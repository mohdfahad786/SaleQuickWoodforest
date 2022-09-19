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
echo form_open_multipart('pos/'.$loc, array('id' => "my_form"));
echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
?>    
             <form>  
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
                            <div class="col-md-6">
                              
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Invoice No</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Invoice No" readonly name="invoice" id="invoice"  required value="<?php echo (isset($invoice) && !empty($invoice)) ? $invoice : set_value('invoice');?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Name</label>
                                        <div class="col-md-9">
                                              <input   type="text"  class="form-control" name="name" id="name" readonly placeholder="Name"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>"  required>

                                               <input   type="hidden"  class="form-control" name="payment_id" id="payment_id" readonly placeholder="Name"  required value="<?php echo (isset($payment_id) && !empty($payment_id)) ? $payment_id : set_value('payment_id');?>"  required>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Amount</label>
                                        <div class="col-md-9">
                                             <input type="text" class="form-control" name="amount" id="amount"   value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>">
                                        </div>
                                    </div>

                                    <!--  <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Pin Code</label>
                                        <div class="col-md-9">
                                             <input type="text" class="form-control" name="pin_code" id="pin_code" maxlength="6" onKeyPress="return isNumberKey(event)"   value="<?php echo (isset($pin_code) && !empty($pin_code)) ? $pin_code : set_value('pin_code');?>">

         <input type="hidden" class="form-control" name="psw" id="psw" readonly required value="<?php echo (isset($psw) && !empty($psw)) ? $psw : set_value('psw');?>">
                                        </div>
                                    </div> -->
                                   
                            </div>
                            <div class="col-md-6">
                              
                                     <!--  <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Auth Key</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="auth_key" id="auth_key" readonly required value="<?php echo (isset($auth_key) && !empty($auth_key)) ? $auth_key : set_value('auth_key');?>">
                                        </div>
                                    </div> -->

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Email id</label>
                                        <div class="col-md-9">
                                             <input class="form-control" placeholder="email id" name="email" readonly id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email Id:"
        value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">mobile no</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Mobile no" name="mob_no" readonly id="mob_no" pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :"
        value="<?php echo (isset($mob_no) && !empty($mob_no)) ? $mob_no : set_value('mob_no');?>" required type="text">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label class="col-md-3 col-form-label">City</label>
                                        <div class="col-md-9">
                                           <input type="text" class="form-control" name="city" id="city"   value="<?php echo (isset($city) && !empty($city)) ? $city : set_value('city');?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Status</label>
                                        <div class="col-md-9">
                                             <input   type="text"  class="form-control" name="status" id="status" readonly required value="<?php echo (isset($status) && !empty($status)) ? $status : set_value('status');?>"  >
                                        </div>
                                    </div> -->

                                   

                               
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Reason</label>
                                    <div class="col-md-11 pad-l-60">
                                       

                                         <textarea class="form-control" style="height: auto"  rows="5" required name="reason" ><?php echo (isset($reason) && !empty($reason)) ? $reason : set_value('reason');?></textarea>

                                    </div>
                                </div>
                            </div>

                            <!--  <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Address2</label>
                                    <div class="col-md-11 pad-l-60">
                                        <input   type="text"  class="form-control" name="address2" id="address2"   value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : set_value('address2');?>"  >
                                    </div>
                                </div>
                            </div>
 -->
                          
                           

                           

                        </div>
                    </div>

                  



                <div class="row text-center">
                    
<!-- <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light  btn-md pull-right">Submit</button>
 -->
                      <input type="submit" id="btn_login" name="submit"  class="btn btn-primary   btn-lg btn-lgs" value="Submit" />

                       
                </div>
                 </div>
                <!-- end row -->
                <!--end row/ WEATHER -->
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
      </form>
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