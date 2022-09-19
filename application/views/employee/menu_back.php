 <div class="left side-menu">
            <div class="sidebar-inner slimscrollleft">
                <!--- Divider -->
                <div id="sidebar-menu">
                    <ul>
                        <li class="menu-title clearfix">
                            <div class="left-user pull-left">

                                  <?php if($this->session->userdata('merchant_logo')!='') {?>
             <img src="<?php echo base_url("logo/".$this->session->userdata('merchant_logo')); ?>" class="rounded-circle sidebar-user pull-right" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
<?php }  else { ?>
 <img src="<?php echo base_url("logo"); ?>/nologo.jpg" class="rounded-circle sidebar-user pull-right" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
 <?php } ?>
                              

                                <div class="ol"></div>
                            </div>
                            <div class="user-info pull-left text-left"><span class="user-name"><?php echo  $session_id = $this->session->userdata('merchant_name'); ?> </span>
                                <span>online</span></div>
                        </li>
                      
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/money.png"> <span> Straight Payment</span><span class="menu-arrow"></span></a>
                             <ul class="list-unstyled">
             <?php if($this->session->userdata('create_pay_permissions')=='1') { ?>           
             <li><a href="<?php echo base_url('employee/add_straight_request'); ?>">Create  Requests</a></li> 
              <?php } ?>   
    <li><a href="<?php echo base_url('employee/all_straight_request'); ?>">All Payment requests</a></li>
                            </ul> 
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/bills.png"><span> Recurring Payment </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                               <?php if($this->session->userdata('create_pay_permissions')=='1') { ?> 
                               <li><a href="<?php echo base_url('employee/add_customer_request'); ?>">Create Requests</a></li> 
                                <?php } ?>   
    <li><a href="<?php echo base_url('employee/all_customer_request'); ?>">All Payment requests</a></li>
                                
                            </ul> 
                        </li>

                          <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/pos-management.png"><span> Pos Management </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('pos/add_pos'); ?>"> Add New Pos </a></li>
 <li><a href="<?php echo base_url('pos/all_pos'); ?>">  List Pos</a></li>
                                
                            </ul> 
                        </li>


                          <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/icon-charge-back.png"><span> Charge Back  </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('pos/all_confirm_payment'); ?>"> All Confirm payment  </a></li>
                              <!--   <li><a href="<?php echo base_url('pos/add_charge_back'); ?>"> Add Charge Back  </a></li> -->
                            <li><a href="<?php echo base_url('pos/all_charge_back'); ?>">  List Charge Back </a></li>
                                
                            </ul> 
                        </li>


                      
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/setting.png"><span> Web Management </span> <span class="menu-arrow"></span></a>
                             <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('employee/edit_profile'); ?>"> Update Profile  </a></li>

                               
                            </ul>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>