<?php
namespace cnp\sdk;
 require_once 'connect.php';
 ?>
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

<link rel="icon" type="image/png" href="img/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
<style>
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
     /*background:url(https://salequick.com/email/images/payment_icon2.png); */
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


}
</style>
</head>

<body style="padding: 0px;margin: 0;font-family: 'Fira Sans', sans-serif;font-size: 16px !important;background-color: #7aabd4;>
<div style="max-width: 1600px;margin: 0 auto;">
  <div style="color:#fff;">
    <div style="padding-top: 40px;">
      <div class="midle" style="">
    <img style="margin-left: 270px;" src="https://salequick.com/assets3/img/tenor.gif">
        	 <!--<h3 style="text-align: center; border-radius: 50%; margin: 10px auto 20px; padding: 10px;"><div class="alert alert-success text-center"> Payment  Process   </div></h3>-->
	</div>
<div style="clear:both"></div>
</div>
</div>

</div>

<?php

//require_once _DIR_.'/../vendor/autoload.php';
require_once realpath(__DIR__). '/vendor/autoload.php';
#Sale

//   $sql = "select * from merchant";
//   $resilt = mysqli_query($conn,$sql);
//   $rs =  mysqli_fetch_array($resilt);
  
  

  $amount  = $_POST['amount'] ;
  $invoice_no  = $_POST['invoice_no'] ;
  $name  = $_POST['name'] ;
  $address  = $_POST['address'] ;
  $city  = $_POST['city'] ;
  $state  = $_POST['state'] ;
  $zip  = $_POST['zip'] ;
  $card_no  = $_POST['card_no'] ;
  $exp_month  = $_POST['exp_month'] ;
  $exp_year  = $_POST['exp_year'] ;
  $card_validation_num  = $_POST['card_validation_num'] ;
  $card_type  = $_POST['card_type'] ;
  
  
  
$sale_info = array(
                'orderId' => $invoice_no,
                      'id'=> '456',
          'amount' =>  $amount,
          'orderSource'=>'ecommerce',
          'billToAddress'=>array(
          'name' => $name,
          'addressLine1' => $address,
          'city' => $city,
          'state' =>$state,
          'zip' => $zip,
          'country' => 'US'),
          'card'=>array(
          'number' =>$card_no,
          'expDate' => $exp_month.$exp_year,
          'cardValidationNum' =>  $card_validation_num,
          'type' => '')
      );
 
$initialize = new CnpOnlineRequest();
$authResponse = $initialize->authorizationRequest($sale_info);


if(XmlParser::getNode($authResponse,'message') =='Approved')
{ 
 $saleResponse = $initialize->saleRequest($sale_info);

 //print_r($saleResponse);
#display results
//echo ("Response: " . (XmlParser::getNode($saleResponse,'response')) . "<br>");
//echo ("Message: " . XmlParser::getNode($saleResponse,'message') . "<br>");
//echo ("orderId: " . XmlParser::getNode($saleResponse,'orderId') . "<br>");
//echo ("Vantiv Transaction ID: " . XmlParser::getNode($saleResponse,'cnpTxnId'));


if(XmlParser::getNode($saleResponse,'message') =='Approved')
{
    ?>
    
<form action="https://salequick.com/payment_cnp/<?php echo  $_POST['bct_id1'] ;?>/<?php echo  $_POST['bct_id2'] ;?>" method="POST"  name="myform" id="dateForm" style="display:none;">
  <input type="hidden" class="form-control" name="bct_id" value="<?php echo $_POST['bct_id'] ;?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id1" value="<?php echo  $_POST['bct_id1'] ;?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo  $_POST['bct_id2'] ;?>" readonly required>
      
      <input type="text" class="form-control" name="message" value="<?php echo  XmlParser::getNode($saleResponse,'message') ;?>" readonly required>
      <input type="text" class="form-control" name="transaction_id"  value="<?php echo  XmlParser::getNode($saleResponse,'cnpTxnId') ;?>" readonly required>
       <input type="text" class="form-control" name="card_type"  value="<?php echo   $card_type ;?>" readonly required>
       <input type="text" class="form-control" name="card_no"  value="<?php echo   $card_no ;?>" readonly required>
      
  <input  type="submit" name="btnSubmit">
</form>
    
  <script type="text/javascript">
    //document.getElementById('dateForm').submit(); // SUBMIT FORM
    
    document.myform.submit();
</script>
<?php }


if(XmlParser::getNode($saleResponse,'message')!='Approved')
 throw new \Exception('CnpSaleTransaction does not get the right response');
 
}

else
{
    echo ("Message: " . XmlParser::getNode($saleResponse,'message') . "<br>");  
}
?>



</body>
</html>