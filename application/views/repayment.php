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




<!-- Facebook Pixel Code -->



<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/meanmenu.min.css"); 

?>" />

<link rel="stylesheet" type="text/css"  href="<?php echo base_url("front/css/responsive.css"); ?>" />



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



.logo{ width:270px; margin:20px auto; float:none; } 

</style>

</head>

<body>

<!-- Preloader Start -->

<div class="logo"><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="" /></a></div>

<!-- Contact Section Start -->

<section class="login-block">

  <div class="container">

    <?php echo $this->session->flashdata('pmsg'); ?>

  <div class="row">

    <?php if($resend!='') { ?>

    <div class="col-md-7 login-sec">

      <div class="signup-iner">

      

      <h2>Payment Detail.  </h2>

    

      <div style="color:red;"><?php echo validation_errors(); ?></div>

      

     <form action="<?php echo base_url('rec_payment');?>/<?php echo $this->uri->segment(2) ?>/<?php echo  $this->uri->segment(3) ?>" method="post">



     



        <div class="form-group col-sm-6">

           <label> Name </label>

        <input type="text" class="form-control" name="name" pattern="[a-zA-Z\s]+" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" readonly required>



        <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>  





        <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required> 



<input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required> 

  

        

        </div>

        

      

      

       <div class="form-group col-sm-6">

         <label> Mobile No </label>

        <input type="text" class="form-control" name="mobile" readonly pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>        

        </div>

         <div class="form-group col-sm-6">

           <label> Email Id </label>

        <input type="text" class="form-control" name="email" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" readonly pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>        

        </div>



        <div class="form-group col-sm-6">

          <label> Amount </label>

        <input type="text" class="form-control" name="amount" value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>" readonly  required>        

        </div>

        

        

      

      

     

      <div class=" clearfix"></div>

  <div class=" col-sm-12 text2 ">    

<div>By clicking the button below, I agree to be bound by Sale Quick user agreement and the  Privacy Policy</div>

<div class="checkbox">

      <label>

        <input type="checkbox" required> I agree to receive marking communication from Sale Quick. I can change my notification preferences at any time.

      </label>

    </div>

       </div>

      

      <div class="btns">

        <input type="submit" name="submit" class="btn btn-primary pull-right" value="Proceed">

      </div>

      </form>

      

      

      <div class=" clearfix"></div>

      </div>

      

    </div>

    <?php } ?>

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