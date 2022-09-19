<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    span.card-type-image {
        display: inline-block !important;
        max-width: 51px;
        vertical-align: middle;
        margin-left:3px;
    }
    .card-type-no-wraper{
        display: block;
        width: 121px;
    }
    span.num_seprater {
        padding: 0 5px;
        color: rgba(68, 68, 68, 0.68);
        font-size: 20px;
        display: inline-block;
    }
    .table tbody tr td span, table tbody tr td span {
        display: contents;
    }
    @media screen and (max-width: 640px) {
        #transaction_recurring_daterange span {
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
            width: 105px !important;
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 640px) {
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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">View All Customer Recurring Payment Request</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('pos/all_customer_request_recurring');?>" style="margin-bottom: 20px !important;">
                <!-- <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;"> -->
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="transaction_recurring_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;">
                        <span>
                            <?php echo ((isset($curr_payment_date) && !empty($curr_payment_date))?(date("F-d-Y", strtotime($curr_payment_date)) .' - '.date("F-d-Y", strtotime($end))):('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="curr_payment_date" type="hidden" value="<?php echo (isset($curr_payment_date) && !empty($curr_payment_date))? $curr_payment_date : '';?>">
                        <input name="end" type="hidden" value="<?php echo (isset($end) && !empty($end))? $end : '';?>">
                    </div>
                </div>
                <!-- <div class="col-sm-2 col-md-2 col-lg-2"> -->
                <div class="table_custom_status_selector">
                    <select class="form-control" name="status" id="status" style="border: none !important;">
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
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="transaction_recurring_dt" class="hover row-border salequick-dt" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th width="9%">Amount</th>
                                <th width="8%">Status</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">Next Payment Date</th>
                                <th width="15%">End Date</th>
                                <th width="18%">Completed/Upcomming</th>
                                <th data-priority="1">Recurring</th>
                                <th width="8%">Payment type</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($mem as $a_data) {
                                $recurring_pay_start_date=$a_data['recurring_pay_start_date']; 
                                $recurring_type=$a_data['recurring_type'];
                                $recurring_pay_type=$a_data['recurring_pay_type'];
                                $payment_type=$a_data['payment_type'];  //   recurring   or  straight 
                                $recurring_count_remain=$a_data['recurring_count_remain'];
                                $pay_status=$a_data['status'];
                                $invoice_id=$a_data['payment_id'];
                                $recurring_count=$a_data['recurring_count'];
                             
                                $this->db->where('invoice_no',$invoice_id); 
                                $curentDate=date('Y-m-d');
                                $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE invoice_no='$invoice_id' AND ( `status`='$pay_status' OR `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
                                $df=$GetPrevResult->result_array(); 
                                $is_prev_paid=count($df);      

                                $this->db->where('invoice_no',$invoice_id); 
                                $GetFirstRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  invoice_no='$invoice_id'  ORDER BY id ASC  LIMIT 0,1 "); 
                                $DGetFirstRecord=$GetFirstRecord->row_array();
                                
                                $merchant_id=$a_data["merchant_id"];
                                $GetlastRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id'  ORDER BY id DESC  LIMIT 0,1 "); 
                                $lastRecord=$GetlastRecord->row();

                                $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
                                $DGetAllpaidRecord=$GetAllpaidRecord->result();
                                $AllPaidRequest=count($DGetAllpaidRecord);

                                $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
                                $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
                                $AllUnPaidRequest=count($DGetAllUnpaidRecord);

                                $count++;
                            ?>
                            <tr>
                                    <td><?php echo ucfirst($a_data['name']); ?></td>
                                    <td>
                                        <?php $amount = $a_data['amount'] - $a_data['late_fee']; ?>
                                        <span class="status_success">
                                            $<?= number_format($amount,2); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                            if( $a_data['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($a_data['recurring_payment']=='stop' || $a_data['recurring_payment']=='complete' )  && $is_prev_paid <='0') { 
                                                echo '<span class="status_success">Complete</span>';
                                            } else if( $a_data['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($a_data['recurring_payment']=='stop' || $a_data['recurring_payment']=='complete' ) ) {
                                                echo '<span class="badge badge-success">Complete</span>';
                                            } else if( $AllPaidRequest > 0  &&  $a_data['recurring_count'] != $AllPaidRequest && $AllUnPaidRequest == 0) {
                                                echo '<span class="badge badge-secondary">Good Standing</span>';
                                            } else if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'){
                                                echo '<span class="badge badge-danger">Late</span>';
                                            } else {
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo date("M d Y", strtotime($DGetFirstRecord['recurring_pay_start_date'])); ?></td>
                                    <td><?php  echo  date("M d Y", strtotime($lastRecord->recurring_next_pay_date)); ?></td>
                                    <td>
                                        <?php                                         
                                            if($lastRecord->recurring_count < 0 ) {
                                                echo '<span style="font-size: 25px; text-align: center; padding: 0 0 0 15px;" >&infin; </span>';

                                            } else {
                                                $recurring_count=$recurring_count-1; 
                                                switch($recurring_type) {
                                                    case 'daily':
                                                        $a=$recurring_count*1;
                                                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$a." days", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;

                                                    case 'weekly':
                                                        $a=$recurring_count*7;
                                                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$a."days", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;

                                                    case 'biweekly':
                                                        $a=$recurring_count*14; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime('+'.$a.' days', strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    case 'monthly':
                                                        $a=$recurring_count*1; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime('+'.$a.' month', strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    case 'quarterly':
                                                        $a=$recurring_count*3; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." month", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    case 'yearly':
                                                        $a=$recurring_count*12; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." month", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    default :
                                                        $a=$recurring_count*1; 
                                                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$a." days", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                                                }
                                                echo date("M d Y", strtotime($recurring_next_pay_date));
                                            }
                                        ?>
                                    </td>       
                                    <td align="center">
                                        <?php
                                            $recurringCount=(int)($lastRecord->recurring_count); 
                                            $upcomming=$recurringCount > 0 ? $recurringCount-$AllPaidRequest: '<span style="font-size: 25px;">âˆž </span>';
                                            echo '<span class="status_success">'.$AllPaidRequest .'</span><span class="num_seprater">|</span><span class="pos_Status_pend">'.$upcomming.'</span>';
                                        ?>  
                                    </td>
                                    <td>
                                        <?php
                                        if( $a_data['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($a_data['recurring_payment']=='stop' || $a_data['recurring_payment']=='complete' )  && $is_prev_paid <='0') { ?>
                                            <a class="btn btn-sm "  onClick="alert('Your All Dues are Clear and Payment complete!')"> <i class="fa fa-check"></i> Done</a>
                                        <?php } else { ?> 
                                            <div class="start_stop_tax <?php if($a_data['recurring_payment']=='start') { echo 'active'; }?>" rel="<?php echo $a_data['id'];?>">
                                                <label class="switch switch_type1" role="switch">
                                                    <input type="checkbox" class="switch__toggle" <?php if($a_data['recurring_payment']=='start') { echo 'checked'; } elseif( $a_data['recurring_payment']=='stop'){ echo ''; } ?>>
                                                    <span class="switch__label">|</span>
                                                </label>
                                                <span class="msg">
                                                    <span class="stop">Stop</span>
                                                    <span class="start">Start</span>
                                                </span>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td><?php if($a_data['recurring_pay_type'] == '1') echo 'Auto'; else  echo 'Manual'; ?></td>
                                    <td>
                                        <?php
                                        if($recurring_count_remain =='0') { ?>
                                            <a class="pos_vw_refund pos_Status_c badge-btn" href="<?php echo base_url('pos/invoice_details/'.$a_data['payment_id']); ?>"><span class="fa fa-eye"></span> Transactions</a>
                                        <?php } else { ?>
                                            <div class="dropdown dt-vw-del-dpdwn">
                                                <button type="button" data-toggle="dropdown">
                                                    <i class="material-icons"> more_vert </i>
                                                </button>
                                                <!-- check point -->
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item pos_vw_refund" data-id="<?php echo $a_data['id']; ?>" href="<?php echo base_url('editrecurring/edit_customer_request/'.$a_data['id']); ?>"><span class="fa fa-edit"></span>  Edit</a>
                                                    <a class="dropdown-item pos_vw_refund" href="<?php echo base_url('pos/invoice_details/'.$a_data['payment_id']); ?>"><span class="fa fa-exchange"></span> Transactions</a>
                                                </div>
                                            </div>
                                        <?php } ?>
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

<div id="transRecur-modal" class="modal">
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
<script>
function stop_pak(id)
{

	
	if(confirm('Are you sure Stop Recurring?'))
	{
		$.ajax({
			url : "<?php echo base_url('merchant/stop_recurring')?>/"+id,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				location.reload(); 
				// $('#sidebar-menu ul.sub-menu  a.allCustomerRecur').trigger('click');
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error  data');
			}
		});
	}
}
function start_pak(id)
{
	if(confirm('Are you sure Start Recurring?'))
	{
		$.ajax({
			url : "<?php echo base_url('merchant/start_recurring')?>/"+id,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				location.reload(); 
				// $('#sidebar-menu ul.sub-menu  a.allCustomerRecur').trigger('click');
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error deleting data');
			}
		});
	}
}
// jQuery(function($){
jQuery(document).on('click','.transaction_recur_vw_btn',function(e) {
		console.log('clicked-lined')
		// stop - start
		e.preventDefault();
		var uid = $(this).data('id');   // it will get id of clicked row
		$('#transRecur-modal').modal('show');
		$('#dynamic-content').html(''); // leave it blank before ajax call
		$('#modal-loader').show();      // load ajax loader
		$.ajax({
		 url: "<?php  echo base_url('merchant/search_record_payment'); ?>",
		 type: 'POST',
		 data: 'id='+uid,
		 dataType: 'html'
	 })
		.done(function(data){
			// console.log(data);    
			$('#dynamic-content').html(data); // load response 
			$('#modal-loader').hide();      // hide ajax loader 
		})
		.fail(function(){
			$('#dynamic-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader').hide();
		});
})
// })

jQuery(function($){
	$('.start_stop_tax,.start_stop_tax input[type="checkbox"]').on('click', function (e) {
		// stop - start
		e.preventDefault();
		if($(this).closest('.start_stop_tax').hasClass('active')){
			stop_pak($(this).closest('.start_stop_tax').attr('rel'));
		}
		else{
			start_pak($(this).closest('.start_stop_tax').attr('rel'));
		}
	})
})
</script>

<?php include_once'footer_dash.php'; ?>