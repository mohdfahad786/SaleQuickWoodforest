<?php
ini_set('MAX_EXECUTION_TIME', '-1');
// ini_set('memory_limit','2048M');
defined('BASEPATH') OR exit('No direct script access allowed');
 //require APPPATH . 'third_party/REST_Controller.php';
//require APPPATH . 'third_party/Format.php';
 require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
 //use Restserver\Libraries\REST_Controller;
 header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");
 define('UPLOAD_PATH', 'https://salequick.com/logo/');
define('UPLOAD_POS_PATH', 'https://salequick.com/uploads/item_image/');
 //header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 class Payroc_api extends REST_Controller {
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
        date_default_timezone_set("America/Chicago");
      }
    
    
    
private function verify_request()
{
    // Get all the headers
    $headers = $this->input->request_headers();
    
   //print_r($headers); die('testing');
    
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




 public function add_pos_post() {
      $data = array();
      $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      $sub_merchant_id = $_POST['sub_merchant_id'];
      $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
      $otherCharges = $_POST['otherCharges'];
      $otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
      $name = $_POST['name'];
      $mobile_no = $_POST['mobile_no'];
      $email_id = $_POST['email_id'];
      $new_tax = $_POST['tax'];
      $protector_tax = $_POST['protector_tax'] ? $_POST['protector_tax'] : "0.00";
      $reference = trim($_POST['reference']);
      $amount = $_POST['approved_amount'];
      $card_no = $_POST['card_number_masked'];
      $card = $_POST['card'] ? $_POST['card'] : 0;
      $card_logo = $_POST['cardType'] ? $_POST['cardType'] : "";


      // $express_transactiondate = $_POST['express_transaction_date'] ? $_POST['express_transaction_date'] : 0;
      // $express_transactiontime = $_POST['express_transaction_time'] ? $_POST['express_transaction_time'] : 0;
      // $express_transactiontimezone = $_POST['express_transaction_time_zone'] ? $_POST['express_transaction_time_zone'] : 0;

      $express_transactiondate = $_POST['transactionDate'] ? $_POST['transactionDate'] : 0;
      $express_transactiontime = $_POST['transactionTime'] ? $_POST['transactionTime'] : 0;
      $transactionTimezone = $_POST['transactionTimezone'] ? $_POST['transactionTimezone'] : 0;

      $rawResponse = $_POST['rawResponse'] ? $_POST['rawResponse'] : "";
      $rawRequest = $_POST['rawRequest'] ? $_POST['rawRequest'] : "";


      $transaction_id_cnp = $_POST['transactionID'] ? $_POST['transactionID'] : "";
      $transaction = $_POST['transaction'] ? $_POST['transaction'] : "0.00";
      $processor_name = $_POST['processorName'] ? $_POST['processorName'] : "";
      $transaction_status = $_POST['transaction_status'] ? $_POST['transaction_status'] : "";

      $auth_code1 = $_POST['authcode'] ? $_POST['authcode'] : "";
      $auth_code2 = $_POST['authCode'] ? $_POST['authCode'] : "";
      $auth_code3 = $_POST['auth_code'] ? $_POST['auth_code'] : "";
      if($auth_code1!='')
      {
            $auth_code = $auth_code1;
      }
      else if($auth_code2!='')
      {
           $auth_code = $auth_code2;
      }
      else
      {
           $auth_code = $auth_code3;
      } 
      
      $pos_type = $_POST['pos_type'];
      $app_type = $_POST['app_type'];
      if ($transaction_status == 'Declined') {
        $staus = 'declined';
      } else if ($transaction_status == 'Approved') {
        $staus = 'confirm';
      }
      $transaction_statuscode = '';
      $reference_number = '';
      $response_cnp = '';
      $acquirer_data = '';
      $approval_number = '';
      $bin = '';
      $batch = '';
      $credit_cardsaleresponse = '';
      $express_responsecode = '';
      $express_responsemessage = '';
      $hostbatch_amount = '';
      $hostbatch_id = '';
      $hostitem_id = '';
      $hostresponse_code = '';
      //new
      //$hostreversal_queueid = $_POST['HostResponseMessage'];
      //$hosttransaction_id = $_POST['AVSResponseCode'];
      //old
      $hostreversal_queueid = '';
      $hosttransaction_id = '';
      $today2 = date("Y-m-d");
      //$payment_id = "POS_" . date("Ymdhms");
    
      $payment_id_1 = "POS_" . date("Ymdhisu");
      $payment_id = str_replace("000000", "", $payment_id_1);
      $year = date("Y");
      $month = date("m");
      $time1 = date("H");
      $day1 = date("N");
            
            $getDashboard = $this->db->query("SELECT SUM(percentage) AS PRC FROM tax WHERE  merchant_id = '" . $merchant_id . "' and status='active'  ");
      $getDashboardData = $getDashboard->result_array();
             $tax1 = $getDashboardData[0]['PRC'];
              if ($new_tax == '1') {
        $tax = ($tax1 / 100) * $amount;
      } else if ($new_tax == '0') {
        $tax = '0';
      }
      if ($tax == 0) {
        $tax_n = 0; //$protector_tax;
      } else {
        $tax_n = $protector_tax; //$tax;
      }
      if(isset($_POST['adv_pos_tax']) && $_POST['adv_pos_tax'] != 0){
          $tax = $_POST['adv_pos_tax'];
          $tax_n = $_POST['adv_pos_tax'];
      }
      $amount11 = $amount;
      $amount1 = $amount;
      $merchantdetails = $this->admin_model->s_fee_merchant("merchant", $merchant_id);
     
      $fee_swap = $merchantdetails['0']['text_email'];
      $fee_invoice = $merchantdetails['0']['point_sale'];
      $fee_email = $merchantdetails['0']['f_swap_Text'];
      $feee = ($amount11 / 100) * $fee_invoice;
      $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
      $fee_email = ($fee_email != '') ? $fee_email : 0;
      $fee = $feee + $fee_swap + $fee_email;
      $discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
      $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $amount;
      $tip_amount = isset($_POST['tip_amount'])?$_POST['tip_amount']:0;
      $is_for_vts= isset($_POST['is_for_vts'])?$_POST['is_for_vts']:"false";
              $data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'employee_pin' =>$employee_pin,
                         'invoice_no' =>$payment_id, 
                         'amount' =>$amount1,
                         'tax' =>$tax_n,
                         'fee' =>$fee,
                         'discount' =>$discount,
                         'total_amount' =>$total_amount,
                         'tip_amount' =>$tip_amount, 
                         'name' => $name, 
                         'card_no' =>$card_no, 
                         'status' =>$staus,
                         'date_c' =>$today2,
                         'mobile_no' =>$mobile_no,
                         'email_id' =>$email_id, 
                         'year' =>$year, 
                         'month' =>$month, 
                         'time1' =>$time1, 
                         'day1' =>$day1,
                        'reference' =>$reference,
                        'protector_tax' =>$protector_tax,
                        'transaction_id' =>$transaction_id_cnp,
                        'auth_code' =>$auth_code,
                        'c_type' =>'CNP',
                        'pos_type' =>$pos_type,
                        'app_type' =>$app_type,
                        'card_type' =>$card_logo,
                        'transaction_status' =>$transaction_status,
                        'processor_name' =>$processor_name, 
                        'express_transactiondate' =>$express_transactiondate ,
                        'express_transactiontime' =>$express_transactiontime ,
                        'express_transactiontimezone' =>$express_transactiontimezone,
                        'other_charges' =>$otherCharges, 
                        'otherChargesName'=> $otherChargesName,
                        'is_for_vts'=>$is_for_vts
              );
            $get_item_data_pos = $this->db->where('transaction_id', $transaction_id_cnp)->where('merchant_id', $merchant_id)->get('pos')->num_rows();

            if($get_item_data_pos > 0) {

               $dub_id = "SELECT id From pos WHERE merchant_id ='".$merchant_id."' and transaction_id='".$transaction_id_cnp."' ";
        $dub_idd = $this->db->query($dub_id)->result();
        $id = trim($dub_idd[0]->id);
            } else {
                  $id = $this->admin_model->insert_data("pos", $data);
                   $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$id,
                        'rawRequest' =>$rawRequest,
                        'rawResponse' =>$rawResponse,
                         
                        );
                        $pax_id = $this->admin_model->insert_data("payroc_json", $data_pax);
            }
            
            $status = parent::HTTP_OK;
            if(!empty($id)){
                
                  //Satrt QuickBook sync
  $query_qb_setting = "SELECT realm_id From tbl_qbonline_setting WHERE merchant_id = $merchant_id and status='1' and pos_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                            $url ="https://salequick.com/quickbook/get_invoice_detail_vt";
                            $qbdata =array(
                            'id' => $id,
                            'merchant_id' => $merchant_id
                            
                            );
                            
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            $result = curl_exec($ch);
                            curl_close($ch);
                            $result = json_decode($result,true);
                            //print_r($result);
                            curl_close($ch);
                            }
                             //End QuickBook sync
      $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id,'invoice_no' => $payment_id];
            
            }
            else
            {
                 $response = ['status' => 401, 'errorMsg' => 'Fail'];
            }
             
              }
              else
              {
                  $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
              }
              $this->response($response, $status);
          }
                     


}
