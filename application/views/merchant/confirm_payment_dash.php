<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>:: Payment Success ::</title>
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>new_assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    </head>

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
        .main-box {
            width: 100%;
            height: 100%;
            padding: 0 15px;
            float: left;
            max-width: 100%;
            clear: both;
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
        .privacy-txt {
            color: #666;
        }
        .privacy-txt:hover,.privacy-txt:focus {
            color: #4a90e2;
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
        
    </style>
    <body style="margin:0 auto;padding: 0;">
        <div class="main-box">
            <div class="invoice-wrap">
                <div class="top-div">
                    <div class="onlyMessageSection">
                        <div class="svgAlertWraper"> 
                            <img src="<?php echo base_url('new_assets/img/big_tick.png'); ?>">
                        </div>
                        <h2 style="color: #4BB543 !important;">Payment Successful</h2>
                        <a style="color: #B9B9B9 !important" href="<?php echo base_url().'pos/all_pos'; ?>"><h3>Go to Transaction List</h3></a>
                    </div>

                    <div class="footer-wraper">
                        <div class="footer_address" style="float: left;">
                            <span style="display: block;color: #404040;font-weight: 600;text-align: left;"></span>
                            <span style="display: inline-block;color:#666"></span>
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
    </body>
</html>