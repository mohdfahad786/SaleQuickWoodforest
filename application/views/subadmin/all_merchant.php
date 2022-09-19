<?php
    include_once'header_dash_list.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    /*.table tbody tr td span, table tbody tr td span {
        display: inline !important;
    }*/
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
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
        -webkit-box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        -moz-box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
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
        font-size: 30px !important;
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
    /*.modal.show.blur-mdl {
        opacity: 0.75;
    }*/
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
    .td_left_text {
        font-size: 16px;
        font-family: Avenir-Heavy !important;
        height: 50px !important;
    }
    .padding_10 {
        padding-left: 10px !important;
    }
    .modal-backdrop {
        opacity: 0.65;
        filter: alpha(opacity=65);
    }
</style>

<?php
$Total_enactive=0;
$Total_active=0;
$Total_pending=0;
$Total_cancel=0;
//print_r($package_mem); die();
foreach($package_mem as $a_data) {
   // print_r($a_data); die(); 
    $start_date = date("Y-m-d", strtotime("-29 days"));
    $end_date = date("Y-m-d");
    $employee=0;

    $package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data->id,$employee, 'pos');
    $package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data->id,$employee, 'customer_payment_request');
    
    $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount'];

    if($total_amount_a > '0') {
        $a=1;
        $Total_active+= $a;
    } else {  
        $b=1;  
        $Total_enactive+= $b;
    }
    if($a_data->status=='pending') { 
       $c=1;  
       $Total_pending+= $c;
    } else if($a_data->status=='cancel') {
       $d=1;  
       $Total_cancel+= $d;
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
                                    <h1 class="newtotalorders head-count-val"><?php echo $Total_active ;?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                   <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-2.png"> 
                                    <!-- <img src="<?php echo base_url('merchant-panel'); ?>/image/doller-package.png"> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Active</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                            <small class="summary-grid-text">Merchant</small>

                                </div>
                                <div class="col-2" style="margin-left: -5px !important;">
                                    <a class="top_grid_link" href="<?= base_url('agent/all_active_merchant'); ?>" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="totalorders head-count-val" style="color: #000 !important;"><?php echo $Total_enactive; ?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-3.png">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Inactive </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <small class="summary-grid-text">Merchant </small>
                                </div>
                                <div class="col-2" style="margin-left: -5px !important;">
                                    <a class="top_grid_link" href="<?= base_url('agent/inactive_merchant'); ?>" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="totalpendingorders head-count-val" style="color: #000 !important;"><?php echo $Total_pending; ?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-1.png">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Pending</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                      <small class="summary-grid-text">Merchant</small>
                                
                            
                                </div>
                                <div class="col-2" style="margin-left: -5px !important;">
                                    <form method="post" action="<?php echo base_url('agent/pending_merchant'); ?>">
                                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                        <input name="status" type="hidden" value="pending">

                                        <button class="top_grid_btn" type="submit" name="mysubmit" value="Search" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6 col-sm-6 equel-grid">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="TotalLate head-count-val" style="color: #000 !important;"><?php echo $Total_cancel; ?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="https://salequick.com/new_assets/img/new-icons/summary-img-4.png">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Canceled</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <small class="summary-grid-text">Merchant</small>
                                </div>
                                <div class="col-2" style="margin-left: -5px !important;">
                                    <form method="post" action="<?php echo base_url('agent/canceled_merchant'); ?>">
                                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                        <input name="status" type="hidden" value="cancel">

                                        <button class="top_grid_btn" type="mysubmit" name="mysubmit" value="Search" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $count = 0; ?>
            <?php if($meta=='Canceled Merchant') { ?>
                <form class="row" method="post" action="<?php echo base_url('agent/canceled_merchant'); ?>" style="margin-bottom: 20px !important;">

            <?php } else if($meta=='Approved Merchant') { ?> 
                <form class="row" method="post" action="<?php echo base_url('agent/approve_merchant'); ?>" style="margin-bottom: 20px !important;">

            <?php } else if($meta=='Pending Merchant') { ?> 
                <form class="row" method="post" action="<?php echo base_url('agent/pending_merchant'); ?>" style="margin-bottom: 20px !important;">

            <?php } else { ?>
                <form class="row" method="post" action="<?php echo base_url('agent/all_merchant'); ?>" style="margin-bottom: 20px !important;">
            <?php } ?>
                <!-- <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;"> -->
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <!-- <div id="pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div> -->
                </div>
                <!-- <div class="col-sm-2 col-md-2 col-lg-2"> -->
                <div class="table_custom_status_selector">
                    <?php if($meta=='Canceled Merchant') { ?> 
                        <select class="form-control" name="status" id="status" required="" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <option value="cancel">Cancel</option>
                        </select> 
               
                    <?php } else if($meta=='Approved Merchant') { ?> 
                        <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <option value="active">Approved</option>
                        </select>

                    <?php } else if($meta=='Pending Merchant') { ?> 
                        <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <option value="pending">Pending</option>
                        </select> 

                    <?php } else { ?>
                        <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <option value="">Select Status</option>
                            <?php if (!empty($status) && isset($status)) { ?>
                                <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?> >Pending</option>
                                <option value="Activate_Details" <?php echo (($status == 'Activate_Details') ? 'selected' : "") ?> > Activate Details</option>
                                <option value="Waiting_For_Approval" <?php echo (($status == 'Waiting_For_Approval') ? 'selected' : "") ?> >Waiting For Approval</option>
                                <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?> >Confirm</option>
                                <option value="active" <?php echo (($status == 'active') ? 'selected' : "") ?> >Active</option>
                                <option value="block" <?php echo (($status == 'block') ? 'selected' : "") ?>>Block</option>
                                <option value="cancel" <?php echo (($status == 'cancel') ? 'selected' : "") ?>>Cancel</option>
                            <?php } else { ?>
                                <option value="pending">Pending</option>                
                                <option value="Activate_Details"> Activate Details</option>
                                <option value="Waiting_For_Approval">Waiting For Approval</option>
                                <option value="confirm">Confirm</option>
                                <option value="active">Active</option>
                                <option value="block">Block</option>
                                <option value="cancel">Cancel</option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
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
                                <th>Company Name</th>
                                <th>Contact Person</th>
                                <th class="no-event">Info</th>
                                <th>Monthly Income </th>
                                <th class="no-event">Status </th>
                               <!--  <th>Tokenized System</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($mem as $a_data) {
                                $count++;
                                $start_date = date("Y-m-d", strtotime("-29 days"));
                                $end_date = date("Y-m-d");
                                $employee=0;
   
                                $package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'pos');
   
                                $package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'customer_payment_request');
     
                                $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']; 

                                   $current_month = date('m');
        
        if($current_month == '01') {
            $field_name = 'Totaljan';
        } else if($current_month == '02') {
            $field_name = 'Totalfeb';
        } else if($current_month == '03') {
            $field_name = 'Totalmarch';
        } else if($current_month == '04') {
            $field_name = 'Totalaprl';
        } else if($current_month == '05') {
            $field_name = 'Totalmay';
        } else if($current_month == '06') {
            $field_name = 'Totaljune';
        } else if($current_month == '07') {
            $field_name = 'Totaljuly';
        } else if($current_month == '08') {
            $field_name = 'Totalaugust';
        } else if($current_month == '09') {
            $field_name = 'Totalsep';
        } else if($current_month == '10') {
            $field_name = 'Totaloct';
        } else if($current_month == '11') {
            $field_name = 'Totalnov';
        }  else if($current_month == '12') {
            $field_name = 'Totaldec';
        }

                          $get_monthly_volume = $this->db->select($field_name)->where('merchant_id',$a_data['id'])->get('merchant_year_graph_two')->row();

                          $get_monthly_volume_merchant = !empty($get_monthly_volume->$field_name) ? '$'.number_format($get_monthly_volume->$field_name,2) : '$0.00';
            // echo $this->db->last_query();die;
            // echo '<pre>';print_r($get_monthly_volume);die;
                                ?>

                                <tr id="row_<?php echo $a_data['id'];?>">
                                    <td><?php echo $a_data['business_name'] ?></td>
                                    <td><?php echo $a_data['name'] ?></td>
                                    <td style="width: 150px !important;">
                                        <a href="#" class="poslist_vw_btn pos_Status_c badge-btn" data-id="<?php echo $a_data['id']; ?>" style="display: table-caption !important;"><span class="fa fa-eye"></span> View</a>
                                    </td>
                                    <td><span class="status_success"><?php echo $get_monthly_volume_merchant; ?></span></td>
                                    <td>
                                        <?php
                                        if($a_data['status']=='active') {
                                            if($total_amount_a > '0'){
                                                echo '<span class="btn btn-success" style="display: inline-flex !important;">Active</span>';
                                            } elseif ($total_amount_a == '0') {
                                                echo '<span class="btn btn-danger" style="display: inline-flex !important;">Inactive</span>';
                                            } else {
                                                echo '<span class="btn btn-danger" style="display: inline-flex !important;">Inactive</span>';
                                            }
                                        } else {
                                            echo '<span class="btn btn-warning" style="display: inline-flex !important;">'.$a_data['status'].'</span>';
                                        } ?>
                                    </td>
                                  <!--   <td>
                                        <span class="start_stop_tax <?php echo ($a_data['is_token_system_permission'] > 0) ? 'active' : ''; ?>" rel="238" ><label class="switch switch_type1" role="switch" style="z-index: 0 !important;"><input type="checkbox" class="switch__toggle" <?php echo ($a_data['is_token_system_permission'] > 0) ?  'checked' : ''; ?> id="switchval_<?php echo $a_data['id']; ?>" value="<?php echo $a_data['id']; ?>"><span class="switch__label">|</span></label><span class="msg"><span class="stop">Stop</span><span class="start">Start</span></span></span>
                                    </td> -->
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="invoice-receipt-modal" class="invRecptMdlWrapper modal" data-backdrop="true">
    <div class="modal-dialog modal-lg modal-md modal-sm" style="max-width: 575px !important;">
        <div class="modal-content" id="invoicePdfData">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div id="new_receipt_body" class="col-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                            <p class="invoice-number" style="font-family: Avenir-Heavy !important;font-size: 18px;"><u>Merchant Details</u></p>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 15px !important;margin-top: 5px !important;">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <table class="payment-details-table" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td width="30%" class="left td_left_text">Name</td>
                                        <td width="70%" style="text-align: right;" class="merchant_name"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="left td_left_text">Email</td>
                                        <td width="70%" style="text-align: right;" class="merchant_email"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="left td_left_text">Mobile No.</td>
                                        <td width="70%" style="text-align: right;" class="merchant_mob_no"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="left td_left_text">Business Number</td>
                                        <td width="70%" style="text-align: right;" class="merchant_business_number"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="left td_left_text">Address</td>
                                        <td width="70%" style="text-align: right;white-space: pre-line !important;" class="merchant_address"></td>
                                    </tr>
                                    <!-- <tr>
                                        <td width="30%" class="left td_left_text">State</td>
                                        <td width="70%" style="text-align: right;" class="merchant_state"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="left td_left_text">City</td>
                                        <td width="70%" style="text-align: right;" class="merchant_city"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="left td_left_text">Zip</td>
                                        <td width="70%" style="text-align: right;" class="merchant_zip"></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function($){
        $('body').on('click','.poslist_vw_btn', function (e) {
            $('.merchant_name').empty();
            $('.merchant_email').empty();
            $('.merchant_mob_no').empty();
            $('.merchant_business_number').empty();
            $('.merchant_address').empty();
            // $('.merchant_state').empty();
            // $('.merchant_city').empty();
            // $('.merchant_zip').empty();
                // stop - start
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            // $('#invoice-receipt-modal').modal('show');
            // $('#invoice-receipt-modal .modal-content').html($('#loader-content').html());

            $.ajax({
                url: "<?php echo base_url('agent/search_record_column_merchant'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: "JSON",
            })
            .done(function(data){
                // var data = data[0];
                // console.log(data);return false;
                // $('#invoice-receipt-modal .modal-content').html(data); // load response
                $('.merchant_name').html(data.business_name);
                $('.merchant_email').html(data.email);
                $('.merchant_mob_no').html(data.mob_no);
                $('.merchant_business_number').html(data.business_number);
                $('.merchant_address').html(data.merchant_address);
                // $('.merchant_state').html(data.state);
                // $('.merchant_city').html(data.city);
                // $('.merchant_zip').html(data.zip);

                $('#invoice-receipt-modal').modal('show');
            })
            .fail(function(){
                $('#invoice-receipt-modal .modal-content').html("<div class='modal-header' style='border-bottom: none !important;margin-top: 10px !important;font-size: 15px !important;font-weight: 500;'><div class='row'><div class='col-12'><i class='mdi mdi-alert-outline mdi-2x' style='color: red;'></i> Something went wrong, Please try again.</div></div></div>");
            });
        })
    });

    $(document).on('change','.start_stop_tax input[type="checkbox"]', function (e) {
        // stop - start
        e.preventDefault();
        var m=$(this).val(); 
        var permission=$(this).is(':checked');
        //alert(permission); 
        $.ajax({
            url: "<?php  echo base_url('agent/tokenSystemPermission'); ?>",
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
        } else {
            $(this).closest('.start_stop_tax').removeClass('active');
        }
    })
</script>
<?php include_once'footer_dash_list.php'; ?>