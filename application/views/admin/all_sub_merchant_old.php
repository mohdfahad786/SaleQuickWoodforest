<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
<meta name="author" content="Coderthemes">
<link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
<title>Admin | Dashboard</title>
<!-- DataTables -->
<link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?php echo base_url('datatable'); ?>/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('datatable'); ?>/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
<style>

.form-control {
  
    text-transform: none;
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
</head>
<body class="fixed-left">
<!-- Begin page -->
<div id="wrapper"> 
  
  <!-- Top Bar Start -->
  
  <?php $this->load->view('admin/top'); ?>
  
  <!-- Top Bar End --> 
  
  <!-- ========== Left Sidebar Start ========== -->
  
  <?php $this->load->view('admin/menu'); ?>
  
  <!-- ============================================================== --> 
  
  <!-- Start right Content here --> 
  
  <!-- ============================================================== -->
  
  <div class="content-page"> 
    
    <!-- Start content -->
    
    <div class="content">
      <div class="container-fluid">
        <div class="col-md-12">
          <h2 class="m-b-20">View All Sub User</h2>
        </div>
      </div>
      <div class="card-box">
        <form method="post" action="<?php echo base_url('dashboard/all_sub_merchant');?>" >
          <div class="row">
            <div class="col-md-4 form-group">
              <select class="form-control"  name="status" id="status">
                <option value="">Select Status</option>
                <option value="pending">Pending</option>                
                <!--<option value="Activate_Details"> Activate Details</option>-->
                <!--<option value="Waiting_For_Approval">Waiting For Approval</option>-->
                <!--<option value="confirm">Confirm</option>-->
                <option value="active">Active</option>
                <option value="block">Block</option>
              </select>
              <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span> </div>
            <div class="col-sm-6 form-group">
              <div class="input-daterange input-group" id="date-range">
                <input class="form-control" name="start_date" type="text" autocomplete="off"  placeholder="Select Start Date">
                <span class="input-group-addon bg-primary b-0 text-white" style="background-color: #3bafda !important;">to</span>
                <input class="form-control" name="end_date" type="text" autocomplete="off"  placeholder="Select End Date">
              </div>
            </div>
            <div class="col-md-2 form-group"> 
              
              <!--  <input type="submit" name="mysubmit" class="btn btn-primary " value="Search" />  -->
              
              <button class="btn btn-primary " type="submit" name="mysubmit" value="Search" ><i class=" ti-search"></i> Search</button>
            </div>
          </div>
        </form>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card-box table-responsive">
            <?php
$count = 0;
if(isset($msg))
echo $msg;
?>
            <div class="table-rep-plugin">
              <div class="table-responsive" data-pattern="priority-columns"> 
                
                <!--   <h4 class="m-t-0 header-title"><b>data table</b></h4> -->
                
                <table id="datatable" class="table table-bordered">
                  <thead>
                    <tr>
                        <th style="display: none;">Sr.No.</th>
                      <th> Name </th>
                      <th> Email </th>
                      <th>Sub User ID</th>
                       <th>Merchant ID</th>
                       <th>Merchant DBA</th>
                      <th>Account Status</th>
                      <th align="center"> Account Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$i=1;
  foreach($mem as $key=>$a_data)
{
$count++;
 
  ?>
                    <tr>
                          <td style="display: none;"> <?php echo $i; ?></td> 
                      <td><?php echo $a_data['name'] ?></td>
                      <td><?php echo $a_data['email'] ?></td>
                      <td><?php echo $a_data['id'] ?></td>
                       <td><?php echo $a_data['merchant_id'] ?></td>
                       <td><?php echo $a_data['dba_name'] ?></td>
                      <td><?php echo $a_data['status'] ?></td>
                      <td>
                       <!--  <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="btn btn-sm btn-info"><i class=" ti-eye "></i> Payment Detail</button> -->

                        <button data-toggle="modal" data-target="#view-modall" data-id="<?php echo $a_data['id'];  ?>" id="getcredt" class="btn btn-sm btn-info"><i class=" ti-eye "></i> Credentials</button>

                       <!--  <button data-toggle="modal" onClick="viewDetails(<?php echo $key;  ?>)" data-target="#view-ActivationDetails" data-id="<?php echo $key;  ?>" id="activationDetails" class="<?php echo ($a_data['status']=='Waiting_For_Approval')?"highliter":""?> btn btn-sm btn-info"><i class=" ti-eye "></i> Activation Details</button> -->

                       
                      
                        <!--<a class="btn btn-sm btn-warning" id="edit-bt" href="<?php  echo base_url('dashboard/update_merchant/' . $a_data['id']) ?>"><i class="fa fa-pencil"></i> </a>-->
                        <!--<button class="btn btn-sm btn-danger" onclick="merchant_delete(<?php echo $a_data['id'];?>)"><i class="fa fa-trash"></i></button>-->
                        </td>
                    </tr>
                    <?php $i++;}?>
                  </tbody>
                </table>
              </div>
            </div>
            <div id="view-modall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Sub User CR credentials </h4>
                  </div>
                  <div class="modal-body">
                    <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> </div>
                    
                    <!-- content will be load here -->
                    
                    <div id="dynamic-content1">
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Connection ID</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <input type="text" class="form-control"  name="connection_id" id="connection_id"   placeholder="Connection ID:" 
                 >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">API Key</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="api_key" id="api_key"  placeholder="API Key" 
                 >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Auth Code</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="auth_code" id="auth_code"  placeholder="Auth Code" >
                              <input type="hidden" class="form-control" id="m_id">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Min Shop Supply Value</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="min_shop_supply" id="min_shop_supply"  placeholder="Min Shop Supply Value" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Max Shop Supply Value</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="max_shop_supply" id="max_shop_supply"  placeholder="Max Shop Supply Value" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Shop Supply Percent</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="shop_supply_percent" id="shop_supply_percent"  placeholder="Shop Supply Percent" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Protractor Tax Percent</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="protractor_tax_percent" id="protractor_tax_percent"  placeholder="Protractor Tax Percent" >
                            </div>
                          </div>
                        </div>
                      </div>


 <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">B Code</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="b_code" id="b_code"  placeholder="B Code" >
                            </div>
                          </div>
                        </div>
                      </div>

 <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">D Code</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="d_code" id="d_code"  placeholder="D Code" >
                            </div>
                          </div>
                        </div>
                      </div>

 <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T Code</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t_code" id="t_code"  placeholder="T Code" >
                            </div>
                          </div>
                        </div>
                      </div>
                      
             <div class="col-md-10">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">URL_CR</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="url_cr" id="url_cr"  placeholder="URL_CR" >
                            </div>
                          </div>
                        </div>
                      </div>
                      
                       <div class="col-md-10">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Username_CR</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="username_cr" id="username_cr"  placeholder="Username_CR" >
                            </div>
                          </div>
                        </div>
                      </div>
                      
                       <div class="col-md-10">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Password_CR</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="password_cr" id="password_cr"  placeholder="Password_CR" >
                            </div>
                          </div>
                        </div>
                      </div>
                      
                       <div class="col-md-10">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">Api_Key_CR</label>
                          <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="api_key_cr" id="api_key_cr"  placeholder="Api_Key_CR" >
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      
                      


      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T1</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t1_code_name" id="t1_code_name"  placeholder="T1 Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t1_code_value" id="t1_code_value"  placeholder="T1 Value" >
                            </div>
                          </div>

                        </div>
                      </div>
            
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T1 value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t1_max_value" id="t1_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t1_min_value" id="t1_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T1 value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t1_fixed" id="t1_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T2</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t2_code_name" id="t2_code_name"  placeholder="T2 Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t2_code_value" id="t2_code_value"  placeholder="T2 Value" >
                            </div>
                          </div>

                        </div>
                      </div>
            
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T2 value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t2_max_value" id="t2_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t2_min_value" id="t2_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T2 value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t2_fixed" id="t2_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>
            
             <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T3</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t3_code_name" id="t3_code_name"  placeholder="T3 Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t3_code_value" id="t3_code_value"  placeholder="T3 Value" >
                            </div>
                          </div>

                        </div>
                      </div>
            
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T3 value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t3_max_value" id="t3_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t3_min_value" id="t3_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">T3 value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="t3_fixed" id="t3_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>
                      

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">A</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="a_code_name" id="a_code_name"  placeholder="A Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="a_code_value" id="a_code_value"  placeholder="A Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">A value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="a_max_value" id="a_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="a_min_value" id="a_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">A value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="a_fixed" id="a_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>




         <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">C</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="c_code_name" id="c_code_name"  placeholder="C Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="c_code_value" id="c_code_value"  placeholder="C Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">C value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="c_max_value" id="c_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="c_min_value" id="c_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">C value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="c_fixed" id="c_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>


         <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">E</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="e_code_name" id="e_code_name"  placeholder="E Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="e_code_value" id="e_code_value"  placeholder="E Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">E value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="e_max_value" id="e_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="e_min_value" id="e_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">E value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="e_fixed" id="e_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>


         <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">F</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="f_code_name" id="f_code_name"  placeholder="F Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="f_code_value" id="f_code_value"  placeholder="F Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">F value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="f_max_value" id="f_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="f_min_value" id="f_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">F value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="f_fixed" id="f_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                               <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">G</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="g_code_name" id="g_code_name"  placeholder="G Name" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="g_code_value" id="g_code_value"  placeholder="G Value" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">G value(Max/Min)</label>
                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="g_max_value" id="g_max_value"  placeholder="Max value" >
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="g_min_value" id="g_min_value"  placeholder="Min Value" >
                            </div>
                          </div>

                          

                        </div>
                      </div>
                      

                           <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">G value(Fixed)</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="g_fixed" id="g_fixed"  placeholder="Fixed Value" >
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">TerminalID_CNP</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                    <input type="text" class="form-control" autocomplete="off"   name="terminal_id" id="terminal_id"  placeholder="Terminal ID" >
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">AccountID_CNP</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                    <input type="text" class="form-control" autocomplete="off"   name="account_id" id="account_id"  placeholder="AccountID" >
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">AccountToken_CNP</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="account_token" id="account_token"  placeholder="AccountToken" >
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">ApplicationID_CNP</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="application_id" id="application_id"  placeholder="ApplicationID" >
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="col-md-10" style="display: none;">
                        <div class="form-group row">
                          <label class="col-md-4 col-form-label">AcceptorID_CNP</label>
                          

                           <div class="col-md-8">
                            <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                              <input type="text" class="form-control" autocomplete="off"   name="acceptor_id" id="acceptor_id"  placeholder="AcceptorID" >
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="modal-footer"> 
                    
                    <!--   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    
                    <button type="submit" name="submit" id="mysubmit" class="btn btn-primary waves-effect waves-light  btn-lg btn-lgs " data-dismiss="modal" >Update</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.modal -->
            
            <div id="view-ActivationDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Activation Details </h4>
                  </div>
                  <div class="modal-body">
                    <div id="activation_modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> </div>
                    
                    <!-- content will be load here -->
                    
                    <div id="activation_dynamic-content1">
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-centered" >
                          <div class="col-lg-6 col-md-6 col-sm-12 pull-left" >                            
                            
                            <div class="form-group ">
                              <label ><strong>Business Service:</strong></label>
                              <span id="business_service"></span> </div>
                           
                            <div class="form-group ">
                              <label><strong>Business website:</strong></label>
                              <span id="website"></span> </div>
                            <div class="form-group ">
                              <label><strong>Business Phone Number:</strong></label>
                              <span id="business_number"></span> </div>
                            <div class="form-group ">
                              <label><strong>Years in Business:</strong></label>
                              <span id="year_business"></span> </div>
                            <div class="form-group ">
                              <label><strong>Estimated monthly processing volume::</strong></label>
                              <span id="monthly_processing_volume"></span> </div>
                            <div class="form-group ">
                              <label><strong>Legal Name of business:</strong></label>
                              <span id="business_name"></span> </div>
                            <div class="form-group ">
                              <label ><strong> DBA Name:</strong></label>
                              <span id="business_dba_name"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Type of Business:</strong></label>
                              <span id="business_type"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Employer Identification Number (EIN):</strong></label>
                              <span id="ien_no"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Street:</strong></label>
                              <span id="address1"></span> </div>
                            <div class="form-group ">
                              <label ><strong>City:</strong></label>
                              <span id="city"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Country:</strong></label>
                              <span id="country"></span> </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 pull-left" >
                            <div class="form-group ">
                              <label ><strong>First Name:</strong></label>
                              <span id="o_name"></span> </div>
                            
                            <div class="form-group ">
                              <label ><strong>Date of Brith:</strong></label>
                              <span id="o_dob"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Social Security Number:</strong></label>
                              <span id="o_ss_number"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Percentage of ownership:</strong></label>
                              <span id="percentage_of_ownership"></span> </div>
                            <div class="form-group ">
                              <label ><strong>Home Address:</strong></label>
                              <span id="o_address"></span> </div>
                            <div class="form-group ">
                              <label><strong>Business name :</strong></label>
                              <span id="cc_business_name"></span> </div>
                            <div class="form-group ">
                              <label><strong>Routing number:</strong></label>
                              <span id="bank_routing"></span> </div>
                            <div class="form-group ">
                              <label><strong>Account number:</strong></label>
                              <span id="bank_account"></span> </div>
                            <div class="form-group ">
                              <label><strong>Bank Name:</strong></label>
                              <span id="bank_name"></span> </div>
                            <div class="form-group ">
                              <label><strong>Zip:</strong></label>
                              <span id="zip"></span> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer"> <?php echo form_open('dashboard/Approved_merchant', array('id' => "activation_form"));?>
                    <input type="hidden" name="id" id="activation_id" value="">
                    <a id="approved_merhcanturl" class="btn btn-primary waves-effect waves-light" href="#">Approve</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- end row --> 
      
    </div>
    
    <!-- end container --> 
    
  </div>
  
  <!-- end content --> 
  
</div>
<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== --> 
<!-- Right Sidebar --> 
<!-- /Right-bar -->
</div>
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Payment Detail </h4>
      </div>
      <div class="modal-body">
        <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> </div>
        
        <!-- content will be load here -->
        
        <div id="dynamic-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
</div>
<!-- END wrapper --> 
<script>
    var resizefunc = [];
    </script> 
<!-- Plugins  --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script> 
<!-- Popper for Bootstrap --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.blockUI.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script> 
<!-- Required datatable js --> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.js"></script> 
<!-- Buttons examples --> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.buttons.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/buttons.bootstrap4.min.js"></script> 
<!-- <script src="plugins/datatables/pdfmake.min.js"></script>
        <script src="plugins/datatables/vfs_fonts.js"></script>
        <script src="plugins/datatables/buttons.html5.min.js"></script>
        <script src="plugins/datatables/buttons.print.min.js"></script>
        <script src="plugins/datatables/buttons.colVis.min.js"></script>--> 
<!-- Responsive examples --> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.responsive.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/responsive.bootstrap4.min.js"></script> 
<!-- App js --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable();
        //Buttons examples
        // var table = $('#datatable-buttons').DataTable({
        //lengthChange: false,
        //  buttons: ['copy', 'excel', 'pdf']
        // });
        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
    </script> 
<script>
$(document).ready(function(){
  
  $(document).on('click', '#getUser', function(e){
    
    e.preventDefault();
    
    var uid = $(this).data('id');   // it will get id of clicked row
    
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({
     url: "<?php  echo base_url('dashboard/search_record_column'); ?>",
     
      type: 'POST',
      data: 'id='+uid,
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });
$(document).on('click', '#getcredt', function(e){
  e.preventDefault();
 // $('#getcredt').on("click", function () {
            
             //var tax =  $('#myid').val();
 var tax = $(this).data('id');   // it will get id of clicked row
    
            $('#auth_code').val('');
           $('#api_key').val('');
            $('#connection_id').val('');
             $('#min_shop_supply').val('');
           $('#max_shop_supply').val('');
            $('#shop_supply_percent').val('');
             $('#protractor_tax_percent').val('');
             $('#b_code').val('');
            $('#d_code').val('');
             $('#t_code').val('');
              $('#t1_code_name').val('');
               $('#t1_code_value').val('');
                $('#t2_code_name').val('');
                 $('#t2_code_value').val('');

                   $('#a_code_name').val('');
                   $('#a_code_value').val('');
                   $('#a_min_value').val('');
                   $('#a_max_value').val('');
                   $('#a_fixed').val('');
                   $('#c_code_name').val('');
                   $('#c_code_value').val('');
                   $('#c_min_value').val('');
                   $('#c_max_value').val('');
                   $('#c_fixed').val('');
                   $('#e_code_name').val('');
                   $('#e_code_value').val('');
                   $('#e_min_value').val('');
                   $('#e_max_value').val('');
                   $('#e_fixed').val('');
                   $('#f_code_name').val('');
                   $('#f_code_value').val('');
                   $('#f_min_value').val('');
                   $('#f_max_value').val('');
                   $('#f_fixed').val('');
                   $('#g_code_name').val('');
                   $('#g_code_value').val('');
                   $('#g_min_value').val('');
                   $('#g_max_value').val('');
                   $('#g_fixed').val('');
                   $('#t1_code_name').val('');
                   $('#t1_code_value').val('');
                   $('#t1_min_value').val('');
                   $('#t1_max_value').val('');
                   $('#t1_fixed').val('');
                   $('#t2_code_name').val('');
                   $('#t2_code_value').val('');
                   $('#t2_min_value').val('');
                   $('#t2_max_value').val('');
                   $('#t2_fixed').val('');
                   $('#t3_code_name').val('');
                   $('#t3_code_value').val('');
                   $('#t3_min_value').val('');
                   $('#t3_max_value').val('');
                   $('#t3_fixed').val('');
                   $('#url_cr').val('');
                   $('#username_cr').val('');
                   $('#password_cr').val('');
                   $('#api_key_cr').val('');
                   $('#account_id').val('');
                   $('#account_token').val('');
                   $('#application_id').val('');
                   $('#acceptor_id').val('');
                    $('#terminal_id').val('');

             
           
            $.ajax({
                type: 'POST',
             
                 url: "<?php  echo base_url('pos/search_record_credntl'); ?>",
                data: {id: tax},
                type:'post',
                success: function (dataJson)
                {
                    data = JSON.parse(dataJson)
                    console.log(data)
                   
                    $(data).each(function (index, element) {
                       
        $('#auth_code').val(element.auth_code);
           $('#api_key').val(element.api_key);
            $('#connection_id').val(element.connection_id);
             $('#m_id').val(element.id);
             $('#min_shop_supply').val(element.min_shop_supply);
           $('#max_shop_supply').val(element.max_shop_supply);
            $('#shop_supply_percent').val(element.shop_supply_percent);
             $('#protractor_tax_percent').val(element.protractor_tax_percent);

             $('#b_code').val(element.b_code);
            $('#d_code').val(element.d_code);
             $('#t_code').val(element.t_code);
    
             $('#t1_code_name').val(element.t1_code_name);
               $('#t1_code_value').val(element.t1_code_value);
                $('#t2_code_name').val(element.t2_code_name);
                 $('#t2_code_value').val(element.t2_code_value);

                   $('#a_code_name').val(element.a_code_name);
                   $('#a_code_value').val(element.a_code_value);
                   $('#a_min_value').val(element.a_min_value);
                   $('#a_max_value').val(element.a_max_value);
                   $('#a_fixed').val(element.a_fixed);
                   $('#c_code_name').val(element.c_code_name);
                   $('#c_code_value').val(element.c_code_value);
                   $('#c_min_value').val(element.c_min_value);
                   $('#c_max_value').val(element.c_max_value);
                   $('#c_fixed').val(element.c_fixed);
                   $('#e_code_name').val(element.e_code_name);
                   $('#e_code_value').val(element.e_code_value);
                   $('#e_min_value').val(element.e_min_value);
                   $('#e_max_value').val(element.e_max_value);
                   $('#e_fixed').val(element.e_fixed);
                   $('#f_code_name').val(element.f_code_name);
                   $('#f_code_value').val(element.f_code_value);
                   $('#f_min_value').val(element.f_min_value);
                   $('#f_max_value').val(element.f_max_value);
                   $('#f_fixed').val(element.f_fixed);
                   $('#g_code_name').val(element.g_code_name);
                   $('#g_code_value').val(element.g_code_value);
                   $('#g_min_value').val(element.g_min_value);
                   $('#g_max_value').val(element.g_max_value);
                   $('#g_fixed').val(element.g_fixed);
           $('#t1_code_name').val(element.t1_code_name);
                   $('#t1_code_value').val(element.t1_code_value);
                   $('#t1_min_value').val(element.t1_min_value);
                   $('#t1_max_value').val(element.t1_max_value);
                   $('#t1_fixed').val(element.t1_fixed);
           $('#t2_code_name').val(element.t2_code_name);
                   $('#t2_code_value').val(element.t2_code_value);
                   $('#t2_min_value').val(element.t2_min_value);
                   $('#t2_max_value').val(element.t2_max_value);
                   $('#t2_fixed').val(element.t2_fixed);
           $('#t3_code_name').val(element.t3_code_name);
                   $('#t3_code_value').val(element.t3_code_value);
                   $('#t3_min_value').val(element.t3_min_value);
                   $('#t3_max_value').val(element.t3_max_value);
                   $('#t3_fixed').val(element.t3_fixed);
                   $('#url_cr').val(element.url_cr);
                   $('#username_cr').val(element.username_cr);
                   $('#password_cr').val(element.password_cr);
                   $('#api_key_cr').val(element.api_key_cr);
                   $('#account_id').val(element.account_id_cnp);
                   $('#account_token').val(element.account_token_cnp);
                   $('#application_id').val(element.application_id_cnp);
                   $('#acceptor_id').val(element.acceptor_id_cnp);
                    $('#terminal_id').val(element.terminal_id);

    
                    });
                 
                }
            });
        });
$(document).on('click', '#mysubmit', function(e){
  e.preventDefault();
 // $('#getcredt').on("click", function () {
            
             var auth_code =  $('#auth_code').val();
             var api_key =  $('#api_key').val();
             var connection_id =  $('#connection_id').val();
             var tax =  $('#m_id').val();
             var min_shop_supply =  $('#min_shop_supply').val();
             var max_shop_supply =  $('#max_shop_supply').val();
             var shop_supply_percent =  $('#shop_supply_percent').val();
             var protractor_tax_percent =  $('#protractor_tax_percent').val();
             var b_code =  $('#b_code').val();
             var d_code =  $('#d_code').val();
             var t_code =  $('#t_code').val();
             var t1_code_name = $('#t1_code_name').val();
             var t1_code_value = $('#t1_code_value').val();
             var t2_code_name = $('#t2_code_name').val();
             var t2_code_value =  $('#t2_code_value').val();
             var a_code_name =  $('#a_code_name').val();
             var a_code_value =  $('#a_code_value').val();
             var a_min_value =  $('#a_min_value').val();
             var a_max_value =  $('#a_max_value').val();
             var a_fixed =  $('#a_fixed').val();
             var c_code_name =  $('#c_code_name').val();
             var c_code_value =  $('#c_code_value').val();
             var c_min_value =  $('#c_min_value').val();
             var c_max_value =  $('#c_max_value').val();
             var c_fixed =  $('#c_fixed').val();
             var e_code_name =  $('#e_code_name').val();
             var e_code_value =  $('#e_code_value').val();
             var e_min_value =  $('#e_min_value').val();
             var e_max_value =  $('#e_max_value').val();
             var e_fixed =  $('#e_fixed').val();
             var f_code_name =  $('#f_code_name').val();
             var f_code_value =  $('#f_code_value').val();
             var f_min_value =  $('#f_min_value').val();
             var f_max_value =  $('#f_max_value').val();
             var f_fixed =  $('#f_fixed').val();
             var g_code_name =  $('#g_code_name').val();
             var g_code_value =  $('#g_code_value').val();
             var g_min_value =  $('#g_min_value').val();
             var g_max_value =  $('#g_max_value').val();
             var g_fixed =  $('#g_fixed').val();
             var t1_code_name =  $('#t1_code_name').val();
             var t1_code_value =  $('#t1_code_value').val();
             var t1_min_value =  $('#t1_min_value').val();
             var t1_max_value =  $('#t1_max_value').val();
             var t1_fixed =  $('#t1_fixed').val();
             var t2_code_name =  $('#t2_code_name').val();
             var t2_code_value =  $('#t2_code_value').val();
             var t2_min_value =  $('#t2_min_value').val();
             var t2_max_value =  $('#t2_max_value').val();
             var t2_fixed =  $('#t2_fixed').val();
             var t3_code_name =  $('#t3_code_name').val();
             var t3_code_value =  $('#t3_code_value').val();
             var t3_min_value =  $('#t3_min_value').val();
             var t3_max_value =  $('#t3_max_value').val();
             var t3_fixed =  $('#t3_fixed').val();
             var url_cr =  $('#url_cr').val();
             var username_cr =  $('#username_cr').val();
             var password_cr =  $('#password_cr').val();
             var api_key_cr =  $('#api_key_cr').val();
             var account_id =  $('#account_id').val();
             var account_token =  $('#account_token').val();
             var application_id =  $('#application_id').val();
             var acceptor_id =  $('#acceptor_id').val();
             var terminal_id =  $('#terminal_id').val();
    
    
          
           
            $.ajax({
                type: 'POST',
             
                 url: "<?php  echo base_url('pos/search_record_update'); ?>",
                data: {id: tax, auth_code: auth_code,api_key: api_key,connection_id: connection_id,min_shop_supply: min_shop_supply, max_shop_supply: max_shop_supply,
        shop_supply_percent: shop_supply_percent,protractor_tax_percent: protractor_tax_percent , b_code: b_code , d_code: d_code , t_code: t_code , 
        t1_code_name : t1_code_name , t1_code_value : t1_code_value , t2_code_name : t2_code_name , t2_code_value : t2_code_value ,
        a_code_name : a_code_name , a_code_value : a_code_value , a_min_value : a_min_value , a_max_value : a_max_value ,
        a_fixed : a_fixed,c_code_name : c_code_name , c_code_value : c_code_value , c_min_value : c_min_value , 
        c_max_value : c_max_value ,c_fixed : c_fixed,e_code_name : e_code_name , e_code_value : e_code_value ,
        e_min_value : e_min_value , e_max_value : e_max_value ,e_fixed : e_fixed,f_code_name : f_code_name , 
        f_code_value : f_code_value , f_min_value : f_min_value , f_max_value : f_max_value ,
        f_fixed : f_fixed,g_code_name : g_code_name , g_code_value : g_code_value , g_min_value : g_min_value ,
        g_max_value : g_max_value ,g_fixed : g_fixed,t1_code_name : t1_code_name , t1_code_value : t1_code_value , t1_min_value : t1_min_value ,
        t1_max_value : t1_max_value ,t1_fixed : t1_fixed,t2_code_name : t2_code_name , t2_code_value : t2_code_value , t2_min_value : t2_min_value ,
        t2_max_value : t2_max_value ,t2_fixed : t2_fixed,t3_code_name : t3_code_name , t3_code_value : t3_code_value , t3_min_value : t3_min_value ,
        t3_max_value : t3_max_value ,t3_fixed : t3_fixed  , url_cr : url_cr , username_cr : username_cr ,password_cr : password_cr ,api_key_cr : api_key_cr ,
        account_id : account_id,account_token : account_token,application_id : application_id,acceptor_id : acceptor_id,terminal_id : terminal_id},
                type:'post',
                success: function (dataJson)
                {
                    data = JSON.parse(dataJson)
                    console.log(data)
                   
                    $(data).each(function (index, element) {
                       
        
    
    
                    });
                 
                }
            });
        });
  
});
function merchant_delete(id)
    {
      if(confirm('Are you sure delete this Merchant?'))
      {
       
          $.ajax({
            url : "<?php echo base_url('dashboard/merchant_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
      }
    }
    function merchant_block(id)
    {
      if(confirm('Are you sure Block this Merchant?'))
      {
        
          $.ajax({
            url : "<?php echo base_url('dashboard/block_merchant')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error  data');
            }
        });
      }
    }
   
    function active_merchant(id)
    {
      if(confirm('Are you sure Active this Merchant?'))
      {
        
          $.ajax({
            url : "<?php echo base_url('dashboard/active_merchant')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error  data');
            }
        });
      }
    }
</script> 
<script type="text/javascript">
   function CheckAll()
     {  
       var post_count = document.getElementById('id').value;
       var k ;
       var j =0
        for(k=1; k<=post_count;k++)
         {
           if(document.getElementById('checkall').checked==true)
                   {
                    document.getElementById('ids'+k).checked=true;
              j++;
               }
         else
           {
             document.getElementById('ids'+k).checked=false;
           }   
           }9
   }
var merchant=<?php echo json_encode($mem)?>;
function viewDetails(key){  
  console.log(merchant[key]);
  $("#business_service").html(merchant[key]["allDettils"]["business_service"]);
  $("#website").html(merchant[key]["allDettils"]["website"]);
  $("#business_number").html(merchant[key]["allDettils"]["business_number"]);
  $("#year_business").html(merchant[key]["allDettils"]["year_business"]);
  $("#monthly_processing_volume").html(merchant[key]["allDettils"]["monthly_processing_volume"]);
  $("#business_name").html(merchant[key]["allDettils"]["business_name"]);
  $("#business_dba_name").html(merchant[key]["allDettils"]["business_dba_name"]);
  $("#business_type").html(merchant[key]["allDettils"]["business_type"]);
  $("#ien_no").html(merchant[key]["allDettils"]["ien_no"]);
  $("#address1").html(merchant[key]["allDettils"]["address1"]);
  $("#city").html(merchant[key]["allDettils"]["city"]);
  $("#country").html(merchant[key]["allDettils"]["country"]);
  $("#o_name").html(merchant[key]["allDettils"]["o_name"]);
  
  
  $("#o_dob").html(merchant[key]["allDettils"]["o_dob"]);
  $("#o_ss_number").html(merchant[key]["allDettils"]["o_ss_number"]);
  $("#percentage_of_ownership").html(merchant[key]["allDettils"]["percentage_of_ownership"]);
  $("#o_address").html(merchant[key]["allDettils"]["o_address"]);
  $("#cc_business_name").html(merchant[key]["allDettils"]["cc_business_name"]);
  $("#bank_routing").html(merchant[key]["allDettils"]["bank_routing"]);
  $("#bank_account").html(merchant[key]["allDettils"]["bank_account"]);
  $("#bank_name").html(merchant[key]["allDettils"]["bank_name"]);
  $("#zip").html(merchant[key]["allDettils"]["zip"]);
  $("#approved_merhcanturl").attr("href","<?php  echo base_url('dashboard/Approved_merchant/') ?>"+merchant[key]["allDettils"]["id"]);
  
}
 </script>
</body>
<!-- Mirrored from coderthemes.com/minton/dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:40:15 GMT -->
</html>