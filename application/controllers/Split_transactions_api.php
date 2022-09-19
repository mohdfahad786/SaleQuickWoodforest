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

define('UPLOAD_PATH', 'https://salequick.com/logo/');
define('UPLOAD_POS_PATH', 'https://salequick.com/uploads/item_image/');

//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Split_transactions_api extends REST_Controller {

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

	public function get_split_invoice_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {       
    	    $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
			$otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
			$otherCharges = $_POST['otherCharges'] ? $_POST['otherCharges'] : "0";
			$sub_merchant_id = $_POST['sub_merchant_id'];
			$new_tax = $_POST['tax'];
			$protector_tax = $_POST['protector_tax'] ? $_POST['protector_tax'] : "0.00";
			$reference = trim($_POST['reference']);
			$amount = $_POST['split_amount'];
			$full_amount = $_POST['full_amount'];
			$is_split = $_POST['split_transaction'];
			$transaction_type = 'split';
			$name = '';
			$mobile_no = '';
			$email_id = '';
			$card_no = '';
			$card = '';
			$card_logo = '';
			$express_transactiondate = '';
			$express_transactiontime = '';
			$express_transactiontimezone = '';
			$transaction_id_cnp = '';
			$transaction = '';
			$processor_name = '';
			$transaction_status = '';
			$status = "pending";
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
            if (isset($_POST['invoice_no']) && !empty($_POST['invoice_no'])) {
				$payment_id = $_POST['invoice_no'];

				$stmt1x = $this->db->query("delete from pos where merchant_id='" . $merchant_id . "' and invoice_no='" . $payment_id . "' and status='pending'");

			} else {
				//$payment_id = preg_replace('/\s+/', '', "POS-S_" . $merchant_id . date("Ymdhms"));
				$payment_id_1 = preg_replace('/\s+/', '', "POS-S_" . date("Ymdhisu"));
				$payment_id = str_replace("000000", "", $payment_id_1);
				
			}
			//$split_payment_id = preg_replace('/\s+/', '', "SPI_" . $merchant_id . "-" . date("Ymdhms"));
			$split_payment_id_1 = preg_replace('/\s+/', '', "SPI_"  . "-" . date("Ymdhisu"));
			$split_payment_id = str_replace("000000", "", $split_payment_id_1);
			$year = date("Y");
			$month = date("m");
			$time1 = date("H");
			$day1 = date("N");
            $getDashboard = $this->db->query("SELECT SUM(percentage) AS PRC FROM tax WHERE  merchant_id = '" . $merchant_id . "' ");
			$getDashboardData = $getDashboard->result_array();
            $tax1 = $getDashboardData[0]['PRC'];
			if ($new_tax == '1') {

				$tax = ($tax1 / 100) * $full_amount;
			} else if ($new_tax == '0') {

				$tax = '0';
			}

			if ($tax == 0) {
				$tax_n = $protector_tax;
			} else {
				$tax_n = $tax;
			}
			if (isset($_POST['adv_pos_tax']) && $_POST['adv_pos_tax'] != 0) {
				$tax = $_POST['adv_pos_tax'];
				$tax_n = $_POST['adv_pos_tax'];
			}
			$amount11 = $full_amount + $tax;
			$amount1 = $full_amount + $tax;
			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale'];
			$fee_email = $merchantdetails['0']['f_swap_Text'];
			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
            $discount = (isset($_POST['discount']) && !empty($_POST['discount'])) ? $_POST['discount'] : 0;
			$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $full_amount;
			$tip_amount = isset($_POST['tip']) ? $_POST['tip'] : 0;
			$x = ""; 
			

						$data = array(
                         'employee_pin' =>$employee_pin,
                         'otherChargesName'=>$otherChargesName,
                         'other_charges'=>$otherCharges,
                         'merchant_id'=>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'invoice_no'=>$payment_id, 
                         'amount'=>$amount,
                         'tax'=>$tax_n,
                         'fee'=>$fee,
                         'discount'=>$discount,
                         'total_amount'=>$total_amount,
                         'tip_amount'=>$tip_amount,
                         'full_amount'=>$full_amount,
                         'transaction_type'=>$transaction_type,
                         'split_payment_id'=>$split_payment_id ,
                         'status'=>$status,   
                         'date_c'=>$today2,
                         'year'=>$year, 
                         'month' =>$month, 
                         'time1' =>$time1, 
                         'day1' =>$day1,
						'reference' =>$reference,
                         'protector_tax'=>$protector_tax,
                         'c_type'=>''

						);
						$id = $this->admin_model->insert_data("pos", $data);
						
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Successfull','invoice_no' => $payment_id,
				'split_payment_id' => $split_payment_id];
						
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
					
					
					
