<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>:: Add Card ::</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>new_assets/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/sweetalert.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://salequick.com/front/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://salequick.com/merchant-panel/assets/js/masking.js"></script> -->
    <script src="<?php echo base_url('new_assets/js/jquery.inputmask.js');?>" ></script>
    <script src="<?php echo base_url('new_assets/js/sweetalert.js'); ?>"></script>
    <script src="<?php echo base_url();?>new_assets/js/cp_script_new.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>new_assets/css/cp_style.css">
    <script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>

    <style type="text/css">
        body{
            background-color: rgb(245, 245, 251);
        }
        .card-inner-sketch {
            background: -webkit-gradient(linear, left top, left bottom, from(rgba(34, 115, 220, 0.9)), to(#2273dc));
            background: -webkit-linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
            background: -o-linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
            background: linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
            margin: auto;
            box-shadow: 0px -1px 25px 0px rgba(16, 57, 107, 0.63);
        }
        .btn.btn-second.d-colors{
            border-color: background: linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
            color: background: linear-gradient(rgba(34, 115, 220, 0.9), #2273dc) !important;
        }
        .btn.btn-second.d-colors:hover, .btn.btn-second.d-colors:focus{
            border-color: background: linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
            background-color: background: linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
            color: #fff !important;
        }
        span.save__cinfo {
            display: block;
            padding: 6px 0 0;
            color: #777;
            font-weight: normal;
            line-height: 1.2;
            text-align: justify;
            font-size: 11px;
        }
        .custom-checkbox input#card__save + label {
            margin: 3px 0 0;
            float: left;
        }
        .custom-checkbox .save__ctxt{
            color: #2273dc;
            padding: 0 0;
            display: block;
            font-weight: 600;
        }
        .btn-group-lg>.btn, .btn-lg{
            border-radius: 4px;
        }
        input#card__save[disabled] + label {
            cursor: not-allowed;
        }
        .card-form .form-group{
            position: relative;
        }
        .card-form .form-group.incorrect::after{
            position: absolute;
            top: 5px;right: 5px;
            content: "Invalid";font-size: 12px;
            line-height: 1;pointer-events: none;
            color: red;
        }
        .card-form .form-control.incorrect, .card-form .form-control.incorrect:focus {
            border-color: red;
        }
        /*-----------------------------------------*/
        .loader-active{
            overflow: hidden;
        }
        .loader-active .loader_wraper_outer {
            display: table;            
        }
        .loader_wraper_outer {
        user-select: none;
        display: none;
        min-height: 100vh;
        width: 100%;
        max-width: 100%;
        position: fixed;            
        top: 0;
        z-index: 99999999;
        left: 0;
        width: 100%;
        height: 100%;
        vertical-align: middle;
        text-align: center; }
        .loader_wraper_outer .overlay-bg{
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0,0,0,0.7);
        width: 100%;
        height: 100%;
        opacity: 0;        
        z-index: 0;
        }
        .loader-active  .loader_wraper_outer .overlay-bg{
            -webkit-animation: overlayA linear .15s 1 0s forwards;
            animation: overlayA linear .15s 1 0s forwards;
        }
        @-webkit-keyframes overlayA {
        0% {
        opacity: 0; }
        100% {
        opacity: 1;} }
        @keyframes overlayA {
        0% {
        opacity: 0; }
        100% {
        opacity: 1;} }
        .loader-active  .loader_wraper_outer  .loader_wraper_inner {
            -webkit-animation: iconA linear 0.3s 1 .15s forwards;
            animation: iconA linear 0.3s 1 .15s forwards;
        }
        @-webkit-keyframes iconA {
        0% {
        opacity: 0; }
        30% {
        opacity: 1; }
        100% {
        opacity: 1;} }
        @keyframes iconA {
        0% {
        opacity: 0; }
        30% {
        opacity: 1; }
        100% {
        opacity: 1;} }
        .loader_wraper_inner {
            opacity: 0;
        display: table-cell;
        position: relative;
        z-index: 1;
        vertical-align: middle;
        text-align: center; }
        .loader_wraper_inner svg {
        max-width: 130px;
        width: 100%;
        height: auto; }
        .loader_wraper_inner svg .l_svg_top {
        stroke: #009ceb;
        fill: transparent;
        stroke-dasharray: 1200;
        stroke-dashoffset: 1200;
        -webkit-animation: sql linear 3s infinite 0s;
        animation: sql linear 3s infinite 0s; }
        .loader_wraper_inner svg .l_svg_bottom {
        stroke: #d2d2d2;
        fill: transparent;
        stroke-dasharray: 1200;
        stroke-dashoffset: 1200;
        -webkit-animation: sql_o linear 3s infinite 0s;
        animation: sql_o linear 3s infinite 0s; }
        .loader_wraper_inner svg .l_circle_one {
        stroke: #009ceb;
        fill: transparent;
        stroke-dasharray: 300;
        stroke-dashoffset: 300;
        -webkit-animation: circle_f linear 3s infinite 0s;
        animation: circle_f linear 3s infinite 0s; }
        .loader_wraper_inner svg .l_circle_two {
        stroke: #d2d2d2;
        fill: transparent;
        stroke-dasharray: 300;
        stroke-dashoffset: 300;
        -webkit-animation: circle_s linear 3s infinite 0s;
        animation: circle_s linear 3s infinite 0s; }
        @-webkit-keyframes sql {
        0% {
        fill: transparent;
        stroke-dashoffset: 1200; }
        60% {
        fill: transparent;
        stroke-dashoffset: 0; }
        65% {
        fill: #009ceb;
        stroke-dashoffset: 0; }
        100% {
        fill: #009ceb;
        stroke-dashoffset: 0; } }
        @keyframes sql {
        0% {
        fill: transparent;
        stroke-dashoffset: 1200; }
        60% {
        fill: transparent;
        stroke-dashoffset: 0; }
        65% {
        fill: #009ceb;
        stroke-dashoffset: 0; }
        100% {
        fill: #009ceb;
        stroke-dashoffset: 0; } }
        @-webkit-keyframes sql_o {
        0% {
        fill: transparent;
        stroke-dashoffset: 1200; }
        60% {
        fill: transparent;
        stroke-dashoffset: 0; }
        65% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; }
        100% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; } }
        @keyframes sql_o {
        0% {
        fill: transparent;
        stroke-dashoffset: 1200; }
        60% {
        fill: transparent;
        stroke-dashoffset: 0; }
        65% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; }
        100% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; } }
        @-webkit-keyframes circle_f {
        0% {
        fill: transparent;
        stroke-dashoffset: 300; }
        60% {
        fill: transparent;
        stroke-dashoffset: 300; }
        65% {
        fill: transparent;
        stroke-dashoffset: 300; }
        75% {
        fill: transparent;
        stroke-dashoffset: 0; }
        80% {
        fill: #009ceb;
        stroke-dashoffset: 0; }
        100% {
        fill: #009ceb;
        stroke-dashoffset: 0; } }
        @keyframes circle_f {
        0% {
        fill: transparent;
        stroke-dashoffset: 300; }
        60% {
        fill: transparent;
        stroke-dashoffset: 300; }
        65% {
        fill: transparent;
        stroke-dashoffset: 300; }
        75% {
        fill: transparent;
        stroke-dashoffset: 0; }
        80% {
        fill: #009ceb;
        stroke-dashoffset: 0; }
        100% {
        fill: #009ceb;
        stroke-dashoffset: 0; } }
        @-webkit-keyframes circle_s {
        0% {
        fill: transparent;
        stroke-dashoffset: 300; }
        60% {
        fill: transparent;
        stroke-dashoffset: 300; }
        65% {
        fill: transparent;
        stroke-dashoffset: 300; }
        75% {
        fill: transparent;
        stroke-dashoffset: 0; }
        80% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; }
        100% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; } }
        @keyframes circle_s {
        0% {
        fill: transparent;
        stroke-dashoffset: 300; }
        60% {
        fill: transparent;
        stroke-dashoffset: 300; }
        65% {
        fill: transparent;
        stroke-dashoffset: 300; }
        75% {
        fill: transparent;
        stroke-dashoffset: 0; }
        80% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; }
        100% {
        fill: #d2d2d2;
        stroke-dashoffset: 0; } }
        /*loading text*/
        .loading_txt {
        margin: 0;
        color: #d2d2d2;
        text-transform: capitalize;
        letter-spacing: 2px;
        font-size: 16px; }
        .loading_txt:after {
        content: ' .';
        -webkit-animation: dots 1s steps(5, end) infinite;
        animation: dots 1s steps(5, end) infinite;
        font-size: 25px; }
        @-webkit-keyframes dots {
        0%, 20% {
        color: rgba(0, 0, 0, 0);
        text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0); }
        40% {
        color: #d2d2d2;
        text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0); }
        60% {
        text-shadow: 0.25em 0 0 #d2d2d2, 0.5em 0 0 rgba(0, 0, 0, 0); }
        80%, 100% {
        text-shadow: .25em 0 0 #d2d2d2, .5em 0 0 #d2d2d2; } }
        @keyframes dots {
        0%, 20% {
        color: rgba(0, 0, 0, 0);
        text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0); }
        40% {
        color: #d2d2d2;
        text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0); }
        60% {
        text-shadow: 0.25em 0 0 #d2d2d2, 0.5em 0 0 rgba(0, 0, 0, 0); }
        80%, 100% {
        text-shadow: .25em 0 0 #d2d2d2, .5em 0 0 #d2d2d2; } }
        @media  only screen and (max-width: 767px){
            .loader_wraper_inner svg {
            max-width: 101px;}
            .loading_txt{font-size: 12px;}
        }
    </style>
</head>

<body>
    <div class="loader_wraper_outer ">
        <div class="loader_wraper_inner">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="323px" height="292px" viewBox="0 0 323 292" enable-background="new 0 0 323 292" xml:space="preserve">
                <path fill-rule="evenodd" class="l_svg_top" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M80.747,158.409
                    c18.835,0.853,37.741,0.211,56.614,0.082c8.004-0.056,13.297-3.973,13.162-12.278c-0.135-8.346-5.562-11.768-13.601-11.749
                    c-15.202,0.041-30.406-0.188-45.606-0.031c-7.701,0.081-14.22-1.698-19.787-7.56c-11.189-11.781-22.45-23.546-34.388-34.546
                    c-7.45-6.867-6.208-11.52,0.535-17.809c11.878-11.079,23.238-22.729,34.5-34.444c5.105-5.309,10.741-7.328,18.117-7.292
                    c56.625,0.28,113.253,0.403,169.877,0.1c10.038-0.055,14.076,2.889,13.801,13.391c-0.577,21.479-0.095,42.987-0.047,64.485
                    c0.018,8.729,2.484,16.494,12.664,16.276c10.17-0.215,12.102-8.129,12.074-16.805c-0.073-20.973,0.078-41.946,0.033-62.917
                    c-0.057-27.581-11.35-38.993-39.276-39.21c-27.788-0.218-55.58-0.047-83.367-0.058c-28.314-0.013-56.628,0.045-84.941-0.037
                    c-12.455-0.037-24.02,2.299-33.213,11.47c-13.732,13.698-27.48,27.385-41.05,41.248C9.961,67.755,6.065,76.38,6.974,86.296
                    C8.613,104.161,62.714,157.598,80.747,158.409z"></path>
                <path fill-rule="evenodd" class="l_svg_bottom" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M317.027,207.701
                    c-1.643-17.862-55.744-71.3-73.775-72.111c-18.836-0.853-37.743-0.211-56.615-0.081c-8.005,0.056-13.296,3.973-13.161,12.278
                    c0.136,8.342,5.562,11.765,13.6,11.744c15.203-0.036,30.406,0.189,45.606,0.032c7.702-0.081,14.22,1.698,19.787,7.563
                    c11.19,11.777,22.448,23.543,34.39,34.547c7.449,6.862,6.206,11.52-0.534,17.804c-11.879,11.082-23.241,22.731-34.504,34.447
                    c-5.102,5.31-10.738,7.329-18.112,7.291c-56.628-0.276-113.257-0.402-169.881-0.098c-10.038,0.054-14.077-2.89-13.8-13.391
                    c0.576-21.479,0.095-42.99,0.047-64.485c-0.019-8.729-2.485-16.494-12.665-16.279c-10.17,0.214-12.102,8.129-12.073,16.804
                    c0.072,20.977-0.079,41.945-0.035,62.922c0.057,27.579,11.35,38.992,39.278,39.208c27.786,0.222,55.579,0.048,83.365,0.058
                    c28.315,0.013,56.63-0.044,84.945,0.037c12.451,0.038,24.018-2.296,33.213-11.469c13.731-13.696,27.479-27.386,41.048-41.247
                    C314.037,226.242,317.933,217.616,317.027,207.701z"></path>
                <path fill-rule="evenodd" class="l_circle_one" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M78.328,67.273
                    C67.85,67.507,62.187,74.27,62.595,84.598c0.382,9.705,6.231,14.911,16.313,15.168c10.274-1.035,16.378-6.644,15.716-17.188
                    C94.028,73.065,87.913,67.06,78.328,67.273z"></path>
                <path fill-rule="evenodd" class="l_circle_two" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M245.119,192.908
                    c-10.479,0.233-16.141,6.996-15.733,17.324c0.382,9.705,6.231,14.91,16.313,15.168c10.273-1.034,16.379-6.644,15.717-17.188
                    C260.818,198.7,254.704,192.695,245.119,192.908z"></path>
            </svg>

            <p class="loading_txt">Processing </p>
        </div>
        <span class="overlay-bg"></span>
    </div>
    <style>
        @media screen and (min-width: 768px) {
            .card-form {
                margin-top: 50px !important;
            }
        }
    </style>
    <div class="invoice-wrapper">
       <div class="irm-header-inner">
            <form class="cardPaymentFormWrapper row" action="<?php echo base_url('add_card/payment_cnp_invoicing'); ?>" method="post">
                <div class="col-sm-6 col-lg-6 col-md-6">
                    <div class="row">
                        <div class="card-placeholder">
                            <div class="card-inner-sketch">
                                <div class="col-12">
                                    <div class="row" style="margin: 0px;">
                                        <p class="c__val card__no"><span>xxxx</span><span>xxxx</span><span>xxxx</span><span>----</span></p>
                                    </div>

                                    <div class="row" style="margin: 0px !important;">
                                        <p class="c__titl ">Card Holder</p>
                                    </div>
                                    <div class="row" style="margin: 0px !important;">
                                        <p class="c__val nameonc">-</p>
                                    </div>

                                    <div class="row" style="margin: 0px;">
                                        <div class="mycl-wrapper responsive-cols flex-row">
                                            <div class="flex-col">
                                                <p class="c__titl ">Expires on</p>
                                                <p class="c__val" style="margin-bottom: 5px !important;"><span>--</span> <span>/</span> <span>--</span></p>
                                            </div>
                                            <div style="padding-right: 10px;">
                                                <div class="card-type-logo">
                                                    <img src="https://salequick.com/new_assets/img/cardtypelogo.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner-boxes" style="display: none !important;">
                                <div class="card-box  new-card-box" data-cardno="----" data-mm="--" data-yy="--" data-src="https://salequick.com/new_assets/img/cardtypelogo.png" data-chn="-" style="text-align: -webkit-center !important;">
                                    <input type="radio" value="newcard" name="card_selection_radio" <?php  if(count($token_data) <= '0') { echo  "checked";  } ?> >
                                    <div class="card__box">
                                        <i class="fa fa-plus"></i> Add Card
                                    </div>
                                </div>
                                <style>
                                    .card-inner-boxes .card-box .card__no {
                                        width: 210px;
                                        padding: 7px;
                                        text-align: right;
                                    }
                                    .card-inner-boxes .card-box .remove_card_btn_wrapper {
                                        width: 40px;
                                    }
                                    .get_card_box {
                                        margin-bottom: 10px !important;
                                        border: 1px solid rgb(210, 223, 245);
                                        border-radius: 5px;
                                    }
                                    .get_card_box:hover {
                                            -webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                            -moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                            box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-md-6 card-form">
                    <div class="pay-detail" style="display: inline-block;width: 100%;">
                        <h3 class="form-title">Payment Details</h3>
                        <input type="hidden" value="<?php print_r($getEmail1); ?>"/>
                        <div class="form-group">
                            <label for="card__nameoncard" class="movbale">Card Holder Name</label>
                            <input id="card__nameoncard"  name="name_card" class="form-control required" type="text">
                        </div>

                        <div class="form-group">
                            <label for="card__cnumber" class="movbale">Card Number</label>
                            <div class="input-group" style="height: 35px !important;">
                                <input id="card__cnumber" name="card_no" class="form-control required CardNumber" type="text" minlength="14">
                                <div class="input-group-addon" style="border: none !important;background-color: #fff !important">
                                    <span class="input-group-text card_type"><div style="width: 35px;"></div></span>
                                </div>
                            </div>
                        </div>

                        <div class="mycl-wrapper responsive-cols flex-row">
                            <div class="flex-col">
                                <div class="form-group fg-half">
                                    <?php
                                    $currYr=date('Y');
                                    // $newArray=date('Y');
                                    $LastYr=$currYr + 20;
                                    $yeardata=array();
                                    for ($i=$currYr; $i < $LastYr; $i++) { 
                                        array_push($yeardata,substr($i, 2,2));
                                    }
                                    ?>
                                    <label for="card__validutil" class="movbale">Expires on</label>
                                    <input autocomplete="off"  id="card__validutil"  data-yr='<?php echo json_encode($yeardata);?>' name="exp_month"  name="exp_year" placeholder="MM/YY" class="form-control required ddmm" type="text"  maxlength="5">
                                </div>
                            </div>
                            <div class="flex-col">
                                <div class="form-group fg-half">
                                    <label for="card__cvv" class="movbale">CVV</label>
                                    <input id="card__cvv" class="form-control required cvv" type="text"  name="card_validation_num" maxlength="4">

                                    
                                </div>
                            </div>

                            <div class="flex-col">
                                <div class="form-group fg-half">
                                    <label for="zip" class="movbale">Zip</label>
                                    <input id="zip" class="form-control required" type="text"  name="zip" maxlength="10">

                                    
                                </div>
                            </div>
                        </div>

  <input id="bct_id" class="form-control required" type="hidden"  name="bct_id" value="<?php echo $getEmail[0]['id'];  ?>" >
                         <input id="bct_id1" class="form-control required" type="hidden"  name="bct_id1" value="<?php echo $getEmail[0]['payment_id'];  ?>">

                                      <input id="bct_id2" class="form-control required" type="hidden"  name="bct_id2" value="<?php echo $getEmail[0]['merchant_id'];  ?>" >

                                       <input id="bct_id" class="form-control required" type="hidden"  name="bct_id" value="<?php echo $getEmail[0]['id'];  ?>" >
                        <?php



                         $itemm[0]['is_token_system_permission'] = '1'; ?>
                        <?php if(count($itemm) > 0) {
                            if($itemm[0]['is_token_system_permission']=='1') { ?>
                                <div class="form-group">
                                    <div class="custom-checkbox" style="display: none">
                                      <input type="checkbox" id="card__save" class="radio-circle" value="1" name="issavecard" <?php echo 'checked'; ?>>
                                      <label for="card__save" class="inline-block"></label>
                                      <span class="save__ctxt">Save my card on file for use at <?=$itemm[0]['business_dba_name'];?></span> 
                                      <span class="save__cinfo"><b><?=$itemm[0]['business_dba_name'];?></b> may store my card securely with SaleQuick. The card may be automatically charged as agreed upon until I remove the saved card.</span> 
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                    <button type="button" class="btn btn-first d-colors cardPaySignModalTglr" style="border-radius: 20px;"> Complete The Payment</button>
                </div>
            </form>
        </div>
    </div>

    <div class="cp-footer">
        <div class="row slogan">
            <div class="col-sm-4" >
                <span style="display: block;color: #404040;font-weight: 600;"><?=$getEmail1[0]['business_dba_name'];?></span> <span style="display: inline-block;color:#666"><?=$getEmail1[0]['address1'];?> </span>
            </div>
            <div class="col-sm-4 text-center">
                <div class="privacy-txt">
                    <a class="privacy-txt" href="https://salequick.com/terms_and_condition">Terms </a> &
                    <a class="privacy-txt" href="https://salequick.com/privacy_policy">Privacy policy</a> 
                    | 
                    <span class="power-txt">Powered by <a href="https://salequick.com/">SaleQuick.com</a></span>
                </div>
            </div>
             <div class="col-sm-4 text-right" >
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?=base_url();?>front/invoice/img/foot_icon1.jpg" alt="VISA" ></a>
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?=base_url();?>front/invoice/img/foot_icon2.jpg" alt="MASTERCARD" ></a>
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?=base_url();?>front/invoice/img/foot_icon3.jpg" alt="AMX" ></a>
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?=base_url();?>front/invoice/img/foot_icon4.jpg" alt="DISCOVER" ></a>
            </div>
        </div>
    </div>
</div>
<script>
    // var enable_card_radio = $('input[name="card_selection_radio"]:checked').parent().attr('class');
    // if(enable_card_radio == 'card-box get_card_box') {
    //         $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
    //         $(this).val('').attr('disabled','disabled');
    //     })
    // }

    new Cleave('#card__cnumber', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            //console.log(type)
            if(type == 'amex') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'visa') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'diners') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'mastercard') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'jcb') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'discover') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else {
                //console.log('else');
                var card_img = '<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/cardtypelogo.png" style="width: 48px;height: 30px;">';
                //var card_img2 = '';
            }
            document.querySelector('.card_type').innerHTML = card_img;
            document.querySelector('.card-type-logo').innerHTML = card_img2;
        }
    });

    $(document)
    .on('keydown blur','.card-form .required',function(){
        $('.card-form .form-group').removeClass('incorrect');
    })

    $('.cardPaySignModalTglr').on('click', function (e) {
        if(allFieldsFilled()) {
            $('.cardPaySignModalTglr').removeAttr( "type");
            $('.cardPaySignModalTglr').attr('type','submit');
        }
    })

    function allFieldsFilled(){
      var validation=true;
      $('.card-form .required').each(function(){
        $this=$(this);
          if(!$this.val().length){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
          }
          else if($this.hasClass('CardNumber') && $this.val().length < 14){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
          }
          else if($this.hasClass('ddmm') && $this.val().length < 5){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
          }
          else if($this.hasClass('cvv') && $this.val().length < 3){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
          }
          else if($this.hasClass('zip') && $this.val().length < 4){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
          }
          if(!validation)
          return validation;
      })
      return validation;
    }

    var freezeVp = function(e) {
        e.preventDefault();
    };

    $(function(){
        //masking 
        $(".phone").inputmask({ mask: "(999) 999-9999",clearIncomplete: true });
        $("#card__validutil").inputmask({ mask: "99/99",clearIncomplete: true });
        //Inputmask({ regex: "[0-9]{14,16}",clearIncomplete: true}).mask('#card__cnumber');
        Inputmask({ regex: "[0-9]{3,4}",clearIncomplete: true}).mask('#card__cvv');
        Inputmask({ regex: "[0-9]{5,10}",clearIncomplete: true}).mask('#card__zip');
        Inputmask({ regex: "[0-9]{5,10}",clearIncomplete: true}).mask('#confirm_zip');
    })
</script>
</body>
</html>