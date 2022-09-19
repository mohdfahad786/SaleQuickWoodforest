<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Subadmin | Subadmin</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
  <link href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    .reset-dataTable table.dataTable tbody tr.even.selected td:first-child, .reset-dataTable table.dataTable tbody tr.odd.selected td:first-child{
      border-left: #2273dc  !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected, .reset-dataTable table.dataTable tbody tr.odd.selected {
        background-color: #dff4ff !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected td.sorting_1, .reset-dataTable table.dataTable tbody tr.odd.selected td.sorting_1{
      background-color: rgba(0, 136, 0, 0) !important;
    }
  </style>
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <div id="wrapper"> 
    <div class="page-wrapper pos-list invoice-pos-list">     
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title"> 
            <span><?php echo ($meta)?></span>
            <small style="color:red;"><?php echo validation_errors(); ?></small>
          </div>
        </div>
      </div>
      <?php
      if(isset($msg))
        echo "<h4> $msg</h4>";
        // echo form_open('dashboard/'.$loc, array('id' => "my_form"));
      ?>
      <form action="#" id='my_form' method="post" enctype='multipart/form-data' autocomplete="off" >
       <?php 
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
        <div class="row">
          <div class="col-12">
            <div class="card content-card">
              <div class="card-detail recurring__geninfo custom-form">
                <div class="row  responsive-cols f-wrap f-auto">
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Name</label>
                      <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" placeholder="Full Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required="" type="text">
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Email Address <i class="text-danger">*</i></label>
                      <input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text">
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Phone <i class="text-danger">*</i> </label>
                      <input class="form-control" placeholder="Phone" name="mobile" id="mobile" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required type="text">
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <label for="">Password</label>
                      <?php if($loc=='edit_subadmin')  {?> 
                        <input type="hidden" class="form-control" name="password" id="password"    
                        required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password');?>">
                        <input type="password" autocomplete="off" class="form-control" name="cpsw" id="cpsw"  placeholder="Password:"  >
                      <?php } elseif($loc=='create_new_subadmin')  {?>
                        <input type="text" class="form-control" autocomplete="off" name="password" id="password" placeholder="Password"  required >
                      <?php } ?>
                    </div>
                  </div>

                  <div class="col mx-253">
                    <div class="form-group">
                    <label for="">Status</label>
                      <div class="custom-checkbox">
                        <input type="radio" id='activestatus' <?php if( isset($status)  && $status=='active'){ echo 'checked'; } ?>  value="active" name="status" class="radio-circle"> 
                        <label for="activestatus">Active</label>
                        &nbsp;&nbsp;
                        <input type="radio" id='blockstatus'  <?php if( isset($status)  && $status=='block'){ echo 'checked'; } ?>  value="block" name="status"  class="radio-circle"> 
                        <label for="blockstatus">Block</label>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card content-card">
              <div class="card-detail">
                <div class="row custom-form responsive-cols f-wrap f-auto">
                  <div class="col-12">
                    <div class="custom-form">
                      <div class="form-group">
                        <p><b>Merchant Permission</b></p>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <?php if($loc=='edit_subadmin')  {?> 
                        <div class="custom-checkbox">
                          <input type="checkbox" name="edit_permissions" value="1" id="edit_permissions1" <?php if(1 == $edit_permissions){ echo 'checked="checked"'; } ?>>
                          <label for="edit_permissions1">Edit Permissions</label>
                        </div>
                        <input type="hidden" name="view_permissions" value="1" <?php if(1 == $view_permissions){ echo 'checked="checked"'; } ?> >
                      <?php } elseif($loc=='create_new_subadmin')  {?> 
                        <div class="custom-checkbox">
                          <input type="checkbox" name="edit_permissions" value="1" id="edit_permissions2" >
                          <label for="edit_permissions2">Edit Permissions</label>
                        </div>
                        <input type="hidden" name="view_permissions" value="1"     >
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <?php if($loc=='edit_subadmin')  { ?> 
                        <div class="custom-checkbox">
                          <input type="checkbox" name="active_permissions" value="1" id="active_permissions1" <?php if(1 == $active_permissions){ echo 'checked="checked"'; } ?>>
                          <label for="active_permissions1">Active Permissions</label>
                        </div>
                      <?php } elseif($loc=='create_new_subadmin')  {?> 
                        <div class="custom-checkbox">
                          <input type="checkbox" name="active_permissions" value="1" id="active_permissions2" >
                          <label for="active_permissions2">Active Permissions</label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <?php if($loc=='edit_subadmin')  {?> 
                       <div class="custom-checkbox">
                        <input type="checkbox" name="delete_permissions" value="1" id="delete_permissions1" <?php if(1 == $delete_permissions){ echo 'checked="checked"'; } ?>>
                        <label for="delete_permissions1">Delete Permissions</label>
                      </div>
                    <?php } elseif($loc=='create_new_subadmin')  {?> 
                      <div class="custom-checkbox">
                        <input type="checkbox" name="delete_permissions" value="1" id="delete_permissions2" >
                        <label for="delete_permissions2">Delete Permissions</label>
                      </div>
                    <?php } ?>
                    </div>
                  </div>
                  <!-- <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="radio" id='activestatus' <?php if( isset($status)  && $status=='active'){ echo 'checked'; } ?>  value="active" name="status" class="radio-circle"> 
                        <label for="activestatus">Active</label>
                        &nbsp;&nbsp;
                        <input type="radio" id='blockstatus'  <?php if( isset($status)  && $status=='block'){ echo 'checked'; } ?>  value="block" name="status"  class="radio-circle"> 
                        <label for="blockstatus">Block</label>
                      </div>
                    </div>
                  </div> -->
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
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="Funding" <?php if ( isset($view_menu_permissions) && in_array("1d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Funding" value="1d">
                        <label for="Funding">Funding</label>
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
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TInvoice" <?php if ( isset($view_menu_permissions) && in_array("2b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInvoice" value="2b">
                        <label for="TInvoice">Invoicing</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TRecurring" <?php if ( isset($view_menu_permissions) && in_array("2c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="TRecurring" value="2c">
                        <label for="TRecurring">Recurring</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="TRecurringRequest"  <?php if ( isset($view_menu_permissions) && in_array("2d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TRecurringRequest" value="2d">
                        <label for="TRecurringRequest">Recurring Request</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <p><label><b>Email template</b> </label></p>
                  </div>
                  <div class="col mx-253">
                     <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="InvoiceTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="InvoiceTemplate" value="3a">
                        <label for="InvoiceTemplate">Invoice Template</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="Instore_MobileTemplate" <?php if ( isset($view_menu_permissions) && in_array("3b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Instore_MobileTemplate" value="3b">
                        <label for="Instore_MobileTemplate">Instore &  Mobile </label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="ReceiptTemplate" <?php if ( isset($view_menu_permissions) && in_array("3c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ReceiptTemplate" value="3c">
                        <label for="ReceiptTemplate">Receipt</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="RecurringTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RecurringTemplate" value="3d">
                        <label for="RecurringTemplate">Recurring </label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="RegistrationTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3e", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RegistrationTemplate" value="3e">
                        <label for="RegistrationTemplate">Registration</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <p><label><b>Merchant Master</b> </label></p>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="Vie_Merchant" <?php if ( isset($view_menu_permissions) && in_array("4a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Vie_Merchant" value="4a">
                        <label for="Vie_Merchant">View Merchant</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="ViewSubuser" <?php if ( isset($view_menu_permissions) && in_array("4b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ViewSubuser" value="4b">
                        <label for="ViewSubuser">View Sub user</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <p><label><b>Customers</b> </label></p>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="SupportsRequest" <?php if ( isset($view_menu_permissions) && in_array("4c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="SupportsRequest" value="4c">
                        <label for="SupportsRequest">Supports Request</label>
                      </div>
                    </div>
                  </div>
                  <div class="col mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="SaleRequest" <?php if ( isset($view_menu_permissions) && in_array("4d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="SaleRequest" value="4d">
                        <label for="SaleRequest">Sale Request</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                     <p><label><b>Subadmin Master</b> </label></p>
                  </div>
                  <div class="col  mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="CreateSubadmin" <?php if ( isset($view_menu_permissions) && in_array("5a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="CreateSubadmin" value="5a">
                        <label for="CreateSubadmin">Create Subadmin</label>
                      </div>
                    </div>
                  </div>
                  <div class="col  mx-253">
                    <div class="form-group">
                      <div class="custom-checkbox">
                        <input type="checkbox" name="ViewAllSubadmin" <?php if ( isset($view_menu_permissions) && in_array("5b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ViewAllSubadmin" value="5b">
                        <label for="ViewAllSubadmin">View All Subadmin</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
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
            <div class="card content-card">
              <div class="card-detail">
                <div class="row">
                  <div class="col-12">
                    <div class="custom-form" >
                      <div class="form-group">
                        <p><b>Assign Merchants <i class="text-danger">*</i> </b></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="pos-list-dtable reset-dataTable">
                      <table id="example" class="display cell-border" style="width:100%">
                        <thead>
                          <tr>
                           <!-- <th><input name="select_all" value="1" type="checkbox"></th><th>Sr.No.</th> -->
                           <th>Id</th>
                           <th>DBA Name </th>
                           <th>Company Name</th>
                           <th>Status</th> 
                           <th>Email</th>
                           <th>Phone</th>
                         </tr>
                       </thead>
                       <tbody>
                        <?php if($loc=='edit_subadmin')  {
                         if($assign_merchant!="")
                         {
                           $assign_merchantArray=explode(',',$assign_merchant);
                           $lengthOfArray=count($assign_merchantArray);
                           if(count($all_merchantList) > 0 ) {
                                    //print_r($all_merchantList); 
                            $i=1;
                            foreach($all_merchantList as $a_data)
                            {
                              $count++;
                                     // $m=0;
                                     // for($m=0;$m < $lengthOfArray;$m++){
                              ?>
                              <tr class="<?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'selected '.$a_data->id; }?>" >
                                <!-- <td><input type="checkbox" id='checkbox_<?php echo $a_data->id; ?>' <?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'checked'; }?> name="chkstatus[]" value="<?php echo $a_data->id;?>"  ></td>    -->
                                <td><?php echo $a_data->id;?></td>
                                <td><?php echo $a_data->business_dba_name;?></td>
                                <td><?php echo $a_data->business_name;?></td>
                                <?php
                                if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; }
                                ?>
                                <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                <td><?php echo $a_data->email;?></td>
                                <td><?php echo $a_data->business_number;?></td>
                              </tr>
                              <?php $i++;  } }
                            }
                            else
                            {
                              if(count($all_merchantList) > 0 ) {
                                        //print_r($all_merchantList); 
                                $i=1;
                                foreach($all_merchantList as $a_data)
                                {
                                  $count++;
                                  ?>
                                  <tr>
                                    <!-- <td><input type="checkbox" id='checkbox_<?php echo $a_data->id; ?>'  name="chkstatus[]" value="<?php echo $a_data->id;?>"  ></td>    -->
                                    <td><?php echo $a_data->id;?></td>
                                    <td><?php echo $a_data->business_dba_name;?></td>
                                    <td><?php echo $a_data->business_name;?></td>
                                    <?php
                                    if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                    if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                    if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; }
                                    ?>
                                    <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                    <td><?php echo $a_data->email;?></td>
                                    <td><?php echo $a_data->business_number;?></td>
                                  </tr>
                                  <?php $i++;  } }
                                }
                              } elseif($loc=='create_new_subadmin')  {
                                if(count($all_merchantList) > 0 ) {
                                    //print_r($all_merchantList); 
                                  $i=1;
                                  foreach($all_merchantList as $a_data)
                                  {
                                    $count++;
                                    ?>
                                    <tr>
                                      <!-- <td><input type="checkbox" id='checkbox_<?php echo $a_data->id; ?>'  name="chkstatus[]" value="<?php echo $a_data->id;?>"  ></td>    -->
                                      <td><?php echo $a_data->id;?></td>
                                      <td><?php echo $a_data->business_dba_name;?></td>
                                      <td><?php echo $a_data->business_name;?></td>
                                      <?php
                                      if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                      if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                      if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; }
                                      ?>
                                      <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                      <td><?php echo $a_data->email;?></td>
                                      <td><?php echo $a_data->business_number;?></td>
                                    </tr>
                                    <?php $i++;  } }
                                  } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col col-12 mt-4 mb-2">
                    <div style="display:none" id="hideencheckbox"></div>
                    <input type="submit" id="btn_login"   name="submit"   class="btn btn-first pull-right" value="<?php echo $action ?>" />
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  var resizefunc = [];
</script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<!-- Popper for Bootstrap -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script>
<script type="text/javascript">
  $("#Hold_Amount").on("keyup",function(){
    calcaulatHold($(this));
  });
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    var table =$('#example').DataTable({
      dom: 'lBfrtip',
      "order": [[ 4, "desc" ]],
      select: 'multi',
      responsive: true, 
      language: {
        search: '', searchPlaceholder: "Search",
        oPaginate: {
         sNext: '<i class="fa fa-angle-right"></i>',
         sPrevious: '<i class="fa fa-angle-left"></i>',
         sFirst: '<i class="fa fa-step-backward"></i>',
         sLast: '<i class="fa fa-step-forward"></i>'
       },
       buttons: {
        selectAll: "Select all rows",
        selectNone: "Select none"
      }
     }   ,
     buttons: [
     'selectAll',
     'selectNone',      
     ]
   });
// Handle click on checkbox
$('#example tbody').on('click', 'input[type="checkbox"]', function(e){
  var $row = $(this).closest('tr');
// Get row data
var data = table.row($row).data();
// Get row ID
var rowId = data[0];
// Determine whether row ID is in the list of selected row IDs
var index = $.inArray(rowId, rows_selected);
// If checkbox is checked and row ID is not in list of selected row IDs
if(this.checked && index === -1){
  rows_selected.push(rowId);
// Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
} else if (!this.checked && index !== -1){
  rows_selected.splice(index, 1);
}
if(this.checked){
  $row.addClass('selected');
} else {
  $row.removeClass('selected');
}
// Update state of "Select all" control
updateDataTableSelectAllCtrl(table);
// Prevent click event from propagating to parent
e.stopPropagation();
});
// Handle click on "Select all" control
$('thead input[name="select_all"]', table.table().container()).on('click', function(e){
  if(this.checked){
    $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
  } else {
    $('#example tbody input[type="checkbox"]:checked').trigger('click');
  }
// Prevent click event from propagating to parent
e.stopPropagation();
});
} );
function updateDataTableSelectAllCtrl(table){
  var $table             = table.table().node();
  var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
  var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
  var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);
  // If none of the checkboxes are checked
  if($chkbox_checked.length === 0){
    chkbox_select_all.checked = false;
    if('indeterminate' in chkbox_select_all){
      chkbox_select_all.indeterminate = false;
    }
  // If all of the checkboxes are checked
  } else if ($chkbox_checked.length === $chkbox_all.length){
    chkbox_select_all.checked = true;
    if('indeterminate' in chkbox_select_all){
      chkbox_select_all.indeterminate = false;
    }
  // If some of the checkboxes are checked
  } else {
    chkbox_select_all.checked = true;
    if('indeterminate' in chkbox_select_all){
      chkbox_select_all.indeterminate = true;
    }
  }
}
var rows_selected = [];
function validate(form) {
// validation code here ...
if(rows_selected.length==0) {  alert('Please select checkbox'); return false;}
else { 
  console.log("Hello");
  $("#hideencheckbox").html(''); 
     $.each(rows_selected, function(index, rowId){ // Create a hidden element
       $("#hideencheckbox").append($(rowId).attr("checked","checked"));      
     });
    //return confirm('Do you really want to submit the form?');
  }
}
$('#btn_login').click( function(event) {
  event.preventDefault();
  var table = $('#example').DataTable(); 
  var Rowarray=Array();
  Rowarray=table.rows( { selected: true } ).data();
  var datanew="";
  if(Rowarray.length)
  {
    for(var z=0; z <Rowarray.length; z++ )
    {
      datanew+='&chkstatus[]='+Rowarray[z][0];
    }
  }else{datanew+='&chkstatus[]=';}
  console.log(datanew);
  console.log(Rowarray); 
  console.log(Rowarray); 
  if($('#btn_login').val()=='Update Subadmin')
    { var callUrl='subadmin/update_subadmin'; }
  else if($('#btn_login').val()=='Create New Subadmin')
    { var callUrl='subadmin/create_th'; }
  console.log($('#my_form').serialize()+ datanew); 
  $.ajax({
        url: '<?php echo base_url();?>'+callUrl, //  create_new_subadmin
        type: 'post',
        //dataType: 'json',
        data: $('#my_form').serialize()+datanew,
        success: function(data) {
         if(data=='200')
         {
            // $('small').html('Success');
          window.location.replace('<?php echo base_url('subadmin/all_subadmin'); ?>');
          }
          else
          {
             $('small').html(data); 
           }
           console.log(data); 
           },
           error :function()
           {
            //alert('error'); 
            console.log('Error'); 
          }
        });
});
<?php 
  if(isset($assign_merchant))
  {
    $assign_merchantArray=explode(',',$assign_merchant);
    $jsondata=json_encode($assign_merchantArray); 
  }
  else
  {
    $assign_merchantArray=array();
    $jsondata=json_encode($assign_merchantArray); 
  }
?>
$(document).ready(function() {
  var table = $('#example').DataTable();
  //  table.rows( ['.select'] ).select();
  var json='<?php echo $jsondata; ?>';
  obj = JSON.parse(json);
  var JsArray=Array();
  JsArray=JSON.stringify();
  table.rows().every (function (rowIdx, tableLoop, rowLoop) {
  if ($.inArray(this.data()[0],obj)>-1 ) {
    this.select ();
  }
  });
  //   console.log(obj); 
  //   for(var t=0; t < obj.length; t++)
  //   {
  //      table.data().row('".'+obj[t]+'"').select();
  //   }
  // console.log("HI"); 
  //$('#example tbody tr').toggleClass('selected');
  //table.data().row(58).select();
});
</script>
</body>
</html>