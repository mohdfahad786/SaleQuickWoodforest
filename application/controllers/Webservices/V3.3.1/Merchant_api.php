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

class Merchant_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
		$this->load->model('admin_model');

			
			
    }
    
    function my_encrypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = '1@#$%^&s6*';
    $secret_iv = '`~ @hg(n5%';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
   }

        public function hello_get()
    {
        $tokenData = 'mohd.fahad1690@gmail.com';
        
        
        // Create a token
        $token = AUTHORIZATION::generateToken($tokenData);
        // Set HTTP status code
        $status = parent::HTTP_OK;
        // Prepare the response
        $response = ['status' => $status, 'token' => $token];
        // REST_Controller provide this method to send responses
        $this->response($response, $status);
    }

    public function login_post()
 {
        // Have dummy user details to check user credentials
        // send via postman
        $username = $this->input->post("username");
        $password1 = $this->input->post("password");
        $password = $this->my_encrypt( $password1 , 'e' );
        $ip = $this->input->post("ip");
        $usr_result = $this->login_model->get_merchant($username, $password);
        // $dummy_user = [
        //     'username' => 'Test',
        //     'password' => 'test'
        // ];

        // Extract user data from POST request
        // $username = $this->post('username');
        // $password = $this->post('password');

        // Check if valid user
        //if ($username === $dummy_user['username'] && $password === $dummy_user['password']) {
        if (!empty($usr_result) && $usr_result['status']!='pending' && $usr_result['status']!='pending_signup')  {
             
            
            // Create a token from the user data and send it as reponse
            $token = AUTHORIZATION::generateToken(['merchant_id' => $usr_result['id']]);
            // Prepare the response
            $status = parent::HTTP_OK;

            $response = ['status' => $status, 'token' => $token,'merchant_id' => $usr_result['id'],'login_status' => '1'];

            $this->response($response, $status);
        }
        else {
            $this->response(['msg' => 'Invalid username or password!'], parent::HTTP_NOT_FOUND);
        }

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

public function get_me_data_post()
{
    // Call the verification method and store the return value in the variable
    $data = $this->verify_request();

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'data' => $data];

    $this->response($response, $status);
}

public function charge_list_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       $userdata = array();
	   //$package_data = $this->admin_model->get_data('tax',$merchant_id);
		$package_data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id));
		// print_r($package_data);die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$userdata[] = $each;

		}

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function get_tax_list_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       $userdata = array();
	   //$package_data = $this->admin_model->get_data('tax',$merchant_id);
		$package_data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
		// print_r($package_data);die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$userdata[] = $each;

		}

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function all_employee_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       $userdata = array();
	   //$package_data = $this->admin_model->get_data('tax',$merchant_id);
		$package_data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
		// print_r($package_data);die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$userdata[] = $each;

		}

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function all_user_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       $userdata = array();
	   //$package_data = $this->admin_model->get_data('tax',$merchant_id);
		$package_data = $this->admin_model->data_get_where_1('user', array('merchant_id' => $merchant_id));
		// print_r($package_data);die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$userdata[] = $each;

		}

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function all_recurring_payment_request_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
	$userdata= array();
	if ($_POST['start_date'] != '') {

				$start_date = $_POST['start_date'];

			} else {
				$start_date = date("Y-m-d", strtotime("-364 days"));
			}

			if ($_POST['end_date'] != '') {

				$end_date = $_POST['end_date'];

			} else {
				$end_date = date("Y-m-d");
			}
			
			$type = $_POST['type'];
			
		
              $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'customer_payment_request');
		
			
	
	
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
				
				

				$package['id'] = $each->id ? $each->id : "";
				$package['p_id'] = "";
				$package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
				$package['name'] = $each->name ? $each->name : "";
				$package['email_id'] = $each->email_id ? $each->email_id : "";
				$package['amount'] = $each->amount ? $each->amount : "";
				$package['title']  = $each->title ? $each->title : "";
				$package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
				$package['detail'] = $each->detail ? $each->detail : "";
				$package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
				$package['payment_date'] = $each->payment_date ? $each->payment_date : "";
				$package['date_c'] = $each->add_date ? $each->add_date : "";
				$package['reference'] = $each->reference ? $each->reference : "";
				$package['due_date'] = $each->due_date ? $each->due_date : "";
				$package['status'] = "";
				
				
				$mem[] = $package;
		

			}
		}
	
		$userdata[] = $mem;
	
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}


public function all_confirm_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
	$userdata= array();
	if ($_POST['start_date'] != '') {

				$start_date = $_POST['start_date'];

			} else {
				$start_date = date("Y-m-d", strtotime("-364 days"));
			}

			if ($_POST['end_date'] != '') {

				$end_date = $_POST['end_date'];

			} else {
				$end_date = date("Y-m-d");
			}
			
			$type = $_POST['type'];
			
			if ($type == '' or $type == 'straight') {
              $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'customer_payment_request');
			} elseif ($type == 'recur') {
			     $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'recurring_payment');

			} elseif ($type == 'pos') {
			$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'pos');

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
				
				

				$package['id'] = $each->id ? $each->id : "";
				$package['p_id'] = "";
				$package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
				$package['name'] = $each->name ? $each->name : "";
				$package['email_id'] = $each->email_id ? $each->email_id : "";
				$package['amount'] = $each->amount ? $each->amount : "";
				$package['title']  = $each->title ? $each->title : "";
				$package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
				$package['detail'] = $each->detail ? $each->detail : "";
				$package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
				$package['payment_date'] = $each->payment_date ? $each->payment_date : "";
				$package['date_c'] = $each->add_date ? $each->add_date : "";
				$package['reference'] = $each->reference ? $each->reference : "";
				$package['due_date'] = $each->due_date ? $each->due_date : "";
				$package['status'] = "";
				
				
				$mem[] = $package;
		

			}
		}
	
		$userdata[] = $mem;
	
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}


