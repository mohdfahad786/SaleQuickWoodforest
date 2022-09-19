<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class  Api_registration extends CI_Controller {
    function __construct(){
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
    }
    public function index(){
        $this->load->view('api_signup');
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
   
    public function create_signup() {
    
     
       if (isset($_POST['submit'])) {
		$name = $this->input->post('f_name') ? $this->input->post('f_name') : "";
		$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
		$email = $this->input->post('email') ? $this->input->post('email') : "";
		$state = $this->input->post('state') ? $this->input->post('state') : "";
		$city = $this->input->post('city') ? $this->input->post('city') : "";
		$address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
		$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
		$password1 = $this->input->post('password') ? $this->input->post('password') : "";
		$monthly_fee = '39.99';
		$chargeback = '20.00';
		$point_sale = '2.8';
		$invoice = '2.9';
		$recurring = '2.9';
		$text_email = '0.0';
		$f_swap_Invoice = '0.30';
		$f_swap_Recurring = '0.3';
		$f_swap_Text ='0.10';
        $merchant_key = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,51 ) ,1 ) .substr( md5( time() ), 1);
        $password = $this->my_encrypt( $password1, 'e' );
            $this->form_validation->set_rules('f_name', 'First Name', 'required');
           
          $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
            if ($this->form_validation->run() == FALSE) {
              
               $this->load->view("api_registration");
              // redirect("signup");
            } else {
              $today2 = date("Y-m-d");
        $today1 = date("ymdhisu");
        $unique = "SAL" .$today1 ;
                $data = Array(
						"name" => $this->input->post('f_name'),
						"auth_key" => $unique,
						"merchant_key" => $merchant_key,
						"state" => $state,
						"t_fee" => '10',
						"city" => $city,
						"mob_no" => $this->input->post('mobile'),
						"address1" => $address1,
						"address2" => $address2,
						"password" => $password,
						"user_type" => 'merchant',
						"email" => $this->input->post('email'),
						'date_c' => $today2,
						'f_swap_Invoice' => $f_swap_Invoice,
						'f_swap_Recurring' => $f_swap_Recurring,
						'f_swap_Text' => $f_swap_Text,
						'monthly_fee' => $monthly_fee,
						'chargeback' => $chargeback,
						'point_sale' => $point_sale,
						'invoice' => $invoice,
						'recurring' => $recurring,
						'text_email' => $text_email,
						'status' => 'pending',
						'register_type' => 'api',
          );
          
          
               
        $this->Home_model->insert_data("merchant", $data);
              $url="https://salequick.com/confirm/".$unique;
               set_time_limit(3000); 
        $MailTo = $email; 
        // $MailSubject = 'Confirm Email'; 
        // $header = "From: Gateway<info@salequick.com >\r\n".
        //          "MIME-Version: 1.0" . "\r\n" .
        //          "Content-type: text/html; charset=UTF-8" . "\r\n"; 
        //  $msg = " Click this Url: : ".$url.".";
        // ini_set('sendmail_from', $email); 
        // mail($MailTo, $MailSubject, $msg, $header);
        $htmlContent = '<!DOCTYPE html>
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
                                    <h4 style="margin-bottom: 0px;color:#000; ">Api Registration</h4>
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
                                                         '.$mobile.'
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
                                <a href="https://salequick.com/" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick1.com </a>
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
        </html>
';
// $config['mailtype'] = 'html';
// $this->email->initialize($config);
// $this->email->to($email);
// $this->email->from('info@salequick.com','SaleQuick');
// $this->email->subject('Confirm Email');
// $this->email->message($htmlContent);
//$this->email->attach('files/attachment.pdf');
// $this->email->send();

$MailSubject='Confirm Email';


 $this->email->from('reply@salequick.com', 'Confirm Email');
                   $this->email->to($email);
                  $this->email->subject($MailSubject);
                   $this->email->message($htmlContent);
                  $this->email->send();
             
                       
             $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please verify your email to confirm account </div>');
                         redirect("login");
      
        
            }
        } else {
         
      redirect("api_registration");
        }
    }
  
  
    
}
