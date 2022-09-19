<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('customers_model','customers');
		 date_default_timezone_set("America/Chicago");
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('merchant/all_pos');
	}

	public function ajax_list()
	{
		$list = $this->customers->get_datatables(); 
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $customers->owner_name;
			$row[] = $customers->card_no;
			$row[] = $customers->amount;
			$row[] = '<span class="label label-danger"> '.$customers->status.'  </span>';
			//$row[] = '<a>edit</a>';
			// $row[] = $customers->LastName;
			// $row[] = $customers->phone;
			// $row[] = $customers->address;
			// $row[] = $customers->city;
			// $row[] = $customers->country;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

}
