<?php 

	if (!defined('BASEPATH')) {

		exit('No direct script access allowed');

	}

	class Charges extends CI_Controller {

		public function __construct() {

			parent::__construct();

			$this->load->helper('form');

			$this->load->helper('url');

			$this->load->helper('html');

			$this->load->model('profile_model');

			$this->load->model('admin_model');

			$this->load->model('home_model');

			$this->load->library('form_validation');

			$this->load->library('email');

			$this->load->library('twilio');

			//$this->load->model('sendmail_model');

			$this->load->model('session_checker_model');

			if (!$this->session_checker_model->chk_session_merchant()) {

				redirect('login');

			}

			date_default_timezone_set("America/Chicago");

		}









public function stop_charges($id) {

		$this->admin_model->stop_charges($id);

		echo json_encode(array("status" => TRUE));

	}

	public function start_charges($id) {

		$this->admin_model->start_charges($id);

		echo json_encode(array("status" => TRUE));

	}

	



public function add_charges() {

		$data['meta'] = "Add New Charge";

		$data['loc'] = "add_charges";

		$data['action'] = "Add New Charge";

		if (isset($_POST['submit'])) {

			$this->form_validation->set_rules('title', 'Title', 'required');

			$this->form_validation->set_rules('percentage', 'Percentage', 'required');

			$title = $this->input->post('title') ? $this->input->post('title') : "";

			$type = $this->input->post('type') ? $this->input->post('type') : "";

			$percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";

			if ($this->form_validation->run() == FALSE) {

				$this->load->view("merchant/add_charges_dash", $data);
				// $this->load->view("merchant/add_charges", $data);

			} else {

				$merchant_id = $this->session->userdata('merchant_id');

				$today1 = date("Ymdhms");

				$today2 = date("Y-m-d");

				$data = Array(

					'title' => $title,

					'percentage' => $percentage,

					'type' => $type,

					'merchant_id' => $merchant_id,

					'status' => 'active',

					'date_c' => $today2,

				);

				$id = $this->admin_model->insert_data("other_charges", $data);

				redirect(base_url() . 'Charges/charge_list');

			}

		} else {

			$this->load->view("merchant/add_charges_dash", $data);

		}

	}

	public function edit_charges() {

		$bct_id = $this->uri->segment(3);

		if (!$bct_id && !$this->input->post('submit')) {

			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";

			die;

		}

		$branch = $this->admin_model->data_get_where('other_charges', array('id' => $bct_id));

		if ($this->input->post('submit')) {

			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

			$title = $this->input->post('title') ? $this->input->post('title') : "";
			$type = $this->input->post('type') ? $this->input->post('type') : "";

			$percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";

			$branch_info = array(

				'title' => $title,
                'type' => $type, 
				'percentage' => $percentage,

			);

			$this->admin_model->update_data('other_charges', $branch_info, array('id' => $id));

			$this->session->set_userdata("mymsg", "Data Has Been Updated.");

			redirect('Charges/charge_list');

		} else {

			foreach ($branch as $sub) {

				$data['bct_id'] = $sub->id;

				$data['title'] = $sub->title;
				$data['type'] = $sub->type;

				$data['percentage'] = $sub->percentage;

				$data['type'] = $sub->type;

				break;

			}

		}

		$data['meta'] = "Edit Charges";

		$data['action'] = "Update Charges";

		$data['loc'] = "edit_charges";

		$this->load->view('merchant/add_charges_dash', $data);

	}





	public function charge_list() {
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		//$package_data = $this->admin_model->get_data('tax',$merchant_id);

		$package_data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id));
		// print_r($package_data);die;
		$mem = array();

		$member = array();

		foreach ($package_data as $each) {

			$mem[] = $each;

		}

		$data['mem'] = $mem;
		$data['meta'] = "Other Charges";
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";

		// $this->session->unset_userdata('mymsg');
		

		$this->load->view('merchant/charge_list_dash', $data);

	}



	public function charge_delete($id) {

		$this->admin_model->delete_by_id($id, 'other_charges');

		echo json_encode(array("status" => TRUE));

	}







	}