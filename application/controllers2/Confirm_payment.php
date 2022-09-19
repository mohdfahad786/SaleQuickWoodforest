<?php if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Confirm_payment extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model'); 
			$this->load->model('admin_model');
			$this->load->model('Inventory_model');
			$this->load->model('Inventory_graph_model');
			$this->load->model('Home_model');
			$this->load->library('email');
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
			
		}

		public function dateTimeConvertTimeZone($Adate) {
			date_default_timezone_set("UTC");
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'America/Chicago';
					$datetime = new DateTime($Adate);
					$la_time = new DateTimeZone($time_Zone);
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
			
				
			} else {
				$convertedDateTime=$Adate;
			}
			return $convertedDateTime; 
		}


		public function all_pos() {
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		// echo "<pre>";print_r($merchant_data);die;
		if ($this->input->post('mysubmit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			if ($status == "Chargeback_Confirm") {
				$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
			} else {
				$package_data = $this->admin_model->get_search_merchant_pos_paid_list_wb($start_date, $end_date, $status, $merchant_id, 'pos','no');
				 if($status==''){ 
				      $refund_data = '';
			         }	
			}
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];			
			
		}


		else {
			$package_data = $this->admin_model->get_full_details_pos_wb('pos', $merchant_id,'no');
			//$refund_data = $this->admin_model->get_full_refund_data('pos', $merchant_id);
			$refund_data = '';
			$data['status'] = 'confirm';
			
		}
		
		
		$mem = array();
		$member = array();
		if (isset($package_data)) {
			foreach ($package_data as $each) {
				if ($each->receipt_type == null) // no-cepeipt
				{
					if ($each->mobile_no && $each->email_id) {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no != "" && $each->email_id == "") {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no == "" && $each->email_id != "") {
						$repeiptmethod = $each->email_id;
					} else {
						$repeiptmethod = 'no-receipt';
					}

				} else if ($each->receipt_type == 'no-cepeipt') {
					$repeiptmethod = 'no-receipt';
				} else {
					$repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
				}
				
				$TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
				    
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				$package['date'] =  $TransactiondateTime;  // $TransactiondateTime; 
				$package['status'] = $each->status;
				$package['card_no'] = $each->card_no;
				$package['card_type'] = $each->card_type;
				$package['transaction_type'] = $each->transaction_type;
				if ($each->transaction_type == "split") {
					$package['transaction_id'] = $each->invoice_no;
					$package['amount'] = $each->full_amount;
					$package['card_no'] = "";
					$package['card_type'] = "SPLIT";

				} else {
					$package['transaction_id'] = $each->transaction_id;
					$package['amount'] = $each->amount;
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
				}
				$mem[] = $package;

			}
		}
        
		if (isset($refund_data)) {
			 //print_r($refund_data);die;
			foreach ($refund_data as $each) {

				if ($each->status == 'Chargeback_Confirm') {
					if ($each->receipt_type == null) // no-cepeipt
					{
						if ($each->mobile_no && $each->email_id) {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no != "" && $each->email_id == "") {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no == "" && $each->email_id != "") {
							$repeiptmethod = $each->email_id;
						} else {
							$repeiptmethod = 'no-receipt';
						}

					} else if ($each->receipt_type == 'no-cepeipt') {
						$repeiptmethod = 'no-receipt';
					} else {
						$repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
					}
                   
					$newdate=$this->dateTimeConvertTimeZone($each->refund_dt);
					
					$package['id'] = $each->id;
					$package['refund_row_id'] = $each->refund_row_id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['c_type'] = $each->c_type;
					$package['transaction_id'] = $each->refund_transaction;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					$package['date'] =$newdate;
					$package['status'] = "Refund";
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
					$mem[] = $package; 
				}
			}
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);
		//echo '<pre>'; print_r($mem) ; die; 
		$data['mem'] = $mem;
		$data['merchant_data'] = $merchant_data;
		$this->load->view('merchant/all_pos_dash', $data);
	

	}



	}