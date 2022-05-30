@extends('layouts.master_layout.master_layout')
@section('title','Payment history')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .delBtn{
    border: none;
    background: none;
    margin-left: -7px;
}
</style>

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
                      <i class="fas fa-info-circle"></i> Amount to be paid in PKR - {{$invoice->discount_total?$invoice->discount_total:$invoice->total}}
                    </h4>
                  </div>
                </div>
                <br>
                <form action="{{route('add-payment-history')}}" method="POST">
                  <div class="row">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="roles">Date:</label>
                          <div class="input-group date" id="date" data-target-input="nearest">
                              <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                              <input required type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate">
                          </div>
                          @error('date')
                          <p style="color:red">{{$message}}</p>
                          @enderror
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
                          @error('paid_amount')
                          <p style="color:red">{{$message}}</p>
                          @enderror
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="roles">Remarks:</label>
                          <textarea class="form-control" name="remarks" id="remarks" rows="4" cols="50"></textarea>
                      </div>
                    </div>

                    <div class="col-12">
                      <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
                    </div>



                    {{-- <div class="col-sm-6">
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
                    </div> --}}

                    {{-- <div class="col-sm-6">
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
                    </div> --}}
                  </div>
                </form>
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
                    <h3 class="card-title titleclass">Records</h3>
                </div>
                @if($paymentHistory->count() > 0)
                <div id="table_data">
                    <div class="card-body">
                        <table id="invoice-tbl" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                            <th>Date</th>
                            <th>Amount Paid</th>
                            <th>Remaining Amount</th>
                            <th>Total Amount</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                          </tr>
                          </thead>
                          <tbody id="historyTable">
                          @foreach($paymentHistory as $data)
                          <tr id="history-{{$data->id}}">
                            <td>{{ $data->date }}</td>
                            <td>Rs.{{ $data->paid_amount }}</td>
                            <td></td>
                            <td>Rs.{{ $invoice->discount_total ? $invoice->discount_total : $invoice->total }}</td>
                            <td>{{ $data->remarks }}</td>
                            <td>
                            <form action="{{route('payment-history-delete', $data->id)}}" method="post" id="submit-form">
                              @csrf
                              @method('DELETE')
                            <a title ="Edit" id="{{$data->id}}" class="edit"><i class="fa fa-edit"></i></a>&nbsp &nbsp
                            <button title="Delete" type="submit" class="delBtn"  style="color: #007bff;" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i></button>
                            </form>
                          </td>
                          </tr>
                          @endforeach
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

        <!-- Edit Payment History Modal Start-->
        <div class="modal fade" id="historyModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Edit Payment History</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{route('payment-history-edit')}}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                <div class="row">
                  <input type="hidden" name="invoice_id" id="invoiceId">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles">Date:</label>
                            <div class="input-group date" id="edit-date" data-target-input="nearest">
                                <div class="input-group-append" data-target="#edit-date" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input required type="text" name="date" id="new_date" class="form-control datetimepicker-input" data-target="#reservationdate">
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
                                <input type="text" name="paid_amount" id="amount_paid" class="form-control">
                                <span class="text-danger error-text paid_amount_err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="roles">Remarks:</label>
                            <textarea class="form-control" name="remarks" id="new_remarks" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        <!--Edit Payment History Modal End-->
      </section>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

@if(Session::has('status'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
      toastr.success("{{ session('status') }}");
@endif

    $(function () {
      //Date time picker
      $('#date').datetimepicker({
        format: 'L',
        formatDate:'m/d/Y',
        maxDate: moment(),
      });

      $('#edit-date').datetimepicker({
        format: 'L',
        formatDate:'m/d/Y',
        maxDate: moment(),
      });

      calculateRemainingAmount();

    //  Getting Data from database into history model
    $(document).on('click','.edit',function(){
        var id = $(this).attr('id');
        console.log(id)
        $.ajax({
            url:"/edit-payment-history-form/"+id,
            dataType:"json",
            success:function(data)
            {
              console.log(data)
              $('#historyModal').modal('show');
              $('#amount_paid').val(data.paid_amount);
              $('#new_remarks').val(data.remarks);
              $('#new_date').val(data.date);
              $('#invoiceId').val(data.id);
            }
        })
      });
  });

  function calculateRemainingAmount(){
    $("#historyTable tr").each(function(){
        var currentRow=$(this);
        var prevRow=currentRow.prev();

        var currentRemainingAmount=parseFloat(currentRow.find("td:eq(2)").text().replace(/[^0-9]/gi, ''));
        var prevRemainingAmount=parseFloat(prevRow.find("td:eq(2)").text().replace(/[^0-9]/gi, ''));

        var currentAmountPaid=parseFloat(currentRow.find("td:eq(1)").text().replace(/[^0-9]/gi, ''));
        var prevAmountPaid=parseFloat(prevRow.find("td:eq(1)").text().replace(/[^0-9]/gi, ''));

        var currentTotalAmount=parseFloat(currentRow.find("td:eq(3)").text().replace(/[^0-9]/gi, ''));
        var prevTotalAmount=parseFloat(prevRow.find("td:eq(3)").text().replace(/[^0-9]/gi, ''));

        //IF PREV AMOUNT PAID IS EMPTY THEN MINUS CURRENT AMOUNT PAID FROM TOTAL AMOUNT, OTHERWISE MINUS CURRENT AMOUNT PAID FROM PREV REMAINING AMOUNT
        if(!prevAmountPaid) {
          var remainaingAmountForFirstRow = currentTotalAmount - currentAmountPaid;
          currentRow.find("td:eq(2)").html('Rs.'+remainaingAmountForFirstRow);
        }
        else {
          var remainaingAmount = prevRemainingAmount - currentAmountPaid;
          currentRow.find("td:eq(2)").html('Rs.'+remainaingAmount);
        }
   });
  }
  </script>

@endsection


