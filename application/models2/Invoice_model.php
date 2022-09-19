<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Invoice_model extends CI_Model {
        var $table = 'customer_payment_request';
        var $column_order = array('invoice_no','transaction_id','merchant_id','mobile_no','amount','status','due_date','date_c','invoice_no','email_id'); //set column field database for datatable orderable
        var $column_search = array('invoice_no','transaction_id','merchant_id','mobile_no','amount','status','due_date','date_c','invoice_no','email_id'); //set column field database for datatable searchable 
        var $order = array('id' => 'desc'); // default order 
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        public function _get_datatables_query(){
            //add custom filter here
            // echo"<pre>";print_r($_POST);die;
            $date = date('Y-m-d', strtotime('-30 days'));
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $status = $this->input->post('status');
            if(!empty($start_date)){
                $this->db->where('date_c >=', $start_date);
            }
            if(!empty($end_date)){
                $this->db->where('date_c <=', $end_date);
            }
            if(!empty($status)){
                $this->db->like('status', $status);
                $this->db->where('date_c >=', $date); 
            }
            $this->db->where('payment_type', 'straight' );
            if($start_date == '' && $end_date == '' && $status == ''){
                $this->db->where('status!=','Chargeback_Confirm');
            }
            $this->db->from($this->table);
            $i = 0;
            foreach ($this->column_search as $item) {// loop column
                if($_POST['search']['value']){ // if datatable send POST for search
                    if($i===0){ // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else{
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
            if(isset($_POST['order'])){ // here order processing
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order)){
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
        public function get_datatables(){
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            // echo $this->db->last_query();die;
            $_query = $this->db->last_query();
            $result = array('query' => $_query,'result' => $query->result());
            return $result;
        }
        public function count_filtered(){
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
        public function count_all(){
            if(empty($start_date)){
                $this->db->where('status!=','Chargeback_Confirm');
            }
            $this->db->where('payment_type', 'straight' );
            $this->db->from($this->table);
            return $this->db->count_all_results();
        }
    }