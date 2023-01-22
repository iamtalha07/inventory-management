<?php

namespace App\Http\Controllers;

use DB;
use App\Booker;
use App\Invoice;
use App\Product;
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


        // $data = Invoice::select('invoice_product.product_id as product_id','products.name as name','products.sale_rate as price',DB::raw('SUM(invoice_product.qty) as qty'),DB::raw('SUM(invoice_product.ctn_qty) as ctn_qty'),DB::raw('SUM(invoice_product.amount) as amount'))
        // ->groupBy('invoice_product.product_id','products.name','products.sale_rate')
        // ->join('invoice_product','invoice.id','=','invoice_product.invoice_id')
        // ->join('products',function($join){
        //     $join->on('products.id','=','invoice_product.product_id'); 
        // })
        // ->whereDate('invoice.created_at','>=',$start)
        // ->whereDate('invoice.created_at','<=',$end)
        // // ->where('booker_id',2)
        // ->get();

       
        $sales = Invoice::join('invoice_product','invoice.id','=','invoice_product.invoice_id')
        ->whereIn('booker_id', [1,2])
        ->whereIn('invoice_product.product_id', [1, 2, 3])
        ->whereDate('invoice.created_at','>=',$start)
        ->whereDate('invoice.created_at','<=',$end)
        ->get();

        // $sales = Invoice::select(DB::raw('SUM(invoice_product.qty) as qty'))->join('invoice_product','invoice.id','=','invoice_product.invoice_id')
        // ->groupBy('invoice_product.product_id','booker_id')
        // ->whereIn('booker_id', [1,2])
        // ->whereIn('invoice_product.product_id', [1, 2, 3])
        // ->whereDate('invoice.created_at','>=',$start)
        // ->whereDate('invoice.created_at','<=',$end)
        // ->get();

        $sales = Invoice::select('booker_id','invoice_product.product_id',DB::raw('SUM(invoice_product.qty) as qty'))
        ->groupBy('invoice_product.product_id','booker_id')
        ->join('invoice_product','invoice.id','=','invoice_product.invoice_id')
        ->whereIn('booker_id', [1,2])
        ->whereIn('invoice_product.product_id', [1, 2, 3])
        ->whereDate('invoice.created_at','>=',$start)
        ->whereDate('invoice.created_at','<=',$end)
        ->get();

        // $sales = Invoice::with('saveProduct')->join('invoice_product','invoice.id','=','invoice_product.invoice_id')
        // ->whereIn('booker_id', [1,2])
        // ->whereIn('invoice_product.product_id', [1, 2, 3])
        // ->whereDate('invoice.created_at','>=',$start)
        // ->whereDate('invoice.created_at','<=',$end)
        // ->get();
            // dd($sales);
            // dd($sales->toArray());

            $pivotData = [];
            // $headers = ['Products'];
            $headers = [];
            $bookers = Booker::select('id')->get();

            $bookerId = [];
            foreach($bookers as $booker) {
                $bookerId[$booker->id] = $booker->id;
            }

// dd($sales->toArray());
            foreach($sales as $key => $sale) {
                // dd(gettype($sale));
                if(!isset($pivotData[$sale->product_id])) {
                    $pivotData[$sale->product_id] = array();
                    // $pivotData[$sale->product_id]['product_id'] = $sale->product_id;
                }
                    $pivotData[$sale->product_id][$sale->booker_id] = $sale->qty;

                    // if(count(array_intersect_key(array_flip($sale->toArray()), $bookerId)) === count($sale->toArray())) {
                    //     $pivotData[$sale->product_id][$sale->booker_id] = $sale->qty;
                    // } else {
                    //     $pivotData[$sale->product_id][$sale->booker_id] = 0;
                    // }

                if(!in_array($sale->booker_id, $headers)) {
                    $headers[] = $sale->booker_id;
                }
            }
            dd($pivotData,$headers);

            // echo join($headers, '  ');
            echo '<br>';
            foreach($pivotData as $data) {
                foreach($headers as $header) {
                    echo $data[$header] . '  ';
                }
                echo '<br>';
            }
dd('end');

        $sales->transform(function($order) {
            $itemsArray = [];
            dd($order->saveProduct->groupBy('product_id'));
            $order['items'] = $order->saveProduct->groupBy('product_id')->map(function ($item) use ($itemsArray){
                array_push($itemsArray, [
                    'product_id' => $item[0]['product_id'], 
                    'qty' => $item->sum('qty'),
                    // 'price' => $item->sum('price')
                ]);
                return $itemsArray[0];
            })->values();
            return $order;
        });


            dd($sales[0]->saveProduct[0]->product_id);



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
