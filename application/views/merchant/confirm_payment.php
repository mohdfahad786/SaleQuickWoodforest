<!DOCTYPE html>
<html>
<!-- Mirrored from coderthemes.com/minton/dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:36:17 GMT -->
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
     <title>Merchant | Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
     <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />

     
     <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
   
    <style>
        .card-box {
        padding: 50px;
      }


.noBorder {
  border: none;
}

      
    </style>
</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php $this->load->view('merchant/top'); ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
         <?php $this->load->view('merchant/menu'); ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
           
          

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                
                    <div class="card-box">
                        
                        <div class="row">
                             <div class="col-md-3">
                             </div>
                            <div class="col-md-8">
                               
                                 <h2 class="m-b-20" style=""> Confirm Payment  </h2>   
                           
<?php
  foreach($mem as $a_data)
{
 
  ?>

 


  <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Amount</strong></label>
                                        <div class="col-md-9">
                                           <span class="badge badge-success">$<?php echo $a_data['amount'] ?> </span>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Payment id</strong></label>
                                        <div class="col-md-9">
                                          <?php echo $a_data['invoice_no'] ?>


                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Owner Name</strong></label>
                                        <div class="col-md-9">
                                          <?php echo $a_data['name'] ?>


                                        </div>
                                    </div>


                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Mobile No</strong></label>
                                        <div class="col-md-9">
                                           <span class="badge badge-primary"><?php echo $a_data['mobile_no'] ?> </span>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Email</strong></label>
                                        <div class="col-md-9">
                                           <span class="badge badge-pink"><?php echo $a_data['email_id'] ?> </span>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Date</strong></label>
                                        <div class="col-md-9">
                                          <?php echo $a_data['add_date'] ?>


                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Card No</strong></label>
                                        <div class="col-md-9">
                                           <span class="badge badge-primary"><?php echo $a_data['card_no'] ?> </span>

                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label"><strong>Status</strong></label>
                                        <div class="col-md-9">
                                           <span class="badge badge-danger"><?php echo $a_data['status'] ?> </span>

                                        </div>
                                    </div>




<?php }?>
 
                                 
                                
                            </div>
                          <div class="col-md-1">
                             </div>

                        </div>
                        
                    </div>




  </div>


              
                <!-- end row -->
                <!--end row/ WEATHER -->
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    
         <?php echo form_close(); ?> 
        <!-- end content -->
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- /Right-bar -->
    </div>
    <!-- END wrapper -->
    <script>
            var resizefunc = [];
        </script>

        <!-- Plugins  -->
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script>

        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/js/jquery.multi-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

        <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script>

        <!-- Custom main Js -->
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>


 <script>


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

       function isNumberKeydc(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
      
    </script>
    
   <script type="text/javascript">
  $(document).ready(function(){
    $("#myModal").modal('show');
  });
</script>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <!--  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title">Payment Complete</h4>
            </div>
            <div class="modal-body">
      <!--   <p>Subscribe to our mailing list to get the latest updates straight in your inbox.</p> -->
                <form>
                    <div class="form-group">
                       <!--  <input type="text" class="form-control" placeholder="Name"> -->
                        <button type="submit" data-dismiss="modal" class="btn btn-block btn--md btn-secondary  waves-effect waves-light">Message</button>
                    </div>
                    <div class="form-group">
                       <!--  <input type="email" class="form-control" placeholder="Email Address"> -->
                       <button type="submit" data-dismiss="modal" class="btn btn-block btn--md btn-success waves-effect waves-light">Email</button>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Subscribe</button> -->
                    <!--  <button data-dismiss="modal"  class="btn btn-primary">No Thanks</button> -->

                     <button type="button" data-dismiss="modal" class="btn btn-block btn--md btn-danger waves-effect waves-light">No Thanks</button>

                </form>
            </div>
        </div>
    </div>
</div>
 
 

    </body>

</html>