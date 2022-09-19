<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
 
<style>
    .checkbox {
        height: 22px !important;
    }
    @media screen and (min-width: 1400px) {
        .permission_label {
            font-size: 14px !important;
        }
    }
    @media screen and (max-width: 1399px) {
        .permission_label {
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 1250px) {
        .permission_label {
            font-size: 10px !important;
        }
    }
    .start_stop_show_inv {
        max-width: 121px;
        margin: 0 auto;
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
                <div class="col-sm-6 col-md-12 col-lg-12">
                    <?php
                        echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=>"row"));
                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

                        if(isset($view_menu_permissions) && $view_menu_permissions!="") {
                            $view_menu_permissions_Array=explode(',',$view_menu_permissions); 
                        } else {
                            $view_menu_permissions_Array=array();
                        }
                    ?>
                    <!-- <form> -->
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-title">Employee Details</div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control"  <?php if($loc=='edit_employee')  {  echo 'readonly'; } ?> name="email" id="email" pattern="[ a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email"  value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">User Name</label>
                                                <input type="text" class="form-control" name="name" id="name"  placeholder="Name"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Phone number</label>
                                                <input type="text" class="form-control" name="mobile" id="phone" onkeypress="return isNumberKey(event)" placeholder="Mobile No" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Update Password</label>
                                                <?php if($loc=='edit_employee')  {?> 
                                                    <input type="hidden" class="form-control" name="password" id="password"  placeholder="Password"  required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password');?>">
                                                    <input type="password" class="form-control" name="cpsw" id="cpsw"  placeholder="Change Password">
                                                <?php } else if($loc=='add_employee') { ?>
                                                    <input type="text" class="form-control" name="password" id="password" placeholder="Password" required>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Employee Pin</label>
                                                <?php if($loc=='edit_employee') { ?>
                                                    <?php if(!empty($employee_pin)) { ?>
                                                        <input type="text" class="form-control" name="employee_pin" value="<?php echo $employee_pin;?>" readonly>
                                                        <input type="hidden" name="update_emp_pin" value="<?php echo $update_emp_pin; ?>">
                                                    <?php } else { ?>


                                                        <input type="hidden" name="update_emp_pin" value="<?php echo $update_emp_pin; ?>">
                                                    <?php } ?>
                                                <?php } else if($loc=='add_employee') { ?>
                                                    <input type="text" class="form-control" name="employee_pin" id="empPin" value="<?php echo $emp_pin;?>" readonly >
                                                <?php } ?>
                                            </div>
                                            <?php if($loc=='edit_employee') {?>
                                                <div class="form-group">
                                                    <label for="">Status</label>
                                                    <select class="form-control" name="status" id="status" required="">
                                                        <option value="active" <?php if($status=='active'){ echo 'selected'; } ?> > Active </option>
                                                        <option value="block" <?php if($status=='block'){ echo 'selected'; } ?> > Block </option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label for="" style="display: block !important;">Permission for Refund</label>
                                                <!-- <input type="text" class="form-control" name="emp_refund" id="emp_refund" value=""> -->
                                                <?php if($loc=='edit_employee') {?>
                                                    <span class="start_stop_show_inv " rel="238">
                                                        <label class="switch switch_type1" role="switch" style="z-index: 0 !important;">
                                                            <input type="checkbox" <?php echo ($emp_refund == 1) ? 'checked' : '' ?> id="emp_refund" name="emp_refund" class="switch__toggle" value="">
                                                            <span class="switch__label"></span>
                                                        </label>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="start_stop_show_inv " rel="238">
                                                        <label class="switch switch_type1" role="switch" style="z-index: 0 !important;">
                                                            <input type="checkbox" id="emp_refund" name="emp_refund" class="switch__toggle" value="">
                                                            <span class="switch__label"></span>
                                                        </label>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-12" style="display:none;">
                                            <div class="card content-card">
                                                <div class="card-detail">
                                                    <div class="row custom-form responsive-cols f-wrap f-auto">
                                                        <div class="col-12">
                                                            <div class="custom-form">
                                                                <div class="form-group">
                                                                    <p><b>Payment Type</b></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="ViewPermissions" <?php if ( isset($view_menu_permissions) && in_array("12a", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="ViewPermissions" value="12a">
                                                                    <label for="ViewPermissions">View Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="AddPermissions" <?php if ( isset($view_menu_permissions) && in_array("12b", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="AddPermissions" value="12b">
                                                                    <label for="AddPermissions">Add Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="EditPermissions" <?php if ( isset($view_menu_permissions) && in_array("12c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="EditPermissions" value="12c">
                                                                    <label for="EditPermissions">Edit Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="DeletePermissions" <?php if ( isset($view_menu_permissions) && in_array("12d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="DeletePermissions" value="12d">
                                                                    <label for="DeletePermissions">Delete Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-title">Menu Permission</div>
                                                    
                                            <div class="form-group">
                                                <label for="">Dashboard</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="Dashboard" <?php if ( isset($view_menu_permissions) && in_array("1a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Dashboard" value="1a" class="form-check-input"> Dashboard <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4" style="padding-right: 0px !important;">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TransactionSummary" <?php if ( isset($view_menu_permissions) && in_array("1b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TransactionSummary" value="1b" class="form-check-input"> Transaction Summary <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="SalesTrends" <?php if ( isset($view_menu_permissions) && in_array("1c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="SalesTrends" value="1c" class="form-check-input"> Sales Trends <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Transaction</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("2a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInstoreMobile" value="2a" class="form-check-input"> Instore &amp; Mobile <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TInvoice" <?php if ( isset($view_menu_permissions) && in_array("2b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInvoice" value="2b" class="form-check-input"> Invoicing <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TRecurring" <?php if ( isset($view_menu_permissions) && in_array("2c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="TRecurring" value="2c" class="form-check-input"> Recurring <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Invoice/Virtual Terminal</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="VirtualTerminal"  <?php if ( isset($view_menu_permissions) && in_array("3a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="VirtualTerminal" value="3a" class="form-check-input"> Virtual Terminal <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="IInvoicing" <?php if ( isset($view_menu_permissions) && in_array("3b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="IInvoicing" value="3b" class="form-check-input"> Invoicing <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="IRecurring" <?php if ( isset($view_menu_permissions) && in_array("3c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="IRecurring" value="3c" class="form-check-input"> Recurring <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <label for="">Refund</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="RInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("4a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RInstoreMobile" value="4a" class="form-check-input"> Instore & Mobile <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="RInvoice" <?php if ( isset($view_menu_permissions) && in_array("4b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RInvoice" value="4b" class="form-check-input"> Invoice <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Inventory</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="ItemsManagement" <?php if ( isset($view_menu_permissions) && in_array("4c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ItemsManagement" value="4c" class="form-check-input"> Items Management <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="Reports" <?php if ( isset($view_menu_permissions) && in_array("4d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="Reports" value="4d" class="form-check-input"> Reports <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <label for="">Settings</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" checked="" <?php if ( isset($view_menu_permissions) && in_array("6", $view_menu_permissions_Array)) { echo 'checked'; }?>  name="Settings" id="Settings" value="6" class="form-check-input"> Settings <i class="input-frame"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                                <div class="col-12 text-right">
                                                    <input type="submit" id="btn_login" name="submit" class="btn btn-first" value="<?php echo $action ?>" style="border-radius: 8px !important;" />
                                                </div>
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
    </div>
</div>

<?php include_once'footer_dash.php'; ?>