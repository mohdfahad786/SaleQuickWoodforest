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
        }
    }
    /*.form-group {
        margin-bottom: 2rem !important;
    }*/
</style>

<div class="page-content-wrapper pos-page" style="padding-right: 0px !important">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom"><?php echo $meta; ?></h4> -->
                </div>
            </div>

            <!-- <?php
                echo form_open('pos/'.$loc, array('id' => "my_form", 'class'=>"row", "onsubmit"=>"return virtualTerValidateForm()" ));
                echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
            ?> -->
                <div class="row" style="width: 100% !important;">
                    <div class="col-sm-6 col-md-6 col-lg-6 main_calc" style="margin: auto">
                        <div class="card content-card">
                            <div class="card-title">
                                <div class="calc-screen">
                                    <!-- <div class="text-right all_item_amounts calc_input_text amounts_card">
                                        <input class="form-control" type="text" placeholder="0" style="border: none !important;text-align: right !important; width: 100% !important;color: #0288D1 !important;font-size: 17px !important;padding-right: 0px !important;">
                                    </div> -->
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
                                            <div class="col-10">
                                                <input class="form-control calc-large-digit" type="text" placeholder="0.00" id="t_amount" onKeyPress="return isNumberKey(event)" autocomplete="off" style="border: none !important;text-align: right !important;font-size: 78px !important;height: 90px !important;width: 100% !important;padding-right: 0px !important;font-family: AvenirNext-Medium !important;color: #000 !important;">
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
                                                <!-- <td data-symbol="back" id="pos-del-btn" rowspan="2" valign="middle">C</td> -->
                                                <!-- <td data-symbol="back" id="pos-del-btn" rowspan="2" valign="middle"><span class="material-icons"> arrow_back</span></td> -->
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
                                                <!-- <td data-symbol="equal" id="pos-add-btn" rowspan="2" valign="middle"><span class="material-icons"> drag_handle</span></td> -->
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
                    <!-- <div class="col-sm-6 col-md-6 col-lg-6 custom-form">
                        <div class="card content-card">
                            <div class="card-detail">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px;">
                                        <div class="col-12" style="margin-bottom: 20px !important;">
                                            <h4 class="h4-custom">Current Sales</h4>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="tax" id="carrent_sales_tax" data-tax="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">
                                                <label for="carrent_sales_tax">Apply Tax</label>
                                            </div>
                                            <div class="apply_tax_view" style="display: none;">
                                                <label for="">Tax</label>
                                                <div class="input-group" style="border: none !important;">
                                                    <div class="input-group-addon" style="border-right: none !important;">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="totaltax" readonly placeholder="0.00"  name="totaltax" style="border-left: none !important;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Total</label>
                                            <div class="input-group" style="border: none !important;">
                                                <div class="input-group-addon" style="border-right: none !important;">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="amount" readonly  placeholder="0.00" name="amount" required style="border-left: none !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-first reset_button" onclick="resetThis()" style="width: 100% !important;border-radius: 8px !important;">Reset</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="submit" class="btn btn-second" style="width: 100% !important;border-radius: 8px !important;">Charge</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
                                                echo form_open('pos/card_payment/', array('id' => "my_form"));
                                                echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                                                $merchant_name = $this->session->userdata('merchant_name');
                                                $names = substr($merchant_name, 0, 3);
                                            ?>

                                                <div class="row">
                                                    
                                                     <div class="col-6">
                                                        <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                            <div class="custom-checkbox">
      <input type="checkbox" name="carrent_sales_tax_new" id="carrent_sales_tax_new" data-tax="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">
                                                               
                                                              
                                                                <label for="carrent_sales_tax_new">Apply Tax</label>
                                                            </div>
                                                            <div class="tax_view d-none">
                                                                <div class="input-group ">
                                                                    <div class="input-group-addon">
                                                                        <span class="input-group-text">$</span>
                                                                    </div>
                                                                    <input class="form-control"  name="tax_value" id="tax_value" type="hidden" value="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>" readonly>  
                                                                    <input type="text" class="form-control" id="totaltax" readonly placeholder="0.00"  name="totaltax">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $merchant_id = $this->session->userdata('merchant_id');
                                                        $data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id,'status' => 'active'));
                                                        
                                                        if($data[0]['percentage']!='') { ?>
                                                    <div class="col-6">
                                                        
                                                        <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>
                                                        <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>
                              
                                                        <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" data-charges="<?php if($data[0]['percentage']!=''){echo $data[0]['percentage']; }  else { echo '0';} ?>">
                                                                <label for="carrent_othercharges">Apply <?php echo $data[0]['title']; ?></label>
                                                            </div>
                                                            <div class="charges_view d-none">
                                                                <!-- <label for="">Other Charges</label> -->
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

                                                <!-- <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="tax" id="carrent_sales_tax" data-tax="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">
                                                <label for="carrent_sales_tax">Apply Tax</label>
                                            </div>
                                            <div class="apply_tax_view" style="display: none;">
                                                <label for="">Tax</label>
                                                <div class="input-group" style="border: none !important;">
                                                    <div class="input-group-addon" style="border-right: none !important;">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="totaltax" readonly placeholder="0.00"  name="totaltax" style="border-left: none !important;">
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="">Total</label>
                                            <div class="input-group" style="border: none !important;">
                                                <div class="input-group-addon" style="border-right: none !important;">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="amount" readonly  placeholder="0.00" name="amount" pattern = "^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$" required style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">
                                                <input type="hidden" class="form-control" id="orignal_amount" readonly placeholder="0.00"  name="orignal_amount">
                                                 <input type="hidden" class="form-control" id="main_amount" readonly placeholder="0.00"  name="main_amount">
                                            </div>
                                        </div>







                                                <!-- <div class="form-group">
                                                    <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" required value="<?php echo  $amount ; ?>" readonly>
                                                    <input type="hidden" class="form-control" name="tax" id="tax" required value="<?php echo $tax ; ?>" readonly>
                                                    <?php
                                                        $merchant_id = $this->session->userdata('merchant_id');
                                                        $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
                                                    ?>
                                                    <?php foreach ($data as $view) { ?>
                                                        <input type="hidden" class="form-control" name="TAX_ID[]" required value="<?php echo $view['id']; ?>" readonly>
                                                        <input type="hidden" class="form-control" name="TAX_PER[]" required value="<?php echo $view['percentage']; ?>" readonly>
                                                    <?php } ?>
                                                </div> -->
                                                <div class="form-group">
                                                    <label for="">Card Holder Name</label>
                                                    <input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" placeholder="Card Holder Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Card Number</label> 
                                                    <input type="text" class="form-control" autocomplete="off" onKeyPress="return isNumberKey(event)" minlength="14" maxlength="16" name="card_no" id="card_no" placeholder="Card Number" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="">Expiry Month</label>
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
                                                            <label for="">Expiry Year</label>
                                                            <select class="form-control" name="expiry_year" required>
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
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="">CVV</label>
                                                            <input type="text" class="form-control" name="cvv" id="cvv" autocomplete="off" minlength="3" maxlength="3" onKeyPress="return isNumberKey(event)" placeholder="CVV" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="form-group" style="margin-bottom: 0rem !important;">
                                                            <label for="">Phone</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group" style="margin-bottom: 0rem !important;">
                                                            <label for=""></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="form-group" style="margin-bottom: 0rem !important;">
                                                            <label for="">Email</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Phone" name="mobile_no" id="phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="" style="margin-top: 10px !important;">OR</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="form-group">
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
            <!-- <?php echo form_close();?> -->
        </div>
    </div>
</div>

<style>
    .modal-header {
        border-bottom: none !important;
    }
</style>



<?php include_once'footer_dash.php'; ?>

<script>
    $(document).on('click', '#pos-add-btn', function() {
        var new_amt = $('#t_amount').val();
        if(new_amt != '' && new_amt != '0.00') {
            $(".main_calc").removeAttr("style");
            $('#card_details').removeClass('d-none');
            $('#amount').val(new_amt);
            $('#main_amount').val(new_amt);
            $('#orignal_amount').val(new_amt);
            
             $("#carrent_othercharges").prop("checked", false);
              $("#carrent_sales_tax_new").prop("checked", false);
               $('.charges_view').addClass('d-none');
               $('.tax_view').addClass('d-none');
               $("#other_charges").val();
               $("#totaltax").val();
        }
    })

    // $(document).on('click', '#carrent_sales_tax', function(){
    //     if ($(this).is(':checked')) {
    //         $('.apply_tax_view').css("display", "");
    //     } else {
    //         $('.apply_tax_view').css("display", "none");
    //     }
    // })

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
             $('.charges_view').addClass('d-none');
             $("#carrent_othercharges").prop("checked", false);
        }
    })

    // $(document).on("click", ".reset_button", function(){
    //   $("#my_form")[0].reset();
    //   $('.apply_tax_view').addClass('d-none');
    //   $('.amounts_card').html('0');
    //   $('#t_amount').val('');
    // })

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

    // $(document).on('click', '#pos-add-btn', function() {
    //     // console.log($('#t_amount').val());
    //     var new_amt = $('#t_amount').val();
    //     if(new_amt != '' && new_amt != '0.00') {
    //         // alert(new_amt);
    //         // console.log($('.modal-body').find('#amount'));
    //         $('.modal-body').find('#amount').val(new_amt)
    //         $('#card-payment-modal').modal('show');
    //     }
    // })
