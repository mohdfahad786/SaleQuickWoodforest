<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!--  -->
        
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
                padding: 20px 0px !important;
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
            @media only screen and (max-width:451px) {
                .top-div .head__col{
                    max-width: 100% !important;
                    width: 100% !important;
                    text-align: center !important;
                }
            }
            @media only screen and (max-width:451px) {
                .top-div .head__col{
                    max-width: 100% !important;
                    width: 100% !important;
                    text-align: center !important;
                }
            }


            /* ##################   */ 
            @media only screen and (min-device-width:720px) and (max-device-width:900px) {
                .top-div {
                    padding: 20px 20px !important;
                }
            }
             

            @media only screen and (min-device-width:481px) and (max-device-width:720px) {
                .top-div {
                    padding: 20px 20px !important;
                }
            }
            @media only screen and (max-device-width:651px) {
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

            @media only screen and (max-device-width:480px) {
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
            @font-face {
                font-family: 'Avenir-Black';
                font-style: normal;
                src: url('../new_assets/css/fonts/Avenir-Black.woff') format('woff'),
                     url('../new_assets/css/fonts/Avenir-Black.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Avenir-Heavy';
                font-style: normal;
                src: url('../new_assets/css/fonts/Avenir-Heavy.woff') format('woff'),
                     url('../new_assets/css/fonts/Avenir-Heavy.ttf') format('truetype');
            }
            @font-face {
                font-family: 'AvenirNext-Medium';
                font-style: normal;
                src: url('../new_assets/css/fonts/AvenirNext-Medium.woff') format('woff'),
                     url('../new_assets/css/fonts/AvenirNext-Medium.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Avenir-Roman';
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
            }
            .heading-text {
                color: rgb(0, 166, 255);
                font-size: 22px;
                font-weight: 500 !important;
                margin-bottom: 0px !important;
            }
            .invoice-number {
                font-size: 14px;
            }
            .owner-name {
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 0px !important;
                color: #000;
            }
            .mail-phone-text {
                font-size: 14px;
                color: rgb(148, 148, 146);
                font-weight: 400 !important;
                margin-bottom: 0px !important;
            }
            .item-head {
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 0px !important;
                color: #000 !important;
            }
            .item-detail-hr {
                width: 20% !important;
            }
            .item-details-table tbody tr td {
                font-size: 12px;
                font-weight: 400 !important;
            }
            .item-table-border {
                border-bottom: 1px solid rgb(245, 245, 251);
            }
            .item-details-table tfoot tr td {
                font-size: 13px;
                font-weight: 500 !important;
            }
            .item-details-table tfoot tr {
                border-top: 1px solid lightgray !important;
            }
            .payment-details-table tr td {
                font-size: 13px;
                font-weight: 400 !important;
            }
            .payment-details-table tr td.left {
                color: rgb(105, 105, 105);
            }
            .terms-text {
                font-weight: 400 !important;
                font-size: 9px !important;
                color: rgb(148, 148, 146);
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
    <body style="margin:0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;text-align: center;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
        
        <div style="text-align: center;background-image: -webkit-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: -moz-linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);background-image: linear-gradient(#<?= $msgData['getEmail1'][0]['color'] ?>,#<?= $msgData['getEmail1'][0]['color'] ?>);padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;background-position: center top;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
            
            <div style="text-align: center;width: 72%;max-width: 972px;margin: 0 auto 11px;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);-moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);-webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63);clear: both;display: table;">
                <div class="top-div" style="text-align: left;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">

                    <table border="0" cellpadding="0" cellspacing="0" id="templateColumns" style="margin: auto;width: 100%;">
                        <tr>
                            <td align="center" valign="top" width="100%" colspan="2" class="templateColumnContainer" style="text-align: center !important;">
                                <p class="invoice-number" style="text-align: center !important;margin-bottom: 10px !important;">Merchant Copy</p>
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" width="50%" class="templateColumnContainer">
                                <div class="display-avatar" style="padding: 0px !important;">
                                    <img class="invoice-logo" src="<?= base_url().'logo/'. $msgData['getEmail1'][0]['logo']; ?>">
                                </div>
                            </td>

                            <td align="right" valign="top" width="50%" class="templateColumnContainer" style="text-align: right !important;">
                                <p class="date-text" style="margin-top: 0px !important;"><?php $originalDate = $msgData['getEmail'][0]['date_c'];
                                echo $newDate = date("F d, Y", strtotime($originalDate)); ?></p>
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

                                <?php if($msgData['payment_type'] == 'recurring') { ?>
                                    <p class="mail-phone-text" style="margin-top: 0px !important;">Recurring <?= ($msgData['recurring_type'] == 'daily' ? 'Daily' : ($msgData['recurring_type'] == 'weekly' ? 'Weekly' : ($msgData['recurring_type'] == 'biweekly' ? 'Bi Weekly' : ($msgData['recurring_type'] == 'monthly' ? 'Monthly' : ($msgData['recurring_type'] == 'quarterly' ? 'Quarterly' : ($msgData['recurring_type'] == 'yearly' ? 'Yearly' : ''))))))?> Receipt No <?= $msgData['no_of_invoice'] ?> of <?= ($msgData['recurring_count'] == -1 ? '&infin;' : $msgData['recurring_count'])?></p>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php if(isset($itemlisttype) && !empty($itemlisttype)) {
                            switch($itemlisttype) {
                                case 'pos':
                                    // print_r($invoice_detail_receipt_item); 
                                    $itemLength=count($invoice_detail_receipt_item);
                                    if($itemLength > 0 ) {  ?>
                                        <tr style="overflow: auto;white-space: nowrap;">
                                            <td valign="top" colspan="2" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Item Details</p>
                                                <table class="item-details-table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th>PRODUCT</th>
                                                            <th style="text-align: right !important;">PRICE</th>
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
                                                                <td><?=$item_name; ?></td>
                                                                <td style="text-align: right !important;">$ <?php echo number_format($price,2); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <?php if($msgData['getEmail'][0]['transaction_type'] == 'split'){ ?>
                                            <!-- <tr>
                                                <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                                    <b>Sub Total : </b>
                                                </td>
                                                <td style="padding: 7px 1px;font-weight: 600;border-top: 1px solid #ddd;"> 
                                                    <?php
                                                        $subttl1 = $msgData['full_amount'];
                                                        $subttl2 = $msgData['tax'];
                                                        $late_fee = $msgData['late_fee'];
                                                        $tip = $msgData['getEmail'][0]['tip_amount'] ? $msgData['getEmail'][0]['tip_amount']:0;
                                                        echo '$ '.number_format(($subttl1 - $subttl2- $tip - $late_fee),2);
                                                    ?>
                                                </td>
                                            </tr> -->
                                        <?php } else { ?>
                                            <tr>
                                                <td valign="top" width="50%" class="templateColumnContainer"></td>
                                                <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                    <p class="item-head">Payment Details</p>
                                                    <table class="payment-details-table" style="width: 100%">
                                                        <tbody>
                                                            <td width="50%">Sub Total</td>
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
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }
                                break;
                                // case no  two 
                                case 'request':
                                    $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                                    if($itemLength > 0 ) { ?>
                                        <tr style="overflow: auto;white-space: nowrap;">
                                            <td valign="top" colspan="2" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Item Details</p>
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
                                                                <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);"><?=$item_name[$i]; ?></td>
                                                                <td style="padding: 5px 1px;text-align: right;font-weight: 600;border-top: 1px solid rgba(236, 236, 236, 0.7);">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td valign="top" width="50%" class="templateColumnContainer"></td>
                                            <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                                <p class="item-head">Payment Details</p>
                                                <table class="payment-details-table" style="width: 100%">
                                                    <tbody>
                                                        <td width="50%">Sub Total</td>
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
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php } 
                                break;
                            }
                        } else {
                            $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                            if($itemLength > 0 ) { ?>
                                <tr style="overflow: auto;white-space: nowrap;">
                                    <td valign="top" colspan="2" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                        <p class="item-head">Item Details</p>
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
                                                        <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7);"><?=$item_name[$i]; ?></td>
                                                        <td style="padding: 5px 1px;text-align: right;font-weight: 600;border-top: 1px solid rgba(236, 236, 236, 0.7);">$ <?php echo number_format($total_amount[$i],2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td valign="top" width="50%" class="templateColumnContainer"></td>
                                    <td valign="top" width="50%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                        <p class="item-head">Payment Details</p>
                                        <table class="payment-details-table" style="width: 100%">
                                            <tbody>
                                                <td width="50%">Sub Total</td>
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
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php }
                        } ?>

                        <?php if($msgData['getEmail'][0]['transaction_type'] == 'split'){ ?>
                            <tr>
                                <td valign="top" width="100%" class="templateColumnContainer" style="margin-top: 15px !important;">
                                    <p class="item-head">Split Payment Details</p>
                                    <table class="payment-details-table" style="width: 100%">
                                        <thead>
                                            <tr>
                                               <th>Transaction ID</th>
                                               <th style="text-align: right !important;">Amount</th>
                                               <th>Card Type</th>
                                               <th style="text-align: right !important;">Card NO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($split_payment_data)) {
                                                foreach($split_payment_data as $key => $value) { ?>
                                                    <tr>
                                                        <td><?= $value['transaction_id'] ? $value['transaction_id'] : '-' ?></td>
                                                        <td style="text-align: right !important;">$<?= $value['amount'] ? number_format($value['amount'],2) : '0.00' ?></td>
                                                        <td><?= $value['card_type'] ? $value['card_type'] : '-' ?></td>
                                                        <td style="text-align: right !important;">
                                                            <?php 
                                                                if($value['card_type'] == 'CHECK') {
                                                                    echo $value['card_no'];
                                                                } else if($value['card_type'] == 'CASH'){
                                                                    echo '-';
                                                                } else {
                                                                    echo '****' .substr($value['card_no'], -4);
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td valign="top" width="50%" class="templateColumnContainer" style="padding-right: 20px !important;">
                                <!-- <p class="invoice-to-text">Receipt To</p> -->
                                <?php if(isset($itemlisttype) && !empty($itemlisttype)) {
                                    switch($itemlisttype) {
                                        case 'pos':
                                            if(!empty($msgData['getEmail'][0]['sign'])) { ?>
                                                <img src="<?php echo  base_url(); ?>logo/<?php echo $msgData['getEmail'][0]['sign']; ?>"   style="width: auto; max-width: 100%; max-height: 170px; " onerror="this.outerHTML ='-'" alt="-">
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
                                <p class="item-head">Payment Details</p>
                                <table class="payment-details-table" style="width: 100%">
                                    <tbody>
                                        <?php 
                                        $late_grace_period = $msgData['late_grace_period'];
                                        $payment_date = date('Y-m-d', strtotime($msgData['getEmail_a'][0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
                                        if($msgData['late_fee']) { ?>
                                            <tr>
                                                <td width="50%">Late Fee</td>
                                                <td width="50%" style="text-align: right !important;">$<?= number_format($msgData['late_fee'],2) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php if($msgData['getEmail'][0]['discount']!='' && $msgData['getEmail'][0]['discount']!='0' && $msgData['getEmail'][0]['discount']!="$0.00") {
                                            $discountAmount=($msgData['getEmail'][0]['total_amount']*(int) str_replace('$','',str_replace('%','',$msgData['getEmail'][0]['discount'])) )/100; ?>
                                            <tr>
                                                <td width="50%">Sub Amount</td>
                                                <td width="50%" style="text-align: right !important;">$<?= number_format($msgData['getEmail'][0]['total_amount'],2) ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%">Total Discount</td>
                                                <td width="50%" style="text-align: right !important;">$<?= number_format($discountAmount,2) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php if($msgData['tax']!="" && $msgData['tax'] > 0) { ?>
                                            <tr>
                                                <td width="50%">Tax</td> 
                                                <td width="50%" style="text-align: right !important;"><?php echo (isset($msgData['tax']) && !empty($msgData['tax']))? '$'.number_format($msgData['tax'],2) : "-"; ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <td width="50%">Total Amount</td>
                                            <td width="50%" style="text-align: right !important;">$<?= $msgData['getEmail'][0]['transaction_type'] == 'split' ? number_format($msgData['full_amount'],2) : number_format($msgData['amount'],2) ?></td>
                                        </tr>

                                        <?php if($msgData['getEmail'][0]['transaction_type'] != 'split'){ ?>
                                            <tr>
                                                <td width="50%">Transaction ID</td>
                                                <td width="50%" style="text-align: right !important;"><?= $msgData['trans_a_no'] ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%">Reference</td>
                                                <td width="50%" style="text-align: right !important;"><?php if($msgData['getEmail'][0]['reference'] =='0'){echo 'N/A';}else {echo $msgData['getEmail'][0]['reference']; } ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%">Card Type</td>
                                                <td width="50%" style="text-align: right !important;"><?= !empty($msgData['card_a_type']) ? $msgData['card_a_type'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%">Card Last 4 digits</td>
                                                <td width="50%" style="text-align: right !important;"><?php if(!empty($msgData['card_a_no'])){echo substr($msgData['card_a_no'], -4);} else { ?> &nbsp;&nbsp; <?php } ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php if(!empty($msgData['getEmail'][0]['name_card']) ||  !empty($msgData['getEmail'][0]['name'])){ ?> 
                                            <tr>
                                                <td width="50%">Customer Name</td>
                                                <td width="50%" style="text-align: right !important;"><?php if(!empty($msgData['getEmail'][0]['name_card']) ){echo ucfirst($msgData['getEmail'][0]['name_card']);} elseif(!empty($msgData['getEmail'][0]['name'])){ echo ucfirst($msgData['getEmail'][0]['name']); }else{ ?> &nbsp;&nbsp; <?php } ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td width="50%">Payment Status</td>
                                            <td width="50%" style="text-align: right !important;"><?php if($msgData['message_a']=='confirm' || $msgData['message_a']=='Approved' || $msgData['message_a']=='Chargeback_Confirm' ||  $msgData['getEmail'][0]['status']=='confirm' || $msgData['getEmail'][0]['status']=='Chargeback_Confirm') echo 'Approved'; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
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