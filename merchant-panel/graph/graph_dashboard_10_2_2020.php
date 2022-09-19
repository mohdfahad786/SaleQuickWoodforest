
<?php 
 
 require_once 'connect.php';
 
 $response = array();

 $user = array(); 

 


$date_c = $_GET['start'];

$date_cc = $_GET['end'];



$employee = $_GET['employee'];

$merchnat = $_GET['employee'];
if($_GET['employee']=='all') {




$stmt = $conn->prepare("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= ? and date_c <= ? and status='confirm'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where date_c > ? and date_c < ? and status='confirm'   union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= ? and date_c <= ? and status='confirm' ) x group by date_c");

 
    $stmt->bind_param("ssssss",$date_c,$date_cc,$date_c,$date_cc,$date_c,$date_cc);





}

elseif($_GET['employee']!='all') {




  $stmt = $conn->prepare("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= ? and date_c <= ? and status='confirm' and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where  date_c >= ? and date_c <= ? and status='confirm' and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= ? and date_c <= ? and status='confirm' and merchant_id= ?  ) x group by date_c");

 
    $stmt->bind_param("sssssssss",$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat);

}

else
{

$stmt = $conn->prepare("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= ? and date_c <= ? and status='confirm' and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where  date_c >= ? and date_c <= ? and status='confirm' and merchant_id= ?  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= ? and date_c <= ? and status='confirm' and merchant_id= ?  ) x group by date_c");

 
    $stmt->bind_param("sssssssss",$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat,$date_c,$date_cc,$merchnat);

}


 $stmt->execute(); 
 
 $stmt->store_result();
 
 if($stmt->num_rows > 0){
 
 $stmt->bind_result($id,$merchant_id,$invoice_no,$Amount,$tax,$fee,$name,$date_c);


 while($stmt->fetch()){
 
 $temp  = array(
 'date'=>$date_c, 
 'amount'=>$Amount, 
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
 'amount'=>"0", 
 'clicks'=>"0", 
 'cost'=>"0", 
 'tax'=>"0", 
 'converted_people'=>"0", 
 'revenue'=>"0", 
 'linkcost'=>"0", 

 
 );
  array_push($user, $temp);



 

}



$response = $user;




// $sql = "SELECT * FROM customer_payment_request ";
// $result = $conn->query($sql);
 
// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {

//        $temp  = array(

//  'date'=>$date_c, 
//  'people'=>$row['merchant_id'], 
//  'clicks'=>$row['invoice_no'],
//  'cost'=>$row['tax'],
//  'conversions'=>$row['amount'], 
//  'converted_people'=>$row['name'],
//  'revenue'=>"", 
//  'linkcost'=>"", 



 
//  );

//     }

// } 
// else {

//      $temp  = array(
        
//  'date'=>$date_c, 
//  'people'=>"0", 
//  'clicks'=>"0", 
//  'cost'=>"0", 
//  'conversions'=>"0", 
//  'converted_people'=>"0", 
//  'revenue'=>"0", 
//  'linkcost'=>"0", 

 
//  );
// }

//  array_push($user, $temp);

// $response = $user; 


  echo json_encode($response);

 ?>

