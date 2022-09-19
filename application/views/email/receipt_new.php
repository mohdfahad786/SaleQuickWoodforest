<!DOCTYPE html>
<html>
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

        @media only screen and (min-width:481px) and (max-width:768px) {
            .top-div {
                padding: 20px 20px !important;
            }
        }
        @media only screen and (max-width:651px) {
            .cc .cc-col{
                max-width: 100%  !important;
            }
            .cc .cc-col table{
                max-width: 100%  !important;
            }
            .cc{
                padding: 15px !important
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
            .top-div {
                padding: 20px 20px !important;
            }
        }
        @media only screen and (max-width:451px) {
            .top-div .head__col{
                max-width: 100% !important;
                width: 100% !important;
                text-align: center !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;text-align: center;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
    <div style="text-align: center;background-image: -webkit-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: -moz-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 30px 15px 0;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 201px;background-position: center top;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
        <div style="text-align: center;width: 100%;max-width: 972px;margin: 0 auto 11px;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);-moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);-webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);clear: both;display: table;">
            <div class="top-div" style="text-align: left;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">
                <div class="head__col" style="width: 50%;float: left;">
                    <p>
                        <img src="<?=base_url()?>logo/<?= $msgData['getEmail1'][0]['logo']; ?>" style="height: auto; max-width: 121px; max-height: 85px; width: auto; ">
                    </p> 
                    <h4 style="margin-bottom: 0px;color:#000; "><?php 
                    //print_r($msgData); 
                    echo $msgData['getEmail1'][0]['business_dba_name']; ?></h4>
                    <p style="margin-top: 0px; color: #878787;"><?= $msgData['getEmail1'][0]['website'] ?></p> 
                    <p style=" color: #878787;">
                        <span style="color:#000;text-transform:uppercase;">Telephone:</span> <?= $msgData['getEmail1'][0]['business_number'] ?>
                    </p>
                </div>
                <div class="head__col" style="width: 50%;float: left;text-align: right;">
                    <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Receipt</h3>
                    <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
                    <p style="line-height: 20px;margin-top: 10px">
                        <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
                        <span style="display: block; color: #878787;"><?= $msgData['getEmail'][0]['invoice_no'] ?></span>
                    </p>
                    <p style="line-height: 20px;margin-top: 10px">
                        <span style="display: block;color:#000;text-transform:uppercase;">Receipt Date</span>
                        <span style="display: block; color: #878787;"><?php    $originalDate = $msgData['getEmail'][0]['date_c'];
                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span>
                    </p>
                </div>
            </div>
            <!--  Item List Section Start -->
            <div  style="text-align: left;float: left;width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;padding: 15px;" >
                <?php 
                   //print_r($msgData['getEmail'][0]); 
               
                    if(isset($itemlisttype) && !empty($itemlisttype))
                    {
                        switch($itemlisttype)
                        {
                            case 'pos':
                            // print_r($invoice_detail_receipt_item); 
                            $itemLength=count($invoice_detail_receipt_item);
                            if($itemLength > 0 ) { 
                               ?>

                               <table style="max-width: 475px;width: 100%;font-size: 14px;clear: both;margin: 0 auto;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td colspan="2" style="font-weight: 600;padding: 7px 0;">All Items</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0; $i<$itemLength;  $i++)
                                    { 
                                        $quantity=$invoice_detail_receipt_item[$i]['quantity'];
                                        $price=$invoice_detail_receipt_item[$i]['price'];
                                        $item_name=$invoice_detail_receipt_item[$i]['name'];
                                        $atax=$invoice_detail_receipt_item[$i]['tax'];
                                        ?>
                                        <tr>
                                            <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);"><?=$item_name; ?></td>
                                            <td style="padding: 5px 1px;text-align: right;font-weight: 600;border-top: 1px solid rgba(236, 236, 236, 0.7);">$ <?php echo number_format($price,2); ?></td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                            <b>Total : </b>
                                        </td>
                                        <td style="padding: 7px 1px;text-align: right;font-weight: 600;border-top: 1px solid #ddd;">
                                         <?php
                                         $subttl1=$msgData['amount'];
                                         $subttl2=$msgData['tax']; 
                                    // settype($subttl1,float);
                                    // settype($subttl2,float);
                                         echo '$ '.number_format(($subttl1 - $subttl2-$tip),2);
                                         ?>
                                     </td>
                                 </tr>
                                 <!-- <tr>
                                    <td style="padding: 7px 1px;">
                                        <b>Tax : </b>
                                    </td>
                                    <td style="padding: 7px 1px;text-align: right;font-weight: 600;">
                                        <?php echo (isset($msgData['tax']) && !empty($msgData['tax']))? '$'.number_format($msgData['tax'],2) : "-"; ?>
                                    </td>
                                </tr> -->
                            </tfoot>
                        </table>
                    <?php } 
                    break;
                    // case no  two 
                    case 'request':
                    $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                    if($itemLength > 0 ) { 
                        ?>
                        <table style="max-width: 475px;width: 100%;font-size: 14px;clear: both;margin: 0 auto;" cellspacing="0">
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600;padding: 7px 0;">All Items</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // echo $itemLength;
                                $totalAmt=0;
                                for($i=0; $i<$itemLength;  $i++)
                                { 
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
                                        <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);"><?=$item_name[$i]; ?></td>
                                        <td style="padding: 5px 1px;text-align: right;font-weight: 600;border-top: 1px solid rgba(236, 236, 236, 0.7);">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                    </tr>
                                <?php }  ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                        <b>Total : </b>
                                    </td>
                                    <td style="padding: 7px 1px;text-align: right;font-weight: 600;border-top: 1px solid #ddd;">
                                     <?php
                                     $subttl1=$msgData['amount'];
                                     $subttl2=$msgData['tax'];  
                                        // settype($subttl1,float);
                                        // settype($subttl2,float);
                                     echo '$ '.number_format(($subttl1 - $subttl2),2);
                                     ?>
                                 </td>
                             </tr>
                             <!-- <tr>
                                <td style="padding: 7px 1px;">
                                    <b>Tax : </b>
                                </td>
                                <td style="padding: 7px 1px;text-align: right;font-weight: 600;">
                                 <?php echo (isset($msgData['tax']) && !empty($msgData['tax']))? '$'.number_format($msgData['tax'],2) : "-"; ?>
                             </td> -->
                         </tr>
                     </tfoot>
                    </table>
                    <?php } 
                    break;
                    }
                    }
                    ?>
            </div>
            <!--  Item List Section END -->
            <div class="cc" style="text-align: left;float: left;width: 100%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;padding: 15px 40px;">
                <div class="cc-col" style="width: 100%;float: left;max-width: 50%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                    <table style="max-width: 100%;width: 100%;font-size: 14px;clear: both;margin: 0 auto;min-width: 245px;" cellspacing="0">
                        <thead>
                            <tr>
                                <td colspan="2" style="font-weight: 600;padding: 7px 0;">Receipt To  </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="padding: 5px 1px;">
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
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div  class="cc-col" style="width: 100%;float: left;max-width: 50%;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                    <table style="max-width: 351px;width: 100%;font-size: 14px;clear: both;margin: 0 auto" cellspacing="0">
                        <thead>
                            <tr>
                                <td colspan="2" style="font-weight: 600;padding: 7px 0;">Payment Details</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Total Amount :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;">$<?= number_format($msgData['amount'],2) ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Tax :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?php echo (isset($msgData['tax']) && !empty($msgData['tax']))? '$'.number_format($msgData['tax'],2) : "-"; ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Tip :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?= number_format($msgData['getEmail'][0]['tip_amount'],2) ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Transaction ID :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?= $msgData['trans_a_no'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Reference :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?php if($msgData['getEmail'][0]['reference'] =='0'){echo 'N/A';}else {echo $msgData['getEmail'][0]['reference']; } ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Card Type :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?= !empty($msgData['card_a_type']) ? $msgData['card_a_type'] : ''; ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Last $ digits on card :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?php if(!empty($msgData['card_a_no'])){echo substr($msgData['card_a_no'], -4);} else { ?> &nbsp;&nbsp; <?php } ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);">Payment Status :</td>
                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);text-align: right;font-weight: 600;"><?php  echo $msgData['message_a']; ?></td>
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
</body>
</html>