<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Payroc_auto_invoices_new extends CI_Controller {  
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model');
			$this->load->model('admin_model');
			$this->load->model('home_model');
			$this->load->library('email');
			$this->load->library('twilio');

			//ini_set('display_errors', 1);
            //error_reporting(E_ALL);
			
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

		public function Stop_recurring($invoice_no,$merchant_id) {
			$getallRecurringRecord = $this->db->query("UPDATE  customer_payment_request SET recurring_payment='stop' WHERE invoice_no='$invoice_no' AND  merchant_id='$merchant_id'   ");
			return true; 
		}
		
	
		
		public function autocallfunction() {   
			//  $this->testmailfuncion(); 
			 
	     $data3=array();
		 	$result=$this->admin_model->getallDistinct_Invoice_for_autopayment_new('customer_payment_request'); 
		 	$getallRecurringRecord=$this->setDataInArray($result);

		 	//print_r($result); die();
 
			if(count($getallRecurringRecord)) {
				foreach ($getallRecurringRecord as $key => $row) {
		
					$a=$row['recurring_payment'];
					$c=$row['recurring_count_remain'];
					$e=$row['recurring_next_pay_date'];
					$b=$row['recurring_pay_type'];
					$g=$row['recurring_pay_start_date'];
				    $d=date('Y-m-d');  
					//if( $b=='1'  &&  $c >0 && $d==$e && $a!='complete' && $a =='start' && $row['no_of_invoice']!=$row['recurring_count'] ) { 

					if( $d==$g && $a =='start'  &&  $row['status']!='confirm' && $row['status']!='Chargeback_Confirm'  ) {           
						 //echo $e;  
						//die("okl"); 
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
						$processor_id=$Merchantdata['processor_id'];

						$TicketNumber =  (rand(100000,999999)); 
						$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);  

						$getQuery_tt = $this->db->query(" SELECT invoice_no,token_id FROM invoice_token WHERE invoice_no='$invoice_no'   AND merchant_id='$merchant_id' and status='1'  ");
						$token_data_in = $getQuery_tt->row_array();
						
						$getQuery_t = $this->db->query(" SELECT token,card_type,card_no FROM token  WHERE  id='".$token_data_in['token_id']."' "); 
						//$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
						// echo $this->db->last_query(); 
						$token_data = $getQuery_t->row_array();
					    $paymentcard=$token_data['token']; 
						$security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';

						$authorizationcode="";
                        $ipaddress=$_SERVER['REMOTE_ADDR'];
                        $orderid=$row['invoice_no'];
                          
                           if (!empty($security_key) and !empty($id) and !empty($processor_id)){
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
                        $query .= "customer_vault_id=". urlencode($paymentcard) . "&";
                    
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
                        $arrayy['Response']['ExpressResponseMessage'] = 'Declined';
                    }
                    else if($response['response']==3)
                    {
                        //$message_complete = $response['responsetext'];
                        $message_complete = 'Declined';
                        $arrayy['Response']['ExpressResponseMessage'] = 'Declined';
                    }
                    else 
                    {
                        //$message_complete = 'Error';
                        $message_complete = 'Declined';
                        $arrayy['Response']['ExpressResponseMessage'] = 'Declined';
                    }




						//

					 	if($arrayy['Response']['ExpressResponseMessage']=='Approved' ) {

							$card_a_no = $response['cc_number'];
                            $trans_a_no = $response['transactionid'];
                            $auth_code = $response['authcode'];
                            // $card_a_type =$card_type;
                            if($response['cc_type']=='mc')
                            {
                              $card_a_type ='MasterCard';
                            }
                            
                            else
                             {
                               $card_a_type =ucfirst($response['cc_type']);
                             }    
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
							// $today1 = date("Ymdhisu");
							 $today1_1 = date("ymdhisu");
                             $today1 = str_replace("000000", "", $today1_1);
							 $url = $row['url'];
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
									
									 'sign' =>  $row['sign'],
									 'status' => $staus, 
									 'payment_date' => $today2,
									 'recurring_count_paid' => $paid,   //fdgdfg
									 'recurring_count_remain' => $remain, //sfsfs
									 'transaction_id' => $trans_a_no,
									 'auth_code' => $auth_code,
									 'message' =>  $message_a,
									 'card_type' =>  $token_data['card_type'],
									 'card_no' =>  $token_data['card_no'],
									 'address' =>  $row['address'],
									 'name_card' =>  $row['name_card'],
									 'address_status' =>  $row['address_status'],
									 'zip_status' =>  $row['zip_status'],
									 'cvv_status' =>$row['cvv_status'] ,
									 'ip_a' => $_SERVER['REMOTE_ADDR'],
									 'processor_name' => 'PAYROC'
							 	);

							 	$info22 = Array(
									
									 'id' =>  $row['id'],
								
							 	);
						 	}
							//  $row['no_of_invoice']!=$row['recurring_count']
							//if( ($row['no_of_invoice']+1) == $row['recurring_count'])
							if( ($row['no_of_invoice']) == $row['recurring_count'])	
							{
								$up=$this->Stop_recurring($row['invoice_no'],$row['merchant_id']);
							}
					$id1 = $this->admin_model->update_data("customer_payment_request", $info2,$info22);
							
							 //$m=$this->home_model->update_payment_single($id, $info);
							 $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
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
							 $MailSubject = 'Receipt from '.$Merchantdata['business_dba_name']; 
							 $name_of_customer = $row['name'] ? $row['name'] : $row['email_id'];
							 $MailSubject2 = 'Receipt to ' . $name_of_customer;
							 if(!empty($email)){ 
								$this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
								$this->email->to($email);
								$this->email->subject($MailSubject);
								$this->email->message($msg);
								$this->email->send();
							}
						 	$url=$url;   
					 		$purl = str_replace('rpayment', 'reciept', $url); 
							 if(!empty($row['mobile_no']))
							 { 
							 $sms_reciever = $row['mobile_no'];
							 $sms_message = trim('Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
							 $from = '+18325324983'; //trial account twilio number
							 $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
							 $to = '+1'.$mob;
							 $response = $this->twilio->sms($from, $to,$sms_message);
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

                                            if($message_complete=='Declined')
											 {
											 $staus = 'declined';
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
					 
							
							 $today1_1 = date("ymdhisu");
                             $today1 = str_replace("000000", "", $today1_1);
							 $url = $row['url'];
							 $unique = "PY" . $today1;
							 $today2=date('Y-m-d'); 											
													 
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
									
									 'sign' =>  $row['sign'],
									 'status' => $staus, 
									 'payment_date' => $today2,
									 'transaction_id' => $trans_a_no,
									 'auth_code' => $auth_code,
									 'message' =>  $message_a,
									 'card_type' =>  $token_data['card_type'],
									 'card_no' =>  $token_data['card_no'],
									 'address' =>  $row['address'],
									 'name_card' =>  $row['name_card'],
									 'address_status' =>  $row['address_status'],
									 'zip_status' =>  $row['zip_status'],
									 'cvv_status' =>$row['cvv_status'] ,
									 'ip_a' => $_SERVER['REMOTE_ADDR'],
									 'processor_name' => 'PAYROC'
							 	);

							 	$info22 = Array(
									
									 'id' =>  $row['id'],
								
							 	);
						 	}
							//  $row['no_of_invoice']!=$row['recurring_count']
							//if( ($row['no_of_invoice']+1) == $row['recurring_count'])
							if( ($row['no_of_invoice']) == $row['recurring_count'])	
							{
								$up=$this->Stop_recurring($row['invoice_no'],$row['merchant_id']);
							}
					$id1 = $this->admin_model->update_data("customer_payment_request", $info2,$info22);
							
							 //$m=$this->home_model->update_payment_single($id, $info);
							 $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
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
							// $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id1));
							 //Email Process
						 	$data['email'] = $row['email_id'];
						 	$data['color'] = $Merchantdata['color'];
						 	$data['amount'] = $amount;  
						 	//$data['invoice_detail_receipt_item']=$item; 
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
							 

							$mail_body = $this->load->view('email/rec_payment_failure', $data, true);
											 $msg=$mail_body; 
											 //$merchant_email='vaibhav.angad@gmail.com'; 
											 $merchant_email=$Merchantdata['email'];
											 $customername=$row['name'] ? $row['name']:$row['email_id']; 
											 $MailSubject = 'Declined Payment from '.$Merchantdata['business_dba_name'];
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
											// $m=$this->retrypayment('Declined',$Merchantdata,$token_data,$id,$transaction_id,$merchant_id,$card_type,$mobile_no,$email_id,$amount);    
											 
									 }
									 else if($arrayy['Response']['ExpressResponseMessage']=='Expired Card')
									 {
													//echo $email=$row['email_id']; echo $merchant_email=$Merchantdata['email'];
													 //echo $id;  
													 //die("expire"); 
													 
													 
													 $html_customer='';
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
													 
															 $html_merchant='';
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



}//  End Of the Controllers 