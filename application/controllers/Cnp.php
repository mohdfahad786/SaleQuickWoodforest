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

//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 class Cnp extends REST_Controller {
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


public function dateTimeConvertTimeZone($Adate,$merchant_id) {
            if($Adate) {

                $stmt = $this->db->query("SELECT time_zone FROM merchant WHERE  id ='".$merchant_id."'  ");
    $package_data = $stmt->result_array();
    $time_zone_orignal = $package_data['0']['time_zone'];

                $time_Zone= $time_zone_orignal ?  $time_zone_orignal :'America/Chicago';
            
                    $datetime = new DateTime($Adate);
                    $la_time = new DateTimeZone($time_Zone);
                    $datetime->setTimezone($la_time);
                    $convertedDateTime=$datetime->format('Y-m-d H:i:s');
               
                
                
            } else {
                $convertedDateTime=$Adate;
            }
            return $convertedDateTime; 
        }




      public function payment_post() {

		$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

		$getQuery_a = $this->db->query("SELECT * from merchant where merchant_key ='" . $_POST['x_merchant_key'] . "' and auth_key ='" . $_POST['x_auth_key'] . "'  ");
		$getEmail_a = $getQuery_a->result_array();
		$data['$getEmail_a'] = $getEmail_a;
        $merchant_id = $getEmail_a[0]['id'];
        $processor_id=trim($getEmail_a[0]['processor_id']);    
		//print_r($getEmail_a);
		$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
		//print_r($getEmail_a);die();

			if (!empty($security_key) and !empty($processor_id) ) {

			$account_id = $getEmail_a[0]['account_id_cnp'];
			$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			$account_token = $getEmail_a[0]['account_token_cnp'];
			$application_id = $getEmail_a[0]['application_id_cnp'];
			$terminal_id = $getEmail_a[0]['terminal_id'];

			$mobile_no = $this->input->post('x_phone') ? trim($this->input->post('x_phone')) : "";
			$email_id = $this->input->post('x_email') ? trim($this->input->post('x_email')) : "";

			$amount = $this->input->post('x_amount') ? $this->input->post('x_amount') : "";
			$card_no = $this->input->post('x_card_num') ? $this->input->post('x_card_num') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
                        //echo $card_no;die();
			$cvv = $this->input->post('x_cvv') ? $this->input->post('x_cvv') : "";
			$name = $this->input->post('x_name') ? $this->input->post('x_name') : "";
			$address = $this->input->post('x_address') ? $this->input->post('x_address') : "";
            $card_type = $this->input->post('card_type') ? $this->input->post('card_type') : ""; 


           $expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
			$expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";

			$payment_id_1 = "POS_" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);

			$sub_merchant_id = $this->input->post('sub_merchant_id') ? trim($this->input->post('sub_merchant_id')) : "0";

	$ccnumber=$card_no;
	$amount=$amount;
	$ccexp=$expiry_month.$expiry_year;
	$cvv=$cvv;
	$authorizationcode="";
	$ipaddress="";
	$orderid="";

    $query  = "";
    // Login Information
    $query .= "security_key=" . urlencode($security_key) . "&";
    // Sales Information
    $query .= "ccnumber=" . urlencode($ccnumber) . "&";
    $query .= "ccexp=" . urlencode($ccexp) . "&";
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    $query .= "cvv=" . urlencode($cvv) . "&";
    $query .= "processor_id=" . urlencode($processor_id) . "&";
    $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
    $query .= "ipaddress=" . urlencode($ipaddress) . "&";
    $query .= "orderid=" . urlencode($orderid) . "&";
     $query .= "type=sale";


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_POST, 1);

    if (!($data = curl_exec($ch))) {
        return ERROR;
    }
    curl_close($ch);
    unset($ch);
  
	parse_str($data, $parsed);
	$test = json_encode($parsed);
	$response = json_decode($test, true);
			//$array['Response']['ExpressResponseMessage']='onlie';
	$online = 'ONLINE';

			if ($online = 'ONLINE') {

				

				$card_a_no = $response['cc_number'];
					$trans_a_no = $response['transactionid'];
					//$card_type = $response['CardLogo'];

					$card_type =$card_type;

					$message_a = $response['responsetext'];

					if($response['responsetext']='SUCCESS')
					{
						$message_a = 'Approved';
					}
					else 
					{
						$message_a = $response['responsetext'];
					}
					
					if($response['response']=1)
					{
						$message_complete = 'Approved';
					}
					else if($response['response']=2)
					{
						$message_complete = 'Declined';
					}
					else if($response['response']=3)
					{
						$message_complete = 'Error in transaction data or system error';
					}
					else 
					{
						$message_complete = 'Error';
					}
					


							$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
						$s_fee = $merchantdetails['0']['s_fee'];
						$t_fee = $this->session->userdata('t_fee');

						$fee_invoice = $merchantdetails['0']['point_sale'];
						// $fee_swap =$merchantdetails['0']['f_swap_Recurring'];
						$fee_swap = $merchantdetails['0']['text_email'];
						$fee_email = $merchantdetails['0']['f_swap_Text'];

						$fee1 = ($amount / 100) * $fee_invoice;
						$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
						$fee_email = ($fee_email != '') ? $fee_email : 0;
						$fee = $fee1 + $fee_swap + $fee_email;
						$today1 = date("Ymdhms");
						//$payment_id = "POS_".date("Ymdhms");
						$today2 = date("Y-m-d");
						$year = date("Y");
						$month = date("m");
						$time11 = date("H");

						if ($time11 == '00') {
							$time1 = '01';
						} else {
							$time1 = date("H");
						}

						if ($message_complete == 'Declined') {
							$staus = 'declined';
						}
						//elseif($message_a=='Approved' or $message_a=='Duplicate')
						elseif ($message_complete == 'Approved') {
							$staus = 'confirm';
						} else {
							$staus = 'pending';
						}

						$day1 = date("N");

						$data = Array(
							'amount' => $amount,
							'tax' => $tax,
				             'other_charges' => $other_charges,
					         'otherChargesName' => $other_charges_title,
							'tax_id' => $tax_id,
							'tax_per' => $tax_per,
							'fee' => $fee,
							'merchant_id' => $merchant_id,
							'sub_merchant_id' => $sub_merchant_id,
							'invoice_no' => $payment_id,
							'cvv' => $cvv,
							'name' => $name,
							'mobile_no' => $mobile_no,
							'discount' => '0',
							'total_amount' => '0.00',
							'email_id' => $email_id,
							'card_no' => $card_a_no,
							'address' => $address,
							'expiry_month' => $expiry_month,
							'expiry_year' => $expiry_year,
							'year' => $year,
							'month' => $month,
							'time1' => $time1,
							'day1' => $day1,
							'date_c' => $today2,
							'status' => $staus,
							'transaction_id' => $trans_a_no,
							'c_type' => 'CNP',
							'payment_type' => 'web',
							 'processor_name'=>'PAYROC',
							'card_type' => $card_type,
							'transaction_status' => $message_a,
							'express_responsemessage'=>$message_complete,
							'express_transactiondate' => $arrayy['Response']['ExpressTransactionDate'],
							'express_transactiontime' => $arrayy['Response']['ExpressTransactionTime'],
							'acquirer_data' => $arrayy['Response']['Transaction']['AcquirerData'],
							'woocommerce' =>'no'

						);

						// print_r($data);  die();

						$id = $this->admin_model->insert_data("pos", $data);

						if ($message_complete == 'Declined') {
							
							 $responsee = $message_complete;
							 $status = '400';
							 $response = ['status' => '400', 'errorMsg' => $responsee];
						}
						//elseif($message_a=='Approved' or $message_a=='Duplicate')
						elseif ($message_complete == 'Approved') {
							 $responsee = $message_complete;

							   $user = array(
                      'TxnID'=>$trans_a_no ? $trans_a_no : "",
                      'Card No'=>$card_a_no ? $card_a_no : "",
                      'DateTime'=>$today2 ? $today2 : "",
                      'Amount'=>$amount ? $amount : ""
                    );
$status = '200';
				$response = ['status' => '200', 'successMsg' => $responsee,'UserData' => $user];
						} else {
							$status = '401';
							 $responsee = $arrayy['Response']['ExpressResponseMessage'];
						$response = ['status' => '401', 'errorMsg' => $responsee];
						}
			}

  
	 //$response =$array['Response']['ExpressResponseMessage'];
	  $this->response($response, $status);

	  		} else {
	  			$status = '401';
	  			 // $response = 'CNP-Credential-Not-available';
	  			  $response = ['status' => '401', 'errorMsg' => 'CNP-Credential-Not-available!'];
			
			$this->response($response, $status);
		}
	//return $response;
}




