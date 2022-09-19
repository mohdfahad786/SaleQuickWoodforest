<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
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
	<style type="text/css">
		#dynamic-content table.table>thead>tr>th {
		background: #f1f1f1;
		border: 1px solid #f1f1f1;
		}
		#dynamic-content table.table>tbody>tr>td {
		background-color: #ffffff;
		border-bottom-color: #f1f1f1;
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
						<span>View All Straight Payment Request</span>
					</div>
				</div>
			</div>
			<div class="row sales_date_range">
				<div class="col-12 custom-form">
					<div class="card content-card">
						<form class="row" method="post" action="<?php echo base_url('dashboard/all_customer_request'); ?>">
							<div class="col">
								<div id="daterangeFilter" class="form-control">
										<!-- <span><?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?></span>
										<input name="start_date" type="hidden">
										<input name="end_date" type="hidden"> -->
										<span><?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
										</span>
										<input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
										<input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >

								</div>
							</div>
							<div class="col">
								<select class="form-control" name="status" id="status" required="">
									<option value="">Select Status</option>
									<option value="pending" <?php if( isset($status) && $status=='pending'){ echo 'selected';} ?> >Pending</option>
									<option value="confirm" <?php if( isset($status) && $status=='confirm') { echo 'selected'; } ?> >Confirm</option>
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
								if (isset($msg)) {
									echo $msg;
								}
							?>
							<div class="pos-list-dtable reset-dataTable">
								<table id="datatable" class="display" style="width:100%">
									<thead>
										<tr>
											 <th>Generated on </th> 
											<th>Transaction id</th>
											<th>Card Type</th>
											<th>Merchant </th>
											<th>Phone</th>
											<th>Amount</th>
											<th>Status</th>
											<th>Due Date</th>
											<th>Payment Date</th>
											<th class="no-event"></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i = 1;
											foreach ($mem as $a_data) {
											$count++;

											$typeOfCard=strtolower($a_data['card_type']); 
											switch($typeOfCard)
											{
												case 'discover':
												$card_image='discover.png';
												break;
												case 'mastercard':
												$card_image='mastercard.png';
												break;
												case 'visa':
												$card_image='visa.png';
												break;
												case 'jcb':
												$card_image='jcb.png';
												break;
												case 'maestro':
												$card_image='maestro.png';
												break;
												case 'dci':
												$card_image = 'dci.png';
												break;
												case 'amex':
												$card_image='amx.png';
												break;
												default :
												$card_image='other.png';
											}

										?>
										<tr>
												<td> <?php echo date("M d Y", strtotime($a_data['date_c'])); ?></td>
											 <td> <?php echo $a_data['transaction_id'] ?></td>
											<td> <span class="card-type-image" ><img src="<?php echo base_url(); ?>new_assets/img/<?php echo $card_image; ?> " alt="<?php echo $card_type; ?> "  ></span></td>
											<td>
												<?php
													$data = $this->admin_model->data_get_where_1('merchant', array('id' => $a_data['merchant_id']));
													foreach ($data as $view) {
													echo $view['business_dba_name'];?>
													<?php
													}
												?>
											</td>
											<td> <?php echo htmlspecialchars($a_data['mobile'],ENT_QUOTES) ?></td>
											<td><span class="status_success" > $<?php echo number_format($a_data['amount'], 2); ?> </span> </td>
											<td>
												<?php
												if ($a_data['status'] == 'pending') {
												$current_date = date("Y-m-d");
												$due_date = $a_data['due_date'];
												if ($current_date > $due_date) {
												echo '<span class=" badge badge-danger"> Late  </span>';
												} else {
												echo '<span class="badge badge-warning"> ' . ucfirst($a_data['status']) . '  </span>';
												}
												} elseif ($a_data['status'] == 'confirm' || $a_data['status'] == 'Chargeback_Confirm') {
												echo '<span class="badge badge-success"> Confirm </span>';
												} elseif ($a_data['status'] == 'declined') {
												echo '<span class="badge badge-danger"> ' . $a_data['status'] . ' </span>';
												} elseif ($a_data['status'] == 'Refund') {
												echo '<span class="badge badge-secondary"> Refunded </span>';
												}
												?>
											</td>
											<td> <?php echo date("M d Y", strtotime($a_data['due_date'])); ?></td>
											<td> <?php if ($a_data['status'] != 'pending') {echo date("M d Y", strtotime($a_data['date_c']));}?>
											</td>
											<td>
											 <div class="dropdown dt-vw-del-dpdwn"> 
													<button type="button" data-toggle="dropdown" aria-expanded="false"> 
														<i class="material-icons"> more_vert 
														</i> 
													</button> 
													<div class="dropdown-menu dropdown-menu-right" >
														<?php
															if ($a_data['status'] == 'pending') {
															echo '<a href="'.base_url().'payment/' . $a_data['mpayment_id'] . '/' . $a_data['merchant_id'] . '" target="_blank" class="dropdown-item">
																<i class="fa fa-eye"></i> Invoice
															</a>';
															} elseif ($a_data['status'] == 'declined') {
															echo '<a href="'.base_url().'payment/' . $a_data['mpayment_id'] . '/' . $a_data['merchant_id'] . '" target="_blank" class="dropdown-item">
															<i class="fa fa-eye"></i> Invoice
															</a>';
															} elseif ($a_data['status'] == 'confirm') {
															echo '<a href="'.base_url().'reciept/' . $a_data['mpayment_id'] . '/' . $a_data['merchant_id'] . '" target="_blank" class="dropdown-item">
															<i class="fa fa-eye"></i> Receipt
															</a>';
															} elseif ($a_data['status'] == 'Chargeback_Confirm') {
															echo '<a href="'.base_url().'reciept/' . $a_data['mpayment_id'] . '/' . $a_data['merchant_id'] . '" target="_blank" class="dropdown-item">
															<i class="fa fa-eye"></i> Receipt
															</a>';
															}
															elseif ($a_data['status'] == 'Refund') {   //
															echo '<a href="'.base_url().'refund_reciept/' . $a_data['mpayment_id'] . '/' . $a_data['merchant_id'] .'/'. $a_data['payment_id'] .'" target="_blank" class="dropdown-item">
															<i class="fa fa-eye"></i> Receipt
															</a>';
															}
														?>
														<a data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id']; ?>"  class="dropdown-item getUser" href="#">
															<i class="fa fa-eye">
															</i> Detail
														</a>
													</div> 
												</div>
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
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">
				<i class="glyphicon glyphicon-user"></i> Payment Detail
			</h4>
		</div>
		<div class="modal-body">
			<div id="modal-loader" class="text-center" style="display: none;">
				<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
			</div>
			<div id="dynamic-content"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>

<script>
	var resizefunc = [];
</script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
var dtTransactionsConfig={
	"processing": true,
	"pagingType": "full_numbers",
	"pageLength": 25,
	"dom": 'lBfrtip',
	responsive: true,
//   "ordering": false,
columnDefs: [ { type: 'date', 'targets': [0] } ],
	"order": [],
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
	]
}
$('#datatable').DataTable(dtTransactionsConfig);
});
$(document).ready(function(){
	$(document).on('click', '.getUser', function(e){
		e.preventDefault();
		var uid = $(this).data('id');   // it will get id of clicked row
		$('#dynamic-content').html(''); // leave it blank before ajax call
		$('#modal-loader').show();      // load ajax loader
		$.ajax({
		 url: "<?php echo base_url('dashboard/search_record_column1'); ?>",
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
 $(document).on('click', '#getUserrecurring', function(e){
		e.preventDefault();
		var uid = $(this).data('id');   // it will get id of clicked row
		$('#dynamic-content').html(''); // leave it blank before ajax call
		$('#modal-loader').show();      // load ajax loader
		$.ajax({
		 url: "<?php echo base_url('merchant/search_record_column_recurring'); ?>",
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