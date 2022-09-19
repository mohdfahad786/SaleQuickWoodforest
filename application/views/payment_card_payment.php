<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>:: Payment ::</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>new_assets/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/sweetalert.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://salequick.com/front/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://salequick.com/merchant-panel/assets/js/masking.js"></script> -->
    <script src="<?php echo base_url('new_assets/js/jquery.inputmask.js');?>" ></script>
    <script src="<?php echo base_url('new_assets/js/sweetalert.js'); ?>"></script>
    <script src="<?php echo base_url();?>new_assets/js/cp_script_new.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>new_assets/css/cp_style.css">
    <script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>
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
        $colordata=$itemm[0]['color']?$itemm[0]['color']:'#fff';
        $color2=color_inverse($colordata);
        $late_grace_period = $getEmail1[0]['late_grace_period'];
        if($branch[0]->payment_type == 'recurring') {
            $payment_date = date('Y-m-d', strtotime($branch[0]->recurring_pay_start_date. ' + '.$late_grace_period.' days'));
        } else {
            $payment_date = date('Y-m-d', strtotime($branch[0]->due_date. ' + '.$late_grace_period.' days'));
        }
        // $payment_date = date('Y-m-d', strtotime($branch[0]->recurring_pay_start_date. ' + '.$late_grace_period.' days'));
    ?>
 
