<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_model extends CI_Model {
    var $table = 'customer_payment_request';
    var $column_order = array('transaction_id','merchant_id','mobile_no','amount','status','due_date','date_c','invoice_no','email_id', 'payment_id', 'invoice_type');
    var $column_search = array('transaction_id', 'mt.amount');
    var $order = array('mt.id' => 'desc');
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function _all_conditions_datatable() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        // $end_date = date('Y-m-d', strtotime($this->input->post('end_date') . ' +2 day'));

$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date));

        $status = $this->input->post('status');

        $this->db->select("mt.id, mt.transaction_id, mt.invoice_no, mt.mobile_no, mt.due_date, mt.transaction_type, mt.amount, mt.card_no, mt.invoice_type, mt.card_type, mt.status, mt.add_date, mt.date_c, mt.merchant_id, mt.payment_id, refund.add_date as refund_date, refund.transaction_id as refund_transaction_id, refund.amount as refund_amount, m.name, m.business_dba_name");
        $this->db->from($this->table . ' mt');
        $this->db->join('refund', 'mt.invoice_no = refund.invoice_no', 'left');
        $this->db->join('merchant m', 'mt.merchant_id = m.id', 'left');
        $this->db->where('mt.merchant_id !=', '413');
        $this->db->where('payment_type', 'straight');
        $mysqlQry='';
        if($_POST['merchant_id']!=''){
            $this->db->where('mt.merchant_id', $_POST['merchant_id']);
        }
        else
        {    
            $wf_merchants=$this->session->userdata('wf_merchants');
            $x=explode(",",$wf_merchants);
            $len=sizeof($x);
            if(!empty($wf_merchants)) {
                for ($i=0; $i <$len ; $i++) { 
                    if($i==0){
                        $mysqlQry.='(mt.merchant_id='.$x[$i].' or ';
                    }else if($i==$len-1){
                         $mysqlQry.='mt.merchant_id='.$x[$i].')';
                    }
                    else{
                        $mysqlQry.='mt.merchant_id='.$x[$i].' or ';
                    }
               
                }
                $this->db->where($mysqlQry);
            }else{
                    $mysqlQry=' and mt.merchant_id is null ';
            }
        }
        // $this->db->where('mt.date_c >=', $date);
        if (!empty($start_date)) {
            $this->db->where('mt.date_c >=', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('mt.date_c <=', $end_date);
        }
        if (!empty($status)) {
            $this->db->like('mt.status', $status);
        } else {
            $this->db->where('mt.status !=', 'pending' );
        }
        if($start_date == '' && $end_date == '' && $status == ''){
            $this->db->where('status!=','Chargeback_Confirm');
        }
    }
    public function _get_datatables_query(){
        //add custom filter here
        // echo"<pre>";print_r($_POST);die;
        $this->_all_conditions_datatable();

        $i = 0;
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']){
                if($i===0){
                    $this->db->group_start();
                    $this->db->like('mt.'.$item, $_POST['search']['value']);
                    $this->db->or_like('m.name', $_POST['search']['value']);
                    $this->db->or_like('m.business_dba_name', $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                    $this->db->or_like('m.name', $_POST['search']['value']);
                    $this->db->or_like('m.business_dba_name', $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if(isset($_POST['order'])){ // here order processing
            $this->db->order_by('mt.'.$this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)){
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
