@extends('layouts.master_layout.master_layout')
@section('title','Stock')
@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Stock</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Stock</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"> 
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title titleclass">All</h3>
                </div>
                @if($data->count() > 0)
                <div id="table_data">
                @include('stock.stock_table')
                </div>
                @else
                <div class="card-body">
                  <p>No records found</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </section>

    <script>
    // Toaster
    @if(Session::has('status'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
      toastr.success("{{ session('status') }}");
    @endif


    $(document).ready(function(){
    
    $(document).on('click', '.pagination a', function(event){
     event.preventDefault(); 
     var page = $(this).attr('href').split('page=')[1];
     fetch_data(page);
    });
   
    function fetch_data(page)
    {
     var pagetitle = $('.titleclass').text();
     $.ajax({
      url:"/stock_pagination/fetch_data?page="+page,
      data:{
       title: pagetitle
       },
      success:function(data)
      {
      $("#deleteAllSelectedRecords").attr('disabled','disabled');
       $('#table_data').html(data);
      }
     });
    }
    
   });
    </script>
@endsection
