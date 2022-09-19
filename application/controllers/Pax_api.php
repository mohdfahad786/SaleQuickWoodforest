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
 class Pax_api extends REST_Controller {
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


public function add_pos_card_pax_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
            $sub_merchant_id = $_POST['sub_merchant_id'];
            $otherCharges = $_POST['otherCharges'];
            $otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
            $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
            $amount = $_POST['amount'];
            $card_no = $_POST['card_no'];
            $transaction_guid = $_POST['transaction_guid'];
            $pos_entry_mode = $_POST['pos_entry_mode'];
            $transaction_id = $_POST['transaction_id'];
            $auth_code = $_POST['auth_code'] ? $_POST['auth_code'] : "";
            $client_transaction_id = $_POST['client_transaction_id'];
            $card_type = $_POST['card_type'];
            $invoice_no = $_POST['invoice_no'];
            $reference = $_POST['reference'];
            $tax = $_POST['tax'];
            
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
         
            
                        $data = array(
                         'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'employee_pin' =>$employee_pin,
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
                        'auth_code' =>$auth_code,
                        'c_type' =>'PAX',
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
                        'is_for_vts'=>$is_for_vts                      
                        );
                        $id = $this->admin_model->insert_data("pos", $data);

                        $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$id,
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
                        'serialNumber'=>$serialNumber 
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
                             
                             $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id,'invoice_no' => $invoice_no];
                        
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