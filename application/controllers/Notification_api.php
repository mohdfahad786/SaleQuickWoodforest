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

class Notification_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        date_default_timezone_set("America/Chicago");
       // ini_set('display_errors', 1);
       // error_reporting(E_ALL);

    }

    private function verify_request()
{
    // Get all the headers
    $headers = $this->input->request_headers();
    
   //print_r($headers); die('testing');
    
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



public function get_notification_list_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       //$package_data = $this->admin_model->get_data('tax',$merchant_id);
        //$package_data = $this->admin_model->data_get_where_1('notification', array('merchant_id' => $merchant_id,'status' =>'unread'));

        $query = $this->db->query("SELECT * FROM `notification` WHERE   merchant_id='$merchant_id'   ORDER BY id DESC limit $start_limit,$limit ");

          $package_data = $query->result_array();

    // $start_date=date("M d Y", strtotime($DGetFirstRecord['recurring_pay_start_date'])); 

        $mem = array();
        $member = array();
        foreach ($package_data as $each) {
            $start_date=date("M d Y", strtotime($each['transaction_date'])); 
            $userdata[] = array(
            "name"=>$each['name'],
            "amount"=>$each['amount'],
            "type"=>$each['notification_type'],
            "status"=>$each['status_a'],
            "date"=>$start_date,
        );

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

public function get_notification_count_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      

         $query = $this->db->query(" SELECT count(id) as Totalnotification from notification where  merchant_id = '".$merchant_id."' and status='unread' ");
       
          $package_data = $query->result_array();


        $mem = array();
        $member = array();
        $userdata4 = array(
            "count"=> $package_data[0]['Totalnotification']
        );
        
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata4];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function get_notification_read_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
          $query = $this->db->query("UPDATE  notification set status ='read' where id = '".$id."' and merchant_id = '".$merchant_id."' ");
       
        $mem = array();
        $member = array();
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function notification_delete_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
          $query = $this->db->query("DELETE  from notification  where id = '".$id."' and merchant_id = '".$merchant_id."' ");
       
        $mem = array();
        $member = array();
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function notification_deleteAll_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
          $query = $this->db->query("DELETE  from notification  where merchant_id = '".$merchant_id."' ");
       
        $mem = array();
        $member = array();
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function get_notification_allclear_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
   
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
          $query = $this->db->query("UPDATE  notification set status ='read' where  merchant_id = '".$merchant_id."' ");
       
        $mem = array();
        $member = array();
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function set_device_token_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $token = trim($this->input->post('token'));
    $device = trim($this->input->post('device'));
    $sub_merchant_id = $this->input->post('sub_merchant_id');

   
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       $today2 = date("Y-m-d");
       
          $data = Array(
                    'merchant_id' => $merchant_id,
                    'sub_merchant_id' => $sub_merchant_id,
                    'token' => $token,
                    'device' => $device,
                    'date_c' => $today2,
                );
                $id = $this->admin_model->insert_data("notification_token", $data);
       
        $mem = array();
        $member = array();
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function delete_device_token_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $token = trim($this->input->post('token'));
    $device = trim($this->input->post('device'));
    $sub_merchant_id = $this->input->post('sub_merchant_id');

   
    
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
       
       $query = $this->db->query("DELETE FROM `notification_token` WHERE   merchant_id = '".$merchant_id."' and sub_merchant_id = '".$sub_merchant_id."' and token = '".$token."' and device = '".$device."' ");
       
        $mem = array();
        $member = array();
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


}