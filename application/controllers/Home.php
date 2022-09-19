<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('session');
    	$this->load->database();
		 date_default_timezone_set("America/Chicago");
		
    }
	
	
	 public function home()
	 {
	 
	 	$this->load->view('header_landing');
		$this->load->view('index');
		$this->load->view('footer');  
	
	 }
	 
	 public function index()
	 {
	 //  	$this->load->view('header_landing');
		// $this->load->view('index');
		// $this->load->view('footer');
		$this->load->view('front/index');
	 }
	
}