public function get_split_transactions_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
   
   //if (isTheseParametersAvailable(array('invoice_no'))) {
       if (isset($_POST['invoice_no'])) {
			$invoice_no = $_POST['invoice_no'];
			$merchant_id = isset($_POST['merchant_id']) ? $_POST['merchant_id'] : null;
			//$stmt = $conn->prepare("SELECT count(id) as NewTotalOrders FROM customer_payment_request WHERE date_c = CURDATE() and merchant_id = ? ");
			if ($merchant_id == null) {
				$stmt = $this->db->query(" SELECT transaction_id,amount, full_amount,card_no,c_type from pos where invoice_no = '".$invoice_no."' and status='confirm' order by id DESC ");
				
			} else {
				$stmt = $this->db->query("SELECT transaction_id,amount, full_amount,card_no,c_type from pos where invoice_no = '".$invoice_no."' and merchant_id='".$merchant_id."' and status='confirm' order by id DESC ");
				
			}
			$package_data = $stmt->result_array();
			
			$trnArr = array();
			$totalPayedAmount = 0;
			$fullAmount = 0;
			
			$mem = array();
		
			if (isset($package_data)) {
			foreach ($package_data as $each) {
			
						
						$package['transaction_id'] = $each['transaction_id'];
						$package['amount'] = $each['amount'];
						$package['full_amount'] = $each['full_amount'];
						$package['card_no'] = $each['card_no'];
						$package['c_type'] = $each['c_type'];
						$totalPayedAmount += (float) $each['amount'];
						$fullAmount = (float) $each['full_amount'];
						
				
				$mem[] = $package;
		

			}
		}
	
		$trnArr = $mem;

			
			$remaning_amount = round($fullAmount - $totalPayedAmount, 2);
			
			$status = parent::HTTP_OK;
            $response = ['status' => $status, 'remaning_amount' => $remaning_amount, 'data' => $trnArr];

		} else {

			$response = ['status' => '401', 'msg' => 'Required Param missing'];
		}

    $this->response($response, $status);
}

