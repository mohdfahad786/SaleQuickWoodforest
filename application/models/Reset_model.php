<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor 
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_user($usr)
     {
          $sql = "select * from admin where email_id = '" . $usr . "'  and status = 'active'";
          $query = $this->db->query($sql);
          return $query->num_rows();
     }
      function get_userb($usr)
     {
          $sql = "select * from sub_admin where email = '" . $usr . "'  and status = 'active'";
          $query = $this->db->query($sql);
          return $query->num_rows();
     }

     function get_merchant($usr)
     {
          $sql = "select * from merchant where email = '" . $usr . "'  and (status = 'active' OR status = 'confirm'  OR status = 'Waiting_For_Approval' )";
          $query = $this->db->query($sql);
          return $query->num_rows();
     }

	 
	 
	   function update($usr,$psw)
     {
	 
	 
	 $sql = "UPDATE admin SET password='".($psw)."' WHERE email_id='".$usr."'" ;
	 
           $query = $this->db->query($sql);
		   
		
     }
     
      function bupdate($usr,$psw)
     {
	 
	 
	 $sql = "UPDATE sub_admin SET password='".($psw)."' WHERE email='".$usr."'" ;
	 
           $query = $this->db->query($sql);
		   
		
     }
     

     function update_merchant($usr,$psw)
     {
      
      
      $sql = "UPDATE merchant SET password='".($psw)."' WHERE email='".$usr."'" ;
      
           $query = $this->db->query($sql);
             
          
     }

	 
	 
}

?>