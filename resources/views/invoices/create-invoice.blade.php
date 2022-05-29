@extends('layouts.master_layout.master_layout')
@section('title','Create Invoice')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Create Invoice</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Create New Invoice</li>
        </ol>
        </div>
     </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <form action="{{route('create-invoice')}}" method="POST">
                @csrf
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> Ahsan Traders
                  <small class="float-right">Date: {{$currentDate}}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <br>
            <!-- info row -->
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" name="customer_name"  value="{{old('customer_name')}}" class="form-control">
                    @error('customer_name')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                  </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="booker_name">Booker Name:</label>
                    <div class="input-group">
                      <select name="booker_id" class="form-control" id="sel_booker">
                        <option value="" selected="true">Select Booker</option>
                        @foreach($bookers as $booker)
                          <option value="{{ $booker->id }}">{{ $booker->booker_name }}</option>
                        @endforeach
                      </select>
                      @error('booker_name')
                      <p style="color:red">{{$message}}</p>
                      @enderror
                      <button title ="Add New Booker" type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookerModal" >
                        <i class="fas fa-plus"></i>
                      </button> 
                      <button title ="Delete Role" type="button" class="btn btn-danger" data-toggle="modal" data-target="#bookerModalDelete" >
                          <i class="fas fa-minus"></i>
                      </button> 
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="salesman_name">Salesman Name:</label>
                    <input type="text" name="salesman_name"  value="{{old('salesman_name')}}" class="form-control" >
                    @error('salesman_name')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="area_name">Area Name:</label>
                    <input type="text" name="area_name"  value="{{old('area_name')}}" class="form-control">
                    @error('area_name')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="customer_name">Invoice Status:</label>
                    <select name="status" class="form-control" >
                      <option value="Debit" selected="true" >Debit</option>
                      <option value="Credit">Credit</option>
                  </select>
                </div>
              </div>
            </div>

            @if($errors->has('product_id'))
            <div class="alert alert-danger alert-dismissible  fade show" role="alert">
              {{$errors->first('product_id')}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
            @endif

            <!-- Table row -->
            <div class="row">
              <table class="table table-bordered" id="dynamicTable">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Stock</th>
                    <th>Unit Price</th>
                    <th>Disc%</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="productRow">
                <tr class="dynamicTable">  
                    <td style="width: 360px">
                        <select name="product_id[]" class="form-control productname" >
                          <option value="" selected="true" disabled="true">Select Product</option>
                        @foreach($products as $product)
                          <option name="product_id[]" value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="text" name="qty[]" class="form-control qty"  required></td>
                    <td><input type="text" id="stockID" name="stock[]" class="form-control stock" readonly/></td> 
                    <td><input type="text" name="price[]" class="form-control price" required></td>
                    <td><input type="text" name="dis[]" class="form-control dis" ></td>
                    <td><input type="text" name="amount[]" value="0.00" class="form-control amount" readonly></td>
                    <td><button type="button" name="add" id="add" class="btn btn-success addRow"><i class="fas fa-plus"></i></button></td>  
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td><b>Sub Total</b></td>
                     <td><b>Rs. </b> <b class="total"></b></td>
                     <td></td>
                    </tr>
                   </tfoot>
                   <input type="hidden" name="total" class="total">
                   <input type="hidden" name="discountTotal" id="discountTotal">
            </table> 
              <!-- /.col -->
            </div>
            <!-- /.row -->


            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead">Discount Option:</p>
                <div class="form-group">
                  <div class="custom-control custom-radio">
                      <input class="custom-control-input radio" type="radio" id="Radio1" name="discountRadio" value="noDiscount" checked>
                      <label for="Radio1" class="custom-control-label">No Discount</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input radio" type="radio" id="Radio2" name="discountRadio" value="cashDiscount">
                      <label for="Radio2" class="custom-control-label">Discount by cash</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input radio" type="radio" id="Radio3" name="discountRadio" value="perDiscount">
                      <label for="Radio3" class="custom-control-label">Discount by percentage</label>
                    </div>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-6">
                {{-- <p class="lead">Amount Due 2/22/2014</p> --}}

                <div class="table-responsive">
                  <table class="table">
                    <tr id="discountCash">
                      <th>Discount by cash:</th>
                      <td><input type="text" class="form-control" name="cash" id="cash"></td>
                    </tr>
                    <tr id="discountPer">
                      <th>Discount by percentage:</th>
                      <td><input type="text" class="form-control" name="percentage" id="per"></td>
                    </tr>
                    <tr id="discountTotalSection">
                      <th>Total:</th>
                      <td><span>Rs. </span> <span id="totalDiscount"></span></td>
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
                <button type="submit" class="btn btn-success float-right"> Create Invoice</button>
              </div>
            </div>
            </form>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->

  <!-- Add Booker Modal Start-->
  <div class="modal fade" id="bookerModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Booker</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addBookerForm" autocomplete="off">
          @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Booker Name:</label>
            <input type="text" class="form-control" id="booker" name="booker" placeholder="Enter Booker Name">
            <span class="text-danger error-text booker_err"></span>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Booker</button>
        </div>
        </form>
      </div>
    </div>
  </div>
   <!--Add Role Modal End-->

  <!-- Delete Booker Modal Start-->
  <div class="modal fade" id="bookerModalDelete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Booker</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addBookerForm" autocomplete="off">
          @csrf
        <div class="modal-body">
          <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th><input type="checkbox" id="chkCheckAll"></th>
                  <th>ID</th>
                  <th>Booker</th>
                </tr>
              </thead>
              <tbody id="bookersTable">
                @foreach($bookers as $item)
                <tr id="sid{{$item->id}}">
                  <td><input type="checkbox" name="ids" class="checkBoxClass" value="{{$item->id}}"></td>
                  <td>{{$item->id}}</td>
                  <td>{{$item->booker_name}}</td>
                </tr>
                <tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" id="cancelBookerDelete" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="deleteBooker" class="btn btn-primary" disabled>Delete Booker(s)</button>
        </div>
        </form>
      </div>
    </div>
  </div>
   <!--Delete Booker Modal End-->
  </section>

  <script type="text/javascript">

      var BookerbtnStatus = function() { 
      $("input[type=checkbox]").on("change", function(){
      if ($("input[type=checkbox]:checked").length > 0)
      {
          $("#deleteBooker").removeAttr('disabled','disabled');
      }
      else
      {
          $("#deleteBooker").attr('disabled','disabled');
      }
    });

    }
    $(document).ready(BookerbtnStatus);

    $(document).ready(function(){

      $('#discountCash').hide();
      $('#discountPer').hide();
      $('#discountTotalSection').hide();

      //Discount Radio button actions
      $('.radio').click(function(e) {
            var val = $(this).val();
            var total =   $(".total").val();
                if(val=="cashDiscount")
                {
                    $('#discountCash').show();
                    $('#discountPer').hide();
                    $('#discountTotalSection').show();
                    $("#totalDiscount").html(total);
                    $("#discountTotal").val('');
                    $('#per').val('');
                }
                else if(val=="perDiscount")
                {
                    $('#discountCash').hide();
                    $('#discountPer').show();
                    $('#discountTotalSection').show();
                    $("#totalDiscount").html(total);
                    $("#discountTotal").val('');
                    $('#cash').val('');
                }
                else
                {
                    $('#discountCash').hide();
                    $('#discountPer').hide();
                    $('#discountTotalSection').hide();
                    $('#cash').val('');
                    $('#per').val('');
                    $("#discountTotal").val('');
                }
        });

        $("#discountCash").keyup(function(){
          var discountByCash =   $("#cash").val();
          var total =   $(".total").val();
          var totalAfterDiscount = total - discountByCash;
          totalAfterDiscount = totalAfterDiscount.toFixed(2);

          $("#totalDiscount").html(totalAfterDiscount);
          $("#discountTotal").val(totalAfterDiscount);
      });

      $("#discountPer").keyup(function(){
          var discountByPer =   $("#per").val();
          var total =   $(".total").val();
          var totalAfterDiscount = total - (total*discountByPer)/100;
          totalAfterDiscount = totalAfterDiscount.toFixed(2);
          $("#totalDiscount").html(totalAfterDiscount);
          $("#discountTotal").val(totalAfterDiscount);
      });


        $('.addRow').on('click', function () {
                addRow();
            });

        function addRow() {
        var addRow = '<tr>\n' +
            '<td><select name="product_id[]" class="form-control productname" required>\n' +
             '<option value="" selected="true" disabled="true">Select Product</option>\n' +
                    '@foreach($products as $product)\n' +
                        '<option value="{{$product->id}}">{{$product->name}}</option>\n' +
                    '@endforeach\n' +
                '</select></td>\n' +
            '<td><input type="text" name="qty[]" class="form-control qty"  required></td>\n' +
            '<td><input type="text" id="stockID" name="stock[]" class="form-control stock" readonly/></td>\n'+
            '<td><input type="text" name="price[]" class="form-control price"required ></td>\n' +
            '<td><input type="text" name="dis[]" class="form-control dis" ></td>\n' +
            '<td><input type="text" name="amount[]" value="0.00" class="form-control amount" readonly></td>\n' +
            '<td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus"></i></button></td>\n' +
            '</tr>';
            $('#productRow').append(addRow);

        };

        function recalculatePrice(tr)
        {
          var productAmount = tr.find('.amount').val();
          var total =  parseFloat($('.total').val());
          var productAmount = parseFloat(productAmount);
          var result = total - productAmount;
          if(isNaN(result)==false)
          {
              console.log(result);
              result = result.toFixed(2);
              $('.total').html(result);
              $('.total').val(result);
          }
        }

        $(document).on('click', '.remove-tr', function(){  
          var tr =$(this).parent().parent();
          recalculatePrice(tr);
        $(this).parents('tr').remove();
    });

    $('tbody').delegate('.productname', 'change', function () {
            var tr =$(this).parent().parent();
            var id = tr.find('.productname').val();
            console.log(id)
            $.ajax({
            url: '/get-product-data/'+id,
            type: "GET",
            dataType: "json",
            success:function(data) {
                tr.find('.stock').val(data[1].in_stock);
                tr.find('.price').val(data[0].sale_rate);
            }
        });
    });
    
    $('tbody').delegate('.qty,.price,.dis', 'keyup', function () {

        var tr = $(this).parent().parent();
        var qty = tr.find('.qty').val();
        var price = tr.find('.price').val();
        var dis = tr.find('.dis').val();
        var amount = (qty * price)-(qty * price * dis)/100;
        amount = amount.toFixed(2);
        tr.find('.amount').val(amount);
        total();
    });
    function total(){
        var total = 0;
        $('.amount').each(function (i,e) {
             var amount =$(this).val()-0;
            total += amount;
         })
         total = total.toFixed(2);
        $('.total').html(total);
        $('.total').val(total);
        $('#totalDiscount').html(total);
    }


    $('tbody').delegate('.qty', 'focusout', function () {
        var tr = $(this).parent().parent();
        var qty = tr.find('.qty').val();
        var stock = tr.find('.stock').val();
        var product = tr.find('.productname option:selected').text()
        if(parseFloat(qty) > parseFloat(stock))
        {
          toastr["error"](product + ' does not have enough stock.')
          toastr.options = {
            "closeButton": true,
          }
          recalculatePrice(tr);
          tr.find('.qty').val('');
          tr.find('.amount').val('');
        }
        });

      //Quantity Number only Validation
        var numberOnly = function() {
        var regex = new RegExp("^[0-9]+$");
          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
          if (!regex.test(key)) {
            event.preventDefault();
            return false;
          }
      }

      $('tbody').delegate('.qty', 'keypress', function () {
           numberOnly()
      });

      function printErrorMsg (msg) {
                $.each( msg, function( key, value ) {

                  $('.'+key+'_err').text(value);
            });
        }

      //Add booker
      $('#addBookerForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/add-booker",
            data: $('#addBookerForm').serialize(),
            success: function (response) {
                var id = response.id;
                var name = response.booker_name;
                if($.isEmptyObject(response.error))
                {
                    var option = "<option selected value='"+id+"'>"+name+"</option>";
                    var tableRow = "<tr id='sid"+id+"'><td><input type='checkbox' name='ids' class='checkBoxClass' value="+id+"></td><td>"+id+"</td><td>"+name+"</td></tr>"
                    $("#sel_booker").append(option); 
                    $("#bookersTable").append(tableRow);
                    $('#bookerModal').modal('hide');
                    $(".booker_err").text('');
                    $("#addBookerForm")[0].reset();
                    toastr.success("Booker Added Successfully");
               
                }
                else
                {   toastr.remove();
                    printErrorMsg(response.error);
                }
                 BookerbtnStatus();

            },
            error: function(error){
               console.log('Error');
            }
        });
     });
    //  Booker Check Aall
     $("#chkCheckAll").click(function(){
            $(".checkBoxClass").prop('checked',$(this).prop('checked'));
        });
    });

    // Booker Delete
    $("#deleteBooker").click(function(e){
            e.preventDefault();
            var allids = [];
            $("input:checkbox[name=ids]:checked").each(function(){
                allids.push($(this).val());
            });

            $.ajax({
                url:"{{route('deleteSelectedRoles')}}",
                type:'DELETE',
                data:{
                    ids:allids,
                    _token:$("input[name=_token]").val()
                },
                success:function(data)
                {
               
                    $.each(allids,function(key,val){
                        $('#sid'+val).remove();
                        $("#sel_booker option[value="+val+"]").each(function() {
                        $(this).remove();
                    });
                       
                    });
                    $("#deleteBooker").attr('disabled','disabled');
                    toastr.success(data.success);
                }
            });
        });
  </script>
@endsection