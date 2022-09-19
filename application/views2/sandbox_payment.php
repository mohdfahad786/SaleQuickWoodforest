<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Invoice ::</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<style>
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
.custom-btn
{background-color: #0077e2 !important;
border-radius: 4px;
text-transform: uppercase;
padding: 10px 30px;
font-size: 13px;
text-decoration: none;
float: right;
color: #fff;
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
border: 0;}
.invoice-wrap {
    float: left;
    display: block;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    margin-left: 14%;
    width: 72%;
    background-color: #fff;
    box-shadow: 0px -2px 17px -2px #7b7b7b;
    -moz-box-shadow: 0px -2px 17px -2px #7b7b7b;
    -webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;
}
.main-box {
    width: 100%;
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    padding: 80px 0px 10px 0px;
    display: inline-block;
    overflow: hidden;
    float: left;
    background-image: -webkit-linear-gradient(#<?= $itemm[0]['color'] ?>,#<?= $itemm[0]['color'] ?>);
    background-image: -moz-linear-gradient(#<?= $itemm[0]['color'] ?>,#<?= $itemm[0]['color'] ?>);
    background-image: linear-gradient(#<?= $itemm[0]['color'] ?>,#<?= $itemm[0]['color'] ?>);
    background-size: 100% 190px;
    background-position: center top;
    background-repeat: no-repeat;
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
    max-width: 100%;
}
.footer-wraper>div{
    max-width: 1000px;
    padding: 0;
    text-align: center;
    font-size: 14px;
    width: 100%;
    clear: both;
    margin: 91px auto 0;
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
    .invoice-wrap {
        margin-left: 10%;
        width: 80%;
    }
    .main-box {
        padding: 50px 0px;
    }
    .sixty-div {
        width: 40%;
    }
    .fourty-div {
        width: 60%;
    }
}
@media only screen and (min-width:481px) and (max-width:768px) {
    .invoice-wrap {
        margin-left: 6%;
        width: 88%;
    }
    .main-box {
        padding: 30px 0px;
    }
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
    .invoice-wrap {
        margin-left: 5%;
        width: 90%;
    }
    .bottom-div {
        padding: 20px 20px;
    }
    .top-div {
        padding: 20px 20px;
    }
}
@media only screen and (max-width:480px) {
    .table-change-mobile tr:nth-child(1){
  display: inline-block;
  float:left;
  width: auto;
}
.table-change-mobile tr:nth-child(2){
  display: inline-block;
  float:right;
  width:auto;
}
.table-change-mobile tr:nth-child(1) th{
   display: block;
line-height: 28px;
font-size: 13px;
border-bottom: 0;
padding: 4px
  
}

.table-change-mobile tr:nth-child(2) td{
  display: block;
line-height: 28px;
font-size: 13px;
padding: 4px;
border: 0 !important;

}
.table-change-mobile
{
   display: inline-grid; 
}

}

</style>
<body style="margin:0 auto;padding: 0;">
    <div class="main-box">
        <div class="invoice-wrap">
            <div class="top-div">
                <div class="float-left">
                  <?php if($resend!='') { ?>
                    <div style="color:red;"><?php echo validation_errors(); ?></div>
                    <p><img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>" width="200px"></p>
                    <!--<p style="margin-top: 20px;text-transform: uppercase;line-height: 15px;color:#000;">Recipient</p>-->
                    <!--<p style="margin-bottom: 0px;margin-top: 0px;line-height: 15px;"><?php echo $name  ;?></p>-->
                     <h4 style="margin-bottom: 0px;color:#000; "><?= $itemm[0]['business_dba_name'] ?> </h4>
                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
                            <p style="color: #878787; margin-top: 0px;">Telephone:<?= $itemm[0]['mob_no'] ?></p>
                </div>
                <div class="float-right">
                    <h3 style="text-transform: uppercase;margin-bottom: 0;">Invoice</h3>
                    <p style="line-height: 20px;margin-top: 10px">
                        <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
                        <span style="display: block;"><?php echo $invoice_no ;?></span></p>
                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
                            <span style="display: block;"><?php $originalDate = $date_c;
                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span></p>
                        </div>
                    </div>
                    <div class="bottom-div twenty-div table-change-mobile">
                        <table width="100%" border="1">
                            <tr>
                                <th >Name</th>
                                <th >Phone</th>
                                 <th>Reference </th>
                               
                                <th >Amount</th>
                            </tr>
                          
                                           <tr>
                                              <td ><?php   echo  $name ;?></td>
                                              <td><?php   echo  $mobile ;?></td>
                                              <td><?php  if($reference =='0'){echo 'N/A';}else {echo $reference; } ?></td>
                                             
                                          <td >$<?php   echo $number = number_format($amount,2) ;?></td>
                                      </tr>
                                     
                          <tr>
                            <td style="border-bottom: 0px !important;"></td>
                            <td style="border-bottom: 0px !important;"></td>
                            <td style="border-bottom: 0px !important;">
                               
                            </td>
                            <td style="border-bottom: 0px !important;"></td>
                            <td style="border-bottom: 0px !important;">
                              
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
                       <?php $color = $itemm[0]['color']; ?>
                       <form action="<?php echo base_url('card_payment');?>" method="post">
                           <input type="hidden" class="form-control" name="color" value="<?php echo (isset($color) && !empty($color)) ? $color : set_value('color');?>" readonly required>
                          <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>
                          <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required>
                          <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required>
                          <input type="hidden" class="form-control" name="mobile" readonly pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>
                          <input type="hidden" class="form-control" name="email" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" readonly pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>
                          <input type="hidden" class="form-control" name="amount" value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>" readonly  required>
                          <input type="submit" name="submit" class="custom-btn" value="CONTINUE TO PAYMENT">
                      </form>
                  </div>
              </div>
          <?php } else {?>
           <h1 style="text-align: center; border-radius: 50%; margin: 10px auto 20px; padding: 10px;"><?php echo $this->session->flashdata('pmsg'); ?></h1>
       <?php } ?>
   </div>
    <div class="footer-wraper" >
        <div >
            <div class="footer_address" style="float: left;">
                <span style="display: block;"><?php echo $itemm[0]['business_dba_name']   ;?></span>
                <span style="display: inline-block;color:#666"><?php echo $itemm[0]['address1']   ;?> </span>
            </div>
            <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
                <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2">Powered by SaleQuick.com </a>
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
</body>
</html>