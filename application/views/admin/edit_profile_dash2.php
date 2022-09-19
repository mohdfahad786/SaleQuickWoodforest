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
                                        <div class="form-group profile_logo_wrapper">
                                            <label for="">Logo</label>
                                            <div class="profile-updater">
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
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">User Name</label>
                                            <input type="text" class="form-control" name="title" id="title" required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input type="text" class="form-control" name="url" id="url" required value="<?php echo (isset($url) && !empty($url)) ? $url : set_value('url');?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Change Password</label>
                                            <input type="password" class="form-control" name="cpsw" id="cpsw">
                                            <input type="hidden" class="form-control" name="psw" id="psw" value="<?php echo $psw ? $psw : set_value('psw');?>">
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.profile-updater  .profile-icon img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document)
    .on('change','#saleQuickPfIcon',function(e){
        console.log($(this).val())
        readURL(this);
    })
    .on('click','.upload-btn',function(e) {
        $('#saleQuickPfIcon').trigger('click');
    })
</script>