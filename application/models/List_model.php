<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class List_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}



function get_search_merchant_pos_late($start_date, $end_date, $status, $merchant_id, $table,$late_end,$start_limit,$limit) {

		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('date_c >=', $date);
			$this->db->where('date_c <=', date('Y-m-d'));
		}
		$this->db->where('due_date <', $late_end);
		if ($status != '') {
			$this->db->where('status', $status);
		}
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$this->db->limit($limit,$start_limit);
		$query = $this->db->get($table);
		return $query->result();
	}

	function get_search_merchant_pos($start_date, $end_date, $status, $merchant_id, $table,$start_limit,$limit) {

		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('date_c >=', $date);
			$this->db->where('date_c <=', date('Y-m-d'));
		}
		if ($status != '') {
			$this->db->where('status', $status);
		}
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$this->db->limit($limit,$start_limit);
		$query = $this->db->get($table);
		return $query->result();
	}

public function get_search_refund_data($table, $merchant_id, $start, $end, $status,$start_limit,$limit) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$is_for_vts='false';
		$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount,r.id as refund_row_id, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start);
		$this->db->where('r.date_c <=', $end);
		$this->db->where('mt.status', $status);
		$this->db->where('mt.is_for_vts', $is_for_vts);
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$this->db->order_by("r.id", "desc");
		$this->db->limit($limit,$start_limit);
		$query = $this->db->get();
		return $query->result();

	}


}