    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Contact Us : SaleQuick</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="front1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="front1/css/mega-menu.css" />
    <link rel="stylesheet" href="front1/css/icons.css">
    <link rel="stylesheet" type="text/css" href="front1/css/default.css" />
    <link rel="stylesheet" type="text/css" href="front1/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="front1/css/color.css" />
    
    <!-- Facebook Pixel Code -->


    <style>
    .fixed-bg.bg1 {
    background: #3393f2 !important;
    }
	.pricing_top .fixed-bg::after{ margin-left: -26px;}
	
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
    <div class="theme-layout">
    <header class="stick">
    <div class="logo">
    <a href="
    <?php echo base_url(); ?>" title="">
    <img src="front1/images/logo-w.png" alt="">
    </a>
    </div>
    <div class="container-div">
    <nav class="menu-4">
    <div class="collapse navbar-collapse js-navbar-collapse">
        <ul class="nav wtf-menu">
             
            <li>
                <a href="
                    <?php echo base_url(); ?>#How">How it works
                </a>
            </li>
            <li>
                <a href="
                    <?php echo base_url(); ?>#Suit">Payment Solutions
                </a>
            </li>
            <li>
                <a href="
                    <?php echo base_url('pricing'); ?>" title="">Pricing
                </a>
            </li>
            <?php /*?><li><a href="<?php echo base_url('api_new'); ?>" title="">API</a></li><?php */?>
            <li>
                <a href="
                    <?php echo base_url('contact_us'); ?>">Contact Us
                </a>
            </li>
            <li class="parent">
                <a href="" title="">
                    <i class="fa fa-ellipsis-v"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="
                            <?php echo base_url('login'); ?>" title="">Login
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.nav-collapse -->
    </nav>
    </div>
    <a class="menu-btn" href="#" title="">
    <i class="fa fa-bars"></i>
    </a>
    </header>
    <section id="home">
    <div class="block wave remove-bottom home_top pricing_top">
    <div class="fixed-bg bg1 stop"></div>
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="slash-featured scrollme">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <div class="featured-text">
                            <h2 class="uppercase title">
        CONTACT US
    </h2>
                           
                        </div>
                    </div>
                </div>
               
            </div>
           
        </div>
    </div>
    </div>
    </div>
    </section> 
    <section id="pricing" class="text-center">
    <div class="container">
    <div class="row">
    <h1 style="text-align: center; border-radius: 50%; margin: 10px auto 20px; padding: 10px;">
        <?php echo $this->session->flashdata('pmsg'); ?>
    </h1>
    <h2 class="title"> Contact Us</h2>
    <p>In any Case</p>
    </div>
    <div class="row">
    <div class="support_form">
         <form action="<?php echo base_url('pricing1');?>" method="post" >
            <div class="col-md-5 col-xs-12">
                <div class="col-md-12">
                    <h3>Sales</h3>
                </div>
                <div class="form-group col-md-12">
                    <input type="text" name="name" placeholder="Your Name" required />
                </div>
                <div class="form-group col-md-12">
                    <input type="text" id="sales_phone" name="phone" placeholder="Your Phone Number" required />
                </div>
                <div class="form-group col-md-12">
                    <input type="email" name="Email" placeholder="Your Email" required style="text-transform: none;" />
                </div>
                 <div class="form-group col-md-12">
  <div class="g-recaptcha" data-sitekey="6LfrQYoUAAAAACflnqPjCo8L45wdViPWOtNMoRf_" data-callback="verifyCaptcha"></div>
  
  
                                                        </div>
                 <!--  <div class="form-group col-md-12">
                    <input type="text" name="estimatedmonthluvolume" placeholder="Estimated Monthly Volume" required />
                </div>
               <div class="form-group select_box col-md-12">
                    <select required="" name="client">
                        <option value="">Are You our client?</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div> -->
                <!-- <div class="form-group select_box col-md-12">
                    <select required="" name="subject">
                        <option value="">What subject do You need help with?</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div> -->
                <!-- <div class="form-group select_box col-md-12">
                    <select  required="" name="time">
                        <option value="">What time should we contact You?</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div> -->
                <div class="form-group">
                    <!--   <button class="simple-btn btn-lg">Send Request</button> -->
                    <input class="simple-btn btn-lg" style="margin-top:155px;" type="submit" name="submit"  value="Send Request">

                    

                    </div>
                </div>
            </form>
            <div class="col-md-2">
                <div class="vertical_line">
                    <span>  OR</span>
                </div>
            </div>
            <form action="<?php echo base_url('pricing1');?>" method="post">
                <div class="col-md-5 col-xs-12">
                    <div class="form-group">
                        <h3>Support</h3>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" name="name" required placeholder="Your Name" />
                    </div>
                      <div class="form-group col-md-12">
                    <input type="text" id="support_phone" name="phone" placeholder="Your Phone Number" required />
                </div>
                    <div class="form-group col-md-12">
                        <input type="email" name="email" required placeholder="Your Email (so we contact You back)" style="text-transform: none;" />
                    </div>
                   <div class="form-group select_box col-md-12">
                    <select required="" name="subject">
                        <option value="">What service do You need assistance with?</option>
                        <option >Point of Sale</option>
                        <option >Invoice</option>
                        <option >Recurring</option>
                        <option >Refunds</option>
                        <option >Chargebacks</option>
                    </select>
                </div> 
                    <div class="form-group col-md-12">
                        <textarea name="message" required placeholder="Your Message" style="min-height:120px;"></textarea>
                    </div>
                     <div class="form-group col-md-12">
                                                     <div class="g-recaptcha" data-sitekey="6LfrQYoUAAAAACflnqPjCo8L45wdViPWOtNMoRf_"></div>
                                                        </div>
                    <div class="form-group">
                        <!--   <button class="simple-btn btn-lg">Send Message</button> -->
                        <input class="simple-btn btn-lg" type="submit" name="submit1"  value="Send For Help">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>or just reach us out 24/7</h3>
                <h2>
                    <b>
                        <i class="fa fa-phone"></i> 877.875.3111
                    </b>
                </h2>
            </div>
        </div>
    </div>
    </section>
    <section id="info" class="text-center m-t-100">
    <div class="container">
        <div class="row m-b-30">
            <h2 class="text-white">Stay up-to-date</h2>
            <h2 class="text-white">with our latest promotions</h2>
        </div>
        <div class="row">
            <div class="support_form">
                <div class="col-md-8 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-7">
                                <input type="text" class="btn_input" placeholder="you@gmail.com" />
                            </div>
                            <div class="col-md-5 text-left">
                                <button class="simple-btn btn-lg side_btn" style="">Send Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <footer class="bg_dark">
    <div class="container text-left">
        <div class="row">
            <div class="footer_link">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <ul class="foot_list_link">
                        <li>
                            <a> Merchant</a>
                        </li>
                        <li>
                            <a> E-Commerce</a>
                        </li>
                        <li>
                            <a> Travel</a>
                        </li>
                        <li>
                            <a> Financial Service</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 text-center col-xs-12 col-sm-4">
                    <ul class="foot_list_link ">
                        <li>
                            <a>   Contact Sales</a>
                        </li>
                        <li>
                            <a>  Contact TechSupport</a>
                        </li>
                       <li><a href="<?php echo base_url('api_new'); ?>" title="">API</a></li>
                        <li>
                            <a>  Career</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 text-right col-xs-12 col-sm-4">
                    <ul class="foot_list_link ">
                        <li>
                            <a> Developer</a>
                        </li>
                        <li>
                            <a> Terms Of Service</a>
                        </li>
                        <li>
                            <a> Privacy Policy</a>
                        </li>
                        <li>
                            <a> Partners</a>
                        </li>
                    </ul>
                </div>
               
            </div>
        </div>
        <div class="center_bar"></div>
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <p class="text-left text-white"></p>
                </div>
                  <div class="col-md-4 col-sm-4">
                <p class="text-center text-white">Copyright 2019 | SaleQuick. All right reserved.</p>
            </div>
        </div>
    </div>
    </footer>
    </div>
    <script src="front1/js/jquery.min.js" type="text/javascript"></script>
    <script src="front1/js/owl.carousel.min.js"></script>
    <script src="front1/js/wow.min.js"></script>
    <script src="front1/js/jquery.combinedScroll.js"></script>
    <script src="front1/js/jquery.scrollme.min.js"></script>
    <script src="front1/js/bootstrap.min.js"></script>
    <script src="front1/js/simpleLightbox.min.js"></script>
    <script src="front1/js/script.js" type="text/javascript"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/masking.js"></script>

     <script>
function submitUserForm() {
    var response = grecaptcha.getResponse();
    if(response.length == 0) {
        document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">This field is required.</span>';
        return false;
    }
    return true;
}
 
function verifyCaptcha() {
    document.getElementById('g-recaptcha-error').innerHTML = '';
}
</script>
    <script>
    function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    	return false;
    return true;
    }
    $(document).ready(function(e) {
    $("#sales_phone").mask("(999) 999-9999");
    	$("#support_phone").mask("(999) 999-9999");
    });
    </script>
    </body>
    </html>
