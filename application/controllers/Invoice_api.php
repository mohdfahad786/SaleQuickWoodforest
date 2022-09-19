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

class Invoice_api extends REST_Controller {

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
        date_default_timezone_set("America/Chicago");    

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
    
    public function set_invoice_state_post()
    {
        // Call the verification method and store the return value in the variable
        $data = array();
        $data = $this->verify_request();
        $merchant_id = $this->input->post('merchant_id');
        if($merchant_id == $data->merchant_id)
        {
            	$sub_merchant_id = $this->input->post('sub_merchant_id');
    			if($sub_merchant_id!=0){
    			    $merchant_id = $sub_merchant_id;
    
    			}
    			else
    			{
    			      $merchant_id = $merchant_id;
    			}
    			$invoice_type = $this->input->post('invoice_type');
    			
           $userdata = array();
           $query = $this->db->query("UPDATE `merchant` SET `invoice_type`='".$invoice_type."' where id ='".$merchant_id."'");
    
        // Send the return data as reponse
        $status = parent::HTTP_OK;
    
        $response = ['status' => $status, 'successMsg' => 'Successfull'];
        }
        else
        {
            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
        }
    
        $this->response($response, $status);
    }


		
		public function pos_invoice_request_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');

    if($merchant_id == $data->merchant_id)
    {
			$sub_merchant_id = $this->input->post('sub_merchant_id');
			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$merchant_name = $merchantdetails['0']['name'];
			$s_fee = $merchantdetails['0']['s_fee'];
			$t_fee = $merchantdetails['0']['t_fee']; 
			$fee_invoice = $merchantdetails['0']['invoice'];
			$fee_swap = $merchantdetails['0']['f_swap_Invoice'];
			$fee_email = $merchantdetails['0']['text_email'];
			$names = substr($merchant_name, 0, 3);
			

			
						$amount = $this->input->post('total_amount') ? $this->input->post('total_amount') : "";
						$other_charges = $this->input->post('otherCharges') ? $this->input->post('otherCharges') : "";
                        $other_charges_title = $this->input->post('otherChargesName') ? $this->input->post('otherChargesName') : "N/A";
						$title = $this->input->post('title') ? $this->input->post('title') : "";
						$remark = $this->input->post('detail') ? $this->input->post('detail') : "";
						$name = $this->input->post('name') ? $this->input->post('name') : "";
						$email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
						$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
						$sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
						$total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
						$note = $this->input->post('note') ? $this->input->post('note') : "";
						$reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
						
						
							$uploadedFileName="";
						
						$attachment=$uploadedFileName;
						if (!empty($sub_merchant_id)) {
							$sub_merchant_id = $sub_merchant_id;
						} else {
							$sub_merchant_id = '0';
						}
						$fee = ($amount / 100) * $fee_invoice;
						$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
						$fee_email = ($fee_email != '') ? $fee_email : 0;
						$fee = $fee + $fee_swap + $fee_email;
						
						$recurring_type = 'false';
						$recurring_count = '0';
						$due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
						$recurring_payment = 'stop';
						// $invoice_no = 'INV'.strtoupper($names).'000'. $sub_merchant_id.rand(10,1000000).$inv;
						//$invoice_no = 'INV' . strtoupper($names) . $sub_merchant_id . rand(10, 1000000) . $inv;
						//$invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
						$invoice_no_1= 'INV' .  date("ymdhisu");
                        $invoice_no = str_replace("000000", "", $invoice_no_1);
						
						$today1_1 = date("ymdhisu");
                        $today1 = str_replace("000000", "", $today1_1);
						$url = base_url().'payment/PY' . $today1 . '/' . $merchant_id;
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
							'invoice_no' => $invoice_no,
							'other_charges' => $other_charges,
                            'otherChargesName' => $other_charges_title,
							'sub_total' => $sub_amount,
							'tax' => $total_tax,
							'fee' => $fee,
							's_fee' => $s_fee,
							'email_id' => $email_id,
							'mobile_no' => $mobile_no,
							'amount' => $amount,
							'title' => $title,
							'detail' => $remark,
							'attachment'=>$attachment,
							'note' => $note,
							'url' => $url,
							'payment_type' => 'straight',
							'recurring_type' => $recurring_type,
							'recurring_count' => $recurring_count,
							'recurring_count_paid' => '0',
							'recurring_count_remain' => $recurring_count,
							'due_date' => $due_date,
							'reference' => $reference,
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
							'payment_device' => 'app',
						);
						$id = $this->admin_model->insert_data("customer_payment_request", $data);

// start 
						$stmt = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,
			ct.quantity*it.price as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct join adv_pos_item it 
			on it.id=ct.item_id 
			 where ct.merchant_id='".$merchant_id."' and ct.user_id='".$sub_merchant_id."' and ct.status=0 order by ct.id desc");

		$stmt1 = $this->db->query("SELECT ct.id,it.id as tier_id,it.item_id, it.name,it.title, ct.price,ct.new_price, it.tax,ct.quantity,
			ct.quantity*it.price as itemCost,discount, CONCAT('".$path."', it.item_image) as itemImage FROM `adv_pos_cart_item` ct join mis_adv_pos_item it 
			on it.item_id=ct.item_id 
			 where ct.merchant_id='".$merchant_id."' and ct.user_id='".$sub_merchant_id."' and ct.status=0 order by ct.id desc");				

						$posItems = array();
			$package_data = $stmt->result_array();
			$package_data1 = $stmt1->result_array();
			
			
			$mem = array();
			$names = array();
			$quantity = array();
			$item_price = array();
			$tax = array();
			$itemCost = array();


						if (isset($package_data)) {
			foreach ($package_data as $each) {
 						$package['id'] = $each['id'];
						$package['tier_id'] = $each['tier_id'];
						$package['item_id'] = $each['item_id'];
                        $names[]= $each['name'];
						$package['title']  = $each['title'];
						
						if ($each['discount'] == "0" || $each['discount'] == null) {
						$item_price[] = (float) $each['new_price'];
						$package['item_price'] = (float) $each['price'];
						} else {
						$item_price[] = (float) $each['new_price'];
						$package['disconted_price'] = (float) $each['price'];
					    }
						$tax[] = $each['tax'];
                        $quantity[] = $each['quantity'];
						$itemCost[] = (float) round(($each['price'] + ($each['price'] * ($each['tax'] / 100))), 2);
						
						$package['taxAmount'] = (float) round(($each['price'] * ($each['tax'] / 100)), 2);
 				
				//$mem[] = $package;
		
 			}
		}

		if (isset($package_data1)) {
			foreach ($package_data1 as $each) {
 						$package['id'] = $each['id'];
						$package['tier_id'] = $each['tier_id'];
						$package['item_id'] = $each['item_id'];
                        $names[]= $each['name'];
						$package['title']  = $each['title'];
						
						if ($each['discount'] == "0" || $each['discount'] == null) {
						$item_price[] = (float) $each['new_price'];
						$package['item_price'] = (float) $each['price'];
						} else {
						$item_price[] = (float) $each['new_price'];
						$package['disconted_price'] = (float) $each['price'];
					    }
						$tax[] = $each['tax'];
                        $quantity[] = $each['quantity'];
						$itemCost[] = (float) round(($each['price'] + ($each['price'] * ($each['tax'] / 100))), 2);
						
						$package['taxAmount'] = (float) round(($each['price'] * ($each['tax'] / 100)), 2);
 				
				//$mem[] = $package;
		
 			}
		}
		
	
		//$posItems = $mem;
		//end

						$item_name = json_encode($names);
						$quantity = json_encode($quantity);
						$price = json_encode($item_price);
						$tax = json_encode($tax);
						$tax_id = json_encode($this->input->post('Tax'));
						$total_amount = json_encode($itemCost);
						$tax_per = json_encode($this->input->post('Tax_Per'));
						$item_Detail_1 = array(
							"p_id" => $id,
							"item_name" => ($item_name),
							"quantity" => ($quantity),
							"price" => ($price),
							"tax" => ($tax),
							"total_amount" => ($total_amount),
						);
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
						$this->admin_model->insert_data("order_item", $item_Detail_1);
						$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
						$data['item_detail'] = $item_Detail_1;  
						$data['msgData'] = $data;
						// echo "<pre>";print_r($data);die;
						//Send Mail Code
						
				 		$msg = $this->load->view('email/invoice', $data, true);
						$email = $email_id;
				// 		if (!empty($mobile_no)) {
				// 			$sms_reciever = $mobile_no;
				// 			//$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
				// 			$sms_message = trim(" Hello '" . $name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
				// 			$from = '+18325324983'; //trial account twilio number
				// 			// $to = '+'.$sms_reciever; //sms recipient number
				// 			$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
				// 			$to = '+1' . $mob;
				// 			$response = $this->twilio->sms($from, $to, $sms_message);
				// 		}
						$MailTo = $email;
						$MailSubject = 'Invoice from '.$getDashboardData_m[0]['business_dba_name'];
						if (!empty($email)) {
							$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
							$this->email->to($MailTo);
							$this->email->subject($MailSubject);
							$this->email->message($msg);
							$this->email->send();
						}

					if (!empty($mobile_no)) {

				
				 $sms_message = trim($getDashboardData_m[0]['business_dba_name'].' is Requesting Payment : '.$url);
                 
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mobile_no;
                 $response = $this->twilio->sms($from, $to, $sms_message);
                 	//print_r($response_1); die();
 
			      }
				
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Payment request sent','id' => $id];
						
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
    

		public function direct_invoice_request_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
    	    $app_type = $_POST['app_type'];
			$sub_merchant_id = $this->input->post('sub_merchant_id');
			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$merchant_name = $merchantdetails['0']['name'];
			$s_fee = $merchantdetails['0']['s_fee'];
			$t_fee = $merchantdetails['0']['t_fee']; 
			$fee_invoice = $merchantdetails['0']['invoice'];
			$fee_swap = $merchantdetails['0']['f_swap_Invoice'];
			$fee_email = $merchantdetails['0']['text_email'];
			$names = substr($merchant_name, 0, 3);
			
// 			$getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
// 			$getDashboardData = $getDashboard->result_array();
// 			$getDashboardNum = $getDashboard->num_rows();
// 			$data['getDashboardNum'] = $getDashboardNum;
// 			if ($getDashboardData == false) {
// 				$data['getDashboardData'] = '0';
// 				$inv = '1';
// 			} else {
// 				$data['getDashboardData'] = $getDashboardData;
// 				$inv1 = $getDashboardData[0]['TotalOrders'];
// 				$inv = $inv1 + 1;
// 			}
			
						$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
						$other_charges = $this->input->post('otherCharges') ? $this->input->post('otherCharges') : "";
                        $other_charges_title = $this->input->post('otherChargesName') ? $this->input->post('otherChargesName') : "N/A";
						$title = $this->input->post('title') ? $this->input->post('title') : "";
						$remark = $this->input->post('detail') ? $this->input->post('detail') : "";
						$name = $this->input->post('name') ? $this->input->post('name') : "";
						$email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
						$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
						$sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
						$total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
						$note = $this->input->post('note') ? $this->input->post('note') : "";
						$reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
						$file = $this->input->post('file') ? $this->input->post('file') : '0' . "";
						$myfile=$_FILES['file']['name'];
						if($myfile!="")
						{
							$new_name = date().time().$_FILES['file']['name'];
	                        $config['file_name'] = $new_name; 
							$config['upload_path']          = './uploads/attachment/';
							$config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
							$config['max_size']             = 1000;
							$config['max_width']            = 3024;
							$config['max_height']           = 3068;
							$this->load->library('upload', $config);
							if ($this->upload->do_upload('file'))
							{
								$data = array('upload_data' => $this->upload->data());
							   // $this->load->view('upload_success', $data);
							    $uploadedFileName=$data['upload_data']['file_name']; 
							}
							
						}
						else
						{
							$uploadedFileName="";
						}
						$attachment=$uploadedFileName;
						if (!empty($sub_merchant_id)) {
							$sub_merchant_id = $sub_merchant_id;
						} else {
							$sub_merchant_id = '0';
						}
						$fee = ($amount / 100) * $fee_invoice;
						$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
						$fee_email = ($fee_email != '') ? $fee_email : 0;
						$fee = $fee + $fee_swap + $fee_email;
						
						$recurring_type = 'false';
						$recurring_count = '0';
						$due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
						$recurring_payment = 'stop';
						// $invoice_no = 'INV'.strtoupper($names).'000'. $sub_merchant_id.rand(10,1000000).$inv;
						//$invoice_no = 'INV' . strtoupper($names) . $sub_merchant_id . rand(10, 1000000) . $inv;
						//$invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
						$invoice_no_1= 'INV' .  date("ymdhisu");
                        $invoice_no = str_replace("000000", "", $invoice_no_1);
						
						$today1_1 = date("ymdhisu");
                        $today1 = str_replace("000000", "", $today1_1);
						$url = base_url().'payment/PY' . $today1 . '/' . $merchant_id;
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
							'invoice_no' => $invoice_no,
							'other_charges' => $other_charges,
                            'otherChargesName' => $other_charges_title,
							'sub_total' => $sub_amount,
							'tax' => $total_tax,
							'fee' => $fee,
							's_fee' => $s_fee,
							'email_id' => $email_id,
							'mobile_no' => $mobile_no,
							'amount' => $amount,
							'title' => $title,
							'detail' => $remark,
							'attachment'=>$attachment,
							'note' => $note,
							'url' => $url,
							'payment_type' => 'straight',
							'recurring_type' => $recurring_type,
							'recurring_count' => $recurring_count,
							'recurring_count_paid' => '0',
							'recurring_count_remain' => $recurring_count,
							'due_date' => $due_date,
							'reference' => $reference,
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
							'payment_device' => 'app',
							'app_type' =>$app_type,
						);
						$id = $this->admin_model->insert_data("customer_payment_request", $data);
						// $id1 = $this->admin_model->insert_data("graph", $data);
						$item_name = json_encode($this->input->post('Item_Name'));
						$quantity = json_encode($this->input->post('Quantity'));
						$price = json_encode($this->input->post('Price'));
						$tax = json_encode($this->input->post('Tax_Amount'));
						$tax_id = json_encode($this->input->post('Tax'));
						$total_amount = json_encode($this->input->post('Total_Amount'));
						$tax_per = json_encode($this->input->post('Tax_Per'));
						$item_Detail_1 = array(
							"p_id" => $id,
							"item_name" => ($item_name),
							"quantity" => ($quantity),
							"price" => ($price),
							"tax" => ($tax),
							"total_amount" => ($total_amount),
						);
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
						$this->admin_model->insert_data("order_item", $item_Detail_1);
						$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
						$data['item_detail'] = $item_Detail_1;  
						$data['msgData'] = $data;
						// echo "<pre>";print_r($data);die;
						//Send Mail Code
						
