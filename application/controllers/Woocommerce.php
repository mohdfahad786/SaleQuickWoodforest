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
 class Woocommerce extends REST_Controller {
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
		 // error_reporting(E_ALL);
        
      }

public function card_payment_post() {
	$status=200;

  // [x_tran_key] => 123456789salequick
	
  //   [x_login] => salequicklogin
  //   [x_version] => 3.1
  //   [x_amount] => 90.00
  //   [x_card_num] => 111
  //   [x_card_code] => 123
  //   [x_exp_date] => 1225
  //   [x_type] => AUTH_CAPTURE
  //   [x_invoice_num] => 20
  //   [x_test_request] => TRUE
  //   [x_delim_char] => |
  //   [x_encap_char] => 
  //   [x_delim_data] => TRUE
  //   [x_relay_response] => FALSE
  //   [x_method] => CC
  //   [x_first_name] => xyz
  //   [x_last_name] => abc
  //   [x_address] => abc
  //   [x_city] => lucknow
  //   [x_state] => UP
  //   [x_zip] => 123
  //   [x_country] => IN
  //   [x_phone] => 123
  //   [x_email] => xyz@gmail.com
  //   [x_ship_to_first_name] => 
  //   [x_ship_to_last_name] => 
  //   [x_ship_to_company] => 
  //   [x_ship_to_address] => 
  //   [x_ship_to_city] => 
  //   [x_ship_to_country] => 
  //   [x_ship_to_state] => 
  //   [x_ship_to_zip] => 
  //   [x_cust_id] => 1
  //   [x_customer_ip] => ::1


	  //Data, connection, auth
		# $dataFromTheForm = $_POST['fieldName']; // request data from the form
		$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

		$getQuery_a = $this->db->query("SELECT * from merchant where merchant_key ='" . $_POST['x_tran_key'] . "' and auth_key ='" . $_POST['x_login'] . "'  ");
		$getEmail_a = $getQuery_a->result_array();
		$data['$getEmail_a'] = $getEmail_a;
        $merchant_id = $getEmail_a[0]['id'];
        $payroc = $getEmail_a[0]['payroc'];    
		//print_r($getEmail_a);
 //Start Wp       
  if($payroc==0){
		if (!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])) {

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
			$cvv = $this->input->post('x_card_code') ? $this->input->post('x_card_code') : "";
			$name = $this->input->post('x_first_name') ? $this->input->post('x_first_name') : "";
			$address = $this->input->post('x_address') ? $this->input->post('x_address') : "";
  

$x_exp_date = $this->input->post('x_exp_date') ? $this->input->post('x_exp_date') : "";

$expiry_month =  substr($x_exp_date,0,-2);
$expiry_year =  substr($x_exp_date,2,2);

			$payment_id_1 = "POS_" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);

			$xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>";

			$headers = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				"SOAPAction: https://transaction.elementexpress.com/",
				"Content-length: " . strlen($xml_post_string),
			); //SOAPAction: your op URL

			$url = $soapUrl;

			// PHP cURL  for https connection with auth
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$response = curl_exec($ch);
			$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json, TRUE);
			//print_r($array);
			curl_close($ch); 
			//$array['Response']['ExpressResponseMessage']='onlie';

			if ($array['Response']['ExpressResponseMessage'] = 'ONLINE') {

				$TicketNumber = (rand(100000, 999999));
				$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken>
                        <AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
                        <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $payment_id . "</ReferenceNumber>
                        <TicketNumber>" . $TicketNumber . "</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
                        <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
                        </Terminal><Card><CardNumber>" . $card_no . "</CardNumber><ExpirationMonth>" . $expiry_month . "</ExpirationMonth><ExpirationYear>" . $expiry_year . "</ExpirationYear></Card><Address><BillingAddress1>" . $address . "</BillingAddress1>
                    </Address></CreditCardSale>"; // data from the form, e.g. some ID number

				$headers = array(
					"Content-type: text/xml;charset=\"utf-8\"",
					"Accept: text/xml",
					"Cache-Control: no-cache",
					"Pragma: no-cache",
					"SOAPAction: https://transaction.elementexpress.com/",
					"Content-length: " . strlen($xml_post_string),
				); //SOAPAction: your op URL

				$url = $soapUrl;

				// PHP cURL  for https connection with auth
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				// converting
				$response = curl_exec($ch);
				$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
				$json = json_encode($xml);
				$arrayy = json_decode($json, TRUE);
				//print_r($arrayy);

				//	die();
				curl_close($ch);

				$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
					$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
					$card_type = $arrayy['Response']['Card']['CardLogo'];
					$message_a = $arrayy['Response']['Transaction']['TransactionStatus'];
					$message_complete = $arrayy['Response']['ExpressResponseMessage'];


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
							'name' => $name,
							'mobile_no' => $mobile_no,
							'discount' => '0',
							'total_amount' => '0.00',
							'email_id' => $email_id,
							'card_no' => $card_a_no,
							'address' => $address,
							'year' => $year,
							'month' => $month,
							'time1' => $time1,
							'day1' => $day1,
							'date_c' => $today2,
							'status' => $staus,
							'transaction_id' => $trans_a_no,
							'c_type' => 'CNP',
							'payment_type' => 'web',
							'card_type' => $card_type,
							'transaction_status' => $message_a,
							'express_responsemessage'=>$message_complete,
							'express_transactiondate' => $arrayy['Response']['ExpressTransactionDate'],
							'express_transactiontime' => $arrayy['Response']['ExpressTransactionTime'],
							'acquirer_data' => $arrayy['Response']['Transaction']['AcquirerData'],
							'woocommerce' =>'yes'

						);

						// print_r($data);  die();

						$id = $this->admin_model->insert_data("pos", $data);

						if ($message_complete == 'Declined') {
							
							 $response = '3|2|13| '.$message_complete.' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						}
						//elseif($message_a=='Approved' or $message_a=='Duplicate')
						elseif ($message_complete == 'Approved') {
							 $response = '1|2|13| '.$message_complete.' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						} else {
							
							 $response = '3|2|13| '.$arrayy['Response']['ExpressResponseMessage'].' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						}
			}

  
	 //$response =$array['Response']['ExpressResponseMessage'];
	  $this->response($response, $status);

	  		} else {
	  			  $response = '3|2|13| CNP-Credential-Not-available.|000000|P|0|||90.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
			
			$this->response($response, $status);
		}
	}

