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

        if($total_amount_a > '0'){
            $a=1;
            $Total_active+= $a;
        } 
        else {  
            $b=1;  
            $Total_enactive+= $b;
        }
        if($a_data->status=='pending')
        { 
           $c=1;  
           $Total_pending+= $c;
        }  
        else if($a_data->status=='cancel')
        {
           $d=1;  
           $Total_cancel+= $d;
        }    
       
    }
  
     ?>

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
                            <small class="summary-grid-text">Merchan</small>

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
      
<!-- 
            <form class="row" method="post" action="<?php echo base_url('agent/all_merchant'); ?>" style="margin-bottom: 20px !important;">
            
                
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div>
                </div>
                

                               <div class="table_custom_status_selector">


                    <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                      <option value="">Select Status</option>
                   <?php if (!empty($status) && isset($status)) {  ?>
                        <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?> >Pending</option>                
                        <option value="Activate_Details" <?php echo (($status == 'Activate_Details') ? 'selected' : "") ?> > Activate Details</option>
                        <option value="Waiting_For_Approval" <?php echo (($status == 'Waiting_For_Approval') ? 'selected' : "") ?> >Waiting For Approval</option>
                        <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?> >Confirm</option>
                        <option value="active" <?php echo (($status == 'active') ? 'selected' : "") ?> >Active</option>
                        <option value="block" <?php echo (($status == 'block') ? 'selected' : "") ?>>Block</option>
                        <option value="cancel" <?php echo (($status == 'cancel') ? 'selected' : "") ?>>Cancel</option>
                   <?php  } else {?>
                        <option value="pending">Pending</option>                
                        <option value="Activate_Details"> Activate Details</option>
                        <option value="Waiting_For_Approval">Waiting For Approval</option>
                        <option value="confirm">Confirm</option>
                        <option value="active">Active</option>
                        <option value="block">Block</option>
                        <option value="cancel">Cancel</option>
                  <?php } ?>
                    </select>
                 
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form> -->
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="dt_inv_pos_sale_list" class="hover row-border pos-list-dtable" style="width:100%">    
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th class="no-event">Info</th>
                                <th>Monthly Income </th>
                                <th class="no-event">Status </th>
                            </tr>
                        </thead>
                        <tbody>
                                                <?php

                     $i = 1;
                                foreach ($mem as $a_data) {
                                    $count++;

                   
                      ?>
                      <?php
      $start_date = date("Y-m-d", strtotime("-29 days"));
      $end_date = date("Y-m-d");
      $employee=0;
   
      $package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'pos');
   
      $package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $a_data['id'],$employee, 'customer_payment_request');
     

       $total_amount_a = $package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount'];

      //$package_data_total_count[0]['id'];
      //print_r($package_data_card_total);
       if($total_amount_a > '0' ){
                      ?>

                                <tr id="row_<?php echo $a_data['id'];?>">
                                    <td><?php echo $a_data['business_name'] ?></td>
                                    <td style="width: 150px !important;">
                                        <a href="#" class="poslist_vw_btn pos_Status_c badge-btn" data-id="<?php echo $a_data['id']; ?>" style="display: table-caption !important;"><span class="fa fa-eye"></span> View</a>
                                    </td>
                                    <td><span class="status_success">$<?php echo number_format(10,2);  ?></span></td>
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
                                            echo '<span class="btn btn-warning"> '.$a_data['status'].'  </span>';
                                        } ?>
                                    </td>
                                </tr>
                                 <?php } $i++;}?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="https://salequick.com/new_assets/css/sweetalert.css">
