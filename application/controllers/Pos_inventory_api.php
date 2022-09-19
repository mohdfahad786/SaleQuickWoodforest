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
 class Pos_inventory_api extends REST_Controller {
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
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);
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
			$card_logo = $_POST['card_logo'] ? $_POST['card_logo'] : "";
			$express_transactiondate = $_POST['express_transaction_date'] ? $_POST['express_transaction_date'] : 0;
			$express_transactiontime = $_POST['express_transaction_time'] ? $_POST['express_transaction_time'] : 0;
			$express_transactiontimezone = $_POST['express_transaction_time_zone'] ? $_POST['express_transaction_time_zone'] : 0;
			$transaction_id_cnp = $_POST['transactionID'] ? $_POST['transactionID'] : "";
			$transaction = $_POST['transaction'] ? $_POST['transaction'] : "0.00";
			$processor_name = $_POST['processor_name'] ? $_POST['processor_name'] : "";
			$transaction_status = $_POST['transaction_status'] ? $_POST['transaction_status'] : "";
			
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
			// $s_fee = $merchantdetails['0']['s_fee'];
			// $t_fee = $merchantdetails['0']['t_fee']; 
			// $fee_invoice = $merchantdetails['0']['invoice'];
			// $fee_swap = $merchantdetails['0']['f_swap_Invoice'];
			// $fee_email = $merchantdetails['0']['text_email'];
  		 //$stmt1a = $conn->prepare("SELECT point_sale,text_email,f_swap_Text FROM merchant WHERE id = ? ");
			// $stmt1a->bind_param("s", $merchant_id);
			// $stmt1a->execute();
			// $stmt1a->store_result();
			// $stmt1a->bind_result($point_sale, $text_email, $f_swap_Text);
			// $row = $stmt1a->fetch();
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
  						$data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
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
  						);
						$id = $this->admin_model->insert_data("pos", $data);
						
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
  	public function add_cash_pos_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');

            $stmt1 = $this->db->query("SELECT status from merchant where id ='".$merchant_id."' ");
		    $getDashboard = $stmt1->result_array();
			$status = $getDashboard[0]['status'];
