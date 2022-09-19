<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login_admin extends CI_Controller
{
     public function __construct()
     {
          parent::__construct();
        
          $this->load->model('login_model');
          $this->load->model('Home_model');
          $this->load->driver('cache');  
          $this->load->library('email');  
           $this->load->library('twilio'); 
          date_default_timezone_set("America/Chicago");
         // ini_set('display_errors', 1);
          //error_reporting(E_ALL);
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
     public function index_old()
     {
		
          $username = $this->input->post("username");
          $password1 = $this->input->post("password");
          
          $date = date("Y:m:d H:i:s");
           $add_time = date("H:i:s");
            $time = strtotime($add_time);
           $endTime = date("H:i:s", strtotime('-59 minutes', $time));
    
      $password = $this->my_encrypt( $password1 , 'e' );
		        $add_time = date("H:i:s");
          $this->form_validation->set_rules("username", "Username", "trim|required");
          $this->form_validation->set_rules("password", "Password", "trim|required");
          if ($this->form_validation->run() == FALSE)
          {
               
               $this->load->view('admin/login_view');
          }
          else
          {
		  
               
               if ($this->input->post('btn_login') == "Login")
               {
                   
                   $ip = $this->input->post("ip");
                   $usr_count = $this->login_model->get_ip($ip,$add_time,$endTime,$date);
                      if($usr_count > 5)
                      {
                          $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Your Ip is Block!</div>');
                          redirect(base_url().'admin');
                      }
                        else{
                    $usr_result = $this->login_model->get_user($username, $password);
                  
					 if (!empty($usr_result)) 
                    {
                         
                        $sessiondata = array(
                              
							   'id' => $usr_result['id'],
								'username' => $usr_result['username'],
								'user_type' => $usr_result['user_type'],
								'name' => $usr_result['name'],
								'image' => $usr_result['image'],
                              
                              'loginuser' => TRUE
                         );
                      $this->session->set_userdata($sessiondata);
                      $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => 'admin',
                    'user_id' => $usr_result['id'],
                    'status' => 'true'
                   
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                        
                           redirect(base_url().'dashboard');
                    }
                    else
                    {
                         $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => 'admin',
                    'user_id' => '',
                    'status' => 'false'
                   
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                 $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                       
                         redirect(base_url().'admin');
                    }
                  }
               }
               else
               {
			   
                     redirect(base_url().'admin');
               }
          }
     }

    public function index() {
        $username = $this->input->post("username");
        $password1 = $this->input->post("password");

        $date = date("Y:m:d H:i:s");
        $add_time = date("H:i:s");
        $time = strtotime($add_time);
        $endTime = date("H:i:s", strtotime('-59 minutes', $time));

        $password = $this->my_encrypt( $password1 , 'e' );
        $add_time = date("H:i:s");
        $this->form_validation->set_rules("username", "Username", "trim|required");
        $this->form_validation->set_rules("password", "Password", "trim|required");
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login_view');

        } else {
            if ($this->input->post('btn_login') == "Login") {
                $ip = $this->input->post("ip");
                $usr_count = $this->login_model->get_ip($ip,$add_time,$endTime,$date);
                if($usr_count > 50) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Your Ip is Block!</div>');
                    redirect(base_url().'admin');
                } else {
                    $usr_result = $this->login_model->get_user($username, $password);
                    $usr_result2 = $this->login_model->get_subadmin($username, $password);
                    //print_r($usr_result2); 
                    //print_r($usr_result);die;
                    // print_r($usr_result['user_type']);  die; 
                    if($usr_result!="") {
                        if (!empty($usr_result) && $usr_result['status']=='active' && $usr_result['user_type']=='wf') {
                            // start otp
                            $otp = rand(1000,9999);
                            $sms_message = trim(" Hello your otp : " . $otp . "  ");
                            $from = '+18325324983'; //trial account twilio number
                            // $to = '+'.$sms_reciever; //sms recipient number
                            //$sms_reciever='7133929414';
                            $sms_reciever=$usr_result['phone'];
                            $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                            $to = '+1' . $mob;
                            $response = $this->twilio->sms($from, $to, $sms_message);

                            // if($username=='developer'){
                            //  print_r($response); die();
                            //   }

                            /////////////// Send email start
                            $otp_data = array(
                                'admin_name' => $usr_result['name'],
                                'otp' => $otp
                            );

                            $MailTo = $usr_result['email_id'];
            
                            //print_r($htmlContent); 
                            $config['mailtype'] = 'html';
                            $this->email->initialize($config);
                            $msg = $this->load->view('email/otp_mail', $otp_data, true);
                            $MailSubject = 'Salequick Admin Otp';
                            $this->email->from('info@salequick.com', 'Salequick Admin Otp');
                            $this->email->to($usr_result['email_id']);
                            $this->email->subject($MailSubject);
                            $this->email->message($msg);
                            $this->email->send();
                        
                 

                $getQuery_delete = $this->db->query(" DELETE FROM otp_detail where admin_id='".$usr_result['id']."' "); 
                    $getQuery_a = $this->db->query("INSERT INTO otp_detail (admin_id, otp) VALUES ('".$usr_result['id']."', '".$otp."') ");

                        
                           //redirect(base_url().'dashboard');
                            redirect(base_url().'otp/index'.'/'.$usr_result['id']);
                    }
                    else
                    {
                         $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => 'admin', //wf
                    'user_id' => '',
                    'status' => 'false'
                   
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">you have Block by another admin</div>');
                       
                         redirect(base_url().'admin');
                    }
                }
                else if( $usr_result2!="")
                {
                    
           
                              
                            if (!empty($usr_result2) && $usr_result2['status']=='active') 
                             {     
                                 $sessiondata = array(
                                       'subadmin_id' => $usr_result2['id'],
                                       'time_zone' => 'America/Chicago',
                                       //  'username' => $usr_result['username'],
                                       'subadmin_user_type' => $usr_result2['user_type'],
                                       'subadmin_name' => $usr_result2['name'],
                                       'subadmin_assign_merchant' => $usr_result2['assign_merchant'],
                                       'subadmin_view_menu_permissions' => $usr_result2['view_menu_permissions'],
                                       'subadmin_view_permissions' => $usr_result2['view_permissions'],
                                       'subadmin_edit_permissions' => $usr_result2['edit_permissions'],
                                       'subadmin_active_permissions' => $usr_result2['active_permissions'],
                                       'subadmin_delete_permissions' => $usr_result2['delete_permissions'],
                                       //'image' => $usr_result['image'],
                                       'subadmin_loginuser' => TRUE
                                  );
                                  
                               $this->session->set_userdata($sessiondata);
                                
                               $data = Array( "ip" => $this->input->post("ip"),  "user_type" => 'sub_admin', 'user_id' => $usr_result2['id'],  'status' => 'true'  );
                               $this->Home_model->insert_data("login_detail", $data);
                              //  print_r($this->session->userdata()); die; 
                               //redirect(base_url().'subadmin/dashboard');
                               redirect(base_url().'subadmin/edit_profile');
                               
                               
                             }
                             
                             else
                             {
                                  $data = Array(
                             "ip" => $this->input->post("ip"),
                             "user_type" => 'sub_admin',
                             'user_id' => '',
                             'status' => 'false'
                            
                                  );
                        
                             $this->Home_model->insert_data("login_detail", $data);
                             $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">you have Block by admin</div>');
                             redirect(base_url().'admin');
                             }
                }
                else
                    {
                    $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => '',
                    'user_id' => '',
                    'status' => 'false'
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                       
                         redirect(base_url().'admin');
                    }

             }
          }
          else
          {
             
                redirect(base_url().'admin');
          }
     }
}


     public function index_old2()
{
     
     $username = $this->input->post("username");
     $password1 = $this->input->post("password");

     $date = date("Y:m:d H:i:s");
     $add_time = date("H:i:s");
     $time = strtotime($add_time);
     $endTime = date("H:i:s", strtotime('-59 minutes', $time));

     $password = $this->my_encrypt( $password1 , 'e' );
     $add_time = date("H:i:s");
     $this->form_validation->set_rules("username", "Username", "trim|required");
     $this->form_validation->set_rules("password", "Password", "trim|required");
     if ($this->form_validation->run() == FALSE)
     {
          
          $this->load->view('admin/login_view');
     }
     else
     {
          if ($this->input->post('btn_login') == "Login")
          { 
              $ip = $this->input->post("ip");
              $usr_count = $this->login_model->get_ip($ip,$add_time,$endTime,$date);
                 if($usr_count > 5)
                 {
                     $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Your Ip is Block!</div>');
                     redirect(base_url().'admin');
                 }
                   else{
                  $usr_result = $this->login_model->get_user($username, $password);
                  $usr_result2 = $this->login_model->get_subadmin($username, $password);
                // print_r($usr_result2);  print_r($usr_result);  die; 
                if($usr_result!="")
                {   
                    if (!empty($usr_result) && $usr_result['status']=='active' ) 
                    {
                         
                        $sessiondata = array( 'id' => $usr_result['id'], 'username' => $usr_result['username'], 
                          'time_zone' => 'America/Chicago',
                        'user_type' => $usr_result['user_type'],
                        'name' => $usr_result['name'], 'image' => $usr_result['image'], 'loginuser' => TRUE
                     );
                      $this->session->set_userdata($sessiondata);
                      $data = Array("ip" => $this->input->post("ip"),  "user_type" => 'admin', 'user_id' => $usr_result['id'],  'status' => 'true'  );
               
                          $this->Home_model->insert_data("login_detail", $data);
                        
                           redirect(base_url().'dashboard');
                    }
                    else
                    {
                         $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => 'admin',
                    'user_id' => '',
                    'status' => 'false'
                   
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">you have Block by another admin</div>');
                       
                         redirect(base_url().'admin');
                    }
                }
                else if( $usr_result2!="")
                {
                    
           
                              
                            if (!empty($usr_result2) && $usr_result2['status']=='active') 
                             {     
                                 $sessiondata = array(
                                       'subadmin_id' => $usr_result2['id'],
                                       'time_zone' => 'America/Chicago',
                                       //  'username' => $usr_result['username'],
                                       'subadmin_user_type' => $usr_result2['user_type'],
                                       'subadmin_name' => $usr_result2['name'],
                                       'subadmin_assign_merchant' => $usr_result2['assign_merchant'],
                                       'subadmin_view_menu_permissions' => $usr_result2['view_menu_permissions'],
                                       'subadmin_view_permissions' => $usr_result2['view_permissions'],
                                       'subadmin_edit_permissions' => $usr_result2['edit_permissions'],
                                       'subadmin_active_permissions' => $usr_result2['active_permissions'],
                                       'subadmin_delete_permissions' => $usr_result2['delete_permissions'],
                                       //'image' => $usr_result['image'],
                                       'subadmin_loginuser' => TRUE
                                  );
                                  
                               $this->session->set_userdata($sessiondata);
                                
                               $data = Array( "ip" => $this->input->post("ip"),  "user_type" => 'sub_admin', 'user_id' => $usr_result2['id'],  'status' => 'true'  );
                               $this->Home_model->insert_data("login_detail", $data);
                              //  print_r($this->session->userdata()); die; 
                               //redirect(base_url().'subadmin/dashboard');
                               redirect(base_url().'subadmin/edit_profile');
                               
                               
                             }
                             
                             else
                             {
                                  $data = Array(
                             "ip" => $this->input->post("ip"),
                             "user_type" => 'sub_admin',
                             'user_id' => '',
                             'status' => 'false'
                            
                                  );
                        
                             $this->Home_model->insert_data("login_detail", $data);
                             $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">you have Block by admin</div>');
                             redirect(base_url().'admin');
                             }
                }
                else
                    {
                    $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => '',
                    'user_id' => '',
                    'status' => 'false'
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                       
                         redirect(base_url().'admin');
                    }

             }
          }
          else
          {
             
                redirect(base_url().'admin');
          }
     }
}

       public function subadmin()
     {
    
          $username = $this->input->post("username");
          $password1 = $this->input->post("password");
          
          $date = date("Y:m:d H:i:s");
           $add_time = date("H:i:s");
            $time = strtotime($add_time);
           $endTime = date("H:i:s", strtotime('-59 minutes', $time));
    
      $password = $this->my_encrypt( $password1 , 'e' );
            $add_time = date("H:i:s");
          $this->form_validation->set_rules("username", "Username", "trim|required");
          $this->form_validation->set_rules("password", "Password", "trim|required");
          if ($this->form_validation->run() == FALSE)
          {
               
               $this->load->view('subadmin/login_view');
          }
          else
          {
      
               
               if ($this->input->post('btn_login') == "Login")
               {
                   
                   $ip = $this->input->post("ip");
                   $usr_count = $this->login_model->get_ip($ip,$add_time,$endTime,$date);
                      if($usr_count > 5)
                      {
                          $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Your Ip is Block!</div>');
                          redirect(base_url().'subadmin');
                      }
                        else{
                    $usr_result = $this->login_model->get_subadmin($username, $password);
                  
           if (!empty($usr_result)) 
                    {
                         
                        $sessiondata = array(
                              
                 'id' => $usr_result['id'],
              //  'username' => $usr_result['username'],
                'user_type' => $usr_result['user_type'],
                'name' => $usr_result['name'],
                 'view_permissions' => $usr_result['view_permissions'],
                                        'edit_permissions' => $usr_result['edit_permissions'],
                                        'edit_permissions' => $usr_result['edit_permissions'],
                                         'delete_permissions' => $usr_result['delete_permissions'],
                //'image' => $usr_result['image'],
                              'loginuser' => TRUE
                         );
                      $this->session->set_userdata($sessiondata);
                      $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => 'sub_admin',
                    'user_id' => $usr_result['id'],
                    'status' => 'true'
                   
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                        
                           redirect(base_url().'subadmin/dashboard');
                    }
                    else
                    {
                         $data = Array(
                    "ip" => $this->input->post("ip"),
                    "user_type" => 'sub_admin',
                    'user_id' => '',
                    'status' => 'false'
                   
                         );
               
                    $this->Home_model->insert_data("login_detail", $data);
                 $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                       
                         redirect(base_url().'subadmin');
                    }
                  }
               }
               else
               {
         
                     redirect(base_url().'subadmin');
               }
          }
     }
	 
