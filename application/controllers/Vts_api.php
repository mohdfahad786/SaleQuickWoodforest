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
 class Vts_api extends REST_Controller {
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
       // ini_set('display_errors', 1);
       // error_reporting(E_ALL);
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


      public function get_data_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $device_serial_number = $this->input->post('deviceSerialNumber');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();

       $query = $this->db->query("SELECT * FROM vts WHERE merchant_id= '".$merchant_id."' and device_serial_number='".$device_serial_number."' order by id desc limit 0,1 ");
       

         if($query->num_rows() > 0) 
         {
         $result = $query->result_array();
        
                $user = array(
         
                    'amount' => $result[0]['amount'],
                    'tax' => $result[0]['tax'],
                    'otherCharges' => $result[0]['other_charges'],
                    'totalAmount' => $result[0]['total_amount'],
                    'totalAmount' => $result[0]['total_amount'],
                    'postId' => $result[0]['transaction_id'],
                    'towedVehicle' => $result[0]['towed_vehicle'],
                    
                );
                $id=$result[0]['id'];
                $queryy = $this->db->query("DELETE FROM vts WHERE id= '".$id."' ");

    // Send the return data as reponse
     $status = parent::HTTP_OK;
     $response = ['status' => $status,'successMsg' => 'successful', 'UserData' => $user];
         }
         else
         {
             $response = ['status' => $status, 'errorMsg' => 'No Data'];
         }
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


   }