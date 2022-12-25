<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
// header("Content-type: text/xml");

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model("serverside_model");
		$this->load->model("invoice_model");
		$this->load->model("recurring_model");
		$this->load->model("Home_model");
		$this->load->model('session_checker_model');
		$this->load->library('email');
		$this->load->library('twilio');

		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}

		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}

	public function add_merchant() {
		$data['meta'] = "Add New Merchant";
		$data['loc'] = "create_merchant";
		$data['action'] = "Add New Merchant";

		$this->load->view("admin/add_merchant_dash", $data);
  	}
  	public function create_merchant() {
  		// echo '<pre>';print_r($_POST);die;

  		$this->form_validation->set_rules('memail', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
		$this->form_validation->set_rules('primary_phone', 'Mobile No', 'required|is_unique[merchant.mob_no]');
		$this->form_validation->set_rules('business_dba_name', 'DBA Name', 'required|regex_match[/^([A-Z0-9a-z .,#&"-])+$/i]|max_length[100]');
		$this->form_validation->set_rules('business_name', 'Legal Business Name', 'required|regex_match[/^([A-Z0-9a-z .,#])+$/i]|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata("error", validation_errors());
			redirect('dashboard/add_merchant');

		} else {
			$email = $this->input->post('memail') ? $this->input->post('memail') : "";
			$pc_phone = $this->input->post('primary_phone') ? $this->input->post('primary_phone') : "";
			$business_name = $this->input->post('business_name') ? $this->input->post('business_name') : "";
			$business_dba_name = $this->input->post('business_dba_name') ? $this->input->post('business_dba_name') : "";
			$taxid = $this->input->post('taxid') ? $this->input->post('taxid') : "";
			
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";
			// $password1 = substr(md5(uniqid(rand(), true)), 0, 10);
			$password = $this->my_encrypt($password1, 'e');

			$today1 = date("Ymdhisu");
			$unique = "SAL" . $today1;
			$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
			
			$usr_result = $this->db->query("SELECT * FROM merchant WHERE email='$email'")->row_array();
			// echo $this->db->last_query();die;
			// print_r($usr_result);die;
			
			if(empty($usr_result)) {
				$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
				$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
				$create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') : '0' . "";

				$view_menu_permissions='';
				$view_menu_permissions .=$this->input->post('ViewPermissions') ? $this->input->post('ViewPermissions').',' : "";  
				$view_menu_permissions .=$this->input->post('AddPermissions') ? $this->input->post('AddPermissions').',' : "";  
				$view_menu_permissions .=$this->input->post('EditPermissions') ? $this->input->post('EditPermissions').',' : "";  
				$view_menu_permissions .=$this->input->post('DeletePermissions') ? $this->input->post('DeletePermissions').',' : ""; 
				$view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
				$view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
				$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
				$view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
				$view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
				$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
				$view_menu_permissions .= $this->input->post('VirtualTerminal') ? $this->input->post('VirtualTerminal').',' : "";  
				$view_menu_permissions .= $this->input->post('IInvoicing') ? $this->input->post('IInvoicing').',' : "";  
				$view_menu_permissions .= $this->input->post('IRecurring') ? $this->input->post('IRecurring').',' : "";  
				$view_menu_permissions .= $this->input->post('RInstoreMobile') ? $this->input->post('RInstoreMobile').',' : "";
				$view_menu_permissions .= $this->input->post('RInvoice') ? $this->input->post('RInvoice').',' : "";
				$view_menu_permissions .= $this->input->post('ItemsManagement') ? $this->input->post('ItemsManagement').',' : "";  
				$view_menu_permissions .= $this->input->post('Reports') ? $this->input->post('Reports').',' : "";  
				$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";

				$data = array(
					"email" => $email,
					"pc_email" => $email,
					"password" => $password,
					"auth_key" => $unique,
				    "merchant_key" => $merchant_key,
				    'user_type'=>'merchant',
					'status' => 'pending_signup',
					'is_token_system_permission' => '1',
					'is_tokenized' => '1',
					'pc_phone' => $pc_phone,
					'business_name'=>$business_name,
					'name'=>$business_name,
					'business_dba_name'=>$business_dba_name,
					'taxid'=>$taxid,
					'wood_forest' => '1',
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'create_pay_permissions' => $create_pay_permissions,
					'view_menu_permissions' => $view_menu_permissions,
				);

				if ($email) {
					$last_merchantId = $this->Home_model->insert_data("merchant", $data);
					$ins_merchant_graph = array(
						'id' => NULL,
						'merchant_id' => $last_merchantId
					);
					$this->db->insert('merchant_year_graph', $ins_merchant_graph);
					$this->db->insert('merchant_year_graph_two', $ins_merchant_graph);
	                if (!empty($last_merchantId)) {
	                    //print_r($usr_result); die;   
	                    // $usr_result_merchant = $this->reset_model->get_merchant_detail($username);
	                    // $password1 = time();
	                    // $token = date("Ymdhmsu");
	                    // $merchant_id=$last_merchantId;
	                             
	                    // $getQuery_delete = $this->db->query(" DELETE FROM change_password where merchant_id='".$merchant_id."' "); 
	                    // $getQuery_a = $this->db->query("INSERT INTO change_password (merchant_id, token) VALUES ('".$merchant_id."', '".$token."') ");
	                    // //$password = $this->my_encrypt( $password1 , 'e' );
	                    // //$usr_update = $this->reset_model->update_merchant($username,$password);
	                    // $url = base_url().'reset/password/'.$merchant_id.'/'.$token;

	                    // set_time_limit(3000); 
	                    // $MailTo = $email; 
	                    // $MailSubject = 'Salequick Credentials'; 
	                    // $header = "From: Salequick<info@salequick.com>\r\n".
	                    // "MIME-Version: 1.0" . "\r\n" .
	                    // "Content-type: text/html; charset=UTF-8" . "\r\n"; 
	                    // // $msg = " Reset Link : ".$url." ";
	                    // $htmlContent = '<!DOCTYPE html>
	                    //     <html>
	                    //     <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	                    //     <title></title>
	                    //     <meta name="viewport" content="width=device-width, initial-scale=1">
	                    //     <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
	                    //     </head>
	                    //     <body style="padding: 0px;margin: 0;font-family:Open Sans, sans-serif;font-size: 14px !important;color: #333;">
	                    //     <div style="max-width: 751px;margin: 0 auto;background:#fafafa;">
	                    //     <div style="color:#fff;padding-top: 30px;padding-bottom: 5px;background-color: #2273dc;border-top-left-radius: 10px;border-top-right-radius: 10px;">
	                    //     <div style="width:80%;margin:0 auto;">
	                    //     <div style="width: 245px;text-align: center;height: 70px;border-radius: 50%;margin: 10px auto 20px;padding: 10px;box-shadow: 0px 0px 5px 10px #438cec8c;"><img src="https://salequick.com/front/images/logo-w.png" style="max-width: 90%;width: 100%;margin: 8px auto 0;display: block;"></div>
	                    //     </div>
	                    //     </div>
	                    //     <div style="max-width: 563px;text-align:right;margin: 0px auto 0;clear: both;width: 100%;display: table;">
	                    //     <p style="text-align: center !important;font-size: 20px !important;font-family: sans-serif !important;letter-spacing: 3px;color: #3c763d;font-weight: 600 !important;">Salequick Credentials</p>
	                    //     <p style="font-size: 16px !important;text-align: center !important;">Hi, Your password is <b>"'.$password1.'"</b> , If you want to reset it then click on link below to create a new password:</p>
	                    //     <p style="line-height: 1.432;text-align: center !important;">
	                    //     <a href="'.$url.'" style="max-height: 40px;padding: 10px 20px;display: inline-flex;justify-content: center;align-items: center;font-size: 0.875rem;font-weight: 600;letter-spacing: 0.03rem;color: #fff;background-color: #696ffb;text-decoration: none;border-radius: 20px;">Set a new password</a>
	                    //     </p> 
	                    //     <p style="font-size: 16px !important;text-align: center !important;">If you did not requested a password reset. you can ignore this email. Your password will not be changed.</p>
	                    //     </div>
	                    //     <div style="padding: 25px 0;overflow:hidden;">
	                    //     <div style="width: 100%;margin:0 auto;overflow:hidden;max-width: 80%;">
	                    //     <div style="width: 100%;margin:10px auto 20px;text-align:center;">
	                    //     </div>
	                    //     </div>
	                    //     <footer style="width:100%;padding: 35px 0 21px;background: #414141;margin-top: 0px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
	                    //     <div style="text-align:center;width:80%;margin:0 auto;color: rgba(255, 255, 255, 0.75);">
	                    //     <h5 style="margin-top: 0;margin-bottom: 10px;font-size: 16px;font-weight:400;line-height: 1.432;">Feel free to contact us any time with question and concerns.</h5>
	                    //     <p style="text-align:center"><a href="https://salequick.com/" style="color: #6ea9ff;cursor:pointer;text-decoration:none !important;"><span style="color: rgba(255, 255, 255, 0.55);">Powered by:</span> SaleQuick.com</a></p>
	                    //     </div>
	                    //     </footer>
	                    //     </div>
	                    //     </body>
	                    //     </html>
	                    // ';

	                    // ini_set('sendmail_from', $email); 
	                    // // mail($MailTo, $MailSubject, $msg, $header);
	                    // $this->email->from('reply@salequick.com', 'Reset Password Link');
	                    // $this->email->to($MailTo);
	                    // $this->email->subject($MailSubject);
	                    // $this->email->message($htmlContent);
	                    // $this->email->send();
	                    // $this->session->set_userdata($sessiondata);
	                    $merchants = $this->db->select('id')->from('merchant')->where('wood_forest', '1')->get()->result_array();
						// echo $this->db->last_query();die;
						foreach ($merchants as $key => $mer_val) {
							$merchant_str .= $mer_val['id'].',';
						}
						// echo $merchant_str;die;
						$merchant_str .= $id.',';
						$merchant_str = rtrim($merchant_str, ',');
						$wf_data = array(
							'wf_merchants' => $merchant_str
						);
						// echo '<pre>Session before';print_r($_SESSION);
						$this->db->where('user_type', 'wf')->update('admin', $wf_data);
						$usr_result=$this->db->query("SELECT * from admin where id='".$_SESSION['id']."' and status='active'")->row_array();
	                    $sessiondata = array('wf_merchants'=>$usr_result['wf_merchants']);
	                    $this->session->set_userdata($sessiondata);
	     				// print_r($_SESSION);die;
	                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Merchant added successfully.  </div>');
	            		redirect('dashboard/all_merchant');
	                } else {
	                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email-Id!</div>');
	                    redirect('dashboard/all_merchant');
	                }

				} else {
					$this->session->set_flashdata("error", "Unauthorized email account. Please try another.");
					redirect('dashboard/add_merchant');
				}
			
			} else {
				$this->session->set_flashdata("error", "This email is already registered. Please try another.");
				redirect('dashboard/add_merchant');
			}
		}
		
	}
	public function add_subuser() {
		$merchant_id=$this->uri->segment(3);
		$get_merchant = $this->db->select('status')->from('merchant')->where('id', $merchant_id)->get()->row();

		if($get_merchant->status != 'active') {
			echo 'Unauthorised Merchant';die;
		}
		// echo $merchant_id;die;
		$data['meta'] = "Add Sub User";
		$data['loc'] = "save_subuser";
		$data['action'] = "Add Sub User";
		$emp_pin=$this->getDigit($merchant_id);
		$data['employee_pin']=$emp_pin;
		$data['merchant_id']=$merchant_id;
		$this->load->view("admin/add_subuser_dash", $data);
	}
	public function save_subuser(){
				$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
				$this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[merchant.mob_no]');
				
				$email = $this->input->post('memail') ? $this->input->post('memail') : "";
				$pc_phone = $this->input->post('primary_phone') ? $this->input->post('primary_phone') : "";

				// $password1 = substr(md5(uniqid(rand(), true)), 0, 10);
				$password1 = $this->input->post('password') ? $this->input->post('password') : "";
				$password = $this->my_encrypt($password1, 'e');

				$today1 = date("Ymdhisu");
				$unique = "SAL" . $today1;
				$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
				
				$usr_result = $this->db->query("SELECT * FROM merchant WHERE email='$email'")->row_array();
				// echo $this->db->last_query();die;
				// print_r($usr_result);die;
				
				if(empty($usr_result)) {
					$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
					$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
					$create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') : '0' . "";

					$view_menu_permissions='';
					$view_menu_permissions .=$this->input->post('ViewPermissions') ? $this->input->post('ViewPermissions').',' : "";  
					$view_menu_permissions .=$this->input->post('AddPermissions') ? $this->input->post('AddPermissions').',' : "";  
					$view_menu_permissions .=$this->input->post('EditPermissions') ? $this->input->post('EditPermissions').',' : "";  
					$view_menu_permissions .=$this->input->post('DeletePermissions') ? $this->input->post('DeletePermissions').',' : ""; 
					$view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
					$view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
					$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
					$view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
					$view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
					$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
					$view_menu_permissions .= $this->input->post('VirtualTerminal') ? $this->input->post('VirtualTerminal').',' : "";  
					$view_menu_permissions .= $this->input->post('IInvoicing') ? $this->input->post('IInvoicing').',' : "";  
					$view_menu_permissions .= $this->input->post('IRecurring') ? $this->input->post('IRecurring').',' : "";  
					$view_menu_permissions .= $this->input->post('RInstoreMobile') ? $this->input->post('RInstoreMobile').',' : "";
					$view_menu_permissions .= $this->input->post('RInvoice') ? $this->input->post('RInvoice').',' : "";
					$view_menu_permissions .= $this->input->post('ItemsManagement') ? $this->input->post('ItemsManagement').',' : "";  
					$view_menu_permissions .= $this->input->post('Reports') ? $this->input->post('Reports').',' : "";  
					$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";
					$mid = $this->input->post('merchant_id') ? $this->input->post('merchant_id') : "";
					if(isset($_POST['emp_refund'])) {
    				    $emp_refund = '1';
    				} else {
    				    $emp_refund = '0';
    				}
    				$name = $this->input->post('name') ? $this->input->post('name') : "";
      				$employee_pin = $this->input->post('employee_pin') ? $this->input->post('employee_pin') : "";
					$data = array(
						'name' => $name,
						"email" => $email,
						"password" => $password,
						"merchant_id" => $mid,
						"auth_key" => $unique,
					    "merchant_key" => $merchant_key,
					    'user_type'=>'employee',
						'status' => 'pending_signup',
						'is_token_system_permission' => '1',
						'is_tokenized' => '1',
						'pc_phone' => $pc_phone,
						'wood_forest' => '1',
						'view_permissions' => $view_permissions,
						'edit_permissions' => $edit_permissions,
						'create_pay_permissions' => $create_pay_permissions,
						'view_menu_permissions' => $view_menu_permissions,
						'employee_pin' => $employee_pin,
						'emp_refund' => $emp_refund,
					);

				if ($email) {
					 $this->Home_model->insert_data("merchant", $data);
		             $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Sub User added successfully.  </div>');
                    redirect('dashboard/all_merchant');
				} else {
					$this->session->set_flashdata('error',  '<div class="alert alert-danger text-center">Unauthorized email account. Please try another.</div>');
					redirect('dashboard/all_merchant');	
				}
				
			} else {
					$this->session->set_flashdata('error',  '<div class="alert alert-danger text-center">This email is already registered. Please try another.</div>');
					redirect('dashboard/all_merchant');
		}
				
	}
  	public function create_merchant_old() {
  		// echo '<pre>';print_r($_POST);die;

  		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
		$this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[merchant.mob_no]');
		
		$email = $this->input->post('memail') ? $this->input->post('memail') : "";
		$pc_phone = $this->input->post('primary_phone') ? $this->input->post('primary_phone') : "";

		$password1 = substr(md5(uniqid(rand(), true)), 0, 10);
		$password = $this->my_encrypt($password1, 'e');

		$today1 = date("Ymdhisu");
		$unique = "SAL" . $today1;
		$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
		
		$usr_result = $this->db->query("SELECT * FROM merchant WHERE email='$email'")->row_array();
		// echo $this->db->last_query();die;
		// print_r($usr_result);die;
		
		if(empty($usr_result)) {
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') : '0' . "";

			$view_menu_permissions='';
			$view_menu_permissions .=$this->input->post('ViewPermissions') ? $this->input->post('ViewPermissions').',' : "";  
			$view_menu_permissions .=$this->input->post('AddPermissions') ? $this->input->post('AddPermissions').',' : "";  
			$view_menu_permissions .=$this->input->post('EditPermissions') ? $this->input->post('EditPermissions').',' : "";  
			$view_menu_permissions .=$this->input->post('DeletePermissions') ? $this->input->post('DeletePermissions').',' : ""; 
			$view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
			$view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
			$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
			$view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
			$view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
			$view_menu_permissions .= $this->input->post('VirtualTerminal') ? $this->input->post('VirtualTerminal').',' : "";  
			$view_menu_permissions .= $this->input->post('IInvoicing') ? $this->input->post('IInvoicing').',' : "";  
			$view_menu_permissions .= $this->input->post('IRecurring') ? $this->input->post('IRecurring').',' : "";  
			$view_menu_permissions .= $this->input->post('RInstoreMobile') ? $this->input->post('RInstoreMobile').',' : "";
			$view_menu_permissions .= $this->input->post('RInvoice') ? $this->input->post('RInvoice').',' : "";
			$view_menu_permissions .= $this->input->post('ItemsManagement') ? $this->input->post('ItemsManagement').',' : "";  
			$view_menu_permissions .= $this->input->post('Reports') ? $this->input->post('Reports').',' : "";  
			$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";

			$data = array(
				"email" => $email,
				"password" => $password,
				"auth_key" => $unique,
			    "merchant_key" => $merchant_key,
				'status' => 'pending_signup',
				'is_token_system_permission' => '1',
				'is_tokenized' => '1',
				'pc_phone' => $pc_phone,
				'wood_forest' => '1',
				'view_permissions' => $view_permissions,
				'edit_permissions' => $edit_permissions,
				'create_pay_permissions' => $create_pay_permissions,
				'view_menu_permissions' => $view_menu_permissions,
			);

			if ($email) {
				$last_merchantId = $this->Home_model->insert_data("merchant", $data);

				$ins_merchant_graph = array(
					'id' => NULL,
					'merchant_id' => $last_merchantId
				);
				$this->db->insert('merchant_year_graph', $ins_merchant_graph);
				$this->db->insert('merchant_year_graph_two', $ins_merchant_graph);

				$mail_verify_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890", mt_rand(0, 51), 1) . substr(md5(time()), 1);
				// echo $verify_key;die;

				// $mail_count = $this->db->where('merchant_id', $id)->get('agreement_verification')->num_rows();
				$mail_arr = $this->db->where('merchant_id', $last_merchantId)->get('agreement_verification')->row();
				if(count($mail_arr) > 0) {
					if($mail_arr->verification_status == 'done') {
						$up_mail = array(
							'mail_verify_key' => $mail_verify_key,
							'verification_status' => ''
						);

						$this->db->where('merchant_id', $last_merchantId);
						$this->db->update('agreement_verification', $up_mail);
						
					} else {
						$up_mail = array(
							'mail_verify_key' => $mail_verify_key
						);

						$this->db->where('merchant_id', $last_merchantId);
						$this->db->update('agreement_verification', $up_mail);
					}

				} else {
					$ins_mail = array(
						'mail_verify_key' => $mail_verify_key,
						'merchant_id' => $last_merchantId,
						'verification_status' => ''
					);
					$this->db->insert('agreement_verification', $ins_mail);
				}

				$new_email = strtolower($email);
				// $mail_temp['merchant_id'] = '894';
				// $mail_temp['auth_key'] = 'be63ed6a-69eb-437c-b026-c4a4c4b81ee7';
				$mail_data['url'] = base_url().'Merchant_agreement/verification/'.$last_merchantId.'/'.$mail_verify_key.'/'.$unique;
				// $mail_data['email'] = $new_email;
				$mail_data['business_dba_name'] = $business_dba_name;
				$subject = 'Salequick - Merchant Agreement';
				$mail_temp = $msg = $this->load->view('email/agreement_mail', $mail_data, true);

				// $business_email
				$this->email->from('info@salequick.com', 'Admin - Salequick');
                // $this->email->to('amir.proget@gmail.com');
                $this->email->to($new_email);
                $this->email->subject($subject);
                $this->email->message($mail_temp);
                if($this->email->send()) {
                	$mail_ins_data = array(
                		'admin_id' => 1,
                		'merchant_id' => $last_merchantId
                	);
                	$this->db->insert('agreement_mail_log', $mail_ins_data);
                	$this->session->set_flashdata("success", "Merchant successfully created. Credentials has been sent to your registered email.");
					redirect('dashboard/all_merchant');
                } else {
                	$this->session->set_flashdata("success", "Merchant successfully created. Mail sent error. Please contact admin.");
					redirect('dashboard/all_merchant');
                }

			} else {
				$this->session->set_flashdata("error", "Unauthorized email account. Please try another.");
				redirect('dashboard/add_merchant');
			}
		
		} else {
			$this->session->set_flashdata("error", "This email is already registered. Please try another.");
			redirect('dashboard/add_merchant');
		}
	}

	public function getDigit($merchant_id){

	    $emp_pin=random_int(1000, 9999);
	    // $merchant_id = $this->session->userdata('merchant_id');
		$query=$this->db->query("SELECT employee_pin from merchant where employee_pin=".$emp_pin." and id=".$merchant_id)->result_array();
        // echo $this->db->last_query();die;
        $emp_pinDb=$query[0]['employee_pin'];
        // echo $emp_pinDb;die;
        if($emp_pinDb!=$emp_pin){
            return $emp_pin;
        }
        else{
          $this->getDigit();
        }
  	}		
	public function index_original() {
		// echo '123';die;
		$data["title"] = "Admin Panel";
		$data["meta"] = "Dashboard";
		$merchant_id = $this->session->userdata('merchant_id');
		
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$last_date = date("Y-m-d", strtotime("-29 days"));
		$date = date("Y-m-d");
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$employee = $this->input->post('employee');
		//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
		//$date1 = date("Y-m-d");
		if ($start == 'undefined') {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");

		} elseif ($start != '') {
			$last_date = $start;
			$date = $end;

		} else {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		}
		if ($employee == 'all') {
			$sub_merchant_id = 0;
		} elseif ($employee == 'merchant') {
			$sub_merchant_id = 0;
		} else {
			$sub_merchant_id = $employee;
		}

		$getDashboard = $this->db->query("SELECT 
			(SELECT count(id) as TotalOrders from customer_payment_request where  status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalOrders, 
			(SELECT count(id) as TotalPosorder from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalPosorder,
			(SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalpendingOrders,
			(SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = '" . $date . "') as NewTotalOrders, 
			(SELECT count(id) as TotalPosordernew from pos where date_c = '" . $date . "') as TotalPosordernew,
			(SELECT count(id) as TotalFailOrders from customer_payment_request where (status='declined' ||  status='block') and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalFailOrders, 
			(SELECT count(id) as TotalPosFailorder from pos where (status='declined' ||  status='block') and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalPosFailorder,

            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS");

		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;

		$widgets_data = array(
			'TotalConfirmOrders' => $getDashboardData[0]['TotalOrders']+$getDashboardData[0]['TotalPosorder'],
			'TotalpendingOrders' => $getDashboardData[0]['TotalpendingOrders'], 
			'NewTotalOrders' => $getDashboardData[0]['NewTotalOrders']+$getDashboardData[0]['TotalPosordernew'], 
			'TotalFaildOrders' => $getDashboardData[0]['TotalFailOrders']+$getDashboardData[0]['TotalPosFailorder']
          ); 
		$data['widgets_data'] = $widgets_data;

		$data1 = array();
		// $data['item'] = $this->admin_model->data_get_where_gg($last_date, $date,'confirm',$merchant_id,$employee,'customer_payment_request' );
		$package_data = $this->admin_model->data_get_where_dow("customer_payment_request", $date, $last_date);

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['amount'] = $each->amount;
			$package['tax'] = $each->tax;
			if ($each->type = 'straight') {
				$package['type'] = 'Invoice';
			} else {
				$package['type'] = $each->type;
			}

			$package['date'] = $each->date_c;

			$package['reference'] = $each->reference;

			$mem[] = $package;
		}
		$data['item'] = $mem;

		$data['item1'] = $this->admin_model->data_get_where_dow("recurring_payment", $date, $last_date);
		$data['item2'] = $this->admin_model->data_get_where_dow("pos", $date, $last_date);
		$data['item3'] = json_encode(array_merge($data['item'], $data['item1'], $data['item2']));

		//  $data['highchart'] = $this->admin_model->get_details($merchant_id);
		// echo json_encode($data['highchart']);
		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('admin/dashboard_dash', $data);
			// return $this->load->view('admin/dashboard', $data);
		}
	}
	public function search_record_column_pos_refund() {
    $searchby = $this->input->post('id');
    $row_id = $this->input->post('row_id');
    $pos = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
        $invoice_no=$pos[0]['invoice_no']; 
    $transaction_type=$pos[0]['transaction_type']; 
      
      if ($transaction_type == "split") {
        $getQuery1 = $this->db->query("SELECT c.quantity,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status='2' and c.transaction_id='" . $invoice_no . "'");
        
        } else {
        $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status='2' and p.invoice_no='" . $invoice_no . "'");
        }
        $itemslist = $getQuery1->result_array();
    $data['item'] = $itemslist;
    $data['pay_report'] = $this->admin_model->search_record_pos($searchby);
    // print_r($this->db->last_query());
    // print_r($data['pay_report']);
    //  die('jo');  
    $data['refundData'] = $this->admin_model->get_refund_by_id($row_id);
    // echo $this->load->view('merchant/show_result_pos_refund', $data, true);
    echo $this->load->view('admin/show_result_pos_refund_dash', $data, true);
  }

	public function index() {
		// echo '<pre>';die;
		$data["title"] = "Admin Panel";
		$data["meta"] = "Dashboard";
		$month = date("m");
    	$today2 = date("Y");

    	 $first_date = date('Y-m-01');
         $last_date = date('Y-m-t');

        $stmt=" and merchant_id IN('";
		$wf_merchants=$this->session->userdata('wf_merchants');

		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                $stmt.=$x[$i];
	            }else{
	                $stmt.="','".$x[$i];
	            }
	        
	        }
	        $stmt.="')";

		}else{
			$stmt=' and merchant_id is null ';

		}

        // echo $stmt;die;
    	if($month=='01' ){
         	$amount = $this->db->query("SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where  month = '01' and year = '" . $today2 . "'".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '01' and year = '" . $today2 . "'".$stmt." and status='confirm' )x group by month  ");
 
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(amount) as Totaljanf from ( SELECT month,amount from customer_payment_request where  month = '01' and year = '" . $today2 . "'".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '01' and year = '" . $today2 . "'".$stmt." and status='confirm' )x group by month  ");

         	$getfee = $fee->result_array();


         	$tax = $this->db->query("SELECT sum(tax) as Totaljantax from ( SELECT month,tax from customer_payment_request where   month = '01' and year = '" . $today2 . "'".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '01' and year = '" . $today2 . "'".$stmt." and status='confirm' )x group by month  ");

           	$gettax = $tax->result_array();

           
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totaljan='".!empty($getamount[0]['Totaljan'])."' ,Totaljanf='".!empty($getfee[0]['Totaljanf'])."',Totaljantax='".!empty($gettax[0]['Totaljantax'])."'  ");

 		}

 		 else if($month=='02' ){
               	$amount = $this->db->query("SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where  month = '02' and year = '" . $today2 . "'".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '02' and year = '" . $today2 . "'".$stmt." and status='confirm' )x group by month  ");
          
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(amount) as Totalfebf from ( SELECT month,amount from customer_payment_request where  month = '02' and year = '" . $today2 . "'".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '02' and year = '" . $today2 . "'".$stmt." and status='confirm' )x group by month  ");

         	$getfee = $fee->result_array();


         	$tax = $this->db->query("SELECT sum(tax) as Totalfebtax from ( SELECT month,tax from customer_payment_request where   month = '02' and year = '" . $today2 . "'".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '02' and year = '" . $today2 . "'".$stmt." and status='confirm' )x group by month  ");

           	$gettax = $tax->result_array();

           
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalfeb='".!empty($getamount[0]['Totalfeb'])."' ,Totalfebf='".!empty($getfee[0]['Totalfebf'])."',Totalfebtax='".!empty($gettax[0]['Totalfebtax'])."'  ");

          // echo $this->db->last_query();die;
 }

  else if($month=='03' ){
 	$amount = $this->db->query("SELECT sum(`amount`-`p_ref_amount`) as Totalmarch from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '03' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '03' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");
     
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totalmarchf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '03' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '03' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();


         	$tax = $this->db->query("SELECT sum(tax) as Totalmarchtax from ( SELECT month,tax from customer_payment_request where   month = '03' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '03' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalmarch='".!empty($getamount[0]['Totalmarch'])."' ,Totalmarchf='".!empty($getfee[0]['Totalmarchf'])."',Totalmarchtax='".!empty($gettax[0]['Totalmarchtax'])."'  ");

          // echo $this->db->last_query();die;
 }
  else if($month=='04' ){
 	$amount = $this->db->query("SELECT sum(`amount`-`p_ref_amount`) as Totalaprl from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");
          
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totalaprlf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totalaprltax from ( SELECT month,tax from customer_payment_request where   month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalaprl='".!empty($getamount[0]['Totalaprl'])."' ,Totalaprlf='".!empty($getfee[0]['Totalaprlf'])."',Totalaprltax='".!empty($gettax[0]['Totalaprltax'])."'  ");

 }

   else if($month=='05' ){

//////////////////////////////////////////
   	$amount = $this->db->query("SELECT sum(`amount`) as Totalaprl from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or  status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or  status='Chargeback_Confirm') )x group by month  ");

      		$getamount = $amount->result_array();

      		$date_c1='2022-04-01';
$date_cc1='2022-04-30';
 	$amount_r = $this->db->query("SELECT sum(amount) as RAmountPOS1 from refund  where date_c>='".$date_c1."' and date_c <= '".$date_cc1."'".$stmt."  and   status='confirm'  ");
      	$getamount_r = $amount_r->result_array();
      	$new_amount1 = !empty($getamount[0]['Totalaprl'])-!empty($getamount_r[0]['RAmountPOS1']);


          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totalaprlf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totalaprltax from ( SELECT month,tax from customer_payment_request where   month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '04' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalaprl='".$new_amount1."' ,Totalaprlf='".!empty($getfee[0]['Totalaprlf'])."',Totalaprltax='".!empty($gettax[0]['Totalaprltax'])."'  ");
     ////////////////////////////////////////
           	
 	$amount = $this->db->query("SELECT sum(amount) as Totalmay from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm'  or status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm'  or status='Chargeback_Confirm') )x group by month  ");

 	$getamount = $amount->result_array();

$date_c='2022-05-01';
$date_cc='2022-05-31';
 	$amount_r = $this->db->query("SELECT sum(amount) as RAmountPOS from refund  where date_c>='".$date_c."' and date_c <= '".$date_cc."'".$stmt."  and   status='confirm'  ");
      	$getamount_r = $amount_r->result_array();
      	$new_amount = !empty($getamount[0]['Totalmay'])-!empty($getamount_r[0]['RAmountPOS']);
      


          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totalmayf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totalmaytax from ( SELECT month,tax from customer_payment_request where   month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalmay='".$new_amount."' ,Totalmayf='".!empty($getfee[0]['Totalmayf'])."',Totalmaytax='".!empty($gettax[0]['Totalmaytax'])."'  ");

 }

    else if($month=='06' ){

//////////////////////////////////////////
   
           	
 	$amount = $this->db->query("SELECT sum(amount) as Totalmay from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm'  or status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm'  or status='Chargeback_Confirm') )x group by month  ");

 	$getamount = $amount->result_array();

$date_c='2022-05-01';
$date_cc='2022-05-31';
 	$amount_r = $this->db->query("SELECT sum(amount) as RAmountPOS from refund  where date_c>='".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' ".$stmt." and   status='confirm'  ");
      	$getamount_r = $amount_r->result_array();
      	$new_amount = !empty($getamount[0]['Totalmay'])-!empty($getamount_r[0]['RAmountPOS']);
      


          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totalmayf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '05' and year = '" . $today2 . "'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '05' and year = '" . $today2 . "' ".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totalmaytax from ( SELECT month,tax from customer_payment_request where   month = '05' and year = '" . $today2 . "' ".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '05' and year = '" . $today2 . "' ".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalmay='".$new_amount."' ,Totalmayf='".!empty($getfee[0]['Totalmayf'])."',Totalmaytax='".!empty($gettax[0]['Totalmaytax'])."'  ");

           	////////////////////////////////////////

           		$amount = $this->db->query("SELECT sum(`amount`) as Totaljune from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '06' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or  status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where  month = '06' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or  status='Chargeback_Confirm') )x group by month  ");
          
      		$getamount = $amount->result_array();

        // $date_c1 =date('Y-m-01');
        // $date_cc1 =date('Y-m-t');

        $date_c1='2022-06-01';
$date_cc1='2022-06-30';

 	$amount_r = $this->db->query("SELECT sum(amount) as RAmountPOS1 from refund  where date_c>='".$date_c1."' and date_c <= '".$date_cc1."' and merchant_id!='413' ".$stmt." and   status='confirm'  ");
      	$getamount_r = $amount_r->result_array();
      	$new_amount1 = !empty($getamount[0]['Totaljune'])-!empty($getamount_r[0]['RAmountPOS1']);


          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totaljunef from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '06' and year = '" . $today2 . "' ".$stmt." and merchant_id!='413' and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '06' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totaljunetax from ( SELECT month,tax from customer_payment_request where   month = '06' and year = '" . $today2 . "' ".$stmt." and merchant_id!='413' and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '06' and year = '" . $today2 . "' ".$stmt." and  merchant_id!='413' and (status='confirm' or partial_refund=1) )x group by month  ");
       
           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totaljune='".$new_amount1."' ,Totaljunef='".!empty($getfee[0]['Totaljunef'])."',Totaljunetax='".!empty($gettax[0]['Totaljunetax'])."'  ");
     

 }

 else if($month=='07' ){

    		$amount = $this->db->query("SELECT sum(`amount`) as Totaljuly from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '07' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or  status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where  month = '07' and year = '" . $today2 . "' ".$stmt." and merchant_id!='413' and (status='confirm' or  status='Chargeback_Confirm') )x group by month  ");
          
      		$getamount = $amount->result_array();

        $date_c1 =date('Y-m-01');
        $date_cc1 =date('Y-m-t');

 	$amount_r = $this->db->query("SELECT sum(amount) as RAmountPOS1 from refund  where date_c>='".$date_c1."' and date_c <= '".$date_cc1."' and merchant_id!='413' ".$stmt." and   status='confirm'  ");
      	$getamount_r = $amount_r->result_array();
      	$new_amount1 = !empty($getamount[0]['Totaljuly'])-!empty($getamount_r[0]['RAmountPOS1']);


          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totaljulyf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '07' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '07' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totaljulytax from ( SELECT month,tax from customer_payment_request where   month = '07' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '07' and year = '" . $today2 . "' and merchant_id!='413' ".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totaljuly='".$new_amount1."' ,Totaljulyf='".!empty($getfee[0]['Totaljulyf'])."',Totaljulytax='".!empty($gettax[0]['Totaljulytax'])."'  ");
 }

else if($month=='08' ){

				$amount = $this->db->query("SELECT sum(`amount`) as Totalaugust from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '08' and year = '" . $today2 . "' and merchant_id!='413'".$stmt." and (status='confirm' or  status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where  month = '08' and year = '" . $today2 . "' and merchant_id!='413'".$stmt." and (status='confirm' or  status='Chargeback_Confirm') )x group by month  ");

      		$getamount = $amount->result_array();

        $date_c1 =date('Y-m-01');
        $date_cc1 =date('Y-m-t');

 	$amount_r = $this->db->query("SELECT sum(amount) as RAmountPOS1 from refund  where date_c>='".$date_c1."' and date_c <= '".$date_cc1."' and merchant_id!='413'".$stmt."  and   status='confirm'  ");
      	$getamount_r = $amount_r->result_array();
      	$new_amount1 = !empty($getamount[0]['Totalaugust'])-!empty($getamount_r[0]['RAmountPOS1']);

  
          	$fee = $this->db->query("SELECT avg(`amount`-`p_ref_amount`) as Totalaugustf from ( SELECT month,amount,p_ref_amount from customer_payment_request where  month = '08' and year = '" . $today2 . "' and merchant_id!='413'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,amount,p_ref_amount from pos where  month = '08' and year = '" . $today2 . "' and merchant_id!='413'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");
          		
         	$getfee = $fee->result_array();

         	$tax = $this->db->query("SELECT sum(tax) as Totalaugusttax from ( SELECT month,tax from customer_payment_request where   month = '08' and year = '" . $today2 . "' and merchant_id!='413'".$stmt." and (status='confirm' or partial_refund=1)    union all SELECT month,tax from pos where  month = '08' and year = '" . $today2 . "' and merchant_id!='413'".$stmt." and (status='confirm' or partial_refund=1) )x group by month  ");

           	$gettax = $tax->result_array();

           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalaugust='".$new_amount1."' ,Totalaugustf='".!empty($getfee[0]['Totalaugustf'])."',Totalaugusttax='".!empty($gettax[0]['Totalaugusttax'])."'  ");
           	// echo $this->db->last_query();die;
 }
		else if($month=='09') {
         	$amount = $this->db->query("SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where  month = '09' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '09' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month  ");
// echo $this->db->last_query();die;          
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(amount) as Totalsepf from ( SELECT month,amount from customer_payment_request where month = '09' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '09' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month ");
          		
         	$getfee = $fee->result_array();

           	$tax = $this->db->query("SELECT sum(tax) as Totalseptax from ( SELECT month,tax from customer_payment_request where  month = '09' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '09' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month");

           	$gettax = $tax->result_array();
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalsep='".!empty($getamount[0]['Totalsep'])."' ,Totalsepf='".!empty($getfee[0]['Totalsepf'])."',Totalseptax='".!empty($gettax[0]['Totalseptax'])."'  ");
           	// echo $this->db->last_query();die;

		} else if($month=='10' ) {
         	$amount = $this->db->query("SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month  ");
          
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(amount) as Totaloctf from ( SELECT month,amount from customer_payment_request where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month ");

         	$getfee = $fee->result_array();

           	$tax = $this->db->query("SELECT sum(tax) as Totalocttax from ( SELECT month,tax from customer_payment_request where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month");

           	$gettax = $tax->result_array();
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totaloct='".!empty($getamount[0]['Totaloct'])."' ,Totaloctf='".!empty($getfee[0]['Totaloctf'])."',Totalocttax='".!empty($gettax[0]['Totalocttax'])."'  ");

		} else if($month=='11') {
         	$amount = $this->db->query("SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where  month = '11' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '11' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month  ");
          
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(amount) as Totalnovf from ( SELECT month,amount from customer_payment_request where  month = '11' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '11' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month ");

         	$getfee = $fee->result_array();

           	$tax = $this->db->query("SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request where  month = '11' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '11' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month");

           	$gettax = $tax->result_array();
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalnov='".!empty($getamount[0]['Totalnov'])."' ,Totalnovf='".!empty($getfee[0]['Totalnovf'])."',Totalnovtax='".!empty($gettax[0]['Totalnovtax'])."'  ");
		}

		else if($month=='12'){
	

         $amount = $this->db->query("SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where  month = '12' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '12' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

      print_r($getamount);
      echo $getamount[0]['Totaldec'];

          $fee = $this->db->query("SELECT avg(amount) as Totaldecf from ( SELECT month,amount from customer_payment_request where  month = '12' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '12' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totaldectax from ( SELECT month,tax from customer_payment_request where  month = '12' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '12' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE admin_year_graph_wf SET Totaldec='".!empty($getamount[0]['Totaldec'])."' ,Totaldecf='".!empty($getfee[0]['Totaldecf'])."',Totaldectax='".!empty($gettax[0]['Totaldectax'])."'  ");


}
	 echo $this->db->last_query();die;
		$getSaleByYear = $this->db->query("SELECT * from admin_year_graph_wf order by id desc limit 0,1");
		$getSaleByYearData = $getSaleByYear->result_array();
		$data['getSaleByYearData'] = $getSaleByYearData;
		// echo '<pre>';print_r($data);die;

		$this->load->view('admin/dashboard_dash', $data);
	}

	public function getGraphData() {
		// echo '<pre>';print_r($_POST);die;
		$response = array();
		$user = array();

		// $date_c = $_POST['start'];
		$date_c = date("Y-m-d", strtotime($_POST['start']));
		//$date_cc = date("Y-m-d", strtotime($_POST['end']));
		$date_cc = date('Y-m-d', strtotime($this->input->post('end') . ' +1 day'));
		$employee = $_POST['employee'];
		$merchnat = $_POST['employee'];
		$last_date = date("Y-m-d", strtotime("-30 days"));
		$date = date("Y-m-d");

		$stmtQuery=" and merchant_id IN('";
		$wf_merchants=$this->session->userdata('wf_merchants');

		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                $stmtQuery.=$x[$i];
	            }else{
	                $stmtQuery.="','".$x[$i];
	            }
	        
	        }
	        $stmtQuery.="')";

		}else{
			$stmtQuery=' and merchant_id is null ';

		}

		if ($_POST['employee'] == 'all') {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ".$stmtQuery." and merchant_id!='413'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where date_c > '".$date_c."' and date_c < '".$date_cc."' ".$stmtQuery." and status='confirm'   union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' ".$stmtQuery." and status='confirm' and merchant_id!='413' ) x group by date_c");
			// echo $this->db->last_query();die;

		} elseif ($_POST['employee'] != 'all') {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee)  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee)  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN ($employee)  ) x group by date_c");

		} else {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee)  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from recurring_payment where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id= $employee  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee) ) x group by date_c");
		}
	// echo $this->db->last_query();die;

		if ($stmt->num_rows() > 0) {
			foreach ($stmt->result_array() as $result) {
				$temp = array(
					'date' 				=> $result['date_c'],
					'amount' 			=> $result['amount'],
					'clicks' 			=> !empty($result['tax']) ? $result['tax'] : '0.00',
					'cost' 				=> $result['fee'],
					'tax' 				=> !empty($result['tax']) ? $result['tax'] : '0.00',
					'converted_people'  => !empty($result['tax']) ? $result['tax'] : '0.00',
					'revenue' 			=> !empty($result['tax']) ? $result['tax'] : '0.00',
					'linkcost' 			=> !empty($result['tax']) ? $result['tax'] : '0.00'
				);
				array_push($user, $temp);
			}

		} else {
			$user = array();
			$temp = array(
				'date' 				=> $date_c,
				'amount' 			=> "0",
				'clicks' 			=> "0",
				'cost' 				=> "0",
				'tax' 				=> "0",
				'converted_people' 	=> "0",
				'revenue' 			=> "0",
				'linkcost' 			=> "0"
			);
			array_push($user, $temp);
		}
		$responseData['saleData'] = $user;

		$condition = '';
		if ($employee != 'all') {
			$condition = ' and merchant_id='.$employee;
		}
		$getDashboard = $this->db->query("SELECT 
			(SELECT count(id) as TotalOrders from customer_payment_request where  status='confirm' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "'$condition ".$stmtQuery.") as TotalOrders, 
			(SELECT count(id) as TotalPosorder from pos where status='confirm'  and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "'$condition ".$stmtQuery.") as TotalPosorder,
			(SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "'$condition ".$stmtQuery.") as TotalpendingOrders,
			(SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = '" . $date_cc . "'$condition ".$stmtQuery.") as NewTotalOrders, 
			(SELECT count(id) as TotalPosordernew from pos where date_c = '" . $date_cc . "'$condition ".$stmtQuery.") as TotalPosordernew,
			(SELECT count(id) as TotalFailOrders from customer_payment_request where (status='declined' ||  status='block') and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "'$condition ".$stmtQuery.") as TotalFailOrders, 
			(SELECT count(id) as TotalPosFailorder from pos where (status='declined' ||  status='block') and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "'$condition ".$stmtQuery.") as TotalPosFailorder,

            (SELECT sum(amount) as TotalAmount from customer_payment_request where  merchant_id!='413' and (status='confirm' or  status='Chargeback_Confirm') and payment_type='straight'  and date_c >= '" . $date_c . "' and date_c <= '" . $date . "'$condition ".$stmtQuery.") as TotalAmount ,
            (SELECT sum(amount) as TotalAmountRe from customer_payment_request where  merchant_id!='413' and (status='confirm' or  status='Chargeback_Confirm') and payment_type='recurring' and date_c >= '" . $date_c . "' and date_c <= '" . $date . "'$condition ".$stmtQuery.") as TotalAmountRe ,
            (SELECT sum(amount) as TotalAmountPOS from pos where merchant_id!='413' and (status='confirm' or  status='Chargeback_Confirm')  and date_c >= '" . $date_c . "' and date_c <= '" . $date . "'$condition ".$stmtQuery.") as TotalAmountPOS");
		 
			// echo $this->db->last_query();die;
		$getDashboardData = $getDashboard->result_array();
		$responseData['getDashboardData'] = $getDashboardData;

		$widgets_data = array(
			'TotalConfirmOrders' => $getDashboardData[0]['TotalOrders']+$getDashboardData[0]['TotalPosorder'],
			'TotalpendingOrders' => $getDashboardData[0]['TotalpendingOrders'], 
			'NewTotalOrders' => $getDashboardData[0]['NewTotalOrders']+$getDashboardData[0]['TotalPosordernew'], 
			'TotalFaildOrders' => $getDashboardData[0]['TotalFailOrders']+$getDashboardData[0]['TotalPosFailorder']
          ); 
		$responseData['widgets_data'] = $widgets_data;

		$response = $responseData;
		// echo '<pre>';print_r($response);die;
		echo json_encode($response);
	}

	public function getDashboardSaleByYear() {

	}

	public function getDashboardExportData_old() {
		// echo '<pre>';print_r($_POST);die;
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$last_date = date("Y-m-d", strtotime("-29 days"));
		$date = date("Y-m-d");
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		if(!empty( $this->input->post('employee') )) {
			$employee = $this->input->post('employee');
		}
		if ($start == 'undefined') {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		} elseif ($start != '') {
			$last_date = $start;
			$date = $end;
		} else {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		}

		//$getA_merchantData=$this->admin_model->select_request_id('merchant',$employee); 
		$getA_merchantData->csv_Customer_name=1; //  its static for  admin and subadmin section 

		if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 

		$data1 = array();
		$package_data = $this->admin_model->data_get_where_down_admin("customer_payment_request", $date, $last_date, $employee);
		// echo $this->db->last_query();die;
		  
		$mem = array();
		$member = array();
		$sum = 0;
		$sum_ref = 0;
		$sum_discount=0;
		foreach ($package_data as $each) {
		   	$package['Amount'] = '$' . $each->amount;
		   	$sum += $each->amount;
		   	$package['Tax'] = '$' . $each->tax;
		   	$package['Card'] = Ucfirst($each->card_type);
		   	if ($each->type == 'straight') {
			   	$package['Type'] = 'INV';
		   	} else {
			   	$package['Type'] = $each->type;
		   	}
		   	$package['Date'] = $each->add_date;
		   	$package['Reference'] = $each->reference;
		   	$package['Discount'] =0;
		   	$package['Tip'] =$each->tip;
		  	if($getA_merchantData->csv_Customer_name > 0 ){ $package['Name'] = "--";} 
		   	$package['Items'] =   $each->items;
		   	$sum_discount+=0;
		   	$mem[] = $package;
		}
		$data['item'] = $mem;
		$package_data1 = $this->admin_model->data_get_where_down_admin("recurring_payment", $date, $last_date, $employee);
		$mem1 = array();
		$member1 = array();
		$sum1 = 0;
		$sum_ref1 = 0;
		$sum_discount1=0;
		foreach ($package_data1 as $each) {
			if ($each->status == 'Chargeback_Confirm') {
				$package1['Amount'] = '-$' . $each->amount;
				$sum_ref1 += $each->amount;
			} else {
				$package1['Amount'] = '$' . $each->amount;
				$sum1 += $each->amount;
			}
			$package1['Tax'] = '$' . $each->tax;
			$package1['Card'] = Ucfirst($each->card_type);
			if ($each->type = 'recurring') {
				$package1['Type'] = 'INV';
			} else {
				$package1['Type'] = $each->type;
			}
			$package1['Date'] = $each->add_date;
			$package1['Reference'] = $each->reference;
			$package1['Discount'] =0;
			$package1['Tip'] =0;
			if($getA_merchantData->csv_Customer_name > 0 ){ $package1['Name'] = "--";} 
			$package1['Items'] =   $each->items;
			$sum_discount1+=0;
			$mem1[] = $package1;
		}
		$data['item1'] = $mem1;
		$package_data2 = $this->admin_model->data_get_where_down_admin("pos", $date, $last_date, $employee);
		$mem2 = array();
		$member2 = array();
		$sum2 = 0;
		$sum_ref2 = 0;
		$sum_discount2=0;
		$sum_tip=0;

		foreach ($package_data2 as $each) {
			$package2['Amount'] = '$' . $each->amount;
			$sum2 += $each->amount;
			$package2['Tax'] = '$' . $each->tax;
			$package2['Tip'] = '$' . $each->tip;
			$package2['Card'] = Ucfirst($each->card_type);
			$package2['Type'] = strtoupper($each->type);
			$package2['Date'] = $each->add_date;
			$package2['Reference'] = $each->reference;
			$package2['Discount'] = $each->discount; 
			$sum_discount2+=number_format($each->discount);
			$sum_tip= number_format(($sum_tip + $each->tip),2);
			if($getA_merchantData->csv_Customer_name > 0 ){ $package2['Name'] = $each->name;} 
			$package2['Items'] = $each->items;
			$mem2[] = $package2;
		}
	 	$data['item2'] = $mem2;
		$package_data3 = $this->admin_model->get_refund_data_admin($date, $last_date, $employee);
		$mem3 = array();
		$member3 = array();
		$sum3 = 0;
		$sum_ref3 = 0;
		$sum_discount3=0;
		$tip_refunded=0;
		foreach ($package_data3 as $each) {
			if ($each->status == 'Chargeback_Confirm') {
			    $refund_amount = (!empty($each->refund_amount)?$each->refund_amount:$each->amount);
				$refund['Amount'] = '-$' .$refund_amount;
				$refund['Tax'] = '$' . $each->tax;
				$refund['Tip'] = '-$' . $each->tip_amount;
				$refund['Card'] = Ucfirst($each->card_type);
				if($each->type == 'straight') {
					$refund['Type'] = 'INV-Refunded';
				} else {
					$refund['Type'] = strtoupper($each->type)."-Refunded";
				}
				$refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
				$refund['Reference'] = $each->reference;
				$refund['Discount'] ='0';
				if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
				$refund['Items'] =  '--';
				$mem3[] = $refund;
				$sum_ref3 += $refund_amount;//$each->refund_amount;
				$tip_refunded += $each->tip_amount;
				$sum_discount3+=0;
			}
		}
	   	$data['item_refund'] = $mem3;

		$totalDiscountsum = number_format($sum_discount + $sum_discount1 + $sum_discount2+$sum_discount3, 2);
		$totalsum = number_format($sum + $sum1 + $sum2, 2);
		$totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
	 	if($getA_merchantData->csv_Customer_name > 0) {
			$data['item4'] = [
				[
					"Amount" => "",
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Sum Amount = $ " . $totalsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Refund Amount = $ " . $totalsumr,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				]
			];

		} else {
			$data['item4'] = [
				[
					"Amount" => "",
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Sum Amount = $ " . $totalsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Refund Amount = $ " . $totalsumr,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				]
			];
		}
	   	
		$data['item5'] = [
			[
				"Sum_Amount" => $totalsum,
				"is_Customer_name"=>$getA_merchantData->csv_Customer_name,
				"Refund_Amount" => $totalsumr,
				"Total_Amount" => number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
				"Total_Discount_Amount"=>$totalDiscountsum
			]
		];
		$arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']);
		 array_multisort(array_map('strtotime',array_column($arr,'Date')),SORT_DESC, $arr);
	   
		$data['item3']=json_encode(array_merge($arr, $data['item4']));
		$data['item5']=json_encode($data['item5']);

		echo json_encode($data);die;
	}

	public function getDashboardExportData() {
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$employee = $this->input->post('employee');
		$stmtQuery="";
		
		$wf_merchants=$this->session->userdata('wf_merchants');
		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                // $stmt.=$this->db->where('merchant_id', $x[$i]);
	                $stmtQuery.=" and (r.merchant_id=".$x[$i];
	            }else{
	                $stmtQuery.=" or r.merchant_id=".$x[$i];
	            }
	        
	        }
	        $stmtQuery.=")";
	    }else{
			$stmtQuery=' and r.merchant_id is null ';
		}

		if ($employee == 'all') {
			$stmt = $this->db->query("SELECT (select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$start."' and r.date_c <= '".$end."' and  p.status='Chargeback_Confirm' ".$stmtQuery.")  As RAmountPOS, (select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$start."' and r.date_c <= '".$end."' and  p.status='Chargeback_Confirm' ".$stmtQuery." ) As RAmountCPR");
				// echo $this->db->last_query();die;
		} else {
			$stmt = $this->db->query("SELECT (select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and p.status='Chargeback_Confirm' and r.merchant_id= $employee) As RAmountPOS, (select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and  p.status='Chargeback_Confirm' and r.merchant_id= $employee) As RAmountCPR");
				// echo $this->db->last_query();die;
		}
		$result_ref = $stmt->result_array();
		// echo $this->db->last_query();die;
		// echo '<pre>';print_r($result_ref);die;

		$sumAmtInv = 0;
		$sumDiscInv = 0;
		$sumAmtPOS = 0;
		$sumDiscPOS = 0;
		$sumAmtInvRef = 0;
		$sumAmtPOSRef = 0;
		$sumDiscInvRef = 0;
		$sumDiscPOSRef = 0;
		$sumTipInv = 0;
		$sumTipPOS = 0;
		$sumTipInvRef = 0;
		$sumTipPOSRef = 0;

		$stmtQuery="";
		$wf_merchants=$this->session->userdata('wf_merchants');
		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                // $stmt.=$this->db->where('merchant_id', $x[$i]);
	                $stmtQuery.=" and (merchant_id=".$x[$i];
	            }else{
	                $stmtQuery.=" or merchant_id=".$x[$i];
	            }
	        
	        }
	        $stmtQuery.=")";
	    }else{
			$stmtQuery=' and merchant_id is null ';
		}
		$ArrInv = $this->db->query("SELECT amount, tax, card_type, tip_amount, type, add_date, reference, status from customer_payment_request where date_c >= '".$start."' and date_c <= '".$end."' ".$stmtQuery." and status='confirm'")->result_array();
		
		// echo '<pre>';print_r($invArr);die;
		if(!empty($ArrInv)) {
			foreach ($ArrInv as $inv) {
			   	$package1['Amount'] = '$'.$inv['amount'];
			   	$sumAmtInv += $inv['amount'];
			   	$package1['Tax'] = '$'.$inv['tax'];
			   	$package1['Tip'] = '$'.$inv['tip_amount'];
			   	$sumTipInv += $inv['tip_amount'];
			   	$package1['Card'] = Ucfirst($inv['card_type']);
			   	if ($inv['type'] == 'straight') {
				   	$package1['Type'] = 'INV';
			   	} else {
				   	$package1['Type'] = $inv['type'];
			   	}
			   	$package1['Date'] = $inv['add_date'];
			   	$package1['Reference'] = $inv['reference'];
			   	$package1['Discount'] = 0;
			   	$package1['Name'] = '--';
			  	// if($getA_merchantData->csv_Customer_name > 0 ){ $package1['Name'] = "--";} 
			   	// $package1['Items'] = $inv['items'];
			   	$sumDiscInv+=0;
			   	$invPackage[] = $package1;
			}
		} else {
			$invPackage[] = [];
		}
		$data['item'] = $invPackage;
		// echo '<pre>';print_r($invPackage);die;

		$ArrPOS = $this->db->query("SELECT amount, tax, card_type, tip_amount, type, add_date, reference, status from pos where date_c >= '".$start."' and date_c <= '".$end."' ".$stmtQuery." and status='confirm'")->result_array();
		// echo $this->db->last_query();die;
		if(!empty($ArrPOS)) {
			foreach ($ArrPOS as $inv) {
			   	$package2['Amount'] = '$'.$inv['amount'];
			   	$sumAmtPOS += $inv['amount'];
			   	$package2['Tax'] = '$'.$inv['tax'];
			   	$package2['Tip'] = '$'.$inv['tip_amount'];
			   	$sumTipPOS += $inv['tip_amount'];
			   	$package2['Card'] = Ucfirst($inv['card_type']);
			   	if ($inv['type'] == 'straight') {
				   	$package2['Type'] = 'INV';
			   	} else {
				   	$package2['Type'] = $inv['type'];
			   	}
			   	$package2['Date'] = $inv['add_date'];
			   	$package2['Reference'] = $inv['reference'];
			   	$package2['Discount'] = 0;
			   	$package2['Name'] = '--';
			  	// if($getA_merchantData->csv_Customer_name > 0 ){ $package2['Name'] = "--";} 
			   	// $package2['Items'] = $inv['items'];
			   	$sumDiscPOS+=0;
			   	$POSPackage[] = $package2;
			}
		} else {
			$POSPackage[] = [];
		}
		$data['item1'] = $POSPackage;

		$ArrInvRef = $this->db->query("SELECT amount, tax, card_type, tip_amount, type, add_date, reference, status from customer_payment_request where date_c >= '".$start."' and date_c <= '".$end."' ".$stmtQuery." and status='Chargeback_Confirm'")->result_array();
		
		// echo '<pre>';print_r($ArrInvRef);die;
		if(!empty($ArrInvRef)) {
			foreach ($ArrInvRef as $inv) {
			   	$package3['Amount'] = '$'.$inv['amount'];
			   	$sumAmtInvRef += $inv['amount'];
			   	$package3['Tax'] = '$'.$inv['tax'];
			   	$package3['Tip'] = '$'.$inv['tip_amount'];
			   	$sumTipInvRef += $inv['tip_amount'];
			   	$package3['Card'] = Ucfirst($inv['card_type']);
			   	if ($inv['type'] == 'straight') {
				   	$package3['Type'] = 'INV';
			   	} else {
				   	$package3['Type'] = $inv['type'];
			   	}
			   	$package3['Date'] = $inv['add_date'];
			   	$package3['Reference'] = $inv['reference'];
			   	$package3['Discount'] = 0;
			   	$package3['Name'] = '--';
			  	// if($getA_merchantData->csv_Customer_name > 0 ){ $package3['Name'] = "--";} 
			   	// $package3['Items'] = $inv['items'];
			   	$sumDiscInvRef+=0;
			   	$invPackageRef[] = $package3;
			}
		} else {
			$invPackageRef[] = [];
		}
		$data['item2'] = $invPackageRef;
		// echo '<pre>';print_r($invPackageRef);die;

		$ArrPOSREf = $this->db->query("SELECT amount, tax, card_type, tip_amount, type, add_date, reference, status from pos where date_c >= '".$start."' and date_c <= '".$end."' ".$stmtQuery." and status='Chargeback_Confirm'")->result_array();
		
		if(!empty($ArrPOSREf)) {
			foreach ($ArrPOSREf as $inv) {
			   	$package4['Amount'] = '$'.$inv['amount'];
			   	$sumAmtPOSRef += $inv['amount'];
			   	$package4['Tax'] = '$'.$inv['tax'];
			   	$package4['Tip'] = '$'.$inv['tip_amount'];
			   	$sumTipPOSRef += $inv['tip_amount'];
			   	$package4['Card'] = Ucfirst($inv['card_type']);
			   	if ($inv['type'] == 'straight') {
				   	$package4['Type'] = 'INV';
			   	} else {
				   	$package4['Type'] = $inv['type'];
			   	}
			   	$package4['Date'] = $inv['add_date'];
			   	$package4['Reference'] = $inv['reference'];
			   	$package4['Discount'] = 0;
			   	$package4['Name'] = '--';
			  	// if($getA_merchantData->csv_Customer_name > 0 ){ $package4['Name'] = "--";} 
			   	// $package4['Items'] = $inv['items'];
			   	$sumDiscPOSRef+=0;
			   	$POSPackageRef[] = $package4;
			}
		} else {
			$POSPackageRef[] = [];
		}
		$data['item_refund'] = $POSPackageRef;

		$totalAmount = $sumAmtInv + $sumAmtPOS;
		$totalAmtRefund = $result_ref[0]['RAmountPOS'] + $result_ref[0]['RAmountCPR'];

		$totalTip = $sumTipInv + $sumTipPOS;
		$totalTipRef = $sumTipInvRef + $sumTipPOSRef;

		$data['item4'] = [
			[
				"Amount" => "",
				"Tax" => '',
				"Tip" => '',
				"Card" => '',
				"Type" => '',
				"Date" => '',
				"Reference" => '',
				"Discount"=>'',
				"Name"=>'',
				"Items" => '',
			],
			[
				"Amount" => "Refund Amount = $ " . number_format($totalAmtRefund, 2),
				"Tax" => '',
				"Tip" => '',
				"Card" => '',
				"Type" => '',
				"Date" => '',
				"Reference" => '',
				"Discount"=>'',
				"Name"=>'',
				"Items" => '',
			],
			[
				"Amount" => "Sum Amount = $ " . number_format($totalAmount, 2),
				"Tax" => '',
				"Tip" => '',
				"Card" => '',
				"Type" => '',
				"Date" => '',
				"Reference" => '',
				"Discount"=>'',
				"Name"=>'',
				"Items" => '',
			],
			[
				"Amount" => "Total Amount = $ " . number_format($totalAmount, 2),
				"Tax" => '',
				"Tip" => '',
				"Card" => '',
				"Type" => '',
				"Date" => '',
				"Reference" => '',
				"Discount"=>'',
				"Name"=>'',
				"Items" => '',
			],
			[
				"Amount" => "Total Tip Amount = $ " . number_format($totalTip-$totalTipRef,2),
				"Tax" => '',
				"Tip" => '',
				"Card" => '',
				"Type" => '',
				"Date" => '',
				"Reference" => '',
				"Discount"=>'',
				"Name"=>'',
				"Items" => '',
			]
		];

		$data['item5'] = [
			[
				"Sum_Amount" => 1,
				"is_Customer_name" => 1,
				"Refund_Amount" => 1,
				"Total_Amount" => 1,
				"Total_Discount_Amount"=>1
			]
		];

		$arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']);
		// echo '<pre>';print_r($arr);die;
		// array_multisort(array_map('strtotime',array_column($arr,'Date')),SORT_DESC, $arr);

		$data['item3'] = json_encode(array_merge($arr, $data['item4']));
		$data['item5'] = json_encode($data['item5']);

		echo json_encode($data);die;
	}

    	public function index1() {
    		// echo '<pre>';print_r($_POST);die;
			$data["title"] = "Admin Panel";
			$today2 = date("Y");
			$last_year = date("Y", strtotime("-1 year"));
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			if(!empty($this->input->post('emplo')) ) { $employee=$this->input->post('emplo'); }else{ $employee = $this->input->post('employee');  }
			//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
			//$date1 = date("Y-m-d");
			if ($start == 'undefined') {
				$last_date = date("Y-m-d", strtotime("-29 days"));
				$date = date("Y-m-d");
			} elseif ($start != '') {
				$last_date = $start;
				$date = $end;
			} else {
				$last_date = date("Y-m-d", strtotime("-29 days"));
				$date = date("Y-m-d");
			}
		
			if ($employee == 'all') {
				$getDashboard = $this->db->query("SELECT
	              (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
	              (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
	              (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
				 "); 
	          $DashboardCountData = $this->db->query("SELECT 
	             ( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalOrders, 
				 ( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalPosorder ,
				 ( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  status='pending'  ) as TotalpendingOrders,
				 ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND date_c = CURDATE()) as NewTotalOrders, 
				 ( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  date_c = CURDATE()) as TotalPosordernew ,
	             ( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				 ( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
						 "); 

			} elseif ($employee == 'merchant') {
				$getDashboard = $this->db->query("SELECT
	              (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
	              (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
	              (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
				 ");
				 $DashboardCountData = $this->db->query("SELECT 
	             ( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalOrders, 
				 ( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalPosorder ,
				 ( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  status='pending'  ) as TotalpendingOrders,
				 ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND date_c = CURDATE()) as NewTotalOrders, 
				 ( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  date_c = CURDATE()) as TotalPosordernew ,
	             ( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				 ( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
						 "); 

			} else {
				$getDashboard = $this->db->query("SELECT
	              (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' and merchant_id='" . $employee . "'  ) as TotalAmount ,
	              (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' and merchant_id='" . $employee . "') as TotalAmountRe ,
	              (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' and merchant_id='" . $employee . "') as TotalAmountPOS
				 ");
				$DashboardCountData = $this->db->query("SELECT 
				( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND status='confirm'  ) as TotalOrders, 
				( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "' AND status='confirm'  ) as TotalPosorder ,
				( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND  status='pending'  ) as TotalpendingOrders,
				( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND date_c = CURDATE()) as NewTotalOrders, 
				( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND  date_c = CURDATE()) as TotalPosordernew ,
				( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "' AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  AND merchant_id='" . $employee . "' AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
						");
			}
	        //    echo $this->db->last_query(); die('Die'); 
			$getDashboardData = $getDashboard->result_array();
			$data['getDashboardData'] = $getDashboardData;
			$DashboardCountData=$DashboardCountData->result_array();
			// print_r($DashboardCountData);  die('Die'); 
	       //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
		    $widgets_data = array(
			'TotalConfirmOrders'=>$DashboardCountData[0]['TotalOrders']+$DashboardCountData[0]['TotalPosorder'],
			'TotalpendingOrders'=>$DashboardCountData[0]['TotalpendingOrders'], 
			'NewTotalOrders'=>$DashboardCountData[0]['NewTotalOrders']+$DashboardCountData[0]['TotalPosordernew'], 
			'TotalFaildOrders' => $DashboardCountData[0]['TotalFailOrders']+$DashboardCountData[0]['TotalPosFailorder'],
	          ); 
			$data['widgets_data'] = $widgets_data;
		

			//$getA_merchantData=$this->admin_model->select_request_id('merchant',$employee); 
			$getA_merchantData->csv_Customer_name=1; //  its static for  admin and subadmin section 

		   if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 

		   $data1 = array();
		   $package_data = $this->admin_model->data_get_where_down_admin("customer_payment_request", $date, $last_date, $employee);
		  
		   $mem = array();
		   $member = array();
		   $sum = 0;
		   $sum_ref = 0;
		   $sum_discount=0;
		   foreach ($package_data as $each) {
			   $package['Amount'] = '$' . $each->amount;
			   $sum += $each->amount;
			   $package['Tax'] = '$' . $each->tax;
			   $package['Card'] = Ucfirst($each->card_type);
			   if ($each->type == 'straight') {
				   $package['Type'] = 'INV';
			   } else {
				   $package['Type'] = $each->type;
			   }
			   $package['Date'] = $each->add_date;
			   $package['Reference'] = $each->reference;
			   $package['Discount'] =0;
			   $package['Tip'] =$each->tip;
			  if($getA_merchantData->csv_Customer_name > 0 ){ $package['Name'] = "--";} 
			   $package['Items'] =   $each->items;
			   $sum_discount+=0;
			   $mem[] = $package;
			   // if ($each->status == 'Chargeback_Confirm') {
			   // 	$refund['Amount'] = '-$' . $each->amount;
			   // 	$refund['Tax'] = '$' . $each->tax;
			   // 	$refund['Card'] = Ucfirst($each->card_type);
			   // 	if ($each->type == 'straight') {
			   // 		$refund['Type'] = 'INV-Refunded';
			   // 	} else {
			   // 		$refund['Type'] = $each->type . "-Refunded";
			   // 	}
			   // 	$refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
			   // 	$refund['Reference'] = $each->reference;
			   // 	$mem[] = $refund;
			   // 	$sum_ref += $each->amount;
			   // }
		   }
		   $data['item'] = $mem;
		   $package_data1 = $this->admin_model->data_get_where_down_admin("recurring_payment", $date, $last_date, $employee);
		   $mem1 = array();
		   $member1 = array();
		   $sum1 = 0;
		   $sum_ref1 = 0;
		   $sum_discount1=0;
		   foreach ($package_data1 as $each) {
			   if ($each->status == 'Chargeback_Confirm') {
				   $package1['Amount'] = '-$' . $each->amount;
				   $sum_ref1 += $each->amount;
			   } else {
				   $package1['Amount'] = '$' . $each->amount;
				   $sum1 += $each->amount;
			   }
			   $package1['Tax'] = '$' . $each->tax;
			   $package1['Card'] = Ucfirst($each->card_type);
			   if ($each->type = 'recurring') {
				   $package1['Type'] = 'INV';
			   } else {
				   $package1['Type'] = $each->type;
			   }
			   $package1['Date'] = $each->add_date;
			   $package1['Reference'] = $each->reference;
			   $package1['Discount'] =0;
			    $package1['Tip'] =0;
			   if($getA_merchantData->csv_Customer_name > 0 ){ $package1['Name'] = "--";} 
			   $package1['Items'] =   $each->items;
			   $sum_discount1+=0;
			   $mem1[] = $package1;
		   }
		   $data['item1'] = $mem1;
		   $package_data2 = $this->admin_model->data_get_where_down_admin("pos", $date, $last_date, $employee);
		   $mem2 = array();
		   $member2 = array();
		   $sum2 = 0;
		   $sum_ref2 = 0;
		   $sum_discount2=0;
		   $sum_tip=0;
		   foreach ($package_data2 as $each) {

			   $package2['Amount'] = '$' . $each->amount;
			   $sum2 += $each->amount;
			   $package2['Tax'] = '$' . $each->tax;
			   $package2['Tip'] = '$' . $each->tip;
			   $package2['Card'] = Ucfirst($each->card_type);
			   $package2['Type'] = strtoupper($each->type);
			   $package2['Date'] = $each->add_date;
			   $package2['Reference'] = $each->reference;
			   $package2['Discount'] = $each->discount; 
			   $sum_discount2+=number_format($each->discount);
			   $sum_tip= number_format(($sum_tip + $each->tip),2);
			   if($getA_merchantData->csv_Customer_name > 0 ){ $package2['Name'] = $each->name;} 
			   $package2['Items'] = $each->items;
			   $mem2[] = $package2;
			   // if ($each->status == 'Chargeback_Confirm') {
			   // 	$refund['Amount'] = '-$' . $each->amount;
			   // 	$refund['Tax'] = '$' . $each->tax;
			   // 	$refund['Card'] = Ucfirst($each->card_type);
			   // 	$refund['Type'] = strtoupper($each->type) . "-Refunded";
			   // 	$refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
			   // 	$refund['Reference'] = $each->reference;
			   // 	$mem2[] = $refund;
			   // 	$sum_ref2 += $each->amount;
			   // }
		   }
	   		$data['item2'] = $mem2;
	  		// print_r($mem2);  die; 
     		// for refund
		   $package_data3 = $this->admin_model->get_refund_data_admin($date, $last_date, $employee);
		   $mem3 = array();
		   $member3 = array();
		   $sum3 = 0;
		   $sum_ref3 = 0;
		   $sum_discount3=0;
		   $tip_refunded=0;
		   foreach ($package_data3 as $each) {
			   if ($each->status == 'Chargeback_Confirm') {
			       $refund_amount = (!empty($each->refund_amount)?$each->refund_amount:$each->amount);
				   $refund['Amount'] = '-$' .$refund_amount;
				   $refund['Tax'] = '$' . $each->tax;
				   $refund['Tip'] = '-$' . $each->tip_amount;
				   $refund['Card'] = Ucfirst($each->card_type);
				   if($each->type == 'straight') {
					   $refund['Type'] = 'INV-Refunded';
				   } else {
					   $refund['Type'] = strtoupper($each->type)."-Refunded";
				   }
				   $refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
				   $refund['Reference'] = $each->reference;
				   $refund['Discount'] ='0';
				   if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
				   $refund['Items'] =  '--';
				   $mem3[] = $refund;
				   $sum_ref3 += $refund_amount;//$each->refund_amount;
				   $tip_refunded += $each->tip_amount;
				   $sum_discount3+=0;
				   
			   }
		   }

	   		$data['item_refund'] = $mem3;


		   $totalDiscountsum = number_format($sum_discount + $sum_discount1 + $sum_discount2+$sum_discount3, 2);
		   $totalsum = number_format($sum + $sum1 + $sum2, 2);
		   $totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
	   		if($getA_merchantData->csv_Customer_name > 0 ){ 
				$data['item4'] = [
					[
						"Amount" => "",
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
					[
						"Amount" => "Sum Amount = $ " . $totalsum,
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
		
					[
						"Amount" => "Refund Amount = $ " . $totalsumr,
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
					[
						"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
						[
						"Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2),
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
					[
						"Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					]
				];
			}
			else
			{
			$data['item4'] = [
				[
					"Amount" => "",
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Sum Amount = $ " . $totalsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
	 
				[
					"Amount" => "Refund Amount = $ " . $totalsumr,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Items" => '',
				],
					[
						"Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2),
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
				[
					"Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				]
			];
		}
	   
		$data['item5'] = [
			[
				"Sum_Amount" => $totalsum,
				"is_Customer_name"=>$getA_merchantData->csv_Customer_name,
				"Refund_Amount" => $totalsumr,
				"Total_Amount" => number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
				"Total_Discount_Amount"=>$totalDiscountsum
			]
		];
		$arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']);
		 array_multisort(array_map('strtotime',array_column($arr,'Date')),SORT_DESC, $arr);
		// array_multisort(array_column($arr, 'Date'), SORT_DESC, $arr);    
	   
		$data['item3']=json_encode(array_merge($arr, $data['item4']));  
	   // $data['item3']=json_encode($data['item']);
		$data['item5']=json_encode($data['item5']);

		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('admin/dashboard', $data);
		}
	}

	function my_encrypt($string, $action = 'e') {
		// you may change these values to your own
		$secret_key = '1@#$%^&s6*';
		$secret_iv = '`~ @hg(n5%';
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'e') {
			$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
		} else if ($action == 'd') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	public function create_th() {
		$dataResponse = array();
	    // print_r($_POST); die;  
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
		$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
		$this->form_validation->set_rules('chkstatus[]', 'Merchant Assign', 'required');
		$this->form_validation->set_rules('Settings', 'Settings', 'required');

		$email = $this->input->post('email') ? $this->input->post('email') : "";
		$name = $this->input->post('name') ? $this->input->post('name') : "";
		$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
		$status = $this->input->post('status') ? $this->input->post('status') : "block";

		$view_menu_permissions='';
        $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
        $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
		$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
		$view_menu_permissions .=$this->input->post('Funding') ? $this->input->post('Funding').',' : "";  
		
        $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
        $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
		$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
		$view_menu_permissions .= $this->input->post('TRecurringRequest') ? $this->input->post('TRecurringRequest').',' : "";
		
		$view_menu_permissions .= $this->input->post('InvoiceTemplate') ? $this->input->post('InvoiceTemplate').',' : "";  
        $view_menu_permissions .= $this->input->post('Instore_MobileTemplate') ? $this->input->post('Instore_MobileTemplate').',' : "";  
		$view_menu_permissions .= $this->input->post('ReceiptTemplate') ? $this->input->post('ReceiptTemplate').',' : "";  
		$view_menu_permissions .= $this->input->post('RecurringTemplate') ? $this->input->post('RecurringTemplate').',' : "";
		$view_menu_permissions .= $this->input->post('RegistrationTemplate') ? $this->input->post('RegistrationTemplate').',' : "";

        $view_menu_permissions .= $this->input->post('Vie_Merchant') ? $this->input->post('Vie_Merchant').',' : "";  
		$view_menu_permissions .= $this->input->post('ViewSubuser') ? $this->input->post('ViewSubuser').',' : "";  
		
        $view_menu_permissions .= $this->input->post('SupportsRequest') ? $this->input->post('SupportsRequest').',' : "";  
		$view_menu_permissions .= $this->input->post('SaleRequest') ? $this->input->post('SaleRequest').',' : ""; 
		
		$view_menu_permissions .= $this->input->post('CreateSubadmin') ? $this->input->post('CreateSubadmin').',' : "";  
		$view_menu_permissions .= $this->input->post('ViewAllSubadmin') ? $this->input->post('ViewAllSubadmin').',' : ""; 
		
		$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : ""; 

		$chkstatus = $_POST['chkstatus'] ? $_POST['chkstatus'] : array();
		
		$password1 = $this->input->post('password') ? $this->input->post('password') : "";
		$password = $this->my_encrypt($password1, 'e');

		if(count($chkstatus) > 0) {
           	$assignMerchant=implode(',',$chkstatus);
		} else {
			$assignMerchant='';
		}
		//echo  $assignMerchant; die; 
		$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
		$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
		$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
		$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

		if ($this->form_validation->run() == FALSE) {
			$dataResponse['status'] = '500';
			$dataResponse['message'] = validation_errors(); 
			//$this->load->view("admin/add_subadmin", $data);
		} else {
			$today1 = date("Ymdhms");
			$today2 = date("Y-m-d");
			$unique = "OH" . $today1;
			$data = Array(
				'name' => $name,
				'email' => $email,
				'mob_no' => $mobile,
				'password' => ($password),
				'assign_merchant'=>$assignMerchant,
				'view_permissions' => $view_permissions,
				'view_menu_permissions'=>$view_menu_permissions,
				'edit_permissions' => $edit_permissions,
				'delete_permissions' => $delete_permissions,
				'active_permissions' => $active_permissions,
				'status' => $status
			);
			$id = $this->admin_model->insert_data("sub_admin", $data);
			//echo $this->db->last_query(); die; 
            $dataResponse['status'] = '200';
			$dataResponse['message'] = 'added';
			//redirect("dashboard/all_subadmin");
		}
		echo json_encode($dataResponse);die;
	}

	public function create_agent() {
	    // echo '<pre>';print_r($_POST); die;
	    $dataResponse = array();
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
		$this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[sub_admin.mob_no]');
		$this->form_validation->set_rules('chkstatus[]', 'Merchant Assign', 'required');
		$this->form_validation->set_rules('Settings', 'Settings', 'required');

		$this->form_validation->set_rules('ssn', 'Social Security No', 'required');
		$this->form_validation->set_rules('ein_no', 'EIN No', 'required');
		$this->form_validation->set_rules('total_commission', 'Sign Up Bonus', 'required');
		$this->form_validation->set_rules('commission_p_merchant', 'Profit Share', 'required');
		$this->form_validation->set_rules('commission_p_transaction', 'Gateway Fee (Per Merchant)', 'required');
		$this->form_validation->set_rules('buy_rent', 'Buy Rate (Per Transaction)', 'required');
		$this->form_validation->set_rules('buyrate_volume', 'Buy Rate Volume', 'required');

		// $this->form_validation->set_rules('password', 'Password', 'required');
		// $this->form_validation->set_rules('cpsw', 'Confirm Password', 'required');

		$name = $this->input->post('name') ? $this->input->post('name') : "";
		$last_name = $this->input->post('last_name') ? $this->input->post('last_name') : "";
		$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
		$email = $this->input->post('email') ? $this->input->post('email') : "";

		$address = $this->input->post('address') ? $this->input->post('address') : "";
		$city = $this->input->post('city') ? $this->input->post('city') : "";
		$state = $this->input->post('state') ? $this->input->post('state') : "";
		$zip_code = $this->input->post('zip_code') ? $this->input->post('zip_code') : "";
		// $status = $this->input->post('status') ? $this->input->post('status') : "block";

		$ssn = $this->input->post('ssn') ? $this->input->post('ssn') : "";
		$ein_no = $this->input->post('ein_no') ? $this->input->post('ein_no') : "";
		$total_commission = $this->input->post('total_commission') ? $this->input->post('total_commission') : "";
		$commission_p_merchant = $this->input->post('commission_p_merchant') ? $this->input->post('commission_p_merchant') : "";
		$commission_p_transaction = $this->input->post('commission_p_transaction') ? $this->input->post('commission_p_transaction') : "";
		$buy_rent = $this->input->post('buy_rent') ? $this->input->post('buy_rent') : "";
		$buyrate_volume = $this->input->post('buyrate_volume') ? $this->input->post('buyrate_volume') : "";

		// $npsw = $this->input->post('password') ? trim($this->input->post('password')) : "";
        // $cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";

		$view_menu_permissions='';
        $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
        $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
		$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
		$view_menu_permissions .=$this->input->post('Funding') ? $this->input->post('Funding').',' : "";  
		
        $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
        $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
		$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
		$view_menu_permissions .= $this->input->post('TRecurringRequest') ? $this->input->post('TRecurringRequest').',' : "";
		
		$view_menu_permissions .= $this->input->post('InvoiceTemplate') ? $this->input->post('InvoiceTemplate').',' : "";  
        $view_menu_permissions .= $this->input->post('Instore_MobileTemplate') ? $this->input->post('Instore_MobileTemplate').',' : "";  
		$view_menu_permissions .= $this->input->post('ReceiptTemplate') ? $this->input->post('ReceiptTemplate').',' : "";  
		$view_menu_permissions .= $this->input->post('RecurringTemplate') ? $this->input->post('RecurringTemplate').',' : "";
		$view_menu_permissions .= $this->input->post('RegistrationTemplate') ? $this->input->post('RegistrationTemplate').',' : "";
		
        $view_menu_permissions .= $this->input->post('Vie_Merchant') ? $this->input->post('Vie_Merchant').',' : "";  
		$view_menu_permissions .= $this->input->post('ViewSubuser') ? $this->input->post('ViewSubuser').',' : "";  
		
        $view_menu_permissions .= $this->input->post('SupportsRequest') ? $this->input->post('SupportsRequest').',' : "";  
		$view_menu_permissions .= $this->input->post('SaleRequest') ? $this->input->post('SaleRequest').',' : ""; 
		
		$view_menu_permissions .= $this->input->post('CreateSubadmin') ? $this->input->post('CreateSubadmin').',' : "";  
		$view_menu_permissions .= $this->input->post('ViewAllSubadmin') ? $this->input->post('ViewAllSubadmin').',' : ""; 
		
		$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : ""; 

		$chkstatus = $_POST['chkstatus'] ? $_POST['chkstatus'] : array();
		
		if(count($chkstatus) > 0) {
           	$assignMerchant=implode(',',$chkstatus);
		} else{
			$assignMerchant='';
		}
		//echo  $assignMerchant; die; 
		$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
		$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
		$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
		$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

		if ($this->form_validation->run() == FALSE) {
			$dataResponse['status'] = '500';
			$dataResponse['message'] = validation_errors();
			echo json_encode($dataResponse);die;
			//$this->load->view("admin/add_subadmin", $data);

		} else {
			// echo $npsw.','.$cpsw;die;
		    // if($npsw == $cpsw) {
		    //   	$password = $this->my_encrypt($npsw, 'e');
		    //   	$data['password'] = $password;
		    // } else {
		    // 	$dataResponse['status'] = '500';
						// $dataResponse['message'] = 'Password and Confirm Password are not matched';
						// echo json_encode($dataResponse);die;
		    //         }
			// $npsw = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$@1234567890", mt_rand(0, 10), 1) . substr(md5(time()), 1);
			$pswdToMail = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 10);
			// echo $npsw;die;
			$password = $this->my_encrypt($pswdToMail, 'e');
          	$data['password'] = $password;

			$today1 = date("Ymdhms");
			$today2 = date("Y-m-d");
			$unique = "OH" . $today1;

			$data['name'] = $name;
			$data['last_name'] = $last_name;
			$data['mob_no'] = $mobile;
			$data['email'] = $email;
			$data['address'] = $address;
			$data['city'] = $city;
			$data['state'] = $state;
			$data['zip_code'] = $zip_code;
			$data['ssn'] = $ssn;
			$data['ein_no'] = $ein_no;
			$data['total_commission'] = $total_commission;
			$data['commission_p_merchant'] = $commission_p_merchant;
			$data['commission_p_transaction'] = $commission_p_transaction;
			$data['buy_rent'] = $buy_rent;
			$data['buyrate_volume'] = $buyrate_volume;
			$data['user_type'] = 'agent';
			$data['assign_merchant'] = $assignMerchant;
			$data['view_permissions'] = $view_permissions;
			$data['view_menu_permissions'] = $view_menu_permissions;
			$data['edit_permissions'] = $edit_permissions;
			$data['delete_permissions'] = $delete_permissions;
			$data['active_permissions'] = $active_permissions;
			$data['status'] = 'active';
			
			$this->db->insert('sub_admin', $data);
			if($this->db->affected_rows() > 0) {
				// $psw1 = $password1;
				set_time_limit(3000); 
				$MailTo = $email;  
				$MailSubject = 'SaleQuick Login Credentials'; 
				$header = "From: Salequick<info@salequick.com>\r\n".
					"MIME-Version: 1.0" . "\r\n" .
					"Content-type: text/html; charset=UTF-8" . "\r\n"; 
				$msg = "Your User ID is ".$email." and Password is ".$pswdToMail.". Please use these Credentials for login into SaleQuick via URL https://reseller.salequick.com/.<br><br>Regards,<br>Team SaleQuick";
				// ini_set('sendmail_from', $email);
				ini_set('sendmail_from', $MailTo);

				$this->email->from('info@salequick.com', '');
				// $this->email->to($MailTo);
				$this->email->to($MailTo);
				$this->email->subject($MailSubject);
				$this->email->message($msg);
				if($this->email->send()) {
					$dataResponse['status'] = '200';
					$dataResponse['message'] = 'added';
					echo json_encode($dataResponse);die;
				} else {
					$dataResponse['status'] = '500';
					$dataResponse['message'] = 'Mail not sent';
					echo json_encode($dataResponse);die;
				}
			} else {
				$dataResponse['status'] = '500';
				$dataResponse['message'] = 'Some issue in add agent.';
				echo json_encode($dataResponse);die;
			}

			// $id = $this->admin_model->insert_data("sub_admin", $data);

			//echo $this->db->last_query(); die; 
            // echo '200';
			//redirect("dashboard/all_subadmin");
			// $dataResponse['status'] = '200';
			// $dataResponse['message'] = 'added';
		}
		echo json_encode($dataResponse);die;
	}

	public function create_new_subadmin_original() {
		$data['meta'] = "Create New Subadmin";
		$data['loc'] = "create_new_subadmin";
		$data['action'] = "Create New Subadmin";

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$password = $this->my_encrypt($password1, 'e');
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(
					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'password' => ($password),
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => 'active',
				);
				$id = $this->admin_model->insert_data("sub_admin", $data);
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		} else {

			$data['all_merchantList'] = $this->admin_model->get_package_details("");
			$this->load->view("admin/add_subadmin", $data);
		}
	}

	public function create_new_subadmin() {
		$dataResponse = array();
		$data['meta'] = "Create New Subadmin";
		$data['loc'] = "create_new_subadmin";
		$data['action'] = "Create New Subadmin";

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$password = $this->my_encrypt($password1, 'e');
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				$dataResponse['status'] = '500';
				$dataResponse['message'] = validation_errors(); 
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(
					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'password' => ($password),
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => 'active',
				);
				$id = $this->admin_model->insert_data("sub_admin", $data);

                $dataResponse['status'] = '200';
				$dataResponse['message'] = 'added';
				//redirect("dashboard/all_subadmin");
			}
			echo json_encode($dataResponse);die;

		} else {
			$data['all_merchantList'] = $this->admin_model->get_package_details("");
			$this->load->view("admin/add_subadmin_dash", $data);
		}
	}

	public function create_new_agent() {
		$data['meta'] = "Create New Agent";
		$data['loc'] = "create_new_agent";
		$data['action'] = "Create New Agent";

		if (isset($_POST['submit'])) {
			// echo '<pre>';print_r($_POST);die;
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			//$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[sub_admin.mob_no]');
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$password = $this->my_encrypt($password1, 'e');
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(

					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'user_type' => 'agent',
					'password' => ($password),
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => 'active',
				);

				$id = $this->admin_model->insert_data("sub_admin", $data);
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		} else {

			$data['all_merchantList'] = $this->admin_model->get_package_details_active_merchant("");

			$this->load->view("admin/add_agent_dash", $data);
		}
	}

	public function update_subadmin() {
        // echo '<pre>';print_r($_POST);die;
        $dataResponse = array();
	    // $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile No', 'required');
		$this->form_validation->set_rules('hidden_assign_merchant', 'Merchant Assign', 'required');
		$this->form_validation->set_rules('Settings', 'Settings', 'required');

		$this->form_validation->set_rules('ssn', 'Social Security No', 'required');
		$this->form_validation->set_rules('ein_no', 'EIN No', 'required');
		// $this->form_validation->set_rules('total_commission', 'Sign Up Bonus', 'required');
		// $this->form_validation->set_rules('commission_p_merchant', 'Profit Share', 'required');
		// $this->form_validation->set_rules('commission_p_transaction', 'Gateway Fee (Per Merchant)', 'required');
		// $this->form_validation->set_rules('buy_rent', 'Buy Rate (Per Transaction)', 'required');

		$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
		// $email = $this->input->post('email') ? $this->input->post('email') : "";
		$name = $this->input->post('name') ? $this->input->post('name') : "";
		$last_name = $this->input->post('last_name') ? $this->input->post('last_name') : "";
		$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
		// $status = $this->input->post('status') ? $this->input->post('status') : "";
        //$mobile = preg_replace("/[\s-]/", "", $mobile);
        //$mobile = preg_replace("/\(|\)/", "", $mobile);
		$address = $this->input->post('address') ? $this->input->post('address') : "";
		$city = $this->input->post('city') ? $this->input->post('city') : "";
		$state = $this->input->post('state') ? $this->input->post('state') : "";
		$zip_code = $this->input->post('zip_code') ? $this->input->post('zip_code') : "";

		$ssn = $this->input->post('ssn') ? $this->input->post('ssn') : "";
		$ein_no = $this->input->post('ein_no') ? $this->input->post('ein_no') : "";
		$total_commission = $this->input->post('total_commission') ? $this->input->post('total_commission') : "";
		$commission_p_merchant = $this->input->post('commission_p_merchant') ? $this->input->post('commission_p_merchant') : "";
		$commission_p_transaction = $this->input->post('commission_p_transaction') ? $this->input->post('commission_p_transaction') : "";
		$buy_rent = $this->input->post('buy_rent') ? $this->input->post('buy_rent') : "";
		$buyrate_volume = $this->input->post('buyrate_volume') ? $this->input->post('buyrate_volume') : "";
		$hidden_assign_merchant = $this->input->post('hidden_assign_merchant') ? $this->input->post('hidden_assign_merchant') : "";

        //echo $mobile;die();
        //$opsw = $this->input->post('password') ? trim($this->input->post('password')) : "";
		//$npsw = $this->input->post('npsw') ? $this->input->post('npsw') : "";
        //$cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";

		$view_menu_permissions='';
        $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
        $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
		$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
		$view_menu_permissions .=$this->input->post('Funding') ? $this->input->post('Funding').',' : "";  
		
        $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
        $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
		$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
		$view_menu_permissions .= $this->input->post('TRecurringRequest') ? $this->input->post('TRecurringRequest').',' : "";
		
		$view_menu_permissions .= $this->input->post('InvoiceTemplate') ? $this->input->post('InvoiceTemplate').',' : "";  
        $view_menu_permissions .= $this->input->post('Instore_MobileTemplate') ? $this->input->post('Instore_MobileTemplate').',' : "";  
		$view_menu_permissions .= $this->input->post('ReceiptTemplate') ? $this->input->post('ReceiptTemplate').',' : "";  
		$view_menu_permissions .= $this->input->post('RecurringTemplate') ? $this->input->post('RecurringTemplate').',' : "";
		$view_menu_permissions .= $this->input->post('RegistrationTemplate') ? $this->input->post('RegistrationTemplate').',' : "";

        $view_menu_permissions .= $this->input->post('Vie_Merchant') ? $this->input->post('Vie_Merchant').',' : "";  
		$view_menu_permissions .= $this->input->post('ViewSubuser') ? $this->input->post('ViewSubuser').',' : "";  
		
        $view_menu_permissions .= $this->input->post('SupportsRequest') ? $this->input->post('SupportsRequest').',' : "";  
		$view_menu_permissions .= $this->input->post('SaleRequest') ? $this->input->post('SaleRequest').',' : ""; 
		
		$view_menu_permissions .= $this->input->post('CreateSubadmin') ? $this->input->post('CreateSubadmin').',' : "";  
		$view_menu_permissions .= $this->input->post('ViewAllSubadmin') ? $this->input->post('ViewAllSubadmin').',' : ""; 
		
		$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";

		$chkstatus = $_POST['chkstatus'] ? $_POST['chkstatus'] : array();
		// print_r($chkstatus); die();  
		// $password1 = $this->input->post('password') ? $this->input->post('password') : "";
		// $password = $this->my_encrypt($cpsw, 'e');

		if(count($chkstatus) > 0) {
           	$assignMerchant=implode(',',$chkstatus);
		} else {
			$assignMerchant='';
		}
		//echo  $assignMerchant; die; 
		$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
		$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
		$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
		$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
        // if ($cpsw != '') {
		// 	$psw1 = $password;
		// } else {
		// 	$psw1 = $password1;
		// }

		if ($this->form_validation->run() == FALSE) {
			// echo validation_errors();
			$dataResponse['status'] = '500';
			$dataResponse['message'] = validation_errors();
			echo json_encode($dataResponse);die;
			//$this->load->view("admin/add_subadmin", $data);

		} else {
			// if($reset_password == '1') {
			// 	$getPswdArr = $this->db->select('password')->where('id', $id)->get('sub_admin')->row();
			// 	$getPassword = $getPswdArr->password;
	  		//      $oldpsw = $this->my_encrypt($opsw, 'e');
			// }
            
			// if(!empty($opsw)) {
			//     if($getPassword == $oldpsw) {
			//   		if($npsw != "" && $cpsw != "") {
			//     		if($npsw == $cpsw) {
			//       			$password = $this->my_encrypt($npsw, 'e');
			//       			$upData['password'] = $password;
			//     		} else {
			//     			$dataResponse['status'] = '500';
			// 				$dataResponse['message'] = 'New password and confirm password are different';
			// 				echo json_encode($dataResponse);die;
			//     		}
			//     	} else {
			//     		$dataResponse['status'] = '500';
			// 			$dataResponse['message'] = 'New Password And Confirm Password can not be blank';
			//     		echo json_encode($dataResponse);die;
			//     	}
			// 	} else {
			// 		$dataResponse['status'] = '500';
			// 		$dataResponse['message'] = 'Incorrect Old Password';
			//   		echo json_encode($dataResponse);die;
			// 	}
            // }

			$upData['name'] = $name;
			$upData['last_name'] = $last_name;
			$upData['mob_no'] = $mobile;
			$upData['address'] = $address;
			$upData['city'] = $city;
			$upData['state'] = $state;
			$upData['zip_code'] = $zip_code;
			$upData['ssn'] = $ssn;
			$upData['ein_no'] = $ein_no;
			$upData['total_commission'] = $total_commission;
			$upData['commission_p_merchant'] = $commission_p_merchant;
			$upData['commission_p_transaction'] = $commission_p_transaction;
			$upData['buy_rent'] = $buy_rent;
			$upData['buyrate_volume'] = $buyrate_volume;
			// $upData['assign_merchant']=$assignMerchant;
			$upData['assign_merchant'] = $hidden_assign_merchant;
			$upData['view_permissions'] = $view_permissions;
			$upData['view_menu_permissions'] = $view_menu_permissions;
			$upData['edit_permissions'] = $edit_permissions;
			$upData['delete_permissions'] = $delete_permissions;
			$upData['active_permissions'] = $active_permissions;
			$upData['status'] = 'active';

			if($this->input->post('reset_password')) {
				$getEmail = $this->db->select('email')->where('id', $id)->get('sub_admin')->row();
				$email = $getEmail->email;

				$pswdToMail = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 10);
				$password = $this->my_encrypt($pswdToMail, 'e');
	          	$upData['password'] = $password;

				$this->db->where('id', $id);
				$this->db->update('sub_admin', $upData);

				if($this->db->affected_rows() > 0) {
					// $psw1 = $password1;
					set_time_limit(3000); 
					$MailTo = $email;
					$MailSubject = 'SaleQuick Password Reset'; 
					$header = "From: Salequick<info@salequick.com>\r\n".
						"MIME-Version: 1.0" . "\r\n" .
						"Content-type: text/html; charset=UTF-8" . "\r\n"; 
					$msg = "Your password has been reset which is ".$pswdToMail." for the email ".$email.". Please use these Credentials for login into SaleQuick via url https://reseller.salequick.com/.<br><br>Regards,<br>Team SaleQuick";
					// ini_set('sendmail_from', $email);
					ini_set('sendmail_from', $MailTo);

					$this->email->from('info@salequick.com', '');
					// $this->email->to($MailTo);
					$this->email->to($MailTo);
					$this->email->subject($MailSubject);
					$this->email->message($msg);
					if($this->email->send()) {
						$dataResponse['status'] = '200';
						$dataResponse['message'] = 'updated_sent';
						echo json_encode($dataResponse);die;
					} else {
						$dataResponse['status'] = '500';
						$dataResponse['message'] = 'Password updation mail not sent';
						echo json_encode($dataResponse);die;
					}
				}
			} else {
				$this->db->where('id', $id);
				$this->db->update('sub_admin', $upData);

				if($this->db->affected_rows() > 0) {
					$dataResponse['status'] = '200';
					$dataResponse['message'] = 'updated';
					echo json_encode($dataResponse);die;
				}
			}

			// $this->admin_model->update_data('sub_admin', $upData, array('id' => $id, ));
		}
		echo json_encode($dataResponse);die;
	}

	public function edit_agent() {
		$bct_id = $this->uri->segment(3);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		$branch = $this->admin_model->get_subadmin_details($bct_id);
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$last_name = $this->input->post('last_name') ? $this->input->post('last_name') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                        
			$password = $this->input->post('password') ? $this->input->post('password') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
			$password1 = $this->my_encrypt($cpsw, 'e');

			if ($cpsw != '') {
				$psw1 = $password1;
			} else {
				$psw1 = $password;
			}
			// echo md5($password);
			$branch_info = array(
				'name' => $name,
				'last_name' => $last_name,
				'status' => $status,
				'email' => $email,
				'mob_no' => $mobile,
				'password' => $psw1,
				'view_permissions' => $view_permissions,
				'edit_permissions' => $edit_permissions,
				'delete_permissions' => $delete_permissions,
				'active_permissions' => $active_permissions,

			);

			$this->admin_model->update_data('sub_admin', $branch_info, array(
				'id' => $id,
			));
			$this->session->set_userdata("mymsg", "Data Has Been Updated.");
			redirect('dashboard/all_agent');
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['last_name'] = $sub->last_name;
				$data['mobile'] = $sub->mob_no;
				$data['password'] = $sub->password;
				$data['status'] = $sub->status;
				$data['address'] = $sub->address;
				$data['city'] = $sub->city;
				$data['state'] = $sub->state;
				$data['zip_code'] = $sub->zip_code;
				$data['ssn'] = $sub->ssn;
				$data['ein_no'] = $sub->ein_no;
				$data['total_commission'] = $sub->total_commission;
				$data['commission_p_merchant'] = $sub->commission_p_merchant;
				$data['commission_p_transaction'] = $sub->commission_p_transaction;
				$data['buy_rent'] = $sub->buy_rent;
				$data['buyrate_volume'] = $sub->buyrate_volume;
				$data['assign_merchant'] = $sub->assign_merchant;
				$data['view_permissions'] = $sub->view_permissions;
				$data['view_menu_permissions'] = $sub->view_menu_permissions;
				$data['edit_permissions'] = $sub->edit_permissions;
				$data['delete_permissions'] = $sub->delete_permissions;
				$data['active_permissions'] = $sub->active_permissions;
				break;
			}
		}
		$data['all_merchantList'] = $this->admin_model->get_package_details_active_merchant("");

		$data['meta'] = "Update Agent";
		$data['action'] = "Update Agent";
		$data['loc'] = "edit_agent";
		$this->load->view('admin/edit_agent_dash', $data);
	}
	
	public function edit_subadmin() {
		$bct_id = $this->uri->segment(3);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		$branch = $this->admin_model->get_subadmin_details($bct_id);
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password = $this->input->post('password') ? $this->input->post('password') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
			$password1 = $this->my_encrypt($cpsw, 'e');

			if ($cpsw != '') {
				$psw1 = $password1;
			} else {
				$psw1 = $password;
			}
			// echo md5($password);
			$branch_info = array(
				'name' => $name,
				'status' => $status,
				'email' => $email,
				'mob_no' => $mobile,
				'password' => $psw1,
				'view_permissions' => $view_permissions,
				'edit_permissions' => $edit_permissions,
				'delete_permissions' => $delete_permissions,
				'active_permissions' => $active_permissions,

			);

			$this->admin_model->update_data('sub_admin', $branch_info, array(
				'id' => $id,
			));
			$this->session->set_userdata("mymsg", "Data Has Been Updated.");
			redirect('dashboard/all_subadmin');
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;
				$data['password'] = $sub->password;
				$data['status'] = $sub->status;
				$data['assign_merchant'] = $sub->assign_merchant;
				$data['view_permissions'] = $sub->view_permissions;
				$data['view_menu_permissions'] = $sub->view_menu_permissions;
				$data['edit_permissions'] = $sub->edit_permissions;
				$data['delete_permissions'] = $sub->delete_permissions;
				$data['active_permissions'] = $sub->active_permissions;
				break;
			}
		}
		$data['all_merchantList'] = $this->admin_model->get_package_details("");

		$data['meta'] = "Update SubAdmin";
		$data['action'] = "Update Subadmin";
		$data['loc'] = "edit_subadmin";
		$this->load->view('admin/add_subadmin_dash', $data);
	}

	public function Approved_merchant($id) {

		//check data exist

		$this->admin_model->update_data('merchant', array(
			"status" => "active",
		), array(
			"id" => $id,
		));

		$this->session->set_userdata("msg", "Merchant Approved");
		redirect('dashboard/all_merchant');
	}

	public function funding_status() {
		// echo '<pre>';print_r($_POST);die;
		//check data exist
		$id = $_POST["mid"];
		$date = $_POST["date"];
		$amount = $_POST["PayableAmount"];
		$hold_amount = $_POST["Hold_Amount"];
		$holdetext = @$_POST["holdetext"];
		$status = $_POST["pstatus"];
		$tabledata = $this->admin_model->data_get_where_serch("funding_status", array(
			"merchant_id" => $id,
			"date" => $date,
		));
		if (empty($tabledata)) {
			$tabledata = $this->admin_model->insert_data("funding_status", array(
				"hold_amount" => $hold_amount,
				"merchant_id" => $id,
				"date" => $date,
				"amount" => $amount,
				"status" => $status,
			));
		} else {
			$this->admin_model->update_data('funding_status', array(
				"hold_amount" => $hold_amount,
				"status" => $status,
				"modifiedDate" => date("Y-m-d H:i:s"),
			), array(
				"merchant_id" => $id,
				"date" => $date,
			));
		}
		if (!empty($holdetext)) {
			foreach ($holdetext as $tid) {
				$this->admin_model->update_data('funding_status', array(
					"hold_amount" => 0,
					"status" => $status,
					"modifiedDate" => date("Y-m-d H:i:s"),
				), array(
					"id" => $tid,
				));
			}
		}
		$updata = array(
			"hold_amount" => $hold_amount,
			"status" => $status,
		);
		$this->db->where('id', $id);
		$this->db->update('report_admin', $updata);

		$this->session->set_userdata("success", "Status Updated Successfully");
		redirect('dashboard/report');
	}
	public function get_holdamount() {
		// echo '<pre>';print_r($_POST);die;
		$mid = $_POST["mid"];
		$cdate = $_POST["cdate"];
		$amounnt = $_POST["amounnt"];
		$tabledata = $this->admin_model->get_holdamount(array(
			'mid' => $mid,
			"cdate" => $cdate,
		));
		echo json_encode($tabledata);
	}

	public function funding_status_post() {
		// echo '<pre>';print_r($_POST);die;
		foreach ($_POST["chkstatus"] as $post) {
			$post = explode("_", $post);
			$id = $post[0];
			$amount = $post[1];
			$date = $_POST["date"];
			$status = isset($_POST["confirmSubmit"]) ? "confirm" : "pending";
			//check data exist
			$tabledata = $this->admin_model->data_get_where_serch("funding_status", array(
				"merchant_id" => $id,
				"date" => $date,
			));
			// echo $this->db->last_query();
			// echo '<pre>';print_r($tabledata);die;
			if (empty($tabledata)) {
				$tabledata = $this->admin_model->insert_data("funding_status", array(
					"merchant_id" => $id,
					"date" => $date,
					"amount" => $amount,
					"status" => $status,
				));
			} else {
				$this->admin_model->update_data('funding_status', array(
					"status" => $status,
					"modifiedDate" => date("Y-m-d H:i:s"),
				), array(
					"merchant_id" => $id,
					"date" => $date,
				));
			}
			$updata = array(
				"amount" => $amount,
				"status" => $status,
			);
			$this->db->where('id', $id);
			$this->db->update('report_admin', $updata);

		}
		$this->session->set_userdata("success", "Status Updated Successfully");
		// redirect('dashboard/report/' . $date);
		redirect('dashboard/report');
	}

	public function update_merchant() {
		$bct_id = $this->uri->segment(3);
		if (!$bct_id &&  !$this->input->post('submit') && !$this->input->post('updatepassword')  ) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		//$branch = $this->admin_model->get_subadmin_details($bct_id);
		$branch = $this->admin_model->get_payment_details_3($bct_id);
		// echo '<pre>';print_r($_POST);die;
		// echo $this->db->last_query();die;
		//print_r($_POST); die("ok"); 
		if($this->input->post('updatepassword')) {
			// echo '<pre>';print_r($_POST);die;
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
            $email = $this->input->post('email') ? strtolower($this->input->post('email')) : "";
            $password = $this->input->post('password') ? $this->input->post('password') : "";
			$cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";

			if(!empty($cpsw)) {
				$password1 = $this->my_encrypt($cpsw, 'e');
				$psw1 = $password1;

				$branch_info = array('password' => $psw1); 
				$up=$this->admin_model->update_data('merchant', $branch_info, array('id' => $id));
			
				$psw1 = $password1;
				set_time_limit(3000); 
				$MailTo = $email;  
				$MailSubject = 'SaleQuick Login Authentication'; 
				$header = "From: Salequick<info@salequick.com>\r\n".
							"MIME-Version: 1.0" . "\r\n" .
							"Content-type: text/html; charset=UTF-8" . "\r\n"; 
				// $msg = " Your user id : ".$email." .  Latest  Password : ".$cpsw.".";
				$msg = "Your password is successfully updated. <br>Your User ID is ".$email." and Updated Password is ".$cpsw.".<br><br>Team SaleQuick";
				// echo $msg;die;
				ini_set('sendmail_from', $email);

				$this->email->from('info@salequick.com', '');
				$this->email->to($MailTo);
				$this->email->subject($MailSubject);
				$this->email->message($msg);
				$this->email->send();

				$this->session->set_flashdata("success", "Password Updated Successfully. Please check your email for updated password.");
			
			} else {
				$this->session->set_flashdata("error", "Password field is required.");
			}
			redirect('dashboard/update_merchant/' . $id);
		}

		if ($this->input->post('submit')) {
			// echo '<pre>';print_r($_POST);die;
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
			$email1 = $this->input->post('email1') ? strtolower($this->input->post('email1')) : "";
			$business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
			$report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
			$batch_report_time = $this->input->post('batch_report_time') ? $this->input->post('batch_report_time') : "";
			$business_name = $this->input->post('business_name') ? $this->input->post('business_name') : "";
			$business_dba_name = $this->input->post('business_dba_name') ? $this->input->post('business_dba_name') : "";
			$business_type = $this->input->post('business_type') ? $this->input->post('business_type') : "";
			$ien_no = $this->input->post('ien_no') ? $this->input->post('ien_no') : "";
			$address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
			$city = $this->input->post('city') ? $this->input->post('city') : "";
			$country = $this->input->post('country') ? $this->input->post('country') : "";
			$zip = $this->input->post('zip') ? $this->input->post('zip') : "";
			$website = $this->input->post('website') ? $this->input->post('website') : "";
			$year_business = $this->input->post('year_business') ? $this->input->post('year_business') : "";
			$o_name = $this->input->post('o_name') ? $this->input->post('o_name') : "";
			$o_email = $this->input->post('o_email') ? strtolower($this->input->post('o_email')) : "";
			$o_phone = $this->input->post('o_phone') ? $this->input->post('o_phone') : "";
			$bank_street = $this->input->post('bank_street') ? $this->input->post('bank_street') : "";
			$bank_zip = $this->input->post('bank_zip') ? $this->input->post('bank_zip') : "";
			$o_address = $this->input->post('o_address') ? $this->input->post('o_address') : "";
			$bank_city = $this->input->post('bank_city') ? $this->input->post('bank_city') : "";
			$bank_country = $this->input->post('bank_country') ? $this->input->post('bank_country') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$signature_status = $this->input->post('signature_status') ? $this->input->post('signature_status') : "";
			$o_social = $this->input->post('o_social') ? $this->input->post('o_social') : "";
			$o_percentage = $this->input->post('o_percentage') ? $this->input->post('o_percentage') : "";
			$protractor_status = $this->input->post('protractor_status') ? $this->input->post('protractor_status') : "";
			$t_fee = $this->input->post('t_fee') ? $this->input->post('t_fee') : "";
			$s_fee = $this->input->post('s_fee') ? $this->input->post('s_fee') : "";
			$bank_account = $this->input->post('bank_account') ? $this->input->post('bank_account') : "";
			$bank_routing = $this->input->post('bank_routing') ? $this->input->post('bank_routing') : "";
			$bank_name = $this->input->post('bank_name') ? $this->input->post('bank_name') : "";
			$funding_time = $this->input->post('funding_time') ? $this->input->post('funding_time') : "";
			$monthly_fee = $this->input->post('monthly_fee') ? $this->input->post('monthly_fee') : "";
			$chargeback = $this->input->post('chargeback') ? $this->input->post('chargeback') : "";
			$text_email = $this->input->post('text_email') ? $this->input->post('text_email') : "";
			$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
			$recurring = $this->input->post('recurring') ? $this->input->post('recurring') : "";
			$point_sale = $this->input->post('point_sale') ? $this->input->post('point_sale') : "";
			$f_swap_Invoice = $this->input->post('f_swap_Invoice') ? $this->input->post('f_swap_Invoice') : "";
			$f_swap_Recurring = $this->input->post('f_swap_Recurring') ? $this->input->post('f_swap_Recurring') : "";
			$f_swap_Text = $this->input->post('f_swap_Text') ? $this->input->post('f_swap_Text') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
            $edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
            $create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') : '0' . "";

            $view_menu_permissions='';
            $view_menu_permissions .=$this->input->post('ViewPermissions') ? $this->input->post('ViewPermissions').',' : "";  
            $view_menu_permissions .=$this->input->post('AddPermissions') ? $this->input->post('AddPermissions').',' : "";  
            $view_menu_permissions .=$this->input->post('EditPermissions') ? $this->input->post('EditPermissions').',' : "";  
            $view_menu_permissions .=$this->input->post('DeletePermissions') ? $this->input->post('DeletePermissions').',' : ""; 
            $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
            $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
            $view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
            $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
            $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
            $view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
            $view_menu_permissions .= $this->input->post('VirtualTerminal') ? $this->input->post('VirtualTerminal').',' : "";  
            $view_menu_permissions .= $this->input->post('IInvoicing') ? $this->input->post('IInvoicing').',' : "";  
            $view_menu_permissions .= $this->input->post('IRecurring') ? $this->input->post('IRecurring').',' : "";  
            $view_menu_permissions .= $this->input->post('RInstoreMobile') ? $this->input->post('RInstoreMobile').',' : "";
            $view_menu_permissions .= $this->input->post('RInvoice') ? $this->input->post('RInvoice').',' : "";
            $view_menu_permissions .= $this->input->post('ItemsManagement') ? $this->input->post('ItemsManagement').',' : "";  
            $view_menu_permissions .= $this->input->post('Reports') ? $this->input->post('Reports').',' : "";  
            $view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";

			
			// $email = $this->input->post('email') ? $this->input->post('email') : "";
			// $password = $this->input->post('password') ? $this->input->post('password') : "";
			// $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			// $state = $this->input->post('state') ? $this->input->post('state') : "";
			// $mi = $this->input->post('mi') ? $this->input->post('mi') : "";

			// $password1 = $this->my_encrypt($cpsw, 'e');

			// if ($cpsw != '') {
			// 	$psw1 = $password1;
			// } else {
			// 	$psw1 = $password;
			// }
			// echo md5($password);
			$branch_info = array(
				'name' => $name,
				'address2' => $address2,
				'email1' => $email1,
				'business_number' => $business_number,
				'report_email' => $report_email,
				'batch_report_time' => $batch_report_time,
				'business_name' => $business_name,
				'business_dba_name' => $business_dba_name,
				'business_type' => $business_type,
				'ien_no' => $ien_no,
				'address1' => $address1,
				'city' => $city,
				'country' => $country,
				'zip' => $zip,
				'website' => $website,
				'year_business' => $year_business,
				'o_name' => $o_name,
				'o_email' => $o_email,
				'o_phone' => $o_phone,
				'bank_street' => $bank_street,
				'bank_zip' => $bank_zip,
				'o_address' => $o_address,
				'bank_city' => $bank_city,
				'bank_country' => $bank_country,
				'status' => $status,
				'signature_status' => $signature_status,
				'o_social' => $o_social,
				'o_percentage' => $o_percentage,
				'protractor_status' => $protractor_status,
				't_fee' => $t_fee,
				's_fee' => $s_fee,
				'bank_account' => $bank_account,
				'bank_routing' => $bank_routing,
				'bank_name' => $bank_name,
				'funding_time' => $funding_time,
				'monthly_fee' => $monthly_fee,
				'chargeback' => $chargeback,
				'text_email' => $text_email,
				'invoice' => $invoice,
				'recurring' => $recurring,
				'point_sale' => $point_sale,
				'f_swap_Invoice' => $f_swap_Invoice,
				'f_swap_Recurring' => $f_swap_Recurring,
				'f_swap_Text' => $f_swap_Text,
				'business_number' => $mobile,
				'view_permissions' => $view_permissions,
                'edit_permissions' => $edit_permissions,
                'create_pay_permissions' => $create_pay_permissions,
                'view_menu_permissions' => $view_menu_permissions,
				//'password' => $psw1,
				// 'state' => $state,
				// 'mi' => $mi,
				// 'email1' => $email1,
			);
			// echo '<pre>';print_r($branch_info);die;
			$this->admin_model->update_data('merchant', $branch_info, array('id' => $id));
			// echo $this->db->last_query();die;
			//  else {
			// 	echo '1';die;
			// }
			$this->session->set_flashdata("success", "Merchant Details Updated Successfully");
			// $this->session->set_flashdata('mymsg_u', '<div class="alert alert-success text-center">  Data Has Been Updated </div>');
			//redirect('dashboard/all_merchant');
			redirect('dashboard/update_merchant/' . $id);

		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['name'] = $sub->name;
				$data['address2'] = $sub->address2;
				$data['email1'] = strtolower($sub->email1);
				$data['business_number'] = $sub->business_number;
				$data['report_email'] = $sub->report_email;
				$data['batch_report_time'] = $sub->batch_report_time;
				$data['business_name'] = $sub->business_name;
				$data['business_dba_name'] = $sub->business_dba_name;
				$data['business_type'] = $sub->business_type;
				$data['ien_no'] = $sub->ien_no;
				$data['address1'] = $sub->address1;
				$data['city'] = $sub->city;
				$data['country'] = $sub->country;
				$data['zip'] = $sub->zip;
				$data['website'] = $sub->website;
				$data['year_business'] = $sub->year_business;
				$data['o_name'] = $sub->o_name;
				$data['o_email'] = strtolower($sub->o_email);
				$data['o_phone'] = $sub->o_phone;
				$data['bank_street'] = $sub->bank_street;
				$data['bank_zip'] = $sub->bank_zip;
				$data['o_address'] = $sub->o_address;
				$data['bank_city'] = $sub->bank_city;
				$data['bank_country'] = $sub->bank_country;
				$data['status'] = $sub->status;
				$data['signature_status'] = $sub->signature_status;
				$data['o_social'] = $sub->o_social;
				$data['o_percentage'] = $sub->o_percentage;
				$data['protractor_status'] = $sub->protractor_status;
				$data['t_fee'] = $sub->t_fee;
				$data['s_fee'] = $sub->s_fee;
				$data['bank_account'] = $sub->bank_account;
				$data['bank_routing'] = $sub->bank_routing;
				$data['bank_name'] = $sub->bank_name;
				$data['funding_time'] = $sub->funding_time;
				$data['monthly_fee'] = $sub->monthly_fee;
				$data['chargeback'] = $sub->chargeback;
				$data['text_email'] = $sub->text_email;
				$data['invoice'] = $sub->invoice;
				$data['recurring'] = $sub->recurring;
				$data['point_sale'] = $sub->point_sale;
				$data['f_swap_Invoice'] = $sub->f_swap_Invoice;
				$data['f_swap_Recurring'] = $sub->f_swap_Recurring;
				$data['f_swap_Text'] = $sub->f_swap_Text;
				$data['email'] = strtolower($sub->email);
				$data['mobile'] = $sub->business_number;
				$data['password'] = $sub->password;
				$data['view_permissions'] = $sub->view_permissions;
				$data['edit_permissions'] = $sub->edit_permissions;
				$data['create_pay_permissions'] = $sub->create_pay_permissions;
				$data['view_menu_permissions'] = $sub->view_menu_permissions;
				// $data['auth_key'] = $sub->auth_key;
				// $data['date'] = $sub->created_on;
				// $data['state'] = $sub->state;
				// $data['city'] = $sub->city;
				// $data['mi'] = $sub->mi;
				// $data['o_address'] = $sub->o_address;
				break;
			}
		}
		$data['meta'] = "Edit Merchant Info";
		$data['action'] = "Update Merchant";
		$data['loc'] = "update_merchant";
		// echo '<pre>';print_r($data);die;
		$this->load->view('admin/update_merchant_dash', $data);
	}

	

	public function all_agent() {
		$data = array();
		if(isset($_GET['success']) && $_GET['success'] == "added") {
		    $data['msg'] = 'Agent Added Successfully. A mail is sent to agent regarding Credentials.';
		}
		if(isset($_GET['success']) && $_GET['success'] == "updated") {
		    $data['msg'] = 'Agent Info Updated Successfully.';
		}
		if(isset($_GET['success']) && $_GET['success'] == "deleted") {
		    $data['msg'] = 'Agent Deleted Successfully.';
		}
		if(isset($_GET['success']) && $_GET['success'] == "updated_sent") {
		    $data['msg'] = 'Agent Info Updated Successfully. A mail is sent to agent regarding Credentials.';
		}

		$package_data = $this->admin_model->get_full_details_agent('sub_admin');

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['last_name'] = $each->last_name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;

			$package['view_permissions'] = $each->view_permissions;
			$package['edit_permissions'] = $each->edit_permissions;
			$package['delete_permissions'] = $each->delete_permissions;
			$package['active_permissions'] = $each->active_permissions;

			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['meta'] = 'View All Agent';

		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');

		// $this->load->view('admin/all_agent', $data);
		$this->load->view('admin/all_agent_dash', $data);
	}

	public function all_subadmin() {
		$data = array();
		if(isset($_GET['success']) && $_GET['success'] == "added") {
		    $data['msg'] = 'Agent Added Successfully.';
		}
		if(isset($_GET['success']) && $_GET['success'] == "updated") {
		    $data['msg'] = 'Agent Updated Successfully.';
		}
		if(isset($_GET['success']) && $_GET['success'] == "deleted") {
		    $data['msg'] = 'Agent Deleted Successfully.';
		}
		$package_data = $this->admin_model->get_full_details_subadmin('sub_admin');

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['view_permissions'] = $each->view_permissions;
			$package['edit_permissions'] = $each->edit_permissions;
			$package['delete_permissions'] = $each->delete_permissions;
			$package['active_permissions'] = $each->active_permissions;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['meta'] = 'View All Subadmin';
		$this->load->view('admin/all_subadmin_dash', $data);
	}
	
	public function all_merchant() {
		$data = array();
		$data['meta'] = 'Woodforest Merchant Accounts';
		$this->load->view('admin/all_merchant_dash', $data);
	}

	function getAllMerchants() {
		// echo '<pre>';print_r($_POST);die;
        $data = $row = array();
		$this->load->model('serverside_model');

		$table = 'merchant';
		$column_order = array('id', 'business_dba_name', 'email', 'business_number', 'business_name', 'status', 'is_token_system_permission');
        $column_search = array('business_dba_name','business_name', 'email');
        $order = array('id' => 'desc');

        $memData = $this->serverside_model->getRows($_POST, $column_order, $column_search, $order, $table);
        // echo $this->db->last_query();die;
        // echo '<pre>';print_r($memData);die;

        $current_month = date('m');
        
        if($current_month == '01') {
        	$field_name = 'Totaljan';
        } else if($current_month == '02') {
        	$field_name = 'Totalfeb';
        } else if($current_month == '03') {
        	$field_name = 'Totalmarch';
        } else if($current_month == '04') {
        	$field_name = 'Totalaprl';
        } else if($current_month == '05') {
        	$field_name = 'Totalmay';
        } else if($current_month == '06') {
        	$field_name = 'Totaljune';
        } else if($current_month == '07') {
        	$field_name = 'Totaljuly';
        } else if($current_month == '08') {
        	$field_name = 'Totalaugust';
        } else if($current_month == '09') {
        	$field_name = 'Totalsep';
        } else if($current_month == '10') {
        	$field_name = 'Totaloct';
        } else if($current_month == '11') {
        	$field_name = 'Totalnov';
        }  else if($current_month == '12') {
        	$field_name = 'Totaldec';
        }
        // echo $current_month.','.$field_name;die;
        
        $i = $_POST['start'];
        foreach($memData as $member) {
        	// echo $member->status;
            $i++;
        	$key = ($i-1);
            $row = array();
            // $row[] = '<span class="td_first" id="row_'.$member->id.'">'.$member->business_dba_name.'</span>';
            $edit_btn_path = base_url('dashboard/update_merchant/'.$member->id);

            // $row[] = '<a class="btn-link" href="'.$edit_btn_path.'">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="btn-link" href="javascript:void(0)" title="delete" onclick="merchant_delete('.$member->id.')" style="margin-right: 10px;">Delete</a>';
            $row[] = '<a class="btn-link" href="'.$edit_btn_path.'">Edit</a>';

            if($member->status == "active") {
            	$btncolor='badge-success';
            	$dtext='Active';
            	$title='Active';
            }
            if($member->status == "Waiting_For_Approval") {
            	$btncolor='badge-warning';
            	$dtext='Waiting';
            	$title='Waiting For Admin Approval';
            }
            if($member->status == "pending") {
            	$btncolor='badge-danger';
            	$dtext='Pending';
            	$title='Pending';
            }
            if($member->status == "pending_signup") {
            	$btncolor='badge-danger';
            	$dtext='Pending Signup';
            	$title='Pending Signup';
            }
            $row[] = '<a data-toggle="tooltip" class="badge '. $btncolor.'" style="font-size: 12px; color:white;" data-placement="top" title="'. $title.'">'.$dtext.'</a>';

            // $row[] = $member->business_dba_name;
            $row[] = '<span class="companyInfoClick" data-legalname="'.$member->business_name.'" data-business_dba_name="'.$member->business_dba_name.'" data-controller_name="'.$member->name.' '.$member->m_name.' '.$member->l_name.'" title="Click to view">'.$member->business_name.'</span>' ;

            $row[] = '<span class="contactClick" data-fullname="'.$member->name.' '.$member->m_name.' '.$member->l_name.'" data-email="'.$member->email.'" data-mobile="'.$member->business_number.'" title="Click to view">'.$member->email.'</span>' ;

            // $row[] = $member->business_number;
            // $row[] = '<span>'.$member->email.'<br>'.$member->business_number.'</span>';

            

            // $payroc_status = ($member->payroc > 0) ? 'active' : '';
            // $payroc_checked = ($member->payroc > 0) ? 'checked' : '';
            // $row[] = '<span class="start_stop_payroc '.$payroc_status.'" rel="238"><label class="switch switch_type1" role="switch" style="z-index: 0 !important;"><input type="checkbox" class="switch__toggle" '.$payroc_checked.' id="switchval_'.$member->id.'" value="'.$member->id.'"><span class="switch__label">|</span></label></span>';

            // $is_token_status = ($member->is_token_system_permission > 0) ? 'active' : '';
            // $is_token_checked = ($member->is_token_system_permission > 0) ?  'checked' : '';
            // $row[] = '<span class="start_stop_tax '.$is_token_status.'" rel="238"><label class="switch switch_type1" role="switch" style="z-index: 0 !important;"><input type="checkbox" class="switch__toggle" '.$is_token_checked.' id="switchval_'.$member->id.'" value="'.$member->id.'"><span class="switch__label">|</span></label></span>';

            $activation_text_highlighter = ($member->status == "active") ? '' : 'highliter';
         //    if($member->status == "confirm") {
	        //     $button_content = array(
		       //      'class' => 'btn btn-sm btn-info span_lg_btn',
		       //      'id' => 'del-bt',
		       //      'content' => ' <a><i class="mdi mdi-account"></i> Active Account</a>',
		       //      'onclick' => 'javascript:active_pak('.$member->id.')'
	        //     );
	        //     $button_data = form_button($button_content);

	        // } elseif($member->status == "active") {
	        //     $button_data = '<button class="btn btn-sm btn-success span_lg_btn" onclick="merchant_block('.$member->id.')"><i class="mdi mdi-account"></i> Block Account</button>';

	        // } elseif($member->status == "block") {
	        //     $button_data = '<button class="btn btn-sm btn-info span_lg_btn" onclick="active_merchant('.$member->id.')"><i class="mdi mdi-account"></i> Active Account</button>';

	        // } elseif($member->status == "pending") {
	        //     $button_data = '<button class="btn btn-sm btn-danger span_lg_btn" onclick="confirm_email('.$member->id.')" ><i class="mdi mdi-account"></i> Confirm Email</button>';
	        // } elseif($member->status == "pending_signup") {
	        //     $button_data = '<button class="btn btn-sm btn-danger span_lg_btn" onclick="confirm_email('.$member->id.')"><i class="mdi mdi-account"></i> Confirm Email</button>';
	        // }
	        // $edit_btn_path = base_url('dashboard/update_merchant/'.$member->id);
	        // $view_sub_merchant_path = base_url('dashboard/all_sub_merchant/'.$member->id);

	        if($member->status == "confirm") {
	            // $button_content = array(
		           //  'class' => 'btn btn-sm btn-info span_lg_btn',
		           //  'id' => 'del-bt',
		           //  'title' => 'Active Account',
		           //  'content' => ' <a><i class="fa fa-check"></i></a>',
		           //  'onclick' => 'javascript:active_pak('.$member->id.')'
	            // );
	            // $button_data = form_button($button_content);
	            $button_data = '';

	        } elseif($member->status == "active") {
	            $button_data = '';

	        } elseif($member->status == "block") {
	            $button_data = '';

	        } elseif($member->status == "pending") {
	            $button_data = '<button class="btn btn-sm btn-danger span_lg_btn" onclick="confirm_email('.$member->id.')" title="Confirm Email" style="padding: 4px 12px !important;margin-left:5px;"><img src="'.base_url('new_assets/admin_img/mark_email_read.svg').'"></button>';

	        } elseif($member->status == "pending_signup") {
	            $button_data = '<button class="btn btn-sm btn-danger span_lg_btn" onclick="confirm_email('.$member->id.')" title="Confirm Email" style="padding: 4px 12px !important;margin-left:5px;"><img src="'.base_url('new_assets/admin_img/mark_email_read.svg').'"></button>';

	        }
	        $edit_btn_path = base_url('dashboard/update_merchant/'.$member->id);
	        $view_sub_merchant_path = base_url('dashboard/all_sub_merchant/'.$member->id);

	        if($member->status == "active") {
	            $active_inactive = '<button class="btn btn-sm btn-success span_lg_btn" title="Block Account" onclick="merchant_block('.$member->id.')" style="width:50px;"><i class="fa fa-ban"></i></button>';
	        } else {
	            $active_inactive = '<button class="btn btn-sm btn-info span_lg_btn" title="Active Account" onclick="active_merchant('.$member->id.')" style="width:50px;"><i class="fa fa-check"></i></button>';
	        }

            // $row[] = '<span class="all_mer_tbl_btns">
            // 	<span style="white-space: nowrap !important;"><button data-toggle="modal" data-target="#view-modall" data-id="'.$member->id.'" id="getcredt" class="btn btn-sm btn-info span_lg_btn" title="Credentials"><i class="fa fa-eye"></i> Credentials</button>
            //     <button data-toggle="modal" onClick="viewDetails('.$member->id.')" data-target="#view-ActivationDetails" data-id="'.$key.'" id="activationDetails" class="'.$activation_text_highlighter.' btn btn-sm btn-info span_lg_btn" style="margin-left: 5px;margin-right: 5px;"><i class="fa fa-eye"></i> Activation Details</button></span>'.$button_data.
            //     '<span class="sm_btn_row" style="white-space: nowrap !important;"><a class="btn btn-sm btn-warning span_sm_btn" title="edit" id="edit-bt" href="'.$edit_btn_path.'"><i class="fa fa-pencil"></i></a>
            //     <a class="btn btn-sm btn-gray span_sm_btn" title="all subuser list" target="_blank" href="'.$view_sub_merchant_path.'"><i class="fa fa-users"></i></a>
            //     <button class="btn btn-sm btn-danger span_sm_btn" title="delete" onclick="merchant_delete('.$member->id.')"><i class="fa fa-trash"></i></button></span></span>';
            $ongoing_notes_url = base_url('merchant_document/ongoing_notes/'.$member->id);
            $all_pdfs_url = base_url('merchant_document/all_pdfs/'.$member->id);

            // Commented on 18 Jan 2022
            // $row[] = '<span class="all_mer_tbl_btns">
            // 	<button data-toggle="modal" data-target="#view-modall" data-id="'.$member->id.'" id="getcredt" class="btn btn-sm btn-primary span_lg_btn" title="Credentials"><i class="fa fa-key"></i></button>
            //     <button data-toggle="modal" title="Activation Details" onClick="viewDetails('.$member->id.')" data-target="#view-ActivationDetails" data-id="'.$key.'" id="activationDetails" class="'.$activation_text_highlighter.' btn btn-sm btn-info span_lg_btn" style="margin-left:5px;"><i class="fa fa-eye"></i></button>
            //     <a class="btn btn-sm btn-warning span_sm_btn" title="Edit" id="edit-bt" href="'.$edit_btn_path.'"><i class="fa fa-pencil"></i></a>
            //     <a class="btn btn-sm btn-success span_sm_btn" title="Ongoing Notes" href="'.$ongoing_notes_url.'"><i class="fa fa-file-text-o"></i></a>
            //     <a class="btn btn-sm btn-dark span_sm_btn" title="All PDFs" href="'.$all_pdfs_url.'"><i class="fa fa-file-pdf-o"></i></a>
            //     <button class="btn btn-sm btn-gray span_sm_btn" title="All Sub User" data-toggle="modal" data-target="#view_all_subuser" data-id="'.$member->id.'" id="getSubUser" style="margin-right: 5px;"><i class="fa fa-users"></i></button>'.$active_inactive.$button_data.'</span>';

            $row[] = '<button data-toggle="modal" data-target="#view-modall" data-id="'.$member->id.'" id="getcredt" class="btn btn-sm btn-primary span_lg_btn" title="Credentials"><i class="fa fa-key"></i></button>
                <button data-toggle="modal" title="Activation Details" onClick="viewDetails('.$member->id.')" data-target="#view-ActivationDetails" data-id="'.$key.'" id="activationDetails" class="'.$activation_text_highlighter.' btn btn-sm btn-info span_lg_btn" style="margin-left:5px;"><i class="fa fa-eye"></i></button>
                <button data-toggle="modal" title="All Sub User" data-target="#view_all_subuser" data-id="'.$member->id.'" data-status="'.$member->status.'" id="getSubUser" class="btn btn-sm btn-gray span_sm_btn" style="margin-right:5px;"><i class="fa fa-users"></i></button>';

            // $field_name
            $get_monthly_volume = $this->db->select($field_name)->where('merchant_id',$member->id)->get('merchant_year_graph_two')->row();
            // echo $this->db->last_query();die;
            // echo '<pre>';print_r($get_monthly_volume);die;

            $row[] = !empty($get_monthly_volume->$field_name) ? '$'.number_format($get_monthly_volume->$field_name,2) : '$0.00';

            if( $_SESSION['user_type']=='wf' ) {
	            $row[] = '<select class="form-control" name="status" id="change_status" data-id="'.$member->id.'" style="font-family: Avenir-Heavy !important;">
	            		<option value="pending" '.(( ($member->status == "pending") || ($member->status == "pending_signup") ) ? "selected" : "") .'>Pending</option>
	                    <option value="active" '.(($member->status == "active") ? "selected" : "") .'>Active</option>
	                    <option value="deactivate" '.(($member->status == "deactivate") ? "selected" : "") .'>Closed</option>
	                </select>';
	        }

            $row[] = '<div class="dropdown dt-vw-del-dpdwn text-right">
            	<button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> 
        		<div class="dropdown-menu dropdown-menu-right">
        			<a href="'.$all_pdfs_url.'" target="_blank" class="dropdown-item">All PDFs</a>
        			<a href="'.$ongoing_notes_url.'" target="_blank" class="dropdown-item">Ongoing Notes</a>
        			<a class="dropdown-item del_merchant" href="javascript:void(0)" data-id="'.$member->id.'" data-name="'.$member->business_dba_name.'">Delete Merchant</a>
        		</div>
        	</div>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->serverside_model->countAll($table),
            "recordsFiltered" => $this->serverside_model->countFiltered($_POST, $column_order, $column_search, $order, $table),
            "data" => $data,
        );
        // echo $this->db->last_query();die;
        echo json_encode($output);
	}

	function update_merchant_status() {
		$responseArr = array();
		$merchant_id = !empty($this->input->post('uid')) ? $this->input->post('uid') : '';
		$status = !empty($this->input->post('status')) ? $this->input->post('status') : '';

		if(!empty($merchant_id)) {
			$data = array('status' => $status);

			$this->db->where('id', $merchant_id);
			$this->db->update('merchant', $data);
			if($this->db->affected_rows() > 0) {
				$responseArr = array(
					'status' => '200',
					'message' => 'Merchant Status Updated Successfully'
				);
			} else {
				$responseArr = array(
					'status' => '500',
					'message' => 'Technical Issue in Updation'
				);
			}
			
		} else {
			$responseArr = array(
				'status' => '500',
				'message' => 'No Merchant Selected. Please try again later.'
			);
		}
		echo json_encode($responseArr);die;
	}

	function get_single_merchant() {
		$id = $this->uri->segment(3);
		$merchant = $this->db->where('id', $id)->get('merchant')->row();

		$get_last_mail = $this->db->where('merchant_id', $id)->order_by('id', 'DESC')->get('agreement_mail_log')->row();
		// print_r($get_last_mail);die;
		if(!empty($get_last_mail)) {
			if($get_last_mail->status == "0") {
				$admin = $this->db->select('name')->where('id', $get_last_mail->admin_id)->get('admin')->row();
				$merchant->last_mail_sent_by = $admin->name;
				$merchant->last_mail_sent_at = date('F, d Y h:i:s', strtotime($get_last_mail->add_datetime));
				$merchant->last_mail_sent_status = $get_last_mail->status;
				
			} else {
				$merchant->last_mail_sent_by = '';
				$merchant->last_mail_sent_at = '';
				$merchant->last_mail_sent_status = '';
			}

		} else {
			$merchant->last_mail_sent_by = '';
			$merchant->last_mail_sent_at = '';
			$merchant->last_mail_sent_status = '';
		}

		$getApplicationDetails = $this->db->where('merchant_id', $id)->get('merchant_api')->row();
		// print_r($getApplicationDetails);die;
		if(!empty($getApplicationDetails)) {
			$datacount = count($getApplicationDetails);
			$applicationstatus = ($datacount > 0) ? $getApplicationDetails->status_message : '';

			$merchant->applicationstatus = $applicationstatus;
			$merchant->merchant_application_id = ($datacount > 0) ? $getApplicationDetails->merchant_application_id: '';

		} else {
			$merchant->applicationstatus = '';
			$merchant->merchant_application_id = '';
		}

		echo json_encode($merchant);
	}

	function inactive_merchant() {
		$responseArr = array();
		$merchant_id = !empty($this->input->post('merchant_id')) ? $this->input->post('merchant_id') : '';

		if(!empty($merchant_id)) {
			$data = array('status' => 'inactive');

			$this->db->where('merchant_id', $merchant_id);
			$this->db->update('merchant', $data);
			if($this->db->affected_rows() > 0) {
				$responseArr = array(
					'status' => '200',
					'message' => 'Merchant Status Updated Successfully'
				);
			} else {
				$responseArr = array(
					'status' => '500',
					'message' => 'Technical Issue in Updation'
				);
			}
			echo json_encode($responseArr);die;
		}
	}

	public function all_sub_merchant() {
		$data = array();
		$data['merchant_id'] = $this->uri->segment(3);
		$data['meta'] = 'View All Sub User';
		// print_r($data); die(); 
		$this->load->view('admin/all_sub_merchant_dash', $data);
	}

	function getAllSubMerchants() {
        $data = $row = array();
		$this->load->model('serverside_model');

		$table = 'merchant';
		$column_order = array('id', 'name', 'email', 'merchant_id', 'dba_name', 'status');
        $column_search = array('business_dba_name','business_name');
        $order = array('id' => 'desc');

        // echo $this->uri->segment(3);die;
        if(!empty($_POST['merchant_id'])) {
			$merchant_id = $_POST['merchant_id'];
			// print_r($v); die(); 
			$memData = $this->serverside_model->getRows_sub_merchant($_POST, $column_order, $column_search, $order, $table, $merchant_id);
		} else {
			$memData = $this->serverside_model->getRows_sub_merchant($_POST, $column_order, $column_search, $order, $table, '');
		}        
        // echo $this->db->last_query();die;
        // echo '<pre>';print_r($memData);die;
        
        $i = $_POST['start'];
        foreach($memData as $member) {
        	// echo $member->status;
            $i++;
        	$key = ($i-1);
            $row = array();
            $row[] = $member->name;
			$row[] = $member->email;
			$row[] = $member->id;
			$row[] = $member->merchant_id;
			$row[] = $member->dba_name;
			$row[] = $member->status;
			$row[] = '<a href="#" data-toggle="modal" data-target="#view-modall" data-id="'.$member->id.'" id="getcredt" class="pos_Status_c badge-btn"><i class="fa fa-eye"></i> Credentials</a>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->serverside_model->countAll_sub_merchant($table, $merchant_id),
            "recordsFiltered" => $this->serverside_model->countFiltered_sub_merchant($_POST, $column_order, $column_search, $order, $table, $merchant_id),
            "data" => $data,
        );
        echo json_encode($output);
	}

	function getSingleSubMerchant() {
        $data = $row = array();
		$this->load->model('serverside_model');

		$table = 'merchant';
		$column_order = array('id', 'name', 'email', 'merchant_id', 'dba_name', 'status');
        $column_search = array('business_dba_name','business_name');
        $order = array('id' => 'desc');

        // echo $this->uri->segment(3);die;
        if(!empty($_POST['merchant_id'])) {
			$merchant_id = $_POST['merchant_id'];
			// print_r($v); die(); 
			$memData = $this->serverside_model->getRows_sub_merchant($_POST, $column_order, $column_search, $order, $table, $merchant_id);
		} else {
			$memData = $this->serverside_model->getRows_sub_merchant($_POST, $column_order, $column_search, $order, $table, '');
		}        
        // echo $this->db->last_query();die;
        // echo '<pre>';print_r($memData);die;
        
        $i = $_POST['start'];
        foreach($memData as $member) {
        	// echo $member->status;
            $i++;
        	$key = ($i-1);
            $row = array();
            $row[] = $member->name;
			$row[] = $member->email;
			$row[] = $member->id;
			$row[] = $member->merchant_id;
			$row[] = $member->dba_name;
			$row[] = $member->status;
			$row[] = '<button data-id="'.$member->id.'" id="getSubUserCreds" data-dismiss="modal" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Credentials</button>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->serverside_model->countAll_sub_merchant($table, $merchant_id),
            "recordsFiltered" => $this->serverside_model->countFiltered_sub_merchant($_POST, $column_order, $column_search, $order, $table, $merchant_id),
            "data" => $data,
        );
        echo json_encode($output);
	}

	public function all_customer_request_original() {
		$data = array();
		if (isset($_POST['mysubmit'])) {
			$employee = '';
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data = $this->admin_model->get_full_details_admin_report_search('customer_payment_request', $date1, $date2, $employee, $status);
		    $data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->admin_model->get_full_details_admin_orderby_new('customer_payment_request');
		}
		// echo $this->db->last_query();die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			// echo '<pre>';print_r($each);die;
			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;
			$package['due_date'] = $each->due_date;
			$package['payment_id'] = $each->invoice_no;
			$package['date_c'] = $each->date_c;
			$package['transaction_id'] = $each->transaction_id;
			$package['mpayment_id'] = $each->payment_id;
			$package['card_type'] = $each->card_type;
			$mem[] = $package;
			if ($package['status'] == "Chargeback_Confirm") {
				$getRefunddata= $this->admin_model->get_refund_transaction($each->merchant_id,$each->invoice_no);
				$package['id'] = $each->id;
				$package['name'] = $each->name;
				$package['merchant_id'] = $each->merchant_id;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
				$package['title'] = $each->title;  
				$package['date'] = $each->refund_date; 
				$package['status'] = "Refund"; 
				$package['payment_type'] = $each->payment_type;
				$package['due_date'] = $each->due_date;
				$package['payment_id'] = $each->invoice_no;
				$package['date_c'] = $each->refund_date ? $each->refund_date : $getRefunddata->add_date;
				$package['transaction_id'] = $each->refund_transaction_id ? $each->refund_transaction_id : $getRefunddata->transaction_id;
				$package['mpayment_id'] = $each->payment_id;
				$package['card_type'] = $each->card_type;
				$mem[] = $package;
			}

		}
		// echo '<pre>';print_r($mem);die;
		array_multisort(array_column($mem, 'date_c'), SORT_DESC, $mem);
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
		$this->load->view('admin/all_customer_request', $data);
	}

	public function all_customer_request() {
		$data = array();
		$data['meta'] = 'Invoice';
		$this->load->view('admin/all_customer_request_dash', $data);
	}
	
	//Invoice Listing
	public function invoice_list() {
		$data = array();
		$_result = $this->invoice_model->get_datatables();
		// echo $this->db->last_query();die;
		$_query = $_result['query'];
		$invoice_list = $_result['result'];
		// echo "<pre>";print_r($_result);die;
		$no = $_POST['start'];
		foreach ($invoice_list as $invoice) {
			$row = array();
			$merchant_name = $this->db->select('business_dba_name')->from('merchant')->where('id', $invoice->merchant_id)->get()->row();
			
			$name = $merchant_name->business_dba_name;
			
			$card_type = $invoice->card_type;
			$typeOfCard = strtolower($card_type);
			switch($typeOfCard) {
			   	case 'discover':
				 	$card_image='discover.png';
				 	break;
			   	case 'mastercard':
				 	$card_image='mastercard.png';
				 	break;
			   	case 'visa':
				 	$card_image='visa.png';
				 	break;
			   	case 'jcb':
				 	$card_image='jcb.png';
				 	break;
			   	case 'maestro':
				 	$card_image='maestro.png';
				 	break;
			   	case 'dci':
				 	$card_image = 'dci.png';
				 	break;
			   	case 'amex':
				 	$card_image='amx.png';
				 	break;
				case 'american express':
                    $card_image = 'amx.png';
                    break;
			   	default :
				 	$card_image='other.png';
			}
			if ($card_image == 'other.png') {
				if ($typeOfCard == "check") {
					$card_image = '<img src="'.base_url().'new_assets/img/check.png" alt="'.$card_type.'" style="display: inline; max-width: 35px;" >';
					$card_image .= ' ('.$invoice->card_no.')';
				} else if($typeOfCard == "cash") {
					$card_image = '<img src="'.base_url().'new_assets/img/cash.png" alt="'.$card_type.'"  style="display: inline; max-width: 35px;">';
				} else {
					$card_image = $card_type;
				}
			} else {
				$card_image = '<img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'" style="display: inline; max-width: 35px;" > ';
				$card_image .= !empty($invoice->card_no) ? ('****' . substr($invoice->card_no, -4)) : '********';
			}

			// if($invoice->merchant_id != '413') {
				$row[] = date("M d Y", strtotime($invoice->date_c));
				$row[] = $invoice->transaction_id;
				$row[] = '<span class="card-type-image" >'.$card_image.'</span>';
				$row[] = $name;
				$row[] = $invoice->mobile_no;
				$row[] = '<span class="status_success"> $'.number_format($invoice->amount, 2).'</span>';

				if ($invoice->status == 'pending') {
					$current_date = date("Y-m-d");
					$due_date = $invoice->due_date;
					if ($current_date > $due_date) {
						$status = '<span class=" badge badge-danger"> Late  </span>';
					} else {
						$status = '<span class="badge badge-warning"> ' . ucfirst($invoice->status) . '  </span>';
					}
				} elseif ($invoice->status == 'confirm' || $invoice->status == 'Chargeback_Confirm') {
					$status = '<span class="badge badge-success"> Confirm </span>';
				} elseif ($invoice->status == 'declined') {
					$status = '<span class="badge badge-danger"> ' . $invoice->status . ' </span>';
				} elseif ($invoice->status == 'Refund') {
					$status = '<span class="badge badge-secondary"> Refunded </span>';
				}

				$row[] = $status;
				$row[] = date("M d Y", strtotime($invoice->due_date));

				if($invoice->status != 'pending') {
					$date_c = date("M d Y", strtotime($invoice->date_c));
				} else {
					$date_c = '';
				}
				$row[] = $date_c;

				$invoice_type = ($invoice->invoice_type == 'custom') ? 'payment' : 'spayment';
				if ($invoice->status == 'pending') {
					// $invoice_receipt = '<a href="'.base_url().$invoice_type.'/' . $invoice->payment_id . '/' . $invoice->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Invoice</a>';
				} elseif ($invoice->status == 'declined') {
					$invoice_receipt = '<a href="'.base_url().$invoice_type.'/' . $invoice->payment_id . '/' . $invoice->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Invoice</a>';
				} elseif ($invoice->status == 'confirm') {
					$invoice_receipt = '<a href="'.base_url().'reciept/' . $invoice->payment_id . '/' . $invoice->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>';
				} elseif ($invoice->status == 'Chargeback_Confirm') {
					$invoice_receipt = '<a href="'.base_url().'reciept/' . $invoice->payment_id . '/' . $invoice->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>';
				} elseif ($invoice->status == 'Refund') {
					$invoice_receipt = '<a href="'.base_url().'refund_reciept/' . $invoice->payment_id . '/' . $invoice->merchant_id .'/'. $invoice->invoice_no .'" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>';
				}
				$row[] = '<div class="dropdown dt-vw-del-dpdwn"> 
							<button type="button" data-toggle="dropdown" aria-expanded="false"> 
								<i class="material-icons"> more_vert</i> 
							</button> 
							<div class="dropdown-menu dropdown-menu-right">'.$invoice_receipt.
								'<a data-toggle="modal" data-target="#view-modal" data-id="'.$invoice->id.'"  class="dropdown-item getUser" href="#">
									<i class="fa fa-eye">
									</i> Detail
								</a>
							</div> 
						</div>';

				$data[] = $row;
			// }
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_model->count_all(),
			"recordsFiltered" => $this->invoice_model->count_filtered(),
			"data" => $data,
		);
		
		echo json_encode($output);
	}

	public function test_report() {
		$start = '2020-12-14';
    	$end = '2021-01-12';


		// $query = $this->db->query("SELECT m.id,m.business_dba_name,fs.amount,fs.hold_amount,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,fs.status,(IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c  <='" . $filters['date2'] . "'),0)) as totalAmount from merchant m left join funding_status fs on (fs.merchant_id=m.id and fs.date >='" . $filters['date'] . "' AND fs.date  <='" . $filters['date2'] . "' )  where  m.user_type='merchant' and m.status='Active' $condtions");

		$whereMerchant = array('user_type'=>'merchant', 'status'=>'Active');
		// $merchantArr = $this->db->select('id,business_dba_name,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account')->where($whereMerchant)->get('merchant')->result_array();
		$merchantArr = $this->db->select('id,business_dba_name,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account')->get_where('merchant', $whereMerchant, 25, 0)->result_array();
		// get_where('merchant', $whereMerchant, 25, 0);
		// echo $this->db->last_query();die;
		// echo '<pre>';print_r($merchantArr);die;
		foreach ($merchantArr as $i => $merchant) {
			// echo '<pre>';print_r($merchant);
			$merchant_id = $merchant['id'];
			$posArr = $this->db->query("select fee,amount from pos where merchant_id=$merchant_id and date_c >='".$start."' AND date_c <='".$end."'")->result_array();
			// echo '<pre>';print_r($posArr);
			$totalPosFee = $totalPosAmt = 0;
			$totalInvFee = $totalInvAmt = 0;
			foreach ($posArr as $pos) {
				$posFee = !empty($pos['fee']) ? $pos['fee'] : 0;
				$posAmt = !empty($pos['amount']) ? $pos['amount'] : 0;

				$totalPosFee = $totalPosFee + $posFee;
				$totalPosAmt = $totalPosAmt + $posAmt;
			}
			// echo $totalPosFee.','.$totalPosAmt.'<br>';
			$invArr = $this->db->query("select fee,amount from customer_payment_request where merchant_id=$merchant_id and date_c >='".$start."' AND date_c <='".$end."'")->result_array();
			// echo '<pre>';print_r($posArr);
			
			foreach ($invArr as $inv) {
				$invFee = !empty($inv['fee']) ? $inv['fee'] : 0;
				$invAmt = !empty($inv['amount']) ? $inv['amount'] : 0;

				$totalInvFee = $totalInvFee + $invFee;
				$totalInvAmt = $totalInvAmt + $invAmt;
			}
			$merchantArr[$i]['totalFee'] = $totalPosFee + $totalInvFee;
			$merchantArr[$i]['totalAmt'] = $totalPosAmt + $totalInvAmt;

			$funding = $this->db->select('amount,hold_amount,status')->where('merchant_id', $merchant_id)->get('funding_status')->row();
			$merchantArr[$i]['funding_amount'] = $funding->amount;
			$merchantArr[$i]['funding_hold_amount'] = $funding->hold_amount;
			$merchantArr[$i]['funding_status'] = $funding->status;
			$merchantArr[$i]['date_c'] = $start;
		}
		echo '<pre>';print_r($merchantArr);die;
	}

	public function report_original($Requestdata = null) {
		$data["title"] = "Admin Panel";
		
		if (isset($_POST['mysubmit'])) {
			//echo '1';die();
			$employee = $_POST['employee'];
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data_full_reporst = $this->admin_model->get_full_reports(array(
				'date' => $date1,
				'date2' => $date2,
				'employee' => $employee,
				'status' => $status,
			));
			$data['reposrint_date'] = $date1;
			$data['full_reporst'] = $package_data_full_reporst;

			$data['employee'] = $employee;
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];

		} else { 
			//echo '2';die();    
			// $package_data = $this->admin_model->get_full_details_admin_report('customer_payment_request');
			//echo $this->db->last_query();die();
			// $package_data1 = $this->admin_model->get_full_details_admin_report('recurring_payment');
			// $package_data2 = $this->admin_model->get_full_details_admin_report('pos');

            //echo '<pre>';print_r($package_data); die();
			$reposrint_date = date("Y-m-d");
			$datetime = new DateTime($reposrint_date);
			$datetime->modify('-1 day');
			$reposrint_date2 = $datetime->format('Y-m-d'); 
			
			if ($Requestdata != null) {
				$reposrint_date = $Requestdata;
			}
			$package_data_full_reporst = $this->admin_model->get_full_reports(array(
				'date' => $reposrint_date2,
				'date2' => $reposrint_date
			));
			//print_r($package_data_full_reporst); die();
			$data['full_reporst'] = $package_data_full_reporst;
			$data['reposrint_date'] = $reposrint_date;

		}
		print_r($data);die;
		
		if ($Requestdata != null) {
			$data['reposrint_date'] = $Requestdata;
		}
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$GrosspaymentValume = 0;
		$TotalFeeCaptured = 0;
		$TotalPayout = 0;
		$TotalTransactions = 0;
		if (!empty($data['full_reporst'])) {
			foreach ($data['full_reporst'] as $key => $full_reporst) {
				if ($full_reporst["totalAmount"] > 0) {
					$firsttimefees = $this->admin_model->getLastpayment(array(
						'date' => $reposrint_date,
						'merchant_id' => $full_reporst['id'],
					));
					$data['full_reporst'][$key]['monthly_fees'] = 0;
					if ($firsttimefees[0]["cnt"] == 0) {
						$data['full_reporst'][$key]['monthly_fees'] = $full_reporst['monthly_fee'];
					}
					$GrosspaymentValume = $GrosspaymentValume + $full_reporst['totalAmount'];
					$TotalFeeCaptured = $TotalFeeCaptured + $full_reporst['feesamoun'] + $data['full_reporst'][$key]['monthly_fees'];
					$TotalTransactions = $TotalTransactions + 1;
				} else {
					$data['full_reporst'][$key]['monthly_fees'] = 0;
				}
			}
		}
		// $this->session->unset_userdata('mymsg');
		
		$data['GrosspaymentValume'] = $GrosspaymentValume;
		$data['TotalFeeCaptured'] = $TotalFeeCaptured;
		$data['TotalTransactions'] = $TotalTransactions;
		//print_r($data);die();
		$this->load->view('admin/report', $data);
	}

	public function report() {
		$data = array();
		$data["title"] = "Admin Panel";
		$data['meta'] = 'Funding Report';

		$data['merchants'] = $this->db->select('id, name')->where(array('status' => 'active', 'user_type' => 'merchant'))->get('merchant')->result_array();
		// echo '<pre>';print_r($data['merchants']);die;
		$this->load->view('admin/report_dash', $data);
	}

	function getMerchantForFunding() {
	   	// echo '<pre>';print_r($getReport);die;
		$this->load->model('report_model');
		$_result = $this->report_model->get_datatables();
		$getReport = $_result['result'];
		$data = array();
		// $data['getReport'] = $getReport;
        
        $date_c = date("Y-m-d");
        $GrossPaymentVolume = 0;
		$TotalFeeCaptured = 0;
		$TotalPayout = 0;
		$TotalTransactions = 0;

        $no = $_POST['start'];
		foreach ($getReport as $key => $report) {
			$row = array();
			$no++;
			// echo '<pre>';print_r($report);
			$report_monthly_fee = !empty($report['monthly_fee']) ? $report['monthly_fee'] : 0;
			if ($report["totalAmount"] > 0) {
				$firsttimefees = $this->admin_model->getLastpayment(array(
					'date' => $date_c,
					'merchant_id' => $report['id'],
				));
				$getReport[$key]['monthly_fees'] = 0;
				if ($firsttimefees[0]["cnt"] == 0) {
					$getReport[$key]['monthly_fees'] = $report_monthly_fee;
				}
				$GrossPaymentVolume = $GrossPaymentVolume + $report['totalAmount'];
				$TotalFeeCaptured = $TotalFeeCaptured + $report['feesamoun'] + $getReport[$key]['monthly_fees'];
				$TotalTransactions = $TotalTransactions + 1;

			} else {
				$getReport[$key]['monthly_fees'] = 0;
			}
			// echo $getReport[$key]['monthly_fees'].'<br>';
			$totalFees=0;
            if($report['totalAmount'] > 0) {
            	$totalFees = $report['feesamoun'] + $report_monthly_fee;
            }

            $rowAmount = $report['totalAmount'] - $totalFees;
            $row[] = '<input type="checkbox" name="chkstatus[]" value="'.$report['id'].'_'.$rowAmount.'">';
            $row[] = '$'.number_format($report['totalAmount'],2);
            $row[] = $report['business_dba_name'];
            $row[] = $report['bank_account'];
            $row[] = '<b class="text-danger">$'.number_format($totalFees,2).'</b>';

			$endAmount = (isset($report['hold_amount']) && $report['hold_amount']!="") ? number_format($report['hold_amount'],2) : '0.00';
			if($report['status'] != '') {
				$payable_hold_amt = number_format(($report['amount']),2).'/'.$endAmount; 
			} else {
				$payable_hold_amt = number_format(($report['totalAmount']-$totalFees),2).'/0.00';
			}
            $row[] = '<b class="text-danger">$'.$payable_hold_amt.'</b>';

            if($report['status'] == 'pending') {
				$report_status = '<span class="badge-btn badge-pink">'.$report['status'].'</span>';
			} elseif ($report['status']=='confirm') {
				$report_status = '<span class="badge-btn badge-success">'.$report['status'].'</span>';
			} else {
				$report_status = '<span class="badge-btn badge-info">UnProcess</span>';
			}
            $row[] = $report_status;
            $row[] = $report['date_c'];

            $rep_modal_amt = ($report['status']!='') ? $report['amount'] : ($report['totalAmount']-$totalFees);
            $row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-date="'.$report['date_c'].'" data-id="'.$report['id'].'" id="getUser" class="btn pos_Status_c btn-first btn-sm custom_btn_pd_a" style="margin-right:10px;color: #fff !important;"><i class="fa fa-eye"></i> View</a>

                <button data-toggle="modal" data-holdamount="'.$report['hold_amount'].'" data-target="#amount-modal" data-amount="'.$rep_modal_amt.'" data-date="'.$report['date_c'].'" data-mid="'.$report['id'].'" id="setamount" class="btn btn-first btn-sm custom_btn_pd"><i class="fa fa-eye"></i> Change Status</button>';

            $data[] = $row;
		}

       	$output = array(  
            "draw"				=> intval($_POST["draw"]),
            "recordsTotal"		=> $this->report_model->count_all(),
            "recordsFiltered"	=> $this->report_model->count_filtered(),
            "data"				=> $data
       	);  
        echo json_encode($output);
    }

    public function getFundingReportSummary() {
    	$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$employee = $this->input->post('employee');
		$status = $this->input->post('status');

		// $this->db->select();
		if (!empty($employee)) {
			$this->db->where('employee', $employee);
		}
		$this->db->from('report_admin');
		$query = $this->db->get();
		$resultArr = $query->result_array();
		// echo '<pre>';print_r($resultArr);die;

		$date_c = date("Y-m-d");
        $GrossPaymentVolume = 0;
		$TotalFeeCaptured = 0;
		$TotalPayout = 0;
		$TotalTransactions = 0;

    	foreach ($resultArr as $key => $report) {
			$report_monthly_fee = !empty($report['monthly_fee']) ? $report['monthly_fee'] : 0;
			if ($report["totalAmount"] > 0) {
				$firsttimefees = $this->admin_model->getLastpayment(array(
					'date' => $date_c,
					'merchant_id' => $report['id'],
				));
				$getReport[$key]['monthly_fees'] = 0;
				if ($firsttimefees[0]["cnt"] == 0) {
					$getReport[$key]['monthly_fees'] = $report_monthly_fee;
				}
				$GrossPaymentVolume = $GrossPaymentVolume + $report['totalAmount'];
				$TotalFeeCaptured = $TotalFeeCaptured + $report['feesamoun'] + $getReport[$key]['monthly_fees'];
				$TotalTransactions = $TotalTransactions + 1;

			} else {
				$getReport[$key]['monthly_fees'] = 0;
			}
			// echo $getReport[$key]['monthly_fees'].'<br>';
			$totalFees=0;
            if($report['totalAmount'] > 0) {
            	$totalFees = $report['feesamoun'] + $report_monthly_fee;
            }
		}
		
		$TotalPayout = $GrossPaymentVolume - $TotalFeeCaptured;
		$data['GrossPaymentVolume'] = '$'.number_format($GrossPaymentVolume, 2);
		$data['TotalFeeCaptured'] = '$'.number_format($TotalFeeCaptured, 2);
		$data['TotalPayout'] = '$'.number_format($TotalPayout, 2);
		$data['TotalTransactions'] = $TotalTransactions;
		// echo '<pre>';print_r($data);die;
		echo json_encode($data);die;
    }

	public function search_record_pos() {
		$searchby = $this->input->post('id');
		$data['item'] = $this->admin_model->data_get_where_1("pos", array(
			"id" => $searchby,
		));

		$data['pay_report'] = $this->admin_model->search_pos($searchby);
		echo $this->load->view('merchant/show_pos', $data, true);
	}

	public function search_record_column2() {
		$id = $this->input->post('id');
		$date = $this->input->post('date');
		// echo '<pre>';print_r($_POST);die;

		// $fundDetails = $this->admin_model->getfundDetails(array(
		// 	"id" => $searchby,
		// 	'date' => $date,
		// ));
		$query = $this->db->query("(select amount,invoice_no,add_date,email_id from pos where merchant_id=".$id." and date_c='".$date."') union (select amount,invoice_no,add_date,email_id from customer_payment_request where merchant_id=".$id." and date_c='".$date."')");
		// echo $this->db->last_query();die;
		$fundDetails = $query->result_array();
		// echo '<pre>';print_r($fundDetails);die;

		// $mem = array();
		// foreach ($fundDetails as $each) {
		// 	$memInt = array();
		// 	$memInt['amount'] = $each['amount'];
		// 	$memInt['invoice_no'] = $each['invoice_no'];
		// 	$memInt['add_date'] = $each['add_date'];
		// 	$memInt['email_id'] = $each['email_id'];
		// 	$mem[] = $memInt;
		// }
		$data['mem'] = $fundDetails;
		echo $this->load->view('admin/fund_modal', $data, true);
	}

	public function search_record_column_recurring() {
		$searchby = $this->input->post('id');
		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('merchant/show_result_recurring', $data, true);
	}

	public function merchant_detail() {
		$data = array();
		$id = $this->uri->segment(3);
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_search($start_date, $end_date, $status, 'customer_payment_request');
		} else {

			$package_data = $this->admin_model->data_get_where('customer_payment_request', array(
				"merchant_id" => $id,
			));
			$merchant_data = $this->admin_model->data_get_where_1('merchant', array(
				"id" => $id,
			));
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;
			$package['due_date'] = $each->due_date;
			$package['payment_id'] = $each->invoice_no;

			$mem[] = $package;
		}
		foreach ($merchant_data as $each1) {

			$package1['id'] = $each1['id'];
			$package1['merchant_name'] = $each1['name'];

			$member[] = $package1;
		}
		$data['mem'] = $mem;
		$data['member'] = $member;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/merchant_detail', $data);
	}

	public function all_customer_request_recurring_original() {
		$data = array();
		$data['meta'] = 'All Customer Recurring Payments';

	 	$merchant_id = $this->session->userdata('merchant_id'); 
		if (isset($_POST['mysubmit'])) {
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data = $this->admin_model->get_full_details_admin_report_search1('customer_payment_request', $date1, $date2, $status);
			// $package_data = $this->admin_model->get_package_details_customer_admin($date1,$date2,$status);
            $data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->admin_model->get_full_details_payment_admin('customer_payment_request');
		}
	    //   echo $this->db->last_query();  die; 
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$package['id'] = $each->id;
			$package['payment_id'] = $each->invoice_no;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['late_fee'] = $each->late_fee;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['due_date'] = $each->due_date;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;
			$package['recurring_payment'] = $each->recurring_payment;
			$package['recurring_type'] = $each->recurring_type;
			$package['recurring_count'] = $each->recurring_count;
			$package['recurring_pay_start_date'] = $each->recurring_pay_start_date;
			$package['recurring_pay_type'] = $each->recurring_pay_type;
			$package['recurring_count_remain'] = $each->recurring_count_remain;
			$package['date_c'] = $each->date_c;
			$mem[] = $package;
		}
		$data['mem'] = $mem;
	 	// echo "<pre>";print_r($data);die;
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');
		$this->load->view('admin/all_customer_request_recurring', $data);
	}

	public function all_customer_request_recurring() {
		$data = array();
		$data['meta'] = 'Recurring List';
		$this->load->view('admin/all_customer_request_recurring_dash', $data);
	}

	public function recurring_list() {
		// echo '<pre>';print_r($_POST);die;
		$data = array();
		$_result = $this->recurring_model->get_datatables();
		
		$_query = $_result['query'];
		$recurring_list = $_result['result'];
		// echo "<pre>";print_r($recurring_list);die;
		$no = $_POST['start'];
		foreach ($recurring_list as $invoice) {
			$row = array();
			
			// if($invoice->merchant_id != '413') {
				$row[] = $invoice->name;
				
				$merchant_name = $this->db->select('name')->from('merchant')->where('id', $invoice->merchant_id)->get()->row();
				// echo $this->db->last_query();die;
				// print_r($merchant_name);die;
				$row[] = !empty($merchant_name) ? $merchant_name->name : '';

				if($invoice->late_fee) {
					$amount = $invoice->amount - $invoice->late_fee;
				} else {
					$amount = $invoice->amount;
				}
				$row[] = '<span class="status_success">$'.number_format($amount,2).'</span>';

				$curentDate = date('Y-m-d');
				$is_prev_paid = $this->db->query("SELECT status FROM customer_payment_request WHERE invoice_no='".$invoice->invoice_no."' AND ( `status`='".$invoice->status."' OR `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC")->num_rows();
				// echo $is_prev_paid;

				$AllPaidRequest = $this->db->query("SELECT invoice_no FROM customer_payment_request WHERE merchant_id='".$invoice->merchant_id."' AND invoice_no='".$invoice->invoice_no."' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm') ORDER BY id DESC")->num_rows();

	            $AllUnPaidRequest=$this->db->query("SELECT invoice_no FROM customer_payment_request WHERE  merchant_id='".$invoice->merchant_id."' AND invoice_no='".$invoice->invoice_no."' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm' ORDER BY id DESC")->num_rows();

	            if( $invoice->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($invoice->recurring_payment=='stop' || $invoice->recurring_payment=='complete' )  && $is_prev_paid <='0') { 
	              	$rec_status = '<span class="status_success">Complete</span>'; //  $recurring_payment = 'complete'; 
	            } else if( $invoice->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($invoice->recurring_payment=='stop' || $invoice->recurring_payment=='complete' ) ) { 
	             	//&& $is_prev_paid <='0'
	              	$rec_status = '<span class="badge badge-success">Complete</span>'; //  $recurring_payment = 'complete'; 
	            } else if( $AllPaidRequest > 0  &&  $invoice->recurring_count != $AllPaidRequest && $AllUnPaidRequest == 0){
	              	$rec_status = '<span class="badge badge-secondary">Good Standing</span>';  /// $recurring_payment = 'good'; 
	            }else if($AllUnPaidRequest > '0' &&  $is_prev_paid > '0'){
	              	$rec_status = '<span class="badge badge-danger">Late</span>';  //$recurring_payment = 'late'; 
	            } else {
	              	$rec_status = '<span class="badge badge-warning">Pending</span>';  //$recurring_payment = 'late'; 
	            }
	            $row[] = $rec_status;

	            $GetFirstRecord = $this->db->query("SELECT recurring_pay_start_date FROM customer_payment_request WHERE  invoice_no='".$invoice->invoice_no."'  ORDER BY id ASC  LIMIT 0,1 "); 
				$DGetFirstRecord = $GetFirstRecord->row_array();
				// echo '<pre>';print_r($DGetFirstRecord);die;
				$row[] = date("M d Y", strtotime($DGetFirstRecord['recurring_pay_start_date']));

				$GetlastRecord = $this->db->query("SELECT recurring_next_pay_date,recurring_count FROM customer_payment_request WHERE merchant_id='".$invoice->merchant_id."' AND  invoice_no='".$invoice->invoice_no."'  ORDER BY id DESC  LIMIT 0,1 "); 
	            $lastRecord = $GetlastRecord->row();
	            // print_r($lastRecord);die;
	            $row[] = date("M d Y", strtotime($lastRecord->recurring_next_pay_date));

	            if($lastRecord->recurring_count < 0 ) {
	            	$recurring_next_pay_date = '<span style="font-size: 25px; text-align: center; padding: 0 0 0 15px;" >&infin; </span>';
	            	$row[] = $recurring_next_pay_date;
	  			} else {
	  				$recurring_count = $invoice->recurring_count;
	        		$recurring_count = $recurring_count - 1;
	        		switch($invoice->recurring_type) {
	              		case 'daily':
	                    	$a=$recurring_count*1; 
	                       	$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." days", strtotime($lastRecord->recurring_next_pay_date)));
	              		break;

	              		case 'weekly':
	                		$a=$recurring_count*7; 
	                
	                		$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a."days", strtotime($lastRecord->recurring_next_pay_date)));
	              		break;

	              		case 'biweekly':
	                 		$a=$recurring_count*14; 
	                		$recurring_next_pay_date=date('Y-m-d', strtotime('+'.$a.' days', strtotime($lastRecord->recurring_next_pay_date)));
	              		break;

	              		case 'monthly':
	                		$a=$recurring_count*1; 
	                		$recurring_next_pay_date=date('Y-m-d', strtotime('+'.$a.' month', strtotime($lastRecord->recurring_next_pay_date)));
	              		break;

	              		case 'quarterly':
	                		$a=$recurring_count*3; 
	                		$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." month", strtotime($lastRecord->recurring_next_pay_date)));
	              		break;

	              		case 'yearly':
	                		$a=$recurring_count*12; 
	                		$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." month", strtotime($lastRecord->recurring_next_pay_date)));
	              		break;

	              		default :
	                		$a=$recurring_count*1; 
	                		$recurring_next_pay_date=date('Y-m-d', strtotime("+".$a." days", strtotime($recurring_pay_start_date)));
	              		break; 
	                }
	              	$row[] = date("M d Y", strtotime($recurring_next_pay_date));
				}

				$recurringCount = (int)($lastRecord->recurring_count);
				$upcomming = ($recurringCount > 0) ? $recurringCount-$AllPaidRequest : '<span style="font-size: 25px;">∞ </span>';
				$row[] = '<span class="status_success upc_span">'.$AllPaidRequest .'</span><span class="num_seprater upc_span"> | </span><span class="pos_Status_pend upc_span">'.$upcomming.'</span>';

				if($invoice->recurring_count == $AllPaidRequest && $AllUnPaidRequest == '0'  && ($invoice->recurring_payment == 'stop' || $invoice->recurring_payment == 'complete') && $is_prev_paid <='0') {
	                $toggle_switch = '<a class="btn btn-sm btn_switch_done"> <i class="fa fa-check"></i> Done</a>';
	            } else {
	            	if($invoice->recurring_payment == 'start') {
	            		$rec_start_active = 'active';
	            	} else {
	            		$rec_start_active = '';
	            	}
	            	if($invoice->recurring_payment == 'start') {
	            		$rec_start_checked = 'checked';
	            	} else if($invoice->recurring_payment == 'stop') {
	            		$rec_start_checked = '';
	            	}
	          		$toggle_switch = '<div class="start_stop_tax '.$rec_start_active.'" rel="'.$invoice->id.'">
	            		<label class="switch switch_type1" role="switch">
	              			<input type="checkbox" class="switch__toggle" '.$rec_start_checked.'>
	              			<span class="switch__label">|</span>
	            		</label>
	        			<span class="msg">
	             		 	<span class="stop">Stop</span>
	                  		<span class="start">Start</span>
	            		</span>
	          		</div>';
	        	}
	      		$row[] = $toggle_switch;

	      		$row[] = ($invoice->recurring_pay_type == '1') ? 'Auto' : 'Manual';

	      		$row[] = '<div class="dropdown dt-vw-del-dpdwn">
	        				<button type="button" data-toggle="dropdown">
	          					<i class="material-icons"> more_vert </i>
	        				</button>
	        				<div class="dropdown-menu dropdown-menu-right">
	        					<a class="dropdown-item pos_vw_refund" href="'.base_url().'dashboard/invoice_details/'.$invoice->invoice_no.'"><span class="fa fa-exchange"></span>  Transactions</a>
	        				</div>
	      				</div>';

				$data[] = $row;
			// }
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->recurring_model->count_all(),
			"recordsFiltered" => $this->recurring_model->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function stop_recurring($id) {
		$this->admin_model->stop_recurring($id);
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	public function start_recurring($id) {
		$this->admin_model->start_recurring($id);
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	//Invoice Details for admin recurring transactions
	public function invoice_details($invoice_no) {
		// echo date('Y-m-d H:i:s');die;
		$data = array();
		$data['meta'] = 'Recurring Payment Request';
		//$merchant_id = $this->session->userdata('merchant_id');
	  	if ($this->input->post('mysubmit')) {
			$curr_payment_date = $_POST['curr_payment_date'];
			$invoice_no = $_POST['invoice_no'];
			$end_date = $_POST['end'];
			$status = $_POST['status'];   
			$data['mem']= $this->admin_model->get_singleGroup_filter_customer_admin($curr_payment_date,$_POST['end'], $status,$invoice_no);
			$data["curr_payment_date"] = $_POST['curr_payment_date']; 
			$data["end"] = $_POST['end'];
		    $data['invoice_no']=$invoice_no; 
			$data["status"] = $_POST['status']; 

            $this->load->view('admin/invoice_details_dash', $data);
		} else if($invoice_no != "") {
			$date = date('Y-m-d', strtotime('-30 days'));
			// if ($merchant_id != '') {
			// 	$this->db->where('merchant_id', $merchant_id);
			// } 
			$this->db->where('payment_type', 'recurring');
			$this->db->where('invoice_no', $invoice_no);
			$this->db->where("payment_type", "recurring");
			//$this->db->where('recurring_next_pay_date >=', $date);
		    $this->db->order_by("id", "desc");
			$data['mem']=$this->db->get('customer_payment_request')->result_array();
			// echo "<pre>";print_r($data);die;
			//print_r(count($data['mem'])); die();       
			$data["curr_payment_date"] = $date; 
			$data["end"] = date('Y-m-d');
			$data["status"] = "";
			$this->load->view('admin/invoice_details_dash', $data);  
		} else {
			redirect(base_url('dashboard/all_customer_request_recurring')); 
		}
	}
	//Search Invoice Detail Receipt
	public function search_invoice_detail_receipt() {
		// $merchant_id = $this->session->userdata('id');
		$searchby = $this->input->post('id');
		// echo $searchby;die;
		$data['invoice_detail_receipt_item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
		$data['invoice_detail_receipt'] = $this->admin_model->search_record($searchby);
		$data['refundData'] = $this->admin_model->data_get_refund("customer_payment_request", $searchby);
		$merchant_id = $data['invoice_detail_receipt'][0]->merchant_id;
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		    $data['merchant_data'] = $getQuery1->result_array();
		// echo "<pre>";print_r($data);die;
		// echo $this->load->view('admin/show_invoice_detail_receipt_admin', $data, true);
		echo $this->load->view('admin/show_invoice_detail_receipt_admin_dash', $data, true);
	}
	
	//Refund Amount from admin
	public function refund() {
		// echo "<pre>";print_r(($_POST)); die();
		$refundfor = $_POST['refundfor'];  
		$merchant_id = $_POST['merchant_id'];  
	 	if($refundfor) {
			// $merchant_id = $this->session->userdata('merchant_id');
			//Data, connection, auth
			# $dataFromTheForm = $_POST['fieldName']; // request data from the form
			$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

			$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
			$getEmail_a = $getQuery_a->result_array();
			$data['$getEmail_a'] = $getEmail_a;
			//print_r($getEmail_a);
			$account_id = $getEmail_a[0]['account_id_cnp'];
			$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			$account_token = $getEmail_a[0]['account_token_cnp'];
			$application_id = $getEmail_a[0]['application_id_cnp'];
			$terminal_id = $getEmail_a[0]['terminal_id'];
			$id = $_POST['id'];
			$invoice_no = $_POST['invoice_no'];
			$amount = $_POST['amount'];
			$transaction_id = $_POST['transaction_id'];
			$payment_id = $_POST['payment_id'];
			$TicketNumber = (rand(100000, 999999));
			$TicketNumber1 = (rand(100000000, 999999999));
			$TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
			// xml post structure
			$xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID>
	            <AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID>
	            </Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
	            <Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
	            <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
	            <TransactionID>" . $transaction_id . "</TransactionID><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $TicketNumber2 . "</ReferenceNumber><TicketNumber>" . $TicketNumber . "</TicketNumber>
	            </Transaction></CreditCardReturn>"; // data from the form, e.g. some ID number

			$headers = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				"SOAPAction: https://transaction.elementexpress.com/",
				"Content-length: " . strlen($xml_post_string),
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
			$arraya = json_decode($json, TRUE);
			
			curl_close($ch);

			// print_r($arraya);  die(); 

			$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
			$card_type = $arraya['Response']['Card']['CardLogo']? $arraya['Response']['Card']['CardLogo'] : '';
			$card_no = $arraya['Response']['Card']['CardNumberMasked'] ? $arraya['Response']['Card']['CardNumberMasked'] : '';
			//  die();
			$date_c = date("Y-m-d");
			// $merchant_id = $this->session->userdata('merchant_id');

			$branch_info = array(
				// 'name' => $name,
				//'email' => $email,
				//'mobile_no' => $mobile,
				'amount' => $amount,
				'transaction_id' => $trans_a_no,
				'card_type' => $card_type,
				'card_no' => $card_no,
				'payment_id' => $payment_id,
				'invoice_no' => $invoice_no,
				//'reason' => $reason,
				'merchant_id' => $merchant_id,
				'date_c' => $date_c,
				'type' => $refundfor,
				'status' => 'confirm',
				'c_type' => 'CNP',
			);
			$branch_inf = array(
				'status' => 'Chargeback_Confirm',
			);
			// $id1 = $this->admin_model->insert_data("refund", $branch_info);
			// $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));
			if ($arraya['Response']['ExpressResponseMessage'] == 'Approved') {
				$id1 = $this->admin_model->insert_data("refund", $branch_info);
				$m = $this->admin_model->update_data('customer_payment_request', $branch_inf, array('id' => $id));
				//Refund receipt mail
				$getQuery = $this->db->query("SELECT * from customer_payment_request where id='$id' ");
				$getEmail = $getQuery->result_array();
				$data['getEmail'] = $getEmail;
				$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' ");
				$getEmail1 = $getQuery1->result_array(); 
				$data['getEmail1'] = $getEmail1;
				$data['resend'] = "";  
				$data['refund_data'] = $branch_info; 
				$email = $getEmail[0]['email_id']; 
				$amount = $getEmail[0]['amount']; 
				$sub_total = $getEmail[0]['sub_total'];
				$tax = $getEmail[0]['tax']; 
				$originalDate = $getEmail[0]['date_c']; 
				$newDate = date("F d,Y", strtotime($originalDate));
				$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
				//Email Process
				$data['invoice_detail_receipt_item'] = $item;  
				$data['email'] = $getEmail[0]['email_id'];
				$data['color'] = $getEmail1[0]['color'];  
				$data['amount'] = $getEmail[0]['amount'];
				$data['sub_total'] = $getEmail[0]['sub_total']; 
				$data['tax'] = $getEmail[0]['tax']; 
				$data['originalDate'] = $getEmail[0]['date_c']; 
				$data['card_a_no'] = $card_a_no; 
				$data['trans_a_no'] = $trans_a_no; 
				$data['card_a_type'] = $card_a_type;
				$data['message_a'] = $message_a;
				$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
				$data['late_fee'] = $getEmail[0]['late_fee'];
				$data['payment_type'] = 'recurring';
				$data['recurring_type'] = $getEmail[0]['recurring_type'];
				$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
				$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
				$data['msgData'] = $data;
				$msg = $this->load->view('email/refund_receipt', $data, true);
				$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
				$email = $email;
				$MailSubject = ' Refund Receipt from ' . $getEmail1[0]['business_dba_name'];
                $nameoFCustomer=$getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id']; 
				$MailSubject2 = ' Refund Receipt to ' .$nameoFCustomer;
				
				if (!empty($email)) {
					$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
					$this->email->to($email);
					$this->email->subject($MailSubject);
					$this->email->message($msg);
					$this->email->send();
				}
	            $this->session->set_flashdata('msg', '<div class="text-success text-center"> Amount Refunded Successfully.. </div>');
	            if($refundfor=='straight') {
					redirect(base_url().'dashboard/all_customer_request');
				} else {
					redirect(base_url() . 'dashboard/invoice_details/'.$invoice_no);
				}
			} else {
				// $id = $arraya['Response']['ExpressResponseMessage'];
				// redirect('payment_error/' . $id);
				$id = $arraya['Response']['ExpressResponseMessage'];
				$this->session->set_flashdata('msg', '<div class="text-danger text-center"> '.$arraya['Response']['ExpressResponseMessage'].' </div>');
				if($refundfor=='straight') {
					redirect(base_url().'dashboard/all_customer_request');
				} else if($refundfor=='recurring') {
                    redirect(base_url('dashboard/all_customer_request_recurring'));
				}
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="text-danger text-center">Refund :  Type of Invoice  id Required..</div>');
			redirect(base_url().'dashboard/invoice_details/'.$invoice_no); 
			
	 	}
		// if(empty($trans_a_no)){
		//      $id='Refund Fail';
		//   redirect('payment_error/'.$id);
		//   }
		//   else
		//   {
		//   $id1 = $this->admin_model->insert_data("refund", $branch_info);
		//   $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));

		//   redirect(base_url().'pos/all_customer_request');
		//   }
	}
	
	//Resend invoice
	public function re_invoice() {
		$rowid = $this->input->post('rowid');
		if($rowid) {
		    $this->db->where('status','pending'); 
			$this->db->where('id',$rowid);  
			$getrequest=$this->db->get('customer_payment_request')->result_array();
			// echo "<pre>";print_r($getrequest);die;
			$data = array(
				'name' => $getrequest[0]['name'],
				'invoice_no' => $getrequest[0]['invoice_no'],
				'sub_total' => $getrequest[0]['sub_total'],
				'tax' => $getrequest[0]['tax'],
				'fee' => $getrequest[0]['fee'],
				's_fee' => $getrequest[0]['s_fee'],
				'email_id' => $getrequest[0]['email_id'],
				'mobile_no' => $getrequest[0]['mobile_no'],
				'amount' => $getrequest[0]['amount'],
				'title' => $getrequest[0]['title'],
				'detail' => $getrequest[0]['detail'],
				'note' => $getrequest[0]['note'],
				'url' => $getrequest[0]['url'],
				'payment_type' => 'straight',
				'recurring_type' => $getrequest[0]['recurring_type'],
				'recurring_count' => $getrequest[0]['recurring_count'],
				'recurring_count_paid' => '0',
				'recurring_count_remain' => $getrequest[0]['recurring_count_remain'],
				'due_date' => $getrequest[0]['due_date'],
				'reference' => $getrequest[0]['reference'],
				'merchant_id' => $getrequest[0]['merchant_id'],
				'sub_merchant_id' => $getrequest[0]['sub_merchant_id'],
				'payment_id' => $getrequest[0]['payment_id'],
				'recurring_payment' => $getrequest[0]['recurring_payment'],
				'recurring_pay_start_date' => $getrequest[0]['recurring_pay_start_date'],
				'year' => $getrequest[0]['year'],
				'month' => $getrequest[0]['month'],
				'time1' => $getrequest[0]['time1'],
				'day1' => $getrequest[0]['day1'],
				'status' => 'pending',
				'date_c' => $getrequest[0]['date_c'],
				'add_date' => $getrequest[0]['add_date'],
			);
			if(count($getrequest)) { 
			    $merchantid=$getrequest[0]['merchant_id'];  

			    $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchantid . "' ");
				$getDashboardData_m = $getDashboard_m->result_array();
			}
			// print_r($getrequest);  die(); 
			if($getrequest && $getDashboardData_m) {  
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
				$data['recurring_type'] = $getrequest[0]['recurring_type'];
				$data['no_of_invoice'] = $getrequest[0]['no_of_invoice'];
				$data['recurring_count'] = $getrequest[0]['recurring_count'] ? $getrequest[0]['recurring_count'] : '&infin;';
				$getitem = $this->admin_model->data_get_where_1("order_item", array("p_id" => $getrequest[0]['id']));
					$item_Detail_1 = array(
						"p_id" => $getitem[0]['p_id'],
						"item_name" => ($getitem[0]['item_name']),
						"quantity" => ($getitem[0]['quantity']),
						"price" => ($getitem[0]['price']),
						"tax" => ($getitem[0]['tax']),
						"tax_id" => ($getitem[0]['tax_id']),
						"tax_per" => ($getitem[0]['tax_per']),
						"total_amount" => ($getitem[0]['total_amount']),
					);
					$data['item_detail'] = $item_Detail_1;
					$data['msgData'] = $data;
					$msg = $this->load->view('email/invoice', $data, true); 
						
					$email = $getrequest[0]['email_id'];
					$mobile_no=$getrequest[0]['mobile_no']; 
					$name=$getrequest[0]['name']; 
					$url=$getrequest[0]['url'];
					$amount=$getrequest[0]['amount'];
					$MailTo = $email;
					
				    $MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
					if (!empty($email)) {
						$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
						$this->email->to($MailTo);
						$this->email->subject($MailSubject);
						$this->email->message($msg);
						$this->email->send();
					}


				if (!empty($mobile_no)) {
					$sms_reciever = $mobile_no;
					//$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
					$sms_message = trim(" Hello '" .$name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");

					$from = '+18325324983'; //trial account twilio number
					// $to = '+'.$sms_reciever; //sms recipient number
					$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
					$to = '+1' . $mob;
					$response = $this->twilio->sms($from, $to, $sms_message);
				}
                echo "200";
			}
		}
	}
	
	//Resend Receipt
	public function re_receipt(){
     	$rowid = $this->input->post('rowid');   
	 	$type = $this->input->post('type');
	 	if($type=='request') {
       		$table1='customer_payment_request'; 
 		} else if($type=='all_request') {
			$table1='pos'; 
	 	}

		if($rowid) {
		   	// $this->db->where('status','confirm'); 
		   	//  $this->db->where('id',$rowid); 
			$data['getEmail']=$getEmail=$this->db->query("SELECT * FROM $table1 WHERE ( `status`='confirm' OR `status`='Chargeback_Confirm')  AND  id='$rowid'   ")->result_array();
			//print_r($getEmail);  die();  
			if(count($getEmail)) {
				$merchantid=$getEmail[0]['merchant_id'];  

				$getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchantid."'  ");
				$getEmail1 =$getQuery_a->result_array();
				$data['getEmail1'] = $getEmail1;  
				//print_r($getEmail1);  die(); 
			}
			//print_r($getEmail);  die(); 
			if($getEmail && $getEmail1) {
				$data['email'] = $getEmail[0]['email_id'];  
				$data['color'] = $getEmail1[0]['color']?$getEmail1[0]['color']: '#000';
				$data['amount'] = $getEmail[0]['amount'];
				$data['sub_total'] = $getEmail[0]['sub_total'];
				$data['tax'] = $getEmail[0]['tax']; 
				$data['originalDate'] = $getEmail[0]['date_c'];
				$data['card_a_no'] = $getEmail[0]['card_no'];
				$data['trans_a_no'] = $getEmail[0]['transaction_id'];
				$data['card_a_type'] = $getEmail[0]['card_type'];
				$data['message_a'] = $getEmail[0]['status'];
				$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
				$data['late_fee'] = $getEmail[0]['late_fee'];
				$data['payment_type'] = 'recurring';
				$data['recurring_type'] = $getEmail[0]['recurring_type'];
				$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
				$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
				$data['msgData'] = $data;
				$itemslist=array(); 
				if($type=='all_request'){
					$invoice_no=$getEmail[0]['invoice_no'];
					$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$invoice_no'");
					$itemslist = $getQuery1->result_array();
					$data['invoice_detail_receipt_item'] = $itemslist;
					$data['itemlisttype'] = 'pos';
				}elseif($type=='request') { 
					$data['invoice_detail_receipt_item']=$this->db->query("SELECT * FROM order_item WHERE  p_id='$rowid' ")->result_array();
					$data['itemlisttype'] = 'request';
				} else{
					$data['pos_item'] =array();
					$data['itemlisttype'] = '';
				}
				$msg = $this->load->view('email/receipt', $data, true); 
				$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);

				$email=$getEmail[0]['email_id'];
				$merchant_email=$getEmail1[0]['email']; 
				$MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
				$customername=$getEmail[0]['name']?$getEmail[0]['name']:$getEmail[0]['email_id']; 
				$MailSubject2 =  'Receipt to '.$customername;
				
			
				if(!empty($email)){ 
					$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
					$this->email->to($email);
					//$this->email->attach($filename);
				    $this->email->subject($MailSubject);
					$this->email->message($msg);
				    $this->email->send();
 
					 }
                
				

			      if(!empty($merchant_email)){ 
					 $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
					 $this->email->to($merchant_email);
					 $this->email->subject($MailSubject2);
					 $this->email->message($merchnat_msg);
					 $this->email->send();
					 }

					 if($type=='request')
					 {
					    $url=$getEmail[0]['url'];
					    $purl = str_replace('payment', 'reciept', $url);
					 }
					 else if($type=='all_request')
					 {
						$business_dba_name=$getEmail1[0]['business_dba_name']; 
						$invoice_no=$getEmail[0]['invoice_no'];
						$purl=" '" . $business_dba_name . "' POS Invoice No :: '" . $invoice_no . "' Your Amount ::'" . $data['amount'] . "' Payment date :: '" . $data['originalDate'] . "' Transaction id ::'" . $data['trans_a_no'] . "' Card type :: '" . $data['card_a_type'] . "' ";
					}
					//print_r($getEmail[0]['mobile_no']);  die(); 
					 if(!empty($getEmail[0]['mobile_no'])){ 

						//$sms_sender = trim($this->input->post('sms_sender'));
		 
						$sms_reciever = $getEmail[0]['mobile_no'];
		 
						//$sms_message = trim('Payment Receipt : '.$purl);
		                $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
						$from = '+18325324983'; //trial account twilio number
		 
						// $to = '+'.$sms_reciever; //sms recipient number
		 
						$mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
		 
						$to = '+1'.$mob;
		 
						$response = $this->twilio->sms($from, $to,$sms_message);
		 
						}
                       
				 echo "200";
			} else{
				echo "500";
			}
		} else {
			echo "500";
		}
	}
	//End Recurring Feature in Admin
	public function stop_package() {
		$pak_id = $this->uri->segment(3);

		if ($this->admin_model->stop_recurring($pak_id)) {
			$this->session->set_userdata("mymsg", "Recurring Has Been Stop.");
		}
	}
	public function start_package() {
		$pak_id = $this->uri->segment(3);

		if ($this->admin_model->start_recurring($pak_id)) {
			$this->session->set_userdata("mymsg", "Recurring Has Been Start.");
		}
	}

	public function all_recurrig_request() {
		$data = array();
		$data['meta'] = 'Recurring Request List';
		$merchant_id = $this->session->userdata('merchant_id');

		if ($this->input->post('mysubmit')) {
			$curr_payment_date = $_POST['curr_payment_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_recurring_details_payment_admin($curr_payment_date, $status);
		} else {
			$package_data = $this->admin_model->get_recurring_details_payment_admin1();
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$package['rid'] = $each->rid;
			$package['cid'] = $each->cid;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
        $this->load->view('admin/all_recurrig_request_dash', $data);
	}

	public function delete_package() {
		$pak_id = $this->uri->segment(3);
		if ($this->admin_model->delete_package($pak_id)) {
			$this->session->set_userdata("mymsg", "Data Has Been Deleted.");
		}
	}

	public function getmerchantDetails() {
		$merchant_id=$this->input->post('merchant_id')?$this->input->post('merchant_id'):'699'; 
		// echo $_REQUEST['merchant_id'];
		// echo "<br/>";
		// echo $merchant_id;  die();  
		//$merchant_id=280;
		
		$getdataOfApi=$this->db->query("SELECT * FROM  merchant_api WHERE merchant_id='$merchant_id'  ")->result_array(); 
		if(count($getdataOfApi) > 0) {
			$merchantApplicationId=$getdataOfApi[0]['merchant_application_id'];
		}
		//$merchantApplicationId=8000; 
		if($merchantApplicationId!='') {
			$url='https://merchantapp.io/salequicktest/api/v1/MerchantApplication/MerchantApplicationDetails?merchantApplicationId='.$merchantApplicationId; 
			//echo json_encode($m);   die; 
			$ch = curl_init();   
			$body = '{}';
			$headers = array(
			   //  "Accept-Encoding: gzip", 
			   //  "Content-Type: application/json",
				"X-AuthenticationKeyId: a626be59-d58b-4f33-8050-104107dfb68f",
				"X-AuthenticationKeyValue: Q8n1!RGbn-5YAEA^s0s6AMrKZoPRuqLoBx2GKW15huKXOvwLq~*vJQqC7REdXviE"
			);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
			curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($m));           
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response     = curl_exec ($ch);
			$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$err = curl_error($ch);
			 //$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
			 //$jsondata = json_encode($response);
			$responceArrayData =json_decode($response, true); 
			curl_close($ch);
   
			//echo  $statusCode;
			if ($err) {
			  echo json_encode("cURL Error #:" . $err);
			} else {
				 //$responceArrayData;
				 //print_r($responceArrayData['ApplicationStatus']);
				 //print_r($responceArrayData['ApplicationStatusLabel']);
				 $dataUp=array(
					 'status'=>$responceArrayData['ApplicationStatus']?$responceArrayData['ApplicationStatus']:'',
					 'status_message'=>$responceArrayData['ApplicationStatusLabel']?$responceArrayData['ApplicationStatusLabel']:''
				 );

				 
				 $this->db->where('merchant_id',$merchant_id);
				 $this->db->where('merchant_application_id',$merchantApplicationId);
				 $up=$this->db->update('merchant_api',$dataUp);
				//   echo json_encode(988);
                //  echo json_encode($up);  die(); 
				 if($up)
				 {
					//  print_r($responceArrayData);  die(); 
					//echo $response; 

					echo json_encode($responceArrayData); 
					// echo json_encode(array('ApplicationStatus'=>101));

					//echo json_encode(array('ApplicationStatus'=>$responceArrayData['ApplicationStatus'],'ApplicationStatusLabel'=>$responceArrayData['ApplicationStatusLabel'],)); 
				    die();  
				} 
				 else
				 {
					echo json_encode(array('ApplicationStatus'=>600));  die(); 
				 } 
			   
		   }
			echo json_encode(array('ApplicationStatus'=>400));
		}
		else
		{
            echo json_encode(array('ApplicationStatus'=>400));
		}
		
	}

	public function merchant_api() {
		// echo json_encode($_POST); die();
		// echo '<pre>';print_r($_POST);die;
		$admin_id = $this->session->userdata('id');
        
		if(isset($_POST)) {
			// echo '<pre>';print_r($_POST);die;
			//echo $this->input->post('checkbox')? $this->input->post('checkbox'):''; die(); 
			//primary
			$pc_name =$this->input->post('pc_name')? $this->input->post('pc_name'):'';
			$pc_title =$this->input->post('pc_title')? $this->input->post('pc_title'):'';
			$pc_email =$this->input->post('pc_email')? strtolower($this->input->post('pc_email')):'';
			$pc_phone =$this->input->post('pc_phone')? $this->input->post('pc_phone'):'';
			$pc_address =$this->input->post('pc_address')? $this->input->post('pc_address'):'';

			//business
			$business_name =$this->input->post('business_name')? $this->input->post('business_name'):'';
			$business_dba_name =$this->input->post('business_dba_name')? $this->input->post('business_dba_name'):'';
			$taxid =$this->input->post('taxid') ? $this->input->post('taxid'):'';
			$country =$this->input->post('busi_country') ? $this->input->post('busi_country'):'';
			$address1 =$this->input->post('address1') ? $this->input->post('address1'):'';
			// $address2 = isset($_POST['address2']) ? $_POST['address2'] : '';
			$city =$this->input->post('busi_city') ? $this->input->post('busi_city'):'';
			$state =$this->input->post('busi_state') ? $this->input->post('busi_state'):'';
			$zip =$this->input->post('busi_zip') ? $this->input->post('busi_zip'):'';
			$ownershiptype =$this->input->post('ownershiptype')? $this->input->post('ownershiptype'):'';
			$business_type =$this->input->post('business_type')? $this->input->post('business_type'):'';
			$establishmentdate =$this->input->post('establishmentdate')? $this->input->post('establishmentdate'):'';
			$business_number =$this->input->post('business_number')? $this->input->post('business_number'):'';
			$customer_service_phone =$this->input->post('customer_service_phone')? $this->input->post('customer_service_phone'):'';
			$business_email =$this->input->post('business_email')? strtolower($this->input->post('business_email')):'';
			$customer_service_email =$this->input->post('customer_service_email')? strtolower($this->input->post('customer_service_email')):'';
			// $website = !empty($this->input->post('website')) ? 'https://'.$this->input->post('website'):'';
			$website = !empty($this->input->post('website')) ? 'https://'.str_replace("https://", "", $this->input->post('website')) : '';

			//owner
			$name =$this->input->post('o_f_name')? $this->input->post('o_f_name'):'';
			$m_name = isset($_POST['o_m_name']) ? $_POST['o_m_name'] : '';
			$l_name =$this->input->post('o_l_name')? $this->input->post('o_l_name'):'';
			// $o_question = isset($this->input->post('o_question')) ? 'True' : 'False';
			// $is_primary_owner = isset($this->input->post('is_primary_owner')) ? 'True' : 'False';
			$o_question = ($_POST['o_question'] == '1') ? 'True' : 'False';
			$is_primary_owner = ($_POST['is_primary_owner'] == '1') ? 'True' : 'False';
			// echo $o_question.','.$is_primary_owner;die;
			// echo 'hello';die;
			$o_ss_number =$this->input->post('o_ss_number')? $this->input->post('o_ss_number'):'';
			$o_percentage =$this->input->post('o_perc')? $this->input->post('o_perc'):'';
			$o_dob =$this->input->post('o_dob')? $this->input->post('o_dob'):'';
			$o_country =$this->input->post('o_country')? $this->input->post('o_country'):'';
			$o_address1 =$this->input->post('o_address1')? $this->input->post('o_address1'):'';
			// $o_address2 = isset($_POST['o_address2']) ? $_POST['o_address2'] : '';
			$o_city =$this->input->post('o_city')? $this->input->post('o_city'):'';
			$o_state =$this->input->post('o_state')? $this->input->post('o_state'):'';
			$o_zip =$this->input->post('o_zip')? $this->input->post('o_zip'):'';
			$o_phone =$this->input->post('o_phone')? $this->input->post('o_phone'):'';
			$o_email =$this->input->post('o_email')? strtolower($this->input->post('o_email')):'';

			//banking
			// $bank_dda =$this->input->post('bank_dda')? $this->input->post('bank_dda'):'';
			// $bank_ach =$this->input->post('bank_ach')? $this->input->post('bank_ach'):'';
			// $bank_routing =$this->input->post('bank_routing')? $this->input->post('bank_routing'):'';
			// $bank_account =$this->input->post('bank_account')? $this->input->post('bank_account'):'';
			// $question =$this->input->post('question')? $this->input->post('question'):'';
			// $billing_descriptor =$this->input->post('billing_descriptor')? $this->input->post('billing_descriptor'):'';

			// //pricing
			// $dis_trans_fee =$this->input->post('dis_trans_fee')? $this->input->post('dis_trans_fee'):'0';
			// $amexrate =$this->input->post('amexrate')? $this->input->post('amexrate'):'0';
			// $chargeback =$this->input->post('chargeback')? $this->input->post('chargeback'):'0';
			// $monthly_gateway_fee =$this->input->post('monthly_gateway_fee')? $this->input->post('monthly_gateway_fee'):'0';
			// $annual_cc_sales_vol =$this->input->post('annual_cc_sales_vol')? $this->input->post('annual_cc_sales_vol'):'0';
			// // $monthly_fee =$this->input->post('monthly_fee')? $this->input->post('monthly_fee'):'0';
			// $vm_cardrate =$this->input->post('vm_cardrate') ? $this->input->post('vm_cardrate'):'0';
			// $annual_processing_volume =$this->input->post('annual_processing_volume')? $this->input->post('annual_processing_volume'):'';
			// $cnp_percent =$this->input->post('cnp_percent')? $this->input->post('cnp_percent'):'';
			// $cp_percent =$this->input->post('cp_percent')? $this->input->post('cp_percent'):'';
			// $average_ticket =$this->input->post('average_ticket')? $this->input->post('average_ticket'):'';
			// $high_ticket =$this->input->post('high_ticket')? $this->input->post('high_ticket'):'';

			// $billing_structure =$this->input->post('billing_structure')? $this->input->post('billing_structure'):'';
			// $fee_structure =$this->input->post('fee_structure')? $this->input->post('fee_structure'):'';
			// $percentage_rate =$this->input->post('percentage_rate')? $this->input->post('percentage_rate'):'';
			// $transaction_rate =$this->input->post('transaction_rate')? $this->input->post('transaction_rate'):'';

			// //other
			// $checkbox =$this->input->post('mycheckbox')? $this->input->post('mycheckbox'):'';
			$key =$this->input->post('key')? $this->input->post('key'):'';
			// $activation_id =$this->input->post('activation_id')? $this->input->post('activation_id'):'';

            // echo json_encode($checkbox);
			// die();
			// echo $address1  .','. $amexrate  .','.  $annual_cc_sales_vol  .','. $annual_processing_volume .','. $bank_account .','. $bank_ach .','. $bank_dda  .','. $bank_routing .','. $billing_descriptor .','.  $business_dba_name .','.  $business_email .','. $business_name .','. $business_number .','. $business_type .','. $chargeback  .','. $city .','. $country .','. $customer_service_email .','. $customer_service_phone .','.  $dis_trans_fee   .','. $establishmentdate .','. $key .','. $monthly_fee   .','. $monthly_gateway_fee  .','. $checkbox  .','. $name .','. $o_address1 .','. $o_dob .','. $o_email .','. $o_phone  .','. $o_ss_number .','. $ownershiptype .','. $pc_address .','. $pc_email .','. $pc_name .','. $pc_phone  .','. $pc_title .','. $question .','. $taxid .','. $vm_cardrate  .','.  $website;die;
			
			// if($pc_name && $pc_title && $pc_address && $pc_email && $pc_phone && $monthly_fee && $vm_cardrate && $dis_trans_fee && $amexrate
			//  && $chargeback && $monthly_gateway_fee && $annual_cc_sales_vol && $checkbox && $question && $billing_descriptor ) {
	       	//echo json_encode(array('Status'=>$this->input->post('amexrate')));die; 
			if($address1   &&  $business_dba_name &&  $business_email && $business_name 
		  	&& $business_number && $business_type &&  $city && $country && $customer_service_email
		   	&& $customer_service_phone &&  $establishmentdate && $key && 
			$name && $o_address1 && $o_dob && $o_email && $o_phone  && $o_ss_number && $ownershiptype && $pc_address 
			&& $pc_email && $pc_name && $pc_phone  &&  $pc_title && $o_question && $taxid ) { 
			   	$data=array(
			   		'pc_name' =>$pc_name,
					'pc_title' =>$pc_title,
					'pc_email' =>$pc_email,
					'pc_phone' =>$pc_phone,
					'pc_address' =>$pc_address,

					'business_name' =>$business_name,
					'business_dba_name' =>$business_dba_name,
					'taxid' =>$taxid,
					'country' =>$country,
					'address1' =>$address1,
					// 'address2' =>$address2,
					'city' =>$city,
					'state' =>$state,
					'zip' =>$zip,
					'ownershiptype' =>$ownershiptype,
					'business_type' =>$business_type,
					'year_business' =>substr($establishmentdate,0,4),
					'month_business' =>substr($establishmentdate,5,2),
					'day_business' =>substr($establishmentdate,8,2),
					'business_number' =>$business_number,
					'customer_service_phone' =>$customer_service_phone,
					'business_email' =>$business_email,
					'customer_service_email' =>$customer_service_email,
					'website' =>$website,

					'name' =>$name,
					'o_name'=>$name,
					'm_name' =>$m_name,
					'l_name' =>$l_name,
					'o_question' =>$o_question,
					'is_primary_owner' =>$is_primary_owner,
					'o_ss_number' =>$o_ss_number,
					'o_percentage' => $o_percentage,
					'dob' =>$o_dob,
					'o_dob_y' =>substr($o_dob,0,4),
					'o_dob_m' =>substr($o_dob,5,2),
					'o_dob_d' =>substr($o_dob,8,2),
					'o_address' =>$o_address1,
					'o_address1' =>$o_address1,
					// 'o_address2' =>$o_address2,
					'o_city' =>$o_city,
					'o_state' =>$o_state,
					'o_zip' =>$o_zip,
					'o_phone' =>$o_phone,
					'o_email' =>$o_email,

					// 'bank_dda' =>$bank_dda,
					// 'bank_ach' =>$bank_ach,
					// 'bank_routing' =>$bank_routing,
					// 'bank_account' =>$bank_account,
					// 'question' =>$question,
					// 'billing_descriptor' =>$billing_descriptor,
					
					// 'dis_trans_fee' =>$dis_trans_fee,
					// 'amexrate' =>$amexrate,
					// 'chargeback' =>$chargeback,
					// 'monthly_gateway_fee'=> $monthly_gateway_fee,
					// 'annual_cc_sales_vol' =>$annual_cc_sales_vol,
					// 'monthly_fee' =>$monthly_fee,
					// 'vm_cardrate' =>$vm_cardrate,
					// 'annual_processing_volume' =>$annual_processing_volume,
					// 'cnp_percent' =>$cnp_percent,
					// 'cp_percent' =>$cp_percent,
					// 'average_ticket' =>$average_ticket,
					// 'high_ticket' =>$high_ticket,
					// 'billing_structure' =>$billing_structure,
					// 'fee_structure' =>$fee_structure,
					// 'percentage_rate' =>$percentage_rate,
					// 'transaction_rate' =>$transaction_rate,
					// 'key' =>$key,
					// 'checkbox' => $checkbox ? 'true':'false',
			   	);
			   	// echo '<pre>';print_r($data);die;

				$id=$this->input->post('key')?$this->input->post('key'):'';
				$this->db->where('id', $id);
				$up=$this->db->update('merchant', $data);
			   	// echo $this->db->last_query();die;

				$getdata=$this->db->select('email')->where('id', $id)->get('merchant')->row();
				// print_r($getdata);die;
				// echo $getdata->email;die;
				//echo json_encode($up);  die(); 
				//echo json_encode($id);  die(); 
				if($up) {
					$mail_verify_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890", mt_rand(0, 51), 1) . substr(md5(time()), 1);
					// echo $verify_key;die;

					// $mail_count = $this->db->where('merchant_id', $id)->get('agreement_verification')->num_rows();
					$mail_arr = $this->db->where('merchant_id', $id)->get('agreement_verification')->row();
					
					if(!empty($mail_arr)) {
						if($mail_arr->verification_status == 'done') {
							$up_mail = array(
								'mail_verify_key' => $mail_verify_key,
								'verification_status' => ''
							);

							$this->db->where('merchant_id', $id);
							$this->db->update('agreement_verification', $up_mail);
							
						} else {
							$up_mail = array(
								'mail_verify_key' => $mail_verify_key
							);

							$this->db->where('merchant_id', $id);
							$this->db->update('agreement_verification', $up_mail);
						}

					} else {
						$ins_mail = array(
							'mail_verify_key' => $mail_verify_key,
							'merchant_id' => $id,
							'verification_status' => ''
						);
						$this->db->insert('agreement_verification', $ins_mail);
					}

					$new_email = strtolower($getdata->email);
					// $mail_temp['merchant_id'] = '894';
					// $mail_temp['auth_key'] = 'be63ed6a-69eb-437c-b026-c4a4c4b81ee7';
					$mail_data['url'] = base_url().'Merchant_agreement/index/'.$id.'/'.$mail_verify_key;
					// $mail_data['email'] = $new_email;
					$mail_data['business_dba_name'] = $business_dba_name;
					$subject = 'Salequick - Merchant Agreement';
					$mail_temp = $msg = $this->load->view('email/agreement_mail', $mail_data, true);

					// $business_email
					$this->email->from('info@salequick.com', 'Admin - Salequick');
                    // $this->email->to('amir.proget@gmail.com');
                    $this->email->to($new_email);
                    $this->email->subject($subject);
                    $this->email->message($mail_temp);
                    if($this->email->send()) {
                    	$mail_ins_data = array(
                    		'admin_id' => $admin_id,
                    		'merchant_id' => $id
                    	);
                    	$this->db->insert('agreement_mail_log', $mail_ins_data);

                    	echo json_encode(array('Status'=>30));
                    } else {
                    	echo json_encode(array('Status'=>'mail_not_send'));
                    }
					
				} else {
	                echo json_encode(array('Status'=>600));   
				}

			} else {
				echo json_encode(array('Status'=>40)); 
			}

		} else {
            echo json_encode(array('Status'=>400));   
		}
	}

	public function update_merchant_details() {
		if(isset($_POST)) {
			// echo '<pre>';print_r($_POST);die;
			//primary
			$pc_name =$this->input->post('pc_name')? $this->input->post('pc_name'):'';
			$pc_title =$this->input->post('pc_title')? $this->input->post('pc_title'):'';
			$pc_email =$this->input->post('pc_email')? strtolower($this->input->post('pc_email')):'';
			$pc_phone =$this->input->post('pc_phone')? $this->input->post('pc_phone'):'';
			$pc_address =$this->input->post('pc_address')? $this->input->post('pc_address'):'';

			//business
			$business_name =$this->input->post('business_name')? $this->input->post('business_name'):'';
			$business_dba_name =$this->input->post('business_dba_name')? $this->input->post('business_dba_name'):'';
			$taxid =$this->input->post('taxid') ? $this->input->post('taxid'):'';
			$country =$this->input->post('busi_country') ? $this->input->post('busi_country'):'';
			$address1 =$this->input->post('address1') ? $this->input->post('address1'):'';
			// $address2 = isset($_POST['address2']) ? $_POST['address2'] : '';
			$city =$this->input->post('busi_city') ? $this->input->post('busi_city'):'';
			$state =$this->input->post('busi_state') ? $this->input->post('busi_state'):'';
			$zip =$this->input->post('busi_zip') ? $this->input->post('busi_zip'):'';
			$ownershiptype =$this->input->post('ownershiptype')? $this->input->post('ownershiptype'):'';
			$business_type =$this->input->post('business_type')? $this->input->post('business_type'):'';
			$establishmentdate =$this->input->post('establishmentdate')? $this->input->post('establishmentdate'):'';
			$business_number =$this->input->post('business_number')? $this->input->post('business_number'):'';
			$customer_service_phone =$this->input->post('customer_service_phone')? $this->input->post('customer_service_phone'):'';
			$business_email =$this->input->post('business_email')? strtolower($this->input->post('business_email')):'';
			$customer_service_email =$this->input->post('customer_service_email')? strtolower($this->input->post('customer_service_email')):'';
			$website = !empty($this->input->post('website')) ? 'https://'.str_replace("https://", "", $this->input->post('website')) : '';

			//owner
			$name =$this->input->post('o_f_name')? $this->input->post('o_f_name'):'';
			$m_name = isset($_POST['o_m_name']) ? $_POST['o_m_name'] : '';
			$l_name =$this->input->post('o_l_name')? $this->input->post('o_l_name'):'';
			// $o_question = isset($this->input->post('o_question')) ? 'True' : 'False';
			// $is_primary_owner = isset($this->input->post('is_primary_owner')) ? 'True' : 'False';
			$o_question = ($_POST['o_question'] == '1') ? 'True' : 'False';
			$is_primary_owner = ($_POST['is_primary_owner'] == '1') ? 'True' : 'False';
			// echo $o_question.','.$is_primary_owner;die;
			// echo 'hello';die;
			$o_ss_number =$this->input->post('o_ss_number')? $this->input->post('o_ss_number'):'';
			$o_percentage =$this->input->post('o_perc')? $this->input->post('o_perc'):'';
			$o_dob =$this->input->post('o_dob')? $this->input->post('o_dob'):'';
			$o_country =$this->input->post('o_country')? $this->input->post('o_country'):'';
			$o_address1 =$this->input->post('o_address1')? $this->input->post('o_address1'):'';
			// $o_address2 = isset($_POST['o_address2']) ? $_POST['o_address2'] : '';
			$o_city =$this->input->post('o_city')? $this->input->post('o_city'):'';
			$o_state =$this->input->post('o_state')? $this->input->post('o_state'):'';
			$o_zip =$this->input->post('o_zip')? $this->input->post('o_zip'):'';
			$o_phone =$this->input->post('o_phone')? $this->input->post('o_phone'):'';
			$o_email =$this->input->post('o_email')? strtolower($this->input->post('o_email')):'';

			//banking
			// $bank_dda =$this->input->post('bank_dda')? $this->input->post('bank_dda'):'';
			// $bank_ach =$this->input->post('bank_ach')? $this->input->post('bank_ach'):'';
			// $bank_routing =$this->input->post('bank_routing')? $this->input->post('bank_routing'):'';
			// $bank_account =$this->input->post('bank_account')? $this->input->post('bank_account'):'';
			// $question =$this->input->post('question')? $this->input->post('question'):'';
			// $billing_descriptor =$this->input->post('billing_descriptor')? $this->input->post('billing_descriptor'):'';

			// //pricing
			// $dis_trans_fee =$this->input->post('dis_trans_fee')? $this->input->post('dis_trans_fee'):'0';
			// $amexrate =$this->input->post('amexrate')? $this->input->post('amexrate'):'0';
			// $chargeback =$this->input->post('chargeback')? $this->input->post('chargeback'):'0';
			// $monthly_gateway_fee =$this->input->post('monthly_gateway_fee')? $this->input->post('monthly_gateway_fee'):'0';
			// $annual_cc_sales_vol =$this->input->post('annual_cc_sales_vol')? $this->input->post('annual_cc_sales_vol'):'0';
			// // $monthly_fee =$this->input->post('monthly_fee')? $this->input->post('monthly_fee'):'0';
			// $vm_cardrate =$this->input->post('vm_cardrate') ? $this->input->post('vm_cardrate'):'0';
			// $annual_processing_volume =$this->input->post('annual_processing_volume')? $this->input->post('annual_processing_volume'):'';
			// $cnp_percent =$this->input->post('cnp_percent')? $this->input->post('cnp_percent'):'';
			// $cp_percent =$this->input->post('cp_percent')? $this->input->post('cp_percent'):'';
			// $average_ticket =$this->input->post('average_ticket')? $this->input->post('average_ticket'):'';
			// $high_ticket =$this->input->post('high_ticket')? $this->input->post('high_ticket'):'';

			// $billing_structure =$this->input->post('billing_structure')? $this->input->post('billing_structure'):'';
			// $fee_structure =$this->input->post('fee_structure')? $this->input->post('fee_structure'):'';
			// $percentage_rate =$this->input->post('percentage_rate')? $this->input->post('percentage_rate'):'';
			// $transaction_rate =$this->input->post('transaction_rate')? $this->input->post('transaction_rate'):'';

			// //other
			// $checkbox =$this->input->post('mycheckbox')? $this->input->post('mycheckbox'):'';
			$key =$this->input->post('key')? $this->input->post('key'):'';
			// $activation_id =$this->input->post('activation_id')? $this->input->post('activation_id'):'';

            if($address1  &&  $business_dba_name &&  $business_email && $business_name 
		  	&& $business_number && $business_type &&  $city && $country && $customer_service_email
		   	&& $customer_service_phone && $key && $establishmentdate &&   $name && $o_address1 && $o_dob && $o_email && $o_phone  && $o_ss_number && $ownershiptype && $pc_address 
			&& $pc_email && $pc_name && $pc_phone  &&  $pc_title && $taxid ) {
			   	$data=array(
			   		'pc_name' =>$pc_name,
					'pc_title' =>$pc_title,
					'pc_email' =>$pc_email,
					'pc_phone' =>$pc_phone,
					'pc_address' =>$pc_address,

					'business_name' =>$business_name,
					'business_dba_name' =>$business_dba_name,
					'taxid' =>$taxid,
					'country' =>$country,
					'address1' =>$address1,
					// 'address2' =>$address2,
					'city' =>$city,
					'state' =>$state,
					'zip' =>$zip,
					'ownershiptype' =>$ownershiptype,
					'business_type' =>$business_type,
					'year_business' =>substr($establishmentdate,0,4),
					'month_business' =>substr($establishmentdate,5,2),
					'day_business' =>substr($establishmentdate,8,2),
					'business_number' =>$business_number,
					'customer_service_phone' =>$customer_service_phone,
					'business_email' =>$business_email,
					'customer_service_email' =>$customer_service_email,
					'website' =>$website,

					'name' =>$name,
					'o_name'=>$name,
					'm_name' =>$m_name,
					'l_name' =>$l_name,
					'o_question' =>$o_question,
					'is_primary_owner' =>$is_primary_owner,
					'o_ss_number' =>$o_ss_number,
					'o_percentage' => $o_percentage,
					'dob' =>$o_dob,
					'o_dob_y' =>substr($o_dob,0,4),
					'o_dob_m' =>substr($o_dob,5,2),
					'o_dob_d' =>substr($o_dob,8,2),
					'o_address' =>$o_address1,
					'o_address1' =>$o_address1,
					'o_country' =>$o_country,
					// 'o_address2' =>$o_address2,
					'o_city' =>$o_city,
					'o_state' =>$o_state,
					'o_zip' =>$o_zip,
					'o_phone' =>$o_phone,
					'o_email' =>$o_email,

					'bank_dda' =>$bank_dda,
					'bank_ach' =>$bank_ach,
					'bank_routing' =>$bank_routing,
					'bank_account' =>$bank_account,
					'question' =>$question,
					'billing_descriptor' =>$billing_descriptor,
					
					'dis_trans_fee' =>$dis_trans_fee,
					'amexrate' =>$amexrate,
					'chargeback' =>$chargeback,
					'monthly_gateway_fee'=> $monthly_gateway_fee,
					// 'annual_cc_sales_vol' =>$annual_cc_sales_vol,
					// 'monthly_fee' =>$monthly_fee,
					'vm_cardrate' =>$vm_cardrate,
					'annual_processing_volume' =>$annual_processing_volume,
					'cnp_percent' =>$cnp_percent,
					'cp_percent' =>$cp_percent,
					'average_ticket' =>$average_ticket,
					'high_ticket' =>$high_ticket,
					'billing_structure' =>$billing_structure,
					'fee_structure' =>$fee_structure,
					'percentage_rate' =>$percentage_rate,
					'transaction_rate' =>$transaction_rate,
					// 'key' =>$key,
					'checkbox' => $checkbox ? 'true':'false',
			   	);
			   	// echo '<pre>';print_r($data);die;

				$id=$this->input->post('key')?$this->input->post('key'):'';
			   	// echo $id;die;
				$this->db->where('id', $id);
				$up = $this->db->update('merchant', $data);

				if($up) {
                	echo json_encode(array('Status'=>200));
					
				} else {
	                echo json_encode(array('Status'=>600));
				}

			} else {
				echo json_encode(array('Status'=>40)); 
			}

		} else {
            echo json_encode(array('Status'=>400));   
		}
	}

	public function search_record_column() {
		$searchby = $this->input->post('id');

		$data['pay_report'] = $this->admin_model->search_record_un($searchby, 'merchant');
		echo $this->load->view('admin/show_result', $data, true);

	}
	public function search_record_column1() {
		$searchby = $this->input->post('id');

		$data['item'] = $this->admin_model->data_get_where_1("order_item", array(
			"p_id" => $searchby,
		));
		// $data['item'] = $this->admin_model->search_item($searchby);
		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('admin/show_result_admin', $data, true);

	}
	public function search_record_payment() {
		$searchby = $this->input->post('id');

		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('admin/show_result_payment', $data, true);

	}

	public function tokenSystemPermission() {
		if(isset($_POST)) {
            $permission=$_POST['permission']; 
			$id=$_POST['id']; 
			if($permission=='true') { 
				$data = array(
					'is_token_system_permission' => 1,
					'is_tokenized'=>1
				);
				 
				$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
				echo '200';
			}else if($permission=='false') { 
				$data = array(
					'is_token_system_permission' =>0,
					'is_tokenized'=>0
				);
				 
				$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
				echo '200';
			}
		}
	}

	public function updatePayrocStatus() {
		if(isset($_POST)) {
            $payroc=$_POST['payroc']; 
			$id=$_POST['id']; 
			if($payroc=='true') { 
				$data = array('payroc' => 1);
				$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
				echo '200';
			}else if($payroc=='false') { 
				$data = array('payroc' =>0);
				$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
				echo '200';
			}
		}
	}

	// public function merchant_delete($id) {
	// 	$this->admin_model->delete_by_id($id, 'merchant');
	// 	echo json_encode(array(
	// 		"status" => TRUE,
	// 	));
	// }

	public function merchant_delete() {
		// echo '<pre>';print_r($_POST);die;
		$pass = $this->input->post('pass');
		$password = $this->my_encrypt($pass, 'e');
		$merchant_id = $this->input->post('merchant_id');
		$admin_id = $this->input->post('admin_id');
		
	   	if($pass && $merchant_id && $admin_id) {
		   	$getdetails = $this->admin_model->get_user_by_id($admin_id); 
		  
		   	//echo json_encode(array("status" => FALSE,'message'=>$getdetails['password'])); die; 
		   	if(count($getdetails)) {
				if($getdetails['password'] == $password) {
					$up_array = array(
						'status' => 'deleted'
					);
					// $this->admin_model->delete_by_id($merchant_id, 'merchant');
					$this->db->where('id', $merchant_id)->update('merchant', $up_array);
					$this->db->where('merchant_id', $merchant_id)->where('user_type', 'employee')->update('merchant', $up_array);

					echo json_encode(array("status" => TRUE,'message'=>'Merchant Deleted Successfully'));
				} else {
					echo json_encode(array("status" => FALSE,'message'=>'Wrong Password.'));
				}
		   	} else {
			   	echo json_encode(array("status" => FALSE,'message'=>'Please re-try'));
		   	}
	   	} else {
	   		echo json_encode(array("status" => FALSE,'message'=>"else"));die;
		   	echo json_encode(array("status" => FALSE,'message'=>'Please enter Your password'));
	   	}
   	}

	public function subadmin_delete($id) {
		$dataResponse = array();
		$this->admin_model->delete_by_id($id, 'sub_admin');

		$dataResponse['status'] = TRUE;
		$dataResponse['message'] = 'deleted';
		// echo json_encode(array(
		// 	"status" => TRUE,
		// ));
		echo json_encode($dataResponse);die;
	}
	public function block_merchant($id) {
		$this->admin_model->block_by_id($id, 'merchant');
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	public function confirm_email($id) {
		$this->admin_model->confirm_email_id($id, 'merchant');
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	public function active_merchant($id) {
		$this->admin_model->active_by_id($id, 'merchant');
		echo json_encode(array(
			"status" => TRUE,
		));
	}

	public function get_assigned_merchant() {
		$merchantid = $this->input->post('m_id');
		$query = $this->db->query("select * from sub_admin where find_in_set($merchantid,assign_merchant)")->num_rows();
		// echo $this->db->last_query();
		echo $query;
	}

	public function get_merchant_email() {
		$merchantid = $this->input->post('m_id');
		$query = $this->db->select('email')->where('id', $merchantid)->get('merchant')->row();
		echo $query->email;
	}

}
?>
	