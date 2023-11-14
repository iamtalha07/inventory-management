<?php

namespace App\Http\Controllers;

use DB;
use App\Stock;
use App\Booker;
use App\Invoice;
use App\InvoiceProduct;
use Illuminate\Http\Request;

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
        // ->where('booker_id',2)
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
}
