<?php
class Profile_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function get_package_details($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('admin');
		return $query->result();
	}
	
	function get_templete($id)
 {

      $this->db->select('*');
      $this->db->from('email_template');
      $this->db->where('id',$id);
     $query = $this->db->get();
  return $query->result();
 }


	function get_merchant_details($id = "") {
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant');
		return $query->result();
	}

	function get_merchant_details_new($id = "") {
		if($id != "") {
			$id = intval($id);
			$this->db->select('csv_Customer_name')->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant');
		return $query->result();
	}

	function get_merchant_details_batch($id = "") {
		if($id != "") {
			$id = intval($id);
			$this->db->select('id,report_email,email,business_dba_name,mob_no,logo,address1,time_zone,batch_report_time')->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('merchant');
		return $query->result();
	}

	
	function update_package($id, $userinfo)
	{
		$this->db->where('id', $id);
		return $this->db->update('admin', $userinfo) ? True : False;
	}
	function get_package_details1($id = "")
	{
	
		if($id != "")
		{
			$id = intval($id);
			$this->db->where('id',$id);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('branch');
		return $query->result();
	}

	
	
}
	?>