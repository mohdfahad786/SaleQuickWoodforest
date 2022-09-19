<?php 
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}
	class Add_card extends CI_Controller {
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
			//ini_set('display_errors', 1);
		    //error_reporting(E_ALL);
		}

	public function index() {  
		{
	             $id = $this->uri->segment(2);
                 $merchant_id = $this->uri->segment(3);
                 $invoice_no = $this->uri->segment(4);
						
				$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $merchant_id . "' and id  ='" . $id . "' ");
				$getEmail = $getQuery->result_array();
                $data['getEmail'] = $getEmail;
				$getEmailCount = $getQuery->num_rows();
				$data['getEmailCount'] = $getEmailCount;

				$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
				$getEmail1 = $getQuery1->result_array();

					$data['getEmail1'] = $getEmail1;
					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $merchant_id));
					$data['itemm'] = $itemm;

						$this->load->view('add_card', $data);

		}

	}

	        public function payment_cnp_invoicing() {
           // echo '<pre>';print_r($_POST);die();
            $data=array();
             $data3=array();
            $paymentcard = $this->input->post('card_selection_radio') ? $this->input->post('card_selection_radio') : "";
            $issavecard = $this->input->post('issavecard') ? $this->input->post('issavecard') : "0";
            if ($paymentcard == 'newcard') {
                $signImg = $this->input->post('sign') ? $this->input->post('sign') : "";
            } else {
                $signImg = $this->input->post('signImg') ? $this->input->post('signImg') : "";
                //$verify_phone_on_cp = $this->input->post('verify_phone_on_cp') ? $this->input->post('verify_phone_on_cp') : "";

            }
            // echo 'Sign Image :  <br/>'.$signImg ; die('this');
            $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
            
            
            //echo $id;die();
            $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
            $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
            $transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
            $message = $this->input->post('message') ? $this->input->post('message') : "";
            $card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
            $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
            //echo $card_no;die();
            $address = $this->input->post('address') ? $this->input->post('address') : "";
            $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
            $today2 = date("Y-m-d H:i:s");
            $new_add_date= gmdate("Y-m-d H:i:s");
            $purl = base_url() . "reciept/$bct_id1/$bct_id2";
            //print_r($bct_id2.'--'.$bct_id1); die();
            $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
            $getEmail = $getQuery->result_array();
            $data['getEmail'] = $getEmail;
            $getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "' ");
            $getEmail1 = $getQuery1->result_array(); //print_r($getEmail1);  die();
            $data['getEmail1'] = $getEmail1;
            $late_grace_period = $getEmail1[0]['late_grace_period'];
            $qb_online_invoice_id = $getEmail[0]['qb_online_invoice_id']; 

           
            
            if($getEmail[0]['payment_type'] == 'recurring') {
                $payment_date = date('Y-m-d', strtotime($getEmail[0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
            } else {
                $payment_date = date('Y-m-d', strtotime($getEmail[0]['due_date']. ' + '.$late_grace_period.' days'));
            }
            $late_fee = $getEmail1[0]['late_fee_status'] > 0 && date('Y-m-d') > $payment_date ? $getEmail1[0]['late_fee'] : 0 ;
            
            $merchant_id = $bct_id2;
            if (count($getEmail)) {
                $type = $getEmail[0]['payment_type'];
                $paid = $getEmail[0]['recurring_count_paid'] + 1;
                $remain = $getEmail[0]['recurring_count_remain'] - 1;
                $amount = $getEmail[0]['amount'];
                
                
                $total_amount_with_late_fee_new = number_format(($getEmail[0]['amount'] + $late_fee),2);
                
                    $b = str_replace(",","",$total_amount_with_late_fee_new);
                                $a = number_format($b,2);
                                $total_amount_with_late_fee = str_replace(",","",$a);
            
                                //print_r($total_amount_with_late_fee);

                    
                $name = $getEmail[0]['name'];
                $phone = $getEmail[0]['mobile_no'];
                $invoice_no = $getEmail[0]['invoice_no'];
                
            }
           
            $soapUrl = "https://payroc.transactiongateway.com/api/transact.php"; // asmx URL of live
            $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
            $getEmail_a = $getQuery_a->result_array();
            $data['$getEmail_a'] = $getEmail_a;
            if (count($getEmail_a)) {
                $merchant_email = $getEmail_a[0]['email'];
            }
           
            $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
            $processor_id=trim($getEmail1[0]['processor_id']);
        if (!empty($security_key) and !empty($getEmail[0]['id']) and !empty($processor_id)){

          

                $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
                $card_no = preg_replace('/\s+/', '', $card_no);
                $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
                $name_card = $this->input->post('name_card') ? $this->input->post('name_card') : "";
                $card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
                $zip = $this->input->post('zip') ? $this->input->post('zip') : "";

                $mmyy = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
                //print_r($mmyy);
                $pos = strpos($mmyy, '/');
                $expiry_month = substr($mmyy, 0, $pos);
                $expiry_year = substr($mmyy, $pos + 1, 2);
                $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
                $payment_token = $this->input->post('payment_token') ? $this->input->post('payment_token') : "";

                
                $array['Response']['ExpressResponseMessage'] = 'ONLINE';
                $TicketNumber = (rand(100000, 999999));
                if ($array['Response']['ExpressResponseMessage'] = 'ONLINE') {
                    if ($paymentcard == 'newcard') {

                       

                        $ccnumber=$card_no;
                        $amount=$amount;
                        $ccexp=$expiry_month.$expiry_year;
                        $cvv=$cvv;
                        $authorizationcode="";
                        $ipaddress=$_SERVER['REMOTE_ADDR'];
                        $orderid=$payment_id;
                        $paytype = $getEmail[0]['recurring_pay_type'];

                       $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
                        $query .= "ccexp=" . urlencode($ccexp) . "&";
                        $query .= "amount=" . urlencode(number_format($total_amount_with_late_fee,2,".","")) . "&";
                        $query .= "cvv=" . urlencode($cvv) . "&";
                        $query .= "zip=" . urlencode($zip) . "&";
                        $query .= "processor_id=" . urlencode($processor_id) . "&";
                        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
                        $query .= "ipaddress=" . urlencode($ipaddress) . "&";
                        $query .= "orderid=" . urlencode($orderid) . "&";
                        //if($paytype==1){ 
                        if (( $issavecard == '1') || $paytype == '1') {    
                            $query .= "customer_vault=add_customer". "&";}
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
                        

                 if ( $issavecard == '1' || $paytype == '1') { 
                        $customer_vault_id=$response['customer_vault_id'];
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
                        $arrayy['Response']['ExpressResponseMessage'] = 'Declined';
                    }
                    else if($response['response']==3)
                    {
                        $message_complete = $response['responsetext'];
                    }
                    else 
                    {
                        $message_complete = 'Error';
                    }



                        if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved' ){

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

                      
                            //print_r($cvv_status);  die();
                            if ($message_complete == 'Declined') {
                                $staus = 'declined';
                            }
                            //elseif($message_a=='Approved' or $message_a=='Duplicate')
                            elseif ($message_complete == 'Approved') {
                                $staus = 'confirm';
                            } else {
                                $staus = 'pending';
                            }
                            //print_r($staus);  die();
                            $day1 = date("N");
                            $today2_a = date("Y-m-d");
                            $year = date("Y");
                            $month = date("m");
                            $time11 = date("H");
                            if ($time11 == '00') {
                                $time1 = '01';
                            } else {
                                $time1 = date("H");
                            }
                            $type = $getEmail[0]['payment_type'];
                            $recurring_type = $getEmail[0]['recurring_type'];
                            $recurring_count = $getEmail[0]['recurring_count'];

                            $paid = $getEmail[0]['recurring_count_paid'] + 1;
                            $remain = ($recurring_count > 0) ? $getEmail[0]['recurring_count_remain'] - 1 : 1;
                            $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                            $recurring_next1 = $getEmail[0]['recurring_next_pay_date'];
                            $sub_total = $getEmail[0]['sub_total'] + $amount;
                            
                            $recurring_payment = $getEmail[0]['recurring_payment']; //   start, stop,  complete
                            $lastRecord = $this->Admin_model->getlast_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            $AllPaidRequest = $this->Admin_model->getAllpaid_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            //print_r($lastRecord->recurring_count); echo "<br/>";
                            // print_r($AllPaidRequest);
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $recurring_payment = 'complete';
                            } else {
                                $recurring_payment = $getEmail[0]['recurring_payment'];
                            }
                            //echo 'recurring_payment '.$recurring_payment.' paid'.$paid.' remain'.$remain.' paytype'.$paytype.' recurring_payment'.$recurring_payment;
                            // die();
                            if ($type == 'straight') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a,
                                    'payment_date' => $today2,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'sign' => $signImg,
                                    'address' => $address,
                                    'name_card' => $name_card,
                                    'auth_code' => $auth_code,
                                    'l_name' => "",
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'processor_name' => 'PAYROC',
                                    'new_add_date' => $new_add_date,
                                    
                                );
                            } elseif ($type == 'recurring') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a, // $today2_a
                                    'payment_date' => $today2,
                                    'recurring_count_paid' => $paid,
                                    //'recurring_count_remain' => $remain,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    //'sub_total' => $amount,
                                    'recurring_payment' => $recurring_payment,
                                    'address' => $address,
                                    'sign' => $signImg,
                                    'name_card' => $name_card,
                                    'auth_code' => $auth_code,
                                    'l_name' => "",
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'processor_name' => 'PAYROC',
                                    'new_add_date' => $new_add_date,

                                );
                            }
                            //print_r($info);

                            //die("end");

                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $up = $this->Stop_recurring($getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            }
                             //print_r($info);
                            $m = $this->Home_model->update_payment_single($id, $info);
                                $data_pax = array(
                            'merchant_id' =>$merchant_id,
                            'pos_id' =>$id,
                            'pax_json'=>$test,
                            'type'=>'invoice' 
                            );
                        $pax_id = $this->Admin_model->insert_data("pax_json", $data_pax);
                            // echo $m; die();
                            //echo  $this->db->last_query();  die("my query");
                            $this->session->set_flashdata('pmsg', '<div class="text-success text-center">  Payment  Complete </div>');
                            $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
                            $getEmail = $getQuery->result_array();
                            $data['getEmail'] = $getEmail;
                            $data['resend'] = "";
                            $email = $getEmail[0]['email_id'];
                            $amount = $getEmail[0]['amount'];
                            $sub_total = $getEmail[0]['sub_total'];
                            $tax = $getEmail[0]['tax'];
                            $originalDate = $getEmail[0]['date_c'];
                            $newDate = date("F d,Y", strtotime($originalDate));
                            $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
                            //Email Process
                            $data['email'] = $getEmail[0]['email_id'];
                            $data['color'] = $getEmail1[0]['color'];
                            $data['amount'] = $getEmail[0]['amount'];
                            $data['sub_total'] = $getEmail[0]['sub_total'];
                            $data['tax'] = $getEmail[0]['tax'];
                            $data['originalDate'] = $getEmail[0]['date_c'];
                            $data['card_a_no'] = $card_a_no;
                            $data['invoice_detail_receipt_item'] = $item;
                            $data['trans_a_no'] = $trans_a_no;
                            $data['card_a_type'] = $card_a_type;
                            $data['message_a'] = $message_a;
                            $data['late_grace_period'] = $getEmail_a[0]['late_grace_period'];
                            $data['late_fee_status'] = $getEmail_a[0]['late_fee_status'];
                            $data['late_fee'] = $getEmail[0]['late_fee'];
                            $data['recurring_type'] = $getEmail[0]['recurring_type'];
                            $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
                            $data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
                            $data['msgData'] = $data;



                      if ($issavecard == '1' || $paytype == '1') {

                        $customer_vault_id=$response['customer_vault_id'];

                        $mob = str_replace(array('(', ')', '-', ' '), '', $phone);
                                $merchant_id=$getEmail[0]['merchant_id'];
                                $my_toke = array(
                                    'name' => $name_card,
                                    'mobile' => $mob,
                                    'email' => $email,
                                    'card_type' => $card_a_type,
                                    'card_expiry_month' => $expiry_month,
                                    'card_expiry_year' => $expiry_year,
                                    'card_no' => $card_a_no,
                                    // 'transaction_id'=>$trans_a_no,
                                    'merchant_id'=>$merchant_id,
                                    'status'=>1,
                                    'payroc'=>'1',
                                    'token' =>  $customer_vault_id,
                                    'zipcode' => $this->input->post('zip') ? $this->input->post('zip') : ""
                                );

                                 // $this->db->insert('token', $my_toke);
                                 //    $m = $this->db->insert_id();
                                 //    $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $m,'merchant_id'=>$merchant_id);
                                 //     $this->db->insert('invoice_token', $invoice_tokenData);
                    }

                           
                              //print_r($getEmail); die();
                            //Send Mail Code
                            //$msg = $this->load->view('email/new_receipt', $data, true);
                            //$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
                            $msg = $this->load->view('email/new_receipt_dash', $data, true);
                            $merchnat_msg = $this->load->view('email/merchant_receipt_dash', $data, true);
                            
                            //Satrt QuickBook sync
                            
                            $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                           
                            $url ="https://salequick.com/quickbook/get_invoice_detail_live_payment2";
                            $qbdata =array(
                            'id' => $qb_online_invoice_id,
                            'merchant_id' => $bct_id2
                            
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
                            

                            $email = $email;
                            $name_of_customer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
                            $MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
                            $MailSubject2 = ' Receipt to ' . $name_of_customer;
                            if (!empty($email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($email);
                                $this->email->subject($MailSubject);
                                $this->email->message($msg);
                                $this->email->send();
                            }
                            $merchant_email = $getEmail1[0]['email'];
                            
                            if (!empty($merchant_email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($merchant_email);
                                $this->email->subject($MailSubject2);
                                $this->email->message($merchnat_msg);
                                if($bct_id2 !='413'){
                               // $this->email->send();
                                }
                            }
                            $merchant_notification_email=$getEmail1[0]['notification_email'];
                            if(!empty($merchant_notification_email)){  
                                $notic_emails=explode(",",$merchant_notification_email);
                                $length=count($notic_emails); 
                                $i=0; $arraydata=array(); 
                                for( $i=0; $i < $length; $i++) {
                                    $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                    $this->email->to($notic_emails[$i]);
                                    $this->email->subject($MailSubject2);
                                    $this->email->message($merchnat_msg);
                                    if($bct_id2 !='413'){
                               // $this->email->send();
                                }
                                    //array_push($arraydata,$notic_emails[$i]);
                                }
                            }
                            //    die('its Ok');
                            if ($type != 'recurring') {
                                if (!empty($getEmail[0]['mobile_no'])) {
                                    //$sms_sender = trim($this->input->post('sms_sender'));
                                    $sms_reciever = $getEmail[0]['mobile_no'];
                                    $sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);
                                    $from = '+18325324983'; //trial account twilio number
                                    // $to = '+'.$sms_reciever; //sms recipient number
                                    $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                                    $to = '+1' . $mob;
                                    $response_twilio = $this->twilio->sms($from, $to, $sms_message);
                                }
                            }
                            if ( $issavecard == '1' || $paytype == '1') {

                               
                                $mob = str_replace(array('(', ')', '-', ' '), '', $phone);
                                $merchant_id=$getEmail[0]['merchant_id'];
                                $my_toke = array(
                                    'name' => $name_card,
                                    'mobile' => $mob,
                                    'email' => $email,
                                    'card_type' => $card_a_type,
                                    'card_expiry_month' => $expiry_month,
                                    'card_expiry_year' => $expiry_year,
                                    'card_no' => $card_a_no,
                                    // 'transaction_id'=>$trans_a_no,
                                    'merchant_id'=>$merchant_id,
                                    'status'=>1,
                                    'payroc'=>'1',
                                    'token' => $response['customer_vault_id'],
                                    'zipcode' => $this->input->post('zip') ? $this->input->post('zip') : ""
                                );

                                if($email!="" && $mob!="" &&  $merchant_id!="")
                                {
                                    $gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND  ( mobile='$mob' or  email='$email' )  AND merchant_id='$merchant_id' ")->result_array();

                                }
                                else if($email="" && $mob!="" &&  $merchant_id!="")
                                {
                                    $gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND mobile='$mob'  AND merchant_id='$merchant_id' ")->result_array();

                                }
                                else if($email!="" && $mob="" &&  $merchant_id!="")
                                {

                                    $gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND email='$email'  AND merchant_id='$merchant_id' ")->result_array();
                                }

                                if (count($gettoken) <= 0) {
                                    $this->db->insert('token', $my_toke);
                                    $m = $this->db->insert_id();
                                    $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $m,'merchant_id'=>$merchant_id);
                                } else {
                                    $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $gettoken[0]['id'],'merchant_id'=>$merchant_id);
                                }
                                $this->db->insert('invoice_token', $invoice_tokenData);
                            }
                            //print_r($m); die();
                           
                            $transaction_date = date("Y-m-d h:i:s");
                            $save_notificationdata = array(
                                'merchant_id' => $merchant_id,
                                'name' => $name,
                                'mobile' => $phone,
                                'email' => $email,
                                'card_type' => $card_a_type,
                                'card_expiry_month' => $expiry_month,
                                'card_expiry_year' => $expiry_year,
                                'card_no' => $card_a_no,
                                'amount' => $total_amount_with_late_fee,
                                'transaction_id' => $trans_a_no,
                                'transaction_date' => $transaction_date,
                                'notification_type' => 'payment',
                                'invoice_no' => $invoice_no,
                                'status' => 'unread',
                                //'zipcode' => $zip
                            );
                            //print_r($save_notificationdata); 
                            //die();
                            $this->db->insert('notification', $save_notificationdata);
                            //echo  $this->db->last_query();  die("my query");
                            if ($getEmail[0]['payment_type'] == 'recurring') {
                                redirect(base_url() . 'rpayment/' . $bct_id1 . '/' . $bct_id2);
                            } else {
                                redirect(base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2);
                            }
                            // End Token
                            //print_r($response); die();
                        } else {
                            if($arrayy['Response']['ExpressResponseMessage'] == 'Declined') {   
                                if($getEmail[0]["recurring_pay_type"] == '1'){
                                    $paytyps='Auto';
                                } else {
                                    $paytyps='Manual';
                                }
                                if($late_fee > 0) {
                                    $declined_late_fee = '<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                        <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Late Fee:</span>
                                        <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">$ '.$late_fee.'</span>
                                        </p>';
                                } else {
                                    $declined_late_fee = '';
                                }
                                $msg='<!DOCTYPE html>
                                    <html>
                                        <head>
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
                                                    <h3 style="margin-top: 25px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">Card Declined </h3>
                                                </div>
                                                <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
                                                    <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
                                                        <div style="width: auto;font-weight: 600;color: #656565;text-align: center;display: inline-block;max-width: 623px;margin: 0 auto;background-color: rgba(53, 127, 223, 0.05);border: 1px solid rgba(53, 127, 223, 0.2);">
                                                            <p style="font-size: 21px;float: left;width: 100%;clear: both;color: #444">Card <span style="color: #d0021b;">Declined</span> </p>
                                                            <div style="float: left;width: 100%;clear: both;">
                                                            <br>
                                                        </div>
                                                        <br>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card Number:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.('****'.substr($card_no, -4)).' </span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Invoice No:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["invoice_no"].' </span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Total Amount:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">$ '.$total_amount_with_late_fee.'</span>
                                                        </p>
                                                        '.$declined_late_fee.'
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Payment Type:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$paytyps.' </span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Name:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["name"].'</span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Email:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["email_id"].'</span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Phone:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["mobile_no"].'</span>
                                                        </p>
                                                        
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="float: left;width: 100%;clear: both;">
                                                <br>
                                            </div>
                                            <div style="float: left;width:100%;text-align:center;clear: both;max-width: 100%;">
                                                <div style="max-width: 970px;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 0 auto;display: table;padding: 15px;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                                                    <div style="width:100%;padding-top: 7px;color:#666;float: left;margin: 0 0 10px;">
                                                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                                                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                                                    </div>
                                                    <div style="float: left;width:100%;text-align:center;margin: 0 0 10px;">
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon1.jpg">
                                                        </a>
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon2.jpg">
                                                        </a>
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon3.jpg">
                                                        </a>
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon4.jpg">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </body>
                                </html>'; 
         
                                
                                $customername=$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
                                $MailSubject = ' Declined   Payment form '.$getEmail1[0]['business_dba_name'];
                                $MailSubject2 = ' Declined   Payment of '.$customername;
                                   
                                $email=$getEmail[0]['email_id'];
                                if(!empty($email)) { 
                                    $this->email->from('info@salequick.com',   $getEmail1[0]['business_dba_name']);
                                    $this->email->to($email);
                                    $this->email->subject($MailSubject);
                                    $this->email->message($msg);
                                   // $this->email->send();
                                }
                                // $merchant_email=$getEmail1[0]['email'];
                                // if(!empty($merchant_email)){ 
                
                                //  $this->email->from('info@salequick.com',   $getEmail1[0]['business_dba_name']);
                                //  $this->email->to($merchant_email);
                                //  $this->email->subject($MailSubject2);
                                //  $this->email->message($msg);
                                //  $this->email->send();
                                //  }
                            }
                            $this->session->set_flashdata('errorCode', $response['responsetext']);
                            $id = $response['responsetext'];
                            $this->session->set_flashdata('card_message', $id);
                            redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
                                
                        }
                    } else {
                        //$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
          

                       // save card payment
//echo '<pre>';print_r($_POST);die();

                        $ccnumber=$card_no;
                        $amount=$amount;
                        $ccexp=$expiry_month.$expiry_year;
                        $cvv=$cvv;
                        $authorizationcode="";
                        $ipaddress=$_SERVER['REMOTE_ADDR'];
                        $orderid=$payment_id;
                        $paytype = $getEmail[0]['recurring_pay_type'];

                      

                        $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "amount=" . urlencode(number_format($total_amount_with_late_fee,2,".","")) . "&";
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
                        $message_complete = $response['responsetext'];

                    }
                    else 
                    {
                        $message_complete = 'Error';
                    }
 

                        if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved') {

                           

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


                            if ($message_complete == 'Declined') {$staus = 'declined';} //elseif($message_a=='Approved' or $message_a=='Duplicate'
                            elseif ($message_complete == 'Approved') {$staus = 'confirm';} else { $staus = 'pending';}

                            $type = $getEmail[0]['payment_type'];
                            $recurring_type = $getEmail[0]['recurring_type'];
                            $recurring_count = $getEmail[0]['recurring_count'];

                            $paid = $getEmail[0]['recurring_count_paid'] + 1;
                            ///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value
                            $remain = ($recurring_count > 0) ? $getEmail[0]['recurring_count_remain'] - 1 : 1;
                            $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                            $recurring_next1 = $getEmail[0]['recurring_next_pay_date'];

                            $sub_total = $getEmail[0]['sub_total'] + $amount;
                            $paytype = $getEmail[0]['recurring_pay_type'];

                            $recurring_payment = $getEmail[0]['recurring_payment']; //   start, stop,  complete

                            $lastRecord = $this->Admin_model->getlast_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);

                            $AllPaidRequest = $this->Admin_model->getAllpaid_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            //print_r($lastRecord->recurring_count); echo "<br/>";
                            // print_r($AllPaidRequest);
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $recurring_payment = 'complete';
                            } else {
                                $recurring_payment = $getEmail[0]['recurring_payment'];
                            }

                            // if ($remain <= '0') {
                            //     $recurring_payment = 'complete';
                            // } else {
                            //     $recurring_payment = 'start';
                            // }
                            $day1 = date("N");
                            $today2_a = date("Y-m-d");
                            $today2 = date("Y-m-d H:i:s");
                            $new_add_date= gmdate("Y-m-d H:i:s");
                            $year = date("Y");
                            $month = date("m");
                            $time11 = date("H");
                            if ($time11 == '00') {$time1 = '01';} else { $time1 = date("H");}
                            //print_r($type);  die();
                            if ($type == 'straight') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a,
                                    'payment_date' => $today2,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'sign' => $signImg,
                                    'address' => $address,
                                    'name_card' => $name_card,
                                    'auth_code' => $auth_code,
                                    'l_name' => "",
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'processor_name' => 'PAYROC',
                                    'new_add_date' => $new_add_date,
                                   
                                );
                            } elseif ($type == 'recurring') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a,
                                    'payment_date' => $today2,
                                    'recurring_count_paid' => $paid,
                                    'recurring_count_remain' => $remain,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'sign' => $signImg,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'name_card' => $name_card ? $name_card : $getEmail[0]['name_card'],
                                    'auth_code' => $auth_code,
                                    'sub_total' => $amount, //
                                    'recurring_payment' => $recurring_payment,
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'processor_name' => 'PAYROC',
                                    'new_add_date' => $new_add_date,
                                );
                            }
                            //print_r($id); die();
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $up = $this->Stop_recurring($getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            }
                            $n = $this->Home_model->update_payment_single($id, $info);
                            $data_pax = array(
                            'merchant_id' =>$merchant_id,
                            'pos_id' =>$id,
                            'pax_json'=>$test,
                            'type'=>'invoice' 
                            );
                           $pax_id = $this->Admin_model->insert_data("pax_json", $data_pax);
                            //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
                            //redirect('dashboard/all_subadmin');
                            $this->session->set_flashdata('pmsg', '<div class="text-success text-center">  Payment  Complete </div>');
                            //$this->load->view('admin/add_subadmin/'.$bct_id);
                            $invId = $getEmail[0]['id'];
                            $getQuery = $this->db->query("SELECT * from customer_payment_request where id='$invId' ");
                            $getEmail = $getQuery->result_array();
                            $data['getEmail'] = $getEmail;
                            $data['resend'] = "";
                            //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
                            // $this->load->view('payment' , $data);
                            $email = $getEmail[0]['email_id'];
                            $amount = $getEmail[0]['amount'];
                            $sub_total = $getEmail[0]['sub_total'];
                            $tax = $getEmail[0]['tax'];
                            $originalDate = $getEmail[0]['date_c'];
                            $newDate = date("F d,Y", strtotime($originalDate));
                            $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
                            //Email Process
                            $data['email'] = $getEmail[0]['email_id'];
                            $data['color'] = $getEmail1[0]['color'];
                            $data['amount'] = $getEmail[0]['amount'];
                            $data['sub_total'] = $getEmail[0]['sub_total'];
                            $data['tax'] = $getEmail[0]['tax'];
                            $data['originalDate'] = $getEmail[0]['date_c'];
                            $data['card_a_no'] = $card_a_no;
                            $data['invoice_detail_receipt_item'] = $item;
                            $data['trans_a_no'] = $trans_a_no;
                            $data['card_a_type'] = $card_a_type;
                            $data['message_a'] = $message_a;
                            $data['late_fee_status'] = $getEmail_a[0]['late_fee_status'];
                            $data['late_fee'] = $getEmail[0]['late_fee'];
                            $data['msgData'] = $data;
                            //$msg = $this->load->view('email/new_receipt', $data, true);
                            //$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
                            $msg = $this->load->view('email/new_receipt_dash', $data, true);
                            $merchnat_msg = $this->load->view('email/merchant_receipt_dash', $data, true);

                            //Satrt QuickBook sync
                           $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                            $url ="https://salequick.com/quickbook/get_invoice_detail_live_payment2";
                            $qbdata =array(
                            'id' => $qb_online_invoice_id,
                            'merchant_id' => $bct_id2
                            
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

                            $email = $email;
                            $MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
                            $nameoFCustomer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
                            $MailSubject2 = ' Receipt to ' . $nameoFCustomer;
                            if (!empty($email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($email);
                                $this->email->subject($MailSubject);
                                $this->email->message($msg);
                                $this->email->send();
                            }
                            
                            $merchant_email = $getEmail1[0]['email'];
                            if (!empty($merchant_email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($merchant_email);
                                $this->email->subject($MailSubject2);
                                $this->email->message($merchnat_msg);
                                if($bct_id2 !='413'){
                               // $this->email->send();
                                }
                            }
                            $merchant_notification_email=$getEmail1[0]['notification_email'];
                            if(!empty($merchant_notification_email)) {  
                                $notic_emails=explode(",",$merchant_notification_email);
                                $length=count($notic_emails); 
                                $i=0; $arraydata=array(); 
                                for( $i=0; $i < $length; $i++) {
                                    $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                    $this->email->to($notic_emails[$i]);
                                    $this->email->subject($MailSubject2);
                                    $this->email->message($merchnat_msg);
                                   if($bct_id2 !='413'){
                              //  $this->email->send();
                                }
                                    //array_push($arraydata,$notic_emails[$i]);
                                }
                            }
                            $url = $getEmail[0]['url'];
                            $getEmail[0]['email_id'];
                            $checkurl = strpos($url, 'rpayment');
                            if ($checkurl !== false) {
                                $purl = str_replace('rpayment', 'reciept', $url);
                            } else {
                                $checkurl = strpos($url, 'payment');
                                if ($checkurl !== false) {
                                    $purl = str_replace('payment', 'reciept', $url);
                                }
                            }
                            //$purl = str_replace('payment', 'reciept', $url);
                            if (!empty($getEmail[0]['mobile_no'])) {
                                $sms_reciever = $getEmail[0]['mobile_no'];
                                //$sms_message = trim('Payment Receipt : ' . $purl);
                                $sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);
                                $from = '+18325324983'; //trial account twilio number
                                $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                                $to = '+1' . $mob;
                                $response_twilio = $this->twilio->sms($from, $to, $sms_message);
                            }

                            $gettoken = $this->db->query("SELECT * FROM token WHERE token='$paymentcard' ")->result_array();
                            $merchant_id=$getEmail[0]['merchant_id'];  
                            if (count($gettoken) > 0 && $getEmail[0]['recurring_pay_type']=='1' && $getEmail[0]['payment_type']=='recurring' ) {
                                $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $gettoken[0]['id'],'merchant_id'=>$merchant_id);
                                $this->db->insert('invoice_token', $invoice_tokenData);
                            } 

                            $save_notificationdata = array(
                                'merchant_id' => $merchant_id,
                                'name' => $name ? $name : $getEmail[0]['name'],
                                'mobile' => $phone,
                                'email' => $email,
                                'card_type' => $card_a_type,
                                'card_expiry_month' => $expiry_month,
                                'card_expiry_year' => $expiry_year,
                                'card_no' => $card_a_no,
                                'amount' => $total_amount_with_late_fee,
                                'address' => $Address,
                                'transaction_id' => $trans_a_no,
                                'transaction_date' => $transaction_date,
                                'notification_type' => 'payment',
                                'invoice_no' => $invoice_no,
                                'status' => 'unread',
                                //'zipcode' => $zip
                            );
                            //print_r($save_notificationdata); die();
                            $this->db->insert('notification', $save_notificationdata);
                            if ($getEmail[0]['payment_type'] == 'recurring') {
                                echo base_url() . 'rpayment/' . $bct_id1 . '/' . $bct_id2;
                            } else {
                                echo base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2;
                            }
                        } else {
                            if ($paymentcard != 'newcard') {
                                $id = $response['responsetext'];
                                $id=strtolower(urldecode($id)); 
                                echo 'payment_error/' . $id;
                            } else {
                                $this->session->set_flashdata('errorCode',$response['responsetext']);
                                $id = $response['responsetext'];
                                $this->session->set_flashdata('card_message', $id);
                                redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
                            }
                        }
                    }
                } else {
                    if ($paymentcard != 'newcard') {
                        $id = $response['responsetext'];
                        $id=strtolower(urldecode($id)); 
                        echo 'payment_error/' . $id;
                    } else {
                        $this->session->set_flashdata('errorCode', $response['responsetext']);
                        $id = $response['responsetext'];
                        $this->session->set_flashdata('card_message', $id);
                        redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
                    }
                }
            } else {
                if ($paymentcard == 'newcard') {
                    $this->session->set_flashdata('errorCode', $response['responsetext']);
                    $id = 'Processor-ID-Not-available';
                    $this->session->set_flashdata('card_message', $id);
                    redirect('payment_error/' .$getEmail[0]['id']);   //  $bct_id2
                } else {
                    $id = 'Processor-ID-Not-available';
                    $id=strtolower(urldecode($id)); 
                    echo 'payment_error/' . $id;
                }
            }
        }

}