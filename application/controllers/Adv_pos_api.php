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

class Adv_pos_api extends REST_Controller {

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


public function getCategory_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    $type = $this->input->post('type');
    if($merchant_id = $data->merchant_id)
    {
       $userdata = array();

       $version_data = $this->admin_model->data_get_where_1('version', array('type' => $type,'status' =>'1'));

       $userdata4 = array(
            "current_version"=> $version_data[0]['current_version'] ? $version_data[0]['current_version'] : "",
            "version_text"=>$version_data[0]['version_text'] ? $version_data[0]['version_text'] : "",
            "type"=> $version_data[0]['type'] ? $version_data[0]['type'] : "",
        );
     
     $stmt = $this->db->query("SELECT `id`, `name`,index_id, description,code FROM `adv_pos_category` where merchant_id='".$_POST['merchant_id']."' and parent_id=0 ORDER BY index_id ASC");
      
      $posItems = array();
      $package_data = $stmt->result_array();
      $mem = array();
      if (isset($package_data)) {
      foreach ($package_data as $each) {
        $package['id'] = $each['id'];
        $package['name'] = $each['name'];
        $package['description'] = $each['description'];
        $package['code'] = $each['code'];
        $mem[] = $package;

      }
    }
  
    $posItems = $mem;
      //pushing the array in response
      
      $status = parent::HTTP_OK;
            $response = ['status' => $status, 'posItems' => $posItems,'updateInfo' => $userdata4];
      
            
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function updateCategory_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
       $userdata = array();
        $someJSON = $this->input->post('rearrange');

          // $someJSON = '[{"code":"ANDROID-TEST-1595012038","description":"","id":165,"name":"Android test"},{"code":"TEST-1584906397","description":"Description","id":126,"name":"test"},{"code":"HELLO-1594895997","description":"N/A","id":162,"name":"hello"},{"code":"SQTESTER-1594896013","description":"N/A","id":164,"name":"sqtester"},{"code":"MURGA-1594896005","description":"N/A","id":163,"name":"murga"},{"code":"ACCESSORIES-1588849621","description":"Description","id":133,"name":"Accessories"}]';

  // Convert JSON string to Array
  $someArray = json_decode($someJSON, true);
  //print_r($someArray);        // Dump all data of the Array

  //$someArray = ...; // Replace ... with your PHP Array
  $i = 1; 
  foreach ($someArray as $key => $value) {
    //echo $value["id"] . ", " . $value["gender"] . "<br>";

    $stmt1 = $this->db->query("UPDATE  `adv_pos_category` set index_id='".$i++."'  where id='".$value["id"]."' and  merchant_id='".$merchant_id."'  ");
  }

  //echo $someArray[0]["name"]; // Access Array data

  // Convert JSON string to Object
  //$someObject = json_decode($someJSON);
  //print_r($someObject);      // Dump all data of the Object
  //echo $someObject[0]->name; 

       // $stmt1 = $this->db->query("UPDATE  `adv_pos_category` set index_id='".$id."'  where id='".$id."'  ");
       
       // $stmt = $this->db->query("SELECT `id`, `name`, description,code FROM `adv_pos_category` where merchant_id='".$_POST['merchant_id']."' and parent_id=0");
            
       //      $posItems = array();
       //      $package_data = $stmt->result_array();
       //      $mem = array();
       //      if (isset($package_data)) {
       //      foreach ($package_data as $each) {
       //          $package['id'] = $each['id'];
       //          $package['name'] = $each['name'];
       //          $package['description'] = $each['description'];
       //          $package['code'] = $each['code'];
       //          $mem[] = $package;

       //      }
       //  }

    
        //$posItems = $mem;
            //pushing the array in response
            
            
             $userdata = array();
	   
	   $stmt = $this->db->query("SELECT `id`, `name`,index_id, description,code FROM `adv_pos_category` where merchant_id='".$_POST['merchant_id']."' and parent_id=0 ORDER BY index_id ASC");
			
			$posItems = array();
			$package_data = $stmt->result_array();
			$mem = array();
			if (isset($package_data)) {
			foreach ($package_data as $each) {
				$package['id'] = $each['id'];
				$package['name'] = $each['name'];
				$package['description'] = $each['description'];
				$package['code'] = $each['code'];
				$mem[] = $package;

			}
		}
	
		$posItems = $mem;
            
            $status = parent::HTTP_OK;
           $response = ['status' => $status, 'posItems' => $posItems];
           
            
                        
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



public function deleteCategory_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
      
	if (isset($_POST['merchant_id'], $_POST['catID'])) {

			$stmt = $this->db->query("delete FROM `adv_pos_category`  where id='".$_POST['catID']."' and merchant_id='".$_POST['merchant_id']."' ");
			
			$stmt1 = $this->db->query("UPDATE  `adv_pos_item_main` set status='2'  where category_id='".$_POST['catID']."' and merchant_id='".$_POST['merchant_id']."' ");
			$stmt2 = $this->db->query("UPDATE  `adv_pos_item`  set status='2'   where category_id='".$_POST['catID']."' and merchant_id='".$_POST['merchant_id']."' ");
			

			if ($stmt) {
				
				$status = parent::HTTP_OK;
                 $response = ['status' => $status, 'successMsg' => 'category deleted'];
			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'category deleted'];
			}
			

		} else {
			
			$response = ['status' => '401', 'errorMsg' => 'Required params not available'];
		}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function newCategory_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
      
			try {

				if (isset($_POST['merchant_id'],$_POST['catName'],$_POST['catDesc'])) {
				    	
						
						$data = array(
                         'merchant_id'=>$_POST['merchant_id'],
                         'name'=>$_POST['catName'],
                         'description'=>$_POST['catDesc'],
                         'code' =>strtoupper(str_replace(" ","-",$_POST['catName'])."-".time()),
                         
						);
						$id = $this->admin_model->insert_data("adv_pos_category", $data);
						// $stmt1 = $this->db->query("UPDATE  `adv_pos_category` set index_id='".$id."'  where id='".$id."'  ");

            			
            
            			if (!empty($id)) {
            				
							$status = parent::HTTP_OK;
                            $response = ['status' => $status, 'successMsg' => 'New category created'];
            			} else {
            				
							$response = ['status' => '401', 'errorMsg' => 'Not able to create new category'];
            			}
            			
				    
				}
				else {
            			
						$response = ['status' => '401', 'errorMsg' => 'Required params not available'];
		            }
	    	}
	    	catch (Exception $e) {
				$response = ['status' => '401', 'errorMsg' => 'Update Fail!'];
			}
						
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



}