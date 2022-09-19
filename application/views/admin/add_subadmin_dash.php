<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
    label {
        font-weight: 100 !important;
    }
    .head_label {
        font-size: 18px !important;
        font-weight: 600 !important;
    }
    .menu_label {
        font-weight: 600 !important;
    }
    .menu_form_group{
        margin-bottom: 0.5rem !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected td:first-child, .reset-dataTable table.dataTable tbody tr.odd.selected td:first-child {
        border-left: #2273dc  !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected, .reset-dataTable table.dataTable tbody tr.odd.selected {
        background-color: #e2e2f7 !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected:hover,
    .reset-dataTable table.dataTable tbody tr.odd.selected:hover {
        background-color: #e2e2f7 !important;
    }
    .table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th, .table>tbody>tr.active>td, .table>tbody>tr.active>th, .table>tbody>tr>td.active, .table>tbody>tr>th.active, .table>tfoot>tr.active>td, .table>tfoot>tr.active>th, .table>tfoot>tr>td.active, .table>tfoot>tr>th.active, .table>thead>tr.active>td, .table>thead>tr.active>th, .table>thead>tr>td.active, .table>thead>tr>th.active {
        background-color: #e2e2f7 !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected td.sorting_1, .reset-dataTable table.dataTable tbody tr.odd.selected td.sorting_1{
        background-color: rgba(0, 136, 0, 0) !important;
    }
    .btn.btn-xs {
        padding: 7px 10px !important;
    }
    .reset-dataTable table.dataTable thead tr {
        background-color: #fff !important;
    }
    .dataTables_length label {
        display: block !important;
    }
    .modal-body {
        color: black !important;
        font-size: 15px !important;
        font-family: AvenirNext-Medium !important;
    }
    .modal-header {
        border-bottom: 1px solid #fff !important;
    }
    div.dt-buttons {
        display: block !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        width: 250px !important;
        height: 42px!important;
        color: #4a4a4a;
        -webkit-box-shadow: 0 0;
        box-shadow: 0 0;
        padding-right: 35px;
        padding-left: 15px;
        border-color: #e1e6ea;
        font-weight: normal;
        border-radius: 3px;
        background-repeat: no-repeat;
        background-size: 15px;
        background-position: right 15px center;
        border: none;
        border-radius: 5px;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom"></div>
            </div>

            <form action="#" id='my_form' method="post" enctype='multipart/form-data' autocomplete="off" >
                <?php echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                if(isset($view_menu_permissions) && $view_menu_permissions!="") {
                    $view_menu_permissions_Array=explode(',',$view_menu_permissions); 
                } else {
                    $view_menu_permissions_Array=array();
                } ?>
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-title"><?php echo ($meta)?></div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" placeholder="Full Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required="" type="text">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Email Address <i class="text-danger">*</i></label>
                                                    <input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Phone <i class="text-danger">*</i> </label>
                                                    <input class="form-control" placeholder="Phone" name="mobile" id="mobile" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required type="text">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <?php if($loc=='edit_subadmin') { ?> 
                                                        <input type="hidden" class="form-control" name="password" id="password" required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password');?>">
                                                        <input type="password" autocomplete="off" class="form-control" name="cpsw" id="cpsw"  placeholder="Password">
                                                    <?php } elseif($loc=='create_new_subadmin')  {?>
                                                        <input type="text" class="form-control" autocomplete="off" name="password" id="password" placeholder="Password"  required>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label for="">Status</label>
                                            <div class="custom-checkbox">
                                                <input type="radio" id='activestatus' <?php if( isset($status)  && $status=='active'){ echo 'checked'; } ?> value="active" name="status" class="radio-circle"> 
                                                <label for="activestatus">Active</label>
                                                &nbsp;&nbsp;
                                                <input type="radio" id='blockstatus' <?php if( isset($status)  && $status=='block'){ echo 'checked'; } ?> value="block" name="status" class="radio-circle"> 
                                                <label for="blockstatus">Block</label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="head_label" for="">Merchant Permission</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <?php if($loc=='edit_subadmin') { ?>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="edit_permissions" value="1" id="edit_permissions1" <?php if(1 == $edit_permissions){ echo 'checked="checked"'; } ?>>
                                                    <label for="edit_permissions1">Edit Permissions</label>
                                                </div>
                                                <input type="hidden" name="view_permissions" value="1" <?php if(1 == $view_permissions){ echo 'checked="checked"'; } ?> >
                                            <?php } elseif($loc=='create_new_subadmin') { ?> 
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="edit_permissions" value="1" id="edit_permissions2" >
                                                    <label for="edit_permissions2">Edit Permissions</label>
                                                </div>
                                                <input type="hidden" name="view_permissions" value="1">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <?php if($loc=='edit_subadmin') { ?>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="active_permissions" value="1" id="active_permissions1" <?php if(1 == $active_permissions){ echo 'checked="checked"'; } ?>>
                                                    <label for="active_permissions1">Active Permissions</label>
                                                </div>
                                            <?php } elseif($loc=='create_new_subadmin') { ?>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="active_permissions" value="1" id="active_permissions2" >
                                                    <label for="active_permissions2">Active Permissions</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <?php if($loc=='edit_subadmin') { ?>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="delete_permissions" value="1" id="delete_permissions1" <?php if(1 == $delete_permissions){ echo 'checked="checked"'; } ?>>
                                                    <label for="delete_permissions1">Delete Permissions</label>
                                                </div>
                                            <?php } elseif($loc=='create_new_subadmin') { ?>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="delete_permissions" value="1" id="delete_permissions2" >
                                                    <label for="delete_permissions2">Delete Permissions</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="head_label" for="">Menu Permission</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Dashboard</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="Dashboard" <?php if ( isset($view_menu_permissions) && in_array("1a", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="Dashboard" value="1a">
                                                <label for="Dashboard">Dashboard</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="TransactionSummary" <?php if ( isset($view_menu_permissions) && in_array("1b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TransactionSummary" value="1b">
                                                <label for="TransactionSummary">Transaction Summary</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="SalesTrends" <?php if ( isset($view_menu_permissions) && in_array("1c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="SalesTrends" value="1c">
                                                <label for="SalesTrends">Sales Trends </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="Funding" <?php if ( isset($view_menu_permissions) && in_array("1d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Funding" value="1d">
                                                <label for="Funding">Funding</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Transaction</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                       <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="TInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("2a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInstoreMobile" value="2a">
                                          <label for="TInstoreMobile">Instore &amp; Mobile</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="TInvoice" <?php if ( isset($view_menu_permissions) && in_array("2b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInvoice" value="2b">
                                          <label for="TInvoice">Invoicing</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="TRecurring" <?php if ( isset($view_menu_permissions) && in_array("2c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="TRecurring" value="2c">
                                          <label for="TRecurring">Recurring</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="TRecurringRequest"  <?php if ( isset($view_menu_permissions) && in_array("2d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TRecurringRequest" value="2d">
                                          <label for="TRecurringRequest">Recurring Request</label>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Email Template</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                       <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="InvoiceTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="InvoiceTemplate" value="3a">
                                          <label for="InvoiceTemplate">Invoice Template</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="Instore_MobileTemplate" <?php if ( isset($view_menu_permissions) && in_array("3b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Instore_MobileTemplate" value="3b">
                                          <label for="Instore_MobileTemplate">Instore &  Mobile </label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="ReceiptTemplate" <?php if ( isset($view_menu_permissions) && in_array("3c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ReceiptTemplate" value="3c">
                                          <label for="ReceiptTemplate">Receipt</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="RecurringTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RecurringTemplate" value="3d">
                                          <label for="RecurringTemplate">Recurring </label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="RegistrationTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3e", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RegistrationTemplate" value="3e">
                                          <label for="RegistrationTemplate">Registration</label>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Merchant Master</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="Vie_Merchant" <?php if ( isset($view_menu_permissions) && in_array("4a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Vie_Merchant" value="4a">
                                          <label for="Vie_Merchant">View Merchant</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="ViewSubuser" <?php if ( isset($view_menu_permissions) && in_array("4b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ViewSubuser" value="4b">
                                          <label for="ViewSubuser">View Sub user</label>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Customers</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="SupportsRequest" <?php if ( isset($view_menu_permissions) && in_array("4c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="SupportsRequest" value="4c">
                                          <label for="SupportsRequest">Supports Request</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="SaleRequest" <?php if ( isset($view_menu_permissions) && in_array("4d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="SaleRequest" value="4d">
                                          <label for="SaleRequest">Sale Request</label>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Subadmin Master</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="CreateSubadmin" <?php if ( isset($view_menu_permissions) && in_array("5a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="CreateSubadmin" value="5a">
                                          <label for="CreateSubadmin">Create Subadmin</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                      <div class="form-group">
                                        <div class="custom-checkbox">
                                          <input type="checkbox" name="ViewAllSubadmin" <?php if ( isset($view_menu_permissions) && in_array("5b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ViewAllSubadmin" value="5b">
                                          <label for="ViewAllSubadmin">View All Subadmin</label>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group menu_form_group">
                                            <label class="menu_label" for="">Settings <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
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
                </div>

                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="">Assign Merchants <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-12">
                                        <div class="pos-list-dtable reset-dataTable">
                                            <table id="example" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>DBA Name</th>
                                                        <th>Company Name</th>
                                                        <th>Status</th> 
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($loc=='edit_subadmin') {
                                                        if($assign_merchant!="") {
                                                            $assign_merchantArray=explode(',',$assign_merchant);
                                                            $lengthOfArray=count($assign_merchantArray);
                                                            if(count($all_merchantList) > 0) {
                                                                $i=1;
                                                                foreach($all_merchantList as $a_data) {
                                                                    $count++; ?>
                                                                    <tr class="<?php if(in_array($a_data->id, $assign_merchantArray)) { echo 'selected '.$a_data->id; } ?>">
                                                                        <td><?php echo $a_data->id;?></td>
                                                                        <td><?php echo $a_data->business_dba_name;?></td>
                                                                        <td><?php echo $a_data->business_name;?></td>

                                                                        <?php
                                                                        if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                                                        if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                                                        if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; } ?>
                                                                        <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                                                        <td><?php echo $a_data->email;?></td>
                                                                        <td><?php echo $a_data->business_number;?></td>
                                                                    </tr>
                                                                    <?php $i++;
                                                                }
                                                            }
                                                        } else {
                                                            if(count($all_merchantList) > 0) {
                                                                $i=1;
                                                                foreach($all_merchantList as $a_data) {
                                                                    $count++; ?>
                                                                    <tr>
                                                                        <td><?php echo $a_data->id;?></td>
                                                                        <td><?php echo $a_data->business_dba_name;?></td>
                                                                        <td><?php echo $a_data->business_name;?></td>

                                                                        <?php
                                                                        if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                                                        if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                                                        if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; } ?>
                                                                        <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                                                        <td><?php echo $a_data->email;?></td>
                                                                        <td><?php echo $a_data->business_number;?></td>
                                                                    </tr>
                                                                    <?php $i++;
                                                                }
                                                            }
                                                        }

                                                    } elseif($loc=='create_new_subadmin') {
                                                        if(count($all_merchantList) > 0 ) {
                                                            $i=1;
                                                            foreach($all_merchantList as $a_data) {
                                                                $count++; ?>
                                                                <tr>
                                                                    <td><?php echo $a_data->id;?></td>
                                                                    <td><?php echo $a_data->business_dba_name;?></td>
                                                                    <td><?php echo $a_data->business_name;?></td>

                                                                    <?php
                                                                    if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                                                    if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                                                    if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; } ?>
                                                                    <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                                                    <td><?php echo $a_data->email;?></td>
                                                                    <td><?php echo $a_data->business_number;?></td>
                                                                </tr>
                                                                <?php $i++;
                                                            }
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px !important;">
                            <div class="col-12">
                                <div style="display:none" id="hideencheckbox"></div>
                                <input type="submit" id="btn_login" name="submit" class="btn btn-first pull-right" value="<?php echo $action ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="message_popup_error" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body error_message"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#mobile').keypress(function(event){
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault(); //stop character from entering input
        }
    });
    
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
            },
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
    });

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
        if(rows_selected.length==0) {
            alert('Please select checkbox'); return false;
        } else {
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
        if(Rowarray.length) {
            for(var z=0; z <Rowarray.length; z++ ) {
                datanew+='&chkstatus[]='+Rowarray[z][0];
            }
        } else {
            datanew+='&chkstatus[]=';
        }
        // console.log(datanew);
        // console.log(Rowarray); 
        // console.log(Rowarray); 
        if($('#btn_login').val()=='Update Subadmin') {
            var callUrl='dashboard/update_subadmin';
        } else if($('#btn_login').val()=='Create New Subadmin') {
            var callUrl='dashboard/create_th';
        }
        // console.log($('#my_form').serialize()+ datanew); 
        $.ajax({
            url: '<?php echo base_url();?>'+callUrl, //  create_new_subadmin
            type: 'post',
            //dataType: 'json',
            data: $('#my_form').serialize()+datanew,
            success: function(data) {
                // console.log(data);return false;
                var data = JSON.parse(data);
                var status = data.status;
                var message = data.message;
                if(status.trim()=='200') {
                    // $('small').html('Success');
                    window.location.replace('<?php echo base_url('dashboard/all_subadmin?success='); ?>'+message);
                } else {
                    // $('small').html(data);
                    $('.modal .error_message').html(message);
                    $("#message_popup_error").modal('show');
                    return false;
                }
                // console.log(data); 
            },
            error: function() {
                //alert('error'); 
                console.log('Error'); 
            }
        });
    });

    <?php if(isset($assign_merchant)) {
        $assign_merchantArray=explode(',',$assign_merchant);
        $jsondata=json_encode($assign_merchantArray); 
    } else {
        $assign_merchantArray=array();
        $jsondata=json_encode($assign_merchantArray); 
    } ?>

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
    });
</script>

<?php include_once'footer_button_dash.php'; ?>