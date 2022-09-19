<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
     <link href="<?php echo base_url("assets/dist/css/AdminLTE.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url("assets/plugins/iCheck/square/blue.css"); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b> Admin</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Reset your password</p>
 
    <?php 
          $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
          echo form_open("reset/index", $attributes);?>	
       <form>
		
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="admin_email" id="admin_email" placeholder="Register Email" autocomplete="off" />
            
           
                    <span class="text-danger"><?php echo form_error('admin_email'); ?></span>
            
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
         
          <div class="row">
            <div class="col-xs-8">    
                                    
            </div>
            <div class="col-xs-4">
             
           <button type="submit" id="btn_login" name="btn_login" value="Reset" class="btn btn-primary btn-block btn-flat">Reset</button>
            </div><!-- /.col -->
          </div>
        </form>
         <?php echo form_close(); ?>
          <?php echo $this->session->flashdata('msg'); ?>

      <!--  <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div>-->
        <!-- /.social-auth-links -->

        <a href="<?php echo base_url('admin'); ?>">Sign in to your account</a><br>
        <!--<a href="register.html" class="text-center">Register a new membership</a>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

     <!-- jQuery 2.1.3 -->
     <script src="<?php echo base_url("assets/plugins/jQuery/jQuery-2.1.3.min.js"); ?>"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url("assets/plugins/iCheck/icheck.min.js"); ?>" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>