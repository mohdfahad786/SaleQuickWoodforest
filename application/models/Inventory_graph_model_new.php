<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_graph_model_new extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	function get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, $table,$condition) {
	   	// $this->db->select('po.*,m.name as mname');
	   	// $this->db->select('po.amount,po.status,po.express_transactiondate,po.add_date,po.transaction_id,po.card_type,po.transaction_type,po.amount,po.name,m.name as mname');
	   	$this->db->select('po.amount,po.status,po.express_transactiondate,po.add_date,po.transaction_id,po.card_type,po.transaction_type,po.amount,po.name,m.name as mname');
		$this->db->from("pos po");
		if ($start_date != '') {
			$this->db->where('po.date_c >=', $start_date);
			$this->db->where('po.date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('po.date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('po.date_c >=', $date);
			$this->db->where('po.date_c <=', date('Y-m-d'));
		}
		$where = '(po.status="Chargeback_Confirm" or po.status = "confirm")';
        $this->db->where($where);
		if($employee!=0)
		{
			$this->db->where('po.sub_merchant_id', $employee);
		}
		$this->db->where('po.card_type', $condition);
		//$this->db->where('po.transaction_type', 'full');
		//$this->db->where('po.status!=', 'pending');
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		$this->db->order_by("po.id", "desc");
		//	$this->db->group_by("po.invoice_no");
		$this->db->group_by("po.id");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('po.status,po.express_transactiondate,po.add_date,po.invoice_no,po.transaction_type,po.reference_numb_opay,po.card_type,po.amount,po.name,m.name as mname');
		$this->db->from("pos po");
		if ($start_date != '') {
			$this->db->where('po.date_c >=', $start_date);
			$this->db->where('po.date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('po.date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('po.date_c >=', $date);
			$this->db->where('po.date_c <=', date('Y-m-d'));
		}
		//$where = '(po.status="Chargeback_Confirm" or po.status = "confirm")';
       	// $this->db->where($where);
        $this->db->where('po.status !=','pending');
   		$this->db->where('po.status !=','declined');
   		$this->db->where('po.status !=','block');
		if($employee!=0)
		{
			$this->db->where('po.sub_merchant_id', $employee);
		}
		$this->db->where('po.transaction_type', 'split');
		//$this->db->where('po.status!=','pending');
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		$this->db->order_by("po.id", "date");
		$this->db->group_by("po.invoice_no");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_online($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('po.amount,po.status,po.express_transactiondate,po.add_date,po.reference_numb_opay,po.card_type,po.transaction_id,po.transaction_type,po.name,m.name as mname');
		$this->db->from("pos po");
		if ($start_date != '') {
			$this->db->where('po.date_c >=', $start_date);
			$this->db->where('po.date_c <=', $end_date);
		} else if ($start_date==$end_date) {
			$this->db->where('po.date_c', $end_date);
		} else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('po.date_c >=', $date);
			$this->db->where('po.date_c <=', date('Y-m-d'));
		}
		//	$where = '(po.status="Chargeback_Confirm" or po.status = "confirm")';
     	//   $this->db->where($where);
        $this->db->where('po.status !=','pending');
   		$this->db->where('po.status !=','declined');
   		$this->db->where('po.status !=','block');
		if($employee!=0)
		{
			$this->db->where('po.sub_merchant_id', $employee);
		}
		$this->db->where('po.card_type!=', 'CASH');
		$this->db->where('po.card_type!=', 'CHECK');
		//	$this->db->where('po.card_type!=', 'ONLINE');
		$this->db->where('po.card_no', '0');
		
		//$this->db->where('po.transaction_type', 'full');
		
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		
		$this->db->order_by("po.id", "date");
		//	$this->db->group_by("po.invoice_no");
		$this->db->group_by("po.id");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('po.amount,po.status,po.express_transactiondate,po.add_date,po.card_type,po.transaction_id,po.transaction_type,po.name,m.name as mname');
		$this->db->from("pos po");
		if ($start_date != '') {
			$this->db->where('po.date_c >=', $start_date);
			$this->db->where('po.date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('po.date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('po.date_c >=', $date);
			$this->db->where('po.date_c <=', date('Y-m-d'));
		}
		//$where = '(po.status="Chargeback_Confirm" or po.status = "confirm")';
       	// $this->db->where($where);
        $this->db->where('po.status !=','pending');
   		$this->db->where('po.status !=','declined');
   		$this->db->where('po.status !=','block');
		if($employee!=0)
		{
			$this->db->where('po.sub_merchant_id', $employee);
		}
		$this->db->where('po.card_type!=', 'CASH');
		$this->db->where('po.card_type!=', 'CHECK');
		//$this->db->where('po.card_type!=', 'ONLINE');
		$this->db->where('po.card_no!=', '0');
		
		//$this->db->where('po.transaction_type', 'full');
		
		
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		
		//	$this->db->order_by("po.id", "date");
			$this->db->order_by("po.date_c", "desc");
		//$this->db->group_by("po.invoice_no");
		$this->db->group_by("po.id");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_card_invoice($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('po.status,po.add_date,po.card_type,po.transaction_id,po.amount,po.name,m.name as mname');
		$this->db->from("customer_payment_request po");
		if ($start_date != '') {
			$this->db->where('po.date_c >=', $start_date);
			$this->db->where('po.date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('po.date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('po.date_c >=', $date);
			$this->db->where('po.date_c <=', date('Y-m-d'));
		}
		//	$where = '(po.status="Chargeback_Confirm" or po.status = "confirm")';
      	//  $this->db->where($where);
         $this->db->where('po.status !=','pending');
   		$this->db->where('po.status !=','declined');
   		$this->db->where('po.status !=','block');
		if($employee!=0)
		{
			$this->db->where('po.sub_merchant_id', $employee);
		}
	
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		
		$this->db->order_by("po.id", "date");
		$this->db->group_by("po.invoice_no");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_pos_type_card_invoice_re($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('po.status,po.add_date,po.card_type,po.transaction_id,po.amount,po.name,m.name as mname');
		$this->db->from("recurring_payment po");
		if ($start_date != '') {
			$this->db->where('po.date_c >=', $start_date);
			$this->db->where('po.date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('po.date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('po.date_c >=', $date);
			$this->db->where('po.date_c <=', date('Y-m-d'));
		}
		//	$where = '(po.status="Chargeback_Confirm" or po.status = "confirm")';
      	//  $this->db->where($where);
        $this->db->where('po.status !=','pending');
   		$this->db->where('po.status !=','declined');
   		$this->db->where('po.status !=','block');
		if($employee!=0)
		{
			$this->db->where('po.sub_merchant_id', $employee);
		}
		
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		
		$this->db->order_by("po.id", "date");
		$this->db->group_by("po.invoice_no");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	public function get_full_refund_data_search_pdf($start_date, $end_date,$table, $merchant_id) {
		
		// $this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->select('mt.status,mt.card_type,mt.transaction_type,mt.name,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->order_by("r.add_date", "desc");
		
	 	if('mt.transaction_type == full'){
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	    else if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		return $query->result_array();

	}

	public function get_full_refund_data_search_pdf_full($start_date, $end_date,$table, $merchant_id) {
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->order_by("r.add_date", "desc");
	   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
	 	
	 	$query = $this->db->get();
		return $query->result_array();
	}

	public function get_full_refund_data_search_pdf_split($start_date, $end_date,$table, $merchant_id) {
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->order_by("r.add_date", "desc");
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		
		$query = $this->db->get();
		return $query->result_array();

	}

}