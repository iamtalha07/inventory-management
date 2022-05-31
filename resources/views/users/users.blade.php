@extends('layouts.master_layout.master_layout')
@section('title','Users')
@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"> 
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title titleclass">All</h3>
                  <div class="card-tools">
                    <div class="row">
                    <div class="input-group input-group-sm" style="width: 50px;">
                      <a href="{{route('user.add')}}" title="Add New User" class="btn btn-block btn-success"><i class="fas fa-plus"></i></a>
                    </div>&nbsp
                    </div>
                  </div>
                </div>
                @if($users->count() > 0)
                <div id="table_data">
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody tbody id="leadsTable">

                        @foreach($users as $item) 
                          <tr>
                            <td><b>{{$item->id}}</b></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->role_as}}</td>
                            <td>
                              {{-- <form action="{{route('product-delete', $item->id)}}" method="post" id="submit-form"> --}}
                                @csrf
                                @method('DELETE')
                              <a title ="Edit" href=""><i class="fa fa-edit"></i></a>&nbsp &nbsp
                              <a title ="Log" href=""><i class="fas fa-list"></i></a>&nbsp &nbsp
                              <button title="Delete" type="submit" class="delBtn"  style="color: #007bff;" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i></button>
                              {{-- </form> --}}
                            </td>
                          </tr>
                        @endforeach
                          </tbody>
                        </table>                      
                      </div>
                </div>
                @else
                <div class="card-body">
                  <p>No records found</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
    </section>

@endsection