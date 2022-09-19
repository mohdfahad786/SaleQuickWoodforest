<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','4048M');
if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

class Report_limit extends CI_Controller {
	public function __construct() {
		// print_r("expression1");die;
		parent::__construct();
		$this->load->model('Inventory_model');
		$this->load->model('Inventory_graph_model');
		$this->load->model('Inventory_graph_model_new');
		$this->load->model('Inventory_graph_model_report');
		$this->load->helper('pdf_helper');
		$this->load->model('profile_model');
		$this->load->model('Email_report_model');
		$this->load->model('admin_model');
		$this->load->model('home_model');
		$this->load->library('email');
		$this->load->library('twilio');

		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);
		
		ignore_user_abort(1);
		
	}

	
	public function dateTimeConvertTimeZone2($Adate) {
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
				date_default_timezone_set('America/Chicago');
				if($time_Zone!='America/Chicago'){
					$datetime = new DateTime($Adate);
					$la_time = new DateTimeZone($time_Zone);
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				} else {
					$convertedDateTime=$Adate;
				}
				
				
			} else {
				$convertedDateTime=$Adate;
			}
			return $convertedDateTime; 
		}
		
		 public function dateTimeConvertTimeZone($Adate,$timezone) {

		 	date_default_timezone_set("UTC");
        if($timezone!=''){
            $time_Zone=$timezone;
        }
        else
        {
         $time_Zone='America/Chicago';   
        }
                    $datetime = new DateTime($Adate);
                    $la_time = new DateTimeZone($time_Zone);
                    $datetime->setTimezone($la_time);
                    $convertedDateTime=$datetime->format('Y-m-d H:i:s');

     
            return $convertedDateTime; 
        }
		
		
	
	

	public function email_report() {
		$data = array();

		 $start= $this->uri->segment(3);
         $limit = $this->uri->segment(4);

		$get_merchant_data = $this->Email_report_model->get_merchant_data_new_limit($start,$limit);
// echo "<pre>";print_r($get_merchant_data);


		if (!empty($get_merchant_data)) { 
			foreach ($get_merchant_data as $key => $value) {
				$merchant_id = $value->id;
				$report_email =$value->report_email;
				$email = $value->email;
                $last_date = date("Y-m-d", strtotime("-1 days"));
			    $date = date("Y-m-d", strtotime("-1 days"));

					$getQuery1 = $this->db->query("SELECT count(id) as id from daily_report_email where merchant_id ='" . $merchant_id . "' and date ='" . $last_date . "'  ");
						$getEmail1 = $getQuery1->result_array();
					
						 $id =$getEmail1[0]['id'];
         if ($id<1) { 

					$package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
					$mem = array();
					$member = array();
					$sum = 0;
					$sum_ref = 0;
					if (!empty($package_data)) {
						foreach ($package_data as $key => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package['Amount'] = '-$' . $each->amount;
								$sum_ref += $each->amount;
							} else {
								$package['Amount'] = '$' . $each->amount;
								
							}$sum += $each->amount;
							$package['Tax'] = $each->tax;
							$package['Card'] = Ucfirst($each->card_type);
							if ($each->type = 'straight') {
								$package['Type'] = 'INV';
							} else {
								$package['Type'] = $each->type;
							}
							$package['Date'] = $each->date_c;
							$package['Referece'] = $each->reference;
							$mem[] = $package;
						}
						$data['item'] = $mem;
						$invoice_count = $key + 1;
						// echo "<br>";
					} else {
						$invoice_count = 0;
					}

					$sum1 = 0;
					$sum_ref1 = 0;
					$recurring_payment_count = 0;

					$package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
					// echo "<pre>";print_r($package_data2);
					$mem2 = array();
					$member2 = array();
					$sum2 = 0;
					$sum_ref2 = 0;
					if (!empty($package_data2)) {
						foreach ($package_data2 as $key2 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package2['Amount'] = '-$' . $each->amount;
								$sum_ref2 += $each->amount;
							} else {
								$package2['Amount'] = '$' . $each->amount;
								
							}$sum2 += $each->amount;
							$package2['Tax'] = '$' . $each->tax;
							$package2['Card'] = Ucfirst($each->card_type);
							$package2['Type'] = strtoupper($each->type);
							$package2['Date'] = $each->date_c;
							$package2['Referece'] = $each->reference;
							$mem2[] = $package2;
						}
						$data['item2'] = $mem2;
						$pos_count = $key2 + 1;
						// echo "<br>";
					} else {
						$pos_count = 0;
					}
                    ####################################
					$package_data3 = $this->Email_report_model->get_report_refund_data("pos", $date, $last_date, $merchant_id);
					$sum_ref3 = 0;
					if (!empty($package_data3)) {
						foreach ($package_data3 as $key2 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package2['Amount'] = '-$' . $each->refund_amount;
								$sum_ref3 = $sum_ref3+$each->refund_amount;
							} 
							
						}
					} 
					
					$package_dat5 = $this->Email_report_model->get_report_refund_data("customer_payment_request", $date, $last_date, $merchant_id);
					$sum_ref5 = 0;
					if (!empty($package_data5)) {
						foreach ($package_data5 as $key2 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package2['Amount'] = '-$' . $each->refund_amount;
								$sum_ref5 = $sum_ref5+$each->refund_amount;
							} 
							
						}
					} 

					
					$totalsum=($sum + $sum1 + $sum2);
					// $totalsumr=(float)($sum_ref + $sum_ref1 + $sum_ref2+$sum_ref3+$sum_ref5);
					$totalsumr=(float)($sum_ref3+$sum_ref5);
					$totalamount=$totalsum-$totalsumr; 
					$reporting_data['invoice_count'] = $invoice_count;
					$reporting_data['recurring_payment_count'] = $recurring_payment_count;
					$reporting_data['pos_count'] = $pos_count;
					$reporting_data['total_transaction'] = ($invoice_count + $recurring_payment_count + $pos_count);
					$reporting_data['totalsum'] = '$' . number_format($sum + $sum1 + $sum2, 2);
					$reporting_data['totalsumr'] = '$' . number_format($sum_ref3+$sum_ref5, 2);
					$reporting_data['totalamount'] = '$' . number_format($totalamount,2);
					$reporting_data['business_dba_name'] = $value->business_dba_name;
					$reporting_data['mob_no'] = $value->mob_no;
					 $reporting_data['email'] = $value->email;
					$reporting_data['logo'] = $value->logo;
					$reporting_data['address1'] = $value->address1;
					$reporting_data['report_type'] = "Daily";
					$reporting_data['report_email'] = $report_email;
					$reporting_data['totalsum_email'] = number_format($sum + $sum1 + $sum2, 2);
					$reporting_data['pdf_link'] = 'https://salequick.com/dailyreport/' . $last_date . '/' . $merchant_id;

					$msg = $this->load->view('email/reporting', $reporting_data, true);
					

						$branch_info1 = array(
						'merchant_id' => $merchant_id,
						'type' => '2',
						'date' => $last_date,
						'email' => $report_email,
						);

						$id111 = $this->admin_model->insert_data("daily_report_email_2", $branch_info1);
	

						if (!empty($report_email)) {  
						
						$this->email->from('info@salequick.com', 'SaleQuick');
						$this->email->to($report_email);
					    //$this->email->to('sq.dev007@gmail.com');
						$this->email->subject('Salequick Reporting');
						$this->email->message($msg);

						$getQuery_mail_count = $this->db->query("SELECT count(id) as id from daily_report_email where merchant_id ='" . $merchant_id . "' and date ='" . $last_date . "'  ");
						$getEmail_count = $getQuery_mail_count->result_array();
						 $id_count =$getEmail_count[0]['id'];
         if ($id_count<1) { 

         							$branch_info = array(
						'merchant_id' => $merchant_id,
						'type' => '2',
						'date' => $last_date,
						'email' => $report_email,
						);

						$id11 = $this->admin_model->insert_data("daily_report_email", $branch_info);

					 if(!empty($id11)){ 
						$this->email->send();
						//echo $id11;
						}
					


					}

					} 

                 }
				}
				
			
		} 

		exit();
	}





	



}
