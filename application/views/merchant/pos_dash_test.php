<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .card {
        border-radius: 20px !important;
    }
    .card.content-card .card-title {
        padding: 40px 22px 20px 22px !important;
    }
    .card.content-card .card-detail {
        padding: 25px 0px 15px 0px !important;
    }
    .table td, .table th {
        border: none !important;
    }
    .table th, .table td {
        border: none !important;
    }
    .table tbody tr td span, table tbody tr td span {
        display: block !important;
    }
    .table tbody tr td, table tbody tr td {
        text-align: center !important;
        background-color: rgb(233, 240, 244);
        padding: 20px 0px 20px 0px;
        border-radius: 30px;
        width: 30px;
        cursor: pointer !important;
        font-size: 26px !important;
        font-family: AvenirNext-Medium !important;
    }
    .table, table {
        border-collapse: separate;
        border-spacing: 25px 15px;
    }
    .all_item_amounts {
        margin-right: 5px !important;
        color: #0288D1 !important;
        font-weight: normal !important;
        font-size: 17px !important;
        min-height: 40px !important;
        font-family: Avenir-Black !important;
    }
    @media (max-width: 1400px) {
        .table, table {
            border-spacing: 10px 15px;
        }
        .card.content-card .card-detail {
            padding: 25px 10px 15px 10px !important;
        }
    }
    @media (max-width: 1300px) {
        .table tbody tr td, table tbody tr td {
            padding: 15px 0px 15px 0px !important;
            font-size: 20px !important;
        }
        input#t_amount {
            height: 75px !important;
            font-size: 50px !important;
        }
    }
    @media (min-width: 1301px) {
        input#t_amount {
            height: 90px !important;
            font-size: 78px !important;
        }
    }
    /*.form-group {
        margin-bottom: 2rem !important;
    }*/
    @media (max-width: 400px) {
        .table tbody tr td, table tbody tr td {
            font-size: 20px !important;
        }
        input#t_amount {
            height: 75px !important;
            font-size: 50px !important;
        }
    }
    @media screen and (max-width: 600px) {
        .pos-page .calc-screen .calc-input .form-control {
            max-width: 225px;
        }
    }
    @media screen and (max-width: 1100px) {
        .label_for_sm_screen {
            height: 42px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .input-group-addon {
            padding: 0px !important;
        }
    }
    #citylist ul{
        margin-top: 0px;
        background: #fff;
        color: #000;
    }
    #citylist li{
        padding: 12px;
        cursor: pointer;
        color: black;
    }
    #citylist li:hover{
        background: #f0f0f0;
    }
</style>
<script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>

