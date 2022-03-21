<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

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
}