<style type="text/css">
    body{
        /*background-image: -webkit-gradient(linear, left top, left bottom, from(#<?=$itemm[0]['color'];?>), color-stop(#<?=$itemm[0]['color'];?>), to(#<?=$itemm[0]['color'];?>));
        background-image: -webkit-linear-gradient( #<?=$itemm[0]['color'];?>, #<?=$itemm[0]['color'];?>);
        background-image: -o-linear-gradient( #<?=$itemm[0]['color'];?>, #<?=$itemm[0]['color'];?>);
        background-image: linear-gradient( #<?=$itemm[0]['color'];?>, #<?=$itemm[0]['color'];?>);*/
        background-color: rgb(245, 245, 251);
    }
    .card-inner-sketch {
        /*background: linear-gradient(135deg, #6B73FF 10%, #000DFF 100%);*/
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(34, 115, 220, 0.9)), to(#2273dc));
        background: -webkit-linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
        background: -o-linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
        background: linear-gradient(rgba(34, 115, 220, 0.9), #2273dc);
        margin: auto;
        box-shadow: 0px -1px 25px 0px rgba(16, 57, 107, 0.63);
    }
    /*.btn.btn-first.d-colors{ 
        background-color: #<?=$itemm[0]['color'];?>;
        border-color: <?=$color2;?>;
        color:<?=$color2;?>; 
    }*/
    
    /*.card-inner-sketch .c__titl
    {
      color:<?=$color2;?> !important;
    }
     .card-inner-sketch .c__val
     {
       color:<?=$color2;?> !important;
     }*/
    /*.btn.btn-first.d-colors:hover, .btn.btn-first.d-colors:focus {
        border-color: #<?=$itemm[0]['color'];?> !important;
        color: #<?=$itemm[0]['color'];?> !important;
        background-color: <?=$color2;?> !important;
    }*/
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
        button.btn.cpCompletePayBtn, button.btn.cardPaySignModalTglr {
            font-size: 11px !important;
        }
        button.btn-second.clear-sign-sketch {
            font-size: 11px !important;
        }
  </style>
</head>
<body>
    <?php 
    // print_r($itemm[0]).'<br>';
    ?>
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
            <form class="cardPaymentFormWrapper row" action="<?= base_url('payment_payroc_invoicing/'.$_POST['bct_id1'].'/'.$_POST['bct_id2']); ?>" method="post">
                <!-- <div class="col-xs-6"> -->
                <div class="col-sm-6 col-lg-6 col-md-6">
                    <div class="row" style="margin-left: 0px !important;">
                        <h3 class="back-btn-title">
                            <a href="#" onclick="goBack()" class="BacktoInvoice">
                                <span class="fa fa-angle-left"></span>
                                Back
                            </a>
                        </h3>
                    </div>
                    <div class="row">
                        <div class="card-placeholder">
                            <div class="card-inner-sketch">
                                <div class="col-12">
                                    <!-- <div class="row" style="margin: 0px !important;">
                                        <div class="mycl-wrapper responsive-cols flex-row">
                                            <div style="margin-left: 8px;">
                                                <div class="card-type-logo">
                                                    <img src="https://salequick.com/new_assets/img/cardtypelogo.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row" style="margin: 0px !important;">
                                        <p class="c__titl ">Card Number</p>
                                    </div> -->
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
                                            <!-- <div class="flex-col">
                                                <p class="c__titl ">CVV No.</p>
                                                <p class="c__val dots">
                                                    <span class="fa fa-circle"></span>
                                                    <span class="fa fa-circle"></span>
                                                    <span class="fa fa-circle"></span>
                                                </p>
                                            </div> -->
                                            <!-- <div class="flex-col"> -->
                                            <div style="padding-right: 10px;">
                                                <div class="card-type-logo">
                                                    <img src="https://salequick.com/new_assets/img/cardtypelogo.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-inner-boxes">
                                <div class="card-box  new-card-box" data-cardno="----" data-mm="--" data-yy="--" data-src="https://salequick.com/new_assets/img/cardtypelogo.png" data-chn="-" style="text-align: -webkit-center !important;">
                                    <input type="radio" value="newcard" name="card_selection_radio" <?php  if(count($token_data) <= '0') { echo  "checked";  } ?> >
                                    <div class="card__box">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                            <path fill="none" stroke="#959595" stroke-width="4" stroke-miterlimit="10" d="M50,3.379v93.242V3.379z"></path>
                                            <path fill="none" stroke="#959595" stroke-width="4" stroke-miterlimit="10" d="M3.379,50h93.242H3.379z"></path>
                                        </svg> -->
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
                                    /*background-color: #ef5350;*/
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
                                .inner_get_card_box {
                                    padding: 0px !important;
                                    height: 50px !important;
                                    text-align: right !important;
                                }
                                .saved_card_head_wrapper {
                                    position: relative;
                                    width: 320px;
                                    margin: auto;
                                }
                                .all_get_saved_cards {
                                    width: 320px;
                                    margin: auto;
                                }
                            </style>
                            <?php if($token_data) { ?>
                                <div class="saved_card_head_wrapper">
                                    <hr style="border-top: 1px solid #bbdefb !important;">
                                    <p style="color: rgb(148, 148, 146);font-family: AvenirNext-Medium;">My saved card</p>
                                </div>
                            <?php } ?>
                                <div class="all_get_saved_cards">
                                
                                    <?php 
                                        $i=1; 
                                        foreach($token_data  as $value)
                                        { 
                                        $cardNumber = str_replace('-', '', $value['card_no']);
                                        $token_id=$value['id'];
                                         $getAll_invoiceToken=$this->db->query("SELECT * FROM invoice_token WHERE token_id='$token_id' ")->result(); 
                                           if(count($getAll_invoiceToken) > 0 ) {
                                            foreach($getAll_invoiceToken as $row)
                                            {

                                               
                                                $invoice_no=$row->invoice_no; 
                                                $getinvoicedetails=$this->db->query("SELECT * FROM customer_payment_request WHERE  invoice_no='$invoice_no' AND payment_type='recurring' AND  no_of_invoice='1'  group by invoice_no")->row(); 
                                                if(count($getinvoicedetails) > 0 )
                                                {
                                                    $merchant_id=$getinvoicedetails->merchant_id;
                                                    $recurring_count=$getinvoicedetails->recurring_count;
                                                    $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_no' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
                                                    $DGetAllpaidRecord=$GetAllpaidRecord->result();
                                                    if(count($DGetAllpaidRecord) > 0 )
                                                    {
                                                        if($recurring_count == count($DGetAllpaidRecord))
                                                        {
                                                            $tokenDel_Code='1'; 
                                                            // $tokenText='All auto  payment are completed and You will not be able to recover this card!'; 
                                                        }
                                                        if($recurring_count != count($DGetAllpaidRecord) && $recurring_count  && count($DGetAllpaidRecord))
                                                        {
                                                            $tokenDel_Code='0'; 
                                                            // $tokenText='Auto  payment are in processed and You will not be able to recover this card!';  
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $tokenDel_Code='0'; 
                                                        // $tokenText='Auto  payment are in processed and You will not be able to recover this card!'; 
                                                    }
                                                    
                                                }
                                                else
                                                {
                                                    $tokenDel_Code='2'; 
                                                    // $tokenText='You will not be able to recover this card!';
                                                }
                                                
                                            }
                                        }
                                        else
                                        {
                                            $tokenDel_Code='2'; 
                                        }
                                          
                                            
                                            
                                    ?> 
                                    <?php 

                                          switch($value['card_type'])
                                          {
                                            case 'Discover':
                                              $card_image='discover.png';
                                              break;
                                            case 'Mastercard':
                                              $card_image='mastercard.png';
                                              break;
                                            case 'MasterCard':
                                              $card_image='mastercard.png';
                                              break;
                                            case 'Visa':
                                              $card_image='visa.png';
                                              break;
                                            case 'Jcb':
                                              $card_image='jcb.png';
                                              break;
                                            case 'Maestro':
                                              $card_image='maestro.png';
                                              break;
                                            case 'Amex':
                                              $card_image='amx.png';
                                              break;
                                            default :
                                              $card_image='cardtypelogo.png';
                                          }
                                        ?>

                                        <div id="card_<?php echo $value['id']; ?>" class="card-box get_card_box" data-cardno="<?php echo substr($cardNumber,strlen($cardNumber) - 4 ,4)?>" data-mm="<?php echo strtoupper($value['card_expiry_month']); ?>" data-yy="<?php echo strtoupper($value['card_expiry_year']); ?>" data-src="https://salequick.com/new_assets/img/<?php echo $card_image; ?>" data-chn="<?php echo strtoupper($value['name']); ?>">
                                            <input type="radio"  name="card_selection_radio" value="<?php echo $value['token']; ?> " <?php if($i=='1') echo 'checked'; ?>>
                                            <div class="card__box" style="display: flex;">
                                                <div class="card__type">
                                                    <img src="<?php echo  base_url();?>/new_assets/img/<?php echo $card_image; ?>">
                                                </div>
                                                <div class="card__no">
                                                    <!-- <span class="fa fa-circle"></span>
                                                    <span class="fa fa-circle"></span>
                                                    <span class="c_last_2"><?php echo substr($cardNumber,strlen($cardNumber) - 2 ,2)?></span> -->
                                                    <span style="font-size: 11px;color: rgb(105, 105, 105);">Ending in</span><br>
                                                    <span class="c_last_2"><?php echo substr($cardNumber,strlen($cardNumber) - 4 ,4) ?></span>
                                                </div>
                                                
                                                <!-- <span class="remove_card_btn pull-right fa fa-trash" onclick="deletecard(<?php echo $value['id']; ?>)"></span> -->
                                                <span class="remove_card_btn fa fa-trash" onclick="deletecard('<?php echo $value['id']; ?>','<?php echo $tokenDel_Code; ?>')" ></span>
                                            </div>
                                        </div>
                                    <?php  $i++; } ?>
                                </div>
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
                        <!-- <div class="form-group">
                            <label for="card__cnumber" class="movbale">Card Number</label>
                            <input id="card__cnumber" name="card_no" class="form-control required CardNumber" type="text"  minlength="14" maxlength="16" >
                        </div> -->

                        <div class="form-group">
                            <label for="card__cnumber" class="movbale">Card Number</label>
                            <div class="input-group" style="height: 35px !important;">
                <input id="card__cnumber" name="card_no" class="form-control required CardNumber" type="text" minlength="14">
                                <div class="input-group-addon" style="border: none !important;background-color: #fff !important">
                                    <!-- <span class="input-group-text card_type"><img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;"></span> -->
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
                                    <!-- <input type="month" name="exp_month"  name="exp_year" placeholder="MM/YY" class="form-control required" > -->
                                    <input autocomplete="off"  id="card__validutil"  data-yr='<?php echo json_encode($yeardata);?>' name="exp_month"  name="exp_year" placeholder="MM/YY" class="form-control required ddmm" type="text"  maxlength="5">
                                    <!-- name="exp_year" -->
                                </div>
                            </div>
                            <div class="flex-col">
                                <div class="form-group fg-half">
                                    <label for="card__cvv" class="movbale">CVV</label>
                                    <input id="card__cvv" class="form-control required cvv" type="text"  name="card_validation_num" maxlength="4">
                                </div>
                            </div>
                           

                        </div>
                        <?php $itemm[0]['is_token_system_permission'] = '1'; ?>
                        <?php if(count($itemm) > 0  ) {
                              if($itemm[0]['is_token_system_permission']=='1') {
                          ?>
                        <div class="form-group">
                            <div class="custom-checkbox">
                              <input type="checkbox" id="card__save" class="radio-circle" value="1" name="issavecard" <?php if($itemm[0]['is_tokenized']=='1') echo 'checked'; ?>>
                              <label for="card__save" class="inline-block"></label>
                              <span class="save__ctxt">Save my card on file for use at <?=$itemm[0]['business_dba_name'];?></span> 
                              <span class="save__cinfo"><b><?=$itemm[0]['business_dba_name'];?></b> may store my card securely with SaleQuick. The card may be automatically charged as agreed upon until I remove the saved card.</span> 
                            </div>
                        </div>
                         <?php }  } ?>
                    </div>
                    <div class="bill-address">
                        <input type="hidden" class="form-control" name="invoice_no" value="<?php if($branch) echo $branch[0]->invoice_no  ;?>"  >
                        <input type="hidden" class="form-control" name="amount" value="<?php if($amount) echo number_format($amount,2)  ;?>"  >
                        <input type="hidden" class="form-control" name="late_fee" value="<?= ($getEmail1[0]['late_fee_status'] > 0 && date('Y-m-d') > $payment_date) ? $getEmail1[0]['late_fee'] : 0 ?>"  >

                        <input type="hidden" class="form-control" name="bct_id" value="<?php if($_POST) echo $_POST['bct_id'];?>"  >
                        <input type="hidden" class="form-control" name="bct_id1" value="<?php if($_POST) echo  $_POST['bct_id1'];?>"  >
                        <input type="hidden" class="form-control" name="bct_id2"  value="<?php if($_POST) echo  $_POST['bct_id2'];?>"  >
                        <h3 class="form-title">Billing Address</h3>
                        <div class="form-group">
                            <label for="card__address" class="movbale">Address</label>
                            <input id="card__address" name="address" class="form-control required" type="text">
                        </div>
                        <div class="form-group">
                            <label for="card__city" class="movbale">City</label>
                            <input id="card__city" name="city" class="form-control required" type="text">
                        </div>
                        <div class="mycl-wrapper responsive-cols flex-row">
                            <div class="flex-col">
                                <div class="form-group fg-half ui-widget">
                                    <label for="card__state" class="movbale">State</label>
                                    <input id="card__state" name="card__state" autocomplete="off" class="form-control required" type="text">
                                </div>
                            </div>
                            <div class="flex-col">
                                <div class="form-group fg-half">
                                    <label for="card__zip" class="movbale">Zip Code</label>
                                    <input id="card__zip" name="zip" class="form-control zip required" type="text" maxlength="10" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-first d-colors cardPaySignModalTglr" style="border-radius: 20px;"> Complete The Payment</button>
                </div>
                <style>
                    #myModal .modal-header {
                        border-bottom: none !important;
                    }
                    p.modal-title {
                        font-size: 14px;
                        font-family: AvenirNext-Medium;
                        line-height: 20px;
                    }
                    p.ttlamt {
                        font-size: 26px;
                        font-family: Avenir-Black;
                        color: #0088ff;
                        margin: 0px !important;
                    }
                    hr.hr_custom {
                        margin: 0px;
                        border-top: 1px solid #e5e5e5;
                    }
                    p.signature_text {
                        color: rgb(105, 105, 105);
                        font-family: AvenirNext-Medium;
                        font-size: 16px;
                    }
                    p.terms_policy {
                        color: rgb(148, 148, 146) !important;
                        font-size: 12px !important;
                        font-family: AvenirNext-Medium;
                    }
                    @media screen and (max-width: 700px) {
                        p.modal-title {
                            font-size: 12px;
                        }
                        p.ttlamt {
                            font-size: 22px;
                        }
                        p.signature_text {
                            font-size: 14px;
                        }
                        p.terms_policy {
                            font-size: 10px !important;
                        }
                    }
                </style>

                <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="padding-bottom: 0px !important;">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <p class="modal-title">Amount payable is</p>
                                <p class="ttlamt">$ <?php if($branch) echo number_format($branch[0]->amount,2)  ;?></p>
                                <hr class="hr_custom">
                                <!-- <h4 class="modal-title">Total Payment <span class="ttlamt">$ <?php if($branch) echo number_format($branch[0]->amount,2)  ;?></span></h4> -->
                            </div>
                            <div class="modal-body">
                                <!-- <div class="verify_phone_on_cp">
                                    <p>Verify your Zipcode</p>
                                    <div class="input-group" style="width: 100%;display: inline-flex !important;">
                                        <input class="form-control confirm_zip" placeholder="Zipcode" id="confirm_zip" maxlength="10" minlength="5" value="" type="text" aria-describedby="basic-addon1" style="border-radius: 5px !important;">
                                        <div class="input-group-append">
                                             <span class="input-group-text" id="basic-addon2" style="padding:10px;"></span>
                                        </div>
                                    </div>
                                </div> -->
                              
                            <?php  if( $getEmail1[0]['signature_status']=='1' ) {  ?>
                                <p class="signature_text">Sign Here</p>

                                <div class="sign-wrapper">
                                    <div class="sign-wrapper-inner">
                                        <canvas id="signature-pad" class="signature-pad" width="0" height="0" style="touch-action: none;"></canvas>
                                    </div>
                                </div>
                                <p class="terms_policy">I agree to pay the above total amount according to my card issuer agreement. I agree to SaleQuick's Terms &amp; Privacy Policy.</p>
                            <?php } ?>
                              
                                <!-- <div class="verify_phone_on_cp">
                                <p> Confirm your mobile no </p>
                                    <input class="form-control phone" placeholder="Phone" id="verify_phone_on_cp" maxlength="14" value="" type="text">
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php  if( $getEmail1[0]['signature_status']=='1') { ?>
                                <button type="button" class="btn" id="save-png" style="display: none;">
                                    <span class="fa fa-save"></span> Save PNG
                                </button>
                                <button type="button" class="btn btn-second d-colors clear-sign-sketch" id="clear" style="border-radius: 20px;height: 37px;">
                                    <span class="fa fa-close"></span> Clear Sign
                                </button>
                                <input type="hidden" class="form-control" name="sign" id="sign" value="">
                              <?php } ?>
                                &nbsp;
                                <button type="submit" class="btn btn-first d-colors cpCompletePayBtn cpDoneBtn" name="submit" style="border-radius: 20px;height: 37px;">
                                    <span class="fa fa-check"></span> Complete Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="myModal_zip" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px !important;">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <p class="modal-title">Amount payable is</p>
                    <p class="ttlamt">$ <?php if($branch) echo number_format($branch[0]->amount,2)  ;?></p>
                    <hr class="hr_custom">
                </div>

                <div class="modal-body">
                    <div class="verify_phone_on_cp">
                        <p>Verify your Zipcode</p>
                        <div class="input-group" style="width: 100%;display: inline-flex !important;">
                            <input class="form-control confirm_zip" placeholder="Zipcode" id="confirm_zip" maxlength="10" minlength="5" value="" type="text" aria-describedby="basic-addon1" style="border-radius: 5px !important;">
                            <div class="input-group-append">
                                 <span class="input-group-text" id="basic-addon2" style="padding:10px;"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="border-radius: 20px;width: 90px;">
                        <span class="fa fa-times"></span> Close
                    </button>
                    <button type="button" class="btn btn-default nextStp_to_sign" style="border-radius: 20px;width: 90px;">
                        Next <span class="fa fa-chevron-right"></span>
                    </button>
                </div>
            </div>
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
  <!--row--> 
</div>
<script>
    //console.log($('input[name="card_selection_radio"]:checked').parent().attr('class'));
    var enable_card_radio = $('input[name="card_selection_radio"]:checked').parent().attr('class');
    if(enable_card_radio == 'card-box get_card_box') {
         $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
          $(this).val('').attr('disabled','disabled');
     })
    }

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

