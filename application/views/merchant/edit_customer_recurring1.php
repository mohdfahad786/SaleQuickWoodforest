<?php
    include_once'header_rec_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .font-weight-medium {
        font-family: Avenir-Black !important;
        color: #000 !important;
    }

    .simple-left-head {
        width: 180px;
        margin-top: 3px;
    }

    .md-dollar {
        font-family: AvenirNext-Medium !important;
        font-size: 22px;
        color: rgb(119, 119, 119);
    }

    @media (max-width: 800px) {
        .product_row_section {
            overflow: auto;
            white-space: nowrap;
        }
    }

    textarea:focus {
        box-shadow: none !important;
    }

    @media (max-width: 640px) {
        .all_items_wrapper {
            min-width: 645px !important;
        }
    }

    @media (max-width: 640px) {
        .name_wrapper_row {
            min-width: 645px !important;
        }
    }

    @media (max-width: 640px) {
        .col_prod_input {
            width: 175px;
        }
    }

    @media (max-width: 640px) {
        .col_qty_input {
            width: 70px;
        }
    }

    @media (max-width: 640px) {
        .btn-attachment {
            font-size: 12px !important;
        }
    }

    @media (max-width: 640px) {
        .col_price_input {
            width: 120px;
        }
    }

    @media (max-width: 640px) {
        .col_tax_input {
            width: 115px;
        }
    }

    @media (max-width: 640px) {
        .col_total_input {
            width: 115px;
        }
    }

    @media (max-width: 640px) {
        .col_del_input {
            width: 56px;
        }
    }

    @media (max-width: 640px) {
        .form-title {
            margin-top: 15px;
        }
    }
    
    .checkbox label .input-frame:before {
        border: 2px solid #969696 !important;
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
    .custom-d .save__ctxt{
        color: #2273dc;
        padding: 0 0;
        display: inline;
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
        text-align: center;
    }

    .loader_wraper_outer .overlay-bg {
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.7);
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 0;
    }

    .loader-active .loader_wraper_outer .overlay-bg {
        -webkit-animation: overlayA linear .15s 1 0s forwards;
        animation: overlayA linear .15s 1 0s forwards;
    }

    @-webkit-keyframes overlayA {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes overlayA {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .loader-active .loader_wraper_outer .loader_wraper_inner {
        -webkit-animation: iconA linear 0.3s 1 .15s forwards;
        animation: iconA linear 0.3s 1 .15s forwards;
    }

    @-webkit-keyframes iconA {
        0% {
            opacity: 0;
        }
        30% {
            opacity: 1;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes iconA {
        0% {
            opacity: 0;
        }
        30% {
            opacity: 1;
        }
        100% {
            opacity: 1;
        }
    }

    .loader_wraper_inner {
        opacity: 0;
        display: table-cell;
        position: relative;
        z-index: 1;
        vertical-align: middle;
        text-align: center;
    }

    .loader_wraper_inner svg {
        max-width: 130px;
        width: 100%;
        height: auto;
    }

    .loader_wraper_inner svg .l_svg_top {
        stroke: #009ceb;
        fill: transparent;
        stroke-dasharray: 1200;
        stroke-dashoffset: 1200;
        -webkit-animation: sql linear 3s infinite 0s;
        animation: sql linear 3s infinite 0s;
    }

    .loader_wraper_inner svg .l_svg_bottom {
        stroke: #d2d2d2;
        fill: transparent;
        stroke-dasharray: 1200;
        stroke-dashoffset: 1200;
        -webkit-animation: sql_o linear 3s infinite 0s;
        animation: sql_o linear 3s infinite 0s;
    }

    .loader_wraper_inner svg .l_circle_one {
        stroke: #009ceb;
        fill: transparent;
        stroke-dasharray: 300;
        stroke-dashoffset: 300;
        -webkit-animation: circle_f linear 3s infinite 0s;
        animation: circle_f linear 3s infinite 0s;
    }

    .loader_wraper_inner svg .l_circle_two {
        stroke: #d2d2d2;
        fill: transparent;
        stroke-dasharray: 300;
        stroke-dashoffset: 300;
        -webkit-animation: circle_s linear 3s infinite 0s;
        animation: circle_s linear 3s infinite 0s;
    }

    @-webkit-keyframes sql {
        0% {
            fill: transparent;
            stroke-dashoffset: 1200;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        65% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
    }

    @keyframes sql {
        0% {
            fill: transparent;
            stroke-dashoffset: 1200;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        65% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
    }

    @-webkit-keyframes sql_o {
        0% {
            fill: transparent;
            stroke-dashoffset: 1200;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        65% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
    }

    @keyframes sql_o {
        0% {
            fill: transparent;
            stroke-dashoffset: 1200;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        65% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
    }

    @-webkit-keyframes circle_f {
        0% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        65% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        75% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        80% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
    }

    @keyframes circle_f {
        0% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        65% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        75% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        80% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #009ceb;
            stroke-dashoffset: 0;
        }
    }

    @-webkit-keyframes circle_s {
        0% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        65% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        75% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        80% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
    }

    @keyframes circle_s {
        0% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        60% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        65% {
            fill: transparent;
            stroke-dashoffset: 300;
        }
        75% {
            fill: transparent;
            stroke-dashoffset: 0;
        }
        80% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
        100% {
            fill: #d2d2d2;
            stroke-dashoffset: 0;
        }
    }

    /*loading text*/
    .loading_txt {
        margin: 0;
        color: #d2d2d2;
        text-transform: capitalize;
        letter-spacing: 2px;
        font-size: 16px;
    }

    .loading_txt:after {
        content: ' .';
        -webkit-animation: dots 1s steps(5, end) infinite;
        animation: dots 1s steps(5, end) infinite;
        font-size: 25px;
    }

    @-webkit-keyframes dots {
        0%,
        20% {
            color: rgba(0, 0, 0, 0);
            text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
        }
        40% {
            color: #d2d2d2;
            text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
        }
        60% {
            text-shadow: 0.25em 0 0 #d2d2d2, 0.5em 0 0 rgba(0, 0, 0, 0);
        }
        80%,
        100% {
            text-shadow: .25em 0 0 #d2d2d2, .5em 0 0 #d2d2d2;
        }
    }

    @keyframes dots {
        0%,
        20% {
            color: rgba(0, 0, 0, 0);
            text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
        }
        40% {
            color: #d2d2d2;
            text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
        }
        60% {
            text-shadow: 0.25em 0 0 #d2d2d2, 0.5em 0 0 rgba(0, 0, 0, 0);
        }
        80%,
        100% {
            text-shadow: .25em 0 0 #d2d2d2, .5em 0 0 #d2d2d2;
        }
    }
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

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Create Invoice</h4> -->
                    <div class="form-group">
                        <div class="row">
                        </div>
                    </div> 
                </div>
            </div>
            <div id="simple_invoice_wrapper" class="row" style="margin-bottom: 30px !important;">
                <div class="col-sm-12 col-md-8 col-lg-6" style="margin: auto;">
                    <?php if( isset($get_recurring_invoice) ) {
                        echo form_open('editRecurring/edit_customer_request/'.$get_recurring_invoice->id, array('id' => "my_form",'class'=>"row"));
                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                        $merchant_name = $this->session->userdata('merchant_name');
                        $names = substr($merchant_name, 0, 3); ?>
                
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col-sm-12 col-md-12 col-lg-12" style="padding: 0px 30px 0px 30px !important;">
                                            <div class="row" style="height: 55px !important;">
                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">
                                                    <input class="form-control" name="name" id="s_name" pattern="[a-zA-Z\s]+" required  placeholder="Name" value="<?=$get_recurring_invoice->name; ?>" required type="text" autocomplete="off" style="border: none !important;margin-top: 5px !important;">
                                                </div>
                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">
                                                    <input class="form-control" name="s_email" id="s_email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email" value="<?=$get_recurring_invoice->email_id; ?>"  type="text" style="border: none !important;margin-top: 5px !important;">
                                                </div>
                                            </div>
                                            <input type="hidden" class="new_token_input" id="new_token_input" name="new_token_input" value="">
                                            <style>
                                                @media (max-width: 1150px) {
                                                    input#money {
                                                        max-width: 280px !important;
                                                        font-size: 50px !important;
                                                    }
                                                }

                                                @media (min-width: 1151px) {
                                                    input#money {
                                                        max-width: 360px !important;
                                                        font-size: 56px !important;
                                                    }
                                                }

                                                @media (max-width: 1150px) {
                                                    .checkbox label {
                                                        font-size: 14px !important;
                                                    }
                                                }
                                            </style>
                                            <div class="row" style="height: 250px !important;border: 1px solid rgb(212, 240, 255) !important;padding-top: 70px !important;padding-bottom: 50px !important;">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <div class="" style="border: none !important;margin: auto !important;display: inline-flex;">
                                                                <div class="input-group-addon" style="border: none !important;background: none !important;height: 62px !important;padding: 0px !important;">
                                                                    <span class="input-group-text" style="font-size: 24px !important;font-family: AvenirNext-Medium;color: rgb(150, 150, 150) !important;">$</span>
                                                                </div>

                                                                <?php if($get_recurring_invoice->recurring_count_remain != 0){ ?>
                                                                    <input type="text" name="s_amount" value="<?=$get_recurring_invoice->amount; ?>" onkeyup="this.style.width = ((this.value.length + 30) * 8) + 'px';"   autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control text-right" id="money" value="<?=$get_recurring_invoice->amount; ?>" placeholder="0.00" style="background-color: #fff !important;border: none !important;text-align: center !important;height: 80px !important;font-family: AvenirNext-Medium !important;color:#000 !important;z-index: 0 !important;width:200px;"  readonly>
                                                                <?php } else { ?>
                                                                    
                                                                    <input type="text" name="s_amount" value="<?=$get_recurring_invoice->sub_total; ?>"onkeyup="this.style.width = ((this.value.length + 30) * 8) + 'px';"  required autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control text-right"  id="money" placeholder="0.00" style="background-color: #fff !important;border: none !important;text-align: center !important;height: 80px !important;font-family: AvenirNext-Medium !important;color:#000 !important;z-index: 0 !important;width:200px;">
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
<?php
                                                $getOtherCharges = $this->db->where('merchant_id',$merchant_id)->get('other_charges')->result();
                                                //print_r($getOtherCharges[0]->title);
                                                $data[0]['title'] = $getOtherCharges[0]->title ? $getOtherCharges[0]->title : '';
                                                $data[0]['percentage'] = $getOtherCharges[0]->percentage ? $getOtherCharges[0]->percentage : '';
                                                $data[0]['type'] = $getOtherCharges[0]->type ? $getOtherCharges[0]->type : '';
                                                ?>
                                                <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>

                                                <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>

                                                <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>

                                                <?php //print_r($data[0]); ?>
                                                <?php if($data[0]['percentage']!='') { ?>
                                                    <div class="row" style="margin-top: 10px;">
                                                        <div class="col-12 text-center">
                                                            <div class="checkbox text-center" style="display: inline-block !important;height: 20px !important;">
                                                                <label style="font-size: 16px;font-weight: 600;">

                                                                <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" class="form-check-input" <?php echo ($get_recurring_invoice->other_charges > 0) ? 'checked' : ''; ?>>

                                                                <?php if($get_recurring_invoice->other_charges > 0){echo $get_recurring_invoice->otherChargesName; } else { ?>Other Charges <?php } ?> - <?php if($get_recurring_invoice->other_charges > 0){echo $data[0]['percentage'];} else { ?>0 <?php } ?><?php if($data[0]['type']!=''){echo $data[0]['type'];} else { ?>$<?php } ?>, Total - $    <i class="input-frame"></i> <span id="full_amount_span"><?php echo ($get_recurring_invoice->other_charges > 0) ? $get_recurring_invoice->amount : '0.00'; ?></span>
                                                                
                                                                <input class="form-control"  name="other_charges_s" id="other_charges_s" type="hidden" value="<?=$get_recurring_invoice->other_charges; ?>" readonly>  
                                                                <input class="form-control" name="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>
                                                                <input class="form-control"  name="full_amount" id="full_amount" type="hidden" value="" readonly>
                                                                <input class="form-control"  name="full_amount_amount" id="full_amount_amount" type="hidden" value="" readonly>  
                                                                </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#money").click(function() {
                                                        $("#full_amount").val();
                                                        $("#full_amount_span").text('0.00');
                                                        //$("#other_amount_span").text();

                                                        $("#carrent_othercharges").prop("checked", false);
                                                    });

                                                    $('input[name="carrent_othercharges"]').click(function() {
                                                        if ($(this).prop("checked") == true) {
                                                            var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                                                            var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                                                            var currency = ($("#money").val()) ? $("#money").val() : 0;
                                                            var amount = Number(currency.replace(/[^0-9.-]+/g, ""));

                                                            if (other_charges_type == '$') {
                                                                var otherCharges = parseFloat(other_charges_value);
                                                                var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                                                            } else if (other_charges_type == '%') {
                                                                var subTotal = parseFloat(amount);
                                                                var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                                                                var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                                                            }

                                                            $("#full_amount_amount").val(currency);
                                                            //$("#money").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                            $("#full_amount").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                            $("#full_amount_span").text(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                            $("#other_charges_s").val(otherCharges.toFixed(2));

                                                        } else if ($(this).prop("checked") == false) {
                                                            var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                                                            var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                                                            var amount = ($("#full_amount").val()) ? $("#full_amount").val() : 0;
                                                            var full_amount_amount = ($("#full_amount_amount").val()) ? $("#full_amount_amount").val() : 0;

                                                            if (other_charges_type == '$') {
                                                                var otherCharges = parseFloat(other_charges_value);
                                                                var totalAmount = parseFloat(amount) - parseFloat(other_charges_value);
                                                            } else if (other_charges_type == '%') {
                                                                var subTotal = parseFloat(amount);
                                                                var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                                                                var totalAmount = parseFloat(amount) - parseFloat(otherCharges);
                                                            }
                                                            // $("#money").val(full_amount_amount);
                                                            $("#other_charges_s").val('');
                                                            $("#full_amount").val(full_amount_amount);
                                                            $("#full_amount_span").text(full_amount_amount);
                                                        }
                                                    });
                                                });
                                            </script>
                                                <input type="text" hidden name="invoice_no" value="<?=$get_recurring_invoice->invoice_no; ?>">
                                                <div class="row" style="height: 55px !important;">
                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">
                                                    <input class="form-control" placeholder="Mobile Number" name="s_mobile" id="s_phone" value="<?=$get_recurring_invoice->mobile_no; ?>" type="text" style="border: none !important;margin-top: 5px !important;" >
                                                </div>
                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">
                                                    <?php if($get_recurring_invoice->recurring_count_paid != 0){ ?>
                                                    <input type="text" name="s_start_date" class="form-control" value="<?=$get_recurring_invoice->recurring_pay_start_date; ?>" id="" placeholder="Start Date"  autocomplete="off" required style="border: none !important;margin-top: 5px !important;" readonly>
                                                    <?php } else { ?>
                                                        <input type="text" name="s_start_date" class="form-control" value="<?=$get_recurring_invoice->recurring_pay_start_date; ?>" id="s_invoiceDueDatePicker" placeholder="Start Date"  autocomplete="off" required style="border: none !important;margin-top: 5px !important;" required>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <!-- added -->
                                            <div class="row" style="height: 75px border: 1px solid rgb(212, 240, 255) !important;">
                                                <input type="text"  class="form-control text-center" name="recurring_type" value="<?php if($get_recurring_invoice->recurring_type_week!='')
                                                {
                                                    echo 'Weekly,'.$get_recurring_invoice->recurring_type_week;
                                                }
                                                else if($get_recurring_invoice->recurring_type_month!='')
                                                {
                                                    echo 'Monthly,'.$get_recurring_invoice->recurring_type_month;
                                                }
                                                else if($get_recurring_invoice->recurring_type!='')
                                                {
                                                    echo $get_recurring_invoice->recurring_type;
                                                }

                                                
                                                
                                                ?>" onclick="javascript:void(0)" id="recurring_type" readonly required>

                                            <input type="hidden"  name="recurring_type_hid" value=""  id="recurring_type_hid" >
                                            <!--     <select class="form-control" name="recurring_type" required>
                                                    <option value="" class="text-center">Interval</option>
                                                    <option value="daily" <?php if($get_recurring_invoice->recurring_type=='daily') echo 'selected';  ?>  class="text-center">Daily</option>
                                                    <option value="weekly" <?php if($get_recurring_invoice->recurring_type=='weekly') echo 'selected';  ?> class="text-center">Weekly</option>
                                                    <option value="biweekly" <?php if($get_recurring_invoice->recurring_type=='biweekly') echo 'selected';  ?> class="text-center">Bi Weekly</option>
                                                    <option value="monthly" <?php if($get_recurring_invoice->recurring_type=='monthly') echo 'selected';  ?> class="text-center" >Monthly</option>
                                                    <option value="quarterly" <?php if($get_recurring_invoice->recurring_type=='quarterly') echo 'selected';  ?> class="text-center">Quarterly</option>
                                                    <option value="yearly" <?php if($get_recurring_invoice->recurring_type=='yearly') echo 'selected';  ?> class="text-center">Yearly</option>
                                                </select> -->
                                            </div>

                                            <div class="row" style="height: 95px; border:1px solid rgb(212, 240, 255) !important;">
                                                <div class="text-center col-12 ">         
                                                    <label for="" style="display: block; margin-top:10px;"><b>Count</b> <img src="<?php echo base_url()?>new_assets/img/info.png"  title="Number of times your customer will be billed" aria-hidden="true" style="width:15px;"></label>
                                                </div>

                                                <div class="col-12 text-center">
                                                    <input type="radio" class="radio-circle" id="pd__constant" name="pd__constant" <?php if($get_recurring_invoice->recurring_count < 0 ) echo 'checked';  ?>>
                                                        <label for="pd__constant" class="inline-block">Constant</label>
                                                        &nbsp;&nbsp;OR
                                                        
                                                        <?php if($get_recurring_invoice->recurring_count < 0 ){ ?>
                                                        <input type='text' style="width: 55px;display: inline-block;vertical-align: middle;margin-left: 5px;background-color: #fff !important;padding: 2px !important;" class='form-control text-center' value='' name='recurring_count' value="" id='recurring_count' maxlength="3" placeholder="Count" onKeyPress="return isNumberKey(event)">
                                                        <?php } else { ?> 
                                                            <input type='text' style="width: 55px;display: inline-block;vertical-align: middle;margin-left: 5px;background-color: #fff !important;padding: 2px !important;" class='form-control text-center' name='recurring_count' id='recurring_count' value="<?php if($get_recurring_invoice->recurring_count_remain > 0 ) echo $get_recurring_invoice->recurring_count_remain; ?>" maxlength="3" placeholder="Count" onKeyPress="return isNumberKey(event)">
                                                            <?php } ?>
 
                                                 </div>
                                            </div>

                                            <div class="row" style="border:1px solid rgb(212, 240, 255) !important;">
                                                <div class="text-center col-12">
                                                    <div class="row mb-3">
                                                        <div class="text-center col-12">
                                                            <label for="" style="margin-top:10px;"><b>Type</b> <img src="<?php echo base_url()?>new_assets/img/info.png" title="Select either Auto or Manual type" aria-hidden="true" style="width:15px;"></label>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col-12 text-center">
                                                           <input type="radio" id="pt__Auto" value="1" name="paytype" <?php echo (($get_recurring_invoice->recurring_pay_type=='1')? 'checked' : ''); ?>>    Auto 
                                                        <input style="margin-left:50px;" type="radio" value="0" id="pt__Manual" <?php echo (($get_recurring_invoice->recurring_pay_type=='0')? 'checked' : ''); ?> name="paytype">    Manual
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                            <div class="text-center col-12">
                                                <a href="javascript:void(0)" class="btn btn-first" id="show_card_popup"><img src="<?php echo base_url('new_assets/img/Activity.png') ?>" style="width: 15px;margin-bottom: 4px;margin-right: 7px;">Add New Card</a>
                                            </div>
                                        </div>

                                        <div class="row token_section" style="margin-top: 15px;">
                                            <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                <div class="form-group small_box">
                                                    <p><b class="tokenStatus"><?php if($token!=''){?> Token Created
                                                        <?php }?></b></p>
                                                    <p><b class="token_value"></b></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                <div class="form-group small_box">
                                                    <div class="row" style="display: block !important;">
                                                        <div class="card_value text-center" style="margin-bottom: 5px;">
                                                                   <?php if($card_type!='') 
                                                                        if($card_type == 'amex') {
                                                                    
                                                                 echo '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                                                                } else if($card_type == 'visa') {
                                                                 
                                                                    echo '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                                                                } else if($card_type == 'diners') {
                                                                 
                                                                    echo '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                                                                } else if($card_type == 'mastercard' or $card_type=='mc') {
                                                                    echo '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                                                                } else if($card_type == 'jcb') {
                                                                    
                                                                    echo '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                                                                } else if($card_type == 'discover') {
                                                                    
                                                                    echo '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                                                             } else {
                //console.log('else');
                                                                    
                                                                    echo '<img src="https://salequick.com/new_assets/img/cardtypelogo.png" style="width: 48px;height: 30px;">';
             
            }
            
                                                                   ?>  
                                                        </div>
                                                    </div>
                                                    <div class="row" style="display: block !important;margin-bottom: 13px;">
                                                        <div class="text-center">
                                                            <b class="card_no_value">
                                                            
                                                            </b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            </div>

                                            <!-- added -->
                                            <div class="row" style="height: 85px; border:1px solid rgb(212, 240, 255) !important;">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <label for="" style="margin-top:10px;"><b>Duration</b> <img src="<?php echo base_url()?>new_assets/img/info.png"   title="Total Number of duration" aria-hidden="true" style="width:15px;"></label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <label aria-hidden="true">Remaining | Completed :</label>
                                                            <label aria-hidden="true">
                                                                <span style="color: red;"><?=$get_recurring_invoice->recurring_count_remain; ?></span> 
                                                                | <span style="color: orange;"> <?=$get_recurring_invoice->recurring_count_paid; ?></span>
                                                            </label>
                                                        </div>
                                                        <!-- <div class="col-6 text-center">
                                                            <label aria-hidden="true">
                                                                <span style="color: red;"><?=$get_recurring_invoice->recurring_count_remain; ?></span> 
                                                                | <span style="color: orange;"> <?=$get_recurring_invoice->recurring_count_paid; ?></span>
                                                            </label>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top: 60px;">
                                        <div class="col-6" style="margin: auto;">
                                            <input type="submit" id="btn_login"  name="submit" value="Save" class="btn btn-first" style="width: 100% !important;border-radius: 20px !important;">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;margin-bottom: 40px;">
                                        <div class="col-6 text-center" style="margin: auto;">
                                            <span id="s_invoice_loader" class="d-none">
                                                <div style="display: inline;"><img src="<?= base_url('new_assets/img/invoice_loader.gif') ?>" style="width: 20px;" /></div>
                                                <div style="display: inline;"><span> Saving...</span></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();

                    } else { ?>
                        <div class="text-center text-danger">No Data Found</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- interval popup -->
<div class="modal fade" id="interval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">Select Interval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="container-fluid" style="border: 1px solid rgb(212, 240, 255) !important; height: 70px;">

                     <button style="float: right; margin-top:13px;" type="button" class="btn btn-primary Daily" value="Daily" id="daily">Apply</button> 
                   
                    <h6 style="margin-top: 10px ;">Daily</h6>
                    <span style="color: gray;">Daily it will bill every day at 1pm cost</span>
                </div>
                <div class="container-fluid" style="border: 1px solid rgb(212, 240, 255) !important; height: 125px;">
                     <button style="float: right; margin-top:13px;" type="button" class="btn btn-primary" value="" id="weekly">Apply</button> 
                   
                    <h6 style="margin-top: 10px ;">Weekly</h6>
                    <span style="color: gray;">Please select day you would like weekly<br> charge to occur</span><br>
                    <button class="btn btn-secondary button5" id="Sun" value="Sunday">Sun</button>
                    <button class="btn btn-secondary button5" id="Mon" value="Monday">Mon</button>
                    <button class="btn btn-secondary button5" id="Tue" value="Tueday">Tue</button>
                    <button class="btn btn-secondary button5" id="Wed" value="Wednesday">Wed</button>
                    <button class="btn btn-secondary button5" id="Thu" value="Thursday">Thu</button>
                    <button class="btn btn-secondary button5" id="Fri" value="Friday">Fri</button>
                    <button class="btn btn-secondary button5" id="Sat" value="Saturday">Sat</button>
 
                </div>
                <div class="container-fluid" style="border: 1px solid rgb(212, 240, 255) !important; height: 120px;">
                     <button style="float: right; margin-top:13px;" type="button" class="btn btn-primary" id="monthlyBtn" name="monthly">Apply</button> 
                   
                    <h6 style="margin-top: 10px ;">Monthly</h6>
                    <span style="color: gray;">Please select day for charge to occur<br> 1 to 28th</span><br>
                    <select class="monthly" name="dateOfMonth" required>
                                    <option id="first" value="Select Date" class="text-center">Select Date</option>
                                    <?php
                                        for ($x = 1; $x <= 28; $x++) {
                                         ?><option value="<?php echo $x ?>" class="text-center"><?php echo $x ?></option>
                                    <?php
                                    }
                                    ?>
                                       
                    </select>
                </div>
            
            </div>
           
        </div>
    </div>
</div>


<div class="modal fade" id="AddCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 0px !important;">
    <div class="modal-dialog" role="document" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none !important;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #3A3C3F !important;font-weight: 600 !important;font-family: Nunito-Regular !important;margin-left: 20px;">Add Your Card Details</h5>
                <button id="card_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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

                <div class="invoice-wrapper">
                   <div class="irm-header-inner">
                        <form id="pop_inputs" class="cardPaymentFormWrapper row">
                            <div class="col-12">
                                <div class="row" style="display: block !important;">
                                    <div class="card-placeholder">
                                        <div class="card-inner-sketch">
                                            <div class="col-12" style="margin-top: 15px;">
                                                <div class="row" style="margin: 0px;display: block !important;">
                                                    <div class="mycl-wrapper responsive-cols flex-row">
                                                        <div class="col-6" style="padding: 0px !important;">
                                                            <div class="chip-logo">
                                                                <img src="<?php echo base_url('new_assets/img/chip.png') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-right" style="padding: 0px !important;">
                                                            <div class="card-type-logo" style="display: inline-flex !important;">
                                                                <img src="https://salequick.com/new_assets/img/cardtypelogo.png">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin: 0px;">
                                                    <p class="c__val card__no"><span>****</span><span>****</span><span>****</span><span>----</span></p>
                                                </div>

                                                <div class="mycl-wrapper row" style="margin: 0 !important;">
                                                    <div class="col-6" style="padding: 0 !important;max-width: 40px !important;margin-bottom: 10px;">
                                                        <p style="line-height: 10px !important;color: #fff !important;font-size: 10px !important;">VALID</p>
                                                        <p style="line-height: 10px !important;color: #fff !important;font-size: 10px !important;">THRU</p>
                                                    </div>
                                                    <div class="col-6" style="padding: 0 !important;">
                                                        <div class="flex-col">
                                                            <p class="c__val" style="margin-bottom: 5px !important;margin-top: 0px !important;"><span>--</span><span>/</span><span>--</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner-boxes">
                                            <div class="card-box  new-card-box" data-cardno="----" data-mm="--" data-yy="--" data-src="https://salequick.com/new_assets/img/cardtypelogo.png" data-chn="-" style="text-align: -webkit-center !important;">
                                                <input type="radio" value="newcard" name="card_selection_radio" <?php  if(count($token_data) <= '0') { echo  "checked";  } ?> >
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 card-form">
                                        <div class="pay-detail" style="display: inline-block;width: 100%;margin-top: 25px;">
                                            <h3 class="form-title card_form_title">Payment Details</h3>
                                            <input type="hidden" value="<?php print_r($getEmail1); ?>"/>
                                            
                                            <div class="form-group">
                                                <label for="card__cnumber" class="movbale">Card Number</label>
                                                <div class="input-group" style="height: 35px !important;">
                                                    <input id="card__cnumber" name="card_no" class="form-control required CardNumber" type="text" minlength="14">
                                                    <div class="input-group-addon" style="border: none !important;background-color: #fff !important;padding: 0px 5px !important;">
                                                        <span class="input-group-text card_type">
                                                            <img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="card__nameoncard" class="movbale">Card Holder Name</label>
                                                <input id="card__nameoncard"  name="name_card" class="form-control required" type="text">
                                            </div>
                                            
                                            <div class="mycl-wrapper responsive-cols flex-row row" style="margin: 0 -15px !important;">
                                                <div class="col-4" style="padding-left: 8px !important;">
                                                    <div class="form-group fg-half">
                                                        <?php
                                                        $currYr=date('Y');
                                                        $LastYr=$currYr + 20;
                                                        $yeardata=array();
                                                        for ($i=$currYr; $i < $LastYr; $i++) { 
                                                            array_push($yeardata,substr($i, 2,2));
                                                        }
                                                        ?>
                                                        <label for="card__validutil" class="movbale">Expire Date</label>
                                                        <input autocomplete="off"  id="card__validutil"  data-yr='<?php echo json_encode($yeardata);?>' name="exp" placeholder="MM/YY" class="form-control required ddmm" type="text"  maxlength="5">
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-left: 8px !important;">
                                                    <div class="form-group fg-half">
                                                        <label for="card__cvv" class="movbale">CVV</label>
                                                        <input id="card__cvv" class="form-control required cvv" type="text"  name="card_validation_num" maxlength="4">
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-left: 8px !important;padding-right: 8px !important;">
                                                    <div class="form-group">
                                                        <div class="form-group fg-half">
                                                            <label for="card__zip" class="movbale">Zip Code</label>
                                                            <input id="card__zip" name="zip" class="form-control zip required" type="text" maxlength="10" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-first d-colors" style="border-radius: 8px !important;margin: 15px 0px !important;width: 100%;">Complete The Payment</button>
                                    </div>
                                    <style>
                                        #myModal .modal-header {
                                            border-bottom: none !important;
                                        }
                                        p.modal-title {
                                            font-size: 14px;
                                            font-family: Nunito-Regular;
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
                                            font-family: Nunito-Regular;
                                            font-size: 16px;
                                        }
                                        p.terms_policy {
                                            color: rgb(148, 148, 146) !important;
                                            font-size: 12px !important;
                                            font-family: Nunito-Regular;
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
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="cardsave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 0px !important;">
     <div class="modal-dialog" role="document" style="max-width: 400px;">
        <div class="modal-content">

            <div class="modal-body text-center">
                
                <div class="container-fluid text-center" style="border: 1px solid rgb(212, 240, 255) !important; height: 550px;">
                    <img style="margin-top: 100px; width: 80px;" src="<?php echo base_url();?>new_assets/img/hand.png" >
                    <br><br><br>
                    <h4>Card Token has been created</h4>
                    <br><br><br>
                    <h5 style="color: blue;">Have a nice day!</h5>
                </div>
            
            </div>
           <div class="modal-footer text-center">
                
                <button type="button" id="saveTokenBtn" class="btn btn-primary">Save and Continue</button>
          </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>new_assets/js/cp_script_rec.js"></script>
<script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>

<script>

    $(document).ready(function() {
            
            $('.token_value').html(<?php echo $token ?>);
            $('.card_no_value').html(<?php echo $card_no ?>);
            
            
           

    var res="Select Date";
    $("select.monthly").change(function(){
        res = $(this).children("option:selected").val();
        
    }); 
     $("#Sun").click(function(){
            $("#weekly").val("Sunday");
            $("#Sun").css("backgroundColor", "#24a0ed");
            $("#Mon").css("backgroundColor", "#6c757d");
            $("#Tue").css("backgroundColor", "#6c757d");
            $("#Wed").css("backgroundColor", "#6c757d");
            $("#Thu").css("backgroundColor", "#6c757d");
            $("#Fri").css("backgroundColor", "#6c757d");
            $("#Sat").css("backgroundColor", "#6c757d");

        });
    $("#Mon").click(function(){
            $("#weekly").val("Monday");
            $("#Mon").css("backgroundColor", "#24a0ed");
            $("#Sun").css("backgroundColor", "#6c757d");
            $("#Tue").css("backgroundColor", "#6c757d");
            $("#Wed").css("backgroundColor", "#6c757d");
            $("#Thu").css("backgroundColor", "#6c757d");
            $("#Fri").css("backgroundColor", "#6c757d");
            $("#Sat").css("backgroundColor", "#6c757d");
        });
    $("#Tue").click(function(){
            $("#weekly").val("Tuesday");
            $("#Tue").css("backgroundColor", "#24a0ed");
            $("#Sun").css("backgroundColor", "#6c757d");
            $("#Mon").css("backgroundColor", "#6c757d");
            $("#Wed").css("backgroundColor", "#6c757d");
            $("#Thu").css("backgroundColor", "#6c757d");
            $("#Fri").css("backgroundColor", "#6c757d");
            $("#Sat").css("backgroundColor", "#6c757d");
        });
    $("#Wed").click(function(){
            $("#weekly").val("Wednesday");
            $("#Wed").css("backgroundColor", "#24a0ed");
            $("#Sun").css("backgroundColor", "#6c757d");
            $("#Mon").css("backgroundColor", "#6c757d");
            $("#Tue").css("backgroundColor", "#6c757d");
            $("#Thu").css("backgroundColor", "#6c757d");
            $("#Fri").css("backgroundColor", "#6c757d");
            $("#Sat").css("backgroundColor", "#6c757d");
        });
    $("#Thu").click(function(){
            $("#weekly").val("Thursday");
            $("#Thu").css("backgroundColor", "#24a0ed");
            $("#Sun").css("backgroundColor", "#6c757d");
            $("#Mon").css("backgroundColor", "#6c757d");
            $("#Tue").css("backgroundColor", "#6c757d");
            $("#Wed").css("backgroundColor", "#6c757d");
            $("#Fri").css("backgroundColor", "#6c757d");
            $("#Sat").css("backgroundColor", "#6c757d");
        });
    $("#Fri").click(function(){
            $("#weekly").val("Friday");
            $("#Fri").css("backgroundColor", "#24a0ed");
            $("#Sun").css("backgroundColor", "#6c757d");
            $("#Mon").css("backgroundColor", "#6c757d");
            $("#Tue").css("backgroundColor", "#6c757d");
            $("#Wed").css("backgroundColor", "#6c757d");
            $("#Thu").css("backgroundColor", "#6c757d");
            $("#Sat").css("backgroundColor", "#6c757d");
        });
    $("#Sat").click(function(){
            $("#weekly").val("Saturday");
            $("#Sat").css("backgroundColor", "#24a0ed");
            $("#Sun").css("backgroundColor", "#6c757d");
            $("#Mon").css("backgroundColor", "#6c757d");
            $("#Tue").css("backgroundColor", "#6c757d");
            $("#Wed").css("backgroundColor", "#6c757d");
            $("#Thu").css("backgroundColor", "#6c757d");
            $("#Fri").css("backgroundColor", "#6c757d");
            
        });

 $(":button").click(function(event){
     if($(this).prop("id") == "saveTokenBtn"){ 
            
            // $('.token_section').removeClass('d-none');
            $('#cardsave').modal('hide');
        }
  if($(this).prop("id") == "daily"){
   
    $("#recurring_type").val($(this).prop("value"));
    $("#recurring_type_hid").val($(this).prop("value"));
    $('#interval').modal('hide');
  }
  else if($(this).prop("id") == "weekly"){
    if($(this).prop("value")=="")
    {
        alert("Select a day");
    }
    else
    {
        $("#recurring_type").val("Weekly,"+$(this).prop("value"));
        $("#recurring_type_hid").val("Weekly,"+$(this).prop("value"));
        $('#interval').modal('hide');     
        //alert("Weekly,"+$(this).prop("value"));
    }
  } 
  else if($(this).prop("id") == "monthlyBtn")
  {
    if(res=="Select Date")
    {
        alert("Select a date from drop-down");
    }
    else
    {
         $("#recurring_type").val("Monthly,"+res);
         $("#recurring_type_hid").val("Monthly,"+res);
        $('#interval').modal('hide');     
        //alert("Monthly,"+res);
    }

    
  }
  // else if($(this).prop("id") == ""){
  //  alert($(this).prop("name"));
  // }
 });
 
});
//check
    $(document).on('click', '#recurring_type', function() {
        
        // var recurring_type = $('#recurring_type_hid').val();
        
        // if(recurring_type == '') {
        //     alert('Interval field is required');
        //     return false;
        // }


        $('#interval').modal('show');

    })

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
            // console.log(card_img)
            // console.log(card_img2);
            document.querySelector('.card_type').innerHTML = card_img;
            document.querySelector('.card-type-logo').innerHTML = card_img2;
            document.querySelector('.card-type-logo2').innerHTML = card_img2;
        }
    });

    $(document)
    .on('keydown blur','.card-form .required',function(){
        $('.card-form .form-group').removeClass('incorrect');
    })

    $('.d-colors').on('click', function (e) {
        if(allFieldsFilled()) {
            $('.d-colors').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
            var formData1 = $('#my_form').serialize();
            var formData2 = $('#pop_inputs').serialize();

            var formData = formData1+'&'+formData2;
            // console.log(formData);return false;

            $.ajax({
                url: "<?= base_url('AcceptCard/updateCard/'.$get_recurring_invoice->invoice_no) ?>",
                type: 'post',
                dataType: 'json',
                data: formData,
                success: function(data1) {
                    if(data1.code=='200') {
                        var msg_data = data1.msg;
                        $('.token_value').html(msg_data.token);
                        $('.tokenStatus').html('Token Created');
                        $('.new_token_input').val(msg_data.id);
                        $('.card_no_value').html(msg_data.card_no);
                        $('.card_value').html(msg_data.card_type);
                        
                        // console.log(msg_data.card_no);return false;
                        // $('small').html('Success');
                        // window.location.replace('<?php echo base_url('pos/all_customer_request_recurring'); ?>');

                        // $('.token_value').val()

                        $('#AddCard').modal('hide');     
                        $('#cardsave').modal('show');

                    } else {
                        $('.d-colors').html('Complete The Payment');
                        alert(data1.msg);return false;
                        // $('small').html(data1); 
                    }
                    // console.log(data1); 
                },
                error :function() {
                    //alert('error'); 
                    console.log('Error'); 
                }
            });
        }
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

    function validateFormm() {
        var x = document.forms["myFormm"]["s_amount"].value;
        
        if (x == "0.00") {
            alert("Amount Must Be Grater Than Zero");
            return false;

        } else if (x == "0") {
            alert("Amount Must Be Grater Than Zero");
            return false;

        } else if (x == "") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        }
    }

    $(document).on('click', '#show_card_popup', function() {
        var s_name = $('#s_name').val();
        var s_email = $('#s_email').val();
        var s_phone = $('#s_phone').val();
        var money = $('#money').val();

        var recurring_type = $('#recurring_type').val();
        var recurring_count = $('#recurring_count').val();

        if(s_name == '') {
            alert('Name field is required');
            return false;
        }

        if( (s_email == '') && (s_phone == '') ) {
            alert('Enter either Email Address or Mobile Number.');
            return false;
        }

        if (money == "0.00") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        } else if (money == "0") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        } else if (money == "") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        }

        if(recurring_type == '') {
            alert('Interval field is required');
            return false;
        }

        if( ($("#pd__constant").prop('checked') == false) && (recurring_count == '') ) {
            alert('Count field is required');
            return false;
        }

        if( ($("#pt__Auto").prop('checked') == false) && ($("#pt__Manual").prop('checked') == false) ) {
            alert('Type field is required');
            return false;
        }

        $('#AddCard').modal('show');
    })

    $(document).on('click', '#btn_login', function() {
        if($('#money').val() > 0) {
            var s_email = $('#s_email').val();
            var s_phone = $('#s_phone').val();

            if( (s_email == '') && (s_phone == '') ) {
                alert('Enter either Email Address or Mobile Number.');
                return false;
            }
            $('#s_invoice_loader').removeClass('d-none');
        }
    })

    $(document).on('click', '#recurring_count', function() {
        $("#pd__constant").prop('checked', false);
    })

    $(document).on('click', '#pd__constant', function() {
        $("#pd__constant").prop('checked', true);
        $('#recurring_count').val('');
    })

    if($('#s_invoiceDueDatePicker').length){
        // $("#s_invoiceDueDatePicker").val(moment().add(2,'Days').format("YYYY-MM-DD"));
        // $("#s_invoiceDueDatePicker").val(moment().format("YYYY-MM-DD"));
        $('#s_invoiceDueDatePicker').daterangepicker({
            minDate: new Date(),
            singleDatePicker: true,
            showDropdowns: true,
            locale: {format: "YYYY-MM-DD"}
        },
        function(start, end, label) {
        });
    }
</script>

<div class="row">
   <div class="col-md-12">
      <?php 
         $success=$this->session->userdata('success');
         if($success!="")
         {?>
         <div class="alert alert-success"> <?php echo $success;?> </div>
         <?php }?>

         <?php 
         $failure=$this->session->userdata('failure');
         if($failure!="")
         {?>
         <div class="alert alert-success"> <?php echo $failure;?> </div>
         <?php }?>
   </div>
</div>

<?php include_once'footer_rec_dash.php'; ?>