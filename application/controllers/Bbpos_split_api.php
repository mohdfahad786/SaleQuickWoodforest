
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

class Bbpos_split_api extends REST_Controller {

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
       // ini_set('display_errors', 1);
		//error_reporting(E_ALL);

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
public function split_payment_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = trim($this->input->post('merchantId'));
    if($merchant_id = $data->merchant_id)
    {
            $app_type = $_POST['appType'];
			$merchant_id = trim($_POST['merchantId']);
			$otherCharges = $_POST['otherCharges'] ? $_POST['otherCharges'] : "0";
			$sub_merchant_id = $_POST['subMerchantId'] ? $_POST['subMerchantId'] : "0";
				$otherChargesName = $_POST['otherChargesName'] ? $_POST['otherChargesName'] : "N/A";

				 $applicationId = $_POST['applicationId'] ? $_POST['applicationId'] : "N/A";
      $cryptogram = $_POST['cryptogram'] ? $_POST['cryptogram'] : "N/A";
      $applicationLabel = $_POST['applicationLabel'] ? $_POST['applicationLabel'] : "N/A";
      $applicationPreferredName = $_POST['applicationPreferredName'] ? $_POST['applicationPreferredName'] : "N/A";

       $hostResponseCode = $_POST['hostResponseCode'] ? $_POST['hostResponseCode'] : "N/A";
      $expressResponseCode = $_POST['expressResponseCode'] ? $_POST['expressResponseCode'] : "N/A";
      $expressResponseMessage = $_POST['expressResponseMessage'] ? $_POST['expressResponseMessage'] : "N/A";
     

			$name = $_POST['cardHolderName'] ? $_POST['cardHolderName'] : "";
			$amount = $_POST['approvedAmount'] ? $_POST['approvedAmount'] : "";
			$full_amount = $_POST['full_amount'] ? $_POST['full_amount'] : "";
			$card_no = $_POST['cardMaskedNumber'] ? $_POST['cardMaskedNumber'] : "";
			$transaction_guid = '';
			$pos_entry_mode = $_POST['entryMode'] ? $_POST['entryMode'] : "";
			$transaction_id = $_POST['transactionId'] ? $_POST['transactionId'] : "";
			$client_transaction_id = '';
			$card_type = $_POST['cardLogo'] ? $_POST['cardLogo'] : "";
			$invoice_no = trim($_POST['split_invoice_no']) ? trim($_POST['split_invoice_no']) : "";
			$split_payment_id = trim($_POST['split_payment_id']) ? trim($_POST['split_payment_id']) : "";
			$reference = $_POST['referenceNumber'] ? $_POST['referenceNumber'] : "";
			$tax = $_POST['tax_amount'] ? $_POST['tax_amount'] : "";
			$transaction_status = trim($_POST['transactionStatus']);
			
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
			 $amount11 = str_replace('"','',$full_amount);
			
			//$amount11 =  $full_amount;


			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$fee_swap = $merchantdetails['0']['text_email'];
			$fee_invoice = $merchantdetails['0']['point_sale']; 
			$fee_email = $merchantdetails['0']['f_swap_Text'];


			$feee = ($amount11 / 100) * $fee_invoice;
			$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
			$fee_email = ($fee_email != '') ? $fee_email : 0;
			$fee = $feee + $fee_swap + $fee_email;
			$tip_amount = isset($_POST['tipAmount']) ? $_POST['tipAmount'] : 0;
			$discount = isset($_POST['discount']) ? $_POST['discount'] : "$" . "0.00";
			$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : $full_amount;

			/*Extra Param Added 31-10-2019*/
			$version = (isset($_POST["version"])) ? $_POST["version"] : "N/A";
			$serialNumber = (isset($_POST["terminalSerialNumber"])) ? $_POST["terminalSerialNumber"] : "N/A";
			$terminalID = (isset($_POST["terminalModel"])) ? $_POST["terminalModel"] : "N/A";
			$storeID = (isset($_POST["storeID"])) ? $_POST["storeID"] : "N/A";
			$chainID = (isset($_POST["chainID"])) ? $_POST["chainID"] : "N/A";
			$paymentServiceTimezone = (isset($_POST["paymentServiceTimezone"])) ? $_POST["paymentServiceTimezone"] : "N/A";
			$paymentServiceTimestamp = (isset($_POST["paymentServiceTimestamp"])) ? $_POST["paymentServiceTimestamp"] : "N/A";
			$deviceTimezone = (isset($_POST["deviceTimezone"])) ? $_POST["deviceTimezone"] : "N/A";
			$deviceTimestamp = (isset($_POST["deviceTimestamp"])) ? $_POST["deviceTimestamp"] : "N/A";
			$processorTimezone = (isset($_POST["processorTimezone"])) ? $_POST["processorTimezone"] : "N/A";
			$processorTimestamp = (isset($_POST["processorTimestamp"])) ? $_POST["processorTimestamp"] : "N/A";
            $description = $_POST['description'];
			$wasProcessedOnline = $_POST['wasProcessedOnline'];
			$transactionDateTime = $_POST['transactionDateTime'];
			$cashbackAmount     = $_POST['cashbackAmount'];
			$balanceAmount  = $_POST['balanceAmount'];
			$sentamount = $_POST['sentAmount'];
			$approvalNumber = $_POST['approvalNumber'];


			if ($split_payment_id == false || $split_payment_id == 'false') {
				
				$response['error'] = true;
				$response['errorMsg'] = 'No SPLIT PAYMENT ID';
			} else {


            

				$stmt = $this->db->query("update pos set otherChargesName='".trim($otherChargesName)."',other_charges='".trim($otherCharges)."',name='".$name."',card_no='".$card_no."',transaction_guid='".$transaction_guid."', pos_entry_mode='".$pos_entry_mode."',transaction_id='".$transaction_id."', client_transaction_id='".$client_transaction_id."', card_type='".$card_type."',  date_c='".$today2."', year='".$year."', month='".$month."', time1='".$time1."', day1='".$day1."',reference='".$reference."',
	            `processorTimestamp`='".$processorTimestamp."', `processorTimezone`='".$processorTimezone."',`deviceTimestamp`='".$deviceTimestamp."', `deviceTimezone`='".$deviceTimezone."', `paymentServiceTimestamp`='".$paymentServiceTimestamp."', `paymentServiceTimezone`='".$paymentServiceTimezone."', `chainID`='".$chainID."', `storeID`='".$storeID."', `terminalID`='".$terminalID."', `version`='".$version."',
	            `serialNumber`='".$serialNumber."',status='".$status."',app_type='".$app_type."',c_type='BBPOS',transaction_type='split',detail='".$description."',wasProcessedOnline='".$wasProcessedOnline."',transactionDateTime='".$transactionDateTime."',cashbackAmount='".$cashbackAmount."',balanceAmount='".$balanceAmount."',sentamount='".$sentamount."',approval_number='".$approvalNumber."',applicationId='".$applicationId."',cryptogram='".$cryptogram."',applicationLabel='".$applicationLabel."',applicationPreferredName='".$applicationPreferredName."',hostResponseCode='".$hostResponseCode."',expressResponseCode='".$expressResponseCode."',expressResponseMessage='".$expressResponseMessage."' where invoice_no='".$invoice_no."'
and merchant_id ='".$merchant_id."' and split_payment_id='".$split_payment_id."' ");
			
			//print_r($this->db->last_query());	
			}
			//print_r($stmt);die;
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

}