				// 		$msg = $this->load->view('email/invoice', $data, true);
				// 		$email = $email_id;
				// 		if (!empty($mobile_no)) {
				// 			$sms_reciever = $mobile_no;
				// 			//$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
				// 			$sms_message = trim(" Hello '" . $name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
				// 			$from = '+18325324983'; //trial account twilio number
				// 			// $to = '+'.$sms_reciever; //sms recipient number
				// 			$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
				// 			$to = '+1' . $mob;
				// 			$response = $this->twilio->sms($from, $to, $sms_message);
				// 		}
				// 		$MailTo = $email;
				// 		$MailSubject = 'Invoice from '.$getDashboardData_m[0]['business_dba_name'];
				// 		if (!empty($email)) {
				// 			$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
				// 			$this->email->to($MailTo);
				// 			$this->email->subject($MailSubject);
				// 			$this->email->message($msg);
				// 			$this->email->send();
				// 		}
				
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Payment request sent','id' => $id];
						
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
  
  public function simple_invoice_request_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
    	    $app_type = $_POST['app_type'];
			$sub_merchant_id = $this->input->post('sub_merchant_id');
			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$merchant_name = $merchantdetails['0']['name'];
			$s_fee = $merchantdetails['0']['s_fee'];
			$t_fee = $merchantdetails['0']['t_fee']; 
			$fee_invoice = $merchantdetails['0']['invoice'];
			$fee_swap = $merchantdetails['0']['f_swap_Invoice'];
			$fee_email = $merchantdetails['0']['text_email'];
			$names = substr($merchant_name, 0, 3);
			
// 			$getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
// 			$getDashboardData = $getDashboard->result_array();
// 			$getDashboardNum = $getDashboard->num_rows();
// 			$data['getDashboardNum'] = $getDashboardNum;
// 			if ($getDashboardData == false) {
// 				$data['getDashboardData'] = '0';
// 				$inv = '1';
// 			} else {
// 				$data['getDashboardData'] = $getDashboardData;
// 				$inv1 = $getDashboardData[0]['TotalOrders'];
// 				$inv = $inv1 + 1;
// 			}
			
						$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
						$other_charges = $this->input->post('otherCharges') ? $this->input->post('otherCharges') : "";
                        $other_charges_title = $this->input->post('otherChargesName') ? $this->input->post('otherChargesName') : "N/A";
						$title = $this->input->post('title') ? $this->input->post('title') : "";
						$remark = $this->input->post('detail') ? $this->input->post('detail') : "";
						$name = $this->input->post('name') ? $this->input->post('name') : "";
						$email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
						$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
						$sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
						$total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
						$note = $this->input->post('note') ? $this->input->post('note') : "";
						$reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
						$file = $this->input->post('file') ? $this->input->post('file') : '0' . "";
						$myfile=$_FILES['file']['name'];
						if($myfile!="")
						{
							$new_name = date().time().$_FILES['file']['name'];
	                        $config['file_name'] = $new_name; 
							$config['upload_path']          = './uploads/attachment/';
							$config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
							$config['max_size']             = 1000;
							$config['max_width']            = 3024;
							$config['max_height']           = 3068;
							$this->load->library('upload', $config);
							if ($this->upload->do_upload('file'))
							{
								$data = array('upload_data' => $this->upload->data());
							   // $this->load->view('upload_success', $data);
							    $uploadedFileName=$data['upload_data']['file_name']; 
							}
							
						}
						else
						{
							$uploadedFileName="";
						}
						$attachment=$uploadedFileName;
						if (!empty($sub_merchant_id)) {
							$sub_merchant_id = $sub_merchant_id;
						} else {
							$sub_merchant_id = '0';
						}
						$fee = ($amount / 100) * $fee_invoice;
						$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
						$fee_email = ($fee_email != '') ? $fee_email : 0;
						$fee = $fee + $fee_swap + $fee_email;
						
						$recurring_type = 'false';
						$recurring_count = '0';
						$due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
						$recurring_payment = 'stop';
						
						//$invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
						$invoice_no_1= 'INV' .  date("ymdhisu");
                        $invoice_no = str_replace("000000", "", $invoice_no_1);
						
