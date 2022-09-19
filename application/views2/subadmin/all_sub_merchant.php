<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Subadmin | Dashboard</title>
  <!-- DataTables -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
  <!-- Responsive datatable examples -->
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <!-- Begin page -->
  <div id="wrapper"> 
    <div class="page-wrapper pos-list invoice-pos-list">   
      <div class="row">
        <div class="col-md-12">
          <div class="back-title m-title"> 
            <span>View All Sub User</span>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row" method="post" action="<?php echo base_url('subadmin/all_sub_merchant');?>">
              <div class="col">
                <div id="daterangeFilter" class="form-control">
                  <!-- <span>April-18-2019 - May-17-2019</span> -->
                   <span><?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                    </span>
                    <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
                    <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                </div>
              </div>
              <div class="col">
                <select class="form-control" name="status" id="status">
                  <option value="">Select Status</option>
                  <?php if (!empty($status) && isset($status)) {  ?>
                      <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?> >Pending</option>          
                      <option value="active" <?php echo (($status == 'active') ? 'selected' : "") ?> >Active</option>
                      <option value="block" <?php echo (($status == 'block') ? 'selected' : "") ?> >Block</option> 
                    <?php  } else { ?>
                      <option value="pending">Pending</option>          
                      <option value="active">Active</option>
                      <option value="block">Block</option> 
                    <?php } ?>
                </select>
              </div>
              <div class="col-3 ">
                <button class="btn btn-first" type="submit" name="mysubmit"><span>Search</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-detail">
              <?php
              $count = 0;
              if(isset($msg))
                echo $msg;
              ?>
              <div class="pos-list-dtable reset-dataTable">
                <table id="all_subuser_dt" class="display" style="width:100%">
                  <thead>
                    <tr>
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
                       <!--  <td style="display: none;"> <?php echo $i; ?></td>  -->
                       <td><?php echo $a_data['name'] ?></td>
                       <td><?php echo $a_data['email'] ?></td>
                       <td><?php echo $a_data['id'] ?></td>
                       <td><?php echo $a_data['merchant_id'] ?></td>
                       <td><?php echo $a_data['dba_name'] ?></td>
                       <td><?php echo $a_data['status'] ?></td>
                       <td>
                         <a href="#" data-toggle="modal" data-target="#view-modall" data-id="<?php echo $a_data['id'];  ?>" id="getcredt" class="pos_Status_c badge-btn"><i class=" ti-eye "></i> Credentials</a>
                       </td>
                     </tr>
                     <?php $i++;}?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>      
    </div>    
  </div>
<div id="view-modall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Sub User CR credentials </h4>
      </div>
      <div class="modal-body custom-form">
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
        <button type="submit" name="submit" id="mysubmit" class="btn btn-first waves-effect waves-light" data-dismiss="modal" >Update</button>
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
        <div id="activation_modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> 
        </div>
        <!-- content will be load here -->
        <div id="activation_dynamic-content1">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-centered" >
              <div class="col-lg-6 col-md-6 col-sm-12 pull-left" >
                <div class="form-group ">
                  <label >
                    <strong>Business Service:</strong>
                  </label>
                  <span id="business_service">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Business website:</strong>
                  </label>
                  <span id="website">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Business Phone Number:</strong>
                  </label>
                  <span id="business_number">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Years in Business:</strong>
                  </label>
                  <span id="year_business">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Estimated monthly processing volume::</strong>
                  </label>
                  <span id="monthly_processing_volume">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Legal Name of business:</strong>
                  </label>
                  <span id="business_name">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong> DBA Name:</strong>
                  </label>
                  <span id="business_dba_name">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Type of Business:</strong>
                  </label>
                  <span id="business_type">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Employer Identification Number (EIN):</strong>
                  </label>
                  <span id="ien_no">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Street:</strong>
                  </label>
                  <span id="address1">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>City:</strong>
                  </label>
                  <span id="city">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Country:</strong>
                  </label>
                  <span id="country">
                  </span> 
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 pull-left" >
                <div class="form-group ">
                  <label >
                    <strong>First Name:</strong>
                  </label>
                  <span id="o_name">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Date of Brith:</strong>
                  </label>
                  <span id="o_dob">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Social Security Number:</strong>
                  </label>
                  <span id="o_ss_number">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Percentage of ownership:</strong>
                  </label>
                  <span id="percentage_of_ownership">
                  </span> 
                </div>
                <div class="form-group ">
                  <label >
                    <strong>Home Address:</strong>
                  </label>
                  <span id="o_address">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Business name :</strong>
                  </label>
                  <span id="cc_business_name">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Routing number:</strong>
                  </label>
                  <span id="bank_routing">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Account number:</strong>
                  </label>
                  <span id="bank_account">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Bank Name:</strong>
                  </label>
                  <span id="bank_name">
                  </span> 
                </div>
                <div class="form-group ">
                  <label>
                    <strong>Zip:</strong>
                  </label>
                  <span id="zip">
                  </span> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer"> <?php echo form_open('subadmin/Approved_merchant', array('id' => "activation_form"));?>
        <input type="hidden" name="id" id="activation_id" value="">
        <a id="approved_merhcanturl" class="btn btn-first waves-effect waves-light" href="#">Approve</a>
      </div>
    </div>
  </div>
</div>
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Payment Detail </h4>
      </div>
      <div class="modal-body">
        <div id="modal-loader" class="text-center" style="display: none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
        </div>
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
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<!-- Popper for Bootstrap --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script> 
<!-- Required datatable js --> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<!-- App js --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    var dtTransactionsConfig={
      "processing": true,
// "sAjaxSource":"data.php",
"pagingType": "full_numbers",
"pageLength": 25,
"dom": 'lBfrtip',
responsive: true, 
language: {
  search: '', searchPlaceholder: "Search",
  oPaginate: {
    sNext: '<i class="fa fa-angle-right"></i>',
    sPrevious: '<i class="fa fa-angle-left"></i>',
    sFirst: '<i class="fa fa-step-backward"></i>',
    sLast: '<i class="fa fa-step-forward"></i>'
  }
}   ,
"buttons": [
{
  extend: 'collection',
  text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
  buttons: [
  'copy',
  'excel',
  'csv',
  'pdf',
  'print'
  ]
}
]
}
$('#all_subuser_dt').DataTable(dtTransactionsConfig);
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
  url: "<?php  echo base_url('subadmin/search_record_column'); ?>",
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
      url : "<?php echo base_url('subadmin/merchant_delete')?>/"+id,
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
      url : "<?php echo base_url('subadmin/block_merchant')?>/"+id,
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
      url : "<?php echo base_url('subadmin/active_merchant')?>/"+id,
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
    $("#approved_merhcanturl").attr("href","<?php  echo base_url('subadmin/Approved_merchant/') ?>"+merchant[key]["allDettils"]["id"]);
  }
</script>
</body>
</html>