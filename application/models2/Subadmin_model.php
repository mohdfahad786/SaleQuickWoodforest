<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Subadmin_model extends CI_Model {


  var $table = 'pos';
  var $column_order = array('transaction_id', 'card_type', 'merchant_id', 'mobile_no', 'amount', 'status', 'add_date', 'invoice_no', 'email_id'); //set column field database for datatable orderable
  var $column_search = array('transaction_id', 'card_type', 'merchant_id', 'mobile_no', 'amount', 'status', 'add_date', 'invoice_no', 'email_id'); //set column field database for datatable searchable
  var $order = array('pos.id' => 'desc'); // default order


  public function __construct() {
    parent::__construct();
    }
    

    public function data_get_where($table, $condition) {
        $this->db->order_by("id", "desc");
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }
        
        $q = $this->db->get_where($table, $condition);
       
    return $q->result(); 
    }
  
    public function data_get_where_1($table, $condition) {
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }

    $this->db->order_by("id", "desc");
    $q = $this->db->get_where($table, $condition);
    return $q->result_array();
    }
    
    public function get_full_details_admin_report($table) {
    $date = date('Y-m-d', strtotime('-30 days'));

        $this->db->where('date_c >=', $date);
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }

    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);

    return $query->result();
    }
    


    function getLastpayment($filters) {
    //print_r($filters);
    $fromdate = date("Y", strtotime($filters['date'])) . "-" . date("m", strtotime($filters['date'])) . "-01";
    $query = $this->db->query("select count(*) as cnt from  funding_status where amount>0 and  merchant_id=" . $filters['merchant_id'] . " and  (date(date)>='" . $fromdate . "' and  date(date)<'" . $filters['date'] . "')");
    return $query->result_array();
    }
    

  public function get_full_reports_reseller_1($filters) {

    $condtions = "";
    // if (isset($filters['status']) and $filters['status'] != '') {
    //   $condtions .= " and fs.status='" . $filters['status'] . "'";
    // }

    // if (isset($filters['employee']) and $filters['employee'] != '') {
    //   $condtions .= " and m.id=" . $filters['employee'];
    //     }
        
        if($this->session->userdata('subadmin_assign_merchant'))
    {
            $allmerf=$this->session->userdata('subadmin_assign_merchant'); 
            $merchantid=explode(',',$allmerf);
            //$this->db->where_in('merchant_id',$merchantid); 
            $query = $this->db->query("SELECT m.id,m.business_dba_name,m.status,m.date_c,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,(IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' AND  card_type!='CASH' AND  card_type!='CHECK' AND  card_no!='0' AND (status='confirm' OR status='Chargeback_Confirm') ),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm')),0)) as totalAmount from merchant m   where m.id IN($allmerf) AND  m.user_type='merchant' and m.status='Active' $condtions");

        }
        else
        {
            $query = $this->db->query("SELECT m.id,m.business_dba_name,m.status,m.date_c,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,(IFNULL((select sum(fee) from  recurring_payment where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  recurring_payment where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm')),0) + IFNULL((select sum(amount) from  pos where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND  card_type!='CASH' AND  card_type!='CHECK' AND  card_no!='0'  AND (status='confirm' OR status='Chargeback_Confirm') ),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm') ),0)) as totalAmount from merchant m   where  m.user_type='merchant' and m.status='Active' $condtions");

        }
        
    //    echo $this->db->last_query();  die(); 
    return $query->result_array();

    }