<script src="https://salequick.com/new_assets/js/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<script>
function refundingConfirm(amount,type)
{
swal({
title: '<span class="h4">Are you sure?</span>',
text: '<p><span class="refund__type">'+type+'</span> <input type="text" class="sure_refund form-control status_success" readonly="" value="'+amount+'"> </p>',
type: "warning",
showCancelButton: true,
confirmButtonClass: "btn btn-first receiptSSendRequestYes",
confirmButtonText: "Send",
cancelButtonClass: "btn danger-btn receiptSSendRequestNo",
cancelButtonText: "Cancel",
closeOnConfirm: true,
html: true,
closeOnCancel: true},function(isConfirm) 
{
    if(isConfirm){$('#invoice-receipt-modal').removeClass('blur-mdl');} else{
$('#invoice-receipt-modal').removeClass('blur-mdl');}
})
}


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
jQuery(function($){
    $('body').on('click','.posrefund_receipt_vw_btn', function (e) {
            // stop - start
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            var row_id = $(this).data('row-id');   // it will get id of clicked row
            $('#invoice-receipt-modal').modal('show');
            $('#invoice-receipt-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
            $.ajax({
             url: "<?php echo base_url('merchant/search_record_column_pos_refund'); ?>",
             type: 'POST',
             data: 'id='+uid+'&'+'row_id='+row_id,
             dataType: 'html'
         })
            .done(function(data){
                // console.log(data);
                $('#invoice-receipt-modal .modal-content').html(data); // load response
            })
            .fail(function(){
                $('#invoice-receipt-modal .modal-content').html("<div class='modal-header' style='border-bottom: none !important;margin-top: 10px !important;font-size: 15px !important;font-weight: 500;'><div class='row'><div class='col-12'><i class='mdi mdi-alert-outline mdi-2x' style='color: red;'></i> Something went wrong, Please try again.</div></div></div>");
            });
    })
});




$(document)
.on('click','#receiptSSendRequest',function(){
    if($('#allpos_partref').is(':checked') && $('.partRefund__amount').val())
    {
        var refType='Partial Refund :';
        $('#invoice-receipt-modal').addClass('blur-mdl');
        //alert($('.partRefund__amount').val()); exit; 
        refundingConfirm($('.partRefund__amount').val(),refType);
    }
    else if($('#allpos_fulref').is(':checked') && $('.fullRefund__amount').val())
    {
        var refType='Full Refund :';
        $('#invoice-receipt-modal').addClass('blur-mdl');
        //alert($('.fullRefund__amount').val()); exit;
        refundingConfirm($('.fullRefund__amount').val(),refType)
        // $('#receiptSSendRequest-modal .sure_refund').val($('#amount.refund__amount').val());
        // $('#receiptSSendRequest-modal').modal('show');
    }
    // $('#invoice-receipt-modal').addClass('blur-mdl');
    // $('#receiptSSendRequest-modal .sure_refund').val($('#invoice-receipt-modal .srpttlAmt').text());
    // $('#receiptSSendRequest-modal').modal('show');
})
.on("hide.bs.modal",'#receiptSSendRequest-modal', function () {
        // put your default event here
        $('#invoice-receipt-modal').removeClass('blur-mdl');
        setTimeout(function(){
            if($('.modal.show').length > 0)
            {
                    $('body').addClass('modal-open');
            }
        },100)
})
.on("click",'#receiptSSendRequestYes,.receiptSSendRequestYes', function () {
        // put your default event here
        if($('#allpos_partref').is(':checked')){
            $('#amount').val($('.partRefund__amount').val());
        }
        else{
            $('#amount').val($('.fullRefund__amount').val());
        }

         $('#invoice-receipt-modal #receiptSSendRequest').attr('type','submit').trigger('click');
})
.on("click",'#receiptSSendRequestNo,.receiptSSendRequestNo', function () {
        // put your default event here
    $('#invoice-receipt-modal').removeClass('blur-mdl');
    // $('#receiptSSendRequest-modal').modal('hide');
})

.on('click','#receiptSSendRequestPrint',function(){
    $('body').addClass('p_recept');
    $('.t-header').addClass('d-none');
    $('.sidebar').addClass('d-none');
    $('#base-contents').addClass('d-none');
    window.print();
    $('body').removeClass('p_recept');
    $('.t-header').removeClass('d-none');
    $('.sidebar').removeClass('d-none');
    $('#base-contents').removeClass('d-none');
})
.on('keydown',function(e){
    if(e.ctrlKey && e.keyCode == 80)
    {
        if($('#invoice-receipt-modal').hasClass('show') && ($('.modal.show').length == 1))
        {
                e.preventDefault();
                $('body').addClass('p_recept');
                window.print();
                $('body').removeClass('p_recept');
        }
    }
})
.on('click','#receiptSSendRequestPdf',function(e){
    e.preventDefault();
        makePDF();
        // generate2();

})

$(document).on('click', '.resend_rcpt_btn', function() {
    var rowid = $(this).data('id');
    // console.log(rowid);
    $('#re_mobile').val('');
    $('#re_email_id').val('');
    $('.resend_phone_receipt').html('Send');
    $('.resend_email_receipt').html('Send');

    if(rowid != '') {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/get_phone_email_info'); ?>',   //  re_receipt_pos
            data: {'rowid': rowid},
            success: function (data){
                var obj = JSON.parse(data);
                // console.log(obj);

                $('#re_mobile').val(obj.phone_no);
                $('#re_email_id').val(obj.email_id);
            }
        });
        
        $('#resendReceiptModal').modal('show');
        $('#rcpt_row_id').val(rowid);
    }
})

