<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">
		<link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
		<title>Admin | Dashboard</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
		<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
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
					<div class="col-12">
						<div class="back-title m-title"> 
							<span>View All Customer Recurring  Payment Request</span>
						</div>
					</div>
				</div>
				<div class="row sales_date_range">
					<div class="col-12 custom-form">
						<div class="card content-card">
							<form class="row" method="post" action="<?php echo base_url('dashboard/all_customer_request_recurring');?>">
								<div class="col">
									<div id="daterangeFilter" class="form-control">
											<span><?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?></span>
											<input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>">
											<input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>">
									</div>
								</div>
								<!-- <div class="col">
									<select class="form-control" name="status" id="status">
										<option value="">Select Status</option>
										<option value="pending" <?php  if(isset($status) && $status=="pending") echo 'selected'; ?>>Pending</option>
										<option value="confirm" <?php  if(isset($status) && $status=="confirm") echo 'selected'; ?> >Confirm</option>
									</select>
								</div> -->
								<div class="col">
									<select class="form-control" name="status" id="status">
										<option value="">Select Status</option>
										<option value="confirm" <?php  if(isset($status) && $status=="confirm") echo 'selected'; ?> >Complete</option>
										<option value="pending" <?php  if(isset($status) && $status=="pending") echo 'selected'; ?>>Good Standing</option>
										<option value="late" <?php  if(isset($status) && $status=="late") echo 'selected'; ?>>Late</option>
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
									<table id="datatable" class="display" style="width:100%">
										<thead>
										 	<!-- <tr>
												<th>Invoice</th>
												<th>Name</th>
												<th>Merchant </th>
												<th>Phone</th>
												<th>Title</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Due Date</th>
												<th>Create Date</th>
												<th>Recurring Status</th>
												<th>Action</th>
												<th>View</th>
											</tr> -->
											<tr>
												<th>Name</th>
												<th>Merchant </th>
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
													// echo "<pre>";print_r($mem);die;
												 	$recurring_pay_start_date=$a_data['recurring_pay_start_date']; 
							                        $recurring_type=$a_data['recurring_type'];
							                        $recurring_pay_type=$a_data['recurring_pay_type'];
							                        $payment_type=$a_data['payment_type'];  //   recurring   or  straight 
							                        $recurring_count_remain=$a_data['recurring_count_remain'];
							                        $pay_status=$a_data['status'];
							                        $invoice_id=$a_data['payment_id'];
							                        $recurring_count=$a_data['recurring_count'];
							                        $curentDate=date('Y-m-d');
							                        $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE invoice_no='$invoice_id' AND ( `status`='$pay_status' OR `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
							                        $df=$GetPrevResult->result_array(); 
							                        $is_prev_paid=count($df);
							                        // print_r($df);die;
							                        // Get the First Invoice Start date  
							                        $GetFirstRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  invoice_no='$invoice_id'  ORDER BY id ASC  LIMIT 0,1 "); 
	                        						$DGetFirstRecord=$GetFirstRecord->row_array();

	                        						$merchant_id=$a_data["merchant_id"];
							                        $GetlastRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id'  ORDER BY id DESC  LIMIT 0,1 "); 
							                        $lastRecord=$GetlastRecord->row();
							                        // echo "<pre>";print_r($lastRecord);die;
							                        $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
							                        $DGetAllpaidRecord=$GetAllpaidRecord->result();
							                        $AllPaidRequest=count($DGetAllpaidRecord);

							                        $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
							                        $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
							                        $AllUnPaidRequest=count($DGetAllUnpaidRecord);
													$count++;
											?>
											<tr>
												<td> <?php echo $a_data['name'] ?></td>
												<td>
												 	<?php 
														$data = $this->admin_model->data_get_where_1('merchant', array('id' => $a_data['merchant_id'])); 
														foreach ($data as $view) { 
															echo $view['name']; ?>
													<?php } ?>
												</td>
												<td>
			                          				<?php 
			                          					if($a_data['late_fee']) {
			                          						$amount = $a_data['amount'] - $a_data['late_fee'];
			                          					} else {
			                          						$amount = $a_data['amount'];
			                          					}
			                          				?>
			                            			<span class="status_success">$<?php echo number_format($amount,2); ?></span>
			                          			</td>
												<td>
													<?php
														if( $a_data['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($a_data['recurring_payment']=='stop' || $a_data['recurring_payment']=='complete' )  && $is_prev_paid <='0') { 
						                                  	echo '<span class="status_success">Complete</span>'; //  $recurring_payment = 'complete'; 
						                                } else if( $a_data['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($a_data['recurring_payment']=='stop' || $a_data['recurring_payment']=='complete' ) ) { 
						                                 	//&& $is_prev_paid <='0'
						                                  	echo '<span class="badge badge-success">Complete</span>'; //  $recurring_payment = 'complete'; 
						                                } else if( $AllPaidRequest > 0  &&  $a_data['recurring_count'] != $AllPaidRequest && $AllUnPaidRequest == 0){
					                                      	echo '<span class="badge badge-secondary">Good Standing</span>';  /// $recurring_payment = 'good'; 
						                                }else if($AllUnPaidRequest > '0' &&  $is_prev_paid > '0'){
						                                  	echo '<span class="badge badge-danger">Late</span>';  //$recurring_payment = 'late'; 
						                                } else {
						                                  	echo '<span class="badge badge-warning">Pending</span>';  //$recurring_payment = 'late'; 
						                                }
												 	?>
											 	</td>
											 	<td>
											 		<?php echo date("M d Y", strtotime($DGetFirstRecord['recurring_pay_start_date']));  ?>
										 		</td>
			                          			<td>
			                          				<?php  echo  date("M d Y", strtotime($lastRecord->recurring_next_pay_date)); ?>
		                          				</td>
		                          				<td>
					                          		<?php     
			                          					if($lastRecord->recurring_count < 0 ) { echo '<span style="font-size: 25px; text-align: center; padding: 0 0 0 15px;" >&infin; </span>'; 
			                          				} else {
			                           
					                            		$recurring_count = $recurring_count - 1;
					                            		switch($recurring_type) {
						                              		case 'daily':
							                                	$a=$recurring_count*1; 
								                               	//echo 'count '.$recurring_count; 
								                                $recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." days", strtotime($lastRecord->recurring_next_pay_date)));
						                              		break;

						                              		case 'weekly':
						                                		$a=$recurring_count*7; 
						                                
						                                		$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a."days", strtotime($lastRecord->recurring_next_pay_date)));
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
						                                		$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." days", strtotime($recurring_pay_start_date)));
						                              		break; 
							                            }
							                          	echo date("M d Y", strtotime($recurring_next_pay_date));
			                          				} ?>
			                      				</td>
			                      				<td align="center">
			                          				<?php 
				                            			$recurringCount=(int)($lastRecord->recurring_count); 
				                            			$upcomming= $recurringCount > 0  ? $recurringCount-$AllPaidRequest : '<span style="font-size: 25px;">??? </span>';
				                           				echo '<span class="status_success">'.$AllPaidRequest .'</span><span class="num_seprater">|</span><span class="pos_Status_pend">'.$upcomming.'</span>'; 
			                           				?>
			                          			</td>
			                          			<td>
					                           	 	<?php 
					                               	//   $a_data['recurring_payment']=='complete'  
						                               if( $a_data['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($a_data['recurring_payment']=='stop' || $a_data['recurring_payment']=='complete' )  && $is_prev_paid <='0') { 
						                                 ?>
						                                <a class="btn btn-sm "  onClick="alert('Your All Dues are Clear and Payment complete!')"> <i class="fa fa-check"></i> Done</a>
						                            <?php } else{ ?> 
					                              		<div  class="start_stop_tax  <?php if($a_data['recurring_payment']=='start') { echo 'active'; }?>"
					                                	rel="<?php echo $a_data['id'];?>">
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
					                          	<td>
					                            	<?php  if($a_data['recurring_pay_type'] == '1') echo 'Auto'; else  echo 'Manual'; ?>
					                          	</td>
												<td>
													<div class="dropdown dt-vw-del-dpdwn">
		                                				<button type="button" data-toggle="dropdown">
		                                  					<i class="material-icons"> more_vert </i>
		                                				</button>
		                                				<div class="dropdown-menu dropdown-menu-right">
		                                					<!-- <a id="getUser" class="dropdown-item invoice_pos_list_item_vw_recept" data-id="<?php echo $a_data['id'];  ?>"href="#"><span class="fa fa-eye"></span>  View</a> -->
		                                  					<!-- <a href="#" data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="dropdown-item  pos_Status_c badge-btn"><span class="fa fa-eye"></i> View</a> -->
		                                  					<a class="dropdown-item pos_vw_refund" href="<?php echo base_url('dashboard/invoice_details/'.$a_data['payment_id']); ?>" ><span class="fa fa-exchange"></span>  Transactions</a>
		                                				</div>
		                              				</div>
													<!-- <a href="#" data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> View</a> -->
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
		<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		 <div class="modal-dialog"> 
				<div class="modal-content"> 
						<div class="modal-header"> 
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button> 
								<h4 class="modal-title">
									<i class="glyphicon glyphicon-user"></i> Payment Detail
								</h4> 
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
		<!-- END wrapper -->
		<script>
		var resizefunc = [];
		</script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
		<!-- Popper for Bootstrap -->
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
		<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script>
		<script>
			function stop_pak(id) {
				if(confirm('Are you sure Stop Recurring?')) {
					$.ajax({
						url : "<?php echo base_url('dashboard/stop_recurring')?>/"+id,
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
			function start_pak(id) {
				if(confirm('Are you sure Start Recurring?')) {
					$.ajax({
						url : "<?php echo base_url('dashboard/start_recurring')?>/"+id,
						type: "POST",
						dataType: "JSON",
						success: function(data){
						 	location.reload();
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert('Error deleting data');
						}
					});
				}
			}
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.start_stop_tax,.start_stop_tax input[type="checkbox"]').on('click', function (e) {
			    	// stop - start
				    e.preventDefault();
				    if($(this).closest('.start_stop_tax').hasClass('active')){
				      stop_pak($(this).closest('.start_stop_tax').attr('rel'));
				    } else {
				      start_pak($(this).closest('.start_stop_tax').attr('rel'));
				    }
			  	})
				$('[data-toggle="tooltip"]').tooltip();  
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
				$('#datatable').DataTable(dtTransactionsConfig);
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
				 		url: "<?php  echo base_url('dashboard/search_record_payment'); ?>",
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
			});
		</script>  
	</body>
</html>