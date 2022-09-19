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
class Batch_report_test_api extends REST_Controller {
    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
        $this->load->model('Inventory_graph_model');
        $this->load->model('Inventory_graph_model_new');
        $this->load->model('Inventory_graph_model_report');
        $this->load->model('Batch_report_model');
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

    public function tz_list($timezone) {
        $mygmt = "";
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            if ($timezone == $zone) {
                $mygmt = date('P', $timestamp);
                break;
            } else {
                $mygmt = '-05:00';
            }
            $zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);
        }
        //return $zones_array;
        return $mygmt;
    }
    
    public function dateTimeConvertTimeZone2($Adate) {
        if($this->session->userdata('time_zone')) {
            $time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
            date_default_timezone_set('America/Chicago');
            if($time_Zone!='America/Chicago'){
                $datetime = new DateTime($Adate);
                $la_time = new DateTimeZone($time_Zone);
                $datetime->setTimezone($la_time);
                $convertedDateTime=$datetime->format('Y-m-d H:i:s');
            } else {
                $convertedDateTime=$Adate;
            }
            
            
        } else {
            $convertedDateTime=$Adate;
        }
        return $convertedDateTime; 
    }

    public function dateTimeConvertTimeZone($Adate,$timezone) {
        if($timezone!=''){
            date_default_timezone_set($timezone);
        }
        else
        {
         date_default_timezone_set('America/Chicago');   
        }
                    $time_Zone='UTC';
                    $datetime = new DateTime($Adate);
                    $la_time = new DateTimeZone($time_Zone);
                    $datetime->setTimezone($la_time);
                    $convertedDateTime=$datetime->format('Y-m-d H:i:s');

     
            return $convertedDateTime; 
        }