function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
      return false;
    }
    return true;
}

$(document)
.on('keydown blur','.card-form .required',function(){
    $('.card-form .form-group').removeClass('incorrect');
})
function allFieldsFilled(){
  var validation=true;
  $('.card-form .required').each(function(){
    $this=$(this);
      if(!$this.val().length){
        validation=false;
        $this.closest('.form-group').addClass('incorrect').find('input').focus();
        // console.log(validation)
        // return false;
      }
      else if($this.hasClass('CardNumber') && $this.val().length < 14){
        validation=false;
        $this.closest('.form-group').addClass('incorrect').find('input').focus();
        // console.log($this.html())
        // console.log(validation)
        // return false;
      }
      else if($this.hasClass('ddmm') && $this.val().length < 5){
        validation=false;
        $this.closest('.form-group').addClass('incorrect').find('input').focus();
        // console.log($this.html())
        // console.log(validation)
        // return false;
      }
      else if($this.hasClass('cvv') && $this.val().length < 3){
        validation=false;
        $this.closest('.form-group').addClass('incorrect').find('input').focus();
        // console.log($this.html())
        // console.log(validation)
        // return false;
      }
      else if($this.hasClass('zip') && $this.val().length < 4){
        validation=false;
        $this.closest('.form-group').addClass('incorrect').find('input').focus();
        // console.log($this.html())
        // console.log(validation)
        // return false;
      }
      if(!validation)
      return validation;
  })
  return validation;
}



