<?php
    include_once'header_rec_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<link rel="stylesheet" href="<?php echo base_url('new_assets/css/recurring.css'); ?>">

<style>
    .card-inner-sketch {
        background: url("<?= base_url('new_assets/img/credit_card_bg.jpg') ?>");
        box-shadow: 0px -1px 25px 0px rgba(16, 57, 107, 0.63);
    }
    #card_close {
        border-radius: 50% !important;
    }
    .card-inner-sketch .c__val.card__no span:not(:last-child) {
        padding-right: 11px !important;
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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Transactions</h4> -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <span onclick="history.back(-1)" class="float-buttons float-left goback-button"><span class="material-icons"> arrow_back</span> Go Back</span>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right" style="margin-top: 8px !important;">
                    <span class="text-uppercase name__invoice"><?php if(count($mem) > 0 ) echo $mem[0]['name'].' </span><small class="pos_Status_c"> ('.$mem[0]['invoice_no'].')</small>'; ?></span>
                </div>
            </div>
 
            <?php if(count($mem) > 0  && 3 > 4 ) {  //  Condition False Here  ?>
                <form class="row" method="post" action="<?php  $inv=$mem[0]['invoice_no']?$mem[0]['invoice_no']:$invoice_no; echo base_url('pos/invoice_details/'.$inv);?>" style="margin-bottom: 20px !important;">
                    <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;">
                        <div id="transaction_recurring_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;width: auto !important;">
                            <span>
                                <?php echo ((isset($curr_payment_date) && !empty($curr_payment_date))?(date("F-d-Y", strtotime($curr_payment_date)) .' - '.date("F-d-Y", strtotime($end))):('<label class="placeholder">Select date range</label>')) ?>
                            </span>
                            <input name="invoice_no" type="hidden" value="<?php if($mem[0]['invoice_no']){ echo $mem[0]['invoice_no']; }else{ echo $invoice_no; }    ?> "  />
                            <input  name="curr_payment_date" type="hidden" value="<?php echo (isset($curr_payment_date) && !empty($curr_payment_date))? $curr_payment_date : '';?>">
                            <input  name="end" type="hidden" value="<?php echo (isset($end) && !empty($end))? $end : '';?>">
                        </div>
                    </div>
                    
                    <div class="table_custom_status_selector">
                        <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <option value="">Select Status</option>
                            <?php if(!empty($status) && isset($status)) { ?>
                                <option value="confirm" <?php echo (($status == 'confirm')?'selected':"") ?>>Complete</option>
                                <option value="pending" <?php echo (($status == 'pending')?'selected':"") ?>>Good Standing</option>
                                <option value="late" <?php echo (($status == 'late')?'selected':"") ?>>Late</option>
                            <?php } else { ?>
                                <option value="confirm" >Complete</option>
                                <option value="pending" >Good Standing</option>
                                <option value="late" >Late</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search" style="width: 126px !important;"><i class="mdi mdi-magnify medium"></i>Submit</button>
                    </div>
                </form>
                <hr>
            <?php } ?>
            
            <div class="row">
                <div class="col-12">
                    <table id="transaction_recurring_dt" class="hover row-border pos-list-dtable" style="width:100%">
                        
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th width="20%">Card Info</th>
                                <th width="15%">Receipt</th>
                                <th width="9%">Amount</th>
                                <th width="8%">Status</th>
                                <th width="15%">Payment Date</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($mem as $a_data) {
                                $count++;
                                //print_r($a_data); 
                                if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago') {
                                    $time_Zone=$this->session->userdata('time_zone');
                                    date_default_timezone_set('America/Chicago');
                                    $datetime = new DateTime($a_data['payment_date']);
                                    $la_time = new DateTimeZone($time_Zone);
                                    $datetime->setTimezone($la_time);
                                    $a_data['payment_date']=$datetime->format('Y-m-d H:i:s');
                                }
                                if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago') {
                                    $prev_ConversionDate=$a_data['recurring_pay_start_date'];
                                    $time_Zone=$this->session->userdata('time_zone');
                                    date_default_timezone_set('America/Chicago');
                                    $datetime = new DateTime($a_data['recurring_pay_start_date']);
                                    $la_time = new DateTimeZone($time_Zone);
                                    $datetime->setTimezone($la_time);
                                    $a_data['recurring_pay_start_date']=$datetime->format('Y-m-d H:i:s');
                                } ?>
                                <tr>
                                    <td><?php echo $a_data['transaction_id'] ?></td>
                                    <td>
                                        <span class="card-type-no-wraper">
                                            <?php echo !empty($a_data['card_no'])?('****'.substr($a_data['card_no'], -4)): 'xxxxxxxx'; ?>
                                            <span class="card-type-image">
                                                <?php $typeOfCard=strtolower($a_data['card_type']);
                                                switch ($typeOfCard) {
                                                    case 'discover':
                                                        $card_image = 'discover.png';
                                                        break;
                                                    case 'Discover':
                                                        $card_image = 'discover.png';
                                                        break;
                                                    case 'mastercard':
                                                        $card_image = 'mastercard.png';
                                                        break;
                                                    case 'Mastercard':
                                                        $card_image = 'mastercard.png';
                                                        break;
                                                    case 'mc':
                                                        $card_image = 'mastercard.png';
                                                        break;
                                                    case 'visa':
                                                        $card_image = 'visa.png';
                                                        break;
                                                    case 'jcb':
                                                        $card_image = 'jcb.png';
                                                        break;
                                                    case 'maestro':
                                                        $card_image = 'maestro.png';
                                                        break;
                                                    case 'dci':
                                                        $card_image = 'dci.png';
                                                        break;
                                                    case 'amex':
                                                        $card_image = 'amx.png';
                                                        break;
                                                    default:
                                                        !empty($a_data['card_no'])?($card_image = 'other.png') : ($card_image = 'nocard.png');
                                                } ?>
                                                <img src="<?=base_url()?>new_assets/img/<?php echo $card_image; ?>" alt="<?php echo $a_data['card_type'] ?>" style="max-width: 45px;border-radius: 5px;margin-right: 5px;">
                                            </span>
                                        </span>
                                    </td>
                                    <td><?php echo $a_data['email_id'] ?></td>
                                    <td>
                                        <?php $amount = $a_data['amount'] - $a_data['late_fee']; ?>
                                        <span class="status_success">$<?= number_format($amount,2); ?></span>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <?php $th=$a_data['payment_date']  ? date("d M  Y", strtotime($a_data['payment_date']) ): date("d M  Y", strtotime($a_data['recurring_pay_start_date']));
                                                     
                                            if($a_data['status']=='confirm' || $status=='confirm') { 
                                                echo '<span class="badge badge-success">Completed</span>'; 
                                            } elseif ($a_data['status']=='Chargeback_Confirm') {
                                                echo '<span class="badge badge-secondary">Refund</span>';
                                            } elseif($a_data['status'] == 'pending'){
                                                echo '<span class="badge badge-warning">Pending</span>';

                                            } elseif($a_data['status'] == 'declined'){ ?>
                                                </a>
                                                <div class="dropdown dt-vw-del-dpdwn">
                                                    <span class="badge badge-danger">Declined</span>
                                                    <button type="button" data-toggle="dropdown">
                                                        <i class="material-icons"> more_vert </i>
                                                    </button>
                                                    <!-- check point -->
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item pos_vw_refund" data-id="<?php echo $a_data['id']; ?>" href="<?php echo base_url('SendRecurring/rerunCard/'.$a_data['invoice_no'].'/'.$a_data['id']); ?>"><span class="fa fa-credit-card"></span>  Re-run card</a>
                                                        <!-- <a class="dropdown-item pos_vw_refund" href="<?php echo base_url('SendRecurring/customer_recurring/#AddCard'.$a_data['payment_id']);  ?>"><span class="fa fa-credit-card"></span> Update card by customer</a> -->
                                                        <a class="dropdown-item pos_vw_refund" href="#"><span class="fa fa-credit-card"></span> Update card by customer</a>
                                                        <a class="dropdown-item pos_vw_refund" href="#AddCard" id="updateMerchant" data-id="<?php echo base_url('AcceptCard/updateCardByMerchant/'.$a_data['invoice_no'].'/'.$a_data['id']); ?> " data-toggle="modal" data-target="#"><span class="fa fa-credit-card"></span> Update card by merchant</a>
                                                        <!-- <a class="dropdown-item pos_vw_refund" href="#"><span class="fa fa-credit-card"></span> Update card by merchant</a> -->
                                                    </div>
                                                </div> 

                                            <?php } else {
                                                echo '<span class="badge badge-danger">Late</span>';
                                            } ?>
                                        </a>
                                    </td>
                                    <td><?php if($a_data['status']=='confirm' ||  $a_data['status']=='Chargeback_Confirm'  )  { echo date("d M  Y", strtotime($a_data['payment_date'])); } else{echo date("d M  Y", strtotime($a_data['recurring_pay_start_date'])); } ?></td>
                                    <td>
                                        <?php if($a_data['status']=='confirm' || $status=='confirm' || $a_data['status']=='Chargeback_Confirm') { ?>
                                            <span class="transaction_recur_vw_btn pos_Status_c badge-btn" style="cursor:pointer; "
                                            data-id="<?php echo $a_data['id'];  ?>"><span class="fa fa-eye" style="padding: 4px;"></span>  Receipt</span>
                                        <?php } elseif($a_data['status']!='confirm' && $status!='confirm' && $a_data['recurring_pay_start_date']!=$prev_ConversionDate ) { ?> 
                                            <button type="submit" id="resend-invoice" name="submit" onclick="resendinvoice(this,<?php echo $a_data['id']; ?> )" class="pos_Status_c badge-btn" style="border: none !important;">Re-Send Invoice</button>  
                                         <?php } ?> 
                                    </td>
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

<div id="transRecur-modal" class="modal fade">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h4 class="modal-title">
                    <i class="glyphicon glyphicon-user"></i> Payment Detail
                </h4> 
            </div> 
            <div class="modal-body"> 
                <div id="modal-loader" class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
                </div>                          
                <div id="dynamic-content">
                    <!-- <div class="form-group">
                        <label >Invoice No:</label>
                        <p class="form-control-static">POS_20190523070517</p>
                    </div> -->
                </div>
            </div> 
        </div> 
    </div>
</div>
<!-- new start -->
<div id="loader-content" style="display: none;">
    <div id="modal-loader" class="text-center"  style="padding: 15px">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
    </div>
</div>
<div id="invoice-detail-modal" class="invRecptMdlWrapper modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content" id="invoicePdfData"> 
            <div class="modal-content">      
            </div>
        </div>
    </div>
</div>



<!-- pop up -->
<div class="modal fade" id="AddCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 0px !important;">
    <div class="modal-dialog" role="document" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none !important;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #3A3C3F !important;font-weight: 600 !important;font-family: Nunito-Regular !important;margin-left: 20px;">Add Your Card Details</h5>
                <button id="card_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="loader_wraper_outer ">
                    <div class="loader_wraper_inner">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="323px" height="292px" viewBox="0 0 323 292" enable-background="new 0 0 323 292" xml:space="preserve">
                            <path fill-rule="evenodd" class="l_svg_top" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M80.747,158.409
                                c18.835,0.853,37.741,0.211,56.614,0.082c8.004-0.056,13.297-3.973,13.162-12.278c-0.135-8.346-5.562-11.768-13.601-11.749
                                c-15.202,0.041-30.406-0.188-45.606-0.031c-7.701,0.081-14.22-1.698-19.787-7.56c-11.189-11.781-22.45-23.546-34.388-34.546
                                c-7.45-6.867-6.208-11.52,0.535-17.809c11.878-11.079,23.238-22.729,34.5-34.444c5.105-5.309,10.741-7.328,18.117-7.292
                                c56.625,0.28,113.253,0.403,169.877,0.1c10.038-0.055,14.076,2.889,13.801,13.391c-0.577,21.479-0.095,42.987-0.047,64.485
                                c0.018,8.729,2.484,16.494,12.664,16.276c10.17-0.215,12.102-8.129,12.074-16.805c-0.073-20.973,0.078-41.946,0.033-62.917
                                c-0.057-27.581-11.35-38.993-39.276-39.21c-27.788-0.218-55.58-0.047-83.367-0.058c-28.314-0.013-56.628,0.045-84.941-0.037
                                c-12.455-0.037-24.02,2.299-33.213,11.47c-13.732,13.698-27.48,27.385-41.05,41.248C9.961,67.755,6.065,76.38,6.974,86.296
                                C8.613,104.161,62.714,157.598,80.747,158.409z"></path>
                            <path fill-rule="evenodd" class="l_svg_bottom" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M317.027,207.701
                                c-1.643-17.862-55.744-71.3-73.775-72.111c-18.836-0.853-37.743-0.211-56.615-0.081c-8.005,0.056-13.296,3.973-13.161,12.278
                                c0.136,8.342,5.562,11.765,13.6,11.744c15.203-0.036,30.406,0.189,45.606,0.032c7.702-0.081,14.22,1.698,19.787,7.563
                                c11.19,11.777,22.448,23.543,34.39,34.547c7.449,6.862,6.206,11.52-0.534,17.804c-11.879,11.082-23.241,22.731-34.504,34.447
                                c-5.102,5.31-10.738,7.329-18.112,7.291c-56.628-0.276-113.257-0.402-169.881-0.098c-10.038,0.054-14.077-2.89-13.8-13.391
                                c0.576-21.479,0.095-42.99,0.047-64.485c-0.019-8.729-2.485-16.494-12.665-16.279c-10.17,0.214-12.102,8.129-12.073,16.804
                                c0.072,20.977-0.079,41.945-0.035,62.922c0.057,27.579,11.35,38.992,39.278,39.208c27.786,0.222,55.579,0.048,83.365,0.058
                                c28.315,0.013,56.63-0.044,84.945,0.037c12.451,0.038,24.018-2.296,33.213-11.469c13.731-13.696,27.479-27.386,41.048-41.247
                                C314.037,226.242,317.933,217.616,317.027,207.701z"></path>
                            <path fill-rule="evenodd" class="l_circle_one" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M78.328,67.273
                                C67.85,67.507,62.187,74.27,62.595,84.598c0.382,9.705,6.231,14.911,16.313,15.168c10.274-1.035,16.378-6.644,15.716-17.188
                                C94.028,73.065,87.913,67.06,78.328,67.273z"></path>
                            <path fill-rule="evenodd" class="l_circle_two" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M245.119,192.908
                                c-10.479,0.233-16.141,6.996-15.733,17.324c0.382,9.705,6.231,14.91,16.313,15.168c10.273-1.034,16.379-6.644,15.717-17.188
                                C260.818,198.7,254.704,192.695,245.119,192.908z"></path>
                        </svg>
                        <p class="loading_txt">Processing </p>
                    </div>
                    <span class="overlay-bg"></span>
                </div>

                <div class="invoice-wrapper">
                   <div class="irm-header-inner">
                        <form class="cardPaymentFormWrapper row" id="updateForm" method="post">
                            <div class="col-12">
                                <div class="row" style="display: block !important;">
                                    <div class="card-placeholder">
                                        <div class="card-inner-sketch">
                                            <div class="col-12" style="margin-top: 15px;">
                                                <div class="row" style="margin: 0px;display: block !important;">
                                                    <div class="mycl-wrapper responsive-cols flex-row">
                                                        <div class="col-6" style="padding: 0px !important;">
                                                            <div class="chip-logo">
                                                                <img src="<?php echo base_url('new_assets/img/chip.png') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-right" style="padding: 0px !important;">
                                                            <div class="card-type-logo" style="display: inline-flex !important;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin: 0px;">
                                                    <p class="c__val card__no"><span>****</span><span>****</span><span>****</span><span>----</span></p>
                                                </div>

                                                <div class="mycl-wrapper row" style="margin: 0 !important;">
                                                    <div class="col-6" style="padding: 0 !important;max-width: 40px !important;margin-bottom: 10px;">
                                                        <p style="line-height: 10px !important;color: #fff !important;font-size: 10px !important;">VALID</p>
                                                        <p style="line-height: 10px !important;color: #fff !important;font-size: 10px !important;">THRU</p>
                                                    </div>
                                                    <div class="col-6" style="padding: 0 !important;">
                                                        <div class="flex-col">
                                                            <p class="c__val" style="margin-bottom: 5px !important;margin-top: 0px !important;"><span>--</span><span>/</span><span>--</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner-boxes">
                                            <div class="card-box  new-card-box" data-cardno="----" data-mm="--" data-yy="--" data-src="https://salequick.com/new_assets/img/cardtypelogo.png" data-chn="-" style="text-align: -webkit-center !important;">
                                                <input type="radio" value="newcard" name="card_selection_radio" <?php  if(count($token_data) <= '0') { echo  "checked";  } ?> >
                                            </div>
                                        <style>
                                            .card-inner-boxes .card-box .card__no {
                                                width: 210px;
                                                padding: 7px;
                                                text-align: right;
                                            }
                                            .card-inner-boxes .card-box .remove_card_btn_wrapper {
                                                width: 40px;
                                            }
                                            .get_card_box {
                                                margin-bottom: 10px !important;
                                                border: 1px solid rgb(210, 223, 245);
                                                border-radius: 5px;
                                            }
                                            .get_card_box:hover {
                                                    -webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                                    -moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                                    box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                            }
                                            .inner_get_card_box {
                                                padding: 0px !important;
                                                height: 50px !important;
                                                text-align: right !important;
                                            }
                                            .saved_card_head_wrapper {
                                                position: relative;
                                                width: 320px;
                                                margin: auto;
                                            }
                                            .all_get_saved_cards {
                                                width: 320px;
                                                margin: auto;
                                            }
                                        </style>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 card-form">
                                        <div class="pay-detail" style="display: inline-block;width: 100%;margin-top: 25px;">
                                            <h3 class="form-title card_form_title">Payment Details</h3>
                                            <input type="hidden" value="<?php print_r($getEmail1); ?>"/>
                                            <input type="hidden" id="amount" name="amount" value="<?php echo $amount ?>">
                                            
                                            <div class="form-group">
                                                <label for="card__cnumber" class="movbale">Card Number</label>
                                                <div class="input-group" style="height: 35px !important;">
                                                    <input id="card__cnumber" name="card_no" class="form-control required CardNumber" type="text" minlength="14">
                                                    <div class="input-group-addon" style="border: none !important;background-color: #fff !important;padding: 0px 5px !important;">
                                                        <span class="input-group-text card_type">
                                                            <img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="card__nameoncard" class="movbale">Card Holder Name</label>
                                                <input id="card__nameoncard"  name="name_card" class="form-control required" type="text">
                                            </div>
                                            
                                            <div class="mycl-wrapper responsive-cols flex-row row" style="margin: 0 -15px !important;">
                                                <div class="col-4" style="padding-left: 8px !important;">
                                                    <div class="form-group fg-half">
                                                        <?php
                                                        $currYr=date('Y');
                                                        $LastYr=$currYr + 20;
                                                        $yeardata=array();
                                                        for ($i=$currYr; $i < $LastYr; $i++) { 
                                                            array_push($yeardata,substr($i, 2,2));
                                                        }
                                                        ?>
                                                        <label for="card__validutil" class="movbale">Expire Date</label>
                                                        <input autocomplete="off"  id="card__validutil"  data-yr='<?php echo json_encode($yeardata);?>' name="exp" placeholder="MM/YY" class="form-control required ddmm" type="text"  maxlength="5">
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-left: 8px !important;">
                                                    <div class="form-group fg-half">
                                                        <label for="card__cvv" class="movbale">CVV</label>
                                                        <input id="card__cvv" class="form-control required cvv" type="text"  name="card_validation_num" maxlength="4">
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-left: 8px !important;padding-right: 8px !important;">
                                                    <div class="form-group">
                                                        <div class="form-group fg-half">
                                                            <label for="card__zip" class="movbale">Zip Code</label>
                                                            <input id="card__zip" name="zip" class="form-control zip required" type="text" maxlength="10" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-first d-colors" style="border-radius: 8px !important;margin: 15px 0px !important;width: 100%;">Complete Payment</button>
                                    </div>
                                    <style>
                                        #myModal .modal-header {
                                            border-bottom: none !important;
                                        }
                                        p.modal-title {
                                            font-size: 14px;
                                            font-family: Nunito-Regular;
                                            line-height: 20px;
                                        }
                                        p.ttlamt {
                                            font-size: 26px;
                                            font-family: Avenir-Black;
                                            color: #0088ff;
                                            margin: 0px !important;
                                        }
                                        hr.hr_custom {
                                            margin: 0px;
                                            border-top: 1px solid #e5e5e5;
                                        }
                                        p.signature_text {
                                            color: rgb(105, 105, 105);
                                            font-family: Nunito-Regular;
                                            font-size: 16px;
                                        }
                                        p.terms_policy {
                                            color: rgb(148, 148, 146) !important;
                                            font-size: 12px !important;
                                            font-family: Nunito-Regular;
                                        }
                                        @media screen and (max-width: 700px) {
                                            p.modal-title {
                                                font-size: 12px;
                                            }
                                            p.ttlamt {
                                                font-size: 22px;
                                            }
                                            p.signature_text {
                                                font-size: 14px;
                                            }
                                            p.terms_policy {
                                                font-size: 10px !important;
                                            }
                                        }
                                    </style>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>new_assets/js/cp_script_rec.js"></script>