public function get_payment_option_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
      
		//if (isTheseParametersAvailable('merchant_id', 'user_id')) {
		 if (isset($_POST['merchant_id'],$_POST['user_id'])) {
			$stmt = $this->db->query("SELECT `id`, `name` FROM `payment_mode` where merchant_id='".$_POST['merchant_id']."'  and status=1 order by id desc");
			
			$package_data = $stmt->result_array();
			$posItems = array();

			$stmt_a = $this->db->query("SELECT payroc FROM merchant WHERE id='".$_POST['merchant_id']."'");

            $getDetail = $stmt_a->result_array();
            $CNP_WP_Payroc=$getDetail[0]['payroc'];

			$mem = array();
		
			if (isset($package_data)) {
			foreach ($package_data as $each) {
						
						$package['id'] = $each['id'];
						$package['name'] = $each['name'];
				
				$mem[] = $package;
		

			}
		}
	
		$posItems = $mem;
		
			
			
			$status = parent::HTTP_OK;
            $response = ['status' => $status,'data' => $posItems,'CNP_WP_Payroc' => $CNP_WP_Payroc];

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



public function split_cash_payment_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
      
		try {
                $app_type = $_POST['app_type'];
				$merchant_id = trim($_POST['merchant_id']);
				$employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
				$sub_merchant_id = trim($_POST['sub_merchant_id']);
			$otherCharges = $_POST['otherCharges'] ? $_POST['otherCharges'] : "0";
				$otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
				$name = $_POST['name'];
				$mobile_no = "";
				$email_id = "";
				// $tax1 = $_POST['tax'];
				// $protector_tax = $_POST['protector_tax'];
				// $reference = trim($_POST['reference']);
				
				$tax1 = $_POST['tax'] ? $_POST['tax'] : "";
				$protector_tax = $_POST['protector_tax'] ? $_POST['protector_tax'] : "0.00";
				$reference = trim($_POST['reference']) ? trim($_POST['reference']) : "";
				
				$amount = $_POST['approved_amount'] ? $_POST['approved_amount'] : 0;
				$payment_mode = strtoupper($_POST['payment_mode']) ? strtoupper($_POST['payment_mode']) : "";
				$card = $payment_mode;
				$card_no = (isset($_POST['cheque_no']) && !empty($_POST['cheque_no'])) ? $_POST['cheque_no'] : 000000;
				$reference_numb_opay = isset($_POST['reference_numb_opay']) ? $_POST['reference_numb_opay'] : 0;
				$card_logo = $payment_mode;

				$express_transactiondate = $_POST['express_transaction_date'] ? $_POST['express_transaction_date'] : 0;
			$express_transactiontime = $_POST['express_transaction_time'] ? $_POST['express_transaction_time'] : 0;
			$express_transactiontimezone = $_POST['express_transaction_time_zone'] ? $_POST['express_transaction_time_zone'] : 0;
				$transaction_id_cnp = "" . date("YmdHis");
				$transaction = "" . date("mdHis");
				$processor_name = $_POST['processor_name'] ? $_POST['processor_name'] : "" ;
				$invoice_no = trim($_POST['invoice_no']);
				$split_payment_id = trim($_POST['split_payment_id']);
				$staus = 'confirm';
				$transaction_status = '';
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
				$payment_id = "POS_" . date("Ymdhms");
				$year = date("Y");
				$month = date("m");
				$time1 = date("H");
				$day1 = date("N");

				$amount11 = $amount + $tax1;
				$amount1 = $amount + $tax1;

				
				$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
				$fee_swap = $merchantdetails['0']['text_email'];
				$fee_invoice = $merchantdetails['0']['point_sale']; 
				$fee_email = $merchantdetails['0']['f_swap_Text'];
				

                //$tip_amount = isset($_POST['tip_amount']) ? $_POST['tip_amount'] : 0;
				$feee = ($amount11 / 100) * $fee_invoice;
				$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
				$fee_email = ($fee_email != '') ? $fee_email : 0;
				$fee = $feee + $fee_swap + $fee_email;
				$discount = isset($_POST['discount']) ? $_POST['discount'] : "$" . "0.00";
				$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $amount;

				if ($split_payment_id == false || $split_payment_id == 'false') {
										$response['error'] = true;
					$response['errorMsg'] = 'No SPLIT PAYMENT ID';

				} else {
				    
					
				$stmt = $this->db->query("update pos set  otherChargesName='".$otherChargesName."',employee_pin='".$employee_pin."',other_charges='".$otherCharges."',name='".$name."',card_no='".$card_no."', status='".$staus."', date_c='".$today2."', year='".$year."', month='".$month."', time1='".$time1."', day1='".$day1."', reference='".$reference."',protector_tax='".$protector_tax."',card='".$card."',card_type='".$card_logo."'
				,express_transactiondate='".$express_transactiondate."',express_transactiontime='".$express_transactiontime."',express_transactiontimezone='".$express_transactiontimezone."',processor_name='".$processor_name."',transaction_id='".$transaction_id_cnp."',c_type='".$payment_mode."',reference_numb_opay='".$reference_numb_opay."',app_type='".$app_type."'
                    where  merchant_id ='".$merchant_id."' AND invoice_no='".$invoice_no."' AND split_payment_id='".$split_payment_id."'");

			
				    
				}
				if ($stmt) {
				    
				   
					

				////===========
					$stmt1 = $this->db->query("SELECT id,transaction_id,amount, full_amount,card_no,c_type,split_payment_id from pos where invoice_no ='".$invoice_no."' and merchant_id='".$merchant_id."' and status='confirm' order by id DESC  ");

					//$stmt1->bind_result($id, $transaction_id, $amount, $full_amount, $card_no, $c_type, $spid);
                    $package_data = $stmt1->result_array();
					$trnArr = array();
					$totalPayedAmount = 0;
					$fullAmount = 0;
					$lastId = "xx";

					// while ($stmt1->fetch()) {
					// 	if ($spid == $split_payment_id) {
					// 		$lastId = $id;
					// 	}
					// 	$temp['id'] = $id;
					// 	$temp['transaction_id'] = $transaction_id;
					// 	$temp['amount'] = $amount;
					// 	$temp['full_amount'] = $full_amount;
					// 	$temp['card_no'] = $card_no;
					// 	$temp['c_type'] = $c_type;
					// 	$totalPayedAmount += (float) $amount;
					// 	$fullAmount = (float) $full_amount;
					// 	array_push($trnArr, $temp);
					// }

					$mem = array();
		
					if (isset($package_data)) {
					foreach ($package_data as $each) {
								

						if ($each['split_payment_id'] == $split_payment_id) {
							$lastId = $each['id'];
						}
						$package['id'] = $each['id'];
						$package['transaction_id'] = $each['transaction_id'];
						$package['amount'] = $each['amount'];
						$package['full_amount'] = $each['full_amount'];
						$package['card_no'] = $each['card_no'];
						$package['c_type'] = $each['c_type'];
						$totalPayedAmount += (float) $each['amount'];
						$fullAmount = (float) $each['full_amount'];

						
						$mem[] = $package;
				

						}
					}

					$trnArr = $mem;

					
				
					$id = strval($lastId);
					$invoice_no = $invoice_no;
					$remaning_amount = round($fullAmount - $totalPayedAmount, 2);
					$data = $trnArr;
					
					//Satrt QuickBook sync
  $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id and status='1' and pos_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                            $Qurl ="https://salequick.com/quickbook/get_invoice_detail_split";
                            $qbdata =array(
                            'id' => $id,
                            'merchant_id' => $merchant_id
                            
                            );
                            
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, $Qurl);
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

					$status = parent::HTTP_OK;
                    $response = ['status' => $status,'successMsg' => 'Successfull','id' => $id,'invoice_no' => $invoice_no,'remaning_amount' => $remaning_amount,'data' => $trnArr];

					///==================
				} else {

				
					$response = ['status' => '401', 'errorMsg' => 'Fail'];
				}
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Cash Transection Fail'];
			}	
						
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



public function split_cp_payment_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
            $app_type = $_POST['app_type'];
			$merchant_id = $_POST['merchant_id'];
			$employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
			$otherCharges = $_POST['otherCharges'] ? $_POST['otherCharges'] : "0";
			$sub_merchant_id = $_POST['sub_merchant_id'] ? $_POST['sub_merchant_id'] : "0";
				$otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
			$name = $_POST['name'] ? $_POST['name'] : "";
			$amount = $_POST['amount'] ? $_POST['amount'] : "";
			$full_amount = $_POST['full_amount'] ? $_POST['full_amount'] : "";
			$card_no = $_POST['card_no'] ? $_POST['card_no'] : "";
			$transaction_guid = $_POST['transaction_guid'] ? $_POST['transaction_guid'] : "";
			$pos_entry_mode = $_POST['pos_entry_mode'] ? $_POST['pos_entry_mode'] : "";
			$transaction_id = $_POST['transaction_id'] ? $_POST['transaction_id'] : "";
			$client_transaction_id = $_POST['client_transaction_id'] ? $_POST['client_transaction_id'] : "";
			$card_type = $_POST['card_type'] ? $_POST['card_type'] : "";
			$invoice_no = $_POST['split_invoice_no'] ? $_POST['split_invoice_no'] : "";
			$split_payment_id = $_POST['split_payment_id'] ? $_POST['split_payment_id'] : "";
			$reference = $_POST['reference'] ? $_POST['reference'] : "";
			$tax = $_POST['tax_amount'] ? $_POST['tax_amount'] : "";
			$transaction_status = $_POST['transaction_status'];
			if ($transaction_status == 'Declined') {
				$status = 'declined';
			} else if ($transaction_status == 'Approved') {
				$status = 'confirm';
			}
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

			if (isset($_POST['adv_pos_tax']) && $_POST['adv_pos_tax'] != 0) {
				$tax = $_POST['adv_pos_tax'];
				$tax_n = $_POST['adv_pos_tax'];
			}

			$amount1 = $full_amount;
			$amount11 = $full_amount;


			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale']; 
			$fee_email = $merchantdetails['0']['f_swap_Text'];


			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
			$tip_amount = isset($_POST['tip_amount']) ? $_POST['tip_amount'] : 0;
			$discount = isset($_POST['discount']) ? $_POST['discount'] : "$" . "0.00";
			$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $full_amount;

			/*Extra Param Added 31-10-2019*/
			$version = (isset($_POST["version"])) ? $_POST["version"] : "N/A";
			$serialNumber = (isset($_POST["serialNumber"])) ? $_POST["serialNumber"] : "N/A";
			$terminalID = (isset($_POST["terminalID"])) ? $_POST["terminalID"] : "N/A";
			$storeID = (isset($_POST["storeID"])) ? $_POST["storeID"] : "N/A";
			$chainID = (isset($_POST["chainID"])) ? $_POST["chainID"] : "N/A";
			$paymentServiceTimezone = (isset($_POST["paymentServiceTimezone"])) ? $_POST["paymentServiceTimezone"] : "N/A";
			$paymentServiceTimestamp = (isset($_POST["paymentServiceTimestamp"])) ? $_POST["paymentServiceTimestamp"] : "N/A";
			$deviceTimezone = (isset($_POST["deviceTimezone"])) ? $_POST["deviceTimezone"] : "N/A";
			$deviceTimestamp = (isset($_POST["deviceTimestamp"])) ? $_POST["deviceTimestamp"] : "N/A";
			$processorTimezone = (isset($_POST["processorTimezone"])) ? $_POST["processorTimezone"] : "N/A";
			$processorTimestamp = (isset($_POST["processorTimestamp"])) ? $_POST["processorTimestamp"] : "N/A";

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

			if ($split_payment_id == false || $split_payment_id == 'false') {
				
				$response['error'] = true;
				$response['errorMsg'] = 'No SPLIT PAYMENT ID';
			} else {


            

				$stmt = $this->db->query("update pos set otherChargesName='".$otherChargesName."',employee_pin='".$employee_pin."',other_charges='".$otherCharges."',name='".$name."',card_no='".$card_no."',transaction_guid='".$transaction_guid."', pos_entry_mode='".$pos_entry_mode."',transaction_id='".$transaction_id."', client_transaction_id='".$client_transaction_id."', card_type='".$card_type."',  date_c='".$today2."', year='".$year."', month='".$month."', time1='".$time1."', day1='".$day1."',reference='".$reference."',
	            `processorTimestamp`='".$processorTimestamp."', `processorTimezone`='".$processorTimezone."',`deviceTimestamp`='".$deviceTimestamp."', `deviceTimezone`='".$deviceTimezone."', `paymentServiceTimestamp`='".$paymentServiceTimestamp."', `paymentServiceTimezone`='".$paymentServiceTimezone."', `chainID`='".$chainID."', `storeID`='".$storeID."',`auth_code`='".$auth_code."',`terminalID`='".$terminalID."', `version`='".$version."',
	            `serialNumber`='".$serialNumber."',status='".$status."',app_type='".$app_type."',c_type='CP',transaction_type='split' where invoice_no='".$invoice_no."' and merchant_id ='".$merchant_id."' and split_payment_id='".$split_payment_id."'");
			
            if(!empty($rawResponse)){
			 $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$split_payment_id,
                        'rawResponse' =>$rawResponse,
                         
                        );
                        $pax_id = $this->admin_model->insert_data("payroc_json", $data_pax);
            }
				
			}
			// print_r($stmt);die;
			if ($stmt) {

				
				////===========
					$stmt1 = $this->db->query("SELECT id,transaction_id,amount, full_amount,card_no,c_type,split_payment_id from pos where invoice_no ='".$invoice_no."' and merchant_id='".$merchant_id."' and status='confirm' order by id DESC ");

		//$stmt1->bind_result($id, $transaction_id, $amount, $full_amount, $card_no, $c_type, $spid);
					$trnArr = array();
					$totalPayedAmount = 0;
					$fullAmount = 0;
					$lastId = "xx";
					$package_data = $stmt1->result_array();

					$mem = array();
		
					if (isset($package_data)) {
					foreach ($package_data as $each) {
								

						if ($each['split_payment_id'] == $split_payment_id) {
							$lastId = $each['id'];
						}
						$package['id'] = $each['id'];
						$package['transaction_id'] = $each['transaction_id'];
						$package['amount'] = $each['amount'];
						$package['full_amount'] = $each['full_amount'];
						$package['card_no'] = $each['card_no'];
						$package['c_type'] = $each['c_type'];
						$totalPayedAmount += (float) $each['amount'];
						$fullAmount = (float) $each['full_amount'];
						$mem[] = $package;

						}
					}

					$trnArr = $mem;


					$id = strval($lastId);
					$invoice_no = $invoice_no;
					$remaning_amount = round($fullAmount - $totalPayedAmount, 2);
					$data = $trnArr;
					
						//Satrt QuickBook sync
  $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id and status='1' and pos_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                            $Qurl ="https://salequick.com/quickbook/get_invoice_detail_split";
                            $qbdata =array(
                            'id' => $id,
                            'merchant_id' => $merchant_id
                            
                            );
                            
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, $Qurl);
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

					$status = parent::HTTP_OK;
                    $response = ['status' => $status,'successMsg' => 'Successfull','id' => $id,'invoice_no' => $invoice_no,'remaning_amount' => $remaning_amount,'data' => $trnArr];
					///==================
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}
		} else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}