var is_signature=<?php echo $getEmail1[0]['signature_status']; ?>;
if(is_signature=='1')
{ 
      var canvas = $('#signature-pad').get(0);
      var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
      });
      function resizeCanvas() {
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        ctx = canvas.getContext('2d');
        ctx.scale(ratio, ratio);
        signaturePad.clear(); // otherwise isEmpty() might return incorrect value
        ctx.globalCompositeOperation = 'source-over'; // default value
    }
     window.addEventListener("resize", resizeCanvas);
}

$(document).ready(function() {
  var  is_signature=<?php echo $getEmail1[0]['signature_status']; ?>;
  if(is_signature=='1')
  {
    resizeCanvas(); 
    document.getElementById('save-png').addEventListener('click', function () {
      if (signaturePad.isEmpty()) {
        return alert("Please provide a signature first.");
      }
      
      var data = signaturePad.toDataURL('image/png');
      document.getElementById("sign").value = data;
      console.log(data);
    });
    document.getElementById('clear').addEventListener('click', function () {
        console.log('clear-clicked')
      signaturePad.clear();
    });

  }
    
  $('.cardPaySignModalTglr').on('click', function (e) {
      if($('.card-box.new-card-box input[name="card_selection_radio"]').is(':checked')) {
          if(screen.availWidth <= 575 && $('.pay-detail,.bill-address').is(':hidden')){
               //alert('a'); 
               $('.pay-detail,.bill-address').slideDown(300);
          }
          if(allFieldsFilled()) {
               if(is_signature=='1') {
                     $('#myModal .modal-footer > button.back_to_zip').remove();
                     $('#myModal').modal('show');
                     $('#myModal .cpCompletePayBtn').attr('type','submit');
               } else {
                     $('.cardPaySignModalTglr').removeAttr( "type");
                     $('.cardPaySignModalTglr').attr('type','submit');
               }
          }
          //$('#myModal').modal('show');
      } else {
          console.log('run')
          if(screen.availWidth <= 575 && $('.pay-detail,.bill-address').is(':visible')){
               $('.pay-detail,.bill-address').slideUp(300);
          }
          $('.verify_phone_on_cp').show();
          $('.confirm_zip').val('');
          $('#basic-addon2').html('');
          $('.nextStp_to_sign').removeClass('okay_next_step');
          $('#myModal_zip').modal('show');
          $('#myModal .cpCompletePayBtn').attr('type','button');
      }
  })
    
  $('.cardPaySignModalTglr2').on('click', function (e) {
      // e.preventDefault();
     if($('.card-box.new-card-box input[name="card_selection_radio"]').is(':checked'))
    {   
        
        
      //============================================================
        if(screen.availWidth <= 575 && $('.pay-detail,.bill-address').is(':hidden')){
          //alert('a'); 
            $('.pay-detail,.bill-address').slideDown(300);
        }
      if(allFieldsFilled()) 
      { // alert('b'); 
          $('.verify_phone_on_cp').hide().removeAttr('required').removeClass('required');
          if(is_signature=='1')
          {
            $('#myModal').modal('show');
            $('#myModal .cpCompletePayBtn').attr('type','submit');
          }
          else
          {
              $('.cardPaySignModalTglr').removeAttr( "type");
              $('.cardPaySignModalTglr').attr('type','submit');
          }
       
      }
    }
    else{
     
        console.log('run')
        if(screen.availWidth <= 575 && $('.pay-detail,.bill-address').is(':visible')){
            $('.pay-detail,.bill-address').slideUp(300);
        }
        $('.verify_phone_on_cp').show();
        $('#myModal').modal('show');
        $('#myModal .cpCompletePayBtn').attr('type','button');
    }
  })
  $('#myModal').on('shown.bs.modal', function (e) {
      var  is_signature=<?php echo $getEmail1[0]['signature_status']; ?>;
  if(is_signature=='1')
  {
    setTimeout(function(){
      resizeCanvas();   
    },100)
  }
  })
  // $('#myModal').on('click','.cpCompletePayBtn[type="submit"]',function (e) {
  //   if (signaturePad.isEmpty()) 
  //   {
  //     e.preventDefault();
  //     if(!$('#myModal .modal-header .signatureMsg').length)
  //     {
  //       $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Please draw sign.</p>');
  //       removeSignatureMsg(); 
  //     }
  //   }
  // });
  $('#myModal').on('click','.cpCompletePayBtn[type="submit"]',function (e) {
         console.log('submit-clicked');
         
         if(is_signature=='1')
          {
                $("#sign").val(signaturePad.toDataURL('image/png'));
                if (signaturePad.isEmpty()) 
                {
                 
                  console.log('sign-empty')
                  e.preventDefault();  
                  if(!$('#myModal .modal-header .signatureMsg').length)
                  {
                    $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Please draw sign.</p>');
                    removeSignatureMsg();
                  }
                }
                else{
                  
                    $('body').addClass('loader-active');
                }
          }
  });

    $(document).on('click','.nextStp_to_sign',function () {
        //e.preventDefault();

        if(is_signature=='1') {
            if($('.verify_phone_on_cp').is(':visible')){
                if( $('.confirm_zip').val() == '' ) {
                    $('.nextStp_to_sign').removeClass('okay_next_step');
                    $('#myModal_zip .modal-header').append('<p class="alert alert-danger signatureMsg">Please enter Zipcode</p>');
                    removeZipMsg();

                } else {
                    $('#basic-addon2').html("<span class='fa fa-spinner fa-spin' style='margin-top: 10px;'></span>");
                    var confirm_zip = $('.confirm_zip').val();
                    var checked_card = $('input[name="card_selection_radio"]:checked').parent().attr('id').split("_");
                    //console.log(checked_card);return false;
                    var checked_card_id = checked_card[1];

                    //var bct_id2=$("input[name=bct_id2]").val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url()?>signup/confirm_zip_cnp",
                        data:{'confirm_zip':confirm_zip, 'checked_card_id':checked_card_id},
                        success: function(response) {
                            //console.log(response);
                            if (response != '') {
                                 if (response == confirm_zip) {
                                      //allow to sign
                                      $('#basic-addon2').html("<span class='fa fa-check' style='margin-top: 10px;color:#32CD32;'></span>");
                                      $('#myModal_zip .modal-header').append('<p class="alert alert-success signatureMsg">Zipcode Verified.</p>');
                                      $('.nextStp_to_sign').html('<span class="fa fa-check"></span> Done');
                                      //$('.nextStp_to_sign').addClass('zip_verified_done');
                                      removeZipMsg();
                                      $('#myModal_zip').modal('hide');
                                      $('#myModal').modal('show');

                                 } else {
                                      $('#basic-addon2').html("<span class='fa fa-times' style='margin-top: 10px;color:#FF0000;'></span>");
                                      $('#myModal_zip .modal-header').append('<p class="alert alert-danger signatureMsg">Incorrect Zipcode. Try Another.</p>');
                                      removeZipMsg();
                                 }
                            } else {
                                 $.ajax({
                     type: "POST",
                     url: "<?php echo base_url()?>signup/update_saved_card_zipcode",
                     data:{'confirm_zip':confirm_zip, 'checked_card_id':checked_card_id},
                     success: function(data) {
                     $('#basic-addon2').html("<span class='fa fa-check' style='margin-top: 10px;color:#32CD32;'></span>");
                     $('#myModal_zip .modal-header').append('<p class="alert alert-success signatureMsg">Zipcode Verified.</p>');
                     $('.nextStp_to_sign').html('<span class="fa fa-check"></span> Done');
                     //$('.nextStp_to_sign').addClass('zip_verified_done');
                     removeZipMsg();
                                         $('#myModal_zip').modal('hide');
                                         $('#myModal').modal('show');
                    }
                    });
                            }
                            
                        }
                    });
                }
            }
        } else {
            //if($('.verify_phone_on_cp').is(':visible') && !$('.verify_phone_on_cp input').val()){
            //    if(!$('#myModal .modal-header .signatureMsg').length) {
            //      $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Please enter phone number.</p>');
            //      removeSignatureMsg();
            //    }
            //} else {
            //    submitwithAjax();
            //}
            if($('.verify_phone_on_cp').is(':visible')){
                if( $('.confirm_zip').val() == '' ) {
                    $('.nextStp_to_sign').removeClass('okay_next_step');
                    $('#myModal_zip .modal-header').append('<p class="alert alert-danger signatureMsg">Please enter Zipcode</p>');
                    removeZipMsg();

                } else {
                    $('#basic-addon2').html("<span class='fa fa-spinner fa-spin' style='margin-top: 10px;'></span>");
                    var confirm_zip = $('.confirm_zip').val();
                    var checked_card = $('input[name="card_selection_radio"]:checked').parent().attr('id').split("_");
                    //console.log(checked_card);return false;
                    var checked_card_id = checked_card[1];

                    //var bct_id2=$("input[name=bct_id2]").val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url()?>signup/confirm_zip_cnp",
                        data:{'confirm_zip':confirm_zip, 'checked_card_id':checked_card_id},
                        success: function(response) {
                            //console.log(response);
                            if (response != '') {
                                 if (response == confirm_zip) {
                                      //allow to sign
                                      $('#basic-addon2').html("<span class='fa fa-check' style='margin-top: 10px;color:#32CD32;'></span>");
                                      $('#myModal_zip .modal-header').append('<p class="alert alert-success signatureMsg">Zipcode Verified.</p>');
                                      $('.nextStp_to_sign').html('<span class="fa fa-check"></span> Done');
                                      //$('.nextStp_to_sign').addClass('zip_verified_done');
                                      removeZipMsg();
                                      $('#myModal_zip').modal('hide');
                                      $('#myModal').modal('show');

                                 } else {
                                      $('#basic-addon2').html("<span class='fa fa-times' style='margin-top: 10px;color:#FF0000;'></span>");
                                      $('#myModal_zip .modal-header').append('<p class="alert alert-danger signatureMsg">Incorrect Zipcode. Try Another.</p>');
                                      removeZipMsg();
                                 }
                            } else {
                                 $.ajax({
                     type: "POST",
                     url: "<?php echo base_url()?>signup/update_saved_card_zipcode",
                     data:{'confirm_zip':confirm_zip, 'checked_card_id':checked_card_id},
                     success: function(data) {
                     $('#basic-addon2').html("<span class='fa fa-check' style='margin-top: 10px;color:#32CD32;'></span>");
                     $('#myModal_zip .modal-header').append('<p class="alert alert-success signatureMsg">Zipcode Verified.</p>');
                     $('.nextStp_to_sign').html('<span class="fa fa-check"></span> Done');
                     //$('.nextStp_to_sign').addClass('zip_verified_done');
                     removeZipMsg();
                                         $('#myModal_zip').modal('hide');
                                         $('#myModal').modal('show');
                    }
                    });
                            }
                            
                        }
                    });
                }
            }
        }
    })

    $('#myModal_zip').on('click','.okay_next_step',function (e) {
        e.preventDefault();
        if(!$('.card-box.new-card-box input[name="card_selection_radio"]').is(':checked')) {
             if (!$('#myModal .modal-footer > button').hasClass('back_to_zip')) {
                  $('#myModal .modal-footer').prepend('<button type="button" class="btn btn-first back_to_zip" style="border-radius: 20px;height: 37px;font-size: 13px !important;"><span class="fa fa-chevron-left"></span> Back</button>');
             }
        }
        $('#myModal_zip').modal('hide');
        $('#myModal').modal('show');
    })

    $('#myModal_zip').on('click','.zip_verified_done',function (e) {
        e.preventDefault();
        $('body').addClass('loader-active');
        var signImg="";
        submitwithAjax();
    })

    $('#myModal').on('click','.back_to_zip',function (e) {
        e.preventDefault();
        $('#myModal_zip').modal('show');
        $('#myModal').modal('hide');
    })

  $('#myModal').on('click','.cpCompletePayBtn[type="button"]',function (e) {
    e.preventDefault();
    console.log('btutton-clicked')
    // console.log('btn-clicked')
    // console.log(signaturePad.isEmpty())

        if(is_signature=='1')
          {
                if (!signaturePad.isEmpty()) 
                {
                   submitwithAjax(); 
                }
                else
                {
                  // console.log('else-btn-clicked');
                  if(!$('#myModal .modal-header .signatureMsg').length)
                  {
                    $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Please draw sign.</p>');
                    removeSignatureMsg();
                  }
                }
          }
          else
          {
              if($('.verify_phone_on_cp').is(':visible') && !$('.verify_phone_on_cp input').val()){
                  if(!$('#myModal .modal-header .signatureMsg').length)
                  {
                    $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Please enter phone number.</p>');
                    removeSignatureMsg();
                  }
              }
              else
              {
                submitwithAjax();
              }
          }

          
          // console.log('else-btn-clicked');
          // if(!$('#myModal .modal-header .signatureMsg').length)
          // {
          //   $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Please draw sign.</p>');
          //   removeSignatureMsg();
          // }
      
         

   
  })
})

