<?php 
if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Pos_list extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model'); 
			$this->load->model('admin_model');
			$this->load->model('Inventory_model');
			$this->load->model('Inventory_graph_model');
			$this->load->model('Home_model');
			$this->load->library('email');
			 $this->load->helper('pdf_helper');
			$this->load->model('customers_model', 'customers');
			
			//ini_set('display_errors', 1);
		    //error_reporting(E_ALL);
		    //ini_set('max_execution_time', -1);
			
		}

		
public function index() {

		$getRow=$this->db->query(" SELECT * FROM customer_payment_request WHERE  payment_type='recurring' ORDER BY id DESC limit 20" )->result_array(); 
		print_r($getRow);
	}

}