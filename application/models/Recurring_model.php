<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Recurring_model extends CI_Model {
    var $table = 'customer_payment_request';
    var $column_order = array('transaction_id','merchant_id','mobile_no','amount','status','due_date','date_c','invoice_no','email_id', 'payment_id'); //set column field database for datatable orderable
    var $column_search = array('transaction_id','amount'); //set column field database for datatable searchable 
    var $order = array('mt.id' => 'desc'); // default order 
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function _all_conditions_datatable() {
       $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date));
        $status = $this->input->post('status');

        $this->db->select("mt.id, mt.transaction_id, mt.invoice_no, mt.mobile_no, mt.due_date, mt.transaction_type, mt.amount, mt.card_no, mt.card_type, mt.status, mt.add_date, mt.date_c, mt.merchant_id, mt.payment_id, mt.name, mt.late_fee, mt.recurring_count, mt.email_id, mt.title, mt.payment_type, mt.recurring_payment, mt.recurring_type, mt.recurring_pay_start_date, mt.recurring_pay_type, mt.recurring_count_remain, m.name, m.business_dba_name");
        $this->db->from($this->table. ' mt');
        $this->db->join('merchant m', 'mt.merchant_id = m.id', 'left');
        $this->db->where('mt.merchant_id !=', '413');
        $this->db->where('mt.payment_type', 'recurring');
        if ($start_date != '') {
            $this->db->where('mt.date_c >=', $start_date);
            $this->db->where('mt.date_c <=', $end_date);
        }
        if ($status != '') {
            $this->db->where('mt.status =', $status);
        }
    }
    public function _get_datatables_query(){
        //add custom filter here
        // echo"<pre>";print_r($_POST);die;
        $this->_all_conditions_datatable();

        $i = 0;
        foreach ($this->column_search as $item) {// loop column
            if($_POST['search']['value']){ // if datatable send POST for search
                if($i===0){ // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like('mt.'.$item, $_POST['search']['value']);
                    $this->db->or_like('m.name', $_POST['search']['value']);
                    $this->db->or_like('m.business_dba_name', $_POST['search']['value']);
                }
                else{
                    $this->db->or_like('mt.'.$item, $_POST['search']['value']);
                    $this->db->or_like('m.name', $_POST['search']['value']);
                    $this->db->or_like('m.business_dba_name', $_POST['search']['value']);
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
        $this->_all_conditions_datatable();
        return $this->db->count_all_results();
    }
}
