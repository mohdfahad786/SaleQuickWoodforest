<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Sandbox extends CI_Controller
      { 
      public function __construct() 
      {
      parent::__construct();

      $this->load->model('customers_model','customers');

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
      
       
      public function all_sandbox_payment()
      {

      $data = array();
      $merchant_id = $this->session->userdata('merchant_id');
      if($this->input->post('mysubmit'))
      {

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $status = $_POST['status'];
        $package_data = $this->Admin_model->get_search_merchant_pos($start_date,$end_date,$status,$merchant_id,'sandbox_payment_request');
        $data["start_date"] = $_POST['start_date'];
        $data["end_date"] = $_POST['end_date'];
        $data["status"] = $_POST['status'];
      }

      else{

      $package_data = $this->Admin_model->get_full_details_pos('sandbox_payment_request',$merchant_id);
      }
      $mem = array();
      $member = array();
      foreach($package_data as $each)
      {

      $package['id'] = $each->id;
      $package['payment_id'] = $each->invoice_no;
      $package['name'] = $each->name;
      $package['email'] = $each->email_id; 
      $package['mobile'] = $each->mobile_no;
      $package['amount'] = $each->amount;

      $package['date'] = $each->add_date; 

      $package['status'] = $each->status;


      $mem[] = $package;
      }
      $data['mem'] = $mem;
      $data['meta'] = 'All Sandbox Payment';
      // $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
      // $this->session->unset_userdata('mymsg');



      $this->load->view('merchant/all_sanbox_payment_dash', $data);
      // $this->load->view('merchant/all_sanbox_payment', $data);
      }




public function card_payment(){
        $id    = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
        $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
        $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
        $today2 = date("Y-m-d H:i:s");

        $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
        $getEmail = $getQuery->result_array();
        $data['getEmail'] = $getEmail;
        $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$bct_id2."'  ");
        $getEmail1 = $getQuery1->result_array();
        $data['getEmail1'] = $getEmail1;

        $email = $getEmail[0]['email_id']; 
        $amount = $getEmail[0]['amount'];
        $sub_total = $getEmail[0]['sub_total'];
        $tax = $getEmail[0]['tax']; 

        $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
        $data['itemm'] = $itemm;
        $data['logo'] = "logo";

        $branch = $this->Home_model->get_payment_details_1($bct_id1);
        $data['branch'] = $branch;
        $this->load->view('sandbox_card_payment' , $data);
    }
    public function card_payment1(){
        $id    = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
        $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
        $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
        $today2 = date("Y-m-d H:i:s");

        $getQuery = $this->db->query("UPDATE sandbox_payment_request SET  status='confirm'  where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
       redirect('api_payment_sandbox/'.$bct_id1.'/'.$bct_id2);
    }
    
    
    public function confirm()
   {
     $id = $this->uri->segment(2);
    
     $getQuery = $this->db->query("SELECT * from merchant where auth_key='".$id."' ");
    $getEmail = $getQuery->result_array();
    $getEmailCount = $getQuery->num_rows();
    $data['getEmailCount'] = $getEmailCount ;
         
    if($getEmailCount > 0)
    {
          if($getEmail[0]['status']=='pending')
          {
      $bct_id1 = $this->uri->segment(4);
                          $info = array(
                //'status' => 'confirm',
                'status' => 'Activate_Details'
                  
                
                          );
      
        $this->Home_model->update_date_single($id, $info);
         
       $this->session->set_flashdata('cmsg', '<div class="alert alert-success text-center" style="max-width: 60%; margin: 0 auto 20px;"> Your Email  Confirm Successfully </div>');
      }
      elseif($getEmail[0]['status']=='confirm')
      {
 $this->session->set_flashdata('cmsg', '<div class="alert alert-success text-center" style="max-width: 60%; margin: 0 auto 20px;"> Your Email Already Confirm  </div>');
      }
           }
           else
           {
 $this->session->set_flashdata('cmsg', '<div class="alert alert-danger text-center" style="max-width: 60%; margin: 0 auto 20px;">  Email  Not Available </div>');
           }             // redirect("confirm");
   $this->load->view('confirm');
   }


    public function payment_cnp(){
        
        
        $id  = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
        $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
        $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
        $transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
        $message = $this->input->post('message') ? $this->input->post('message') : "";
        $card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
        $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
        $today2 = date("Y-m-d H:i:s");
        $purl= "https://salequick.com/demo/reciept/$bct_id1/$bct_id2";
        $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
        $getEmail = $getQuery->result_array();
        $data['getEmail'] = $getEmail;
        $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$bct_id2."'  ");
        $getEmail1 = $getQuery1->result_array();
        $data['getEmail1'] = $getEmail1;
        $type = $getEmail[0]['payment_type'];
        $paid = $getEmail[0]['recurring_count_paid'] + 1;
        $remain = $getEmail[0]['recurring_count_remain'] - 1;
        $amount = $getEmail[0]['amount'];
        $merchant_id = $bct_id2;
        //Data, connection, auth
        # $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;

        //print_r($getEmail_a);
        if(!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])){
            $account_id = $getEmail_a[0]['account_id_cnp'];
            $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
            $account_token = $getEmail_a[0]['account_token_cnp'];
            $application_id = $getEmail_a[0]['application_id_cnp'];
            $terminal_id = $getEmail_a[0]['terminal_id'];
            $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
            $cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
            $name = $this->input->post('name') ? $this->input->post('name') : "";
            $l_name = $this->input->post('l_name') ? $this->input->post('l_name') : "";
            $name_card = $this->input->post('name_card') ? $this->input->post('name_card') : "";
            $expiry_month = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
            // $result = explode('-', $expiry_month1);
            // $expiry_month = $result[1];;
           // $expiry_year =  substr($result[0],2);
           
            $expiry_year = $this->input->post('exp_year') ? $this->input->post('exp_year') : "";
            $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";   
            // xml post structure
            $xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken><AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>";   // data from the form, e.g. some ID number
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
         //print_r($array);
            curl_close($ch);
            // die();
            if ($array['Response']['ExpressResponseMessage']='ONLINE') {
               
                $TicketNumber =  (rand(100000,999999));
            
                $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken>
                <AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
                <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>".$amount."</TransactionAmount><ReferenceNumber>".$payment_id."</ReferenceNumber>
                <TicketNumber>".$TicketNumber."</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>".$terminal_id."</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
                <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
                </Terminal><Card><CardNumber>".$card_no."</CardNumber><ExpirationMonth>".$expiry_month."</ExpirationMonth><ExpirationYear>".$expiry_year."</ExpirationYear></Card></CreditCardSale>";   // data from the form, e.g. some ID number
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
                $arrayy = json_decode($json,TRUE);
              
          // print_r($arrayy);
          //die();
                curl_close($ch);
                if($arrayy['Response']['ExpressResponseMessage']=='Approved' or $arrayy['Response']['ExpressResponseMessage']=='Declined')   
                {
                    
                $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
                $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
                $card_a_type = $arrayy['Response']['Card']['CardLogo'];
                $message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
                $message_complete =  $arrayy['Response']['ExpressResponseMessage']; 
                // $arrayy['Response']['Transaction']['ApprovedAmount']; 
                //}
                // die();
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
                if($type=='straight'){
                    $info = array(
                        'status' => $staus,
                        'payment_date' => $today2,
                        'transaction_id' => $trans_a_no,
                        'message' =>  $message_a,
                        'card_type' =>  $card_a_type,
                        'card_no' =>  $card_a_no,
                        'name_card' =>  $name_card,
                        'l_name' =>  $l_name,
                        'ip_a' => $_SERVER['REMOTE_ADDR']
                    );
                }elseif($type=='recurring'){
                    $info = array(
                        'status' => $staus,
                        'payment_date' => $today2,
                        'recurring_count_paid' => $paid,
                        'recurring_count_remain' => $remain,
                        'transaction_id' => $trans_a_no,
                        'message' =>  $message_a,
                        'card_type' =>  $card_a_type,
                        'card_no' =>  $card_a_no,
                        'name_card' =>  $name_card,
                        'l_name' =>  $l_name,
                        'ip_a' => $_SERVER['REMOTE_ADDR']
                    );
                }
                //print_r($info); die();          
                $this->Home_model->update_payment_single($id, $info);
                //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
                //redirect('dashboard/all_subadmin');
                $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
                //$this->load->view('admin/add_subadmin/'.$bct_id);
                $data['resend'] = "";
                //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
                // $this->load->view('payment' , $data);
                $email = $getEmail[0]['email_id']; 
                $amount = $getEmail[0]['amount'];
                $sub_total = $getEmail[0]['sub_total'];
                $tax = $getEmail[0]['tax']; 
                $originalDate = $getEmail[0]['date_c'];
                $newDate = date("F d,Y", strtotime($originalDate)); 
                $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
                //Email Process
                $data['email'] = $getEmail[0]['email_id']; 
                $data['amount'] = $getEmail[0]['amount'];
                $data['sub_total'] = $getEmail[0]['sub_total'];
                $data['tax'] = $getEmail[0]['tax']; 
                $data['originalDate'] = $getEmail[0]['date_c'];
                $data['card_a_no'] = $card_a_no;
                $data['trans_a_no'] = $trans_a_no;
                $data['card_a_type'] = $card_a_type;
                $data['message_a'] = $message_a;
                $data['msgData'] = $data;
                // echo "<pre>";print_r($data);die;
                //Send Mail Code
                $msg = $this->load->view('email/receipt', $data, true);
                $email = $email;
                
                // $config['mailtype'] = 'html';
                // $this->email->initialize($config);
                // $email_config = Array(
                //     'protocol'  => 'smtp',
                //     'smtp_host' => 'ssl://smtpout.secureserver.net',
                //     'smtp_port' => '465',
                //     'smtp_user' => 'donotinfo@salequick.com',
                //     'smtp_pass' => '94141',
                //     'mailtype'  => 'html',
                //     'charset' => 'utf-8',
                //     'starttls'  => true,
                //     'newline'   => "\r\n"
                // );
                // $this->load->library('email', $email_config);
                // $from = "donotinfo@salequick.com";
                // $subject = "Salequick Receipt";
                // $headers  = "From: $from\r\n"; 
                // $headers .= "Content-type: text/html\r\n";
                // mail($email, $subject, $msg, $headers);
                
                
                  $MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
                //   $headers  = "MIME-Version: 1.0\r\n"; 
                //     $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
                //     $headers .= "From: Salequick<donotreply@salequick.co >\r\n";                  
                //   mail($email, $MailSubject, $msg, $headers);
                   if(!empty($email)){ 
                   $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                   $this->email->to($email);
                  $this->email->subject($MailSubject);
                   $this->email->message($msg);
                  $this->email->send();
                   }
                //$sms_sender = trim($this->input->post('sms_sender'));
                 if(!empty($getEmail[0]['mobile_no'])){ 
                $sms_reciever = $getEmail[0]['mobile_no'];
                 $sms_message = trim('Payment Receipt : '.$purl);
                //  $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
                $from = '+18325324983'; //trial account twilio number
                // $to = '+'.$sms_reciever; //sms recipient number
                $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
                $to = '+1'.$mob;
                $response = $this->twilio->sms($from, $to,$sms_message);
                 }
                //print_r($response); die();
                 redirect(base_url().'api_payment/'.$bct_id1.'/'.$bct_id2);
               // redirect('api_payment/'.$bct_id1.'/'.$bct_id2);
                   }
                     else
                         {
                               $id=$arrayy['Response']['ExpressResponseMessage'];
                         // redirect('payment_error/'.$id);
                          redirect(base_url().'payment_error/'.$id);
                         }
                         
            }else{
                //  print_r($array);
                $id=$array['Response']['ExpressResponseMessage'];
               // redirect('payment_error/'.$id);
                  redirect(base_url().'payment_error/'.$id);
            }
        }else{
            $id='CNP-Credential-Not-available';
            redirect('payment_error/'.$id);
        }
        //break;
    }
    public function payment_error(){
        $id = $this->uri->segment(2);
        $this->session->set_flashdata('cmsg', '<div class="alert alert-success text-center" style="max-width: 60%; margin: 0 auto 20px;">  '.$id.' </div>');
        $this->load->view('payment_error');
    }

    

     public function payment_sandbox(){
        if($this->input->post('submit'))
        {
         $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
        $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
        if(!$bct_id2 && !$this->input->post('submit'))
        {
          echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
          die;
        }
        $branch = $this->Home_model->get_payment_details_1_sand($bct_id1);
        if($this->input->post('submit'))
        {
       $id      = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
       $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
       $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
       $today2 = date("Y-m-d H:i:s");
       
       $purl= "https://salequick.com/reciept/$bct_id1/$bct_id2";
         
          $getQuery = $this->db->query("SELECT * from sandbox_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
    $getEmail = $getQuery->result_array();
 $data['getEmail'] = $getEmail;
     $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$bct_id2."'  ");
    $getEmail1 = $getQuery1->result_array();
     $data['getEmail1'] = $getEmail1;

   

    
       $type = $getEmail[0]['payment_type'];
        $paid = $getEmail[0]['recurring_count_paid'] + 1;
         $remain = $getEmail[0]['recurring_count_remain'] - 1;
      
      if($type=='straight')
      {
                          $info = array(
                'status' => 'confirm',
                'payment_date' => $today2,
                  
                
                          );
                      }
                      elseif($type=='recurring')
                      {
 $info = array(
                'status' => 'confirm',
                'payment_date' => $today2,
                'recurring_count_paid' => $paid,
                'recurring_count_remain' => $remain,
                  
                
                          );
                      }
      
     
   
        
          //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
        //redirect('dashboard/all_subadmin');
         $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
      //  $this->load->view('admin/add_subadmin/'.$bct_id);
         $data['resend'] = "";
        //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
          // $this->load->view('payment' , $data);

 $email = $getEmail[0]['email_id']; 
 $amount = $getEmail[0]['amount'];
  $sub_total = $getEmail[0]['sub_total'];
   $tax = $getEmail[0]['tax']; 

    $originalDate = $getEmail[0]['date_c'];
$newDate = date("F d,Y", strtotime($originalDate)); 





      redirect('api_payment_sandbox/'.$bct_id1.'/'.$bct_id2);
      //break;
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['email'] = $sub->email_id;
          $data['name'] = $sub->name;
        $data['mobile'] = $sub->mobile_no;
         $data['tax'] = $sub->tax;
      $data['amount'] = $sub->amount;
      $data['reference'] = $sub->reference;
        $data['title'] = $sub->title;
        $data['detail'] = $sub->detail;
        $data['status'] = $sub->status;
        $data['bct_id1'] = $bct_id1;
        $data['bct_id2'] = $bct_id2;
         
        break;
      } 
    } 
  
    $data['loc'] = "payment";
    $data['resend'] = "resend";

    $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";
    
         $this->load->view('sandbox_payment1' , $data);
  
  }
  else 
  {
     $bct_id2 = $this->uri->segment(3);
  $bct_id1 = $this->uri->segment(2);
  
 $getQuery = $this->db->query("SELECT * from sandbox_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
    $getEmail = $getQuery->result_array();
    $getEmailCount = $getQuery->num_rows();
    $data['getEmailCount'] = $getEmailCount ;
  
         
    if($getEmailCount > 0)
    {
if($getEmail[0]['status']=='pending')
          {
    if(!$bct_id2 && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
      die;
    }
    $branch = $this->Home_model->get_payment_details_1_sand($bct_id1);
    
   
    if($this->input->post('submit'))
    {
      $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
      $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
      $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
       
  
      
                          $info = array(
                'status' => 'confirm',
                  
                
                          );
      
       
      
        
          //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
        //redirect('dashboard/all_subadmin');
         $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
        // $this->session->unset_userdata('pmsg');
      //  $this->load->view('admin/add_subadmin/'.$bct_id);
         $data['resend'] = "";
        //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
          // $this->load->view('payment' , $data);
      redirect('api_payment_sandbox/'.$bct_id1.'/'.$bct_id2);
    }
    else
    {
        
       
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['email'] = $sub->email_id;
          $data['name'] = $sub->name;
          $data['reference'] = $sub->reference;
          $data['invoice_no'] = $sub->invoice_no;
          $data['due_date'] = $sub->due_date;
          $data['date_c'] = $sub->date_c;
        $data['mobile'] = $sub->mobile_no;
      $data['amount'] = $sub->amount;
        $data['tax'] = $sub->tax;
        $data['title'] = $sub->title;
        $data['detail'] = $sub->detail;
        $data['status'] = $sub->status;
        $data['bct_id1'] = $bct_id1;
        $data['bct_id2'] = $bct_id2;
        break;
      } 
    } 
  


  
    $data['loc'] = "payment";
    $data['resend'] = "resend";
    
    $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";

    
         $this->load->view('sandbox_payment1' , $data);
      
      }
      elseif($getEmail[0]['status']=='confirm')
      {
 $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Payment  Complete   </div>');
 //$this->session->unset_userdata('pmsg');
    $data['resend'] = "";

    $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";

   $this->load->view('sandbox_payment1' , $data);
      }
      }
           else
           {
 $this->session->set_flashdata('pmsg', '<div class="alert alert-danger text-center">  Payment   Not Available </div>');
$data['resend'] = "";
$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";
 //$this->session->unset_userdata('pmsg');
           $this->load->view('sandbox_payment1', $data);
           }   
}
  
   }

   
    public function payment(){
        if($this->input->post('submit'))
        {
         $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
        $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
        if(!$bct_id2 && !$this->input->post('submit'))
        {
          echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
          die;
        }
        $branch = $this->Home_model->get_payment_details_1($bct_id1);
        if($this->input->post('submit'))
        {
       $id      = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
       $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
       $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
       $today2 = date("Y-m-d H:i:s");
       
       $purl= "https://salequick.com/reciept/$bct_id1/$bct_id2";
         
          $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
    $getEmail = $getQuery->result_array();
 $data['getEmail'] = $getEmail;
     $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$bct_id2."'  ");
    $getEmail1 = $getQuery1->result_array();
     $data['getEmail1'] = $getEmail1;

   

    
       $type = $getEmail[0]['payment_type'];
        $paid = $getEmail[0]['recurring_count_paid'] + 1;
         $remain = $getEmail[0]['recurring_count_remain'] - 1;
      
      if($type=='straight')
      {
                          $info = array(
                'status' => 'confirm',
                'payment_date' => $today2,
                  
                
                          );
                      }
                      elseif($type=='recurring')
                      {
 $info = array(
                'status' => 'confirm',
                'payment_date' => $today2,
                'recurring_count_paid' => $paid,
                'recurring_count_remain' => $remain,
                  
                
                          );
                      }
      
        $this->Home_model->update_payment_single($id, $info);
      $this->Home_model->update_payment_graph($bct_id1, $info);
        
          //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
        //redirect('dashboard/all_subadmin');
         $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
      //  $this->load->view('admin/add_subadmin/'.$bct_id);
         $data['resend'] = "";
        //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
          // $this->load->view('payment' , $data);

 $email = $getEmail[0]['email_id']; 
 $amount = $getEmail[0]['amount'];
  $sub_total = $getEmail[0]['sub_total'];
   $tax = $getEmail[0]['tax']; 

    $originalDate = $getEmail[0]['date_c'];
$newDate = date("F d,Y", strtotime($originalDate)); 
 
 $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));

        $htmlContent = '  <!DOCTYPE html>
