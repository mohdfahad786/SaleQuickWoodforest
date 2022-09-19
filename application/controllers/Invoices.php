<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Invoices extends CI_Controller {  
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model');
			$this->load->model('admin_model');
			$this->load->model('home_model');
			$this->load->library('email');
			$this->load->library('twilio');
			
			date_default_timezone_set("America/Chicago"); 
		}
		public  function setDataInArray($package_data) {
			$mem = array();
			$member = array();
			foreach ($package_data as $each) {
				$package['id'] = $each->id;
				$package['invoice_no'] = $each->invoice_no;
				$package['sub_merchant_id'] = $each->sub_merchant_id;
				$package['merchant_id'] = $each->merchant_id;
				$package['user_id'] = $each->user_id;
				$package['auth_key'] = $each->auth_key;
				$package['merchant_key'] = $each->merchant_key;
				$package['payment_id'] = $each->payment_id;
				$package['name'] = $each->name;
				$package['other_charges'] = $each->other_charges;
				$package['otherChargesName'] = $each->otherChargesName;
				$package['l_name'] = $each->l_name;
				$package['email_id'] = $each->email_id;
				$package['mobile_no'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['sub_total'] = $each->sub_total;
				$package['tax'] = $each->tax;
				$package['fee'] = $each->fee;
				$package['s_fee'] = $each->s_fee;
				$package['title'] = $each->title;
				$package['detail'] = $each->detail;
				$package['url'] = $each->url;
				$package['sort_url'] = $each->sort_url;
				$package['success_url'] = $each->success_url;
				$package['fail_url'] = $each->fail_url;
				$package['payment_type'] = $each->payment_type;
				$package['note'] = $each->note;
				$package['reference'] = $each->reference;
				$package['status'] = $each->status;
				$package['recurring_type'] = $each->recurring_type;
				$package['recurring_count'] = $each->recurring_count;
				$package['recurring_count_paid'] = $each->recurring_count_paid;
				$package['recurring_count_remain'] = $each->recurring_count_remain;
				$package['no_of_invoice'] = $each->no_of_invoice;
				$package['recurring_pay_start_date'] = $each->recurring_pay_start_date;
				$package['recurring_next_pay_date'] = $each->recurring_next_pay_date;
				$package['recurring_pay_type'] = $each->recurring_pay_type;
				$package['due_date'] = $each->due_date;
				$package['payment_date'] = $each->payment_date;
				$package['recurring_payment'] = $each->recurring_payment;
				$package['type'] = $each->type;
				$package['time1'] = $each->time1;
				$package['day1'] = $each->day1;
				$package['time_type'] = $each->time_type;
				$package['month'] = $each->month;
				$package['year'] = $each->year;
				$package['city'] = $each->city;
				$package['state'] = $each->state;
				$package['country'] = $each->country;
				$package['zipcode'] = $each->zipcode;
				$package['address'] = $each->address;
				$package['op1'] = $each->op1;
				$package['op2'] = $each->op2;
				$package['sign'] = $each->sign;
				$package['ip_a'] = $each->ip_a;
				$package['transaction_id'] = $each->transaction_id;
				$package['card_type'] = $each->card_type;
				$package['card_no'] = $each->card_no;
				$package['name_card'] = $each->name_card;
				$package['message'] = $each->message;
				$package['user_tye'] = $each->user_tye;
				$package['address_status'] = $each->address_status;
				$package['zip_status'] = $each->zip_status;
				$package['cvv_status'] = $each->cvv_status;
				$package['color'] = $each->color;
				$package['date_c'] = $each->date_c;
				$package['add_date'] = $each->add_date;
				$package['user_type'] = $each->user_type;
				$package['order_type'] = $each->order_type;
				$mem[] = $package;
			}
			array_multisort(array_column($mem, 'recurring_pay_start_date'), SORT_DESC, $mem);
			return  $mem;
		}
		public function autosendinvoice() {
			$result=$this->admin_model->getallDistinct_Invoice('customer_payment_request'); 
			
			$getallRecurringRecord=$this->setDataInArray($result);    
		
	 		$today=date('Y-m-d');  
			

			
			if(count($getallRecurringRecord) > 0 ) {
				
				foreach ($getallRecurringRecord as $key => $row) {
			
					$recurring_payment=$row['recurring_payment'];
					$g=$row['recurring_pay_start_date'];
					$e=$row['recurring_next_pay_date'];
					$merchant_id=$row['merchant_id'];
					$recurring_type=$row['recurring_type'];
					$email_id=$row['email_id'];
					$remain=$row['recurring_count_remain'];
				
					$b=$row['recurring_pay_type'];
					
					if( $remain >0 &&  $recurring_payment=='start' && $row['no_of_invoice']!=$row['recurring_count'] ) { 
						 
					 	switch($b) {
						 	case "1" :
								if($today==$g   &&  ( $row['status']=='confirm' || $row['status']=='Chargeback_Confirm' ) ){    
									//echo $row['invoice_no'];  echo " T1<br/>";   // metach  today with  payment   @@ nothing send  
								}
								if( $today==$g   &&  $row['status']!='confirm' && $row['status']!='Chargeback_Confirm'  ) {   
									$data2 = Array(
										'reference' => $row['reference'],
										'name' => $row['name'],
										'other_charges' => $row['other_charges'],
                                        'otherChargesName' => $row['other_charges_title'],
										'invoice_no' => $row['invoice_no'],
										'email_id' => $row['email_id'],
										'mobile_no' => $row['mobile_no'],
										'amount' => $row['amount'],
										'sub_total' => $row['sub_total'],
										'tax' => $row['tax'],
										'fee' => $row['fee'],
										's_fee' => $row['s_fee'],
										// 'title' => $title,
										'detail' => $row['detail'],
										'note' => $row['note'],
										'url' => $row['url'],
										'payment_type' => $row['payment_type'],
										'recurring_type' => $row['recurring_type'],
										'recurring_count' => $row['recurring_count'],
										// 'due_date' => $due_date,
										'merchant_id' => $row['merchant_id'],
										'sub_merchant_id' => $row['sub_merchant_id'],
										'payment_id' => $row['payment_id'],
										'recurring_payment' => $row['recurring_payment'],
										'recurring_pay_start_date' => $row['recurring_pay_start_date'],
										'recurring_next_pay_date' => $row['recurring_next_pay_date'],
										'recurring_pay_type' => $row['recurring_pay_type'],
										'no_of_invoice' =>$row['no_of_invoice'],
										'add_date' => $row['add_date'],
										'status' => 'pending',
										'year' => $row['year'],
										'month' => $row['month'],
										'time1' => $row['time1'],
										'day1' => $row['day1'],
										'date_c' => $row['date_c'],
										'payment_date' => $row['payment_date'],
										'recurring_count_paid' => $row['recurring_count_paid'],
										'recurring_count_remain' => $row['recurring_count_remain'], 
										'transaction_id' => "", 
										'message' =>  "",
										'card_type' =>  $row['card_type'],
										'card_no' =>  $row['card_no'],
										'sign' =>  "",
										'address' =>  $row['address'],
										'name_card' =>  $row['name_card'],
										'l_name' => "",
										'address_status' =>  $row['address_status'],
										'zip_status' =>  $row['zip_status'],
										'cvv_status' =>  $row['cvv_status'],
										'ip_a' => $_SERVER['REMOTE_ADDR'],
										'order_type' => 'a'
									);
									//print_r($data2);   die(); 
									//$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
									
									$itemres = $this->admin_model->data_get_where_1("order_item", array("p_id" => $row['id']));
										//print_r($itemres);  die(); 
									$data['resend'] = "";
									$item_Detail_1 = array(
										"p_id" => $itemres[0]['p_id'],
										"item_name" => $itemres[0]['item_name'], 
										"quantity" => $itemres[0]['quantity'],
										"price" => $itemres[0]['price'],
										"tax" => $itemres[0]['tax'],
										"tax_id" => $itemres[0]['tax_id'],
										"tax_per" => $itemres[0]['tax_per'],
										"total_amount" => $itemres[0]['total_amount'],
				
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
									$data2['payment_type'] = $row['payment_type'];
									$data2['recurring_type'] = $row['recurring_type'];
									$data2['no_of_invoice'] = $row['no_of_invoice'];
									$data2['recurring_count'] = $row['recurring_count'] ? $row['recurring_count'] : '&infin;';
									//$this->admin_model->insert_data("order_item", $item_Detail_1);
									
									//$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
									$data2['item_detail'] = $item_Detail_1;  
												
									$data['msgData'] = $data2;
									$msg = $this->load->view('email/invoice', $data, true);
					
									//echo $msg; die(); 
									// echo $email_id; die(); 
									$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
									$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
										"MIME-Version: 1.0" . "\r\n" .
										"Content-type: text/html; charset=UTF-8" . "\r\n";
									
									if(!empty($email_id)){ 
										
										$this->email->from('info@salequick.com',$getDashboardData_m[0]['business_dba_name']);
								
										$this->email->to($email_id);
								
										$this->email->subject($MailSubject);  
								
										$this->email->message($msg);
								
										$this->email->send();
											
									}
								} else if($today==$e  &&  ( $row['status']=='confirm' || $row['status']=='Chargeback_Confirm' )  ) {   
									//echo $row['invoice_no'];  echo "TK<br/>";       //  @@ nothing send 
								} else if($today==$e &&  $row['status']!='confirm' && $row['status']!='Chargeback_Confirm'  ) {   
									 //echo $row['invoice_no'];  echo " TL<br/>";        //   genrate inv and send a new invoice 
									$recurring_pay_start_date=$e;
									switch($recurring_type) {
										case 'daily':
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
										break;
										case 'weekly':
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
										break;
										case 'biweekly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
										break;
										case 'monthly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
										break;
										case 'quarterly':
											$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
										break;
										case 'yearly':
										$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
										break;
										default :
											$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
										break;
									}
									$dfg = date("Ymdhisu");
									$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
														
									$unique2 = "PY" . $dfg;
									$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
										if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }
									
									$today2=date('Y-m-d');
									$data2 = Array(
										'reference' => $row['reference'],
										'name' => $row['name'],
										'other_charges' => $row['other_charges'],
										'otherChargesName' => $row['other_charges_title'],
										'invoice_no' => $row['invoice_no'],
										'email_id' => $row['email_id'],
										'mobile_no' => $row['mobile_no'],
										'amount' => $row['amount'],
										'sub_total' => $row['sub_total'],
										'tax' => $row['tax'],
										'fee' => $row['fee'],
										's_fee' => $row['s_fee'],
										// 'title' => $title,
										'detail' => $row['detail'],
										'note' => $row['note'],
										'url' => $url2,
										'payment_type' => $row['payment_type'],
										'recurring_type' => $row['recurring_type'],
										'recurring_count' => $row['recurring_count'],
										// 'due_date' => $due_date,
										'merchant_id' => $row['merchant_id'],
										'sub_merchant_id' => $row['sub_merchant_id'],
										'payment_id' => $unique2,
										'recurring_payment' => $row['no_of_invoice']+1 == $row['recurring_count'] ? 'stop': $row['recurring_payment'],
										'recurring_pay_start_date' => $recurring_pay_start_date,
										'recurring_next_pay_date' => $recurring_next_pay_date,
										'recurring_pay_type' => $row['recurring_pay_type'],
										'no_of_invoice' =>$row['no_of_invoice']+1, 
										'add_date' => $today2,
										'status' => 'pending',
										'year' => $year,
										'month' => $month,
										'time1' => $time1,
										'day1' => $day1,
										'date_c' => $today2_a,
										'payment_date' => "",
										'recurring_count_paid' => $row['recurring_count_paid'],
										'recurring_count_remain' => $row['recurring_count_remain'], 
										'transaction_id' => "",
										'message' =>  "",
										'card_type' =>  $row['card_type'],
										'card_no' =>  $row['card_no'],
										'sign' =>  "",
										'address' =>  $row['address'],
										'name_card' =>  $row['name_card'],
										'l_name' => "",
										'address_status' =>  $row['address_status'],
										'zip_status' =>  $row['zip_status'],
										'cvv_status' =>  $row['cvv_status'],
										'ip_a' => $_SERVER['REMOTE_ADDR'],
										'order_type' => 'a'
									);
									//print_r($data2);   die(); 
									if( ($row['no_of_invoice']+1) == $row['recurring_count']) {
											$up=$this->Stop_recurring($row['invoice_no'],$row['merchant_id']);
									}
									$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
									
									$itemres = $this->admin_model->data_get_where_1("order_item", array("p_id" => $row['id']));
										$data['resend'] = "";
									$item_Detail_1 = array(
										"p_id" => $id2,
										"item_name" => $itemres[0]['item_name'], 
										"quantity" => $itemres[0]['quantity'],
										"price" => $itemres[0]['price'],
										"tax" => $itemres[0]['tax'],
										"tax_id" => $itemres[0]['tax_id'],
										"tax_per" => $itemres[0]['tax_per'],
										"total_amount" => $itemres[0]['total_amount'],
				
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
									$data2['payment_type'] = $row['payment_type'];
									$data2['recurring_type'] = $row['recurring_type'];
									$data2['no_of_invoice'] = $row['no_of_invoice'] + 1;
									$data2['recurring_count'] = $row['recurring_count'] ? $row['recurring_count'] : '&infin;';
									$this->admin_model->insert_data("order_item", $item_Detail_1);
									
									//$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
									$data2['item_detail'] = $item_Detail_1;  
												
									$data['msgData'] = $data2;
									$msg = $this->load->view('email/invoice', $data, true);
										
									//echo $msg; die(); 
										
									$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
									$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
										"MIME-Version: 1.0" . "\r\n" .
										"Content-type: text/html; charset=UTF-8" . "\r\n";
					
									if(!empty($email_id)){ 
						
										$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
								
										$this->email->to($email_id);
								
										$this->email->subject($MailSubject);
								
										$this->email->message($msg);
								
										$this->email->send();
							
									}  
								}
							 	break;
							 	case "0":
									if($today==$g &&  ( $row['status']=='confirm' || $row['status']=='Chargeback_Confirm' )  )
									{  //echo $row['invoice_no'];  echo " T3<br/>";   // metach  today with  payment   @@nothing here 
									}
									if($today==$g  &&  $row['status']!='confirm' && $row['status']!='Chargeback_Confirm'  ) {  
										//echo $today.'=='.$g; 
										//die("ok");  
										$data2 = Array(
											'reference' => $row['reference'],
											'name' => $row['name'],
											'other_charges' => $row['other_charges'],
											'otherChargesName' => $row['other_charges_title'],
											'invoice_no' => $row['invoice_no'],
											'email_id' => $row['email_id'],
											'mobile_no' => $row['mobile_no'],
											'amount' => $row['amount'],
											'sub_total' => $row['sub_total'],
											'tax' => $row['tax'],
											'fee' => $row['fee'],
											's_fee' => $row['s_fee'],
											// 'title' => $title,
											'detail' => $row['detail'],
											'note' => $row['note'],
											'url' => $row['url'],
											'payment_type' => $row['payment_type'],
											'recurring_type' => $row['recurring_type'],
											'recurring_count' => $row['recurring_count'],
											// 'due_date' => $due_date,
											'merchant_id' => $row['merchant_id'],
											'sub_merchant_id' => $row['sub_merchant_id'],
											'payment_id' => $row['payment_id'],
											'recurring_payment' => $row['recurring_payment'],
											'recurring_pay_start_date' => $row['recurring_pay_start_date'],
											'recurring_next_pay_date' => $row['recurring_next_pay_date'],
											'recurring_pay_type' => $row['recurring_pay_type'],
											'no_of_invoice' =>$row['no_of_invoice'],
											'add_date' => $row['add_date'],
											'status' => 'pending',
											'year' => $row['year'],
											'month' => $row['month'],
											'time1' => $row['time1'],
											'day1' => $row['day1'],
											'date_c' => $row['date_c'],
											'payment_date' => $row['payment_date'],
											'recurring_count_paid' => $row['recurring_count_paid'],
											'recurring_count_remain' => $row['recurring_count_remain'], 
											'transaction_id' => "", 
											'message' =>  "",
											'card_type' =>  $row['card_type'],
											'card_no' =>  $row['card_no'],
											'sign' =>  "",
											'address' =>  $row['address'],
											'name_card' =>  $row['name_card'],
											'l_name' => "",
											'address_status' =>  $row['address_status'],
											'zip_status' =>  $row['zip_status'],
											'cvv_status' =>  $row['cvv_status'],
											'ip_a' => $_SERVER['REMOTE_ADDR'],
											'order_type' => 'a'
										);
										//print_r($data2);   die(); 
											//$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											
											$itemres = $this->admin_model->data_get_where_1("order_item", array("p_id" => $row['id']));
											//print_r($itemres);  die(); 
											$data['resend'] = "";
											$item_Detail_1 = array(
												"p_id" => $itemres[0]['p_id'],
												"item_name" => $itemres[0]['item_name'], 
												"quantity" => $itemres[0]['quantity'],
												"price" => $itemres[0]['price'],
												"tax" => $itemres[0]['tax'],
												"tax_id" => $itemres[0]['tax_id'],
												"tax_per" => $itemres[0]['tax_per'],
												"total_amount" => $itemres[0]['total_amount'],
						
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
											$data2['payment_type'] = $row['payment_type'];
											$data2['recurring_type'] = $row['recurring_type'];
											$data2['no_of_invoice'] = $row['no_of_invoice'];
											$data2['recurring_count'] = $row['recurring_count'] ? $row['recurring_count'] : '&infin;';
											//$this->admin_model->insert_data("order_item", $item_Detail_1);
											
											//$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
											$data2['item_detail'] = $item_Detail_1;  
														
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
							
											//echo $msg; die(); 
											// echo $email_id; die(); 
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
												"MIME-Version: 1.0" . "\r\n" .
												"Content-type: text/html; charset=UTF-8" . "\r\n";
											
											if(!empty($email_id)){ 
												
											$this->email->from('info@salequick.com',$getDashboardData_m[0]['business_dba_name']);
									
											$this->email->to($email_id);
									
											$this->email->subject($MailSubject);  
									
											$this->email->message($msg);
									
											$this->email->send();
									
											}
										}
										else if($today==$e  &&  ( $row['status']=='confirm' || $row['status']=='Chargeback_Confirm' )  )  {  
											$recurring_pay_start_date=$e;
											switch($recurring_type) {
												case 'daily':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
												break;
												case 'weekly':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
												break;
												case 'biweekly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
												break;
												case 'monthly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
												break;
												case 'quarterly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
												break;
												case 'yearly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
												break;
												default :
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
												break; 
												
											}
											$dfg = date("Ymdhisu");
											$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
																
											$unique2 = "PY" . $dfg;
											$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
												if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }
											
											
											$today2=date('Y-m-d'); 
											$data2 = Array(
												'reference' => $row['reference'],
												'name' => $row['name'],
												'other_charges' => $row['other_charges'],
												'otherChargesName' => $row['other_charges_title'],
												'invoice_no' => $row['invoice_no'],
												'email_id' => $row['email_id'],
												'mobile_no' => $row['mobile_no'],
												'amount' => $row['amount'],
												'sub_total' => $row['sub_total'],
												'tax' => $row['tax'],
												'fee' => $row['fee'],
												's_fee' => $row['s_fee'],
												// 'title' => $title,
												'detail' => $row['detail'],
												'note' => $row['note'],
												'url' => $url2,
												'payment_type' => $row['payment_type'],
												'recurring_type' => $row['recurring_type'],
												'recurring_count' => $row['recurring_count'],
												// 'due_date' => $due_date,
												'merchant_id' => $row['merchant_id'],
												'sub_merchant_id' => $row['sub_merchant_id'],
												'payment_id' => $unique2,
												'recurring_payment' => $row['no_of_invoice']+1 == $row['recurring_count'] ? 'stop': $row['recurring_payment'],
												'recurring_pay_start_date' => $recurring_pay_start_date,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $row['recurring_pay_type'],
												'no_of_invoice' =>$row['no_of_invoice']+1, 
												'add_date' => $today2,
												'status' => 'pending',
												'year' => $year,
												'month' => $month,
												'time1' => $time1,
												'day1' => $day1,
												'date_c' => $today2_a,
												'payment_date' => "",
												'recurring_count_paid' => $row['recurring_count_paid'],
												'recurring_count_remain' => $row['recurring_count_remain'], 
												'transaction_id' => "",
												'message' =>  "",
												'card_type' =>  $row['card_type'],
												'card_no' =>  $row['card_no'],
												'sign' =>  "",
												'address' =>  $row['address'],
												'name_card' =>  $row['name_card'],
												'l_name' => "",
												'address_status' =>  $row['address_status'],
												'zip_status' =>  $row['zip_status'],
												'cvv_status' =>  $row['cvv_status'],
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
													//print_r($data2);   die(); 
											if( ($row['no_of_invoice']+1) == $row['recurring_count'])
												{
													$up=$this->Stop_recurring($row['invoice_no'],$row['merchant_id']);
												}
											$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											
											$itemres = $this->admin_model->data_get_where_1("order_item", array("p_id" => $row['id']));
												$data['resend'] = "";
											$item_Detail_1 = array(
												"p_id" => $id2,
												"item_name" => $itemres[0]['item_name'], 
												"quantity" => $itemres[0]['quantity'],
												"price" => $itemres[0]['price'],
												"tax" => $itemres[0]['tax'],
												"tax_id" => $itemres[0]['tax_id'],
												"tax_per" => $itemres[0]['tax_per'],
												"total_amount" => $itemres[0]['total_amount'],
						
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
											$data2['payment_type'] = $row['payment_type'];
											$data2['recurring_type'] = $row['recurring_type'];
											$data2['no_of_invoice'] = $row['no_of_invoice'] + 1;
											$data2['recurring_count'] = $row['recurring_count'] ? $row['recurring_count'] : '&infin;';
											$this->admin_model->insert_data("order_item", $item_Detail_1);
											
											//$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
											$data2['item_detail'] = $item_Detail_1;  
														
											$data['msgData'] = $data2;
											$msg = $this->load->view('email/invoice', $data, true);
									
													//echo $msg; die(); 
														
											$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
											$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
												"MIME-Version: 1.0" . "\r\n" .
												"Content-type: text/html; charset=UTF-8" . "\r\n";
							
											if(!empty($email_id)){ 
								
												$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
											
												$this->email->to($email_id);
										
												$this->email->subject($MailSubject);
										
												$this->email->message($msg);
										
												$this->email->send();
										
											}  
										} 
										else if($today==$e &&  $row['status']!='confirm' && $row['status']!='Chargeback_Confirm'  ) {  
											$recurring_pay_start_date=$e;
											switch($recurring_type) {
												case 'daily':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
												break;
												case 'weekly':
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
												break;
												case 'biweekly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
												break;
												case 'monthly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
												break;
												case 'quarterly':
													$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
												break;
												case 'yearly':
												$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
												break;
												default :
													$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
												break; 
												
											}
											$dfg = date("Ymdhisu");
											$url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
																
											$unique2 = "PY" . $dfg;
											$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
												if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }
											
											
											$today2=date('Y-m-d'); 
											$data2 = Array(
												'reference' => $row['reference'],
												'name' => $row['name'],
												'other_charges' => $row['other_charges'],
												'otherChargesName' => $row['other_charges_title'],
												'invoice_no' => $row['invoice_no'],
												'email_id' => $row['email_id'],
												'mobile_no' => $row['mobile_no'],
												'amount' => $row['amount'],
												'sub_total' => $row['sub_total'],
												'tax' => $row['tax'],
												'fee' => $row['fee'],
												's_fee' => $row['s_fee'],
												// 'title' => $title,
												'detail' => $row['detail'],
												'note' => $row['note'],
												'url' => $url2,
												'payment_type' => $row['payment_type'],
												'recurring_type' => $row['recurring_type'],
												'recurring_count' => $row['recurring_count'],
												// 'due_date' => $due_date,
												'merchant_id' => $row['merchant_id'],
												'sub_merchant_id' => $row['sub_merchant_id'],
												'payment_id' => $unique2,
												'recurring_payment' => $row['no_of_invoice']+1 == $row['recurring_count'] ? 'stop': $row['recurring_payment'],
												'recurring_pay_start_date' => $recurring_pay_start_date,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $row['recurring_pay_type'],
												'no_of_invoice' =>$row['no_of_invoice']+1, 
												'add_date' => $today2,
												'status' => 'pending',
												'year' => $year,
												'month' => $month,
												'time1' => $time1,
												'day1' => $day1,
												'date_c' => $today2_a,
												'payment_date' => "",
												'recurring_count_paid' => $row['recurring_count_paid'],
												'recurring_count_remain' => $row['recurring_count_remain'], 
												'transaction_id' => "",
												'message' =>  "",
												'card_type' =>  $row['card_type'],
												'card_no' =>  $row['card_no'],
												'sign' =>  "",
												'address' =>  $row['address'],
												'name_card' =>  $row['name_card'],
												'l_name' => "",
												'address_status' =>  $row['address_status'],
												'zip_status' =>  $row['zip_status'],
												'cvv_status' =>  $row['cvv_status'],
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
											//print_r($data2);   die(); 
											 if( ($row['no_of_invoice']+1) == $row['recurring_count'])
												{
													$up=$this->Stop_recurring($row['invoice_no'],$row['merchant_id']);
												}
												$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
												
												$itemres = $this->admin_model->data_get_where_1("order_item", array("p_id" => $row['id']));
													$data['resend'] = "";
												$item_Detail_1 = array(
													"p_id" => $id2,
													"item_name" => $itemres[0]['item_name'], 
													"quantity" => $itemres[0]['quantity'],
													"price" => $itemres[0]['price'],
													"tax" => $itemres[0]['tax'],
													"tax_id" => $itemres[0]['tax_id'],
													"tax_per" => $itemres[0]['tax_per'],
													"total_amount" => $itemres[0]['total_amount'],
							
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
												$data2['payment_type'] = $row['payment_type'];
												$data2['recurring_type'] = $row['recurring_type'];
												$data2['no_of_invoice'] = $row['no_of_invoice'] + 1;
												$data2['recurring_count'] = $row['recurring_count'] ? $row['recurring_count'] : '&infin;';
												$this->admin_model->insert_data("order_item", $item_Detail_1);
												
												//$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
												$data2['item_detail'] = $item_Detail_1;  
															
												$data['msgData'] = $data2;
												$msg = $this->load->view('email/invoice', $data, true);
								
												//echo $msg; die(); 
													
												$MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
												$header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
													"MIME-Version: 1.0" . "\r\n" .
													"Content-type: text/html; charset=UTF-8" . "\r\n";
								
												if(!empty($email_id)){ 
											
													$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
											
													$this->email->to($email_id);
											
													$this->email->subject($MailSubject);
											
													$this->email->message($msg);
											
													$this->email->send();
												
												}  
											}
								 	break;
								//  default:
								//     if($today==$g)
								//     {  echo $row['invoice_no'];  echo " T7<br/>"; 
								//     }
								//     else if($today==$e  &&  $b=='0' ) 
								//     {  echo $row['invoice_no'];  echo " T8<br/>";  
								//  }
								//  break;
							 }
							
						}
				}
				echo "  Invoices Auto Send Successfully ..";
			}
			
				 
	 
	 	}
		public function Stop_recurring($invoice_no,$merchant_id) {
			$getallRecurringRecord = $this->db->query("UPDATE  customer_payment_request SET recurring_payment='stop' WHERE invoice_no='$invoice_no' AND  merchant_id='$merchant_id'   ");
			return true; 
		}
		public function testmailfuncion() {
			$merchnat_msg="recurring OOOOOOOOOOO Working Email Msg";
			$MailSubject="recurring Test";
		//	$merchant_email="vaibhav.angad@gmail.com";//'pk1105806@gmail.com';
			$this->email->from('info@salequick.com',"gsjgfgsjjkg");
			$this->email->to($merchant_email);
			$this->email->subject($MailSubject);
			$this->email->message($merchnat_msg);
			$this->email->send();
		}
		public function autocallfunction() {   
			//  $this->testmailfuncion(); 
			$this->autosendinvoice();  
	 
		 	$result=$this->admin_model->getallDistinct_Invoice_for_autopayment('customer_payment_request'); 
		 	$getallRecurringRecord=$this->setDataInArray($result);
			// echo "<pre>";print_r($result);die; 
		 	// echo $this->db->last_query();
			// $getallRecurringRecord = $this->db->query("SELECT  * FROM customer_payment_request WHERE  payment_type='recurring' AND ( recurring_payment='start' OR recurring_payment='stop' ) AND recurring_type!='' AND recurring_count_remain >0  AND recurring_pay_type='1'    ");
			// $reptdata['getEmail']=$getallRecurringRecord = $getallRecurringRecord->result_array(); 
			//print_r($getallRecurringRecord);  
			// die(); 
 
			if(count($getallRecurringRecord)) {
				foreach ($getallRecurringRecord as $key => $row) {
		
					$a=$row['recurring_payment'];
					$c=$row['recurring_count_remain'];
					$e=$row['recurring_next_pay_date'];
					$b=$row['recurring_pay_type'];
					$d=date('Y-m-d');  
					if( $b=='1'  &&  $c >0 && $d==$e && $a!='complete' && $a =='start' && $row['no_of_invoice']!=$row['recurring_count'] ) {           
						//  echo $e;  die("okl"); 
					 	$id=$row['id']; 
						$transaction_id=$row['transaction_id']; 
						$merchant_id=$row['merchant_id']; 
						$card_type=$row['card_type']; 
						$mobile_no=$row['mobile_no'];
						$email_id=$row['email_id'];
						$amount=$row['amount'];
						$invoice_no=$row['invoice_no'];
						$getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
						$Merchantdata = $getMerchantdata->row_array();
						$reptdata['getEmail1']=$getMerchantdata->result_array();
						//print_r($Merchantdata); die(); 
						$account_id=$Merchantdata['account_id_cnp']; 
						$account_token=$Merchantdata['account_token_cnp']; 
						$acceptor_id=$Merchantdata['acceptor_id_cnp']; 
						$application_id=$Merchantdata['application_id_cnp']; 
						$terminal_id=$Merchantdata['terminal_id']; 
						$TicketNumber =  (rand(100000,999999)); 
						$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  
						$getQuery_t = $this->db->query(" SELECT token.*,invoice_token.invoice_no FROM token INNER JOIN invoice_token on token.id=invoice_token.token_id  WHERE token.mobile='$mob'   AND invoice_token.invoice_no='$invoice_no' group by card_no"); 
						//$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
						// echo $this->db->last_query(); 
						$token_data = $getQuery_t->row_array();
						$paymentcard=$token_data['token']; 
						//  print_r($token_data); 
						//  die("plo");    
							//  //  Declined   //  Expired Card 
						 
							/* $ExpressResponseMessage='Expired Card'; 
						 	if($ExpressResponseMessage=='Declined')
							 {    
									 /// send an email  to Merchant that Payment is Declined  Today 
									 $msg='<!DOCTYPE html>
									 <html>
									 <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
											 <title>! Declined   Payment ! </title>
									 </head>
									 <body>
											 <div><center> You Have A Payment  With :: Declined   ! Today. </center></div>
									 </body>
									 </html>'; 
							 //$merchant_email='vaibhav.angad@gmail.com'; 
							 $merchant_email=$Merchantdata['email'];
							 $MailSubject = 'Salequick : Declined   Payment'; 
							 if(!empty($merchant_email)){ 
			 
									 $this->email->from('info@salequick.com', 'SaleQuick Payment');
									 $this->email->to($merchant_email);
									 $this->email->subject($MailSubject);
									 $this->email->message($msg);
									 $this->email->send();
									 }
							 $m=$this->retrypayment('Declined',$Merchantdata,$token_data,$id,$transaction_id,$merchant_id,$card_type,$mobile_no,$email_id,$amount);    
							 
					 		}
					 		else if($ExpressResponseMessage=='Expired Card')
					 			{
									//echo $email=$row['email_id']; echo $merchant_email=$Merchantdata['email'];
									 //echo $id;  
									 //die("expire"); 
									 
									 
									 $html_customer='<!DOCTYPE html>
											 <html>
											 <head>
											 <title>Expired Card</title>
											 
											 <meta name="viewport" content="width=device-width,initial-scale=1">
											 <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet" />
											 </head>
											 <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
											 <div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
											 <div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
											 <a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
											 <img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;" />
											 </a>
											 <h3 style="margin-top: 35px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">
											 Update Your card</h3>
											 </div>
											 <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
											 <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
											 <div style="width: auto;font-weight: 600;margin: 0 auto;color: #444;text-align: center;display: inline-block;">
											 <p style="margin-bottom: 21px; float: left; width: 100%; clear: both; ">Hi '.$token_data["name"].', Your <span style="color: #d0021b;">Card is expired</span> details are below.</p> <p style="font-size: 21px;float: left;width: 100%;clear: both;">Invalid card Detail</p>
											 <p style="display: inline-block;width: auto;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 65px;float: left;text-align: left;padding: 0 4px;box-sizing: border-box;">Card No:</span>
											 <span style="display: block;width: auto;float: left;padding: 0 5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_no'].'</span>
											 </p>
											 <p style="width: auto;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
											 <span style="display: block;width: 80px;float: left;text-align: left;padding: 0 4px;box-sizing: border-box;">Exp Month:</span>
											 <span style="display: block;width: auto;float: left;padding: 0 5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_expiry_month'].'</span>
											 </p>
											 <p style="width: auto;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
											 <span style="display: block;width: 80px;float: left;text-align: left;padding: 0 4px;box-sizing: border-box;">Exp Year:</span>
											 <span style="display: block;width: auto;float: left;padding: 0 5px;box-sizing: border-box;color: #666;font-weight: normal;">20'.$token_data['card_expiry_year'].'</span>
											 </p>
											 </div>
											 </div>
											 </div>
											 <div style="padding: 21px 15px;overflow:hidden;background: #f4f7fc;clear: both;">
											 <div style="width:100%;margin:0 auto;overflow:hidden;clear: both;">
											 <div style="width: 100%;margin:10px auto 20px;text-align:center;clear: both;padding: 0 15px;max-width: 100%;box-sizing: border-box;text-align: center;">
											 <p style="display: inline-block;vertical-align: top;"><a  href="'.base_url().'signup/updatecard/'.$row["id"].'" style="color: rgb(172, 203, 242);text-decoration: none;padding: 11px 21px;border-radius: 3px;background: #2978dd;border: 1px solid #2978dd;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> Update Your Crad Info</a></p>
											 </div>
											 </div>
											 </div>
											 <div style="width:100%;border-top: 1px solid #3f86e1;padding: 25px 15px;background: #357fdf;margin-top:0px;clear:both;box-sizing: border-box;">
											 <div style="text-align:center;width:100%;margin:0 auto">
											 <p style="text-align: center;color:rgb(210, 227, 248);margin-top: 30px;">Powered by: <a href="https://salequick.com/"  style="color: rgb(172, 203, 242);cursor:pointer;text-decoration: none;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> SaleQuick.com</a></p>
											 </div>
											 </div>
											 </div>
											 </body>
											 </html>';
									 //$email='vaibhav.angad@gmail.com'; 
									 $email=$row['email_id'];
									 $MailSubject_customer = 'Salequick : Expired Card  Payment'; 
									 if(!empty($email)){ 
											 $this->email->from('info@salequick.com', 'SaleQuick Payment');
											 $this->email->to($email);
											 $this->email->subject($MailSubject_customer);
											 $this->email->message($html_customer);
											 $this->email->send();
											 }
											 $html_merchant='<!DOCTYPE html>
													 <html>
													 <head>
													 <title>Expired Card  Payment</title>
													 
													 <meta name="viewport" content="width=device-width,initial-scale=1">
													 <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet" />
													 </head>
													 <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
													 <div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
													 <div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
													 <a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
													 <img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;" />
													 </a>
													 <h3 style="margin-top: 25px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">
													 Customer</h3>
													 </div>
													 <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
													 <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
													 <div style="width: auto;font-weight: 600;color: #656565;text-align: center;display: inline-block;max-width: 623px;margin: 0 auto;background-color: #fff;border: 1px solid #ddd;">
													 <p style="font-size: 21px;float: left;width: 100%;clear: both;color: #444">Crad Details</p>
													 <div style="float: left;width: 100%;clear: both;">
													 <br/>
													 </div>
													 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
													 <span style="display: block;width: 51px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Email:</span>
													 <span style="display: block;width: auto;float: left;background-color:#f1f1f1;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["email_id"].'</span>
													 </p>
													 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
													 <span style="display: block;width: 55px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Phone:</span>
													 <span style="display: block;width: auto;float: left;background-color:#f1f1f1;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["mobile_no"].'</span>
													 </p>
													 <br/>
													 <br/>
													 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
													 <span style="display: block;width: 81px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card Name:</span>
													 <span style="display: block;width: auto;float: left;background-color:#f1f1f1;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['name'].'</span>
													 </p>
													 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
													 <span style="display: block;width: 65px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card No:</span>
													 <span style="display: block;width: auto;float: left;background-color:#f1f1f1;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_no'].'</span>
													 </p>
													 <p style="max-width: 301px;width: 100%;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
													 <span style="display: block;width: 80px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Exp Month:</span>
													 <span style="display: block;width: auto;float: left;background-color:#f1f1f1;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_no'].'</span>
													 </p>
													 <p style="max-width: 301px;width: 100%;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
													 <span style="display: block;width: 80px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Exp Year:</span>
													 <span style="display: block;width: auto;float: left;background-color:#f1f1f1;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">20'.$token_data['card_expiry_year'].'</span>
													 </p>
													 </div>
													 </div>
													 </div>
													 <div style="float: left;width: 100%;clear: both;">
													 <br/>
													 </div>
													 <div style="width:100%;border-top: 1px solid #3f86e1;padding: 25px 15px;background: #357fdf;margin-top:0px;clear:both;box-sizing: border-box;">
													 <div style="text-align:center;width:100%;margin:0 auto">
													 <p style="text-align: center;color:rgb(210, 227, 248);margin-top: 30px;">Powered by: <a href="https://salequick.com/"  style="color: rgb(172, 203, 242);cursor:pointer;text-decoration: none;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> SaleQuick.com</a></p>
													 </div>
													 </div>
													 </div>
													 </body>
													 </html>';
										//$merchant_email='pk1105806@gmail.com'; 
										$merchant_email=$Merchantdata['email'];
										$MailSubject_merchant = 'Salequick : Expired Card   Payment'; 
										if(!empty($merchant_email)){ 
												$this->email->from('info@salequick.com', 'SaleQuick Payment');
												$this->email->to($merchant_email);
												$this->email->subject($MailSubject_merchant);
												$this->email->message($html_merchant);
												$this->email->send();
												}
						 } 
					 
						 die(" <br/>Auto payment block by Developer");
							 */
							//print_r($token_data); die(); 
					 	$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
						//  $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
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
						 </CreditCardSale>";   // data from the form, e.g. some ID number
						 //print_r($xml_post_string); die();   
						 $headers = array(
						 "Content-type: text/xml;charset=\"utf-8\"",
						 "Accept: text/xml",
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
						 //print_r($arrayy);   die(); 
						 //echo 'shuaeb'; 
						 curl_close($ch);
					 	if($arrayy['Response']['ExpressResponseMessage']=='Approved' ) {
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
							 $type=$row['payment_type'];
							 $recurring_type=$row['recurring_type'];
							 $recurring_count=$row['recurring_count'];
															
							 $paid=$row['recurring_count_paid']+1;
							 //$remain=$row['recurring_count_remain']-1;   ///  before constant feature
							 $remain=($recurring_count >0)?$row['recurring_count_remain']-1:1; 
							 //$recurring_pay_start_date=$row['recurring_pay_start_date'];
							 $recurring_pay_start_date=$row['recurring_next_pay_date'];
							 $recurring_next1=$row['recurring_next_pay_date'];
							 
							 $sub_total=$row['sub_total']+$amount;
							 $paytype=$row['recurring_pay_type']; 
							 $recurring_payment=$row['recurring_payment'];     //   start, stop,  complete
							 
								$lastRecord=$this->admin_model->getlast_request("customer_payment_request", $row['invoice_no'],$row['merchant_id'] );
			
								$AllPaidRequest=$this->admin_model->getAllpaid_request("customer_payment_request", $row['invoice_no'],$row['merchant_id'] );
								//print_r($lastRecord->recurring_count); echo "<br/>";
							// print_r($AllPaidRequest);
							
								if($lastRecord->recurring_count == $AllPaidRequest+1)
								{
										$recurring_payment = 'complete';
								}
								else
								{
										$recurring_payment = $row['recurring_payment'];
								}
					 
							//  if($remain =='0')   
							//  {
							//      $recurring_payment='complete';    
							//  }
							//  else{
							//      $recurring_payment='start'; 
							//  }
							 $today1 = date("Ymdhisu");
							 $url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
							 $unique = "PY" . $today1;
							 $today2=date('Y-m-d'); 
							//  if($row['recurring_payment']=='start' )
											//  {
													
													 
						 	$recurring_next=date($recurring_next1); 
						 	switch($recurring_type) {
								 case 'daily':
									 $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
								 break;  
								 case 'weekly':
									 $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_next)));
								 break;
								 case 'biweekly':
										$recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_next)));
								 break;
								 case 'monthly':
									 $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_next)));
								 break;
								 case 'quarterly':
									 $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_next)));
								 break;
								 case 'yearly':
								 $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_next)));
								 break;
								 default :
										 $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
								 break; 
							} 
						 	//print_r($recurring_pay_start_date);  die();
						 	$today2=date('Y-m-d'); 
						 	if($type=='recurring'){
	 
							 	$data2=$info2 = Array(
									 'reference' => $row['reference'],
									 'name' => $row['name'],
									 'invoice_no' => $row['invoice_no'],
									 'email_id' => $row['email_id'],
									 'mobile_no' => $row['mobile_no'],
									 'amount' => $row['amount'],
									 'sub_total' => $sub_total,
									 'tax' => $row['tax'],
									 'fee' => $row['fee'],
									 's_fee' => $row['s_fee'],
									 // 'title' => $row['title'],
									 'detail' => $row['detail'],
									 'note' => $row['note'],
									 'url' => $url,    /// recurring_payment
									 'payment_type' => 'recurring',
									 'recurring_type' => $row['recurring_type'],
									 'recurring_count' => $row['recurring_count'],
									 // 'due_date' => $row['due_date'],
									 'merchant_id' => $row['merchant_id'],
									 'sub_merchant_id' => $row['sub_merchant_id'],
									 'payment_id'=>$unique,
									 'recurring_payment' => $row['no_of_invoice']+1 == $row['recurring_count'] ? 'complete': $recurring_payment,
									 'no_of_invoice' =>$row['no_of_invoice']+1,
									 'recurring_pay_start_date' => $recurring_pay_start_date,
									 'recurring_next_pay_date' => $recurring_next_pay_date,
									 'recurring_pay_type' => $paytype,
									 'sign' =>  $row['sign'],
									 'add_date' => $today2,  ///fffff
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
									 'card_type' =>  $row['card_type'],
									 'card_no' =>  $row['card_no'],
									 'address' =>  $row['address'],
									 'name_card' =>  $row['name_card'],
									 'address_status' =>  $row['address_status'],
									 'zip_status' =>  $row['zip_status'],
									 'cvv_status' =>$row['cvv_status'] ,
									 'ip_a' => $_SERVER['REMOTE_ADDR'],
									 'order_type' => 'a' 
							 	);
						 	}
							//  $row['no_of_invoice']!=$row['recurring_count']
							if( ($row['no_of_invoice']+1) == $row['recurring_count'])
							{
								$up=$this->Stop_recurring($row['invoice_no'],$row['merchant_id']);
							}
						 	$id1 = $this->admin_model->insert_data("customer_payment_request", $info2);
							 //echo $this->db->last_query();  echo "<br/>";
							 //die("okl"); 
							//  echo $row['no_of_invoice']+1;echo "<br/>";
							//  echo $row['recurring_count']; echo "<br/>";
							//  print_r($info2); die();
							//  $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
							 $orderitem=$this->db->query("SELECT * FROM order_item WHERE p_id ='$id' ")->row_array(); 
							 $data2['resend'] = "";
							 $item_Detail_1 = array(
									 "p_id" => $id1,
									 "item_name" => $orderitem['item_name'], 
									 "quantity" => $orderitem['quantity'],
									 "price" => $orderitem['price'],
									 "tax" => $orderitem['tax'],
									 "tax_id" => $orderitem['tax_id'],
									 "tax_per" => $orderitem['tax_per'],
									 "total_amount" => $orderitem['total_amount'],
							 );
							 $this->admin_model->insert_data("order_item", $item_Detail_1); 
							// } 
							 //$m=$this->home_model->update_payment_single($id, $info);
							 $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id1."' ");
							 $getEmail = $getQuery->result_array();
							 $data['getEmail'] = $getEmail;
							//  $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
							//  $getEmail = $getQuery->result_array();
							//  $data['getEmail'] = $getEmail; 
							 $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
							 $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
							 $data['getEmail1'] = $getEmail1; 
							 $data['resend'] = "";
							 $email = $email_id;
							 $amount = $amount;  
							 $sub_total =$sub_total;
							 $tax = $row['tax']; 
							 $originalDate = $row['date_c'];
							 $newDate = date("F d,Y", strtotime($originalDate)); 
							 $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id1));
							 //Email Process
						 	$data['email'] = $row['email_id'];
						 	$data['color'] = $Merchantdata['color'];
						 	$data['amount'] = $amount;  
						 	$data['invoice_detail_receipt_item']=$item; 
						 	$data['sub_total'] = $sub_total;
						 	$data['tax'] = $row['tax']; 
						 	$data['originalDate'] = $row['date_c'];
						 	$data['card_a_no'] = $card_a_no;
						 	$data['trans_a_no'] = $trans_a_no;
						 	$data['card_a_type'] = $card_a_type;
						 	$data['message_a'] = $message_a;
						 	$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
							$data['late_fee'] = $getEmail[0]['late_fee'];
						 	$data['payment_type'] = 'recurring';
						 	$data['recurring_type'] = $row['recurring_type'];
							$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
							$data['recurring_count'] = $row['recurring_count'] ? $row['recurring_count'] : '&infin;';
							 $data['msgData'] = $data;
							 $msg = $this->load->view('email/receipt', $data, true);
							 $merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
							 $email = $row['email_id'];  
							 //echo  $email;   die("ok"); 
							 $MailSubject = ' Receipt from '.$Merchantdata['business_dba_name']; 
							 $name_of_customer = $row['name'] ? $row['name'] : $row['email_id'];
							 $MailSubject2 = ' Receipt to ' . $name_of_customer;
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
							 //$sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
							 // $from = '+18325324983'; //trial account twilio number
							 // $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
							 // $to = '+1'.$mob;
							 // $response = $this->twilio->sms($from, $to,$sms_message);
							 // }
						 	//$merchant_email='vaibhav.angad@gmail.com';
							if (!empty($Merchantdata['email'])) {
								$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
								$this->email->to($Merchantdata['email']);
								$this->email->subject($MailSubject2);
								$this->email->message($merchnat_msg);
								$this->email->send();
							}
							$merchant_notification_email=$Merchantdata['notification_email'];
							if(!empty($merchant_notification_email)){   
								$notic_emails=explode(",",$merchant_notification_email);
								$length=count($notic_emails); 
								$i=0; $arraydata=array(); 
								for( $i=0; $i < $length; $i++)
								{
									$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
									$this->email->to($notic_emails[$i]);
									$this->email->subject($MailSubject2);
									$this->email->message($merchnat_msg);
									$this->email->send();
									//array_push($arraydata,$notic_emails[$i]);
									}
							}
											 
							 //print_r($token_data); die; 
							 $save_notificationdata = array(
								 'merchant_id'=>$row['merchant_id'], 
								 'name' => $row['name'],
								 'mobile' => $row['mobile_no'],
								 'email' => $row['email_id'],
								 'card_type' =>  $token_data['card_type'],
								 'card_expiry_month'=> $token_data['card_expiry_month'],
								 'card_expiry_year'=> $token_data['card_expiry_year'],
								 'card_no' => $token_data['card_no'],
								 'amount'  =>$amount,
								 'address' =>$row['address'],
								 'transaction_id'=>$trans_a_no,
								 'transaction_date'=>$transaction_date,
								 'notification_type' => 'payment',
								 'invoice_no'=>$row['invoice_no'],
								 'status'   =>'unread'
							 );
						 	//print_r($save_notificationdata); die(); 
						 	$this->db->insert('notification',$save_notificationdata);
						 	echo "All Auto Payment Complete of This date"; 
									 }
									 else if($arrayy['Response']['ExpressResponseMessage']=='Declined')
									 {    
											
											 /// send an email  to Merchant that Payment is Declined  Today 
											 if($row["recurring_pay_type"] == '1'){
													 $paytyps='Auto';
											 }
											 else{
													 $paytyps='Manual';
											 }
											 $msg='<!DOCTYPE html>
											 <html><head>
											 <title>Decline Payment</title>
											 
											 <meta name="viewport" content="width=device-width,initial-scale=1">
											 <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
											 </head>
											 <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
											 <div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
											 <div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
											 <a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
											 <img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;">
											 </a>
											 <h3 style="margin-top: 25px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">
											 Card Declined </h3>
											 </div>
											 <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
											 <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
											 <div style="width: auto;font-weight: 600;color: #656565;text-align: center;display: inline-block;max-width: 623px;margin: 0 auto;background-color: rgba(53, 127, 223, 0.05);border: 1px solid rgba(53, 127, 223, 0.2);">
											 <p style="font-size: 21px;float: left;width: 100%;clear: both;color: #444">Card <span style="color: #d0021b;">Declined</span></p>
											 <div style="float: left;width: 100%;clear: both;">
											 <br>
											 </div>
											 <br>
											 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Invoice No:</span>
											 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["invoice_no"].' </span>
											 </p>
											 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Amount:</span>
											 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["amount"].'</span>
											 </p>
											 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Payment Type:</span>
											 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$paytyps.' </span>
											 </p>
											 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Name:</span>
											 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["name"].'</span>
											 </p>
											 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Email:</span>
											 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["email_id"].'</span>
											 </p>
											 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
											 <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Phone:</span>
											 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["mobile_no"].'</span>
											 </p>
											 <br>
											 </div>
											 </div>
											 </div>
											 <div style="float: left;width: 100%;clear: both;">
											 <br>
											 </div>
											 <div style="width:100%;border-top: 1px solid #3f86e1;padding: 25px 15px;background: #357fdf;margin-top:0px;clear:both;box-sizing: border-box;">
											 <div style="text-align:center;width:100%;margin:0 auto">
											 <p style="text-align: center;color:rgb(210, 227, 248);margin-top: 30px;">Powered by: <a href="https://salequick.com/" style="color: rgb(172, 203, 242);cursor:pointer;text-decoration: none;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> SaleQuick.com</a></p>
											 </div>
											 </div>
											 </div>
											 </body>
											 </html>'; 
											 //$merchant_email='vaibhav.angad@gmail.com'; 
											 $merchant_email=$Merchantdata['email'];
											 $customername=$row['name'] ? $row['name']:$row['email_id']; 
											 $MailSubject = ' Declined   Payment from '.$Merchantdata['business_dba_name'];
											 if(!empty($row['email_id'])){ 
							 
												$this->email->from('info@salequick.com',  $Merchantdata['business_dba_name']);
												$this->email->to($row['email_id']);
												$this->email->subject($MailSubject);
												$this->email->message($msg);
												$this->email->send();
												}
												 
											
											//  if(!empty($merchant_email)){ 
							 
											//      $this->email->from('info@salequick.com',  $Merchantdata['business_dba_name']);
											//      $this->email->to($merchant_email);
											//      $this->email->subject($MailSubject);
											//      $this->email->message($msg);
											//      $this->email->send();
											//      }
												// $merchant_notification_email=$Merchantdata['notification_email'];
												// if(!empty($merchant_notification_email)){  
												//   $notic_emails=explode(",",$merchant_notification_email);
												//   $length=count($notic_emails); 
												//   $i=0; $arraydata=array(); 
												//   for( $i=0; $i < $length; $i++)
												//   {
												//     $this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
												//     $this->email->to($notic_emails[$i]);
												//     $this->email->subject($MailSubject);
												//     $this->email->message($msg);
												//     $this->email->send();
												//     //array_push($arraydata,$notic_emails[$i]);
												//     }
												// }
											 $m=$this->retrypayment('Declined',$Merchantdata,$token_data,$id,$transaction_id,$merchant_id,$card_type,$mobile_no,$email_id,$amount);    
											 
									 }
									 else if($arrayy['Response']['ExpressResponseMessage']=='Expired Card')
									 {
													//echo $email=$row['email_id']; echo $merchant_email=$Merchantdata['email'];
													 //echo $id;  
													 //die("expire"); 
													 
													 
													 $html_customer='<!DOCTYPE html>
															 <html>
															 <head>
															 <title>Expired Card</title>
															 
															 <meta name="viewport" content="width=device-width,initial-scale=1">
															 <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet" />
															 </head>
															 <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
															 <div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
															 <div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
															 <a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
															 <img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;" />
															 </a>
															 <h3 style="margin-top: 35px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">
															 Update Your card</h3>
															 </div>
															 <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
															 <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
															 <div style="width: auto;font-weight: 600;margin: 0 auto;color: #444;text-align: center;display: inline-block;">
															 <p style="margin-bottom: 21px; float: left; width: 100%; clear: both; ">Hi '.$token_data["name"].', Your <span style="color: #d0021b;">Card is expired</span> details are below.</p> <p style="font-size: 21px;float: left;width: 100%;clear: both;">Invalid card Detail</p>
															 <p style="display: inline-block;width: auto;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															 <span style="display: block;width: 65px;float: left;text-align: left;padding: 0 4px;box-sizing: border-box;">Card No:</span>
															 <span style="display: block;width: auto;float: left;padding: 0 5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_no'].'</span>
															 </p>
															 <p style="width: auto;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
															 <span style="display: block;width: 80px;float: left;text-align: left;padding: 0 4px;box-sizing: border-box;">Exp Month:</span>
															 <span style="display: block;width: auto;float: left;padding: 0 5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_expiry_month'].'</span>
															 </p>
															 <p style="width: auto;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
															 <span style="display: block;width: 80px;float: left;text-align: left;padding: 0 4px;box-sizing: border-box;">Exp Year:</span>
															 <span style="display: block;width: auto;float: left;padding: 0 5px;box-sizing: border-box;color: #666;font-weight: normal;">20'.$token_data['card_expiry_year'].'</span>
															 </p>
															 </div>
															 </div>
															 </div>
															 <div style="padding: 21px 15px;overflow:hidden;background: #f4f7fc;clear: both;">
															 <div style="width:100%;margin:0 auto;overflow:hidden;clear: both;">
															 <div style="width: 100%;margin:10px auto 20px;text-align:center;clear: both;padding: 0 15px;max-width: 100%;box-sizing: border-box;text-align: center;">
															 <p style="display: inline-block;vertical-align: top;"><a  href="'.base_url().'"signup/updatecard/'.$row["id"].'" style="color: rgb(172, 203, 242);text-decoration: none;padding: 11px 21px;border-radius: 3px;background: #2978dd;border: 1px solid #2978dd;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> Update Your Crad Info</a></p>
															 </div>
															 </div>
															 </div>
															 <div style="width:100%;border-top: 1px solid #3f86e1;padding: 25px 15px;background: #357fdf;margin-top:0px;clear:both;box-sizing: border-box;">
															 <div style="text-align:center;width:100%;margin:0 auto">
															 <p style="text-align: center;color:rgb(210, 227, 248);margin-top: 30px;">Powered by: <a href="https://salequick.com/"  style="color: rgb(172, 203, 242);cursor:pointer;text-decoration: none;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> SaleQuick.com</a></p>
															 </div>
															 </div>
															 </div>
															 </body>
															 </html>';
													 //$email='vaibhav.angad@gmail.com'; 
													 $email=$row['email_id'];
													 $MailSubject_customer = 'Card hase been  Expired : '.$Merchantdata['business_dba_name']; 
													 if(!empty($email)){ 
															 $this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
															 $this->email->to($email);
															 $this->email->subject($MailSubject_customer);
															 $this->email->message($html_customer);
															 $this->email->send();
															 }
													 
															 $html_merchant='<!DOCTYPE html>
																	 <html><head>
																	 <title>Expired Card Detail</title>
																	 
																	 <meta name="viewport" content="width=device-width,initial-scale=1">
																	 <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
																	 </head>
																	 <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
																	 <div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
																	 <div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
																	 <a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
																	 <img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;">
																	 </a>
																	 <h3 style="margin-top: 25px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">
																	 Customer</h3>
																	 </div>
																	 <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
																	 <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
																	 <div style="width: auto;font-weight: 600;color: #656565;text-align: center;display: inline-block;max-width: 623px;margin: 0 auto;background-color: rgba(53, 127, 223, 0.05);border: 1px solid rgba(53, 127, 223, 0.2);">
																	 <p style="font-size: 21px;float: left;width: 100%;clear: both;color: #444"> <span style="color: #d0021b;">Expired</span> Card Details</p>
																	 <div style="float: left;width: 100%;clear: both;">
																	 <br>
																	 </div>
																	 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
																	 <span style="display: block;width: 81px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Email:</span>
																	 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["email_id"].'</span>
																	 </p>
																	 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
																	 <span style="display: block;width: 81px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Phone:</span>
																	 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$row["mobile_no"].'</span>
																	 </p>
																	 <br>
																	 <br>
																	 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
																	 <span style="display: block;width: 81px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card Name:</span>
																	 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['name'].'</span>
																	 </p>
																	 <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
																	 <span style="display: block;width: 81px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card No:</span>
																	 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_no'].'</span>
																	 </p>
																	 <p style="max-width: 301px;width: 100%;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
																	 <span style="display: block;width: 80px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Exp Month:</span>
																	 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$token_data['card_expiry_month'].'</span>
																	 </p>
																	 <p style="max-width: 301px;width: 100%;display: inline-block;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;vertical-align: top;"> 
																	 <span style="display: block;width: 80px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Exp Year:</span>
																	 <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">20'.$token_data['card_expiry_year'].'</span>
																	 </p>
																	 <br>
																	 </div>
																	 </div>
																	 </div>
																	 <div style="float: left;width: 100%;clear: both;">
																	 <br>
																	 </div>
																	 <div style="width:100%;border-top: 1px solid #3f86e1;padding: 25px 15px;background: #357fdf;margin-top:0px;clear:both;box-sizing: border-box;">
																	 <div style="text-align:center;width:100%;margin:0 auto">
																	 <p style="text-align: center;color:rgb(210, 227, 248);margin-top: 30px;">Powered by: <a href="https://salequick.com/" style="color: rgb(172, 203, 242);cursor:pointer;text-decoration: none;-webkit-transition: all 0.3s ease 0s;-moz-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;"> SaleQuick.com</a></p>
																	 </div>
																	 </div>
																	 </div>
																	 </body></html>';
														//$merchant_email='pk1105806@gmail.com'; 
														$merchant_email=$Merchantdata['email'];
														$MailSubject_merchant = ' Expired Card   Payment of '.$row['name']?$row['name']:$row['email_id']; 
														if(!empty($merchant_email)){ 
																$this->email->from('info@salequick.com',  $Merchantdata['business_dba_name']);
																$this->email->to($merchant_email);
																$this->email->subject($MailSubject_merchant);
																$this->email->message($html_merchant);
																$this->email->send();
														}
														$merchant_notification_email=$Merchantdata['notification_email'];
														if(!empty($merchant_notification_email)){  
															$notic_emails=explode(",",$merchant_notification_email);
															$length=count($notic_emails); 
															$i=0; $arraydata=array(); 
															for( $i=0; $i < $length; $i++)
															{
																$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
																$this->email->to($notic_emails[$i]);
																$this->email->subject($MailSubject_merchant);
																$this->email->message($html_merchant);
																$this->email->send();
																//array_push($arraydata,$notic_emails[$i]);
																}
														}
									 }  
								
						}
						else
						{
							 echo "Today is No  Auto Payment <br/>"; 
						}
					 //print_r($Merchantdata); 
					 //echo $this->db->last_query();  
						
			 }
			 //print_r($getallRecurringRecord);
	 }
	 else
	 {
			 echo "Today is No  Auto Payment <br/>"; 
	 }
				
}
public function retrypayment($ExpressResponseMessage,$Merchantdata,$token_data,$id,$transaction_id,$merchant_id,$card_type,$mobile_no,$email_id,$amount)
{
		// print($ExpressResponseMessage.'---'.$id.'--'.$transaction_id.'----'.$merchant_id.'--'.$card_type.'---'.$mobile_no.'--'.$email_id.'----'.$amount); 
		// echo "<br/>"; print_r($Merchantdata); 
		//  echo "<br/>"; print_r($token_data); die("in the retry function "); 
		//  die(); 
		//$ExpressResponseMessage=$arrayy['Response']['ExpressResponseMessage'];
		 // $ExpressResponseMessage='Declined';   //  Declined   //  Expired Card]
				if($ExpressResponseMessage=='Declined')
				{
										
										$id=$id; 
										$transaction_id=$transaction_id; 
										$merchant_id=$merchant_id; 
										$card_type=$card_type; 
										$mobile_no=$mobile_no;
										$email_id=$email_id; 
										$amount=$amount;
										$merchant_email=$Merchantdata['email'];
										$account_id=$Merchantdata['account_id_cnp']; 
										$account_token=$Merchantdata['account_token_cnp']; 
										$acceptor_id=$Merchantdata['acceptor_id_cnp']; 
										$application_id=$Merchantdata['application_id_cnp']; 
										$terminal_id=$Merchantdata['terminal_id']; 
										$TicketNumber =  (rand(100000,999999)); 
										$paymentcard=$token_data['token']; 
										
										$getallRecurringRecord = $this->db->query("SELECT  * FROM customer_payment_request WHERE  id='$id' ");
										$row=$getallRecurringRecord->row_array();
									 // print_r($row['recurring_next_pay_date']);  die(); 
										//row_array()
										for ($i=1; $i < 4; $i++) { 
												//  ####     Payment  Code Start  #######
												if($i > 1){sleep(5);}
								 $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
										// $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
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
										</CreditCardSale>";   // data from the form, e.g. some ID number
										//print_r($xml_post_string); die();   
										$headers = array(
										"Content-type: text/xml;charset=\"utf-8\"",
										"Accept: text/xml",
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
										//print_r($arrayy);   die(); 
										//echo 'shuaeb'; 
										curl_close($ch);
								if($arrayy['Response']['ExpressResponseMessage']=='Approved')  
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
														$type=$row['payment_type'];
														$recurring_type=$row['recurring_type'];
														$recurring_count=$row['recurring_count'];
														$paid=$row['recurring_count_paid']+1;
														//$remain=$row['recurring_count_remain']-1;   ///  before constant feature
														$remain=($recurring_count >0)?$row['recurring_count_remain']-1:1; 
														$recurring_pay_start_date=$row['recurring_next_pay_date'];
														$recurring_next1=$row['recurring_next_pay_date'];
														
														$sub_total=$row['sub_total']+$amount;
														$paytype=$row['recurring_pay_type'];
														$recurring_payment=$row['recurring_payment'];     //   start, stop,  complete
														
												
														if($remain =='0') 
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
										if( $row['recurring_payment']=='start')
										{
												
												$recurring_next=date($recurring_next1); 
												switch($recurring_type)
												{
														case 'daily':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
														break;  
														case 'weekly':
															$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_next)));
														break;
														case 'biweekly':
															 $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_next)));
														break;
														case 'monthly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_next)));
														break;
														case 'quarterly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_next)));
														break;
														case 'yearly':
														$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_next)));
														break;
														default :
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
														break; 
											 } 
												//print_r($recurring_pay_start_date);  die();
																$today2=date('Y-m-d'); 
																if($type=='recurring')
																{
																		$data2=$info2 = Array(
																				'reference' => $row['reference'],
																				'name' => $row['name'],
																				'invoice_no' => $row['invoice_no'],
																				'email_id' => $row['email_id'],
																				'mobile_no' => $row['mobile_no'],
																				'amount' => $row['amount'],
																				'sub_total' => $sub_total,
																				'tax' => $row['tax'],
																				'fee' => $row['fee'],
																				's_fee' => $row['s_fee'],
																				// 'title' => $row['title'],
																				'detail' => $row['detail'],
																				'note' => $row['note'],
																				'url' => $url,    /// 
																				'payment_type' => 'recurring',
																				'recurring_type' => $row['recurring_type'],
																				'recurring_count' => $row['recurring_count'],
																				// 'due_date' => $row['due_date'],
																				'merchant_id' => $row['merchant_id'],
																				'sub_merchant_id' => $row['sub_merchant_id'],
																				'payment_id'=>$unique,
																				'recurring_payment' => $recurring_payment,
																				
																				'recurring_pay_start_date' => $recurring_pay_start_date,
																				'recurring_next_pay_date' => $recurring_next_pay_date,
																				'recurring_pay_type' => $paytype,
																				'add_date' => $today2,  ///fffff
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
																				'card_type' =>  $row['card_type'],
																				'card_no' =>  $row['card_no'],
																				'address' =>  $row['address'],
																				'name_card' =>  $row['name_card'],
																				'address_status' =>  $row['address_status'],
																				'zip_status' =>  $row['zip_status'],
																				'cvv_status' =>$row['cvv_status'] ,
																				'ip_a' => $_SERVER['REMOTE_ADDR'],
																				'order_type' => 'a'
																		);
																}
														 //print_r($info2);   die(); 
													 $id1 = $this->admin_model->insert_data("customer_payment_request", $info2);
														//$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
														$orderitem=$this->db->query("SELECT * FROM order_item WHERE p_id ='$id' ")->row_array(); 
														$data2['resend'] = "";
														
														$item_Detail_1 = array(
																"p_id" => $id1,
																"item_name" => $orderitem['item_name'], 
																"quantity" => $orderitem['quantity'],
																"price" => $orderitem['price'],
																"tax" => $orderitem['tax'],
																"tax_id" => $orderitem['tax_id'],
																"tax_per" => $orderitem['tax_per'],
																"total_amount" => $orderitem['total_amount'],
														);
														$this->admin_model->insert_data("order_item", $item_Detail_1);
										}
										$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id1."' ");
										$getEmail = $getQuery->result_array();
										$data['getEmail'] = $getEmail;
										$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
										$getEmail1 = $getQuery1->result_array();  
										$data['getEmail1'] = $getEmail1; 
										$data['resend'] = "";
										$email = $email_id; 
										$amount = $amount;  
										$sub_total =$sub_total;
										$tax = $row['tax']; 
										$originalDate = $row['date_c'];
										$newDate = date("F d,Y", strtotime($originalDate)); 
										$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
										$data['email'] = $row['email_id'];
										$data['color'] = $Merchantdata['color'];
										$data['amount'] = $amount;  
										$data['sub_total'] = $sub_total;
										$data['invoice_detail_receipt_item']=$item; 
										$data['tax'] = $row['tax']; 
										$data['originalDate'] = $row['date_c'];
										$data['card_a_no'] = $card_a_no;
										$data['trans_a_no'] = $trans_a_no;
										$data['card_a_type'] = $card_a_type;
										$data['message_a'] = $message_a;
										$data['msgData'] = $data;
										$msg = $this->load->view('email/receipt', $data, true);
										$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
										$email = $row['email_id']; 
										$MailSubject = ' Receipt from '.$Merchantdata['business_dba_name']; 
										$name_of_customer = $row['name'] ? $row['name'] : $row['email_id'];
										$MailSubject2 = ' Receipt to ' . $name_of_customer;
										if(!empty($email)){ 
											$this->email->from('info@salequick.com',  $Merchantdata['business_dba_name']);
											$this->email->to($email);
											$this->email->subject($MailSubject);
											$this->email->message($msg);
											$this->email->send();
										}
										//$merchant_email='vaibhav.angad@gmail.com';
										if (!empty($Merchantdata['email'])) {
											$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
											$this->email->to($Merchantdata['email']);
											$this->email->subject($MailSubject2);
											$this->email->message($merchnat_msg);
											$this->email->send();
										}
										$merchant_notification_email=$Merchantdata['notification_email'];
										if(!empty($merchant_notification_email)){  
											$notic_emails=explode(",",$merchant_notification_email);
											$length=count($notic_emails); 
											$i=0; $arraydata=array(); 
											for( $i=0; $i < $length; $i++)
											{
												$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
												$this->email->to($notic_emails[$i]);
												$this->email->subject($MailSubject2);
												$this->email->message($merchnat_msg);
												$this->email->send();
												//array_push($arraydata,$notic_emails[$i]);
												}
										}
						
										$url=$url;   
										$purl = str_replace('rpayment', 'reciept', $url); 
										//uncommented by ss 16-12-2019 -commented by SS 04-12-2019
										if(!empty($row['mobile_no']))
										{ 
										$sms_reciever = $row['mobile_no'];
										//$sms_message = trim('Payment Receipt : '.$purl);
										$sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
										$from = '+18325324983'; //trial account twilio number
										$mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
										$to = '+1'.$mob;
										$response = $this->twilio->sms($from, $to,$sms_message);
										}
										
										$save_notificationdata = array(
										'merchant_id'=>$row['merchant_id'], 
										'name' => $row['name'],
										'mobile' => $row['mobile_no'],
										'email' => $row['email_id'],
										'card_type' =>  $token_data['card_type'],
										'card_expiry_month'=> $token_data['card_expiry_month'],
										'card_expiry_year'=> $token_data['card_expiry_year'],
										'card_no' => $token_data['card_no'],
										'amount'  =>$amount,
										'address' =>$row['address'],
										'transaction_id'=>$trans_a_no,
										'transaction_date'=>$transaction_date,
										'notification_type' => 'payment',
										'invoice_no'=>$row['invoice_no'],
										'status'   =>'unread'
										);
										//print_r($save_notificationdata); die(); 
										$this->db->insert('notification',$save_notificationdata);
										echo " Payment Sussessfully Now! <br/>"; 
											 break;
										} ///  End of Payment Check  Responce  
										else 
										{
												$errormessage=$arrayy['Response']['ExpressResponseMessage'];
												$errormessage='Declined'; 
												$in_data=array(
															 'merchant_id'=>$merchant_id,
															 'invoice_no'=>$row['invoice_no'],
															 'payment_id'=>$row['payment_id'],
															 'amount'=>$amount,
															 'payment_date'=>$row['recurring_next_pay_date'],
															 'error_message'=>$errormessage
												); 
												$this->db->insert('failed_payment',$in_data);
												if($i=='3')
												{
															//   a insertion for declined  invoice 
															$transaction_date=""; 
															$staus = 'declined';
															$day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
															if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }
															$type=$row['payment_type'];
															$recurring_type=$row['recurring_type'];
															$recurring_count=$row['recurring_count'];
															$paid=$row['recurring_count_paid'];
															//$remain=$row['recurring_count_remain']-1;   ///  before constant feature
															$remain=($recurring_count >0)?$row['recurring_count_remain']:1; 
															$recurring_pay_start_date=$row['recurring_next_pay_date'];
															$recurring_next1=$row['recurring_next_pay_date'];
															
															$sub_total=$row['sub_total']+$amount;
															$paytype=$row['recurring_pay_type'];
															$recurring_payment=$row['recurring_payment'];     //   start, stop,  complete
															
															
															if($remain =='0') 
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
											if( $row['recurring_payment']=='start')
											 {
													
													$recurring_next=date($recurring_next1); 
													switch($recurring_type)
													{
															case 'daily':
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
															break;  
															case 'weekly':
																$recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_next)));
															break;
															case 'biweekly':
																 $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_next)));
															break;
															case 'monthly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_next)));
															break;
															case 'quarterly':
																$recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_next)));
															break;
															case 'yearly':
															$recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_next)));
															break;
															default :
																	$recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
															break; 
												 } 
													//print_r($recurring_pay_start_date);  die();
																	$today2=date('Y-m-d'); 
																	if($type=='recurring')
																	{
																		 $transaction_id="";
																			$data2=$info2 = Array(
																					'reference' => $row['reference'],
																					'name' => $row['name'],
																					'invoice_no' => $row['invoice_no'],
																					'email_id' => $row['email_id'],
																					'mobile_no' => $row['mobile_no'],
																					'amount' => $row['amount'],
																					'sub_total' => $sub_total,
																					'tax' => $row['tax'],
																					'fee' => $row['fee'],
																					's_fee' => $row['s_fee'],
																					// 'title' => $row['title'],
																					'detail' => $row['detail'],
																					'note' => $row['note'],
																					'url' => $url,    /// 
																					'payment_type' => 'recurring',
																					'recurring_type' => $row['recurring_type'],
																					'recurring_count' => $row['recurring_count'],
																					// 'due_date' => $row['due_date'],
																					'merchant_id' => $row['merchant_id'],
																					'sub_merchant_id' => $row['sub_merchant_id'],
																					'payment_id'=>$unique,
																					'recurring_payment' => $recurring_payment,
																					
																					'recurring_pay_start_date' => $recurring_pay_start_date,
																					'recurring_next_pay_date' => $recurring_next_pay_date,
																					'recurring_pay_type' => $paytype,
																					'add_date' => date('Y-m-d H:i:s'),  ///fffff
																					'status' => $staus,
																					'year' => $year,
																					'month' => $month,
																					'time1' => $time1,
																					'day1' => $day1,
																					'date_c' => $today2_a,
																					'payment_date' => $today2,
																					'recurring_count_paid' => $paid,   //fdgdfg
																					'recurring_count_remain' => $remain, //sfsfs
																					'transaction_id' => $transaction_id,
																					'message' =>  "",
																					'card_type' =>  $row['card_type'],
																					'card_no' =>  "",
																					'address' =>  $row['address'],
																					'name_card' =>  $row['name_card'],
																					'address_status' =>  $row['address_status'],
																					'zip_status' =>  $row['zip_status'],
																					'cvv_status' =>$row['cvv_status'] ,
																					'ip_a' => $_SERVER['REMOTE_ADDR'],
																					'order_type' => 'a'
																			);
																	}
															 //print_r($info2);   die(); 
														 $id1 = $this->admin_model->insert_data("customer_payment_request", $info2);
															//$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
															$orderitem=$this->db->query("SELECT * FROM order_item WHERE p_id ='$id' ")->row_array(); 
															$data2['resend'] = "";
															
															$item_Detail_1 = array(
																	"p_id" => $id1,
																	"item_name" => $orderitem['item_name'], 
																	"quantity" => $orderitem['quantity'],
																	"price" => $orderitem['price'],
																	"tax" => $orderitem['tax'],
																	"tax_id" => $orderitem['tax_id'],
																	"tax_per" => $orderitem['tax_per'],
																	"total_amount" => $orderitem['total_amount'],
					
															);
															//print_r($item_Detail_1);  die();   
															$this->admin_model->insert_data("order_item", $item_Detail_1);
											}
											$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id1."' ");
											$getEmail = $getQuery->result_array();
											$data['getEmail'] = $getEmail;
											$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
											$getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
											$data['getEmail1'] = $getEmail1; 
											$data['resend'] = "";
											$email = $email_id; 
											$amount = $amount;  
											$sub_total =$sub_total;
											$tax = $row['tax']; 
											$originalDate = $row['date_c'];
											$newDate = date("F d,Y", strtotime($originalDate)); 
											$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
											//Email Process
											$data['email'] = $row['email_id'];
											$data['color'] = $Merchantdata['color'];
											$data['amount'] = $amount;  
											$data['sub_total'] = $sub_total;
											$data['tax'] = $row['tax']; 
											$data['originalDate'] = $row['date_c'];
											$data['card_a_no'] = "";
											$data['trans_a_no'] = "";
											$data['card_a_type'] = "";
											$data['message_a'] = "";
											//$msg = $this->load->view('email/receipt', $data, true);
											$msg='<!DOCTYPE html>
											<html>
											<head>
													<title>Failed Transaction!!</title>
											</head>
											<body>
												 <div><center style="color:red;">Transaction failed..</center><div>
											</body>
											</html>'; 
											$email = $row['email_id'];  
											//echo  $email;   die("ok"); 
												 $MailSubject = ' Transaction Failed  '.$Merchantdata['business_dba_name']; 
												 $MailSubject2=' Transaction Failed of '.$row['invoice_no']; 
														 if(!empty($email)){ 
													 $this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
													 $this->email->to($email);
													 $this->email->subject($MailSubject);
													 $this->email->message($msg);
													 $this->email->send();
														 }
															//$merchant_email='vaibhav.angad@gmail.com';
										if (!empty($Merchantdata['email'])) {
											$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
											$this->email->to($Merchantdata['email']);
											$this->email->subject($MailSubject2);
											$this->email->message($msg);
											$this->email->send();
										}
										$merchant_notification_email=$Merchantdata['notification_email'];
										if(!empty($merchant_notification_email)){  
											$notic_emails=explode(",",$merchant_notification_email);
											$length=count($notic_emails); 
											$i=0; $arraydata=array(); 
											for( $i=0; $i < $length; $i++)
											{
												$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
												$this->email->to($notic_emails[$i]);
												$this->email->subject($MailSubject2);
												$this->email->message($msg);
												$this->email->send();
												//array_push($arraydata,$notic_emails[$i]);
												}
										}
											$url=$url;   
											$purl = str_replace('rpayment', 'reciept', $url); 
											if(!empty($row['mobile_no']))
											{ 
											$sms_reciever = $row['mobile_no'];
												 // $sms_message = trim('Payment Receipt : '.$purl);
											$sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
											$from = '+18325324983'; //trial account twilio number
											$mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
											$to = '+1'.$mob;
											$response = $this->twilio->sms($from, $to,$sms_message);
											}
													$save_notificationdata = array(
													'merchant_id'=>$row['merchant_id'], 
													'name' => $row['name'],
													'mobile' => $row['mobile_no'],
													'email' => $row['email_id'],
													'card_type' =>  "",
													'card_expiry_month'=> "",
													'card_expiry_year'=> "",
													'card_no' => "",
													'amount'  =>$amount,
													'address' =>$row['address'],
													'transaction_id'=>'',
													'transaction_date'=>$transaction_date,
													'notification_type' => 'failed',
													'invoice_no'=>$row['invoice_no'],
													'status'   =>'unread'
													);
													//print_r($save_notificationdata); die(); 
													$this->db->insert('notification',$save_notificationdata);
												}
												
										}
										
												// ####  Payment Code End  Here ####
												
												
				 }  ///   End Of Loop 
										
										echo "<br/> Its Out Of Loop."; 
										
										 
				}
				else if($ExpressResponseMessage=='Expired Card')
				{
					 echo " his nis the Expire Card Condition ";  
				}
		
}
}//  End Of the Controllers 