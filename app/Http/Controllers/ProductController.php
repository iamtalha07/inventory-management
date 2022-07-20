<?php

namespace App\Http\Controllers;

use Session;
use App\Brand;
use App\Stock;
use App\Product;
use App\ProductLog;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::paginate(config('pagination.dashboard.items_per_page'));
        return view('products.products',compact('data'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $data = Product::paginate(config('pagination.dashboard.items_per_page'));
            return view('products.products_table', compact('data'))->render();
        }
    }

    public function addProduct()
    {
        $brands = Brand::all();
        return view('products.product_add',['brands'=>$brands]);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());

        //Creating Log
        $productLog = new ProductLog;
        $productLog->product_id = $product->id;
        $productLog->remarks = 'Product added successfully. Quantity: '.$product->purchase_qty;
        $productLog->save();

        //Adding product in stock
        $stock = new Stock;
        $stock->product_id = $product->id;
        $stock->sale_qty = 0;
        $stock->in_stock = $request->purchase_qty;
        $stock->save();

        Session::flash('status','Product added successfully!');
        return redirect('products');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if($product){
            return view('products.product_edit',['product'=>$product]);
        }
    }

    public function update(ProductRequest $request,Product $product){
        $product->update($request->all());
        Session::flash('status','Product updated successfully!');
        return redirect('products');
    }

    public function delete(Product $product){
        $product_id = $product->id;
        $product->delete();
        Stock::find($product_id)->delete();
        Session::flash('status','Product deleted successfully');
        return redirect()->back();
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        $product = Product::whereIn('id',$ids)->get();
        Product::whereIn('id',$ids)->delete();
        Stock::whereIn('product_id',$ids)->delete();
        return response()->json($product);
    }

    public function ProductLog($id)
    {
        $product = Product::find($id);
        $data = ProductLog::where('product_id',$id)->get();
        $data = ProductLog::where('product_id',$id)->paginate(config('pagination.product_dashboard.items_per_page'));
        return view('products.product_log',[
            'product'=>$product,
            'data'=>$data,
        ]);
    }

    public function fetch_log_data(Request $request)
    {
        if($request->ajax())
        {
            $data = ProductLog::where('product_id',$request->id)->paginate(config('pagination.product_dashboard.items_per_page'));
            return view('products.product_log_table', compact('data'))->render();
        }
    }
}
