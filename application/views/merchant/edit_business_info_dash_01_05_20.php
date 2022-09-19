<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

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
                    <!-- <h4 class="h4-custom">Business Info</h4> -->
                </div>
            </div>

            <?php
                echo form_open(base_url().'merchant/general_settings', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
                echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
            ?>
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="grid grid-chart" style="width: 100% !important;height: 515px !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Edit Business Info</div>
                                            <div class="form-group">
                                                <label for="">Address 1</label>
                                                <input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="address1" id="address1" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1');?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="">Address 2</label>
                                                <input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="address2" id="address2"  value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : set_value('address2');?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">City</label>
                                                <input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="city" id="city"   value="<?php echo (isset($city) && !empty($city)) ? $city : set_value('city');?>">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">State</label>
                                                        <select class="form-control" name="state" id="state" required <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>>
                                                            <option value="">Select State</option>
                                                            <option value="AL" <?php if($state=='AL') echo 'selected';  ?>>Alabama</option>
                                                            <option value="AK" <?php if($state=='AK') echo 'selected';  ?>>Alaska</option>
                                                            <option value="AZ" <?php if($state=='AZ') echo 'selected';  ?>>Arizona</option>
                                                            <option value="AR" <?php if($state=='AR') echo 'selected';  ?>>Arkansas</option>
                                                            <option value="CA" <?php if($state=='CA') echo 'selected';  ?>>California</option>
                                                            <option value="CO" <?php if($state=='CO') echo 'selected';  ?>>Colorado</option>
                                                            <option value="CT" <?php if($state=='CT') echo 'selected';  ?>>Connecticut</option>
                                                            <option value="DE" <?php if($state=='DE') echo 'selected';  ?>>Delaware</option>
                                                            <option value="DC" <?php if($state=='DC') echo 'selected';  ?>>District Of Columbia</option>
                                                            <option value="FL" <?php if($state=='FL') echo 'selected';  ?>>Florida</option>
                                                            <option value="GA" <?php if($state=='GA') echo 'selected';  ?>>Georgia</option>
                                                            <option value="HI" <?php if($state=='HI') echo 'selected';  ?>>Hawaii</option>
                                                            <option value="ID" <?php if($state=='ID') echo 'selected';  ?>>Idaho</option>
                                                            <option value="IL" <?php if($state=='IL') echo 'selected';  ?>>Illinois</option>
                                                            <option value="IN" <?php if($state=='IN') echo 'selected';  ?>>Indiana</option>
                                                            <option value="IA" <?php if($state=='IA') echo 'selected';  ?>>Iowa</option>
                                                            <option value="KS" <?php if($state=='KS') echo 'selected';  ?>>Kansas</option>
                                                            <option value="KY" <?php if($state=='KY') echo 'selected';  ?>>Kentucky</option>
                                                            <option value="LA" <?php if($state=='LA') echo 'selected';  ?>>Louisiana</option>
                                                            <option value="ME" <?php if($state=='ME') echo 'selected';  ?>>Maine</option>
                                                            <option value="MD" <?php if($state=='MD') echo 'selected';  ?>>Maryland</option>
                                                            <option value="MA" <?php if($state=='MA') echo 'selected';  ?>>Massachusetts</option>
                                                            <option value="MI" <?php if($state=='MI') echo 'selected';  ?>>Michigan</option>
                                                            <option value="MN" <?php if($state=='MN') echo 'selected';  ?>>Minnesota</option>
                                                            <option value="MS" <?php if($state=='MS') echo 'selected';  ?>>Mississippi</option>
                                                            <option value="MO" <?php if($state=='MO') echo 'selected';  ?>>Missouri</option>
                                                            <option value="MT" <?php if($state=='MT') echo 'selected';  ?>>Montana</option>
                                                            <option value="NE" <?php if($state=='NE') echo 'selected';  ?>>Nebraska</option>
                                                            <option value="NV" <?php if($state=='NV') echo 'selected';  ?>>Nevada</option>
                                                            <option value="NH" <?php if($state=='NH') echo 'selected';  ?>>New Hampshire</option>
                                                            <option value="NJ" <?php if($state=='NJ') echo 'selected';  ?>>New Jersey</option>
                                                            <option value="NM" <?php if($state=='NM') echo 'selected';  ?>>New Mexico</option>
                                                            <option value="NY" <?php if($state=='NY') echo 'selected';  ?>>New York</option>
                                                            <option value="NC" <?php if($state=='NC') echo 'selected';  ?>>North Carolina</option>
                                                            <option value="ND" <?php if($state=='ND') echo 'selected';  ?>>North Dakota</option>
                                                            <option value="OH" <?php if($state=='OH') echo 'selected';  ?>>Ohio</option>
                                                            <option value="OK" <?php if($state=='OK') echo 'selected';  ?>>Oklahoma</option>
                                                            <option value="OR" <?php if($state=='OR') echo 'selected';  ?>>Oregon</option>
                                                            <option value="PA" <?php if($state=='PA') echo 'selected';  ?>>Pennsylvania</option>
                                                            <option value="RI" <?php if($state=='RI') echo 'selected';  ?>>Rhode Island</option>
                                                            <option value="SC" <?php if($state=='SC') echo 'selected';  ?>>South Carolina</option>
                                                            <option value="SD" <?php if($state=='SD') echo 'selected';  ?>>South Dakota</option>
                                                            <option value="TN" <?php if($state=='TN') echo 'selected';  ?>>Tennessee</option>
                                                            <option value="TX" <?php if($state=='TX') echo 'selected';  ?>>Texas</option>
                                                            <option value="UT" <?php if($state=='UT') echo 'selected';  ?>>Utah</option>
                                                            <option value="VT" <?php if($state=='VT') echo 'selected';  ?>>Vermont</option>
                                                            <option value="VA" <?php if($state=='VA') echo 'selected';  ?>>Virginia</option>
                                                            <option value="WA" <?php if($state=='WA') echo 'selected';  ?>>Washington</option>
                                                            <option value="WV" <?php if($state=='WV') echo 'selected';  ?>>West Virginia</option>
                                                            <option value="WY" <?php if($state=='WY') echo 'selected';  ?>>Wisconsin</option>
                                                            <option value="WY" <?php if($state=='WY') echo 'selected';  ?>>Wyoming</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Zip Code</label>
                                                        <input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="zip" id="zip" maxlength="6" onKeyPress="return isNumberKey(event)"   value="<?php echo (isset($zip) && !empty($zip)) ? $zip : set_value('zip');?>">
                                                        <input type="hidden" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="psw" id="psw" readonly required value="<?php echo (isset($psw) && !empty($psw)) ? $psw : set_value('psw');?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Phone</label>
                                                <input class="form-control us-phone-no" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Phone" name="business_number" id="business_number"  maxlength="14" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :" value="<?php echo (isset($business_number) && !empty($business_number)) ? $business_number : set_value('business_number');?>" required type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="grid grid-chart" style="width: 100% !important;height: 250px !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px !important;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Edit Notification & Reports</div>
                                            <div class="form-group">
                                                <label for="">Report Email Address</label>
                                                <input type="text" id="multipleEmailOnly" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Enter Emails only" class="form-control" name="report_email"  value="<?php echo (isset($report_email) && !empty($report_email)) ? $report_email : set_value('report_email');?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="display: block !important;">Email Report Type</label>
                                                <select id='reportEmailTypes' name="report_type[]" multiple data-placeholder="Select Report Type" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  >
                                                    <option value="">Please Select</option>
                                                    <?php 
                                                    $arraytdata=explode(",",$report_type);
                                                    if(isset($report_type) && !empty($report_type)) { ?>
                                                        <option value="daily" <?php if(in_array('daily',$arraytdata)) echo "selected"; ?>>Daily</option>
                                                        <option value="weekly" <?php if(in_array('weekly',$arraytdata)) echo "selected"; ?>>Weekly</option>
                                                        <option value="monthly" <?php if(in_array('monthly',$arraytdata)) echo "selected"; ?>>Monthly</option>
                                                    <?php } else {?>
                                                        <option value="daily" >Daily</option>
                                                        <option value="weekly" >Weekly</option>
                                                        <option value="monthly" >Monthly</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-chart" style="width: 100% !important;height: 250px !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px !important;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Edit Permissions</div>
                                            <div class="form-group" style="margin-top: 35px !important;margin-bottom: 25px !important;">
                                                <div class="checkbox">
                                                    <label for="nameoncsv" style="font-size: 14px !important;">
                                                        <input type="checkbox" class="form-check-input" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="csv_Customer_name" <?php if($csv_Customer_name > 0 ) echo 'checked'; ?> id="nameoncsv" value="1"> Want to show name on receipt to show on csv <i class="input-frame"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Time Zone</label>
                                                <select class="form-control" name="time_zone" id="time_zone" required <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> >
                                                    <option value="">--Select Time Zone--</option>
                                                    <?php  $sessionTime_zone=$this->session->userdata("time_zone"); 
                                                        foreach(timezone_identifiers_list() as $key => $zone) {  
                                                            date_default_timezone_set($zone);
                                                            $zones_array[$key]['zone'] = $zone;
                                                    ?> 
                                                    <option value="<?php echo $zone; ?>"   class="<?php echo $time_zone; ?>" <?php if($time_zone==$zone  ||  $sessionTime_zone==$zone){ echo 'selected'; } ?>><?php echo $zone; ?></option>
                                                    <?php  }  ?> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">API Key</div>
                                            <div class="form-group">
                                                <label for="">Auth Key</label>
                                                <input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="auth_key" id="auth_key" readonly required value="<?php echo (isset($auth_key) && !empty($auth_key)) ? $auth_key : set_value('auth_key');?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Merchant Key</label>
                                                <input type="text" class="form-control" name="merchant_key" id="merchant_key" readonly required value="<?php echo (isset($merchant_key) && !empty($merchant_key)) ? $merchant_key : set_value('merchant_key');?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Transaction Mode</label>
                                                <select class="form-control" name="transaction_mode" id="transaction_mode">
                                                    <option value="">Select Transaction Mode</option>
                                                    <option value="live">Live</option>
                                                    <option value="sandbox">Sandbox</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Change Password</div>
                                            <div class="form-group">
                                                <label for="">Old Password</label>
                                                <input type="password" class="form-control" name="old_pswd" value="" placeholder="Old Password" autocomplete="new-password">
                                                <!-- <input type="password" class="form-control" name="old_pswd" value="" placeholder="Old Password" autocomplete="false"> -->
                                            </div>
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" class="form-control"  autocomplete="false" name="npsw" placeholder="New Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Confirm Password</label>
                                                <input type="password" class="form-control"  autocomplete="false" placeholder="Confirm Password" name="cpsw">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                    <div class="col-12 text-right">
                        <input type="submit" id="btn_login" name="mysubmit" value="Save" class="btn btn-first" style="width: 230px !important;border-radius: 8px !important;">
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>

<script>
    $(document).ready(function() {
        $('input[name=old_pswd]').val('');
    })
</script>