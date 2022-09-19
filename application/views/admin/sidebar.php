<?php if (empty($this->session->userdata('username')))

{

    header('Location:  '.  base_url().'admin'  );

}

?> 

 

 <!-- Left Sidebar start --> 

<div class="sidebar-wrapper">   



  <div class="user-info">

    <div class="user-icon">

          <img src="<?php echo base_url()?>new_assets/img/user.svg" alt="user">

    </div>

    <div class="user-name">Admin Panel</div>

  </div>

  <div id="sidebar-menu" class="slimscrollleft">

    <ul>    

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

          <li>

            <a href="<?=base_url('dashboard')?>">  Dashboard 

            </a>

          </li>

          <li >

            <a href="<?=base_url('Admin_Graph/sale')?>">  Sales Summary   

            </a>

          </li>

          <li >

            <a href="<?=base_url('Admin_Graph/trends')?>">  Sales Trends   

            </a>

          </li>

          <li >

            <a href="<?=base_url('dashboard/report')?>">  Funding  

            </a>

          </li>

        </ul> 

      </li>

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

          <li>

            <a href="<?=base_url('dashboard/all_merchant')?>">  View Merchant 

            </a>

          </li>

          <li>

            <a href="<?=base_url('dashboard/all_sub_merchant')?>">  View Sub User 

            </a>

          </li>

        </ul> 

      </li>

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

          <li>

            <a href="<?=base_url('customer/all_support')?>">Support Request</a>

          </li>      

          <li>

            <a href="<?=base_url('customer/all_request')?>">Sales Request</a>

          </li>     

          <li>

            <a href="#">Website traffic analytics</a>

          </li>     

          <li>

            <a href="#">Area to process card reader sales</a>

          </li>    

        </ul> 

      </li>

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

          <li>

            <a href="<?=base_url('admin/all_pos')?>">Instore & Mobile </a>

          </li>

          <li>

            <a href="<?=base_url('dashboard/all_customer_request')?>">  Invoice   </a>

          </li>

          <li>

            <a href="<?=base_url('dashboard/all_customer_request_recurring')?>">  Recurring   </a>

          </li>

          <li>

            <a href="<?=base_url('dashboard/all_recurrig_request')?>">  Recurring Request   </a>

          </li>

        </ul> 

      </li>

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/images/sam.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/sam-c.png">

            <span>SubAdmin Master</span>  

          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">

          <li>

            <a href="<?=base_url('dashboard/create_new_subadmin')?>">Create New SubAdmin</a>

          </li>

          <li>

            <a href="<?=base_url('dashboard/all_subadmin')?>">View All SubAdmin</a>

          </li>

        </ul> 

      </li>

      <li>


         <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/images/sam.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/sam-c.png">

            <span>Sales Agents</span>  

          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">

          <li>

            <a href="<?=base_url('dashboard/create_new_agent')?>">Create New Agent</a>

          </li>



          <li>

            <a href="<?=base_url('dashboard/all_agent')?>">View All Agent</a>

          </li>
           <li>

            <a href="<?=base_url('Agent/all_agent_report')?>">Sales Agent Reports</a>

          </li>

        </ul> 

      </li>
      
      
      <li>
        <a class="virtual-terminal" href="<?php echo base_url('broadcast/send_mail'); ?>">
          <span>
            <img src="<?=base_url();?>new_assets/images/sam.png">
            <img class="c-icon" src="<?=base_url();?>new_assets/images/sam-c.png">
            <span>Broadcast Mail </span>
          </span>  
        </a>
      </li>
      

      <li>

        <a href="#">

          <span>

            <img src="<?=base_url();?>new_assets/images/et.png">

            <img class="c-icon" src="<?=base_url();?>new_assets/images/et-c.png">

            <span>Email Template</span>  

          </span> <i class="material-icons plus"> add </i><i class="material-icons minus"> remove </i>

        </a>

        <ul class="sub-menu">

          <li>

            <a href="<?php echo base_url('email_template/invoice'); ?>">Invoice</a>

          </li>

          <li>

            <a href="<?php echo base_url('email_template/pos'); ?>">Instore & Mobile</a>

          </li>

          <li>

            <a href="<?php echo base_url('email_template/reciept'); ?>">Receipt</a>

          </li>

          <li>

            <a href="<?php echo base_url('email_template/recurring'); ?>">Recurring</a>

          </li>

          <li>

            <a href="<?php echo base_url('email_template/registration'); ?>">Registration</a>

          </li>

        </ul> 

      </li>

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

            <a href="<?php echo  base_url('profile/edit_profile');?>"> Update Profile  

            </a>

          </li>

          <li>

            <a href="<?php echo base_url('logout'); ?>">Log Out 

            </a>

          </li>

        </ul>

      </li>

    </ul>

  </div>

</div>  