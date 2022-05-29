@extends('layouts.master_layout.master_layout')
@section('title','Brands')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Brands</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Brands</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title titleclass">All</h3>
              <div class="card-tools">
                <div class="row">
                <div class="input-group input-group-sm" style="width: 50px;">
                  <a href="{{route('brand')}}" title="Add New Brand" class="btn btn-block btn-success"><i class="fas fa-plus"></i></a>
                </div>&nbsp
                <div class="input-group input-group-sm" style="width: 50px;">
                <button disabled type="button" value="Delete" id="deleteAllSelectedRecords" class="btn btn-danger check" style="width: 100%;"><i class="fas fa-trash-alt"></i></button>
                </div>
                </div>
              </div>
            </div>
            @if($data->count() > 0)
            <div id="table_data">
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th><input type="checkbox" name="Accept" id="chkCheckAll"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody tbody id="leadsTable">
                        @foreach ($data as $item)  
                      <tr>
                        <td><input type="checkbox" name="ids" id="checkboxId" class="checkBoxClass" value=""></td>
                        <td>{{$item->id}}</td>
                        <td>{{$item->brand_title}}</td>
                        <td>{{$item->brand_description}}</td>
                        <td>
                          <form action="" method="post" id="submit-form">
                            @csrf
                            @method('DELETE')
                          <a title ="Edit" href=""><i class="fa fa-edit"></i></a>&nbsp &nbsp
                          <a title ="Log" href=""><i class="fas fa-list"></i></a>&nbsp &nbsp
                          <button title="Delete" type="submit" class="delBtn"  style="color: #007bff;" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i></button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
            </div>
            @else
            <div class="card-body">
                <div class="alert alert-info">
                  No records found.
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  @endsection