$(document).on('click', '.resend_phone_receipt, .resend_email_receipt', function() {
    // alert();
    var rcpt_row_id = $('#rcpt_row_id').val();
    var phone_formated = $('#re_mobile').val();
    var email_id = $('#re_email_id').val();
    // console.log(this.className);return false;
    if(this.className == 'btn btn-info resend_phone_receipt') {
        if(phone_formated == '') {
            alert('Please enter phone number to re-send receipt.');
            return false;
        }
        // $('.resend_phone_receipt').prop("disabled", true);
        phone = phone_formated.replace(/[- )(]/g,'');

        var data = {
            'rowid'             : rcpt_row_id,
            'type'              : 'all_request',
            'phone_formated'    : phone_formated,
            'phone'             : phone
        };
        // console.log(this);return false;
        $('.resend_phone_receipt').html('<span class="fa fa-spinner fa-spin" style="width: 35px;"></span>');
        // return false;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_receipt_instore_on_phone'); ?>',   //  re_receipt_pos
            data: data,
            success: function (data){
                if(data==200) {
                    $('.resend_phone_receipt').html('<span class="fa fa-check" style="width:35px;"></span>');
                    
                    // $(this).html('Sent');
                    // alert('Receipt sent successfully.');
                    // $('.resend_rcpt_btn_confirm').html('<span class="fa fa-check status_success"></span> Re-Send Success');
                }
                if(data==500) {
                    alert('Something went wrong.');
                }
            }
        });
    }


    if(this.className == 'btn btn-info resend_email_receipt') {
        if(email_id == '') {
            alert('Please enter email address to re-send receipt.');
            return false;
        }

        if(email_id != '') {
            var pattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$/i;
            if(!pattern.test(email_id)) {
                alert('Please provide a valid email');
                return false;
            }
        }
        // $('.resend_email_receipt').prop("disabled", true);

        var data = {
            'rowid'             : rcpt_row_id,
            'type'              : 'all_request',
            'email_id'          : email_id
        };
        // console.log(this);return false;
        $('.resend_email_receipt').html('<span class="fa fa-spinner fa-spin" style="width: 35px;"></span>');
        // return false;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_receipt_instore_on_email'); ?>',   //  re_receipt_pos
            data: data,
            success: function (data){
                if(data==200) {
                    // console.log('done');
                    $('.resend_email_receipt').html('<span class="fa fa-check" style="width:35px;"></span>');
                    // $('.resend_email_receipt').html('<span class="text-success">Sent</span>');
                    
                    // $(this).html('Sent');
                    // alert('Receipt sent successfully.');
                    // $('.resend_rcpt_btn_confirm').html('<span class="fa fa-check status_success"></span> Re-Send Success');
                }
                if(data==500) {
                    alert('Something went wrong.');
                }
            }
        });
    }    
    
})
</script>

<?php include_once'footer_dash_list.php'; ?>