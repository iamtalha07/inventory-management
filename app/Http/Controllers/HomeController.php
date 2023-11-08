<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use App\Stock;
use App\Invoice;
use App\InvoiceProduct;
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
        $stocks = Stock::all();
        $stockWorth = 0;
        foreach ($stocks as $stock) {

            $stockPrice = $stock->in_stock * $stock->product->sale_rate;
            $stockWorth += $stockPrice;
        }

        $soldProduct = InvoiceProduct::all()->sum('disc_amount');
        $totalDebit = Invoice::where('status', 'Debit')->sum('net_total');
        $totalCredit = Invoice::where('status', 'Credit')->sum('net_total');

      



        $products = Product::all()->count();
        $brands = Brand::all()->count();
        $invoice = Invoice::whereDate('created_at', date('Y-m-d'))->get()->count();
        $invoiceTotal = Invoice::whereDate('created_at', date('Y-m-d'))->get()->sum('total');
        $user = User::all()->count();
        return view('home', [
            'products' => $products,
            'brands' => $brands,
            'invoice' => $invoice,
            'user' => $user,
            'stock' => $stockWorth,
            'totalSold' => $soldProduct,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit
        ]);
    }
}
