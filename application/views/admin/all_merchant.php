<!DOCTYPE html>
<html lang="en"> 
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Dashboard</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
  <style type="text/css">
      table tr.child td.child>ul>li {
      white-space: normal;
      }
      table tr.child td.child>ul>li a, table tr.child td.child>ul>li button {
      margin-bottom: 5px;
      }
      .btn.btn-gray {
      background-color: #8a8a8a;
      border: 1px solid #8a8a8a; 
      color: #fff;
      }
      .btn.btn-gray.focus, .btn.btn-gray:focus {
      -webkit-box-shadow: 0 0 0 3px rgba(138, 138, 138, 0.25);
      box-shadow: 0 0 0 3px rgba(138, 138, 138, 0.25);
      }
      .highliter{
      -webkit-animation: blinkAnim 0.5s ease-in-out   0s infinite;
      animation: blinkAnim 0.5s ease-in-out   0s infinite;
      }
      @-webkit-keyframes blinkAnim{
      from{
      color: #333;
      background-color: #ffc107;
      border-color: #ffc107;
      }
      to{
      background-color: #17a2b8;
      }
      }
      @keyframes blinkAnim{
      from{
      color: #333;
      background-color: #ffc107;
      border-color: #ffc107;
      }
      to{
      background-color: #17a2b8;
      }
      }
      .reset-dataTable table.dataTable td, .reset-dataTable table.dataTable th {
          white-space: nowrap;
      }
      .modal-dialog {
          max-width: 650px;
          margin: 30px auto;
      }
      #activation_dynamic-content1 .form-group {
        max-width: 50%;
        float: left;
        width: 100%;
        position: relative;
        padding: 0 5px;
      }
      .rel-div{
        position: relative;
      }
      select.form-control:not([size]):not([multiple]){
        height: 40px;
      }
      .tab-content>.tab-pane {
        padding-top: 15px;
      }
      .nav-tabs .nav-link, .nav-tabs .nav-link {
          border-color: #2273dc #2273dc #ddd;
          margin: 0 2px;
      }
      .nav-tabs .nav-item .nav-link, .nav-tabs .nav-link {
          background-color: #e9ecef;
      }
      .nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus {
        background-color: #2273dc;
        color: rgba(255,255,255,0.85);
      }
      .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        background-color: #2273dc;
        color: rgba(255,255,255,0.85);
      }
      @media only screen and (max-width: 767px){
        #view-ActivationDetails.modal.show .modal .modal-dialog .close{
          right: -10px;
        }
        #view-ActivationDetails.modal.show .modal-dialog{
          padding: 0 15px;
        }
      }
      @media only screen and (max-width: 479px){
        #activation_dynamic-content1 .form-group {
          max-width: 100%;
          padding: 0;
        }
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
            <span>View All Merchant</span>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row" method="post" action="<?php echo base_url('dashboard/all_merchant');?>">
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
                        <option value="Activate_Details" <?php echo (($status == 'Activate_Details') ? 'selected' : "") ?> > Activate Details</option>
                        <option value="Waiting_For_Approval" <?php echo (($status == 'Waiting_For_Approval') ? 'selected' : "") ?> >Waiting For Approval</option>
                        <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?> >Confirm</option>
                        <option value="active" <?php echo (($status == 'active') ? 'selected' : "") ?> >Active</option>
                        <option value="block" <?php echo (($status == 'block') ? 'selected' : "") ?>>Block</option>
                   <?php  } else {?>
                        <option value="pending">Pending</option>                
                        <option value="Activate_Details"> Activate Details</option>
                        <option value="Waiting_For_Approval">Waiting For Approval</option>
                        <option value="confirm">Confirm</option>
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
                <table id="dt_inv_pos_sale_list" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th class="no-event">DBA Name</th>
                          <th class="no-event">Company Name</th>
                          <!-- <th>Primary Contact</th>
                          <th>Sub Merchant ID</th> -->
                          
                          <th class="no-event" >Status </th>
                          <th class="no-event">Tokenized system</th>
                          <th class="no-event">Details </th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
                    $i=1;
                    foreach($mem as $key=>$a_data)
                    {
                    $count++;
                    // print_r($a_data); 
                  ?>
                    <tr id="row_<?php echo $a_data['id'];?>">
                      <td><?php echo $a_data['business_dba_name'] ?></td>
                      <td><?php echo $a_data['business_name'] ?></td>
                      <!-- <td><?php echo $a_data['id'] ?></td>
                      <td><?php echo $a_data['id'] ?></td> -->

                      <?php
                                      if($a_data['status']=="active"){ $btncolor='badge-success'; $dtext='Active'; $title='Active';}
                                      if($a_data['status']=="Waiting_For_Approval"){ $btncolor='badge-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                      if($a_data['status']=="pending"){$btncolor='badge-danger'; $dtext='Pending'; $title='Pending'; }
                                      ?>
                                      <td><a data-toggle="tooltip" class="badge  <?php echo $btncolor;?> " style="font-size: 12px; color:white; " data-placement="top" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td>
                                      
 <td>
                        <span class="start_stop_tax <?php if($a_data['is_token_system_permission'] > 0 ) echo 'active'; ?> " rel="238">
                          <label class="switch switch_type1" role="switch">
                            <input type="checkbox" class="switch__toggle"  <?php if($a_data['is_token_system_permission'] > 0 ) echo 'checked'; ?> id="switchval_<?php echo $a_data['id'];?>" value="<?php echo $a_data['id'];?>">
                            <span class="switch__label">|
                            </span>
                          </label>
                          <span class="msg">
                            <span class="stop">Stop
                            </span>
                            <span class="start">Start
                            </span>
                          </span>
                        </span> 
                      </td>
                     
                      <td class="all_mer_tbl_btns">
                        <!--<button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="btn btn-sm btn-info">-->
                        <!--  <i class=" ti-eye ">-->
                        <!--  </i> Payment Detail-->
                        <!--</button>-->
                        <button data-toggle="modal" data-target="#view-modall" data-id="<?php echo $a_data['id'];  ?>" id="getcredt" class="btn btn-sm btn-info">
                          <i class=" ti-eye ">
                          </i> Credentials
                        </button>
                        <button data-toggle="modal" onClick="viewDetails('<?php echo $key;?>')" data-target="#view-ActivationDetails" data-id="<?php echo $key;  ?>" id="activationDetails" class="<?php echo ($a_data['status']=="active")?'':'highliter'; ?> btn btn-sm btn-info">
                          <i class=" ti-eye ">
                          </i> Activation Details
                        </button>
                        <!--  -->
                        <?php if($a_data['status']=='confirm'){ ?>
                        <?php
                        $data = array(
                          'class' => 'btn btn-sm btn-info',
                        'id' => 'del-bt',
                        'content' => ' <a ><i class="mdi mdi-account"></i> Active Account</a>',
                        'onclick' => 'javascript:active_pak('.$a_data['id'].')'
                        );
                        echo form_button($data); 
                        ?>
                        <?php }  elseif($a_data['status']=='active') { ?>
                        <button  class="btn btn-sm btn-success"  onclick="merchant_block(<?php echo $a_data['id'];?>)"><i class=" mdi mdi-account "></i> Block Account</button>
                        <?php }  elseif($a_data['status']=='block') { ?>
                        <button  class="btn btn-sm btn-info" onclick="active_merchant(<?php echo $a_data['id'];?>)"><i class=" mdi mdi-account "></i> Active Account</button>
                        <?php }  elseif($a_data['status']=='pending') { ?>
                        <button  class="btn btn-sm btn-danger" onclick="confirm_email(<?php echo $a_data['id'];?>)"><i class="mdi mdi-account "></i> Confirm Email</button>
                        <?php } ?>
                        <!--  -->
                        <a class="btn btn-sm btn-warning" title="edit" id="edit-bt" href="<?php  echo base_url('dashboard/update_merchant/' . $a_data['id']) ?>">
                          <i class="fa fa-pencil">
                          </i> 
                        </a>
                        <a class="btn btn-sm btn-gray" title="all subuser list" target='_blank' href="<?php  echo base_url('dashboard/all_sub_merchant/' . $a_data['id']) ?>">
                          <i class="fa fa-users">
                          </i> 
                        </a>
                        <button class="btn btn-sm btn-danger" title="delete"  onclick="merchant_delete(<?=$a_data['id'];?>)">
                          <i class="fa fa-trash">
                          </i>
                        </button>
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
<!-- Begin page -->
<div id="view-modall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Protractor credentials </h4>
    </div>
    <div class="modal-body custom-form">
      <div id="modal-loader" class="text-center" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
      </div>
      <!-- content will be load here -->
      <div id="dynamic-content1">
        <div class="row">
          <div class="col-12">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#genDetail">General</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#t1Detail">t1</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#t2Detail">t2</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#t3Detail">t3</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#aDetail">A</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cDetail">C</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#eDetail">E</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#fDetail">F</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#gDetail">G</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cnpDetail">CNP</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane container active" id="genDetail">
                <div class="row">
                  <div class="col-6">
                  <div class="form-group">
                    <label>Connection ID</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control"  name="connection_id" id="connection_id"   placeholder="Connection ID:" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>API Key</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="api_key" id="api_key"  placeholder="API Key" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Auth Code</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="auth_code" id="auth_code"  placeholder="Auth Code" >
                        <input type="hidden" class="form-control" id="m_id">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Min Shop Supply Value</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="min_shop_supply" id="min_shop_supply"  placeholder="Min Shop Supply Value" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Max Shop Supply Value</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="max_shop_supply" id="max_shop_supply"  placeholder="Max Shop Supply Value" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Shop Supply Percent</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="shop_supply_percent" id="shop_supply_percent"  placeholder="Shop Supply Percent" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Protractor Tax Percent</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="protractor_tax_percent" id="protractor_tax_percent"  placeholder="Protractor Tax Percent" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>B Code</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="b_code" id="b_code"  placeholder="B Code" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>D Code</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="d_code" id="d_code"  placeholder="D Code" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>T Code</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="t_code" id="t_code"  placeholder="T Code" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>URL_CR</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="url_cr" id="url_cr"  placeholder="URL_CR" >
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6">
                  <div class="form-group">
                    <label>Username_CR</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="username_cr" id="username_cr"  placeholder="Username_CR" >
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6">
                  <div class="form-group">
                    <label>Password_CR</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="password_cr" id="password_cr"  placeholder="Password_CR" >
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6">
                  <div class="form-group">
                    <label>Api_Key_CR</label>
                    <div >
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="api_key_cr" id="api_key_cr"  placeholder="Api_Key_CR" >
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="t1Detail">
                <div class="row">
                  <div class="col-12">
                    <label >T1</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t1_code_name" id="t1_code_name"  placeholder="T1 Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t1_code_value" id="t1_code_value"  placeholder="T1 Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                      <label >T1 value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t1_max_value" id="t1_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t1_min_value" id="t1_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                 <div class="col-12">
                    <label>T1 value(Fixed)</label>
                    <div class="form-group row">
                       <div class="col-md-12">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t1_fixed" id="t1_fixed"  placeholder="Fixed Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
              </div>
              <div class="tab-pane container fade" id="t2Detail">
                <div class="row">
                  <div class="col-12">
                    <label>T2</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t2_code_name" id="t2_code_name"  placeholder="T2 Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t2_code_value" id="t2_code_value"  placeholder="T2 Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>T2 value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t2_max_value" id="t2_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t2_min_value" id="t2_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>T2 value(Fixed)</label>
                    <div class="form-group">
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="t2_fixed" id="t2_fixed"  placeholder="Fixed Value" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="t3Detail">
                <div class="row">
                  <div class="col-12">
                    <label>T3</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t3_code_name" id="t3_code_name"  placeholder="T3 Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t3_code_value" id="t3_code_value"  placeholder="T3 Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="col-12">
                      <label>T3 value(Max/Min)</label>
                      <div class="form-group row">
                        <div class="col-6">
                          <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                            <input type="text" class="form-control" autocomplete="off"   name="t3_max_value" id="t3_max_value"  placeholder="Max value" >
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                            <input type="text" class="form-control" autocomplete="off"   name="t3_min_value" id="t3_min_value"  placeholder="Min Value" >
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label >T3 value(Fixed)</label>
                      <div class="form-group">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="t3_fixed" id="t3_fixed"  placeholder="Fixed Value" >
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="aDetail">
                <div class="row">
                  <div class="col-12">
                    <label>A</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="a_code_name" id="a_code_name"  placeholder="A Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="a_code_value" id="a_code_value"  placeholder="A Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>A value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="a_max_value" id="a_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="a_min_value" id="a_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>A value(Fixed)</label>
                    <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                      <input type="text" class="form-control" autocomplete="off"   name="a_fixed" id="a_fixed"  placeholder="Fixed Value" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="cDetail">
                <div class="row">
                  <div class="col-12">
                    <label>C</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="c_code_name" id="c_code_name"  placeholder="C Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="c_code_value" id="c_code_value"  placeholder="C Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>C value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="c_max_value" id="c_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="c_min_value" id="c_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                 <div class="col-12">
                    <label>C value(Fixed)</label>
                    <div class="form-group ">
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                      <input type="text" class="form-control" autocomplete="off"   name="c_fixed" id="c_fixed"  placeholder="Fixed Value" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="eDetail">
                <div class="row">
                  <div class="col-12">
                    <label>E</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="e_code_name" id="e_code_name"  placeholder="E Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="e_code_value" id="e_code_value"  placeholder="E Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>E value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="e_max_value" id="e_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group"><span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="e_min_value" id="e_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>E value(Fixed)</label>
                    <div class="form-group">
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                      <input type="text" class="form-control" autocomplete="off"   name="e_fixed" id="e_fixed"  placeholder="Fixed Value" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="fDetail">
                <div class="row">
                  <div class="col-12">
                    <label >F</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="f_code_name" id="f_code_name"  placeholder="F Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="f_code_value" id="f_code_value"  placeholder="F Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>F value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="f_max_value" id="f_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="f_min_value" id="f_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>F value(Fixed)</label>
                    <div class="form-group ">
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                      <input type="text" class="form-control" autocomplete="off"   name="f_fixed" id="f_fixed"  placeholder="Fixed Value" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="gDetail">
                <div class="row">
                  <div class="col-12">
                    <label>G</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="g_code_name" id="g_code_name"  placeholder="G Name" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="g_code_value" id="g_code_value"  placeholder="G Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label>G value(Max/Min)</label>
                    <div class="form-group row">
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="g_max_value" id="g_max_value"  placeholder="Max value" >
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="g_min_value" id="g_min_value"  placeholder="Min Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>G value(Fixed)</label>
                       <div >
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="g_fixed" id="g_fixed"  placeholder="Fixed Value" >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container fade" id="cnpDetail">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group ">
                      <label>TerminalID_CNP</label>
                       <div>
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                <input type="text" class="form-control" autocomplete="off"   name="terminal_id" id="terminal_id"  placeholder="Terminal ID" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <label>AccountID_CNP</label>
                    <div class="form-group ">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                <input type="text" class="form-control" autocomplete="off"   name="account_id" id="account_id"  placeholder="AccountID" >
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <label >AccountToken_CNP</label>
                    <div class="form-group">
                        <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                          <input type="text" class="form-control" autocomplete="off"   name="account_token" id="account_token"  placeholder="AccountToken" >
                        </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <label>ApplicationID_CNP</label>
                    <div class="form-group ">
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="application_id" id="application_id"  placeholder="ApplicationID" >
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <label>AcceptorID_CNP</label>
                    <div class="form-group">
                      <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                        <input type="text" class="form-control" autocomplete="off"   name="acceptor_id" id="acceptor_id"  placeholder="AcceptorID" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer"> 
      <!--   <button type="button" class="btn btn-second" data-dismiss="modal">Close</button> -->
      <p id="updateCredentialFnMsg"></p>
      <button type="submit" name="submit" onclick="updateCredentialFn(event);" class="btn btn-first waves-effect waves-light  btn-lg btn-lgs ">Update</button>
    </div>
  </div>
</div>
</div>
<!-- /.modal -->
<div id="view-ActivationDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content" id="printableArea">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Activation Details </h4>
    </div>
    <div class="modal-body custom-form">
      <div id="modal-loader" class="text-center" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
      </div>
      <!-- content will be load here -->
      <div id="activation_dynamic-content1">
        <div class="row">
          <div class="col-12">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#busInfo">Business Information </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#BusOwnInfo">Business Owner Information</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#BankInfo">Banking Information</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane container active" id="busInfo">
                <div class="row">
                  <div class="col-sm-12" >
                    <div class="form-group ">
                      <label>Legal Name of business:</label>
                      <input type="text" class="form-control required" id="business_name" placeholder=''> 
                    </div>
                    <div class="form-group ">
                      <label > DBA Name:</label>
                      <input type="text" class="form-control required" id="business_dba_name" placeholder=''> 
                    </div>
                    <div class="form-group ">
                      <label >Tax Identification Number  :</label>
                      <input type="text" class="form-control required us-tin-no" id="taxid" placeholder='' onkeypress="return isNumberKey(event)"> 
                    </div>
                    <div class="form-group ">
                      <label >Physical Address :</label>
                      <input type="text" class="form-control required" id="address1" placeholder=''>
                    </div>
                    <div class="form-group ">
                      <label >Ownership Type  :</label>
                      <div class="rel-div">
                        <select class="form-control required" name="bsns_ownrtyp" required="" autocomplete="off" id="ownershiptype">
                          <option value="">Select Ownership Type</option>
                          <option value="Government">Government</option>
                          <option value="LLC">Limited Liability Company</option>
                          <option value="NonProfit">Non-Profit</option>
                          <option value="Partnership">Partnership</option>
                          <option value="PrivateCorporation">Private Corporation</option>
                          <option value="PublicCorporation">Public Corporation</option>
                          <option value="SoleProprietorship">Sole Proprietorship</option>
                        </select>
                      </div>
                      <!-- <input type="text" class="form-control required" id="ownershiptype" placeholder=''>  -->
                    </div>
                    <div class="form-group ">
                      <label >Business Type :</label>
                      <div class="rel-div">
                        <select class="form-control required" name="bsns_type" required="" autocomplete="off" id="business_type">
                          <option value="">Select Business Type</option>
                          <option value="AutoRental">Auto Rental</option>
                          <option value="ECommerce">E-Commerce</option>
                          <option value="Lodging">Lodging</option>
                          <option value="MOTO">MOTO</option>
                          <option value="Restaurant">Restaurant</option>
                          <option value="Retail">Retail</option>
                        </select>
                      </div>
                      <!-- <input type="text" class="form-control required" id="business_type" placeholder=''>  -->
                    </div>
                    <div class="form-group ">
                      <label >Business Establishment Date :</label>
                      <input type="text" class="form-control required us-date-calendar" id="establishmentdate" placeholder='yyyy-mm-dd'> 
                    </div>
                    <div class="form-group ">
                      <label>Business Phone Number:</label>
                      <input type="text" class="form-control required us-phone-no" id="business_number" placeholder='' > 
                    </div>
                    <div class="form-group ">
                      <label >Customer Service Phone Number :</label>
                      <input type="text" class="form-control required us-phone-no" id="customer_service_phone" placeholder=''> 
                    </div>
                    <div class="form-group ">
                      <label >Business Email Address :</label>
                      <input type="text" class="form-control required email" id="business_email" placeholder=''> 
                    </div>
                    <div class="form-group ">
                      <label >customer service Email :</label>
                      <input type="text" class="form-control required email" id="customer_service_email" placeholder=''> 
                    </div>
                    <div class="form-group ">
                      <label>Business website:</label>
                      <input type="text" class="form-control required" id="website" placeholder='Website'> 
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container " id="BusOwnInfo">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group ">
                      <label>Primary Contact's Name:</label>
                      <input  type="text" id="pc_name" class="form-control required" name="pc_name" placeholder="" /> 
                    </div>
                    <div class="form-group ">
                      <label>Primary Contact's Title:</label>
                      <input  type="text" id="pc_title" class="form-control required" name="pc_title" placeholder="" /> 
                    </div>
                    <div class="form-group ">
                      <label>Primary Contact's Address :</label>
                      <input  type="text" id="pc_address" class="form-control required" name="pc_address" placeholder=" " /> 
                    </div>
                    <div class="form-group ">
                      <label>Primary Contact's Email:</label>
                      <input  type="text" id="pc_email" name="pc_email" placeholder="" class="form-control required email" /> 
                    </div>
                    <div class="form-group ">
                      <label>Primary Contact's Phone:</label>
                      <input  type="text" id="pc_phone" name="pc_phone" placeholder="" class="form-control required us-phone-no" /> 
                    </div>
                    <div class="form-group ">
                      <label>Monthly  Fee:</label>
                      <input  type="text" id="monthly_fee" name="monthly_fee" placeholder="Monthly  Fee" class="form-control required" onkeypress="return isNumberKey1dc(this,event)" /> 
                    </div>
                    <div class="form-group ">
                      <label>vm Card Rate :</label>
                      <input  type="text" id="vm_cardrate" name="vm_cardrate" placeholder="" class="form-control required" onkeypress="return isNumberKey(event)"/> 
                    </div>
                    <div class="form-group ">
                      <label >Name:</label>
                      <input type="text" class="form-control required" id="name" placeholder=""> 
                    </div>
                    <div class="form-group ">
                      <label >Social Security Number:</label>
                      <input type="text" class="form-control required us-ssn-no-enc" id="o_ss_number" placeholder="" onkeypress="return isNumberKey(event)" maxlength="11"> 
                    </div>
                    <div class="form-group ">
                      <label >Date of Brith:</label>
                      <input type="text" class="form-control required us-date-calendar" id="o_dob" placeholder='yyyy-mm-dd'> 
                    </div>
                    <div class="form-group ">
                      <label >Home Address:</label>
                      <input type="text" class="form-control required" id="o_address" placeholder=""> 
                    </div>
                    <div class="form-group ">
                      <label >Phone:</label>
                      <input type="text" class="form-control required us-phone-no" id="o_phone" placeholder=""> 
                    </div>
                    <div class="form-group ">
                      <label >Email:</label>
                      <input type="text" class="form-control required email" id="o_email" placeholder=""> 
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane container " id="BankInfo">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group ">
                      <label >Bank Account DDA Type:</label>
                      <!-- <input type="text" class="form-control required" id="bank_dda" placeholder="">  -->
                      <div class="rel-div">
                        <select class="form-control required" name="bank_dda" id="bank_dda" required="">
                          <option value="">Select Bank Account DDA Type</option>
                          <option value="CommercialChecking">Commercial Checking</option>
                          <option value="PrivateChecking">Private Checking</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label >Bank Account ACH type:</label>
                      <div class="rel-div">
                        <select class="form-control required" name="baccachtype" required="" id="bank_ach">
                          <option value="">Select Bank Account ACH Type</option>
                          <option value="CommercialChecking">Business Checking</option>
                          <option value="PrivateChecking">Personal Checking</option>
                        </select>
                      </div>
                     <!--  <input type="text" class="form-control required"  placeholder="">  -->
                    </div>
                    <div class="form-group ">
                      <label>Routing number:</label>
                      <input type="text" class="form-control required" id="bank_routing" placeholder="" maxlength="9" onkeypress="return isNumberKey(event)">
                    </div>
                    <div class="form-group ">
                      <label>Account number:</label>
                      <input type="text" class="form-control required" id="bank_account" placeholder="" maxlength="17" onkeypress="return isNumberKey(event)"> 
                    </div>
                    <div class="form-group ">
                      <label>Estimated Annual  Processing Volume:</label>
                      <div class="rel-div">
                        <select class="form-control required" name="mepvolume" id="annual_processing_volume">
                          <option value="">Estimated Annual Processing Volume</option>
                          <option value="10000">$10,000</option>
                          <option value="20000">$20,000</option>
                          <option value="30000">$30,000</option>
                          <option value="40000">$40,000</option>
                          <option value="50000">$50,000</option>
                          <option value="60000">$60,000</option>
                          <option value="70000">$70,000</option>
                          <option value="80000">$80,000</option>
                          <option value="90000">$90,000</option>
                          <option value="100000">$100,000+</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label >City:</label>
                      <input type="text" class="form-control required" id="city" placeholder=""> 
                    </div>
                    <div class="form-group ">
                      <label >Country:</label>
                      <input type="text" class="form-control required" id="country" placeholder=""> 
                    </div>
                    <div class="form-group ">
                      <label>Dis Transaction Fee:</label> 
                      <input  type="text" id="dis_trans_fee" class="form-control required" name="dis_trans_fee" placeholder=""  onkeypress="return isNumberKey1dc(this,event)"/> 
                    </div>
                    <div class="form-group ">
                      <label> Amexrate:</label>
                      <input  type="text" id="amexrate" class="form-control required" name="amexrate" placeholder="" onkeypress="return isNumberKey(event)"/> 
                    </div>
                    <div class="form-group ">
                      <label>Chargeback:</label>
                      <input  type="text" id="chargeback" class="form-control required" name="chargeback" placeholder="" /> 
                    </div>
                    <div class="form-group ">
                      <label>Monthly Gateway fee :</label>
                      <input  type="text" id="monthly_gateway_fee" class="form-control required" name="monthly_gateway_fee" placeholder=""  onkeypress="return isNumberKey1dc(this,event)"/> 
                    </div>
                    <div class="form-group ">
                      <label>Annual CC Sales vol:</label>
                      <input  type="text" id="annual_cc_sales_vol" class="form-control required" name="annual_cc_sales_vol" placeholder=""  onkeypress="return isNumberKey1dc(this,event)"/> 
                    </div>
                    <input  type="hidden" id="mycheckbox" class="hidden_inputs" name="mycheckbox"  value="1" />
                    <div class="form-group ">
                      <label>Question:</label>
                      <input  type="text" id="question" class="form-control required" name="question" placeholder="" /> 
                    </div>
                    <div class="form-group ">
                      <label>V Billing Descriptor :</label>
                      <input  type="text" id="billing_descriptor" class="form-control required" name="billing_descriptor" placeholder="" /> 
                    </div>
                    <div class="form-group applicationstatusDiv">
                      <label>Application Status:</label>
                      <br/>
                      <span class="b text-success  h4" id="applicationstatus"><?php echo $applicationstatus; ?></span>
                      <span id="checkapplicationstatus"   onclick="checkApplicationStatusFn()"   class="btn btn-first btn-xs" ><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></span>
                    </div>
                    <input type="hidden" id="key" class="hidden_inputs" name='key' />
                    <input type="hidden" name="id" id="activation_id" class="hidden_inputs" value="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="error-section h4 text-danger "></div>
      <div class="error-message h5 text-danger "> </div>
    </div>
    <div class="modal-footer"> <?php echo form_open('dashboard/Approved_merchant', array('id' => "activation_form"));?>
    <a href=""  id="printButton" class="btn btn-first waves-effect waves-light custom-btn" onclick="printDiv('printableArea')" style="margin-left: 5px;">Print</a> 
    <a id="approved_merhcanturl"  class="btn btn-first waves-effect waves-light" href="#">Approve</a>
    <a id="send_to_merhcant"   onclick="Api_merhcant()"   class="btn btn-first waves-effect waves-light" href="javascript:void(0)" >Send to underwriting</a>
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
      <div class="modal-body custom-form">
        <div id="modal-loader" class="text-center" style="display: none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
        </div>
        <!-- content will be load here -->
        <div id="dynamic-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-second" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  var resizefunc = [];
</script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
  <script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
  <script type="text/javascript" src="<?php echo base_url(); ?>/new_assets/js/datatables.min.js"></script>
  <!-- Custom main Js -->
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/masking.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/new_assets/css/sweetalert.css">
<script src="<?php echo base_url(); ?>/new_assets/js/sweetalert.js"></script>
<script type="text/javascript">
$(function(){
  var dtTransactionsConfig={
    "processing": true,
    // "sAjaxSource":"data.php",
    "order": [],
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
    ],
    // "order": [{ 'id', "desc" }]
    // "columns": [
    // { "width": "25%" }
    
    
    // ]

  }
  $('#dt_inv_pos_sale_list').DataTable(dtTransactionsConfig);
})
function updateCredentialFn(e){
      console.log('clicked-cr');
      // $('#getcredt').on("click", function () {
             var auth_code =  $('#auth_code').val();
             var api_key =  $('#api_key').val();
             var connection_id =  $('#connection_id').val();
             var tax =  $('#m_id').val();
             console.log(tax);
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
                  if(dataJson == '200'){
                    $('#updateCredentialFnMsg').html('<span class="text-success">Updated successfully!</span>');
                  }
                  else{
                    $('#updateCredentialFnMsg').html('<span class="text-danger">Something went wrong!</span>');
                  }
                  setTimeout(function(){$('#updateCredentialFnMsg').html('');},3000)
                }
            });
};
function merchant_delete(id)
{
  var tableRowId=id;
  swal({
    title: '<span class="h4">Are you sure, want to delete this Merchant?</span>',
    text: '<p>If you are sure, enter your password below:</p><p><input type="text" class="form-control merchant_delete_pass" value=""  placeholder="Password" autocomplete="off"> </p>',
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn btn-first ",
    confirmButtonText: "Delete",
    cancelButtonClass: "btn danger-btn ",
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    html: true,
    closeOnCancel: true},
    function(isConfirm) 
    { 
      // console.log(isConfirm);
      // console.log($('.merchant_delete_pass').val());
      if(isConfirm){
        var pass=$('.merchant_delete_pass').val();
        var admin_id="<?php echo $this->session->userdata('id'); ?>";
        if(pass){
          $.ajax({     //  //  /"+id+'/'+'/'+pass 
              url : "<?php echo base_url('dashboard/merchant_delete')?>", 
              type: "POST",
              data:{'merchant_id':id,'pass':pass,'admin_id':admin_id},
              dataType: "JSON",
              success: function(data)
              {
                console.log(data); 
                //location.reload();
                if(data.status){
                  console.log('row_'+tableRowId);
                  $('#row_'+tableRowId).remove();
                  swal(
                    'Deleted!',
                    'Merchant has been deleted.',
                    'success'
                  )
                }
                else{
                  $('.merchant_delete_pass').val('');
                  $('.merchant_delete_pass').after('<span id="incorrectPassMsg" class="text-danger">'+data.message+'</span>');
                  setTimeout(function(){$('#incorrectPassMsg').remove();},3000)
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                // alert('Error deleting data'); 
                swal(
                  'Something went wrong!',
                  'Please try again later.',
                  'error'
                )
              }
            });
        }
        else{
          $('.merchant_delete_pass').focus();
        }
      }
      else
      {
      }
    })
}
$(document)
.on('click', '#getcredt', function(e){
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
                    //console.log(data)
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
    $(document).ready(function() {
        $('#datatable').DataTable();
        //Buttons examples
        // var table = $('#datatable-buttons').DataTable({
        //lengthChange: false,
        //  buttons: ['copy', 'excel', 'pdf']
        // });
        // table.buttons().container()
        //     .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    })
    .on('change','.start_stop_tax input[type="checkbox"]', function (e) {
      // stop - start
      e.preventDefault();
      var m=$(this).val(); 
      var permission=$(this).is(':checked');
      //alert(permission); 
      $.ajax({
     url: "<?php  echo base_url('dashboard/tokenSystemPermission'); ?>",
      type: 'POST',
      data: {id:m,permission:permission}
      //dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      if(data=='200'){
       }
      // $('#dynamic-content').html('');    
      // $('#dynamic-content').html(data); // load response 
      // $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      console.log(data); 
    });
      if($(this).is(':checked')){
        $(this).closest('.start_stop_tax').addClass('active');
      }
      else{
        $(this).closest('.start_stop_tax').removeClass('active');
      }
    })
    </script> 
<script>
function getSelectionStart(o) {
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate();
        r.moveEnd('character', o.value.length);
        if (r.text == '') return o.value.length
        return o.value.lastIndexOf(r.text)
    } else return o.selectionStart;
}
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
      return false;
    }
    return true;
}
function isNumberKey1dc(el,evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode;
  var number = el.value.split('.');
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
  }
  //just one dot
  if(number.length>1 && charCode == 46){
       return false;
  }
  //get the carat position
  var caratPos = getSelectionStart(el);
  var dotPos = el.value.indexOf(".");
  if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
      return false;
  }
  return true;
}
$(document)
.on('keydown click', '#activation_dynamic-content1 .required', function(e){
  console.log('clicked')
  $('#activation_dynamic-content1 .form-group').removeClass('incorrect mandatory');
})    
.on('focus','input.us-ssn-no-enc',function(){
  $(this).attr('maxlength',9);
  $(this).val($(this).data('val'));
})
.ready(function(){
  $('input.us-ssn-no-enc').each(function(){
    if($(this).val()){
      $(this).trigger('blur');
    }
  })
})
.on('blur','input.us-ssn-no-enc',function(){
  $(this).attr('maxlength',11);
  var inpVal=$(this).val(),encPlaceh='';
  if(inpVal.length)
  {
    $(this).data('val',$(this).val().trim());
    var ttlL=$(this).val().trim().length;
    // console.log(ttlL)
    for (var i = 0; i < ttlL; i++) 
    {
      if(i == 3 || i == 6)
      {
        encPlaceh+='-';
      }
      else if(i<= 5)
      {
        encPlaceh+='x';
      }
      else{
        i = ttlL;
        encPlaceh+=inpVal.substr(5, ttlL-1);
      }
    }
    // console.log(encPlaceh)
    $(this).val(encPlaceh);
  }
  else{
    $(this).data('val','');
  }
})
.on('click', '#getUser', function(e){
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
})
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
    function confirm_email(id)
    {
      if(confirm('Are you sure confirm_email this Merchant?'))
      {
          $.ajax({
            url : "<?php echo base_url('dashboard/confirm_email')?>/"+id,
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
       }
   }
var merchant=<?php echo json_encode($mem)?>;
function viewDetails(key)
{  
  console.log(merchant[key]);
  //alert(key); 
  // $('#approved_merhcanturl').hide();
    if(merchant[key]["applicationstatus"]!="")
    {
      $('.applicationstatusDiv').show();
      $('#applicationstatus').html(merchant[key]["applicationstatus"]);
      $('#send_to_merhcant').hide();
      $('#approved_merhcanturl').show();
    }
    else
    {   
      $('.applicationstatusDiv').hide();
      $('#send_to_merhcant').show();
      $('#approved_merhcanturl').hide();
    }
  // alert(application_status); 
$("#business_name").val(merchant[key]["allDettils"]["business_name"]);
$("#business_dba_name").val(merchant[key]["allDettils"]["business_dba_name"]);
$("#taxid").val(merchant[key]["allDettils"]["taxid"]).mask("99-9999999");
$("#address1").val(merchant[key]["allDettils"]["address1"]);
$("#ownershiptype").val(merchant[key]["allDettils"]["ownershiptype"]);
$("#business_type").val(merchant[key]["allDettils"]["business_type"]);
var mm=merchant[key]["allDettils"]["month_business"];
var dd=merchant[key]["allDettils"]["day_business"];
var ymd=merchant[key]["allDettils"]["year_business"]? (merchant[key]["allDettils"]["year_business"] + '-'+ mm + '-'+ dd) : '' ;
$("#establishmentdate").val(ymd).datepicker('setDate', ymd);
$("#business_number").val(merchant[key]["allDettils"]["business_number"]).mask("(999) 999-9999");
$("#customer_service_phone").val(merchant[key]["allDettils"]["customer_service_phone"]).mask("(999) 999-9999");
$("#business_email").val(merchant[key]["allDettils"]["business_email"]);
$("#customer_service_email").val(merchant[key]["allDettils"]["customer_service_email"]);
$("#website").val(merchant[key]["allDettils"]["website"]);
$("#annual_processing_volume").val(merchant[key]["allDettils"]["annual_processing_volume"]);
$("#year_business").val(merchant[key]["allDettils"]["day_business"]+' '+merchant[key]["allDettils"]["month_business"]+' ,20'+merchant[key]["allDettils"]["year_business"]);
$("#annual_processing_volume").val(merchant[key]["allDettils"]["annual_processing_volume"]);
$("#ien_no").val(merchant[key]["allDettils"]["ien_no"]);
$("#city").val(merchant[key]["allDettils"]["city"]);
$("#country").val(merchant[key]["allDettils"]["country"]);
$("#pc_name").val(merchant[key]["allDettils"]["o_name"]); //pc_name
$("#pc_title").val(merchant[key]["allDettils"]["pc_title"]);  //  pc_title
$("#pc_address").val(merchant[key]["allDettils"]["o_address1"]);  // pc_address
$("#pc_email").val(merchant[key]["allDettils"]["o_email"]);   //  pc_email
$("#pc_phone").val(merchant[key]["allDettils"]["o_phone"]).mask("(999) 999-9999");   //  pc_phone 
$("#monthly_fee").val(merchant[key]["allDettils"]["monthly_fee"]);
$("#vm_cardrate").val(merchant[key]["allDettils"]["vm_cardrate"]);
$("#dis_trans_fee").val(merchant[key]["allDettils"]["dis_trans_fee"]); // 
$("#amexrate").val(merchant[key]["allDettils"]["amexrate"]);
$("#monthly_gateway_fee").val(merchant[key]["allDettils"]["monthly_gateway_fee"]);
$("#chargeback").val(merchant[key]["allDettils"]["chargeback"]);
$("#annual_cc_sales_vol").val(merchant[key]["allDettils"]["annual_cc_sales_vol"]);
$("#checkbox").val(merchant[key]["allDettils"]["checkbox"]);
$("#question").val(merchant[key]["allDettils"]["question"]);
$("#billing_descriptor").val(merchant[key]["allDettils"]["billing_descriptor"]);
$("#name").val(merchant[key]["allDettils"]["o_name"]);
$("#o_dob").val(merchant[key]["allDettils"]["dob"]).datepicker('setDate', merchant[key]["allDettils"]["dob"]);;
if(merchant[key]["allDettils"]["o_ss_number"]){
var newval=merchant[key]["allDettils"]["o_ss_number"];
newval=newval.replace(/[\(\)-\s]/g,''); }
$("#o_ss_number").data('val',newval);
$("#o_ss_number").val(newval).trigger('blur');
$("#o_phone").val(merchant[key]["allDettils"]["o_phone"]).mask("(999) 999-9999");
$("#o_email").val(merchant[key]["allDettils"]["o_email"]);
$("#o_address").val(merchant[key]["allDettils"]["o_address1"]);
$("#bank_dda").val(merchant[key]["allDettils"]["bank_dda"]);
$("#bank_ach").val(merchant[key]["allDettils"]["bank_ach"]);
$("#bank_routing").val(merchant[key]["allDettils"]["bank_routing"]);
$("#bank_account").val(merchant[key]["allDettils"]["bank_account"]);
$("#approved_merhcanturl").attr("href","<?php  echo base_url('dashboard/Approved_merchant/') ?>"+merchant[key]["allDettils"]["id"]);
$('#key').val(merchant[key]["allDettils"]["id"]);  
// setTimeout(function(){
//   $("#activation_dynamic-content1 .us-phone-no").mask("(999) 999-9999");
//   $("#activation_dynamic-content1 .us-tin-no").mask("99-9999999");
// },300)
}
 </script>
 <script type="text/javascript">
function checkApplicationStatusFn()
{
$('#checkapplicationstatus').addClass('active');
// console.log('checkApplicationStatus');
var merchant_id= $('#key').val();
$.ajax({
url : "<?php echo base_url('dashboard/getmerchantDetails'); ?>",
type: "POST",
dataType: "JSON",
data: {'merchant_id':merchant_id},
success: function(data)
{
  console.log(data);
// console.log(data.ApplicationStatus);
// if(data.ApplicationStatus)
// {
// $('#send_to_merhcant').hide(); 
// $('#approved_merhcanturl').show(); 
// $('.error-section').html(""); 
// $('.applicationstatus').html('<span class="text-success">'+data.ApplicationStatusLabel+'</span>');
// }
// else
// {
// $('#send_to_merhcant').html('Send to underwriting');
// $('.error-section').html(""); 
// $('.error-message').html('<span class="text-danger">Somthing went Wrong!</span>');
// }
// $('#checkapplicationstatus').removeClass('active');
},
error: function (jqXHR, textStatus, errorThrown)
{
$('#checkapplicationstatus').removeClass('active');
alert('Somthing went Wrong!');
}
});
}
function  Api_merhcant()
 {        
if(validateMerchantApi($('#activation_dynamic-content1')))
{
if(confirm('Are you sure send to Merchant?'))
{ 
$('#send_to_merhcant').html('Wait...');
$.ajax({
url : "<?php echo base_url('dashboard/merchant_api'); ?>",
type: "POST",
dataType: "JSON",
data: getWholeData(),
success: function(data)
{
console.log(data); 
if(data.Status=='30')
{
$('#send_to_merhcant').hide(); 
$('#approved_merhcanturl').show(); 
$('.error-section').html(""); 
$('.error-message').html('<span class="text-success">Send Successfully..</span>');
$('.applicationstatusDiv').show();
$('#applicationstatus').html('<span class="text-success">Submission successful.</span>');
//alert('success'); 
}
else if(data.Status=='400' ||  data.Status=='40')
{
$('#send_to_merhcant').html('Send to underwriting');
$('.error-section').html(""); 
$('.error-message').html('<span class="text-danger">All Fields Are Required..</span>');
}
else
{
$('#send_to_merhcant').html('Send to underwriting');
$('.error-section').html(data.StatusMessage); 
if(data.Errors.length > 0)  
{
var i=0;
for(i=0;i<data.Errors.length; i++)
{
//console.log(data.Errors[i].Message);
$('.error-message').append('<span class="text-danger">'+data.Errors[i].Message+'</span><br/>');
}
} 
}
},
error: function (jqXHR, textStatus, errorThrown)
{
alert('Error  data');
$('#send_to_merhcant').html('Send to underwriting');
$('.error-section').html(""); 
$('.error-message').html('<span class="text-danger">Error  data</span>');
}
});
}  
}
else{
//do nothing
}
}
function printDiv(printableArea){
document.getElementById(printableArea).classList.remove("print_button");
var printContents = document.getElementById(printableArea).innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();
document.body.innerHTML = originalContents;
}
// var doc = new jsPDF();
var specialElementHandlers = {
'#div_button': function (element, renderer) {
return true;
}
};
</script>
</body>
</html>