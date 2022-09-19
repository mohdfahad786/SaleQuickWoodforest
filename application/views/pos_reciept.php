<!DOCTYPE html>
<html lang="en">

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <title>:: Receipt ::</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
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
		.fourty-div p{
			float: left;
			width: 100%;
			margin-bottom: 7px;
		}
		.fourty-div p span {
			line-height: 1.432;
		}
		/*.top-div::after {
			content: "";
			position: absolute;
			left: 0;
			top: 0;
		   
			background-color: #<?php echo $itemm[0]['color'] ;?>;
			height: 175px;
			width: 100%;
			z-index: -1;
			-webkit-transition: all 0.3s ease 0s;
			-moz-transition: all 0.3s ease 0s;
			transition: all 0.3s ease 0s;
		}*/
		.bottom-div {
			display: inline-block;
			float: left;
			padding: 20px 40px;
			width: 100%;
			box-sizing: border-box
		}

		.sixty-div {
			width: 50%;
			float: left;
			display: inline-block;
			padding-right: 15px;
		}

		.fourty-div {
			width: 50%;
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
			.footer_address {
				text-align: center !important;
			}
			.footer_t_c{
				padding-bottom: 7px;
			}
			.footer-wraper>div{
				margin: 51px auto 0;
			}
		}
		@media screen and (max-width: 768px) {
			.footer_address > span:first {
				display: inline-block;
				width: 100%;
			}
			.main-box{padding: 51px 15px 10px;}
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
			display: table;
			clear: both;
			max-width: 100%;
			margin: 25px auto 15px;
		}
		.sixty-div {
			width: 100%;
			display: table;
			max-width: 100%;
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
							<!-- <p><img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>" width="200px"></p> -->

							<?php 
					 			if ( $itemm[0]['logo'] ) { ?>
					  				<p><img src="<?=base_url();?>logo/<?php  echo $itemm[0]['logo']; ?>" style="height: auto;max-width: 221px;max-height: 85px;width: auto;"></p>
				 			<?php } else { ?>
							 	<div style="display: inline-block; height: 51px; width: 51px; border-radius: 50%; border: 1px solid lightgray; text-transform: uppercase; background-color: white; color: #444; line-height: 51px; text-align: center; font-size: 25px;"><?php    if($itemm[0]['name']) echo ucfirst(substr($itemm[0]['name'],0,1)); ?></div>
				 			<?php } ?>
							<h4 style="margin-bottom: 0px;font-size: 16px;"><?php echo $getEmail1[0]['business_dba_name']; ?></h4>
						
							<p style="margin-top: 0px;"><?php echo $getEmail1[0]['website']; ?></p>
							<p><span style="color:#333;">Telephone:</span> <?php echo $getEmail1[0]['business_number']; ?></p>
						</div>
						<div class="float-right">
							<h3 style="text-transform: uppercase;margin-bottom: 0;font-size: 19px;">Receipt</h3>
							<p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
							<p style="line-height: 20px;margin-top: 10px">
								<span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
								<span style="display: block;"><?php echo $invoice_no ;?></span>
							</p>
							<p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Receipt Date</span>
								<span style="display: block;"><?php $originalDate = $date_c;
									echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span>
							</p>
						</div>
					</div>
					<div class="bottom-div">
						<div class="sixty-div">
							<?php if($transaction_type == 'split') { ?>
							<div class="cc-col" style="width: 100%;float: left;max-width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
	                            <table style="max-width: 100%;width: 100%;font-size: 14px;clear: both;margin: 0 auto;" cellspacing="0">
	                                <thead>
	                                    <tr>
	                                        <td colspan="4" style="font-weight: 600;padding: 15px 0;">Split Payment Details</td>
	                                    </tr>
	                                    <tr>
	                                       <th>Transaction ID</th>
	                                       <th>Amount</th>
	                                       <th>Card Type</th>
	                                       <th>Card NO</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <?php 
	                                        if(!empty($branch)) {
	                                            foreach($branch as $key => $value) {
	                                    ?>
	                                    <tr>
	                                        <td><?= $value->transaction_id ? $value->transaction_id : '-' ?></td>
	                                        <td>$<?= $value->amount ? $value->amount : '0.00' ?></td>
	                                        <td><?= $value->card_type ? $value->card_type : '-' ?></td>
	                                        <td>
	                                            <?php 
	                                                if($value->card_type == 'CHECK') {
	                                                    echo $value->card_no;
	                                                } else if($value->card_type == 'CASH'){
	                                                    echo '-';
	                                                } else {
	                                                    echo '****' .substr($value->card_no, -4);
	                                                }
	                                            ?>
	                                        </td>
	                                    </tr>
	                                <?php }} ?>
	                                </tbody>
	                            </table>
	                        </div>
						<?php } ?>
						</div>
						<div class="fourty-div">
							<!-- <div class="recipt" style="clear: both;width: 100%;"> -->
						  	<?php 	
							  	if(isset($advPos) && count($advPos) > 0){
									$recipt='<table style="max-width: 555px;width: 100%;font-size: 14px;clear: both;border-bottom: 1px solid #ddd;" cellspacing="0"><thead><th>Items</th><th></th></thead><tbody>';
									$i=1;
									$subtotalamt=0;
									foreach($advPos as $pos){
									    if($pos['discount_amount'] > 0){
										
										$recipt=$recipt.'<tr><td style="padding: 5px 1px;">'.$pos['name'].'</td><td style="padding: 5px 1px;text-align: right;font-weight: 600;"> (<del style="color:red">$'.number_format(($pos['price']+$pos['discount_amount']),2).'</del>) &nbsp; $'.number_format($pos['price'],2).'</td></tr>';
									    }
									    else
									    {
$recipt=$recipt.'<tr><td style="padding: 5px 1px;">'.$pos['name'].'</td><td style="padding: 5px 1px;text-align: right;font-weight: 600;">  $'.number_format($pos['price'],2).'</td></tr>';
				        
									    }
										$subtotalamt=$subtotalamt+$pos['price']; 
										$taxa=$pos['tax'];
										$tip=$pos['tip_amount'];
										$i++;
										
									}
									$recipt=$recipt."</table>"; 
									echo $recipt;
							  	}
							?>
									
							<!-- </div> -->
							
							<h4 style="margin: 15px 0 10px;clear: both;width: 100%;font-size: 14px;float: left;">Payment Details</h4>
							
							
								<?php if($getEmail[0]['discount']!='' && $getEmail[0]['discount'] !='0'  && $getEmail[0]['discount'] !='$0.00'   ) { 
							  
							  //$discountAmount=$getEmail[0]['tax']+$getEmail[0]['total_amount']+$getEmail[0]['tip_amount']+$getEmail[0]['other_charges']-$getEmail[0]['amount'];
							  $discountAmount=$getEmail[0]['discount'];
							  ?>
							
							 <p><span class="left-div" style="color: rgb(251, 32, 10);">Total Discount (<? echo $getEmail[0]['discount']; ?>) :</span><span class="right-div" style="color: rgb(251, 32, 10);">-$<?php echo number_format($discountAmount,2); ?></span></p>
							<?php } ?>
							
							<?php 	
							  	if(isset($advPos) && count($advPos) > 0){   ?>
							  	
									<p style="clear: both;width: 100%;float: left;margin: 15px 0 0;line-height: 1;">
										<span class="left-div">Subtotal :</span>
										<span class="right-div"> $<?php echo $subtotalamt ? number_format($subtotalamt,2): number_format($amount,2)  ;?></span>
									</p>
									
							<?php } 
						 	
						else
							{ 
							if($transaction_type == 'split') { ?>
					<p><span class="left-div">Sub Total :</span><span class="right-div">$<?php echo number_format($getEmail[0]['full_amount'] - ($getEmail[0]['tax']+$getEmail[0]['tip_amount']+$getEmail[0]['other_charges']),2);?></span></p>
   <?php } else { ?>
   	<p><span class="left-div">Sub Total :</span><span class="right-div">$<?php echo number_format($getEmail[0]['amount'] - ($getEmail[0]['tax']+$getEmail[0]['tip_amount']+$getEmail[0]['other_charges']),2);?></span></p>
					
						<?php }	}
							?> 
                            
                             
                            	<?php  if( $getEmail[0]['tax'] > 0 ){ ?>
							<p>
								<span class="left-div">Total Taxes :</span>
								<span class="right-div"> $<?php echo number_format($getEmail[0]['tax'],2);?></span>
							</p>
							
							<?php } ?>
							
							<?php if($getEmail[0]['tip_amount'] > 0){?>
							<p>
								<span class="left-div"> Tip Amount :</span>
								<span class="right-div"> $<?php echo number_format($getEmail[0]['tip_amount'],2)  ;?></span>
							</p>
							<?php }?> 
							<?php if($getEmail[0]['other_charges'] > 0){?>
							<p>
								<span class="left-div"><?php echo $getEmail[0]['otherChargesName']; ?> :</span>
								<span class="right-div"> $<?php echo number_format($getEmail[0]['other_charges'],2)  ;?></span>
							</p>
							<?php }?> 
						
							
						

							<p>
								<span class="left-div">Total Amount :</span>
								<span class="right-div"> $<?= ($transaction_type == 'split') ? number_format($full_amount,2) : number_format($amount, 2) ;?></span>
							</p>
							<?php if($transaction_type != 'split') { ?>
								<p>
									<span class="left-div">Transaction ID :</span>
									<span class="right-div"><?php echo $transaction_id; ?></span>
								</p>
								<?php if(!empty($reference)){ ?>
								<p>
									<span class="left-div">Reference :</span>
									<span class="right-div"> <?php    if($reference==""){echo '--'; }elseif($reference =='0' && $reference!=""){echo 'N/A';}else { echo $reference; } ?></span>
								</p>
							   <?php } ?>
								<p>
									<span class="left-div">Card Type :</span>
									<span class="right-div"> <?php if(!empty($card_type)){echo $card_type;} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?></span>
								</p>
								<p>
									<span class="left-div">Last 4 digits on card :</span>
									<span class="right-div"><?php if(!empty($card_no)){echo substr($card_no, -4);;} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
								</p>
							<?php } ?>
							<?php if(!empty($name)){ ?> 
							<p>
								<span class="left-div">Customer Name :</span>
								<span class="right-div"><?php if(!empty($name)){echo ucfirst($name);} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
							</p>
							<?php } ?>
							<p>
								<span class="left-div">Payment Status</span>
								<span class="right-div" style="text-transform: uppercase;color:#4a90e2;margin-top:0;font-size: 14px;font-weight: 600;">APPROVED </span>
							</p>
						</div>
						<div class="sixty-div">
							<h4 style="font-size: 14px;margin-top: 14px;">Invoice To</h4>
							<p style="text-transform: uppercase;color: #333;"><?php echo $name;?></p>
							<?php 
								if(!empty($sign)) {
							?>
						   		<p><img src="<?=base_url();?>logo/<?php echo $sign;  ?>" width="70%"></p>
						   	<?php } else { ?>
						   		<p>--</p>
						   	<?php } ?>
							<!-- <p><img src="https://salequick.com/logo/<?php echo $sign ?>" style="width: auto;height:auto;max-width: 100%;max-height: 198px;"></p> -->
							<div style="width: 100%;float: left;display: inline-block;margin-top: 20px;font-style:italic;line-height: 20px;">
								<!-- <p style="text-transform: uppercase;margin-bottom: 0;line-height: 20px;font-style: italic"> -->
								<small style="float:left;display: inline-block;width:100%;color: #878787;text-transform:uppercase;">* i agree to pay above total amount according to the cardholder agreement (Merchant agreement if credit voucher)</small>
								<!-- </p> -->
								<!-- <p style="text-transform: uppercase;margin-top: 0;line-height: 20px;font-style: italic"> -->
								<small style="color: #878787;text-transform:uppercase;">** important - please retain this copy for your records</small>
								<!-- </p> -->
							</div>
						</div>
						<div class="fourty-div"></div>
						<div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
							<a href="" id="printButton" class="custom-btn" onclick="printDiv('printableArea')" style="margin-left: 5px;">Print</a>
							<!-- <a href="#" style="background-color:#f5f5f5;padding: 10px 30px;font-size: 13px;border-radius:4px;text-decoration:none;float:right;
							color: #666;">Save</a> -->
						</div>
					</div>
				</div>
				<div class="footer-wraper" >
					<div >
						<div class="footer_address" style="float: left;text-align: left;">
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
			<?php } else {  ?> 
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