// End Wp
// Start Pyroc
		elseif($payroc==1)
		{
			 $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
            $processor_id=trim($getEmail_a[0]['processor_id']);
		if (!empty($security_key) and !empty($getEmail_a[0]['id']) and !empty($processor_id)){

		

			$mobile_no = $this->input->post('x_phone') ? trim($this->input->post('x_phone')) : "";
			$email_id = $this->input->post('x_email') ? trim($this->input->post('x_email')) : "";

			$amount = $this->input->post('x_amount') ? $this->input->post('x_amount') : "";
			$card_no = $this->input->post('x_card_num') ? $this->input->post('x_card_num') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
                        //echo $card_no;die();
			$cvv = $this->input->post('x_card_code') ? $this->input->post('x_card_code') : "";
			$name = $this->input->post('x_first_name') ? $this->input->post('x_first_name') : "";
			$address = $this->input->post('x_address') ? $this->input->post('x_address') : "";
  

			$x_exp_date = $this->input->post('x_exp_date') ? $this->input->post('x_exp_date') : "";

			$expiry_month =  substr($x_exp_date,0,-2);
			$expiry_year =  substr($x_exp_date,2,2);

			$payment_id_1 = "POS_" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);

			$ccnumber=$card_no;
			$amount=$amount;
			$ccexp=$expiry_month.$expiry_year;
			$cvv=$cvv;
			$authorizationcode="";
			$ipaddress=$_SERVER['REMOTE_ADDR'];
			$orderid=$payment_id;

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
			

			
			//print_r($array);
			curl_close($ch); 
			$array['Response']['ExpressResponseMessage']='ONLINE';


			if ($array['Response']['ExpressResponseMessage'] == 'ONLINE') {

				$TicketNumber = (rand(100000, 999999));
			

					$card_a_no = $response['cc_number'];
					$trans_a_no = $response['transactionid'];
					$auth_code1 = $response['authcode']; 

				      $auth_code2 = $response['authCode'];
				      if($auth_code1!='')
				      {
				            $auth_code = $auth_code1;
				      }
				      else
				      {
				           $auth_code = $auth_code2;
				     }
					// $card_a_type =$card_type;
					if($response['cc_type']=='mc')
					{
					$card_type ='MasterCard';
					}

					else
					{
					$card_type =ucfirst($response['cc_type']);
					}   

					if($response['responsetext']=='Approved')
					{
						$message_a = 'Approved';
						
					}
					else 
					{
						$message_a = $response['responsetext'];
					}
					
					if($response['response']==1)
					{
						$message_complete = 'Approved';
						$arrayy['Response']['ExpressResponseMessage'] = 'Approved';
					}
					else if($response['response']==2)
					{
						$message_complete = 'Declined';
					}
					else if($response['response']==3)
					{
						$message_complete = $response['responsetext'];
					}
					else 
					{
						$message_complete = 'Error';
					}

					if ($message_complete == 'Declined') {
					 $staus = 'declined';
					 }

					elseif ($message_complete == 'Approved') {
					 $staus = 'confirm';
					 } else {
					  $staus = 'pending';
					  }


						$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
						$s_fee = $merchantdetails['0']['s_fee'];

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
							'name' => $name,
							'mobile_no' => $mobile_no,
							'discount' => '0',
							'total_amount' => '0.00',
							'email_id' => $email_id,
							'card_no' => $card_a_no,
							'address' => $address,
							'year' => $year,
							'month' => $month,
							'time1' => $time1,
							'day1' => $day1,
							'date_c' => $today2,
							'auth_code' => $auth_code,
							'status' => $staus,
							'transaction_id' => $trans_a_no,
							'c_type' => 'CNP',
							'payment_type' => 'web',
							'card_type' => $card_type,
							'transaction_status' => $message_a,
							'express_responsemessage'=>$message_complete,
							'pax_json'=>$test,
							'processor_name'=>'PAYROC',
							'woocommerce' =>'yes'

						);

						// print_r($data);  
						//die();

						$id = $this->admin_model->insert_data("pos", $data);
						//echo $this->db->last_query();

						if ($message_complete == 'Declined') {
							
							 $response = '3|2|13| '.$message_complete.' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						}
						//elseif($message_a=='Approved' or $message_a=='Duplicate')
						elseif ($message_complete == 'Approved') {
							 $response = '1|2|13| '.$message_complete.' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						} else {
							
							 $response = '3|2|13| '.$response['responsetext'].' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						}
			}

  
	 //$response =$array['Response']['ExpressResponseMessage'];
	  $this->response($response, $status);

	  		} else {
	  			  $response = '3|2|13| Processor-ID-Not-available.|000000|P|0|||90.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
			
			$this->response($response, $status);
		}

		}