function  submitwithAjax()
{
             //alert("its ok");   exit;  
                   $('body').addClass('loader-active');
                   var signImg="";
                   if(is_signature=='1')
                   {
                      $("#sign").val(signaturePad.toDataURL('image/png'));
                       signImg=$("#sign").val();
                   }

                    //var verify_phone_on_cp=$("#verify_phone_on_cp").val();

                    var activeCard_AccountId=$('input[name="card_selection_radio"]:checked').val();
                     
                    
                    //console.log(signImg );
                    //console.log(activeCardId);
                    var bct_id =$("input[name=bct_id]").val();
                    var bct_id1=$("input[name=bct_id1]").val();
                    var bct_id2=$("input[name=bct_id2]").val();
                    // console.log(bct_id1 );
                    // console.log(bct_id2);
                    // console.log(verify_phone_on_cp); 
                    //call ajax ---------------------------------
                      $(this).html("<span class='fa fa-spinner fa-spin'></span> WAIT..."); 
                      $.ajax({
                        type: "POST",
                         url: "<?php echo base_url()?>payroc_invoice/payment_cnp_invoicing",
                        data:{'signImg':signImg, 'card_selection_radio':activeCard_AccountId,'bct_id1':bct_id1,'bct_id2':bct_id2,'bct_id':bct_id},
                        success: function(response) {
                            console.log('response');
                            console.log(response);

                            if(response=='payment_error/Mobile-Number-Not-Matched')
                            {
                              $('#myModal .modal-header').append('<p class="alert alert-danger signatureMsg">Plase Enter a valid Mobile Number !</p>');
                              removeSignatureMsg();
                            }
                            else
                            {
                                console.log(response);
                                // $('#myModal .modal-header').append(response);
                                window.location = response;
                                window.location.replace(response);
                                $('#myModal').delay(300).modal('hide');
                            }
                            $('.cpCompletePayBtn[type="button"]').html("Done");
                            $('body').removeClass('loader-active');
                        },
                        error: function(response) {
                            // console.log('error-response');
                            console.log(response);
                            $('.cpCompletePayBtn[type="button"]').html("Done");
                            $('body').removeClass('loader-active');
                        }
                      }); 
}