</script>

<script>
    $(document).ready(function(){
        

        $('input[name="carrent_othercharges"]').click(function(){
            if($(this).prop("checked") == true){
                
         var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
         var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
         var amount = ($("#amount").val()) ? $("#amount").val() : 0;
         var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
         if(orignal_amount!='')
         {
           amount = orignal_amount;   
         }
         else
         {
              amount = amount;
         }
         $("#orignal_amount").val(parseFloat(amount));
        if(other_charges_type=='$'){
           var otherCharges = parseFloat(other_charges_value);
           var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                }
                else if(other_charges_type=='%'){
                    var subTotal = parseFloat(amount) ;
                    var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                     var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                }
                
                 $("#amount").val(totalAmount.toFixed(2));
                 $("#other_charges").val(otherCharges.toFixed(2));
                 $("#orignal_amount").val(parseFloat(amount));
            }
            else if($(this).prop("checked") == false){
                
         var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
         var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
         var amount = ($("#amount").val()) ? $("#amount").val() : 0;
         var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
         if(orignal_amount!='')
         {
           amount == orignal_amount;   
         }
         else
         {
              amount == amount;
         }
         $("#orignal_amount").val(parseFloat(amount));
         
        if(other_charges_type=='$'){
           var otherCharges = parseFloat(other_charges_value);
           var totalAmount = parseFloat(amount) - parseFloat(other_charges_value)  ;
                }
                else if(other_charges_type=='%'){
                    var subTotal = parseFloat(amount) ;
                    var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                     var totalAmount = parseFloat(amount) - parseFloat(otherCharges)  ;
           
                }
                $("#amount").val(parseFloat(orignal_amount));
                $("#orignal_amount").val(parseFloat(orignal_amount));
                $("#other_charges").val();
            }
        });
        
        
                $('input[name="carrent_sales_tax_new"]').click(function(){
                    
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
                 
            }
            else if($(this).prop("checked") == false){
                var orignal_amount = ($("#orignal_amount").val()) ? $("#orignal_amount").val() : 0;
                 var t_amount = ($("#t_amount").val()) ? $("#t_amount").val() : 0;
                
                $("#amount").val(parseFloat(main_amount));
                $("#orignal_amount").val(parseFloat(main_amount));
                $("#totaltax").val();
                $("#other_charges").val();
                $('.charges_view').addClass('d-none');
                $("#carrent_othercharges").prop("checked", false);
            }
        });
        
    });
</script>