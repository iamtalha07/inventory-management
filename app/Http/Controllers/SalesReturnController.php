<?php

namespace App\Http\Controllers;

use Session;
use App\Stock;
use App\Invoice;
use App\SalesReturn;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\Vue;

class SalesReturnController extends Controller
{
    public function index()
    {
        return view('sales-return.salesreturn');
    }

    public function searchInvoiceById(Request $request)
    {
        $invoice = Invoice::find($request->invoiceId);

        if(!$invoice)
        {
            Session::flash('status','Invoice does not exist');
            return redirect()->back();
        }

        return view('sales-return.salesreturnform', ['invoice' => $invoice]);
    }

    public function returnSales(Request $request)
    {
        foreach($request->product_id as $key => $product_id)
        {
            $salesReturn = new SalesReturn;
            $stock = Stock::where('product_id',$request->product_id[$key])->first();

            $salesReturn->invoice_id = $request->invoice_id;
            $salesReturn->product_id = $request->product_id[$key];
            $salesReturn->quantity_returned = $request->type[$key] == "single" ? $request->quantity_returned[$key] : $request->quantity_returned[$key] * $stock->product->ctn_size;
            $salesReturn->reason = $request->reason;
            $salesReturn->return_date = now();
            $salesReturn->save();

            if($request->type[$key] == "single")
            {
                $returnedQuantity = $request->quantity_returned[$key];
            } else {
                $returnedQuantity = $request->quantity_returned[$key] * $stock->product->ctn_size;
                $stock->decrement('ctn_sale_qty', $request->quantity_returned[$key]);
            }

            $stock->increment('in_stock',  $returnedQuantity);
            $stock->decrement('sale_qty', $returnedQuantity);
            $updateCtnInStock = $stock->in_stock / $stock->product->ctn_size;
            $stock->ctn_in_stock = floor($updateCtnInStock);

            $stock->save();
        }
        return redirect()->back();
    }

    public function salesReturnList()
    {
        // $invoices = Invoice::all();
        $invoices = Invoice::has('invoiceReturnProduct')->get();
        // dd($invoices[0]->invoiceReturnProduct);

        return view('sales-return.sales-return-listing');
    }
}
