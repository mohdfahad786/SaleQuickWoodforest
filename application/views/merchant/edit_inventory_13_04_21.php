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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom"><?php echo ($meta)?></h4> -->
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto !important;">
                    <?php
                        echo form_open('Inventory/'.$loc, array('id' => "my_form",'class' => "row", 'enctype'=> "multipart/form-data"));
                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

                        // print_r($package_data[0]); 
                        $name=$package_data[0]['name'];
                        $tax=$package_data[0]['tax'];
                        $price=$package_data[0]['price'];
                        $sku=$package_data[0]['sku'];
                        $barcode_data=$package_data[0]['barcode_data'];
                        $quantity = ($package_data[0]['quantity'] == 'I') ? '∞' : $package_data[0]['quantity'];
                        $category_id=$package_data[0]['category_id'];
                        $item_id=$package_data[0]['item_id'];
                        $sold_qty_alert=$package_data[0]['sold_qty_alert'];

                        $mode=$package_data[0]['mode'];
                        $title=$package_data[0]['title'];
                    ?>
                    <!-- <form> -->
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-title"><?php echo ($meta)?></div>

                                            <!-- <div class="form-group">
                                                <label for="">Image</label>
                                                <input type="text" class="form-control" name="title" id="title"  placeholder="Title"  required value="<?php echo $package_data[0]['itemImage']; ?>">
                                            </div> -->

                                            <div class="form-group">
                                                <label for="">Image</label>
                                                <?php if(isset($package_data[0]['itemImage']) && $package_data[0]['itemImage']!=''){ ?>
                                                    <div class="logo_preview">
                                                        <img class="custom_logo_style" src="<?php echo $upload_loc.'/'.$package_data[0]['itemImage'] ;?>" alt="logo">
                                                        <span class="logo_close"><i class="fa fa-times"></i></span>
                                                    </div>
                                                    <div class="uploading_text d-none" style="text-align: center;">
                                                        <label class="text-success">Uploading Image...</label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="logo_preview">
                                                        <img class="custom_logo_style" src="<?php echo base_url('new_assets/img/no-logo.png') ;?>" alt="logo">
                                                    </div>
                                                    <div class="uploading_text d-none" style="text-align: center;">
                                                        <label class="text-success">Uploading Image...</label>
                                                    </div>
                                                <?php } ?>
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn image_btn">Browse Picture</button>
                                                    <input type="file" name="item_image" class="custom-file-input" id="item_image" value="<?php echo (isset($package_data[0]['itemImage']) && !empty($package_data[0]['itemImage'])) ? $package_data[0]['itemImage'] : ''; ?>">
                                                </div>
                                            </div>
                                        
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Product</label>
                                                        <?php if($mode==0) { ?> 
                                                            <input type="text" class="form-control" name="name" id="name"  placeholder="Name"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                                                        <?php } elseif ($mode==1 && $title=='regular') { ?>
                                                            <input type="text" class="form-control" name="name" id="name"  placeholder="Name"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                                                        <?php } else { ?>
                                                            <input type="text" class="form-control" name="name" id="name"  placeholder="Name"  required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
                                                        <?php } ?>

                                                        <input type="hidden" class="form-control" name="item_image_old" id="item_image_old" value="<?php echo $package_data[0]['itemImage']; ?>">

                                                        <input type="hidden" class="form-control" name="title" id="title" value="<?php echo $package_data[0]['title']; ?>">

                                                        <input type="hidden" class="form-control" name="mode" id="mode" value="<?php echo $package_data[0]['mode']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Product Category</label>
                                                        <select name="category_id" class="form-control" id="category_id">
                                                        <?php
                                                        foreach ($package_data_cat as $view) { ?>
                                                            <option  value="<?php echo $view['id']; ?>" <?php if($category_id==$view['id']) echo 'selected';  ?>><?php echo $view['name']; ?></option>
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Barcode</label>
                                                        <input type="text" class="form-control" name="barcode_data" id="barcode_data"  placeholder="Barcode" required value="<?php echo (isset($barcode_data) && !empty($barcode_data)) ? $barcode_data : set_value('barcode_data');?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Price</label>
                                                        <input type="text" class="form-control" name="price" id="price"  placeholder="Price"  required value="<?php echo (isset($price) && !empty($price)) ? $price : set_value('price');?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <!-- <input type="text" class="form-control" name="quantity" id="quantity"  placeholder="Quantity" required value="<?php echo (isset($quantity) && !empty($quantity)) ? $quantity : set_value('quantity');?>"> -->
                                                                <label for="">Quantity</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <label class="switch switch_type1" role="switch" style="margin-top: 8px !important;">
                                                                                <input type="checkbox" <?php if($quantity != 'I') echo 'checked'; ?> id="quantity_switch" class="switch__toggle">
                                                                                <span class="switch__label"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="quantity" data-qty="<?php echo (isset($quantity) && !empty($quantity)) ? $quantity : 0; ?>" id="quantity" placeholder="Qty" required value="<?php echo (isset($quantity) && !empty($quantity)) ? $quantity : 0; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Low Sold Qty</label>
                                                                <input type="text" class="form-control" name="sold_qty_alert" id="sold_qty_alert"  placeholder="Low Sold Qty" value="<?php echo (isset($sold_qty_alert) && !empty($sold_qty_alert)) ? $sold_qty_alert : set_value('sold_qty_alert');?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                            
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Tax %</label>
                                                                <select name="tax" class="form-control" id="tax">
                                                                    <option  value="0.00" >No Tax(0.00%)</option>
                                                                <?php
                                                                foreach ($package_data_tax as $view) { ?>
                                                                    <option  value="<?php echo $view['percentage']; ?>" <?php if($tax==$view['percentage']) echo 'selected';  ?>><?php echo $view['title'].'('.$view['percentage'].')'; ?></option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">SKU</label>
                                                                <input type="text" class="form-control" name="sku" id="sku"  placeholder="SKU" required value="<?php echo (isset($sku) && !empty($sku)) ? $sku : set_value('sku');?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                        <div class="col-6">
                                            <input type="hidden" id="item_id" name="item_id" value="<?php echo $item_id; ?>">
                                            <input type="submit" id="btn_login" name="submit" class="btn btn-first" value="<?php echo $action ?>" style="border-radius: 8px !important;width: 100%;" />
                                        </div>
                                        <div class="col-6">
                                            <a class="btn btn-second" href="<?php echo base_url('pos/inventorymngt'); ?>">Cancel</a>
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

    $("#price").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });
    $("#quantity").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });
    $("#sold_qty_alert").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });

    $(document).ready(function() {
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

    // Uploading Logo
    // $(document).on('change', '#item_image', function(){
    $('#item_image').change(function(){
        $('.uploading_text').removeClass('d-none');
        var base_url = "<?= base_url() ?>";
        var item_id = $('#item_id').val();
        var bct_id = $('input[name=bct_id]').val();

        var file_data = $('#item_image').prop('files')[0];   
        var form_data = new FormData();                  
        // console.log(form_data);return false;
        form_data.append('item_image', file_data);
        // form_data.append('item_id', item_id);
        form_data.append('bct_id', bct_id);

        $.ajax({
            url:"<?php echo base_url('inventory/update_item_image') ?>",
            type:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            // beforeSend:function(){
            //  $('.logo_preview').html("<label class='text-success' style='text-align:center;'>Image Uploading...</label>");
            // },   
            success:function(data) {
                var data = JSON.parse(data);
                // console.log(data);return false;
                if(data.status == 'success') {
                    $('.custom_logo_style').attr("src", base_url+"uploads/item_image/"+data.msg);
                    $('.logo_preview').html('<button class="logo_close"><i class="fa fa-times"></i></button>');
                    
                    $('.logo_preview').html('<img class="custom_logo_style" src="' + base_url + 'uploads/item_image/' + data.msg + '" alt="logo"><button class="logo_close"><i class="fa fa-times"></i></button>');
                    
                }
                $('.uploading_text').addClass('d-none');
            }
        });
    });

    $(document).on('click', '.logo_close', function() {
        var bct_id = $('input[name=bct_id]').val();
        // alert("<?php echo base_url('inventory/remove_category_image') ?>/"+bct_id);return false;
        var base_url = "<?= base_url() ?>";
        
        $.ajax({
            url: "<?php echo base_url('inventory/remove_category_image') ?>/"+bct_id,
            type: "POST",
            success: function(data) {
                if(data == '200') {
                    $('.logo_preview').html('<img class="custom_logo_style" src="' + base_url + 'new_assets/img/no-logo.png" alt="logo">');
                }
            }
        });
    })
</script>

<?php include_once'footer_dash.php'; ?>