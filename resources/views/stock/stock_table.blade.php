<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="card-body">
  <table id="example2" class="table table-bordered table-hover">
    <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Purchase Qty</th>
      <th>Sale Qty</th>
      <th>In Stock</th>
      <th>Ctn In Stock</th>
      <th>Stocks Worth</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody tbody id="leadsTable">
      @foreach($data as $item)
    <tr>
      <td ><b>{{$item->id}}</b></td>
      <td>{{$item->product->name}}</td>
      <td id="purchaseQty-{{$item->id}}">{{$item->product->purchase_qty}}</td>
      <td>{{$item->sale_qty}}</td>
      <td id="inStock-{{$item->id}}">{{$item->in_stock}}</td>
      <td id="cntInStock-{{$item->id}}">{{$item->ctn_in_stock}}</td>
      <td>{{'Rs. ' . $item->in_stock * $item->product->purchase_rate}}</td>
      <td>
        <a title ="Manage quantity" href="javascript:void(0)" id="{{$item->id}}" class="addQtyClass"><i class="fas fa-plus"></i></a>&nbsp &nbsp
    </td>
    </tr>
    @endforeach
    </tbody>
  </table>
    <div class="float-right">
    {!! $data->links() !!}
    </div>
</div>

<!-- Add Quantity Modal Start -->
<div class="modal fade" id="modal-qty">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Stock</h4>
          <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addQtyForm" class="sample_form" method="POST">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="stock_id" id="stock_id">
            <input type="hidden" name="product_id" id="product_id">
            <div class="form-group">
                <label for="qty">Manage Quantity:</label>
                <input type="number" class="form-control" name="qty"  id="qty">
                <span class="text-danger error-text qty_err_edit"></span>
            </div>

            <div class="form-group">
              <textarea name="remarks" class="form-control" rows="3" placeholder="Enter Remarks..."></textarea>
          </div>
        </div>
        <div class="col-sm-6">
          <!-- radio -->
          <div class="form-group">
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" id="qtyRadio2" name="qtyOption" value="add-quantity" checked>
              <label for="qtyRadio2" class="custom-control-label">Add Quantity</label>
            </div>
        </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="closeModal btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Done</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!-- Add Quantity Modal End -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
  });

  $(document).on('click','.addQtyClass',function(){
        var id = $(this).attr('id');
        $.ajax({
            url:"/stock-add-quantity/"+id,
            dataType:"json",
            success:function(data)
            {
                $('#modal-qty').modal('show');
                $('#product_id').val(data.result.product_id);
                $('#stock_id').val(data.result.id);
            }
        })
  });

        //Add quantity in stock
        $('#addQtyForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);
        var stockID = $("#stock_id").val();
        $.ajax({
            type: "POST",
            url: "/add-qty/"+stockID,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response){
              if($.isEmptyObject(response.error)){
                var id = response[0].id;
                $("#inStock-"+id).html(response[0].in_stock);
                $("#cntInStock-"+id).html(response[0].ctn_in_stock);
                $("#purchaseQty-"+id).html(response[1].purchase_qty);
                $('#modal-qty').modal('hide');
                $("#addQtyForm")[0].reset();
                $('.error-text').text("");
              }
              else
              {
                  $('.error-text').text('');
                  printErrorMsgEdit(response.error);
              }
            },
        });

     });

     $('.closeModal').on('click', function(){
        $("#addQtyForm")[0].reset();
        $('.error-text').text("");
        $(".error").css("display","none");
      });

     function printErrorMsgEdit (msg) {
                $.each( msg, function( key, value ) {
                  $('.'+key+'_err_edit').text(value);
            });
        }
</script>
