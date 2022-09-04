@extends('layouts.master_layout.master_layout')
@section('title','Invoice Detail')
@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Invoice Detail</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Invoice Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

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
                  <i class="fas fa-globe"></i> {{config('admin.title.ahsan_traders')}}
                 
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <br>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <div class="well">
                  <ul class="list-unstyled mb0">
                      <li><strong>Customer Name:</strong> {{$invoice->customer_name}}</li>
                      <li><strong>Booker Name:</strong> {{$invoice->booker->booker_name}}</li>
                      <li><strong>Area Name:</strong> {{$invoice->area_name}}</li>
                  </ul>
              </div>
              </div>
              <div class="col-sm-4 invoice-col">
              </div>
              <div class="col-sm-4 invoice-col">
                <div class="well">
                  <ul class="list-unstyled mb0">
                      <li><strong>Invoice</strong> #{{$invoice->id}}</li>
                      <li><strong>Date:</strong> {{$invoice->created_at->format('m/d/Y')}} - {{ $invoice->created_at->format('g:i A')}}</li>
                      <li><strong>Salesman Name:</strong> {{$invoice->salesman_name}}</li>
                  </ul>
              </div>
              </div>
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Product</th>
                    <th>Unit Qty</th>
                    <th>Ctn Qty</th>
                    <th>Rate</th>
                    <th>Disc</th>
                    <th>Disc %</th>
                    <th>Gross Amount</th>
                    <th>Net Amount</th>

                  </tr>
                  </thead>
                  @foreach($invoice->invoiceProduct as $product)
                  <tbody>
                  <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->qty ? $product->pivot->qty : '-'}}</td>
                    <td>{{$product->pivot->ctn_qty ? $product->pivot->ctn_qty : '-'}}</td>
                    <td>Rs.{{$product->pivot->product_type == 'single' ? $product->sale_rate : $product->ctn_sale_rate}}</td>
                    <td>{{$product->pivot->disc_by_cash ? 'Rs.' : '-'}}{{$product->pivot->disc_by_cash}}</td>
                    <td>{{$product->pivot->disc_by_percentage}}{{$product->pivot->disc_by_percentage ? '%':'-'}}</td>
                    <td>Rs.{{$product->pivot->amount}}</td>
                    <td>Rs.{{$product->pivot->disc_amount}}</td>
                  </tr>
                  </tbody>
                  @endforeach
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">

              </div>
              <!-- /.col -->
              <div class="col-6">
                <div class="table-responsive">
                  <table class="table">
                    @if($invoice->discount)
                    <tr>
                      <th>Gross Total:</th>
                      <td>Rs.{{$invoice->total}}</td>
                    </tr>
                    <tr>
                      <th>Discount:</th>
                      <td>Rs.{{$invoice->discount}}</td>
                    </tr>
                    @endif
                    <tr>
                      <th>Total:</th>
                      <td>Rs.{{$invoice->discount_total ? $invoice->discount_total : $invoice->total}}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="javascript:void(0)" rel="noopener" onclick="window.print()" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>


@endsection
