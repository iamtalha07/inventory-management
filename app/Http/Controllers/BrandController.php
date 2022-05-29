<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
class BrandController extends Controller
{
    function index()
    {
        $data = Brand::all();
        return view('brands.brand', ['data' => $data]);
    }
}
