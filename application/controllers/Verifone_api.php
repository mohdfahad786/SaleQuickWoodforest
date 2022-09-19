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
 class Verifone_api extends REST_Controller {
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


public function add_pos_card_verifone_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
            $sub_merchant_id = $_POST['sub_merchant_id'];
            $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
            $otherCharges = $_POST['otherCharges'];
            $otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";
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
                        'c_type' =>'VRF',
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
                        $pax_id = $this->admin_model->insert_data("verifone_json", $data_pax);
                        
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


    public function split_payment_post()
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
            $auth_code = $_POST['auth_code'] ? $_POST['auth_code'] : "";
            $client_transaction_id = $_POST['client_transaction_id'] ? $_POST['client_transaction_id'] : "";
            $card_type = $_POST['card_type'] ? $_POST['card_type'] : "";
            $invoice_no = $_POST['split_invoice_no'] ? $_POST['split_invoice_no'] : "";
            $split_payment_id = $_POST['split_payment_id'] ? $_POST['split_payment_id'] : "";
            $reference = $_POST['reference'] ? $_POST['reference'] : "";
            $tax = $_POST['tax_amount'] ? $_POST['tax_amount'] : "";
            $transaction_status = $_POST['transaction_status'];
            $is_for_vts= isset($_POST['is_for_vts'])?$_POST['is_for_vts']:"false";
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
             $pax_json=(isset($_POST["pax_json"]))?$_POST["pax_json"]:"";
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

            if ($split_payment_id == false || $split_payment_id == 'false') {
                
                $response['error'] = true;
                $response['errorMsg'] = 'No SPLIT PAYMENT ID';
            } else {


            

                $stmt = $this->db->query("update pos set otherChargesName='".$otherChargesName."',employee_pin='".$employee_pin."',other_charges='".$otherCharges."',name='".$name."',card_no='".$card_no."',transaction_guid='".$transaction_guid."', pos_entry_mode='".$pos_entry_mode."',transaction_id='".$transaction_id."',auth_code='".$auth_code."',client_transaction_id='".$client_transaction_id."', card_type='".$card_type."',  date_c='".$today2."', year='".$year."', month='".$month."', time1='".$time1."', day1='".$day1."',reference='".$reference."',is_for_vts='".$is_for_vts."',status='".$status."',app_type='".$app_type."',c_type='PAX',transaction_type='split' where invoice_no='".$invoice_no."' and merchant_id ='".$merchant_id."' and split_payment_id='".$split_payment_id."'");


                $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>1,
                        'invoice_no' =>$invoice_no,
                        'split_payment_id' =>$split_payment_id,
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
                        $pax_id = $this->admin_model->insert_data("verifone_json", $data_pax);
            
                
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


    public function pax_payment_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
           
            
    if($merchant_id == $data->merchant_id)
    {       
            $p_id = $this->input->post('id');
      $sub_merchant_id = $_POST['sub_merchant_id'];
      $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
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
                        $pax_id = $this->admin_model->insert_data("verifone_json", $data_pax);
                        
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

    public function pax_refund_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       
            $invoice_no = isset($_POST['split_invoice_no']) ? $_POST['split_invoice_no'] : $_POST['invoice_no'];
            $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
            $amount = $_POST['amount'];
            $card_no = $_POST['card_no'];
            $transaction_guid = $_POST['transaction_guid'];
            $pos_entry_mode = $_POST['pos_entry_mode'];
            $transaction_id = $_POST['transaction_id'];
            $client_transaction_id = $_POST['client_transaction_id'];
            $card_type = $_POST['card_type'];
            $split_payment_id = isset($_POST['split_payment_id']) ? $_POST['split_payment_id'] : '';
            $c_type = 'CP';

            $today2 = date("Y-m-d");
            $today3 = date("Y-m-d H:i:s");
            $data = array(
                             'merchant_id' =>$merchant_id,
                              'employee_pin' =>$employee_pin,
                             'invoice_no' =>$invoice_no, 
                             'payment_id' =>$split_payment_id,
                             'amount' =>$amount,
                             'transaction_guid' =>$transaction_guid,
                             'pos_entry_mode' =>$pos_entry_mode,
                             'transaction_id' =>$transaction_id, 
                             'client_transaction_id' =>$client_transaction_id,
                             'card_type' =>$card_type,
                             'status' =>'confirm',
                             'type' =>'straight', 
                             'date_c' =>$today2,
                             'c_type' =>$c_type,
                            
                         );
            $stmt = $this->admin_model->insert_data("refund", $data);

            if (isset($_POST['split_payment_id']) && !empty($_POST['split_payment_id'])) {

                $getQuery = $this->db->query("SELECT p_ref_amount,amount,partial_refund from customer_payment_request where invoice_no='".$invoice_no."' and split_payment_id='".$split_payment_id."' ");
                 $getEmail = $getQuery->result_array();
                 $data['getEmail'] = $getEmail;
                $paid_amount = $amount;
                $p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
                $amount = $getEmail[0]['amount'];
    if($getEmail[0]['amount'] > $p_ref_amount )
    {
    $p_ref_amount = $p_ref_amount;
    $partial_refund = 1;
    $refund_amount = $p_ref_amount;
    
    $remain_amount = number_format(($getEmail[0]['amount']-$p_ref_amount),2);
    }
    elseif($getEmail[0]['amount'] == $p_ref_amount)
    {
       $p_ref_amount = 0;
       $partial_refund = 0;
       $refund_amount = number_format($getEmail[0]['amount'],2);
       $remain_amount = 0 ;
    }

                $stmt1 = $this->db->query("UPDATE  customer_payment_request set status ='Chargeback_Confirm',date_r ='".$today2."',p_ref_amount ='".$p_ref_amount."',partial_refund = '".$partial_refund."' where invoice_no ='".$invoice_no."' and split_payment_id='".$split_payment_id."' ");

            } else {

                $getQuery = $this->db->query("SELECT p_ref_amount,amount,partial_refund from customer_payment_request where invoice_no='".$invoice_no."'  ");
                 $getEmail = $getQuery->result_array();
                 $data['getEmail'] = $getEmail;
                $paid_amount = $amount;
                $p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
                $amount = $getEmail[0]['amount'];
    if($getEmail[0]['amount'] > $p_ref_amount )
    {
    $p_ref_amount = $p_ref_amount;
    $partial_refund = 1;
    $refund_amount = $p_ref_amount;
    $remain_amount = number_format(($getEmail[0]['amount']-$p_ref_amount),2);

    }
    elseif($getEmail[0]['amount'] == $p_ref_amount)
    {
       $p_ref_amount = 0;
       $partial_refund = 0;
       $refund_amount = number_format($getEmail[0]['amount'],2);
       $remain_amount = 0 ;

     
    }

                  $stmt1 = $this->db->query("UPDATE  customer_payment_request set status ='Chargeback_Confirm',date_r ='".$today2."',p_ref_amount ='".$p_ref_amount."',partial_refund = '".$partial_refund."' where invoice_no ='".$invoice_no."'  ");

                  if(is_null($refund_amount)){
                $refund_amount=0;
                }
                if(is_null($remain_amount)){
                $remain_amount=0;
                }

            }

            if ($stmt1) {

                if (!empty(stmt)) {

                    $status = parent::HTTP_OK;
                    $response = ['status' => $status,'refund_amount' => $refund_amount,'remain_amount' => $remain_amount, 'successMsg' => 'Successfull'];
                } else {
                    
                    $response = ['status' => '401', 'errorMsg' => 'Fail!'];
                }
            } else {
                
                $response = ['status' => '401', 'errorMsg' => 'Fail to update!'];
            }   
     
    
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function create_refund_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       
            $invoice_no = isset($_POST['split_invoice_no']) ? $_POST['split_invoice_no'] : $_POST['invoice_no'];
            $employee_pin = $_POST['employee_pin'] ? $_POST['employee_pin'] : "";
            $amount = $_POST['amount'];
            $card_no = $_POST['card_no'];
            $transaction_guid = $_POST['transaction_guid'];
            $pos_entry_mode = $_POST['pos_entry_mode'];
            $transaction_id = $_POST['transaction_id'];
            $client_transaction_id = $_POST['client_transaction_id'];
            $card_type = $_POST['card_type'];
            $split_payment_id = isset($_POST['split_payment_id']) ? $_POST['split_payment_id'] : '';
            $c_type = 'CP';
            $pax_refund_status = $_POST['pax_refund_status'];
            $auth_code1 = $_POST['authcode'] ? $_POST['authcode'] : "";
            $auth_code2 = $_POST['authCode'] ? $_POST['authCode'] : "";
            $auth_code3 = $_POST['auth_code_refund'] ? $_POST['auth_code_refund'] : "";
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
            

            $today2 = date("Y-m-d");
            $today3 = date("Y-m-d H:i:s");
            $data = array(
                             'merchant_id' =>$merchant_id,
                              'employee_pin' =>$employee_pin,
                             'invoice_no' =>$invoice_no, 
                             'payment_id' =>$split_payment_id,
                             'amount' =>$amount,
                             'transaction_guid' =>$transaction_guid,
                             'pos_entry_mode' =>$pos_entry_mode,
                             'transaction_id' =>$transaction_id, 
                             'client_transaction_id' =>$client_transaction_id,
                             'card_type' =>$card_type,
                             'status' =>'confirm',
                             'type' =>'pos', 
                             'date_c' =>$today2,
                             'c_type' =>$c_type,
                             'auth_code' =>$auth_code,
                            
                         );
            $stmt = $this->admin_model->insert_data("refund", $data);

            if (isset($_POST['split_payment_id']) && !empty($_POST['split_payment_id'])) {

                $getQuery = $this->db->query("SELECT p_ref_amount,amount,partial_refund from pos where invoice_no='".$invoice_no."' and split_payment_id='".$split_payment_id."' ");
                 $getEmail = $getQuery->result_array();
                 $data['getEmail'] = $getEmail;
                $paid_amount = $amount;
                $p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
                $amount = $getEmail[0]['amount'];
    if($getEmail[0]['amount'] > $p_ref_amount )
    {
    $p_ref_amount = $p_ref_amount;
    $partial_refund = 1;
    $refund_amount = $p_ref_amount;
    
    $remain_amount = number_format(($getEmail[0]['amount']-$p_ref_amount),2);
    }
    elseif($getEmail[0]['amount'] == $p_ref_amount)
    {
       $p_ref_amount = 0;
       $partial_refund = 0;
       $refund_amount = number_format($getEmail[0]['amount'],2);
       $remain_amount = 0 ;
    }

                $stmt1 = $this->db->query("UPDATE  pos set status ='Chargeback_Confirm',date_r ='".$today2."',p_ref_amount ='".$p_ref_amount."',partial_refund = '".$partial_refund."', pax_refund_status ='".$pax_refund_status."' where invoice_no ='".$invoice_no."' and split_payment_id='".$split_payment_id."' ");

            } else {

                $getQuery = $this->db->query("SELECT p_ref_amount,amount,partial_refund from pos where invoice_no='".$invoice_no."'  ");
                 $getEmail = $getQuery->result_array();
                 $data['getEmail'] = $getEmail;
                $paid_amount = $amount;
                $p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
                $amount = $getEmail[0]['amount'];
    if($getEmail[0]['amount'] > $p_ref_amount )
    {
    $p_ref_amount = $p_ref_amount;
    $partial_refund = 1;
    $refund_amount = $p_ref_amount;
    $remain_amount = number_format(($getEmail[0]['amount']-$p_ref_amount),2);

    }
    elseif($getEmail[0]['amount'] == $p_ref_amount)
    {
       $p_ref_amount = 0;
       $partial_refund = 0;
       $refund_amount = number_format($getEmail[0]['amount'],2);
       $remain_amount = 0 ;

     
    }

                  $stmt1 = $this->db->query("UPDATE  pos set status ='Chargeback_Confirm',date_r ='".$today2."',p_ref_amount ='".$p_ref_amount."',partial_refund = '".$partial_refund."', pax_refund_status ='".$pax_refund_status."' where invoice_no ='".$invoice_no."'  ");

            }

            if ($stmt1) {

                if (!empty(stmt)) {

                    $status = parent::HTTP_OK;
                    $response = ['status' => $status,'refund_amount' => $refund_amount,'remain_amount' => $remain_amount, 'successMsg' => 'Successfull'];
                } else {
                    
                    $response = ['status' => '401', 'errorMsg' => 'Fail!'];
                }
            } else {
                
                $response = ['status' => '401', 'errorMsg' => 'Fail to update!'];
            }   
     
    
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}                


}