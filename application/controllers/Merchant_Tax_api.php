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

class Merchant_Tax_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        //date_default_timezone_set("America/Chicago");

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



    public function get_tax_list_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $type = $this->input->post('type');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       //$package_data = $this->admin_model->get_data('tax',$merchant_id);
        $package_data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' =>'active'));

        $version_data = $this->admin_model->data_get_where_1('version', array('type' => $type,'status' =>'1'));
        $package_data_tax = $this->admin_model->data_get_where_1('merchant', array('id' => $merchant_id));

             

         //print_r($version_data);die;
        $mem = array();
        $member = array();
        foreach ($package_data as $each) {
            $userdata[] = $each;

        }
         $userdata2[] = array(
            "id"=>"0",
            "merchant_id"=> $merchant_id,
            "title"=>"No Tax",
            "percentage"=> "0.00",
            "status"=>"active",
            "date_c"=>"",
            "add_date"=>""
        );

$userdata4 = array(
            "current_version"=> $version_data[0]['current_version'] ? $version_data[0]['current_version'] : "",
            "version_text"=>$version_data[0]['version_text'] ? $version_data[0]['version_text'] : "",
            "type"=> $version_data[0]['type'] ? $version_data[0]['type'] : "",
        );

       
      
   $userdata3 = array_merge($userdata2,$userdata);
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata3,'updateInfo' => $userdata4,'taxableOption' => $package_data_tax['0']['tax_option']];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



public function get_other_charges_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
        $userdata = array();
       //$package_data = $this->admin_model->get_data('tax',$merchant_id);
        $package_data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id, 'status' =>'active'));

        $package_data_tax = $this->admin_model->data_get_where_1('merchant', array('id' => $merchant_id));

       
        $mem = array();
        $member = array();
        
//      foreach ($package_data as $each) {
//          $userdata[] = $each;

//      }
        
    if(!empty($package_data[0]['id'])){
        $userdata = array(
                        'id' => $package_data[0]['id'] ? $package_data[0]['id'] : "",
                        'title' => $package_data[0]['title'] ? $package_data[0]['title'] : "",
                        'type' => $package_data[0]['type'] ? $package_data[0]['type'] : "",
                        'value' => $package_data[0]['percentage'] ? $package_data[0]['percentage'] : "",

                    );
                    }
                    else
                    {
                    $userdata = array(
                        

                    );
                    }

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata,'taxableOption' => $package_data_tax['0']['tax_option']];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function get_pin_detail_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $employee_pin = $this->input->post('employee_pin');
    
    if($merchant_id == $data->merchant_id)
    {
        $userdata = array();

    $package_data_tax = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id,'employee_pin' => $employee_pin));
       
        $mem = array();
        $member = array();
        
//echo $package_data_tax[0]['id'];
//echo $this->db->last_query();die;
        
    if(!empty($package_data_tax[0]['id'])){
        $userdata = array(
                        'validate' => '1',
                       

                    );
                    }
                    else
                    {
                    $userdata = array(
                        
'validate' => '0',
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


}