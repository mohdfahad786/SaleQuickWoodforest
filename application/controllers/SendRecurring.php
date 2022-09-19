<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class SendRecurring extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model'); 
			$this->load->model('admin_model');
			$this->load->model('Inventory_model');
			$this->load->model('Inventory_graph_model');
			$this->load->model('acceptcard_model');						
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

		public function dateTimeConvertTimeZone2($Adate) {
			date_default_timezone_set("UTC");
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
				//date_default_timezone_set('America/Chicago');
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

		public function rerunCard($invoice_no,$row_Id)
		{

			$x=$this->acceptcard_model->amountDetails($invoice_no);
			$amount2=$x[0]['amount'];
			$late_fee=$x[0]['late_fee']; 
			// echo 1111;
			$token=$this->acceptcard_model->tokenDetails($invoice_no);
			// echo $token;die;
			if($token==0)
			{
				$this->session->set_flashdata('success',"Kindly add your card first");
				redirect(base_url('pos/all_customer_request_recurring')); 
			}
			$merchant_id = $this->session->userdata('merchant_id');
		
			$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
			$getEmail_a = $getQuery_a->result_array();
			//$data['$getEmail_a'] = $getEmail_a;
          //print_r($getEmail_a[0]['mob_no']); die();
		 //$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
		 	$security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
		 	$processor_id=trim($getEmail_a[0]['processor_id']);
		 
			$authorizationcode="";
			$ipaddress=$_SERVER['REMOTE_ADDR'];
		 	$mydata=array();
		 	$mydata['merchant_id'] =$merchant_id;
		 	$orderid=$invoice_no;
		 	$amount =$amount2;
		
		 
		 	if (!empty($security_key)  and !empty($processor_id)){
                          $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
                        $query .= "processor_id=" . urlencode($processor_id) . "&";
                        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
                        $query .= "ipaddress=" . urlencode($ipaddress) . "&";
                        $query .= "orderid=" . urlencode($orderid) . "&";
                        $query .= "customer_vault=update_customer". "&";
                        $query .= "customer_vault_id=". urlencode($token) . "&";
                    
                        $query .= "type=sale";
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

                        if (!($data3 = curl_exec($ch))) {
                        return ERROR;
                        }
                        curl_close($ch);
                        unset($ch);

                        parse_str($data3, $parsed);
                        $test = json_encode($parsed);
                        $response = json_decode($test, true);

                        //print_r($query);

                         //echo "<pre>"; print_r($response);
                       //echo "<br/>"; die();

                    }else
                    {
                    	 $message_complete = 'Error';
                    }
					 	
						// end payroc code

                 if($response['responsetext']=='Approved')
                    {
                    	// echo "<pre>"; print_r($response);die;
                        $message_a ='Payment successfull by token:'.$token;
                        $this->acceptcard_model->updateRecurringCount($row_Id,$invoice_no,$response);
                    	
                    }
                    else 
                    {
                    	// echo "<pre>"; print_r($response);die;
                        $message_a = $response['responsetext'];
                        $this->acceptcard_model->updateRecurringDeclined($row_Id,$invoice_no,$response);
                    }
                    
                    // if($response['response']==1)
                    // {
                    //     $message_complete = 'Approved';
                    //     $arrayy['Response']['ExpressResponseMessage'] = 'Approved';
                    // }
                    // else if($response['response']==2)
                    // {
                    //     $message_complete = 'Declined';
                    //     $arrayy['Response']['ExpressResponseMessage'] = 'Declined';
                    // }
                    // else if($response['response']==3)
                    // {
                    //     $message_complete = $response['responsetext'];
                    // }
                    // else 
                    // {
                    //     $message_complete = 'Error';
                    // }
                    $this->session->set_flashdata('success',$message_a);
                    redirect(base_url().'pos/all_customer_request_recurring/');
                    //$this->load->view('pos/invoice_details/',$invoice_no);	
	
				
		}
		public function updatecard($data)
		{
			$this->load->view('merchant/UpdateCard', $data);
			//$this->load->view('merchant/all_customer_request_dash', $data);
		}
		public function all_customer_request() {
			$data = array();
			$data["meta"] = "Transactions";
			$merchant_id = $this->session->userdata('merchant_id');
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
			if ($this->input->post('mysubmit')) {
				$employee = $this->session->userdata('merchant_id');
				$status = $_POST['status'];
				$date1 = $_POST['start_date'];
				$date2 = $_POST['end_date'];

				if ($status == "Chargeback_Confirm") {
					$refund_data = $this->admin_model->get_search_refund_data('customer_payment_request', $merchant_id, $date1, $date2, $status);
				} else {
					$package_data = $this->admin_model->get_full_details_admin_report_search('customer_payment_request', $date1, $date2, $employee, $status);
				}
				// $package_data = $this->admin_model->get_full_details_admin_report_search('customer_payment_request', $date1, $date2, $employee, $status);

				$data["start_date"] = $_POST['start_date'];
				$data["end_date"] = $_POST['end_date'];
				$data["status"] = $_POST['status'];
			} else {
				// $package_data = $this->admin_model->get_full_details_admin_a('customer_payment_request', $merchant_id);
				$package_data = $this->admin_model->get_full_details_admin_report_search('customer_payment_request', $date1, $date2, $merchant_id, 'confirm');
				// $refund_data = $this->admin_model->get_full_refund_data('customer_payment_request', $merchant_id);
				$refund_data = '';
				$data['status'] = 'confirm';
			}
			
			//print_r($package_data); die();
			$mem = array();
			$member = array();
			if (isset($package_data)) {
				foreach ($package_data as $each) {

					if ($each->mobile_no && $each->email_id) {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no != "" && $each->email_id == "") {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no == "" && $each->email_id != "") {
						$repeiptmethod = $each->email_id;
					} else {
						$repeiptmethod = 'no-receipt';
					}
					$each->add_date=$this->dateTimeConvertTimeZone($each->add_date);
					$new_add_date=$this->dateTimeConvertTimeZone($each->new_add_date);
					$each->due_date=$this->dateTimeConvertTimeZone($each->due_date);
					$payment_date=$this->dateTimeConvertTimeZone($each->payment_date);
					$each->date_c=$this->dateTimeConvertTimeZone($each->date_c);
					$package['id'] = $each->id;
					$package['refund_row_id'] = "";
					$package['name'] = $each->name;
					$package['merchant_id'] = $each->merchant_id;
					$package['email'] = $each->email_id;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['amount'] = $each->amount;
					$package['attachment'] = $each->attachment;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['status'] = $each->status;
					$package['payment_type'] = $each->payment_type;
					$package['due_date'] = $each->due_date;

					if(!empty($each->new_add_date))
					{
                      $package['payment_date'] = $new_add_date;
					}
					else
					{
						$package['payment_date'] = $payment_date;
					}

					
					$package['transaction_id'] = $each->transaction_id;
					$package['date_c'] = $each->date_c;
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
					$mem[] = $package;
				}
			}
			if (isset($refund_data)) {
				// echo "<pre>"; print_r($refund_data);die;
				foreach ($refund_data as $each) {
					if ($each->status == 'Chargeback_Confirm') {
					    if ($each->mobile_no && $each->email_id) {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no != "" && $each->email_id == "") {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no == "" && $each->email_id != "") {
							$repeiptmethod = $each->email_id;
						} else {
							$repeiptmethod = 'no-receipt';
						}
						$each->due_date=$this->dateTimeConvertTimeZone($each->due_date);
						$each->payment_date=$this->dateTimeConvertTimeZone($each->payment_date);
						$each->refund_dt=$this->dateTimeConvertTimeZone($each->refund_dt);
						$package['id'] = $each->id;
						$package['refund_row_id'] = $each->refund_row_id;
						$package['name'] = $each->name;
						$package['merchant_id'] = $each->merchant_id;
						$package['email'] = $each->email_id;
						$package['mobile'] = $each->mobile_no;
						$package['repeiptmethod'] = $repeiptmethod;
						// $package['amount'] = $each->amount;
						$package['amount'] = $each->refund_amount;
						$package['attachment'] = $each->attachment;
						$package['title'] = $each->title;
						$package['payment_type'] = $each->payment_type;
						$package['due_date'] = $each->due_date;
						$package['payment_date'] = $each->refund_dt;  //$each->payment_date;
						$package['payment_id'] = $each->invoice_no;
						$package['transaction_id'] = $each->refund_transaction;
						$package['date_c'] = $each->refund_dt; //$each->date_c;
						$package['date'] = $each->refund_dt;
						$package['status'] = "Refund";
						$package['card_no'] = $each->card_no;
						$package['card_type'] = $each->card_type;
						$mem[] = $package;
					}
				}
			}
			// array_multisort(array_column($mem, 'date_c'), SORT_DESC, $mem);
			$data['mem'] = $mem;
			$data['merchant_data'] = $merchant_data;
			// echo "<pre>";print_r($data);die;
			// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			// $this->session->unset_userdata('mymsg');
			$this->load->view('merchant/all_customer_request_dash', $data);
			// $this->load->view('merchant/all_customer_request', $data);
		}
		public function add_charge_back() {
			$bct_id = $this->uri->segment(3);

			if (!$bct_id && !$this->input->post('submit')) {
				echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
				die;
			}
			$branch = $this->admin_model->data_get_where('customer_payment_request', array('id' => $bct_id));
			if ($this->input->post('submit')) {
				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$payment_id = $this->input->post('payment_id') ? $this->input->post('payment_id') : "";
				$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";
				$merchant_id = $this->session->userdata('merchant_id');
				$date_c = date("Y-m-d");

				$branch_info = array(
					'name' => $name,
					'email' => $email,
					'mobile_no' => $mobile,
					'amount' => $amount,
					'payment_id' => $payment_id,
					'invoice_no' => $invoice,
					'reason' => $reason,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => 'straight',
					'status' => 'confirm',

				);
				$branch_inf = array(

					'status' => 'Chargeback_Confirm',

				);

				$id1 = $this->admin_model->insert_data("refund", $branch_info);
				$this->admin_model->update_data('customer_payment_request', $branch_inf, array('id' => $id));
				$this->admin_model->update_data('graph', $branch_inf, array('id' => $id));
				$this->session->set_userdata("mymsg", "Successfully Refund.");
				redirect(base_url() . 'pos2/all_charge_back');
			} else {
				foreach ($branch as $sub) {
					$data['bct_id'] = $sub->id;
					$data['invoice'] = $sub->invoice_no;
					$data['payment_id'] = $sub->payment_id;
					$data['amount'] = $sub->amount;
					$data['name'] = $sub->name;
					$data['email'] = $sub->email_id;
					$data['mob_no'] = $sub->mobile_no;

					break;
				}
			}
			$data['meta'] = "Add Charge Back";
			$data['action'] = "Add Charge Back";
			$data['loc'] = "add_charge_back";
			//     if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			// $this->load->view('employee/add_charge_back', $data);
			//     }
			// else
			// {
			$this->load->view('merchant/add_charge_back', $data);
			//}

		}
		public function add_charge_back_recuuring() {
			$merchant_id = $this->session->userdata('merchant_id');
			$bct_id = $this->uri->segment(3);

			if (!$bct_id && !$this->input->post('submit')) {
				echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
				die;
			}
			$branch = $this->admin_model->get_recurring_details_payment_rr($merchant_id, $bct_id);
			if ($this->input->post('submit')) {
				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$payment_id = $this->input->post('payment_id') ? $this->input->post('payment_id') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";
				$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
				$date_c = date("Y-m-d");

				$branch_info = array(
					'name' => $name,
					'email' => $email,
					'mobile_no' => $mobile,
					'payment_id' => $payment_id,
					'amount' => $amount,
					'invoice_no' => $invoice,
					'reason' => $reason,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => 'recurring',
					'status' => 'confirm',

				);

				$branch_inf = array(

					'status' => 'Chargeback_Confirm',

				);

				$id1 = $this->admin_model->insert_data("refund", $branch_info);
				$this->admin_model->update_data('recurring_payment', $branch_inf, array('id' => $id));
				$this->admin_model->update_data('graph', $branch_inf, array('id' => $id));
				$this->session->set_userdata("mymsg", "successfully charge Back Has Been Added.");
				redirect(base_url() . 'pos2/all_charge_back');
			} else {
				foreach ($branch as $sub) {
					$data['bct_id'] = $sub->rid;
					$data['invoice'] = $sub->invoice_no;
					$data['payment_id'] = $sub->payment_id;
					$data['amount'] = $sub->amount;
					$data['name'] = $sub->name;
					$data['email'] = $sub->email_id;
					$data['mob_no'] = $sub->mobile_no;

					break;
				}
			}
			$data['meta'] = "Add Charge Back";
			$data['action'] = "Add Charge Back";
			$data['loc'] = "add_charge_back_recuuring";
			//     if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			// $this->load->view('employee/add_charge_back', $data);
			//     }
			// else
			// {
			$this->load->view('merchant/add_charge_back', $data);
			//}

		}

		public function add_charge_back_pos() {
			//   $data['meta'] = "Add New Charge Back";
			// $data['loc'] = "add_charge_back";
			// $data['action'] = "Add New Charge Back";
			$merchant_id = $this->session->userdata('merchant_id');
			$bct_id = $this->uri->segment(3);

			if (!$bct_id && !$this->input->post('submit')) {
				echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
				die;
			}
			// $branch = $this->admin_model->get_recurring_details_payment_rr($merchant_id, $bct_id);
			$branch = $this->admin_model->data_get_where('pos', array('id' => $bct_id));
			if ($this->input->post('submit')) {
				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$payment_id = $this->input->post('payment_id') ? $this->input->post('payment_id') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";
				$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
				$date_c = date("Y-m-d");

				$branch_info = array(
					'name' => $name,
					'email' => $email,
					'mobile_no' => $mobile,
					'payment_id' => $payment_id,
					'amount' => $amount,
					'invoice_no' => $invoice,
					'reason' => $reason,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => 'pos',
					'status' => 'confirm',

				);

				$branch_inf = array(

					'status' => 'Chargeback_Confirm',

				);

				$id1 = $this->admin_model->insert_data("refund", $branch_info);
				$this->admin_model->update_data('pos', $branch_inf, array('id' => $id));
				$this->admin_model->update_data('graph', $branch_inf, array('id' => $id));
				$this->session->set_userdata("mymsg", "successfully charge Back Has Been Added.");
				redirect(base_url() . 'pos2/all_charge_back');
			} else {
				foreach ($branch as $sub) {
					$data['bct_id'] = $sub->id;
					$data['invoice'] = $sub->invoice_no;

					$data['amount'] = $sub->amount;
					$data['name'] = $sub->name;
					$data['email'] = $sub->email_id;
					$data['mob_no'] = $sub->mobile_no;

					break;
				}
			}
			$data['meta'] = "Add Charge Back";
			$data['action'] = "Add Charge Back";
			$data['loc'] = "add_charge_back_pos";
			//     if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			// $this->load->view('employee/add_charge_back', $data);
			//     }
			// else
			// {
			$this->load->view('merchant/add_charge_back', $data);
			// }

		}
		public function add_charge_back_r() {
			//   $data['meta'] = "Add New Charge Back";
			// $data['loc'] = "add_charge_back";
			// $data['action'] = "Add New Charge Back";
			$merchant_id = $this->session->userdata('merchant_id');

			$bct_id = $this->uri->segment(3);

			if (!$bct_id && !$this->input->post('submit')) {
				echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
				die;
			}
			$branch = $this->admin_model->get_recurring_details_payment_rr($merchant_id, $bct_id);
			if ($this->input->post('submit')) {
				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";

				$branch_info = array(
					'name' => $name,
					'email' => $email,
					'mobile_no' => $mobile,
					'payment_id' => $payment_id,
					'invoice_no' => $invoice,
					'reason' => $reason,

				);

				$id = $this->admin_model->insert_data("refund", $branch_info);
				$this->session->set_userdata("mymsg", "successfully charge Back Has Been Added.");
				redirect(base_url() . 'pos2/all_charge_back');
			} else {
				foreach ($branch as $sub) {
					$data['bct_id'] = $sub->rid;
					$data['invoice'] = $sub->invoice_no;
					$data['payment_id'] = $sub->payment_id;

					$data['name'] = $sub->name;
					$data['email'] = $sub->email_id;
					$data['mob_no'] = $sub->mobile_no;

					break;
				}
			}
			$data['meta'] = "Add Charge Back";
			$data['action'] = "Add Charge Back";
			$data['loc'] = "add_charge_back";

			//      if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			// $this->load->view('employee/add_charge_back', $data);
			//     }
			// else
			// {
			$this->load->view('merchant/add_charge_back', $data);
			// }

		}

		public function add_charge_back1() {
			$data['meta'] = "Add New Charge Back";
			$data['loc'] = "add_charge_back";
			$data['action'] = "Add New Charge Back";

			if (isset($_POST['submit'])) {
				$this->form_validation->set_rules('email', 'Email Address', 'required');
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";

				if ($this->form_validation->run() == FALSE) {
					$this->load->view("merchant/add_charge_back", $data);
				} else {
					$merchant_id = $this->session->userdata('merchant_id');
					$today1 = date("Ymdhms");
					$today2 = date("Y-m-d");

					$data = Array(

						'name' => $name,
						'email' => $email,
						'mobile_no' => $mobile,

						'invoice_no' => $invoice,
						'payment_id' => $invoice,
						'reason' => $reason,
						//  'user_type' => 'employee',
						'merchant_id' => $merchant_id,

						'status' => 'pending',
						// 'date_c' => $today2
					);

					$id = $this->admin_model->insert_data("refund", $data);

					redirect(base_url() . 'pos2/all_charge_back');

				}
			} else {
				$this->load->view("merchant/add_charge_back", $data);
			}

		}
		public function edit_charge_back() {

			$bct_id = $this->uri->segment(3);

			if (!$bct_id && !$this->input->post('submit')) {
				echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
				die;
			}
			$branch = $this->admin_model->data_get_where('refund', array('id' => $bct_id));
			if ($this->input->post('submit')) {
				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";

				$branch_info = array(
					'name' => $name,
					'email' => $email,
					'mobile_no' => $mobile,
					'payment_id' => $invoice,
					'reason' => $reason,

				);

				$this->admin_model->update_data('refund', $branch_info, array('id' => $bct_id));
				$this->session->set_userdata("mymsg", "Data Has Been Updated.");
				redirect('pos2/all_charge_back');
			} else {
				foreach ($branch as $sub) {
					$data['bct_id'] = $sub->id;
					$data['invoice'] = $sub->invoice_no;
					$data['payment_id'] = $sub->payment_id;

					$data['name'] = $sub->name;
					$data['email'] = $sub->email;
					$data['mob_no'] = $sub->mobile_no;
					$data['reason'] = $sub->reason;

					break;
				}
			}
			$data['meta'] = "Update Charge Back";
			$data['action'] = "Update Charge Back";
			$data['loc'] = "edit_charge_back";

			//      if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			// $this->load->view('employee/add_charge_back', $data);
			//     }
			// else
			// {
			$this->load->view('merchant/add_charge_back', $data);
			//}
		}
		public function edit_charge_back_admin() {

			$bct_id = $this->uri->segment(3);

			if (!$bct_id && !$this->input->post('submit')) {
				echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
				die;
			}
			$branch = $this->admin_model->data_get_where('refund', array('id' => $bct_id));
			if ($this->input->post('submit')) {
				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
				$email = $this->input->post('email') ? $this->input->post('email') : "";
				$name = $this->input->post('name') ? $this->input->post('name') : "";
				$mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
				$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
				$reason = $this->input->post('reason') ? $this->input->post('reason') : "";
				$detail = $this->input->post('detail') ? $this->input->post('detail') : "";
				$status = $this->input->post('status') ? $this->input->post('status') : "";

				$branch_info = array(

					'detail' => $detail,
					'status' => $status,

				);

				$this->admin_model->update_data('refund', $branch_info, array('id' => $id));
				$this->session->set_userdata("mymsg", "Data Has Been Updated.");
				redirect('pos2/all_charge_back');
			} else {
				foreach ($branch as $sub) {
					$data['bct_id'] = $sub->id;
					$data['invoice'] = $sub->invoice_no;
					$data['payment_id'] = $sub->payment_id;

					$data['name'] = $sub->name;
					$data['email'] = $sub->email;
					$data['mob_no'] = $sub->mobile_no;
					$data['reason'] = $sub->reason;
					$data['status'] = $sub->status;
					$data['detail'] = $sub->detail;

					break;
				}
			}
			$data['meta'] = "Update Charge Back status";
			$data['action'] = "Update Charge Back";
			$data['loc'] = "edit_charge_back_admin";

			$this->load->view('admin/add_charge_back', $data);
		}

		public function all_charge_back1() {

			$data = array();

			$merchant_id = $this->session->userdata('merchant_id');

			//$package_data = $this->admin_model->get_data('tax',$merchant_id);
			if ($this->session->userdata('user_type') == 'admin') {
				$package_data = $this->admin_model->data_get_where_2('refund');
			} else {
				$package_data = $this->admin_model->data_get_where_1('refund', array('merchant_id' => $merchant_id));
			}

			$mem = array();
			$member = array();
			foreach ($package_data as $each) {

				$mem[] = $each;
			}
			$data['mem'] = $mem;
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');

			//   if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			// $this->load->view('employee/all_charge_back', $data);
			//     }

			// else
			// {
			$this->load->view('merchant/all_charge_back', $data);
			//}
		}
		public function all_charge_back() {

			$data = array();
			$mem = array();
			$member = array();
			$merchant_id = $this->session->userdata('merchant_id');
			if ($this->input->post('mysubmit')) {

				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				$status = $_POST['status'];
				if ($status == 'straight') {
					$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'confirm', $merchant_id, 'refund');
					$data['meta'] = "View All Straight Refund Payment ";

				} else if ($status == 'recurring') {
					$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'confirm', $merchant_id, 'refund');
					$data['meta'] = "View All Recurring Refund Payment ";
				} else if ($status == 'pos') {
					$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'confirm', $merchant_id, 'refund');
					$data['meta'] = "View All Pos Refund Payment ";

				}
			} else {
				$data['meta'] = "View All  Refund Payment ";

				$package_data = $this->admin_model->get_full_details_payment_rr('refund', $merchant_id);

			}
			foreach ($package_data as $each) {

				$package['id'] = $each->id;
				$package['payment_id'] = $each->invoice_no;
				$package['name'] = $each->name;
				$package['email'] = $each->email;
				$package['mobile_no'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['reason'] = $each->reason;
				// $package['date'] = $each->add_date;
				// $package['due_date'] = $each->due_date;
				// $package['payment_date'] = $each->payment_date;
				$package['status'] = $each->status;
				$package['type'] = $each->type;
				//   $package['payment_type'] = $each->payment_type;
				//     $package['recurring_payment'] = $each->recurring_payment;

				$mem[] = $package;
			}

			$data['mem'] = $mem;
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');

			//   if($this->session->userdata('merchant_user_type')=='employee')
			//     {
			//    $this->load->view('employee/all_charge_back', $data);
			//     }
			// else
			// {

			$this->load->view('merchant/all_charge_back', $data);
			//}
		}

		public function charge_back_delete($id) {
			$this->admin_model->delete_by_id($id, 'refund');
			echo json_encode(array("status" => TRUE));
		}

		public function add_pos() {

			$merchant_id = $this->session->userdata('merchant_id');
			$data['meta'] = "Point Of Sale";
			$data['loc'] = "add_pos";
			$data['action'] = "Charge";
			$getDashboard = $this->db->query("SELECT ( SELECT sum(percentage) as TotalTax from tax where status='active' and merchant_id = '" . $merchant_id . "' ) as TotalTax");
			$getDashboardData = $getDashboard->result_array();
			$data['getDashboardData'] = $getDashboardData;

			$merchant_status = $this->session->userdata('merchant_status');
			$Activate_Details = $this->session->userdata('Activate_Details');
			if ($merchant_status == 'active') {
				// if (isset($_POST['submit'])) {
				// 	$this->form_validation->set_rules('amount', 'Amount', 'required');
				// 	$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
				// 	$tax = $this->input->post('totaltax') ? $this->input->post('totaltax') : "";

				// 	if ($this->form_validation->run() == FALSE) {
				// 		//  if($this->session->userdata('merchant_user_type')=='employee')
				// 		//     {
				// 		// $this->load->view('employee/pos', $data);
				// 		//     }
				// 		// else
				// 		// {
				// 		$data['meta'] = "Virtual Terminal";
				// 		$this->load->view('merchant/pos_dash', $data);
				// 		// $this->load->view('merchant/pos', $data);
				// 		//}
				// 	} else {

				// 		$today1 = date("Ymdhms");
				// 		$today2 = date("Y-m-d");

				// 		$data = Array(

				// 			'amount' => $amount,
				// 			'tax' => $tax,

				// 		);
				// 		$data['meta'] = "Card Payment";
				// 		$this->load->view("merchant/card1_dash", $data);
				// 		// $this->load->view("merchant/card1", $data);

				// 	}
				// } else {

				// 	//          if($this->session->userdata('merchant_user_type')=='employee')
				// 	//     {
				// 	// $this->load->view('employee/pos', $data);
				// 	//     }
				// 	// else
				// 	// {
				// 	$data['meta'] = "Virtual Terminal";
				// 	$this->load->view('merchant/pos_dash', $data);
				// 	// $this->load->view('merchant/pos', $data);
				// 	//}
				// }
				$data['meta'] = "Virtual Terminal";
				$this->load->view('merchant/pos_dash', $data);

			} elseif ($merchant_status == 'block') {
				$data['meta'] = "Your Account Is Block";
				$data['loc'] = "";
				$data['resend'] = "";
				$this->load->view("merchant/block", $data);
			} elseif ($merchant_status == 'confirm') {
				$data['meta'] = "Your Account Is Not Active";
				$data['loc'] = "";
				$data['resend'] = "";
				$this->load->view("merchant/block", $data);
			} elseif ($merchant_status == "Activate_Details") {
				$urlafterSign = 'https://salequick.com/merchant/after_signup';
				$data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
				$data['loc'] = "";
				$data['resend'] = "";
				$this->load->view("merchant/blockactive", $data);
			} elseif ($merchant_status == "Waiting_For_Approval") {
				$urlafterSign = 'https://salequick.com/merchant/after_signup';
				$data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
				$data['loc'] = "";
				$data['resend'] = "";
				$this->load->view("merchant/blockactive", $data);
			} else {
				$data['meta'] = "Your Email Is Not Confirm First Confirm Email";
				$data['loc'] = "resend";
				$data['resend'] = "resend";
				$this->load->view("merchant/block", $data);
			}

		}

		public function refund() {
			$refundfor = $_POST['refundfor'];  
		 	if($refundfor) {
				// echo "<pre>";print_r(($_POST)); die();
				$merchant_id = $this->session->userdata('merchant_id');
				//Data, connection, auth
				# $dataFromTheForm = $_POST['fieldName']; // request data from the form
				$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

				$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
				$getEmail_a = $getQuery_a->result_array();
				$data['$getEmail_a'] = $getEmail_a;
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
				$xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID>
		            <AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID>
		            </Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
		            <Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
		            <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
		            <TransactionID>" . $transaction_id . "</TransactionID><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $TicketNumber2 . "</ReferenceNumber><TicketNumber>" . $TicketNumber . "</TicketNumber>
		            </Transaction></CreditCardReturn>"; // data from the form, e.g. some ID number

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
				$arraya = json_decode($json, TRUE);
				
				curl_close($ch);

				// print_r($arraya);  die(); 

				$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
				$card_type = $arraya['Response']['Card']['CardLogo']? $arraya['Response']['Card']['CardLogo'] : '';
				$card_no = $arraya['Response']['Card']['CardNumberMasked'] ? $arraya['Response']['Card']['CardNumberMasked'] : '';
				//  die();
				$date_c = date("Y-m-d");
				$merchant_id = $this->session->userdata('merchant_id');

				$branch_info = array(
					// 'name' => $name,
					//'email' => $email,
					//'mobile_no' => $mobile,
					'amount' => $amount,
					'transaction_id' => $trans_a_no,
					'card_type' => $card_type,
					'card_no' => $card_no,
					'payment_id' => $payment_id,
					'invoice_no' => $invoice_no,
					//'reason' => $reason,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => $refundfor,
					'status' => 'confirm',
					'c_type' => 'CNP',
				);
				$branch_inf = array(
					'status' => 'Chargeback_Confirm',
				);
				// $id1 = $this->admin_model->insert_data("refund", $branch_info);
				// $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));
				if ($arraya['Response']['ExpressResponseMessage'] == 'Approved') {
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
						$this->email->send();
					}
		            $this->session->set_flashdata('msg', '<div class="text-success text-center"> Amount Refunded Successfully.. </div>');
		            if($refundfor=='straight') {
						redirect(base_url().'pos2/all_customer_request');
					} else {
						redirect(base_url() . 'pos2/invoice_details/'.$invoice_no);
					}
				} else {
					// $id = $arraya['Response']['ExpressResponseMessage'];
					// redirect('payment_error/' . $id);
					$id = $arraya['Response']['ExpressResponseMessage'];
					$this->session->set_flashdata('msg', '<div class="text-danger text-center"> '.$arraya['Response']['ExpressResponseMessage'].' </div>');
					if($refundfor=='straight') {
						redirect(base_url().'pos2/all_customer_request');
					} else if($refundfor=='recurring') {
	                    redirect(base_url('pos2/all_customer_request_recurring'));
					}
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="text-danger text-center">Refund :  Type of Invoice  id Required..</div>');
				redirect(base_url().'pos2/invoice_details/'.$invoice_no); 
				
		 	}
			// if(empty($trans_a_no)){
			//      $id='Refund Fail';
			//   redirect('payment_error/'.$id);
			//   }
			//   else
			//   {
			//   $id1 = $this->admin_model->insert_data("refund", $branch_info);
			//   $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));

			//   redirect(base_url().'pos2/all_customer_request');
			//   }
		}
		public function refund_pos_old() {
			//print_r(($_POST)); die();
			if(isset($_POST) &&  count($_POST) > 0 )
			{
			$merchant_id = $this->session->userdata('merchant_id');
			//Data, connection, auth
			# $dataFromTheForm = $_POST['fieldName']; // request data from the form
			$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

			$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
			$getEmail_a = $getQuery_a->result_array();
			$data['$getEmail_a'] = $getEmail_a;

			//print_r($getEmail_a);die;

			$account_id = $getEmail_a[0]['account_id_cnp'];
			$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			$account_token = $getEmail_a[0]['account_token_cnp'];
			$application_id = $getEmail_a[0]['application_id_cnp'];
			$terminal_id = $getEmail_a[0]['terminal_id'];

			$id = $_POST['id'];
			$invoice_no = $_POST['invoice_no'];
		   $amount =$_POST['amount'];
			//$amount =0.01;
		    $transaction_id = $_POST['transaction_id'];
			$TicketNumber = (rand(100000, 999999));
			$TicketNumber1 = (rand(100000000, 999999999));
			$TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
			// xml post structure
			$xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID>
	                  <AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID>
	                  </Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
	                  <Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
	                  <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
	                  <TransactionID>" . $transaction_id . "</TransactionID><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $TicketNumber2 . "</ReferenceNumber><TicketNumber>" . $TicketNumber . "</TicketNumber>
	                  </Transaction></CreditCardReturn>"; // data from the form, e.g. some ID number
		        //echo  $xml_post_string; die;  
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
				$arraya = json_decode($json, TRUE);
				//	print_r($arraya);
				curl_close($ch);
				$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
				//    $card_type = $arraya['Response']['Card']['CardLogo'];
				//   $card_no = $arraya['Response']['Card']['CardNumberMasked'];
				//  die();
				$date_c = date("Y-m-d");
				$merchant_id = $this->session->userdata('merchant_id');

				$branch_info = array(
					// 'name' => $name,
					//'email' => $email,
					// 'mobile_no' => $mobile,
					'amount' => $amount,
					'transaction_id' => $trans_a_no,
					//'card_type' => $card_type,
					//'card_no' => $card_no,
					//'payment_id' => $payment_id,
					'invoice_no' => $invoice_no,
					//  'reason' => $reason,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => 'pos',
					'status' => 'confirm',
					'c_type' => 'CNP',

				);
				$branch_inf = array(
					'status' => 'Chargeback_Confirm',
				);
				if ($arraya['Response']['ExpressResponseMessage'] == 'Approved') {
					$id1 = $this->admin_model->insert_data("refund", $branch_info);
					$this->admin_model->update_data('pos', $branch_inf, array('id' => $id));
					redirect(base_url() . 'refund/all_pos');
				} else {
					$id = $arraya['Response']['ExpressResponseMessage'];
					redirect('payment_error/' . $id);
				}
			}
			else{
				redirect(base_url().'pos2/all_pos');
			}

		}

		public function refund_pos() {
			//print_r($_POST['amount'] ); die();
		//	print_r($_POST);
			
		   $merchant_id = $this->session->userdata('merchant_id');
		   //Data, connection, auth
		   # $dataFromTheForm = $_POST['fieldName']; // request data from the form
			//    $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
		   	$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL
		   
		   	$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
		   	$getEmail_a = $getQuery_a->result_array();
		   	$data['$getEmail_a'] = $getEmail_a;

		   	//print_r($getEmail_a);die;

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
		   	$xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID>
					 <AccountToken>" . $account_token ."</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID>
					 </Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
					 <Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
					 <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
					 <TransactionID>" . $transaction_id . "</TransactionID><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $TicketNumber2 . "</ReferenceNumber><TicketNumber>" . $TicketNumber . "</TicketNumber>
					 </Transaction></CreditCardReturn>"; // data from the form, e.g. some ID number
		  	//echo $xml_post_string; die; 
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
			$arraya = json_decode($json, TRUE);

			//print_r($arraya);

			curl_close($ch);
			$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
		   	//    $card_type = $arraya['Response']['Card']['CardLogo'];
		   	//   $card_no = $arraya['Response']['Card']['CardNumberMasked'];
		 	//die();
		   	$date_c = date("Y-m-d");
		   	$merchant_id = $this->session->userdata('merchant_id');

		   	$branch_info = array(
			   // 'name' => $name,
			   //'email' => $email,
			   // 'mobile_no' => $mobile,
			   'amount' => $amount,
			   'transaction_id' => $trans_a_no,
			   //'transaction_id' => $transaction_id,    //  Old Transaction id
			   //     'card_type' => $card_type,
			   //    'card_no' => $card_no,
			   // 'payment_id' => $payment_id,
			   'invoice_no' => $invoice_no,
			   //  'reason' => $reason,
			   'merchant_id' => $merchant_id,
			   'date_c' => $date_c,
			   'type' => 'pos',
			   'status' => 'confirm',
			   'c_type' => 'CNP',

		   	);
		   	$branch_inf = array(

			   'status' => 'Chargeback_Confirm',

		   	);
		   	//print_r($arraya['Response']['ExpressResponseMessage']);  die(); 
		   	if ($arraya['Response']['ExpressResponseMessage'] == 'Approved') {
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
													   $this->email->send();
												   }
												   $this->session->set_flashdata('success','Amount Refunded Successfully.. ');
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   redirect(base_url() . 'refund/all_pos');
		   	} else {
			   //$errorCode = $arraya['Response']['ExpressResponseCode'];
			   $this->session->set_flashdata('errorCode',$arraya['Response']['ExpressResponseCode']);
			   $id = $arraya['Response']['ExpressResponseMessage'];
			   redirect(base_url().'payment_error/' . $id);

		   	}

	   	}

	   	public function getGUID(){
			if (function_exists('com_create_guid')){
				return com_create_guid();
			}else{
				mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
				// $charid = strtoupper(md5(uniqid(rand(), true)));
				$charid = strtolower(md5(uniqid(rand(), true)));
				$hyphen = chr(45);// "-"
				$uuid = ""// "{"
					.substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
					//.chr(125);// "}"
				return $uuid;
			}
		}
	  	public function get_cr_merchant_info($url_cr,$api_key_cr,$inputRawData) {
			$purl=$url_cr.'/wsapi/Authentication/'; 
			$ch = curl_init();
			$headers = array(
				"X-Roam-Key:$api_key_cr",
				"X-Roam-ApiVersion:6.10.0",
				"X-Roam-ClientVersion:1.0.0",
				"Accept-Encoding:gzip", 
				"Content-Type:application/json" 
			);
			//print_r($inputRawData); die; 
			curl_setopt($ch, CURLOPT_URL,$purl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($inputRawData));           
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response     = curl_exec ($ch);
			$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$err = curl_error($ch);
			 //$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
			 //$jsondata = json_encode($response);
			 $responceArrayData =json_decode($response, true); 
			curl_close($curl);

			return $responceArrayData; 
	  	}

	  	public function  get_cr_transaction_info($url_cr,$session_token,$transaction_id) {
			$purl2=$url_cr.'/wsapi/Transactions/'.$transaction_id; 
		 	$curl = curl_init();
		 	curl_setopt_array($curl, array(
			   	CURLOPT_URL => $purl2,
			   	CURLOPT_RETURNTRANSFER => true,
			   	CURLOPT_ENCODING => "",
			   	CURLOPT_MAXREDIRS => 10,
			   	CURLOPT_TIMEOUT => 30,
			   	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			   	CURLOPT_CUSTOMREQUEST => "GET",
			   	CURLOPT_POSTFIELDS => "",
			   	CURLOPT_HTTPHEADER => array(
					"Accept: */*",
					//"X-Roam-Key:$session_token",
					"X-Roam-ApiVersion: 6.10.0",
					"X-Roam-ClientVersion: 1.0.0",
					"X-Roam-Token: $session_token",
					"Accept-Encoding: gzip",
					"Content-Type: application/json",
					"Cache-Control: no-cache",
			  	),
		 	));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			return $response; 
	  	}
	   	public function refund_cp_pos() {
		   
		   	$merchant_id = $this->session->userdata('merchant_id');
		   	if($merchant_id && isset($_POST)) { 
			   
				$invoice_no=$this->input->post('invoice_no')?$this->input->post('invoice_no'):""; 
		       $transaction_id=$this->input->post('transaction_id')?$this->input->post('transaction_id'):"";

		       $getQuery_merchant = $this->db->query("SELECT merchant_id,sub_merchant_id from pos where invoice_no ='".$invoice_no."' and transaction_id ='".$transaction_id."'  ");

                $getQuery_merchant_det = $getQuery_merchant->result_array();
                $paymnet_merchant = $getQuery_merchant_det[0]['merchant_id'];
                $paymnet_sub_merchant = $getQuery_merchant_det[0]['sub_merchant_id'];

                if($paymnet_sub_merchant!=0)
                {
             $paymnet_merchant_id =$paymnet_sub_merchant;
                }
            else
            {
            $paymnet_merchant_id =$paymnet_merchant ;
            }
				$Row_id=$_POST['id']; 
				$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $paymnet_merchant_id . "'  ");
				$getEmail_a = $getQuery_a->result_array();
				$data['$getEmail_a'] = $getEmail_a;  
				//$merchant_id = $getEmail_a[0]['id'];
				$url_cr = $getEmail_a[0]['url_cr'];
				$username_cr = $getEmail_a[0]['username_cr'];
				$password_cr = $getEmail_a[0]['password_cr'];
				$api_key_cr = $getEmail_a[0]['api_key_cr'];

			   	if($username_cr && $password_cr && $url_cr) {
				   
					   $inputRawData=array ( 'user_name' => $username_cr, 'password' => $password_cr );
					   $responceArrayData=$this->get_cr_merchant_info($url_cr,$api_key_cr,$inputRawData); 
					   $invoice_no=$this->input->post('invoice_no')?$this->input->post('invoice_no'):""; 
					   $amount=$this->input->post('amount')?$this->input->post('amount'):""; 
					   $transaction_id=$this->input->post('transaction_id')?$this->input->post('transaction_id'):""; 
					   $rowid=$this->input->post('id')?$this->input->post('id'):"";
					   $getdata = $this->db->query("SELECT * from pos where id ='" . $rowid . "'  ");
					   $getPosdata = $getdata->result_array();
					   $session_token=$responceArrayData['session']['session_token'];
					   
					   
					   $amount_new = number_format($amount,2);
                       $b = str_replace(",","",$amount_new);
                       $a = number_format($b,2);
                       $amount = str_replace(",","",$a);
                       
                       //print_r($amount); die();
					  
				   if($session_token && $amount )
				   {
					   

					   $version=($getPosdata[0]['version']=='N/A')? '1':$getPosdata[0]['version']; 
					   $chainID=($getPosdata[0]['chainID']=='N/A')?$responceArrayData['chain_id']:$getPosdata[0]['chainID']; 
					   $storeID=($getPosdata[0]['storeID']=='N/A')?$responceArrayData['store_id']:$getPosdata[0]['storeID']; 
					   $terminalID=($getPosdata[0]['terminalID']=='N/A')?$responceArrayData['terminal_id']:$getPosdata[0]['terminalID']; 
					   $client_transaction_id=($getPosdata[0]['client_transaction_id']=='N/A')?'':$getPosdata[0]['client_transaction_id']; 

					   $processorTimestamp=($getPosdata[0]['processorTimestamp']=='N/A')?'20150101120253':$getPosdata[0]['processorTimestamp'];
					   $processorTimezone=($getPosdata[0]['processorTimezone']=='N/A')?'America/New_York':$getPosdata[0]['processorTimezone']; 

					   $deviceTimestamp=($getPosdata[0]['deviceTimestamp']=='N/A')?'20150101120253':$getPosdata[0]['deviceTimestamp']; 
					   $deviceTimezone=($getPosdata[0]['deviceTimezone']=='N/A')?'America/New_York':$getPosdata[0]['deviceTimezone']; 

					   $paymentServiceTimestamp=($getPosdata[0]['paymentServiceTimestamp']=='N/A')?'20150101120253':$getPosdata[0]['paymentServiceTimestamp']; 
					   $paymentServiceTimezone=($getPosdata[0]['paymentServiceTimezone']=='N/A')?'America/New_York':$getPosdata[0]['paymentServiceTimezone']; 

					   $getPosdata[0]['transaction_date']=substr($paymentServiceTimestamp,0,8); 
					   $getPosdata[0]['transaction_time']=substr($paymentServiceTimestamp,8,6);
					   $getPosdata[0]['paymentServiceTimezone']=$paymentServiceTimezone; 
					   if($getPosdata[0]['transaction_type']=='split')
					   {
						   $split_payment_id=$getPosdata[0]['split_payment_id'];
					   }
					   else{
						   $split_payment_id="";
					   }
					   $transaction_date=($getPosdata[0]['transaction_date']=='N/A')?'20150101':$getPosdata[0]['transaction_date'];
					   $transaction_time=($getPosdata[0]['transaction_time']=='N/A')?'120253':$getPosdata[0]['transaction_time']; 
					   $transaction_timezone=($getPosdata[0]['paymentServiceTimezone']=='N/A')?'America/New_York':$getPosdata[0]['paymentServiceTimezone']; 
					   $hardware_serial_number=($getPosdata[0]['serialNumber']=='N/A')?'18284RP10653740':$getPosdata[0]['serialNumber'];
					   
					   
						   //  CURLOPT_URL => "https://mcm.roamdata.com/wsapi/Transactions/81623711", 
						   $response=$this->get_cr_transaction_info($url_cr,$session_token,$transaction_id);
						   
						   //  if ($err) {
						   //    $Error="cURL Error #:" . $err;
						   //    $this->session->set_flashdata('error',$Error);
						   //  } 
						   if($response) {

							   $ResponceArray=json_decode($response); 
							  if(count($response) > 0  && $ResponceArray->payment_list[0]->refundable_amount_in_cents ) 
							  {

								   $ResponceArray->payment_list[0]->transaction_guid;
								   $ResponceArray->payment_list[0]->refundable_amount_in_cents;
								   $ResponceArray->payment_list[0]->device_time_zone;
								   $ResponceArray->payment_list[0]->device_time_stamp;
								   $GUID = $this->getGUID();
								   $amount;
								   


								   $transaction_id; 
								   $requested_amount=($amount*100); 
								   
							   if($requested_amount <= $ResponceArray->payment_list[0]->refundable_amount_in_cents)
							   {
								   
								  // $transaction_date=substr($ResponceArray->payment_list[0]->device_time_stamp,0,8);

								  $transaction_date= date("Ymd");  
								   $transaction_time=substr($ResponceArray->payment_list[0]->device_time_stamp,8,6);
								   $original_transaction_id=$ResponceArray->payment_list[0]->transaction_guid;
								   $transaction_timezone=$ResponceArray->payment_list[0]->device_time_zone;


								   $aa= "{\n\t\t\"transaction\":\n\t\t{\n\t\t\"version\":\"$version\",\n\t    \"client_transaction_id\":\"$GUID\",\n\t\t\"transaction_code\":\"credit_refund\",\n\t\t\"transaction_date\":\"$transaction_date\",\n\t\t\"transaction_time\":\"$transaction_time\",\n\t\t\"original_transaction_id\":\"$original_transaction_id\",\n\t\t\"transaction_timezone\":\"$transaction_timezone\",\n\t\t\"transaction_amount\":\"$requested_amount\",\n\t\t\"currency_code\":\"USD\",\n\t\t\"pos_capability\":\"keyed_entry,track1,track2,contactless_msr,contactless_emv,contact_emv\",\n\t\t\"pos_type\":\"mobile\"\n\t\t}\n}";

								  // print_r($aa); die();   

								 
										   $purl3=$url_cr.'/wsapi/Authorization/'; 
										   $curl3 = curl_init();


										 curl_setopt_array($curl3, array(
										   CURLOPT_URL => $purl3,
										   CURLOPT_RETURNTRANSFER => true,
										   CURLOPT_ENCODING => "",
										   CURLOPT_MAXREDIRS => 10,
										   CURLOPT_TIMEOUT => 30,
										   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										   CURLOPT_CUSTOMREQUEST => "POST",
										   


 CURLOPT_POSTFIELDS =>"{\n\t\t\"transaction\":\n\t\t{\n\t\t\"version\":\"$version\",\n\t    \"client_transaction_id\":\"$GUID\",\n\t\t\"transaction_code\":\"credit_refund\",\n\t\t\"transaction_date\":\"$transaction_date\",\n\t\t\"transaction_time\":\"$transaction_time\",\n\t\t\"original_transaction_id\":\"$original_transaction_id\",\n\t\t\"transaction_timezone\":\"$transaction_timezone\",\n\t\t\"transaction_amount\":\"$requested_amount\",\n\t\t\"currency_code\":\"USD\",\n\t\t\"pos_capability\":\"keyed_entry,track1,track2,contactless_msr,contactless_emv,contact_emv\",\n\t\t\"pos_type\":\"mobile\"\n\t\t}\n}"
										   ,
										   CURLOPT_HTTPHEADER => array(
											   "Accept: */*",
											   //"X-Roam-Key:$session_token",
											   "X-Roam-ApiVersion: 6.10.0",
											   "X-Roam-ClientVersion: 1.0.0",
											   "X-Roam-Token: $session_token",
											   "Accept-Encoding: gzip",
											   "Content-Type: application/json",
											   "Cache-Control: no-cache",
											 ),
										   ));
										

										   $refund_response = curl_exec($curl3);
										   $err = curl_error($curl3);

										   curl_close($curl3);

										   if ($err) {
											   $Error="cURL Error #:" . $err;
											   $this->session->set_flashdata('error',$Error);
										   } else {
											    
												$refund_ResponceArray=json_decode($refund_response);
												//echo $refund_response;
												//echo $refund_response;
											     //die();
												$show_error= $refund_ResponceArray->transaction->clerk_display;
												if($refund_ResponceArray->transaction->clerk_display =='Approved')
												{
														  
												   $amount=($refund_ResponceArray->transaction->transaction_amount)/100;
												   $transaction_id=$refund_ResponceArray->transaction->mcm_transaction_id;
												   $card_type=$refund_ResponceArray->transaction->card_type;
												   $card_no=$refund_ResponceArray->transaction->primary_account_number_masked;
												   $New_invoice_no=$refund_ResponceArray->transaction->mcm_invoice_id;

												   $transaction_guid=$refund_ResponceArray->transaction->transaction_id;
												   $client_transaction_id=$refund_ResponceArray->transaction->client_transaction_id;

												   $date_c = date("Y-m-d");
												   $merchant_id = $this->session->userdata('merchant_id');
												   $branch_info = array(
													   'amount' => $amount,
													   'transaction_id' => $transaction_id,
													   'card_type' => $card_type,
													   'card_no' => $card_no,
													   'invoice_no' => $New_invoice_no,
													   'transaction_guid' => $transaction_guid,
													   'pos_entry_mode' => 'contactless_emv',
													   'client_transaction_id' => $client_transaction_id,
													   //'reason' => $reason,
													   'payment_id'=>$split_payment_id,
													   'merchant_id' => $merchant_id,
													   'date_c' => $date_c,
													   'type' => 'pos',
													   'status' => 'confirm',
													   'c_type' => 'CP'
												   );
												   $branch_inf = array('status' => 'Chargeback_Confirm');
												   //print_r($arraya['Response']['ExpressResponseMessage']);  die(); 
												   
												   $id1 = $this->admin_model->insert_data("refund", $branch_info);
												   $this->admin_model->update_data('pos', $branch_inf, array('id' => $Row_id));



												   $getQuery = $this->db->query("SELECT * from pos where id='$Row_id' ");
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
                                                      $this->admin_model->update_data('pos', $branch_inf_refund_p, array('id' => $Row_id));
  
						   
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
													   $this->email->send();
												   }
												   $this->session->set_flashdata('success','Amount Refunded Successfully.. ');
												   $this->session->set_flashdata('msg', '<div class="text-success text-center"> Amount Refunded Successfully.. </div>');
												   redirect(base_url() . 'refund/all_pos');
												}
												else
												{
												   $this->session->set_flashdata('msg',$show_error);
												}

										   }

							   }
							   else
							   {
								   $this->session->set_flashdata('msg','Requested Amount exceeds the original refundable amount. Please enter a smaller amount');
							   }
							  }
							  else{
								$this->session->set_flashdata('msg','This Transaction Can`t Find ...');
							  }
							}
							else{
							   $this->session->set_flashdata('msg','This Transaction Can`t Find ...');
							 }
					   }
					   else
					   {
						   $this->session->set_flashdata('msg','Cr Login Credential Are required....');
					   }
			   }
			   else
			   {
				   $this->session->set_flashdata('msg','Cr_Username , Cr_Password And  Cr_Url  are required..');
			   }

			   redirect(base_url().'pos2/all_pos');
		   }
	   	}



	public function refund_cp_pos_copy() {
		//print_r(($_POST)); die();
		if(isset($_POST) &&  count($_POST) > 0 )
		{
			$merchant_id = $this->session->userdata('merchant_id');
			//Data, connection, auth
			# $dataFromTheForm = $_POST['fieldName']; // request data from the form
			$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

			$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
			$getEmail_a = $getQuery_a->result_array();
			$data['$getEmail_a'] = $getEmail_a;
			print_r($getEmail_a); 
			
			
                $amountOfMoney = new AmountOfMoney();
				$amountOfMoney->amount = 1;
				$amountOfMoney->currencyCode = "EUR";

				$bankAccountIban = new BankAccountIban();
				$bankAccountIban->iban = "NL53INGB0000000036";

				$bankRefundMethodSpecificInput = new BankRefundMethodSpecificInput();
				$bankRefundMethodSpecificInput->bankAccountIban = $bankAccountIban;

				$name = new PersonalName();
				$name->surname = "Coyote";

				$address = new AddressPersonal();
				$address->countryCode = "US";
				$address->name = $name;

				$contactDetails = new ContactDetailsBase();
				$contactDetails->emailAddress = "wile.e.coyote@acmelabs.com";
				$contactDetails->emailMessageType = "html";

				$customer = new RefundCustomer();
				$customer->address = $address;
				$customer->contactDetails = $contactDetails;

				$refundReferences = new RefundReferences();
				$refundReferences->merchantReference = "AcmeOrder0001";

				$body = new RefundRequest();
				$body->amountOfMoney = $amountOfMoney;
				$body->bankRefundMethodSpecificInput = $bankRefundMethodSpecificInput;
				$body->customer = $customer;
				$body->refundDate = "20140306";
				$body->refundReferences = $refundReferences;

				try {
					$response = $client->merchant("merchantId")->payments()->refund("paymentId", $body);
				} catch (DeclinedRefundException $e) {
					$this->handleDeclinedRefund($e->getRefundResult());
				} catch (ApiException $e) {
					$this->handleApiErrors($e->getErrors());
				}





		
		}
		else
		{
			redirect(base_url('pos2/all_pos')); 
		}
		
	}

	public function card_payment() {
		$data['meta'] = "Add New Pos";
		$data['loc'] = "add_pos";
		$data['action'] = "Charge";

	 //print_r(($_POST)); die();

		$merchant_id = $this->session->userdata('merchant_id');
		//Data, connection, auth
		# $dataFromTheForm = $_POST['fieldName']; // request data from the form
		$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

		$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
		$getEmail_a = $getQuery_a->result_array();
		$data['$getEmail_a'] = $getEmail_a;

		//print_r($getEmail_a);
		if (!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])) {

			$account_id = $getEmail_a[0]['account_id_cnp'];
			$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			$account_token = $getEmail_a[0]['account_token_cnp'];
			$application_id = $getEmail_a[0]['application_id_cnp'];
			$terminal_id = $getEmail_a[0]['terminal_id'];

			$mobile_no = $this->input->post('mobile_no') ? trim($this->input->post('mobile_no')) : "";
			$email_id = $this->input->post('email_id') ? trim($this->input->post('email_id')) : "";

			//if(empty($mobile_no) && empty($email_id)) {
			//	$this->session->set_flashdata('error', 'Please enter either Mobile No or Email to receive the receipt.');
			//	redirect(base_url('pos2/add_pos'));
			//}

			$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
			$card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
                        $card_no = preg_replace('/\s+/', '', $card_no);
                        //echo $card_no;die();
			$cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$address = $this->input->post('address') ? $this->input->post('address') : "";

			$expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
			$expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";
			$payment_id_1 = "POS_" . date("Ymdhisu");
			$payment_id = str_replace("000000", "", $payment_id_1);
			// xml post structure

			$xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>"; // data from the form, e.g. some ID number
//print_r($xml_post_string); die();
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

			//   die();

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

				//if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved' or $arrayy['Response']['ExpressResponseMessage'] == 'Declined') {
					$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
					$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
					$card_type = $arrayy['Response']['Card']['CardLogo'];
					$message_a = $arrayy['Response']['Transaction']['TransactionStatus'];
					$message_complete = $arrayy['Response']['ExpressResponseMessage'];

					//         $arrayy['Response']['Transaction']['TransactionStatus'];
					//   $arrayy['Response']['Transaction']['ApprovedAmount'];

					//   }

					//  if (isset($_POST['message'])) {
					$this->form_validation->set_rules('amount', 'Amount', 'required');
					//  $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
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
					$transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
					$merchant_id = $this->session->userdata('merchant_id');
					if (!empty($this->session->userdata('subuser_id'))) {
						$sub_merchant_id = $this->session->userdata('subuser_id');
					} else {
						$sub_merchant_id = '0';
					}

					//  $tax_id = $this->input->post('TAX_ID') ? $this->input->post('TAX_ID') : "";
					//  $tax_per = $this->input->post('TAX_PER') ? $this->input->post('TAX_PER') : "";

					$tax_id = json_encode($this->input->post('TAX_ID'));
					$tax_per = json_encode($this->input->post('TAX_PER'));

					//   echo $this->input->post('TAX_ID') ; die();

					if ($this->form_validation->run() == FALSE) {

						// if($this->session->userdata('merchant_user_type')=='employee')
						// {
						//     $this->load->view('employee/pos', $data);
						// }
						// else
						// {
						$this->load->view('merchant/pos_dash', $data);
						//}
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

						// print_r($data);  die();

						$id = $this->admin_model->insert_data("pos", $data);

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
						
						
						 

						// $this->load->view("merchant/confirm_payment" , $data);

						// $config['mailtype'] = 'html';
						// $this->email->initialize($config);
						// $this->email->to($email_id);
						// $this->email->from('info@salequick.com','Point Of Sale Invoice');
						// $this->email->subject('Invoice');
						// $this->email->message($htmlContent);

						$msg = $this->load->view('email/pos_receipt', $data, true);
						$email = $email_id;

						// $config['mailtype'] = 'html';
						// $this->email->initialize($config);
						// $email_config = Array(
						//     'protocol'  => 'smtp',
						//     'smtp_host' => 'ssl://smtpout.secureserver.net',
						//     'smtp_port' => '465',
						//     'smtp_user' => 'donotinfo@salequick.com',
						//     'smtp_pass' => '94141',
						//     'mailtype'  => 'html',
						//     'charset' => 'utf-8',
						//     'starttls'  => true,
						//     'newline'   => "\r\n"
						// );
						// $this->load->library('email', $email_config);
						// $from = "donotinfo@salequick.com";
						// $subject = "Salequick Receipt";
						// $headers  = "From: $from\r\n";
						// $headers .= "Content-type: text/html\r\n";
						// mail($email, $subject, $msg, $headers);

						//   $from = "info@salequick.com";
						//   $subject = "Point Of Sale Invoice";
						//   $headers  = "From: $from\r\n";
						//   $headers .= "Content-type: text/html\r\n";
						//   mail($email, $subject, $msg, $headers);

						$MailSubject = ' Point Of Sale Receipt from '.$getEmail1[0]['business_dba_name'];
						//   $headers  = "MIME-Version: 1.0\r\n";
						//   $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
						//   $headers .= "From: Salequick<donotreply@salequick.co >\r\n";
						//   mail($email, $MailSubject, $msg, $headers);

						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->to($email);
						$this->email->subject($MailSubject);
						$this->email->message($msg);
							if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved' ) {
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
						redirect(base_url() . 'pos2/confirm_payment/' . $id);					
						//redirect(base_url() . 'pos2/all_pos');
						} elseif($arrayy['Response']['ExpressResponseMessage'] == 'Declined'){
						    	$id = 'Declined';
						    	$this->session->set_flashdata('success', 'Payment successfully done. We send the receipt on the option you choose.');
						redirect(base_url() . 'payment_error/' . $id);
						}
						
						else {
					$id = $arrayy['Response']['ExpressResponseMessage'];
					redirect('payment_error/' . $id);
			        	}


						//$this->email->attach('files/attachment.pdf');

						// if($message_a=='Approved')
						// {
						// $this->email->send();
						// }

					}
					
				// } else {
				// 	$id = $arrayy['Response']['ExpressResponseMessage'];
				// 	redirect('payment_error/' . $id);
				// }

			} else {
				// if($this->session->userdata('merchant_user_type')=='employee')
				// {
				//     $this->load->view('employee/pos', $data);
				// }
				// else
				// {
				$this->load->view('merchant/pos', $data);
				//}
			}

		} else {
			$id = 'CNP-Credential-Not-available';
			redirect('payment_error/' . $id);
		}
	}

	public function search_record_update() {
		$id = $this->input->post('id');
		$auth_code = $this->input->post('auth_code') ? $this->input->post('auth_code') : "";
		$api_key = $this->input->post('api_key') ? $this->input->post('api_key') : "";
		$connection_id = $this->input->post('connection_id') ? $this->input->post('connection_id') : "";
		$min_shop_supply = $this->input->post('min_shop_supply') ? $this->input->post('min_shop_supply') : "";
		$max_shop_supply = $this->input->post('max_shop_supply') ? $this->input->post('max_shop_supply') : "";
		$shop_supply_percent = $this->input->post('shop_supply_percent') ? $this->input->post('shop_supply_percent') : "";
		$protractor_tax_percent = $this->input->post('protractor_tax_percent') ? $this->input->post('protractor_tax_percent') : "";
		$b_code = $this->input->post('b_code') ? $this->input->post('b_code') : "";
		$d_code = $this->input->post('d_code') ? $this->input->post('d_code') : "";
		$t_code = $this->input->post('t_code') ? $this->input->post('t_code') : "";
		$t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
		$t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
		$t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
		$t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
		$a_code_name = $this->input->post('a_code_name') ? $this->input->post('a_code_name') : "";
		$a_code_value = $this->input->post('a_code_value') ? $this->input->post('a_code_value') : "";
		$a_min_value = $this->input->post('a_min_value') ? $this->input->post('a_min_value') : "";
		$a_max_value = $this->input->post('a_max_value') ? $this->input->post('a_max_value') : "";
		$a_fixed = $this->input->post('a_fixed') ? $this->input->post('a_fixed') : "";
		$c_code_name = $this->input->post('c_code_name') ? $this->input->post('c_code_name') : "";
		$c_code_value = $this->input->post('c_code_value') ? $this->input->post('c_code_value') : "";
		$c_min_value = $this->input->post('c_min_value') ? $this->input->post('c_min_value') : "";
		$c_max_value = $this->input->post('c_max_value') ? $this->input->post('c_max_value') : "";
		$c_fixed = $this->input->post('c_fixed') ? $this->input->post('c_fixed') : "";
		$e_code_name = $this->input->post('e_code_name') ? $this->input->post('e_code_name') : "";
		$e_code_value = $this->input->post('e_code_value') ? $this->input->post('e_code_value') : "";
		$e_min_value = $this->input->post('e_min_value') ? $this->input->post('e_min_value') : "";
		$e_max_value = $this->input->post('e_max_value') ? $this->input->post('e_max_value') : "";
		$e_fixed = $this->input->post('e_fixed') ? $this->input->post('e_fixed') : "";
		$f_code_name = $this->input->post('f_code_name') ? $this->input->post('f_code_name') : "";
		$f_code_value = $this->input->post('f_code_value') ? $this->input->post('f_code_value') : "";
		$f_min_value = $this->input->post('f_min_value') ? $this->input->post('f_min_value') : "";
		$f_max_value = $this->input->post('f_max_value') ? $this->input->post('f_max_value') : "";
		$f_fixed = $this->input->post('f_fixed') ? $this->input->post('f_fixed') : "";
		$g_code_name = $this->input->post('g_code_name') ? $this->input->post('g_code_name') : "";
		$g_code_value = $this->input->post('g_code_value') ? $this->input->post('g_code_value') : "";
		$g_min_value = $this->input->post('g_min_value') ? $this->input->post('g_min_value') : "";
		$g_max_value = $this->input->post('g_max_value') ? $this->input->post('g_max_value') : "";
		$g_fixed = $this->input->post('g_fixed') ? $this->input->post('g_fixed') : "";
		$t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
		$t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
		$t1_min_value = $this->input->post('t1_min_value') ? $this->input->post('t1_min_value') : "";
		$t1_max_value = $this->input->post('t1_max_value') ? $this->input->post('t1_max_value') : "";
		$t1_fixed = $this->input->post('t1_fixed') ? $this->input->post('t1_fixed') : "";
		$t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
		$t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
		$t2_min_value = $this->input->post('t2_min_value') ? $this->input->post('t2_min_value') : "";
		$t2_max_value = $this->input->post('t2_max_value') ? $this->input->post('t2_max_value') : "";
		$t2_fixed = $this->input->post('t2_fixed') ? $this->input->post('t2_fixed') : "";
		$t3_code_name = $this->input->post('t3_code_name') ? $this->input->post('t3_code_name') : "";
		$t3_code_value = $this->input->post('t3_code_value') ? $this->input->post('t3_code_value') : "";
		$t3_min_value = $this->input->post('t3_min_value') ? $this->input->post('t3_min_value') : "";
		$t3_max_value = $this->input->post('t3_max_value') ? $this->input->post('t3_max_value') : "";
		$t3_fixed = $this->input->post('t3_fixed') ? $this->input->post('t3_fixed') : "";
		$url_cr = $this->input->post('url_cr') ? $this->input->post('url_cr') : "";
		$username_cr = $this->input->post('username_cr') ? $this->input->post('username_cr') : "";
		$password_cr = $this->input->post('password_cr') ? $this->input->post('password_cr') : "";
		$api_key_cr = $this->input->post('api_key_cr') ? $this->input->post('api_key_cr') : "";
		$account_id = $this->input->post('account_id') ? $this->input->post('account_id') : "";
		$account_token = $this->input->post('account_token') ? $this->input->post('account_token') : "";
		$application_id = $this->input->post('application_id') ? $this->input->post('application_id') : "";
		$acceptor_id = $this->input->post('acceptor_id') ? $this->input->post('acceptor_id') : "";
		$terminal_id = $this->input->post('terminal_id') ? $this->input->post('terminal_id') : "";

		$branch_info = array(
			'connection_id' => $connection_id,
			'api_key' => $api_key,
			'auth_code' => $auth_code,
			'min_shop_supply' => $min_shop_supply,
			'max_shop_supply' => $max_shop_supply,
			'shop_supply_percent' => $shop_supply_percent,
			'protractor_tax_percent' => $protractor_tax_percent,
			'b_code' => $b_code,
			'd_code' => $d_code,
			't_code' => $t_code,
			't1_code_name' => $t1_code_name,
			't1_code_value' => $t1_code_value,
			't2_code_name' => $t2_code_name,
			't2_code_value' => $t2_code_value,
			'a_code_name' => $a_code_name,
			'a_code_value' => $a_code_value,
			'a_min_value' => $a_min_value,
			'a_max_value' => $a_max_value,
			'a_fixed' => $a_fixed,
			'c_code_name' => $c_code_name,
			'c_code_value' => $c_code_value,
			'c_min_value' => $c_min_value,
			'c_max_value' => $c_max_value,
			'c_fixed' => $c_fixed,
			'e_code_name' => $e_code_name,
			'e_code_value' => $e_code_value,
			'e_min_value' => $e_min_value,
			'e_max_value' => $e_max_value,
			'e_fixed' => $e_fixed,
			'f_code_name' => $f_code_name,
			'f_code_value' => $f_code_value,
			'f_min_value' => $f_min_value,
			'f_max_value' => $f_max_value,
			'f_fixed' => $f_fixed,
			'g_code_name' => $g_code_name,
			'g_code_value' => $g_code_value,
			'g_min_value' => $g_min_value,
			'g_max_value' => $g_max_value,
			'g_fixed' => $g_fixed,
			't1_code_name' => $t1_code_name,
			't1_code_value' => $t1_code_value,
			't1_min_value' => $t1_min_value,
			't1_max_value' => $t1_max_value,
			't1_fixed' => $t1_fixed,
			't2_code_name' => $t2_code_name,
			't2_code_value' => $t2_code_value,
			't2_min_value' => $t2_min_value,
			't2_max_value' => $t2_max_value,
			't2_fixed' => $t2_fixed,
			't3_code_name' => $t3_code_name,
			't3_code_value' => $t3_code_value,
			't3_min_value' => $t3_min_value,
			't3_max_value' => $t3_max_value,
			't3_fixed' => $t3_fixed,
			'url_cr' => $url_cr,
			'username_cr' => $username_cr,
			'password_cr' => $password_cr,
			'api_key_cr' => $api_key_cr,
			'account_id_cnp' => $account_id,
			'account_token_cnp' => $account_token,
			'application_id_cnp' => $application_id,
			'acceptor_id_cnp' => $acceptor_id,
			'terminal_id' => $terminal_id,

		);

		$respoonced=$this->admin_model->update_data('merchant', $branch_info, array('id' => $id));
		if($respoonced){
			echo '200';
		}
		else{
			echo '400';			
		}
	}

	public function search_record_card() {
		$var = $this->input->post('id');

		$data1 = $this->admin_model->data_get_where_serch_pos("pos", $var);
		//$data = $this->admin_model->data_get_where_serch("pos", array("card_no1" => $var));
		if (empty($data1)) {
			$data2 = $this->admin_model->data_get_where_serch_pos_pos("pos", $var);
			$data = $data2;

		} else {
			$data = $data1;
		}

		echo json_encode($data);
		die();
	}

	public function search_record_credntl() {
		$var = $this->input->post('id');

		$data = $this->admin_model->data_get_where_serch("merchant", array("id" => $var));
		echo json_encode($data);
		die();
	}
	public function confirm_payment() {
		$bct_id = $this->uri->segment(3);
		$merchant_id = $this->session->userdata('merchant_id');

		$data = array();

		$merchant_id = $this->session->userdata('merchant_id');

		//$package_data = $this->admin_model->get_data('tax',$merchant_id);
		$package_data = $this->admin_model->data_get_where_1('pos', array('id' => $bct_id, 'merchant_id' => $merchant_id));

		$mem = array();

		foreach ($package_data as $each) {

			$mem[] = $each;
		}
		$data['mem'] = $mem;

		//         if($this->session->userdata('merchant_user_type')=='employee')
		//     {
		//   return $this->load->view('employee/confirm_payment' ,$data);
		//     }
		// else
		// {
		return $this->load->view('merchant/confirm_payment_dash', $data);
		// return $this->load->view('merchant/confirm_payment', $data);
		//}

	}
	public function all_pos3() {

		$this->load->view('merchant/all_pos');
	}
	public function ajax_list() {
		$list = $this->customers->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $customers->name;
			$row[] = $customers->card_no;
			$row[] = $customers->amount;
			$row[] = '<span class="label label-danger"> ' . $customers->status . '  </span>';
			//$row[] = '<a>edit</a>';
			// $row[] = $customers->LastName;
			// $row[] = $customers->phone;
			// $row[] = $customers->address;
			// $row[] = $customers->city;
			// $row[] = $customers->country;
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customers->count_all(),
			"recordsFiltered" => $this->customers->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function inventorymngt() {

		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_full_inventory_spdata($start_date, $end_date,$merchant_id);
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
		} else {
			
			$package_data = $this->Inventory_graph_model->get_full_inventory_data_no_limit($merchant_id);
			
			$data['package_data_no_main_item'] = $this->Inventory_graph_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
			
		}
	
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if(count($each) > 0   && $each->status!='2' ) 
			{
           $each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
			$package['id'] = $each->id;
			$package['merchant_id'] = $each->merchant_id;
			$package['mname'] = $each->mname;
			$package['item_id'] = $each->item_id;
			$package['name'] = $each->name;
			$package['title'] = $each->title;
			$package['sku'] = $each->sku;
			$package['barcode_data'] = $each->barcode_data;
			$package['price'] = $each->price;
			$package['tax'] = $each->tax;
			$package['description'] = $each->description;
			$package['quantity'] = $each->quantity;
			$package['sold_quantity'] = $each->sold_quantity;
			$package['item_image'] = $each->item_image;
			$package['status'] = $each->status;
			$package['date'] = $each->created_at;

			$package['cat_name'] = $each->cat_name;
			$package['cat_code'] = $each->cat_code;
			$mem[] = $package;
		}
	}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		$data['mem'] = $mem;
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');
		$data["title"] ='Inventory Management';
		$data["meta"] ='Inventory Management';
		$this->load->view('merchant/inventory_dash', $data);
		// $this->load->view('merchant/inventory', $data);
	}
	
	public function inventoryreport()
	{
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		$data['merchantdata'] = $getQuery1->result_array();

		//$data['getInventry_main_items']= $this->admin_model->get_all_inventry_main_items($merchant_id);
		$data['getInventry_main_items']= $this->admin_model->get_all_inventry_category($merchant_id);
		
		$this->db->get('adv_pos_item_main');
		if ($this->input->post('mysubmit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$main_items = $_POST['main_items'];
			$package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);

			$data['package_data_no_main_item']=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);

			 $data["start_date"] = $_POST['start_date'];
			$data["end_date"] =  $_POST['end_date'];
			$data["main_items"] = $_POST['main_items'];
		} 
		elseif ($this->input->post('search_Submit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$main_items = $_POST['main_items'];
			$package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);
			$package_data_no_main_item=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			$package_data_total_count_confirm = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'confirm', $merchant_id,'pos');

			$package_data_total_count_refund = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'Chargeback_Confirm', $merchant_id,'pos');
			
			
			
			$package_data_invoice_refund = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund($start_date, $end_date,$main_items,$merchant_id);
			$total_order = count($package_data_invoice_refund);
			$refund_amount=0;
			foreach($package_data_invoice_refund as $invoice_refund)
			{
				$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				$refund_amount+= $refund_check['amount'];
			}


			$package_data_invoice_refund_split = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund_split($start_date, $end_date,$main_items,$merchant_id);
			$total_order_split = count($package_data_invoice_refund_split);
			 $refund_amount_split=0;
			
			//print_r($package_data_invoice_refund_split); die();
			foreach($package_data_invoice_refund_split as $invoice_refund_split)
			{
				$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				$refund_amount_split+= $refund_check['amount'];
			}

			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] =  $_POST['end_date'];
			$data["main_items"] = $_POST['main_items'];
			
		} 

		
		else {
			
			 $start_date = date('Y-m-d', strtotime('-30 days'));
			 $end_date = date('Y-m-d');
			 $data["start_date"] = $start_date;
			 $data["end_date"] =  $end_date;
			 $main_items ='';
			$package_data = $this->Inventory_model->get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id);
			$data['package_data_no_main_item']=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			
			$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			
			//print_r($data['package_data_mis_item']);
		
		}
		//Pdf html



		$parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($data['start_date'],$data['end_date'],$merchant_id,$main_items);
				foreach ($parent_sale as $a_sale) 
                        {
		$text_Sale_html .= '<tr>
                <td style="border-left: 1px solid grey; border-bottom:1px solid grey">'.date("Y-m-d", strtotime($a_sale['updated_at'])).'</td>
				 <td style=" border-bottom:1px solid grey">'.$a_sale['transaction_id'].'</td>
				 <td style=" border-bottom:1px solid grey">'.$a_sale['order_id'].'</td>
				  <td style=" border-bottom:1px solid grey" >'.ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']).'</td>
				<td style="border-bottom:1px solid grey">'.$a_sale['quantity'].'</td>
				
				<td style=" border-bottom:1px solid grey">$ '.number_format($a_sale['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format(str_replace("-",'',$a_sale['discount']),2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format($a_sale['tax_value'],2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format(($a_sale['sold_price']+$a_sale['tax_value'])-$a_sale['discount'],2).'</td>
                    <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
					</tr>';
						}

						//End html
		
		$mem = array();
		
		$member = array();
		foreach ($package_data as $each) {
			if(count($each) > 0  )  
			{
            $each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
			
			$package['item_id'] = $each->item_id;
			$package['main_item_id'] = $each->main_item_id;
			$package['mname'] = $each->mname;
			$package['merchant_id'] = $merchant_id;
			$package['price'] = $each->price;
			$package['tax_value'] = $each->tax_value;
			$package['sku'] = $each->sku;
			$package['new_price'] = $each->new_price;
			$package['quantity'] = $each->quantity;
			$package['cat_name'] = $each->cat_name;
			$package['status'] = $each->status;
			$package['discount'] = $each->discount;
			$package['date'] = $each->created_at;
			$package['updated_at'] = $each->updated_at;
			$package['rowtype'] ="parent";
			$package['sold_price'] = $each->sold_price;
			// $package['tax'] = $each->tax;
			$package['item_name'] = $each->item_name;
			$package['base_price'] = $each->base_price;
			$package['item_image'] = $each->item_image;
			$package['item_title'] = $each->item_title;
			$mem[] = $package;

			

		}
	}

	$data['mem'] = $mem;
		$data['title']='Merchant || Inventory Report';
		$data['meta']='Inventory Report';
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');
		$this->load->view('merchant/inventoryreport_dash', $data);
		// $this->load->view('merchant/inventoryreport', $data);
	//print_r($mem);
		//array_multisort(array_column($mem, 'item_id'),SORT_DESC,$mem);
		
		
		if ($this->input->post('search_Submit')) {

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Inventory Report";
         $title_head = '';
		 
		$obj_pdf->SetTitle($title);
		//$obj_pdf->SetHeaderData($data['merchantdata'][0]['logo'], PDF_HEADER_LOGO_WIDTH, $title,$title_head);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->AddPage();
		
		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->setHeaderTemplateAutoreset(true);
		ob_start();
		

		$startdate = date('M  jS, Y', strtotime($start_date));
		$enddate = date('M  jS, Y', strtotime($end_date));
		$enddatee = date("M  jS, Y h:i A");
		
	    		 $j = 1;
		 $total_item_s = 0;
		 $total_paid_s = 0;
		 $sold_price_s = 0;
		 $tax_value_s = 0;
		 $discount_s = 0;
			foreach ($package_data_no_main_item as $a_data) 
								{
		  
			  $textcolors .= '<tr>
				<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
				 <td style=" border-bottom:1px solid grey" width="10%">'.($a_data['sku']).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
				<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['discount'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2).'</td>
			</tr>';
			
			$total_item_s+= $a_data['quantity'];
			$sold_price_s+= $a_data['sold_price'];
			if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0)
			{
              $tax_value_s+= $a_data['bill_tax'];
			}
			else
			{
				$tax_value_s+= $a_data['tax_value'];
			}

			if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0)
			{
              $discount_s+= $a_data['bill_discount'];
			}
			else
			{
				$discount_s+= $a_data['discount'];
			}
			
			
		 $j++; 
		}
		
		 $k = 1;
		 $total_item_m = 0;
		 $total_paid_m = 0;
		 $sold_price_m = 0;
		 $tax_value_m = 0;
		 $discount_m = 0;
			foreach ($package_data_mis_item as $a_data) 
								{
		  
			  $textcolors .= '<tr>
				<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
				 <td style=" border-bottom:1px solid grey" width="10%"></td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
				<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['discount'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2).'</td>
			</tr>';
			
			$total_item_m+= $a_data['quantity'];
			$sold_price_m+= $a_data['sold_price'];
			if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0)
			{
              $tax_value_m+= $a_data['bill_tax'];
			}
			else
			{
				$tax_value_m+= $a_data['tax_value'];
			}

			if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0)
			{
              $discount_m+= $a_data['bill_discount'];
			}
			else
			{
				$discount_m+= $a_data['discount'];
			}
			
			
		 $k++; 
		}
	
		 $i = 1;
		 $total_item = 0;
		 $total_paid = 0;
		 $sold_price = 0;
		 $tax_value = 0;
		 $discount = 0;
								foreach ($mem as $a_data) 
								{
		  
			  $textcolors .= '<tr >
				<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
				 <td style=" border-bottom:1px solid grey" width="10%"></td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
				<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(str_replace("-",'', $a_data['discount']),2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2).'</td>
			</tr>';
			
			
			
		
			
			$parent = $this->Inventory_model->get_full_inventory_reportdata($data['start_date'],$data['end_date'],$merchant_id,$a_data['main_item_id']);
				foreach ($parent as $parent_Data) 
		
                        {
							$parent_name= Ucfirst($parent_Data['item_title']);
							$textcolors .= '<tr>
                 <td   style="border-left: 1px solid grey; border-bottom:1px solid grey;" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;'.$parent_name.'</td>
				 <td style=" border-bottom:1px solid grey" width="10%">'.$parent_Data['sku'].'</td>
				<td style="border-bottom:1px solid grey" width="10%">'.$parent_Data['quantity'].'</td>
				<td style="border-bottom:1px solid grey" width="10%">0</td>
				<td style=" border-bottom:1px solid grey" width="10%">$ '.number_format($parent_Data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey" width="10%">$ '.number_format(str_replace("-",'',$parent_Data['discount']),2).'</td>
				<td style="border-bottom:1px solid grey" width="10%">$ '.number_format($parent_Data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey" width="10%">$ '.number_format(($parent_Data['sold_price']+$parent_Data['tax_value'])-$parent_Data['discount'],2).'</td>
                      </tr>';
								
								}
						 
			
			$total_item+= $a_data['quantity'];
			$sold_price+= $a_data['sold_price'];
			//$tax_value+= $a_data['tax_value'];
			//$discount+= $a_data['discount'];

			if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0)
			{
              $tax_value+= $a_data['bill_tax'];
			}
			else
			{
				$tax_value+= $a_data['tax_value'];
			}

			if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0)
			{
              $discount+= $a_data['bill_discount'];
			}
			else
			{
				$discount+= $a_data['discount'];
			}
		  
		}
		
		
		$text_Sale = $text_Sale_html;
						


		$html = '
		
		<table   cellpadding="2">
			<tr >
				<td align="left">
				
    <img src="https://salequick.com/logo/'.$data['merchantdata'][0]['logo'].'"  width="60">
  </td>
  <td align="left" colspan="3">
  <span style="font-size: 12px;font-weight:900;">'.ucfirst($data['merchantdata'][0]['business_name']).'</span> 
  <br>&nbsp;&nbsp;<span>'.ucfirst($data['merchantdata'][0]['business_dba_name']).' </span> 
  <br>&nbsp;&nbsp;<span>'.ucfirst($data['merchantdata'][0]['address1']).'</span>
				 </td>
				 <td>
				 </td>
				 <td>
				 </td>
				 
				<td  align="right" colspan="3"> 
				Report Period: '.$enddate.', 12:00 am <br>-'.$startdate.', 11:59 pm
				<br> Generated -   '.$enddatee.'
				</td>
			</tr>
		</table>
		
		<table   cellpadding="2">
			<tr >
				<td> <h2>'.($total_item+$total_item_s+$total_item_m).'</h2> <br> Total Item Sold </td>
				<td> <h2>$ '.number_format(($package_data_total_count_confirm[0]['amount']+$package_data_total_count_refund[0]['amount']+$sold_price+$tax_value+$sold_price_s+$tax_value_m+$sold_price_m+$tax_value_m)-($discount+$refund_amount+$package_data_total_count_refund[0]['amount']+$discount_s),2).'</h2> <br> Total Paid  </td>
				<td> 
				<h2>'.($total_order_split+$total_order+$package_data_total_count_confirm[0]['id']+$package_data_total_count_refund[0]['id']).'</h2> <br>Number Of Orders 
				</td>
				<td> <h2>$ '.number_format(($refund_amount_split+$refund_amount+$package_data_total_count_refund[0]['amount']),2).'</h2> <br> Total Refund  </td>
				
				<td colspan="2">
				</td>
			</tr>
		</table>
		<h3>Summary</h3>
		<table   cellpadding="2">
			<tr >
				<th bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%">Item Name</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;"  width="10%">Sku</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Total Sold</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Total Refund</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">SubTotal</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Discount</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Tax</th>
				<th bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">Grand Total</th>
			</tr>
			'.$textcolors.'
		   
		</table> ';

		$html_Sale = '<h3>Item Sale</h3>
		<table   cellpadding="2">
			<tr >
				<th bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%" >Date</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="15%" >Transaction id</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;"  width="15%">Order Id </th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="15%">Item Name</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="5%">Qty</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="9%">SubTotal</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="8%">Discount</th>
				<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="7%">Tax</th>
				<th bgcolor="#cccccc" style="border-bottom:1px solid grey;font-size: 9px;" width="10%">Grand Total</th>
				<th bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 9px;" width="7%">Status</th>
								  
			</tr>
			'.$text_Sale.'
		</table>';
		$content = $textcolors;
		ob_end_clean();
		//$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->setDestination('Summary', 0, '');
		$obj_pdf->Bookmark('Summary', 0, 0, '', 'BI', array(128,0,0), -1, '#Summary');
		$obj_pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
		$obj_pdf->writeHTML($html, true, false, true, false, '');
		$obj_pdf->AddPage();
		$obj_pdf->setDestination('Item Sale', 0, '');
		$obj_pdf->Bookmark('Item Sale', 0, 0, '', 'BI', array(128,0,0), -1, '#Item Sale');
		$obj_pdf->Cell(0, 10, 'Item Sale', 0, 1, 'L');
		$obj_pdf->writeHTML($html_Sale, true, false, true, false, '');
		$obj_pdf->Output('Inventory Report.pdf', 'D');

				}
				
		
	}
	

	public function inventoryreport_back_us_lion()
	{   
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		//$data['getInventry_main_items']= $this->admin_model->get_all_inventry_main_items($merchant_id);
		$this->db->get('adv_pos_item_main');
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			 
			$main_items = $_POST['main_items'];
			$package_data = $this->admin_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] =  $_POST['end_date'];
			$data["main_items"] = $_POST['main_items'];
		} else {
			
			$package_data = $this->admin_model->get_full_inventory_reportdata_no_limit($merchant_id);
		}
		
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if(count($each) > 0  )   //  && $each->status!='2' 
			{
            $each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
			
			$package['item_id'] = $each->item_id;
			
			$package['price'] = $each->price;
			$package['new_price'] = $each->new_price;
			$package['quantity'] = $each->quantity;
			$package['cat_name'] = $each->cat_name;
			$package['status'] = $each->status;
			$package['discount'] = $each->discount;
			$package['date'] = $each->created_at;
			$package['updated_at'] = $each->updated_at;
			$package['rowtype'] ="parent";
			$package['sold_price'] = $each->sold_price;
			// $package['tax'] = $each->tax;
			$package['item_name'] = $each->item_name;
			$package['base_price'] = $each->base_price;
			$package['item_image'] = $each->item_image;

			$package['item_title'] = $each->item_title;
			$mem[] = $package;
			

			// $inventry_items=$this->admin_model->getinventry_items_list($merchant_id,$each->item_id); 
            
			// if(count($inventry_items) > 0 && $inventry_items!="")
			// {  
			// 	foreach($inventry_items as $itemslist)
			// 	{
            //         $itemslist->created_at=$this->dateTimeConvertTimeZone($itemslist->created_at);
			// 		$package2['item_id'] = $itemslist->item_id;
			// 		//$inventry_items=$this->admin_model->getinventry_items_list($merchant_id,$each->item_id); 
			// 		$package2['price'] = $itemslist->price;
			// 		$package2['new_price'] = $itemslist->new_price;
			// 		$package2['quantity'] = $itemslist->quantity;
			// 		$package2['cat_name'] = $itemslist->cat_name;
			// 		$package2['status'] = $itemslist->status;
			// 		$package2['discount'] = $itemslist->discount;
			// 		$package2['date'] = $itemslist->created_at;
			// 		$package2['updated_at'] = $itemslist->updated_at;
			// 		$package2['rowtype'] ="child";
			// 		$package2['sold_price'] = $itemslist->sold_price;
			// 		// $package['tax'] = $each->tax;
			// 		$package2['item_name'] = $itemslist->item_name;
			// 		$package2['base_price'] = $itemslist->base_price;
			// 		$package2['item_image'] = $itemslist->item_image;
			// 		$package2['item_title'] = $itemslist->item_title;
			// 		$mem[] = $package2;
			// 	}
				
				
			// }
		}
	}
		$data['mem'] = $mem;
		$data['title']='Merchant || Inventory Report';
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
		$this->load->view('merchant/inventoryreport', $data);
	}

		public function all_ecommerce_sandbox() {
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			
			if ($status == "Chargeback_Confirm") {
				$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
			} else {
				$package_data = $this->admin_model->get_search_merchant_pos_paid_list($start_date, $end_date, $status, $merchant_id, 'pos_sandbox');
				 if($status==''){ 
				     
				      $refund_data = '';
			         }	
			        
			}
						
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
					
		}
		elseif ($this->input->post('search_Submit')) {
			
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			
			if ($status == "Chargeback_Confirm") {
				$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
			} else {
				$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date, $status, $merchant_id, 'pos');
				 if($status==''){ 
				   
				      $refund_data = '';
			         }	
			        
			}
		
			$refund_data_search = $this->Inventory_model->get_full_refund_data_search_pdf($start_date, $end_date,'pos', $merchant_id);
			
			
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		}

		else {
			$package_data = $this->admin_model->get_full_details_pos('pos_sandbox', $merchant_id);
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

				$pyadate=str_replace("-","",$each->express_transactiondate);
				$paytime=str_replace(":","",$each->express_transactiontime);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
			$TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
				}
				
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				//$package['amount'] = $each->refund_amount;
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
		$data['meta'] = 'Ecommerce Sadbox Transactions';
		$this->load->view('merchant/all_pos_ecom_sandbox', $data);
	}

	public function all_ecommerce() {
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			
			if ($status == "Chargeback_Confirm") {
				$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
			} else {
				$package_data = $this->admin_model->get_search_merchant_pos_paid_list_wb($start_date, $end_date, $status, $merchant_id, 'pos','yes');
				 if($status==''){ 
				     
				      $refund_data = '';
			         }	
			        
			}
						
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
					
		}
		elseif ($this->input->post('search_Submit')) {
			
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			
			if ($status == "Chargeback_Confirm") {
				$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
			} else {
				$package_data = $this->admin_model->get_search_merchant_pos_wb($start_date, $end_date, $status, $merchant_id, 'pos','yes');
				 if($status==''){ 
				   
				      $refund_data = '';
			         }	
			        
			}
		
			$refund_data_search = $this->Inventory_model->get_full_refund_data_search_pdf($start_date, $end_date,'pos', $merchant_id);
			
			
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		}

		else {
			$package_data = $this->admin_model->get_full_details_pos_wb('pos', $merchant_id,'yes');
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

				$pyadate=str_replace("-","",$each->express_transactiondate);
				$paytime=str_replace(":","",$each->express_transactiontime);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				
			    //$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime);
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date); 
				}
				else {
			$TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
				}
				
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				//$package['amount'] = $each->refund_amount;
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
		$data['meta'] = 'Ecommerce Transactions';
		$this->load->view('merchant/all_pos_ecom_dash', $data);
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
				     //$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, 'Chargeback_Confirm');
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
				//$each->add_date=$this->dateTimeConvertTimeZone($each->add_date);

				$pyadate=str_replace("-","",$each->express_transactiondate);
				$paytime=str_replace(":","",$each->express_transactiontime);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    //$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
			     $TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
			    
				}
				else {
					// $datetime = new DateTime($each->add_date,new DateTimeZone('America/Vancouver'));
					// $la_time = new DateTimeZone('America/Chicago'); // dggdgh
					// $datetime->setTimezone($la_time);
					// $convertedDateTime=$datetime->format('Y-m-d H:i:s');
				 //    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
				    
				}
				
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				//$package['amount'] = $each->refund_amount;
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
                    // $each->refund_dt=$this->dateTimeConvertTimeZone($each->refund_dt);
					// $datetime = new DateTime($each->refund_dt,new DateTimeZone('America/Vancouver'));
					// $la_time = new DateTimeZone('America/Chicago'); // dggdgh
					// $datetime->setTimezone($la_time);
					// $convertedDateTime=$datetime->format('Y-m-d H:i:s');

					// $newdate=$this->dateTimeConvertTimeZone($convertedDateTime);
					$newdate=$this->dateTimeConvertTimeZone($each->refund_dt);
					
					$package['id'] = $each->id;
					$package['refund_row_id'] = $each->refund_row_id;
					// $package['refund_row_id'] = "ABCD";
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['c_type'] = $each->c_type;
					$package['transaction_id'] = $each->refund_transaction;
					// $package['amount'] = $each->amount;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					//$package['amount'] = $each->refund_amount;
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
		
		if ($this->input->post('search_Submit')) {

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Transaction Report";
        $title_head = '';
		$obj_pdf->SetTitle($title);
		//$obj_pdf->SetHeaderData($data['merchantdata'][0]['logo'], PDF_HEADER_LOGO_WIDTH, $title,$title_head);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->AddPage();
		
		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->setHeaderTemplateAutoreset(true);
		ob_start();
		

		$startdate = date('M  jS, Y', strtotime($start_date));
		$enddate = date('M  jS, Y', strtotime($end_date));
		$enddatee = date("M  jS, Y h:i A");
	
		 $i = 0;
		 $total_item = 0;
		 $total_paid = 0;
		foreach ($package_data_array as $a_data) 
		{
			$total = number_format(($a_data['amount']),2);
			$total_item = 	$i++;
			$total_paid+= $total;
		}
		
		 $j = 0;
		 $total_item_refund = 0;
		 $total_paid_refund = 0;
		foreach ($refund_data_search as $a_data) 
		{
			$total = number_format(($a_data['amount']),2);
			$total_item_refund = 	$j++;
			$total_paid_refund+= $total;
		}
		 $k = 0;
		 $total_item_cash = 0;
		 $total_paid_cash = 0;
			foreach ($package_data_cash as $a_data) 
			{
				
			$total = number_format(($a_data['amount']),2);
			$total_item_cash = 	$k++;
			$total_paid_cash+= $total;
			
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				
			
		$count++;
		
			$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($a_data['add_date'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));		
			  $textcolors .= '<tr>
				<td width="23%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
				
			</tr>';
			
		}
		
		foreach ($package_data_splite as $a_data) 
			{
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($a_data['add_date'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Split .= '<tr>
				<td width="23%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['invoice_no'].'</td>
				
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
		
			
		if ($a_data['transaction_type'] == "split") {	
		$merchant_id = $this->session->userdata('merchant_id');
		$this->db->where('invoice_no', $a_data['invoice_no']);
		$this->db->where('merchant_id ', $merchant_id);
		$query = $this->db->get('pos');
		$split_payment = $query->result_array();
			
			//$parent = $this->Inventory_model->get_full_inventory_reportdata($data['start_date'],$data['end_date'],$merchant_id,$a_data['main_item_id']);
				foreach ($split_payment as $split_payment_Data) 
                        {
							
							 if ($split_payment_Data['status'] == 'pending') {
				$status =  ucfirst($split_payment_Data['status']) ;
			} elseif ($split_payment_Data['status'] == 'confirm' ||  $split_payment_Data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($split_payment_Data['status'] == 'declined') {
				$status = ucfirst($split_payment_Data['status']) ;
			} elseif ($split_payment_Data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($split_payment_Data['repeiptmethod']) && !empty($split_payment_Data['repeiptmethod']))? $split_payment_Data['repeiptmethod'] : 'No Receipt';	
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($a_data['add_date'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
				 
							$textcolors_Split .= '<tr>
							
				<td width="23%" align="centre"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$split_payment_Data['transaction_id'].'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['transaction_type']).'</td>
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($split_payment_Data['amount'], 2).'</td>
				';
				
                                if ($merchant_data[0]->csv_Customer_name > 0) {
					$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$split_payment_Data['name'].'</td>';
											 }else
											 {
											$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style=" border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['mname']).'</td>
				
                
                      </tr>';
						 }
		 } 
						 
		  
		}
		
		$l = 0;
        $total_item_check = 0;
		$total_paid_check = 0;
		
		foreach ($package_data_check as $a_data) 
			{
				
			$total = number_format(($a_data['amount']),2);
            $total_item_check = 	$l++;
			$total_paid_check+= $total;
				
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
                 
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($a_data['add_date'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Check .= '<tr>
				<td width="23%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
				$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Check .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
		
		$m = 0;
        $total_item_online = 0;
		$total_paid_online = 0;
		
		foreach ($package_data_online as $a_data) 
			{
				$total = number_format(($a_data['amount']),2);
                $total_item_online = 	$m++;
			    $total_paid_online+= $total;
				
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($a_data['add_date'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Online .= '<tr>
				<td width="23%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
				$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Online .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
	
		
		$n = 0;
        $total_item_card = 0;
		$total_paid_card = 0;
		
		foreach ($package_data_card as $a_data) 
			{
				$total = number_format(($a_data['amount']),2);
                $total_item_card = 	$n++;
			    $total_paid_card+= $total;
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($a_data['add_date'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Card .= '<tr>
				<td width="23%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
		
				$o = 0;
        $total_item_card = 0;
		$total_paid_card = 0;
		
		foreach ($refund_data_search as $a_data) 
			{
				$total = number_format(($a_data['amount']),2);
                $total_item_card = 	$o++;
			    $total_paid_card+= $total;
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
                 
                 $datetime = new DateTime($a_data['refund_dt'],new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');

					$newdate=$this->dateTimeConvertTimeZone($convertedDateTime);
				// $newdate = date("M d Y h:i A", strtotime($a_data['date']));
			
								
			  $textcolors_Refund .= '<tr>
				<td width="23%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}

		$html = '
		<style>
		.borderr {
  border: 2px solid red;
  padding: 10px;
  border-radius: 25px;
}
		</style>
		<table   cellpadding="3">
			<tr>
				
  <td align="left" colspan="4">
  <span style="font-size: 25px;font-weight:900;">'.ucfirst($data['merchantdata'][0]['business_name']).'</span> 
  <br >&nbsp;&nbsp;<span style="font-size: 15px;font-weight:800;">Transactions across all terminals  </span> 
 
				 </td>
				 <td>
				 </td>
				<td  align="left" colspan="3"> 
				</td>
			</tr>
			<tr>
				
					<td  align="left" colspan="4"> 
				&nbsp;Report Period: '.$enddate.', 12:00 am -- '.$startdate.', 11:59 pm
				<br>&nbsp;&nbsp; Generated -   '.$enddatee.'
				
				</td>
				
       <td align="left" colspan="3">
 
				 </td>
				 <td>
				 </td>
				 
			</tr>
			<tr>
				
					<td  align="left" colspan="4"> 
				&nbsp;Total # Transactions: '.($i-$j).'
				
				</td>
				
       <td align="left" colspan="3">
 
				 </td>
				 <td>
				 </td>
				 
			</tr>
		</table>
		
		
		
		<hr style="padding-top:20px;padding-bottom:20px;">
		<h2>Summary</h2>
		<table   cellpadding="2" style="border: 1px solid grey;">
		<tr>
			<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Net Total</h3> </td>
			<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format(($total_paid-$total_paid_refund),2).'</h3> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Purchases ('.$i.')</h3> </td>
				<td align="right">  <h3> $'.number_format($total_paid,2).' </h3> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Refunds ('.$j.')</h3> </td>
				<td align="right" > <h3>$'.number_format($total_paid_refund,2).' </h3> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Pending ('.$package_data_total_pending[0]['id'].')</h3> </td>
				<td align="right" > <h3>$'.number_format($package_data_total_pending[0]['amount'],2).' </h3> </td>
				
			</tr>
		</table>
		
		
		
		<hr style="padding-top:20px;padding-bottom:20px;">
		<h2>Breakdown</h2>
		<table    cellpadding="2" style="border: 1px solid grey;">
		<tr >
			<td  style="border-bottom:1px solid grey;padding: 10px; border-radius:10px;" align="left"> <h3>Net Total</h3> </td>
			<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format($total_paid-$total_paid_refund,2).'</h3> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Total Purchases ('.$i.')</h3> </td>
				<td align="right">  <h3> $'.number_format($total_paid,2).' </h3></td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Cash Purchases ('.$package_data_cash_total[0]['id'].')</span> </td>
				<td align="right"> <span style="font-size: 8px;"> $'.number_format($package_data_cash_total[0]['amount'],2).' </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Card Purchases ('.$package_data_card_total[0]['id'].')</span> </td>
				<td align="right">  <span style="font-size: 8px;"> $'.number_format($package_data_card_total[0]['amount'],2).' </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Check Purchases ('.$package_data_check_total[0]['id'].')</span> </td>
				<td align="right">  <span style="font-size: 8px;"> $'.number_format($package_data_check_total[0]['amount'],2).' </span> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Other Purchases ('.$package_data_online_total[0]['id'].')</span> </td>
				<td align="right">  <span style="font-size: 8px;"> $'.number_format($package_data_online_total[0]['amount'],2).' </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Refunds ('.$j.')</h3> </td>
				<td align="right" > <h3>$'.number_format($total_paid_refund,2).' </h3> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Cash Refunds (0)</span> </td>
				<td align="right" > <span style="font-size: 8px;">$0 </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Card Refunds ('.$j.')</span> </td>
				<td align="right" > <span style="font-size: 8px;">$'.number_format($total_paid_refund,2).' </span> </td>
				
			</tr>
		</table>
		
		
		
		
		
		
		<h3 style="padding: 10px;">Cash Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="23%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				
			</tr>

			'.$textcolors.'
		   
		</table> ';
		
				$html_Check = '
		<h3 style="padding: 10px;">Check Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="23%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Check.'
		   
		</table> ';
		
		$html_Online = '
		<h3 style="padding: 10px;">Other Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="23%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Online.'
		   
		</table> ';
		
		$html_Card = '
		<h3 style="padding: 10px;">Card Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="23%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Card.'
		   
		</table> ';
		
			$html_Split= '
		<h3 style="padding: 10px;">Split Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="23%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Split.'
		   
		</table> ';
		
		$html_Refund= '
		<h3 style="padding: 10px;">Refund Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="23%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Refund.'
		   
		</table> ';

		
		ob_end_clean();
		$obj_pdf->writeHTML($html, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Check, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Online, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Card, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Split, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Refund, true, false, true, false, '');
		$obj_pdf->setDestination('Transaction Report', 0, '');
		$obj_pdf->Bookmark('Transaction Report', 0, 0, '', 'BI', array(128,0,0), -1, '#Transaction Report');
		$obj_pdf->Cell(0, 10, 'Transaction Report', 0, 1, 'L');
		$obj_pdf->Output('Transaction Report.pdf', 'D');

				}
				
		$data['merchant_data'] = $merchant_data;
		$data['meta'] = 'Transactions';
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// echo "<pre>";print_r($data);die;
		// $this->session->unset_userdata('mymsg');

		$this->load->view('merchant/all_pos_dash', $data);
		// $this->load->view('merchant/all_pos', $data);
	}

	public function all_pos_us_lion() {

		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			if ($status == "Chargeback_Confirm") {
				$refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
				
			} else {
				$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date, $status, $merchant_id, 'pos');
				
				 if($status==''){ 
				     $refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, 'Chargeback_Confirm');
			         }	
			        
			}

			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			
			$package_data = $this->admin_model->get_full_details_pos('pos', $merchant_id); 
			$refund_data = $this->admin_model->get_full_refund_data('pos', $merchant_id);
            
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
				//$each->add_date=$this->dateTimeConvertTimeZone($each->add_date);

				$pyadate=str_replace("-","",$each->express_transactiondate);
				$paytime=str_replace(":","",$each->express_transactiontime);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($each->add_date,new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
				
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				//$package['amount'] = $each->refund_amount;
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
			// print_r($refund_data);die;
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
                    // $each->refund_dt=$this->dateTimeConvertTimeZone($each->refund_dt);
					$datetime = new DateTime($each->refund_dt,new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');

					$newdate=$this->dateTimeConvertTimeZone($convertedDateTime);
					
					$package['id'] = $each->id;
					$package['refund_row_id'] = $each->refund_row_id;
					// $package['refund_row_id'] = "ABCD";
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['c_type'] = $each->c_type;
					$package['transaction_id'] = $each->refund_transaction;
					// $package['amount'] = $each->amount;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					//$package['amount'] = $each->refund_amount;
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
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        
		$this->load->view('merchant/all_pos', $data);
	}
	

	// Split Transactions //   
	public function split_transactions($invoice_no) {
		$merchant_id = $this->session->userdata('merchant_id');
		$this->db->where('invoice_no ', $invoice_no);
		$this->db->where('merchant_id ', $merchant_id);
		$query = $this->db->get('pos');
		$data['result'] = $query->result_array();
		$package_data=$query->result(); 
		$mem = array();
		foreach ($package_data as $each) {

			
				// no-cepeipt
				if ($each->mobile_no && $each->email_id) {
					$repeiptmethod = $each->mobile_no;
				} else if ($each->mobile_no != "" && $each->email_id == "") {
					$repeiptmethod = $each->mobile_no;
				} else if ($each->mobile_no == "" && $each->email_id != "") {
					$repeiptmethod = $each->email_id;
				} else {
					$repeiptmethod = 'no-receipt';
				}
			
			$each->add_date = $this->dateTimeConvertTimeZone($each->add_date);
			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['repeiptmethod'] = $repeiptmethod;
			$package['c_type'] = $each->c_type;
			$package['transaction_type'] = $each->transaction_type;
			if ($each->transaction_type == "split") {
				$package['transaction_id'] = $each->transaction_id;
				$package['amount'] = $each->amount;
				$package['full_amount']=$each->full_amount;
				$package['card_no'] = $each->card_no;
				$package['card_type'] = $each->card_type;
			} else {
				$package['transaction_id'] = $each->transaction_id;
				
				$package['amount'] = $each->amount;
				$package['full_amount']=$each->full_amount;
				$package['card_no'] = $each->card_no;
				$package['card_type'] = $each->card_type;
			}
			$package['refund_row_id'] ="";
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$mem[] = $package;

			if($each->status=='Chargeback_Confirm' && $each->transaction_type == "split" )
			{
				$allsplitrefund=$this->admin_model->getallSplitrefund_by_splittransaction_id('pos',$merchant_id,$each->split_payment_id); 
				if(count($allsplitrefund) > 0 )
				{
					
					foreach($allsplitrefund as $row )
					{
						$row->refund_dt = $this->dateTimeConvertTimeZone($row->refund_dt);
						$refund['id'] = $each->id;
						$refund['name'] = $each->name;
						$refund['email'] = $each->email_id;
						$refund['repeiptmethod'] = $repeiptmethod;
						$refund['c_type'] = $each->c_type;
						$refund['transaction_type'] = $each->transaction_type;
						if ($each->transaction_type == "split") {
							
							$refund['full_amount']=$each->full_amount;
							$refund['card_no'] = $each->card_no;
							$refund['card_type'] = $each->card_type;
			
						} else {
							
							$refund['full_amount']=$each->full_amount;
							$refund['card_no'] = $each->card_no;
							$refund['card_type'] = $each->card_type;
						}

						$refund['status'] ='Refund';
						$refund['refund_row_id'] = $row->refund_row_id;
						$refund['date'] = $row->refund_dt;
						$refund['amount'] = $row->refund_amount;
						$refund['transaction_id'] = $row->refund_transaction;
                        $mem[] = $refund;

					}
				}
			}
		}
		$data['result']=$mem;
		// echo "<pre>";print_r($data);die;
		$this->load->view('merchant/split_payment_view_dash', $data);
		// $this->load->view('merchant/split_payment_view', $data);
	}
	//Inventory Report Pdf
	public function all_pos_pdf() {
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		// echo "<pre>";print_r($merchant_data);die;
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date, $status, $merchant_id, 'pos');
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->admin_model->get_full_details_pos('pos', $merchant_id);
			$refund_data = $this->admin_model->get_full_refund_data('pos', $merchant_id);
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if ($each->receipt_type == null) {
				// no-cepeipt
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
				$repeiptmethod = $each->receipt_type;
			}
			$each->add_date = $this->dateTimeConvertTimeZone($each->add_date);
			$package['id'] = $each->id;

			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['repeiptmethod'] = $repeiptmethod;
			$package['c_type'] = $each->c_type;
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

			$package['date'] = $each->add_date;
			$package['status'] = $each->status;

			$mem[] = $package;

		}

		if (isset($refund_data)) {
			// print_r($refund_data);die;
			foreach ($refund_data as $each) {
				$each->refund_dt = $this->dateTimeConvertTimeZone($each->refund_dt);
				if ($each->status == 'Chargeback_Confirm') {
					$package['id'] = $each->id;
					$package['transaction_id'] = $each->refund_transaction;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['repeiptmethod'] = $each->mobile_no;
					$package['c_type'] = $each->c_type;
					$package['refund_row_id'] = $each->refund_row_id;
					//$package['transaction_id'] = $each->transaction_id;
					$package['amount'] = $each->refund_amount ? $each->refund_amount : $each->amount;
					$package['date'] = $each->refund_dt;
					$package['status'] = "Refund";
					$mem[] = $package;
				}
			}
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);
		$data['mem'] = $mem;
		$data['merchant_data'] = $merchant_data;
		tcpdf();
		ob_start();
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->AddPage("L");
		$pdf->SetFont('times', 'B', 10, '', 'false');
		$pdf->MultiCell(0, 5, '', 0, 'C', 0, 2, '', '', true);
		$pdf->Ln(5);
		$html = $this->load->view('merchant/all_pos_pdf', $data, true);
		// echo "<pre>";print_r($data);die;
		$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->output();
		ob_end_flush();
	}
	public function all_customer_request_recurring() {
		 
		$data = array(); 
		$merchant_id = $this->session->userdata('merchant_id');
		$data["meta"] = "Recurring Invoice";
		if ($this->input->post('mysubmit')) {
			$curr_payment_date = $_POST['curr_payment_date'];
			$end_date = $_POST['end'];
		    $status = $_POST['status'];   
			$package_data = $this->admin_model->get_package_details_customer_admin($curr_payment_date,$_POST['end'], $status);
			$data["curr_payment_date"] = $_POST['curr_payment_date'];
			$data["end"] = $_POST['end'];
			$data["status"] = $_POST['status']; 
		} else {
			
			$this->acceptcard_model->saveCardNum($_SESSION['token']);
			
			$package_data = $this->admin_model->get_full_details_payment_admin('customer_payment_request');
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$each->add_date=$this->dateTimeConvertTimeZone($each->add_date);
			$each->due_date=$this->dateTimeConvertTimeZone($each->due_date);
			$each->recurring_pay_start_date=$this->dateTimeConvertTimeZone($each->recurring_pay_start_date);
			$each->recurring_next_pay_date=$this->dateTimeConvertTimeZone($each->recurring_next_pay_date);
			$each->date_c=$this->dateTimeConvertTimeZone($each->date_c);
			$package['id'] = $each->id;
			$package['payment_id'] = $each->invoice_no;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['late_fee'] = $each->late_fee;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['due_date'] = $each->due_date;
			$package['url'] = $each->url;
			$package['add_date'] = $each->add_date;
			$package['recurring_type'] = $each->recurring_type;
			$package['recurring_pay_type'] = $each->recurring_pay_type;
			$package['recurring_count'] = $each->recurring_count;
			$package['recurring_pay_start_date'] = $each->recurring_pay_start_date;
			$package['recurring_next_pay_date'] = $each->recurring_next_pay_date;
			$package['card_type'] = $each->card_type;
			$package['card_no'] = $each->card_no;
			$package['recurring_count_paid'] = $each->recurring_count_paid;
			$package['recurring_count_remain'] = $each->recurring_count_remain;
			$package['date_c'] = $each->date_c;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;
			$package['recurring_payment'] = $each->recurring_payment;
			$mem[] = $package;
		}
  		array_multisort(array_column($mem, 'recurring_pay_start_date'), SORT_DESC, $mem);
		$data['mem'] = $mem;
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');
		$this->load->view('merchant/cust_request_recurring', $data);
		// $this->load->view('merchant/all_customer_request_recurring', $data);
	}

	public  function  invoice_details($invoice_no) {
		$merchant_id = $this->session->userdata('merchant_id');
		$data['meta'] = 'Recurring Payment Request';
	  	if ($this->input->post('mysubmit')) {
			$curr_payment_date = $_POST['curr_payment_date'];
			$invoice_no = $_POST['invoice_no'];
			$end_date = $_POST['end'];
			$status = $_POST['status'];   
			$data['mem']= $this->admin_model->get_singleGroup_filter_customer_admin($curr_payment_date,$_POST['end'], $status,$invoice_no);
			$data["curr_payment_date"] = $_POST['curr_payment_date']; 
			$data["end"] = $_POST['end'];
		    $data['invoice_no']=$invoice_no; 
			$data["status"] = $_POST['status']; 
            $this->load->view('merchant/invoice_details_dash', $data);
		} else if($invoice_no!="") {
			$date = date('Y-m-d', strtotime('-30 days'));
			if ($merchant_id != '') {
				$this->db->where('merchant_id', $merchant_id);
			} 
			$this->db->where('payment_type', 'recurring');
			$this->db->where('invoice_no', $invoice_no);
			$this->db->where("payment_type", "recurring");
			//$this->db->where('recurring_next_pay_date >=', $date);
		    $this->db->order_by("id", "desc");
		    
			$data['mem']=$this->db->get('customer_payment_request')->result_array(); 
// 			print_r(count($data['mem'])); die();       
			$data["curr_payment_date"] = $date; 
			$data["end"] = date('Y-m-d');
			$data["status"] = "";
			$this->load->view('merchant/invoice_details_dash', $data);  
		} else {
			redirect(base_url('pos2/all_customer_request_recurring')); 
		}
	}
	public function all_confirm_payment() {

		$data = array();
		$mem = array();
		$member = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			if ($status == 'straight') {
				$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'confirm', $merchant_id, 'customer_payment_request');
				$data['meta'] = "View All Straight Confirm Payment ";
				foreach ($package_data as $each) {

					$package['id'] = $each->id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->amount;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['due_date'] = $each->due_date;
					$package['payment_date'] = $each->payment_date;
					$package['status'] = $each->status;
					$package['type'] = $each->type;
					//   $package['payment_type'] = $each->payment_type;
					//     $package['recurring_payment'] = $each->recurring_payment;

					$mem[] = $package;
				}
			} else if ($status == 'recurring') {
				$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'confirm', $merchant_id, 'recurring_payment');
				$data['meta'] = "View All Recurring Confirm Payment ";
				foreach ($package_data as $each) {

					$package['id'] = $each->id;
					$package['p_id'] = $each->p_id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->amount;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['due_date'] = $each->due_date;
					$package['payment_date'] = $each->payment_date;
					$package['status'] = $each->status;
					$package['type'] = $each->type;
					//   $package['payment_type'] = $each->payment_type;
					//     $package['recurring_payment'] = $each->recurring_payment;

					$mem[] = $package;
				}
			} else if ($status == 'pos') {
				$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'confirm', $merchant_id, 'pos');
				$data['meta'] = "View All Pos Confirm Payment ";
				foreach ($package_data as $each) {

					$package['id'] = $each->id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->amount;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['due_date'] = $each->due_date;
					$package['payment_date'] = $each->payment_date;
					$package['status'] = $each->status;
					$package['type'] = $each->type;
					//   $package['payment_type'] = $each->payment_type;
					//     $package['recurring_payment'] = $each->recurring_payment;

					$mem[] = $package;
				}
			}
		} else {
			$data['meta'] = "View All Straight Confirm Payment ";

			$package_data = $this->admin_model->get_full_details_payment_rr('customer_payment_request', $merchant_id);
			foreach ($package_data as $each) {

				$package['id'] = $each->id;
				$package['payment_id'] = $each->invoice_no;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['title'] = $each->title;
				$package['date'] = $each->add_date;
				$package['due_date'] = $each->due_date;
				$package['payment_date'] = $each->payment_date;
				$package['status'] = $each->status;
				$package['type'] = $each->type;
				//   $package['payment_type'] = $each->payment_type;
				//     $package['recurring_payment'] = $each->recurring_payment;

				$mem[] = $package;
			}
		}

		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		//   if($this->session->userdata('merchant_user_type')=='employee')
		//     {
		//    $this->load->view('employee/all_confirm_payment', $data);
		//     }
		// else
		// {

		$this->load->view('merchant/all_confirm_payment', $data);
		//}
	}
	public function all_pending_payment() {

		$data = array();
		$mem = array();
		$member = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			if ($status == 'straight') {
				$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'pending', $merchant_id, 'customer_payment_request');
				$data['meta'] = "View All Straight Pending Payment ";
				foreach ($package_data as $each) {

					$package['id'] = $each->id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->amount;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['due_date'] = $each->due_date;
					$package['payment_date'] = $each->payment_date;
					$package['status'] = $each->status;
					$package['type'] = $each->type;
					$package['payment_type'] = $each->payment_type;
					$package['recurring_payment'] = $each->recurring_payment;

					$mem[] = $package;
				}
			} else if ($status == 'recurring') {
				$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'pending', $merchant_id, 'recurring_payment');
				$data['meta'] = "View All Recurring Pending Payment ";
				foreach ($package_data as $each) {

					$package['id'] = $each->id;
					$package['p_id'] = $each->p_id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->amount;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['due_date'] = $each->due_date;
					$package['payment_date'] = $each->payment_date;
					$package['status'] = $each->status;
					$package['type'] = $each->type;
					//$package['payment_type'] = $each->payment_type;
					// $package['recurring_payment'] = $each->recurring_payment;

					$mem[] = $package;
				}
			} else if ($status == 'pos') {
				$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, 'pending', $merchant_id, 'pos');
				$data['meta'] = "View All Pos Pending Payment ";
				foreach ($package_data as $each) {

					$package['id'] = $each->id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->amount;
					$package['title'] = $each->title;
					$package['date'] = $each->add_date;
					$package['due_date'] = $each->due_date;
					$package['payment_date'] = $each->payment_date;
					$package['status'] = $each->status;
					$package['type'] = $each->type;
					//   $package['payment_type'] = $each->payment_type;
					//     $package['recurring_payment'] = $each->recurring_payment;

					$mem[] = $package;
				}
			}
		} else {
			$data['meta'] = "View All Straight Pending Payment ";

			$package_data = $this->admin_model->get_full_details_payment_rr_p('customer_payment_request', $merchant_id);
			foreach ($package_data as $each) {

				$package['id'] = $each->id;
				$package['payment_id'] = $each->invoice_no;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['title'] = $each->title;
				$package['date'] = $each->add_date;
				$package['due_date'] = $each->due_date;
				$package['payment_date'] = $each->payment_date;
				$package['status'] = $each->status;
				$package['type'] = $each->type;
				$package['payment_type'] = $each->payment_type;
				$package['recurring_payment'] = $each->recurring_payment;

				$mem[] = $package;
			}
		}

		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		//   if($this->session->userdata('merchant_user_type')=='employee')
		//     {
		//    $this->load->view('employee/all_pending_payment', $data);
		//     }
		// else
		// {

		$this->load->view('merchant/all_pending_payment', $data);
		//}
	}
	public function all_confirm_recurring() {

		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_search_merchant($start_date, $end_date, $status, $merchant_id, 'customer_payment_request');
		} else {

			$package_data = $this->admin_model->get_recurring_details_payment_rrr($merchant_id);
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->rid;
			$package['payment_id'] = $each->invoice_no;
			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;

			$package['payment_date'] = $each->payment_date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		//   if($this->session->userdata('merchant_user_type')=='employee')
		//     {
		//    $this->load->view('employee/all_confirm_recurring', $data);
		//     }
		// else
		// {

		$this->load->view('merchant/all_confirm_recurring', $data);
		//}
	}
	public function all_recurrig_request() {

		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {

			$curr_payment_date = $_POST['curr_payment_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_recurring_details_payment_admin($curr_payment_date, $status);
		} else {

			$package_data = $this->admin_model->get_recurring_details_payment_admin1();
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['rid'] = $each->rid;
			$package['cid'] = $each->cid;
			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/all_recurrig_request', $data);
	}
	
	public function inventoryreport_ExcelDownload() {
		// create file name
        $fileName = 'Inventory Report Excel.xlsx';
		// load excel library
        $this->load->library('Excel');
		$data = array();
		$mem = array();
		$member = array();
		
		$merchant_id = $this->session->userdata('merchant_id');
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		$data['merchantdata'] = $getQuery1->result_array();
		
		if ($_POST) {
			// echo '<pre>';print_r($_POST);die;
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$main_items = $_POST['main_items'];
			// echo $start_date.','.$end_date.','.$main_items;die;
			$package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);

			$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			$package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);

		} else {
			// echo 'no data';die;
			$start_date = date('Y-m-d', strtotime('-30 days'));
			$end_date = date('Y-m-d');
			$data["start_date"] = $start_date;
			$data["end_date"] =  $end_date;
			$main_items = '';
			$package_data = $this->Inventory_model->get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id);
			$package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
		}
		
		foreach ($package_data as $each) {
			if($each) {
				$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['item_id'] = $each->item_id;
				$package['main_item_id'] = $each->main_item_id;
				$package['mname'] = $each->mname;
				$package['merchant_id'] = $merchant_id;
				// $package['price'] = $each->price;
				$package['tax_value'] = $each->tax_value;
				$package['sku'] = $each->sku;
				// $package['new_price'] = $each->new_price;
				$package['quantity'] = $each->quantity;
				$package['cat_name'] = $each->cat_name;
				$package['status'] = $each->status;
				$package['discount'] = $each->discount;
				$package['date'] = $each->created_at;
				$package['updated_at'] = $each->updated_at;
				$package['rowtype'] = "parent";
				$package['sold_price'] = $each->sold_price;
				$package['item_name'] = $each->item_name;
				$package['base_price'] = $each->base_price;
				$package['item_image'] = $each->item_image;
				$package['item_title'] = $each->item_title;
				$mem[] = $package;
			}
		}

		$startdate = date('M  jS, Y', strtotime($start_date));
		$enddate = date('M  jS, Y', strtotime($end_date));
		$enddatee = date("M  jS, Y h:i A");

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Column Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', ucfirst($data['merchantdata'][0]['business_name']));
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Report Period: '.$enddate.', 12:00 am');
		$rowCount = 2;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['business_dba_name']));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-'.$startdate.', 11:59 pm');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['address1']));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Generated - '.$enddatee);
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Summary');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Item Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'SKU');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Sold');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Refund');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'SubTotal');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Discount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Tax');       
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Grand Total');
		$rowCount++;
		
		$j = 1;
		$total_item_s = 0;
		$total_paid_s = 0;
		$sold_price_s = 0;
		$tax_value_s = 0;
		$discount_s = 0;
		foreach ($package_data_no_main_item as $a_data) {
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

			$export_sold_price = $a_data['sold_price'] ? number_format($a_data['sold_price'],2) : '0.00';
			
			$export_discount = ($a_data["discount"]!="") ? number_format(str_replace("-",'', $a_data['discount']),2) : '0.00';

			$export_tax = $a_data['tax_value'] ? number_format($a_data['tax_value'],2) : '0.00';
			$export_tax = '$'.$export_tax;

			$export_grand_total = $a_data['sold_price'] ? number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2) : '0.00';

			$export_sold_price = '$'.$export_sold_price;
			$export_discount = '$'.$export_discount;
			$export_grand_total = '$'.$export_grand_total;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['sku']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
            $rowCount++;
			$j++;
		}
		
		$k = 1;
		$total_item_m = 0;
		$total_paid_m = 0;
		$sold_price_m = 0;
		$tax_value_m = 0;
		$discount_m = 0;
		foreach ($package_data_mis_item as $a_data) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['quantity']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '$ '.number_format($a_data['sold_price'],2));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$ '.number_format($a_data['discount'],2));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$ '.number_format($a_data['tax_value'],2));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2));
            $rowCount++;
			
			$total_item_m+= $a_data['quantity'];
			$sold_price_m+= $a_data['sold_price'];
			
			if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0) {
              $tax_value_m+= $a_data['bill_tax'];
			} else {
				$tax_value_m+= $a_data['tax_value'];
			}

			if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0) {
              $discount_m+= $a_data['bill_discount'];
			} else {
				$discount_m+= $a_data['discount'];
			}
			$k++; 
		}

		$i = 1;
		foreach ($mem as $a_data) {
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

			$export_sold_price = $a_data['sold_price'] ? round($a_data['sold_price'],2) : '0.00';
			// echo $export_sold_price.'<br>';
			
			$export_discount = ($a_data["discount"]!="") ? number_format(str_replace("-",'', $a_data['discount']),2) : '0.00';

			$export_tax = $a_data['tax_value'] ? number_format($a_data['tax_value'],2) : '0.00';

			// echo $export_sold_price.' , '.$export_tax.' , '.$export_discount.'<br>';
			$export_grand_total = $export_sold_price ? ($export_sold_price+$export_tax-$export_discount) : '0.00';

			$export_sold_price = '$'.number_format($export_sold_price, 2);
			$export_discount = '$'.$export_discount;
			$export_grand_total = '$'.$export_grand_total;
			$export_tax = '$'.$export_tax;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
			$rowCount++;
			
			$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date, $end_date,$merchant_id,$a_data['main_item_id']);

			foreach ($parent as $parent_Data) {
				// echo '<pre>';print_r($parent_Data);die;
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];

				$export_sold_price = ($parent_Data['sold_price'] != "") ? number_format($parent_Data['sold_price'],2) : '0.00';
				
				$export_discount = ($parent_Data["discount"]!="") ? number_format(str_replace("-",'', $parent_Data['discount']),2) : '0.00';

				$export_tax = $parent_Data['tax_value'] ? number_format($parent_Data['tax_value'],2) : '0.00';
				$export_tax = '$'.$export_tax;

				$export_grand_total = $parent_Data['sold_price'] ? number_format(($parent_Data['sold_price']+$parent_Data['tax_value'])-$parent_Data['discount'],2) : '0.00';

				$export_sold_price = '$'.$export_sold_price;
				$export_discount = '$'.$export_discount;
				$export_grand_total = '$'.$export_grand_total;

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '  -'.htmlentities(Ucfirst($parent_Data['item_title'])) );
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['sku']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
				$rowCount++;
			}
		}
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Item Sale');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
		$rowCount++;
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Transaction ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Order ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Item Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Qty');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'SubTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Discount');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Tax');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Grand Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Status');
		$rowCount++;

		$parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date,$end_date,$merchant_id,$main_items);

		foreach ($parent_sale as $a_sale) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale['updated_at'])));
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['order_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']));
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $a_sale['quantity']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale['sold_price'],2));
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale['discount']),2));
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale['tax_value'],2));
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale['sold_price']+$a_sale['tax_value'])-$a_sale['discount'],2));
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
			$rowCount++;
		}

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
		// download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(site_url().$fileName);  
	}

	public function inventoryreport_CSVDownload() {
		// load excel library
        $this->load->library('Excel');
		$data = array();
		$mem = array();
		$member = array();
		
		$merchant_id = $this->session->userdata('merchant_id');
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		$data['merchantdata'] = $getQuery1->result_array();
		
		if ($_POST) {
			// echo '<pre>';print_r($_POST);die;
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$main_items = $_POST['main_items'];
			// echo $start_date.','.$end_date.','.$main_items;die;
			$package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);
			$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			$package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);

		} else {
			// echo 'no data';die;
			$start_date = date('Y-m-d', strtotime('-30 days'));
			$end_date = date('Y-m-d');
			$data["start_date"] = $start_date;
			$data["end_date"] =  $end_date;
			$main_items = '';
			$package_data = $this->Inventory_model->get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id);
			$package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
		}
		
		foreach ($package_data as $each) {
			if($each) {
				$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['item_id'] = $each->item_id;
				$package['main_item_id'] = $each->main_item_id;
				$package['mname'] = $each->mname;
				$package['merchant_id'] = $merchant_id;
				// $package['price'] = $each->price;
				$package['tax_value'] = $each->tax_value;
				$package['sku'] = $each->sku;
				// $package['new_price'] = $each->new_price;
				$package['quantity'] = $each->quantity;
				$package['cat_name'] = $each->cat_name;
				$package['status'] = $each->status;
				$package['discount'] = $each->discount;
				$package['date'] = $each->created_at;
				$package['updated_at'] = $each->updated_at;
				$package['rowtype'] = "parent";
				$package['sold_price'] = $each->sold_price;
				$package['item_name'] = $each->item_name;
				$package['base_price'] = $each->base_price;
				$package['item_image'] = $each->item_image;
				$package['item_title'] = $each->item_title;
				$mem[] = $package;
			}
		}

		$startdate = date('M  jS, Y', strtotime($start_date));
		$enddate = date('M  jS, Y', strtotime($end_date));
		$enddatee = date("M  jS, Y h:i A");

        $objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Column Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1'.$rowCount, ucfirst($data['merchantdata'][0]['business_name']));
		$objPHPExcel->getActiveSheet()->SetCellValue('D1'.$rowCount, 'Report Period: '.$enddate.', 12:00 am');
		$rowCount = 2;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['business_dba_name']));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-'.$startdate.', 11:59 pm');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['address1']));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Generated - '.$enddatee);
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Summary');
		$rowCount++;
		// set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Item Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'SKU');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Sold');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Refund');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'SubTotal');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Discount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Tax');       
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Grand Total');
		$rowCount++;
        // set Row
		
		$j = 1;
		$total_item_s = 0;
		$total_paid_s = 0;
		$sold_price_s = 0;
		$tax_value_s = 0;
		$discount_s = 0;
		foreach ($package_data_no_main_item as $a_data) {
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

			$export_sold_price = $a_data['sold_price'] ? number_format($a_data['sold_price'],2) : '0.00';
			
			$export_discount = ($a_data["discount"]!="") ? number_format(str_replace("-",'', $a_data['discount']),2) : '0.00';

			$export_tax = $a_data['tax_value'] ? number_format($a_data['tax_value'],2) : '0.00';
			$export_tax = '$'.$export_tax;

			$export_grand_total = $a_data['sold_price'] ? number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2) : '0.00';

			$export_sold_price = '$'.$export_sold_price;
			$export_discount = '$'.$export_discount;
			$export_grand_total = '$'.$export_grand_total;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['sku']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
            $rowCount++;
			$j++;
		}
		
		$k = 1;
		$total_item_m = 0;
		$total_paid_m = 0;
		$sold_price_m = 0;
		$tax_value_m = 0;
		$discount_m = 0;
		foreach ($package_data_mis_item as $a_data) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['quantity']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '$ '.number_format($a_data['sold_price'],2));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$ '.number_format($a_data['discount'],2));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$ '.number_format($a_data['tax_value'],2));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2));
            $rowCount++;
			
			$total_item_m+= $a_data['quantity'];
			$sold_price_m+= $a_data['sold_price'];
			
			if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0) {
              $tax_value_m+= $a_data['bill_tax'];
			} else {
				$tax_value_m+= $a_data['tax_value'];
			}

			if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0) {
              $discount_m+= $a_data['bill_discount'];
			} else {
				$discount_m+= $a_data['discount'];
			}
			$k++; 
		}

		$i = 1;
		foreach ($mem as $a_data) {
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

			$export_sold_price = $a_data['sold_price'] ? round($a_data['sold_price'],2) : '0.00';
			// echo $export_sold_price.'<br>';
			
			$export_discount = ($a_data["discount"]!="") ? number_format(str_replace("-",'', $a_data['discount']),2) : '0.00';

			$export_tax = $a_data['tax_value'] ? number_format($a_data['tax_value'],2) : '0.00';

			// echo $export_sold_price.' , '.$export_tax.' , '.$export_discount.'<br>';
			$export_grand_total = $export_sold_price ? ($export_sold_price+$export_tax-$export_discount) : '0.00';

			$export_sold_price = '$'.number_format($export_sold_price, 2);
			$export_discount = '$'.$export_discount;
			$export_grand_total = '$'.$export_grand_total;
			$export_tax = '$'.$export_tax;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
			$rowCount++;
			
			$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date, $end_date,$merchant_id,$a_data['main_item_id']);

			foreach ($parent as $parent_Data) {
				// echo '<pre>';print_r($parent_Data);die;
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];

				$export_sold_price = ($parent_Data['sold_price'] != "") ? number_format($parent_Data['sold_price'],2) : '0.00';
				
				$export_discount = ($parent_Data["discount"]!="") ? number_format(str_replace("-",'', $parent_Data['discount']),2) : '0.00';

				$export_tax = $parent_Data['tax_value'] ? number_format($parent_Data['tax_value'],2) : '0.00';
				$export_tax = '$'.$export_tax;

				$export_grand_total = $parent_Data['sold_price'] ? number_format(($parent_Data['sold_price']+$parent_Data['tax_value'])-$parent_Data['discount'],2) : '0.00';

				$export_sold_price = '$'.$export_sold_price;
				$export_discount = '$'.$export_discount;
				$export_grand_total = '$'.$export_grand_total;

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '  -'.htmlentities(Ucfirst($parent_Data['item_title'])) );
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['sku']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
				$rowCount++;
			}
		}
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
		$rowCount++;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Item Sale');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
		$rowCount++;
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Transaction ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Order ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Item Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Qty');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'SubTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Discount');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Tax');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Grand Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Status');
		$rowCount++;

		$parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date,$end_date,$merchant_id,$main_items);

		foreach ($parent_sale as $a_sale) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale['updated_at'])));
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['order_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']));
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $a_sale['quantity']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale['sold_price'],2));
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale['discount']),2));
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale['tax_value'],2));
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale['sold_price']+$a_sale['tax_value'])-$a_sale['discount'],2));
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
			$rowCount++;
		}
		// create file name
		$fileName = 'Inventory Report CSV';
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function inventorymngt_FullExcelDownload() {
		// $this->load->library('export');
		$this->load->library('Excel');
		$fileName = 'Inventory Management Excel.xlsx';
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		// echo $merchant_id;die;
		$package_data_no_main_item = $this->Inventory_graph_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
		$package_data = $this->Inventory_graph_model->get_full_inventory_data_no_limit($merchant_id);
		// echo '<pre>';print_r($package_data);die;
	
		$mem = array();
		$event_export = array();
		foreach ($package_data as $each) {
			if($each && $each->status!='2') {
				$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['id'] = $each->id;
				$package['merchant_id'] = $each->merchant_id;
				$package['mname'] = $each->mname;
				$package['item_id'] = $each->item_id;
				$package['name'] = $each->name;
				$package['title'] = $each->title;
				$package['sku'] = $each->sku;
				$package['price'] = $each->price;
				$package['tax'] = $each->tax;
				$package['description'] = $each->description;
				$package['quantity'] = $each->quantity;
				$package['sold_quantity'] = $each->sold_quantity;
				$package['item_image'] = $each->item_image;
				$package['status'] = $each->status;
				$package['date'] = $each->created_at;
				$package['cat_name'] = $each->cat_name;
				$package['cat_code'] = $each->cat_code;
				$mem[] = $package;
			}
		}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Column Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		// set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Item Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SKU');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Tax');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'In Stock');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sold Quantity');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
        // set Row
		$rowCount = 2;

		foreach ($package_data_no_main_item as $a_data) {
			$export_price = $a_data['price'] ? number_format($a_data['price'],2) : '0.00';
			$export_price = '$'.$export_price;

			$export_tax = $a_data['tax'].'%';
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];
			$export_sold = ($a_data['sold_quantity']=='I') ? 'Infinite' : $a_data['sold_quantity'];
			if($a_data['status']=='0') {
				$export_status = 'active';
			} else if($a_data['status']=='1'){
				$export_status = 'inactive';
			} else if($a_data['status']=='2'){
				$export_status = 'deleted';
			} else {
				$export_status = '--';
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['name'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['cat_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['sku']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
            $rowCount++;
		}

		$i = 1;
		foreach ($mem as $a_data) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;
			
			$parent = $this->Inventory_graph_model->get_full_inventory_data_no_limit_list($a_data['merchant_id'],$a_data['item_id']);

			foreach ($parent as $parent_Data) {
				$export_title = '  -'.$parent_Data['title'];
				$export_price = $parent_Data['price'] ? number_format($parent_Data['price'],2) : '0.00';
				$export_price = '$ '.$export_price;

				$export_tax = $parent_Data['tax'].'%';
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];
				$export_sold = ($parent_Data['sold_quantity']=='I') ? 'Infinite' : $parent_Data['sold_quantity'];
				if($a_data['status']=='0') {
					$export_status = 'active';
				} else if($a_data['status']=='1'){
					$export_status = 'inactive';
				} else if($a_data['status']=='2'){
					$export_status = 'deleted';
				} else {
					$export_status = '--';
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $export_title);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['cat_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $parent_Data['sku']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
				$rowCount++;
			}
			$i++;
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
		// download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(site_url().$fileName);
	}

	public function inventorymngt_FullCSVDownload() {
		// $this->load->library('export');
		$this->load->library('Excel');
		// $fileName = 'Inventory Management Excel.xlsx';
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		// echo $merchant_id;die;
		$package_data_no_main_item = $this->Inventory_graph_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
		$package_data = $this->Inventory_graph_model->get_full_inventory_data_no_limit($merchant_id);
		// echo '<pre>';print_r($package_data);die;
	
		$mem = array();
		$event_export = array();
		foreach ($package_data as $each) {
			if($each && $each->status!='2') {
				$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['id'] = $each->id;
				$package['merchant_id'] = $each->merchant_id;
				$package['mname'] = $each->mname;
				$package['item_id'] = $each->item_id;
				$package['name'] = $each->name;
				$package['title'] = $each->title;
				$package['sku'] = $each->sku;
				$package['price'] = $each->price;
				$package['tax'] = $each->tax;
				$package['description'] = $each->description;
				$package['quantity'] = $each->quantity;
				$package['sold_quantity'] = $each->sold_quantity;
				$package['item_image'] = $each->item_image;
				$package['status'] = $each->status;
				$package['date'] = $each->created_at;
				$package['cat_name'] = $each->cat_name;
				$package['cat_code'] = $each->cat_code;
				$mem[] = $package;
			}
		}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Column Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		// set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Item Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SKU');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Tax');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'In Stock');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sold Quantity');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
        // set Row
		$rowCount = 2;

		foreach ($package_data_no_main_item as $a_data) {
			$export_price = $a_data['price'] ? number_format($a_data['price'],2) : '0.00';
			$export_price = '$'.$export_price;

			$export_tax = $a_data['tax'].'%';
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];
			$export_sold = ($a_data['sold_quantity']=='I') ? 'Infinite' : $a_data['sold_quantity'];
			if($a_data['status']=='0') {
				$export_status = 'active';
			} else if($a_data['status']=='1'){
				$export_status = 'inactive';
			} else if($a_data['status']=='2'){
				$export_status = 'deleted';
			} else {
				$export_status = '--';
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['name'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['cat_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['sku']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
            $rowCount++;
		}

		$i = 1;
		foreach ($mem as $a_data) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;
			
			$parent = $this->Inventory_graph_model->get_full_inventory_data_no_limit_list($a_data['merchant_id'],$a_data['item_id']);

			foreach ($parent as $parent_Data) {
				$export_title = '  -'.$parent_Data['title'];
				$export_price = $parent_Data['price'] ? number_format($parent_Data['price'],2) : '0.00';
				$export_price = '$ '.$export_price;

				$export_tax = $parent_Data['tax'].'%';
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];
				$export_sold = ($parent_Data['sold_quantity']=='I') ? 'Infinite' : $parent_Data['sold_quantity'];
				if($a_data['status']=='0') {
					$export_status = 'active';
				} else if($a_data['status']=='1'){
					$export_status = 'inactive';
				} else if($a_data['status']=='2'){
					$export_status = 'deleted';
				} else {
					$export_status = '--';
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $export_title);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['cat_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $parent_Data['sku']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
				$rowCount++;
			}
			$i++;
		}
		// create file name
		$fileName = 'Inventory Management CSV';
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function search_card_details() {
		// print_r($_POST);die;
		$merchant_id = $this->session->userdata('merchant_id');
		$CardNo = $this->input->post('CardNo');
		$ChoppedCardNo = substr($CardNo, -4);
		$NameOnCard = $this->input->post('NameOnCard');

		$query = $this->db->query("select distinct expiry_month, expiry_year, cvv, name, SUBSTRING(card_no, -4) as card_no from pos WHERE payment_type = 'web' AND merchant_id = ".$merchant_id." AND SUBSTRING(card_no, -4) = '".$ChoppedCardNo."' AND name = '".$NameOnCard."'");
		$result = $query->result_array();

		foreach ($result as $row) {
			$response[] = array(
				"value" => $row['expiry_month'].','.$row['expiry_year'].','.$row['cvv'],
				"label" => $row['name'].' ('.$row['card_no'].')'
			);
		}
	  	echo json_encode($response);
	}

}