<html>
<head>
   
    <meta charset="utf-8">
    <title>Receipt</title>
    <meta charset="utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    </head>
<body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
    <div style="max-width: 900px;margin: 0 auto;">
              <div style="color:#fff;">
              <div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">
                  <div class="" style="width:80%;margin:0 auto;">
                            <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 10px;">
                        <img src="https://salequick.com/logo/'.$getEmail1[0]['logo'].'" style="width: 100%; height: 100%;;margin-top: 0px;     border-radius: 50%;" />
                      </div>
                              <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center">$'.number_format($amount,2)  .'  at '. $getEmail1[0]['business_name'] .'</h3>
                            <hr style="margin-top: 20px;  margin-bottom: 20px; border: 0;border-top: 1px solid #eee;" />
                          <div style="float:left;width:45%;padding:0 15px;text-align:right;">
                        <span>
                            '. $getEmail[0]['invoice_no'].'
                        </span>
                    </div>
                        <div style="float:left;width:45%;padding:0 15px;text-align:left;">
                          <span>
                            '. $newDate.'
                        </span>
                    </div>
                          </div>
              </div>
              <div style="background-color: #437ba8;overflow: hidden;">
                      <h2 class="m-b-20" style="font-size:30px;margin:20px 0;text-align:center">
                
                <img src="https://salequick.com/email/images/payment_icon.png" style="margin-bottom:-5px;" />
                
                     $ '.number_format($amount,2).'</h2>
                  </div>
          </div>
                <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
                  <div style="width:80%;margin:0 auto;overflow:hidden">
                    <div style="float:left;width:50%;">
                      <h5 style="text-align:left;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Description</h5>
                  </div>
                <div style="float:left;width:50%;">
                      <h5  style="text-align:right;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Price</h5>
                  </div>
                    <div style="clear:both"></div>
                <hr style="border: 0; border-top: 1px solid #d6d1d1;" />';
   
  foreach ($item as $rowp) { 
  $item_name =  str_replace(array('\\', '/'), '', $rowp['item_name']);
  $quantity =  str_replace(array('\\', '/'), '', $rowp['quantity']);
  $price =  str_replace(array('\\', '/'), '', $rowp['price']);
  $tax2 =  str_replace(array('\\', '/'), '', $rowp['tax']);
  $tax_id =  str_replace(array('\\', '/'), '', $rowp['tax_id']);
  $total_amount =  str_replace(array('\\', '/'), '', $rowp['total_amount']);
   $item_name1 = json_decode($item_name);
     $quantity1 = json_decode($quantity);
   $price1 = json_decode($price);
    $tax1 = json_decode($tax2);
    $tax_id1 = json_decode($tax_id);
    $total_amount1 = json_decode($total_amount);
    $i = 0; 

           foreach ($item_name1 as $rowpp) { 
if($quantity1[$i] > 0 && $item_name1[$i]!='Labor'){
                   $htmlContent .= '<div style="float:left;width:50%;">
                      <h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">'.$item_name1[$i] .'</h5>
                  </div>
                <div style="float:left;width:50%;">
                      <h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ '.number_format($price1[$i],2) .'</b></h5>
                  </div>
                
               <div class="clearfix" style="clear:both"></div>
               
                   <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';

  } $i++; } 

  $j=0;
$qun = 0;
$prc = 0;
$tax = 0;
$total = 0;

 foreach ($item_name1 as $rowpp) {

  if($item_name1[$j]=='Labor' && $quantity1[$j] > 0  ) { 
      
      
    
      $qun += $quantity1[$j];
      $prc += $price1[$j];
      $tax += $tax1[$j];
      $total += $total_amount1[$j];

      
      
      } 
$j++; }  
$k=0;

foreach ($item_name1 as $rowpp) {
   

  if($item_name1[$k]=='Labor'  ) {  


                    $htmlContent .= '<div style="float:left;width:50%;">
                      <h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">Labor</h5>
                  </div>
                <div style="float:left;width:50%;">
                      <h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ '.number_format($prc,2) .'</b></h5>
                  </div>
                
               <div class="clearfix" style="clear:both"></div>
               
                   <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';

                      
  break; $k++; } }




  } 
      
                
                   
                $htmlContent .='<div style="float:left;width:50%;text-align:right;margin-left:50%;">
                    <div style="display:block;margin-bottom:20px;overflow: hidden;margin-top:0px;">
                        <span style="float:left">Tax </span>
                        <span style="float:right">$ '.number_format($tax,2).'</span>
                    </div>
                    <div style="clear:both"></div>
                    <hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />
                    <div style="display:block;margin-bottom:25px;overflow: hidden;">
                        <span style="float:left;">Total </span>
                        <span style="float:right;"><b> $ '.number_format($amount,2).'</b></span>
                      </div>
                </div>
                </div>
              </div>
              <footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
                    <div style="text-align:center;width:80%;margin:0 auto">
                    <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with  question and concerns.</h5>
                  <p><a style="color:#4a91f9;cursor:pointer;">'. $getEmail1[0]['email'].'</a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;">'. $getEmail1[0]['mob_no'].'</a></p>
                <br />
                  <p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>
                  <p style="color: #868484;">You are receiving something because purchased something at Company name</p>
                  <p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
                </div>
            </footer>
        </div>
    </body>
