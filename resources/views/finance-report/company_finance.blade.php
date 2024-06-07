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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title titleclass">Account Finance Reporting Section</h3>
                            <div class="card-tools">
                                <div class="row">
                                    <div class="input-group input-group-sm" style="width: 50px;">
                                        <a href="{{ route('categories.add') }}" title="Add New Category"
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
                                                        <form action="{{ route('category-delete', $account->id) }}"
                                                            method="post" id="submit-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a title="Edit"
                                                                href="{{ route('edit.category', $account->id) }}"><i
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

@endsection