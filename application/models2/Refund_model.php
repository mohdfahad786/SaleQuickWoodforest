<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refund_model extends CI_Model
{
     function __construct()
     {
         
          parent::__construct();
     }
     
     public function s_fee($table, $condition){

	$this->db->select('*');
      $this->db->from($table);

	  $this->db->where('id',$condition);
	  //	$this->db->order_by("id", "desc");
	    $query = $this->db->get();
		return $query->result_array();
}


   public function data_get_where_1($table, $condition) {
       
        $this->db->order_by("id", "desc");
         $q = $this->db->get_where($table, $condition);
        return $q->result_array();
    }

     public function graph($table,$condition)
	{
		$this->db->get_where($table, $condition);
	}

     public function data_get_where_2($table) {
     	 $this->db->order_by("id", "desc");
        $q = $this->db->get_where($table);
        return $q->result_array();
    }

     public function data_get_where($table, $condition) {
     	 $this->db->order_by("id", "desc");
        $q = $this->db->get_where($table, $condition);
        return $q->result();
    }
    
       public  function data_get_where_dow($table,$end_date,$start_date)
	{
	 
	  $this->db->select('amount,tax,type,date_c,reference');
      $this->db->from($table);
	  $this->db->where('date_c >=',$start_date);
	  $this->db->where('date_c <=',$end_date);
	  $this->db->where('status','confirm');
	 // $this->db->where('merchant_id',$merchant_id);
	 	$this->db->order_by("id", "desc");
	    $query = $this->db->get();
	//	return $query->result_array();
		return $query->result();
	
	}
	
	public  function data_get_where_down($table,$end_date,$start_date,$merchant_id)
	{
	 
	  $this->db->select('amount,tax,type,date_c,reference');
      $this->db->from($table);
	  $this->db->where('date_c >=',$start_date);
	  $this->db->where('date_c <=',$end_date);
	  $this->db->where('status','confirm');
	  $this->db->where('merchant_id',$merchant_id);
	 	$this->db->order_by("id", "desc");
	    $query = $this->db->get();
	//	return $query->result_array();
		return $query->result();
	
	}

     public function data_get_where_g($table, $condition) {
     	 $this->db->order_by("id", "desc");
     	 $this->db->select('amount,tax,type,date_c,reference');	
        $q = $this->db->get_where($table, $condition);
        return $q->result_array();
    }



   public  function data_get_where_gg($start_date,$end_date,$status,$merchant_id,$employ,$table)
	{
	 
	  $this->db->select('amount,tax,type,date_c,reference');
      $this->db->from($table);

	  if($start_date!=''  ){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <=',$end_date);
	  
	}
	else
	{

	  $date = date('Y-m-d', strtotime('-30 days'));
	   $this->db->where('date_c >', $date  );
		
	}
	  if($status!=''){
	 
	  $this->db->where('status',$status);
	  
	}

	if($employ!='all' or $employ!='merchant' ){
	  
	  $this->db->where('sub_merchant_id',$employ);
	  
	}
	  $this->db->where('merchant_id',$merchant_id);
	  //	$this->db->order_by("id", "desc");
	    $query = $this->db->get();
		return $query->result_array();
	
	}

	public  function data_get_where_ggg($start_date,$end_date,$status,$employ,$table)
	{
	 
	  $this->db->select('amount,tax,type,date_c,reference');
      $this->db->from($table);

	  if($start_date!=''  ){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <=',$end_date);
	  
	}
	else
	{

	  $date = date('Y-m-d', strtotime('-30 days'));
	   $this->db->where('date_c >', $date  );
		
	}
	  if($status!=''){
	 
	  $this->db->where('status',$status);
	  
	}

	if($employ!='all'  ){
	  
	  $this->db->where('merchant_id',$employ);
	  
	}
	//  $this->db->where('merchant_id',$merchant_id);
	  //	$this->db->order_by("id", "desc");
	    $query = $this->db->get();
		return $query->result_array();
	
	}
	
		public  function data_get_where_ggg_1($start_date,$end_date,$status,$employ,$table)
	{
	 
	  $this->db->select('amount,tax,type,date_c,reference');
      $this->db->from($table);

	  if($start_date!=''  ){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <=',$end_date);
	  
	}
	else
	{

	  $date = date('Y-m-d', strtotime('-30 days'));
	   $this->db->where('date_c >', $date  );
		
	}
	  if($status!=''){
	 
	  $this->db->where('status',$status);
	  
	}

	if($employ!='all'  ){
	  
	  $this->db->where('merchant_id',$employ);
	  
	}
	//  $this->db->where('merchant_id',$merchant_id);
	  //	$this->db->order_by("id", "desc");
	    $query = $this->db->get();
		return $query->result();
	
	}


     public function data_get_where_serch($table, $condition) {
     	 $this->db->order_by("id", "asc");
        $q = $this->db->get_where($table, $condition);
        return $q->result();
    }

     public function data_get_where_3($table) {
     	 $this->db->order_by("id", "desc");
        $q = $this->db->get_where($table);
        return $q->result();
    }

    function get_payment_details_3($id = "")
    {
    
        if($id != "")
        {
            $id = intval($id);
            $this->db->where('id',$id);
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get('merchant');
        return $query->result();
    }
    

    public function update_data($table, $data, $condition) {
        $this->db->where($condition);
        $this->db->update($table, $data);
        return true;
    }
     
      public function insert_data($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

 public function delete_item($table, $condition) {
        $this->db->where($condition);
        $this->db->delete($table);
        return true;
    }

     public function get_data($table) {
        $q = $this->db->get($table);
        return $q->result_array();
    }

     function get_search($start_date,$end_date,$status,$table)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	
	$query = $this->db->get($table);
		
		return $query->result();
	
	
	}

	  function get_search_merchant($start_date,$end_date,$status,$merchant_id,$table)
	{
	 
	  if($start_date!=''  ){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}

	else

	{

		$date = date('Y-m-d', strtotime('-30 days'));

	   $this->db->where('date_c >=', $date  );
	
	
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	  $this->db->where('merchant_id',$merchant_id);
	  //	$this->db->order_by("id", "desc");
	
	$query = $this->db->get($table);
		
		return $query->result();
	
	
	}


function get_search_merchant_type($start_date,$end_date,$status,$merchant_id,$table,$type)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	  $this->db->where('merchant_id',$merchant_id);
	$this->db->where('payment_type', $type );
	$query = $this->db->get($table);
		
		return $query->result();
	
	
	}

	function get_search_merchant_pos($start_date,$end_date,$merchant_id,$table)
	{
	 
	 
	$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount');
		$this->db->from("refund r");
		 if($start_date!=''){
	  
	  $this->db->where('r.date_c >=',$start_date);

	  $this->db->where('r.date_c <=',$end_date);
	  
	}
	    $this->db->where('mt.status' , 'Chargeback_Confirm');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
		$this->db->order_by("mt.id", "desc");
		$query = $this->db->get();
// 	 $this->db->where('status' , 'Chargeback_Confirm');
	 
// 	  $this->db->where('merchant_id',$merchant_id);
// 	$this->db->order_by("id", "desc");
// 	$query = $this->db->get($table);
		
		return $query->result();
	
	
	}


    function get_package_details_new($date1,$status)
	{
	 
	  if($date1!=''){
	  
	  $this->db->where('date_c',$date1);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	$query = $this->db->get('payment_request');
		
		return $query->result();
	
	
	}

	function delete_package($id)
	{
		$this->db->where('id', $id);
		
		return $this->db->delete('merchant') ? True : False;
	}

	function active_order($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('merchant', array('status' => 'active')) ? True : False;
	}
	function stop_recurring($id)
	{
		$this->db->where('id', $id);
		$this->db->update('customer_payment_request', array('recurring_payment' => 'stop')) ;
	}
	function start_recurring($id)
	{
		$this->db->where('id', $id);
		$this->db->update('customer_payment_request', array('recurring_payment' => 'start'));
	}

	function stop_tex($id)
	{
		$this->db->where('id', $id);
		$this->db->update('tax', array('status' => 'block')) ;
	}
	function start_tex($id)
	{
		$this->db->where('id', $id);
		$this->db->update('tax', array('status' => 'active'));
	}


	 function get_package_details_merchant($start_date,$end_date,$status)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	$this->db->where('user_type','merchant');
	$query = $this->db->get('merchant');
		
		return $query->result();
	
	
	}


	function get_package_details_merchant1($start_date,$end_date,$status)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	
	$query = $this->db->get('d_online');
		
		return $query->result();
	
	
	}
	
		function get_package_details_merchant1a($start_date,$end_date)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	  
	
	$query = $this->db->get('d_online');
		
		return $query->result();
	
	
	}

	function get_package_details_merchant2($start_date,$end_date,$status)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	   if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	
 	$merchant_id = $this->session->userdata('merchant_id');
	
 	if($merchant_id!=''){
	  
 	  $this->db->where('merchant_id',$merchant_id);
	  
 	}
	
	$query = $this->db->get('r_call');
		
		return $query->result();
	
	
	}
	
		function get_package_details_merchant2a($start_date,$end_date)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);

	  $this->db->where('date_c <',$end_date);
	  
	}
	  
 
	
	$query = $this->db->get('r_call');
		
		return $query->result();
	
	
	}


