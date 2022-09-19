<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AcceptCard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // load base_url
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->model('acceptcard_model');
        $this->load->model('home_model');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('twilio');
        if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'America/Chicago';
				date_default_timezone_set($time_Zone);
			} else {
				date_default_timezone_set('America/Chicago');
			}
        // Load Model
        //$this->load->model('Main_model');
    }

    public function index() {
        $this->load->view('merchant/AcceptCard_view');
    }

	public function updateCardByMerchant($invoice_no)
	{

			$merchant_id = $this->session->userdata('merchant_id');
		
		$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
		$getEmail_a = $getQuery_a->result_array();
		$data['$getEmail_a'] = $getEmail_a;

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
         $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
		 $processor_id=trim($getEmail_a[0]['processor_id']);
		 
		 $mydata=array();
		 $mydata['merchant_id'] =$merchant_id;
		 $this->form_validation->set_rules('card_no', 'card_no', 'required');
		 
		 $amount ='0.1';
		 //$other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
		 //$other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
		 $name= $this->input->post('name_card') ? $this->input->post('name_card') : "";
		 $mydata['name']=$name;
		 $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
		 
		 $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
		 
		 $exp=$this->input->post('exp');
		 $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
		 
		 $expiry_month= substr($exp,0,2);
		 
		 $expiry_year = substr($exp,3,5);
		 
		 
		 $transaction_id =$trans_a_no;
		 //print_r($mydata);die;
		 $ip =$response['ipaddress']; 
		
		if (!empty($security_key) and !empty($processor_id) ) {
	
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
			$query .= "customer_vault=" . urlencode('add_customer') . "&";
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
			$query .= "type=sale"."&";

			
			//print_r($query);die;
		
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
			curl_setopt($ch, CURLOPT_POST, 1);
			//echo $query;
			if (!($data = curl_exec($ch))) {
				//echo 'er';	
				return ERROR;
			}
			curl_close($ch);
			unset($ch);
		    
			parse_str($data, $parsed);
			$test = json_encode($parsed);
			$response = json_decode($test, true);
			//print_r($response);die;
			//$msg=$msg.$response['transactionid']." customer_vault_id:".$response['customer_vault_id']." Amount Deducted: ".$response['amount'];
			$mydata['token'] =$response['customer_vault_id'];
			$mydata['transaction_id'] =$response['transactionid'];
			
			$mydata['card_type'] =$response['cc_type'];
			$mydata['card_expiry_month']=$expiry_month;
			$mydata['card_expiry_year']=$expiry_year;
			$mydata['card_no'] =$response['cc_number'];
			$mydata['zipcode']=$zip;			
			$mydata['mobile'] =$getEmail_a[0]['mob_no'];
			$mydata['email'] =$getEmail_a[0]['email'];
			$mydata['status']='1';
			$mydata['payroc']='1';
			//echo 'check';
			//print_r($mydata);die;	
			
			///refund

			$transaction_id = $response['transactionid'];//$_POST['transaction_id']; 
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
 
 			//print_r($query);die;
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
		 //print_r($arraya);die;
 
		 curl_close($ch);
		 //$msg=$msg." Refund Response:"." ".$arraya['responsetext']." Amount Refunded: ".$arraya['amount'];
		 
			//refund($response['transactionid']);
			$this->acceptcard_model->insert_Card($mydata); 
			//  code of invoice
			$collect = array();
		
			session_start();
		
		
	//  print_r($collect);
	// die(); // ghayas
	  //print_r($mydata['token']);
	  $_SESSION['token']=$mydata['token'];
	  $this->acceptcard_model->updateInvoiceAndToken($_SESSION['token'],$merchant_id,$invoice_no);
	  $res=$this->acceptcard_model->fetch($_SESSION['token'],$merchant_id);
	  
	 //print_r($res);die;
      $data=array();
      $data['card_no']= $res[0]['card_no'];
      $data['token']= $res[0]['token'];

      $data['card_type']=$res[0]['card_type'];
	//print_r($data);die;  
			// code of invoice end
			//$this->load->view("merchant/customer_recurring", $data);

			$msg="Card updated !!! New Token Number is:".$res[0]['token'];;
			$this->session->set_flashdata('success',$msg);		
			redirect(base_url('pos/all_customer_request_recurring')); 
	
			}

	}

	public function updateCard($invoice_no){
		$merchant_id = $this->session->userdata('merchant_id');
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        $data['meta'] = "Add New Pos";
        $data['loc'] = "add_pos";
        $data['action'] = "Charge";
        $merchant_id = $this->session->userdata('merchant_id');
        
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        
        $security_key = 'fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
        $processor_id = trim($getEmail_a[0]['processor_id']);
        $mydata = array();
        $mydata['merchant_id'] = $merchant_id;
        $this->form_validation->set_rules('card_no', 'card_no', 'required');
        
        $amount = '0.01';
        $name = $this->input->post('name_card') ? $this->input->post('name_card') : "";
        $mydata['name'] = $name;
         $email = $this->input->post('s_email') ? $this->input->post('s_email') : "";
        $mob_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";
        $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
        $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
        $exp = $this->input->post('exp');
        $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
        $expiry_month = substr($exp, 0, 2);
        $expiry_year = substr($exp, 3, 5);
        $transaction_id = $trans_a_no;
        //print_r($mydata);die;
        $ip = $response['ipaddress'];
        if (!empty($security_key) and !empty($processor_id)) {
            $ccnumber = $card_no;
            $amount = $amount;
            $ccexp = $expiry_month . $expiry_year;
            $cvv = $cvv;
            $authorizationcode = "";
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $orderid = $payment_id;
            $query = "";
            // Login Information
            $query.= "security_key=" . urlencode($security_key) . "&";
            $query.= "customer_vault=" . urlencode('add_customer') . "&";
            // Sales Information
            $query.= "ccnumber=" . urlencode($ccnumber) . "&";
            $query.= "ccexp=" . urlencode($ccexp) . "&";
            $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
            $query.= "cvv=" . urlencode($cvv) . "&";
            $query.= "zip=" . urlencode($zip) . "&";
            $query.= "processor_id=" . urlencode($processor_id) . "&";
            $query.= "authorizationcode=" . urlencode($authorizationcode) . "&";
            $query.= "ipaddress=" . urlencode($ipaddress) . "&";
            $query.= "orderid=" . urlencode($orderid) . "&";
            $query.= "type=sale" . "&";
            // echo '11';die;
            //print_r($query);die;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            curl_setopt($ch, CURLOPT_POST, 1);
            //echo $query;
            if ($data = curl_exec($ch)) {
            	// echo $data;die;
            	// echo 1;die;
                // echo 'er';

                curl_close($ch);
	            unset($ch);
	            parse_str($data, $parsed);
	            $test = json_encode($parsed);
	            $response = json_decode($test, true);
	          // if($merchant_id=='888'){
	          //  print_r($response);die;
	          // }

	            if($response['response'] != '1') {
	            	$data_resp['code'] = 500;
	            	$data_resp['msg'] = $response['responsetext'];
	            	// echo 1;die;
	            	echo json_encode($data_resp);die;
	            	// echo 1;die;
	            }
	            //$msg=$msg.$response['transactionid']." customer_vault_id:".$response['customer_vault_id']." Amount Deducted: ".$response['amount'];
	            $mydata['token'] = $response['customer_vault_id'];
	            $mydata['transaction_id'] = $response['transactionid'];
	            $mydata['card_type'] = $response['cc_type'];
	            $mydata['card_expiry_month'] = $expiry_month;
	            $mydata['card_expiry_year'] = $expiry_year;
	            $mydata['card_no'] = $response['cc_number'];
	            $mydata['zipcode'] = $zip;

	            $mob = str_replace(array( '(', ')','-',' ' ), '', $mob_no);
	            $mydata['mobile'] = $mob;
	             $mydata['email'] = $email;
	            $mydata['status'] = '1';
	            $mydata['payroc'] = '1';
	            //echo 'check';
	            // print_r($mydata);die;

	            ///refund
	            $transaction_id = $response['transactionid']; //$_POST['transaction_id'];
	            $TicketNumber = (rand(100000, 999999));
	            $TicketNumber1 = (rand(100000000, 999999999));
	            $TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
	            // xml post structure
	            $amount = $amount;
	            $query = "";
	            // Login Information
	            $query.= "security_key=" . urlencode($security_key) . "&";
	            // Sales Information
	            $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
	            $query.= "payment=creditcard" . "&";
	            $query.= "transactionid=" . urlencode($transaction_id) . "&";
	            $query.= "type=refund";
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
	            //print_r($arraya);die;
	          //   if($merchant_id=='888'){
	          //  print_r($arraya);
	          // }
	            curl_close($ch);

	            //$msg=$msg." Refund Response:"." ".$arraya['responsetext']." Amount Refunded: ".$arraya['amount'];
	            //refund($response['transactionid']);
	            //	$this->load->model('AcceptCard_model');
	            //echo 'model loaded'; die;
	            //$xx= $this->acceptcard_model->insert_Card($mydata);
	            //print_r($mydata);//die;
	            $this->acceptcard_model->insert_Card($mydata);
	            $token_id = $this->db->insert_id();
	             //echo $token_id;die; 

	            if($token_id != '') {
	            	// echo 33;die;
	            	//$token_id = $this->db->insert_id();
		            // session_start();
		            
		            $_SESSION['token'] = $mydata['token'];
		            $_SESSION['token_id'] = $token_id;
		            $res = $this->acceptcard_model->fetch($_SESSION['token'],$merchant_id);
		            $this->db->query("update customer_payment_request set token=1 where invoice_no='".$invoice_no."'");
					$query1=$this->db->query("SELECT token.id from token,invoice_token where invoice_token.token_id=token.id and invoice_no='".$invoiceNum."'")->result_array();
		            $query2=$this->db->query("update invoice_token set token_id=".$query1[0]['id']." where invoice_no='".$invoiceNum."'");
		            //echo $this->db->last_query();die;
		            // print_r($res);//die;
		            $data = array();
		            // $msg = "Token Created Successfully";
		            $data['card_no'] = $res[0]['card_no'];
		            $data['token'] = $res[0]['token'];
		            $data['card_type'] = $res[0]['card_type'];
		            // $data['msg'] = $msg;
		            $other_charges = $this->input->post('other_charges_value') ? $this->input->post('other_charges_value') : "";
	                $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";

		            // echo json_encode($data);die;
		            $s_amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : "";
		            if (!empty($this->session->userdata('subuser_id'))) {
		                $sub_merchant_id = $this->session->userdata('subuser_id');
		            } else {
		                $sub_merchant_id = '0';
		            }
		            $fee = ($s_amount / 100) * $fee_invoice;
		            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
		            $fee_email = ($fee_email != '') ? $fee_email : 0;
		            $fee = $fee + $fee_swap + $fee_email;
		            $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
		            $full_amount = $this->input->post('full_amount') ? $this->input->post('full_amount') : "";
		            $full_amount_amount = $this->input->post('full_amount_amount') ? $this->input->post('full_amount_amount') : "";
		            $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";

		            $invoice_no_1 = 'INV' . date("ymdhisu");
		            $invoice_no = str_replace("000000", "", $invoice_no_1);

		            $recurring_payment = 'start';
		            $merchant_id = $this->session->userdata('merchant_id');
		            //echo 2;die;
		            $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";
	                $name = $this->input->post('name') ? $this->input->post('name') : "";
	                $email_id = $this->input->post('s_email') ? $this->input->post('s_email') : "";
	                $phone = $mobile_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";
	                // $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";


	                $recurring_type1 = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
	                $myArray = explode(',', $recurring_type1);
	                $recurring_type=strtolower(trim($myArray[0]));

	                if($recurring_type=='weekly'){
	                $recurring_type_weekly=strtolower(trim($myArray[1]));
	                $recurring_type_monthly='';
	                }
	                else if($recurring_type=='monthly'){
	                $recurring_type_weekly='';
	                $recurring_type_monthly=strtolower(trim($myArray[1]));
	                }
	                else
	                {
	                $recurring_type_weekly='';
	                $recurring_type_monthly='';
	                }

	                $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
	                $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
	                $recurring_pay_start_date = $this->input->post('s_start_date') ? $this->input->post('s_start_date') : "";
	                
	                if ($pd__constant == 'on' && $recurring_count == "") {
	                    $recurring_count = - 1;
	                }
	                // echo $recurring_count;  die();
	                if ($paytype == '0' || $paytype == '1') {
	                    $today1_1 = date("ymdhisu");
                        $today1 = str_replace("000000", "", $today1_1);
	                    $url = base_url() . 'rpayment/PY' . $today1 . '/' . $merchant_id;
	                    $today2 = date("Y-m-d");
	                    $year = date("Y");
	                    $month = date("m");
	                    $today3 = date("Y-m-d H:i:s");
	                    $unique = "PY" . $today1;
	                    $time11 = date("H");
	                    if ($time11 == '00') {
	                        $time1 = '01';
	                    } else {
	                        $time1 = date("H");
	                    }
	                    $recurring_pay_start_date = date($recurring_pay_start_date);
	                    //echo $recurring_type;  die();
	                    if ($recurring_count > 0) {
	                        $remain = $recurring_count;
	                    } else {
	                        $remain = 1;
	                        $recurring_count = - 1;
	                    }
	                    switch ($recurring_type) {
	                        case 'daily':
	                            $recurring_next_pay_date = Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
	                        break;
	                        case 'weekly':
	                            $recurring_next_pay_date = Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
	                        break;
	                        case 'biweekly':
	                            $recurring_next_pay_date = date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
	                        break;
	                        case 'monthly':
	                            $recurring_next_pay_date = date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
	                        break;
	                        case 'quarterly':
	                            $recurring_next_pay_date = date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
	                        break;
	                        case 'yearly':
	                            $recurring_next_pay_date = date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
	                        break;
	                        default:
	                            $recurring_next_pay_date = Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
	                        break;
	                    }
	                    // echo $paytype.','.$mydata['token'].','.$today2.','.$recurring_pay_start_date;die;

          // die("ok");    

	                    $day1 = date("N");
	                    $amountaa = $sub_amount + $fee;
	                    	                    
	                    $data = array();
	                    $data['merchant_id'] = $this->session->userdata('merchant_id');
	                    $collect = array('invoice_no' => $invoice_no, 'merchant_id' => $data['merchant_id'],);
	                    //print_r($collect);die;
	                    // $this->acceptcard_model->saveInvoiceNum($collect, $_SESSION['token']);

	                    $MailTo = $email_id;
	                    $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
	                    $getDashboardData_m = $getDashboard_m->result_array();
	                    $data['getDashboardData_m'] = $getDashboardData_m;
	                    $data['business_name'] = $getDashboardData_m[0]['business_name'];
	                    $data['address1'] = $getDashboardData_m[0]['address1'];
	                    $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
	                    $data['logo'] = $getDashboardData_m[0]['logo'];
	                    $data['business_number'] = $getDashboardData_m[0]['business_number'];
	                    $data['color'] = $getDashboardData_m[0]['color'];
	                    $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
	                    $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
	                    $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
	                    $data['payment_type'] = 'recurring';
	                    $data['recurring_type'] = $recurring_type;
	                    $data['no_of_invoice'] = 1;
	                    $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';

	                    //$this->admin_model->insert_data("order_item", $item_Detail_1);
	                    // $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
	                    $data['item_detail'] = $item_Detail_1;
	                    $data['msgData'] = $data;



             			$new_data = array();
	                    $sql_nn="SELECT card_type, right(card_no,4) as 'card_no',token from token where token='".$_SESSION['token']."'";
                        $res = $this->db->query($sql_nn)->result_array();
                        

                        $type= strtolower($res[0]['card_type']);
                        //echo $type;
                        if($type == 'amex') { 
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';

                        } else if($type == 'visa') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'diners') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'mastercard') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'mc') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'jcb') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'discover') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/cardtypelogo.png" style="width: 48px;height: 30px;">';
                        }

                        

                        // $new_data_n = echo json_encode($new_data);
	                    $new_data['card_no'] = $res[0]['card_no'];
                        $new_data['token'] = $res[0]['token'];
                        // $new_data['card_type'] = $res[0]['card_type'];

	                    $data_resp['code'] = 200;
		            	$data_resp['msg'] = $new_data;

	              //       $data_resp['code'] = 200;
		            	// $data_resp['msg'] = '';
		            	echo json_encode($data_resp);die;
	                    // redirect("pos/all_customer_request_recurring");
	                }
	            	
	            } else {
	            	// echo 44;die;
	            	$data_resp['code'] = 500;
	            	$data_resp['msg'] = 'Something went wrong. Please try again.';
	            	echo json_encode($data_resp);die;
	            }
	            // print_r($data);die;
	            // code of invoice end
	            // $this->load->view("merchant/customer_recurring", $data);

            } else {
            	// echo 2;die;
            	return ERROR;
            	
            }
        }
		
	}

    public function saveCard() {
    	// echo '<pre>';print_r($_POST);die;

    	$merchant_id = $this->session->userdata('merchant_id');
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        $data['meta'] = "Add New Pos";
        $data['loc'] = "add_pos";
        $data['action'] = "Charge";
        $merchant_id = $this->session->userdata('merchant_id');
        
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        
        $security_key = 'fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
        $processor_id = trim($getEmail_a[0]['processor_id']);
        $mydata = array();
        $mydata['merchant_id'] = $merchant_id;
        $this->form_validation->set_rules('card_no', 'card_no', 'required');
        
        $amount = '0.01';
        $name = $this->input->post('name_card') ? $this->input->post('name_card') : "";
        $email = $this->input->post('s_email') ? $this->input->post('s_email') : "";
        $mob_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";

        
        $mydata['name'] = $name;
        $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
        $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
        $exp = $this->input->post('exp');
        $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
        $expiry_month = substr($exp, 0, 2);
        $expiry_year = substr($exp, 3, 5);
        $transaction_id = $trans_a_no;
        //print_r($mydata);die;
        $ip = $response['ipaddress'];
        if (!empty($security_key) and !empty($processor_id)) {
            $ccnumber = $card_no;
            $amount = $amount;
            $ccexp = $expiry_month . $expiry_year;
            $cvv = $cvv;
            $authorizationcode = "";
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $orderid = $payment_id;
            $query = "";
            // Login Information
            $query.= "security_key=" . urlencode($security_key) . "&";
            $query.= "customer_vault=" . urlencode('add_customer') . "&";
            // Sales Information
            $query.= "ccnumber=" . urlencode($ccnumber) . "&";
            $query.= "ccexp=" . urlencode($ccexp) . "&";
            $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
            $query.= "cvv=" . urlencode($cvv) . "&";
            $query.= "zip=" . urlencode($zip) . "&";
            $query.= "processor_id=" . urlencode($processor_id) . "&";
            $query.= "authorizationcode=" . urlencode($authorizationcode) . "&";
            $query.= "ipaddress=" . urlencode($ipaddress) . "&";
            $query.= "orderid=" . urlencode($orderid) . "&";
            $query.= "type=sale" . "&";
            // echo '11';die;
            //print_r($query);die;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            curl_setopt($ch, CURLOPT_POST, 1);
            //echo $query;
            if ($data = curl_exec($ch)) {
            	// echo $data;die;
            	// echo 1;die;
                // echo 'er';

                curl_close($ch);
	            unset($ch);
	            parse_str($data, $parsed);
	            $test = json_encode($parsed);
	            $response = json_decode($test, true);
	          // if($merchant_id=='888'){
	          //  print_r($response);die;
	          // }

	            if($response['response'] != '1') {
	            	$data_resp['code'] = 500;
	            	$data_resp['msg'] = $response['responsetext'];
	            	// echo 1;die;
	            	echo json_encode($data_resp);die;
	            	// echo 1;die;
	            }
	            //$msg=$msg.$response['transactionid']." customer_vault_id:".$response['customer_vault_id']." Amount Deducted: ".$response['amount'];
	            $mydata['token'] = $response['customer_vault_id'];
	            $mydata['transaction_id'] = $response['transactionid'];
	            $mydata['card_type'] = $response['cc_type'];
	            $mydata['card_expiry_month'] = $expiry_month;
	            $mydata['card_expiry_year'] = $expiry_year;
	            $mydata['card_no'] = $response['cc_number'];
	            $mydata['zipcode'] = $zip;

	            $mob = str_replace(array( '(', ')','-',' ' ), '', $mob_no);
	            $mydata['mobile'] = $mob;
	            $mydata['email'] = $email;
	            $mydata['status'] = '1';
	            $mydata['payroc'] = '1';
	            //echo 'check';
	            // print_r($mydata);die;

	            ///refund
	            $transaction_id = $response['transactionid']; //$_POST['transaction_id'];
	            $TicketNumber = (rand(100000, 999999));
	            $TicketNumber1 = (rand(100000000, 999999999));
	            $TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
	            // xml post structure
	            $amount = $amount;
	            $query = "";
	            // Login Information
	            $query.= "security_key=" . urlencode($security_key) . "&";
	            // Sales Information
	            $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
	            $query.= "payment=creditcard" . "&";
	            $query.= "transactionid=" . urlencode($transaction_id) . "&";
	            $query.= "type=refund";
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
	            //print_r($arraya);die;
	          //   if($merchant_id=='888'){
	          //  print_r($arraya);
	          // }
	            curl_close($ch);

	            //$msg=$msg." Refund Response:"." ".$arraya['responsetext']." Amount Refunded: ".$arraya['amount'];
	            //refund($response['transactionid']);
	            //	$this->load->model('AcceptCard_model');
	            //echo 'model loaded'; die;
	            //$xx= $this->acceptcard_model->insert_Card($mydata);
	            //print_r($mydata);//die;
	            $this->acceptcard_model->insert_Card($mydata);
	            $token_id = $this->db->insert_id();
	             //echo $token_id;die;

	            if($token_id != '') {
	            	// echo 33;die;
	            	//$token_id = $this->db->insert_id();
		            // session_start();
		            
		            $_SESSION['token'] = $mydata['token'];
		            $_SESSION['token_id'] = $token_id;
		            $res = $this->acceptcard_model->fetch($_SESSION['token'],$merchant_id);
		            // print_r($res);//die;
		            $data = array();
		            // $msg = "Token Created Successfully";
		            $data['card_no'] = $res[0]['card_no'];
		            $data['token'] = $res[0]['token'];
		            $data['card_type'] = $res[0]['card_type'];
		            // $data['msg'] = $msg;
		            $other_charges = $this->input->post('other_charges_value') ? $this->input->post('other_charges_value') : "";
	                $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";

		            // echo json_encode($data);die;
		            $s_amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : "";
		            if (!empty($this->session->userdata('subuser_id'))) {
		                $sub_merchant_id = $this->session->userdata('subuser_id');
		            } else {
		                $sub_merchant_id = '0';
		            }
		            $fee = ($s_amount / 100) * $fee_invoice;
		            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
		            $fee_email = ($fee_email != '') ? $fee_email : 0;
		            $fee = $fee + $fee_swap + $fee_email;
		            $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
		            $full_amount = $this->input->post('full_amount') ? $this->input->post('full_amount') : "";
		            $full_amount_amount = $this->input->post('full_amount_amount') ? $this->input->post('full_amount_amount') : "";
		            $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";

		            $invoice_no_1 = 'INV' . date("ymdhisu");
		            $invoice_no = str_replace("000000", "", $invoice_no_1);

		            $recurring_payment = 'start';
		            $merchant_id = $this->session->userdata('merchant_id');
		            //echo 2;die;
		            $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";
	                $name = $this->input->post('name') ? $this->input->post('name') : "";
	                $email_id = $this->input->post('s_email') ? $this->input->post('s_email') : "";
	                $phone = $mobile_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";
	                // $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";


	                $recurring_type1 = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
	                $myArray = explode(',', $recurring_type1);
	                $recurring_type=strtolower(trim($myArray[0]));

	                if($recurring_type=='weekly'){
	                $recurring_type_weekly=strtolower(trim($myArray[1]));
	                $recurring_type_monthly='';
	                }
	                else if($recurring_type=='monthly'){
	                $recurring_type_weekly='';
	                $recurring_type_monthly=strtolower(trim($myArray[1]));
	                }
	                else
	                {
	                $recurring_type_weekly='';
	                $recurring_type_monthly='';
	                }

	                $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
	                $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
	                $recurring_pay_start_date = $this->input->post('s_start_date') ? $this->input->post('s_start_date') : "";
	                
	                if ($pd__constant == 'on' && $recurring_count == "") {
	                    $recurring_count = - 1;
	                }
	                // echo $recurring_count;  die();
	                if ($paytype == '0' || $paytype == '1') {
	                    $today1_1 = date("ymdhisu");
                        $today1 = str_replace("000000", "", $today1_1);
	                    $url = base_url() . 'rpayment/PY' . $today1 . '/' . $merchant_id;
	                    $today2 = date("Y-m-d");
	                    $year = date("Y");
	                    $month = date("m");
	                    $today3 = date("Y-m-d H:i:s");
	                    $unique = "PY" . $today1;
	                    $time11 = date("H");
	                    if ($time11 == '00') {
	                        $time1 = '01';
	                    } else {
	                        $time1 = date("H");
	                    }
	                    $recurring_pay_start_date = date($recurring_pay_start_date);
	                    //echo $recurring_type;  die();
	                    if ($recurring_count > 0) {
	                        $remain = $recurring_count;
	                    } else {
	                        $remain = 1;
	                        $recurring_count = - 1;
	                    }
	                    
	                    // echo $paytype.','.$mydata['token'].','.$today2.','.$recurring_pay_start_date;die;

          // die("ok");    

	                    $day1 = date("N");
	                    $amountaa = $sub_amount + $fee;
	                    	                    
	                    $data = array();
	                    $data['merchant_id'] = $this->session->userdata('merchant_id');
	                    $collect = array('invoice_no' => $invoice_no, 'merchant_id' => $data['merchant_id'],);
	                    //print_r($collect);die;
	                    // $this->acceptcard_model->saveInvoiceNum($collect, $_SESSION['token']);

	                    $MailTo = $email_id;
	                    $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
	                    $getDashboardData_m = $getDashboard_m->result_array();
	                    $data['getDashboardData_m'] = $getDashboardData_m;
	                    $data['business_name'] = $getDashboardData_m[0]['business_name'];
	                    $data['address1'] = $getDashboardData_m[0]['address1'];
	                    $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
	                    $data['logo'] = $getDashboardData_m[0]['logo'];
	                    $data['business_number'] = $getDashboardData_m[0]['business_number'];
	                    $data['color'] = $getDashboardData_m[0]['color'];
	                    $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
	                    $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
	                    $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
	                    $data['payment_type'] = 'recurring';
	                    $data['recurring_type'] = $recurring_type;
	                    $data['no_of_invoice'] = 1;
	                    $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';

	                    //$this->admin_model->insert_data("order_item", $item_Detail_1);
	                    // $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
	                    $data['item_detail'] = $item_Detail_1;
	                    $data['msgData'] = $data;


	                    //$header = "From: " . $getDashboardData_m[0]['business_dba_name'] . "<info@salequick.com >\r\n" . "MIME-Version: 1.0" . "\r\n" . "Content-type: text/html; charset=UTF-8" . "\r\n";
	                    //if ($recurring_pay_start_date <= $today2) {
	                   
             			$new_data = array();
	                    $sql_nn="SELECT card_type, right(card_no,4) as 'card_no',token from token where token='".$_SESSION['token']."'";
                        $res = $this->db->query($sql_nn)->result_array();
                        

                        $type= strtolower($res[0]['card_type']);
                        //echo $type;
                        if($type == 'amex') { 
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';

                        } else if($type == 'visa') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'diners') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'mastercard') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'mc') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'jcb') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else if($type == 'discover') {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                        } else {
                            $new_data['card_type'] = '<img src="https://salequick.com/new_assets/img/cardtypelogo.png" style="width: 48px;height: 30px;">';
                        }

                        

                        // $new_data_n = echo json_encode($new_data);
	                    $new_data['card_no'] = $res[0]['card_no'];
                        $new_data['token'] = $res[0]['token'];
                        // $new_data['card_type'] = $res[0]['card_type'];

	                    $data_resp['code'] = 200;
		            	$data_resp['msg'] = $new_data;

	              //       $data_resp['code'] = 200;
		            	// $data_resp['msg'] = '';
		            	echo json_encode($data_resp);die;
	                    // redirect("pos/all_customer_request_recurring");
	                }
	            	
	            } else {
	            	// echo 44;die;
	            	$data_resp['code'] = 500;
	            	$data_resp['msg'] = 'Something went wrong. Please try again.';
	            	echo json_encode($data_resp);die;
	            }
	            // print_r($data);die;
	            // code of invoice end
	            // $this->load->view("merchant/customer_recurring", $data);

            } else {
            	// echo 2;die;
            	return ERROR;
            	
            }
        }
    }

    public function accept() {
        $merchant_id = $this->session->userdata('merchant_id');
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        //print_r($getEmail_a);
        //  echo 'Id:'.$getEmail_a[0][id];
        //  echo 'TOken:'.$getEmail_a[0][account_token_cnp];
        //  echo 'Mobile :'.$getEmail_a[0][mob_no];
        //  echo 'Email:'.$getEmail_a[0][email];die;
        //$msg="Transactionid:";
        $data['meta'] = "Add New Pos";
        $data['loc'] = "add_pos";
        $data['action'] = "Charge";
        $merchant_id = $this->session->userdata('merchant_id');
        //echo $merchant_id;
        // if($merchant_id==413){
        // print_r(($_POST)); die();
        // }
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        //print_r($getEmail_a); die();
        //$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
        $security_key = 'fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
        $processor_id = trim($getEmail_a[0]['processor_id']);
        $this->form_validation->set_rules('card_no', 'card_no', 'required');
        //$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
        //$email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
        $amount = '0.2';
        //$tax = $this->input->post('totaltax') ? $this->input->post('totaltax') : "";
        //$other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
        //$other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
        $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
        $name = $this->input->post('name_card') ? $this->input->post('name_card') : "";
        $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
        $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
        $exp = $this->input->post('exp');
        $expiry_month = substr($exp, 0, 2);
        $expiry_year = substr($exp, 3, 5);
        $transaction_id = $trans_a_no;
        //echo $name;
        $ip = $response['ipaddress'];
        if (!empty($security_key) and !empty($processor_id)) {
            $ccnumber = $card_no;
            $amount = $amount;
            $ccexp = $expiry_month . $expiry_year;
            $cvv = $cvv;
            $authorizationcode = "";
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $orderid = $payment_id;
            $query = "";
            // Login Information
            $query.= "security_key=" . urlencode($security_key) . "&";
            $query.= "customer_vault=" . urlencode('add_customer') . "&";
            // Sales Information
            $query.= "ccnumber=" . urlencode($ccnumber) . "&";
            $query.= "ccexp=" . urlencode($ccexp) . "&";
            $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
            $query.= "cvv=" . urlencode($cvv) . "&";
            $query.= "zip=" . urlencode($zip) . "&";
            $query.= "processor_id=" . urlencode($processor_id) . "&";
            $query.= "authorizationcode=" . urlencode($authorizationcode) . "&";
            $query.= "ipaddress=" . urlencode($ipaddress) . "&";
            $query.= "orderid=" . urlencode($orderid) . "&";
            $query.= "type=sale" . "&";
            //print_r($query);die;
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
                echo 'er';
                return ERROR;
            }
            curl_close($ch);
            unset($ch);
            parse_str($data, $parsed);
            $test = json_encode($parsed);
            $response = json_decode($test, true);
            print_r($response);
            die;
            //$msg=$msg.$response['transactionid']." customer_vault_id:".$response['customer_vault_id']." Amount Deducted: ".$response['amount'];
            ///refund
            $transaction_id = $response['transactionid']; //$_POST['transaction_id'];
            $TicketNumber = (rand(100000, 999999));
            $TicketNumber1 = (rand(100000000, 999999999));
            $TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
            // xml post structure
            $amount = $amount;
            $query = "";
            // Login Information
            $query.= "security_key=" . urlencode($security_key) . "&";
            // Sales Information
            $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
            $query.= "payment=creditcard" . "&";
            $query.= "transactionid=" . urlencode($transaction_id) . "&";
            $query.= "type=refund";
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
            // echo 'hi';
            parse_str($data, $parsed);
            $test = json_encode($parsed);
            $arraya = json_decode($test, true);
            //$json = json_encode($xml);
            //$arraya = json_decode($json, TRUE);
            //print_r($arraya);die;
            curl_close($ch);
            $msg = "Token Created Successfully";
            //print_r($msg);
            // echo base_url();die;
            //refund($response['transactionid']);
            $this->session->set_flashdata('success', $msg);
            redirect(base_url() . 'AcceptCard/');
            /*
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
            $sms_message = trim('Payment Receipt : '.$purl);
            
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
            */
        }
    }
}