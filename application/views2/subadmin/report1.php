<?php
    include_once'header_dash_list.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .table tbody tr td span, table tbody tr td span {
        display: inline !important;
    }
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
    }
    .resend_rcpt_btn_confirm {
        margin-top: 10px !important;
        font-family: AvenirNext-Medium !important;
        font-weight: 600;
        color: #000;
    }
    .resend_rcpt_btn_confirm:focus, .resend_rcpt_btn_confirm:hover {
        color: #000;
    }
    .resend_rcpt_btn {
        font-family: AvenirNext-Medium !important;
        color: #868e96 !important;
        padding: 0px 15px !important;
    }
    .resend_rcpt_btn:focus, .resend_rcpt_btn:hover {
        color: #000;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    .summary-grid-status {
        font-size: 18px;
        color: rgb(62, 62, 62);
        font-weight: 600;
        font-family: Avenir-Heavy !important;
        margin-bottom: 0px !important;
    }
    @media screen and (max-width: 640px) {
        #pos_list_daterange span {
            font-size: 10px !important;
        }
    }
    @media screen and (max-width: 640px) {
        select.form-control {
            font-size: 10px !important;
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
    .top_grid_effect:hover {
        -webkit-box-shadow: rgba(102, 102, 102, 0.09) 20px 15px 15px;
        -moz-box-shadow: rgba(102, 102, 102, 0.09) 20px 15px 15px;
        box-shadow: rgba(102, 102, 102, 0.09) 20px 15px 15px;
        /*box-shadow: rgba(102, 102, 102, 0.09) 0 0 15px;*/
        opacity: 1;
        transition-timing-function: ease;
    }
    .top_grid_link {
        background-color: #4c6ef5;
        padding: 2px 10px;
        border-radius: 10px;
    }
    .top_grid_btn {
        background-color: #4c6ef5;
        border-radius: 10px;
        border: none !important;
        padding: 0px 10px;
    }
    .head-count-val {
        color: #000 !important;
        font-family: Avenir-Black;
        font-weight: 600 !important;
        font-size: 20px !important;
    }
    @media screen and (min-width: 641px) {
        #invoice-receipt-modal .modal-content {
            padding: 0px 25px 15px 25px !important;
            border: none !important;
        }
    }
    @media screen and (max-width: 640px) {
        #invoice-receipt-modal .modal-content {
            padding: 0px 5px 15px 5px !important;
            border: none !important;
        }
    }
    .modal-header {
        border-bottom: none !important;
    }
    .modal.show.blur-mdl {
        opacity: 0.75;
    }
    body.p_recept .modal-dialog.modal-lg{
        max-width: 900px;
    }
    body.p_recept .modal .modal-footer,body.p_recept .modal .close, body.p_recept .modal .refunded_row {
        display: none !important;
    }
    span.card-img-no {
        white-space: nowrap;
        display: block;
        min-width: 115px;
    }
    .noc {
        display: none !important;
    }
</style>

