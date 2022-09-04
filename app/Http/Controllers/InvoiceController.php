<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Stock;
use Validator;
use App\Booker;
use App\Invoice;
use App\Product;
use Carbon\Carbon;
use App\ProductLog;
use App\InvoiceProduct;
use App\PaymentHistory;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\PaymentRequest;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = Invoice::paginate(config('pagination.dashboard.items_per_page'));
        return view('invoices.invoice',compact('data'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $data = Invoice::paginate(config('pagination.dashboard.items_per_page'));
            return view('invoices.invoice_table', compact('data'))->render();
        }
    }

    public function createInvoiceForm()
    {
        $products = Product::all();
        $currentDate = date("d-m-Y");
        $bookers = Booker::all();
        return view('invoices.create-invoice',['products'=>$products,'bookers'=>$bookers,'currentDate'=>$currentDate]);
    }

    public function getProductData($id)
    {
        $product = Product::find($id);
        $stock = $product->Stock;
        $result = [$product,$stock];
        return $result;
    }

    public function createInvoice(InvoiceRequest $request)
    {   
        if($request->discountRadio == 'cashDiscount'){
            $discountValue = $request->cash;
        }
        else if($request->discountRadio == 'perDiscount'){
            $percentage = $request->percentage;
            $total = $request->total;
            $discountValue =  ($total * $percentage)/100;
        }
        else{
            $discountValue = null;
        }

        $invoice = new Invoice;
        $invoice->customer_name = $request->customer_name;
        $invoice->booker_id =  $request->booker_id;
        $invoice->salesman_name = $request->salesman_name;
        $invoice->area_name = $request->area_name;
        $invoice->status = $request->status;
        $invoice->total = $request->total;
        $invoice->discount = $discountValue;
        $invoice->discount_total = $request->discountTotal;
        $invoice->save();

        foreach ($request->product_id as $key => $product_id){
            $productInvoice = new InvoiceProduct;
            $productInvoice->invoice_id = $invoice->id;
            $productInvoice->product_id = $request->product_id[$key];
            $productInvoice->qty = $request->qty[$key];
            $productInvoice->ctn_qty = $request->ctnQty[$key];
            $productInvoice->disc_by_cash = $request->dis[$key];
            $productInvoice->disc_by_percentage = $request->disByPer[$key];
            $productInvoice->amount = $request->amount[$key];
            $productInvoice->disc_amount = $request->disAmount[$key];
            $productInvoice->product_type = $request->qty[$key] ? 'single' : 'carton';
            $productData[] = $productInvoice;

            //Updating products stock
            $productStock = Stock::where('product_id',$request->product_id[$key])->first();
            
            if($request->qty[$key]) {
                $updatedQuantity = $request->stock[$key] - $request->qty[$key];
                $updateSaleQty = $request->qty[$key];
            }
            else {
                $purchasedCtnQuantity = $request->ctnQty[$key] * $request->packSize[$key];
                $updatedQuantity = $request->stock[$key] - $purchasedCtnQuantity;
                $updateSaleQty = $purchasedCtnQuantity;
            }

            $productStock->in_stock = $updatedQuantity;
            $sale_qty = $productStock->sale_qty;
            $sale_qty = $sale_qty + $updateSaleQty;
            $productStock->sale_qty = $sale_qty;

            $ctn_sale_qty = $productStock->ctn_sale_qty + $request->ctnQty[$key];
            $productStock->ctn_sale_qty = $ctn_sale_qty;
            $updateCtnInStock = $productStock->in_stock/$request->packSize[$key];
            $productStock->ctn_in_stock = floor($updateCtnInStock);
            $productStock->save();

            //Creating Log
            $productLog = new ProductLog;
            $productLog->product_id = $request->product_id[$key];
            $productLog->date = null;
            $productLog->remarks = $updateSaleQty.' of this product has been sold. New Quantity: '.$updatedQuantity;
            $productLog->save();
         }
        $invoice->saveProduct()->saveMany($productData);

        return redirect()->route('invoice/detail',$invoice->id);
    }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('status','Invoice deleted successfully');
        return redirect()->back();
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        $invoice = Invoice::whereIn('id',$ids)->get();
        Invoice::whereIn('id',$ids)->delete();
        return response()->json($invoice);
    }

    public function detail($id)
    {
        $invoice = Invoice::find($id);
        $discountAmount = 0;

        foreach($invoice->invoiceProduct as $item) {
            $discountAmount += $item->pivot->amount - $item->pivot->disc_amount;
        }

        return view('invoices.invoice_detail',['invoice'=>$invoice, 'discountAmount' => $discountAmount]);
    }

    public function InvoicePrint($id)
    {
        $invoice = Invoice::find($id);
        return view('pdf.pdf_invoice',['invoice'=>$invoice]);
    }

    public function summaryList()
    {
        $data = Invoice::whereDate('created_at', date('Y-m-d'))->get();
        $bookers = Booker::all();
        return view('invoices.invoice_summary',['data'=>$data,'bookers'=>$bookers]);
    }

    public function searchInvoice(Request $request)
    {  
        $start = $request->start? $request->start:date('Y-m-d');
        $end =  $request->end? $request->end:date('Y-m-d');
        $bookers = Booker::all();
        $invoice = Invoice::query();

        if($request->filled('booker')){
            $invoice->whereIn('booker_id',$request->booker);
        }
        else{
            $invoice->where('booker_id','!=',null);
        }

        if($request->filled('status')){
            $invoice->where('status',$request->status);
        }
        else{
            $invoice->where('status','!=',null);
        }

        if($request->filled('discountOption')){
            $invoice->whereNotNull('discount');
        }

        $invoice->whereDate('created_at','>=', $start)
                ->whereDate('created_at','<=',$end);

        $test = $invoice->get();
        $totalDebit = $test->where('status','Debit')->sum('total');
        $totalCredit = $test->where('status','Credit')->sum('total');
        $totalDiscount = $test->where('discount','!=',null)->sum('discount');
        $GrossTotal = $test->sum('total');

        return view('invoices.invoice_summary',[
            'data'=>$invoice->get(),
            'bookers'=>$bookers,
            'totalDebit'=>$totalDebit,
            'totalCredit'=>$totalCredit,
            'totalDiscount'=>$totalDiscount,
            'GrossTotal'=>$GrossTotal,
            'start'=>$start,
            'end'=>$end,
        ]);
    } 

    public function changeStatus(Invoice $invoice, Request $request)
    {
        if($invoice->status=='Credit')
        {
            $invoice->update(['status'=>'Debit']);
        }
        else
        {
            $invoice->update(['status'=>'Credit']);
        }
        
        $invoiceData = Invoice::whereDate('created_at','>=', $request->startDate)
        ->whereDate('created_at','<=',$request->endDate)->get();
        $totalDebit = $invoiceData->where('status','Debit')->sum('total');
        $totalCredit = $invoiceData->where('status','Credit')->sum('total');
        return response()->json(['invoice'=>$invoice, 'totalDebit'=> $totalDebit, 'totalCredit'=>$totalCredit]);

    }

    public function paymentHistory(Invoice $invoice)
    {
        $paymentHistory = PaymentHistory::where('invoice_id',$invoice->id)->orderBy('date','ASC')->get();
        return view('invoices.invoice_payment_history',[
            'invoice'=>$invoice,
            'paymentHistory'=>$paymentHistory
        ]);
    }

    public function addPaymentHistory(PaymentRequest $request)
    {
        $paymentHistory = new PaymentHistory;
        $paymentHistory->invoice_id =  $request->invoice_id;
        $paymentHistory->date = Carbon::parse($request->date);
        $paymentHistory->paid_amount = $request->paid_amount;
        $paymentHistory->remarks = $request->remarks;
        $paymentHistory->save();

        Session::flash('status','Record added successfully!');
        return redirect()->back();
    }

    public function deletePaymentHistory(PaymentHistory $paymentHistory)
    {
        $paymentHistory->delete();
        Session::flash('status','Record deleted successfully');
        return redirect()->back();
    }

    function editPaymentHistoryForm($id)
    {
        $data = PaymentHistory::find($id);
        return response()->json($data);
    }

    function updatePaymentHistory(Request $request)
    {
        $paymentHistory = PaymentHistory::find($request->invoice_id);
        $paymentHistory->date = Carbon::parse($request->date);
        $paymentHistory->paid_amount = $request->paid_amount;
        $paymentHistory->remarks = $request->remarks;
        $paymentHistory->save();

        Session::flash('status','Record updated successfully');
        return redirect()->back();
    }
    
}
