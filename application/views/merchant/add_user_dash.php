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
                <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto !important;">
                    <?php
                        echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=> 'row custom-form'));
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
                                                <label for="">Email </label>
                                                <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email Id" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Phone number</label>
                                                <input type="text" class="form-control" name="mobile" id="mobile" pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">User Name</label>
                                                <input type="text" class="form-control" name="name" id="name"  placeholder="User Name"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Domain Name</label>
                                                <input type="text" class="form-control" name="domain_name" id="domain_name"  placeholder="Domain Name"  required value="<?php echo (isset($domain_name) && !empty($domain_name)) ? $domain_name : set_value('domain_name');?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <input type="text" class="form-control" name="address" id="address"  placeholder="Address" required value="<?php echo (isset($address) && !empty($address)) ? $address : set_value('$address');?>">
                                            </div>
                                            <?php if($loc == 'edit_user') {?>
                                                <div class="form-group">
                                                    <label for="">Auth Key</label>
                                                    <input type="text" class="form-control" name="auth_key" id="auth_key"  placeholder="Auth Key" required value="<?php echo (isset($auth_key) && !empty($auth_key)) ? $auth_key : set_value('auth_key');?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Status</label>
                                                    <select class="form-control"  name="status" id="status" required="">
                                                        <option value="active" <?php if($status=='active'){ echo 'selected'; } ?> > Active </option>
                                                        <option value="block" <?php if($status=='block'){ echo 'selected'; } ?> > Block </option>
                                                    </select>
                                                </div>
                                            <?php } ?>
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