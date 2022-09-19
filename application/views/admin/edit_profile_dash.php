<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
    .profile_logo_wrapper {
        max-width: 250px;
        margin: auto;
    }
    .edit-profile .profile-icon-outer .profile-icon {
        border-radius: 10px !important;
    }
    .edit-profile .profile-icon-outer {
        max-width: 150px !important;
    }
    .edit-profile .profile-icon-outer .profile-icon>img {
        object-fit: fill !important;
    }
    label {
        font-weight: 600;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: block !important;
        width: 150px;
        margin: auto;
        margin-top: 5px;
    }
    .image_btn {
        background: rgb(0, 166, 255) !important;
        color: #fff !important;
        width: 150px !important;
        height: 36px !important;
        text-transform: none !important;
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
        /*width: 240px;*/
        width: auto;
    }
    .logo_preview {
        text-align: center;
        margin-top: 5px;
        position: relative;
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
    .form-group {
        margin-bottom: 20px !important;
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
                echo form_open_multipart('profile/'.$loc, array('id' => "my_form",'autocomplete' => "off"));
                echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
            ?>
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-title">Edit Info</div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <!-- <div class="form-group profile_logo_wrapper"> -->
                                        <div class="form-group">
                                            <label for="">Logo</label>
                                            <!-- <div class="profile-updater">
                                                <div class="profile-icon-outer">
                                                    <div class="profile-icon">
                                                        <?php if($mypic!='') { ?>
                                                            <img src="<?php echo $upload_loc.'/'.$mypic; ?>" alt="user"/>
                                                        <?php } else { ?>
                                                            <img src="https://salequick.com/logo/no-logo.png" alt="user">
                                                        <?php }?>
                                                    </div> 
                                                </div>
                                                <div class="upload-btn btn">
                                                    <span>Upload</span>
                                                    <span><i class="fa fa-camera"></i></span>
                                                </div>
                                                <input type="file" style="height: auto;" class="form-control" name="mypic" id="saleQuickPfIcon"  placeholder="Editor Image:" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
                                            </div> -->

                                            <?php if($mypic!='') { ?>
                                                <div class="logo_preview">
                                                    <img class="custom_logo_style" src="<?php echo $upload_loc.'/'.$mypic; ?>" alt="user">
                                                </div>
                                            <?php } else { ?>
                                                <div class="logo_preview">
                                                    <img class="custom_logo_style_blank" src="<?php echo base_url('new_assets/img/plus-2.png'); ?>" alt="logo">
                                                </div>
                                            <?php } ?>
                                            <div class="upload-btn-wrapper">
                                                <button class="btn image_btn">Browse Picture</button>
                                                <!-- <input type="file" name="image" class="custom-file-input" id="image" value="<?php echo (isset($image) && !empty($image)) ? $image : set_value('image');?>"> -->
                                                <input type="file" style="height: auto;" class="form-control" name="mypic" id="image" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">User Name</label>
                                            <input type="text" class="form-control" name="title" id="title" value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input type="text" class="form-control" name="url" id="url" value="<?php echo (isset($url) && !empty($url)) ? $url : set_value('url');?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone</label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="<?= $phone; ?>" placeholder="Phone" autocomplete="off" required>
                                        </div>
                                        <div class="form-group" style="margin-top: -10px !important;">
                                            <label for=""></label>
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="reset_password" value="0" id="reset_password" style="width: 17px !important; height: 17px !important;">
                                                <label for="reset_password">Want to change password?</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Enter Password</label>
                                            <input type="password" class="form-control" name="cpsw" id="cpsw" autocomplete="off" placeholder="Password">
                                            <input type="hidden" class="form-control" name="psw" id="psw" value="<?php echo $psw ? $psw : set_value('psw');?>" minlength="8">
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

<?php include_once'footer_dash.php'; ?>

<script>
    $(document).ready(function() {
        $('input[name=old_pswd]').val('');
    })

    $(document).on('change', '#image', function(){
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // $('.custom_logo_style').attr('src', e.target.result);
                var upImage = e.target.result;
                $('.logo_preview').html('<img class="custom_logo_style" src="' + upImage + '" alt="user">');
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    });

    $(document).on('click', '#reset_password', function() {
        if ($(this).prop("checked")) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    })
</script>