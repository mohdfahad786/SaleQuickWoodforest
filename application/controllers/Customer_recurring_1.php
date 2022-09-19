<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Customer_recurring extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->model('acceptcard_model');
        $this->load->model('home_model');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('twilio');
        //$this->load->model('sendmail_model');
        $this->load->model('session_checker_model');
        if (!$this->session_checker_model->chk_session_merchant()) {
            redirect('login');
        }
        if ($this->session->userdata('time_zone')) {
            $time_Zone = $this->session->userdata('time_zone') ? $this->session->userdata('time_zone') : '';
            date_default_timezone_set($time_Zone);
        } else {
            date_default_timezone_set('America/Chicago');
        }
         // ini_set('display_errors', 1);
         // error_reporting(E_ALL);
    }

    public function index() {
        // session_start();
        /*$is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');
        
        if($is_page_refreshed ) {
        $_SESSION["invoice_no"]=null;
          echo 'This Page Is refreshed.'.$_SESSION["invoice_no"];die;
        } */
        $merchant_id = $this->session->userdata('merchant_id');
        $merchant_name = $this->session->userdata('merchant_name');
        $t_fee = $this->session->userdata('t_fee');
        $aa = $this->admin_model->s_fee("merchant", $merchant_id);
        $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
        $s_fee = $merchantdetails['0']['s_fee'];
        $t_fee = $this->session->userdata('t_fee');
        $fee_invoice = $merchantdetails['0']['invoice'];
        $fee_swap = $merchantdetails['0']['f_swap_Recurring'];
        $fee_email = $merchantdetails['0']['text_email'];
        $names = substr($merchant_name, 0, 3);
        $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");

        // print_r($getOtherCharges);die;
        $getDashboardData = $getDashboard->result_array();
        $getDashboardNum = $getDashboard->num_rows();
        $data['getDashboardNum'] = $getDashboardNum;
        if ($getDashboardData == false) {
            $data['getDashboardData'] = '0';
            $inv = '1';
        } else {
            $data['getDashboardData'] = $getDashboardData;
            $inv1 = $getDashboardData[0]['TotalOrders'];
            $inv = $inv1 + 1;
        }
        $merchant_status = $this->session->userdata('merchant_status');
        if ($merchant_status == 'active') {
            $data['meta'] = "Send Recurring Payment Request";
            $data['loc'] = "add_customer_request";
            $data['action'] = "Send Request";
            
            $data['meta'] = 'Recurring';
            $inv = $this->input->post('invoice_no');
            $this->load->view("merchant/customer_recurring", $data);
        } elseif ($merchant_status == 'block') {
            $data['meta'] = "Your Account Is Block";
            $data['loc'] = "";
            $data['resend'] = "";
            $this->load->view("merchant/block", $data);
        } elseif ($merchant_status == 'confirm') {
            $data['meta'] = "Your Account Is Not Active";
            $data['loc'] = "";
            $data['resend'] = "";
            $this->load->view("merchant/block", $data);
        } elseif ($merchant_status == "Activate_Details") {
            $urlafterSign = base_url('merchant/after_signup');
            $data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
            $data['loc'] = "";
            $data['resend'] = "";
            $this->load->view("merchant/blockactive", $data);
        } elseif ($merchant_status == "Waiting_For_Approval") {
            $urlafterSign = base_url('merchant/after_signup');
            $data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
            $data['loc'] = "";
            $data['resend'] = "";
            $this->load->view("merchant/blockactive", $data);
        } else {
            $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
            $data['loc'] = "resend";
            $data['resend'] = "resend";
            $this->load->view("merchant/block", $data);
        }
    }

    public function fetch() {
        $inv = $this->input->post('invoice_no');
        $res = $this->acceptcard_model->fetch($inv);
        $data = array();
        $data['card_no'] = $res[0]['card_no']; 
        $data['token'] = $res[0]['token'];
        // print_r($data);
        // die;
        $this->load->view('merchant/customer_recurring', $data);
        // redirect(base_url().'Customer_recurring/');
    }

    public function create_recurring() {
        // echo '<pre>';print_r($_POST);die;
        $merchant_id = $this->session->userdata('merchant_id');
        $merchant_name = $this->session->userdata('merchant_name');
        $t_fee = $this->session->userdata('t_fee');
        $aa = $this->admin_model->s_fee("merchant", $merchant_id);
        $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
        $s_fee = $merchantdetails['0']['s_fee'];
        $t_fee = $this->session->userdata('t_fee');
        $fee_invoice = $merchantdetails['0']['invoice'];
        $fee_swap = $merchantdetails['0']['f_swap_Recurring'];
        $fee_email = $merchantdetails['0']['text_email'];
        $names = substr($merchant_name, 0, 3);
        $merchant_status = $this->session->userdata('merchant_status');

        $data['meta'] = "Send Recurring Payment Request";
        $data['loc'] = "customer_recurring";
        $data['action'] = "Send Request";
        if (isset($_POST['submit'])) {
            //print_r($_POST);  die();
            // $this->form_validation->set_rules('amount', 'amount', 'required');
            $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
            if ($pd__constant != 'on') {
                $this->form_validation->set_rules('recurring_count', 'Payments Duration', 'required');
            }
            $this->form_validation->set_rules('paytype', 'Payment Type', 'required');
            // $this->form_validation->set_rules('amount', 'amount', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            // $this->form_validation->set_rules('reverence', 'Reverence', 'required');
            // $this->form_validation->set_rules('mobile', 'Phone Number', 'required');
            // $this->form_validation->set_rules('due_date', 'Due  Date', 'required');
            $this->form_validation->set_rules('s_start_date', 'Recurring Start  Date', 'required');
            // $this->form_validation->set_rules('title', 'Title', 'required');
            // $this->form_validation->set_rules('Item_Name[]', 'Item Name', 'required');
            // $this->form_validation->set_rules('Quantity[]', 'Quantity', 'required');
            // $this->form_validation->set_rules('Price[]', 'Price', 'required');
            $amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : "";
            if (!empty($this->session->userdata('subuser_id'))) {
                $sub_merchant_id = $this->session->userdata('subuser_id');
            } else {
                $sub_merchant_id = '0';
            }
            $fee = ($amount / 100) * $fee_invoice;
            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
            $fee_email = ($fee_email != '') ? $fee_email : 0;
            $fee = $fee + $fee_swap + $fee_email;
            $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
            $full_amount = $this->input->post('full_amount') ? $this->input->post('full_amount') : "";
            $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
            $invoice_no_1 = 'INV' . date("ymdhisu");
            $invoice_no = str_replace("000000", "", $invoice_no_1);
            $recurring_payment = 'start';
            $merchant_id = $this->session->userdata('merchant_id');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', '<div class="alert alert-danger text-center">Name,Payments Duration, Amount Are Required.</div>');
                //$this->load->view('merchant/add_customer_request');
                redirect(base_url('customer_recurring'));
            } else {
                //print_r($_POST);  die();
                $other_charges = $this->input->post('other_charges_s') ? $this->input->post('other_charges_s') : "";
                $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
                $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";
                //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
                //$remark = $this->input->post('remark') ? $this->input->post('remark') : "";
                $name = $this->input->post('name') ? $this->input->post('name') : "";
                $email_id = $this->input->post('s_email') ? $this->input->post('s_email') : "";
                $phone = $mobile_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";
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
                $recurring_pay_start_date = $this->input->post('s_start_date') ? $this->input->post('s_start_date') : "";
               
                //echo $pd__constant;   // pd__constant
                //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
                if ($pd__constant == 'on' && $recurring_count == "") {
                    $recurring_count = - 1;
                }
                // echo $recurring_count;  die();
                if ($paytype == '0' || $paytype == '1') {
                    //echo $recurring_count;  die();
                    //print_r($merchant_id);  die("manual");
                    $today1_1 = date("ymdhisu");
                    $today1 = str_replace("000000", "", $today1_1);
                    $url = base_url() . 'rpayment/PY' . $today1 . '/' . $merchant_id;
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
                    $recurring_pay_start_date = date($recurring_pay_start_date);
                    //echo $recurring_type;  die();
                    if ($recurring_count > 0) {
                        $remain = $recurring_count;
                    } else {
                        $remain = 1;
                        $recurring_count = - 1;
                    }
                    switch ($recurring_type) {
                        case 'daily':
                            $recurring_next_pay_date = Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                        break;
                        case 'weekly':
                            $recurring_next_pay_date = Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
                        break;
                        case 'biweekly':
                            $recurring_next_pay_date = date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
                        break;
                        case 'monthly':
                            $recurring_next_pay_date = date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
                        break;
                        case 'quarterly':
                            $recurring_next_pay_date = date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
                        break;
                        case 'yearly':
                            $recurring_next_pay_date = date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
                        break;
                        default:
                            $recurring_next_pay_date = Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                        break;
                    }

                    if($other_charges > 0) {
                        $new_amount = $full_amount;
                    } else {
                        $new_amount = $amount;
                    }
                    // print_r($recurring_pay_start_date);
                    // echo "<br/><br/>";
                    // print_r($recurring_next_pay_date);
                    //die("ok");
                    // echo $_SESSION['token'];die;
         if( $paytype=='1'  && $_SESSION['token']!='' && $today2==$recurring_pay_start_date) {
       
                        $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
                        $mydata['token'] = $_SESSION['token'];
                        $Merchantdata = $getMerchantdata->row_array();
                        $processor_id=$Merchantdata['processor_id'];
                        $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
                        $paymentcard=$mydata['token']; 
                        // echo $paymentcard;die;
                        $authorizationcode="";
                        $ipaddress=$_SERVER['REMOTE_ADDR'];
                        $orderid=$invoice_no;

            
                 if (!empty($security_key) and !empty($processor_id)){
                          $query  = "";
                        // Login Information
                        $query .= "security_key=" . urlencode($security_key) . "&";
                        // Sales Information
                        $query .= "amount=" . urlencode(number_format($new_amount,2,".","")) . "&";
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
                        // echo '<pre>';print_r($response);


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
        // echo 'pending';die;
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

                    
                    // echo $new_amount;die;
                    $token_value = !empty($_SESSION['token']) ? '1' : '0'; 

                    $day1 = date("N");
                    $amountaa = $sub_amount + $fee;
                    $data = Array('reference' => $reference,
                      'name' => $name,
                      'other_charges' => $other_charges,
                      'otherChargesName' => $other_charges_title,
                      'invoice_no' => $invoice_no,
                      'email_id' => $email_id,
                      'mobile_no' => $mobile_no,
                      'amount' => $new_amount,
                      'sub_total' => $amount,
                      'tax' => $total_tax,
                      'fee' => $fee,
                      's_fee' => $fee_swap,
                      'detail' => $remark,
                      'note' => $note,
                      'url' => $url,
                      'payment_type' => 'recurring',
                      'recurring_type' => $recurring_type,
                      'recurring_count' => $recurring_count,
                      'recurring_count_paid' => $recurring_count_paid,
                      // 'recurring_count_paid' => '0',
                      'recurring_count_remain' => $remain,
                      'recurring_pay_start_date' => $recurring_pay_start_date,
                      'recurring_next_pay_date' => $recurring_next_pay_date,
                      'recurring_pay_type' => $paytype,
                      'no_of_invoice' => 1,
                      'merchant_id' => $merchant_id,
                      'sub_merchant_id' => $sub_merchant_id,
                      'payment_id' => $unique,
                      'recurring_payment' => $recurring_payment,
                      'year' => $year,
                      'month' => $month,
                      'time1' => $time1,
                      'day1' => $day1,
                      'token' => $token_value,
                      'status' => $status,
                      'recurring_type_week' => $recurring_type_weekly,
                      'recurring_type_month' => $recurring_type_monthly,
                      'date_c' => $today2,
                      'order_type' => 'a',
                      'processor_name' => 'PAYROC',
                      'transaction_id' => $trans_a_no,
                        'auth_code' => $auth_code,
                        'message' =>  $message_a,
                        'card_type' =>  $card_a_type,
                        'card_no' =>  $card_a_no,
                        'payment_date' => $payment_date,
                    );
                    //print_r($data); die();
                    $id = $this->admin_model->insert_data("customer_payment_request", $data);
                    $data_inv_token = array(
                        'token_id' => $_SESSION['token_id'],
                        'invoice_no' => $invoice_no,
                        'merchant_id' => $merchant_id,
                    );
                    // if(!$this->db->insert('invoice_token', $data_inv_token)) {
                    //     $data_resp['code'] = 500;
                    //     $data_resp['msg'] = 'Recurring Data Insertion Error. Please try again.';
                    //     echo json_encode($data_resp);die;
                    // }
                    $this->db->insert('invoice_token', $data_inv_token);
                    $data = array();
                    unset($_SESSION['token']);
                    unset($_SESSION['token_id']);
                    // echo $id.',hi';die;
                    $data['merchant_id'] = $this->session->userdata('merchant_id');
                    $collect = array('invoice_no' => $invoice_no, 'merchant_id' => $data['merchant_id'],);
                    //print_r($collect);die;
                    $this->acceptcard_model->saveInvoiceNum($collect, $_SESSION['token']);
                    //  $id1 = $this->admin_model->insert_data("graph", $data);
                    // $item_name = json_encode($this->input->post('Item_Name'));
                    // $quantity = json_encode($this->input->post('Quantity'));
                    // $price = json_encode($this->input->post('Price'));
                    // $tax = json_encode($this->input->post('Tax_Amount'));
                    // $tax_id = json_encode($this->input->post('Tax'));
                    // $tax_per = json_encode($this->input->post('Tax_Per'));
                    // $total_amount = json_encode($this->input->post('Total_Amount'));
                    // $item_Detail_1 = array(
                    //   "p_id" => $id,
                    //   "item_name" => ($item_name),
                    //   "quantity" => ($quantity),
                    //   "price" => ($price),
                    //   "tax" => ($tax),
                    //   "tax_id" => ($tax_id),
                    //   "tax_per" => ($tax_per),
                    //   "total_amount" => ($total_amount),
                    // );
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
                    //$this->admin_model->insert_data("order_item", $item_Detail_1);
                    //$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
                    //$data['item_detail'] = $item_Detail_1;
                    $data['msgData'] = $data;
                    
                    // $header = "From: " . $getDashboardData_m[0]['business_dba_name'] . "<info@salequick.com >\r\n" . "MIME-Version: 1.0" . "\r\n" . "Content-type: text/html; charset=UTF-8" . "\r\n";


                    if (($recurring_pay_start_date <= $today2) && ($status=='pending')) {   
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



                    // if ($recurring_pay_start_date <= $today2) {
                    //     if (!empty($email_id)) {
                    //         $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
                    //        $getEmail = $getQuery->result_array();
                    //        $data['getEmail'] = $getEmail;

                    //        $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
                    //        $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
                    //        $data['getEmail1'] = $getEmail1; 
                    //        $data['resend'] = "";
                    //        $email = $getEmail[0]['email_id'];
                    //         $invoice_no = $getEmail[0]['invoice_no'];
                    //        $status = $getEmail[0]['status'];
                    //        $token = $getEmail[0]['token'];
                    //        $url = $getEmail[0]['url'];
                    //        $purl = str_replace('rpayment', 'reciept', $url); 
                    //        $durl='https://salequick.com/add_card/'.$payment_id.'/'.$merchant_id.'/'.$invoice_no;
                           
                    //        $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                    //        $recurring_pay_type = $getEmail[0]['recurring_pay_type'];
                    //        $amount = $getEmail[0]['amount'];  
                    //        $sub_total =$getEmail[0]['sub_total'];
                    //        $tax = $getEmail[0]['tax']; 
                    //        $originalDate = $getEmail[0]['date_c'];
                    //        $newDate = date("F d,Y", strtotime($originalDate)); 
                    //        //Email Process
                    //         $data['business_dba_name'] = $getEmail1[0]['business_dba_name'];
                    //         $data['email'] = $getEmail[0]['email_id'];
                    //         $data['color'] = $getEmail1[0]['color'];
                    //         $data['logo'] = $getEmail1[0]['logo'];
                    //         $data['amount'] = $amount;  
                    //         $data['sub_total'] = $sub_total;
                    //         $data['tax'] = $row['tax']; 
                    //         $data['originalDate'] = $getEmail[0]['date_c'];
                    //         $data['card_a_no'] = $getEmail[0]['card_no'];
                    //         $data['trans_a_no'] = $getEmail[0]['transaction_id'];
                    //         $data['card_a_type'] = $getEmail[0]['card_type'];
                    //         $data['message_a'] = $getEmail[0]['message'];
                    //         $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
                    //         $data['late_fee'] = $getEmail[0]['late_fee'];
                    //         $data['payment_type'] = 'recurring';
                    //         $data['recurring_type'] = $getEmail[0]['recurring_type'];
                    //         $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
                    //         $data['recurring_count'] =$getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
                    //         $today=date('Y-m-d');

                    //         $data['msgData'] = $data;

                    //         $msg = $this->load->view('email/invoice1', $data, true);
                    //         $MailSubject = ' Invoice from ' . $getDashboardData_m[0]['business_dba_name'];
                    //         $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
                    //         $this->email->to($email_id);
                    //         $this->email->subject($MailSubject);
                    //         $this->email->message($msg);
                    //         $this->email->send();
                    //     }
                    //     if (!empty($mobile_no)) {
                    //         $sms_reciever = $mobile_no;
                    //         // $sms_message = "Hello ".$name." from ".$getDashboardData_m[0]['business_dba_name']."  is requesting  ".$amount."  payment from you <a href='".$url."'>CONTINUE TO PAYMENT</a>";
                    //         $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '" . $url . "' ");
                    //         // $sms_message = trim('Payment Url : '.$url);
                    //         $from = '+18325324983'; //trial account twilio number
                    //         $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                    //         $to = '+1' . $mob;
                    //         $response = $this->twilio->sms($from, $to, $sms_message);
                    //         //print_r($response->HttpStatus);
                    //         //print_r($response->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );
                            
                    //     }
                    // }
                    $this->session->set_userdata("mymsg", " New payment request add successfully.");
                    // redirect("merchant/all_customer_request");
                    redirect("pos/all_customer_request_recurring");
                }
            }
        }
    }

}
?>