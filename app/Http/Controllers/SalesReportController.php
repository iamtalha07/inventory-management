<?php

namespace App\Http\Controllers;

use DB;
use App\Booker;
use App\Invoice;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    function index(Request $request)
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

        return view('sales-report.sales_report',[
            'data' => $data,
            'bookers' => $bookers,
            'total' => $total,
            'start' => $start,
            'end' => $end
        ]);
    }
}
