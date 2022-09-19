<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>:: Refund Receipt ::</title>
        <link href="<?php echo base_url('/new_assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <script src="<?php echo base_url('/new_assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('/new_assets/js/bootstrap.min.js'); ?>"></script>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    </head>

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
        .invoice-wrap {
            display: block;
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            max-width: 972px;
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
            background-image: -webkit-linear-gradient( #<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : '2273dc';?>,#<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : '2273dc';?>);
            background-image: -moz-linear-gradient( #<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : '2273dc';?>,#<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : '2273dc';?>);
            background-image: linear-gradient( #<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : '2273dc';?>,#<?= !empty($itemm[0]['color']) ? $itemm[0]['color'] : '2273dc';?>);
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
            padding: 45px 55px;
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
        .heading-text {
            color: rgb(0, 166, 255);
            font-size: 30px;
            /*letter-spacing: 5px;*/
            font-weight: 600 !important;
            margin-bottom: 0px !important;
            font-family: Avenir-Heavy !important;
        }
        .invoice-number {
            font-size: 18px;
            font-family: Avenir-Black !important;
        }
        .owner-name {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 0px !important;
            font-family: AvenirNext-Medium !important;
            color: #000;
        }
        .mail-phone-text {
            font-size: 16px;
            color: rgb(148, 148, 146);
            font-weight: 400 !important;
            margin-bottom: 0px !important;
            font-family: AvenirNext-Medium !important;
        }
        .item-head {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 0px !important;
            color: #000 !important;
            font-family: AvenirNext-Medium !important;
        }
        .item-detail-hr {
            width: 20% !important;
        }
        .item-details-table tbody tr td {
            font-size: 16px;
            font-weight: 400 !important;
            font-family: AvenirNext-Medium !important;
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
        .payment-details-table tr td.left {
            color: rgb(105, 105, 105);
        }
        .terms-text {
            font-weight: 400 !important;
            font-size: 8px !important;
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
        @media screen and (max-width: 640px) {
            .date-text {
                font-size: 13px;
            }
        }
        @media screen and (max-width: 640px) {
            .heading-text {
                font-size: 24px;
            }
        }
        @media screen and (max-width: 640px) {
            .invoice-number {
                font-size: 13px;
            }
        }
        @media screen and (max-width: 640px) {
            .footer_t_c {
                font-size: 12px !important;
            }
        }
        @media screen and (max-width: 640px) {
            p {
                margin: 0px;
            }
        }
        @media screen and (max-width: 640px) {
            .owner-name {
                font-size: 19px;
            }
        }
        @media screen and (max-width: 640px) {
            .mail-phone-text {
                font-size: 13px;
            }
        }
        @media screen and (max-width: 640px) {
            .item-head {
                font-size: 19px;
            }
        }
        @media screen and (max-width: 640px) {
            .item-details-table thead tr th {
                font-size: 13px !important;
            }
        }
        @media screen and (max-width: 640px) {
            .item-details-table tbody tr td {
                font-size: 13px !important;
            }
        }
        @media screen and (max-width: 640px) {
            .payment-details-table tr td {
                font-size: 12px !important;
            }
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
        .column_padding_zero {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }
    </style>
    <body style="margin:0 auto;padding: 0;">
        <div class="main-box">
            <?php if(isset($itemm[0])) { ?>
                <div class="invoice-wrap" id="printableArea">
                    <div class="top-div">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <!-- <div style="color:red;"><?php echo validation_errors(); ?></div> -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p class="invoice-number">Customer Copy</p>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px !important;">
                                <div class="col-sm-6 col-md-6 col-lg-6"> 
                                    <div class="display-avatar" style="padding: 0px !important;">
                                        <?php if($itemm[0]['logo']) { ?>
                                            <img class="invoice-logo" src="<?php echo base_url(); ?>logo/<?php echo $itemm[0]['logo']; ?>" alt="logo">
                                        <?php } else { ?>
                                            <div class="owner-name" style="font-size: 50px !important;">
                                                <?php if($itemm[0]['name']) echo ucfirst(substr($itemm[0]['name'],0,1)); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 text-right column_padding_zero">
                                    <p class="date-text"><?php $originalDate = $refundData[0]['date_c'];
                                    echo $newDate = date("F d, Y", strtotime($originalDate)); ?></p>
                                    <p class="heading-text">REFUND RECEIPT</p>
                                    <p class="invoice-number"><?php echo $invoice_no; ?></p>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px !important;">
                                <div class="col-sm-6 col-md-6 col-lg-6"></div>
                                <div class="col-sm-6 col-md-6 col-lg-6 text-right column_padding_zero">
                                    <?php if($getEmail1[0]['business_dba_name']) { ?>
                                        <p class="owner-name"><?= $getEmail1[0]['business_dba_name']; ?></p>
                                    <?php } ?>
                                    <?php if($getEmail1[0]['website']) { ?>
                                        <p class="mail-phone-text"><?php echo $getEmail1[0]['website']; ?></p>
                                    <?php } ?>
                                    <?php if($getEmail1[0]['business_number']) { ?>
                                        <p class="mail-phone-text"><?= $getEmail1[0]['business_number'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php if(isset($advPos) && count($advPos) > 0) { ?>
                                <div class="row" style="margin-bottom: 10px !important;overflow: auto;white-space: nowrap;">
                                    <div class="col-sm-6 col-md-6 col-lg-6"></div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 column_padding_zero">
                                        <div class="undergo-head">
                                            <span class="item-head">Item Details</span>
                                            <div class="line-b4-head"></div>
                                        </div>

                                        <table class="item-details-table" style="width: 100%">
                                            <tbody>
                                                <?php
                                                $i=1;
                                                $subtotalamt=0;
                                                foreach($advPos as $pos){ ?>
                                                        <tr class="item-table-border">
                                                            <td><?php echo $pos['name']; ?></td>
                                                            <td width="20%" style="text-align: right;">$ <?php echo number_format($pos['price'],2); ?></td>
                                                        </tr>
                                                    <?php
                                                    $subtotalamt=$subtotalamt+$pos['price']; 
                                                    $taxa=$pos['tax'];
                                                    $tip=$pos['tip_amount'];
                                                    $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="row" style="margin-bottom: 10px !important;margin-top: 25px !important;">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="row" style="margin-bottom: 20px !important;">
                                        <div class="col-12">
                                            <?php if(!empty($sign)) {
                                                if($name) { ?>
                                                    <p class="invoice-number"><?php echo $name; ?></p>
                                                <?php } ?>
                                                
                                                <img src="<?=base_url();?>logo/<?php echo $sign; ?>" class="signature-size"/>

                                                <p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;line-height: 10px !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p>
                                                <p class="terms-text" style="text-align: justify !important;line-height: 10px !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <?php if(isset($refundData) && count($refundData) > 0) {
                                        $i=1;
                                        $subtotalRefundamt=0; ?>
                                        <div class="row" style="margin-top: 5px !important;">
                                            <div class="col-12 text-right" style="margin-bottom: 15px;">
                                                <span style="font-family: Avenir-Heavy;font-size: 18px;">Refunded</span><br>
                                                <?php foreach($refundData as $refu) {
                                                    $reAMt = ($refu['amount']!="" && $refu['amount'] > 0) ? $refu['amount'] :'0.00'; ?>
                                                    <span class="" style="font-family: AvenirNext-Medium !important;font-size: 16px !important;">
                                                        <span class="status_success">$ <?php echo $reAMt; ?>,</span>
                                                        <span>On</span>
                                                        <span><?php echo date("F d, Y", strtotime($refu['date_c'])); ?></span>
                                                    </span>
                                                    <br>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="row">
                                        <div class="undergo-head">
                                            <span class="item-head">Payment Details</span>
                                            <div class="line-b4-head"></div>
                                        </div>
                                        <table class="payment-details-table" style="width: 100%">
                                            <tbody>
                                                <?php if(isset($advPos) && count($advPos) > 0) { ?>
                                                    <tr>
                                                        <td width="50%" class="left">Sub Total</td>
                                                        <td width="50%" style="text-align: right;">$<?php echo $subtotalamt ? number_format($subtotalamt,2) : number_format($amount,2); ?></td>
                                                    </tr>
                                                <?php } if(isset($advPos) && count($advPos) > 0  && $tax > 0 ) { ?>
                                                    <tr>
                                                        <td width="50%" class="left">Tax</td>
                                                        <td width="50%" style="text-align: right;">$<?php echo number_format($tax,2); ?></td>
                                                    </tr>
                                                <?php } ?>

                                                <?php if($itemm[0]['tip'] == 1) { ?>
                                                    <tr>
                                                        <td width="50%" class="left">Tip</td>
                                                        <td width="50%" style="text-align: right;">$<?php echo number_format($getEmail[0]['tip_amount'],2); ?></td>
                                                    </tr>
                                                <?php } ?>

                                                <?php if($getEmail[0]['discount']!='' && $getEmail[0]['discount'] !='0'  ) {
                                                    $discountAmount=($getEmail[0]['total_amount']* (int) str_replace('$','',str_replace('%','',$getEmail[0]['discount'])) ) /100; ?>
                                                    <tr>
                                                        <td width="50%" class="left">Sub Amount</td>
                                                        <td width="50%" style="text-align: right;">$<?php echo number_format($getEmail[0]['total_amount'],2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="left">Discount Amount</td>
                                                        <td width="50%" style="text-align: right;">$<?php echo number_format($discountAmount,2); ?></td>
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td width="50%" class="left">Total Amount</td>
                                                    <td width="50%" style="text-align: right;">$<?php echo number_format($amount,2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" class="left">Card Type</td>
                                                    <td width="50%" style="text-align: right;"><?php if(!empty($card_type)) { echo $card_type; } else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" class="left">Card Last 4 Digits</td>
                                                    <td width="50%" style="text-align: right;"><?php if(!empty($card_no)){ echo substr($card_no, -4); } else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?></td>
                                                </tr>

                                                <?php if(!empty($name)){ ?>
                                                    <tr>
                                                        <td width="50%" class="left">Customer Name</td>
                                                        <td width="50%" style="text-align: right;"><?php if(!empty($name)) { echo ucfirst($name); } else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-right" style="padding-right: 0px;margin-top: 20px;">
                                    <a href="" id="printButton" class="btn btn-first" onclick="printDiv('printableArea')" style="width: 110px;border-radius: 20px;">Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
         
                <div class="footer-wraper">
                    <div>
                        <div class="footer_address" style="float: left; text-align: left;">
                            <span style="display: block;color: #404040;font-weight: 600;"><?php if($itemm)  echo $itemm[0]['business_dba_name']   ;?></span>
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
            <?php } else { ?> 
                <span>Payment Not Found</span>
            <?php } ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
        <script type="text/javascript">
            function printDiv(printableArea) {
                document.getElementById(printableArea).classList.remove("print_button");
                var printContents = document.getElementById(printableArea).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
            var doc = new jsPDF();
            var specialElementHandlers = {
                '#div_button': function (element, renderer) {
                    return true;
              }
            };
            $('#pdf').click(function () {
                doc.fromHTML($('#printableArea').html(), 15, 15, {
                    'width': 170,
                        'elementHandlers': specialElementHandlers
                });
                doc.save('sample-file.pdf');
            });
        </script>
    </body>
</html>