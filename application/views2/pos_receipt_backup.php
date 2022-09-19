<!DOCTYPE html>

<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->

<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="SaleQuick">
<meta name="keywords" content="SaleQuick">
<meta name="author" content="SaleQuick">

<!-- Title -->

<title>:: Sale Quick ::</title>

<!-- Favicon Icon -->

<link rel="icon" type="image/png" href="https://salequick.com/front1/images/logo-w.png">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
<style>
.data-grid > div{
    width: 100% !important;
}
.table {
    font-family: 'Fira Sans', sans-serif;
}
.table-striped>tbody>tr:nth-of-type(odd) {
/* background-color: #7aabd4;*/
   
}
th {
    text-align: right;
    font-weight: normal !important;
}
.midle {
    width: 80%;
    margin: 0 auto;
}
.midle3 {
    width: 80%;
    margin: 0 auto;
}
.midle2 {
    width: 60%;
}

.midle4 {
    width: 280px;
    margin: 0 auto; 
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    /*border: 1px solid #7aabd4;*/
    border: none !important;
    border-bottom: 1px solid #eee !important;
    font-size: 16px;
    font-weight: 400;
    margin-left: 30px;
    margin-top: 10px;
    margin-bottom: 10px;
    color: #000;
}
.input1 {
    width: 30%;
}
.table-bordered>tbody>tr>th {
    text-align: right;
    color: #868484;
    font-size: 18px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.table-bordered {
    border: none !important;
}


.payment_icon{ 
    background:url(https://salequick.com/email/images/payment_icon2.png); 
    background-repeat:no-repeat; 
    /*background-position:right center;*/
    background-position: 90% 53%; 
    padding-right: 76px !important;
}





 @media screen and (max-width: 600px) {
.midle {
    width: 100%
}
.midle3 {
    width: 100%
}
.midle2 {
    width: 100%
}

.midle4 {
    width: 100%
    margin: 0 auto; 
}
.input1 {
    width: 45%;
}
.Item_Name {
    max-width: 60px;
    word-wrap: break-word;
    word-break: break-word;
    white-space: unset;
}
.img_mobile{
    width: 100% !important;
}
.img_mobile img{
    width: 100% !important;
}

}
</style>
</head>

<body style="padding: 0px;margin: 0;font-family: 'Fira Sans', sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
<div style="max-width: 900px;margin: 0 auto;">
<div style="color:#fff;">
<div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">
<div class="midle" style="">
        <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 5px;">
                        <img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>" style="width: calc(84px - 10px);height: calc(84px - 10px);
    margin-top: 0px;
    border-radius: 50%;" />

                    </div>

<h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600">$<?php echo number_format($amount,2)  ;?><br />
<span style="color:#000000;"><span style="font-size:24px;">&nbsp;</span></span><span style="color:null;"><span style="font-size:24px;color: #076547;">Payment Complete</span></span></h3>
</div>
</div>

<div style="background-color: #437ba8;overflow: hidden;">
    
<div  style="width:80%;text-align:right;margin:20px auto;">

<?php if($transaction_id !='') {?>


<!---for desktop only -->
<div class="hidden-xs hidden-sm" style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">
<div style="width:14%;float:left;text-align:center"><span>Invoice No</span></div>
<div style="width:14%;float:left;text-align:center"><span>Date </span></div>
<div style="width:14%;float:left;text-align:center"><span>Amount</span></div>

<div style="width:16%;float:left;text-align:center"><span>Transaction id </span></div>

<div style="width:14%;float:left;text-align:center"><span>Reference </span></div>
<div style="width:14%;float:left;text-align:center"><span>Card Type</span></div>
<div style="width:14%;float:left;text-align:center"><span>Last 4 of card</span></div>

</div>



<?php } else { ?>
<div style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">
<div style="width:33.3%;float:left;text-align:center"><span>Invoice No</span></div>
<div style="width:33.3%;float:left;text-align:center"><span>Date </span></div>
<div style="width:33.3%;float:left;text-align:center"><span>Amount</span></div>
</div>
<?php }  ?>
<!--<div style="clear:both">&nbsp;</div>-->

<!--<hr style="margin-top: 5px; margin-bottom: 10px; border: 0; border-top: 1px solid #eee;" />-->
<?php if($transaction_id !='') {?>


<div class="hidden-xs hidden-sm" style="display:block;margin-bottom:25px;overflow: hidden;">
<div style="width:14%;float:left;text-align:center"><span><?php echo $invoice_no ;?></span></div>

<div style="width:14%;float:left;text-align:center"><span><?php echo $date_c ;?></span></div>

<div style="width:14%;float:left;text-align:center"><span>$<?php echo number_format($amount,2)  ;?> </span></div>

<div style="width:16%;float:left;text-align:center"><span><?php echo $transaction_id ;?></span></div>

<div style="width:14%;float:left;text-align:center"><span><?php  if($reference =='0'){echo 'N/A';}else {echo $reference; } ?></span></div>
<div style="width:14%;float:left;text-align:center"><span><?php echo $card_type ;?></span></div>
<div style="width:14%;float:left;text-align:center"><span><?php echo substr($card_no, -4); ;?> </span></div>



</div>

<!---end desktop --->





<?php } else { ?>
<div style="display:block;margin-bottom:25px;overflow: hidden;">
<div style="width:33.3%;float:left;text-align:center"><span><?php echo $invoice_no ;?></span></div>

<div style="width:33.3%;float:left;text-align:center"><span><?php echo $date_c ;?></span></div>

<div style="width:33.3%;float:left;text-align:center"><span>$<?php echo number_format($amount,2)  ;?> </span></div>
</div>
<?php }  ?>

<!--// for mobile //-->
<div class="visible-xs visible-sm data-grid" style="display:block;margin-bottom:25px;overflow: hidden;">
<div style="width:14%;float:left;text-align:center"><span><b>Invoice No : </b> <?php echo $invoice_no ;?></span></div>

<div style="width:14%;float:left;text-align:center"><span><b>Date : </b> <?php echo $date_c ;?></span></div>

<div style="width:14%;float:left;text-align:center"><span><b>Amount : </b> $<?php echo number_format($amount,2)  ;?> </span></div>

<div style="width:16%;float:left;text-align:center"><span><b>Transaction id: </b> <?php echo $transaction_id ;?></span></div>

<div style="width:14%;float:left;text-align:center"><span><b>Reference : </b> <?php  if($reference =='0'){echo 'N/A';}else {echo $reference; } ?></span></div>
<div style="width:14%;float:left;text-align:center"><span><b>Card Type : </b> <?php echo $card_type ;?></span></div>
<div style="width:14%;float:left;text-align:center"><span><b>Last 4 of card : </b> <?php echo substr($card_no, -4); ;?> </span></div>



</div>
<!---end --mobile only -->


<!--<?php if($transaction_id !='') {?>-->

<!--<div style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">-->

<!--<div style="width:33.3%;float:left;text-align:center"><span>Card Type</span></div>-->
<!--<div style="width:33.3%;float:left;text-align:center"><span>Reference </span></div>-->
<!--<div style="width:33.3%;float:left;text-align:center"><span>Last 4 of card</span></div>-->
<!--</div>-->

<!--<div style="clear:both">&nbsp;</div>-->

<!--<hr style="margin-top: 5px; margin-bottom: 10px; border: 0; border-top: 1px solid #eee;" />-->

<!--<div style="display:block;margin-bottom:25px;overflow: hidden;">-->
    
<!--   <div style="width:33.3%;float:left;text-align:center"><span><?php echo $card_type  ;?> </span></div>-->
    
<!--<div style="width:33.3%;float:left;text-align:center"><span><?php  if($reference =='0'){echo 'N/A';}else {echo $reference; } ?></span></div>-->

<!--<div style="width:33.3%;float:left;text-align:center"><span><?php echo substr($card_no, -4); ;?></span></div>-->


<!--</div>-->
<!--<?php } ?>-->

</div>
</div>
</div>

<div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
<div style="width:80%;margin:0 auto;overflow:hidden">
<div class="img_mobile" style="width:60%;margin:10px auto 20px;text-align:center" class="img-responsive"><img src="https://salequick.com/logo/<?php echo $sign ?>" style="margin:0px auto;" /></div>

<hr style="margin-top: 5px; margin-bottom: 20px; border: 0; border-top: 1px solid #eee;" />
<div style="clear:both">&nbsp;</div>
</div>
</div>

<footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
<div style="text-align:center;width:80%;margin:0 auto">
    
    <h3 style="margin-top: 10px; margin-bottom: 10px;font-size:22px;font-weight:400;">APPROVED</h3>
    
    <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</h5>

<h4 style="margin-top: 10px; margin-bottom: 10px;font-size:20px;font-weight:400;">Customer Copy</h4>

<h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">IMPORTANT - Please retain this copy for your records .</h5>



<p><a style="color:#4a91f9;cursor:pointer;"><?php echo $itemm[0]['email']; ?></a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;"><?php echo $itemm[0]['mob_no']; ?></a></p>

<p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
<p style="text-align:right"><a href="https://salequick.com/terms_and_condition">Terms</a>&nbsp;|<a href="https://salequick.com/privacy_policy">Privacy</a></p>
</div>
</footer>
</div>
</body>
</html>
