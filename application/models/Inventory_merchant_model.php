<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_merchant_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_full_inventory_spdata($start_date, $end_date,$merchant_id) {
		$query=$this->db->query("SELECT `positm`.*, `poscat`.`name` as `cat_name`, `poscat`.`code` as `cat_code` FROM `adv_pos_item` `positm` JOIN `adv_pos_category` `poscat` ON `poscat`.`id` = `positm`.`category_id` WHERE DATE(`positm`.`created_at`) >='$start_date' AND DATE(`positm`.`created_at`) <= '$end_date' AND `positm`.`merchant_id` = '$merchant_id' AND `poscat`.`merchant_id` = '$merchant_id' ORDER BY `positm`.`created_at` DESC "); 
	    return $query->result();
	}

	public function get_full_inventory_data_no_limit($merchant_id) {
		$this->db->select(' positm.id, positm.barcode_data, positm.sold_qty_alert, positm.category_id, positm.sub_category_id, positm.item_id, positm.mode, positm.title, positm.name,posmain.name as mname, positm.sku, SUM(positm.price) as price , positm.tax, positm.merchant_id, positm.description, SUM(positm.quantity) as quantity, SUM(positm.sold_quantity) as sold_quantity , positm.item_image, positm.created_at, positm.updated_at, positm.status,poscat.name as cat_name,poscat.code as cat_code');
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
		$this->db->select(' positm.id, positm.barcode_data, positm.sold_qty_alert, positm.category_id, positm.sub_category_id, positm.item_id, positm.mode, positm.title, positm.name, positm.sku, 
		SUM(positm.price) as price , positm.tax, positm.merchant_id, positm.description, positm.quantity as quantity, SUM(positm.sold_quantity) as sold_quantity , positm.item_image, 
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

}