<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Panel</title>
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
  <!-- links -->
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://salequick.com/new_assets/css/style.css">
  <style type="text/css">
    .custom-form label,.custom-form .custom-checkbox input[type=checkbox]:not(.radio-circle):checked+label, .custom-form .custom-checkbox input[type=radio]:not(.radio-circle):checked+label {
    user-select: none;
    color: rgba(255, 255, 255, 0.75);font-weight: normal;
    }
    .custom-form .custom-checkbox input[type=checkbox]:not(.radio-circle)+label:before, .custom-form .custom-checkbox input[type=radio]:not(.radio-circle)+label:before{
    border-color: rgba(255, 255, 255, 0.75);
    }
    .custom-form .custom-checkbox input[type=checkbox]:not(.radio-circle):checked+label:before, .custom-form .custom-checkbox input[type=radio]:not(.radio-circle):checked+label:before{
    border-right-color: rgba(255, 255, 255, 0.75);
    border-bottom-color: rgba(255, 255, 255, 0.75);
    }
  </style>  
</head>
<body>
<div id="wrapper"> 
  <div class="outer-page-wrapper ">    
    <div class="login-register">
      <div class="log-reg-box-inner">
        <div class="row">
          <div class="col-12">
            <?php echo $this->session->flashdata('msg'); ?>
            <?php unset($_SESSION['msg']); ?>
          </div>
        </div>
        <?php 
          $attributes = array("class" => "row custom-form", "id" => "loginform", "name" => "loginform");
          echo form_open("otp/otp", $attributes);
        ?> 
          <div class="col-12">
            <div class="logo-wrapper-outer clearfix">
                <a  href="<?php echo base_url(''); ?>" class="logo-wrapper no-ajax">
                  <img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="Salequick">
                </a>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter Otp" required="">

               <input type="hidden" name="admin_id" id="admin_id" class="form-control" value="<?php echo $this->uri->segment(3) ?>">
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <button type="submit" id="btn_login" name="btn_login" class="btn btn-first" value="Reset">Submit</button>
            </div> 
          </div>
          <div class="col-12">
            <div class="form-group text-center">
              <p><a class="no-ajax" href="<?php echo base_url('admin'); ?>">Log In?</a></p>
            </div> 
          </div>
          <?php echo form_close(); ?>
      </div>
    </div> 
  </div>
</div>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script type="text/javascript">
function vCenterRequired($elem){
var winH=$(window).height() - 30 ; var elemH=$elem.outerHeight(true) ;
if(elemH > winH){return false } else{return true; } }
function loginRegFget(){
if(vCenterRequired($('.login-register'))){$('.login-register').addClass('v-center'); } else{$('.login-register').removeClass('v-center'); } }
$(window).on('resize',function(){loginRegFget();})
$(function(){loginRegFget();})
</script>
</body>
</html>