<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <title>:: Refund Receipt ::</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
 
</head>
<style>
	body {
		font-family: 'Open Sans', sans-serif;
		width: 100%;
		height: 100%;
	}
	::after, ::before, * {
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}

	*, ::after, ::before {
		box-sizing: inherit;
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
	.custom-btn {
		background-color: #0077e2 !important;
		border-radius: 4px;
		text-transform: uppercase;
		padding: 10px 30px;
		font-size: 13px;
		text-decoration: none;
		float: right;
		color: #fff;
		/*-webkit-appearance: button;
		-moz-appearance: button;
		-ms-appearance: button;*/
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		-ms-touch-action: manipulation;
		touch-action: manipulation;
		cursor: pointer;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
		-ms-border-radius: 4px;
		border: 0;
	}
	.invoice-wrap::after, .invoice-wrap::before,.main-box::after,.main-box::before {
		display: table;
		content: "";
		clear: both;
	}
	.receipt_wraper{
		text-align: left;
		float: left;
		width: 100%;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		padding: 20px 40px;
	}
	.receipt-rcol, .receipt-lcol {
		padding: 0;
		max-width: 50%;width: 100%;
		float: left;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	.receipt-rcol{
		padding-left:15px;
	}
	.table-row p{
		float: left;
		width: 100%;
		margin-bottom: 7px;
	}
	.table-row p span {
		line-height: 1.432;
	}
	.table-row{
		max-width: 475px;width: 100%;font-size: 14px;  float: right;
		display: table;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	.table-row::after,.table-row::before{
		content: "";clear: both;display: table;
	}
	.invoice-wrap {
		max-width: 971px;
		display: block;
		clear: both;
		border-radius: 4px;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
		margin: 0 auto;
		width: 100%;
		background-color: #fff;
		box-shadow: 0px -2px 17px -2px #7b7b7b;
		-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;
		-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;
	}
	.main-box {
			-webkit-box-sizing: border-box;
		box-sizing: border-box;
		width: 100%;
		max-width: 100%;
		height: 100%;
		background-position: center;
		background-repeat: no-repeat;
		padding: 80px 15px 10px;
		display: inline-block;
		float: left;
		background-image: -webkit-linear-gradient(#<?php echo $itemm[0]['color'] ;?>,#<?php echo $itemm[0]['color'] ;?>);
		background-image: -moz-linear-gradient(#<?php echo $itemm[0]['color'] ;?>,#<?php echo $itemm[0]['color'] ;?>);
		background-image: linear-gradient(#<?php echo $itemm[0]['color'] ;?>,#<?php echo $itemm[0]['color'] ;?>);
		background-size:  100% 190px;
		background-position: center top;
		background-repeat: no-repeat;
		overflow: hidden;
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
	.footer-wraper{
		float: left;
		width: 100%;
		clear: both;
		max-width: 100%;
	}
	.footer-wraper>div{
		max-width: 1000px;
		padding: 0;
		text-align: center;
		font-size: 14px;
		width: 100%;
		clear: both;
		margin: 91px auto 0;
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
			width: 50%;
		}

		.fourty-div {
			width: 50%;
		}
	}
	@media screen and (max-width: 768px) {
		.footer_address > span:first {
			display: inline-block;
			width: 100%;
		}
		.main-box{padding: 51px 15px 10px;}
	}
	@media only screen and (max-width:651px){
		.receipt-rcol, .receipt-lcol {
			max-width: 100%;width: 100% !important;
		}
		.receipt-rcol{
			padding: 21px 0 0;
		}
		.receipt-rcol>*,.receipt-rcol table{
			float: none !important;
			margin: 0 auto;
			max-width: 100% !important;
		}
		.receipt_wraper{
				padding: 20px 21px;
		}
	}
	@media only screen and (min-width:601px) and (max-width:768px) {
		.bottom-div {
			padding: 20px 20px;
		}

		.top-div {
			padding: 20px 20px;
		}
	}

	@media only screen and (max-width:600px) {
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
		float: none;
		display: block;
		clear: both;
		max-width: 400px;
		margin: 25px auto 15px;
	}
	.sixty-div {
		width: 100%;
		display: block;
		max-width: 400px;
		margin: 0 auto;
		clear: both;
		float: none;
	}
		.bottom-div {
			padding: 20px 20px;
		}

		.top-div {
			padding: 20px 20px;
		}
	}
</style>

<body style="margin:0 auto;padding: 0;">
	<div class="main-box">

	<?php  if(isset($itemm[0] ) ) {  ?>
		<div class="invoice-wrap" id="printableArea">

			<div class="top-div">
				<div class="float-left">
					<?php 
					 if ( $itemm[0]['logo'] ) { ?>
					  <p><img src="<?=base_url();?>logo/<?php  echo $itemm[0]['logo']; ?>"  style="height: auto;max-width: 221px;max-height: 85px;width: auto;"></p>
					 
					 <?php }
					 else
					 {  
						
						 ?>
					 <div style="display: inline-block; height: 51px; width: 51px; border-radius: 50%; border: 1px solid lightgray; text-transform: uppercase; background-color: white; color: #444; line-height: 51px; text-align: center; font-size: 25px;"><?php    if($itemm[0]['name']) echo ucfirst(substr($itemm[0]['name'],0,1)); ?></div>
					 <?php }
				  ?>


						<h4 style="margin-bottom: 0px;"><?php echo $getEmail1[0]['business_dba_name']; ?></h4>
						
						<p style="margin-top: 0px;"><?php echo $getEmail1[0]['website']; ?></p>
						<p><span style="color:#333;">Telephone:</span> <?php echo $getEmail1[0]['business_number']; ?></p>
				</div>
				<div class="float-right">
					<h3 style="text-transform: uppercase;margin-bottom: 0;font-size: 19px;">Refund Receipt</h3>
					<p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
					<p style="line-height: 20px;margin-top: 10px">
						<span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						<span style="display: block;"><?php echo $invoice_no ;?></span></p>
					<p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Refund Date</span>
						<span style="display: block;"><?php //$originalDate = $date_c; 
							$originalDate=$refundData[0]['date_c'];
							echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span></p>
				</div>
			</div>
			<div class="receipt_wraper">
				<div class="receipt-lcol">
					<h4 style="font-size: 14px;margin-top: 7px;">Invoice To</h4>
					<p style="text-transform: uppercase;color: #333;"><?php echo $name  ;?></p>
				   <p><img src="https://salequick.com/logo/<?php echo $sign ?>" style="width: auto;height:auto;max-width: 100%;max-height: 198px;"></p>

					<div style="width: 100%;float: left;display: inline-block;margin-top: 20px;font-style:italic;line-height: 20px;margin-top: 7px;">
						<small style="float:left;display: inline-block;width:100%; !important;color: #878787;text-transform:uppercase;">* i agree to pay above total amount according to the cardholder agreement (Merchant agreement if credit voucher)</small>
						<small style="color: #878787;text-transform:uppercase;">** important - please retain this copy for your records</small>
					</div>
				</div>
			   
				<div class="receipt-rcol">
					  <?php 	
					  if(isset($advPos) && count($advPos) > 0){
						$recipt='<table style="max-width: 555px;width: 100%;font-size: 14px;clear: both;border-bottom: 1px solid #ddd;" cellspacing="0"><thead><th>Items</th><th></th></thead><tbody>';
							$i=1;
							$subtotalamt=0;
							foreach($advPos as $pos){
								
								$recipt=$recipt.'<tr><td style="padding: 5px 1px;">'.$pos['name'].'</td><td style="padding: 5px 1px;text-align: right;font-weight: 600;">$'.number_format($pos['price'],2).'</td></tr>';
					 
								$subtotalamt=$subtotalamt+$pos['price']; 
								$taxa=$pos['tax'];
								$tip=$pos['tip_amount'];
								$i++;
								
							}
							$recipt=$recipt."</table>"; 
							echo $recipt;
					  }
							?>
					<?php 	
					  if(isset($advPos) && count($advPos) > 0){   ?>
					<p style="clear: both;width: 100%;float: left;margin: 15px 0 0;line-height: 1;">
						<span class="left-div">Subtotal :</span>
						<span class="right-div"> $<?php echo $subtotalamt ? number_format($subtotalamt,2): number_format($amount,2)  ;?></span>
					</p>

					  <?php }   if(isset($advPos) && count($advPos) > 0  && $tax > 0 ){   ?>
					<p style="clear: both;width: 100%;float: left;margin: 15px 0 0;line-height: 1;">
						<span class="left-div">Tax : </span>
						<span class="right-div"> $<?php echo number_format($tax,2)  ;?></span>
					</p>
					
					<?php } ?>
					<?php if($itemm[0]['tip']==1){ ?>
					<p style="clear: both;width: 100%;float: left;margin: 15px 0 0;line-height: 1;">
						<span class="left-div">Tip :</span>
						<span class="right-div"> $<?php echo number_format($getEmail[0]['tip_amount'],2)  ;?></span>
					</p>
					<?php }?> 
					
				   <div class="table-row">
						<h4 style="margin: 15px 0 10px;clear: both;width: 100%;float: left;">Payment Details</h4>
						<?php if($getEmail[0]['discount']!='' && $getEmail[0]['discount'] !='0'  ) { 
						 $discountAmount=($getEmail[0]['total_amount']* (int) str_replace('$','',str_replace('%','',$getEmail[0]['discount'])) ) /100; 
						?>
						<p><span class="left-div">Sub Amount :</span><span class="right-div">$<?php echo number_format($getEmail[0]['total_amount'],2);?></span></p>
						<p><span class="left-div">Discount Amount :</span><span class="right-div">$<?php echo number_format($discountAmount,2);?></span></p>
						<?php } ?>

						<p >
						<span class="left-div">Total Amount :</span><span class="right-div">$<?php echo number_format($amount,2);?></span>
						</p>
						<p>
							<span class="left-div">Card Type :</span>
							<span class="right-div"> <?php if(!empty($card_type)){echo $card_type;} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?></span>
						</p>
						<p>
							<span class="left-div">Last 4 digits on card :</span>
							<span class="right-div"><?php if(!empty($card_no)){echo substr($card_no, -4);;} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
						</p>
						<?php if(!empty($name)){ ?> 
						<p>
							<span class="left-div">Customer Name :</span>
							<span class="right-div"><?php if(!empty($name)){echo ucfirst($name);} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
						</p>
						<?php } ?>
					   <p style="margin: 0;padding-top: 11px;">
						   <span style="font-size: 12px;font-weight: 600;color: #000;">Refunds</span>
					   </p>
					   <p>
						<?php   
						  if(isset($refundData) && count($refundData) > 0){
							$recipt='<table style="max-width: 555px;width: 100%;font-size: 14px;clear: both;border-bottom: 1px solid #ddd;" cellspacing="0"><tbody><tr><td style="padding: 7px 0;color:#353535;">Date</td><td style="padding: 7px 0;color:#353535;text-align: center;">Transaction Id</td><td style="padding: 7px 0;color:#353535;text-align: right;">Amount</td></tr>';
								$i=1;
								$subtotalRefundamt=0;
								foreach($refundData as $refu){
									$reAMt=($refu['amount']!="" && $refu['amount'] > 0) ? $refu['amount'] :'0.00'; 
									$recipt=$recipt.'<tr><td style="padding: 7px 0;color:#353535;">'.date("F d, Y", strtotime($refu['date_c'])).'</td><td style="padding: 7px 0;color:#353535;text-align: center;">'.$refu['transaction_id'].'</td><td style="padding: 7px 0;color:#353535;text-align: right;">$'.$reAMt.'</td></tr>';
						 
									$subtotalRefundamt=$subtotalRefundamt+$reAMt; 
								}
								$recipt=$recipt."</tbody></table>"; 
								echo $recipt;
						  }

								?>
						</p>
					   <p style="clear: both;width: 100%;float: left;margin: 15px 0 0;line-height: 1; color: #2273dc !important; ">
						<span class="left-div"><b style="color: #000; ">Total Refund Amount </b></span>
						<span class="right-div">
							<b style="color: #000; ">$ <?php  echo number_format($subtotalRefundamt,2); ?></b> 
							<!-- <b style="color: #000; ">$ <?= number_format($amount,2); ?></b>  -->
						</span>
					   </p>
					</div>
				</div>
				
				<div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
				   
					 <a href="" id="printButton" class="custom-btn" onclick="printDiv('printableArea')" style="margin-left: 5px;">Print</a>
					<!-- <a href="#" style="background-color:#f5f5f5;padding: 10px 30px;font-size: 13px;border-radius:4px;text-decoration:none;float:right;
					color: #666;">Save</a> -->
				</div>
			</div>
		   

				   
		</div>
		<div class="footer-wraper" >
		<div >
			<div class="footer_address" style="float: left;">
				<span style="display: block;"><?php echo $itemm[0]['business_dba_name']   ;?></span>
				<span style="display:inline-block;color:#666"><?php echo $itemm[0]['address1']   ;?> </span>
			</div>
			<div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
				<a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
				<a href="" style="text-decoration: none;color:#0077e2">Powered by SaleQuick.com </a>
			</div>
			 <div class="footer_cards" style="float: right;">
				<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon1.jpg'); ?>" alt="" class="" /></a>
				<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon2.jpg'); ?>" alt="" class="" /></a>
				<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon3.jpg'); ?>" alt="" class="" /></a>
				<a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon4.jpg'); ?>" alt="" class="" /></a>
			</div>
		</div>
	</div>

	<?php } else{  ?> 

<span>Payment Not Found...</span>
<?php  }?>
	</div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script type="text/javascript">
	function printDiv(printableArea) {
		document.getElementById(printableArea).classList.remove("print_button");
		var printContents = document.getElementById(printableArea).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
	var doc = new jsPDF();
	var specialElementHandlers = {
		'#div_button': function (element, renderer) {
			return true;
	  }
	};
	$('#pdf').click(function () {
		doc.fromHTML($('#printableArea').html(), 15, 15, {
			'width': 170,
				'elementHandlers': specialElementHandlers
		});
		doc.save('sample-file.pdf');
	});
	
</script>