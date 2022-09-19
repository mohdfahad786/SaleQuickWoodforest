<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Batch_report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	function get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, $table,$condition) {
	   	
	   	$this->db->select('amount,status,express_transactiondate,add_date,transaction_id,card_type,transaction_type,amount,name,sub_merchant_name as mname');
		//$this->db->from("pos po");
		
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
		
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
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
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
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
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
		
		//$this->db->where('transaction_type', 'full');
		
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
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
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
		
		//$this->db->where('transaction_type', 'full');
		
		
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
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
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
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
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

	public function get_full_refund_data_search_pdf_2($start_date, $end_date,$table, $merchant_id) {
		
		// $this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->select('mt.status,mt.card_type,mt.transaction_type,mt.name,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
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

	function get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, $table,$condition) {

		 $this->db->select('count(id) as id, SUM(amount) as amount');
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
		   $this->db->where('status !=','pending');
   $this->db->where('status !=','declined');
   $this->db->where('status !=','block');

		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		$this->db->where('card_type', $condition);
		//$this->db->where('status!=', 'pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, $table) {

		 $this->db->select('count(id) as id, SUM(amount) as amount');
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
		   $this->db->where('status !=','pending');
   $this->db->where('status !=','declined');
   $this->db->where('status !=','block');

		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		//$this->db->where('card_type', $condition);
		//$this->db->where('status!=', 'pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_tip_total($start_date, $end_date, $merchant_id,$employee, $table) {

		$this->db->select('count(DISTINCT invoice_no) as id, SUM(tip_amount) as amount');
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
		$this->db->where('tip_amount >',0);
		$this->db->where('status !=','pending');
		$this->db->where('status !=','declined');
		$this->db->where('status !=','block');
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		$this->db->where('merchant_id', $merchant_id); 
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_tax_total($start_date, $end_date, $merchant_id,$employee, $table) {

		$this->db->select('count(DISTINCT invoice_no) as id, SUM(tax) as amount');
	   $this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
	   $this->db->where('tax >',0);
	   $this->db->where('status !=','pending');
       $this->db->where('status !=','declined');
       $this->db->where('status !=','block');
        $this->db->where('status !=','Chargeback_Confirm');
	   if($employee!=0)
	   {
		   $this->db->where('sub_merchant_id', $employee);
	   }
	   $this->db->where('merchant_id', $merchant_id); 
	   $query = $this->db->get($table);
	   return $query->result_array();
   }
function get_search_merchant_other_charges_total($start_date, $end_date, $merchant_id,$employee, $table) {

	$this->db->select('count(DISTINCT invoice_no) as id, SUM(other_charges) as amount');
   $this->db->where('add_date >=', $start_date);
	$this->db->where('add_date <=', $end_date);
   $this->db->where('other_charges >',0);
   $this->db->where('status !=','pending');
   $this->db->where('status !=','declined');
   $this->db->where('status !=','block');
   

   if($employee!=0)
   {
	   $this->db->where('sub_merchant_id', $employee);
   }
   $this->db->where('merchant_id', $merchant_id);
   //if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
  // $this->db->where('other_charges is NOT NULL', NULL, FALSE);
  // $this->db->group_by("invoice_no");
   $query = $this->db->get($table);
   return $query->result_array();
}


		function get_search_merchant_pos_total_online($start_date, $end_date, $status, $merchant_id,$employee, $table) {

	    $this->db->select('count(id) as id, SUM(amount) as amount');
	     $this->db->where('add_date >=', $start_date);
	$this->db->where('add_date <=', $end_date);
		   $this->db->where('status !=','pending');
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
		$this->db->where('card_no', '0');
		//$this->db->where('status!=','pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_search_merchant_pos_total_card($start_date, $end_date, $status, $merchant_id,$employee, $table) {

	$this->db->select('count(id) as id, SUM(amount) as amount');
	$this->db->where('add_date >=', $start_date);
	$this->db->where('add_date <=', $end_date);
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
	//$this->db->where('status!=','pending');
	if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
	
	$query = $this->db->get($table);
	return $query->result_array();
	}
	
	public function get_full_refund_data_search_pdf($start_date, $end_date,$table, $merchant_id) {
		
		// $this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->select('mt.status,mt.card_type,mt.transaction_type,mt.name,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
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
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
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
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->order_by("r.add_date", "desc");
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		
		$query = $this->db->get();
		return $query->result_array();

	}

		public function get_full_refund_cash_check($start_date, $end_date,$table, $merchant_id,$condition) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.card_type', $condition);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
	
		 if('mt.transaction_type == full'){
		
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	    
		$query = $this->db->get();
		return $query->result_array();

	}

		public function get_full_refund_cash_check_s($start_date, $end_date,$table, $merchant_id,$condition) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.card_type', $condition);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
	
		 if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		$query = $this->db->get();
		return $query->result_array();

	}
	
	public function get_full_refund_total_count_new($start_date, $end_date, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('r.status', 'confirm');
		$this->db->where('r.merchant_id', $merchant_id); 
		$query = $this->db->get();
		return $query->result_array();

	}


		public function get_full_refund_card($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.card_type!=', 'CASH');
		$this->db->where('mt.card_type!=', 'CHECK');
		$this->db->where('mt.card_type!=', 'ONLINE');
		$this->db->where('mt.card_no!=', '0');
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		 if('mt.transaction_type == full'){
		
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	  
		$query = $this->db->get();
		return $query->result_array();

	}

	public function get_full_refund_card_s($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.card_type!=', 'CASH');
		$this->db->where('mt.card_type!=', 'CHECK');
		$this->db->where('mt.card_type!=', 'ONLINE');
		$this->db->where('mt.card_no!=', '0');
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		 
		
		

		if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		
		$query = $this->db->get();
		return $query->result_array();

	}

	public function get_full_refund_online($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.card_type!=', 'CASH');
		$this->db->where('mt.card_type!=', 'CHECK');
		$this->db->where('mt.card_type!=', 'ONLINE');
		$this->db->where('mt.card_no', '0');
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
	 if('mt.transaction_type == full'){
		
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	   
		$query = $this->db->get();
		return $query->result_array();

	}
	public function get_full_refund_online_s($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start_date);
		$this->db->where('r.add_date <=', $end_date);
		$this->db->where('mt.card_type!=', 'CASH');
		$this->db->where('mt.card_type!=', 'CHECK');
		$this->db->where('mt.card_type!=', 'ONLINE');
		$this->db->where('mt.card_no', '0');
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
	if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		$query = $this->db->get();
		return $query->result_array();

	}


	public function data_get_where_down($table, $end_date, $start_date, $merchant_id) {
		$getA_merchantData=$this->select_request_id('merchant',$merchant_id); 
	   if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 
		if ($table == "pos") {
			 
			$this->db->select('amount,tax,tip_amount,card_type,type,date_c,date_r,reference,transaction_id,status,add_date');
			$this->db->select($name);
		} else {
			$this->db->select('amount,tax,  tip_amount, card_type,type,date_c,reference,transaction_id,status,add_date');
			$this->db->select($name);  
		}
		$this->db->from($table);
		$this->db->where('add_date >=', $start_date);
		$this->db->where('add_date <=', $end_date);
		$this->db->where('status!=', 'pending');
		$this->db->where('status!=', 'block');
		$this->db->where('status!=', 'declined');
		$this->db->where('merchant_id', $merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		 //echo $this->db->last_query();die;
		$mem2 =  array(); 
		foreach($query->result()  as $row)
		{
			$package2['amount'] = $row->amount;
			$package2['tax'] =  $row->tax;
			$package2['tip_amount'] =  $row->tip_amount;
			$package2['card_type'] =$row->card_type;
			$package2['type'] = $row->type;
			$package2['add_date'] = $row->add_date;
			$package2['reference'] = $row->reference;
			$package2['date_c'] = $row->date_c;
            if($getA_merchantData->csv_Customer_name > 0 ){ $package2['name'] = $row->name; }
			$package2['status'] = $row->status;
			$transactionId = $row->transaction_id; 
		   $itemnameList=$this->db->query("SELECT GROUP_CONCAT(adv_pos_item.name) item_name from adv_pos_item  join adv_pos_cart_item on adv_pos_item.id=adv_pos_cart_item.item_id JOIN $table  on adv_pos_cart_item.transaction_id = $table.transaction_id  where adv_pos_cart_item.transaction_id ='$transactionId' ")->result_array(); 
			if(count($itemnameList) > 0 )
			{
				$res=implode(',',$itemnameList[0]);
				
			    if($res==true) { $m=$res; } else{ $m="--"; }
			}else{$m="--";  }
			$package2['items'] = $m;
			$package2['transactionid']=$transactionId;
			$mem2[]=(object) $package2;
		}
		
		 return $mem2;
	}

	public function get_report_refund_data($table, $start, $end, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('mt.status,mt.invoice_no,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.add_date >=', $start);
		$this->db->where('r.add_date <=', $end);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result();

	}



	function select_request_id($table,$id)
	{
		
	   $this->db->where('id',$id);
	   $query=$this->db->get($table);
	  
	   return $query->row();  

	}

	function select_request_id_api($table,$id)
	{
		
	   $this->db->where('id',$id);
	   $query=$this->db->get($table);
	  
	   return $query->result_array();  

	}

}