function get_subadmin_details($id = "")
	{ 
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('sub_admin');
		return $query->result();
	}
	

	function get_user_details($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('user');
		return $query->result();
	}

	function get_employee_details($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant');
		return $query->result();
	}

		

	function get_package_details_admin($date1,$status)
	{
	 
	  if($date1!=''){
	  
	  $this->db->where('date_c',$date1);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
  
	$this->db->where('payment_type', 'straight' );
	  $this->db->order_by('id','desc');
	$query = $this->db->get('customer_payment_request');
		
		return $query->result();
	
	
	}

	function get_package_details_customer_r($start_date,$end_date,$status,$merchant_id)
	{
	 
	  if($start_date!=''){
	  
	  $this->db->where('date_c >=',$start_date);
	   $this->db->where('date_c <',$end_date);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	$this->db->where('merchant_id',$merchant_id);
	$this->db->where('payment_type', 'recurring' );
	$query = $this->db->get('customer_payment_request');
		
		return $query->result();
	
	
	}

	function get_package_details_customer_rr($date1,$status,$merchant_id)
	{
	 
	  if($date1!=''){
	  
	  $this->db->where('date_c',$date1);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}


	$this->db->where('merchant_id',$merchant_id);
	$this->db->where('status', 'confirm' );
	$query = $this->db->get('customer_payment_request');
		
		return $query->result();
	
	
	}

	function get_package_details_customer_admin($date1,$status)
	{
	 
	  if($date1!=''){
	  
	  $this->db->where('date_c',$date1);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('status',$status);
	  
	}
	
	$merchant_id = $this->session->userdata('merchant_id');
	
		if($merchant_id!=''){
		  
		  $this->db->where('merchant_id',$merchant_id);
		  
		}
	
	$this->db->where('payment_type', 'recurring' );
	$query = $this->db->get('customer_payment_request');
		
		return $query->result();
	
	
	}
	
	
	
	public function get_package_details($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
			 
		}
	    $this->db->where('user_type', 'merchant');
		$this->db->order_by("id", "desc");
		// $this->db->limit(1);
		$query = $this->db->get('merchant');
		
		return $query->result();
	}

	public function get_package_support($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
			 
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('d_online');
		
		return $query->result();
	}

	public function get_package_request($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
			 
		}
		
 		$merchant_id = $this->session->userdata('merchant_id');
	
 		if($merchant_id!=''){
		  
 		  $this->db->where('merchant_id',$merchant_id);
		  
 		}
		
		$this->db->order_by("id", "desc");
		$query = $this->db->get('r_call');
		
		return $query->result();
	}
	
		public function get_package_request_aa($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
			 
		}
		
