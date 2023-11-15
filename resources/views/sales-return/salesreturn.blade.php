@extends('layouts.master_layout.master_layout')
@section('title', 'Sales Return')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Initiate Sales Return</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Initiate Sales Return</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <form method="GET" action="{{ route('sales-return-search') }}">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Search Invoice</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="roles">User Name:</label>
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                                            class="form-control" placeholder="Enter Category Name" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span style="color: red;">* </span>
                                    <label>Search By Invoice ID:</label>
                                    <input type="text" name="invoiceId" value="{{ old('name') }}"
                                    class="form-control" placeholder="Search Invoice" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary float-right">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Toaster
        @if(Session::has('status'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
          toastr.error("{{ session('status') }}");
        @endif
    </script>


@endsection
