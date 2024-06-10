<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Brand;
use App\AccountFinance;
use App\Http\Requests\LedgerRequest;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected $accountFinance;

public function __construct(AccountFinance $accountFinance)
{
    $this->accountFinance = $accountFinance;
}

public function index() {
    return view('finance-report.report_navigation_page');
}

public function viewFina() {
    $accounts = $this->accountFinance->all();

    return view('finance-report.company_finance', compact('accounts'));
}

public function addFinanceView()
{
    $brands = Brand::all();
    return view('finance-report.add_company_finance', compact('brands'));
}

public function saveLedger(LedgerRequest $request) 
{
    try {
        $data = $request->validated();

        // Convert date format from 'DD-MM-YYYY' to 'YYYY-MM-DD'
        $request->bill_date = Carbon::createFromFormat('d-m-Y', $request->bill_date)->format('Y-m-d');

        $ledger = AccountFinance::create([
            'brand_id'          => $request->brand_id,
            'bill_no'           => $request->bill_no,
            'product_name'      => $request->products,
            'bill_date'         => $request->bill_date,
            'total_amount'      => $request->total_amount,
            'amount_paid'       => $request->amount_paid,
            'amount_remaining'  => $request->amount_remaining,
            'payable_by'        => $request->payable_by,
            'payable_to'        => $request->payable_to,
            'remarks'           => $request->remarks,
        ]);

        Session::flash('success', 'Ledger Saved Successfully');
        return redirect()->route('view-finances');

    } catch (\Exception $e) {
        \Log::error($e);
        
        Session::flash('error', 'Failed to save the ledger. Please try again.');
        return redirect()->back();
    }
}

public function editLedger(AccountFinance $account)
{
    $brands = Brand::all();
    return view('finance-report.edit_ledger', ['account' => $account, 'brands' => $brands]);
}

public function updateLedger(Request $request, AccountFinance $account)
{
    try {

        // Convert date format from 'DD-MM-YYYY' to 'YYYY-MM-DD'
        $request->bill_date = Carbon::createFromFormat('d-m-Y', $request->bill_date)->format('Y-m-d');
        
        $updateRecord = $account->update([
            'brand_id'          => $request->brand_id,
            'bill_no'           => $request->bill_no,
            'product_name'      => $request->products,
            'bill_date'         => $request->bill_date,
            'total_amount'      => $request->total_amount,
            'amount_paid'       => $request->amount_paid,
            'amount_remaining'  => $request->amount_remaining,
            'payable_by'        => $request->payable_by,
            'payable_to'        => $request->payable_to,
            'remarks'           => $request->remarks,
        ]);

        Session::flash('success', 'Ledger Record Updated Successfully');
        return redirect()->route('view-finances');

        // Return a success response or perform any other actions upon successful update
    } catch (\Exception $e) {
        \Log::error($e);
        
        Session::flash('error', 'Failed to save the ledger. Please try again.');
        return redirect()->back();
    }
}


public function delete(AccountFinance $account)
{
    $account->delete();
    
    Session::flash('success','Ledger Record Deleted Successfully');
    return redirect()->back();
}


}


