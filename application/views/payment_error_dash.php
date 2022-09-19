<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>:: Payment Error ::</title>
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>new_assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    </head>

    <?php
        function color_inverse($color){
            $color = str_replace('#', '', $color);
            if (strlen($color) != 6) {
                return '000000';
            }
            $rgb = '';
            for ($x=0;$x<3;$x++) {
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
        body {
            font-family: 'Open Sans', sans-serif;
            width: 100%;
            height: 100%;
        }
        td, th {
            vertical-align: top;
            text-align: left;
        }
        p {
            font-size: 13px;
            color: #878787;
            line-height: 30px;
            margin: 4px 0px;
        }
        .custom-btn {
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
        .custom-btn:hover,.custom-btn:focus {
            outline: none;
            background-color: <?php echo $color2?$color2:'transparent'; ?> !important;
            border-color: #<?=$itemm[0]['color'];?>;
            color: #<?=$itemm[0]['color'];?>;
        }
        .invoice-wrap {
            display: table;
            max-width: 972px;
            width: 100%;
            margin: 30px auto 0;
            border-radius: 10px;
            -webkit-box-shadow: rgba(102, 102, 102, 0.09) 0px 0 20px;
            -moz-box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;
            box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;
        }
        .main-box {
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
        .privacy-txt:hover,.privacy-txt:focus {
            color: #4a90e2;
        }
        .top-div {
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            background: #fff;
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
            margin-top: 60px;
        }
        .footer_cards a{
            display: inline-block;
            vertical-align: top;
            margin-left: 7px;
        }
        .footer_address{
            padding-left: 15px;
            width: 25% !important;
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
          width: 200px !important;
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
        .btn-link {
            background: none!important;
            border: none;
            padding: 0!important;
            font-family: arial, sans-serif;
            color: #B9B9B9;
            text-decoration: underline;
            cursor: pointer;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 15px;
        }
    </style>
    <body style="margin:0 auto;padding: 0;">
        <div class="main-box">
            <div class="invoice-wrap">
                <div class="top-div">
                    <div class="onlyMessageSection">
                        <div class="svgAlertWraper"> 
                            <img src="<?php echo base_url('new_assets/img/big_cross.png'); ?>">
                        </div>
                        <h2 style="color: red !important;"><?= !empty($paymentdata) ? 'Payment Declined!' : $response_msg; ?></h2>
                        <!-- <button style="color: #B9B9B9 !important" onclick="goBack()"><h3>Back to Payment</h3></button> -->
                        <?php if($paymentdata) { ?>
                             <?php

                        $getMerchant = $this->db->query("SELECT payroc from merchant where id = ".$paymentdata['merchant_id']." ");
                        $getMerchantData = $getMerchant->result_array();
                      
                          $payroc = $getMerchantData[0]['payroc'];
                                            if($payroc==1){ ?>

                          <form action="<?php echo base_url('payment_card_payment');?>" method="post">
                      <?php  }  else { ?>
               <form action="<?php echo base_url('card_payment');?>" method="post">
                               
                        <?php     } ?>
                                <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($paymentdata) ) ? $paymentdata['id'] : set_value('bct_id');?>" readonly required>
                                <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($paymentdata) ) ? $paymentdata['payment_id'] : set_value('bct_id1');?>" readonly required>
                                <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($paymentdata) ) ? $paymentdata['merchant_id'] : set_value('bct_id2');?>" readonly required>
                                <input type="hidden" class="form-control" name="mobile" readonly pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)" value="<?php echo (isset($paymentdata) ) ? $paymentdata['mobile_no'] : set_value('mobile');?>" required>
                                <input type="hidden" class="form-control" name="email" value="<?php echo (isset($paymentdata) ) ? $paymentdata['email_id'] : set_value('email');?>" readonly pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>
                                <input type="hidden" class="form-control" name="amount" value="<?php echo (isset($paymentdata) ) ? $paymentdata['amount'] : set_value('amount');?>" readonly  required>
                                <input type="submit" name="submit" class="btn-link" value="Back To Payment">
                            </form>
                        <?php } ?>

                        <?php echo $this->session->flashdata('cmsg'); ?>
                        <?php if($paymentdata) { ?>


                             <?php

                        $getMerchant = $this->db->query("SELECT payroc from merchant where id = ".$paymentdata['merchant_id']." ");
                        $getMerchantData = $getMerchant->result_array();
                      
                          $payroc = $getMerchantData[0]['payroc'];
                                            if($payroc==1){ ?>

                          <form action="<?php echo base_url('payment_card_payment');?>" method="post">
                      <?php  }  else { ?>
               <form action="<?php echo base_url('card_payment');?>" method="post">
                               
                        <?php     } ?>
                              

                           

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

                    <div class="footer-wraper">
                        <div class="footer_address" style="float: left;">
                            <span style="display: block;color: #404040;font-weight: 600;text-align: left;">
                                <?php if($itemm) echo $itemm[0]['business_dba_name']; ?>
                            </span>
                            <span style="display: inline-block;color:#666">
                                <?php if($itemm) echo $itemm[0]['address1']; ?>
                            </span>
                        </div>
                        <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
                            <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/terms_and_condition">Terms </a>& <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/privacy_policy">Privacy policy </a> | Powered by <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2"> SaleQuick.com </a>
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
<script>
function goBack() {
  history.go(-1);
}
</script>
    </body>
</html>