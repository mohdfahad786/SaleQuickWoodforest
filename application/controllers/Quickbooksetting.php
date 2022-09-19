<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/config.php';

require_once('/home/salequicknew/public_html/HelloWorld/vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;

$config = include('config.php');

 class Quickbooksetting extends CI_Controller {
     public function __construct() {
        parent::__construct();
        
        
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
		$this->load->model('admin_model');
		$this->load->library('email');
       
        date_default_timezone_set("America/Chicago");
      }
      
       public function index()
	 {
	  //	$this->load->view('header_landing');
		$this->load->view('quickbook');
	//	$this->load->view('footer');  
	 }
 }
 
 ?>