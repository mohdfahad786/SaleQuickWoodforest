<?php
    include_once 'header_dash.php';
    include_once 'sidebar_dash.php';
    //echo '<pre>';print_r($_SESSION);
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
    @media screen and (max-width: 640px) {
        #daterangeFilter span {
            font-size: 10px !important;
        }
    }
    @media screen and (max-width: 640px) {
        select.form-control {
            font-size: 10px !important;
        }
    }
    @media screen and (max-width: 420px) {
        select.form-control {
            margin-left: 5px !important;
        }
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
    }
    .btn:not(.social-icon-btn).social-btn-outlined {
        width: 126px !important;
    }
    @media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.medium {
            margin-right: 10px !important;
        }
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
    .highliter {
        -webkit-animation: blinkAnim 0.5s ease-in-out 0s infinite;
        animation: blinkAnim 0.5s ease-in-out 0s infinite;
    }
    @-webkit-keyframes blinkAnim {
        from {
            color: #333;
            background-color: #ffc107;
            border-color: #ffc107;
        }
        to {
            background-color: #17a2b8;
        }
    }
    @keyframes blinkAnim {
        from {
            color: #333;
            background-color: #ffc107;
            border-color: #ffc107;
        }
        to {
            background-color: #17a2b8;
        }
    }
    
    .span_lg_btn {
        margin-bottom: 5px;
        /*width: 190px;*/
    }
    .span_sm_btn {
        padding: 7px 15px !important;
        margin-bottom: 5px;
        margin-left: 5px;
    }
    .start_stop_payroc {
        max-width: 121px;
        margin: 0 auto;
    }
    .start_stop_payroc .switch.switch_type1 {
        margin: 0 15px 0 0;
    }
    .start_stop_payroc .switch__label {
        color: #fff;
        line-height: 25px;
        padding-left: 7px;
    }
    .start_stop_payroc .msg {
        color: #000 !important;
    }
    .start_stop_payroc.active .stop {
        display: initial;
    }
    .start_stop_payroc.active .start {
        display: none;
    }
    .start_stop_payroc:not(.active) .stop {
        display: none;
    }
    .start_stop_payroc:not(.active) .start {
        display: initial;
    }
    @media screen and (max-width: 970px) {
        .start_stop_tax {
            margin: 0 !important;
        }
        .start_stop_payroc {
            margin: 0 !important;
        }
        .all_mer_tbl_btns {
            display: block !important;
            max-width: 390px !important;
            white-space: normal !important;
        }
        .sm_btn_row {
            display: inline !important;
        }
        .span_sm_btn {
            width: 58px !important;
        }
    }
    @media screen and (max-width: 460px) {
        .all_mer_tbl_btns .btn,
        .all_mer_tbl_btns .btn i,
        .modal-dialog input::placeholder {
            font-size: 10px !important;
        }
        .all_mer_tbl_btns {
            max-width: 300px !important;
        }
        .span_lg_btn {
            width: 140px !important;
            height: 35px !important;
            max-height: 30px !important;
            padding: 0px 5px !important;
        }
        .sm_btn_row {
            display: inline !important;
        }
        .span_sm_btn {
            padding: 7px 15px !important;
            height: 35px !important;
            max-height: 30px !important;
            width: 41px !important;
        }
        #del-bt {
            margin-right: -3px !important;
        }
        .modal-dialog .btn-first {
            font-size: 13px !important;
        }
        .modal-dialog .custom-form .form-control:not(textarea),
        .modal-dialog .custom-form .input-group-addon {
            height: 35px !important;
        }
        #view-modall .modal-title, #view-ActivationDetails .modal-title {
            font-size: 16px !important;
        }
    }
    @media screen and (min-width: 730px) {
        #view-modall .modal-dialog, #view-ActivationDetails .modal-dialog {
            min-width: 690px !important;
        }
    }
    @media screen and (max-width: 560px) {
        #dynamic-content1 ul li a, #activation_dynamic-content1 ul li a {
            font-size: 10px !important;
        }
        #dynamic-content1 .nav-link, #activation_dynamic-content1 .nav-link {
            padding: 5px 10px !important;
        }
        #dynamic-content1 label, #activation_dynamic-content1 label {
            font-size: 10px !important;
        }
    }
    .modal-dialog .btn-first {
        height: 35px !important;
        max-height: 35px !important;
        padding: .5rem 1rem !important;
        font-family: AvenirNext-Medium !important;
    }
    @media screen and (max-width: 500px) {
        .modal-dialog {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }
    }
    #all_subuser_dt_filter input {
        border: 2px solid rgba(210, 223, 245) !important;
    }
    @media (min-width: 576px) {
        #view_all_subuser .modal-dialog {
            max-width: initial !important;
        }
    }
    .modal-content {
        background-color: #f8f8f8 !important;
    }
    .custom-form label {
        font-weight: 100 !important;
    }
    @media screen and (max-width: 640px) {
        .custom-form label {
            font-size: 11px !important;
        }
    }
    @media screen and (min-width: 641px) {
        .custom-form label {
            font-size: 13px !important;
        }
    }
    .nav_btn_style {
        width: 100px;
        margin-right: 5px;
    }
    .contactClick, .companyInfoClick {
        cursor: pointer;
    }
    .form-group.mandatory select,
    .form-group.mandatory input {
        background-color: #FF6347;
    }
    .table.dataTable tbody td {
        vertical-align: middle !important;
    }
    .nav-tabs>li {
        float: left;
        margin-bottom: -1px;
        position: relative;
        display: block;
    }
    ul.status_tabs a {
        color: #337ab7;
        text-decoration: none !important;
    }
    .status_tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        position: relative;
        display: block;
        padding: 10px 15px;
        font-family: Avenir-Heavy !important;
    }
    .status_tabs>li.active>a, .status_tabs>li.active>a:focus, .status_tabs>li.active>a:hover {
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    .confirm, .cancel {
        padding: 7px 21px !important;
        height: 40px !important;
        max-height: 40px !important;
    }
    .add-merchant {
        width: auto;
        height: 40px;
        background: rgb(237, 237, 237);
        border: none;
        border-radius: 8px;
        color: rgb(132, 132, 132);
        font-size: 16px;
        font-weight: 400;
        padding: 10px 20px 10px 20px;
        font-family: Avenir-Black !important;
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

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <ul class="nav nav-tabs status_tabs" style="margin: 20px 0px 22px;visibility: visible;">
                        <li class="active"><a class="status_tab_anchor" href="javascript:void(0)" data-val="">All</a></li>
                        <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="active">Active</a></li>
                        <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="pending">Pending</a></li>
                        <!-- <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="Waiting_For_Approval">Waiting For Approval</a></li>
                        <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="confirm">Confirm</a></li>
                        <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="active">Active</a></li>
                        <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="block">Block</a></li> -->
                        <li><a class="status_tab_anchor" href="javascript:void(0)" data-val="deactivate">Deactivated</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="col-12 py-5 py-5-custom text-right">
                        <a class="add-merchant" href="<?php echo base_url('dashboard/add_merchant'); ?>"><i class="fa fa-plus"></i> Add Merchant</a>
                    </div>
                </div>
            </div>
            <!-- <hr> -->
            
            <div class="row">
                <div class="col-12">
                    <table id="dt_inv_pos_sale_list" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <!-- <th>DBA Name</th> -->
                                <th>Action</th>
                                <th style="width: 10% !important;">Status</th>
                                <th>Company Name</th>
                                <th>Contact</th>
                                <!-- <th>Phone NO</th> -->
                                <!-- <th>Contact</th> -->
                                <!-- <th style="width: 10% !important;">Payroc</th> -->
                                <!-- <th style="width: 10% !important;">Tokenized System</th> -->
                                <th>Details</th>
                                <th>Monthly Volume</th>
                                <?php if( ($_SESSION['id'] == 1) || ($_SESSION['id'] == 2) || ($_SESSION['id'] == 4) || ($_SESSION['id'] == 8) ) { ?>
                                    <th>Status Action</th>
                                <?php } ?>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body contactModalBody"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="companyInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body companyInfoModalBody"></div>
    </div>
  </div>
</div>

<!-- Merchant Credentials Modal -->
<div id="view-modall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog col-sm-6 col-md-8 col-lg-8">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="row">
                    <div class="col-12" style="display: flex;">
                        <div>
                            <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Merchant Credentials </h4>
                        </div>
                        <div id="payment_method_name" style="margin-top: 3px;margin-left: 10px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body custom-form">
                <div id="modal-loader" class="text-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
                </div>
                <!-- content will be load here -->
                <div id="dynamic-content1">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                                <li class="nav-item">
                                    <a class="cred_nav_link nav-link active" data-toggle="tab" href="#genDetail">General</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#backofficeCreds">Backoffice Credentials</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#t1Detail">t1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#t2Detail">t2</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#t3Detail">t3</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#aDetail">A</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#cDetail">C</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#eDetail">E</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#fDetail">F</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-none" data-toggle="tab" href="#gDetail">G</a>
                                </li>
                                <li class="nav-item">
                                    <a class="cred_nav_link nav-link" data-toggle="tab" href="#cnpDetail">WorldPay/FIS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="cred_nav_link nav-link" data-toggle="tab" href="#tsysDetail">TSYS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="cred_nav_link nav-link" data-toggle="tab" href="#wfDetail">WoodForest</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane container active" id="genDetail">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Connection ID</label>
                                                <input type="hidden" id="payroc_value" value="">
                                                <div>
                                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" name="connection_id" id="connection_id" placeholder="Connection ID:">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>API Key</label>
                                                <div>
                                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                        <input type="text" class="form-control" autocomplete="off" name="api_key" id="api_key"  placeholder="API Key" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Auth Code</label>
                                                <div>
                                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                        <input type="text" class="form-control" autocomplete="off" name="auth_code" id="auth_code"  placeholder="Auth Code" >
                                                        <input type="hidden" class="form-control" id="m_id">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Min Shop Supply Value</label>
                                                <div>
                                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                        <input type="text" class="form-control" autocomplete="off" name="min_shop_supply" id="min_shop_supply"  placeholder="Min Shop Supply Value" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Max Shop Supply Value</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="max_shop_supply" id="max_shop_supply"  placeholder="Max Shop Supply Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Shop Supply Percent</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="shop_supply_percent" id="shop_supply_percent"  placeholder="Shop Supply Percent" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Protractor Tax Percent</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="protractor_tax_percent" id="protractor_tax_percent"  placeholder="Protractor Tax Percent" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>B Code</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="b_code" id="b_code"  placeholder="B Code" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>D Code</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="d_code" id="d_code"  placeholder="D Code" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>T Code</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t_code" id="t_code"  placeholder="T Code" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>URL_CR</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="url_cr" id="url_cr"  placeholder="URL_CR" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                         <div class="col-6">
                                          <div class="form-group">
                                            <label>Username_CR</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="username_cr" id="username_cr"  placeholder="Username_CR" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                         <div class="col-6">
                                          <div class="form-group">
                                            <label>Password_CR</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="password_cr" id="password_cr"  placeholder="Password_CR" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Api_Key_CR</label>
                                            <div >
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="api_key_cr" id="api_key_cr"  placeholder="Api_Key_CR" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="tab-pane container fade" id="backofficeCreds">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <span class="start_stop_payroc">
                                                <label class="switch switch_type1" role="switch" style="z-index: 0 !important;">
                                                    <input type="checkbox" class="switch__toggle"  id="switchval_413" value="413">
                                                    <span class="switch__label">|</span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row worldpay_mode d-none">
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>TerminalID_CNP</label>
                                             <div>
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="terminal_id" id="terminal_id"  placeholder="Terminal ID" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>AccountID_CNP</label>
                                          <div class="form-group">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="account_id" id="account_id"  placeholder="AccountID" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>AccountToken_CNP</label>
                                          <div class="form-group">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="account_token" id="account_token"  placeholder="AccountToken" >
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>ApplicationID_CNP</label>
                                          <div class="form-group">
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="application_id" id="application_id"  placeholder="ApplicationID" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>AcceptorID_CNP</label>
                                          <div class="form-group">
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="acceptor_id" id="acceptor_id"  placeholder="AcceptorID" >
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row payroc_mode">
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>POS MID</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_pos_mid" id="pax_pos_mid" placeholder="POS MID">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>V Number</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_v_no" id="pax_v_no" placeholder="V Number">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>BIN Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_bin" id="pax_bin" placeholder="BIN Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Agent Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_agent" id="pax_agent" placeholder="Agent Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Chain</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_chain" id="pax_chain" placeholder="Chain">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Store NO</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_store_no" id="pax_store_no" placeholder="Store NO">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Terminal NO</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_terminal_no" id="pax_terminal_no" placeholder="Terminal NO">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Currency Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_currency_code" id="pax_currency_code" placeholder="Currency Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Country Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_country_code" id="pax_country_code" placeholder="Country Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Location NO</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_location_no" id="pax_location_no" placeholder="Location NO">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Timezone Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_timezone" id="pax_timezone" placeholder="Timezone Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>MCC/SIC</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_mcc_sic" id="pax_mcc_sic" placeholder="MCC/SIC">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Processor ID</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="processor_id" id="processor_id" placeholder="Processor ID">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="tab-pane container fade d-none" id="t1Detail">
                                    <div class="row">
                                        <div class="col-12">
                                          <label>T1</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t1_code_name" id="t1_code_name"  placeholder="T1 Name" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t1_code_value" id="t1_code_value"  placeholder="T1 Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <label>T1 value(Max/Min)</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t1_max_value" id="t1_max_value"  placeholder="Max value" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t1_min_value" id="t1_min_value"  placeholder="Min Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <label>T1 value(Fixed)</label>
                                            <div class="form-group row">
                                               <div class="col-md-12">
                                                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="t1_fixed" id="t1_fixed"  placeholder="Fixed Value" >
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade d-none" id="t2Detail">
                                    <div class="row">
                                        <div class="col-12">
                                          <label>T2</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t2_code_name" id="t2_code_name"  placeholder="T2 Name" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t2_code_value" id="t2_code_value"  placeholder="T2 Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <label>T2 value(Max/Min)</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t2_max_value" id="t2_max_value"  placeholder="Max value" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="t2_min_value" id="t2_min_value"  placeholder="Min Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <label>T2 value(Fixed)</label>
                                          <div class="form-group">
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="t2_fixed" id="t2_fixed"  placeholder="Fixed Value" >
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade d-none" id="t3Detail">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>T3</label>
                                            <div class="form-group row">
                                              <div class="col-6">
                                                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="t3_code_name" id="t3_code_name"  placeholder="T3 Name" >
                                                </div>
                                              </div>
                                              <div class="col-6">
                                                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="t3_code_value" id="t3_code_value"  placeholder="T3 Value" >
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label>T3 value(Max/Min)</label>
                                            <div class="form-group row">
                                                <div class="col-6">
                                                  <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                    <input type="text" class="form-control" autocomplete="off"   name="t3_max_value" id="t3_max_value"  placeholder="Max value" >
                                                  </div>
                                                </div>
                                                <div class="col-6">
                                                  <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                    <input type="text" class="form-control" autocomplete="off"   name="t3_min_value" id="t3_min_value"  placeholder="Min Value" >
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                          <label>T3 value(Fixed)</label>
                                          <div class="form-group">
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="t3_fixed" id="t3_fixed"  placeholder="Fixed Value" >
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade d-none" id="aDetail">
                                    <div class="row">
                                        <div class="col-12">
                                          <label>A</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="a_code_name" id="a_code_name"  placeholder="A Name" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="a_code_value" id="a_code_value"  placeholder="A Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <label>A value(Max/Min)</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="a_max_value" id="a_max_value"  placeholder="Max value" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
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
                                <div class="tab-pane container fade d-none" id="cDetail">
                                    <div class="row">
                                        <div class="col-12">
                                          <label>C</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="c_code_name" id="c_code_name"  placeholder="C Name" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="c_code_value" id="c_code_value"  placeholder="C Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <label>C value(Max/Min)</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="c_max_value" id="c_max_value"  placeholder="Max value" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="c_min_value" id="c_min_value"  placeholder="Min Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <label>C value(Fixed)</label>
                                            <div class="form-group">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="c_fixed" id="c_fixed"  placeholder="Fixed Value" >
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade d-none" id="eDetail">
                                    <div class="row">
                                        <div class="col-12">
                                          <label>E</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="e_code_name" id="e_code_name"  placeholder="E Name" >
                                              </div>
                                            </div>
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="e_code_value" id="e_code_value"  placeholder="E Value" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <label>E value(Max/Min)</label>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
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
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="e_fixed" id="e_fixed"  placeholder="Fixed Value" >
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade d-none" id="fDetail">
                                  <div class="row">
                                    <div class="col-12">
                                      <label>F</label>
                                      <div class="form-group row">
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="f_code_name" id="f_code_name"  placeholder="F Name" >
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="f_code_value" id="f_code_value"  placeholder="F Value" >
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <label>F value(Max/Min)</label>
                                      <div class="form-group row">
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="f_max_value" id="f_max_value"  placeholder="Max value" >
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="f_min_value" id="f_min_value"  placeholder="Min Value" >
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <label>F value(Fixed)</label>
                                      <div class="form-group">
                                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                        <input type="text" class="form-control" autocomplete="off"   name="f_fixed" id="f_fixed"  placeholder="Fixed Value" >
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="tab-pane container fade d-none" id="gDetail">
                                  <div class="row">
                                    <div class="col-12">
                                      <label>G</label>
                                      <div class="form-group row">
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="g_code_name" id="g_code_name"  placeholder="G Name" >
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="g_code_value" id="g_code_value"  placeholder="G Value" >
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <label>G value(Max/Min)</label>
                                      <div class="form-group row">
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="g_max_value" id="g_max_value"  placeholder="Max value" >
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                            <input type="text" class="form-control" autocomplete="off"   name="g_min_value" id="g_min_value"  placeholder="Min Value" >
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="form-group">
                                        <label>G value(Fixed)</label>
                                         <div >
                                          <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
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
                                          <div class="form-group">
                                            <label>TerminalID_CNP</label>
                                             <div>
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="terminal_id" id="terminal_id"  placeholder="Terminal ID" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>AccountID_CNP</label>
                                          <div class="form-group">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off"   name="account_id" id="account_id"  placeholder="AccountID" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>AccountToken_CNP</label>
                                          <div class="form-group">
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                <input type="text" class="form-control" autocomplete="off"   name="account_token" id="account_token"  placeholder="AccountToken" >
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>ApplicationID_CNP</label>
                                          <div class="form-group">
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="application_id" id="application_id"  placeholder="ApplicationID" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <label>AcceptorID_CNP</label>
                                          <div class="form-group">
                                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                              <input type="text" class="form-control" autocomplete="off"   name="acceptor_id" id="acceptor_id"  placeholder="AcceptorID" >
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="tsysDetail">
                                    <div class="row">
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>POS MID</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_pos_mid" id="pax_pos_mid" placeholder="POS MID">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>V Number</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_v_no" id="pax_v_no" placeholder="V Number">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>BIN Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_bin" id="pax_bin" placeholder="BIN Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Agent Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_agent" id="pax_agent" placeholder="Agent Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Chain</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_chain" id="pax_chain" placeholder="Chain">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Store NO</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_store_no" id="pax_store_no" placeholder="Store NO">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Terminal NO</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_terminal_no" id="pax_terminal_no" placeholder="Terminal NO">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Currency Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_currency_code" id="pax_currency_code" placeholder="Currency Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Country Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_country_code" id="pax_country_code" placeholder="Country Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Location NO</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_location_no" id="pax_location_no" placeholder="Location NO">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Timezone Code</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_timezone" id="pax_timezone" placeholder="Timezone Code">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>MCC/SIC</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="pax_mcc_sic" id="pax_mcc_sic" placeholder="MCC/SIC">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Processor ID</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="processor_id" id="processor_id" placeholder="Processor ID">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label>Security Key</label>
                                             <div>
                                              <div class="input-group">
                                                  <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="security_key_value" id="security_key_value" placeholder="Security Key">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="vtsDetail">
                                    <div class="row">
                                        <div class="col-6">
                                          <div class="form-group d-none">
                                            <label>Pin Number</label>
                                             <div>
                                              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                                                  <input type="text" class="form-control" autocomplete="off" name="PinNumber" id="PinNumber" placeholder="Pin Number">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label>is VTS?</label>
                                            <div class="vts_switch_section">
                                                <label class="switch switch_type1" role="switch">
                                                    <input type="checkbox" name="late_fee_status" checked id="late_fee_status" value="" class="switch__toggle">
                                                    <span class="switch__label"></span>
                                                </label>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="wfDetail">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Activate Woodforest Account</label>
                                                <div class="wf_switch_section">
                                                    <label class="switch switch_type1" role="switch">
                                                        <input type="checkbox" name="wood_forest" checked id="wood_forest" value="" class="switch__toggle">
                                                        <span class="switch__label"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Billing Package</label>
                                                <select class="form-control" id="package_value" name="package_value">
                                                    <option value="">Please select</option>
                                                    <option value="1">Mobile App Only</option>
                                                    <option value="2">Mobile Only With Other Charges</option>
                                                    <option value="3">All in one (Access to all our products)</option>
                                                    <option value="4">All in one + Other charges (Access to all our products)</option>
                                                </select>
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

<!-- Activation Details Modal -->
<div id="view-ActivationDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog col-sm-6 col-md-8 col-lg-8">
        <div class="modal-content" id="printableArea">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Activation Details </h4>
            </div>
            <div class="modal-body custom-form">
                <div id="modal-loader" class="text-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000">
                        <g fill="none" fill-rule="evenodd" stroke-width="2">
                            <circle cx="22" cy="22" r="19.8669">
                                <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate>
                                <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="22" cy="22" r="15.8844">
                                <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate>
                                <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate>
                            </circle>
                        </g>
                    </svg>
                </div>

                <div id="activation_dynamic-content1">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#primaryInfo">Primary Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#busInfo">Business Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#BusOwnInfo">Owner Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#BankInfo">Banking Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Pricing">Pricing</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane container active" id="primaryInfo">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" id="pc_name" class="form-control required" name="pc_name" /> 
                                            </div>
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input  type="text" id="pc_title" class="form-control required" name="pc_title" /> 
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input  type="text" id="pc_email" name="pc_email"  class="form-control required email" /> 
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input  type="text" id="pc_phone" name="pc_phone"  class="form-control required us-phone-no" /> 
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input  type="text" id="pc_address" class="form-control required" name="pc_address" /> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container" id="busInfo">
                                    <div class="row">
                                        <div class="col-sm-12" >
                                            <div class="form-group">
                                                <label>Legal Business Name</label>
                                                <input type="text" class="form-control required" id="business_name"> 
                                            </div>
                                            <div class="form-group">
                                                <label>DBA Name</label>
                                                <input type="text" class="form-control required" id="business_dba_name"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Tax Identification Number (TIN)</label>
                                                <input type="text" class="form-control required us-tin-no" id="taxid" onkeypress="return isNumberKey(event)"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Physical Address</label>
                                                <select class="form-control required" required autocomplete="off" id="busi_country">
                                                    <option value="">Select Country</option>
                                                    <option value="USA">United States of America</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Canada">Canada</option>
                                                </select>
                                                <input type="text" class="form-control required" id="address1">
                                                <!-- <input type="text" class="form-control" id="address2"> -->
                                                <input type="text" class="form-control required" id="busi_city">
                                                <select class="form-control required" id="busi_state" required autocomplete="off">
                                                    <option value="">Select State</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="DC">District Of Columbia</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                                <input type="text" class="form-control required" id="busi_zip">
                                            </div>
                                            <div class="form-group">
                                                <label>Ownership Type</label>
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
                                                <!-- <input type="text" class="form-control required" id="ownershiptype" >  -->
                                            </div>
                                            <div class="form-group">
                                                <label>Business Type</label>
                                                <div class="rel-div">
                                                    <select class="form-control required" name="bsns_type" required="" autocomplete="off" id="business_type">
                                                        <option value="">Select Business Type</option>
                                                        <option value="Service">Service</option>
                                                        <option value="ECommerce">E-Commerce</option>
                                                        <option value="Restaurant">Restaurant</option>
                                                        <option value="Retail">Retail</option>
                                                    </select>
                                                </div>
                                                <!-- <input type="text" class="form-control required" id="business_type" >  -->
                                            </div>
                                            <div class="form-group">
                                                <label>Business Establishment Date</label>
                                                <!-- <input type="text" class="form-control required us-date-calendar" id="establishmentdate" placeholder='yyyy-mm-dd'> --> 
                                                <input type="text" class="form-control required us-date-calendar" id="establishmentdate"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Business Phone Number</label>
                                                <input type="text" class="form-control required us-phone-no" id="business_number"  > 
                                            </div>
                                            <div class="form-group">
                                                <label>Customer Service Phone Number</label>
                                                <input type="text" class="form-control required us-phone-no" id="customer_service_phone" > 
                                            </div>
                                            <div class="form-group">
                                                <label>Business Email</label>
                                                <input type="text" class="form-control required email" id="business_email" > 
                                            </div>
                                            <div class="form-group">
                                                <label>Customer Service Email</label>
                                                <input type="text" class="form-control required email" id="customer_service_email" > 
                                            </div>
                                            <div class="form-group">
                                                <label>Business Website</label>
                                                <input type="text" class="form-control non_required" id="website"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container" id="BusOwnInfo">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Owner Name</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="text" class="form-control required" id="o_f_name">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" class="form-control non_required" id="o_m_name">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" class="form-control required" id="o_l_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3" style="display: inline-flex !important;    padding-left: 0 !important;">
                                                <input type="checkbox" id="o_question" name="o_question" class="form-control owner_check non_required" style="height: 15px !important;width: auto !important;" value=""> <span class="cs-label" style="margin-left:10px;">Are there any owners with 25% or more ownership?</span>
                                            </div>
                                            <div class="col-12 mb-3" style="display: inline-flex !important;    padding-left: 0 !important;">
                                                <input type="checkbox" id="is_primary_owner" name="is_primary_owner" class="form-control owner_check non_required" style="height: 15px !important;width: auto !important;" value=""> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Social Security Number</label>
                                                <input type="text" class="form-control required us-ssn-no-enc" id="o_ss_number"  onkeypress="return isNumberKey(event)" maxlength="11"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Ownership Percentage</label>
                                                <input type="text" class="form-control required" id="o_perc" onkeypress="return isNumberKey(event)"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Date Of Birth</label>
                                                <!-- <input type="text" class="form-control required us-date-calendar" id="o_dob" placeholder='yyyy-mm-dd'>  -->
                                                <input type="text" class="form-control required us-date-calendar" id="o_dob"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Home Address</label>
                                                <select class="form-control" id="o_country" required autocomplete="off">
                                                    <option value="">Select Country</option>
                                                    <option value="USA">United States of America</option>
                                                </select>
                                                <input type="text" class="form-control required" id="o_address1">
                                                <!-- <input type="text" class="form-control" id="o_address2"> -->
                                                <input type="text" class="form-control required" id="o_city">
                                                <select class="form-control required" id="o_state" required autocomplete="off">
                                                    <option value="">Select State</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="DC">District Of Columbia</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                                <input type="text" class="form-control required" id="o_zip" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="form-group">
                                                <label>Owner Phone</label>
                                                <input type="text" class="form-control required us-phone-no" id="o_phone" > 
                                            </div>
                                            <div class="form-group">
                                                <label>Owner Email</label>
                                                <input type="text" class="form-control required email" id="o_email" > 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container" id="BankInfo">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Bank Account DDA Type</label>
                                                <!-- <input type="text" class="form-control required" id="bank_dda" >  -->
                                                <div class="rel-div">
                                                    <select class="form-control required" name="bank_dda" id="bank_dda" required="">
                                                        <option value="">Select Bank Account DDA Type</option>
                                                        <option value="CommercialChecking">Commercial Checking</option>
                                                        <option value="PrivateChecking">Private Checking</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Bank Account ACH Type</label>
                                                <div class="rel-div">
                                                    <select class="form-control required" name="baccachtype" required="" id="bank_ach">
                                                        <option value="">Select Bank Account ACH Type</option>
                                                        <option value="CommercialChecking">Business Checking</option>
                                                        <option value="PrivateChecking">Personal Checking</option>
                                                    </select>
                                                </div>
                                                <!--  <input type="text" class="form-control required"  >  -->
                                            </div>
                                            <div class="form-group">
                                                <label>Routing Number</label>
                                                <input type="text" class="form-control required" id="bank_routing"  maxlength="9" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input type="text" class="form-control required" id="bank_account"  maxlength="17" onkeypress="return isNumberKey(event)"> 
                                            </div>
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control required" id="city" > 
                                            </div>
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control required" id="country" > 
                                            </div>
                                            <input  type="hidden" id="mycheckbox" class="hidden_inputs" name="mycheckbox"  value="1" />
                                            <div class="form-group d-none">
                                                <label>Question</label>
                                                <input  type="text" id="question" class="form-control required" name="question"  /> 
                                            </div>
                                            <div class="form-group d-none">
                                                <label>V Billing Descriptor </label>
                                                <input  type="text" id="billing_descriptor" class="form-control required" name="billing_descriptor"  /> 
                                            </div>
                                            <input type="hidden" id="key" class="hidden_inputs" name='key' />
                                            <input type="hidden" name="id" id="activation_id" class="hidden_inputs" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container" id="Pricing">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Billing Structure</label>
                                                        <div class="rel-div">
                                                            <select class="form-control required" name="billing_structure" id="billing_structure">
                                                                <option value="">Select Billing Structure</option>
                                                                <option value="Daily">Daily</option>
                                                                <option value="Monthly">Monthly</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Fee Structure</label>
                                                        <div class="rel-div">
                                                            <select class="form-control required" name="fee_structure" id="fee_structure">
                                                                <option value="">Select Fee Structure</option>
                                                                <option value="flat_rate">Flat Rate</option>
                                                                <option value="interchange_plus">Interchange Plus</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fee_input_section">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group fee_input_one d-none">
                                                            <label>Percentage Rate</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                                <input type="text" id="percentage_rate" name="percentage_rate" class="form-control required" onkeypress="return isDecimal(event)"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group fee_input_two d-none">
                                                            <label>Transaction Rate</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">$</span>
                                                                </div>
                                                                <input type="text" id="transaction_rate" name="transaction_rate" class="form-control required" onkeypress="return isDecimal(event)"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group d-none">
                                                <label>Dis Transaction Fee</label> 
                                                <input type="text" id="dis_trans_fee" class="form-control required" name="dis_trans_fee" onkeypress="return isNumberKey1dc(this,event)"/> 
                                            </div>
                                            <div class="form-group d-none">
                                                <label> Amexrate</label>
                                                <input type="text" id="amexrate" class="form-control required" name="amexrate" onkeypress="return isNumberKey(event)"/> 
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Chargeback</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="chargeback" class="form-control required" name="chargeback" onkeypress="return isDecimal(event)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Monthly Gateway Fee</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="monthly_gateway_fee" class="form-control required" name="monthly_gateway_fee" onkeypress="return isDecimal(event)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label>Annual CC Sales vol</label>
                                                <input type="text" id="annual_cc_sales_vol" class="form-control required" name="annual_cc_sales_vol" onkeypress="return isNumberKey1dc(this,event)"/>
                                                </div> -->
                                            <!-- <div class="form-group">
                                                <label>Monthly Fee</label>
                                                <input type="text" id="monthly_fee" name="monthly_fee" class="form-control required" onkeypress="return isNumberKey1dc(this,event)" /> 
                                                </div> -->
                                            <div class="form-group d-none">
                                                <label>vm Card Rate </label>
                                                <input type="text" id="vm_cardrate" name="vm_cardrate" class="form-control required" onkeypress="return isNumberKey(event)"/> 
                                            </div>
                                            <div class="form-group">
                                                <label>Estimated Annual Processing Volume</label>
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
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>CNP Percentage</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                            <input type="text" id="cnp_percent" name="cnp_percent" class="form-control required" onkeypress="return isDecimal(event)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>CP Percentage</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                            <input type="text" id="cp_percent" name="cp_percent" class="form-control required" onkeypress="return isDecimal(event)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Average Ticket</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="average_ticket" name="average_ticket" class="form-control required" onkeypress="return isDecimal(event)"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>High Ticket</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="high_ticket" name="high_ticket" class="form-control required" onkeypress="return isDecimal(event)"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group applicationstatusDiv">
                                                <label>Application Status</label>
                                                <br/>
                                                <span class="b text-success h4" id="applicationstatus"><?php echo $applicationstatus; ?></span>
                                                <span id="checkapplicationstatus" onclick="checkApplicationStatusFn()"   class="btn btn-first btn-xs" ><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error-section h4 text-danger "></div>
                    <div class="error-message h5 text-danger " style="padding-left: 15px !important;"> </div>
                </div>
                <div class="modal-footer" style="display: grid !important;">
                    <div class="row mail_status_row"></div>
                    <div class="row">
                        <div class="col-12" style="display: flex !important;">
                            <!-- <a href="" id="printButton" class="btn btn-first waves-effect waves-light custom-btn" onclick="printDiv('printableArea')" style="margin-left: 5px;">Print</a> -->
                            <a href="javascript:void(0)" id="saveMerchant" class="btn btn-first waves-effect waves-light custom-btn" onclick="saveMerchantDetail()" style="margin-right: 5px;">Save</a>
                            <?php //echo form_open('dashboard/Approved_merchant', array('id' => "activation_form"));?>
                            <form id="activation_form" action="dashboard/Approved_merchant">
                                <a id="approved_merhcanturl" class="btn btn-first waves-effect waves-light" href="#" style="margin-right: 5px;">Approve</a>
                            </form>
                            <a id="send_to_merhcant" onclick="Api_merhcant()" class="btn btn-first waves-effect waves-light" href="javascript:void(0)" >Send Mail to Merchant</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Detail Modal -->
<!-- <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
        <div id="dynamic-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-second" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<!-- Add sub user -->
<!-- <div id="add_subuser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closebtn" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Sub User</h4>
            </div>
            <div class="modal-body custom-form">
                <div id="modal-loader" class="text-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
                </div>
                <div id="dynamic-content_subuser">
                    <form id="pop_inputs">
                    <div class="row">
                        <input type="hidden" id="current_id" name="merchant_id">
                    
                            <div class="col-sm-6 col-md-12 col-lg-12">
                                
                        <div   style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-title">User Info</div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control" name="memail" id="email" pattern="[ a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Mobile Number</label>
                                                <input type="text" class="form-control" name="primary_phone" id="phone" onkeypress="return isNumberKey(event)" placeholder="Mobile Number" required="">
                                            </div>
                                        </div>

                                        <div class="col-12" style="display:none;">
                                            <div class="card content-card">
                                                <div class="card-detail">
                                                    <div class="row custom-form responsive-cols f-wrap f-auto">
                                                        <div class="col-12">
                                                            <div class="custom-form">
                                                                <div class="form-group">
                                                                    <p><b>Payment Type</b></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="ViewPermissions"   id="ViewPermissions" value="12a">
                                                                    <label for="ViewPermissions">View Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="AddPermissions"   id="AddPermissions" value="12b">
                                                                    <label for="AddPermissions">Add Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="EditPermissions"   id="EditPermissions" value="12c">
                                                                    <label for="EditPermissions">Edit Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                        <div class="col mx-253">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="DeletePermissions"  id="DeletePermissions" value="12d">
                                                                    <label for="DeletePermissions">Delete Permissions</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-title">User Permissions</div>
                                                    
                                            <div class="form-group">
                                                <label for="">Dashboard</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="Dashboard"  id="Dashboard" value="1a" class="form-check-input"> Dashboard <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4" style="padding-right: 0px !important;">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TransactionSummary"  id="TransactionSummary" value="1b" class="form-check-input"> Transaction Summary <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="SalesTrends"  id="SalesTrends" value="1c" class="form-check-input"> Sales Trends <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Transaction</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TInstoreMobile"  id="TInstoreMobile" value="2a" class="form-check-input"> Instore &amp; Mobile <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TInvoice"  id="TInvoice" value="2b" class="form-check-input"> Invoicing <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="TRecurring" id="TRecurring" value="2c" class="form-check-input"> Recurring <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Invoice/Virtual Terminal</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="VirtualTerminal"   id="VirtualTerminal" value="3a" class="form-check-input"> Virtual Terminal <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="IInvoicing"  id="IInvoicing" value="3b" class="form-check-input"> Invoicing <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="IRecurring"  id="IRecurring" value="3c" class="form-check-input"> Recurring <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <label for="">Refund</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="RInstoreMobile" id="RInstoreMobile" value="4a" class="form-check-input"> Instore & Mobile <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="RInvoice"  id="RInvoice" value="4b" class="form-check-input"> Invoice <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Inventory</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="ItemsManagement"  id="ItemsManagement" value="4c" class="form-check-input"> Items Management <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" name="Reports"   id="Reports" value="4d" class="form-check-input"> Reports <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <label for="">Settings</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="checkbox">
                                                            <label class="permission_label" for="">
                                                                <input type="checkbox" checked=""   name="Settings" id="Settings" value="6" class="form-check-input"> Settings <i class=""></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                                <div class="col-12 text-right">
                                                    <!-- <input type="submit" id="btn_login" name="submit" class="btn btn-first" value="Add Sub User" style="border-radius: 8px !important;" /> -->
                                                    <a href="javascript:void(0)" class="btn btn-first d-colors" id="subuser_popup_add_btn">Add Sub User</a>
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
                    </form>
            </div>
        </div>
    </div>
</div> -->
<!-- End of add sub user -->
<!-- All Sub User - Original -->
<div id="view_all_subuser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                    <h4 class="modal-title">All Sub Users</h4>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 add_employee_section text-right">
                    
                </div>
            </div>
            <div class="modal-body custom-form">
                <div id="modal-loader" class="text-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
                </div>
                <div id="dynamic-content_subuser">
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
    </div>
</div>

<div id="subuser_details" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Sub User CR credentials </h4>
      </div>
      <div class="modal-body custom-form">
        <div id="dynamic-content1">
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Connection ID</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control"  name="connection_id2" id="connection_id2"   placeholder="Connection ID:" 
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">API Key</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="api_key2" id="api_key2"  placeholder="API Key" 
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Auth Code</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="auth_code2" id="auth_code2"  placeholder="Auth Code" >
                  <input type="hidden" class="form-control" id="m_id2">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Min Shop Supply Value</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="min_shop_supply2" id="min_shop_supply2"  placeholder="Min Shop Supply Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Max Shop Supply Value</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="max_shop_supply2" id="max_shop_supply2"  placeholder="Max Shop Supply Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Shop Supply Percent</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="shop_supply_percent2" id="shop_supply_percent2"  placeholder="Shop Supply Percent" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Protractor Tax Percent</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="protractor_tax_percent2" id="protractor_tax_percent2"  placeholder="Protractor Tax Percent" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">B Code</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="b_code2" id="b_code2"  placeholder="B Code" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">D Code</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="d_code2" id="d_code2"  placeholder="D Code" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T Code</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t_code2" id="t_code2"  placeholder="T Code" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">URL_CR</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="url_cr2" id="url_cr2"  placeholder="URL_CR" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Username_CR</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="username_cr2" id="username_cr2"  placeholder="Username_CR" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Password_CR</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="password_cr2" id="password_cr2"  placeholder="Password_CR" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Api_Key_CR</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="api_key_cr2" id="api_key_cr2"  placeholder="Api_Key_CR" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T1</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t1_code_name2" id="t1_code_name2"  placeholder="T1 Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t1_code_value2" id="t1_code_value2"  placeholder="T1 Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T1 value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t1_max_value2" id="t1_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t1_min_value2" id="t1_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T1 value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t1_fixed2" id="t1_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T2</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t2_code_name2" id="t2_code_name2"  placeholder="T2 Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t2_code_value2" id="t2_code_value2"  placeholder="T2 Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T2 value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t2_max_value2" id="t2_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t2_min_value2" id="t2_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T2 value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t2_fixed2" id="t2_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T3</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t3_code_name2" id="t3_code_name2"  placeholder="T3 Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t3_code_value2" id="t3_code_value2"  placeholder="T3 Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T3 value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t3_max_value2" id="t3_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t3_min_value2" id="t3_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">T3 value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="t3_fixed2" id="t3_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">A</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="a_code_name2" id="a_code_name2"  placeholder="A Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="a_code_value2" id="a_code_value2"  placeholder="A Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">A value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="a_max_value2" id="a_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="a_min_value2" id="a_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">A value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="a_fixed2" id="a_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">C</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="c_code_name2" id="c_code_name2"  placeholder="C Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="c_code_value2" id="c_code_value2"  placeholder="C Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">C value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="c_max_value2" id="c_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="c_min_value2" id="c_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">C value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="c_fixed2" id="c_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">E</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="e_code_name2" id="e_code_name2"  placeholder="E Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="e_code_value2" id="e_code_value2"  placeholder="E Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">E value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="e_max_value2" id="e_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="e_min_value2" id="e_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">E value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="e_fixed2" id="e_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">F</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="f_code_name2" id="f_code_name2"  placeholder="F Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="f_code_value2" id="f_code_value2"  placeholder="F Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">F value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="f_max_value2" id="f_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="f_min_value2" id="f_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">F value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="f_fixed2" id="f_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">G</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="g_code_name2" id="g_code_name2"  placeholder="G Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="g_code_value2" id="g_code_value2"  placeholder="G Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">G value(Max/Min)</label>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="g_max_value2" id="g_max_value2"  placeholder="Max value" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="g_min_value2" id="g_min_value2"  placeholder="Min Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">G value(Fixed)</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="g_fixed2" id="g_fixed2"  placeholder="Fixed Value" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">TerminalID_CNP</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="terminal_id2" id="terminal_id2"  placeholder="Terminal ID" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">AccountID_CNP</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="account_id2" id="account_id2"  placeholder="AccountID" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">AccountToken_CNP</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="account_token2" id="account_token2"  placeholder="AccountToken" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">ApplicationID_CNP</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="application_id2" id="application_id2"  placeholder="ApplicationID" >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10" style="display: none;">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">AcceptorID_CNP</label>
              <div class="col-md-8">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="acceptor_id2" id="acceptor_id2"  placeholder="AcceptorID" >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" id="updateSubUserCred" class="btn btn-first waves-effect waves-light" data-dismiss="modal" >Update</button>
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

    $(document).ready(function() {
        fill_datatable();

        function fill_datatable(start_date = '', end_date = '', status = '') {
            // console.log(status);return false;
            var table;
            table = $('#dt_inv_pos_sale_list').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 25,
                // "dom": 'lBfrtip',
                responsive: true,
                "order": [],
                
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('dashboard/getAllMerchants'); ?>",
                    data: {
                        // 'start_date'    : start_date,
                        // 'end_date'      : end_date,
                        'start_date'    : '',
                        'end_date'      : '',
                        'status'        : status
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
                    "targets": [0], "orderable": false,
                    // targets: 2, visible: false
                }],
                // rowCallback: function(row, data, displayNum, displayIndex, dataIndex) {
                //     var contact = data[1].html();
                //     $(row).attr('title', contact)
                // }
            });
        }
        // console.log(table.context[0].ajax)

        $(document)
        .on('click', '#mysubmit', function() {
            // console.log(table, 'mysubmit');return false;
            var start_date = dateFormatter($('#startDate').val());
            var end_date = dateFormatter($('#endDate').val());
            var status = $('#status').val();

            $('#dt_inv_pos_sale_list').DataTable().destroy();
            fill_datatable(start_date, end_date, status);
        })
        .on('click', '.status_tab_anchor', function(e){
            // console.log($(this));return false;
            var $this = $(this);
            $('.status_tab_anchor').parent().removeClass('active');
            $this.parent().addClass('active');

            var status = $(this).data('val');

            $('#dt_inv_pos_sale_list').empty();
            $('#dt_inv_pos_sale_list').DataTable().destroy();
            fill_datatable('', '', status);
        })
    });

    $(document).on('change', '#fee_structure', function() {
        // console.log($(this).val());
        var fee_structure = $(this).val();
        if(fee_structure != '') {
            $('.fee_input_section').removeClass('d-none');
            $('.fee_input_one').removeClass('d-none');
            $('.fee_input_two').removeClass('d-none');
        } else {
            $('.fee_input_section').addClass('d-none');
            $('.fee_input_one').addClass('d-none');
            $('.fee_input_two').addClass('d-none');
        }
    })

    $(document).on('click', 'span.companyInfoClick', function() {
        // console.log($(this));
        $('.companyInfoModalBody').text('');
        var legalname = $(this).attr('data-legalname');
        var business_dba_name = $(this).attr('data-business_dba_name');
        var controller_name = $(this).attr('data-controller_name');

        $('.companyInfoModalBody').html('<p><strong>Legal Business Name: </strong>'+legalname+'</p><strong>Business DBA Name: </strong>'+business_dba_name+'</p><p><strong>Company Controller Name: </strong>'+controller_name+'</p>')
        $('#companyInfoModal').modal('show');
    })

    $(document).on('click', 'span.contactClick', function() {
        // console.log($(this));
        $('.contactModalBody').text('');
        var fullname = $(this).attr('data-fullname');
        var email = $(this).attr('data-email');
        var mobile = $(this).attr('data-mobile');

        $('.contactModalBody').html('<p><strong>Full Name: </strong>'+fullname+'</p><strong>Email: </strong>'+email+'</p><p><strong>Mobile: </strong>'+mobile+'</p>')
        $('#contactModal').modal('show');
    })
    // var x= '<?=base_url(); ?>';
    $(document).on('click', '#getSubUser', function(e){
        // console.log(x);
        e.preventDefault();
         
        $('#all_subuser_dt').DataTable().destroy();
        var merchant_id = $(this).data('id');
        var status = $(this).data('status');
        $('#subuser').attr('data-id',merchant_id);
        $('#current_id').val(merchant_id);

        if(status == 'active') {
            var myurl='<?= base_url('Dashboard/add_subuser/') ?>'+merchant_id;

            var add_employee_btn_html = '<a class="add-merchant" id="subuser" href="'+myurl+'"><i class="fa fa-plus"></i> Add Sub User</a>';
            // $('#subuser').attr("href",myurl); // Get current url
            $('.add_employee_section').html('');
            $('.add_employee_section').html(add_employee_btn_html);
        }

        var table;
        table = $('#all_subuser_dt').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            responsive: true,
            "order": [],
            
            "ajax": {
                "url": "<?php echo base_url('dashboard/getSingleSubMerchant'); ?>",
                data: {
                    'start_date'    : '',
                    'end_date'      : '',
                    'status'        : '',
                    'merchant_id'   : merchant_id,
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
    });
    $(document).on('click', '#subuser_popup_add_btn', function() {
        if($('#email').val() == '') {
            alert('Email field is required');
            return false;
        }

        if($('#phone').val() == '') {
            alert('Enter Mobile Number.');
            return false;
        }
        $('.d-colors').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        var formData = $('#pop_inputs').serialize();
        // console.log(formData);
            // $.ajax({
            //     url: "<?= base_url('Dashboard/add_subuser') ?>",
            //     type: 'post',
            //     dataType: 'json',
            //     data: formData,
            //     success: function(data1) {
            //         if(data1.code=='200') {
            //            $('#add_subuser').modal('hide');     
            //             alert(data1.msg);
            //             $('#view_all_subuser').modal('show');

            //         } else {
            //             $('.d-colors').html('Add Sub User');
            //             alert(data1.msg);return false;
            //             // $('small').html(data1); 
            //         }
            //         // console.log(data1); 
            //     },
            //     error :function() {
            //         //alert('error'); 
            //         console.log('Error'); 
            //     }
            // });
    })
    function updateCredentialFn(e){
        // console.log($('.cred_nav_link.active').attr('href'));return false;
        var cred_nav_link = $('.cred_nav_link.active').attr('href');
        var PinNumber = $('#PinNumber').val();
        var package_value = $('#package_value').val();

        if(cred_nav_link == '#tsysDetail') {
            var pax_pos_mid = $('#pax_pos_mid').val();
            var processor_id = $('#processor_id').val();

            if(pax_pos_mid == '') {
                alert('POS MID is required');
                return false;
            }
            if(processor_id == '') {
                alert('Processor ID is required');
                return false;
            }
            var payroc_val = '1';
        } else if(cred_nav_link == '#genDetail') {
            var payroc_val = $('#payroc_value').val();
        } else if(cred_nav_link == '#vtsDetail') {
            var payroc_val = $('#payroc_value').val();

            // if(PinNumber == '') {
            //     alert('Pin Number is required');
            //     return false;
            // }
        }  else if(cred_nav_link == '#wfDetail') {
            if ($('#wood_forest').is(':checked')) {
                if(package_value == '') {
                    alert('Please select Billing package');
                    return false;
                }
            }
            var payroc_val = $('#payroc_value').val();


        }else {
            var payroc_val = '0';
        }

        if ($('#is_vts').is(':checked')) {
            var is_vts_value = 1;
        } else {
            var is_vts_value = 0;
        }
        if ($('#wood_forest').is(':checked')) {
            var wood_forest = '1';
        } else {
            var wood_forest = '0';
        }
        console.log('clicked-cr');
        // $('#getcredt').on("click", function () {
        var auth_code =  $('#auth_code').val();
        var api_key =  $('#api_key').val();
        var connection_id =  $('#connection_id').val();
        var tax = $('#m_id').val();
        // console.log(tax);return false;
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
        var pax_pos_mid = $('#pax_pos_mid').val();
        var pax_v_no = $('#pax_v_no').val();
        var pax_bin = $('#pax_bin').val();
        var pax_agent = $('#pax_agent').val();
        var pax_chain = $('#pax_chain').val();
        var pax_store_no = $('#pax_store_no').val();
        var pax_terminal_no = $('#pax_terminal_no').val();
        var pax_currency_code = $('#pax_currency_code').val();
        var pax_country_code = $('#pax_country_code').val();
        var pax_location_no = $('#pax_location_no').val();
        var pax_timezone = $('#pax_timezone').val();
        var pax_mcc_sic = $('#pax_mcc_sic').val();
        var processor_id = $('#processor_id').val();
        var security_key_value = $('#security_key_value').val();

        
        $.ajax({
            type: 'POST',
            url: "<?php  echo base_url('Admin_Backend/search_record_update'); ?>",
            data: {
                id: tax, auth_code: auth_code,api_key: api_key,connection_id: connection_id,min_shop_supply: min_shop_supply, max_shop_supply: max_shop_supply,
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
                account_id : account_id,account_token : account_token,application_id : application_id,acceptor_id : acceptor_id,terminal_id : terminal_id, pax_pos_mid : pax_pos_mid, pax_v_no : pax_v_no, pax_bin : pax_bin, pax_agent : pax_agent, pax_chain : pax_chain, pax_store_no : pax_store_no, pax_terminal_no : pax_terminal_no, pax_currency_code : pax_currency_code, pax_country_code : pax_country_code, pax_location_no : pax_location_no, pax_timezone : pax_timezone, pax_mcc_sic : pax_mcc_sic, processor_id : processor_id, PinNumber : PinNumber, payroc_val : payroc_val, is_vts : is_vts_value, package_value : package_value, wood_forest : wood_forest, security_key_value : security_key_value
            },
            type:'post',
            success: function (dataJson) {
                if(dataJson == '200'){
                    $('#payment_method_name').empty();
                    var payment_method_name = (payroc_val == 1) ? 'TSYS' : 'WorldPay/FIS';
                    $('#payment_method_name').html('<a class="badge badge-success" style="font-size: 12px; color:white;">'+payment_method_name+'</a>')

                    $('#updateCredentialFnMsg').html('<span class="text-success">Updated successfully!</span>');
                } else {
                    $('#updateCredentialFnMsg').html('<span class="text-danger">Something went wrong!</span>');
                }
                setTimeout(function(){$('#updateCredentialFnMsg').html('');},3000)
            }
        });
    };

    $(document).on('click', '.del_merchant', function() {
        var thisBtn = $(this);
        var id = thisBtn.attr('data-id');
        var name = thisBtn.attr('data-name');
        var redirect_url = "<?php echo base_url('dashboard/all_merchant') ?>";
        // console.log(id);

        var tableRowId = id;
        // console.log($('#row_'+tableRowId));return false;

        swal({
            title: '<span class="h4">Delete "'+name+'"?</span>',
            // text: '<p>If you are sure, enter your password below:</p><p><input type="text" class="form-control merchant_delete_pass" value="" placeholder="Password" autocomplete="off"></p>',
            text: '<p>Before continuing, please re-enter your password to verify</p><p><input type="text" class="form-control merchant_delete_pass" value="" placeholder="Password" autocomplete="off"></p>',
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-first ",
            confirmButtonText: "Delete",
            cancelButtonClass: "btn danger-btn ",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            html: true,
            closeOnCancel: true
        },
        function(isConfirm) {
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
                        success: function(data) {
                            // console.log(data);return false;
                            //location.reload();
                            if(data.status){
                                // $('#row_'+tableRowId).remove();
                                // console.log('#row_'+tableRowId);
                                // $('#row_'+tableRowId).parent().parent().next().remove();
                                // $('#row_'+tableRowId).parent().parent().remove();
                                // thisBtn.parent().parent().parent().parent().remove();

                                // swal(
                                //     'Deleted',
                                //     'Merchant Deleted Successfully',
                                //     'success'
                                // )
                                window.location.replace(redirect_url);

                            } else {
                                $('.merchant_delete_pass').val('');
                                $('.merchant_delete_pass').after('<span id="incorrectPassMsg" class="text-danger">'+data.message+'</span>');
                                setTimeout(function(){$('#incorrectPassMsg').remove();},3000)
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // alert('Error deleting data'); 
                            swal(
                                'Something went wrong!',
                                'Please try again later.',
                                'error'
                            )
                        }
                    });
                } else {
                    $('.merchant_delete_pass').focus();
                }
            } else {
            }
        })
    })

    // function merchant_delete(id) {
    //     var tableRowId = id;
    //     // console.log($('#row_'+tableRowId));return false;

    //     swal({
    //         title: '<span class="h4">Are you sure, want to delete this Merchant?</span>',
    //         text: '<p>If you are sure, enter your password below:</p><p><input type="text" class="form-control merchant_delete_pass" value=""  placeholder="Password" autocomplete="off"> </p>',
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonClass: "btn btn-first ",
    //         confirmButtonText: "Delete",
    //         cancelButtonClass: "btn danger-btn ",
    //         cancelButtonText: "Cancel",
    //         closeOnConfirm: false,
    //         html: true,
    //         closeOnCancel: true
    //     },
    //     function(isConfirm) {
    //         // console.log(isConfirm);
    //         // console.log($('.merchant_delete_pass').val());
    //         if(isConfirm){
    //             var pass=$('.merchant_delete_pass').val();
    //             var admin_id="<?php echo $this->session->userdata('id'); ?>";
    //             if(pass){
    //                 $.ajax({     //  //  /"+id+'/'+'/'+pass 
    //                     url : "<?php echo base_url('dashboard/merchant_delete')?>",
    //                     type: "POST",
    //                     data:{'merchant_id':id,'pass':pass,'admin_id':admin_id},
    //                     dataType: "JSON",
    //                     success: function(data) {
    //                         // console.log(data);
    //                         //location.reload();
    //                         if(data.status){
    //                             // $('#row_'+tableRowId).remove();
    //                             // console.log('#row_'+tableRowId);
    //                             $('#row_'+tableRowId).parent().parent().next().remove();
    //                             $('#row_'+tableRowId).parent().parent().remove();
    //                             swal(
    //                                 'Deleted',
    //                                 'Merchant Deleted Successfully',
    //                                 'success'
    //                             )
    //                         } else {
    //                             $('.merchant_delete_pass').val('');
    //                             $('.merchant_delete_pass').after('<span id="incorrectPassMsg" class="text-danger">'+data.message+'</span>');
    //                             setTimeout(function(){$('#incorrectPassMsg').remove();},3000)
    //                         }
    //                     },
    //                     error: function (jqXHR, textStatus, errorThrown) {
    //                         // alert('Error deleting data'); 
    //                         swal(
    //                             'Something went wrong!',
    //                             'Please try again later.',
    //                             'error'
    //                         )
    //                     }
    //                 });
    //             } else {
    //                 $('.merchant_delete_pass').focus();
    //             }
    //         } else {
    //         }
    //     })
    // }

    $(document)
    .on('click', '#getcredt', function(e){
        $('#payment_method_name').empty();
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
        $('#pax_pos_mid').val('');
        $('#pax_v_no').val('');
        $('#pax_bin').val('');
        $('#pax_agent').val('');
        $('#pax_chain').val('');
        $('#pax_store_no').val('');
        $('#pax_terminal_no').val('');
        $('#pax_currency_code').val('');
        $('#pax_country_code').val('');
        $('#pax_location_no').val('');
        $('#pax_timezone').val('');
        $('#pax_mcc_sic').val('');
        $('#processor_id').val('');
        $('#PinNumber').val('');
        $('.vts_switch_section').html('');
        $('.wf_switch_section').html('');
        $('#package_value').val('');
        $('#security_key_value').val('');
        
        
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Admin_Backend/search_record_credntl'); ?>",
            data: {id: tax},
            type:'post',
            success: function (dataJson) {
                data = JSON.parse(dataJson)
                // console.log(data)
                $(data).each(function (index, element) {
                    var payment_method_name = (element.payroc == 1) ? 'TSYS' : 'WorldPay/FIS';
                    $('#payment_method_name').html('<a class="badge badge-success" style="font-size: 12px; color:white;">'+payment_method_name+'</a>')
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
                    $('#pax_pos_mid').val(element.pax_pos_mid);
                    $('#pax_v_no').val(element.pax_v_no);
                    $('#pax_bin').val(element.pax_bin);
                    $('#pax_agent').val(element.pax_agent);
                    $('#pax_chain').val(element.pax_chain);
                    $('#pax_store_no').val(element.pax_store_no);
                    $('#pax_terminal_no').val(element.pax_terminal_no);
                    $('#pax_currency_code').val(element.pax_currency_code);
                    $('#pax_country_code').val(element.pax_country_code);
                    $('#pax_location_no').val(element.pax_location_no);
                    $('#pax_timezone').val(element.pax_timezone);
                    $('#pax_mcc_sic').val(element.pax_mcc_sic);
                    $('#processor_id').val(element.processor_id);
                    $('#PinNumber').val(element.PinNumber);
                    $('#payroc_value').val(element.payroc);
                    $('#package_value').val(element.package_value);
                    $('#security_key_value').val(element.security_key_value);
                    console.log(element.is_vts);
                    var is_vts_checked = (element.is_vts == 1) ? 'checked' : '';
                    var is_wf_checked = (element.wood_forest == 1) ? 'checked' : '';
                    $('.vts_switch_section').html('<label class="switch switch_type1" role="switch"><input type="checkbox" name="is_vts" '+is_vts_checked+' id="is_vts" value="" class="switch__toggle"><span class="switch__label"></span></label>')
                    $('.wf_switch_section').html('<label class="switch switch_type1" role="switch"><input type="checkbox" name="wood_forest" '+is_wf_checked+' id="wood_forest" value="" class="switch__toggle"><span class="switch__label"></span></label>')
                });
            }
        });
    });

    $(document).on('click', '.cred_nav_link', function() {
        var cred_nav_link = $(this).attr('href');
        // console.log(cred_nav_link);return false;

        // var cred_nav_link = $this.hasClass('active').data('val');
        if(cred_nav_link == '#tsysDetail') {
            // console.log('#tsysDetail');
            $('#payroc_value').val('1');
        }
        if(cred_nav_link == '#cnpDetail') {
            // console.log('#cnpDetail');
            $('#payroc_value').val('0');
        }
    })
    $(document).on('click', '#subuser', function(e){
        
        $('#view_all_subuser').modal('hide');
        var merchant_id=$(this).data('id');
        // $(this).each(function(){ 
        
        // });
        // $.ajax({
        //         url: "<?= base_url('Dashboard/add_subuser') ?>",
        //         type: 'post',
        //         dataType: 'json',
        //         data: {merchant_id : merchant_id},
        //         success: function(data1) {
        //             if(data1.code=='200') {
        //                $('#add_subuser').modal('hide');     
        //                 alert(data1.msg);
        //                 $('#view_all_subuser').modal('show');

        //             } else {
        //                 $('.d-colors').html('Add Sub User');
        //                 alert(data1.msg);return false;
        //                 // $('small').html(data1); 
        //             }
        //             // console.log(data1); 
        //         },
        //         error :function() {
        //             //alert('error'); 
        //             console.log('Error'); 
        //         }
        //     });
        
    })
    
    $(document).on('click', '#getSubUserCreds', function(e){
        e.preventDefault();
        $('#view_all_subuser').modal('hide');

        var tax = $(this).data('id');   // it will get id of clicked row
        $('#auth_code2').val('');
        $('#api_key2').val('');
        $('#connection_id2').val('');
        $('#min_shop_supply2').val('');
        $('#max_shop_supply2').val('');
        $('#shop_supply_percent2').val('');
        $('#protractor_tax_percent2').val('');
        $('#b_code2').val('');
        $('#d_code2').val('');
        $('#t_code2').val('');
        $('#t1_code_name2').val('');
        $('#t1_code_value2').val('');
        $('#t2_code_name2').val('');
        $('#t2_code_value2').val('');
        $('#a_code_name2').val('');
        $('#a_code_value2').val('');
        $('#a_min_value2').val('');
        $('#a_max_value2').val('');
        $('#a_fixed2').val('');
        $('#c_code_name2').val('');
        $('#c_code_value2').val('');
        $('#c_min_value2').val('');
        $('#c_max_value2').val('');
        $('#c_fixed2').val('');
        $('#e_code_name2').val('');
        $('#e_code_value2').val('');
        $('#e_min_value2').val('');
        $('#e_max_value2').val('');
        $('#e_fixed2').val('');
        $('#f_code_name2').val('');
        $('#f_code_value2').val('');
        $('#f_min_value2').val('');
        $('#f_max_value2').val('');
        $('#f_fixed2').val('');
        $('#g_code_name2').val('');
        $('#g_code_value2').val('');
        $('#g_min_value2').val('');
        $('#g_max_value2').val('');
        $('#g_fixed2').val('');
        $('#t1_code_name2').val('');
        $('#t1_code_value2').val('');
        $('#t1_min_value2').val('');
        $('#t1_max_value2').val('');
        $('#t1_fixed2').val('');
        $('#t2_code_name2').val('');
        $('#t2_code_value2').val('');
        $('#t2_min_value2').val('');
        $('#t2_max_value2').val('');
        $('#t2_fixed2').val('');
        $('#t3_code_name2').val('');
        $('#t3_code_value2').val('');
        $('#t3_min_value2').val('');
        $('#t3_max_value2').val('');
        $('#t3_fixed2').val('');
        $('#url_cr2').val('');
        $('#username_cr2').val('');
        $('#password_cr2').val('');
        $('#api_key_cr2').val('');
        $('#account_id2').val('');
        $('#account_token2').val('');
        $('#application_id2').val('');
        $('#acceptor_id2').val('');
        $('#terminal_id2').val('');
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Admin_Backend/search_record_credntl'); ?>",
            data: {id: tax},
            type:'post',
            success: function (dataJson) {
                data = JSON.parse(dataJson);
                // console.log(data)
                $(data).each(function (index, element) {
                    $('#auth_code2').val(element.auth_code);
                    $('#api_key2').val(element.api_key);
                    $('#connection_id2').val(element.connection_id);
                    $('#m_id2').val(element.id);
                    $('#min_shop_supply2').val(element.min_shop_supply);
                    $('#max_shop_supply2').val(element.max_shop_supply);
                    $('#shop_supply_percent2').val(element.shop_supply_percent);
                    $('#protractor_tax_percent2').val(element.protractor_tax_percent);
                    $('#b_code2').val(element.b_code);
                    $('#d_code2').val(element.d_code);
                    $('#t_code2').val(element.t_code);
                    $('#t1_code_name2').val(element.t1_code_name);
                    $('#t1_code_value2').val(element.t1_code_value);
                    $('#t2_code_name2').val(element.t2_code_name);
                    $('#t2_code_value2').val(element.t2_code_value);
                    $('#a_code_name2').val(element.a_code_name);
                    $('#a_code_value2').val(element.a_code_value);
                    $('#a_min_value2').val(element.a_min_value);
                    $('#a_max_value2').val(element.a_max_value);
                    $('#a_fixed2').val(element.a_fixed);
                    $('#c_code_name2').val(element.c_code_name);
                    $('#c_code_value2').val(element.c_code_value);
                    $('#c_min_value2').val(element.c_min_value);
                    $('#c_max_value2').val(element.c_max_value);
                    $('#c_fixed2').val(element.c_fixed);
                    $('#e_code_name2').val(element.e_code_name);
                    $('#e_code_value2').val(element.e_code_value);
                    $('#e_min_value2').val(element.e_min_value);
                    $('#e_max_value2').val(element.e_max_value);
                    $('#e_fixed2').val(element.e_fixed);
                    $('#f_code_name2').val(element.f_code_name);
                    $('#f_code_value2').val(element.f_code_value);
                    $('#f_min_value2').val(element.f_min_value);
                    $('#f_max_value2').val(element.f_max_value);
                    $('#f_fixed2').val(element.f_fixed);
                    $('#g_code_name2').val(element.g_code_name);
                    $('#g_code_value2').val(element.g_code_value);
                    $('#g_min_value2').val(element.g_min_value);
                    $('#g_max_value2').val(element.g_max_value);
                    $('#g_fixed2').val(element.g_fixed);
                    $('#t1_code_name2').val(element.t1_code_name);
                    $('#t1_code_value2').val(element.t1_code_value);
                    $('#t1_min_value2').val(element.t1_min_value);
                    $('#t1_max_value2').val(element.t1_max_value);
                    $('#t1_fixed2').val(element.t1_fixed);
                    $('#t2_code_name2').val(element.t2_code_name);
                    $('#t2_code_value2').val(element.t2_code_value);
                    $('#t2_min_value2').val(element.t2_min_value);
                    $('#t2_max_value2').val(element.t2_max_value);
                    $('#t2_fixed2').val(element.t2_fixed);
                    $('#t3_code_name2').val(element.t3_code_name);
                    $('#t3_code_value2').val(element.t3_code_value);
                    $('#t3_min_value2').val(element.t3_min_value);
                    $('#t3_max_value2').val(element.t3_max_value);
                    $('#t3_fixed2').val(element.t3_fixed);
                    $('#url_cr2').val(element.url_cr);
                    $('#username_cr2').val(element.username_cr);
                    $('#password_cr2').val(element.password_cr);
                    $('#api_key_cr2').val(element.api_key_cr);
                    $('#account_id2').val(element.account_id_cnp);
                    $('#account_token2').val(element.account_token_cnp);
                    $('#application_id2').val(element.application_id_cnp);
                    $('#acceptor_id2').val(element.acceptor_id_cnp);
                    $('#terminal_id2').val(element.terminal_id);

                    $('#subuser_details').modal('show');
                });
            }
        });
    });

    $(document).on('click', '#updateSubUserCred', function(e){
        e.preventDefault();
        // $('#getcredt').on("click", function () {
        var auth_code =  $('#auth_code2').val();
        var api_key =  $('#api_key2').val();
        var connection_id =  $('#connection_id2').val();
        var tax =  $('#m_id2').val();
        // console.log(tax);return false;
        var min_shop_supply =  $('#min_shop_supply2').val();
        var max_shop_supply =  $('#max_shop_supply2').val();
        var shop_supply_percent =  $('#shop_supply_percent2').val();
        var protractor_tax_percent =  $('#protractor_tax_percent2').val();
        var b_code =  $('#b_code2').val();
        var d_code =  $('#d_code2').val();
        var t_code =  $('#t_code2').val();
        var t1_code_name = $('#t1_code_name2').val();
        var t1_code_value = $('#t1_code_value2').val();
        var t2_code_name = $('#t2_code_name2').val();
        var t2_code_value =  $('#t2_code_value2').val();
        var a_code_name =  $('#a_code_name2').val();
        var a_code_value =  $('#a_code_value2').val();
        var a_min_value =  $('#a_min_value2').val();
        var a_max_value =  $('#a_max_value2').val();
        var a_fixed =  $('#a_fixed2').val();
        var c_code_name =  $('#c_code_name2').val();
        var c_code_value =  $('#c_code_value2').val();
        var c_min_value =  $('#c_min_value2').val();
        var c_max_value =  $('#c_max_value2').val();
        var c_fixed =  $('#c_fixed2').val();
        var e_code_name =  $('#e_code_name2').val();
        var e_code_value =  $('#e_code_value2').val();
        var e_min_value =  $('#e_min_value2').val();
        var e_max_value =  $('#e_max_value2').val();
        var e_fixed =  $('#e_fixed2').val();
        var f_code_name =  $('#f_code_name2').val();
        var f_code_value =  $('#f_code_value2').val();
        var f_min_value =  $('#f_min_value2').val();
        var f_max_value =  $('#f_max_value2').val();
        var f_fixed =  $('#f_fixed2').val();
        var g_code_name =  $('#g_code_name2').val();
        var g_code_value =  $('#g_code_value2').val();
        var g_min_value =  $('#g_min_value2').val();
        var g_max_value =  $('#g_max_value2').val();
        var g_fixed =  $('#g_fixed2').val();
        var t1_code_name =  $('#t1_code_name2').val();
        var t1_code_value =  $('#t1_code_value2').val();
        var t1_min_value =  $('#t1_min_value2').val();
        var t1_max_value =  $('#t1_max_value2').val();
        var t1_fixed =  $('#t1_fixed2').val();
        var t2_code_name =  $('#t2_code_name2').val();
        var t2_code_value =  $('#t2_code_value2').val();
        var t2_min_value =  $('#t2_min_value2').val();
        var t2_max_value =  $('#t2_max_value2').val();
        var t2_fixed =  $('#t2_fixed2').val();
        var t3_code_name =  $('#t3_code_name2').val();
        var t3_code_value =  $('#t3_code_value2').val();
        var t3_min_value =  $('#t3_min_value2').val();
        var t3_max_value =  $('#t3_max_value2').val();
        var t3_fixed =  $('#t3_fixed2').val();
        var url_cr =  $('#url_cr2').val();
        var username_cr =  $('#username_cr2').val();
        var password_cr =  $('#password_cr2').val();
        var api_key_cr =  $('#api_key_cr2').val();
        var account_id =  $('#account_id2').val();
        var account_token =  $('#account_token2').val();
        var application_id =  $('#application_id2').val();
        var acceptor_id =  $('#acceptor_id2').val();
        var terminal_id =  $('#terminal_id2').val();
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
        // console.log(updateData);return false;

        $.ajax({
            type: 'POST',
            url: "<?php  echo base_url('Admin_Backend/search_record_update_new'); ?>",
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
    
    $(document).ready(function() {
        $('#datatable').DataTable();
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
        })
        .fail(function(){
            console.log(data); 
        });

        if($(this).is(':checked')){
            $(this).closest('.start_stop_tax').addClass('active');
        } else {
            $(this).closest('.start_stop_tax').removeClass('active');
        }
    })
    .on('change','.start_stop_payroc input[type="checkbox"]', function (e) {
        // stop - start payroc
        e.preventDefault();
        var m=$(this).val(); 
        var payroc=$(this).is(':checked');
        //alert(payroc); 
        $.ajax({
            url: "<?php  echo base_url('dashboard/updatePayrocStatus'); ?>",
            type: 'POST',
            data: {id:m,payroc:payroc}
            //dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            if(data=='200'){
            }
        })
        .fail(function(){
            console.log(data); 
        });

        if($(this).is(':checked')){
            $(this).closest('.start_stop_payroc').addClass('active');
        } else {
            $(this).closest('.start_stop_payroc').removeClass('active');
        }
    })

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
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isDecimal(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }
    }

    // $('#cnp_percent').keypress(function(event) {
    $('#cnp_percent').on("keyup keypress", function() {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();

        } else {
            // console.log(2);
            // console.log($('#cnp_percent').val());
            var cnp_percent = $('#cnp_percent').val();
            var cp_percent = $('#cp_percent').val();
            if(cnp_percent > 100) {
                $('#cnp_percent').val(0);
                alert('CNP Percent should not be greater than 100');
                return false;
            
            } else {
                cp_percent = 100 - cnp_percent;
                // console.log(cp_percent);
                $('#cp_percent').val(cp_percent);
            }
        }
    });

    $('#cp_percent').on("keyup keypress", function() {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();

        } else {
            var cp_percent = $('#cp_percent').val();
            var cnp_percent = $('#cnp_percent').val();
            if(cp_percent > 100) {
                $('#cp_percent').val(0);
                alert('CP Percent should not be greater than 100');
                return false;
            
            } else {
                cnp_percent = 100 - cp_percent;
                // console.log(cp_percent);
                $('#cnp_percent').val(cnp_percent);
            }
        }
    });

    function isNumberKey1dc(el,evt) {
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
        // console.log('clicked')
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
        if(inpVal.length) {
            $(this).data('val',$(this).val().trim());
            var ttlL=$(this).val().trim().length;
            // console.log(ttlL)
            for (var i = 0; i < ttlL; i++) {
                if(i == 3 || i == 6) {
                    encPlaceh+='-';
                } else if(i<= 5) {
                    encPlaceh+='x';
                } else{
                    i = ttlL;
                    encPlaceh+=inpVal.substr(5, ttlL-1);
                }
            }
            // console.log(encPlaceh)
            $(this).val(encPlaceh);
        } else {
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
    .on('change', '#change_status', function(e){
        // console.log($(this));return false;
        var uid = $(this).data('id');
        var status = $(this).val();

        // console.log(uid, status);
        swal({
            title: '<span class="h4">Are you sure, want to change status for this Merchant?</span>',
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-first ",
            confirmButtonText: "Okay",
            cancelButtonClass: "btn danger-btn ",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            html: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if(isConfirm){
                if(uid){
                    $.ajax({
                        url : "<?php echo base_url('dashboard/update_merchant_status')?>",
                        type: "POST",
                        dataType: "JSON",
                        data:{'uid':uid,'status':status},
                        success: function(data) {
                            if(data.status == 200){
                                swal(
                                    'Updated',
                                    data.message,
                                    'success'
                                )
                            } else {
                                swal(
                                    'Something went wrong!',
                                    data.message,
                                    'error'
                                )
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // alert('Error deleting data'); 
                            swal(
                                'Something went wrong!',
                                data.message,
                                'error'
                            )
                        }
                    });
                } else {
                    swal(
                        'Something went wrong!',
                        'No Merchant Selected. Please try again later.',
                        'error'
                    )
                }
            }
        })
    })

    function merchant_block(id) {
        if(confirm('Are you sure Block this Merchant?')) {
            $.ajax({
                url : "<?php echo base_url('dashboard/block_merchant')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                   location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error  data');
                }
            });
        }
    }

    function confirm_email(id) {
        if(confirm('Are you sure confirm_email this Merchant?')) {
            $.ajax({
                url : "<?php echo base_url('dashboard/confirm_email')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                   location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error  data');
                }
            });
        }
    }

    function active_merchant(id) {
        if(confirm('Are you sure Active this Merchant?')) {
            $.ajax({
                url : "<?php echo base_url('dashboard/active_merchant')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                   location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error  data');
                }
            });
        }
    }

    function CheckAll() {  
        var post_count = document.getElementById('id').value;
        var k;
        var j =0;
        for(k=1; k<=post_count;k++) {
            if(document.getElementById('checkall').checked==true) {
                document.getElementById('ids'+k).checked=true;
                j++;
            } else {
                document.getElementById('ids'+k).checked=false;
            }
        }
    }

    function viewDetails(merchant_id) {
        // console.log(merchant_id);return false;
        if(merchant_id != '') {
            $.ajax({
                url : "<?php echo base_url('dashboard/get_single_merchant')?>/"+merchant_id,
                type: "POST",
                dataType: "JSON",
                success: function(merchant) {
                    // console.log(merchant.applicationstatus);return false;
                    // console.log(merchant);return false;
                    //alert(key); 
                    // $('#approved_merhcanturl').hide();
                    if(merchant.last_mail_sent_status == "0") {
                        $('.mail_status_row').html('');
                        $('.mail_status_row').html('<div class="col-12 text-right" style="padding-right: 0px !important;"><p><span><strong>Last mail sent by: </strong></span><span id="mailed_by">'+merchant.last_mail_sent_by+'</span></p><p><span><strong>At: </strong></span><span id="mailed_at">'+merchant.last_mail_sent_at+'</span></p></div>');
                    
                    } else {
                        $('.mail_status_row').html('');
                    }

                    if(merchant.applicationstatus != "") {
                        $('.applicationstatusDiv').show();
                        // $('#applicationstatus').html(merchant[key]["applicationstatus"]);
                        $('#applicationstatus').html(merchant.applicationstatus);
                        // $('#send_to_merhcant').hide();
                        // $('#approved_merhcanturl').show();
                    } else {
                        $('.applicationstatusDiv').hide();
                        // $('#send_to_merhcant').show();
                        // $('#approved_merhcanturl').hide();
                    }

                    if((merchant.applicationstatus != "") && (merchant.status != 'active')) {
                        // $('.applicationstatusDiv').show();
                        // $('#applicationstatus').html(merchant[key]["applicationstatus"]);
                        // $('#applicationstatus').html(merchant.applicationstatus);
                        // $('#send_to_merhcant').hide();
                        $('#approved_merhcanturl').show();
                    } else {
                        // $('.applicationstatusDiv').hide();
                        // $('#send_to_merhcant').show();
                        $('#approved_merhcanturl').hide();
                    }
                    // alert(application_status); 
                    // Primary Info
                    $("#pc_name").val(merchant.pc_name); //pc_name
                    $("#pc_title").val(merchant.pc_title);  //  pc_title
                    $("#pc_email").val(merchant.pc_email);   //  pc_email
                    $("#pc_phone").val(merchant.pc_phone).mask("(999) 999-9999");   //  pc_phone 
                    $("#pc_address").val(merchant.pc_address);  // pc_address
                    
                    // Business Info
                    $("#business_name").val(merchant.business_name);
                    $("#business_dba_name").val(merchant.business_dba_name);
                    $("#taxid").val(merchant.taxid).mask("99-9999999");
                    $("#busi_country").val(merchant.country);
                    $("#address1").val(merchant.address1);
                    // $("#address2").val(merchant.address2);
                    $("#busi_city").val(merchant.city);
                    $("#busi_state").val(merchant.state);
                    $("#busi_zip").val(merchant.zip);
                    $("#ownershiptype").val(merchant.ownershiptype);
                    $("#business_type").val(merchant.business_type);
                    var mm=merchant.month_business;
                    var dd=merchant.day_business;
                    var ymd=merchant.year_business? (merchant.year_business + '-'+ mm + '-'+ dd) : '' ;
                    $("#establishmentdate").val(ymd).datepicker('setDate', ymd);
                    $("#business_number").val(merchant.business_number).mask("(999) 999-9999");
                    $("#customer_service_phone").val(merchant.customer_service_phone).mask("(999) 999-9999");
                    $("#business_email").val(merchant.business_email);
                    $("#customer_service_email").val(merchant.customer_service_email);
                    $("#website").val(merchant.website);
                    $("#annual_processing_volume").val(merchant.annual_processing_volume);
                    $("#year_business").val(merchant.day_business+' '+merchant.month_business+' ,20'+merchant.year_business);
                    $("#annual_processing_volume").val(merchant.annual_processing_volume);
                    $("#ien_no").val(merchant.ien_no);
                    $("#city").val(merchant.city);
                    $("#country").val(merchant.country);
                    
                    // $("#monthly_fee").val(merchant.monthly_fee);
                    $("#vm_cardrate").val(merchant.vm_cardrate);
                    $("#dis_trans_fee").val(merchant.dis_trans_fee); // 
                    $("#amexrate").val(merchant.amexrate);
                    $("#monthly_gateway_fee").val(merchant.monthly_gateway_fee);
                    $("#chargeback").val(merchant.chargeback);
                    // $("#annual_cc_sales_vol").val(merchant.annual_cc_sales_vol);
                    $("#checkbox").val(merchant.checkbox);
                    $("#question").val(merchant.question);
                    $("#billing_descriptor").val(merchant.billing_descriptor);
                    $("#o_f_name").val(merchant.name);
                    $("#o_m_name").val(merchant.m_name);
                    $("#o_l_name").val(merchant.l_name);
                    $("#o_perc").val(merchant.o_percentage);
                    $("#o_dob").val(merchant.dob).datepicker('setDate', merchant.dob);

                    var o_question = (merchant.o_question == 'True') ? '1' : '0';
                    var is_primary_owner = (merchant.is_primary_owner == 'True') ? '1' : '0';
                    // console.log(o_question);return false;
                    $("#o_question").val(o_question);
                    $("#is_primary_owner").val(is_primary_owner);

                    if(o_question == '1') {
                        $('#o_question').prop('checked', true);
                    }
                    if(is_primary_owner == '1') {
                        $('#is_primary_owner').prop('checked', true);
                    }

                    $("#cnp_percent").val(merchant.cnp_percent);
                    $("#cp_percent").val(merchant.cp_percent);
                    $("#average_ticket").val(merchant.average_ticket);
                    $("#high_ticket").val(merchant.high_ticket);

                    if(merchant.o_ss_number) {
                        var newval=merchant.o_ss_number;
                        newval=newval.replace(/[\(\)-\s]/g,'');
                    }                    

                    $("#o_ss_number").data('val',newval);
                    $("#o_ss_number").val(newval).trigger('blur');
                    $("#o_phone").val(merchant.o_phone).mask("(999) 999-9999");
                    $("#o_email").val(merchant.o_email);
                    $("#o_country").val(merchant.o_country);
                    $("#o_address1").val(merchant.o_address1);
                    // $("#o_address2").val(merchant.o_address2);
                    $("#o_city").val(merchant.o_city);
                    $("#o_state").val(merchant.o_state);
                    $("#o_zip").val(merchant.o_zip);
                    $("#bank_dda").val(merchant.bank_dda);
                    $("#bank_ach").val(merchant.bank_ach);
                    $("#bank_routing").val(merchant.bank_routing);
                    $("#bank_account").val(merchant.bank_account);

                    $("#billing_structure").val(merchant.billing_structure);
                    $("#fee_structure").val(merchant.fee_structure);
                    $("#percentage_rate").val(merchant.percentage_rate);
                    $("#transaction_rate").val(merchant.transaction_rate);

                    if(merchant.percentage_rate) {
                        $('.fee_input_one').removeClass('d-none');
                    }
                    if(merchant.transaction_rate) {
                        $('.fee_input_two').removeClass('d-none');
                    }
                    
                    $("#approved_merhcanturl").attr("href","<?php echo base_url('dashboard/Approved_merchant/') ?>"+merchant.id);
                    $('#key').val(merchant.id);  
                    // setTimeout(function(){
                    //   $("#activation_dynamic-content1 .us-phone-no").mask("(999) 999-9999");
                    //   $("#activation_dynamic-content1 .us-tin-no").mask("99-9999999");
                    // },300)
                }
            });
        }
    }

    function checkApplicationStatusFn() {
        $('#checkapplicationstatus').addClass('active');
        // console.log('checkApplicationStatus');
        var merchant_id= $('#key').val();
        $.ajax({
            url : "<?php echo base_url('dashboard/getmerchantDetails'); ?>",
            type: "POST",
            dataType: "JSON",
            data: {'merchant_id':merchant_id},
            success: function(data) {
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
                // $('#send_to_merhcant').html('Send Mail to Merchant');
                // $('.error-section').html(""); 
                // $('.error-message').html('<span class="text-danger">Somthing went Wrong!</span>');
                // }
                // $('#checkapplicationstatus').removeClass('active');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#checkapplicationstatus').removeClass('active');
                alert('Somthing went Wrong!');
            }
        });
    }

    function admin_getWholeData($wrapper){
        var wholeData= {};
        $('#activation_dynamic-content1 .required, #activation_dynamic-content1 .non_required, #activation_dynamic-content1 .hidden_inputs').each(function(){
            var txtVal=$(this).val();
            if($(this).hasClass('us-phone-no')){
                txtVal=txtVal.replace(/[\(\)-\s]/g,'');
            
            } else if($(this).hasClass('us-ssn-no-enc')){
                txtVal=$(this).data('val'); 
            }
            wholeData[$(this).attr('id')]=txtVal;
        })
        // console.log(wholeData);return false;

        return wholeData;
    }

    $(document).on('change', '#o_question, #is_primary_owner', function() {
        if($(this).is(':checked')) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    })

    function Api_merhcant() {
        if(validateMerchantApi($('#activation_dynamic-content1'))) {
            if(confirm('Are you sure send to Merchant?')) {
                $('#send_to_merhcant').html('Wait...');
                // console.log(admin_getWholeData);return false;
                // admin_getWholeData();

                $.ajax({
                    url : "<?php echo base_url('dashboard/merchant_api'); ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: admin_getWholeData(),
                    success: function(data) {
                        // console.log(data);return false; 
                        if(data.Status=='30') {
                            $('#send_to_merhcant').html('Sent');
                            $('#send_to_merhcant').show(); 
                            // $('#approved_merhcanturl').show(); 
                            $('.error-section').html(""); 
                            // $('.error-message').html('<span class="text-success">Send Successfully..</span>');
                            $('.error-message').html('<span class="text-success">Email sent successfully to this merchant');
                            // $('.applicationstatusDiv').show();
                            // $('#applicationstatus').html('<span class="text-success">Submission successful.</span>');
                            //alert('success');
                        } else if(data.Status=='400' ||  data.Status=='40') {
                            $('#send_to_merhcant').html('Send Mail to Merchant');
                            $('.error-section').html(""); 
                            $('.error-message').html('<span class="text-danger">All Fields Are Required..</span>');

                        } else if(data.Status=='mail_not_send') {
                            $('.error-message').html('<span class="text-success">E-mail not sent. Something went wrong.</span>');

                        } else {
                            $('#send_to_merhcant').html('Send Mail to Merchant');
                            $('.error-section').html(data.StatusMessage); 
                            if(data.Errors.length > 0) {
                                var i=0;
                                for(i=0;i<data.Errors.length; i++) {
                                    //console.log(data.Errors[i].Message);
                                    $('.error-message').append('<span class="text-danger">'+data.Errors[i].Message+'</span><br/>');
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error  data');
                        $('#send_to_merhcant').html('Send Mail to Merchant');
                        $('.error-section').html(""); 
                        $('.error-message').html('<span class="text-danger">Error  data</span>');
                    }
                });
            }  
        } else {
            //do nothing
        }
    }

    function saveMerchantDetail() {
        if(validateMerchantApi($('#activation_dynamic-content1'))) {
            if(confirm('Do you want to update info of this Merchant?')) {
                $('#saveMerchant').html('Saving');

                $.ajax({
                    url : "<?php echo base_url('dashboard/update_merchant_details'); ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: admin_getWholeData(),
                    success: function(data) {
                        // console.log(data);return false; 
                        if(data.Status=='200') {
                            $('#saveMerchant').html('Save');
                            $('.error-section').html(""); 
                            $('.error-message').html('<span class="text-danger">Saved Successfully</span>');

                        } else if(data.Status=='400' ||  data.Status=='40') {
                            $('#saveMerchant').html('Save');
                            $('.error-section').html(""); 
                            $('.error-message').html('<span class="text-danger">All Fields Are Required</span>');

                        } else {
                            $('#saveMerchant').html('Save');
                            $('.error-section').html(data.StatusMessage); 
                            if(data.Errors.length > 0) {
                                var i=0;
                                for(i=0;i<data.Errors.length; i++) {
                                    //console.log(data.Errors[i].Message);
                                    $('.error-message').append('<span class="text-danger">'+data.Errors[i].Message+'</span><br/>');
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert('Error data');
                        $('#saveMerchant').html('Save');
                        $('.error-section').html(""); 
                        $('.error-message').html('<span class="text-danger">Error data</span>');
                    }
                });
            }  
        }
    }

    function validateMerchantApi($wrapper) {
        var emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;// Email address
        var phone = /[0-9]/;// Email address
        var trueFalse= 1;

        $wrapper.find('.required').each(function() {
            var tabIndx=$(this).closest('.tab-pane').index();
            var tabLngth=$wrapper.find('.tab-pane').length - 1;
            var goNext=false;

            var $triggerTab='';
            $triggerTab=$wrapper.find('.nav-tabs .nav-item .nav-link').eq(tabIndx).attr('href');
            // console.log($triggerTab);

            var txtVal=$(this).val();
            // console.log(txtVal)
            //check empty
            if(!txtVal.length) {
                // console.log('run')
                $(this).closest('.form-group').addClass('mandatory');
                console.log($(this).closest('.form-group'));
                $('.nav-tabs a[href="' + $triggerTab + '"]').tab('show');
                $(this).focus();
                // $(this).css('background-color','#B22222');
                
                // $(this).css('color','#fff');
                trueFalse=0;
                return false;
            }

            //check if email
            if($(this).hasClass('email')) {
                if(!emailRegx.test(txtVal)) {
                    $(this).closest('.form-group').addClass('incorrect');
                    $('.nav-tabs a[href="' + $triggerTab + '"]').tab('show');
                    $(this).focus();
                    trueFalse=0;
                    return false;
                }
            }
        })
        return trueFalse;
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
<?php include_once'footer_dash.php'; ?>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>