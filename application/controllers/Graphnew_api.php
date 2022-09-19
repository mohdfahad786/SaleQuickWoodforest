<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . 'third_party/REST_Controller.php';
//require APPPATH . 'third_party/Format.php';
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
//use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class Graphnew_api extends REST_Controller {
    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
    $this->load->model('admin_model');
    $this->load->library('email');
        $this->load->library('twilio');
    }
    
private function verify_request()
{
    // Get all the headers
    $headers = $this->input->request_headers();
    
    //print_r($headers); die();
    // Extract the token
    //$token = $headers['Authorization'];
     $token = $headers['X-Requested-With'];
    
    // Use try-catch
    // JWT library throws exception if the token is not valid
    try {
        // Validate the token
        // Successfull validation will return the decoded user data else returns false
        $data = AUTHORIZATION::validateToken($token);
        if ($data === false) {
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
            $this->response($response, $status);
            exit();
        } else {
            return $data;
        }
    } catch (Exception $e) {
        // Token is invalid
        // Send the unathorized access message
        $status = parent::HTTP_UNAUTHORIZED;
        $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
        $this->response($response, $status);
    }
}


public function dashboard_graph_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {

$response = array();
$user = array(); 
$user1 = array(); 
$user2 = array(); 
$user7 = array(); 
$user10 = array(); 
$user13 = array(); 
$user16 = array(); 
$user100 = array(); 
$user101 = array(); 
$merchant = $_POST['merchant_id'];
$date_c = $_POST['start'];
$date_cc = $_POST['end'];
// $employee = $_POST['employee'];
 $employee = strtolower($_POST['employee']);
// echo $merchant_id.','.$merchant.','.$employee;die();
$today2 = date("Y");
$last_year = date("Y",strtotime("-1 year")); 
//$stmt = $this->db->query("SELECT title FROM other_charges WHERE status='active' and merchant_id='".$merchant."' ");
$stmt_ch = $this->db->query("SELECT title FROM `other_charges` WHERE merchant_id='".$merchant_id."'  ");
$getItem = $stmt_ch->result_array();
$title = $getItem[0]['title'];
	if (!empty($title)) {
            $title=$title;
		
	} else {
			 $title = '';
	}
			
 
if($employee=='all') {

$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."'  ) x group by date_c");
 


$stmt1 = $this->db->query("SELECT 
              (SELECT sum(amount) as TotalAmount from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmount ,
              (SELECT sum(amount) as TotalAmountRe from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountRe ,
              (SELECT sum(amount) as TotalAmountPOS from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountPOS
  ");
 


$stmta = $this->db->query("SELECT 
            (SELECT sum(amount) as TotalAmountdetail from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountdetail ,
            (SELECT sum(amount) as TotalAmountRedetail from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountRedetail ,
            (SELECT sum(amount) as TotalAmountPOSdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountPOSdetail,
            (SELECT sum(fee) as TotalAmountdetailfee from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountdetailfee ,
            (SELECT sum(fee) as TotalAmountRedetailfee from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountRedetailfee ,
            (SELECT sum(fee) as TotalAmountPOSdetailfee from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountPOSdetailfee,
            (SELECT sum(tax) as TotalAmountdetailtax from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountdetailtax ,
            (SELECT sum(tax) as TotalAmountRedetailtax from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountRedetailtax ,
            (SELECT sum(tax) as TotalAmountPOSdetailtax from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountPOSdetailtax,
            (SELECT sum(amount) as refund from refund where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as refund,
            (SELECT sum(tip_amount) as TotalTipdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' )   and merchant_id='".$merchant."' ) as TotalTipdetail ,
            (SELECT sum(tip_amount) as TotalRefundTipdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='Chargeback_Confirm'  and merchant_id='".$merchant."' ) as TotalRefundTipdetail,
            (SELECT sum(other_charges) as TotalChargedetail from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalChargedetail ,
            (SELECT sum(other_charges) as TotalChargeRedetail from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalChargeRedetail ,
            (SELECT sum(other_charges) as TotalChargePOSdetailt from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalChargePOSdetailt
			
  ");
 

 
}
elseif($employee=='merchent') {

    
    $stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."'  ) x group by date_c");
   
    
    $stmt1 = $this->db->query("SELECT 
 (SELECT sum(amount) as TotalAmount from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmount ,
              (SELECT sum(amount) as TotalAmountRe from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountRe ,
              (SELECT sum(amount) as TotalAmountPOS from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountPOS");
 
   
$stmta = $this->db->query("SELECT 
            (SELECT sum(amount) as TotalAmountdetail from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountdetail ,
            (SELECT sum(amount) as TotalAmountRedetail from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountRedetail ,
            (SELECT sum(amount) as TotalAmountPOSdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountPOSdetail,
            (SELECT sum(fee) as TotalAmountdetailfee from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountdetailfee ,
            (SELECT sum(fee) as TotalAmountRedetailfee from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountRedetailfee ,
            (SELECT sum(fee) as TotalAmountPOSdetailfee from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as TotalAmountPOSdetailfee,
            (SELECT sum(tax) as TotalAmountdetailtax from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountdetailtax ,
            (SELECT sum(tax) as TotalAmountRedetailtax from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountRedetailtax ,
            (SELECT sum(tax) as TotalAmountPOSdetailtax from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalAmountPOSdetailtax,
            (SELECT sum(amount) as refund from refund where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and merchant_id='".$merchant."' ) as refund,
            (SELECT sum(tip_amount) as TotalTipdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' )  and merchant_id='".$merchant."' ) as TotalTipdetail ,
            (SELECT sum(tip_amount) as TotalRefundTipdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='Chargeback_Confirm'  and merchant_id='".$merchant."' ) as TotalRefundTipdetail,
            (SELECT sum(other_charges) as TotalChargedetail from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalChargedetail ,
            (SELECT sum(other_charges) as TotalChargeRedetail from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalChargeRedetail ,
            (SELECT sum(other_charges) as TotalChargePOSdetailt from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and merchant_id='".$merchant."' ) as TotalChargePOSdetailt			
  ");

 
 
    
}
else
{

 
$stmt = $this->db->query("SELECT id,sub_merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,sub_merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."'  union all SELECT id,sub_merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."'  union all SELECT id,sub_merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."'  ) x group by date_c");
 


$stmt1 = $this->db->query("SELECT 
              (SELECT sum(amount) as TotalAmount from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as TotalAmount ,
              (SELECT sum(amount) as TotalAmountRe from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as TotalAmountRe ,
              (SELECT sum(amount) as TotalAmountPOS from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as TotalAmountPOS
  ");
 


$stmta = $this->db->query("SELECT 
            (SELECT sum(amount) as TotalAmountdetail from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalAmountdetail ,
            (SELECT sum(amount) as TotalAmountRedetail from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalAmountRedetail ,
            (SELECT sum(amount) as TotalAmountPOSdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalAmountPOSdetail,
            (SELECT sum(fee) as TotalAmountdetailfee from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as TotalAmountdetailfee ,
            (SELECT sum(fee) as TotalAmountRedetailfee from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as TotalAmountRedetailfee ,
            (SELECT sum(fee) as TotalAmountPOSdetailfee from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as TotalAmountPOSdetailfee,
            (SELECT sum(tax) as TotalAmountdetailtax from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalAmountdetailtax ,
            (SELECT sum(tax) as TotalAmountRedetailtax from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalAmountRedetailtax ,
            (SELECT sum(tax) as TotalAmountPOSdetailtax from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalAmountPOSdetailtax,
            (SELECT sum(amount) as refund from refund where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='confirm' and sub_merchant_id='".$employee."' ) as refund,
            (SELECT sum(tip_amount) as TotalTipdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' )   and sub_merchant_id='".$employee."' ) as TotalTipdetail ,
            (SELECT sum(tip_amount) as TotalRefundTipdetail from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and status='Chargeback_Confirm'  and sub_merchant_id='".$employee."' ) as TotalRefundTipdetail,
            (SELECT sum(other_charges) as TotalChargedetail from customer_payment_request where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalChargedetail ,
            (SELECT sum(other_charges) as TotalChargeRedetail from recurring_payment where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalChargeRedetail ,
            (SELECT sum(other_charges) as TotalChargePOSdetailt from pos where date_c >='".$date_c."' and date_c <='".$date_cc."' and (status='confirm' OR status='Chargeback_Confirm' ) and sub_merchant_id='".$employee."' ) as TotalChargePOSdetailt
			
  ");
 

 
}


$stmt7 = $this->db->query("SELECT (SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where   merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where   merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm' )x group by month ) as Totaljan ,
(SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm' )x group by month ) as Totalfeb  ,
(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where   merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm' )x group by month ) as Totalmarch,
(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm' )x group by month ) as Totalaprl  ,
(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm' )x group by month ) as Totalmay,
(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm' )x group by month ) as Totaljune  ,
(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm' )x group by month ) as Totaljuly,
(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm' )x group by month ) as Totalaugust  ,
(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm' )x group by month ) as Totalsep,
(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm' )x group by month ) as Totaloct  ,
(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = ' 11' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = ' 11' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = ' 11' and year='".$today2."' and status='confirm' )x group by month ) as Totalnov,
(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm' )x group by month ) as Totaldec  ,
(SELECT sum(tax) as Totaljant from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm' )x group by month ) as Totaljant ,
(SELECT sum(tax) as Totalfebt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm' )x group by month ) as Totalfebt  ,
(SELECT sum(tax) as Totalmarcht from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm' )x group by month ) as Totalmarcht,
(SELECT sum(tax) as Totalaprlt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm' )x group by month ) as Totalaprlt  ,
(SELECT sum(tax) as Totalmayt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm' )x group by month ) as Totalmayt,
(SELECT sum(tax) as Totaljunet from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm' )x group by month ) as Totaljunet  ,
(SELECT sum(tax) as Totaljulyt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm' )x group by month ) as Totaljulyt,
(SELECT sum(tax) as Totalaugustt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm' )x group by month ) as Totalaugustt  ,
(SELECT sum(tax) as Totalsept from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm' )x group by month ) as Totalsept,
(SELECT sum(tax) as Totaloctt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm' )x group by month ) as Totaloctt  ,
(SELECT sum(tax) as Totalnovt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = ' 11' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = ' 11' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = ' 11' and year='".$today2."' and status='confirm' )x group by month ) as Totalnovt,
(SELECT sum(tax) as Totaldect from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm' )x group by month ) as Totaldect  ,
(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '01' and year='".$today2."' and status='confirm' )x group by month ) as Totaljanf ,
(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '02' and year='".$today2."' and status='confirm' )x group by month ) as Totalfebf  ,
(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '03' and year='".$today2."' and status='confirm' )x group by month ) as Totalmarchf,
(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '04' and year='".$today2."' and status='confirm' )x group by month ) as Totalaprlf  ,
(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '05' and year='".$today2."' and status='confirm' )x group by month ) as Totalmayf,
(SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '06' and year='".$today2."' and status='confirm' )x group by month ) as Totaljunef  ,
(SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '07' and year='".$today2."' and status='confirm' )x group by month ) as Totaljulyf,
(SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '08' and year='".$today2."' and status='confirm' )x group by month ) as Totalaugustf  ,
(SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '09' and year='".$today2."' and status='confirm' )x group by month ) as Totalsepf,
(SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '10' and year='".$today2."' and status='confirm' )x group by month ) as Totaloctf  ,
(SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '11' and year='".$today2."' and status='confirm' )x group by month ) as Totalnovf,
(SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '12' and year='".$today2."' and status='confirm' )x group by month ) as Totaldecf  
  "); 
 
 
 
$stmt4 = $this->db->query("SELECT (SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljan ,
(SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm' )x group by month ) as Totalfeb  ,
(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm' )x group by month ) as Totalmarch,
(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm' )x group by month ) as Totalaprl  ,
(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm' )x group by month ) as Totalmay,
(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljune  ,
(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljuly,
(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm' )x group by month ) as Totalaugust  ,
(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm' )x group by month ) as Totalsep,
(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm' )x group by month ) as Totaloct  ,
(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm' )x group by month ) as Totalnov,
(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm' )x group by month ) as Totaldec  ,
(SELECT sum(tax) as Totaljant from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljant ,
(SELECT sum(tax) as Totalfebt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm' )x group by month ) as Totalfebt  ,
(SELECT sum(tax) as Totalmarcht from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm' )x group by month ) as Totalmarcht,
(SELECT sum(tax) as Totalaprlt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm' )x group by month ) as Totalaprlt  ,
(SELECT sum(tax) as Totalmayt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm' )x group by month ) as Totalmayt,
(SELECT sum(tax) as Totaljunet from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljunet  ,
(SELECT sum(tax) as Totaljulyt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljulyt,
(SELECT sum(tax) as Totalaugustt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm' )x group by month ) as Totalaugustt  ,
(SELECT sum(tax) as Totalsept from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm' )x group by month ) as Totalsept,
(SELECT sum(tax) as Totaloctt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm' )x group by month ) as Totaloctt  ,
(SELECT sum(tax) as Totalnovt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm' )x group by month ) as Totalnovt,
(SELECT sum(tax) as Totaldect from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm' )x group by month ) as Totaldect  ,
(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '01' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljanf ,
(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '02' and year='".$last_year."' and status='confirm' )x group by month ) as Totalfebf  ,
(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '03' and year='".$last_year."' and status='confirm' )x group by month ) as Totalmarchf,
(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '04' and year='".$last_year."' and status='confirm' )x group by month ) as Totalaprlf  ,
(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '05' and year='".$last_year."' and status='confirm' )x group by month ) as Totalmayf,
(SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '06' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljunef  ,
(SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '07' and year='".$last_year."' and status='confirm' )x group by month ) as Totaljulyf,
(SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '08' and year='".$last_year."' and status='confirm' )x group by month ) as Totalaugustf  ,
(SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '09' and year='".$last_year."' and status='confirm' )x group by month ) as Totalsepf,
(SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '10' and year='".$last_year."' and status='confirm' )x group by month ) as Totaloctf  ,
(SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '11' and year='".$last_year."' and status='confirm' )x group by month ) as Totalnovf,
(SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '12' and year='".$last_year."' and status='confirm' )x group by month ) as Totaldecf  
  "); 
 
 
  $getStmt = $stmt->result_array();
  $id = $getStmt[0]['id'];

 if(!empty($id)){
  $id = $getStmt[0]['id'];
  $merchant_id = $getStmt[0]['merchant_id'];
  $invoice_no = $getStmt[0]['invoice_no'];
  $amount = $getStmt[0]['amount'];
  $tax = $getStmt[0]['tax'];
  $fee = $getStmt[0]['fee'];
  $name = $getStmt[0]['name'];
  $date_c = $getStmt[0]['date_c'];
 

  $getStmt1 = $stmt1->result_array();
 
  $TotalAmount = $getStmt1[0]['TotalAmount'];
  $TotalAmountRe = $getStmt1[0]['TotalAmountRe'];
  $TotalAmountPOS = $getStmt1[0]['TotalAmountPOS'];

  $getStmta = $stmta->result_array();

$TotalAmountdetail = $getStmta[0]['TotalAmountdetail'];
$TotalAmountRedetail = $getStmta[0]['TotalAmountRedetail'];
$TotalAmountPOSdetail = $getStmta[0]['TotalAmountPOSdetail'];
$TotalAmountdetailfee = $getStmta[0]['TotalAmountdetailfee'];
$TotalAmountRedetailfee = $getStmta[0]['TotalAmountRedetailfee'];
$TotalAmountPOSdetailfee = $getStmta[0]['TotalAmountPOSdetailfee'];
$TotalAmountdetailtax = $getStmta[0]['TotalAmountdetailtax'];
$TotalAmountRedetailtax = $getStmta[0]['TotalAmountRedetailtax'];
$TotalAmountPOSdetailtax = $getStmta[0]['TotalAmountPOSdetailtax'];
$refund = $getStmta[0]['refund'];
$tip = $getStmta[0]['TotalTipdetail'];
//$tipRefunded = $getStmta[0]['tipRefunded'];
$tipRefunded = 0;
$TotalChargedetail = $getStmta[0]['TotalChargedetail'];
$TotalChargeRedetail = $getStmta[0]['TotalChargeRedetail'];
$TotalChargePOSdetailt = $getStmta[0]['TotalChargePOSdetailt'];


$mem = array();
foreach ($getStmt as $each) {
 
 $temp  = array(
 'date'=>$each['date_c'], 
 'amount'=>number_format($each['amount'],2,'.',''), 
  'fee'=>number_format($each['fee'],2,'.',''),
 'tax'=>number_format($each['tax'],2,'.',''),
 
 );
  //array_push($user, $temp);
  $mem[] = $temp;
 }
 $user=$mem;

  if($TotalAmount+$TotalAmountRe+$TotalAmountPOS ==0)
  {
  
 $user1 = array(
     
 'Direct'=>number_format(0.00), 
 'Recur'=>number_format(0.00), 
 'Pos'=>number_format(0.00), 
 
 );
  }
  else
  {
      
      $user1 = array(
     
     
 'Direct'=>number_format($TotalAmount/($TotalAmount+$TotalAmountRe+$TotalAmountPOS)*100,2,'.',''), 
 'Recur'=>number_format($TotalAmountRe/($TotalAmount+$TotalAmountRe+$TotalAmountPOS)*100,2,'.',''), 
 'Pos'=>number_format($TotalAmountPOS/($TotalAmount+$TotalAmountRe+$TotalAmountPOS)*100,2,'.',''), 
 
 
 );
  }
  $tipRefunded=0;

  	if($title!=''){
 $user100 = array(
  array(
    'type'=>'amount',
    'sale_amount'=>number_format(($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail - ($tip+$TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax+$TotalChargedetail +$TotalChargeRedetail+$TotalChargePOSdetailt)),2,'.',''), 
    'refunds_amount'=>number_format(($refund - $tipRefunded),2,'.',''),
    'net_amount'=>number_format((($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail) - $refund -($tip+$TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax+$TotalChargedetail +$TotalChargeRedetail+$TotalChargePOSdetailt)),2,'.',''), 
),
  array(
     'type'=>'tax',
 'sale_tax'=>number_format(($TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax),2,'.',''),
 'refunds_tax'=>number_format((0),2,'.',''),
 'net_tax'=>number_format(($TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax),2,'.','')
),
 array(
    'type'=>'tip',
    'sale_tip'=>number_format(($tip),2,'.',''),
    'refunds_tip'=>number_format(($tipRefunded),2,'.',''), 
    'net_tip'=>number_format(($tip-$tipRefunded),2,'.','')
 
),
    array(
         'type'=>$title,
     'sale_otherCharges'=>number_format(($TotalChargedetail +$TotalChargeRedetail+$TotalChargePOSdetailt),2,'.',''),
     'refunds_otherCharges'=>number_format((0),2,'.',''),
     'net_otherCharges'=>number_format(($TotalChargedetail +$TotalChargeRedetail+$TotalChargePOSdetailt),2,'.',''),
    
    ),
  array(
     'type'=>'Total',
  
  'sale_total'=>number_format((($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail)  ),2,'.',''),
 'refunds_total'=>number_format(($refund),2,'.',''),

   'net_total'=>number_format((($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail)  - $refund ),2,'.','')
),
 );
 
  	}
  	
  	else
  	{
  	     $user100 = array(
  array(
    'type'=>'amount',
    'sale_amount'=>number_format(($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail - ($tip+$TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax)),2,'.',''), 
    'refunds_amount'=>number_format(($refund - $tipRefunded),2,'.',''),
    'net_amount'=>number_format((($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail) - $refund -($tip+$TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax)),2,'.',''), 
),
  array(
     'type'=>'tax',
 'sale_tax'=>number_format(($TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax),2,'.',''),
 'refunds_tax'=>number_format((0),2,'.',''),
 'net_tax'=>number_format(($TotalAmountdetailtax +$TotalAmountRedetailtax+$TotalAmountPOSdetailtax),2,'.','')
),
 array(
    'type'=>'tip',
    'sale_tip'=>number_format(($tip),2,'.',''),
    'refunds_tip'=>number_format(($tipRefunded),2,'.',''), 
    'net_tip'=>number_format(($tip-$tipRefunded),2,'.','')
 
),
   
  array(
     'type'=>'Total',

  'sale_total'=>number_format((($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail)  ),2,'.',''),
 'refunds_total'=>number_format(($refund),2,'.',''),

   'net_total'=>number_format((($TotalAmountdetail+$TotalAmountRedetail+$TotalAmountPOSdetail)  - $refund ),2,'.','')
),
 );
  	}

$getStmt7 = $stmt7->result_array();
 
$Totaljan = $getStmt7[0]['Totaljan'];
$Totalfeb = $getStmt7[0]['Totalfeb'];
$Totalmarch = $getStmt7[0]['Totalmarch'];
$Totalaprl = $getStmt7[0]['Totalaprl'];
$Totalmay = $getStmt7[0]['Totalmay'];
$Totaljune = $getStmt7[0]['Totaljune'];
$Totaljuly = $getStmt7[0]['Totaljuly'];
$Totalaugust = $getStmt7[0]['Totalaugust'];
$Totalsep = $getStmt7[0]['Totalsep'];
$Totaloct = $getStmt7[0]['Totaloct'];
$Totalnov = $getStmt7[0]['Totalnov'];
$Totaldec = $getStmt7[0]['Totaldec'];

$Totaljant = $getStmt7[0]['Totaljant'];
$Totalfebt = $getStmt7[0]['Totalfebt'];
$Totalmarcht = $getStmt7[0]['Totalmarcht'];
$Totalaprlt = $getStmt7[0]['Totalaprlt'];
$Totalmayt = $getStmt7[0]['Totalmayt'];
$Totaljunet = $getStmt7[0]['Totaljunet'];
$Totaljulyt = $getStmt7[0]['Totaljulyt'];
$Totalaugustt = $getStmt7[0]['Totalaugustt'];
$Totalsept = $getStmt7[0]['Totalsept'];
$Totaloctt = $getStmt7[0]['Totaloctt'];
$Totalnovt = $getStmt7[0]['Totalnovt'];
$Totaldect = $getStmt7[0]['Totaldect'];    

$Totaljanf = $getStmt7[0]['Totaljanf'];
$Totalfebf = $getStmt7[0]['Totalfebf'];
$Totalmarchf = $getStmt7[0]['Totalmarchf'];
$Totalaprlf = $getStmt7[0]['Totalaprlf'];
$Totalmayf = $getStmt7[0]['Totalmayf'];
$Totaljunef = $getStmt7[0]['Totaljunef'];
$Totaljulyf = $getStmt7[0]['Totaljulyf'];
$Totalaugustf = $getStmt7[0]['Totalaugustf'];
$Totalsepf = $getStmt7[0]['Totalsepf'];
$Totaloctf = $getStmt7[0]['Totaloctf'];
$Totalnovf = $getStmt7[0]['Totalnovf'];
$Totaldecf = $getStmt7[0]['Totaldecf'];


 $user7 = array(
 array( 
 'amount'=>number_format($Totaljan,2,'.',''),
 'date'=>'January',
 'tax'=>number_format($Totaljant,2,'.',''),
  'fee'=>number_format($Totaljanf,2,'.','')),
 array('amount'=>number_format($Totalfeb,2,'.',''),
 'date'=>'February',
 'tax'=>number_format($Totalfebt,2,'.',''),
 'fee'=>number_format($Totalfebf,2,'.','')), 
 array('amount'=>number_format($Totalmarch,2,'.','') ,
 'date'=>'March',
 'tax'=>number_format($Totalmarcht,2,'.','') ,
 'fee'=>number_format($Totalmarchf,2,'.','') ),
 array('amount'=>number_format($Totalaprl,2,'.',''),
 'date'=>'April',
 'tax'=>number_format($Totalaprlt,2,'.',''),
 'fee'=>number_format($Totalaprlf,2,'.','')),
 array('amount'=>number_format($Totalmay,2,'.',''),
 'date'=>'May',
 'tax'=>number_format($Totalmayt,2,'.',''),
 'fee'=>number_format($Totalmayf,2,'.','')), 
 array('amount'=>number_format($Totaljune,2,'.','') ,
 'date'=>'June',
 'tax'=>number_format($Totaljunet,2,'.','') ,
 'fee'=>number_format($Totaljunef,2,'.','') ),
 array('amount'=>number_format($Totaljuly,2,'.',''),
  'date'=>'July',
 'tax'=>number_format($Totaljulyt,2,'.',''),
 'fee'=>number_format($Totaljulyf,2,'.','') ),
 array('amount'=>number_format($Totalaugust,2,'.',''), 
 'date'=>'August',
 'tax'=>number_format($Totalaugustt,2,'.',''), 
 'fee'=>number_format($Totalaugustf,2,'.','') ), 
 array('amount'=>number_format($Totalsep,2,'.','') ,
 'date'=>'September',
 'tax'=>number_format($Totalsept,2,'.','') ,
 'fee'=>number_format($Totalsepf,2,'.','')) ,
 array('amount'=>number_format($Totaloct,2,'.',''),
 'date'=>'October',
 'tax'=>number_format($Totaloctt,2,'.',''),
 'fee'=>number_format($Totaloctf,2,'.','') ),
 array('amount'=>number_format($Totalnov,2,'.',''),
 'date'=>'November',
 'tax'=>number_format($Totalnovt,2,'.',''),
 'fee'=>number_format($Totalnovf,2,'.','') ), 
 array('amount'=>number_format($Totaldec,2,'.','') ,
 'date'=>'December',
  'tax'=>number_format($Totaldect,2,'.','') ,
  'fee'=>number_format($Totaldecf,2,'.','') )
 );
 

 $getStmt4 = $stmt4->result_array();
 
$Totaljan4 = $getStmt4[0]['Totaljan'];
$Totalfeb4 = $getStmt4[0]['Totalfeb'];
$Totalmarch4 = $getStmt4[0]['Totalmarch'];
$Totalaprl4 = $getStmt4[0]['Totalaprl'];
$Totalmay4 = $getStmt4[0]['Totalmay'];
$Totaljune4 = $getStmt4[0]['Totaljune'];
$Totaljuly4 = $getStmt4[0]['Totaljuly'];
$Totalaugust4 = $getStmt4[0]['Totalaugust'];
$Totalsep4 = $getStmt4[0]['Totalsep'];
$Totaloct4 = $getStmt4[0]['Totaloct'];
$Totalnov4 = $getStmt4[0]['Totalnov'];
$Totaldec4 = $getStmt4[0]['Totaldec'];

$Totaljant4 = $getStmt4[0]['Totaljant'];
$Totalfebt4 = $getStmt4[0]['Totalfebt'];
$Totalmarcht4 = $getStmt4[0]['Totalmarcht'];
$Totalaprlt4 = $getStmt4[0]['Totalaprlt'];
$Totalmayt4 = $getStmt4[0]['Totalmayt'];
$Totaljunet4 = $getStmt4[0]['Totaljunet'];
$Totaljulyt4 = $getStmt4[0]['Totaljulyt'];
$Totalaugustt4 = $getStmt4[0]['Totalaugustt'];
$Totalsept4 = $getStmt4[0]['Totalsept'];
$Totaloctt4 = $getStmt4[0]['Totaloctt'];
$Totalnovt4 = $getStmt4[0]['Totalnovt'];
$Totaldect4 = $getStmt4[0]['Totaldect'];    

$Totaljanf4 = $getStmt4[0]['Totaljanf'];
$Totalfebf4 = $getStmt4[0]['Totalfebf'];
$Totalmarchf4 = $getStmt4[0]['Totalmarchf'];
$Totalaprlf4 = $getStmt4[0]['Totalaprlf'];
$Totalmayf4 = $getStmt4[0]['Totalmayf'];
$Totaljunef4 = $getStmt4[0]['Totaljunef'];
$Totaljulyf4 = $getStmt4[0]['Totaljulyf'];
$Totalaugustf4 = $getStmt4[0]['Totalaugustf'];
$Totalsepf4 = $getStmt4[0]['Totalsepf'];
$Totaloctf4 = $getStmt4[0]['Totaloctf'];
$Totalnovf4 = $getStmt4[0]['Totalnovf'];
$Totaldecf4 = $getStmt4[0]['Totaldecf'];


 $user4 = array(
  array( 
 'amount'=>number_format($Totaljan4,2,'.',''),
 'date'=>'January',
 'tax'=>number_format($Totaljant4,2,'.',''),
  'fee'=>number_format($Totaljanf4,2,'.','')),
 array('amount'=>number_format($Totalfeb4,2,'.',''),
 'date'=>'February',
 'tax'=>number_format($Totalfebt4,2,'.',''),
 'fee'=>number_format($Totalfebf4,2,'.','')), 
 array('amount'=>number_format($Totalmarch4,2,'.','') ,
 'date'=>'March',
 'tax'=>number_format($Totalmarcht4,2,'.','') ,
 'fee'=>number_format($Totalmarchf4,2,'.','') ),
 array('amount'=>number_format($Totalaprl4,2,'.',''),
 'date'=>'April',
 'tax'=>number_format($Totalaprlt4,2,'.',''),
 'fee'=>number_format($Totalaprlf4),2,'.',''),
 array('amount'=>number_format($Totalmay4,2,'.',''),
 'date'=>'May',
 'tax'=>number_format($Totalmayt4,2,'.',''),
 'fee'=>number_format($Totalmayf4,2,'.','')), 
 array('amount'=>number_format($Totaljune4,2,'.','') ,
 'date'=>'June',
 'tax'=>number_format($Totaljunet4,2,'.','') ,
 'fee'=>number_format($Totaljunef4,2,'.','') ),
 array('amount'=>number_format($Totaljuly4,2,'.',''),
  'date'=>'July',
 'tax'=>number_format($Totaljulyt4,2,'.',''),
 'fee'=>number_format($Totaljulyf4,2,'.','') ),
 array('amount'=>number_format($Totalaugust4,2,'.',''), 
 'date'=>'August',
 'tax'=>number_format($Totalaugustt4,2,'.',''), 
 'fee'=>number_format($Totalaugustf4,2,'.','') ), 
 array('amount'=>number_format($Totalsep4,2,'.','') ,
 'date'=>'September',
 'tax'=>number_format($Totalsept4,2,'.','') ,
 'fee'=>number_format($Totalsepf4,2,'.','')) ,
 array('amount'=>number_format($Totaloct4,2,'.',''),
 'date'=>'October',
 'tax'=>number_format($Totaloctt4,2,'.',''),
 'fee'=>number_format($Totaloctf4,2,'.','') ),
 array('amount'=>number_format($Totalnov4,2,'.',''),
 'date'=>'November',
 'tax'=>number_format($Totalnovt4,2,'.',''),
 'fee'=>number_format($Totalnovf4,2,'.','') ), 
 array('amount'=>number_format($Totaldec4,2,'.','') ,
 'date'=>'December',
  'tax'=>number_format($Totaldect4,2,'.','') ,
  'fee'=>number_format($Totaldecf4,2,'.','') )
 );
 
 $status = parent::HTTP_OK;
 $response['status'] = $status; 
 $response['successMsg'] = 'successfull'; 
 $response['Sales_Chart'] = $user; 
 $response['Order_Chart'] = $user1;
 
 $response['Year_Chart'] = $user7;
 $response['Lat_Year_Chart'] = $user4;
 $response['Detail_Chart'] = $user100;
 
    //  echo $employee;die();
    if($employee == 'all') {
        // $all_employee = $this->db->get_where('merchant', array('merchant_id' => $merchant, 'status' => 'active'))->result_array();
        $all_employee = $this->db->query("SELECT id as empId, name as empName FROM merchant WHERE merchant_id = ".$merchant)->result_array();
    } else {
        // $all_employee = $this->db->get_where('merchant', array('id' => $employee, 'status' => 'active'))->result_array();
        $all_employee = $this->db->query("SELECT id as empId, name as empName FROM merchant WHERE id = ".$employee)->result_array();
    }
    //  echo '<pre>';print_r($all_employee);die();
    foreach ($all_employee as $i => $employee) {
        // $tip_query = $this->db->query("SELECT SUM(tip_amount) as total_tip FROM `pos` WHERE `sub_merchant_id` = ". $employee['id']. " `AND date_c` ")->result();
        $tip_query = $this->db->query("SELECT SUM(tip_amount) as total_tip FROM `pos` WHERE `sub_merchant_id` = ". $employee['empId']. " AND `date_c` >= '".$date_c."' AND `date_c` <= '".$date_cc."' AND (status='confirm' OR status='Chargeback_Confirm')")->result();
        $tip_refund_query = $this->db->query("SELECT SUM(tip_amount) as total_refund_tip FROM `customer_payment_request` WHERE `sub_merchant_id` = ". $employee['empId']. " AND `date_c` >= '".$date_c."' AND `date_c` <= '".$date_cc."' AND (status='confirm' OR status='Chargeback_Confirm')")->result();
        
        $tip_amount = !empty($tip_query[0]->total_tip) ? $tip_query[0]->total_tip : '0.00';
        $tip_refund_amount = !empty($tip_refund_query[0]->total_refund_tip) ? $tip_refund_query[0]->total_refund_tip : '0.00';
        
        // echo $this->db->last_query();die();
        // print_r($tip_refund_query);
        $user101[$i]['EmpName'] = $employee['empName'];
        $user101[$i]['SalesTip'] = '$'.number_format(($tip_amount + $tip_refund_amount), 2);
        $user101[$i]['RefundTip'] = '$0.00';
        $user101[$i]['NetTip'] = '$'.number_format(($tip_amount + $tip_refund_amount), 2);
    }
//  echo '<pre>';print_r($user101);die();
 $response['Employee_Tip'] = $user101;
   
/*****   dashboard widgets_data section  Start  ********/
$date_s = $_POST['start'];
$date_e = $_POST['end'];
 
 $stmt_wd = $this->db->query("SELECT
 ( SELECT sum(tip_amount) as TotalPOSTipAmount from pos where status='confirm'AND date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' ) as TotalPOSTipAmount,
( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' ) as TotalPOSConfirm,
( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' ) as TotalInvoiceConfirm,
( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' ) as TotalRecurringConfirm,
( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' ) as TotalInvoicePending,
( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' ) as TotalRecurringPending,
( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '".$date_s."' AND '".$date_e."' and merchant_id='".$merchant."' AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
 ");
 
  $getStmt_wd = $stmt_wd->result_array();

 
 $TotalPOSTipAmount = $getStmt_wd[0]['TotalPOSTipAmount'] ? $getStmt_wd[0]['TotalPOSTipAmount'] : "0";
 $TotalPOSConfirm = $getStmt_wd[0]['TotalPOSConfirm'] ? $getStmt_wd[0]['TotalPOSConfirm'] : "0";
 $TotalInvoiceConfirm = $getStmt_wd[0]['TotalInvoiceConfirm'] ? $getStmt_wd[0]['TotalInvoiceConfirm'] : "0";
 $TotalRecurringConfirm = $getStmt_wd[0]['TotalRecurringConfirm'] ? $getStmt_wd[0]['TotalRecurringConfirm'] : "0";
 $TotalInvoicePending = $getStmt_wd[0]['TotalInvoicePending'] ? $getStmt_wd[0]['TotalInvoicePending'] : "0";
 $TotalRecurringPending = $getStmt_wd[0]['TotalRecurringPending'] ? $getStmt_wd[0]['TotalRecurringPending'] : "0";
 $TotalInvoicePendingDueOver = $getStmt_wd[0]['TotalInvoicePendingDueOver'] ? $getStmt_wd[0]['TotalInvoicePendingDueOver'] : "0";
 $TotalRecurringPendingDueOver = $getStmt_wd[0]['TotalRecurringPendingDueOver'] ? $getStmt_wd[0]['TotalRecurringPendingDueOver'] : "0";
 


 $widgets_data = array(
     'TotalTipAmount'=>$TotalPOSTipAmount,
     'NewTotalOrders'=>$TotalPOSConfirm, 
     'TotalOrders'=>$TotalInvoiceConfirm+$TotalRecurringConfirm, 
     'TotalpendingOrders'=>$TotalInvoicePending+$TotalRecurringPending, 
     'TotalAmount'=>0, 
     'TotalLate' => $TotalInvoicePendingDueOver+$TotalRecurringPendingDueOver,

 );
 
 $response['widgets_data'] = $widgets_data; 

  
 /*****   dashboard widgets_data section end    ********/
 }
 else{
$status = parent::HTTP_OK;
$response = ['status' => $status, 'errorMsg' => 'No Data!'];
 }
   }
              else
              {
                  $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
              }
              $this->response($response, $status);
   }
   
   
   
   

 
public function year_graph_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
 
$merchant = $_POST['merchant_id'];
$merchant_id = $_POST['merchant_id'];
$employee = 0;
$today2 = date("Y");
$last_year = date("Y",strtotime("-1 year")); 
$cday = date("Y-m-d",strtotime("-1 days"));
$lday = date("Y-m-d",strtotime("-8 days")); 
$monday = strtotime("last monday");
$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
$sunday1 = strtotime(date("Y-m-d",$monday)." -7 days");
$sunday2 = strtotime(date("Y-m-d",$sunday1)." +6 days");
$this_week_ed1 = date("Y-m-d",$sunday2);
$this_week_sd1 = date("Y-m-d",$sunday1);
$this_week_sd = date("Y-m-d",$monday);
$this_week_ed = date("Y-m-d",$sunday);
$last_date = date("Y-m-d",strtotime("-8 days")); 
$date = date("Y-m-d",strtotime("-1 days"));

$stmt = $this->db->query("SELECT (SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljan ,
(SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm' )x group by month ) as Totalfeb  ,
(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm' )x group by month ) as Totalmarch,
(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm' )x group by month ) as Totalaprl  ,
(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm' )x group by month ) as Totalmay,
(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljune  ,
(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljuly,
(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm' )x group by month ) as Totalaugust  ,
(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm' )x group by month ) as Totalsep,
(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm' )x group by month ) as Totaloct  ,
(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm' )x group by month ) as Totalnov,
(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm' )x group by month ) as Totaldec  ,
(SELECT sum(tax) as Totaljant from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljant ,
(SELECT sum(tax) as Totalfebt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm' )x group by month ) as Totalfebt  ,
(SELECT sum(tax) as Totalmarcht from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm' )x group by month ) as Totalmarcht,
(SELECT sum(tax) as Totalaprlt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm' )x group by month ) as Totalaprlt  ,
(SELECT sum(tax) as Totalmayt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm' )x group by month ) as Totalmayt,
(SELECT sum(tax) as Totaljunet from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljunet  ,
(SELECT sum(tax) as Totaljulyt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljulyt,
(SELECT sum(tax) as Totalaugustt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm' )x group by month ) as Totalaugustt  ,
(SELECT sum(tax) as Totalsept from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm' )x group by month ) as Totalsept,
(SELECT sum(tax) as Totaloctt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm' )x group by month ) as Totaloctt  ,
(SELECT sum(tax) as Totalnovt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm' )x group by month ) as Totalnovt,
(SELECT sum(tax) as Totaldect from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm' )x group by month ) as Totaldect  ,
(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '01' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljanf ,
(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '02' and year ='".$today2."' and status='confirm' )x group by month ) as Totalfebf  ,
(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '03' and year ='".$today2."' and status='confirm' )x group by month ) as Totalmarchf,
(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '04' and year ='".$today2."' and status='confirm' )x group by month ) as Totalaprlf  ,
(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '05' and year ='".$today2."' and status='confirm' )x group by month ) as Totalmayf,
(SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '06' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljunef  ,
(SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '07' and year ='".$today2."' and status='confirm' )x group by month ) as Totaljulyf,
(SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '08' and year ='".$today2."' and status='confirm' )x group by month ) as Totalaugustf  ,
(SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '09' and year ='".$today2."' and status='confirm' )x group by month ) as Totalsepf,
(SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '10' and year ='".$today2."' and status='confirm' )x group by month ) as Totaloctf  ,
(SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '11' and year ='".$today2."' and status='confirm' )x group by month ) as Totalnovf,
(SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '12' and year ='".$today2."' and status='confirm' )x group by month ) as Totaldecf  
  "); 
 

 
$stmt2 = $this->db->query("SELECT (SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljan ,
(SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalfeb  ,
(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalmarch,
(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalaprl  ,
(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalmay,
(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljune  ,
(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljuly,
(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalaugust  ,
(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalsep,
(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaloct  ,
(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalnov,
(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm' union all SELECT month,amount from pos where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaldec  ,
(SELECT sum(tax) as Totaljant from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljant ,
(SELECT sum(tax) as Totalfebt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalfebt  ,
(SELECT sum(tax) as Totalmarcht from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalmarcht,
(SELECT sum(tax) as Totalaprlt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalaprlt  ,
(SELECT sum(tax) as Totalmayt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalmayt,
(SELECT sum(tax) as Totaljunet from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljunet  ,
(SELECT sum(tax) as Totaljulyt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljulyt,
(SELECT sum(tax) as Totalaugustt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalaugustt  ,
(SELECT sum(tax) as Totalsept from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalsept,
(SELECT sum(tax) as Totaloctt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaloctt  ,
(SELECT sum(tax) as Totalnovt from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalnovt,
(SELECT sum(tax) as Totaldect from ( SELECT month,tax from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm' union all SELECT month,tax from pos where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaldect  ,
(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '01' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljanf ,
(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '02' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalfebf  ,
(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '03' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalmarchf,
(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '04' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalaprlf  ,
(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '05' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalmayf,
(SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '06' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljunef  ,
(SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '07' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaljulyf,
(SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '08' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalaugustf  ,
(SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '09' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalsepf,
(SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '10' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaloctf  ,
(SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '11' and year ='".$last_year."' and status='confirm' )x group by month ) as Totalnovf,
(SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm' union all SELECT month,fee from pos where  merchant_id='".$merchant."' and month = '12' and year ='".$last_year."' and status='confirm' )x group by month ) as Totaldecf  
  "); 


 $stmt7 = $this->db->query("SELECT  (SELECT sum(amount) as Monday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Monday,
(SELECT sum(amount) as Tuesday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesday,
(SELECT sum(amount) as Wednesday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesday,
(SELECT sum(amount) as Thursday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursday,
(SELECT sum(amount) as Friday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Friday,
(SELECT sum(amount) as Satuday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satuday,
(SELECT sum(amount) as Sunday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sunday,
 (SELECT sum(tax) as Mondayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Mondayt,
(SELECT sum(tax) as Tuesdayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesdayt,
(SELECT sum(tax) as Wednesdayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesdayt,
(SELECT sum(tax) as Thursdayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursdayt,
(SELECT sum(tax) as Fridayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Fridayt,
(SELECT sum(tax) as Satudayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satudayt,
(SELECT sum(tax) as Sundayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sundayt,
(SELECT sum(fee) as Mondayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Mondayf,
(SELECT sum(fee) as Tuesdayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesdayf,
(SELECT sum(fee) as Wednesdayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesdayf,
(SELECT sum(fee) as Thursdayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursdayf,
(SELECT sum(fee) as Fridayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Fridayf,
(SELECT sum(fee) as Satudayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satudayf,
(SELECT sum(fee) as Sundayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed."' and date_c >='".$this_week_sd."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sundayf
  "); 
 

 
 
 $stmt10 = $this->db->query("SELECT  (SELECT sum(amount) as Monday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Monday,
(SELECT sum(amount) as Tuesday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesday,
(SELECT sum(amount) as Wednesday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesday,
(SELECT sum(amount) as Thursday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursday,
(SELECT sum(amount) as Friday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Friday,
(SELECT sum(amount) as Satuday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satuday,
(SELECT sum(amount) as Sunday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sunday,
(SELECT sum(tax) as Mondayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Mondayt,
(SELECT sum(tax) as Tuesdayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesdayt,
(SELECT sum(tax) as Wednesdayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesdayt,
(SELECT sum(tax) as Thursdayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursdayt,
(SELECT sum(tax) as Fridayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Fridayt,
(SELECT sum(tax) as Satudayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satudayt,
(SELECT sum(tax) as Sundayt from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sundayt,
(SELECT sum(fee) as Mondayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Mondayf,
(SELECT sum(fee) as Tuesdayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesdayf,
(SELECT sum(fee) as Wednesdayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesdayf,
(SELECT sum(fee) as Thursdayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursdayf,
(SELECT sum(fee) as Fridayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Fridayf,
(SELECT sum(fee) as Satudayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satudayf,
(SELECT sum(fee) as Sundayf from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'   and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c <='".$this_week_ed1."' and date_c >='".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sundayf
  "); 
 

  
  $stmt13 = $this->db->query("SELECT  (SELECT sum(amount) as time22 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."' and time1 = '01' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."' and time1 = '01' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 = '01' and status='confirm' )x group by merchant_id ) as time22,
    (SELECT sum(amount) as time2 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by merchant_id ) as time2,
     (SELECT sum(amount) as time3 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by merchant_id ) as time3,
      (SELECT sum(amount) as time4 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by merchant_id ) as time4,
       (SELECT sum(amount) as time5 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by merchant_id ) as time5,
        (SELECT sum(amount) as time6 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as time6,
         (SELECT sum(amount) as time7 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as time7,
          (SELECT sum(amount) as time8 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as time8,
           (SELECT sum(amount) as time9 from ( SELECT merchant_id,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as time9,
            (SELECT sum(amount) as time10 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as time10,
             (SELECT sum(amount) as time11 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as time11,
              (SELECT sum(amount) as time12 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '22' and  time1 <= '24'  and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '22' and  time1 <= '24'  and status='confirm' )x group by merchant_id ) as time12  ,
              (SELECT sum(tax) as time22t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."' and time1 = '01' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."' and time1 = '01' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 = '01' and status='confirm' )x group by merchant_id ) as time22t,
    (SELECT sum(tax) as time2t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by merchant_id ) as time2t,
     (SELECT sum(tax) as time3t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by merchant_id ) as time3t,
      (SELECT sum(tax) as time4t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by merchant_id ) as time4t,
       (SELECT sum(tax) as time5t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by merchant_id ) as time5t,
        (SELECT sum(tax) as time6t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as time6t,
         (SELECT sum(tax) as time7t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as time7t,
          (SELECT sum(tax) as time8t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as time8t,
           (SELECT sum(tax) as time9t from ( SELECT merchant_id,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as time9t,
            (SELECT sum(tax) as time10t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as time10t,
             (SELECT sum(tax) as time11t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as time11t,
              (SELECT sum(tax) as time12t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '22' and  time1 <= '24'  and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '22' and  time1 <= '24'  and status='confirm' )x group by merchant_id ) as time12t  ,
              (SELECT sum(fee) as time22f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."' and time1 = '01' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."' and time1 = '01' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 = '01' and status='confirm' )x group by merchant_id ) as time22f,
    (SELECT sum(fee) as time2f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by merchant_id ) as time2f,
     (SELECT sum(fee) as time3f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by merchant_id ) as time3f,
      (SELECT sum(fee) as time4f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by merchant_id ) as time4f,
       (SELECT sum(fee) as time5f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by merchant_id ) as time5f,
        (SELECT sum(fee) as time6f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as time6f,
         (SELECT sum(fee) as time7f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as time7f,
          (SELECT sum(fee) as time8f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as time8f,
           (SELECT sum(fee) as time9f from ( SELECT merchant_id,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as time9f,
            (SELECT sum(fee) as time10f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as time10f,
             (SELECT sum(fee) as time11f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as time11f,
              (SELECT sum(fee) as time12f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$date."'  and time1 >= '22' and  time1 <= '24'  and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$date."' and time1 >= '22' and  time1 <= '24'  and status='confirm' )x group by merchant_id ) as time12f  
  "); 
 


  $stmt16 = $this->db->query("SELECT  (SELECT sum(amount) as time22 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 = '01' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."' and time1 = '01' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 = '01' and status='confirm' )x group by merchant_id ) as time22,
    (SELECT sum(amount) as time2 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by merchant_id ) as time2,
     (SELECT sum(amount) as time3 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by merchant_id ) as time3,
      (SELECT sum(amount) as time4 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by merchant_id ) as time4,
       (SELECT sum(amount) as time5 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by merchant_id ) as time5,
        (SELECT sum(amount) as time6 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as time6,
         (SELECT sum(amount) as time7 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as time7,
          (SELECT sum(amount) as time8 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as time8,
           (SELECT sum(amount) as time9 from ( SELECT merchant_id,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as time9,
            (SELECT sum(amount) as time10 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as time10,
             (SELECT sum(amount) as time11 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as time11,
              (SELECT sum(amount) as time12 from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '22' and  time1 <= '24'  and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '22' and  time1 <= '24'  and status='confirm' )x group by merchant_id ) as time12  ,
              (SELECT sum(tax) as time22t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 = '01' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."' and time1 = '01' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 = '01' and status='confirm' )x group by merchant_id ) as time22t,
    (SELECT sum(tax) as time2t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by merchant_id ) as time2t,
     (SELECT sum(tax) as time3t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by merchant_id ) as time3t,
      (SELECT sum(tax) as time4t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by merchant_id ) as time4t,
       (SELECT sum(tax) as time5t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by merchant_id ) as time5t,
        (SELECT sum(tax) as time6t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as time6t,
         (SELECT sum(tax) as time7t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as time7t,
          (SELECT sum(tax) as time8t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as time8t,
           (SELECT sum(tax) as time9t from ( SELECT merchant_id,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as time9t,
            (SELECT sum(tax) as time10t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as time10t,
             (SELECT sum(tax) as time11t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as time11t,
              (SELECT sum(tax) as time12t from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '22' and  time1 <= '24'  and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '22' and  time1 <= '24'  and status='confirm' )x group by merchant_id ) as time12t  ,
              (SELECT sum(fee) as time22f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 = '01' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."' and time1 = '01' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 = '01' and status='confirm' )x group by merchant_id ) as time22f,
    (SELECT sum(fee) as time2f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by merchant_id ) as time2f,
     (SELECT sum(fee) as time3f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by merchant_id ) as time3f,
      (SELECT sum(fee) as time4f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by merchant_id ) as time4f,
       (SELECT sum(fee) as time5f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by merchant_id ) as time5f,
        (SELECT sum(fee) as time6f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as time6f,
         (SELECT sum(fee) as time7f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as time7f,
          (SELECT sum(fee) as time8f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as time8f,
           (SELECT sum(fee) as time9f from ( SELECT merchant_id,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as time9f,
            (SELECT sum(fee) as time10f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as time10f,
             (SELECT sum(fee) as time11f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as time11f,
              (SELECT sum(fee) as time12f from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id='".$merchant."' and date_c ='".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id='".$merchant."'  and date_c ='".$last_date."'  and time1 >= '22' and  time1 <= '24'  and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id='".$merchant."' and date_c ='".$last_date."' and time1 >= '22' and  time1 <= '24'  and status='confirm' )x group by merchant_id ) as time12f  
  "); 
 

   
 // $stmt->execute();
 // $stmt->store_result();
 // if($stmt->num_rows > 0){

 $getStmt7 = $stmt->result_array();
 
$Totaljan = $getStmt7[0]['Totaljan'];
$Totalfeb = $getStmt7[0]['Totalfeb'];
$Totalmarch = $getStmt7[0]['Totalmarch'];
$Totalaprl = $getStmt7[0]['Totalaprl'];
$Totalmay = $getStmt7[0]['Totalmay'];
$Totaljune = $getStmt7[0]['Totaljune'];
$Totaljuly = $getStmt7[0]['Totaljuly'];
$Totalaugust = $getStmt7[0]['Totalaugust'];
$Totalsep = $getStmt7[0]['Totalsep'];
$Totaloct = $getStmt7[0]['Totaloct'];
$Totalnov = $getStmt7[0]['Totalnov'];
$Totaldec = $getStmt7[0]['Totaldec'];

$Totaljant = $getStmt7[0]['Totaljant'];
$Totalfebt = $getStmt7[0]['Totalfebt'];
$Totalmarcht = $getStmt7[0]['Totalmarcht'];
$Totalaprlt = $getStmt7[0]['Totalaprlt'];
$Totalmayt = $getStmt7[0]['Totalmayt'];
$Totaljunet = $getStmt7[0]['Totaljunet'];
$Totaljulyt = $getStmt7[0]['Totaljulyt'];
$Totalaugustt = $getStmt7[0]['Totalaugustt'];
$Totalsept = $getStmt7[0]['Totalsept'];
$Totaloctt = $getStmt7[0]['Totaloctt'];
$Totalnovt = $getStmt7[0]['Totalnovt'];
$Totaldect = $getStmt7[0]['Totaldect'];    

$Totaljanf = $getStmt7[0]['Totaljanf'];
$Totalfebf = $getStmt7[0]['Totalfebf'];
$Totalmarchf = $getStmt7[0]['Totalmarchf'];
$Totalaprlf = $getStmt7[0]['Totalaprlf'];
$Totalmayf = $getStmt7[0]['Totalmayf'];
$Totaljunef = $getStmt7[0]['Totaljunef'];
$Totaljulyf = $getStmt7[0]['Totaljulyf'];
$Totalaugustf = $getStmt7[0]['Totalaugustf'];
$Totalsepf = $getStmt7[0]['Totalsepf'];
$Totaloctf = $getStmt7[0]['Totaloctf'];
$Totalnovf = $getStmt7[0]['Totalnovf'];
$Totaldecf = $getStmt7[0]['Totaldecf'];

 // $stmt->bind_result($Totaljan,$Totalfeb,$Totalmarch,$Totalaprl,$Totalmay,$Totaljune,$Totaljuly,$Totalaugust,$Totalsep,$Totaloct,$Totalnov,$Totaldec,$Totaljant,$Totalfebt,$Totalmarcht,$Totalaprlt,$Totalmayt,$Totaljunet,$Totaljulyt,$Totalaugustt,$Totalsept,$Totaloctt,$Totalnovt,$Totaldect,$Totaljanf,$Totalfebf,$Totalmarchf,$Totalaprlf,$Totalmayf,$Totaljunef,$Totaljulyf,$Totalaugustf,$Totalsepf,$Totaloctf,$Totalnovf,$Totaldecf);
 // $stmt->fetch();
 $user = array(
 array( 
 'amount'=>number_format($Totaljan,2,'.',''),
 'date'=>'January',
 'tax'=>number_format($Totaljant,2,'.',''),
  'fee'=>number_format($Totaljanf,2,'.','')),
 array('amount'=>number_format($Totalfeb,2,'.',''),
 'date'=>'February',
 'tax'=>number_format($Totalfebt,2,'.',''),
 'fee'=>number_format($Totalfebf,2,'.','')), 
 array('amount'=>number_format($Totalmarch,2,'.','') ,
 'date'=>'March',
 'tax'=>number_format($Totalmarcht,2,'.','') ,
 'fee'=>number_format($Totalmarchf,2,'.','') ),
 array('amount'=>number_format($Totalaprl,2,'.',''),
 'date'=>'April',
 'tax'=>number_format($Totalaprlt,2,'.',''),
 'fee'=>number_format($Totalaprlf,2,'.','')),
 array('amount'=>number_format($Totalmay,2,'.',''),
 'date'=>'May',
 'tax'=>number_format($Totalmayt,2,'.',''),
 'fee'=>number_format($Totalmayf,2,'.','')), 
 array('amount'=>number_format($Totaljune,2,'.','') ,
 'date'=>'June',
 'tax'=>number_format($Totaljunet,2,'.','') ,
 'fee'=>number_format($Totaljunef,2,'.','') ),
 array('amount'=>number_format($Totaljuly,2,'.',''),
  'date'=>'July',
 'tax'=>number_format($Totaljulyt,2,'.',''),
 'fee'=>number_format($Totaljulyf,2,'.','') ),
 array('amount'=>number_format($Totalaugust,2,'.',''), 
 'date'=>'August',
 'tax'=>number_format($Totalaugustt,2,'.',''), 
 'fee'=>number_format($Totalaugustf,2,'.','') ), 
 array('amount'=>number_format($Totalsep,2,'.','') ,
 'date'=>'September',
 'tax'=>number_format($Totalsept,2,'.','') ,
 'fee'=>number_format($Totalsepf,2,'.','')) ,
 array('amount'=>number_format($Totaloct,2,'.',''),
 'date'=>'October',
 'tax'=>number_format($Totaloctt,2,'.',''),
 'fee'=>number_format($Totaloctf,2,'.','') ),
 array('amount'=>number_format($Totalnov,2,'.',''),
 'date'=>'November',
 'tax'=>number_format($Totalnovt,2,'.',''),
 'fee'=>number_format($Totalnovf,2,'.','') ), 
 array('amount'=>number_format($Totaldec,2,'.','') ,
 'date'=>'December',
  'tax'=>number_format($Totaldect,2,'.','') ,
  'fee'=>number_format($Totaldecf,2,'.','') )
 );
 
$getStmt4 = $stmt2->result_array();
 
$Totaljan4 = $getStmt4[0]['Totaljan'];
$Totalfeb4 = $getStmt4[0]['Totalfeb'];
$Totalmarch4 = $getStmt4[0]['Totalmarch'];
$Totalaprl4 = $getStmt4[0]['Totalaprl'];
$Totalmay4 = $getStmt4[0]['Totalmay'];
$Totaljune4 = $getStmt4[0]['Totaljune'];
$Totaljuly4 = $getStmt4[0]['Totaljuly'];
$Totalaugust4 = $getStmt4[0]['Totalaugust'];
$Totalsep4 = $getStmt4[0]['Totalsep'];
$Totaloct4 = $getStmt4[0]['Totaloct'];
$Totalnov4 = $getStmt4[0]['Totalnov'];
$Totaldec4 = $getStmt4[0]['Totaldec'];

$Totaljant4 = $getStmt4[0]['Totaljant'];
$Totalfebt4 = $getStmt4[0]['Totalfebt'];
$Totalmarcht4 = $getStmt4[0]['Totalmarcht'];
$Totalaprlt4 = $getStmt4[0]['Totalaprlt'];
$Totalmayt4 = $getStmt4[0]['Totalmayt'];
$Totaljunet4 = $getStmt4[0]['Totaljunet'];
$Totaljulyt4 = $getStmt4[0]['Totaljulyt'];
$Totalaugustt4 = $getStmt4[0]['Totalaugustt'];
$Totalsept4 = $getStmt4[0]['Totalsept'];
$Totaloctt4 = $getStmt4[0]['Totaloctt'];
$Totalnovt4 = $getStmt4[0]['Totalnovt'];
$Totaldect4 = $getStmt4[0]['Totaldect'];    

$Totaljanf4 = $getStmt4[0]['Totaljanf'];
$Totalfebf4 = $getStmt4[0]['Totalfebf'];
$Totalmarchf4 = $getStmt4[0]['Totalmarchf'];
$Totalaprlf4 = $getStmt4[0]['Totalaprlf'];
$Totalmayf4 = $getStmt4[0]['Totalmayf'];
$Totaljunef4 = $getStmt4[0]['Totaljunef'];
$Totaljulyf4 = $getStmt4[0]['Totaljulyf'];
$Totalaugustf4 = $getStmt4[0]['Totalaugustf'];
$Totalsepf4 = $getStmt4[0]['Totalsepf'];
$Totaloctf4 = $getStmt4[0]['Totaloctf'];
$Totalnovf4 = $getStmt4[0]['Totalnovf'];
$Totaldecf4 = $getStmt4[0]['Totaldecf'];
 
 $user2 = array(
  array( 

 'amount'=>number_format($Totaljan4,2,'.',''),
 'date'=>'January',
 'tax'=>number_format($Totaljant4,2,'.',''),
  'fee'=>number_format($Totaljanf4,2,'.','')),
 array('amount'=>number_format($Totalfeb4,2,'.',''),
 'date'=>'February',
 'tax'=>number_format($Totalfebt4,2,'.',''),
 'fee'=>number_format($Totalfebf4,2,'.','')), 
 array('amount'=>number_format($Totalmarch4,2,'.','') ,
 'date'=>'March',
 'tax'=>number_format($Totalmarcht4,2,'.','') ,
 'fee'=>number_format($Totalmarchf4,2,'.','') ),
 array('amount'=>number_format($Totalaprl4,2,'.',''),
 'date'=>'April',
 'tax'=>number_format($Totalaprlt4,2,'.',''),
 'fee'=>number_format($Totalaprlf4),2,'.',''),
 array('amount'=>number_format($Totalmay4,2,'.',''),
 'date'=>'May',
 'tax'=>number_format($Totalmayt4,2,'.',''),
 'fee'=>number_format($Totalmayf4,2,'.','')), 
 array('amount'=>number_format($Totaljune4,2,'.','') ,
 'date'=>'June',
 'tax'=>number_format($Totaljunet4,2,'.','') ,
 'fee'=>number_format($Totaljunef4,2,'.','') ),
 array('amount'=>number_format($Totaljuly4,2,'.',''),
  'date'=>'July',
 'tax'=>number_format($Totaljulyt4,2,'.',''),
 'fee'=>number_format($Totaljulyf4,2,'.','') ),
 array('amount'=>number_format($Totalaugust4,2,'.',''), 
 'date'=>'August',
 'tax'=>number_format($Totalaugustt4,2,'.',''), 
 'fee'=>number_format($Totalaugustf4,2,'.','') ), 
 array('amount'=>number_format($Totalsep4,2,'.','') ,
 'date'=>'September',
 'tax'=>number_format($Totalsept4,2,'.','') ,
 'fee'=>number_format($Totalsepf4,2,'.','')) ,
 array('amount'=>number_format($Totaloct4,2,'.',''),
 'date'=>'October',
 'tax'=>number_format($Totaloctt4,2,'.',''),
 'fee'=>number_format($Totaloctf4,2,'.','') ),
 array('amount'=>number_format($Totalnov4,2,'.',''),
 'date'=>'November',
 'tax'=>number_format($Totalnovt4,2,'.',''),
 'fee'=>number_format($Totalnovf4,2,'.','') ), 
 array('amount'=>number_format($Totaldec4,2,'.','') ,
 'date'=>'December',
  'tax'=>number_format($Totaldect4,2,'.','') ,
  'fee'=>number_format($Totaldecf4,2,'.','') )
 );


 $getStmt77 = $stmt7->result_array();
 
$Monday = $getStmt77[0]['Monday'];
$Tuesday = $getStmt77[0]['Tuesday'];
$Wednesday = $getStmt77[0]['Wednesday'];
$Thursday = $getStmt77[0]['Thursday'];
$Friday = $getStmt77[0]['Friday'];
$Satuday = $getStmt77[0]['Satuday'];
$Sunday = $getStmt77[0]['Sunday'];

$Mondayt = $getStmt77[0]['Mondayt'];
$Tuesdayt = $getStmt77[0]['Tuesdayt'];
$Wednesdayt = $getStmt77[0]['Wednesdayt'];
$Thursdayt = $getStmt77[0]['Thursdayt'];
$Fridayt = $getStmt77[0]['Fridayt'];
$Satudayt = $getStmt77[0]['Satudayt'];
$Sundayt = $getStmt77[0]['Sundayt'];

$Mondayf = $getStmt77[0]['Mondayf'];
$Tuesdayf = $getStmt77[0]['Tuesdayf'];
$Wednesdayf = $getStmt77[0]['Wednesdayf'];
$Thursdayf = $getStmt77[0]['Thursdayf'];
$Fridayf = $getStmt77[0]['Fridayf'];
$Satudayf = $getStmt77[0]['Satudayf'];
$Sundayf = $getStmt77[0]['Sundayf'];



 $user7 = array(
   array( 
 'amount'=>number_format($Monday,2,'.',''),
 'date'=>'Monday',
 'tax'=>number_format($Mondayt,2,'.',''),
  'fee'=>number_format($Mondayf,2,'.','')),
   array( 
 'amount'=>number_format($Tuesday,2,'.',''),
 'date'=>'Tuesday',
 'tax'=>number_format($Tuesdayt,2,'.',''),
  'fee'=>number_format($Tuesdayf,2,'.','')),
   array( 
 'amount'=>number_format($Wednesday,2,'.',''),
 'date'=>'Wednesday',
 'tax'=>number_format($Wednesdayt,2,'.',''),
  'fee'=>number_format($Wednesdayf,2,'.','')),
   array( 
 'amount'=>number_format($Thursday,2,'.',''),
 'date'=>'Thursday',
 'tax'=>number_format($Thursdayt,2,'.',''),
  'fee'=>number_format($Thursdayf,2,'.','')),
   array( 
 'amount'=>number_format($Friday,2,'.',''),
 'date'=>'Friday',
 'tax'=>number_format($Fridayt,2,'.',''),
  'fee'=>number_format($Fridayf,2,'.','')),
   array( 
 'amount'=>number_format($Satuday,2,'.',''),
 'date'=>'Satuday',
 'tax'=>number_format($Satudayt,2,'.',''),
  'fee'=>number_format($Satudayf,2,'.','')),
   array( 
 'amount'=>number_format($Sunday,2,'.',''),
 'date'=>'Sunday',
 'tax'=>number_format($Sundayt,2,'.',''),
  'fee'=>number_format($Sundayf,2,'.',''))
 
 );
 

$getStmt10 = $stmt10->result_array();
 
$Monday10 = $getStmt10[0]['Monday'];
$Tuesday10 = $getStmt10[0]['Tuesday'];
$Wednesday10 = $getStmt10[0]['Wednesday'];
$Thursday10 = $getStmt10[0]['Thursday'];
$Friday10 = $getStmt10[0]['Friday'];
$Satuday10 = $getStmt10[0]['Satuday'];
$Sunday10 = $getStmt10[0]['Sunday'];

$Mondayt10 = $getStmt10[0]['Mondayt'];
$Tuesdayt10 = $getStmt10[0]['Tuesdayt'];
$Wednesdayt10 = $getStmt10[0]['Wednesdayt'];
$Thursdayt10 = $getStmt10[0]['Thursdayt'];
$Fridayt10 = $getStmt10[0]['Fridayt'];
$Satudayt10 = $getStmt10[0]['Satudayt'];
$Sundayt10 = $getStmt10[0]['Sundayt'];

$Mondayf10 = $getStmt10[0]['Mondayf'];
$Tuesdayf10 = $getStmt10[0]['Tuesdayf'];
$Wednesdayf10 = $getStmt10[0]['Wednesdayf'];
$Thursdayf10 = $getStmt10[0]['Thursdayf'];
$Fridayf10 = $getStmt10[0]['Fridayf'];
$Satudayf10 = $getStmt10[0]['Satudayf'];
$Sundayf10 = $getStmt10[0]['Sundayf'];


 $user10 = array(
   array( 
 'amount'=>number_format($Monday10,2,'.',''),
 'date'=>'Monday',
 'tax'=>number_format($Mondayt10,2,'.',''),
  'fee'=>number_format($Mondayf10,2,'.','')),
   array( 
 'amount'=>number_format($Tuesday10,2,'.',''),
 'date'=>'Tuesday',
 'tax'=>number_format($Tuesdayt10,2,'.',''),
  'fee'=>number_format($Tuesdayf10,2,'.','')),
   array( 
 'amount'=>number_format($Wednesday10,2,'.',''),
 'date'=>'Wednesday',
 'tax'=>number_format($Wednesdayt10,2,'.',''),
  'fee'=>number_format($Wednesdayf10,2,'.','')),
   array( 
 'amount'=>number_format($Thursday10,2,'.',''),
 'date'=>'Thursday',
 'tax'=>number_format($Thursdayt10,2,'.',''),
  'fee'=>number_format($Thursdayf10,2,'.','')),
   array( 
 'amount'=>number_format($Friday10,2,'.',''),
 'date'=>'Friday',
 'tax'=>number_format($Fridayt10,2,'.',''),
  'fee'=>number_format($Fridayf10,2,'.','')),
   array( 
 'amount'=>number_format($Satuday10,2,'.',''),
 'date'=>'Satuday',
 'tax'=>number_format($Satudayt10,2,'.',''),
  'fee'=>number_format($Satudayf10,2,'.','')),
   array( 
 'amount'=>number_format($Sunday10,2,'.',''),
 'date'=>'Sunday',
 'tax'=>number_format($Sundayt10,2,'.',''),
  'fee'=>number_format($Sundayf10,2,'.',''))
 
 );

$getStmt13 = $stmt13->result_array();
 
$time22 = $getStmt13[0]['time22'];
$time2 = $getStmt13[0]['time2'];
$time3 = $getStmt13[0]['time3'];
$time4 = $getStmt13[0]['time4'];
$time5 = $getStmt13[0]['time5'];
$time6 = $getStmt13[0]['time6'];
$time7 = $getStmt13[0]['time7'];
$time8 = $getStmt13[0]['time8'];
$time9 = $getStmt13[0]['time9'];
$time10 = $getStmt13[0]['time10'];
$time11 = $getStmt13[0]['time11'];
$time12 = $getStmt13[0]['time12'];

$time22t = $getStmt13[0]['time22t'];
$time2t = $getStmt13[0]['time2t'];
$time3t = $getStmt13[0]['time3t'];
$time4t = $getStmt13[0]['time4t'];
$time5t = $getStmt13[0]['time5t'];
$time6t = $getStmt13[0]['time6t'];
$time7t = $getStmt13[0]['time7t'];
$time8t = $getStmt13[0]['time8t'];
$time9t = $getStmt13[0]['time9t'];
$time10t = $getStmt13[0]['time10t'];
$time11t = $getStmt13[0]['time11t'];
$time12t = $getStmt13[0]['time12t'];

$time22f = $getStmt13[0]['time22f'];
$time2f = $getStmt13[0]['time2f'];
$time3f = $getStmt13[0]['time3f'];
$time4f = $getStmt13[0]['time4f'];
$time5f = $getStmt13[0]['time5f'];
$time6f = $getStmt13[0]['time6f'];
$time7f = $getStmt13[0]['time7f'];
$time8f = $getStmt13[0]['time8f'];
$time9f = $getStmt13[0]['time9f'];
$time10f = $getStmt13[0]['time10f'];
$time11f = $getStmt13[0]['time11f'];
$time12f = $getStmt13[0]['time12f'];


 $user13 = array(
 array( 
 'amount'=>number_format($time22,2,'.',''),
 'date'=>'12am',
 'tax'=>number_format($time22t,2,'.',''),
  'fee'=>number_format($time22f,2,'.','')),
 array( 
 'amount'=>number_format($time2,2,'.',''),
 'date'=>'2am',
 'tax'=>number_format($time2t,2,'.',''),
  'fee'=>number_format($time2f,2,'.','')),
 array( 
 'amount'=>number_format($time3,2,'.',''),
 'date'=>'4am',
 'tax'=>number_format($time3t,2,'.',''),
  'fee'=>number_format($time3,2,'.','')),
 array( 
 'amount'=>number_format($time4,2,'.',''),
 'date'=>'6am',
 'tax'=>number_format($time4t,2,'.',''),
  'fee'=>number_format($time4f,2,'.','')),
 array( 
 'amount'=>number_format($time5,2,'.',''),
 'date'=>'8am',
 'tax'=>number_format($time5t,2,'.',''),
  'fee'=>number_format($time5f,2,'.','')),
 array( 
 'amount'=>number_format($time6,2,'.',''),
 'date'=>'10am',
 'tax'=>number_format($time6t,2,'.',''),
  'fee'=>number_format($time6f,2,'.','')),
 array( 
 'amount'=>number_format($time7,2,'.',''),
 'date'=>'12pm',
 'tax'=>number_format($time7f,2,'.',''),
  'fee'=>number_format($time7f,2,'.','')),
 array( 
 'amount'=>number_format($time8,2,'.',''),
 'date'=>'2pm',
 'tax'=>number_format($time8t,2,'.',''),
  'fee'=>number_format($time8t,2,'.','')),
 array( 
 'amount'=>number_format($time9,2,'.',''),
 'date'=>'4pm',
 'tax'=>number_format($time9t,2,'.',''),
  'fee'=>number_format($time9f,2,'.','')),
 array( 
 'amount'=>number_format($time10,2,'.',''),
 'date'=>'6pm',
 'tax'=>number_format($time10t,2,'.',''),
  'fee'=>number_format($time10f,2,'.','')),
 array( 
 'amount'=>number_format($time11,2,'.',''),
 'date'=>'8pm',
 'tax'=>number_format($time11t,2,'.',''),
  'fee'=>number_format($time11f,2,'.','')),
 array( 
 'amount'=>number_format($time12,2,'.',''),
 'date'=>'10pm',
 'tax'=>number_format($time12t,2,'.',''),
  'fee'=>number_format($time12f,2,'.',''))
 
 );
 
$getStmt16 = $stmt16->result_array();
 
$time2216 = $getStmt16[0]['time22'];
$time216 = $getStmt16[0]['time2'];
$time316 = $getStmt16[0]['time3'];
$time416 = $getStmt16[0]['time4'];
$time516 = $getStmt16[0]['time5'];
$time616 = $getStmt16[0]['time6'];
$time716 = $getStmt16[0]['time7'];
$time816 = $getStmt16[0]['time8'];
$time916 = $getStmt16[0]['time9'];
$time1016 = $getStmt16[0]['time10'];
$time1116 = $getStmt16[0]['time11'];
$time1216 = $getStmt16[0]['time12'];

$time22t16 = $getStmt16[0]['time22t'];
$time2t16 = $getStmt16[0]['time2t'];
$time3t16 = $getStmt16[0]['time3t'];
$time4t16 = $getStmt16[0]['time4t'];
$time5t16 = $getStmt16[0]['time5t'];
$time6t16 = $getStmt16[0]['time6t'];
$time7t16 = $getStmt16[0]['time7t'];
$time8t16 = $getStmt16[0]['time8t'];
$time9t16 = $getStmt16[0]['time9t'];
$time10t16 = $getStmt16[0]['time10t'];
$time11t16 = $getStmt16[0]['time11t'];
$time12t16 = $getStmt16[0]['time12t'];

$time22f16 = $getStmt16[0]['time22f'];
$time2f16 = $getStmt16[0]['time2f'];
$time3f16 = $getStmt16[0]['time3f'];
$time4f16 = $getStmt16[0]['time4f'];
$time5f16 = $getStmt16[0]['time5f'];
$time6f16 = $getStmt16[0]['time6f'];
$time7f16 = $getStmt16[0]['time7f'];
$time8f16 = $getStmt16[0]['time8f'];
$time9f16 = $getStmt16[0]['time9f'];
$time10f16 = $getStmt16[0]['time10f'];
$time11f16 = $getStmt16[0]['time11f'];
$time12f16 = $getStmt16[0]['time12f'];


 $user16 = array(
 array( 
 'amount'=>number_format($time2216,2,'.',''),
 'date'=>'12am',
 'tax'=>number_format($time22t16,2,'.',''),
  'fee'=>number_format($time22f16,2,'.','')),
 array( 
 'amount'=>number_format($time216,2,'.',''),
 'date'=>'2am',
 'tax'=>number_format($time2t16,2,'.',''),
  'fee'=>number_format($time2f16,2,'.','')),
 array( 
 'amount'=>number_format($time316,2,'.',''),
 'date'=>'4am',
 'tax'=>number_format($time3t16,2,'.',''),
  'fee'=>number_format($time316,2,'.','')),
 array( 
 'amount'=>number_format($time416,2,'.',''),
 'date'=>'6am',
 'tax'=>number_format($time4t16,2,'.',''),
  'fee'=>number_format($time4f16,2,'.','')),
 array( 
 'amount'=>number_format($time516,2,'.',''),
 'date'=>'8am',
 'tax'=>number_format($time5t16,2,'.',''),
  'fee'=>number_format($time5f16,2,'.','')),
 array( 
 'amount'=>number_format($time616,2,'.',''),
 'date'=>'10am',
 'tax'=>number_format($time6t16,2,'.',''),
  'fee'=>number_format($time6f16,2,'.','')),
 array( 
 'amount'=>number_format($time716,2,'.',''),
 'date'=>'12pm',
 'tax'=>number_format($time7f16,2,'.',''),
  'fee'=>number_format($time7f16,2,'.','')),
 array( 
 'amount'=>number_format($time816,2,'.',''),
 'date'=>'2pm',
 'tax'=>number_format($time8t16,2,'.',''),
  'fee'=>number_format($time8t16,2,'.','')),
 array( 
 'amount'=>number_format($time916,2,'.',''),
 'date'=>'4pm',
 'tax'=>number_format($time9t16,2,'.',''),
  'fee'=>number_format($time9f16,2,'.','')),
 array( 
 'amount'=>number_format($time1016,2,'.',''),
 'date'=>'6pm',
 'tax'=>number_format($time10t16,2,'.',''),
  'fee'=>number_format($time10f16,2,'.','')),
 array( 
 'amount'=>number_format($time1116,2,'.',''),
 'date'=>'8pm',
 'tax'=>number_format($time11t16,2,'.',''),
  'fee'=>number_format($time11f16,2,'.','')),
 array( 
 'amount'=>number_format($time1216,2,'.',''),
 'date'=>'10pm',
 'tax'=>number_format($time12t16,2,'.',''),
  'fee'=>number_format($time12f16,2,'.',''))
 
 );
 
 
 $status = parent::HTTP_OK;

$response = ['status' => $status];

$response['successMsg'] = 'successfull'; 
$response['Year_Chart'] = $user; 
$response['Lat_Year_Chart'] = $user2;
$response['Current_week'] = $user7;
$response['Last_week'] = $user10;
$response['Yesterday'] = $user13;
$response['Last_Yesterday'] = $user16;


 // }
 // else{
 // $response['error'] = true; 
 // $response['errorMsg'] = 'No Data';
 // }



 }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



   
   
   
   


 }
 
 
 
 