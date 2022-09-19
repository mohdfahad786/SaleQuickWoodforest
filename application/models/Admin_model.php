<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Admin_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function s_fee($table, $condition) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('id', $condition);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function s_fee_merchant($table, $condition) {
		$this->db->select('text_email,point_sale,f_swap_Text');
		$this->db->from($table);
		$this->db->where('id', $condition);
		$query = $this->db->get();
		return $query->result_array();
	}

	//  count the pos item Here //
	public function check_pos_optimized_inv($table,$transaction_id) {   
		$query = $this->db->query("SELECT * FROM $table WHERE transaction_id='$transaction_id'  ");
		return $query->result_array();
	}
	public function get_refund_by_id($id) {
		$getrefundsdata=$this->db->query("SELECT * FROM refund WHERE  id='$id' ")->result_array();
		return $getrefundsdata; 
	}

	//search_refunds_of_pos
	public function data_get_refund($table,$id) {   
		$this->db->where('id',$id);   
		$getpaymentsdata=$this->db->get($table)->row_array();
		
		$invoice_no = $getpaymentsdata['invoice_no']; 
		$merchant_id = $getpaymentsdata['merchant_id'];
		$transaction_id = $getpaymentsdata['transaction_id'];   // AND transaction_id='$transaction_id' 
		$payment_id = $getpaymentsdata['payment_id'];   
		$payment_type = $getpaymentsdata['payment_type'];
		$split_payment_id=$getpaymentsdata['split_payment_id'];
		// $getrefundsdata=$this->db->query("SELECT * FROM refund WHERE  invoice_no='$invoice_no' AND merchant_id='$merchant_id' ")->result_array();
		if($payment_type == 'recurring') {
			$getrefundsdata=$this->db->query("SELECT R.* FROM refund R join customer_payment_request C on C.invoice_no= R.invoice_no WHERE R.payment_id = '$payment_id' and C.status='Chargeback_Confirm' AND R.merchant_id = $merchant_id AND C.id = $id")->result_array();
		} else if($payment_type == 'straight') {
			$getrefundsdata=$this->db->query("SELECT R.* FROM refund R join customer_payment_request C on C.invoice_no= R.invoice_no WHERE R.invoice_no = '$invoice_no' and C.status='Chargeback_Confirm' AND R.merchant_id = $merchant_id AND C.id = $id")->result_array();
		}
		else if($payment_type == 'app') {
			if($getpaymentsdata['transaction_type']=='split')
			{
				 $getrefundsdata = $this->db->query("SELECT R.* FROM refund R join pos C on C.split_payment_id= R.payment_id WHERE R.payment_id = '$split_payment_id' and C.status='Chargeback_Confirm' AND R.merchant_id = $merchant_id AND C.id = $id")->result_array();
			}
			else
			{
				$getrefundsdata = $this->db->query("SELECT R.* FROM refund R join pos C on C.invoice_no= R.invoice_no WHERE R.invoice_no = '$invoice_no' and C.status='Chargeback_Confirm' AND R.merchant_id = $merchant_id AND C.id = $id")->result_array();
			}

			
		}
		else
		{
			$getrefundsdata=$this->db->query("SELECT R.* FROM refund R join pos C on C.invoice_no= R.invoice_no WHERE R.invoice_no = '$invoice_no' and C.status='Chargeback_Confirm' AND R.merchant_id = $merchant_id AND C.id = $id")->result_array();
		}
		//echo $this->db->last_query();die;
		return $getrefundsdata;  
	}
	
	public function get_search_refund_data($table, $merchant_id, $start, $end, $status) {
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
		$query = $this->db->get();
		return $query->result();

	}
	public function get_search_refund_data_vts($table, $merchant_id, $start, $end, $status) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$is_for_vts='true';
		$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount,r.id as refund_row_id, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start);
		$this->db->where('r.date_c <=', $end);
		$this->db->where('mt.status', $status);
		$this->db->where('mt.is_for_vts', $is_for_vts);
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$this->db->order_by("r.id", "desc");
		$query = $this->db->get();
		return $query->result();

	}
	public function data_get_where_pos_itemsList($table, $id) {
		$this->db->where('id', $id);
		$getpaymentsdata = $this->db->get($table)->row_array();
		$transaction_id = $getpaymentsdata['transaction_id'];
		$invoice_no = $getpaymentsdata['invoice_no'];
		$transaction_type = $getpaymentsdata['transaction_type'];
		if($transaction_type == 'split') {
			$getitemsListdata = $this->db->query("SELECT i.name item_name,c.quantity,c.discount_amount,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status=2 and c.transaction_id='" . $invoice_no . "'")->result_array();
            
		} else {
			$getitemsListdata = $this->db->query("SELECT i.name item_name,c.quantity,c.discount_amount,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $invoice_no . "'")->result_array();
		}
		return $getitemsListdata;

	}
	public function data_get_where_pos_itemsList_copy($table,$id) {   
		$this->db->where('id',$id);  
		$getpaymentsdata=$this->db->get($table)->row_array();
	    $transaction_id=$getpaymentsdata['transaction_id']; 
		$getItemsListdata=$this->db->query("SELECT * FROM adv_pos_cart_item WHERE  transaction_id='$transaction_id'  AND `status`='2' ")->result_array();
		 
		if(count($getItemsListdata) > 0 ) {
			$getitemsListdata=$this->db->query(" SELECT adv_pos_item.name item_name,adv_pos_cart_item.price,adv_pos_cart_item.transaction_id from adv_pos_item join adv_pos_cart_item on adv_pos_item.id=adv_pos_cart_item.item_id WHERE adv_pos_cart_item.transaction_id='$transaction_id' AND adv_pos_cart_item.status='2' ")->result_array(); 
	 	} else {
         	$getitemsListdata=array();  
	 	}
		return $getitemsListdata;   

	}
	public function data_get_where_1($table, $condition) {
		$this->db->order_by("id", "desc");
		$wf_merchants=$this->session->userdata('wf_merchants');
		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	               $this->db->where('id', $x[$i]);
	            }else{
	                $this->db->or_where('id', $x[$i]);
	            }
	        
	        } 
	     }else{
	     	$this->db->where('id IS NULL', null, false);
	     }
		$q = $this->db->get_where($table, $condition);
		
		return $q->result_array();
	}
	

	public function data_get_where_month($table, $condition) {
		$this->db->order_by("month", "desc");
		$q = $this->db->get_where($table, $condition);
		return $q->result_array();
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
		$query = $this->db->get($table);
		return $query->result();
	}
	public function get_full_details_pos_new_admin($table) {
		$date = date('Y-m-d', strtotime('-60 days'));
		//$date ='2018-01-01';
		//$this->db->where('status !=', 'Chargeback_Confirm' );
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}
	public function graph($table, $condition) {
		$this->db->get_where($table, $condition);
	}
	public function data_get_where_2($table) {
		$this->db->order_by("id", "desc");
		$q = $this->db->get_where($table);
		return $q->result_array();
	}
	public function data_get_where($table, $condition) {
		$this->db->order_by("id", "desc");
		$q = $this->db->get_where($table, $condition);
		return $q->result();
	}
	public function data_get_where_dow($table, $end_date, $start_date) {
		$this->db->select('amount,tax,type,date_c,reference');
		$this->db->from($table);
		$this->db->where('date_c >=', $start_date);
		$this->db->where('date_c <=', $end_date);
		$this->db->where('status', 'confirm');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		//return $query->result_array();
		return $query->result();
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
		$this->db->where('date_c >=', $start_date);
		$this->db->where('date_c <=', $end_date);
		$this->db->where('status!=', 'pending');
		$this->db->where('status!=', 'block');
		$this->db->where('status!=', 'declined');
		$this->db->where('merchant_id', $merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		// echo $this->db->last_query();die;
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
	public function data_get_where_down_join($table, $end_date, $start_date, $merchant_id) {
		if ($table == "pos") {
			$this->db->select('mt.amount,mt.tax,mt.card_type,mt.type,mt.date_c,mt.date_r,mt.reference,mt.status,r.date_c as refund_dt,r.amount as refund_amount');
		} else {
			$this->db->select('mt.amount,mt.tax,mt.card_type,mt.type,mt.date_c,mt.reference,mt.status,r.date_c as refund_dt,r.amount as refund_amount');
		}
		$this->db->from($table . " mt");
		$this->db->where('mt.date_c >=', $start_date);
		$this->db->where('mt.date_c <=', $end_date);
		$this->db->where('mt.status!=', 'pending');
		$this->db->where('mt.status!=', 'block');
		$this->db->where('mt.status!=', 'declined');
		$this->db->where('mt.merchant_id', $merchant_id);
		$this->db->join('refund r', 'mt.invoice_no = r.invoice_no', 'left');
		$this->db->order_by("mt.id", "desc");
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		//return $query->result_array();
		return $query->result();
	}
	public function get_refund_data($end_date, $start_date, $merchant_id) {
		$this->db->select('mt.amount,mt.tax,mt.tip_amount,mt.card_type,mt.type,mt.date_c,mt.reference,mt.name,mt.status,r.add_date as refund_dt,r.amount as refund_amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status!=', 'pending');
		$this->db->where('mt.status!=', 'block');
		$this->db->where('mt.status!=', 'declined');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('mt.amount,mt.tax,mt.tip_amount,mt.card_type,mt.type,mt.date_c,mt.reference,mt.name,mt.status,r.add_date as refund_dt,r.amount as refund_amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status!=', 'pending');
		$this->db->where('mt.status!=', 'block');
		$this->db->where('mt.status!=', 'declined');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join('customer_payment_request mt', 'mt.invoice_no = r.invoice_no');
		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . " UNION ALL " . $query2);
		return $query->result();
	}
	public function data_get_where_down_pos($table, $end_date, $start_date, $merchant_id) {
		$this->db->select('amount,tax,protector_tax,card_type,type,date_c,reference,status');
		$this->db->from($table);
		$this->db->where('date_c >=', $start_date);
		$this->db->where('date_c <=', $end_date);
		$this->db->where('status!=', 'pending');
		$this->db->where('status!=', 'block');
		$this->db->where('merchant_id', $merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		//return $query->result_array();
		return $query->result();
	}
	public function data_get_where_g($table, $condition) {
		$this->db->order_by("id", "desc");
		$this->db->select('amount,tax,type,date_c,reference');
		if($this->session->userdata('assign_merchant'))
		{   $merchantid=explode(',',$this->session->userdata('assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
		}

		$q = $this->db->get_where($table, $condition);
		return $q->result_array();
	}
	public function data_get_where_gg($start_date, $end_date, $status, $merchant_id, $employ, $table) {
		$this->db->select('amount,tax,type,date_c,reference');
		$this->db->from($table);
		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		} else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('date_c >', $date);
		}
		if ($status != '') {
			$this->db->where('status', $status);
		}
		if ($employ != 'all' or $employ != 'merchant') {
			$this->db->where('sub_merchant_id', $employ);
		}
		$this->db->where('merchant_id', $merchant_id);
		//$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	public function data_get_where_ggg($start_date, $end_date, $status, $employ, $table) {
		$this->db->select('amount,tax,type,date_c,reference');
		$this->db->from($table);
		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		} else {
			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('date_c >', $date);
		}if ($status != '') {
			$this->db->where('status', $status);
		}
		if ($employ != 'all') {
			$this->db->where('merchant_id', $employ);
		}
		//$this->db->where('merchant_id',$merchant_id);
		//$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	public function data_get_where_ggg_1($start_date, $end_date, $status, $employ, $table) {
		$this->db->select('amount,tax,type,date_c,reference');
		$this->db->from($table);

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		} else {

			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('date_c >', $date);

		}
		if ($status != '') {

			$this->db->where('status', $status);
			$this->db->or_where('status', 'Chargeback_Confirm');

		}

		if ($employ !='all' && $employ!="" ) {
             $employId=explode(',',$employ); 
			 $this->db->where_in('merchant_id', $employId);

		}
		//  $this->db->where('merchant_id',$merchant_id);
		//	$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result_array();

	}

	public function data_get_where_ggg_refund($start_date, $end_date, $status, $employ, $table) {

		

		$this->db->select('mt.amount,mt.tax,mt.type,mt.reference,r.add_date as date_c');
		$this->db->from("refund r");
		if ($start_date != '') {

			$this->db->where('r.date_c >=', $start_date);

			$this->db->where('r.date_c <=', $end_date);

		} else {

			$date = date('Y-m-d', strtotime('-30 days'));
			$this->db->where('r.date_c >', $date);

		}
		if ($employ!='all' && $employ!="") {
			$merchantId=explode(',',$employ); 
			$this->db->where_in('mt.merchant_id', $merchantId);
		}
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();

		// print_r($this->db->last_query());
		// die("m");
		return $query->result();

	}

	public function data_get_where_serch_pos($table, $var) {

		$end = substr($var, 12, 4);
		$start_c = substr($var, 0, 6);

		$this->db->select('mobile_no,email_id');
		$this->db->from($table);
		$this->db->where('card_no LIKE', $start_c . '__________');
		$this->db->where('card_no LIKE', '____________' . $end);
		// $this->db->where('status!=','pending');
		// $this->db->where('status!=','block');
		// $this->db->where('merchant_id',$merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		//	return $query->result_array();
		return $query->result();

	}

	public function data_get_where_serch_pos_pos($table, $var) {

		$end = substr($var, 12, 4);
		$start_c = substr($var, 0, 6);
		$this->db->select('mobile_no,email_id');
		$this->db->from($table);
		$this->db->where('card_no LIKE', '_______________' . $end);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);
		$query = $this->db->get();
		//	return $query->result_array();
		return $query->result();

	}

	public function data_get_where_serch($table, $condition) {
		$this->db->order_by("id", "asc");
		$q = $this->db->get_where($table, $condition);
		return $q->result();
	}

	public function data_get_where_3($table) {
		$this->db->order_by("id", "desc");
		$q = $this->db->get_where($table);
		return $q->result();
	}

	function get_payment_details_3($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant');
		return $query->result();
	}

	public function update_data($table, $data, $condition) {
		$this->db->where($condition);
		$this->db->update($table, $data);
		return true;
	}


	public function insert_data($table, $data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function delete_item($table, $condition) {
		$this->db->where($condition);
		$this->db->delete($table);
		return true;
	}

	public function get_data($table) {
		$q = $this->db->get($table);
		return $q->result_array();
	}

	function get_search($start_date, $end_date, $status, $table) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}

		$query = $this->db->get($table);

		return $query->result();

	}

	function get_search_merchant($start_date, $end_date, $status, $merchant_id, $table) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <', $end_date);

		} else {

			$date = date('Y-m-d', strtotime('-30 days'));

			$this->db->where('date_c >=', $date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		$this->db->where('merchant_id', $merchant_id);
		//	$this->db->order_by("id", "desc");

		$query = $this->db->get($table);

		return $query->result();

	}

	function get_search_merchant_type($start_date, $end_date, $status, $merchant_id, $table, $type) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('payment_type', $type);
		$query = $this->db->get($table);

		return $query->result();

	}

	function get_search_merchant_pos($start_date, $end_date, $status, $merchant_id, $table) {

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
		$query = $this->db->get($table);
		return $query->result();
	}

	function get_search_merchant_pos_wb($start_date, $end_date, $status, $merchant_id, $table,$woocommerce) {

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
		$this->db->where('woocommerce', $woocommerce);
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result();
	}
	
		function get_search_merchant_pos_late($start_date, $end_date, $status, $merchant_id, $table,$late_end) {

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
		$query = $this->db->get($table);
		return $query->result();
	}
	
	function get_search_merchant_pos_recurring_payment_request($start_date, $end_date, $status, $merchant_id, $table,$recurring) {

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
// 		if ($status != '') {
// 			$this->db->where('status', $status);
// 		}
			$this->db->where('payment_type', $recurring);
		
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result();
	}
	
		function get_search_merchant_pos_paid_list($start_date, $end_date, $status, $merchant_id, $table) {

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
			//$this->db->where('status', $status OR status ='Chargeback_Confirm');
			$this->db->where("(status ='" .trim($status)."' OR status ='Chargeback_Confirm' )");
			//$this->db->or_where('status', 'Chargeback_Confirm');
		}
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result();
	}

	function get_search_merchant_pos_paid_list_wb($start_date, $end_date, $status, $merchant_id, $table,$woocommerce) {

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
			//$this->db->where('status', $status OR status ='Chargeback_Confirm');
			$this->db->where("(status ='" .trim($status)."' OR status ='Chargeback_Confirm' )");
			//$this->db->or_where('status', 'Chargeback_Confirm');
		}
		$this->db->where('woocommerce', $woocommerce);
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result();
	}
		function get_search_merchant_pos_paid_list1($start_date, $end_date, $status, $merchant_id, $table) {

		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		}
		else if ($start_date==$end_date)
		{
			$this->db->where('date_c', $end_date);
		}
		else {
			$date = date('Y-m-d', strtotime('-60 days'));
			$this->db->where('date_c >=', $date);
			$this->db->where('date_c <=', date('Y-m-d'));
		}
