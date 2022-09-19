<?php 
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }
  class Settlement_backup extends CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
      $this->load->library('form_validation');
      $this->load->model('Home_model');
      $this->load->model('login_model');
      $this->load->model('Admin_model');
      $this->load->library('email');
      $this->load->library('twilio');
      date_default_timezone_set("America/Chicago");
      //ini_set('display_errors', 1);
        //error_reporting(E_ALL);
    }

public function token2()
   {
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.integritypays.com/v1/auth',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "userName":"Salequicksettlement",
    "password":"MS756a@^mOgd"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: ss-opt=temp; X-UAId=55; ss-id=LQ7uqPWlYbxGDVCYGoj6; ss-pid=3zvYDBtC6FcnjaUysxQs'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

//bearerToken
            //$test = json_encode($parsed);
            $response_p = json_decode($response, true);
            $bearerToken = $response_p['bearerToken'];

            // Second Api

          

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.integritypays.com/v1/settlement/403903455400044?StartDate=10/18/21&EndDate=10/20/21',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$bearerToken,
    'Cookie: ss-opt=temp; X-UAId=55; ss-id=BcM5bFcLXMvgtbPjTMOX; ss-pid=GqiuqxSFC3ldTynTuukC'
  ),
));

$response_batch_detail = curl_exec($curl);
curl_close($curl);
$response_batch_detail_p = json_decode($response_batch_detail, true);
return $response_batch_detail_p['batches'];
//print_r($response_batch_detail_p['batches']);

   }
   public function token()
   {
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.integritypays.com/v1/auth',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "userName":"Salequicksettlement",
    "password":"MS756a@^mOgd"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: ss-opt=temp; X-UAId=55; ss-id=LQ7uqPWlYbxGDVCYGoj6; ss-pid=3zvYDBtC6FcnjaUysxQs'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

//bearerToken
            //$test = json_encode($parsed);
            $response_p = json_decode($response, true);
            $bearerToken = $response_p['bearerToken'];
            return $bearerToken;

            // Second Api

          
//print_r($response_batch_detail_p['batches']);

   }


   public function payment()

   {
     $start = $this->uri->segment(3);
 $limit = $this->uri->segment(4);
$getQuery_m = $this->db->query("SELECT id,pax_pos_mid from merchant where pax_pos_mid!='' limit $start,$limit  ");
                $getEmail_m = $getQuery_m->result_array();
               // print_r($getEmail_m);
                //$key = array();
    foreach($getEmail_m as $getEmail_mm)
    {
     
    $mid = $getEmail_mm['pax_pos_mid'];
   echo $merchant_id = $getEmail_mm['id'];
     // array_push($key, $getEmail_mm);

    
      $cday = date("m/d/y", strtotime("-5 days"));
     echo $dday = date("m/d/y", strtotime("-1 days"));
    // echo $dday = '12/27/2021';
     //print_r($key);
//$age=array("Peter"=>"35","Ben"=>"37","Joe"=>"43","Harry"=>"50");
//print_r(array_chunk($age,2,true));
     //Array ( [0] => Array ( [Peter] => 35 [Ben] => 37 ) [1] => Array ( [Joe] => 43 [Harry] => 50 ) )

    //$mid = $this->uri->segment(3);
    //$merchant_id = $this->uri->segment(4);
    $token =$this->token();
    //print_r($token);

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.integritypays.com/v1/settlement/'.$mid.'?StartDate='.$dday.'&EndDate='.$dday,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$token,
    'Cookie: ss-opt=temp; X-UAId=55; ss-id=BcM5bFcLXMvgtbPjTMOX; ss-pid=GqiuqxSFC3ldTynTuukC'
  ),
));

