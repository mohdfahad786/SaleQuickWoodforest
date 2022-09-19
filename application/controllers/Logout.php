<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		
    
	}
	
	public function index()
	{
		
		
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('image');
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('id');
		$this->session->sess_destroy();
		//session_destroy();
		
		redirect(base_url().'admin');
		
	}
	
	
	
	public function merchant()
	{
	
		
		$this->session->unset_userdata('merchant');
		$this->session->unset_userdata('merchant_user_type');
		$this->session->unset_userdata('merchant_name');
		$this->session->unset_userdata('merchant_id');
		$this->session->sess_destroy();
		
	
		redirect(base_url().'login');
		
	}
	
	public function subadmin()
	{
	
		
		$this->session->unset_userdata('username1');
		$this->session->unset_userdata('branch_name');
		$this->session->unset_userdata('id');
		//$this->session->unset_userdata('user_type');
		$this->session->sess_destroy();
		
		redirect(base_url().'subadmin');
		
	}
}