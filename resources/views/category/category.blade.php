@extends('layouts.master_layout.master_layout')
@section('title', 'Categories')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                                        <a href="{{ route('categories.add') }}" title="Add New Category"
                                            class="btn btn-block btn-success"><i class="fas fa-plus"></i></a>
                                    </div>&nbsp
                                </div>
                            </div>
                        </div>
                        @if ($categories->count() > 0)
                            <div id="table_data">
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody tbody id="leadsTable">

                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td><b>{{ $category->id }}</b></td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->description }}</td>
                                                    <td>
                                                        <form action="{{ route('category-delete', $category->id) }}"
                                                            method="post" id="submit-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a title="Edit"
                                                                href="{{ route('edit.category', $category->id) }}"><i
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
                                <p>No records found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Toaster --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Toaster
        @if (Session::has('status'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('status') }}");
        @endif
    </script>
@endsection
