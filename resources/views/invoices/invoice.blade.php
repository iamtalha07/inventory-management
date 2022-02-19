@extends('layouts.master_layout.master_layout')
@section('title','Invoice')
@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Invoice</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Invoice</li>
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
                  <div class="card-tools">
                    <div class="row">
                    <div class="input-group input-group-sm" style="width: 50px;">
                      <a href="{{route('invoice/create-invoice')}}" title="Add New Product" class="btn btn-block btn-success"><i class="fas fa-plus"></i></a>
                    </div>&nbsp
                    <div class="input-group input-group-sm" style="width: 50px;">
                    <button disabled type="button" value="Delete" id="deleteAllSelectedRecords" class="btn btn-danger check" style="width: 100%;"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    </div>
                  </div>
                </div>
                @if($data->count() > 0)
                <div id="table_data">
                @include('invoices.invoice_table')
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
            url:"/invoice-pagination/fetch_data?page="+page,
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

        $("#deleteAllSelectedRecords").click(function(e){
             e.preventDefault();
             var allids = [];
             $("input:checkbox[name=ids]:checked").each(function(){
                 allids.push($(this).val());
             });

             $.ajax({
                 url:"{{route('invoice.deleteSelectedInvoice')}}",
                 type:'DELETE',
                 data:{
                     ids:allids,
                     _token:$("input[name=_token]").val()
                 },
                 success:function(data)
                 {
                     $.each(allids,function(key,val){
                         $("#invoice-"+val ).addClass( "deletedClass" );
                         $('#invoice-'+val).remove();
                     });
                     $("#deleteAllSelectedRecords").attr('disabled','disabled');
                     toastr.success("Invoice deleted successfully");
                 }
             });
        });
        
       });
</script>

@endsection