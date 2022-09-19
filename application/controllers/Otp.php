<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Otp extends CI_Controller
{

     public function __construct()
     {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->model('reset_model');
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->library('email');
        date_default_timezone_set("America/Chicago");
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
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

 public function index() {
     $admin_id = $this->uri->segment(3);
   //  die();

    $username = $this->input->post("otp");

    $this->form_validation->set_rules("otp", "OTP", "trim|required");

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/otp');

        } else {
            if ($this->input->post('btn_login') == "Reset") {
                $usr_result = $this->reset_model->get_user($username); 
                //echo $this->db->last_query();
                if ($usr_result > 0) {
                    //print_r($usr_result); die;   
                    $usr_result_merchant = $this->reset_model->get_user_detail($username);
                    $password1 = time();
                    $token = date("Ymdhmsu");
                    $token_one= substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
                    $merchant_id=$usr_result_merchant['0']['id'];
                             
                    $getQuery_delete = $this->db->query(" DELETE FROM change_password_admin where merchant_id='".$merchant_id."' "); 
                    $getQuery_a = $this->db->query("INSERT INTO change_password_admin (merchant_id, token, token_one) VALUES ('".$merchant_id."', '".$token."','".$token_one."') ");
                    //$password = $this->my_encrypt( $password1 , 'e' );
                    //$usr_update = $this->reset_model->update_merchant($username,$password);
                    $url = base_url().'reset/password_admin/'.$merchant_id.'/'.$token.'/'.$token_one;

              

                    ini_set('sendmail_from', $username); 
                    // mail($MailTo, $MailSubject, $msg, $header);
                    $this->email->from('reply@salequick.com', 'Reset Password Link');
                    $this->email->to($MailTo);
                    $this->email->subject($MailSubject);
                    $this->email->message($htmlContent);
                    $this->email->send();
                    // $this->session->set_userdata($sessiondata);
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please Check Your Email-Id For Reset Password Link  </div>');
                    redirect(base_url().'reset');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email-Id!</div>');
                    redirect(base_url().'reset');
                }
            } else {
                redirect(base_url().'reset');
            }
        }
    }

 
   

public function otp()
     {
    
             if ($this->input->post('btn_login') == "Reset")
               {

 
    $admin_id = $_POST['admin_id'];
     $otp = $_POST['otp'];
       $token_detail = $this->db->query("select * from otp_detail where admin_id='".$admin_id."' and otp='".$otp."' and status='0' ")->num_rows();

   

       $this->form_validation->set_rules("otp", "Otp", "required");

          if ($this->form_validation->run() == FALSE)
          {
           
             //echo $this->db->last_query();die;
           
         $this->load->view('admin/login_view');

          }
            else if($token_detail==1){

            
                
                 $usr_result = $this->login_model->get_user_id($admin_id); 
               
                    $sessiondata = array( 'id' => $usr_result['id'], 'username' => $usr_result['username'], 
              'time_zone' => 'America/Chicago',
            'user_type' => $usr_result['user_type'],
            'name' => $usr_result['name'],'wf_merchants'=>$usr_result['wf_merchants'], 'image' => $usr_result['image'], 'loginuser' => TRUE
         );
                    //print_r($sessiondata);die;
            $this->session->set_userdata($sessiondata);
            print_r($this->session->userdata); 
            die();

            $data = Array("ip" => $this->input->post("ip"),  "user_type" => 'wf', 'user_id' => $usr_result['id'],  'status' => 'true'  );
     
                $this->Home_model->insert_data("login_detail", $data);
                redirect(base_url().'dashboard');

                
                            }
                            else
               {
                 $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Otp Not Valid </div>');
                             
                             redirect(base_url().'otp/index'.'/'.$admin_id);
               }

                 }
               else
               {   
                  
                         $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Otp Not Valid </div>');
                            redirect(base_url().'otp/index'.'/'.$admin_id);
                  
               }

         
     }


      


   
}

   