//End Payroc
	//return $response;
}


public function card_payment_test_post() {
	    $status=200;

		$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL

		$getQuery_a = $this->db->query("SELECT * from merchant where merchant_key ='" . $_POST['x_tran_key'] . "' and auth_key ='" . $_POST['x_login'] . "'  ");
		$getEmail_a = $getQuery_a->result_array();
		$data['$getEmail_a'] = $getEmail_a;
        $merchant_id = $getEmail_a[0]['id'];    
		//print_r($getEmail_a);
		if (!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])) {

			// $account_id = $getEmail_a[0]['account_id_cnp'];
			// $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			// $account_token = $getEmail_a[0]['account_token_cnp'];
			// $application_id = $getEmail_a[0]['application_id_cnp'];
			// $terminal_id = $getEmail_a[0]['terminal_id'];

$account_id ='1058981';
$account_token ='6B788148E8E97DF9F05E11514A5CE5CD5AACD695EB88FBFBDE1C30A89F6F0D55D89D5301';
$acceptor_id ='3928907';
$terminal_id = '0060810007';
$application_id = '9726';


			$mobile_no = $this->input->post('x_phone') ? trim($this->input->post('x_phone')) : "";
			$email_id = $this->input->post('x_email') ? trim($this->input->post('x_email')) : "";

			$amount = $this->input->post('x_amount') ? $this->input->post('x_amount') : "";
			$card_no = $this->input->post('x_card_num') ? $this->input->post('x_card_num') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
                        //echo $card_no;die();
			$cvv = $this->input->post('x_card_code') ? $this->input->post('x_card_code') : "";
			$name = $this->input->post('x_first_name') ? $this->input->post('x_first_name') : "";
			$address = $this->input->post('x_address') ? $this->input->post('x_address') : "";

$x_exp_date = $this->input->post('x_exp_date') ? $this->input->post('x_exp_date') : "";

$expiry_month =  substr($x_exp_date,0,-2);
$expiry_year =  substr($x_exp_date,2,2);

			$payment_id_1 = "POS_" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);

			$xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>";

			$headers = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				"SOAPAction: https://transaction.elementexpress.com/",
				"Content-length: " . strlen($xml_post_string),
			); //SOAPAction: your op URL

			$url = $soapUrl;

			// PHP cURL  for https connection with auth
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$response = curl_exec($ch);
			$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json, TRUE);
			//print_r($array);
			curl_close($ch); 
			//$array['Response']['ExpressResponseMessage']='onlie';

			if ($array['Response']['ExpressResponseMessage'] = 'ONLINE') {

				$TicketNumber = (rand(100000, 999999));
				$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken>
                        <AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
                        <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $payment_id . "</ReferenceNumber>
                        <TicketNumber>" . $TicketNumber . "</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
                        <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
                        </Terminal><Card><CardNumber>" . $card_no . "</CardNumber><ExpirationMonth>" . $expiry_month . "</ExpirationMonth><ExpirationYear>" . $expiry_year . "</ExpirationYear></Card><Address><BillingAddress1>" . $address . "</BillingAddress1>
                    </Address></CreditCardSale>"; // data from the form, e.g. some ID number

				$headers = array(
					"Content-type: text/xml;charset=\"utf-8\"",
					"Accept: text/xml",
					"Cache-Control: no-cache",
					"Pragma: no-cache",
					"SOAPAction: https://transaction.elementexpress.com/",
					"Content-length: " . strlen($xml_post_string),
				); //SOAPAction: your op URL

				$url = $soapUrl;

				// PHP cURL  for https connection with auth
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				// converting
				$response = curl_exec($ch);
				$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
				$json = json_encode($xml);
				$arrayy = json_decode($json, TRUE);
				//print_r($arrayy);

				//	die();
				curl_close($ch);

				$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
				$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
				$card_type = $arrayy['Response']['Card']['CardLogo'];
				$message_a = $arrayy['Response']['Transaction']['TransactionStatus'];
				$message_complete = $arrayy['Response']['ExpressResponseMessage'];


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
							'card_no1' => $card_no,
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
							'card_type' => $card_type,
							'transaction_status' => $message_a,
							'express_responsemessage'=>$message_complete,
							'express_transactiondate' => $arrayy['Response']['ExpressTransactionDate'],
							'express_transactiontime' => $arrayy['Response']['ExpressTransactionTime'],
							'acquirer_data' => $arrayy['Response']['Transaction']['AcquirerData'],

						);


					$id = $this->admin_model->insert_data("pos_sandbox", $data);

						if ($message_complete == 'Declined') {
							
							 $response = '3|2|13| '.$message_complete.' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						}
						//elseif($message_a=='Approved' or $message_a=='Duplicate')
						elseif ($message_complete == 'Approved') {
							 $response = '1|2|13| '.$message_complete.' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						} else {
							
							 $response = '3|2|13| '.$arrayy['Response']['ExpressResponseMessage'].' |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
						}
						
			}

	  $this->response($response, $status);

	  		} else {
	  			  $response = '3|2|13| CNP-Credential-Not-available |000000|P|0|||00.00||auth_capture|||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
			
			$this->response($response, $status);
		}
	//return $response;
}


}