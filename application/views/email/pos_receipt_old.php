<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <title>SalesQuick Reciept</title>
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
	            width: 50%;
	            float: left;
	            display: inline-block;
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
	                width: 50%;
	            }
	            .fourty-div {
	                width: 50%;
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
        </style>
    </head>

	 <body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;
        width: 100%;
        height: 100%;">
        <!--<div class="main-box" style="background-image: linear-gradient(#4990e2 30%, #fff 30%);width: 100%;-->
        <!--        height: 100%;display: inline-block;float: left;">-->
            
            <div class="main-box" style="background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;">
            <div class="invoice-wrap" style="float: left;
                display: block; border-radius: 4px;-moz-border-radius: 4px; -webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">
                <div class="top-div" style="border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;float: left;box-sizing: border-box;padding: 20px 40px;">
                    <div class="float-left">
	                    <p><img src="https://salequick.com/logo/<?= $msgData['getEmail1'][0]['logo'] ?>" width="200px"></p>
	                        <!--<h4 style="margin-bottom: 0px;color:#000; "><?= $msgData['getEmail1'][0]['business_dba_name'] ?></h4>-->
	                         <h4 style="margin-bottom: 0px;color:#000; "><?= $msgData['getEmail1'][0]['business_dba_name'] ?></h4>
	                         <p style="margin-top: 0px; color: #878787;"><?= $msgData['getEmail1'][0]['website'] ?></p> 
	                        <p style=" color: #878787;">Telephone:<?= $msgData['getEmail1'][0]['business_number'] ?></p>
	                </div>
	                <div class="float-right">
	                    <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Receipt</h3>
	                    <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
	                    <p style="line-height: 20px;margin-top: 10px">
	                        <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
	                        <span style="display: block; color: #878787;"><?= $msgData['invoice_no'] ?></span></p>
	                    <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
	                        <span style="display: block; color: #878787;"><?php $originalDate = $msgData['date_c'];
                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span></p>
	                </div>
	            </div>
	            <div class="bottom-div">
	                <div class="sixty-div">
	                    <h4 style="color:#000;">Invoice To</h4>
	                    <p style="color: #878787;"><?= $msgData['name'] ?></p>
	                    <!-- <p><img src="https://salequick.com/logo/logo_20190130115126.jpg" width="100px"></p> -->
	                        <h4 style="margin-bottom:0;color:#000; ">Payment Status</h4>
	                        <p style="text-transform: uppercase;color:#4a90e2;margin-top:0;font-size: 14px;font-weight: 600;"><?= $msgData['message_complete'] ?></p>
	                </div>
	                <div class="fourty-div">
	                    <h4 style="color:#000;">Payment Details</h4>
						
	                    <p>
	                        <span class="left-div ">Total Amount :</span>
	                        <span class="right-div"> $<?= $msgData['amount'] ?></span>
	                    </p>
	                    <p>
	                        <span class="left-div">Transaction ID :</span>
	                        <span class="right-div"><?= $msgData['trans_a_no'] ?></span>
	                    </p>
	                    <p>
	                        <span class="left-div">Reference :</span>
	                        <span class="right-div"><?php if($msgData['reference'] =='0'){echo 'N/A';}else {echo $msgData['reference']; } ?></span>
	                    </p>
	                    <p>
	                        <span class="left-div">Card Type :</span>
	                        <span class="right-div"> <?= !empty($msgData['card_a_type']) ? $msgData['card_a_type'] : ''; ?></span>
	                    </p>
	                    <p>
	                        <span class="left-div">Last 4 digits on card :</span>
	                        <span class="right-div"> <?php if(!empty($msgData['card_a_no'])){echo substr($msgData['card_a_no'], -4);} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
	                    </p>
	                    
	                     <p>
	                        <span class="left-div">Customer Name :</span>
	                        <span class="right-div">  
	                        <?= !empty(ucfirst($msgData['name'])) ? ucfirst($msgData['name']) : ''; ?>
	                        </span>
	                    </p>
	                    
	                </div>
	                <div style="width: 100%;float: left;display: inline-block;margin-top: 20px">
	                    <p style="text-transform: uppercase;margin-bottom: 0;line-height: 20px;font-style: italic">* i agree to pay above total amount according to the cardholder agreement (Merchant agreement if credit voucher)</p>
	                    <p style="text-transform: uppercase;margin-top: 0;line-height: 20px;font-style: italic">** important - please retain this copy for your records</p>
	                </div>
	                <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
	                    <a href="#" style="background-color:#0077e2;border-radius:4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration:none;float:right;
	                    color: #fff;">Print</a>
	                    <a href="#" style="background-color:#f5f5f5;padding: 10px 30px;font-size: 13px;border-radius:4px;text-decoration:none;float:right;
	                    color: #666;">Save</a>
	                </div>
	            </div>
	        </div>
	        <div class="footer-wraper" >
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