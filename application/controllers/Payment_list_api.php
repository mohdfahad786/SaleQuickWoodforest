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

class Payment_list_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->model('list_model');
        //date_default_timezone_set("America/Chicago");
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








public function dateTimeConvertTimeZone($Adate,$merchant_id) {
            if($Adate) {

                $stmt = $this->db->query("SELECT time_zone FROM merchant WHERE  id ='".$merchant_id."'  ");
    $package_data = $stmt->result_array();
    $time_zone_orignal = $package_data['0']['time_zone'];

                $time_Zone= $time_zone_orignal ?  $time_zone_orignal :'America/Chicago';
            
                    $datetime = new DateTime($Adate);
                    $la_time = new DateTimeZone($time_Zone);
                    $datetime->setTimezone($la_time);
                    $convertedDateTime=$datetime->format('Y-m-d H:i:s');
               
                
                
            } else {
                $convertedDateTime=$Adate;
            }
            return $convertedDateTime; 
        }





public function all_confirm_payment_post() {
    $data = array();
    $partial = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');

    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
        $start1 = $_POST['start_date'];
            $end1 = $_POST['end_date'];

            if ($_POST['start_date'] != '') {

                $start = $start1;

            } else {
                $start = date("Y-m-d", strtotime("-364 days"));
            }

            if ($_POST['end_date'] != '') {

                $end = $end1;

            } else {
                $end = date("Y-m-d");
            }
            
            $type = $_POST['type'];
            
            
            if ($type == '' or $type == 'straight') {

                $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and payment_type='straight' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <= '".$end."'  order by id desc  limit $start_limit,$limit ");

                 $stmt_total = $this->db->query("SELECT COUNT(DISTINCT invoice_no) as MID FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' ");

            } elseif ($type == 'recur') {

                $stmt = $this->db->query("SELECT id,name,email_id,p_ref_amount,amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and payment_type='recurring'  and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <= '".$end."'  order by id desc  limit $start_limit,$limit ");
                
                 $stmt_total = $this->db->query("SELECT COUNT(DISTINCT invoice_no) as MID FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and payment_type='recurring' and is_for_vts='false' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' ");
              

            } elseif ($type == 'pos') {
                $stmt = $this->db->query("SELECT id,name,email_id,sum(p_ref_amount) as p_ref_amount,sum(amount) as amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' group by invoice_no  order by id desc limit $start_limit,$limit ");

                $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' ");

                // echo $this->db->last_query(); die();

            }
            elseif ($type == 'vts') {
                $stmt = $this->db->query("SELECT id,name,email_id,sum(p_ref_amount) as p_ref_amount,sum(amount) as amount,title,mobile_no,detail,invoice_no,payment_date,add_date,reference,due_date,transaction_id,card_no,transaction_type,card_type FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='true' and (status='confirm' OR (status ='Chargeback_Confirm' and partial_refund=1)) and date_c >='".$start."' and date_c <='".$end."' group by invoice_no order by id desc limit $start_limit,$limit");

            }
            $package_data = $stmt->result_array();
            $total_count = $stmt_total->result_array();
            $TotalCompleted = number_format($total_count[0]['MID'],2);
            //print_r($total_count[0]['MID']);
      
        $mem = array();
        $member = array();
    
                    foreach ($package_data as $each) {
                     $remain_amount_1=   $each['amount'] - $each['p_ref_amount'];
                    $remain_amount = number_format($remain_amount_1,2);
 $memm = array();
                    $stmt_p = $this->db->query("SELECT id,amount,date_c,transaction_id FROM refund WHERE   merchant_id ='".$merchant_id."' and invoice_no='".$each['invoice_no']."' ");
            $package_data_partial = $stmt_p->result_array();
            if (count($package_data_partial)>0) {
            foreach ($package_data_partial as $each_partial) {

                $partial = array(
                            'id' => $each_partial['id'] ? $each_partial['id'] : "",
                            'amount' => $each_partial['amount'] ? $each_partial['amount'] : "",
                            'transaction_id' => $each_partial['transaction_id'] ? $each_partial['transaction_id'] : "",
                            'date_c' => $each_partial['date_c'] ? $each_partial['date_c'] : "",

                        );
                $memm[] = $partial;
            }
        }
            $partialdata = $memm;
                
                    if ($each['mobile_no'] != '') {
                        
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['mobile_no'] ? $each['mobile_no'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) ? $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "",
                            'status' => "",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            'partial_refund' =>$partialdata,
                           'card_type' =>$each['card_type'] ? $each['card_type'] : "NA"
                            
                        

                        );
                    } else {
                        $package = array(
                            'invoice_no' => $each['invoice_no'] ? $each['invoice_no'] : "",
                            'id' => $each['id'] ? $each['id'] : "",
                            'p_id' => "",
                            'name' => $each['name'] ? $each['name'] : "",
                            'email_id' => $each['email_id'] ? $each['email_id'] : "",
                            'amount' => $each['amount'] ? $each['amount'] : "",
                            'remain_amount' => $remain_amount ? $remain_amount : "",
                            'title' => $each['title'] ? $each['title'] : "",
                            'mob_no' => $each['email_id'] ? $each['email_id'] : "",
                            'detail' => $each['detail'] ? $each['detail'] : "",
                            'payment_id' => $each['reference'] ? $each['reference'] : "",
                            'payment_date' => $each['payment_date'] ? $each['payment_date'] : "",
                            'date_c' => $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) ? $this->dateTimeConvertTimeZone($each['add_date'],$merchant_id) : "",
                            'reference' => $each['reference'] ? $each['reference'] : "NA",
                            'due_date' => $each['due_date'] ? $each['due_date'] : "",
                            'status' => "",
                            'transaction_id' => $each['transaction_id'] ? $each['transaction_id'] : "NA",
                            'card_no' => $each['card_no'] ? $each['card_no'] : "NA",
                            'transaction_type' => $each['transaction_type'] ? $each['transaction_type'] : "NA",
                            'partial_refund' =>$partialdata,
                            'card_type' =>$each['card_type'] ? $each['card_type'] : "NA"

                        );
                    }
                    $mem[] = $package;
                }
    
        $userdata = $mem;
    
    $status = parent::HTTP_OK;
    $response = ['status' => $status, 'TotalCompleted' => $TotalCompleted, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}



