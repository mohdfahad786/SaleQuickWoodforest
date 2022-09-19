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

class Bbpos_refund_api extends REST_Controller {

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



public function create_refund_bbpos_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);

    

    $merchant_id = $this->input->post('merchantId');
    if($merchant_id = $data->merchant_id)
    {
       
			$invoice_no = isset($_POST['split_invoice_no']) ? $_POST['split_invoice_no'] : $_POST['invoice_no'];
		
			$amount_p = $_POST['refundAmount'];
			$amount = str_replace("-","",$amount_p);
			$subMerchantId = $_POST['subMerchantId'];
			$card_no = $_POST['cardNumberMasked'];
			$transaction_guid = $_POST['transaction_guid'];
			$pos_entry_mode = $_POST['pos_entry_mode'];
			$transaction_id = $_POST['transactionID'];
			$client_transaction_id = $_POST['client_transaction_id'];
			$card_type = $_POST['cardLogo'];
			$split_payment_id = isset($_POST['split_payment_id']) ? $_POST['split_payment_id'] : '';
			$c_type = 'BBPOS';

			$today2 = date("Y-m-d");
			$today3 = date("Y-m-d H:i:s");
			$data = array(
							 'merchant_id' =>$merchant_id,
							 'sub_merchant_id' =>$subMerchantId,
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
							
						 );
			$stmt = $this->admin_model->insert_data("refund", $data);

			if (isset($_POST['split_payment_id']) && !empty($_POST['split_payment_id'])) {

				$getQuery = $this->db->query("SELECT p_ref_amount,amount,partial_refund from pos where invoice_no='".$invoice_no."' and split_payment_id='".$split_payment_id."' ");
				 $getEmail = $getQuery->result_array();
				 $data['getEmail'] = $getEmail;
				$paid_amount = $amount;
  				$p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
  				//$amount = $getEmail[0]['amount'];
	//if($getEmail[0]['amount'] > $p_ref_amount )
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

				$stmt1 = $this->db->query("UPDATE  pos set status ='Chargeback_Confirm',date_r ='".$today2."',p_ref_amount ='".$p_ref_amount."',partial_refund = '".$partial_refund."' where invoice_no ='".$invoice_no."' and split_payment_id='".$split_payment_id."' ");

			} else {

				$getQuery = $this->db->query("SELECT p_ref_amount,amount,partial_refund from pos where invoice_no='".$invoice_no."'  ");
				 $getEmail = $getQuery->result_array();
				 $data['getEmail'] = $getEmail;
				$paid_amount = $amount;
  				$p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
  				//$amount = $getEmail[0]['amount'];
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

				  $stmt1 = $this->db->query("UPDATE  pos set status ='Chargeback_Confirm',date_r ='".$today2."',p_ref_amount ='".$p_ref_amount."',partial_refund = '".$partial_refund."' where invoice_no ='".$invoice_no."'  ");

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