public function merchant()
     {
        $username = $this->input->post("username");
        $password1 = $this->input->post("password");
        $password = $this->my_encrypt( $password1 , 'e' );
        //  $password = $this->my_encrypt( $encrypted , 'd' );
        $date = date("Y:m:d H:i:s");
        $add_time = date("H:i:s");
        $time = strtotime($add_time);
        $endTime = date("H:i:s", strtotime('-59 minutes', $time));
        $this->form_validation->set_rules("username", "Username", "trim|required");
        $this->form_validation->set_rules("password", "Password", "trim|required");
        if ($this->form_validation->run() == FALSE)
        {
          $this->load->view('login'); 
        }
        else
        {  
          if ($this->input->post('btn_login') == "Login")
          {
          $ip = $this->input->post("ip");
             $usr_count = $this->login_model->get_ip($ip,$add_time,$endTime,$date);
                if($usr_count > 500)
                {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Your Ip is Block  '.$usr_count.'!</div>');
                   redirect('login');
                }
              else{
              $usr_result = $this->login_model->get_merchant($username, $password);
              //print_r($usr_result);  die("pl"); 
          //   echo $usr_result['status'];  die(); 
              
               if (!empty($usr_result) && $usr_result['status']!='pending' && $usr_result['status']!='pending_signup') 
              {
                 
                if($usr_result['time_zone']==""){ $usr_result['time_zone']='America/Chicago';  }
                   //die('if');   
                  $sessiondata = array(
                        'merchant_id' => $usr_result['id'],
                        'merchant' => $usr_result['email'],
                        'merchant_user_type' => $usr_result['user_type'],
                        'merchant_name' => $usr_result['name'],
                        'merchant_status' => $usr_result['status'],
                        'merchant_auth_key' => $usr_result['auth_key'],
                        'website' => $usr_result['website'],
                        'time_zone' => $usr_result['time_zone'],
                        'm_email' => $usr_result['email'],
                        'm_business_number' => $usr_result['business_number'],
                        'view_permissions' => $usr_result['view_permissions'],
                        'edit_permissions' => $usr_result['edit_permissions'],
                        'create_pay_permissions' => $usr_result['create_pay_permissions'],
						'view_menu_permissions' => $usr_result['view_menu_permissions'],
                        'business_dba_name' => $usr_result['business_dba_name'],
                        'merchant_logo' => $usr_result['logo'],
                        'p_merchant_id' => $usr_result['merchant_id'],
                        'Activate_Details' => $usr_result['Activate_Details'],
                        't_fee' => $usr_result['t_fee'],
                        'register_type' => $usr_result['register_type'],
                        'ecom_transaction_mode' => $usr_result['ecom_transaction_mode'],
                        'payroc' => $usr_result['payroc'],
                        'loginuser' => TRUE
                   );
                   
           //   print_r($sessiondata); die();
           // $this->cache->memcached->save('sessiondata', $sessiondata, 86400);
                $this->session->set_userdata($sessiondata);
                 $data = Array(
              "ip" => $this->input->post("ip"),
              "user_type" => 'merchant',
              'user_id' => $usr_result['id'],
              'status' => 'true',
               'add_time' => $add_time
                   );
              $this->Home_model->insert_data("login_detail", $data);
              $merchant_user_type = $this->session->userdata('merchant_user_type'); 
              
             //echo $usr_result['status'];
             //die();
                if($merchant_user_type=='merchant'){
                    if ( $usr_result['status']=='Waiting_For_Approval') 
                    {
                        redirect(base_url('merchant/after_signup'));
                    }
                    else
                    {
                         redirect(base_url('merchant'));
                    }
                   
              }
              elseif($merchant_user_type=='employee')
              {
                       $submerchant_id = $this->session->userdata('p_merchant_id');
                        $subuser_id = $this->session->userdata('merchant_id');
          $getMarchentlogo = $this->db->query("SELECT id,email,business_number,t_fee,name,text_email,logo,invoice,recurring,point_sale,f_swap_Invoice,f_swap_Recurring,f_swap_Text,business_dba_name,ecom_transaction_mode,payroc from merchant where id = '".$submerchant_id."' ");
          $getMarchentLogoo = $getMarchentlogo->result_array();
          $data['getMarchentLogoo'] = $getMarchentLogoo;
          $sessiondata = array(
               'merchant_logo' => $getMarchentLogoo[0]['logo'],
               'merchant_name' => $getMarchentLogoo[0]['name'],
               'text_email' => $getMarchentLogoo[0]['text_email'],
               'invoice' => $getMarchentLogoo[0]['invoice'],
               'website' => $usr_result['website'],
               'recurring' => $getMarchentLogoo[0]['recurring'],
               'point_sale' => $getMarchentLogoo[0]['point_sale'],
               'f_swap_Invoice' => $getMarchentLogoo[0]['f_swap_Invoice'],
               'f_swap_Recurring' => $getMarchentLogoo[0]['f_swap_Recurring'],
               'business_dba_name' => $getMarchentLogoo[0]['business_dba_name'],
               'f_swap_Text' => $getMarchentLogoo[0]['f_swap_Text'],
               't_fee' => $getMarchentLogoo[0]['t_fee'],
               'ecom_transaction_mode' => $getMarchentLogoo[0]['ecom_transaction_mode'],
               'register_type' => $usr_result['register_type'],
               'time_zone' => $usr_result['time_zone'],
               'm_email' => $getMarchentLogoo[0]['email'],
               'm_business_number' => $getMarchentLogoo[0]['business_number'],
               'subuser_id' => $this->session->userdata('merchant_id'),
               'merchant_id' => $getMarchentLogoo[0]['id'],
               'view_menu_permissions' => $usr_result['view_menu_permissions'], 
               'employee_id' => $usr_result['id'],
               'employee_email' => $usr_result['email'],
               'employee_username' => $usr_result['name'],
               'employee_password' => $usr_result['password'],
               'employee_mobile' => $usr_result['mob_no'],
               'payroc' => $getMarchentLogoo[0]['payroc'],

                   );
         //$this->cache->memcached->save('website_name', $name, 86400);
                $this->session->set_userdata($sessiondata);
                      //  redirect(base_url().'employee');
                     //   redirect(base_url().'merchant');
                       //redirect(base_url().'pos/add_pos');
					   redirect(base_url().'merchant/general_settings');
              }
              }
              else  if (!empty($usr_result) && $usr_result['status']=='pending') 
              {
               $data = Array( "ip" => $this->input->post("ip"),  "user_type" => 'merchant', 'user_id' => '', 'status' => 'false', 'add_time' => $add_time);
               $this->Home_model->insert_data("login_detail", $data);
               $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">check your email for confirmation !</div>');
               redirect(base_url().'login');
              }
              else if (!empty($usr_result) && $usr_result['status']=='pending_signup') 
              {
              
               if ($username && $password) {
                    //$last_merchantId = $this->session->userdata('last_merchantId');
                    $this->db->where('email', $username);
                    $this->db->where('password', $password);
                    $result= $this->db->get('merchant')->row_array();
                    $this->session->set_userdata('last_merchantId',$result['id']);
               } 
               $this->session->set_userdata('step', 'one');
               //$this->load->view('signup', $data);    
               redirect(base_url().'signup'); 
              }
              else
              { 
               $data = Array( "ip" => $this->input->post("ip"),  "user_type" => 'merchant', 'user_id' => '', 'status' => 'false', 'add_time' => $add_time);
               $this->Home_model->insert_data("login_detail", $data);
               $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
               redirect(base_url().'login');
              }
            }
        }
        else
        {
          
            redirect(base_url().'login');
        }
      }
     }
}
?>