$response_batch_detail = curl_exec($curl);
curl_close($curl);
$response_batch_detail_p = json_decode($response_batch_detail, true);
 $response_batch_detail_p['batches'];

    
     foreach($response_batch_detail_p['batches'] as $token_detail)
    {
     
      $batchId= $token_detail['batchId'];
   


  //$batchId = $this->uri->segment(3);
  //  $mid = $this->uri->segment(4);
  // $mid = '403903455400051';
  $url ='https://api.integritypays.com/v1/settlement/'.$mid.'/batch/'.$batchId;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.integritypays.com/v1/settlement/'.$mid.'/batch/'.$batchId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo  $response;
$response_batch_detail_p = json_decode($response, true);
 //echo '<pre>'; print_r($response_batch_detail_p); 
//print_r($response_batch_detail_p['batchDetails']);
 $batchDetails=$response_batch_detail_p['batchDetails'];
 foreach($batchDetails as $batchDetails_s)
    {
     echo '<pre>';
  // [transactionType] => Capture
       print_r($batchDetails_s);
   echo $auth_code= $batchDetails_s['authorizationCode'];
  
    $getQuery = $this->db->query("SELECT id,auth_code,amount from pos where merchant_id ='" . $merchant_id . "' and auth_code  ='" . $auth_code . "' ");
                $getEmail = $getQuery->result_array();

                 $getQuery1 = $this->db->query("SELECT id,auth_code,amount from customer_payment_request where merchant_id ='" . $merchant_id . "' and auth_code  ='" . $auth_code . "' ");
                $getEmail1 = $getQuery1->result_array();

                $getQuery2 = $this->db->query("SELECT id,auth_code,amount from refund where merchant_id ='" . $merchant_id . "' and auth_code  ='" . $auth_code . "' ");
                $getEmail2 = $getQuery2->result_array();

                //print_r($getEmail);
                //pos_settlement
                if(empty($getEmail) && empty($getEmail1) && empty($getEmail2) )
                {
echo 'Not  available';

$year = date("Y");
$month = date("m");
$transactionDate=$batchDetails_s['transactionDate'];
$var = explode('T', $transactionDate); 
$new_date =$var[0];
//$new_date = date("Y-m-d", strtotime("-1 days"));
$cur_new_date = $new_date.' 15:32:53';

$getQuery_insert = $this->db->query("INSERT INTO `pos_settlement` (`id`, `merchant_id`, `sub_merchant_id`, `sub_merchant_name`, `invoice_no`, `qb_online_invoice_id`, `amount`, `sentamount`, `sub_total`, `tax`, `protector_tax`, `fee`, `other_charges`, `otherChargesName`, `tax_id`, `tax_per`, `discount`, `total_amount`, `tip_amount`, `full_amount`, `p_ref_amount`, `partial_refund`, `cashbackAmount`, `balanceAmount`, `transaction_type`, `cvv`, `name`, `mobile_no`, `email_id`, `re_mobile_no`, `re_email_id`, `receipt_type`, `card_no`, `card_no1`, `expiry_month`, `expiry_year`, `title`, `detail`, `due_date`, `payment_date`, `type`, `time1`, `day1`, `time_type`, `month`, `year`, `sign`, `ip`, `reference`, `transaction_guid`, `pos_entry_mode`, `transaction_id`, `client_transaction_id`, `auth_code`, `card_type`, `status`, `date_c`, `date_r`, `acquirer_data`, `approval_number`, `bin`, `batch`, `card`, `address`, `card_logo`, `credit_cardsaleresponse`, `express_responsecode`, `express_responsemessage`, `express_transactiondate`, `express_transactiontime`, `express_transactiontimezone`, `hostbatch_amount`, `hostbatch_id`, `hostitem_id`, `hostresponse_code`, `hostreversal_queueid`, `hosttransaction_id`, `processor_name`, `reference_number`, `reference_numb_opay`, `response_cnp`, `transaction`, `transaction_id_cnp`, `transaction_status`, `transaction_statuscode`, `c_type`, `add_date`, `payment_type`, `split_payment_id`, `processorTimestamp`, `processorTimezone`, `deviceTimestamp`, `deviceTimezone`, `paymentServiceTimestamp`, `paymentServiceTimezone`, `chainID`, `storeID`, `terminalID`, `version`, `serialNumber`, `adv_pos_exc`, `pos_type`, `app_type`, `wasProcessedOnline`, `transactionDateTime`, `qb_status`, `woocommerce`, `pax_json`, `rawRequest`, `rawResponse`, `applicationId`, `cryptogram`, `applicationLabel`, `applicationPreferredName`, `hostResponseCode`, `expressResponseCode`, `expressResponseMessage`, `lati`, `longi`) VALUES (NULL, '" . $merchant_id . "', '" . $merchant_id . "', NULL, '".$batchDetails_s['transactionId']."', '0', '".$batchDetails_s['transactionAmount']."', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', '0', '0.00', '0.00', 'full', NULL, NULL, NULL, NULL, NULL, NULL, 'no-cepeipt', '".$batchDetails_s['humanReadableCardNumber']."', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '".$month."', '".$year."', NULL, NULL, NULL, NULL, NULL, '".$batchDetails_s['transactionId']."', NULL, '".$batchDetails_s['authorizationCode']."', '".$batchDetails_s['cardType']."', 'confirm', '".$new_date."', NULL, NULL, NULL, '0', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, 'Approved', NULL, 'PAX', '".$cur_new_date."', 'app', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '0', 'no', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL) ");
                }
                else
                {
echo 'Available';
                }

    }


   }

    }
    
     }



  }