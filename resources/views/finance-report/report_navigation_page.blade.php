@extends('layouts.master_layout.master_layout')
@section('title','Navigation Menu')
@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Report Navigation View</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Navigate to reports</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-12">
            <a href="{{route('view-finances')}}" style="color: inherit;">
              <div class="info-box shadow-none">
                <span class="info-box-icon bg-info"><i class="far fa-copy"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"></span>
                  <span class="info-box-number">Account Finance</span>
                </div>
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box shadow-sm">
              <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Shadows</span>
                <span class="info-box-number">Small</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box shadow">
              <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Shadows</span>
                <span class="info-box-number">Regular</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Shadows</span>
                <span class="info-box-number">Large</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container -->
      
    </div>
</section>

@endsection