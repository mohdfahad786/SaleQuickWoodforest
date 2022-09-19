<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Email_report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}


		public function get_merchant_data_new_limit($start,$limit) {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1,report_type');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email!=','');
		$this->db->where('id!=','543');
		//$this->db->where('id','413');
		$this->db->where("find_in_set('daily', report_type)");
		$this->db->limit($limit, $start);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		//echo $this->db->last_query(); die("");
		return $res;
	}

	public function get_merchant_data_new_user_limit($start,$limit) {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1,report_type');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email','');
		$this->db->where('id!=','543');
		$this->db->where("find_in_set('daily', report_type)");
		$this->db->limit($limit, $start);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	

	public function get_merchant_data_new() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1,report_type');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email!=','');
		$this->db->where('id!=','543');
		$this->db->where("find_in_set('daily', report_type)");
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_d() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1,report_type');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email!=','');
		$this->db->where('id','543');
		$this->db->where("find_in_set('daily', report_type)");
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_user() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1,report_type');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email','');
		$this->db->where("find_in_set('daily', report_type)");
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_monthly_report() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email!=', '');
		$this->db->where("find_in_set('monthly', report_type)");
	//$ignore = array(661,268,836,618,108,847,798,543,805,531,577,278,286,833,272,423,284,829,848,642,493,620,586);
      //  $this->db->where_not_in('id', $ignore);
		//$this->db->where_in('monthly', 'user_id');
		//$this->db->limit(10, 0);
		$this->db->limit(500, 0);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		//echo $this->db->last_query(); die("");
		return $res;
	}

	public function get_merchant_data_new_monthly_user() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email', '');
		$this->db->where("find_in_set('monthly', report_type)");
	//$ignore = array(661,268,836,618,108,847,798,543,805,531,577,278,286,833,272,423,284,829,848,642,493,620,586);
      //  $this->db->where_not_in('id', $ignore);
		//$this->db->where_in('monthly', 'user_id');
		//$this->db->limit(10, 0);
		$this->db->limit(500, 0);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_monthly_report_single() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('report_email!=','');
		$this->db->where("find_in_set('monthly', report_type)");
		//$ignore = array(531,577,286,833,272,284,829,848,642,493,620);
		//$ignore = array(577,272,829,848,620);
	//$ignore = array(661,268,836,618,108,847,798,543,805,531,577,286,833,272,284,829,848,642,493,620);
		//$ignore_latest = array(661,836,618,805);
        //$this->db->where_in('id', $ignore);
		//$this->db->where_in('monthly', 'user_id');
		//$this->db->limit(20, 0);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_monthly_user_single() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		//$this->db->where('report_email','');
		$this->db->where("find_in_set('monthly', report_type)");
	//$ignore = array(661,268,836,618,108,847,798,543,805,531,577,278,286,833,272,423,284,829,848,642,493,620,586);
	//$ignore = array(531,493,642,833,847);
       // $this->db->where_in('id', $ignore);
		//$this->db->where_in('monthly', 'user_id');
		//$this->db->limit(20, 0);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}


	public function get_merchant_data_new2() {
		$this->db->select('id,report_email,email,business_dba_name,mob_no,email,logo,address1');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->where('status', 'active');
		$this->db->where("find_in_set('daily', report_type)");
		//$this->db->where_in('monthly', 'user_id');
		$this->db->limit(30, 20);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}


	public function get_report_refund_data($table, $start, $end, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('mt.status,mt.invoice_no,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start);
		$this->db->where('r.date_c <=', $end);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result();

	}

}