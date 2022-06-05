<?php

namespace App\Http\Controllers;

use Session;
use App\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;

class BrandsController extends Controller
{
    function index() {
        $brands = Brand::all();
        return view('brands.brands',['brands'=>$brands]);
    }

    function addBrand() {
        return view('brands.brand_add');
    }

    function store(BrandRequest $request) {
        $brand = Brand::create($request->all());
        Session::flash('status','Brand Added Successfully!');
        return redirect('brands');
    }

    function edit(Brand $brand) {
        return view('brands.brand_edit',['brand'=>$brand]);
    }

    public function update(BrandRequest $request, Brand $brand){
        $brand->update($request->all());
        Session::flash('status','Brand updated successfully!');
        return redirect('brands');
    }

    public function delete(Brand $brand){
        $brand->delete();
        Session::flash('status','Brand Deleted Successfully');
        return redirect()->back();
    }
}
