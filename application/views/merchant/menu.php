<?php if (empty($this->session->userdata('merchant_name')))
{
    header('Location:  '.  'https://salequick.com/login'  );
}
?>
<style>  

#sidebar-menu ul ul li.active a {
    color: #216078!important;
}
.highliter {
 
  position: relative;
  

  
  text-transform: uppercase;
  text-align: center;
 
  color: white;
  border: none;
 
  cursor: pointer;
  box-shadow: 0 0 0 0 rgba(90, 153, 212, 0.5);
  -webkit-animation: pulse 1.5s infinite;
}

.highliter:hover {
  -webkit-animation: none;
}

@-webkit-keyframes pulse {
  0% {
    -moz-transform: scale(0.5);
    -ms-transform: scale(0.5);
    -webkit-transform: scale(0.5);
    transform: scale(0.9);
  }
  70% {
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -webkit-transform: scale(1);
    transform: scale(1);
    box-shadow: 0 0 0 20px rgba(90, 153, 212, 0);
  }
  100% {
    -moz-transform: scale(0.9);
    -ms-transform: scale(0.9);
    -webkit-transform: scale(0.9);
    transform: scale(0.9);
    box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
  }
}

</style>
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
               <?php if($this->session->userdata('merchant_status')!='active') { ?>         
              <li><a class="<?php echo ($this->session->userdata('merchant_status')=='Waiting_For_Approval')?'highliter':''?>" href="<?php echo base_url('merchant/after_signup'); ?>"><img src="<?php echo base_url('merchant-panel'); ?>/image/setting2.png"><span> Activate Account </span> </a></li>
              <?php } ?>
                         <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/icon-charge-back.png"><span> Dashboard  </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">
                               <li><a href="<?php echo base_url('merchant'); ?>">  Dashboard </a></li>

                               <li ><a href="<?php echo base_url('graph/sale'); ?>">  Sales Summary   </a></li>
                                <li ><a href="<?php echo base_url('graph/trends'); ?>">  Sales Trends   </a></li>

                            
                           
                                
                            </ul> 
                        </li>


                          <li class="has_sub">
                            <a href="<?php echo base_url('pos/add_pos'); ?>" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/pos-management.png"><span>Point of Sale </span>  </a>
                      
                        </li>


                       
                        <li class="has_sub">
                            <a href="<?php echo base_url('merchant/add_straight_request'); ?>" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/money.png"> <span> Invoicing </span></a>
                             <ul class="list-unstyled">
                        
           
  
                            </ul> 
                        </li>
                        <li class="has_sub">
                            <a href="<?php echo base_url('merchant/add_customer_request'); ?>" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/bills.png"><span> Recurring  </span></a>
                             <ul class="list-unstyled">
                              
  
                                
                            </ul> 
                        </li>



                          <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/icon-charge-back.png"><span> Transaction  </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">

                             
                <li><a href="<?php echo base_url('pos/all_pos'); ?>">  Pos </a></li>
                                
                                <li><a href="<?php echo base_url('pos/all_customer_request'); ?>">  Invoice   </a></li>

                                   <li><a href="<?php echo base_url('pos/all_customer_request_recurring'); ?>">  Recurring     </a></li>
                                   <?php if($this->session->userdata('register_type')=='api') { ?>         
              <li><a  href="<?php echo base_url('sandbox/all_sandbox_payment'); ?>">Sandbox Payment   </a></li>
              <?php } ?>    
                                     
                                
                            </ul> 
                        </li>
                        
                          <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/icon-charge-back.png"><span> Refund  </span> <span class="menu-arrow"></span> </a>
                             <ul class="list-unstyled">

                             
                <li><a href="<?php echo base_url('refund/all_pos'); ?>">  Pos </a></li>
                                
                               <li><a href="<?php echo base_url('refund/all_customer_request'); ?>">  Invoice   </a></li>

                                <!--   <li><a href="<?php echo base_url('pos/all_customer_request_recurring'); ?>">  Recurring     </a></li>-->

                                     
                                
                            </ul> 
                        </li>


                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect waves-primary"><img src="<?php echo base_url('merchant-panel'); ?>/image/setting.png"><span> Settings </span> <span class="menu-arrow"></span></a>
                             <ul class="list-unstyled">
                                    <li><a href="<?php echo base_url('api/invoice'); ?>"> Api Detail   </a></li>
                                <li><a href="<?php echo base_url('merchant/edit_profile'); ?>"> Profile  </a></li>
                                   
    <li><a href="<?php echo base_url('merchant/tax_list'); ?>">Tax </a></li>

 <li><a href="<?php echo base_url('merchant/all_employee'); ?>"> Employee </a></li>
  <li><a href="<?php echo base_url('merchant/all_user'); ?>"> User </a></li>
  
                         
                            </ul>
                        </li>

                  
                        
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>