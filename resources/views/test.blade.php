
Conversation opened. 1 read message.

Skip to content
Using Advanced Research Projects and Technologies Private Limited Mail with screen readers
in:sent 
5 of 53
(no subject)
Inbox

Talha Bin Ishaq <talha.ishaq@arpatech.com>
Tue, Feb 1, 11:53 AM (4 days ago)
to me

@extends('layouts.admin_layout.admin_layout')
@section('title','ArpatechCRM | Create Lead')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Lead</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Create Lead</li>
                </ol>
                </div>
            </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Create New Lead</h3>
            
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
              
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="testcheckbox" method="POST">
                        @csrf
                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input radio" type="radio" id="customRadio1" name="customRadio" value="noDiscount" checked>
                                    <label for="customRadio1" class="custom-control-label">No Discount</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input radio" type="radio" id="customRadio2" name="customRadio" value="cashDiscount">
                                    <label for="customRadio2" class="custom-control-label">Discount by cash</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input radio" type="radio" id="customRadio3" name="customRadio" value="perDiscount">
                                    <label for="customRadio3" class="custom-control-label">Discount by percentage</label>
                                  </div>
                              </div>
                        </div>


                        <div class="col-md-6">
                          <div class="form-group">
                              <div id="cashdiv">
                              <label for="roles"><span style="color: red;">* </span>Cash:</label>
                              <input type="text" class="form-control" name="cash" id="cash">
                            </div>

                            <div id="perdiv">
                              <label for="roles"><span style="color: red;">* </span>Percentage:</label>
                              <input type="text" class="form-control" name="percentage" id="per">
                            </div>
                        </div>
                      </div>
            
                        <!-- /.col -->


                        <!-- /.col -->
                        </div>


                </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-12">

                        <button type="submit" name="submit" class="btn btn-primary float-right submitBtn">Submit</button>
                     
                   
                        <button type="submit" name="draft" class="btn btn-info float-right submitBtn" style="margin-right: 5px;">Drafts</button>

                        </div>
                        </div>
                    </div>
                </form>
               
            </div>





        </div>
        </section>


    </div>

<script>
    //ENABLING AND DISABLING START
    // $('.radio').click(function(e) {
    //     var val = $(this).val();
    //         if(val=="cashDiscount")
    //         {
    //             $('#cash').removeAttr('disabled');
    //             $('#per').attr('disabled','disabled'); 

    //         }
    //         else if(val=="perDiscount")
    //         {
    //             $('#per').removeAttr('disabled');
    //             $('#cash').attr('disabled','disabled'); 

    //         }
    //         else
    //         {
    //             $('#cash').attr('disabled','disabled');
    //             $('#per').attr('disabled','disabled'); 
    //         }
    // });
    //ENABLING AND DISABLING END

    $(function(){
        $('#cashdiv').hide();
        $('#perdiv').hide();

            $('.radio').click(function(e) {
            var val = $(this).val();
                if(val=="cashDiscount")
                {
                    $('#cashdiv').show();
                    $('#perdiv').hide();
                    $('#per').val('');

                }
                else if(val=="perDiscount")
                {
                    $('#cashdiv').hide();
                    $('#perdiv').show();
                    $('#cash').val('');


                }
                else
                {
                    $('#cashdiv').hide();
                    $('#perdiv').hide();
                    $('#cash').val('');
                    $('#per').val('');
                }
        });
    });

</script>

@endsection
