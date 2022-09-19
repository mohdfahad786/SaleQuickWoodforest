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

class Recurring_api extends REST_Controller {

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
    $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
    $getDashboardData = $getDashboard->result_array();
    $getDashboardNum = $getDashboard->num_rows();
    if ($getDashboardData == false) {
      $getDashboardData = '0';
      $inv = '1';
    } else {
      $inv1 = $getDashboardData[0]['TotalOrders'];
      $inv = $inv1 + 1;
    }

    $merchant_status = $this->session->userdata('merchant_status');
    $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
      // if($pd__constant!='on') { $this->form_validation->set_rules('recurring_count', 'Payments Duration', 'required'); }

      // $this->form_validation->set_rules('paytype', 'Payment Type', 'required');
      // $this->form_validation->set_rules('amount', 'amount', 'required');
      // $this->form_validation->set_rules('name', 'Name', 'required');
      // $this->form_validation->set_rules('recurring_pay_start_date', 'Recurring Start  Date', 'required');
      // $this->form_validation->set_rules('Item_Name[]', 'Item Name', 'required');
      // $this->form_validation->set_rules('Quantity[]', 'Quantity', 'required');
      // $this->form_validation->set_rules('Price[]', 'Price', 'required');
      
      $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
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

        $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
        $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
        $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";
         //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
        $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
        $name = $this->input->post('name') ? $this->input->post('name') : "";
        $email_id = $this->input->post('email') ? $this->input->post('email') : "";
        $phone=$mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
        $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
        $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
        $other_charges_state = $this->input->post('other_charges_state') ? $this->input->post('other_charges_state') : "";
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
       
