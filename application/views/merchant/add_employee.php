<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>
<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper update-emp">    
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title">
            <span class="material-icons"> arrow_back</span> <span><?php echo ($meta)?></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              <?php
                if(isset($msg))
                echo "<h5> $msg</h5>";
                echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=>"row"));
                echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
				
				       if(isset($view_menu_permissions) && $view_menu_permissions!="")
       {
         $view_menu_permissions_Array=explode(',',$view_menu_permissions); 
       }
       else
       {
        $view_menu_permissions_Array=array();
      }
              ?>
                <div class="col-12 pos_Status_cncl">
                  <?php echo validation_errors(); ?>
                </div>
               
              <!-- <div class="row"> -->
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Email </label>
                      <input type="email" class="form-control"  <?php if($loc=='edit_employee')  {  echo 'readonly'; } ?> name="email" id="email" pattern="[ a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email:"  value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
                    </div>
                    <div class="form-group">
                      <label for="">User Name</label>
                      <input type="text" class="form-control" name="name" id="name"  placeholder="Name:"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form" >
                    <div class="form-group">
                      <label for="">Phone number</label>
                      <input type="text" class="form-control" name="mobile" id="phone" onkeypress="return isNumberKey(event)" placeholder="Mobile No :" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required="">
                    </div>
                    <div class="form-group" >
                      <label for="">Update Password</label>
                      <?php if($loc=='edit_employee')  {?> 
                        <input type="hidden" class="form-control" name="password" id="password"  placeholder="Password:"  required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password');?>">
                        <input type="password" class="form-control" name="cpsw" id="cpsw"  placeholder="Change Password:"  >
                      <?php
                      } 
                      elseif($loc=='add_employee')  {
                      ?>
                        <input type="text" class="form-control" name="password" id="password"  placeholder="Password:"  required >
                      <?php } ?>
                    </div>
                  </div>      
                </div>
                <?php if($loc=='edit_employee')  {?>  
                  <div class="col-12">
                    <div class="custom-form" >
                      <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-control"  name="status" id="status" required="">
                          <option value="active" <?php if($status=='active'){ echo 'selected'; } ?> > Active </option>
                          <option value="block" <?php if($status=='block'){ echo 'selected'; } ?> > Block </option>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php } ?>
				
				
				
				<div class="col-12" style="display:none;">
            <div class="card content-card">
              <div class="card-detail">
                <div class="row custom-form responsive-cols f-wrap f-auto">
                  <div class="col-12">
                    <div class="custom-form">
                      <div class="form-group">
                        <p><b>Payment Mode</b></p>
                      </div>
                    </div>
                  </div>
				  
				  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="ViewPermissions" <?php if ( isset($view_menu_permissions) && in_array("12a", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="ViewPermissions" value="12a">
                        <label for="ViewPermissions">View Permissions</label>
                      </div>
                    </div>
                  </div>
				  
				  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="AddPermissions" <?php if ( isset($view_menu_permissions) && in_array("12b", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="AddPermissions" value="12b">
                        <label for="AddPermissions">Add Permissions</label>
                      </div>
                    </div>
                  </div>
				  
				  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="EditPermissions" <?php if ( isset($view_menu_permissions) && in_array("12c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="EditPermissions" value="12c">
                        <label for="EditPermissions">Edit Permissions</label>
                      </div>
                    </div>
                  </div>
				  
				  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="DeletePermissions" <?php if ( isset($view_menu_permissions) && in_array("12d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="DeletePermissions" value="12d">
                        <label for="DeletePermissions">Delete Permissions</label>
                      </div>
                    </div>
                  </div>
				  
				 
				
                  
                </div>
              </div>
            </div>
          </div>
				
				
				
				
				<div class="col-12">
            <div class="card content-card">
              <div class="card-detail custom-form">
                <div class="row">
                  <div class="col-12">
                    <div class="custom-form">
                      <div class="form-group">
                        <p><b>Menu Permission</b></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <p> <label><b>Dashboard</b> </label></p>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="Dashboard" <?php if ( isset($view_menu_permissions) && in_array("1a", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="Dashboard" value="1a">
                        <label for="Dashboard">Dashboard</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TransactionSummary" <?php if ( isset($view_menu_permissions) && in_array("1b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TransactionSummary" value="1b">
                        <label for="TransactionSummary">Transaction Summary</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="SalesTrends" <?php if ( isset($view_menu_permissions) && in_array("1c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="SalesTrends" value="1c">
                        <label for="SalesTrends">Sales Trends </label>
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-12">
                     <p><label><b>Transaction</b> </label></p>
                  </div>
                  <div class="col mx-253">
                     <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("2a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInstoreMobile" value="2a">
                        <label for="TInstoreMobile">Instore &amp; Mobile</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253" style="display:none;">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TInvoice" <?php if ( isset($view_menu_permissions) && in_array("2b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInvoice" value="2b">
                        <label for="TInvoice">Invoicing</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253" style="display:none;">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TRecurring" <?php if ( isset($view_menu_permissions) && in_array("2c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="TRecurring" value="2c">
                        <label for="TRecurring">Recurring</label>
                      </div>
                    </div>
                  </div>
                 
                </div>
                <div class="row">
                  <div class="col-12">
                    <p><label><b>Invoice/Virtual Terminal</b> </label></p>
                  </div>
                  <div class="col mx-253">
                     <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="VirtualTerminal"  <?php if ( isset($view_menu_permissions) && in_array("3a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="VirtualTerminal" value="3a">
                        <label for="VirtualTerminal">Virtual Terminal</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="IInvoicing" <?php if ( isset($view_menu_permissions) && in_array("3b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="IInvoicing" value="3b">
                        <label for="IInvoicing">Invoicing</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="IRecurring" <?php if ( isset($view_menu_permissions) && in_array("3c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="IRecurring" value="3c">
                        <label for="IRecurring">Recurring</label>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="row" style="display:none;">
                  <div class="col-12">
                    <p><label><b>Refund</b> </label></p>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="RInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("4a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RInstoreMobile" value="4a">
                        <label for="RInstoreMobile">Instore & Mobile</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="RInvoice" <?php if ( isset($view_menu_permissions) && in_array("4b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RInvoice" value="4b">
                        <label for="RInvoice">Invoice</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" >
                  <div class="col-12">
                    <p><label><b>Inventory</b> </label></p>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="ItemsManagement" <?php if ( isset($view_menu_permissions) && in_array("4c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ItemsManagement" value="4c">
                        <label for="ItemsManagement">Items Management</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="Reports" <?php if ( isset($view_menu_permissions) && in_array("4d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="Reports" value="4d">
                        <label for="Reports">Reports</label>
                      </div>
                    </div>
                  </div>
                </div>
				
				  <div class="row" style="display:none;">
                  <div class="col-12">
                    <p><label><b>Settings  <i class="text-danger">*</i> </b> </label></p>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" checked="" <?php if ( isset($view_menu_permissions) && in_array("6", $view_menu_permissions_Array)) { echo 'checked'; }?>  name="Settings" id="Settings" value="6">
                        <label for="Settings">Settings</label>
                      </div>
                    </div>
                  </div>
                </div>
 
               
              </div>
            </div>
          </div>
				
				
				
				
				
				
				
				
				
				
				
                <div class="col-12">
                  <div class="custom-form" >
                    <div class="form-group">
                      <input type="submit" id="btn_login" name="submit"  class="btn btn-first pull-right" value="<?php echo $action ?>" />
                      <!-- <button class="btn btn-first pull-right">Add New Employee</button> -->
                    </div>
                  </div>
                </div>
              <?php echo form_close(); ?> 
              <!-- </div> -->
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
<!-- End Page Content -->
<?php
include_once'footer_new.php';
?>
