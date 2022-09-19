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

class New_recurring_api extends REST_Controller {

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
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);

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
    $orignal_amount = $this->input->post('amount') ? $this->input->post('orignal_amount') : "";

      if (!empty($this->session->userdata('subuser_id'))) {
        $sub_merchant_id = $this->session->userdata('subuser_id');
      } else {
        $sub_merchant_id = '0';
      }
      $fee = ($amount / 100) * $fee_invoice;
      $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
      $fee_email = ($fee_email != '') ? $fee_email : 0;
      $fee = $fee + $fee_swap + $fee_email;
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
        $phone=$mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
        //$recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";

        $recurring_type1 = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
        $myArray = explode(',', $recurring_type1);
        $recurring_type=strtolower(trim($myArray[0]));

        if($recurring_type=='weekly'){
        $recurring_type_weekly=strtolower(trim($myArray[1]));
        $recurring_type_monthly='';

    $recurring_next_pay_date_week=date('Y-m-d', strtotime('next '.$recurring_type_weekly));

   // echo $recurring_next_pay_date_1=date('Y-m-d', strtotime('+1 month', strtotime($recur_date)));
        }
        else if($recurring_type=='monthly'){
        $recurring_type_weekly='';
        $recurring_type_monthly=strtolower(trim($myArray[1]));
        if($recurring_type_monthly<10)
        {

          $recur_date= date('Y-m-0'.$recurring_type_monthly);
        }
        else
        {
            
             $recur_date= date('Y-m-'.$recurring_type_monthly);
        }


   $recurring_next_pay_date_month=date('Y-m-d', strtotime('+1 month', strtotime($recur_date)));

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
        $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
        $name_card = $this->input->post('nameoncard') ? $this->input->post('nameoncard') : "";
        $expiry_month = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
        $expiry_year = $this->input->post('exp_year') ? $this->input->post('exp_year') : "";
        $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
        $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
        $toke_rec = $this->input->post('token') ? $this->input->post('token') : "0";
        $tokenVal = $this->input->post('tokenVal') ? $this->input->post('tokenVal') : "0";
     
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
                    //$recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
                     $recurring_next_pay_date=$recurring_next_pay_date_month;
                    
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

                
          
    if($toke_rec=='1' && $paytype=='1'  && $tokenVal!='0' && $today2==$recurring_pay_start_date)

    //if($toke_rec=='1' && $paytype=='1'  && $tokenVal!='0' && $today2=='2022-04-26')  

      
      {
       
         $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
            $Merchantdata = $getMerchantdata->row_array();
            $processor_id=$Merchantdata['processor_id'];
            $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
            $paymentcard=$tokenVal; 
            $authorizationcode="";
            $ipaddress=$_SERVER['REMOTE_ADDR'];
            $orderid=$invoice_no;
                 if (!empty($security_key) and !empty($processor_id)){
                          $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
                        $query .= "processor_id=" . urlencode($processor_id) . "&";
                        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
                        $query .= "ipaddress=" . urlencode($ipaddress) . "&";
                        $query .= "orderid=" . urlencode($orderid) . "&";
                        $query .= "customer_vault=update_customer". "&";
                        $query .= "customer_vault_id=". urlencode($paymentcard) . "&";
                    
                        $query .= "type=sale";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                        curl_setopt($ch, CURLOPT_POST, 1);

                        if (!($data3 = curl_exec($ch))) {
                        return ERROR;
                        }
                        curl_close($ch);
                        unset($ch);

                        parse_str($data3, $parsed);
                        $test = json_encode($parsed);
                        $response = json_decode($test, true);


                    }else
                    {
                       $message_complete = 'Error';
                    }
                    //print_r($response);
                    $message_a = $response['responsetext'];

                    if($response['response']==1)
                    {
                      
                        $status = 'confirm'; 
                        $card_a_no = $response['cc_number'];
                        $trans_a_no = $response['transactionid'];
                        $auth_code = $response['authcode'];
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
                            // $card_a_type =$card_type;
                            if($response['cc_type']=='mc')
                            {
                              $card_a_type ='MasterCard';
                            }
                            
                            else
                             {
                               $card_a_type =ucfirst($response['cc_type']);
                             }   
                    }
                    else if($response['response']==2)
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
                         $status = 'declined';
                    }
                    
                    else 
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
                         $status = 'declined';
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
          $amountaa = $sub_amount + $fee;
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
            'date_c' => $today2,
            'order_type' => 'a',
            'payment_device'=>'app',
            'app_type'=>$app_type,
            'other_charges_state' => $other_charges_state,
            'token' => $toke_rec
            
          );
          //print_r($data); die();  
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
  

 public function add_direct_invoice_request_r_mail_post()
{
    $data = array();
    $dataa = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $dataa->merchant_id)
    {
      $merchant_id = $_POST['merchant_id'];
      $payment_id = $_POST['payment_id'];
      $sid = $_POST['id'];
      $type = $_POST['type'];

       $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$payment_id."' ");
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

      
       if ($type == 'email') {
        $stmt = $this->db->query("UPDATE  customer_payment_request set email_id ='".$sid."' where id = '".$payment_id."'");
        
        
    
            if($status=='confirm'){
             $mail_body = $this->load->view('email/receipt', $data, true);
             $MailSubject = 'Receipt from '.$data['business_dba_name'];

             $mail_body_1 = $this->load->view('email/rec_setup_success', $data, true);
             $MailSubject_1 = 'Receipt from ' . $data['business_dba_name'];
              $this->email->from('info@salequick.com', $data['business_dba_name']);
               $this->email->to($email);
               $this->email->subject($MailSubject_1);
               $this->email->message($mail_body_1);
               $this->email->send();

             }

              else if($status=='pending' && $recurring_pay_start_date=$today ){  
             $mail_body = $this->load->view('email/invoice1', $data, true);
             $MailSubject = 'Recurring Invoice from ' . $data['business_dba_name'];
             }
            else if($status=='pending' && $token=='1' ){
             $mail_body = $this->load->view('email/rec_setup_success', $data, true);
             $MailSubject = 'Recurring Setup from ' . $data['business_dba_name'];
           }
           else if($status=='declined'){
             $mail_body = $this->load->view('email/rec_payment_failure', $data, true);
             $MailSubject = 'Declined Payment from ' . $data['business_dba_name'];
           }

             $email = $sid;
          
             if (!empty($email)) {
               $this->email->from('info@salequick.com', $data['business_dba_name']);
               $this->email->to($email);
               $this->email->subject($MailSubject);
               $this->email->message($mail_body);
               $this->email->send();
             }


        $message = '1';
      } else if ($type == 'sms') {

          if($status='pending' && $recurring_pay_start_date=$today ){ 
        $stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."' ");
        
        $mob = str_replace(array('(', ')', '-', ' '), '', $sid);
        $mobile = '+1' . $mob;
                        
         $sms_message = trim(" " . $business_dba_name . " is Requesting  Payment .$url ");
        
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
             } 

          if($status='declined' && $recurring_pay_start_date=$today ){ 
        $stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."' ");
        
        $mob = str_replace(array('(', ')', '-', ' '), '', $sid);
        $mobile = '+1' . $mob;
       $sms_message = trim("Declined Payment from " . $business_dba_name . ": $durl ");

                 
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
             }  

            else if($status='confirm'){
        $stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."' ");
        
        $mob = str_replace(array('(', ')', '-', ' '), '', $sid);
        $mobile = '+1' . $mob;
                        
         $sms_message = trim(" Receipt from " . $business_dba_name . "  .$purl ");
        
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
             }    


        $message = '1';
      }
      if ($message) {
        $status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];
      } else {
        
        $response = ['status' => '401', 'errorMsg' => 'Fail'];
      }
     }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}


 public function resend_decline_request_mail_post()
{
    $data = array();
    $dataa = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $dataa->merchant_id)
    {
      $merchant_id = $_POST['merchant_id'];
      $payment_id = $_POST['payment_id'];
       
    
               $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$payment_id."' ");
               $getEmail = $getQuery->result_array();
               $data['getEmail'] = $getEmail;

               $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
               $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
               $data['getEmail1'] = $getEmail1; 
               $data['resend'] = "";
               $email = $getEmail[0]['email_id'];
               $id = $getEmail[0]['id'];
               $new_merchant_id = $getEmail[0]['merchant_id'];
               $new_invoice_no = $getEmail[0]['invoice_no'];
               $mobile_no = $getEmail[0]['mobile_no'];
               $status = $getEmail[0]['status'];
               $token = $getEmail[0]['token'];
               $url = $getEmail[0]['url'];
               $purl = str_replace('rpayment', 'reciept', $url); 
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
      if (!empty($email)) {
             
             $mail_body = $this->load->view('email/rec_payment_failure', $data, true);
             $MailSubject = 'Salequick Declined  ' . $data['business_dba_name'];
          
             if (!empty($email)) {
               $this->email->from('info@salequick.com', $data['business_dba_name']);
               $this->email->to($email);
               $this->email->subject($MailSubject);
               $this->email->message($mail_body);
               $this->email->send();
             }


        $message = '1';
      } else if (!empty($mobile_no)) {

       
        $mob = str_replace(array('(', ')', '-', ' '), '', $sid);
        $mobile = '+1' . $mob;
                        
         $sms_message = trim(" Receipt from " . $business_dba_name . "  .$purl ");
        
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
           


        $message = '1';
      }
      if ($message) {
        $status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];
      } else {
        
        $response = ['status' => '401', 'errorMsg' => 'Fail'];
      }
     }
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}

