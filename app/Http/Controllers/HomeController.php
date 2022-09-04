<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use App\Invoice;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all()->count();
        $brands = Brand::all()->count();
        $invoice = Invoice::whereDate('created_at', date('Y-m-d'))->get()->count();
        $invoiceTotal = Invoice::whereDate('created_at', date('Y-m-d'))->get()->sum('total');
        $user = User::all()->count();
        return view('home',[
            'products'=>$products,
            'brands'=>$brands,
            'invoice'=>$invoice,
            'user' => $user,
        ]);
    }
}
