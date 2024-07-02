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
            <li class="breadcrumb-item active">Edit Finance Ledger</li>
        </ol>
        </div>
     </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
      <x-finance_component.finance-navigation />
      {{-- <span><p>*. This section</p></span> --}}
            <form method="POST" action="{{ url('update-ledger', ['id' => $account->id]) }}">
                @csrf
                @method('post')
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Company Invoice</h3>
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
                                  <select class="form-control" name="brand_id" id="brand_id">
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $brand->id == $account->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <!-- Select Category -->
                                <div class="form-group">
                                    <label>Select Category</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <!-- Categories will be populated dynamically via Ajax -->
                                        <option value="{{ $account->category_id }}">{{ $account->category->name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Bill Number -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Enter Bill no:</label>
                                    <div class="input-group">
                                        <input type="text" name="bill_no" value="{{ $account->bill_no }}" class="form-control"
                                            placeholder="Bill number here" autocapitalize="on" required>
                                    </div>
                                    @error('bill_no')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Bill Date:</label>
                                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                          <input type="text" name="bill_date" value="{{ $account->billed_date }}" placeholder="Enter Date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                          </div>
                                      </div>
                                  </div>
                            </div>

                            <!-- Description -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="roles">Description:</label>
                                    <div class="input-group">
                                        <input type="text" name="description" value="{{ $account->description }}" class="form-control"
                                            placeholder="Enter description" required>
                                    </div>
                                    @error('description')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    
                
                        <!-- Billed Amount -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Billed Amount:</label>
                                    <div class="input-group">
                                        <input type="number" name="billed_amount" id="billed_amount" value="{{ $account->billed_amount }}" class="form-control"
                                            placeholder="Enter Total Amount" required>
                                            <div class="input-group-append" data-target="#billed_amount">
                                                <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                                            </div>
                                    </div>
                                    @error('billed_amount')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Paid Amount -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Amount Paid:</label>
                                    <div class="input-group">
                                        <input type="number" name="amount_paid" id="amount_paid" value="{{ $account->amount_paid }}" class="form-control"
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Balance:</label>
                                    <div class="input-group">
                                        <input type="number" name="balance" id="balanceID" value="{{ $account->adjusted_amount }}" class="form-control"
                                            placeholder="Enter Balance Amount" readonly required>
                                            <div class="input-group-append" data-target="#balance">
                                                <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                                            </div>
                                    </div>
                                    @error('balance')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                                <!-- Date -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Payment Date:</label>
                                        <div class="input-group date" id="payment_date" data-target-input="nearest">
                                            <input type="text" name="payment_date" placeholder="Enter Date" value="{{ $account->payment_date }}" class="form-control datetimepicker-input" data-target="#payment_date"/>
                                            <div class="input-group-append" data-target="#payment_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('payment_date')
                                        <p style="color:red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                        </div>
 
                        <!-- Remarks -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="roles">Remarks:</label>
                                    <div class="input-group">
                                        <input type="text" name="remarks" value="{{ $account->remarks }}" class="form-control"
                                            placeholder="Enter remarks or leave it empty">
                                    </div>
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
    $('#reservationdate, #payment_date').datetimepicker({
        format: 'DD-MM-YYYY'
    });
});

// Another Script..

// Get input fields
var billedAmountInput = document.getElementById('billed_amount');
    var amountPaidInput = document.getElementById('amount_paid');
    var balanceInput = document.getElementById('balanceID');

    // Function to calculate balance
    function calculateBalance() {
        var billedAmount = parseInt(billedAmountInput.value) || 0; // Convert to integer or default to 0 if empty or non-numeric
        var amountPaid = parseInt(amountPaidInput.value) || 0; // Convert to integer or default to 0 if empty or non-numeric

        // Calculate balance
        var balance = billedAmount - amountPaid;

        // Update balance input field
        balanceInput.value = balance;
    }

    // Listner for Input 
    amountPaidInput.addEventListener('input', calculateBalance);
    billedAmountInput.addEventListener('input', calculateBalance);

    document.addEventListener('DOMContentLoaded', function() {

    // Listen for change event on brand select
    document.getElementById('brand_id').addEventListener('change', function() {
        var brandId = this.value;
        console.log("helo");
        
        fetch(`/get-category-brand/${brandId}`)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(categories) {
                var categorySelect = document.getElementById('category_id');

                // Clear existing options
                categorySelect.innerHTML = '';

                // Add new options
                categories.forEach(function(category) {
                    var option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(function(error) {
                console.error('Error fetching categories', error);
            });
    });
});
</script>

@endsection