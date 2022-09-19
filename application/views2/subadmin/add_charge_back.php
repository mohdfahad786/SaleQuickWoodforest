<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
     <title>Admin | Dashboard</title>
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
        <?php $this->load->view('admin/top'); ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
         <?php $this->load->view('admin/menu'); ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
         <?php
if(isset($msg))
echo "<h4> $msg</h4>";
echo form_open_multipart('charge_back/'.$loc, array('id' => "my_form"));
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
                                   
                                  <!--   <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Status</label>
                                        <div class="col-md-9">
                                            


                                                <select class="form-control"  name="status" id="status" required="">
 
    <option value="pending" <?php if($status=='pending'){ echo 'selected'; } ?> > Pending </option>
     <option value="confirm" <?php if($status=='confirm'){ echo 'selected'; } ?> > Confirm </option>
     <option value="reject" <?php if($status=='reject'){ echo 'selected'; } ?> > Reject </option>
                          
                    </select>

                                        </div>
                                    </div> -->

                                   
                            </div>
                            <div class="col-md-6">
                              
                                 

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Email</label>
                                        <div class="col-md-9">
                                             <input class="form-control" placeholder="email id" name="email" readonly id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email:"
        value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Phone</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Phone" name="mob_no" readonly id="mob_no" pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Phone:"
        value="<?php echo (isset($mob_no) && !empty($mob_no)) ? $mob_no : set_value('mob_no');?>" required type="text">
                                        </div>
                                    </div>
                                 

                                   

                               
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Reason</label>
                                    <div class="col-md-11 pad-l-60">
                                       

                                         <textarea class="form-control" style="height: auto" readonly=""  rows="5" required name="reason" ><?php echo (isset($reason) && !empty($reason)) ? $reason : set_value('reason');?></textarea>

                                    </div>
                                </div>
                            </div>

                               <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">Detail</label>
                                    <div class="col-md-11 pad-l-60">
                                       

                                 <textarea class="form-control" style="height: auto"  rows="5" required name="detail" ><?php echo (isset($detail) && !empty($detail)) ? $detail : set_value('detail');?></textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
      <div class="form-group row">

  <label class="col-md-1 col-form-label">Status</label>
                                    <div class="col-md-11 pad-l-60">

<div class="radio radio-success form-check-inline">
                                        <input id="inlineRadio1"  name="status" value="pending" <?php if($status=='pending'){ echo 'checked'; } ?> type="radio">
                                        <label for="inlineRadio1"> Pending </label>
                                    </div>

                                    <div class="radio radio-success  form-check-inline">
                                        <input id="inlineRadio2"  name="status" value="confirm" <?php if($status=='confirm'){ echo 'checked'; } ?> type="radio">
                                        <label for="inlineRadio2">Confirm </label>
                                    </div>

                                     <div class="radio radio-success  form-check-inline">
                                        <input id="inlineRadio3" value="reject" name="status" <?php if($status=='reject'){ echo 'checked'; } ?> type="radio">
                                        <label for="inlineRadio3"> Reject</label>
                                    </div>

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