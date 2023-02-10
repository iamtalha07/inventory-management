<?php

namespace App\Http\Controllers;

use Session;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    function index()
    {
        $categories = Category::all();
        return view('category.category', ['categories' => $categories]);
    }

    function create()
    {
        return view('category.category_add');
    }

    function store(CategoryRequest $request)
    {
        Category::create($request->all());
        Session::flash('status','Category Added Successfully!');
        return redirect('category/view-category');
    }

    function edit(Category $category) {
        return view('category.category_edit',['category'=>$category]);
    }

    public function update(CategoryRequest $request, Category $category){
        $category->update($request->all());
        Session::flash('status','Category updated successfully!');
        return redirect('category/view-category');
    }

    public function delete(Category $category){
        $category->delete();
        Session::flash('status','Category Deleted Successfully');
        return redirect()->back();
    }
}