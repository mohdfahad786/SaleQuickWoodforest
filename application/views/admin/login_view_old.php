<?php if (($this->session->userdata('username')))
{
    header('Location:  '.  'https://salequick.com/dashboard'  );
}
?>
<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">

    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">

    <title>SubAdmin | Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">

    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/font-awesome.min.css "); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/magnific-popup.css "); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/owl.carousel.min.css "); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/animate.css "); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/main.css "); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/meanmenu.min.css "); 

?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(" front/css/responsive.css "); ?>" />

    <!--  <link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">

        <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style1.css" rel="stylesheet" type="text/css">

        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script> -->

</head>
<style>
    body {
        background: #6699cc !important;
    }
    
    .logo {
        width: auto !important;
        max-height: 50px;
        text-align: center;
        margin: 20px auto 5rem !important;
    }
    
    .login-block {
        background: #6699cc;
        /* fallback for old browsers */
        background: #6699cc;
        background: #6699cc;
        float: left;
        width: 100%;
        padding: 50px 0;
    }
    
    .banner-sec {}
    
    .container {}
    
    .carousel-inner {
        border-radius: 0 10px 10px 0;
    }
    
    .carousel-caption {
        text-align: left;
        left: 5%;
    }
    
    .login-sec {
        /*
padding: 50px 30px;
 position: relative;
  background-color: #fff;
    margin: 0 auto;
    float: none;*/
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 40%;
    }
    
    .login-sec .input-group {
        margin-bottom: 20px;
    }
    
    .login-sec .input-group .input-group-addon {
        padding: 6px 10px;
        border: 0px solid #ddd;
        border-radius: 30px 0px 0px 30px;
        background: #fff;
    }
    
    .login-sec .input-group .input-group-addon img {
        max-width: 35px;
    }
    
    .login-sec .input-group input {
        border-radius: 0px 30px 30px 0px !important;
        height: 50px;
        text-align: center;
        border: 0px solid #ddd;
        font-size: 18px;
        font-weight: 600;
        color: #69c;
    }
    
    login-sec .input-group input:focus {
        border-radius: 0px 30px 30px 0px !important;
        height: 50px;
        text-align: center;
        border: 0px solid #ddd;
        font-size: 18px;
        font-weight: 600;
        color: #69c;
    }
    
    .login-sec .input-group input::placeholder {
        font-size: 18px;
        font-weight: 600;
        color: #69c;
    }
    
    .form-check .btn {
        padding: 15px 30px;
        width: 250px;
        border-radius: 30px;
        background-color: #00dcbe;
        font-weight: 600;
        font-size: 16px;
        box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        transition: all ease .3s;
    }
    
    .form-check .btn:hover {
        box-shadow: 0 8px 17px 2px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
    }
    
    .sky_text {
        color: #00dcbe;
    }
    
    .white_text {
        color: #fff;
    }
    
    .login-sec .copy-text {
        position: absolute;
        width: 80%;
        bottom: 20px;
        font-size: 13px;
        text-align: center;
    }
    
    .login-sec .copy-text i {
        color: #FEB58A;
    }
    
    .login-sec .copy-text a {
        color: #6772e5;
    }
    
    .login-sec h2 {
        margin-bottom: 30px;
        font-weight: 800;
        font-size: 30px;
        color: #6772e5;
    }
    
    .login-sec h2:after {
        content: " ";
        width: 100px;
        height: 5px;
        background: #FEB58A;
        display: block;
        margin-top: 20px;
        border-radius: 3px;
        margin-left: auto;
        margin-right: auto
    }
    
    .btn-login {
        background: #6772e5;
        color: #fff;
        font-weight: 600;
    }
    
    .banner-text {
        width: 70%;
        position: absolute;
        bottom: 40px;
        padding-left: 20px;
    }
    
    .banner-text h2 {
        color: #fff;
        font-weight: 600;
    }
    
    .banner-text h2:after {
        content: " ";
        width: 100px;
        height: 5px;
        background: #FFF;
        display: block;
        margin-top: 20px;
        border-radius: 3px;
    }
    
    .banner-text p {
        color: #fff;
    }
    
    .logo {
        width: 200px;
        margin: 20px auto;
        float: none;
    }
    .login-sec .alert
    {
        width:100% !important;
    }
</style>

<body>

    <div class="login-form">

        <section class="login-block">

            <div class="container">

                <div class="row">

                    <div class="col-md-12 login-sec">

                        <div class="logo">

                            <a href="<?php echo base_url(); ?>" " title=" "><img src="<?php echo base_url( 'front/images/logo-w.png'); ?>" alt="" /></a></div>

                            <?php 
          $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
          echo form_open("login_admin/subadmin", $attributes);?> 

                            <form class="login-form">

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <img src="<?php echo base_url('front/img/email.png'); ?>" alt="" />
                                      </span>

                                    <input class="form-control" type="text" id="username" name="username" required="" placeholder="Username">
                                    <input type="hidden" class="form-control" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">

                                </div>

                                <div class="input-group">

                                    <span class="input-group-addon">
                                         <img src="<?php echo base_url('front/img/pass.png'); ?>" alt="" />
                                        </span>

                                    <input class="form-control" type="password" id="password" name="password" required="" placeholder="Password">

                                </div>

                                <div class="form-group text-left">

                                    <div class="checkbox checkbox-primary">

                                        <input id="checkbox-signup" type="checkbox">

                                        <label for="checkbox-signup white_text" style="font-size:16px;color:#fff;">

                                            Remember me

                                        </label>

                                    </div>

                                </div>

                                <div class="form-check text-center">

                                    <button id="btn_login" name="btn_login" class="btn btn-login" value="Login" type="submit">Log In

                                    </button>
                                    

                                    <br/>

                                    <br/>
                                     <p class="white_text">   <a href="<?php echo base_url('reset/subadmin'); ?>" class="white_text"><i class="fa fa-lock m-r-5"></i> Forgot your

                            password?</a></p>

                                </div>

                    </div>

                    

                    </form>

                    <?php echo form_close(); ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                </div>

                <script>
                    var resizefunc = [];
                </script>

                <!-- Plugins  -->

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
                <!-- Popper for Bootstrap -->

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/ssets/js/jquery.blockUI.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>//plugins/switchery/switchery.min.js"></script>

                <!-- Custom main Js -->

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>

                <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>

</body>

</html>