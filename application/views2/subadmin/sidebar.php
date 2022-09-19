<?php 


if (empty($this->session->userdata('subadmin_user_type')))

{

    header('Location:  '.  base_url().'admin'  );

}

if( $this->session->userdata('subadmin_user_type')=='sub_admin' )
{
  
  if (!empty($this->session->userdata('subadmin_id')) &&  !empty($this->session->userdata('subadmin_id')) )
  {
    

   if($this->session->userdata('subadmin_view_menu_permissions')){
    
     $menuarraydata=explode(',',$this->session->userdata('subadmin_view_menu_permissions'));
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

          <img src="<?php echo base_url()?>new_assets/img/user.svg" alt="user">

    </div>

    <div class="user-name">Subamin Panel</div>

  </div>

  <div id="sidebar-menu" class="slimscrollleft">

    <ul>    
    <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("1a", $menuarraydata) ||  in_array("1b", $menuarraydata) ||  in_array("1c", $menuarraydata) || in_array("1d", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/img/dashboard-small.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/img/dashboard-small-c.png">

            <span>Dashboard</span>  

          </span> 

          <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">
        <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("1a", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/dashboard')?>">  Dashboard 

            </a>

          </li>
        <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("1b", $menuarraydata)  )  ) { ?>
          <li >

            <a href="<?=base_url('Subadmin_Graph/sale')?>">  Sales Summary   

            </a>

          </li>
          <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("1c", $menuarraydata)  )  ) { ?>
          <li >

            <a href="<?=base_url('Subadmin_Graph/trends')?>">  Sales Trends   

            </a>

          </li>
          <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("1d", $menuarraydata)  )  ) { ?>
          <li >

            <a href="<?=base_url('subadmin/report')?>">  Funding  

            </a>

          </li>
          <?php }?>

        </ul> 

      </li>
    <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("4a", $menuarraydata) ||  in_array("4b", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/images/mm.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/mm-c.png">

            <span>Merchant Master</span>  

          </span> 

          <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">
        <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("4a", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_merchant')?>">  View Merchant 

            </a>

          </li>
          <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("4b", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_sub_merchant')?>">  View Sub User 

            </a>

          </li>
          <?php } ?>

        </ul> 

      </li>
      <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("4c", $menuarraydata) || in_array("5d", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>
            <img src="<?=base_url();?>new_assets/images/customer.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/customer-c.png">

            <span>Customers</span>

          </span> 

          <i class="material-icons plus"> add </i>

          <i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">
        <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("4c", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadminCustomer/all_support')?>">Support Request</a>

          </li>      
        <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("4d", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadminCustomer/all_request')?>">Sales Request</a>

          </li>     
          <?php }?>
          <!-- <li>

            <a href="#">Website traffic analytics</a>

          </li>     

          <li>

            <a href="#">Area to process card reader sales</a>

          </li>     -->

        </ul> 

      </li>
      <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("2a", $menuarraydata) ||  in_array("2b", $menuarraydata) ||  in_array("2c", $menuarraydata) || in_array("2d", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/img/transaction-small.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/img/transaction-small-c.png">

            <span>Payments</span>  

          </span> 

          <i class="material-icons plus"> add </i>

          <i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">
        <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("2a", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_pos')?>">Instore & Mobile </a>

          </li>
        <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("2b", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_customer_request')?>">  Invoice   </a>

          </li>
          <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("2c", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_customer_request_recurring')?>">  Recurring   </a>

          </li>
          <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("2d", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_recurrig_request')?>">  Recurring Request   </a>

          </li>
          <?php } ?>
        </ul> 

      </li>
      <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("5a", $menuarraydata) ||  in_array("5b", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/images/sam.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/sam-c.png">

            <span>SubAdmin Master</span>  

          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">
        <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("5a", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/create_new_subadmin')?>">Create New SubAdmin</a>

          </li>
        <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("5b", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?=base_url('subadmin/all_subadmin')?>">View All SubAdmin</a>

          </li>
          <?php }?>
        </ul> 

      </li>
      <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("3a", $menuarraydata) ||  in_array("3b", $menuarraydata) ||  in_array("3c", $menuarraydata) || in_array("3d", $menuarraydata) || in_array("3e", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/images/et.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/et-c.png">

            <span>Email Template</span>  

          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">
        <?php if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("3a", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?php echo base_url('subadmin_email_template/invoice'); ?>">Invoice</a>

          </li>
        <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("3b", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?php echo base_url('subadmin_email_template/pos'); ?>">Instore & Mobile</a>

          </li>
          <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("3c", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?php echo base_url('subadmin_email_template/reciept'); ?>">Receipt</a>

          </li>
          <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("3d", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?php echo base_url('subadmin_email_template/recurring'); ?>">Recurring</a>

          </li>
          <?php }if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("3e", $menuarraydata)  )  ) { ?>
          <li>

            <a href="<?php echo base_url('subadmin_email_template/registration'); ?>">Registration</a>

          </li>
          <?php } ?>

        </ul> 

      </li>
      <?php } if( $this->session->userdata('subadmin_user_type')=='sub_admin' && ( in_array("6", $menuarraydata) )  ) { ?>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/img/settings-small.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/img/settings-small-c.png">

            <span>Settings</span> 

          </span> 

          <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">

          <li>

            <a href="<?php echo  base_url('subadmin/edit_profile');?>"> Update Profile  

            </a>

          </li>

          <li>

            <a href="<?php echo base_url('subadmin/logout'); ?>">Log Out 

            </a>

          </li>

        </ul>

      </li>
      <?php } ?>
    </ul>

  </div>

</div>  