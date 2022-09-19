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

class api extends REST_Controller {

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


    }


 public function simple_invoice_post() {
      $data = array();
	
         $auth_key=$_POST['auth_key'];
	 $merchant_key=$_POST['merchant_key'];
	  
	 $stmt1 = $this->db->query("SELECT id,status FROM merchant WHERE auth_key='".$auth_key."' and merchant_key='".$merchant_key."' ");
      $getDetail_merchant = $stmt1->result_array();     

     $merchant_id = $getDetail_merchant[0]['id'];

     $merchant_status=$getDetail_merchant[0]['status'];


      $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
      $merchant_name = $merchantdetails['0']['name'];
      $s_fee = $merchantdetails['0']['s_fee'];
      $t_fee = $merchantdetails['0']['t_fee'];
      $fee_invoice = $merchantdetails['0']['invoice'];
      $fee_swap = $merchantdetails['0']['f_swap_Invoice'];
      $fee_email = $merchantdetails['0']['text_email'];
      $names = substr($merchant_name, 0, 3);
      
     
      if ($merchant_status == 'active') {
        $data['meta'] = "Simple Invoice Request";
        $data['loc'] = "simple_invoice";
        $data['action'] = "Send Request";
       
         
        $name = htmlspecialchars($this->input->post('name'));
        $email_id = htmlspecialchars($this->input->post('email')); 
		$amount_ss = htmlspecialchars($this->input->post('amount'));
		$due_date = htmlspecialchars($this->input->post('due_date'));
$mobile_no = htmlspecialchars($this->input->post('phone'));
		
          if ( (empty($amount_ss)  || empty($name) ||  empty($due_date))  || (empty($email_id) && empty($mobile_no)) ) {
          $response = ['status' => '401', 'errorMsg' => 'Name, Email, Due  Date, Amount Fields Are Required!'];
                       
          } else {
            
            
            
            $b = str_replace(",","",$amount_ss);
                        $a = number_format($b,2);
                        $amount = str_replace(",","",$a);
            $detail = "";
            
			$reference = htmlspecialchars($this->input->post('reference') ? $this->input->post('reference') : "N/A");
            
            
            $sub_amount = htmlspecialchars($this->input->post('amount') ? $this->input->post('amount') : "");
            $total_tax_a = htmlspecialchars($this->input->post('tax') ? $this->input->post('tax') : '0' . "");
			$total_tax =number_format($total_tax_a, 2);
            $other_charges = "";
            $other_charges_title = "";
            
           
            $sub_merchant_id = '0';
            
            $fee = ($amount / 100) * $fee_invoice;
            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
            $fee_email = ($fee_email != '') ? $fee_email : 0;
            $fee = $fee + $fee_swap + $fee_email;
            
            $recurring_type = 'false';
            $recurring_count = '0';
            
            $recurring_payment = 'stop';
            $invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
            $invoice_no = str_replace("000000", "", $invoice_no_1);
            $today1 = date("ymdhisu");
            $url = base_url().'spayment/PY' . $today1 . '/' . $merchant_id;
            $today2 = date("Y-m-d");
            $p_date = date('F j, Y', strtotime($today2));
            $year = date("Y");
            $month = date("m");
            $time11 = date("H");
            if ($time11 == '00') {
              $time1 = '01';
            } else {
              $time1 = date("H");
            }
            $day1 = date("N");
            $today3 = date("Y-m-d H:i:s");
            $amountaa = $sub_amount + $fee;
            $unique = "PY" . $today1;
            $data = array(
              'name' => $name,
              'other_charges' => $other_charges,
              'otherChargesName' => $other_charges_title,
			  'reference' => $reference,
              'invoice_no' => $invoice_no,
              'sub_total' => $sub_amount,
              'tax' => $total_tax,
              'fee' => $fee,
              's_fee' => $s_fee,
              'email_id' => $email_id,
              'mobile_no' => $mobile_no,
              'amount' => $amount,
              'detail' => $detail,
              'url' => $url,
              'payment_type' => 'straight',
              'invoice_type' => 'simple',
              'recurring_type' => $recurring_type,
              'recurring_count' => $recurring_count,
              'recurring_count_paid' => '0',
              'recurring_count_remain' => $recurring_count,
              'due_date' => $due_date,            
              'merchant_id' => $merchant_id,
              'sub_merchant_id' => $sub_merchant_id,
              'payment_id' => $unique,
              'recurring_payment' => $recurring_payment,
              'year' => $year,
              'month' => $month,
              'time1' => $time1,
              'day1' => $day1,
              'status' => 'pending',
              'date_c' => $today2,
              'add_date' => $today3,
              'api_payment' => 'yes',
            );
           // print_r($data); die();
            $id = $this->admin_model->insert_data("customer_payment_request", $data);
            
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
            $data['payment_type'] = 'straight';
            $data['recurring_type'] = $recurring_type;
            $data['no_of_invoice'] = 1;
            $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
             
            $data['msgData'] = $data;
            // echo "<pre>";print_r($data);die;
            //Send Mail Code
            $msg = $this->load->view('email/simple_invoice', $data, true);
            $email = $email_id;
            if (!empty($mobile_no)) {
              $sms_reciever = $mobile_no;
              //$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
              $sms_message = trim(" Hello '" . $name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
              $from = '+18325324983'; //trial account twilio number
              // $to = '+'.$sms_reciever; //sms recipient number
              $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
              $to = '+1' . $mob;
              $response = $this->twilio->sms($from, $to, $sms_message);
            }
            $MailTo = $email;
            $MailSubject = 'Invoice from '.$getDashboardData_m[0]['business_dba_name'];
            if (!empty($email)) {
              $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
              $this->email->to($MailTo);
              $this->email->subject($MailSubject);
              $this->email->message($msg);
              $this->email->send();
            }
			
			 $stmt_invoice = $this->db->query("SELECT url,amount,tax,name,invoice_no,payment_id,reference FROM customer_payment_request WHERE id='".$id."' ");
             $getDetail_stmt_invoice = $stmt_invoice->result_array();     

            $invoice = array();
            $invoice['payment_url'] = $getDetail_stmt_invoice[0]['url'];
			$invoice['amount'] = $getDetail_stmt_invoice[0]['amount'];
			$invoice['tax'] = $getDetail_stmt_invoice[0]['tax'];
			$invoice['name'] = $getDetail_stmt_invoice[0]['name'];
			$invoice['invoice_no'] = $getDetail_stmt_invoice[0]['invoice_no'];
			$invoice['payment_id'] = $getDetail_stmt_invoice[0]['payment_id'];
           
			$status = parent::HTTP_OK;
			$response = ['status' => $status, 'successMsg' => 'Invoice send successfully','UserData' => $invoice];
           
          }
        
      } elseif ($merchant_status == 'block') {
        
		$response = ['status' => '401', 'errorMsg' => 'Your Account Is Block!'];
        
      } elseif ($merchant_status == 'confirm') {
     
		
		$response = ['status' => '401', 'errorMsg' => 'Your Account Is Not Active!'];
      } elseif ($merchant_status == "Activate_Details") {
       
		$response = ['status' => '401', 'errorMsg' => 'Please Activate Your Account!'];
       
      } elseif ($merchant_status == "Waiting_For_Approval") {
        
		$response = ['status' => '401', 'errorMsg' => 'Waiting For Admin Approval!'];
       
      } else {
        
		$response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!!'];
       
      }

    $this->response($response, $status);
    }
	
	public function all_payment_post() {
    $data = array();
   
     $auth_key=$_POST['auth_key'];
	 $status=$_POST['status'];
	 $merchant_key=$_POST['merchant_key'];
	  
	 $stmt1 = $this->db->query("SELECT id,status FROM merchant WHERE auth_key='".$auth_key."' and merchant_key='".$merchant_key."' ");
     $getDetail_merchant = $stmt1->result_array();     
     $merchant_id = $getDetail_merchant[0]['id'];
    if(!empty($merchant_id))
    {
	$userdata= array();
		$start1 = $_POST['start_date'];
			$end1 = $_POST['end_date'];

			if ($_POST['start_date'] != '') {

				$start = $start1;

			} else {
				$start = date("Y-m-d", strtotime("-364 days"));
			}

			if ($_POST['end_date'] != '') {

				$end = $end1;

			} else {
				$end = date("Y-m-d");
			}
			
		

			$stmt = $this->db->query("SELECT id,name,email_id,payment_id,amount,tax,title,mobile_no,invoice_no,payment_date,add_date,reference,status,due_date,transaction_id,transaction_type,sign FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and status='".$status."' and date_c >='".$start."' and date_c <= '".$end."' order by id desc  ");
		
			$package_data = $stmt->result_array();
			//print_r($package_data);
	
	
		$mem = array();
		$member = array();

		
					foreach ($package_data as $each) {

				
					    
						$package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "NA",
                            'id' => $each['id'] ? $each['id'] : "NA",
                            'name' => $each['name'] ? $each['name'] : "NA",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "NA",
                            'amount' => $each['amount'] ? $each['amount'] : "NA",
                            'tax' => $each['tax'] ? $each['tax'] : "NA",
                            'mob_no' => $each['mobile_no'] ? $each['mobile_no'] : "NA",
                            'payment_id' => $each['payment_id'] ? $each['payment_id'] : "NA",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "NA",
                            'date_c' => $each['add_date'] ? $each['add_date'] : "NA",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "NA",
                            'status' => $each['status'] ? $each['status'] : "NA",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'sign' => $each['sign'] ? $each['sign'] : "NA",
                            

						);
					
					$mem[] = $package;
				}
	
		$userdata = $mem;
	
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}


}
?>