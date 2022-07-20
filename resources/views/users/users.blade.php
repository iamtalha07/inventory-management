@extends('layouts.master_layout.master_layout')
@section('title','Users')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                            <th>Contact No</th>
                            <th>Salary</th>
                            <th>CNIC</th>
                            <th>Role</th>
                            <th>Actions</th>
                          </tr>
                          </thead>
                          <tbody tbody id="leadsTable">

                        @foreach($users as $item) 
                          <tr>
                            <td><b>{{$item->id}}</b></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->contact}}</td>
                            <td>{{$item->salary?'Rs.':''}}{{$item->salary}}</td>
                            <td>{{$item->cnic}}</td>
                            <td>{{ucfirst($item->role_as)}}</td>
                            <td>
                              <form action="{{route('user-delete', $item->id)}}" method="post" id="submit-form">
                                @csrf
                                @method('DELETE')
                              <a title ="Edit" href="{{route('user/edit-user',$item->id)}}"><i class="fa fa-edit"></i></a>&nbsp &nbsp
                              @if(Auth::user()->id != $item->id)
                              <button title="Delete" type="submit" class="delBtn"  style="color: #007bff;" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i></button>
                              @endif
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
                  <p>No records found</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
    </section>

{{-- Toaster --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // Toaster
    @if(Session::has('status'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
      toastr.success("{{ session('status') }}");
    @endif
</script>
@endsection