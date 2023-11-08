<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .delBtn {
        border: none;
        background: none;
        margin-left: -7px;
    }
</style>
<div class="card-body">
    <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Type</th>
                <th>Sold Quantity</th>
                <th>Returned Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody tbody id="leadsTable">
            @foreach ($data as $invoice)
            @foreach ($invoice->invoiceReturnProduct as $salesReturn)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->customer_name }}</td>
                @foreach ($invoice->invoiceProduct as $invoiceProduct)

                    @if ($invoiceProduct->pivot->product_id == $salesReturn->product_id)
                        <td>{{ $invoiceProduct->name }}</td>
                        <td>{{ $invoiceProduct->pivot->product_type }}</td>
                        <td>{{ $invoiceProduct->pivot->qty ? $invoiceProduct->pivot->qty : $invoiceProduct->pivot->ctn_qty}}</td>
                    @endif
                @endforeach
                <td>{{ $salesReturn->quantity_returned }}</td>
                <td>{{ $salesReturn->return_date }}</td>
            </tr>
            @endforeach
            @endforeach

        </tbody>
    </table>
    <div class="float-right">
        {!! $data->links() !!}
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- DataTable --}}
<script>
    $(document).ready(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
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

        $("input[type=checkbox]").on("change", function() {
            if ($("input[type=checkbox]:checked").length > 0) {
                $("#deleteAllSelectedRecords").removeAttr('disabled', 'disabled');
                $(".deletedClass").hide();
            } else {
                $("#deleteAllSelectedRecords").attr('disabled', 'disabled');
            }
        });

        $("#chkCheckAll").click(function() {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });
    });
</script>
