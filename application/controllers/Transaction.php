<?php 
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }
  class Transaction extends CI_Controller {
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

public function index()
   {
   

$curl = curl_init();
echo $dday = date("Y-m-d", strtotime("-1 days"));

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.infinicept.com/api/salequick/transactions/paginated?PageSize=1000&includeTotalCount=true&SpecificDate='.$dday,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-AuthenticationKeyId: 1625b631-3928-4b08-2a5d-08d988ebffe9',
    'x-AuthenticationKeyValue: DTw1PnWoesjSJATao8VJnZ5bOuxc5rZune6TdRxwfAaoCydiqkwTbUUJSBxnKc0t',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_pp = json_decode($response, true);
//print_r($response_pp);
foreach($response_pp['transactions'] as $response_p)
    {
//  echo '<pre>';
 //print_r($response_p);

$var = explode('T', $response_p['transactionDate']); 
$transactionDate =$var[0];

$orderdate = explode('-', $transactionDate);
$year = $orderdate[0];
$month   = $orderdate[1];


$var1 = explode('T', $response_p['transactionSettledDate']); 
$settlement_date =$var1[0];
$amount = number_format($response_p['authorizationAmount'],2);
$revenue= number_format($amount*3/100,2);


$getQuery_insert = $this->db->query("INSERT INTO `infinicept_transaction` (`infinicept_id`, `processorTransactionID`, `onHold`, `merchant_id`, `merchant_name`, `sub_merchant_id`, `sub_merchant_name`, `transactionDate`,`month`,`year`, `authorizationCode`, `authorizationAmount`,`amount`, `transactionAmount`,  `revenue`,`buy_rate`,  `interchangeFee`, `networkFees`, `processorFee`, `assessmentFee`, `payfacFee`, `chargebackFee`, `commissionFee`, `processedDate`, `totalFees`, `netAmount`, `mid`, `achReturnFee`, `transactionSettledDate`,`settlement_date`, `date_c`, `status`, `merchant_id_update`) VALUES ('".$response_p['id']."','".$response_p['processorTransactionID']."', '".$response_p['onHold']."', NULL,  '".$response_p['submerchantName']."', '".$response_p['submerchantId']."', '".$response_p['submerchantDbaName']."', '".$transactionDate."','".$month."','".$year."', '".$response_p['authorizationCode']."', '".$response_p['authorizationAmount']."','".$response_p['authorizationAmount']."', '".$response_p['transactionAmount']."', '".$revenue."', '0.00', '".$response_p['interchangeFee']."', '".$response_p['networkFees']."', '".$response_p['processorFee']."', '".$response_p['assessmentFee']."', '".$response_p['payfacFee']."', '".$response_p['chargebackFee']."','".$response_p['commissionFee']."', '".$response_p['processedDate']."', '".$response_p['totalFees']."', '".$response_p['netAmount']."', '".$response_p['processorMID']."', '".$response_p['achReturnFee']."', '".$response_p['transactionSettledDate']."','".$settlement_date."', '".$transactionDate."','confirm','0') ");
//echo $this->db->last_query();die;
}

}


public function update()
{

   $getQuery = $this->db->query("SELECT id,pax_pos_mid from merchant where pax_pos_mid !='' ");
   $getMerchant = $getQuery->result_array();
    
    foreach($getMerchant as $getMerchant_p)
    {
      

      $this->db->query("UPDATE `infinicept_transaction` SET `merchant_id`='".$getMerchant_p['id']."',`merchant_id_update`='1' WHERE `mid`='".$getMerchant_p['pax_pos_mid']."'  and `merchant_id_update`='0' ");

       //echo  $this->db->last_query();  die("my query");
     }

}



}