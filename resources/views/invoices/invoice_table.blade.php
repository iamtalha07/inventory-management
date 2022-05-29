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
      <th>Customer Name</th>
      <th>Booker Name</th>
      <th>Salesman Name</th>
      <th>Area Name</th>
      <th>Status</th>
      <th>Total</th>
      <th>Actions</th>

    </tr>
    </thead>
    <tbody tbody id="leadsTable">
      @foreach($data as $item) 
    <tr id="invoice-{{$item->id}}">
      <td><input type="checkbox" name="ids" id="checkboxId{{$item->id}}" class="checkBoxClass" value="{{$item->id}}"></td>
      <td><b>{{$item->id}}</b></td>
      <td>{{$item->customer_name}}</td>
      <td>{{$item->booker->booker_name}}</td>
      <td>{{$item->salesman_name}}</td>
      <td>{{$item->area_name}}</td>
      <td id="status-{{$item->id}}"><span class="{{$item->status == 'Credit' ? 'badge bg-danger' : 'badge bg-success'}}">{{$item->status}}</span></td>
      <td>Rs.{{$item->total}}</td>
      <td>
        <form action="{{route('invoice-delete', $item->id)}}" method="post" id="submit-form">
          @csrf
          @method('DELETE')
        <a title ="Detail" href="{{route('invoice/detail',$item->id)}}"><i class="fa fa-eye"></i></a>&nbsp &nbsp
        {{-- <a title ="Change status" href="{{route('invoice/change-status',$item->id)}}"><i class="fas fa-exchange-alt"></i></a>&nbsp &nbsp --}}
        <a title ="Change status" id="{{$item->id}}" class="changeStatus" href="javascript:void(0)"><i class="fas fa-exchange-alt"></i></a>&nbsp &nbsp
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

    $(document).on('click','.changeStatus',function(){
        var id = $(this).attr('id');
        $.ajax({
            url:"invoice/change-status/"+id,
            dataType:"json",
            success:function(data)
            {
              if(data.status == 'Credit')
              {
                var status = '<span class="badge bg-danger">'+data.status+'</span>'
              }
              else{
                var status = '<span class="badge bg-success">'+data.status+'</span>'
              }
              $('#status-'+id).html(status);
              toastr.remove();
              toastr.options =
                {
                  "closeButton" : true,
                  "progressBar" : true
                }
  		          toastr.success("Status Updated Successfully");
            }
        })
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