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
	 


   public function merchant()
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

	 
