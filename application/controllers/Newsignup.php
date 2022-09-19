<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Newsignup extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->helper('html');

        $this->load->library('form_validation');

        $this->load->model('Home_model');

        $this->load->model('Admin_model');

        $this->load->library('email');

        $this->load->library('twilio');

        date_default_timezone_set("America/Chicago");
        //$this->load->model('notification'); 

    }

public function stepfour_signup()
    {

         
        //$name = $this->input->post('mbname') ? $this->input->post('mbname') : "";
        //$mobile = $this->input->post('mphone') ? $this->input->post('mphone') : "";
        //$email = $this->input->post('memail') ? $this->input->post('memail') : "";
        $last_merchantId = $this->session->userdata('last_merchantId');
        $this->db->where('id', $last_merchantId);
        $getresult = $this->db->get('merchant')->row_array();
        // print_r($getresult['mob_no']); die();
        $name = $getresult['name'];
        $mobile = $getresult['mob_no'];
        $email = $getresult['email'];
        
        $routeNo = $this->input->post('routeNo')?$this->input->post('routeNo'):''; 
        $confrouteNo = $this->input->post('confrouteNo')?$this->input->post('confrouteNo'):"";
        if ($routeNo == $confrouteNo) {
            $routingno = $this->input->post('routeNo');
        } else {
            echo '400';
        }
        
        $accountnumber_one = $this->input->post('accno')?$this->input->post('accno'):'';
        $caccountnumber = $this->input->post('confaccno')?$this->input->post('confaccno'):"";
        if ($accountnumber_one == $caccountnumber) {
            $accountnumber = $this->input->post('accno');
        } else {
            echo '400';
        }
        
        //print_r($email);  die();
        $today1 = date("Ymdhisu");
        $unique = "SAL" . $today1;
        $merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
        $data = array(
            "bank_dda"=>$this->input->post('baccachtype') ? $this->input->post('baccachtype'):'', 
            "bank_ach"=>$this->input->post('baccachtype') ? $this->input->post('baccachtype'):'', 
            "bank_routing" => $routingno,
            "bank_account" => $accountnumber,
            "auth_key" => $unique,
            "merchant_key" => $merchant_key,
            'status' => 'block',
        );
      
        if ($routingno && $accountnumber ) {
            //$result=$this->Home_model->insert_data("merchant", $data);
            $this->db->where('id', $last_merchantId);
            $this->db->update('merchant', $data);
            $this->session->unset_userdata('last_merchantId');
            $this->session->unset_userdata('step');
            $url = base_url() . "confirm/" . $unique;
            set_time_limit(3000);

            $MailTo = $email;
            $htmlContent = '<!DOCTYPE html>
      <html>
      <head>
      <title></title>
      <meta charset="utf-8">
      <title></title>
      <meta charset="utf-8" />
      <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet" />
      </head>
      <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
      <div style="max-width: 900px;margin: 0 auto;">
      <div style="color:#fff;">
      <div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">
      <div style="width:80%;margin:0 auto;">
      <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 10px;"><img src="https://salequick.com/email/images/logo.png" style="width:90%; height:90%;margin-top: 10px;" /></div>
      <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600"><br />
      Registration</h3>
      </div>
      </div>
      <div style="background-color: #437ba8;overflow: hidden;">
      <div style="width:80%;text-align:right;margin:20px auto;">
      <div style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">
      <div style="width:33.3%;float:left;text-align:center"><span>Name</span></div>
      <div style="width:33.3%;float:left;text-align:center"><span>Email</span></div>
      <div style="width:33.3%;float:left;text-align:center"><span>Phone </span></div>
      <!--<span style="float:left">Start Date </span>                         <span style="float:right">January 8,2020</span>--></div>
      <div style="clear:both">&nbsp;</div>
      <hr style="margin-top: 5px; margin-bottom: 10px; border: 0; border-top: 1px solid #eee;" />
      <div style="display:block;margin-bottom:25px;overflow: hidden;">
      <div style="width:33.3%;float:left;text-align:center"><span>' . $name . '</span></div>
      <div style="width:33.3%;float:left;text-align:center"><span>' . $email . '</span></div>
      <div style="width:33.3%;float:left;text-align:center"><span>' . $mobile . ' </span></div>
      </div>
      </div>
      </div>
      </div>
      <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
      <div style="width:80%;margin:0 auto;overflow:hidden">
      <div style="width:60%;margin:10px auto 20px;text-align:center">
      <p>Click this Url: : <a href="' . $url . '"> ' . $url . '</a></p>
      </div>
      <hr style="margin-top: 5px; margin-bottom: 20px; border: 0; border-top: 1px solid #eee;" />
      <div style="clear:both">&nbsp;</div>
      </div>
      </div>
      <footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
      <div style="text-align:center;width:80%;margin:0 auto">
      <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with question and concerns.</h5>
      <p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>
      <p style="color: #868484;">You are receiving something because purchased something at Company name</p>
      <p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
      </div>
      </footer>
      </div>
      </body>
      </html>
      ';
            //print_r($htmlContent); die();
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $MailSubject = 'Salequick Registration Confirmation ';
            $this->email->from('info@salequick.com', 'Confirm Email');
            $this->email->to($email);
            $this->email->subject($MailSubject);
            $this->email->message($htmlContent);
            $this->email->send();
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Member Business Registration Successfully.. </div>');
            //echo $this->session->flashdata('success'); die();
            //redirect(base_url("signup"));
            //redirect(base_url("login"));
            echo '200';
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Somthing Event Wrong!..</div>');
            //echo $this->session->flashdata('error'); die();
            //redirect(base_url("signup"));
            echo '500';
        }
    }
    public function stepthree_signup()
    {
        $dobYear=$this->input->post('fodoby') ? $this->input->post('fodoby'):"";
        $dobMonth=$this->input->post('fodobm') ? $this->input->post('fodobm'):"";
        $dobDate=$this->input->post('fodobd') ? $this->input->post('fodobd'):"";
        $DOB=$dobYear.'-'.$dobMonth.'-'.$dobDate; 
        
        $data = array(
            'o_email' => $this->input->post('fo_email') ? $this->input->post('fo_email'):"",
            "o_phone" => $this->input->post('fo_phone') ? $this->input->post('fo_phone'):"",
            'o_dob_d' => $dobDate,
            'o_dob_m' => $dobMonth,
            'o_dob_y' => $dobYear,
            'dob' => $DOB,
            'o_address1' => $this->input->post('fohadd_1') ? $this->input->post('fohadd_1'):"",
            'o_address2' => $this->input->post('fohadd_2') ? $this->input->post('fohadd_2'):"",
            'o_city' => $this->input->post('fohadd_city') ? $this->input->post('fohadd_city'):"",
            'o_country' => $this->input->post('fohadd_cntry') ? $this->input->post('fohadd_cntry'):"",
            'o_state' => $this->input->post('fohadd_state') ? $this->input->post('fohadd_state'):"",
            'o_zip' => $this->input->post('fohadd_zip') ? $this->input->post('fohadd_zip'):"",
            'o_ss_number' => $this->input->post('fossn') ? $this->input->post('fossn'):"",
            'o_name' => $this->input->post('foname1') ? $this->input->post('foname1'):"",
            'name' => $this->input->post('foname1') ? $this->input->post('foname1'):"",
            'm_name' => $this->input->post('foname2') ? $this->input->post('foname2'):"",
            'l_name' => $this->input->post('foname3') ? $this->input->post('foname3'):""
            
            
        );

        // echo json_encode($data);  die(); 
        $last_merchantId = $this->session->userdata('last_merchantId');
        if (
            isset($_POST['fo_email']) && isset($_POST['fo_phone']) && isset($_POST['fodobd']) && isset($_POST['fodobm']) && 
            isset($_POST['fodoby']) && isset($_POST['fohadd_1']) && isset($_POST['fohadd_2']) && isset($_POST['fohadd_city']) &&
             isset($_POST['fohadd_cntry']) &&
            isset($_POST['fohadd_state']) && isset($_POST['fohadd_zip']) && isset($_POST['foname1']) && isset($_POST['foname2']) && isset($_POST['foname3']) && 
            isset($_POST['fossn']) 
        ) {
            //$result=$this->Home_model->insert_data("merchant", $data);
            $this->db->where('id', $last_merchantId);
            $this->db->update('merchant', $data);
            // echo $this->db->last_query();  die(); 
            $this->session->set_userdata('last_merchantId', $last_merchantId);
            $this->session->set_userdata('step', 'three');
            echo json_encode($data);
        }
    }
    public function steptwo_signup()
    {   $data = array(
        'business_dba_name' => $this->input->post('bsns_dbaname') ? $this->input->post('bsns_dbaname'):"",
        "business_email" => $this->input->post('bsns_email') ? $this->input->post('bsns_email'):"",
        'business_name' => $this->input->post('bsns_name') ? $this->input->post('bsns_name'):"",
        'ownershiptype' => $this->input->post('bsns_ownrtyp') ? $this->input->post('bsns_ownrtyp'):"",
        'business_number' => $this->input->post('bsns_phone') ? $this->input->post('bsns_phone'):"",
        'day_business' => $this->input->post('bsns_strtdate_d') ? $this->input->post('bsns_strtdate_d'):"",
        'month_business' => $this->input->post('bsns_strtdate_m') ? $this->input->post('bsns_strtdate_m'):"",
        'year_business' => $this->input->post('bsns_strtdate_y') ? $this->input->post('bsns_strtdate_y'):"",
        'taxid' => $this->input->post('bsns_tin') ? $this->input->post('bsns_tin'):"",
        'business_type' => $this->input->post('bsns_type') ? $this->input->post('bsns_type'):"",
        'website' => $this->input->post('bsns_website') ? $this->input->post('bsns_website'):"",
        'address1' => $this->input->post('bsnspadd_1') ? $this->input->post('bsnspadd_1'):"",
        'address2' => $this->input->post('bsnspadd_2') ? $this->input->post('bsnspadd_2'):"",
        'city' => $this->input->post('bsnspadd_city') ? $this->input->post('bsnspadd_city'):"",
        'country' => $this->input->post('bsnspadd_cnttry') ? $this->input->post('bsnspadd_cnttry'):"",
        'state' => $this->input->post('bsnspadd_state') ? $this->input->post('bsnspadd_state'):"",
        'zip' => $this->input->post('bsnspadd_zip') ? $this->input->post('bsnspadd_zip'):"",
        'customer_service_email' => $this->input->post('custServ_email') ? $this->input->post('custServ_email'):"",
        'customer_service_phone' => $this->input->post('custServ_phone') ? $this->input->post('custServ_phone'):"",
        'annual_processing_volume' => $this->input->post('mepvolume') ? $this->input->post('mepvolume'):""
        
     );
        


       
        //echo json_encode($data);  die(); 
        $last_merchantId = $this->session->userdata('last_merchantId');
        if (isset($_POST['bsns_dbaname']) && isset($_POST['bsns_email']) && isset($_POST['bsns_name']) && isset($_POST['bsns_ownrtyp']) && isset($_POST['bsns_phone']) &&
        isset($_POST['bsns_strtdate_d']) && isset($_POST['bsns_strtdate_m']) && isset($_POST['bsns_strtdate_y']) && isset($_POST['bsns_tin']) && 
        isset($_POST['bsns_type']) && isset($_POST['bsns_website']) && isset($_POST['bsnspadd_1']) && isset($_POST['bsnspadd_2']) && isset($_POST['bsnspadd_city']) &&
        isset($_POST['bsnspadd_cnttry']) && isset($_POST['bsnspadd_state']) && isset($_POST['bsnspadd_zip']) && isset($_POST['custServ_email']) && isset($_POST['custServ_phone']) && 
        isset($_POST['mepvolume']) 
        ) {
            //$result=$this->Home_model->insert_data("merchant", $data);
            $this->db->where('id', $last_merchantId);
            $this->db->update('merchant', $data);
            $this->session->set_userdata('last_merchantId', $last_merchantId);
            $this->session->set_userdata('step', 'two');
            echo json_encode($data);
        }
    }
    public function stepone_signup()
    {
        echo "hello"; die();
        $email = $this->input->post('email') ? $this->input->post('email'):'';
        $password_one = $this->input->post('password') ? $this->input->post('password') :'';
        $cpassword = $this->input->post('mconfpass') ? $this->input->post('mconfpass') :'';
         
        if ($password_one == $cpassword) {
            $password1 = $this->input->post('password');
        } else {
            // return
            // $password1=$this->input->post('password');
            echo json_encode('200');
        }
        $merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
        $password = $this->my_encrypt($password1, 'e');
        $data = array(
           
            "email" => $this->input->post('email'),
            "password" => $password
        );
        if ( $email  && $password_one && $cpassword) {
            $result = $this->Home_model->insert_data("merchant", $data);
            $this->session->set_userdata('last_merchantId', $result);
            $this->session->set_userdata('merchant_key', $merchant_key);
            $this->session->set_userdata('step', 'one');
            echo json_encode($data);
            // echo 'run';

        }
    }
// sign up step new change



}