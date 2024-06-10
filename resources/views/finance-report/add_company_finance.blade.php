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
            <li class="breadcrumb-item active">Add Transaction Ledger</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
      <x-finance_component.finance-navigation />
            <form method="POST" action="{{route('save-ledger')}}">
                @csrf
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Add Finance Ledger</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <!-- Select brand -->
                                <div class="form-group">
                                  <label>Select brand</label>
                                  <select class="form-control" name="brand_id">
                                    @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{ $brand->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <!-- Bill Number -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Enter Bill no:</label>
                                    <div class="input-group">
                                        <input type="text" name="bill_no" value="{{ old('bill_no') }}" class="form-control"
                                            placeholder="Bill number here" autocapitalize="on" required>
                                    </div>
                                    @error('bill_no')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Product Name -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="roles">Products:</label>
                                    <div class="input-group">
                                        <input type="text" name="products" value="{{ old('products') }}" class="form-control"
                                            placeholder="Enter Products" required>
                                    </div>
                                    @error('products')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Bill Date:</label>
                                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                          <input type="text" name="bill_date" placeholder="Enter Date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                          </div>
                                      </div>
                                  </div>
                            </div>
                        </div>
                        <!-- Total Amount -->
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Total Amount:</label>
                                    <div class="input-group">
                                        <input type="number" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" class="form-control"
                                            placeholder="Enter Total Amount" required>
                                            <div class="input-group-append" data-target="#total_amount">
                                                <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                                            </div>
                                    </div>
                                    @error('total_amount')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Paid Amount -->
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Amount Paid:</label>
                                    <div class="input-group">
                                        <input type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid') }}" class="form-control"
                                            placeholder="Enter Paid Amount" required>
                                            <div class="input-group-append" data-target="#amount_paid">
                                                <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                                            </div>
                                    </div>
                                    @error('amount_paid')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Remaining Amount/Balance -->
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Amount Remaining:</label>
                                    <div class="input-group">
                                        <input type="number" name="amount_remaining" id="amount_remaining" value="{{ old('amount_remaining') }}" class="form-control"
                                            placeholder="Enter Balance Amount" required>
                                            <div class="input-group-append" data-target="#amount_remaining">
                                                <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                                            </div>
                                    </div>
                                    @error('amount_remaining')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Payable By -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Payable By:</label>
                                    <div class="input-group">
                                        <input type="text" name="payable_by" value="{{ old('payable_by') }}" class="form-control"
                                            placeholder="Payment made by" required>
                                    </div>
                                    @error('payable_by')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Payable To -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Payable To:</label>
                                    <div class="input-group">
                                        <input type="text" name="payable_to" value="{{ old('payable_to') }}" class="form-control"
                                            placeholder="Payment made to" required>
                                    </div>
                                    @error('payable_to')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="roles">Remarks:</label>
                                <div class="input-group">
                                    <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control"
                                        placeholder="Enter remarks or leave it empty" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
   
    </div>
</section>

<script>
   $(function () {
           $('#reservationdate').datetimepicker({
               format: 'DD-MM-YYYY'
           });
       });
</script>

@endsection