// 		if ($status != '') {
// 			$this->db->where('status', $status);
// 		}
		
		if ($status != '') {

			$this->db->where('status', $status);
			$this->db->or_where('status', 'Chargeback_Confirm');

		}
		
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result();
	}

	function get_package_details_new($date1, $status) {

		if ($date1 != '') {

			$this->db->where('date_c', $date1);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		
		$query = $this->db->get('payment_request');

		return $query->result();

	}

	function delete_package($id) {
		$this->db->where('id', $id);

		return $this->db->delete('merchant') ? True : False;
	}

	function active_order($id) {
		$this->db->where('id', $id);
		return $this->db->update('merchant', array('status' => 'active')) ? True : False;
	}
	function stop_recurring($id) {
		$query = $this->db->select('invoice_no')->where('id', $id)->get('customer_payment_request')->result();
		$invoice_no = $query[0]->invoice_no;
		$this->db->where('invoice_no', $invoice_no);
		$this->db->update('customer_payment_request', array('recurring_payment' => 'stop'));
	}
	function start_recurring($id) {
		$query = $this->db->select('invoice_no')->where('id', $id)->get('customer_payment_request')->result();
		$invoice_no = $query[0]->invoice_no;
		$this->db->where('invoice_no', $invoice_no);
		$this->db->update('customer_payment_request', array('recurring_payment' => 'start'));
	}

	function stop_tex($id) {
		$this->db->where('id', $id);
		$this->db->update('tax', array('status' => 'block'));
	}
	function start_tex($id) {
		$this->db->where('id', $id);
		$this->db->update('tax', array('status' => 'active'));
	}
	
	function stop_charges($id) {
		$this->db->where('id', $id);
		$this->db->update('other_charges', array('status' => 'block'));
	}
	function start_charges($id) {
		$this->db->where('id', $id);
		$this->db->update('other_charges', array('status' => 'active'));
	}

	function get_package_details_merchant($start_date, $end_date, $status) {
        
		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		$this->db->where('user_type', 'merchant');
		$query = $this->db->get('merchant');

		return $query->result();

	}
	
		function get_package_details_merchant_list($start_date, $end_date, $status) {
		    
		$this->db->select("id,name,email,mob_no,t_fee,auth_key,business_dba_name,business_name,status,business_name,created_on");
		$this->db->from('merchant');
        
		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		$this->db->where('user_type', 'merchant');
		$query = $this->db->get();

		return $query->result();

	}

	function get_package_details_subadmin_merchant($start_date, $end_date, $status) {
		$merchantid=explode(',',$this->session->userdata('assign_merchant'));
		if($merchantid!="")
		{
			$this->db->where_in('id', $merchantid);
		}
		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		$this->db->where('user_type', 'merchant');
		$query = $this->db->get('merchant');
        //   print_r($this->db->last_query());  die(); 
		return $query->result();

	}


	function get_package_details_merchant_sub($start_date, $end_date, $status,$id) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		
		if ($id != "") {
		
			$this->db->where('merchant_id', $id);

		}
		$this->db->where('user_type', 'employee');
		$query = $this->db->get('merchant');

		return $query->result();

	}

	function get_package_details_subadmin_merchant_sub($start_date, $end_date, $status) {
		$merchantid=explode(',',$this->session->userdata('assign_merchant')); 
		if($merchantid!="") { $this->db->where_in('merchant_id', $merchantid); }
		if ($start_date != '') {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		}
		if ($status != '') { $this->db->where('status', $status); }
		$this->db->where('user_type', 'employee');
		$query = $this->db->get('merchant');
		// echo $this->db->last_query(); die; 
		return $query->result();

	}


	function get_package_details_merchant1($start_date, $end_date, $status) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}

		$query = $this->db->get('d_online');

		return $query->result();

	}

	function get_package_details_merchant1a($start_date, $end_date) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		}

		$this->db->where('name!=', '');
		$this->db->where('email!=', '');
		$this->db->where('phone!=', '');

		$query = $this->db->get('d_online');

		return $query->result();

	}

	function get_package_details_merchant2($start_date, $end_date, $status) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}

		$merchant_id = $this->session->userdata('merchant_id');

		if ($merchant_id != '') {

			$this->db->where('merchant_id', $merchant_id);

		}

		$query = $this->db->get('r_call');

		return $query->result();

	}

	function get_package_details_merchant2a($start_date, $end_date) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);

			$this->db->where('date_c <=', $end_date);

		}

		$query = $this->db->get('r_call');

		return $query->result();

	}

	function get_subadmin_details($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('sub_admin');
		return $query->result();
	}

	function get_user_details($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('user');
		return $query->result();
	}
	
	public function get_employee_menu($id,$merchant_id)
	{
		if ($id != "" && $merchant_id!="" ) {
			$this->db->where('employee_id', $id);
			$this->db->where('merchant_id', $merchant_id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant_menu');
		return $query->result();

		
	}
	function get_employee_details($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant');
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

	function get_package_details_admin($date1, $status) {

		if ($date1 != '') {

			$this->db->where('date_c', $date1);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}

		$this->db->where('payment_type', 'straight');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('customer_payment_request');

		return $query->result();

	}

	function get_package_details_customer_r($start_date, $end_date, $status, $merchant_id) {

		if ($start_date != '') {

			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <', $end_date);

		}
		if ($status != '') {

			$this->db->where('status', $status);

		}
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('payment_type', 'recurring');
		$query = $this->db->get('customer_payment_request');

		return $query->result();

	}

	function get_package_details_customer_rr($date1, $status, $merchant_id) {

		if ($date1 != '') {
			$this->db->where('date_c', $date1); 
		}
		if ($status != '') {

			$this->db->where('status', $status);

		}

		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('status', 'confirm');
		$query = $this->db->get('customer_payment_request');

		return $query->result();

	}
	public  function  get_singleGroup_filter_customer_admin($date1,$date2, $status,$invoice_no)
	{
		$date = date('Y-m-d', strtotime('-30 days'));
		$today=date('');
		//$this->db->where('recurring_next_pay_date >=', $date1);
		//$this->db->where('recurring_next_pay_date <=', $date2);
			if ($status != '') {
				switch($status){
					case "confirm":
						$this->db->where('status', $status);
						
					break;

					case "pending":
						$this->db->where('recurring_next_pay_date >=', $date1);
		                $this->db->where('recurring_next_pay_date <=', $date2);
						$this->db->where('status', $status);
					break; 

					case "late":
					  $this->db->where('recurring_next_pay_date <', $today);
						
					  $this->db->where('status', $status);
					break; 
				}
		} 
		//echo $invoice_no;  die();
		$this->db->where('payment_type', 'recurring');
		$this->db->where('invoice_no', $invoice_no);
		$this->db->order_by("id", "desc");
		
		$query = $this->db->get('customer_payment_request');
		//print_r($query->result());   die(); 
		return $query->result_array();

	}

	public function get_full_details_payment_admin_copy($table) {
        $date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('payment_type', 'recurring');
		$this->db->where('recurring_pay_start_date >=',$date );
		$merchant_id = $this->session->userdata('merchant_id');

		if ($merchant_id != '') {

			$this->db->where('merchant_id', $merchant_id);

		}

		$this->db->distinct();
		$this->db->select('invoice_no');
		
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
         
		//return $query->result();
        $mem=array();
		foreach ($query->result() as $row) {
			$invoice_No=$row->invoice_no;
			 
            $this->db->where('payment_type', 'recurring');
			$this->db->where('invoice_no', $invoice_No);
		   $this->db->order_by("id", "desc");
		   $each = $this->db->get($table)->row();
		 array_push($mem, $each); 
	  }
	  return $mem;

	}

	public function get_full_details_payment_admin($table) {
        $date = date('Y-m-d', strtotime('-30 days'));
		$merchant_id = $this->session->userdata('merchant_id');
		if($merchant_id!="")
		{
			$query = $this->db->query("SELECT * FROM $table WHERE payment_type='recurring' AND no_of_invoice='1' AND merchant_id='$merchant_id' AND date_c >= '$date' GROUP BY invoice_no ORDER BY id DESC ");

		}
		else
		{
			$query = $this->db->query("SELECT * FROM $table WHERE payment_type='recurring' AND no_of_invoice='1'  AND date_c >= '$date' GROUP BY invoice_no ORDER BY id DESC ");

		}
		$mem=array(); 
		foreach ($query->result() as $row) {
			$invoice_No=$row->invoice_no;
			$row_id=$row->id;
			$this->db->where('id', $row_id);
		    $each = $this->db->get($table)->row();
		    array_push($mem, $each); 
	  }
	  return $mem;

	}


	function get_package_details_customer_admin($date1,$date2, $status) {
		
        $curentDate=date('Y-m-d'); 
		$merchant_id = $this->session->userdata('merchant_id');
		$query = $this->db->query("SELECT * FROM `customer_payment_request` WHERE payment_type='recurring' AND no_of_invoice='1' AND merchant_id='$merchant_id' AND date_c <= '$date2' AND date_c >= '$date1' GROUP BY invoice_no ORDER BY id DESC ");
		$mem=array();
		$a=1; 
		foreach ($query->result() as $row) {
			$invoice_id=$row->invoice_no;
			$merchant_id=$row->merchant_id;
			$row_id=$row->id;
			if($row->recurring_count  > 0){ $row->recurring_count =$row->recurring_count; }elseif($row->recurring_count < 0){ $row->recurring_count=1; }else{ $row->recurring_count=1; }
		    $this->db->where('id', $row_id);
			$table='customer_payment_request'; 
			$this->db->get($table)->row();

			if ($status != '') {
				switch($status){

					 case "confirm":
					    $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
						$DGetAllpaidRecord=$GetAllpaidRecord->result();
						$AllPaidRequest=count($DGetAllpaidRecord);

						$GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
						$DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
						$AllUnPaidRequest=count($DGetAllUnpaidRecord);


						$GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
						$df=$GetPrevResult->result_array(); 
						$is_prev_paid=count($df); 

					 if( $row->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ( $row->recurring_payment=='stop' ||  $row->recurring_payment=='complete')   && $is_prev_paid <='0') { 
					     array_push($mem, $row); 
					   } else {  $each=array();  }
					 break;

				 	case "pending":
						$GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
						$DGetAllpaidRecord=$GetAllpaidRecord->result();
						$AllPaidRequest=count($DGetAllpaidRecord);
			
						$GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
						$DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
						$AllUnPaidRequest=count($DGetAllUnpaidRecord);
			
			
						$GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
						$df=$GetPrevResult->result_array(); 
						$is_prev_paid=count($df);  

					   if( $is_prev_paid <='0' &&  $AllUnPaidRequest >='0' && $row->recurring_payment=='start'  && $row->recurring_count > $AllPaidRequest  ){ 
						     array_push($mem, $row); 
					   } else {  $each=array();  }
				 	break; 
				 	
				 	case "late":
						$GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
						$DGetAllpaidRecord=$GetAllpaidRecord->result();
						$AllPaidRequest=count($DGetAllpaidRecord);
			
						$GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
						$DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
						$AllUnPaidRequest=count($DGetAllUnpaidRecord);
			
			
						$GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
						$df=$GetPrevResult->result_array(); 
						$is_prev_paid=count($df);  

				 	if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'  ){
					  array_push($mem, $row); 
				  	} else {  $each=array();  }
				 	break; 
				 	
				 	default :
				   		$each=array(); array_push($mem, $row); 
				 		break; 
				}
		   }
		   else{
			   array_push($mem, $row); 
		   }
	     }
	  return $mem;  

	}

	function get_package_details_customer_admin_api($status,$merchant_id,$start_limit,$limit) {
		
        $curentDate=date('Y-m-d'); 
		//$merchant_id = $this->session->userdata('merchant_id');
		$query = $this->db->query("SELECT * FROM `customer_payment_request` WHERE payment_type='recurring' AND no_of_invoice='1' AND merchant_id='$merchant_id'  GROUP BY invoice_no ORDER BY id DESC limit $start_limit,$limit ");
		$mem=array();
		$a=1; 
		foreach ($query->result() as $row) {
			$invoice_id=$row->invoice_no;
			$merchant_id=$row->merchant_id;
			$row_id=$row->id;
			if($row->recurring_count  > 0){ $row->recurring_count =$row->recurring_count; }elseif($row->recurring_count < 0){ $row->recurring_count=1; }else{ $row->recurring_count=1; }
		    $this->db->where('id', $row_id);
			$table='customer_payment_request'; 
			$this->db->get($table)->row();

			if ($status != '') {
				switch($status){

					 case "confirm":
					    $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
						$DGetAllpaidRecord=$GetAllpaidRecord->result();
						$AllPaidRequest=count($DGetAllpaidRecord);

						$GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
						$DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
						$AllUnPaidRequest=count($DGetAllUnpaidRecord);


						$GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
						$df=$GetPrevResult->result_array(); 
						$is_prev_paid=count($df); 

					 if( $row->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ( $row->recurring_payment=='stop' ||  $row->recurring_payment=='complete')   && $is_prev_paid <='0') { 
					     array_push($mem, $row); 
					   } else {  $each=array();  }
					 break;

				 	case "pending":
						$GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
						$DGetAllpaidRecord=$GetAllpaidRecord->result();
						$AllPaidRequest=count($DGetAllpaidRecord);
			
						$GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
						$DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
						$AllUnPaidRequest=count($DGetAllUnpaidRecord);
			
			
						$GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
						$df=$GetPrevResult->result_array(); 
						$is_prev_paid=count($df);  

					   if( $is_prev_paid <='0' &&  $AllUnPaidRequest >='0' && $row->recurring_payment=='start'  && $row->recurring_count > $AllPaidRequest  ){ 
						     array_push($mem, $row); 
					   } else {  $each=array();  }
				 	break; 
				 	
				 	case "late":
						$GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
						$DGetAllpaidRecord=$GetAllpaidRecord->result();
						$AllPaidRequest=count($DGetAllpaidRecord);
			
						$GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
						$DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
						$AllUnPaidRequest=count($DGetAllUnpaidRecord);
			
			
						$GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
						$df=$GetPrevResult->result_array(); 
						$is_prev_paid=count($df);  

				 	if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'  ){
					  array_push($mem, $row); 
				  	} else {  $each=array();  }
				 	break; 
				 	
				 	default :
				   		$each=array(); array_push($mem, $row); 
				 		break; 
				}
		   }
		   else{
			   array_push($mem, $row); 
		   }
	     }
	  return $mem;  

	}
	public function get_subadmin_package_details($id = "") {
  
		if ($id != "") {
			// $id = intval($id);
			// $this->db->where('id', $id); 
			$this->db->where_in('id', $id);
		}
		$this->db->where('user_type', 'merchant');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
		// print_r($query->result());  die; 
		return $query->result();
	}
	public function get_package_details($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id); 

		}
		$this->db->where('user_type', 'merchant');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
		return $query->result();
	}

	public function get_package_details_active_merchant($id = "") {
		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id); 
		}
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
		return $query->result();
	}

	public function get_package_details_sub($id = "") {
		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);

		}
		$this->db->where('user_type', 'employee');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
        
		return $query->result();
	}
	public function get_package_details_sub_by_id($id = "") {

		
		if ($id != "") {
			$id = intval($id);
			$this->db->where('merchant_id', $id);

		}
		$this->db->where('user_type', 'employee');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
        
		return $query->result();
	}
    public function get_package_details_subadmin_sub($id = "") {

		if ($id != "") {
			//$id = intval($id);
			$this->db->where_in('merchant_id', $id);

		}
		$this->db->where('user_type', 'employee');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
		// echo $this->db->last_query();  
		// print_r($query->result()); 
		// die(); 
		return $query->result();
	}
	public function get_package_support($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);

		}
		$this->db->where('name!=', '');
		$this->db->where('email!=', '');
		$this->db->where('phone!=', '');

		$this->db->order_by("id", "desc");
		$query = $this->db->get('d_online');

		return $query->result();
	}

	public function get_package_request($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);

		}

		$merchant_id = $this->session->userdata('merchant_id');

		if ($merchant_id != '') {

			$this->db->where('merchant_id', $merchant_id);

		}

		$this->db->order_by("id", "desc");
		$query = $this->db->get('r_call');

		return $query->result();
	}

	public function get_package_request_aa($id = "") {

		if ($id != "") {
			$id = intval($id);
			$this->db->where('id', $id);

		}

// 		$merchant_id = $this->session->userdata('merchant_id');

// 		if($merchant_id!=''){

// 		  $this->db->where('merchant_id',$merchant_id);

// 		}

		$this->db->order_by("id", "desc");
		$query = $this->db->get('r_call');

		return $query->result();
	}

	public function get_full_details($table) {

		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}
	
	public function get_full_details_subadmin($table) {

        $this->db->where('user_type','sub_admin');
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_agent_payout($merchant_id,$table) {
		$this->db->select('mt.*,ag.*');
		$this->db->from("agent_payout ag");
		$this->db->where('ag.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.id = ag.merchant_id');
		$query = $this->db->get();
		return $query->result();

	}

	public function get_full_details_agent_payout_id($id,$table) {
		$this->db->select('mt.*,ag.*');
		$this->db->from("agent_payout ag");
		$this->db->where('ag.id', $id);
		$this->db->join($table . ' mt', 'mt.id = ag.merchant_id');
		$query = $this->db->get();
		return $query->result();

	}
	public function get_full_details_agent($table) {

		$this->db->where('user_type','agent');
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}
	public function get_full_details_employee($table, $merchant_id) {
		$this->db->where('merchant_id', $merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_admin_report($table) {
		$date = date('Y-m-d', strtotime('-30 days'));

		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}
    public function get_report_refund_data($table, $start, $end, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start);
		$this->db->where('r.date_c <=', $end);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result();

	}
	public function get_full_details_admin_report_search($table, $date1, $date2, $employee, $status) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('payment_type', 'straight');
		if ($date1 != '') {
			$this->db->where('date_c >=', $date1);
			$this->db->where('date_c <=', $date2);
		} else {
			$this->db->where('date_c >=', $date);
		}
		if($status != '' && $status == 'confirm') {
			$this->db->where("(status ='" .trim($status)."' OR status ='Chargeback_Confirm' )");
		} else {
			$this->db->where('status =', $status);
		}
		if ($employee != '') {
			$this->db->where('merchant_id =', $employee);
		}

		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result();
	}
	
	public function get_full_details_admin_report_search_qb($table, $date1, $date2, $employee, $status) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('payment_type', 'straight');
		if ($date1 != '') {
			$this->db->where('date_c >=', $date1);
			$this->db->where('date_c <=', $date2);
		} else {
			$this->db->where('date_c >=', $date);
		}
// 		if($status != '' && $status == 'confirm') {
// 			$this->db->where("(status ='" .trim($status)."' OR status ='Chargeback_Confirm' )");
// 		} else {
// 			$this->db->where('status =', $status);
// 		}
		if ($employee != '') {
			$this->db->where('merchant_id =', $employee);
		}
          $this->db->limit(3, 0);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		// echo $this->db->last_query();die;
		return $query->result();
	}

	public function get_full_details_admin_report_search1($table, $date1, $date2, $status) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('payment_type', 'recurring');
		if ($date1 != '') {
			$this->db->where('date_c >=', $date1);
			$this->db->where('date_c <=', $date2);
		} else {
			$this->db->where('date_c >=', $date);
		}

		if ($status != '') {
			$this->db->where('status =', $status);
		}

		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_admin($table) {

		$this->db->where('payment_type', 'straight');
		$this->db->where('status!=', 'Chargeback_Confirm');
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_admin_orderby($table) {
		$this->db->select("mt.*, refund.add_date as refund_date,refund.amount as refund_amount");
		$this->db->from($table . ' mt');
		$this->db->join('refund', 'mt.invoice_no = refund.invoice_no', 'left');

		$this->db->where('payment_type', 'straight');
		$this->db->order_by('order_type desc');
		$this->db->order_by("mt.payment_date", "desc");
		$query = $this->db->get();

		return $query->result();
	}
	public function get_full_details_admin_orderby_new($table) {
        $date = date('Y-m-d', strtotime('-7 days'));   
		$this->db->select("mt.*, refund.add_date as refund_date,refund.amount as refund_amount");
		$this->db->from($table . ' mt');
		$this->db->join('refund', 'mt.invoice_no = refund.invoice_no', 'left');
        $this->db->where('mt.date_c >=', $date);   
		$this->db->where('payment_type', 'straight');
		$this->db->order_by('order_type desc');
		$this->db->order_by("mt.payment_date", "desc");
		$query = $this->db->get();

		return $query->result();
	}

	public function get_full_details_admin_a($table, $merchant_id) {

		$this->db->where('payment_type', 'straight');
		//$this->db->where('status !=', 'Chargeback_Confirm' );
		
		$curdate=date('Y-m-d'); 
		// $prev_date=date('Y-m-d', strtotime('-29 days', strtotime($curdate)));
		$prev_date=date('Y-m-d', strtotime('-29 days', strtotime($curdate)));
		//echo $curdate;  echo "<br/>"; echo $prev_date;  die(); 
		// $this->db->where('$accommodation >=', minvalue);
		// $this->db->where('$accommodation <=', maxvalue);

		$this->db->where('date_c >=', $prev_date);
		$this->db->where('date_c <=', $curdate);
		
		$this->db->where('merchant_id', $merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_payment($table, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));   

		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('payment_type', 'straight');
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_pos($table, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		if($merchant_id!="") {
			$this->db->where('merchant_id', $merchant_id);
		}
		$this->db->where('status !=', 'pending' );
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$this->db->group_by("invoice_no");
		$query = $this->db->get($table);
		return $query->result();
	}

	public function get_full_details_pos_wb($table, $merchant_id,$woocommerce) {
		$date = date('Y-m-d', strtotime('-30 days'));
		if($merchant_id!="") {
			$this->db->where('merchant_id', $merchant_id);
		}
		$this->db->where('status !=', 'pending' );
		$this->db->where('date_c >=', $date);
		$this->db->where('woocommerce', $woocommerce);
		$this->db->order_by("id", "desc");
		$this->db->group_by("invoice_no");
		$query = $this->db->get($table);
		return $query->result();
	}

	

	public function get_full_inventory_spdata($start_date, $end_date,$merchant_id) {
		$query=$this->db->query("SELECT `positm`.*, `poscat`.`name` as `cat_name`, `poscat`.`code` as `cat_code` FROM `adv_pos_item` `positm` JOIN `adv_pos_category` `poscat` ON `poscat`.`id` = `positm`.`category_id` WHERE DATE(`positm`.`created_at`) >='$start_date' AND DATE(`positm`.`created_at`) <= '$end_date' AND `positm`.`merchant_id` = '$merchant_id' AND `poscat`.`merchant_id` = '$merchant_id' ORDER BY `positm`.`created_at` DESC "); 
	    return $query->result();
	}
    public function get_full_inventory_data($merchant_id) {
		$this->db->select('positm.*,poscat.name as cat_name,poscat.code as cat_code');
		$this->db->from("adv_pos_item positm");
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('positm.created_at >=', $date);
		$this->db->where('positm.merchant_id', $merchant_id);
		$this->db->where('poscat.merchant_id', $merchant_id);
		$this->db->order_by("positm.created_at", "desc");
		$this->db->join('adv_pos_category poscat', 'poscat.id = positm.category_id');
		$query = $this->db->get();
		return $query->result(); 
	}
	
	 public function get_full_inventory_data_no_limit($merchant_id) {
		$this->db->select('positm.*,poscat.name as cat_name,poscat.code as cat_code');
		$this->db->from("adv_pos_item positm");
	//	$date = date('Y-m-d', strtotime('-30 days'));
	//	$this->db->where('positm.created_at >=', $date);
		$this->db->where('positm.merchant_id', $merchant_id);
		$this->db->where('poscat.merchant_id', $merchant_id);
		$this->db->order_by("positm.created_at", "desc");
		$this->db->join('adv_pos_category poscat', 'poscat.id = positm.category_id');
		$query = $this->db->get();
		return $query->result(); 
	}
	
	public function get_all_inventry_category($merchant_id)
	{
		
		$this->db->where('merchant_id',$merchant_id);
		
		$query = $this->db->get('adv_pos_category');

		return $query->result();
	}
	public function get_all_inventry_main_items($merchant_id)
	{
		$this->db->where('status','0');
		$this->db->where('merchant_id',$merchant_id);
		
		$query = $this->db->get('adv_pos_item_main');

		return $query->result();
	}
	public function get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id)
	{
		if($main_items!="")
		{
			//$query=$this->db->query("SELECT `cart`.*, `item`.`name` as `item_name`, `item`.`tax` as `tax`, `item`.`price` as `base_price`, `item`.`item_image` as `item_image`,`item`.`title` as `item_title`, `cat`.`name` as `cat_name` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id`  WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items' ORDER BY `cart`.`created_at` DESC "); 
		    //  Second Query : $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` , `item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`, SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN 'No-discount' ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `new_discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items'  GROUP BY `cart`.`item_id` ORDER BY `item`.`item_id` DESC"); 
		    $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` , `item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`, SUM(`cart`.`quantity`*`item`.`price`) as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items'  GROUP BY `cart`.`item_id` ORDER BY `item`.`item_id` DESC"); 
		}
		else
		{
			//$query=$this->db->query("SELECT `cart`.*, `item`.`name` as `item_name`, `item`.`tax` as `tax`, `item`.`price` as `base_price`, `item`.`item_image` as `item_image`,`item`.`title` as `item_title`, `cat`.`name` as `cat_name` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' ORDER BY `cart`.`created_at` DESC "); 
		    // Second  Query :: $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` , `item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`, SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN 'No-discount' ELSE sum(`cart`.`quantity`*`cart`.`new_price` -`cart`.`price`) END as `new_discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id'  GROUP BY `cart`.`item_id` ORDER BY `item`.`item_id` DESC"); 
		    $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` , `item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`,SUM(`cart`.`quantity`*`item`.`price`)  as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id'  GROUP BY `cart`.`item_id` ORDER BY `item`.`item_id` DESC"); 
		}return $query->result();
	}
	 public function getinventry_items_list($merchant_id,$item_id)
	 {

       $this->db->select(" `item`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,`item`.`price` as `base_price`,`cart`.`quantity` as `quantity`,`cart`.`new_price` as `new_price`,`cart`.`price` as `price`, (`cart`.`quantity` * `cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` AND `cart`.`quantity` * `cart`.`new_price`> `cart`.`price`) THEN `cart`.`quantity` * `cart`.`new_price`-`cart`.`price` WHEN ( `cart`.`quantity` * `cart`.`new_price` > `cart`.`price`) THEN (`cart`.`quantity` * `cart`.`new_price`)-`cart`.`price` ELSE (`cart`.`quantity` * `cart`.`new_price`)-`cart`.`price` END as `discount`,(`cart`.`quantity` * `item`.`price`) as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
        $this->db->from("adv_pos_cart_item cart");
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('cart.updated_at >=', $date);
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('cart.status', 2);
		$this->db->where('item.id',$item_id);
		$this->db->group_by("item.item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->order_by("item.item_id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get();
		//echo $this->db->last_query(); die("ol");     
		return $query->result();
	 }

	public function get_full_inventory_reportdata($merchant_id) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`, SUM(`cart`.`quantity`*`item`.`price`)  as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
	   //  Second Query //   $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN '' ELSE sum(`cart`.`quantity`*`cart`.`new_price`)-`cart`.`price` END as `discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
		//$this->db->select('cart.*,item.name as item_name,item.tax as tax,item.price as base_price,item.item_image as item_image,item.title as item_title,cat.name as cat_name');
		$this->db->from("adv_pos_cart_item cart");
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('cart.updated_at >=', $date);
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('cart.status', 2);
		$this->db->group_by("cart.item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->order_by("item.item_id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		// echo $this->db->last_query(); die("ol");    
		return $query->result();
	}
	
	public function get_full_inventory_reportdata_no_limit($merchant_id) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`, SUM(`cart`.`quantity`*`item`.`price`)  as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
	   //  Second Query //   $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN '' ELSE sum(`cart`.`quantity`*`cart`.`new_price`)-`cart`.`price` END as `discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
		//$this->db->select('cart.*,item.name as item_name,item.tax as tax,item.price as base_price,item.item_image as item_image,item.title as item_title,cat.name as cat_name');
		$this->db->from("adv_pos_cart_item cart");
		//$date = date('Y-m-d', strtotime('-30 days'));
		//$this->db->where('cart.updated_at >=', $date);
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('cart.status', 2);
		$this->db->group_by("cart.item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->order_by("item.item_id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		// echo $this->db->last_query(); die("ol");    
		return $query->result();
	}

	public function get_full_refund_data($table, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $date);
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result();

	}


	public function getallSplitrefund_by_splittransaction_id($table, $merchant_id,$splitTransaction_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $date);
		if ($merchant_id != "") {$this->db->where('r.merchant_id', $merchant_id);}
		if ($splitTransaction_id != "") {$this->db->where('r.payment_id', $splitTransaction_id);}
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getallSplitrefund($table, $merchant_id,$invoice_no) {
		//$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		//$this->db->where('r.date_c >=', $date);
		if ($merchant_id != "") {$this->db->where('r.merchant_id', $merchant_id);}
		if ($invoice_no != "") {$this->db->where('r.invoice_no', $invoice_no);}
		$query = $this->db->get();
		return $query->result();
	}
	public function get_full_customer_payment_refund_data($merchant_id) {
		$date = date('Y-m-d', strtotime('-60 days'));
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $date);
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join('customer_payment_request mt', 'mt.invoice_no = r.invoice_no');
		return $query = $this->db->get();
	}
	function get_user_by_id($id)
     {
        
	   $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('id', $id);   
        $this->db->where('status', 'active');
        $query = $this->db->get();
        return $query->row_array();
     }

	public function getallDistinct_Invoice($table)
    {
      $this->db->where('payment_type', 'recurring');
      $this->db->where('recurring_payment', 'start');
      $this->db->distinct();
      $this->db->select('invoice_no');
      $this->db->order_by("recurring_pay_start_date", "desc");
      $query = $this->db->get($table);
           
      //return $query->result();
          $mem=array();
      foreach ($query->result() as $row) {
        $invoice_No=$row->invoice_no;
              $this->db->where('payment_type', 'recurring');
        $this->db->where('invoice_no', $invoice_No);
         $this->db->order_by("id", "desc");
         $each = $this->db->get($table)->row();
       array_push($mem, $each); 
      }
      return $mem;
	}
	public function getallDistinct_Invoice_for_autopayment($table)
    {
      $this->db->where('payment_type', 'recurring');
      $this->db->where('recurring_payment', 'start');
      $this->db->where('recurring_pay_type', '1');
	  
      $this->db->distinct();
      $this->db->select('invoice_no');
      $this->db->order_by("recurring_pay_start_date", "desc");
      $query = $this->db->get($table);
      // echo $this->db->last_query();die;
         //return $query->result();
          $mem=array();
          foreach ($query->result() as $row) {
              $invoice_No=$row->invoice_no;
              $this->db->where('payment_type', 'recurring');
              $this->db->where('invoice_no', $invoice_No);
              $this->db->order_by("id", "desc");
              $each = $this->db->get($table)->row();
              array_push($mem, $each); 
          }
         return $mem;
	}

	public function getallDistinct_Invoice_for_autopayment_new($table)
    {
      $this->db->where('payment_type', 'recurring');
      $this->db->where('recurring_payment', 'start');
      $this->db->where('recurring_pay_type', '1');
      $this->db->where('token', '1');
	  
      $this->db->distinct();
      $this->db->select('invoice_no');
      //$this->db->limit(9,1);
      //$this->db->limit(10, 0);
      //$this->db->limit(limit, start);
      $this->db->order_by("recurring_pay_start_date", "desc");
      $query = $this->db->get($table);
      // echo $this->db->last_query();die;
         //return $query->result();
          $mem=array();
          foreach ($query->result() as $row) {
              $invoice_No=$row->invoice_no;
              $this->db->where('payment_type', 'recurring');
              $this->db->where('invoice_no', $invoice_No);
              $this->db->order_by("id", "desc");
              $each = $this->db->get($table)->row();
              array_push($mem, $each); 
          }
         return $mem;
	}

	public function getlast_request($table,$invoice_No,$merchant_id)
	{
		 $GetlastRecord=$this->db->query("SELECT * FROM $table WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_No'  ORDER BY id DESC  LIMIT 0,1 "); 
		 $DGetlastRecord=$GetlastRecord->row();
		 return $DGetlastRecord; 
	}

	public function getAllpaid_request($table,$invoice_No,$merchant_id)
	{
		$GetAllpaidRecord=$this->db->query("SELECT * FROM $table WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_No' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
		$DGetAllpaidRecord=$GetAllpaidRecord->result();
		return count($DGetAllpaidRecord);  
	}


	public function get_full_details_payment_r($table, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('payment_type', 'recurring');
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_payment_rr($table, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('status', 'confirm');
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_payment_rr_p($table, $merchant_id) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('status', 'pending');
		$this->db->where('date_c >=', $date);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_full_details_recurring($table) {
		$this->db->where('payment_type', 'recurring');
		$this->db->where('recurring_count_remain >', '0');
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);

		return $query->result();
	}

	public function get_recurring_details_payment($merchant_id, $id) {

		$this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date,r.payment_date');
		$this->db->from('recurring_payment r');
		$this->db->join('customer_payment_request c', 'r.p_id = c.id');
		$this->db->where('r.merchant_id', $merchant_id);

		$this->db->where('r.p_id', $id);

		
		return $result->result();

	}

	public function get_recurring_details_payment_rr($merchant_id, $id) {

		$this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.invoice_no,r.payment_id,r.add_date,r.payment_date');
		$this->db->from('recurring_payment r');
		$this->db->join('customer_payment_request c', 'r.p_id = c.id');
		$this->db->where('r.merchant_id', $merchant_id);

		$this->db->where('r.id', $id);

		$result = $this->db->get();
		return $result->result();

	}

	public function get_recurring_details_payment_rrr($merchant_id) {

		$this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.invoice_no,r.payment_id,r.add_date,r.payment_date');
		$this->db->from('recurring_payment r');
		$this->db->join('customer_payment_request c', 'r.p_id = c.id');
		$this->db->where('r.merchant_id', $merchant_id);

		$result = $this->db->get();
		return $result->result();

	}

	public function get_recurring_details_payment_admin1() {

		$this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.merchant_id,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');
		$this->db->from('recurring_payment r');
		$this->db->join('customer_payment_request c', 'r.p_id = c.id');
		$result = $this->db->get();
		return $result->result();

	}

	public function get_full_reports($filters) {

		$condtions = "";
		if (isset($filters['status']) and $filters['status'] != '') {
			$condtions .= " and fs.status='" . $filters['status'] . "'";
		}

		if (isset($filters['employee']) and $filters['employee'] != '') {
			$condtions .= " and m.id=" . $filters['employee'];
		}

		$query = $this->db->query("SELECT m.id,m.business_dba_name,fs.amount,fs.hold_amount,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,fs.status,(IFNULL((select sum(fee) from  recurring_payment where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  recurring_payment where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0) + IFNULL((select sum(amount) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c  <='" . $filters['date2'] . "'),0)) as totalAmount from merchant m left join funding_status fs on (fs.merchant_id=m.id and fs.date >='" . $filters['date'] . "' AND fs.date  <='" . $filters['date2'] . "' )  where  m.user_type='merchant' and m.status='Active' $condtions");
        //  print_r($this->db->last_query()); die("gy"); 
		return $query->result_array();

	}

	function getfundDetails($filters) {
		$query = $this->db->query("(select amount,invoice_no,add_date,email_id from  recurring_payment where merchant_id=" . $filters['id'] . " and date_c='" . $filters['date'] . "')union (select amount,invoice_no,add_date,email_id  from  pos where merchant_id=" . $filters['id'] . " and date_c='" . $filters['date'] . "')
		union (select amount,invoice_no,add_date,email_id  from  customer_payment_request where merchant_id=" . $filters['id'] . " and date_c='" . $filters['date'] . "')"
		);

		return $query->result_array();
	}

	function get_holdamount($filters) {
		$query = $this->db->query("select * from funding_status where merchant_id=" . $filters['mid'] . " and hold_amount>0 and date<>'" . $filters['cdate'] . "'");

		return $query->result_array();
	}

	function getLastpayment($filters) {
		//print_r($filters);
		$fromdate = date("Y", strtotime($filters['date'])) . "-" . date("m", strtotime($filters['date'])) . "-01";
		$query = $this->db->query("select count(*) as cnt from  funding_status where amount>0 and  merchant_id=" . $filters['merchant_id'] . " and  (date(date)>='" . $fromdate . "' and  date(date)<'" . $filters['date'] . "')");
		return $query->result_array();
	}

	function get_recurring_details_payment_search($date1, $status, $merchant_id) {

		$this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');
		$this->db->from('recurring_payment r');
		$this->db->join('customer_payment_request c', 'r.p_id = c.id');
		$this->db->where('r.merchant_id', $merchant_id);

		if ($date1 != '') {

			$this->db->where('r.date_c', $date1);

		}
		if ($status != '') {

			$this->db->where('r.status', $status);

		}

		$result = $this->db->get();
		return $result->result();

	}

	function get_recurring_details_payment_admin($date1, $status) {

		$this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.merchant_id,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');
		$this->db->from('recurring_payment r');
		$this->db->join('customer_payment_request c', 'r.p_id = c.id');

		if ($date1 != '') {

			$this->db->where('r.date_c', $date1);

		}
		if ($status != '') {

			$this->db->where('r.status', $status);

		}

		$result = $this->db->get();
		return $result->result();

	}
	public function search_record($searchby) {
		$this->db->select('*');
		$this->db->from('customer_payment_request');
		$this->db->where('id', $searchby);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	public function search_record_pos($searchby) {
		$this->db->select('*');
		$this->db->from('pos');
		$this->db->where('id', $searchby);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	public function search_record_pos_split($searchby,$merchant_id) {
		$this->db->select('*');
		$this->db->from('pos');
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('invoice_no', $searchby);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	public function search_pos($searchby) {
		$this->db->select('*');
		$this->db->from('pos');
		$this->db->where('id', $searchby);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	public function search_item($searchby) {
		$this->db->select('*');
		$this->db->from('order_item');
		$this->db->where('p_id', $searchby);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	public function search_record_un($searchby, $table) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('id', $searchby);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	public function delete_by_id($id, $table_name) {
		$this->db->where('id', $id);
		$this->db->delete($table_name);
	}
		public function delete_by_merchant_id($id, $table_name) {
		$this->db->where('merchant_id', $id);
		$this->db->delete($table_name);
	}
	public function block_by_id($id, $table_name) {
		$this->db->where('id', $id);
		$this->db->update($table_name, array('status' => 'block'));
	}
	public function confirm_email_id($id, $table_name) {
		$this->db->where('id', $id);
		$this->db->update($table_name, array('status' => 'confirm'));
	}
	public function active_by_id($id, $table_name) {
		$this->db->where('id', $id);
		$this->db->update($table_name, array('status' => 'active'));
	}
	public function get_merchant_data() {
		$this->db->select('*');
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
		public function get_merchant_data_new() {
		$this->db->select('*');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		//$this->db->limit(1, 0);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_admin() {
		$this->db->select('*');
		$this->db->where('user_type', 'merchant');
		$this->db->where('status', 'active');
		//$this->db->limit(0,50);
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

	public function get_merchant_data_new_particular() {
		$this->db->select('*');
		$this->db->where('user_type', 'merchant');
		$this->db->where('id', '272');
		$this->db->from('merchant');
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}

//  New Function For  Download data of Admin Panel 

public function data_get_where_dow_bymerchant($table, $end_date, $start_date,$merchant_id) {
	$this->db->select('amount,tax,tip_amount,type,date_c,reference,tip_amount,name');
	$this->db->from($table);
	$this->db->where('date_c >=', $start_date);
	$this->db->where('date_c <=', $end_date);
	if($merchant_id!=""){ $this->db->where_in('merchant_id',$merchant_id); }
	$this->db->where('status', 'confirm');
	$this->db->order_by("id", "desc");
	$query = $this->db->get();
	// echo $this->db->last_query();die;
	//return $query->result_array();
	return $query->result();
}

//   new models  Function for admin /subadmin  export data 

public function data_get_where_down_admin($table, $end_date, $start_date, $merchant_id) {
   
	//$getA_merchantData=$this->select_request_id('merchant',$merchant_id); 
   //if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 
   $name='name';

	if ($table == "pos") {
		 
		$this->db->select('amount,tax,tip_amount,card_type,type,date_c,date_r,reference,transaction_id,status,add_date');
		$this->db->select($name);
	} else {
		$this->db->select('amount,tax,card_type,type,date_c,reference,transaction_id,status,add_date');
		$this->db->select($name);  
	}
	$this->db->from($table);
	$this->db->where('date_c >=', $start_date);
	$this->db->where('date_c <=', $end_date);
	$this->db->where('status!=', 'pending');
	$this->db->where('status!=', 'block');
	$this->db->where('status!=', 'declined');
	if($merchant_id!="" && $merchant_id!='all'){ $this->db->where_in('merchant_id', $merchant_id); } 
	$this->db->order_by("id", "desc");
	$query = $this->db->get();
	$mem2 =  array(); 
	foreach($query->result()  as $row)
	{
		$package2['amount'] = $row->amount;
		$package2['tax'] =  $row->tax;
		$package2['tip'] =  $row->tip_amount;
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
public function get_refund_data_admin($end_date, $start_date, $merchant_id) {
	$this->db->select('mt.amount,mt.tax,mt.tip_amount,mt.card_type,mt.type,mt.date_c,mt.reference,mt.name,mt.status,r.add_date as refund_dt,r.amount as refund_amount');
	$this->db->from("refund r");
	$this->db->where('r.date_c >=', $start_date);
	$this->db->where('r.date_c <=', $end_date);
	$this->db->where('mt.status!=', 'pending');
	$this->db->where('mt.status!=', 'block');
	$this->db->where('mt.status!=', 'declined');
	if($merchant_id!="" && $merchant_id!='all') { $this->db->where_in('r.merchant_id', $merchant_id); } 
	$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
	$query1 = $this->db->get_compiled_select();

	$this->db->select('mt.amount,mt.tax,"0" as tip_amount, mt.card_type,mt.type,mt.date_c,mt.reference,mt.name,mt.status,r.add_date as refund_dt,r.amount as refund_amount');
	$this->db->from("refund r");
	$this->db->where('r.date_c >=', $start_date);
	$this->db->where('r.date_c <=', $end_date);
	$this->db->where('mt.status!=', 'pending');
	$this->db->where('mt.status!=', 'block');
	$this->db->where('mt.status!=', 'declined');
	if($merchant_id!="" && $merchant_id!='all') { $this->db->where_in('r.merchant_id', $merchant_id); } 
	$this->db->join('customer_payment_request mt', 'mt.invoice_no = r.invoice_no');
	$query2 = $this->db->get_compiled_select();

	$query = $this->db->query($query1 . " UNION ALL " . $query2);
	return $query->result();
}


	public function  get_refund_transaction($merchant_id,$invoice_no)
	{
		
		 $this->db->where('invoice_no',$invoice_no); 
		 $this->db->where('merchant_id',$merchant_id); 
		 $query = $this->db->get('refund');
		 return $query->row(); 
	}

	public function get_sales_summary_report($table, $end_date, $start_date,$merchant_id) {
		$this->db->select('amount,tax,tip_amount,type,date_c,reference,tip_amount,name');
		$this->db->from($table);
		$this->db->where('date_c >=', $start_date);
		$this->db->where('date_c <=', $end_date);
		$wf_merchants=$this->session->userdata('wf_merchants');
        $x=explode(",",$wf_merchants);
        $len=sizeof($x);
        if(!empty($wf_merchants)) {
				for ($i=0; $i <$len ; $i++) { 
		            if($i==0){
		               $this->db->where('merchant_id', $x[$i]);
		            }else{
		                $this->db->or_where('merchant_id', $x[$i]);
		            }
		        
		        }
		}else{
				$this->db->where('merchant_id IS NULL', null, false);
		}
		if($merchant_id != 'all') {
			$this->db->where('merchant_id',$merchant_id);
		}
		
		$this->db->where('status', 'confirm');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		//return $query->result_array();
		return $query->result();
	}

	public function get_sales_summary_report_refund($end_date, $start_date, $merchant_id) {
		$this->db->select('mt.amount, mt.tax, mt.tip_amount, mt.card_type, mt.type, mt.date_c, mt.reference, mt.name, mt.status, r.add_date as refund_dt, r.amount as refund_amount');
		$this->db->from("refund r");

		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status!=', 'pending');
		$this->db->where('mt.status!=', 'block');
		$this->db->where('mt.status!=', 'declined');

		if($merchant_id!="" && $merchant_id!='all') {
		 $this->db->where_in('r.merchant_id', $merchant_id); 
		} 
		$sqlQry='';
		if($merchant_id=='all'){
			$wf_merchants=$this->session->userdata('wf_merchants');
        	$x=explode(",",$wf_merchants);
        	$len=sizeof($x);
        	if(!empty($wf_merchants)) {
	        	for ($i=0; $i <$len ; $i++) { 
	            	if($i==0){
	               		// $this->db->where('r.merchant_id='. $x[$i]." or ");
	               		$sqlQry.='(r.merchant_id='. $x[$i].' or ';
	            	}else if($i==$len-1)
	            	{
	            		$sqlQry.='r.merchant_id='. $x[$i].' )';
	            	}
	            	else{
	                	// $this->db->or_where('r.merchant_id', $x[$i]);
	                	$sqlQry.='r.merchant_id='. $x[$i].' or ';
	            	}
	        
	        	}
				$this->db->where($sqlQry);
			}
			else{
				$this->db->where('r.merchant_id IS NULL', null, false);
			}
		}
		$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');

		$query1 = $this->db->get_compiled_select();
		
		$this->db->select('mt.amount,mt.tax,"0" as tip_amount, mt.card_type, mt.type, mt.date_c, mt.reference, mt.name, mt.status, r.add_date as refund_dt, r.amount as refund_amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.status!=', 'pending');
		$this->db->where('mt.status!=', 'block');
		$this->db->where('mt.status!=', 'declined');
		if($merchant_id!="" && $merchant_id!='all') {
		 $this->db->where_in('r.merchant_id', $merchant_id); 
		}
		$sqlQry='';
		if($merchant_id=='all'){
			$wf_merchants=$this->session->userdata('wf_merchants');
        	$x=explode(",",$wf_merchants);
        	$len=sizeof($x);
        	if(!empty($wf_merchants)) {
	        	for ($i=0; $i <$len ; $i++) { 
	            	if($i==0){
	               		// $this->db->where('r.merchant_id='. $x[$i]." or ");
	               		$sqlQry.='(r.merchant_id='. $x[$i].' or ';
	            	}else if($i==$len-1)
	            	{
	            		$sqlQry.='r.merchant_id='. $x[$i].' )';
	            	}
	            	else{
	                	// $this->db->or_where('r.merchant_id', $x[$i]);
	                	$sqlQry.='r.merchant_id='. $x[$i].' or ';
	            	}
	        
	        	}
	        	$this->db->where($sqlQry);
	        }else{
				$this->db->where('r.merchant_id IS NULL', null, false);
			} 
		}

		$this->db->join('customer_payment_request mt', 'mt.invoice_no = r.invoice_no');
		$query2 = $this->db->get_compiled_select();
		// echo $query1;die;
		$query = $this->db->query($query1 . " UNION ALL " . $query2);
		
		return $query->result();
	}

}
