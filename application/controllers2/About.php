<?php    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  About extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		 $this->load->library('form_validation');
		$this->load->library('session');
    	$this->load->database();
		 $this->load->model('admin_model');
		
    }
	
	

	 public function index()
	 {
	
	 $this->load->view('about');
	 }


	  public function products()
	 {
	
	 $this->load->view('products');
	 }
	 
	   public function terms_and_condition()
	 {
	
	 	$this->load->view('terms_and_condition');
		$this->load->view('footer');
	 }
	 
	   public function api_new()
	 {
	 	$this->load->view('api_new');
	 }
	 
	   public function privacy_policy()
	 {
	
	 	$this->load->view('privacy_policy');
		$this->load->view('footer');
	 }
	 
   	public function blog()
	 {
	 $this->load->view('blog');
	 $this->load->view('footer');
	 }
   	public function blog_more()
	 {
	 $this->load->view('blog_more');
	 $this->load->view('footer');
	 }
   	public function blog_more2()
	 {
	 $this->load->view('blog_more2');
	 $this->load->view('footer');
	 }
   	public function blog_more3()
	 {
	 $this->load->view('blog_more3');
	 $this->load->view('footer');
	 }
   	public function blog_more4()
	 {
	 $this->load->view('blog_more4');
	 $this->load->view('footer');
	 }
	 
	 public function pos()
	{
		//$this->load->view('header_landing');
		$this->load->view('pos');
		$this->load->view('footer');
	}
	
	public function invoice()
	{
		//$this->load->view('header_landing');
		$this->load->view('invoice');
		$this->load->view('footer');
	}
	public function api()
	{
	//	$this->load->view('header_landing');
		$this->load->view('api');
		$this->load->view('footer');
	}
	public function pricing()
	{
	//	$this->load->view('header_landing');
		$this->load->view('pricing');
		$this->load->view('footer');
	}

  
	 
	 public function api2()
	 {
	      $this->session->set_flashdata('apimsg', '<div class="alert alert-success text-center">Demo Sent </div>');
	       redirect(base_url('api#apimsg'));
	 }
	 public function api3()
	 {
	      $this->session->set_flashdata('apimsg', '<div class="alert alert-success text-center"> Demo Sent </div>');
	       redirect(base_url('home#SendMsg'));
	 }
	  public function api4()
	 {
	      $this->session->set_flashdata('apimsg', '<div class="alert alert-success text-center"> Demo Sent </div>');
	       redirect(base_url('invoice#apimsg'));
	 }
	 
	  public function pricing2()
	 { 
	 
	 $this->load->view('pricing');	

	
	 }


	

	 public function support()
	 {
	
	 $this->load->view('support');
	 }

	  public function company()
	 {
	
	 $this->load->view('company');
	 }
	 public function login()
	 {
	
	 $this->load->view('login');
	 }
	 
	  public function api_detail()
	 {
	
	 $this->load->view('api_detail');
	 }

	public function admin()
	 {
	  $this->load->view('admin/login_view');
	 }

	  public function subadmin()
	 {
	  $this->load->view('subadmin/login_view');
	 }
	 
	  public function agent()
	 {
	  $this->load->view('subadmin/login_view');
	 }
	 
	
}
