<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");
class Invoice_pos_mail_api extends REST_Controller {
    public function __construct() {
        parent::__construct();
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
    $headers = $this->input->request_headers();
    $token = $headers['X-Requested-With'];
    
   
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

public function add_pos_mail_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
			
				$merchant_id = $_POST['merchant_id'];
				 $payment_id = $_POST['payment_id'];
				$sid = $_POST['id'];
				$type = $_POST['type'];
				$data= array();
				


	$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" .$merchant_id ."' and id  ='".$payment_id."' ");



							$getEmail = $getQuery->result_array();

								
							$data['getEmail'] = $getEmail;


	$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' ");
			$getEmail1 = $getQuery1->result_array(); //print_r($getEmail1);  die();
			$data['getEmail1'] = $getEmail1;

			

			$late_grace_period = $getEmail1[0]['late_grace_period'];
			if($getEmail[0]['payment_type'] == 'recurring') {
				$payment_date = date('Y-m-d', strtotime($getEmail[0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
			} else {
				$payment_date = date('Y-m-d', strtotime($getEmail[0]['due_date']. ' + '.$late_grace_period.' days'));
			}
			$late_fee = $getEmail1[0]['late_fee_status'] > 0 && date('Y-m-d') > $payment_date ? $getEmail1[0]['late_fee'] : 0 ;

              
				$invoice_no =  $getEmail[0]['invoice_no'];
				$payment_invoice_no =  $getEmail[0]['payment_id'];
				$date_c = $getEmail[0]['date_c'];
				$sign = $getEmail[0]['sign'];
				$other_charges=$getEmail[0]['other_charges'];
				
				if($otherChargesName=='')
				{
				    $otherChargesName ='Other Charges';
				}
				else
				{
				  $otherChargesName = $otherChargesName;  
				}
				$transaction_id = $getEmail[0]['transaction_id'];
				$card_type = $getEmail[0]['card_type'];
				$mobile_no = $getEmail[0]['mobile_no'];



				// $transaction_status = $getDetail[0]['transaction_status'];
				// $nameR = (isset($_POST['recipient_name'])) ? $_POST["recipient_name"] : $getDetail[0]['name'];
				// $c_name = (isset($_POST['receipt_type']) && $_POST['receipt_type'] == 1) ? $nameR : "";
				// $cc_name = $c_name;
				// $reference = $getDetail[0]['reference'];
				// if ($referenc == '0') {$referenc = 'N/A';} else { $referenc = $referenc;}
				// $card_no = $getDetail[0]['card_no'];
				// $card_no_1 = substr($card_no, -4);
				//$signn = 'https://salequick.com/logo/'.$sign;
				// $p_date = date('F j, Y',strtotime($date_c));
				$p_date = date('F d, Y', strtotime($date_c));
				$mob = str_replace(array('(', ')', '-', ' '), '', $mobile_no);
				$mobile = '+1' . $mob;
				$url = 'https://salequick.com/reciept/' . $payment_invoice_no . '/' . $merchant_id;
				
				if ($type == 'email') {
					try {
						// $stmt = $this->db->query("UPDATE  pos set name='".$nameR."', email_id ='".$sid."', receipt_type=IFNULL (CONCAT( receipt_type ,',', 'email'), 'email') where id ='".$payment_id."' ");


						// Start New code


	
							$data['resend'] = "";
							$email = $getEmail[0]['email_id'];
							$amount = $getEmail[0]['amount'];
							$sub_total = $getEmail[0]['sub_total'];
							$tax = $getEmail[0]['tax'];
							$originalDate = $getEmail[0]['date_c'];
							$newDate = date("F d,Y", strtotime($originalDate));


							$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $payment_id));
							//Email Process
							
							$data['email'] = $getEmail[0]['email_id'];
							$data['color'] = $getEmail1[0]['color'];
							$data['amount'] = $getEmail[0]['amount'];
							$data['sub_total'] = $getEmail[0]['sub_total'];
							$data['tax'] = $getEmail[0]['tax'];
							$data['originalDate'] = $getEmail[0]['date_c'];
							$data['card_a_no'] = $getEmail[0]['card_no'];
							$data['invoice_detail_receipt_item'] = $item;
							$data['trans_a_no'] = $getEmail[0]['transaction_id'];
							$data['card_a_type'] = $getEmail[0]['card_type'];
							$data['message_a'] = $message_a;
							$data['late_grace_period'] = $getEmail1[0]['late_grace_period'];
							$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
							$data['late_fee'] = $getEmail[0]['late_fee'];
							$data['recurring_type'] = $getEmail[0]['recurring_type'];
							$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
							$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';

							

							$data['msgData'] = $data;
							//Send Mail Code

							

							$msg = $this->load->view('email/new_receipt', $data, true);
							$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
							$email = $sid;
							$name_of_customer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
							$MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
							$MailSubject2 = ' Receipt to ' . $name_of_customer;
							if (!empty($email)) {
								$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
								$this->email->to($email);
								$this->email->subject($MailSubject);
								$this->email->message($msg);
								$this->email->send();
							}

                            $merchant_email = $getEmail1[0]['email'];
							
							if (!empty($merchant_email)) {
								$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
								//$this->email->to($merchant_email);
								$this->email->to('sq.dev007@gmail.com');
								$this->email->subject($MailSubject2);
								$this->email->message($merchnat_msg);
								$this->email->send();
							}



						// End new code

					
						
						$message = 1;
					} catch (Exception $e) {
					
						$response = ['status' => '401', 'errorMsg' => 'Invalid Email'];
					}
				} else if ($type == 'sms') {
					try {
						//$stmt = $this->db->query("UPDATE  pos set name='".$nameR."', mobile_no ='".$sid."',receipt_type=IFNULL (CONCAT( receipt_type ,',', 'sms'), 'sms') where id ='".$payment_id."' ");
						
						$mob = str_replace(array('(', ')', '-', ' '), '', $sid);
						$mobile = '+1' . $mob;
						
					 // $sms_message = trim(" '" . $business_dba_name . "' POS Invoice No '" . $invoice_no . "' Your Amount '" . $amount . "' "); 
					
					  //$sms_message = trim(" 'Dear " .$cc_name. ", ".$business_dba_name ."' POS Invoice No'" . $invoice_no . "' Your Amount '" .$amount."'  "); 
					//  $sms_message_1 = trim(" Payment date '" . $p_date . "' Transaction id '" . $transaction_id . "' Card type '" . $card_type . "' "); 
				
					//$sms_message = trim(" 'Dear'");
						$sms_message_2 = trim(" Payment  Receipt: $url");
                         $from = '+18325324983'; //trial account twilio number
		                 $to = '+1' . $mob;
		               //  $response = $this->twilio->sms($from, $to, $sms_message);
		                // $response_1 = $this->twilio->sms($from, $to, $sms_message_1);
		                 $response_2 = $this->twilio->sms($from, $to, $sms_message_2);
		                 
		                 //print_r($response_2->HttpStatus);
		                 //print_r($response_1->HttpStatus);
		                 //print_r($response_2->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );

		                $status = parent::HTTP_OK;


		                 if($response_2->HttpStatus==400 || $response_2->HttpStatus==429 || $response_2->HttpStatus==503){
		                  $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }else if($response_1->HttpStatus==400 || $response_1->HttpStatus==429 || $response_1->HttpStatus==503){
		                 $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }else if($response->HttpStatus==400 || $response->HttpStatus==429 || $response->HttpStatus==503){
		                  $response = ['status' => $status,'successMsg' => 'Successfull'];
		                // $response = ['status' => '400', 'errorMsg' => $response_1->ErrorMessage];
		                 }
		                 else
		                 {
		                
                        $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }
						
					} catch (Exception $e) {
						// $response['error'] = true;
						// $response['errorMsg'] = 'Invalid Number';
						$status = parent::HTTP_OK;
                        $response = ['status' => $status, 'successMsg' => 'Successfull'];
					}
				} else {
					//$stmt = $this->db->query("UPDATE  pos set name='".$nameR."', receipt_type = 'no-cepeipt' where id ='".$payment_id."' ");
				
					$message = 1;
				}
				if ($message) {
					
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Successfull'];
				}
				
			}
	
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
}


}