						$today1_1 = date("ymdhisu");
                        $today1 = str_replace("000000", "", $today1_1);
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
							'invoice_no' => $invoice_no,
							'other_charges' => $other_charges,
                            'otherChargesName' => $other_charges_title,
							'sub_total' => $sub_amount,
							'tax' => $total_tax,
							'fee' => $fee,
							's_fee' => $s_fee,
							'email_id' => $email_id,
							'mobile_no' => $mobile_no,
							'amount' => $amount,
							'title' => $title,
							'detail' => $remark,
							'attachment'=>$attachment,
							'note' => $note,
							'url' => $url,
							'invoice_type' => 'simple',
							'payment_type' => 'straight',
							'recurring_type' => $recurring_type,
							'recurring_count' => $recurring_count,
							'recurring_count_paid' => '0',
							'recurring_count_remain' => $recurring_count,
							'due_date' => $due_date,
							'reference' => $reference,
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
							'payment_device' => 'app',
							'app_type' =>$app_type,
							'c_type' =>'CNP'
						);
						$id = $this->admin_model->insert_data("customer_payment_request", $data);
						
	
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Payment request sent','id' => $id];
						
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
								
				
	public function recurring_invoice_request_post() {
			$data = array();
			$data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
			$sub_merchant_id = $this->input->post('sub_merchant_id');
			$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
			$merchant_name = $merchantdetails['0']['name'];
			$s_fee = $merchantdetails['0']['s_fee'];
			$t_fee = $merchantdetails['0']['t_fee']; 
			$fee_invoice = $merchantdetails['0']['invoice'];
            $fee_swap = $merchantdetails['0']['f_swap_Recurring'];
			$fee_email = $merchantdetails['0']['text_email'];
			$names = substr($merchant_name, 0, 3);
			
// 			$getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
// 			$getDashboardData = $getDashboard->result_array();
// 			$getDashboardNum = $getDashboard->num_rows();
// 			$data['getDashboardNum'] = $getDashboardNum;
// 			if ($getDashboardData == false) {
// 				$data['getDashboardData'] = '0';
// 				$inv = '1';
// 			} else {
// 				$data['getDashboardData'] = $getDashboardData;
// 				$inv1 = $getDashboardData[0]['TotalOrders'];
// 				$inv = $inv1 + 1;
// 			}
			            $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
			            $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
						$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
						$title = $this->input->post('title') ? $this->input->post('title') : "";
						$remark = $this->input->post('remark') ? $this->input->post('remark') : "";
						$name = $this->input->post('name') ? $this->input->post('name') : "";
						$email_id = $this->input->post('email') ? $this->input->post('email') : "";
						$mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
						$sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
						$total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
						$note = $this->input->post('note') ? $this->input->post('note') : "";
						$reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
						$file = $this->input->post('file') ? $this->input->post('file') : '0' . "";
						$myfile=$_FILES['file']['name'];
						if($myfile!="")
						{
							$new_name = date().time().$_FILES['file']['name'];
	                        $config['file_name'] = $new_name; 
							$config['upload_path']          = './uploads/attachment/';
							$config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
							$config['max_size']             = 1000;
							$config['max_width']            = 3024;
							$config['max_height']           = 3068;
							$this->load->library('upload', $config);
							if ($this->upload->do_upload('file'))
							{
								$data = array('upload_data' => $this->upload->data());
							   // $this->load->view('upload_success', $data);
							    $uploadedFileName=$data['upload_data']['file_name']; 
							}
							
						}
						else
						{
							$uploadedFileName="";
						}
						$attachment=$uploadedFileName;
						if (!empty($sub_merchant_id)) {
							$sub_merchant_id = $sub_merchant_id;
						} else {
							$sub_merchant_id = '0';
						}
						$fee = ($amount / 100) * $fee_invoice;
						$fee_swap = ($fee_swap != '') ? $fee_swap : 0;
						$fee_email = ($fee_email != '') ? $fee_email : 0;
						$fee = $fee + $fee_swap + $fee_email;
						$due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
						$recurring_payment = 'start';
						// $invoice_no = 'INV'.strtoupper($names).'000'. $sub_merchant_id.rand(10,1000000).$inv;
						//$invoice_no = 'INV' . strtoupper($names) . $sub_merchant_id . rand(10, 1000000) . $inv;
						//$invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
						$invoice_no_1= 'INV' .  date("ymdhisu");
                        $invoice_no = str_replace("000000", "", $invoice_no_1);
						
						$today1_1 = date("ymdhisu");
                        $today1 = str_replace("000000", "", $today1_1);
						$url = base_url().'payment/PY' . $today1 . '/' . $merchant_id;
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
							'invoice_no' => $invoice_no,
							'sub_total' => $sub_amount,
							'tax' => $total_tax,
							'fee' => $fee,
							's_fee' => $s_fee,
							'email_id' => $email_id,
							'mobile_no' => $mobile_no,
							'amount' => $amount,
							'title' => $title,
							'detail' => $remark,
							'attachment'=>$attachment,
							'note' => $note,
							'url' => $url,
							'payment_type' => 'recurring',
							'recurring_type' => $recurring_type,
							'recurring_count' => $recurring_count,
							'recurring_count_paid' => '0',
							'recurring_count_remain' => $recurring_count,
							'due_date' => $due_date,
							'reference' => $reference,
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
						);
						$id = $this->admin_model->insert_data("customer_payment_request", $data);
						// $id1 = $this->admin_model->insert_data("graph", $data);
						$item_name = json_encode($this->input->post('Item_Name'));
						$quantity = json_encode($this->input->post('Quantity'));
						$price = json_encode($this->input->post('Price'));
						$tax = json_encode($this->input->post('Tax_Amount'));
						$tax_id = json_encode($this->input->post('Tax'));
						$total_amount = json_encode($this->input->post('Total_Amount'));
						$tax_per = json_encode($this->input->post('Tax_Per'));
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
						$this->admin_model->insert_data("order_item", $item_Detail_1);
						$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
						$data['item_detail'] = $item_Detail_1;  
						$data['msgData'] = $data;
						// echo "<pre>";print_r($data);die;
						//Send Mail Code
						
				// 		$msg = $this->load->view('email/invoice', $data, true);
				// 		$email = $email_id;
				// 		if (!empty($mobile_no)) {
				// 			$sms_reciever = $mobile_no;
				// 			//$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
				// 			$sms_message = trim(" Hello '" . $name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
				// 			$from = '+18325324983'; //trial account twilio number
				// 			// $to = '+'.$sms_reciever; //sms recipient number
				// 			$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
				// 			$to = '+1' . $mob;
				// 			$response = $this->twilio->sms($from, $to, $sms_message);
				// 		}
				// 		$MailTo = $email;
				// 		$MailSubject = 'Invoice from '.$getDashboardData_m[0]['business_dba_name'];
				// 		if (!empty($email)) {
				// 			$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
				// 			$this->email->to($MailTo);
				// 			$this->email->subject($MailSubject);
				// 			$this->email->message($msg);
				// 			$this->email->send();
				// 		}
				
						$status = parent::HTTP_OK;
						if(!empty($id)){
						     $response = ['status' => $status, 'successMsg' => 'Payment request sent','id' => $id];
						
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
		
    public function delet_invoice_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $transection_id = $_POST['id'];
	$status = 'pending';

			$stmt = $this->db->query(" DELETE FROM customer_payment_request where id ='".$transection_id."' and status ='".$status."' ");

			if ($stmt) {
			
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Cart item deleted'];

			} else {

				$response = ['status' => '401', 'msg' => 'No Data'];
			}

    $this->response($response, $status);
}

public function refund_invoice_detail_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $p_id = $_POST['p_id'];
	$status = 'confirm';
	
    $merchant_id = $_POST['merchant_id'];
	
	        	$stmt1 = $this->db->query("SELECT logo,business_name,business_dba_name,date_c,business_number,payroc FROM merchant WHERE id ='".$merchant_id."' ");
                $getDetail_merchant = $stmt1->result_array();
                $logo = 'https://salequick.com/logo/'.$getDetail_merchant[0]['logo'];
                $business_name = $getDetail_merchant[0]['business_name'];
                $business_dba_name = $getDetail_merchant[0]['business_dba_name'];
                $business_number = $getDetail_merchant[0]['business_number'];
                //$date_c = $getDetail_merchant[0]['date_c'];
                $CNP_WP_Payroc = $getDetail_merchant[0]['payroc'];
                
             

                
	$stmt = $this->db->query("SELECT invoice_no,ip_a,transaction_id, card_type,card_no,reference,amount,c_type,date_c FROM customer_payment_request WHERE id ='".$p_id."' and status = '".$status."'");

      $getDetail = $stmt->result_array();
      $invoice_no = $getDetail[0]['invoice_no'];
      $ip_a = $getDetail[0]['ip_a'];
      $transaction_id = $getDetail[0]['transaction_id'];
      $card_type = $getDetail[0]['card_type'];
      $card_no = $getDetail[0]['card_no'];
      $reference = $getDetail[0]['reference'];
      $amount = $getDetail[0]['amount'];
      //$c_type = $getDetail[0]['c_type'] ? $getDetail[0]['c_type'] : "";
      $c_type = "web";
      $date_c = $getDetail[0]['date_c'] ? $getDetail[0]['date_c'] : "";
     

			if (!empty($invoice_no)) {


				if (empty($ip_a)) {
					$ip_a = '';
				} else {
					$ip_a = $ip_a;
				}

				if (empty($card_type)) {
					$card_type = '';
				} else {
					$card_type = $card_type;
				}

				if (empty($invoice_no)) {
					$invoice_no = '';
				} else {
					$invoice_no = $invoice_no;
				}

				if (empty($reference)) {
					$reference = '';
				} else {
					$reference = $reference;
				}

				if (empty($card_no)) {
					$card_no = '';
				} else {
					$card_no = $card_no;
				}

				if (empty($transaction_id)) {
					$transaction_id = '';
				} else {
					$transaction_id = $transaction_id;
				}

				$user = array(

					'invoice_no' => $invoice_no,
					'ip' => $ip_a,
					// 'sign' => 'https://salequick.com/logo/'.$sign,
					// 'transaction_guid' => $transaction_guid,
					// 'pos_entry_mode' => $pos_entry_mode,
					'transaction_id' => $transaction_id,
					// 'client_transaction_id' => $client_transaction_id,
					'card_type' => $card_type,
					'card_no' => $card_no,
					'reference_no' => $reference,
					'obtainAmount' => $amount,
					'c_type' => $c_type,
					'logo' => $logo,
					'business_name' => $business_name,
					'business_dba_name' => $business_dba_name,
					'business_number' => $business_number,
					'date_c' => $date_c,
					'CNP_WP_Payroc' => $CNP_WP_Payroc,

				);
				
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull','UserData' => $user];
			} else {

			    $response = ['status' => '401', 'errorMsg' => 'No Data'];
			}

    $this->response($response, $status);
}