<?php
    $Total_enactive=0;
    foreach($full_reporst as $a_data) {
        $start_date = date("Y-m-d", strtotime("-29 days"));
        $end_date = date("Y-m-d");
        $employee=0;

        $package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'pos');
        $package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'customer_payment_request');
        $package_data_total_count_invoice_re = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'recurring_payment');
        $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'];

        if($total_amount_a > '0'){
        } elseif ($total_amount_a = 0.00) {
            $Total_enactive = $Total_enactive + 1;
        } else {    
            $Total_enactive = $Total_enactive + 1;
        }
    } ?>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="https://salequick.com/new_assets/img/giphy.gif"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!--  <h4 class="h4-custom">Transactions</h4> --> 
                </div>
            </div>

                        <div class="row">
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary" >
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="newtotalorders head-count-val">$<?php echo number_format($GrosspaymentValume,2) ;?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                   <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-2.png"> 
                                    <!-- <img src="<?php echo base_url('merchant-panel'); ?>/image/doller-package.png"> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Payment</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                  <small class="summary-grid-text">Card Payment Volume</small>
                                </div>
                                <div class="col-2" style="margin-left: -5px !important;">
                                    <!-- <a class="top_grid_link" href="<?= base_url('pos/all_pos'); ?>" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <!-- <a href="#" data-toggle="modal" data-target="#view-modal-revenue" data-id="" id="getRevenue" title="View Details"> -->
                                <div class="d-flex justify-content-between">
                                    <div class="summary-grid-text-section">
                                        <h1 class="totalorders head-count-val" style="color: #000 !important;">$<?php echo number_format($getDashboardData[0]['NewTotalOrders'] + $getDashboardData[0]['TotalPosordernew'],2) ; ?></h1>
                                    </div>
                                    <div class="summary-grid-img-section">
                                        <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-3.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="summary-grid-status">Revenue </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <small class="summary-grid-text">Total Revenue </small>
                                    </div>
                                    <div class="col-2" style="margin-left: -5px !important;">
                                        <!-- <a class="top_grid_link" href="<?= base_url('pos/all_customer_request'); ?>" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></a> -->
                                    </div>
                                </div>
                            <!-- </a> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <!-- <a href="#" data-toggle="modal" data-target="#view-modal-cost" data-id="" id="getCost" title="View Details"> -->
                                <div class="d-flex justify-content-between">
                                    <div class="summary-grid-text-section">
                                        <h1 class="totalpendingorders head-count-val" style="color: #000 !important;">$0.00</h1>
                                    </div>
                                    <div class="summary-grid-img-section">
                                        <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-1.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="summary-grid-status">Cost</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                          <small class="summary-grid-text">Total  cost of revenue</small>
                                    
                                
                                    </div>
                                    <div class="col-2" style="margin-left: -5px !important;">
                                        <!-- <form method="post" action="<?php echo base_url('pos/all_customer_request'); ?>">
                                            <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                            <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                            <input name="status" type="hidden" value="pending">

                                            <button class="top_grid_btn" type="submit" name="mysubmit" value="Search" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></button>
                                        </form> -->
                                    </div>
                                </div>
                            <!-- </a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 col-sm-6 equel-grid">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <!-- <a href="#" data-toggle="modal" data-target="#view-modal-profit" data-id="" id="getProfit" title="View Details"> -->
                                <div class="d-flex justify-content-between">
                                    <div class="summary-grid-text-section">
                                        <h1 class="TotalLate head-count-val" style="color: #000 !important;">$<?php echo number_format($total_payout,2) ;?></h1>
                                    </div>
                                    <div class="summary-grid-img-section">
                                        <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-4.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="summary-grid-status">Payout</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <small class="summary-grid-text">Total Payout</small>
                                    </div>
                                    <div class="col-2" style="margin-left: -5px !important;">
                                        <!-- <form method="post" action="<?php echo base_url('pos/all_customer_request'); ?>">
                                            <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                            <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                            <input name="status" type="hidden" value="pending">

                                            <button class="top_grid_btn" type="submit" name="mysubmit" value="Search" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></button>
                                        </form> -->
                                    </div>
                                </div>
                            <!-- </a> -->
                        </div>
                    </div>
                </div>
            </div>

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('agent/report'); ?>" style="margin-bottom: 20px !important;">
                <!-- <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;"> -->
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div>
                </div>
                <!-- <div class="col-sm-2 col-md-2 col-lg-2"> -->
               <!--  <div class="table_custom_status_selector">
                    <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
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
                </div> -->
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="dt_inv_pos_sale_list" class="hover row-border pos-list-dtable" style="width:100%">    
                        <thead>
                            <tr>
                                <th class="no-event">Crad Payments</th>
                                <th class="no-event">Merchant</th>
                                <th class="no-event">Avg Transaction </th>
                                <th class="no-event">Revenue </th>
                                <th class="no-event">Cost </th>
                                <th class="no-event">Reseller Profit</th>
                                <th class="no-event">Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($full_reporst as $a_data) {
                                $count++; ?>
                                <?php
                                $start_date = date("Y-m-d", strtotime("-29 days"));
                                $end_date = date("Y-m-d");
                                $employee=0;
                                //  $package_data_cash_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $a_data['id'],$employee, 'pos','CASH');
                                $package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'pos');
                                //  $package_data_card_total = $this->Inventory_graph_model->get_search_merchant_pos_total_card($start_date, $end_date, $status, $a_data['id'],$employee, 'pos');
                                $package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'customer_payment_request');
                                // $package_data_total_count_invoice_re = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'recurring_payment');
                                //  $package_data_check_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $a_data['id'],$employee, 'pos','CHECK');
                                // $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'];

                                $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount'];

                                //$package_data_total_count[0]['id'];
                                //print_r($package_data_card_total);
                                ?>

                                <tr id="row_<?php echo $a_data['id'];?>">
                                    <td>$ <?php echo @number_format($a_data['totalAmount'],2); ?> </td>
                                    <td><?php echo $a_data['business_dba_name']; ?></td>
                                    <td>$0.00</td>

                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#view-modal-revenue" data-id="" id="getRevenue" title="View Details">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#view-modal-cost" data-id="" id="getCost" title="View Details">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#view-modal-profit" data-id="" id="getProfit" title="View Details">$0.00</a>
                                    </td>

                                    <td>
                                        <?php
                                        if($a_data['status']=='active') {
                                            if($total_amount_a > '0'){
                                                echo '<span class="btn btn-success"> Active  </span>';
                                            } elseif ($total_amount_a == '0') {
                                                echo '<span class="btn btn-danger"> Inactive </span>';
                                            } else {
                                                echo '<span class="btn btn-danger"> Inactive </span>';
                                            }
                                        } else {
                                            echo '<span class="btn btn-warning"> Pending  </span>';
                                        } ?>
                                    </td>
                                </tr>
                                <?php $i++;
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="view-modal-revenue" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Merchant Revenue
        </h4> 
      </div> 
      <div class="modal-body"> 
       <div id="modal-loader" class="text-center modal-loader" style="display: none;">
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

<div id="view-modal-cost" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Merchant Cost
        </h4> 
      </div> 
      <div class="modal-body"> 
       <div id="modal-loader" class="text-center modal-loader" style="display: none;">
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

<div id="view-modal-profit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Merchant Profit
        </h4> 
      </div> 
      <div class="modal-body"> 
       <div id="modal-loader" class="text-center modal-loader" style="display: none;">
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

<script>
    $(document).ready(function(){
        $(document).on('click', '#getRevenue', function(e){
            // e.preventDefault();
            // var uid = $(this).data('id');
            // var date = $(this).data('date');
            // $('#dynamic-content').html('');
            // $('#modal-loader,.modal-loader').show();
            // $.ajax({
            //     url: "<?php echo base_url('dashboard/search_record_column2'); ?>",
            //     type: 'POST',
            //     data: 'id='+uid+"&date="+date,
            //     dataType: 'html'
            // })
            // .done(function(data){
            //     console.log(data);  
            //     $('#dynamic-content').html('');    
            //     $('#dynamic-content').html(data);
            //     $('#modal-loader,.modal-loader').hide();
            // })
            // .fail(function(){
            //     $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            //     $('#modal-loader,.modal-loader').hide();
            // });
        });
    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="https://salequick.com/new_assets/css/sweetalert.css">
<script src="https://salequick.com/new_assets/js/sweetalert.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<?php include_once'footer_dash_list.php'; ?>