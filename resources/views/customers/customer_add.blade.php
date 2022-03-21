@extends('layouts.master_layout.master_layout')
@section('title','Add Customer')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Add New Customer</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Add new Customer</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <form method="POST" action="">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Add new Customer</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="roles">Customer Name:</label>
                      <div class="input-group">
                        <input type="text" name="name"  value="{{old('name')}}" class="form-control">
                      </div>
                      @error('name')
                      <p style="color:red">{{$message}}</p>
                      @enderror
                    </div>
              </div>
    
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                      
                        <label>Phone Number:</label>
                        <input type="text" name="phone_no" value="{{old('phone_no')}}" class="form-control">
                        @error('phone_no')
                        <p style="color:red">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="roles">Area Name:</label>
                        <input type="text" name="area_name" value="{{old('area_name')}}" class="form-control">
                        @error('area_name')
                        <p style="color:red">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
            <div class="card-footer">
                <div class="row">
                <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
                </div>
                </div>
            </div>
       
    </div>
    </form>
</div>
</section>

@endsection