public function all_late_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');
    $late_end =  date("Y-m-d");
    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
    if ($_POST['start_date'] != '') {

                $start_date = $_POST['start_date'];

            } else {
                $start_date = date("Y-m-d", strtotime("-364 days"));
            }

            if ($_POST['end_date'] != '') {

                $end_date = $_POST['end_date'];

            } else {
                $end_date = date("Y-m-d");
            }
            
            $type = $_POST['type'];
            
            if ($type == '' or $type == 'straight') {
              $package_data = $this->list_model->get_search_merchant_pos_late($start_date, $end_date,'pending', $merchant_id, 'customer_payment_request',$late_end,$start_limit,$limit);

                $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='pending' and due_date <'".$late_end."' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'recur') {
                 $package_data = $this->list_model->get_search_merchant_pos_late($start_date, $end_date,'pending', $merchant_id, 'recurring_payment',$late_end,$start_limit,$limit);

                   $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM recurring_payment WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='pending'  and due_date <'".$late_end."' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'pos') {
            $package_data = $this->list_model->get_search_merchant_pos_late($start_date, $end_date,'pending', $merchant_id, 'pos',$late_end,$start_limit,$limit);

             $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='pending' and due_date <'".$late_end."' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            }
            $total_count = $stmt_total->result_array();
            $TotalLate = number_format($total_count[0]['MID'],2);
    
    
        $mem = array();
        $member = array();
        if (isset($package_data)) {
            foreach ($package_data as $each) {
                if ($each->receipt_type == null) // no-cepeipt
                {
                    if ($each->mobile_no && $each->email_id) {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no != "" && $each->email_id == "") {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no == "" && $each->email_id != "") {
                        $repeiptmethod = $each->email_id;
                    } else {
                        $repeiptmethod = 'no-receipt';
                    }

                } else if ($each->receipt_type == 'no-cepeipt') {
                    $repeiptmethod = 'no-receipt';
                } else {
                    $repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
                }
                
                

                $package['id'] = $each->id ? $each->id : "";
                $package['p_id'] = "";
                $package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
                $package['name'] = $each->name ? $each->name : "";
                $package['email_id'] = $each->email_id ? $each->email_id : "";
                $package['amount'] = $each->amount ? $each->amount : "";
                $package['title']  = $each->title ? $each->title : "";
                $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
                $package['detail'] = $each->detail ? $each->detail : "";
                $package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
                $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) ? $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                

                
                
                $mem[] = $package;
        

            }
        }
    
        $userdata = $mem;
    
    $status = parent::HTTP_OK;
    $response = ['status' => $status,'TotalLate' => $TotalLate, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}

