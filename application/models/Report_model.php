<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report_model extends CI_Model {
	var $table = 'report_admin';
	var $column_order = array('id', 'business_dba_name', 'amount', 'hold_amount', 'monthly_fee', 'text_email', 'f_swap_Invoice', 'f_swap_Recurring', 'f_swap_Text', 'name', 'invoice', 'recurring', 'point_sale', 'email', 'bank_account', 'status', 'feesamoun', 'date_c', 'totalAmount');
	var $column_search = array('id', 'business_dba_name', 'amount', 'hold_amount', 'monthly_fee', 'text_email', 'f_swap_Invoice', 'f_swap_Recurring', 'f_swap_Text', 'name', 'invoice', 'recurring', 'point_sale', 'email', 'bank_account', 'status', 'feesamoun', 'date_c', 'totalAmount');
	var $order = array('id' => 'desc');
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function _all_conditions_datatable() {
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$employee = $this->input->post('employee');
		$status = $this->input->post('status');

		// $condtions = "";
		// if (!empty($status)) {
		// 	$condtions .= " and fs.status = '" . $status . "'";
		// }
		if (!empty($employee)) {
			$this->db->where('id', $employee);
		}
		$this->db->from($this->table);
	}

	public function _get_datatables_query() {
		$this->_all_conditions_datatable();
		
		$i = 0;
		foreach ($this->column_search as $item) {
			// loop column
			if ($_POST['search']['value']) {
				// if datatable send POST for search
				if ($i === 0) {
					// first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i) //last loop
				{
					$this->db->group_end();
				}
				//close bracket
			}
			$i++;
		}
		if (isset($_POST['order'])) {
			// here order processing
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		// $this->db->group_by("pos.invoice_no");
	}

	public function get_datatables() {
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		$_query = $this->db->last_query();
		$result = array('query' => $_query, 'result' => $query->result_array());
		return $result;
	}

	public function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all() {
		$this->_all_conditions_datatable();
		return $this->db->count_all_results();
	}
}