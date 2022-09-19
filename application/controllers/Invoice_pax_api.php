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
 class Invoice_pax_api extends REST_Controller {
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

  	public function pax_payment_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
           
            
    if($merchant_id == $data->merchant_id)
    {       
    	    $p_id = $this->input->post('id');
            $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
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
            $tax = $_POST['tax_amount'];
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
            
            
        
            $tip_amount = isset($_POST['tip_amount'])?$_POST['tip_amount']:0;
            $discount= isset($_POST['discount'])?$_POST['discount']:"$"."0.00";
            $total_amount= isset($_POST['total_amount'])?$_POST['total_amount']:$amount;
        
            $pax_json=(isset($_POST["pax_json"]))?$_POST["pax_json"]:"";
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
            $is_for_vts= isset($_POST['is_for_vts'])?$_POST['is_for_vts']:"false";

 	      $today_p = date("Y-m-d H:i:s");

  						$info = array(
  							        'sub_merchant_id' =>$sub_merchant_id,
                                    'employee_pin' =>$employee_pin,
									'status' => 'confirm',
									//'late_fee' => $late_fee,
									//'amount' => $amount1,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2,
									'payment_date' => $today_p,
									'transaction_id' => $transaction_id,
                                    'auth_code' =>$auth_code,
									'message' => $message_a,
									'card_type' => $card_type,
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
									'c_type' =>'PAX',
									'app_type' =>$app_type,
									'invoice_pos_charge' =>'yes',
									'transaction_guid' => $transaction_guid,
									'pos_entry_mode'=> $pos_entry_mode,
									'client_transaction_id'=>$client_transaction_id,
                                    'is_for_vts'=>$is_for_vts
								);
		

					$id =$this->Home_model->update_payment_single($p_id, $info);

                     $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$p_id,
                        'pax_json'=>$pax_json,
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
                        'type'=>'invoice' 
                        );
                        $pax_id = $this->admin_model->insert_data("pax_json", $data_pax);
						
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
						     $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $p_id,'invoice_no' => $invoice_no];
						
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