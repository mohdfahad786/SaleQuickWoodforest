<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Home_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function data_get_where($table, $condition) {
        $q = $this->db->get_where($table, $condition);
        return $q->result_array();
    }

    public function get_payment_details_1($id) {
        $this->db->where('payment_id',$id);
        $query = $this->db->get('customer_payment_request');
        return $query->result();
    }
    public function get_payment_details_1_sand($id) {
        $this->db->where('payment_id',$id);
        $query = $this->db->get('sandbox_payment_request');
        return $query->result();
    }
    public function get_payment_details_1_pos($id) {
        $this->db->where('invoice_no',$id);
        $query = $this->db->get('pos');
        // echo $this->db->last_query();die;
        return $query->result();
    }

    public function insert_data($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
     public function update_data($table, $data, $condition) {
        $this->db->where($condition);
        $this->db->update($table, $data);
        return true;
    }


    public function get_data($table) {
        $q = $this->db->get($table);
        return $q->result_array();
    }

    public function delete_item($table, $condition) {
        $this->db->where($condition);
        $this->db->delete($table);
        return true;
    }

     function update_date_single($id, $userinfo)
    {
        $this->db->where('auth_key', $id);
        return $this->db->update('merchant', $userinfo) ? True : False;
    }

    function update_payment_single($id, $userinfo)
    {
        $this->db->where('id', $id);
        return $this->db->update('customer_payment_request', $userinfo) ? True : False;
    }

     function update_payment_single_recurring($id, $userinfo)
    {
        $this->db->where('id', $id);
        return $this->db->update('recurring_payment', $userinfo) ? True : False;
    }
     function update_payment_graph($id, $userinfo)
    {
        $this->db->where('payment_id', $id);
        return $this->db->update('graph', $userinfo) ? True : False;
    }

function get_payment_details($id = "")
    {
    
        if($id != "")
        {
            $id = intval($id);
            $this->db->where('payment_id',$id);
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get('customer_payment_request');
        return $query->result();
    }


    function get_payment_details_recurring($id)
    {
    
        


         $this->db->select('r.id as rid,c.id as cid ,c.title,c.detail,c.payment_type,c.name,c.email_id,c.mobile_no,c.amount,r.status,r.add_date');     
    $this->db->from('recurring_payment r');
   $this->db->join('customer_payment_request c', 'r.p_id = c.id');
    $this->db->where('r.payment_id' , $id);

    
        $result = $this->db->get();
        return $result->result();
    }

   

    public function get_state() {
        $q = $this->db->get_where("states", array("country_id" => 101));
        return $q->result_array();
    }

public function getCity($id)
	{
		$q = $this->db->get_where("cities", array("status"=>1,"id"=>$id));
		return $q->result_array();		
	}
	
public function getCity1($id)
	{
		//$q = $this->db->get_where("cities", array("status"=>1,"state_id"=>$id));
		//return $q->result_array();

                   $this->db->where('state_id', $id);
             
		
		$query = $this->db->get('cities');
		return $query->result();

		
	}

	 public function get_state1($id) {
        $q = $this->db->get_where("states", array("country_id" => 101,"id"=>$id));
        return $q->result_array();
    }

    
	
	public function getCustomer_list()
	{
		
		 $this->db->order_by("id", "desc");
		 $this->db->where('RequestStatus', 0); 
		$q = $this->db->get('pointsredeemedreq');
		
		
		return $q->result_array();
		
	}
	
	public function getCustomer_redem()
	{
		
		 $this->db->order_by("id", "desc"); 
		 $this->db->where('RequestStatus', 1);
		$q = $this->db->get('pointsredeemedreq');
		
		
		return $q->result_array();
		
	}

   

   

    public function get_total_record($table) {
        $q = $this->db->get($table);
        return $q->num_rows();
    }

    public function get_pagination_table($table, $limit, $pagedata, $condition) {
        $this->db->select();
        $this->db->from($table);
        $this->db->where($condition);
        $this->db->limit($pagedata, $limit);
        $this->db->order_by('id', 'DESC');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function get_pagination_table_con($table, $limit, $pagedata) {
        $this->db->select();
        $this->db->from($table);
        $this->db->limit($pagedata, $limit);
        $this->db->order_by('id', 'DESC');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function getName($table, $condition, $column) {
        $this->db->select($column);
        $this->db->from($table);
        $this->db->where($condition);
        $q = $this->db->get();
        return $q->result_array();
    }

    public function get_markup_value() {
        $q = $this->db->get_where("mark_up", array("type" => "web"));
        return $q->result_array();
    }
    
    public function check_vaue_set($id){
        $sqlData = "SELECT * FROM `vandors` v  JOIN `vandor_holiday` ON `vandor_holiday`.`vandors_id` = `v`.`id` JOIN `vandor_menu` ON `vandor_menu`.`vandor_id` = `v`.`id` WHERE `v`.`id` =".$id;
        $q = $this->db->query($sqlData);
        return $q->result_array();
    }

    public function get_data_like($table,$column,$value){
        $this->db->like($column, $value);
        $q = $this->db->get($table);
        return $q->result_array();
    }
	
	function get_point_detail($id)
	{
	
	   $this->db->where('id', $id);
		$query = $this->db->get('user_vendor_login');
		return $query->result();
	}
	
	function update_point($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('pointsredeemedreq', array('RequestStatus' => 1)) ? True : False;
	}
	
	function active_order($id)
	{
		$this->db->where('Id', $id);
		return $this->db->update('merchant', array('staus' => 'confirm')) ? True : False;
	}
	
	function deactive_order($id)
	{
		$this->db->where('Id', $id);
		return $this->db->update('placed_orders', array('admin_confirm' => 0)) ? True : False;
	}
	


}