if($status == 'active')
    {
    if($merchant_id == $data->merchant_id)
    {
			$sub_merchant_id = $_POST['sub_merchant_id'];
				$otherCharges = $_POST['otherCharges'] ? $_POST['otherCharges'] : 0;
				$otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
				$name = $_POST['name'] ? $_POST['name'] : "NA";
				$mobile_no = "";
				$email_id = "";
				$tax1 = $_POST['tax'];
				$protector_tax = $_POST['protector_tax'] ? $_POST['protector_tax'] : "0.00";
				$reference = trim($_POST['reference']);
				$amount = $_POST['approved_amount'];
				$card = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "CASH";
				$reference_numb_opay = isset($_POST['reference_numb_opay']) ? $_POST['reference_numb_opay'] : 0;
				$card_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : 000000;
				$card_logo = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "CASH";
				$express_transactiondate = $_POST['express_transaction_date'] ? $_POST['express_transaction_date'] : 0;
			$express_transactiontime = $_POST['express_transaction_time'] ? $_POST['express_transaction_time'] : 0;
			$express_transactiontimezone = $_POST['express_transaction_time_zone'] ? $_POST['express_transaction_time_zone'] : 0;
				$transaction_id_cnp = "" . date("YmdHis");
				$transaction = "" . date("mdHis");
			
				$processor_name = $_POST['processor_name'] ? $_POST['processor_name'] : "";
			$transaction_status = $_POST['transaction_status'] ? $_POST['transaction_status'] : "";
				
				$pos_type = $_POST['pos_type'];
                $app_type = $_POST['app_type'];
 				if ($transaction_status == 'Declined') {
					$staus = 'declined';
				} else if ($transaction_status == 'Approved') {
					$staus = 'confirm';
				}
				$discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
				$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $amount;
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
				$hostreversal_queueid = '';
				$hosttransaction_id = '';
				$today2 = date("Y-m-d");
				//$payment_id = "POS_" . date("Ymdhisu");
				$payment_id_1 = "POS_" . date("Ymdhisu");
			    $payment_id = str_replace("000000", "", $payment_id_1);
				$year = date("Y");
				$month = date("m");
				$time1 = date("H");
				$day1 = date("N");
 				$amount11 = $amount + $tax1;
            
            
 			$merchantdetails = $this->admin_model->s_fee_merchant("merchant", $merchant_id);
			// $s_fee = $merchantdetails['0']['s_fee'];
			// $t_fee = $merchantdetails['0']['t_fee']; 
			// $fee_invoice = $merchantdetails['0']['invoice'];
			// $fee_swap = $merchantdetails['0']['f_swap_Invoice'];
			// $fee_email = $merchantdetails['0']['text_email'];
  		 //$stmt1a = $conn->prepare("SELECT point_sale,text_email,f_swap_Text FROM merchant WHERE id = ? ");
			// $stmt1a->bind_param("s", $merchant_id);
			// $stmt1a->execute();
			// $stmt1a->store_result();
			// $stmt1a->bind_result($point_sale, $text_email, $f_swap_Text);
			// $row = $stmt1a->fetch();
 			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale'];
			$fee_email = $merchantdetails['0']['f_swap_Text'];
			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
			$tip_amount = isset($_POST['tip_amount'])?$_POST['tip_amount']:0;
			$amount1 = $amount + $tax1 + $tip_amount + $otherCharges;
  						$data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'invoice_no' =>$payment_id, 
                         'amount' =>$amount1,
                         'tax' =>$tax1,
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
						'c_type' =>$card,
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
						'reference_numb_opay' =>$reference_numb_opay,
  						);
						$id = $this->admin_model->insert_data("pos", $data);
						
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
                             
						     $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id,'invoice_no' => $payment_id, 'transaction_id' => $transaction_id_cnp];
						
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
					     }
					    else
					    {
					        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
					    }
					    $this->response($response, $status);
					}
     public function add_pos_card_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
			$sub_merchant_id = $_POST['sub_merchant_id'];
            $otherCharges = $_POST['otherCharges'];
            $otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
			$amount = $_POST['amount'];
			$card_no = $_POST['card_no'];
			$transaction_guid = $_POST['transaction_guid'];
			$pos_entry_mode = $_POST['pos_entry_mode'];
			$transaction_id = $_POST['transaction_id'];
			$client_transaction_id = $_POST['client_transaction_id'];
			$card_type = $_POST['card_type'];
			$invoice_no = $_POST['invoice_no'];
			$reference = $_POST['reference'];
			//$tax = $_POST['tax_amount'];
			if($_POST['tax_amount'] < 0)
			{
			$tax = 0.00;
			}
			else
			{
				$tax = $_POST['tax_amount'];
			}
			$pos_type = $_POST['pos_type'];
            $app_type = $_POST['app_type'];
            $name = trim($_POST['name']);
 			$today2 = date("Y-m-d");
			$payment_id = "POS_" . date("Ymdhms");
 			$year = date("Y");
			$month = date("m");
			$time11 = date("H");
 			if ($time11 == '00') {
				$time1 = '01';
			} else {
				$time1 = date("H");
			}
			$day1 = date("N");
 			if(isset($_POST['adv_pos_tax']) && $_POST['adv_pos_tax'] != 0){
			    $tax = $_POST['adv_pos_tax'];
			    $tax_n = $_POST['adv_pos_tax'];
			}
 			$amount1 = $amount;
			$amount11 = $amount;
            
            
 			$merchantdetails = $this->admin_model->s_fee_merchant("merchant", $merchant_id);
 			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale'];
			$fee_email = $merchantdetails['0']['f_swap_Text'];
			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
			$tip_amount = isset($_POST['tip_amount'])?$_POST['tip_amount']:0;
	        $discount= isset($_POST['discount'])?$_POST['discount']:"$"."0.00";
	        $total_amount= isset($_POST['total_amount'])?$_POST['total_amount']:$amount;
	        
	        /*Extra Param Added 31-10-2019*/
	        $version=(isset($_POST["version"]))?$_POST["version"]:"N/A";
	        $serialNumber=(isset($_POST["serialNumber"]))?$_POST["serialNumber"]:"N/A";
	        $terminalID=(isset($_POST["terminalID"]))?$_POST["terminalID"]:"N/A";
	        $storeID=(isset($_POST["storeID"]))?$_POST["storeID"]:"N/A";
	        $chainID=(isset($_POST["chainID"]))?$_POST["chainID"]:"N/A";
	        $paymentServiceTimezone=(isset($_POST["paymentServiceTimezone"]))?$_POST["paymentServiceTimezone"]:"N/A";
	        $paymentServiceTimestamp=(isset($_POST["paymentServiceTimestamp"]))?$_POST["paymentServiceTimestamp"]:"N/A";
	        $deviceTimezone=(isset($_POST["deviceTimezone"]))?$_POST["deviceTimezone"]:"N/A";
	        $deviceTimestamp=(isset($_POST["deviceTimestamp"]))?$_POST["deviceTimestamp"]:"N/A";
	        $processorTimezone=(isset($_POST["processorTimezone"]))?$_POST["processorTimezone"]:"N/A";
	        $processorTimestamp=(isset($_POST["processorTimestamp"]))?$_POST["processorTimestamp"]:"N/A";

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
	         $rawResponse= $_POST["rawResponse"] ? $_POST["rawResponse"]:"";

  						$data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'invoice_no' =>$invoice_no, 
                         'amount' =>$amount1,
                         'tax' =>$tax,
                         'fee' =>$fee,
                         'discount' =>$discount,
                         'total_amount' =>$total_amount,
                         'tip_amount' =>$tip_amount, 
                         'name' => $name, 
                         'card_no' =>$card_no, 
                         'status' =>'confirm',
                         'date_c' =>$today2,
                         'mobile_no' =>$mobile_no,
                         'email_id' =>$email_id, 
                         'year' =>$year, 
                         'month' =>$month, 
                         'time1' =>$time1, 
                         'day1' =>$day1,
						'reference' =>$reference,
						'protector_tax' =>$protector_tax,
						'transaction_id' =>$transaction_id,
						'c_type' =>'CP',
						'pos_type' =>$pos_type,
						'app_type' =>$app_type,
						'card_type' =>$card_type,
						'transaction_status' =>$transaction_status,
						'processor_name' =>$processor_name, 
						'express_transactiondate' =>$express_transactiondate ,
						'express_transactiontime' =>$express_transactiontime ,
						'express_transactiontimezone' =>$express_transactiontimezone,
						'other_charges' =>$otherCharges, 
						'otherChargesName'=> $otherChargesName,
						'reference_numb_opay' =>$reference_numb_opay,
						'transaction_guid' => $transaction_guid,
						'pos_entry_mode'=> $pos_entry_mode,
						'client_transaction_id'=>$client_transaction_id,
						'processorTimestamp'=>$processorTimestamp, 
						'processorTimezone'=>$processorTimezone, 
						'deviceTimestamp'=>$deviceTimestamp, 
						'deviceTimezone'=>$deviceTimezone, 
						'paymentServiceTimestamp'=>$paymentServiceTimestamp, 
						'paymentServiceTimezone'=>$paymentServiceTimezone, 
						'chainID'=>$chainID, 
						'storeID'=>$storeID, 
						'terminalID'=>$terminalID,
						'version'=>$version, 
						'serialNumber'=>$serialNumber,
						'auth_code'=>$auth_code,
  						);
						$id = $this->admin_model->insert_data("pos", $data);
                        if(!empty($rawResponse)){
						 $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$id,
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
   	public function add_pos_card_declined_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
    	    $app_type = $_POST['app_type'];
			$sub_merchant_id = $_POST['sub_merchant_id'];
 			$amount = $_POST['amount'];
			$card_no = $_POST['card_no'];
			$transaction_guid = $_POST['transaction_guid'];
			$pos_entry_mode = $_POST['pos_entry_mode'];
			$transaction_id = $_POST['transaction_id'];
			$client_transaction_id = $_POST['client_transaction_id'];
			$card_type = $_POST['card_type'];
			$invoice_no = $_POST['invoice_no'];
			$reference = $_POST['reference'];
			$tax = $_POST['tax_amount'];
 			$today2 = date("Y-m-d");
			$payment_id = "POS_" . date("Ymdhms");
 			$year = date("Y");
			$month = date("m");
			$time11 = date("H");
 			if ($time11 == '00') {
				$time1 = '01';
			} else {
				$time1 = date("H");
			}
			$day1 = date("N");
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
	        $rawResponse= $_POST["rawResponse"] ? $_POST["rawResponse"]:"";
            
//             $getDashboard = $this->db->query("SELECT SUM(percentage) AS PRC FROM tax WHERE  merchant_id = '" . $merchant_id . "' ");
// 			$getDashboardData = $getDashboard->result_array();
//             $tax1 = $getDashboardData[0]['PRC'];
 			$amount11 = $amount;
			$amount1 = $amount;
 			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			
 			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale'];
			$fee_email = $merchantdetails['0']['f_swap_Text'];
			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
 			
 						$data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'invoice_no' =>$invoice_no, 
                         'amount' =>$amount1,
                         'tax' =>$tax,
                         'fee' =>$fee,
                         'card_no' =>$card_no, 
                         'status' =>'declined',
                         'date_c' =>$today2,
                         'year' =>$year, 
                         'month' =>$month, 
                         'time1' =>$time1, 
                         'day1' =>$day1,
						'reference' =>$reference,
						'transaction_id' =>$transaction_id,
						'c_type' =>'CP',
						'card_type' =>$card_type,
						'app_type' =>$app_type,
						'client_transaction_id' =>$client_transaction_id ,
						'pos_entry_mode' =>$pos_entry_mode,
						'transaction_guid' =>$transaction_guid,
						'auth_code' =>$auth_code, 
  						);
						$id = $this->admin_model->insert_data("pos", $data);

						if(!empty($rawResponse)){
			 $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$id,
                        'rawResponse' =>$rawResponse,
                         
                        );
                        $pax_id = $this->admin_model->insert_data("payroc_json", $data_pax);
            }
						
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id];
						
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
   	public function add_tripos_card_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchantId');
    if($merchant_id == $data->merchant_id)
    {       
    	    $otherCharges = $_POST['otherCharges'];
            $otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";

      $applicationId = $_POST['applicationId'] ? $_POST['applicationId'] : "N/A";
      $cryptogram = $_POST['cryptogram'] ? $_POST['cryptogram'] : "N/A";
      $applicationLabel = $_POST['applicationLabel'] ? $_POST['applicationLabel'] : "N/A";
      $applicationPreferredName = $_POST['applicationPreferredName'] ? $_POST['applicationPreferredName'] : "N/A";

      $hostResponseCode = $_POST['hostResponseCode'] ? $_POST['hostResponseCode'] : "N/A";
      $expressResponseCode = $_POST['expressResponseCode'] ? $_POST['expressResponseCode'] : "N/A";
      $expressResponseMessage = $_POST['expressResponseMessage'] ? $_POST['expressResponseMessage'] : "N/A";

			$description = $_POST['description'];
			$transactionStatus = $_POST['transactionStatus'];
	    	$wasProcessedOnline = $_POST['wasProcessedOnline'];
			$transactionDateTime = $_POST['transactionDateTime'];
			$cashbackAmount     = $_POST['cashbackAmount'];
			$balanceAmount  = $_POST['balanceAmount'];
			$sub_merchant_id = $_POST['subMerchantId'];
			$amount = $_POST['approvedAmount'];
			$sentamount = $_POST['sentAmount'];
			$pos_type = $_POST['posType'];
			$app_type = $_POST['appType'];
			$transaction_id = $_POST['transactionId'];
			$reference = $_POST['referenceNumber'];
            $pos_entry_mode = $_POST['entryMode']; 
			$card_no = $_POST['cardMaskedNumber'];
			$transaction_guid = '';
			$client_transaction_id = 0;
			$card_type = $_POST['cardLogo'];
			
			if($_POST['tax_amount'] < 0)
			{
			$tax = 0.00;
			}
			else
			{
				$tax = $_POST['tax_amount'];
			}
            $name = $_POST['cardHolderName'];
 			$today2 = date("Y-m-d");
			//$payment_id = "POS_" . date("Ymdhisu");
			$payment_id_1 = "BPS_" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);
            //$invoice_no = "POS_" . date("Ymdhisu");
            $invoice_no_1 = "BPS_" . date("Ymdhisu");
			$invoice_no = str_replace("000000","", $invoice_no_1);
			$approvalNumber = $_POST['approvalNumber'];
			$year = date("Y");
			$month = date("m");
			$time11 = date("H");
 			if ($time11 == '00') {
				$time1 = '01';
			} else {
				$time1 = date("H");
			}
			$day1 = date("N");
 			
			if(isset($_POST['adv_pos_tax']) && $_POST['adv_pos_tax'] != 0){
			    $tax = $_POST['adv_pos_tax'];
			    $tax_n = $_POST['adv_pos_tax'];
			}
 			$amount1 = $amount;
			$amount11 = $amount;
 			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
 			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale'];
			$fee_email = $merchantdetails['0']['f_swap_Text'];
			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
			$tip_amount = isset($_POST['tipAmount'])?$_POST['tipAmount']:0;
	        $discount= isset($_POST['discount'])?$_POST['discount']:"$"."0.00";
	        $total_amount= isset($_POST['total_amount'])?$_POST['total_amount']:$amount;
	        
	        /*Extra Param Added 31-10-2019*/
	        $version=(isset($_POST["version"]))?$_POST["version"]:"N/A";
	        $serialNumber=(isset($_POST["terminalSerialNumber"]))?$_POST["terminalSerialNumber"]:"N/A";
			//$terminalSerialNumber = $_POST['terminalSerialNumber'];
	        $terminalID=(isset($_POST["terminalModel"]))?$_POST["terminalModel"]:"N/A";
			//$terminalModel = $_POST['terminalModel'];
	        $storeID=(isset($_POST["storeID"]))?$_POST["storeID"]:"N/A";
	        $chainID=(isset($_POST["chainID"]))?$_POST["chainID"]:"N/A";
	        $paymentServiceTimezone=(isset($_POST["paymentServiceTimezone"]))?$_POST["paymentServiceTimezone"]:"N/A";
	        $paymentServiceTimestamp=(isset($_POST["paymentServiceTimestamp"]))?$_POST["paymentServiceTimestamp"]:"N/A";
	        $deviceTimezone=(isset($_POST["deviceTimezone"]))?$_POST["deviceTimezone"]:"N/A";
	        $deviceTimestamp=(isset($_POST["deviceTimestamp"]))?$_POST["deviceTimestamp"]:"N/A";
	        $processorTimezone=(isset($_POST["processorTimezone"]))?$_POST["processorTimezone"]:"N/A";
	        $processorTimestamp=(isset($_POST["processorTimestamp"]))?$_POST["processorTimestamp"]:"N/A";
  						$data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'invoice_no' =>$invoice_no, 
                         'amount' =>$amount1,
                         'tax' =>$tax,
                         'fee' =>$fee,
                         'discount' =>$discount,
                         'total_amount' =>$total_amount,
                         'tip_amount' =>$tip_amount, 
                         'name' => $name, 
                         'card_no' =>$card_no, 
                         'status' =>'confirm',
                         'date_c' =>$today2,
                         'mobile_no' =>$mobile_no,
                         'email_id' =>$email_id, 
                         'year' =>$year, 
                         'month' =>$month, 
                         'time1' =>$time1, 
                         'day1' =>$day1,
						'reference' =>$reference,
						'protector_tax' =>$protector_tax,
						'transaction_id' =>$transaction_id,
						'c_type' =>'BBPOS',
						'pos_type' =>$pos_type,
						'app_type' =>$app_type,
						'card_type' =>$card_type,
						'transaction_status' =>$transaction_status,
						'processor_name' =>$processor_name, 
						'transaction_guid' => $transaction_guid,
						'pos_entry_mode'=> $pos_entry_mode,
						'client_transaction_id'=>$client_transaction_id,
						'processorTimestamp'=>$processorTimestamp, 
						'processorTimezone'=>$processorTimezone, 
						'other_charges' =>$otherCharges, 
						'otherChargesName'=> $otherChargesName,
						'deviceTimestamp'=>$deviceTimestamp, 
						'deviceTimezone'=>$deviceTimezone, 
						'paymentServiceTimestamp'=>$paymentServiceTimestamp, 
						'paymentServiceTimezone'=>$paymentServiceTimezone, 
						'chainID'=>$chainID, 
						'storeID'=>$storeID, 
						'terminalID'=>$terminalID,
						'version'=>$version, 
						'serialNumber'=>$serialNumber,
						'detail'=> $description,
						'wasProcessedOnline'=>$wasProcessedOnline,
						'transactionDateTime'=>$transactionDateTime,
						'cashbackAmount'=>$cashbackAmount,
						'balanceAmount'=>$balanceAmount,
						'sentamount'=>$sentamount,
						'type'=>'triPos',
						'approval_number'=>$approvalNumber,
						'applicationId'=>$applicationId,
						'cryptogram'=>$cryptogram,
						'applicationLabel'=>$applicationLabel,
						'applicationPreferredName'=>$applicationPreferredName,
						'hostResponseCode'=>$hostResponseCode,
						'expressResponseCode'=>$expressResponseCode,
						'expressResponseMessage'=>$expressResponseMessage						
  						);
						$id = $this->admin_model->insert_data("pos", $data);
						
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id];
						
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
    public function advPOSItems_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       	$name = $this->input->post('name') ? $this->input->post('name') : "";
		$sku = $this->input->post('sku') ? $this->input->post('sku') : "";
		$price = $this->input->post('price') ? $this->input->post('price') : "";
		$tax = $this->input->post('tax') ? $this->input->post('tax') : "";
		$quantity = $this->input->post('quantity') ? $this->input->post('quantity') : "";
		$catID = $this->input->post('catID') ? $this->input->post('catID') : "";
			
			if (isset($_FILES['itemImage']['name'])) {
 					$date = date("mdHis");
					$image = $_FILES['itemImage']['name'];
					$exp = explode(".", $image);
					$extension = end($exp);
 					$image_name = strtolower("adv_pos_item") . "_" . $date . "." . $extension;
 					//move_uploaded_file($_FILES['itemImage']['tmp_name'], UPLOAD_POS_PATH . $image_name);
					
					$config['file_name'] = $image_name; 
                    $config['upload_path']          = './uploads/item_image/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 3024;
                    $config['max_height']           = 3068;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('itemImage'))
                    {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                    }
                     $image_name =$uploadedFileName;
				
				$data = Array(
				'name' => $name,
				'sku' => $sku, 
				'price' => $price,
				'tax' => $tax,
				'quantity' => $quantity,
				'category_id' => $catID,
				'item_image' =>$image_name
					
				);
				$id = $this->admin_model->insert_data("adv_pos_item", $data);
				
				if (!empty($id)) {
						
					$status = parent::HTTP_OK;
				     $response = ['status' => $status, 'successMsg' =>'Advance POS Item added Successfully'];
 					} else {
						
						 $response = ['status' => '401', 'errorMsg' => 'Server error'];
					}
				
				// Send the return data as reponse
				
				
				} else {
					
					 $response = ['status' => '401', 'errorMsg' => 'No item image selected'];
				}
				
	 
    
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
 public function addPOSItemsNew_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
     $fulldata = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       	$itemName = $this->input->post('name') ? $this->input->post('name') : "";
		//$sku = $this->input->post('sku') ? $this->input->post('sku') : "";
		//$price = $this->input->post('price') ? $this->input->post('price') : "";
		$tax = $this->input->post('tax') ? $this->input->post('tax') : "";
		//$quantity = $this->input->post('quantity') ? $this->input->post('quantity') : "";
		$itemCategory = $this->input->post('catID') ? $this->input->post('catID') : "";
		$barcode_data = $this->input->post('barcode_data') ? $this->input->post('barcode_data') : "";

		$prod_mode = $this->input->post('prod_mode') ? $this->input->post('prod_mode') : "0" ;
				$items = json_decode($_POST['items']);	
				
			
			if (isset($_FILES['itemImage']['name'])) {
 					$date = date("mdHis");
					$image = $_FILES['itemImage']['name'];
					$exp = explode(".", $image);
					$extension = end($exp);
					$image_name = strtolower("adv_pos_item") . "_" . $merchant_id . "_" . $date . "." . $extension;
 					//$image_name = strtolower("adv_pos_item") . "_" . $date . "." . $extension;
 					//move_uploaded_file($_FILES['itemImage']['tmp_name'], UPLOAD_POS_PATH . $image_name);
					$config['file_name'] = $image_name; 
                    $config['upload_path']          = './uploads/item_image/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 3024;
                    $config['max_height']           = 3068;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('itemImage'))
                    {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                    }
                     $image_name =$uploadedFileName;
                 }
                 else
                 {
                 	$image_name ="";
                 }
				
				$fulldata = Array(
				'name' => $itemName,
				'merchant_id' => $merchant_id, 
				'category_id' => $itemCategory,
				'item_img' =>$image_name
				);
				
				
				$id = $this->admin_model->insert_data("adv_pos_item_main", $fulldata);
			
				if (!empty($id)) {
				    	$itemId=$id;
				    foreach ($items as $item) {
					 
							
							$data = array(
							 'item_id' =>$itemId,
							 'name' =>$itemName,
							 'title' =>$item->title,
							 'sku' =>$item->sku, 
							 'price' =>$item->price,
							 'tax' =>$tax,
							 'merchant_id' =>$merchant_id, 
							 'description' =>$itemName,
							 'quantity' =>$item->quantity,
							 'category_id' =>$itemCategory,
							 'mode' =>$prod_mode, 
							 'item_image' =>$image_name,
							 'barcode_data' =>$barcode_data
						 );
						 $stmt = $this->admin_model->insert_data("adv_pos_item", $data);
				    
						    }
						
					$status = parent::HTTP_OK;
				     $response = ['status' => $status, 'successMsg' =>'Advance POS Item added Successfully'];
 					} else {
						
						 //$response = ['status' => '401', 'errorMsg' => 'Server error'];
						  $response = ['status' => '401', 'errorMsg' => $id];
					}
				
				// Send the return data as reponse
				
				
				// } else {
					
				// 	 $response = ['status' => '401', 'errorMsg' => 'No item image selected'];
				// }
				
	 
    
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
    public function getAdvPOSItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       $server_ip = gethostbyname(gethostname());
	  //query to get images from database
	  $path = "https://salequick.com/uploads/item_image/";
				
				
				
							 
			
	       if (isset($_POST['catID'], $_POST['subCatID'])) {
				$stmt = $this->db->query("SELECT `id`,item_id, `name`,sku, `price`, `tax`,`quantity`,sold_quantity, category_id,title, CONCAT('".$path."', `item_image`) as itemImage FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and sub_category_id='".$_POST['subCatID']."' and status=0 order by id desc");
				$package_data = $stmt->result_array();
			} else if (isset($_POST['catID'])) {
				$stmt =  $this->db->query("SELECT `id`,item_id, `name`,sku, `price`, `tax`,`quantity`,sold_quantity,category_id,title, CONCAT('".$path."', `item_image`) as itemImage FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and status=0 order by id desc");
				$package_data = $stmt->result_array();
			} else {
				$stmt =  $this->db->query("SELECT `id`,item_id, `name`,sku, `price`, `tax`,`quantity`,sold_quantity,category_id,title, CONCAT('".$path."', `item_image`) as itemImage FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and status=0 order by id desc");
				$package_data = $stmt->result_array();
			}
			
		$mem = array();
		$member = array();
		
 		
			if (isset($package_data)) {
			foreach ($package_data as $each) {
		
						
				$package['id'] = $each['id'];
				$package['item_id'] = $each['item_id'];
				$package['category_id'] = $each['category_id'];
				$package['name'] = $each['name'];
				$package['sku'] = $each['sku'];
				$package['price'] = $each['price'];
				$package['tax'] = $each['tax'];
				$package['quantity'] = $each['quantity'];
				$package['title'] = is_null($each['title']) ? "Regular" : $each['title'];
				$package['soldQuantity'] = $each['sold_quantity'];
				$package['remaningQuantity'] = ($each['quantity'] !== "I") ? $each['quantity'] - $each['sold_quantity'] : $each['quantity'];
				$package['itemImage'] = $each['itemImage'];
 				
				$mem[] = $package;
		
 			}
		}
	
		$userdata = $mem;
     // Send the return data as reponse
    $status = parent::HTTP_OK;
     $response = ['status' => $status, 'UserData' => $userdata];
						
	
	 
    
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
       public function getAdvPOSMenuItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');

     $sub_merchant_id = $this->input->post('sub_merchant_id');

    $stmt_e = $this->db->query("SELECT updateInventoryPermission FROM `merchant` where merchant_id='".$merchant_id."' and id='".$sub_merchant_id."' ");
				
	$posItems_e = array();
	$package_data_e = $stmt_e->result_array();
	$package_data_e[0]['updateInventoryPermission'];

	if($sub_merchant_id > 0)
    {
    	$updateInventoryPermission=$package_data_e[0]['updateInventoryPermission'];
    }

    else 
    {
    	$updateInventoryPermission=1;
    }

    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       $server_ip = gethostbyname(gethostname());
	  //query to get images from database
	  $path = "https://salequick.com/uploads/item_image/";
				
				
				
			if (isset($_POST['catID'], $_POST['subCatID'])) {
				$stmt = $this->db->query("SELECT `id`, `name`,sku, `price`, `tax`,`quantity`,sold_quantity, category_id,size,  `item_image` as itemImage,mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and sub_category_id='".$_POST['subCatID']."' and status=0 order by id desc");
				
			} else if (isset($_POST['catID'])) {
				$stmt = $this->db->query("SELECT item_id,category_id, `name`,GROUP_CONCAT(id) as 'id',GROUP_CONCAT(sku) as 'sku', GROUP_CONCAT(`price`) as 'price',GROUP_CONCAT(`title`) as 'title',tax,GROUP_CONCAT(`quantity`) as 'quantity',GROUP_CONCAT(sold_quantity) as 'sold_quantity', `item_image` as itemImage,mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and item_id !=0 and status=0 group by item_id
				UNION SELECT item_id,category_id, `name`,`id`,sku, `price`,title, `tax`,`quantity`,sold_quantity,  `item_image` as itemImage, mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and item_id=0 and status=0  order by id desc");
				
			} else {
				$stmt = $this->db->query("SELECT item_id,category_id, `name`,GROUP_CONCAT(id) as 'id',GROUP_CONCAT(sku) as 'sku', GROUP_CONCAT(`price`) as 'price',GROUP_CONCAT(`title`) as 'title', tax,GROUP_CONCAT(`quantity`) as 'quantity',GROUP_CONCAT(sold_quantity) as 'sold_quantity',  `item_image` as itemImage, mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and item_id !=0 and status=0 group by item_id
				UNION SELECT item_id,category_id, `name`,`id`,sku, `price`,title, `tax`,`quantity`,sold_quantity, `item_image` as itemImage , mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and  item_id=0 and status=0  order by id desc");
				
			}
			
			$posItems = array();
			$package_data = $stmt->result_array();
			//echo $package_data[0]['item_id'];
			//print_r($package_data);
			
			$mem = array();
        if (isset($package_data)) {
			foreach ($package_data as $each) {
				
			    $package['item_id'] = $each['item_id'];
				$package['category_id'] = $each['category_id'];
				$package['name'] = $each['name'] ? $each['name'] : "" ;
				$package['prod_mode'] = $each['mode'] ? $each['mode'] : "0";
				// $package['remaningQuantity'] = $quantity - $sold_quantity;
				//$package['itemImage'] = $each['itemImage'] ? $each['itemImage'] : "";
				
				if(!empty($each['itemImage']))
				{
                  $package['itemImage'] = $path.$each['itemImage'];
				}
				else
				{
					$package['itemImage'] = "";
				}
            	$package['tax'] = $each['tax'] ? $each['tax'] : "";
				//$titleList=is_null($each['title']) ? $each['title'] : "Regular"  ; 
				//$titleList= $each['title'] ? $each['title'] : "Regular" ;
				$titleList= $each['title'] ? $each['title'] : "Regular"  ;
				$package['barcode_data']= $each['barcode_data'] ? $each['barcode_data'] : ""  ;
				 
				//   String to Array  
				$idarray=explode(",",$each['id']);
				$skuarray=explode(",",$each['sku']);
				$pricearray=explode(",",$each['price']);
				$taxarray=explode(",",$each['tax']);
				$quantityarray=explode(",",$each['quantity']);
				$titleListarray=explode(",",$titleList);   //  is_null($title) ? "Regular" : $each['title'] 
				$sold_quantityarray=explode(",",$each['sold_quantity']);
				$regularIndex=array_search("Regular", $each['titleListarray'],false);
				$countOfSku=count($skuarray);
				if($countOfSku > 0)
				{
					$listData=array();
					$listData2 = array();
					 for($i=0; $i < $countOfSku; $i++){
					     if(strtolower($titleListarray[$i])=="regular"){
    					    $temp12 = array();
    						$temp12['id'] = $idarray[$i];
                            $temp12['sku'] = $skuarray[$i];
    						$temp12['price'] = $pricearray[$i];
    				        $temp12['remaningQuantity'] = $quantityarray[$i] - $sold_quantityarray[$i];
    						$temp12['quantity'] = $quantityarray[$i];
    						$temp12['title'] = $titleListarray[$i] ? $titleListarray[$i] : "";
    						$temp12['soldQuantity'] = $sold_quantityarray[$i];
    						
    						array_push($listData2, $temp12);
					     }
					     else{
    						$temp2 = array();
    						$temp2['id'] = $idarray[$i];
                            $temp2['sku'] = $skuarray[$i];
    						$temp2['price'] = $pricearray[$i];
    						$temp2['quantity'] = $quantityarray[$i];
    						$temp2['title'] = $titleListarray[$i] ? $titleListarray[$i] :"";
    						$temp2['soldQuantity'] = $sold_quantityarray[$i];
					        $temp2['remaningQuantity'] = $quantityarray[$i] - $sold_quantityarray[$i];
					        
                            array_push($listData, $temp2);
					         
					     }
					 }
					 if(!empty($listData2)){
					    $listData= array_merge($listData2,$listData);
					 }
					 
				}
				
				
				// $price = array_column($listData, 'id');
    //             rsort($price);
    //             array_multisort($price, SORT_desc, $listData);
    //             // usort($listData, make_comparer('id'));
				// 
				
			foreach ($listData as $key => $row) {
                // replace 0 with the field's index/key
                $ids[$key]  = $row[0];
            }
            
            array_multisort($ids, SORT_ASC, $listData);
				// print_r($listData);die;
			$package['tierdata'] = $listData;
				/*$temp['sku'] = $sku;
				$temp['price'] = $price;
			
				$temp['quantity'] = $quantity;
				$temp['title'] = is_null($title) ? "Regular" : $title;
				$temp['soldQuantity'] = $sold_quantity;*/
				//array_push($posItems, $temp);
				$mem[] = $package;
			}
		}	
     $posItems = $mem;
    // Send the return data as reponse
    $status = parent::HTTP_OK;
     $response = ['status' => $status, 'posItems' => $posItems,'updateInventoryPermission' => $updateInventoryPermission ];
						
	
	 
    
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
    public function deleteAdvPOSItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
	   $item_id = $this->input->post('item_id');
	   
	   $getDashboard = $this->db->query("SELECT count(*) as cartItem FROM `adv_pos_cart_item` where item_id='" . $item_id . "' and merchant_id='" . $merchant_id . "' and status=0 order by id desc ");
		$getDashboardData = $getDashboard->result_array();
        $cartItem = $getDashboardData[0]['cartItem'];
			 
	   if (isset($cartItem) && $cartItem > 0) {
				
				//$response = ['status' => '401', 'errorMsg' => 'Item not deleted! Item added in cart!'];
				$response = ['status' => '401', 'errorMsg' => 'Item in use cannot be deleted!'];
				
			} else {
	   $branch_info = array(
				'status' => 2,
			);
		$this->admin_model->update_data('adv_pos_item', $branch_info, array('id' => $item_id,'merchant_id' => $merchant_id));
			
    // Send the return data as reponse
    $status = parent::HTTP_OK;
     $response = ['status' => $status, 'successMsg' => 'POS item tire deleted'];
	}
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function deleteAdvPOSMainItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
	   $item_id = $this->input->post('item_id');
	   
	 $getDashboard = $this->db->query("SELECT count(*) as cartItem FROM  `adv_pos_cart_item` ci join adv_pos_item i on i.id=ci.item_id where i.item_id='".$item_id."' and i.merchant_id='".$merchant_id."' and i.status=0 and  ci.status=0  ");
	 //  $getDashboard = $this->db->query("SELECT count(*) as cartItem FROM  `adv_pos_cart_item` ci join adv_pos_item i on i.id=ci.item_id where i.item_id='".$item_id."' and i.merchant_id='".$merchant_id."' and ci.status=0 ");
		$getDashboardData = $getDashboard->result_array();
		//print_r($getDashboardData);
        $cartItem = $getDashboardData[0]['cartItem'];
			 
	   if (isset($cartItem) && $cartItem > 0) {
				
				//$response = ['status' => '401', 'msg' => 'Item not deleted! Item added in cart!'];
				$response = ['status' => '401', 'errorMsg' => 'Item in use cannot be deleted!'];
			} else {
	   $branch_info = array(
				'status' => 2,
			);
		$this->admin_model->update_data('adv_pos_item', $branch_info, array('item_id' => $item_id,'merchant_id' => $merchant_id));
		$this->admin_model->update_data('adv_pos_item_main', $branch_info, array('id' => $item_id,'merchant_id' => $merchant_id));
			
    // Send the return data as reponse
    $status = parent::HTTP_OK;
     $response = ['status' => $status, 'successMsg' => 'POS item tire deleted'];
	}
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function editPOSItemsNew_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      $userdata = array();
	  
	  try {
 				$itemName = $_POST['name'];
				$itemCategory = $_POST['catID'];
				$merchantId = $_POST['merchant_id'];
				$tax = $_POST['tax'];
				$itemId = $_POST['item_id'];
				$prod_mode = isset($_POST['prod_mode'])?$_POST['prod_mode']:0;
				$barcode_data = $this->input->post('barcode_data') ? $this->input->post('barcode_data') : "";
				//$items = json_decode($_POST['items']);
				$items = json_decode(stripcslashes($_POST['items']));
				if (isset($_FILES['itemImage']['name'])) {
 					$date = date("mdHis");
					$image = $_FILES['itemImage']['name'];
					$exp = explode(".", $image);
					$extension = end($exp);
 					$image_name = strtolower("adv_pos_item") . "_" . $merchantId . "_" . $date . "." . $extension;
                      $config['file_name'] = $image_name; 
                    $config['upload_path']          = './uploads/item_image/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 3024;
                    $config['max_height']           = 3068;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('itemImage'))
                    {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                    }
                     $image_name =$uploadedFileName;

                     } else {
					$image_name ="";
				}
            
					 if(empty($itemId) || $itemId==0){
					     
						 $data = array(
                         'merchant_id' =>$merchantId,
                         'name' =>$itemName,
                         'category_id' =>$itemCategory, 
                         'item_img' =>$image_name,
						 );
						 $smtp1 = $this->admin_model->insert_data("adv_pos_item_main", $data);
					 }
					 else{

					 	 $data_u = array(
                         'name' =>$itemName,
                         'category_id' =>$itemCategory, 
                         'item_img' =>$image_name,
						 );
					   $data_con = array(
                         'id' =>$itemId,
                         'merchant_id' =>$merchantId
						 );
			$smtp1 = $this->admin_model->update_data("adv_pos_item_main", $data_u,$data_con);
					 
					// $smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."',`item_img`='".$image_name."' WHERE `id`='".$itemId."' and
					// `merchant_id` ='".$merchantId."'");
					 }
                    
					if ($smtp1) {
						// print_r($conn);die;
						if(empty($itemId) || $itemId==0){
						    //$itemId = $conn->insert_id;
						     $itemId = $this->db->insert_id();
						}
					//$smtp1->close();
					
						foreach ($items as $item) {
						    $is_deleted=(!empty($item->is_deleted) && $item->is_deleted==1) ? 2: 0;
						    
						    if(empty($item->id) || $item->id==0){
	                       
							
							$data = array(
							 'item_id' =>$itemId,
							 'name' =>$itemName,
							 'title' =>$item->title,
							 'sku' =>$item->sku, 
							 'price' =>$item->price,
							 'tax' =>$tax,
							 'merchant_id' =>$merchantId, 
							 'description' =>$itemName,
							 'quantity' =>$item->quantity,
							 'category_id' =>$itemCategory,
							 'mode' =>$prod_mode, 
							 'item_image' =>$image_name,
							 'barcode_data' =>$barcode_data
						 );
						 $stmt = $this->admin_model->insert_data("adv_pos_item", $data);
						 
                           }
						    else{

						    	 $data_un = array(
                         'item_id' =>$itemId,
                         'category_id' =>$itemCategory, 
                         'name' =>$itemName,
                         'title' =>$item->title, 
                         'sku' =>$item->sku,
                         'price' =>$item->price,
                         'tax' =>$tax, 
                         'description' =>$itemName,
                         'quantity' =>$item->quantity,
                         'mode' =>$prod_mode,
                         'status' =>$is_deleted, 
                         'item_image' =>$image_name,
						 );
					   $data_conn = array(
                         'id' =>$item->id,
                         'merchant_id' =>$merchantId
						 );
					   //print_r($data_conn);
			$stmt = $this->admin_model->update_data("adv_pos_item", $data_un,$data_conn);
							
		// $stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_id`='".$itemId."',`category_id`='".$itemCategory."',`name`='".$itemName."',
		// `title`='".$item->title."',`sku`='".$item->sku."',
		// 						 `price`='".$item->price."',`tax`='".$tax."',`description`='".$itemName."',
		// 						 `quantity`='".$item->quantity."',mode='".$prod_mode."', status='".$is_deleted."', `item_image`='".$image_name."'
		// 						 WHERE `id`='".$item->id."'  and `merchant_id` ='".$merchantId."'");
						
                            }
                            	if ($stmt) {
								$status = parent::HTTP_OK;
                                $response = ['status' => $status, 'successMsg' => 'Advance POS Item updated Successfully'];
 							} else {
 								$status = parent::HTTP_OK;
								//$response = ['status' => '401', 'errorMsg' => 'Server error 2!'];
								$response = ['status' => $status, 'successMsg' => 'Advance POS Item updated Successfully'];
							}
						
						}
					} else {
						$status = parent::HTTP_OK;
						//$response = ['status' => '401', 'errorMsg' => 'Server error 3!'];
						$response = ['status' => $status, 'successMsg' => 'Advance POS Item updated Successfully'];
 					}
				// } else {
				// 	$response = ['status' => '401', 'errorMsg' => 'No item image selected!'];
				// }
			} catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
	  
      // end	  
	  
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function editAdvPOSItems_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      $userdata = array();
	  
		try {
 				$stmt = $this->db->query("UPDATE `adv_pos_item` SET `quantity`=CASE
                        WHEN quantity = 'I' THEN 'I'
                        ELSE (quantity+'".$_POST['quantity']."')
                        END
                        WHERE merchant_id='".$_POST['merchant_id']."' and id='".$_POST['item_id']."' ");
				
 				if ($stmt) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Advance POS Item updated Successfully'];
 				} else {
					$response = ['status' => '401', 'errorMsg' => 'Server error!'];
				}
				//$stmt->close();
				// }
			} catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
	  
      // end	  
	  
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function addToCartold_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
        
      $userdata = array();
	  if(!empty($_POST['item_id']))
	  {
		try {
		    //echo $_POST['item_id']; die();
		    
				$merchantID = $_POST['merchant_id'];
				$user_id = $_POST['user_id'];
				$itemID = $_POST['item_id'];
				$new_price = $_POST['price'];
				$quantity = $_POST['quantity'];
				$discount = (isset($_POST['discount'])) ? $_POST['discount'] : 0;
				$price = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? $_POST['price'] * $quantity : $_POST['discounted_price'];
				$discount_amount = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? 0 : $_POST['price'] * $quantity - $_POST['discounted_price'];
				
				$stmt = $this->db->query("select count(*) as CID from adv_pos_cart_item where  merchant_id='".$merchantID."' AND user_id='".$_POST['user_id']."' AND item_id  ='".$itemID."' AND status=0 ");
				$package_data = $stmt->result_array();
				if ($package_data[0]['CID'] == 0) {
					$data = array(
							 'item_id' =>$_POST["item_id"],
							 'merchant_id' =>$_POST['merchant_id'], 
							 'user_id' =>$_POST['user_id'],
							 'quantity' =>$quantity,
							 'price' =>$price,
							 'new_price' =>$new_price,
							 'discount' =>$discount, 
							 'discount_amount' =>$discount_amount,
							
						 );
						 $stmt2 = $this->admin_model->insert_data("adv_pos_cart_item", $data);
						 
					if (!empty(stmt2)) {
						$last_id = $conn->insert_id;
						
                $stmt_tax = $this->db->query("SELECT ct.price as price_t,ct.new_price as new_price_t, it.tax as tax_t,discount as discount_t 
				FROM `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id where ct.id='".$last_id."'  and ct.status=0 order by ct.id desc");
                    $getDashboardData = $stmt_tax->result_array();
                    $new_price_t = $getDashboardData[0]['new_price_t'];
					$tax_t = $getDashboardData[0]['tax_t'];
					$discount_t = $getDashboardData[0]['discount_t'];
			
					
				if ($discount_t == "0" || $discount_t == null) {
					$price_tax = (float) $new_price_t;
					$item_price_t = (float) $price_t;
				} else {
					$price_tax = (float) $price_t;
					$disconted_price_t = (float) $price_t;
				}
 				$tax_t = $tax_t;
				$taxAmount = (float) round(($price_tax * ($tax_t / 100)), 2);
			    $totalTaxAmount = $taxAmount;
  			    $stmt_tax_update = $this->db->query("UPDATE  adv_pos_cart_item set tax_value ='".$totalTaxAmount."' where id = '".$last_id."' ");
          
						
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Item added into cart'];
					
					} else {
						
						$response = ['status' => '401', 'errorMsg' => 'Unable to add item into cart!'];
					}
				} else {
					
					$response = ['status' => '401', 'errorMsg' => 'Item already in cart!'];
				}
 			} catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
		}
		else
		{

			try {
				$merchantID = $_POST['merchant_id'];
				$user_id = $_POST['user_id'];
				$itemID = 'MIS'.date('ymdhisu');
				$new_price = $this->input->post('price') ? $this->input->post('price') : "";
				$quantity = $this->input->post('quantity') ? $this->input->post('quantity') : "";
				$user_id = $this->input->post('sub_merchant_id') ? $this->input->post('sub_merchant_id') : "";
				$discount =  0;
				$price =  $_POST['price'] * $quantity ;
				$discount_amount = 0;
				$taxAmount = (float) round(($_POST['price'] * ($_POST['tax'] / 100)), 2);
				
					$data = array(
							 'item_id' =>$itemID,
							 'merchant_id' =>$_POST['merchant_id'], 
							 'user_id' =>$user_id,
							 'quantity' =>$quantity,
							 'price' =>$price,
							 'new_price' =>$new_price,
							 'discount' =>$discount, 
							 'discount_amount' =>$discount_amount,
							 'tax_value' =>$taxAmount,
							 'isMiscelleanous' =>1
							
						 );
						 
						
						 $stmt2 = $this->admin_model->insert_data("adv_pos_cart_item", $data);
						 //echo $stmt2;
						 // print_r($data); die();

						$name = $this->input->post('name') ? $this->input->post('name') : "";
						$price = $this->input->post('price') ? $this->input->post('price') : "";
						$quantity = $this->input->post('quantity') ? $this->input->post('quantity') : "";
						$category_id  = $this->input->post('category_id') ? $this->input->post('category_id') : "";
						


						$data = Array(
						'item_id' =>$itemID,
						 'merchant_id' =>$_POST['merchant_id'],
						'category_id' =>$category_id,
						'name' => $name,
						'title' =>'',
						'price' => $price,
						'quantity' => $quantity,
						'tax' =>$taxAmount

						);
						$id = $this->admin_model->insert_data("mis_adv_pos_item", $data);
						 
					if (!empty(stmt2)) {
					
	
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Item added into cart'];
					
					} else {
						
						$response = ['status' => '401', 'errorMsg' => 'Unable to add item into cart!'];
					}
				
 			} catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
		}
	  
         // end	  
	  
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}


 public function addToCart_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
        
      $userdata = array();
	  if(!empty($_POST['item_id']))
	  {

$stmt_item = $this->db->query("select quantity as NQID from adv_pos_item where  merchant_id='".$merchant_id."' AND id  ='".$_POST['item_id']."' AND status=0 ");
				$package_data_item = $stmt_item->result_array();
				$item_quantity=$package_data_item[0]['NQID'];
				

			$stmt_cart = $this->db->query("select quantity as NQCID from adv_pos_cart_item where  merchant_id='".$merchant_id."'  AND item_id  ='".$_POST['item_id']."' AND status=0 ");
				$package_data_cart = $stmt_cart->result_array();
				$cart_quantity=$package_data_cart[0]['NQCID'];
				$available_quantity=$item_quantity-$cart_quantity;
				$required_quantity = $_POST['quantity'];
			if($required_quantity>$available_quantity && $item_quantity!='I'){
				if($item_quantity==0){

				$response = ['status' => '401', 'errorMsg' => 'Stock Not available!'];
				}
				else
				{
				$response = ['status' => '401', 'errorMsg' => 'Only "'.$item_quantity.'"  stock available!'];
				}

			} else
		  {

		try {
		    //echo $_POST['item_id']; die();
		    
				$merchantID = $_POST['merchant_id'];
				$user_id = $_POST['user_id'];
				$itemID = $_POST['item_id'];
				$new_price = $_POST['price'];
				$quantity = $_POST['quantity'];
				$discount = (isset($_POST['discount'])) ? $_POST['discount'] : 0;
				$price = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? $_POST['price'] * $quantity : $_POST['discounted_price'];
				$discount_amount = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? 0 : $_POST['price'] * $quantity - $_POST['discounted_price'];

				$item_name = $_POST['item_name'] ? $_POST['item_name'] : "";
				$item_title = $_POST['item_title'] ? $_POST['item_title'] : "";
				
				$stmt = $this->db->query("select id as CID,quantity from adv_pos_cart_item where  merchant_id='".$merchantID."' AND user_id='".$_POST['user_id']."' AND item_id  ='".$itemID."' AND status=0 ");
				$package_data = $stmt->result_array();
				if ($package_data[0]['CID'] == '') {
					$data = array(
							 'item_id' =>$_POST["item_id"],
							 'merchant_id' =>$_POST['merchant_id'], 
							 'user_id' =>$_POST['user_id'],
							 'quantity' =>$quantity,
							 'item_name' =>$item_name,
							 'item_title' =>$item_title,
							 'price' =>$price,
							 'new_price' =>$new_price,
							 'discount' =>$discount, 
							 'discount_amount' =>$discount_amount,
							
						 );
						 $stmt2 = $this->admin_model->insert_data("adv_pos_cart_item", $data);
						 
					if (!empty(stmt2)) {
						$last_id = $conn->insert_id;
						
                $stmt_tax = $this->db->query("SELECT ct.price as price_t,ct.new_price as new_price_t, it.tax as tax_t,discount as discount_t 
				FROM `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id where ct.id='".$last_id."'  and ct.status=0 order by ct.id desc");
                    $getDashboardData = $stmt_tax->result_array();
                    $new_price_t = $getDashboardData[0]['new_price_t'];
					$tax_t = $getDashboardData[0]['tax_t'];
					$discount_t = $getDashboardData[0]['discount_t'];
			
					
				if ($discount_t == "0" || $discount_t == null) {
					$price_tax = (float) $new_price_t;
					$item_price_t = (float) $price_t;
				} else {
					$price_tax = (float) $price_t;
					$disconted_price_t = (float) $price_t;
				}
 				$tax_t = $tax_t;
				$taxAmount = (float) round(($price_tax * ($tax_t / 100)), 2);
			    $totalTaxAmount = $taxAmount;
  			    $stmt_tax_update = $this->db->query("UPDATE  adv_pos_cart_item set tax_value ='".$totalTaxAmount."' where id = '".$last_id."' ");
          
						
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Item added into cart'];
					
					} else {
						
						$response = ['status' => '401', 'errorMsg' => 'Unable to add item into cart!'];

					}
				} else {
					
					$quantity = $_POST['quantity'] + $package_data[0]['quantity'];

					

					$stmt_tax_update = $this->db->query("UPDATE  adv_pos_cart_item set quantity ='".$quantity."',price ='".$price*$quantity."',new_price ='".$new_price."',discount ='".$discount."',discount_amount ='".$discount_amount."' where id = '".$package_data[0]['CID']."' ");

					$response = ['status' => 200, 'successMsg' =>''];
					
				}
 			} catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
		 }
		}
		else
		{

			try {
				$merchantID = $_POST['merchant_id'];
				$user_id = $_POST['user_id'];
				$itemID = 'MIS'.date('ymdhisu');
				$new_price = $this->input->post('price') ? $this->input->post('price') : "";
				$quantity = $this->input->post('quantity') ? $this->input->post('quantity') : "";
				$user_id = $this->input->post('sub_merchant_id') ? $this->input->post('sub_merchant_id') : "";
				$discount =  0;
				$price =  $_POST['price'] * $quantity ;
				$discount_amount = 0;
				$taxAmount = (float) round(($_POST['price'] * ($_POST['tax'] / 100)), 2);
				$item_name = $_POST['item_name'] ? $_POST['item_name'] : "";
				$item_title = $_POST['item_title'] ? $_POST['item_title'] : "";
				
					$data = array(
							 'item_id' =>$itemID,
							 'merchant_id' =>$_POST['merchant_id'], 
							 'user_id' =>$user_id,
							 'quantity' =>$quantity,
							 'item_name' =>$item_name,
							 'item_title' =>$item_title,
							 'price' =>$price,
							 'new_price' =>$new_price,
							 'discount' =>$discount, 
							 'discount_amount' =>$discount_amount,
							 'tax_value' =>$taxAmount,
							 'isMiscelleanous' =>1
							
						 );
						 
						
						 $stmt2 = $this->admin_model->insert_data("adv_pos_cart_item", $data);
						 //echo $stmt2;
						 // print_r($data); die();

						$name = $this->input->post('name') ? $this->input->post('name') : "";
						$price = $this->input->post('price') ? $this->input->post('price') : "";
						$quantity = $this->input->post('quantity') ? $this->input->post('quantity') : "";
						$category_id  = $this->input->post('category_id') ? $this->input->post('category_id') : "";
						


						$data = Array(
						'item_id' =>$itemID,
						 'merchant_id' =>$_POST['merchant_id'],
						'category_id' =>$category_id,
						'name' => $name,
						'title' =>'',
						'price' => $price,
						'quantity' => $quantity,
						'tax' =>$taxAmount

						);
						$id = $this->admin_model->insert_data("mis_adv_pos_item", $data);
						 
					if (!empty(stmt2)) {
					
	
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Item added into cart'];
					
					} else {
						
						$response = ['status' => '401', 'errorMsg' => 'Unable to add item into cart!'];
					}
				
 			} catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
		}
	  
         // end	  
	  
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function getCartItemold_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      $userdata = array();
	  
 			$path = "https://salequick.com/uploads/item_image/";
			$stmt = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,
			ct.quantity*it.price as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct join adv_pos_item it 
			on it.id=ct.item_id 
			 where ct.merchant_id='".$_POST['merchant_id']."' and ct.user_id='".$_POST['user_id']."' and ct.status=0 order by ct.id desc");
			 
			 $stmt1 = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,
			ct.quantity*it.price as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct  join mis_adv_pos_item it on it.item_id=ct.item_id
			 where ct.merchant_id='".$_POST['merchant_id']."' and ct.user_id='".$_POST['user_id']."' and ct.status=0 order by ct.id desc");
			
			$posItems = array();
			$package_data = $stmt->result_array();
			$package_data1 = $stmt1->result_array();
			
			//print_r($package_data);
			
			$mem = array();
			
			if (isset($package_data1)) {
			foreach ($package_data1 as $each) {
 						$package['id'] = $each['id'];
						$package['tier_id'] = $each['tier_id'];
						$package['item_id'] = $each['item_id'];
						$package['name'] = $each['name'];
						$package['title']  = $each['title'];
						
						if ($each['discount'] == "0" || $each['discount'] == null) {
						$package['price'] = (float) $each['new_price'];
						$package['item_price'] = (float) $each['price'];
						} else {
						$package['price'] = (float) $each['new_price'];
						$package['disconted_price'] = (float) $each['price'];
					    }
						$package['tax'] = $each['tax'];
						$package['quantity'] = $each['quantity'];
						$package['itemCost'] = (float) round(($each['price'] + ($each['quantity'] * ($each['tax']))), 2);
						$package['itemImage'] = '';
						$package['taxAmount'] = (float) round(($each['quantity'] * ($each['tax'])), 2);
 				
				$mem[] = $package;
		
 			}
		}
			
			if (isset($package_data)) {
			foreach ($package_data as $each) {
 						$package['id'] = $each['id'];
						$package['tier_id'] = $each['tier_id'];
						$package['item_id'] = $each['item_id'];
						$package['name'] = $each['name'];
						$package['title']  = $each['title'];
						
						if ($each['discount'] == "0" || $each['discount'] == null) {
						$package['price'] = (float) $each['new_price'];
						$package['item_price'] = (float) $each['price'];
						} else {
						$package['price'] = (float) $each['new_price'];
						$package['disconted_price'] = (float) $each['price'];
					    }
						$package['tax'] = $each['tax'];
						$package['quantity'] = $each['quantity'];
						$package['itemCost'] = (float) round(($each['price'] + ($each['price'] * ($each['tax'] / 100))), 2);
						$package['itemImage'] = $each['itemImage'];
						$package['taxAmount'] = (float) round(($each['price'] * ($each['tax'] / 100)), 2);
 				
				$mem[] = $package;
		
 			}
		}
		
	
		$posItems = $mem;
			
 			$totalTaxAmount = array_column($posItems, 'taxAmount');
			$totalPrice = array_column($posItems, 'itemCost');
			$newprice = array_sum($totalPrice);
			$othercharges = 0;
			
			if(	$newprice > 0) {
			 $stmt_a = $this->db->query("SELECT id,title,percentage,type FROM other_charges WHERE status='active' and merchant_id = '".$_POST['merchant_id']."' ");
			$package_data = $stmt_a->result_array();
				//print_r($package_data[0]['CID']);
			   //$galTotal = $stmt->num_rows();
			if (!empty($package_data[0]['id'])) {
			//if ($stmt_a->num_rows() > 0) {
 			$getDashboardData = $stmt_a->result_array();
                    $title = $getDashboardData[0]['title'];
					$type = $getDashboardData[0]['type'];
					$percentage = $getDashboardData[0]['percentage'];
 	            if(isset($type) && strtolower($type) == strtolower("$")){
				    
				    $otherchargess =  (float) number_format(($percentage),2);
				    $othercharges = $otherchargess ? $otherchargess : "";
				    $newprice = (float) number_format(($newprice + $percentage),2);
				}
			else if(isset($type) && strtolower($type) == strtolower("%")){
				    
				   $otherchargess = (float) number_format(($newprice * ($percentage / 100)),2);
				   $othercharges = $otherchargess ? $otherchargess : "";
				    $newprice = (float) ($newprice + number_format($newprice * ($percentage / 100),2));
				}
				
				
			
			} else {
		      	$othercharges = 0;
			    $newprice = $newprice;
			}
			}
			
			$totals = array(
				"totalPrice" => $newprice,
				"totalTaxAmount" => array_sum($totalTaxAmount),
				"otherCharges" => $othercharges,
				"otherChargeTitle" => $title ? $title  : "otherCharge" ,
				
			);
 			$status = parent::HTTP_OK;
            $response = ['status' => $status, 'posItems' => $posItems, 'totals' => $totals];
	  
	  
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}

