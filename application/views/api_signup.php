<!DOCTYPE html>
<?php if (!empty($this->session->userdata('merchant_name')))
{
    header('Location:  '.  'https://salequick.com/merchant'  );
}
?>
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




.logo{
  width: auto !important;
  max-height: 50px;
  text-align: center;
  margin: 20px auto 2rem !important;
}


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

    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    width: 40%;

}
.login-sec .input-group {
      margin-bottom: 20px;
}

.login-sec .input-group .input-group-addon{
      padding: 6px 10px; 
      border: 0px solid #ddd; 
      border-radius: 30px 0px 0px 30px;
      background: #fff;

}
.login-sec .input-group .input-group-addon img{
      max-width: 35px;
}


.login-sec .input-group input{
      border-radius: 0px 30px 30px 0px !important;
      height: 50px;
      text-align: center;
      border: 0px solid #ddd;
      font-size: 18px;
      font-weight: 600;
      color: #69c;
}

login-sec .input-group input:focus{
         border-radius: 0px 30px 30px 0px !important;
      height: 50px;
      text-align: center;
      border: 0px solid #ddd;
      font-size: 18px;
      font-weight: 600;
      color: #69c;
}
.login-sec .input-group input::placeholder{
      font-size: 18px;
      font-weight: 600;
      color: #69c;
}
.form-check .btn{
    padding: 15px 30px;
    width: 250px;
    border-radius: 30px;
    background-color: #00dcbe;
    font-weight: 600;
    font-size: 16px;
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
    transition: all ease .3s;
}
.form-check .btn:hover{
    box-shadow: 0 8px 17px 2px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);
}

.sky_text{
  color: #00dcbe;
}
.white_text{
  color: #fff !important;
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



/*.logo{ width:270px; margin:20px auto; float:none; } */

</style>

</head>

<body>

<!-- Preloader Start -->



<!-- Contact Section Start -->

<section class="login-block">

  <div class="container">

    <?php echo $this->session->flashdata('smsg'); ?>

  <div class="row">

    <div class="login-sec">

     

      <div class="logo"><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="" /></a></div>

     <!-- <h1 class="white_text text-center">Sign Up  </h1>-->
       <div class="row">

      <!--<p class="boldText">Individual account</p>

      <p>Shop, send and receive payments. All without sharing your financial information.</p>-->

      <div style="color:red;"><?php echo validation_errors(); ?></div>

      

      <form action="<?php echo base_url('Api_registration/create_signup');?>" method="post">



        <div class="input-group">
            <span class="input-group-addon">
                 <img src="<?php echo base_url('front/img/email.png'); ?>" alt="" />
                </span>


        <input type="text" class="form-control" name="f_name" pattern="[a-zA-Z\s]+" placeholder="Company Name" required> 

        </div>

        

      

      

       <div class="input-group">
          <span class="input-group-addon">
                 <img src="<?php echo base_url('front/img/phone.png'); ?>" alt="" />
                </span>


        <input type="text" class="form-control" name="mobile" id="phone" placeholder="Phone"  onKeyPress="return isNumberKey(event)" required>        

        </div>

         <div class="input-group">
            <span class="input-group-addon">
                 <img src="<?php echo base_url('front/img/mail.png'); ?>" alt="" />
                </span>


        <input type="text" class="form-control" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>        

        </div>

        <div class="input-group">
            <span class="input-group-addon">
                 <img src="<?php echo base_url('front/img/pass.png'); ?>" alt="" />
            </span>


         <input type="password" class="form-control" name="password" placeholder="Password" required />        

        </div>

        

      

      

     

      <div class=" clearfix"></div>

  <div class=" col-sm-12 text2 white_text" style="display:none;">    

<div class="white_text">By clicking the button below, I agree to be bound by Sale Quick user agreement and the  Privacy Policy</div>

<div class="checkbox">

      <label>

        <input type="checkbox" checked required> I agree to receive marking communication from Sale Quick. I can change my notification preferences at any time.

      </label>

    </div>

       </div>

      

      <div class="btns form-check text-center form-group">

        <!-- <input type="submit" name="submit" class="btn btn-primary" value="Submit" /> -->
        <button type="submit" name="submit" value="submit" class="btn white_text">SignUp Now</button>

      </div>

      <p class="white_text text-center">  Already have an account ! <a class="sky_text" href="<?php echo base_url('login'); ?>">  Login Now</a></p>

      </form>

      

      

      <div class=" clearfix"></div>

      </div>

      

    </div>

 <!--    <div class="col-md-8 banner-sec"> </div> -->

  </div>

</section>

<script>
            var resizefunc = [];
        </script>

        <!-- Plugins  -->




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

  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/masking.js"></script>



     <script >
                                            
  $(function(){
  
  $("#phone").mask("(999) 999-9999");


  $("#phone").on("blur", function() {
      var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );

      if( last.length == 5 ) {
          var move = $(this).val().substr( $(this).val().indexOf("-") + 1, 1 );

          var lastfour = last.substr(1,4);

          var first = $(this).val().substr( 0, 9 );

          $(this).val( first + move + '-' + lastfour );
      }
  });
}); 






function isNumberKey(evt){

    var charCode = (evt.which) ? evt.which : event.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;

    return true;

}

</script>

<!-- Scripts Js End -->

</body>

</html>