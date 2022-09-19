<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout1 extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
    
	}
	
	public function index()
	{
	
		
		$this->session->unset_userdata('username1');
		$this->session->unset_userdata('branch_name');
		$this->session->unset_userdata('id');
		//$this->session->unset_userdata('user_type');
		//session_destroy();
		
		redirect('subadmin');
		
	}
}