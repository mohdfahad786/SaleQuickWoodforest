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
                    <!-- <h4 class="h4-custom"><?php echo ($meta)?></h4> -->
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin: auto !important;">
                    <?php
                        echo form_open('charges/'.$loc, array('id' => "my_form",'class' => "row"));
                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                    ?>
                    <!-- <form> -->
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-title"><?php echo ($meta)?></div>
                                            <div class="form-group">
                                                <label for="">Title</label>
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Title"  required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Type </label>
                                                <select name="type" class="form-control sel_item_tax tax" required >
                                                    <option value="">Select Type</option>
                                                    <?php if($loc='edit_charges') { ?>
                                                        <option value="%" <?php if($type=='%'){ echo 'selected'; } ?>>Percent (%)</option>
                                                        <option value="$" <?php if($type=='$'){ echo 'selected'; } ?> >Fixed ($)</option>
                                                    <?php }else { ?>
                                                        <option value="%">Percent (%)</option>
                                                        <option value="$">Fixed ($)</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Value</label>
                                                <input type="text" class="form-control" name="percentage" id="percentage" maxlength="10" onKeyPress="return isNumberKeydc(event)"  placeholder="Percentage " value="<?php echo (isset($percentage) && !empty($percentage)) ? $percentage : set_value('percentage');?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                        <div class="col-12 text-right">
                                            <input type="submit" id="btn_login" name="submit" class="btn btn-first" value="<?php echo $action ?>" style="border-radius: 8px !important;width: 100%;" />
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