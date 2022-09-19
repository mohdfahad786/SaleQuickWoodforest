<?php

    include_once'header_dash.php';

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

    #attachment_status, #attachment_status2 {
        color: #4BB543;
        font-family: AvenirNext-Medium !important;
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

                            <div class="simple-left-head">

                                <h4 class="font-weight-medium">Simple Invoice</h4>

                            </div>

                            <div class="simple-switch-section">

                                <div>

                                    <label class="switch switch_type1" role="switch" style="z-index: 0 !important;">

                                        <input type="checkbox" name="is_simple" id="is_simple" class="switch__toggle" <?php echo ($this->session->userdata('invoice_type') == '1') ? 'checked' : (($invoice_type == '1') ? 'checked' : '') ?>>

                                        <span class="switch__label"></span>

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            

            <div id="complex_invoice_wrapper" class="row" style="margin-bottom: 30px !important;">

                <div class="col-12">

                    <?php

                        echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=>"row inv-rec-wrapper",'enctype'=> 'multipart/form-data','name' => "myForm",'onsubmit' => "return validateForm()"));

                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

                        $merchant_name = $this->session->userdata('merchant_name');

                        $names = substr($merchant_name, 0, 3);

                    ?>

                    <!-- <form> -->

                        <div class="grid grid-chart" style="width: 100% !important;">

                            <div class="grid-body d-flex flex-column">

                                <div class="mt-auto">

                                    <div class="row">

                                        <div class="col-sm-6 col-md-6 col-lg-6">

                                            <div class="form-title">Customer Details</div>

                                            <div class="form-group">

                                                <label for="">Customer Name</label>

                                                <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" required  placeholder="Customer Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required type="text" autocomplete="off">

                                            </div>

                                            <div class="form-group">

                                                <label for="">Email Address</label>

                                                <input class="form-control basic_email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>"  type="text">

                                            </div>

                                            <div class="form-group">

                                                <label for="">Mobile Number</label>

                                                <input class="form-control basic_number" placeholder="Mobile Number" name="mobile" id="phone" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" type="text">

                                            </div> 

                                        </div>

                                        <div class="col-sm-6 col-md-6 col-lg-6">

                                            <div class="form-title">Invoice Details</div>

                                            <div class="row">

                                                <div class="col-sm-6 col-md-6 col-lg-6">

                                                    <div class="form-group">

                                                        <label for="">Invoice NO</label>

                                                        <input class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+" value="INV<?php echo strtoupper($names) ?>000<?php echo  $getDashboardData[0]['TotalOrders']+1; ?>" readonly required type="text">

                                                    </div>

                                                </div>

                                                <div class="col-sm-6 col-md-6 col-lg-6">

                                                    <div class="form-group">

                                                        <label for="">Reference</label>

                                                        <input class="form-control" name="reverence" id="reverence" placeholder="Reference" value="<?php echo (isset($reverence) && !empty($reverence)) ? $reverence : set_value('reverence');?>" type="text">

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="">Due Date</label>

                                                <input type="text" name="due_date" class="form-control"  id="invoiceDueDatePicker" placeholder="Due Date" name="" autocomplete="off" required>

                                            </div>

                                            <div class="form-group">

                                                <label for="">Title</label>

                                                <input class="form-control" name="title" id="title"  placeholder="Title" required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>" type="text">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <hr class="form-hr">

                            <div class="grid-body d-flex flex-column">

                                <div class="mt-auto product_row_section">

                                    <div class="row">

                                        <div class="col-sm-12 col-md-12 col-lg-12">

                                            <div class="form-title">Items</div>

                                        </div>

                                    </div>

                                    <div class="card-detail">

                                        <div class="row name_wrapper_row">

                                            <div class="col-sm-3 col-md-3 col-lg-3 col_prod_input">

                                                <label for="">Product</label>

                                            </div>

                                            <div class="col-sm-2 col-md-2 col-lg-2 col_qty_input">

                                                <label for="">QTY</label>

                                            </div>

                                            <div class="col-sm-2 col-md-2 col-lg-2 col_price_input">

                                                <label for="">Unit Price ($)</label>

                                            </div>

                                            <div class="col-sm-2 col-md-2 col-lg-2 col_tax_input">

                                                <label for="">Tax</label>

                                            </div>

                                            <!--<div class="col-sm-2 col-md-2 col-lg-2">-->

                                            <!--    <label for="">Other Charges</label>-->

                                            <!--</div>-->

                                            <div class="col-sm-2 col-md-2 col-lg-2 col_total_input">

                                                <label for="">Total ($)</label>

                                            </div>

                                            <div class="col-sm-1 col-md-1 col-lg-1 col_del_input"></div>

                                        </div>

                                        <div class="all_items_wrapper">

                                            <div class="row custom-form reset-col-p" style="margin-bottom: 10px;">

                                                <div class="item_row col-sm-3 col-md-3 col-lg-3 col_prod_input">

                                                    <input class="form-control item_name" name="Item_Name[]" id="item_name_1" placeholder="Product" type="text" required="">

                                                </div>

                                                <div class="item_row col-sm-2 col-md-2 col-lg-2 col_qty_input">

                                                    <input class="form-control item_qty" placeholder="QTY" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required>

                                                </div>

                                                <div class="item_row col-sm-2 col-md-2 col-lg-2 col_price_input">

                                                    <input class="form-control item_price"  id="price_1" required  name="Price[]" placeholder="Unit Price ($)" type="text" autocomplete="off" onKeyPress="return isNumberKeydc(event)">

                                                </div>

                                                <div class="item_row col-sm-2 col-md-2 col-lg-2 col_tax_input">

                                                    <?php

                                                        $merchant_id = $this->session->userdata('merchant_id');

                                                        $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' => 'active')); 

                                                    ?>

                                                    <select name="Tax[]" class="form-control sel_item_tax tax" id="tax_1">

                                                        <option rel="0" value="0" >No Tax</option>

                                                        <?php foreach ($data as $view) { ?>

                                                            <option rel="<?php echo $view['percentage']; ?>" value="<?php echo $view['id']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>

                                                        <?php } ?>

                                                    </select>

                                                    <input type="hidden" class="form-control price item_tax" id="tax_amount_1" placeholder="Tax Amount"  name="Tax_Amount[]" value="0">

                                                    <input type="hidden" class="form-control hide_tax" id="tax_per_1" name="Tax_Per[]" value="0">

                                                </div>



                                                <!--<div class="item_row col-sm-2 col-md-2 col-lg-2">-->

                                                <!--    <select name="o_charges[]" class="form-control sel_item_tax tax" id="tax_2">-->

                                                <!--        <option rel="0" value="0">No Charges</option>-->

                                                <!--        <option rel="0" value="1">1.00</option>-->

                                                <!--    </select>-->

                                                   

                                                <!--</div>-->



                                                <div class="item_row col-sm-2 col-md-2 col-lg-2 col_total_input">

                                                    <input class="form-control sub_total" placeholder="Total"  name="Total_Amount[]" id="total_amount_1" readonly type="text">

                                                </div>

                                                <div class="item_row col-sm-1 col-md-1 col-lg-1 col_del_input"></div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-12">

                                                <div class="item-adder new-item-adder">

                                                    <button type="button" class="add-item">Add Product</button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    

                                </div>

                            </div>

                            <hr class="form-hr">

                            <div class="grid-body d-flex flex-column">

                                <div class="mt-auto">

                                    <div class="row">

                                        <div class="col-sm-6 col-md-8 col-lg-8">

                                            <div class="row">

                                                <div class="col-sm-12 col-md-12 col-lg-12">

                                                    <label for="">Attachment</label>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-sm-12 col-md-12 col-lg-12" style="display: inline-flex;">

                                                    <div class="upload-btn-wrapper">

                                                        <button class="btn-attachment">

                                                            <i class="mdi mdi-upload"></i> Click here to add an attachment</button>

                                                        <!-- <input class="item_name" name="file" type="file"> -->
                                                        <input id="attachment_file" name="file" type="file">

                                                    </div>

                                                    <div style="padding: 10px 20px;">
                                                        <span id="attachment_status"></span>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-md-4 col-lg-4">

                                            <div class="form-title">Total and Subtotal</div>

                                            <div class="row">

                                                <div class="col-8">

                                                    <label class="invoicing_total_label" for="">Sub Total ($)</label>

                                                </div>

                                                <div class="col-4">

                                                    <input class="form-control" value="0.00" name="sub_amount" id="sub_amount" type="text" readonly style="background-color: #fff !important;border: none !important;text-align: right !important;">

                                                </div>

                                            </div>

                                            <div class="row">

                                             <div class="col-8">

                                                    <label class="invoicing_total_label" for="">Sub Tax ($)</label>

                                                </div>

                                               <div class="col-4">

                                                    <input class="form-control total_tax" name="total_tax" id="total_tax" value="0.00" type="text" readonly style="background-color: #fff !important;border: none !important;text-align: right !important;">

                                                </div>

                                            </div>

                                               <?php
                                                        $merchant_id = $this->session->userdata('merchant_id');

                                                        $data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id,'status' => 'active')); 

                                                    ?> 
                                            
                                         <?php if($data[0]['percentage']!='') { ?>
                                            <div class="row">

                                                <div class="col-8">

                                                    <label class="invoicing_total_label"><?php if($data[0]['title']!=''){echo $data[0]['title'];} else { ?>Other Charges <?php } ?> ($)</label>
                                                    
                                                 

                                                </div>

                                                <div class="col-4">

                                                                         

                                                    <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>

                                                    <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>

                                                    <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>                          

                                                    <!--<input class="form-control" placeholder="0.00" name="other_charges" id="other_charges" type="text" readonly>-->

                                                    <input class="amount form-control" name="other_charges" value="0.00" id="other_charges" type="text" readonly style="background-color: #fff !important;border: none !important;text-align: right !important;" readonly>

                                                </div>

                                            </div>
                                        
                                            <?php } ?>

                                            <div class="row">

                                               <div class="col-6">

                                                    <label for="" style="font-size: 18px !important;font-weight: 600 !important;margin-top: 5px !important;">Total Amount ($)</label>

                                                </div>

                                               <div class="col-6">

                                                    <input class="amount form-control" name="amount" value="0.00" id="amount" type="text" readonly style="background-color: #fff !important;border: none !important;font-size: 22px !important;font-weight: 600 !important;text-align: right !important;">

                                                </div>

                                            </div>

                                            
                                            <div class="row custom-form inv-custom-btns">
                                                <div class="col-6">
                                                    <button type="reset" class="btn btn-second" style="width: 100% !important;border-radius: 8px !important;">Clear All</button>
                                                </div>
                                                <div class="col-6">
                                                    <button id="invoice_send_btn" type="submit" name="submit" class="btn btn-first" style="width: 100% !important;border-radius: 8px !important;">Send Request</button>
                                                    <!--<button type="submit" name="submit" class="btn btn-first" style="width: 100% !important;border-radius: 8px !important;"><i class="fa fa-spin fa-spinner"></i> Sending...</button>-->
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php echo form_close();?>

                </div>

            </div>



            <div id="simple_invoice_wrapper" class="row" style="margin-bottom: 30px !important;">

                <div class="col-sm-12 col-md-8 col-lg-6" style="margin: auto;">

                    <?php
                        echo form_open('merchant/simple_invoice', array('id' => "my_form",'class'=>"row inv-rec-wrapper",'enctype'=> 'multipart/form-data','name' => "myFormm",'onsubmit' => "return validateFormm()"));

                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                    ?>

                        <div class="grid grid-chart" style="width: 100% !important;">

                            <div class="grid-body d-flex flex-column">

                                <div class="mt-auto">

                                    <div class="row" style="margin-top: 15px;">

                                        <div class="col-sm-12 col-md-12 col-lg-12" style="padding: 0px 30px 0px 30px !important;">

                                            <div class="row" style="height: 55px !important;">

                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">

                                                    <input class="form-control" name="name" id="s_name" pattern="[a-zA-Z\s]+" required  placeholder="Customer Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required type="text" autocomplete="off" style="border: none !important;margin-top: 5px !important;">

                                                </div>

                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">

                                                    <input class="form-control" name="s_email" id="s_email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email Address" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>"  type="text" style="border: none !important;margin-top: 5px !important;">

                                                </div>

                                            </div>

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

                                                                <!--<input class="form-control" autocomplete="off" onkeypress="return isNumberKey(event)" pattern = "^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$" autofill="off" name="s_amount" value="" id="s_amount" type="text" placeholder="0.00" style="background-color: #fff !important;border: none !important;font-size: 65px !important;text-align: center !important;height: 62px !important;font-family: AvenirNext-Medium !important;color:#000 !important;z-index: 0 !important;">-->
                                                                <input type="text"   name="s_amount"  onkeyup="this.style.width = ((this.value.length + 30) * 8) + 'px';"  required autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control text-right" id="money" value="0.00" placeholder="0.00" style="background-color: #fff !important;border: none !important;text-align: center !important;height: 80px !important;font-family: AvenirNext-Medium !important;color:#000 !important;z-index: 0 !important;width:200px;">
                                                            </div>

                                                        </div>

                                                    </div>


                                                    <?php if($data[0]['percentage']!='') { ?>
                                                        <div class="row" style="margin-top: 30px;">

                                                            <div class="col-12 text-center">

                                                                <!-- <input type="number" class="form-control" name="s_o_charges" id="s_o_charges" value="" placeholder="Other Charges" style="border: none !important;margin-top: 5px !important;"> -->

                                                                <div class="checkbox text-center" style="display: inline-block !important;height: 20px !important;">

                                                                    <label style="font-size: 16px;font-weight: 600;">

                                                                    <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" class="form-check-input" > <?php if($data[0]['title']!=''){echo $data[0]['title'];  } else { ?>Other Charges <?php } ?> - <?php if($data[0]['percentage']!=''){echo $data[0]['percentage'];} else { ?>0 <?php } ?><?php if($data[0]['type']!=''){echo $data[0]['type'];} else { ?>$<?php } ?>, Total - $    <i class="input-frame"></i> <span id="full_amount_span" >00.00</span> 
                                                                    
                                                                    <input class="form-control"  name="other_charges_s" id="other_charges_s" type="hidden" value="" readonly>  
                                                                    
                                                                    <input class="form-control" name="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>

                                                                    <input class="form-control"  name="full_amount" id="full_amount" type="hidden" value="" readonly>

                                                                    <input class="form-control"  name="full_amount_amount" id="full_amount_amount" type="hidden" value="" readonly>  
                                                                    </label>

                                                                </div>

                                                            </div>

                                                        </div>
                                                    <?php } ?>

                                                <!-- </div> -->

                                            </div>

                                        </div>

                                            
                                        <script>
                                            $(document).ready(function(){
                                                $("#money").click(function(){
                                                    $("#full_amount").val();
                                                    $("#full_amount_span").text('0.00');
                                                    //$("#other_amount_span").text();
                                                    $("#carrent_othercharges").prop("checked", false);
                                                });

                                                $('input[name="carrent_othercharges"]').click(function(){
                                                    if($(this).prop("checked") == true){
                                                        var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                                                        var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                                                        var currency = ($("#money").val()) ? $("#money").val() : 0;
                                                        var amount = Number(currency.replace(/[^0-9.-]+/g,""));

                                                        if(other_charges_type == '$'){
                                                            var otherCharges = parseFloat(other_charges_value);
                                                            var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                                                        } else if(other_charges_type == '%') {
                                                            var subTotal = parseFloat(amount) ;
                                                            var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                                                            var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                                                        }
                                                        
                                                        $("#full_amount_amount").val(currency);
                                                        //$("#money").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                        $("#full_amount").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                        $("#full_amount_span").text(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); 
                                                        $("#other_charges_s").val(otherCharges.toFixed(2));
                                                        
                                                    } else if($(this).prop("checked") == false){
                                                        var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                                                        var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                                                        var amount = ($("#full_amount").val()) ? $("#full_amount").val() : 0;
                                                        var full_amount_amount = ($("#full_amount_amount").val()) ? $("#full_amount_amount").val() : 0;
                                                 
                                                        if(other_charges_type=='$'){
                                                            var otherCharges = parseFloat(other_charges_value);
                                                            var totalAmount = parseFloat(amount) - parseFloat(other_charges_value)  ;
                                                        } else if(other_charges_type=='%'){
                                                            var subTotal = parseFloat(amount) ;
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

                                            <!-- <div class="row" style="height: 55px !important;">
                                                <div class="col-12" style="border: 1px solid rgb(212, 240, 255) !important;">
                                                    <input type="number" class="form-control" name="s_o_charges" id="s_o_charges" value="" placeholder="Other Charges" style="border: none !important;margin-top: 5px !important;">
                                                </div>
                                            </div> -->

                                            <div class="row" style="height: 55px !important;">

                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">

                                                    <input class="form-control" placeholder="Mobile Number" name="s_mobile" id="s_phone" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" type="text" style="border: none !important;margin-top: 5px !important;">

                                                </div>

                                                <div class="col-6" style="border: 1px solid rgb(212, 240, 255) !important;">

                                                    <input type="text" name="s_due_date" class="form-control" id="s_invoiceDueDatePicker" placeholder="Due Date" name="" autocomplete="off" required style="border: none !important;margin-top: 5px !important;">

                                                </div>

                                            </div>

                                            <div class="row" style="height: 90px !important;">

                                                <div class="col-12" style="border: 1px solid rgb(212, 240, 255) !important;">

                                                    <textarea class="form-control" name="s_detail" id="description" rows="4" cols="50" placeholder="Description" style="border: none !important;margin-top: 5px !important;resize: none;"></textarea>

                                                </div>

                                            </div>

                                            <div class="row" style="border: 1px solid rgb(212, 240, 255) !important;padding: 10px 13px !important;">

                                                <div class="col-sm-12 col-md-12 col-lg-12">

                                                    <label for="" style="color: rgb(162, 162, 163) !important;">Attachment</label>

                                                </div>

                                                <div class="col-sm-12 col-md-12 col-lg-12" style="display: inline-flex;">

                                                    <div class="upload-btn-wrapper">

                                                        <button class="btn-attachment">

                                                            <i class="mdi mdi-upload"></i> Click here to add an attachment</button>

                                                        <!-- <input class="item_name" name="file" type="file"> -->
                                                        <input id="attachment_file2" name="attached_file" type="file">

                                                    </div>

                                                    <div style="padding: 10px 20px;">
                                                        <span id="attachment_status2"></span>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!--<div class="row" style="margin-top: 60px;margin-bottom: 40px;">-->
                                    <!--    <div class="col-6" style="margin: auto;">-->
                                    <!--        <input type="submit" id="btn_login"  name="submit" value="Send" class="btn btn-first" style="width: 100% !important;border-radius: 20px !important;">-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="row" style="margin-top: 60px;">
                                        <div class="col-6" style="margin: auto;">
                                            <input type="submit" id="btn_login"  name="submit" value="Send" class="btn btn-first" style="width: 100% !important;border-radius: 20px !important;">
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top: 10px;margin-bottom: 40px;">
                                        <div class="col-6 text-center" style="margin: auto;">
                                            <span id="s_invoice_loader" class="d-none">
                                                <div style="display: inline;"><img src="<?= base_url('new_assets/img/invoice_loader.gif') ?>" style="width: 20px;" /></div> <div style="display: inline;"><span> Sending...</span></div>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php echo form_close();?>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    $('#attachment_file').change(function() {
        var filename = $(this).val();
        var lastIndex = filename.lastIndexOf("\\");
        if (lastIndex >= 0) {
            filename = filename.substring(lastIndex + 1);
        }
        // $('#attachment_status').val(filename);
        $('#attachment_status').html('<i class="fa fa-check"></i> Uploaded');
    });

    $('#attachment_file2').change(function() {
        var filename = $(this).val();
        var lastIndex = filename.lastIndexOf("\\");
        if (lastIndex >= 0) {
            filename = filename.substring(lastIndex + 1);
        }
        // $('#attachment_status').val(filename);
        $('#attachment_status2').html('<i class="fa fa-check"></i> Uploaded');
    });
            
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
    
    $(document).on('click', '#invoice_send_btn', function() {
        // if($('#amount').val() > 0) {
        //     $('#invoice_send_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
        // }
        // else {
        //     alert('Total Amount must be greater than zero');
        //     return false;
        // }
        var c_name = $("input[name=name]").val();
        var title = $("input[name=title]").val();
        var item_name = $("#item_name_1").val();
        var quantity = $("#quantity_1").val();
        var price = $("#price_1").val();

        var email = $(".basic_email").val();
        var mobile = $(".basic_number").val();

        if( (email == '') && (mobile == '') ) {
            alert('Enter either Email Address or Mobile Number.');
            return false;
        }
        
        if( (c_name != '') && (title != '') && (item_name != '') && (quantity != '') && (price != '') ) {
            $('#invoice_send_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
        } else {
            alert('Customer Name, Title, Product, Quantity and Unit Price fields are required.');
            $('#invoice_send_btn').html('Send Request');
            return false;
        }
    })

    // // $('input#s_amount').on('blur', function() {
    // $('input#s_amount').on('keyup',function(e){
    //     e.preventDefault();
    //     // $("input#s_amount").numeric();
    //     const value = this.value.replace(/,/g, '');
    //     this.value = parseFloat(value).toLocaleString('en-US', {
    //         style: 'decimal',
    //         maximumFractionDigits: 2,
    //         minimumFractionDigits: 2
    //     });
    // });


    $(document).ready(function() {

        if ($('#is_simple').is(':checked')) {

            $('#complex_invoice_wrapper').addClass("d-none");

            $('#simple_invoice_wrapper').removeClass("d-none");

        } else {

            $('#complex_invoice_wrapper').removeClass("d-none");

            $('#simple_invoice_wrapper').addClass("d-none");

        }

    })



    $(document).on('click', '#is_simple', function() {
        if ($(this).is(':checked')) {
            $('#complex_invoice_wrapper').addClass("d-none");
            $('#simple_invoice_wrapper').removeClass("d-none");
            var invoice_type = '1';
        } else {
            $('#complex_invoice_wrapper').removeClass("d-none");
            $('#simple_invoice_wrapper').addClass("d-none");
            var invoice_type = '0';
        }
        $.ajax({
            url: "<?php echo base_url('merchant/update_invoice_type') ?>",
            type: "POST",
            data: {invoice_type: invoice_type},
            success: function(data) {
                // if(data == '') {
                //     $('.custom_logo_style').attr("src", base_url+"new_assets/img/no-logo.png");
                //     $('.invoice-logo').attr("src", base_url+"new_assets/img/no-logo.png");
                //     $('.img-lg-custom').attr("src", base_url+"new_assets/img/no-logo.png");
                // }
            }
        });
    })



    if($('#s_invoiceDueDatePicker').length){

        $("#s_invoiceDueDatePicker").val(moment().add(2,'Days').format("YYYY-MM-DD"));

        $('#s_invoiceDueDatePicker').daterangepicker({

            singleDatePicker: true,

            showDropdowns: true,

            locale: {format: "YYYY-MM-DD"}

        },

        function(start, end, label) {

        });

    }

</script>



<?php include_once'footer_dash.php'; ?>

