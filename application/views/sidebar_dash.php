<?php 
$url =  base_url('');
if( $this->session->userdata('subadmin_user_type') != 'agent') {
    header('Location:  '.  $url);
}

if( $this->session->userdata('subadmin_user_type') == 'agent') {
    if (!empty($this->session->userdata('subadmin_id')) &&  !empty($this->session->userdata('subadmin_id')) ) {
        if($this->session->userdata('subadmin_view_menu_permissions')){
            $menuarraydata=explode(',',$this->session->userdata('subadmin_view_menu_permissions'));
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
</style>

<!-- Left Sidebar menu -->
<div class="sidebar">
    <div class="sb-body" style="overflow: auto !important;">
        <div class="user-profile">
            <div class="display-avatar sidebar_logo_preview">
                <img class="img-lg-custom" src="<?php echo base_url('new_assets'); ?>/img/user.svg" alt="profile image">
            </div>
            <div class="info-wrapper">
                <p class="user-name">Reseller Panel</p>
            </div>
        </div>

        <ul class="navigation-menu">
            <li>
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Dashboard</span>
                    <img class="img-ss mb-1 mr-2" src="https://salequick.com/new_assets/img/new-icons/dashboard-icon.png" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="dashboard">
                    <li><a href="<?=base_url('agent/dashboard')?>">Dashboard</a></li>
                    <li><a href="<?=base_url('agent/report')?>">Residual</a></li>
                </ul>
            </li>

            <li>
                <a href="#merchant_master" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Merchant Master</span>
                    <img class="img-ss mb-1 mr-2" src="https://salequick.com/new_assets/img/new-icons/pos-icon.png" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="merchant_master">
                    <li><a href="<?=base_url('agent/all_merchant')?>">All Merchant </a> </li>
                    <!--  <li><a href="<?=base_url('agent/all_active_merchant')?>">Active  Merchant </a> </li>
                    <li><a href="<?=base_url('agent/mute_merchant')?>">Mute  Merchant </a> </li>
                    <li><a href="<?=base_url('agent/canceled_merchant')?>">Canceled  Merchant </a> </li> -->
                    <li><a href="<?=base_url('agent/add_merchant')?>">Add Merchant </a> </li>
                </ul>
            </li>
            
            <li>
                <a href="#transactions" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Transactions</span>
                    <img class="img-ss mb-1 mr-2" src="https://salequick.com/new_assets/img/new-icons/transaction-icon.png" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="transactions">
                    <li><a href="<?=base_url('agent/all_pos')?>">Instore & Mobile</a></li>
                    <li><a href="<?=base_url('agent/all_customer_request')?>">Invoice</a></li>
                    <li><a href="<?=base_url('agent/all_customer_request_recurring')?>">Recurring</a></li>
                    <!-- <li><a href="<?=base_url('agent/all_recurrig_request')?>">Recurring Request</a></li> -->
                </ul>
            </li>

            <li>
                <a href="#profile_settings" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Account Settings</span>
                    <img class="img-ss mb-1 mr-2" src="https://salequick.com/new_assets/img/new-icons/profile-setting.png" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="profile_settings">
                    <li><a href="<?php echo  base_url('agent/edit_profile');?>">Reseller detail</a></li>
                    <li><a href="<?php echo base_url('agent/logout'); ?>">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="sidebar-foot-div">
        <hr class="sidebar-foot-hr">
        <small class="sidebar-foot-sm d-block">Powered By</small>
        <small class="sidebar-foot-md">Milstead Technologies, LLC</small>
    </div>
</div>