<?php if (empty($this->session->userdata('username')))
{ 
    header('Location:  '.  'https://salequick.com/admin'  );
}
?> 
 <div class="left side-menu">
            <div class="sidebar-inner slimscrollleft">
                <!--- Divider -->
                <div id="sidebar-menu"> 
                    <ul>
                        <li class="menu-title clearfix">
                            <div class="left-user pull-left">

                                  <?php if($this->session->userdata('image')!='') {?>
             <img src="<?php echo base_url("logo/".$this->session->userdata('image')); ?>" class="rounded-circle sidebar-user pull-right" alt="<?php echo  $session_id = $this->session->userdata('name'); ?>"/>
<?php }  else { ?>
 <img src="<?php echo base_url("logo"); ?>/nologo.jpg" class="rounded-circle sidebar-user pull-right" alt="<?php echo  $session_id = $this->session->userdata('name'); ?>"/>
 <?php } ?>
                              

                                <div class="ol"></div>
                            </div>
                            <div class="user-info pull-left text-left"><span class="user-name"><?php echo  $session_id = $this->session->userdata('name'); ?> </span>
                                <span>online</span></div>
                        </li>

                         <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/icon-charge-back.png"><span> Dashboard  </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                               <li><a href="<?php echo base_url('dashboard'); ?>">  Dashboard </a></li>

                               <li><a href="<?php echo base_url('Admin_Graph/sale'); ?>">  Sales Summary   </a></li>
                       <li ><a href="<?php echo base_url('Admin_Graph/trends'); ?>">  Sales Trends   </a></li>

                         <li ><a href="<?php echo base_url('dashboard/report'); ?>">  Funding   </a></li>

                            
                           
                                
                            </ul> 
                        </li>

                         <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/bills.png"><span> Merchant Master </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                               
   <li><a href="<?php echo base_url('dashboard/all_merchant'); ?>">View Marchent</a></li>
    <li><a href="<?php echo base_url('dashboard/all_sub_merchant'); ?>">View Sub User</a></li>
                                
                            </ul> 
                        </li>


                         <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/addE.png"><span> Customers </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                               
   <li><a href="<?php echo base_url('customer/all_support'); ?>">Support Request</a></li>
    <li><a href="<?php echo base_url('customer/all_request'); ?>">Sales Request</a></li>
     <li><a href="#">Website traffic analytics</a></li>
      <li><a href="#">Area to process card reader sales</a></li>
                                
                            </ul> 
                        </li>


                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/money.png"> <span> Payments </span><span class="menu-arrow"></span></a>
                             <ul class="list-unstyled">
                        
      <li><a href="<?php echo base_url('admin/all_pos'); ?>">   Pos</a></li>      
    <li><a href="<?php echo base_url('dashboard/all_customer_request'); ?>">Invoice </a></li>
      <li><a href="<?php echo base_url('dashboard/all_customer_request_recurring'); ?>">Recurring  </a></li>
       <li><a href="<?php echo base_url('dashboard/all_recurrig_request'); ?>">Recurring  Requests</a></li>
                            </ul> 
                        </li>

                        <!--  <li class="has_sub">-->
                        <!--    <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/icon-charge-back.png"><span> Charge Back  </span> <span class="menu-arrow"></span> </a>-->
                        <!--     <ul class="list-unstyled">-->
                             
                        <!--    <li><a href="<?php echo base_url('charge_back/all_charge_back'); ?>">  List Charge Back </a></li>-->
                                
                        <!--    </ul> -->
                        <!--</li>-->


                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary">
                                <img src="<?php echo base_url('merchant-panel'); ?>/image/employee.png"><span> SubAdmin Master </span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                               <li><a href="<?php echo base_url('dashboard/create_new_subadmin'); ?>"> Create New SubAdmin </a></li> 
                                <li><a href="<?php echo base_url('dashboard/all_subadmin'); ?>">View All SubAdmin</a></li>
                            </ul> 
                        </li>
                        
                      
    


                     <!--   <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/pos-management.png"><span> Pos Management </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                               <li><a href="<?php echo base_url('pos/add_pos'); ?>"> Add New Pos </a></li> 
 
                                
                            </ul> 
                        </li> -->

  <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary">
                                <img src="<?php echo base_url('merchant-panel'); ?>/image/employee.png"><span> Email Template </span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">

                              <li><a href="<?php echo base_url('email_template/invoice'); ?>">Invoice </a></li>  

                               <li><a href="<?php echo base_url('email_template/pos'); ?>"> Pos </a></li> 

                               <li><a href="<?php echo base_url('email_template/reciept'); ?>"> Reciept </a></li> 

                               <li><a href="<?php echo base_url('email_template/recurring'); ?>"> Recurring </a></li> 
                               
                               <li><a href="<?php echo base_url('email_template/registration'); ?>"> Registration </a></li> 

                              
                               
                            </ul> 
                        </li>
                        
                        

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/setting.png"><span> Web Management </span> <span class="menu-arrow"></span></a>
                             <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('profile/edit_profile'); ?>"> Update Profile  </a></li>

                               
                            </ul>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>