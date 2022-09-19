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

echo form_open_multipart('merchant/'.$loc, array('id' => "my_form"));
echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";


?>    
             <form>  
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Page-Title -->
                     <?php
                     if(isset($emymsg))
echo "<h4> $emymsg</h4>";
?>   
                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-6">
                              
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">User Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="title" style="text-transform: lowercase;" id="title" readonly required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Name</label>
                                        <div class="col-md-9">
                                              <input   type="text"  class="form-control" name="name" id="name"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>"  required>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">State</label>
                                        <div class="col-md-9">
                                             <input type="text" class="form-control" name="state" id="state"   value="<?php echo (isset($state) && !empty($state)) ? $state : set_value('state');?>">
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Pin Code</label>
                                        <div class="col-md-9">
                                             <input type="text" class="form-control" name="pin_code" id="pin_code" maxlength="6" onKeyPress="return isNumberKey(event)"   value="<?php echo (isset($pin_code) && !empty($pin_code)) ? $pin_code : set_value('pin_code');?>">

                                            <input type="hidden" class="form-control" name="psw" id="psw" readonly required value="<?php echo (isset($psw) && !empty($psw)) ? $psw : set_value('psw');?>">
                                        </div>
                                    </div>
                                    <?php if($register_type=='api'){ ?>
                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Api status</label>
                                        <div class="col-md-9">
                 <!--<input type="text" class="form-control" name="api_type" id="api_type" value="<?php echo (isset($api_type) && !empty($api_type)) ? $api_type : set_value('api_type');?>">-->
                 <select class="form-control" name="api_type" id="api_type">
                 <option value="sandbox" <?php if($api_type=='sandbox'){ echo 'selected'; } ?>>Sandbox</option>
                <option value="live" <?php if($api_type=='live'){ echo 'selected'; } ?>>Live</option>
                </select>
                 

     
                                        </div>
                                    </div>
                                    <?php } ?>
                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Invoice Color</label>
                                        <div class="col-md-9">
                                              <input autocomplete="off"  id="styleInput" class="jscolor  {valueElement:'valueInput', styleElement:'styleInput', borderColor:'#216078', insetColor:'#216078', backgroundColor:'#216078',padding: 7,borderWidth:0,borderRadius:4,}"  value="" readonly style="display: block;width: 100%;max-width: 100%;font-size: 1rem;line-height: 1.25;border: 5px solid rgb(33, 96, 120);height: 28px;background-color: rgb(255, 255, 255);caret-color: transparent;background-image: none;color: rgb(0, 0, 0);outline-offset: -7px;cursor: pointer;outline: rgb(2, 4, 4) solid 2px !important;border-radius: 4px !important;max-width: 100%;" >
                                            <input type="hidden" name="color" id="valueInput" value="#<?php echo (isset($color) && !empty($color)) ? $color : set_value('color');?>" >
                                        </div>
                                    </div>
                                   
                            </div>
                            <div class="col-md-6">
                              
                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Auth Key</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="auth_key" id="auth_key" readonly required value="<?php echo (isset($auth_key) && !empty($auth_key)) ? $auth_key : set_value('auth_key');?>">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Merchant Key</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="merchant_key" id="merchant_key" readonly required value="<?php echo (isset($merchant_key) && !empty($merchant_key)) ? $merchant_key : set_value('merchant_key');?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Phone</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Phone" name="mob_no" id="phone"  maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :"
        value="<?php echo (isset($mob_no) && !empty($mob_no)) ? $mob_no : set_value('mob_no');?>" required type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
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
                                    </div>

                                   

                               
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Address1</label>
                                    <div class="col-md-11 pad-l-60">
                                       <input   type="text"  class="form-control" name="address1" id="address1"   value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1');?>"  >
                                    </div>
                                </div>
                            </div>

                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Address2</label>
                                    <div class="col-md-11 pad-l-60">
                                        <input   type="text"  class="form-control" name="address2" id="address2"   value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : set_value('address2');?>"  >
                                    </div>
                                </div>
                            </div>

                             <div class="form-group col-md-12">
<?php 
if($mypic!=''){
echo "<img height= \"50\" src=".$upload_loc."/".$mypic.">";
}
?>
</div>

                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Logo</label>
                                    <div class="col-md-11 pad-l-60">
                                          <input type="file" style="height: auto;" class="form-control" name="mypic" id="mypic"  placeholder="Editor Image:" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">



                                    </div>
                                </div>
                            </div>

                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Change Password</label>
                                    <div class="col-md-11 pad-l-60">
                                         <input type="password" class="form-control" name="cpsw" id="cpsw" value="" autocomplete="off"  >
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                  



                <div class="row text-center">
                    

                      <input type="submit" id="btn_login" name="mysubmit"  class="btn btn-primary   btn-lg btn-lgs" value="Update" />

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
		
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/masking.js"></script>
            <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/colorScript.js"></script>
	 <script >
                                            
                                            $(function(){
  
  $("#phone").mask("(999) 999-9999");


  $("#phone").on("blur", function() {
      var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );

      if( last.length == 5 ) {
          var move = $(this).val().substr( $(this).val().indexOf("-") + 1, 1 );

          var lastfour = last.substr(1,4);

          var first = $(this).val().substr( 0, 9 );

          $(this).val( first + move + '-' + lastfour );
      }
  });
}); 
                                        </script>


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