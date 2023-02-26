@extends('layouts.master_layout.master_layout')
@section('title', 'Stock')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stock</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
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
                            <div class="input-group" style="width: 241px; float: left;">
                                <select name="category_id" class="form-control" id="category_filter" required>
                                    <option value="" selected="true">All</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == request()->route('category_id') ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p style="color:red">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if ($data->count() > 0)
                            <div id="table_data">
                                @include('stock.stock_table')
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

    <script>
        // Toaster
        @if (Session::has('status'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('status') }}");
        @endif


        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                var pagetitle = $('.titleclass').text();
                var selectedCategory = $('#category_filter').val();
                $.ajax({
                    url: "/stock_pagination/fetch_data?page=" + page,
                    data: {
                        title: pagetitle,
                        category_id: selectedCategory
                    },
                    success: function(data) {
                        $("#deleteAllSelectedRecords").attr('disabled', 'disabled');
                        $('#table_data').html(data);
                    }
                });
            }

            $('#category_filter').on('change', function() {
                var accesslevel_id = $(this).val();
                var url = '{{ route('stock', ':id') }}';
                url = url.replace(':id', accesslevel_id);
                window.location.href = url;
            });

        });
    </script>
@endsection