public function getCartItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      $userdata = array();
	  
 			$path = "https://salequick.com/uploads/item_image/";
			 $stmt = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,
			ct.quantity*it.price as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct join adv_pos_item it 
			on it.id=ct.item_id 
			 where ct.merchant_id='".$_POST['merchant_id']."' and ct.user_id='".$_POST['user_id']."' and ct.status=0 order by ct.id desc");
			 
			 $stmt1 = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,
			ct.quantity*it.price as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct  join mis_adv_pos_item it on it.item_id=ct.item_id
			 where ct.merchant_id='".$_POST['merchant_id']."' and ct.user_id='".$_POST['user_id']."' and ct.status=0 order by ct.id desc");
			
			$posItems = array();
			$package_data = $stmt->result_array();
			$package_data1 = $stmt1->result_array();
			
			//print_r($package_data);
			
			$mem = array();
			
			if (isset($package_data1)) {
			foreach ($package_data1 as $each) {
 						$package['id'] = $each['id'];
						$package['tier_id'] = $each['tier_id'];
						$package['item_id'] = $each['item_id'];
						$package['name'] = $each['name'];
						$package['title']  = $each['title'];
						
						if ($each['discount'] == "0" || $each['discount'] == null) {
						$package['price'] = (float) $each['new_price'];
						$package['item_price'] = (float) $each['price'];
						} else {
						$package['price'] = (float) $each['new_price'];
						$package['disconted_price'] = (float) $each['price'];
					    }
						$package['tax'] = $each['tax'];
						$package['quantity'] = $each['quantity'];
						$itemCost_1 = (float) round(($each['price'] + ($each['quantity'] * ($each['tax']))), 2);
						$package['itemCost'] = $itemCost_1;

						$package['itemImage'] = '';
						$taxAmount_1 = (float) round(($each['quantity'] * ($each['tax'])), 2);
						$package['taxAmount'] = $taxAmount_1*$package['quantity'];
 				
				$mem[] = $package;
		
 			}
		}
			
			if (isset($package_data)) {
			foreach ($package_data as $each) {
 						$package['id'] = $each['id'];
						$package['tier_id'] = $each['tier_id'];
						$package['item_id'] = $each['item_id'];
						$package['name'] = $each['name'];
						$package['title']  = $each['title'];
						
						if ($each['discount'] == "0" || $each['discount'] == null) {
						$package['price'] = (float) $each['new_price'];
						$package['item_price'] = (float) $each['price'];
						unset($package['disconted_price']);
						} else {
						$package['price'] = (float) $each['new_price'];
						$package['disconted_price'] = (float) $each['price'];
					    }
						$package['tax'] = $each['tax'];
						$package['quantity'] = $each['quantity'];

						$itemCost_1 = (float) round(($each['price'] + ($each['price'] * ($each['tax'] / 100))), 2);
						$package['itemCost'] = $itemCost_1;
						$taxAmount_1 = (float) round(($each['price'] * ($each['tax'] / 100)), 2);
						$package['taxAmount'] = $taxAmount_1;
						$package['itemImage'] = $each['itemImage'];
						

 				
				$mem[] = $package;
		
 			}
		}
		
	
		$posItems = $mem;
			
 			$totalTaxAmount = array_column($posItems, 'taxAmount');
			$totalPrice = array_column($posItems, 'itemCost');
			$newprice = array_sum($totalPrice);
			$othercharges = 0;
			
			if(	$newprice > 0) {
			 $stmt_a = $this->db->query("SELECT id,title,percentage,type FROM other_charges WHERE status='active' and merchant_id = '".$_POST['merchant_id']."' ");
			$package_data = $stmt_a->result_array();
				//print_r($package_data[0]['CID']);
			   //$galTotal = $stmt->num_rows();
			if (!empty($package_data[0]['id'])) {
			//if ($stmt_a->num_rows() > 0) {
 			$getDashboardData = $stmt_a->result_array();
                    $title = $getDashboardData[0]['title'];
					$type = $getDashboardData[0]['type'];
					$percentage = $getDashboardData[0]['percentage'];
 	            if(isset($type) && strtolower($type) == strtolower("$")){
				    
				    $otherchargess =  (float) number_format(($percentage),2);
				    $othercharges = $otherchargess ? $otherchargess : "";
				    $newprice = (float) number_format(($newprice + $percentage),2);
				}
			else if(isset($type) && strtolower($type) == strtolower("%")){
				    
				   $otherchargess = (float) number_format(($newprice * ($percentage / 100)),2);
				   $othercharges = $otherchargess ? $otherchargess : "";
				    $newprice = (float) ($newprice + number_format($newprice * ($percentage / 100),2));
				}
				
				
			
			} else {
		      	$othercharges = 0;
			    $newprice = $newprice;
			}
			}
			
			$totals = array(
				"totalPrice" => $newprice,
				"totalTaxAmount" => array_sum($totalTaxAmount),
				"otherCharges" => $othercharges,
				"otherChargeTitle" => $title ? $title  : "otherCharge" ,
				
			);
 			$status = parent::HTTP_OK;
            $response = ['status' => $status, 'posItems' => $posItems, 'totals' => $totals];
	  
	  
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  public function getFinalTax_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
	  $path = "https://salequick.com/uploads/item_image/";
 	  $stmt1 = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,ct.quantity*it.price
	  as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id 
	  where ct.merchant_id='".$_POST['merchant_id']."' and ct.user_id='".$_POST['user_id']."' and ct.status=0 order by ct.id desc");
	  $package_data1 = $stmt1->result_array();
	  
	  $stmt2 = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,ct.quantity*it.price
	  as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct join mis_adv_pos_item it on it.item_id=ct.item_id 
	  where ct.merchant_id='".$_POST['merchant_id']."' and ct.user_id='".$_POST['user_id']."' and ct.status=0 order by ct.id desc");
	  $package_data2 = $stmt2->result_array();
	  
			
			$posItems = array();
			
	     	//$rows=$stmt->num_rows();
