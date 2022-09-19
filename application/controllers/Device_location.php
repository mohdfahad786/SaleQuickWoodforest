<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
// header("Content-type: text/xml");

class Device_location extends CI_Controller {
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
		$this->load->model('session_checker_model');
		$this->load->library('email');
		$this->load->library('twilio');

		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}

		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	    // error_reporting(E_ALL);
	}

	public function index() {
		$data["title"] = "Admin Panel";
		$data["meta"] = "Device Locations";
		
		$query = $this->db->query("SELECT * FROM location_test ORDER BY id DESC");
		$locationData = $query->result_array();
		// echo '<pre>';print_r($locationData);die;
		
		foreach ($locationData as $key => $row) {
			$mark_color = '';
			$merchant_id = $row['merchant_id'];
			$merchant = $this->db->query("SELECT business_dba_name FROM merchant WHERE id = $merchant_id")->row();

            $markers[$key]['name'] = !empty($merchant->business_dba_name) ? str_replace("'", "&quot", $merchant->business_dba_name) : 'Unnamed';
            $markers[$key]['latitude'] = $row['lat'];
            $markers[$key]['longitude'] = $row['longi'];
            $markers[$key]['device'] = $row['device'];

            $date1 = date("Y-m-d H:i:s", strtotime($row['date_time']));
            // $date2 = date('Y-m-d H:i:s', strtotime($date1.' +24 hour'));
            $curr_date = date('Y-m-d H:i:s');
            $curr_date1 = date('Y-m-d H:i:s', strtotime($curr_date.' -24 hour'));
            // echo $curr_date1;
            if($date1 >= $curr_date1) {
            	$mark_color = 'green_circle';
            } else {
            	$mark_color = 'blue_circle';
            }
            $markers[$key]['mark_color'] = $mark_color;
        }
        
        // echo '<pre>';print_r($markers);die;
        $data['markers'] =  json_encode($markers);
        $this->load->view('admin/device_location', $data);
	}

}
?>