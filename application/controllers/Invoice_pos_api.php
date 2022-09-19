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
 class Invoice_pos_api extends REST_Controller {
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

  	public function cnp_payroc_payment_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
           
            
    if($merchant_id == $data->merchant_id)
    {       
    	    $p_id = $this->input->post('id');
    	    $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
			$sub_merchant_id = $_POST['sub_merchant_id'];
			$name = $_POST['name'];
			$mobile_no = $_POST['mobile_no'];
			$email_id = $_POST['email_id'];
			$new_tax = $_POST['tax'];
		    $amount = $_POST['approved_amount'];
			$card_no = $_POST['card_number_masked'];
			$card = $_POST['card'] ? $_POST['card'] : 0;
			$card_logo1 = $_POST['cardType'] ? $_POST['cardType'] : "";
			$card_logo2 = $_POST['card_type'] ? $_POST['card_type'] : "";

			if($card_logo1!='')
      {
            $card_logo = $card_logo1;
      }
     
      else
      {
           $card_logo = $card_logo2;
      } 
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
			else { $staus = 'pending';}
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
		
			$payment_id_1 = "PY" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);
			$year = date("Y");
			$month = date("m");
			$time11 = date("H");
							if ($time11 == '00') {
								$time1 = '01';
							} else {
								$time1 = date("H");
							}
			$day1 = date("N");
           
			$amount11 = $amount;
			$amount1 = $amount;
			$today_p = date("Y-m-d H:i:s");
			$auth_code1 = $_POST['authcode'] ? $_POST['authcode'] : "";

      $auth_code2 = $_POST['authCode'] ? $_POST['authCode'] : "";
      if($auth_code1!='')
      {
            $auth_code = $auth_code1;
      }
      else
      {
           $auth_code = $auth_code2;
     } 
$is_for_vts= isset($_POST['is_for_vts'])?$_POST['is_for_vts']:"false";

 			//$merchantdetails = $this->admin_model->s_fee_merchant("merchant", $merchant_id);
			
 		// 	$fee_swap = $merchantdetails['0']['text_email'];
			// $fee_invoice = $merchantdetails['0']['point_sale'];
			// $fee_email = $merchantdetails['0']['f_swap_Text'];
			// $feee = ($amount11 / 100) * $fee_invoice;
			// $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			// $fee_email = ($fee_email != '') ? $fee_email : 0;
			// $fee = $feee + $fee_swap + $fee_email;
 		// 	$discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
			// $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $amount;
			// $tip_amount = isset($_POST['tip_amount'])?$_POST['tip_amount']:0;
			 
  	// 					$data = array(
   //                         'merchant_id' =>$merchant_id,
   //                       'sub_merchant_id' =>$sub_merchant_id,
   //                       'invoice_no' =>$payment_id, 
   //                       'amount' =>$amount1,
   //                       'tax' =>$tax_n,
   //                       'fee' =>$fee,
   //                       'discount' =>$discount,
   //                       'total_amount' =>$total_amount,
   //                       'tip_amount' =>$tip_amount, 
   //                       'name' => $name, 
   //                       'card_no' =>$card_no, 
   //                       'status' =>$staus,
   //                       'date_c' =>$today2,
   //                       'mobile_no' =>$mobile_no,
   //                       'email_id' =>$email_id, 
   //                       'year' =>$year, 
   //                       'month' =>$month, 
   //                       'time1' =>$time1, 
   //                       'day1' =>$day1,
			// 			'reference' =>$reference,
			// 			'protector_tax' =>$protector_tax,
			// 			'transaction_id' =>$transaction_id_cnp,
			// 			'c_type' =>'CNP',
			// 			'pos_type' =>$pos_type,
			// 			'app_type' =>$app_type,
			// 			'card_type' =>$card_logo,
			// 			'transaction_status' =>$transaction_status,
			// 			'processor_name' =>$processor_name, 
			// 			'express_transactiondate' =>$express_transactiondate ,
			// 			'express_transactiontime' =>$express_transactiontime ,
			// 			'express_transactiontimezone' =>$express_transactiontimezone,
			// 			'other_charges' =>$otherCharges, 
			// 			'otherChargesName'=> $otherChargesName,
  	// 					);
$new_add_date= gmdate("Y-m-d H:i:s");
  						$info = array(
  							     'sub_merchant_id' =>$sub_merchant_id,
  							      'employee_pin' =>$employee_pin,
									'status' => $staus,
									//'late_fee' => $late_fee,
									//'amount' => $amount1,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2,
									'payment_date' => $today_p,
									'transaction_id' => $transaction_id_cnp,
									'message' => $message_a,
									'card_type' => $card_logo,
									'card_no' => $card_no,
									'sign' => $signImg,
									'address' => $address,
									'name_card' => $name,
									'l_name' => "",
									'address_status' => $address_status,
									'zip_status' => $zip_status,
									'cvv_status' => $cvv_status,
									'ip_a' => $_SERVER['REMOTE_ADDR'],
									'order_type' => 'a',
									'c_type' =>'CNP',
									'transaction_status' =>$transaction_status,
									'processor_name' =>$processor_name,
									'app_type' =>$app_type,
									'invoice_pos_charge' =>'yes',
									'new_add_date' => $new_add_date,
									'auth_code' =>$auth_code,
									'is_for_vts'=>$is_for_vts
								);

					$id =$this->Home_model->update_payment_single($p_id, $info);
						
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
						     $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $p_id];
						
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

  	public function cnp_payment_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
           
            
    if($merchant_id == $data->merchant_id)
    {       
    	    $p_id = $this->input->post('id');
    	    $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
			$sub_merchant_id = $_POST['sub_merchant_id'];
			$name = $_POST['name'];
			$mobile_no = $_POST['mobile_no'];
			$email_id = $_POST['email_id'];
			$new_tax = $_POST['tax'];
		    $amount = $_POST['approved_amount'];
			$card_no = $_POST['card_number_masked'];
			$card = $_POST['card'] ? $_POST['card'] : 0;
			//$card_logo = $_POST['card_logo'] ? $_POST['card_logo'] : "";
			$card_logo1 = $_POST['cardType'] ? $_POST['cardType'] : "";
			$card_logo2 = $_POST['card_type'] ? $_POST['card_type'] : "";

			if($card_logo1!='')
      {
            $card_logo = $card_logo1;
      }
     
      else
      {
           $card_logo = $card_logo2;
      } 

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
			else { $staus = 'pending';}
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
		
			$payment_id_1 = "PY" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);
			$year = date("Y");
			$month = date("m");
			$time11 = date("H");
							if ($time11 == '00') {
								$time1 = '01';
							} else {
								$time1 = date("H");
							}
			$day1 = date("N");
           
			$amount11 = $amount;
			$amount1 = $amount;
			$today_p = date("Y-m-d H:i:s");

 			//$merchantdetails = $this->admin_model->s_fee_merchant("merchant", $merchant_id);
			
 		// 	$fee_swap = $merchantdetails['0']['text_email'];
			// $fee_invoice = $merchantdetails['0']['point_sale'];
			// $fee_email = $merchantdetails['0']['f_swap_Text'];
			// $feee = ($amount11 / 100) * $fee_invoice;
			// $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			// $fee_email = ($fee_email != '') ? $fee_email : 0;
			// $fee = $feee + $fee_swap + $fee_email;
 		// 	$discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
			// $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $amount;
			// $tip_amount = isset($_POST['tip_amount'])?$_POST['tip_amount']:0;
			 
  	// 					$data = array(
   //                         'merchant_id' =>$merchant_id,
   //                       'sub_merchant_id' =>$sub_merchant_id,
   //                       'invoice_no' =>$payment_id, 
   //                       'amount' =>$amount1,
   //                       'tax' =>$tax_n,
   //                       'fee' =>$fee,
   //                       'discount' =>$discount,
   //                       'total_amount' =>$total_amount,
   //                       'tip_amount' =>$tip_amount, 
   //                       'name' => $name, 
   //                       'card_no' =>$card_no, 
   //                       'status' =>$staus,
   //                       'date_c' =>$today2,
   //                       'mobile_no' =>$mobile_no,
   //                       'email_id' =>$email_id, 
   //                       'year' =>$year, 
   //                       'month' =>$month, 
   //                       'time1' =>$time1, 
   //                       'day1' =>$day1,
			// 			'reference' =>$reference,
			// 			'protector_tax' =>$protector_tax,
			// 			'transaction_id' =>$transaction_id_cnp,
			// 			'c_type' =>'CNP',
			// 			'pos_type' =>$pos_type,
			// 			'app_type' =>$app_type,
			// 			'card_type' =>$card_logo,
			// 			'transaction_status' =>$transaction_status,
			// 			'processor_name' =>$processor_name, 
			// 			'express_transactiondate' =>$express_transactiondate ,
			// 			'express_transactiontime' =>$express_transactiontime ,
			// 			'express_transactiontimezone' =>$express_transactiontimezone,
			// 			'other_charges' =>$otherCharges, 
			// 			'otherChargesName'=> $otherChargesName,
  	// 					);
