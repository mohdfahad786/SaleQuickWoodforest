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
    
    echo form_open('dashboard/'.$loc, array('id' => "my_form"));
    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
    ?>
          
<form>
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">

                   <div style="color:red;"><?php echo validation_errors(); ?></div>
                    <!-- Page-Title -->
                    <div class="col-md-12">
                            <h2 class="m-b-20"> <?php echo ($meta)?>  </h2></div>
                    </div>
                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-6">
                               
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email:"
        value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Name</label>
                                        <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name"  placeholder="Name:" 
        required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                                        </div>
                                    </div>


                               
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Phone</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="mobile" id="mobile" pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Phone :"
        value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>
                                        </div>
                                    </div>


                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Password</label>
                                        <div class="col-md-9">
                                          <?php if($loc=='edit_subadmin')  {?> 

                                           <input type="hidden" class="form-control" name="password" id="password"  placeholder="Password:" 
        required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password');?>">

         <input type="password" class="form-control" name="cpsw" id="cpsw"  placeholder="Change Password:"  >

                                          <?php } elseif($loc=='create_new_subadmin')  {?>
                                      <input type="text" class="form-control" name="password" id="password"  placeholder="Password:" 
        required ><?php } ?>
        
                                        </div>
                                    </div>




                                     <?php if($loc=='edit_subadmin')  {?>  
                          <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Status</label>
                                        <div class="col-md-9">
                           <select class="form-control"  name="status" id="status" required="">
 
    <option value="active" <?php if($status=='active'){ echo 'selected'; } ?> > Active </option>
     <option value="block" <?php if($status=='block'){ echo 'selected'; } ?> > Block </option>
                          
                    
                                             </select>
                         <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
<?php } ?>


                               
                                 </div>
                                   <div class="col-md-6">  

           
                                <div class="form-group row">
                                        <label class="col-md-6 col-form-label">Edit Permissions</label>
                                        <div class="col-md-6">
                                           <?php if($loc=='edit_subadmin')  {?> 
              <input type="checkbox" class="checkbox checkbox-primary"   name="edit_permissions" value="1"  <?php if(1 == $edit_permissions){ echo 'checked="checked"'; } ?> >
                <input type="hidden" name="view_permissions" value="1" <?php if(1 == $view_permissions){ echo 'checked="checked"'; } ?> >
                                         <?php } elseif($loc=='create_new_subadmin')  {?> 
                                          <input type="checkbox" class="checkbox checkbox-primary"  name="edit_permissions" value="1"  >
                <input type="hidden" name="view_permissions" value="1"     >
                                          <?php } ?>
                                        </div>
                                    </div>



                                <div class="form-group row">
                                        <label class="col-md-6 col-form-label">Active Permissions</label>
                                        <div class="col-md-6">
                                           <?php if($loc=='edit_subadmin')  {?> 
                                         <input type="checkbox" class="checkbox checkbox-primary"   name="active_permissions" value="1"  <?php if(1 == $active_permissions){ echo 'checked="checked"'; } ?> >
               
                                         <?php } elseif($loc=='create_new_subadmin')  {?> 
                                          <input type="checkbox" class="checkbox checkbox-primary"  name="active_permissions" value="1"  >
               
                                          <?php } ?>
                                        </div>
                                    </div>



                                <div class="form-group row">
                                        <label class="col-md-6 col-form-label">Delete Permissions</label>
                                        <div class="col-md-6">
                                           <?php if($loc=='edit_subadmin')  {?> 
                                         <input type="checkbox" class="checkbox checkbox-primary"   name="delete_permissions" value="1"  <?php if(1 == $delete_permissions){ echo 'checked="checked"'; } ?> >
               
                                         <?php } elseif($loc=='create_new_subadmin')  {?> 
                                          <input type="checkbox" class="checkbox checkbox-primary"  name="delete_permissions" value="1"  >
               
                                          <?php } ?>
                                        </div>
                                    </div>
                                 
                     
                         <div>
                           

                             <input type="submit" id="btn_login" name="submit"  class="btn btn-primary btn-md pull-right" value="<?php echo $action ?>" />




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