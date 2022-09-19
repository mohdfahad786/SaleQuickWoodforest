<?php if (empty($this->session->userdata('merchant_name'))) {
    header('Location:  '.  'https://salequick.com/login');
}

if($this->session->userdata('merchant_user_type')=='employee') {
    if(!empty($this->session->userdata('employee_id')) && !empty($this->session->userdata('employee_id'))) {
        if($this->session->userdata('view_menu_permissions')){
            $menuarraydata=explode(',',$this->session->userdata('view_menu_permissions'));
            print_r($menuarraydata);
        } else {
            $menuarraydata=array();
        }

    } else {
        $menuofemployee="";
        $menuarraydata=array();
    }
} ?>

<style>
    .img-lg-custom-text-light {
        max-height: 100px;
        max-width: 100px;
        width: auto;
        height: auto;
        font-size: 50px;
        color: #fff;
        font-family: Roboto-Thin !important;
        /* border: 2px solid rgb(148, 148, 146); */
        padding: 3px 25px;
        border-radius: 50%;
        background-color: rgb(0, 166, 255);
    }
    .img-lg-custom {
        padding: 20px !important;
    }
</style>

<!-- Left Sidebar menu -->
<div class="sidebar" style="overflow: auto !important;">
    <div class="user-profile">
        <div class="display-avatar sidebar_logo_preview">
            <?php if($this->session->userdata('merchant_logo') ) { ?>
                <img class="img-lg-custom" src="<?php echo base_url()."logo/".$this->session->userdata('merchant_logo'); ?>" alt="profile image">
            <?php } else { ?>
                <div class="img-lg-custom-text-light">
                    <!--<?php echo substr($this->session->userdata('merchant_name'),0,1); ?>-->
                    <?php echo !empty($this->session->userdata('business_dba_name')) ? strtoupper(substr($this->session->userdata('business_dba_name'),0,1)) : strtoupper(substr($this->session->userdata('merchant_name'),0,1)); ?>
                </div>
                <!--<img class="img-lg-custom" src="<?php echo base_url('new_assets/img/no-logo.png'); ?>" alt="profile image">-->
            <?php } ?>
        </div>
        <div class="info-wrapper">
            <p class="user-name"><?php echo $this->session->userdata('business_dba_name');?></p>
            <p class="ml-2 text-muted" style="font-family: Avenir-Heavy !important;"><?php echo ucfirst($this->session->userdata('merchant_user_type'));?></p>
        </div>
    </div>
    <ul class="navigation-menu">
        <?php if($this->session->userdata('merchant_status')!='active') { ?>
            <li>
                <a class="<?php echo ($this->session->userdata('merchant_status')=='Waiting_For_Approval')?'highliter':''?>" href="<?php echo base_url('merchant/after_signup'); ?>">
                    <span>
                        <img src="<?php echo base_url('new_assets/img/accM1.png'); ?>">
                        <img class="c-icon" src="<?php echo base_url('new_assets/img/accM0.png'); ?>">
                        <span>Activate Account</span>
                    </span>
                </a>
            </li>
        <?php } ?>

        <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1a", $menuarraydata) ||  in_array("1b", $menuarraydata) ||  in_array("1c", $menuarraydata) )  ) { ?>
            <li>
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false">
                  <span class="link-title">Dashboard</span>
                  <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/dashboard-icon.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="dashboard">
                    <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1a", $menuarraydata)  )  ) { ?>
                        <li>
                            <a href="<?php echo base_url('merchant'); ?>">Dashboard</a>
                        </li>
                    <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1b", $menuarraydata)  )  ) { ?>
                        <li>
                            <a href="<?php echo base_url('graph/sale'); ?>">Transaction Summary</a>
                        </li>
                    <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1c", $menuarraydata)  )  ) { ?>
                        <li>
                            <a href="<?php echo base_url('graph/trends'); ?>">Sales Trends</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("3a", $menuarraydata)  ) ) { ?>
            <li>
                <a href="<?php echo base_url('pos/add_pos'); ?>">
                    <span class="link-title">Virtual Terminal</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/pos-icon.png'); ?>" alt="sidebar-icon">
                </a>
            </li>
        <?php } ?>

        <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("3b", $menuarraydata)  ) ) { ?>
            <li>
                <a href="<?php echo base_url('merchant/add_straight_request'); ?>">
                    <span class="link-title">Invoicing</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/invoicing.png'); ?>" alt="sidebar-icon">
                </a>
            </li>
        <?php } ?>

        <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("3c", $menuarraydata)  )  ) { ?>
            <li>
                <a href="<?php echo base_url('merchant/add_customer_request'); ?>">
                    <span class="link-title">Recurring</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/recurring-icon.png'); ?>" alt="sidebar-icon">
                </a>
            </li>
        <?php } ?>

        <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
            <li>
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false">
                  <span class="link-title">Dashboard</span>
                  <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/dashboard-icon.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="dashboard">
                    <li>
                        <a href="<?php echo base_url('merchant'); ?>">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('graph/sale'); ?>">Transaction Summary</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('graph/trends'); ?>">Sales Trends</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?php echo base_url('pos/add_pos'); ?>">
                    <span class="link-title">Virtual Terminal</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/pos-icon.png'); ?>" alt="sidebar-icon">
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('merchant/add_straight_request'); ?>">
                    <span class="link-title">Invoicing</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/invoicing.png'); ?>" alt="sidebar-icon">
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('merchant/add_customer_request'); ?>">
                    <span class="link-title">Recurring</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/recurring-icon.png'); ?>" alt="sidebar-icon">
                </a>
            </li>
        <?php } ?>

        <li>
            <a href="#transactions" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Transactions</span>
              <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/transaction-icon.png'); ?>" alt="sidebar-icon">
            </a>
            <ul class="collapse navigation-submenu" id="transactions">
                <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("2a", $menuarraydata)  )  ) { ?>
                    <li>
                        <a href="<?php echo base_url('pos/all_pos'); ?>">Instore & Mobile</a>
                    </li>
                <?php } if($this->session->userdata('merchant_user_type')=='merchant') { ?>
                    <li>
                        <a href="<?php echo base_url('pos/all_pos'); ?>">Instore & Mobile</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('pos/all_customer_request'); ?>">Invoicing</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('pos/all_customer_request_recurring'); ?>">Recurring Invoice</a>
                    </li>
                <?php } ?>
                <!-- <?php if($this->session->userdata('register_type')=='api') { ?>
                    <li>
                        <a href="<?php echo base_url('sandbox/all_sandbox_payment'); ?>">Sandbox Payment</a>
                    </li>
                <?php } ?> -->
            </ul>
        </li>

        <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("4c", $menuarraydata) ||  in_array("4d", $menuarraydata)  )  ) { ?>
            <li>
                <a href="#inventory" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Inventory</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/inventory.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="inventory">
                    <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("4c", $menuarraydata)  )  ) { ?>
                        <li>
                            <a href="<?php echo base_url('pos/inventorymngt'); ?>">Inventory Management</a>
                        </li>
                    <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("4d", $menuarraydata)  )  ) { ?>
                        <li>
                            <a href="<?php echo base_url('pos/inventoryreport'); ?>">Reports</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
            <li>
                <a href="#inventory" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Inventory</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/inventory.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="inventory">
                    <li>
                        <a href="<?php echo base_url('pos/inventorymngt'); ?>">Inventory Management</a>
                    </li>
                    <?php if($this->session->userdata('merchant_id') == '413') { ?>
                    <li>
                        <a href="<?php echo base_url('inventory/all_category'); ?>">Category</a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('pos/inventoryreport'); ?>">Reports</a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <li>
            <a href="#profile_settings" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Account Settings</span>
                <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/profile-setting.png'); ?>" alt="sidebar-icon">
            </a>
            <ul class="collapse navigation-submenu" id="profile_settings">
                <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
                    <li>
                        <a href="<?php echo base_url('merchant/general_settings'); ?>">General</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('merchant/invoice_settings'); ?>">Invoice & Receipt</a>
                    </li>

                    <!-- <li>
                        <a href="<?php echo base_url('merchant/edit_business_info'); ?>">Business Info</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('merchant/edit_report_notification'); ?>">Report Notification</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('merchant/edit_permissions'); ?>">Permissions</a>
                    </li> -->
                <?php } ?>
                <!-- <li>
                    <a href="<?php echo base_url('merchant/change_password'); ?>">Change Password</a>
                </li> -->
                <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
                    <li>
                        <a href="<?php echo base_url('merchant/payment_mode'); ?>">Payment Types</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('merchant/tax_list'); ?>">Tax</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('charges/charge_list'); ?>">Other Charges</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('merchant/all_employee'); ?>">Employee</a>
                    </li>
                    <?php if($this->session->userdata('merchant_status')=='active') { ?>
                    
                    <li>
                        <a href="<?php echo base_url('quickbook'); ?>">QuickBook Connect</a>
                    </li>
                    <?php } ?>
                    <!-- <li>
                        <a href="<?php echo base_url('merchant/all_user'); ?>">User</a>
                    </li> -->
                <?php } ?>
                <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
                    <!-- <li>
                        <a href="<?php echo base_url('api/invoice'); ?>">API Detail</a>
                    </li> -->
                    
                <?php  } ?>
                <li>
                    <a href="<?php echo base_url('logout/merchant'); ?>">Logout </a>
                </li>
            </ul>
        </li>

        <!-- <li>
            <a href="#settings" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Settings</span>
                <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/setting-icon.png'); ?>" alt="sidebar-icon">
            </a>
            <ul class="collapse navigation-submenu" id="settings">
                
            </ul>
        </li> -->
        
        <li class="sidebar-foot-div">
            <hr class="sidebar-foot-hr">
            <small class="sidebar-foot-sm d-block">Powered By</small>
            <small class="sidebar-foot-md">Milstead Technologies, LLC</small>
        </li>
    </ul>
</div>