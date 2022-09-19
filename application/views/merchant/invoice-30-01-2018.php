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
       <h4> Api</h4>
             <form>  
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Page-Title -->
                      <h3> Api Detail</h3>
                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-6">
                              
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">name</label>
                                        <div class="col-md-9">
                 
                   <p>String </br>
                   <label>  First Name (Required)</label> </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">l_name</label>
                                        <div class="col-md-9">
                                             
                                              <p>String </br>
                   <label>  Last Name (Required)</label> </p>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                         <label class="col-md-3 col-form-label" style="text-transform:none">mobile_no</label>
                                        <div class="col-md-9">
                                              
                                               <p>Integer </br>
                   <label>  Mobile No (Required)</label> </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">email_id</label>
                                        <div class="col-md-9">
                                            
                                              <p>String </br>
                   <label> Email id (Required)</label> </p>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                         <label class="col-md-3 col-form-label" style="text-transform:none">amount</label>
                                        <div class="col-md-9">
                                                <p>Integer </br>
                   <label> Amount (Required)</label> </p>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                       
                                        <label class="col-md-3 col-form-label" style="text-transform:none">tax</label>
                                        <div class="col-md-9">
                                               <p>Integer </br>
                   <label> Tax (Optional)</label> </p>
                                        </div>
                                    </div>
  <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">invoice_no</label>
                                        <div class="col-md-9">
                                               <p>Integer </br>
                   <label> Invoice No (Required  and generate unique)</label> </p>
                                        </div>
                                    </div>


                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">city</label>
                                        <div class="col-md-9">
                                            <p>String </br>
                   <label> City (Required)</label> </p>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">state</label>
                                        <div class="col-md-9">
                                            <p>String </br>
                   <label> State (Required)</label> </p>
                                        </div>
                                    </div>

                                   
                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">country</label>
                                        <div class="col-md-9">
                                            <p>String </br>
                   <label> Country (Required)</label> </p>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">zipcode</label>
                                        <div class="col-md-9">
                                              <p>String </br>
                   <label> Zip Code (Required)</label> </p>

        
                                        </div>
                                    </div>

                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">address</label>
                                        <div class="col-md-9">
                                             
                                              <p>String </br>
                   <label> Street Address (Required)</label> </p>
                                        </div>
                                    </div>

                                   

                                   
                            </div>
                            <div class="col-md-6">

                                 <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">op1</label>
                                        <div class="col-md-9">
                                     
<p>String </br>
                   <label> Optional Data1 if you want to add any extra field (Optional)</label> </p>
        
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">op2</label>
                                        <div class="col-md-9">
                                  <p>String </br>
                   <label> Optional Data2 if you want to add any extra field (Optional)</label> </p>
                                        </div>
                                    </div>
                              
                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">Auth Key</label>
                                        <div class="col-md-9">
                                           
                                            <p>String </br>
                   <label> Auth Key Provided By gateway (Required)</label> </p>
                                        </div>
                                    </div>

                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">merchant_key</label>
                                        <div class="col-md-9">
                                           <p>String </br>
                   <label> Merchant Key  Provided By gateway (Required)</label> </p>
                                        </div>
                                    </div>

                                  
                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label">type</label>
                                        <div class="col-md-9">
                                            <p>String </br>
                   <label> Card Type (Required)</label> </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">cNum</label>
                                        <div class="col-md-9">
                                             <p>String </br>
                   <label> Card Number (Required)</label> </p>
                                        </div>
                                    </div>
                                  
                                   
                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">cvv</label>
                                        <div class="col-md-9">
                                           <p>String </br>
                   <label> Cvv Number (Required)</label> </p>
                                        </div>
                                    </div>


                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">expiry_month</label>
                                        <div class="col-md-9">
                                           <p>String </br>
                   <label> Expiry Month (Required)</label> </p>
                                        </div>
                                    </div>


                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" style="text-transform:none">expiry_year</label>
                                        <div class="col-md-9">
                                            <p>String </br>
                   <label> Expiry Year (Required)</label> </p>
                                        </div>
                                    </div>
                                    
                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Download Kit</label>
                                        <div class="col-md-9">
               <a class="btn" href="http://gateway.anmolenterprises.org/file.zip"> <a href="http://gateway.anmolenterprises.org/file.zip">Download</a>
                                        </div>
                                    </div>

                                                                    
                            </div>

                            <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Result In Json</label>
                                         <pre style="background-color:#669999;">
                                        <div class="col-md-9" style="font-size: 20px; color: white">
                                         
                                          {  
   "errorCode":0,
   "message":"SUCCESS",
   "result":{  
      "name":"shuaeb",
      "amount":"200",
      "invoice_no":"fsr453443tre",
      "email_id":"shuaebahmad15@gmail.com",
      "mobile_no":"9919692700",
      "payment_id":"PY20180117110106"
   }
}



                                        </div>
                                        </pre>
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