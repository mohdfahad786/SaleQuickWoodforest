<?php
ini_set('MAX_EXECUTION_TIME', '-1');
// ini_set('memory_limit','2048M');
defined('BASEPATH') OR exit('No direct script access allowed');
 //require APPPATH . 'third_party/REST_Controller.php';
//require APPPATH . 'third_party/Format.php';
 require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
 //use Restserver\Libraries\REST_Controller;
 header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");
 define('UPLOAD_PATH', 'https://salequick.com/uploads/pdf/');
define('UPLOAD_POS_PATH', 'https://salequick.com/uploads/pdf/');
 //header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 class Pax_log_api extends REST_Controller {
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
       //ini_set('display_errors', 1);
       //error_reporting(E_ALL);
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


 public function upload_log_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
   $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
			try {
 				if (isset($_FILES['log']['name'])) {
					$date = date("YmdHis");
					$image = $_FILES['log']['name'];
					$exp = explode(".", $image);
					$extension = end($exp);
 					$image_name = "log_" . $date . "." . $extension;
 					//move_uploaded_file($_FILES['logo']['tmp_name'], UPLOAD_PATH . $image_name);
					
					$config['file_name'] = $image_name; 
                    $config['upload_path']          = './file/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx|zip|rar|log|txt';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 3024;
                    $config['max_height']           = 3068;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('log'))
                    {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                    }
                     $image_name =$uploadedFileName;
  					//$stmt = $this->db->query("UPDATE  pos set  sign = '".$image_name."', ip = '".$_POST['ip']."' where id = '".$_POST['payment_id']."' ");

                    $data = array(
                             'merchant_id' =>$merchant_id, 
                             'image' =>$image_name                            
                         );
                      $stmt2 = $this->admin_model->insert_data("pax_log_image", $data);
                     // echo $this->db->last_query();   
                   
  									
				}
 				 if (!empty($stmt2)) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Log Uploaded Successfully'];
 				} else {
				
					$response = ['status' => '401', 'msg' => 'Could not upload file!'];
				}
			} catch (Exception $e) {
				
				$response = ['status' => '401', 'errorMsg' => 'Update Fail'];
			}

              }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    
 	
						
    
     $this->response($response, $status);
}

 public function add_log_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
     $fulldata = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();


        $request = $this->input->post('request') ? $this->input->post('request') : "";
        $response = $this->input->post('response') ? $this->input->post('response') : "";
        $type = $this->input->post('type') ? $this->input->post('type') : "";
        $utcInMillis = $this->input->post('utcInMillis') ? $this->input->post('utcInMillis') : "";
		$jsonobj = $this->input->post('data') ? $this->input->post('data') : "";  
        $arr = json_decode($jsonobj, true);   
        
foreach($arr as $array)
{
	 $fulldata = Array(
                'merchant_id' => $merchant_id,
                'request' => $array['request'], 
                'response' => $array['response'],
                'type' => $array['payment_type'],
                'utc_time_in_millis' =>$array['utc_time_in_millis'],
                'transaction_id' =>$array['transaction_id']
                
                );

	
	$id = $this->admin_model->insert_data("pax_log", $fulldata);
}
            
                if (!empty($id)) {
                        $itemId=$id;
                    
                        
                    $status = parent::HTTP_OK;
                     $response = ['status' => $status, 'successMsg' =>'Log added Successfully'];
                    } else {
                        
                         //$response = ['status' => '401', 'errorMsg' => 'Server error'];
                          $response = ['status' => '401', 'errorMsg' => $id];
                    }
                
              
     
    
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
     $this->response($response, $status);
}



public function all_log_post()
{
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $re_merchant_id = $this->input->post('re_merchant_id');
       $start = $this->input->post('skip');
       $limit = $this->input->post('limit');
       $date = $this->input->post('date');
       $userdata = array();
       //$package_data = $this->admin_model->get_data('tax',$merchant_id);
        //$package_data = $this->admin_model->data_get_where_1('pax_log', array('merchant_id' => $re_merchant_id  ,'add_date' => $date ));

         $query=$this->db->query("SELECT * from pax_log WHERE DATE(add_date) ='$date' and merchant_id = '$re_merchant_id'  ORDER BY id DESC limit $start,$limit"); 
        
        $package_data = $query->result_array();

        //print_r($package_data);die;
        $mem = array();
        $member = array();
        
        
            if (isset($package_data)) {
            foreach ($package_data as $each) {
            
                        $package['id'] = $each['id'];
                        $package['merchant_id'] = $each['merchant_id'];
                        $package['transaction_id'] = $each['transaction_id'];
                        $package['request'] = $each['request'];
                        $package['response']  = $each['response'];
                        $package['type'] = $each['type'];
                        $package['add_date'] = $each['add_date'];
                       
                $mem[] = $package;

            }
        }
    
    $userdata = $mem;
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