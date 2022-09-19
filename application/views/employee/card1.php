<!DOCTYPE html>
<html>
   <!-- Mirrored from coderthemes.com/minton/dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:36:17 GMT -->
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
      <meta name="author" content="Coderthemes">
      <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
      <title>Employee | Dashboard</title>
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
      <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
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
         <?php $this->load->view('employee/top'); ?>
         <!-- Top Bar End -->
         <!-- ========== Left Sidebar Start ========== -->
         <?php $this->load->view('employee/menu'); ?>
         <!-- Left Sidebar End -->
         <!-- ============================================================== -->
         <!-- Start right Content here -->
         <!-- ============================================================== -->
         <?php
            if(isset($msg))
            echo "<h4> $msg</h4>";
            
           echo form_open('pos_employee/card_payment/', array('id' => "my_form"));
           echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
            
                $merchant_name = $this->session->userdata('merchant_name');
            
            $names = substr($merchant_name, 0, 3);
              
            ?>
         <!-- <form> -->
            
            <div class="content-page">
               <!-- Start content -->
               <div class="content">
                  <div class="container-fluid">
                     <!-- Page-Title -->
                     <div class="col-md-12">
                        <h2 class="m-b-20"> Card Payment </h2>
                        <button class="btn btn-primary pull-right" onclick="history.go(-1);">Back </button>
                     </div>
                  </div>
                  <div class="card-box">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Amount</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <input type="text" class="form-control"  name="amount" id="amount"  placeholder="Amount:" 
                                       required value="<?php echo  $amount ; ?>" readonly>
                                    <input type="hidden" class="form-control"  name="tax" id="tax"  
                                       required value="<?php echo  $tax ; ?>" readonly>
                                    <?php
                                       $merchant_id = $this->session->userdata('merchant_id');
                                       $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
                                       
                                       ?>
                                    <?php foreach ($data as $view) { ?>
                                    <input type="hidden" class="form-control"  name="TAX_ID[]" 
                                       required value="<?php echo $view['id']; ?>" readonly>
                                    <input type="hidden" class="form-control"  name="TAX_PER[]" 
                                       required value="<?php echo $view['percentage']; ?>" readonly>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Owner name</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                                    <input type="text" class="form-control"  name="name" id="name" pattern="[a-zA-Z\s]+"  placeholder="Owner name:" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Address</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"></span> 
                                    <input type="text" class="form-control"  name="address" id="address"   placeholder="Address:" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">City</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"></i></span> 
                                    <input type="text" class="form-control"  name="city" id="city" pattern="[a-zA-Z\s]+"  placeholder="City Name:" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">State</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"></span> 
                                    <input type="text" class="form-control"  name="state" id="state" pattern="[a-zA-Z\s]+"  placeholder="State Name:" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Zip</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"></span> 
                                    <input type="text" class="form-control"  name="zip" id="zip"   placeholder="Zip:" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Card Number</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span> 
                                    <input type="text" class="form-control" autocomplete="off" onKeyPress="return isNumberKey(event)"     minlength="14"      maxlength="16"  name="card_no" id="card_no"  placeholder="Card Number" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">CVV</label>
                              <div class="col-md-8">
                                 <div class="input-group" >          
                                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                    <input type="text" class="form-control"  name="cvv" id="cvv" autocomplete="off" minlength="3" maxlength="3" onKeyPress="return isNumberKey(event)"  placeholder="CVV" 
                                       required >
                                 </div>
                              </div>
                           </div>
                        </div>

                        
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Card Expiry Month</label>
                              <div class="col-md-8">
                                 <select class="form-control" name="expiry_month" id="expiry_month" required>
                                    <option value="">Select Month</option>
                                    <option value="01">Jan (01)</option>
                                    <option value="02">Feb (02)</option>
                                    <option value="03">Mar (03)</option>
                                    <option value="04">Apr (04)</option>
                                    <option value="05">May (05)</option>
                                    <option value="06">June (06)</option>
                                    <option value="07">July (07)</option>
                                    <option value="08">Aug (08)</option>
                                    <option value="09">Sep (09)</option>
                                    <option value="10">Oct (10)</option>
                                    1
                                    <option value="11">Nov (11)</option>
                                    <option value="12">Dec (12)</option>
                                 </select>
                                 <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Card Expiry Year</label>
                              <div class="col-md-8">
                                 <select class="form-control" name="expiry_year" required>
                                    <option value="">Select year</option>
                                    
                                    <option value="19">2019</option>
                                    <option value="20">2020</option>
                                    <option value="21">2021</option>
                                    <option value="22">2022</option>
                                    <option value="23">2023</option>
                                    <option value="24">2024</option>
                                    <option value="25">2025</option>
                                    <option value="26">2026</option>
                                    <option value="27">2027</option>
                                    <option value="28">2028</option>
                                    <option value="29">2029</option>
                                    <option value="30">2030</option>
                                 </select>
                                 <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6" style="display:none;">
                           <div class="form-group row">
                              <label class="col-md-4 col-form-label">Card Type</label>
                              <div class="col-md-8">
                                 <select class="form-control" name="card_type" required>
                                    <!--<option value="">Select Card Type</option>-->
                                    <option value="MC">Master Card</option>
                                 </select>
                                 <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
               <div class="row text-center">
                  <!--  <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light  btn-lg btn-lgs">Pay Now</button> -->
                  <button type="button" data-toggle="modal" data-target="#view-modal" data-id="1" id="getUser" class="btn btn-primary waves-effect waves-light  btn-lg btn-lgs">  Pay Now</button>
               </div>
               <!-- end row -->
               <!--end row/ WEATHER -->
               <!-- end row -->
            </div>
            <!-- end container -->
      </div>
      <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog"> 
      <div class="modal-content"> 
      <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
      <h4 class="modal-title">
      <i class="glyphicon glyphicon-user"></i> Customer Detail
      </h4> 
      </div> 
      <div class="modal-body"> 
      <div id="modal-loader" style="display: none; text-align: center;">
      <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>">
      </div>
      <!-- content will be load here -->                          
      <div id="dynamic-content">
      <div class="col-md-10">
      <div class="form-group row">
      <label class="col-md-4 col-form-label">Phone</label>
      <div class="col-md-8">
      <div class="input-group" >          
      <span class="input-group-addon"><i class="fa fa-user"></i></span> 
      <input type="text" class="form-control"  name="mobile_no" id="phone"   placeholder="Phone:" 
         >
      </div>
      </div>
      </div>
      </div>
      <div class="col-md-10">
      <div class="form-group row">
      <label class="col-md-4 col-form-label">Email</label>
      <div class="col-md-8">
      <div class="input-group" >          
      <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span> 
      <input type="text" class="form-control" autocomplete="off"   name="email_id" id="email_id"  placeholder="Email" 
         >
      </div>
      </div>
      </div>
      </div>
      </div>
      </div> 
      <div class="modal-footer"> 
      <!--   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->  
      <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light  btn-lg btn-lgs">Pay Now</button>
      </div> 
      </div> 
      </div>
      </div><!-- /.modal -->   
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
      <!--    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>  -->
      <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
      <!-- Popper for Bootstrap -->
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
         $('#card_no').on("keyup", function () {
                     var tax =  $('#card_no').val();
         
                     $('#phone').val('');
                    $('#email_id').val('');
                    
                     $.ajax({
                         type: 'POST',
                      
                          url: "<?php  echo base_url('pos/search_record_card'); ?>",
         
                         data: {id: tax},
                         type:'post',
                         success: function (dataJson)
                         {
                             data = JSON.parse(dataJson)
                            
                             $(data).each(function (index, element) {
                                
                 $('#phone').val(element.mobile_no);
                    $('#email_id').val(element.email_id);
             
             
         
                             });
                          
                         }
                     });
                 });
         
         
         
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