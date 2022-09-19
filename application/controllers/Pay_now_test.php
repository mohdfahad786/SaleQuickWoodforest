<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Pay_now_test extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->model('Home_model');
        $this->load->model('login_model');
        $this->load->model('Admin_model');
        $this->load->library('email');
        $this->load->library('twilio');
        date_default_timezone_set("America/Chicago");
        // ini_set('display_errors', 1);
        // error_reporting(E_ALL);
    }

    public function index() {
        $data = array('');
        $merchant_key = $this->uri->segment(2);
        $merchant_id = $this->uri->segment(3);
        $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $merchant_id,"merchant_key" => $merchant_key, "payroc" => 1 ));
        $data['itemm'] = $itemm;
        //print_r($itemm);
        if(!empty($itemm)) {
            $this->load->view('secure_payment_test', $data);
        } else {
            $id='Payment Link Not available'; 
            redirect('payment_error/'.$id); 
        }
    }

    public function card_payment() {
        // echo '<pre>';print_r($_POST);die;
        $data['meta'] = "Add New Pos";
        $data['loc'] = "add_pos";
        $data['action'] = "Charge";

        $merchant_id = $this->input->post('merchant_id') ? trim($this->input->post('merchant_id')) : "";
        $merchant_key = $this->input->post('merchant_key') ? trim($this->input->post('merchant_key')) : "";
        $token_status = $this->input->post('token') ? trim($this->input->post('token')) : "";
    
        $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' and merchant_key='" . $merchant_key . "' and payroc=1");
        $getEmail_a = $getQuery_a->result_array();
        $data['$getEmail_a'] = $getEmail_a;

        //$security_key='6457Thfj624V5r7WUwc5v6a68Zsd6YEm';
        $security_key='fcnpBA9a579qp7QA2wMpCtcgGB453Q43';
        $processor_id=trim($getEmail_a[0]['processor_id']);
        //print_r($getEmail_a);
        if (!empty($security_key) and !empty($processor_id) ) {
            $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
            $full_amount = $this->input->post('full_amount') ? $this->input->post('full_amount') : "";
            $sub_total = $this->input->post('full_amount_amount') ? $this->input->post('full_amount_amount') : "0.00";

            $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
            $other_charges = $this->input->post('other_charges_s') ? $this->input->post('other_charges_s') : "";

            $mobile_no = $this->input->post('mobile_no') ? trim($this->input->post('mobile_no')) : "";
            $email_id = $this->input->post('email_id') ? trim($this->input->post('email_id')) : "";
            $reference = $this->input->post('reference') ? trim($this->input->post('reference')) : "";

            $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
            $card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
            $name = $this->input->post('name_card') ? $this->input->post('name_card') : "";

            $cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
            $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
            $isVerified = $this->input->post('isVerified') ? $this->input->post('isVerified') : "";

            // $address = $this->input->post('address') ? $this->input->post('address') : "";
            // $tax = $this->input->post('totaltax') ? $this->input->post('totaltax') : "";
            
            if($other_charges > 0) {
                $amount = $full_amount;
            } else {
                $amount = $amount;
            }

            $str = $this->input->post('exp_month');
            $ex_month=explode("/",$str);
            $expiry_month= $ex_month[0];
            $expiry_year= $ex_month[1];
            // $expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
            // $expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";
            $payment_id_1 = "POS_" . date("Ymdhisu");
            $payment_id = str_replace("000000", "", $payment_id_1);
            // xml post structure
        
            $ccnumber=$card_no;
            $amount=$amount;
            $ccexp=$expiry_month.$expiry_year;
            $cvv=$cvv;
            $authorizationcode="";
            $ipaddress=$_SERVER['REMOTE_ADDR'];
            $orderid=$payment_id;

            if($token_status == 'no') {
            // if($isVerified == 'no') {
                // echo '11';die;
                $query = "";
                // Login Information
                $query.= "security_key=" . urlencode($security_key) . "&";
                $query.= "customer_vault=" . urlencode('add_customer') . "&";
                // Sales Information
                $query.= "ccnumber=" . urlencode($ccnumber) . "&";
                $query.= "ccexp=" . urlencode($ccexp) . "&";
                $query.= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
                $query.= "cvv=" . urlencode($cvv) . "&";
                $query.= "zip=" . urlencode($zip) . "&";
                $query.= "processor_id=" . urlencode($processor_id) . "&";
                $query.= "authorizationcode=" . urlencode($authorizationcode) . "&";
                $query.= "ipaddress=" . urlencode($ipaddress) . "&";
                $query.= "orderid=" . urlencode($orderid) . "&";
                $query.= "type=sale" . "&";

            } else {
                $token_id = $this->input->post('token_id') ? $this->input->post('token_id') : "";
                // echo '22';die;
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
                $query .= "customer_vault_id=". urlencode($token_id) . "&";
            
                $query .= "type=sale";
            }
            // print_r($query);die;

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
            // echo '<pre>';print_r($response);
            
            $card_a_no = $response['cc_number'];
            //$auth_code = $response['authcode'];

            $auth_code1 = $response['authcode']; 
            $auth_code2 = $response['authCode'];
                      
            if($auth_code1!='') {
                $auth_code = $auth_code1;
            } else {
                $auth_code = $auth_code2;
            }

            $trans_a_no = $response['transactionid'];
            $transaction_id =$trans_a_no;

            $ip =$response['ipaddress'];
            $sub_merchant_id = '0';

            if($response['responsetext']=='Approved') {
                $message_a = 'Approved';
            } else {
                $message_a = $response['responsetext'];
            }
            
            if($response['response']==1) {
                $message_complete = 'Approved';
            } else if($response['response']==2) {
                $message_complete = 'Declined';
            } else if($response['response']==3) {
                $message_complete = $response['responsetext'];
            } else {
                $message_complete = 'Error';
            }

            $merchantdetails = $this->Admin_model->s_fee("merchant", $merchant_id);
            $s_fee = $merchantdetails['0']['s_fee'];
            
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
                'sub_total' => $sub_total,
                // 'tax' => $tax,
                'other_charges' => $other_charges,
                'otherChargesName' => $other_charges_title,
                'tax_id' => '0',
                'tax_per' => null,
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
                // 'address' => $address,
                'address' => '',
                'expiry_month' => $expiry_month,
                'expiry_year' => $expiry_year,
                'year' => $year,
                'month' => $month,
                'time1' => $time1,
                'day1' => $day1,
                'date_c' => $today2,
                'auth_code' => $auth_code,
                'status' => $staus,
                'transaction_id' => $trans_a_no,
                'c_type' => 'CNP',
                'processor_name'=>'PAYROC',
                'payment_type' => 'web',
                'card_type' => $card_type,
                'transaction_status' => $message_a,
                'express_responsemessage'=>$message_complete,
                'ip'=>$ip,
                'express_transactiondate' => '',
                'express_transactiontime' => '',
                'acquirer_data' => '',
                'reference' => $reference
                // 'is_link_pay' => '1'
            );

            $id = $this->Admin_model->insert_data("pos", $data);

            $data_pax = array(
                'merchant_id' =>$merchant_id,
                'pos_id' =>$id,
                'rawResponse' =>$test,
            );
            $pax_id = $this->Admin_model->insert_data("payroc_json", $data_pax);

            $mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);

            if($token_status == 'no') {
                $token_data = array(
                    'merchant_id' => $merchant_id,
                    'name' => $name,
                    'token' => $response['customer_vault_id'],
                    'transaction_id' => $transaction_id,
                    'card_type' => $response['cc_type'],
                    'card_expiry_month' => $expiry_month,
                    'card_expiry_year' => $expiry_year,
                    'card_no' => $card_a_no,
                    'zipcode' => $zip,
                    'mobile' => $mob,
                    'email' => $email_id,
                    'status' => '1',
                    'payroc' => '1'
                );
                $id2 = $this->Admin_model->insert_data("token", $token_data);
            }
            // die;
            //$this->db->last_query(); die();

            $getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
            $getEmail1 = $getQuery1->result_array();
            $data['getEmail1'] = $getEmail1;
            $data['card_a_no'] = $card_a_no;
            $data['trans_a_no'] = $trans_a_no;
            $data['card_a_type'] = $card_type;
            $data['message_complete'] = $message_complete;
            $data['name'] = $name;
            $data['amount'] = $amount;
            $data['invoice_no'] = $payment_id;
            $data['date_c'] = $today2;
            $data['reference'] = !empty($reference) ? $reference : '0';

            $data['msgData'] = $data;

            $msg = $this->load->view('email/pos_receipt', $data, true);
            $email = $email_id;

            $MailSubject = ' Point Of Sale Receipt from '.$getEmail1[0]['business_dba_name'];

            $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
            $this->email->to($email);
            $this->email->subject($MailSubject);
            $this->email->message($msg);

            if ($response['response']==1 ) {
                //Satrt QuickBook sync
                $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id and status='1' and vt_status='1' ";
                $result_setting = $this->db->query($query_qb_setting)->result();
                $intuit_realm_id = trim($result_setting[0]->realm_id);
    
                if(!empty($intuit_realm_id)){
                    $url ="https://salequick.com/quickbook/get_invoice_detail_vt";
                    $qbdata =array(
                        'id' => $id,
                        'merchant_id' => $merchant_id
                    );
                    
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result = json_decode($result,true);
                    //print_r($result);
                    curl_close($ch);
                }
                //End QuickBook sync

                $this->email->send();
                
                $purl = base_url() . 'pos_reciept/' . $payment_id . '/' . $merchant_id;     
                if(!empty($mobile_no)) {
                    $sms_reciever = $mobile_no;
                    $sms_message = trim('Payment Receipt : '.$purl);

                    $from = '+18325324983'; //trial account twilio number

                    $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);

                    $to = '+1'.$mob;

                    $response_sms = $this->twilio->sms($from, $to,$sms_message);
                }
                //print_r($response_sms);
                // die();
                
                $this->session->set_flashdata('success', 'Payment successfully done. We send the receipt on the option you choose.');
                redirect(base_url() . 'pay_now/confirm_payment/' . $id.'/'.$merchant_id);
                //redirect(base_url() . 'pos/all_pos');

            } elseif($arrayy['Response']['ExpressResponseMessage'] == 'Declined'){
                $id = 'Declined';
                $this->session->set_flashdata('success', 'Payment successfully done. We send the receipt on the option you choose.');
                redirect(base_url() . 'payment_error/' . $id);
            
            } else {
                $id = $response['responsetext'];
                redirect('payment_error/' . $id);
            }

        } else {
            $id = 'Processor-ID-Not-available';
            redirect('payment_error/' . $id);
        }
    }

    public function confirm_payment() {
        $bct_id = $this->uri->segment(3);
        $merchant_id = $this->uri->segment(4);;

        $data = array();
        $package_data = $this->Admin_model->data_get_where_1('pos', array('id' => $bct_id, 'merchant_id' => $merchant_id));

        $mem = array();

        foreach ($package_data as $each) {
            $mem[] = $each;
        }
        $data['mem'] = $mem;

        return $this->load->view('confirm_payment_dash', $data);
    }

    public function searchByPhoneNo() {
        // echo 1;die;
        $phone = $this->input->post('phone');
        // echo $phone;die;
        // $getQuery_t = $this->db->query("SELECT * FROM token WHERE ( mobile='" . $mob . "' || email='$email') AND `status` ='1' AND merchant_id='$bct_id2'  group by card_no ");
        $query = $this->db->query("SELECT * FROM token WHERE mobile='" . $phone . "' AND `status` ='1' group by card_no");
        $result = $query->result_array();
        $res_count = count($result);
        // echo $res_count;die;

        if($res_count > 0) {
            foreach ($result as $row) {
                // print_r($row);
                $card_expiry = $row['card_expiry_month'].'/'.$row['card_expiry_year'];
                $response[] = array(
                    "label" => $row['mobile'],
                    "value" => $card_expiry.','.$row['card_no'].','.$row['name'].','.$row['id'].','.$row['card_type'],
                    "token" => $row['token'],
                    // "card_type" => $row['card_type']
                );
            }
            echo json_encode($response);
        }
    }

    public function searchByEmail() {
        // echo 1;die;
        $email = $this->input->post('email');
        // echo $phone;die;
        // $getQuery_t = $this->db->query("SELECT * FROM token WHERE ( mobile='" . $mob . "' || email='$email') AND `status` ='1' AND merchant_id='$bct_id2'  group by card_no ");
        $query = $this->db->query("SELECT * FROM token WHERE email LIKE '%" . $email . "%' AND `status` ='1' group by card_no");
        $result = $query->result_array();
        $res_count = count($result);
        // echo $res_count;die;

        if($res_count > 0) {
            foreach ($result as $row) {
                // print_r($row);
                $card_expiry = $row['card_expiry_month'].'/'.$row['card_expiry_year'];
                $response[] = array(
                    "label" => $row['email'],
                    "value" => $card_expiry.','.$row['card_no'].','.$row['name'].','.$row['id'].','.$row['card_type'],
                    "token" => $row['token'],
                    // "card_type" => $row['card_type']
                );
            }
            echo json_encode($response);
        }
    }

    public function verify_zipcode() {
        //echo '<pre>';print_r($_POST);die();
        $card_id = $_POST['checked_card_id'];
        $confirm_zip = $_POST['confirm_zip'];

        $card_details = $this->db->get_where('token', ['id' => $card_id])->result();
        //echo '<pre>';print_r($card_details[0]->zipcode);die();
        echo $card_details[0]->zipcode;die();
    }

}