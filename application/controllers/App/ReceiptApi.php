<?php 
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}
	class ReceiptApi extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->library('form_validation');
			$this->load->model('Home_model');
			$this->load->model('login_model');
			$this->load->model('Admin_model');
			$this->load->library('email');
			$this->load->library('twilio');
			date_default_timezone_set("America/Chicago");

			// ini_set('display_errors', 1);
		 //    error_reporting(E_ALL);
		 //    ini_set('max_execution_time', -1);
		}

	public function pos_reciept_json($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
		// $data['invoiceData'] = $invoiceData;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['discount'] = $sub->discount;
			$data["discounted_amount"] = $sub->total_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			$data['tip'] = ($sub->tip_amount !=0 || $sub->tip_amount !=0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no;
			$data["ip"] = $sub->ip;
			$data["c_type"]= $sub->c_type;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name;
			$data['business_dba_name'] = $sub->business_dba_name;
			$data['business_number'] = $sub->business_number;
			$data['address'] = $sub->address1;
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}

		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	public function pos_reciept_json_v3($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
// 		print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['discount'] = $sub->discount;
			$data["discounted_amount"] = $sub->total_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			$data['tip'] = ($sub->tip_amount !=0 || $sub->tip_amount !=0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no;
			$data["ip"] = $sub->ip;
			$data["c_type"]= $sub->c_type;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name;
			$data['business_dba_name'] = $sub->business_dba_name;
			$data['business_number'] = $sub->business_number;
			$data['address'] = $sub->address1;
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}

		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	public function pos_reciept_json_v3_2($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
// 		print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$transaction_type = $invoiceData[0]->transaction_type;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		$splited_bill = "";
		$totalAmu = 0;
		foreach ($invoiceData as $invoice) {
		    
		    	if( $invoice->reference_numb_opay!='0' && $invoice->reference_numb_opay!='' ){
					$card_no_reference = ($invoice->reference_numb_opay) ?  $invoice->reference_numb_opay : "N/A" ;
				}
				else
				{
				    	$card_no_reference = ($invoice->card_no) ? $invoice->card_no : "N/A";
				}
				
			if ($invoice->transaction_type == "split") {
				$splited_bill[] = array(
				    
					'amount' => $invoice->amount ? $invoice->amount : "",
					'c_type' => $invoice->c_type ? $invoice->c_type : "",
					'transaction_id' => $invoice->transaction_id ? $invoice->transaction_id : "",
					'split_payment_id' => $invoice->split_payment_id ? $invoice->split_payment_id : "",
					'card_type' => $invoice->card_type ? $invoice->card_type : "",
				//	'card_no' => ($invoice->card_type === "CASH") ? "" : $invoice->card_no,
						'card_no' => $card_no_reference,
					'date_c' => $invoice->date_c,
					'status' => ($invoice->status == 'Chargeback_Confirm') ? true : false,
					'sign' => !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "",
				);
				$totalAmu = $totalAmu + $invoice->amount;
				$sign = !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "";
			}

		}

		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id ? $sub->email_id : "";
			$data['name'] = $sub->name ? $sub->name : "";
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no ? $sub->invoice_no : "";
			
			if($sub->transaction_type== "split"){
			$data['reference_numb_opay'] = "n/a";
			}
			else
			{
				$data['reference_numb_opay'] = ($sub->reference_numb_opay) ? $sub->reference_numb_opay: "n/a";
			}
			
			$data['due_date'] = $sub->due_date ? $sub->due_date : "";
			$data['mobile'] = $sub->mobile_no ? $sub->mobile_no : "";
			$data['amount'] = ($totalAmu == 0) ? $sub->amount : $totalAmu;
			$data['discount'] = $sub->discount ? $sub->discount : "";
			$data["discounted_amount"] = $sub->total_amount ? $sub->total_amount : "";
			$data['transaction_id'] = $sub->transaction_id ? $sub->transaction_id : "";
			$data['card_type'] = $sub->card_type ? $sub->card_type : "";
			$data['tax'] = $sub->tax ? $sub->tax : "";
			$data['tip'] = ($sub->tip_amount != 0 || $sub->tip_amount != 0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['split_sign'] = $sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no ? $sub->card_no : "n/a";
			$data["ip"] = $sub->ip ? $sub->ip : "";
			$data["c_type"] = $sub->c_type ? $sub->c_type : "";
			$data["splitted_bill"] = $splited_bill;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name ? $sub->business_name : "";
			$data['business_dba_name'] = $sub->business_dba_name ? $sub->business_dba_name : "";
			$data['business_number'] = $sub->business_number ? $sub->business_number : "";
			$data['address'] = $sub->address1 ? $sub->address1 : "";
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}
		if ($transaction_type == "split") {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	
		public function pos_reciept_json_v3_3($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
// 		print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$transaction_type = $invoiceData[0]->transaction_type;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		
		$chargesInfo = $this->db->query("SELECT * from other_charges where merchant_id ='" . $bct_id2 . "'  ");
		$chargesData = $chargesInfo->result_object();
		
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		$splited_bill = "";
		$totalAmu = 0;
		foreach ($invoiceData as $invoice) {
		    
		    	if( $invoice->reference_numb_opay!='0' && $invoice->reference_numb_opay!='' ){
					$card_no_reference = ($invoice->reference_numb_opay) ?  $invoice->reference_numb_opay : "N/A" ;
				}
				else
				{
				    	$card_no_reference = ($invoice->card_no) ? $invoice->card_no : "N/A";
				}
				
			if ($invoice->transaction_type == "split") {
				$splited_bill[] = array(
				    
					'amount' => $invoice->amount ? $invoice->amount : "",
					'c_type' => $invoice->c_type ? $invoice->c_type : "",
					'transaction_id' => $invoice->transaction_id ? $invoice->transaction_id : "",
					'split_payment_id' => $invoice->split_payment_id ? $invoice->split_payment_id : "",
					'card_type' => $invoice->card_type ? $invoice->card_type : "",
				//	'card_no' => ($invoice->card_type === "CASH") ? "" : $invoice->card_no,
						'card_no' => $card_no_reference,
					'date_c' => $invoice->date_c,
					'status' => ($invoice->status == 'Chargeback_Confirm') ? true : false,
					'sign' => !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "",
				);
				$totalAmu = $totalAmu + $invoice->amount;
				$sign = !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "";
			}

		}

		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id ? $sub->email_id : "";
			$data['name'] = $sub->name ? $sub->name : "";
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no ? $sub->invoice_no : "";
			
			if($sub->transaction_type== "split"){
			$data['reference_numb_opay'] = "n/a";
			}
			else
			{
				$data['reference_numb_opay'] = ($sub->reference_numb_opay) ? $sub->reference_numb_opay: "n/a";
			}
			
			$data['due_date'] = $sub->due_date ? $sub->due_date : "";
				$data['other_charges'] = $sub->other_charges ? $sub->other_charges : "";
			$data['mobile'] = $sub->mobile_no ? $sub->mobile_no : "";
			$data['amount'] = ($totalAmu == 0) ? $sub->amount : $totalAmu;
			$data['discount'] = $sub->discount ? $sub->discount : "";
			$data["discounted_amount"] = $sub->total_amount ? $sub->total_amount : "";
			$data['transaction_id'] = $sub->transaction_id ? $sub->transaction_id : "";
			$data['card_type'] = $sub->card_type ? $sub->card_type : "";
			$data['tax'] = $sub->tax ? $sub->tax : "";
			$data['tip'] = ($sub->tip_amount != 0 || $sub->tip_amount != 0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['split_sign'] = $sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no ? $sub->card_no : "n/a";
			$data["ip"] = $sub->ip ? $sub->ip : "";
			$data["c_type"] = $sub->c_type ? $sub->c_type : "";
			$data["splitted_bill"] = $splited_bill;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name ? $sub->business_name : "";
			$data['business_dba_name'] = $sub->business_dba_name ? $sub->business_dba_name : "";
			$data['business_number'] = $sub->business_number ? $sub->business_number : "";
			$data['address'] = $sub->address1 ? $sub->address1 : "";
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}
		foreach ($chargesData as $subcharges) {
			$data['otherChargeTitle'] = ($subcharges->title) ? $subcharges->title : "";
			
			break;

		}
		
		if ($transaction_type == "split") {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	
	public function pos_reciept_json_v3_4($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
		//print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$transaction_type = $invoiceData[0]->transaction_type;

		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		
		$chargesInfo = $this->db->query("SELECT * from other_charges where merchant_id ='" . $bct_id2 . "'  ");
		$chargesData = $chargesInfo->result_object();
		
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		$splited_bill = array();
		$totalAmu = 0;

		$data['sub_merchant_id'] = $invoiceData[0]->sub_merchant_id  ? $invoiceData[0]->sub_merchant_id : "0";
			

           if($invoiceData[0]->sub_merchant_id!=''){

			$merchantInfo_s = $this->db->query("SELECT emp_refund from merchant where id ='" . $invoiceData[0]->sub_merchant_id . "'  ");
		$merchantData_s = $merchantInfo_s->result_object();

		//print_r($merchantData_s);die;

$data['emp_refund'] = $merchantData_s[0]->emp_refund ? $merchantData_s[0]->emp_refund : "0";

		    }else
		    {
		    	$data['emp_refund'] = $merchantData[0]->emp_refund ? $merchantData[0]->emp_refund : "0";
		    }

		//print_r($transaction_type);die;
		foreach ($invoiceData as $invoice) {
		    
		    	if( $invoice->reference_numb_opay!='0' && $invoice->reference_numb_opay!='' ){
					$card_no_reference = ($invoice->reference_numb_opay) ?  $invoice->reference_numb_opay : "N/A" ;
				}
				else if( $invoice->c_type=='BBPOS' ){
					$card_no_bbpos=substr_replace($invoice->card_no,"******",0,6);
					$card_no_reference = $card_no_bbpos ? $card_no_bbpos : "N/A";
				}
				else
				{
				    	$card_no_reference = ($invoice->card_no) ? $invoice->card_no : "N/A";
				}

				if( $invoice->c_type=='BBPOS' ){
			$time_c_bbpos=substr_replace($invoice->transactionDateTime,"",0,11);
			$date_c_bbpos=substr_replace($invoice->transactionDateTime,"",10);
					$date_c = $date_c_bbpos;
					$time_c = $time_c_bbpos;

					$applicationId = ($invoice->applicationId) ? $invoice->applicationId : "N/A";
					$cryptogram = ($invoice->cryptogram) ? $invoice->cryptogram : "N/A";
					$applicationLabel = ($invoice->applicationLabel) ? $invoice->applicationLabel : "N/A";
					$applicationPreferredName = ($invoice->applicationPreferredName) ? $invoice->applicationPreferredName : "N/A";

					$hostResponseCode = ($invoice->hostResponseCode) ? $invoice->hostResponseCode : "N/A";
					$expressResponseCode = ($invoice->expressResponseCode) ? $invoice->expressResponseCode : "N/A";
					$expressResponseMessage = ($invoice->expressResponseMessage) ? $invoice->expressResponseMessage : "N/A"; 
					
				}
				else
				{
					$date_c = $invoice->date_c;
					$time_c = "N/A";
					$applicationId = "N/A";
					$cryptogram = "N/A";
					$applicationLabel = "N/A";
					$applicationPreferredName = "N/A";

					$hostResponseCode = "N/A";
					$expressResponseCode = "N/A";
					$expressResponseMessage = "N/A"; 
				}
				
			if ($invoice->transaction_type == "split") {
				$splited_bill[] = array(
			'amount' => $invoice->amount ? $invoice->amount : "",
			'c_type' => $invoice->c_type ? $invoice->c_type : "",
			'transaction_id' => $invoice->transaction_id ? $invoice->transaction_id : "",
			'split_payment_id' => $invoice->split_payment_id ? $invoice->split_payment_id : "",
			'card_type' => $invoice->card_type ? $invoice->card_type : "",
		    //'card_no' => ($invoice->card_type === "CASH") ? "" : $invoice->card_no,
			'card_no' => $card_no_reference,
			'date_c' => $date_c,
			'time_c' => $time_c,
			'applicationId' => $applicationId,
			'cryptogram' => $cryptogram,
			'applicationLabel' => $applicationLabel,
			'applicationPreferredName' => $applicationPreferredName,
			'hostResponseCode' => $hostResponseCode,
			'expressResponseCode' => $expressResponseCode,
			'expressResponseMessage' => $expressResponseMessage,
			'status' => ($invoice->status == 'Chargeback_Confirm') ? true : false,
			'sign' => !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "",
				);
			$totalAmu = $totalAmu + $invoice->amount;
			$sign = !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "";
			}

		}

		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id ? $sub->email_id : "";
			$data['name'] = $sub->name ? $sub->name : "";
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no ? $sub->invoice_no : "";
			
			if($sub->transaction_type== "split"){
			$data['reference_numb_opay'] = "n/a";
			}
			else
			{
				$data['reference_numb_opay'] = ($sub->reference_numb_opay) ? $sub->reference_numb_opay: "n/a";
			}
			
			$data['due_date'] = $sub->due_date ? $sub->due_date : "";
				$data['other_charges'] = $sub->other_charges ? $sub->other_charges : "";
			$data['mobile'] = $sub->mobile_no ? $sub->mobile_no : "";
			$data['amount'] = ($totalAmu == 0) ? $sub->amount : $totalAmu;
			$data['discount'] = $sub->discount ? $sub->discount : "";
			$data["discounted_amount"] = $sub->total_amount ? $sub->total_amount : "";
			$data['transaction_id'] = $sub->transaction_id ? $sub->transaction_id : "";
			$data['card_type'] = $sub->card_type ? $sub->card_type : "";
			$data['auth_code'] = $sub->auth_code ? $sub->auth_code : "";
			$data['tax'] = $sub->tax ? $sub->tax : "";
			$data['tip'] = ($sub->tip_amount != 0 || $sub->tip_amount != 0.00) ? $sub->tip_amount : "n/a";
			if($sub->sign!=''){
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
		    }
		    else
		    {
		    	$data['sign'] = "";

		    }

		     $merchantInfo_ss = $this->db->query("SELECT pax_json from pax_json where pos_id ='" . $sub->id . "' and merchant_id ='" . $bct_id2. "' and type='pos'  ");
		$merchantData_ss = $merchantInfo_ss->result_object();



		    if($merchantData_ss[0]->pax_json!=''){
			$data['pax_json'] = $merchantData_ss[0]->pax_json;
		    }

		    else if($sub->pax_json!=''){
			$data['pax_json'] = $sub->pax_json;
		    }
		     if($sub->pax_refund_status!=''){
			$data['pax_refund_status'] = $sub->pax_refund_status;
		    }
		    if($sub->pos_entry_mode!=''){
			$data['entryMode'] = $sub->pos_entry_mode  ? $sub->pos_entry_mode : "";
		    }
		    if($sub->approval_number!=''){
			$data['approvalNumber'] = $sub->approval_number  ? $sub->approval_number : "";
		    }

		    
		    
			$data['split_sign'] = $sign ? $sign :"" ;
			if( $sub->c_type=='BBPOS' ){
				$time_c_bbpos=substr_replace($sub->transactionDateTime,"",0,11);
				$date_c_bbpos=substr_replace($sub->transactionDateTime,"",10);
					$data['date_c'] = $date_c_bbpos;
					$data['time_c'] = $time_c_bbpos;

			$data['applicationId'] = ($sub->applicationId) ? $sub->applicationId : "N/A";
				$data['cryptogram'] = ($sub->cryptogram) ? $sub->cryptogram : "N/A";
				$data['applicationLabel'] = ($sub->applicationLabel) ? $sub->applicationLabel : "N/A";
				$data['applicationPreferredName'] = ($sub->applicationPreferredName) ? $sub->applicationPreferredName : "N/A";

				$data['hostResponseCode'] = ($sub->hostResponseCode) ? $sub->hostResponseCode : "N/A";
				$data['expressResponseCode'] = ($sub->expressResponseCode) ? $sub->expressResponseCode : "N/A";
				$data['expressResponseMessage'] = ($sub->expressResponseMessage) ? $sub->expressResponseMessage : "N/A";
				
				}
				else
				{
             $data['date_c'] = $sub->date_c;
				}

			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			if( $sub->c_type=='BBPOS' ){
					$card_no_bbpos=substr_replace($sub->card_no,"******",0,6);
					$data['card_no'] = $card_no_bbpos ? $card_no_bbpos : "n/a";
				}
				else
				{
               $data['card_no'] = $sub->card_no ? $sub->card_no : "n/a";
				}
			$data["ip"] = $sub->ip ? $sub->ip : "";
			$data["c_type"] = $sub->c_type ? $sub->c_type : "";
			$data["splitted_bill"] = $splited_bill;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name ? $sub->business_name : "";
			$data['business_dba_name'] = $sub->business_dba_name ? $sub->business_dba_name : "";
			$data['business_number'] = $sub->business_number ? $sub->business_number : "";
			$data['address'] = $sub->address1 ? $sub->address1 : "";
			$data['CNP_WP_Payroc'] = $sub->payroc ? $sub->payroc : "0";
			$data['emp_refund'] = $sub->emp_refund ? $sub->emp_refund : "0";
			if($sub->logo!=''){
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
		    }else
		    {
		    	$data['logo'] = "";
		    }
			break;

		}
		foreach ($chargesData as $subcharges) {
			$data['otherChargeTitle'] = ($subcharges->title) ? $subcharges->title : "";
			
			break;

		}
		
		if ($transaction_type == "split") {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
			
			$getQuery2 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join mis_adv_pos_item i on c.item_id=i.item_id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		
		    $getQuery2 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join mis_adv_pos_item i on c.item_id=i.item_id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}

		$advPos1 = $getQuery1->result_object();
		$advPos2 = $getQuery2->result_object();
		$advPos = array_merge($advPos1,$advPos2);
		
		//print_r($advPos1); die();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}

		public function pos_reciept_json_v3_5($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
		//print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$transaction_type = $invoiceData[0]->transaction_type;

		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		
		$chargesInfo = $this->db->query("SELECT * from other_charges where merchant_id ='" . $bct_id2 . "'  ");
		$chargesData = $chargesInfo->result_object();
		
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		$splited_bill = array();
		$totalAmu = 0;

		//print_r($invoiceData[0]->sub_merchant_id);die;

		$data['sub_merchant_id'] = $invoiceData[0]->sub_merchant_id  ? $invoiceData[0]->sub_merchant_id : "0";
			

           if($invoiceData[0]->sub_merchant_id!=''){

			$merchantInfo_s = $this->db->query("SELECT emp_refund from merchant where id ='" . $invoiceData[0]->sub_merchant_id . "'  ");
		$merchantData_s = $merchantInfo_s->result_object();

		//print_r($merchantData_s);die;

$data['emp_refund'] = $merchantData_s[0]->emp_refund ? $merchantData_s[0]->emp_refund : "0";

		    }else
		    {
		    	$data['emp_refund'] = $merchantData[0]->emp_refund ? $merchantData[0]->emp_refund : "0";
		    }



		foreach ($invoiceData as $invoice) {
		    
		    	if( $invoice->reference_numb_opay!='0' && $invoice->reference_numb_opay!='' ){
					$card_no_reference = ($invoice->reference_numb_opay) ?  $invoice->reference_numb_opay : "N/A" ;
				}
				else if( $invoice->c_type=='BBPOS' ){
					$card_no_bbpos=substr_replace($invoice->card_no,"******",0,6);
					$card_no_reference = $card_no_bbpos ? $card_no_bbpos : "N/A";
				}
				else
				{
				    	$card_no_reference = ($invoice->card_no) ? $invoice->card_no : "N/A";
				}

				if( $invoice->c_type=='BBPOS' ){
			$time_c_bbpos=substr_replace($invoice->transactionDateTime,"",0,11);
			$date_c_bbpos=substr_replace($invoice->transactionDateTime,"",10);
					$date_c = $date_c_bbpos;
					$time_c = $time_c_bbpos;

					$applicationId = ($invoice->applicationId) ? $invoice->applicationId : "N/A";
					$cryptogram = ($invoice->cryptogram) ? $invoice->cryptogram : "N/A";
					$applicationLabel = ($invoice->applicationLabel) ? $invoice->applicationLabel : "N/A";
					$applicationPreferredName = ($invoice->applicationPreferredName) ? $invoice->applicationPreferredName : "N/A";

					$hostResponseCode = ($invoice->hostResponseCode) ? $invoice->hostResponseCode : "N/A";
					$expressResponseCode = ($invoice->expressResponseCode) ? $invoice->expressResponseCode : "N/A";
					$expressResponseMessage = ($invoice->expressResponseMessage) ? $invoice->expressResponseMessage : "N/A"; 
					
				}
				else
				{
					$date_c = $invoice->date_c;
					$time_c = "N/A";
					$applicationId = "N/A";
					$cryptogram = "N/A";
					$applicationLabel = "N/A";
					$applicationPreferredName = "N/A";

					$hostResponseCode = "N/A";
					$expressResponseCode = "N/A";
					$expressResponseMessage = "N/A"; 
				}
				
			if ($invoice->transaction_type == "split") {
				$splited_bill[] = array(
			'amount' => $invoice->amount ? $invoice->amount : "",
			'c_type' => $invoice->c_type ? $invoice->c_type : "",
			'transaction_id' => $invoice->transaction_id ? $invoice->transaction_id : "",
			'split_payment_id' => $invoice->split_payment_id ? $invoice->split_payment_id : "",
			'card_type' => $invoice->card_type ? $invoice->card_type : "",
		    //'card_no' => ($invoice->card_type === "CASH") ? "" : $invoice->card_no,
			'card_no' => $card_no_reference,
			'date_c' => $date_c,
			'time_c' => $time_c,
			'applicationId' => $applicationId,
			'cryptogram' => $cryptogram,
			'applicationLabel' => $applicationLabel,
			'applicationPreferredName' => $applicationPreferredName,
			'hostResponseCode' => $hostResponseCode,
			'expressResponseCode' => $expressResponseCode,
			'expressResponseMessage' => $expressResponseMessage,
			'status' => ($invoice->status == 'Chargeback_Confirm') ? true : false,
			'sign' => !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "",
				);
			$totalAmu = $totalAmu + $invoice->amount;
			$sign = !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "";
			}

		}

		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id ? $sub->email_id : "";
			$data['name'] = $sub->name ? $sub->name : "";
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no ? $sub->invoice_no : "";
			
			if($sub->transaction_type== "split"){
			$data['reference_numb_opay'] = "n/a";
			}
			else
			{
				$data['reference_numb_opay'] = ($sub->reference_numb_opay) ? $sub->reference_numb_opay: "n/a";
			}
			
			$data['due_date'] = $sub->due_date ? $sub->due_date : "";
				$data['other_charges'] = $sub->other_charges ? $sub->other_charges : "";
			$data['mobile'] = $sub->mobile_no ? $sub->mobile_no : "";
			$data['amount'] = ($totalAmu == 0) ? $sub->amount : $totalAmu;
			$data['discount'] = $sub->discount ? $sub->discount : "";
			$data["discounted_amount"] = $sub->total_amount ? $sub->total_amount : "";
			$data['transaction_id'] = $sub->transaction_id ? $sub->transaction_id : "";
			$data['card_type'] = $sub->card_type ? $sub->card_type : "";
			$data['tax'] = $sub->tax ? $sub->tax : "";
			$data['tip'] = ($sub->tip_amount != 0 || $sub->tip_amount != 0.00) ? $sub->tip_amount : "n/a";
			if($sub->sign!=''){
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
		    }
		    else
		    {
		    	$data['sign'] = "";

		    }
		    if($sub->pax_json!=''){
			$data['pax_json'] = $sub->pax_json;
		    }
		    if($sub->pos_entry_mode!=''){
			$data['entryMode'] = $sub->pos_entry_mode  ? $sub->pos_entry_mode : "";
		    }
		    if($sub->approval_number!=''){
			$data['approvalNumber'] = $sub->approval_number  ? $sub->approval_number : "";
		    }

		    
		    
			$data['split_sign'] = $sign ? $sign :"" ;
			if( $sub->c_type=='BBPOS' ){
				$time_c_bbpos=substr_replace($sub->transactionDateTime,"",0,11);
				$date_c_bbpos=substr_replace($sub->transactionDateTime,"",10);
					$data['date_c'] = $date_c_bbpos;
					$data['time_c'] = $time_c_bbpos;

			$data['applicationId'] = ($sub->applicationId) ? $sub->applicationId : "N/A";
				$data['cryptogram'] = ($sub->cryptogram) ? $sub->cryptogram : "N/A";
				$data['applicationLabel'] = ($sub->applicationLabel) ? $sub->applicationLabel : "N/A";
				$data['applicationPreferredName'] = ($sub->applicationPreferredName) ? $sub->applicationPreferredName : "N/A";

				$data['hostResponseCode'] = ($sub->hostResponseCode) ? $sub->hostResponseCode : "N/A";
				$data['expressResponseCode'] = ($sub->expressResponseCode) ? $sub->expressResponseCode : "N/A";
				$data['expressResponseMessage'] = ($sub->expressResponseMessage) ? $sub->expressResponseMessage : "N/A";
				
				}
				else
				{
             $data['date_c'] = $sub->date_c;
				}

			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			if( $sub->c_type=='BBPOS' ){
					$card_no_bbpos=substr_replace($sub->card_no,"******",0,6);
					$data['card_no'] = $card_no_bbpos ? $card_no_bbpos : "n/a";
				}
				else
				{
               $data['card_no'] = $sub->card_no ? $sub->card_no : "n/a";
				}
			$data["ip"] = $sub->ip ? $sub->ip : "";
			$data["c_type"] = $sub->c_type ? $sub->c_type : "";
			$data["splitted_bill"] = $splited_bill;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name ? $sub->business_name : "";
			$data['business_dba_name'] = $sub->business_dba_name ? $sub->business_dba_name : "";
			$data['business_number'] = $sub->business_number ? $sub->business_number : "";
			$data['address'] = $sub->address1 ? $sub->address1 : "";
			$data['CNP_WP_Payroc'] = $sub->payroc ? $sub->payroc : "0";


			if($sub->logo!=''){
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
		    }else
		    {
		    	$data['logo'] = "";
		    }
			break;

		}
		foreach ($chargesData as $subcharges) {
			$data['otherChargeTitle'] = ($subcharges->title) ? $subcharges->title : "";
			
			break;

		}
		
		if ($transaction_type == "split") {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
			
			$getQuery2 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join mis_adv_pos_item i on c.item_id=i.item_id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		
		    $getQuery2 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join mis_adv_pos_item i on c.item_id=i.item_id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}

		$advPos1 = $getQuery1->result_object();
		$advPos2 = $getQuery2->result_object();
		$advPos = array_merge($advPos1,$advPos2);
		
		//print_r($advPos1); die();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	
		public function pos_reciept_json_v3_2_3($invoice, $id,$token) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
// 		print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$transaction_type = $invoiceData[0]->transaction_type;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		$splited_bill = "";
		$totalAmu = 0;
		foreach ($invoiceData as $invoice) {
		    
		    	if( $invoice->reference_numb_opay!='0' && $invoice->reference_numb_opay!='' ){
					$card_no_reference = ($invoice->reference_numb_opay) ?  $invoice->reference_numb_opay : "N/A" ;
				}
				else
				{
				    	$card_no_reference = ($invoice->card_no) ? $invoice->card_no : "N/A";
				}
				
			if ($invoice->transaction_type == "split") {
				$splited_bill[] = array(
				    
					'amount' => $invoice->amount ? $invoice->amount : "",
					'c_type' => $invoice->c_type ? $invoice->c_type : "",
					'transaction_id' => $invoice->transaction_id ? $invoice->transaction_id : "",
					'split_payment_id' => $invoice->split_payment_id ? $invoice->split_payment_id : "",
					'card_type' => $invoice->card_type ? $invoice->card_type : "",
				//	'card_no' => ($invoice->card_type === "CASH") ? "" : $invoice->card_no,
						'card_no' => $card_no_reference,
					'date_c' => $invoice->date_c,
					'status' => ($invoice->status == 'Chargeback_Confirm') ? true : false,
					'sign' => !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "",
				);
				$totalAmu = $totalAmu + $invoice->amount;
				$sign = !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "";
			}

		}

		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id ? $sub->email_id : "";
			$data['name'] = $sub->name ? $sub->name : "";
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no ? $sub->invoice_no : "";
			
			if($sub->transaction_type== "split"){
			$data['reference_numb_opay'] = "n/a";
			}
			else
			{
				$data['reference_numb_opay'] = ($sub->reference_numb_opay) ? $sub->reference_numb_opay: "n/a";
			}
			
			$data['due_date'] = $sub->due_date ? $sub->due_date : "";
			$data['mobile'] = $sub->mobile_no ? $sub->mobile_no : "";
			$data['amount'] = ($totalAmu == 0) ? $sub->amount : $totalAmu;
			$data['discount'] = $sub->discount ? $sub->discount : "";
			$data["discounted_amount"] = $sub->total_amount ? $sub->total_amount : "";
			$data['transaction_id'] = $sub->transaction_id ? $sub->transaction_id : "";
			$data['card_type'] = $sub->card_type ? $sub->card_type : "";
			$data['tax'] = $sub->tax ? $sub->tax : "";
			$data['tip'] = ($sub->tip_amount != 0 || $sub->tip_amount != 0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['split_sign'] = $sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no ? $sub->card_no : "n/a";
			$data["ip"] = $sub->ip ? $sub->ip : "";
			$data["c_type"] = $sub->c_type ? $sub->c_type : "";
			$data["splitted_bill"] = $splited_bill;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name ? $sub->business_name : "";
			$data['business_dba_name'] = $sub->business_dba_name ? $sub->business_dba_name : "";
			$data['business_number'] = $sub->business_number ? $sub->business_number : "";
			$data['address'] = $sub->address1 ? $sub->address1 : "";
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}
		if ($transaction_type == "split") {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	public function adv_pos_reciept_copy() {
		$bct_id2 = $this->uri->segment(3);

		$bct_id1 = $this->uri->segment(2);

		$today2 = date("Y-m-d H:i:s");

		$branch = $this->Home_model->get_payment_details_1_pos($bct_id1);

		$data['$branch'] = $branch;

		$getQuery = $this->db->query("SELECT * from pos where merchant_id ='" . $bct_id2 . "' and invoice_no  ='" . $bct_id1 . "' ");

		$getEmail = $getQuery->result_array();

		$data['getEmail'] = $getEmail;

		$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");

		$getEmail1 = $getQuery1->result_array();

		$data['getEmail1'] = $getEmail1;

		$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

		$data['itemm'] = $itemm;

		$data['logo'] = "logo";

		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");

		$advPos = $getQuery1->result_array();

		$data['advPos'] = $advPos;

		foreach ($branch as $sub) {

			$data['email'] = $sub->email_id;

			$data['name'] = $sub->name;

			// $data['message'] = $sub->message;

			$data['invoice_no'] = $sub->invoice_no;

			$data['due_date'] = $sub->due_date;

			$data['mobile'] = $sub->mobile_no;

			$data['amount'] = $sub->amount;

			$data['transaction_id'] = $sub->transaction_id;

			$data['card_type'] = $sub->card_type;

			$data['tax'] = $sub->tax;

			// $data['detail'] = $sub->detail;

			//  $data['status'] = $sub->status;

			$data['bct_id1'] = $bct_id1;

			$data['bct_id2'] = $bct_id2;

			$data['sign'] = $sub->sign;

			$data['date_c'] = $sub->date_c;

			$data['reference'] = $sub->reference;

			$data['card_no'] = $sub->card_no;

			break;

		}

		$this->load->view('pos_reciept', $data);

	}


}