public function decline_add_card_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
            $today2=date('Y-m-d');
    if($merchant_id == $data->merchant_id)
    {
            $invoice_no = $_POST['invoice_no'];
            $payment_id = $_POST['payment_id'];
            $token = $_POST['token'];
            $tokenVal=$token;
            $name = $_POST['name'];
            $card_type = $_POST['card_type'];
            $card_expiry_month = $_POST['card_expiry_month'];
            $card_expiry_year = $_POST['card_expiry_year'];
            $card_no = $_POST['card_no'];
            $zipcode = $_POST['zipcode'];
            
            $mobile  = $this->input->post('mobile') ? $this->input->post('mobile') : "";
            $email  = $this->input->post('email') ? $this->input->post('email') : "";
            $status = '1';
            $payroc = '1';

             $getRow_token=$this->db->query(" SELECT token_id FROM invoice_token WHERE invoice_no='$invoice_no' and merchant_id='$merchant_id' and status=1 " )->result_array(); 
                 $token_id=$getRow_token[0]['token_id'] ? $getRow_token[0]['token_id'] :"0";

                 $stmt = $this->db->query("delete FROM `invoice_token`  where invoice_no='".$invoice_no."' ");
                $stmt1 = $this->db->query("delete FROM `token`  where id='".$token_id."' "); 

           
                        $data = array(
                         'merchant_id' =>$merchant_id,
                         'name' =>$name,
                         'token' =>$token,
                         'card_type' =>$card_type,
                         'card_expiry_month' =>$card_expiry_month,
                         'card_expiry_year' =>$card_expiry_year,
                         'card_no' =>$card_no, 
                         'zipcode' =>$zipcode,
                         'mobile' =>$mobile, 
                         'email' =>$email,
                         'status' =>$status, 
                         'payroc' =>$payroc,
                                                                 
                        );
                        $id = $this->admin_model->insert_data("token", $data);
                        //echo  $this->db->last_query();  die("my query");

                        $data_pax = array(
                        'merchant_id' =>$merchant_id,
                        'token_id' =>$id,
                        'invoice_no'=>$invoice_no,
                        'status'=>$status, 
                       
                        );
                        $pax_id = $this->admin_model->insert_data("invoice_token", $data_pax);


           $getInv = $this->db->query("SELECT * from customer_payment_request where id ='".$payment_id."' ");
            $Invoicedata = $getInv->row_array();


             $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
            $Merchantdata = $getMerchantdata->row_array();
            $processor_id=$Merchantdata['processor_id'];
            $amount=$Invoicedata['amount'];
            $recurring_count=$Invoicedata['recurring_count'];
            $recurring_count_paid=$Invoicedata['recurring_count_paid']+1;
            $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
            $paymentcard=$tokenVal; 
            $authorizationcode="";
            $ipaddress=$_SERVER['REMOTE_ADDR'];
            $orderid=$invoice_no;
                 if (!empty($security_key) and !empty($processor_id)){
                          $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
                        $query .= "processor_id=" . urlencode($processor_id) . "&";
                        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
                        $query .= "ipaddress=" . urlencode($ipaddress) . "&";
                        $query .= "orderid=" . urlencode($orderid) . "&";
                        $query .= "customer_vault=update_customer". "&";
                        $query .= "customer_vault_id=". urlencode($paymentcard) . "&";
                    
                        $query .= "type=sale";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                        curl_setopt($ch, CURLOPT_POST, 1);

                        if (!($data3 = curl_exec($ch))) {
                        return ERROR;
                        }
                        curl_close($ch);
                        unset($ch);

                        parse_str($data3, $parsed);
                        $test = json_encode($parsed);
                        $response = json_decode($test, true);


                    }else
                    {
                       $message_complete = 'Error';
                    }
                    //print_r($response);
                    $message_a = $response['responsetext'];

                    if($response['response']==1)
                    {
                      
                        $status = 'confirm'; 
                        $card_a_no = $response['cc_number'];
                        $trans_a_no = $response['transactionid'];
                        $auth_code = $response['authcode'];
                        
                        $payment_date=date('Y-m-d');

                         if($recurring_count > 0)
                          {
                            $remain = $recurring_count-1;
                          }
                          else
                          {
                            $remain=1; 
                          }
                            // $card_a_type =$card_type;
                            if($response['cc_type']=='mc')
                            {
                              $card_a_type ='MasterCard';
                            }
                            
                            else
                             {
                               $card_a_type =ucfirst($response['cc_type']);
                             }   
                    }
                    else if($response['response']==2)
                    {
                         $status = 'declined';
                    }
                    
                    else 
                    {
                         $status = 'pending';
                    }
                    
 //'recurring_count_paid' => $recurring_count_paid,
   //         'recurring_count_remain' => $remain,

 $data = Array(
            'payment_date' => $payment_date,
            'status' => $status,
            'transaction_id' => $trans_a_no,
            'auth_code' => $auth_code,
            'message' =>  $message_a,
            'card_type' =>  $card_a_type,
            'card_no' =>  $card_a_no,
            'date_c' => $today2,
            'order_type' => 'a',
            'payment_device'=>'app',
            
          );
 
          //print_r($data); die();  
          $idd = $this->admin_model->update_data("customer_payment_request", $data,array('id' => $payment_id,'merchant_id' => $merchant_id));

/////////////////// Email code

               $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$payment_id."' ");
               $getEmail = $getQuery->result_array();
               $data['getEmail'] = $getEmail;

               $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
               $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
               $data['getEmail1'] = $getEmail1; 
               $data['resend'] = "";
               $email = $getEmail[0]['email_id'];
               $id = $getEmail[0]['id'];
               $new_merchant_id = $getEmail[0]['merchant_id'];
               $new_invoice_no = $getEmail[0]['invoice_no'];
               $mobile_no = $getEmail[0]['mobile_no'];
               $status = $getEmail[0]['status'];
               $token = $getEmail[0]['token'];
               $url = $getEmail[0]['url'];
               $purl = str_replace('rpayment', 'reciept', $url); 
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
      if (!empty($email)) {
              if($status=='confirm'){
             $mail_body = $this->load->view('email/receipt', $data, true);
             $MailSubject = 'Receipt from '.$data['business_dba_name'];
          
             if (!empty($email)) {
               $this->email->from('info@salequick.com', $data['business_dba_name']);
               $this->email->to($email);
               $this->email->subject($MailSubject);
               $this->email->message($mail_body);
               $this->email->send();
             }
           }


        $message = '1';
      } else if (!empty($mobile_no)) {

       if($status=='confirm'){
        $mob = str_replace(array('(', ')', '-', ' '), '', $sid);
        $mobile = '+1' . $mob;
                        
         $sms_message = trim(" Receipt from " . $business_dba_name . "  .$purl ");
        
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
           
        }

        $message = '1';
      }         



 //////////////////////    end     
                        
                        $status = parent::HTTP_OK;
                        if(!empty($idd)){
                            
                              
                             
                     $response = ['status' => $status, 'successMsg' => 'Successfull'];
                        
                        }
                        else
                        {
                             $response = ['status' => 401, 'errorMsg' => 'Fail'];
                        }
                       
                        }
                        else
                        {
                            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
                        }
                        $this->response($response, $status);
                    }                
 

 public function rerun_add_card_post() {
            $data = array();
            $data = $this->verify_request();
            $merchant_id = $this->input->post('merchant_id');
            $today2=date('Y-m-d');
    if($merchant_id == $data->merchant_id)
    {
            $invoice_no = $_POST['invoice_no'];
            $payment_id = $_POST['payment_id'];
           

             $getRow_token=$this->db->query(" SELECT token_id FROM invoice_token WHERE invoice_no='$invoice_no' and merchant_id='$merchant_id' and status=1 " )->result_array(); 
                 $token_id=$getRow_token[0]['token_id'] ? $getRow_token[0]['token_id'] :"0";

                   $getRow_token1=$this->db->query(" SELECT token FROM token WHERE id='$token_id' and merchant_id='$merchant_id' and status=1 " )->result_array(); 
                 $tokenVal=$getRow_token1[0]['token'] ? $getRow_token1[0]['token'] :"0";



           $getInv = $this->db->query("SELECT * from customer_payment_request where id ='".$payment_id."' ");
            $Invoicedata = $getInv->row_array();


             $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
            $Merchantdata = $getMerchantdata->row_array();
            $processor_id=$Merchantdata['processor_id'];
            $amount=$Invoicedata['amount'];
            $recurring_count=$Invoicedata['recurring_count'];
            $recurring_count_paid=$Invoicedata['recurring_count_paid']+1;
            $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
            $paymentcard=$tokenVal; 
            $authorizationcode="";
            $ipaddress=$_SERVER['REMOTE_ADDR'];
            $orderid=$invoice_no;
                 if (!empty($security_key) and !empty($processor_id)){
                          $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
                        $query .= "processor_id=" . urlencode($processor_id) . "&";
                        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
                        $query .= "ipaddress=" . urlencode($ipaddress) . "&";
                        $query .= "orderid=" . urlencode($orderid) . "&";
                        $query .= "customer_vault=update_customer". "&";
                        $query .= "customer_vault_id=". urlencode($paymentcard) . "&";
                    
                        $query .= "type=sale";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://payroc.transactiongateway.com/api/transact.php");
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                        curl_setopt($ch, CURLOPT_POST, 1);

                        if (!($data3 = curl_exec($ch))) {
                        return ERROR;
                        }
                        curl_close($ch);
                        unset($ch);

                        parse_str($data3, $parsed);
                        $test = json_encode($parsed);
                        $response = json_decode($test, true);


                    }else
                    {
                       $message_complete = 'Error';
                    }
                    //print_r($response);
                    $message_a = $response['responsetext'];

                    if($response['response']==1)
                    {
                      
                        $status = 'confirm'; 
                        $card_a_no = $response['cc_number'];
                        $trans_a_no = $response['transactionid'];
                        $auth_code = $response['authcode'];
                        
                        $payment_date=date('Y-m-d');

                         if($recurring_count > 0)
                          {
                            $remain = $recurring_count-1;
                          }
                          else
                          {
                            $remain=1; 
                          }
                            // $card_a_type =$card_type;
                            if($response['cc_type']=='mc')
                            {
                              $card_a_type ='MasterCard';
                            }
                            
                            else
                             {
                               $card_a_type =ucfirst($response['cc_type']);
                             }   
                    }
                    else if($response['response']==2)
                    {
                         $status = 'declined';
                    }
                    
                    else 
                    {
                         $status = 'pending';
                    }
                    
 //'recurring_count_paid' => $recurring_count_paid,
   //         'recurring_count_remain' => $remain,

 $data = Array(
            'payment_date' => $payment_date,
            'status' => $status,
            'transaction_id' => $trans_a_no,
            'auth_code' => $auth_code,
            'message' =>  $message_a,
            'card_type' =>  $card_a_type,
            'card_no' =>  $card_a_no,
            'date_c' => $today2,
            'order_type' => 'a',
            'payment_device'=>'app',
            
          );
 
          //print_r($data); die();  
          $idd = $this->admin_model->update_data("customer_payment_request", $data,array('id' => $payment_id,'merchant_id' => $merchant_id));


                        
                        $status = parent::HTTP_OK;
                        if(!empty($idd)){
                            
                              
                             
                     $response = ['status' => $status, 'successMsg' => 'Successfull'];
                        
                        }
                        else
                        {
                             $response = ['status' => 401, 'errorMsg' => 'Fail'];
                        }
                       
                        }
                        else
                        {
                            $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
                        }
                        $this->response($response, $status);
                    }     

}