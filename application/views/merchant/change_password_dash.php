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
                <div class="col-12 py-5 py-5-custom">
                    <h4 class="h4-custom">Update Password</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6" style="margin: auto;">
                    <?php
                        echo form_open(base_url().'merchant/change_password', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
                        echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
                    ?>
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Change Password</div>
                                            <div class="form-group">
                                                <label for="">Old Password</label>
                                                <input type="password" class="form-control" name="opsw" id="cpsw" value="" placeholder="Old Password" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" class="form-control"  autocomplete="off"  name="npsw" placeholder="New Password" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Confirm Password</label>
                                                <input type="password" class="form-control"  autocomplete="off" placeholder="Confirm Password" name="cpsw" required="">
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