<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index()
    {
        $data = Stock::paginate(config('pagination.dashboard.items_per_page'));
        return view('stock.stock',compact('data'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $data = Stock::paginate(config('pagination.dashboard.items_per_page'));
            return view('stock.stock_table', compact('data'))->render();
        }
    }

    function addQuantity($id)
    {
        $data = Stock::find($id);
        return response()->json(['result'=>$data]);
    }

    function addStockQuantity(Request $request,Stock $stock)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'required|not_in:0',
        ],[
            'qty.required' => 'This field is required',
            'qty.not_in' => 'Quantity can not be 0',
        ]);
        $product = Products::find($request->product_id);

        if ($validator->passes()) {
            $qtyLogMessage = $request->remarks;
            
            $id = $stock->id;
            $stock->in_stock += $request->qty;

            if($request->qtyOption == 'add-quantity')
            {
                $product->purchase_qty = $product->purchase_qty+$request->qty;
            }

            //Creating Log
            $product->ProductLog()->create([
                'product_id' => $product->id,
                'remarks'=> $qtyLogMessage,
            ]);
            $stock->save();
            $product->save();
            $result = [$stock,$product];
            return $result;
        }
        return response()->json(['error'=>$validator->errors()]);
    }
}
