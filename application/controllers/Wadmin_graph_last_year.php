<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
// header("Content-type: text/xml");

class Wadmin_graph_last_year extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model("serverside_model");
		$this->load->model("invoice_model");
		$this->load->model("recurring_model");
		$this->load->model("Home_model");
		$this->load->model('session_checker_model');
		$this->load->library('email');
		$this->load->library('twilio');

		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}

		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}




public function index() {
		// echo '<pre>';die;
		$data["title"] = "Admin Panel";
		$data["meta"] = "Dashboard";
		$month = date("m");
    	$today2 = date("Y", strtotime("-1 year"));

    	 $first_date = date('Y-m-01');
         $last_date = date('Y-m-t');

        $stmt=" and merchant_id IN('";
		$wf_merchants=$this->session->userdata('wf_merchants');

		if(!empty($wf_merchants)) {
	        $x=explode(",",$wf_merchants);
	        $len=sizeof($x);
	        for ($i=0; $i <$len ; $i++) { 
	            if($i==0){
	                $stmt.=$x[$i];
	            }else{
	                $stmt.="','".$x[$i];
	            }
	        
	        }
	        $stmt.="')";

		}else{
			$stmt=' and merchant_id is null ';

		}

// $date_c1 =date('2022-01-01');
//         $date_cc1 =date('2022-01-31');

		    		$amount = $this->db->query("SELECT sum(amount) as Totalboct from ( SELECT month,amount from customer_payment_request where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month  ");
// echo $this->db->last_query();die;          
      		$getamount = $amount->result_array();

          	$fee = $this->db->query("SELECT avg(amount) as Totalboctf from ( SELECT month,amount from customer_payment_request where month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,amount from pos where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month ");
          		
         	$getfee = $fee->result_array();

           	$tax = $this->db->query("SELECT sum(tax) as Totalbocttax from ( SELECT month,tax from customer_payment_request where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm'    union all SELECT month,tax from pos where  month = '10' and year = '" . $today2 . "' ".$stmt." and status='confirm' )x group by month");

           	$gettax = $tax->result_array();
          
           	$amount = $this->db->query("UPDATE admin_year_graph_wf SET Totalboct='".!empty($getamount[0]['Totalboct'])."' ,Totalboctf='".!empty($getfee[0]['Totalboctf'])."',Totalbocttax='".!empty($gettax[0]['Totalbocttax'])."'  ");
}

}