// 			print_r($rows);die;
			$package_data = array_merge($package_data1,$package_data2);
			//	print_r($package_data);
			//$rows = $package_data[0]['CID'];
			$rows = count($package_data);
			$mem = array();
		//	if (isset($package_data)) {
			foreach ($package_data as $each) {
				$package['id'] = $each['id'];
				$package['tier_id']= $each['tier_id'];
				$package['item_id']=$each['item_id'];
				$package['name'] = $each['name'];
				$package['title'] = $each['title'];
				// echo ($discount == "0");die;
				
				if(isset($_POST['discount_type']) && strtolower($_POST['discount_type']) == strtolower("$")){
				    $disc =  (float) number_format(($_POST['discount']/$rows),2);
				    $package['price_n'] = (float) number_format(($each['price'] - $_POST['discount']/$rows),2);
				}
				else{
				    
				    $disc = (float) number_format(($each['price'] * ($_POST['discount'] / 100)),2);
				    $package['price_n'] = (float) ($each['price'] - number_format($each['price'] * ($_POST['discount'] / 100),2));
				}
				
				$new_tax = (float) (round($package['price_n'] * ($each['tax'] / 100), 2));
				
				$stmt_tax_update = $this->db->query("UPDATE  adv_pos_cart_item set bill_tax = '".$new_tax."',bill_discount='".$disc."' where merchant_id='".$_POST['merchant_id']."' AND 
				user_id ='".$_POST['user_id']."' and status=0");
			
				if ($discount == "0" || $discount == null) {
					$package['price'] = (float) $each['new_price'];
					$package['item_price'] = (float) $package['price_n'];
				} else {
					$package['price'] = (float) $each['new_price'];
					$package['disconted_price'] = (float) $package['price_n'];
				}
				
 				$package['tax'] = $each['tax'];
				$package['quantity'] = $each['quantity'];
				
				$package['itemCost'] = (float) ($package['price_n'] + round($package['price_n'] * ($each['tax'] / 100), 2));
				$package['itemImage'] = $each['itemImage'];
				$package['taxAmount'] = (float) round(($package['price_n'] * ($each['tax'] / 100)), 2);
				$package['disc'] = $disc;
				
				$mem[] = $package;
			 }
		//	}
          $posItems = $mem;
			$totalTaxAmount = array_column($posItems, 'taxAmount');
			$totalPrice = array_column($posItems, 'itemCost');
			$totalDiscount= array_column($posItems, 'disc');
			$newprice = array_sum($totalPrice);
			$othercharges = 0;
			$newdiscount = array_sum($totalDiscount);
			$newdtaxAmount =array_sum($totalTaxAmount);
 			
			if(	$newprice > 0) {
			$stmt_a =  $this->db->query("SELECT id,title,percentage,type FROM other_charges WHERE status='active' and merchant_id = '".$_POST['merchant_id']."' ");
			$getDashboardData_a = $stmt_a->result_array();
			if (!empty($getDashboardData_a[0]['id'])) {
			//if ($stmt_a->num_rows() > 0) {
 			$getDashboardData_a = $stmt_a->result_array();
            $type = $getDashboardData_a[0]['type'];
			$title = $getDashboardData_a[0]['title'];
			$percentage = $getDashboardData_a[0]['percentage'];
			 
			
				
 	        if(isset($type) && strtolower($type) == strtolower("$")){
				    
				    $othercharges =  (float) number_format(($percentage),2);
				    
				    
				
				
				$newprice = number_format(($newprice + $othercharges),2);
 				}
			else if(isset($type) && strtolower($type) == strtolower("%")){
				    
				    $othercharges =  number_format(( $newprice * ($percentage / 100)),2);
				    $newprice =  number_format(($newprice + $othercharges),2);
				    
				  
				}
				
				
			
			} else {
		      	$othercharges = 0;
			    $newprice = $newprice;
			}
			}
			
			$totals = array(
				"totalPrice" => $newprice,
				"totalTaxAmount" => $newdtaxAmount,
				"totalDiscount" => $newdiscount,
				"otherCharges" => $othercharges,
				"otherChargeTitle" => $title ? $title  : "" ,
			);
 			$status = parent::HTTP_OK;
            $response = ['status' => $status, 'posItems' => $posItems, 'totals' => $totals];
						 
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  public function changePOS_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
	   
	   try {
				$merchantID = $_POST['merchant_id'];
				$pos_type = $_POST['pos_type'];
				$stmt2 = $this->db->query("UPDATE merchant SET pos_type='".$pos_type."' WHERE id='".$merchantID."' ");
				
				if ($this->db->affected_rows() > 0) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'pos_type' => $pos_type];
				} else {
				$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'pos_type' => $pos_type];
				}
			} catch (Exception $e) {
			
				 $response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
			
	 
			
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function setTip_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
	   
	   try {
				$merchantID = $_POST['merchant_id'];
				$tip_status = $_POST['tip_status'];
				$stmt2 = $this->db->query("UPDATE merchant SET tip='".$tip_status."' WHERE id='".$merchantID."' ");
				
				if ($this->db->affected_rows() > 0) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'tip_status' => $tip_status];
				} else {
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'tip_status' => $tip_status];
				}
			} catch (Exception $e) {
			
				 $response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
			
	 
			
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function changeReceiptMode_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
	   
	   try {
				$merchantID = $_POST['merchant_id'];
				$receipt_type = $_POST['receipt_type'];
				$stmt2 = $this->db->query("UPDATE merchant SET receipt_type='".$receipt_type."' WHERE id='".$merchantID."' ");
				
				if ($this->db->affected_rows() > 0) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'receipt_type' => $receipt_type];
				} else {
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'receipt_type' => $receipt_type];
				}
			} catch (Exception $e) {
			
				 $response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
			
	 
			
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  public function clearCartItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
			$stmt = $this->db->query("DELETE FROM `adv_pos_cart_item`  where  merchant_id='".$_POST['merchant_id']."' and user_id='".$_POST['user_id']."' and status=0 ");
			
				
				if ($this->db->affected_rows() > 0) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Cart item deleted'];
				} else {
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'No item in your cart'];
				}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  // public function editCartIemPrice_post()
