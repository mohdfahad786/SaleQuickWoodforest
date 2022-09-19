<?php
    include_once 'header_dash.php';
    include_once 'sidebar_dash.php';
?>

<style>
    table tbody tr td span.dtr-data {
        display: inline !important;
    }
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
    }
    .btn:not(.social-icon-btn).social-btn-outlined {
        width: 126px !important;
    }
    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
        top: auto !important;
        left: 0px !important;
    }
    .nav-tabs .nav-link {
        font-family: 'Avenir-Black' !important;
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
    .btn-sm {
        margin-right: 10px;
    }
    .btn-warning, .btn-gray, .btn-danger {
        padding: 7px 15px !important;
    }
    @media screen and (max-width: 640px) {
        #pos_list_daterange span {
            font-size: 10px !important;
        }
        select.form-control {
            font-size: 10px !important;
        }
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
        }
        .btn.social-btn-outlined i.medium {
            margin-right: 10px !important;
        }
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

            <div class="row" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo (date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))) ?>
                        </span>
                        <input name="start_date" id="startDate" type="hidden" value="">
                        <input name="end_date" id="endDate" type="hidden" value="">
                    </div>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <?php if (!empty($status) && isset($status)) { ?>
                            <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?>>Pending</option>
                            <option value="active" <?php echo (($status == 'active') ? 'selected' : "") ?>>Active</option>
                            <option value="block" <?php echo (($status == 'block') ? 'selected' : "") ?>>Block</option> 
                        <?php } else { ?>
                            <option value="pending">Pending</option>          
                            <option value="active">Active</option>
                            <option value="block">Block</option> 
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search" style="text-transform: none !important;"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </div>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="all_subuser_dt" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Sub User ID</th>
                                <th>Merchant ID</th>
                                <th>Merchant DBA</th>
                                <th>Account Status</th>
                                <th align="center">Account Details</th>
                            </tr>
                        </thead>
                        
                    </table>
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
        <!-- <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> </div> -->
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
        <button type="submit" name="submit" id="update_cr_cred" class="btn btn-first waves-effect waves-light" data-dismiss="modal" >Update</button>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/new_assets/css/sweetalert.css">
<script src="<?php echo base_url(); ?>/new_assets/js/sweetalert.js"></script>
<script type="text/javascript">
    function dateFormatter(date) {
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = year+'-'+month+'-'+day;
        return date;
    };

    $(function() {
        var start = moment().subtract(10, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            $('#startDate').val(start.format('YYYY-MM-D'));
            $('#endDate').val(end.format('YYYY-MM-D'));
        }

        $('#daterangeFilter').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });

    <?php if(isset($merchant_id) && !empty($merchant_id)) {
        $merchant_id_post = $merchant_id;
    } else {
        $merchant_id_post = '';
    } ?>

    $(document).ready(function() {
        fill_datatable();

        function fill_datatable(start_date = '', end_date = '', status = '') {
            var table;
            table = $('#all_subuser_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 25,
                // "dom": 'lBfrtip',
                responsive: true,
                "order": [],
                
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('dashboard/getAllSubMerchants'); ?>",
                    data: {
                        'start_date'    : start_date,
                        'end_date'      : end_date,
                        'status'        : status,
                        'merchant_id'   : '<?php echo $merchant_id_post; ?>',
                    },
                    "type": "POST"
                },
                language: {
                    search: '', searchPlaceholder: "Search",
                    oPaginate: {
                        sNext: '<i class="fa fa-angle-right"></i>',
                        sPrevious: '<i class="fa fa-angle-left"></i>',
                        sFirst: '<i class="fa fa-step-backward"></i>',
                        sLast: '<i class="fa fa-step-forward"></i>'
                    }
                },
                "columnDefs": [{ 
                    "targets": [0],
                    "orderable": false
                }]
            });
        }
        // console.log(table.context[0].ajax)

        $(document).on('click', '#mysubmit', function() {
            // console.log(table, 'mysubmit');return false;
            var start_date = dateFormatter($('#startDate').val());
            var end_date = dateFormatter($('#endDate').val());
            var status = $('#status').val();

            $('#dt_inv_pos_sale_list').DataTable().destroy();
            fill_datatable(start_date, end_date, status);
        })
    });

    $(document).on('click', '#getcredt', function(e){
        e.preventDefault();
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
            url: "<?php  echo base_url('Admin_Backend/search_record_credntl'); ?>",
            data: {id: tax},
            type:'post',
            success: function (dataJson) {
                data = JSON.parse(dataJson);
                // console.log(data)
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

    $(document).on('click', '#update_cr_cred', function(e){
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
        var updateData = {
            id: tax,
            auth_code: auth_code,
            api_key: api_key,
            connection_id: connection_id,
            min_shop_supply: min_shop_supply,
            max_shop_supply: max_shop_supply,
            shop_supply_percent: shop_supply_percent,
            protractor_tax_percent: protractor_tax_percent,
            b_code: b_code,
            d_code: d_code,
            t_code: t_code,
            t1_code_name : t1_code_name,
            t1_code_value : t1_code_value,
            t2_code_name : t2_code_name,
            t2_code_value : t2_code_value,
            a_code_name : a_code_name,
            a_code_value : a_code_value,
            a_min_value : a_min_value,
            a_max_value : a_max_value,
            a_fixed : a_fixed,
            c_code_name : c_code_name,
            c_code_value : c_code_value,
            c_min_value : c_min_value,
            c_max_value : c_max_value,
            c_fixed : c_fixed,
            e_code_name : e_code_name,
            e_code_value : e_code_value,
            e_min_value : e_min_value,
            e_max_value : e_max_value,
            e_fixed : e_fixed,
            f_code_name : f_code_name,
            f_code_value : f_code_value,
            f_min_value : f_min_value,
            f_max_value : f_max_value,
            f_fixed : f_fixed,
            g_code_name : g_code_name,
            g_code_value : g_code_value,
            g_min_value : g_min_value,
            g_max_value : g_max_value,
            g_fixed : g_fixed,
            t1_code_name : t1_code_name,
            t1_code_value : t1_code_value,
            t1_min_value : t1_min_value,
            t1_max_value : t1_max_value,
            t1_fixed : t1_fixed,
            t2_code_name : t2_code_name,
            t2_code_value : t2_code_value,
            t2_min_value : t2_min_value,
            t2_max_value : t2_max_value,
            t2_fixed : t2_fixed,
            t3_code_name : t3_code_name,
            t3_code_value : t3_code_value,
            t3_min_value : t3_min_value,
            t3_max_value : t3_max_value,
            t3_fixed : t3_fixed,
            url_cr : url_cr,
            username_cr : username_cr,
            password_cr : password_cr,
            api_key_cr : api_key_cr,
            account_id : account_id,
            account_token : account_token,
            application_id : application_id,
            acceptor_id : acceptor_id,
            terminal_id : terminal_id
        }

        $.ajax({
            type: 'POST',
            url: "<?php  echo base_url('Admin_Backend/search_record_update'); ?>",
            data: updateData,
            type:'post',
            success: function (dataJson) {
                data = JSON.parse(dataJson)
                // console.log(data)
                $(data).each(function (index, element) {
                });
            }
        });
    });
</script>
<?php include_once'footer_dash.php'; ?>