<div class="card-body">
    <table id="example2" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Date</th>
        <th>Remarks</th>
      </tr>
      </thead>
      <tbody tbody id="leadsTable">
        @foreach($data as $item) 
      <tr>
        <td><b>{{$item->id}}</b></td>
        <td>{{$item->product->name}}</td>
        <td>{{$item->created_at->format('d/m/Y')}}</td>
        <td>{{$item->remarks}}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
    <div class="float-right">
      {!! $data->links() !!}
      </div>
  
  </div>
  
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
  </script>