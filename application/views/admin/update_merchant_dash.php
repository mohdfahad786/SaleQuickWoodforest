<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>
<link rel="stylesheet" type="text/css" href="https://salequick.com/new_assets/css/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>new_assets/css/bootstrap-datetimepicker-standalone.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<style>
    label {
        font-weight: 600;
    }
    .btn.btn-xs {
        margin-top: 3px !important;
        padding: 0px 10px !important;
    }
    #btn_login {
        margin-top: 15px !important;
    }
    @media screen and (max-width: 460px) {
        input, input::placeholder, label {
            font-size: 10px !important;
        }
        #btn_login {
            font-size: 13px !important;
            height: 35px !important;
            max-height: 30px !important;
            padding: 0px 5px !important;
        }
        .form-control:not(textarea) {
            height: 35px !important;
        }
    }
    .nav-tabs>li>a:hover {
        border-color: #eee #eee #ddd;
    }
    .nav>li>a:focus, .nav>li>a:hover {
        text-decoration: none;
        background-color: #eee;
    }
    .nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
    }
    .nav>li>a {
        position: relative;
        display: block;
        padding: 10px 15px;
        color: #337ab7;
        font-weight: 600 !important;
        font-family: 'Avenir-Black' !important;
        font-size: 16px;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #fff;
        border-color: #ddd #ddd #fff;
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
                <div class="col-12 py-5-custom"></div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-8 col-lg-12" style="margin: auto;">
                    <div class="grid grid-chart" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                                    
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#changePassword">Change Password</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#primary">Primary Contact</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#businessInfo">Business Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#ownerInfo">Owner Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#banking">Banking Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#pricing">Pricing</a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a class="nav-link" data-toggle="tab" href="#permission">Permissions</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="changePassword" class="tab-pane container active">
                                        <?php
                                        echo form_open('dashboard/' . $loc, array('id' => "my_form"));
                                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : ""; ?>
                                        <?php if(isset($view_menu_permissions) && $view_menu_permissions!="") {
                                                                $view_menu_permissions_Array=explode(',',$view_menu_permissions); 
                                                            } else {
                                                                $view_menu_permissions_Array=array();
                                                            }?>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email ID" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email'); ?>" required readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Change Password</label>
                                                        <?php if($loc == 'update_merchant'){ ?>
                                                            <input type="hidden" class="form-control" name="password" id="password" placeholder="Password" required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password'); ?>">
                                                            <input type="text" class="form-control" name="cpsw" id="cpsw"
                                                            placeholder="Generate Password" autocomplete="cpsw" readonly>
                                                        <?php } ?>
                                                        <input type="button" class="btn btn-first btn-md btn-xs" style="cursor:pointer;" onclick="makeid(7)" value="Generate Password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input type="submit" name="updatepassword" class="btn btn-first btn-md pull-right" value="Reset Password" />
                                                    </div>
                                                </div>
                                            </div>
                                        <?php echo form_close();?>
                                    </div>
                                    
                                    <div id="primary" class="tab-pane container ">
                                        <?php
                                        echo form_open('dashboard/'.$loc, array('id' => ""));
                                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : ""; ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Address</label>
                                                            <input type="text" class="form-control" name="address2" id="address2"
                                                            placeholder="Address" value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : set_value('address2'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <input type="email" class="form-control" name="email1" id="email1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email ID" value="<?php echo (isset($email1) && !empty($email1)) ? $email1 : set_value('email1'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Phone Number </label>
                                                            <input type="text" class="form-control" name="business_number" id="business_number" maxlength="10" onKeyPress="return isNumberKey(event)"
                                                            placeholder="Mobile No" value="<?php echo (isset($business_number) && !empty($business_number)) ? $business_number : set_value('business_number'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Report Email</label>
                                                    <input type="text" id="multipleEmailOnly" placeholder="Enter Emails only" class="form-control" name="report_email" value="<?php echo (isset($report_email) && !empty($report_email)) ? $report_email : set_value('report_email');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Batch Report Time</label>
                                                    <input type="text" name="batch_report_time" class="form-control" autocomplete="off" required="" placeholder="Batch Report Time" id="batch_report_time" value="<?php echo (isset($batch_report_time) && !empty($batch_report_time)) ? $batch_report_time : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px !important;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" class="btn btn-first btn-md pull-right btn_submit" value="<?php echo $action ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="businessInfo" class="tab-pane container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Legal Business Name</label>
                                                            <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Legal Business Name" value="<?php echo (isset($business_name) && !empty($business_name)) ? $business_name : set_value('business_name'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">DBA Name</label>
                                                            <input type="text" class="form-control" name="business_dba_name" id="business_dba_name" placeholder="DBA Name" value="<?php echo (isset($business_dba_name) && !empty($business_dba_name)) ? $business_dba_name : set_value('business_dba_name'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Business Type (i.e., Inc,LLC,LTD)</label>
                                                            <input type="text" class="form-control" name="business_type" id="business_type" placeholder="Business Type" value="<?php echo (isset($business_type) && !empty($business_type)) ? $business_type : set_value('business_type'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">EIN Number</label>
                                                            <input type="text" class="form-control" name="ien_no" id="ien_no" placeholder="EIN Number" value="<?php echo (isset($ien_no) && !empty($ien_no)) ? $ien_no : set_value('ien_no'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="">Address</label>
                                                            <input type="text" class="form-control" name="address1" id="address1" placeholder="Address" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">City</label>
                                                            <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo (isset($city) && !empty($city)) ? $city : set_value('city'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="">Country</label>
                                                            <input type="text" class="form-control" name="country" id="country" placeholder="Country" value="<?php echo (isset($country) && !empty($country)) ? $country : set_value('country'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="">Zip</label>
                                                            <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip" value="<?php echo (isset($zip) && !empty($zip)) ? $zip : set_value('zip'); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Website </label>
                                                    <input type="text" class="form-control" name="website" id="website" placeholder="Website" value="<?php echo (isset($website) && !empty($website)) ? $website : set_value('website'); ?>">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="">Year in Business </label>
                                                            <input type="text" class="form-control" name="year_business" id="year_business" placeholder="Year In Business" value="<?php echo (isset($year_business) && !empty($year_business)) ? $year_business : set_value('year_business'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="">Business Phone No.</label>
                                                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Business Phone Number" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px !important;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" class="btn btn-first btn-md pull-right btn_submit" value="<?php echo $action ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="ownerInfo" class="tab-pane container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input type="text" class="form-control" name="o_name" id="o_name" placeholder="Name" value="<?php echo (isset($o_name) && !empty($o_name)) ? $o_name : set_value('o_name'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email ID</label>
                                                    <input type="email" class="form-control" name="o_email" id="o_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email ID" value="<?php echo (isset($o_email) && !empty($o_email)) ? $o_email : set_value('o_email'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" class="form-control" name="o_phone" id="o_phone" maxlength="10" onKeyPress="return isNumberKey(event)" placeholder="Phone Number" value="<?php echo (isset($o_phone) && !empty($o_phone)) ? $o_phone : set_value('o_phone'); ?>">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Street</label>
                                                            <input type="text" class="form-control" name="bank_street" id="bank_street" placeholder="Street" value="<?php echo (isset($bank_street) && !empty($bank_street)) ? $bank_street : set_value('bank_street'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Zip</label>
                                                            <input type="text" class="form-control" name="bank_zip" id="bank_zip" placeholder="Zip" value="<?php echo (isset($bank_zip) && !empty($bank_zip)) ? $bank_zip : set_value('bank_zip'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Address</label>
                                                    <input type="text" class="form-control" name="o_address" id="o_address" placeholder="Address" value="<?php echo (isset($o_address) && !empty($o_address)) ? $o_address : set_value('o_address'); ?>">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">City</label>
                                                            <input type="text" class="form-control" name="bank_city" id="bank_city" placeholder="City" value="<?php echo (isset($bank_city) && !empty($bank_city)) ? $bank_city : set_value('bank_city'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Country</label>
                                                            <input type="text" class="form-control" name="bank_country" id="bank_country" placeholder="Country" value="<?php echo (isset($bank_country) && !empty($bank_country)) ? $bank_country : set_value('bank_country'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php if ($loc == 'update_merchant') {?>
                                                    <div class="form-group">
                                                        <label for="">Status</label>
                                                        <select class="form-control" name="status" id="status" required="">
                                                            <option value="active" <?php if ($status == 'pending_signup') {echo 'selected';}?>> Select an option </option>
                                                            <option value="active" <?php if ($status == 'active') {echo 'selected';}?>> Active </option>
                                                            <option value="block" <?php if ($status == 'block') {echo 'selected';}?>>
                                                                Block </option>
                                                            <option value="Activate_Details" <?php if ($status == 'Activate_Details') {echo 'selected';}?>>
                                                                Activate Details </option>
                                                            <option value="Waiting_For_Approval" <?php if ($status == 'Waiting_For_Approval') {echo 'selected';}?>>
                                                                Waiting For Approval </option>
                                                            <option value="pending" <?php if ($status == 'pending') {echo 'selected';}?>> Pending
                                                            </option>
                                                            <option value="confirm" <?php if ($status == 'confirm') {echo 'selected';}?>> Confirm
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Signature Status</label>
                                                        <select class="form-control" name="signature_status" id="statsignature_statusus" required="">
                                                            <option value="2"  disabled <?php if ($signature_status == '2') {echo 'selected';}?>  > Disable </option>
                                                            <option value="1" <?php if ($signature_status == '1') {echo 'selected';}?> > Allow </option>
                                                            <option value="0" <?php if ($signature_status == '0') {echo 'selected';}?>>Block</option>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <label for="">Social</label>
                                                    <input type="text" class="form-control" name="o_social" id="o_social" placeholder="Social" value="<?php echo (isset($o_social) && !empty($o_social)) ? $o_social : set_value('o_social'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Percentage Of Ownership</label>
                                                    <input type="text" class="form-control" name="o_percentage" id="o_percentage" onKeyPress="return isNumberKeydc(event)" placeholder="Percentage Of Ownership" value="<?php echo (isset($o_percentage) && !empty($o_percentage)) ? $o_percentage : set_value('o_percentage'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Protractor Status</label>
                                                    <select class="form-control" name="protractor_status" id="protractor_status"
                                                        required="">
                                                        <option value="1" <?php if ($protractor_status == '1') {echo 'selected';}?>> Active</option>
                                                        <option value="0" <?php if ($protractor_status == '0') {echo 'selected';}?>> Block</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" class="form-control" name="t_fee" id="t_fee" onKeyPress="return isNumberKeydc(event)" placeholder="Percent Fee" required value="<?php echo (isset($t_fee) && !empty($t_fee)) ? $t_fee : set_value('t_fee'); ?>">
                                                <input type="hidden" class="form-control" name="s_fee" id="s_fee" onKeyPress="return isNumberKeydc(event)" placeholder="Swipe Fee" required value="<?php echo (isset($s_fee) && !empty($s_fee)) ? $s_fee : set_value('s_fee'); ?>">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px !important;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" class="btn btn-first btn-md pull-right btn_submit" value="<?php echo $action ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="banking" class="tab-pane container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Account Number</label>
                                                    <input type="text" class="form-control" name="bank_account" id="bank_account" placeholder="Account Number" value="<?php echo (isset($bank_account) && !empty($bank_account)) ? $bank_account : set_value('bank_account'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Routing Number</label>
                                                    <input type="text" class="form-control" name="bank_routing" id="bank_routing" placeholder="Routing Number" value="<?php echo (isset($bank_routing) && !empty($bank_routing)) ? $bank_routing : set_value('bank_routing'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" value="<?php echo (isset($bank_name) && !empty($bank_name)) ? $bank_name : set_value('bank_name'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Funding Time</label>
                                                    <input type="text" class="form-control" name="funding_time" id="funding_time" placeholder="Funding Time" value="<?php echo (isset($funding_time) && !empty($funding_time)) ? $funding_time : set_value('funding_time'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px !important;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" class="btn btn-first btn-md pull-right btn_submit" value="<?php echo $action ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="pricing" class="tab-pane container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Monthly Gateway</label>
                                                    <input type="text" class="form-control" name="monthly_fee" id="monthly_fee" onKeyPress="return isNumberKeydc(event)" placeholder="Monthly Gateway" value="<?php echo (isset($monthly_fee) && !empty($monthly_fee)) ? $monthly_fee : set_value('monthly_fee'); ?>">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Chargeback</label>
                                                            <input type="text" class="form-control" name="chargeback" id="chargeback" onKeyPress="return isNumberKeydc(event)" placeholder="Chargeback" value="<?php echo (isset($chargeback) && !empty($chargeback)) ? $chargeback : set_value('chargeback'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Text/Email</label>
                                                            <input type="text" class="form-control" name="text_email" id="text_email" onKeyPress="return isNumberKeydc(event)" placeholder="Text/Email" value="<?php echo (isset($text_email) && !empty($text_email)) ? $text_email : set_value('text_email'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Invoice</label>
                                                            <input type="text" class="form-control" name="invoice" id="invoice" onKeyPress="return isNumberKeydc(event)" placeholder="Invoice" value="<?php echo (isset($invoice) && !empty($invoice)) ? $invoice : set_value('invoice'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Recurring</label>
                                                            <input type="text" class="form-control" name="recurring" id="recurring" onKeyPress="return isNumberKeydc(event)" placeholder="Recurring" value="<?php echo (isset($recurring) && !empty($recurring)) ? $recurring : set_value('recurring'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Point Of Sale</label>
                                                            <input type="text" class="form-control" name="point_sale" id="point_sale" onKeyPress="return isNumberKeydc(event)" placeholder="Point Of Sale" value="<?php echo (isset($point_sale) && !empty($point_sale)) ? $point_sale : set_value('point_sale'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Swipe Invoice</label>
                                                            <input type="text" class="form-control" name="f_swap_Invoice" id="f_swap_Invoice" onKeyPress="return isNumberKeydc(event)" placeholder="Swipe Invoice" value="<?php echo (isset($f_swap_Invoice) && !empty($f_swap_Invoice)) ? $f_swap_Invoice : set_value('f_swap_Invoice'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 9px;">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Swipe Recurring</label>
                                                            <input type="text" class="form-control" name="f_swap_Recurring" id="f_swap_Recurring" onKeyPress="return isNumberKeydc(event)" placeholder="Swipe Recurring" value="<?php echo (isset($f_swap_Recurring) && !empty($f_swap_Recurring)) ? $f_swap_Recurring : set_value('f_swap_Recurring'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Swipe POS</label>
                                                            <input type="text" class="form-control" name="f_swap_Text" id="f_swap_Text" onKeyPress="return isNumberKeydc(event)" placeholder="Swipe POS" value="<?php echo (isset($f_swap_Text) && !empty($f_swap_Text)) ? $f_swap_Text : set_value('f_swap_Text'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px !important;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" class="btn btn-first btn-md pull-right btn_submit" value="<?php echo $action ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="permission" class="tab-pane container d-none">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="">Dashboard</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="Dashboard" <?php if ( isset($view_menu_permissions) && in_array("1a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Dashboard" value="1a" class="form-check-input"> Dashboard <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4" style="padding-right: 0px !important;">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TransactionSummary" <?php if ( isset($view_menu_permissions) && in_array("1b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TransactionSummary" value="1b" class="form-check-input"> Transaction Summary <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="SalesTrends" <?php if ( isset($view_menu_permissions) && in_array("1c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="SalesTrends" value="1c" class="form-check-input"> Sales Trends <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Transaction</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("2a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInstoreMobile" value="2a" class="form-check-input"> Instore &amp; Mobile <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TInvoice" <?php if ( isset($view_menu_permissions) && in_array("2b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInvoice" value="2b" class="form-check-input"> Invoicing <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TRecurring" <?php if ( isset($view_menu_permissions) && in_array("2c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="TRecurring" value="2c" class="form-check-input"> Recurring <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Invoice/Virtual Terminal</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="VirtualTerminal"  <?php if ( isset($view_menu_permissions) && in_array("3a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="VirtualTerminal" value="3a" class="form-check-input"> Virtual Terminal <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="IInvoicing" <?php if ( isset($view_menu_permissions) && in_array("3b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="IInvoicing" value="3b" class="form-check-input"> Invoicing <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="IRecurring" <?php if ( isset($view_menu_permissions) && in_array("3c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="IRecurring" value="3c" class="form-check-input"> Recurring <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <label for="">Refund</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="RInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("4a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RInstoreMobile" value="4a" class="form-check-input"> Instore & Mobile <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="RInvoice" <?php if ( isset($view_menu_permissions) && in_array("4b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RInvoice" value="4b" class="form-check-input"> Invoice <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Inventory</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="ItemsManagement" <?php if ( isset($view_menu_permissions) && in_array("4c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ItemsManagement" value="4c" class="form-check-input"> Items Management <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="Reports" <?php if ( isset($view_menu_permissions) && in_array("4d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="Reports" value="4d" class="form-check-input"> Reports <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <label for="">Settings</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" checked="" <?php if ( isset($view_menu_permissions) && in_array("6", $view_menu_permissions_Array)) { echo 'checked'; }?>  name="Settings" id="Settings" value="6" class="form-check-input"> Settings <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        </div>
                                        <div class="row" style="margin-bottom: 10px !important;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" class="btn btn-first btn-md pull-right btn_submit" value="<?php echo $action ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
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

<script>
    $(function() {
        $("#business_number").mask("(999) 999-9999");
        $("#mobile").mask("(999) 999-9999");
        $("#o_phone").mask("(999) 999-9999");
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

    $('#batch_report_time').datetimepicker({
      // todayHighlight: true,
      // autoclose: true,
      format: 'HH:mm:ss'
      // format: 'LT'
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isNumberKeydc(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
            &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        //return result;
        $('#cpsw').val(result); 
        //alert(result); 
    }

    $(document).ready(function() {
        //tag input
        var emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if( $("#multipleEmailOnly").length) {
            $("#multipleEmailOnly").tagsinput({
                maxTags: 3,
            });
            $('#multipleEmailOnly').on('beforeItemAdd', function(event) {
                if(!emailRegx.test(event.item)){
                    event.cancel = true;
                }
            });
        }
    })

    $(document).on('click', '.btn_submit', function() {
        var batch_report_time = $('#batch_report_time').val();
        var zip = $('#zip').val();

        if(batch_report_time == '') {
            alert('Batch Report Time in Primary Contact Tab is required');
            return false;
        }

        if(zip == '') {
            alert('Zip in Business Info Tab is required');
            return false;
        }
    })
</script>

<?php include_once'footer_dash.php'; ?>