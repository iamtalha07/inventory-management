<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .delBtn{
      border: none;
      background: none;
      margin-left: -7px;
  }
</style>
<div class="card-body">
  <table id="example2" class="table table-bordered table-hover">
    <thead>
    <tr>
      <th><input type="checkbox" name="Accept" id="chkCheckAll"></th>
      <th>ID</th>
      <th>Name</th>
      <th>Purchase Qty</th>
      <th>Purchase Rate</th>
      <th>Sale Rate</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody tbody id="leadsTable">
      @foreach($data as $item) 
    <tr id="product-{{$item->id}}">
      <td><input type="checkbox" name="ids" id="checkboxId{{$item->id}}" class="checkBoxClass" value="{{$item->id}}"></td>
      <td><b>{{$item->id}}</b></td>
      <td>{{$item->name}}</td>
      <td>{{$item->purchase_qty}}</td>
      <td>Rs.{{$item->purchase_rate}}</td>
      <td>Rs.{{$item->sale_rate}}</td>
      <td>
        <form action="{{route('product-delete', $item->id)}}" method="post" id="submit-form">
          @csrf
          @method('DELETE')
        <a title ="Edit" href="{{route('product/edit-product',$item->id)}}"><i class="fa fa-edit"></i></a>&nbsp &nbsp
        <a title ="Log" href="{{route('product/log',$item->id)}}"><i class="fas fa-list"></i></a>&nbsp &nbsp
        <button title="Delete" type="submit" class="delBtn"  style="color: #007bff;" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i></button>
        </form>
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  <div class="float-right">
    {!! $data->links() !!}
    </div>

</div>

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
  });
</script>
