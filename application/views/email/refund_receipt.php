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
                padding: 20px 20px !important;
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
                padding: 20px 0px !important;
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
                color: rgb(0, 166, 255) !important;
                font-size: 22px !important;
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
                font-size: 22px !important;
                font-weight: 600;
                margin-bottom: 0px !important;
                /*font-family: AvenirNext-Medium !important;*/
                color: #000 !important;
            }
            .mail-phone-text {
                font-size: 14px;
                color: rgb(148, 148, 146);
                font-weight: 400 !important;
                margin-bottom: 0px !important;
                /*font-family: AvenirNext-Medium !important;*/
            }
            .item-head {
                font-size: 22px !important;
                font-weight: 600;
                margin-bottom: 0px !important;
                color: #000 !important;
                /*font-family: AvenirNext-Medium !important;*/
            }
            .item-detail-hr {
                width: 20% !important;
            }
            .item-details-table tbody tr td {
                font-size: 12px;
                font-weight: 400 !important;
                /*font-family: AvenirNext-Medium !important;*/
            }
            /*.item-details-table tbody tr {
                height: 45px;
            }*/
            .item-table-border {
                border-bottom: 1px solid rgb(245, 245, 251);
            }
            .item-details-table tfoot tr td {
                font-size: 13px;
                font-weight: 500 !important;
                /*font-family: AvenirNext-Medium !important;*/
            }
            .item-details-table tfoot tr {
                /*height: 45px;*/
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
    <body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;position: relative;">

        <div class="main-box" style="background-image: -webkit-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: -moz-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;">
            <div class="invoice-wrap" style="position:relative;width: 72%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

                <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">

                    <table border="0" cellpadding="0" cellspacing="0" id="templateColumns" style="margin: auto;width: 100%;">
                        <tr>
                            <td align="center" valign="top" width="100%" colspan="2" class="templateColumnContainer" style="text-align: center !important;">
                                <p class="invoice-number" style="text-align: center !important;margin-bottom: 10px !important;">Merchant Copy</p>
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" width="50%" class="templateColumnContainer">
                                <div class="display-avatar" style="padding: 0px !important;">
                                    <img class="invoice-logo" src="<?= base_url().'logo/'. $msgData['getEmail1'][0]['logo'] ?>">
                                </div>
                            </td>

                            <td align="right" valign="top" width="50%" class="templateColumnContainer" style="text-align: right !important;">
                                <p class="date-text" style="margin-top: 0px !important;">
                                    <?php $originalDate = $refund_data['date_c'];
                                    echo $newDate = date("F d, Y", strtotime($originalDate)); ?>
                                </p>
                                <p class="heading-text" style="margin-top: 0px !important;">RECEIPT</p>
                                <p class="invoice-number" style="margin-top: 0px !important;"><?= $msgData['getEmail'][0]['invoice_no'] ?></p>
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
                                    <p class="mail-phone-text" style="margin-top: 0px !important;"><?= $msgData['getEmail1'][0]['business_number'] ?></p>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php if(isset($itemlisttype) && !empty($itemlisttype)) {
                            switch($itemlisttype) {
                                case 'pos':
                                    $itemLength=count($invoice_detail_receipt_item);
                                    if($itemLength > 0 ) { ?>
                                        <tr style="overflow: auto;white-space: nowrap;">
                                            <td valign="top" colspan="2" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Item Details</p>
                                                <div style="overflow-x:auto;">
                                                    <table class="item-details-table" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>PRODUCT</th>
                                                                <th style="text-align: right !important;">PRICE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php for($i=0; $i<$itemLength;  $i++) {
                                                                $quantity=$invoice_detail_receipt_item[$i]['quantity'];
                                                                $price=$invoice_detail_receipt_item[$i]['price'];
                                                                $item_name=$invoice_detail_receipt_item[$i]['name'];
                                                                $atax=$invoice_detail_receipt_item[$i]['tax']; ?>
                                                                <tr>
                                                                    <td><?=$item_name; ?></td>
                                                                    <td style="text-align: right !important;">$ <?= number_format($price,2); ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- <tr>
                                            <td valign="top" width="50%" class="templateColumnContainer"></td>
                                            <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Payment Details</p>
                                                <table class="payment-details-table" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td width="50%" class="left">Total</td>
                                                            <td width="50%" style="text-align: right !important;">
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
                                                            <td width="50%" class="left">Tip</td>
                                                            <td width="50%" style="text-align: right !important;">
                                                                <?php echo (isset($msgData['getEmail'][0]['tip_amount']) && !empty($msgData['getEmail'][0]['tip_amount']))? '$'.number_format($msgData['getEmail'][0]['tip_amount'],2) : '0'; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> -->
                                    <?php } 
                                break;

                                case 'request':
                                    $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                                    if($itemLength > 0 ) { ?>
                                        <tr style="overflow: auto;white-space: nowrap;">
                                            <td valign="top" colspan="2" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Item Details</p>
                                                <div style="overflow-x:auto;">
                                                    <table class="item-details-table" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>PRODUCT</th>
                                                                <th style="text-align: right !important;">PRICE</th>
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
                                                                    <td><?=$item_name[$i]; ?></td>
                                                                    <td style="text-align: right !important;">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- <tr>
                                            <td valign="top" width="50%" class="templateColumnContainer"></td>
                                            <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Payment Details</p>
                                                <table class="payment-details-table" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td width="50%" class="left">Total</td>
                                                            <td width="50%" style="text-align: right !important;">
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
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> -->
                                    <?php }
                                break;
                            }
                        } else {
                            $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                            if($itemLength > 0 ) { ?>
                                <tr style="overflow: auto;white-space: nowrap;">
                                    <td valign="top" colspan="2" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                        <p class="item-head">Item Details</p>
                                        <div style="overflow-x:auto;">
                                            <table class="item-details-table" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>PRODUCT</th>
                                                        <th style="text-align: right !important;">PRICE</th>
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
                                                            <td><?=$item_name[$i]; ?></td>
                                                            <td style="text-align: right !important;">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <!-- <tr>
                                    <td valign="top" width="50%" class="templateColumnContainer"></td>
                                    <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                        <p class="item-head">Payment Details</p>
                                        <table class="payment-details-table" style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td width="50%" class="left">Total</td>
                                                    <td width="50%" style="text-align: right !important;">
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
                                            </tbody>
                                        </table>
                                    </td>
                                </tr> -->
                            <?php }
                        } ?>

                        <tr>
                            <td valign="top" width="50%" class="templateColumnContainer" style="padding-right: 20px !important;padding-top: 25px !important;">
                                <!-- <p class="invoice-to-text" style="margin-top: 10px !important;">Receipt To</p> -->
                                <?php if(isset($itemlisttype) && !empty($itemlisttype)) {
                                    switch($itemlisttype) {
                                        case 'pos': ?>
                                            <?php if(!empty($msgData['getEmail'][0]['sign'])) { ?>
                                                <img src="<?php echo  base_url(); ?>logo/<?php echo $msgData['getEmail'][0]['sign']; ?>"   style="width: auto; max-width: 100%; max-height: 170px; " onerror="this.outerHTML ='-'" alt="-">
                                            <?php } elseif($msgData['getEmail'][0]['name']!="") { ?>
                                                <span><?=$msgData['getEmail'][0]['name'];?></span>
                                            <?php }
                                        break;

                                        case 'request':
                                            if($msgData['getEmail'][0]['sign']!="") {
                                                $base64_string=$msgData['getEmail'][0]['sign']; 
                                                $img = str_replace('data:image/png;base64,', '', $base64_string);
                                                $img = str_replace(' ', '+', $img);  
                                                $img = base64_decode($img);
                                                $file='signature_'.uniqid().'.png';
                                                $success=file_put_contents('uploads/sign/'.$file, $img); ?>
                                                <img src="<?php echo  base_url('uploads/sign/'); ?><?php echo $file; ?>" style="width: auto; max-width: 100%; max-height: 170px; "/>
                                            <?php } elseif($msgData['getEmail'][0]['name']!="") { ?>
                                                <span><?=$msgData['getEmail'][0]['name'];?></span>
                                            <?php }
                                        break;

                                        default: ?>
                                            <span><?=$msgData['getEmail'][0]['name'];?></span>
                                        <?php break;
                                    }
                                } else {
                                    if($msgData['getEmail'][0]['sign']!=""){  
                                        $base64_string=$msgData['getEmail'][0]['sign']; 
                                        $img = str_replace('data:image/png;base64,', '', $base64_string);
                                        $img = str_replace(' ', '+', $img);  
                                        $img = base64_decode($img);
                                        $file='signature_'.uniqid().'.png';
                                        $success=file_put_contents('uploads/sign/'.$file, $img); ?>
                                        <img src="<?php echo  base_url('uploads/sign/'); ?><?php echo $file; ?>" style="width: auto; max-width: 100%; max-height: 170px; "/>
                                    <?php } elseif($msgData['getEmail'][0]['name']!="") { ?>
                                        <span><?=$msgData['getEmail'][0]['name'];?></span>
                                    <?php }
                                } ?>
                                <p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p><p class="terms-text" style="text-align: justify !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>
                            </td>

                            <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                <table style="width: 100%">
                                    <tr>
                                        <p class="item-head" style="margin-top: 10px!important;">Payment Details</p>
                                        <table class="payment-details-table" style="width: 100%">
                                            <tbody>
                                                <!-- <?php if(isset($itemlisttype) && !empty($itemlisttype)) {
                                                    switch($itemlisttype) {
                                                        case 'pos':
                                                            $itemLength=count($invoice_detail_receipt_item);
                                                            if($itemLength > 0 ) { ?>
                                                                <tr>
                                                                    <td width="50%" class="left">Total</td>
                                                                    <td width="50%" style="text-align: right !important;">
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
                                                                    <td width="50%" class="left">Tip</td>
                                                                    <td width="50%" style="text-align: right !important;">
                                                                        <?php echo (isset($msgData['getEmail'][0]['tip_amount']) && !empty($msgData['getEmail'][0]['tip_amount']))? '$'.number_format($msgData['getEmail'][0]['tip_amount'],2) : '0'; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } 
                                                        break;

                                                        case 'request':
                                                            $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                                                            if($itemLength > 0 ) { ?>
                                                                <tr>
                                                                    <td width="50%" class="left">Sub Total</td>
                                                                    <td width="50%" style="text-align: right !important;">
                                                                        <?php
                                                                        $subttl1=$msgData['amount'];
                                                                        $subttl2=$msgData['tax'];
                                                                        $late_fee = $msgData['late_fee'];
                                                                        $o_charges = $msgData['getEmail'][0]['other_charges'];
                                                                        // settype($subttl1,float);
                                                                        // settype($subttl2,float);
                                                                        echo '$'.number_format(($subttl1 - $subttl2 - $late_fee - $o_charges),2);
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        break;
                                                    }
                                                } else {
                                                    $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                                                    if($itemLength > 0 ) { ?>
                                                        <tr>
                                                            <td width="50%" class="left">Sub Total</td>
                                                            <td width="50%" style="text-align: right !important;">
                                                                <?php
                                                                $subttl1=$msgData['amount'];
                                                                $subttl2=$msgData['tax'];
                                                                $late_fee = $msgData['late_fee'];
                                                                $o_charges = $msgData['getEmail'][0]['other_charges'];
                                                                // settype($subttl1,float);
                                                                // settype($subttl2,float);
                                                                echo '$ '.number_format(($subttl1 - $subttl2 - $late_fee - $o_charges),2);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } ?> -->

                                                <tr>
                                                    <td width="50%" class="left">Sub Total</td>
                                                    <td width="50%" style="text-align: right !important;">$<?= number_format(($msgData['amount'] - $msgData['tax'] - $msgData['late_fee'] - $msgData['getEmail'][0]['other_charges']),2); ?></td>
                                                </tr>

                                                <?php
                                                $late_grace_period = $msgData['late_grace_period'];
                                                $payment_date = date('Y-m-d', strtotime($msgData['getEmail_a'][0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
                                                if($msgData['late_fee']) { ?>
                                                    <tr>
                                                        <td width="50%">Late Fee</td>
                                                        <td width="50%" style="text-align: right !important;">$<?= number_format($msgData['late_fee'],2) ?></td>
                                                    </tr>
                                                <?php } ?>

                                                <?php if($msgData['getEmail'][0]['discount']!='' && $msgData['getEmail'][0]['discount']!='0' && $msgData['getEmail'][0]['discount']!="$0.00"){
                                                        $discountAmount=$msgData['getEmail'][0]['tax']+$msgData['getEmail'][0]['total_amount']-$msgData['getEmail'][0]['amount'];
                                                } ?>

                                                <?php //if($msgData['getEmail'][0]['tax']!="" && $msgData['getEmail'][0]['tax'] > 0) { ?>
                                                    <tr>
                                                        <td width="50%">Total Tax</td> 
                                                        <td width="50%" style="text-align: right !important;"><?php echo '$'.number_format($msgData['getEmail'][0]['tax'],2); ?></td>
                                                    </tr>
                                                <?php //} ?>

                                                <?php if($msgData['getEmail'][0]['other_charges']!="" && $msgData['getEmail'][0]['other_charges'] > 0) { ?>
                                                    <tr>
                                                        <td width="50%"><?= $msgData['getEmail'][0]['otherChargesName']; ?></td> 
                                                        <td width="50%" style="text-align: right !important;">$<?= number_format($msgData['getEmail'][0]['other_charges'],2); ?></td>
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td width="50%">Total Amount</td>
                                                    <td width="50%" style="text-align: right !important;">
                                                    $<?php echo number_format($msgData['amount'], 2);  ?></td>
                                                </tr>
                                               
                                                <tr>
                                                    <td width="50%">Transaction ID</td>
                                                    <td width="50%" style="text-align: right !important;"><?=$msgData['getEmail'][0]['transaction_id']; ?></td>
                                                </tr>

                                                <tr>
                                                    <td width="50%">Payment Date</td>
                                                    <td width="50%" style="text-align: right !important;"><?=date("F d, Y", strtotime($msgData['getEmail'][0]['date_c'])); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </tr>

                                    <tr>
                                        <p class="item-head" style="margin-top: 10px!important;">Refund Details</p>
                                        <table class="payment-details-table" style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Refund Amount</td>
                                                    <td width="50%" style="text-align: right !important;">
                                                    $<?php echo number_format($refund_data['amount'],2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Transaction ID</td>
                                                    <td width="50%" style="text-align: right !important;"><?=$refund_data['transaction_id']; ?></td>
                                                </tr>

                                                <tr>
                                                    <td width="50%">Type</td>
                                                    <td width="50%" style="text-align: right !important;"><?=$refund_data['type']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Refund Date</td>
                                                    <td width="50%" style="text-align: right !important;"><?=date("F d, Y", strtotime($refund_data['date_c'])); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </tr>
                                </table>
                                
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">

                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">

                    <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">

                        <span style="display: block;font-weight:600;color:#000 "> <?= $msgData['getEmail1'][0]['business_dba_name'] ?> </span>
                        <span style="display: inline-block;color:#666"> <?= $msgData['getEmail1'][0]['address1'] ?> </span>
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