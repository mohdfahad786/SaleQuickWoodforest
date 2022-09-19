<?php 
 require_once 'connect.php';
 $response = array();
 $user = array(); 
 $date_c = $_GET['start'];
 $date_cc = $_GET['end'];
 $merchnat = $_GET['merchant'];
 //$fee = $_GET['fee'];
 $employee = $_GET['employee'];
if($_GET['employee']=='all') {

 $stmt = $conn->prepare("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(p_ref_amount) as p_ref_amount,sum(tax) as tax,avg(amount) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from customer_payment_request where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from recurring_payment where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,tax,amount,p_ref_amount,name,date_c from pos where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and merchant_id= ?  ) x group by date_c");

    $stmt->bind_param("sssssssss",$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat);
    
}

elseif($_GET['employee']=='merchent') {

	$stmt = $conn->prepare("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(p_ref_amount) as p_ref_amount,sum(tax) as tax,avg(amount) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from customer_payment_request where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and sub_merchant_id='0' and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from recurring_payment where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and sub_merchant_id='0' and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from pos where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and sub_merchant_id='0' and merchant_id= ?  ) x group by date_c");

 
    $stmt->bind_param("sssssssss",$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat);

}

else
{


 $stmt = $conn->prepare("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(p_ref_amount) as p_ref_amount,sum(tax) as tax,avg(amount) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from customer_payment_request where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and sub_merchant_id=? and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from recurring_payment where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and sub_merchant_id=? and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from pos where date_c >= ? and date_c <= ? and (status='confirm' or partial_refund=1) and sub_merchant_id=? and merchant_id= ?  ) x group by date_c");

 
    $stmt->bind_param("ssssssssssss",$date_c,$date_cc,$employee,$merchnat,$date_c,$date_cc,$employee,$merchnat,$date_c,$date_cc,$employee,$merchnat);

}


 $stmt->execute();
 
 $stmt->store_result();
 
 if($stmt->num_rows > 0){
 
 $stmt->bind_result($id,$merchant_id,$invoice_no,$amount,$p_ref_amount,$tax,$fee,$name,$date_c);


 while($stmt->fetch()){
 
 $temp  = array(
 'date'=>$date_c, 
 'amount'=>$amount-$p_ref_amount, 
  'clicks'=>$tax,
 'cost'=>$fee,
 'tax'=>$tax,
 'converted_people'=>$tax,
 'revenue'=>$tax, 
 'linkcost'=>$tax,
 
 );
  array_push($user, $temp);
 }

}

else
{


$user = array(); 
 
 
 $temp  = array(
 'date'=>$date_c, 
 'people'=>"0", 
 'clicks'=>"0", 
 'cost'=>"0", 
 'conversions'=>"0", 
 'converted_people'=>"0", 
 'revenue'=>"0", 
 'linkcost'=>"0", 

 
 );
  array_push($user, $temp);


}

$response = $user;
echo json_encode($response);

 ?>

