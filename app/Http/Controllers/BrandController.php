<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Session;
class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::all();
        return view('brands.brand',["data"=>$data]);
    }

    public function addBrand()
    {
        
    }
}
