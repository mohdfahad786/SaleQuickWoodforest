<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
     function __construct()
     {
         
          parent::__construct();
     }

   function get_ip($ip,$add_time,$endTime,$date)
     {

       

 

          $sql = "select * from login_detail where ip = '" .$ip. "' and add_date='" .$date. "' and status = 'false' and (add_time between '" .$endTime. "' and '" .$add_time. "')  ";
          $query = $this->db->query($sql);
          return $query->num_rows();
     }


     
     function get_user($usr, $pwd)
     {
        
		$this->db->select('*');
        $this->db->from('admin');
        $this->db->where('username', $usr);
		 $this->db->where('password', ($pwd));
        $this->db->where('status', 'active');
        $this->db->where('user_type', 'wf');
        $query = $this->db->get();
        return $query->row_array();
     }
     function get_user_id($id)
     {
        
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('id', $id);
        $this->db->where('status', 'active');
        $query = $this->db->get();
        return $query->row_array();
     }

     function get_subadmin($usr, $pwd)
     {
        
        $this->db->select('*');
        $this->db->from('sub_admin');
        $this->db->where('email', $usr);
         $this->db->where('password', ($pwd));
        $this->db->where('status', 'active');
        $query = $this->db->get();
        return $query->row_array();
     }

	function get_merchant($usr, $pwd)
     {
        
	   $this->db->select('*');
        $this->db->from('merchant');
        $this->db->where('email', $usr);
	   $this->db->where('password', ($pwd));
        // $this->db->where('status !=', 'Waiting_For_Approval');
        // $this->db->where('status !=', 'block'); 
        //$this->db->where('status !=', 'pending');
        $query = $this->db->get();
         
        return $query->row_array();
     }
	 
	 
}


?>