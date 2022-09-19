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
        margin-top: 5px;
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
    .custom_logo_style_blank {
        border: 3px solid #ddd;
        border-style: dotted;
        border-radius: 10px;
        padding: 20px;
        /*max-height: 110px;*/
        width: 140px;
        height: 120px;
    }
    .variant_section_rows {
        border: 2px solid rgba(210, 223, 245);
        border-radius: 10px;
        padding: 10px;
    }
    .btn_save {
        background-color: #868e96 !important;
        color: #fff !important;
        border: 1px solid #868e96 !important;
    }
    .btn_save:hover {
        background-color: #fff !important;
        color: #868e96 !important;
    }
    .btn_delete {
        background-color: #dc3545 !important;
        color: #fff !important;
        border: 1px solid #dc3545 !important;
    }
    .btn_delete:hover {
        background-color: #fff !important;
        color: #dc3545 !important;
    }
    .show_variant_rows {
        border: 2px solid rgba(210, 223, 245);
        border-radius: 10px;
        padding: 5px;
        margin: 0px 0px 10px 0px !important;
    }
    .show_variant_rows label {
        margin-bottom: 0px !important;
    }
    .add_row {
        border: 1px solid rgba(210, 223, 245);
        padding: 10px;
        margin: 10px 0px 0px 0px !important;
    }
    .add_row label {
        margin-bottom: 0px !important;
        cursor: pointer;
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
                    <?php echo form_open('Inventory/'.$loc, array('id' => "my_form",'class' => "row", 'enctype'=> "multipart/form-data")); ?>

                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-title"><?php echo ($meta)?></div>

                                            <div class="form-group">
                                                <label for="">Image</label>
                                                <div class="logo_preview">
                                                    <img class="custom_logo_style_blank" src="<?php echo base_url('new_assets/img/plus-2.png') ;?>" alt="logo">
                                                </div>
                                                <div class="uploading_text d-none" style="text-align: center;">
                                                    <label class="text-success">Uploading Image...</label>
                                                </div>

                                                <div class="upload-btn-wrapper">
                                                    <button class="btn image_btn">Browse Picture</button>
                                                    <input type="file" name="item_image" class="custom-file-input" id="item_image" value="" required>
                                                </div>
                                            </div>
                                        
                                            <div class="row mb-2">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <span class="custom-checkbox">
                                                        <input type="radio" id="single_mode" class="radio-circle mode" checked value="0" name="mode">
                                                        <label for="single" class="inline-block">Single Product</label>
                                                    </span>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <span class="custom-checkbox">
                                                        <input type="radio" id="multi_mode" class="radio-circle mode" value="1" name="mode">
                                                        <label for="multi" class="inline-block">Product Variation</label>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="single_mode_section">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Product</label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Product Category</label>
                                                            <select name="category_id" class="form-control" id="category_id" required>
                                                            <?php foreach ($package_data_cat as $view) { ?>
                                                                <option  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Barcode</label>
                                                            <input type="text" class="form-control" name="barcode_data" id="barcode_data"  placeholder="Barcode" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="">Price</label>
                                                            <div class="input-group" style="border: none !important;">
                                                                <div class="input-group-addon" style="border-right: none !important;background-color: #fff !important;">
                                                                    <span class="input-group-text" style="font-size: 15px !important;">$</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="price" id="price" placeholder="0.00" onKeyPress="return isNumberKey(event)" autocomplete="off" value="0.00" style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">
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
                                                                                    <input type="checkbox" id="quantity_switch" class="switch__toggle">
                                                                                    <span class="switch__label"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" name="quantity" data-qty="0" id="quantity" placeholder="Qty" required value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="">Low Sold Qty</label>
                                                                    <input type="text" class="form-control" name="sold_qty_alert" id="sold_qty_alert" placeholder="Low Sold Qty" value="">
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="">Tax %</label>
                                                                    <select name="tax" class="form-control" id="tax" required>
                                                                        <option  value="0.00" >No Tax(0.00%)</option>
                                                                    <?php
                                                                    foreach ($package_data_tax as $view) { ?>
                                                                        <option  value="<?php echo $view['percentage']; ?>"><?php echo $view['title'].'('.$view['percentage'].')'; ?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="">SKU</label>
                                                                    <input type="text" class="form-control" name="sku" id="sku"  placeholder="SKU" required value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="multi_mode_section"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-6">
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
        
        // $('#price').val('0.00');
    //    $('#price').mask('000000000.00', { reverse: true });
        if($('#quantity_switch').is(':checked')) {
            $('#quantity').attr("disabled", false);
        } else {
            // $('#quantity').val('I');
            $('#quantity').attr("disabled", true);
        }
    });

    // $(document).on('change', '#item_image', function(){
    //     var input = this;
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function(e) {
    //         $('.custom_logo_style').attr('src', e.target.result);
    //         }
    //         reader.readAsDataURL(input.files[0]); // convert to base64 string
    //     }
    // });

    var category_html = '';
    var tax_html = '';
    var package_data_cat = <?php echo json_encode($package_data_cat); ?>;
    var package_data_tax = <?php echo json_encode($package_data_tax); ?>;

    // package_data_cat.each(function (index, el) {
    $.each(package_data_cat, function(key, val){
        category_html += '<option value="' + val.id + '">' + val.name + '</option>';
        // console.log(val);
    });
    // console.log(category_html);

    $.each(package_data_tax, function(key, val){
        tax_html += '<option value="' + val.percentage + '">'+val.title+ '('+val.percentage+')' +'</option>';
        // console.log(val);
    });
    // console.log(tax_html);return false;

    $(document).on('click', '.mode', function() {
        // console.log('111');
        if($('#single_mode').is(':checked')) {
            $('#single_mode').prop( "checked", true );
            $('#multi_mode').prop( "checked", false );
            // console.log('1');return false;
            $('.single_mode_section').removeClass('d-none');
            $('.multi_mode_section').addClass('d-none');

            $('.single_mode_section').html('');
            $('.multi_mode_section').html('');
            $('.single_mode_section').html('<div class="row"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Product</label><input type="text" class="form-control" name="name" id="name" placeholder="Name" required value=""></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Product Category</label><select name="category_id" class="form-control" id="category_id" required>'+category_html+'</select></div></div></div><div class="row"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Barcode</label><input type="text" class="form-control" name="barcode_data" id="barcode_data" placeholder="Barcode" value=""></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Price</label><div class="input-group" style="border: none !important;"><div class="input-group-addon" style="border-right: none !important;background-color: #fff !important;"><span class="input-group-text" style="font-size: 15px !important;">$</span></div><input type="text" class="form-control" name="price" id="price" placeholder="Price" onKeyPress="return isNumberKey(event)" autocomplete="off" value="0.00" style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;"></div></div></div></div><div class="row"><div class="col-sm-6 col-md-6 col-lg-6"><div class="row"><div class="col-6"><div class="form-group"><label for="">Quantity</label><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><label class="switch switch_type1" role="switch" style="margin-top: 8px !important;"><input type="checkbox" id="quantity_switch" class="switch__toggle"><span class="switch__label"></span></label></div></div><input type="text" class="form-control" name="quantity" data-qty="0" id="quantity" placeholder="Qty" required value="" disabled></div></div></div><div class="col-6"><div class="form-group"><label for="">Low Sold Qty</label><input type="text" class="form-control" name="sold_qty_alert" id="sold_qty_alert" placeholder="Low Sold Qty" value=""></div></div></div>  </div><div class="col-sm-6 col-md-6 col-lg-6"><div class="row"><div class="col-6"><div class="form-group"><label for="">Tax %</label><select name="tax" class="form-control" id="tax" required><option value="0.00" >No Tax(0.00%)</option>'+tax_html+'</select></div></div><div class="col-6"><div class="form-group"><label for="">SKU</label><input type="text" class="form-control" name="sku" id="sku" placeholder="SKU" required value=""></div></div></div></div></div>');

                $('#price').maskMoney();

        } else if($('#multi_mode').is(':checked')) {
            $('#multi_mode').prop( "checked", true );
            $('#single_mode').prop( "checked", false );
            // console.log('2');return false;
            $('.multi_mode_section').removeClass('d-none');
            $('.single_mode_section').addClass('d-none');

            
            $('.single_mode_section').html('');
            $('.multi_mode_section').html('');
            $('.multi_mode_section').html('<div class="multi_under_section"><div class="row"><div class="col-12"><div class="form-group"><label for="">Product</label><input type="text" class="form-control" name="name" id="name" placeholder="Name" required value=""></div></div></div><div class="row"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Product Category</label><select name="category_id" class="form-control" id="category_id" required>'+category_html+'</select></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Tax %</label><select name="tax" class="form-control" id="tax" required><option value="0.00">No Tax(0.00%)</option>'+tax_html+'</select></div></div></div><div class="show_variant"></div><div class="variant_section"><div class="variant_section_rows"><div class="row row_one"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Variant Name*</label><input type="text" class="form-control" name="var_name[]" id="var_name" placeholder="Variant Name" value=""></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Price*</label><div class="input-group" style="border: none !important;"><div class="input-group-addon" style="border-right: none !important;background-color: #fff !important;"><span class="input-group-text" style="font-size: 15px !important;">$</span></div><input type="text" class="form-control" name="price[]" id="price" placeholder="Price" onKeyPress="return isNumberKey(event)" autocomplete="off" value="0.00" style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;"></div></div></div></div><div class="row row_two"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Quantity</label><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><label class="switch switch_type1" role="switch" style="margin-top: 8px !important;"><input type="checkbox" class="switch__toggle quantity_switch1"><span class="switch__label"></span></label></div></div><input type="text" class="form-control" name="quantity[]" data-qty="0" id="quantity" placeholder="Qty" value="∞"></div></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">SKU*</label><input type="text" class="form-control" name="sku[]" id="sku" placeholder="SKU" value=""></div></div></div><div class="row mt-2"><div class="col-sm-6 col-md-8 col-lg-6"><div class="row"><div class="col-6"><button type="button" class="btn_save btn btn-sm btn-secondary"><i class="fa fa-save"></i> Save</button></div><div class="col-6"><button type="button" class="btn_delete btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></div></div></div></div></div></div><div class="row add_row"><div class="col-12"><label><i class="fa fa-plus"></i> Have product variants? Add now</label></div></div></div>');

                $('#price').maskMoney();
        }
    })
    var x=1;
    $(document).on('click', '.add_row', function() {
        $('.variant_section').append('<div class="variant_section_rows"><div class="row row_one"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Variant Name*</label><input type="text" class="form-control" name="var_name[]" id="var_name" placeholder="Variant Name" value=""></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Price*</label><div class="input-group" style="border: none !important;"><div class="input-group-addon" style="border-right: none !important;background-color: #fff !important;"><span class="input-group-text" style="font-size: 15px !important;">$</span></div><input type="text" class="form-control" name="price[]" id="price'+x+'" placeholder="Price" onKeyPress="return isNumberKey(event)" autocomplete="off" value="0.00" style="border-left: none !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;"></div></div></div></div><div class="row row_two"><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">Quantity</label><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><label class="switch switch_type1" role="switch" style="margin-top: 8px !important;"><input type="checkbox" class="switch__toggle quantity_switch1"><span class="switch__label"></span></label></div></div><input class="form-control" name="quantity[]" data-qty="0" id="quantity" placeholder="Qty" value="∞"></div></div></div><div class="col-sm-6 col-md-6 col-lg-6"><div class="form-group"><label for="">SKU*</label><input type="text" class="form-control" name="sku[]" id="sku" placeholder="SKU" value=""></div></div></div><div class="row mt-2"><div class="col-sm-6 col-md-8 col-lg-6"><div class="row"><div class="col-6"><button type="button" class="btn_save btn btn-sm btn-secondary"><i class="fa fa-save"></i> Save</button></div><div class="col-6"><button type="button" class="btn_delete btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></div></div></div></div></div>');

            $('#price'+x).maskMoney();
            x++;
    })

    $(document).on('change', '#quantity_switch', function() {
        if($('#quantity_switch').is(':checked')) {
            var qty = $('#quantity').attr('data-qty');
            $('#quantity').val(qty);
            
            $('#quantity').attr("disabled", false);
        } else {
            $('#quantity').val('∞');
            $('#quantity').attr("disabled", true);
        }
    })

    $(document).on('change', '.quantity_switch1', function() {
        var $this = $(this);
        var wrapper = $this.closest("div.variant_section_rows");
        var quantity_switch = wrapper.find('input.quantity_switch1');
        if(quantity_switch.is(':checked')) {
            // console.log(quantity_switch.closest('.input-group').find('#quantity'));return false;
            var qty_input = quantity_switch.closest('.input-group').find('#quantity');
            var qty = qty_input.attr('data-qty');
            qty_input.val(qty);
            
            // qty_input.attr("disabled", false);
        } else {
            // console.log('call2');return false;
            var qty_input = quantity_switch.closest('.input-group').find('#quantity');
            qty_input.val('∞');
            // qty_input.attr("disabled", true);
        }
    })

    $(document).on('click', '.btn_save', function() {
        var $this = $(this);
        var wrapper = $this.closest("div.variant_section_rows");
        // console.log($this.closest("div.variant_section_rows"));
        var vrt_name = wrapper.find('input#var_name').val();
        var vrt_price = wrapper.find('input#price').val();
        var vrt_sku = wrapper.find('input#sku').val();
        var vrt_qty = wrapper.find('input#quantity').val();

        if ( (vrt_name == '') || (vrt_price == '') ) {
            alert('Please fill Variant Name and Price fields');return false;
        }

        var price_ptrn = /^\d{0,4}(\.\d{0,2})?$/;
        if (!price_ptrn.test(vrt_price)) {
            alert('Please enter price correct decimal value');return false;
        }

        wrapper.addClass('d-none');
        $('.show_variant').append('<div class="row show_variant_rows"><div class="col-12"><div class="row"><div class="col-6"><label>'+vrt_name+'</label></div><div class="col-6 text-right"><label>$'+vrt_price+'</label></div></div><div class="row"><div class="col-6"><label>'+vrt_qty+'</label></div><div class="col-6 text-right"><label>'+vrt_sku+'</label></div></div></div></div>');
    })

    $(document).on('click', '.btn_delete', function() {
        $(this).closest("div.variant_section_rows").remove();
    })

    $(document).on('click', '#btn_login', function() {
        if($('#multi_mode').is(':checked')) {
            var input_find = $('.variant_section').find('input[type="text"]');
            $(input_find).each(function() {
                if ( $(this) == '' ) {
                    alert('Please fill all required fields');return false;
                }
                // console.log($(this));
            });
        }
    })

    $("#item_image").change(function(){
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
                $('.logo_preview').html('<img class="custom_logo_style" src="'+ e.target.result +'" alt="logo">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    });

    // Uploading Logo
    // $(document).on('change', '#item_image', function(){
    // $('#item_image').change(function(){
    //     $('.uploading_text').removeClass('d-none');
    //     var base_url = "<?= base_url() ?>";
    //     var item_id = $('#item_id').val();
    //     var bct_id = $('input[name=bct_id]').val();

    //     var file_data = $('#item_image').prop('files')[0];   
    //     var form_data = new FormData();                  
    //     // console.log(form_data);return false;
    //     form_data.append('item_image', file_data);
    //     // form_data.append('item_id', item_id);
    //     form_data.append('bct_id', bct_id);

    //     $.ajax({
    //         url:"<?php echo base_url('inventory/update_item_image') ?>",
    //         type:"POST",
    //         data: form_data,
    //         contentType: false,
    //         cache: false,
    //         processData: false,

    //         success:function(data) {
    //             var data = JSON.parse(data);
    //             // console.log(data);return false;
    //             if(data.status == 'success') {
    //                 $('.custom_logo_style').attr("src", base_url+"uploads/item_image/"+data.msg);
    //                 $('.logo_preview').html('<button class="logo_close"><i class="fa fa-times"></i></button>');
                    
    //                 $('.logo_preview').html('<img class="custom_logo_style" src="' + base_url + 'uploads/item_image/' + data.msg + '" alt="logo">');
    //             }
    //             $('.uploading_text').addClass('d-none');
    //         }
    //     });
    // });
</script>

<?php include_once'footer_dash.php'; ?>