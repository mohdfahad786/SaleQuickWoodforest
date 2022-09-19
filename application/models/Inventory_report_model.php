<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id) {
		if($main_items!="") {
			$query=$this->db->query("SELECT `cart`.`item_id` as `item_id` ,`item`.`item_id` as `main_item_id`,`posmain`.`name` as `mname`,item.sku, `item`.`name` as `item_name`, `item`.`title` as
            `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round(tax_value,2)) as `tax_value` ,round(`item`.`tax`,2) as `tax_value1`, 
            sum(`cart`.`discount_amount`) 
             as `discount`, SUM(`cart`.`price`) as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,
            `cart`.`created_at`,`cart`.`updated_at` as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` 
            JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` 
            JOIN `adv_pos_item_main` `posmain` ON `posmain`.`id` = `item`.`item_id` 
            WHERE  
            `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`category_id`='$main_items' AND `item`.`mode`='1'  
            GROUP BY `main_item_id` ORDER BY `item`.`item_id` DESC limit ".$_POST['start'].",".$_POST['length']." "); 

		} else {
		    $query=$this->db->query("SELECT `cart`.`item_id` as `item_id` ,`item`.`item_id` as `main_item_id`,`posmain`.`name` as `mname`,item.sku,
			`item`.`name` as `item_name`, `item`.`title` as `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`, SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,SUM(round(tax_value,2)) as `tax_value` ,round(`item`.`tax`,2) as `tax_value1`, 
			sum(`cart`.`discount_amount`)  as `discount`,SUM(`cart`.`price`)  
			as `sold_price`, `item`.`item_image` as `item_image`, `cat`.`name` as `cat_name`,`cart`.`created_at`,`cart`.`updated_at` 
			as `updated_at`,`cart`.`status` as `status` FROM `adv_pos_cart_item` `cart` JOIN `adv_pos_item` `item` ON `item`.`id` = `cart`.`item_id` 
			JOIN `adv_pos_category` `cat` ON `cat`.`id` = `item`.`category_id` JOIN `adv_pos_item_main` `posmain` ON `posmain`.`id` = `item`.`item_id` WHERE `cart`.`updated_at` >='$start_date' AND `cart`.`updated_at` <= '$end_date' 
			AND  `cart`.`merchant_id` = '$merchant_id' AND `item`.`merchant_id` = '$merchant_id' AND `item`.`mode`='1' GROUP BY `main_item_id` ORDER BY `item`.`item_id` DESC limit ".$_POST['start'].",".$_POST['length']." "); 
		}
		return $query->result();
	}

	public function get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`item.name` as `mname`,`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`,SUM(round(tax_value,2)) as `tax_value` ,round(`item`.`tax`,2) as `tax_value1` ,item.sku,SUM(`item`.`price`) as `base_price`,SUM(`cart`.`quantity`) as `quantity`,
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
		if($_POST['length'] != -1) {
	        $this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items) { 
	    $this->db->select(" `cart`.`item_id` as `item_id`,`item`.`item_id` as `main_item_id`,`item`.`item_id` as `cat_item_id`,`item.name` as `mname`,`item`.`name` as `item_name`,
		`item`.`title` as `item_title`,`cart`.`bill_tax` as `bill_tax`,`cart`.`bill_discount` as `bill_discount`,SUM(round(tax_value,2)) as `tax_value` ,round(`item`.`tax`,2) as `tax_value1` ,item.sku,SUM(`item`.`price`)
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
		if($_POST['length'] != -1) {
	        $this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get(); 
		return $query->result_array();
	}

}