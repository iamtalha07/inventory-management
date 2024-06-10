@extends('layouts.master_layout.master_layout')
@section('title','Home')
@section('content')
<style>

</style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Rs. {{number_format($stock)}}</h3>

                <p>Stock Worth</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('products')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Rs. {{number_format($totalSold)}}</h3>

                <p>Today's Sale</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-invoice"></i>
              </div>
              <a href="{{route('invoice/invoice-search')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Rs. {{number_format($totalDebit)}}</h3>

                <p>Today's Total Debit</p>
              </div>
              <div class="icon">
                <i class="fas fa-star"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rs. {{number_format($totalCredit)}}</h3>

                <p>Today's Total Credit</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <a href="{{route('user')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        {{-- <h5 class="mb-2">Info Box With Custom Shadows <small><i>Using Bootstrap's Shadow Utility</i></small></h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="{{route('view-finances')}}" style="text-decoration: none; color: inherit;">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
              <div class="info-box-content">
        
                <span class="info-box-number">Manage Finance</span>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div> --}}

        <!-- Application buttons -->
        <div class="row">
        <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Quick Navigation</h3>
          </div>
          <div class="card-body">
            <a href="{{route('view-all-reports')}}" class="btn btn-app">
              <span class="badge bg-teal">new feature</span>
              <i class="fas fa-inbox"></i> Account Reports
            </a>
            <a class="btn btn-app">
              <span class="badge bg-purple">upcoming feature</span>
              <i class="fas fa-users"></i> Users
            </a>
            <a class="btn btn-app">
              <span class="badge bg-purple">upcoming feature</span>
              <i class="fas fa-barcode"></i> Products
            </a>
            <a class="btn btn-app">
              <span class="badge bg-purple">upcoming feature</span>
              <i class="fas fa-inbox"></i> Orders
            </a>
      
        
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->


@endsection
