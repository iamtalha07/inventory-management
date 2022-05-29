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

    //Add a Customer
    function addCustomer(Request $request)
    {
        Customer::create($request->all());
        Session::flash('status','Customer added successfully!');
        return redirect('customer');
    }

    //Delete a Customer
    function deleteCustomer(Customer $customer)
    {
        $customer->delete();
        Session::flash('status','Customer deleted successfully');
        return redirect('customer');
    }

    function editCustomer(Customer $customer)
    {
        return view('customers.customer_edit',['customer'=>$customer]);
    }

    public function update(Request $request,Customer $customer)
    {
        $customer->update($request->all());
        Session::flash('status','Customer updated successfully!');
        return redirect('customer');
    }
}
