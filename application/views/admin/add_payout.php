<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Agent</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
  <link href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    .reset-dataTable table.dataTable tbody tr.even.selected td:first-child, .reset-dataTable table.dataTable tbody tr.odd.selected td:first-child{
      border-left: #2273dc  !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected, .reset-dataTable table.dataTable tbody tr.odd.selected {
        background-color: #dff4ff !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected td.sorting_1, .reset-dataTable table.dataTable tbody tr.odd.selected td.sorting_1{
      background-color: rgba(0, 136, 0, 0) !important;
    }
  </style>
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <div id="wrapper"> 
    <div class="page-wrapper pos-list invoice-pos-list">     
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title"> 
            <span><?php echo ($meta)?></span>
            <small style="color:red;"><?php echo validation_errors(); ?></small>
          </div>
        </div>
      </div>
      <?php
      if(isset($msg))
        echo "<h4> $msg</h4>";
        // echo form_open('agent/'.$loc, array('id' => "my_form"));
      ?>
    <form action="<?php echo base_url('Agent/add_payout_agent'); ?>" id='my_form' method="post" enctype='multipart/form-data' autocomplete="off" >
    
        <div class="row">
          <div class="col-12">
            <div class="card content-card">
              <div class="card-detail recurring__geninfo custom-form">
                <div class="row  responsive-cols f-wrap f-auto">
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Name</label>
                      <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" placeholder="Full Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required="" type="text" readonly>

                      <input class="form-control" name="bct_id" id="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" required="" type="hidden">

                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Email Address <i class="text-danger">*</i></label>
                      <input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text" readonly>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Phone <i class="text-danger">*</i> </label>
                      <input class="form-control" placeholder="Phone" name="mobile" id="mobile" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required type="text" readonly>
                    </div>
                  </div>
               
                

                  

                </div>
              </div>
            </div>
          </div>
         
          
          <div class="col-12">
            <div class="card content-card">
              <div class="card-detail">
                <div class="row">
                  

                 
                  
                 <div class="col-3">
                  <div class="col mx-253">
                    <div class="form-group">
                       <select class="form-control"  name="year" id="year" required="">
                  <option value="">Select Year</option>
                  <option <?php echo ($year=="2020")?'selected="selected"':''?> value="2020">2020</option>
                  <option <?php echo ($year=="2021")?'selected="selected"':''?> value="2021">2021</option>
                  <option <?php echo ($year=="2022")?'selected="selected"':''?> value="2022">2022</option>
                  <option <?php echo ($year=="2023")?'selected="selected"':''?> value="2023">2023</option>
                  <option <?php echo ($year=="2024")?'selected="selected"':''?> value="2024">2024</option>
                  <option <?php echo ($year=="2025")?'selected="selected"':''?> value="2025">2025</option>
                </select>
                    </div>
                  </div>
                </div>
                  <div class="col-3">
                  <div class="col mx-253">
                    <div class="form-group">
                        <select class="form-control"  name="month" id="month" required="">
                  <option value="">Select Month</option>
                  <option <?php echo ($month=="01")?'selected="selected"':''?> value="01">January</option>
                  <option <?php echo ($month=="02")?'selected="selected"':''?> value="02">February</option>
                  <option <?php echo ($month=="03")?'selected="selected"':''?> value="03">March</option>
                  <option <?php echo ($month=="04")?'selected="selected"':''?> value="04">April</option>
                  <option <?php echo ($month=="05")?'selected="selected"':''?> value="05">May</option>
                  <option <?php echo ($month=="06")?'selected="selected"':''?> value="06">June</option>
                  <option <?php echo ($month=="07")?'selected="selected"':''?> value="07">July</option>
                  <option <?php echo ($month=="08")?'selected="selected"':''?> value="08">August</option>
                  <option <?php echo ($month=="09")?'selected="selected"':''?> value="09">September</option>
                  <option <?php echo ($month=="10")?'selected="selected"':''?> value="10">October</option>
                  <option <?php echo ($month=="11")?'selected="selected"':''?> value="11">November</option>
                  <option <?php echo ($month=="12")?'selected="selected"':''?> value="12">December</option>
                 
                </select>
                  </div>
                 
                </div>
              </div>

              <div class="col-3">
                    <div class="form-group">
                      <input class="form-control" placeholder="Amount" name="amount" id="amount" onKeyPress="return isNumberKeydc(event)" required type="text">
                    </div>
                  </div>

                  <div class="col-3">
                  
                    <div style="display:none" id="hideencheckbox"></div>
                    <input type="submit" id="btn_login"   name="submit"   class="btn btn-first pull-right" value="<?php echo $action ?>" />
                  
                </div>
                


              </div>
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  var resizefunc = [];
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
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<!-- Popper for Bootstrap -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script>

</body>
</html>