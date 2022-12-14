<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Recurring_admin_model extends CI_Model {
	// var $table = 'customer_payment_request';
	var $column_order = array('transaction_id', 'card_type', 'merchant_id', 'mobile_no', 'amount', 'status', 'add_date', 'invoice_no', 'email_id');
	var $column_search = array('transaction_id', 'amount','name');
	var $order = array('customer_payment_request.id' => 'desc');

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function _all_conditions_datatable() {
		// echo '<pre>';print_r($_POST);die;
		// $merchant_id = $this->session->userdata('merchant_id');
		// $date1 = $this->input->post('start_date');
		// $date2 = $this->input->post('end_date');
		$date1='1969-01-01';
		$date2=date("Y-m-d");
		$status = $this->input->post('status');

		$date1 = date('Y-m-d', strtotime($date1));
		$date2 = date('Y-m-d', strtotime($date2));

		$this->db->select("*");
		$this->db->from('customer_payment_request cpr');

		$this->db->where('cpr.merchant_id !=', 413);
		$this->db->where('cpr.payment_type', 'recurring');
		if (!empty($date1)) {
			$this->db->where('cpr.date_c >=', $date1);
			$this->db->where('cpr.date_c <=', $date2);
		}
		$status = $this->input->post('status');
		if(!empty($status)) {
			if($status=='late')
			{
				$this->db->like('cpr.status', 'declined');
			}
			else{
				$this->db->like('cpr.status', $status);
			}
		}
		$mysqlQry='';
		if($_POST['merchant_id']!=''){
            $this->db->where('cpr.merchant_id', $_POST['merchant_id']);
        }
        else
        {
			$stmtQuery="cpr.merchant_id IN('";
			$wf_merchants=$this->session->userdata('wf_merchants');

			if(!empty($wf_merchants)) {
		        $x=explode(",",$wf_merchants);
		        $len=sizeof($x);
		        for ($i=0; $i <$len ; $i++) { 
		            if($i==0){
		                $stmtQuery.=$x[$i];
		            }else{
		                $stmtQuery.="','".$x[$i];
		            }
		        
		        }
		        $stmtQuery.="')";

			}else{
				$stmtQuery=' cpr.merchant_id is null ';

			}
			$this->db->where($stmtQuery);
	    }
		
		
	}

	public function _get_datatables_query() {
		$this->_all_conditions_datatable();
		
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like("cpr." . $item, $_POST['search']['value']);
				} else {
					$this->db->or_like("cpr." . $item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}
		if (isset($_POST['order'])) {
			// here order processing
			$this->db->order_by("cpr." . $this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->group_by("cpr.invoice_no");
	}

	public function get_datatables() {
		$this->_get_datatables_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		$_query = $this->db->last_query();
		// echo $_query;die;
		$result = array('query' => $_query, 'result' => $query->result());
		return $result;
	}

	public function count_filtered() {
		// $merchant_id = $this->session->userdata('merchant_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));
		$status = $this->input->post('status');

		if(!empty($status)) {
			$where = " AND status LIKE '".$status."'";
		} else {
			$where = "";
		}

		$i = 0;
		$where_search = '';
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$where_search .= " AND ".$item." LIKE '%".$_POST['search']['value']."%'";
				} else {
					$where_search .= " OR ".$item." LIKE '%".$_POST['search']['value']."%'";
				}
			}
			$i++;
		}	
		$stmtQuery=" and merchant_id IN('";
		$wf_merchants=$this->session->userdata('wf_merchants');

		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                $stmtQuery.=$x[$i];
	            }else{
	                $stmtQuery.="','".$x[$i];
	            }
	        
	        }
	        $stmtQuery.="')";

		}else{
			$stmtQuery=' and merchant_id is null ';

		}
		$query_count_filter = $this->db->query("SELECT invoice_no FROM customer_payment_request WHERE payment_type = 'recurring' ".$stmtQuery." AND date_c >= '".$start_date. "' AND date_c <= '".$end_date. "' AND merchant_id != 413". $where.$where_search);
		

		return $query_count_filter->num_rows();
	}

	public function count_all() {
		// $merchant_id = $this->session->userdata('merchant_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));
		$stmtQuery=" and merchant_id IN('";
		$wf_merchants=$this->session->userdata('wf_merchants');

		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                $stmtQuery.=$x[$i];
	            }else{
	                $stmtQuery.="','".$x[$i];
	            }
	        
	        }
	        $stmtQuery.="')";

		}else{
			$stmtQuery=' and merchant_id is null ';

		}
		$query_count_all = $this->db->query("SELECT invoice_no FROM customer_payment_request WHERE payment_type = 'recurring' ".$stmtQuery." AND date_c >= '".$start_date. "' AND date_c <= '".$end_date. "' AND merchant_id != 413");
		
		return $query_count_all->num_rows();
	}
}