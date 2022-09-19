<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_graph_model_report extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	function get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, $table,$condition) {
	   	
	   	$this->db->select('amount,status,express_transactiondate,add_date,transaction_id,card_type,transaction_type,amount,name,sub_merchant_name as mname');
		//$this->db->from("pos po");
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
		$where = '(status="Chargeback_Confirm" or status = "confirm")';
        $this->db->where($where);
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		$this->db->where('card_type', $condition);
		$this->db->where('transaction_type', 'full');
		//$this->db->where('status!=', 'pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		//	$this->db->group_by("invoice_no");
		$this->db->group_by("id");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('status,express_transactiondate,add_date,invoice_no,transaction_type,reference_numb_opay,card_type,amount,name,sub_merchant_name as mname');
		//$this->db->from(" );
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
		//$where = '(status="Chargeback_Confirm" or status = "confirm")';
       	// $this->db->where($where);
        $this->db->where('status !=','pending');
   		$this->db->where('status !=','declined');
   		$this->db->where('status !=','block');
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		$this->db->where('transaction_type', 'split');
		//$this->db->where('status!=','pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "date");
		$this->db->group_by("invoice_no");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_online($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('amount,status,express_transactiondate,add_date,reference_numb_opay,card_type,transaction_id,transaction_type,name,sub_merchant_name as mname');
		//$this->db->from("pos po");
		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		} else if ($start_date==$end_date) {
			$this->db->where('date_c', $end_date);
		} else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('date_c >=', $date);
			$this->db->where('date_c <=', date('Y-m-d'));
		}
		//	$where = '(status="Chargeback_Confirm" or status = "confirm")';
     	//   $this->db->where($where);
        $this->db->where('status !=','pending');
   		$this->db->where('status !=','declined');
   		$this->db->where('status !=','block');
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		$this->db->where('card_type!=', 'CASH');
		$this->db->where('card_type!=', 'CHECK');
		//	$this->db->where('card_type!=', 'ONLINE');
		$this->db->where('card_no', '0');
		
		$this->db->where('transaction_type', 'full');
		
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		
		
		
		$this->db->order_by("id", "date");
		//	$this->db->group_by("invoice_no");
		$this->db->group_by("id");
		$query = $this->db->get($table);
		//echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('amount,status,express_transactiondate,add_date,card_type,transaction_id,transaction_type,name,sub_merchant_name as mname');
	//	$this->db->from("pos po");
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
		//$where = '(status="Chargeback_Confirm" or status = "confirm")';
       	// $this->db->where($where);
        $this->db->where('status !=','pending');
   		$this->db->where('status !=','declined');
   		$this->db->where('status !=','block');
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		$this->db->where('card_type!=', 'CASH');
		$this->db->where('card_type!=', 'CHECK');
		//$this->db->where('card_type!=', 'ONLINE');
		$this->db->where('card_no!=', '0');
		
		$this->db->where('transaction_type', 'full');
		
		
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		
	
		
		//	$this->db->order_by("id", "date");
			$this->db->order_by("date_c", "desc");
		//$this->db->group_by("invoice_no");
		$this->db->group_by("id");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result_array();
	}

	function get_search_merchant_pos_type_card_invoice($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('status,add_date,card_type,transaction_id,amount,name');
	//	$this->db->from("customer_payment_request po");
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
		//	$where = '(status="Chargeback_Confirm" or status = "confirm")';
      	//  $this->db->where($where);
         $this->db->where('status !=','pending');
   		$this->db->where('status !=','declined');
   		$this->db->where('status !=','block');
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
	
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		
		
		$this->db->order_by("id", "date");
		$this->db->group_by("invoice_no");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_pos_type_card_invoice_re($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        // $this->db->select('po.*,m.name as mname');
        $this->db->select('status,add_date,card_type,transaction_id,amount,name,name as mname');
		//$this->db->from("recurring_payment po");
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
		//	$where = '(status="Chargeback_Confirm" or status = "confirm")';
      	//  $this->db->where($where);
        $this->db->where('status !=','pending');
   		$this->db->where('status !=','declined');
   		$this->db->where('status !=','block');
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		
	//	$this->db->join('merchant m', 'sub_merchant_id = m.id','left');
		
		$this->db->order_by("id", "date");
		$this->db->group_by("invoice_no");
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

}