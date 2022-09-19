<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SaleQuick Reciept</title>
        <link href="<?php echo base_url('/new_assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="icon" href="https://salequick.com/front_assets/images/cropped-salequick-fav-192x192.png" sizes="192x192" />
        <script src="<?php echo base_url('/new_assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('/new_assets/js/bootstrap.min.js'); ?>"></script>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
        <style>
         	body {
	            font-family: 'Open Sans', sans-serif;
	            width: 100%;
	            height: 100%;
        	}
        	td, th {
	            vertical-align: top;
	            text-align: left;
	        }
	        p {
	            font-size: 13px;
	            color: #878787;
	            line-height: 30px;
	            margin: 4px 0px;
	        }
        	a {
        		text-decoration:none;
        	}
        	td {
        		color: #495057;
        	}
	        .invoice-wrap {
	            float: left;
	            display: block;
	            border-radius: 4px;
	            -moz-border-radius: 4px;
	            -webkit-border-radius: 4px;
	            margin-left: 14%;
	            width: 72%;
	            background-color: #fff;
	        }
	        .main-box {
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
	            display: inline-block;
	            width: 100%;
	            float: left;
	            box-sizing: border-box;
	            -moz-box-sizing: border-box;
	            -webkit-box-sizing: border-box;
	            padding: 20px 20px;
                border-bottom: 3px solid lightgray;
	        }
	        .bottom-div {
	            display: inline-block;
	            float: left;
	            padding: 20px 0px;
	            width: 100%;
	            box-sizing: border-box
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
	            margin: 20px auto 0;
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
	            .bottom-div {
	                padding: 20px 20px;
	            }
	            .top-div {
	                padding: 20px 20px;
	            }
	        }
	        @media only screen and (max-width:480px) {
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
	        .terms-text {
	            font-weight: 400 !important;
	            font-size: 9px !important;
	            color: rgb(148, 148, 146);
	            line-height: 10px !important;
	        }
	        td.content {
		    	font-size: 15px;
			    font-weight: 400 !important;
			    text-align: justify;
			    padding-bottom: 10px;
		    }
		    td.content_bullet {
		    	font-size: 13px;
			    font-weight: 400 !important;
			    text-align: justify;
			    padding-bottom: 10px;
			    font-weight: 600 !important;
		    }
		    td.content_head {
		    	font-size: 15px;
			    font-weight: 400 !important;
			    text-align: justify;
			    padding-top: 10px;
			    padding-bottom: 10px;
		    }
		    .templateColumnContainer {
		    	text-align: center !important;
		    	padding-bottom: 20px;
		    }
		    .templateColumnContainer span {
		    	font-size: 18px;
		    	font-weight: 600;
		    }
	        @media screen and (max-width: 640px) {
	        	.footer_t_c {
	                font-size: 12px !important;
	            }
	            p {
	                margin: 0px;
	            }
	            td.content {
			    	font-size: 12px !important;
			    }
			    td.content_head {
			    	font-size: 14px !important;
			    }
			    td.content_bullet {
			    	font-size: 14px;
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
		    }
		    .custom_button {
		    	background-color: #0077e2;
		    	text-transform: uppercase;
		    	padding: 14px 30px;
		    	font-size: 16px;
		    	text-decoration: none;
		    	color: #fff;
		    	margin-right: 15px;
		    	border-radius: 10px;
		    	font-weight: 600;
		    }
        </style>
    </head>

	<body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;">
        <div class="main-box" style="padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;">
            <div class="invoice-wrap" style="float: left;
                display: block; border-radius: 4px;-moz-border-radius: 4px; -webkit-border-radius: 4px;background-color: #fff;">
                <div class="top-div">
                	<table border="0" cellpadding="0" cellspacing="0" id="templateColumns" style="margin: auto;width: 100%;">
					    <tr>
					        <td valign="top" width="100%" class="templateColumnContainer">
					        	<img src="https://salequick.com/front_assets/images/cropped-salequick-fav-192x192.png" alt="SaleQuick Icon" style="    width: 120px !important;margin-bottom: 20px;">
					        </td>
					    </tr>
					    <tr>
					        <td style="text-align: center !important;font-size: 20px !important;font-weight: 600 !important;padding-bottom: 20px !important;" class="content">Welcome <span style="color: #3a7fd5;"><?php echo $business_dba_name; ?></span>!</td>
					    </tr>
					    <tr>
					        <td style="text-align: center !important;" class="content">Please agree to SaleQuick's Merchant Services Agreement, Terms & Privacy Policy.<br>Please take time to read and understand.</td>
					    </tr>
					</table>

					<!-- button -->
					<table border="0" cellpadding="0" cellspacing="0" id="templateColumns" style="margin: auto;width: 100%;">
						<tr>
			            	<td style="text-align: center !important;">
				            	<div class="bottom-div text-center">
					                <div style="width: 100%;display: inline-block;margin-bottom: 30px;margin-top: 20px;">
					                    <a href="<?php echo $url; ?>" class="custom_button" style="color: #fff !important;">Click Here</a>
					                </div>
					            </div>
					        </td>
			            </tr>
					</table>
	            </div>
	        </div>

	        <div class="footer-wraper text-center">
	        	<div >
		            <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;color:#666; ">
		                <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
		                <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
		            </div>
	             	<div class="footer_cards">
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