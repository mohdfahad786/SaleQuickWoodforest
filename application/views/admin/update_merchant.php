<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title>Admin | Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
    <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        input.btn.btn-first.btn-md.btn-xs.pull-right {
            font-size: 12px;
            padding: 5px 12px;
            margin-top: 3px;
        }
        .col-sm-6 {
            max-width: 258px;
        }
    </style>
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
<div id="wrapper"> 
    <div class="page-wrapper edit-profile">     
        <div class="row">
            <div class="col-12">
              <div class="back-title m-title"> 
               <?php if (isset($this->session->userdata['mymsg_u'])) {echo "<h4 style='color: #61bb8e;
                    font-size: 25px;'>" . $this->session->userdata['mymsg_u'] . "</h4>";}
                $this->session->unset_userdata('mymsg_u');
                ?>
                <span><?php echo ($meta) ?> <?php if (isset($msg)) { echo $msg;  } ?></span>
              </div>
              <div style="color:red;"><?php echo validation_errors(); ?></div>
            </div>
        </div>
        <?php
            echo form_open('dashboard/' . $loc, array('id' => "my_form"));
            echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                    Account
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                              <label for="">Email</label>
                                              <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email Id:" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email'); ?>" required readonly> 
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Change Password</label>
                                                <?php if ($loc == 'update_merchant') {?>
                                                    <input type="hidden" class="form-control" name="password" id="password"
                                                    placeholder="Password" required
                                                    value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password'); ?>">
                                                    <input type="text" class="form-control" name="cpsw" id="cpsw"
                                                    placeholder="Generate Password:" autocomplete="cpsw" readonly>
                                                <?php }?>
                                                <input type="button" class="btn btn-first btn-md btn-xs pull-right" style="cursor:pointer; " onclick="makeid(7)" value="Generate Password" /> 
                                            </div>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                </div>
                            </div>
                            <div class="col">
                                <div class="custom-form">
                                    <div class="form-group">
                                        <input type="submit" id="btn_login" name="updatepassword" class="btn btn-first btn-md pull-right" value="Reset Password" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <?php echo form_close(); ?>
        <?php
            echo form_open('dashboard/' . $loc, array('id' => "my_form"));
            echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                    Business Information
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                              <label for="">Business Legal Name</label>
                                              <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name" value="<?php echo (isset($business_name) && !empty($business_name)) ? $business_name : set_value('business_name'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Business DBA Name</label>
                                                <input type="text" class="form-control" name="business_dba_name" id="business_dba_name" placeholder="Business DBA Name" value="<?php echo (isset($business_dba_name) && !empty($business_dba_name)) ? $business_dba_name : set_value('business_dba_name'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Business Type (Inc,LLC,LTD)</label>
                                                <input type="text" class="form-control" name="business_type" id="business_type" placeholder="Business Type (Inc,LLC,LTD)" value="<?php echo (isset($business_type) && !empty($business_type)) ? $business_type : set_value('business_type'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">EIN Number</label>
                                                <input type="text" class="form-control" name="ien_no" id="ien_no" placeholder="EIN Number" value="<?php echo (isset($ien_no) && !empty($ien_no)) ? $ien_no : set_value('ien_no'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">City</label>
                                                <input type="text" class="form-control" name="city" id="city" placeholder="City"
                                                value="<?php echo (isset($city) && !empty($city)) ? $city : set_value('city'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label class="">Country</label>
                                                <input type="text" class="form-control" name="country" id="country" placeholder="Country" value="<?php echo (isset($country) && !empty($country)) ? $country : set_value('country'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label class="">Address </label>
                                                <input type="text" class="form-control" name="address1" id="address1" placeholder="Address" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label class="">Website </label>
                                                <input type="text" class="form-control" name="website" id="website"
                                                placeholder="Website"
                                                value="<?php echo (isset($website) && !empty($website)) ? $website : set_value('website'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label class="">Year in Business </label>
                                                <input type="text" class="form-control" name="year_business" id="year_business"
                                                placeholder="Year In Business"
                                                value="<?php echo (isset($year_business) && !empty($year_business)) ? $year_business : set_value('year_business'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label class="">Business Phone Number</label>
                                                <input type="text" class="form-control" name="business_number"
                                                id="business_number" placeholder="Business Phone Number"
                                                value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile'); ?>"
                                                readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label class="">Zip</label>
                                                <input type="text" class="form-control" name="zip" id="zip" placeholder="zip"
                                                value="<?php echo (isset($zip) && !empty($zip)) ? $zip : set_value('zip'); ?>"
                                                readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                    Primary Contact
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                              <label for="">Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name:"
                                                    value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <input type="text" class="form-control" name="address2" id="address2"
                                                    placeholder="Address:"
                                                    value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : set_value('address2'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control" name="email1" id="email1"
                                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email Id:"
                                                    value="<?php echo (isset($email1) && !empty($email1)) ? $email1 : set_value('email1'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Phone Number </label>
                                                 <input type="text" class="form-control" name="business_number"
                                                    id="business_number" maxlength="10" onKeyPress="return isNumberKey(event)"
                                                    placeholder="Mobile No :"
                                                    value="<?php echo (isset($business_number) && !empty($business_number)) ? $business_number : set_value('business_number'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                    Funding Instruction
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                              <label for="">Bank Account</label>
                                              <input type="text" class="form-control" name="bank_account"
                                              id="bank_account" placeholder="Bank Account:"
                                              value="<?php echo (isset($bank_account) && !empty($bank_account)) ? $bank_account : set_value('bank_account'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Bank Routing</label>
                                                <input type="text" class="form-control" name="bank_routing"
                                                id="bank_routing" placeholder="Bank Routing:"
                                                value="<?php echo (isset($bank_routing) && !empty($bank_routing)) ? $bank_routing : set_value('bank_routing'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Bank Name</label>
                                                <input type="text" class="form-control" name="bank_name" id="bank_name"
                                                placeholder="Bank Name"
                                                value="<?php echo (isset($bank_name) && !empty($bank_name)) ? $bank_name : set_value('bank_name'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Funding Time </label>
                                                <input type="text" class="form-control" name="funding_time"
                                                id="funding_time" placeholder="Funding Time"
                                                value="<?php echo (isset($funding_time) && !empty($funding_time)) ? $funding_time : set_value('funding_time'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                    Fees
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Monthly Gateway Fee</label>
                                                <input type="text" class="form-control" name="monthly_fee" id="monthly_fee" onKeyPress="return isNumberKeydc(event)" placeholder="Monthly Gateway Fee:" value="<?php echo (isset($monthly_fee) && !empty($monthly_fee)) ? $monthly_fee : set_value('monthly_fee'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Chargeback Fee</label>
                                                <input type="text" class="form-control" name="chargeback" id="chargeback"
                                                onKeyPress="return isNumberKeydc(event)" placeholder="Chargeback:"
                                                value="<?php echo (isset($chargeback) && !empty($chargeback)) ? $chargeback : set_value('chargeback'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Text/Email Fee</label>
                                                <input type="text" class="form-control" name="text_email" id="text_email"
                                                onKeyPress="return isNumberKeydc(event)" placeholder="Text/Email:"
                                                value="<?php echo (isset($text_email) && !empty($text_email)) ? $text_email : set_value('text_email'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Invoice</label>
                                                <input type="text" class="form-control" name="invoice" id="invoice"
                                                onKeyPress="return isNumberKeydc(event)" placeholder="Invoice:"
                                                value="<?php echo (isset($invoice) && !empty($invoice)) ? $invoice : set_value('invoice'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Recurring</label>
                                                <input type="text" class="form-control" name="recurring" id="recurring"
                                                onKeyPress="return isNumberKeydc(event)" placeholder="Recurring:"
                                                value="<?php echo (isset($recurring) && !empty($recurring)) ? $recurring : set_value('recurring'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Point Of Sale</label>
                                                <input type="text" class="form-control" name="point_sale" id="point_sale"
                                                onKeyPress="return isNumberKeydc(event)" placeholder="Point Of Sale:"
                                                value="<?php echo (isset($point_sale) && !empty($point_sale)) ? $point_sale : set_value('point_sale'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Swipe Invoice</label>
                                                <input type="text" class="form-control" name="f_swap_Invoice"
                                                id="f_swap_Invoice" onKeyPress="return isNumberKeydc(event)"
                                                placeholder="Swipe Invoice:"
                                                value="<?php echo (isset($f_swap_Invoice) && !empty($f_swap_Invoice)) ? $f_swap_Invoice : set_value('f_swap_Invoice'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Swipe Recurring</label>
                                                <input type="text" class="form-control" name="f_swap_Recurring"
                                                id="f_swap_Recurring" onKeyPress="return isNumberKeydc(event)"
                                                placeholder="Swipe Recurring:"
                                                value="<?php echo (isset($f_swap_Recurring) && !empty($f_swap_Recurring)) ? $f_swap_Recurring : set_value('f_swap_Recurring'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Swipe POS Fee</label>
                                                <input type="text" class="form-control" name="f_swap_Text" id="f_swap_Text" onKeyPress="return  isNumberKeydc(event)" placeholder="Swipe Text/Email:" value="<?php echo (isset($f_swap_Text) && !empty($f_swap_Text)) ? $f_swap_Text : set_value('f_swap_Text'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col  fixed-col">
                                <div class="change-pass">
                                    Ownership
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                              <label for="">Name</label>
                                                <input type="text" class="form-control" name="o_name" id="o_name"
                                                        placeholder="Name:"
                                                        value="<?php echo (isset($o_name) && !empty($o_name)) ? $o_name : set_value('o_name'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Email Id</label>
                                                    <input type="email" class="form-control" name="o_email" id="o_email"
                                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"
                                                        placeholder="Email Id:"
                                                        value="<?php echo (isset($o_email) && !empty($o_email)) ? $o_email : set_value('o_email'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Phone Number</label>
                                                    <input type="text" class="form-control" name="o_phone" id="o_phone"
                                                        maxlength="10" onKeyPress="return isNumberKey(event)"
                                                        placeholder="Phone Number :"
                                                        value="<?php echo (isset($o_phone) && !empty($o_phone)) ? $o_phone : set_value('o_phone'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Street</label>
                                                    <input type="text" class="form-control" name="bank_street" id="bank_street"
                                                        placeholder="bank_street"
                                                        value="<?php echo (isset($bank_street) && !empty($bank_street)) ? $bank_street : set_value('bank_street'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">City</label>
                                                    <input type="text" class="form-control" name="bank_city" id="bank_city"
                                                        placeholder="bank_city"
                                                        value="<?php echo (isset($bank_city) && !empty($bank_city)) ? $bank_city : set_value('bank_city'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <?php if ($loc == 'update_merchant') {?>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Status</label>
                                                <select class="form-control" name="status" id="status" required="">
                                                        <option value="active"
                                                            <?php if ($status == 'active') {echo 'selected';}?>> Active </option>
                                                        <option value="block" <?php if ($status == 'block') {echo 'selected';}?>>
                                                            Block </option>
                                                        <option value="Activate_Details"
                                                            <?php if ($status == 'Activate_Details') {echo 'selected';}?>>
                                                            Activate Details </option>
                                                        <option value="Waiting_For_Approval"
                                                            <?php if ($status == 'Waiting_For_Approval') {echo 'selected';}?>>
                                                            Waiting For Approval </option>
                                                        <option value="pending"
                                                            <?php if ($status == 'pending') {echo 'selected';}?>> Pending
                                                        </option>
                                                        <option value="confirm"
                                                            <?php if ($status == 'confirm') {echo 'selected';}?>> Confirm
                                                        </option>
                                                    </select>
                                            </div>
                                        </div>      
                                    </div>
                                    <?php }?>
                                    <?php if ($loc == 'update_merchant') {?>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Signature Status</label>
                                                <select class="form-control" name="signature_status" id="statsignature_statusus" required="">
                                                    <option value="2"  disabled <?php if ($signature_status == '2') {echo 'selected';}?>  > Disable </option>
                                                    <option value="1" <?php if ($signature_status == '1') {echo 'selected';}?> > Allow </option>
                                                    <option value="0" <?php if ($signature_status == '0') {echo 'selected';}?>>Block</option>
                                                </select>
                                            </div>
                                        </div>      
                                    </div>
                                    <?php }?>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Social</label>
                                                    <input type="text" class="form-control" name="social" id="social"
                                                        placeholder="Social"
                                                        value="<?php echo (isset($social) && !empty($social)) ? $social : set_value('social'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                    <input type="text" class="form-control" name="o_address" id="o_address"
                                                        placeholder="Address"
                                                        value="<?php echo (isset($o_address) && !empty($o_address)) ? $o_address : set_value('o_address'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Percentage Of Ownership</label>
                                                    <input type="text" class="form-control" name="o_percentage"
                                                        id="o_percentage" onKeyPress="return isNumberKeydc(event)"
                                                        placeholder="Percentage Of Ownership"
                                                        value="<?php echo (isset($o_percentage) && !empty($o_percentage)) ? $o_percentage : set_value('o_percentage'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Country</label>
                                                    <input type="text" class="form-control" name="bank_country"
                                                        id="bank_country" placeholder="bank_country"
                                                        value="<?php echo (isset($bank_country) && !empty($bank_country)) ? $bank_country : set_value('bank_country'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Zip</label>
                                                    <input type="text" class="form-control" name="bank_zip" id="bank_zip"
                                                        placeholder="zip"
                                                        value="<?php echo (isset($bank_zip) && !empty($bank_zip)) ? $bank_zip : set_value('bank_zip'); ?>">
                                            </div>
                                        </div>      
                                    </div>
                                    <?php if ($loc == 'update_merchant') {?>
                                    <div class="col-sm-6">
                                        <div class="custom-form">
                                            <div class="form-group">
                                                <label for="">Protractor Status</label>
                                                <select class="form-control" name="protractor_status" id="protractor_status"
                                                    required="">
                                                    <option value="1"
                                                        <?php if ($protractor_status == '1') {echo 'selected';}?>> Active
                                                    </option>
                                                    <option value="0"
                                                        <?php if ($protractor_status == '0') {echo 'selected';}?>> Block
                                                    </option>
                                                </select>
                                            </div>
                                        </div>      
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="t_fee" id="t_fee"
                            onKeyPress="return isNumberKeydc(event)" placeholder="Percent Fee" required
                            value="<?php echo (isset($t_fee) && !empty($t_fee)) ? $t_fee : set_value('t_fee'); ?>">
                            <input type="hidden" class="form-control" name="s_fee" id="s_fee"
                            onKeyPress="return isNumberKeydc(event)" placeholder="Swipe Fee" required
                            value="<?php echo (isset($s_fee) && !empty($s_fee)) ? $s_fee : set_value('s_fee'); ?>">
                            <div class="col-12">
                                <div class="custom-form">
                                    <div class="form-group">
                                        <input type="submit" id="btn_login" name="submit"
                                            class="btn btn-first btn-md pull-right" value="<?php echo $action ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <?php echo form_close(); ?>
    </div>
</div>
    <script>
    var resizefunc = [];
    </script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<!-- Popper for Bootstrap -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
    <script>
    $(function() {
        $("#business_number").mask("(999) 999-9999");
        $("#business_number").on("blur", function() {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);
            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                var lastfour = last.substr(1, 4);
                var first = $(this).val().substr(0, 9);
                $(this).val(first + move + '-' + lastfour);
            }
        });
    });
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    function isNumberKeydc(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
            &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   //return result;
   $('#cpsw').val(result); 
   //alert(result); 
}
    </script>
</body>
</html>