<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_api extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
    	$this->load->database();
    }
    
    public function index() {
        $this->load->view('front_api/apimain');
	}
 //     public function authentication() {
 //        $this->load->view('front_api/api_authentication');
	// }
 //     public function connected() {
 //        $this->load->view('front_api/api_connected');
	// }
 //     public function error() {
 //        $this->load->view('front_api/api_error');
	// }
 //     public function handling() {
 //        $this->load->view('front_api/api_handling');
	// }
 //     public function expanding() {
 //        $this->load->view('front_api/api_expanding');
	// }
 //     public function metadata() {
 //        $this->load->view('front_api/api_metadata');
	// }
 //     public function pagination() {
 //        $this->load->view('front_api/api_pagination');
	// }
 //     public function payment() {
 //        $this->load->view('front_api/api_payment');
	// }
 //     public function cnp() {
 //        $this->load->view('front_api/api_cnp');
	// }
 //     public function transaction() {
 //        $this->load->view('front_api/api_transaction');
	// }
 //     public function receipt() {
 //        $this->load->view('front_api/api_receipt');
	// }
}
