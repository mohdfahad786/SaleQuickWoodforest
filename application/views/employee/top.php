   <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center">
                    <a href="<?php echo base_url(""); ?>" class="logo"> <span>Employee Panel</span></a>
                </div>
            </div>
            <!-- Button mobile view to collapse sidebar menu -->
            <nav class="navbar-custom">
                <ul class="list-inline float-right mb-0">
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">

                              

                                  <?php if($this->session->userdata('merchant_logo')!='') {?>
             <img src="<?php echo base_url("logo/".$this->session->userdata('merchant_logo')); ?>" class="rounded-circle" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
<?php }  else { ?>
 <img src="<?php echo base_url("logo"); ?>/nologo.jpg" class="rounded-circle" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
 <?php } ?>


                                <span><?php echo  $session_id = $this->session->userdata('merchant_name'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                            </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="text-overflow"><small>Welcome ! <?php echo  $session_id = $this->session->userdata('merchant_name'); ?></small> </h5>
                            </div>
                             <!-- item-->
                            <a href="<?php echo base_url('employee'); ?>" class="dropdown-item notify-item">
                                    <i class=" mdi mdi-view-dashboard"></i> <span>Dashboard</span>
                                </a>
                            <!-- item-->
                            <!-- item-->
                            <a href="<?php echo base_url('employee/edit_profile'); ?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-star-variant"></i> <span>Profile</span>
                                </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-settings"></i> <span>Settings</span>
                                </a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lock-open"></i> <span>Lock Screen</span>
                                </a>
                            <!-- item-->
                            <a href="<?php echo base_url('logout/merchant'); ?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout"></i> <span>Logout</span>
                                </a>
                        </div>
                    </li>
                </ul>
                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-light waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
          <script type="text/javascript">
var XMLHttpRequestObject = false;
var base_url = '<?php echo base_url(); ?>';
var base_url_no_index = '<?php echo base_url(); ?>';
</script>
<?php

if(isset($extraHeadContent))
echo $extraHeadContent;
?>