public function get_full_reports_reseller($filters) {

    $condtions = "";
    $allmerf=$this->session->userdata('subadmin_assign_merchant'); 
 
//$this->db->where_in('merchant_id',$merchantid);
$query = $this->db->query("SELECT sum(Payment_Volume) as amount,sum(Revenue) as revenue ,sum(InterchangeDuesFee) as interchangeFee ,sum(GrossProfit) as GrossProfit,sum(buy_rate) as buy_rate,sum(buy_rate_valume) as buy_rate_valume,sum(gateway_fee) as gateway_fee  from csv_details   where merchant_id IN($allmerf) and month ='" . $filters['csv_month'] . "' AND year ='" . $filters['csv_year'] . "' ");
       
      // echo $this->db->last_query();  die(); 
    return $query->result_array();

    }

    public function get_full_payout_reseller($filters) {

    $condtions = "";
    $subadmin_id = $this->session->userdata('subadmin_id');

//$query = $this->db->query("SELECT sum(amount) as amount from agent_payout where  date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ");
$query = $this->db->query("SELECT sum(amount) as amount from agent_payout where  add_date >='" . DATE($filters['date']) . "' AND add_date <='" . DATE($filters['date2']) . "' AND merchant_id='".$subadmin_id."' ");
       
       //echo $this->db->last_query();  die(); 
    return $query->result_array();

    }

    public function get_full_reports_merchant($filters) {

    $condtions = "";

$merchantid=explode(',',$filters['merchant_id']);
$query = $this->db->query("SELECT Merchant,sum(Transaction) as transaction,sum(Payment_Volume) as amount,sum(Revenue) as revenue ,sum(InterchangeDuesFee) as interchangeFee ,sum(GrossProfit) as GrossProfit,sum(buy_rate) as buy_rate,sum(buy_rate_valume) as buy_rate_valume,sum(gateway_fee) as gateway_fee from csv_details where merchant_id='".$filters['merchant_id']."' and  month ='" . $filters['csv_month'] . "' AND year ='" . $filters['csv_year'] . "' ");

       
      //echo $this->db->last_query();  die(); 
    return $query->result_array();

    }


    public function get_full_reports($filters) {

    $condtions = "";
    // if (isset($filters['status']) and $filters['status'] != '') {
    //   $condtions .= " and fs.status='" . $filters['status'] . "'";
    // }

    // if (isset($filters['employee']) and $filters['employee'] != '') {
    //   $condtions .= " and m.id=" . $filters['employee'];
    //     }
        
        if($this->session->userdata('subadmin_assign_merchant'))
    {
            $allmerf=$this->session->userdata('subadmin_assign_merchant'); 
            $merchantid=explode(',',$allmerf);
            //$this->db->where_in('merchant_id',$merchantid); 
            $query = $this->db->query("SELECT m.id,m.business_dba_name,m.status,m.date_c,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,(IFNULL((select sum(fee) from  recurring_payment where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  pos where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as month, (IFNULL((select sum(amount) from  recurring_payment where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm')),0) + IFNULL((select sum(amount) from  pos where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND  card_type!='CASH' AND  card_type!='CHECK' AND  card_no!='0' AND (status='confirm' OR status='Chargeback_Confirm') ),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm')),0)) as totalAmount from merchant m   where m.id IN($allmerf) AND  m.user_type='merchant' and m.status='Active' $condtions");

        }
        else
        {
            $query = $this->db->query("SELECT m.id,m.business_dba_name,m.status,m.date_c,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,(IFNULL((select sum(fee) from  recurring_payment where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  recurring_payment where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm')),0) + IFNULL((select sum(amount) from  pos where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND  card_type!='CASH' AND  card_type!='CHECK' AND  card_no!='0'  AND (status='confirm' OR status='Chargeback_Confirm') ),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and year ='" . $filters['date'] . "' AND month ='" . $filters['date2'] . "' AND (status='confirm' OR status='Chargeback_Confirm') ),0)) as totalAmount from merchant m   where  m.user_type='merchant' and m.status='Active' $condtions");

        }
        
    //    echo $this->db->last_query();  die(); 
    return $query->result_array();

    }
    

    public function data_get_where_g($table, $condition) {
    $this->db->order_by("id", "desc");
    $this->db->select('amount,tax,type,date_c,reference');
    if($this->session->userdata('assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
    }
    $q = $this->db->get_where($table, $condition);
    return $q->result_array();
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
    

    public function data_get_where_dow($table, $end_date, $start_date) {
    $this->db->select('amount,tax,type,date_c,reference');
    $this->db->from($table);
    $this->db->where('date_c >=', $start_date);
    $this->db->where('date_c <=', $end_date);
    $this->db->where("(status='confirm' OR status='Chargeback_Confirm')");
    if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
    }
    $this->db->order_by("id", "desc");
    $query = $this->db->get(); //print_r($this->db->last_query()); die("Query"); 
    return $query->result();
    }

    public function get_full_details_agent($table,$subadmin_id) {

        $this->db->where('user_type','agent');
        $this->db->where('id',$subadmin_id);
        $this->db->order_by("id", "desc");
        $query = $this->db->get($table);

        return $query->result();
    }
    

    public function data_get_where_ggg_1($start_date, $end_date, $status, $employ, $table) {
    $this->db->select('amount,tax,tip_amount,type,date_c,reference');
    $this->db->from($table);

    if ($start_date != '') {

      $this->db->where('date_c >=', $start_date);

      $this->db->where('date_c <=', $end_date);

    } else {

      $date = date('Y-m-d', strtotime('-30 days'));
      $this->db->where('date_c >', $date);

    }
    if ($status != '') {
      // $this->db->where('status', $status);
      // $this->db->or_where('status', 'Chargeback_Confirm');
            $this->db->where("(status='$status' OR status='Chargeback_Confirm')");
    }

        
        
    if ($employ !='all' && $employ!="" ) {
      $this->db->where_in('merchant_id', $employ);
        }
        else if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }
    //  $this->db->where('merchant_id',$merchant_id);
    //  $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query->result_array();

    }


    public function data_get_where_ggg_refund($start_date, $end_date, $status, $employ, $table) {

    

    $this->db->select('mt.amount,mt.tax,mt.tip_amount,mt.type,mt.reference,r.add_date as date_c');
    $this->db->from("refund r");
    if ($start_date != '') {

      $this->db->where('r.date_c >=', $start_date);

      $this->db->where('r.date_c <=', $end_date);

    } else {

      $date = date('Y-m-d', strtotime('-30 days'));
      $this->db->where('r.date_c >', $date);

    }
    if ($employ!='all' && $employ!="") {
      $this->db->where_in('mt.merchant_id', $employ);
        }
        else if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('mt.merchant_id',$merchantid);
        }

    $this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
    $query = $this->db->get();

    // print_r($this->db->last_query());
    // die("m");
    return $query->result();

    }




    function get_user_by_id($id)
     {
        
     $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('id', $id);   
        $this->db->where('status', 'active');
        $query = $this->db->get();
        return $query->row_array();
   }
   
  function select_request_id($table,$id)
  {
    
     $this->db->where('id',$id);
     $query=$this->db->get($table);
     return $query->row();  

    }


    public function get_package_details($id = "") {

    if ($id != "") {
      //$id = intval($id);
      $this->db->where_in('id', $id); 
           
    }
    $this->db->where('user_type', 'merchant');
    $this->db->order_by("id", "desc");
    // $this->db->limit(1);
    $query = $this->db->get('merchant');
    return $query->result();
  }
  public function get_package_details_id($id = "") {
    $this->db->select('id,status');
    if ($id != "") {
      //$id = intval($id);
      $this->db->where_in('id', $id); 
           
    }
    $this->db->where('user_type', 'merchant');
    $this->db->order_by("id", "desc");
    // $this->db->limit(1);
    $query = $this->db->get('merchant');
    return $query->result();
  }
   
  


  function get_package_details_merchant($start_date, $end_date, $status) {
    if ($start_date!=""  && $end_date!="" && $start_date==$end_date) { $this->db->where('date(created_on)', $start_date); }
    else if ($start_date!=""  && $end_date!="" && $start_date!=$end_date) { 
      $this->db->where('date(created_on) >=', $start_date); 
      $this->db->where('date(created_on) <=', $end_date);
    }
        if ($status != '') {
      $this->db->where('status', $status);
    }
    $this->db->where('user_type', 'merchant');

    if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('id',$merchantid);
    }
    
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('merchant');
    // echo $this->db->last_query();  die; 
    return $query->result();

  }

  function get_package_details_agent($status) {
    
    $this->db->where('status', $status);
    $this->db->where('user_type', 'merchant');

    if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('id',$merchantid);
    }
    
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('merchant');
    return $query->result();

  }
    
    function get_package_details_merchant_sub($start_date, $end_date, $status) {

    if ($start_date != '') {

      $this->db->where('date_c >=', $start_date);

      $this->db->where('date_c <=', $end_date);

    }
    if ($status != '') {

      $this->db->where('status', $status);

        }

        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }

    $this->db->where('user_type', 'employee');
    $query = $this->db->get('merchant');

    return $query->result();

    }

    public function get_package_details_sub($id = "") {
    if ($id != "") {
      //$id = intval($id);
      $this->db->where_in('merchant_id', $id);
    }
    $this->db->where('user_type', 'employee');
    $this->db->order_by("id", "desc");
    // $this->db->limit(1);
    $query = $this->db->get('merchant');
    return $query->result();
    }
    
    function get_package_details_merchant1a($start_date, $end_date) {
    if ($start_date != '') {
      $this->db->where('date_c >=', $start_date);
      $this->db->where('date_c <=', $end_date);
    }
    $query = $this->db->get('d_online');
    return $query->result();
    }
    public function get_package_support($id = "") {

    if ($id != "") {
      $id = intval($id);
      $this->db->where('id', $id);
    }
    $this->db->order_by("id", "desc");
    $query = $this->db->get('d_online');
    return $query->result();
    }

    function get_package_details_merchant2a($start_date, $end_date) {
    if ($start_date != '') {
      $this->db->where('date_c >=', $start_date);
      $this->db->where('date_c <=', $end_date);
    }
    $query = $this->db->get('r_call');
    return $query->result();
    }

    public function get_package_request_aa($id = "") {

    if ($id != "") {
      $id = intval($id);
      $this->db->where('id', $id);

    }
    $this->db->order_by("id", "desc");
    $query = $this->db->get('r_call');

    return $query->result();
    }

    function get_package_details_admin($date1, $status) {

    if ($date1 != '') {

      $this->db->where('date_c', $date1);

    }
    if ($status != '') {

      $this->db->where('status', $status);

    }
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }
    $this->db->where('payment_type', 'straight');
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('customer_payment_request');

    return $query->result();

    }


    public function get_full_details_admin($table) {

        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }

    $this->db->where('payment_type', 'straight');
    $this->db->where('status!=', 'Chargeback_Confirm');
    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);

    return $query->result();
    }

    function get_search($start_date, $end_date, $status, $table) {

    if ($start_date != '') {

      $this->db->where('date_c >=', $start_date);

      $this->db->where('date_c <', $end_date);

    }
    if ($status != '') {

      $this->db->where('status', $status);

        }
        
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }


    $query = $this->db->get($table);

    return $query->result();

    }
  function get_package_details_customer_admin($date1,$date2, $status) {
    
        $curentDate=date('Y-m-d'); 
    $merchantid = $this->session->userdata('subadmin_assign_merchant');
    $query = $this->db->query("SELECT * FROM `customer_payment_request` WHERE payment_type='recurring' AND no_of_invoice='1' AND merchant_id IN ($merchantid) AND date_c <= '$date2' AND date_c >= '$date1' GROUP BY invoice_no ORDER BY id DESC ");
    $mem=array();
    $a=1; 
    foreach ($query->result() as $row) {
      $invoice_id=$row->invoice_no;
      $merchant_id=$row->merchant_id;
      $row_id=$row->id;
      if($row->recurring_count  > 0){ $row->recurring_count =$row->recurring_count; }elseif($row->recurring_count < 0){ $row->recurring_count=1; }else{ $row->recurring_count=1; }
        $this->db->where('id', $row_id);
      $table='customer_payment_request'; 
      $this->db->get($table)->row();

      if ($status != '') {
        switch($status){

           case "confirm":
              $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
            $DGetAllpaidRecord=$GetAllpaidRecord->result();
            $AllPaidRequest=count($DGetAllpaidRecord);

            $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
            $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
            $AllUnPaidRequest=count($DGetAllUnpaidRecord);


            $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
            $df=$GetPrevResult->result_array(); 
            $is_prev_paid=count($df); 

           if( $row->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ( $row->recurring_payment=='stop' ||  $row->recurring_payment=='complete')   && $is_prev_paid <='0') { 
               array_push($mem, $row); 
             } else {  $each=array();  }
           break;

           case "pending":
            $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
            $DGetAllpaidRecord=$GetAllpaidRecord->result();
            $AllPaidRequest=count($DGetAllpaidRecord);
      
            $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
            $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
            $AllUnPaidRequest=count($DGetAllUnpaidRecord);
      
      
            $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
            $df=$GetPrevResult->result_array(); 
            $is_prev_paid=count($df);  

             if( $is_prev_paid <='0' &&  $AllUnPaidRequest >='0' && $row->recurring_payment=='start'  && $row->recurring_count > $AllPaidRequest  ){ 
                 array_push($mem, $row); 
             } else {  $each=array();  }
           break; 

           case "late":

            $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
            $DGetAllpaidRecord=$GetAllpaidRecord->result();
            $AllPaidRequest=count($DGetAllpaidRecord);
      
            $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
            $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
            $AllUnPaidRequest=count($DGetAllUnpaidRecord);
      
      
            $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
            $df=$GetPrevResult->result_array(); 
            $is_prev_paid=count($df);  

           if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'  ){
            array_push($mem, $row); 
            } else {  $each=array();  }
           break; 
           default :
             $each=array(); array_push($mem, $row); 
           break; 
        }
       }
       else{
         array_push($mem, $row); 
       }
       }
    return $mem;  

  }
  
  public function _get_datatables_query() {
    //add custom filter here
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status = $this->input->post('status');
    $this->db->select("pos.*, refund.add_date as refund_date,refund.transaction_id as refund_transaction_id");
    $this->db->from($this->table);
    $this->db->join('refund', 'pos.invoice_no = refund.invoice_no', 'left');
    if (!empty($end_date) && !empty($start_date) && $start_date==$end_date) {
      $this->db->where('pos.date_c', $end_date);
    }
    else if (!empty($start_date)) {
      $this->db->where('pos.date_c >=', $start_date);
    }
    else if (!empty($end_date)) {
      $this->db->where('pos.date_c <=', $end_date);
    }
    if (!empty($status)) {
      $this->db->like('pos.status', $status);
    }
    if($this->session->userdata('subadmin_assign_merchant'))
    {
      $merchantid = $this->session->userdata('subadmin_assign_merchant');
      $merchant_id=explode(",",$merchantid); 
      $this->db->where_in('pos.merchant_id', $merchant_id);
      // $this->db->where_in('refund.merchant_id', $merchant_id);
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
      
      $this->db->order_by("pos.".$this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
    else
    {
      $this->db->order_by("pos.date_c","DESC");
    }
  }
  public function get_datatables() {
      
    $this->_get_datatables_query(); 
    if ($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }

    $query = $this->db->get(); 
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
    
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  public function check_pos_optimized_inv($table,$transaction_id)
  {   
    $query = $this->db->query("SELECT * FROM $table WHERE transaction_id='$transaction_id'  ");
    return $query->result_array();
  }

  
  
  public function get_full_refund_data($table, $merchant_id) {
    $date = date('Y-m-d', strtotime('-30 days'));
    $this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
    $this->db->from("refund r");
    $this->db->where('r.date_c >=', $date);
    if($merchant_id!=""){ $this->db->where_in('r.merchant_id', $merchant_id); }
    $this->db->join($table . ' mt', 'mt.invoice_no = r.invoice_no');
    $query = $this->db->get();
    return $query->result();

  }

  function get_search_merchant_pos($start_date, $end_date, $status, $merchant_id, $table) {

    if ($start_date != '' && $end_date!="") {
      $this->db->where('date_c >=', $start_date);
      $this->db->where('date_c <=', $end_date);
    }
    else if ($start_date==$end_date)
    {
      $this->db->where('date_c', $end_date);
    }
    else {
      $date = date('Y-m-d', strtotime('-30 days'));
      $this->db->where('date_c >=', $date);
      $this->db->where('date_c <=', date('Y-m-d'));
    }
    if ($status != '') {
      $this->db->where('status', $status);
    }
    if($merchant_id!=""){ $this->db->where_in('merchant_id', $merchant_id); }
    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);
    return $query->result();
  }

  public function get_full_details_pos($table, $merchant_id) {
    $date = date('Y-m-d', strtotime('-30 days'));

    if($merchant_id!="")
    {
      $this->db->where_in('merchant_id', $merchant_id);
    }
    //$this->db->where('status !=', 'Chargeback_Confirm' );
    $this->db->where('date_c >=', $date);
    $this->db->order_by('id', "desc");
    $query = $this->db->get($table);

    return $query->result();
  }
    public function get_search_merchant_pos_new_admin($start_date, $end_date, $status, $table) {
    if ($start_date != '') {
      $this->db->where('date_c >=', $start_date);
      $this->db->where('date_c <=', $end_date);
    }
    if ($status != '') {
      $this->db->where('status', $status);
        }
        
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }

    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);
    return $query->result();
    }

  
    public function get_full_details_pos_new_admin($table) {
    $date = date('Y-m-d', strtotime('-60 days'));   
    //$date ='2018-01-01';
        //$this->db->where('status !=', 'Chargeback_Confirm' );
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }

    $this->db->where('date_c >=', $date);
    $this->db->order_by("id", "desc");
    $this->db->limit(10);
    $query = $this->db->get($table);
    
    return $query->result();
  }
  
  
    
    public function get_full_details_admin_report_search($table, $date1, $date2, $employee, $status) {
    $date = date('Y-m-d', strtotime('-30 days'));
    $this->db->where('payment_type', 'straight');
    if( $date1!=""  && $date2!=""  &&  $date1==$date2)
    {
      $this->db->where('date_c', $date1);
    }
    else if($date1!=""  && $date2!="" &&  $date1!=$date2) {
      $this->db->where('date_c >=', $date1);
      $this->db->where('date_c <=', $date2);
    } else {
      $this->db->where('date_c >=', $date);
    }

    if ($status !='') {
      $this->db->where('status', $status);
    }

    if ($employee != '') {
      $this->db->where_in('merchant_id ', $employee);
    }
    
        else if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
        }


    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);

    return $query->result();
    }
    
  public function  get_refund_transaction($merchant_id,$invoice_no)
  {
    
     $this->db->where('invoice_no',$invoice_no); 
     $this->db->where('merchant_id',$merchant_id); 
     $query = $this->db->get('refund');
     return $query->row(); 
  }
    
    public function get_full_details_admin_orderby($table) {
    $this->db->select("mt.*, refund.add_date as refund_date,refund.transaction_id as refund_transaction_id");
    $this->db->from($table . ' mt');
    $this->db->join('refund', 'mt.invoice_no = refund.invoice_no', 'left');
        $this->db->where('payment_type', 'straight');
        if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('mt.merchant_id',$merchantid);
        }

    $this->db->order_by('order_type desc');
    $this->db->order_by("mt.payment_date", "desc");
    $this->db->limit(10);
    $query = $this->db->get();
    return $query->result();
  }
  

  public function get_full_details_admin_report_search1($table, $date1, $date2, $status) {
    $date = date('Y-m-d', strtotime('-30 days'));
    $this->db->where('payment_type', 'recurring');
    if ($date1!="" && $date2!="" && $date1==$date2) {
      $this->db->where('date_c', $date1);
    }
    else if ($date1!="" && $date2!="" && $date1!=$date2) {
      $this->db->where('date_c >=', $date1);
      $this->db->where('date_c <=', $date2);
    } else {
      $this->db->where('date_c >=', $date);
    }
    if ($status != '') {
      $this->db->where('status =', $status);
    }
    if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('merchant_id',$merchantid);
    }
    

    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);

    return $query->result();
  }
  public function get_full_details_payment_admin_co($table) {
        $date = date('Y-m-d', strtotime('-30 days'));
    
    if($this->session->userdata('subadmin_assign_merchant'))
    {   
      $merchantid=$this->session->userdata('subadmin_assign_merchant');
      //$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            //$this->db->where_in('merchant_id',$merchantid);
    }else{ $merchantid='';}

    if($merchantid!="")
    {
      $query = $this->db->query("SELECT * FROM $table WHERE payment_type='recurring' AND merchant_id IN ($merchantid) AND date_c >= '$date' ORDER BY id DESC ");

    }
    else
    {
      $query = $this->db->query("SELECT * FROM $table WHERE payment_type='recurring'  AND date_c >= '$date' ORDER BY id DESC ");

    }
    $mem=array(); 
    foreach ($query->result() as $row) {
      $invoice_No=$row->invoice_no;
      $row_id=$row->id;
      $this->db->where('id', $row_id);
        $each = $this->db->get($table)->row();
        array_push($mem, $each); 
    }
    return $mem;
  }
  public function get_full_details_payment_admin($table) {
        $date = date('Y-m-d', strtotime('-30 days'));
    
    if($this->session->userdata('subadmin_assign_merchant'))
    {   
      $merchantid=$this->session->userdata('subadmin_assign_merchant');
      //$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            //$this->db->where_in('merchant_id',$merchantid);
    }else{ $merchantid='';}

    if($merchantid!="")
    {
      $query = $this->db->query("SELECT * FROM $table WHERE payment_type='recurring' AND no_of_invoice='1' AND merchant_id IN ($merchantid) AND date_c >= '$date' GROUP BY invoice_no ORDER BY id DESC ");

    }
    else
    {
      $query = $this->db->query("SELECT * FROM $table WHERE payment_type='recurring' AND no_of_invoice='1'  AND date_c >= '$date' GROUP BY invoice_no ORDER BY id DESC ");

    }
    $mem=array(); 
    foreach ($query->result() as $row) {
      $invoice_No=$row->invoice_no;
      $row_id=$row->id;
      $this->db->where('id', $row_id);
        $each = $this->db->get($table)->row();
        array_push($mem, $each); 
    }
    return $mem;
  }

  function get_recurring_details_payment_admin($date1, $status) {
    $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.merchant_id,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');
    $this->db->from('recurring_payment r');
    $this->db->join('customer_payment_request c', 'r.p_id = c.id');
    if ($date1 != '') {
      $this->db->where('r.date_c', $date1);
    }
    if ($status != '') {
      $this->db->where('r.status', $status);  
    }
    if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('r.merchant_id',$merchantid);
    }

    $result = $this->db->get();
    return $result->result();
  }


  public function get_recurring_details_payment_admin1() {

    $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.merchant_id,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');
    $this->db->from('recurring_payment r');
    $this->db->join('customer_payment_request c', 'r.p_id = c.id');
    if($this->session->userdata('subadmin_assign_merchant'))
    {   $merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
            $this->db->where_in('r.merchant_id',$merchantid);
    }
    $result = $this->db->get();
    return $result->result();

  }
  public function get_full_details($table) {

    $this->db->order_by("id", "desc");
    $query = $this->db->get($table);

    return $query->result();
  }

  //  New Function For  Download data of Admin Panel 

  public function data_get_where_dow_bymerchant($table, $end_date, $start_date,$merchant_id) {
    $this->db->select('amount,tax,tip_amount,type,date_c,reference');
    $this->db->from($table);
    $this->db->where('date_c >=', $start_date);
    $this->db->where('date_c <=', $end_date);
    if($merchant_id!=""){ $this->db->where_in('merchant_id',$merchant_id); }
    $this->db->where('status', 'confirm');
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    //return $query->result_array();
    return $query->result();
  }
  public function get_refund_data_admin($end_date, $start_date, $merchant_id) {
    $this->db->select('mt.amount,mt.tax,mt.tip_amount,mt.card_type,mt.type,mt.date_c,mt.reference,mt.name,mt.status,r.add_date as refund_dt,r.amount as refund_amount');
    $this->db->from("refund r");
    $this->db->where('r.date_c >=', $start_date);
    $this->db->where('r.date_c <=', $end_date);
    $this->db->where('mt.status!=', 'pending');
    $this->db->where('mt.status!=', 'block');
    $this->db->where('mt.status!=', 'declined');
    if($merchant_id!="" && $merchant_id!='all') { $this->db->where_in('r.merchant_id', $merchant_id); } 
    $this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
    $query1 = $this->db->get_compiled_select();

    $this->db->select('mt.amount,mt.tax,"0" as tip_amount, mt.card_type,mt.type,mt.date_c,mt.reference,mt.name,mt.status,r.add_date as refund_dt,r.amount as refund_amount');
    $this->db->from("refund r");
    $this->db->where('r.date_c >=', $start_date);
    $this->db->where('r.date_c <=', $end_date);
    $this->db->where('mt.status!=', 'pending');
    $this->db->where('mt.status!=', 'block');
    $this->db->where('mt.status!=', 'declined');
    if($merchant_id!="" && $merchant_id!='all') { $this->db->where_in('r.merchant_id', $merchant_id); } 
    $this->db->join('customer_payment_request mt', 'mt.invoice_no = r.invoice_no');
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1 . " UNION ALL " . $query2);
    return $query->result();
  }


  
  

}
