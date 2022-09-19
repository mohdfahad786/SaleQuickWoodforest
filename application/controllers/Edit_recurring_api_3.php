<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require APPPATH . 'third_party/REST_Controller.php';
//require APPPATH . 'third_party/Format.php';

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

//use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");

//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Edit_recurring_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->library('email');
        $this->load->library('twilio');
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);

    }
    
    private function verify_request()
{
    // Get all the headers
    $headers = $this->input->request_headers();
    
    //print_r($headers); die();
    // Extract the token
    //$token = $headers['Authorization'];
     $token = $headers['X-Requested-With'];
    

    // Use try-catch
    // JWT library throws exception if the token is not valid
    try {
        // Validate the token
        // Successfull validation will return the decoded user data else returns false
        $data = AUTHORIZATION::validateToken($token);
        if ($data === false) {
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
            $this->response($response, $status);

            exit();
        } else {
            return $data;
        }
    } catch (Exception $e) {
        // Token is invalid
        // Send the unathorized access message
        $status = parent::HTTP_UNAUTHORIZED;
        $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
        $this->response($response, $status);
    }
}
    public function edit_customer_request_post() {    
    	//die('Hi'); 
        $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    $id2 = $this->input->post('id');
    if($merchant_id == $data->merchant_id)
    {
		$aa = $this->admin_model->s_fee("merchant", $merchant_id);
		$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
		$s_fee = $merchantdetails['0']['s_fee'];
		$t_fee =$merchantdetails['0']['t_fee'];
		$merchant_name = $merchantdetails['0']['name'];
		$fee_invoice = $merchantdetails['0']['invoice'];
		$fee_swap = $merchantdetails['0']['f_swap_Recurring'];
		$fee_email = $merchantdetails['0']['text_email'];
		$names = substr($merchant_name, 0, 3);

		$getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
		$getDashboardData = $getDashboard->result_array();
		$getDashboardNum = $getDashboard->num_rows();
		if ($getDashboardData == false) {
			$getDashboardData = '0';
			$inv = '1';
		} else {
			$inv1 = $getDashboardData[0]['TotalOrders'];
			$inv = $inv1 + 1;
		}
		$merchant_status = $merchantdetails['0']['status'];
				
		$pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
        $amount = $this->input->post('amount') ? $this->input->post('amount') : "";  
				$sub_merchant_id = '0';  
				$fee = ($amount / 100) * $fee_invoice;
				$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
				$fee_email = ($fee_email != '') ? $fee_email : 0;
				$fee = $fee + $fee_swap + $fee_email;
				$sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
				$total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
				$invoice_no = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
				$recurring_payment = 'start';

				$getRow=$this->db->query(" SELECT * FROM customer_payment_request WHERE id='$id' " )->result_array(); 
				$merchant_id=$getRow[0]['merchant_id']; 
				$getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
				$Merchantdata = $getMerchantdata->row_array();
				$reptdata['getEmail1']=$getMerchantdata->result_array();

				
									   //print_r($_POST);  die();
					   $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
                       $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
					   $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";  
					   //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
					  $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
					  $name = $this->input->post('name') ? $this->input->post('name') : "";
					  $email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
					  $phone=$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
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
					   
					   $title = $this->input->post('title') ? $this->input->post('title') : "";
					   $other_charges_state = $this->input->post('other_charges_state') ? $this->input->post('other_charges_state') : "";
					   
					  // $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
					  $recurring_next_pay_date = $this->input->post('recurring_next_pay_date') ? $this->input->post('recurring_next_pay_date') : "";
					  $recurring_pay_start_date = $this->input->post('recurring_pay_start_date') ? $this->input->post('recurring_pay_start_date') : "";
					  $note = $this->input->post('note') ? $this->input->post('note') : "";
					  $reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
					  
					  $address = $this->input->post('address') ? $this->input->post('address') : "";
					  $country = $this->input->post('country') ? $this->input->post('country') : "";
					  $city = $this->input->post('city') ? $this->input->post('city') : "";
					  $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
					  $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
					  $name_card = $this->input->post('name_card') ? $this->input->post('name_card') : "";
					  $expiry_month = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
					  $expiry_year = $this->input->post('exp_year') ? $this->input->post('exp_year') : "";
					  $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
					  $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
					   $orignal_amount = $this->input->post('orignal_amount') ? $this->input->post('orignal_amount') : "0.00"; 
					    $update_amount = $this->input->post('update_amount') ? $this->input->post('update_amount') : "0.00"; 
					  
					   //echo $pd__constant;   // pd__constant
						//   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
					   if($pd__constant=='on' &&  $recurring_count=="") { $recurring_count=-1;  }
					   $curdate=date('Y-m-d');

 
					   if($getRow[0]['recurring_count_paid']=='0')
					   {
							 if($getRow[0]['recurring_pay_type']=='1')  //  auto 
							 {
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
											   $today1_1 = date("ymdhisu");
                                               $dfg = str_replace("000000", "", $today1_1);
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
                                                   'title' => $title,
                                                   'other_charges_state' => $other_charges_state,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												   'amount' => $amount,
												   'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   'payment_id'=>$unique2,
												   'url'=>$url2,
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
												   'address' =>  $address,
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $resend = "";
										 
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
													 
											$msgData = $data2;
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
													   //$m=$this->email->send();
													   }
											  }
							 $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
										   
								   }
								   else if($paytype=='0')  //  auto to manual 
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
											   $today1_1 = date("ymdhisu");
                                               $dfg = str_replace("000000", "", $today1_1);
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
                                                   'title' => $title,
                                                   'other_charges_state' => $other_charges_state,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   'payment_id'=>$unique2,
												   'url'=>$url2,
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
												   'address' =>  $address,
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $resend = "";
										   
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
													 
											$data = $data2;
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
													   //$m=$this->email->send();
													   }
											  }


							 $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
										   
									   
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
											   $today1_1 = date("ymdhisu");
                                               $dfg = str_replace("000000", "", $today1_1);
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
                                                   'title' => $title,
                                                   'other_charges_state' => $other_charges_state,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   'payment_id'=>$unique2,
												   'url'=>$url2,
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
												   'address' =>  $address,
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $resend = "";
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
													 
											$data->msgData = $data2;
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
													   //$m=$this->email->send();
													   }
											  }


											  $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
																		   
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
											   $today1_1 = date("ymdhisu");
                                               $dfg = str_replace("000000", "", $today1_1);
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
                                                   'title' => $title,
                                                   'other_charges_state' => $other_charges_state,
												   'invoice_no' => $invoice_no,
												   'email_id' => $email_id,
												   'mobile_no' => $mobile_no,
												   'amount' => $amount,
												   'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												   'sub_total' => $sub_amount,
												   'tax' => $total_tax,
												   'fee' => $fee,
												   's_fee' => $fee_swap,
												   'payment_id'=>$unique2,
												   'url'=>$url2,
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
												   'address' =>  $address,
												   'ip_a' => $_SERVER['REMOTE_ADDR'],
												   'order_type' => 'a'
											   );
				   
										   //print_r($data2); die(); 
										  // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',$data2);
										   $resend = "";
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
													 
											$data = $data2;
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
													   //$m=$this->email->send();
													   }
											  }
											 

											  $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
											$today1_1 = date("ymdhisu");
                                            $dfg = str_replace("000000", "", $today1_1);
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
                                                'other_charges_state' => $other_charges_state,
												'invoice_no' => $invoice_no,
												'email_id' => $email_id,
												'mobile_no' => $mobile_no,
												'amount' => $amount,
												'orignal_amount' => $orignal_amount,
												'update_amount' => $update_amount,
												'sub_total' => $sub_amount,
												'tax' => $total_tax,
												'fee' => $fee,
												's_fee' => $fee_swap,
												'title' => $title,
												'detail' => $remark,
												'note' => $note,
												'url' => $url2,
												'payment_type' => 'recurring',
												'recurring_type' => $recurring_type,
												'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
												'recurring_count' => $recurring_count1,
												// 'due_date' => $due_date,
												'merchant_id' => $merchant_id,
												'sub_merchant_id' => $sub_merchant_id,
												'payment_id' => $unique2,
												'recurring_payment' => $recurring_payment,
						
												'recurring_pay_start_date' => $recurring_pay_start_date1,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $paytype,
												
												'add_date' => $today3,
												'status' => 'pending',
												'year' => $year,
												'month' => $month,
												'time1' => $time1,
												'day1' => $day1,
												'date_c' => $today2_a,
												'payment_date' => "",
												'recurring_count_paid' => $paid,
												'recurring_count_remain' => $remain, 
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
						
											//print_r($data2); die(); 
				
												$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
												//$data['resend'] = "";
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
														
												//$data['msgData'] = $data2;
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
															//$m=$this->email->send();
															}
												}
												$this->db->where('id', $id);
												$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
												
										
												$status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];

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
                                                    'title' => $title,
                                                    'other_charges_state' => $other_charges_state,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'orignal_amount' => $orignal_amount,
												    'update_amount' => $update_amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
															//$m=$this->email->send();
															}
													}



											$status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
									  
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

														$today1_1 = date("ymdhisu");
                                                        $today1 = str_replace("000000", "", $today1_1);
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
																		'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
																		'sub_total' => $sub_amount,
																		'tax' => $total_tax,
																		'fee' => $fee,
																		's_fee' => $fee_swap,
																		'title' => $title,
																		'other_charges_state' => $other_charges_state,
																		'detail' => $remark,
																		'note' => $note,
																		'url' => $url,    /// 
																		'payment_type' => 'recurring',
																		'recurring_type' => $recurring_type,
																		'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
																		'recurring_count' => $recurring_count1,
																		// 'due_date' => $row['due_date'],
																		'merchant_id' => $merchant_id,
																		'sub_merchant_id' => $sub_merchant_id,
																		'payment_id'=>$unique,
																		'recurring_payment' => $recurring_payment,
																		
																		'recurring_pay_start_date' => $recurring_pay_start_date1,
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
																//$this->email->send();
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
															$status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];

												}
												else
												{
													$ide=$arrayy['Response']['ExpressResponseMessage']; 

													 $response = ['status' => 401, 'errorMsg' => $ide];
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
												$today1_1 = date("ymdhisu");
                                                $dfg = str_replace("000000", "", $today1_1);
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
													'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'fee' => $fee,
													's_fee' => $fee_swap,
													'title' => $title,
													'other_charges_state' => $other_charges_state,
													'detail' => $remark,
													'note' => $note,
													'url' => $url2,
													'payment_type' => 'recurring',
													'recurring_type' => $recurring_type,
													'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'merchant_id' => $merchant_id,
													'sub_merchant_id' => $sub_merchant_id,
													'payment_id' => $unique2,
													'recurring_payment' => $recurring_payment,
							
													'recurring_pay_start_date' => $recurring_pay_start_date1,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													
													'add_date' => $today3,
													'status' => 'pending',
													'year' => $year,
													'month' => $month,
													'time1' => $time1,
													'day1' => $day1,
													'date_c' => $today2_a,
													'payment_date' => "",
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
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
																//$m=$this->email->send();
																}
													 $this->db->where('id', $id);
													 $updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
													 
