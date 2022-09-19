<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class EditRecurring extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('profile_model');
		$this->load->model('admin_model');
		$this->load->model('home_model');
		$this->load->library('form_validation');
		//$this->load->library('notification');
		$this->load->library('email');
		$this->load->library('twilio');
		//$this->load->model('sendmail_model');
		$this->load->model('session_checker_model');
		if (!$this->session_checker_model->chk_session_merchant()) {
			redirect('login');
		}
		date_default_timezone_set("America/Chicago");
         // ini_set('display_errors', 1);
         // error_reporting(E_ALL);
    }


    public function index() { 

    }

    public function edit_customer_request($id) {
    	if($_POST) {
    		// echo '<pre>';print_r($_POST);die;
    		$merchant_id = $this->session->userdata('merchant_id');
	    	$aa = $this->admin_model->s_fee("merchant", $merchant_id);

	    	$merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
	        
	        $s_fee = $merchantdetails['0']['s_fee'];
	        $t_fee =$merchantdetails['0']['t_fee'];
	        $merchant_name = $merchantdetails['0']['name'];
	        $fee_invoice = $merchantdetails['0']['invoice'];
	        $fee_swap = $merchantdetails['0']['f_swap_Recurring'];
	        $fee_email = $merchantdetails['0']['text_email'];
	        $names = substr($merchant_name, 0, 3);

			$get_recurring_invoice = $this->admin_model->select_request_id('customer_payment_request',$id);

			$full_amount = $this->input->post('full_amount') ? $this->input->post('full_amount') : "";
			$other_charges = $this->input->post('other_charges_s') ? $this->input->post('other_charges_s') : "0.00";
	        $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";

	    	// if($get_recurring_invoice->recurring_count_paid > 0) {
	    		
	    	// 	$update_amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : '0';
	    	// 	if($other_charges > 0) {
      //               $new_amount = $full_amount;
      //           } else {
      //               $new_amount = $update_amount;
      //           }

	    	// 	$fee = ($update_amount / 100) * $fee_invoice;
	    	// 	$up_data['update_amount'] = $new_amount;

	    	// } else {

	    	// 	$s_amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : '0';
	    	// 	if($other_charges > 0) {
	    	// 		// echo $full_amount;die;
      //               $new_amount = $full_amount;
      //           } else {
      //           	// echo 22;die;
      //               $new_amount = $s_amount;
      //           }

	    	// 	$fee = ($s_amount / 100) * $fee_invoice;
	    	// 	$up_data['update_amount'] = $new_amount;
	    	// }

	    	$s_amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : '0';
    		if($other_charges > 0) {
                $new_amount = $full_amount;
            } else {
            	// echo 22;die;
                $new_amount = $s_amount;
            }
			// echo $new_amount;die;

    		$fee = ($new_amount / 100) * $fee_invoice;
    		$up_data['update_amount'] = $new_amount;
	    	// echo $up_data['update_amount'];die;
			// echo $get_recurring_invoice->recurring_count_paid;die;

	        $merchant_status = $merchantdetails['0']['status'];
	                
	        $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
	        // $amount = $this->input->post('amount') ? $this->input->post('amount') : "";  
	        // echo $amount.','.$fee_invoice;die;
	        $sub_merchant_id = '0';  
	        
	        $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
	        $fee_email = ($fee_email != '') ? $fee_email : 0;
	        $fee = $fee + $fee_swap + $fee_email;
	        $sub_amount = $this->input->post('s_amount') ? $this->input->post('s_amount') : "";
	        $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
	        $invoice_no = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
	        $recurring_payment = 'start';

	        $getRow=$this->db->query(" SELECT * FROM customer_payment_request WHERE id='$id' " )->result_array(); 
	        $merchant_id=$getRow[0]['merchant_id']; 
	        $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
	        $Merchantdata = $getMerchantdata->row_array();
	        $reptdata['getEmail1']=$getMerchantdata->result_array();
	                
			//print_r($_POST);die();
	        
	        $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";  
	        
	        // here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
	        // $detail = $this->input->post('detail') ? $this->input->post('detail') : "";
	        $name = $this->input->post('name') ? $this->input->post('name') : "";
	        $email_id = $this->input->post('s_email') ? $this->input->post('s_email') : "";
	        $mobile_no = $this->input->post('s_mobile') ? $this->input->post('s_mobile') : "";
			// $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";

	        $recurring_type1 = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
	        $myArray = explode(',', $recurring_type1);
	        $recurring_type=strtolower(trim($myArray[0]));

	        if($recurring_type=='weekly'){
	        	$recurring_type_weekly=strtolower(trim($myArray[1]));
	        	$recurring_type_monthly='';
	        } else if($recurring_type=='monthly'){
		        $recurring_type_weekly='';
	    	    $recurring_type_monthly=strtolower(trim($myArray[1]));
	        } else {
		        $recurring_type_weekly='';
	    	    $recurring_type_monthly='';
	        }

	        $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
	        $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
	                       
	        // $title = $this->input->post('title') ? $this->input->post('title') : "";
	        // $other_charges_state = $this->input->post('other_charges_state') ? $this->input->post('other_charges_state') : "";
	                       
	        // $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
	        // $recurring_next_pay_date = $this->input->post('recurring_next_pay_date') ? $this->input->post('recurring_next_pay_date') : "";
	         
	        $note = $this->input->post('note') ? $this->input->post('note') : "";
	        $reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
	        $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
	        // $orignal_amount = $this->input->post('orignal_amount') ? $this->input->post('orignal_amount') : "0.00"; 
	        // $update_amount = $this->input->post('update_amount') ? $this->input->post('update_amount') : "0.00"; 
	                      
			//echo $pd__constant;   // pd__constant
			// here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
	        if($pd__constant=='on' &&  $recurring_count=="") { 
	        	$recurring_count=-1;  
	        }
	        
            if($get_recurring_invoice->recurring_count_paid == 0) {
            	$recurring_pay_start_date = $this->input->post('s_start_date') ? $this->input->post('s_start_date') : "";
            	$recurring_pay_start_date1=date($recurring_pay_start_date);

	        	switch($recurring_type) {
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

            	$up_data['recurring_pay_start_date'] = $recurring_pay_start_date;
            	$up_data['recurring_next_pay_date'] = $recurring_next_pay_date;
            }

			// $up_data = Array(
			$up_data['name'] = $name;
			$up_data['other_charges'] = $other_charges;
			$up_data['otherChargesName'] = $other_charges_title;
			// $up_data['title'] = $title;
			// $up_data['other_charges_state'] = $other_charges_state;
			$up_data['email_id'] = $email_id;
			$up_data['mobile_no'] = $mobile_no;
			// $up_data['orignal_amount'] = $orignal_amount;
			$up_data['sub_total'] = $sub_amount;
			
			$up_data['tax'] = $total_tax;
			$up_data['fee'] = $fee;
			$up_data['s_fee'] = $fee_swap;
			// $up_data['detail'] = '';
			// $up_data['note'] = $note;
			$up_data['recurring_type'] = $recurring_type;
			$up_data['recurring_type_week'] = $recurring_type_weekly;
			$up_data['recurring_type_month'] = $recurring_type_monthly;
			$up_data['recurring_count'] = $recurring_count;
			$up_data['recurring_payment'] = $recurring_payment;
			$up_data['recurring_count_remain'] = $recurring_count-$get_recurring_invoice->recurring_count_paid;
			
			// $up_data['recurring_next_pay_date'] = $recurring_next_pay_date;
			$up_data['recurring_pay_type'] = $paytype;
			$up_data['ip_a'] = $_SERVER['REMOTE_ADDR'];
			$up_data['order_type'] = 'a';
           	// );
                   
			// echo '<pre>';print_r($up_data); die(); 
            // $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
            $this->db->where('id', $id);
            $updateresult=$this->db->update('customer_payment_request',$up_data);
          		// echo $this->db->last_query();die;

            $invoiceNum =$get_recurring_invoice->invoice_no;
            // $query1=$this->db->query("SELECT token.id from token,invoice_token where invoice_token.token_id=token.id and invoice_no='".$invoiceNum."'")->result_array();
            // echo $invoiceNum;die;
            // echo $this->db->last_query();die;
            $currentTokenid= $query1[0]['id'];
            $new_token_input = $_POST['new_token_input'];
            //echo $new_token_input;die;
        	$query2=$this->db->query("update invoice_token set token_id=".$new_token_input.	" where invoice_no='".$invoiceNum."'");
        	//echo $this->db->last_query();die;

    		$this->session->set_flashdata('success', 'Invoice : <span style="color:#f5a623; ">'.$invoice_no.'</span> Updated.'); 
			redirect(base_url('pos/all_customer_request_recurring'));

    	} else {
    		$data['meta'] = 'Edit Recurring';
            $get_recurring_invoice = $this->admin_model->select_request_id('customer_payment_request',$id);
            $data['get_recurring_invoice'] = $get_recurring_invoice;
			
			$invoiceNum =$get_recurring_invoice->invoice_no;
			
			if(!empty($invoiceNum)) {
	            $query1=$this->db->query("SELECT token.id from token,invoice_token where invoice_token.token_id=token.id and invoice_no='".$invoiceNum."'")->result_array();
	            $currentTokenid= $query1[0]['id'];

	            $get_token = $this->db->query("SELECT card_type, right(card_no,4) as 'card_no',token from token where id='".$currentTokenid."' and status=1")->result_array();
	            $data['card_no'] = $get_token[0]['card_no']; 
		        $data['token'] = $get_token[0]['token'];
		        $data['card_type'] = $get_token[0]['card_type'];

			} else {
				$data['card_no'] = '';
		        $data['token'] = '';
		        $data['card_type'] = '';
			}
            //echo '<pre>';print_r($data);die;

            $data['itemslist']=$this->admin_model->search_item($id);

    		$this->load->view("merchant/edit_customer_recurring", $data);
    	}        
	}

}  //   End Of The Class 
?>