@extends('layouts.master_layout.master_layout')
@section('title','Invoice')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<style>
  .delBtn{
    border: none;
    background: none;
    margin-left: -7px;
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Summary</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Summary</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
      <div class="card card-default">
        <form action="{{route('invoice/invoice-search')}}" method="GET">
          <div class="card-header">
              <h3 class="card-title">Filter Invoice</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
              </button>
              </div>
          </div>

          <div class="card-body">
              <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Booker:</label>
                  <select class="select2" name="booker[]" multiple="multiple" data-placeholder="Select Booker" style="width: 100%;">
                    @foreach($bookers as $booker)
                    <option value="{{$booker->id}}">{{$booker->booker_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label>Status:</label>
                    <div class="input-group">
                      <select name="status" class="form-control" >
                        <option value="" selected="true" disabled="true">Select Status</option>
                        <option value="">All</option>
                        <option value="Credit">Credit</option>
                        <option value="Debit">Debit</option>
                    </select>
                    </div>
                    @error('status')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                  </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label>Discount:</label>
                    <div class="input-group">
                      <select name="discountOption" class="form-control" >
                        <option value="" selected="true">All</option>
                        <option value="onlyDiscount">Only Discount</option>
                    </select>
                    </div>
                    @error('status')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                  </div>
              </div>

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

    {{-- invoice status modal start --}}
    <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="invoiceStatusForm" autocomplete="off">
                @csrf
                <input type="text" name="invoice_id" id="invoideID">
                <div class="modal-body">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="debitId" value="Debit" name="invoiceStatusRadioBtn">
                            <label for="debitId" class="custom-control-label">Debit</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-danger" type="radio" id="creditId" value="Credit" name="invoiceStatusRadioBtn">
                            <label for="creditId" class="custom-control-label">Credit</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-warning" type="radio" id="returnedId" value="Returned" name="invoiceStatusRadioBtn">
                            <label for="returnedId" class="custom-control-label">Returned</label>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title titleclass">Invoice</h3>
                  <div class="card-tools">
                    <div class="row">
                      <div class="input-group input-group-sm" style="width: 50px;">
                        <a href="javascript:void(0)" title="Print" onclick="summaryPrint('invoice-print')" class="btn btn-block btn-info"><i class="fas fa-print"></i></a>
                      </div>&nbsp
                      <div class="input-group input-group-sm" style="width: 50px;">
                      <button disabled type="button" value="Delete" id="deleteAllSelectedRecords" class="btn btn-danger check" style="width: 100%;"><i class="fas fa-trash-alt"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="table_data">
                     @if($data->count() > 0)
                    <div class="card-body" id="invoice-print">
                        <table id="example2" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                            <th class="no-print"><input type="checkbox" name="Accept" id="chkCheckAll"></th>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Booker Name</th>
                            <th>Area Name</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Net Total</th>
                            <th>Status</th>
                            <th class="no-print">Action</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $item)
                          <tr id="invoice-{{$item->id}}">
                            <td class="no-print"><input type="checkbox" name="ids" id="checkboxId{{$item->id}}" class="checkBoxClass" value="{{$item->id}}"></td>
                            <td><b>{{$item->id}}</b></td>
                            <td>{{$item->created_at->format('m/d/Y')}}</td>
                            <td>{{$item->customer_name}}</td>
                            <td>{{$item->booker->booker_name}}</td>
                            <td>{{$item->area_name}}</td>
                            <td>{{$item->discount ? $item->discount : '-'}}</td>
                            <td>Rs.{{$item->total}}</td>
                            <td>Rs.{{$item->net_total?$item->net_total:$item->total}}</td>
                            <td id="status-{{$item->id}}">
                                <a href="#" status_id="{{$item->id}}" class="change-status">
                                    <span class="{{$item->status == 'Credit' ? 'badge bg-danger' : 'badge bg-success'}}">{{$item->status}}</span>
                                </a>
                            </td>
                            <td class="no-print">
                              <form actyion="{{route('invoice-delete', $item->id)}}" method="post" id="submit-form">
                                @csrf
                                @method('DELETE')
                              <a title ="Detail" href="{{route('invoice/detail',$item->id)}}"><i class="fa fa-eye"></i></a>&nbsp &nbsp
                              {{-- <a title ="Change status" id="{{$item->id}}" class="changeStatus" href="javascript:void(0)"><i class="fas fa-exchange-alt"></i></a>&nbsp &nbsp --}}
                              <a title ="Payment history" href="{{route('invoice/payment-history',$item->id)}}" id="paymentHistory" class="paymentHistory" ><i class="fas fa-list"></i></a>&nbsp &nbsp
                              <button title="Delete" type="submit" class="delBtn"  style="color: #007bff;" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i></button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                          </tbody>
                            <tfoot>
                            <tr>
                              <th colspan="11">Report</th>
                              <tr>
                                <th colspan="6">Total Debit</th>
                                <td colspan="5" id="debit">Rs.{{$totalDebit}}</td>
                               </tr>
                               <tr>
                                <th colspan="6">Total Credit</th>
                                <td colspan="5" id="credit">Rs.{{$totalCredit}}</td>
                               </tr>
                               <tr>
                                <th colspan="6">Total Discount</th>
                                <td colspan="5">Rs.{{$totalDiscount}}</td>
                               </tr>
                               <tr>
                                <th colspan="6">Total</th>
                                <td colspan="5" id="reportTotal">Rs.{{$GrossTotal}}</td>
                               </tr>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Select2 -->
{{-- <script src="/plugins/select2/js/select2.full.min.js"></script> --}}

<script type="text/javascript">

 // Toaster
  @if(Session::has('status'))
  toastr.options =
  {
      "closeButton" : true,
      "progressBar" : true
  }
  toastr.success("{{ session('status') }}");
  @endif

  $(function() {

      var start = {!! json_encode($start) !!};
      var end = {!! json_encode($end) !!};
      start = moment(start);
      end = moment(end);

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
  </script>

{{-- DataTable --}}
<script>
    $(document).ready(function(){
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $('#example2').DataTable({

      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
    $('input[type=search]').addClass("no-print");
    $('.dataTables_filter').addClass("no-print");

    $("input[type=checkbox]").on("change", function(){
        if ($("input[type=checkbox]:checked").length > 0)
        {
            $("#deleteAllSelectedRecords").removeAttr('disabled','disabled');
            $(".deletedClass").hide();
        }
        else
        {
            $("#deleteAllSelectedRecords").attr('disabled','disabled');
        }
    });

    $("#chkCheckAll").click(function(){
      $(".checkBoxClass").prop('checked',$(this).prop('checked'));
  });

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
      $('.select2').select2({
        closeOnSelect: false
      });

      $(document).on('click','.change-status',function(e){
        e.preventDefault();
        var statusId = $(this).attr('status_id');

        $.ajax({
         url: '{{ route('invoice.get-status') }}',
         type: 'GET',
         data: {
            id: statusId,
         },
         success:function(data)
         {
            var status = data.status;
            $('#status-modal').modal('show');

            if (status === 'Debit') {
                $('#debitId').prop('checked', true);
            } else if (status === 'Credit') {
                $('#creditId').prop('checked', true);
            } else if (status === 'Returned') {
                $('#returnedId').prop('checked', true);
            }
            $("#invoideID").val(data.id);

         }
     });
    });

    $('#invoiceStatusForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);
        let startDate = $('#date-range-start').val();
        let endDate = $('#date-range-end').val();

        formData.append('startDate', startDate);
        formData.append('endDate', endDate);

        $.ajax({
            type: "POST",
            url: '{{ route('invoice.change-status') }}',
            data:  formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                let invoice = response.invoice;

                let statusElement = document.createElement('a');
                statusElement.href = '#';
                statusElement.classList.add('change-status');
                statusElement.setAttribute('status_id', invoice.id);

                let spanElement = document.createElement('span');
                spanElement.textContent = invoice.status;
                statusElement.appendChild(spanElement);

                if (invoice.status === 'Credit') {
                    spanElement.classList.add('badge', 'bg-danger');
                }
                else if(invoice.status == 'Debit'){
                    spanElement.classList.add('badge', 'bg-success');
                }
                else {
                    spanElement.classList.add('badge', 'bg-warning');
                }
                let total = parseFloat(response.totalDebit) + parseFloat(response.totalCredit);

                $('#status-'+ invoice.id).html(statusElement);
                $('#debit').text('Rs.'+ response.totalDebit);
                $('#credit').text('Rs.'+ response.totalCredit);
                $('#reportTotal').text('Rs.'+ total.toFixed(2));

                $('#status-modal').modal('hide')
            },
        });
     });

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

