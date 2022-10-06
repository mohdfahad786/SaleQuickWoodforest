 <?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Multiadmin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->library('email');
		$this->load->model('session_checker_model');
		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}
       
		date_default_timezone_set("America/Chicago");
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		
		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);
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

	public function add_admin() {
		$data['meta'] = 'Add Admin';
		$data['loc'] = 'add_admin';
		$data['action'] = 'Add Admin';
		$data['upload_loc'] = base_url('logo');

		if($_POST) {
			// echo '<pre>';print_r($_FILES); die;
		    $this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[admin.username]');
			$this->form_validation->set_rules('email_id', 'Email', 'required|valid_email|is_unique[admin.email_id]');
			$this->form_validation->set_rules('user_type', 'User Type', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$username = $this->input->post('username') ? $this->input->post('username') : "";
			$email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
			$phone = $this->input->post('phone') ? $this->input->post('phone') : "";
			$user_type = $this->input->post('user_type') ? $this->input->post('user_type') : "";
			$address = $this->input->post('address') ? $this->input->post('address') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('multiadmin/add_admin');

			} else {
				$pswdToMail = substr(str_shuffle('123456789ABCDEFGHJKLMNPQRSTUVWXYZ@$!#'), 1, 10);
				// echo $npsw;die;
				$wf_merchants=$this->session->userdata('wf_merchants');
				$password = $this->my_encrypt($pswdToMail, 'e');
	          	$ins_data['password'] = $password;

				$ins_data['name'] = $name;
				$ins_data['username'] = $username;
				$ins_data['email_id'] = $email_id;
				$ins_data['phone'] = $phone;
				$ins_data['user_type'] = $user_type;
				$ins_data['address'] = $address;
				$ins_data['status'] = $status;
				$ins_data['wf_merchants'] = $wf_merchants;

				if($_FILES['image']['name'] != '') {
					$path = $_FILES['image']['name'];
					$ext = pathinfo($path, PATHINFO_EXTENSION);
					$filename='image_'.date('YmdHi').'.'.$ext; 
					$_FILES['image']['name'] = $filename;
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_width'] = 70000;
					$config['max_height'] = 70000;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('image')) {
						$fInfo = $this->upload->data();
						$image = $fInfo['file_name'];
		            } else {
		            	$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('multiadmin/add_admin');
		            }
			        $ins_data['image'] = $image;
	            }
				
				$this->db->insert('admin', $ins_data);
				// echo $this->db->last_query();die;
				if($this->db->affected_rows() > 0) {
					// echo 'inserted';die;
					// $psw1 = $password1;
					set_time_limit(3000); 
					$MailTo = $email_id;  
					$MailSubject = 'SaleQuick Login Credentials'; 
					$header = "From: Salequick<info@salequick.com>\r\n".
						"MIME-Version: 1.0" . "\r\n" .
						"Content-type: text/html; charset=UTF-8" . "\r\n";
					$msg = "Your Username is ".$email_id." and Password is ".$pswdToMail.". Please use these Credentials for login into SaleQuick via URL https://woodforest.salequick.com/admin.<br><br>Regards,<br>Team SaleQuick";
					// ini_set('sendmail_from', $email);
					ini_set('sendmail_from', $MailTo);

					$this->email->from('info@salequick.com', '');
					// $this->email->to($MailTo);
					$this->email->to($MailTo);
					$this->email->subject($MailSubject);
					$this->email->message($msg);
					if($this->email->send()) {
						$this->session->set_flashdata('success', 'Admin Added Successfully. An email is sent to '.$email_id. '. Check mail for credentials');
						redirect('multiadmin/all_admin');
					} else {
						$this->session->set_flashdata('error', 'Mail send error.');
						redirect('multiadmin/add_admin');
					}
				} else {
					$this->session->set_flashdata('error', 'Error in creating Admin.');
					redirect('multiadmin/add_admin');
				}
			}
		}
		$this->load->view('admin/add_admin', $data);
	}

	public function all_admin() {
		$data['meta'] = 'All Admin';
		$data['adminArr'] = $this->db->query("select * from admin where user_type='wf'")->result_array();
		// echo $this->db->last_query();die;
		// echo '<pre>';print_r($data['adminArr']);die;

		$this->load->view('admin/all_admin', $data);
	}

	public function edit_admin() {
		$id = $this->uri->segment(3);
		$adminDetails = $this->db->where('id', $id)->get('admin')->result_array();
		// echo '<pre>';print_r($adminDetails);die;
		$data['id'] = $id;
		$data['username'] = $adminDetails[0]['username'];
        $data['email_id'] = $adminDetails[0]['email_id'];
        $data['password'] = $adminDetails[0]['password'];
        $data['user_type'] = $adminDetails[0]['user_type'];
        $data['name'] = $adminDetails[0]['name'];
        $data['phone'] = $adminDetails[0]['phone'];
        $data['image'] = $adminDetails[0]['image'];
        $data['address'] = $adminDetails[0]['address'];
        $data['status'] = $adminDetails[0]['status'];
		// echo $id;die;
		$data['meta'] = 'Edit Admin';
		$data['loc'] = 'edit_admin';
		$data['action'] = 'Update';
		$data['upload_loc'] = base_url('uploads');

		if($_POST) {
			// echo '<pre>';print_r($_FILES); die;
		    $this->form_validation->set_rules('name', 'Name', 'required');
		    $this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('user_type', 'User Type', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$phone = $this->input->post('phone') ? $this->input->post('phone') : "";
			$user_type = $this->input->post('user_type') ? $this->input->post('user_type') : "";
			$address = $this->input->post('address') ? $this->input->post('address') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('multiadmin/edit_admin/'.$id);

			} else {
				if($this->input->post('reset_password')) {
					$pswdToMail = substr(str_shuffle('123456789ABCDEFGHJKLMNPQRSTUVWXYZ@$!#'), 1, 10);
					// echo $npsw;die;
					$password = $this->my_encrypt($pswdToMail, 'e');
		          	$ins_data['password'] = $password;
					
					set_time_limit(3000); 
					$MailTo = $data['email_id'];  
					$MailSubject = 'SaleQuick Login Credentials'; 
					$header = "From: Salequick<info@salequick.com>\r\n".
						"MIME-Version: 1.0" . "\r\n" .
						"Content-type: text/html; charset=UTF-8" . "\r\n";
					$msg = "The password for your username ".$data['username']." has been changed that is ".$pswdToMail.". Please use these Credentials for login into SaleQuick via URL https://salequick.com/admin.<br><br>Regards,<br>Team SaleQuick";
					// ini_set('sendmail_from', $email);
					ini_set('sendmail_from', $MailTo);

					$this->email->from('info@salequick.com', '');
					// $this->email->to($MailTo);
					$this->email->to($MailTo);
					$this->email->subject($MailSubject);
					$this->email->message($msg);
					$this->email->send();
				}

				if($_FILES['image']['name'] != '') {
					$path = $_FILES['image']['name'];
					$ext = pathinfo($path, PATHINFO_EXTENSION);
					$filename='image_'.date('YmdHi').'.'.$ext; 
					$_FILES['image']['name'] = $filename;
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_width'] = 70000;
					$config['max_height'] = 70000;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('image')) {
						$fInfo = $this->upload->data();
						$image = $fInfo['file_name'];
		            } else {
		            	$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('multiadmin/edit_admin/'.$id);
		            }
			        $ins_data['image'] = $image;
	            }

	            $ins_data['name'] = $name;
				$ins_data['user_type'] = $user_type;
				$ins_data['phone'] = $phone;
				$ins_data['address'] = $address;
				$ins_data['status'] = $status;
				
				$this->db->where('id', $id);
				$this->db->update('admin', $ins_data);
				// echo $this->db->last_query();die;
				if($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('success', 'Admin Details Updated Successfully.');
					redirect('multiadmin/all_admin');

				} else {
					$this->session->set_flashdata('error', 'Error in creating Admin.');
					redirect('multiadmin/edit_admin/'.$id);
				}
			}
		}
		$this->load->view('admin/add_admin', $data);
	}

	public function deleteAdmin() {
     	$response = array();
	   	$id =$this->uri->segment(3);
	   
	 	$this->db->where('id', $id);
		if($this->db->delete('admin')) {
			$response = ['status' => '200', 'successMsg' => 'Admin details has been deleted'];
			// echo 1;die;
	 		
		} else {
	   		$response = ['status' => '401', 'errorMsg' => 'Item not deleted! Item added in cart!'];
	   		// echo 2;die;
		}
		echo json_encode($response);die;
	}

}