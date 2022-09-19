<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Graph extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('profile_model');
		
		$this->load->model('Inventory_graph_model');
		$this->load->model('Inventory_graph_model_new');
		$this->load->helper('pdf_helper');
		
		$this->load->model('admin_model');
		$this->load->model('home_model');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->model('session_checker_model');
		if (!$this->session_checker_model->chk_session_merchant()) {
			redirect('login');
		}
		ini_set('max_execution_time', -1);
		date_default_timezone_set("America/Chicago");

		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}

	public function tz_list($timezone) {
		$mygmt = "";
		$zones_array = array();
		$timestamp = time();
		foreach (timezone_identifiers_list() as $key => $zone) {
			date_default_timezone_set($zone);
			$zones_array[$key]['zone'] = $zone;
			if ($timezone == $zone) {
				$mygmt = date('P', $timestamp);
				break;
			} else {
				$mygmt = '-05:00';
			}
			$zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);
		}
		//return $zones_array;
		return $mygmt;

	}
	
	public function dateTimeConvertTimeZone($Adate) {
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
				date_default_timezone_set('America/Chicago');
				if($time_Zone!='America/Chicago'){
					$datetime = new DateTime($Adate);
					$la_time = new DateTimeZone($time_Zone);
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				} else {
					$convertedDateTime=$Adate;
				}
				
				
			} else {
				$convertedDateTime=$Adate;
			}
			return $convertedDateTime; 
		}

	public function trends() {

		$timezone = $this->session->userdata('time_zone');

		if ($timezone == "") {$timezone = "America/Chicago";}
		date_default_timezone_set($timezone);
		$Zone__GMT = $this->tz_list($timezone);

		$data["title"] = "Merchant Panel";
		$data["meta"] = "Sales Trends";
		
		if( $this->session->userdata('employee_id') ) {
            $merchant_id = $this->session->userdata('employee_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
        }
		//$merchant_id = $this->session->userdata('merchant_id');
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$start = $this->input->post('start');
		$end = $this->input->post('end');

		//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
		//$date1 = date("Y-m-d");

		if ($start != '') {
			$last_date = $start;
			$date = $end;
		} else {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		}
		$cday = date("Y-m-d", strtotime("-1 days"));
		$lday = date("Y-m-d", strtotime("-8 days"));

		$monday = strtotime("last monday");
		$monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;

		$sunday = strtotime(date("Y-m-d", $monday) . " +6 days");

		$sunday1 = strtotime(date("Y-m-d", $monday) . " -7 days");
		$sunday2 = strtotime(date("Y-m-d", $sunday1) . " +6 days");

		$this_week_ed1 = date("Y-m-d", $sunday2);
		$this_week_sd1 = date("Y-m-d", $sunday1);

		$this_week_sd = date("Y-m-d", $monday);
		$this_week_ed = date("Y-m-d", $sunday);

		$last_date = date("Y-m-d", strtotime("-8 days"));
		$date = date("Y-m-d", strtotime("-1 days"));
		$curdate = date("Y-m-d");

		$getDashboard = $this->db->query("SELECT
			(SELECT sum(`amount`-`p_ref_amount`) as Monday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Monday ,
			(SELECT sum(`amount`-`p_ref_amount`) as Tuesday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Tuesday ,
			(SELECT sum(`amount`-`p_ref_amount`) as Wednesday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Wednesday ,
			(SELECT sum(`amount`-`p_ref_amount`) as Thursday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Thursday ,
			(SELECT sum(`amount`-`p_ref_amount`) as Friday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Friday ,
			(SELECT sum(`amount`-`p_ref_amount`) as Satuday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Satuday ,
			(SELECT sum(`amount`-`p_ref_amount`) as Sunday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and (status='confirm' or partial_refund=1) union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Sunday ,

			(SELECT avg(amount) as Monday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm' )x group by merchant_id ) as Monday_fee ,
			(SELECT avg(amount) as Tuesday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm' )x group by merchant_id ) as Tuesday_fee ,
			(SELECT avg(amount) as Wednesday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm' )x group by merchant_id ) as Wednesday_fee ,
			(SELECT avg(amount) as Thursday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm' )x group by merchant_id ) as Thursday_fee ,
			(SELECT avg(amount) as Friday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm' )x group by merchant_id ) as Friday_fee ,
			(SELECT avg(amount) as Satuday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm' )x group by merchant_id ) as Satuday_fee ,
			(SELECT avg(amount) as Sunday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm' )x group by merchant_id ) as Sunday_fee ,

			(SELECT sum(tax) as Monday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm' )x group by merchant_id ) as Monday_tax ,
			(SELECT sum(tax) as Tuesday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm' )x group by merchant_id ) as Tuesday_tax ,
			(SELECT sum(tax) as Wednesday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm' )x group by merchant_id ) as Wednesday_tax ,
			(SELECT sum(tax) as Thursday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm' )x group by merchant_id ) as Thursday_tax ,
			(SELECT sum(tax) as Friday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm' )x group by merchant_id ) as Friday_tax ,
			(SELECT sum(tax) as Satuday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm' )x group by merchant_id ) as Satuday_tax ,
			(SELECT sum(tax) as Sunday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm' )x group by merchant_id ) as Sunday_tax ,

			(SELECT sum(`amount`-`p_ref_amount`) as Monday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Monday_l ,
			(SELECT sum(`amount`-`p_ref_amount`) as Tuesday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and (status='confirm' or partial_refund=1) union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Tuesday_l ,
			(SELECT sum(`amount`-`p_ref_amount`) as Wednesday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Wednesday_l ,
			(SELECT sum(`amount`-`p_ref_amount`) as Thursday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Thursday_l ,
			(SELECT sum(`amount`-`p_ref_amount`) as Friday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and (status='confirm' or partial_refund=1) union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Friday_l ,
			(SELECT sum(`amount`-`p_ref_amount`) as Satuday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Satuday_l ,
			(SELECT sum(`amount`-`p_ref_amount`) as Sunday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and (status='confirm' or partial_refund=1) )x group by merchant_id ) as Sunday_l ,

			(SELECT avg(amount) as Monday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm' )x group by merchant_id ) as Monday_l_fee ,
			(SELECT avg(amount) as Tuesday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm' )x group by merchant_id ) as Tuesday_l_amount ,
			(SELECT avg(amount) as Wednesday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm' )x group by merchant_id ) as Wednesday_l_fee ,
			(SELECT avg(amount) as Thursday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm' )x group by merchant_id ) as Thursday_l_fee ,
			(SELECT avg(amount) as Friday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm' )x group by merchant_id ) as Friday_l_fee ,
			(SELECT avg(amount) as Satuday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm' )x group by merchant_id ) as Satuday_l_fee ,
			(SELECT avg(amount) as Sunday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm' )x group by merchant_id ) as Sunday_l_fee ,

			(SELECT sum(tax) as Monday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm' )x group by merchant_id ) as Monday_l_tax ,
			(SELECT sum(tax) as Tuesday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm' )x group by merchant_id ) as Tuesday_l_tax ,
			(SELECT sum(tax) as Wednesday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm' )x group by merchant_id ) as Wednesday_l_tax ,
			(SELECT sum(tax) as Thursday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm' )x group by merchant_id ) as Thursday_l_tax ,
			(SELECT sum(tax) as Friday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm' )x group by merchant_id ) as Friday_l_tax ,
			(SELECT sum(tax) as Satuday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm' )x group by merchant_id ) as Satuday_l_tax ,
			(SELECT sum(tax) as Sunday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm' )x group by merchant_id ) as Sunday_l_tax ,

			(SELECT sum(amount) as Total_today_0timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' )x group by merchant_id ) as Total_today_0timea ,

			(SELECT sum(amount) as Total_today_1timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' )x group by merchant_id ) as Total_today_1timea ,

			(SELECT sum(amount) as Total_today_2timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' )x group by merchant_id ) as Total_today_2timea ,

			(SELECT sum(amount) as Total_today_3timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' )x group by merchant_id ) as Total_today_3timea ,

			(SELECT sum(amount) as Total_today_4timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm' )x group by merchant_id ) as Total_today_4timea ,

			(SELECT sum(amount) as Total_today_5timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm' )x group by merchant_id ) as Total_today_5timea ,

			(SELECT sum(amount) as Total_today_6timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' )x group by merchant_id ) as Total_today_6timea ,

			(SELECT sum(amount) as Total_today_7timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' )x group by merchant_id ) as Total_today_7timea ,

			(SELECT sum(amount) as Total_today_8timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm' )x group by merchant_id ) as Total_today_8timea ,

			(SELECT sum(amount) as Total_today_9timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' )x group by merchant_id ) as Total_today_9timea ,

			(SELECT sum(amount) as Total_today_10timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_today_10timea ,

			(SELECT sum(amount) as Total_today_11timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_today_11timea ,

			(SELECT sum(amount) as Total_today_12timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_today_12timea ,

			(SELECT sum(amount) as Total_today_13timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_today_13timea ,

			(SELECT sum(amount) as Total_today_14timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_today_14timea ,

			(SELECT sum(amount) as Total_today_15timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_today_15timea ,

			(SELECT sum(amount) as Total_today_16timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_today_16timea ,

			(SELECT sum(amount) as Total_today_17timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_today_17timea ,

			(SELECT sum(amount) as Total_today_18timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_today_18timea ,

			(SELECT sum(amount) as Total_today_19timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_today_19timea ,

			(SELECT sum(amount) as Total_today_20timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_today_20timea ,

			(SELECT sum(amount) as Total_today_21timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_today_21timea ,

			(SELECT sum(amount) as Total_today_22timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_today_22timea ,

			(SELECT sum(amount) as Total_today_23timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_today_23timea ,

			(SELECT sum(tax) as Total_today_0timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' )x group by merchant_id ) as Total_today_0timetax ,

			(SELECT sum(tax) as Total_today_1timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' )x group by merchant_id ) as Total_today_1timetax ,

			(SELECT sum(tax) as Total_today_2timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' )x group by merchant_id ) as Total_today_2timetax ,

			(SELECT sum(tax) as Total_today_3timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' )x group by merchant_id ) as Total_today_3timetax ,

			(SELECT sum(tax) as Total_today_4timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm' )x group by merchant_id ) as Total_today_4timetax ,

			(SELECT sum(tax) as Total_today_5timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm' )x group by merchant_id ) as Total_today_5timetax ,

			(SELECT sum(tax) as Total_today_6timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' )x group by merchant_id ) as Total_today_6timetax ,

			(SELECT sum(tax) as Total_today_7timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' )x group by merchant_id ) as Total_today_7timetax ,

			(SELECT sum(tax) as Total_today_8timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm' )x group by merchant_id ) as Total_today_8timetax ,

			(SELECT sum(tax) as Total_today_9timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' )x group by merchant_id ) as Total_today_9timetax ,

			(SELECT sum(tax) as Total_today_10timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_today_10timetax ,

			(SELECT sum(tax) as Total_today_11timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_today_11timetax ,

			(SELECT sum(tax) as Total_today_12timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_today_12timetax ,

			(SELECT sum(tax) as Total_today_13timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_today_13timetax ,

			(SELECT sum(tax) as Total_today_14timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_today_14timetax ,

			(SELECT sum(tax) as Total_today_15timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_today_15timetax ,

			(SELECT sum(tax) as Total_today_16timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_today_16timetax ,

			(SELECT sum(tax) as Total_today_17timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_today_17timetax ,

			(SELECT sum(tax) as Total_today_18timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_today_18timetax ,

			(SELECT sum(tax) as Total_today_19timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_today_19timetax ,

			(SELECT sum(tax) as Total_today_20timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_today_20timetax ,

			(SELECT sum(tax) as Total_today_21timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_today_21timetax ,

			(SELECT sum(tax) as Total_today_22timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_today_22timetax ,

			(SELECT sum(tax) as Total_today_23timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_today_23timetax ,

			(SELECT avg(amount) as Total_today_0timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' )x group by merchant_id ) as Total_today_0timefee ,

			(SELECT avg(amount) as Total_today_1timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' )x group by merchant_id ) as Total_today_1timefee ,

			(SELECT avg(amount) as Total_today_2timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' )x group by merchant_id ) as Total_today_2timefee ,

			(SELECT avg(amount) as Total_today_3timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' )x group by merchant_id ) as Total_today_3timefee ,

			(SELECT avg(amount) as Total_today_4timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm' )x group by merchant_id ) as Total_today_4timefee ,

			(SELECT avg(amount) as Total_today_5timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm' )x group by merchant_id ) as Total_today_5timefee ,

			(SELECT avg(amount) as Total_today_6timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' )x group by merchant_id ) as Total_today_6timefee ,

			(SELECT avg(amount) as Total_today_7timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' )x group by merchant_id ) as Total_today_7timefee ,

			(SELECT avg(amount) as Total_today_8timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm' )x group by merchant_id ) as Total_today_8timefee ,

			(SELECT avg(amount) as Total_today_9timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' )x group by merchant_id ) as Total_today_9timefee ,

			(SELECT avg(amount) as Total_today_10timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_today_10timefee ,

			(SELECT avg(amount) as Total_today_11timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_today_11timefee ,

			(SELECT avg(amount) as Total_today_12timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_today_12timefee ,

			(SELECT avg(amount) as Total_today_13timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_today_13timefee ,

			(SELECT avg(amount) as Total_today_14timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_today_14timefee ,

			(SELECT avg(amount) as Total_today_15timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_today_15timefee ,

			(SELECT avg(amount) as Total_today_16timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_today_16timefee ,

			(SELECT avg(amount) as Total_today_17timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_today_17timefee ,

			(SELECT avg(amount) as Total_today_18timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_today_18timefee ,

			(SELECT avg(amount) as Total_today_19timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_today_19timefee ,

			(SELECT avg(amount) as Total_today_20timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_today_20timefee ,

			(SELECT avg(amount) as Total_today_21timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_today_21timefee ,

			(SELECT avg(amount) as Total_today_22timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_today_22timefee ,

			(SELECT avg(amount) as Total_today_23timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$curdate' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_today_23timefee ,

			(SELECT sum(amount) as Total_yesterday_0timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' )x group by merchant_id ) as Total_yesterday_0timea ,

			(SELECT sum(amount) as Total_yesterday_1timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' )x group by merchant_id ) as Total_yesterday_1timea ,

			(SELECT sum(amount) as Total_yesterday_2timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' )x group by merchant_id ) as Total_yesterday_2timea ,

			(SELECT sum(amount) as Total_yesterday_3timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' )x group by merchant_id ) as Total_yesterday_3timea ,

			(SELECT sum(amount) as Total_yesterday_4timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm' )x group by merchant_id ) as Total_yesterday_4timea ,

			(SELECT sum(amount) as Total_yesterday_5timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm' )x group by merchant_id ) as Total_yesterday_5timea ,

			(SELECT sum(amount) as Total_yesterday_6timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' )x group by merchant_id ) as Total_yesterday_6timea ,

			(SELECT sum(amount) as Total_yesterday_7timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' )x group by merchant_id ) as Total_yesterday_7timea ,

			(SELECT sum(amount) as Total_yesterday_8timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm' )x group by merchant_id ) as Total_yesterday_8timea ,

			(SELECT sum(amount) as Total_yesterday_9timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' )x group by merchant_id ) as Total_yesterday_9timea ,

			(SELECT sum(amount) as Total_yesterday_10timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_yesterday_10timea ,

			(SELECT sum(amount) as Total_yesterday_11timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_yesterday_11timea ,

			(SELECT sum(amount) as Total_yesterday_12timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_yesterday_12timea ,

			(SELECT sum(amount) as Total_yesterday_13timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_yesterday_13timea ,

			(SELECT sum(amount) as Total_yesterday_14timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_yesterday_14timea ,

			(SELECT sum(amount) as Total_yesterday_15timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_yesterday_15timea ,

			(SELECT sum(amount) as Total_yesterday_16timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_yesterday_16timea ,

			(SELECT sum(amount) as Total_yesterday_17timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_yesterday_17timea ,

			(SELECT sum(amount) as Total_yesterday_18timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_yesterday_18timea ,

			(SELECT sum(amount) as Total_yesterday_19timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_yesterday_19timea ,

			(SELECT sum(amount) as Total_yesterday_20timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_yesterday_20timea ,

			(SELECT sum(amount) as Total_yesterday_21timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_yesterday_21timea ,

			(SELECT sum(amount) as Total_yesterday_22timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_yesterday_22timea ,

			(SELECT sum(amount) as Total_yesterday_23timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_yesterday_23timea ,

			(SELECT sum(tax) as Total_yesterday_0timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' )x group by merchant_id ) as Total_yesterday_0timetax ,

			(SELECT sum(tax) as Total_yesterday_1timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' )x group by merchant_id ) as Total_yesterday_1timetax ,

			(SELECT sum(tax) as Total_yesterday_2timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' )x group by merchant_id ) as Total_yesterday_2timetax ,

			(SELECT sum(tax) as Total_yesterday_3timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' )x group by merchant_id ) as Total_yesterday_3timetax ,

			(SELECT sum(tax) as Total_yesterday_4timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm' )x group by merchant_id ) as Total_yesterday_4timetax ,

			(SELECT sum(tax) as Total_yesterday_5timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm' )x group by merchant_id ) as Total_yesterday_5timetax ,

			(SELECT sum(tax) as Total_yesterday_6timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' )x group by merchant_id ) as Total_yesterday_6timetax ,

			(SELECT sum(tax) as Total_yesterday_7timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' )x group by merchant_id ) as Total_yesterday_7timetax ,

			(SELECT sum(tax) as Total_yesterday_8timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm' )x group by merchant_id ) as Total_yesterday_8timetax ,

			(SELECT sum(tax) as Total_yesterday_9timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' )x group by merchant_id ) as Total_yesterday_9timetax ,

			(SELECT sum(tax) as Total_yesterday_10timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_yesterday_10timetax ,

			(SELECT sum(tax) as Total_yesterday_11timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_yesterday_11timetax ,

			(SELECT sum(tax) as Total_yesterday_12timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_yesterday_12timetax ,

			(SELECT sum(tax) as Total_yesterday_13timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_yesterday_13timetax ,

			(SELECT sum(tax) as Total_yesterday_14timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_yesterday_14timetax ,

			(SELECT sum(tax) as Total_yesterday_15timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_yesterday_15timetax ,

			(SELECT sum(tax) as Total_yesterday_16timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_yesterday_16timetax ,

			(SELECT sum(tax) as Total_yesterday_17timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_yesterday_17timetax ,

			(SELECT sum(tax) as Total_yesterday_18timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_yesterday_18timetax ,

			(SELECT sum(tax) as Total_yesterday_19timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_yesterday_19timetax ,

			(SELECT sum(tax) as Total_yesterday_20timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_yesterday_20timetax ,

			(SELECT sum(tax) as Total_yesterday_21timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_yesterday_21timetax ,

			(SELECT sum(tax) as Total_yesterday_22timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_yesterday_22timetax ,

			(SELECT sum(tax) as Total_yesterday_23timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_yesterday_23timetax ,

			(SELECT avg(amount) as Total_yesterday_0timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='00' and status='confirm' )x group by merchant_id ) as Total_yesterday_0timefee ,

			(SELECT avg(amount) as Total_yesterday_1timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='01' and status='confirm' )x group by merchant_id ) as Total_yesterday_1timefee ,

			(SELECT avg(amount) as Total_yesterday_2timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='02' and status='confirm' )x group by merchant_id ) as Total_yesterday_2timefee ,

			(SELECT avg(amount) as Total_yesterday_3timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='03' and status='confirm' )x group by merchant_id ) as Total_yesterday_3timefee ,

			(SELECT avg(amount) as Total_yesterday_4timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='04' and status='confirm' )x group by merchant_id ) as Total_yesterday_4timefee ,

			(SELECT avg(amount) as Total_yesterday_5timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='05' and status='confirm' )x group by merchant_id ) as Total_yesterday_5timefee ,

			(SELECT avg(amount) as Total_yesterday_6timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='06' and status='confirm' )x group by merchant_id ) as Total_yesterday_6timefee ,

			(SELECT avg(amount) as Total_yesterday_7timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='07' and status='confirm' )x group by merchant_id ) as Total_yesterday_7timefee ,

			(SELECT avg(amount) as Total_yesterday_8timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='08' and status='confirm' )x group by merchant_id ) as Total_yesterday_8timefee ,

			(SELECT avg(amount) as Total_yesterday_9timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='09' and status='confirm' )x group by merchant_id ) as Total_yesterday_9timefee ,

			(SELECT avg(amount) as Total_yesterday_10timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_yesterday_10timefee ,

			(SELECT avg(amount) as Total_yesterday_11timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_yesterday_11timefee ,

			(SELECT avg(amount) as Total_yesterday_12timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_yesterday_12timefee ,

			(SELECT avg(amount) as Total_yesterday_13timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_yesterday_13timefee ,

			(SELECT avg(amount) as Total_yesterday_14timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_yesterday_14timefee ,

			(SELECT avg(amount) as Total_yesterday_15timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_yesterday_15timefee ,

			(SELECT avg(amount) as Total_yesterday_16timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_yesterday_16timefee ,

			(SELECT avg(amount) as Total_yesterday_17timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_yesterday_17timefee ,

			(SELECT avg(amount) as Total_yesterday_18timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_yesterday_18timefee ,

			(SELECT avg(amount) as Total_yesterday_19timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_yesterday_19timefee ,

			(SELECT avg(amount) as Total_yesterday_20timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_yesterday_20timefee ,

			(SELECT avg(amount) as Total_yesterday_21timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_yesterday_21timefee ,

			(SELECT avg(amount) as Total_yesterday_22timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_yesterday_22timefee ,

			(SELECT avg(amount) as Total_yesterday_23timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') = '$date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_yesterday_23timefee
		");
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;
		// print_r($getDashboardData);   die();

        $getSaleByYear = $this->db->query("SELECT * from merchant_year_graph where merchant_id = ".$merchant_id." order by id desc limit 0,1");
        $getSaleByYearData = $getSaleByYear->result_array();
        // echo '<pre>';print_r($getSaleByYearData);die;
        $data['getSaleByYearData'] = $getSaleByYearData;

		// $data['item'] = $this->admin_model->data_get_where_g("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));

		$package_data = $this->admin_model->data_get_where("customer_payment_request", array("merchant_id" => $merchant_id, "status" => 'confirm'));

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['amount'] = $each->amount;
			$package['tax'] = $each->tax;
			$package['type'] = $each->type;
			$package['date'] = $each->date_c;

			$mem[] = $package;
		}
		$data['item'] = $mem;

		$data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("merchant_id" => $merchant_id, "status" => 'confirm'));
		$data['item2'] = $this->admin_model->data_get_where_g("pos", array("merchant_id" => $merchant_id));

		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('merchant/trend_dash', $data);
			// return $this->load->view('merchant/trend', $data);
		}
	}

	public function widgets() {
	    $data["title"] = "Merchant Panel";
		$merchant_id = $this->session->userdata('merchant_id');
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$last_date = date("Y-m-d", strtotime("-29 days"));
		$date = date("Y-m-d");
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$employee = $this->input->post('employee');
       if ($start == 'undefined') {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		} elseif ($start != '') {
			$last_date = $start;
			$date = $end;
		} else {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		}

		if ($employee == 'all') {
			$getDashboard = $this->db->query("SELECT
			(SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
			(SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
			(SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
			");
		    $DashboardCountData = $this->db->query("SELECT 

			( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
			( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
			( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
			( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
			( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
			( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
			( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
			"); 
		} elseif ($employee == 'merchant') {
			$getDashboard = $this->db->query("SELECT
			(SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
			(SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
			(SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
			");
			$DashboardCountData = $this->db->query("SELECT 

			( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
			( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
			( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
			( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
			( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
			( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
			( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
			"); 
		} else {
			$getDashboard = $this->db->query("SELECT
			(SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and sub_merchant_id ='" . $employee . "' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
			(SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and sub_merchant_id ='" . $employee . "'  and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
			(SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and sub_merchant_id ='" . $employee . "'  and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
			");
			$DashboardCountData = $this->db->query("SELECT 

			( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalPOSConfirm,
			( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
			( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
			( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalInvoicePending,
			( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalRecurringPending,
			( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
			( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
			");
		    
		}
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;

	    $DashboardCountData=$DashboardCountData->result_array();
        //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
	    $widgets_data = array(
		'NewTotalOrders'=>$DashboardCountData[0]['TotalPOSConfirm'], 
		'TotalOrders'=>$DashboardCountData[0]['TotalInvoiceConfirm']+$DashboardCountData[0]['TotalRecurringConfirm'], 
		'TotalpendingOrders'=>$DashboardCountData[0]['TotalInvoicePending']+$DashboardCountData[0]['TotalRecurringPending'], 
		'TotalAmount'=>0, 
		'TotalLate' => $DashboardCountData[0]['TotalInvoicePendingDueOver']+$DashboardCountData[0]['TotalRecurringPendingDueOver'],
          ); 
	   $data['widgets_data'] = $widgets_data;

	echo json_encode($data); die();
	
}


	public function sale() {
		$employee = 0;
        // echo '<pre>';print_r($this->session->userdata());die();
        if ($this->session->userdata('employee_id')) {
            $merchant_id = $this->session->userdata('employee_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
        }
        
		$timezone = $this->session->userdata('time_zone');
		if ($timezone == "") {$timezone = "America/Chicago";}
		$Zone__GMT = $this->tz_list($timezone);
		date_default_timezone_set($timezone);

		$data["title"] = "Merchant Panel";
		$data["meta"] = "Transaction Summary";

		//$merchant_id = $this->session->userdata('merchant_id');
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));

		$start = $this->input->post('start');
		$end = $this->input->post('end');

		//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
		//$date1 = date("Y-m-d");
		if ($start != '') {
			$last_date = $start;
			$date = $end;

		} else {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		}
		$merchant_data = $this->profile_model->get_merchant_details_new($merchant_id);
		
		
		
		$mem = array();
		$member = array();
		if (isset($package_data)) {
			foreach ($package_data as $each) {
				if ($each->receipt_type == null) // no-cepeipt
				{
					if ($each->mobile_no && $each->email_id) {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no != "" && $each->email_id == "") {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no == "" && $each->email_id != "") {
						$repeiptmethod = $each->email_id;
					} else {
						$repeiptmethod = 'no-receipt';
					}

				} else if ($each->receipt_type == 'no-cepeipt') {
					$repeiptmethod = 'no-receipt';
				} else {
					$repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
				}
				//$each->add_date=$this->dateTimeConvertTimeZone($each->add_date);

				$pyadate=str_replace("-","",$each->express_transactiondate);
				$paytime=str_replace(":","",$each->express_transactiontime);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($each->add_date,new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
				}
				
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				//$package['amount'] = $each->refund_amount;
				$package['date'] =  $TransactiondateTime;  // $TransactiondateTime; 
				$package['status'] = $each->status;
				$package['card_no'] = $each->card_no;
				$package['card_type'] = $each->card_type;
				$package['transaction_type'] = $each->transaction_type;
				if ($each->transaction_type == "split") {
					$package['transaction_id'] = $each->invoice_no;
					$package['amount'] = $each->full_amount;
					$package['card_no'] = "";
					$package['card_type'] = "SPLIT";

				} else {
					$package['transaction_id'] = $each->transaction_id;
					$package['amount'] = $each->amount;
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
				}
				$mem[] = $package;

			}
		}
        
		if (isset($refund_data)) {
			// print_r($refund_data);die;
			foreach ($refund_data as $each) {

				if ($each->status == 'Chargeback_Confirm') {
					if ($each->receipt_type == null) // no-cepeipt
					{
						if ($each->mobile_no && $each->email_id) {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no != "" && $each->email_id == "") {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no == "" && $each->email_id != "") {
							$repeiptmethod = $each->email_id;
						} else {
							$repeiptmethod = 'no-receipt';
						}

					} else if ($each->receipt_type == 'no-cepeipt') {
						$repeiptmethod = 'no-receipt';
					} else {
						$repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
					}
                    // $each->refund_dt=$this->dateTimeConvertTimeZone($each->refund_dt);
					$datetime = new DateTime($each->refund_dt,new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');

					$newdate=$this->dateTimeConvertTimeZone($convertedDateTime);
					
					$package['id'] = $each->id;
					$package['refund_row_id'] = $each->refund_row_id;
					// $package['refund_row_id'] = "ABCD";
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['c_type'] = $each->c_type;
					$package['transaction_id'] = $each->refund_transaction;
					// $package['amount'] = $each->amount;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					//$package['amount'] = $each->refund_amount;
					$package['date'] =$newdate;
					$package['status'] = "Refund";
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
					$mem[] = $package; 
				}
			}
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);
		//echo '<pre>'; print_r($mem) ; die; 
		$data['mem'] = $mem;
		
		

		//date_c <= '$date' and date_c >= '$last_date'

		//$data['result']=array('Start'=>$date,'end'=>$last_date);
		// print_r($data['result']);  die();

		//echo date_default_timezone_get();  die();
		$getDashboard = $this->db->query("SELECT
			(SELECT sum(amount) as Total_today_0timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='0' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='0' and status='confirm' )x group by merchant_id )  ,

			(SELECT sum(amount) as Total_today_1timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='1' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='1' and status='confirm' )x group by merchant_id ) as Total_today_1timea ,

			(SELECT sum(amount) as Total_today_2timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='2' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='2' and status='confirm' )x group by merchant_id ) as Total_today_2timea ,

			(SELECT sum(amount) as Total_today_3timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='3' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='3' and status='confirm' )x group by merchant_id ) as Total_today_3timea ,

			(SELECT sum(amount) as Total_today_4timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='4' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='4' and status='confirm' )x group by merchant_id ) as Total_today_4timea ,

			(SELECT sum(amount) as Total_today_5timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='5' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='5' and status='confirm' )x group by merchant_id ) as Total_today_5timea ,

			(SELECT sum(amount) as Total_today_6timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='6' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='6' and status='confirm' )x group by merchant_id ) as Total_today_6timea ,

			(SELECT sum(amount) as Total_today_7timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='7' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='7' and status='confirm' )x group by merchant_id ) as Total_today_7timea ,

			(SELECT sum(amount) as Total_today_8timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='8' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='8' and status='confirm' )x group by merchant_id ) as Total_today_8timea ,

			(SELECT sum(amount) as Total_today_9timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='9' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='9' and status='confirm' )x group by merchant_id ) as Total_today_9timea ,

			(SELECT sum(amount) as Total_today_10timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_today_10timea ,

			(SELECT sum(amount) as Total_today_11timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_today_11timea ,

			(SELECT sum(amount) as Total_today_12timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_today_12timea ,

			(SELECT sum(amount) as Total_today_13timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_today_13timea ,

			(SELECT sum(amount) as Total_today_14timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_today_14timea ,

			(SELECT sum(amount) as Total_today_15timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_today_15timea ,

			(SELECT sum(amount) as Total_today_16timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_today_16timea ,

			(SELECT sum(amount) as Total_today_17timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_today_17timea ,

			(SELECT sum(amount) as Total_today_18timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_today_18timea ,

			(SELECT sum(amount) as Total_today_19timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_today_19timea ,

			(SELECT sum(amount) as Total_today_20timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_today_20timea ,

			(SELECT sum(amount) as Total_today_21timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_today_21timea ,

			(SELECT sum(amount) as Total_today_22timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_today_22timea ,

			(SELECT sum(amount) as Total_today_23timea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_today_23timea ,




			(SELECT sum(tax) as Total_today_0timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='0' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='0' and status='confirm' )x group by merchant_id ) as Total_today_0timetax ,

			(SELECT sum(tax) as Total_today_1timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='1' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='1' and status='confirm' )x group by merchant_id ) as Total_today_1timetax ,

			(SELECT sum(tax) as Total_today_2timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='2' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='2' and status='confirm' )x group by merchant_id ) as Total_today_2timetax ,

			(SELECT sum(tax) as Total_today_3timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='3' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='3' and status='confirm' )x group by merchant_id ) as Total_today_3timetax ,

			(SELECT sum(tax) as Total_today_4timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='4' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='4' and status='confirm' )x group by merchant_id ) as Total_today_4timetax ,

			(SELECT sum(tax) as Total_today_5timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='5' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='5' and status='confirm' )x group by merchant_id ) as Total_today_5timetax ,

			(SELECT sum(tax) as Total_today_6timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='6' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='6' and status='confirm' )x group by merchant_id ) as Total_today_6timetax ,

			(SELECT sum(tax) as Total_today_7timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='7' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='7' and status='confirm' )x group by merchant_id ) as Total_today_7timetax ,

			(SELECT sum(tax) as Total_today_8timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='8' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='8' and status='confirm' )x group by merchant_id ) as Total_today_8timetax ,

			(SELECT sum(tax) as Total_today_9timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='9' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='9' and status='confirm' )x group by merchant_id ) as Total_today_9timetax ,

			(SELECT sum(tax) as Total_today_10timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_today_10timetax ,

			(SELECT sum(tax) as Total_today_11timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_today_11timetax ,

			(SELECT sum(tax) as Total_today_12timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_today_12timetax ,

			(SELECT sum(tax) as Total_today_13timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_today_13timetax ,

			(SELECT sum(tax) as Total_today_14timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_today_14timetax ,

			(SELECT sum(tax) as Total_today_15timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_today_15timetax ,

			(SELECT sum(tax) as Total_today_16timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_today_16timetax ,

			(SELECT sum(tax) as Total_today_17timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_today_17timetax ,

			(SELECT sum(tax) as Total_today_18timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_today_18timetax ,

			(SELECT sum(tax) as Total_today_19timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_today_19timetax ,

			(SELECT sum(tax) as Total_today_20timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_today_20timetax ,

			(SELECT sum(tax) as Total_today_21timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_today_21timetax ,

			(SELECT sum(tax) as Total_today_22timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_today_22timetax ,

			(SELECT sum(tax) as Total_today_23timetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_today_23timetax ,

			(SELECT avg(amount) as Total_today_0timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='0' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='0' and status='confirm' )x group by merchant_id ) as Total_today_0timefee ,

			(SELECT avg(amount) as Total_today_1timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='1' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='1' and status='confirm' )x group by merchant_id ) as Total_today_1timefee ,

			(SELECT avg(amount) as Total_today_2timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='2' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='2' and status='confirm' )x group by merchant_id ) as Total_today_2timefee ,

			(SELECT avg(amount) as Total_today_3timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='3' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='3' and status='confirm' )x group by merchant_id ) as Total_today_3timefee ,

			(SELECT avg(amount) as Total_today_4timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='4' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='4' and status='confirm' )x group by merchant_id ) as Total_today_4timefee ,

			(SELECT avg(amount) as Total_today_5timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='5' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='5' and status='confirm' )x group by merchant_id ) as Total_today_5timefee ,

			(SELECT avg(amount) as Total_today_6timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='6' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='6' and status='confirm' )x group by merchant_id ) as Total_today_6timefee ,

			(SELECT avg(amount) as Total_today_7timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='7' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='7' and status='confirm' )x group by merchant_id ) as Total_today_7timefee ,

			(SELECT avg(amount) as Total_today_8timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='8' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='8' and status='confirm' )x group by merchant_id ) as Total_today_8timefee ,

			(SELECT avg(amount) as Total_today_9timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='9' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='9' and status='confirm' )x group by merchant_id ) as Total_today_9timefee ,

			(SELECT avg(amount) as Total_today_10timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='10' and status='confirm' )x group by merchant_id ) as Total_today_10timefee ,

			(SELECT avg(amount) as Total_today_11timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='11' and status='confirm' )x group by merchant_id ) as Total_today_11timefee ,

			(SELECT avg(amount) as Total_today_12timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='12' and status='confirm' )x group by merchant_id ) as Total_today_12timefee ,

			(SELECT avg(amount) as Total_today_13timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='13' and status='confirm' )x group by merchant_id ) as Total_today_13timefee ,

			(SELECT avg(amount) as Total_today_14timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='14' and status='confirm' )x group by merchant_id ) as Total_today_14timefee ,

			(SELECT avg(amount) as Total_today_15timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='15' and status='confirm' )x group by merchant_id ) as Total_today_15timefee ,

			(SELECT avg(amount) as Total_today_16timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='16' and status='confirm' )x group by merchant_id ) as Total_today_16timefee ,

			(SELECT avg(amount) as Total_today_17timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='17' and status='confirm' )x group by merchant_id ) as Total_today_17timefee ,

			(SELECT avg(amount) as Total_today_18timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='18' and status='confirm' )x group by merchant_id ) as Total_today_18timefee ,

			(SELECT avg(amount) as Total_today_19timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='19' and status='confirm' )x group by merchant_id ) as Total_today_19timefee ,

			(SELECT avg(amount) as Total_today_20timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='20' and status='confirm' )x group by merchant_id ) as Total_today_20timefee ,

			(SELECT avg(amount) as Total_today_21timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='21' and status='confirm' )x group by merchant_id ) as Total_today_21timefee ,

			(SELECT avg(amount) as Total_today_22timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='22' and status='confirm' )x group by merchant_id ) as Total_today_22timefee ,

			(SELECT avg(amount) as Total_today_23timefee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$date' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$last_date' and HOUR(cast(CONVERT_TZ(add_date, '-5:00', '$Zone__GMT') as time(0)))='23' and status='confirm' )x group by merchant_id ) as Total_today_23timefee
		");

		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;
		//print_r($getDashboardData);  die();

		$getA_merchantData = $this->admin_model->select_request_id('merchant', $merchant_id);
		if ($getA_merchantData->csv_Customer_name > 0) {$name = 'name';} else { $name = '';};

		//$refundeddata=$this->admin_model->get_refund_data($date,$last_date,$merchant_id);
		//print_r($refundeddata); die;

		$package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
		$mem = array();
		$member = array();
		$sum = 0;
		$sum_ref = 0;
		$sum_discount = 0;
		foreach ($package_data as $each) {
			if ($each->status == 'Chargeback_Confirm') {
				// $package['Amount'] = '-$'.$each->amount;
				// $sum_ref+= $each->amount;
				// if($each->type='straight'){ $package['Type'] = 'INV-Refunded'; 	} else { $package['Type'] = $each->type.'-Refunded'; }
			} else {
				$package['Amount'] = '$' . $each->amount;
				$sum += $each->amount;
				if ($each->type = 'straight') {$package['Type'] = 'INV';} else { $package['Type'] = $each->type;}
			}
			$package['Tax'] = '$'. $each->tax;
			$package['Card'] = Ucfirst($each->card_type);

			$package['Date'] = $each->date_c;
			$package['Reference'] = $each->reference;
			$package['Tip'] ='$'. $each->tip_amount;
			$package['Discount'] = 0;
			$sum_discount += 0;
			if ($getA_merchantData->csv_Customer_name > 0) {$package['Name'] = "--";}
			$package['Items'] = $each->items;
			$mem[] = $package;
		}
		$data['item'] = $mem;

		$package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);

		$mem1 = array();
		$member1 = array();
		$sum1 = 0;
		$sum_ref1 = 0;
		$sum_discount1 = 0;
		foreach ($package_data1 as $each) {
			if ($each->status == 'Chargeback_Confirm') {
				// $package1['Amount'] = '-$'.$each->amount;
				// $sum_ref1+= $each->amount;
				// if($each->type='straight'){ $package1['Type'] = 'INV-Refunded'; 	} else { $package1['Type'] = $each->type.'-Refunded'; }
			} else {
				$package1['Amount'] = '$' . $each->amount;
				$sum1 += $each->amount;
				if ($each->type = 'straight') {$package1['Type'] = 'INV';} else { $package1['Type'] = $each->type;}
			}
			$package1['Tax'] = '$' . $each->tax;
			$package1['Card'] = Ucfirst($each->card_type);

			$package1['Date'] = $each->date_c;
			$package1['Reference'] = $each->reference;
			$package1['Tip'] = 0;
			$package1['Discount'] = 0;
			$sum_discount1 += 0;
			if ($getA_merchantData->csv_Customer_name > 0) {$package1['Name'] = "--";}
			$package1['Items'] = $each->items;
			$mem1[] = $package1;
		}
		$data['item1'] = $mem1;

		$package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
       
		$mem2 = array();
		$member2 = array();
		//if($each->type='straight'){ $package1['Type'] = 'INV-Refunded'; 	} else { $package1['Type'] = $each->type.'-Refunded'; }
		$sum2 = 0;
		$sum_ref2 = 0;
		$sum_discount2 = 0;
		$sum_tip=0;
		foreach ($package_data2 as $each) {
			$package2['Amount'] = '$' . $each->amount;
			$sum2 += $each->amount;
			$package2['Type'] = strtoupper($each->type);
			$package2['Tax'] = '$' . $each->tax;
			$package2['Tip'] = '$' . $each->tip_amount;
			$package2['Card'] = Ucfirst($each->card_type);
			//$package2['Type'] = strtoupper($each->type);
			$package2['Date'] = $each->date_c;
			$package2['Reference'] = $each->reference;
			$package2['Discount'] = isset($each->discount) ? number_format($each->discount) : 0;
			$sum_tip = isset($each->tip) ? number_format(($sum_tip + $each->tip),2) : number_format(($sum_tip + 0),2);
			$sum_discount2 += isset($each->discount) ? $each->discount : 0;
			if ($getA_merchantData->csv_Customer_name > 0) {$package2['Name'] = $each->name;}
			$package2['Items'] = $each->items;
			$mem2[] = $package2; 
		}
		$data['item2'] = $mem2;
		// for refund 
		$package_data3 = $this->admin_model->get_refund_data($date, $last_date, $merchant_id);
		$mem3 = array();
		$member3 = array();
		$sum3 = 0;
		$sum_ref3 = 0;
		$sum_discount3 = 0;
		$tip_refunded=0;
		foreach ($package_data3 as $each) {
			if ($each->status == 'Chargeback_Confirm') {
				$refund_amount = (!empty($each->refund_amount) ? $each->refund_amount : $each->amount);
				$refund['Amount'] = '-$' . $each->refund_amount; // amount
				$refund['Tax'] = '$' . $each->tax;
				$refund['Tip'] = '-$' . $each->tip_amount;
				$refund['Card'] = Ucfirst($each->card_type);
				if ($each->type == 'straight') {
					$refund['Type'] = 'INV-Refunded';
				} else {
					$refund['Type'] = strtoupper($each->type) . "-Refunded";
				}
				$refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
				$refund['Reference'] = $each->reference;
				$refund['Refund Transaction Id'] = $each->refund_transaction_id;
				
				$refund['Discount'] = 0;
				if ($getA_merchantData->csv_Customer_name > 0) {$refund['Name'] = "--";}
				$refund['Items'] = "--";
				$mem3[] = $refund;
				$sum_ref3 += $refund_amount;//$each->refund_amount;
			   	$tip_refunded += $each->tip_amount;
				$sum_discount3 += 0;
			}
		}

		$data['item_refund'] = $mem3;
		//print_r($mem3);   die(); 
		// $totalsum = number_format($sum + $sum1 + $sum2, 2);
		// $totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
		$totalDiscountsum = number_format($sum_discount + $sum_discount1 + $sum_discount2 + $sum_discount3, 2);
		$totalsum = number_format($sum + $sum1 + $sum2, 2);
		$totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
		if ($getA_merchantData->csv_Customer_name > 0) {
			$data['item4'] = [
				[
					"Amount" => "",
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Name" => '',
					"Items" => '',
				],
				[
					"Amount" => "Sum Amount = $ " . $totalsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Name" => '',
					"Items" => '',
				],
		        [
					"Amount" => "Refund Amount = $ " . $totalsumr,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Name" => '',
					"Items" => '',
				],
				[
					"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3), 2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Name" => '',
					"Items" => '',
				],
				[
					"Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Name" => '',
					"Items" => '',
				],
				[
					"Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Name"=>'',
					"Items" => ''
				]
			];
		} else {
			$data['item4'] = [
				[
					"Amount" => "",
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Items" => '',
				],
				[
					"Amount" => "Sum Amount = $ " . $totalsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Items" => '',
				],

				[
					"Amount" => "Refund Amount = $ " . $totalsumr,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Items" => '',
				],
				[
					"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2+$sum_ref3), 2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Items" => '',
				],
				[
					"Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Items" => '',
				],
				[
					"Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount" => '',
					"Items" => ''
				]
			];
		}

		$data['item5'] = [
			[
				"Sum_Amount" => $totalsum,
				"is_Customer_name" => $getA_merchantData->csv_Customer_name,
				"Refund_Amount" => $totalsumr,
				"Total_Amount" => number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2+$sum_ref3), 2),
				"Total_Discount_Amount" => $totalDiscountsum,
			],

		];
		//print_r($data['item4']);die();
		// print_r($data);die();
		// print_r($data);die();

		// $data['item3']= json_encode(array_merge($data['item'],$data['item1'],$data['item2'],$data['item4'],$data['item5']));
		//print_r($data);  die();
		$arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']); //$data['item_refund']
		array_multisort(array_column($arr, 'Date'), SORT_DESC, $arr);
		$data['item3'] = json_encode(array_merge($arr, $data['item4']));
		$data['item5'] = json_encode($data['item5']);

		//$data['item3']= json_encode(array_merge($data['item'],$data['item1'],$data['item2'],$data['item4']));
		//$data['item3']=json_encode(array_merge($arr, $data['item4']));
		//$data['item3']=json_encode(array_merge($arr, $data['item5']));
                //echo '<pre>';print_r($data);die();
		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('merchant/sale_dash', $data);
			// return $this->load->view('merchant/sale', $data);
		}

	}

	public function download_reports() {
		$employee = 0;
        // echo '<pre>';print_r($this->session->userdata());die();
        if ($this->session->userdata('employee_id')) {
            $merchant_id = $this->session->userdata('employee_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
        }
        
		$timezone = $this->session->userdata('time_zone');
		if ($timezone == "") {$timezone = "America/Chicago";}
		$Zone__GMT = $this->tz_list($timezone);
		date_default_timezone_set($timezone);

		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));

		$start = $this->input->post('start');
		$end = $this->input->post('end');

		if ($start != '') {
			$last_date = $start;
			$date = $end;
		} else {
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
		}
		$merchant_data = $this->profile_model->get_merchant_details_new($merchant_id);

		if ( $this->input->post('search_Submit') || $this->input->post('excel_export') || $this->input->post('csv_export') ) {
			
			$start_date =  $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$status = '';
			if ($start_date != '') {
			 	$start_date = $start_date;
			 	$end_date = $end_date;

			} else {
				$start_date = date("Y-m-d", strtotime("-29 days"));
				$end_date = date("Y-m-d");
			}
			
			$package_data_cash = $this->Inventory_graph_model_new->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CASH');
			// echo '<pre>';print_r($package_data_cash);die;
			$package_data_check = $this->Inventory_graph_model_new->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CHECK');
			//$package_data_online = $this->Inventory_graph_model->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','ONLINE');
			$package_data_splite = $this->Inventory_graph_model_new->get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			
			$package_data_online = $this->Inventory_graph_model_new->get_search_merchant_pos_type_online($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_card = $this->Inventory_graph_model_new->get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_card_invoice = $this->Inventory_graph_model_new->get_search_merchant_pos_type_card_invoice($start_date, $end_date, $status, $merchant_id,$employee, 'customer_payment_request');

			$package_data_card_invoice_re = $this->Inventory_graph_model_new->get_search_merchant_pos_type_card_invoice_re($start_date, $end_date, $status, $merchant_id,$employee, 'recurring_payment');
			//end new
			
			$package_data_cash_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CASH');
			
			$package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'customer_payment_request');
			$package_data_total_count_invoice_re = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'recurring_payment');
			
			//$package_data_total_pending = $this->Inventory_graph_model->get_search_merchant_pending_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_pos_tip = $this->Inventory_graph_model->get_search_merchant_tip_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_invoice_tip = $this->Inventory_graph_model->get_search_merchant_tip_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');

			$package_data_total_pos_tax = $this->Inventory_graph_model->get_search_merchant_tax_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_invoice_tax = $this->Inventory_graph_model->get_search_merchant_tax_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');

			$package_data_total_pos_other_charges = $this->Inventory_graph_model->get_search_merchant_other_charges_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			//print_r($package_data_total_pos_other_charges); 
			$package_data_total_invoice_other_charges = $this->Inventory_graph_model->get_search_merchant_other_charges_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');
			//print_r($package_data_total_invoice_other_charges); die();
			$package_data_check_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CHECK');
			//$package_data_online_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','ONLINE');
			$package_data_online_total = $this->Inventory_graph_model->get_search_merchant_pos_total_online($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_card_total = $this->Inventory_graph_model->get_search_merchant_pos_total_card($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			
			$refund_data_search = $this->Inventory_graph_model_new->get_full_refund_data_search_pdf($start_date, $end_date,'pos', $merchant_id);
			$refund_data_search_invoice = $this->Inventory_graph_model_new->get_full_refund_data_search_pdf($start_date, $end_date,'customer_payment_request', $merchant_id);
			$refund_data_search_invoice_rec = $this->Inventory_graph_model_new->get_full_refund_data_search_pdf($start_date, $end_date,'recurring_payment', $merchant_id);
            $refund_data_cash = $this->Inventory_graph_model->get_full_refund_cash_check($start_date, $end_date,'pos',$merchant_id,'CASH');
            $refund_data_check = $this->Inventory_graph_model->get_full_refund_cash_check($start_date, $end_date,'pos',$merchant_id,'CHECK');
            $refund_data_card = $this->Inventory_graph_model->get_full_refund_card($start_date, $end_date,'pos',$merchant_id);
            $refund_data_online = $this->Inventory_graph_model->get_full_refund_online($start_date, $end_date,'pos',$merchant_id);
             $refund_data_total_new = $this->Inventory_graph_model->get_full_refund_total_count_new($start_date, $end_date,$merchant_id);
			
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		}

		if ($this->input->post('search_Submit')) {
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "Transaction Report";
	        $title_head = '';
			$obj_pdf->SetTitle($title);
			//$obj_pdf->SetHeaderData($data['merchantdata'][0]['logo'], PDF_HEADER_LOGO_WIDTH, $title,$title_head);
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->AddPage();
		
			//$obj_pdf->SetPrintHeader(false);
			//$obj_pdf->setHeaderTemplateAutoreset(true);
			ob_start();
			
			$startdate = date('M  jS, Y', strtotime($start_date));
			$enddate = date('M  jS, Y', strtotime($end_date));
			$enddatee = date("M  jS, Y h:i A");
		
			$i = 0;
			$total_item = 0;
			$total_paid = 0;
			//foreach ($package_data_array as $aa_data) 
			//{
			//	$total = $aa_data['amount'];
				//$total_item = 	$i++;
				//$total_paid+= number_format(($total),2);
			//}
			
			$j = 0;
			$total_item_refund = 0;
			$total_paid_refund = 0;
			 
			// print_r($refund_data_search); die();
			foreach ($refund_data_search as $ab_data) {
				$total = number_format(($ab_data['refund_amount']),2);
				$total_item_refund = 	$j++;
				$total_paid_refund+= $ab_data['refund_amount'];
			}
		
			$jj = 0;
			$total_item_refund_invoice = 0;
			$total_paid_refund_invoice = 0;
			foreach ($refund_data_search_invoice as $ab_data) {
				$total = number_format(($ab_data['refund_amount']),2);
				$total_item_refund_invoice = 	$j++;
				$total_paid_refund_invoice+= $ab_data['refund_amount'];
			}
			$jjj = 0;
			$total_item_refund_invoice_rec = 0;
			$total_paid_refund_invoice_rec = 0;
			foreach ($refund_data_search_invoice_rec as $abc_data) {
				$total = number_format(($abc_data['refund_amount']),2);
				$total_item_refund_invoice_rec = 	$j++;
				$total_paid_refund_invoice_rec+= $abc_data['refund_amount'];
			}
			
			$k = 0;
			$total_item_cash = 0;
			$total_paid_cash = 0;
			foreach ($package_data_cash as $a_data) {
				$total = number_format(($a_data['amount']),2);
				$total_item_cash = 	$k++;
				$total_paid_cash+= $total;
				
				if ($a_data['status'] == 'pending') {
					$status =  ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
					 $status = 'Paid';
				} elseif ($a_data['status'] == 'declined') {
					$status = ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'Refund') {
					 $status = ' Refund ';
				}		
	            $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
				
				$count++;
			
				$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
	  
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
					$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
					// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
		            // $date->setTimezone(new DateTimeZone('America/Chicago'));
		            // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime);

				} else {
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
				$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));		
				$textcolors .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';
					}
					$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
				</tr>';
			}
			
			foreach ($package_data_splite as $a_data) {
				if ($a_data['status'] == 'pending') {
					$status =  ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
					 $status = 'Paid';
				} elseif ($a_data['status'] == 'declined') {
					$status = ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'Refund') {
					 $status = ' Refund ';
				}		
	            $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
	  
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)) {
					$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
					// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
		            // $date->setTimezone(new DateTimeZone('America/Chicago'));
		            // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				} else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
				$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
									
				$textcolors_Split .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['invoice_no'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
					<td width="10%" style="border-bottom:1px solid grey"></td>';
				
					$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
					<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
				</tr>';
				
				if ($a_data['transaction_type'] == "split") {
					$merchant_id = $this->session->userdata('merchant_id');
					$this->db->where('invoice_no', $a_data['invoice_no']);
					$this->db->where('merchant_id ', $merchant_id);
					$query = $this->db->get('pos');
					$split_payment = $query->result_array();
					
					//$parent = $this->Inventory_model->get_full_inventory_reportdata($data['start_date'],$data['end_date'],$merchant_id,$a_data['main_item_id']);
					foreach ($split_payment as $split_payment_Data) {
						if ($split_payment_Data['status'] == 'pending') {
							$status =  ucfirst($split_payment_Data['status']) ;
						} elseif ($split_payment_Data['status'] == 'confirm' ||  $split_payment_Data['status'] == 'Chargeback_Confirm' ) {
							 $status = 'Paid';
						} elseif ($split_payment_Data['status'] == 'declined') {
							$status = ucfirst($split_payment_Data['status']) ;
						} elseif ($split_payment_Data['status'] == 'Refund') {
							 $status = ' Refund ';
						}		
		                $receipt = (isset($split_payment_Data['repeiptmethod']) && !empty($split_payment_Data['repeiptmethod']))? $split_payment_Data['repeiptmethod'] : 'No Receipt';	
						 	$pyadate=str_replace("-","",$split_payment_Data['express_transactiondate']);
						$paytime=str_replace(":","",$split_payment_Data['express_transactiontime']);
						$each->express_transactiontimezone; //  UTC-05:00:00
		      
						$PayYear=substr($pyadate,0,4); 
						$PayMonth=substr($pyadate,4,2); 
						$PayDay=substr($pyadate,6,2); 

						$PayHours=substr($paytime,0,2); 
						$PayMinut=substr($paytime,2,2); 
						$PaySecond=substr($paytime,4,2);
						
						if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
							$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
							// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
			                // $date->setTimezone(new DateTimeZone('America/Chicago'));
			                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
						    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
						} else {
							$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
						}
						$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));

						if($split_payment_Data['reference_numb_opay']!='0' && $split_payment_Data['reference_numb_opay']!=''){
		                    $split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']).'('.$split_payment_Data['reference_numb_opay'].')';
						} else {
		                   $split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']);
						}

						$textcolors_Split .= '<tr>
							<td width="21%" align="centre"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$split_payment_Data['transaction_id'].'</td>
							<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.($split_payment_Data['card_type']).'</td>
							<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['transaction_type']).'</td>
							<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($split_payment_Data['amount'], 2).'</td>';
						
		                    if ($merchant_data[0]->csv_Customer_name > 0) {
								$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$split_payment_Data['name'].'</td>';
							} else {
								$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';
							}
							$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
							<td width="8%" style=" border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
							<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['name']).'</td>
		                </tr>';
					}
				}
			}
			
			$l = 0;
	        $total_item_check = 0;
			$total_paid_check = 0;
			foreach ($package_data_check as $a_data) {
				$total = number_format(($a_data['amount']),2);
	            $total_item_check = 	$l++;
				$total_paid_check+= $total;
					
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						 $status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						 $status = ' Refund ';
					}		
	                $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
	                 
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
	      
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
					
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
		                // $date->setTimezone(new DateTimeZone('America/Chicago'));
		                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
					    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
									
				  	$textcolors_Check .= '<tr>
						<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
						<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
						<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
						<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
						if ($merchant_data[0]->csv_Customer_name > 0) {
							$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
						} else {
							$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';
						}
					
						$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
						<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
						<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Check .= '<tr> <td colspan="7">No Data</td></tr>';
				}
			}
			
			$m = 0;
	        $total_item_online = 0;
			$total_paid_online = 0;
			foreach ($package_data_online as $a_data) {
				$total = number_format(($a_data['amount']),2);
	            $total_item_online = 	$m++;
			    $total_paid_online+= $total;
					
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						 $status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						 $status = ' Refund ';
					}		
	                $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
	      
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
					
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
		                // $date->setTimezone(new DateTimeZone('America/Chicago'));
		                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
					    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
				
					if($a_data['reference_numb_opay']!='0' && $a_data['reference_numb_opay']!=''){
	                    // $a_data['card_type'] = $a_data['reference_numb_opay'];
	                    $a_data['card_type'] = ucfirst($a_data['card_type']).'('.$a_data['reference_numb_opay'].')';
					} else {
	                   	$a_data['card_type'] = ucfirst($a_data['card_type']);
					}		
				  	$textcolors_Online .= '<tr>
						<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
						<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.($a_data['card_type']).'</td>
						<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
						
						<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
						
						if ($merchant_data[0]->csv_Customer_name > 0) {
							$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
						}else {
							$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';				 }
					
						$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
						<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
						<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Online .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}

			$n = 0;
	        $total_item_card = 0;
			$total_paid_card = 0;
		
			foreach ($package_data_card as $a_data) {
				$total = number_format(($a_data['amount']),2);
                $total_item_card = 	$n++;
			    $total_paid_card+= $total;
			
				if(!empty($a_data)) {
				 	if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
                 	$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
	      
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
				
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
		                // $date->setTimezone(new DateTimeZone('America/Chicago'));
		                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    		$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
								
			  		$textcolors_Card .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
			
					$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			foreach ($package_data_card_invoice as $a_data) {
				if(!empty($a_data)) {
			 		if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						 $status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']);
					} elseif ($a_data['status'] == 'Refund') {
						 $status = ' Refund ';
					}
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
								
				  	$textcolors_Card .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">Invoice</td>
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';
					}
			
					$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';

				} else {
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			foreach ($package_data_card_invoice_re as $a_data) {
				if(!empty($a_data)) {
				 	if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
									
				  	$textcolors_Card .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">R-Invoice</td>
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			$o = 0;
	        $total_item_card = 0;
			$total_paid_card = 0;
			foreach ($refund_data_search as $a_data) {
				$total = number_format(($a_data['refund_amount']),2);
                $total_item_card = 	$o++;
			    $total_paid_card+= $a_data['refund_amount'];
			
				if(!empty($a_data)) {
				 	if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						 $status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						 $status = ' Refund ';
					}
	                $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
	                $TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
									
				  	$textcolors_Refund .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
				
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}

			foreach ($refund_data_search_invoice as $a_data) {
				if(!empty($a_data)) {
			 		if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						 $status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						 $status = ' Refund ';
					}
                 	$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
                	$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
								
				  	$textcolors_Refund .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">Invoice</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
				
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}

			foreach ($refund_data_search_invoice_rec as $a_data) {
			
				if(!empty($a_data)) {
			 		if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						 $status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						 $status = ' Refund ';
					}
                 	$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
                 
                 	$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
				
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
								
				  	$textcolors_Refund .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">R-Invoice</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
				
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}

			$html = '
			<style>
				.borderr {
						border: 2px solid red;
						padding: 10px;
						border-radius: 25px;
				}
			</style>
			<table cellpadding="3">
				<tr>
					<td align="left" colspan="4">
						<span style="font-size: 25px;font-weight:900;">'.ucfirst($data['merchantdata'][0]['business_name']).'</span> 
						<br >&nbsp;&nbsp;<span style="font-size: 15px;font-weight:800;">Transactions across all terminals  </span>
					 </td>
					 <td>
					 </td>
					<td  align="left" colspan="3"> 
					</td>
				</tr>
				<tr>
					<td  align="left" colspan="5"> 
						&nbsp;Report Period: '.$enddate.', 12:00 am -- '.$startdate.', 11:59 pm
						<br>&nbsp;&nbsp; Generated -   '.$enddatee.'
					</td>
   					<td align="left" colspan="2"></td>
			 		<td></td>
				</tr>
				<tr>
					<td  align="left" colspan="4"> 
						&nbsp;Total # Transactions: '.(($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'])-($refund_data_total_new[0]['id'])).'
					</td>
   					<td align="left" colspan="3"></td>
			 		<td></td>
				</tr>
			</table>
	
			<hr style="padding-top:20px;padding-bottom:20px;">
			<h2>Summary</h2>
			<table cellpadding="2" style="border: 1px solid grey;">
				<tr>
					<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Net Total</h3> </td>
					<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount'])),2).'</h3> </td>
				</tr>
				<tr>
					<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Other Charges</h3> </td>
					<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2).' </h3> </td>
				</tr>
				<tr>
					<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Gross Total</h3> </td>
					<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount']+$package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount'])),2).'</h3> </td>
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Purchases ('.($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']).')</h3> </td>
					<td align="right">  <h3> $'.number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']) -($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount'])),2).' </h3> </td>
					
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Refunds ('.($refund_data_total_new[0]['id']).')</h3> </td>
					<td align="right" > <h3>$'.number_format(($refund_data_total_new[0]['amount']),2).' </h3> </td>
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Tips ('.($package_data_total_pos_tip[0]['id']+$package_data_total_invoice_tip[0]['id']).')</h3> </td>
					<td align="right" > <h3>$'.number_format(($package_data_total_pos_tip[0]['amount']+$package_data_total_invoice_tip[0]['amount']),2).' </h3> </td>
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Tax ('.($package_data_total_pos_tax[0]['id']+$package_data_total_invoice_tax[0]['id']).')</h3> </td>
					<td align="right" > <h3>$'.number_format(($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount']),2).' </h3> </td>
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Other Charges ('.($package_data_total_pos_other_charges[0]['id']+$package_data_total_invoice_other_charges[0]['id']).')</h3> </td>
					<td align="right" > <h3>$'.number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2).' </h3> </td>
				</tr>
			</table>
	
			<hr style="padding-top:20px;padding-bottom:20px;">
			<h2>Breakdown</h2>
			<table cellpadding="2" style="border: 1px solid grey;">
				<tr>
					<td  style="border-bottom:1px solid grey;padding: 10px; border-radius:10px;" align="left"> <h3>Net Total</h3> </td>
					<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount']),2).'</h3> </td>
					
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Total Purchases ('.($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']-$refund_data_total_new[0]['id']).')</h3> </td>
					<td align="right">  <h3> $'.number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$refund_data_total_new[0]['amount']),2).' </h3></td>
					
				</tr>
				
				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Cash Purchases ('.($package_data_cash_total[0]['id']-$refund_data_cash[0]['id']).')</span> </td>
					<td align="right"> <span style="font-size: 8px;"> $'.number_format(($package_data_cash_total[0]['amount']-$refund_data_cash[0]['amount']),2).' </span> </td>
					
				</tr>
				
				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Card Purchases ('.($package_data_card_total[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'] -$refund_data_card[0]['id']).')</span> </td>
					<td align="right">  <span style="font-size: 8px;"> $'.number_format(($package_data_card_total[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$refund_data_card[0]['amount']),2).' </span> </td>
					
				</tr>
				
				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Check Purchases ('.($package_data_check_total[0]['id']-$refund_data_check[0]['id']).')</span> </td>
					<td align="right">  <span style="font-size: 8px;"> $'.number_format(($package_data_check_total[0]['amount']-$refund_data_check[0]['amount']),2).' </span> </td>
					
				</tr>
				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Other Purchases ('.($package_data_online_total[0]['id']-$refund_data_online[0]['id']).')</span> </td>
					<td align="right">  <span style="font-size: 8px;"> $'.number_format(($package_data_online_total[0]['amount']-$refund_data_online[0]['amount']),2).' </span> </td>
					
				</tr>
				
				<tr>
					<td style="padding: 10px;" align="left"> <h3>Refunds ('.($refund_data_total_new[0]['id']).')</h3> </td>
					<td align="right" > <h3>$'.number_format(($refund_data_total_new[0]['amount']),2).' </h3> </td>
					
				</tr>
				
				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Cash Refunds ('.$refund_data_cash[0]['id'].')</span> </td>
					<td align="right" > <span style="font-size: 8px;">$'.number_format($refund_data_cash[0]['amount'],2).'  </span> </td>
					
				</tr>
				
				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Card Refunds ('.($refund_data_card[0]['id']+$jj+$jjj).')</span> </td>
					<td align="right" > <span style="font-size: 8px;">$'.number_format(($refund_data_card[0]['amount']+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2).' </span> </td>
					
				</tr>

				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Check Refunds ('.$refund_data_check[0]['id'].')</span> </td>
					<td align="right" > <span style="font-size: 8px;">$'.number_format($refund_data_check[0]['amount'],2).'  </span> </td>
					
				</tr>

				<tr>
					<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Other Refunds ('.$refund_data_online[0]['id'].')</span> </td>
					<td align="right" > <span style="font-size: 8px;">$'.number_format($refund_data_online[0]['amount'],2).'  </span> </td>
					
				</tr>
			</table>

			<h3 style="padding: 10px;">Cash Purchases</h3>
			<table cellpadding="2">
				<tr >
					<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
	               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
				   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
					<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
					<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
					<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				</tr>
				'.$textcolors.'
			</table> ';
	
			$html_Check = '
			<h3 style="padding: 10px;">Check Purchases</h3>
			<table cellpadding="2">
				<tr>
					<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
	               	<th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
				   	<th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
					<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
					<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
					<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				</tr>
				'.$textcolors_Check.'
			</table> ';
	
			$html_Online = '
			<h3 style="padding: 10px;">Other Purchases</h3>
			<table   cellpadding="2">
				<tr >
					<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
	               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
				   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
					<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
					<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
					<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				</tr>

				'.$textcolors_Online.'
			</table> ';
	
			$html_Card = '
			<h3 style="padding: 10px;">Card Purchases</h3>
			<table   cellpadding="2">
				<tr >
					<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
	               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
				   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
					<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
					<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
					<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				</tr>

				'.$textcolors_Card.'
			</table> ';
	
			$html_Split= '
			<h3 style="padding: 10px;">Split Purchases</h3>
			<table   cellpadding="2">
				<tr >
					<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
	               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
				   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
					<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
					<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
					<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				</tr>

				'.$textcolors_Split.'
			</table> ';
	
			$html_Refund= '
			<h3 style="padding: 10px;">Refund Purchases</h3>
			<table   cellpadding="2">
				<tr >
					<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
	               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
				   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
					<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
					<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
					<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
					<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				</tr>

				'.$textcolors_Refund.'
			</table> ';
	
			ob_end_clean();
			$obj_pdf->writeHTML($html, true, false, true, false, '');
			$obj_pdf->writeHTML($html_Check, true, false, true, false, '');
			$obj_pdf->writeHTML($html_Online, true, false, true, false, '');
			$obj_pdf->writeHTML($html_Card, true, false, true, false, '');
			$obj_pdf->writeHTML($html_Split, true, false, true, false, '');
			$obj_pdf->writeHTML($html_Refund, true, false, true, false, '');
			$obj_pdf->setDestination('Transaction Report', 0, '');
			$obj_pdf->Bookmark('Transaction Report', 0, 0, '', 'BI', array(128,0,0), -1, '#Transaction Report');
			$obj_pdf->Cell(0, 10, 'Transaction Report', 0, 1, 'L');
			$obj_pdf->Output('Transaction Report.pdf', 'D');
		}

		if ($this->input->post('excel_export') || $this->input->post('csv_export')) {
			$this->load->library('Excel');
			
			$startdate = date('M  jS, Y', strtotime($start_date));
			$enddate = date('M  jS, Y', strtotime($end_date));
			$enddatee = date("M  jS, Y h:i A");
		
			$i = 0;
			$total_item = 0;
			$total_paid = 0;
		
			$j = 0;
			$total_item_refund = 0;
			$total_paid_refund = 0;
			foreach ($refund_data_search as $ab_data) {
				$total = number_format(($ab_data['refund_amount']),2);
				$total_item_refund = $j++;
				$total_paid_refund+= $ab_data['refund_amount'];
			}
			
			$jj = 0;
			$total_item_refund_invoice = 0;
			$total_paid_refund_invoice = 0;
			foreach ($refund_data_search_invoice as $ab_data) {
				$total = number_format(($ab_data['refund_amount']),2);
				$total_item_refund_invoice = $j++;
				$total_paid_refund_invoice+= $ab_data['refund_amount'];
			}

			$jjj = 0;
			$total_item_refund_invoice_rec = 0;
			$total_paid_refund_invoice_rec = 0;
			foreach ($refund_data_search_invoice_rec as $abc_data) {
				$total = number_format(($abc_data['refund_amount']),2);
				$total_item_refund_invoice_rec = $j++;
				$total_paid_refund_invoice_rec+= $abc_data['refund_amount'];
			}

			$k = 0;
			$total_item_cash = 0;
			$total_paid_cash = 0;
			foreach ($package_data_cash as $a_data) {
				$total = number_format(($a_data['amount']),2);
				$total_item_cash = 	$k++;
				$total_paid_cash+= $total;
				
				if ($a_data['status'] == 'pending') {
					$status =  ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
					$status = 'Paid';
				} elseif ($a_data['status'] == 'declined') {
					$status = ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'Refund') {
					$status = ' Refund ';
				}		
				$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				$count++;
		
				$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
					$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
					// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
					// $date->setTimezone(new DateTimeZone('America/Chicago'));
					// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
					$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				} else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
				$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));		
				$textcolors .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
					$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
				} else {
					$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
				}
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
				</tr>';
			}
		
			foreach ($package_data_splite as $a_data) {
				if ($a_data['status'] == 'pending') {
					$status =  ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
					$status = 'Paid';
				} elseif ($a_data['status'] == 'declined') {
					$status = ucfirst($a_data['status']) ;
				} elseif ($a_data['status'] == 'Refund') {
					$status = ' Refund ';
				}
				$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
					$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
					// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
					// $date->setTimezone(new DateTimeZone('America/Chicago'));
					// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
					$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				} else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
				$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
				$textcolors_Split .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['invoice_no'].'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="10%" style="border-bottom:1px solid grey"></td>';
				
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
				</tr>';
			
				if ($a_data['transaction_type'] == "split") {
					$merchant_id = $this->session->userdata('merchant_id');
					$this->db->where('invoice_no', $a_data['invoice_no']);
					$this->db->where('merchant_id ', $merchant_id);
					$query = $this->db->get('pos');
					$split_payment = $query->result_array();
			
					//$parent = $this->Inventory_model->get_full_inventory_reportdata($data['start_date'],$data['end_date'],$merchant_id,$a_data['main_item_id']);
					foreach ($split_payment as $split_payment_Data) {
						if ($split_payment_Data['status'] == 'pending') {
							$status =  ucfirst($split_payment_Data['status']) ;
						} elseif ($split_payment_Data['status'] == 'confirm' ||  $split_payment_Data['status'] == 'Chargeback_Confirm' ) {
							$status = 'Paid';
						} elseif ($split_payment_Data['status'] == 'declined') {
							$status = ucfirst($split_payment_Data['status']) ;
						} elseif ($split_payment_Data['status'] == 'Refund') {
							$status = ' Refund ';
						}
						$receipt = (isset($split_payment_Data['repeiptmethod']) && !empty($split_payment_Data['repeiptmethod']))? $split_payment_Data['repeiptmethod'] : 'No Receipt';	
							$pyadate=str_replace("-","",$split_payment_Data['express_transactiondate']);
						$paytime=str_replace(":","",$split_payment_Data['express_transactiontime']);
						$each->express_transactiontimezone; //  UTC-05:00:00
			
						$PayYear=substr($pyadate,0,4); 
						$PayMonth=substr($pyadate,4,2); 
						$PayDay=substr($pyadate,6,2); 

						$PayHours=substr($paytime,0,2); 
						$PayMinut=substr($paytime,2,2); 
						$PaySecond=substr($paytime,4,2);
						
						if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
							$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
							// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
							// $date->setTimezone(new DateTimeZone('America/Chicago'));
							// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
							$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
						} else {
							$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
						}
						$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));

						if($split_payment_Data['reference_numb_opay']!='0' && $split_payment_Data['reference_numb_opay']!=''){
							$split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']).'('.$split_payment_Data['reference_numb_opay'].')';
						} else {
							$split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']);
						}
						$textcolors_Split .= '<tr>
							
						<td width="21%" align="centre"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$split_payment_Data['transaction_id'].'</td>
						<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.($split_payment_Data['card_type']).'</td>
						<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['transaction_type']).'</td>
						<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($split_payment_Data['amount'], 2).'</td>
						';
				
						if ($merchant_data[0]->csv_Customer_name > 0) {
							$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$split_payment_Data['name'].'</td>';
						} else {
							$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
						}
						$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
						<td width="8%" style=" border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
						<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['name']).'</td>
						</tr>';
					}
		 		}
			}
		
			$l = 0;
			$total_item_check = 0;
			$total_paid_check = 0;
			foreach ($package_data_check as $a_data) {
				$total = number_format(($a_data['amount']),2);
				$total_item_check = 	$l++;
				$total_paid_check+= $total;
				
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
		
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
					
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
						// $date->setTimezone(new DateTimeZone('America/Chicago'));
						// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
						$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
					$textcolors_Check .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
					$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
												}else
												{
					$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
												}
					
					$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
						<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Check .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			$m = 0;
			$total_item_online = 0;
			$total_paid_online = 0;
			foreach ($package_data_online as $a_data) {
				$total = number_format(($a_data['amount']),2);
                $total_item_online = 	$m++;
			    $total_paid_online+= $total;
				
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
		
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
				
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
						// $date->setTimezone(new DateTimeZone('America/Chicago'));
						// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
						$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
		
					if($a_data['reference_numb_opay']!='0' && $a_data['reference_numb_opay']!=''){
						// $a_data['card_type'] = $a_data['reference_numb_opay'];
						$a_data['card_type'] = ucfirst($a_data['card_type']).'('.$a_data['reference_numb_opay'].')';
					} else {
						$a_data['card_type'] = ucfirst($a_data['card_type']);
					}
					$textcolors_Online .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Online .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
	
			$n = 0;
			$total_item_card = 0;
			$total_paid_card = 0;
			foreach ($package_data_card as $a_data) {
				$total = number_format(($a_data['amount']),2);
                $total_item_card = 	$n++;
			    $total_paid_card+= $total;
			
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
		
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
					
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
						// $date->setTimezone(new DateTimeZone('America/Chicago'));
						// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
						$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  		$textcolors_Card .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
			
					$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			foreach ($package_data_card_invoice as $a_data) {
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
					$textcolors_Card .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">Invoice</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			foreach ($package_data_card_invoice_re as $a_data) {
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
											
					$textcolors_Card .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">R-Invoice</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
		
			$o = 0;
			$total_item_card = 0;
			$total_paid_card = 0;
			foreach ($refund_data_search as $a_data) {
				$total = number_format(($a_data['refund_amount']),2);
				$total_item_card = 	$o++;
				$total_paid_card+= $total;
			
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
					
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
			
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
		
							
					$textcolors_Refund .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
	
			foreach ($refund_data_search_invoice as $a_data) {
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
					
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
					
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
									
					$textcolors_Refund .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">Invoice</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}

			foreach ($refund_data_search_invoice_rec as $a_data) {
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
					
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
					
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
							
					$textcolors_Refund .= '<tr>
					<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
					
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
					<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">R-Invoice</td>
					
					<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
					
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
					} else {
						$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
					}
					$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
					<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
					</tr>';
				} else {
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
			}
			// echo $data['merchantdata'][0]['business_name'];die;

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Column Width
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Transactions across all terminals');
			// set Row
			$rowCount = 2;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Report Period: '.$enddate.', 12:00 am -- '.$startdate.', 11:59 pm');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Generated - '.$enddatee);
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Total # Transactions: '.(($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'])-($refund_data_total_new[0]['id'])) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Summary
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Summary');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Net Total');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec)),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Purchases ('.($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Refunds ('.($j+$jj+$jjj).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Tips ('.($package_data_total_pos_tip[0]['id']+$package_data_total_invoice_tip[0]['id']).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_total_pos_tip[0]['amount']+$package_data_total_invoice_tip[0]['amount']),2) );
			$rowCount++;									$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Tax ('.($package_data_total_pos_tax[0]['id']+$package_data_total_invoice_tax[0]['id']).')');			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount']),2) );			$rowCount++;									$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Other Charges ('.($package_data_total_pos_other_charges[0]['id']+$package_data_total_invoice_other_charges[0]['id']).')');			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2) );			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Breakdown
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Breakdown');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Net Total');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Total Purchases ('.($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']-$j+$jj+$jjj).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Cash Purchases ('.($package_data_cash_total[0]['id']-$refund_data_cash[0]['id']).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_cash_total[0]['amount']-$refund_data_cash[0]['amount']),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Card Purchases ('.($package_data_card_total[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'] -$refund_data_card[0]['id']).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_card_total[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$refund_data_card[0]['amount']),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Check Purchases ('.($package_data_check_total[0]['id']-$refund_data_check[0]['id']).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_check_total[0]['amount']-$refund_data_check[0]['amount']),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Other Purchases ('.($package_data_online_total[0]['id']-$refund_data_online[0]['id']).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($package_data_online_total[0]['amount']-$refund_data_online[0]['amount']),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Refunds ('.($j+$jj+$jjj).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Cash Refunds ('.$refund_data_cash[0]['id'].')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format($refund_data_cash[0]['amount'],2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Card Refunds ('.($refund_data_card[0]['id']+$jj+$jjj).')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format(($refund_data_card[0]['amount']+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Check Refunds ('.$refund_data_check[0]['id'].')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format($refund_data_check[0]['amount'],2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Other Refunds ('.$refund_data_online[0]['id'].')');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , '$'. number_format($refund_data_online[0]['amount'],2) );
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Cash Purchases
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Cash Purchases');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Transaction id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , 'Payment Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Transaction Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , 'Name on Card');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , 'Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , 'Employee');
			$rowCount++;

			foreach ($package_data_cash as $a_data) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['transaction_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , ucfirst($a_data['transaction_type']));
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['amount'], 2));
				if ($merchant_data[0]->csv_Customer_name > 0) {
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
				$rowCount++;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Check Purchases
			// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Check Purchases');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Transaction id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , 'Payment Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Transaction Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , 'Name on Card');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , 'Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , 'Employee');
			$rowCount++;

			foreach ($package_data_check as $a_data) {
				if(!empty($a_data)) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['transaction_id']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , ucfirst($a_data['transaction_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['amount'], 2));
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');	 
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'No Data');
					$rowCount++;
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Other Purchases
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Other Purchases');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Transaction id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , 'Payment Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Transaction Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , 'Name on Card');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , 'Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , 'Employee');
			$rowCount++;

			foreach ($package_data_online as $a_data) {
				$total = number_format(($a_data['amount']),2);
                $total_item_online = $m++;
				$total_paid_online+= $total;
				
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
					$paytime=str_replace(":","",$a_data['express_transactiontime']);
					$each->express_transactiontimezone; //  UTC-05:00:00
		
					$PayYear=substr($pyadate,0,4); 
					$PayMonth=substr($pyadate,4,2); 
					$PayDay=substr($pyadate,6,2); 

					$PayHours=substr($paytime,0,2); 
					$PayMinut=substr($paytime,2,2); 
					$PaySecond=substr($paytime,4,2);
				
					if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
						$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
						// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
						// $date->setTimezone(new DateTimeZone('America/Chicago'));
						// $convertedDatetime=$date->format('Y-m-d H:i:s'); 
						$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
					} else {
						$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
					}
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
		
					if($a_data['reference_numb_opay']!='0' && $a_data['reference_numb_opay']!=''){
						// $a_data['card_type'] = $a_data['reference_numb_opay'];
						$a_data['card_type'] = ucfirst($a_data['card_type']).'('.$a_data['reference_numb_opay'].')';
					} else {
						$a_data['card_type'] = ucfirst($a_data['card_type']);
					}

					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['transaction_id']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , $a_data['card_type']);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , ucfirst($a_data['transaction_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['amount'], 2) );
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']) );
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'No Data');
					$rowCount++;
				}
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Card Purchases
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Card Purchases');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Transaction id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , 'Payment Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Transaction Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , 'Name on Card');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , 'Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , 'Employee');
			$rowCount++;

			foreach ($package_data_card as $a_data) {
				if(!empty($a_data)) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['transaction_id']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , ucfirst($a_data['transaction_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['amount'], 2));
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
					}
					
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No Data');
					$rowCount++;
				}
			}
		
			foreach ($package_data_card_invoice as $a_data) {
				if(!empty($a_data)) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['transaction_id']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Invoice');
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['amount'], 2));
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No Data');
					$rowCount++;
				}
			}
		
			foreach ($package_data_card_invoice_re as $a_data) {
				if(!empty($a_data)) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['transaction_id']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'R-Invoice');
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['amount'], 2));
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No Data');
					$rowCount++;
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Split Purchases
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Split Purchases');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Transaction id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , 'Payment Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Transaction Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , 'Name on Card');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , 'Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , 'Employee');
			$rowCount++;

			foreach ($package_data_splite as $a_data) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , $a_data['invoice_no']);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
				$rowCount++;

				if ($a_data['transaction_type'] == "split") {
					$merchant_id = $this->session->userdata('merchant_id');
					$this->db->where('invoice_no', $a_data['invoice_no']);
					$this->db->where('merchant_id ', $merchant_id);
					$query = $this->db->get('pos');
					$split_payment = $query->result_array();
			
					foreach ($split_payment as $split_payment_Data) {
						if ($split_payment_Data['status'] == 'pending') {
							$status =  ucfirst($split_payment_Data['status']) ;
						} elseif ($split_payment_Data['status'] == 'confirm' ||  $split_payment_Data['status'] == 'Chargeback_Confirm' ) {
							$status = 'Paid';
						} elseif ($split_payment_Data['status'] == 'declined') {
							$status = ucfirst($split_payment_Data['status']) ;
						} elseif ($split_payment_Data['status'] == 'Refund') {
							$status = ' Refund ';
						}
						$receipt = (isset($split_payment_Data['repeiptmethod']) && !empty($split_payment_Data['repeiptmethod']))? $split_payment_Data['repeiptmethod'] : 'No Receipt';	
							$pyadate=str_replace("-","",$split_payment_Data['express_transactiondate']);
						$paytime=str_replace(":","",$split_payment_Data['express_transactiontime']);
						$each->express_transactiontimezone; //  UTC-05:00:00
			
						$PayYear=substr($pyadate,0,4); 
						$PayMonth=substr($pyadate,4,2); 
						$PayDay=substr($pyadate,6,2); 

						$PayHours=substr($paytime,0,2); 
						$PayMinut=substr($paytime,2,2); 
						$PaySecond=substr($paytime,4,2);
						
						if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
							$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;
							$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
						} else {
							$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
						}
						$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));

						if($split_payment_Data['reference_numb_opay']!='0' && $split_payment_Data['reference_numb_opay']!=''){
							$split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']).'('.$split_payment_Data['reference_numb_opay'].')';
						} else {
							$split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']);
						}

						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '  '.$split_payment_Data['transaction_id']);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ($split_payment_Data['card_type']));
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , ucfirst($split_payment_Data['transaction_type']) );
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($split_payment_Data['amount'], 2));
						if ($merchant_data[0]->csv_Customer_name > 0) {
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $split_payment_Data['name']);
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
						}
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($split_payment_Data['name']) );
						$rowCount++;
					}
		 		}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , '');
			$rowCount++;

			// Refund Purchases
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Refund Purchases');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , 'Transaction id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , 'Payment Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Transaction Type');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , 'Name on Card');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , 'Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , 'Employee');
			$rowCount++;

			foreach ($refund_data_search as $a_data) {
				$total = number_format(($a_data['refund_amount']),2);
				$total_item_card = 	$o++;
				$total_paid_card+= $total;
			
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
					
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
			
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
		
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['refund_transaction']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , ucfirst($a_data['transaction_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['refund_amount'], 2));
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No Data');
					$rowCount++;
				}
			}

			foreach ($refund_data_search_invoice as $a_data) {
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
					
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
					
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));

					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount , ' '.$a_data['refund_transaction']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount , ucfirst($a_data['card_type']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount , 'Invoice');
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount , '$ '.number_format($a_data['refund_amount'], 2));
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount , '');
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount , $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount , $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount , ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No Data');
					$rowCount++;
				}
			}

			foreach ($refund_data_search_invoice_rec as $a_data) {
				if(!empty($a_data)) {
					if ($a_data['status'] == 'pending') {
						$status =  ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
						$status = 'Paid';
					} elseif ($a_data['status'] == 'declined') {
						$status = ucfirst($a_data['status']) ;
					} elseif ($a_data['status'] == 'Refund') {
						$status = ' Refund ';
					}
					$receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
					
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
					
					$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
							
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ' '.$a_data['refund_transaction']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, ucfirst($a_data['card_type']) );
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'R-Invoice');
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '$ '.number_format($a_data['refund_amount'], 2) );
					if ($merchant_data[0]->csv_Customer_name > 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $a_data['name']);
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '');
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $newdate);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $status);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, ucfirst($a_data['mname']));
					$rowCount++;
				} else {
					// $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No Data');
					$rowCount++;
				}
			}
			// echo $_POST['excel_export'];die;

			if ($_POST['excel_export']) {
				// echo 'excel';die;
				$fileName = 'Transaction Report Excel.xlsx';

				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save($fileName);
				// download file
				header("Content-Type: application/vnd.ms-excel");
				redirect(site_url().$fileName);
			}
			if ($_POST['csv_export']) {
				// echo 'csv';die;
				$fileName = 'Transaction Report CSV';

				// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}
		}
	}

}

?>