// {
//     // Call the verification method and store the return value in the variable
//     $data = array();
//     $data = $this->verify_request();
//     // print_r($data->merchant_id);
//     $merchant_id = $this->input->post('merchant_id');
//     if($merchant_id == $data->merchant_id)
//     {
      
// 	if (isset($_POST['merchant_id'], $_POST['item_id'], $_POST['quantity'], $_POST['price'])) {
// 			try {
// 				$merchantID = $_POST['merchant_id'];
// 				$itemID = $_POST['item_id'];
// 				$quantity = $_POST['quantity'];
// 				$new_price = $_POST['price'];
// 				$price = $_POST['price'] * $quantity;
// 				$stmt2 = $this->db->query("UPDATE adv_pos_cart_item SET quantity='".$quantity."', price='".$price."',new_price='".$new_price."',discount=0 WHERE merchant_id='".$merchantID."' AND id ='".$itemID."' AND status=0");
				
// 				if ($stmt2->affected_rows() > 0) {
					
// 					$status = parent::HTTP_OK;
//                     $response = ['status' => $status, 'successMsg' => 'item quantity updated into cart'];
// 				} else {
					
// 					$response = ['status' => '401', 'errorMsg' => 'Unable to update item into cart'];
// 				}
// 			} catch (Exception $e) {
				