$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
                                                    'other_charges_state' => $other_charges_state,
                                                    'title' => $title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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

											$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
                                                            'other_charges_state' => $other_charges_state,
                                                            'title' => $title,
															'invoice_no' => $invoice_no,
															'email_id' => $email_id,
															'mobile_no' => $mobile_no,
															'amount' => $amount,
														'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
															'sub_total' => $sub_amount,
															'tax' => $total_tax,
															'url'=>$getRow[0]['url'],
															'date_c'=>$getRow[0]['date_c'],
															'payment_type' => $type,
															'recurring_type' => $recurring_type,
															'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
													$resend = "";
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
																	//$m=$this->email->send();
																	}
															}
													 
													$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
												  
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
		
															$today1_1 = date("ymdhisu");
                                                            $today1 = str_replace("000000", "", $today1_1);

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
														'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
																			'sub_total' => $sub_amount,
																			'tax' => $total_tax,
																			'fee' => $fee,
																			's_fee' => $fee_swap,
																			'payment_type' => $type,
																			'recurring_type' => $recurring_type,
																			'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
																			'recurring_count' => $recurring_count1,
																			'merchant_id' => $merchant_id,
																			'sub_merchant_id' => $sub_merchant_id,
																			'recurring_payment' => $recurring_payment,
																			'recurring_pay_start_date' => $recurring_pay_start_date1,
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
																	//$this->email->send();
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
																$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
		
													}
													else
													{
														$ide=$arrayy['Response']['ExpressResponseMessage']; 
														 $response = ['status' => 401, 'errorMsg' => $ide];
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
                                                                'other_charges_state' => $other_charges_state,
                                                                'title'=>$title,
																'invoice_no' => $invoice_no,
																'email_id' => $email_id,
																'mobile_no' => $mobile_no,
																'amount' => $amount,
																'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
																'sub_total' => $sub_amount,
																'tax' => $total_tax,
																'url'=>$getRow[0]['url'],
																'date_c'=>$getRow[0]['date_c'],
																'payment_type' => $type,
																'recurring_type' => $recurring_type,
																'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
																		//$m=$this->email->send();
																		}
																}
														
														$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
                                                            'other_charges_state' => $other_charges_state,
                                                            'title'=>$title,
															'invoice_no' => $invoice_no,
															'email_id' => $email_id,
															'mobile_no' => $mobile_no,
															'amount' => $amount,
															'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
															'sub_total' => $sub_amount,
															'tax' => $total_tax,
															'url'=>$getRow[0]['url'],
															'date_c'=>$getRow[0]['date_c'],
															'payment_type' => $type,
															'recurring_type' => $recurring_type,
															'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
																	//$m=$this->email->send();
																	}
															}
													
													$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id]; 
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
										$today1_1 = date("ymdhisu");
                                        $dfg = str_replace("000000", "", $today1_1);
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
                                            'other_charges_state' => $other_charges_state,
											'invoice_no' => $invoice_no,
											'email_id' => $email_id,
											'mobile_no' => $mobile_no,
											'amount' => $amount,
											'orignal_amount' => $orignal_amount,
											'update_amount' => $update_amount,
											'sub_total' => $sub_amount,
											'tax' => $total_tax,
											'fee' => $fee,
											's_fee' => $fee_swap,
											 'title' => $title,
											'detail' => $remark,
											'note' => $note,
											'url' => $url2,
											'payment_type' => 'recurring',
											'recurring_type' => $recurring_type,
											'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
											'recurring_count' => $recurring_count1,
											// 'due_date' => $due_date,
											'merchant_id' => $merchant_id,
											'sub_merchant_id' => $sub_merchant_id,
											'payment_id' => $unique2,
											'recurring_payment' => $recurring_payment,
					
											'recurring_pay_start_date' => $recurring_pay_start_date1,
											'recurring_next_pay_date' => $recurring_next_pay_date,
											'recurring_pay_type' => $paytype,
											
											'add_date' => $today3,
											'status' => 'pending',
											'year' => $year,
											'month' => $month,
											'time1' => $time1,
											'day1' => $day1,
											'date_c' => $today2_a,
											'payment_date' => "",
											'recurring_count_paid' => $paid,
											'recurring_count_remain' => $remain, 
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
														//$m=$this->email->send();
														}
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
											
											$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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

														$today1_1 = date("ymdhisu");
                                                        $today1 = str_replace("000000", "", $today1_1);
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
																		'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
																		'sub_total' => $sub_amount,
																		'tax' => $total_tax,
																		'fee' => $fee,
																		's_fee' => $fee_swap,
																		'other_charges_state' => $other_charges_state,
																		'title' => $title,
																		'detail' => $remark,
																		'note' => $note,
																		'url' => $url,    /// 
																		'payment_type' => 'recurring',
																		'recurring_type' => $recurring_type,
																		'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
																		'recurring_count' => $recurring_count1,
																		// 'due_date' => $row['due_date'],
																		'merchant_id' => $merchant_id,
																		'sub_merchant_id' => $sub_merchant_id,
																		'payment_id'=>$unique,
																		'recurring_payment' => $recurring_payment,
																		
																		'recurring_pay_start_date' => $recurring_pay_start_date1,
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
															$resend = "";
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
																//$this->email->send();
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
															$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];

												}
												else
												{
													$ide=$arrayy['Response']['ExpressResponseMessage']; 
													 $response = ['status' => 401, 'errorMsg' => $ide];
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
												$today1_1 = date("ymdhisu");
                                                $dfg = str_replace("000000", "", $today1_1);
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
													'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'fee' => $fee,
													's_fee' => $fee_swap,
													'other_charges_state' => $other_charges_state,
													 'title' => $title,
													'detail' => $remark,
													'note' => $note,
													'url' => $url2,
													'payment_type' => 'recurring',
													'recurring_type' => $recurring_type,
													'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
													'recurring_count' => $recurring_count1,
													// 'due_date' => $due_date,
													'merchant_id' => $merchant_id,
													'sub_merchant_id' => $sub_merchant_id,
													'payment_id' => $unique2,
													'recurring_payment' => $recurring_payment,
							
													'recurring_pay_start_date' => $recurring_pay_start_date1,
													'recurring_next_pay_date' => $recurring_next_pay_date,
													'recurring_pay_type' => $paytype,
													
													'add_date' => $today3,
													'status' => 'pending',
													'year' => $year,
													'month' => $month,
													'time1' => $time1,
													'day1' => $day1,
													'date_c' => $today2_a,
													'payment_date' => "",
													'recurring_count_paid' => $paid,
													'recurring_count_remain' => $remain, 
													'ip_a' => $_SERVER['REMOTE_ADDR'],
													'order_type' => 'a'
												);
							
												//print_r($data2); die(); 
					
													$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
													$resend = "";
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
													
													$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];    	
											           
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
											$today1_1 = date("ymdhisu");
                                            $dfg = str_replace("000000", "", $today1_1);
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
												'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												'sub_total' => $sub_amount,
												'tax' => $total_tax,
												'fee' => $fee,
												's_fee' => $fee_swap,
												'other_charges_state' => $other_charges_state,
												'title' => $title,
												'detail' => $remark,
												'note' => $note,
												'url' => $url2,
												'payment_type' => $type,
												'recurring_type' => $recurring_type,
												'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
												'recurring_count' => $recurring_count1,
												// 'due_date' => $due_date,
												'merchant_id' => $merchant_id,
												'sub_merchant_id' => $sub_merchant_id,
												'payment_id' => $unique2,
												'recurring_payment' => $recurring_payment,
						
												'recurring_pay_start_date' => $recurring_pay_start_date1,
												'recurring_next_pay_date' => $recurring_next_pay_date,
												'recurring_pay_type' => $paytype,
												
												'add_date' => $today3,
												'status' => 'pending',
												'year' => $year,
												'month' => $month,
												'time1' => $time1,
												'day1' => $day1,
												'date_c' => $today2_a,
												'payment_date' => "",
												'recurring_count_paid' => $paid,
												'recurring_count_remain' => $remain, 
												'ip_a' => $_SERVER['REMOTE_ADDR'],
												'order_type' => 'a'
											);
						
											//print_r($data2); die(); 
				
												$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
												$resend = "";
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
												
												$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];

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
                                                    'other_charges_state' => $other_charges_state,
                                                    'title'=>$title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
											$resend = "";
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
															//$m=$this->email->send();
															}
													}
                                             
											$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
                                          
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

													$today1_1 = date("ymdhisu");
                                                    $today1 = str_replace("000000", "", $today1_1);
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
                                                                    'other_charges_state' => $other_charges_state,
                                                                    'title'=>$title,
																	'invoice_no' => $invoice_no,
																	'email_id' => $email_id,
																	'mobile_no' => $mobile_no,
																	'amount' => $amount,
																	'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
																	'sub_total' => $sub_amount,
																	'tax' => $total_tax,
																	'fee' => $fee,
																	's_fee' => $fee_swap,
																	'payment_type' => $type,
																	'recurring_type' => $recurring_type,
																	'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
																	'recurring_count' => $recurring_count1,
																	'merchant_id' => $merchant_id,
																	'sub_merchant_id' => $sub_merchant_id,
																	'recurring_payment' => $recurring_payment,
																	'recurring_pay_start_date' => $recurring_pay_start_date1,
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
														$resend = "";
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
														$resend = "";
												
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
															//$this->email->send();
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
														$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];

											}
											else
											{
												$ide=$arrayy['Response']['ExpressResponseMessage']; 
												 $response = ['status' => 401, 'errorMsg' => $ide];
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
                                                        'other_charges_state' => $other_charges_state,
                                                        'title'=>$title,
														'invoice_no' => $invoice_no,
														'email_id' => $email_id,
														'mobile_no' => $mobile_no,
														'amount' => $amount,
														'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
														'sub_total' => $sub_amount,
														'tax' => $total_tax,
														'url'=>$getRow[0]['url'],
														'date_c'=>$getRow[0]['date_c'],
														'payment_type' => $type,
														'recurring_type' => $recurring_type,
														'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
												$resend = "";
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
																//$m=$this->email->send();
																}
														}
												
												$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
                                                    'other_charges_state' => $other_charges_state,
                                                    'title'=>$title,
													'invoice_no' => $invoice_no,
													'email_id' => $email_id,
													'mobile_no' => $mobile_no,
													'amount' => $amount,
													'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
													'sub_total' => $sub_amount,
													'tax' => $total_tax,
													'url'=>$getRow[0]['url'],
													'date_c'=>$getRow[0]['date_c'],
													'payment_type' => $type,
													'recurring_type' => $recurring_type,
													'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
											$resend = "";
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
															//$m=$this->email->send();
															}
													}
											
											$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
										$today1_1 = date("ymdhisu");
                                        $dfg = str_replace("000000", "", $today1_1);
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
											'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
											'sub_total' => $sub_amount,
											'tax' => $total_tax,
											'fee' => $fee,
											's_fee' => $fee_swap,
											'other_charges_state' => $other_charges_state,
											'title' => $title,
											'detail' => $remark,
											'note' => $note,
											'url' => $url2,
											'payment_type' => 'recurring',
											'recurring_type' => $recurring_type,
											'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
											'recurring_count' => $recurring_count1,
											// 'due_date' => $due_date,
											'merchant_id' => $merchant_id,
											'sub_merchant_id' => $sub_merchant_id,
											'payment_id' => $unique2,
											'recurring_payment' => $recurring_payment,
					
											'recurring_pay_start_date' => $recurring_pay_start_date1,
											'recurring_next_pay_date' => $recurring_next_pay_date,
											'recurring_pay_type' => $paytype,
											
											'add_date' => $today3,
											'status' => 'pending',
											'year' => $year,
											'month' => $month,
											'time1' => $time1,
											'day1' => $day1,
											'date_c' => $today2_a,
											'payment_date' => "",
											'recurring_count_paid' => $paid,
											'recurring_count_remain' => $remain, 
											'ip_a' => $_SERVER['REMOTE_ADDR'],
											'order_type' => 'a'
										);
					
										 // print_r($data2); die(); 
			
											$id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
											$resend = "";
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
					
											$getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_grace_period,late_fee_status,late_fee FROM merchant WHERE id = '" . $merchant_id . "' ");
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
													
											//$data['msgData'] = $data2;
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
														//$m=$this->email->send();
														}
											}
											$this->db->where('id', $id);
											$updateresult=$this->db->update('customer_payment_request',array('recurring_next_pay_date'=>date('Y-m-d')));
											
											$status = parent::HTTP_OK;

											$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
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
												'orignal_amount' => $orignal_amount,
												   'update_amount' => $update_amount,
												'sub_total' => $sub_amount,
												'tax' => $total_tax,
												'url'=>$getRow[0]['url'],
												'date_c'=>$getRow[0]['date_c'],
												'payment_type' => $type,
												'recurring_type' => $recurring_type,
												'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
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
										$resend = "";
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
														//$m=$this->email->send();
														}
												}
										

										$response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];




								}
							}        
						}
						
					}  
					

                 
           
                      if(!empty($id)){
                             $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Payment Request Update Successfull','id' => $id];
                        
                        }
                        else
                        {
                             $response = ['status' => 401, 'errorMsg' => 'Payment Request Not Send'];
                        }
                       
                        }
                        else
                        {
                            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
                        }
                        $this->response($response, $status);
} 


}  //   End Of The Class 
?>