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

class Edit_recurring_api extends REST_Controller {

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
    public function edit_customer_request_post() {    
      //die('Hi'); 
        $data = array();
    $data = $this->verify_request();
    $merchant_id = $this->input->post('merchant_id');
    $id = $this->input->post('id');
    $id2 = $this->input->post('id');
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
        $merchant_status = $merchantdetails['0']['status'];
        $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
        $amount = $this->input->post('amount') ? $this->input->post('amount') : "";  
                $sub_merchant_id = '0';  
                $fee = ($amount / 100) * $fee_invoice;
                $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
                $fee_email = ($fee_email != '') ? $fee_email : 0;
                $fee = $fee + $fee_swap + $fee_email;
                $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
                $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
                $invoice_no = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
                $recurring_payment = 'start';

                $getRow=$this->db->query(" SELECT * FROM customer_payment_request WHERE id='$id' " )->result_array(); 
                $merchant_id=$getRow[0]['merchant_id']; 
                $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
                $Merchantdata = $getMerchantdata->row_array();
                $reptdata['getEmail1']=$getMerchantdata->result_array();

                
                                       //print_r($_POST);  die();
                       $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
                       $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
                       $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";  
                       //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
                      $detail = $this->input->post('detail') ? $this->input->post('detail') : "";
                      $name = $this->input->post('name') ? $this->input->post('name') : "";
                      $email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
                      $phone=$mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
                     // $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";

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
                       
                       $title = $this->input->post('title') ? $this->input->post('title') : "";
                       $other_charges_state = $this->input->post('other_charges_state') ? $this->input->post('other_charges_state') : "";
                       
                      // $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
                      $recurring_next_pay_date = $this->input->post('recurring_next_pay_date') ? $this->input->post('recurring_next_pay_date') : "";
                      $recurring_pay_start_date = $this->input->post('recurring_pay_start_date') ? $this->input->post('recurring_pay_start_date') : "";
                      $note = $this->input->post('note') ? $this->input->post('note') : "";
                      $reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
                      
                   
                      $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
                       $orignal_amount = $this->input->post('orignal_amount') ? $this->input->post('orignal_amount') : "0.00"; 
                        $update_amount = $this->input->post('update_amount') ? $this->input->post('update_amount') : "0.00"; 
                      
                       //echo $pd__constant;   // pd__constant
                        //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
                       if($pd__constant=='on' &&  $recurring_count=="") 
                        { $recurring_count=-1;  }
                         $recurring_pay_start_date1=date($recurring_pay_start_date);
                       switch($recurring_type)
                                               {
                                                   case 'daily':
                                                   $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
                                                   break;
                                                   case 'weekly':
                                                   $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date1)));
                                                   break;
                                                   case 'biweekly':
                                                   $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date1)));
                                                   break;
                                                   case 'monthly':
                                                   $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date1)));
                                                   break;
                                                   case 'quarterly':
                                                   $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date1)));
                                                   break;
                                                   case 'yearly':
                                                   $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date1)));
                                                   break;
                                                   default :
                                                       $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date1)));
                                                   break; 
                                               }


                                               $data2 = Array(
                                                   'name' => $name,
                                                   'other_charges' => $other_charges,
                                                   'otherChargesName' => $other_charges_title,
                                                   'title' => $title,
                                                  'other_charges_state' => $other_charges_state,
                                                   'email_id' => $email_id,
                                                   'mobile_no' => $mobile_no,
                                                   'orignal_amount' => $orignal_amount,
                                                   'update_amount' => $update_amount,
                                                   'amount' => $amount,
                                                   'sub_total' => $sub_amount,
                                                   'tax' => $total_tax,
                                                   'fee' => $fee,
                                                   's_fee' => $fee_swap,
                                                   'detail' => $detail,
                                                   'note' => $note,
                                                   'recurring_type' => $recurring_type,
                                                   'recurring_type_week' => $recurring_type_weekly,
                                                   'recurring_type_month' => $recurring_type_monthly,
                                                   'recurring_count' => $recurring_count,
                                                   'recurring_payment' => $recurring_payment,
                                                   'recurring_pay_start_date' => $recurring_pay_start_date,
                                                   'recurring_next_pay_date' => $recurring_next_pay_date,
                                                   'recurring_pay_type' => $paytype,
                                                   'ip_a' => $_SERVER['REMOTE_ADDR'],
                                                   'order_type' => 'a'
                                               );
                   
                                           //print_r($data2); die(); 
                                          // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
                                            $this->db->where('id', $id);
                                            $updateresult=$this->db->update('customer_payment_request',$data2);

                                              $status = parent::HTTP_OK;
                             $response = ['status' => $status, 'successMsg' => 'Invoice  : '.$invoice_no.' Updated..','id' => $id];
    }
    else
    {
        $response = ['status' => '401', 'msg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
} 


}  //   End Of The Class 
?>