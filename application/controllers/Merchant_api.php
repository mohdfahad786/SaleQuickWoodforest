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
    
    public function get_me_data_post()
    {
        // Call the verification method and store the return value in the variable
        $data = $this->verify_request();
    
        // Send the return data as reponse
        $status = parent::HTTP_OK;
    
        $response = ['status' => $status, 'data' => $data];
    
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
        
        
         $userdata = array();
        

        //if ($username === $dummy_user['username'] && $password === $dummy_user['password']) {
        if (!empty($usr_result) && $usr_result['status']!='pending' && $usr_result['status']!='pending_signup')  {
             
            
            
             $query = $this->db->query("UPDATE `merchant` SET `login_status`=1 where id ='".$usr_result['id']."'");
             //$result = $query->result();
         
            
            // Create a token from the user data and send it as reponse
            $token = AUTHORIZATION::generateToken(['merchant_id' => $usr_result['id']]);
            // Prepare the response
            $status = parent::HTTP_OK;
            
            
             $user = array(
                
                    'id'=>$usr_result['id'] ? $usr_result['id'] : "",
                    'name'=>$usr_result['name'] ? $usr_result['name'] : "", 
                    'email'=>$usr_result['email'] ? $usr_result['email'] : "",
                    'connection_id'=>$usr_result['connection_id'] ? $usr_result['connection_id'] : "", 
                    'api_key'=>$usr_result['api_key'] ? $usr_result['api_key'] : "", 
                    'auth_code'=>$usr_result['auth_code'] ? $usr_result['auth_code'] : "",
                    'min_shop_supply'=>$usr_result['min_shop_supply'] ? $usr_result['min_shop_supply'] : "",
                    'max_shop_supply'=>$usr_result['max_shop_supply'] ? $usr_result['max_shop_supply'] : "", 
                    'shop_supply_percent'=>$usr_result['shop_supply_percent'] ? $usr_result['shop_supply_percent'] : "", 
                    'protractor_tax_percent'=>$usr_result['protractor_tax_percent'] ? $usr_result['protractor_tax_percent'] : "",
                    'b_code'=>$usr_result['b_code'] ? $usr_result['b_code'] : "", 
                    'd_code'=>$usr_result['d_code'] ? $usr_result['d_code'] : "", 
                    't_code'=>$usr_result['t_code'] ? $usr_result['t_code'] : "",
                    'a_code_name'=>$usr_result['a_code_name'] ? $usr_result['a_code_name'] : "", 
                    'a_code_value'=>$usr_result['a_code_value'] ? $usr_result['a_code_value'] : "", 
                    'a_min_value'=>$usr_result['a_min_value'] ? $usr_result['a_min_value'] : "",
                    'a_max_value'=>$usr_result['a_max_value'] ? $usr_result['a_max_value'] : "", 
                    'a_fixed'=>$usr_result['a_fixed'] ? $usr_result['a_fixed'] : "",
                    'c_code_name'=>$usr_result['c_code_name'] ? $usr_result['c_code_name'] : "", 
                    'c_code_value'=>$usr_result['c_code_value'] ? $usr_result['c_code_value'] : "", 
                    'c_min_value'=>$usr_result['c_min_value'] ? $usr_result['c_min_value'] : "",
                    'c_max_value'=>$usr_result['c_max_value'] ? $usr_result['c_max_value'] : "", 
                    'c_fixed'=>$usr_result['c_fixed'] ? $usr_result['c_fixed'] : "",
                    'e_code_name'=>$usr_result['e_code_name'] ? $usr_result['e_code_name'] : "", 
                    'e_code_value'=>$usr_result['e_code_value'] ? $usr_result['e_code_value'] : "", 
                    'e_min_value'=>$usr_result['e_min_value'] ? $usr_result['e_min_value'] : "",
                    'e_max_value'=>$usr_result['e_max_value'] ? $usr_result['e_max_value'] : "", 
                    'e_fixed'=>$usr_result['e_fixed'] ? $usr_result['e_fixed'] : "",
                    'f_code_name'=>$usr_result['f_code_name'] ? $usr_result['f_code_name'] : "", 
                    'f_code_value'=>$usr_result['f_code_value'] ? $usr_result['f_code_value'] : "", 
                    'f_min_value'=>$usr_result['f_min_value'] ? $usr_result['f_min_value'] : "",
                    'f_max_value'=>$usr_result['f_max_value'] ? $usr_result['f_max_value'] : "", 
                    'f_fixed'=>$usr_result['f_fixed'] ? $usr_result['f_fixed'] : "",
                    'g_code_name'=>$usr_result['g_code_name'] ? $usr_result['g_code_name'] : "", 
                    'g_code_value'=>$usr_result['g_code_value'] ? $usr_result['g_code_value'] : "", 
                    'g_min_value'=>$usr_result['g_min_value'] ? $usr_result['g_min_value'] : "",
                    'g_max_value'=>$usr_result['g_max_value'] ? $usr_result['g_max_value'] : "", 
                    'g_fixed'=>$usr_result['g_fixed'] ? $usr_result['g_fixed'] : "",
                    't1_code_name'=>$usr_result['t1_code_name'] ? $usr_result['t1_code_name'] : "", 
                    't1_code_value'=>$usr_result['t1_code_value'] ? $usr_result['t1_code_value'] : "", 
                    't1_min_value'=>$usr_result['t1_min_value'] ? $usr_result['t1_min_value'] : "",
                    't1_max_value'=>$usr_result['t1_max_value'] ? $usr_result['t1_max_value'] : "", 
                    't1_fixed'=>$usr_result['t1_fixed'] ? $usr_result['t1_fixed'] : "",
                    't2_code_name'=>$usr_result['t2_code_name'] ? $usr_result['t2_code_name'] : "", 
                    't2_code_value'=>$usr_result['t2_code_value'] ? $usr_result['t2_code_value'] : "", 
                    't2_min_value'=>$usr_result['t2_min_value'] ? $usr_result['t2_min_value'] : "",
                    't2_max_value'=>$usr_result['t2_max_value'] ? $usr_result['t2_max_value'] : "", 
                    't2_fixed'=>$usr_result['t2_fixed'] ? $usr_result['t2_fixed'] : "",
                    't3_code_name'=>$usr_result['t3_code_name'] ? $usr_result['t3_code_name'] : "", 
                    't3_code_value'=>$usr_result['t3_code_value'] ? $usr_result['t3_code_value'] : "", 
                    't3_min_value'=>$usr_result['t3_min_value'] ? $usr_result['t3_min_value'] : "",
                    't3_max_value'=>$usr_result['t3_max_value'] ? $usr_result['t3_max_value'] : "", 
                    't3_fixed'=>$usr_result['t3_fixed'] ? $usr_result['t3_fixed'] : "",
                    'url_cr'=>$usr_result['url_cr'] ? $usr_result['url_cr'] : "", 
                    'username_cr'=>$usr_result['username_cr'] ? $usr_result['username_cr'] : "",
                    'password_cr'=>$usr_result['password_cr'] ? $usr_result['password_cr'] : "", 
                    'api_key_cr'=>$usr_result['api_key_cr'] ? $usr_result['api_key_cr'] : "",
                    'account_id_cnp'=>$usr_result['account_id_cnp'] ? $usr_result['account_id_cnp'] : "", 
                    'acceptor_id_cnp'=>$usr_result['acceptor_id_cnp'] ? $usr_result['acceptor_id_cnp'] : "",
                    'account_token_cnp'=>$usr_result['account_token_cnp'] ? $usr_result['account_token_cnp'] : "", 
                    'application_id_cnp'=>$usr_result['application_id_cnp'] ? $usr_result['application_id_cnp'] : "",
                    'terminal_id_cnp'=>$usr_result['terminal_id'] ? $usr_result['terminal_id'] : "",
                    'sub_user_id'=>'0',
                    'protractor_status'=>$usr_result['protractor_status'] ? $usr_result['protractor_status'] : "",
                    'pos_type'=>$usr_result['pos_type'] ? $usr_result['pos_type'] : "",
                    'receipt_type'=>$usr_result['receipt_type'] ? $usr_result['receipt_type'] : "",
                    'tip'=>$usr_result['tip'] ? $usr_result['tip'] : "",
                    'invoice_type'=>$usr_result['invoice_type'] ? $usr_result['invoice_type'] : "",
                    'token'=>$token

                );

  
           $response = ['status' => $status,'successMsg' => 'successfull', 'UserData' => $user];

            //$response = ['status' => $status, 'token' => $token,'merchant_id' => $usr_result['id'],'login_status' => '1'];

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



    

        
public function logout_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $sub_merchant_id = $this->input->post('sub_merchant_id');
    if($merchant_id == $data->merchant_id)
    {
        if(!empty($sub_merchant_id))
        {
            $merchant_id = $sub_merchant_id;
        }
        else
        {
            $merchant_id = $merchant_id;
        }
        
       $userdata = array();
       $query = $this->db->query("UPDATE `merchant` SET `login_status`=0 where id ='".$merchant_id."'");

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' => 'Logout Successfully'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function all_pos_post()
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
        $package_data = $this->admin_model->data_get_where_1('pos', array('merchant_id' => $merchant_id));
        // print_r($package_data);die;
        $mem = array();
        $member = array();
        
//      foreach ($package_data as $each) {
//          //print_r($each['id']);
//          $userdata[] = $each;

//      }
        
            if (isset($package_data)) {
            foreach ($package_data as $each) {
            

                        $package['id'] = $each['id'];
                        $package['merchant_id'] = $each['merchant_id'];
                        $package['amount'] = $each['amount'];
                        $package['payment_id'] = $each['invoice_no'];
                        $package['owner_name']  = $each['name'];
                        $package['card_no'] = $each['card_no'];
                        $package['expiry_month'] = $each['expiry_month'];
                        $package['status'] = $each['status'];
                        $package['expiry_year'] = $each['expiry_year'];
                        $package['cvv']  = $each['cvv'];
                        $package['date_c'] = $each['date_c'];

                
                $mem[] = $package;
        

            }
        }
    
        $userdata = $mem;

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
        // print_r($package_data);die;
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

    $response = ['status' => $status, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function block_tax_post()
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
       
       $branch_info = array(
                'status' => 'block',
            );
        $this->admin_model->update_data('tax', $branch_info, array('id' => $tax_id,'merchant_id' => $merchant_id));
            
    

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

public function new_payment_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();

       $query = $this->db->query("SELECT ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = CURDATE() and merchant_id = '".$merchant_id."' ) as NewTotalOrders, ( SELECT count(id) as NewTotalOrders_p from pos where date_c = CURDATE() and merchant_id = '".$merchant_id."' ) as NewTotalOrders_p, ( SELECT count(id) as TotalOrders from customer_payment_request where status='confirm' and merchant_id = '".$merchant_id."' ) as TotalOrders,   ( SELECT count(id) as TotalOrders_p from pos where status='confirm' and merchant_id = '".$merchant_id."' ) as TotalOrders_p,
                 ( SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending' and merchant_id = '".$merchant_id."') as TotalpendingOrders,
                 ( SELECT count(id) as TotalpendingOrders_p from pos where status='pending' and merchant_id = '".$merchant_id."') as TotalpendingOrders_p, (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id ='".$merchant_id."') as TotalAmount , (SELECT sum(amount) as TotalAmount_p from pos where status='confirm' and merchant_id = '".$merchant_id."') as TotalAmount_p");
      

         if($query->num_rows() > 0) 
         {
         $result = $query->result_array();
        $user = array(
                    'NewTotalOrders' => $result[0]['NewTotalOrders'] + $result[0]['NewTotalOrders_p'],
                    'TotalOrders' => $result[0]['TotalOrders'] + $result[0]['TotalOrders_p'],
                    'TotalpendingOrders' => $result[0]['TotalpendingOrders'] + $result[0]['TotalpendingOrders_p'],
                    'TotalAmount' => $result[0]['TotalAmount'] + $result[0]['TotalAmount_p'],

                );

    // Send the return data as reponse
     $status = parent::HTTP_OK;
     $response = ['status' => $status,'successMsg' => 'successfull', 'UserData' => $user];
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


public function get_invoice_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();

       $query = $this->db->query(" SELECT ( SELECT count(id) as Totalinvoice from customer_payment_request where  merchant_id = '".$merchant_id."' ) as Totalinvoice,  ( SELECT name as Name from merchant where status='active' and id = '".$merchant_id."' ) as Name");
       

         if($query->num_rows() > 0) 
         {
         $result = $query->result_array();
         $names = strtoupper(substr($result[0]['Name'], 0, 3));
                $Totalinvoicee = $result[0]['Totalinvoice'] + 1;
                $user = array(

                    'invoice_no' => 'INV' . $names . '000' . $Totalinvoicee,

                );

    // Send the return data as reponse
     $status = parent::HTTP_OK;
     $response = ['status' => $status,'successMsg' => 'successfull', 'UserData' => $user];
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


public function get_logo_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();

       $query = $this->db->query("SELECT logo,address1,business_number,business_dba_name,batch_report_time,is_vts,PinNumber,emp_access FROM merchant WHERE id = '".$merchant_id."' ");
       

         if($query->num_rows() > 0) 
         {
         $result = $query->result_array();
        
                $user = array(

                    'logo' => 'https://salequick.com/logo/' . $result[0]['logo'],
                    'address' => $result[0]['address1'],
                    'phone' => $result[0]['business_number'],
                    'business_dba_name' => $result[0]['business_dba_name'],
                    'batch_report_time' => $result[0]['batch_report_time'],
                    'vts' => $result[0]['is_vts'],
                    'emp_access' => $result[0]['emp_access'],
                    'PinNumber' => $result[0]['PinNumber']
                );

    // Send the return data as reponse
     $status = parent::HTTP_OK;
     $response = ['status' => $status,'successMsg' => 'successfull', 'UserData' => $user];
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


public function get_tip_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();

       $query = $this->db->query("SELECT tip,tip_type,tip_val_1,tip_val_2,tip_val_3,tip_val_4 FROM merchant WHERE id = '".$merchant_id."' ");
       

         if($query->num_rows() > 0) 
         {
         $result = $query->result_array();
        
                $user = array(

                    'tip_status' => $result[0]['tip'],
                    'tip_type' => $result[0]['tip_type'],
                    'tip_val_1' => $result[0]['tip_val_1'] ? $result[0]['tip_val_1'] : "",
                    'tip_val_2' => $result[0]['tip_val_2'] ? $result[0]['tip_val_2'] : "",
                    'tip_val_3' => $result[0]['tip_val_3'] ? $result[0]['tip_val_3'] : "",
                    'tip_val_4' => $result[0]['tip_val_4'] ? $result[0]['tip_val_4'] : "",

                );

    // Send the return data as reponse
     $status = parent::HTTP_OK;
     $response = ['status' => $status,'successMsg' => 'successfull', 'UserData' => $user];
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

    $response = ['status' => $status, 'UserData' => $userdata3,'updateInfo' => $userdata4];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function get_tax_list_post2()
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
        $package_data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' =>'active'));
        // print_r($package_data);die;
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
       
      
   $userdata3 = array_merge($userdata2,$userdata);
       
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata3];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function add_tax_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
        $title = $this->input->post('title') ? $this->input->post('title') : "";
            $percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";
            
            $today1 = date("Ymdhms");
                $today2 = date("Y-m-d");
                $data = Array(
                    'title' => $title,
                    'percentage' => $percentage,
                    'merchant_id' => $merchant_id,
                    'status' => 'active',
                    'date_c' => $today2,
                );
                $id = $this->admin_model->insert_data("tax", $data);
                
     
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'successMsg' =>'Successfull'];
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
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
       $update = array("isUpdate"=>"0", "message"=>"", "title"=>"Warning!");
       //$package_data = $this->admin_model->get_data('tax',$merchant_id);
       $stmt = $this->db->query("SELECT id,merchant_id,name,email,mob_no,create_pay_permissions,edit_permissions,status FROM merchant WHERE   merchant_id ='".$merchant_id."' and user_type='employee' ");

        $package_data = $stmt->result_array();
        // print_r($package_data);die;
        $mem = array();
        $member = array();
        foreach ($package_data as $each) {
            $userdata[] = $each;

        }


    $query = $this->db->query(" SELECT count(id) as Totalnotification from notification where  merchant_id = '".$merchant_id."' and status='unread' ");
       
     $version_data = $query->result_array();

          $userdata4 = array(
            "count"=> $version_data[0]['Totalnotification']
        );

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata,'Update'=>$update,'Notification' => $userdata4];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function all_employee_post_2()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
      
       $update = array("isUpdate"=>"0", "message"=>"", "title"=>"Warning!");
       //$package_data = $this->admin_model->get_data('tax',$merchant_id);
       $stmt = $this->db->query("SELECT id,merchant_id,name,email,mob_no,create_pay_permissions,edit_permissions,status FROM merchant WHERE   merchant_id ='".$merchant_id."' and user_type='employee' ");

        $package_data = $stmt->result_array();
        // print_r($package_data);die;
        $mem = array();
        $member = array();
        foreach ($package_data as $each) {
            $userdata[] = $each;

        }

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status, 'UserData' => $userdata,'Update'=>$update];
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
    if($merchant_id == $data->merchant_id)
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
    if($merchant_id == $data->merchant_id)
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
            
        
            $package_data = $this->admin_model->get_search_merchant_pos_recurring_payment_request($start_date, $end_date,'confirm' , $merchant_id, 'customer_payment_request','recurring');
            

        $mem = array();
        $member = array();
        if (isset($package_data)) {
            foreach ($package_data as $each) {
            

                        $package['id'] = $each->id ? $each->id : "";
                        $package['p_id'] = "";
                        $package['name'] = $each->name ? $each->name : "";
                        $package['email_id'] = $each->email_id ? $each->email_id : "";
                        $package['amount'] = $each->amount ? $each->amount : "";
                        $package['title']  = $each->title ? $each->title : "";
                        $package['detail'] = $each->detail ? $each->detail : "";
                        $package['payment_id'] = $each->invoice_no ? $each->invoice_no : "";
                        $package['url']  = $each->url ? $each->url : "";
                        $package['sort_url'] = $each->sort_url ? $each->sort_url : "";
                        $package['payment_type'] = $each->payment_type ? $each->payment_type : "";
                        $package['status'] = $each->status ? $each->status : "";
                        $package['recurring_type'] = $each->recurring_type ? $each->recurring_type : "";
                        $package['recurring_count']  = $each->recurring_count ? $each->recurring_count : "";
                        $package['recurring_count_paid'] = $each->recurring_count_paid ? $each->recurring_count_paid : "";
                        $package['recurring_count_remain'] = $each->recurring_count_remain ? $each->recurring_count_remain : "";
                        $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                        $package['date_c'] = $each->date_c ? $each->date_c : "";
                    
                
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

public function dateTimeConvertTimeZone($Adate,$merchant_id) {
            if($Adate) {

                $stmt = $this->db->query("SELECT time_zone FROM merchant WHERE  id ='".$merchant_id."'  ");
    $package_data = $stmt->result_array();
    $time_zone_orignal = $package_data['0']['time_zone'];

                $time_Zone= $time_zone_orignal ?  $time_zone_orignal :'America/Chicago';
            
                    $datetime = new DateTime($Adate);
                    $la_time = new DateTimeZone($time_Zone);
                    $datetime->setTimezone($la_time);
                    $convertedDateTime=$datetime->format('Y-m-d H:i:s');
               
                
                
            } else {
                $convertedDateTime=$Adate;
            }
            return $convertedDateTime; 
        }


public  function  invoice_details_post() {
    $data = array();
    $package = array();
    // $merchant_id = $this->session->userdata('merchant_id');
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $invoice_no = $this->input->post('invoice_no');
    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
      
            $date = date('Y-m-d', strtotime('-30 days'));
            if ($merchant_id != '') {
                $this->db->where('merchant_id', $merchant_id);
            } 
            $this->db->where('payment_type', 'recurring');
            $this->db->where('invoice_no', $invoice_no);
            $this->db->where("payment_type", "recurring");
            //$this->db->where('recurring_next_pay_date >=', $date);
            $this->db->order_by("id", "desc");
            $mem=$this->db->get('customer_payment_request')->result_array(); 
//          print_r(count($data['mem'])); die();       
           // $data["curr_payment_date"] = $date; 
           // $data["end"] = date('Y-m-d');
           // $data["status"] = "";
             $recdata = array();
        $rmem = array();
         foreach ($mem as $package) {

            $card_info = !empty($package['card_no'])?('****'.substr($package['card_no'], -4)): 'xxxxxxxx';
            $typeOfCard=strtolower($package['card_type']);
             $amount2 = $package['amount'] - $package['late_fee'];
             $amount = number_format($amount2,2);
                    if($package['status']=='confirm' )
              { 
                $status='Completed'; 
            } elseif ($package['status']=='Chargeback_Confirm') {
                $status='Refund';
            
            } 
            elseif ($package['status']=='declined') {
                $status='Declined';
            
            } 
            elseif($package['recurring_pay_start_date'] >= date("Y-m-d")){
                 $status='Pending';
               
            } else { 
                 $status='Late';

            }
            // $th=$package['payment_date']  ? date("d M  Y", strtotime($package['payment_date']) ): date("d M  Y", strtotime($package['recurring_pay_start_date']));

             if($package['status']=='confirm' ||  $package['status']=='Chargeback_Confirm'  )  { $th= date("d M Y", strtotime($package['payment_date'])); } else{$th= date("d M Y", strtotime($package['recurring_pay_start_date'])); }
        $rpackage['id']=$package['id'] ? $package['id'] : "";
        $rpackage['invoice_no']=$package['invoice_no'] ? $package['invoice_no'] : "";
         if($package['status']=='Chargeback_Confirm'){

             $getInv = $this->db->query("SELECT * from refund where invoice_no ='".$invoice_no."'  and merchant_id='".$merchant_id."' ");
            $Invoicedata = $getInv->row_array();
    $rpackage['transaction_id']= $Invoicedata['transaction_id'] ? $Invoicedata['transaction_id'] : "";
} else
{
    $rpackage['transaction_id']=$package['transaction_id'] ? $package['transaction_id'] : "";

}
          $rpackage['card_info']= $card_info ? $card_info : "";
          $rpackage['type_card']= $typeOfCard ? $typeOfCard : "";
          $rpackage['receipt']=$package['email_id'] ? $package['email_id'] : "";
          $rpackage['amount']=$amount ? $amount : "";
          $rpackage['status']=$status ? $status :"";
          $rpackage['payment_date']=$th ? $th : "";
         
         $rmem[] = $rpackage;
         } 

    $userdata = $mem;
   
       $recdata= $rmem;
        $status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $recdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
       
    }

public  function  recurring_details_post() {
    $data = array();
    $package = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    $invoice_no = $this->input->post('invoice_no');
    if($merchant_id == $data->merchant_id)
    {
    $get_recurring_invoice=$this->admin_model->select_request_id_api('customer_payment_request',$id);

    $stmt555 = $this->db->query("SELECT  type FROM other_charges WHERE merchant_id ='".$merchant_id."' ");
    $getothercharge = $stmt555->result_array();

    $getRow_token=$this->db->query(" SELECT token_id FROM invoice_token WHERE invoice_no='".$invoice_no."' and merchant_id='".$merchant_id."' and status=1 " )->result_array(); 
                $token_id=$getRow_token[0]['token_id'] ? $getRow_token[0]['token_id'] :"0"; 

    $getRow_tokenvalue=$this->db->query(" SELECT token FROM token WHERE id='".$token_id."'  and status=1 " )->result_array(); 
        $tokenVal=$getRow_tokenvalue[0]['token']  ? $getRow_tokenvalue[0]['token'] :"0";

        $recurring_type1= $get_recurring_invoice[0]['recurring_type'] ? $get_recurring_invoice[0]['recurring_type'] : "";
         $recurring_type2= $get_recurring_invoice[0]['recurring_type_week'] ? $get_recurring_invoice[0]['recurring_type_week'] : "";
          $recurring_type3= $get_recurring_invoice[0]['recurring_type_month'] ? $get_recurring_invoice[0]['recurring_type_month'] : "";

        if($recurring_type1=='weekly'){
        $recurring_type=$recurring_type1.', '.$recurring_type2;
        
        }
        else if($recurring_type1=='monthly'){
       $recurring_type=$recurring_type1.', '.$recurring_type3;
        
        }
        else
        {
        $recurring_type=$recurring_type1;
       
        }


    // print_r($get_recurring_invoice[0]['id']);
        $userdata= array(

        'id'=>$get_recurring_invoice[0]['id'] ? $get_recurring_invoice[0]['id'] : "",
        'invoice_no'=>$get_recurring_invoice[0]['invoice_no'] ? $get_recurring_invoice[0]['invoice_no'] : "",
        'qb_online_invoice_id'=>$get_recurring_invoice[0]['qb_online_invoice_id'] ? $get_recurring_invoice[0]['qb_online_invoice_id'] : "0",
        'sub_merchant_id'=>$get_recurring_invoice[0]['sub_merchant_id'] ? $get_recurring_invoice[0]['sub_merchant_id'] : "0",
        'merchant_id'=>$get_recurring_invoice[0]['merchant_id'] ? $get_recurring_invoice[0]['merchant_id'] : "",
        'user_id'=>$get_recurring_invoice[0]['user_id'] ? $get_recurring_invoice[0]['user_id'] : "0",

       // 'auth_key'=>$get_recurring_invoice['auth_key'] ? $get_recurring_invoice['auth_key'] : "",
       // 'merchant_key'=>$get_recurring_invoice['merchant_key'] ? $get_recurring_invoice['merchant_key'] : "",
        'payment_id'=>$get_recurring_invoice[0]['payment_id'] ? $get_recurring_invoice[0]['payment_id'] : "0",
        'name'=>$get_recurring_invoice[0]['name'] ? $get_recurring_invoice[0]['name'] : "",
        'payment_id'=>$get_recurring_invoice[0]['payment_id'] ? $get_recurring_invoice[0]['payment_id'] : "",

        'l_name'=>$get_recurring_invoice[0]['l_name'] ? $get_recurring_invoice[0]['l_name'] : "",
        'email_id'=>$get_recurring_invoice[0]['email_id'] ? $get_recurring_invoice[0]['email_id'] : "",
        'mobile_no'=>$get_recurring_invoice[0]['mobile_no'] ? $get_recurring_invoice[0]['mobile_no'] : "",
        'amount'=>$get_recurring_invoice[0]['amount'] ? $get_recurring_invoice[0]['amount'] : "",
        'sub_total'=>$get_recurring_invoice[0]['sub_total'] ? $get_recurring_invoice[0]['sub_total'] : "",
        'tip_amount'=>$get_recurring_invoice[0]['tip_amount'] ? $get_recurring_invoice[0]['tip_amount'] : "",

        'tax'=>$get_recurring_invoice[0]['tax'] ? $get_recurring_invoice[0]['tax'] : "",
        'fee'=>$get_recurring_invoice[0]['fee'] ? $get_recurring_invoice[0]['fee'] : "",
        'other_charges'=>$get_recurring_invoice[0]['other_charges'] ? $get_recurring_invoice[0]['other_charges'] : "",
        'otherChargesName'=>$get_recurring_invoice[0]['otherChargesName'] ? $get_recurring_invoice[0]['otherChargesName'] : "",
        'p_ref_amount'=>$get_recurring_invoice[0]['p_ref_amount'] ? $get_recurring_invoice[0]['p_ref_amount'] : "0.00",
        's_fee'=>$get_recurring_invoice[0]['s_fee'] ? $get_recurring_invoice[0]['s_fee'] : "",

         'partial_refund'=>$get_recurring_invoice[0]['partial_refund'] ? $get_recurring_invoice[0]['partial_refund'] : "0",
        'title'=>$get_recurring_invoice[0]['title'] ? $get_recurring_invoice[0]['title'] : "",
        'detail'=>$get_recurring_invoice[0]['detail'] ? $get_recurring_invoice[0]['detail'] : "",
        'attachment'=>$get_recurring_invoice[0]['attachment'] ? $get_recurring_invoice[0]['attachment'] : "",
        'url'=>$get_recurring_invoice[0]['url'] ? $get_recurring_invoice[0]['url'] : "",
       // 'sort_url'=>$get_recurring_invoice['sort_url'] ? $get_recurring_invoice['sort_url'] : "",

       // 'success_url'=>$get_recurring_invoice['success_url'] ? $get_recurring_invoice['success_url'] : "0",
       // 'fail_url'=>$get_recurring_invoice['fail_url'] ? $get_recurring_invoice['fail_url'] : "",
        'payment_type'=>$get_recurring_invoice[0]['payment_type'] ? $get_recurring_invoice[0]['payment_type'] : "",
        'note'=>$get_recurring_invoice[0]['note'] ? $get_recurring_invoice[0]['note'] : "",
        'reference'=>$get_recurring_invoice[0]['reference'] ? $get_recurring_invoice[0]['reference'] : "0",
        'status'=>$get_recurring_invoice[0]['status'] ? $get_recurring_invoice[0]['status'] : "",
      'recurring_type'=>$recurring_type,
      'recurring_count'=>$get_recurring_invoice[0]['recurring_count'] ? $get_recurring_invoice[0]['recurring_count'] : "0",
      'recurring_count_paid'=>$get_recurring_invoice[0]['recurring_count_paid'] ? $get_recurring_invoice[0]['recurring_count_paid'] : "0",
      'recurring_count_remain'=>$get_recurring_invoice[0]['recurring_count_remain'] ? $get_recurring_invoice[0]['recurring_count_remain'] : "0",
      'no_of_invoice'=>$get_recurring_invoice[0]['no_of_invoice'] ? $get_recurring_invoice[0]['no_of_invoice'] : "",
      'recurring_pay_start_date'=>$get_recurring_invoice[0]['recurring_pay_start_date'] ? $get_recurring_invoice[0]['recurring_pay_start_date'] : "",


       'recurring_next_pay_date'=>$get_recurring_invoice[0]['recurring_next_pay_date'] ? $get_recurring_invoice[0]['recurring_next_pay_date'] : "0",
      'recurring_pay_type'=>$get_recurring_invoice[0]['recurring_pay_type'] ? $get_recurring_invoice[0]['recurring_pay_type'] : "0",
      'due_date'=>$get_recurring_invoice[0]['due_date'] ? $get_recurring_invoice[0]['due_date'] : "",
      'payment_date'=>$get_recurring_invoice[0]['payment_date'] ? $get_recurring_invoice[0]['payment_date'] : "",
      'recurring_payment'=>$get_recurring_invoice[0]['recurring_payment'] ? $get_recurring_invoice[0]['recurring_payment'] : "",
      'type'=>$get_recurring_invoice[0]['type'] ? $get_recurring_invoice[0]['type'] : "",

       'invoice_type'=>$get_recurring_invoice[0]['invoice_type'] ? $get_recurring_invoice[0]['invoice_type'] : "",
      'time1'=>$get_recurring_invoice[0]['time1'] ? $get_recurring_invoice[0]['time1'] : "",
      'day1'=>$get_recurring_invoice[0]['day1'] ? $get_recurring_invoice[0]['day1'] : "",
      'time_type'=>$get_recurring_invoice[0]['time_type'] ? $get_recurring_invoice[0]['time_type'] : "",
      'month'=>$get_recurring_invoice[0]['month'] ? $get_recurring_invoice[0]['month'] : "",
      'year'=>$get_recurring_invoice[0]['year'] ? $get_recurring_invoice[0]['year'] : "",

      // 'city'=>$get_recurring_invoice['city'] ? $get_recurring_invoice['city'] : "",
      // 'state'=>$get_recurring_invoice['state'] ? $get_recurring_invoice['state'] : "",
      // 'country'=>$get_recurring_invoice['country'] ? $get_recurring_invoice['country'] : "",
      // 'zipcode'=>$get_recurring_invoice['zipcode'] ? $get_recurring_invoice['zipcode'] : "",
      // 'address'=>$get_recurring_invoice['address'] ? $get_recurring_invoice['address'] : "",
      // 'op1'=>$get_recurring_invoice['op1'] ? $get_recurring_invoice['op1'] : "",

      // 'op2'=>$get_recurring_invoice['op2'] ? $get_recurring_invoice['op2'] : "",
      'sign'=>$get_recurring_invoice[0]['sign'] ? $get_recurring_invoice[0]['sign'] : "",
      //'ip_a'=>$get_recurring_invoice['ip_a'] ? $get_recurring_invoice['ip_a'] : "",
      'transaction_id'=>$get_recurring_invoice[0]['transaction_id'] ? $get_recurring_invoice[0]['transaction_id'] : "",
      'card_type'=>$get_recurring_invoice[0]['card_type'] ? $get_recurring_invoice[0]['card_type'] : "",
      'card_no'=>$get_recurring_invoice[0]['card_no'] ? $get_recurring_invoice[0]['card_no'] : "",


    'name_card'=>$get_recurring_invoice[0]['name_card'] ? $get_recurring_invoice[0]['name_card'] : "",
      'message'=>$get_recurring_invoice[0]['message'] ? $get_recurring_invoice[0]['message'] : "",
      'user_tye'=>$get_recurring_invoice[0]['user_tye'] ? $get_recurring_invoice[0]['user_tye'] : "",
      'address_status'=>$get_recurring_invoice[0]['address_status'] ? $get_recurring_invoice[0]['address_status'] : "",
      'zip_status'=>$get_recurring_invoice[0]['zip_status'] ? $get_recurring_invoice[0]['zip_status'] : "",
      'cvv_status'=>$get_recurring_invoice[0]['cvv_status'] ? $get_recurring_invoice[0]['cvv_status'] : "",

      //'color'=>$get_recurring_invoice['color'] ? $get_recurring_invoice['color'] : "",
      'date_c'=>$get_recurring_invoice[0]['date_c'] ? $get_recurring_invoice[0]['date_c'] : "",
      'add_date'=>$get_recurring_invoice[0]['add_date'] ? $get_recurring_invoice[0]['add_date'] : "",
      'user_type'=>$get_recurring_invoice[0]['user_type'] ? $get_recurring_invoice[0]['user_type'] : "",
      'order_type'=>$get_recurring_invoice[0]['order_type'] ? $get_recurring_invoice[0]['order_type'] : "",
      'late_fee'=>$get_recurring_invoice[0]['late_fee'] ? $get_recurring_invoice[0]['late_fee'] : "0",

'transaction_type'=>$get_recurring_invoice[0]['transaction_type'] ? $get_recurring_invoice[0]['transaction_type'] : "",
      'split_payment_id'=>$get_recurring_invoice[0]['split_payment_id'] ? $get_recurring_invoice[0]['split_payment_id'] : "",
      'api_payment'=>$get_recurring_invoice[0]['api_payment'] ? $get_recurring_invoice[0]['api_payment'] : "",
      'qb_status'=>$get_recurring_invoice[0]['qb_status'] ? $get_recurring_invoice[0]['qb_status'] : "",
      'payment_device'=>$get_recurring_invoice[0]['payment_device'] ? $get_recurring_invoice[0]['payment_device'] : "",
      'app_type'=>$get_recurring_invoice[0]['app_type'] ? $get_recurring_invoice[0]['app_type'] : "0",
      'other_charges_state'=>$get_recurring_invoice[0]['other_charges_state'] ? $get_recurring_invoice[0]['other_charges_state'] : "0",
      'othercharge_type'=>$getothercharge[0]['type'] ? $getothercharge[0]['type'] : "",
      'token'=>$get_recurring_invoice[0]['token'] ? $get_recurring_invoice[0]['token'] : "0",
      'tokenVal'=>$tokenVal ? $tokenVal : "0",


             );




$stmt55 = $this->db->query("SELECT  quantity, price, tax, tax_id, tax_per, total_amount,item_name FROM order_item WHERE p_id ='".$id."' ");
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
                
                $mem = array();
        $member = array();
               $i = 0;
                foreach ($item_name1 as $rowpp) {
                    if ($quantity1[$i] > 0) {
                        $price_bb = number_format($price1[$i], 2);
                        $tax_aa = $total_amount1[$i] - ($price1[$i] * $quantity1[$i]);
                        $tax_aaa = number_format($tax_aa, 2);
                        $total_aaa = number_format($total_amount1[$i], 2);
            
                        $package['itemsName'] = $item_name1[$i];
                        $package['quantity'] = $quantity1[$i];
                        $package['price'] =  $price_bb;
                        $package['taxRate'] = $tax_aaa;
                        $package['total']  = $total_aaa;

                
                $mem[] = $package;

    
        $itemslist = $mem;


                    }
                    $i++;
                }

        $status = parent::HTTP_OK;
       $response = ['status' => $status, 'UserData' => $userdata,'itemslist' => $itemslist];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
       
    }

public function all_customer_request_recurring_post() {
    $data = array();
    $package = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');
    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
         
            $status = $_POST['status'];   
            $package_data = $this->admin_model->get_package_details_customer_admin_api($status,$merchant_id,$start_limit,$limit);
        //print_r($package_data); die();
        
        $mem = array();
        $member = array();
        foreach ($package_data as $each) {

            $each->add_date=$this->dateTimeConvertTimeZone($each->add_date,$merchant_id);
            $each->due_date=$this->dateTimeConvertTimeZone($each->due_date,$merchant_id);
            $each->recurring_pay_start_date=$this->dateTimeConvertTimeZone($each->recurring_pay_start_date,$merchant_id);
            $each->recurring_next_pay_date=$this->dateTimeConvertTimeZone($each->recurring_next_pay_date,$merchant_id);
            $each->date_c=$this->dateTimeConvertTimeZone($each->date_c,$merchant_id);

            $package['id'] = $each->id;
            $package['payment_id'] = $each->invoice_no;
            $package['name'] = $each->name;
          
            $package['merchant_id'] = $each->merchant_id;
            $package['email'] = $each->email_id;
            $package['mobile'] = $each->mobile_no;
            $package['amount'] = $each->amount;
            $package['late_fee'] = $each->late_fee;
            $package['title'] = $each->title;
            $package['date'] = $each->add_date;
            $package['due_date'] = $each->due_date;
            $package['url'] = $each->url;
            $package['add_date'] = $each->add_date;
            $package['recurring_type'] = $each->recurring_type;
            $package['recurring_pay_type'] = $each->recurring_pay_type;
            $package['recurring_count'] = $each->recurring_count;
            $package['recurring_pay_start_date'] = $each->recurring_pay_start_date;
            $package['recurring_next_pay_date'] = $each->recurring_next_pay_date;
            $package['card_type'] = $each->card_type;
            $package['card_no'] = $each->card_no;
            $package['recurring_count_paid'] = $each->recurring_count_paid;
            $package['recurring_count_remain'] = $each->recurring_count_remain;
            $package['date_c'] = $each->date_c;
            $package['status'] = $each->status;
            $package['payment_type'] = $each->payment_type;
            $package['recurring_payment'] = $each->recurring_payment;
            $package['invoice_no'] = $each->invoice_no;

            $mem[] = $package;

        }

        //array_multisort(array_column($mem, 'recurring_pay_start_date'), SORT_DESC, $mem);
        array_multisort(array_column($mem, 'id'), SORT_DESC, $mem);
       // die();
       // $data['mem'] = $mem;
        $recdata = array();
        $rmem = array();
        foreach ($mem as $package) {
         $recurring_pay_start_date=$package['recurring_pay_start_date']; 
        $recurring_type=$package['recurring_type'];
        $recurring_pay_type=$package['recurring_pay_type'];
        $payment_type=$package['payment_type'];  //   recurring   or  straight 
        $recurring_count_remain=$package['recurring_count_remain'];
        $pay_status=$package['status'];
        $invoice_id=$package['payment_id'];
        $recurring_count=$package['recurring_count'];
        $invoice_no=$package['invoice_no'];
                             
                                $this->db->where('invoice_no',$invoice_id); 
                                $curentDate=date('Y-m-d');
                                $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE invoice_no='$invoice_id' AND ( `status`='$pay_status' OR `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
                                $df=$GetPrevResult->result_array(); 
                                $is_prev_paid=count($df);      

                                $this->db->where('invoice_no',$invoice_id); 
                                $GetFirstRecord=$this->db->query("SELECT recurring_pay_start_date FROM customer_payment_request WHERE  invoice_no='$invoice_id'  ORDER BY id ASC  LIMIT 0,1 "); 
                                $DGetFirstRecord=$GetFirstRecord->row_array();
                                
                                $merchant_id=$package["merchant_id"];
                                $GetlastRecord=$this->db->query("SELECT recurring_next_pay_date,recurring_count FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id'  ORDER BY id DESC  LIMIT 0,1 "); 
                                $lastRecord=$GetlastRecord->row();
                                

                                $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
                                $DGetAllpaidRecord=$GetAllpaidRecord->result();
                                $AllPaidRequest=count($DGetAllpaidRecord);

                                $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
                                $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
                                $AllUnPaidRequest=count($DGetAllUnpaidRecord);

                                $count++;

                                 if( $package['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($package['recurring_payment']=='stop' || $package['recurring_payment']=='complete' )  && $is_prev_paid <='0') { 
                                                $status='Complete';
                                            } else if( $package['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($package['recurring_payment']=='stop' || $package['recurring_payment']=='complete' ) ) {
                                                
                                                $status='Complete';
                                            } else if( $AllPaidRequest > 0  &&  $package['recurring_count'] != $AllPaidRequest && $AllUnPaidRequest == 0) {
                                               
                                                 $status='Good Standing';
                                            } else if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'){
                                                
                                                $status='Late';
                                            } else {

                                                $status='Pending';
                                            }


        $start_date=date("M d Y", strtotime($DGetFirstRecord['recurring_pay_start_date'])); 
        $next_payment_date=date("M d Y", strtotime($lastRecord->recurring_next_pay_date)); 
                                
                                    
    if($package['recurring_pay_type'] == '1'){ $payment_type1 = 'Auto'; } else { $payment_type1 = 'Manual'; }

  if($lastRecord->recurring_count < 0 ) {
                                                $end_date= '&infin;';

                                            } else {
                                                $recurring_count=$recurring_count-1; 
                                                switch($recurring_type) {
                                                    case 'daily':
                                                        $a=$recurring_count*1;
                                                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$a." days", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;

                                                    case 'weekly':
                                                        $a=$recurring_count*7;
                                                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$a."days", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;

                                                    case 'biweekly':
                                                        $a=$recurring_count*14; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime('+'.$a.' days', strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    case 'monthly':
                                                        $a=$recurring_count*1; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime('+'.$a.' month', strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    case 'quarterly':
                                                        $a=$recurring_count*3; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." month", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    case 'yearly':
                                                        $a=$recurring_count*12; 
                                                        $recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." month", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                
                                                    default :
                                                        $a=$recurring_count*1; 
                                                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$a." days", strtotime($lastRecord->recurring_next_pay_date)));
                                                    break;
                                                }
                                                $end_date= date("M d Y", strtotime($recurring_next_pay_date));
                                            }

                                            $recurringCount=(int)($lastRecord->recurring_count); 
                                            $upcomming=$recurringCount > 0 ? $recurringCount-$AllPaidRequest: '&infin;';
                                            $complete_upcoming=$AllPaidRequest .'|'.$upcomming;
       
       if( $package['recurring_count'] == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($package['recurring_payment']=='stop' || $package['recurring_payment']=='complete' )
           && $is_prev_paid <='0') {  $recurring = 'Done';
                              } 
    elseif($package['recurring_payment']=='start') { $recurring =  'Start'; }
     elseif($package['recurring_payment']=='stop') { $recurring =  'Stop'; }
     
        $amount1 = $package['amount'] - $package['late_fee'];
        $amount = number_format($amount1,2); 
         $rpackage['id'] = $package['id'] ? $package['id'] : "";
             $rpackage['name'] = ucfirst($package['name']) ? ucfirst($package['name']) : "";
             $rpackage['amount'] = $amount ? $amount : "";
             $rpackage['status'] = $status ? $status : "";
             $rpackage['start_date'] = $start_date ? $start_date : "";
             $rpackage['next_payment_date'] = $next_payment_date ? $next_payment_date : "";
             $rpackage['end_date'] = $end_date ? $end_date : "";
             $rpackage['complete'] = $AllPaidRequest ? $AllPaidRequest : "0";
             $rpackage['upcoming'] = $upcomming ? $upcomming : "0";
             $rpackage['payment_type'] = $payment_type1 ? $payment_type1 : "";
              $rpackage['recurring'] = $recurring ? $recurring : "";
               $rpackage['invoice_no'] = $invoice_no ? $invoice_no : "";

        
        $rmem[] = $rpackage;
    }

     $userdata = $mem;
     $recdata= $rmem;
        $status = parent::HTTP_OK;
    $response = ['status' => $status, 'UserData' => $recdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
       
    }


    public function stop_recurring_post() {
     $data = array();
     $package = array();
     $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    if($merchant_id == $data->merchant_id)
    {
    $this->admin_model->stop_recurring($id);
     $status = parent::HTTP_OK;
    $response = ['status' => $status, 'msg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
  }
  public function start_recurring_post() {
     $data = array();
     $package = array();
     $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    if($merchant_id == $data->merchant_id)
    {
    $this->admin_model->start_recurring($id);
    //echo json_encode(array("status" => TRUE));
     $status = parent::HTTP_OK;
    $response = ['status' => $status, 'msg' => 'Successful'];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
  }


public function all_confirm_payment_post() {
    $data = array();
    $partial = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
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
            
            $type = $_POST['type'];
            
            
            if ($type == '' or $type == 'straight') {

                $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and payment_type='straight' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <= '".$end."' order by id desc  ");
            } elseif ($type == 'recur') {

                $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and payment_type='recurring'  and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <= '".$end."' order by id desc  ");
                
                // $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM recurring_payment WHERE   merchant_id ='".$merchant_id."' and status='confirm' and date_c >='".$start."' and date_c <='".$end."' order by id desc ");

            } elseif ($type == 'pos') {
                $stmt = $this->db->query("SELECT id,name,email_id,sum(p_ref_amount) as p_ref_amount,sum(amount) as amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' group by invoice_no order by id desc ");

            }
            elseif ($type == 'vts') {
                $stmt = $this->db->query("SELECT id,name,email_id,sum(p_ref_amount) as p_ref_amount,sum(amount) as amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='true' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' group by invoice_no order by id desc ");

            }
            $package_data = $stmt->result_array();
            //print_r($package_data);
            
        
            
    
    
        $mem = array();
       
        $member = array();
    
                    foreach ($package_data as $each) {
                     $remain_amount_1=   $each['amount'] - $each['p_ref_amount'];
                    $remain_amount = number_format($remain_amount_1,2);
 $memm = array();
                    $stmt_p = $this->db->query("SELECT id,amount,date_c,transaction_id FROM refund WHERE   merchant_id ='".$merchant_id."' and invoice_no='".$each['invoice_no']."' ");
            $package_data_partial = $stmt_p->result_array();
            if (count($package_data_partial)>0) {
            foreach ($package_data_partial as $each_partial) {

                $partial = array(
                            'id' => $each_partial['id'] ? $each_partial['id'] : "",
                            'amount' => $each_partial['amount'] ? $each_partial['amount'] : "",
                            'transaction_id' => $each_partial['transaction_id'] ? $each_partial['transaction_id'] : "",
                            'date_c' => $each_partial['date_c'] ? $each_partial['date_c'] : "",

                        );
                $memm[] = $partial;
            }
        }
            $partialdata = $memm;
                
                    if ($each['mobile_no'] != '') {
                        
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['mobile_no'] ? $each['mobile_no'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) ? $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "",
                            'status' => "",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            'partial_refund' =>$partialdata,
                           'card_type' =>$each['card_type'] ? $each['card_type'] : "NA"
                            
                        

                        );
                    } else {
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['email_id'] ? $each['email_id'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) ? $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "",
                            'status' => "",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            'partial_refund' =>$partialdata,
                            'card_type' =>$each['card_type'] ? $each['card_type'] : "NA"

                        );
                    }
                    $mem[] = $package;
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

public function all_confirm_payment_new_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
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
            
            $type = $_POST['type'];
            
            
            if ($type == '' or $type == 'straight') {

                $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <= '".$end."' order by id desc  ");
            } elseif ($type == 'recur') {
                $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type FROM recurring_payment WHERE   merchant_id ='".$merchant_id."' and status='confirm' and date_c >='".$start."' and date_c <='".$end."' order by id desc ");

            } elseif ($type == 'pos') {
                $stmt = $this->db->query("SELECT id,name,email_id,sum(p_ref_amount) as p_ref_amount,sum(amount) as amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type FROM pos WHERE   merchant_id ='".$merchant_id."' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' group by invoice_no order by id desc ");

            }
            $package_data = $stmt->result_array();
            //print_r($package_data);
            
            
//          if ($type == '' or $type == 'straight') {
//               $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'customer_payment_request');
//          } elseif ($type == 'recur') {
//               $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'recurring_payment');

//          } elseif ($type == 'pos') {
//          $package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'confirm' , $merchant_id, 'pos');

//          }
            
    
    
        $mem = array();
        $member = array();
    //  if (isset($package_data)) {
//          foreach ($package_data as $each) {
//              if ($each->receipt_type == null) // no-cepeipt
//              {
//                  if ($each->mobile_no && $each->email_id) {
//                      $repeiptmethod = $each->mobile_no;
//                  } else if ($each->mobile_no != "" && $each->email_id == "") {
//                      $repeiptmethod = $each->mobile_no;
//                  } else if ($each->mobile_no == "" && $each->email_id != "") {
//                      $repeiptmethod = $each->email_id;
//                  } else {
//                      $repeiptmethod = 'no-receipt';
//                  }

//              } else if ($each->receipt_type == 'no-cepeipt') {
//                  $repeiptmethod = 'no-receipt';
//              } else {
//                  $repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
//              }
                
                

//              $package['id'] = $each->id ? $each->id : "";
//              $package['p_id'] = "";
//              $package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
//              $package['name'] = $each->name ? $each->name : "";
//              $package['email_id'] = $each->email_id ? $each->email_id : "";
//              $package['amount'] = $each->amount ? $each->amount : "";
//              $package['title']  = $each->title ? $each->title : "";
//              $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
//              $package['detail'] = $each->detail ? $each->detail : "";
//              $package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
//              $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
//              $package['date_c'] = $each->add_date ? $each->add_date : "";
//              $package['reference'] = $each->reference ? $each->reference : "";
//              $package['due_date'] = $each->due_date ? $each->due_date : "";
//              $package['status'] = "";
                
                
//              $mem[] = $package;
        

//          }
        //}
        
                    foreach ($package_data as $each) {
                     $remain_amount_1=   $each['amount'] - $each['p_ref_amount'];
                    $remain_amount = number_format($remain_amount_1,2);
                
                    if ($each['mobile_no'] != '') {
                        
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['mobile_no'] ? $each['mobile_no'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $each['add_date'] ? $each['add_date'] : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "",
                            'status' => "",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            
                        

                        );
                    } else {
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['email_id'] ? $each['email_id'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $each['add_date'] ? $each['add_date'] : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "",
                            'status' => "",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",

                        );
                    }
                    $mem[] = $package;
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

public function all_late_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $late_end =  date("Y-m-d");
    if($merchant_id == $data->merchant_id)
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
              $package_data = $this->admin_model->get_search_merchant_pos_late($start_date, $end_date,'pending', $merchant_id, 'customer_payment_request',$late_end);
            } elseif ($type == 'recur') {
                 $package_data = $this->admin_model->get_search_merchant_pos_late($start_date, $end_date,'pending', $merchant_id, 'recurring_payment',$late_end);

            } elseif ($type == 'pos') {
            $package_data = $this->admin_model->get_search_merchant_pos_late($start_date, $end_date,'pending', $merchant_id, 'pos',$late_end);

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
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) ? $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                

                
                
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

public function all_pending_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
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

                 $package['otherChargeAmount'] = $each->other_charges ? $each->other_charges : "";
                  $package['otherChargeName'] = $each->otherChargesName ? $each->otherChargesName : "";
                   $package['taxAmount'] = $each->tax ? $each->tax : "";

                $package['title']  = $each->title ? $each->title : "";
                $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
                $package['detail'] = $each->detail ? $each->detail : "";
                $package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
                 $package['refrence_id'] = $each->payment_id ? $each->payment_id : "";

                $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) ? $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                
                
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

public function all_declined_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
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
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) ? $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                
                
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


public function all_refund_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
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
              //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'customer_payment_request');

               $package_data = $this->admin_model->get_search_refund_data('customer_payment_request', $merchant_id, $start_date, $end_date,'Chargeback_Confirm');
            } elseif ($type == 'recur') {
                 //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'recurring_payment');
                 $package_data = $this->admin_model->get_search_refund_data('recurring_payment', $merchant_id, $start_date, $end_date,'Chargeback_Confirm');

            } elseif ($type == 'pos') {
            //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'pos');
              $package_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date,'Chargeback_Confirm');

            }
            elseif ($type == 'vts') {
            //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'pos');
              $package_data = $this->admin_model->get_search_refund_data_vts('pos', $merchant_id, $start_date, $end_date,'Chargeback_Confirm');

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
                $package['amount'] = $each->refund_amount ? $each->refund_amount : "";
                $package['title']  = $each->title ? $each->title : "";
                $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
                $package['detail'] = $each->detail ? $each->detail : "";
                $package['payment_id'] = $each->refund_transaction ? $each->refund_transaction : "";
                $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->refund_dt,$merchant_id) ? $this->dateTimeConvertTimeZone($each->refund_dt,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                
                
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



public function get_profile_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
       $userdata = array();
       $package_data = $this->admin_model->data_get_where_1('merchant', array('id' => $merchant_id));
    
        $mem = array();
        
        
            if (isset($package_data)) {
            foreach ($package_data as $each) {
            
                    $package['name'] = $each['name'];
                    $package['l_name'] = $each['l_name'];
                    $package['business_name'] = $each['business_name'];
                    $package['business_number'] = $each['business_number'];
                    $package['year_business'] = $each['year_business'];
                    $package['auth_key'] = $each['ien_no'];
                    $package['email'] = $each['email'];
                    $package['mob_no'] = $each['mob_no'];
                    $package['address1'] = $each['address1'];
                    $package['address2'] = $each['address2'];
                    $package['website'] = $each['website'];
                    $package['country'] = $each['country'];
                    $package['state'] = $each['state'];
                    $package['city'] = $each['city'];
                    $package['description'] = $each['description'];
                    $package['mi'] = $each['mi'];
                    $package['pin_code'] = $each['pin_code'];
                    $package['status'] = $each['status'];
                    $package['logo'] = $each['logo'];
                    $package['logo'] = 'https://salequick.com/logo/' .$each['logo'];

                        $package['id'] = $each['id'];
                        

                
                $mem[] = $package;
        

            }
        }
    
        $userdata = $mem;

    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status,'successMsg' => 'successfull', 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



public function add_user_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mob_no = $_POST['mobile_no'];
            $address = $_POST['address'];
            $domain = $_POST['domain'];

            $stmt1 = $this->db->query("SELECT auth_key FROM merchant WHERE id ='".$merchant_id."' ");
            $getDashboardData = $stmt1->result_array();
            $auth_keyy = $getDashboardData[0]['auth_key'];
            $m_auth = $auth_keyy;

            $today2 = date("Y-m-d");
            $m_auth_key = $m_auth;
            $auth_key = 'SL_' . date("Ymdhms");

            $stmt = $this->db->query("SELECT domain FROM user WHERE domain ='".$domain."' ");
            $getDashboard = $stmt->result_array();

            if (!empty($getDashboard[0]['domain'])) {
                $response['error'] = true;
                $response['errorMsg'] = 'Domain Alredy in use';
            } else {


                $data = array(
                             'merchant_id' =>$merchant_id,
                             'm_auth_key' =>$m_auth_key, 
                             'auth_key' =>$auth_key,
                             'name' =>$name,
                             'email' =>$email,
                             'mob_no' =>$mob_no,
                             'address1' =>$address, 
                             'client_transaction_id' =>$client_transaction_id,
                             'card_type' =>$card_type,
                             'status' =>'active',
                             'domain' =>'domain', 
                             'date_c' =>$today2,
                            
                         );
            $stmt = $this->admin_model->insert_data("user", $data);


                if (!empty($stmt)) {

                    $status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Successfull'];
                } else {
                    
                    $response = ['status' => '401', 'errorMsg' => 'Fail!'];
                }
            }
                        
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function add_employee_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
      
            $name = $_POST['name'];
            $l_name = $_POST['l_name'];
            $email = $_POST['email'];
            $mob_no = $_POST['mobile_no'];

            $create_pay_permissions = $_POST['create_pay_permissions'];
            $edit_permissions = $_POST['edit_permissions'];
            $password1 = $_POST['password'];

            $password = $this->my_encrypt($password1, 'e');
            $today2 = date("Y-m-d");

            $stmt = $this->db->query("SELECT name FROM merchant WHERE email ='".$email."' ");
            $getDashboard = $stmt->result_array();


            if (!empty($getDashboard[0]['name'])) {
                
                $response = ['status' => '401', 'errorMsg' => 'Email id Alredy in use!'];
            } else {

                
                $data = array(
                             'merchant_id' =>$merchant_id,
                             'user_type' =>'employee', 
                             'l_name' =>$l_name,
                             'name' =>$name,
                             'email' =>$email,
                             'mob_no' =>$mob_no,
                             'password' =>$password, 
                             'view_permissions' =>'1',
                             'create_pay_permissions' =>$create_pay_permissions,
                             'edit_permissions' =>$edit_permissions,
                             'status' =>'active',
                             'date_c' =>$today2,
                            
                         );
            $stmt = $this->admin_model->insert_data("merchant", $data);


            if (!empty($stmt)) {

                    $status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Successfull'];
                } else {
                    
                    $response = ['status' => '401', 'errorMsg' => 'Fail!'];
                }
            }

                        
    }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


public function update_employee_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
   $name = $_POST['name'];
            $edit_permissions = $_POST['edit_permissions'];
            $create_pay_permissions = $_POST['create_pay_permissions'];
            $status = $_POST['status'];
            $merchant_id = $_POST['employee_id'];
            $mobile_no = $_POST['mobile_no'];
            $email = $_POST['email'];
            $password1 = $_POST['password'];

            $today2 = date("Y-m-d");
            $today3 = date("Y-m-d H:i:s");

            if (!empty($_POST['password'])) {
                $password = $this->my_encrypt($password1, 'e');
                $stmt = $this->db->query("UPDATE  merchant set name ='".$name."', mob_no ='".$mobile_no."', email = '".$email."', create_pay_permissions ='".$create_pay_permissions."' , edit_permissions = '".$edit_permissions."' , status = '".$status."' , password = '".$password."' where id = '".$merchant_id."' ");

            
            } else {

                $stmt = $this->db->query("UPDATE  merchant set name ='".$name."', mob_no = '".$mobile_no."', email = '".$email."', create_pay_permissions = '".$create_pay_permissions."' , edit_permissions = '".$edit_permissions."' , status = '".$status."'  where id = '".$merchant_id."'");

            }

            if ($stmt) {

                $status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];
            } else {
                
                $response = ['status' => '401', 'errorMsg' => 'Fail'];
            }

    $this->response($response, $status);
}



}

/* End of file Api.php */