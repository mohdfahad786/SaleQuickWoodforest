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

           <?php

    if(isset($msg))

    echo "<h4> $msg</h4>";

    

    echo form_open('merchant/'.$loc, array('id' => "my_form"));

    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

    ?>

          



        <div class="content-page">

            <!-- Start content -->

            <div class="content">

                <div class="container-fluid">

                    <!-- Page-Title -->

                    <div class="col-md-12">

                            <h2 class="m-b-20"> <?php echo ($meta)?>  </h2></div>

                    </div>

                    <div class="card-box">

                        <div class="row">

                            <div class="col-md-8">

                               

                                  

                                 

                                 

                                

                            </div>

                         



                        </div>

                         <div>

                           



                            <!--  <input type="submit" id="btn_login" name="submit"  class="btn btn-primary btn-md pull-right" value="<?php echo $action ?>" /> -->



                              



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

 



    </body>



</html>