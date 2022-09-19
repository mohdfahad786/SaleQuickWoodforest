<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class EditRecurring extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('profile_model');
		$this->load->model('admin_model');
		$this->load->model('home_model');
		$this->load->library('form_validation');
		//$this->load->library('notification');
		$this->load->library('email');
		$this->load->library('twilio');
		//$this->load->model('sendmail_model');
		$this->load->model('session_checker_model');
		if (!$this->session_checker_model->chk_session_merchant()) {
			redirect('login');
		}
		date_default_timezone_set("America/Chicago");
    }

    public function index() { 

    }

    public function edit_customer_request($id) {
    	// echo $id;die;

        $merchant_id = $this->session->userdata('merchant_id');
		$merchant_name = $this->session->userdata('merchant_name');
		$t_fee = $this->session->userdata('t_fee');
		$aa = $this->admin_model->s_fee("merchant", $merchant_id);
		$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
		//print_r($merchantdetails);die;
		$s_fee = $merchantdetails['0']['s_fee'];
		$t_fee = $this->session->userdata('t_fee');
		$fee_invoice = $merchantdetails['0']['invoice'];
		$fee_swap = $merchantdetails['0']['f_swap_Recurring'];
		$fee_email = $merchantdetails['0']['text_email'];
		$names = substr($merchant_name, 0, 3);
		$getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
		$getDashboardData = $getDashboard->result_array();
		$getDashboardNum = $getDashboard->num_rows();

		$data['getDashboardNum'] = $getDashboardNum;
		if ($getDashboardData == false) {
			$data['getDashboardData'] = '0';
			$inv = '1';
		} else {		
			$data['getDashboardData'] = $getDashboardData;
			$inv1 = $getDashboardData[0]['TotalOrders'];
			$inv = $inv1 + 1;
		}
		$merchant_status = $this->session->userdata('merchant_status');
		if ($merchant_status == 'active') {
			$data['meta'] = "Send Recurring Payment Request";
			$data['loc'] = "add_customer_request";
			$data['action'] = "Send Request";

			if(isset($_POST['submit']) && $id!="") {
				$pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
				if($pd__constant!='on') { $this->form_validation->set_rules('recurring_count', 'Payments Duration', 'required'); }
				$this->form_validation->set_rules('paytype', 'Payment Type', 'required');
				$this->form_validation->set_rules('s_amount', 'amount', 'required');
				$this->form_validation->set_rules('name', 'Name', 'required');
				// $this->form_validation->set_rules('reverence', 'Reverence', 'required');
				// $this->form_validation->set_rules('mobile', 'Phone Number', 'required');
				// $this->form_validation->set_rules('due_date', 'Due  Date', 'required');
				$this->form_validation->set_rules('s_start_date', 'Recurring Start Date', 'required');
				// $this->form_validation->set_rules('title', 'Title', 'required');
				//$this->form_validation->set_rules('Item_Name[]', 'Item Name', 'required');
				//$this->form_validation->set_rules('Quantity[]', 'Quantity', 'required');
				//$this->form_validation->set_rules('Price[]', 'Price', 'required');
                $amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : "";   
				if (!empty($this->session->userdata('subuser_id'))) {
					$sub_merchant_id = $this->session->userdata('subuser_id');
				} else {
					$sub_merchant_id = '0';  
				}
				$fee = ($amount / 100) * $fee_invoice;
				$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
				$fee_email = ($fee_email != '') ? $fee_email : 0;
				$fee = $fee + $fee_swap + $fee_email;
				$sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
				$total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
				$invoice_no = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
				// echo 1;
				// echo $invoice_no;die;
				// $invoice_no = 'INV'.strtoupper($names).'000'.$inv;
				$recurring_payment = 'start';

				$merchant_id = $this->session->userdata('merchant_id'); 

				$getRow=$this->db->query(" SELECT * FROM customer_payment_request WHERE id='$id' " )->result_array(); 
				$merchant_id=$getRow[0]['merchant_id']; 
				$getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
				$Merchantdata = $getMerchantdata->row_array();
				$reptdata['getEmail1']=$getMerchantdata->result_array();

				//for updating
				if ($this->form_validation->run() == FALSE) {
					//echo 'yaha error'; die;
					$this->session->set_flashdata('error','<div class="alert alert-danger text-center">'.validation_errors().'</div>'); 
					//$this->load->view('merchant/add_customer_request');
					redirect(base_url('editrecurring/edit_customer_request/'.$id)); 

				} else { 
					//echo 'chal gaya bhai';die;
					   //print_r($_POST);  die();
					   $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
                       $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
					   $paytype = $this->input->post('paytype') ? "1": "0";  
					   //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
					  //$remark = $this->input->post('remark') ? $this->input->post('remark') : "";
					  $name = $this->input->post('name') ? $this->input->post('name') : "";
					  $email_id = $this->input->post('s_email') ? $this->input->post('s_email') : "";
					  
                $amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : 
					  $phone=$mobile_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";
					  $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
					  $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
					  $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
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

					  // $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
					  //$recurring_next_pay_date = $this->input->post('recurring_next_pay_date') ? $this->input->post('recurring_next_pay_date') : "";
					  $recurring_pay_start_date = $this->input->post('s_start_date') ? $this->input->post('s_start_date') : "";
					  //$note = $this->input->post('note') ? $this->input->post('note') : "";
					  //$reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
					  
					  // $address = $this->input->post('address') ? $this->input->post('address') : "";
					  // $country = $this->input->post('country') ? $this->input->post('country') : "";
					  // $city = $this->input->post('city') ? $this->input->post('city') : "";
					  // $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
					  // $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
					  // $name_card = $this->input->post('name_card') ? $this->input->post('name_card') : "";
					  // $expiry_month = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
					  // $expiry_year = $this->input->post('exp_year') ? $this->input->post('exp_year') : "";
					  // $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
					   $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
					  //  //echo $pd__constant;   // pd__constant
						//   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
					   if($pd__constant=='on' &&  $recurring_count=="") { $recurring_count=-1;  }
					   $curdate=date('Y-m-d');
					   
 
					   if($getRow[0]['recurring_count_paid']=='0')
					   {

					   	
							 if($getRow[0]['recurring_pay_type']=='1')  //  auto 
							 {
							 	//echo $paytype;die;
								   if($paytype=='1')   //   Auto to Auto 
								   {     //die("Auto To Auto"); 
										
											   //$recurring_pay_start_date1=$recurring_next_pay_date;
											   $recurring_pay_start_date1=date($recurring_pay_start_date); 
											   switch($recurring_type)
											   {
												   case 'daily':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'weekly':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'biweekly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'monthly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'quarterly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'yearly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												   break;
												   default :
													   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break; 
											   }
											   $dfg = date("Ymdhisu");
											   $url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   //$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   $unique2 = "PY" . $dfg;
											   
											   $day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											   $month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											   $today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
											   $type=$getRow[0]['payment_type'];
											   $paid=$getRow[0]['recurring_count_paid']; 
											   $recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											   ///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											   $remain=($recurring_count >0)?$recurring_count:1; 
											   $sub_total=$getRow[0]['sub_total']+$amount;
											   //   start, stop,  complete
											   if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
				   
											   $data2 = Array(
												   'reference' => $reference,
												   'name' => $name,
												   'other_charges' => $other_charges,
                                                   'otherChargesName' => $other_charges_title,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   //'payment_id'=>$unique2,
												   //'url'=>$url2,
												   'detail' => $remark,
												   'note' => $note,
													'date_c'=>$today2_a,
													'amount'=>$amount,
												   'payment_type' => 'recurring',
												   'recurring_type' => $recurring_type,
												   'recurring_count' => $recurring_count1,
												   // 'due_date' => $due_date,
												   'recurring_payment' => $recurring_payment,
												   'recurring_pay_start_date' => $recurring_pay_start_date,
												   'recurring_next_pay_date' => $recurring_next_pay_date,
												   'recurring_pay_type' => $paytype,
												   'status' => 'pending',
												   'payment_date' => "",
												   'recurring_count_paid' => $paid,
												   'recurring_count_remain' => $remain, 
												   'transaction_id' => "",
												   'message' =>  "",
												  'recurring_type_week' => $recurring_type_weekly,
                      								'recurring_type_month' => $recurring_type_monthly,
												   'card_no' =>  '',
												   'sign' =>  "",
												   'address' =>  $address,
												   'name_card' =>  $name_card,
												   'l_name' => "",
												   'address_status' =>  "",
												   'zip_status' =>  "",
												   'cvv_status' =>  "",
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										  //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $data['resend'] = "";
										   $item_name = json_encode($this->input->post('Item_Name'));
										   $quantity = json_encode($this->input->post('Quantity'));
										   $price = json_encode($this->input->post('Price'));
										   $tax = json_encode($this->input->post('Tax_Amount'));
										   $tax_id = json_encode($this->input->post('Tax'));
										   $tax_per = json_encode($this->input->post('Tax_Per'));
										   $total_amount = json_encode($this->input->post('Total_Amount'));
										   $item_Detail_1 = array(
											   "p_id" => $id,
											   "item_name" => ($item_name),  
											   "quantity" => ($quantity),
											   "price" => ($price),
											   "tax" => ($tax),
											   "tax_id" => ($tax_id),
											   "tax_per" => ($tax_per),
											   "total_amount" => ($total_amount),
					   
										   );
										   // print_r($item_Detail_1);  die(); 
										   	$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
										   	$getDashboardData_m = $getDashboard_m->result_array();
										   //print_r($getDashboardData_m); die();  
										   	$data2['getDashboardData_m'] = $getDashboardData_m;
										   	$data2['business_name'] = $getDashboardData_m[0]['business_name'];
										   	$data2['address1'] = $getDashboardData_m[0]['address1'];
										   	$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
										   	$data2['logo'] = $getDashboardData_m[0]['logo'];
										   	$data2['business_number'] = $getDashboardData_m[0]['business_number'];
										   	$data2['color'] = $getDashboardData_m[0]['color'];
										   	$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
										   	$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
										   //$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										  // echo $mn;  die(); 
										   $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
										   $data2['item_detail'] = $item_Detail_1;  
													 
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											  "MIME-Version: 1.0" . "\r\n" .
											  "Content-type: text/html; charset=UTF-8" . "\r\n";
											  if($recurring_pay_start_date==$curdate)    //  auto to manual   
											  { 
												   if(!empty($email_id)){ 
													   $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
													   $this->email->to($email_id);
													   $this->email->subject($MailSubject);
													   $this->email->message($msg);
													   $m=$this->email->send();
													   }
											  }
											  $this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											  redirect(base_url('pos/all_customer_request_recurring'));
										   
								   }
								   else if($paytype=='0')  //  auto to manual 
								   {    //echo 1; die;    
									   //$recurring_pay_start_date1=$recurring_next_pay_date;
									    
											   $recurring_pay_start_date1=date($recurring_pay_start_date); 
											   switch($recurring_type)
											   {
												   case 'daily':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'weekly':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'biweekly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'monthly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'quarterly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'yearly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												   break;
												   default :
													   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break; 
											   }
											   $dfg = date("Ymdhisu");
											   $url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   //$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   $unique2 = "PY" . $dfg;
											   
											   $day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											   $month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											   $today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
											   $type=$getRow[0]['payment_type'];
											   $paid=$getRow[0]['recurring_count_paid']; 
											   $recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											   ///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											   $remain=($recurring_count >0)?$recurring_count:1; 
											   $sub_total=$getRow[0]['sub_total']+$amount;
											   //   start, stop,  complete
											   if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
				   
											   $data2 = Array(
												   'reference' => $reference,
												   'name' => $name,
												   'other_charges' => $other_charges,
                                                   'otherChargesName' => $other_charges_title,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   //'payment_id'=>$unique2,
												   //'url'=>$url2,
												   'detail' => $remark,
												   'note' => $note,
													'date_c'=>$today2_a,
												   'payment_type' => 'recurring',
												   'recurring_type' => $recurring_type,
												   'recurring_type_week' => $recurring_type_weekly,
                      								'recurring_type_month' => $recurring_type_monthly,
												   'recurring_count' => $recurring_count1,
												   // 'due_date' => $due_date,
												   'recurring_payment' => $recurring_payment,
												   'recurring_pay_start_date' => $recurring_pay_start_date,
												   'recurring_next_pay_date' => $recurring_next_pay_date,
												   'recurring_pay_type' => $paytype,
												   'status' => 'pending',
												   'payment_date' => "",
												   'recurring_count_paid' => $paid,
												   'recurring_count_remain' => $remain, 
												   'transaction_id' => "",
												   'message' =>  "",
												   'card_type' =>  '',
												   'card_no' =>  '',
												   'sign' =>  "",
												   'address' =>  $address,
												   'name_card' =>  $name_card,
												   'l_name' => "",
												   'address_status' =>  "",
												   'zip_status' =>  "",
												   'cvv_status' =>  "",
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $data['resend'] = "";
										   $item_name = json_encode($this->input->post('Item_Name'));
										   $quantity = json_encode($this->input->post('Quantity'));
										   $price = json_encode($this->input->post('Price'));
										   $tax = json_encode($this->input->post('Tax_Amount'));
										   $tax_id = json_encode($this->input->post('Tax'));
										   $tax_per = json_encode($this->input->post('Tax_Per'));
										   $total_amount = json_encode($this->input->post('Total_Amount'));
										   $item_Detail_1 = array(
											   "p_id" => $id,
											   "item_name" => ($item_name),  
											   "quantity" => ($quantity),
											   "price" => ($price),
											   "tax" => ($tax),
											   "tax_id" => ($tax_id),
											   "tax_per" => ($tax_per),
											   "total_amount" => ($total_amount),
					   
										   );
										   // print_r($item_Detail_1);  die(); 
										   $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
										   $getDashboardData_m = $getDashboard_m->result_array();
										   //print_r($getDashboardData_m); die();  
										   $data2['getDashboardData_m'] = $getDashboardData_m;
										   $data2['business_name'] = $getDashboardData_m[0]['business_name'];
										   $data2['address1'] = $getDashboardData_m[0]['address1'];
										   $data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
										   $data2['logo'] = $getDashboardData_m[0]['logo'];
										   $data2['business_number'] = $getDashboardData_m[0]['business_number'];
										   $data2['color'] = $getDashboardData_m[0]['color'];
										   $data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
										   $data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
										   //$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										  // echo $mn;  die(); 
										   $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
										   $data2['item_detail'] = $item_Detail_1;  
													 
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject =  ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											  "MIME-Version: 1.0" . "\r\n" .
											  "Content-type: text/html; charset=UTF-8" . "\r\n";
											  if($recurring_pay_start_date==$curdate)    //  auto to manual   
											  { 
												   if(!empty($email_id)){ 
													   $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
													   $this->email->to($email_id);
													   $this->email->subject($MailSubject);
													   $this->email->message($msg);
													   $m=$this->email->send();
													   }
											  }
											  $this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											  redirect(base_url('pos/all_customer_request_recurring'));
										   
									   
								   }
							 }
							 else if($getRow[0]['recurring_pay_type']=='0')  //  menual
							 {
								   if($paytype=='0')   //   manual to manual 
								   {
									   //$recurring_pay_start_date1=$recurring_next_pay_date;
											   $recurring_pay_start_date1=date($recurring_pay_start_date); 
											   switch($recurring_type)
											   {
												   case 'daily':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'weekly':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'biweekly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'monthly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'quarterly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'yearly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												   break;
												   default :
													   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break; 
											   }
											   $dfg = date("Ymdhisu");
											   $url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   //$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   $unique2 = "PY" . $dfg;
											   
											   $day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											   $month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											   $today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
											   $type=$getRow[0]['payment_type'];
											   $paid=$getRow[0]['recurring_count_paid']; 
											   $recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											   ///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											   $remain=($recurring_count >0)?$recurring_count:1; 
											   $sub_total=$getRow[0]['sub_total']+$amount;
											   //   start, stop,  complete
											   if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
				   
											   $data2 = Array(
												   'reference' => $reference,
												   'name' => $name,
												   'other_charges' => $other_charges,
                                                   'otherChargesName' => $other_charges_title,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   //'payment_id'=>$unique2,
												   //'url'=>$url2,
												   'detail' => $remark,
												   'note' => $note,
													'date_c'=>$today2_a,
												   'payment_type' => 'recurring',
												   'recurring_type' => $recurring_type,
												   'recurring_count' => $recurring_count1,
												   // 'due_date' => $due_date,
												   'recurring_payment' => $recurring_payment,
												   'recurring_pay_start_date' => $recurring_pay_start_date,
												   'recurring_next_pay_date' => $recurring_next_pay_date,
												   'recurring_pay_type' => $paytype,
												   'status' => 'pending',
												   'payment_date' => "",
												   'recurring_count_paid' => $paid,
												   'recurring_count_remain' => $remain, 
												   'transaction_id' => "",
												   'message' =>  "",
												   'card_type' =>  '',
												   'card_no' =>  '',
												   'sign' =>  "",
												   'address' =>  $address,
												   'name_card' =>  $name_card,
												   'l_name' => "",
												   'address_status' =>  "",
												   'zip_status' =>  "",
												   'cvv_status' =>  "",
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $data['resend'] = "";
										   $item_name = json_encode($this->input->post('Item_Name'));
										   $quantity = json_encode($this->input->post('Quantity'));
										   $price = json_encode($this->input->post('Price'));
										   $tax = json_encode($this->input->post('Tax_Amount'));
										   $tax_id = json_encode($this->input->post('Tax'));
										   $tax_per = json_encode($this->input->post('Tax_Per'));
										   $total_amount = json_encode($this->input->post('Total_Amount'));
										   $item_Detail_1 = array(
											   "p_id" => $id,
											   "item_name" => ($item_name),  
											   "quantity" => ($quantity),
											   "price" => ($price),
											   "tax" => ($tax),
											   "tax_id" => ($tax_id),
											   "tax_per" => ($tax_per),
											   "total_amount" => ($total_amount),
					   
										   );
										   // print_r($item_Detail_1);  die(); 
										   $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
										   $getDashboardData_m = $getDashboard_m->result_array();
										   //print_r($getDashboardData_m); die();  
										   $data2['getDashboardData_m'] = $getDashboardData_m;
										   $data2['business_name'] = $getDashboardData_m[0]['business_name'];
										   $data2['address1'] = $getDashboardData_m[0]['address1'];
										   $data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
										   $data2['logo'] = $getDashboardData_m[0]['logo'];
										   $data2['business_number'] = $getDashboardData_m[0]['business_number'];
										   $data2['color'] = $getDashboardData_m[0]['color'];
										   $data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
										   $data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
										   //$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										  // echo $mn;  die(); 
										   $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
										   $data2['item_detail'] = $item_Detail_1;  
													 
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											  "MIME-Version: 1.0" . "\r\n" .
											  "Content-type: text/html; charset=UTF-8" . "\r\n";
											  if($recurring_pay_start_date==$curdate)    //  auto to manual   
											  { 
												   if(!empty($email_id)){ 
													   $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
													   $this->email->to($email_id);
													   $this->email->subject($MailSubject);
													   $this->email->message($msg);
													   $m=$this->email->send();
													   }
											  }
											  $this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											  redirect(base_url('pos/all_customer_request_recurring'));
																		   
								   }
								   else if($paytype=='1')  //  Manual  to  Auto 
								   {
									   //$recurring_pay_start_date1=$recurring_next_pay_date;
											   $recurring_pay_start_date1=date($recurring_pay_start_date); 
											   switch($recurring_type)
											   {
												   case 'daily':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'weekly':
												   $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												   break;
												   case 'biweekly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'monthly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'quarterly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												   break;
												   case 'yearly':
												   $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												   break;
												   default :
													   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												   break; 
											   }
											   $dfg = date("Ymdhisu");
											   $url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   //$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											   $unique2 = "PY" . $dfg;
											   
											   $day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											   $month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											   $today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
											   $type=$getRow[0]['payment_type'];
											   $paid=$getRow[0]['recurring_count_paid']; 
											   $recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											   ///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											   $remain=($recurring_count >0)?$recurring_count:1; 
											   $sub_total=$getRow[0]['sub_total']+$amount;
											   //   start, stop,  complete
											   if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
				   
											   $data2 = Array(
												   'reference' => $reference,
												   'name' => $name,
												   'other_charges' => $other_charges,
                                                   'otherChargesName' => $other_charges_title,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   //'payment_id'=>$unique2,
												   //'url'=>$url2,
												   'detail' => $remark,
												   'note' => $note,
													'date_c'=>$today2_a,
												   'payment_type' => 'recurring',
												   'recurring_type' => $recurring_type,
												   'recurring_count' => $recurring_count1,
												   // 'due_date' => $due_date,
												   'recurring_payment' => $recurring_payment,
												   'recurring_pay_start_date' => $recurring_pay_start_date,
												   'recurring_next_pay_date' => $recurring_next_pay_date,
												   'recurring_pay_type' => $paytype,
												   'status' => 'pending',
												   'payment_date' => "",
												   'recurring_count_paid' => $paid,
												   'recurring_count_remain' => $remain, 
												   'transaction_id' => "",
												   'message' =>  "",
												   'card_type' =>  '',
												   'card_no' =>  '',
												   'sign' =>  "",
												   'address' =>  $address,
												   'name_card' =>  $name_card,
												   'l_name' => "",
												   'address_status' =>  "",
												   'zip_status' =>  "",
												   'cvv_status' =>  "",
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $data['resend'] = "";
										   $item_name = json_encode($this->input->post('Item_Name'));
										   $quantity = json_encode($this->input->post('Quantity'));
										   $price = json_encode($this->input->post('Price'));
										   $tax = json_encode($this->input->post('Tax_Amount'));
										   $tax_id = json_encode($this->input->post('Tax'));
										   $tax_per = json_encode($this->input->post('Tax_Per'));
										   $total_amount = json_encode($this->input->post('Total_Amount'));
										   $item_Detail_1 = array(
											   "p_id" => $id,
											   "item_name" => ($item_name),  
											   "quantity" => ($quantity),
											   "price" => ($price),
											   "tax" => ($tax),
											   "tax_id" => ($tax_id),
											   "tax_per" => ($tax_per),
											   "total_amount" => ($total_amount),
					   
										   );
										   // print_r($item_Detail_1);  die(); 
										   $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
										   $getDashboardData_m = $getDashboard_m->result_array();
										   //print_r($getDashboardData_m); die();  
										   $data2['getDashboardData_m'] = $getDashboardData_m;
										   $data2['business_name'] = $getDashboardData_m[0]['business_name'];
										   $data2['address1'] = $getDashboardData_m[0]['address1'];
										   $data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
										   $data2['logo'] = $getDashboardData_m[0]['logo'];
										   $data2['business_number'] = $getDashboardData_m[0]['business_number'];
										   $data2['color'] = $getDashboardData_m[0]['color'];
										   $data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
										   $data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
										   //$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										  // echo $mn;  die(); 
										   $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
										   $data2['item_detail'] = $item_Detail_1;  
													 
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											  "MIME-Version: 1.0" . "\r\n" .
											  "Content-type: text/html; charset=UTF-8" . "\r\n";
											  if($recurring_pay_start_date==$curdate)    //  auto to manual   
											  { 
												   if(!empty($email_id)){ 
													   $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
													   $this->email->to($email_id);
													   $this->email->subject($MailSubject);
													   $this->email->message($msg);
													   $m=$this->email->send();
													   }
											  }
											  $this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											  redirect(base_url('pos/all_customer_request_recurring'));
								   }
							}
				    }	
					else if($getRow[0]['recurring_count_paid'] !='0')   //   this condition for one payment or one more paid invoice :: edit functionallity 
					{
						if($getRow[0]['recurring_pay_type']=='1')  ///    Auto 
						{
							
							if($paytype=='0') // Auto to    Manual
							{     
								     //die("its auto To Menual"); 
                                    //  $mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
									//  $card_type=$getRow[0]['card_type']; 
									//  $getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
									//  $token_data = $getQuery_t->row_array();
									//  $tokenID=$token_data['id'];
									//   if($tokenID != "" ){  
									// 	  $res = $this->db->query("DELETE FROM token WHERE  id='$tokenID' ");
									//   }
								    if($getRow[0]['status']=='confirm' ||  $getRow[0]['status']=='Chargeback_Confirm' ) {
												$recurring_pay_start_date1=$recurring_next_pay_date;
												$recurring_pay_start_date1=date($recurring_pay_start_date1); 
											switch($recurring_type)
											{
												case 'daily':
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												break;
												case 'weekly':
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												break;
												case 'biweekly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												break;
												case 'monthly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												break;
												case 'quarterly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												break;
												case 'yearly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												break;
												default :
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												break; 
											}
											$dfg = date("Ymdhisu");
											$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											//$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											$unique2 = "PY" . $dfg;
											$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											$today2 = date("Y-m-d");  $year = date("Y"); $month = date("m");  $today3 = date("Y-m-d H:i:s");
											$type=$getRow[0]['payment_type'];
											$paid=$getRow[0]['recurring_count_paid']; 
											$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											$remain=($recurring_count >0)?$recurring_count:1; 
											$sub_total=$getRow[0]['sub_total']+$amount;
											//   start, stop,  complete
											if($remain <='0')  {  $recurring_payment='complete';  } else{ $recurring_payment='start';  }
											$data2 = Array(
												'reference' => $reference,
												'name' => $name,
												'other_charges' => $other_charges,
                                                'otherChargesName' => $other_charges_title,
												'invoice_no' => $invoice_no,
												'email_id' => $email_id,
												'mobile_no' => $mobile_no,
												'amount' => $amount,
												'sub_total' => $sub_amount,
												'tax' => $total_tax,
												'fee' => $fee,
												's_fee' => $fee_swap,
												// 'title' => $title,
												'detail' => $remark,
												'note' => $note,
												//'url' => $url2,
												'payment_type' => 'recurring',
												'recurring_type' => $recurring_type,
												'recurring_count' => $recurring_count1,
												// 'due_date' => $due_date,
												'merchant_id' => $merchant_id,
												'sub_merchant_id' => $sub_merchant_id,
												//'payment_id' => $unique2,
												'recurring_payment' => $recurring_payment,
						
												'recurring_pay_start_date' => $recurring_pay_start_date1,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $paytype,
												
												'status' => 'pending',
												'year' => $year,
												'month' => $month,
												'time1' => $time1,
												'day1' => $day1,
												'date_c' => $today2_a,
												'payment_date' => "",
												'recurring_count_paid' => $paid,
												'recurring_count_remain' => $remain, 
												'transaction_id' => "",
												'message' =>  "",
												'card_type' =>$getRow[0]['card_type'],
												'card_no' =>  '',
												'sign' =>  "",
												'address' =>  $address,
												'name_card' =>  $name_card,
												'l_name' => "",
												'address_status' =>  "",
												'zip_status' =>  "",
												'cvv_status' =>  "",
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
						
											//print_r($data2); die(); 
				
												$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
												$data['resend'] = "";
												$item_name = json_encode($this->input->post('Item_Name'));
												$quantity = json_encode($this->input->post('Quantity'));
												$price = json_encode($this->input->post('Price'));
												$tax = json_encode($this->input->post('Tax_Amount'));
												$tax_id = json_encode($this->input->post('Tax'));
												$tax_per = json_encode($this->input->post('Tax_Per'));
												$total_amount = json_encode($this->input->post('Total_Amount'));
												$item_Detail_1 = array(
													"p_id" => $id2,
													"item_name" => ($item_name),  
													"quantity" => ($quantity),
													"price" => ($price),
													"tax" => ($tax),
													"tax_id" => ($tax_id),
													"tax_per" => ($tax_per),
													"total_amount" => ($total_amount),
							
												);
						
												$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
												$getDashboardData_m = $getDashboard_m->result_array();
												//print_r($getDashboardData_m); die();  
												$data2['getDashboardData_m'] = $getDashboardData_m;
												$data2['business_name'] = $getDashboardData_m[0]['business_name'];
												$data2['address1'] = $getDashboardData_m[0]['address1'];
												$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
												$data2['logo'] = $getDashboardData_m[0]['logo'];
												$data2['business_number'] = $getDashboardData_m[0]['business_number'];
												$data2['color'] = $getDashboardData_m[0]['color'];
												$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
												$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
												$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
												$data2['payment_type'] = 'recurring';
												$data2['recurring_type'] = $recurring_type;
												$data2['no_of_invoice'] = 1;
												$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
												$this->admin_model->insert_data("order_item", $item_Detail_1);
												$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
												$data2['item_detail'] = $item_Detail_1;  
														
												$data['msgData'] = $data2;
												$msg = $this->load->view('email/invoice', $data, true);
								
												
												
												$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
												$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
												"MIME-Version: 1.0" . "\r\n" .
												"Content-type: text/html; charset=UTF-8" . "\r\n";
												//echo $recurring_pay_start_date1; echo "<br/>"; echo $curdate;  die(); 
												if($recurring_pay_start_date1==$curdate)
												{    
														if(!empty($email_id)){ 
															$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
															$this->email->to($email_id);
															$this->email->subject($MailSubject);
															$this->email->message($msg);
															$m=$this->email->send();
															}
												}
												$this->db->where('id', $id);
												$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
												
												$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
												redirect(base_url('pos/all_customer_request_recurring'));
								}  else {  //  Unpaid Auto To Manual Change Update
										  //die(" Unpaid Auto To Manual Change Update");
										   
											   $recurring_pay_start_date1=$recurring_next_pay_date;
												$recurring_pay_start_date1=date($recurring_pay_start_date);     
												switch($recurring_type)
												{
													case 'daily':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'weekly':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'biweekly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
													break;
													case 'monthly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'quarterly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'yearly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
													break;
													default :
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break; 
												}
												
												
												$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
												$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
												$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
												$type=$getRow[0]['payment_type'];
												$paid=$getRow[0]['recurring_count_paid']; 
												$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
												///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
												$remain=($recurring_count >0)?$recurring_count:1; 
												$sub_total=$getRow[0]['sub_total']+$amount;
												//   start, stop,  complete
												if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
					
												$data2 = Array(
													'reference' => $reference,
													'name' => $name,
													'other_charges' => $other_charges,
                                                    'otherChargesName' => $other_charges_title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'recurring_payment' => $recurring_payment,
													'recurring_pay_start_date' => $recurring_pay_start_date1,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
					
											//print_r($data2); die("auto To Auto "); 
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
											$data['resend'] = "";
											$item_name = json_encode($this->input->post('Item_Name'));
											$quantity = json_encode($this->input->post('Quantity'));
											$price = json_encode($this->input->post('Price'));
											$tax = json_encode($this->input->post('Tax_Amount'));
											$tax_id = json_encode($this->input->post('Tax'));
											$tax_per = json_encode($this->input->post('Tax_Per'));
											$total_amount = json_encode($this->input->post('Total_Amount'));
											$item_Detail_1 = array(
												
												"item_name" => ($item_name),  
												"quantity" => ($quantity),
												"price" => ($price),
												"tax" => ($tax),
												"tax_id" => ($tax_id),
												"tax_per" => ($tax_per),
												"total_amount" => ($total_amount),
						
											);
											 //print_r($item_Detail_1);  die(); 
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
											$getDashboardData_m = $getDashboard_m->result_array();
											//print_r($getDashboardData_m); die();  
											$data2['getDashboardData_m'] = $getDashboardData_m;
											$data2['business_name'] = $getDashboardData_m[0]['business_name'];
											$data2['address1'] = $getDashboardData_m[0]['address1'];
											$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
											$data2['logo'] = $getDashboardData_m[0]['logo'];
											$data2['business_number'] = $getDashboardData_m[0]['business_number'];
											$data2['color'] = $getDashboardData_m[0]['color'];
											$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
											$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
											//$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										// echo $mn;  die(); 
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
											$data2['item_detail'] = $item_Detail_1;  
													
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											"MIME-Version: 1.0" . "\r\n" .
											"Content-type: text/html; charset=UTF-8" . "\r\n";

											//print_r($email_id.'---'.$recurring_next_pay_date.'----'.$curdate);  die("first "); 
											    if($recurring_pay_start_date1==$curdate) 
													{
														if(!empty($email_id)){ 
															$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
															$this->email->to($email_id);
															$this->email->subject($MailSubject);
															$this->email->message($msg);
															$m=$this->email->send();
															}
													}

											$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											redirect(base_url('pos/all_customer_request_recurring'));
									  
									}
									


								

							}
							else if($paytype=='1')  //    Auto  To Auto 
							{ 
								   if($getRow[0]['status']=='confirm' ||  $getRow[0]['status']=='Chargeback_Confirm')  {     //die("Auto  To Auto"); 
									   if($recurring_next_pay_date==$curdate)   //   Auto To Auto 
									   {
										   
											$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
											$card_type=$getRow[0]['card_type']; 
											$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
											$token_data = $getQuery_t->row_array();
											$paymentcard=$token_data['token'];

											  if($paymentcard)   //   if card are save 
											  {
                                                  //$transaction_id=$getRow[0]['transaction_id']; 
													$merchant_id=$getRow[0]['merchant_id']; 
													
													//$mobile_no=$getRow[0]['mobile_no'];
													$amount=$amount; 
													$account_id=$Merchantdata['account_id_cnp']; 
													$account_token=$Merchantdata['account_token_cnp']; 
													$acceptor_id=$Merchantdata['acceptor_id_cnp']; 
													$application_id=$Merchantdata['application_id_cnp']; 
													$terminal_id=$Merchantdata['terminal_id']; 
													$TicketNumber =  (rand(100000,999999)); 
													//$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
													$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
													$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>
													<Credentials>
													<AccountID>".$account_id."</AccountID>
													<AccountToken>".$account_token."</AccountToken>
													<AcceptorID>".$acceptor_id."</AcceptorID>
													</Credentials>
													<Application>
													<ApplicationID>".$application_id."</ApplicationID>
													<ApplicationVersion>2.2</ApplicationVersion>
													<ApplicationName>SaleQuick</ApplicationName>
													</Application>
													<Transaction>
													<TransactionAmount>".$amount."</TransactionAmount>
													<ReferenceNumber>84421174091</ReferenceNumber>
													<TicketNumber>".$TicketNumber."</TicketNumber>
													<MarketCode>3</MarketCode>
													<PaymentType>3</PaymentType>
													<SubmissionType>2</SubmissionType>
													<NetworkTransactionID>000001051388332</NetworkTransactionID>
													</Transaction>
													<Terminal>
													<TerminalID>".$terminal_id."</TerminalID>
													<CardPresentCode>3</CardPresentCode>
													<CardholderPresentCode>7</CardholderPresentCode>
													<CardInputCode>4</CardInputCode>
													<CVVPresenceCode>2</CVVPresenceCode>
													<TerminalCapabilityCode>5</TerminalCapabilityCode>
													<TerminalEnvironmentCode>6</TerminalEnvironmentCode>
													<MotoECICode>7</MotoECICode>
													</Terminal>
													<PaymentAccount>
													<PaymentAccountID>".$paymentcard."</PaymentAccountID>
													</PaymentAccount>
													</CreditCardSale>";       // data from the form, e.g. some ID number

													//print_r($xml_post_string); die();   
													$headers = array("Content-type: text/xml;charset=\"utf-8\"","Accept: text/xml",
													"Method:POST"
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
													$arrayy = json_decode($json,TRUE);
													//print_r($arrayy);  die("ok");
													curl_close($ch);
													if($arrayy['Response']['ExpressResponseMessage']=='Approved' )  
													{ 
														$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
														$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
														$card_a_type = $arrayy['Response']['Card']['CardLogo'];
														$message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
														$message_complete =  $arrayy['Response']['ExpressResponseMessage'];  
														//print_r($arrayy); die();
														$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
														$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
														$Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
														$Address ="";
														if(isset($arrayy['Response']['Address']['BillingAddress1']))
														{
														$Address =$arrayy['Response']['Address']['BillingAddress1'];
														}
														$Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
														$Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
														//die(); //2019-07-04 12:05:41
														$rt=$Tdate.' '.$Ttime;
														$transaction_date=date($rt); 
														if($message_complete=='Declined')
														{
														$staus = 'declined';
														}
														//elseif($message_a=='Approved' or $message_a=='Duplicate'
														elseif($message_complete=='Approved') 
														{ 
														$staus = 'confirm';  
														}
														else 
														{
														$staus = 'pending'; 
														}
														$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
														if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }

													
														$type=$getRow[0]['payment_type'];
												
														$paid=$getRow[0]['recurring_count_paid']+1; 

														$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;

														///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 

														$remain=($recurring_count >0)?$recurring_count-1:1; 
														
														$sub_total=$getRow[0]['sub_total']+$amount;
														
														//   start, stop,  complete
														if($remain <='0') 
														{
														$recurring_payment='complete'; 
														}
														else{
														$recurring_payment='start'; 
														}

														$today1 = date("Ymdhisu");
														$url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
														$unique = "PY" . $today1;
														$today2=date('Y-m-d'); 
														
														

														$recurring_pay_start_date1=$recurring_next_pay_date;
														$recurring_pay_start_date1=date($recurring_pay_start_date1); 
														switch($recurring_type)
														{
															case 'daily':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
															break;

															case 'weekly':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
															break;

															case 'biweekly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
															break;

															case 'monthly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
															break;

															case 'quarterly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
															break;

															case 'yearly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
															break;

															default :
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
															break; 
														}
														//print_r($recurring_pay_start_date);  die();
																$today2=date('Y-m-d'); 
																if($type=='recurring'){
								
																	$data2=$info2 = Array(
																		'reference' => $reference,
																		'name' => $name,
																		'other_charges' => $other_charges,
                                                                        'otherChargesName' => $other_charges_title,
																		'invoice_no' => $invoice_no,
																		'email_id' => $email_id,
																		'mobile_no' => $mobile_no,
																		'amount' => $amount,
																		'sub_total' => $sub_amount,
																		'tax' => $total_tax,
																		'fee' => $fee,
																		's_fee' => $fee_swap,
																		// 'title' => $title,
																		'detail' => $remark,
																		'note' => $note,
																		//'url' => $url,    /// 
																		'payment_type' => 'recurring',
																		'recurring_type' => $recurring_type,
																		'recurring_count' => $recurring_count1,
																		// 'due_date' => $row['due_date'],
																		'merchant_id' => $merchant_id,
																		'sub_merchant_id' => $sub_merchant_id,
																		//'payment_id'=>$unique,
																		'recurring_payment' => $recurring_payment,
																		
																		'recurring_pay_start_date' => $recurring_pay_start_date1,
																		'recurring_next_pay_date' => $recurring_next_pay_date,
																		'recurring_pay_type' => $paytype,

																		'status' => $staus,
																		'year' => $year,
																		'month' => $month,
																		'time1' => $time1,
																		'day1' => $day1,
																		'date_c' => $today2_a,
																		'payment_date' => $today2,
																		'recurring_count_paid' => $paid,   //fdgdfg
																		'recurring_count_remain' => $remain, //sfsfs
																		'transaction_id' => $trans_a_no,
																		'message' =>  $message_a,
																		'card_type' =>  $card_a_type,
																		'card_no' =>  $card_a_no,
																		'address' =>  $getRow[0]['address'],
																		'name_card' =>  $getRow[0]['name_card'],
																		'address_status' =>  $getRow[0]['address_status'],
																		'zip_status' =>  $getRow[0]['zip_status'],
																		'cvv_status' =>$getRow[0]['cvv_status'] ,
																		'ip_a' => $_SERVER['REMOTE_ADDR'],
																		'order_type' => 'a'
																	);
																}
															//print_r($info2);   die(); 
															$id1 = $this->admin_model->insert_data("customer_payment_request", $info2);
															//$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
															$data2['resend'] = "";
															$item_name = json_encode($this->input->post('Item_Name'));
															$quantity = json_encode($this->input->post('Quantity'));
															$price = json_encode($this->input->post('Price'));
															$tax = json_encode($this->input->post('Tax_Amount'));
															$tax_id = json_encode($this->input->post('Tax'));
															$tax_per = json_encode($this->input->post('Tax_Per'));
															$total_amount = json_encode($this->input->post('Total_Amount'));
															$item_Detail_1 = array(
																"p_id" => $id1,
																"item_name" => ($item_name),  
																"quantity" => ($quantity),
																"price" => ($price),
																"tax" => ($tax),
																"tax_id" => ($tax_id),
																"tax_per" => ($tax_per),
																"total_amount" => ($total_amount),
										
															);
															$this->admin_model->insert_data("order_item", $item_Detail_1);


															$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id1."' ");
															$getEmail = $getQuery->result_array();
															$data['getEmail'] = $getEmail;

															$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
															$getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
															$data['getEmail1'] = $getEmail1; 
															$data['resend'] = "";
													
															$email = $email_id;  $amount = $amount;   $sub_total =$sub_total; $tax = $this->input->post('Tax_Amount'); 
															$originalDate = $today2; $newDate = date("F d,Y", strtotime($originalDate)); 
															$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
															//Email Process
															$data['email'] = $email_id;
															$data['color'] = $Merchantdata['color'];
															$data['amount'] = $amount;  
															$data['sub_total'] = $sub_total;
															$data['tax'] = $this->input->post('Tax_Amount'); 
															$data['originalDate'] = $today2;
															$data['card_a_no'] = $card_a_no;
															$data['trans_a_no'] = $trans_a_no;
															$data['card_a_type'] = $card_a_type;
															$data['message_a'] = $message_a;
															$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
															$data['late_fee'] = $getEmail[0]['late_fee'];
															$data['payment_type'] = 'recurring';
															$data['recurring_type'] = $recurring_type;
															$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
															$data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
															$data['msgData'] = $data;
															$msg = $this->load->view('email/receipt', $data, true);
															$email = $email_id; 
															//echo  $email;   die("ok"); 
															$MailSubject = ' Receipt from '.$Merchantdata['business_dba_name']; 
															if(!empty($email)){ 
																$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
																$this->email->to($email);
																$this->email->subject($MailSubject);
																$this->email->message($msg);
																$this->email->send();
																}

															$url=$url;   
															$purl = str_replace('rpayment', 'reciept', $url); 
															// if(!empty($row['mobile_no']))
															// { 
															// $sms_reciever = $row['mobile_no'];
															     //// $sms_message = trim('Payment Receipt : '.$purl);
															//$sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
															// $from = '+18325324983'; //trial account twilio number
															// $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
															// $to = '+1'.$mob;
															// $response = $this->twilio->sms($from, $to,$sms_message);
															// }
															//print_r($token_data); die; 
															$save_notificationdata = array(
															'merchant_id'=>$merchant_id, 
															'name' => $name,
															'other_charges' => $other_charges,
                                                            'otherChargesName' => $other_charges_title,
															'mobile' => $mobile_no,
															'email' => $email_id,
															'card_type' =>  $card_a_type,
															'card_expiry_month'=> $token_data['card_expiry_month'],
															'card_expiry_year'=> $token_data['card_expiry_year'],
															'card_no' => $card_a_no,
															'amount'  =>$amount,
															'address' =>$address,
															'transaction_id'=>$trans_a_no,
															'transaction_date'=>$transaction_date,
															'notification_type' => 'payment',
															'invoice_no'=>$invoice_no,
															'status'   =>'unread'
															);
															//print_r($save_notificationdata); die(); 
															$this->db->insert('notification',$save_notificationdata);
															$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
								                            redirect(base_url('pos/all_customer_request_recurring'));

												}
												else
												{
													$id=$arrayy['Response']['ExpressResponseMessage']; 
													$this->session->set_flashdata('error', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> &nbsp;&nbsp;'.$id.'..'); 
													redirect(base_url('pos/all_customer_request_recurring'));
												}
												 
											   }
											   else    //   if card are not  save 
											    {      //die("no card Save "); 
													$recurring_pay_start_date1=$recurring_next_pay_date;
													$recurring_pay_start_date1=date($recurring_pay_start_date1); 
												switch($recurring_type)
												{
													case 'daily':
													  $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'weekly':
													  $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'biweekly':
													   $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
													break;
													case 'monthly':
													  $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'quarterly':
													  $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'yearly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
													break;
													default :
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break; 
												}
												$dfg = date("Ymdhisu");
												$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
												//$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
												$unique2 = "PY" . $dfg;
												$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
												$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
												$today2 = date("Y-m-d");  $year = date("Y"); $month = date("m");  $today3 = date("Y-m-d H:i:s");
												$type=$getRow[0]['payment_type'];
												$paid=$getRow[0]['recurring_count_paid']; 
												$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
												///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
												$remain=($recurring_count >0)?$recurring_count:1; 
												$sub_total=$getRow[0]['sub_total']+$amount;
												 //   start, stop,  complete
												if($remain <='0')  {  $recurring_payment='complete';  } else{ $recurring_payment='start';  }
												$data2 = Array(
													'reference' => $reference,
													'name' => $name,
													'other_charges' => $other_charges,
                                                    'otherChargesName' => $other_charges_title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'fee' => $fee,
													's_fee' => $fee_swap,
													// 'title' => $title,
													'detail' => $remark,
													'note' => $note,
													//'url' => $url2,
													'payment_type' => 'recurring',
													'recurring_type' => $recurring_type,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'merchant_id' => $merchant_id,
													'sub_merchant_id' => $sub_merchant_id,
													//'payment_id' => $unique2,
													'recurring_payment' => $recurring_payment,
							
													'recurring_pay_start_date' => $recurring_pay_start_date1,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													
													'status' => 'pending',
													'year' => $year,
													'month' => $month,
													'time1' => $time1,
													'day1' => $day1,
													'date_c' => $today2_a,
													'payment_date' => "",
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'transaction_id' => "",
													'message' =>  "",
													'card_type' =>$getRow[0]['card_type'],
													'card_no' =>  '',
													'sign' =>  "",
													'address' =>  $address,
													'name_card' =>  $name_card,
													'l_name' => "",
													'address_status' =>  "",
													'zip_status' =>  "",
													'cvv_status' =>  "",
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
							
												   //print_r($data2); die(); 
					
													$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
													$data['resend'] = "";
													$item_name = json_encode($this->input->post('Item_Name'));
													$quantity = json_encode($this->input->post('Quantity'));
													$price = json_encode($this->input->post('Price'));
													$tax = json_encode($this->input->post('Tax_Amount'));
													$tax_id = json_encode($this->input->post('Tax'));
													$tax_per = json_encode($this->input->post('Tax_Per'));
													$total_amount = json_encode($this->input->post('Total_Amount'));
													$item_Detail_1 = array(
														"p_id" => $id2,
														"item_name" => ($item_name),  
														"quantity" => ($quantity),
														"price" => ($price),
														"tax" => ($tax),
														"tax_id" => ($tax_id),
														"tax_per" => ($tax_per),
														"total_amount" => ($total_amount),
								
													);
							
													$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
													$getDashboardData_m = $getDashboard_m->result_array();
													//print_r($getDashboardData_m); die();  
													$data2['getDashboardData_m'] = $getDashboardData_m;
													$data2['business_name'] = $getDashboardData_m[0]['business_name'];
													$data2['address1'] = $getDashboardData_m[0]['address1'];
													$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
													$data2['logo'] = $getDashboardData_m[0]['logo'];
													$data2['business_number'] = $getDashboardData_m[0]['business_number'];
													$data2['color'] = $getDashboardData_m[0]['color'];
													$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
													$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
													$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
													$data2['payment_type'] = 'recurring';
													$data2['recurring_type'] = $recurring_type;
													$data2['no_of_invoice'] = 1;
													$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
													$this->admin_model->insert_data("order_item", $item_Detail_1);
													$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
													$data2['item_detail'] = $item_Detail_1;  
															  
													 $data['msgData'] = $data2;
													 $msg = $this->load->view('email/invoice', $data, true);
									
													
													 
													 $MailSubject = '  Invoice from '.$getDashboardData_m[0]['business_dba_name'];
													 $header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
													   "MIME-Version: 1.0" . "\r\n" .
													   "Content-type: text/html; charset=UTF-8" . "\r\n";
													   //echo $recurring_pay_start_date1; echo "<br/>"; echo $curdate;  die(); 
															if(!empty($email_id)){ 
																$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
																$this->email->to($email_id);
																$this->email->subject($MailSubject);
																$this->email->message($msg);
																$m=$this->email->send();
																}
													 $this->db->where('id', $id);
													 $updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
													 
													 $this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
													 redirect(base_url('pos/all_customer_request_recurring'));
											    }  //  End Of No Card Save Condition 
									   }
									   else    ///    auto to auto   :: next Pay Date!=today    
									   {
											  // die(" Auto To Auto  next date != Today "); 
											   ///$recurring_pay_start_date1=$recurring_next_pay_date;
												// $recurring_pay_start_date1=date($recurring_pay_start_date);     
												// switch($recurring_type)
												// {
												// 	case 'daily':
												// 	$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'weekly':
												// 	$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'biweekly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'monthly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'quarterly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'yearly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	default :
												// 		$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												// 	break; 
												// }
												
												
												$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
												$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
												$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
												$type=$getRow[0]['payment_type'];
												$paid=$getRow[0]['recurring_count_paid']; 
												$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
												///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
												$remain=($recurring_count >0)?$recurring_count:1; 
												$sub_total=$getRow[0]['sub_total']+$amount;
												//   start, stop,  complete
												if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
					
												$data2 = Array(
													'reference' => $reference,
													'name' => $name,
													'other_charges' => $other_charges,
                                                    'otherChargesName' => $other_charges_title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'recurring_payment' => $recurring_payment,
													'recurring_pay_start_date' => $recurring_pay_start_date,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
					
											//print_r($data2); die("auto To Auto "); 
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
											$data['resend'] = "";
											$item_name = json_encode($this->input->post('Item_Name'));
											$quantity = json_encode($this->input->post('Quantity'));
											$price = json_encode($this->input->post('Price'));
											$tax = json_encode($this->input->post('Tax_Amount'));
											$tax_id = json_encode($this->input->post('Tax'));
											$tax_per = json_encode($this->input->post('Tax_Per'));
											$total_amount = json_encode($this->input->post('Total_Amount'));
											$item_Detail_1 = array(
												
												"item_name" => ($item_name),  
												"quantity" => ($quantity),
												"price" => ($price),
												"tax" => ($tax),
												"tax_id" => ($tax_id),
												"tax_per" => ($tax_per),
												"total_amount" => ($total_amount),
						
											);
											 //print_r($item_Detail_1);  die(); 
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
											$getDashboardData_m = $getDashboard_m->result_array();
											//print_r($getDashboardData_m); die();  
											$data2['getDashboardData_m'] = $getDashboardData_m;
											$data2['business_name'] = $getDashboardData_m[0]['business_name'];
											$data2['address1'] = $getDashboardData_m[0]['address1'];
											$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
											$data2['logo'] = $getDashboardData_m[0]['logo'];
											$data2['business_number'] = $getDashboardData_m[0]['business_number'];
											$data2['color'] = $getDashboardData_m[0]['color'];
											$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
											$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
											//$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										 //  echo $mn;  die(); 
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
											$data2['item_detail'] = $item_Detail_1;  
													
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											"MIME-Version: 1.0" . "\r\n" .
											"Content-type: text/html; charset=UTF-8" . "\r\n";
													// if(!empty($email_id)){ 
													// 	$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
													// 	$this->email->to($email_id);
													// 	$this->email->subject($MailSubject);
													// 	$this->email->message($msg);
													// 	$m=$this->email->send();
													// 	}

											$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											redirect(base_url('pos/all_customer_request_recurring'));
									   }  //   And of Auto to Auto 

									}
									else if($getRow[0]['status']=='pending') { //die("Auto To Auto:  pending payment ");

                                        if($recurring_next_pay_date==$curdate)  {  //die("Auto To Auto:  pending payment  :  Unpid  paydate==current date ");
											$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
											$card_type=$getRow[0]['card_type']; 
											$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
											//echo $this->db->last_query();   die();
											$token_data = $getQuery_t->row_array();
											$paymentcard=$token_data['token'];
		
											  if($paymentcard == "" ){  //die("Auto to auto  pending Payment :: unpaid  : pay date == current date :and   no card here  "); 
														//die("hi Am here"); 
														$recurring_pay_start_date1=$recurring_next_pay_date;
														$recurring_pay_start_date1=date($recurring_pay_start_date);     
														switch($recurring_type)
														{
															case 'daily':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
															break;
															case 'weekly':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
															break;
															case 'biweekly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
															break;
															case 'monthly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
															break;
															case 'quarterly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
															break;
															case 'yearly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
															break;
															default :
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
															break; 
														}
														
														
														$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
														$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
														$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
														$type=$getRow[0]['payment_type'];
														$paid=$getRow[0]['recurring_count_paid']; 
														$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
														///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
														$remain=($recurring_count >0)?$recurring_count:1; 
														$sub_total=$getRow[0]['sub_total']+$amount;
														//   start, stop,  complete
														if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
							
														$data2 = Array(
															'reference' => $reference,
															'name' => $name,
															'other_charges' => $other_charges,
                                                            'otherChargesName' => $other_charges_title,
															'invoice_no' => $invoice_no,
															'email_id' => $email_id,
															'mobile_no' => $mobile_no,
															'amount' => $amount,
															'sub_total' => $sub_amount,
															'tax' => $total_tax,
															'url'=>$getRow[0]['url'],
															'date_c'=>$getRow[0]['date_c'],
															'payment_type' => $type,
															'recurring_type' => $recurring_type,
															'recurring_count' => $recurring_count1,
															// 'due_date' => $due_date,
															'recurring_payment' => $recurring_payment,
															'recurring_pay_start_date' => $recurring_pay_start_date1,
															'recurring_next_pay_date' => $recurring_next_pay_date,
															'recurring_pay_type' => $paytype,
															'recurring_count_paid' => $paid,
															'recurring_count_remain' => $remain, 
															'ip_a' => $_SERVER['REMOTE_ADDR'],
															'order_type' => 'a'
														);
							
													//print_r($data2); die("auto To Auto "); 
													$this->db->where('id', $id);
													$updateresult=$this->db->update('customer_payment_request',$data2);
													$data['resend'] = "";
													$item_name = json_encode($this->input->post('Item_Name'));
													$quantity = json_encode($this->input->post('Quantity'));
													$price = json_encode($this->input->post('Price'));
													$tax = json_encode($this->input->post('Tax_Amount'));
													$tax_id = json_encode($this->input->post('Tax'));
													$tax_per = json_encode($this->input->post('Tax_Per'));
													$total_amount = json_encode($this->input->post('Total_Amount'));
													$item_Detail_1 = array(
														
														"item_name" => ($item_name),  
														"quantity" => ($quantity),
														"price" => ($price),
														"tax" => ($tax),
														"tax_id" => ($tax_id),
														"tax_per" => ($tax_per),
														"total_amount" => ($total_amount),
								
													);
													//print_r($item_Detail_1);  die(); 
													$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_periodFROM merchant WHERE id = '" . $merchant_id . "' ");
													$getDashboardData_m = $getDashboard_m->result_array();
													//print_r($getDashboardData_m); die();  
													$data2['getDashboardData_m'] = $getDashboardData_m;
													$data2['business_name'] = $getDashboardData_m[0]['business_name'];
													$data2['address1'] = $getDashboardData_m[0]['address1'];
													$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
													$data2['logo'] = $getDashboardData_m[0]['logo'];
													$data2['business_number'] = $getDashboardData_m[0]['business_number'];
													$data2['color'] = $getDashboardData_m[0]['color'];
													$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
													$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
													$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
													$data2['payment_type'] = 'recurring';
													$data2['recurring_type'] = $recurring_type;
													$data2['no_of_invoice'] = 1;
													$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
													//$this->admin_model->insert_data("order_item", $item_Detail_1);
													$this->db->where('p_id', $id);
													$mn=$update=$this->db->update('order_item',$item_Detail_1);
												// echo $mn;  die(); 
													$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
													$data2['item_detail'] = $item_Detail_1; 
													$data['msgData'] = $data2;
													$msg = $this->load->view('email/invoice', $data, true);
													//echo $msg; die();
													$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
													$header = "From: ".$getDashboardData_m[0]['business_dba_name']. "<info@salequick.com >\r\n" .
													"MIME-Version: 1.0" . "\r\n" .
													"Content-type: text/html; charset=UTF-8" . "\r\n";
													//print_r($email_id.'----'.$recurring_pay_start_date1.'----'.$curdate); die(); 
														if($recurring_pay_start_date1==$curdate) 
															{
																if(!empty($email_id)){ 
																	$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
																	$this->email->to($email_id);
																	$this->email->subject($MailSubject);
																	$this->email->message($msg);
																	$m=$this->email->send();
																	}
															}
													 
													$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
													redirect(base_url('pos/all_customer_request_recurring'));
												  
											}
											else {   //die("Auto    to auto  pending Payment :: unpaid  : pay date == current date :and   card are save here  "); 
														
													  //print_r( $Merchantdata['color']);  die(); 
													   $merchant_id=$getRow[0]['merchant_id']; 
																	
														//$mobile_no=$getRow[0]['mobile_no'];
													    $amount=$amount; 
		
														$account_id=$Merchantdata['account_id_cnp']; 
														$account_token=$Merchantdata['account_token_cnp']; 
														$acceptor_id=$Merchantdata['acceptor_id_cnp']; 
														$application_id=$Merchantdata['application_id_cnp']; 
														$terminal_id=$Merchantdata['terminal_id']; 
														$TicketNumber =  (rand(100000,999999)); 
														//$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
														$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
														$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>
														<Credentials>
														<AccountID>".$account_id."</AccountID>
														<AccountToken>".$account_token."</AccountToken>
														<AcceptorID>".$acceptor_id."</AcceptorID>
														</Credentials>
														<Application>
														<ApplicationID>".$application_id."</ApplicationID>
														<ApplicationVersion>2.2</ApplicationVersion>
														<ApplicationName>SaleQuick</ApplicationName>
														</Application>
														<Transaction>
														<TransactionAmount>".$amount."</TransactionAmount>
														<ReferenceNumber>84421174091</ReferenceNumber>
														<TicketNumber>".$TicketNumber."</TicketNumber>
														<MarketCode>3</MarketCode>
														<PaymentType>3</PaymentType>
														<SubmissionType>2</SubmissionType>
														<NetworkTransactionID>000001051388332</NetworkTransactionID>
														</Transaction>
														<Terminal>
														<TerminalID>".$terminal_id."</TerminalID>
														<CardPresentCode>3</CardPresentCode>
														<CardholderPresentCode>7</CardholderPresentCode>
														<CardInputCode>4</CardInputCode>
														<CVVPresenceCode>2</CVVPresenceCode>
														<TerminalCapabilityCode>5</TerminalCapabilityCode>
														<TerminalEnvironmentCode>6</TerminalEnvironmentCode>
														<MotoECICode>7</MotoECICode>
														</Terminal>
														<PaymentAccount>
														<PaymentAccountID>".$paymentcard."</PaymentAccountID>
														</PaymentAccount>
														</CreditCardSale>";       // data from the form, e.g. some ID number
		
														//print_r($xml_post_string); die();   
														$headers = array("Content-type: text/xml;charset=\"utf-8\"","Accept: text/xml",
														"Method:POST"
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
														$arrayy = json_decode($json,TRUE);
														//print_r($arrayy);  die("ok");
														curl_close($ch);
														if($arrayy['Response']['ExpressResponseMessage']=='Approved' )  
														{ 
															$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
															$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
															$card_a_type = $arrayy['Response']['Card']['CardLogo'];
															$message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
															$message_complete =  $arrayy['Response']['ExpressResponseMessage'];  
															//print_r($arrayy); die();
															$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
															$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
															$Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
															$Address ="";
															if(isset($arrayy['Response']['Address']['BillingAddress1']))
															{
															$Address =$arrayy['Response']['Address']['BillingAddress1'];
															}
															$Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
															$Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
															//die(); //2019-07-04 12:05:41
															$rt=$Tdate.' '.$Ttime;
															$transaction_date=date($rt); 
															if($message_complete=='Declined')
															{
															$staus = 'declined';
															}
															//elseif($message_a=='Approved' or $message_a=='Duplicate'
															elseif($message_complete=='Approved') 
															{ 
															$staus = 'confirm';  
															}
															else 
															{
															$staus = 'pending'; 
															}
															$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
															if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }
		
														
															$type=$getRow[0]['payment_type'];
													
															$paid=$getRow[0]['recurring_count_paid']+1; 
		
															$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
		
															///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
		
															$remain=($recurring_count >0)?$recurring_count-1:1; 
															
															$sub_total=$getRow[0]['sub_total']+$amount;
															
															//   start, stop,  complete
															if($remain <='0') 
															{
															$recurring_payment='complete'; 
															}
															else{
															$recurring_payment='start'; 
															}
		
															$today1 = date("Ymdhisu");
															//$url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
															///$unique = "PY" . $today1;
															$today2=date('Y-m-d'); 
															
															
		
															$recurring_pay_start_date1=$recurring_next_pay_date;
															$recurring_pay_start_date1=date($recurring_pay_start_date1); 
															switch($recurring_type)
															{
																case 'daily':
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
																break;
		
																case 'weekly':
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
																break;
		
																case 'biweekly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
																break;
		
																case 'monthly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
																break;
		
																case 'quarterly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
																break;
		
																case 'yearly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
																break;
		
																default :
																	$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
																break; 
															}
															//print_r($recurring_pay_start_date);  die();
																	$today2=date('Y-m-d'); 
																	if($type=='recurring'){
									
																		$data2=$info2 = Array(
																			'reference' => $reference,
																			'name' => $name,
																			'other_charges' => $other_charges,
                                                                            'otherChargesName' => $other_charges_title,
																			'invoice_no' => $invoice_no,
																			'email_id' => $email_id,
																			'mobile_no' => $mobile_no,
																			'amount' => $amount,
																			'sub_total' => $sub_amount,
																			'tax' => $total_tax,
																			'fee' => $fee,
																			's_fee' => $fee_swap,
																			'payment_type' => $type,
																			'recurring_type' => $recurring_type,
																			'recurring_count' => $recurring_count1,
																			'merchant_id' => $merchant_id,
																			'sub_merchant_id' => $sub_merchant_id,
																			'recurring_payment' => $recurring_payment,
																			'recurring_pay_start_date' => $recurring_pay_start_date1,
																			'recurring_next_pay_date' => $recurring_next_pay_date,
																			'recurring_pay_type' => $paytype,
																			'status' => $staus,
																			'year' => $year,
																			'month' => $month,
																			'time1' => $time1,
																			'day1' => $day1,
																			'date_c' => $today2_a,
																			'payment_date' => $today2,
																			'recurring_count_paid' => $paid,   //fdgdfg
																			'recurring_count_remain' => $remain, //sfsfs
																			'transaction_id' => $trans_a_no,
																			'message' =>  $message_a,
																			'card_type' =>  $card_a_type,
																			'card_no' =>  $card_a_no,
																			'address' =>  $getRow[0]['address'],
																			'name_card' =>  $getRow[0]['name_card'],
																			'address_status' =>  $getRow[0]['address_status'],
																			'zip_status' =>  $getRow[0]['zip_status'],
																			'cvv_status' =>$getRow[0]['cvv_status'] ,
																			'ip_a' => $_SERVER['REMOTE_ADDR'],
																			'order_type' => 'a'
																			
																		);
																	}
		
																$this->db->where('id', $id);
																$updateresult=$this->db->update('customer_payment_request',$data2);
																$data2['resend'] = "";
																$item_name = json_encode($this->input->post('Item_Name'));
																$quantity = json_encode($this->input->post('Quantity'));
																$price = json_encode($this->input->post('Price'));
																$tax = json_encode($this->input->post('Tax_Amount'));
																$tax_id = json_encode($this->input->post('Tax'));
																$tax_per = json_encode($this->input->post('Tax_Per'));
																$total_amount = json_encode($this->input->post('Total_Amount'));
																$item_Detail_1 = array(
																	
																	"item_name" => ($item_name),  
																	"quantity" => ($quantity),
																	"price" => ($price),
																	"tax" => ($tax),
																	"tax_id" => ($tax_id),
																	"tax_per" => ($tax_per),
																	"total_amount" => ($total_amount),
											
																);
																$this->db->where('p_id', $id);
																$upd=$this->db->update('order_item',$item_Detail_1);
		
																$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
																$getEmail = $getQuery->result_array();
																$data['getEmail'] = $getEmail;
		
																$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
																$getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
																$data['getEmail1'] = $getEmail1; 
																$data['resend'] = "";
														
																$email = $email_id;  $amount = $amount;   $sub_total =$sub_total; $tax = $this->input->post('Tax_Amount'); 
																$originalDate = $today2; $newDate = date("F d,Y", strtotime($originalDate)); 
																$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
																//Email Process
																$data['email'] = $email_id;
																$data['color'] = $Merchantdata['color'];
																$data['amount'] = $amount;  
																$data['sub_total'] = $sub_total;
																$data['tax'] = $this->input->post('Tax_Amount'); 
																$data['originalDate'] = $today2;
																$data['card_a_no'] = $card_a_no;
																$data['trans_a_no'] = $trans_a_no;
																$data['card_a_type'] = $card_a_type;
																$data['message_a'] = $message_a;
																$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
																$data['late_fee'] = $getEmail[0]['late_fee'];
																$data['payment_type'] = 'recurring';
																$data['recurring_type'] = $recurring_type;
																$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
																$data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
																$data['msgData'] = $data;
																$msg = $this->load->view('email/receipt', $data, true);
																$email = $email_id; 
																//echo  $email;   die("ok"); 
																$MailSubject = ' Receipt from '.$Merchantdata['business_dba_name']; 
																if(!empty($email)){ 
																	$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
																	$this->email->to($email);
																	$this->email->subject($MailSubject);
																	$this->email->message($msg);
																	$this->email->send();
																	}
		
																$url=$url;   
																$purl = str_replace('rpayment', 'reciept', $url); 
																// if(!empty($row['mobile_no']))
																// { 
																// $sms_reciever = $row['mobile_no'];
																// $sms_message = trim('Payment Receipt : '.$purl);
																// $from = '+18325324983'; //trial account twilio number
																// $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
																// $to = '+1'.$mob;
																// $response = $this->twilio->sms($from, $to,$sms_message);
																// }
																//print_r($token_data); die; 
																$save_notificationdata = array(
																'merchant_id'=>$merchant_id, 
																'name' => $name,
																'other_charges' => $other_charges,
                                                                'otherChargesName' => $other_charges_title,
																'mobile' => $mobile_no,
																'email' => $email_id,
																'card_type' =>  $card_a_type,
																'card_expiry_month'=> $token_data['card_expiry_month'],
																'card_expiry_year'=> $token_data['card_expiry_year'],
																'card_no' => $card_a_no,
																'amount'  =>$amount,
																'address' =>$address,
																'transaction_id'=>$trans_a_no,
																'transaction_date'=>$transaction_date,
																'notification_type' => 'payment',
																'invoice_no'=>$invoice_no,
																'status'   =>'unread'
																);
																//print_r($save_notificationdata); die(); 
																$this->db->insert('notification',$save_notificationdata);
																$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
																redirect(base_url('pos/all_customer_request_recurring'));
		
													}
													else
													{
														$id=$arrayy['Response']['ExpressResponseMessage']; 
														$this->session->set_flashdata('error', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> &nbsp;&nbsp;'.$id.'..'); 
														redirect(base_url('pos/all_customer_request_recurring'));
													}
												}     //  End Of the Card Save or  No Card :: Both  condition are end here       
										} 
										else{   //die("Auto To Auto:  pending payment  :  Unpid ::  Pay date !=  current date  ");
											
												$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
												$card_type=$getRow[0]['card_type']; 
												$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
												$token_data = $getQuery_t->row_array();
												$paymentcard=$token_data['token']; 
		
											  if($paymentcard == "") { //die(" haaa hh Auto to auto pending payment : unpaid :: pay date  != current date :: and there are no card here "); 
															
															$recurring_pay_start_date1=$recurring_next_pay_date;
															$recurring_pay_start_date1=date($recurring_pay_start_date);     
															switch($recurring_type)
															{
																case 'daily':
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
																break;
																case 'weekly':
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
																break;
																case 'biweekly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
																break;
																case 'monthly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
																break;
																case 'quarterly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
																break;
																case 'yearly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
																break;
																default :
																	$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
																break; 
															}
															
															
															$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
															$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
															$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
															$type=$getRow[0]['payment_type'];
															$paid=$getRow[0]['recurring_count_paid']; 
															$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
															///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
															$remain=($recurring_count >0)?$recurring_count:1; 
															$sub_total=$getRow[0]['sub_total']+$amount;
															//   start, stop,  complete
															if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
								
															$data2 = Array(
																'reference' => $reference,
																'name' => $name,
																'other_charges' => $other_charges,
                                                                'otherChargesName' => $other_charges_title,
																'invoice_no' => $invoice_no,
																'email_id' => $email_id,
																'mobile_no' => $mobile_no,
																'amount' => $amount,
																'sub_total' => $sub_amount,
																'tax' => $total_tax,
																'url'=>$getRow[0]['url'],
																'date_c'=>$getRow[0]['date_c'],
																'payment_type' => $type,
																'recurring_type' => $recurring_type,
																'recurring_count' => $recurring_count1,
																// 'due_date' => $due_date,
																'recurring_payment' => $recurring_payment,
																'recurring_pay_start_date' => $recurring_pay_start_date1,
																'recurring_next_pay_date' => $recurring_next_pay_date,
																'recurring_pay_type' => $paytype,
																'recurring_count_paid' => $paid,
																'recurring_count_remain' => $remain, 
																'ip_a' => $_SERVER['REMOTE_ADDR'],
																'order_type' => 'a'
															);
								
														//print_r($data2); die("auto To Auto "); 

														$this->db->where('id', $id);
														$updateresult=$this->db->update('customer_payment_request',$data2);
														$data['resend'] = "";
														$item_name = json_encode($this->input->post('Item_Name'));
														$quantity = json_encode($this->input->post('Quantity'));
														$price = json_encode($this->input->post('Price'));
														$tax = json_encode($this->input->post('Tax_Amount'));
														$tax_id = json_encode($this->input->post('Tax'));
														$tax_per = json_encode($this->input->post('Tax_Per'));
														$total_amount = json_encode($this->input->post('Total_Amount'));
														$item_Detail_1 = array(
															
															"item_name" => ($item_name),  
															"quantity" => ($quantity),
															"price" => ($price),
															"tax" => ($tax),
															"tax_id" => ($tax_id),
															"tax_per" => ($tax_per),
															"total_amount" => ($total_amount),
									
														);
														//print_r($item_Detail_1);  die(); 
														$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
														$getDashboardData_m = $getDashboard_m->result_array();
														//print_r($getDashboardData_m); die();  
														$data2['getDashboardData_m'] = $getDashboardData_m;
														$data2['business_name'] = $getDashboardData_m[0]['business_name'];
														$data2['address1'] = $getDashboardData_m[0]['address1'];
														$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
														$data2['logo'] = $getDashboardData_m[0]['logo'];
														$data2['business_number'] = $getDashboardData_m[0]['business_number'];
														$data2['color'] = $getDashboardData_m[0]['color'];
														$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
														$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
														$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
														$data2['payment_type'] = 'recurring';
														$data2['recurring_type'] = $recurring_type;
														$data2['no_of_invoice'] = 1;
														$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
														//$this->admin_model->insert_data("order_item", $item_Detail_1);
														$this->db->where('p_id', $id);
														$mn=$update=$this->db->update('order_item',$item_Detail_1);
													// echo $mn;  die(); 
														$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
														$data2['item_detail'] = $item_Detail_1;  
																
														$data['msgData'] = $data2;
														$msg = $this->load->view('email/invoice', $data, true);
														
														$MailSubject = ' Invoice from  '.$getDashboardData_m[0]['business_dba_name'];
														$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
														"MIME-Version: 1.0" . "\r\n" .
														"Content-type: text/html; charset=UTF-8" . "\r\n";
														//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$curdate); die(); 
															if($recurring_pay_start_date1==$curdate) 
																{
																	if(!empty($email_id)){ 
																		$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
																		$this->email->to($email_id);
																		$this->email->subject($MailSubject);
																		$this->email->message($msg);
																		$m=$this->email->send();
																		}
																}
														
														$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
														redirect(base_url('pos/all_customer_request_recurring'));
											  }
											  else  
											{  //die("Auto to auto pending payment : unpaid :: pay date  != current date :: and there are save card here "); 
														//die("okui");
														//$recurring_pay_start_date1=$recurring_next_pay_date;
														// $recurring_pay_start_date1=date($recurring_pay_start_date);     
														// switch($recurring_type)
														// {  
														// 	case 'daily':
														// 	$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
														// 	break;
														// 	case 'weekly':
														// 	$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
														// 	break;
														// 	case 'biweekly':
														// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
														// 	break;
														// 	case 'monthly':
														// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
														// 	break;
														// 	case 'quarterly':
														// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
														// 	break;
														// 	case 'yearly':
														// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
														// 	break;
														// 	default :
														// 		$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
														// 	break; 
														// }
														
														
														$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
														$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
														$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
														$type=$getRow[0]['payment_type'];
														$paid=$getRow[0]['recurring_count_paid']; 
														$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
														///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
														$remain=($recurring_count >0)?$recurring_count:1; 
														$sub_total=$getRow[0]['sub_total']+$amount;
														//   start, stop,  complete
														if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
							
														$data2 = Array(
															'reference' => $reference,
															'name' => $name,
															'other_charges' => $other_charges,
                                                            'otherChargesName' => $other_charges_title,
															'invoice_no' => $invoice_no,
															'email_id' => $email_id,
															'mobile_no' => $mobile_no,
															'amount' => $amount,
															'sub_total' => $sub_amount,
															'tax' => $total_tax,
															'url'=>$getRow[0]['url'],
															'date_c'=>$getRow[0]['date_c'],
															'payment_type' => $type,
															'recurring_type' => $recurring_type,
															'recurring_count' => $recurring_count1,
															// 'due_date' => $due_date,
															'recurring_payment' => $recurring_payment,
															//'recurring_pay_start_date' => $recurring_pay_start_date,
															'recurring_next_pay_date' => $recurring_next_pay_date,
															'recurring_pay_type' => $paytype,
															'recurring_count_paid' => $paid,
															'recurring_count_remain' => $remain, 
															'ip_a' => $_SERVER['REMOTE_ADDR'],
															'order_type' => 'a'
														);
							
													//print_r($data2); die("auto To Auto "); 

													$this->db->where('id', $id);
													$updateresult=$this->db->update('customer_payment_request',$data2);
													$data['resend'] = "";
													$item_name = json_encode($this->input->post('Item_Name'));
													$quantity = json_encode($this->input->post('Quantity'));
													$price = json_encode($this->input->post('Price'));
													$tax = json_encode($this->input->post('Tax_Amount'));
													$tax_id = json_encode($this->input->post('Tax'));
													$tax_per = json_encode($this->input->post('Tax_Per'));
													$total_amount = json_encode($this->input->post('Total_Amount'));
													$item_Detail_1 = array(
														
														"item_name" => ($item_name),  
														"quantity" => ($quantity),
														"price" => ($price),
														"tax" => ($tax),
														"tax_id" => ($tax_id),
														"tax_per" => ($tax_per),
														"total_amount" => ($total_amount),
								
													);
													//print_r($item_Detail_1);  die(); 
													$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
													$getDashboardData_m = $getDashboard_m->result_array();
													//print_r($getDashboardData_m); die();  
													$data2['getDashboardData_m'] = $getDashboardData_m;
													$data2['business_name'] = $getDashboardData_m[0]['business_name'];
													$data2['address1'] = $getDashboardData_m[0]['address1'];
													$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
													$data2['logo'] = $getDashboardData_m[0]['logo'];
													$data2['business_number'] = $getDashboardData_m[0]['business_number'];
													$data2['color'] = $getDashboardData_m[0]['color'];
													$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
													$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
													$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
													$data2['payment_type'] = 'recurring';
													$data2['recurring_type'] = $recurring_type;
													$data2['no_of_invoice'] = 1;
													$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
													//$this->admin_model->insert_data("order_item", $item_Detail_1);
													$this->db->where('p_id', $id);
													$mn=$update=$this->db->update('order_item',$item_Detail_1);
												// echo $mn;  die(); 
													$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
													$data2['item_detail'] = $item_Detail_1;  
															
													$data['msgData'] = $data2; 
													$msg = $this->load->view('email/invoice', $data, true);
													
													$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
													$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
													"MIME-Version: 1.0" . "\r\n" .
													"Content-type: text/html; charset=UTF-8" . "\r\n";
													//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$curdate); die(); 
														if($recurring_next_pay_date==$curdate) 
															{
																if(!empty($email_id)){ 
																	$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
																	$this->email->to($email_id);
																	$this->email->subject($MailSubject);
																	$this->email->message($msg);
																	$m=$this->email->send();
																	}
															}
													
													$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
													redirect(base_url('pos/all_customer_request_recurring')); 
											}   ///  End Of the  Auto to auto : with all cases here
										}
									}
									
							}
						}
						else if($getRow[0]['recurring_pay_type']=='0')  //  Manual
						{
							if($paytype=='1')  ///   Manual To Auto
							{
								//die("Manual To Auto"); 
								if($getRow[0]['status']=='confirm' ||  $getRow[0]['status']=='Chargeback_Confirm')  {      //die("Manual To Auto:  confirm payment ");  
									if($recurring_next_pay_date==$curdate) {   //die("Manual To Auto:  confirm payment :: next date== current date"); 
										$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
										$card_type=$getRow[0]['card_type']; 
										$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
										$token_data = $getQuery_t->row_array();
										$paymentcard=$token_data['token'];

										if($paymentcard == "") { //die('Manual To Auto:  confirm payment :: next date == current date ::  no card  save ');
											$recurring_pay_start_date1=$recurring_next_pay_date;
											$recurring_pay_start_date1=date($recurring_pay_start_date1); 
										switch($recurring_type)
										{
											case 'daily':
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
											break;
											case 'weekly':
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
											break;
											case 'biweekly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
											break;
											case 'monthly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
											break;
											case 'quarterly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
											break;
											case 'yearly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
											break;
											default :
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
											break; 
										}
										$dfg = date("Ymdhisu");
										$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
										//$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
										$unique2 = "PY" . $dfg;
										$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
										$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
										$today2 = date("Y-m-d");  $year = date("Y"); $month = date("m");  $today3 = date("Y-m-d H:i:s");
										$type=$getRow[0]['payment_type'];
										$paid=$getRow[0]['recurring_count_paid']; 
										$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
										///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
										$remain=($recurring_count >0)?$recurring_count:1; 
										$sub_total=$getRow[0]['sub_total']+$amount;
										//   start, stop,  complete
										if($remain <='0')  {  $recurring_payment='complete';  } else{ $recurring_payment='start';  }
										$data2 = Array(
											'reference' => $reference,
											'name' => $name,
											'other_charges' => $other_charges,
                                            'otherChargesName' => $other_charges_title,
											'invoice_no' => $invoice_no,
											'email_id' => $email_id,
											'mobile_no' => $mobile_no,
											'amount' => $amount,
											'sub_total' => $sub_amount,
											'tax' => $total_tax,
											'fee' => $fee,
											's_fee' => $fee_swap,
											// 'title' => $title,
											'detail' => $remark,
											'note' => $note,
											//'url' => $url2,
											'payment_type' => 'recurring',
											'recurring_type' => $recurring_type,
											'recurring_count' => $recurring_count1,
											// 'due_date' => $due_date,
											'merchant_id' => $merchant_id,
											'sub_merchant_id' => $sub_merchant_id,
											//'payment_id' => $unique2,
											'recurring_payment' => $recurring_payment,
					
											'recurring_pay_start_date' => $recurring_pay_start_date1,
											'recurring_next_pay_date' => $recurring_next_pay_date,
											'recurring_pay_type' => $paytype,
											
											'status' => 'pending',
											'year' => $year,
											'month' => $month,
											'time1' => $time1,
											'day1' => $day1,
											'date_c' => $today2_a,
											'payment_date' => "",
											'recurring_count_paid' => $paid,
											'recurring_count_remain' => $remain, 
											'transaction_id' => "",
											'message' =>  "",
											'card_type' =>$getRow[0]['card_type'],
											'card_no' =>  '',
											'sign' =>  "",
											'address' =>  $address,
											'name_card' =>  $name_card,
											'l_name' => "",
											'address_status' =>  "",
											'zip_status' =>  "",
											'cvv_status' =>  "",
											'ip_a' => $_SERVER['REMOTE_ADDR'],
											'order_type' => 'a'
										);
					
										  //print_r($data2); die(); 
			
											$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$data['resend'] = "";
											$item_name = json_encode($this->input->post('Item_Name'));
											$quantity = json_encode($this->input->post('Quantity'));
											$price = json_encode($this->input->post('Price'));
											$tax = json_encode($this->input->post('Tax_Amount'));
											$tax_id = json_encode($this->input->post('Tax'));
											$tax_per = json_encode($this->input->post('Tax_Per'));
											$total_amount = json_encode($this->input->post('Total_Amount'));
											$item_Detail_1 = array(
												"p_id" => $id2,
												"item_name" => ($item_name),  
												"quantity" => ($quantity),
												"price" => ($price),
												"tax" => ($tax),
												"tax_id" => ($tax_id),
												"tax_per" => ($tax_per),
												"total_amount" => ($total_amount),
						
											);
					
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
											$getDashboardData_m = $getDashboard_m->result_array();
											//print_r($getDashboardData_m); die();  
											$data2['getDashboardData_m'] = $getDashboardData_m;
											$data2['business_name'] = $getDashboardData_m[0]['business_name'];
											$data2['address1'] = $getDashboardData_m[0]['address1'];
											$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
											$data2['logo'] = $getDashboardData_m[0]['logo'];
											$data2['business_number'] = $getDashboardData_m[0]['business_number'];
											$data2['color'] = $getDashboardData_m[0]['color'];
											$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
											$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
											$this->admin_model->insert_data("order_item", $item_Detail_1);
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
											$data2['item_detail'] = $item_Detail_1;  
													
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From:".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											"MIME-Version: 1.0" . "\r\n" .
											"Content-type: text/html; charset=UTF-8" . "\r\n";
											//echo $recurring_pay_start_date1; echo "<br/>"; echo $curdate;  die(); 
													if(!empty($email_id)){ 
														$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
														$this->email->to($email_id);
														$this->email->subject($MailSubject);
														$this->email->message($msg);
														$m=$this->email->send();
														}
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
											
											$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											redirect(base_url('pos/all_customer_request_recurring'));
									}   
									else  {    //die(' Manual To Auto:  confirm payment :: next date == current date  :: if card are save '); 
											   //$transaction_id=$getRow[0]['transaction_id']; 
													$merchant_id=$getRow[0]['merchant_id']; 
													
													//$mobile_no=$getRow[0]['mobile_no'];
													$amount=$amount; 
													$account_id=$Merchantdata['account_id_cnp']; 
													$account_token=$Merchantdata['account_token_cnp']; 
													$acceptor_id=$Merchantdata['acceptor_id_cnp']; 
													$application_id=$Merchantdata['application_id_cnp']; 
													$terminal_id=$Merchantdata['terminal_id']; 
													$TicketNumber =  (rand(100000,999999)); 
													//$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
													$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
													$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>
													<Credentials>
													<AccountID>".$account_id."</AccountID>
													<AccountToken>".$account_token."</AccountToken>
													<AcceptorID>".$acceptor_id."</AcceptorID>
													</Credentials>
													<Application>
													<ApplicationID>".$application_id."</ApplicationID>
													<ApplicationVersion>2.2</ApplicationVersion>
													<ApplicationName>SaleQuick</ApplicationName>
													</Application>
													<Transaction>
													<TransactionAmount>".$amount."</TransactionAmount>
													<ReferenceNumber>84421174091</ReferenceNumber>
													<TicketNumber>".$TicketNumber."</TicketNumber>
													<MarketCode>3</MarketCode>
													<PaymentType>3</PaymentType>
													<SubmissionType>2</SubmissionType>
													<NetworkTransactionID>000001051388332</NetworkTransactionID>
													</Transaction>
													<Terminal>
													<TerminalID>".$terminal_id."</TerminalID>
													<CardPresentCode>3</CardPresentCode>
													<CardholderPresentCode>7</CardholderPresentCode>
													<CardInputCode>4</CardInputCode>
													<CVVPresenceCode>2</CVVPresenceCode>
													<TerminalCapabilityCode>5</TerminalCapabilityCode>
													<TerminalEnvironmentCode>6</TerminalEnvironmentCode>
													<MotoECICode>7</MotoECICode>
													</Terminal>
													<PaymentAccount>
													<PaymentAccountID>".$paymentcard."</PaymentAccountID>
													</PaymentAccount>
													</CreditCardSale>";       // data from the form, e.g. some ID number

													//print_r($xml_post_string); die();   
													$headers = array("Content-type: text/xml;charset=\"utf-8\"","Accept: text/xml",
													"Method:POST"
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
													$arrayy = json_decode($json,TRUE);
													//print_r($arrayy);  die("ok");
													curl_close($ch);
													if($arrayy['Response']['ExpressResponseMessage']=='Approved' )  
													{ 
														$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
														$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
														$card_a_type = $arrayy['Response']['Card']['CardLogo'];
														$message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
														$message_complete =  $arrayy['Response']['ExpressResponseMessage'];  
														//print_r($arrayy); die();
														$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
														$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
														$Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
														$Address ="";
														if(isset($arrayy['Response']['Address']['BillingAddress1']))
														{
														$Address =$arrayy['Response']['Address']['BillingAddress1'];
														}
														$Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
														$Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
														//die(); //2019-07-04 12:05:41
														$rt=$Tdate.' '.$Ttime;
														$transaction_date=date($rt); 
														if($message_complete=='Declined')
														{
														$staus = 'declined';
														}
														//elseif($message_a=='Approved' or $message_a=='Duplicate'
														elseif($message_complete=='Approved') 
														{ 
														$staus = 'confirm';  
														}
														else 
														{
														$staus = 'pending'; 
														}
														$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
														if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }

													
														$type=$getRow[0]['payment_type'];
												
														$paid=$getRow[0]['recurring_count_paid']+1; 

														$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;

														///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 

														$remain=($recurring_count >0)?$recurring_count-1:1; 
														
														$sub_total=$getRow[0]['sub_total']+$amount;
														
														//   start, stop,  complete
														if($remain <='0') 
														{
														$recurring_payment='complete'; 
														}
														else{
														$recurring_payment='start'; 
														}

														$today1 = date("Ymdhisu");
														$url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
														$unique = "PY" . $today1;
														$today2=date('Y-m-d'); 
														
														

														$recurring_pay_start_date1=$recurring_next_pay_date;
														$recurring_pay_start_date1=date($recurring_pay_start_date1); 
														switch($recurring_type)
														{
															case 'daily':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
															break;

															case 'weekly':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
															break;

															case 'biweekly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
															break;

															case 'monthly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
															break;

															case 'quarterly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
															break;

															case 'yearly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
															break;

															default :
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
															break; 
														}
														//print_r($recurring_pay_start_date);  die();
																$today2=date('Y-m-d'); 
																if($type=='recurring'){
								
																	$data2=$info2 = Array(
																		'reference' => $reference,
																		'name' => $name,
																		'other_charges' => $other_charges,
                                                                        'otherChargesName' => $other_charges_title,
																		'invoice_no' => $invoice_no,
																		'email_id' => $email_id,
																		'mobile_no' => $mobile_no,
																		'amount' => $amount,
																		'sub_total' => $sub_amount,
																		'tax' => $total_tax,
																		'fee' => $fee,
																		's_fee' => $fee_swap,
																		// 'title' => $title,
																		'detail' => $remark,
																		'note' => $note,
																		//'url' => $url,    /// 
																		'payment_type' => 'recurring',
																		'recurring_type' => $recurring_type,
																		'recurring_count' => $recurring_count1,
																		// 'due_date' => $row['due_date'],
																		'merchant_id' => $merchant_id,
																		'sub_merchant_id' => $sub_merchant_id,
																		//'payment_id'=>$unique,
																		'recurring_payment' => $recurring_payment,
																		
																		'recurring_pay_start_date' => $recurring_pay_start_date1,
																		'recurring_next_pay_date' => $recurring_next_pay_date,
																		'recurring_pay_type' => $paytype,

																		'status' => $staus,
																		'year' => $year,
																		'month' => $month,
																		'time1' => $time1,
																		'day1' => $day1,
																		'date_c' => $today2_a,
																		'payment_date' => $today2,
																		'recurring_count_paid' => $paid,   //fdgdfg
																		'recurring_count_remain' => $remain, //sfsfs
																		'transaction_id' => $trans_a_no,
																		'message' =>  $message_a,
																		'card_type' =>  $card_a_type,
																		'card_no' =>  $card_a_no,
																		'address' =>  $getRow[0]['address'],
																		'name_card' =>  $getRow[0]['name_card'],
																		'address_status' =>  $getRow[0]['address_status'],
																		'zip_status' =>  $getRow[0]['zip_status'],
																		'cvv_status' =>$getRow[0]['cvv_status'] ,
																		'ip_a' => $_SERVER['REMOTE_ADDR'],
																		'order_type' => 'a'
																	);
																}
															//print_r($info2);   die(); 
															$id1 = $this->admin_model->insert_data("customer_payment_request", $info2);
															//$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
															$data2['resend'] = "";
															$item_name = json_encode($this->input->post('Item_Name'));
															$quantity = json_encode($this->input->post('Quantity'));
															$price = json_encode($this->input->post('Price'));
															$tax = json_encode($this->input->post('Tax_Amount'));
															$tax_id = json_encode($this->input->post('Tax'));
															$tax_per = json_encode($this->input->post('Tax_Per'));
															$total_amount = json_encode($this->input->post('Total_Amount'));
															$item_Detail_1 = array(
																"p_id" => $id1,
																"item_name" => ($item_name),  
																"quantity" => ($quantity),
																"price" => ($price),
																"tax" => ($tax),
																"tax_id" => ($tax_id),
																"tax_per" => ($tax_per),
																"total_amount" => ($total_amount),
										
															);
															$this->admin_model->insert_data("order_item", $item_Detail_1);


															$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id1."' ");
															$getEmail = $getQuery->result_array();
															$data['getEmail'] = $getEmail;

															$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
															$getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
															$data['getEmail1'] = $getEmail1; 
															$data['resend'] = "";
													
															$email = $email_id;  $amount = $amount;   $sub_total =$sub_total; $tax = $this->input->post('Tax_Amount'); 
															$originalDate = $today2; $newDate = date("F d,Y", strtotime($originalDate)); 
															$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
															//Email Process
															$data['email'] = $email_id;
															$data['color'] = $Merchantdata['color'];
															$data['amount'] = $amount;  
															$data['sub_total'] = $sub_total;
															$data['tax'] = $this->input->post('Tax_Amount'); 
															$data['originalDate'] = $today2;
															$data['card_a_no'] = $card_a_no;
															$data['trans_a_no'] = $trans_a_no;
															$data['card_a_type'] = $card_a_type;
															$data['message_a'] = $message_a;
															$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
															$data['late_fee'] = $getEmail[0]['late_fee'];
															$data['payment_type'] = 'recurring';
															$data['recurring_type'] = $recurring_type;
															$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
															$data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
															$data['msgData'] = $data;
															$msg = $this->load->view('email/receipt', $data, true);
															$email = $email_id; 
															//echo  $email;   die("ok"); 
															$MailSubject = ' Receipt from '.$Merchantdata['business_dba_name']; 
															if(!empty($email)){ 
																$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
																$this->email->to($email);
																$this->email->subject($MailSubject);
																$this->email->message($msg);
																$this->email->send();
																}

															$url=$url;   
															$purl = str_replace('rpayment', 'reciept', $url); 
															// if(!empty($row['mobile_no']))
															// { 
															// $sms_reciever = $row['mobile_no'];
															  //// $sms_message = trim('Payment Receipt : '.$purl);
															  $sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
															// $from = '+18325324983'; //trial account twilio number
															// $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
															// $to = '+1'.$mob;
															// $response = $this->twilio->sms($from, $to,$sms_message);
															// }
															//print_r($token_data); die; 
															$save_notificationdata = array(
															'merchant_id'=>$merchant_id, 
															'name' => $name,
															'other_charges' => $other_charges,
                                                            'otherChargesName' => $other_charges_title,
															'mobile' => $mobile_no,
															'email' => $email_id,
															'card_type' =>  $card_a_type,
															'card_expiry_month'=> $token_data['card_expiry_month'],
															'card_expiry_year'=> $token_data['card_expiry_year'],
															'card_no' => $card_a_no,
															'amount'  =>$amount,
															'address' =>$address,
															'transaction_id'=>$trans_a_no,
															'transaction_date'=>$transaction_date,
															'notification_type' => 'payment',
															'invoice_no'=>$invoice_no,
															'status'   =>'unread'
															);
															//print_r($save_notificationdata); die(); 
															$this->db->insert('notification',$save_notificationdata);
															$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
								                            redirect(base_url('pos/all_customer_request_recurring'));

												}
												else
												{
													$id=$arrayy['Response']['ExpressResponseMessage']; 
													$this->session->set_flashdata('error', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> &nbsp;&nbsp;'.$id.'..'); 
													redirect(base_url('pos/all_customer_request_recurring'));
												}
									        }    //  End Of The Menual To Auto   With Success Payment  of Today ==  Next Paydate
									} 
									else  {   //die("Manual To Auto:  confirm payment :: next date= != current date");
										
										$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
										$card_type=$getRow[0]['card_type']; 
										$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
										$token_data = $getQuery_t->row_array();
										$paymentcard=$token_data['token'];

										  if($paymentcard == "") {   //die(' !!!Manual To Auto:  confirm payment :: next date != current date ::  no card  save ');
													$recurring_pay_start_date1=$recurring_next_pay_date;
													$recurring_pay_start_date1=date($recurring_pay_start_date1); 
												switch($recurring_type)
												{
													case 'daily':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'weekly':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'biweekly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
													break;
													case 'monthly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'quarterly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'yearly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
													break;
													default :
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break; 
												}
												$dfg = date("Ymdhisu");
												$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
												//$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
												$unique2 = "PY" . $dfg;
												$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
												$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
												$today2 = date("Y-m-d");  $year = date("Y"); $month = date("m");  $today3 = date("Y-m-d H:i:s");
												$type=$getRow[0]['payment_type'];
												$paid=$getRow[0]['recurring_count_paid']; 
												$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
												///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
												$remain=($recurring_count >0)?$recurring_count:1; 
												$sub_total=$getRow[0]['sub_total']+$amount;
												//   start, stop,  complete
												if($remain <='0')  {  $recurring_payment='complete';  } else{ $recurring_payment='start';  }
												$data2 = Array(
													'reference' => $reference,
													'name' => $name,
													'other_charges' => $other_charges,
                                                    'otherChargesName' => $other_charges_title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'fee' => $fee,
													's_fee' => $fee_swap,
													// 'title' => $title,
													'detail' => $remark,
													'note' => $note,
													//'url' => $url2,
													'payment_type' => 'recurring',
													'recurring_type' => $recurring_type,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'merchant_id' => $merchant_id,
													'sub_merchant_id' => $sub_merchant_id,
													//'payment_id' => $unique2,
													'recurring_payment' => $recurring_payment,
							
													'recurring_pay_start_date' => $recurring_pay_start_date1,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													
													'status' => 'pending',
													'year' => $year,
													'month' => $month,
													'time1' => $time1,
													'day1' => $day1,
													'date_c' => $today2_a,
													'payment_date' => "",
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'transaction_id' => "",
													'message' =>  "",
													'card_type' => $getRow[0]['card_type'],
													'card_no' =>  '',
													'sign' =>  "",
													'address' =>  $address,
													'name_card' =>  $name_card,
													'l_name' => "",
													'address_status' =>  "",
													'zip_status' =>  "",
													'cvv_status' =>  "",
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
							
												//print_r($data2); die(); 
					
													$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
													$data['resend'] = "";
													$item_name = json_encode($this->input->post('Item_Name'));
													$quantity = json_encode($this->input->post('Quantity'));
													$price = json_encode($this->input->post('Price'));
													$tax = json_encode($this->input->post('Tax_Amount'));
													$tax_id = json_encode($this->input->post('Tax'));
													$tax_per = json_encode($this->input->post('Tax_Per'));
													$total_amount = json_encode($this->input->post('Total_Amount'));
													$item_Detail_1 = array(
														"p_id" => $id2,
														"item_name" => ($item_name),  
														"quantity" => ($quantity),
														"price" => ($price),
														"tax" => ($tax),
														"tax_id" => ($tax_id),
														"tax_per" => ($tax_per),
														"total_amount" => ($total_amount),
								
													);
							
													$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
													$getDashboardData_m = $getDashboard_m->result_array();
													//print_r($getDashboardData_m); die();  
													$data2['getDashboardData_m'] = $getDashboardData_m;
													$data2['business_name'] = $getDashboardData_m[0]['business_name'];
													$data2['address1'] = $getDashboardData_m[0]['address1'];
													$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
													$data2['logo'] = $getDashboardData_m[0]['logo'];
													$data2['business_number'] = $getDashboardData_m[0]['business_number'];
													$data2['color'] = $getDashboardData_m[0]['color'];
													$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
													$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
													$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
													$data2['payment_type'] = 'recurring';
													$data2['recurring_type'] = $recurring_type;
													$data2['no_of_invoice'] = 1;
													$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
													$this->admin_model->insert_data("order_item", $item_Detail_1);
													$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
													$data2['item_detail'] = $item_Detail_1;  
															
													$data['msgData'] = $data2;
													$msg = $this->load->view('email/invoice', $data, true);
													$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
													$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
													"MIME-Version: 1.0" . "\r\n" .
													"Content-type: text/html; charset=UTF-8" . "\r\n";
													//echo $recurring_pay_start_date1; echo "<br/>"; echo $curdate;  die(); 
															// if(!empty($email_id)){ 
															// 	$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
															// 	$this->email->to($email_id);
															// 	$this->email->subject($MailSubject);
															// 	$this->email->message($msg);
															// 	$m=$this->email->send();
															// 	}
													$this->db->where('id', $id);
													$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
													
													$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
													redirect(base_url('pos/all_customer_request_recurring'));    	
											           
								    }    
									else  {    //die(' Manual To Auto:  confirm payment :: next date != current date  :: if card are save '); 
												
										        $recurring_pay_start_date1=$recurring_next_pay_date;
												$recurring_pay_start_date1=date($recurring_pay_start_date1); 
											switch($recurring_type)
											{
												case 'daily':
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												break;
												case 'weekly':
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												break;
												case 'biweekly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												break;
												case 'monthly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												break;
												case 'quarterly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												break;
												case 'yearly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												break;
												default :
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												break; 
											}
											$dfg = date("Ymdhisu");
											$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											//$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
											$unique2 = "PY" . $dfg;
											$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											$today2 = date("Y-m-d");  $year = date("Y"); $month = date("m");  $today3 = date("Y-m-d H:i:s");
											$type=$getRow[0]['payment_type'];
											$paid=$getRow[0]['recurring_count_paid']; 
											$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											$remain=($recurring_count >0)?$recurring_count:1; 
											$sub_total=$getRow[0]['sub_total']+$amount;
											//   start, stop,  complete
											if($remain <='0')  {  $recurring_payment='complete';  } else{ $recurring_payment='start';  }
											$data2 = Array(
												'reference' => $reference,
												'name' => $name,
												'other_charges' => $other_charges,
                                                'otherChargesName' => $other_charges_title,
												'invoice_no' => $invoice_no,
												'email_id' => $email_id,
												'mobile_no' => $mobile_no,
												'amount' => $amount,
												'sub_total' => $sub_amount,
												'tax' => $total_tax,
												'fee' => $fee,
												's_fee' => $fee_swap,
												// 'title' => $title,
												'detail' => $remark,
												'note' => $note,
												//'url' => $url2,
												'payment_type' => $type,
												'recurring_type' => $recurring_type,
												'recurring_count' => $recurring_count1,
												// 'due_date' => $due_date,
												'merchant_id' => $merchant_id,
												'sub_merchant_id' => $sub_merchant_id,
												//'payment_id' => $unique2,
												'recurring_payment' => $recurring_payment,
						
												'recurring_pay_start_date' => $recurring_pay_start_date1,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $paytype,
												
												'status' => 'pending',
												'year' => $year,
												'month' => $month,
												'time1' => $time1,
												'day1' => $day1,
												'date_c' => $today2_a,
												'payment_date' => "",
												'recurring_count_paid' => $paid,
												'recurring_count_remain' => $remain, 
												'transaction_id' => "",
												'message' =>  "",
												'card_type' =>  $getRow[0]['card_type'],
												'card_no' =>  '',
												'sign' =>  "",
												'address' =>  $address,
												'name_card' =>  $name_card,
												'l_name' => "",
												'address_status' =>  "",
												'zip_status' =>  "",
												'cvv_status' =>  "",
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
						
											//print_r($data2); die(); 
				
												$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
												$data['resend'] = "";
												$item_name = json_encode($this->input->post('Item_Name'));
												$quantity = json_encode($this->input->post('Quantity'));
												$price = json_encode($this->input->post('Price'));
												$tax = json_encode($this->input->post('Tax_Amount'));
												$tax_id = json_encode($this->input->post('Tax'));
												$tax_per = json_encode($this->input->post('Tax_Per'));
												$total_amount = json_encode($this->input->post('Total_Amount'));
												$item_Detail_1 = array(
													"p_id" => $id2,
													"item_name" => ($item_name),  
													"quantity" => ($quantity),
													"price" => ($price),
													"tax" => ($tax),
													"tax_id" => ($tax_id),
													"tax_per" => ($tax_per),
													"total_amount" => ($total_amount),
							
												);
						
												$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
												$getDashboardData_m = $getDashboard_m->result_array();
												//print_r($getDashboardData_m); die();  
												$data2['getDashboardData_m'] = $getDashboardData_m;
												$data2['business_name'] = $getDashboardData_m[0]['business_name'];
												$data2['address1'] = $getDashboardData_m[0]['address1'];
												$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
												$data2['logo'] = $getDashboardData_m[0]['logo'];
												$data2['business_number'] = $getDashboardData_m[0]['business_number'];
												$data2['color'] = $getDashboardData_m[0]['color'];
												$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
												$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
												$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
												$data2['payment_type'] = 'recurring';
												$data2['recurring_type'] = $recurring_type;
												$data2['no_of_invoice'] = 1;
												$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
												$this->admin_model->insert_data("order_item", $item_Detail_1);
												$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
												$data2['item_detail'] = $item_Detail_1;  
														
												$data['msgData'] = $data2;
												$msg = $this->load->view('email/invoice', $data, true);
												$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
												$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
												"MIME-Version: 1.0" . "\r\n" .
												"Content-type: text/html; charset=UTF-8" . "\r\n";
												//echo $recurring_pay_start_date1; echo "<br/>"; echo $curdate;  die(); 
														// if(!empty($email_id)){ 
														// 	$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
														// 	$this->email->to($email_id);
														// 	$this->email->subject($MailSubject);
														// 	$this->email->message($msg);
														// 	$m=$this->email->send();
														// 	}
												$this->db->where('id', $id);
												$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
												
												$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
												redirect(base_url('pos/all_customer_request_recurring')); 

									}   
								}
							}
							else if($getRow[0]['status']=='pending') {   //die("Manual To Auto:  pending payment  :  Unpid  ");
								if($recurring_next_pay_date==$curdate)  {  //die("Manual To Auto:  pending payment  :  Unpid  paydate==current date ");
									$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
									$card_type=$getRow[0]['card_type']; 
									$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
									$token_data = $getQuery_t->row_array();
									$paymentcard=$token_data['token'];

									  if($paymentcard == "" ) {  //die("manual    to auto  pending Payment :: unpaid  : pay date == current date :and   no card here  "); 
												//die("hi Am here"); 
										        $recurring_pay_start_date1=$recurring_next_pay_date;
												$recurring_pay_start_date1=date($recurring_pay_start_date);     
												switch($recurring_type)
												{
													case 'daily':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'weekly':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
													break;
													case 'biweekly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
													break;
													case 'monthly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'quarterly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
													break;
													case 'yearly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
													break;
													default :
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
													break; 
												}
												
												
												$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
												$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
												$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
												$type=$getRow[0]['payment_type'];
												$paid=$getRow[0]['recurring_count_paid']; 
												$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
												///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
												$remain=($recurring_count >0)?$recurring_count:1; 
												$sub_total=$getRow[0]['sub_total']+$amount;
												//   start, stop,  complete
												if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
					
												$data2 = Array(
													'reference' => $reference,
													'name' => $name,
													'other_charges' => $other_charges,
                                                    'otherChargesName' => $other_charges_title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'recurring_payment' => $recurring_payment,
													'recurring_pay_start_date' => $recurring_pay_start_date1,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
					
											//print_r($data2); die("auto To Auto "); 

											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
											$data['resend'] = "";
											$item_name = json_encode($this->input->post('Item_Name'));
											$quantity = json_encode($this->input->post('Quantity'));
											$price = json_encode($this->input->post('Price'));
											$tax = json_encode($this->input->post('Tax_Amount'));
											$tax_id = json_encode($this->input->post('Tax'));
											$tax_per = json_encode($this->input->post('Tax_Per'));
											$total_amount = json_encode($this->input->post('Total_Amount'));
											$item_Detail_1 = array(
												
												"item_name" => ($item_name),  
												"quantity" => ($quantity),
												"price" => ($price),
												"tax" => ($tax),
												"tax_id" => ($tax_id),
												"tax_per" => ($tax_per),
												"total_amount" => ($total_amount),
						
											);
											//print_r($item_Detail_1);  die(); 
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
											$getDashboardData_m = $getDashboard_m->result_array();
											//print_r($getDashboardData_m); die();  
											$data2['getDashboardData_m'] = $getDashboardData_m;
											$data2['business_name'] = $getDashboardData_m[0]['business_name'];
											$data2['address1'] = $getDashboardData_m[0]['address1'];
											$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
											$data2['logo'] = $getDashboardData_m[0]['logo'];
											$data2['business_number'] = $getDashboardData_m[0]['business_number'];
											$data2['color'] = $getDashboardData_m[0]['color'];
											$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
											$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
											//$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										// echo $mn;  die(); 
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
											$data2['item_detail'] = $item_Detail_1;  
													
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											"MIME-Version: 1.0" . "\r\n" .
											"Content-type: text/html; charset=UTF-8" . "\r\n";
											//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$curdate); die(); 
												if($recurring_pay_start_date1==$curdate) 
													{
														if(!empty($email_id)){ 
															$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
															$this->email->to($email_id);
															$this->email->subject($MailSubject);
															$this->email->message($msg);
															$m=$this->email->send();
															}
													}
                                             
											$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											redirect(base_url('pos/all_customer_request_recurring'));
                                          
									}
									else {      //die("manual    to auto  pending Payment :: unpaid  : pay date == current date :and   card are save here  "); 
												
										      //print_r( $Merchantdata['color']);  die(); 
										       $merchant_id=$getRow[0]['merchant_id']; 
															
												//$mobile_no=$getRow[0]['mobile_no'];
												$amount=$amount; 

												$account_id=$Merchantdata['account_id_cnp']; 
												$account_token=$Merchantdata['account_token_cnp']; 
												$acceptor_id=$Merchantdata['acceptor_id_cnp']; 
												$application_id=$Merchantdata['application_id_cnp']; 
												$terminal_id=$Merchantdata['terminal_id']; 
												$TicketNumber =  (rand(100000,999999)); 
												//$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
												$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
												$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>
												<Credentials>
												<AccountID>".$account_id."</AccountID>
												<AccountToken>".$account_token."</AccountToken>
												<AcceptorID>".$acceptor_id."</AcceptorID>
												</Credentials>
												<Application>
												<ApplicationID>".$application_id."</ApplicationID>
												<ApplicationVersion>2.2</ApplicationVersion>
												<ApplicationName>SaleQuick</ApplicationName>
												</Application>
												<Transaction>
												<TransactionAmount>".$amount."</TransactionAmount>
												<ReferenceNumber>84421174091</ReferenceNumber>
												<TicketNumber>".$TicketNumber."</TicketNumber>
												<MarketCode>3</MarketCode>
												<PaymentType>3</PaymentType>
												<SubmissionType>2</SubmissionType>
												<NetworkTransactionID>000001051388332</NetworkTransactionID>
												</Transaction>
												<Terminal>
												<TerminalID>".$terminal_id."</TerminalID>
												<CardPresentCode>3</CardPresentCode>
												<CardholderPresentCode>7</CardholderPresentCode>
												<CardInputCode>4</CardInputCode>
												<CVVPresenceCode>2</CVVPresenceCode>
												<TerminalCapabilityCode>5</TerminalCapabilityCode>
												<TerminalEnvironmentCode>6</TerminalEnvironmentCode>
												<MotoECICode>7</MotoECICode>
												</Terminal>
												<PaymentAccount>
												<PaymentAccountID>".$paymentcard."</PaymentAccountID>
												</PaymentAccount>
												</CreditCardSale>";       // data from the form, e.g. some ID number

												//print_r($xml_post_string); die();   
												$headers = array("Content-type: text/xml;charset=\"utf-8\"","Accept: text/xml",
												"Method:POST"
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
												$arrayy = json_decode($json,TRUE);
												//print_r($arrayy);  die("ok");
												curl_close($ch);
												if($arrayy['Response']['ExpressResponseMessage']=='Approved' )  
												{ 
													$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
													$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
													$card_a_type = $arrayy['Response']['Card']['CardLogo'];
													$message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
													$message_complete =  $arrayy['Response']['ExpressResponseMessage'];  
													//print_r($arrayy); die();
													$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
													$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
													$Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
													$Address ="";
													if(isset($arrayy['Response']['Address']['BillingAddress1']))
													{
													$Address =$arrayy['Response']['Address']['BillingAddress1'];
													}
													$Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
													$Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
													//die(); //2019-07-04 12:05:41
													$rt=$Tdate.' '.$Ttime;
													$transaction_date=date($rt); 
													if($message_complete=='Declined')
													{
													$staus = 'declined';
													}
													//elseif($message_a=='Approved' or $message_a=='Duplicate'
													elseif($message_complete=='Approved') 
													{ 
													$staus = 'confirm';  
													}
													else 
													{
													$staus = 'pending'; 
													}
													$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
													if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }

												
													$type=$getRow[0]['payment_type'];
											
													$paid=$getRow[0]['recurring_count_paid']+1; 

													$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;

													///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 

													$remain=($recurring_count >0)?$recurring_count-1:1; 
													
													$sub_total=$getRow[0]['sub_total']+$amount;
													
													//   start, stop,  complete
													if($remain <='0') 
													{
													$recurring_payment='complete'; 
													}
													else{
													$recurring_payment='start'; 
													}

													$today1 = date("Ymdhisu");
													//$url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
													///$unique = "PY" . $today1;
													$today2=date('Y-m-d'); 
													
													

													$recurring_pay_start_date1=$recurring_next_pay_date;
													$recurring_pay_start_date1=date($recurring_pay_start_date1); 
													switch($recurring_type)
													{
														case 'daily':
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
														break;

														case 'weekly':
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
														break;

														case 'biweekly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
														break;

														case 'monthly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
														break;

														case 'quarterly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
														break;

														case 'yearly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
														break;

														default :
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
														break; 
													}
													//print_r($recurring_pay_start_date);  die();
															$today2=date('Y-m-d'); 
															if($type=='recurring'){
							
																$data2=$info2 = Array(
																	'reference' => $reference,
																	'name' => $name,
																	'other_charges' => $other_charges,
                                                                    'otherChargesName' => $other_charges_title,
																	'invoice_no' => $invoice_no,
																	'email_id' => $email_id,
																	'mobile_no' => $mobile_no,
																	'amount' => $amount,
																	'sub_total' => $sub_amount,
																	'tax' => $total_tax,
																	'fee' => $fee,
																	's_fee' => $fee_swap,
																	'payment_type' => $type,
																	'recurring_type' => $recurring_type,
																	'recurring_count' => $recurring_count1,
																	'merchant_id' => $merchant_id,
																	'sub_merchant_id' => $sub_merchant_id,
																	'recurring_payment' => $recurring_payment,
																	'recurring_pay_start_date' => $recurring_pay_start_date1,
																	'recurring_next_pay_date' => $recurring_next_pay_date,
																	'recurring_pay_type' => $paytype,
																	'status' => $staus,
																	'year' => $year,
																	'month' => $month,
																	'time1' => $time1,
																	'day1' => $day1,
																	'date_c' => $today2_a,
																	'payment_date' => $today2,
																	'recurring_count_paid' => $paid,   //fdgdfg
																	'recurring_count_remain' => $remain, //sfsfs
																	'transaction_id' => $trans_a_no,
																	'message' =>  $message_a,
																	'card_type' =>  $card_a_type,
																	'card_no' =>  $card_a_no,
																	'address' =>  $getRow[0]['address'],
																	'name_card' =>  $getRow[0]['name_card'],
																	'address_status' =>  $getRow[0]['address_status'],
																	'zip_status' =>  $getRow[0]['zip_status'],
																	'cvv_status' =>$getRow[0]['cvv_status'] ,
																	'ip_a' => $_SERVER['REMOTE_ADDR'],
																	'order_type' => 'a'
																	
																);
															}

														$this->db->where('id', $id);
														$updateresult=$this->db->update('customer_payment_request',$data2);
														$data2['resend'] = "";
														$item_name = json_encode($this->input->post('Item_Name'));
														$quantity = json_encode($this->input->post('Quantity'));
														$price = json_encode($this->input->post('Price'));
														$tax = json_encode($this->input->post('Tax_Amount'));
														$tax_id = json_encode($this->input->post('Tax'));
														$tax_per = json_encode($this->input->post('Tax_Per'));
														$total_amount = json_encode($this->input->post('Total_Amount'));
														$item_Detail_1 = array(
															
															"item_name" => ($item_name),  
															"quantity" => ($quantity),
															"price" => ($price),
															"tax" => ($tax),
															"tax_id" => ($tax_id),
															"tax_per" => ($tax_per),
															"total_amount" => ($total_amount),
									
														);
                                                        $this->db->where('p_id', $id);
													    $upd=$this->db->update('order_item',$item_Detail_1);

														$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
														$getEmail = $getQuery->result_array();
														$data['getEmail'] = $getEmail;

														$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
														$getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
														$data['getEmail1'] = $getEmail1; 
														$data['resend'] = "";
												
														$email = $email_id;  $amount = $amount;   $sub_total =$sub_total; $tax = $this->input->post('Tax_Amount'); 
														$originalDate = $today2; $newDate = date("F d,Y", strtotime($originalDate)); 
														$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
														//Email Process
														$data['email'] = $email_id;
														$data['color'] = $Merchantdata['color'];
														$data['amount'] = $amount;  
														$data['sub_total'] = $sub_total;
														$data['tax'] = $this->input->post('Tax_Amount'); 
														$data['originalDate'] = $today2;
														$data['card_a_no'] = $card_a_no;
														$data['trans_a_no'] = $trans_a_no;
														$data['card_a_type'] = $card_a_type;
														$data['message_a'] = $message_a;
														$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
														$data['late_fee'] = $getEmail[0]['late_fee'];
														$data['payment_type'] = 'recurring';
														$data['recurring_type'] = $recurring_type;
														$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
														$data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
														$data['msgData'] = $data;
														$msg = $this->load->view('email/receipt', $data, true);
														$email = $email_id; 
														//echo  $email;   die("ok"); 
														$MailSubject = ' Receipt from '.$Merchantdata['business_dba_name']; 
														if(!empty($email)){ 
															$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
															$this->email->to($email);
															$this->email->subject($MailSubject);
															$this->email->message($msg);
															$this->email->send();
															}

														$url=$url;   
														$purl = str_replace('rpayment', 'reciept', $url); 
														// if(!empty($row['mobile_no']))
														// { 
														// $sms_reciever = $row['mobile_no'];
														  //// $sms_message = trim('Payment Receipt : '.$purl);
														//$sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
														// $from = '+18325324983'; //trial account twilio number
														// $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
														// $to = '+1'.$mob;
														// $response = $this->twilio->sms($from, $to,$sms_message);
														// }
														//print_r($token_data); die; 
														$save_notificationdata = array(
														'merchant_id'=>$merchant_id, 
														'name' => $name,
														'other_charges' => $other_charges,
                                                        'otherChargesName' => $other_charges_title,
														'mobile' => $mobile_no,
														'email' => $email_id,
														'card_type' =>  $card_a_type,
														'card_expiry_month'=> $token_data['card_expiry_month'],
														'card_expiry_year'=> $token_data['card_expiry_year'],
														'card_no' => $card_a_no,
														'amount'  =>$amount,
														'address' =>$address,
														'transaction_id'=>$trans_a_no,
														'transaction_date'=>$transaction_date,
														'notification_type' => 'payment',
														'invoice_no'=>$invoice_no,
														'status'   =>'unread'
														);
														//print_r($save_notificationdata); die(); 
														$this->db->insert('notification',$save_notificationdata);
														$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
														redirect(base_url('pos/all_customer_request_recurring'));

											}
											else
											{
												$id=$arrayy['Response']['ExpressResponseMessage']; 
												$this->session->set_flashdata('error', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> &nbsp;&nbsp;'.$id.'..'); 
												redirect(base_url('pos/all_customer_request_recurring'));
											}
							            }     //  End Of the Card Save or  No Card :: Both  condition are end here       
								} 
								else{  //die("Manual To Auto:  pending payment  :  Unpid ::  Pay date !=  current date  ");
									$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
									$card_type=$getRow[0]['card_type']; 
									$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
									$token_data = $getQuery_t->row_array();
									$paymentcard=$token_data['token'];

									  if($paymentcard == "" &&  3 > 4) {     //die(" haaa hh Manual to auto pending payment : unpaid :: pay date  != current date :: and there are no card here "); 
													
										            $recurring_pay_start_date1=$recurring_next_pay_date;
													$recurring_pay_start_date1=date($recurring_pay_start_date);     
													switch($recurring_type)
													{
														case 'daily':
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
														break;
														case 'weekly':
														$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
														break;
														case 'biweekly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
														break;
														case 'monthly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
														break;
														case 'quarterly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
														break;
														case 'yearly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
														break;
														default :
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
														break; 
													}
													
													
													$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
													$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
													$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
													$type=$getRow[0]['payment_type'];
													$paid=$getRow[0]['recurring_count_paid']; 
													$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
													///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
													$remain=($recurring_count >0)?$recurring_count:1; 
													$sub_total=$getRow[0]['sub_total']+$amount;
													//   start, stop,  complete
													if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
						
													$data2 = Array(
														'reference' => $reference,
														'name' => $name,
														'other_charges' => $other_charges,
                                                        'otherChargesName' => $other_charges_title,
														'invoice_no' => $invoice_no,
														'email_id' => $email_id,
														'mobile_no' => $mobile_no,
														'amount' => $amount,
														'sub_total' => $sub_amount,
														'tax' => $total_tax,
														'url'=>$getRow[0]['url'],
														'date_c'=>$getRow[0]['date_c'],
														'payment_type' => $type,
														'recurring_type' => $recurring_type,
														'recurring_count' => $recurring_count1,
														// 'due_date' => $due_date,
														'recurring_payment' => $recurring_payment,
														'recurring_pay_start_date' => $recurring_pay_start_date1,
														'recurring_next_pay_date' => $recurring_next_pay_date,
														'recurring_pay_type' => $paytype,
														'recurring_count_paid' => $paid,
														'recurring_count_remain' => $remain, 
														'ip_a' => $_SERVER['REMOTE_ADDR'],
														'order_type' => 'a'
													);
						
												//print_r($data2); die("auto To Auto "); 

												$this->db->where('id', $id);
												$updateresult=$this->db->update('customer_payment_request',$data2);
												$data['resend'] = "";
												$item_name = json_encode($this->input->post('Item_Name'));
												$quantity = json_encode($this->input->post('Quantity'));
												$price = json_encode($this->input->post('Price'));
												$tax = json_encode($this->input->post('Tax_Amount'));
												$tax_id = json_encode($this->input->post('Tax'));
												$tax_per = json_encode($this->input->post('Tax_Per'));
												$total_amount = json_encode($this->input->post('Total_Amount'));
												$item_Detail_1 = array(
													
													"item_name" => ($item_name),  
													"quantity" => ($quantity),
													"price" => ($price),
													"tax" => ($tax),
													"tax_id" => ($tax_id),
													"tax_per" => ($tax_per),
													"total_amount" => ($total_amount),
							
												);
												//print_r($item_Detail_1);  die(); 
												$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
												$getDashboardData_m = $getDashboard_m->result_array();
												//print_r($getDashboardData_m); die();  
												$data2['getDashboardData_m'] = $getDashboardData_m;
												$data2['business_name'] = $getDashboardData_m[0]['business_name'];
												$data2['address1'] = $getDashboardData_m[0]['address1'];
												$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
												$data2['logo'] = $getDashboardData_m[0]['logo'];
												$data2['business_number'] = $getDashboardData_m[0]['business_number'];
												$data2['color'] = $getDashboardData_m[0]['color'];
												$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
												$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
												$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
												$data2['payment_type'] = 'recurring';
												$data2['recurring_type'] = $recurring_type;
												$data2['no_of_invoice'] = 1;
												$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
												//$this->admin_model->insert_data("order_item", $item_Detail_1);
												$this->db->where('p_id', $id);
												$mn=$update=$this->db->update('order_item',$item_Detail_1);
											// echo $mn;  die(); 
												$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
												$data2['item_detail'] = $item_Detail_1;  
														
												$data['msgData'] = $data2;
												$msg = $this->load->view('email/invoice', $data, true);
												
												$MailSubject = ' Invoice '.$getDashboardData_m[0]['business_dba_name'];
												$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
												"MIME-Version: 1.0" . "\r\n" .
												"Content-type: text/html; charset=UTF-8" . "\r\n";
												//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$curdate); die(); 
													if($recurring_pay_start_date1==$curdate) 
														{
															if(!empty($email_id)){ 
																$this->email->from('info@salequick.com',$getDashboardData_m[0]['business_dba_name']);
																$this->email->to($email_id);
																$this->email->subject($MailSubject);
																$this->email->message($msg);
																$m=$this->email->send();
																}
														}
												
												$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
												redirect(base_url('pos/all_customer_request_recurring'));
									  }
									  else  
									  {   //die("Manual to auto pending payment : unpaid :: pay date  != current date :: and there are save card here "); 
												//die("okui");
												//$recurring_pay_start_date1=$recurring_next_pay_date;
												// $recurring_pay_start_date1=date($recurring_pay_start_date);     
												// switch($recurring_type)
												// {
												// 	case 'daily':
												// 	$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'weekly':
												// 	$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'biweekly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'monthly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'quarterly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	case 'yearly':
												// 	$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												// 	break;
												// 	default :
												// 		$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												// 	break; 
												// }
												
												
												$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
												$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
												$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
												$type=$getRow[0]['payment_type'];
												$paid=$getRow[0]['recurring_count_paid']; 
												$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
												///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
												$remain=($recurring_count >0)?$recurring_count:1; 
												$sub_total=$getRow[0]['sub_total']+$amount;
												//   start, stop,  complete
												if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
					
												$data2 = Array(
													'reference' => $reference,
													'name' => $name,
													'other_charges' => $other_charges,
                                                    'otherChargesName' => $other_charges_title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'recurring_payment' => $recurring_payment,
													//'recurring_pay_start_date' => $recurring_pay_start_date,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
					
											//print_r($data2); die("auto To Auto ");

											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
											$data['resend'] = "";
											$item_name = json_encode($this->input->post('Item_Name'));
											$quantity = json_encode($this->input->post('Quantity'));
											$price = json_encode($this->input->post('Price'));
											$tax = json_encode($this->input->post('Tax_Amount'));
											$tax_id = json_encode($this->input->post('Tax'));
											$tax_per = json_encode($this->input->post('Tax_Per'));
											$total_amount = json_encode($this->input->post('Total_Amount'));
											$item_Detail_1 = array(
												
												"item_name" => ($item_name),  
												"quantity" => ($quantity),
												"price" => ($price),
												"tax" => ($tax),
												"tax_id" => ($tax_id),
												"tax_per" => ($tax_per),
												"total_amount" => ($total_amount),
						
											);
											//print_r($item_Detail_1);  die(); 
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color FROM merchant WHERE id = '" . $merchant_id . "' ");
											$getDashboardData_m = $getDashboard_m->result_array();
											//print_r($getDashboardData_m); die();  
											$data2['getDashboardData_m'] = $getDashboardData_m;
											$data2['business_name'] = $getDashboardData_m[0]['business_name'];
											$data2['address1'] = $getDashboardData_m[0]['address1'];
											$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
											$data2['logo'] = $getDashboardData_m[0]['logo'];
											$data2['business_number'] = $getDashboardData_m[0]['business_number'];
											$data2['color'] = $getDashboardData_m[0]['color'];
											$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
											$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
											//$this->admin_model->insert_data("order_item", $item_Detail_1);
											$this->db->where('p_id', $id);
											$mn=$update=$this->db->update('order_item',$item_Detail_1);
										// echo $mn;  die(); 
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
											$data2['item_detail'] = $item_Detail_1;  
													
											$data['msgData'] = $data2; 
											$msg = $this->load->view('email/invoice', $data, true);
											
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From:".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											"MIME-Version: 1.0" . "\r\n" .
											"Content-type: text/html; charset=UTF-8" . "\r\n";
											//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$curdate); die(); 
												if($recurring_next_pay_date==$curdate) 
													{
														if(!empty($email_id)){ 
															$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
															$this->email->to($email_id);
															$this->email->subject($MailSubject);
															$this->email->message($msg);
															$m=$this->email->send();
															}
													}
											
											$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											redirect(base_url('pos/all_customer_request_recurring')); 
									  }   ///  End Of the  menual to auto : with all cases here
								}
							}
							}   
							else if($paytype=='0') { //die("Manual To Menual");
                                 
								if($getRow[0]['status']=='confirm' ||  $getRow[0]['status']=='Chargeback_Confirm'  )  {      //die("Manual To Menual:  confirm payment ");  
									// if($recurring_next_pay_date==$curdate)  { 
									// 	  die("Manual To Menual:  confirm payment ::  Current Date"); 
									// } 
									// else {   die("Manual To Menual:  confirm payment ::  Others Date"); 
                                      
									// }

										$recurring_pay_start_date1=$recurring_next_pay_date;
										$recurring_pay_start_date1=date($recurring_pay_start_date1); 
										switch($recurring_type)
										{
											case 'daily':
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
											break;
											case 'weekly':
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
											break;
											case 'biweekly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
											break;
											case 'monthly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
											break;
											case 'quarterly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
											break;
											case 'yearly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
											break;
											default :
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
											break; 
										}
										$dfg = date("Ymdhisu");
										$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
										//$url = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
										$unique2 = "PY" . $dfg;
										$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
										$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
										$today2 = date("Y-m-d");  $year = date("Y"); $month = date("m");  $today3 = date("Y-m-d H:i:s");
										$type=$getRow[0]['payment_type'];
										$paid=$getRow[0]['recurring_count_paid']; 
										$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
										///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
										$remain=($recurring_count >0)?$recurring_count:1; 
										$sub_total=$getRow[0]['sub_total']+$amount;
										//   start, stop,  complete
										if($remain <='0')  {  $recurring_payment='complete';  } else{ $recurring_payment='start';  }
										$data2 = Array(
											'reference' => $reference,
											'name' => $name,
											'other_charges' => $other_charges,
                                            'otherChargesName' => $other_charges_title,
											'invoice_no' => $invoice_no,
											'email_id' => $email_id,
											'mobile_no' => $mobile_no,
											'amount' => $amount,
											'sub_total' => $sub_amount,
											'tax' => $total_tax,
											'fee' => $fee,
											's_fee' => $fee_swap,
											// 'title' => $title,
											'detail' => $remark,
											'note' => $note,
											//'url' => $url2,
											'payment_type' => 'recurring',
											'recurring_type' => $recurring_type,
											'recurring_count' => $recurring_count1,
											// 'due_date' => $due_date,
											'merchant_id' => $merchant_id,
											'sub_merchant_id' => $sub_merchant_id,
											//'payment_id' => $unique2,
											'recurring_payment' => $recurring_payment,
					
											'recurring_pay_start_date' => $recurring_pay_start_date1,
											'recurring_next_pay_date' => $recurring_next_pay_date,
											'recurring_pay_type' => $paytype,
											
											'status' => 'pending',
											'year' => $year,
											'month' => $month,
											'time1' => $time1,
											'day1' => $day1,
											'date_c' => $today2_a,
											'payment_date' => "",
											'recurring_count_paid' => $paid,
											'recurring_count_remain' => $remain, 
											'transaction_id' => "",
											'message' =>  "",
											'card_type' =>  $getRow[0]['card_type'],
											'card_no' =>  '',
											'sign' =>  "",
											'address' =>  $address,
											'name_card' =>  $name_card,
											'l_name' => "",
											'address_status' =>  "",
											'zip_status' =>  "",
											'cvv_status' =>  "",
											'ip_a' => $_SERVER['REMOTE_ADDR'],
											'order_type' => 'a'
										);
					
										 // print_r($data2); die(); 
			
											$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$data['resend'] = "";
											$item_name = json_encode($this->input->post('Item_Name'));
											$quantity = json_encode($this->input->post('Quantity'));
											$price = json_encode($this->input->post('Price'));
											$tax = json_encode($this->input->post('Tax_Amount'));
											$tax_id = json_encode($this->input->post('Tax'));
											$tax_per = json_encode($this->input->post('Tax_Per'));
											$total_amount = json_encode($this->input->post('Total_Amount'));
											$item_Detail_1 = array(
												"p_id" => $id2,
												"item_name" => ($item_name),  
												"quantity" => ($quantity),
												"price" => ($price),
												"tax" => ($tax),
												"tax_id" => ($tax_id),
												"tax_per" => ($tax_per),
												"total_amount" => ($total_amount),
						
											);
					
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color FROM merchant WHERE id = '" . $merchant_id . "' ");
											$getDashboardData_m = $getDashboard_m->result_array();
											//print_r($getDashboardData_m); die();  
											$data2['getDashboardData_m'] = $getDashboardData_m;
											$data2['business_name'] = $getDashboardData_m[0]['business_name'];
											$data2['address1'] = $getDashboardData_m[0]['address1'];
											$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
											$data2['logo'] = $getDashboardData_m[0]['logo'];
											$data2['business_number'] = $getDashboardData_m[0]['business_number'];
											$data2['color'] = $getDashboardData_m[0]['color'];
											$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
											$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
											$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
											$data2['payment_type'] = 'recurring';
											$data2['recurring_type'] = $recurring_type;
											$data2['no_of_invoice'] = 1;
											$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
											$this->admin_model->insert_data("order_item", $item_Detail_1);
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
											$data2['item_detail'] = $item_Detail_1;  
													
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
											"MIME-Version: 1.0" . "\r\n" .
											"Content-type: text/html; charset=UTF-8" . "\r\n";
											//echo $recurring_pay_start_date1; echo "<br/>"; echo $curdate;  die(); 
											if($recurring_pay_start_date1==$curdate) {
													if(!empty($email_id)){ 
														$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
														$this->email->to($email_id);
														$this->email->subject($MailSubject);
														$this->email->message($msg);
														$m=$this->email->send();
														}
											}
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
											
											$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
											redirect(base_url('pos/all_customer_request_recurring'));
								}
								else if($getRow[0]['status']=='pending') {  //die("Manual To Menual:  pending payment ");

									// if($recurring_next_pay_date==$curdate)  { 

									// } 
									// else  {
                                         
									// }
											 
											     
											$recurring_pay_start_date1=$recurring_next_pay_date;
											//$recurring_pay_start_date1=date($recurring_pay_start_date);     
											switch($recurring_type)
											{
												case 'daily':
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												break;
												case 'weekly':
												$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
												break;
												case 'biweekly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
												break;
												case 'monthly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
												break;
												case 'quarterly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
												break;
												case 'yearly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
												break;
												default :
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
												break; 
											}
											//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$recurring_pay_start_date1); die();
											
											$day1 = date("N"); $today2_a = date("Y-m-d"); 	$year = date("Y");
											$month = date("m"); $time11 = date("H"); if($time11=='00'){ $time1 = '01'; }else{ $time1 = date("H"); }
											$today2 = date("Y-m-d");   $today3 = date("Y-m-d H:i:s");
											$type=$getRow[0]['payment_type'];
											$paid=$getRow[0]['recurring_count_paid']; 
											$recurring_count1=($recurring_count >0)?$recurring_count+$getRow[0]['recurring_count_paid']:-1;
											///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value 
											$remain=($recurring_count >0)?$recurring_count:1; 
											$sub_total=$getRow[0]['sub_total']+$amount;
											//   start, stop,  complete
											if($remain <='0')  { $recurring_payment='complete';  } else{ $recurring_payment='start';  }
				
											$data2 = Array(
												'reference' => $reference,
												'name' => $name,
												'other_charges' => $other_charges,
                                                'otherChargesName' => $other_charges_title,
												'invoice_no' => $invoice_no,
												'email_id' => $email_id,
												'mobile_no' => $mobile_no,
												'amount' => $amount,
												'sub_total' => $sub_amount,
												'tax' => $total_tax,
												'url'=>$getRow[0]['url'],
												'date_c'=>$getRow[0]['date_c'],
												'payment_type' => $type,
												'recurring_type' => $recurring_type,
												'recurring_count' => $recurring_count1,
												// 'due_date' => $due_date,
												'recurring_payment' => $recurring_payment,
												'recurring_pay_start_date' => $recurring_pay_start_date1,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $paytype,
												'recurring_count_paid' => $paid,
												'recurring_count_remain' => $remain, 
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
				
										//print_r($data2); die("auto To Auto "); 
										$this->db->where('id', $id);
										$updateresult=$this->db->update('customer_payment_request',$data2);
										//echo $this->db->last_query();  die(); 
										$data['resend'] = "";
										$item_name = json_encode($this->input->post('Item_Name'));
										$quantity = json_encode($this->input->post('Quantity'));
										$price = json_encode($this->input->post('Price'));
										$tax = json_encode($this->input->post('Tax_Amount'));
										$tax_id = json_encode($this->input->post('Tax'));
										$tax_per = json_encode($this->input->post('Tax_Per'));
										$total_amount = json_encode($this->input->post('Total_Amount'));
										$item_Detail_1 = array(
											
											"item_name" => ($item_name),  
											"quantity" => ($quantity),
											"price" => ($price),
											"tax" => ($tax),
											"tax_id" => ($tax_id),
											"tax_per" => ($tax_per),
											"total_amount" => ($total_amount),
					
										);
										//print_r($item_Detail_1);  die(); 
										$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color FROM merchant WHERE id = '" . $merchant_id . "' ");
										$getDashboardData_m = $getDashboard_m->result_array();
										//print_r($getDashboardData_m); die();  
										$data2['getDashboardData_m'] = $getDashboardData_m;
										$data2['business_name'] = $getDashboardData_m[0]['business_name'];
										$data2['address1'] = $getDashboardData_m[0]['address1'];
										$data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
										$data2['logo'] = $getDashboardData_m[0]['logo'];
										$data2['business_number'] = $getDashboardData_m[0]['business_number'];
										$data2['color'] = $getDashboardData_m[0]['color'];
										$data2['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
										$data2['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
										$data2['late_fee'] = $getDashboardData_m[0]['late_fee'];
										$data2['payment_type'] = 'recurring';
										$data2['recurring_type'] = $recurring_type;
										$data2['no_of_invoice'] = 1;
										$data2['recurring_count'] = $recurring_count1 ? $recurring_count1 : '&infin;';
										//$this->admin_model->insert_data("order_item", $item_Detail_1);
										$this->db->where('p_id', $id);
										$mn=$update=$this->db->update('order_item',$item_Detail_1);
									// echo $mn;  die(); 
										$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
										$data2['item_detail'] = $item_Detail_1;  
												
										$data['msgData'] = $data2;
										$msg = $this->load->view('email/invoice', $data, true);
										
										$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
										$header = "From:".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
										"MIME-Version: 1.0" . "\r\n" .
										"Content-type: text/html; charset=UTF-8" . "\r\n";
										//print_r($email_id.'----'.$recurring_next_pay_date.'----'.$curdate); die(); 
											if($recurring_pay_start_date1==$curdate) 
												{
													if(!empty($email_id)){ 
														$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
														$this->email->to($email_id);
														$this->email->subject($MailSubject);
														$this->email->message($msg);
														$m=$this->email->send();
														}
												}
										
										$this->session->set_flashdata('success', ' Invoice  : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
										redirect(base_url('pos/all_customer_request_recurring'));


								}
							}        
						}
						
					}  
					

                 }
            }
            else if($id!="")
            {    
                $data['meta'] = 'Edit Recurring';
                $get_recurring_invoice = $this->admin_model->select_request_id('customer_payment_request',$id);
                $data['get_recurring_invoice'] = $get_recurring_invoice;

                $get_inv_token = $this->db->where('invoice_no', $get_recurring_invoice->invoice_no)->get('invoice_token')->row();
				//print_r($get_recurring_invoice->invoice_no);die;
                // $get_token = $this->db->where('merchant_id',$merchant_id)->where('id',$get_inv_token->token_id)->get('token')->row();
                //echo $merchant_id;die;
                $invoiceNum=$get_recurring_invoice->invoice_no;
                                
                $query1=$this->db->query("SELECT token.id from token,invoice_token where invoice_token.token_id=token.id and invoice_no='".$invoiceNum."'")->result_array();
                //echo $query1[0]['id'];die;
                //echo $invoiceNum;die;
                $query2=$this->db->query("update invoice_token set token_id=".$query1[0]['id']." where invoice_no='".$invoiceNum."'");
                $currentTokenid= $query1[0]['id'];
                
                //echo $currentTokenid;die;

                $get_token = $this->db->query("SELECT card_type, right(card_no,4) as 'card_no',token from token where id='".$currentTokenid."' and status=1")->result_array();
                //echo $this->db->last_query();die;
                //print_r( $get_token);die;
                 //echo $this->db->last_query();die;
              	$data['card_no'] = $get_token[0]['card_no']; 
		        $data['token'] = $get_token[0]['token'];
		        $data['card_type'] = $get_token[0]['card_type'];
                //echo '<pre>';print_r($data);die;

                $data['itemslist']=$this->admin_model->search_item($id); 
                // print_r($data['get_recurring_invoice']); echo "<br/>"; 
                // print_r($data['itemslist']);  
                // die("Its  Ok");    
               // print_r($data);die;
                 $this->load->view("merchant/edit_customer_recurring", $data);
                //$this->load->view("merchant/edit_customer_request_dash", $data);
                // $this->load->view("merchant/edit_customer_request", $data);
            }
           else 
            {     
			  redirect(base_url("merchant/edit_customer_request"));
		    }


        }
		elseif ($merchant_status == 'block') {
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
			$urlafterSign = base_url('merchant/after_signup');
			$data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
			$data['loc'] = "";
			$data['resend'] = "";
			$this->load->view("merchant/blockactive", $data);
		} elseif ($merchant_status == "Waiting_For_Approval") {
			$urlafterSign = base_url('merchant/after_signup');
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





    }//  End Of The Edit Function 


}  //   End Of The Class 
?>