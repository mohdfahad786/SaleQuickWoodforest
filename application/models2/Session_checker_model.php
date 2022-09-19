<?php
class Session_checker_model extends CI_Model {
 function __construct()
    {
        parent::__construct();
	}
	function chk_session()
	{
		if($this->session->userdata('username') != "")
		return True;
		else
		return False;
	}
	
	function chk_session_subadmim()
	{
		if($this->session->userdata('user_type') != "")
		return True;
		else
		return False;
	}
	function chk_session_merchant()
	{
		if($this->session->userdata('merchant') != "")
		return True;
		else
		return False;
	}
	function chk_session_submerchant()
	{
		if($this->session->userdata('merchant') != "")
		return True;
		else
		return False;
	}
	
	
}
	?>