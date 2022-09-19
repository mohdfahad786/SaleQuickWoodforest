<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Agent_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}


  public function data_get_where_amount($subadmin_id,$month,$year) {
    $this->db->select('amount');
    $this->db->from('agent_payout');
    $this->db->where('merchant_id', $subadmin_id);
    $this->db->where('month', $month);
    $this->db->where('year', $year);
    
   
    $this->db->order_by("id", "desc");
    $query = $this->db->get(); //print_r($this->db->last_query()); die("Query"); 
    return $query->result();
    }

	public function get_full_reports_reseller($filters) {

    $condtions = "";
   
            // $allmerf=$this->session->userdata('subadmin_assign_merchant'); 
            // $merchantid=explode(',',$allmerf);
            // //$this->db->where_in('merchant_id',$merchantid); 
            // $query = $this->db->query("SELECT m.id,m.business_dba_name,m.status,m.date_c,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,(IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' AND  card_type!='CASH' AND  card_type!='CHECK' AND  card_no!='0' AND (status='confirm' OR status='Chargeback_Confirm') ),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm')),0)) as totalAmount from merchant m   where m.id IN($allmerf) AND  m.user_type='merchant' and m.status='Active' $condtions");


// $query = $this->db->query("SELECT sum(amount) as amount,sum(revenue) as revenue ,sum(interchangeFee) as interchangeFee ,sum(networkFees) as networkFees,sum(buy_rate) as buy_rate from infinicept_transaction where  date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ");

$query = $this->db->query("SELECT sum(Payment_Volume) as amount,sum(Revenue) as revenue ,sum(InterchangeDuesFee) as interchangeFee ,sum(GrossProfit) as GrossProfit from csv_details where  month ='" . $filters['csv_month'] . "' AND year ='" . $filters['csv_year'] . "' ");
       
       //echo $this->db->last_query();  die(); 
    return $query->result_array();

    }

    public function get_full_payout_reseller($filters) {

    $condtions = "";


//$query = $this->db->query("SELECT sum(amount) as amount from agent_payout where  date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ");
$query = $this->db->query("SELECT sum(amount) as amount from agent_payout where  add_date >='" . DATE($filters['date']) . "' AND add_date <='" . DATE($filters['date2']) . "' ");
       
       //echo $this->db->last_query();  die(); 
    return $query->result_array();

    }


     public function get_full_reports_merchant($filters) {

    $condtions = "";

$merchantid=explode(',',$filters['merchant_id']);
$query = $this->db->query("SELECT sum(Transaction) as transaction,sum(Payment_Volume) as amount,sum(Revenue) as revenue ,sum(InterchangeDuesFee) as interchangeFee ,sum(GrossProfit) as GrossProfit,sum(buy_rate) as buy_rate,sum(buy_rate_valume) as buy_rate_valume,sum(gateway_fee) as gateway_fee from csv_details where merchant_id IN (".$filters['merchant_id'].") and  month ='" . $filters['csv_month'] . "' AND year ='" . $filters['csv_year'] . "' ");

       
      //echo $this->db->last_query();  die(); 
    return $query->result_array();

    }


}