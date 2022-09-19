<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reset extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('session');
          $this->load->database();
          $this->load->library('form_validation');
          $this->load->model('reset_model');
                $this->load->library('email');
           date_default_timezone_set("America/Chicago");
           //ini_set('display_errors', 1);
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

     public function index()
     {
	 
	 
          $username = $this->input->post("admin_email");
     

          $this->form_validation->set_rules("admin_email", "Username", "trim|required");

          if ($this->form_validation->run() == FALSE)
          {
               $this->load->view('admin/reset');
          }
          else
          {
               if ($this->input->post('btn_login') == "Reset")
               {
                    $usr_result = $this->reset_model->get_user($username); 
                    if ($usr_result > 0) 
                    {
                         $password1 = time();
                         $password = $this->my_encrypt( $password1 , 'e' );
                         $usr_update = $this->reset_model->update($username,$password);
                         set_time_limit(3000); 
                         $MailTo = $username; 
                         $MailSubject = 'Update Password Successful'; 
                         $header = "From: Salequick<info@salequick.com>\r\n".
                         "MIME-Version: 1.0" . "\r\n" .
                         "Content-type: text/html; charset=UTF-8" . "\r\n"; 
                         $msg = " Your user id : ".$username.". Password : ".$password1.".";
                         ini_set('sendmail_from', $username); 
                         // mail($MailTo, $MailSubject, $msg, $header);
                         $this->email->from('info@salequick.com', 'Update Password Successful');
                         $this->email->to($MailTo);
                         $this->email->subject($MailSubject);
                         $this->email->message($msg);
                         $this->email->send();
                         //$this->session->set_userdata($sessiondata);
                         $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please Check Your Email-Id For New Password </div>');
                         redirect('reset');
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email-Id!</div>');
                         redirect('reset');
                    }
               }
               else
               {
                  
                    redirect('reset');
               }
          }
     }
	 

