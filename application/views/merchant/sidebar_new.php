<?php if (empty($this->session->userdata('merchant_name')))
{
  header('Location:  '.  'https://salequick.com/login'  );
}

if( $this->session->userdata('merchant_user_type')=='employee' )
{
  
  if (!empty($this->session->userdata('employee_id')) &&  !empty($this->session->userdata('employee_id')) )
  {
	  
 if($this->session->userdata('view_menu_permissions')){
    
     $menuarraydata=explode(',',$this->session->userdata('view_menu_permissions'));
	 print_r($menuarraydata);
   }
   else{ $menuarraydata=array(); }
   
   }
  else
  {
    $menuofemployee="";
    $menuarraydata=array();
  }
  
}
?>
 <!-- Left Sidebar start --> 
<div class="sidebar-wrapper">   

  <div class="user-info">
    <div class="user-icon">
      <?php if($this->session->userdata('merchant_logo') ) { ?>
          <img src="<?php echo base_url()."logo/".$this->session->userdata('merchant_logo'); ?>" alt="user">
      <?php }else{ ?>
        <div class="user-icon-text">
        <?php echo substr($this->session->userdata('merchant_name'),0,1);  ?>
        </div> 
      <?php }?>
    </div>
    <div class="user-name"><?php echo $this->session->userdata('business_dba_name');?></div>
  </div>
  <div id="sidebar-menu" class="slimscrollleft">
    <ul>      
       <?php if($this->session->userdata('merchant_status')!='active') { ?>         
      <li>
        <a class="<?php echo ($this->session->userdata('merchant_status')=='Waiting_For_Approval')?'highliter':''?>" href="<?php echo base_url('merchant/after_signup'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/accM1.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/accM0.png'); ?>">
            <span>Activate Account </span>
          </span> 
        </a>
      </li>
      <?php } ?>
	  
	  

<?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1a", $menuarraydata) ||  in_array("1b", $menuarraydata) ||  in_array("1c", $menuarraydata) )  ) { ?> 
 <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/dashboard-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/dashboard-small-c.png'); ?>">
            <span>Dashboard</span>  
          </span> 
          <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
		 <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1a", $menuarraydata)  )  ) { ?>
          <li>
            <a href="<?php echo base_url('merchant'); ?>" >  Dashboard 
            </a>
          </li>
		  <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1b", $menuarraydata)  )  ) { ?>
          <li >
            <a href="<?php echo base_url('graph/sale'); ?>" >  Transaction Summary
            </a>
          </li>
		   <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("1c", $menuarraydata)  )  ) { ?>
          <li >
            <a href="<?php echo base_url('graph/trends'); ?>" >  Sales Trends   
            </a>
          </li>
		  <?php } ?>
        </ul> 
      </li>
	  <?php } ?>
	   <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("3a", $menuarraydata)  )  ) { ?>
      <li>
	  
	  
        <a class="virtual-terminal" href="<?php echo base_url('pos/add_pos'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/pos-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/pos-small-c.png'); ?>">
            <span>Virtual Terminal </span>
          </span>  
        </a>
      </li>
	  <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("3b", $menuarraydata)  )  ) { ?>
      <li>
        <a href="<?php echo base_url('merchant/add_straight_request'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/invoice-small.png'); ?>">   
            <img class="c-icon" src="<?php echo base_url('new_assets/img/invoice-small-c.png'); ?>">  
            <span>Invoicing</span> 
          </span>
        </a>
      </li>
	   <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("3c", $menuarraydata)  )  ) { ?>
      <li>
        <a href="<?php echo base_url('merchant/add_customer_request'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/recurring-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/recurring-small-c.png'); ?>">
            <span>Recurring</span>  
          </span>
        </a>
      </li>
	  <?php } ?>
	  
	            <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
      <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/dashboard-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/dashboard-small-c.png'); ?>">
            <span>Dashboard</span>  
          </span> 
          <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo base_url('merchant'); ?>" >  Dashboard 
            </a>
          </li>
          <li >
            <a href="<?php echo base_url('graph/sale'); ?>" >  Transaction Summary
            </a>
          </li>
          <li >
            <a href="<?php echo base_url('graph/trends'); ?>" >  Sales Trends   
            </a>
          </li>
        </ul> 
      </li>
      <li>
        <a class="virtual-terminal" href="<?php echo base_url('pos/add_pos'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/pos-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/pos-small-c.png'); ?>">
            <span>Virtual Terminal </span>
          </span>  
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('merchant/add_straight_request'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/invoice-small.png'); ?>">   
            <img class="c-icon" src="<?php echo base_url('new_assets/img/invoice-small-c.png'); ?>">  
            <span>Invoicing</span> 
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('merchant/add_customer_request'); ?>">
          <span>
            <img src="<?php echo base_url('new_assets/img/recurring-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/recurring-small-c.png'); ?>">
            <span>Recurring</span>  
          </span>
        </a>
      </li>
	            <?php } ?>
      <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/transaction-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/transaction-small-c.png'); ?>">
            <span>Transactions</span>
          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
		 <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("2a", $menuarraydata)  )  ) { ?>
          <li>
            <a href="<?php echo base_url('pos/all_pos'); ?>">Instore & Mobile</a>
          </li>
		 <?php } if($this->session->userdata('merchant_user_type')=='merchant') { ?>
		  
		  <li>
            <a href="<?php echo base_url('pos/all_pos'); ?>">Instore & Mobile</a>
          </li>
          <li>
            <a href="<?php echo base_url('pos/all_customer_request'); ?>">  Invoice    </a>
          </li>
          <li>
            <a class="allCustomerRecur" href="<?php echo base_url('pos/all_customer_request_recurring'); ?>">  Recurring   </a>
          </li>
           <?php } ?>
          <?php if($this->session->userdata('register_type')=='api') { ?>         
            <li><a  href="<?php echo base_url('sandbox/all_sandbox_payment'); ?>">Sandbox Payment   </a></li>
          <?php } ?>  
        </ul> 
      </li>
      <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
      <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/refund-icon.png'); ?>">
