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
    select.form-control {
        border: 1px solid transparent !important;
    }
</style>

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
                                        <h1 class="totalorders head-count-val" style="color: #000 !important;">$<?php echo number_format($TotalrevenueCaptured,2) ;?></h1>
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
                                        <h1 class="totalpendingorders head-count-val" style="color: #000 !important;">$<?php echo number_format($Cost,2) ;?></h1>
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
                                        <h1 class="TotalLate head-count-val" style="color: #000 !important;">$<?php echo number_format($Payout,2) ;?></h1>
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
            <form class="row" method="post" action="<?php echo base_url('Agent/report'); ?>" style="margin-bottom: 20px !important;margin-top: 10px !important;">
             
                <div class="col-12">
                    <div class="row">
                        <div style="width: auto;margin-right: 15px;margin-top: 10px;margin-left: 12px;">
                            <label>Select Year & Month</label>
                        </div>
                        <div>
                            <?php
                            $currentYear = date('Y');
                            $startYear=date('Y')-2;
                            ?>
                            <select class="form-control" id="csv_year" name="csv_year" required style="margin-right: 10px;width: 100px;">
                                <option value="">Year</option>
                                <?php for ($i=$currentYear; $i >= $startYear ; $i--) { ?>
                                    <option value="<?=$i?>" <?php echo ($i == $csv_year) ? 'selected' : ''; ?>><?=$i;?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div style="margin-right: 10px;width: 100px;">
                            <select class="form-control" id="csv_month" name="csv_month" required>
                                <option value="">Month</option>
                                <option value="1" <?php echo ($csv_month == '1') ? 'selected' : ''; ?>>Jan</option>
                                <option value="2" <?php echo ($csv_month == '2') ? 'selected' : ''; ?>>Feb</option>
                                <option value="3" <?php echo ($csv_month == '3') ? 'selected' : ''; ?>>Mar</option>
                                <option value="4" <?php echo ($csv_month == '4') ? 'selected' : ''; ?>>Apr</option>
                                <option value="5" <?php echo ($csv_month == '5') ? 'selected' : ''; ?>>May</option>
                                <option value="6" <?php echo ($csv_month == '6') ? 'selected' : ''; ?>>Jun</option>
                                <option value="7" <?php echo ($csv_month == '7') ? 'selected' : ''; ?>>Jul</option>
                                <option value="8" <?php echo ($csv_month == '8') ? 'selected' : ''; ?>>Aug</option>
                                <option value="9" <?php echo ($csv_month == '9') ? 'selected' : ''; ?>>Sep</option>
                                <option value="10" <?php echo ($csv_month == '10') ? 'selected' : ''; ?>>Oct</option>
                                <option value="11" <?php echo ($csv_month == '11') ? 'selected' : ''; ?>>Nov</option>
                                <option value="12" <?php echo ($csv_month == '12') ? 'selected' : ''; ?>>Dec</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">    
                        <thead>
                            <tr>
                                 <th class="no-event">Total Transaction</th>
                                <th class="no-event">Payment Volume</th>
                                 <th class="no-event">Merchant</th>
                               <!--  <th class="no-event">Reseller</th> -->
                               <!--  <th class="no-event">Number Of active Merchants </th> -->
                                <th class="no-event">Revenue </th>
                                <th class="no-event">Cost </th>
                                 <th class="no-event">Signup Bonus </th>
                                <th class="no-event">Reseller Profit</th>
                                <th class="no-event">Status </th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                            $count = 0;
                            $i=1;
                            foreach($mem as $a_data) {
                                $count++; 
                               
                                $start_date = date("Y-m-d", strtotime("-29 days"));
                                $end_date = date("Y-m-d");
                                $employee=0;
                               
                                $package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'pos');
                               
                                $package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'customer_payment_request');
                            

                                $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount'];

                                ?>
                            <tr id="row_11">
                                <td><?php echo $a_data['m_transaction'] ?></td>
                                <td>$ <?php echo number_format($a_data['m_amount'],2) ?> </td>
                                <td><?php echo $a_data['name'] ?></td>
                               <!--  <td><?php echo $a_data['total_merchant'] ?></td> -->
                                <td>
                                    <a href="javascript:void(0)" data-value1="<?php echo '$11.00'; ?>" data-value2="<?php echo '$22.00'; ?>" data-value3="<?php echo '$33.00'; ?>" id="getRevenue" title="View Details">$<?php echo number_format($a_data['m_revenue'],2) ?></a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-value4="<?php echo number_format($a_data['m_cost_only'],2) ?>" data-value5="<?php echo number_format($a_data['m_buy_rate'],2) ?>" data-value6="<?php echo number_format($a_data['m_gateway_fee'],2) ?>" id="getCost" title="View Details">$<?php echo number_format($a_data['m_cost'],2) ?></a>
                                </td>

                                 <td>
                                    <a href="javascript:void(0)" >$0.00</a>
                                </td>

                                <td>
                                    <a href="javascript:void(0)" data-value7="<?php echo '$77.00'; ?>" data-value8="<?php echo '$88.00'; ?>" data-value9="<?php echo '$99.00'; ?>" id="getProfit" title="View Details">$<?php echo number_format($a_data['m_profit'],2) ?></a>
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
                            } ?>
                            <!-- <tr id="row_11">
                                <td>$ 0.00 </td>
                                <td>Demo Name</td>
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
                                    <span class="btn btn-success"> Active </span>
                                </td>
                            </tr>
                            <tr id="row_11">
                                <td>$ 0.00 </td>
                                <td>Demo Name</td>
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
                                    <span class="btn btn-success"> Active </span>
                                </td>
                            </tr>
                            <tr id="row_11">
                                <td>$ 0.00 </td>
                                <td>Demo Name</td>
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
                                    <span class="btn btn-success"> Active </span>
                                </td>
                            </tr>
                            <tr id="row_11">
                                <td>$ 0.00 </td>
                                <td>Demo Name</td>
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
                                    <span class="btn btn-success"> Active </span>
                                </td>
                            </tr> -->
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
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Heading1</th>
                    <th>Heading2</th>
                    <th>Heading3</th>
                </tr>
                <tr>
                    <td class="td_value1"></td>
                    <td class="td_value2"></td>
                    <td class="td_value3"></td>
                </tr>
            </tbody>
        </table>
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
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>InterchangeFee</th>
                    <th>Buy Rate</th>
                    <th>Gateway Fee</th>
                </tr>
                <tr>
                    <td class="td_value4"></td>
                    <td class="td_value5"></td>
                    <td class="td_value6"></td>
                </tr>
            </tbody>
        </table>
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
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Heading1</th>
                    <th>Heading2</th>
                    <th>Heading3</th>
                </tr>
                <tr>
                    <td class="td_value7"></td>
                    <td class="td_value8"></td>
                    <td class="td_value9"></td>
                </tr>
            </tbody>
        </table>
      </div> 
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
      </div> 
    </div> 
  </div>
