<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SaleQuick Reciept</title>
        <link href="<?php echo base_url('/new_assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <script src="<?php echo base_url('/new_assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('/new_assets/js/bootstrap.min.js'); ?>"></script>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
        <style>
         	body {
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
        	a{text-decoration:none;}
	        .invoice-wrap {
	            float: left;
	            display: block;
	            border-radius: 4px;
	            -moz-border-radius: 4px;
	            -webkit-border-radius: 4px;
	            margin-left: 14%;
	            width: 72%;
	            background-color: #fff;
	            box-shadow: 0px -2px 17px -2px #7b7b7b;
	            -moz-box-shadow: 0px -2px 17px -2px #7b7b7b;
	            -webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;
	        }
	        .custom-btn
	        {background-color: #0077e2 !important;
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
	        border: 0;}
	        .main-box {
	           background-image:url(https://salequick.com/email/images/backimg.jpg);
	           background-image: linear-gradient(#4990e2 30%, #fff 30%);
	            background-size: cover;
	            width: 100%;
	            height: 100%;
	            background-position: center;
	            background-repeat: no-repeat;
	            padding: 80px 0px 10px 0px;
	            display: inline-block;
	            float: left;
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
	            padding: 20px 20px;
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
	            padding: 20px 0px;
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
	            .invoice-wrap {
	                margin-left: 10%;
	                width: 80%;
	            }

	            .main-box {
	                padding: 50px 0px;
	            }

	            .sixty-div {
	                width: 40%;
	            }

	            .fourty-div {
	                width: 60%;
	            }
	        }

	        @media screen and (max-width: 768px) {
	            .footer_address > span:first {
	                display: inline-block;
	                width: 100%;
	            }
	        }
	        @media only screen and (min-width:481px) and (max-width:768px) {
	            .invoice-wrap {
	                margin-left: 6%;
	                width: 88%;
	            }
	            .main-box {
	                padding: 30px 0px;
	            }
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
	            .invoice-wrap {
	                margin-left: 5%;
	                width: 90%;
	            }
	            .bottom-div {
	                padding: 20px 20px;
	            }
	            .top-div {
	                padding: 20px 20px;
	            }
	        }
	        @font-face {
			    font-family: 'Avenir-Black';
			    /*font-weight: bold;*/
			    font-style: normal;
			    src: url('../new_assets/css/fonts/Avenir-Black.woff') format('woff'),
			         url('../new_assets/css/fonts/Avenir-Black.ttf') format('truetype');
			}
			@font-face {
			    font-family: 'Avenir-Heavy';
			    /*font-weight: bold;*/
			    font-style: normal;
			    src: url('../new_assets/css/fonts/Avenir-Heavy.woff') format('woff'),
			         url('../new_assets/css/fonts/Avenir-Heavy.ttf') format('truetype');
			}
			@font-face {
			    font-family: 'AvenirNext-Medium';
			    /*font-weight: bold;*/
			    font-style: normal;
			    src: url('../new_assets/css/fonts/AvenirNext-Medium.woff') format('woff'),
			         url('../new_assets/css/fonts/AvenirNext-Medium.ttf') format('truetype');
			}
			@font-face {
			    font-family: 'Avenir-Roman';
			    /*font-weight: bold;*/
			    font-style: normal;
			    src: url('../new_assets/css/fonts/Avenir-Roman.woff') format('woff'),
			         url('../new_assets/css/fonts/Avenir-Roman.ttf') format('truetype');
			}
			/*@media screen and (max-width: 640px) {
				.top-div {
	                padding: 20px 20px;
	            }
			}*/
	        .right-grid-main {
	            border-radius: 0px !important;
	            margin-bottom: 0px !important;
	        }
	        .right-grid-body {
	            margin-top: 20px !important;
	        }
	        .grid-chart {
	            margin-top: 40px !important;
	        }
	        .invoice-logo {
	            max-height: 100px;
	            max-width: 300px;
	        }
	        .date-text {
	            color: rgb(148, 148, 146);
	            font-size: 14px;
	            margin-bottom: 0rem !important;
	            /*font-family: AvenirNext-Medium !important;*/
	        }
	        .heading-text {
	            color: rgb(0, 166, 255);
	            font-size: 22px;
	            /*letter-spacing: 5px;*/
	            font-weight: 500 !important;
	            margin-bottom: 0px !important;
	            /*font-family: Avenir-Heavy !important;*/
	        }
	        .invoice-number {
	            font-size: 14px;
	            /*font-family: Avenir-Black !important;*/
	        }
	        .owner-name {
	            font-size: 22px;
	            font-weight: 600;
	            margin-bottom: 0px !important;
	            /*font-family: AvenirNext-Medium !important;*/
	            color: #000;
	        }
	        .mail-phone-text {
	            font-size: 14px;
	            color: rgb(148, 148, 146);
	            font-weight: 400 !important;
	            margin-bottom: 0px !important;
	            /*font-family: AvenirNext-Medium !important;*/
	        }
	        .item-head {
	            font-size: 22px;
	            font-weight: 600;
	            margin-bottom: 0px !important;
	            color: #000 !important;
	            /*font-family: AvenirNext-Medium !important;*/
	        }
	        .item-detail-hr {
	            width: 20% !important;
	        }
	        .item-details-table tbody tr td {
	            font-size: 14px;
	            font-weight: 400 !important;
	            /*font-family: AvenirNext-Medium !important;*/
	        }
	        .item-details-table tbody tr {
	            height: 45px;
	        }
	        .item-table-border {
	            border-bottom: 1px solid rgb(245, 245, 251);
	        }
	        .item-details-table tfoot tr td {
	            font-size: 14px;
	            font-weight: 500 !important;
	            /*font-family: AvenirNext-Medium !important;*/
	        }
	        .item-details-table tfoot tr {
	            height: 45px;
	            border-top: 1px solid lightgray !important;
	        }
	        .payment-details-table tr td {
	            /*height: 30px !important;*/
	            font-size: 13px;
	            font-weight: 400 !important;
	            /*font-family: AvenirNext-Medium !important;*/
	        }
	        .payment-details-table tr td.left {
	            color: rgb(105, 105, 105);
	        }
	        .terms-text {
	            font-weight: 400 !important;
	            font-size: 9px !important;
	            color: rgb(148, 148, 146);
	            /*font-family: AvenirNext-Medium !important;*/
	            line-height: 10px !important;
	        }
	        .signature-size {
	            max-width: 200px;
	            max-height: 80px;
	            margin-bottom: 20px;
	        }
	        .line-b4-head {
	            height: 4px;
	            width: 70px;
	            background-color: #000;
	        }
	        .undergo-head {
	            margin-bottom: 10px;
	        }
	        .pos_Status_c {
	        	text-transform: uppercase;
			    color: #4a90e2;
			    margin-top: 0;
			    font-size: 14px;
			    font-weight: 600;
			    /*font-family: AvenirNext-Medium !important;*/
	        }

	        @media screen and (max-width: 640px) {
            .date-text {
                font-size: 13px;
            }
        }
        @media screen and (max-width: 640px) {
            .heading-text {
                font-size: 24px;
            }
        }
        @media screen and (max-width: 640px) {
            .invoice-number {
                font-size: 13px;
            }
        }
        @media screen and (max-width: 640px) {
            .footer_t_c {
                font-size: 12px !important;
            }
        }
        @media screen and (max-width: 640px) {
            p {
                margin: 0px;
            }
        }
        @media screen and (max-width: 640px) {
            .owner-name {
                font-size: 19px;
            }
        }
        @media screen and (max-width: 640px) {
            .mail-phone-text {
                font-size: 13px;
            }
        }
        @media screen and (max-width: 640px) {
            .item-head {
                font-size: 19px;
            }
        }
        @media screen and (max-width: 640px) {
            .item-details-table thead tr th {
                font-size: 13px !important;
            }
        }
        @media screen and (max-width: 640px) {
            .item-details-table tbody tr td {
                font-size: 13px !important;
            }
        }
        @media screen and (max-width: 640px) {
            .payment-details-table tr td {
                font-size: 12px !important;
            }
        }

	        @media only screen and (max-width: 480px){
		        #templateColumns{
		            width:100% !important;
		        }

		        .templateColumnContainer{
		            display:block !important;
		            width:100% !important;
		        }

		        .columnImage{
		            height:auto !important;
		            max-width:480px !important;
		            width:100% !important;
		        }

		        .leftColumnContent{
		            font-size:16px !important;
		            line-height:125% !important;
		        }

		        .rightColumnContent{
		            font-size:16px !important;
		            line-height:125% !important;
		        }
		    }
        </style>
    </head>

	<body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;">
        <div class="main-box" style="background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;">
            <div class="invoice-wrap" style="float: left;
                display: block; border-radius: 4px;-moz-border-radius: 4px; -webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">
                <div class="top-div" style="border-radius: 4px;background: #fff;display: inline-block;width: 100%;float: left;box-sizing: border-box;padding: 20px 20px;">
                	<table border="0" cellpadding="0" cellspacing="0" id="templateColumns" style="margin: auto;width: 100%;">
					    <tr>
					        <td align="center" valign="top" width="100%" colspan="2" class="templateColumnContainer" style="text-align: center !important;">
					        	<p class="invoice-number" style="text-align: center !important;">Merchant Copy</p>
					        </td>
					    </tr>

					    <tr>
					        <td valign="top" width="50%" class="templateColumnContainer">
					        	<div class="display-avatar" style="padding: 0px !important;">
                                    <img class="invoice-logo" src="<?= base_url().'logo/'.$msgData['getEmail1'][0]['logo'] ?>">
                                </div>
					        </td>

					        <td align="right" valign="top" width="50%" class="templateColumnContainer" style="text-align: right !important;">
					        	<p class="date-text" style="margin-top: 0px !important;"><?php $originalDate = $msgData['date_c'];
                            	echo $newDate = date("F d, Y", strtotime($originalDate)); ?></p>
                                <p class="heading-text" style="margin-top: 0px !important;">RECEIPT</p>
                                <p class="invoice-number" style="margin-top: 0px !important;"><?= $msgData['invoice_no'] ?></p>
					        </td>
					    </tr>

					    <tr>
                            <td valign="top" width="50%" class="templateColumnContainer"></td>
                            <td align="right" valign="top" width="50%" class="templateColumnContainer" style="text-align: right !important;">
                                <?php if($msgData['getEmail1'][0]['business_dba_name']) { ?>
                                    <p class="owner-name" style="margin-top: 0px !important;"><?= $msgData['getEmail1'][0]['business_dba_name'] ?></p>
                                <?php } ?>
                                <p class="mail-phone-text" style="margin-top: 0px !important;"><?= $msgData['getEmail1'][0]['website'] ?></p>
                                <?php if($msgData['getEmail1'][0]['business_number']) { ?>
                                    <p class="mail-phone-text" style="margin-top: 0px !important;    margin-bottom: 20px !important;"><?= $msgData['getEmail1'][0]['business_number'] ?></p>
                                <?php } ?>
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" width="50%" class="templateColumnContainer" style="padding-right: 15px;">
	                            <?php if($msgData['name']) { ?>
	                                <p class="invoice-number"><?php echo $msgData['name']; ?></p>
	                            <?php } ?>
	                            <p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p>
	                            <p class="terms-text" style="text-align: justify !important;margin-bottom: 20px !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>

	                            <span style="font-size: 18px;text-align: right !important;">Payment Status</span><br>
	                            <span class="pos_Status_c" style="text-align: right !important;"><?= $msgData['message_complete'] ?></span>
			                </td>

			                <td align="right" valign="top" width="50%" class="templateColumnContainer" style="text-align: right !important;">
		                        <p class="item-head" style="margin-bottom: 10px !important;">Payment Details</p>
			                    <table class="payment-details-table" style="width: 100%">
			                        <tbody>
			                        <tr>
		                                    <td width="50%" class="left">Total Amount</td>
		                                    <td width="50%" style="text-align: right;">$ <?= number_format($msgData['amount'],2) ?></td>
		                                </tr>
		                                <tr>
		                                    <td width="50%" class="left">Transaction ID</td>
		                                    <td width="50%" style="text-align: right;"><?= $msgData['trans_a_no'] ?></td>
		                                </tr>
		                                <tr>
		                                    <td width="50%" class="left">Reference</td>
		                                    <td width="50%" style="text-align: right;"><?php if($msgData['reference'] =='0'){echo 'N/A';}else {echo $msgData['reference']; } ?></td>
		                                </tr>
		                                <tr>
		                                    <td width="50%" class="left">Card Type</td>
		                                    <td width="50%" style="text-align: right;"><?= !empty($msgData['card_a_type']) ? $msgData['card_a_type'] : ''; ?></td>
		                                </tr>
		                                <tr>
		                                    <td width="50%" class="left">Card Last 4 digits</td>
		                                    <td width="50%" style="text-align: right;"><?php if(!empty($msgData['card_a_no'])){echo substr($msgData['card_a_no'], -4);} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?></td>
		                                </tr>
			                        </tbody>
			                    </table>
			                </td>
			            </tr>

			            <tr>
			            	<td colspan="2" style="text-align: right !important;">
				            	<div class="bottom-div text-right" style="margin-top: 35px;">
					                <div style="width: 100%;display: inline-block;margin-bottom: 30px;">
					                    <a href="#" style="background-color:#0077e2;border-radius:4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration:none;
					                    color: #fff;margin-right: 15px;border-radius: 20px;">Print</a>
					                    <a href="#" style="background-color:#4CCEAC;padding: 10px 30px;font-size: 13px;border-radius:4px;text-decoration:none;
					                    color: #666;border-radius: 20px;">Save</a>
					                </div>
					            </div>
					        </td>
			            </tr>
					</table>
	            </div>

	            
	        </div>
	        <div class="footer-wraper">
	        	<div >
		            <div class="footer_address" style="float: left;">
		                <span style="display: block;font-weight:600;color:#000 "> <?= $msgData['getEmail1'][0]['business_dba_name'] ?> </span>
		                <span style="display: inline-block;color:#666"> <?= $msgData['getEmail1'][0]['address1'] ?> </span>
		            </div>
		            <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;color:#666; ">
		                <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
		                <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
		            </div>
	             	<div class="footer_cards" style="float: right;">
		                <a style="text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" /></a>
		                <a style="text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" /></a>
		                <a style="text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  /></a>
		                <a style="text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  /></a>
		            </div>
	        	</div>
	    	</div>
	    </div>
	</body>
</html>