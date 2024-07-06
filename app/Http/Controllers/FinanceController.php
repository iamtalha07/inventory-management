<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use App\Brand;
use App\Category;
use App\BillRecords;
use App\BrandBalance;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LedgerRequest;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected $billRecords;

public function __construct(BillRecords $billRecords)
{
    $this->billRecords = $billRecords;
}

public function index() {
    return view('finance-report.report_navigation_page');
}


public function filteredInvoicing(Request $request)
{
    $values       = array();
    $brands       = Brand::all();
    $brand_id     = $request->brand;
    $bill_records = BillRecords::where('brand_id', $brand_id)->get();
   
    // $values['total_billed']        = $bill_records->sum('billed_amount');
    $total_billed          =  $bill_records->sum('billed_amount');
    $total_paid            =  $bill_records->sum('amount_paid');

    $values = [
        'total_billed'          =>  $total_billed,
        'total_paid'            =>  $total_paid,
        'outstanding_balance'   =>  $total_billed - $total_paid,
    ];

    $balanceExists = BrandBalance::where('balance', '>', 0)->where('brand_id', $brand_id)->exists();
    return view('finance-report.company_finance', compact('bill_records', 'brands', 'values', 'balanceExists', 'brand_id'));

}

public function viewPage() {
    $bill_records = $this->billRecords->all();
    $brands = Brand::all();

    $total_billed          = $bill_records->sum('billed_amount');
    $total_paid            = $bill_records->sum('amount_paid');
    $overall_balance       = BrandBalance::sum('balance');

    $values = [
        'total_billed'          =>  $total_billed,
        'total_paid'            =>  $total_paid,
        'outstanding_balance'   =>  $overall_balance,
    ];

    $total_balance = BrandBalance::sum('balance');
    $balanceExists = $total_balance !== null && $total_balance > 0;
    dd($balanceExists);

    return view('finance-report.company_finance', compact('bill_records', 'brands', 'values', 'balanceExists'));
}

public function getCategoriesByBrand($id)
{
    $categories = Category::where('brand_id', $id)->get();
    return response()->json($categories);
}

public function addFinanceView()
{
    $brands     = Brand::all();
    $categories = Category::all();
    return view('finance-report.add_company_finance', compact('brands', 'categories'));
}


public function editLedger(BillRecords $account)
{
    $brands = Brand::all();
    // dd($account);
    return view('finance-report.edit_ledger', ['account' => $account, 'brands' => $brands]);
}

public function saveLedger(LedgerRequest $request) 
{
    DB::beginTransaction();
    try {
        $data = $request->validated();

        // Convert date format from 'DD-MM-YYYY' to 'YYYY-MM-DD'
        $bill_date    = Carbon::createFromFormat('d-m-Y', $request->bill_date)->format('Y-m-d');
        $payment_date = Carbon::createFromFormat('d-m-Y', $request->payment_date)->format('Y-m-d');

        $billed_amount = $request->billed_amount;
        $amount_paid   = $request->amount_paid;
        $adjusted_current_bill = $billed_amount - $amount_paid;
      
        // Save the ledger record
        $ledger = BillRecords::create([
            'brand_id'        => $request->brand_id,
            'category_id'     => $request->category_id,
            'bill_no'         => $request->bill_no,
            'description'     => $request->description,
            'billed_date'     => $bill_date,
            'billed_amount'   => $billed_amount,
            'amount_paid'     => $amount_paid,
            'adjusted_amount' => $adjusted_current_bill,
            'payment_date'    => $payment_date,
            'remarks'         => $request->remarks,
            'generated_user'  => Auth::user()->name,
        ]);

        // Upsert the adjusted balance into the BrandBalance table
         BrandBalance::updateOrCreate(
            ['brand_id' => $data['brand_id']],
            [
            'last_paid_bill_no'  => $request->bill_no, 
            'balance' => DB::raw('balance + ' . $adjusted_current_bill)
            ]
        );
      
        DB::commit();
  
        Session::flash('success', 'Record Saved Successfully');
        return redirect()->route('view-finances');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e);
        
        Session::flash('error', 'Failed to save the record. Please try again.');
        return redirect()->back();
    }
}

public function updateLedger(Request $request, BillRecords $account)
{
    DB::beginTransaction();
    try {
        // Convert date format from 'DD-MM-YYYY' to 'YYYY-MM-DD'
        $bill_date    = Carbon::createFromFormat('d-m-Y', $request->bill_date)->format('Y-m-d');
        $payment_date = Carbon::createFromFormat('d-m-Y', $request->payment_date)->format('Y-m-d');
        
        $billed_amount = $request->billed_amount;
        $amount_paid   = $request->amount_paid;
        $adjusted_current_bill = $billed_amount - $amount_paid;

        $db_update = $account->adjusted_amount - $adjusted_current_bill;
        //Update the ledger record.
        $updateRecord = $account->update([
            'brand_id'          => $request->brand_id,
            'category_id'       => $request->category_id,
            'bill_no'           => $request->bill_no,
            'description'       => $request->description,
            'billed_date'       => $bill_date,
            'billed_amount'     => $billed_amount,
            'amount_paid'       => $amount_paid,
            'adjusted_amount'   => $adjusted_current_bill,
            'payment_date'      => $payment_date,
            'remarks'           => $request->remarks,
        ]);

        // Upsert the adjusted balance into the BrandBalance table
        BrandBalance::updateOrCreate(
            ['brand_id' => $request->brand_id],
            [
            'last_paid_bill_no'  => $request->bill_no, 
            'balance' => DB::raw('balance - ' . $db_update)
            // 'balance' => DB::raw('balance + ' . '-' . $account->adjusted_amount - $adjusted_current_bill)
            ]
        );

        DB::commit();

            Session::flash('success', 'Record Updated Successfully');
            return redirect()->route('view-finances');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e);
        
        Session::flash('error', 'Failed to update the record. Please try again.');
        return redirect()->back();
    }
}

public function getBillDetails($id)
{
    $billrecord = BillRecords::where('id', $id)->first();

    if(!$billrecord) {
        Session::flash('error', 'Bill not found');
        return redirect()->back();
    }
    // Session::flash('success', 'Record Fetched Successfully');
    return view('finance-report.view_bill_details', ['billrecord'  =>  $billrecord]);
}


public function delete(BillRecords $record)
{
    $record->delete();
    
    Session::flash('success','Record Deleted Successfully');
    return redirect()->back();
}

// Function for Ajax Deletion with SweetAlert2
public function destroy(BillRecords $account)
{
    try {
        $account->delete();
        
        Session::flash('success', 'Record Deleted Successfully');

        return response()->json([
            'message' => 'Record deleted successfully'
        ], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete record.'], 500);
    }
}
}


