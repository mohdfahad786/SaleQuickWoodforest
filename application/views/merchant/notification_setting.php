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
                <div class="col-12 py-5-custom"></div>
            </div>

            <?php
                echo form_open(base_url().'merchant/notification_setting', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
                echo isset($merchant_id) ? form_hidden('merchant_id', $merchant_id) : "";
            ?>
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto;">
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="form-title">Notification Setting</div>
                                    <div class="form-group">
                                        <label style="font-size: 14px !important;">Choose notification option:</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label style="font-size: 14px !important;">
                                                <input type="checkbox" class="form-check-input" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?> name="mail_notify" <?php if($mail_notify > 0) echo 'checked'; ?> id="mail_notify" value="1"> Want email notification? <i class="input-frame"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="nameoncsv" style="font-size: 14px !important;">
                                                <input type="checkbox" class="form-check-input" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?> name="sms_notify" <?php if($sms_notify > 0) echo 'checked'; ?> id="sms_notify" value="1"> Want sms notification? <i class="input-frame"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="nameoncsv" style="font-size: 14px !important;">
                                                <input type="checkbox" class="form-check-input" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?> name="push_notify" <?php if($push_notify > 0) echo 'checked'; ?> id="push_notify" value="1"> Want push notification? <i class="input-frame"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="btn_login" name="mysubmit" value="Save" class="btn btn-first" <?php if($this->session->userdata('employee_id')) { echo 'disabled'; }?> style="width: 100% !important;border-radius: 8px !important;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>