<div class="page-content-wrapper pos-page" style="padding-right: 0px !important">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom"></div>
            </div>

            <div class="row" style="width: 100% !important;">
                <div class="col-sm-6 col-md-6 col-lg-6 main_calc" style="margin: auto">
                    <div class="card content-card">
                        <div class="card-title">
                            <div class="calc-screen">
                                <style>
                                    .calc-large-digit::placeholder {
                                        color: black !important;
                                    }
                                </style>
                                <div class="calc-input">
                                    <div class="row">
                                        <div class="col-2" style="padding-left: 20px !important;">
                                            <h2 style="color: rgb(150, 150, 150) !important;font-family: AvenirNext-Medium !important;margin-top: 7px !important;">$</h2>
                                        </div>
                                        <div class="col-10" style="padding-left: 0px !important;">
                                            <input class="form-control calc-large-digit" type="text" placeholder="0.00" id="t_amount" onKeyPress="return isNumberKey(event)" autocomplete="off" style="border: none !important;text-align: right !important;width: 100% !important;padding-right: 0px !important;font-family: AvenirNext-Medium !important;color: #000 !important;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-detail">
                            <div class="">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td onclick="posCalcFn(this)" data-val="1" ><span class="b-btm-top"></span><span>1</span></td>
                                            <td onclick="posCalcFn(this)" data-val="2" ><span class="b-btm-top"></span><span>2</span></td>
                                            <td onclick="posCalcFn(this)" data-val="3" ><span class="b-btm-top"></span><span>3</span></td>
                                            <td data-symbol="back" id="pos-del-btn" rowspan="2" valign="middle">C</td>
                                        </tr>
                                        <tr>
                                            <td onclick="posCalcFn(this)" data-val="4" ><span class="b-btm-top"></span><span>4</span></td>
                                            <td onclick="posCalcFn(this)" data-val="5" ><span class="b-btm-top"></span><span>5</span></td>
                                            <td onclick="posCalcFn(this)" data-val="6" ><span class="b-btm-top"></span><span>6</span></td>
                                        </tr>
                                        <tr>
                                            <td onclick="posCalcFn(this)" data-val="7" ><span class="b-btm-top"></span><span>7</span></td>
                                            <td onclick="posCalcFn(this)" data-val="8" ><span class="b-btm-top"></span><span>8</span></td>
                                            <td onclick="posCalcFn(this)" data-val="9" ><span class="b-btm-top"></span><span>9</span></td>
                                            <td data-symbol="equal" id="pos-add-btn" rowspan="2" valign="middle" style="color: #fff !important;background-color: rgb(46, 201, 115) !important;">Charge</td>
                                        </tr>
                                        <tr>
                                            <td onclick="posCalcFn(this)" data-val="00"  colspan="2"><span class="b-btm-top"></span><span>00</span></td>
                                            <td onclick="posCalcFn(this)" data-val="0" ><span class="b-btm-top"></span><span>0</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="card_details" class="col-sm-6 col-md-6 col-lg-6 custom-form d-none">
                    <div class="card content-card">
                        <div class="card-detail" style="padding: 20px 15px 20px 15px !important;">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px;">
                                    <div class="col-12" style="margin-bottom: 20px !important;">
                                        <h4 class="h4-custom">Card Details </h4>
                                    </div>
                                    <div class="col-12" style="margin-bottom: 10px !important;">
                                        <?php
                                        $payroc = $this->session->userdata('payroc');
                                        if($payroc == 1) {
                                            echo form_open('payroc/card_payment/', array('id' => "my_form"));
                                            echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                                        } else {
                                            echo form_open('pos/card_payment/', array('id' => "my_form"));
                                            echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                                        }
                                        $merchant_name = $this->session->userdata('merchant_name');
                                        $names = substr($merchant_name, 0, 3);
                                        ?>

                                        <?php if($tax_option == '0') { ?>
                                            <div class="row">
                                                <div class="col-6 tax_section">
                                                    <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                        <div class="custom-checkbox">
                                                            <input type="checkbox" name="carrent_sales_tax_new" id="carrent_sales_tax_new" data-tax="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">
                                                            <label for="carrent_sales_tax_new" class="label_for_sm_screen">Apply Tax</label>
                                                        </div>
                                                        <div class="tax_view d-none">
                                                            <div class="input-group ">
                                                                <div class="input-group-addon">
                                                                    <span class="input-group-text">$</span>
                                                                </div>
                                                                <input class="form-control"  name="tax_value" id="tax_value" type="hidden" value="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>" readonly>
                                                                <input type="text" class="form-control" id="totaltax" readonly placeholder="0.00"  name="totaltax" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $merchant_id = $this->session->userdata('merchant_id');
                                                $data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id,'status' => 'active'));
                                                
                                                if($data[0]['percentage']!='') { ?>
                                                    <div class="col-6 ocharges_section">
                                                        <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>
                                                        <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>
                                                        <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>
                              
                                                        <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" data-charges="<?php if($data[0]['percentage']!=''){echo $data[0]['percentage']; }  else { echo '0';} ?>">
                                                                <label for="carrent_othercharges" class="label_for_sm_screen">Apply <?php echo $data[0]['title']; ?></label>
                                                            </div>
                                                            <div class="charges_view d-none">
                                                                <div class="input-group ">
                                                                    <div class="input-group-addon">
                                                                        <span class="input-group-text">$</span>
                                                                    </div>
                                                                    <input class="form-control " placeholder="0.00" name="other_charges" id="other_charges" type="text" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            
                                        <?php } else if( ($tax_option == '1') || ($tax_option == '2') ) { ?>
                                            <div class="row">
                                                <?php
                                                $merchant_id = $this->session->userdata('merchant_id');
                                                $data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id,'status' => 'active'));
                                                    
                                                if($data[0]['percentage']!='') { ?>
                                                    <div class="col-6 ocharges_section">
                                                        <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>
                                                        <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>
                                                        <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>
                              
                                                        <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" data-charges="<?php if($data[0]['percentage']!=''){echo $data[0]['percentage']; }  else { echo '0';} ?>">
                                                                <label for="carrent_othercharges" class="label_for_sm_screen">Apply <?php echo $data[0]['title']; ?></label>
                                                            </div>
                                                            <div class="charges_view d-none">
                                                                <div class="input-group ">
                                                                    <div class="input-group-addon">
                                                                        <span class="input-group-text">$</span>
                                                                    </div>
                                                                    <input class="form-control " placeholder="0.00" name="other_charges" id="other_charges" type="text" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-6 tax_section">
                                                    <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                        <div class="custom-checkbox">
                                                            <input type="checkbox" name="carrent_sales_tax_new" id="carrent_sales_tax_new" data-tax="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">
                                                            <label for="carrent_sales_tax_new" class="label_for_sm_screen">Apply Tax</label>
                                                        </div>
                                                        <div class="tax_view d-none">
                                                            <div class="input-group ">
                                                                <div class="input-group-addon">
                                                                    <span class="input-group-text">$</span>
                                                                </div>
                                                                <input class="form-control"  name="tax_value" id="tax_value" type="hidden" value="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>" readonly>
                                                                <input type="text" class="form-control" id="totaltax" readonly placeholder="0.00"  name="totaltax" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>

                                        <div class="form-group">
                                            <label for="">Total</label>
                                            <div class="input-group" style="border: none !important;">
                                                <div class="input-group-addon" style="border-right: none !important;">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="amount" readonly  placeholder="0.00" name="amount" pattern = "^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$" required style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;z-index: 0 !important;">
                                                <input type="hidden" class="form-control" id="orignal_amount" readonly placeholder="0.00"  name="orignal_amount">
                                                 <input type="hidden" class="form-control" id="main_amount" readonly placeholder="0.00"  name="main_amount">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Card Holder Name</label>
                                            <input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z0-9\s]+" placeholder="Card Holder Name" value="" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Card Number</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" onKeyUp="return isNumberKeyCardNo(event)" minlength="14" name="card_no" id="card_no" placeholder="Card Number"  required style="border-right: none !important;border-top-right-radius: 0px !important;border-bottom-right-radius: 0px !important;">

                                                <input type="hidden" name="card_type" id="card_type_post" value="">

                                                <div class="input-group-addon" style="border-left: none !important;">
                                                    <span class="input-group-text card_type"><img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="" class="label_for_sm_screen">Expiry Month</label>
                                                    <select class="form-control" name="expiry_month" id="expiry_month" required>
                                                        <option value="">MM</option>
                                                        <option value="01">Jan (01)</option>
                                                        <option value="02">Feb (02)</option>
                                                        <option value="03">Mar (03)</option>
                                                        <option value="04">Apr (04)</option>
                                                        <option value="05">May (05)</option>
                                                        <option value="06">June (06)</option>
                                                        <option value="07">July (07)</option>
                                                        <option value="08">Aug (08)</option>
                                                        <option value="09">Sep (09)</option>
                                                        <option value="10">Oct (10)</option>
                                                        <option value="11">Nov (11)</option>
                                                        <option value="12">Dec (12)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="" class="label_for_sm_screen">Expiry Year</label>
                                                    <select class="form-control" name="expiry_year" id="expiry_year" required>
                                                        <option value="">YY</option>
                                                        <option value="19">2019</option>
                                                        <option value="20">2020</option>
                                                        <option value="21">2021</option>
                                                        <option value="22">2022</option>
                                                        <option value="23">2023</option>
                                                        <option value="24">2024</option>
                                                        <option value="25">2025</option>
                                                        <option value="26">2026</option>
                                                        <option value="27">2027</option>
                                                        <option value="28">2028</option>
                                                        <option value="29">2029</option>
                                                        <option value="30">2030</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <?php if($payroc==1) { ?>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="" class="label_for_sm_screen">CVV</label>
                                                        <input type="text" class="form-control" name="cvv" id="cvv" autocomplete="off" minlength="3" maxlength="4" onKeyPress="return isNumberKey(event)" placeholder="CVV" required>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="" class="label_for_sm_screen">Zip</label>
                                                        <input type="text" class="form-control" name="zip" id="zip" autocomplete="off" minlength="3" maxlength="10" onKeyPress="return isNumberKey(event)" placeholder="Zip" required>
                                                    </div>
                                                </div>
                                            <?php } else {?>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="" class="label_for_sm_screen">CVV</label>
                                                        <input type="text" class="form-control" name="cvv" id="cvv" autocomplete="off" minlength="3" maxlength="4" onKeyPress="return isNumberKey(event)" placeholder="CVV" required>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4 col-md-4 col-lg-5">
                                                <div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="text" class="form-control" placeholder="Phone" name="mobile_no" id="phone">
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">OR</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-5">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <button id="paymentCheckoutSubmitBtn" type="submit" name="submit" class="btn btn-first" data-dismiss="modal" style="border-radius: 8px !important;">Pay Now</button>
                                            </div>
                                        </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header {
        border-bottom: none !important;
    }
</style>

<?php include_once'footer_dash.php'; ?>
<link href='<?php echo base_url('new_assets/css/jquery-ui.css'); ?>' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url('new_assets/js/jquery-ui.js'); ?>' type='text/javascript'></script>

<script>
    new Cleave('#card_no', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            console.log(type)
            if(type == 'amex') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 35px;">';
                var card_type_n = 'American Express';

            } else if(type == 'visa') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 35px;">';
                var card_type_n = 'Visa';

            } else if(type == 'diners') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 35px;">';
                var card_type_n = "Diner's Club";

            } else if(type == 'mastercard') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 35px;">';
                var card_type_n = 'MasterCard';

            } else if(type == 'jcb') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 35px;">';
                var card_type_n = 'JCB';

            } else if(type == 'discover') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 35px;">';
                var card_type_n = 'Discover';
                
            } else {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">';
                var card_type_n = 'Unknown';
            }
            document.querySelector('.card_type').innerHTML = card_img;
            $('#card_type_post').val(card_type_n);
        }
    });

    function isNumberKeyCardNo(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }

    $(document).ready(function() {
        $("#my_form")[0].reset();
        $('#t_amount').val('0.00');
    })

    $(document).on('keyup', '#card_no', function() {
        var CardNo = $('#card_no').val();
        var NameOnCard = $('#name').val();
            // console.log(CardNo);return false;
        if(CardNo.length > 16) {
            if(NameOnCard == '') {
                alert('Please enter Card Holder Name for card suggestion');
                return false;

            } else {
                $( "#card_no" ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url: "<?php echo base_url('pos/search_card_details');?>",
                            type: 'post',
                            dataType: "json",
                            data: {'CardNo': request.term, 'NameOnCard': NameOnCard},
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        if(ui.item.value) {
                            var result = ui.item.value;
                            var resultArr = result.split(",");
                            // console.log(resultArr);
                            $('#expiry_month').val(resultArr[0]);
                            $('#expiry_year').val(resultArr[1]);
                            $('#cvv').val(resultArr[2]);
                        }
                        return false;
                    }
                });
            }
        }
    })
    
    $('form').submit(function() {
        var phone = $('#phone').val();
        var email_id = $('#email_id').val();
        var pay_amount = parseFloat($('#amount').val());
        var count = 0;
        
        if(pay_amount == 0) {
            alert('Payable Amount must be greater than Zero');
            return false;
        }
        
        $('form#my_form input.form-control').each(function( i, field ) {
            if ( (field.id == 'name') || (field.id == 'card_no') || (field.id == 'cvv') ) {
                var f_id = field.id;
                var value = field.value;
                if (value == '') {
                    $('#'+f_id).css('background-color', '#ffcccb');
                    count++;
                } else {
                    $('#'+f_id).css('background-color', '#fff');
                }
            }
        });
        
        $('form#my_form select').each(function( i, field ) {
            var f_id = field.id;
            var value = field.value;
            if (value == '') {
                $('#'+f_id).css('background-color', '#ffcccb');
                count++;
            } else {
                $('#'+f_id).css('background-color', '#fff');
            }
        });
        
        if((phone == '') && (email_id == '')) {
			$('#phone').css('background-color', '#ffcccb');
			$('#email_id').css('background-color', '#ffcccb');
			count++;
		} else {
			$('#phone').css('background-color', '#fff');
			$('#email_id').css('background-color', '#fff');
		}
		
		console.log(count);
		if (count > 0) {
		    return false;
		} else {
            var fewSeconds = 5;
            var btn_submit = $('#paymentCheckoutSubmitBtn');
            console.log(btn_submit);
            btn_submit.html('<i class="fa fa-spin fa-spinner"></i> Processing...');

		    btn_submit.attr('disabled', 'disabled');
		}
    })

    $(document).on('click', '#pos-add-btn', function() {
        var new_amt1 = $('#t_amount').val();
         var new_amt = parseFloat(new_amt1) ;
        
        // if(new_amt != '' && new_amt != '0.00') {
        if(new_amt > 0) {
            $(".main_calc").removeAttr("style");
            $('#card_details').removeClass('d-none');
            $('#amount').val(new_amt.toFixed(2));
            $('#main_amount').val(new_amt.toFixed(2));
            $('#orignal_amount').val(new_amt.toFixed(2));
            
            $("#carrent_othercharges").prop("checked", false);
            $("#carrent_sales_tax_new").prop("checked", false);
            $('.charges_view').addClass('d-none');
            $('.tax_view').addClass('d-none');
            $("#other_charges").val('');
            $("#totaltax").val('');
        }
    })

    function virtualTerValidateForm() {
        var x = document.forms["my_form"]["amount"].value;
        if (x == "") {
            alert("Amount must be filled out");
            return false;
        }
    }

    function resetThis(){
        $('#sidebar-menu  a.virtual-terminal').trigger('click');
    }

    <?php if($tax_option == '0') { ?>
        $(document).on('click', '#carrent_othercharges', function(){
            if ($(this).is(':checked')) {
                $('.charges_view').removeClass('d-none');
            } else {
                $('.charges_view').addClass('d-none');
            }
        })

        $(document).on('click', '#carrent_sales_tax_new', function(){
            if ($(this).is(':checked')) {
                $('.tax_view').removeClass('d-none');
            } else {
                $('.tax_view').addClass('d-none');
                $("#other_charges").val();
            }
        })
        
        $(document).ready(function(){
            $('input[name="carrent_othercharges"]').click(function() {
                if($(this).prop("checked") == true){
                    var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                    var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                    var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                    var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                    if(orignal_amount!='') {
                        amount = orignal_amount;
                    } else {
                        amount = amount;
                    }
                    $("#orignal_amount").val(parseFloat(amount));
                    if(other_charges_type=='$'){
                        var otherCharges = parseFloat(other_charges_value);
                        var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                    } else if(other_charges_type=='%') {
                        var subTotal = parseFloat(amount) ;
                        var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                        var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                    }
                    $("#amount").val(totalAmount.toFixed(2));
                    $("#other_charges").val(otherCharges.toFixed(2));
                    $("#orignal_amount").val(parseFloat(amount));

                } else if($(this).prop("checked") == false) {
                    var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                    var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                    var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                    var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                    if(orignal_amount!='') {
                        amount == orignal_amount;
                    } else {
                        amount == amount;
                    }
                    $("#orignal_amount").val(parseFloat(amount));
             
                    if(other_charges_type=='$'){
                        var otherCharges = parseFloat(other_charges_value);
                        var totalAmount = parseFloat(amount) - parseFloat(other_charges_value)  ;
                    } else if(other_charges_type=='%'){
                        var subTotal = parseFloat(amount) ;
                        var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                        var totalAmount = parseFloat(amount) - parseFloat(otherCharges);
                    }
                    var new_amt = parseFloat(orignal_amount) ;
                    
                    $("#amount").val(new_amt.toFixed(2));
                    //$("#amount").val(parseFloat(orignal_amount));
                    $("#orignal_amount").val(parseFloat(orignal_amount));
                    $("#other_charges").val('');
                }
            });
            
            $('input[name="carrent_sales_tax_new"]').click(function() {
                var tax_value = ($("#tax_value").val()) ? $("#tax_value").val() : 0;
                var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                var main_amount = ($("#main_amount").val()) ? $("#main_amount").val() : 0;
                
                var subTotal = parseFloat(main_amount) ;
                var otherCharges = parseFloat(subTotal * (tax_value / 100));
                        
                if($(this).prop("checked") == true){
                    $("#other_charges").val(0);
                    $('.charges_view').addClass('d-none');
                    $("#carrent_othercharges").prop("checked", false);
                    
                    var totalAmount = parseFloat(otherCharges) + parseFloat(main_amount);
                    $("#amount").val(totalAmount.toFixed(2));
                    $("#totaltax").val(otherCharges.toFixed(2));
                    $("#orignal_amount").val(totalAmount.toFixed(2));

                } else if($(this).prop("checked") == false) {
                    var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                    var t_amount = ($("#t_amount").val()) ? $("#t_amount").val() : 0;
                    var new_amt = parseFloat(main_amount) ;
                    
                    $("#amount").val(new_amt.toFixed(2));
                    $("#orignal_amount").val(parseFloat(main_amount));
                    
                    $("#carrent_othercharges").prop("checked", false);
                    $("#carrent_sales_tax_new").prop("checked", false);
                    $('.charges_view').addClass('d-none');
                    $('.tax_view').addClass('d-none');
                    $("#other_charges").val('');
                    $("#totaltax").val('');
                }
            });
        });

    <?php } else if($tax_option == '1') { ?>
        $(document).on('click', '#carrent_othercharges', function(){
            if ($(this).is(':checked')) {
                $('.charges_view').removeClass('d-none');
            } else {
                $('.charges_view').addClass('d-none');
            }
        })

        $(document).on('click', '#carrent_sales_tax_new', function(){
            if ($(this).is(':checked')) {
                $('.tax_view').removeClass('d-none');
            } else {
                $('.tax_view').addClass('d-none');
                $("#other_charges").val();
            }
        })

        $(document).ready(function(){
            $('input[name="carrent_othercharges"]').click(function() {
                var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                var main_amount = ($("#main_amount").val()) ? $("#main_amount").val() : 0;
                if(orignal_amount!='') {
                    amount = orignal_amount;
                } else {
                    amount = amount;
                }
                $("#orignal_amount").val(parseFloat(amount));
                
                if($(this).prop("checked") == true){
                    if(other_charges_type=='$'){
                        var otherCharges = parseFloat(other_charges_value);
                        var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                    } else if(other_charges_type=='%') {
                        var subTotal = parseFloat(amount) ;
                        var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                        var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                    }
                    $("#amount").val(totalAmount.toFixed(2));
                    $("#other_charges").val(otherCharges.toFixed(2));
                    var orignal_amount = parseFloat(amount) + parseFloat(otherCharges);
                    $("#orignal_amount").val(orignal_amount.toFixed(2));

                } else if($(this).prop("checked") == false) {
                    var new_amt = parseFloat(main_amount);
                    
                    $("#amount").val(new_amt.toFixed(2));
                    $("#orignal_amount").val(new_amt.toFixed(2));
                    
                    $("#carrent_othercharges").prop("checked", false);
                    $("#carrent_sales_tax_new").prop("checked", false);
                    $('.charges_view').addClass('d-none');
                    $('.tax_view').addClass('d-none');
                    $("#other_charges").val('');
                    $("#totaltax").val('');
                }
            });
            
            $('input[name="carrent_sales_tax_new"]').click(function() {
                var tax_value = ($("#tax_value").val()) ? $("#tax_value").val() : 0;
                var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                var main_amount = ($("#main_amount").val()) ? $("#main_amount").val() : 0;
                var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                
                var subTotal = parseFloat(orignal_amount);
                var total_tax = parseFloat(subTotal * (tax_value / 100));
                // console.log(total_tax);
                        
                if($(this).prop("checked") == true) {
                    var totalAmount = parseFloat(total_tax) + parseFloat(orignal_amount);
                    $("#amount").val(totalAmount.toFixed(2));
                    $("#totaltax").val(total_tax.toFixed(2));

                } else if($(this).prop("checked") == false) {
                    var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                    var new_amt = parseFloat(orignal_amount);
                    
                    $("#amount").val(new_amt.toFixed(2));
                }
            });
        });

    <?php } else if($tax_option == '2') { ?>
        $(document).on('click', '#carrent_othercharges', function(){
            if ($(this).is(':checked')) {
                $('.charges_view').removeClass('d-none');
            } else {
                $('.charges_view').addClass('d-none');
            }
        })

        $(document).on('click', '#carrent_sales_tax_new', function(){
            if ($(this).is(':checked')) {
                $('.tax_view').removeClass('d-none');
            } else {
                $('.tax_view').addClass('d-none');
            }
        })

        $(document).ready(function(){
            $('input[name="carrent_othercharges"]').click(function() {
                var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                var main_amount = ($("#main_amount").val()) ? $("#main_amount").val() : 0;
                if(orignal_amount!='') {
                    amount = orignal_amount;
                } else {
                    amount = amount;
                }
                $("#orignal_amount").val(parseFloat(amount));
                
                if($(this).prop("checked") == true){
                    if(other_charges_type=='$'){
                        var otherCharges = parseFloat(other_charges_value);
                        var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                    } else if(other_charges_type=='%') {
                        var subTotal = parseFloat(amount) ;
                        var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                        var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                    }
                    $("#amount").val(totalAmount.toFixed(2));
                    $("#other_charges").val(otherCharges.toFixed(2));
                    var orignal_amount = parseFloat(amount) + parseFloat(otherCharges);
                    $("#orignal_amount").val(orignal_amount.toFixed(2));

                } else if($(this).prop("checked") == false) {
                    var new_amt = parseFloat(main_amount);
                    
                    $("#amount").val(new_amt.toFixed(2));
                    $("#orignal_amount").val(new_amt.toFixed(2));
                    
                    $("#carrent_othercharges").prop("checked", false);
                    $("#carrent_sales_tax_new").prop("checked", false);
                    $('.charges_view').addClass('d-none');
                    $('.tax_view').addClass('d-none');
                    $("#other_charges").val('');
                    $("#totaltax").val('');
                }
            });
            
            $('input[name="carrent_sales_tax_new"]').click(function() {
                var tax_value = ($("#tax_value").val()) ? $("#tax_value").val() : 0;
                var amount = ($("#amount").val()) ? $("#amount").val() : 0;
                var main_amount = ($("#main_amount").val()) ? $("#main_amount").val() : 0;
                var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                
                var subTotal = parseFloat(main_amount);
                var total_tax = parseFloat(subTotal * (tax_value / 100));
                // console.log(total_tax);
                        
                if($(this).prop("checked") == true) {
                    var totalAmount = parseFloat(total_tax) + parseFloat(orignal_amount);
                    $("#amount").val(totalAmount.toFixed(2));
                    $("#totaltax").val(total_tax.toFixed(2));

                } else if($(this).prop("checked") == false) {
                    var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                    var new_amt = parseFloat(orignal_amount);
                    
                    $("#amount").val(new_amt.toFixed(2));
                }
            });
        });
    <?php } ?>
</script>