</html>


';

$MailSubject=" Receipt from ".$getEmail1[0]['business_dba_name'];
$config['mailtype'] = 'html';
$this->email->initialize($config);
$this->email->to($email);
$this->email->from('info@salequick.com',$getEmail1[0]['business_dba_name']);
$this->email->subject($MailSubject);
$this->email->message($htmlContent);
//$this->email->attach('files/attachment.pdf');
$this->email->send();


//$sms_sender = trim($this->input->post('sms_sender'));
$sms_reciever = $getEmail[0]['mobile_no'];
$sms_message = trim('Payment Receipt : '.$purl);
// $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
$from = '+18325324983'; //trial account twilio number
// $to = '+'.$sms_reciever; //sms recipient number
$mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
 $to = '+1'.$mob;
$response = $this->twilio->sms($from, $to,$sms_message);
//print_r($response); die();


      redirect('api_payment/'.$bct_id1.'/'.$bct_id2);
      //break;
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['email'] = $sub->email_id;
          $data['name'] = $sub->name;
        $data['mobile'] = $sub->mobile_no;
         $data['tax'] = $sub->tax;
      $data['amount'] = $sub->amount;
      $data['reference'] = $sub->reference;
        $data['title'] = $sub->title;
        $data['detail'] = $sub->detail;
        $data['status'] = $sub->status;
        $data['bct_id1'] = $bct_id1;
        $data['bct_id2'] = $bct_id2;
         
        break;
      } 
    } 
  
    $data['loc'] = "payment";
    $data['resend'] = "resend";

    $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";
    
         $this->load->view('sandbox_payment' , $data);
  
  }
  else 
  {
     $bct_id2 = $this->uri->segment(3);
  $bct_id1 = $this->uri->segment(2);
  
 $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
    $getEmail = $getQuery->result_array();
    $getEmailCount = $getQuery->num_rows();
    $data['getEmailCount'] = $getEmailCount ;
  
         
    if($getEmailCount > 0)
    {
if($getEmail[0]['status']=='pending')
          {
    if(!$bct_id2 && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
      die;
    }
    $branch = $this->Home_model->get_payment_details_1($bct_id1);
    
   
    if($this->input->post('submit'))
    {
      $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
      $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
      $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
       
  
      
                          $info = array(
                'status' => 'confirm',
                  
                
                          );
      
        $this->Home_model->update_payment_single($bct_id1, $info);
        $this->Home_model->update_payment_graph($bct_id1, $info);
      
        
          //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
        //redirect('dashboard/all_subadmin');
         $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
        // $this->session->unset_userdata('pmsg');
      //  $this->load->view('admin/add_subadmin/'.$bct_id);
         $data['resend'] = "";
        //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
          // $this->load->view('payment' , $data);
      redirect('api_payment/'.$bct_id1.'/'.$bct_id2);
    }
    else
    {
        
       
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['email'] = $sub->email_id;
          $data['name'] = $sub->name;
          $data['reference'] = $sub->reference;
          $data['invoice_no'] = $sub->invoice_no;
          $data['color'] = $sub->color;
          $data['due_date'] = $sub->due_date;
          $data['date_c'] = $sub->date_c;
        $data['mobile'] = $sub->mobile_no;
      $data['amount'] = $sub->amount;
        $data['tax'] = $sub->tax;
        $data['title'] = $sub->title;
        $data['detail'] = $sub->detail;
        $data['status'] = $sub->status;
        $data['bct_id1'] = $bct_id1;
        $data['bct_id2'] = $bct_id2;
        
        break;
      } 
    } 
  


    $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));
    
    
 $data['item'] = $item;
    $data['loc'] = "payment";
    $data['resend'] = "resend";
    
    $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";

    
         $this->load->view('sandbox_payment' , $data);
      
      }
      elseif($getEmail[0]['status']=='confirm')
      {
 $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Payment  Complete   </div>');
 //$this->session->unset_userdata('pmsg');
    $data['resend'] = "";

    $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";

   $this->load->view('sandbox_payment' , $data);
      }
      }
           else
           {
 $this->session->set_flashdata('pmsg', '<div class="alert alert-danger text-center">  Payment   Not Available </div>');
$data['resend'] = "";
$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";
 //$this->session->unset_userdata('pmsg');
           $this->load->view('sandbox_payment', $data);
           }   
}
  
   }


    public function reciept()
   {


     $id      = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
      $bct_id2 = $this->uri->segment(3);
   $bct_id1 = $this->uri->segment(2);
       $today2 = date("Y-m-d H:i:s");
         
   
    $branch = $this->Home_model->get_payment_details_1($bct_id1);

      $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='".$bct_id2."' and payment_id  ='".$bct_id1."' ");
    $getEmail = $getQuery->result_array();
     $data['getEmail'] = $getEmail;

     $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$bct_id2."'  ");
    $getEmail1 = $getQuery1->result_array();
     $data['getEmail1'] = $getEmail1;

     $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
 $data['itemm'] = $itemm;
    $data['logo'] = "logo";

     foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['email'] = $sub->email_id;
          $data['name'] = $sub->name;
          
          $data['invoice_no'] = $sub->invoice_no;
          $data['transaction_id'] = $sub->transaction_id;
          $data['message'] = $sub->message;
           $data['reference'] = $sub->reference;
            $data['card_type'] = $sub->card_type;
             $data['card_no'] = $sub->card_no;
          $data['due_date'] = $sub->due_date;
        $data['mobile'] = $sub->mobile_no;
      $data['amount'] = $sub->amount;
        
        $data['title'] = $sub->title;
        $data['detail'] = $sub->detail;
        $data['status'] = $sub->status;
        $data['bct_id1'] = $bct_id1;
        $data['bct_id2'] = $bct_id2;
         $data['recurring_count'] = $sub->recurring_count;
        $data['recurring_type'] = $sub->recurring_type;
        $data['date_c'] = $sub->date_c;
        break;
      } 

  $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));
 $data['item'] = $item;
      $this->load->view('reciept' , $data);
      
   }


 
      

      }