function removeZipMsg(){
  setTimeout(function(){
    $('#myModal_zip .modal-header').find('.signatureMsg').slideUp(300,function(){
      $(this).remove();
    })
  },3000);
}
function removeSignatureMsg(){
  setTimeout(function(){
    $('#myModal .modal-header').find('.signatureMsg').slideUp(300,function(){
      $(this).remove();
    })
  },3000);
}
function goBack() {
  window.history.back();
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
// $('input[name="paymentcard"]').on('change',function(){
//   var $input=$('.card_pay_blur_wraper .form-group').find('input, select');
//   if($('input[name="paymentcard"].newCardopt').is(':checked')){
//       $input.removeAttr('disabled');
//       $input.attr('required',true);
//     $('.card_pay_blur_wraper').removeClass('active');
//   }
//   else{
//     $input.attr('disabled',true);
//     $input.removeAttr('required');
//     $('.card_pay_blur_wraper').addClass('active');
//   }
// })
// $('.card-wraper .card-wraper-inner,.card-wraper .new-card-wraper').on('click',function(){
//   $('.card-wraper .card-wraper-inner,.card-wraper .new-card-wraper').removeClass('active');
//   $(this).addClass('active');
//   if($('.card-wraper .new-card-wraper').hasClass('active'))
//   {
//     $('.card_payment_wraper .card_pay_blur_wraper').slideDown();
//   }
//   else{
//     $('.card_payment_wraper .card_pay_blur_wraper').slideUp();
//   }
// })


function deletecard(tokenid,tokenDel)
{
    var tokenText=""; 
     if(tokenDel)
     {
           if(tokenDel=='0')
           tokenText='Auto  payment are in processed to  this card and You will not be able to delete this card!';
           if(tokenDel=='1')
           tokenText='All auto  payment are completed to  this card and You will not be able to recover this card!';
           if(tokenDel=='2')
           tokenText='You will not be able to recover this card!';
     }
     else
     {
         tokenText='You will not be able to recover this card!';
     }
    if(tokenDel=='1' || tokenDel=='2' ) { var ConfirmButton=true;  }else{var ConfirmButton=false; }
  swal({
        title: "Are you sure?",
        text: tokenText,
        type: "warning",
        showCancelButton: true,
        showConfirmButton:   ConfirmButton,          //  tokenDel > 0 ? true:false 
        confirmButtonClass: "btn btn-second d-colors",
        confirmButtonText: "Remove",
        cancelButtonClass: "btn btn-first d-colors",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
      },
      function(isConfirm) 
      {
        if (isConfirm) 
          {
            $.ajax({
              type: "POST",
              url: "<?=base_url();?>merchant/deletecard",
              data:{"tokenId":tokenid},
              dataType: "json",
              success: function(response) {
                  console.log(response)
                 // var json = $.parseJSON(response);
                  if(response.status==true)
                  {
                    $('#card_'+tokenid).remove(); 
                    // location.reload;
                  }
              },
              error: function(response) {
                console.log(response);
              }
            });
          } 
      })
}
var freezeVp = function(e) {
    e.preventDefault();
};

function stopBodyScrolling (bool) {
    if (bool === true) {
        document.body.addEventListener("touchmove", freezeVp, false);
    } else {
        document.body.removeEventListener("touchmove", freezeVp, false);
    }
}
$(function(){
//masking 
    $(".phone").inputmask({ mask: "(999) 999-9999",clearIncomplete: true });
    $("#card__validutil").inputmask({ mask: "99/99",clearIncomplete: true });
    //Inputmask({ regex: "[0-9]{14,16}",clearIncomplete: true}).mask('#card__cnumber');
    Inputmask({ regex: "[0-9]{3,4}",clearIncomplete: true}).mask('#card__cvv');
    Inputmask({ regex: "[0-9]{5,10}",clearIncomplete: true}).mask('#card__zip');
    Inputmask({ regex: "[0-9]{5,10}",clearIncomplete: true}).mask('#confirm_zip');

  $('.modal')
      .on('show.bs.modal', function (){
            stopBodyScrolling(true);
        })
      .on('hide.bs.modal', function (){
          if ($('.modal.in').length == 1) {
            stopBodyScrolling(false);
          }
        });
})
</script>
</body>
</html>