<?php 
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }
  class Token extends CI_Controller {
    public function __construct() {
    
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
      $this->load->model('profile_model');
      $this->load->model('admin_model');
      $this->load->model('home_model');
      $this->load->library('form_validation');
      $this->load->library('email');
      $this->load->library('twilio');
      
      //$this->load->model('sendmail_model');
      $this->load->model('session_checker_model');
      if (!$this->session_checker_model->chk_session_merchant()) {
        redirect('login');
      }
      if($this->session->userdata('time_zone')) {
        $time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
        date_default_timezone_set($time_Zone);
      }
      else
      {
        date_default_timezone_set('America/Chicago');
      }
      // ini_set('display_errors', 1);
     //    error_reporting(E_ALL);
    }


    public function token_list() {
    $data = array();
    $data["meta"] ='Token List';
    $merchant_id = $this->session->userdata('merchant_id');
    //$package_data = $this->admin_model->get_data('tax',$merchant_id);
    $package_data = $this->admin_model->data_get_where_1('token', array('merchant_id' => $merchant_id));
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
      $mem[] = $each;
    }
    $data['mem'] = $mem;
    // $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    // $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/token_list', $data);
    // $this->load->view('merchant/tax_list', $data);
  }




  }