<script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>

<script>
    new Cleave('#card__cnumber', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            //console.log(type)
            if(type == 'amex') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'visa') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'diners') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'mastercard') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'jcb') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'discover') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else {
                //console.log('else');
                var card_img = '<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">';
                // var card_img2 = '<img src="https://salequick.com/new_assets/img/cardtypelogo.png" style="width: 48px;height: 30px;">';
                var card_img2 = '';
            }
            // console.log(card_img)
            // console.log(card_img2);
            document.querySelector('.card_type').innerHTML = card_img;
            document.querySelector('.card-type-logo').innerHTML = card_img2;
        }
    });

    $(document)
    .on('keydown blur','.card-form .required',function(){
        $('.card-form .form-group').removeClass('incorrect');
    })
    $('.d-colors').on('click', function (e) {
        
      var validation=true;
      $('.card-form .required').each(function(){
        $this=$(this);
          if(!$this.val().length){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('CardNumber') && $this.val().length < 14){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('ddmm') && $this.val().length < 5){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('cvv') && $this.val().length < 3){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('zip') && $this.val().length < 4){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          if(!validation)
          return validation;
      })
      return validation;
        
    })

    function validateFormm() {
        var x = document.forms["myFormm"]["s_amount"].value;
        
        if (x == "0.00") {
            alert("Amount Must Be Grater Than Zero");
            return false;

        } else if (x == "0") {
            alert("Amount Must Be Grater Than Zero");
            return false;

        } else if (x == "") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        }
    }

    $(document).on('click', '#btn_login', function() {
        if($('#money').val() > 0) {
            var s_email = $('#s_email').val();
            var s_phone = $('#s_phone').val();

            if( (s_email == '') && (s_phone == '') ) {
                alert('Enter either Email Address or Mobile Number.');
                return false;
            }
            $('#s_invoice_loader').removeClass('d-none');
        }
    })

    if($('#s_invoiceDueDatePicker').length){
        $("#s_invoiceDueDatePicker").val(moment().add(2,'Days').format("YYYY-MM-DD"));
        $('#s_invoiceDueDatePicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {format: "YYYY-MM-DD"}
        },
        function(start, end, label) {
        });
    }

    
