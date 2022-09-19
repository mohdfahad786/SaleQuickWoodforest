<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SalesQuick</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
        <style>

        body {
            font-family: 'Open Sans', sans-serif !important;
            width: 100% !important;
            height: 100% !important;
        }
        
        td,
        th {
            vertical-align: top !important;
            text-align: left !important;
        }
        
        p {
            font-size: 13px !important;
            color: #878787 !important;
            line-height: 28px !important;
            margin: 4px 0px !important;
        }
        
        a {
            text-decoration: none !important;
        }
        
        .main-box {
            padding: 80px 0px 10px 0px !important;
        }
        
        .invoice-wrap {
            margin-left: 14% !important;
            width: 72% !important;
            max-width: 72% !important;
        }
        
        .top-div {
            padding: 20px 40px !important;
        }
        
        .float-left {
            float: left !important;
            width:auto !important;
            text-align: left !important;
        }
        
        .float-right {
            float: right !important;
            width:auto !important;
            text-align: right !important;
        }
        
        .bottom-div {
            padding: 20px 40px !important;
        }
        
        .footer-wraper>div::after,
        .footer-wraper>div::before,
        .footer-wraper::after,
        .footer-wraper:before {
            display: table !important;
            clear: both !important;
            content: "" !important;
        }
        
        .footer_cards {
            padding-right: 15px !important;
        }
        
        .footer-wraper>div>div {
            margin-bottom: 11px !important;width: auto !important;
        }
        
        .footer_address span:first-child {
            font-weight: 600 !important;
        }
        
        .sixty-div
        {
            width: 60% !important;
            text-align:left !important;
        }
        .fourty-div
        {
            width: 40% !important;

        }

        .left-div {

        width: 50% !important;

        display: inline-block !important;

        float: left !important;

        font-size: 14px !important;

        color: #353535 !important;

        }

        .right-div {

            width: 50% !important;

            display: inline-block !important;

            float: left !important;

            text-align: right !important;

            font-size: 14px !important;

            color: #353535 !important;

            font-weight: 600 !important;

        }

        @media screen and (max-width: 768px) {
            .footer_address>span:first {
                display: inline-block !important;
                width: 100% !important;
            }
        }
        
        @media only screen and (max-width:820px) {
            .footer-wraper>div>div {
                float: none !important;
            }
            .footer_address,
            .footer_cards {
                padding-right: 0px !important;
                padding-left: 0px !important;
            }
            .footer_t_c {
                padding-bottom: 7px !important;
            }
            .footer-wraper>div {
                margin: 20px auto 0 !important;
            }
        }
        
        @media only screen and (min-width:769px) and (max-width:900px) {
            .sixty-div {
                    width: 40% !important;
                    }
                    .fourty-div {

                    width: 60% !important;

            }
            .invoice-wrap {
                margin-left: 10% !important;
                width: 80% !important;
                max-width: 80% !important;
            }
            .main-box {
                padding: 50px 0px !important;
            }
        }
        
        @media only screen and (min-width:481px) and (max-width:768px) {
            .sixty-div {
              width: 40% !important;

                }

                .fourty-div {

                    width: 60% !important;

                }

            .invoice-wrap {
                margin-left: 6% !important;
                width: 88% !important;
                max-width: 88% !important;
            }
            .main-box {
                padding: 30px 0px !important;
            }
            .bottom-div {
                padding: 20px 20px !important;
            }
            .top-div {
                padding: 20px 20px !important;
            }
        }
        
        @media only screen and (max-width:400px) {
            .twenty-div {
                word-wrap: break-word !important;
            }
        }
        
        @media only screen and (max-width:375px) {
            .twenty-div {
                word-wrap: anywhere !important;
            }
        }
        
        @media only screen and (max-width:480px) {
            .float-right {
                text-align: center !important;
                width: 100% !important;
            }
            .float-left {
                text-align: center !important;
                width: 100% !important;
            }
            .invoice-wrap {
                margin-left: 5% !important;
                width: 90% !important;
                max-width: 90% !important;
            }
            .bottom-div {
                padding: 20px 10px !important;
            }
            .top-div {
                padding: 20px 20px !important;
            }
            .fourty-div {

                    width: 100% !important;

                    float: left !important;

                }

                .sixty-div {

                    width: 100% !important;

                    text-align: center !important;

                }
        }
    </style>

    </head>



	 <body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;">

        <!--<div class="main-box" style="padding: 80px 0px 10px 0px; background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>  30%, #fff  30%);width: 100%;height: 100%;display: inline-block;">-->
            
            <div class="main-box" style="background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;">

            <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

                <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">

                   <div class="float-left" style="width:100%;display:inline-block;text-align:center;">

	                    <p><img src="<?php echo  base_url(); ?>logo/<?= $msgData['getEmail1'][0]['logo'] ?>" width="200px"></p>

	                        <!--<h4 style="margin-bottom: 0px;color:#000; "><?= $msgData['getEmail1'][0]['business_dba_name'] ?></h4>-->

	                         <h4 style="margin-bottom: 0px;color:#000; ">Salequick</h4>

	                         <p style="margin-top: 0px; color: #878787;"><?= $msgData['getEmail1'][0]['website'] ?></p> 

	                         <p style=" color: #878787;">Telephone:<?= $msgData['getEmail1'][0]['business_number'] ?></p>

	                </div>

	                <div class="float-right" style="width:100%;display:inline-block;text-align:center;">

	                    <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Receipt</h3>

	                    <p style="margin-top: 0;line-height: 20px;color:#000">Merchant Copy</p>

	                    <p style="line-height: 20px;margin-top: 10px">

	                        <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>

	                        <span style="display: block; color: #878787;"><?= $msgData['getEmail'][0]['invoice_no'] ?></span></p>

	                    <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>

	                        <span style="display: block; color: #878787;"><?php $originalDate = $msgData['getEmail'][0]['date_c'];

                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span></p>

	                </div>

	            </div>

	            <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">

	                 <div class="sixty-div" style="width: 100%;float: left;display:inline-block;text-align:center; ">

	                    <h4 style="color:#000;">Invoice To</h4>

                            <!-- <p style="color: #878787;"><?= $msgData['getEmail'][0]['name'] ?></p> -->

                            <!-- <p><img src="https://salequick.com/logo/logo_20190130115126.jpg" width="100px"></p> -->

                            <?php 
                                            if(isset($itemlisttype) && !empty($itemlisttype))
                                            {
                                                switch($itemlisttype)
                                                {
                                                    case 'pos': ?>
                                                    <img src="<?php echo  base_url(); ?>logo/<?php echo $msgData['getEmail'][0]['sign']; ?>"   style="width: auto; max-width: 100%; max-height: 170px; " onerror="this.outerHTML ='-'" alt="-">
                                                    <!-- <img src="<?php echo  base_url('uploads/sign/'); ?><?php echo $file; ?>" style="width: auto; max-width: 100%; max-height: 170px; "/> -->
                                                <?php break;
                                                    case 'request':
                                                    if($msgData['getEmail'][0]['sign']!=""){  
                                                        $base64_string=$msgData['getEmail'][0]['sign']; 
                                                        $img = str_replace('data:image/png;base64,', '', $base64_string);
                                                        $img = str_replace(' ', '+', $img);  
                                                        $img = base64_decode($img);
                                                        $file='signature_'.uniqid().'.png';
                                                        $success=file_put_contents('uploads/sign/'.$file, $img); ?>
                                                        <img src="<?php echo  base_url('uploads/sign/'); ?><?php echo $file; ?>" style="width: auto; max-width: 100%; max-height: 170px; "/>
                                                    
                                                <?php }
                                                    elseif($msgData['getEmail'][0]['name']!="")
                                                    { ?>
                                                    <span><?=$msgData['getEmail'][0]['name'];?></span>
                                                <?php }
                                                    break;

                                                    default:  ?>
                                                    <span><?=$msgData['getEmail'][0]['name'];?></span>
                                                    <?php break;
                                                }
                                            }

                                    ?> 

                                    

	                        <h4 style="margin-bottom:0;color:#000; ">Payment Status</h4>

	                        <p style="text-transform: uppercase;color:#4a90e2;margin-top:0;font-size: 14px;font-weight: 600;"><?= $msgData['message_a'] ?></p>

	                </div>

	                <div class="fourty-div" style="width: 100%; text-align: left;display:inline-block;float:right;">

                          <div class="recipt" style="clear: both;width: 100%;">
                            <?php 	
                            if(isset($msgData['itemdata']) && count($msgData['itemdata']) > 0){
                                $recipt='<table style="max-width: 555px;width: 100%;font-size: 14px;" border="0" cellspacing="0"><tbody>';
                                    $i=1;
                                    $subtotalamt=0;
                                        foreach($msgData['itemdata'] as $pos){
                                            
                                            $recipt=$recipt.'<tr><td style="padding: 5px 1px;"></td><td style="padding: 5px 1px;">'.$pos['name'].'</td><td style="padding: 5px 1px;"></td><td style="padding: 5px 1px;">$'.$pos['price'].'</td></tr>';
                                            
                                            $subtotalamt=$subtotalamt+$pos['price']; 
                                            $taxa=$pos['tax'];
                                            $i++;
                                            
                                        }
                                        $recipt=$recipt."</table>";
                                        echo $recipt;
                                    }
                                        ?>
                                    
                            </div>

	                    <h4 style="color:#000;">Payment Details</h4>

                        <?php 	
                            if(isset($msgData['itemdata']) && count($msgData['itemdata']) > 0){   ?>
                            
                            <p style="line-height:26px;">

	                        <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;">Subtotal Amount :</span>

	                        <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;"> $<?php echo number_format($subtotalamt,2)  ;?></span>

	                    </p>
                           
                            <p style="line-height:26px;">

	                        <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;">Total Taxes :</span>

	                        <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;">$<?php echo number_format($taxa,2)  ;?></span>

	                    </p>
                            <?php } ?>



	                   <p style="line-height:26px;">

	                        <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;">Total Payable Amount :</span>

	                        <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;"> $<?= $msgData['amount'] ?></span>

	                    </p>

	                   <p style="line-height:26px;">

	                       <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;">Transaction ID :</span>

	                         <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;"><?= $msgData['trans_a_no'] ?></span>

	                    </p>

	                   <p style="line-height:26px;">

	                        <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;"> Reference :</span>

	                        <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;">
	                        	<?php if($msgData['getEmail'][0]['reference'] =='0'){echo 'N/A';}else {echo $msgData['getEmail'][0]['reference']; } ?></span>

	                    </p>

	                    <p style="line-height:26px;">

	                        <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;"> Card Type :</span>

	                        <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;">
	                        	<?= !empty($msgData['card_a_type']) ? $msgData['card_a_type'] : ''; ?>
	                        		
	                        </span>

	                    </p>

	                    <p style="line-height:26px;">

	                        <span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;">Last $ digits on card :</span>

	                        <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;"> <?php if(!empty($msgData['card_a_no'])){echo substr($msgData['card_a_no'], -4);} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>

	                    </p>

	                </div>

	                <div style="width: 100%;float: left;display: inline-block;margin-top: 20px">

	                    <p style="text-transform: uppercase;margin-bottom: 0;line-height: 20px;font-style: italic;color: #878787;font-size:12px; ">* i agree to pay above total amount according to the cardholder agreement (Merchant agreement if credit voucher)</p>

	                    <p style="text-transform: uppercase;margin-bottom: 0;line-height: 20px;font-style: italic;color: #878787;font-size:12px; ">** important - please retain this copy for your records</p>

	                </div>

	                 <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">

	                   <a href="#" style="background-color:#0077e2;border-radius:4px;text-transform: uppercase;padding: 10px  30px;font-size:13px;text-decoration:none;float:right;color: #fff;"> Print </a>

	                    <a href="#" style="background-color:#f5f5f5;padding: 10px 30px;font-size: 13px;border-radius:4px;text-decoration:none;float:right;margin-right: 10px;color: #666;"> Save </a>

	                </div>

	            </div>

	        </div>

	        <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">
            
            <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 20px auto 0;display: block;">

                <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">

		                <span style="display: block;font-weight:600;color:#000 "> <?= $msgData['getEmail1'][0]['business_dba_name'] ?> </span>

		                <span style="display: inline-block;color:#666"> <?= $msgData['getEmail1'][0]['address1'] ?> </span>

		            </div>

		            <div class="footer_t_c" style="width:100%;display: inline-block;vertical-align: middle;padding-top: 7px;color:#666; ">

		                <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|

		                <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>

		            </div>

	             	<div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">

		                <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
		                	<img src="https://salequick.com/front/invoice/img/foot_icon1.jpg"></a>

		                <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
		                	<img src="https://salequick.com/front/invoice/img/foot_icon2.jpg">
		                </a>

		                <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
		                	<img src="https://salequick.com/front/invoice/img/foot_icon3.jpg">
		                </a>

		                <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
		                	<img src="https://salequick.com/front/invoice/img/foot_icon4.jpg">
		                </a>

		            </div>

	        	</div>

	    	</div>

	    </div>

	</body>

</html>