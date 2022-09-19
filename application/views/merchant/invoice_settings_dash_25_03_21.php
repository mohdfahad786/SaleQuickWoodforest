<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style>
    .page-content-wrapper {
        padding-right: 0px !important;
    }
    .color-ins {
        font-size: 12px;
        color: rgb(130, 130, 130);
        display: inline !important;
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
        width: 180px;
    }
    .date-text {
        color: rgb(148, 148, 146);
        font-size: 16px;
        margin-bottom: 0rem !important;
    }
    .heading-text {
        color: rgb(0, 166, 255);
        font-size: 36px;
        letter-spacing: 5px;
        font-weight: 700 !important;
        margin-bottom: 0px !important;
    }
    .invoice-number {
        font-size: 18px;
    }
    .owner-name {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 0px !important;
    }
    .mail-phone-text {
        font-size: 16px;
        color: rgb(148, 148, 146);
        font-weight: 400 !important;
        margin-bottom: 0px !important;
    }
    .item-head {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 0px !important;
        color: #000;
    }
    .item-detail-hr {
        width: 20% !important;
    }
    .item-details-table tr td {
        font-size: 16px;
        font-weight: 500 !important;
        font-family: Avenir-Black !important;
    }
    .item-details-table tr {
        height: 45px;
    }
    .item-table-border {
        border-bottom: 1px solid rgb(245, 245, 251);
    }
    .payment-details-table tr td {
        height: 30px !important;
    }
    .payment-details-table tr td {
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
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: block !important;
    }
    .btn {
        /*border: 1px solid rgb(210, 223, 245);*/
        color: rgb(148, 148, 146);
        background-color: #fff;
        padding: 8px 20px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        width: 100% !important;
    }
    @media (min-width: 1401px) {
        .btn {
            border: 2px solid rgba(210, 223, 245) !important;
        }
    }
    @media (max-width: 1400px) {
        .btn {
            border: 1px solid rgba(210, 223, 245) !important;
        }
    }
    .btn:not([class*='btn-inverse']):not(.component-flat) {
        box-shadow: none !important;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .font-weight-medium {
        font-family: Avenir-Black !important;
    }
    .text-gray {
        font-family: AvenirNext-Medium !important;
    }

    /*-------*/
    .page-content-wrapper {
        padding-right: 0px !important;
    }
    .color-ins {
        font-size: 12px;
        color: rgb(130, 130, 130);
        display: inline !important;
    }
    .reciept-style {
        position: relative;
        height: auto;
        width: 90%;
        margin-top: 50px;
        margin-left: 5%;
        background-color: white;
        /*box-shadow: 0 0 10px 3px rgba(100, 100, 100, 0.7);*/
        border-radius: 20px;
    }
    .grid-receipt-custom {
        height: 140px;
        width: 100% !important;
        margin-top: 30px !important;
        border-radius: 0px !important;
    }
    .footer-wraper {
        float: left;
        width: 100%;
        clear: both;
        color: #666;
        max-width: 100%;
    }
    .footer-wraper>div {
        max-width: 1000px;
        padding: 0;
        text-align: center;
        font-size: 14px;
        width: 100%;
        clear: both;
        margin: 51px auto 11px;
        display: block;
    }
    .footer_address {
        padding-left: 15px;
    }
    .footer_cards {
        padding-right: 15px;
    }
    .privacy-txt {
        color: #666;
    }
    .footer-wraper>div>div {
        margin-bottom: 11px;
    }
    .footer_cards a {
        display: inline-block;
        vertical-align: top;
        /*margin-left: 7px;*/
    }
    .line-b4-head {
        height: 4px;
        width: 70px;
        background-color: #000;
    }
    .undergo-head {
        margin-bottom: 10px;
    }
    .custom_logo_style {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        max-height: 110px;
        width: 300px;
    }
    .logo_preview {
        text-align: center;
        margin-top: 5px;
        position: relative;
    }
    .logo_preview .logo_close {
        position: absolute;
        /*top: 20%;
        right: 16%;*/
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: #fff;
        color: #555;
        opacity: 0.5;
        font-size: 14px;
        padding: 0px 5px;
        border: 1px solid #555;
        cursor: pointer;
        border-radius: 50%;
        text-align: center;
    }
    .logo_preview .logo_close:hover {
        background-color: #555;
        color: #fff;
        opacity: 0.5;
    }
    @media (max-width: 1400px) {
    .invoice_mt_auto {
        padding: 15px 5px !important;
    }
    }
    @media (min-width: 1401px) {
        .invoice_mt_auto {
            padding: 15px 25px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .date-text {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .heading-text {
            font-size: 25px;
        }
    }
    @media screen and (max-width: 640px) {
        .invoice-number {
            font-size: 14px;
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
    @media screen and (max-width: 640px) {
        .invoice-logo {
            max-height: 75px;
            width: 175px;
        }
    }
    @media screen and (max-width: 600px) {
        .reciept-style {
            margin-left: 3% !important;
        }
    }
    @media screen and (max-width: 600px) {
        .footer_mgmt_sm_size {
            display: inline-grid !important;
        }
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <!-- invoice view -->
                <div class="col-sm-6 col-md-7 col-log-7" style="padding: 0;">
                    <div class="grid grid-chart grid-receipt-custom" style="background-color: #<?php echo ($color ? $color : 'fff') ?>;">
                        <div class="reciept-style">
                            <style>
                                @media (max-width: 1000px) {
                                    .invoice_flex_column {
                                        padding: 20px 10px 20px !important;
                                    }
                                }
                            </style>
                            <div class="grid-body d-flex flex-column invoice_flex_column">
                                <div class="mt-auto invoice_mt_auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row" style="margin-bottom: 20px !important;">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="display-avatar inv_preview_logo" style="padding: 0px !important;">
                                                        <?php if(isset($mypic) && $mypic!=''){ ?>
                                                            <img class="invoice-logo" src="<?php echo $upload_loc.'/'.$mypic ;?>" alt="logo">
                                                        <?php } else { ?>
                                                            <div class="img-lg-custom-text-light">
                                                                <!--<?php echo substr($this->session->userdata('merchant_name'),0,1); ?>-->
                                                                <?php echo !empty($this->session->userdata('business_dba_name')) ? strtoupper(substr($this->session->userdata('business_dba_name'),0,1)) : strtoupper(substr($this->session->userdata('merchant_name'),0,1)); ?>
                                                            </div>
                                                            <!--<img class="invoice-logo" src="<?php echo base_url('new_assets/img/no-logo.png') ;?>" alt="logo">-->
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                    <p class="date-text"><?php echo date('M d, Y') ?></p>
                                                    <p class="heading-text">INVOICE</p>
                                                    <p class="invoice-number">#AD31230</p>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 20px !important;">
                                                <div class="col-sm-6 col-md-6 col-lg-6"></div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                    <p class="owner-name" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                        <?php echo (isset($business_dba_name) && !empty($business_dba_name)) ? $business_dba_name : set_value('business_dba_name');?>
                                                    </p>
                                                    <p class="mail-phone-text" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo (isset($user_name) && !empty($user_name)) ? $user_name : set_value('user_name');?></p>
                                                    <?php if($business_number) { ?>
                                                        <p class="mail-phone-text business_number_class"><?php echo $business_number;?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- <p class="item-head">Item Details</p> -->
                                                    <div class="undergo-head">
                                                        <span class="item-head">Item Details</span>
                                                        <div class="line-b4-head"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 30px !important;">
                                                <div class="col-12">
                                                    <table class="item-details-table" style="width: 100%">
                                                        <tr class="item-table-border">
                                                            <td width="10%">1x</td>
                                                            <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Car Caddy Cup (Red)</td>
                                                            <td width="30%" style="text-align: right;">$ 5.00</td>
                                                        </tr>
                                                        <tr class="item-table-border">
                                                            <td width="10%">2x</td>
                                                            <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Flashlight w/Light Up Pen (Red)</td>
                                                            <td width="30%" style="text-align: right;">$ 12.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10%">1x</td>
                                                            <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">5 by 7 Notebook (Regular)</td>
                                                            <td width="30%" style="text-align: right;">$ 5.00</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 10px;">
                                                    <div class="sign_class">
                                                        <?php if($signature_status =='1') { ?>
                                                            <img src="<?php echo base_url('new_assets/img/signature.png') ?>" class="signature-size">
                                                            <p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p><p class="terms-text" style="text-align: justify !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>
                                                        <?php } else { ?>
                                                            <!-- <div style="height: 80px;">N/A</div> -->
                                                        <?php } ?>
                                                        
                                                    </div>

                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <!-- <p class="item-head">Payment Details</p> -->
                                                    <div class="undergo-head">
                                                        <span class="item-head">Payment Details</span>
                                                        <div class="line-b4-head"></div>
                                                    </div>
                                                    <table class="payment-details-table" style="width: 100%">
                                                        <tr>
                                                            <td width="50%" class="left">Total Amount</td>
                                                            <td width="50%" style="text-align: right;">$ 22.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%" class="left">Transaction ID</td>
                                                            <td width="50%" style="text-align: right;">96045922</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%" class="left">Payment Type</td>
                                                            <td width="50%" style="text-align: right;">AMEX</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%" class="left">Name On Card</td>
                                                            <td width="50%" style="text-align: right;">John Smith</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer-wraper">
                            <div>
                                <div class="row">
                                    <div class="col-12 footer_mgmt_sm_size">
                                        <div class="footer_address" style="float: left; text-align: center;">
                                            <span style="display: block;color: #404040;font-weight: 600;"><?php echo (isset($business_dba_name) && !empty($business_dba_name)) ? $business_dba_name : set_value('business_dba_name');?></span>
                                            <span class="o_address1_class" style="display: inline-block;color:#666"><?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1');?></span>
                                        </div>
                                        <div class="footer_t_c" style="display: inline-block;vertical-align: middle;font-size: 12px !important;">
                                            <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/terms_and_condition">Terms </a>&amp; <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/privacy_policy">Privacy policy </a> |
                                                Powered by <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2"> SaleQuick.com </a>
                                        </div>
                                        <div class="footer_cards" style="float: right;">
                                            <a style="text-decoration: none;color:#666;" href="#">
                                                <img src="<?php echo base_url('front/invoice/img/foot_icon1.jpg') ?>" alt="" class="" style="max-width: 80% !important">
                                            </a>
                                            <a style="text-decoration: none;color:#666;" href="#">
                                                <img src="<?php echo base_url('front/invoice/img/foot_icon2.jpg') ?>" alt="" class="" style="max-width: 80% !important">
                                            </a>
                                            <a style="text-decoration: none;color:#666;" href="#">
                                                <img src="<?php echo base_url('front/invoice/img/foot_icon3.jpg') ?>" alt="" class="" style="max-width: 80% !important">
                                            </a>
                                            <a style="text-decoration: none;color:#666;" href="#">
                                                <img src="<?php echo base_url('front/invoice/img/foot_icon4.jpg') ?>" alt="" class="" style="max-width: 80% !important">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- invoice setting -->
                <style>
                    @media (max-width: 600px) {
                        .setting_wrapper {
                            padding-left: 0px !important;
                        }
                    }
                </style>
                <div class="col-sm-6 col-md-5 col-log-5 setting_wrapper">
                    <!-- <?php
                        echo form_open(base_url().'merchant/invoice_settings', array('id' => "my_form",'autocomplete'=>"false",'enctype'=> "multipart/form-data"));
                        echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
                    ?> -->
                        <div class="grid right-grid-main">
                            <div class="grid-body right-grid-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-title">Invoice Settings</div>
                                        <div class="form-group" style="margin-top: 30px;">
                                            <!-- <form method="POST"> -->
                                                <label for="">Invoice Logo</label>
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn">Click to upload logo</button>
                                                    <input type="file" name="mypic" class="custom-file-input" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> id="mypic" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
                                                </div>
                                            <!-- </form> -->
                                            <?php if(isset($mypic) && $mypic!=''){ ?>
                                                <div class="logo_preview">
                                                    <img class="custom_logo_style" src="<?php echo $upload_loc.'/'.$mypic ;?>" alt="logo">
                                                    <button class="logo_close"><i class="fa fa-times"></i></button>
                                                </div>
                                                <div class="uploading_text d-none" style="text-align: center;">
                                                    <label class="text-success">Uploading Image...</label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="logo_preview">
                                                    <img class="custom_logo_style" src="<?php echo base_url('new_assets/img/no-logo.png') ;?>" alt="logo">
                                                </div>
                                                <div class="uploading_text d-none" style="text-align: center;">
                                                    <label class="text-success">Uploading Image...</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <!-- <div class="form-group" style="margin-top: 30px;">
                                            <label for="">Invoice Color</label>
                                            <div class="invoice-color-wraper">
                                                <input autocomplete="false" id="styleInput" class="invoice_color jscolor {valueElement:'valueInput', styleElement:'styleInput', borderColor:'#fff', insetColor:'#fff', backgroundColor:'rgb(255, 255, 255)',padding: 15,borderWidth:0,borderRadius:4,}" value="" style="width: 40px !important;height: 40px !important;border-radius: 10px !important;border: 0px !important;">
                                                <input type="hidden" name="color" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> id="valueInput" value="#<?php echo (isset($color) && !empty($color)) ? $color : set_value('color');?>" autocomplete="false">
                                                <p class="color-ins">Click here to change color</p>
                                            </div>
                                        </div> -->

                                        <div class="form-group" style="margin-top: 30px;">
                                            <label for="">Invoice Color</label>
                                            <style>
                                                .color-wrapper {
                                                    position: relative;
                                                    width: 250px;
                                                    display: table-caption;
                                                }
                                                .color-wrapper p {
                                                    margin-bottom: 5px;
                                                }
                                                .color-picker {
                                                    width: 130px;
                                                    background: #F3F3F3;
                                                    height: 105px;
                                                    padding: 5px;
                                                    border: 5px solid #fff;
                                                    box-shadow: 0px 0px 3px 1px #DDD;
                                                    position: absolute;
                                                    top: 50px;
                                                    left: 2px;
                                                }
                                                .color-holder {
                                                    background: #fff;
                                                    cursor: pointer;
                                                    border: 1px solid #AAA;
                                                    width: 40px;
                                                    height: 36px;
                                                    float: left;
                                                    margin-right: 5px;
                                                    border-radius: 10px;
                                                }
                                                .color-picker .color-item {
                                                    cursor: pointer;
                                                    width: 10px;
                                                    height: 10px;
                                                    list-style-type: none;
                                                    float: left;
                                                    margin: 2px;
                                                    border: 1px solid #DDD;
                                                }
                                                .color-picker .color-item:hover {
                                                    border: 1px solid #666;
                                                    opacity: 0.8;
                                                    -moz-opacity: 0.8;
                                                    filter:alpha(opacity=8);
                                                }
                                                .color_ins_wrapper {
                                                    margin-top: 19px;
                                                }
                                            </style>
                                            <div class="color-wrapper">
                                                <input type="hidden" name="custom_color" placeholder="#FFFFFF" id="pickcolor" class="call-picker" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> value="<?php echo (isset($color) && !empty($color)) ? $color : set_value('color');?>">
                                                <div class="color-holder call-picker"></div>
                                                <div class="color_ins_wrapper">
                                                    <p class="color-ins">Click here to change color</p>
                                                </div>
                                                <div class="color-picker" id="color-picker" style="display: none"></div>
                                            </div>
                                        </div>

                                        <form method="POST" action="<?php echo base_url('merchant/update_multiple_email') ?>" id="notification_email_form">
                                            <div class="form-group" style="margin-top: 30px;">
                                                <label for="">Email for Notification</label>
                                                <input type="text" id="multipleNotificationEmailOnly" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Enter Notification Emails only" class="form-control" name="notification_email"  value="<?php echo (isset($notification_email) && !empty($notification_email)) ? $notification_email : set_value('notification_email');?>">
                                            </div>
                                        </form>

                                        <div class="form-group" style="margin-top: 30px;">
                                            <label for="">Phone</label>
                                            <input class="form-control us-phone-no" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Phone" name="business_number" id="business_number"  maxlength="14" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :" value="<?php echo (isset($business_number) && !empty($business_number)) ? $business_number : set_value('business_number');?>"  type="text" onfocusout="update_business_number()">
                                        </div>
                                        <div class="form-group" style="margin-top: 30px;">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="address1" id="address1" placeholder="Address" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1');?>">
                                        </div>
                                        <?php if($signature_status > 0 ) { ?>
                                            <div class="form-group" style="margin-top: 35px;">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <h4 class="font-weight-medium">Signature Permission</h4>
                                                        <span class="text-gray">Capture signature on Invoice</span>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <div>
                                                            <label class="switch switch_type1" role="switch">
                                                                <input type="checkbox" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?> name="signature_status"  <?php if($signature_status =='1') echo 'checked'; ?> id="signature_status" class="switch__toggle">
                                                                <span class="switch__label"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="form-group" style="margin-top: 35px;">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h4 class="font-weight-medium">Late Fee Alert</h4>
                                                    <span class="text-gray">Automatically send mail by each 24 hours when Invoice is late</span>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <div>
                                                        <label class="switch switch_type1" role="switch">
                                                            <input type="checkbox" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?>  name="late_fee_mail_status" <?php if($late_fee_mail_status =='1') echo 'checked'; ?> id="late_fee_mail_status" value="" class="switch__toggle">
                                                            <span class="switch__label"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 35px;">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h4 class="font-weight-medium">Late Fee</h4>
                                                    <span class="text-gray">Automatically add late fee when Invoice is late</span>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <div>
                                                        <label class="switch switch_type1" role="switch">
                                                            <input type="checkbox" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?>  name="late_fee_status" <?php if($late_fee_status =='1') echo 'checked'; ?> id="late_fee_status" value="" class="switch__toggle">
                                                            <span class="switch__label"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                            @media (max-width: 1400px) {
                                                .late_fee_label {
                                                    height: 42px !important;
                                                }
                                            }
                                        </style>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="late_fee_label" for="">Late Fee</label>
                                                    <input type="text" min="0" maxlength="5" class="form-control allownumericwithdecimal" <?php if($this->session->userdata('employee_id')) { }?> name="late_fee" id="late_fee" disabled value="<?php echo (isset($late_fee) && !empty($late_fee)) ? $late_fee : set_value('late_fee');?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="late_fee_label" for="">Late Grace Period(In days)</label>
                                                    <input type="text" min="0" maxlength="2" class="form-control allownumericwithoutdecimal" name="late_grace_period" id="late_grace_period" disabled value="<?php echo (isset($late_grace_period) && !empty($late_grace_period)) ? $late_grace_period : set_value('late_grace_period');?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row" style="margin: 30px 0px 160px 0px;">
                                    <input type="submit" id="btn_login" name="mysubmit" value="Update" class="btn btn-first" style="width: 100% !important;border-radius: 20px !important;">
                                </div> -->
                          </div>
                        </div>
                    <!-- <?php echo form_close();?> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js" /></script>

<script>
    var colorList = [ '000000', '993300', '333300', '003300', '003366', '000066', '333399', '333333', 
'660000', 'FF6633', '666633', '336633', '336666', '0066FF', '666699', '666666', 'CC3333', 'FF9933', '99CC33', '669966', '66CCCC', '3366FF', '663366', '999999', 'CC66FF', 'FFCC33', 'FFFF66', '99FF66', '99CCCC', '66CCFF', '993366', 'CCCCCC', 'FF99CC', 'FFCC99', 'FFFF99', 'CCffCC', 'CCFFff', '99CCFF', 'CC99FF', 'FFFFFF' ];
    var picker = $('#color-picker');

    for (var i = 0; i < colorList.length; i++ ) {
        picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
    }

    $('body').click(function () {
        picker.fadeOut();
    });

    $('.call-picker').click(function(event) {
        event.stopPropagation();
        picker.fadeIn();
        // picker.children('li').hover(function() {
        picker.children('li').click(function() {
            var codeHex = $(this).data('hex');

            $('.color-holder').css('background-color', codeHex);
            $('#pickcolor').val(codeHex);
            codeHex = codeHex.replace('#','');
            console.log(codeHex)

            $.ajax({
                url: "<?php echo base_url('merchant/update_invoice_color') ?>",
                type: "POST",
                data: {invoice_color: codeHex},
                success: function(data) {
                    // console.log(data);
                    $('.grid-receipt-custom').css('background-color', '#'+data);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var inv_color = '<?php echo (isset($color) && !empty($color)) ? $color : set_value('color');?>';
        $('.color-holder').css('background-color', '#'+inv_color);

        $('.bootstrap-tagsinput').find('input').addClass('notification_input');

        //Late Fee Validation
        $(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        if($('#late_fee_status').is(':checked')){
            $('#late_fee, #late_grace_period').prop('disabled',false);
            $('#late_fee, #late_grace_period').attr('required','required');
        }
        $('#late_fee_status').click(function() {
            if($(this).is(':checked')){
                $('#late_fee, #late_grace_period').prop('disabled',false);
                $('#late_fee, #late_grace_period').attr('required','required');
            } else {
                $('#late_fee, #late_grace_period').prop('disabled',true);
                $('#late_fee, #late_grace_period').removeAttr('required');
            }
        });

    });

    $("#styleInput").keypress(function(e) {
        e.preventDefault();
    });

    // Uploading Logo
    $(document).on('change', '#mypic', function(){
        $('.uploading_text').removeClass('d-none');
        var base_url = "<?= base_url() ?>";
        var name = document.getElementById("mypic").files[0].name;
        var form_data = new FormData();
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("mypic").files[0]);
        form_data.append("mypic", document.getElementById('mypic').files[0]);
        $.ajax({
            url:"<?php echo base_url('merchant/update_profile_picture') ?>",
            method:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            // beforeSend:function(){
            //  $('.logo_preview').html("<label class='text-success' style='text-align:center;'>Image Uploading...</label>");
            // },   
            success:function(data) {
                // $('.custom_logo_style').attr("src", base_url+"logo/"+data);
                // $('.logo_preview').html('<button class="logo_close"><i class="fa fa-times"></i></button>');
                
                $('.logo_preview').html('<img class="custom_logo_style" src="' + base_url + 'logo/' + data + '" alt="logo"><button class="logo_close"><i class="fa fa-times"></i></button>');
                
                $('.inv_preview_logo').html('<img class="invoice-logo" src="' + base_url + 'logo/' + data + '" alt="logo">');
                $('.sidebar_logo_preview').html('<img class="img-lg-custom" src="' + base_url + 'logo/' + data + '" alt="logo">');
                
                // $('.invoice-logo').attr("src", base_url+"logo/"+data);
                // $('.img-lg-custom').attr("src", base_url+"logo/"+data);
                
                $('.uploading_text').addClass('d-none');
            }
        });
    });

    // $(document).on('change', '#valueInput', function() {
    //     var invoice_color = $('#valueInput').val();

    //     $.ajax({
    //         url: "<?php echo base_url('merchant/update_invoice_color') ?>",
    //         type: "POST",
    //         data: {invoice_color: invoice_color},
    //         success: function(data) {
    //             // console.log(data);
    //             $('.grid-receipt-custom').css('background-color', '#'+data);
    //         }
    //     });
    // })
    

    var request = new XMLHttpRequest();

    $('#multipleNotificationEmailOnly').on('itemAdded', function(event) {
        event.preventDefault();

        var form_mail = document.getElementById('notification_email_form');
        var formData = new FormData(form_mail);

        request.open('post', '<?php echo base_url('merchant/update_multiple_email') ?>');
        request.send(formData);
    });

    $('#multipleNotificationEmailOnly').on('itemRemoved', function(event) {
        event.preventDefault();

        var form_mail = document.getElementById('notification_email_form');
        var formData = new FormData(form_mail);

        request.open('post', '<?php echo base_url('merchant/update_multiple_email') ?>');
        request.send(formData);
    });


    function update_business_number() {
        var business_number = $('#business_number').val();
        // business_number = business_number.replace(/[- )(_]/g,'');

        $.ajax({
            url: "<?php echo base_url('merchant/update_business_number') ?>",
            type: "POST",
            data: {business_number: business_number},
            success: function(data) {
                $('#business_number').val(data);
                $('.business_number_class').text(data);
                // console.log(data);
                // $('.grid-receipt-custom').css('background-color', data);
            }
        });
    }

    $('#address1').keyup(function() {
        // console.log($(this).val());
        var address1 = $('#address1').val();

        $.ajax({
            url: "<?php echo base_url('merchant/update_o_address1') ?>",
            type: "POST",
            data: {address1: address1},
            success: function(data) {
                // console.log(data);
                // $('.grid-receipt-custom').css('background-color', data);
                $('.o_address1_class').text(data);
                // $('#address1').val(data);
            }
        });
    });

    $(document).on('change', '#signature_status, #late_fee_status', function() {
        // console.log($('#signature_status').val())
        if($('#signature_status').is(':checked')) {
            var signature_status = '1';
        } else {
            var signature_status = '2';
        }

        if($('#late_fee_status').is(':checked')) {
            var late_fee_status = '1';
        } else {
            var late_fee_status = '0';
        }

        $.ajax({
            url: "<?php echo base_url('merchant/update_signature_late_fee_status') ?>",
            type: "POST",
            data: {signature_status: signature_status, late_fee_status: late_fee_status},
            success: function(data) {
                if(data == '1') {
                    $('.signature-size').removeClass('d-none');
                    $('.sign_class').html('<img src="<?php echo base_url('new_assets/img/signature.png') ?>" class="signature-size"><p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p><p class="terms-text" style="text-align: justify !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>');
                    
                } else {
                    $('.signature-size').addClass('d-none');
                    $('.sign_class').html('<div style="height: 80px;"></div>');
                }
                // console.log(data);
                // $('.grid-receipt-custom').css('background-color', data);
            }
        });
    })

    $(document).on('change', '#late_fee_mail_status', function() {
        if($('#late_fee_mail_status').is(':checked')) {
            var late_fee_mail_status = '1';
        } else {
            var late_fee_mail_status = '0';
        }

        $.ajax({
            url: "<?php echo base_url('merchant/update_late_fee_mail_status') ?>",
            type: "POST",
            data: {late_fee_mail_status: late_fee_mail_status},
            success: function(data) {
                
            }
        });
    })

    $('#late_fee, #late_grace_period').keyup(function() {
        // console.log($(this).val());
        var late_fee = $('#late_fee').val();
        var late_grace_period = $('#late_grace_period').val();

        $.ajax({
            url: "<?php echo base_url('merchant/update_late_grace_fee') ?>",
            type: "POST",
            data: {late_fee: late_fee, late_grace_period: late_grace_period},
            success: function(data) {
                // console.log(data);
                // $('.grid-receipt-custom').css('background-color', data);
                // $('#o_address1').val(data);
                // $('.o_address1_class').text(data);
            }
        });
    });

    $(document).on('click', '.logo_close', function() {
        var base_url = "<?= base_url() ?>";
        var name_substring = "<?php echo !empty($this->session->userdata('business_dba_name')) ? strtoupper(substr($this->session->userdata('business_dba_name'),0,1)) : strtoupper(substr($this->session->userdata('merchant_name'),0,1)); ?>";
        $.ajax({
            url: "<?php echo base_url('merchant/remove_profile_picture') ?>",
            type: "POST",
            data: {mypic: ''},
            success: function(data) {
                // if(data == '') {
                    // console.log('working');
                    $('.logo_preview').html('<img class="custom_logo_style" src="' + base_url + 'new_assets/img/no-logo.png" alt="logo">');
                    
                    // $('.custom_logo_style').attr("src", base_url+"new_assets/img/no-logo.png");
                    // $('.invoice-logo').attr("src", base_url+"new_assets/img/no-logo.png");
                    // $('.img-lg-custom').attr("src", base_url+"new_assets/img/no-logo.png");
                    $('.display-avatar').html('<div class="img-lg-custom-text-light">'+name_substring+'</div>');
                // }
            }
        });
    })
</script>