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
class Login_api extends REST_Controller {
    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->library('email');
        date_default_timezone_set("America/Chicago");

            
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

public function forgot_pass_post()
{
    $status = 200;
$response = ['status' => 200, 'successMsg' => 'Password Update successfull'];
$this->response($response, $status);
}
public function login_post()
 {
    

//if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['ip']) ){
 
  
          
 $email = $_POST['username'];
 $password1 = ($_POST['password']); 
 $password = $this->my_encrypt( $password1 , 'e' );
 $ip = $_POST['ip'];
  
 $userdata = array();
 $stmt_a = $this->db->query("SELECT id,merchant_id,user_type,url_cr, username_cr, password_cr, api_key_cr,login_status  FROM merchant WHERE email ='".$email."' AND password ='".$password."' ");

 $getDetail = $stmt_a->result_array();

    if(!empty($getDetail[0]['id'])){
        
    // Create a token from the user data and send it as reponse
        
    // Prepare the response
            
   //print_r($getDetail);
   $user_type = $getDetail[0]['user_type'] ? $getDetail[0]['user_type'] : "";
     $url_cr_c = $getDetail[0]['url_cr'] ? $getDetail[0]['url_cr'] : "";
    $username_cr_c = $getDetail[0]['username_cr'] ? $getDetail[0]['username_cr'] : "";
    $password_cr_c = $getDetail[0]['password_cr'] ? $getDetail[0]['password_cr'] : "";
    $api_key_cr_c = $getDetail[0]['api_key_cr'] ? $getDetail[0]['api_key_cr'] : "";
     $s_id = $getDetail[0]['id'] ? $getDetail[0]['id'] : "";
  $merchant_id = $getDetail[0]['merchant_id'] ? $getDetail[0]['merchant_id']: "";
    $login_status = $getDetail[0]['login_status'] ? $getDetail[0]['login_status'] : "";
    //$login_status==0
    if(1==1){
        $stmt_L = $this->db->query("UPDATE `merchant` SET `login_status`=1 where id ='".$s_id."' ");
        
     if($user_type=='merchant'){
         
 
 $stmt = $this->db->query("SELECT id, name, email,connection_id,api_key,auth_code,min_shop_supply,max_shop_supply,shop_supply_percent,protractor_tax_percent,b_code,d_code,t_code ,a_code_name, a_code_value, a_min_value,
 a_max_value, a_fixed,c_code_name, c_code_value, c_min_value, c_max_value, c_fixed, e_code_name, e_code_value, e_min_value, e_max_value, e_fixed, f_code_name, f_code_value, f_min_value, f_max_value, f_fixed, g_code_name,
 g_code_value, g_min_value, g_max_value, g_fixed,t1_code_name, t1_code_value, t2_code_name, t2_code_value,t1_min_value, t1_max_value, t1_fixed, t2_min_value, t2_max_value, t2_fixed, t3_code_name, t3_code_value,
 t3_min_value,t3_max_value, t3_fixed, url_cr, username_cr, password_cr, api_key_cr,account_id_cnp,acceptor_id_cnp,account_token_cnp,application_id_cnp,terminal_id,protractor_status, pos_type, receipt_type,tip,invoice_type,payroc,processor_id 
FROM merchant WHERE email ='".$email."' AND password = '".$password."' ");

$getDetailUser = $stmt->result_array();

 
 if(!empty($getDetailUser[0]['id'])){
 
$token = AUTHORIZATION::generateToken(['merchant_id' => $getDetailUser[0]['id']]);
 
 $user = array(
 'id'=>$getDetailUser[0]['id'] ? $getDetailUser[0]['id'] : "",
 'name'=>$getDetailUser[0]['name'] ? $getDetailUser[0]['name'] : "", 
 'email'=>$getDetailUser[0]['email'] ? $getDetailUser[0]['email'] : "",
 'connection_id'=>$getDetailUser[0]['connection_id'] ? $getDetailUser[0]['connection_id'] : "", 
 'api_key'=>$getDetailUser[0]['api_key'] ? $getDetailUser[0]['api_key'] : "", 
 'auth_code'=>$getDetailUser[0]['auth_code'] ? getDetailUser[0]['auth_code'] : "",
 'min_shop_supply'=>$getDetailUser[0]['min_shop_supply'] ? $getDetailUser[0]['min_shop_supply'] : "",
 'max_shop_supply'=>$getDetailUser[0]['max_shop_supply'] ? $getDetailUser[0]['max_shop_supply'] : "", 
 'shop_supply_percent'=>$getDetailUser[0]['shop_supply_percent'] ? $getDetailUser[0]['shop_supply_percent'] : "", 
 'protractor_tax_percent'=>$getDetailUser[0]['protractor_tax_percent'] ? $getDetailUser[0]['protractor_tax_percent'] : "",
 'b_code'=>$getDetailUser[0]['b_code'] ? $getDetailUser[0]['b_code'] : "", 
 'd_code'=>$getDetailUser[0]['d_code'] ? $getDetailUser[0]['d_code'] : "", 
 't_code'=>$getDetailUser[0]['t_code'] ? $getDetailUser[0]['t_code'] : "",
 'a_code_name'=>$getDetailUser[0]['a_code_name'] ? $getDetailUser[0]['a_code_name'] : "", 
 'a_code_value'=>$getDetailUser[0]['a_code_value'] ? $getDetailUser[0]['a_code_value'] : "", 
 'a_min_value'=>$getDetailUser[0]['a_min_value'] ? $getDetailUser[0]['a_min_value'] : "",
 'a_max_value'=>$getDetailUser[0]['a_max_value'] ? $getDetailUser[0]['a_max_value'] : "", 
 'a_fixed'=>$getDetailUser[0]['a_fixed'] ? $getDetailUser[0]['a_fixed'] : "",
 'c_code_name'=>$getDetailUser[0]['c_code_name'] ? $getDetailUser[0]['c_code_name'] : "", 
 'c_code_value'=>$getDetailUser[0]['c_code_value'] ? $getDetailUser[0]['c_code_value'] : "", 
 'c_min_value'=>$getDetailUser[0]['c_min_value'] ? $getDetailUser[0]['c_min_value'] : "",
 'c_max_value'=>$getDetailUser[0]['c_max_value'] ? $getDetailUser[0]['c_max_value'] : "", 
 'c_fixed'=>$getDetailUser[0]['c_fixed'] ? $getDetailUser[0]['c_fixed'] : "",
 'e_code_name'=>$getDetailUser[0]['e_code_name'] ? $getDetailUser[0]['e_code_name'] : "", 
 'e_code_value'=>$getDetailUser[0]['e_code_value'] ? $getDetailUser[0]['e_code_value'] : "", 
 'e_min_value'=>$getDetailUser[0]['e_min_value'] ? $getDetailUser[0]['e_min_value'] : "",
 'e_max_value'=>$getDetailUser[0]['e_max_value'] ? $getDetailUser[0]['e_max_value'] : "", 
 'e_fixed'=>$getDetailUser[0]['e_fixed'] ? $getDetailUser[0]['e_fixed'] : "",
 'f_code_name'=>$getDetailUser[0]['f_code_name'] ? $getDetailUser[0]['f_code_name'] : "", 
 'f_code_value'=>$getDetailUser[0]['f_code_value'] ? $getDetailUser[0]['f_code_value'] : "", 
 'f_min_value'=>$getDetailUser[0]['f_min_value'] ? $getDetailUser[0]['f_min_value'] : "",
 'f_max_value'=>$getDetailUser[0]['f_max_value'] ? $getDetailUser[0]['f_max_value'] : "", 
 'f_fixed'=>$getDetailUser[0]['f_fixed'] ? $getDetailUser[0]['f_fixed'] : "",
 'g_code_name'=>$getDetailUser[0]['g_code_name'] ? $getDetailUser[0]['g_code_name'] : "", 
 'g_code_value'=>$getDetailUser[0]['g_code_value'] ? $getDetailUser[0]['g_code_value'] : "", 
 'g_min_value'=>$getDetailUser[0]['g_min_value'] ? $getDetailUser[0]['g_min_value'] : "",
 'g_max_value'=>$getDetailUser[0]['g_max_value'] ? $getDetailUser[0]['g_max_value'] : "", 
 'g_fixed'=>$getDetailUser[0]['g_fixed'] ? $getDetailUser[0]['g_fixed'] : "",
 't1_code_name'=>$getDetailUser[0]['t1_code_name'] ? $getDetailUser[0]['t1_code_name'] : "", 
 't1_code_value'=>$getDetailUser[0]['t1_code_value'] ? $getDetailUser[0]['t1_code_value'] : "", 
 't1_min_value'=>$getDetailUser[0]['t1_min_value'] ? $getDetailUser[0]['t1_min_value'] : "",
 't1_max_value'=>$getDetailUser[0]['t1_max_value'] ? $getDetailUser[0]['t1_max_value'] : "", 
 't1_fixed'=>$getDetailUser[0]['t1_fixed'] ? $getDetailUser[0]['t1_fixed'] : "",
 't2_code_name'=>$getDetailUser[0]['t2_code_name'] ? $getDetailUser[0]['t2_code_name'] : "", 
 't2_code_value'=>$getDetailUser[0]['t2_code_value'] ? $getDetailUser[0]['t2_code_value'] : "", 
 't2_min_value'=>$getDetailUser[0]['t2_min_value'] ? $getDetailUser[0]['t2_min_value'] : "",
 't2_max_value'=>$getDetailUser[0]['t2_max_value'] ? $getDetailUser[0]['t2_max_value'] : "", 
 't2_fixed'=>$getDetailUser[0]['t2_fixed'] ? $getDetailUser[0]['t2_fixed'] : "",
 't3_code_name'=>$getDetailUser[0]['t3_code_name'] ? $getDetailUser[0]['t3_code_name'] : "", 
 't3_code_value'=>$getDetailUser[0]['t3_code_value'] ? $getDetailUser[0]['t3_code_value'] : "", 
 't3_min_value'=>$getDetailUser[0]['t3_min_value'] ? $getDetailUser[0]['t3_min_value'] : "",
 't3_max_value'=>$getDetailUser[0]['t3_max_value'] ? $getDetailUser[0]['t3_max_value'] : "", 
 't3_fixed'=>$getDetailUser[0]['t3_fixed'] ? $getDetailUser[0]['t3_fixed'] : "",
 'url_cr'=>$getDetailUser[0]['url_cr'] ? $getDetailUser[0]['url_cr'] : "", 
 'username_cr'=>$getDetailUser[0]['username_cr'] ? $getDetailUser[0]['username_cr'] : "",
 'password_cr'=>$getDetailUser[0]['password_cr'] ? $getDetailUser[0]['password_cr'] :  "", 
 'api_key_cr'=>$getDetailUser[0]['api_key_cr'] ? $getDetailUser[0]['api_key_cr'] : "",
 'account_id_cnp'=>$getDetailUser[0]['account_id_cnp'] ? $getDetailUser[0]['account_id_cnp'] : "",
 'acceptor_id_cnp'=>$getDetailUser[0]['acceptor_id_cnp'] ? $getDetailUser[0]['acceptor_id_cnp'] : "",
 'account_token_cnp'=>$getDetailUser[0]['account_token_cnp'] ? $getDetailUser[0]['account_token_cnp'] : "", 
 'application_id_cnp'=>$getDetailUser[0]['application_id_cnp'] ? $getDetailUser[0]['application_id_cnp'] : "",
  'terminal_id_cnp'=>$getDetailUser[0]['terminal_id'] ? $getDetailUser[0]['terminal_id'] : "",
 'sub_user_id'=>'0',
 'protractor_status'=>$getDetailUser[0]['protractor_status'] ? $getDetailUser[0]['protractor_status'] : "",
 'pos_type'=>$getDetailUser[0]['pos_type'] ? $getDetailUser[0]['pos_type'] : "",
 'receipt_type'=>$getDetailUser[0]['receipt_type'] ? $getDetailUser[0]['receipt_type'] : "",
 'tip'=>$getDetailUser[0]['tip'] ? $getDetailUser[0]['tip'] : "",
 'invoice_type'=>$getDetailUser[0]['invoice_type'] ? $getDetailUser[0]['invoice_type'] : "",
 'token'=>$token,
 'POS_Processor_id'=>$getDetailUser[0]['processor_id'] ? $getDetailUser[0]['processor_id'] : "NA",
 'payroc_apikey'=>'fcnpBA9a579qp7QA2wMpCtcgGB453Q43'
 );
 
  //print_r($user);
 
$stmt = $this->db->query("INSERT INTO login_detail (user_type,status, user_id, ip) VALUES ('merchant','true', '".$getDetailUser[0]['id']."', '".$ip."')");

$status = parent::HTTP_OK;
$response = ['status' => $status, 'successMsg' => 'Login successfull', 'UserData' => $user];
 
 }
 
 else{
     
    $stmt = $this->db->query("INSERT INTO login_detail (user_type,status, ip) VALUES ('merchant','false', '".$ip."')");
$status = 200;
$response = ['status' => '200', 'errorMsg' => 'Invalid username or password'];
 }
 
     }
     
     elseif($user_type=='employee')
     {
         
         $stmt = $this->db->query("SELECT id, name, email,connection_id,api_key,auth_code,min_shop_supply,max_shop_supply,shop_supply_percent,protractor_tax_percent,b_code,d_code,t_code ,a_code_name, a_code_value,
         a_min_value, a_max_value, a_fixed,c_code_name, c_code_value, c_min_value, c_max_value, c_fixed, e_code_name, e_code_value, e_min_value, e_max_value, e_fixed, f_code_name, f_code_value, f_min_value, f_max_value,
         f_fixed, g_code_name, g_code_value, g_min_value,  g_max_value, g_fixed,t1_code_name, t1_code_value, t2_code_name, t2_code_value,t1_min_value, t1_max_value, t1_fixed, t2_min_value, t2_max_value, t2_fixed,
         t3_code_name, t3_code_value, t3_min_value,t3_max_value, t3_fixed, url_cr, username_cr, password_cr, api_key_cr,account_id_cnp,acceptor_id_cnp,account_token_cnp,application_id_cnp,terminal_id,protractor_status,
         pos_type, receipt_type,tip,invoice_type,payroc,processor_id
         FROM merchant WHERE id ='".$merchant_id."' ");

 $getDetailUser = $stmt->result_array();

 
 if(!empty($getDetailUser[0]['id'])){
 
 $token = AUTHORIZATION::generateToken(['merchant_id' => $getDetailUser[0]['id']]);
 
 $user = array(
'id'=>$getDetailUser[0]['id'] ? $getDetailUser[0]['id'] : "",
 'name'=>$getDetailUser[0]['name'] ? $getDetailUser[0]['name'] : "", 
 'email'=>$getDetailUser[0]['email'] ? $getDetailUser[0]['email'] : "",
 'connection_id'=>$getDetailUser[0]['connection_id'] ? $getDetailUser[0]['connection_id'] : "", 
 'api_key'=>$getDetailUser[0]['api_key'] ? $getDetailUser[0]['api_key'] : "", 
 'auth_code'=>$getDetailUser[0]['auth_code'] ? getDetailUser[0]['auth_code'] : "",
 'min_shop_supply'=>$getDetailUser[0]['min_shop_supply'] ? $getDetailUser[0]['min_shop_supply'] : "",
 'max_shop_supply'=>$getDetailUser[0]['max_shop_supply'] ? $getDetailUser[0]['max_shop_supply'] : "", 
 'shop_supply_percent'=>$getDetailUser[0]['shop_supply_percent'] ? $getDetailUser[0]['shop_supply_percent'] : "", 
 'protractor_tax_percent'=>$getDetailUser[0]['protractor_tax_percent'] ? $getDetailUser[0]['protractor_tax_percent'] : "",
 'b_code'=>$getDetailUser[0]['b_code'] ? $getDetailUser[0]['b_code'] : "", 
 'd_code'=>$getDetailUser[0]['d_code'] ? $getDetailUser[0]['d_code'] : "", 
 't_code'=>$getDetailUser[0]['t_code'] ? $getDetailUser[0]['t_code'] : "",
  'a_code_name'=>$getDetailUser[0]['a_code_name'] ? $getDetailUser[0]['a_code_name'] : "", 
 'a_code_value'=>$getDetailUser[0]['a_code_value'] ? $getDetailUser[0]['a_code_value'] : "", 
 'a_min_value'=>$getDetailUser[0]['a_min_value'] ? $getDetailUser[0]['a_min_value'] : "",
 'a_max_value'=>$getDetailUser[0]['a_max_value'] ? $getDetailUser[0]['a_max_value'] : "", 
 'a_fixed'=>$getDetailUser[0]['a_fixed'] ? $getDetailUser[0]['a_fixed'] : "",
 'c_code_name'=>$getDetailUser[0]['c_code_name'] ? $getDetailUser[0]['c_code_name'] : "", 
 'c_code_value'=>$getDetailUser[0]['c_code_value'] ? $getDetailUser[0]['c_code_value'] : "", 
 'c_min_value'=>$getDetailUser[0]['c_min_value'] ? $getDetailUser[0]['c_min_value'] : "",
 'c_max_value'=>$getDetailUser[0]['c_max_value'] ? $getDetailUser[0]['c_max_value'] : "", 
 'c_fixed'=>$getDetailUser[0]['c_fixed'] ? $getDetailUser[0]['c_fixed'] : "",
 'e_code_name'=>$getDetailUser[0]['e_code_name'] ? $getDetailUser[0]['e_code_name'] : "", 
 'e_code_value'=>$getDetailUser[0]['e_code_value'] ? $getDetailUser[0]['e_code_value'] : "", 
 'e_min_value'=>$getDetailUser[0]['e_min_value'] ? $getDetailUser[0]['e_min_value'] : "",
 'e_max_value'=>$getDetailUser[0]['e_max_value'] ? $getDetailUser[0]['e_max_value'] : "", 
 'e_fixed'=>$getDetailUser[0]['e_fixed'] ? $getDetailUser[0]['e_fixed'] : "",
 'f_code_name'=>$getDetailUser[0]['f_code_name'] ? $getDetailUser[0]['f_code_name'] : "", 
 'f_code_value'=>$getDetailUser[0]['f_code_value'] ? $getDetailUser[0]['f_code_value'] : "", 
 'f_min_value'=>$getDetailUser[0]['f_min_value'] ? $getDetailUser[0]['f_min_value'] : "",
 'f_max_value'=>$getDetailUser[0]['f_max_value'] ? $getDetailUser[0]['f_max_value'] : "", 
 'f_fixed'=>$getDetailUser[0]['f_fixed'] ? $getDetailUser[0]['f_fixed'] : "",
 'g_code_name'=>$getDetailUser[0]['g_code_name'] ? $getDetailUser[0]['g_code_name'] : "", 
 'g_code_value'=>$getDetailUser[0]['g_code_value'] ? $getDetailUser[0]['g_code_value'] : "", 
 'g_min_value'=>$getDetailUser[0]['g_min_value'] ? $getDetailUser[0]['g_min_value'] : "",
 'g_max_value'=>$getDetailUser[0]['g_max_value'] ? $getDetailUser[0]['g_max_value'] : "", 
 'g_fixed'=>$getDetailUser[0]['g_fixed'] ? $getDetailUser[0]['g_fixed'] : "",
 't1_code_name'=>$getDetailUser[0]['t1_code_name'] ? $getDetailUser[0]['t1_code_name'] : "", 
 't1_code_value'=>$getDetailUser[0]['t1_code_value'] ? $getDetailUser[0]['t1_code_value'] : "", 
 't1_min_value'=>$getDetailUser[0]['t1_min_value'] ? $getDetailUser[0]['t1_min_value'] : "",
 't1_max_value'=>$getDetailUser[0]['t1_max_value'] ? $getDetailUser[0]['t1_max_value'] : "", 
 't1_fixed'=>$getDetailUser[0]['t1_fixed'] ? $getDetailUser[0]['t1_fixed'] : "",
 't2_code_name'=>$getDetailUser[0]['t2_code_name'] ? $getDetailUser[0]['t2_code_name'] : "", 
 't2_code_value'=>$getDetailUser[0]['t2_code_value'] ? $getDetailUser[0]['t2_code_value'] : "", 
 't2_min_value'=>$getDetailUser[0]['t2_min_value'] ? $getDetailUser[0]['t2_min_value'] : "",
 't2_max_value'=>$getDetailUser[0]['t2_max_value'] ? $getDetailUser[0]['t2_max_value'] : "", 
 't2_fixed'=>$getDetailUser[0]['t2_fixed'] ? $getDetailUser[0]['t2_fixed'] : "",
 't3_code_name'=>$getDetailUser[0]['t3_code_name'] ? $getDetailUser[0]['t3_code_name'] : "", 
 't3_code_value'=>$getDetailUser[0]['t3_code_value'] ? $getDetailUser[0]['t3_code_value'] : "", 
 't3_min_value'=>$getDetailUser[0]['t3_min_value'] ? $getDetailUser[0]['t3_min_value'] : "",
 't3_max_value'=>$getDetailUser[0]['t3_max_value'] ? $getDetailUser[0]['t3_max_value'] : "", 
 't3_fixed'=>$getDetailUser[0]['t3_fixed'] ? $getDetailUser[0]['t3_fixed'] : "",
 'url_cr'=>$url_cr_c ? $url_cr_c : "", 
 'username_cr'=>$username_cr_c ? $username_cr_c : "",
 'password_cr'=>$password_cr_c ? $password_cr_c : "", 
 'api_key_cr'=>$api_key_cr_c ? $api_key_cr_c : "",
 'sub_user_id'=>$s_id ? $s_id : "",
 'account_id_cnp'=>$getDetailUser[0]['account_id_cnp'] ? $getDetailUser[0]['account_id_cnp'] : "",
 'acceptor_id_cnp'=>$getDetailUser[0]['acceptor_id_cnp'] ? $getDetailUser[0]['acceptor_id_cnp'] : "",
 'account_token_cnp'=>$getDetailUser[0]['account_token_cnp'] ? $getDetailUser[0]['account_token_cnp'] : "", 
 'application_id_cnp'=>$getDetailUser[0]['application_id_cnp'] ? $getDetailUser[0]['application_id_cnp'] : "",
 'terminal_id_cnp'=>$getDetailUser[0]['terminal_id'] ? $getDetailUser[0]['terminal_id'] : "",
 'protractor_status'=>$getDetailUser[0]['protractor_status'] ? $getDetailUser[0]['protractor_status'] : "",
 'pos_type'=>$getDetailUser[0]['pos_type'] ? $getDetailUser[0]['pos_type'] : "",
 'receipt_type'=>$getDetailUser[0]['receipt_type'] ? $getDetailUser[0]['receipt_type'] : "",
 'tip'=>$getDetailUser[0]['tip'] ? $getDetailUser[0]['tip'] : "",
 'invoice_type'=>$getDetailUser[0]['invoice_type'] ? $getDetailUser[0]['invoice_type'] : "",
 'token'=>$token,
 'POS_Processor_id'=>$getDetailUser[0]['processor_id'] ? $getDetailUser[0]['processor_id'] : "NA",
 'payroc_apikey'=>'fcnpBA9a579qp7QA2wMpCtcgGB453Q43'
 
 );
 
$stmt = $this->db->query("INSERT INTO login_detail (user_type,status, user_id, ip) VALUES ('employee','true', '".$getDetailUser[0]['id']."', '".$ip."')");

 
 $status = parent::HTTP_OK;
 $response = ['status' => $status, 'successMsg' => 'Login successfull', 'UserData' => $user];
 
 }
 
 else{
     
 $stmt = $this->db->query("INSERT INTO login_detail (user_type,status, ip) VALUES ('merchant','false', '".$ip."')");
 $status = 200;
    $response = ['status' => '200', 'errorMsg' => 'Invalid username or password'];
 }
     }
     
    }
    else{
  $stmt = $this->db->query("INSERT INTO login_detail (user_type,status, ip) VALUES ('merchant','false', '".$ip."')");
$status = 200;
 $response = ['status' => '200', 'errorMsg' => 'Your account is currently logged onto another device. Please log out of the other device or contact your administrator.']; 
    }
     
    
    
}
 
 else{
     
 $ip = $ip;
    $stmt = $this->db->query("INSERT INTO login_detail (user_type,status, ip) VALUES ('merchant','false','".$ip."')");

$status = 200;
 $response = ['status' => '200', 'errorMsg' => 'Invalid username or password'];
 } 
     
     
    $this->response($response, $status); 


  }



  public function register_post()
  {
      $data = array();
      
    
    
      if(isset($_POST['email']))
      {
        $merchant_key = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,51 ) ,1 ) .substr( md5( time() ), 1);
		$today1 = date("Ymdhisu");
		$unique = "SL" .$today1 ;
		$name = $_POST['name'];
		$auth_key = $unique;
		$monthly_fee = '39.99';
		$chargeback = '20.00';
		$point_sale = '2.8';
		$invoice = '2.9';
		$recurring = '2.9';
		$text_email = '0.0';
		$f_swap_Invoice = '0.30';
		$f_swap_Recurring = '0.3';
		$f_swap_Text ='0.10';
		$t_fee = '10';
		$email = $_POST['email'];
		$password1 = ($_POST['password']); 
		$password = $this->my_encrypt( $password1 , 'e' );
		$mob_no = $_POST['mob_no'];
		$today2 = date("Y-m-d");
		
 
 $stmt = $this->db->query("SELECT id FROM merchant WHERE email ='".$email."' ");
 
 $getUser = $stmt->result_array();
 $id = $getUser[0]['id'];
 if(!empty($id)){

 $response = ['status' => '401', 'errorMsg' => 'User already registered'];

 
 }
 else
 {


 $data = array(
    'name' =>$name,
    'auth_key' =>$auth_key,
    'email' =>$email, 
    'password' =>$password,
    'mob_no' => $mob_no, 
    'user_type' =>'merchant', 
    'status' =>'pending',
    'date_c' =>$today2,
    'f_swap_Invoice' =>$f_swap_Invoice,
    'f_swap_Recurring' =>$f_swap_Recurring,
    'f_swap_Text' =>$f_swap_Text,
    'monthly_fee' =>$monthly_fee,
    'chargeback' =>$chargeback,
    'point_sale' =>$point_sale,
    'recurring' =>$recurring,
    'text_email' =>$text_email,
    'merchant_key' =>$merchant_key,
    't_fee' =>$t_fee,
   

   );
$stmt = $this->admin_model->insert_data("merchant", $data);

if(!empty($stmt))
{
$url="https://salequick.com/confirm/".$auth_key;
 
$mail_body = '<!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                    
        
                @media only screen and (max-width:480px) {
                    .table-change-mobile tr.header-class{
                        display: inline-block !important;
                        float:left !important;
                        width: auto !important;
                    }
                    .table-change-mobile tr.data-class{
                      display: inline-block !important;
                      float:right !important;
                      width:auto !important;
                    }
                    .table-change-mobile tr.header-class th{
                    display: block !important;
                    line-height: 28px !important;
                    font-size: 13px !important;
                    border-bottom: 0 !important;
                    padding: 4px !important;
                  
                    }
        
                .table-change-mobile tr.data-class td{
                    display: block !important;
                    line-height: 28px !important;
                    font-size: 13px !important;
                    padding: 4px !important;
                    border: 0 !important;
        
                }
                .table-change-mobile
                {
                   display: inline-grid !important; 
                }
                
                }
            </style>
            </head>
           <body style="margin:0 auto;padding: 0;font-family: Open Sans, sans-serif;width: 100%;height: 100%;">
        
            <div class="main-box" style="padding: 80px 0px 10px 0px; background-image: linear-gradient(#4990e2 30%, #fff 30%);width: 100%;height: 100%;display: inline-block;">
        
                <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">
        
                    <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">
        
                        <div class="float-left" style="width:100%;display:inline-block;text-align:center;">
        
                                <p><img src="https://salequick.com/email/images/logo.png" width="100px"></p>
                                    <h4 style="margin-bottom: 0px;color:#000; ">Registration</h4>
                                     <p style="margin-top: 0px;">www.salequick.com</p> 
                                    
                            </div>
        
                            <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
                                <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Please Confirm Email</h3>
                                
                            </div>
                            
                        </div>
                         <div class="bottom-div twenty-div table-change-mobile" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">
        
                           <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
                                <tr class="header-class">
                                    <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"> Name</th>
                                     <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"> Email</th>
                                      <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"> Phone</th>
                                   
                                 
                                   
                                    <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Click this Url</th>
                                </tr>
        
        
                                     
                                    <tr class="data-class">
                                                    
                                                   
                                                   <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                         '.$name.'
                                                    </td>
                                                    <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                         '.$email.'
                                                    </td>
                                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                         '.$mob_no.'
                                                    </td>
                                            
        <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;"><a href="'.$url.'"> Click Here</a>                                                
                                                    </td>
                                                </tr>
                                                <tr>
                                    <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                                    <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                                    <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                        <p style="text-transform: uppercase;color:#7e8899;border:0px! important;"></p>
                                    </td>
                                    <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                                    <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                        <p style="color: #0077e2;border:0px;"></p>
                                    </td>
                                </tr>
                                                
                            </table>
                           
                        </div>
                    </div>
                        <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">
        
                        <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">
        
                             <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">
        
                                
                            </div>
                            <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">
        
                                <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                                <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
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
		
		
		 $MailSubject = 'Confirm Email'; 
    
   
if (!empty($email)) {
    $this->email->from('info@salequick.com','Salequick');
    $this->email->to($email);
    $this->email->subject($MailSubject);
    $this->email->message($mail_body);
    $this->email->send();
}

$message = '1';

 $status = parent::HTTP_OK;
 $response = ['status' => $status, 'successMsg' => 'User Registered Successfully'];
}
else
{

 $response = ['status' => '401', 'errorMsg' => 'User Registeration Fail'];
 }
 //
 }
      }
      else
      {
          $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
      }
  
      $this->response($response, $status);
  }







}
