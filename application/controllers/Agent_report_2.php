<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Agent_report extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('agent_model'); 
		$this->load->model('session_checker_model');
		$this->load->library('email');
		$this->load->library('twilio');

		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}

		date_default_timezone_set("America/Chicago");
	  //ini_set('display_errors', 1);
      //error_reporting(E_ALL);
	}

	public function all_agent_report2() {
		$data = array();
		$mem = array();
		$member = array();

		$package_data = $this->admin_model->get_full_details_agent('sub_admin');
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
		$data['meta'] = 'View All Agent Report';
		$this->load->view('admin/all_agent_report_dash', $data);
	}

	public function all_agent_report() {
		$data = array();
		$mem = array();
		$member = array();

		if (isset($_POST['mysubmit'])) {
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];

			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];

		} else {
			// $data["start_date"] = $_POST['start_date'];
			// $data["end_date"] = $_POST['end_date'];

			$data["start_date"] = '2021-12-06';
			$data["end_date"] = '2022-01-06';
		}


		$package_data_full_reporst = $this->agent_model->get_full_reports_reseller(array(
				'date' => $data["start_date"],
				'date2' => $data["end_date"]
			));

		$package_data_full_payout = $this->agent_model->get_full_payout_reseller(array(
				'date' => $data["start_date"],
				'date2' => $data["end_date"]
			));

	//print_r($package_data_full_reporst); die();

		$package_data = $this->admin_model->get_full_details_agent('sub_admin');
		foreach ($package_data as $each) {
			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['view_permissions'] = $each->view_permissions;
			$package['edit_permissions'] = $each->edit_permissions;
			$package['delete_permissions'] = $each->delete_permissions;
			$package['active_permissions'] = $each->active_permissions;
			$package['assign_merchan'] = $each->assign_merchant;
			$merchantid=explode(',',$each->assign_merchant);
			$package['total_merchant'] = count($merchantid);

			 $package_data_report_merchant = $this->agent_model->get_full_reports_merchant(array(
				'merchant_id' => $each->assign_merchant,
				'date' => $data["start_date"],
				'date2' => $data["end_date"]
			));
			 //print_r($package_data_report_merchant[0]);

             $package['m_amount'] = $package_data_report_merchant[0]['amount'];
             $package['m_revenue'] = $package_data_report_merchant[0]['revenue'];
             $package['m_cost'] = $package_data_report_merchant[0]['interchangeFee']+$package_data_report_merchant[0]['networkFees']+$package_data_report_merchant[0]['buy_rate'];
             $profit = $package_data_report_merchant[0]['revenue'] -($package_data_report_merchant[0]['interchangeFee']+$package_data_report_merchant[0]['networkFees']+$package_data_report_merchant[0]['buy_rate']);

             $package['m_profit']=($profit*$each->commission_p_merchant)/100;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;

		$data['GrosspaymentValume'] = $package_data_full_reporst[0]['amount'];
		$data['TotalrevenueCaptured'] = $package_data_full_reporst[0]['revenue'];
		$data['Payout'] = $package_data_full_payout[0]['amount'];
		
		$data['Cost'] = $package_data_full_reporst[0]['interchangeFee']+$package_data_full_reporst[0]['networkFees']+$package_data_full_reporst[0]['buy_rate'];

		$data['meta'] = 'View All Agent Revenue Report';
		$this->load->view('admin/all_agent_report_dash_test', $data);
	}
    
    public function all_payout() {
		$data = array();
		$mem = array();
		$member = array();

        $bct_id = $this->uri->segment(3);
		$package_data = $this->admin_model->get_full_details_agent_payout($bct_id,'sub_admin');
		//print_r($package_data); die();
		foreach ($package_data as $each) {
			$package['id'] = $each->id;
			$package['merchant_id'] = $each->merchant_id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['amount'] = $each->amount;
			$package['year'] = $each->year;
			$package['month'] = $each->month;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['meta'] = 'View All Payout';
		$this->load->view('admin/all_payout_dash', $data);
	}

	public function add_payout_agent() {
        $bct_id = $this->uri->segment(3);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to Add</h3>";
			die;
		}
		$branch = $this->admin_model->get_subadmin_details($bct_id);
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
			$month = $this->input->post('month') ? $this->input->post('month') : "";
			$year = $this->input->post('year') ? $this->input->post('year') : "";
			
			$branch_info = array(
				'merchant_id' => $id,
				'amount' => $amount,
				'month' => $month,
				'year' => $year,
			);
			$this->admin_model->insert_data("agent_payout", $branch_info);
			$this->session->set_flashdata("success", "Payout Added Successfully");
			redirect('Agent/all_agent_report');

		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;	
				break;
			}
		}
		$data['meta'] = "Add Payout";
		$data['action'] = "Add Payout";
		$data['loc'] = "edit_payout";
		$this->load->view('admin/add_payout_dash', $data);
	}

	public function edit_payout_agent() {
        $bct_id = $this->uri->segment(3);
        $merchant_id = $this->uri->segment(4);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to Add</h3>";
			die;
		}

		$branch = $this->admin_model->get_full_details_agent_payout_id($bct_id,'sub_admin');
		//print_r($branch); die();

		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$merchant_id = $this->input->post('merchant_id') ? $this->input->post('merchant_id') : "";
			$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
			$month = $this->input->post('month') ? $this->input->post('month') : "";
			$year = $this->input->post('year') ? $this->input->post('year') : "";
			
			$branch_info = array(
				'amount' => $amount,
				'month' => $month,
				'year' => $year,
			);
			$this->admin_model->update_data('agent_payout', $branch_info, array(
				'id' => $id,
			));
			$this->session->set_userdata("success", "Payout Updated Successfully");
			redirect('Agent/all_payout/'.$merchant_id);
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['merchant_id'] = $sub->merchant_id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;
				$data['amount'] = $sub->amount;
				$data['month'] = $sub->month;
				$data['year'] = $sub->year;
				break;
			}
		}
		$data['meta'] = "Edit Payout";
		$data['action'] = "Edit Payout";
		$data['loc'] = "edit_payout";
		$this->load->view('admin/edit_payout_dash', $data);
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
			redirect('dashboard/all_agent');
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

		$data['meta'] = "Update Agent";
		$data['action'] = "Update Agent";
		$data['loc'] = "edit_agent";
		$this->load->view('admin/add_agent', $data);

	}


		public function create_agent()
	{
	    //    print_r($_POST); die;  
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$this->form_validation->set_rules('chkstatus[]', 'Merchant Assign', 'required');
			
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "block";

			


		

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
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		
	}

	}