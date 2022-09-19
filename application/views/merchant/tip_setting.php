<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .start_stop_tax {
        margin: 0 !important;
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
                <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto !important;">
                    <?php
                        echo form_open('merchant/tip_setting', array('id' => "my_form",'class' => "row responsive-cols custom-form"));
                        //echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                    ?>
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-title"><?php echo ($meta) ?></div>
                                            <div class="row" style="margin-bottom: 10px;">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Suggested Tip</label>
                                                        <div class="start_stop_tax <?php if($tip == 1) { echo 'active'; } ?>" rel="<?php echo $a_data['id'];?>">
                                                            <label class="switch switch_type1" role="switch">
                                                                <input type="checkbox" name="tip" class="switch__toggle" <?php if($tip == 1) { echo 'checked'; } ?>>
                                                                <span class="switch__label">|</span>
                                                            </label>
                                                            <span class="msg">
                                                                <span class="stop">Stop</span>
                                                                <span class="start">Start</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <label for="">Tip Type</label>
                                                    <select name="tip_type" class="form-control">
                                                        <option value="$" <?php echo ($tip_type == '$') ? 'selected' : ''; ?>>$</option>
                                                        <option value="%" <?php echo ($tip_type == '%') ? 'selected' : ''; ?>>%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Tip Value 1</label>
                                                        <input type="text" class="form-control" name="tip_val_1" id="tip_val_1" required value="<?php echo (isset($tip_val_1) && !empty($tip_val_1)) ? $tip_val_1 : set_value('tip_val_1');?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Tip Value 2</label>
                                                        <input type="text" class="form-control" name="tip_val_2" id="tip_val_2" required value="<?php echo (isset($tip_val_2) && !empty($tip_val_2)) ? $tip_val_2 : set_value('tip_val_2');?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Tip Value 3</label>
                                                        <input type="text" class="form-control" name="tip_val_3" id="tip_val_3" required value="<?php echo (isset($tip_val_3) && !empty($tip_val_3)) ? $tip_val_3 : set_value('tip_val_3');?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Tip Value 4</label>
                                                        <input type="text" class="form-control" name="tip_val_4" id="tip_val_4" required value="<?php echo (isset($tip_val_4) && !empty($tip_val_4)) ? $tip_val_4 : set_value('tip_val_4');?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                        <div class="col-12 text-right">
                                            <input type="submit" id="btn_login" name="submit" class="btn btn-first" value="Update" style="border-radius: 8px !important;width: 100%;" />
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
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));

    $("#tip_val_1, #tip_val_2, #tip_val_3, #tip_val_4").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });
</script>

<?php include_once'footer_dash.php'; ?>