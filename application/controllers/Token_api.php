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
 define('UPLOAD_PATH', 'https://salequick.com/logo/');
define('UPLOAD_POS_PATH', 'https://salequick.com/uploads/item_image/');
 //header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 class Token_api extends REST_Controller {
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


public function add_token_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
            $invoice_no = $_POST['invoice_no'];
            $token = $_POST['token'];
            $name = $_POST['name'];

            $card_type = $_POST['card_type'];
            $card_expiry_month = $_POST['card_expiry_month'];
            $card_expiry_year = $_POST['card_expiry_year'];
            $card_no = $_POST['card_no'];
            $zipcode = $_POST['zipcode'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];

             $mob = str_replace(array( '(', ')','-',' ' ), '', $mobile);
            $status = '1';
            $payroc = '1';
           
                        $data = array(
                         'merchant_id' =>$merchant_id,
                         'name' =>$name,
                         'token' =>$token,
                         'card_type' =>$card_type,
                         'card_expiry_month' =>$card_expiry_month,
                         'card_expiry_year' =>$card_expiry_year,
                         'card_no' =>$card_no, 
                         'zipcode' =>$zipcode,
                         'mobile' =>$mob, 
                         'email' =>$email,
                         'status' =>$status, 
                         'payroc' =>$payroc,
                                                                 
                        );
                        $id = $this->admin_model->insert_data("token", $data);

                        $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'token_id' =>$id,
                        'invoice_no'=>$invoice_no,
                        'status'=>$status, 
                       
                        );
                        $pax_id = $this->admin_model->insert_data("invoice_token", $data_pax);
                        
                        $status = parent::HTTP_OK;
                        if(!empty($id)){
                            
                              
                             
                     $response = ['status' => $status, 'successMsg' => 'Successfull'];
                        
                        }
                        else
                        {
                             $response = ['status' => 401, 'errorMsg' => 'Fail'];
                        }
                       
                        }
                        else
                        {
                            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
                        }
                        $this->response($response, $status);
                    }


public function edit_token_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
            $invoice_no = $_POST['invoice_no'];
            $token = $_POST['token'];
            $name = $_POST['name'];
            $card_type = $_POST['card_type'];
            $card_expiry_month = $_POST['card_expiry_month'];
            $card_expiry_year = $_POST['card_expiry_year'];
            $card_no = $_POST['card_no'];
            $zipcode = $_POST['zipcode'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $status = '1';
            $payroc = '1';
            $mob = str_replace(array( '(', ')','-',' ' ), '', $mobile);

             $getRow_token=$this->db->query(" SELECT token_id FROM invoice_token WHERE invoice_no='$invoice_no' and merchant_id='$merchant_id' and status=1 " )->result_array(); 
                $token_id=$getRow_token[0]['token_id'] ? $getRow_token[0]['token_id'] :"0";

                 $stmt = $this->db->query("delete FROM `invoice_token`  where invoice_no='".$invoice_no."' ");
                $stmt1 = $this->db->query("delete FROM `token`  where id='".$token_id."' "); 

           
                        $data = array(
                         'merchant_id' =>$merchant_id,
                         'name' =>$name,
                         'token' =>$token,
                         'card_type' =>$card_type,
                         'card_expiry_month' =>$card_expiry_month,
                         'card_expiry_year' =>$card_expiry_year,
                         'card_no' =>$card_no, 
                         'zipcode' =>$zipcode,
                         'mobile' =>$mob, 
                         'email' =>$email,
                         'status' =>$status, 
                         'payroc' =>$payroc,
                                                                 
                        );
                        $id = $this->admin_model->insert_data("token", $data);

       

                        $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'token_id' =>$id,
                        'invoice_no'=>$invoice_no,
                        'status'=>$status, 
                       
                        );
                        $pax_id = $this->admin_model->insert_data("invoice_token", $data_pax);
                        
                        $status = parent::HTTP_OK;
                        if(!empty($id)){
                            
                              
                             
                     $response = ['status' => $status, 'successMsg' => 'Successfull'];
                        
                        }
                        else
                        {
                             $response = ['status' => 401, 'errorMsg' => 'Fail'];
                        }
                       
                        }
                        else
                        {
                            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
                        }
                        $this->response($response, $status);
                    }                    




}