public function password()
     {
      $merchant_id = $this->uri->segment(3);
       $token = $this->uri->segment(4);
     //  // $merchant_id = '413';
     //  // $token = '20201029031057000000';

     //   $token_detail = $this->db->query("select * from change_password where merchant_id='".$merchant_id."' and token='".$token."' ")->num_rows();
       
     // if($token_detail ==1) {
             if ($this->input->post('btn_login') == "Reset")
               {

 
    $password1 = $_POST['password'];
     $token = $_POST['token'];
      $merchant_id = $_POST['merchant_id'];
       $token_detail = $this->db->query("select * from change_password where merchant_id='".$merchant_id."' and token='".$token."' and status='0' ")->num_rows();

       

        // $this->form_validation->set_rules("password", "required");

       $this->form_validation->set_rules("password", "Password", "required");

          if ($this->form_validation->run() == FALSE)
          {
           
          echo "stringrrrr"; die();

                 $this->load->view('reset_password');

          }
            else if($token_detail==1){
                 // $merchant_data = $this->profile_model->get_merchant_details($merchant_id);
                // print_r($merchant_data[0]->email);
                 
                  $password = $this->my_encrypt( $password1 , 'e' );
                 
                 //die();
                //$usr_update = $this->reset_model->update($username,$password);
                 $usr_update = $this->db->query("update merchant set password='".$password."' where id='".$merchant_id."'  ");

                 $usr_updatee = $this->db->query("update change_password set status='1' where merchant_id='".$merchant_id."' and token='".$token."' ");

                   $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Password Change Successfully  </div>');
                              redirect(base_url().'login');
                            }

                 }
               else
               {   
                   $merchant_id = $this->uri->segment(3);
                   $token = $this->uri->segment(4);


     $token_detail = $this->db->query("select * from change_password where merchant_id='".$merchant_id."' and token='".$token."' and status='0'")->num_rows();
     //echo $token_detail;
       //echo "string"; die();
      if($token_detail ==1) {
                
                    $this->load->view('reset_password');
                  }
                  else
                  {
                         $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Reset Password Link Not Valid </div>');
                             redirect(base_url().'reset/merchant');
                  }
               }

         
     }

   public function merchant()
     {
      
          
          $username = $this->input->post("email_id");
    

          $this->form_validation->set_rules("email_id", "Username", "trim|required");

          if ($this->form_validation->run() == FALSE)
          {

               $this->load->view('forgot_password');
          }
          else
          {

             
               if ($this->input->post('btn_login') == "Reset")
               {
               
                    $usr_result = $this->reset_model->get_merchant($username); 
                  //echo $this->db->last_query(); 
                 
                    if ($usr_result > 0) 
                    {
                      //print_r($usr_result); die;   
                     $usr_result_merchant = $this->reset_model->get_merchant_detail($username);
                      
                         
                              $password1 = time();
                              $token = date("Ymdhmsu");
                              $merchant_id=$usr_result_merchant['0']['id'];
                             
                             $getQuery_delete = $this->db->query(" DELETE FROM change_password where merchant_id='".$merchant_id."' "); 
                              $getQuery_a = $this->db->query("INSERT INTO change_password (merchant_id, token)
VALUES ('".$merchant_id."', '".$token."') ");
                              //$password = $this->my_encrypt( $password1 , 'e' );
                              //$usr_update = $this->reset_model->update_merchant($username,$password);
            $url = base_url().'reset/password/'.$merchant_id.'/'.$token;



                              set_time_limit(3000); 
                              $MailTo = $username; 
                              $MailSubject = 'Reset Password Link'; 
                              $header = "From: Salequick<info@salequick.com>\r\n".
                              "MIME-Version: 1.0" . "\r\n" .
                              "Content-type: text/html; charset=UTF-8" . "\r\n"; 
                              $msg = " Reset Link : ".$url." ";
                              ini_set('sendmail_from', $username); 
                              // mail($MailTo, $MailSubject, $msg, $header);
                              $this->email->from('reply@salequick.com', 'Reset Password Link');
                              $this->email->to($MailTo);
                              $this->email->subject($MailSubject);
                              $this->email->message($msg);
                              $this->email->send();
                              // $this->session->set_userdata($sessiondata);
                              $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please Check Your Email-Id For Reset Password Link  </div>');
                              redirect(base_url().'reset/merchant');
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email-Id!</div>');
                         redirect(base_url().'reset/merchant');
                    }
               }
               else
               {
                 
                    redirect(base_url().'reset/merchant');
               }
          }
     }
      

   public function merchant_old()
     {
      
          
          $username = $this->input->post("email_id");
    // echo $username;die;

          $this->form_validation->set_rules("email_id", "Username", "trim|required");

          if ($this->form_validation->run() == FALSE)
          {
               $this->load->view('forgot_password');
          }
          else
          {
               if ($this->input->post('btn_login') == "Reset")
               {
                    $usr_result = $this->reset_model->get_merchant($username); //echo $this->db->last_query(); print_r($usr_result); die;
                    if ($usr_result > 0) 
                    {
                            
                              $password1 = time();
                              $password = $this->my_encrypt( $password1 , 'e' );
                              $usr_update = $this->reset_model->update_merchant($username,$password);
                              set_time_limit(3000); 
                              $MailTo = $username; 
                              $MailSubject = 'Update Password Successful'; 
                              $header = "From: Salequick<info@salequick.com>\r\n".
                              "MIME-Version: 1.0" . "\r\n" .
                              "Content-type: text/html; charset=UTF-8" . "\r\n"; 
                              $msg = " Your user id : ".$username.". Password : ".$password1.".";
                              ini_set('sendmail_from', $username); 
                              // mail($MailTo, $MailSubject, $msg, $header);
                              $this->email->from('reply@salequick.com', 'Update Password Successful');
                              $this->email->to($MailTo);
                              $this->email->subject($MailSubject);
                              $this->email->message($msg);
                              $this->email->send();
                              // $this->session->set_userdata($sessiondata);
                              $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please Check Your Email-Id For New Password </div>');
                              redirect(base_url().'reset/merchant');
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email-Id!</div>');
                         redirect(base_url().'reset/merchant');
                    }
               }
               else
               {
                  
                    redirect(base_url().'reset/merchant');
               }
          }
     }
      





	
	  public function subadmin()
     {
	 
	 
          $username = $this->input->post("admin_email");
     

          $this->form_validation->set_rules("admin_email", "Username", "trim|required");

          if ($this->form_validation->run() == FALSE)
          {
               $this->load->view('subadmin/reset');
          }
          else
          {
               if ($this->input->post('btn_login') == "Reset")
               {
                    $usr_result = $this->reset_model->get_userb($username);
                    if ($usr_result > 0) 
                    {
					$password1 = time();
                         $password = $this->my_encrypt( $password1 , 'e' );
                         $usr_update = $this->reset_model->bupdate($username,$password);
						 
                         set_time_limit(3000); 
                         $MailTo = $username; 
                         $MailSubject = 'Update Password Successful'; 
                         $header = "From: Salequick<info@salequick.com>\r\n".
                         "MIME-Version: 1.0" . "\r\n" .
                         "Content-type: text/html; charset=UTF-8" . "\r\n"; 
                         $msg = " Your user id : ".$username.". Password : ".$password1.".";
                         ini_set('sendmail_from', $username); 
				     //mail($MailTo, $MailSubject, $msg, $header);
                         $this->email->from('reply@salequick.com', 'Update Password Successful');
                         $this->email->to($MailTo);
                         $this->email->subject($MailSubject);
                         $this->email->message($msg);
                         $this->email->send();
                        // $this->session->set_userdata($sessiondata);
				     $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please Check Your Email-Id For New Password </div>');
                         redirect('reset/subadmin');
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email-Id!</div>');
                         redirect('reset/subadmin');
                    }
               }
               else
               {
			   
                    redirect('reset/subadmin');
               }
          }
     }
	 
}

	 
