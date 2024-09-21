@extends('layouts.master_layout.master_layout')
@section('title', 'Change Profile')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Profile Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Change Profile Information</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">

            {{-- </div> --}}
            <form method="POST" action="{{ url('update-profile', ['id' => $user->id]) }}">
                @csrf
                @method('put')
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Edit User Form</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>Name:</label>
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                            required>
                                    </div>
                                    @error('name')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="roles"><span style="color: red;">* </span>E-Mail:</label>
                                    <input type="text" name="email" value="{{ $user->email }}" class="form-control"
                                        readonly>
                                    @error('email')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">* </span>Password:</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter User Password">
                                    @error('password')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">* </span>Confirm Password:</label>
                                    <input type="password" name="confirm_password" class="form-control"
                                        placeholder="Confirm Password">
                                    @error('confirm_password')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact No:</label>
                                    <input type="number" name="contact" class="form-control" value="{{ $user->contact }}"
                                        placeholder="Enter Contact Number">
                                    @error('contact')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CNIC No:</label>
                                    <input type="text" name="cnic" class="form-control" value="{{ $user->cnic }}"
                                        placeholder="Enter CNIC Number">
                                    @error('cnic')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Salary:</label>
                                    <input type="number" name="salary" class="form-control" value="{{ $user->salary }}"
                                        placeholder="Enter Current Salary">
                                    @error('salary')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;">* </span>User Role:</label>
                                    <select name="role_as" class="form-control" id="role_as" required>
                                        <option value="" selected>Select Booker</option>
                                        <option value="admin" {{ $user->role_as == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="employee" {{ $user->role_as == 'employee' ? 'selected' : '' }}>
                                            Employee</option>
                                    </select>
                                    @error('role_as')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
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
        </div>
    </section>
    
    <section class="content">
    
    <div class="container-fluid">
        <div class="col-md-6">
            
        {{-- </div> --}}
    <div class="card card-info">
        <div class="card-header" style="display: flex; align-items: center;">
            <i class="fas fa-chart-pie" style="margin-right: 0.5rem;"></i>
            <h3 class="card-title" style="margin: 0;">Change Application Name</h3>
        </div>
            
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('change-app-name') }}">
            @csrf
            @method('POST')
          <div class="card-body">
            <div class="form-group row">
              <label for="AppName" class="col-md-3 col-form-label">Enter New Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="app_name" id="AppName" placeholder="Enter Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="confirm_password" class="col-md-3 col-form-label">Confirm Password</label>
              <div class="col-md-9">
                <input type="password" class="form-control" id="confirm_password" name="password" placeholder="Enter Password">
              </div>
            </div>
           
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-info float-right">
                <i class="fas fa-save mr-1"></i> Save Name
            </button>
          </div>
          <!-- /.card-footer -->
        </form>
      </div>
      </div>
      </div>
    </section>

@push('scripts')
    @if (Session::has('success'))
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false,
                    "title": 'Success',
                    "escapeHtml": false, // Allow HTML in the message
                };

                toastr.success('{{ Session::get('success') }}', 'Success');
            });
        </script>
    @elseif (Session::has('error'))
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false,
                    "title": 'Error',
                    "escapeHtml": false, // Allow HTML in the message
                };

                toastr.error('{{ Session::get('error') }}', 'Error');
            });
        </script>
    @endif
@endpush


@endsection