// 				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
// 			}
// 		} else {
			
// 			$response = ['status' => '401', 'errorMsg' => 'Required parameter is not selected!'];
// 		}
						
//     }
//     else
//     {
//         $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
//     }
 //     $this->response($response, $status);
// }
 public function deleteCartItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
		if (isset($_POST['merchant_id'], $_POST['item_id'])) {
 			$stmt = $this->db->query("delete FROM `adv_pos_cart_item`  where id='".$_POST['item_id']."' and merchant_id='".$_POST['merchant_id']."' and status=0 ");
			
 			if ($stmt) {
				
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Cart item deleted'];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Cart item not deleted'];
			}
			
 			} else {
			
			$response = ['status' => '401', 'errorMsg' => 'Required parameter is not selected'];
			}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  public function editCartIemPrice_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
		if (isset($_POST['merchant_id'], $_POST['item_id'], $_POST['quantity'], $_POST['price'])) {
			try {
				$merchantID = $_POST['merchant_id'];
				$itemID = $_POST['item_id'];
				$quantity = $_POST['quantity'];
				$new_price = $_POST['price'];
				$price = $_POST['price'] * $quantity;
				$stmt2 = $this->db->query("UPDATE adv_pos_cart_item SET quantity='".$quantity."', price='".$price."',new_price='".$new_price."',discount=0 WHERE merchant_id='".$merchantID."' AND id ='".$itemID."' AND status=0");
				
				if ($stmt2->affected_rows() > 0) {
					
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'item quantity updated into cart'];
					
				} else {
					
					$response = ['status' => '401', 'errorMsg' => 'Unable to update item into cart'];
				}
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
		} else {
			$response = ['status' => '401', 'errorMsg' => 'Required parameter is not selected'];
		}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  public function editAdvPOSMainItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
				if (isset($_POST['name'], $_POST['merchant_id'], $_POST['item_id'], $_POST['catID'], $_POST['tax'])) {
 			try {
				$name = $_POST["name"];
				$merchant_id = $_POST["merchant_id"];
				$catID = $_POST["catID"];
				$itemID = $_POST["item_id"];
				$tax = $_POST['tax'];
				if (isset($_FILES['itemImage']['name'])) {
 					$date = date("YmdHis");
					$image = $_FILES['itemImage']['name'];
					$exp = explode(".", $image);
					$extension = end($exp);
 					$image_name = strtolower("adv_pos_item") . "_" . $merchant_id . "_" . $date . "." . $extension;
 					//move_uploaded_file($_FILES['itemImage']['tmp_name'], UPLOAD_POS_PATH . $image_name);
					
					$config['file_name'] = $image_name; 
                    $config['upload_path']          = './uploads/item_image/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 3024;
                    $config['max_height']           = 3068;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('itemImage'))
                    {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                    }
                     $image_name =$uploadedFileName;
 					$stmt2 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$name."',category_id='".$catID."',`item_img`='".$image_name."' WHERE merchant_id='".$merchant_id."' and id='".$itemID."' ");
 					
 					if ($this->db->affected_rows() > 0) {
						
						$stmt = $this->db->query("UPDATE `adv_pos_item` SET `name`='".$name."',category_id='".$catID."', tax='".$tax."',`item_image`='".$image_name."' WHERE merchant_id='".$merchant_id."' and item_id='".$itemID."'");
  						if ($this->db->affected_rows() > 0) {
							$status = parent::HTTP_OK;
                            $response = ['status' => $status, 'successMsg' => 'Advance POS Item updated Successfully'];
 						} else {
							$response = ['status' => '401', 'errorMsg' => 'Server error'];
						}
						
					} else {
						$response = ['status' => '401', 'errorMsg' => 'Server error'];
					}
 				} else {
					$stmt2 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$name."',category_id='".$catID."' WHERE merchant_id='".$merchant_id."' and id='".$itemID."' ");
  					if ($this->db->affected_rows() > 0) {
						
						$stmt = $this->db->query("UPDATE `adv_pos_item` SET `name`='".$name."',category_id='".$catID."' tax='".$tax."' WHERE merchant_id='".$merchant_id."' and item_id='".$itemID."'  ");
  						if ($this->db->affected_rows() > 0) {
							
							$status = parent::HTTP_OK;
                            $response = ['status' => $status, 'successMsg' => 'Advance POS Item updated Successfully'];
 						} else {
							
							$response = ['status' => '401', 'errorMsg' => 'Server error'];
						}
						
					} else {
						
						$response = ['status' => '401', 'errorMsg' => 'Server error'];
					}
				}
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
			}
 		} else {
			$response = ['status' => '401', 'errorMsg' => 'Required params not available'];
		}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
   public function editCartIemold_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
		if (isset($_POST['merchant_id'],$_POST['user_id'], $_POST['item_id'], $_POST['quantity'], $_POST['price'])) {
			try {
			    if(isset($_POST['deleted_id']) && $_POST['deleted_id'] !=$_POST['item_id']){
			        	$merchantID = $_POST['merchant_id'];
        				$user_id = $_POST['user_id'];
        				$itemID = $_POST['item_id'];
        				$new_price = $_POST['price'];
        				$quantity = $_POST['quantity'];
        				$discount = (isset($_POST['discount'])) ? $_POST['discount'] : 0;
        				$price = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? $_POST['price'] * $quantity : $_POST['discounted_price'];
        				$discount_amount = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? 0 : $_POST['price'] * $quantity - $_POST['discounted_price'];
        				
					   $stmt = $this->db->query("select count(*) as CID from adv_pos_cart_item where  merchant_id='".$merchantID."' AND user_id='".$_POST['user_id']."' AND item_id  ='".$itemID."' AND status=0 ");
				       $galTotal = $stmt->num_rows();
        				//$row = $stmt->get_result()->fetch_row();
        				// print_r($row);die;
        				//$galTotal = $row[0];
        		$package_data = $stmt->result_array();
			
				if ($package_data[0]['CID'] == 0) {
						
						$data = array(
                         'item_id' =>$_POST["item_id"],
                         'merchant_id' =>$_POST['merchant_id'],
                         'user_id' =>$_POST['user_id'], 
                         'quantity' =>$quantity,
                         'price' =>$price,
                         'new_price' =>$new_price,
                         'discount' =>$discount,
						 'discount_amount' =>$discount_amount,
 						);
						$id = $this->admin_model->insert_data("adv_pos_cart_item", $data);
						
        					
							if (!empty($id)) {
        					    
        					    // tax calculate 
						//$last_id = $conn->insert_id;
						$last_id = $id;
						//$last_id = mysqli_insert_id($conn);
						
             $stmt_tax = $this->db->query("SELECT ct.price as price_t,ct.new_price as new_price_t, it.tax as tax_t,discount as discount_t FROM 
			 `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id where ct.id='".$last_id."'  and ct.status=0 order by ct.id desc");
  		   
            $package_data = $stmt_tax->result_array();			
			
				if ($package_data[0]['discount_t'] == "0" || $package_data[0]['discount_t'] == null) {
					$price_tax = (float) $package_data[0]['new_price_t'];
					$item_price_t = (float) $package_data[0]['price_t'];
				} else {
					$price_tax = (float) $package_data[0]['price_t'];
					$disconted_price_t = (float) $package_data[0]['price_t'];
				}
 				$package_data[0]['tax_t'] = $package_data[0]['tax_t'];
				$taxAmount = (float) round(($price_tax * ($package_data[0]['tax_t'] / 100)), 2);
			    $totalTaxAmount = $taxAmount;
  			    $stmt_tax_update =$this->db->query("UPDATE  adv_pos_cart_item set tax_value ='".$totalTaxAmount."' where id ='".$last_id."' ");
				
           // end tax 
        			$stmt3 = $this->db->query("delete FROM `adv_pos_cart_item`  where id='".$_POST['deleted_id']."' and merchant_id='".$_POST['merchant_id']."' and status=0 ");
                    			
        					
								$status = parent::HTTP_OK;
                                $response = ['status' => $status, 'successMsg' => 'Item updated into cart'];
        					} else {
        						
								$response = ['status' => '401', 'errorMsg' => 'Change did not happen'];
        					}
        				} else {
        					
							$response = ['status' => '401', 'errorMsg' => 'Item already in cart'];
        				}
			    }
			    else{
			    $merchantID = $_POST['merchant_id'];
				$itemID = $_POST['item_id'];
				$quantity = $_POST['quantity'];
				$new_price = $_POST['price'];
				$discount = (isset($_POST['discount'])) ? $_POST['discount'] : 0;
				$price = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? $_POST['price'] * $quantity : $_POST['discounted_price'];
				$discount_amount = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? 0 : $_POST['price'] * $quantity - $_POST['discounted_price'];
				
				$stmt2 = $this->db->query("UPDATE adv_pos_cart_item SET quantity='".$quantity."', price='".$price."',new_price='".$new_price."',
				discount='".$discount."', 
				discount_amount='".$discount_amount."'
				WHERE merchant_id='".$merchantID."' AND id ='".$itemID."' AND status=0");
				
				// tax calculate 
											
			$stmt_tax = $this->db->query("SELECT ct.price as price_t,ct.new_price as new_price_t, it.tax as tax_t,discount as discount_t 
					FROM `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id where ct.merchant_id='".$merchantID."' AND ct.id='".$merchantID."' ");
  			$package_data = $stmt_tax->result_array();	
			
				if ($package_data[0]['discount_t'] == "0" || $package_data[0]['discount_t'] == null) {
					$price_tax = (float) $price_t;
					$item_price_t = (float) $package_data[0]['price_t'];
				} else {
					$price_tax = (float) $package_data[0]['price_t'];
					$disconted_price_t = (float) $package_data[0]['price_t'];
				}
 				$package_data[0]['tax_t'] = $package_data[0]['tax_t'];
				$taxAmount = (float) round(($price_tax * ($package_data[0]['tax_t'] / 100)), 2);
			    $totalTaxAmount = $taxAmount;
 			    $stmt_tax_update = $this->db->query("UPDATE  adv_pos_cart_item set tax_value ='".$totalTaxAmoun."' where merchant_id='".$totalTaxAmoun."' AND id ='".$itemID."' ");
				
				if ($stmt2) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'item updated into cart'];
				} else {
					
					$response = ['status' => '401', 'errorMsg' => 'Change did not happen'];
				}
			    }
			
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
			}
		} else {
			
			$response = ['status' => '401', 'errorMsg' => 'Required params not selected'];
		}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}

       public function editCartIem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
		if (isset($_POST['merchant_id'],$_POST['user_id'], $_POST['item_id'], $_POST['quantity'], $_POST['price'])) {
			try {
			    if(isset($_POST['deleted_id']) && $_POST['deleted_id'] !=$_POST['item_id']){
			        	$merchantID = $_POST['merchant_id'];
        				$user_id = $_POST['user_id'];
        				$itemID = $_POST['item_id'];
        				$new_price = $_POST['price'];
        				$quantity = $_POST['quantity'];
        				$discount = (isset($_POST['discount'])) ? $_POST['discount'] : 0;
        				$price = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? $_POST['price'] * $quantity : $_POST['discounted_price'];
        				$discount_amount = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? 0 : $_POST['price'] * $quantity - $_POST['discounted_price'];
        				$item_name = $_POST['item_name'] ? $_POST['item_name'] : "";
				        $item_title = $_POST['item_title'] ? $_POST['item_title'] : "";
        				
					   $stmt = $this->db->query("select count(*) as CID from adv_pos_cart_item where  merchant_id='".$merchantID."' AND user_id='".$_POST['user_id']."' AND item_id  ='".$itemID."' AND status=0 ");
				       $galTotal = $stmt->num_rows();
        				//$row = $stmt->get_result()->fetch_row();
        				// print_r($row);die;
        				//$galTotal = $row[0];
        		$package_data = $stmt->result_array();
			
				if ($package_data[0]['CID'] == 0) {
						
						$data = array(
                         'item_id' =>$_POST["item_id"],
                         'merchant_id' =>$_POST['merchant_id'],
                         'user_id' =>$_POST['user_id'], 
                         'item_name' =>$item_name,
						 'item_title' =>$item_title,
                         'quantity' =>$quantity,
                         'price' =>$price,
                         'new_price' =>$new_price,
                         'discount' =>$discount,
						 'discount_amount' =>$discount_amount,
 						);
						$id = $this->admin_model->insert_data("adv_pos_cart_item", $data);
						
        					
							if (!empty($id)) {
        					    
        					    // tax calculate 
						//$last_id = $conn->insert_id;
						$last_id = $id;
						//$last_id = mysqli_insert_id($conn);
						
             $stmt_tax = $this->db->query("SELECT ct.price as price_t,ct.new_price as new_price_t, it.tax as tax_t,discount as discount_t FROM 
			 `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id where ct.id='".$last_id."'  and ct.status=0 order by ct.id desc");
  		   
            $package_data = $stmt_tax->result_array();			
			
				if ($package_data[0]['discount_t'] == "0" || $package_data[0]['discount_t'] == null) {
					$price_tax = (float) $package_data[0]['new_price_t'];
					$item_price_t = (float) $package_data[0]['price_t'];
				} else {
					$price_tax = (float) $package_data[0]['price_t'];
					$disconted_price_t = (float) $package_data[0]['price_t'];
				}
 				$package_data[0]['tax_t'] = $package_data[0]['tax_t'];
				$taxAmount = (float) round(($price_tax * ($package_data[0]['tax_t'] / 100)), 2);
			    $totalTaxAmount = $taxAmount;
  			    $stmt_tax_update =$this->db->query("UPDATE  adv_pos_cart_item set tax_value ='".$totalTaxAmount."' where id ='".$last_id."' ");
				
           // end tax 
        			$stmt3 = $this->db->query("delete FROM `adv_pos_cart_item`  where id='".$_POST['deleted_id']."' and merchant_id='".$_POST['merchant_id']."' and status=0 ");
                    			
        					
								$status = parent::HTTP_OK;
                                $response = ['status' => $status, 'successMsg' => 'Item updated into cart'];
        					} else {
        						
								$response = ['status' => '401', 'errorMsg' => 'Change did not happen'];
        					}
        				} else {
        					
							$response = ['status' => '401', 'errorMsg' => 'Item already in cart'];
        				}
			    }
			    else{
			    $merchantID = $_POST['merchant_id'];
				$itemID = $_POST['item_id'];
				$quantity = $_POST['quantity'];
				$new_price = $_POST['price'];
				$discount = (isset($_POST['discount'])) ? $_POST['discount'] : 0;
				$price = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? $_POST['price'] * $quantity : $_POST['discounted_price'];
				$discount_amount = (!isset($_POST['discounted_price']) || $_POST['discounted_price'] == 0) ? 0 : $_POST['price'] * $quantity - $_POST['discounted_price'];
				
				// start quantity

				$stmt_newitem = $this->db->query("select item_id as NEID from adv_pos_cart_item where  merchant_id='".$merchantID."'  AND id  ='".$_POST['item_id']."' AND status=0 ");
				$package_data_newitem = $stmt_newitem->result_array();
				$new_item_id=$package_data_newitem[0]['NEID'];

				$stmt_item = $this->db->query("select quantity as NQID from adv_pos_item where  merchant_id='".$merchantID."' AND id  ='".$new_item_id."' AND status=0 ");
				$package_data_item = $stmt_item->result_array();
				$item_quantity=$package_data_item[0]['NQID'];
				

			$stmt_cart = $this->db->query("select quantity as NQCID from adv_pos_cart_item where  merchant_id='".$merchantID."'  AND item_id  ='".$new_item_id."' AND status=0 ");
				$package_data_cart = $stmt_cart->result_array();
				$cart_quantity=$package_data_cart[0]['NQCID'];
				$available_quantity=$item_quantity-$cart_quantity;
				$required_quantity = $_POST['quantity'];
			

			if($cart_quantity==$quantity){
				$stmt2 = $this->db->query("UPDATE adv_pos_cart_item SET quantity='".$quantity."', price='".$price."',new_price='".$new_price."',
				discount='".$discount."', 
				discount_amount='".$discount_amount."'
				WHERE merchant_id='".$merchantID."' AND id ='".$itemID."' AND status=0");
				}
				elseif($required_quantity>$available_quantity && $item_quantity!='I'){

           $stmt2_new =1;
			
			  }
			  else
			  {
			  	$stmt2 = $this->db->query("UPDATE adv_pos_cart_item SET quantity='".$quantity."', price='".$price."',new_price='".$new_price."',
				discount='".$discount."', 
				discount_amount='".$discount_amount."'
				WHERE merchant_id='".$merchantID."' AND id ='".$itemID."' AND status=0");
			  }
				// else{
				// $stmt2 = $this->db->query("UPDATE adv_pos_cart_item SET quantity='".$quantity."', price='".$price."',new_price='".$new_price."',
				// discount='".$discount."', 
				// discount_amount='".$discount_amount."'
				// WHERE merchant_id='".$merchantID."' AND id ='".$itemID."' AND status=0");
				// }

				// end quantity

				
				// tax calculate 
											
			$stmt_tax = $this->db->query("SELECT ct.price as price_t,ct.new_price as new_price_t, it.tax as tax_t,discount as discount_t 
					FROM `adv_pos_cart_item` ct join adv_pos_item it on it.id=ct.item_id where ct.merchant_id='".$merchantID."' AND ct.id='".$merchantID."' ");
  			$package_data = $stmt_tax->result_array();	
			
				if ($package_data[0]['discount_t'] == "0" || $package_data[0]['discount_t'] == null) {
					$price_tax = (float) $price_t;
					$item_price_t = (float) $package_data[0]['price_t'];
				} else {
					$price_tax = (float) $package_data[0]['price_t'];
					$disconted_price_t = (float) $package_data[0]['price_t'];
				}
 				$package_data[0]['tax_t'] = $package_data[0]['tax_t'];
				$taxAmount = (float) round(($price_tax * ($package_data[0]['tax_t'] / 100)), 2);
			    $totalTaxAmount = $taxAmount;
 			    $stmt_tax_update = $this->db->query("UPDATE  adv_pos_cart_item set tax_value ='".$totalTaxAmoun."' where merchant_id='".$totalTaxAmoun."' AND id ='".$itemID."' ");
				
				if ($stmt2) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'item updated into cart'];
				}

			elseif ($stmt2_new) {
			$response = ['status' => '401', 'errorMsg' => 'Only "'.$item_quantity.'"  stock available!'];
			}
				 else {
					
					$response = ['status' => '401', 'errorMsg' => 'Change did not happen'];
				}
			    }
			
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
			}
		} else {
			
			$response = ['status' => '401', 'errorMsg' => 'Required params not selected'];
		}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
 public function upload_signature_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
   
      
			try {
 				if (isset($_FILES['logo']['name'])) {
					$pid = $_POST['payment_id'];
					$date = date("YmdHis");
					$image = $_FILES['logo']['name'];
					$exp = explode(".", $image);
					$extension = end($exp);
 					$image_name = "logo_" . $pid . "_" . $date . "." . $extension;
 					//move_uploaded_file($_FILES['logo']['tmp_name'], UPLOAD_PATH . $image_name);
					
					$config['file_name'] = $image_name; 
                    $config['upload_path']          = './logo/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 3024;
                    $config['max_height']           = 3068;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('logo'))
                    {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                    }
                     $image_name =$uploadedFileName;
  					$stmt = $this->db->query("UPDATE  pos set  sign = '".$image_name."', ip = '".$_POST['ip']."' where id = '".$_POST['payment_id']."' ");

  					$getDashboard = $this->db->query("SELECT invoice_no FROM pos WHERE  id = '" .$_POST['payment_id']. "'   ");
			$getDashboardData = $getDashboard->result_array();
             $invoice_no = $getDashboardData[0]['invoice_no'];
					
				}
 				if ($this->db->affected_rows()) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status,'invoice_no' => $invoice_no, 'successMsg' => 'Signature Uploaded Successfully'];
 				} else {
				
					$response = ['status' => '401', 'msg' => 'Could not upload file!'];
				}
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
			}
 	
						
    
     $this->response($response, $status);
}
  public function soledCartItem_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
			if (isset($_POST['merchant_id'],$_POST['user_id'], $_POST['transaction_id'])) {
		    
		    $transactionID=isset($_POST['split_invoice_no'])?$_POST['split_invoice_no']:$_POST['transaction_id'];

		    $order_id = $_POST['order_id'] ? $_POST['order_id'] : "";

 			$stmt2 = $this->db->query("select item_id as itemID, quantity from adv_pos_cart_item  where merchant_id='".$_POST['merchant_id']."' and user_id='".$_POST['user_id']."' and status=0");
			
			$package_data = $stmt2->result_array();
			$items = array();
			$quantity2=array();
			
			
			 $userdata = array();
	  
		$mem = array();
		$member = array();
		
		
			if (isset($package_data)) {
			foreach ($package_data as $each) {
			
 						$package['id'] = $each['itemID'];
						$package['quantity'] = $each['quantity'];
						
				
				$mem[] = $package;
		
 			}
		}
	
		$items = $mem;
			
 			foreach ($items as $item) {
			    
			$stmt22 = $this->db->query("select  quantity from adv_pos_item  where id='".$item['id']."' ");
			$package_data = $stmt22->result_array(); 
				
			
			   
			    $quantity = $package_data[0]['quantity'];
			   
			   
			if($quantity=='I'){
				$stmt3 = $this->db->query("UPDATE adv_pos_item SET sold_quantity=(sold_quantity+'".$item['quantity']."')  where  id='".$item['id']."'");
				
				
			}
			else
			{
			    $stmt3 = $this->db->query("UPDATE adv_pos_item SET sold_quantity=(sold_quantity+'".$item['quantity']."'),quantity=(quantity-'".$item['quantity']."')  where  id='".$item['id']."'");
				
			    
			}
			}
			$stmt = $this->db->query("UPDATE adv_pos_cart_item SET status=2, transaction_id='".$transactionID."',order_id='".$order_id."',tax='".$_POST['tax_status']."'  where merchant_id='".$_POST['merchant_id']."' and user_id='".$_POST['user_id']."' and status=0");
			
			if ($this->db->affected_rows() > 0) {
				
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Cart item soled'];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Low internet connection'];
			}
			
 		} else {
			
			$response = ['status' => '401', 'errorMsg' => 'Required parameter is not selected'];
		}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}
  public function card_detail_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
			$card_no = $_POST['card_no'];
			$merchant_id = isset($_POST['merchant_id']) ? $_POST['merchant_id'] : null;
 			if ($merchant_id == null) {
				$stmt = $this->db->query(" SELECT mobile_no,email_id from pos where card_no ='".$card_no."' order by id DESC ");
				
			} else {
				$stmt = $this->db->query(" SELECT mobile_no,email_id from pos where card_no ='".$card_no."' and merchant_id='".$merchant_id."' order by id DESC ");
				
			}
   			if ( !empty($getDashboard[0]['mobile_no']) or (!empty($getDashboard[0]['email_id'])) ) {
 				$stmt1 = $this->db->query("SELECT mobile_no from pos where card_no ='".$card_no."' and mobile_no!='' order by id DESC ");
				$getDashboard = $stmt1->result_array();
				$mobile_no1 = $getDashboard[0]['mobile_no'];
 				$stmt2 = $conn->prepare(" SELECT email_id from pos where card_no ='".$card_no."' and email_id!='' order by id DESC ");
 				$getDashboard_data = $stmt1->result_array();
				$email_id1 = $getDashboard_data[0]['email_id'];
 				$user = array(
					'mobile_no' => "", //$mobile_no1 ? $mobile_no1 : '',
					'email_id' => "", //$email_id1 ? $email_id1 : '',
 				);
 				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull', 'UserData' => $user];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'No Email And mobile no available!'];
			}
						
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}


     
}
           
