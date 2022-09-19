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
                    <h4 class="h4-custom">Permissions</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6" style="margin: auto;">
                    <?php
                        echo form_open(base_url().'merchant/edit_permissions', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
                        echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
                    ?>
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px !important;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Edit Permissions</div>
                                            <div class="form-group">
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