<img class="c-icon" src="<?php echo base_url('new_assets/img/refund-icon-c.png'); ?>">
            <span>Refund</span>  
          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo base_url('refund/all_pos'); ?>">Instore & Mobile </a>
          </li>
          <li>
            <a href="<?php echo base_url('refund/all_customer_request'); ?>">  Invoice   </a>
          </li>
        </ul> 
      </li>
      <?php } ?>
	  
	  <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("4c", $menuarraydata) ||  in_array("4d", $menuarraydata)  )  ) { ?> 
	  
	  <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/inventory-icon.png'); ?>">
          <img class="c-icon" src="<?php echo base_url('new_assets/img/inventory-icon-c.png'); ?>">
            <span>Inventory</span>  
          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
		 <?php if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("4c", $menuarraydata)  )  ) { ?>
          <li>
            <a href="<?php echo base_url('pos/inventorymngt'); ?>">Items Management</a>
          </li>
		 <?php } if( $this->session->userdata('merchant_user_type')=='employee' && ( in_array("4d", $menuarraydata)  )  ) { ?>
          <li>
            <a href="<?php echo base_url('pos/inventoryreport'); ?>">  Reports   </a>
          </li>
		  <?php } ?>
        </ul> 
      </li>
	  
      <?php } ?>
      <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
      <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/inventory-icon.png'); ?>">
          <img class="c-icon" src="<?php echo base_url('new_assets/img/inventory-icon-c.png'); ?>">
            <span>Inventory</span>  
          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo base_url('pos/inventorymngt'); ?>">Items Management</a>
          </li>
          <li>
            <a href="<?php echo base_url('pos/inventoryreport'); ?>">  Reports   </a>
          </li>
        </ul> 
      </li>

      <li>
				<a href="<?php echo base_url('merchant/payment_mode'); ?>">
					<span>
						<img src="<?php echo base_url('new_assets/img/refund-small.png'); ?>">
						<img class="c-icon" src="<?php echo base_url('new_assets/img/refund-small-c.png'); ?>">
						<span>Payment Mode</span>  
					</span> 
				</a>
				
			</li>
      
      <?php } ?>
      
      <li>
        <a href="#">
          <span>
            <img src="<?php echo base_url('new_assets/img/settings-small.png'); ?>">
            <img class="c-icon" src="<?php echo base_url('new_assets/img/settings-small-c.png'); ?>">
            <span>Settings</span> 
          </span> 
          <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>
        </a>
        <ul class="sub-menu">
          <li>
            <a class="no-ajax" href="<?php echo base_url('logout/merchant'); ?>"> Logout 
            </a>
          </li>
          <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
            <li>
              <a href="<?php echo base_url('api/invoice'); ?>"> Api Detail   
              </a>
            </li>
            <li>
            <a href="<?php echo base_url('merchant/edit_profile'); ?>"> Profile  
            </a>
          </li>

          <?php } ?>

          <?php if($this->session->userdata('employee_id')) { ?>
            <li>
            <a href="<?php echo base_url('merchant/edit_employee_profile'); ?>">Profile</a>
           </li>
           <!-- <li>
            <a href="<?php echo base_url('merchant/edit_profile'); ?>">Merchant Profile</a>
          </li> -->
          
          <?php } ?>

          
          <?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
          <li>
            <a href="<?php echo base_url('merchant/tax_list'); ?>" class="tax-list">Tax 
            </a>
          </li>
          <li>
            <a href="<?php echo base_url('merchant/all_employee'); ?>"> Employee 
            </a>
          </li>
          <li>
            <a href="<?php echo base_url('merchant/all_user'); ?>"> User 
            </a>
          </li>
          <?php } ?>
        </ul>
      </li>
    </ul>
  </div>
</div>  