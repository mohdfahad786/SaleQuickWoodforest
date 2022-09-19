<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Serverside_model extends CI_Model {
	function __construct() {
		parent::__construct();
    }
    
    public function getRows($postData, $column_order, $column_search, $order, $table) {
    	$this->_get_datatables_query($postData, $column_order, $column_search, $order, $table);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();
    }
    
    public function countAll($table){
        $this->db->from($table);
        $this->db->where('user_type', 'merchant');
        $this->db->where('status !=', 'deleted');
        if(!empty($postData['start_date'])) {
            $this->db->where('date_c >=', $postData['start_date']);
            $this->db->where('date_c <', $postData['end_date']);
        }
        if(!empty($postData['status'])) {
            // $this->db->where('status', $postData['status']);
            if($postData['status'] == 'pending') {
                $this->db->where('status', 'pending');
                $this->db->or_where('status', 'pending_signup');
                
            } else {
                $this->db->where('status', $postData['status']);
            }
        }

        return $this->db->count_all_results();
    }
    
    public function countFiltered($postData, $column_order, $column_search, $order, $table){
        $this->_get_datatables_query($postData, $column_order, $column_search, $order, $table);
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->num_rows();
    }
    
    private function _get_datatables_query($postData, $column_order, $column_search, $order, $table){
        // print_r($postData);die;
        $this->db->from($table);
        $this->db->where('user_type', 'merchant');
        $this->db->where('status !=', 'deleted');
        $this->db->where('wood_forest', '1');
        if(!empty($postData['start_date'])) {
            $this->db->where('date_c >=', $postData['start_date']);
            $this->db->where('date_c <', $postData['end_date']);
        }
        // if(!empty($postData['status'])) {
        //     $this->db->where('status', $postData['status']);
        // }
        if(!empty($postData['status'])) {
            if($postData['status'] == 'pending') {
                $this->db->where('status', 'pending');
                $this->db->or_where('status', 'pending_signup');
                
            } else {
                $this->db->where('status', $postData['status']);
            }

        } else {
            $this->db->where('status !=', 'block');
            $this->db->where('status !=', 'deactivate');
        }

        $i = 0;
        foreach($column_search as $item){
            if($postData['search']['value']){
                if($i===0){
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                if(count($column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
        
        if(isset($postData['order'])){
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if(isset($order)) {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getRows_sub_merchant($postData, $column_order, $column_search, $order, $table, $merchant_id) {
        $this->_get_datatables_query_sub_merchant($postData, $column_order, $column_search, $order, $table, $merchant_id);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function countAll_sub_merchant($table, $merchant_id){
        $this->db->from($table);
        $this->db->where('user_type', 'employee');
        $this->db->where('status !=', 'deleted');
        if(!empty($postData['start_date'])) {
            $this->db->where('date_c >=', $postData['start_date']);
            $this->db->where('date_c <=', $postData['end_date']);
        }
        if(!empty($postData['status'])) {
            $this->db->where('status', $postData['status']);
        }
        if (!empty($merchant_id)) {
            $this->db->where('merchant_id', $merchant_id);
        }

        return $this->db->count_all_results();
    }
    
    public function countFiltered_sub_merchant($postData, $column_order, $column_search, $order, $table, $merchant_id){
        $this->_get_datatables_query_sub_merchant($postData, $column_order, $column_search, $order, $table, $merchant_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    private function _get_datatables_query_sub_merchant($postData, $column_order, $column_search, $order, $table, $merchant_id){
        // print_r($postData);die;
        $this->db->from($table);
        $this->db->where('user_type', 'employee');
        $this->db->where('status !=', 'deleted');
        if(!empty($postData['start_date'])) {
            $this->db->where('date_c >=', $postData['start_date']);
            $this->db->where('date_c <=', $postData['end_date']);
        }
        if(!empty($postData['status'])) {
            $this->db->where('status', $postData['status']);
        }
        if (!empty($merchant_id)) {
            $this->db->where('merchant_id', $merchant_id);
        }

        $i = 0;
        foreach($column_search as $item){
            if($postData['search']['value']){
                if($i===0){
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                if(count($column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
        
        if(isset($postData['order'])){
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if(isset($order)) {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

}