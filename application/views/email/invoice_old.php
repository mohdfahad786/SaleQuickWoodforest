<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SalesQuick</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
         <style>
         /* a[href] .custom-btn
            {
                color: <?=$color2;?> !important;
                cursor: pointer;
                border: 1px solid <?=$color2;?> !important;
                background-color:#<?=$msgData['getDashboardData_m'][0]['color']; ?> !important; 
            }   */
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
            margin-bottom: 11px !important;
            width: auto !important;
        }
        
        .footer_address span:first-child {
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
            .fourty-div {

                    width: 100% !important;

                    float: right !important;

                }

                .sixty-div {

                    width: 100% !important;

                    text-align: center !important;

                }
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
        }
         .sixty-div {

                width: 60% !important;

                float: left !important;

                display: inline-block !important;

            }

            .fourty-div {

                width: 40% !important;

                float: right !important;

                display: inline-block !important;

            }
     
    </style>
    </head>
   <body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;position: relative;">

    <div class="main-box" style="background-image: linear-gradient(#<?= $msgData['getDashboardData_m'][0]['color'] ?>,#<?= $msgData['color'] ?>);padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;">
    <!--<div class="main-box" style="padding: 80px 0px 10px 0px; width: 100%;height: 100%;display: inline-block;position: relative;">-->
        <!--<div style="z-index: 0;margin:0 auto;padding: 0;max-width: 100%;width: 100%;height: 30%;position: absolute;top: 0;left: 0;background-color: #<?= $msgData['color'] ?>"></div>-->
        <div class="invoice-wrap" style="position:relative;width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

            <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">

                <div class="float-left" style="width:100%;display:inline-block;text-align:center;">

                        <p><img src="https://salequick.com/logo/<?= $msgData['getDashboardData_m'][0]['logo'] ?>" width="200px"></p>
                            <h4 style="margin-bottom: 0px;color:#000; "><?= $msgData['getDashboardData_m'][0]['business_dba_name'] ?> </h4>
                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
                            <p style="color: #878787; margin-top: 0px;">Telephone:<?= $msgData['getDashboardData_m'][0]['business_number'] ?></p>
                    </div>
                    <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
                        <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Invoice</h3>
                        <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
                        <p style="line-height: 20px;margin-top: 10px">
                            <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
                            <span style="display: block;color: #878787;"><?= $msgData['invoice_no'] ?></span></p>
                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
                            <span style="display: block;color: #878787;"><?php $originalDate = $msgData['date_c'];
                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span>
                        </p>
                        <?php if($msgData['payment_type'] == 'recurring') { ?>
                            <p style="line-height: 20px;margin-top: 10px">
                                <span style="display: block;color:#000;text-transform:uppercase;">Recurring</span>
                                <span style="display: block; color: #878787;">Recurring <?= ($msgData['recurring_type'] == 'daily' ? 'Daily' : ($msgData['recurring_type'] == 'weekly' ? 'Weekly' : ($msgData['recurring_type'] == 'biweekly' ? 'Bi Weekly' : ($msgData['recurring_type'] == 'monthly' ? 'Monthly' : ($msgData['recurring_type'] == 'quarterly' ? 'Quarterly' : ($msgData['recurring_type'] == 'yearly' ? 'Yearly' : ''))))))?> Invoice No <?= $msgData['no_of_invoice']?> of <?= ($msgData['recurring_count'] == -1 ? '&infin;' : $msgData['recurring_count'])?></span>
                            </p>
                        <?php } ?>
                    </div>
                </div>
                 <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">

                   <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
                        <tr>
                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Item name</th>
                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Qty</th>
                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Price</th>
                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Tax</th>
                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Amount</th>
                        </tr>
                        <?php
                            // echo "<pre>";print_r($msgData['item_detail']['item_name']);die;
                            if(!empty($msgData) && array_key_exists('item_detail', $msgData)){
                                // foreach ($msgData['item_detail'] as $rowp) { 
                                    $item_name =  str_replace(array('\\', '/'), '', $msgData['item_detail']['item_name']);
                                    $quantity =  str_replace(array('\\', '/'), '', $msgData['item_detail']['quantity']);
                                    $price =  str_replace(array('\\', '/'), '', $msgData['item_detail']['price']);
                                    $tax =  str_replace(array('\\', '/'), '', $msgData['item_detail']['tax']);
                                    $tax_id =  str_replace(array('\\', '/'), '', $msgData['item_detail']['tax_id']);
                                    $total_amount =  str_replace(array('\\', '/'), '', $msgData['item_detail']['total_amount']);
                                    $item_name1 = json_decode($item_name);
                                    $quantity1 = json_decode($quantity);
                                    $price1 = json_decode($price);
                                    $tax1 = json_decode($tax);
                                    $tax_id1 = json_decode($tax_id);
                                    $total_amount1 = json_decode($total_amount);
                                    $i = 0; 
                                    foreach ($item_name1 as $rowpp) {
                                        if($quantity1[$i] > 0 && ucfirst($item_name1[$i])!='Labor'){
                                        ?>
                                        <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                <?php echo $item_name1[$i] ;?>
                                                    
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                <?php echo $quantity1[$i] ;?>
                                                
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $ <?= number_format(floatval($price1[$i]), 2) ;?>
                                                    
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $<?php
                                                    $tax_a = $total_amount1[$i] - ($price1[$i]*$quantity1[$i]);
                                                    if( $price1[$i]*$quantity1[$i] >= $total_amount1[$i] ){
                                                        echo '0.00';
                                                    }else{
                                                        echo  number_format($tax_a,2)  ;
                                                    }
                                                ?>
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$<?php   echo number_format($total_amount1[$i],2) ;?>
                                                
                                            </td>
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
                                    $j++; } 
                                    $Array1 = $data;
                                    $Array2 = $data1;
                                    // Build the result here
                                    $Array3 = [];
                                    // There is no validation, the code assumes that $Array2 contains
                                    // the same number of items as $Array1 or more
                                    foreach ($Array1 as $index => $key) {
                                        // If the key $key was not encountered yet then add it to the result
                                        if (! array_key_exists($key, $Array3)) {
                                            $Array3[$key] = 0;
                                        }
                                        // Add the value associate with $key to the sum in the results array
                                        $Array3[$key] += $Array2[$index];
                                    }
                                    foreach ($Array3 as $index => $person) {
                                        $laboramount = $index*$person;
                                        ?>
                                        <tr>
                                            <td style="color: #7e8899;font-size:13px;">Labor</td>
                                            <td style="color: #7e8899;font-size:13px;"><?php echo $person ;?></td>
                                            <td style="color: #7e8899;font-size:13px;">$<?php echo $index ;?></td>
                                            <td style="color: #7e8899;font-size:13px;">0.00</td>
                                            <td style="color: #7e8899;font-size:13px;">$<?php echo number_format($laboramount,2) ;?></td>
                                        </tr>
                                      <?php 
                                    }
                                // }
                            }   
                        ?>
                        <tr>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <?php
                                    $late_grace_period = $msgData['late_grace_period'];
                                    $payment_date = date('Y-m-d', strtotime($msgData['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
                                    $late_fee_status = $msgData['late_fee_status'] ? $msgData['late_fee_status'] : 0;
                                    $late_fee = $msgData['late_fee'] ? $msgData['late_fee'] : ''; 
                                    $amount = $late_fee + $msgData['amount'];
                                    if($late_fee_status > 0 && date('Y-m-d') > $payment_date) { 
                                ?>
                                    <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Late Fee</p>
                                <?php } ?>
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <?php
                                    if($late_fee_status > 0 && date('Y-m-d') > $payment_date) { 
                                ?>
                                    <p style="color: #0077e2;border:0px;">$<?= number_format($msgData['late_fee'],2)  ;?></p>
                                    <p style="color: #0077e2;border:0px;">$<?= number_format($amount,2)  ;?></p>
                                <?php } else { ?>
                                    <p style="color: #0077e2;border:0px;">$<?= number_format($msgData['amount'],2)  ;?></p>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
                    
                      <a href="<?= $msgData['url'] ?>" class="custom-btn" style="color:white !important; background-color: #2273dc !important;  border-radius: 4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration: none;float: right; -webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 1px solid #000;">CONTINUE TO PAYMENT</a> 
                      <?php if($msgData['attachment']!=""){?> <!--DOWNLOAD-->
                       <a href="<?php echo base_url('uploads/attachment/').$msgData['attachment']; ?>"  class="custom-btn" style="color: #fff !important; background-color:rgb(11,107,230);  border-radius: 4px;padding: 10px 30px;font-size: 13px; text-transform: uppercase; text-decoration: none;float: left; -webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 1px solid #0000;"> ATTACHMENT</a> 
                     <?php } ?>

                     </div>
                </div>
            </div>
                <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">

                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">

                     <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">

                        <span style="display: block;font-weight:600;color:#000 "> <?= $msgData['getDashboardData_m'][0]['business_dba_name'] ?> </span>
                        <span style="display: inline-block;color:#666"> <?= $msgData['getDashboardData_m'][0]['address1'] ?> </span>
                    </div>
                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">

                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                    </div>
                    <div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">

                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  ></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
