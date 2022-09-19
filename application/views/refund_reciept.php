<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>:: Receipt ::</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    
    <!-- Facebook Pixel Code -->

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
.invoice-wrap {
    display: table;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    max-width: 972px;
    background-color: #fff;
    box-shadow: 0px -2px 17px -2px #7b7b7b;
    -moz-box-shadow: 0px -2px 17px -2px #7b7b7b;
    -webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;
    width: 100%;
    margin: 0 auto;
}

.main-box {
    width: 100%;
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
        -webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
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
.receipt_wraper{
    text-align: left;
    float: left;
    width: 100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 15px 0;
}
.receipt-rcol, .receipt-lcol {
    padding: 0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.receipt-rcol{
    padding-left:15px;
}
.table-row p{
    float: left;
    width: 100%;
    margin-bottom: 7px;
}
.table-row p span {
    line-height: 1.432;
}
.table-row{
    max-width: 475px;width: 100%;font-size: 14px;  float: right;
    display: table;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.table-row::after,.table-row::before{
    content: "";clear: both;display: table;
}
.bottom-div {
    display: inline-block;
    float: left;
    padding: 20px 40px;
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
    .main-box{padding: 51px 15px 10px;}
}
@media only screen and (max-width:651px){
    .receipt-rcol, .receipt-lcol {
        max-width: 100%;width: 100% !important;
    }
    .receipt-rcol{
        padding: 21px 0 0;
    }
    .receipt-rcol>*,.receipt-rcol table{
        float: none !important;
        margin: 0 auto;
        max-width: 100% !important;
    }
}
@media only screen and (min-width:481px) and (max-width:768px) {
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
        <div class="invoice-wrap" id="printableArea">
            <div class="top-div">
                <div class="float-left">
                    <?php 
                     if ( $itemm[0]['logo'] ) { ?>
                      <p><img src="<?=base_url();?>logo/<?php  echo $itemm[0]['logo']; ?>"  style="height: auto;max-width: 221px;max-height: 85px;width: auto;"></p>
                     
                     <?php }
                     else
                     {  
                        
                         ?>
                     <div style="display: inline-block; height: 51px; width: 51px; border-radius: 50%; border: 1px solid lightgray; text-transform: uppercase; background-color: white; color: #444; line-height: 51px; text-align: center; font-size: 25px;"><?php    if($itemm[0]['name']) echo ucfirst(substr($itemm[0]['name'],0,1)); ?></div>
                     <?php }
                  ?>
                <h4 style="margin-bottom: 0px;font-size: 16px;"><?php  echo $getEmail1[0]['business_dba_name']; ?></h4>
                <p style="margin-top: 0px;"><?php echo $getEmail1[0]['website']; ?></p>
                <p><span style="color:#333;">Telephone:</span> <?php echo $getEmail1[0]['business_number']; ?></p>
                </div>
                <div class="float-right">
                    <h3 style="text-transform: uppercase;margin-bottom: 0;font-size: 19px;">Refund Receipt</h3>
                    <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
                    <p style="line-height: 20px;margin-top: 10px">
                        <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
                        <span style="display: block;"><?php echo $invoice_no ;?></span></p>
                    <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Refund Date</span>
                        <span style="display: block;"><?php $originalDate = $date_c;
                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></span></p>
                </div>
            </div>
            <div class="bottom-div">
               <!--  Item List Section Start -->
            <div class="receipt_wraper" >
             <div  class="receipt-lcol" style="text-align: left;float: left;width: 50%;">
                <div class="sixty-div">
                    <h4 style="font-size: 14px;margin-top: 7px;">Invoice To</h4>
                    <p style="text-transform: uppercase;color: #333;"><?php echo $name  ;?></p>
                </div>
                 <?php if(isset($sign)) {?>
                  <img src="<?php echo  $sign; ?>"  style="width: auto;height:auto;max-width: 100%;max-height: 198px;"/>
                 <?php }?>
                  <div style="width: 100%;float: left;display: inline-block; font-style:italic;line-height: 20px;margin-top: 7px;">
                    <small style="float:left;display: inline-block;width:100%;color: #878787;text-transform:uppercase;">* i agree to pay above total amount according to the cardholder agreement (Merchant agreement if credit voucher)</small>
                     <small style="color: #878787;text-transform:uppercase;">** important - please retain this copy for your records</small>
                  </div>
             </div> 
             <div class="receipt-rcol" style="text-align: left;float: left;width: 50%;">   
                <?php  $itemLength=count(json_decode($item[0]['quantity']));
                    if($itemLength > 0 ) { 
                        ?>
                        <table style="max-width: 475px;width: 100%;font-size: 14px;  float: right;" cellspacing="0">
                            <thead>
                                <tr>
                                    <td colspan="2" style="font-weight: 600;padding: 7px 0;">All Items</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // echo $itemLength;
                               $tax=0.0;
                                $totalAmt=0.0;
                                for($i=0; $i<$itemLength;  $i++)
                                { 
                                    //json_decode($myJSON);
                                    $quantity=json_decode($item[0]['quantity']);
                                    $price=json_decode($item[0]['price']);
                                    //$tax=json_decode($item[0]['tax']);
                                    $tax_id=json_decode($item[0]['tax_id']);
                                    $tax_per=json_decode($item[0]['tax_per']);
                                    $total_amount=json_decode($item[0]['total_amount']);
                                    $item_name=json_decode($item[0]['item_name']);
                                    $totalAmt+=$total_amount[$i]; 
                                    $tax=$tax+$tax[$i];
                                    ?>
                                    <tr>
                                        <td style="padding: 5px 1px;border-top: 1px solid rgba(236, 236, 236, 0.7); width: 70%;"><?=$item_name[$i]; ?></td>
                                        <td style="padding: 5px 1px;width: 70%;text-align: right;font-weight: 600;border-top: 1px solid rgba(236, 236, 236, 0.7);color: #353535;"> <?php echo '$ '.number_format($total_amount[$i],2); ?></td>
                                    </tr>
                                <?php    }  ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="padding: 7px 1px;border-top: 1px solid #ddd;">
                                        <b>Total : </b>
                                    </td>
                                    <td style="padding: 7px 1px;text-align: right;font-weight: 600;border-top: 1px solid #ddd;">
                                     <?php
                                       $subttl1= $amount;
                                       $subttl2= $tax; 
                                        // settype($subttl1,float);
                                        // settype($subttl2,float);
                                     echo '$ '.number_format(($subttl1 - $subttl2),2);
                                     ?>
                                 </td>
                             </tr>
                             <?php if($tax!="" && $tax > 0  ) { ?>
                             <tr>
                                <td style="padding: 7px 1px;">
                                    <b>Tax :</b>
                                </td>
                                <td style="padding: 7px 1px;text-align: right;font-weight: 600;">
                                 <?php echo (isset($tax))? '$ '.$tax: "-"; ?>
                             </td>
                         </tr>
                             <?php } ?>
                     </tfoot>
                    </table>
                    <?php } 
                    
                    ?>

                    <div class="table-row">  <!--class="fourty-div"-->
                        <h4>Payment Details</h4>
                        <p>
                            <span class="left-div">Total Amount :</span>
                            <span class="right-div"> $<?php echo number_format($amount,2)  ;?></span>
                        </p>
                        <!-- <p>
                        <span class="left-div">Total Refund Amount </span>
                        <span class="right-div">$ <?php 
                         $totalAmt=0.0;
                         foreach($refundData as $item) {  $totalAmt+=$item['amount'];  }
                        echo number_format($totalAmt,2); ?></span>
                        </p> -->
                    
                        
                        <p>
                            <span class="left-div">Card Type :</span>
                            <span class="right-div"> <?php if(!empty($card_type)){echo $card_type;} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
                        </p>
                        <p>
                            <span class="left-div">Last 4 digits on card :</span>
                            <span class="right-div"> <?php if(!empty($card_no)){echo substr($card_no, -4);;} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
                        </p>
                        <?php if(!empty($name_card)){ ?> 
                        <p>
                            <span class="left-div">Name on Card :</span>
                            <span class="right-div"><?php if(!empty($name_card)){echo ucfirst($name_card);} else { ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> </span>
                        </p>
                        <?php } ?>

                    </div>

                    <div style="text-align: left;float: left;width: 100%;">   <?php 
                    $itemLength=count($refundData);
                    if($itemLength > 0 ) { 
                        ?>
                        <table style="max-width: 475px;width: 100%;font-size: 14px;  float: right;" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="2" style="font-size: 12px; padding-top: 11px; ">Refunds</th> </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="33.33%" style="text-align:left; padding: 7px 0;color:#353535;">
                                        Date
                                    </td>
                                    <td width="33.33%" style="text-align:center; padding: 7px 0;color:#353535;">
                                        Transaction Id
                                    </td>
                                    <td  style="text-align:right; padding: 7px 0;color:#353535;">
                                        Amount
                                    </td>
                                </tr>
                                <?php
                                $totalAmt=0.0;
                                foreach($refundData as $item)
                                { 
                                   
                                    $totalAmt+=$item['amount']; 
                                   
                                    ?>
                                    <tr>
                                        <td style="padding: 7px 0;color:#353535;">
                                            <?php 
                                                echo date("F d, Y", strtotime($item['date_c']));
                                                ?></td>
                                        <td style="padding: 4px 0 7px; text-align: center"> <?php echo ($item['transaction_id']) ? $item['transaction_id'] :'-'; ?></td> <td style="text-align:right;"><?php echo $item['amount'] ? '$'.number_format($item['amount'],2):'-'; ?></td>
                                    </tr>
                                <?php    }  ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="padding: 7px 1px;border-top: 1px solid #ddd; ">
                                        <b>Total Refund Amount </b>
                                    </td>
                                    <td style="padding: 7px 1px;text-align: right;font-weight: 600;border-top: 1px solid #ddd;">
                                     <?php
                                     echo $totalAmt ? '$'.number_format($totalAmt,2):'-';
                                     ?>
                                 </td>
                             </tr>
                             
                     </tfoot>
                    </table>
                    <?php } 
                    
                    ?>
                    </div>
            </div>
            </div>
            </div>
            <div class="bottom-div">
                <div style="width: 100%;float: left;display: inline-block;">
                <a href="" id="printButton" class="custom-btn" onclick="printDiv('printableArea')" style="margin-left: 5px;">Print</a>
                </div>
            </div>
        </div>
       <div class="footer-wraper" >
        <div >
            <div class="footer_address" style="float: left;">
                <span style="display: block;"><?php echo $itemm[0]['business_dba_name']   ;?></span>
                <span style="display: inline-block;color:#666"><?php echo $itemm[0]['address1']   ;?> </span>
            </div>
            <div class="footer_t_c" style="display: inline-block;vertical-align: middle;padding-top: 7px;">
                <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2">Powered by SaleQuick.com </a>
            </div>
             <div class="footer_cards" style="float: right;">
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon1.jpg'); ?>" alt="" class="" /></a>
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon2.jpg'); ?>" alt="" class="" /></a>
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon3.jpg'); ?>" alt="" class="" /></a>
                <a style="text-decoration: none;color:#666;" href="#"><img src="<?php echo base_url('front/invoice/img/foot_icon4.jpg'); ?>" alt="" class="" /></a>
            </div>
        </div>
    </div>
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