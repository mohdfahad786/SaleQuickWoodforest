<?php 
$url =  base_url('agent/dashboard');

if( $this->session->userdata('subadmin_user_type')=='agent' )
 {
     header('Location:  '.  $url);
}


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title>Reseller Login</title>
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
    <!-- links -->
    <link href="https://salequick.com/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
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
        input.form-control {
            background-color: rgba(255, 255, 255, 0.8) !important;
            height: 40px!important;
            border-color: #e1e6ea !important;
        }
        input::placeholder {
            color: #adb5c7 !important;
        }
        label {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        input#checkbox-signup {
            width: 15px !important;
            height: 15px !important;
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
            </div>
          </div>
          <?php 
           
            $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
            echo form_open("login_admin/index", $attributes);
          ?>
            <div class="col-12">
              <div class="logo-wrapper-outer clearfix">
                  <a  href="https://salequick.com/" class="logo-wrapper no-ajax">
                    <img src="https://salequick.com/front/images/logo-w.png" alt="Salequick">
                  </a>
              </div>
            </div>
            
             <!-- <div class="col-12">
              <div class="form-group ">
               <h2 style="color: aliceblue;text-align: center;">Agent Login</h2>
              </div>
            </div> -->
            <div class="col-12">
              <div class="form-group ">
               <p style="color: rgba(255, 255, 255, 0.5) !important;">Reseller Login</p>
              </div>
            </div>
            
            <div class="col-12">
              <div class="form-group">
                <input type="text" class="form-control"  placeholder="Email" required id="username" name="username">
                <input type="hidden" class="form-control" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <div class="custom-checkbox">
                  <input type="checkbox" id="checkbox-signup" name="remember"> 
                  <label for="checkbox-signup"> Remember Me </label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <button type="submit" id="btn_login" name="btn_login" class="btn btn-first btn-block" value="Login">Login</button>
              </div> 
            </div>
            <div class="col-12">
              <div class="form-group text-center">
                <p><a class="no-ajax" href="<?php echo base_url('reset/index'); ?>">Forgot Password?</a></p>
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