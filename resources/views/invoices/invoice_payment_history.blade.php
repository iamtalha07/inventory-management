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
                        <a class="float-right" id="total">Rs.{{$invoice->discount_total?$invoice->discount_total:$invoice->total}}</a>
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
                          <a href="javascript:void(0)" title="Add payment history" class="btn btn-block btn-success"
                            data-toggle="modal"
                            data-target="#historyModal"
                            data-id="{{ $invoice->id }}">
                            <i class="fas fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                {{-- @if($paymentHistory->count() > 0) --}}
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
                          <tbody id="historyTable">
                          @foreach($paymentHistory as $data)
                          <tr id="history-{{$data->id}}">
                            <td>{{ $data->date }}</td>
                            <td>Rs.{{ $data->paid_amount }}</td>
                            <td>Rs.{{ $data->remaining_amount }}</td>
                            <td>Rs.{{ $invoice->discount_total ? $invoice->discount_total : $invoice->total }}</td>
                            <td>{{ $data->remarks }}</td>
                          </tr>
                          @endforeach
                          </tbody>
                        </table>
                        <div class="float-right">
                          </div>
                      </div>
                </div>
                {{-- @else
                <div class="card-body">
                    <div class="alert alert-info">
                      No records found.
                    </div>
                  </div>
                @endif --}}
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
                <form id="addPaymentHistory" autocomplete="off">
                @csrf
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles">Date:</label>
                            <div class="input-group date" id="date" data-target-input="nearest">
                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input required type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate">
                                <input type="text" name="invoice_id" id="invoiceId">
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
                                <input type="text" name="paid_amount" id="paid_amount" class="form-control">
                                <span class="text-danger error-text paid_amount_err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="roles">Remarks:</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="4" cols="50"></textarea>
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
      $('#date').datetimepicker({
        format: 'L',
        formatDate:'m/d/Y',
        maxDate: moment(),
      });

      function printErrorMsg (msg) {
                $.each( msg, function( key, value ) {

                  $('.'+key+'_err').text(value);
            });
        }

      $('#addPaymentHistory').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/add-payment-history",
            data: $('#addPaymentHistory').serialize(),
            success: function (response) {
                console.log(response);
                console.log(response.paid_amount);
              

                var total = $('#total').text();
                console.log(total);
                if($.isEmptyObject(response.error))
                {
                  console.log('yes')
                var tableRow =  "<tr id='history-"+response.id+"'>"+
                                "<td>"+response.date+"</td>"+
                                "<td>Rs."+response.paid_amount+"</td>"+
                                "<td>Rs."+response.remaining_amount+"</td>"+
                                "<td>"+ total +"</td>"+
                                "<td>"+response.remarks+"</td>"+
                                "</tr>";
                console.log(tableRow);
                $("#historyTable").append(tableRow);
                $('#historyModal').modal('hide');
                $(".paid_amount_err").text('');
                $('#paid_amount').val('');
                $('#remarks').val('');
                // $("#addPaymentHistory")[0].reset();
                // $("#date").val(moment());

                
                toastr.success("Payment history added");
                }
                else
                {   
                  console.log('no')

                    toastr.remove();
                    printErrorMsg(response.error);
                }
            },
            error: function(error){
              alert('Error');
            }
        });
     });


      $('#historyModal').on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var modal = $(this);
        var invoiceId = button.data('id');
        modal.find('.modal-body #invoiceId').val(invoiceId);
      });
  });
  </script>

@endsection