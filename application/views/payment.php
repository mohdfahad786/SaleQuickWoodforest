<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>:: Invoice ::</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<?php 
	 	function color_inverse($color){
			$color = str_replace('#', '', $color);
			if (strlen($color) != 6){ return '000000'; } 
			$rgb = '';
			for ($x=0;$x<3;$x++){
					$c = 255 - hexdec(substr($color,(2*$x),2));
					$c = ($c < 0) ? 0 : dechex($c);
					$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
			}
			return '#'.$rgb;
		}
		$late_grace_period = $itemm[0]['late_grace_period'];
		if($payment_type == 'recurring') {
 			$payment_date = date('Y-m-d', strtotime($recurring_pay_start_date. ' + '.$late_grace_period.' days'));
		} else {
			$payment_date = date('Y-m-d', strtotime($due_date. ' + '.$late_grace_period.' days'));
		}
		$late_fee_status = $itemm[0]['late_fee_status'] ? $itemm[0]['late_fee_status'] : 0;
	 	$late_fee = $itemm[0]['late_fee'] ? $itemm[0]['late_fee'] : '';
		$colordata=$itemm[0]['color']?$itemm[0]['color']:'#fff';
		$color2=color_inverse($colordata);
	?>
	<style>
		:after, :before {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		:after, :before {
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
		}
		* {
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
		}
		.svgAlertWraper {
			position: relative;
			width: 150px; 
		}
		.svgAlertWraper .green-stroke {
			stroke: #7CB342; 
		}
		.svgAlertWraper .red-stroke {
			stroke: #FF6245; 
		}
		.svgAlertWraper .yellow-stroke {
			stroke: #FFC107; 
		}
		.svgAlertWraper .saw-circle circle.path {
			stroke-dasharray: 330;
			stroke-dashoffset: 0;
			stroke-linecap: round;
			opacity: 0.4;
			-webkit-animation: 0.7s draw-circle ease-out;
			animation: 0.7s draw-circle ease-out;
			/*------- sacCheck ---------*/ 
		}
		.svgAlertWraper .sacCheck {
			stroke-width: 6.25;
			stroke-linecap: round;
			position: absolute;
			top: 56px;
			left: 49px;
			width: 52px;
			height: 40px; }
			.svgAlertWraper .sacCheck path {
				-webkit-animation: 1s draw-check ease-out;
				animation: 1s draw-check ease-out;
				/*---------- sawCross ----------*/ }
		.svgAlertWraper .sawCross {
			stroke-width: 6.25;
			stroke-linecap: round;
			position: absolute;
			top: 54px;
			left: 54px;
			width: 40px;
			height: 40px; }
			.svgAlertWraper .sawCross .first-line {
				-webkit-animation: 0.7s draw-first-line ease-out;
				animation: 0.7s draw-first-line ease-out; }
			.svgAlertWraper .sawCross .second-line {
				-webkit-animation: 0.7s draw-second-line ease-out;
				animation: 0.7s draw-second-line ease-out; }
		.svgAlertWraper .sawSign {
			stroke-width: 6.25;
			stroke-linecap: round;
			position: absolute;
			top: 40px;
			left: 68px;
			width: 15px;
			height: 70px;
			-webkit-animation: 0.5s sawSign-bounce cubic-bezier(0.175, 0.885, 0.32, 1.275);
			animation: 0.5s sawSign-bounce cubic-bezier(0.175, 0.885, 0.32, 1.275); }
			.svgAlertWraper .sawSign .dot {
				fill: #FFC107; stroke: none;}

		@-webkit-keyframes sawSign-bounce {
			0% {
				-webkit-transform: scale(0);
				transform: scale(0);
				opacity: 0; 
			}
			50% {
				-webkit-transform: scale(0);
				transform: scale(0);
				opacity: 1; 
			}
			100% {
				-webkit-transform: scale(1);
				transform: scale(1); 
			} 
		}

		@keyframes sawSign-bounce {
			0% {
				-webkit-transform: scale(0);
				transform: scale(0);
				opacity: 0; }
			50% {
				-webkit-transform: scale(0);
				transform: scale(0);
				opacity: 1; }
			100% {
				-webkit-transform: scale(1);
				transform: scale(1); } 
		}

		@-webkit-keyframes draw-circle {
			0% {
				stroke-dasharray: 0,330;
				stroke-dashoffset: 0;
				opacity: 1; }
			80% {
				stroke-dasharray: 330,330;
				stroke-dashoffset: 0;
				opacity: 1; }
			100% {
				opacity: 0.4; } 
		}

		@keyframes draw-circle {
			0% {
				stroke-dasharray: 0,330;
				stroke-dashoffset: 0;
				opacity: 1; }
			80% {
				stroke-dasharray: 330,330;
				stroke-dashoffset: 0;
				opacity: 1; }
			100% {
				opacity: 0.4; } 
			}

		@-webkit-keyframes draw-check {
			0% {
				stroke-dasharray: 49,80;
				stroke-dashoffset: 48;
				opacity: 0; }
			50% {
				stroke-dasharray: 49,80;
				stroke-dashoffset: 48;
				opacity: 1; }
			100% {
				stroke-dasharray: 130,80;
				stroke-dashoffset: 48; } }

		@keyframes draw-check {
			0% {
				stroke-dasharray: 49,80;
				stroke-dashoffset: 48;
				opacity: 0; }
			50% {
				stroke-dasharray: 49,80;
				stroke-dashoffset: 48;
				opacity: 1; }
			100% {
				stroke-dasharray: 130,80;
				stroke-dashoffset: 48; } }

		@-webkit-keyframes draw-first-line {
			0% {
				stroke-dasharray: 0,56;
				stroke-dashoffset: 0; }
			50% {
				stroke-dasharray: 0,56;
				stroke-dashoffset: 0; }
			100% {
				stroke-dasharray: 56,330;
				stroke-dashoffset: 0; } }

		@keyframes draw-first-line {
			0% {
				stroke-dasharray: 0,56;
				stroke-dashoffset: 0; }
			50% {
				stroke-dasharray: 0,56;
				stroke-dashoffset: 0; }
			100% {
				stroke-dasharray: 56,330;
				stroke-dashoffset: 0; } }

		@-webkit-keyframes draw-second-line {
			0% {
				stroke-dasharray: 0,55;
				stroke-dashoffset: 1; }
			50% {
				stroke-dasharray: 0,55;
				stroke-dashoffset: 1; }
			100% {
				stroke-dasharray: 55,0;
				stroke-dashoffset: 70; } }

		@keyframes draw-second-line {
			0% {
				stroke-dasharray: 0,55;
				stroke-dashoffset: 1; }
			50% {
				stroke-dasharray: 0,55;
				stroke-dashoffset: 1; }
			100% {
				stroke-dasharray: 55,0;
				stroke-dashoffset: 70; } }
		body {
			background-color: #fff;
				font-family: 'Open Sans', sans-serif;
				width: 100%;
				height: 100%;
		}
		td,
		th {
				vertical-align: top;
				text-align: left;
		}
		p {
				font-size: 13px;
				color: #878787;
				line-height: 30px;
				margin: 4px 0px;
		}
		.custom-btn{
			background-color: #<?=$itemm[0]['color'];?> !important;
			border: 1px solid <?=$color2;?>;
			border-radius: 4px;
			text-transform: uppercase;
			padding: 10px 30px;
			font-size: 13px;
			text-decoration: none;
			float: right;
			color: <?=$color2;?>;
			-webkit-transition: all 0.3s ease 0s;
			-o-transition: all 0.3s ease 0s;
			transition: all 0.3s ease 0s;
			-webkit-appearance: button;
			-moz-appearance: button;
			-ms-appearance: button;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			-ms-border-radius: 4px;
		}
		.custom-btn:hover,.custom-btn:focus {
			outline: none;
			background-color: <?=$color2;?> !important;
			border-color: #<?=$itemm[0]['color'];?>;
			color: #<?=$itemm[0]['color'];?>;
		}
		.invoice-wrap {
			display: block;
			border-radius: 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			max-width: 972px;
			width: 100%;
			background-color: #fff;
			-webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
			-moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
			box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);
			margin: 30px auto 0;
		}
		.invoice-wrap::after,.invoice-wrap::before{
			content: '';
			display: table;
			clear: both;
		}
		.main-box {
			background-image: -webkit-linear-gradient( #<?=$itemm[0]['color'];?>,#<?=$itemm[0]['color'];?>);
			background-image: -moz-linear-gradient( #<?=$itemm[0]['color'];?>,#<?=$itemm[0]['color'];?>);
			background-image: linear-gradient( #<?=$itemm[0]['color'];?>,#<?=$itemm[0]['color'];?>);
			background-size: 100% 201px;
			background-position: top center;
			background-repeat: no-repeat;
			width: 100%;
			height: 100%;
			padding: 0 15px;
			float: left;
			max-width: 100%;
			clear: both;
		}
		.privacy-txt {
			color: #666;
		}
		.privacy-txt:hover,.privacy-txt:focus {
			color: #4a90e2;
		}
		@media screen and (max-width: 768px) {
			.footer_address > span:first {
					display: inline-block;
					width: 100%;
			}
			.footer_address {
				text-align: center !important;
			}
		}
		.top-div {
			border-radius: 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			background: #fafafa;
			display: inline-block;
			width: 100%;
			float: left;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			padding: 20px 40px;
		}
		.twenty-div table {
			border-collapse: collapse;
			border: 0px;
		}
		.float-left {
			float: left;
			text-align: left
		}
		.float-right {
			float: right;
			text-align: right
		}
		.bottom-div {
			display: inline-block;
			float: left;
			padding: 20px 40px;
			width: 100%;
			box-sizing: border-box
		}
		.sixty-div {
			width: 60%;
			float: left;
			display: inline-block;
		}
		.fourty-div {
			width: 40%;
			float: right;
			display: inline-block;
		}
		.left-div {
			width: 50%;
			display: inline-block;
			float: left;
			font-size: 14px;
			color: #353535
		}
		.right-div {
			width: 50%;
			display: inline-block;
			float: left;
			text-align: right;
			font-size: 14px;
			color: #353535;
			font-weight: 600;
		}
		.items-list-table th,.items-list-table td{
			font-size: 13px;
			border: 0px;
			padding: 7px;

		}
		.onlyMessageSection .alert {
			font-size: 21px;
			margin-bottom: 7px;
		}
		.items-list-table thead th{
			color: #7e8899;
			text-transform: uppercase;
			font-weight: 500;

		}
		.alert.alert-danger,.text-danger{
			color: #FF6245;
		}
		.items-list-table tbody{
			color: #000;
			border-top: 1px solid #eaeaea;  
			max-width: 100%;
			width: 100%;
		}
		.items-list-table tfoot{
			border-top: 1px solid #eaeaea;  
			max-width: 100%;
		}
		.items-list-table tfoot td{
			text-align: right;
		}
		.items-list-table tfoot span{
			display: inline-block;
			vertical-align: top;
			padding: 0 7px;
			min-width: 100px;
			text-align: left;
			font-weight: 700;
		}
		.footer-wraper{
			float: left;
			width: 100%;
			clear: both;
			color: #666;
			max-width: 100%;
		}
		.footer-wraper>div{
			max-width: 1000px;
			padding: 0;
			text-align: center;
			font-size: 14px;
			width: 100%;
			clear: both;
			margin: 51px auto 11px;
			display: block;
		}
		.footer_cards a{
			display: inline-block;
			vertical-align: top;
			margin-left: 7px;
		}
		.footer-wraper>div::after,.footer-wraper>div::before,.footer-wraper::after,.footer-wraper:before{
			display: table;
			clear: both;
			content: "";
		}
		.footer_address{
			padding-left: 15px;
		}
		.footer_cards{
			padding-right: 15px;
		}
		.footer-wraper>div>div{
			margin-bottom: 11px;
		}
		.footer_address span:first-child{
			font-weight: 600;
		}
		.alert.alert-success,.text-success{
			color: #7CB342;
			text-transform: capitalize;
		}
		.onlyMessageSection{
			padding: 21px 0;
			clear: both;
			width: 100%;
			text-align: center;
			min-height: 201px;
			font-weight: 600;
		}
		.svgAlertWraper{
			margin: 0 auto;
		}
		.onlyMessageSection span.text-success,.onlyMessageSection span.text-danger {
			font-size: 21px;
			font-weight: 600;
			display: block;
			margin-bottom: 21px;
		}
		.items-list-table-overflow{
			overflow: auto;
		}
		span.amtttl {
			padding: 3px 21px;
			background-color: whitesmoke;
			border: 1px solid #e0e0e0;
			font-size: 25px;
			color: #7cb342;
			font-weight: 400;
			display: inline-block;
			vertical-align: top;
			min-width: 160px;
		}
		@media only screen and (max-width:820px){
			.footer-wraper>div>div{
				float: none !important;
			}
			.footer_address,.footer_cards{
				padding-right: 0px !important;
				padding-left: 0px !important;
			}
			.footer_t_c{
				padding-bottom: 7px;
			}
			.footer-wraper>div{
				margin: 51px auto 0;
			}
		}
		@media only screen and (min-width:769px) and (max-width:900px) {
			.sixty-div {
					width: 40%;
			}
			.fourty-div {
					width: 60%;
			}
		}
		@media only screen and (min-width:481px) and (max-width:768px) {
			.sixty-div {
				width: 40%;
			}
			.fourty-div {
				width: 60%;
			}
			.bottom-div {
				padding: 20px 20px;
			}
			.top-div {
				padding: 20px 20px;
			}
		}
		@media only screen and (max-width:400px) {
			.twenty-div {
			 	word-wrap: break-word;
		 	}
		}
		@media only screen and (max-width:375px) {
			.twenty-div {
		 		word-wrap: anywhere;
 			}
		}
		@media only screen and (max-width:480px) {
			.float-right {
				text-align: center;
				width: 100%;
			}
			.float-left {
				text-align: center;
				width: 100%;
			}
			.fourty-div {
				width: 100%;
				float: right;
			}
			.sixty-div {
				width: 100%;
				text-align: center;
			}
			.bottom-div {
				padding: 20px 20px;
			}
			.top-div {
				padding: 20px 20px;
			}
		}
		@media screen and (max-width: 600px) {
			.onlyMessageSection{
				min-height: 101px
			}
		}

	</style>
	<body style="margin:0 auto;padding: 0;">
		<div class="main-box">
			<div class="invoice-wrap">
				<div class="top-div">
					<?php if($resend!='') { ?>
					<div class="float-left">
						<div style="color:red;"><?php echo validation_errors(); ?></div>
						<p>
							<img src="<?php echo base_url(); ?>logo/<?php echo $itemm[0]['logo']; ?>" style="height: auto;max-width: 121px;max-height: 90px;width: auto;" />
						</p>
					 	<h4 style="margin-bottom: 0px;color:#000; "><?= $itemm[0]['business_dba_name'] ?> </h4>
						<p style="color: #878787; margin-top: 0px;">Telephone:<?= $itemm[0]['business_number'] ?></p>
					</div>
					<div class="float-right">
						<h3 style="text-transform: uppercase;margin-bottom: 0;">Invoice</h3>
						<p style="line-height: 20px;margin-top: 10px">
						<span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						<span style="display: block;"><?php echo $invoice_no ;?></span></p>
						<p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
							<span style="display: block;"><?php $originalDate = $date_c;
							echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span></p>
					</div>
				</div>
				<div class="bottom-div twenty-div">
					<div class="items-list-table-overflow">
						<table width="100%" border="1" class="items-list-table">
							<thead>
								<tr>
									<th >Item name</th>
									<th >Qty</th>
									 <th >Price </th>
									<th >Tax</th>
									<th >Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($item as $rowp) { 
							 		$item_name =  str_replace(array('\\', '/'), '', $rowp['item_name']);
							 		$quantity =  str_replace(array('\\', '/'), '', $rowp['quantity']);
							 		$price =  str_replace(array('\\', '/'), '', $rowp['price']);
							 		$tax =  str_replace(array('\\', '/'), '', $rowp['tax']);
							 		$tax_id =  str_replace(array('\\', '/'), '', $rowp['tax_id']);
							 		$total_amount =  str_replace(array('\\', '/'), '', $rowp['total_amount']);
							 		$item_name1 = json_decode($item_name);
								 	$quantity1 = json_decode($quantity);
								 	$price1 = json_decode($price);
								 	$tax1 = json_decode($tax);
								 	$tax_id1 = json_decode($tax_id);
								 	$total_amount1 = json_decode($total_amount);
								 	$i = 0; 
								 	foreach ($item_name1 as $rowpp) {
									 	if($quantity1[$i] > 0 && ucfirst($item_name1[$i])!='Labor'){ ?>
										 	<tr>
												<td ><?php echo $item_name1[$i] ;?></td>
												<td><?php echo $quantity1[$i] ;?></td>
												<td>$ <?php echo number_format(floatval($price1[$i]),2) ;?></td>
												<td>
													<?php
														$tax_a = $total_amount1[$i] - ($price1[$i]*$quantity1[$i]);
														if( $price1[$i]*$quantity1[$i] >= $total_amount1[$i] ){
														 	echo '$0.00';
													 	} else {
															echo  '$'.number_format($tax_a,2)  ;
														}
													?>
												</td>
												<td >$<?php   echo $number = number_format($total_amount1[$i],2) ;?></td>
											</tr>
											<?php
										} 
										$i++; 
									} 
									$j = 0; 
									$data = array();
									$data1 = array();
									foreach ($item_name1 as $rowpp) {
									 	if($quantity1[$j] > 0 && ucfirst($item_name1[$j])=='Labor'){
											$data[] =  $price1[$j];
											$data1[] =  $quantity1[$j];
											
										?>
										<?php
										} 
										$j++; 
									} 
									$Array1 = $data;
									$Array2 = $data1;
									$Array3 = [];
									foreach ($Array1 as $index => $key) {
										if (! array_key_exists($key, $Array3)) {
												$Array3[$key] = 0;
										}
										$Array3[$key] += $Array2[$index];
									}
									foreach ($Array3 as $index => $person) { ?>
										<tr>
											<td >Labor</td>
											<td><?php echo $person ;?></td>
											<td>$<?php echo number_format($index,2) ;?></td>
											<td>$0.00</td>
											<td >$<?php echo number_format($index*$person,2) ;?></td>
										</tr>
										<?php 
									}
								} 
								?>
							</tbody>
							<tfoot>
								<tr>
									<?php if($late_fee_status > 0 && date('Y-m-d') > $payment_date) { 
										$amount = $late_fee + $amount;
									?>
										<td  align="right" colspan="5" >
											<span  style="text-transform: uppercase;color:#7e8899;border:0px! important;">Late Fee</span>
											<span  style="color: #0077e2;border:0px;">$<?php echo number_format($late_fee,2)  ;?></span>
										</td>
									<?php } ?>
								</tr>
								<tr class="total-row">
									<td  align="right" colspan="5" >
										<span  style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</span>
										<span  style="color: #0077e2;border:0px;">$<?php echo number_format($amount,2)  ;?></span>
									</td>
								</tr>
								<!-- <tr>
									<td style="border-bottom: 0px !important;"></td>
									<td style="border-bottom: 0px !important;"></td>
									<td style="border-bottom: 0px !important;">
										<p style="text-transform: uppercase;color:#7e8899;border:0px! important;text-align: left;">Total</p>
									</td>
									<td style="border-bottom: 0px !important;"></td>
									<td style="border-bottom: 0px !important;">
										<p style="color: #0077e2;border:0px;text-align: left;">$<?php echo number_format($amount,2)  ;?></p>
									</td>
								</tr> -->
								<!-- <tr class="total-row">
									<td  align="right" colspan="5" >
											<span  style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</span>
											<span  style="color: #0077e2;border:0px;">$<?php echo number_format($amount,2)  ;?></span>
									</td>
								</tr> -->
							</tfoot>
						</table>
					</div>
					<div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
					 	<form action="<?php echo base_url('card_payment');?>" method="post">
							<input type="hidden" class="form-control" name="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" readonly required>
							<input type="hidden" class="form-control" name="bct_id1" value="<?php echo (isset($bct_id1) && !empty($bct_id1)) ? $bct_id1 : set_value('bct_id1');?>" readonly required>
							<input type="hidden" class="form-control" name="bct_id2"  value="<?php echo (isset($bct_id2) && !empty($bct_id2)) ? $bct_id2 : set_value('bct_id2');?>" readonly required>
							<input type="hidden" class="form-control" name="mobile" readonly pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>
							<input type="hidden" class="form-control" name="email" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" readonly pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required>
							<input type="hidden" class="form-control" name="late_fee" value="<?= ($late_fee_status > 0 && date('Y-m-d') > $payment_date) ? $late_fee : 0 ?>" readonly  required>
							<input type="hidden" class="form-control" name="amount" value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>" readonly  required>
							<input type="submit" name="submit" class="custom-btn" value="CONTINUE TO PAYMENT">
						</form>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div class="onlyMessageSection">
				<?php if($Tstatus == 'success') { ?>
					<div class="svgAlertWraper">
						<svg class="saw-circle green-stroke">
								<circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/>
						</svg>
						<svg class="sacCheck green-stroke">
								<g transform="matrix(0.79961,8.65821e-32,8.39584e-32,0.79961,-489.57,-205.679)">
										<path class="sacCheck__check" fill="none" d="M616.306,283.025L634.087,300.805L673.361,261.53"/>
								</g>
						</svg>
					</div>
				<?php echo $this->session->flashdata('pmsg'); echo '<span class="amtttl"> $ '.$Tamount.'</span>'; ?>
				<?php }else{ ?>
					<div class="svgAlertWraper">
						<svg class="saw-circle red-stroke">
							<circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/>
						</svg>
						<svg class="sawCross red-stroke">
								<g transform="matrix(0.79961,8.65821e-32,8.39584e-32,0.79961,-502.652,-204.518)">
										<path class="first-line" d="M634.087,300.805L673.361,261.53" fill="none"/>
								</g>
								<g transform="matrix(-1.28587e-16,-0.79961,0.79961,-1.28587e-16,-204.752,543.031)">
										<path class="second-line" d="M634.087,300.805L673.361,261.53"/>
								</g>
						</svg>
					</div>
					<?php echo $this->session->flashdata('pmsg'); ?> 
					<?php } ?>
					</div>
			 <?php } ?>
	 
			<div class="footer-wraper" >
				<div >
					<div class="footer_address" style="float: left; text-align: left;">
						<span style="display: block;color: #404040;font-weight: 600;"><?php if($itemm)  echo $itemm[0]['business_dba_name']   ;?></span>
						<span style="display: inline-block;color:#666"><?php  if($itemm)  echo $itemm[0]['address1']   ;?> </span>
					</div>
					<div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
						<a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/terms_and_condition">Terms </a>& <a class="privacy-txt" style="text-decoration: none;" href="https://salequick.com/privacy_policy">Privacy policy </a> |
							Powered by <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2"> SaleQuick.com </a>
					</div>
					 <div class="footer_cards" style="float: right;">
						<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon1.jpg'); ?>" alt="" class="" /></a>
						<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon2.jpg'); ?>" alt="" class="" /></a>
						<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon3.jpg'); ?>" alt="" class="" /></a>
						<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon4.jpg'); ?>" alt="" class="" /></a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>