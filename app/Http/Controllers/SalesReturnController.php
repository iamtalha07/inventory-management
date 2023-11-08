<?php

namespace App\Http\Controllers;

use Session;
use App\Stock;
use App\Invoice;
use App\InvoiceProduct;
use App\Product;
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

        if (!$invoice) {
            Session::flash('status', 'Invoice does not exist');
            return redirect()->back();
        }

        return view('sales-return.salesreturnform', ['invoice' => $invoice]);
    }

    public function returnSales(Request $request)
    {
        foreach ($request->product_id as $key => $product_id) {

            $invoiceProduct = InvoiceProduct::where('invoice_id', $request->invoice_id)->where('product_id', $request->product_id[$key])->first();

            $salesReturn = new SalesReturn;
            $stock = Stock::where('product_id', $request->product_id[$key])->first();

            $salesReturn->invoice_id = $request->invoice_id;
            $salesReturn->product_id = $request->product_id[$key];
            $salesReturn->quantity_returned = $request->type[$key] == "single" ? $request->quantity_returned[$key] : $request->quantity_returned[$key] * $stock->product->ctn_size;
            $salesReturn->reason = $request->reason;
            $salesReturn->return_date = now();
            $salesReturn->save();

            if ($request->type[$key] == "single") {
                $returnedQuantity = $request->quantity_returned[$key];

                $invoiceProduct->decrement('qty', $request->quantity_returned[$key]);
                $product = Product::find($request->product_id[$key]);
                $productPrice = $product->sale_rate;
                $updatedQty = $invoiceProduct->qty;
                $updatedPrice = $updatedQty * $productPrice;

                $invoiceProduct->amount = $updatedPrice;

                if ($invoiceProduct->disc_by_cash) {
                    $invoiceProduct->disc_amount = $updatedPrice - $invoiceProduct->disc_by_cash;
                } elseif ($invoiceProduct->disc_by_percentage) {
                    $discount = ($invoiceProduct->disc_by_percentage / 100) * $updatedPrice;
                    $invoiceProduct->disc_amount =  $updatedPrice - $discount;
                } else {
                    $invoiceProduct->disc_amount = $updatedPrice;
                }

                $invoiceProduct->save();
            } else {
                $returnedQuantity = $request->quantity_returned[$key] * $stock->product->ctn_size;
                $stock->decrement('ctn_sale_qty', $request->quantity_returned[$key]);

                $invoiceProduct->decrement('ctn_qty', $request->quantity_returned[$key]);
                $product = Product::find($request->product_id[$key]);
                $productPrice = $product->ctn_sale_rate;
                $updatedQty = $invoiceProduct->ctn_qty;
                $updatedPrice = $updatedQty * $productPrice;
                $invoiceProduct->amount = $updatedPrice;

                if ($invoiceProduct->disc_by_cash) {
                    $invoiceProduct->disc_amount = $updatedPrice - $invoiceProduct->disc_by_cash;
                } elseif ($invoiceProduct->disc_by_percentage) {
                    $discount = ($invoiceProduct->disc_by_percentage / 100) * $updatedPrice;
                    $invoiceProduct->disc_amount =  $updatedPrice - $discount;
                } else {
                    $invoiceProduct->disc_amount = $updatedPrice;
                }

                $invoiceProduct->save();
            }

            $stock->increment('in_stock',  $returnedQuantity);
            $stock->decrement('sale_qty', $returnedQuantity);
            $updateCtnInStock = $stock->in_stock / $stock->product->ctn_size;
            $stock->ctn_in_stock = floor($updateCtnInStock);

            $stock->save();
        }
        $totalInvoicePrice = InvoiceProduct::where('invoice_id', $request->invoice_id)->sum('disc_amount');
        $invoice = Invoice::find($request->invoice_id);
        $invoice->total = $totalInvoicePrice;
        if ($invoice->less_trade_offer) {
            $invoice->net_total = $totalInvoicePrice - $invoice->less_trade_offer;
        } elseif ($invoice->less_percentage_discount) {
            $discount = ($invoice->less_percentage_discount / 100) * $totalInvoicePrice;
            $invoice->net_total =  $totalInvoicePrice - $discount;
        }
        $invoice->save();

        return redirect()->back();
    }

    public function salesReturnList()
    {
        // $invoices = Invoice::all();

        // dd($invoices[0]->invoiceReturnProduct);

        $data = Invoice::has('invoiceReturnProduct')->paginate(5);

        // $data = SalesReturn::paginate(config('pagination.dashboard.items_per_page'));
        // dd($data[2]->invoiceProduct);
        return view('sales-return.sales-return-listing', compact('data'));

        // return view('sales-return.sales-return-listing');
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            // $data = SalesReturn::paginate(config('pagination.dashboard.items_per_page'));
            $data = Invoice::has('invoiceReturnProduct')->paginate(5);
            return view('sales-return.sales-return-listing-table', compact('data'))->render();
        }
    }
}
