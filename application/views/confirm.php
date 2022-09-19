<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="SaleQuick">
<meta name="keywords" content="SaleQuick">
<meta name="author" content="SaleQuick">
<!-- Title -->
<title>:: Sale Quick ::</title>
<!-- Favicon Icon -->
<link rel="icon" type="image/png" href="img/favicon.png">

<!-- Stylesheets Start -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/bootstrap.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/font-awesome.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/magnific-popup.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/owl.carousel.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/animate.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/main.css"); ?>" />



<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/meanmenu.min.css"); 
?>" />
<link rel="stylesheet" type="text/css"  href="<?php echo base_url("front/css/responsive.css"); ?>" />


<!-- Facebook Pixel Code -->


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<style>

body{ background: #6699cc !important;}


.login-block {
  background: #6699cc;  /* fallback for old browsers */
  background: #6699cc;
  background: #6699cc;
  float: left;
  width: 100%;
  padding : 50px 0;
}
.banner-sec {
  
  
}
.container {
  
  
}
.carousel-inner {
  border-radius: 0 10px 10px 0;
}
.carousel-caption {
  text-align: left;
  left: 5%;
}
.login-sec {
  padding: 20px 20px;
  position: relative;
  background-color: #fff;
    margin: 0 auto;
    float: none;
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
.login-sec h2:after{
    display: none;
}

.logo{ width:270px; margin:20px auto; float:none; } 
</style>
</head>
<body>
<!-- Preloader Start -->
<div class="logo"><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="" /></a></div>
<!-- Contact Section Start -->
<section class="login-block">
  <div class="container">
   <?php echo $this->session->flashdata('cmsg'); ?>
  <div class="row">
    <div class="col-md-7 login-sec">
      <div class="signup-iner">
      
      <h2 class="text-center"> <a class="text-primary" href="<?php echo base_url('login'); ?>"> Login Now.  </a> </h2>
     
      </div>
      
    </div>
    <div class="col-md-8 banner-sec"> </div>
  </div>
</section>
<script>


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>

<!-- Scripts Js Start --> 
<script src="<?php echo base_url("front/js/jquery.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/bootstrap.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/jquery.magnific-popup.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/owl.carousel.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/owl.animate.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/jquery.scrollUp.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/jquery.counterup.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/modernizr.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/waypoints.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/jquery.meanmenu.min.js"); ?>"> </script> 
<script src="<?php echo base_url("front/js/custom.js"); ?>"> </script> 
<!-- Scripts Js End -->
</body>
</html>