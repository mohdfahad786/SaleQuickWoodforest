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

class New_recurring_same_date_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->library('email');
        $this->load->library('twilio');
        date_default_timezone_set('America/Chicago');
       // ini_set('display_errors', 1);
       // error_reporting(E_ALL);

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



public function recurring_invoice_request_post() {

    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {
   
    $aa = $this->admin_model->s_fee("merchant", $merchant_id);
    $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
    $s_fee = $merchantdetails['0']['s_fee'];
    $t_fee =$merchantdetails['0']['t_fee'];
    $merchant_name = $merchantdetails['0']['name'];
    $fee_invoice = $merchantdetails['0']['invoice'];
    $fee_swap = $merchantdetails['0']['f_swap_Recurring'];
    $fee_email = $merchantdetails['0']['text_email'];
    $names = substr($merchant_name, 0, 3); 
    
    $merchant_status = $this->session->userdata('merchant_status');
    $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
      
      $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
    $orignal_amount = $this->input->post('orignal_amount') ? $this->input->post('orignal_amount') : "0.00";

      if (!empty($this->session->userdata('subuser_id'))) {
        $sub_merchant_id = $this->session->userdata('subuser_id');
      } else {
        $sub_merchant_id = '0';
      }
      $fee1 = ($amount / 100) * $fee_invoice;
      $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
      $fee_email = ($fee_email != '') ? $fee_email : 0;
      $fee = $fee1 + $fee_swap + $fee_email;
      $sub_amount = $this->input->post('sub_total') ? $this->input->post('sub_total') : "";
      $title = $this->input->post('title') ? $this->input->post('title') : "";
      $app_type  = $this->input->post('app_type') ? $this->input->post('app_type') : "";
      $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
      $invoice_no_1= 'INV' .  date("ymdhisu");
      $invoice_no = str_replace("000000", "", $invoice_no_1);
      $recurring_payment = 'start';
      $other_charges_state = $this->input->post('other_charges_state') ? $this->input->post('other_charges_state') : "0";
      
        $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
        $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
      
        $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";
         //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
        $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
        $name = $this->input->post('name') ? $this->input->post('name') : "";
        $email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
        $phone=$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
        //$recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";

        $recurring_type1 = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
        $myArray = explode(',', $recurring_type1);
        $recurring_type=strtolower(trim($myArray[0]));

        if($recurring_type=='weekly'){
        $recurring_type_weekly=strtolower(trim($myArray[1]));
        $recurring_type_monthly='';
        }
        else if($recurring_type=='monthly'){
        $recurring_type_weekly='';
        $recurring_type_monthly=strtolower(trim($myArray[1]));
        }
        else
        {
        $recurring_type_weekly='';
        $recurring_type_monthly='';
        }



        $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
        
        $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
         
        // $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
        $recurring_pay_start_date = $this->input->post('recurring_pay_start_date') ? $this->input->post('recurring_pay_start_date') : "";
        $note = $this->input->post('note') ? $this->input->post('note') : "";
        $reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
         
        $address = $this->input->post('address') ? $this->input->post('address') : "";
        $country = $this->input->post('country') ? $this->input->post('country') : "";
        $city = $this->input->post('city') ? $this->input->post('city') : "";
        $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
        //$name_card = $this->input->post('nameoncard') ? $this->input->post('nameoncard') : "";
        $expiry_month = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
        $expiry_year = $this->input->post('exp_year') ? $this->input->post('exp_year') : "";
        $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
        $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
       // $toke_rec = $this->input->post('token') ? $this->input->post('token') : "0";
         $toke_rec = '1';
        $tokenVal = $this->input->post('token') ? $this->input->post('token') : "0";
        $status = $this->input->post('status') ? $this->input->post('status') : "";
        $transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
        $auth_code = $this->input->post('auth_code') ? $this->input->post('auth_code') : "";
        $message_a = $this->input->post('message') ? $this->input->post('message') : "";
         
        /////////// token paramter
         $token = $_POST['token'] ? $_POST['token'] : "";
            $name_card = $_POST['name_token'] ? $_POST['name_token'] : "";
            $card_type = $_POST['card_type'] ? $_POST['card_type'] : "";
            $card_expiry_month = $_POST['card_expiry_month'] ? $_POST['card_expiry_month'] : "";
            $card_expiry_year = $_POST['card_expiry_year'] ? $_POST['card_expiry_year'] : "";
            $card_no = $_POST['card_no'] ? $_POST['card_no'] : "";
            $zipcode = $_POST['zipcode'] ? $_POST['zipcode'] : "";
            $mobile = $_POST['mobile_token'] ? $_POST['mobile_token'] : "";
            $email = $_POST['email_token'] ? $_POST['email_token'] : "";

          /////////////
     
         //echo $pd__constant;   // pd__constant
          //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
         if($pd__constant=='on' &&  $recurring_count=="")
         {
           $recurring_count=-1; 
         }   
         // echo $recurring_count;  die();
       
        if($paytype=='0' ||  $paytype=='1')
         {  
                  //echo $recurring_count;  die(); 
                 
                  $today1_1 = date("ymdhisu");
                  $today1 = str_replace("000000", "", $today1_1);
                  $url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
                  $today2 = date("Y-m-d");
                  $year = date("Y");
                  $month = date("m");
                  $today3 = date("Y-m-d H:i:s");
                  $unique = "PY" . $today1;
                  $time11 = date("H");
                  if ($time11 == '00') {
                    $time1 = '01';
                  } else {
                    $time1 = date("H");
                  }
                  
                  $recurring_pay_start_date=date($recurring_pay_start_date); 
                  //echo $recurring_type;  die(); 
                  
        
          switch($recurring_type)
                {
                  case 'daily':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'weekly':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'biweekly':
                     $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
                  break;
                  case 'monthly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'quarterly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'yearly':
                  $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
                  break;
                  default :
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break; 
                  
                }

                
          
    if($status=='confirm')

      {
       
         
                        $card_a_no = $card_no;
                        $trans_a_no = $transaction_id;
                        $auth_code = $auth_code;
                        $recurring_count_paid=1;
                        $payment_date=date('Y-m-d');

                         if($recurring_count > 0)
                          {
                            $remain = $recurring_count-1;
                          }
                          else
                          {
                            $remain=1; 
                          }
                             $card_a_type =$card_type;
                            if($card_a_type=='mc')
                            {
                              $card_a_type ='MasterCard';
                            }
                            
                            else
                             {
                               $card_a_type =ucfirst($card_a_type);
                             }   
                    }
                    else if($status =='declined')
                    {
                        $recurring_count_paid=0;
                        $payment_date=date('Y-m-d');

                         if($recurring_count > 0)
                          {
                            //$remain = $recurring_count-1;
                             $remain = $recurring_count;
                          }
                          else
                          {
                            $remain=1; 
                          }
                        
                    }
                   
                  
      else
      {
          $status = 'pending';
          $card_a_no = '';
          $trans_a_no = '';
          $auth_code = '';
          $card_a_type='';
          $message_a = '';
          $payment_date='';
          $recurring_count_paid=0;
          if($recurring_count > 0)
                  {
                    $remain = $recurring_count;
                  }
                  else
                  {
                    $remain=1; 
                    
                  }
      }
          // die("ok"); 


          $day1 = date("N");
          $data = Array(
            'reference' => $reference,
            'name' => $name,
            'other_charges' => $other_charges,
            'otherChargesName' => $other_charges_title,
            'invoice_no' => $invoice_no,
            'email_id' => $email_id,
            'mobile_no' => $mobile_no,
            'amount' => $amount,
            'orignal_amount' => $orignal_amount,
            'sub_total' => $sub_amount,
            'tax' => $total_tax,
            'fee' => $fee,
            's_fee' => $fee_swap,
            'title' => $title,
            'detail' => $remark,
            'note' => $note,
            'url' => $url,
            'payment_type' => 'recurring',
            'recurring_type' => $recurring_type,
            'recurring_type_week' => $recurring_type_weekly,
            'recurring_type_month' => $recurring_type_monthly,
            'recurring_count' => $recurring_count,
            'recurring_count_paid' => $recurring_count_paid,
            'recurring_count_remain' => $remain,
            'recurring_pay_start_date' => $recurring_pay_start_date,
            'recurring_next_pay_date' => $recurring_next_pay_date,
            'recurring_pay_type' => $paytype,
            'payment_date' => $payment_date,
            'no_of_invoice' => 1,
            // 'due_date' => $due_date,
            'merchant_id' => $merchant_id,
            'sub_merchant_id' => $sub_merchant_id,
            'payment_id' => $unique,
            'recurring_payment' => $recurring_payment,
            'year' => $year,
            'month' => $month,
            'time1' => $time1,
            'day1' => $day1,
            'status' => $status,
            'transaction_id' => $trans_a_no,
            'auth_code' => $auth_code,
            'message' =>  $message_a,
            'card_type' =>  $card_a_type,
            'card_no' =>  $card_a_no,
            'name_card' =>  $name_card,
            'date_c' => $today2,
            'order_type' => 'a',
            'processor_name' => 'PAYROC',
            'payment_device'=>'app',
            'app_type'=>$app_type,
            'other_charges_state' => $other_charges_state,
            'token' => $toke_rec
            
          );
            
          $id = $this->admin_model->insert_data("customer_payment_request", $data);
         
          
          $MailTo = $email_id;
          $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
          $getDashboardData_m = $getDashboard_m->result_array();
          $data['getDashboardData_m'] = $getDashboardData_m;
          $data['business_name'] = $getDashboardData_m[0]['business_name'];
          $data['address1'] = $getDashboardData_m[0]['address1'];
          $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
          $data['logo'] = $getDashboardData_m[0]['logo'];
          $data['business_number'] = $getDashboardData_m[0]['business_number'];
          $data['color'] = $getDashboardData_m[0]['color'];
          $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
          $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
          $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
          $data['payment_type'] = 'recurring';
          $data['recurring_type'] = $recurring_type;
          $data['no_of_invoice'] = 1;
          $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';


          /////////////token
           
            $mob = str_replace(array( '(', ')','-',' ' ), '', $mobile);
            $statuss = '1';
            $payroc = '1';
           
                        $data_token = array(
                         'merchant_id' =>$merchant_id,
                         'name' =>$name_card,
                         'token' =>$token,
                         'card_type' =>$card_type,
                         'card_expiry_month' =>$card_expiry_month,
                         'card_expiry_year' =>$card_expiry_year,
                         'card_no' =>$card_no, 
                         'zipcode' =>$zipcode,
                         'mobile' =>$mob, 
                         'email' =>$email,
                         'status' =>$statuss, 
                         'payroc' =>$payroc,
                                                                 
                        );
                        $idd = $this->admin_model->insert_data("token", $data_token);

                        $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'token_id' =>$idd,
                        'invoice_no'=>$invoice_no,
                        'status'=>$statuss, 
                       
                        );
                        $pax_id = $this->admin_model->insert_data("invoice_token", $data_pax);

                        //print_r($pax_id); die();

          /////////////////////end token

          ////////////////////////////email
        
          if ($status=='pending') {   
                        if (!empty($email_id)) {
                            $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
                            $getEmail = $getQuery->result_array();
                            $data['getEmail'] = $getEmail;

                            $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
                            $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
                            $data['getEmail1'] = $getEmail1; 
                            $data['resend'] = "";
                            $email = $getEmail[0]['email_id'];
                            $invoice_no = $getEmail[0]['invoice_no'];
                            $status = $getEmail[0]['status'];
                            $token = $getEmail[0]['token'];
                            $url = $getEmail[0]['url'];
                            $purl = str_replace('rpayment', 'reciept', $url); 
                            $durl='https://salequick.com/add_card/'.$payment_id.'/'.$merchant_id.'/'.$invoice_no;
           
                            $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                            $recurring_pay_type = $getEmail[0]['recurring_pay_type'];
                            $amount = $getEmail[0]['amount'];  
                            $sub_total =$getEmail[0]['sub_total'];
                            $tax = $getEmail[0]['tax']; 
                            $originalDate = $getEmail[0]['date_c'];
                            $newDate = date("F d,Y", strtotime($originalDate)); 
                            //Email Process
                            $data['business_dba_name'] = $getEmail1[0]['business_dba_name'];
                            $data['email'] = $getEmail[0]['email_id'];
                            $data['color'] = $getEmail1[0]['color'];
                            $data['logo'] = $getEmail1[0]['logo'];
                            $data['amount'] = $amount;  
                            $data['sub_total'] = $sub_total;
                            $data['tax'] = $tax; 
                            $data['originalDate'] = $getEmail[0]['date_c'];
                            $data['card_a_no'] = $getEmail[0]['card_no'];
                            $data['trans_a_no'] = $getEmail[0]['transaction_id'];
                            $data['card_a_type'] = $getEmail[0]['card_type'];
                            $data['message_a'] = $getEmail[0]['message'];
                            $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
                            $data['late_fee'] = $getEmail[0]['late_fee'];
                            $data['payment_type'] = 'recurring';
                            $data['recurring_type'] = $getEmail[0]['recurring_type'];
                            $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
                            $data['recurring_count'] =$getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
                            $today=date('Y-m-d');

                            $data['msgData'] = $data;

                            $msg = $this->load->view('email/invoice1', $data, true);
                            $MailSubject = ' Invoice from ' . $getDashboardData_m[0]['business_dba_name'];

                            $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
                            $this->email->to($email_id);
                            $this->email->subject($MailSubject);
                            $this->email->message($msg);
                            $this->email->send();
                        }

                        if (!empty($mobile_no)) {
                            $sms_reciever = $mobile_no;
                            // $sms_message = "Hello ".$name." from ".$getDashboardData_m[0]['business_dba_name']."  is requesting  ".$amount."  payment from you <a href='".$url."'>CONTINUE TO PAYMENT</a>";
                            $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '" . $url . "' ");
                            // $sms_message = trim('Payment Url : '.$url);
                            $from = '+18325324983'; //trial account twilio number
                            $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                            $to = '+1' . $mob;
                            $response = $this->twilio->sms($from, $to, $sms_message);
                            //print_r($response->HttpStatus);
                            //print_r($response->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );
                        }
                    }

                    if($status=='confirm'){
                    
                        $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
                        $getEmail = $getQuery->result_array();
                        $data['getEmail'] = $getEmail;

                        $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
                        $getEmail1 = $getQuery1->result_array();
                        //print_r($getEmail1);  die(); 
                        $data['getEmail1'] = $getEmail1; 
                        $data['resend'] = "";
                        $email = $getEmail[0]['email_id'];
                        $invoice_no = $getEmail[0]['invoice_no'];
                        $status = $getEmail[0]['status'];
                        $token = $getEmail[0]['token'];
                        $url = $getEmail[0]['url'];
                        $purl = str_replace('rpayment', 'reciept', $url); 
                        $durl='https://salequick.com/add_card/'.$payment_id.'/'.$merchant_id.'/'.$invoice_no;
           
                        $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                        $recurring_pay_type = $getEmail[0]['recurring_pay_type'];
                        $amount = $getEmail[0]['amount'];  
                        $sub_total =$getEmail[0]['sub_total'];
                        $tax = $getEmail[0]['tax']; 
                        $originalDate = $getEmail[0]['date_c'];
                        $newDate = date("F d,Y", strtotime($originalDate)); 
                        //Email Process
                        $data['business_dba_name'] = $getEmail1[0]['business_dba_name'];
                        $data['email'] = $getEmail[0]['email_id'];
                        $data['color'] = $getEmail1[0]['color'];
                        $data['logo'] = $getEmail1[0]['logo'];
                        $data['amount'] = $amount;  
                        $data['sub_total'] = $sub_total;
                        $data['tax'] = $tax; 
                        $data['originalDate'] = $getEmail[0]['date_c'];
                        $data['card_a_no'] = $getEmail[0]['card_no'];
                        $data['trans_a_no'] = $getEmail[0]['transaction_id'];
                        $data['card_a_type'] = $getEmail[0]['card_type'];
                        $data['message_a'] = $getEmail[0]['message'];
                        $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
                        $data['late_fee'] = $getEmail[0]['late_fee'];
                        $data['payment_type'] = 'recurring';
                        $data['recurring_type'] = $getEmail[0]['recurring_type'];
                        $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
                        $data['recurring_count'] =$getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
                        $today=date('Y-m-d');

                        $data['msgData'] = $data;

                        if (!empty($email_id)) {
                            $mail_body_1 = $this->load->view('email/rec_setup_success', $data, true);
                            $MailSubject_1 = 'Recurring setup for ' . $getDashboardData_m[0]['business_dba_name'];
                            $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
                           $this->email->to($email_id);
                           $this->email->subject($MailSubject_1);
                           $this->email->message($mail_body_1);
                           $this->email->send();
                           ///////

                           $mail_body = $this->load->view('email/receipt', $data, true);
                            $MailSubject = 'Receipt from '.$getDashboardData_m[0]['business_dba_name'];
                            $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
                           $this->email->to($email_id);
                           $this->email->subject($MailSubject);
                           $this->email->message($mail_body);
                           $this->email->send();
                        }
                        if (!empty($mobile_no)) {
                            $sms_reciever = $mobile_no;
                        
                            $sms_message = trim("Receipt from " . $getDashboardData_m[0]['business_dba_name'] . "  .$purl ");
                            $from = '+18325324983'; //trial account twilio number
                            $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                            $to = '+1' . $mob;
                            $response = $this->twilio->sms($from, $to, $sms_message);
                            //print_r($response->HttpStatus);
                            //print_r($response->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );
                        }
                    }

                    if($status=='declined'){
         
                        $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
                       $getEmail = $getQuery->result_array();
                       $data['getEmail'] = $getEmail;

                       $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
                       $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
                       $data['getEmail1'] = $getEmail1; 
                       $data['resend'] = "";
                       $email = $getEmail[0]['email_id'];
                        $invoice_no = $getEmail[0]['invoice_no'];
                       $status = $getEmail[0]['status'];
                       $token = $getEmail[0]['token'];
                       $url = $getEmail[0]['url'];
                       $purl = str_replace('rpayment', 'reciept', $url); 
                       $durl='https://salequick.com/add_card/'.$payment_id.'/'.$merchant_id.'/'.$invoice_no;
                       
                       $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                       $recurring_pay_type = $getEmail[0]['recurring_pay_type'];
                       $amount = $getEmail[0]['amount'];  
                       $sub_total =$getEmail[0]['sub_total'];
                       $tax = $getEmail[0]['tax']; 
                       $originalDate = $getEmail[0]['date_c'];
                       $newDate = date("F d,Y", strtotime($originalDate)); 
                       //Email Process
                      $data['business_dba_name'] = $getEmail1[0]['business_dba_name'];
                      $data['email'] = $getEmail[0]['email_id'];
                      $data['color'] = $getEmail1[0]['color'];
                      $data['logo'] = $getEmail1[0]['logo'];
                      $data['amount'] = $amount;  
                      $data['sub_total'] = $sub_total;
                      $data['tax'] = $row['tax']; 
                      $data['originalDate'] = $getEmail[0]['date_c'];
                      $data['card_a_no'] = $getEmail[0]['card_no'];
                      $data['trans_a_no'] = $getEmail[0]['transaction_id'];
                      $data['card_a_type'] = $getEmail[0]['card_type'];
                      $data['message_a'] = $getEmail[0]['message'];
                      $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
                      $data['late_fee'] = $getEmail[0]['late_fee'];
                      $data['payment_type'] = 'recurring';
                      $data['recurring_type'] = $getEmail[0]['recurring_type'];
                      $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
                      $data['recurring_count'] =$getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
                      $today=date('Y-m-d');

                      $data['msgData'] = $data;

                        if (!empty($email_id)) {
                            $mail_body = $this->load->view('email/rec_payment_failure', $data, true);
                            $MailSubject = 'Declined Payment from ' . $getDashboardData_m[0]['business_dba_name'];

                            $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
                            $this->email->to($email_id);
                            $this->email->subject($MailSubject);
                            $this->email->message($mail_body);
                            $this->email->send();
                        }
                        if (!empty($mobile_no)) {
                            $sms_reciever = $mobile_no;
                        
                            $sms_message = trim("Declined Payment from " . $getDashboardData_m[0]['business_dba_name'] . "  .$durl ");
                            $from = '+18325324983'; //trial account twilio number
                            $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                            $to = '+1' . $mob;
                            $response = $this->twilio->sms($from, $to, $sms_message);
                            //print_r($response->HttpStatus);
                            //print_r($response->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );
                        }
                    }
       
    
          //////////////////////////////mobile              
 
                  }
      
                        
                        if(!empty($id)){

                             $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Payment Request Send Successfull','id' => $id,'invoice_no' => $invoice_no ];
                        
                        }
                        else
                        {
                             $response = ['status' => 401, 'errorMsg' => 'Payment Request Not Send'];
                        }
                       
                        }
                        else
                        {
                            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
                        }
                        $this->response($response, $status);
}
  


   

}