</script>




<!-- new end -->
<style type="text/css">
    #invoice-detail-modal .modal-dialog {
        max-width: 800px;
        padding: 0 15px;
    }
    .sweet-alert .btn {
        padding: 5px 15px;
        min-width: 100px;
    }
    .modal.show.blur-mdl {
        overflow: hidden;
        filter: blur(1px);
        opacity: 0.8;
    }
    body.p_recept #invoice-detail-modal .modal-dialog.modal-lg{
        max-width: 900px;
    }
    body.p_recept > .modal .modal-footer,body.p_recept > .modal .close{
        display: none;
    }
    @media only screen and (max-width: 851px){
        .modal .modal-dialog .close {
            right: -8px;
        }
    }
    @media only screen and (max-width: 767px){
        #invoice-detail-modal .modal-footer {

        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo  base_url(); ?>new_assets/css/sweetalert.css">
<script src="<?php echo  base_url(); ?>new_assets/js/sweetalert.js"></script>

<script>
    function makePDF() {
        $('body').addClass('p_recept');
        // window.scroll({ top: 0, left: 0 });
        var winW=$(window).width();
        $('#invoice-detail-modal').scrollTop(0);
        var quotes = document.getElementById('invoicePdfData');
        html2canvas(quotes, {
            onrendered: function(canvas) {

                //! MAKE YOUR PDF
                var pdf = new jsPDF('p', 'pt', 'a4');

                for (var i = 0; i <= quotes.clientHeight/980; i++) {
                        //! This is all just html2canvas stuff
                    var srcImg  = canvas;
                    var sX      = 0;
                    var sY      = 980*i ; // start 980 pixels down for every new page
                    var sWidth  = 900 ;
                    var sHeight = 980;
                    var dX      = 0;
                    var dY      = 0 ;
                    var dWidth  = 900;
                    var dHeight = 980;

                    window.onePageCanvas = document.createElement("canvas");
                    onePageCanvas.setAttribute('width', 900);
                    onePageCanvas.setAttribute('height', 980);
                    var ctx = onePageCanvas.getContext('2d');
                    // details on this usage of this function:
                    // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
                    ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

                    // document.body.appendChild(canvas);
                    var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

                    var width         = onePageCanvas.width;
                    var height        = onePageCanvas.clientHeight;

                    //! If we're on anything other than the first page,
                    // add another page
                    if (i > 0) {
                            pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
                    }
                    //! now we declare that we're working on that page
                    pdf.setPage(i+1);
                    //! now we add content to that page!
                    pdf.addImage(canvasDataURL, 'PNG', 15, 15, (width*.62), (height*.62));

                }
                //! after the for loop is finished running, we save the pdf.
                pdf.save('receipt.pdf');
                $('body').removeClass('p_recept');
            }
        });
    }
</script>
<script>
    $(document).on('click', '#updateMerchant', function() {
            var address = $(this).attr('data-id');
            $('#updateForm').attr('action', address);

        })
    
    function refundingConfirm(amount,type) {
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
        closeOnCancel: true},function(isConfirm) {
            if(isConfirm){$('#invoice-detail-modal').removeClass('blur-mdl');
            ///call here 

        } else{
            $('#invoice-detail-modal').removeClass('blur-mdl');}
        })
    }

    $(document)
        .on('click','.transaction_recur_vw_btn', function (e) {
            // stop - start
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#invoice-detail-modal').modal('show');
            $('#invoice-detail-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
            $.ajax({
                url: "<?php  echo base_url('merchant/search_invoice_detail_receipt'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: 'html'
            })
        .done(function(data){
            // console.log(data);
            $('#invoice-detail-modal .modal-content').html(data); // load response 
        })
        .fail(function(){
            $('#invoice-detail-modal .modal-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
        });
    })
    .on('click','#receiptSSendRequest',function(){
        if($('#allpos_partref').is(':checked') && $('.partRefund__amount').val()) {
            var refType='Partial Refund :';
            $('#invoice-detail-modal').addClass('blur-mdl');
            refundingConfirm($('.partRefund__amount').val(),refType);
        } else if($('#allpos_fulref').is(':checked') && $('.fullRefund__amount').val()) {
            var refType='Full Refund :';
            $('#invoice-detail-modal').addClass('blur-mdl');
            refundingConfirm($('.fullRefund__amount').val(),refType)
            // $('#receiptSSendRequest-modal .sure_refund').val($('#amount.refund__amount').val());
            // $('#receiptSSendRequest-modal').modal('show');
        }
        // $('#invoice-detail-modal').addClass('blur-mdl');
        // $('#receiptSSendRequest-modal .sure_refund').val($('#invoice-detail-modal .srpttlAmt').text());
        // $('#receiptSSendRequest-modal').modal('show');
    })
    .on("hide.bs.modal",'#receiptSSendRequest-modal', function () {
        // put your default event here
        $('#invoice-detail-modal').removeClass('blur-mdl');
        setTimeout(function(){
            if($('.modal.show').length > 0)
            {
                    $('body').addClass('modal-open');
            }
        },100)
    })
    .on("click",'#receiptSSendRequestYes,.receiptSSendRequestYes', function () {
        // put your default event here
        $('#amount').val($('input.sure_refund').val());
        $('#invoice-detail-modal #receiptSSendRequest').attr('type','submit').trigger('click');
    })
    .on("click",'#receiptSSendRequestNo,.receiptSSendRequestNo', function () {
            // put your default event here
        $('#invoice-detail-modal').removeClass('blur-mdl');
        // $('#receiptSSendRequest-modal').modal('hide');
    })
    .on('click','#receiptSSendRequestPrint',function(){
        $('body').addClass('p_recept');
        window.print();
        $('body').removeClass('p_recept');
    })
    .on('keydown',function(e){
        if(e.ctrlKey && e.keyCode == 80) {
            if($('#invoice-detail-modal').hasClass('show') && ($('.modal.show').length == 1)) {
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
    function resendinvoice(el,rowid) {
        $this=$(el);
        $this.html('<span class="fa fa-spinner fa-spin"></span> Re-Sending Invoice');
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>merchant/re_invoice',
            data: {'rowid':rowid },
            beforeSend:function(data){$("#resend-invoice").attr("disabled",true);},
            success: function (data){
                if(data=='200') {
                    $this.html('<span class="fa fa-check status_success"></span> Re-Sent Invoice!');
                    setTimeout(function(){$("#resend-invoice").removeAttr("disabled");$this.html('Re-Send Invoice')},2000);
                }
            }
        });
    }
</script>


<?php include_once'footer_rec_dash.php'; ?>