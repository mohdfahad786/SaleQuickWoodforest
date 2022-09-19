<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	
	class Payroc extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model'); 
			$this->load->model('admin_model');
			$this->load->model('Inventory_model');
			$this->load->model('Inventory_graph_model');
			$this->load->model('Home_model');
			$this->load->library('email');
			$this->load->library('twilio');
			 $this->load->helper('pdf_helper');
			$this->load->model('customers_model', 'customers');
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'America/Chicago';
				date_default_timezone_set($time_Zone);
			}
			else
			{
				date_default_timezone_set('America/Chicago');
			}
			//ini_set('display_errors', 1);
		    //error_reporting(E_ALL);
		    //ini_set('max_execution_time', -1);
			
		}


	public function refund_invoice() {
			$refundfor = $_POST['refundfor'];  
		 	if($refundfor) {
				// echo "<pre>";print_r(($_POST)); die();
				$merchant_id = $this->session->userdata('merchant_id');
				

				$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
				$getEmail_a = $getQuery_a->result_array();
				$data['$getEmail_a'] = $getEmail_a;

				 $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';

				//print_r($getEmail_a);
				$account_id = $getEmail_a[0]['account_id_cnp'];
				$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
				$account_token = $getEmail_a[0]['account_token_cnp'];
				$application_id = $getEmail_a[0]['application_id_cnp'];
				$terminal_id = $getEmail_a[0]['terminal_id'];
				$id = $_POST['id'];
				$invoice_no = $_POST['invoice_no'];
				$amount_new = number_format($_POST['amount'],2);
    			$b = str_replace(",","",$amount_new);
                $a = number_format($b,2);
                $amount = str_replace(",","",$a);
                
                //echo $_POST['amount']; die();
            
				$transaction_id = $_POST['transaction_id'];
				$payment_id = $_POST['payment_id'];
				$TicketNumber = (rand(100000, 999999));
				$TicketNumber1 = (rand(100000000, 999999999));
				$TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
				// xml post structure
				 $query  = "";
    // Login Information
    $query .= "security_key=" . urlencode($security_key) . "&";
    // Sales Information
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    $query .= "payment=creditcard"."&";
    $query .= "transactionid=" . urlencode($transaction_id) . "&";
     $query .= "type=refund";


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
	$arraya = json_decode($test, true);
			//$json = json_encode($xml);
			//$arraya = json_decode($json, TRUE);

			//print_r($arraya);  die();

			
			$trans_a_no = $arraya['transactionid'];
			$auth_code1 = $arraya['authcode']; 
			$auth_code2 = $arraya['authCode'];
			if($auth_code1!='')
			{
			$auth_code = $auth_code1;
			}
			else
			{
			$auth_code = $auth_code2;
			}

				// print_r($arraya);  die(); 

				//$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
				//$card_type = $arraya['Response']['Card']['CardLogo']? $arraya['Response']['Card']['CardLogo'] : '';
				//$card_no = $arraya['Response']['Card']['CardNumberMasked'] ? $arraya['Response']['Card']['CardNumberMasked'] : '';
				//  die();
				$date_c = date("Y-m-d");
				$merchant_id = $this->session->userdata('merchant_id');

				$branch_info = array(
					
					'amount' => $amount,
					'transaction_id' => $trans_a_no,
					'auth_code' => $auth_code,
					'payment_id' => $payment_id,
					'invoice_no' => $invoice_no,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => $refundfor,
					'status' => 'confirm',
					'c_type' => 'CNP',
				);
				$branch_inf = array(
					'status' => 'Chargeback_Confirm',
					'date_r' => $date_c,
				);
				// $id1 = $this->admin_model->insert_data("refund", $branch_info);
				// $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));
				//if ($arraya['responsetext'] == 'SUCCESS') {
				if ($arraya['response'] == '1') {
					$id1 = $this->admin_model->insert_data("refund", $branch_info);
					$m = $this->admin_model->update_data('customer_payment_request', $branch_inf, array('id' => $id));
					//Refund receipt mail
					$getQuery = $this->db->query("SELECT * from customer_payment_request where id='$id' ");
					$getEmail = $getQuery->result_array();
					$data['getEmail'] = $getEmail;
					
              $paid_amount = $this->input->post('amount') ? $this->input->post('amount') : "";
              $p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
              $amount = $getEmail[0]['amount'];
            	if($getEmail[0]['amount'] > $p_ref_amount )
            	{
            	$p_ref_amount = $p_ref_amount;
            	$partial_refund = 1;
            	}
            	elseif($getEmail[0]['amount'] == $p_ref_amount)
            	{
                   $p_ref_amount = 0;
            	   $partial_refund = 0;
            	}
              $branch_inf_refund_p = array('p_ref_amount' =>$p_ref_amount ,'partial_refund' => $partial_refund);
              $this->admin_model->update_data('customer_payment_request', $branch_inf_refund_p, array('id' => $id)); 


					
					
					$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' ");
					$getEmail1 = $getQuery1->result_array(); 
					$data['getEmail1'] = $getEmail1;
					$data['resend'] = "";  
					$data['refund_data']=$branch_info; 
					$email = $getEmail[0]['email_id']; 
					$amount = $getEmail[0]['amount']; 
					$sub_total = $getEmail[0]['sub_total'];
					$tax = $getEmail[0]['tax']; 
					$originalDate = $getEmail[0]['date_c']; 
					$newDate = date("F d,Y", strtotime($originalDate));
					$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
					//Email Process
					$data['invoice_detail_receipt_item'] = $item;  
					$data['email'] = $getEmail[0]['email_id'];
					$data['color'] = $getEmail1[0]['color'];  
					$data['amount'] = $getEmail[0]['amount'];
					$data['sub_total'] = $getEmail[0]['sub_total']; 
					$data['tax'] = $getEmail[0]['tax']; 
					$data['originalDate'] = $getEmail[0]['date_c']; 
					$data['card_a_no'] = $card_a_no; 
					$data['trans_a_no'] = $trans_a_no; 
					$data['card_a_type'] = $card_a_type;
					$data['message_a'] = $message_a;
					$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
					$data['late_fee'] = $getEmail[0]['late_fee'];
					$data['payment_type'] = 'recurring';
					$data['recurring_type'] = $getEmail[0]['recurring_type'];
					$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
					$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
					$data['msgData'] = $data;
					$msg = $this->load->view('email/refund_receipt', $data, true);
					$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
					$email = $email;
					$MailSubject = ' Refund Receipt from ' . $getEmail1[0]['business_dba_name'];
	                $nameoFCustomer=$getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id']; 
					$MailSubject2 = ' Refund Receipt to ' .$nameoFCustomer;
					
					if (!empty($email)) {
						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->to($email);
						$this->email->subject($MailSubject);
						$this->email->message($msg);
						//$this->email->send();
					}
		            $this->session->set_flashdata('msg', '<div class="text-success text-center"> Amount Refunded Successfully.. </div>');
		            if($refundfor=='straight') {
						redirect(base_url().'pos/all_customer_request');
					} else {
						redirect(base_url() . 'pos/invoice_details/'.$invoice_no);
					}
				} else {
					// $id = $arraya['Response']['ExpressResponseMessage'];
					// redirect('payment_error/' . $id);
					$id = $arraya['responsetext'];
					$this->session->set_flashdata('msg', '<div class="text-danger text-center"> '.$arraya['responsetext'].' </div>');
					if($refundfor=='straight') {
						redirect(base_url().'pos/all_customer_request');
					} else if($refundfor=='recurring') {
	                    redirect(base_url('pos/all_customer_request_recurring'));
					}
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="text-danger text-center">Refund :  Type of Invoice  id Required..</div>');
				redirect(base_url().'pos/invoice_details/'.$invoice_no); 
				
		 	}
			
		}

public function refund_payroc() {
			//print_r($_POST['amount'] ); die();
			//print_r($_POST); die();
			
		   $merchant_id = $this->session->userdata('merchant_id');
		   
		   
		   	$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
		   	$getEmail_a = $getQuery_a->result_array();
		   	$data['$getEmail_a'] = $getEmail_a;

		   	//print_r($getEmail_a);die;
		   	 //$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
		   	 $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
		     //print_r($getEmail_a);
		

			$account_id = $getEmail_a[0]['account_id_cnp'];
			$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			$account_token = $getEmail_a[0]['account_token_cnp'];
			$application_id = $getEmail_a[0]['application_id_cnp'];
			$terminal_id = $getEmail_a[0]['terminal_id'];
			  //print_r($account_token); die(); account_token
			$id = $_POST['id'];
			$invoice_no = $_POST['invoice_no'];
			$amount = $_POST['amount'];   
			
			$amount_new = number_format($amount,2);
                       $b = str_replace(",","",$amount_new);
                       $a = number_format($b,2);
                       $amount = str_replace(",","",$a);
		   	//echo ($amount); die(); 
		   
		   	$transaction_id = $_POST['transaction_id']; 
		   	$TicketNumber = (rand(100000, 999999));  
		   	$TicketNumber1 = (rand(100000000, 999999999));
	  	 	$TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
		   	// xml post structure
		   
	$amount=$amount;
	

    $query  = "";
    // Login Information
    $query .= "security_key=" . urlencode($security_key) . "&";
    // Sales Information
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    $query .= "payment=creditcard"."&";
    $query .= "transactionid=" . urlencode($transaction_id) . "&";
     $query .= "type=refund";


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
	$arraya = json_decode($test, true);
			//$json = json_encode($xml);
			//$arraya = json_decode($json, TRUE);


			curl_close($ch);
			$trans_a_no = $arraya['transactionid'];
			$auth_code1 = $arraya['authcode']; 
			$auth_code2 = $arraya['authCode'];
			if($auth_code1!='')
			{
			$auth_code = $auth_code1;
			}
			else
			{
			$auth_code = $auth_code2;
			}
		   	//    $card_type = $arraya['Response']['Card']['CardLogo'];
		   	//   $card_no = $arraya['Response']['Card']['CardNumberMasked'];
		 	//die();
		   	$date_c = date("Y-m-d");
		   	$merchant_id = $this->session->userdata('merchant_id');

		   	$branch_info = array(
			   'amount' => $amount,
			   'transaction_id' => $trans_a_no,
			   'auth_code' => $auth_code,  
			   'invoice_no' => $invoice_no,
			   'merchant_id' => $merchant_id,
			   'date_c' => $date_c,
			   'type' => 'pos',
			   'status' => 'confirm',
			   'c_type' => 'CNP',

		   	);
		   	$branch_inf = array(

			   'status' => 'Chargeback_Confirm',
			   'date_r' => $date_c,

		   	);
		   	//print_r($arraya['Response']['ExpressResponseMessage']);  die(); 
		   	//if ($arraya['responsetext'] == 'Approved') {
		   		//if ($arraya['responsetext'] == 'SUCCESS') {
		   			if ($arraya['response'] == '1') {
		   		
			   $id1 = $this->admin_model->insert_data("refund", $branch_info);
			   $this->session->set_flashdata('msg', '<div class="text-success text-center"> Amount Refunded Successfully.. </div>');
			   $this->admin_model->update_data('pos', $branch_inf, array('id' => $id));
			   
			   
			   
			   
			   
			    $getQuery = $this->db->query("SELECT * from pos where id='$id' ");
												   $getEmail = $getQuery->result_array();
												   $data['getEmail'] = $getEmail;
												   
												   
	$paid_amount = $this->input->post('amount') ? $this->input->post('amount') : "";
  $p_ref_amount = $getEmail[0]['p_ref_amount'] + $paid_amount;
  $amount = $getEmail[0]['amount'];
	if($getEmail[0]['amount'] > $p_ref_amount )
	{
	$p_ref_amount = $p_ref_amount;
	$partial_refund = 1;
	}
	elseif($getEmail[0]['amount'] == $p_ref_amount)
	{
       $p_ref_amount = 0;
	   $partial_refund = 0;
	}
  $branch_inf_refund_p = array('p_ref_amount' =>$p_ref_amount ,'partial_refund' => $partial_refund);
  $this->admin_model->update_data('pos', $branch_inf_refund_p, array('id' => $id));
  
						   
							   $getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' ");
							   $getEmail1 = $getQuery1->result_array(); 
							   $data['getEmail1'] = $getEmail1;
	   
	   
							   $data['resend'] = "";  $data['refund_data']=$branch_info; 
							   $email = $getEmail[0]['email_id']; $amount = $getEmail[0]['amount']; $sub_total = $getEmail[0]['sub_total'];
							   $tax = $getEmail[0]['tax']; $originalDate = $getEmail[0]['date_c']; $newDate = date("F d,Y", strtotime($originalDate));
							   $data['email'] = $getEmail[0]['email_id'];
							   $data['color'] = $getEmail1[0]['color'];  $data['amount'] = $getEmail[0]['amount'];
							   $data['sub_total'] = $getEmail[0]['sub_total']; $data['tax'] = $getEmail[0]['tax']; 
							   $data['originalDate'] = $getEmail[0]['date_c']; $data['card_a_no'] = $card_a_no; 
							   $data['trans_a_no'] = $trans_a_no; $data['card_a_type'] = $card_a_type;
							   $data['message_a'] = $message_a; $data['msgData'] = $data;
	   
							   $invoice_no=$getEmail[0]['invoice_no'];
							   $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$invoice_no'");
							   $itemslist = $getQuery1->result_array();
							   $data['invoice_detail_receipt_item'] = $itemslist;
							   $data['itemlisttype'] = 'pos';  
	   
							   $msg = $this->load->view('email/refund_receipt', $data, true);
							   $merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
							   
							   $email = $email;
							   $MailSubject = ' Refund Receipt from ' . $getEmail1[0]['business_dba_name'];
							   $nameoFCustomer=$getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id']; 
							   $MailSubject2 = ' Refund Receipt to ' .$nameoFCustomer;
							   
												
												   if (!empty($email)) {
													   $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
													   $this->email->to($email);
													   $this->email->subject($MailSubject);
													   $this->email->message($msg);
													  // $this->email->send();
												   }
												   $this->session->set_flashdata('success','Amount Refunded Successfully.. ');
			     
			   
			   
			   
			   
			   
			   redirect(base_url() . 'refund/all_pos');
		   	} else {
			   //$errorCode = $arraya['Response']['ExpressResponseCode'];
			   $this->session->set_flashdata('errorCode',$arraya['responsetext']);
			   $id = $arraya['responsetext'];
			   redirect(base_url().'payment_error/' . $id);

		   	}

	   	}


public function card_payment() {
		$data['meta'] = "Add New Pos";
		$data['loc'] = "add_pos";
		$data['action'] = "Charge";

		$merchant_id = $this->session->userdata('merchant_id');
		
		// if($merchant_id==413){

	 // print_r(($_POST)); die();
	 // }

		
		

		$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
		$getEmail_a = $getQuery_a->result_array();
		$data['$getEmail_a'] = $getEmail_a;

		 //$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
		 $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
		 $processor_id=trim($getEmail_a[0]['processor_id']);
		//print_r($getEmail_a);
		if (!empty($security_key) and !empty($processor_id) ) {

			
			$mobile_no = $this->input->post('mobile_no') ? trim($this->input->post('mobile_no')) : "";
			$email_id = $this->input->post('email_id') ? trim($this->input->post('email_id')) : "";

			
			$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
			$card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
                        $card_no = preg_replace('/\s+/', '', $card_no);
                        //echo $card_no;die();
			$cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";

			$card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$zip = $this->input->post('zip') ? $this->input->post('zip') : "";
			$address = $this->input->post('address') ? $this->input->post('address') : "";

			$expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
			$expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";
			$payment_id_1 = "POS_" . date("ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);
			// xml post structure

		
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
    $query .= "zip=" . urlencode($zip) . "&";
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

			
					$card_a_no = $response['cc_number'];
					//$auth_code = $response['authcode'];

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

					$trans_a_no = $response['transactionid']; 
				
					$card_type =$card_type;

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
					

				

					$this->form_validation->set_rules('amount', 'Amount', 'required');
					$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
					$email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
					$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
					$tax = $this->input->post('totaltax') ? $this->input->post('totaltax') : "";
					$other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
					$other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
					$cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
					$name = $this->input->post('name') ? $this->input->post('name') : "";
					$card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
					$expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
					$expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";
					$transaction_id =$trans_a_no;

					$ip =$response['ipaddress']; 

					$merchant_id = $this->session->userdata('merchant_id');
					if (!empty($this->session->userdata('subuser_id'))) {
						$sub_merchant_id = $this->session->userdata('subuser_id');
					} else {
						$sub_merchant_id = '0';
					}

					

					$tax_id = json_encode($this->input->post('TAX_ID'));
					$tax_per = json_encode($this->input->post('TAX_PER'));

					
					if ($this->form_validation->run() == FALSE) {

						
						$this->load->view('merchant/pos_dash', $data);
						
					} else {
						$merchant_id = $this->session->userdata('merchant_id');
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
							'expiry_month' => $expiry_month,
							'expiry_year' => $expiry_year,
							'year' => $year,
							'month' => $month,
							'time1' => $time1,
							'day1' => $day1,
							'date_c' => $today2,
							'auth_code' => $auth_code,
							'status' => $staus,
							'transaction_id' => $trans_a_no,
							'c_type' => 'CNP',
							'processor_name'=>'PAYROC',
							'payment_type' => 'web',
							'card_type' => $card_type,
							'transaction_status' => $message_a,
							'express_responsemessage'=>$message_complete,
							'ip'=>$ip,
							'express_transactiondate' => '',
							'express_transactiontime' => '',
							'acquirer_data' => '',

						);



						//print_r($data);  
						

						$id = $this->admin_model->insert_data("pos", $data);

						 $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'pos_id' =>$id,
                        'rawResponse' =>$test,
                        );
                        $pax_id = $this->admin_model->insert_data("payroc_json", $data_pax);
						//$this->db->last_query(); die();

						$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
						$getEmail1 = $getQuery1->result_array();
						$data['getEmail1'] = $getEmail1;
						$data['card_a_no'] = $card_a_no;
						$data['trans_a_no'] = $trans_a_no;
						$data['card_a_type'] = $card_type;
						$data['message_complete'] = $message_complete;
						$data['name'] = $name;
						$data['amount'] = $amount;
						$data['invoice_no'] = $payment_id;
						$data['date_c'] = $today2;
						$data['reference'] = '0';

						$data['msgData'] = $data;
						
				

						$msg = $this->load->view('email/pos_receipt', $data, true);
						$email = $email_id;

					

						$MailSubject = ' Point Of Sale Receipt from '.$getEmail1[0]['business_dba_name'];
				

						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->to($email);
						$this->email->subject($MailSubject);
						$this->email->message($msg);

						



				if ($response['response']==1 ) {
								
				 //Satrt QuickBook sync
				  $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id and status='1' and vt_status='1' ";
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


						$this->email->send();
                        
                        $purl = base_url() . 'pos_reciept/' . $payment_id . '/' . $merchant_id;     
						if(!empty($mobile_no))
									 {

									$sms_reciever = $mobile_no;
									//$sms_message = trim('Payment Receipt : '.$purl);
									$sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);

									$from = '+18325324983'; //trial account twilio number

									$mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);

									 $to = '+1'.$mob;

									 $response_sms = $this->twilio->sms($from, $to,$sms_message);

									}
						//print_r($response_sms);
						//die();
						
						$this->session->set_flashdata('success', 'Payment successfully done. We send the receipt on the option you choose.');
						redirect(base_url() . 'pos/confirm_payment/' . $id);					
						//redirect(base_url() . 'pos/all_pos');
						} elseif($arrayy['Response']['ExpressResponseMessage'] == 'Declined'){
						    	$id = 'Declined';
						    	$this->session->set_flashdata('success', 'Payment successfully done. We send the receipt on the option you choose.');
						redirect(base_url() . 'payment_error/' . $id);
						}
						
						else {
					$id = $response['responsetext'];
					redirect('payment_error/' . $id);
			        	}



					}
					
			

			

		} else {
			$id = 'Processor-ID-Not-available';
			redirect('payment_error/' . $id);
		}
	}





	   	}