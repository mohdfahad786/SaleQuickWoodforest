<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: 1px solid rgba(210, 223, 245) !important;
    }
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid rgba(210, 223, 245) !important;
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
                <div class="col-12 py-5 py-5-custom">
                    <h4 class="h4-custom">Notification & Reports</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6" style="margin: auto;">
                    <?php
                        echo form_open(base_url().'merchant/edit_report_notification', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
                        echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
                    ?>
                        <div class="grid grid-chart" style="width: 100% !important;">
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
                                    <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                        <div class="col-12">
                                            <input type="submit" id="btn_login" name="mysubmit" value="Save" class="btn btn-first" style="width: 100% !important;border-radius: 8px !important;">
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

<?php include_once'footer_dash.php'; ?>