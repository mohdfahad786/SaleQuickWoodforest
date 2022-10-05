<?php
if (empty($this->session->userdata('username'))) {
    header('Location:  '.  base_url().'admin'  );
}
?>
<?php //echo '<pre>';print_r($this->session->userdata());die; ?>
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
    .display-avatar {
        padding: 15px !important;
    }
</style>

<div class="sidebar">
    <div class="sb-body" style="overflow: auto !important;">
        <!-- <div class="user-profile">
            <div class="display-avatar sidebar_logo_preview">
                <img class="img-lg-custom" src="<?php echo base_url()?>new_assets/img/user.svg" alt="profile image">
            </div>
            <div class="info-wrapper">
                <p class="user-name">
                    <?php echo (!empty($this->session->userdata('name'))) ? ucfirst($this->session->userdata('name')) : ucfirst($this->session->userdata('username')); ?>
                </p>
                <p class="ml-2 text-muted" style="font-family: Avenir-Heavy !important;"><?php echo ucfirst($this->session->userdata('user_type')); ?></p>
            </div>
        </div> -->

        <div class="user-profile">
            <div class="display-avatar sidebar_logo_preview">
                <?php if($this->session->userdata('image') ) { ?>
                    <img class="img-lg-custom" src="<?php echo base_url()."uploads/".$this->session->userdata('image'); ?>" alt="profile image">
                <?php } else { ?>
                    <div class="img-lg-custom-text-light">
                        <?php echo (!empty($this->session->userdata('name'))) ? strtoupper(substr($this->session->userdata('name'),0,1)) : strtoupper(substr($this->session->userdata('username'),0,1)); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="info-wrapper">
                <p class="user-name">
                    <?php echo (!empty($this->session->userdata('name'))) ? ucfirst($this->session->userdata('name')) : ucfirst($this->session->userdata('username')); ?>
                </p>
                <p class="ml-2 text-muted" style="font-family: Avenir-Heavy !important;"><?php echo ucfirst($this->session->userdata('user_type')); ?></p>
            </div>
        </div>

        <ul class="navigation-menu">
            <li>
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false">
                  	<span class="link-title">Dashboard</span>
                  	<img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/dashboard-icon.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="dashboard">
                    <li>
                        <a href="<?php echo base_url('dashboard'); ?>" title="Dashboard">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Admin_Graph/sale'); ?>" title="Sales Summary">Sales Summary</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Admin_Graph/trends'); ?>" title="Sales Trends">Sales Trends</a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo base_url('Admin_Chart/trends_original'); ?>" title="Funding">ghayas</a>
                    </li> -->
                   <!--  <li>
                        <a href="<?php echo base_url('dashboard/report'); ?>" title="Funding">Funding</a>
                    </li> -->
                </ul>
            </li>
            

            <li>
                <a href="#merchant_master" data-toggle="collapse" aria-expanded="false">
                  	<span class="link-title">Merchant</span>
                  	<img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/dashboard-icon.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="merchant_master">
                    <li>
                        <a href="<?php echo base_url('dashboard/all_merchant'); ?>" title="View Merchant">View Merchant</a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo base_url('dashboard/all_sub_merchant'); ?>" title="View Sub User">View Sub User</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('device_location'); ?>" title="Device Locations">Device Locations</a>
                    </li> -->
                </ul>
            </li>

           <li>
                <a href="#admin_master" data-toggle="collapse" aria-expanded="false">
                    <span class="link-title">Admins</span>
                    <img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/dashboard-icon.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="admin_master">
                    <li>
                        <a href="<?php echo base_url('multiadmin/add_admin'); ?>" title="View Merchant">Add Admin</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('multiadmin/all_admin'); ?>" title="View Sub User">All Admin</a>
                    </li>
                </ul>
            </li>

           

            <li>
                <a href="#payments" data-toggle="collapse" aria-expanded="false">
                  	<span class="link-title">Payments</span>
                  	<img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/admin_img/transaction-icon2.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="payments">
                    <li>
                        <a href="<?=base_url('admin/all_pos')?>" title="Instore & Mobile">Instore & Mobile</a>
                    </li>
                   
                    <li>
                        <a href="<?=base_url('dashboard/all_customer_request')?>" title="Invoice">Invoice</a>
                    </li>
                    <li>
                        <a href="<?=base_url('dashboard/all_customer_request_recurring')?>" title="Recurring">Recurring</a>
                    </li>
                    <!-- <li>
                        <a href="<?=base_url('dashboard/all_recurrig_request')?>" title="Recurring Request">Recurring Request</a>
                    </li> -->
                    <li>
                        <a href="<?=base_url('admin/all_ecommerce')?>" title="Recurring Request">Ecommerce</a>
                    </li>
                   <!--   <li>
                        <a href="<?=base_url('settlement_list/all_pos')?>" title="Settlement List">Settlement List</a>
                    </li> -->
                </ul>
            </li>

          


          

            <!-- <li>
                <a href="#email_template" data-toggle="collapse" aria-expanded="false">
                  	<span class="link-title">Email Template</span>
                  	<img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/img/new-icons/dashboard-icon.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="email_template">
                    <li>
                        <a href="<?php echo base_url('email_template/invoice'); ?>" title="Invoice">Invoice</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('email_template/pos'); ?>" title="Instore & Mobile">Instore & Mobile</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('email_template/reciept'); ?>" title="Receipt">Receipt</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('email_template/recurring'); ?>" title="Recurring">Recurring</a>
                    </li>
                    <li>
                		<a href="<?php echo base_url('email_template/registration'); ?>" title="Registration">Registration</a>
              		</li>
                </ul>
            </li> -->

            <li>
                <a href="#settings" data-toggle="collapse" aria-expanded="false">
                  	<span class="link-title">Settings</span>
                  	<img class="img-ss mb-1 mr-2" src="<?php echo base_url('new_assets/admin_img/profile-setting2.png'); ?>" alt="sidebar-icon">
                </a>
                <ul class="collapse navigation-submenu" id="settings">
                    <li>
                        <a href="<?php echo  base_url('profile/edit_profile');?>" title="Update Profile">My Profile</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('logout'); ?>" title="Log Out">Log Out</a>
                    </li>
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