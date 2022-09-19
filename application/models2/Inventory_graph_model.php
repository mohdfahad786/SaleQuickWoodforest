<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_graph_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id)
	{
		if($main_items!="")
		{
			//$query=$this->db->query("SELECT `cart`.*, `item`.`name` as `item_name`, `item`.`tax` as `tax`, `item`.`price` as `base_price`, `item`.`item_image` as `item_image`,`item`.`title` as `item_title`, `cat`.`name` as `cat_name` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id`  WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items' ORDER BY `cart`.`created_at` DESC "); 
		    //  Second Query : $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` , `item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`, SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN 'No-discount' ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `new_discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items'  GROUP BY `cart`.`item_id` ORDER BY `item`.`item_id` DESC"); 
		    $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` ,`item`.`item_id` as `main_item_id`,item.sku, `item`.`name` as `item_name`, `item`.`title` as
			`item_title`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round((`cart`.`price`)*(`item`.`tax`)/100,2)) as `tax_value`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`,
			(`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`)
			THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) 
			THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) 
			END as `discount`, SUM(`cart`.`quantity`*`item`.`price`) as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,
			`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items'  
			GROUP BY `main_item_id` ORDER BY `item`.`item_id` DESC"); 
		}
		else
		{
			//$query=$this->db->query("SELECT `cart`.*, `item`.`name` as `item_name`, `item`.`tax` as `tax`, `item`.`price` as `base_price`, `item`.`item_image` as `item_image`,`item`.`title` as `item_title`, `cat`.`name` as `cat_name` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' ORDER BY `cart`.`created_at` DESC "); 
		    // Second  Query :: $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` , `item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`, SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`, SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN 'No-discount' ELSE sum(`cart`.`quantity`*`cart`.`new_price` -`cart`.`price`) END as `new_discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id'  GROUP BY `cart`.`item_id` ORDER BY `item`.`item_id` DESC"); 
		    $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` ,`item`.`item_id` as `main_item_id`,item.sku,
			`item`.`name` as `item_name`, `item`.`title` as `item_title`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round((`cart`.`price`)*(`item`.`tax`)/100,2)) as `tax_value`,
			SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,
			CASE WHEN (`cart`.`new_price`=`item`.`price` AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`)
			WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) 
			ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`,SUM(`cart`.`quantity`*`item`.`price`)  
			as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
			as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` 
			JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' 
			AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id'  GROUP BY `main_item_id` ORDER BY `item`.`item_id` DESC"); 
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
	
	public function get_full_inventory_spreportdata_invoice_refund($start_date, $end_date,$main_items,$merchant_id)
	{
		if($main_items!="")
		{
		    $query=$this->db->query("SELECT `cart`.`transaction_id` as `transaction_id`,`po`.`invoice_no` as `order_id`  FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `pos` `po` ON `po`.`transaction_id` = `cart`.`transaction_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`item_id`='$main_items'  
			GROUP BY `cart`.`transaction_id` ORDER BY `item`.`item_id` DESC"); 
		}
		else
		{
			 $query=$this->db->query("SELECT `cart`.`transaction_id` as `transaction_id`,`po`.`invoice_no` as `order_id`  FROM `adv_pos_cart_item` `cart` 
			JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `pos` `po` ON `po`.`transaction_id` = `cart`.`transaction_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
			WHERE DATE(`cart`.`updated_at`) >='$start_date' AND DATE(`cart`.`updated_at`) <= '$end_date' AND  
			`cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' GROUP BY `cart`.`transaction_id` ORDER BY `item`.`item_id` DESC");  
			
		    
		}return $query->result();
	}
	
	public function get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,SUM(round((`cart`.`price`)*(`item`.`tax`)/100,2)) as `tax_value`,item.sku,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,
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
		$this->db->group_by("main_item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		$this->db->order_by("item.item_id", "desc");
		$this->db->join('adv_pos_item item', 'item.id = cart.item_id');
		$this->db->join('adv_pos_category cat', 'cat.id = item.category_id');
		$query = $this->db->get(); 
		// echo $this->db->last_query(); die("ol");    
		return $query->result();
	}
	
		public function get_full_inventory_reportdata($start_date, $end_date,$merchant_id,$main_item_id) { 
		//SUM((`cart`.`price`)*(`item`.`tax`)/100);
	    $this->db->select(" `cart`.`id` as `cid`,`cart`.`item_id` as `item_id`,`item`.`item_id` as `cat_item_id`,`item`.`name` as `item_name`,`po`.`invoice_no` as `order_id`,`item`.`title` as `item_title`,item.sku,
		SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round((`cart`.`price`)*(`item`.`tax`)/100,2)) as `tax_value`,SUM(`cart`.`new_price`) as `new_price`, 
		SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` 
		AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) 
		THEN sum(cart.quantity *`cart`.`new_price`-`cart`.`price`) ELSE sum(`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`, 
		SUM(`cart`.`quantity`*`item`.`price`)  as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,
		`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
	   //  Second Query //   $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN '' ELSE sum(`cart`.`quantity`*`cart`.`new_price`)-`cart`.`price` END as `discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
		//$this->db->select('cart.*,item.name as item_name,item.tax as tax,item.price as base_price,item.item_image as item_image,item.title as item_title,cat.name as cat_name');
		$this->db->from("adv_pos_cart_item cart");
		//$date = date('Y-m-d', strtotime('-30 days'));
		//$this->db->where('cart.updated_at >=', $date);
		$this->db->where('DATE(cart.updated_at) >=', $start_date );
		$this->db->where('DATE(cart.updated_at) <=', $end_date );
		$this->db->where('cart.merchant_id', $merchant_id);
		$this->db->where('item.item_id', $main_item_id);
		$this->db->where('cart.status', 2);
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
		`item`.`price` as `base_price`,`cart`.`quantity` as `quantity`,round((`cart`.`price`)*(`item`.`tax`)/100,2) as `tax_value`,`cart`.`new_price` as `new_price`, 
		`cart`.`price` as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN (`cart`.`new_price`=`item`.`price` 
		AND cart.quantity * `cart`.`new_price`>`cart`.`price`) THEN cart.quantity *`cart`.`new_price`-`cart`.`price` WHEN ( cart.quantity *`cart`.`new_price`>`cart`.`price`) 
		THEN cart.quantity *`cart`.`new_price`-`cart`.`price` ELSE (`cart`.`quantity`*`cart`.`new_price`-`cart`.`price`) END as `discount`, 
		(`cart`.`quantity`*`item`.`price`)  as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,
		`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
	   //  Second Query //   $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`name` as `item_name`,`item`.`title` as `item_title`,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`price` * `item`.`tax` /100) as `tax`, SUM(`cart`.`quantity`) as `quantity`,SUM(`cart`.`new_price`) as `new_price`, SUM(`cart`.`price`) as `price`, (`cart`.`quantity`*`cart`.`new_price`) as `quantity*new_price`,CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN '' ELSE sum(`cart`.`quantity`*`cart`.`new_price`)-`cart`.`price` END as `discount`, CASE WHEN `cart`.`price`=(`cart`.`quantity`*`cart`.`new_price`) THEN SUM(`cart`.`new_price`) ELSE SUM((`item`.`price`)-(`cart`.`new_price`-`cart`.`price`)) END as `sold_price`,`item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` ");
		//$this->db->select('cart.*,item.name as item_name,item.tax as tax,item.price as base_price,item.item_image as item_image,item.title as item_title,cat.name as cat_name');
		$this->db->from("adv_pos_cart_item cart");
		//$date = date('Y-m-d', strtotime('-30 days'));
		//$this->db->where('cart.updated_at >=', $date);
		$this->db->where('DATE(cart.updated_at) >=', $start_date );
		$this->db->where('DATE(cart.updated_at) <=', $end_date  );
		$this->db->where('cart.merchant_id', $merchant_id);
		//$this->db->where('cart.main_item_id', $main_item_id);
		$this->db->where('cart.status', 2);
		//$this->db->group_by("cart.item_id");
		$this->db->where('item.merchant_id', $merchant_id);
		if($main_items!=''){
		$this->db->where('item.item_id', $main_items);
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
		return $query->result_array();

	}
		public function get_full_refund_data_search_p1($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
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
	
	function get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, $table,$condition) {

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
		return $query->result_array();
	}
	
		function get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, $table,$condition) {

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
	
	function get_search_merchant_pending_total($start_date, $end_date, $merchant_id,$employee, $table) {

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
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_search_merchant_tip_total($start_date, $end_date, $merchant_id,$employee, $table) {

		 $this->db->select('count(DISTINCT invoice_no) as id, SUM(tip_amount) as amount');
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
	   $this->db->where('tax >',0);
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
function get_search_merchant_other_charges_total($start_date, $end_date, $merchant_id,$employee, $table) {

	$this->db->select('count(DISTINCT invoice_no) as id, SUM(other_charges) as amount');
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
	
	function get_search_merchant_pos_total_card($start_date, $end_date, $status, $merchant_id,$employee, $table) {

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
	
		
	function get_search_merchant_pos_total_online($start_date, $end_date, $status, $merchant_id,$employee, $table) {

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

	
		function get_search_merchant_pos($start_date, $end_date, $status, $merchant_id,$employee, $table) {

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
	   
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result();
	}
	
	function get_search_merchant_pos_with_array($start_date, $end_date, $status, $merchant_id,$employee, $table) {

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
	   
		if($employee!=0)
		{
			$this->db->where('sub_merchant_id', $employee);
		}
		if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	
	function get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id,$employee, $table) {
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
		return $query->result_array();
	}
	function get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id,$employee, $table) {
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
			$this->db->order_by("date_c", "desc");
		//$this->db->group_by("po.invoice_no");
		$this->db->group_by("po.id");
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_search_merchant_pos_type_online($start_date, $end_date, $status, $merchant_id,$employee, $table) {
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
	
	function get_search_merchant_pos_type_card_invoice($start_date, $end_date, $status, $merchant_id,$employee, $table) {
        $this->db->select('po.*,m.name as mname');
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
        $this->db->select('po.*,m.name as mname');
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
	
	public function get_full_inventory_spdata($start_date, $end_date,$merchant_id) {
		$query=$this->db->query("SELECT positm.id, positm.category_id, positm.sub_category_id, positm.item_id, positm.mode, positm.title, positm.name, positm.sku, 
		positm.price, positm.tax, positm.merchant_id, positm.description, positm.quantity, positm.sold_quantity, positm.item_image, positm.created_at, positm.updated_at,
		positm.status, `poscat`.`name` as `cat_name`, `poscat`.`code` as `cat_code` 
		FROM `adv_pos_item` `positm` JOIN `adv_pos_category` `poscat` ON `poscat`.`id` = `positm`.`category_id` 
		WHERE DATE(`positm`.`created_at`) >='$start_date' AND DATE(`positm`.`created_at`) <= '$end_date' AND 
		`positm`.`merchant_id` = '$merchant_id' AND `poscat`.`merchant_id` = '$merchant_id' GROUP BY `positm`.`item_id`  ORDER BY `positm`.`created_at` DESC "); 
	    return $query->result();
	}
	
	public function get_full_inventory_spdata_list($start_date, $end_date,$merchant_id,$item_id) {
		$query=$this->db->query("SELECT positm.id, positm.category_id, positm.sub_category_id, positm.item_id, positm.mode, positm.title, positm.name, positm.sku, 
		positm.price, positm.tax, positm.merchant_id, positm.description, positm.quantity, positm.sold_quantity, positm.item_image, positm.created_at, positm.updated_at,
		positm.status, `poscat`.`name` as `cat_name`, `poscat`.`code` as `cat_code` 
		FROM `adv_pos_item` `positm` JOIN `adv_pos_category` `poscat` ON `poscat`.`id` = `positm`.`category_id` 
		WHERE DATE(`positm`.`created_at`) >='$start_date' AND DATE(`positm`.`created_at`) <= '$end_date' AND 
		`positm`.`merchant_id` = '$merchant_id' AND `poscat`.`merchant_id` = '$merchant_id' AND `positm`.`item_id` = '$item_id'  ORDER BY `positm`.`created_at` DESC "); 
	    return $query->result();
	}
	
	
	
	 public function get_full_inventory_data_no_limit($merchant_id) {
		$this->db->select(' positm.id, positm.category_id, positm.sub_category_id, positm.item_id, positm.mode, positm.title, positm.name,posmain.name as mname, positm.sku, 
		SUM(positm.price) as price , positm.tax, positm.merchant_id, positm.description, SUM(positm.quantity) as quantity, SUM(positm.sold_quantity) as sold_quantity , positm.item_image, 
		positm.created_at, positm.updated_at,
		positm.status,poscat.name as cat_name,poscat.code as cat_code');
		$this->db->from("adv_pos_item positm");
	//	$date = date('Y-m-d', strtotime('-30 days'));y
	//	$this->db->where('positm.created_at >=', $date);
		$this->db->where('positm.merchant_id', $merchant_id);
		$this->db->where('positm.status', '0');
		$this->db->where('positm.mode', '1');
		$this->db->where('poscat.merchant_id', $merchant_id);
		$this->db->group_by("positm.item_id");
		$this->db->order_by("positm.created_at", "desc");
		$this->db->join('adv_pos_category poscat', 'poscat.id = positm.category_id');
		$this->db->join('adv_pos_item_main posmain', 'posmain.id = positm.item_id');
		$query = $this->db->get();
		return $query->result(); 
		

	}
	
	public function get_full_inventory_data_no_limit_no_main_item($merchant_id) {
		$query=$this->db->query("SELECT `positm`.*, `poscat`.`name` as `cat_name`, `poscat`.`code` as `cat_code` 
		FROM `adv_pos_item` `positm` JOIN `adv_pos_category` `poscat` ON `poscat`.`id` = `positm`.`category_id` 
		WHERE `positm`.`merchant_id` = '$merchant_id' AND `poscat`.`merchant_id` = '$merchant_id'  AND `positm`.`mode` = '0' AND `positm`.`status` = '0' ORDER BY `positm`.`created_at` DESC "); 
	    return $query->result_array();
	}
	
	
	 public function get_full_inventory_data_no_limit_list($merchant_id,$item_id) {
		$this->db->select(' positm.id, positm.category_id, positm.sub_category_id, positm.item_id, positm.mode, positm.title, positm.name, positm.sku, 
		SUM(positm.price) as price , positm.tax, positm.merchant_id, positm.description, SUM(positm.quantity) as quantity, SUM(positm.sold_quantity) as sold_quantity , positm.item_image, 
		positm.created_at, positm.updated_at,
		positm.status,poscat.name as cat_name,poscat.code as cat_code');
		$this->db->from("adv_pos_item positm");
	//	$date = date('Y-m-d', strtotime('-30 days'));
	//	$this->db->where('positm.created_at >=', $date);
		$this->db->where('positm.merchant_id', $merchant_id);
		$this->db->where('positm.item_id', $item_id);
		$this->db->where('positm.status', '0');
		$this->db->where('positm.mode', '1');
		$this->db->where('poscat.merchant_id', $merchant_id);
		//$this->db->group_by("positm.item_id");
		$this->db->group_by("positm.title");
		
		$this->db->order_by("positm.created_at", "desc");
		$this->db->join('adv_pos_category poscat', 'poscat.id = positm.category_id');
		$query = $this->db->get();
		return $query->result_array(); 
	}



	public function get_full_refund_cash_check($start_date, $end_date,$table, $merchant_id,$condition) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.card_type', $condition);
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
	
		 if('mt.transaction_type == full'){
		
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	    else if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		$query = $this->db->get();
		return $query->result_array();

	}
	
	public function get_full_refund_total_count_new($start_date, $end_date, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('r.status', 'confirm');
		$this->db->where('r.merchant_id', $merchant_id); 
		$query = $this->db->get();
		return $query->result_array();

	}

	public function get_full_refund_card($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.card_type!=', 'CASH');
		$this->db->where('mt.card_type!=', 'CHECK');
		$this->db->where('mt.card_type!=', 'ONLINE');
		$this->db->where('mt.card_no!=', '0');
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
		 if('mt.transaction_type == full'){
		
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	    else if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		$query = $this->db->get();
		return $query->result_array();

	}

	public function get_full_refund_online($start_date, $end_date,$table, $merchant_id) {
		
		$this->db->select('count(r.id) as id, SUM(r.amount) as amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $start_date);
		$this->db->where('r.date_c <=', $end_date);
		$this->db->where('mt.card_type!=', 'CASH');
		$this->db->where('mt.card_type!=', 'CHECK');
		$this->db->where('mt.card_type!=', 'ONLINE');
		$this->db->where('mt.card_no', '0');
		$this->db->where('mt.status', 'Chargeback_Confirm');
		if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
	 if('mt.transaction_type == full'){
		
		   	$this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
		}
	    else if('mt.transaction_type == split'){
		$this->db->join($table . ' mt', 'mt.split_payment_id = r.payment_id');
		}
		$query = $this->db->get();
		return $query->result_array();

	}

	
	
}