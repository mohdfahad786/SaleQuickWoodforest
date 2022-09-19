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

class Vts_merchant_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        date_default_timezone_set("America/Chicago");
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);

    }

public function add_payment_value_post()
{
    $data = array();
    $merchant_id = $this->input->post('merchant_id');
    
       $userdata = array();

    
    

        //$merchant_id = $this->input->post('merchantId') ? $this->input->post('merchantId') : "";
        $device_serial_number = $this->input->post('deviceSerialNumber') ? $this->input->post('deviceSerialNumber') : "";
        $total_amount = trim($this->input->post('totalAmount')) ? trim($this->input->post('totalAmount')) : "";
        $amount = trim($this->input->post('amount')) ? trim($this->input->post('amount')) : "";
        $tax = trim($this->input->post('tax')) ? trim($this->input->post('tax')) : 0;
        $other_charges = trim($this->input->post('otherCharges')) ? trim($this->input->post('otherCharges')) : 0;

        $merchant_key = $this->input->post('merchantKey') ? $this->input->post('merchantKey') : "";
        $auth_key = $this->input->post('authKey') ? $this->input->post('authKey') : "";
        $towed_vehicle = $this->input->post('towedVehicle') ? $this->input->post('towedVehicle') : "";

           if (!empty($auth_key) && !empty($merchant_key) && !empty($device_serial_number) && !empty($total_amount) && !empty($amount) && !empty($towed_vehicle) ) { 

         if (is_numeric($other_charges) && is_numeric($tax)  && is_numeric($total_amount) && is_numeric($amount)  ) { 

            


$getQuery_a = $this->db->query("SELECT * from merchant where merchant_key ='" . $merchant_key . "' and auth_key ='" . $auth_key . "'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;
        $merchant_id = $getEmail_a[0]['id'];

if(!empty($merchant_id)){
                 $today1_1 = date("ymdhisu");
                 $today1 = str_replace("000000", "", $today1_1);
                 $transaction_id =$today1.$merchant_id;
                $today2 = date("Y-m-d");
                $data = Array(
                    'merchant_id' => $merchant_id,
                    'amount' => $amount,
                    'total_amount' => $total_amount,
                    'other_charges' => $other_charges,
                    'device_serial_number' => $device_serial_number,
                    'tax' => $tax,
                    'transaction_id' => $transaction_id,
                    'towed_vehicle' => $towed_vehicle,
                    'date_c' => $today2,
                );
                $id = $this->admin_model->insert_data("vts", $data);
                
     
    // Send the return data as reponse
    $status = parent::HTTP_OK;

    $response = ['status' => $status,'postId' => $transaction_id, 'successMsg' =>'Successful'];
    

    $this->response($response, $status);

  }
  else
  {
     $status = '401';
                 // $response = 'CNP-Credential-Not-available';
                  $response = ['status' => '401', 'errorMsg' => 'Wrong auth_key OR merchant_key !'];
            
            $this->response($response, $status);
  }
      } else {
                $status = '401';
                 // $response = 'CNP-Credential-Not-available';
                  $response = ['status' => '401', 'errorMsg' => 'Please Fill Numeric Value!'];
            
            $this->response($response, $status);
        }


    } else {
                $status = '401';
                 // $response = 'CNP-Credential-Not-available';
                  $response = ['status' => '401', 'errorMsg' => 'Please Fill Required Filed!'];
            
            $this->response($response, $status);
        }
}


  public function cnpPayment_post() {


    $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

    $getQuery_a = $this->db->query("SELECT * from merchant where merchant_key ='" . $_POST['merchantKey'] . "' and auth_key ='" . $_POST['authKey'] . "'  ");
    $getEmail_a = $getQuery_a->result_array();
    $data['$getEmail_a'] = $getEmail_a;
    $merchant_id = $getEmail_a[0]['id'];
    $processor_id=trim($getEmail_a[0]['processor_id']);     
    //print_r($getEmail_a);
    //$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
    $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
    

    if (!empty($security_key) and !empty($processor_id) ) {

      $account_id = $getEmail_a[0]['account_id_cnp'];
      $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
      $account_token = $getEmail_a[0]['account_token_cnp'];
      $application_id = $getEmail_a[0]['application_id_cnp'];
      $terminal_id = $getEmail_a[0]['terminal_id'];

      $mobile_no = $this->input->post('phone') ? trim($this->input->post('phone')) : "";
      $email_id = $this->input->post('email') ? trim($this->input->post('email')) : "";

      $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
      $card_no = $this->input->post('cardNumber') ? $this->input->post('cardNumber') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
                        //echo $card_no;die();
      $cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
      $name = $this->input->post('name') ? $this->input->post('name') : "";
      $address = $this->input->post('address') ? $this->input->post('address') : "";
      $expiry_month = $this->input->post('expiryMonth') ? $this->input->post('expiryMonth') : "";
      $expiry_year = $this->input->post('expiryYear') ? $this->input->post('expiryYear') : "";
      $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
      $payment_id_1 = "POS_" . date("Ymdhisu");
      $payment_id = str_replace("000000", "", $payment_id_1);

      $sub_merchant_id = $this->input->post('sub_merchant_id') ? trim($this->input->post('sub_merchant_id')) : "0";

  $ccnumber=$card_no;
  $amount=$amount;
  $ccexp=$expiry_month.$expiry_year;
  $cvv=$cvv;
  $authorizationcode="";
  $ipaddress=$_SERVER['REMOTE_ADDR'];
  $orderid=$payment_id;

    

    $query  = "";
    // Login Information
    $query .= "security_key=" . urlencode($security_key) . "&";
    // Sales Information
    $query .= "ccnumber=" . urlencode($ccnumber) . "&";
    $query .= "ccexp=" . urlencode($ccexp) . "&";
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    $query .= "cvv=" . urlencode($cvv) . "&";
    $query .= "zip=" . urlencode($zip) . "&";
    $query .= "processor_id=" . urlencode($processor_id) . "&";
    $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
    $query .= "ipaddress=" . urlencode($ipaddress) . "&";
    $query .= "orderid=" . urlencode($orderid) . "&";
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

    if (!($data = curl_exec($ch))) {
        return ERROR;
    }
    curl_close($ch);
    unset($ch);
  
  parse_str($data, $parsed);
  $test = json_encode($parsed);
  $response = json_decode($test, true);
  //print_r($response);
  // die();
      //$array['Response']['ExpressResponseMessage']='onlie';
  $online = 'ONLINE';

      if ($online = 'ONLINE') {

        

          $card_a_no = $response['cc_number'];
          $trans_a_no = $response['transactionid'];

          if($response['cc_type']=='mc')
          {
            $card_type ='MasterCard';
          }

          else
           {
             $card_type =ucfirst($response['cc_type']);
           }  

          $auth_code1 = $response['authcode']; 

              $auth_code2 = $response['authCode'];
              if($auth_code1!='')
              {
                    $auth_code = $auth_code1;
              }
              else
              {
                   $auth_code = $auth_code2;
             }

          $message_a = $response['responsetext'];

          if($response['responsetext']=='SUCCESS')
          {
            $message_a = 'Approved';
          }
          else 
          {
            $message_a = $response['responsetext'];
          }
          
          if($response['response']==1)
          {
            $message_complete = 'Approved';
          }
          else if($response['response']==2)
          {
            $message_complete = 'Declined';
          }
          else if($response['response']==3)
          {
            $message_complete = 'Error in transaction data or system error';
          }
          else 
          {
            $message_complete = 'Error';
          }
          

            $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
            $s_fee = $merchantdetails['0']['s_fee'];
            $t_fee = $this->session->userdata('t_fee');
            $fee_invoice = $merchantdetails['0']['point_sale'];
            // $fee_swap =$merchantdetails['0']['f_swap_Recurring'];
            $fee_swap = $merchantdetails['0']['text_email'];
            $fee_email = $merchantdetails['0']['f_swap_Text'];

            $fee1 = ($amount / 100) * $fee_invoice;
            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
            $fee_email = ($fee_email != '') ? $fee_email : 0;
            $fee = $fee1 + $fee_swap + $fee_email;
            $today1 = date("Ymdhms");
            //$payment_id = "POS_".date("Ymdhms");
            $today2 = date("Y-m-d");
            $year = date("Y");
            $month = date("m");
            $time11 = date("H");

            if ($time11 == '00') {
              $time1 = '01';
            } else {
              $time1 = date("H");
            }

            if ($message_complete == 'Declined') {
              $staus = 'declined';
            }
            //elseif($message_a=='Approved' or $message_a=='Duplicate')
            elseif ($message_complete == 'Approved') {
              $staus = 'confirm';
            } else {
              $staus = 'pending';
            }

            $day1 = date("N");

            $data = Array(
              'amount' => $amount,
              'fee' => $fee,
              'merchant_id' => $merchant_id,
              'sub_merchant_id' => $sub_merchant_id,
              'invoice_no' => $payment_id,
              'name' => $name,
              'mobile_no' => $mobile_no,
              'discount' => '0',
              'total_amount' => '0.00',
              'email_id' => $email_id,
              'card_no' => $card_a_no,
              'address' => $address,
              'year' => $year,
              'month' => $month,
              'time1' => $time1,
              'day1' => $day1,
              'date_c' => $today2,
              'auth_code' => $auth_code,
              'status' => $staus,
              'transaction_id' => $trans_a_no,
              'c_type' => 'CNP',
              'payment_type' => 'web',
               'processor_name'=>'PAYROC',
              'card_type' => $card_type,
              'transaction_status' => $message_a,
              'express_responsemessage'=>$message_complete,
              'woocommerce' =>'no',
              'is_for_vts' =>'true'

            );

            // print_r($data);  die();

            $id = $this->admin_model->insert_data("pos", $data);

            if ($message_complete == 'Declined') {
              
               $responsee = $message_complete;
               $status = '400';
               $response = ['status' => '400', 'errorMsg' => $responsee];
            }
            //elseif($message_a=='Approved' or $message_a=='Duplicate')
            elseif ($message_complete == 'Approved') {
               $responsee = $message_complete;

                 $user = array(
                      'amount'=>$amount ? $amount : "",
                      'transactionId'=>$trans_a_no ? $trans_a_no : "",
                      'maskedCardNumber'=>$card_a_no ? $card_a_no : "",
                      'dateTime'=>$today2 ? $today2 : ""
                      
                    );
           $status = '200';
        $response = ['status' => '200', 'successMsg' => $responsee,'UserData' => $user];
            } else {
              $status = '401';
               $responsee = $arrayy['Response']['ExpressResponseMessage'];
            $response = ['status' => '401', 'errorMsg' => $responsee];
            }
      }

  
   //$response =$array['Response']['ExpressResponseMessage'];
    $this->response($response, $status);

        } else {
          $status = '401';
           // $response = 'CNP-Credential-Not-available';
            $response = ['status' => '401', 'errorMsg' => 'CNP-Credential-Not-available!'];
      
      $this->response($response, $status);
    }
  //return $response;
}





}