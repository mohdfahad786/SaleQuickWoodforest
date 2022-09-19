<?php
namespace cnp\sdk;
 require_once 'connect.php';
//require_once _DIR_.'/../vendor/autoload.php';
require_once realpath(__DIR__). '/vendor/autoload.php';
 
 $id  = $_POST['id'] ;

 $invoice_no  = $_POST['invoice_no'] ;
 $amount  = $_POST['amount'] ;
 
# standalone credit
$credit_info = array(
        'id'=>  $id,
	'card'=>array('type'=>'VI',
			'number'=>'4100000000000001',
			'expDate'=>'1213',
			'cardValidationNum' => '1213'),
        'orderSource'=>'ecommerce',
        'orderId'=>$invoice_no,
        'amount'=> $amount
	);
 
$initialize = new CnpOnlineRequest();
$creditResponse = $initialize->creditRequest($credit_info);
 
#display results

//echo ("Response: " . (XmlParser::getNode($creditResponse,'response')) . "<br>");
//echo ("Message: " . XmlParser::getNode($creditResponse,'message') . "<br>");
//echo ("Vantiv Transaction ID: " . XmlParser::getNode($creditResponse,'cnpTxnId'));

if(XmlParser::getNode($creditResponse,'message') =='Approved')
{
    $result = $conn->query("UPDATE customer_payment_request SET status ='Chargeback_Confirm' WHERE id ='".$id."' ");

}

if(XmlParser::getNode($creditResponse,'message')!='Approved')
 throw new \Exception('CnpRefundTransaction does not get the right response');
 
//header("Location: https://salequick.com/pos/all_customer_request");
?>

<form action="https://salequick.com/pos/all_customer_request" method="POST"  name="myform" id="dateForm" style="display:none;">
 
  <input  type="submit" name="btnSubmit">
</form>
    
  <script type="text/javascript">
    //document.getElementById('dateForm').submit(); // SUBMIT FORM
    
    document.myform.submit();
</script>