public function refund_invoice_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
		
			$id = $_POST['p_id'];
			$invoice_no = $_POST['invoice_no'];
			$amount = $_POST['amount'];
			$transaction_id = $_POST['transaction_id'];

			$getMerchant = $this->db->query("SELECT payroc from merchant where id = ".$merchant_id." ");
            $getMerchantData = $getMerchant->result_array();
            $payroc = $getMerchantData[0]['payroc'];
             if($payroc==1){
// Start Payroc


				$security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
				
				$amount_new = number_format($_POST['amount'],2);
    			$b = str_replace(",","",$amount_new);
                $a = number_format($b,2);
                $amount = str_replace(",","",$a);
                
            
				$payment_id = $_POST['payment_id'];
				$TicketNumber = (rand(100000, 999999));
				$TicketNumber1 = (rand(100000000, 999999999));
				$TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
						// xml post structure
						 $query  = "";
		    // Login Information
		    $query .= "security_key=" . urlencode($security_key) . "&";
		    // Sales Information
		    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
		    $query .= "payment=creditcard"."&";
		    $query .= "transactionid=" . urlencode($transaction_id) . "&";
		     $query .= "type=refund";


		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		    curl_setopt($ch, CURLOPT_POST, 1);

		    if (!($data = curl_exec($ch))) {
		        return ERROR;
		    }
		    curl_close($ch);
		    unset($ch);
		  
			parse_str($data, $parsed);
			$test = json_encode($parsed);
			$arraya = json_decode($test, true);
			//$json = json_encode($xml);
			//$arraya = json_decode($json, TRUE);

			//print_r($arraya);  die();

			$trans_a_no = $arraya['transactionid'];
			$auth_code1 = $arraya['authcode'];
			$auth_code2 = $arraya['authCode'];
			if($auth_code1!='')
			{
			$auth_code = $auth_code1;
			}
			else 
			{
			$auth_code = $auth_code2;
			}
			

			
				$date_c = date("Y-m-d");
				$branch_info = array(
					'amount' => $amount,
					'transaction_id' => $trans_a_no,
					'auth_code' => $auth_code,
					'payment_id' => $payment_id,
					'invoice_no' => $invoice_no,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => $refundfor,
					'status' => 'confirm',
					'c_type' => 'CNP',
				);
				$branch_inf = array(
					'status' => 'Chargeback_Confirm',
				);
				
				if ($arraya['response'] == '1') {
					$id1 = $this->admin_model->insert_data("refund", $branch_info);
					$m = $this->admin_model->update_data('customer_payment_request', $branch_inf, array('id' => $id));
					
					$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];

			} else {
				
				$rerrorMsg = $arraya['responsetext'];
				$response = ['status' => '401', 'errorMsg' => $rerrorMsg];

			}             	


             }
             else
             {

// Start Wp
			//Data, connection, auth
			# $dataFromTheForm = $_POST['fieldName']; // request data from the form
			$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL


			$stmt = $this->db->query("SELECT account_id_cnp,acceptor_id_cnp,account_token_cnp,application_id_cnp,terminal_id FROM merchant WHERE id ='".$merchant_id."' ");

			  $getDetail = $stmt->result_array();

     		  $account_id = $getDetail[0]['account_id_cnp'];
		      $acceptor_id = $getDetail[0]['acceptor_id_cnp'];
		      $account_token = $getDetail[0]['account_token_cnp'];
		      $application_id = $getDetail[0]['application_id_cnp'];
		      $terminal_id = $getDetail[0]['terminal_id'];
		    
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
			$response1 = curl_exec($ch);
			$xml = simplexml_load_string($response1, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$arraya = json_decode($json, TRUE);
			//	print_r($arraya);
			curl_close($ch);
			$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
			//  $card_type = $arraya['Response']['Card']['CardLogo'];
			$card_no = $arraya['Response']['Card']['CardNumberMasked'];
			//  die();
			$date_c = date("Y-m-d");

			$status = 'Chargeback_Confirm';

			if ($arraya['Response']['ExpressResponseMessage'] == 'Approved') {

				//     $id='Refund Fail';
				//               redirect('payment_error/'.$id);
		

				$data = array(
                         'merchant_id' =>$merchant_id,
                         'transaction_id' =>$trans_a_no,
                         'invoice_no' =>$invoice_no, 
                         'amount' =>$amount,
                         'type' => 'straight', 
                         'card_no' =>$card_no, 
                         'status' =>'confirm',
                         'date_c' =>$date_c,
                         'c_type' =>'CNP',

						);
					$stmt3 = $this->admin_model->insert_data("refund", $data);

				$stmt2 =$this->db->query("UPDATE  customer_payment_request set status ='".$status."' where id ='".$id."' ");
				
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];

			} else {
				
				$rerrorMsg = $arraya['Response']['ExpressResponseMessage'];
				$response = ['status' => '401', 'errorMsg' => $rerrorMsg];

			}

// End Wp
         }
						
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



	
public function add_direct_invoice_request_mail_post()
{
	$data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
			$merchant_id = $_POST['merchant_id'];
			$payment_id = $_POST['payment_id'];
			$sid = $_POST['id'];
			$type = $_POST['type'];
			$merchant_id_e = 1;

			$stmt = $this->db->query("SELECT other_charges,otherChargesName,name,sub_total,invoice_no,amount,tax,fee,date_c,url FROM customer_payment_request WHERE id ='".$payment_id."' ");
			

			$getCustDetail = $stmt->result_array();
			$invoice_no = $getCustDetail[0]['invoice_no'];
			$other_charges = $getCustDetail[0]['other_charges'];
			$otherChargesName = $getCustDetail[0]['otherChargesName'];
			
			$amount = number_format($getCustDetail[0]['amount'], 2);
			$tax = $getCustDetail[0]['tax'];
			$sub_total = number_format($getCustDetail[0]['sub_total'], 2);
			$name1 = $getCustDetail[0]['name'];
			$fee = $getCustDetail[0]['fee'];
			$date_c = $getCustDetail[0]['date_c'];
			$url = $getCustDetail[0]['url'];
			$p_date = date('F j, Y', strtotime($date_c));
			$p_date1 = date('F d, Y', strtotime($date_c));
			$stmt1 = $this->db->query("SELECT logo,business_dba_name,name,email,business_number,address1,color FROM merchant WHERE id ='".$merchant_id."' ");
			$getPersonaDetail = $stmt1->result_array();
			$name = $getPersonaDetail[0]['name'];
			$logo = $getPersonaDetail[0]['logo'];
			$color = $getPersonaDetail[0]['color'];
			$email_id = $getPersonaDetail[0]['email'];
			$business_dba_name = $getPersonaDetail[0]['business_dba_name'];
			$mob_no = $getPersonaDetail[0]['business_number'];
			$address = $getPersonaDetail[0]['address1'];
			if ($type == 'email') {
				$stmt = $this->db->query("UPDATE  customer_payment_request set email_id ='".$sid."' where id = '".$payment_id."'");
				
				$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_e."' ");
				$getTemplate = $stmt5->result_array();
                $templete = $getTemplate[0]['templete'];
				$tamount1 = $amount - $tax;
				$tamount = number_format($tamount1, 2);
				$token = array(
					'USER_NAME' => $name,
					'PHONE' => $mob_no,
					'EMAIL' => $email_id,
					'LOGO' => $logo,
					'AMOUNT' => $amount,
					'COMPANY' => $business_dba_name,
					'TAX' => $tax,
					'URL' => $url,
					'TAMOUNT' => $sub_total,
					'INVOICE_NO' => $invoice_no,
					'PAYMENT_DATE' => $p_date,
				);
				$pattern = '[%s]';
				foreach ($token as $key => $val) {
					$varMap[sprintf($pattern, $key)] = $val;
				}
				$stmt55 = $this->db->query("SELECT  quantity, price, tax, tax_id, tax_per, total_amount,item_name FROM order_item WHERE p_id ='".$payment_id."' ");
				$getItem = $stmt55->result_array();
				
				
				$quantity_a = $getItem[0]['quantity'];
				$price_a = $getItem[0]['price'];
				$tax_a = $getItem[0]['tax'];
				$tax_id_a = $getItem[0]['tax_id'];
				$tax_per_a = $getItem[0]['tax_per'];
				$total_amount_a = $getItem[0]['total_amount'];
				$item_name_a = $getItem[0]['item_name'];
				$item_name = str_replace(array('\\', '/'), '', $item_name_a);
				$quantity = str_replace(array('\\', '/'), '', $quantity_a);
				$price = str_replace(array('\\', '/'), '', $price_a);
				$tax2 = str_replace(array('\\', '/'), '', $tax_a);
				$tax_id = str_replace(array('\\', '/'), '', $tax_id_a);
				$total_amount = str_replace(array('\\', '/'), '', $total_amount_a);
				$item_name1 = json_decode($item_name);
				$quantity1 = json_decode($quantity);
				$price1 = json_decode($price);
				$tax1 = json_decode($tax2);
				$tax_id1 = json_decode($tax_id);
				$total_amount1 = json_decode($total_amount);
				
				$mail_body = '<!DOCTYPE html>
						<html>
						    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						        
						        <title>SalesQuick</title>
						        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
						         <style>
						        body {
						            font-family: Open Sans, sans-serif !important;
						            width: 100% !important;
						            height: 100% !important;
						        }
						        td,
						        th {
						            vertical-align: top !important;
						            text-align: left !important;
						        }
						        p {
						            font-size: 13px !important;
						            color: #878787 !important;
						            line-height: 28px !important;
						            margin: 4px 0px !important;
						        }
						        a {
						            text-decoration: none !important;
						        }
						        .main-box {
						            padding: 80px 0px 10px 0px !important;
						        }
						        .invoice-wrap {
						            margin-left: 14% !important;
						            width: 72% !important;
						            max-width: 72% !important;
						        }
						        .top-div {
						            padding: 20px 40px !important;
						        }
						        .float-left {
						            float: left !important;
						            width:auto !important;
						            text-align: left !important;
						        }
						        .float-right {
						            float: right !important;
						            width:auto !important;
						            text-align: right !important;
						        }
						        .bottom-div {
						            padding: 20px 40px !important;
						        }
						        .footer-wraper>div::after,
						        .footer-wraper>div::before,
						        .footer-wraper::after,
						        .footer-wraper:before {
						            display: table !important;
						            clear: both !important;
						            content: "" !important;
						        }
						        .footer_cards {
						            padding-right: 15px !important;
						        }
						        .footer-wraper>div>div {
						            margin-bottom: 11px !important;
						        }
						        .footer_address span:first-child {
						            font-weight: 600 !important;
						        }
						        @media screen and (max-width: 768px) {
						            .footer_address>span:first {
						                display: inline-block !important;
						                width: 100% !important;
						            }
						        }
						        @media only screen and (max-width:820px) {
						            .footer-wraper>div>div {
						                float: none !important;
						            }
						            .footer_address,
						            .footer_cards {
						                padding-right: 0px !important;
						                padding-left: 0px !important;
						            }
						            .footer_t_c {
						                padding-bottom: 7px !important;
						            }
						            .footer-wraper>div {
						                margin: 20px auto 0 !important;
						            }
						        }
						        @media only screen and (min-width:769px) and (max-width:900px) {
						            .invoice-wrap {
						                margin-left: 10% !important;
						                width: 80% !important;
						                max-width: 80% !important;
						            }
						            .main-box {
						                padding: 50px 0px !important;
						            }
						        }
						        @media only screen and (min-width:481px) and (max-width:768px) {
						            .invoice-wrap {
						                margin-left: 6% !important;
						                width: 88% !important;
						                max-width: 88% !important;
						            }
						            .main-box {
						                padding: 30px 0px !important;
						            }
						            .bottom-div {
						                padding: 20px 20px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						        @media only screen and (max-width:400px) {
						            .twenty-div {
						                word-wrap: break-word !important;
						            }
						        }
						        @media only screen and (max-width:375px) {
						            .twenty-div {
						                word-wrap: anywhere !important;
						            }
						        }
						        @media only screen and (max-width:480px) {
						            .fourty-div {
						                    width: 100% !important;
						                    float: right !important;
						                }
						                .sixty-div {
						                    width: 100% !important;
						                    text-align: center !important;
						                }
						            .float-right {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .float-left {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .invoice-wrap {
						                margin-left: 5% !important;
						                width: 90% !important;
						                max-width: 90% !important;
						            }
						            .bottom-div {
						                padding: 20px 10px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						         .sixty-div {
						                width: 60% !important;
						                float: left !important;
						                display: inline-block !important;
						            }
						            .fourty-div {
						                width: 40% !important;
						                float: right !important;
						                display: inline-block !important;
						            }
						    </style>
						    </head>
						   <body style="margin:0 auto;padding: 0;font-family: Open Sans, sans-serif;width: 100%;height: 100%;">
						    <div class="main-box" style="background-image: linear-gradient(#' . $color . ',#' . $color . ');padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;">
						        <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">
						            <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">
						                <div class="float-left" style="width:100%;display:inline-block;text-align:center;">
						                        <p><img src="https://salequick.com/logo/' . $logo . '" width="200px"></p>
						                            <h4 style="margin-bottom: 0px;color:#000; ">' . $business_dba_name . ' </h4>
						                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
						                            <p style="color: #878787; margin-top: 0px;">Telephone:' . $mob_no . '</p>
						                    </div>
						                    <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
						                        <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Invoice</h3>
						                        <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
						                        <p style="line-height: 20px;margin-top: 10px">
						                            <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						                            <span style="display: block;color: #878787;">' . $invoice_no . '</span></p>
						                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
						                            <span style="display: block;color: #878787;">' . $p_date1 . '</span></p>
						                    </div>
						                </div>
						                 <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">
						                   <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
						                        <tr>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Item name</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Qty</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Price</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Tax</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Amount</th>
						                        </tr>
						 <tr>';
				$i = 0;
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$i] > 0 && ucfirst($item_name1[$i]) != 'Labor') {
						$price_bb = number_format($price1[$i], 2);
						$tax_aa = $total_amount1[$i] - ($price1[$i] * $quantity1[$i]);
						$tax_aaa = number_format($tax_aa, 2);
						$total_aaa = number_format($total_amount1[$i], 2);
						$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               ' . $item_name1[$i] . '
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $quantity1[$i] . '
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $' . $price_bb . '
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $tax_aaa . '';
					
						$mail_body .= '</td>
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $total_aaa . '
                                            </td>
                                        </tr>';
					}
					$i++;
				}
				$j = 0;
				$data = array();
				$data1 = array();
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$j] > 0 && ucfirst($item_name1[$j]) == 'Labor') {
						$data[] = $price1[$j];
						$data1[] = $quantity1[$j];
					}
					$j++;}
				$Array1 = $data;
				$Array2 = $data1;
				// Build the result here
				$Array3 = [];
				// There is no validation, the code assumes that $Array2 contains
				// the same number of items as $Array1 or more
				foreach ($Array1 as $index => $key) {
					// If the key $key was not encountered yet then add it to the result
					if (!array_key_exists($key, $Array3)) {
						$Array3[$key] = 0;
					}
					// Add the value associate with $key to the sum in the results array
					$Array3[$key] += $Array2[$index];
				}
				foreach ($Array3 as $index => $person) {
					$laboramount = number_format($index * $person, 2);
					$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               Labor
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $person . '
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $' . $index . '
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$0.00';
					
					$mail_body .= '</td>
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $laboramount . '
                                            </td>
                                        </tr>';
				}
      if($other_charges > 0){
				$mail_body .= '  
				
				<tr>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">'.$otherChargesName.'</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="color: #0077e2;border:0px;">$' . $other_charges . '</p>
                            </td>
                        </tr>';
      }
                    
					$mail_body .= ' <tr>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="color: #0077e2;border:0px;">$' . $amount . '</p>
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
                        <a href="' . $url . '" class="custom-btn" style="background-color: #0077e2;border-radius: 4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration: none;float: right;color: #fff;-webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 0;">CONTINUE TO PAYMENT</a>
                    </div>
                </div>
            </div>
                <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">
                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">
                     <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">
                        <span style="display: block;font-weight:600;color:#000 ">' . $business_dba_name . '</span>
                        <span style="display: inline-block;color:#666">' . $address . '</span>
                    </div>
                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">
                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                    </div>
                    <div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  ></a>
                    </div>
                </div>
            </div>
        </div>
			    </body>
			</html>';
				$MailSubject = 'Salequick Invoice';
				
				set_time_limit(3000);
				// $mj = new Mailjet\Client('bd44f3f110259eb60f880abdc2de47e3', '571258666c3347fbf47fbf12850f00e7',
				// 	true, ['version' => 'v3.1']);
				// $body = [
				// 	'Messages' => [
				// 		[
				// 			'From' => [
				// 				'Email' => "info@salequick.com",
				// 				'Name' => $business_dba_name,
				// 			],
				// 			'To' => [
				// 				[
				// 					'Email' => $sid,
				// 					'Name' => "",
				// 				],
				// 			],
				// 			'Subject' => "Salequick Invoice",
				// 			'TextPart' => "",
				// 			'HTMLPart' => $mail_body,
				// 		],
				// 	],
				// ];
				// $messagee = $mj->post(Resources::$Email, ['body' => $body]);
				//$messagee->success() && var_dump($messagee->getData());


				       $email = $sid;
					   $MailSubject = 'Salequick Invoice' . $business_dba_name;
					  
					
					   if (!empty($email)) {
						   $this->email->from('info@salequick.com', $business_dba_name);
						   $this->email->to($email);
						   $this->email->subject($MailSubject);
						   $this->email->message($mail_body);
						   $this->email->send();
					   }


				$message = '1';
			} else if ($type == 'sms') {
				$stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."' ");
				
				$mob = str_replace(array('(', ')', '-', ' '), '', $sid);
				$mobile = '+1' . $mob;
				//Your Account Sid and Auth Token from twilio.com/console

				// $sid = "AC9f4bf218c2edc01652d321f3a006d2ff";
				// $token = "320da85d6fd15c96ab28b272e14cda93";
				// $twilio = new Client($sid, $token);
				// $message_sms = $twilio->messages
				// 	->create($mobile,
				// 		array(
				// 			'body' => " Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  ('" . $amount . "') $url ",
				// 			'from' => "+18325324983",
				// 		)
				// 	);

                
				 //$sms_message = trim(" Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  ('" . $amount . "') $url "); 
				 $sms_message = trim(" " . $business_dba_name . " is Requesting  Payment .$url ");
				
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);

