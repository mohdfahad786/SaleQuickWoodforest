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
		 if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
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
		 if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		//$this->db->limit('10');
		$query = $this->db->get($table);
		
		return $query->result();
	}
}