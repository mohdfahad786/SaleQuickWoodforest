<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('profile_model');
        $this->load->model('admin_model');
        $this->load->model('home_model');
        $this->load->library('email');
        $this->load->library('twilio');
        $this->load->model('session_checker_model');
        if(!$this->session_checker_model->chk_session_merchant())
            redirect('login');
            date_default_timezone_set("America/Chicago");
    }
	public function email_report(){
		echo "this is the report";die;
	}
}