public function all_pending_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');
    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
    if ($_POST['start_date'] != '') {

                $start_date = $_POST['start_date'];

            } else {
                $start_date = date("Y-m-d", strtotime("-364 days"));
            }

            if ($_POST['end_date'] != '') {

                $end_date = $_POST['end_date'];

            } else {
                $end_date = date("Y-m-d");
            }
            
            $type = $_POST['type'];
            
            if ($type == '' or $type == 'straight') {
              $package_data = $this->list_model->get_search_merchant_pos($start_date, $end_date,'pending', $merchant_id, 'customer_payment_request',$start_limit,$limit);

               $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='pending' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'recur') {
                 $package_data = $this->list_model->get_search_merchant_pos($start_date, $end_date,'pending', $merchant_id, 'recurring_payment',$start_limit,$limit);

                  $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM recurring_payment WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='pending' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'pos') {
            $package_data = $this->list_model->get_search_merchant_pos($start_date, $end_date,'pending', $merchant_id, 'pos',$start_limit,$limit);

             $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='pending' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            }
            
    $total_count = $stmt_total->result_array();
    $TotalPending = number_format($total_count[0]['MID'],2);
    
        $mem = array();
        $member = array();
        if (isset($package_data)) {
            foreach ($package_data as $each) {
                if ($each->receipt_type == null) // no-cepeipt
                {
                    if ($each->mobile_no && $each->email_id) {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no != "" && $each->email_id == "") {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no == "" && $each->email_id != "") {
                        $repeiptmethod = $each->email_id;
                    } else {
                        $repeiptmethod = 'no-receipt';
                    }

                } else if ($each->receipt_type == 'no-cepeipt') {
                    $repeiptmethod = 'no-receipt';
                } else {
                    $repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
                }
                
                

                $package['id'] = $each->id ? $each->id : "";
                $package['p_id'] = "";
                $package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
                $package['name'] = $each->name ? $each->name : "";
                $package['email_id'] = $each->email_id ? $each->email_id : "";
                $package['amount'] = $each->amount ? $each->amount : "";

                 $package['otherChargeAmount'] = $each->other_charges ? $each->other_charges : "";
                  $package['otherChargeName'] = $each->otherChargesName ? $each->otherChargesName : "";
                   $package['taxAmount'] = $each->tax ? $each->tax : "";

                $package['title']  = $each->title ? $each->title : "";
                $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
                $package['detail'] = $each->detail ? $each->detail : "";
                $package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
                 $package['refrence_id'] = $each->payment_id ? $each->payment_id : "";

                $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) ? $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                
                
                $mem[] = $package;
        

            }
        }
    
        $userdata = $mem;
    
    $status = parent::HTTP_OK;
    $response = ['status' => $status,'TotalPending' => $TotalPending, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}

public function all_declined_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');
    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
    if ($_POST['start_date'] != '') {

                $start_date = $_POST['start_date'];

            } else {
                $start_date = date("Y-m-d", strtotime("-364 days"));
            }

            if ($_POST['end_date'] != '') {

                $end_date = $_POST['end_date'];

            } else {
                $end_date = date("Y-m-d");
            }
            
            $type = $_POST['type'];
            
            if ($type == '' or $type == 'straight') {
              $package_data = $this->list_model->get_search_merchant_pos($start_date, $end_date,'declined', $merchant_id, 'customer_payment_request',$start_limit,$limit);

               $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM customer_payment_request WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='declined' and  date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'recur') {
                 $package_data = $this->list_model->get_search_merchant_pos($start_date, $end_date,'declined', $merchant_id, 'recurring_payment',$start_limit,$limit);

                  $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM recurring_payment WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='declined' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'pos') {
            $package_data = $this->list_model->get_search_merchant_pos($start_date, $end_date,'declined', $merchant_id, 'pos',$start_limit,$limit);

             $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM pos WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='declined' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            }
            
    $total_count = $stmt_total->result_array();
    $TotalDeclined = number_format($total_count[0]['MID'],2);
    
        $mem = array();
        $member = array();
        if (isset($package_data)) {
            foreach ($package_data as $each) {
                if ($each->receipt_type == null) // no-cepeipt
                {
                    if ($each->mobile_no && $each->email_id) {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no != "" && $each->email_id == "") {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no == "" && $each->email_id != "") {
                        $repeiptmethod = $each->email_id;
                    } else {
                        $repeiptmethod = 'no-receipt';
                    }

                } else if ($each->receipt_type == 'no-cepeipt') {
                    $repeiptmethod = 'no-receipt';
                } else {
                    $repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
                }
                
                

                $package['id'] = $each->id ? $each->id : "";
                $package['p_id'] = "";
                $package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
                $package['name'] = $each->name ? $each->name : "";
                $package['email_id'] = $each->email_id ? $each->email_id : "";
                $package['amount'] = $each->amount ? $each->amount : "";
                $package['title']  = $each->title ? $each->title : "";
                $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
                $package['detail'] = $each->detail ? $each->detail : "";
                $package['payment_id'] = $each->transaction_id ? $each->transaction_id : "";
                $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) ? $this->dateTimeConvertTimeZone($each->add_date,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                
                
                $mem[] = $package;
        

            }
        }
    
        $userdata = $mem;
    
    $status = parent::HTTP_OK;
    $response = ['status' => $status,'TotalDeclined' => $TotalDeclined, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}


