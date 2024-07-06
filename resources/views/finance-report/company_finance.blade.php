@extends('layouts.master_layout.master_layout')
@section('title','Financial Report')
@section('content')
<style>
    .color-palette {
  height: 35px;
  line-height: 35px;
  text-align: right;
  padding-right: .75rem;
}

.color-palette.disabled {
  text-align: center;
  padding-right: 0;
  display: block;
}

.color-palette-set {
  margin-bottom: 15px;
}

.color-palette span {
  display: none;
  font-size: 12px;
}

.color-palette:hover span {
  display: block;
}

.color-palette.disabled span {
  display: block;
  text-align: left;
  padding-left: .75rem;
}

.color-palette-box h4 {
  position: absolute;
  left: 1.25rem;
  margin-top: .75rem;
  color: rgba(255, 255, 255, 0.8);
  font-size: 12px;
  display: block;
  z-index: 7;
}
.amount-stat{
    font-size: 18px !important;
}
</style>

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Company Invoices</h1>
        <div class="row mt-1">
            <div class="col-md-12" >
                <span style="font-size: 17px;">{{isset($brand_id) ? 'Company Invoice Status' : 'Overall Invoice Status'}}:</span>
                  <a class="btn btn-{{ $balanceExists == true ? 'warning' : 'success' }} btn-sm ml-3" style="color: white; cursor: default;">{{ $balanceExists == true ? 'Dues Outstanding' : 'Dues Resolved' }}</a>
            </div>
        </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active">Company Invoices</li>
            </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>

{{-- new section --}}
<section class="content">
    <div class="container-fluid">
        <x-finance_component.finance-navigation />
                <div class="row">
                    <div class="col-12">
                        <div class="card card-default color-palette-box">
                            <div class="card-header">
                                <h3 class="card-title titleclass">Stats & Controls</h3>
                                {{-- <div class="card-tools">
                                    <div class="row">
                                      
                                    </div>
                                </div> --}}
                            </div>
                    {{-- content here --}}
                  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                {{-- <p style="text-align: left">Overall Status</p> --}}
                            <form action="{{ route('filtered-invoicing') }}" method="GET">
                                <div class="row">
                                 {{-- Filtering items shall be placed here --}}
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-size: 16px;">Company/Brand:</label>
                                            <div class="input-group">
                                                {{-- <select name="brand" class="form-control form-control-sm"> --}}
                                                <select name="brand" class="form-control form-control">
                                                    <option value="" selected="true" disabled="true">Select Brand</option>
                                                    @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ isset($brand_id) && $brand->id == $brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                      </div>
                                  </div>
                                  {{-- Search Button --}}
                                  <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="submit"></label>
                                        <button type="submit" class="btn btn-success search-btn" style="margin-top: 3px"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                    
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="row mb-1">

                                </div>
                           
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="text-center bg-info"><strong>Total Invoicing Value</strong></h4>
                                        <div class="color-palette-set">
                                        <div class="bg-info color-palette"><span></span></div>
                                        <div class="bg-info disabled color-palette"><span class="amount-stat"><strong>Rs. {{ number_format($values['total_billed']) }}</strong></span></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <h4 class="text-center bg-olive"><strong>Total Amount Paid</strong></h4>
                                        <div class="color-palette-set">
                                        <div class="bg-olive color-palette"><span></span></div>
                                        <div class="bg-olive disabled color-palette"><span class="amount-stat"><strong>Rs. {{ number_format($values['total_paid']) }}</strong></span></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <h4 class="text-center"><strong>Total Outstanding Balance</strong></h4>
                                        <div class="color-palette-set">
                                        <div class="bg-danger color-palette"><span></span></div>
                                        <div class="bg-danger disabled color-palette"><span class="amount-stat"><strong>Rs. {{ number_format($values['outstanding_balance']) }}</strong></span></div>
                                        </div>
                                    </div>
                        
                                </div>
                                {{-- Amount Payable & Receivable --}}
                                @if(isset($account) == true)
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="text-center"><strong>Amount Payable</strong></h4>
                                        <div class="color-palette-set">
                                            <div class="bg-danger color-palette"><span></span></div>
                                            <div class="bg-danger disabled color-palette" style="height: 50px;"><span class="amount-stat" style="padding-top: 0.5rem;"><strong>Rs. {{ number_format(isset($account['payable']) ? $account['payable'] : 0) }}</strong></span></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-center"><strong>Amount Receivable</strong></h4>
                                        <div class="color-palette-set">
                                            <div class="bg-olive color-palette"><span></span></div>
                                            <div class="bg-olive disabled color-palette" style="height: 50px;"><span class="amount-stat" style="padding-top: 0.5rem;"><strong>Rs. {{ number_format(isset($account['receivable']) ? $account['receivable'] : 0) }}</strong></span></div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
     
</div>
</section>
{{-- new section --}}

<section class="content">
  <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title titleclass">Billing Transaction History</h3>
                            <div class="card-tools">
                                <div class="row">
                                    <div class="input-group input-group-sm" style="width: 50px;">
                                        <a href="{{ route('add-finance') }}" title="Add New Record"
                                            class="btn btn-block btn-success"><i class="fas fa-plus"></i></a>
                                    </div>&nbsp
                                </div>
                            </div>
                        </div>
                        @if ($bill_records->count() > 0)
                            <div id="table_data">
                                <div class="card-body">
                                    <table id="example2" class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Bill number</th>    
                                                <th>Billed Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Adjusted Amount</th>
                                                <th>Bill Date</th>
                                                <th>Payment Date</th>
                                                {{-- <th>Remarks</th> --}}
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody tbody id="leadsTable">
                                            @foreach ($bill_records as $item)
                                                <tr>
                                                    <td><b>{{ $item->id }}</b></td>
                                                    <td>{{ $item->brand->name }}</td>
                                                    <td>{{ $item->category->name }}</td>
                                                    <td>{{ $item->bill_no }}</td>
                                                    <td>{{ $item->billed_amount }}</td>
                                                    <td>{{ $item->amount_paid }}</td>
                                                    <td>{{ $item->adjusted_amount }}</td>
                                                    <td>{{ $item->billed_date }}</td>
                                                    <td>{{ $item->payment_date }}</td>
                                                    {{-- <td>{{ $item->remarks }}</td> --}}
                                                    <td style="display: flex; width: max-content">
                                                        <form action="{{ route('ledger-record-delete', $item->id) }}" method="post" id="submit-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a title="View Bill Details" href="{{ route('get-bill-detail', $item->id) }}"><i class="fa fa-eye my-icon"></i></a>&nbsp;
                                                            <a title="Edit" href="{{ route('edit-ledger', $item->id) }}"><i class="fa fa-edit my-icon"></i></a>&nbsp;
                                                            <button title="Delete" type="submit" class="delBtn" style="color: #007bff;" onclick="return confirm('Are you sure?')"><i class="fa fa-trash my-icon"></i></button>
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
