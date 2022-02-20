@extends('layouts.master_layout.master_layout')
@section('title','Sales Report')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Sales Report</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Sales Report</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
          <form action="{{route('sales-report')}}" method="GET">
            <div class="card-header">
                <h3 class="card-title">Filter Sales Report</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </div>
            </div>
  
            <div class="card-body">
                <div class="row">
                <div class="form-group">
                  <label>Date range:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reportrange">
                  </div>
                </div>
                <input type="hidden" name="start" id="date-range-start">
                <input type="hidden" name="end" id="date-range-end">
                
                <div class="col-md-1">
                  <div class="form-group">
                      <label for="submit"></label>
                      <button type="submit" class="btn btn-success search-btn" style="margin-top: 35px;"><i class="fas fa-search"></i></button>
                  </div>
                </div>
                </div>
            </div>
          </form>
    </div>
  </div>
</section>

<section class="content">
    <div class="container-fluid"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title titleclass">Sales Report</h3>
              <div class="card-tools">
                <div class="row">
                  <div class="input-group input-group-sm" style="width: 50px;">
                    <a href="javascript:void(0)" title="Print" onclick="summaryPrint('report-print')" class="btn btn-block btn-info"><i class="fas fa-print"></i></a>
                  </div>&nbsp
                </div>
              </div>
            </div>
            <div id="table_data">
                 @if($data->count() > 0)
                <div class="card-body" id="report-print">
                  <h2>Ahsan Traders (DRS)</h2>
                    <table id="example2" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th colspan="5">{{$start}} - {{$end}}</th>
                        </tr>
                      <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                      </tr>
                      </thead>
                      <tbody tbody id="leadsTable">
                        @foreach($data as $item) 
                      <tr>
                        <td><b>{{$item->product_id}}</b></td>
                        <td>{{$item->name}}</td>
                        <td>Rs.{{$item->price}}</td>
                        <td>{{$item->qty}}</td>
                        <td>Rs.{{$item->amount}}</td>
                      </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                        <td colspan="3"></td>
                         <td><b>Total</b></td>
                         <td><b>Rs.{{$total}}</b></td>
                        </tr>
                       </tfoot>
                    </table>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">

$(function() {

  $('#example2').DataTable({

    "paging": false,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": false,
    "responsive": true,
    buttons: [
      {
        extend: 'print',
        text: 'Print'
      }
    ]
    });

    $('input[type=search]').addClass("no-print");
    $('.dataTables_filter').addClass("no-print");
    $('.dt-buttons').addClass("no-print");

  
  var start = moment();
  var end = moment();

  function cb(start, end) {
      $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('#date-range-start').val(start.format('YYYY-MM-DD'));
      $('#date-range-end').val(end.format('YYYY-MM-DD'));
    }
  
  $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
  }, cb);
  cb(start, end);
});

function summaryPrint(printContent){
    var backup = document.body.innerHTML;
    var divcontent = document.getElementById(printContent).innerHTML;
    document.body.innerHTML = divcontent;
    window.print();
    document.body.innerHTML = backup;
  }
</script>
@endsection