public function paymentList_post() {
    $data = array();
    $partial = array();
    $auth_key=$_POST['auth_key'];
	// $status=$_POST['status'];
	$merchant_key=$_POST['merchant_key'];
	  
	 $stmt1 = $this->db->query("SELECT id,status FROM merchant WHERE auth_key='".$auth_key."' and merchant_key='".$merchant_key."' ");
     $getDetail_merchant = $stmt1->result_array();     
     $merchant_id = $getDetail_merchant[0]['id'];
     //print_r($merchant_id);die();
    if(!empty($merchant_id))
    {

		$userdata= array();
		$start1 = $_POST['start_date'];
		$end1 = $_POST['end_date'];

		if ($_POST['start_date'] != '') {

		$start = $start1;

		} else {
		$start = date("Y-m-d", strtotime("-364 days"));
		}

		if ($_POST['end_date'] != '') {

		$end = $end1;

		} else {
		$end = date("Y-m-d");
		}
            
         
                $stmt = $this->db->query("SELECT id,name,email_id,sum(p_ref_amount) as p_ref_amount,sum(amount) as amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM pos WHERE   merchant_id ='".$merchant_id."' and processor_name='PAYROC' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' group by invoice_no order by id desc ");

            $package_data = $stmt->result_array();
           // print_r($package_data);die();
        $mem = array();
        $member = array();
    
                    foreach ($package_data as $each) {
                    $remain_amount_1=   $each['amount'] - $each['p_ref_amount'];
                    $remain_amount = number_format($remain_amount_1,2);
                    $memm = array();
                    $stmt_p = $this->db->query("SELECT id,amount,date_c,transaction_id FROM refund WHERE   merchant_id ='".$merchant_id."' and invoice_no='".$each['invoice_no']."' ");
            $package_data_partial = $stmt_p->result_array();
            if (count($package_data_partial)>0) {
            foreach ($package_data_partial as $each_partial) {

                $partial = array(
                            'id' => $each_partial['id'] ? $each_partial['id'] : "",
                            'amount' => $each_partial['amount'] ? $each_partial['amount'] : "",
                            'transaction_id' => $each_partial['transaction_id'] ? $each_partial['transaction_id'] : "",
                            'date_c' => $each_partial['date_c'] ? $each_partial['date_c'] : "",

                        );
                $memm[] = $partial;
            }
        }
            $partialdata = $memm;
                
                    if ($each['mobile_no'] != '') {
                        
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['mobile_no'] ? $each['mobile_no'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) ? $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            'partial_refund' =>$partialdata,
                           'card_type' =>$each['card_type'] ? $each['card_type'] : "NA"
                            
                        

                        );
                       
                    } else {
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['email_id'] ? $each['email_id'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) ? $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            'partial_refund' =>$partialdata,
                            'card_type' =>$each['card_type'] ? $each['card_type'] : "NA"

                        );

                       
                    }
                    $mem[] = $package;
                }
    
        $userdata = $mem;
    
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}





}

   



