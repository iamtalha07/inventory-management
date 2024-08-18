<?php

namespace App\Http\Controllers;

use DB;
use App\Stock;
use App\Booker;
use App\Invoice;
use App\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    function dailySalesReport(Request $request)
    {
        $bookers = Booker::all();
        $start = date('Y-m-d');
        $end = date('Y-m-d');

        if($request->filled('start')){
            $start = $request->start;
        }

        if($request->filled('end')){
            $end = $request->end;
        }

        $data = Invoice::select('invoice_product.product_id as product_id','products.name as name','products.sale_rate as price',DB::raw('SUM(invoice_product.qty) as qty'),DB::raw('SUM(invoice_product.ctn_qty) as ctn_qty'),DB::raw('SUM(invoice_product.amount) as amount'))
        ->groupBy('invoice_product.product_id','products.name','products.sale_rate')
        ->join('invoice_product','invoice.id','=','invoice_product.invoice_id')
        ->join('products',function($join){
            $join->on('products.id','=','invoice_product.product_id');
        })
        ->whereDate('invoice.created_at','>=',$start)
        ->whereDate('invoice.created_at','<=',$end)

        ->get();

        $total = 0;
        foreach($data as $item)
        {
            $total += $item->amount;
        }

        return view('report.sales_report',[
            'data' => $data,
            'bookers' => $bookers,
            'total' => $total,
            'start' => $start,
            'end' => $end
        ]);
    }

    function financialReport(Request $request)
    {
        // dd($request->all());
        $start = date('Y-m-01');  // First day of the current month
        $end = date('Y-m-t');    // Last day of the current month


        if($request->filled('start')){
            $start = $request->start;
        }

        if($request->filled('end')){
            $end = $request->end;
        }

        $totalSales = InvoiceProduct::whereBetween('created_at', [$start, $end])->sum('disc_amount');
        $totalDebit = Invoice::where('status', 'Debit')->whereBetween('created_at', [$start, $end])->sum('net_total');
        $totalCredit = Invoice::where('status', 'Credit')->whereBetween('created_at', [$start, $end])->sum('net_total');
        $stocks = Stock::all();
        $stockWorth = 0;
        foreach ($stocks as $stock) {

            $stockPrice = $stock->in_stock * $stock->product->sale_rate;
            $stockWorth += $stockPrice;
        }

        return view('report.financial_report',[
            'totalSales' => $totalSales,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'stockWorth' => $stockWorth,
            'start' => $start,
            'end' => $end
        ]);
    }

    // function profitReport(Request $request)
    // {
    //     $start = date('Y-m-d');  // First day of the current month
    //     $end = date('Y-m-d');    // Last day of the current month

    //     if($request->filled('start')){
    //         $start = $request->start;
    //     }

    //     if($request->filled('end')){
    //         $end = $request->end;
    //     }

    //     $invoices = Invoice::with(['invoiceProduct'])
    //     ->whereBetween('created_at', [$start, $end])
    //     ->orderBy('created_at', 'desc')
    //     ->get();

    //     foreach ($invoices as $invoice) {
    //         foreach ($invoice->invoiceProduct as $invoiceProduct) {

    //             $purchaseCost = $invoiceProduct->purchase_rate * $invoiceProduct->pivot->qty;
    //             $profit = $invoiceProduct->pivot->amount - $purchaseCost;
    //             $invoiceProduct->profit = $profit;
    //         }
    //     }

    //     return view('report.profit_report', [
    //         'invoices' => $invoices
    //     ]);
    // }

    function profitReport(Request $request)
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        if ($request->filled('start')) {
            $start = Carbon::parse($request->start)->startOfDay();
        }

        if ($request->filled('end')) {
            $end = Carbon::parse($request->end)->endOfDay();
        }

        $invoices = Invoice::with(['invoiceProduct'])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($invoices as $invoice) {
            foreach ($invoice->invoiceProduct as $invoiceProduct) {
                // return $invoiceProduct;
                if($invoiceProduct->pivot->product_type == 'carton')
                {
                    $unitQuantity = $invoiceProduct->pivot->ctn_qty * $invoiceProduct->ctn_size;
                    $amount = $invoiceProduct->pivot->amount ?? $invoiceProduct->pivot->disc_amount;
                    $unitPrice = $amount / $unitQuantity;
                    $quantity = $unitQuantity;

                    $purchaseCost = $invoiceProduct->purchase_rate * $quantity;
                    $profit = $invoiceProduct->pivot->amount - $purchaseCost;
                    $invoiceProduct->profit = $profit;
                    $invoiceProduct->ctn_per_piece_price = $unitPrice;
                }

                // $purchaseCost = $invoiceProduct->purchase_rate * $quantity;
                // $profit = $invoiceProduct->pivot->amount - $purchaseCost;
                // $invoiceProduct->profit = $profit;

                // $purchaseCost = $invoiceProduct->purchase_rate * $invoiceProduct->pivot->qty;
                // $profit = $invoiceProduct->pivot->amount - $purchaseCost;
                // $invoiceProduct->profit = $profit;
            }
        }

        // Calculate total profit across all invoices and products
        // $totalProfit = $invoices->flatMap(function ($invoice) {
        //     return $invoice->invoiceProduct->map(function ($product) {
        //         return $product->pivot->amount - ($product->purchase_rate * $product->pivot->qty);
        //     });
        // })->sum();

        return view('report.profit_report', [
            'invoices' => $invoices,
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d'),
            // 'totalProfit' => $totalProfit, // Pass total profit to the view
        ]);
    }
}
