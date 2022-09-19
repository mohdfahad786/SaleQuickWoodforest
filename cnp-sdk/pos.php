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

<body style="padding: 0px;margin: 0;font-family: 'Fira Sans', sans-serif;font-size: 16px !important;background-color: #7aabd4;">

<?php
//require_once _DIR_.'/../vendor/autoload.php';
require_once realpath(__DIR__). '/vendor/autoload.php';
#Sale

//   $sql = "select * from merchant";
//   $resilt = mysqli_query($conn,$sql);
//   $rs =  mysqli_fetch_array($resilt);
  
  

  $amount  = number_format($_POST['amount'],0) ;
  $TAX_ID  = $_POST['TAX_ID'] ;
  $TAX_PER  = $_POST['TAX_PER'] ;
  $name  = $_POST['name'] ;
  $address  = $_POST['address'] ;
  $city  = $_POST['city'] ;
  $state  = $_POST['state'] ;
  $zip  = $_POST['zip'] ;
  $card_no  = $_POST['card_no'] ;
  $exp_month  = $_POST['expiry_month'] ;
  $exp_year  = $_POST['expiry_year'] ;
  $card_validation_num  = $_POST['cvv'] ;
  $card_type  = $_POST['card_type'] ;
  $invoice_no = "POS_".date("Ymdhms");
  $email_id  = $_POST['email_id'] ;
  $mobile_no  = $_POST['mobile_no'] ;
  
  
  
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
$saleResponse = $initialize->saleRequest($sale_info);
 
 //print_r($saleResponse);
#display results
//echo ("Response: " . (XmlParser::getNode($saleResponse,'response')) . "<br>");
//echo ("Message: " . XmlParser::getNode($saleResponse,'message') . "<br>");
//echo ("orderId: " . XmlParser::getNode($saleResponse,'orderId') . "<br>");
//echo ("Vantiv Transaction ID: " . XmlParser::getNode($saleResponse,'cnpTxnId'));
if(empty($saleResponse)){
?>

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
}

if(XmlParser::getNode($saleResponse,'message') =='Approved')
{
    ?>
    
    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row">
             <div class="col-md-12 text-center">
             <img style="max-width: 120px" src="https://salequick.com/assets3/img/Tick_240x240.png">
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                   <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600">
                    <span style="color:#000000;"><span style="font-size:24px;">&nbsp;</span></span>
                    <span style="color:null;"><span style="font-size:24px;color: #076547;">Payment Complete</span></span>
                    </h3>
                
            </div>
        </div>
       
        
    </div>
   
    
 
    
    <form action="https://salequick.com/pos/card_payment/" method="POST"  name="myform" id="dateForm" enctype="multipart/form-data" style="padding-top: 150px;"  >
        
          <input type="hidden" class="form-control" name="amount" value="<?php echo $amount ;?>" readonly required>
      <input type="hidden" class="form-control" name="TAX_ID" value='<?php print_r(json_encode($TAX_ID)) ;?>' readonly required>
      <input type="hidden" class="form-control" name="TAX_PER"  value='<?php print_r(json_encode($TAX_PER)) ;?>' readonly required>
       <input type="hidden" class="form-control" name="name" value="<?php echo  $name ;?>" readonly required>
      <input type="hidden" class="form-control" name="address"  value="<?php echo  $address ;?>" readonly required>
       <input type="hidden" class="form-control" name="city" value="<?php echo  $city ;?>" readonly required>
      <input type="hidden" class="form-control" name="state"  value="<?php echo  $state ;?>" readonly required>
       <input type="hidden" class="form-control" name="zip" value="<?php echo  $zip ;?>" readonly required>
      <input type="hidden" class="form-control" name="card_no"  value="<?php echo  $card_no ;?>" readonly required>
       <input type="hidden" class="form-control" name="expiry_month"  value="<?php echo  $exp_month ;?>" readonly required>
       <input type="hidden" class="form-control" name="expiry_year" value="<?php echo  $exp_year;?>" readonly required>
      <input type="hidden" class="form-control" name="cvv"  value="<?php echo  $card_validation_num ;?>" readonly required>
       <input type="hidden" class="form-control" name="card_type" value="<?php echo  $card_type;?>" readonly required>
      <input type="hidden" class="form-control" name="invoice_no"  value="<?php echo  $invoice_no ;?>" readonly required>
       <input type="hidden" class="form-control" name="email_id"  value="<?php echo  $email_id ;?>" readonly required>
       <input type="hidden" class="form-control" name="mobile_no"  value="<?php echo  $mobile_no ;?>" readonly required>


      
      <input type="hidden" class="form-control" name="message" value="<?php echo  XmlParser::getNode($saleResponse,'message') ;?>" readonly required>
      <input type="hidden" class="form-control" name="transaction_id"  value="<?php echo  XmlParser::getNode($saleResponse,'cnpTxnId') ;?>" readonly required>
      <div class="form-group text-center">
          <input  type="submit" name="btnSubmit" style="background: #00dcba;border:1px solid #00dcba;border-radius: 20px;padding: 10px 20px;color:#fff" value="Continue">
      </div>
      
</form>
    
    
<!--  <script type="text/javascript">-->
<!--    //document.getElementById('dateForm').submit(); // SUBMIT FORM-->
    
<!--document.myform.submit();-->
<!--</script>-->

<?php }


if(XmlParser::getNode($saleResponse,'message')!='Approved')
 throw new \Exception('CnpSaleTransaction does not get the right response');
 
 ?>



</body>
</html>