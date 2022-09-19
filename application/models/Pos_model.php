<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pos_model extends CI_Model {
	var $table = 'pos';
	var $column_order = array('transaction_id', 'card_type', 'merchant_id', 'mobile_no', 'amount', 'status', 'add_date', 'invoice_no', 'email_id'); //set column field database for datatable orderable
	var $column_search = array('transaction_id', 'card_type', 'merchant_id', 'mobile_no', 'amount', 'status', 'add_date', 'invoice_no', 'email_id'); //set column field database for datatable searchable
	var $order = array('pos.id' => 'desc'); // default order
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function _get_datatables_query_old() {
		//add custom filter here
		// echo"<pre>";print_r($_POST);die;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$status = $this->input->post('status');
		if (!empty($start_date)) {
			$this->db->where('date_c >=', $start_date);
		}
		$this->db->where('date_c >=', $start_date);
		if (!empty($end_date)) {
			$this->db->where('date_c <=', $end_date);
		}
		if (!empty($status)) {
			$this->db->like('status', $status);
		}
		$this->db->from($this->table);
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
	}

	public function _get_datatables_query() {
		//add custom filter here
		// echo"<pre>";print_r($_POST);die;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$status = $this->input->post('status');
		$this->db->select("pos.*, refund.add_date as refund_date,refund.transaction_id as refund_transaction_id,refund.amount as refund_amount");
		$this->db->from($this->table);
		$this->db->join('refund', 'pos.invoice_no = refund.invoice_no', 'left');
		if (!empty($start_date)) {
			$this->db->where('pos.date_c >=', $start_date);
		}
		if (!empty($end_date)) {
			$this->db->where('pos.date_c <=', $end_date);
		}
		if (!empty($status)) {
			$this->db->like('pos.status', $status);
		} else {
			$this->db->where('pos.status !=', 'pending' );
		}
		


		$i = 0;
		foreach ($this->column_search as $item) {
			// loop column
			if ($_POST['search']['value']) {
				// if datatable send POST for search
				if ($i === 0) {
					// first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like("pos." . $item, $_POST['search']['value']);
				} else {
					$this->db->or_like("pos." . $item, $_POST['search']['value']);
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
			$this->db->order_by("pos." . $this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->group_by("pos.invoice_no");
	}
	public function get_datatables() {
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		$_query = $this->db->last_query();
		$result = array('query' => $_query, 'result' => $query->result());
		return $result;
	}
	public function get_datatables_test() {
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die;
		$_query = $this->db->last_query();
		$result = array('query' => $_query, 'result' => $query->result());
		return $result;
	}
	public function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all() {
		// if(!empty($start_date)){
		//     $start_date = date("Y-m-d",strtotime("-29 days"));
		// }else{
		//     $start_date = date("Y-m-d",strtotime("-30 days"));
		// }
		// $this->db->where('date_c >=', $start_date);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}