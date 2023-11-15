@extends('layouts.master_layout.master_layout')
@section('title', 'Sales Return')
@section('content')

    <style>
        .label-color {
            color: #007bff;
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Return Request For Invoice # {{ $invoice->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoice # {{ $invoice->id }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Invoice Details</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-user"></i> Customer:</strong>
                            <strong><span class="float-right label-color">{{ $invoice->customer_name }}</span></strong>
                            <hr />
                            <strong><i class="fas fa-calendar-day"></i>
                                Date:</strong>
                            <strong><span
                                    class="float-right label-color">{{ $invoice->created_at->format('m/d/Y') }}</span></strong>
                            <hr />
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Area Name:</strong>
                            <strong><span class="float-right label-color">{{ $invoice->area_name }}</span></strong>
                            <hr />
                            <strong><i class="fas fa-user-tie"></i> Booker:</strong>
                            <strong><span
                                    class="float-right label-color">{{ $invoice->booker->booker_name }}</span></strong>
                            <hr />

                            <strong><i class="fas fa-user"></i>
                                Salesman:</strong>
                            <strong><span class="float-right label-color">{{ $invoice->salesman_name }}</span></strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <form action="{{ route('sales-return.store') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <table class="table table-bordered" id="table_id">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product</th>
                                                <th>Type</th>
                                                <th>Purchased Quantity</th>
                                                <th>Return Quantity</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" name="invoice_id" class="form-control"
                                            value="{{ $invoice->id }}">
                                        <tbody id="productRow">
                                            @foreach ($invoice->invoiceProduct as $product)
                                                <tr class="row_id">
                                                    <td><input type="checkbox" class="enable-fields-checkbox"></td>
                                                    <td style="display: none"><input type="text" name="product_id[]" class="form-control requestField"
                                                        value="{{ $product->id }}" disabled></td>
                                                    <td><input type="text" name="product_name[]" class="form-control"
                                                            value="{{ $product->name }}" disabled></td>
                                                    <td><input type="text" name="type[]" id="type" class="form-control"
                                                            value="{{ $product->pivot->product_type }}" disabled></td>
                                                    <td><input type="text" name="qty[]" class="form-control qty"
                                                            value="{{ $product->pivot->qty ? $product->pivot->qty : $product->pivot->ctn_qty  }}" disabled></td>
                                                    <td><input type="number" name="quantity_returned[]" class="form-control requestField"
                                                            value="0" min="0" disabled></td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <!-- /.col -->
                                </div>
                                <div class="form-group">
                                    <label>Reason:</label>
                                    <input type="text" name="reason" class="form-control" value=""
                                        placeholder="Return for returning">
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" name="submit"
                                            class="btn btn-primary float-right">Return</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function () {
            $('.enable-fields-checkbox').change(function () {
                var $row = $(this).closest('.row_id');
                var $fieldsToEnable = $row.find('.requestField'); // Select all inputs with class 'requestField'
                var $quantityReturned = $row.find('input[name="quantity_returned[]"]');
                var $qty = $row.find('input[name="qty[]"]');
                var isChecked = $(this).is(':checked');

                // Enable or disable the fields with class 'requestField' based on the checkbox state
                $fieldsToEnable.prop('disabled', !isChecked);

                // Toggle the 'readonly' and 'disabled' properties for the 'type' field based on the checkbox state
                var $typeField = $row.find('#type');
                if (isChecked) {
                    $typeField.prop('readonly', true);
                    $typeField.prop('disabled', false);
                } else {
                    $typeField.prop('readonly', false);
                    $typeField.prop('disabled', true);
                }

                // Handle the validation
                if (isChecked) {
                    $quantityReturned.on('input', function () {
                        var quantityReturned = parseFloat($quantityReturned.val());
                        var qty = parseFloat($qty.val());

                        if (quantityReturned > qty) {
                            alert('Quantity returned cannot be greater than purchased quantity.');
                            $quantityReturned.val(qty);
                        }
                    });
                } else {
                    $quantityReturned.off('input'); // Remove the input event handler
                }
            });
        });
    </script>


@endsection
