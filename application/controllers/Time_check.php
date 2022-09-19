<?php
ini_set('MAX_EXECUTION_TIME', '-1');
// ini_set('memory_limit','2048M');
defined('BASEPATH') OR exit('No direct script access allowed');
 //require APPPATH . 'third_party/REST_Controller.php';
//require APPPATH . 'third_party/Format.php';
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
 //use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");
define('UPLOAD_PATH', 'https://salequick.com/logo/');
define('UPLOAD_POS_PATH', 'https://salequick.com/uploads/item_image/');
 //header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class  Time_check extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('session');
    	$this->load->database();
		
		
    }
	
	
	 public function index()
	 {
	  echo	$tt= date("Ymd"); 
	  // 	echo $tt; 
	  // echo 	date_default_timezone_get();
echo  $url='https://salequick.com/Admin_Chart/dashboard_sale_by_year';
    $cmd=sprintf( 'start %s',$url );
    exec($url);


	 }
	
}
