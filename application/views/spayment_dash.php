<!DOCTYPE html>

<html lang="en">

      <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>:: Invoice ::</title>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
            <link href="<?php echo base_url('/new_assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
            <script src="<?php echo base_url('/new_assets/js/jquery.min.js'); ?>"></script>
            <script src="<?php echo base_url('/new_assets/js/bootstrap.min.js'); ?>"></script>
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

            $late_grace_period = $itemm[0]['late_grace_period'];

            if($payment_type == 'recurring') {

                  $payment_date = date('Y-m-d', strtotime($recurring_pay_start_date. ' + '.$late_grace_period.' days'));

            } else {

                  $payment_date = date('Y-m-d', strtotime($due_date. ' + '.$late_grace_period.' days'));

            }

            $late_fee_status = $itemm[0]['late_fee_status'] ? $itemm[0]['late_fee_status'] : 0;

            $late_fee = $itemm[0]['late_fee'] ? $itemm[0]['late_fee'] : '';

            $colordata=$itemm[0]['color']?$itemm[0]['color']:'#fff';

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

                  background-color: #fff;

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

            .custom-btn{

                  background-color: #<?=$itemm[0]['color'];?> !important;

                  border: 1px solid <?=$color2;?>;

                  border-radius: 4px;

                  text-transform: uppercase;

                  padding: 10px 30px;

                  font-size: 13px;

                  text-decoration: none;

                  float: right;

                  color: <?=$color2;?>;

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

                  background-color: <?=$color2;?> !important;

                  border-color: #<?=$itemm[0]['color'];?>;

                  color: #<?=$itemm[0]['color'];?>;

            }

            .invoice-wrap {
                  display: block;
                  border-radius: 10px;
                  -moz-border-radius: 10px;
                  -webkit-border-radius: 10px;
                  max-width: 920px;
                  width: 100%;
                  background-color: #fff;
                  -webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
                  -moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
                  box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
                  /*-webkit-box-shadow: rgba(102, 102, 102, 0.09) 0px 0 20px;
                  -moz-box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;
                  box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;*/
                  margin: 30px auto 0;
            }

            .invoice-wrap::after,.invoice-wrap::before{

                  content: '';

                  display: table;

                  clear: both;

            }

            .main-box {

                  background-image: -webkit-linear-gradient( #<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : 'AF7AC5';?>,#<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : 'AF7AC5';?>);

                  background-image: -moz-linear-gradient( #<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : 'AF7AC5';?>,#<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : 'AF7AC5';?>);

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

            .privacy-txt:hover,.privacy-txt:focus {

                  color: #4a90e2;

            }

            @media screen and (max-width: 768px) {

                  .footer_address > span:first {

                              display: inline-block;

                              width: 100%;

                  }

                  .footer_address {

                        text-align: center !important;

                  }

            }

            .top-div {
                  border-radius: 10px;
                  -moz-border-radius: 10px;
                  -webkit-border-radius: 10px;
                  /*background: #fafafa;*/
                  display: inline-block;
                  width: 100%;
                  float: left;
                  box-sizing: border-box;
                  -moz-box-sizing: border-box;
                  -webkit-box-sizing: border-box;
                  padding: 35px 25px;
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

            .items-list-table th,.items-list-table td{

                  font-size: 13px;

                  border: 0px;

                  padding: 7px;



            }

            .onlyMessageSection .alert {

                  font-size: 21px;

                  margin-bottom: 7px;

            }

            .items-list-table thead th{

                  color: #7e8899;

                  text-transform: uppercase;

                  font-weight: 500;



            }

            .alert.alert-danger,.text-danger{

                  color: #FF6245;

            }

            .items-list-table tbody{

                  color: #000;

                  border-top: 1px solid #eaeaea;  

                  max-width: 100%;

                  width: 100%;

            }

            .items-list-table tfoot{

                  border-top: 1px solid #eaeaea;  

                  max-width: 100%;

            }

            .items-list-table tfoot td{

                  text-align: right;

            }

            .items-list-table tfoot span{

                  display: inline-block;

                  vertical-align: top;

                  padding: 0 7px;

                  min-width: 100px;

                  text-align: left;

                  font-weight: 700;

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

            .alert.alert-success,.text-success{

                  color: #7CB342;

                  text-transform: capitalize;

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

            .onlyMessageSection span.text-success,.onlyMessageSection span.text-danger {

                  font-size: 21px;

                  font-weight: 600;

                  display: block;

                  margin-bottom: 21px;

            }

            .items-list-table-overflow{

                  overflow: auto;

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

            /*new style*/
            @font-face {
                  font-family: 'Roboto-Thin';
                  /*font-weight: bold;*/
                  font-style: normal;
                  src: url('../../new_assets/css/fonts/Roboto-Thin.woff') format('woff'),
                        url('../../new_assets/css/fonts/Roboto-Thin.ttf') format('truetype');
            }
            @font-face {
                  font-family: 'Avenir-Black';
                  /*font-weight: bold;*/
                  font-style: normal;
                  src: url('../../new_assets/css/fonts/Avenir-Black.woff') format('woff'),
                       url('../../new_assets/css/fonts/Avenir-Black.ttf') format('truetype');
            }
            @font-face {
                  font-family: 'Avenir-Heavy';
                  /*font-weight: bold;*/
                  font-style: normal;
                  src: url('../../new_assets/css/fonts/Avenir-Heavy.woff') format('woff'),
                       url('../../new_assets/css/fonts/Avenir-Heavy.ttf') format('truetype');
            }
            @font-face {
                  font-family: 'AvenirNext-Medium';
                  /*font-weight: bold;*/
                  font-style: normal;
                  src: url('../../new_assets/css/fonts/AvenirNext-Medium.woff') format('woff'),
                       url('../../new_assets/css/fonts/AvenirNext-Medium.ttf') format('truetype');
            }
            @font-face {
                  font-family: 'Avenir-Roman';
                  /*font-weight: bold;*/
                  font-style: normal;
                  src: url('../../new_assets/css/fonts/Avenir-Roman.woff') format('woff'),
                       url('../../new_assets/css/fonts/Avenir-Roman.ttf') format('truetype');
            }
            .modal-header {
                  border-bottom: none !important;
            }
            .right-grid-main {
                  border-radius: 0px !important;
                  margin-bottom: 0px !important;
            }
            .right-grid-body {
                  margin-top: 20px !important;
            }
            .grid-chart {
                  margin-top: 40px !important;
            }
            .invoice-logo {
                  max-height: 100px;
                  max-width: 300px;
            }
            .date-text {
                  color: rgb(148, 148, 146);
                  font-size: 16px;
                  margin-bottom: 0rem !important;
                  font-family: AvenirNext-Medium !important;
            }
            @media screen and (max-width: 640px) {
                  .date-text {
                        font-size: 13px;
                  }
            }
            .heading-text {
                  color: rgb(0, 166, 255);
                  font-size: 30px;
                  /*letter-spacing: 5px;*/
                  font-weight: 600 !important;
                  margin-bottom: 0px !important;
                  font-family: Avenir-Heavy !important;
            }
            @media screen and (max-width: 640px) {
                  .heading-text {
                        font-size: 27px;
                  }
            }
            .invoice-number {
                  font-size: 18px;
                  font-family: Avenir-Black !important;
            }
            @media screen and (max-width: 640px) {
                  .invoice-number {
                        font-size: 13px;
                  }
            }
            @media screen and (max-width: 640px) {
                  p {
                      margin: 0px;
                  }
            }
            @media screen and (max-width: 640px) {
                  .footer_t_c {
                      font-size: 12px !important;
                  }
            }
            .owner-name {
                font-size: 26px;
                font-weight: 600;
                margin-bottom: 0px !important;
                font-family: AvenirNext-Medium !important;
                color: #000;
            }
            @media screen and (max-width: 640px) {
                      .owner-name {
                            font-size: 19px;
                      }
                }
            .mail-phone-text {
                font-size: 16px;
                color: rgb(148, 148, 146);
                font-weight: 400 !important;
                margin-bottom: 0px !important;
                font-family: AvenirNext-Medium !important;
            }
            @media screen and (max-width: 640px) {
                      .mail-phone-text {
                            font-size: 13px;
                      }
                }
            .item-head {
                font-size: 19px;
                font-weight: 600;
                margin-bottom: 0px !important;
                color: #000 !important;
                font-family: AvenirNext-Medium !important;
            }
            @media screen and (max-width: 640px) {
                      .item-head {
                            font-size: 19px;
                      }
                }
            .item-detail-hr {
                width: 20% !important;
            }
            @media screen and (max-width: 640px) {
                      .item-details-table thead tr th {
                            font-size: 13px !important;
                      }
                }
            .item-details-table tbody tr td {
                font-size: 16px;
                font-weight: 400 !important;
                font-family: AvenirNext-Medium !important;
            }
            @media screen and (max-width: 640px) {
                      .item-details-table tbody tr td {
                            font-size: 13px !important;
                      }
                }
            .item-details-table tbody tr {
                height: 45px;
            }
            .item-table-border {
                border-bottom: 1px solid rgb(245, 245, 251);
            }
            .item-details-table tfoot tr td {
                font-size: 16px;
                font-weight: 500 !important;
                font-family: AvenirNext-Medium !important;
            }
            .item-details-table tfoot tr {
                height: 45px;
                border-top: 1px solid lightgray !important;
            }
            .payment-details-table tr td {
                height: 30px !important;
                font-size: 14px;
                font-weight: 400 !important;
                font-family: AvenirNext-Medium !important;
            }
            @media screen and (max-width: 640px) {
                      .payment-details-table tr td {
                            font-size: 12px !important;
                      }
                }
            .payment-details-table tr td.left {
                color: rgb(105, 105, 105);
            }
            .terms-text {
                font-weight: 400 !important;
                font-size: 12px !important;
                color: rgb(148, 148, 146);
                font-family: AvenirNext-Medium !important;
            }
            .signature-size {
                max-width: 200px;
                max-height: 80px;
                margin-bottom: 20px;
            }
            .invoice-to-text {
                color: rgb(105, 105, 105);
                font-size: 22px;
                font-weight: 400;
                font-family: AvenirNext-Medium !important;
            }
            .line-b4-head {
                height: 4px;
                width: 70px;
                background-color: #000;
            }
            .undergo-head {
                margin-bottom: 10px;
            }

            .btn.btn-first {
                font-size: 16px;
                background: rgb(0, 166, 255);
                -webkit-transition: all 0.3s ease 0s;
                -o-transition: all 0.3s ease 0s;
                transition: all 0.3s ease 0s;
                border: 1px solid #2273dc;
                color: #fff;
                padding: 7px 15px;
            }
            @media screen and (max-width: 640px) {
                .btn.btn-first {
                    font-size: 13px;
                }
            }
            .btn.btn-first:hover, .btn.btn-first:focus {
                outline: none;
                -webkit-box-shadow: 0 0;
                box-shadow: 0 0;
                background-image: none;
                background-color: transparent !important;
                border: 1px solid #2273dc !important;
                color: #1369d9 !important;
            }
            .btn {
                display: inline-block;
                padding: 6px 12px;
                margin-bottom: 0;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -ms-touch-action: manipulation;
                touch-action: manipulation;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-image: none;
                border: 1px solid transparent;
                border-radius: 4px;
            }

            .svgAlertWraper{
              margin: 0 auto;
              width: 220px !important;
            }
            .svgAlertWraper img {
                width: 220px;
            }
            span.amtttl {
                padding: 3px 21px;
                font-size: 34px;
                color: #4BB543;
                font-weight: 400;
                display: inline-block;
                vertical-align: top;
                min-width: 230px;
                font-family: AvenirNext-Medium;
            }
            h4.success {
                color: #4BB543 !important;
                font-size: 22px;
                font-family: AvenirNext-Medium;
            }
            h4.error {
                color: red !important;
                font-size: 22px;
                font-family: AvenirNext-Medium;
            }
            @media screen and (max-width: 640px) {
                .svgAlertWraper img {
                    width: 150px;
                }
                span.amtttl {
                    font-size: 22px;
                }
                h4.success {
                    font-size: 14px;
                }
                h4.error {
                    font-size: 14px;
                }
            }
            .img-lg-custom-text-light {
                max-height: 100px;
                max-width: 100px;
                width: auto;
                height: auto;
                font-size: 50px;
                color: #fff;
                font-family: Roboto-Thin !important;
                padding: 10px 33px;
                border-radius: 50%;
                background-color: rgb(0, 166, 255);
            }
            .invoice-wrap1 {
                  display: block;
                  border-radius: 10px;
                  -moz-border-radius: 10px;
                  -webkit-border-radius: 10px;
                  max-width: 450px;
                  width: 100%;
                  background-color: #fff;
                  -webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
                  -moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
                  box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
                  /*-webkit-box-shadow: rgba(102, 102, 102, 0.09) 0px 0 20px;
                  -moz-box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;
                  box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;*/
                  margin: 30px auto 0;
            }

            .invoice-wrap1::after,.invoice-wrap1::before{

                  content: '';

                  display: table;

                  clear: both;

            }
      </style>

        <body style="margin:0 auto;padding: 0;">
            <div class="main-box">
                <?php if($resend!='') { ?>
                    <div class="invoice-wrap1">
                        <div class="top-div">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div style="color:red;"><?php echo validation_errors(); ?></div>
                                <div class="row" style="margin-bottom: 10px !important;">
                                    <!--<div class="col-sm-6 col-md-6 col-lg-6"> -->
                                    <div class="col-sm-12 col-md-12 col-lg-12"> 
                                        <div class="display-avatar" style="padding: 0px !important;">
                                            <?php if($itemm[0]['logo']) { ?>
                                                <img class="invoice-logo" src="<?php echo base_url(); ?>logo/<?php echo $itemm[0]['logo']; ?>" alt="logo">
                                            <?php } else { ?>
                                                <?php if($itemm) { ?>
                                                    <div class="img-lg-custom-text-light">
                                                        <!--<?php echo substr($this->session->userdata('merchant_name'),0,1); ?>-->
                                                        <?php echo !empty($itemm[0]['business_dba_name']) ? strtoupper(substr($itemm[0]['business_dba_name'],0,1)) : strtoupper(substr($itemm[0]['merchant_name'],0,1)); ?>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px !important;">
                                    <!--<div class="col-sm-6 col-md-6 col-lg-6 text-right">-->
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                        <p class="date-text"><?php $originalDate = $date_c;
                                        echo $newDate = date("F d, Y", strtotime($originalDate)); ?></p>
                                        <p class="heading-text">INVOICE</p>
                                        <p class="invoice-number"><?php echo $invoice_no ;?></p>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px !important;">
                                    <!--<div class="col-sm-6 col-md-6 col-lg-6"></div>-->
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                        <?php if($itemm[0]['business_dba_name']) { ?>
                                            <p class="owner-name"><?= $itemm[0]['business_dba_name'] ?></p>
                                        <?php } ?>
                                        <!-- <p class="mail-phone-text"><?php echo ($this->session->userdata('website')) ? $this->session->userdata('website'): ""; ?></p> -->
                                        <?php if($itemm[0]['business_number']) { ?>
                                            <p class="mail-phone-text"><?= $itemm[0]['business_number'] ?></p>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- <div class="row" style="margin-bottom: 10px !important;overflow: auto;white-space: nowrap;">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="undergo-head">
                                            <span class="item-head">Customer Details</span>
                                            <div class="line-b4-head"></div>
                                        </div>
                                        <table class="item-details-table">
                                            <thead>
                                                <tr>
                                                    <th>NAME</th>
                                                                          <th>EMAIL</th>
                                                                          <th>PHONE</th>
                                                                          <th>DUE DATE</th>
                                                                          <th style="text-align: right;">AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                  <tr class="item-table-border">
                                                    <td width="20%"><?php echo $name; ?></td>
                                                    <td><?php echo $email; ?></td>
                                                    <td width="20%"><?php echo $mobile; ?> </td>
                                                    <td><?php echo $due_date; ?></td>
                                                    <td style="text-align: right;"><?php echo $amount; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> -->

                                <div class="row" style="margin-bottom: 10px !important;">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                      <?php if($attachment) { ?>
                                            <p class="invoice-number">Attachment</p>
                                            <img src="<?php echo base_url().'/uploads/attachment/'.$attachment; ?>" style="max-height: 150px;max-width: 150px;">
                                            <p style="font-size: 16px;font-weight: 400 !important;font-family: AvenirNext-Medium !important;"><?php echo $attachment ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px !important;">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="undergo-head">
                                            <span class="item-head">Payment Details</span>
                                            <div class="line-b4-head"></div>
                                        </div>
                                        <table class="payment-details-table" style="width: 100%">
                                            <tbody>
                                                  <tr>
                                                    <td width="50%" class="left">Due Date</td>
                                                    <td width="50%" style="text-align: right;"><?php echo $due_date; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" class="left">Sub Total  </td>
                                                    <td width="50%" style="text-align: right;">$ <?php echo number_format(($amount - ($other_charges+$tax)), 2); ?></td>
                                                </tr>
                                                <?php if($tax > 0) { ?>
                                                    <tr>
                                                        <td width="50%" class="left">Tax</td>
                                                        <td width="50%" style="text-align: right !important;">$ <?= number_format($tax, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if($other_charges!="" && $other_charges > 0) { ?>
                                                    <tr>
                                                        <td width="50%" class="left"><?= $otherChargesName ?></td>
                                                        <td width="50%" style="text-align: right !important;">$ <?= number_format($other_charges, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if($late_fee_status > 0 && date('Y-m-d') > $payment_date) {
                                                                          $amount = $late_fee + $amount; ?>
                                                    <tr>
                                                        <td width="50%" class="left">Late Fee</td>
                                                        <td width="50%" style="text-align: right;">$ <?php echo number_format($late_fee,2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td width="50%" class="left" style="font-size: 20px !important;">Total Amount</td>
                                                    <td width="50%" style="text-align: right;font-size: 20px !important;">$ <?php echo number_format($amount,2); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <!--<div class="col-sm-6 col-md-6 col-lg-8"></div>-->
                                    <div class="col-sm-12 col-md-12 col-lg-12">
 <?php

// if($bct_id2==413 || $bct_id2==865 || $bct_id2==867 ){

                        $getMerchant = $this->db->query("SELECT payroc from merchant where id = ".$bct_id2." ");
                              $getMerchantData = $getMerchant->result_array();

                          $payroc = $getMerchantData[0]['payroc'];
                                            if($payroc==1){ ?>

                          <form action="<?php echo base_url('payment_card_payment');?>" method="post">
                      <?php  }
                            else
                            { ?>
               <form action="<?php echo base_url('card_payment');?>" method="post">
                               

                               <?php     }  ?>


                                                              <input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>

                                                              <input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required>

                                                              <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required>

                                                              <input type="hidden" class="form-control" name="mobile" readonly pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>

                                                              <input type="hidden" class="form-control" name="email" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" readonly pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>

                                                              <input type="hidden" class="form-control" name="late_fee" value="<?= ($late_fee_status > 0 && date('Y-m-d') > $payment_date) ? $late_fee : 0 ?>" readonly  required>

                                                              <input type="hidden" class="form-control" name="amount" value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>" readonly  required>

                                                              <input type="submit" name="submit" class="btn btn-first" value="CONTINUE TO PAYMENT" style="width: 100%;border-radius: 20px;">

                                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer-wraper" >
                        <?php if($itemm) {
                            if($itemm[0]['state']=='AL') {
                                $state_nm = 'Alabama';
                            } else if($itemm[0]['state']=='AK') {
                                $state_nm = 'Alaska';
                            } else if($itemm[0]['state']=='AZ') {
                                $state_nm = 'Arizona';
                            } else if($itemm[0]['state']=='AR') {
                                $state_nm = 'Arkansas';
                            } else if($itemm[0]['state']=='CA') {
                                $state_nm = 'California';
                            } else if($itemm[0]['state']=='CO') {
                                $state_nm = 'Colorado';
                            } else if($itemm[0]['state']=='CT') {
                                $state_nm = 'Connecticut';
                            } else if($itemm[0]['state']=='DE') {
                                $state_nm = 'Delaware';
                            } else if($itemm[0]['state']=='DC') {
                                $state_nm = 'District Of Columbia';
                            } else if($itemm[0]['state']=='FL') {
                                $state_nm = 'Florida';
                            } else if($itemm[0]['state']=='GA') {
                                $state_nm = 'Georgia';
                            } else if($itemm[0]['state']=='HI') {
                                $state_nm = 'Hawaii';
                            } else if($itemm[0]['state']=='ID') {
                                $state_nm = 'Idaho';
                            } else if($itemm[0]['state']=='IL') {
                                $state_nm = 'Illinois';
                            } else if($itemm[0]['state']=='IN') {
                                $state_nm = 'Indiana';
                            } else if($itemm[0]['state']=='IA') {
                                $state_nm = 'Iowa';
                            } else if($itemm[0]['state']=='KS') {
                                $state_nm = 'Kansas';
                            } else if($itemm[0]['state']=='KY') {
                                $state_nm = 'Kentucky';
                            } else if($itemm[0]['state']=='LA') {
                                $state_nm = 'Louisiana';
                            } else if($itemm[0]['state']=='ME') {
                                $state_nm = 'Maine';
                            } else if($itemm[0]['state']=='MD') {
                                $state_nm = 'Maryland';
                            } else if($itemm[0]['state']=='MA') {
                                $state_nm = 'Massachusetts';
                            } else if($itemm[0]['state']=='MI') {
                                $state_nm = 'Michigan';
                            } else if($itemm[0]['state']=='MN') {
                                $state_nm = 'Minnesota';
                            } else if($itemm[0]['state']=='MS') {
                                $state_nm = 'Mississippi';
                            } else if($itemm[0]['state']=='MO') {
                                $state_nm = 'Missouri';
                            } else if($itemm[0]['state']=='MT') {
                                $state_nm = 'Montana';
                            } else if($itemm[0]['state']=='NE') {
                                $state_nm = 'Nebraska';
                            } else if($itemm[0]['state']=='NV') {
                                $state_nm = 'Nevada';
                            } else if($itemm[0]['state']=='NH') {
                                $state_nm = 'New Hampshire';
                            } else if($itemm[0]['state']=='NJ') {
                                $state_nm = 'New Jersey';
                            } else if($itemm[0]['state']=='NM') {
                                $state_nm = 'New Mexico';
                            } else if($itemm[0]['state']=='NY') {
                                $state_nm = 'New York';
                            } else if($itemm[0]['state']=='NC') {
                                $state_nm = 'North Carolina';
                            } else if($itemm[0]['state']=='ND') {
                                $state_nm = 'North Dakota';
                            } else if($itemm[0]['state']=='OH') {
                                $state_nm = 'Ohio';
                            } else if($itemm[0]['state']=='OK') {
                                $state_nm = 'Oklahoma';
                            } else if($itemm[0]['state']=='OR') {
                                $state_nm = 'Oregon';
                            } else if($itemm[0]['state']=='PA') {
                                $state_nm = 'Pennsylvania';
                            } else if($itemm[0]['state']=='RI') {
                                $state_nm = 'Rhode Island';
                            } else if($itemm[0]['state']=='SC') {
                                $state_nm = 'South Carolina';
                            } else if($itemm[0]['state']=='SD') {
                                $state_nm = 'South Dakota';
                            } else if($itemm[0]['state']=='TN') {
                                $state_nm = 'Tennessee';
                            } else if($itemm[0]['state']=='TX') {
                                $state_nm = 'Texas';
                            } else if($itemm[0]['state']=='UT') {
                                $state_nm = 'Utah';
                            } else if($itemm[0]['state']=='VT') {
                                $state_nm = 'Vermont';
                            } else if($itemm[0]['state']=='VA') {
                                $state_nm = 'Virginia';
                            } else if($itemm[0]['state']=='WA') {
                                $state_nm = 'Washington';
                            } else if($itemm[0]['state']=='WV') {
                                $state_nm = 'West Virginia';
                            } else if($itemm[0]['state']=='WY') {
                                $state_nm = 'Wisconsin';
                            } else if($itemm[0]['state']=='WY') {
                                $state_nm = 'Wyoming';
                            }
                        } ?>

                        <div>
                            <div class="footer_address" style="float: left;float: none !important;">
                                <span style="display: block;color: #404040;font-weight: 600;"><?php if($itemm)  echo $itemm[0]['business_dba_name']   ;?></span>

                                <!--<span style="display: inline-block;color:#666"><?php  if($itemm)  echo $itemm[0]['address1']   ;?> </span>-->
                                <span style="display: inline-block;color:#666"><?= $itemm ? $itemm[0]['address1'].', '.$itemm[0]['city'].', '.$state_nm.', '.$itemm[0]['zip'] : '' ?> </span>
                            </div>

                            <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
                                <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/terms_and_condition">Terms </a>& <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/privacy_policy">Privacy policy </a> | Powered by <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2"> SaleQuick.com </a>
                            </div>

                            <div class="footer_cards">
                                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon1.jpg'); ?>" alt="" class="" /></a>

                                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon2.jpg'); ?>" alt="" class="" /></a>

                                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon3.jpg'); ?>" alt="" class="" /></a>

                                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon4.jpg'); ?>" alt="" class="" /></a>
                            </div>
                        </div>
                    </div>
                

                <?php } else { ?>
                    <div class="invoice-wrap abcdef">
                        <div class="onlyMessageSection">

                            <?php if($Tstatus == 'success') { ?>

                                  <div class="svgAlertWraper">

                                        <img src="<?php echo base_url('new_assets/img/big_tick.png'); ?>">

                                  </div>

                                  <?php //echo $this->session->flashdata('pmsg');
                                        echo '<span class="amtttl">$ '.$Tamount.'</span>'; ?>

                                  <h4 class="success">Payment Successful</h4>

                            <?php }else{ ?>

                                  <div class="svgAlertWraper">

                                        <img src="<?php echo base_url('new_assets/img/big_tick.png'); ?>">

                                  </div>

                                  <h4 class="success"><?php echo $this->session->flashdata('pmsg'); ?></h4>

                            <?php } ?>

                        </div>
                    </div>

                    <div class="footer-wraper">
                        <?php if($itemm) {
                            if($itemm[0]['state']=='AL') {
                                $state_nm = 'Alabama';
                            } else if($itemm[0]['state']=='AK') {
                                $state_nm = 'Alaska';
                            } else if($itemm[0]['state']=='AZ') {
                                $state_nm = 'Arizona';
                            } else if($itemm[0]['state']=='AR') {
                                $state_nm = 'Arkansas';
                            } else if($itemm[0]['state']=='CA') {
                                $state_nm = 'California';
                            } else if($itemm[0]['state']=='CO') {
                                $state_nm = 'Colorado';
                            } else if($itemm[0]['state']=='CT') {
                                $state_nm = 'Connecticut';
                            } else if($itemm[0]['state']=='DE') {
                                $state_nm = 'Delaware';
                            } else if($itemm[0]['state']=='DC') {
                                $state_nm = 'District Of Columbia';
                            } else if($itemm[0]['state']=='FL') {
                                $state_nm = 'Florida';
                            } else if($itemm[0]['state']=='GA') {
                                $state_nm = 'Georgia';
                            } else if($itemm[0]['state']=='HI') {
                                $state_nm = 'Hawaii';
                            } else if($itemm[0]['state']=='ID') {
                                $state_nm = 'Idaho';
                            } else if($itemm[0]['state']=='IL') {
                                $state_nm = 'Illinois';
                            } else if($itemm[0]['state']=='IN') {
                                $state_nm = 'Indiana';
                            } else if($itemm[0]['state']=='IA') {
                                $state_nm = 'Iowa';
                            } else if($itemm[0]['state']=='KS') {
                                $state_nm = 'Kansas';
                            } else if($itemm[0]['state']=='KY') {
                                $state_nm = 'Kentucky';
                            } else if($itemm[0]['state']=='LA') {
                                $state_nm = 'Louisiana';
                            } else if($itemm[0]['state']=='ME') {
                                $state_nm = 'Maine';
                            } else if($itemm[0]['state']=='MD') {
                                $state_nm = 'Maryland';
                            } else if($itemm[0]['state']=='MA') {
                                $state_nm = 'Massachusetts';
                            } else if($itemm[0]['state']=='MI') {
                                $state_nm = 'Michigan';
                            } else if($itemm[0]['state']=='MN') {
                                $state_nm = 'Minnesota';
                            } else if($itemm[0]['state']=='MS') {
                                $state_nm = 'Mississippi';
                            } else if($itemm[0]['state']=='MO') {
                                $state_nm = 'Missouri';
                            } else if($itemm[0]['state']=='MT') {
                                $state_nm = 'Montana';
                            } else if($itemm[0]['state']=='NE') {
                                $state_nm = 'Nebraska';
                            } else if($itemm[0]['state']=='NV') {
                                $state_nm = 'Nevada';
                            } else if($itemm[0]['state']=='NH') {
                                $state_nm = 'New Hampshire';
                            } else if($itemm[0]['state']=='NJ') {
                                $state_nm = 'New Jersey';
                            } else if($itemm[0]['state']=='NM') {
                                $state_nm = 'New Mexico';
                            } else if($itemm[0]['state']=='NY') {
                                $state_nm = 'New York';
                            } else if($itemm[0]['state']=='NC') {
                                $state_nm = 'North Carolina';
                            } else if($itemm[0]['state']=='ND') {
                                $state_nm = 'North Dakota';
                            } else if($itemm[0]['state']=='OH') {
                                $state_nm = 'Ohio';
                            } else if($itemm[0]['state']=='OK') {
                                $state_nm = 'Oklahoma';
                            } else if($itemm[0]['state']=='OR') {
                                $state_nm = 'Oregon';
                            } else if($itemm[0]['state']=='PA') {
                                $state_nm = 'Pennsylvania';
                            } else if($itemm[0]['state']=='RI') {
                                $state_nm = 'Rhode Island';
                            } else if($itemm[0]['state']=='SC') {
                                $state_nm = 'South Carolina';
                            } else if($itemm[0]['state']=='SD') {
                                $state_nm = 'South Dakota';
                            } else if($itemm[0]['state']=='TN') {
                                $state_nm = 'Tennessee';
                            } else if($itemm[0]['state']=='TX') {
                                $state_nm = 'Texas';
                            } else if($itemm[0]['state']=='UT') {
                                $state_nm = 'Utah';
                            } else if($itemm[0]['state']=='VT') {
                                $state_nm = 'Vermont';
                            } else if($itemm[0]['state']=='VA') {
                                $state_nm = 'Virginia';
                            } else if($itemm[0]['state']=='WA') {
                                $state_nm = 'Washington';
                            } else if($itemm[0]['state']=='WV') {
                                $state_nm = 'West Virginia';
                            } else if($itemm[0]['state']=='WY') {
                                $state_nm = 'Wisconsin';
                            } else if($itemm[0]['state']=='WY') {
                                $state_nm = 'Wyoming';
                            }
                        } ?>

                        <div>
                            <div class="footer_address" style="float: left; text-align: left;">
                                <span style="display: block;color: #404040;font-weight: 600;"><?php if($itemm)  echo $itemm[0]['business_dba_name']   ;?></span>

                                <!--<span style="display: inline-block;color:#666"><?php  if($itemm)  echo $itemm[0]['address1']   ;?> </span>-->
                                <span style="display: inline-block;color:#666"><?= $itemm ? $itemm[0]['address1'].', '.$itemm[0]['city'].', '.$state_nm.', '.$itemm[0]['zip'] : '' ?> </span>
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
                <?php } ?>
            </div>
      </body>
</html>