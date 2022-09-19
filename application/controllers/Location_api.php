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
 class Location_api extends REST_Controller {
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


public function set_location_old_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
            $long= $_POST['long'];
            $lat= $_POST['lat'];
            $device= $_POST['device'];
            $sub_merchant_id= $_POST['sub_merchant_id'];
            $dateTime = $_POST['dateTime'];
            
       
            $amount11 = $amount;
            
       
                        $data = array(
                           'merchant_id' =>$merchant_id,
                         'sub_merchant_id' =>$sub_merchant_id,
                         'lat' =>$lat,
                         'longi' =>$long,
                         'device' =>$device, 
                         'date_time' =>$dateTime
                        );
                        $id = $this->admin_model->insert_data("location_test", $data);
                        
                        $status = parent::HTTP_OK;
                        if(!empty($id)){
                            
                 
                             
                             $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id];
                        
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

public function set_location_post() {
        $data = array();
        $data = $this->verify_request();
        $merchant_id = $this->input->post('merchant_id');

        if($merchant_id == $data->merchant_id) {
            $long = $_POST['long'];
            $lat = $_POST['lat'];
            $device = $_POST['device'];
            $sub_merchant_id = $_POST['sub_merchant_id'];
            $dateTime = $_POST['dateTime'];
            // $amount11 = $amount;

            if( empty($sub_merchant_id) ) {
                $query = $this->db->query('SELECT * FROM location_test WHERE merchant_id = '.$merchant_id.' AND (sub_merchant_id = 0 OR sub_merchant_id = '.$merchant_id.')')->result_array();
                // echo '2,'.$this->db->last_query();die;

            } else if($merchant_id != $sub_merchant_id) {
                $query = $this->db->query('SELECT * FROM location_test WHERE merchant_id = '.$merchant_id.' AND sub_merchant_id = '.$sub_merchant_id)->result_array();
                // echo '3,'.$this->db->last_query();die;

            } else if($merchant_id == $sub_merchant_id) {
                $query = $this->db->query('SELECT * FROM location_test WHERE merchant_id = '.$merchant_id.' AND sub_merchant_id = '.$merchant_id)->result_array();
                // echo '4,'.$this->db->last_query();die;
            }

            if(count($query) > 0) {
                //update
                if( empty($sub_merchant_id) ) {
                    $query2 = $this->db->query('SELECT * FROM location_test WHERE merchant_id = '.$merchant_id.' AND (sub_merchant_id = 0 OR sub_merchant_id = '.$merchant_id.')')->result_array();
                    $get_id = $query2[0]['id'];

                    $this->db->query("UPDATE location_test SET sub_merchant_id = ".$merchant_id.", lat = '".$lat."', longi = '".$long."', device = '".$device."', date_time = '".$dateTime."' WHERE merchant_id = ".$merchant_id." AND (sub_merchant_id = 0 OR sub_merchant_id = ".$merchant_id.")");
                    // echo "1".$this->db->last_query();die;

                } else if($merchant_id != $sub_merchant_id) {
                    $query2 = $this->db->query("SELECT * FROM location_test WHERE merchant_id = ".$merchant_id." AND sub_merchant_id = ".$sub_merchant_id)->result_array();
                    $get_id = $query2[0]["id"];

                    $this->db->query("UPDATE location_test SET lat = '".$lat."', longi = '".$long."', device = '".$device."', date_time = '".$dateTime."' WHERE merchant_id = ".$merchant_id." AND sub_merchant_id = ".$sub_merchant_id);
                    // echo "1".$this->db->last_query();die;

                } else if($merchant_id == $sub_merchant_id) {
                    $query2 = $this->db->query("SELECT * FROM location_test WHERE merchant_id = ".$merchant_id." AND sub_merchant_id = ".$merchant_id)->result_array();
                    $get_id = $query2[0]["id"];

                    $this->db->query("UPDATE location_test SET lat = '".$lat."', longi = '".$long."', device = '".$device."', date_time = '".$dateTime."' WHERE merchant_id = ".$merchant_id." AND sub_merchant_id = ".$merchant_id);
                    // echo '1'.$this->db->last_query();die;
                }
                $id = $get_id;

            } else {
                //insert
                $ins_data = array(
                    'merchant_id' => $merchant_id,
                    'sub_merchant_id' => empty($sub_merchant_id) ? $merchant_id : $sub_merchant_id,
                    'lat' => $lat,
                    'longi' => $long,
                    'device' => $device, 
                    'date_time' => $dateTime
                );

                $id = $this->admin_model->insert_data("location_test", $ins_data);
            }
                        
            $status = parent::HTTP_OK;
            if(!empty($id)){
                $response = ['status' => $status, 'successMsg' => 'Successfull','id' => $id];
            
            } else {
                $response = ['status' => 401, 'errorMsg' => 'Fail'];
            }
           
        } else {
            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
        }
        $this->response($response, $status);
    }


}