public function split_cnp_payment_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
            $app_type = $_POST['app_type'];
			$invoice_no = $_POST['invoice_no'];
			$employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
			$split_payment_id = $_POST['split_payment_id'];
			$merchant_id = $_POST['merchant_id'];
			$otherCharges = $_POST['otherCharges'] ? $_POST['otherCharges'] : "0";
			 $auth_code1 = $_POST['authcode'] ? $_POST['authcode'] : "";
			 $rawResponse = $_POST['rawResponse'] ? $_POST['rawResponse'] : "";
      $rawRequest = $_POST['rawRequest'] ? $_POST['rawRequest'] : "";

      $auth_code2 = $_POST['authCode'] ? $_POST['authCode'] : "";
      if($auth_code1!='')
      {
            $auth_code = $auth_code1;
      }
      else
      {
           $auth_code = $auth_code2;
     } 
			$otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
			$sub_merchant_id = $_POST['sub_merchant_id'];
			$name = $_POST['name'];
			$mobile_no = $_POST['mobile_no'];
			$email_id = $_POST['email_id'];
			$new_tax = $_POST['tax'];
			$protector_tax = $_POST['protector_tax'];
			$reference = trim($_POST['reference']);
			$amount = $_POST['approved_amount'];
			$card_no = $_POST['card_number_masked'];
			$card = $_POST['card'];
			
			 $card_logo1 = $_POST['card_logo'] ? $_POST['card_logo'] : "";

      $card_logo2 = $_POST['cardType'] ? $_POST['cardType'] : "";
      if($card_logo1!='')
      {
            $card_logo = $card_logo1;
      }
      else
      {
           $card_logo = $card_logo2;
     } 
			$express_transactiondate = $_POST['express_transaction_date'];
			$express_transactiontime = $_POST['express_transaction_time'];
			$express_transactiontimezone = $_POST['express_transaction_time_zone'];
			$transaction_id_cnp = $_POST['transactionID'];
			$transaction = $_POST['transaction'] ? $_POST['transaction'] :"0.00";
			$processor_name = $_POST['processor_name'] ? $_POST['processor_name'] :"";
			$transaction_status = $_POST['transaction_status'];

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
			$year = date("Y");
			$month = date("m");
			$time1 = date("H");
			$day1 = date("N");
			

			$getDashboard = $this->db->query("SELECT SUM(percentage) AS PRC FROM tax WHERE  merchant_id = '" . $merchant_id . "' and status='active' ");
			$getDashboardData = $getDashboard->result_array();
            $tax1 = $getDashboardData[0]['PRC'];


			if ($new_tax == '1') {

				$tax = ($tax1 / 100) * $amount;
			} else if ($new_tax == '0') {

				$tax = '0';
			}

			if ($tax == 0) {
				$tax_n = $protector_tax;
			} else {
				$tax_n = $tax;
			}
			if (isset($_POST['adv_pos_tax']) && $_POST['adv_pos_tax'] != 0) {
				$tax = $_POST['adv_pos_tax'];
				$tax_n = $_POST['adv_pos_tax'];
			}
			$amount11 = $amount + $tax;
			$amount1 = $amount + $tax;


			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale']; 
			$fee_email = $merchantdetails['0']['f_swap_Text'];


			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;

			$discount = isset($_POST['discount']) ? $_POST['discount'] : "$" . "0.00";
			$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $amount;
			$tip_amount = isset($_POST['tip_amount']) ? $_POST['tip_amount'] : 0;

			if ($split_payment_id == false || $split_payment_id == 'false') {
			
				$response['error'] = true;
				$response['errorMsg'] = 'No SPLIT PAYMENT ID';

			} else {


				
				$stmt = $this->db->query("update pos set otherChargesName='".$otherChargesName."',employee_pin='".$employee_pin."',other_charges='".$otherCharges."', name='".$name."' , card_no='".$card_no."', status='".$staus."',   date_c='".$today2."',mobile_no='".$mobile_no."',email_id='".$email_id."', year='".$year."', month='".$month."', time1='".$time1."', day1='".$day1."',
                                      reference='".$reference."',protector_tax='".$protector_tax."',card='".$card."',card_type='".$card_logo."',
                                        express_transactiondate='".$express_transactiondate."' ,express_transactiontime='".$express_transactiontime."' ,express_transactiontimezone='".$express_transactiontimezone."',
                                       processor_name='".$processor_name."' ,transaction='".$transaction."' ,transaction_id='".$transaction_id_cnp."' ,auth_code='".$auth_code."',rawRequest='".$rawRequest."',rawResponse='".$rawResponse."',
                                       transaction_status='".$transaction_status."',
                                       app_type='".$app_type."' ,c_type='CNP'  where invoice_no='".$invoice_no."' and merchant_id ='".$merchant_id."' and split_payment_id='".$split_payment_id."' ");


			}

			if ($stmt) {
				
				////===========
					$stmt1 = $this->db->query("SELECT id,transaction_id,amount, full_amount,card_no,c_type,split_payment_id from pos where invoice_no ='".$invoice_no."' and merchant_id='".$merchant_id."' and status='confirm' order by id DESC ");
					
					 $package_data = $stmt1->result_array();

					$trnArr = array();
					$totalPayedAmount = 0;
					$fullAmount = 0;
					$lastId = "xx";
					
                     $mem = array();
		
					if (isset($package_data)) {
					foreach ($package_data as $each) {
								

						if ($each['split_payment_id'] == $split_payment_id) {
							$lastId = $each['id'];
						}
						$package['id'] = $each['id'];
						$package['transaction_id'] = $each['transaction_id'];
						$package['amount'] = $each['amount'];
						$package['full_amount'] = $each['full_amount'];
						$package['card_no'] = $each['card_no'];
						$package['c_type'] = $each['c_type'];
						$totalPayedAmount += (float) $each['amount'];
						$fullAmount = (float) $each['full_amount'];
						$mem[] = $package;

						}
					}

					$trnArr = $mem;

				

					$id = strval($lastId);
					$invoice_no = $invoice_no;
					$remaning_amount = round($fullAmount - $totalPayedAmount, 2);
					$data = $trnArr;
					
						//Satrt QuickBook sync
  $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id and status='1' and pos_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                            $Qurl ="https://salequick.com/quickbook/get_invoice_detail_split";
                            $qbdata =array(
                            'id' => $id,
                            'merchant_id' => $merchant_id
                            
                            );
                            
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, $Qurl);
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

					$status = parent::HTTP_OK;
                    $response = ['status' => $status,'successMsg' => 'Successfull','id' => $id,'invoice_no' => $invoice_no,'remaning_amount' => $remaning_amount,'data' => $trnArr];



					///==================
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail!'];
			}
		} else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}
    
    
}

