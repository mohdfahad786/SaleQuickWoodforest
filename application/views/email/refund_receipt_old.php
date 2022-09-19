<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SalesQuick</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
        <style>
            p {
                font-size: 13px !important;
                color: #878787 !important;
                line-height: 28px !important;
                margin: 4px 0px !important;
            }
            a {
                text-decoration: none !important;
            }
            @media only screen and (max-device-width:451px) {
                .top-div .head__col{
                    max-width: 100% !important;
                    width: 100% !important;
                    text-align: center !important;
                }
            }
            @media only screen and (max-device-width:451px) {
                .top-div .head__col{
                    max-width: 100% !important;
                    width: 100% !important;
                    text-align: center !important;
                }
            }
            @media only screen and (max-device-width:451px) {
                .top-div .head__col{
                    max-width: 100% !important;
                    width: 100% !important;
                    text-align: center !important;
                }
            }
        </style>
    </head>
    <body style="margin:0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;text-align: center;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
        <div style="text-align: center;background-image: -webkit-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: -moz-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 30px 0 0;background-repeat: no-repeat;display: table;background-size: 100% 201px;background-position: center top;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;max-width: 100%;width: 100%;">
            <div style="padding: 0 15px;display: table;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;max-width: 100%;width: 100%;">
                <div style="text-align: center;width: 100%;max-width: 751px;margin: 0 auto 11px;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);-moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);-webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);clear: both;display: table;">
                    <div class="top-div" style="text-align: left;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">
                        <div class="head__col" style="width: 50%;float: left;">
                            <p>
                                <img src="<?=base_url()?>logo/<?=$msgData['getEmail1'][0]['logo']; ?>" style="height: auto;max-width: 175px;max-height: 85px;width: auto; ">
                            </p> 
                            <h4 style="margin-bottom: 0px;color:#000; "><?php  echo $msgData['getEmail1'][0]['business_dba_name']; ?></h4>
                            <p style="margin-top: 0px; color: #878787;"><?= $msgData['getEmail1'][0]['website'] ?></p> 
                            <p style=" color: #878787;">
                                <span style="color:#878787;text-transform:uppercase;">Telephone:</span> <?= $msgData['getEmail1'][0]['business_number'] ?>
                            </p>
                        </div>
                        <div class="head__col" style="width: 50%;float: left;text-align: right;">
                            <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;"> Refund Receipt</h3>
                            <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
                            <p style="line-height: 20px;margin-top: 10px">
                                <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
                                <span style="display: block; color: #878787;"><?= $msgData['getEmail'][0]['invoice_no'] ?></span>
                            </p>
                            <p style="line-height: 20px;margin-top: 10px">
                                <span style="display: block;color:#000;text-transform:uppercase;">Receipt Date</span>
                                <span style="display: block; color: #878787;"><?php    $originalDate =$refund_data['date_c']; // $msgData['getEmail'][0]['date_c'];
                                echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span>
                            </p>
                            <!-- <?php if($msgData['payment_type'] == 'recurring') { ?>
                                <p style="line-height: 20px;margin-top: 10px">
                                    <span style="display: block;color:#000;text-transform:uppercase;">Recurring</span>
                                    <span style="display: block; color: #878787;">Recurring <?= ($msgData['recurring_type'] == 'daily' ? 'Daily' : ($msgData['recurring_type'] == 'weekly' ? 'Weekly' : ($msgData['recurring_type'] == 'biweekly' ? 'Bi Weekly' : ($msgData['recurring_type'] == 'monthly' ? 'Monthly' : ($msgData['recurring_type'] == 'quarterly' ? 'Quarterly' : ($msgData['recurring_type'] == 'yearly' ? 'Yearly' : ''))))))?> Receipt No <?= $msgData['no_of_invoice']?> of <?= ($msgData['recurring_count'] == -1 ? '&infin;' : $msgData['recurring_count'])?></span>
                                </p>
                            <?php } ?> -->
                        </div>
                    </div>
                  
                    <div  style="text-align: left;float: left;width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;padding: 15px 20px;" >
                        <?php 
                            if(isset($itemlisttype) && !empty($itemlisttype)) {
                                switch($itemlisttype) {
                                    case 'pos':
                                    $itemLength=count($invoice_detail_receipt_item);
                                    if($itemLength > 0 ) { 
                        ?>
                        <table style="max-width: 100%;width: 100%;font-size: 14px;clear: both;margin: 0 auto;" cellspacing="0">
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600;padding: 15px 0px;">All Items</td>
                                </tr>
                            </thead>
                            <tbody>
    						  <?php
                                    for($i=0; $i<$itemLength;  $i++) { 
                                        $quantity=$invoice_detail_receipt_item[$i]['quantity'];
                                        $price=$invoice_detail_receipt_item[$i]['price'];
                                        $item_name=$invoice_detail_receipt_item[$i]['name'];
                                        $atax=$invoice_detail_receipt_item[$i]['tax'];
                                        ?>
    						        <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"><?=$item_name; ?></td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">$ <?= number_format($price,2); ?></td>
                                    </tr>
								<?php }  ?>
                            </tbody>
                            <tfoot style="color: #333; "> 
                                <tr>
                                    <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                        <b>Total : </b>
                                    </td>
                                    <td style="padding: 7px 1px;font-weight: 600;border-top: 1px solid #ddd;"> 
                                        <?php
                                            $subttl1=$msgData['amount'];
                                            $subttl2=$msgData['tax'];
                                            $late_fee = $msgData['late_fee']; 
                                            // settype($subttl1,float);
                                            // settype($subttl2,float);
                                            $tip=$msgData['getEmail'][0]['tip_amount']?$msgData['getEmail'][0]['tip_amount']:0;
                                             echo '$ '.number_format(($subttl1 - $subttl2 - $tip - $late_fee),2);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 7px 1px;">
                                        <b>Tip : </b>
                                    </td>
                                    <td style="padding: 7px 1px;font-weight: 600;">
                                        <?php echo (isset($msgData['getEmail'][0]['tip_amount']) && !empty($msgData['getEmail'][0]['tip_amount']))? '$'.$msgData['getEmail'][0]['tip_amount'] : '0'; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
					   <?php } 
                        break;
                        // case no  two 
                        case 'request':
                        $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                        if($itemLength > 0 ) { ?>
					        <table style="max-width: 100%;width: 100%;font-size: 14px;clear: both;margin: 0 auto;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td colspan="2" style="font-weight: 600;padding: 15px 0px;">All Items</td>
                                    </tr>
                                </thead>
                                <tbody>
    						        <?php
                                        // echo $itemLength;
                                        $totalAmt=0;
                                        for($i=0; $i<$itemLength;  $i++) { 
                                            //json_decode($myJSON);
                                            $quantity=json_decode($invoice_detail_receipt_item[0]['quantity']);
                                            $price=json_decode($invoice_detail_receipt_item[0]['price']);
                                            $tax=json_decode($invoice_detail_receipt_item[0]['tax']);
                                            $tax_id=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                                            $tax_per=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                                            $total_amount=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                                            $item_name=json_decode($invoice_detail_receipt_item[0]['item_name']);
                                            $totalAmt+=$total_amount[$i];
                                        ?>
									    <tr>
                                            <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"><?=$item_name[$i]; ?></td>
                                            <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                        </tr>
									<?php }  ?>
                                </tbody>
                                <tfoot style="color: #333; "> 
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                            <b>Total : </b>
                                        </td>
                                        <td style="padding: 7px 1px;font-weight: 600;border-top: 1px solid #ddd;"> 
        								    <?php
                                                $subttl1=$msgData['amount'];
                                                $subttl2=$msgData['tax'];
                                                $late_fee = $msgData['late_fee'];
                                                // settype($subttl1,float);
                                                // settype($subttl2,float);
                                                echo '$ '.number_format(($subttl1 - $subttl2 - $late_fee),2);
                                            ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
					       <?php 
                        } 
                        break;
                        }
                        } else {
                            $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                            if($itemLength > 0 ) { 
                                ?>
    						   <table style="max-width: 100%;width: 100%;font-size: 14px;clear: both;margin: 0 auto;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td colspan="2" style="font-weight: 600;padding: 15px 0px;">All Items</td>
                                        </tr>
                                    </thead>
                                    <tbody>
        						        <?php
                                            // echo $itemLength;
                                            $totalAmt=0;
                                            for($i=0; $i<$itemLength;  $i++) { 
                                                //json_decode($myJSON);
                                                $quantity=json_decode($invoice_detail_receipt_item[0]['quantity']);
                                                $price=json_decode($invoice_detail_receipt_item[0]['price']);
                                                $tax=json_decode($invoice_detail_receipt_item[0]['tax']);
                                                $tax_id=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                                                $tax_per=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                                                $total_amount=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                                                $item_name=json_decode($invoice_detail_receipt_item[0]['item_name']);
                                                $totalAmt+=$total_amount[$i];
                                        ?>
    								    <tr>
                                            <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"><?=$item_name[$i]; ?></td>
                                            <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                        </tr>
    									<?php }  ?>
                                    </tbody>
                                    <tfoot style="color: #333; "> 
                                        <tr>
                                            <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                                <b>Total : </b>
                                            </td>
                                            <td style="padding: 7px 1px;font-weight: 600;border-top: 1px solid #ddd;"> 
            								    <?php
                                                    $subttl1=$msgData['amount'];
                                                    $subttl2=$msgData['tax'];
                                                    $late_fee = $msgData['late_fee'];
                                                    // settype($subttl1,float);
                                                    // settype($subttl2,float);
                                                    echo '$ '.number_format(($subttl1 - $subttl2 - $late_fee),2);
                                                ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
    					   <?php }
                        }?>
                    </div>
                    <div class="cc" style="text-align: left;float: left;width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;padding: 15px 20px;">
                        <div  class="cc-col" style="width: 100%;float: left;max-width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                            <table style="max-width: 100%;width: 100%;font-size: 14px;clear: both;margin: 0 auto" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td colspan="2" style="font-weight: 600;padding: 15px 0;">Payment Details</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $late_grace_period = $msgData['late_grace_period'];
                                        $payment_date = date('Y-m-d', strtotime($msgData['getEmail_a'][0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
                                        // if(($msgData['late_fee']) || ($msgData['late_fee_status'] > 0 && date('Y-m-d') > $payment_date])) { 
                                        if($msgData['late_fee']) { 
                                    ?>
                                        <tr>
                                            <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Late Fee :</td>
                                            <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;">$<?= $msgData['late_fee'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if($msgData['getEmail'][0]['discount']!='' && $msgData['getEmail'][0]['discount']!='0' && $msgData['getEmail'][0]['discount']!="$0.00"){
                                         // $discountAmount=($msgData['getEmail'][0]['total_amount']*(int) str_replace('$','',str_replace('%','',$msgData['getEmail'][0]['discount'])) )/100; 
                                       $discountAmount=$msgData['getEmail'][0]['tax']+$msgData['getEmail'][0]['total_amount']-$msgData['getEmail'][0]['amount'];
                                       ?>
                                     <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"> Sub Amount :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">
    									$<?=$msgData['getEmail'][0]['total_amount']?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Total Discount (<?=$msgData['getEmail'][0]['discount'];?>):</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">
    									-$<?= $discountAmount ?></td>
                                    </tr> -->
                                   <?php } ?>
                                   <?php //if($msgData['tax']!="" && $msgData['tax'] > 0) { ?>
                                    <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Tax :</td> 
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?php echo (isset($msgData['tax']) && !empty($msgData['tax']))? '$'.$msgData['tax'] : "-"; ?></td>
                                    </tr> -->
    								<?php //} ?>
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"> Amount :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">
    									$<?php echo number_format($msgData['amount'], 2);  ?></td>
                                    </tr>
                                   
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Transaction ID :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=$msgData['getEmail'][0]['transaction_id']; ?></td>
                                    </tr>
                                   
                                    <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Reference :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?php if($msgData['getEmail'][0]['reference'] =='0'){echo 'N/A';}else {echo $msgData['getEmail'][0]['reference']; } ?></td>
                                    </tr> -->
                                    <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Card Type</td> 
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=!empty($msgData['card_a_type']) ? $msgData['card_a_type'] : $msgData['getEmail'][0]['card_type']; ?></td>
                                    </tr> -->
                                    <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Last 4 digits on card :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?php if(!empty($msgData['card_a_no'])){echo substr($msgData['card_a_no'], -4);} else if($msgData['getEmail'][0]['card_no']){ echo substr($msgData['getEmail'][0]['card_no'],-4);  }else{ ?> &nbsp;&nbsp; <?php } ?></td>
                                    </tr> -->

    								 <?php //if($msgData['getEmail'][0]['name_card']!="" ||  $msgData['getEmail'][0]['name']!='') { ?> 
                                    <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Name On Card :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=$msgData['getEmail'][0]['name_card']?$msgData['getEmail'][0]['name_card']:$msgData['getEmail'][0]['name']; ?></td>
                                    </tr> -->
    								<?php// } ?>
                                    <!-- <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Payment Status :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?php   if($msgData['message_a']=='confirm' || $msgData['message_a']=='Approved' ||  $msgData['message_a']=='Chargeback_Confirm' ||  $msgData['getEmail'][0]['status']=='confirm' ||  $msgData['getEmail'][0]['status']=='Chargeback_Confirm'  ) echo 'Approved'; ?></td>
                                    </tr> -->
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"> Payment date :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=date("F d, Y", strtotime($msgData['getEmail'][0]['date_c'])); ?></td>
                                    </tr>
                                    

                                </tbody>

                                <thead>
                                    <tr>
                                        <td colspan="2" style="font-weight: 600;padding: 15px 0;">Refund Details</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Amount :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;">
    									$<?php echo number_format($refund_data['amount'],2); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Transaction ID :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=$refund_data['transaction_id']; ?></td>
                                    </tr>

                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;">Type :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=$refund_data['type']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;text-transform: uppercase;font-size: 13px;color:#1b1b1b;"> Refund date :</td>
                                        <td style="padding: 7px 1px;border-top: 1px solid #eaeaea;font-weight: 500;color: #444;text-transform: uppercase;"><?=date("F d, Y", strtotime($refund_data['date_c'])); ?></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="cc-col" style="width: 100%;float: left;max-width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                            <table style="width: 100%;font-size: 14px;clear: both;margin: 15px 0 7px;min-width: 245px;max-width: 475px;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td colspan="2" style="font-weight: 600;padding: 15px 0;">Receipt To  </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="padding: 7px 1px;">
                                            
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
                                                else
                                                {
                                                     if($msgData['getEmail'][0]['sign']!=""){  
                                                        $base64_string=$msgData['getEmail'][0]['sign']; 
                                                        $img = str_replace('data:image/png;base64,', '', $base64_string);
                                                        $img = str_replace(' ', '+', $img);  
                                                        $img = base64_decode($img);
                                                        $file='signature_'.uniqid().'.png';
                                                        $success=file_put_contents('uploads/sign/'.$file, $img); ?>
                                                        <img src="<?php echo  base_url('uploads/sign/'); ?><?php echo $file; ?>" style="width: auto; max-width: 100%; max-height: 170px; "/>
                                                       <?php }
                                                }

                                        ?> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="width: 100%;float: left;max-width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;margin-top: 21px;">
                            <p style="text-transform: uppercase;margin-bottom: 0;line-height: 20px;font-style: italic;color: #878787;font-size:12px; ">* i agree to pay above total amount according to the cardholder agreement (Merchant agreement if credit voucher)</p>
                            <p style="text-transform: uppercase;margin-bottom: 0;line-height: 20px;font-style: italic;color: #878787;font-size:12px; ">** important - please retain this copy for your records</p>
                        </div>
                    </div>
                </div>
                <div style="float: left;width:100%;text-align:center;clear: both;max-width: 100%;">
                    <div style="max-width: 970px;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 0 auto;display: table;padding: 15px;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                        <div style="float: left;width:100%;text-align:center;margin: 0 0 10px;" >
                            <span style="display: block;font-weight:600;color:#000 "> <?= $msgData['getEmail1'][0]['business_dba_name'] ?> </span>
                            <span style="display: inline-block;color:#666"> <?= $msgData['getEmail1'][0]['address1'] ?> </span>
                        </div>
                        <div style="width:100%;padding-top: 7px;color:#666;float: left;margin: 0 0 10px;">
                            <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                            <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                        </div>
                        <div style="float: left;width:100%;text-align:center;margin: 0 0 10px;">
                            <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                <img src="https://salequick.com/front/invoice/img/foot_icon1.jpg">
                            </a>
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
        </div>
    </body>
</html>
