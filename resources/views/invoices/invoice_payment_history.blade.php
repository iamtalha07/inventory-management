@extends('layouts.master_layout.master_layout')
@section('title','Payment history')
@section('content')


<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Payment Hisotry</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Payment history</li>
        </ol>
        </div>
     </div>
    </div>
</section>

<div class="container-fluid">
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="invoice p-3 mb-3">
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-info-circle"></i> Payment history
                    </h4>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-6">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <b>Invoice Id:</b>
                        <a class="float-right" id="product_id">{{$invoice->id}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Customer Name:</b>
                        <a class="float-right">{{$invoice->customer_name}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Booker Name:</b>
                        <a class="float-right">{{$invoice->booker->booker_name}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Area Name:</b>
                        <a class="float-right">{{$invoice->area_name}}</a>
                      </li>
                    </ul>
                  </div>

                  <div class="col-sm-6">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <b>Date:</b>
                        <a class="float-right">{{$invoice->created_at->format('m/d/Y')}}</a>
                      </li>
                      <li class="list-group-item">
                        <div style="display: inline;">
                        <b>Salesman Name:</b>
                        <a class="float-right">{{$invoice->salesman_name}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Status:</b>
                        <a class="float-right">{{$invoice->status}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Total:</b>
                        <a class="float-right">Rs.{{$invoice->discount_total?$invoice->discount_total:$invoice->total}}</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <br>
              </div>
              </div>
            </div>
          </div>
    </section>

    <section class="content">
        <div class="container-fluid">  
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <h3 class="card-title titleclass">History</h3>
                    <div class="card-tools">
                      <div class="row">
                        <div class="input-group input-group-sm" style="width: 50px;">
                          <a href="javascript:void(0)" title="Add payment history" class="btn btn-block btn-success"  data-toggle="modal" data-target="#historyModal"><i class="fas fa-plus"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                @if($paymentHistory->count() > 0)
                <div id="table_data">
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                            <th>Date</th>
                            <th>Amount Paid</th>
                            <th>Remaining Amount</th>
                            <th>Total Amount</th>
                            <th>Remarks</th>
                          </tr>
                          </thead>
                          <tbody tbody id="leadsTable">
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          </tbody>
                        </table>
                        <div class="float-right">
                          </div>
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

        <!-- Add Payment History Modal Start-->
        <div class="modal fade" id="historyModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Add Payment History</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="addBookerForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles">Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input required type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate">
                            </div>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles">Amount Paid:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rs.</span>
                                </div>
                                <input type="text" name="amount_paid"  class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="roles">Remarks:</label>
                            <textarea class="form-control" name="description" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        <!--Add Payment History Modal End-->
      </section>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script>
    $(function () {
      //Date time picker
      $('#reservationdate').datetimepicker({
        format: 'L',
        formatDate:'m/d/Y',
        maxDate: moment(),
        // minDate:'-1970/01/02',//yesterday is minimum date(for today use 0 or -1970/01/01)
        // maxDate:'+1870/01/02'//tomorrow is maximum date calendar
      });
      });
  </script>

@endsection