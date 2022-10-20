<?php 
// if (($this->session->userdata('username')))
// {
//     header('Location:  '.  'https://salequick.com/dashboard');
// }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Mobile Credit Card Processing APP | Payment Processing | Salequick">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title> Admin / Subadmin Login </title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
    <!-- links -->
    <link href="<?php echo base_url(); ?>new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>new_assets/css/style.css">
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
        .outer-page-wrapper{
          color: rgba(255,255,255,0.7);
        }
        .log-reg-box-inner {
            max-width: 365px !important;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
           
            $attributes = array("class" => "form-horizontal custom-form", "id" => "loginform", "name" => "loginform");
            echo form_open("login_admin/index", $attributes);
          ?>
            <div class="col-12">
              <div class="logo-wrapper-outer clearfix">
                  <a  href="<?php echo base_url(); ?>" class="logo-wrapper no-ajax">
                    <img src="<?php echo base_url('new_assets/img/logo-w.png'); ?>" alt="Salequick">
                  </a>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group ">
               <p>Admin/Sub Admin Login</p>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <input type="email" class="form-control"  placeholder="Email" required id="username" name="username">
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
                    <div class="g-recaptcha" data-sitekey="6LdsrTMiAAAAACJvbmyBzlOeMRfBnHt9yQsIrN-j"></div>
                </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <div class="custom-checkbox ">
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