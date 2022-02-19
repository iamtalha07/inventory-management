
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('css/admin_css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">
      <!-- DataTables -->
      <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    {{-- toaster --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  </head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> Ahsan Traders
                 
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <br>
            <!-- info row -->
            <div class="row invoice-info">
              {{-- <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong>Admin, Inc.</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (804) 123-5432<br>
                  Email: info@almasaeedstudio.com
                </address>
              </div> --}}
              <div class="col-sm-5 invoice-col">
                <div class="well">
                  <ul class="list-unstyled mb0">
                      <li><strong>Customer Name:</strong> {{$invoice->customer_name}}</li>
                      <li><strong>Booker Name:</strong> {{$invoice->booker->booker_name}}</li>
                      <li><strong>Area Name:</strong> {{$invoice->area_name}}</li>
                  </ul>
              </div>
              </div>

              <div class="col-sm-4 invoice-col">
                <div class="well">
                  <ul class="list-unstyled mb0">
                      <li><strong>Invoice</strong> #{{$invoice->id}}</li>
                      <li><strong>Date:</strong> {{$invoice->created_at->format('m/d/Y')}}</li>
                      <li><strong>Time:</strong> {{ $invoice->created_at->format('g:i A')}}</li>
                  </ul>
              </div>
              </div>
              {{-- <div class="col-sm-4 invoice-col">
                <b>Invoice: {{$invoice->id}}</b><br>
                <b>Customer Name:</b> {{$invoice->customer_name}}<br>
                <b>Booker Name:</b> {{$invoice->booker->booker_name}}<br>
                <b>Salesman Name:</b> {{$invoice->salesman_name}} <br>
                <b>Area Name:</b> {{$invoice->area_name}}
              </div> --}}
              <!-- /.col -->
              {{-- <div class="col-sm-4 invoice-col">
                To
                <address>
                  <strong>John Doe</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (555) 539-1037<br>
                  Email: john.doe@example.com
                </address>
              </div> --}}
              <!-- /.col -->
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Disc%</th>
                    <th>Amount</th>

                  </tr>
                  </thead>
                  @foreach($invoice->invoiceProduct as $product)
                  <tbody>
                  <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->qty}}</td>
                    <td>Rs.{{$product->sale_rate}}</td>
                    <td>{{$product->pivot->disc}}</td>
                    <td>Rs.{{$product->pivot->amount}}</td>
                  </tr>
                  </tbody>
                  @endforeach
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <div>
                  <table class="table">
                    <tr>
                      <th>Salesman Name:</th>
                      <td>{{$invoice->salesman_name}}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-6">
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th>Total:</th>
                      <td>Rs.{{$invoice->total}}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->

          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>