// if($merchant_id==413)
// {
// 	print_r($response_1);
// }
				$message = '1';
			}
			if ($message) {
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}
		 }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



public function resend_invoice_request_mail_post()
{
	$data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
			$merchant_id = $_POST['merchant_id'];
			$payment_id = $_POST['payment_id'];
			//$sid = $_POST['id'];
			//$type = $_POST['type'];
			$merchant_id_e = 1;

			$stmt = $this->db->query("SELECT other_charges,otherChargesName,name,sub_total,invoice_no,amount,tax,fee,date_c,url,invoice_type,email_id, mobile_no FROM customer_payment_request WHERE id ='".$payment_id."' ");
			

			$getCustDetail = $stmt->result_array();
			$invoice_no = $getCustDetail[0]['invoice_no'];
			$other_charges = $getCustDetail[0]['other_charges'];
			$otherChargesName = $getCustDetail[0]['otherChargesName'];
			if($otherChargesName=='')
			{
			    $otherChargesName ='Other Charges';
			}
			else
			{
			  $otherChargesName = $otherChargesName;  
			}

			$invoice_type = $getCustDetail[0]['invoice_type'];
			$email_id1 = $getCustDetail[0]['email_id'];
			$mobile_no = $getCustDetail[0]['mobile_no'];
			
			$amount = number_format($getCustDetail[0]['amount'], 2);
			$tax = $getCustDetail[0]['tax'];
			$sub_total = number_format($getCustDetail[0]['sub_total'], 2);
			$name1 = $getCustDetail[0]['name'];
			$fee = $getCustDetail[0]['fee'];
			$date_c = $getCustDetail[0]['date_c'];
			$url = $getCustDetail[0]['url'];
			$p_date = date('F j, Y', strtotime($date_c));
			$p_date1 = date('F d, Y', strtotime($date_c));
			$stmt1 = $this->db->query("SELECT logo,business_dba_name,name,email,business_number,address1,color FROM merchant WHERE id ='".$merchant_id."' ");
			$getPersonaDetail = $stmt1->result_array();
			$name = $getPersonaDetail[0]['name'];
			$logo = $getPersonaDetail[0]['logo'];
			$color = $getPersonaDetail[0]['color'];
			$email_id = $getPersonaDetail[0]['email'];
			$business_dba_name = $getPersonaDetail[0]['business_dba_name'];
			$mob_no = $getPersonaDetail[0]['business_number'];
			$address = $getPersonaDetail[0]['address1'];

	if($invoice_type=='custom'){
			if (!empty($email_id1)) {
				
				
				$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_e."' ");
				$getTemplate = $stmt5->result_array();
                $templete = $getTemplate[0]['templete'];
				$tamount1 = $amount - $tax;
				$tamount = number_format($tamount1, 2);
				$token = array(
					'USER_NAME' => $name,
					'PHONE' => $mob_no,
					'EMAIL' => $email_id,
					'LOGO' => $logo,
					'AMOUNT' => $amount,
					'COMPANY' => $business_dba_name,
					'TAX' => $tax,
					'URL' => $url,
					'TAMOUNT' => $sub_total,
					'INVOICE_NO' => $invoice_no,
					'PAYMENT_DATE' => $p_date,
				);
				$pattern = '[%s]';
				foreach ($token as $key => $val) {
					$varMap[sprintf($pattern, $key)] = $val;
				}
				$stmt55 = $this->db->query("SELECT  quantity, price, tax, tax_id, tax_per, total_amount,item_name FROM order_item WHERE p_id ='".$payment_id."' ");
				$getItem = $stmt55->result_array();
				
				
				$quantity_a = $getItem[0]['quantity'];
				$price_a = $getItem[0]['price'];
				$tax_a = $getItem[0]['tax'];
				$tax_id_a = $getItem[0]['tax_id'];
				$tax_per_a = $getItem[0]['tax_per'];
				$total_amount_a = $getItem[0]['total_amount'];
				$item_name_a = $getItem[0]['item_name'];
				$item_name = str_replace(array('\\', '/'), '', $item_name_a);
				$quantity = str_replace(array('\\', '/'), '', $quantity_a);
				$price = str_replace(array('\\', '/'), '', $price_a);
				$tax2 = str_replace(array('\\', '/'), '', $tax_a);
				$tax_id = str_replace(array('\\', '/'), '', $tax_id_a);
				$total_amount = str_replace(array('\\', '/'), '', $total_amount_a);
				$item_name1 = json_decode($item_name);
				$quantity1 = json_decode($quantity);
				$price1 = json_decode($price);
				$tax1 = json_decode($tax2);
				$tax_id1 = json_decode($tax_id);
				$total_amount1 = json_decode($total_amount);
				
				$mail_body = '<!DOCTYPE html>
						<html>
						    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						        
						        <title>SalesQuick</title>
						        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
						         <style>
						        body {
						            font-family: Open Sans, sans-serif !important;
						            width: 100% !important;
						            height: 100% !important;
						        }
						        td,
						        th {
						            vertical-align: top !important;
						            text-align: left !important;
						        }
						        p {
						            font-size: 13px !important;
						            color: #878787 !important;
						            line-height: 28px !important;
						            margin: 4px 0px !important;
						        }
						        a {
						            text-decoration: none !important;
						        }
						        .main-box {
						            padding: 80px 0px 10px 0px !important;
						        }
						        .invoice-wrap {
						            margin-left: 14% !important;
						            width: 72% !important;
						            max-width: 72% !important;
						        }
						        .top-div {
						            padding: 20px 40px !important;
						        }
						        .float-left {
						            float: left !important;
						            width:auto !important;
						            text-align: left !important;
						        }
						        .float-right {
						            float: right !important;
						            width:auto !important;
						            text-align: right !important;
						        }
						        .bottom-div {
						            padding: 20px 40px !important;
						        }
						        .footer-wraper>div::after,
						        .footer-wraper>div::before,
						        .footer-wraper::after,
						        .footer-wraper:before {
						            display: table !important;
						            clear: both !important;
						            content: "" !important;
						        }
						        .footer_cards {
						            padding-right: 15px !important;
						        }
						        .footer-wraper>div>div {
						            margin-bottom: 11px !important;
						        }
						        .footer_address span:first-child {
						            font-weight: 600 !important;
						        }
						        @media screen and (max-width: 768px) {
						            .footer_address>span:first {
						                display: inline-block !important;
						                width: 100% !important;
						            }
						        }
						        @media only screen and (max-width:820px) {
						            .footer-wraper>div>div {
						                float: none !important;
						            }
						            .footer_address,
						            .footer_cards {
						                padding-right: 0px !important;
						                padding-left: 0px !important;
						            }
						            .footer_t_c {
						                padding-bottom: 7px !important;
						            }
						            .footer-wraper>div {
						                margin: 20px auto 0 !important;
						            }
						        }
						        @media only screen and (min-width:769px) and (max-width:900px) {
						            .invoice-wrap {
						                margin-left: 10% !important;
						                width: 80% !important;
						                max-width: 80% !important;
						            }
						            .main-box {
						                padding: 50px 0px !important;
						            }
						        }
						        @media only screen and (min-width:481px) and (max-width:768px) {
						            .invoice-wrap {
						                margin-left: 6% !important;
						                width: 88% !important;
						                max-width: 88% !important;
						            }
						            .main-box {
						                padding: 30px 0px !important;
						            }
						            .bottom-div {
						                padding: 20px 20px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						        @media only screen and (max-width:400px) {
						            .twenty-div {
						                word-wrap: break-word !important;
						            }
						        }
						        @media only screen and (max-width:375px) {
						            .twenty-div {
						                word-wrap: anywhere !important;
						            }
						        }
						        @media only screen and (max-width:480px) {
						            .fourty-div {
						                    width: 100% !important;
						                    float: right !important;
						                }
						                .sixty-div {
						                    width: 100% !important;
						                    text-align: center !important;
						                }
						            .float-right {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .float-left {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .invoice-wrap {
						                margin-left: 5% !important;
						                width: 90% !important;
						                max-width: 90% !important;
						            }
						            .bottom-div {
						                padding: 20px 10px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						         .sixty-div {
						                width: 60% !important;
						                float: left !important;
						                display: inline-block !important;
						            }
						            .fourty-div {
						                width: 40% !important;
						                float: right !important;
						                display: inline-block !important;
						            }
						    </style>
						    </head>
						   <body style="margin:0 auto;padding: 0;font-family: Open Sans, sans-serif;width: 100%;height: 100%;">
						    <div class="main-box" style="background-image: linear-gradient(#' . $color . ',#' . $color . ');padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;">
						        <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">
						            <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">
						                <div class="float-left" style="width:100%;display:inline-block;text-align:center;">
						                        <p><img src="https://salequick.com/logo/' . $logo . '" width="200px"></p>
						                            <h4 style="margin-bottom: 0px;color:#000; ">' . $business_dba_name . ' </h4>
						                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
						                            <p style="color: #878787; margin-top: 0px;">Telephone:' . $mob_no . '</p>
						                    </div>
						                    <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
						                        <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Invoice</h3>
						                        <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
						                        <p style="line-height: 20px;margin-top: 10px">
						                            <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						                            <span style="display: block;color: #878787;">' . $invoice_no . '</span></p>
						                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
						                            <span style="display: block;color: #878787;">' . $p_date1 . '</span></p>
						                    </div>
						                </div>
						                 <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">
						                   <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
						                        <tr>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Item name</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Qty</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Price</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Tax</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Amount</th>
						                        </tr>
						 <tr>';
				$i = 0;
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$i] > 0 && ucfirst($item_name1[$i]) != 'Labor') {
						$price_bb = number_format($price1[$i], 2);
						$tax_aa = $total_amount1[$i] - ($price1[$i] * $quantity1[$i]);
						$tax_aaa = number_format($tax_aa, 2);
						$total_aaa = number_format($total_amount1[$i], 2);
						$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               ' . $item_name1[$i] . '
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $quantity1[$i] . '
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $' . $price_bb . '
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $tax_aaa . '';
					
						$mail_body .= '</td>
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $total_aaa . '
                                            </td>
                                        </tr>';
					}
					$i++;
				}
				$j = 0;
				$data = array();
				$data1 = array();
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$j] > 0 && ucfirst($item_name1[$j]) == 'Labor') {
						$data[] = $price1[$j];
						$data1[] = $quantity1[$j];
					}
					$j++;}
				$Array1 = $data;
				$Array2 = $data1;
				// Build the result here
				$Array3 = [];
				// There is no validation, the code assumes that $Array2 contains
				// the same number of items as $Array1 or more
				foreach ($Array1 as $index => $key) {
					// If the key $key was not encountered yet then add it to the result
					if (!array_key_exists($key, $Array3)) {
						$Array3[$key] = 0;
					}
					// Add the value associate with $key to the sum in the results array
					$Array3[$key] += $Array2[$index];
				}
				foreach ($Array3 as $index => $person) {
					$laboramount = number_format($index * $person, 2);
					$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               Labor
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $person . '
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $' . $index . '
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$0.00';
					
					$mail_body .= '</td>
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $laboramount . '
                                            </td>
                                        </tr>';
				}
      if($other_charges > 0){
				$mail_body .= '  
				
				<tr>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">'.$otherChargesName.'</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="color: #0077e2;border:0px;">$' . $other_charges . '</p>
                            </td>
                        </tr>';
      }
                    
					$mail_body .= ' <tr>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="color: #0077e2;border:0px;">$' . $amount . '</p>
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
                        <a href="' . $url . '" class="custom-btn" style="background-color: #0077e2;border-radius: 4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration: none;float: right;color: #fff;-webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 0;">CONTINUE TO PAYMENT</a>
                    </div>
                </div>
            </div>
                <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">
                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">
                     <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">
                        <span style="display: block;font-weight:600;color:#000 ">' . $business_dba_name . '</span>
                        <span style="display: inline-block;color:#666">' . $address . '</span>
                    </div>
                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">
                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                    </div>
                    <div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  ></a>
                    </div>
                </div>
            </div>
        </div>
			    </body>
			</html>';
				$MailSubject = 'Salequick Invoice';
				
				set_time_limit(3000);
			

				       $email = $email_id1;
					   $MailSubject = 'Salequick Invoice' . $business_dba_name;
					  
					
					   if (!empty($email)) {
						   $this->email->from('info@salequick.com', $business_dba_name);
						   $this->email->to($email);
						   $this->email->subject($MailSubject);
						   $this->email->message($mail_body);
						   $this->email->send();
					   }


				$message = '1';
			} else if (!empty($mobile_no)) {
				
				
				$mob = str_replace(array('(', ')', '-', ' '), '', $mobile_no);
				$mobile = '+1' . $mob;
				
				// $sms_message = trim(" Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  ('" . $amount . "') $url "); 

			$sms_message = trim(" " . $business_dba_name . " is requesting  payment. ".$url." ");

				
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
                 

				$message = '1';
			}
			if ($message) {
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}
		 }

	 elseif($invoice_type=='simple')
		{
		

			$stmt = $this->db->query("SELECT other_charges,otherChargesName,name,sub_total,invoice_no,amount,tax,fee,date_c,url,email_id,mobile_no,due_date,detail FROM customer_payment_request WHERE id ='".$payment_id."'");

			$getDetail = $stmt->result_array();
			$invoice_no = $getDetail[0]['invoice_no'];
			
			$other_charges = $getDetail[0]['other_charges'];
			$otherChargesName = $getDetail[0]['otherChargesName'];
			if($otherChargesName=='')
			{
			    $otherChargesName ='Other Charges';
			}
			else
			{
			  $otherChargesName = $otherChargesName;  
			}
			$amount = number_format($getDetail[0]['amount'], 2);
			$sub_total = number_format($getDetail[0]['sub_total'], 2);
			$tax = $getDetail[0]['tax'];
			$name1 = $getDetail[0]['name'];
			$detail = $getDetail[0]['detail'];
			$fee = $getDetail[0]['fee'];
			$date_c = $getDetail[0]['date_c'];
			$url = $getDetail[0]['url'];
			$email_id1 = $getDetail[0]['email_id'];
			$mobile_no = $getDetail[0]['mobile_no'];
			$due_date = $getDetail[0]['due_date'];

			$p_date = date('F j, Y', strtotime($date_c));
			$p_date1 = date('F d, Y', strtotime($date_c));

			$stmt1 =$this->db->query("SELECT logo,business_dba_name,name,email,business_number,address1,color FROM merchant WHERE id ='".$merchant_id."' ");
			
		
			$getCustDetail = $stmt1->result_array();
			$name = $getCustDetail[0]['name'];
			$logo = $getCustDetail[0]['logo'];
			$color = $getCustDetail[0]['color'];
			$email_id = $getCustDetail[0]['email'];
			$business_dba_name = $getCustDetail[0]['business_dba_name'];
			$mob_no = $getCustDetail[0]['business_number'];
			$address = $getCustDetail[0]['address1'];


				if (!empty($email_id1)) {

				

				$mail_body = '<!DOCTYPE html>
						<html>
						    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						        
						        <title>SalesQuick</title>
						        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
						         <style>
						        body {
						            font-family: Open Sans, sans-serif !important;
						            width: 100% !important;
						            height: 100% !important;
						        }

						        td,
						        th {
						            vertical-align: top !important;
						            text-align: left !important;
						        }

						        p {
						            font-size: 13px !important;
						            color: #878787 !important;
						            line-height: 28px !important;
						            margin: 4px 0px !important;
						        }

						        a {
						            text-decoration: none !important;
						        }

						        .main-box {
						            padding: 80px 0px 10px 0px !important;
						        }

						        .invoice-wrap {
						            margin-left: 14% !important;
						            width: 72% !important;
						            max-width: 72% !important;
						        }

						        .top-div {
						            padding: 20px 40px !important;
						        }

						        .float-left {
						            float: left !important;
						            width:auto !important;
						            text-align: left !important;
						        }

						        .float-right {
						            float: right !important;
						            width:auto !important;
						            text-align: right !important;
						        }

						        .bottom-div {
						            padding: 20px 40px !important;
						        }

						        .footer-wraper>div::after,
						        .footer-wraper>div::before,
						        .footer-wraper::after,
						        .footer-wraper:before {
						            display: table !important;
						            clear: both !important;
						            content: "" !important;
						        }

						        .footer_cards {
						            padding-right: 15px !important;
						        }

						        .footer-wraper>div>div {
						            margin-bottom: 11px !important;
						        }

						        .footer_address span:first-child {
						            font-weight: 600 !important;
						        }

						        @media screen and (max-width: 768px) {
						            .footer_address>span:first {
						                display: inline-block !important;
						                width: 100% !important;
						            }
						        }

						        @media only screen and (max-width:820px) {
						            .footer-wraper>div>div {
						                float: none !important;
						            }
						            .footer_address,
						            .footer_cards {
						                padding-right: 0px !important;
						                padding-left: 0px !important;
						            }
						            .footer_t_c {
						                padding-bottom: 7px !important;
						            }
						            .footer-wraper>div {
						                margin: 20px auto 0 !important;
						            }
						        }

						        @media only screen and (min-width:769px) and (max-width:900px) {
						            .invoice-wrap {
						                margin-left: 10% !important;
						                width: 80% !important;
						                max-width: 80% !important;
						            }
						            .main-box {
						                padding: 50px 0px !important;
						            }
						        }

						        @media only screen and (min-width:481px) and (max-width:768px) {
						            .invoice-wrap {
						                margin-left: 6% !important;
						                width: 88% !important;
						                max-width: 88% !important;
						            }
						            .main-box {
						                padding: 30px 0px !important;
						            }
						            .bottom-div {
						                padding: 20px 20px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }

						        @media only screen and (max-width:400px) {
						            .twenty-div {
						                word-wrap: break-word !important;
						            }
						        }

						        @media only screen and (max-width:375px) {
						            .twenty-div {
						                word-wrap: anywhere !important;
						            }
						        }

						        @media only screen and (max-width:480px) {
						            .fourty-div {

						                    width: 100% !important;

						                    float: right !important;

						                }

						                .sixty-div {

						                    width: 100% !important;

						                    text-align: center !important;

						                }
						            .float-right {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .float-left {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .invoice-wrap {
						                margin-left: 5% !important;
						                width: 90% !important;
						                max-width: 90% !important;
						            }
						            .bottom-div {
						                padding: 20px 10px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						         .sixty-div {

						                width: 60% !important;

						                float: left !important;

						                display: inline-block !important;

						            }

						            .fourty-div {

						                width: 40% !important;

						                float: right !important;

						                display: inline-block !important;

						            }
						    </style>
						    </head>
						   <body style="margin:0 auto;padding: 0;font-family: Open Sans, sans-serif;width: 100%;height: 100%;">

						    <div class="main-box" style="background-image: linear-gradient(#' . $color . ',#' . $color . ');padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;">

						        <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

						            <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">

						                <div class="float-left" style="width:100%;display:inline-block;text-align:center;">

						                        <p><img src="https://salequick.com/logo/' . $logo . '" width="200px"></p>
						                            <h4 style="margin-bottom: 0px;color:#000; ">' . $business_dba_name . ' </h4>
						                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
						                            <p style="color: #878787; margin-top: 0px;">Telephone:' . $mob_no . '</p>
						                    </div>
						                    <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
						                        <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Invoice</h3>
						                        <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
						                        <p style="line-height: 20px;margin-top: 10px">
						                            <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						                            <span style="display: block;color: #878787;">' . $invoice_no . '</span></p>
						                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
						                            <span style="display: block;color: #878787;">' . $p_date1 . '</span></p>
						                    </div>
						                </div>
						                 <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">

						                   <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
						                        <tr>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"> Name</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Phone</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Due date</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"></th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Amount</th>

						                        </tr>


						 <tr>';

			

						$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               ' . $name1 . '

                                            </td>
                                            
                                           
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $mobile_no . '

                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">' . $due_date . '</td>
                                             <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;"></td>
                                            
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $amount . '
                                            </td>
                                           
                                            
                                        </tr>'
                                        
                                        
                                        ;
                                        
                                        
                                        if($other_charges > 0){
				$mail_body .= '  
				
				<tr>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">'.$otherChargesName.'</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="color: #0077e2;border:0px;">$' . $other_charges . '</p>
                            </td>
                        </tr>';
      }
					

				$mail_body .= '  <tr>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="color: #0077e2;border:0px;">$' . $amount . '</p>
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">

                        <a href="' . $url . '" class="custom-btn" style="background-color: #0077e2;border-radius: 4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration: none;float: right;color: #fff;-webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 0;">CONTINUE TO PAYMENT</a>

                    </div>
                </div>
            </div>
                <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">

                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">

                     <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">

                        <span style="display: block;font-weight:600;color:#000 ">' . $business_dba_name . '</span>
                        <span style="display: inline-block;color:#666">' . $address . '</span>
                    </div>
                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">

                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                    </div>
                    <div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">

                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  ></a>
                    </div>
                </div>
            </div>
        </div>
			    </body>
			</html>';
				
				set_time_limit(3000);


			    $email = $email_id1;
			   $MailSubject = 'Salequick Simple Invoice' . $business_dba_name;
			  
			
			   if (!empty($email)) {
				   $this->email->from('info@salequick.com', $business_dba_name);
				   $this->email->to($email);
				   $this->email->subject($MailSubject);
				   $this->email->message($mail_body);
				   $this->email->send();
			   }
				//$messagee->success() && var_dump($messagee->getData());
				$message = '1';

			} else if (!empty($mobile_no)) {

				
				$mob = str_replace(array('(', ')', '-', ' '), '', $mobile_no);

				
				// $sms_message = trim(" Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  ('" . $amount . "') $url "); 

			 $sms_message = trim("" . $business_dba_name. " is requesting  payment .  ".$url." ");

				
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
                 	
				$message = '1';

			}

			if ($message) {

                $status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];

			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}
			
		    
		}
	}
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function add_direct_invoice_request_r_mail_post()
{
	$data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
			$merchant_id = $_POST['merchant_id'];
			$payment_id = $_POST['payment_id'];
			$sid = $_POST['id'];
			$type = $_POST['type'];
			$merchant_id_e = 1;

			$stmt = $this->db->query("SELECT other_charges,otherChargesName,name,sub_total,invoice_no,amount,tax,fee,date_c,url,payment_type FROM customer_payment_request WHERE id ='".$payment_id."' ");
			

			$getCustDetail = $stmt->result_array();
			$invoice_no = $getCustDetail[0]['invoice_no'];
			$other_charges = $getCustDetail[0]['other_charges'];
			$otherChargesName = $getCustDetail[0]['otherChargesName'];
			$payment_type = $getCustDetail[0]['payment_type'];
			$amount = number_format($getCustDetail[0]['amount'], 2);
			$tax = $getCustDetail[0]['tax'];
			$sub_total = number_format($getCustDetail[0]['sub_total'], 2);
			$name1 = $getCustDetail[0]['name'];
			$fee = $getCustDetail[0]['fee'];
			$date_c = $getCustDetail[0]['date_c'];
			$url = $getCustDetail[0]['url'];
			$p_date = date('F j, Y', strtotime($date_c));
			$p_date1 = date('F d, Y', strtotime($date_c));
			$stmt1 = $this->db->query("SELECT logo,business_dba_name,name,email,business_number,address1,color FROM merchant WHERE id ='".$merchant_id."' ");
			$getPersonaDetail = $stmt1->result_array();
			$name = $getPersonaDetail[0]['name'];
			$logo = $getPersonaDetail[0]['logo'];
			$color = $getPersonaDetail[0]['color'];
			$email_id = $getPersonaDetail[0]['email'];
			$business_dba_name = $getPersonaDetail[0]['business_dba_name'];
			$mob_no = $getPersonaDetail[0]['business_number'];
			$address = $getPersonaDetail[0]['address1'];
			if ($type == 'email') {
				$stmt = $this->db->query("UPDATE  customer_payment_request set email_id ='".$sid."' where id = '".$payment_id."'");
				
				$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_e."' ");
				$getTemplate = $stmt5->result_array();
                $templete = $getTemplate[0]['templete'];
				$tamount1 = $amount - $tax;
				$tamount = number_format($tamount1, 2);
				$token = array(
					'USER_NAME' => $name,
					'PHONE' => $mob_no,
					'EMAIL' => $email_id,
					'LOGO' => $logo,
					'AMOUNT' => $amount,
					'COMPANY' => $business_dba_name,
					'TAX' => $tax,
					'URL' => $url,
					'TAMOUNT' => $sub_total,
					'INVOICE_NO' => $invoice_no,
					'PAYMENT_DATE' => $p_date,
				);
				$pattern = '[%s]';
				foreach ($token as $key => $val) {
					$varMap[sprintf($pattern, $key)] = $val;
				}
				$stmt55 = $this->db->query("SELECT  quantity, price, tax, tax_id, tax_per, total_amount,item_name FROM order_item WHERE p_id ='".$payment_id."' ");
				$getItem = $stmt55->result_array();
				
				
				$quantity_a = $getItem[0]['quantity'];
				$price_a = $getItem[0]['price'];
				$tax_a = $getItem[0]['tax'];
				$tax_id_a = $getItem[0]['tax_id'];
				$tax_per_a = $getItem[0]['tax_per'];
				$total_amount_a = $getItem[0]['total_amount'];
				$item_name_a = $getItem[0]['item_name'];
				$item_name = str_replace(array('\\', '/'), '', $item_name_a);
				$quantity = str_replace(array('\\', '/'), '', $quantity_a);
				$price = str_replace(array('\\', '/'), '', $price_a);
				$tax2 = str_replace(array('\\', '/'), '', $tax_a);
				$tax_id = str_replace(array('\\', '/'), '', $tax_id_a);
				$total_amount = str_replace(array('\\', '/'), '', $total_amount_a);
				$item_name1 = json_decode($item_name);
				$quantity1 = json_decode($quantity);
				$price1 = json_decode($price);
				$tax1 = json_decode($tax2);
				$tax_id1 = json_decode($tax_id);
				$total_amount1 = json_decode($total_amount);
				
				$mail_body = '<!DOCTYPE html>
						<html>
						    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						        
						        <title>SalesQuick</title>
						        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
						         <style>
						        body {
						            font-family: Open Sans, sans-serif !important;
						            width: 100% !important;
						            height: 100% !important;
						        }
						        td,
						        th {
						            vertical-align: top !important;
						            text-align: left !important;
						        }
						        p {
						            font-size: 13px !important;
						            color: #878787 !important;
						            line-height: 28px !important;
						            margin: 4px 0px !important;
						        }
						        a {
						            text-decoration: none !important;
						        }
						        .main-box {
						            padding: 80px 0px 10px 0px !important;
						        }
						        .invoice-wrap {
						            margin-left: 14% !important;
						            width: 72% !important;
						            max-width: 72% !important;
						        }
						        .top-div {
						            padding: 20px 40px !important;
						        }
						        .float-left {
						            float: left !important;
						            width:auto !important;
						            text-align: left !important;
						        }
						        .float-right {
						            float: right !important;
						            width:auto !important;
						            text-align: right !important;
						        }
						        .bottom-div {
						            padding: 20px 40px !important;
						        }
						        .footer-wraper>div::after,
						        .footer-wraper>div::before,
						        .footer-wraper::after,
						        .footer-wraper:before {
						            display: table !important;
						            clear: both !important;
						            content: "" !important;
						        }
						        .footer_cards {
						            padding-right: 15px !important;
						        }
						        .footer-wraper>div>div {
						            margin-bottom: 11px !important;
						        }
						        .footer_address span:first-child {
						            font-weight: 600 !important;
						        }
						        @media screen and (max-width: 768px) {
						            .footer_address>span:first {
						                display: inline-block !important;
						                width: 100% !important;
						            }
						        }
						        @media only screen and (max-width:820px) {
						            .footer-wraper>div>div {
						                float: none !important;
						            }
						            .footer_address,
						            .footer_cards {
						                padding-right: 0px !important;
						                padding-left: 0px !important;
						            }
						            .footer_t_c {
						                padding-bottom: 7px !important;
						            }
						            .footer-wraper>div {
						                margin: 20px auto 0 !important;
						            }
						        }
						        @media only screen and (min-width:769px) and (max-width:900px) {
						            .invoice-wrap {
						                margin-left: 10% !important;
						                width: 80% !important;
						                max-width: 80% !important;
						            }
						            .main-box {
						                padding: 50px 0px !important;
						            }
						        }
						        @media only screen and (min-width:481px) and (max-width:768px) {
						            .invoice-wrap {
						                margin-left: 6% !important;
						                width: 88% !important;
						                max-width: 88% !important;
						            }
						            .main-box {
						                padding: 30px 0px !important;
						            }
						            .bottom-div {
						                padding: 20px 20px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						        @media only screen and (max-width:400px) {
						            .twenty-div {
						                word-wrap: break-word !important;
						            }
						        }
						        @media only screen and (max-width:375px) {
						            .twenty-div {
						                word-wrap: anywhere !important;
						            }
						        }
						        @media only screen and (max-width:480px) {
						            .fourty-div {
						                    width: 100% !important;
						                    float: right !important;
						                }
						                .sixty-div {
						                    width: 100% !important;
						                    text-align: center !important;
						                }
						            .float-right {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .float-left {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .invoice-wrap {
						                margin-left: 5% !important;
						                width: 90% !important;
						                max-width: 90% !important;
						            }
						            .bottom-div {
						                padding: 20px 10px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						         .sixty-div {
						                width: 60% !important;
						                float: left !important;
						                display: inline-block !important;
						            }
						            .fourty-div {
						                width: 40% !important;
						                float: right !important;
						                display: inline-block !important;
						            }
						    </style>
						    </head>
						   <body style="margin:0 auto;padding: 0;font-family: Open Sans, sans-serif;width: 100%;height: 100%;">
						    <div class="main-box" style="background-image: linear-gradient(#' . $color . ',#' . $color . ');padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;">
						        <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">
						            <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">
						                <div class="float-left" style="width:100%;display:inline-block;text-align:center;">
						                        <p><img src="https://salequick.com/logo/' . $logo . '" width="200px"></p>
						                            <h4 style="margin-bottom: 0px;color:#000; ">' . $business_dba_name . ' </h4>
						                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
						                            <p style="color: #878787; margin-top: 0px;">Telephone:' . $mob_no . '</p>
						                    </div>
						                    <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
						                        <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Invoice</h3>
						                        <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
						                        <p style="line-height: 20px;margin-top: 10px">
						                            <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						                            <span style="display: block;color: #878787;">' . $invoice_no . '</span></p>
						                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
						                            <span style="display: block;color: #878787;">' . $p_date1 . '</span></p>
						                    </div>
						                </div>
						                 <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">
						                   <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
						                        <tr>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Item name</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Qty</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Price</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Tax</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Amount</th>
						                        </tr>
						 <tr>';
				$i = 0;
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$i] > 0 && ucfirst($item_name1[$i]) != 'Labor') {
						$price_bb = number_format($price1[$i], 2);
						$tax_aa = $total_amount1[$i] - ($price1[$i] * $quantity1[$i]);
						$tax_aaa = number_format($tax_aa, 2);
						$total_aaa = number_format($total_amount1[$i], 2);
						$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               ' . $item_name1[$i] . '
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $quantity1[$i] . '
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $' . $price_bb . '
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $tax_aaa . '';
					
						$mail_body .= '</td>
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $total_aaa . '
                                            </td>
                                        </tr>';
					}
					$i++;
				}
				$j = 0;
				$data = array();
				$data1 = array();
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$j] > 0 && ucfirst($item_name1[$j]) == 'Labor') {
						$data[] = $price1[$j];
						$data1[] = $quantity1[$j];
					}
					$j++;}
				$Array1 = $data;
				$Array2 = $data1;
				// Build the result here
				$Array3 = [];
				// There is no validation, the code assumes that $Array2 contains
				// the same number of items as $Array1 or more
				foreach ($Array1 as $index => $key) {
					// If the key $key was not encountered yet then add it to the result
					if (!array_key_exists($key, $Array3)) {
						$Array3[$key] = 0;
					}
					// Add the value associate with $key to the sum in the results array
					$Array3[$key] += $Array2[$index];
				}
				foreach ($Array3 as $index => $person) {
					$laboramount = number_format($index * $person, 2);
					$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               Labor
                                            </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $person . '
                                            </td>
                                            <!-- <td>$ <?php echo number_format($price1[$i],2) ;?></td> -->
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                $' . $index . '
                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$0.00';
					
					$mail_body .= '</td>
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $laboramount . '
                                            </td>
                                        </tr>';
				}
      if($other_charges > 0){
				$mail_body .= '  
				
				<tr>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">'.$otherChargesName.'</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="color: #0077e2;border:0px;">$' . $other_charges . '</p>
                            </td>
                        </tr>';
      }
                    
					$mail_body .= ' <tr>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="color: #0077e2;border:0px;">$' . $amount . '</p>
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">
                        <a href="' . $url . '" class="custom-btn" style="background-color: #0077e2;border-radius: 4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration: none;float: right;color: #fff;-webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 0;">CONTINUE TO PAYMENT</a>
                    </div>
                </div>
            </div>
                <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">
                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">
                     <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">
                        <span style="display: block;font-weight:600;color:#000 ">' . $business_dba_name . '</span>
                        <span style="display: inline-block;color:#666">' . $address . '</span>
                    </div>
                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">
                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                    </div>
                    <div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  ></a>
                    </div>
                </div>
            </div>
        </div>
			    </body>
			</html>';
				$MailSubject = 'Salequick Invoice';
				
				set_time_limit(3000);
				


				       $email = $sid;
					   $MailSubject = 'Salequick Recurring Invoice' . $business_dba_name;
					  
					
					   if (!empty($email)) {
						   $this->email->from('info@salequick.com', $business_dba_name);
						   $this->email->to($email);
						   $this->email->subject($MailSubject);
						   $this->email->message($mail_body);
						   $this->email->send();
					   }


				$message = '1';
			} else if ($type == 'sms') {
				$stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."' ");
				
				$mob = str_replace(array('(', ')', '-', ' '), '', $sid);
				$mobile = '+1' . $mob;
				                
				 //$sms_message = trim(" Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  ('" . $amount . "') $url "); 
				 $sms_message = trim(" " . $business_dba_name . " is Requesting  Payment .$url ");
				
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);


				$message = '1';
			}
			if ($message) {
				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}
		 }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function add_direct_invoice_request_rback_mail_post()
{
	$data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {

     		$payment_id = $_POST['payment_id'];
			$sid = $_POST['id'];
			$type = $_POST['type'];
			$merchant_id_e = 1;

			$stmt = $this->db->query("SELECT name,sub_total,invoice_no,amount,tax,fee,date_c,url FROM customer_payment_request WHERE id = '".$payment_id."' ");
			
			$getCustDetail = $stmt->result_array();
			$invoice_no = $getCustDetail[0]['invoice_no'];
			$amount = $getCustDetail[0]['amount'];
			$sub_total = $getCustDetail[0]['sub_total'];
			$tax = $getCustDetail[0]['tax'];
			$name1 = $getCustDetail[0]['name'];
			$fee = $getCustDetail[0]['fee'];
			$url = $getCustDetail[0]['url'];
			$date_c = $getCustDetail[0]['date_c'];
			$p_date = date('F j, Y', strtotime($date_c));

			$stmt1 = $this->db->query("SELECT logo,business_dba_name,name,email,mob_no FROM merchant WHERE id ='".$merchant_id."' ");
			
		
			$getUserDetail = $stmt1->result_array();
			$name = $getUserDetail[0]['name'];
			$logo = $getUserDetail[0]['logo'];
			$business_dba_name = $getUserDetail[0]['business_dba_name'];
			$email_id = $getUserDetail[0]['email'];
			$mob_no = $getUserDetail[0]['mob_no'];
			
			

			if ($type == 'email') {

				$stmt = $this->db->query("UPDATE  customer_payment_request set email_id ='".$sid."' where id ='".$payment_id."' ");

			

				$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_e."' ");
				$getTemplateDetail = $stmt5->result_array();
				
                $templete = $getUserDetail[0]['templete'];
				$tamount1 = $amount - $tax;
				$tamount = number_format($tamount1, 2);

				$token = array(

					'USER_NAME' => $name,
					'PHONE' => $mob_no,
					'EMAIL' => $email_id,
					'LOGO' => $logo,
					'AMOUNT' => $amount,
					'COMPANY' => $business_dba_name,
					'TAX' => $tax,
					'URL' => $url,
					'TAMOUNT' => $sub_total,
					'INVOICE_NO' => $invoice_no,
					'PAYMENT_DATE' => $p_date,

				);

				$pattern = '[%s]';
				foreach ($token as $key => $val) {
					$varMap[sprintf($pattern, $key)] = $val;
				}

				// $MailSubject = 'Payment  Invoice';
				// $header = "From:Salequick<info@salequick.com >\r\n" .
				// 	"MIME-Version: 1.0" . "\r\n" .
				// 	"Content-type: text/html; charset=UTF-8" . "\r\n";

				$htmlContent = strtr($templete, $varMap);


				$email = $sid;
					   $MailSubject = 'Salequick Recurring Invoice' . $business_dba_name;
					  
					
					   if (!empty($email)) {
						   $this->email->from('info@salequick.com', $business_dba_name);
						   $this->email->to($email);
						   $this->email->subject($MailSubject);
						   $this->email->message($htmlContent);
						   $this->email->send();
					   }

				//$message = mail($sid, $MailSubject, $htmlContent, $header);
				$message = '1';

			} else if ($type == 'sms') {

				$stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."'  ");

				$mob = str_replace(array('(', ')', '-', ' '), '', $sid);
				

				// $sms_message = trim(" Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  '" . $amount . "' ");

		 $sms_message = trim("" . $business_dba_name . " is Requesting  Payment .  ".$url." ");


				 $sms_message_1 = trim("  Payment date  '" . $p_date . "' url is ".$url." "); 
				
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
                 $response_2 = $this->twilio->sms($from, $to, $sms_message_1);
                 $message = '1';

			}

			if ($message) {

				$status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];

			} else {

				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}


			
	}
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function invoice_test_post()
{
  echo 'test invoice';
}






 
    
}