$new_add_date= gmdate("Y-m-d H:i:s");
  						$info = array(
  							     'sub_merchant_id' =>$sub_merchant_id,
  							      'employee_pin' =>$employee_pin,
									'status' => $staus,
									//'late_fee' => $late_fee,
									//'amount' => $amount1,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2,
									'payment_date' => $today_p,
									'transaction_id' => $transaction_id_cnp,
									'message' => $message_a,
									'card_type' => $card_logo,
									'card_no' => $card_no,
									'sign' => $signImg,
									'address' => $address,
									'name_card' => $name,
									'l_name' => "",
									'address_status' => $address_status,
									'zip_status' => $zip_status,
									'cvv_status' => $cvv_status,
									'ip_a' => $_SERVER['REMOTE_ADDR'],
									'order_type' => 'a',
									'c_type' =>'CNP',
									'transaction_status' =>$transaction_status,
									'app_type' =>$app_type,
									'invoice_pos_charge' =>'yes',
									'new_add_date' => $new_add_date,
								);

					$id =$this->Home_model->update_payment_single($p_id, $info);
						
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
						     $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $p_id];
						
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
                    $config['upload_path']          = './uploads/sign/';
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
  					$stmt = $this->db->query("UPDATE  customer_payment_request set  sign = '".$image_name."' where id = '".$_POST['payment_id']."' ");
					
				}
 				if ($this->db->affected_rows()) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Signature Uploaded Successfully'];
 				} else {
				
					$response = ['status' => '401', 'msg' => 'Could not upload file!'];
				}
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
			}
 	
						
    
     $this->response($response, $status);
}


}