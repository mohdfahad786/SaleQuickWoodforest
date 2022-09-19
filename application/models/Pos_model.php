<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pos_model extends CI_Model {
	// var $table = 'pos';
	var $column_order = array('transaction_id', 'card_type', 'merchant_id', 'mobile_no', 'amount', 'status', 'add_date', 'invoice_no', 'email_id');
	var $column_search = array('transaction_id', 'amount','card_no');
	var $order = array('pos.id' => 'desc');
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function _all_conditions_datatable() {
		// echo '<pre>';print_r($_POST);die;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$start_date = date("Y-m-d", strtotime($start_date));
		$end_date = date("Y-m-d", strtotime($end_date));

		// $start_date = date("Y-m-d", strtotime($start_date));
		// $end_date = date("Y-m-d", strtotime($end_date));
		// echo $start_date.','.$end_date;die;
		// date_format($date,"Y/m/d H:i:s");
		//$end_date = date('Y-m-d', strtotime($this->input->post('end_date') . ' +2 day'));
		$status = $this->input->post('status');

		$this->db->select("pos.id, pos.transaction_id, pos.invoice_no, pos.transaction_type, pos.full_amount, pos.amount, pos.card_no, pos.card_type, pos.status, pos.add_date, pos.merchant_id, refund.add_date as refund_date, refund.transaction_id as refund_transaction_id, refund.amount as refund_amount, m.name, m.business_dba_name");
		$this->db->from('pos');
		$this->db->join('refund', 'pos.invoice_no = refund.invoice_no', 'left');
		$this->db->join('merchant m', 'pos.merchant_id = m.id', 'left');
		// $this->db->limit(20, 0);

		$this->db->where('pos.merchant_id !=', '413');
		$mysqlQry='';
		if($_POST['merchant_id']!=''){
			$this->db->where('pos.merchant_id', $_POST['merchant_id']);
		}
		else{
			$wf_merchants=$this->session->userdata('wf_merchants');
			$x=explode(",",$wf_merchants);
			$len=sizeof($x);
			if(!empty($wf_merchants)) {
				for ($i=0; $i <$len ; $i++) { 
					if($i==0){
		              	$mysqlQry.='(pos.merchant_id='.$x[$i].' or ';
		           	}else if($i==$len-1){
		           		 $mysqlQry.='pos.merchant_id='.$x[$i].')';
		           	}
		           	else{
		               	$mysqlQry.='pos.merchant_id='.$x[$i].' or ';
		           	}
		       
		        }
		        $this->db->where($mysqlQry);
		    }else{
					$stmt=' and pos.merchant_id is null ';
			}
		}
		if (!empty($start_date)) {
			$this->db->where('pos.date_c >=', $start_date);
			$this->db->where('pos.date_c <=', $end_date);
		}
		if (!empty($status)) {
			$this->db->where('pos.status', $status);
		} else {
			$this->db->where('pos.status !=', 'pending');
		}
		// echo $this->db->last_query();die;
	}
	public function _get_datatables_query() {
		//add custom filter here
		// echo"<pre>";print_r($_POST);die;
		$this->_all_conditions_datatable();
		
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					// echo '1<br>';
					$this->db->group_start();
					$this->db->like("pos." . $item, $_POST['search']['value']);
					$this->db->or_like('m.name', $_POST['search']['value']);
					$this->db->or_like('m.business_dba_name', $_POST['search']['value']);
				} else {
					// echo '2<br>';
					$this->db->or_like("pos." . $item, $_POST['search']['value']);
					$this->db->or_like('m.name', $_POST['search']['value']);
					$this->db->or_like('m.business_dba_name', $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}
		// die;
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
	// public function count_filtered() {
	// 	$this->_get_datatables_query();
	// 	$query = $this->db->get();
	// 	return $query->num_rows();
	// }
	// public function count_all() {
	// 	$this->_all_conditions_datatable();
	// 	return $this->db->count_all_results();
	// }

	public function _all_count_conditions_datatable() {
		// $this->_all_conditions_datatable();
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$start_date = date("Y-m-d", strtotime($start_date));
		$end_date = date("Y-m-d", strtotime($end_date));
		$status = $this->input->post('status');

		$this->db->select("id");
		$this->db->from('pos');
		// $this->db->join('refund', 'pos.invoice_no = refund.invoice_no', 'left');
		// $this->db->join('merchant m', 'pos.merchant_id = m.id', 'left');

		$this->db->where('merchant_id !=', '413');
		if (!empty($start_date)) {
			$this->db->where('date_c >=', $start_date);
			$this->db->where('date_c <=', $end_date);
		}
		if (!empty($status)) {
			$this->db->where('status', $status);
		} else {
			$this->db->where('status !=', 'pending');
		}
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
		// return $this->db->count_all_results();
	}

	public function count_filtered() {
		if( !empty($_POST['search']['value']) ) {
			$this->_all_conditions_datatable();

			$i = 0;
			// echo '<pre>';print_r($_POST['search']['value']);die;
			foreach ($this->column_search as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						// echo '1<br>';
						$this->db->group_start();
						$this->db->like("pos." . $item, $_POST['search']['value']);
						$this->db->or_like('m.name', $_POST['search']['value']);
						$this->db->or_like('m.business_dba_name', $_POST['search']['value']);
					} else {
						// echo '2<br>';
						$this->db->or_like("pos." . $item, $_POST['search']['value']);
						$this->db->or_like('m.name', $_POST['search']['value']);
						$this->db->or_like('m.business_dba_name', $_POST['search']['value']);
					}
					if (count($this->column_search) - 1 == $i) {
						$this->db->group_end();
					}
				}
				$i++;
			}
			// die;
			if (isset($_POST['order'])) {
				// here order processing
				$this->db->order_by("pos." . $this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
			$this->db->group_by("pos.invoice_no");
			
		} else {
			$this->_all_count_conditions_datatable();
			return $this->db->count_all_results();
		}
		// $this->_get_datatables_query();

		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all() {
		$this->_all_count_conditions_datatable();
		return $this->db->count_all_results();
	}
}
