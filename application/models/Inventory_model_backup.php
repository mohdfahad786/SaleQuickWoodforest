<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id)
	{
		if($main_items!="")
		{

			
			
			 $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` ,`item`.`item_id` as `main_item_id`,`posmain`.`name` as `mname`,item.sku, `item`.`name` as `item_name`, `item`.`title` as
            `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,round(tax_value,2) as `tax_value`,  round(`item`.`tax`,2) as `tax_value1`, 
            sum(`cart`.`discount_amount`) 
             as `discount`, SUM(`cart`.`price`) as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,
            `cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` 
            JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
            JOIN `adv_pos_item_main` `posmain` ON `posmain`.`id` = `item`.`item_id` 
            WHERE  
            `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`category_id`='$main_items' AND `item`.`mode`='1'  
            GROUP BY `main_item_id` ORDER BY `item`.`item_id` DESC"); 
		}
		else
		{
			
		    $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` ,`item`.`item_id` as `main_item_id`,`posmain`.`name` as `mname`,item.sku,
			`item`.`name` as `item_name`, `item`.`title` as `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round(tax_value,2)) as `tax_value` ,  round(`item`.`tax`,2) as `tax_value1`, 
			sum(`cart`.`discount_amount`)  as `discount`,SUM(`cart`.`price`)  
			as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
			as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` 
			JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` JOIN `adv_pos_item_main` `posmain` ON `posmain`.`id` = `item`.`item_id` WHERE `cart`.`updated_at` >='$start_date' AND `cart`.`updated_at` <= '$end_date' 
			AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`mode`='1' GROUP BY `main_item_id` ORDER BY `item`.`item_id` DESC"); 
		}return $query->result();
	}
	
	public function refund_check($id)
	{
		$this->db->select("amount");
		$this->db->from("refund");
		$this->db->where('invoice_no', $id);
		//$this->db->where('cart.main_item_id', $main_item_id);
		//$this->db->where('cart.status', 2);
		//$this->db->join('pos item', 'item.transaction_id = cart.cart_transaction_id');
		//$this->db->join('refund ref', 'ref.invoice_no = item.invoice_no');
		$query = $this->db->get(); 
		//return $query->result_array();
		return $query->row_array();
		
	}

		public function get_full_inventory_spreportdata_invoice_refund_split($start_date, $end_date,$main_items,$merchant_id)
	{
		if($main_items!="")
		{
		    $query=$this->db->query("SELECT `cart`.`transaction_id` as `transaction_id`,`po`.`invoice_no` as `order_id`  FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `pos` `po` ON `po`.`invoice_no` = `cart`.`transaction_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE `cart`.`updated_at` >='$start_date' AND `cart`.`updated_at` <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`category_id`='$main_items'  
			GROUP BY `cart`.`transaction_id` ORDER BY `item`.`item_id` DESC"); 
		}
		else
		{
			 $query=$this->db->query("SELECT `cart`.`transaction_id` as `transaction_id`,`po`.`invoice_no` as `order_id`  FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `pos` `po` ON `po`.`invoice_no` = `cart`.`transaction_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE `cart`.`updated_at` >='$start_date' AND `cart`.`updated_at` <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' GROUP BY `cart`.`transaction_id` ORDER BY `item`.`item_id` DESC");  
			
		    
		}return $query->result();

		
	}
	
	
	public function get_full_inventory_spreportdata_invoice_refund($start_date, $end_date,$main_items,$merchant_id)
	{
		if($main_items!="")
		{
		    $query=$this->db->query("SELECT `cart`.`transaction_id` as `transaction_id`,`po`.`invoice_no` as `order_id`  FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `pos` `po` ON `po`.`transaction_id` = `cart`.`transaction_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE `cart`.`updated_at` >='$start_date' AND `cart`.`updated_at` <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`category_id`='$main_items'  
			GROUP BY `cart`.`transaction_id` ORDER BY `item`.`item_id` DESC"); 
		}
		else
		{
			 $query=$this->db->query("SELECT `cart`.`transaction_id` as `transaction_id`,`po`.`invoice_no` as `order_id`  FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `pos` `po` ON `po`.`transaction_id` = `cart`.`transaction_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE `cart`.`updated_at` >='$start_date' AND `cart`.`updated_at` <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' GROUP BY `cart`.`transaction_id` ORDER BY `item`.`item_id` DESC");  
			
		    
		}
//get_full_inventory_reportdata_main_no_main_item echo $this->db->last_query(); die("");   
		return $query->result();


	}
	


  	function get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$table) {

		 $this->db->select('count(id) as id, SUM(amount) as amount');
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
		$this->db->where('adv_pos_exc',1);
		$this->db->where('status', $status);
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$query = $this->db->get($table);

		return $query->result_array();
	}



	public function get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`posmain.name` as `mname`,`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,SUM(round(tax_value,2)) as `tax_value`,  round(`item`.`tax`,2) as `tax_value1` ,item.sku,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,
		SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,
		CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) 
		WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE 
			sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`, SUM(`cart`.`quantity`*`item`.`price`)  
		as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
		as `updated_at`,`cart`.`status` as `status` ");
	   //  Second Query //   $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN '' ELSE sum(`cart`.`quantity`*`cart`.`new_price`)-`cart`.`price` END as `discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
		//$this->db->select('cart.*,item.name as item_name,item.tax as tax,item.price as base_price,item.item_image as item_image,item.title as item_title,cat.name as cat_name');
		$this->db->from("adv_pos_cart_item cart");
		$date = date('Y-m-d', strtotime('-30 days'));
	    $this->db->where('DATE(cart.updated_at) >=', $date);
		//$this->db->where('cart.updated_at >=', $start_date);
		//$this->db->where('cart.updated_at <=', $end_date);
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('cart.status', 2);
		$this->db->where('item.mode', 1);
		$this->db->group_by("main_item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->order_by("item.item_id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$this->db->join('adv_pos_item_main posmain', 'posmain.id = item.item_id');
		$query = $this->db->get(); 
		// echo $this->db->last_query(); die("ol");    
		return $query->result();
	}
	
	public function get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`item.name` as `mname`,`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`,SUM(round(tax_value,2)) as `tax_value`,  round(`item`.`tax`,2) as `tax_value1` ,item.sku,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,
		
		 
			sum(`cart`.`discount_amount`)  as `discount`, SUM(`cart`.`price`)  
		as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
		as `updated_at`,`cart`.`status` as `status` ");
	  
		$this->db->from("adv_pos_cart_item cart");
		$date = date('Y-m-d', strtotime('-30 days'));
		// $this->db->where('DATE(cart.updated_at) >=', $start_date);
	 //    $this->db->where('DATE(cart.updated_at) <=', $end_date);
	    $this->db->where('cart.updated_at >=', $start_date);
	    $this->db->where('cart.updated_at <=', $end_date);
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('cart.status', 2);
		$this->db->where('item.mode', 0);
		$this->db->where('item.merchant_id', $merchant_id);
		if($main_items!='')
		{
			$this->db->where('item.category_id', $main_items);
		}
		$this->db->group_by("item_id");
		$this->db->order_by("item.id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`item.name` as `mname`,`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`,SUM(round(tax_value,2)) as `tax_value` ,  round(`item`.`tax`,2) as `tax_value1` ,item.sku,SUM(`item`.`price`)
		as `base_price`,SUM(`cart`.`quantity`) as `quantity`,sum(`cart`.`discount_amount`)  as `discount`, SUM(`cart`.`price`)  
		as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
		as `updated_at`,`cart`.`status` as `status` ");
	  
		$this->db->from("adv_pos_cart_item cart");
		$date = date('Y-m-d', strtotime('-30 days'));
		// $this->db->where('DATE(cart.updated_at) >=', $start_date);
	 //    $this->db->where('DATE(cart.updated_at) <=', $end_date);
	    $this->db->where('cart.updated_at >=', $start_date);
	    $this->db->where('cart.updated_at <=', $end_date);
 		$this->db->where('cart.merchant_id', $merchant_id);
 		$this->db->where('cart.status', 2);
 		$this->db->where('item.mode', 0);
 		$this->db->where('item.merchant_id', $merchant_id);
 			if($main_items!='')
		{
			$this->db->where('item.category_id', $main_items);
		}
 		$this->db->group_by("item_id");
		$this->db->order_by("item.id", "desc");
		$this->db->join('mis_adv_pos_item item', 'item.item_id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		return $query->result_array();
	}
	
	public function get_full_inventory_reportdata_main_no_main_item1($start_date, $end_date,$merchant_id) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`sku`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`item.name` as `mname`,
		`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,round((`cart`.`price`)*(`item`.`tax`)/100,2) as `tax_value`,item.sku,`item`.`price` as `base_price`,`cart`.`quantity`
		as `quantity`,
		`cart`.`new_price` as `new_price`, `cart`.`price` as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,
		CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN cart.quantity *`cart`.`new_price`-`cart`.`price`
		WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN (cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE 
			`cart`.`quantity`*`cart`.`new_price`-`cart`.`price` END as `discount`, (`cart`.`quantity`*`item`.`price`)  
		as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
		as `updated_at`,`cart`.`status` as `status` ");
	    $this->db->from("adv_pos_cart_item cart");
		$date = date('Y-m-d', strtotime('-30 days'));
	    $this->db->where('DATE(cart.updated_at) >=', $start_date);
		//$this->db->where('cart.updated_at >=', $start_date);
		//$this->db->where('cart.updated_at <=', $end_date);
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('cart.status', 2);
		$this->db->where('item.mode', 0);
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->group_by("item_id");
		$this->db->order_by("item.id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		return $query->result_array();
	}
	
		public function get_full_inventory_reportdata($start_date, $end_date,$merchant_id,$main_item_id) { 
		//SUM((`cart`.`price`)*(`item`.`tax`)/100);
	    $this->db->select(" `cart`.`id` as `cid`,`cart`.`item_id` as `item_id`,`item`.`item_id` as `cat_item_id`,`item`.`name` as `item_name`,`po`.`invoice_no` as `order_id`,`item`.`title` as `item_title`,item.sku,
		SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round(tax_value,2)) as `tax_value`, round(`item`.`tax`,2) as `tax_value1` ,sum(`cart`.`discount_amount`)  as `discount`, 
		SUM(`cart`.`price`)  as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,
		`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
	  
		$this->db->from("adv_pos_cart_item cart");
		
		$this->db->where('DATE(cart.updated_at) >=', $start_date );
		$this->db->where('DATE(cart.updated_at) <=', $end_date );
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('item.item_id', $main_item_id);
		$this->db->where('cart.status', 2);
		$this->db->where('item.mode', 1);
		$this->db->group_by("cart.item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->order_by("item.item_id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('pos po', 'cart.transaction_id = po.transaction_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		// echo $this->db->last_query(); die("ol");    
		//return $query->result();
		return $query->result_array();
	}
	
	
	
	public function get_full_inventory_reportdata_sale($start_date, $end_date,$merchant_id,$main_items) { 
		
	    $this->db->select(" `cart`.`item_id` as `item_id`,`po`.`invoice_no` as `order_id`,`cart`.`transaction_id` as `transaction_id`,`item`.`item_id` as `cat_item_id`,
		`item`.`name` as `item_name`,`item`.`title` as `item_title`,item.sku,
		`item`.`price` as `base_price`,`cart`.`quantity` as `quantity`,round((`cart`.`price`)*(`item`.`tax`)/100,2) as `tax_value`,(`cart`.`discount_amount`)  as `discount`, 
		(`cart`.`price`)  as `sold_price`, `cat`.`name` as `cat_name`,`cart`.`created_at`,
		`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
	   
		$this->db->from("adv_pos_cart_item cart");
		
		// $this->db->where('DATE(cart.updated_at) >=', $start_date );
		// $this->db->where('DATE(cart.updated_at) <=', $end_date  );

		$this->db->where('cart.updated_at >=', $start_date );
		$this->db->where('cart.updated_at <=', $end_date  );

		$this->db->where('cart.merchant_id', $merchant_id);
		//$this->db->where('cart.main_item_id', $main_item_id);
		$this->db->where('cart.status', 2);
		//$this->db->group_by("cart.item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		if($main_items!=''){
		$this->db->where('item.category_id', $main_items);
		}
		$this->db->order_by("cart.updated_at", "desc");
		
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('pos po', 'cart.transaction_id = po.transaction_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		// echo $this->db->last_query(); die("ol");    
		//return $query->result();
		return $query->result_array();
	}
	
		public function get_full_refund_data_search($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		
		
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result();

	}
	public function get_full_refund_data_search_pdf($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result_array();

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
	
	function get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id, $table,$condition) {

	   $this->db->select('po.*,m.name as mname');
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
		if ($status != '') {
			$this->db->where('po.status', $status);
		}
		$this->db->where('po.card_type', $condition);
		$this->db->where('po.transaction_type', 'full');
		$this->db->where('po.status!=', 'pending');
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		$this->db->order_by("po.id", "desc");
		$this->db->group_by("po.invoice_no");
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
		function get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id, $table,$condition) {

		 $this->db->select('count(id) as id, SUM(amount) as amount');
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
		$this->db->where('card_type', $condition);
		$this->db->where('status!=', 'pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_search_merchant_pending_total($start_date, $end_date, $merchant_id, $table) {

		 $this->db->select('count(id) as id, SUM(amount) as amount');
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
		
		$this->db->where('status','pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_search_merchant_pos_total_card($start_date, $end_date, $status, $merchant_id, $table) {

	    $this->db->select('count(id) as id, SUM(amount) as amount');
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
		$this->db->where('card_type!=', 'CASH');
		$this->db->where('card_type!=', 'CHECK');
		$this->db->where('card_type!=', 'ONLINE');
		$this->db->where('status!=','pending');
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		
		$query = $this->db->get($table);
		return $query->result_array();
	}

	
	
	
	function get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id, $table) {
        $this->db->select('po.*,m.name as mname');
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
		if ($status != '') {
			$this->db->where('po.status', $status);
		}
		$this->db->where('po.transaction_type', 'split');
		$this->db->where('po.status!=','pending');
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		$this->db->order_by("po.id", "date");
		$this->db->group_by("po.invoice_no");
		$query = $this->db->get($table);
		return $query->result_array();
	}
	function get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id, $table) {
        $this->db->select('po.*,m.name as mname');
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
		if ($status != '') {
			$this->db->where('status', $status);
		}
		$this->db->where('po.card_type!=', 'CASH');
		$this->db->where('po.card_type!=', 'CHECK');
		$this->db->where('po.card_type!=', 'ONLINE');
		
		$this->db->where('po.transaction_type', 'full');
		$this->db->where('po.status!=','pending');
		
		if($merchant_id!=""){ $this->db->where('po.merchant_id', $merchant_id); }
		
		$this->db->join('merchant m', 'po.sub_merchant_id = m.id','left');
		
		$this->db->order_by("po.id", "date");
		$this->db->group_by("po.invoice_no");
		$query = $this->db->get($table);
		return $query->result_array();
	}
   
   
   public function get_search_refund_data($table, $merchant_id, $start, $end, $status) {
		$date = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start);
		$this->db->where('r.date_c <=', $end);
		$this->db->where('mt.status', $status);
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		$query = $this->db->get();
		return $query->result_array();

	}
	
	function get_search_merchant_pos_with_array($start_date, $end_date, $status, $merchant_id, $table) {

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
		//if ($status != '') {
		//	$this->db->where('status', $status);
		//}
		
		$where = '(status="Chargeback_Confirm" or status = "confirm")';
        $this->db->where($where);
	   
		
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	
	
}