public function all_refund_payment_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $start_limit = $this->input->post('start');
    $limit = $this->input->post('limit');
    if($merchant_id == $data->merchant_id)
    {
    $userdata= array();
    if ($_POST['start_date'] != '') {

                $start_date = $_POST['start_date'];

            } else {
                $start_date = date("Y-m-d", strtotime("-364 days"));
            }

            if ($_POST['end_date'] != '') {

                $end_date = $_POST['end_date'];

            } else {
                $end_date = date("Y-m-d");
            }
            
            $type = $_POST['type'];
            
            if ($type == '' or $type == 'straight') {
              //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'customer_payment_request');

               $package_data = $this->list_model->get_search_refund_data('customer_payment_request', $merchant_id, $start_date, $end_date,'Chargeback_Confirm',$start_limit,$limit);

               $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM refund WHERE   merchant_id ='".$merchant_id."' and type='straight' and status='confirm' and  date_c >='".$start_date."' and date_c <='".$end_date."' ");
            } elseif ($type == 'recur') {
                 //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'recurring_payment');
                 $package_data = $this->list_model->get_search_refund_data('recurring_payment', $merchant_id, $start_date, $end_date,'Chargeback_Confirm',$start_limit,$limit);

                  $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM recurring_payment WHERE   merchant_id ='".$merchant_id."' and is_for_vts='false' and status='Chargeback_Confirm' and date_c >='".$start_date."' and date_c <='".$end_date."' ");

            } elseif ($type == 'pos') {
            //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'pos');
              $package_data = $this->list_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date,'Chargeback_Confirm',$start_limit,$limit);

               $stmt_total = $this->db->query("SELECT SUM(amount) as MID FROM refund WHERE   merchant_id ='".$merchant_id."' and type='pos' and status='confirm' and  date_c >='".$start_date."' and date_c <='".$end_date."' ");

            }
            elseif ($type == 'vts') {
            //$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date,'Chargeback_Confirm', $merchant_id, 'pos');
              $package_data = $this->admin_model->get_search_refund_data_vts('pos', $merchant_id, $start_date, $end_date,'Chargeback_Confirm');

            }
            $total_count = $stmt_total->result_array();
            $TotalRefunded = number_format($total_count[0]['MID'],2);
    
    
        $mem = array();
        $member = array();
        if (isset($package_data)) {
            foreach ($package_data as $each) {
                if ($each->receipt_type == null) // no-cepeipt
                {
                    if ($each->mobile_no && $each->email_id) {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no != "" && $each->email_id == "") {
                        $repeiptmethod = $each->mobile_no;
                    } else if ($each->mobile_no == "" && $each->email_id != "") {
                        $repeiptmethod = $each->email_id;
                    } else {
                        $repeiptmethod = 'no-receipt';
                    }

                } else if ($each->receipt_type == 'no-cepeipt') {
                    $repeiptmethod = 'no-receipt';
                } else {
                    $repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
                }
                
                

               $package['id'] = $each->id ? $each->id : "";
                $package['p_id'] = "";
                $package['invoice_no'] = $each->invoice_no ? $each->invoice_no: "";
                $package['name'] = $each->name ? $each->name : "NA";
                $package['email_id'] = $each->email_id ? $each->email_id : "";
                $package['amount'] = $each->refund_amount ? $each->refund_amount : "";
                $package['title']  = $each->title ? $each->title : "";
                $package['mob_no'] = $repeiptmethod ? $repeiptmethod : "";
                $package['detail'] = $each->detail ? $each->detail : "";
                $package['payment_id'] = $each->refund_transaction ? $each->refund_transaction : "";
                $package['payment_date'] = $each->payment_date ? $each->payment_date : "";
                $package['date_c'] = $this->dateTimeConvertTimeZone($each->refund_dt,$merchant_id) ? $this->dateTimeConvertTimeZone($each->refund_dt,$merchant_id) : "";
                $package['reference'] = $each->reference ? $each->reference : "";
                $package['due_date'] = $each->due_date ? $each->due_date : "";
                $package['status'] = "";
                
                
                $mem[] = $package;
        

            }
        }
    
        $userdata = $mem;
    
    $status = parent::HTTP_OK;
    $response = ['status' => $status,'TotalRefunded' => $TotalRefunded, 'UserData' => $userdata];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
    
}








}

/* End of file Api.php */