// 		$merchant_id = $this->session->userdata('merchant_id');
	
// 		if($merchant_id!=''){
		  
// 		  $this->db->where('merchant_id',$merchant_id);
		  
// 		}
		
		$this->db->order_by("id", "desc");
		$query = $this->db->get('r_call');
		
		return $query->result();
	}

	public function get_full_details($table)
	{
	
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}
	public function get_full_details_employee($table,$merchant_id)
	{
	   $this->db->where('merchant_id',$merchant_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}


public function get_full_details_admin_report($table)
	{
	   $date = date('Y-m-d', strtotime('-30 days'));
	   
	     $this->db->where('date_c >=', $date  );
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}

	public function get_full_details_admin_report_search($table,$date1,$date2,$employee)
	{
	   $date = date('Y-m-d', strtotime('-30 days'));
	   $this->db->where('payment_type', 'straight' );
	   if($date1 !=''){
	     $this->db->where('date_c >=', $date1  );
	     $this->db->where('date_c <=', $date2  );
	   }
	   else
	   {
	       $this->db->where('date_c >=', $date  ); 
	   }

	  
	     	 $this->db->where('status =', 'Chargeback_Confirm');
	    
	      if($employee!=''){
	     	 $this->db->where('merchant_id =', $employee  );
	     }
	     
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}


public function get_full_details_admin_report_search1($table,$date1,$date2,$status)
	{
	   $date = date('Y-m-d', strtotime('-30 days'));
	   $this->db->where('payment_type', 'recurring' );
	   if($date1 !=''){
	     $this->db->where('date_c >=', $date1  );
	     $this->db->where('date_c <=', $date2  );
	   }
	   else
	   {
	       $this->db->where('date_c >=', $date  ); 
	   }

	     if($status!=''){
	     	 $this->db->where('status =', $status  );
	     }
	     
	     
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}




	public function get_full_details_admin($table)
	{
	   
	    $this->db->where('payment_type', 'straight' );
	    $this->db->where('status!=','Chargeback_Confirm');
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}
	public function get_full_details_admin_a($table,$merchant_id)
	{
	   
	    $this->db->where('payment_type', 'straight' );
	     $this->db->where('status', 'Chargeback_Confirm' );
	    $this->db->where('merchant_id', $merchant_id );
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}

	public function get_full_details_payment($table,$merchant_id)
	{
		$date = date('Y-m-d', strtotime('-30 days'));

	    $this->db->where('merchant_id' , $merchant_id);
	    $this->db->where('payment_type', 'straight' );
	   $this->db->where('date_c >=', $date  );
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}

	public function get_full_details_pos($table,$merchant_id)
	{
		$date = date('Y-m-d', strtotime('-100 days'));

	    
		//$query = $this->db->get($table);
		
		$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount');
		$this->db->from("refund r");
		$this->db->where('r.date_c >=', $date);
	    $this->db->where('mt.status' , 'Chargeback_Confirm');
		$this->db->where('r.merchant_id', $merchant_id);
		$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
		$this->db->order_by("r.id", "desc");
		//$this->db->order_by("mt.id", "desc");
		$query = $this->db->get();
		
		return $query->result();
	}

	public function get_full_details_payment_admin($table)
	{
	   
	    $this->db->where('payment_type', 'recurring' );
		$merchant_id = $this->session->userdata('merchant_id');
	
		if($merchant_id!=''){
		  
		  $this->db->where('merchant_id',$merchant_id);
		  
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}
	

	
	public function get_full_details_payment_r($table,$merchant_id)
	{
		$date = date('Y-m-d', strtotime('-30 days'));
	    $this->db->where('merchant_id' , $merchant_id);
	    $this->db->where('payment_type', 'recurring' );
	     $this->db->where('date_c >=', $date  );
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}

	public function get_full_details_payment_rr($table,$merchant_id)
	{
		$date = date('Y-m-d', strtotime('-30 days'));
	    $this->db->where('merchant_id' , $merchant_id);
	    $this->db->where('status', 'confirm' );
	     $this->db->where('date_c >=', $date  );
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}

	public function get_full_details_payment_rr_p($table,$merchant_id)
	{
		$date = date('Y-m-d', strtotime('-30 days'));
	    $this->db->where('merchant_id' , $merchant_id);
	    $this->db->where('status', 'pending' );
	     $this->db->where('date_c >=', $date  );
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}

	public function get_full_details_recurring($table)
	{
	    $this->db->where('payment_type' , 'recurring');
	    $this->db->where('recurring_count_remain >' , '0');
		$this->db->order_by("id", "desc");
		$query = $this->db->get($table);
		
		return $query->result();
	}


	public function get_recurring_details_payment($merchant_id,$id)
	{
	   
	  
	 $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date,r.payment_date');	  
    $this->db->from('recurring_payment r');
   $this->db->join('customer_payment_request c', 'r.p_id = c.id');
    $this->db->where('r.merchant_id' , $merchant_id);

 $this->db->where('r.p_id' , $id);

 
	    $result = $this->db->get();
		return $result->result();
		
	}

	public function get_recurring_details_payment_rr($merchant_id,$id)
	{
	   
	  
	 $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.invoice_no,r.payment_id,r.add_date,r.payment_date');	  
    $this->db->from('recurring_payment r');
   $this->db->join('customer_payment_request c', 'r.p_id = c.id');
   $this->db->where('r.merchant_id' , $merchant_id);

 $this->db->where('r.id' , $id);

 
	    $result = $this->db->get();
		return $result->result();
		
	}

	public function get_recurring_details_payment_rrr($merchant_id)
	{
	   
	  
	 $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.invoice_no,r.payment_id,r.add_date,r.payment_date');	  
    $this->db->from('recurring_payment r');
   $this->db->join('customer_payment_request c', 'r.p_id = c.id');
   $this->db->where('r.merchant_id' , $merchant_id);

 
	    $result = $this->db->get();
		return $result->result();
		
	}

	public function get_recurring_details_payment_admin1()
	{
	   

	  
	 $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.merchant_id,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');	  
    $this->db->from('recurring_payment r');
   $this->db->join('customer_payment_request c', 'r.p_id = c.id');
   
	    $result = $this->db->get();
		return $result->result();
		
	}
        
        public function get_full_reports($filters) 
	{
	   
           $condtions="";
          if(isset($filters['status']) and $filters['status']!=''){
              $condtions.=" and fs.status='".$filters['status']."'"; 
          }
          
          if(isset($filters['employee']) and $filters['employee']!=''){
              $condtions.=" and m.id=".$filters['employee']; 
          }
	  
	$query = $this->db->query("SELECT m.id,fs.amount,fs.hold_amount,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,fs.status,(IFNULL((select sum(fee) from  recurring_payment where merchant_id=m.id and date_c='".$filters['date']."'),0) + IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c='".$filters['date']."'),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c='".$filters['date']."'),0)) as feesamoun, '".$filters['date']."' as date_c, (IFNULL((select sum(amount) from  recurring_payment where merchant_id=m.id and date_c='".$filters['date']."'),0) + IFNULL((select sum(amount) from  pos where merchant_id=m.id and date_c='".$filters['date']."'),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and date_c='".$filters['date']."'),0)) as totalAmount from merchant m left join funding_status fs on (fs.merchant_id=m.id and fs.date='".$filters['date']."')  where  m.user_type='merchant' and m.status='Active' $condtions");
   
	   
		return $query->result_array();
		
	}

	function getfundDetails($filters){
		$query = $this->db->query("(select amount,invoice_no,add_date,email_id from  recurring_payment where merchant_id=".$filters['id']." and date_c='".$filters['date']."')union (select amount,invoice_no,add_date,email_id  from  pos where merchant_id=".$filters['id']." and date_c='".$filters['date']."')
		union (select amount,invoice_no,add_date,email_id  from  customer_payment_request where merchant_id=".$filters['id']." and date_c='".$filters['date']."')"
		);
   
	   
		return $query->result_array();
	}

	function get_holdamount($filters){
		$query = $this->db->query("select * from funding_status where merchant_id=".$filters['mid']." and hold_amount>0 and date<>'".$filters['cdate']."'");
			   
		return $query->result_array();
	}

	function getLastpayment($filters){
		//print_r($filters);
		$fromdate=date("Y",strtotime($filters['date']))."-".date("m",strtotime($filters['date']))."-01";
		$query = $this->db->query("select count(*) as cnt from  funding_status where amount>0 and  merchant_id=".$filters['merchant_id']." and  (date(date)>='".$fromdate."' and  date(date)<'".$filters['date']."')");	   
		return $query->result_array();
	}

	function get_recurring_details_payment_search($date1,$status,$merchant_id)
	{
	 
	  $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');	  
    $this->db->from('recurring_payment r');
    $this->db->join('customer_payment_request c', 'r.p_id = c.id');
    $this->db->where('r.merchant_id' , $merchant_id);

	  if($date1!=''){
	  
	  $this->db->where('r.date_c',$date1);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('r.status',$status);
	  
	}
	
     $result = $this->db->get();
		return $result->result();
	
	
	}

	function get_recurring_details_payment_admin($date1,$status)
	{
	 
	  $this->db->select('r.id as rid,c.id as cid ,c.title,c.payment_type,c.merchant_id,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');	  
    $this->db->from('recurring_payment r');
    $this->db->join('customer_payment_request c', 'r.p_id = c.id');
    
	  if($date1!=''){
	  
	  $this->db->where('r.date_c',$date1);
	  
	}
	  if($status!=''){
	  
	  $this->db->where('r.status',$status);
	  
	}
	
     $result = $this->db->get();
		return $result->result();
	
	
	}

	public function search_record($searchby) {
       $this->db->select('*'); 

         $this->db->from('customer_payment_request');
         $this->db->where('id',$searchby); 
      
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }
    
    public function search_record_pos($searchby) {
       $this->db->select('*'); 

         $this->db->from('pos');
         $this->db->where('id',$searchby); 
      
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    	public function search_pos($searchby) {
       $this->db->select('*'); 

         $this->db->from('pos');
         $this->db->where('id',$searchby); 
      
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function search_item($searchby) {
       $this->db->select('*'); 

         $this->db->from('order_item');
         $this->db->where('p_id',$searchby); 
      
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function search_record_un($searchby,$table) {
       $this->db->select('*'); 

         $this->db->from($table);
         $this->db->where('id',$searchby); 
      
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function delete_by_id($id,$table_name)
	{
		$this->db->where('id', $id);
		$this->db->delete($table_name);
	}
	public function block_by_id($id,$table_name)
	{
		$this->db->where('id', $id);
	
	 $this->db->update($table_name, array('status' => 'block'));
	}
	public function active_by_id($id,$table_name)
	{
		$this->db->where('id', $id);
		 $this->db->update($table_name, array('status' => 'active'));
	}
	

}

