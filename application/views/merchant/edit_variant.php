<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: block !important;
        width: 150px;
        margin: auto;
    }
    .btn {
        /*border: 1px solid rgb(210, 223, 245);*/
        color: rgb(148, 148, 146);
        background-color: #fff;
        padding: 8px 20px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        width: 100% !important;
    }
    @media (min-width: 1401px) {
        .btn {
            border: 2px solid rgba(210, 223, 245) !important;
        }
    }
    @media (max-width: 1400px) {
        .btn {
            border: 1px solid rgba(210, 223, 245) !important;
        }
    }
    .btn:not([class*='btn-inverse']):not(.component-flat) {
        box-shadow: none !important;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .custom_logo_style {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        max-height: 130px;
        width: 240px;
    }
    .logo_preview {
        text-align: center;
        margin-top: 5px;
        position: relative;
    }
    .image_btn {
        background: rgb(0, 166, 255) !important;
        color: #fff !important;
        width: 150px !important;
        height: 36px !important;
    }
    .logo_preview .logo_close {
        position: absolute;
        /*top: 18%;
        right: 29%;*/
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: #fff;
        color: #555;
        opacity: 0.5;
        font-size: 14px;
        padding: 0px 5px;
        border: 1px solid #555;
        cursor: pointer;
        border-radius: 50%;
        text-align: center;
    }
    .logo_preview .logo_close:hover {
        background-color: #555;
        color: #fff;
        opacity: 0.5;
    }
    .input-group-text {
        padding-left: 1px !important;
    }
    .input-group-addon {
        border: 1px solid rgba(210, 223, 245) !important;
    }
    @media (min-width: 1400px) {
        .input-group-addon {
            border: 2px solid rgba(210, 223, 245) !important;
        }
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
                        echo form_open('Inventory/'.$loc, array('id' => "my_form",'class' => "row", 'enctype'=> "multipart/form-data"));
                        //echo '<pre>';print_r($package_data);
                    ?>
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-title"><?php echo ($meta)?></div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Product</label>
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Product" required value="<?php echo $package_data->title; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Barcode</label>
                                                        <input type="text" class="form-control" name="barcode_data" id="barcode_data" placeholder="Barcode" value="<?php echo $package_data->barcode_data; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Tax %</label>
                                                        <select name="tax" class="form-control" id="tax">
                                                            <option  value="0.00" >No Tax(0.00%)</option>
                                                        <?php
                                                        foreach ($package_data_tax as $tax) { ?>
                                                            <option value="<?php echo $tax['percentage']; ?>" <?php if($tax['percentage'] == $package_data->tax) { echo 'selected'; } ?> ><?php echo $tax['title'].'('.$tax['percentage'].')'; ?></option>
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Price</label>
                                                        <input type="text" class="form-control" name="price" id="price" placeholder="Price" required value="<?php echo $package_data->price; ?>">
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Price</label>
                                                            <div class="input-group" style="border: none !important;">
                                                                <div class="input-group-addon" style="border-right: none !important;background-color: #fff !important;">
                                                                    <span class="input-group-text" style="font-size: 15px !important;">$</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="price" id="price" placeholder="0.00" onKeyPress="return isNumberKey(event)" autocomplete="off" value="<?php echo $package_data->price; ?>" style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Quantity</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <label class="switch switch_type1" role="switch" style="margin-top: 8px !important;">
                                                                                <input type="checkbox" id="quantity_switch" class="switch__toggle" checked>
                                                                                <span class="switch__label"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text" class="form-control" data-qty="" id="quantity" placeholder="Qty" required value="<?php echo ($package_data->quantity == 'I') ? '∞' : $package_data->quantity; ?>">
                                                                    <input type="hidden" name="quantity" id="quantity2" value="<?php echo ($package_data->quantity == 'I') ? '∞' : $package_data->quantity; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Low Sold Qty</label>
                                                                <input type="text" class="form-control" name="sold_qty_alert" id="sold_qty_alert"  placeholder="Low Sold Qty" value="<?php echo $package_data->sold_qty_alert; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">SKU</label>
                                                        <input type="text" class="form-control" name="sku" id="sku" placeholder="SKU" required value="<?php echo $package_data->sku; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                        <div class="col-6">
                                            <input type="hidden" id="prod_id" name="prod_id" value="<?php echo $package_data->id; ?>">
                                            <input type="submit" id="btn_login" name="submit" class="btn btn-first" value="<?php echo $action ?>" style="border-radius: 8px !important;width: 100%;" />
                                        </div>
                                        <div class="col-6">
                                            <a class="btn btn-second" href="<?php echo base_url('inventory/inventorymngt'); ?>">Cancel</a>
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
<script src="https://salequick.com/new_assets/js/jquery.maskMoney.min.js" type="text/javascript"></script>
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

    // $("#price").inputFilter(function(value) {
    //     return /^-?\d*[.]?\d*$/.test(value);
    // });
    $("#quantity").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });
    $("#sold_qty_alert").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });

    $(document).ready(function() {
        $('#price').maskMoney();
        if($('#quantity_switch').is(':checked')) {
            $('#quantity').attr("disabled", false);
        } else {
            // $('#quantity').val('I');
            $('#quantity').attr("disabled", true);
        }
    });

    $(document).on('change', '#quantity_switch', function() {
        if($('#quantity_switch').is(':checked')) {
            console.log(1);
            var qty = $('#quantity').attr('data-qty');
            $('#quantity').val(qty);
            $('#quantity2').val(qty);
            
            $('#quantity').attr("disabled", false);
        } else {
            console.log(2);
            $('#quantity').val('∞');
            $('#quantity2').val('∞');
            $('#quantity').attr("disabled", true);
        }
    })

    $(document).on('keyup', '#quantity', function() {
        var qty = $('#quantity').val();
        $('#quantity2').val(qty);
    })
</script>

<?php include_once'footer_dash.php'; ?>