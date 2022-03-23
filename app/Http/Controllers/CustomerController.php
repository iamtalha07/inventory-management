<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Session;

class CustomerController extends Controller
{
    function index()
    {
        $data = Customer::all();
        return view('customers.customer',["data"=>$data]);
    }

    function  customerAddForm()
    {
        return view('customers.customer_add');
    }

    function addCustomer(Request $request)
    {
        Customer::create($request->all());
        Session::flash('status','Customer added successfully!');
        return redirect('customer');
    }
}