         //echo $pd__constant;   // pd__constant
          //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
         if($pd__constant=='on' &&  $recurring_count=="")
         {
           $recurring_count=-1; 
         }   
         // echo $recurring_count;  die();
        if($paytype=='1' && 3 > 7)    //   condition break 
        {
            
          // echo "Helllo  Its Auto Pay Mode";  die(); 
           //echo $recurring_count;  die(); 
           //$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL live 
           $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL   sandbox 
           $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
           $getEmail_a = $getQuery_a->result_array();
           $data['$getEmail_a'] = $getEmail_a;
           if(count($getEmail_a))
           {
             $merchant_email = $getEmail_a[0]['email'];
           }
          // print_r($getEmail_a);  die("Auto");
          if(!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id']))
          {     //if($account_id && $acceptor_id && $account_token && $application_id && $terminal_id)
            
            $account_id = $getEmail_a[0]['account_id_cnp']; 
            $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
            $account_token = $getEmail_a[0]['account_token_cnp']; 
            $application_id = $getEmail_a[0]['application_id_cnp'];
            $terminal_id = $getEmail_a[0]['terminal_id'];
            // $account_id = 1196211; 
            // $acceptor_id = 4445029890514;
            // $account_token = D737D32F8674BF81780A6F259DE66080F984048E249A9DB4DA01C93DC6F733A2F2535101; 
            // $application_id = 9726;
            // $terminal_id = '4374N000101';
             
            
            
            $xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken><AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>";   // data from the form, e.g. some ID number
            $headers = array(
              "Content-type: text/xml;charset=\"utf-8\"",
              "Accept: text/xml",
              "Cache-Control: no-cache",
              "Pragma: no-cache",
              "SOAPAction: https://transaction.elementexpress.com/",
              "Content-length: ".strlen($xml_post_string),
            ); //SOAPAction: your op URL 
             // print_r($xml_post_string);  die(); 
            //die("end");
            $url = $soapUrl;
            //print_r($url); die("ok"); 
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);  
            
            $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            //print_r($array); die("ok");
            curl_close($ch);
            //die("okok");
            $TicketNumber =  (rand(100000,999999));
            if ($array['Response']['ExpressResponseMessage']='ONLINE') {
              $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken>
                 <AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
                 <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>".$amount."</TransactionAmount><ReferenceNumber>".$payment_id."</ReferenceNumber>
                 <TicketNumber>".$TicketNumber."</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>".$terminal_id."</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
                 <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
                 </Terminal><Card><CardNumber>".$card_no."</CardNumber><ExpirationMonth>".$expiry_month."</ExpirationMonth><ExpirationYear>".$expiry_year."</ExpirationYear><CVV>".$cvv."</CVV></Card><Address><BillingZipcode>".$zip."</BillingZipcode>
                  <BillingAddress1>".$address."</BillingAddress1></Address></CreditCardSale>";   // data from the form, e.g. some ID number
      
                  $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://transaction.elementexpress.com/", 
                    "Content-length: ".strlen($xml_post_string),
                  ); //SOAPAction: your op URL
                $url = $soapUrl;
                
                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword);
                // username and password - declared at the top of the doc
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                // converting
                $response = curl_exec($ch); 
                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $arrayy = json_decode($json,TRUE);
                //    print_r($arrayy);
                //  die();
                curl_close($ch);
                if($arrayy['Response']['ExpressResponseMessage']=='Approved' or $arrayy['Response']['ExpressResponseMessage']=='Declined')   
                {   
                  $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
                  $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
                  $card_a_type = $arrayy['Response']['Card']['CardLogo'];
           
                  //print_r($card_a_type);  die(); 
                  $message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
                  $message_complete =  $arrayy['Response']['ExpressResponseMessage']; 
                  $AVSResponseCode = $arrayy['Response']['Card']['AVSResponseCode'];
                  $CVVResponseCode = $arrayy['Response']['Card']['CVVResponseCode'];
                  
                  if($AVSResponseCode=='A')
                  {
           
                    $address_status = 'Address match';
           
                    $zip_status = 'Zip does not match';
           
                  }
       
              
       
                  elseif($AVSResponseCode=='G')
           
                  {
           
                    $address_status = 'Global non-AVS participant';
           
                    $zip_status = 'Global non-AVS participant';
           
                  }
           
                  elseif($AVSResponseCode=='N')
           
                  {
           
                    $address_status = 'Address  not match';
           
                    $zip_status = 'Zip  not match';
           
                  }
           
                  elseif($AVSResponseCode=='R')
           
                  {
           
                    $address_status = 'Retry, system unavailable or timed out';
           
                    $zip_status = 'Retry, system unavailable or timed out';
           
                  }
           
                  elseif($AVSResponseCode=='S')
           
                  {
           
                    $address_status = 'Service not supported: Issuer does not support AVS and Visa';
           
                    $zip_status = 'Service not supported: Issuer does not support AVS and Visa';
           
                  }
           
                  elseif($AVSResponseCode=='U')
           
                  {
           
                    $address_status = 'Unavailable: Address information not verified for domestic transactions';
           
                    $zip_status = 'Unavailable: Address information not verified for domestic transactions';
           
                  }
           
                  elseif($AVSResponseCode=='W')
           
                  {
       
                    $address_status = 'Address does not match';
           
                    $zip_status = 'Zip matches';
           
                  }
           
                  elseif($AVSResponseCode=='X')
           
                  {
           
                    $address_status = 'Address match';
           
                    $zip_status = 'Zip matches';
           
                  }
           
                  elseif($AVSResponseCode=='Y')
           
                  {
           
                    $address_status = 'address match';
           
                    $zip_status = 'zip match';
           
                  }
           
                  elseif($AVSResponseCode=='Z')
           
                  {
           
                    $address_status = 'Address does not match';
           
                    $zip_status = 'zip match';
           
                  }
           
                  elseif($AVSResponseCode=='E')
           
                  {
           
                    $address_status = 'AVS service not supported';
           
                    $zip_status = 'AVS service not supported';
           
                  }
           
                  elseif($AVSResponseCode=='D')
           
                  {
           
                    $address_status = 'Address match (International)';
           
                    $zip_status = 'Zip  match (International)';
           
                  }
           
                  elseif($AVSResponseCode=='M')
           
                  {
           
                    $address_status = 'Address match (International)';
           
                    $zip_status = 'Zip  match (International)';
           
                  }
           
                  elseif($AVSResponseCode=='P')
           
                  {
           
                    $address_status = 'Address not verified because of incompatible formats';
           
                    $zip_status = 'Zip matches';
           
                  }
           
                  elseif($AVSResponseCode=='N')
           
                  {
           
                    $address_status = 'Address  not match';
           
                    $zip_status = 'Zip not matches';
           
                  }
           
           
           
                  if($CVVResponseCode=='M')
           
                  {
           
                    $cvv_status = 'Match';
           
                    
           
                  }
                  
                  elseif($CVVResponseCode=='P')
           
                  {
           
                    $cvv_status = 'Not Processed';
           
                  }
           
                  elseif($CVVResponseCode=='N')
           
                  {
           
                    $cvv_status = 'No Match';
           
                  }
           
           
           
                  elseif($CVVResponseCode=='S')
           
                  {
           
                    $cvv_status = 'CVV value should be on the card, but the merchant has indicated that it is not present (Visa & Discover)';
           
                  }
           
                  elseif($CVVResponseCode=='U')
           
                  {
           
                    $cvv_status = 'Issuer not certified for CVV processing';
           
                  }
                  if($arrayy['Response']['Card']['CVVResponseCode']!='M')
                  {
                      $id='CVV-Number-Error';
                      redirect('payment_error/'.$id);
                  }
                   //print_r($cvv_status);  die(); 
                  $today2 = date("Y-m-d H:i:s");
                  if($message_complete=='Declined')
                    {
                    $staus = 'declined';
                    }
                    //elseif($message_a=='Approved' or $message_a=='Duplicate') 
                  elseif($message_complete=='Approved') 
                    {
                    $staus = 'confirm'; 
                }
                else 
                {
                $staus = 'pending';  
                }
                $day1 = date("N");
                $today2_a = date("Y-m-d");
                $year = date("Y");
                $month = date("m");
                $time11 = date("H");
                if($time11=='00'){
                  $time1 = '01';
                }else{
                  $time1 = date("H");
                }
                 
             
              
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
              $day1 = date("N");
              $amountaa = $sub_amount + $fee;
              $paid = 1;
              if($recurring_count >0)
              {
                $remain = $recurring_count - 1;
              }
              else
              {
                $remain=1; 
                $recurring_count= -1;   
              }
              if($remain <= 0) 
              {
                $recurring_payment='complete'; 
              }
              else{
                $recurring_payment='start'; 
              }
                 
              $recurring_pay_start_date=date($recurring_pay_start_date); 
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
                
              $data1 = Array(
                'reference' => $reference,
                'name' => $name,
                'other_charges' => $other_charges,
                'otherChargesName' => $other_charges_title,
                'invoice_no' => $invoice_no,
                'email_id' => $email_id,
                'mobile_no' => $mobile_no,
                'amount' => $amount,
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
                'recurring_count' => $recurring_count,
                // 'due_date' => $due_date,
                'merchant_id' => $merchant_id,
                'sub_merchant_id' => $sub_merchant_id,
                'payment_id' => $unique,
                'recurring_payment' => $recurring_payment,
                'recurring_pay_start_date' => $recurring_pay_start_date,
                'recurring_next_pay_date' => $recurring_next_pay_date,
                'recurring_pay_type' => $paytype,
                'status' => $staus,                
                'year' => $year,
                'month' => $month,
                'time1' => $time1,
                'day1' => $day1,
                'date_c' => $today2_a,
                'payment_date' => $today2,
                'recurring_count_paid' => $paid,
                'recurring_count_remain' => $remain,
                'transaction_id' => $trans_a_no,
                'message' =>  $message_a,
                'card_type' =>  $card_a_type,
                'card_no' =>  $card_a_no,
                'sign' =>  "",
                'address' =>  $address,
                'name_card' =>  $name_card,
                'l_name' => "",
                'address_status' =>  $address_status,
                'zip_status' =>  $zip_status,
                'cvv_status' =>  $cvv_status,
                'ip_a' => $_SERVER['REMOTE_ADDR'],
                'order_type' => 'a',
                'payment_device'=>'app',
                'app_type'=>$app_type,
                'other_charges_state' => $other_charges_state
                );
                
              $id1 = $this->admin_model->insert_data("customer_payment_request", $data1);
                ///first insertion /
              $data['resend'] = "";
              $item_name = json_encode($this->input->post('Item_Name'));
              $quantity = json_encode($this->input->post('Quantity'));
              $price = json_encode($this->input->post('Price'));
              $tax = json_encode($this->input->post('Tax_Amount'));
              $tax_id = json_encode($this->input->post('Tax'));
              $tax_per = json_encode($this->input->post('Tax_Per'));
              $total_amount = json_encode($this->input->post('Total_Amount'));
              $item_Detail_1 = array(
                "p_id" => $id1,
                "item_name" => ($item_name), 
                "quantity" => ($quantity),
                "price" => ($price),
                "tax" => ($tax),
                "tax_id" => ($tax_id),
                "tax_per" => ($tax_per),
                "total_amount" => ($total_amount),
    
              );
              //print_r($item_Detail_1);  die(); 
              $this->admin_model->insert_data("order_item", $item_Detail_1);

               
              $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
              $this->db->where('status','confirm'); 
              $this->db->where('id',$id1); 
              $data['getEmail']=$getEmail=$this->db->get('customer_payment_request')->result_array();
              $data['getEmail1']=$getEmail_a; 
              
              $email = $email_id; 
              $amount = $amount;
              $sub_total = $sub_amount;
              $tax = $total_tax; 
              $originalDate = $today2_a;
              $merchant_email=$getEmail_a[0]['email'];
              $newDate = date("F d,Y", strtotime($originalDate)); 
              //Email Process
              $data['email'] = $email_id;
              $data['color'] = $getEmail_a[0]['color'];
              $data['amount'] = $amount;
              $data['sub_total'] = $sub_amount;
              $data['tax'] = $total_tax; 
              $data['originalDate'] = $today2_a;
              $data['card_a_no'] = $card_a_no;
              $data['trans_a_no'] = $trans_a_no;
              $data['card_a_type'] = $card_a_type;
              $data['message_a'] = $message_a;
              $data['late_fee_status'] = $merchantdetails[0]['late_fee_status'];
              $data['late_fee'] = $getEmail[0]['late_fee'];
              $data['payment_type'] = 'recurring';
              $data['recurring_type'] = $recurring_type;
              $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
              $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
              $data['msgData'] = $data;
              $msg = $this->load->view('email/new_receipt', $data, true);
              //echo $msg;  die(); 
              $merchnat_msg = $this->load->view('email/merchnat_receipt', $data, true);
          
               $email = $email; 
       
               $MailSubject = ' Receipt from '.$getEmail_a[0]['business_dba_name']; 
               $MailSubject2= ' Receipt to '.$getEmail[0]['name']?$getEmail[0]['name']:$getEmail[0]['email_id'];
       
              if(!empty($email)){ 
       
                  $this->email->from('info@salequick.com', $getEmail_a[0]['business_dba_name']);
       
                  $this->email->to($email);
       
                  $this->email->subject($MailSubject);
       
                  $this->email->message($msg);
       
                  $this->email->send();
       
              }
                 
              if(!empty($merchant_email)){ 
       
                $this->email->from('info@salequick.com', $getEmail_a[0]['business_dba_name']);
       
                $this->email->to($merchant_email);
       
                  $this->email->subject($MailSubject2);
       
                $this->email->message($merchnat_msg);
       
                  $this->email->send();
       
              }
       
              
              if(3 > 4) {
                $url=$getEmail[0]['url']; 
                //$purl = str_replace('payment', 'reciept', $url);
                $purl = str_replace('rpayment', 'reciept', $url);
                if(!empty($mobile_no)){ 
                  //$sms_sender = trim($this->input->post('sms_sender'));
                  $sms_reciever = $getEmail[0]['mobile_no'];
                  //$sms_message = trim('Payment Receipt : '.$purl);
                  $sms_message = trim(' Receipt from '.$getEmail_a[0]['business_dba_name'].' : '.$purl);
                  $from = '+18325324983'; //trial account twilio number
                  // $to = '+'.$sms_reciever; //sms recipient number
                  $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
                  $to = '+1'.$mob; 
                  $response = $this->twilio->sms($from, $to,$sms_message);
                }
              }
              $savecard=0; 
              if($savecard == '0'  )   //  card Save Condition
              {
                   // Start create Token
                $soapUrl1 = "https://certservices.elementexpress.com/";
                $referenceNumber =  (rand(1000,9999));
                 $xml_post_string = "<PaymentAccountCreateWithTransID xmlns='https://services.elementexpress.com'>
            
                  <Credentials>
            
                    <AccountID>".$account_id."</AccountID>
            
                    <AccountToken>".$account_token."</AccountToken>
            
                    <AcceptorID>".$acceptor_id."</AcceptorID>
            
                  </Credentials>
            
                  <Application>
            
                    <ApplicationID>".$application_id."</ApplicationID>
            
                    <ApplicationVersion>2.2</ApplicationVersion>
            
                    <ApplicationName>SaleQuick</ApplicationName>
            
                  </Application>
            
                  <PaymentAccount>
            
                    <PaymentAccountType>0</PaymentAccountType>
            
                    <PaymentAccountReferenceNumber>".$referenceNumber."</PaymentAccountReferenceNumber>
            
                  </PaymentAccount>
            
                  <Transaction>
            
                    <TransactionID>".$trans_a_no."</TransactionID>
            
                  </Transaction>
            
                  </PaymentAccountCreateWithTransID>";   // data from the form, e.g. some ID number
            
                  $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Method:POST"
                  ); //SOAPAction: your op URL
            
                  $url = $soapUrl1;
                  // PHP cURL  for https connection with auth
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                  curl_setopt($ch, CURLOPT_URL, $url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
                  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                  curl_setopt($ch, CURLOPT_POST, true);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                  // converting
                  $response = curl_exec($ch); 
                  $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                  $json = json_encode($xml);
                  $arrrayy = json_decode($json,TRUE);
                  // print_r($arrrayy); die(); 
                  //print_r($arrayy['Response']['PaymentAccount']['PaymentAccountReferenceNumber']);
                  curl_close($ch);
                  $tokenId=$arrrayy['Response']['PaymentAccount']['PaymentAccountID']; 
                  $mob = str_replace(array( '(', ')','-',' ' ), '', $phone);
                  $my_toke = array(
                    'name' => $name,
            
                    'mobile' => $mob,
                    'card_type' => $card_a_type,
            
                    'card_expiry_month'=>$expiry_month,
            
                    'card_expiry_year'=>$expiry_year,
            
                    'card_no' => $card_a_no,
                    // 'transaction_id'=>$trans_a_no,
                    
                    'token' => $tokenId,
            
                    );
                    $gettoken=$this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND mobile='$mob' ")->result_array();
                    if(count($gettoken) <= 0)
                    {
                      $this->db->insert('token',$my_toke);
                    }
              }
              /// print_r($my_toke);  die(); 
             // $this->db->insert('token',$my_toke);
              //print_r($response); die();
              $TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
              $TransactionDate = $arrayy['Response']['ExpressTransactionDate']; 
              //print_r($arrayy);  die(); 
              $Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
              $Address = $arrayy['Response']['Address']['BillingAddress1'];
      
              $Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
              $Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
              //die(); //2019-07-04 12:05:41
              $rt=$Tdate.' '.$Ttime;
              $transaction_date=date($rt); 
             
              $save_notificationdata = array(
              'merchant_id'=>$merchant_id,
              'name' => $name,
              'mobile' => $phone,
              'email' => $email,
              'card_type' => $card_a_type,
              'card_expiry_month'=>$expiry_month,
              'card_expiry_year'=>$expiry_year,
              'card_no' => $card_a_no,
              'amount'  =>$Amount,
              'address' =>$Address,
              'transaction_id'=>$trans_a_no,
              'transaction_date'=>$transaction_date,
              'notification_type' => 'payment',
              'invoice_no'=>$invoice_no,
              'status'   =>'unread'
              );
              //print_r($save_notificationdata); die(); 
               $this->db->insert('notification',$save_notificationdata);
              
             $status = parent::HTTP_OK;
             $response = ['status' => $status, 'successMsg' => 'New payment Add Successfully']; 
            }
            else
            {
                $id=$arrayy['Response']['ExpressResponseMessage'];
              

            $status = parent::HTTP_OK;
            $response = ['status' => $status, 'errorMsg' => $id];

            }
            }
            else{
               $id=$array['Response']['ExpressResponseMessage'];
               
                $status = parent::HTTP_OK;
            $response = ['status' => $status, 'errorMsg' => $id];
       
            }
            
          }
          else{
              $id='CNP-Credential-Not-available';


               $status = parent::HTTP_OK;
            $response = ['status' => $status, 'errorMsg' => $id];
            }
        }
        else if($paytype=='0' ||  $paytype=='1')
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
                  if($recurring_count > 0)
                  {
                    $remain = $recurring_count;
                  }
                  else
                  {
                    $remain=1; 
                    $recurring_count= -1; 
                  }
        
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
          
          // print_r($recurring_pay_start_date);
          // echo "<br/><br/>"; 
          // print_r($recurring_next_pay_date); 
           //die("ok"); 
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
            'recurring_count' => $recurring_count,
            'recurring_count_paid' => '0',
            'recurring_count_remain' => $remain,
            'recurring_pay_start_date' => $recurring_pay_start_date,
            'recurring_next_pay_date' => $recurring_next_pay_date,
            'recurring_pay_type' => $paytype,
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
            'status' => 'pending',
            'date_c' => $today2,
            'order_type' => 'a',
            'payment_device'=>'app',
            'app_type'=>$app_type,
            'other_charges_state' => $other_charges_state,
            'token' => $toke_rec
            
          );
          //print_r($data); die();  
          $id = $this->admin_model->insert_data("customer_payment_request", $data);
          //  $id1 = $this->admin_model->insert_data("graph", $data);
          $item_name = json_encode($this->input->post('Item_Name'));
          $quantity = json_encode($this->input->post('Quantity'));
          $price = json_encode($this->input->post('Price'));
          $tax = json_encode($this->input->post('Tax_Amount'));
          $tax_id = json_encode($this->input->post('Tax'));
          $tax_per = json_encode($this->input->post('Tax_Per'));
          $total_amount = json_encode($this->input->post('Total_Amount'));
          $item_Detail_1 = array(
            "p_id" => $id,
            "item_name" => ($item_name),
            "quantity" => ($quantity),
            "price" => ($price),
            "tax" => ($tax),
            "tax_id" => ($tax_id),
            "tax_per" => ($tax_per),
            "total_amount" => ($total_amount),
          );
          
          
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
          $this->admin_model->insert_data("order_item", $item_Detail_1);
          $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
          $data['item_detail'] = $item_Detail_1;  
          

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