<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Invoice ::</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>new_assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<?php
       function color_inverse($color){
        $color = str_replace('#', '', $color);
        if (strlen($color) != 6){ return '000000'; }
        $rgb = '';
        for ($x=0;$x<3;$x++){
            $c = 255 - hexdec(substr($color,(2*$x),2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
        return '#'.$rgb;
      }
     
        $colordata=$itemm?$itemm[0]['color']:'#fff';
        $color2=color_inverse($colordata);
    ?>

<style>
  :after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
:after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body {
    font-family: 'Open Sans', sans-serif;
    width: 100%;
    height: 100%;
}
td,
th {
    vertical-align: top;
    text-align: left;
}
p {
    font-size: 13px;
    color: #878787;
    line-height: 30px;
    margin: 4px 0px;
}

.svgAlertWraper .red-stroke {
stroke: #FF6245; }
.svgAlertWraper .sawCross {
stroke-width: 6.25;
stroke-linecap: round;
position: absolute;
top: 54px;
left: 54px;
width: 40px;
height: 40px; }
.custom-btn
{
background-color: #<?=$itemm[0]['color'];?> !important;
border: 1px solid <?=$color2;?>;
border-radius: 4px;
text-transform: uppercase;
padding: 10px 30px;
font-size: 13px;
text-decoration: none;
float: right;
color: #fff;
-webkit-transition: all 0.3s ease 0s;
-o-transition: all 0.3s ease 0s;
transition: all 0.3s ease 0s;
-webkit-appearance: button;
-moz-appearance: button;
-ms-appearance: button;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-ms-touch-action: manipulation;
touch-action: manipulation;
cursor: pointer;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
-ms-border-radius: 4px;
}
.custom-btn:hover,.custom-btn:focus
{
    outline: none;
background-color: <?php echo $color2?$color2:'transparent'; ?> !important;
border-color: #<?=$itemm[0]['color'];?>;
color: #<?=$itemm[0]['color'];?>;
}
.invoice-wrap {
    display: table;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    max-width: 972px;
    width: 100%;
    background-color: #fff;
    -webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
    -moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
    box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
    margin: 30px auto 0;
}
.main-box {
    background-image: -webkit-linear-gradient( #<?=$itemm[0]['color'];?>,#<?=$itemm[0]['color'];?>);
    background-image: -moz-linear-gradient( #<?=$itemm[0]['color'];?>,#<?=$itemm[0]['color'];?>);
    background-image: linear-gradient( #<?=$itemm[0]['color'];?>,#<?=$itemm[0]['color'];?>);
    background-size: 100% 201px;
    background-position: top center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    padding: 0 15px;
    float: left;
    max-width: 100%;
    clear: both;
}
.privacy-txt {
    color: #666;
}
.svgAlertWraper .sawCross .first-line {
-webkit-animation: 0.7s draw-first-line ease-out;
animation: 0.7s draw-first-line ease-out; }
.svgAlertWraper .sawCross .second-line {
-webkit-animation: 0.7s draw-second-line ease-out;
animation: 0.7s draw-second-line ease-out; }
.privacy-txt:hover,.privacy-txt:focus {
    color: #4a90e2;
}
@media screen and (max-width: 768px) {
    .footer_address > span:first {
        display: inline-block;
        width: 100%;
    }
}
.top-div {
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    background: #fafafa;
    display: inline-block;
    width: 100%;
    float: left;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    padding: 20px 40px;
}
.twenty-div table {
    border-collapse: collapse;
    border: 0px;
}
.float-left {
    float: left;
    text-align: left
}
.float-right {
    float: right;
    text-align: right
}
.bottom-div {
    display: inline-block;
    float: left;
    padding: 20px 40px;
    width: 100%;
    box-sizing: border-box
}
.sixty-div {
    width: 60%;
    float: left;
    display: inline-block;
}
.fourty-div {
    width: 40%;
    float: right;
    display: inline-block;
}
.left-div {
    width: 50%;
    display: inline-block;
    float: left;
    font-size: 14px;
    color: #353535
}
.right-div {
    width: 50%;
    display: inline-block;
    float: left;
    text-align: right;
    font-size: 14px;
    color: #353535;
    font-weight: 600;
}
.twenty-div td {
    line-height: 50px;
    color: #000;
    font-size: 13px;
    border-bottom: 1px solid #cfcfcf !important;
    border: 0px;
}
.twenty-div th {
    color: #7e8899;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 13px;
    border: 0px;
}
.footer-wraper{
    float: left;
    width: 100%;
    clear: both;
    color: #666;
    max-width: 100%;
}
.footer-wraper>div{
    max-width: 1000px;
    padding: 0;
    text-align: center;
    font-size: 14px;
    width: 100%;
    clear: both;
    margin: 51px auto 11px;
    display: block;
}
.footer_cards a{
    display: inline-block;
    vertical-align: top;
    margin-left: 7px;
}
.footer-wraper>div::after,.footer-wraper>div::before,.footer-wraper::after,.footer-wraper:before{
    display: table;
    clear: both;
    content: "";
}
.footer_address{
    padding-left: 15px;
}
.footer_cards{
    padding-right: 15px;
}
.footer-wraper>div>div{
    margin-bottom: 11px;
}
.footer_address span:first-child{
    font-weight: 600;
}
.alert.alert-success{
      color: #7CB342;
}
.onlyMessageSection{
  padding: 21px 0;
  clear: both;
  width: 100%;
  text-align: center;
  min-height: 201px;
  font-weight: 600;
}
.svgAlertWraper{
  margin: 0 auto;
}
.alert.alert-danger,.text-danger {
    color: #FF6245;
    text-transform: capitalize;
}
.onlyMessageSection span.text-success,.onlyMessageSection span.text-danger {
    font-size: 21px;
    font-weight: 600;
    display: block;
    margin-bottom: 21px;
}
@media only screen and (max-width:820px){
    .footer-wraper>div>div{
        float: none !important;
    }
    .footer_address,.footer_cards{
        padding-right: 0px !important;
        padding-left: 0px !important;
    }
    .footer_t_c{
        padding-bottom: 7px;
    }
    .footer-wraper>div{
        margin: 51px auto 0;
    }
}
@media only screen and (min-width:769px) and (max-width:900px) {
    .sixty-div {
        width: 40%;
    }
    .fourty-div {
        width: 60%;
    }
}
@media only screen and (min-width:481px) and (max-width:768px) {
    .sixty-div {
        width: 40%;
    }
    .fourty-div {
        width: 60%;
    }
    .bottom-div {
        padding: 20px 20px;
    }
    .top-div {
        padding: 20px 20px;
    }
}
@media only screen and (max-width:400px) {
    .twenty-div {
     word-wrap: break-word;
 }
}
@media only screen and (max-width:375px) {
    .twenty-div {
     word-wrap: anywhere;
 }
}
@media only screen and (max-width:480px) {
    .float-right {
        text-align: center;
        width: 100%;
    }
    .float-left {
        text-align: center;
        width: 100%;
    }
    .fourty-div {
        width: 100%;
        float: right;
    }
    .sixty-div {
        width: 100%;
        text-align: center;
    }
    .bottom-div {
        padding: 20px 20px;
    }
    .top-div {
        padding: 20px 20px;
    }
}
@media screen and (max-width: 600px) {
    .onlyMessageSection{
      min-height: 101px
    }
}
.svgAlertWraper {
  position: relative;
  width: 150px; }
  .svgAlertWraper .saw-circle circle.path {
    stroke-dasharray: 330;
    stroke-dashoffset: 0;
    stroke-linecap: round;
    opacity: 0.4;
    -webkit-animation: 0.7s draw-circle ease-out;
    animation: 0.7s draw-circle ease-out;
}

@-webkit-keyframes draw-first-line {
  0% {
    stroke-dasharray: 0,56;
    stroke-dashoffset: 0; }
  50% {
    stroke-dasharray: 0,56;
    stroke-dashoffset: 0; }
  100% {
    stroke-dasharray: 56,330;
    stroke-dashoffset: 0; } }

@keyframes draw-first-line {
  0% {
    stroke-dasharray: 0,56;
    stroke-dashoffset: 0; }
  50% {
    stroke-dasharray: 0,56;
    stroke-dashoffset: 0; }
  100% {
    stroke-dasharray: 56,330;
    stroke-dashoffset: 0; } }

@-webkit-keyframes draw-second-line {
  0% {
    stroke-dasharray: 0,55;
    stroke-dashoffset: 1; }
  50% {
    stroke-dasharray: 0,55;
    stroke-dashoffset: 1; }
  100% {
    stroke-dasharray: 55,0;
    stroke-dashoffset: 70; } }

@keyframes draw-second-line {
  0% {
    stroke-dasharray: 0,55;
    stroke-dashoffset: 1; }
  50% {
    stroke-dasharray: 0,55;
    stroke-dashoffset: 1; }
  100% {
    stroke-dasharray: 55,0;
    stroke-dashoffset: 70; } }
.svgAlertWraper .saw-circle circle.path {
    stroke-dasharray: 330;
    stroke-dashoffset: 0;
    stroke-linecap: round;
    opacity: 0.4;
    -webkit-animation: 0.7s draw-circle ease-out;
    animation: 0.7s draw-circle ease-out;
}
@-webkit-keyframes draw-circle {
  0% {
    stroke-dasharray: 0,330;
    stroke-dashoffset: 0;
    opacity: 1; }
  80% {
    stroke-dasharray: 330,330;
    stroke-dashoffset: 0;
    opacity: 1; }
  100% {
    opacity: 0.4; } }

@keyframes draw-circle {
  0% {
    stroke-dasharray: 0,330;
    stroke-dashoffset: 0;
    opacity: 1; }
  80% {
    stroke-dasharray: 330,330;
    stroke-dashoffset: 0;
    opacity: 1; }
  100% {
    opacity: 0.4; } }
</style>
<body style="margin:0 auto;padding: 0;">
  
  <div class="main-box">
    <div class="invoice-wrap">
        <div class="top-div">
          <div class="onlyMessageSection">
            <div class="svgAlertWraper">
              <svg class="saw-circle red-stroke">
                  <circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/>
              </svg>
              <svg class="sawCross red-stroke">
                  <g transform="matrix(0.79961,8.65821e-32,8.39584e-32,0.79961,-502.652,-204.518)">
                      <path class="first-line" d="M634.087,300.805L673.361,261.53" fill="none"/>
                  </g>
                  <g transform="matrix(-1.28587e-16,-0.79961,0.79961,-1.28587e-16,-204.752,543.031)">
                      <path class="second-line" d="M634.087,300.805L673.361,261.53"/>
                  </g>
              </svg>
            </div>
            <?php echo $this->session->flashdata('cmsg'); ?>

            <?php if($paymentdata) { ?>
            <form action="<?php echo base_url('card_payment');?>" method="post">
                <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($paymentdata) ) ? $paymentdata['id'] : set_value('bct_id');?>" readonly required>
                <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($paymentdata) ) ? $paymentdata['payment_id'] : set_value('bct_id1');?>" readonly required>
                <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($paymentdata) ) ? $paymentdata['merchant_id'] : set_value('bct_id2');?>" readonly required>
                <input type="hidden" class="form-control" name="mobile" readonly pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)" value="<?php echo (isset($paymentdata) ) ? $paymentdata['mobile_no'] : set_value('mobile');?>" required>
                <input type="hidden" class="form-control" name="email" value="<?php echo (isset($paymentdata) ) ? $paymentdata['email_id'] : set_value('email');?>" readonly pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>
                <input type="hidden" class="form-control" name="amount" value="<?php echo (isset($paymentdata) ) ? $paymentdata['amount'] : set_value('amount');?>" readonly  required>
                <input type="submit" name="submit" class="custom-btn " value="RE-TRY TO PAYMENT">
            </form>
            <?php } ?>

          </div>
        <div class="footer-wraper" >
            <div >
                <div class="footer_address" style="float: left;">
                    <span style="display: block;color: #404040;font-weight: 600;text-align: left;"><?php if($itemm)  echo $itemm[0]['business_dba_name']   ;?></span>
                    <span style="display: inline-block;color:#666"><?php  if($itemm)  echo $itemm[0]['address1']   ;?> </span>
                </div>
                <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
                    <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/terms_and_condition">Terms </a>& <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/privacy_policy">Privacy policy </a> |
                    Powered by <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2"> SaleQuick.com </a>
                </div>
                 <div class="footer_cards" style="float: right;">
                    <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon1.jpg'); ?>" alt="" class="" /></a>
                    <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon2.jpg'); ?>" alt="" class="" /></a>
                    <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon3.jpg'); ?>" alt="" class="" /></a>
                    <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon4.jpg'); ?>" alt="" class="" /></a>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>