</div>

<script>
    $(document).on('click', '#getRevenue1', function(e){
        $('.td_value1').html('');
        $('.td_value2').html('');
        $('.td_value3').html('');

        $('.td_value1').html($(this).data('value1'));
        $('.td_value2').html($(this).data('value2'));
        $('.td_value3').html($(this).data('value3'));

        $('#view-modal-revenue').modal('show');
    });

    $(document).on('click', '#getCost', function(e){
        $('.td_value4').html('');
        $('.td_value5').html('');
        $('.td_value6').html('');

        $('.td_value4').html($(this).data('value4'));
        $('.td_value5').html($(this).data('value5'));
        $('.td_value6').html($(this).data('value6'));

        $('#view-modal-cost').modal('show');
    });

    $(document).on('click', '#getProfit1', function(e){
        // e.preventDefault();
        $('.td_value7').html('');
        $('.td_value8').html('');
        $('.td_value9').html('');

        $('.td_value7').html($(this).data('value7'));
        $('.td_value8').html($(this).data('value8'));
        $('.td_value9').html($(this).data('value9'));

        $('#view-modal-profit').modal('show');
    });

    function setTransactionDefDate(){
        if($("#inv_pos_list_daterange").length){
            $("#inv_pos_list_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
            $("#inv_pos_list_daterange input[name='start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
            $("#inv_pos_list_daterange input[name='end_date']").val( moment().format("YYYY-MM-DD"));
        }
    }

    $(document).ready(function() {
        if($('#inv_pos_list_daterange').length){
            var inv_pos_list_daterange_config = {
                ranges: {
                    Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                },opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
                startDate: (($("#inv_pos_list_daterange input[name='start_date']").val().length > 0) ? ($("#inv_pos_list_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
                    endDate: (($("#inv_pos_list_daterange input[name='end_date']").val().length > 0) ? ($("#inv_pos_list_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
            };
            // console.log(inv_pos_list_daterange_config)
            $('#inv_pos_list_daterange').daterangepicker(inv_pos_list_daterange_config, function(a, b) {
                $("#inv_pos_list_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
                $("#inv_pos_list_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
                $("#inv_pos_list_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
                // setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
            });
        }

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
                },
                "buttons": [{
                    extend: 'collection',
                    text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
                    buttons: [
                        'copy',
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ]
                }]
            }
            $('#datatable').DataTable(dtTransactionsConfig);
        });
    })
</script>

<?php include_once'footer_dash.php'; ?>