public function all_pending_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
	$userdata= array();
	if ($_POST['start_date'] != '') {

				$start_date = $_POST['start_date'];

			} else {
				$start_date = date("Y-m-d", strtotime("-364 days"));
			}

			if ($_POST['end_date'] != '') {

				$end_date = $_POST['end_date'];

			} else {
				$end_date = date("Y-m-d");
			}
			
			$type = $_POST['type'];
			
			if ($type == '' or $type == 'straight') {
              $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'pending', $merchant_id, 'customer_payment_request');
			} elseif ($type == 'recur') {
			     $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'pending', $merchant_id, 'recurring_payment');

			} elseif ($type == 'pos') {
			$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'pending', $merchant_id, 'pos');

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
				
				

				$package['id'] = $each->id ? $each->id : "";
				$package['p_id'] = "";
				$package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
				$package['name'] = $each->name ? $each->name : "";
				$package['email_id'] = $each->email_id ? $each->email_id : "";
				$package['amount'] = $each->amount ? $each->amount : "";
				$package['title']  = $each->title ? $each->title : "";
				$package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
				$package['detail'] = $each->detail ? $each->detail : "";
				$package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
				$package['payment_date'] = $each->payment_date ? $each->payment_date : "";
				$package['date_c'] = $each->add_date ? $each->add_date : "";
				$package['reference'] = $each->reference ? $each->reference : "";
				$package['due_date'] = $each->due_date ? $each->due_date : "";
				$package['status'] = "";
				
				
				$mem[] = $package;
		

			}
		}
	
		$userdata[] = $mem;
	
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}

public function all_declined_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
	$userdata= array();
	if ($_POST['start_date'] != '') {

				$start_date = $_POST['start_date'];

			} else {
				$start_date = date("Y-m-d", strtotime("-364 days"));
			}

			if ($_POST['end_date'] != '') {

				$end_date = $_POST['end_date'];

			} else {
				$end_date = date("Y-m-d");
			}
			
			$type = $_POST['type'];
			
			if ($type == '' or $type == 'straight') {
              $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'declined', $merchant_id, 'customer_payment_request');
			} elseif ($type == 'recur') {
			     $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'declined', $merchant_id, 'recurring_payment');

			} elseif ($type == 'pos') {
			$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'declined', $merchant_id, 'pos');

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
				
				

				$package['id'] = $each->id ? $each->id : "";
				$package['p_id'] = "";
				$package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
				$package['name'] = $each->name ? $each->name : "";
				$package['email_id'] = $each->email_id ? $each->email_id : "";
				$package['amount'] = $each->amount ? $each->amount : "";
				$package['title']  = $each->title ? $each->title : "";
				$package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
				$package['detail'] = $each->detail ? $each->detail : "";
				$package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
				$package['payment_date'] = $each->payment_date ? $each->payment_date : "";
				$package['date_c'] = $each->add_date ? $each->add_date : "";
				$package['reference'] = $each->reference ? $each->reference : "";
				$package['due_date'] = $each->due_date ? $each->due_date : "";
				$package['status'] = "";
				
				
				$mem[] = $package;
		

			}
		}
	
		$userdata[] = $mem;
	
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}


public function all_refund_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
	$userdata= array();
	if ($_POST['start_date'] != '') {

				$start_date = $_POST['start_date'];

			} else {
				$start_date = date("Y-m-d", strtotime("-364 days"));
			}

			if ($_POST['end_date'] != '') {

				$end_date = $_POST['end_date'];

			} else {
				$end_date = date("Y-m-d");
			}
			
			$type = $_POST['type'];
			
			if ($type == '' or $type == 'straight') {
              $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'customer_payment_request');
			} elseif ($type == 'recur') {
			     $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'recurring_payment');

			} elseif ($type == 'pos') {
			$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'pos');

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
				
				

				$package['id'] = $each->id ? $each->id : "";
				$package['p_id'] = "";
				$package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
				$package['name'] = $each->name ? $each->name : "NA";
				$package['email_id'] = $each->email_id ? $each->email_id : "";
				$package['amount'] = $each->amount ? $each->amount : "";
				$package['title']  = $each->title ? $each->title : "";
				$package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
				$package['detail'] = $each->detail ? $each->detail : "";
				$package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
				$package['payment_date'] = $each->payment_date ? $each->payment_date : "";
				$package['date_c'] = $each->add_date ? $each->add_date : "";
				$package['reference'] = $each->reference ? $each->reference : "";
				$package['due_date'] = $each->due_date ? $each->due_date : "";
				$package['status'] = "";
				
				
				$mem[] = $package;
		

			}
		}
	
		$userdata[] = $mem;
	
	$status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}





}

/* End of file Api.php */