public function report_post()
{
     

    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
      
        $response = array();
        $user = array();
        $user1 = array();
        $user2 = array();
        $user3 = array();
        $user4 = array();
        $user5 = array(); 
        $user6 = array();
        $user7 = array();
        $user8 = array(); 
        $user9 = array();
        $user10 = array();
        $user11 = array();

        $user_summery = array();
        $user_breakdown = array();
        $status = ''; 
        $employee = 0;
        $merchant = $_POST['merchant_id'];
        //$employee = $_POST['employee'];
        $merchant_data = $this->profile_model->get_merchant_details_batch($merchant_id);
                
        $timezone = $merchant_data[0]->time_zone;
      
        $start_date2 = $this->input->post('start');
        $end_date2 = $this->input->post('end');

        
          $batch_report_time=htmlspecialchars(trim($merchant_data[0]->batch_report_time));
       
              $start_date1 = $start_date2.' '.$batch_report_time;
              $end_date1 = $end_date2.' '.$batch_report_time;
                        
          $start_date=$this->dateTimeConvertTimeZone($start_date1,$timezone); 
          $end_date=$this->dateTimeConvertTimeZone($end_date1,$timezone);  





            $package_data_cash = $this->Batch_report_model->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CASH');
            $package_data_check = $this->Batch_report_model->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CHECK');
        
            $package_data_splite = $this->Batch_report_model->get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
            
            $package_data_online = $this->Batch_report_model->get_search_merchant_pos_type_online($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
            $package_data_card = $this->Batch_report_model->get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
            $package_data_card_invoice = $this->Batch_report_model->get_search_merchant_pos_type_card_invoice($start_date, $end_date, $status, $merchant_id,$employee, 'customer_payment_request');

            $package_data_card_invoice_re = $this->Batch_report_model->get_search_merchant_pos_type_card_invoice_re($start_date, $end_date, $status, $merchant_id,$employee, 'recurring_payment');
            //end new
            
            $package_data_cash_total = $this->Batch_report_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CASH');
            
            $package_data_total_count = $this->Batch_report_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
            $package_data_total_count_invoice = $this->Batch_report_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'customer_payment_request');
            $package_data_total_count_invoice_re = $this->Batch_report_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'recurring_payment');
            
           
            $package_data_total_pos_tip = $this->Batch_report_model->get_search_merchant_tip_total($start_date, $end_date,$merchant_id,$employee, 'pos');
            $package_data_total_invoice_tip = $this->Batch_report_model->get_search_merchant_tip_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');

            $package_data_total_pos_tax = $this->Batch_report_model->get_search_merchant_tax_total($start_date, $end_date,$merchant_id,$employee, 'pos');
            $package_data_total_invoice_tax = $this->Batch_report_model->get_search_merchant_tax_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');

            $package_data_total_pos_other_charges = $this->Batch_report_model->get_search_merchant_other_charges_total($start_date, $end_date,$merchant_id,$employee, 'pos');
            //print_r($package_data_total_pos_other_charges); 
            $package_data_total_invoice_other_charges = $this->Batch_report_model->get_search_merchant_other_charges_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');
            //print_r($package_data_total_invoice_other_charges); die();
            $package_data_check_total = $this->Batch_report_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CHECK');
            
            $package_data_online_total = $this->Batch_report_model->get_search_merchant_pos_total_online($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
            $package_data_card_total = $this->Batch_report_model->get_search_merchant_pos_total_card($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
            
            $refund_data_search = $this->Batch_report_model->get_full_refund_data_search_pdf($start_date, $end_date,'pos', $merchant_id);
            $refund_data_search_full = $this->Batch_report_model->get_full_refund_data_search_pdf_full($start_date, $end_date,'pos', $merchant_id);
            $refund_data_search_split = $this->Batch_report_model->get_full_refund_data_search_pdf_split($start_date, $end_date,'pos', $merchant_id);

            $refund_data_search_invoice = $this->Batch_report_model->get_full_refund_data_search_pdf($start_date, $end_date,'customer_payment_request', $merchant_id);
            $refund_data_search_invoice_rec = $this->Batch_report_model->get_full_refund_data_search_pdf($start_date, $end_date,'recurring_payment', $merchant_id);

            $refund_data_cash = $this->Batch_report_model->get_full_refund_cash_check($start_date, $end_date,'pos',$merchant_id,'CASH');
            $refund_data_check = $this->Batch_report_model->get_full_refund_cash_check($start_date, $end_date,'pos',$merchant_id,'CHECK');
            $refund_data_card = $this->Batch_report_model->get_full_refund_card($start_date, $end_date,'pos',$merchant_id);
            $refund_data_online = $this->Batch_report_model->get_full_refund_online($start_date, $end_date,'pos',$merchant_id);

             $refund_data_cash_s = $this->Batch_report_model->get_full_refund_cash_check_s($start_date, $end_date,'pos',$merchant_id,'CASH');
            $refund_data_check_s = $this->Batch_report_model->get_full_refund_cash_check_s($start_date, $end_date,'pos',$merchant_id,'CHECK');
            $refund_data_card_s = $this->Batch_report_model->get_full_refund_card_s($start_date, $end_date,'pos',$merchant_id);
            $refund_data_online_s = $this->Batch_report_model->get_full_refund_online_s($start_date, $end_date,'pos',$merchant_id);
            $refund_data_total_new = $this->Batch_report_model->get_full_refund_total_count_new($start_date, $end_date,$merchant_id);




    $mem11 = array();
    foreach ($package_data_splite as $a_data) {
     
     // $temp11  = array(
     // 'ID'=>$a_data['invoice_no'],
     //  );
     if ($a_data['transaction_type'] == "split") {
                    $this->db->where('invoice_no', $a_data['invoice_no']);
                    $this->db->where('merchant_id ', $merchant_id);
                    $query = $this->db->get('pos');
                    $split_payment = $query->result_array();

                    foreach ($split_payment as $split_payment_Data) {

                         $temp11  = array(
     'Split_id'=>$a_data['invoice_no'],                      
     'ID'=>$split_payment_Data['transaction_id'], 
     'Type'=>$split_payment_Data['card_type'], 
     'amount'=>number_format($split_payment_Data['amount'],2,'.','')
      );
     //array_push($user, $temp);
      $mem11[] = $temp11;
                    }
                }


     }
     $user11=$mem11;







    $mem = array();
    foreach ($package_data_cash as $each) {
     
     $temp  = array(
     'ID'=>$each['transaction_id'], 
     'Type'=>$each['card_type'], 
     'amount'=>number_format($each['amount'],2,'.','')
      );
      //array_push($user, $temp);
      $mem[] = $temp;
     }
     $user=$mem;

     $mem_1 = array();
    foreach ($package_data_check as $each1) {
     
     $temp1 = array(
     'ID'=>$each1['transaction_id'], 
     'Type'=>$each1['card_type'], 
     'amount'=>number_format($each1['amount'],2,'.','')
      );
      //array_push($user, $temp);
      $mem_1[] = $temp1;
     }
     $user1=$mem_1;

     $mem_2 = array();
    foreach ($package_data_online as $each2) {
     
     $temp2 = array(
     'ID'=>$each2['transaction_id'], 
     'Type'=>$each2['card_type'], 
     'amount'=>number_format($each2['amount'],2,'.','')
      );
      //array_push($user, $temp);
      $mem_2[] = $temp2;
     }
     $user2=$mem_2;

     $mem_3 = array();
    foreach ($package_data_card as $each3) {
     
     $temp3 = array(
     'ID'=>$each3['transaction_id'], 
     'Type'=>$each3['card_type'], 
     'amount'=>number_format($each3['amount'],2,'.','')
      );
      //array_push($user, $temp);
      $mem_3[] = $temp3;
     }
     $user3=$mem_3;

     $mem_6 = array();
    foreach ($package_data_card_invoice as $each6) {
     
     $temp6 = array(
     'ID'=>$each6['transaction_id'], 
     'Type'=>$each6['card_type'], 
     'amount'=>number_format($each6['amount'],2,'.','')
      );
      //array_push($user, $temp);
      $mem_6[] = $temp6;
     }
     $user6=$mem_6;
     $user7=array_merge($user3,$user6);


      $mem_8 = array();
    foreach ($refund_data_search_full as $each8) {
     
     $temp8 = array(
     'ID'=>$each8['refund_transaction'], 
     'Type'=>$each8['card_type'], 
     'amount'=>number_format($each8['refund_amount'],2,'.','')
      );
      //array_push($user, $temp);
      $mem_8[] = $temp8;
     }
     $user8=$mem_8;

      $mem_9 = array();
    foreach ($refund_data_search_split as $each9) {
     
     $temp9 = array(
     'ID'=>$each9['refund_transaction'], 
     'Type'=>$each9['card_type'], 
     'amount'=>number_format($each9['refund_amount'],2,'.','')
      );
      $mem_9[] = $temp9;
     }
     $user9=$mem_9;

      $mem_10 = array();
    foreach ($refund_data_search_invoice as $each10) {
     
     $temp10 = array(
     'ID'=>$each10['refund_transaction'], 
     'Type'=>$each10['card_type'], 
     'amount'=>number_format($each10['refund_amount'],2,'.','')
      );
      $mem_10[] = $temp10;
     }
     $user10=$mem_10;

   
  $user4=array_merge($user8,$user9,$user10);


  $user_summery = array(
     
     
 'Net_total'=>max(number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount'])),2),0), 
 'Other_charges'=>max(number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2),0), 
 'Gross_total'=>max(number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount']+$package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount'])),2),0), 
 'Purchases_count'=>max($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'],0),
 'Purchases_amount'=>max(number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']) -($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount'])),2),0),
 'Refunds_count'=>$refund_data_total_new[0]['id'],
 'Refunds_amount'=>max(number_format(($refund_data_total_new[0]['amount']),2),0),
 'Tips_count'=>$package_data_total_pos_tip[0]['id']+$package_data_total_invoice_tip[0]['id'],
 'Tips_amount'=>max(number_format(($package_data_total_pos_tip[0]['amount']+$package_data_total_invoice_tip[0]['amount']),2),0),
 'Tax_count'=>max($package_data_total_pos_tax[0]['id']+$package_data_total_invoice_tax[0]['id'],0),
 'Tax_amount'=>max(number_format(($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount']),2),0),
 'Other_charges_count'=>max($package_data_total_pos_other_charges[0]['id']+$package_data_total_invoice_other_charges[0]['id'],0),
 'Other_charges_amount'=>max(number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2),0)
 
 
 );

  $user_breakdown = array(
     
     
 'Net_total'=>max(number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount']),2),0),
 'Total_purchases_count'=>max(($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']-$refund_data_total_new[0]['id']),0),
 'Total_purchases_amount'=>max(number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$refund_data_total_new[0]['amount']),2),0),
 'Cash_purchases_count'=>max(($package_data_cash_total[0]['id']-$refund_data_cash[0]['id']),0),
 'Cash_purchases_amount'=>max(number_format(($package_data_cash_total[0]['amount']-$refund_data_cash[0]['amount']),2),0),
 'Card_purchases_count'=>max(($package_data_card_total[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'] -$refund_data_card[0]['id'] - $total_item_card_p),0),
 'Card_purchases_amount'=>max(number_format(($package_data_card_total[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$refund_data_card[0]['amount']-$total_paid_card_p),2),0),
 'Check_purchases_count'=>max(($package_data_check_total[0]['id']-$refund_data_check[0]['id']),0),
 'Check_purchases_amount'=>max(number_format(($package_data_check_total[0]['amount']-$refund_data_check[0]['amount']),2),0),
 'Other_purchases_count'=>max(($package_data_online_total[0]['id']-$refund_data_online[0]['id']),0),
 'Other_purchases_amount'=>max(number_format(($package_data_online_total[0]['amount']-$refund_data_online[0]['amount']),2),0),
 'Refunds_count'=>$refund_data_total_new[0]['id'],
 'Refunds_amount'=>max(number_format(($refund_data_total_new[0]['amount']),2),0),
 'Cash_refunds_count'=>max(($refund_data_cash[0]['id'] + $refund_data_cash_s[0]['id']),0),
 'Cash_refunds_amount'=>max(number_format(($refund_data_cash[0]['amount']+$refund_data_cash_s[0]['amount']),2),0),
 'Card_refunds_count'=>max(($refund_data_card[0]['id'] + $refund_data_card_s[0]['id']),0),
 'Card_refunds_amount'=>max(number_format(($refund_data_card[0]['amount'] + $refund_data_card_s[0]['amount']),2),0),
 'Check_refunds_count'=>max(($refund_data_check[0]['id']+$refund_data_check_s[0]['id']),0),
 'Check_refunds_amount'=>max(number_format(($refund_data_check[0]['amount']+$refund_data_check_s[0]['amount']),2),0),
 'Other_refunds_count'=>max(($refund_data_online[0]['id']+$refund_data_online_s[0]['id']),0),
 'Other_refunds_amount'=>max(number_format(($refund_data_online[0]['amount']+$refund_data_online_s[0]['amount']),2),0)
 
 );

     

     $status = parent::HTTP_OK;
     $response['status'] = $status; 
     $response['successMsg'] = 'successfull'; 
     $response['Summary'] = $user_summery; 
     $response['Breakdown'] = $user_breakdown;
     $response['Cash_Purchases'] = $user; 
     $response['Check_Purchases'] = $user1;
     $response['Other_Purchases'] = $user2;
     $response['Card_Purchases'] = $user7;
     $response['Split_Purchases'] = $user11;
     $response['Refund_Purchases'] = $user4;
     $response['Email'] = 'true';


    }

    else
      {
          $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
      }
              $this->response($response, $status);

}


  
    public function email_post() {
    $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
		$merchant_id = $this->input->post('merchant_id1');
    $get_merchant_data = $this->profile_model->get_merchant_details_batch($merchant_id);
    //echo "<pre>";print_r($get_merchant_data);die;

        if (!empty($get_merchant_data)) { 
            foreach ($get_merchant_data as $key => $value) {
               $merchant_id = $value->id;
              
                
                $report_email =$value->report_email;
                $email = $value->email;


                $timezone = $value->time_zone;
      
        $start_date2 = $this->input->post('start');
        $end_date2 = $this->input->post('end');

        
         $batch_report_time=htmlspecialchars(trim($value->batch_report_time));
       
              $start_date1 = $start_date2.' '.$batch_report_time;
              $end_date1 = $end_date2.' '.$batch_report_time;
                        
          // $start_date=$this->dateTimeConvertTimeZone($start_date1,$timezone); 
          // $end_date=$this->dateTimeConvertTimeZone($end_date1,$timezone);  

           echo $last_date=$this->dateTimeConvertTimeZone($start_date1,$timezone); 
		   echo 'ss';
		   
          echo $date=$this->dateTimeConvertTimeZone($end_date1,$timezone);  

               
                  //  echo $last_date = date("Y-m-d", strtotime("-1 days"));
                   // echo $date = date("Y-m-d", strtotime("-1 days"));

                 
         $package_data = $this->Batch_report_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
                 
// echo "<pre>";print_r($package_data);
                    $mem = array();
                    $member = array();
                    $sum = 0;
                    $sum_ref = 0;
                    if (!empty($package_data)) {
                        foreach ($package_data as $key => $each) {
                            if ($each->status == 'Chargeback_Confirm') {
                                $package['Amount'] = '-$' . $each->amount;
                                $sum_ref += $each->amount;
                            } else {
                                $package['Amount'] = '$' . $each->amount;
                                
                            }$sum += $each->amount;
                            $package['Tax'] = $each->tax;
                            $package['Card'] = Ucfirst($each->card_type);
                            if ($each->type = 'straight') {
                                $package['Type'] = 'INV';
                            } else {
                                $package['Type'] = $each->type;
                            }
                            $package['Date'] = $each->date_c;
                            $package['Referece'] = $each->reference;
                            $mem[] = $package;
                        }
                       // $data['item'] = $mem;
                        $invoice_count = $key + 1;
                        // echo "<br>";
                    } else {
                        $invoice_count = 0;
                    }

                    $sum1 = 0;
                    $sum_ref1 = 0;
                    $recurring_payment_count = 0;

                    $package_data2 = $this->Batch_report_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
                    // echo "<pre>";print_r($package_data2);
                    $mem2 = array();
                    $member2 = array();
                    $sum2 = 0;
                    $sum_ref2 = 0;
                    if (!empty($package_data2)) {
                        foreach ($package_data2 as $key2 => $each) {
                            if ($each->status == 'Chargeback_Confirm') {
                                $package2['Amount'] = '-$' . $each->amount;
                                $sum_ref2 += $each->amount;
                            } else {
                                $package2['Amount'] = '$' . $each->amount;
                                
                            }$sum2 += $each->amount;
                            $package2['Tax'] = '$' . $each->tax;
                            $package2['Card'] = Ucfirst($each->card_type);
                            $package2['Type'] = strtoupper($each->type);
                            $package2['Date'] = $each->date_c;
                            $package2['Referece'] = $each->reference;
                            $mem2[] = $package2;
                        }
//$data['item2'] = $mem2;
                        $pos_count = $key2 + 1;
                        // echo "<br>";
                    } else {
                        $pos_count = 0;
                    }
                    ####################################
                    $package_data3 = $this->Batch_report_model->get_report_refund_data("pos", $date, $last_date, $merchant_id);
                    $sum_ref3 = 0;
                    if (!empty($package_data3)) {
                        foreach ($package_data3 as $key2 => $each) {
                            if ($each->status == 'Chargeback_Confirm') {
                                $package2['Amount'] = '-$' . $each->refund_amount;
                                $sum_ref3 = $sum_ref3+$each->refund_amount;
                            } 
                            
                        }
                    } 
                    
                    $package_dat5 = $this->Batch_report_model->get_report_refund_data("customer_payment_request", $date, $last_date, $merchant_id);
                    $sum_ref5 = 0;
                    if (!empty($package_data5)) {
                        foreach ($package_data5 as $key2 => $each) {
                            if ($each->status == 'Chargeback_Confirm') {
                                $package2['Amount'] = '-$' . $each->refund_amount;
                                $sum_ref5 = $sum_ref5+$each->refund_amount;
                            } 
                            
                        }
                    } 

                    
                    $totalsum=($sum + $sum1 + $sum2);
                    // $totalsumr=(float)($sum_ref + $sum_ref1 + $sum_ref2+$sum_ref3+$sum_ref5);
                    $totalsumr=(float)($sum_ref3+$sum_ref5);
                    $totalamount=$totalsum-$totalsumr; 
                    $reporting_data['invoice_count'] = $invoice_count;
                    $reporting_data['recurring_payment_count'] = $recurring_payment_count;
                    $reporting_data['pos_count'] = $pos_count;
                    $reporting_data['total_transaction'] = ($invoice_count + $recurring_payment_count + $pos_count);
                    $reporting_data['totalsum'] = '$' . number_format($sum + $sum1 + $sum2, 2);
                    $reporting_data['totalsumr'] = '$' . number_format($sum_ref3+$sum_ref5, 2);
                    $reporting_data['totalamount'] = '$' . number_format($totalamount,2);
                    $reporting_data['business_dba_name'] = $value->business_dba_name;
                    $reporting_data['mob_no'] = $value->mob_no;
                     $reporting_data['email'] = $value->email;
                    $reporting_data['logo'] = $value->logo;
                    $reporting_data['address1'] = $value->address1;
                    $reporting_data['report_type'] = "Daily";
                    $reporting_data['report_email'] = $report_email;
                    $reporting_data['totalsum_email'] = number_format($sum + $sum1 + $sum2, 2);
    $reporting_data['pdf_link'] = 'https://salequick.com/batchreport/' . $last_date . '/' . $merchant_id. '/' .$date;
                    // echo "<pre>";print_r($reporting_data);die;
                    // die;
                    // $data['msgData'] = $data;
                    $msg = $this->load->view('email/batch_reporting', $reporting_data, true);
                   

                       
    
$getQuery1 = $this->db->query("SELECT count(id) as id from batch_report_email_test where merchant_id ='" . $merchant_id . "' and date ='" . $last_date . "'  ");
                        $getEmail1 = $getQuery1->result_array();
                       // print_r($getEmail1); die();
                    
                         $id =$getEmail1[0]['id'];
                          $report_email; 
         if ($id==0) { 
                    //if (!empty($email) && empty($report_email)) {  
                        if (!empty($report_email)) {  
                        
                        $this->email->from('info@salequick.com', 'SaleQuick');
                        
                       // $this->email->to($report_email);
                       $this->email->to('sq.dev007@gmail.com');
                       $this->email->subject('Salequick Batch Reporting');
                       $this->email->message($msg);

                        $getQuery_mail_count = $this->db->query("SELECT count(id) as id from batch_report_email_test where merchant_id ='" . $merchant_id . "' and date ='" . $last_date . "'  ");
                        $getEmail_count = $getQuery_mail_count->result_array();
                         $id_count =$getEmail_count[0]['id'];
         if ($id_count==0) { 
                        $this->email->send();
                    }

                        $branch_info = array(
                        'merchant_id' => $merchant_id,
                        'type' => '2',
                        'date' => $last_date,
                        'email' => $report_email,
                        );

                        $id11 = $this->admin_model->insert_data("batch_report_email_test", $branch_info);

                    }

                    else if (empty($report_email)) {   
                        $this->email->from('info@salequick.com', 'SaleQuick');
                       // $this->email->to($email);
                        $this->email->to('sq.dev007@gmail.com');
                        $this->email->subject('Salequick Batch Reporting');
                        $this->email->message($msg);
                        $getQuery_mail_count = $this->db->query("SELECT count(id) as id from batch_report_email_test where merchant_id ='" . $merchant_id . "' and date ='" . $last_date . "'  ");
                        $getEmail_count = $getQuery_mail_count->result_array();
                         $id_count =$getEmail_count[0]['id'];
         if ($id_count==0) { 
                        $this->email->send();
                    }

                        $branch_info = array(
                        'merchant_id' => $merchant_id,
                        'type' => '1',
                        'date' => $last_date,
                        'email' => $email,
                        );

                        $id11 = $this->admin_model->insert_data("batch_report_email_test", $branch_info);

                    }


                    $status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Successfull']; 

                 }
                     else
                     {
                         $status = parent::HTTP_OK;
                        $response = ['status' => $status, 'successMsg' => 'Successfull']; 
                     }
                }
                
        //  }
            
        }

        }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
    }
   


 }
 
 
 
 