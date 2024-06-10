@extends('layouts.master_layout.master_layout')
@section('title','Financial Report')
@section('content')

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Financial Report Section</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Financial Report Section</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
      <x-finance_component.finance-navigation />
      {{-- CODE HERE --}}
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">

        </div>
        <!-- /.col -->
        <div class="col-6">
            <div class="table-responsive">
                <table class="table">
              
                        <tr>
                            <th>Total Receivable:</th>
                            <td>Rs. Data here</td>
                        </tr>
                        <tr>
                            <th>Outstanding Balance:</th>
                            <td>Rs. Data here</td>
                        </tr>
                        <tr>
                            <th>Outstanding Balance:</th>
                            <td>Rs. Data here</td>
                        </tr>
                   
                
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
      {{-- record here --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title titleclass">Ledger Transaction Section</h3>
                            <div class="card-tools">
                                <div class="row">
                                    <div class="input-group input-group-sm" style="width: 50px;">
                                        <a href="{{ route('add-finance') }}" title="Add New Record"
                                            class="btn btn-block btn-success"><i class="fas fa-plus"></i></a>
                                    </div>&nbsp
                                </div>
                            </div>
                        </div>
                        @if ($accounts->count() > 0)
                            <div id="table_data">
                                <div class="card-body">
                                    <table id="example2" class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Brand</th>
                                                <th>Bill number</th>
                                                <th>Products</th>
                                                <th>Total Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Amount Remaining</th>
                                                <th>Payable By</th>
                                                <th>Payable To</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody tbody id="leadsTable">

                                            @foreach ($accounts as $account)
                                                <tr>
                                                    <td><b>{{ $account->id }}</b></td>
                                                    <td>{{ $account->brand_id }}</td>
                                                    <td>{{ $account->bill_no }}</td>
                                                    <td>{{ $account->product_name }}</td>
                                                    <td>{{ $account->total_amount }}</td>
                                                    <td>{{ $account->amount_paid }}</td>
                                                    <td>{{ $account->amount_remaining }}</td>
                                                    <td>{{ $account->payable_by }}</td>
                                                    <td>{{ $account->payable_to }}</td>
                                                    <td>
                                                        <form action="{{ route('ledger-record-delete', $account->id) }}"
                                                            method="post" id="submit-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a title="Edit"
                                                                href="{{ route('edit-ledger', $account->id) }}"><i
                                                                    class="fa fa-edit"></i></a>&nbsp
                                                            &nbsp
                                                            <button title="Delete" type="submit" class="delBtn"
                                                                style="color: #007bff;"
                                                                onclick="return confirm('Are you sure?')"> <i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <p style="text-align: center">No records found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
   
    </div>
</section>
@push('scripts')
<script>
    // Toaster
    @if (Session::has('success'))
    toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('success') }}");
    @endif
    @if (Session::has('error'))
    toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    @endif
</script>
@endpush
@endsection
