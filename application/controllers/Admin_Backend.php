<?php ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Admin_Backend extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('profile_model'); 
		$this->load->model('admin_model');
		$this->load->model('Inventory_model');
		$this->load->model('Inventory_graph_model');
		$this->load->model('Home_model');
		$this->load->library('email');
		 $this->load->helper('pdf_helper');
		$this->load->model('customers_model', 'customers');
		date_default_timezone_set("America/Chicago");
		//ini_set('display_errors', 1);
	    //error_reporting(E_ALL);
	    //ini_set('max_execution_time', -1);
	}

	public function search_record_credntl() {
		$var = $this->input->post('id');

		$data = $this->admin_model->data_get_where_serch("merchant", array("id" => $var));
		echo json_encode($data);
		die();
	}

	public function search_record_update() {
		// echo '<pre>';print_r($_POST);die;
		$payroc_val = $_POST['payroc_val'];

		$id = $this->input->post('id');
		$auth_code = $this->input->post('auth_code') ? $this->input->post('auth_code') : "";
		$api_key = $this->input->post('api_key') ? $this->input->post('api_key') : "";
		$connection_id = $this->input->post('connection_id') ? $this->input->post('connection_id') : "";
		$min_shop_supply = $this->input->post('min_shop_supply') ? $this->input->post('min_shop_supply') : "";
		$max_shop_supply = $this->input->post('max_shop_supply') ? $this->input->post('max_shop_supply') : "";
		$shop_supply_percent = $this->input->post('shop_supply_percent') ? $this->input->post('shop_supply_percent') : "";
		$protractor_tax_percent = $this->input->post('protractor_tax_percent') ? $this->input->post('protractor_tax_percent') : "";
		$b_code = $this->input->post('b_code') ? $this->input->post('b_code') : "";
		$d_code = $this->input->post('d_code') ? $this->input->post('d_code') : "";
		$t_code = $this->input->post('t_code') ? $this->input->post('t_code') : "";
		$t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
		$t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
		$t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
		$t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
		$a_code_name = $this->input->post('a_code_name') ? $this->input->post('a_code_name') : "";
		$a_code_value = $this->input->post('a_code_value') ? $this->input->post('a_code_value') : "";
		$a_min_value = $this->input->post('a_min_value') ? $this->input->post('a_min_value') : "";
		$a_max_value = $this->input->post('a_max_value') ? $this->input->post('a_max_value') : "";
		$a_fixed = $this->input->post('a_fixed') ? $this->input->post('a_fixed') : "";
		$c_code_name = $this->input->post('c_code_name') ? $this->input->post('c_code_name') : "";
		$c_code_value = $this->input->post('c_code_value') ? $this->input->post('c_code_value') : "";
		$c_min_value = $this->input->post('c_min_value') ? $this->input->post('c_min_value') : "";
		$c_max_value = $this->input->post('c_max_value') ? $this->input->post('c_max_value') : "";
		$c_fixed = $this->input->post('c_fixed') ? $this->input->post('c_fixed') : "";
		$e_code_name = $this->input->post('e_code_name') ? $this->input->post('e_code_name') : "";
		$e_code_value = $this->input->post('e_code_value') ? $this->input->post('e_code_value') : "";
		$e_min_value = $this->input->post('e_min_value') ? $this->input->post('e_min_value') : "";
		$e_max_value = $this->input->post('e_max_value') ? $this->input->post('e_max_value') : "";
		$e_fixed = $this->input->post('e_fixed') ? $this->input->post('e_fixed') : "";
		$f_code_name = $this->input->post('f_code_name') ? $this->input->post('f_code_name') : "";
		$f_code_value = $this->input->post('f_code_value') ? $this->input->post('f_code_value') : "";
		$f_min_value = $this->input->post('f_min_value') ? $this->input->post('f_min_value') : "";
		$f_max_value = $this->input->post('f_max_value') ? $this->input->post('f_max_value') : "";
		$f_fixed = $this->input->post('f_fixed') ? $this->input->post('f_fixed') : "";
		$g_code_name = $this->input->post('g_code_name') ? $this->input->post('g_code_name') : "";
		$g_code_value = $this->input->post('g_code_value') ? $this->input->post('g_code_value') : "";
		$g_min_value = $this->input->post('g_min_value') ? $this->input->post('g_min_value') : "";
		$g_max_value = $this->input->post('g_max_value') ? $this->input->post('g_max_value') : "";
		$g_fixed = $this->input->post('g_fixed') ? $this->input->post('g_fixed') : "";
		$t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
		$t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
		$t1_min_value = $this->input->post('t1_min_value') ? $this->input->post('t1_min_value') : "";
		$t1_max_value = $this->input->post('t1_max_value') ? $this->input->post('t1_max_value') : "";
		$t1_fixed = $this->input->post('t1_fixed') ? $this->input->post('t1_fixed') : "";
		$t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
		$t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
		$t2_min_value = $this->input->post('t2_min_value') ? $this->input->post('t2_min_value') : "";
		$t2_max_value = $this->input->post('t2_max_value') ? $this->input->post('t2_max_value') : "";
		$t2_fixed = $this->input->post('t2_fixed') ? $this->input->post('t2_fixed') : "";
		$t3_code_name = $this->input->post('t3_code_name') ? $this->input->post('t3_code_name') : "";
		$t3_code_value = $this->input->post('t3_code_value') ? $this->input->post('t3_code_value') : "";
		$t3_min_value = $this->input->post('t3_min_value') ? $this->input->post('t3_min_value') : "";
		$t3_max_value = $this->input->post('t3_max_value') ? $this->input->post('t3_max_value') : "";
		$t3_fixed = $this->input->post('t3_fixed') ? $this->input->post('t3_fixed') : "";
		$url_cr = $this->input->post('url_cr') ? $this->input->post('url_cr') : "";
		$username_cr = $this->input->post('username_cr') ? $this->input->post('username_cr') : "";
		$password_cr = $this->input->post('password_cr') ? $this->input->post('password_cr') : "";
		$api_key_cr = $this->input->post('api_key_cr') ? $this->input->post('api_key_cr') : "";
		$account_id = $this->input->post('account_id') ? $this->input->post('account_id') : "";
		$account_token = $this->input->post('account_token') ? $this->input->post('account_token') : "";
		$application_id = $this->input->post('application_id') ? $this->input->post('application_id') : "";
		$acceptor_id = $this->input->post('acceptor_id') ? $this->input->post('acceptor_id') : "";
		$terminal_id = $this->input->post('terminal_id') ? $this->input->post('terminal_id') : "";

		$pax_pos_mid = $this->input->post('pax_pos_mid') ? $this->input->post('pax_pos_mid') : "";
		$pax_v_no = $this->input->post('pax_v_no') ? $this->input->post('pax_v_no') : "";
		$pax_bin = $this->input->post('pax_bin') ? $this->input->post('pax_bin') : "";
		$pax_agent = $this->input->post('pax_agent') ? $this->input->post('pax_agent') : "";
		$pax_chain = $this->input->post('pax_chain') ? $this->input->post('pax_chain') : "";
		$pax_store_no = $this->input->post('pax_store_no') ? $this->input->post('pax_store_no') : "";
		$pax_terminal_no = $this->input->post('pax_terminal_no') ? $this->input->post('pax_terminal_no') : "";
		$pax_currency_code = $this->input->post('pax_currency_code') ? $this->input->post('pax_currency_code') : "";
		$pax_country_code = $this->input->post('pax_country_code') ? $this->input->post('pax_country_code') : "";
		$pax_location_no = $this->input->post('pax_location_no') ? $this->input->post('pax_location_no') : "";
		$pax_timezone = $this->input->post('pax_timezone') ? $this->input->post('pax_timezone') : "";
		$pax_mcc_sic = $this->input->post('pax_mcc_sic') ? $this->input->post('pax_mcc_sic') : "";
		$processor_id = $this->input->post('processor_id') ? $this->input->post('processor_id') : "";
		$PinNumber = $this->input->post('PinNumber') ? $this->input->post('PinNumber') : "";
		$is_vts = $this->input->post('is_vts') ? $this->input->post('is_vts') : "";

		$branch_info = array(
			'connection_id' => $connection_id,
			'api_key' => $api_key,
			'auth_code' => $auth_code,
			'min_shop_supply' => $min_shop_supply,
			'max_shop_supply' => $max_shop_supply,
			'shop_supply_percent' => $shop_supply_percent,
			'protractor_tax_percent' => $protractor_tax_percent,
			'b_code' => $b_code,
			'd_code' => $d_code,
			't_code' => $t_code,
			't1_code_name' => $t1_code_name,
			't1_code_value' => $t1_code_value,
			't2_code_name' => $t2_code_name,
			't2_code_value' => $t2_code_value,
			'a_code_name' => $a_code_name,
			'a_code_value' => $a_code_value,
			'a_min_value' => $a_min_value,
			'a_max_value' => $a_max_value,
			'a_fixed' => $a_fixed,
			'c_code_name' => $c_code_name,
			'c_code_value' => $c_code_value,
			'c_min_value' => $c_min_value,
			'c_max_value' => $c_max_value,
			'c_fixed' => $c_fixed,
			'e_code_name' => $e_code_name,
			'e_code_value' => $e_code_value,
			'e_min_value' => $e_min_value,
			'e_max_value' => $e_max_value,
			'e_fixed' => $e_fixed,
			'f_code_name' => $f_code_name,
			'f_code_value' => $f_code_value,
			'f_min_value' => $f_min_value,
			'f_max_value' => $f_max_value,
			'f_fixed' => $f_fixed,
			'g_code_name' => $g_code_name,
			'g_code_value' => $g_code_value,
			'g_min_value' => $g_min_value,
			'g_max_value' => $g_max_value,
			'g_fixed' => $g_fixed,
			't1_code_name' => $t1_code_name,
			't1_code_value' => $t1_code_value,
			't1_min_value' => $t1_min_value,
			't1_max_value' => $t1_max_value,
			't1_fixed' => $t1_fixed,
			't2_code_name' => $t2_code_name,
			't2_code_value' => $t2_code_value,
			't2_min_value' => $t2_min_value,
			't2_max_value' => $t2_max_value,
			't2_fixed' => $t2_fixed,
			't3_code_name' => $t3_code_name,
			't3_code_value' => $t3_code_value,
			't3_min_value' => $t3_min_value,
			't3_max_value' => $t3_max_value,
			't3_fixed' => $t3_fixed,
			'url_cr' => $url_cr,
			'username_cr' => $username_cr,
			'password_cr' => $password_cr,
			'api_key_cr' => $api_key_cr,
			'account_id_cnp' => $account_id,
			'account_token_cnp' => $account_token,
			'application_id_cnp' => $application_id,
			'acceptor_id_cnp' => $acceptor_id,
			'terminal_id' => $terminal_id,
			
			'pax_pos_mid' => $pax_pos_mid,
			'pax_v_no' => $pax_v_no,
			'pax_bin' => $pax_bin,
			'pax_agent' => $pax_agent,
			'pax_chain' => $pax_chain,
			'pax_store_no' => $pax_store_no,
			'pax_terminal_no' => $pax_terminal_no,
			'pax_currency_code' => $pax_currency_code,
			'pax_country_code' => $pax_country_code,
			'pax_location_no' => $pax_location_no,
			'pax_timezone' => $pax_timezone,
			'pax_mcc_sic' => $pax_mcc_sic,
			'processor_id' => $processor_id,
			'PinNumber' => $PinNumber,
			'is_vts' => $is_vts,
			'payroc' => $payroc_val

		);

		$respoonced=$this->admin_model->update_data('merchant', $branch_info, array('id' => $id));
		if($respoonced){
			echo '200';
		}
		else{
			echo '400';			
		}
	}

	public function search_record_update_new() {
		$id = $this->input->post('id');
		$auth_code = $this->input->post('auth_code') ? $this->input->post('auth_code') : "";
		$api_key = $this->input->post('api_key') ? $this->input->post('api_key') : "";
		$connection_id = $this->input->post('connection_id') ? $this->input->post('connection_id') : "";
		$min_shop_supply = $this->input->post('min_shop_supply') ? $this->input->post('min_shop_supply') : "";
		$max_shop_supply = $this->input->post('max_shop_supply') ? $this->input->post('max_shop_supply') : "";
		$shop_supply_percent = $this->input->post('shop_supply_percent') ? $this->input->post('shop_supply_percent') : "";
		$protractor_tax_percent = $this->input->post('protractor_tax_percent') ? $this->input->post('protractor_tax_percent') : "";
		$b_code = $this->input->post('b_code') ? $this->input->post('b_code') : "";
		$d_code = $this->input->post('d_code') ? $this->input->post('d_code') : "";
		$t_code = $this->input->post('t_code') ? $this->input->post('t_code') : "";
		$t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
		$t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
		$t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
		$t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
		$a_code_name = $this->input->post('a_code_name') ? $this->input->post('a_code_name') : "";
		$a_code_value = $this->input->post('a_code_value') ? $this->input->post('a_code_value') : "";
		$a_min_value = $this->input->post('a_min_value') ? $this->input->post('a_min_value') : "";
		$a_max_value = $this->input->post('a_max_value') ? $this->input->post('a_max_value') : "";
		$a_fixed = $this->input->post('a_fixed') ? $this->input->post('a_fixed') : "";
		$c_code_name = $this->input->post('c_code_name') ? $this->input->post('c_code_name') : "";
		$c_code_value = $this->input->post('c_code_value') ? $this->input->post('c_code_value') : "";
		$c_min_value = $this->input->post('c_min_value') ? $this->input->post('c_min_value') : "";
		$c_max_value = $this->input->post('c_max_value') ? $this->input->post('c_max_value') : "";
		$c_fixed = $this->input->post('c_fixed') ? $this->input->post('c_fixed') : "";
		$e_code_name = $this->input->post('e_code_name') ? $this->input->post('e_code_name') : "";
		$e_code_value = $this->input->post('e_code_value') ? $this->input->post('e_code_value') : "";
		$e_min_value = $this->input->post('e_min_value') ? $this->input->post('e_min_value') : "";
		$e_max_value = $this->input->post('e_max_value') ? $this->input->post('e_max_value') : "";
		$e_fixed = $this->input->post('e_fixed') ? $this->input->post('e_fixed') : "";
		$f_code_name = $this->input->post('f_code_name') ? $this->input->post('f_code_name') : "";
		$f_code_value = $this->input->post('f_code_value') ? $this->input->post('f_code_value') : "";
		$f_min_value = $this->input->post('f_min_value') ? $this->input->post('f_min_value') : "";
		$f_max_value = $this->input->post('f_max_value') ? $this->input->post('f_max_value') : "";
		$f_fixed = $this->input->post('f_fixed') ? $this->input->post('f_fixed') : "";
		$g_code_name = $this->input->post('g_code_name') ? $this->input->post('g_code_name') : "";
		$g_code_value = $this->input->post('g_code_value') ? $this->input->post('g_code_value') : "";
		$g_min_value = $this->input->post('g_min_value') ? $this->input->post('g_min_value') : "";
		$g_max_value = $this->input->post('g_max_value') ? $this->input->post('g_max_value') : "";
		$g_fixed = $this->input->post('g_fixed') ? $this->input->post('g_fixed') : "";
		$t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
		$t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
		$t1_min_value = $this->input->post('t1_min_value') ? $this->input->post('t1_min_value') : "";
		$t1_max_value = $this->input->post('t1_max_value') ? $this->input->post('t1_max_value') : "";
		$t1_fixed = $this->input->post('t1_fixed') ? $this->input->post('t1_fixed') : "";
		$t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
		$t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
		$t2_min_value = $this->input->post('t2_min_value') ? $this->input->post('t2_min_value') : "";
		$t2_max_value = $this->input->post('t2_max_value') ? $this->input->post('t2_max_value') : "";
		$t2_fixed = $this->input->post('t2_fixed') ? $this->input->post('t2_fixed') : "";
		$t3_code_name = $this->input->post('t3_code_name') ? $this->input->post('t3_code_name') : "";
		$t3_code_value = $this->input->post('t3_code_value') ? $this->input->post('t3_code_value') : "";
		$t3_min_value = $this->input->post('t3_min_value') ? $this->input->post('t3_min_value') : "";
		$t3_max_value = $this->input->post('t3_max_value') ? $this->input->post('t3_max_value') : "";
		$t3_fixed = $this->input->post('t3_fixed') ? $this->input->post('t3_fixed') : "";
		$url_cr = $this->input->post('url_cr') ? $this->input->post('url_cr') : "";
		$username_cr = $this->input->post('username_cr') ? $this->input->post('username_cr') : "";
		$password_cr = $this->input->post('password_cr') ? $this->input->post('password_cr') : "";
		$api_key_cr = $this->input->post('api_key_cr') ? $this->input->post('api_key_cr') : "";
		$account_id = $this->input->post('account_id') ? $this->input->post('account_id') : "";
		$account_token = $this->input->post('account_token') ? $this->input->post('account_token') : "";
		$application_id = $this->input->post('application_id') ? $this->input->post('application_id') : "";
		$acceptor_id = $this->input->post('acceptor_id') ? $this->input->post('acceptor_id') : "";
		$terminal_id = $this->input->post('terminal_id') ? $this->input->post('terminal_id') : "";

		$pax_pos_mid = $this->input->post('pax_pos_mid') ? $this->input->post('pax_pos_mid') : "";
		$pax_v_no = $this->input->post('pax_v_no') ? $this->input->post('pax_v_no') : "";
		$pax_bin = $this->input->post('pax_bin') ? $this->input->post('pax_bin') : "";
		$pax_agent = $this->input->post('pax_agent') ? $this->input->post('pax_agent') : "";
		$pax_chain = $this->input->post('pax_chain') ? $this->input->post('pax_chain') : "";
		$pax_store_no = $this->input->post('pax_store_no') ? $this->input->post('pax_store_no') : "";
		$pax_terminal_no = $this->input->post('pax_terminal_no') ? $this->input->post('pax_terminal_no') : "";
		$pax_currency_code = $this->input->post('pax_currency_code') ? $this->input->post('pax_currency_code') : "";
		$pax_country_code = $this->input->post('pax_country_code') ? $this->input->post('pax_country_code') : "";
		$pax_location_no = $this->input->post('pax_location_no') ? $this->input->post('pax_location_no') : "";
		$pax_timezone = $this->input->post('pax_timezone') ? $this->input->post('pax_timezone') : "";
		$pax_mcc_sic = $this->input->post('pax_mcc_sic') ? $this->input->post('pax_mcc_sic') : "";
		$processor_id = $this->input->post('processor_id') ? $this->input->post('processor_id') : "";

		$branch_info = array(
			'connection_id' => $connection_id,
			'api_key' => $api_key,
			'auth_code' => $auth_code,
			'min_shop_supply' => $min_shop_supply,
			'max_shop_supply' => $max_shop_supply,
			'shop_supply_percent' => $shop_supply_percent,
			'protractor_tax_percent' => $protractor_tax_percent,
			'b_code' => $b_code,
			'd_code' => $d_code,
			't_code' => $t_code,
			't1_code_name' => $t1_code_name,
			't1_code_value' => $t1_code_value,
			't2_code_name' => $t2_code_name,
			't2_code_value' => $t2_code_value,
			'a_code_name' => $a_code_name,
			'a_code_value' => $a_code_value,
			'a_min_value' => $a_min_value,
			'a_max_value' => $a_max_value,
			'a_fixed' => $a_fixed,
			'c_code_name' => $c_code_name,
			'c_code_value' => $c_code_value,
			'c_min_value' => $c_min_value,
			'c_max_value' => $c_max_value,
			'c_fixed' => $c_fixed,
			'e_code_name' => $e_code_name,
			'e_code_value' => $e_code_value,
			'e_min_value' => $e_min_value,
			'e_max_value' => $e_max_value,
			'e_fixed' => $e_fixed,
			'f_code_name' => $f_code_name,
			'f_code_value' => $f_code_value,
			'f_min_value' => $f_min_value,
			'f_max_value' => $f_max_value,
			'f_fixed' => $f_fixed,
			'g_code_name' => $g_code_name,
			'g_code_value' => $g_code_value,
			'g_min_value' => $g_min_value,
			'g_max_value' => $g_max_value,
			'g_fixed' => $g_fixed,
			't1_code_name' => $t1_code_name,
			't1_code_value' => $t1_code_value,
			't1_min_value' => $t1_min_value,
			't1_max_value' => $t1_max_value,
			't1_fixed' => $t1_fixed,
			't2_code_name' => $t2_code_name,
			't2_code_value' => $t2_code_value,
			't2_min_value' => $t2_min_value,
			't2_max_value' => $t2_max_value,
			't2_fixed' => $t2_fixed,
			't3_code_name' => $t3_code_name,
			't3_code_value' => $t3_code_value,
			't3_min_value' => $t3_min_value,
			't3_max_value' => $t3_max_value,
			't3_fixed' => $t3_fixed,
			'url_cr' => $url_cr,
			'username_cr' => $username_cr,
			'password_cr' => $password_cr,
			'api_key_cr' => $api_key_cr,
			'account_id_cnp' => $account_id,
			'account_token_cnp' => $account_token,
			'application_id_cnp' => $application_id,
			'acceptor_id_cnp' => $acceptor_id,
			'terminal_id' => $terminal_id,
			
			'pax_pos_mid' => $pax_pos_mid,
			'pax_v_no' => $pax_v_no,
			'pax_bin' => $pax_bin,
			'pax_agent' => $pax_agent,
			'pax_chain' => $pax_chain,
			'pax_store_no' => $pax_store_no,
			'pax_terminal_no' => $pax_terminal_no,
			'pax_currency_code' => $pax_currency_code,
			'pax_country_code' => $pax_country_code,
			'pax_location_no' => $pax_location_no,
			'pax_timezone' => $pax_timezone,
			'pax_mcc_sic' => $pax_mcc_sic,
			'processor_id' => $processor_id,

		);

		$respoonced=$this->admin_model->update_data('merchant', $branch_info, array('id' => $id));
		if($respoonced){
			echo '200';
		}
		else{
			echo '400';			
		}
	}
	
}
?>