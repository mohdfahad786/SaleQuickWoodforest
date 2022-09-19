<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Revenue_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_search_merchant_pos_new_admin($start_date, $end_date, $status, $table) {
		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		}
		
		if ($status != '') {
			$this->db->where('status', $status);
		}
		$this->db->order_by("id", "desc");
		//$this->db->limit('10');
		$query = $this->db->get($table);
		return $query->result();
	}

	public function get_full_details_pos_new_admin($table) {
		$date = date('Y-m-d', strtotime('-30 days'));
		//$date ='2018-01-01';
		//$this->db->where('status !=', 'Chargeback_Confirm' );
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		//$this->db->limit('10');
		$query = $this->db->get($table);
		
		return $query->result();
	}
}