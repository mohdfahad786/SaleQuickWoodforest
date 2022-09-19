<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
    .bg-gray {
        background-color: #f2f2f2;
        padding: 15px;
        border-radius: 4px;
    }
    label {
        font-weight: 600;
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

            <?php
                echo form_open_multipart('email_template/'.$loc, array('id' => "my_form"));
                echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
            ?>
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-title"><?php echo $meta; ?></div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <p class="pt-2 pb-2 bg-gray">
                                                Amount = [AMOUNT] , Tax = [TAX] , Invoice no = [INVOICE_NO] , date = [PAYMENT_DATE] , Signature =[SIGN] , Amount without tax =[TAMOUNT] ,  Merchant Email = [EMAIL] , Merchant Phone =[PHONE]
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <textarea id="editor1" class="ckeditor" name="templete" ><?php echo (isset($templete) && !empty($templete)) ? $templete : set_value('templete');?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                    <div class="col-12 text-right">
                                        <input type="submit" id="btn_login" name="mysubmit" value="Update" class="btn btn-first" style="width: 230px !important;border-radius: 8px !important;">
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

<script type="text/javascript" src="<?php echo base_url('backup/assets/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'editor1', {
        fullPage: true,
        allowedContent: true,
        extraPlugins: 'wysiwygarea'
    });
</script>

<?php include_once'footer_dash.php'; ?>