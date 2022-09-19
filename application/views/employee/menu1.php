    <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
    <div class="pull-left image">
    
     

        <?php if($this->session->userdata('merchant_logo')!='') {?>
             <img src="<?php echo base_url("logo/".$this->session->userdata('merchant_logo')); ?>" class="img-circle" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
<?php }  else { ?>
 <img src="<?php echo base_url("logo"); ?>/nologo.jpg" class="img-circle" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
 <?php } ?>

    </div>
    <div class="pull-left info">
    <p><?php echo  $session_id = $this->session->userdata('merchant_name'); ?></p>
    <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
    </div>
    </div>
    
  <!--  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search..."/>
    <span class="input-group-btn">
    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
    </span>
    </div>
    </form>-->
    
    <ul class="sidebar-menu">
  <!--   <li class="treeview">
    <a href="#">
    <i class="fa fa-arrows"></i> <span>Merchant Payment </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
    <li><a href="<?php echo base_url('merchant/add_new_request'); ?>"><i class="fa fa-circle-o"></i>New Payment requests</a></li>
    <li><a href="<?php echo base_url('merchant/all_payment_request'); ?>"><i class="fa fa-circle-o"></i>All Payment requests</a></li>
    </ul>
    </li> -->

     <li class="treeview">
    <a href="#">
   <i class="fa fa-male"></i><span>Employee Master </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
    <li><a href="<?php echo base_url('merchant/add_employee'); ?>"><i class="fa fa-circle-o"></i>  Add Employee</a></li>
    <li><a href="<?php echo base_url('merchant/all_employee'); ?>"><i class="fa fa-circle-o"></i>All Employee</a></li>
    </ul>
    </li>

     <li class="treeview">
    <a href="#">
   <i class="fa fa-money"></i> <span>Straight Payment </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
    <li><a href="<?php echo base_url('merchant/add_straight_request'); ?>"><i class="fa fa-circle-o"></i>  New Payment requests</a></li>
    <li><a href="<?php echo base_url('merchant/all_straight_request'); ?>"><i class="fa fa-circle-o"></i>All Payment requests</a></li>

    </ul>
    </li>

     <li class="treeview">
    <a href="#">
   <i class="fa fa-money"></i> <span>Recurring Payment </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
    <li><a href="<?php echo base_url('merchant/add_customer_request'); ?>"><i class="fa fa-circle-o"></i>  New Payment requests</a></li>
    <li><a href="<?php echo base_url('merchant/all_customer_request'); ?>"><i class="fa fa-circle-o"></i>All Payment requests</a></li>
  <!--   <li><a href="<?php echo base_url('merchant/all_customer_request_recurring'); ?>"><i class="fa fa-circle-o"></i>Recurring Payment requests</a></li>

      <li><a href="<?php echo base_url('merchant/all_recurrig_request'); ?>"><i class="fa fa-circle-o"></i>Send Recurring  requests</a></li> -->
    </ul>
    </li>

     <li class="treeview">
    <a href="#">
   <i class="fa fa-laptop"></i> <span>Tax Management </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
    <li><a href="<?php echo base_url('merchant/add_tax'); ?>"><i class="fa fa-circle-o"></i> Add New Tax </a></li>
    <li><a href="<?php echo base_url('merchant/tax_list'); ?>"><i class="fa fa-circle-o"></i> Tax List</a></li>
 
    </ul>
    </li>


       <li class="treeview">
    <a href="#">
   <i class="fa fa-laptop"></i> <span>Pos Management </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
    <li><a href="<?php echo base_url('pos/add_pos'); ?>"><i class="fa fa-circle-o"></i> Add New Pos </a></li>
 <li><a href="<?php echo base_url('pos/all_pos'); ?>"><i class="fa fa-circle-o"></i>  List Pos</a></li> 
 
    </ul>
    </li>



       
  <li class="treeview">
    <a href="#">
    <i class="fa fa-wrench"></i>
    <span>Web Management</span>
          <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

<li><a href="<?php echo base_url('merchant/edit_profile'); ?>"><i class="fa fa-circle-o"></i> Update Profile  </a></li>
</ul>
    </li> 
   
    
   </ul>
   
    
    </section>