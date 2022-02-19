@extends('layouts.master_layout.master_layout')
@section('title','Products')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Product Log</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Product Log</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Product Detail Section -->
<div class="container-fluid">
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- Main content -->
              <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-info-circle"></i> Product Detail
                      <a href="{{route('product/edit-product',$product->id)}}" class="btn btn-block btn-success float-right" style="width: 50px;" title="Edit"><i class="fas fa-edit"></i></a>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <br>
                <!-- info row -->
                <div class="row">
                  <div class="col-sm-6">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <b>Product Id:</b>
                        <a class="float-right" id="product_id">{{$product->id}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Product Name:</b>
                        <a class="float-right">{{$product->name}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Purchase Quantity:</b>
                        <a class="float-right">{{$product->purchase_qty}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Purchase Rate:</b>
                        <a class="float-right">Rs.{{$product->purchase_rate}}</a>
                      </li>
                    </ul>
                  </div>

                  <!-- /.col -->
                  <div class="col-sm-6">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <b>Date:</b>
                        <a class="float-right">{{$product->date}}</a>
                      </li>
                      <li class="list-group-item">
                        <div style="display: inline;">
                        <b>In Stock:</b>
                        <a class="float-right">{{$product->Stock->in_stock}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Sale Quantity:</b>
                        <a class="float-right">{{$product->Stock->sale_qty}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Sale Rate:</b>
                        <a class="float-right">Rs.{{$product->sale_rate}}</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- /.row -->
                <br>
                <div class="row">
                  <div class="col-6">
                    <p class="lead">Product Description:</p>
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                      {{$product->description}}
                    </p>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
    </section>
    <!-- /.content -->
</div>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <!-- Main row -->    
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                <h4 class="card-title titleclass">Product Log</h4>
                </div>
                @if($data->count() > 0)
                <!-- /.card-header -->
                <div id="table_data">
                @include('products.product_log_table')
                </div>
                @else
                <div class="card-body">
                  <p>No records found</p>
                </div>
                @endif
                <!-- /.card-body --> 
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

<script>
    $(document).ready(function(){
    $(document).on('click', '.pagination a', function(event){
     event.preventDefault(); 
     var page = $(this).attr('href').split('page=')[1];
     fetch_data(page);
    });
   
    function fetch_data(page)
    {
     var pagetitle = $('.titleclass').text();
     var id =  $("#product_id").text();
     $.ajax({
      url:"/product_log_pagination/fetch_data?page="+page,
      data:{
       title: pagetitle,
       id: id,
       },
      success:function(data)
      {
       $('#table_data').html(data);
      }
     });
    }
    
   });
</script>
@endsection