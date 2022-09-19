<?php
    // ini_set('MAX_EXECUTION_TIME', '-1');
    // ini_set('memory_limit','2048M');
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Dashboard extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->library('form_validation');
			$this->load->model('admin_model'); 
			$this->load->model('session_checker_model');
			$this->load->library('email');
			$this->load->library('twilio');

			if (!$this->session_checker_model->chk_session()) {
				redirect('admin');
			}

			date_default_timezone_set("America/Chicago");
			//ini_set('display_errors', 1);
		    //    error_reporting(E_ALL);
		}
		public function index() {
			$data["title"] = "Admin Panel";
			$merchant_id = $this->session->userdata('merchant_id');
			
	       
			$today2 = date("Y");
			$last_year = date("Y", strtotime("-1 year"));
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$employee = $this->input->post('employee');
			//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
			//$date1 = date("Y-m-d");
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
				$sub_merchant_id = 0;
			} elseif ($employee == 'merchant') {
				$sub_merchant_id = 0;
			} else {
				$sub_merchant_id = $employee;
			}

			$getDashboard = $this->db->query("SELECT 
			
					(SELECT count(id) as TotalOrders from customer_payment_request where  status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalOrders, 
					(SELECT count(id) as TotalPosorder from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalPosorder,
					(SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalpendingOrders,
					(SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = '" . $date . "') as NewTotalOrders, 
					(SELECT count(id) as TotalPosordernew from pos where date_c = '" . $date . "') as TotalPosordernew,
					(SELECT count(id) as TotalFailOrders from customer_payment_request where (status='declined' ||  status='block') and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' ) as TotalFailOrders, 
					(SELECT count(id) as TotalPosFailorder from pos where (status='declined' ||  status='block') and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalPosFailorder,
	             

	                (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
	                (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
	                (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS,

	                (SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request  where  month = '01' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '01' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '01' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljan   ,
	                (SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request  where  month = '02' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '02' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '02' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalfeb   ,
					(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request  where  month = '03' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '03' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '03' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalmarch   ,
					(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request  where  month = '04' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '04' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '04' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalaprl   ,
					(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request  where  month = '05' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '05' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '05' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalmay   ,
					(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request  where  month = '06' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '06' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '06' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljune   ,
					(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request  where  month = '07' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '07' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '07' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljuly   ,
					(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request  where  month = '08' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '08' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '08' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalaugust   ,
					(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request  where  month = '09' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '09' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '09' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalsep   ,
					(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request  where  month = '10' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '10' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '10' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaloct   ,
					(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request  where  month = '11' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '11' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalnov   ,
					(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request  where  month = '12' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '12' and year = '" . $today2 . "' and status='confirm' union all SELECT month,amount from pos  where  month = '12' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaldec ,
					(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request  where  month = '01' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '01' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '01' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljanf   ,
					(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request  where  month = '02' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '02' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '02' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalfebf   ,
					(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request  where  month = '03' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '03' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '03' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalmarchf   ,
					(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request  where  month = '04' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '04' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '04' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalaprlf   ,
					(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request  where  month = '05' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '05' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '05' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalmayf   ,

	                (SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request  where  month = '06' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '06' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '06' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljunef   ,
	                (SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request  where  month = '07' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '07' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '07' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljulyf   ,
	                (SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request  where  month = '08' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '08' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '08' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalaugustf   ,
	                (SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request  where  month = '09' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '09' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '09' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalsepf   ,
	                (SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request  where  month = '10' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '10' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '10' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaloctf   ,
	                (SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request  where  month = '11' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '11' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalnovf   ,
	                (SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request  where  month = '12' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '12' and year = '" . $today2 . "' and status='confirm' union all SELECT month,fee from pos  where  month = '12' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaldecf   ,
					(SELECT sum(tax) as Totaljantax from ( SELECT month,tax from customer_payment_request  where  month = '01' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '01' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '01' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljantax   ,
					(SELECT sum(tax) as Totalfebtax from ( SELECT month,tax from customer_payment_request  where  month = '02' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '02' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '02' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalfebtax   ,
					(SELECT sum(tax) as Totalmarchtax from ( SELECT month,tax from customer_payment_request  where  month = '03' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '03' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '03' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalmarchtax   ,
					(SELECT sum(tax) as Totalaprltax from ( SELECT month,tax from customer_payment_request  where  month = '04' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '04' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '04' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalaprltax   ,
					(SELECT sum(tax) as Totalmaytax from ( SELECT month,tax from customer_payment_request  where  month = '05' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '05' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '05' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalmaytax   ,
					(SELECT sum(tax) as Totaljunetax from ( SELECT month,tax from customer_payment_request  where  month = '06' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '06' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '06' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljunetax   ,
					(SELECT sum(tax) as Totaljulytax from ( SELECT month,tax from customer_payment_request  where  month = '07' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '07' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '07' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaljulytax   ,
					(SELECT sum(tax) as Totalaugusttax from ( SELECT month,tax from customer_payment_request  where  month = '08' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '08' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '08' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalaugusttax   ,
					(SELECT sum(tax) as Totalseptax from ( SELECT month,tax from customer_payment_request  where  month = '09' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '09' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '09' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalseptax   ,
					(SELECT sum(tax) as Totalocttax from ( SELECT month,tax from customer_payment_request  where  month = '10' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '10' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '10' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalocttax   ,
					(SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request  where  month = '11' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '11' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totalnovtax   ,
					(SELECT sum(tax) as Totaldectax from ( SELECT month,tax from customer_payment_request  where  month = '12' and year = '" . $today2 . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '12' and year = '" . $today2 . "' and status='confirm' union all SELECT month,tax from pos  where  month = '12' and year = '" . $today2 . "' and status='confirm' )x group by month ) as Totaldectax   ,
	                (SELECT sum(amount) as Totalbjan from ( SELECT month,amount from customer_payment_request  where  month = '01' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '01' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '01' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbjan   ,
	                (SELECT sum(amount) as Totalbfeb from ( SELECT month,amount from customer_payment_request  where  month = '02' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '02' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '02' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbfeb   ,
	                (SELECT sum(amount) as Totalbmarch from ( SELECT month,amount from customer_payment_request  where  month = '03' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '03' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '03' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbmarch   ,
	                (SELECT sum(amount) as Totalbaprl from ( SELECT month,amount from customer_payment_request  where  month = '04' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '04' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '04' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbaprl   ,
	                (SELECT sum(amount) as Totalbmay from ( SELECT month,amount from customer_payment_request  where  month = '05' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '05' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '05' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbmay   ,
	                (SELECT sum(amount) as Totalbjune from ( SELECT month,amount from customer_payment_request  where  month = '06' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '06' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '06' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbjune   ,
	                (SELECT sum(amount) as Totalbjuly from ( SELECT month,amount from customer_payment_request  where  month = '07' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '07' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '07' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbjuly   ,
	                (SELECT sum(amount) as Totalbaugust from ( SELECT month,amount from customer_payment_request  where  month = '08' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '08' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '08' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbaugust   ,
	                (SELECT sum(amount) as Totalbsep from ( SELECT month,amount from customer_payment_request  where  month = '09' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '09' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '09' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbsep   ,
	                (SELECT sum(amount) as Totalboct from ( SELECT month,amount from customer_payment_request  where  month = '10' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '10' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '10' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalboct   ,
	                (SELECT sum(amount) as Totalbnov from ( SELECT month,amount from customer_payment_request  where  month = '11' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '11' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '11' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbnov   ,
	                (SELECT sum(amount) as Totalbdec from ( SELECT month,amount from customer_payment_request  where  month = '12' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from recurring_payment  where  month = '12' and year = '" . $last_year . "' and status='confirm' union all SELECT month,amount from pos  where  month = '12' and year = '" . $last_year . "' and status='confirm' ) x group by month ) as Totalbdec ,
	                (SELECT sum(fee) as Totalbjanf from ( SELECT month,fee from customer_payment_request  where  month = '01' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '01' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '01' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbjanf   ,
	                (SELECT sum(fee) as Totalbfebf from ( SELECT month,fee from customer_payment_request  where  month = '02' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '02' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '02' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbfebf   ,
	                (SELECT sum(fee) as Totalbmarchf from ( SELECT month,fee from customer_payment_request  where  month = '03' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '03' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '03' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbmarchf   ,
	                (SELECT sum(fee) as Totalbaprlf from ( SELECT month,fee from customer_payment_request  where  month = '04' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '04' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '04' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbaprlf   ,
	                (SELECT sum(fee) as Totalbmayf from ( SELECT month,fee from customer_payment_request  where  month = '05' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '05' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '05' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbmayf   ,
	                (SELECT sum(fee) as Totalbjunef from ( SELECT month,fee from customer_payment_request  where  month = '06' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '06' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '06' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbjunef   ,
	                (SELECT sum(fee) as Totalbjulyf from ( SELECT month,fee from customer_payment_request  where  month = '07' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '07' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '07' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbjulyf   ,
	                (SELECT sum(fee) as Totalbaugustf from ( SELECT month,fee from customer_payment_request  where  month = '08' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '08' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '08' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbaugustf   ,
	                (SELECT sum(fee) as Totalbsepf from ( SELECT month,fee from customer_payment_request  where  month = '09' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '09' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '09' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbsepf   ,
	                (SELECT sum(fee) as Totalboctf from ( SELECT month,fee from customer_payment_request  where  month = '10' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '10' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '10' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalboctf   ,
	                (SELECT sum(fee) as Totalbnovf from ( SELECT month,fee from customer_payment_request  where  month = '11' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '11' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '11' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbnovf   ,
	                (SELECT sum(fee) as Totalbdecf from ( SELECT month,fee from customer_payment_request  where  month = '12' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,fee from recurring_payment  where  month = '12' and year = '" . $last_year . "' and status='confirm' union all SELECT month,fee from pos  where  month = '12' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbdecf   ,
					(SELECT sum(tax) as Totalbjantax from ( SELECT month,tax from customer_payment_request  where  month = '01' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '01' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '01' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbjantax   ,
					(SELECT sum(tax) as Totalbfebtax from ( SELECT month,tax from customer_payment_request  where  month = '02' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '02' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '02' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbfebtax   ,
					(SELECT sum(tax) as Totalbmarchtax from ( SELECT month,tax from customer_payment_request  where  month = '03' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '03' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '03' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbmarchtax   ,
					(SELECT sum(tax) as Totalbaprltax from ( SELECT month,tax from customer_payment_request  where  month = '04' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '04' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '04' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbaprltax   ,
					(SELECT sum(tax) as Totalbmaytax from ( SELECT month,tax from customer_payment_request  where  month = '05' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '05' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '05' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbmaytax   ,
					(SELECT sum(tax) as Totalbjunetax from ( SELECT month,tax from customer_payment_request  where  month = '06' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '06' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '06' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbjunetax   ,
					(SELECT sum(tax) as Totalbjulytax from ( SELECT month,tax from customer_payment_request  where  month = '07' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '07' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '07' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbjulytax   ,
					(SELECT sum(tax) as Totalbaugusttax from ( SELECT month,tax from customer_payment_request  where  month = '08' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '08' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '08' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbaugusttax   ,
					(SELECT sum(tax) as Totalbseptax from ( SELECT month,tax from customer_payment_request  where  month = '09' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '09' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '09' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbseptax   ,
					(SELECT sum(tax) as Totalbocttax from ( SELECT month,tax from customer_payment_request  where  month = '10' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment  where  month = '10' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '10' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbocttax   ,
					(SELECT sum(tax) as Totalbnovtax from ( SELECT month,tax from customer_payment_request  where  month = '11' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment where     month = '11' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '11' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbnovtax   ,
					(SELECT sum(tax) as Totalbdectax from ( SELECT month,tax from customer_payment_request where     month = '12' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from recurring_payment where     month = '12' and year = '" . $last_year . "' and status='confirm' union all SELECT month,tax from pos  where  month = '12' and year = '" . $last_year . "' and status='confirm' )x group by month ) as Totalbdectax
	                   ");
			$getDashboardData = $getDashboard->result_array();
			$data['getDashboardData'] = $getDashboardData;
			$data1 = array();
			// $data['item'] = $this->admin_model->data_get_where_gg($last_date, $date,'confirm',$merchant_id,$employee,'customer_payment_request' );
			$package_data = $this->admin_model->data_get_where_dow("customer_payment_request", $date, $last_date);

			$mem = array();
			$member = array();
			foreach ($package_data as $each) {

				$package['amount'] = $each->amount;
				$package['tax'] = $each->tax;
				if ($each->type = 'straight') {
					$package['type'] = 'Invoice';
				} else {
					$package['type'] = $each->type;
				}

				$package['date'] = $each->date_c;

				$package['reference'] = $each->reference;

				$mem[] = $package;
			}
			$data['item'] = $mem;

			$data['item1'] = $this->admin_model->data_get_where_dow("recurring_payment", $date, $last_date);
			$data['item2'] = $this->admin_model->data_get_where_dow("pos", $date, $last_date);
			$data['item3'] = json_encode(array_merge($data['item'], $data['item1'], $data['item2']));

			//  $data['highchart'] = $this->admin_model->get_details($merchant_id);
			// echo json_encode($data['highchart']);
			if ($this->input->post('start') != '') {
				echo json_encode($data);
				die();
			} else {
				return $this->load->view('admin/dashboard', $data);
			}

		}
    	public function index1() {
			$data["title"] = "Admin Panel";
			$today2 = date("Y");
			$last_year = date("Y", strtotime("-1 year"));
			$last_date = date("Y-m-d", strtotime("-29 days"));
			$date = date("Y-m-d");
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			if(!empty($this->input->post('emplo')) ) { $employee=$this->input->post('emplo'); }else{ $employee = $this->input->post('employee');  }
			//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
			//$date1 = date("Y-m-d");
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
	              (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
	              (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
	              (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
				 "); 
	          $DashboardCountData = $this->db->query("SELECT 
	             ( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalOrders, 
				 ( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalPosorder ,
				 ( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  status='pending'  ) as TotalpendingOrders,
				 ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND date_c = CURDATE()) as NewTotalOrders, 
				 ( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  date_c = CURDATE()) as TotalPosordernew ,
	             ( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				 ( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
						 "); 

			} elseif ($employee == 'merchant') {
				$getDashboard = $this->db->query("SELECT
	              (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
	              (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
	              (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
				 ");
				 $DashboardCountData = $this->db->query("SELECT 
	             ( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalOrders, 
				 ( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm'  ) as TotalPosorder ,
				 ( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  status='pending'  ) as TotalpendingOrders,
				 ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND date_c = CURDATE()) as NewTotalOrders, 
				 ( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  date_c = CURDATE()) as TotalPosordernew ,
	             ( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				 ( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
						 "); 

			} else {
				$getDashboard = $this->db->query("SELECT
	              (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' and merchant_id='" . $employee . "'  ) as TotalAmount ,
	              (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' and merchant_id='" . $employee . "') as TotalAmountRe ,
	              (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' and merchant_id='" . $employee . "') as TotalAmountPOS
				 ");
				$DashboardCountData = $this->db->query("SELECT 
				( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND status='confirm'  ) as TotalOrders, 
				( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "' AND status='confirm'  ) as TotalPosorder ,
				( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND  status='pending'  ) as TotalpendingOrders,
				( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND date_c = CURDATE()) as NewTotalOrders, 
				( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "'  AND  date_c = CURDATE()) as TotalPosordernew ,
				( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id='" . $employee . "' AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  AND merchant_id='" . $employee . "' AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
						");
			}
	        //    echo $this->db->last_query(); die('Die'); 
			$getDashboardData = $getDashboard->result_array();
			$data['getDashboardData'] = $getDashboardData;
			$DashboardCountData=$DashboardCountData->result_array();
			// print_r($DashboardCountData);  die('Die'); 
	       //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
		    $widgets_data = array(
			'TotalConfirmOrders'=>$DashboardCountData[0]['TotalOrders']+$DashboardCountData[0]['TotalPosorder'],
			'TotalpendingOrders'=>$DashboardCountData[0]['TotalpendingOrders'], 
			'NewTotalOrders'=>$DashboardCountData[0]['NewTotalOrders']+$DashboardCountData[0]['TotalPosordernew'], 
			'TotalFaildOrders' => $DashboardCountData[0]['TotalFailOrders']+$DashboardCountData[0]['TotalPosFailorder'],
	          ); 
			$data['widgets_data'] = $widgets_data;
		

			//$getA_merchantData=$this->admin_model->select_request_id('merchant',$employee); 
			$getA_merchantData->csv_Customer_name=1; //  its static for  admin and subadmin section 

		   if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 

		   $data1 = array();
		   $package_data = $this->admin_model->data_get_where_down_admin("customer_payment_request", $date, $last_date, $employee);
		  
		   $mem = array();
		   $member = array();
		   $sum = 0;
		   $sum_ref = 0;
		   $sum_discount=0;
		   foreach ($package_data as $each) {
			   $package['Amount'] = '$' . $each->amount;
			   $sum += $each->amount;
			   $package['Tax'] = '$' . $each->tax;
			   $package['Card'] = Ucfirst($each->card_type);
			   if ($each->type == 'straight') {
				   $package['Type'] = 'INV';
			   } else {
				   $package['Type'] = $each->type;
			   }
			   $package['Date'] = $each->add_date;
			   $package['Reference'] = $each->reference;
			   $package['Discount'] =0;
			   $package['Tip'] =$each->tip;
			  if($getA_merchantData->csv_Customer_name > 0 ){ $package['Name'] = "--";} 
			   $package['Items'] =   $each->items;
			   $sum_discount+=0;
			   $mem[] = $package;
			   // if ($each->status == 'Chargeback_Confirm') {
			   // 	$refund['Amount'] = '-$' . $each->amount;
			   // 	$refund['Tax'] = '$' . $each->tax;
			   // 	$refund['Card'] = Ucfirst($each->card_type);
			   // 	if ($each->type == 'straight') {
			   // 		$refund['Type'] = 'INV-Refunded';
			   // 	} else {
			   // 		$refund['Type'] = $each->type . "-Refunded";
			   // 	}
			   // 	$refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
			   // 	$refund['Reference'] = $each->reference;
			   // 	$mem[] = $refund;
			   // 	$sum_ref += $each->amount;
			   // }
		   }
		   $data['item'] = $mem;
		   $package_data1 = $this->admin_model->data_get_where_down_admin("recurring_payment", $date, $last_date, $employee);
		   $mem1 = array();
		   $member1 = array();
		   $sum1 = 0;
		   $sum_ref1 = 0;
		   $sum_discount1=0;
		   foreach ($package_data1 as $each) {
			   if ($each->status == 'Chargeback_Confirm') {
				   $package1['Amount'] = '-$' . $each->amount;
				   $sum_ref1 += $each->amount;
			   } else {
				   $package1['Amount'] = '$' . $each->amount;
				   $sum1 += $each->amount;
			   }
			   $package1['Tax'] = '$' . $each->tax;
			   $package1['Card'] = Ucfirst($each->card_type);
			   if ($each->type = 'recurring') {
				   $package1['Type'] = 'INV';
			   } else {
				   $package1['Type'] = $each->type;
			   }
			   $package1['Date'] = $each->add_date;
			   $package1['Reference'] = $each->reference;
			   $package1['Discount'] =0;
			    $package1['Tip'] =0;
			   if($getA_merchantData->csv_Customer_name > 0 ){ $package1['Name'] = "--";} 
			   $package1['Items'] =   $each->items;
			   $sum_discount1+=0;
			   $mem1[] = $package1;
		   }
		   $data['item1'] = $mem1;
		   $package_data2 = $this->admin_model->data_get_where_down_admin("pos", $date, $last_date, $employee);
		   $mem2 = array();
		   $member2 = array();
		   $sum2 = 0;
		   $sum_ref2 = 0;
		   $sum_discount2=0;
		   $sum_tip=0;
		   foreach ($package_data2 as $each) {

			   $package2['Amount'] = '$' . $each->amount;
			   $sum2 += $each->amount;
			   $package2['Tax'] = '$' . $each->tax;
			   $package2['Tip'] = '$' . $each->tip;
			   $package2['Card'] = Ucfirst($each->card_type);
			   $package2['Type'] = strtoupper($each->type);
			   $package2['Date'] = $each->add_date;
			   $package2['Reference'] = $each->reference;
			   $package2['Discount'] = $each->discount; 
			   $sum_discount2+=number_format($each->discount);
			   $sum_tip= number_format(($sum_tip + $each->tip),2);
			   if($getA_merchantData->csv_Customer_name > 0 ){ $package2['Name'] = $each->name;} 
			   $package2['Items'] = $each->items;
			   $mem2[] = $package2;
			   // if ($each->status == 'Chargeback_Confirm') {
			   // 	$refund['Amount'] = '-$' . $each->amount;
			   // 	$refund['Tax'] = '$' . $each->tax;
			   // 	$refund['Card'] = Ucfirst($each->card_type);
			   // 	$refund['Type'] = strtoupper($each->type) . "-Refunded";
			   // 	$refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
			   // 	$refund['Reference'] = $each->reference;
			   // 	$mem2[] = $refund;
			   // 	$sum_ref2 += $each->amount;
			   // }
		   }
	   		$data['item2'] = $mem2;
	  		// print_r($mem2);  die; 
     		// for refund
		   $package_data3 = $this->admin_model->get_refund_data_admin($date, $last_date, $employee);
		   $mem3 = array();
		   $member3 = array();
		   $sum3 = 0;
		   $sum_ref3 = 0;
		   $sum_discount3=0;
		   $tip_refunded=0;
		   foreach ($package_data3 as $each) {
			   if ($each->status == 'Chargeback_Confirm') {
			       $refund_amount = (!empty($each->refund_amount)?$each->refund_amount:$each->amount);
				   $refund['Amount'] = '-$' .$refund_amount;
				   $refund['Tax'] = '$' . $each->tax;
				   $refund['Tip'] = '-$' . $each->tip_amount;
				   $refund['Card'] = Ucfirst($each->card_type);
				   if($each->type == 'straight') {
					   $refund['Type'] = 'INV-Refunded';
				   } else {
					   $refund['Type'] = strtoupper($each->type)."-Refunded";
				   }
				   $refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
				   $refund['Reference'] = $each->reference;
				   $refund['Discount'] ='0';
				   if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
				   $refund['Items'] =  '--';
				   $mem3[] = $refund;
				   $sum_ref3 += $refund_amount;//$each->refund_amount;
				   $tip_refunded += $each->tip_amount;
				   $sum_discount3+=0;
				   
			   }
		   }

	   		$data['item_refund'] = $mem3;


		   $totalDiscountsum = number_format($sum_discount + $sum_discount1 + $sum_discount2+$sum_discount3, 2);
		   $totalsum = number_format($sum + $sum1 + $sum2, 2);
		   $totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
	   	if($getA_merchantData->csv_Customer_name > 0 ){ 
				$data['item4'] = [
					[
						"Amount" => "",
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
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
						"Discount"=>'',
						"Name"=>'',
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
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					],
					[
						"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
						"Tax" => '',
						"Tip" => '',
						"Card" => '',
						"Type" => '',
						"Date" => '',
						"Reference" => '',
						"Discount"=>'',
						"Name"=>'',
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
						"Discount"=>'',
						"Name"=>'',
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
						"Discount"=>'',
						"Name"=>'',
						"Items" => '',
					]
				];
		}
		else
		{
			$data['item4'] = [
				[
					"Amount" => "",
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
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
					"Discount"=>'',
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
					"Discount"=>'',
					"Items" => '',
				],
				[
					"Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
					"Tax" => '',
					"Tip" => '',
					"Card" => '',
					"Type" => '',
					"Date" => '',
					"Reference" => '',
					"Discount"=>'',
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
						"Discount"=>'',
						"Name"=>'',
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
					"Discount"=>'',
					"Name"=>'',
					"Items" => '',
				]
			];
		}
	   
		$data['item5'] = [
			[
				"Sum_Amount" => $totalsum,
				"is_Customer_name"=>$getA_merchantData->csv_Customer_name,
				"Refund_Amount" => $totalsumr,
				"Total_Amount" => number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
				"Total_Discount_Amount"=>$totalDiscountsum
			]
		];
		$arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']);
		 array_multisort(array_map('strtotime',array_column($arr,'Date')),SORT_DESC, $arr);
// 		array_multisort(array_column($arr, 'Date'), SORT_DESC, $arr);    
	   
		$data['item3']=json_encode(array_merge($arr, $data['item4']));  
	   // $data['item3']=json_encode($data['item']);
		$data['item5']=json_encode($data['item5']);



		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('admin/dashboard', $data);
		}
	}
	function my_encrypt($string, $action = 'e') {
		// you may change these values to your own
		$secret_key = '1@#$%^&s6*';
		$secret_iv = '`~ @hg(n5%';
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'e') {
			$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
		} else if ($action == 'd') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	public function create_th()
	{
	    //    print_r($_POST); die;  
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$this->form_validation->set_rules('chkstatus[]', 'Merchant Assign', 'required');
			$this->form_validation->set_rules('Settings', 'Settings', 'required');

			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "block";

			$view_menu_permissions='';
            $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
            $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
			$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
			$view_menu_permissions .=$this->input->post('Funding') ? $this->input->post('Funding').',' : "";  
			
            $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
            $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurringRequest') ? $this->input->post('TRecurringRequest').',' : "";
			
			$view_menu_permissions .= $this->input->post('InvoiceTemplate') ? $this->input->post('InvoiceTemplate').',' : "";  
            $view_menu_permissions .= $this->input->post('Instore_MobileTemplate') ? $this->input->post('Instore_MobileTemplate').',' : "";  
			$view_menu_permissions .= $this->input->post('ReceiptTemplate') ? $this->input->post('ReceiptTemplate').',' : "";  
			$view_menu_permissions .= $this->input->post('RecurringTemplate') ? $this->input->post('RecurringTemplate').',' : "";
			$view_menu_permissions .= $this->input->post('RegistrationTemplate') ? $this->input->post('RegistrationTemplate').',' : "";

			
            $view_menu_permissions .= $this->input->post('Vie_Merchant') ? $this->input->post('Vie_Merchant').',' : "";  
			$view_menu_permissions .= $this->input->post('ViewSubuser') ? $this->input->post('ViewSubuser').',' : "";  
			
            $view_menu_permissions .= $this->input->post('SupportsRequest') ? $this->input->post('SupportsRequest').',' : "";  
			$view_menu_permissions .= $this->input->post('SaleRequest') ? $this->input->post('SaleRequest').',' : ""; 
			
			$view_menu_permissions .= $this->input->post('CreateSubadmin') ? $this->input->post('CreateSubadmin').',' : "";  
			$view_menu_permissions .= $this->input->post('ViewAllSubadmin') ? $this->input->post('ViewAllSubadmin').',' : ""; 
			
			$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : ""; 



			$chkstatus = $_POST['chkstatus'] ? $_POST['chkstatus'] : array();
			
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";
			$password = $this->my_encrypt($password1, 'e');

			if(count($chkstatus) > 0)
			{
               $assignMerchant=implode(',',$chkstatus);
			}
			else{
				$assignMerchant='';
			}
			//echo  $assignMerchant; die; 
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(

					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'password' => ($password),
					'assign_merchant'=>$assignMerchant,
					'view_permissions' => $view_permissions,
					'view_menu_permissions'=>$view_menu_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => $status
				);

				$id = $this->admin_model->insert_data("sub_admin", $data);
				//echo $this->db->last_query(); die; 
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		
	}

	public function create_agent()
	{
	    //    print_r($_POST); die;  
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[sub_admin.mob_no]');
			$this->form_validation->set_rules('chkstatus[]', 'Merchant Assign', 'required');
			$this->form_validation->set_rules('Settings', 'Settings', 'required');

			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "block";

			$view_menu_permissions='';
            $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
            $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
			$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
			$view_menu_permissions .=$this->input->post('Funding') ? $this->input->post('Funding').',' : "";  
			
            $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
            $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurringRequest') ? $this->input->post('TRecurringRequest').',' : "";
			
			$view_menu_permissions .= $this->input->post('InvoiceTemplate') ? $this->input->post('InvoiceTemplate').',' : "";  
            $view_menu_permissions .= $this->input->post('Instore_MobileTemplate') ? $this->input->post('Instore_MobileTemplate').',' : "";  
			$view_menu_permissions .= $this->input->post('ReceiptTemplate') ? $this->input->post('ReceiptTemplate').',' : "";  
			$view_menu_permissions .= $this->input->post('RecurringTemplate') ? $this->input->post('RecurringTemplate').',' : "";
			$view_menu_permissions .= $this->input->post('RegistrationTemplate') ? $this->input->post('RegistrationTemplate').',' : "";

			
            $view_menu_permissions .= $this->input->post('Vie_Merchant') ? $this->input->post('Vie_Merchant').',' : "";  
			$view_menu_permissions .= $this->input->post('ViewSubuser') ? $this->input->post('ViewSubuser').',' : "";  
			
            $view_menu_permissions .= $this->input->post('SupportsRequest') ? $this->input->post('SupportsRequest').',' : "";  
			$view_menu_permissions .= $this->input->post('SaleRequest') ? $this->input->post('SaleRequest').',' : ""; 
			
			$view_menu_permissions .= $this->input->post('CreateSubadmin') ? $this->input->post('CreateSubadmin').',' : "";  
			$view_menu_permissions .= $this->input->post('ViewAllSubadmin') ? $this->input->post('ViewAllSubadmin').',' : ""; 
			
			$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : ""; 



			$chkstatus = $_POST['chkstatus'] ? $_POST['chkstatus'] : array();
			
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";
			$password = $this->my_encrypt($password1, 'e');

			if(count($chkstatus) > 0)
			{
               $assignMerchant=implode(',',$chkstatus);
			}
			else{
				$assignMerchant='';
			}
			//echo  $assignMerchant; die; 
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(

					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'user_type' => 'agent',
					'password' => ($password),
					'assign_merchant'=>$assignMerchant,
					'view_permissions' => $view_permissions,
					'view_menu_permissions'=>$view_menu_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => $status
				);

				$id = $this->admin_model->insert_data("sub_admin", $data);
				//echo $this->db->last_query(); die; 
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		
	}

	public function create_new_subadmin() {
		$data['meta'] = "Create New Subadmin";
		$data['loc'] = "create_new_subadmin";
		$data['action'] = "Create New Subadmin";

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$password = $this->my_encrypt($password1, 'e');
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(

					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'password' => ($password),
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => 'active',
				);

				$id = $this->admin_model->insert_data("sub_admin", $data);
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		} else {

			$data['all_merchantList'] = $this->admin_model->get_package_details("");

			$this->load->view("admin/add_subadmin", $data);
		}

	}

	public function create_new_agent() {
		$data['meta'] = "Create New Agent";
		$data['loc'] = "create_new_agent";
		$data['action'] = "Create New Agent";

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			//$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mob_no]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[sub_admin.mob_no]');
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$password = $this->my_encrypt($password1, 'e');
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(

					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'user_type' => 'agent',
					'password' => ($password),
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => 'active',
				);

				$id = $this->admin_model->insert_data("sub_admin", $data);
                echo '200';
				//redirect("dashboard/all_subadmin");
			}
		} else {

			$data['all_merchantList'] = $this->admin_model->get_package_details("");

			$this->load->view("admin/add_agent", $data);
		}

	}
	public function update_subadmin()
	{
		

            // print_r($_POST);die;  
		    $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('chkstatus[]', 'Merchant Assign', 'required');
			$this->form_validation->set_rules('Settings', 'Settings', 'required');

			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                        //$mobile = preg_replace("/[\s-]/", "", $mobile);
                        //$mobile = preg_replace("/\(|\)/", "", $mobile);
                        //echo $mobile;die();
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";


			$status = $this->input->post('status') ? $this->input->post('status') : "block";

			$view_menu_permissions='';
            $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
            $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
			$view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
			$view_menu_permissions .=$this->input->post('Funding') ? $this->input->post('Funding').',' : "";  
			
            $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
            $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
			$view_menu_permissions .= $this->input->post('TRecurringRequest') ? $this->input->post('TRecurringRequest').',' : "";
			
			$view_menu_permissions .= $this->input->post('InvoiceTemplate') ? $this->input->post('InvoiceTemplate').',' : "";  
            $view_menu_permissions .= $this->input->post('Instore_MobileTemplate') ? $this->input->post('Instore_MobileTemplate').',' : "";  
			$view_menu_permissions .= $this->input->post('ReceiptTemplate') ? $this->input->post('ReceiptTemplate').',' : "";  
			$view_menu_permissions .= $this->input->post('RecurringTemplate') ? $this->input->post('RecurringTemplate').',' : "";
			$view_menu_permissions .= $this->input->post('RegistrationTemplate') ? $this->input->post('RegistrationTemplate').',' : "";

			
            $view_menu_permissions .= $this->input->post('Vie_Merchant') ? $this->input->post('Vie_Merchant').',' : "";  
			$view_menu_permissions .= $this->input->post('ViewSubuser') ? $this->input->post('ViewSubuser').',' : "";  
			
            $view_menu_permissions .= $this->input->post('SupportsRequest') ? $this->input->post('SupportsRequest').',' : "";  
			$view_menu_permissions .= $this->input->post('SaleRequest') ? $this->input->post('SaleRequest').',' : ""; 
			
			$view_menu_permissions .= $this->input->post('CreateSubadmin') ? $this->input->post('CreateSubadmin').',' : "";  
			$view_menu_permissions .= $this->input->post('ViewAllSubadmin') ? $this->input->post('ViewAllSubadmin').',' : ""; 
			
			$view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";



			$chkstatus = $_POST['chkstatus'] ? $_POST['chkstatus'] : array();
			// print_r($chkstatus); die();  
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";
			$password = $this->my_encrypt($cpsw, 'e');

			if(count($chkstatus) > 0)
			{
               $assignMerchant=implode(',',$chkstatus);
			}
			else{
				$assignMerchant='';
			}
			//echo  $assignMerchant; die; 
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
            if ($cpsw != '') {
				$psw1 = $password;
			} else {
				$psw1 = $password1;
			}

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();  
				//$this->load->view("admin/add_subadmin", $data);
			} else {
				
				$branch_info = array(
					'name' => $name,
					'status' => $status,
					'email' => $email,
					'mob_no' => $mobile,
					'password' => $psw1,
					'assign_merchant'=>$assignMerchant,
					'view_permissions' => $view_permissions,
					'view_menu_permissions'=>$view_menu_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
	
				);
	
				$this->admin_model->update_data('sub_admin', $branch_info, array('id' => $id, ));
				echo '200';
				
			}

		
	}

		public function edit_agent() {

		$bct_id = $this->uri->segment(3);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		$branch = $this->admin_model->get_subadmin_details($bct_id);
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                        
			$password = $this->input->post('password') ? $this->input->post('password') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
			$password1 = $this->my_encrypt($cpsw, 'e');

			if ($cpsw != '') {
				$psw1 = $password1;
			} else {
				$psw1 = $password;
			}
			// echo md5($password);
			$branch_info = array(
				'name' => $name,
				'status' => $status,
				'email' => $email,
				'mob_no' => $mobile,
				'password' => $psw1,
				'view_permissions' => $view_permissions,
				'edit_permissions' => $edit_permissions,
				'delete_permissions' => $delete_permissions,
				'active_permissions' => $active_permissions,

			);

			$this->admin_model->update_data('sub_admin', $branch_info, array(
				'id' => $id,
			));
			$this->session->set_userdata("mymsg", "Data Has Been Updated.");
			redirect('dashboard/all_agent');
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;
				$data['password'] = $sub->password;
				$data['status'] = $sub->status;
				$data['assign_merchant'] = $sub->assign_merchant;
				$data['view_permissions'] = $sub->view_permissions;
				$data['view_menu_permissions'] = $sub->view_menu_permissions;
				$data['edit_permissions'] = $sub->edit_permissions;
				$data['delete_permissions'] = $sub->delete_permissions;
				$data['active_permissions'] = $sub->active_permissions;
				break;
			}
		}
		$data['all_merchantList'] = $this->admin_model->get_package_details("");

		$data['meta'] = "Update Agent";
		$data['action'] = "Update Agent";
		$data['loc'] = "edit_agent";
		$this->load->view('admin/add_agent', $data);

	}
	public function edit_subadmin() {

		$bct_id = $this->uri->segment(3);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		$branch = $this->admin_model->get_subadmin_details($bct_id);
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password = $this->input->post('password') ? $this->input->post('password') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
			$password1 = $this->my_encrypt($cpsw, 'e');

			if ($cpsw != '') {
				$psw1 = $password1;
			} else {
				$psw1 = $password;
			}
			// echo md5($password);
			$branch_info = array(
				'name' => $name,
				'status' => $status,
				'email' => $email,
				'mob_no' => $mobile,
				'password' => $psw1,
				'view_permissions' => $view_permissions,
				'edit_permissions' => $edit_permissions,
				'delete_permissions' => $delete_permissions,
				'active_permissions' => $active_permissions,

			);

			$this->admin_model->update_data('sub_admin', $branch_info, array(
				'id' => $id,
			));
			$this->session->set_userdata("mymsg", "Data Has Been Updated.");
			redirect('dashboard/all_subadmin');
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;
				$data['password'] = $sub->password;
				$data['status'] = $sub->status;
				$data['assign_merchant'] = $sub->assign_merchant;
				$data['view_permissions'] = $sub->view_permissions;
				$data['view_menu_permissions'] = $sub->view_menu_permissions;
				$data['edit_permissions'] = $sub->edit_permissions;
				$data['delete_permissions'] = $sub->delete_permissions;
				$data['active_permissions'] = $sub->active_permissions;
				break;
			}
		}
		$data['all_merchantList'] = $this->admin_model->get_package_details("");

		$data['meta'] = "Update SubAdmin";
		$data['action'] = "Update Subadmin";
		$data['loc'] = "edit_subadmin";
		$this->load->view('admin/add_subadmin', $data);

	}

	public function Approved_merchant($id) {

		//check data exist

		$this->admin_model->update_data('merchant', array(
			"status" => "active",
		), array(
			"id" => $id,
		));

		$this->session->set_userdata("msg", "Merchant Approved");
		redirect('dashboard/all_merchant');
	}

	public function funding_status() {

		//check data exist
		$id = $_POST["mid"];
		$date = $_POST["date"];
		$amount = $_POST["PayableAmount"];
		$hold_amount = $_POST["Hold_Amount"];
		$holdetext = @$_POST["holdetext"];
		$status = $_POST["pstatus"];
		$tabledata = $this->admin_model->data_get_where_serch("funding_status", array(
			"merchant_id" => $id,
			"date" => $date,
		));
		if (empty($tabledata)) {
			$tabledata = $this->admin_model->insert_data("funding_status", array(
				"hold_amount" => $hold_amount,
				"merchant_id" => $id,
				"date" => $date,
				"amount" => $amount,
				"status" => $status,
			));
		} else {
			$this->admin_model->update_data('funding_status', array(
				"hold_amount" => $hold_amount,
				"status" => $status,
				"modifiedDate" => date("Y-m-d H:i:s"),
			), array(
				"merchant_id" => $id,
				"date" => $date,
			));
		}
		if (!empty($holdetext)) {
			foreach ($holdetext as $tid) {
				$this->admin_model->update_data('funding_status', array(
					"hold_amount" => 0,
					"status" => $status,
					"modifiedDate" => date("Y-m-d H:i:s"),
				), array(
					"id" => $tid,
				));
			}
		}
		$this->session->set_userdata("msg", "Status Has Been Updated.");
		redirect('dashboard/report/' . $date);
	}
	public function get_holdamount() {
		$mid = $_POST["mid"];
		$cdate = $_POST["cdate"];
		$amounnt = $_POST["amounnt"];
		$tabledata = $this->admin_model->get_holdamount(array(
			'mid' => $mid,
			"cdate" => $cdate,
		));
		echo json_encode($tabledata);
	}
	public function funding_status_post() {

		foreach ($_POST["chkstatus"] as $post) {
			$post = explode("_", $post);
			$id = $post[0];
			$amount = $post[1];
			$date = $_POST["date"];
			$status = isset($_POST["confirmSubmit"]) ? "confirm" : "pending";
			//check data exist
			$tabledata = $this->admin_model->data_get_where_serch("funding_status", array(
				"merchant_id" => $id,
				"date" => $date,
			));
			if (empty($tabledata)) {
				$tabledata = $this->admin_model->insert_data("funding_status", array(
					"merchant_id" => $id,
					"date" => $date,
					"amount" => $amount,
					"status" => $status,
				));
			} else {
				$this->admin_model->update_data('funding_status', array(
					"status" => $status,
					"modifiedDate" => date("Y-m-d H:i:s"),
				), array(
					"merchant_id" => $id,
					"date" => $date,
				));
			}

		}
		$this->session->set_userdata("msg", "Status Has Been Updated.");
		redirect('dashboard/report/' . $date);
	}
	public function update_merchant() {

		$bct_id = $this->uri->segment(3);
		if (!$bct_id &&  !$this->input->post('submit') && !$this->input->post('updatepassword')  ) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		//$branch = $this->admin_model->get_subadmin_details($bct_id);
		$branch = $this->admin_model->get_payment_details_3($bct_id);
		//print_r($_POST); die("ok"); 
		if($this->input->post('updatepassword'))
		{ 
			 $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
             $email = $this->input->post('email') ? $this->input->post('email') : "";
             $password = $this->input->post('password') ? $this->input->post('password') : "";
			 $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			 $password1 = $this->my_encrypt($cpsw, 'e');
				if ($cpsw != '') {
					$psw1 = $password1;
				} else {
					$psw1 = $password;
				}
			$branch_info = array('password' => $psw1); 
			$up=$this->admin_model->update_data('merchant', $branch_info, array('id' => $id));
		

			if ($cpsw != '') {
				$psw1 = $password1;
				set_time_limit(3000); 
				$MailTo = $email;  
				$MailSubject = ' Your Sale  Quick login Authentication  '; 
				$header = "From: Salequick<info@salequick.com>\r\n".
							"MIME-Version: 1.0" . "\r\n" .
							"Content-type: text/html; charset=UTF-8" . "\r\n"; 
				$msg = " Your user id : ".$email." .  Latest  Password : ".$cpsw.".";
				ini_set('sendmail_from', $email); 
					$this->email->from('info@salequick.com', '');
					$this->email->to($MailTo);
					$this->email->subject($MailSubject);
					$this->email->message($msg);
					$this->email->send();
			} 
			$this->session->set_userdata("mymsg_u", "Password has been updated ...");
			redirect('dashboard/update_merchant/' . $id);
			
		}
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$email1 = $this->input->post('email1') ? $this->input->post('email1') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$status = $this->input->post('status') ? $this->input->post('status') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			// $password = $this->input->post('password') ? $this->input->post('password') : "";
			// $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$t_fee = $this->input->post('t_fee') ? $this->input->post('t_fee') : "";
			$s_fee = $this->input->post('s_fee') ? $this->input->post('s_fee') : "";
			$f_swap_Invoice = $this->input->post('f_swap_Invoice') ? $this->input->post('f_swap_Invoice') : "";
			$f_swap_Recurring = $this->input->post('f_swap_Recurring') ? $this->input->post('f_swap_Recurring') : "";
			$f_swap_Text = $this->input->post('f_swap_Text') ? $this->input->post('f_swap_Text') : "";
			$address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
			$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
			$state = $this->input->post('state') ? $this->input->post('state') : "";
			$city = $this->input->post('city') ? $this->input->post('city') : "";
			$business_name = $this->input->post('business_name') ? $this->input->post('business_name') : "";
			$business_dba_name = $this->input->post('business_dba_name') ? $this->input->post('business_dba_name') : "";
			$business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
			$year_business = $this->input->post('year_business') ? $this->input->post('year_business') : "";
			$ien_no = $this->input->post('ien_no') ? $this->input->post('ien_no') : "";
			$mi = $this->input->post('mi') ? $this->input->post('mi') : "";
			$website = $this->input->post('website') ? $this->input->post('website') : "";
			$business_type = $this->input->post('business_type') ? $this->input->post('business_type') : "";
			$bank_name = $this->input->post('bank_name') ? $this->input->post('bank_name') : "";
			$funding_time = $this->input->post('funding_time') ? $this->input->post('funding_time') : "";
			$bank_account = $this->input->post('bank_account') ? $this->input->post('bank_account') : "";
			$bank_routing = $this->input->post('bank_routing') ? $this->input->post('bank_routing') : "";
			$monthly_fee = $this->input->post('monthly_fee') ? $this->input->post('monthly_fee') : "";
			$chargeback = $this->input->post('chargeback') ? $this->input->post('chargeback') : "";
			$point_sale = $this->input->post('point_sale') ? $this->input->post('point_sale') : "";
			$invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
			$recurring = $this->input->post('recurring') ? $this->input->post('recurring') : "";
			$text_email = $this->input->post('text_email') ? $this->input->post('text_email') : "";
			$o_name = $this->input->post('o_name') ? $this->input->post('o_name') : "";
			$o_address = $this->input->post('o_address') ? $this->input->post('o_address') : "";
			$o_phone = $this->input->post('o_phone') ? $this->input->post('o_phone') : "";
			$o_email = $this->input->post('o_email') ? $this->input->post('o_email') : "";
			$o_social = $this->input->post('o_social') ? $this->input->post('o_social') : "";
			$o_percentage = $this->input->post('o_percentage') ? $this->input->post('o_percentage') : "";
			$city = $this->input->post('city') ? $this->input->post('city') : "";
			$country = $this->input->post('country') ? $this->input->post('country') : "";
			$zip = $this->input->post('zip') ? $this->input->post('zip') : "";
			$city = $this->input->post('city') ? $this->input->post('city') : "";
			$bank_street = $this->input->post('bank_street') ? $this->input->post('bank_street') : "";
			$bank_city = $this->input->post('bank_city') ? $this->input->post('bank_city') : "";
			$bank_country = $this->input->post('bank_country') ? $this->input->post('bank_country') : "";
			$bank_zip = $this->input->post('bank_zip') ? $this->input->post('bank_zip') : "";
			$protractor_status = $this->input->post('protractor_status') ? $this->input->post('protractor_status') : "";
			$signature_status = $this->input->post('signature_status') ? $this->input->post('signature_status') : "";

			// $password1 = $this->my_encrypt($cpsw, 'e');

			// if ($cpsw != '') {
			// 	$psw1 = $password1;
			// } else {
			// 	$psw1 = $password;
			// }
			// echo md5($password);
			$branch_info = array(

				'name' => $name,
				//'password' => $psw1,
				'status' => $status,
				't_fee' => $t_fee,
				's_fee' => $s_fee,
				'f_swap_Invoice' => $f_swap_Invoice,
				'f_swap_Recurring' => $f_swap_Recurring,
				'f_swap_Text' => $f_swap_Text,
				'address1' => $address1,
				'address2' => $address2,
				'state' => $state,
				'city' => $city,
				'email1' => $email1,
				'business_name' => $business_name,
				'business_dba_name' => $business_dba_name,
				'business_number' => $business_number,
				'year_business' => $year_business,
				'ien_no' => $ien_no,
				'mi' => $mi,
				'website' => $website,
				'email1' => $email1,
				'business_type' => $business_type,
				'bank_name' => $bank_name,
				'funding_time' => $funding_time,
				'bank_account' => $bank_account,
				'bank_routing' => $bank_routing,
				'monthly_fee' => $monthly_fee,
				'chargeback' => $chargeback,
				'point_sale' => $point_sale,
				'invoice' => $invoice,
				'recurring' => $recurring,
				'text_email' => $text_email,
				'o_name' => $o_name,
				'o_phone' => $o_phone,
				'o_email' => $o_email,
				'o_social' => $o_social,
				'o_percentage' => $o_percentage,
				'o_address' => $o_address,
				'city' => $city,
				'country' => $country,
				'zip' => $zip,
				'bank_street' => $bank_street,
				'bank_city' => $bank_city,
				'bank_country' => $bank_country,
				'bank_zip' => $bank_zip,
				'protractor_status' => $protractor_status,
				'signature_status' => $signature_status,

			);

			// print_r($branch_info); die();

			$this->admin_model->update_data('merchant', $branch_info, array(
				'id' => $id,
			));
          
		

			$this->session->set_userdata("mymsg_u", "Merchant information  has been updated.");
			// $this->session->set_flashdata('mymsg_u', '<div class="alert alert-success text-center">  Data Has Been Updated </div>');
			//redirect('dashboard/all_merchant');
			redirect('dashboard/update_merchant/' . $id);
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['email1'] = $sub->email1;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;
				$data['o_address'] = $sub->o_address;
				$data['city'] = $sub->city;
				$data['country'] = $sub->country;
				$data['zip'] = $sub->zip;
				$data['bank_street'] = $sub->bank_street;
				$data['bank_city'] = $sub->o_address;
				$data['bank_country'] = $sub->bank_country;
				$data['bank_zip'] = $sub->country;
				$data['password'] = $sub->password;
				$data['status'] = $sub->status;
				$data['t_fee'] = $sub->t_fee;
				$data['s_fee'] = $sub->s_fee;
				$data['f_swap_Invoice'] = $sub->f_swap_Invoice;
				$data['f_swap_Recurring'] = $sub->f_swap_Recurring;
				$data['f_swap_Text'] = $sub->f_swap_Text;
				$data['auth_key'] = $sub->auth_key;
				$data['date'] = $sub->created_on;
				$data['address1'] = $sub->address1;
				$data['address2'] = $sub->address2;
				$data['state'] = $sub->state;
				$data['city'] = $sub->city;
				$data['business_name'] = $sub->business_name;
				$data['business_dba_name'] = $sub->business_dba_name;
				$data['business_number'] = $sub->business_number;
				$data['year_business'] = $sub->year_business;
				$data['ien_no'] = $sub->ien_no;
				$data['mi'] = $sub->mi;
				$data['website'] = $sub->website;
				$data['business_type'] = $sub->business_type;
				$data['bank_name'] = $sub->bank_name;
				$data['funding_time'] = $sub->funding_time;
				$data['bank_account'] = $sub->bank_account;
				$data['bank_routing'] = $sub->bank_routing;
				$data['monthly_fee'] = $sub->monthly_fee;
				$data['chargeback'] = $sub->chargeback;
				$data['point_sale'] = $sub->point_sale;
				$data['invoice'] = $sub->invoice;
				$data['recurring'] = $sub->recurring;
				$data['text_email'] = $sub->text_email;
				$data['o_name'] = $sub->o_name;
				$data['o_address'] = $sub->o_address;
				$data['o_phone'] = $sub->o_phone;
				$data['o_email'] = $sub->o_email;
				$data['o_social'] = $sub->o_social;
				$data['o_percentage'] = $sub->o_percentage;
				$data['protractor_status'] = $sub->protractor_status;
				$data['signature_status'] = $sub->signature_status;

				break;
			}
		}
		$data['meta'] = "Update Merchant";
		$data['action'] = "Update Merchant";
		$data['loc'] = "update_merchant";
		//print_r($data);
		$this->load->view('admin/update_merchant', $data);

	}

		public function all_agent() {

		$data = array();

		$package_data = $this->admin_model->get_full_details_agent('sub_admin');

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;

			$package['view_permissions'] = $each->view_permissions;
			$package['edit_permissions'] = $each->edit_permissions;
			$package['delete_permissions'] = $each->delete_permissions;
			$package['active_permissions'] = $each->active_permissions;

			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;

		

		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/all_agent', $data);
	}
	public function all_subadmin() {

		$data = array();

		$package_data = $this->admin_model->get_full_details_subadmin('sub_admin');

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;

			$package['view_permissions'] = $each->view_permissions;
			$package['edit_permissions'] = $each->edit_permissions;
			$package['delete_permissions'] = $each->delete_permissions;
			$package['active_permissions'] = $each->active_permissions;

			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;

		

		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/all_subadmin', $data);
	}
	
	public function all_merchant() {

		$data = array();
		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_package_details_merchant($start_date, $end_date, $status);

			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {

			$package_data = $this->admin_model->get_package_details("");
		}
		$mem = array();
		$member = array();

		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			$getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			$datacount=count($getApplicationDetails);  
			$applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';
			

			$package['id'] = $each->id;
			$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			$package['applicationstatus'] = $applicationstatus;
			$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;

		array_multisort(array_column($mem, 'id'), SORT_DESC, $mem);

		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/all_merchant', $data);
	}

		public function all_sub_merchant() {

			$data = array();
			if (isset($_POST['mysubmit'])) {

				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				$status = $_POST['status'];
				
			if($this->uri->segment(3))
			{
				$v=$this->uri->segment(3); 
				// print_r($v); die(); 
			$package_data = $this->admin_model->get_package_details_merchant_sub($start_date, $end_date, $status,$v);
			}  
			else {

				$package_data = $this->admin_model->get_package_details_merchant_sub($start_date, $end_date, $status,"");
			}
				
				//echo $this->db->last_query(); die("okly"); 
				$data["start_date"] = $_POST['start_date'];
				$data["end_date"] = $_POST['end_date'];
				$data["status"] = $_POST['status'];
			}
			elseif($this->uri->segment(3))
			{
				$v=$this->uri->segment(3); 
				// print_r($v); die(); 
				$package_data = $this->admin_model->get_package_details_sub_by_id($v);
			}  
			else {

				$package_data = $this->admin_model->get_package_details_sub_by_id("");
			}
			$mem = array();
			$member = array();

			foreach ($package_data as $each) {
				$this->db->where('id',$each->merchant_id); 
				$result=$this->db->get('merchant')->row_array(); 
				$package['id'] = $each->id;
				$package['allDettils'] = json_decode(json_encode($each), true);
				$package['name'] = $each->name;
				$package['business_name'] = $each->business_name;
				$package['business_number'] = $each->business_number;
				$package['merchant_id'] = $each->merchant_id;
				$package['dba_name'] = $result['name'];
				$package['email'] = $each->email;
				$package['mob_no'] = $each->mob_no;
				$package['t_fee'] = $each->t_fee;
				$package['auth_key'] = $each->auth_key;
				$package['created_on'] = $each->created_on;
				//$package['date'] = $each->date;
				$package['status'] = $each->status;

				$mem[] = $package;
			}
			$data['mem'] = $mem;
			// print_r($mem); die; 
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');

			$this->load->view('admin/all_sub_merchant', $data);
		}

		public function all_customer_request() {
			$data = array();
			if (isset($_POST['mysubmit'])) {
				$employee = '';
				$status = $_POST['status'];
				$date1 = $_POST['start_date'];
				$date2 = $_POST['end_date'];
				$package_data = $this->admin_model->get_full_details_admin_report_search('customer_payment_request', $date1, $date2, $employee, $status);
			    $data["start_date"] = $_POST['start_date'];
				$data["end_date"] = $_POST['end_date'];
				$data["status"] = $_POST['status'];
			} else {
				$package_data = $this->admin_model->get_full_details_admin_orderby_new('customer_payment_request');
			}
			$mem = array();
			$member = array();
			foreach ($package_data as $each) {
				$package['id'] = $each->id;
				$package['name'] = $each->name;
				$package['merchant_id'] = $each->merchant_id;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['title'] = $each->title;
				$package['date'] = $each->add_date;
				$package['status'] = $each->status;
				$package['payment_type'] = $each->payment_type;
				$package['due_date'] = $each->due_date;
				$package['payment_id'] = $each->invoice_no;
				$package['date_c'] = $each->date_c;
				$package['transaction_id'] = $each->transaction_id;
				$package['mpayment_id'] = $each->payment_id;
				$package['card_type'] = $each->card_type;
				$mem[] = $package;
				if ($package['status'] == "Chargeback_Confirm") {
					$getRefunddata= $this->admin_model->get_refund_transaction($each->merchant_id,$each->invoice_no);
					$package['id'] = $each->id;
					$package['name'] = $each->name;
					$package['merchant_id'] = $each->merchant_id;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					$package['title'] = $each->title;  
					$package['date'] = $each->refund_date; 
					$package['status'] = "Refund"; 
					$package['payment_type'] = $each->payment_type;
					$package['due_date'] = $each->due_date;
					$package['payment_id'] = $each->invoice_no;
					$package['date_c'] = $each->refund_date ? $each->refund_date : $getRefunddata->add_date;
					$package['transaction_id'] = $each->refund_transaction_id ? $each->refund_transaction_id : $getRefunddata->transaction_id;
					$package['mpayment_id'] = $each->payment_id;
					$package['card_type'] = $each->card_type;
					$mem[] = $package;
				}

			}
			array_multisort(array_column($mem, 'date_c'), SORT_DESC, $mem);
			$data['mem'] = $mem;
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');
			$this->load->view('admin/all_customer_request', $data);
		}
	

	//Invoice Listing
	public function invoice_list() {
		$data = array();
		$_result = $this->invoice_model->get_datatables();
		$_query = $_result['query'];
		$invoice_list = $_result['result'];
		// echo "<pre>";print_r($invoice_list);die;
		$no = $_POST['start'];
		foreach ($invoice_list as $invoice) {
			$row = array();
			$merchant_name = $this->admin_model->data_get_where_1('merchant', array('id' => $invoice->merchant_id));
			// echo "<pre>";print_r($merchant_name);
			foreach ($merchant_name as $key => $value) {
				$name = $value['business_dba_name'];
			}
			$row[] = $invoice->payment_id;
			$row[] = $invoice->transaction_id;
			$row[] = $name;
			$row[] = $invoice->mobile_no;
			$row[] = '<h5 class="no-margin text-bold text-danger" >$' . number_format($invoice->amount, 2) . '</h5>';
			if ($invoice->status == 'pending') {
				$status = '<span class="badge badge-pink"> ' . $invoice->status . '  </span>';
			} elseif ($invoice->status == 'confirm') {
				$status = '<span class="badge badge-success"> ' . $invoice->status . ' </span>';
			} else {
				$status = '';
			}
			$row[] = $status;
			$row[] = $invoice->due_date;
			if ($invoice->status != 'pending') {
				$date_c = $invoice->date_c;
			} else {
				$date_c = '';
			}
			$row[] = $date_c;
			if ($invoice->status == 'pending') {
				$invoice_no = '<a href="https://salequick.com/payment/' . $invoice->payment_id . '/' . $invoice->merchant_id . '" target="_blank">
                    <button class="btn btn-sm btn-warning"><i class="ti-receipt"></i> Invoice</button>
                     </a>';
			} elseif ($invoice->status == 'confirm') {
				$invoice_no = '<a href="https://salequick.com/payment/' . $invoice->payment_id . '/' . $invoice->merchant_id . '" target="_blank">
                    <button class="btn btn-sm btn-success"><i class="ti-receipt"></i> Receipt</button>
                    </a>';
			} else {
				$invoice_no = '';
			}
			$row[] = $invoice_no;
			$row[] = '<button data-toggle="modal" data-target="#view-modal" data-id="' . $invoice->id . '" id="getUser" class="btn btn-sm btn-info"><i class="ti-eye"></i> View</button>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_model->count_all(),
			"recordsFiltered" => $this->invoice_model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	//Invoice Listing

	public function report($Requestdata = null) {
		$data["title"] = "Admin Panel";
		
		if (isset($_POST['mysubmit'])) {
			//echo '1';die();
			$employee = $_POST['employee'];
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data_full_reporst = $this->admin_model->get_full_reports(array(
				'date' => $date1,
				'date2' => $date2,
				'employee' => $employee,
				'status' => $status,
			));
			$data['reposrint_date'] = $date1;
			$data['full_reporst'] = $package_data_full_reporst;

			$data['employee'] = $employee;
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];

		} else { 
			//echo '2';die();    
			$package_data = $this->admin_model->get_full_details_admin_report('customer_payment_request');
//echo $this->db->last_query();die();
			$package_data1 = $this->admin_model->get_full_details_admin_report('recurring_payment');
			$package_data2 = $this->admin_model->get_full_details_admin_report('pos');

                        //echo '<pre>';print_r($package_data); die();
			$reposrint_date = date("Y-m-d");
			$datetime = new DateTime($reposrint_date);
			$datetime->modify('-1 day');
			$reposrint_date2 = $datetime->format('Y-m-d'); 
			
			if ($Requestdata != null) {
				$reposrint_date = $Requestdata;
			}
			$package_data_full_reporst = $this->admin_model->get_full_reports(array(
				'date' => $reposrint_date2,
				'date2' => $reposrint_date
			));
			//print_r($package_data_full_reporst); die();
			$data['full_reporst'] = $package_data_full_reporst;
			$data['reposrint_date'] = $reposrint_date;

		}
		
		
		if ($Requestdata != null) {
			$data['reposrint_date'] = $Requestdata;
		}
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$GrosspaymentValume = 0;
		$TotalFeeCaptured = 0;
		$TotalPayout = 0;
		$TotalTransactions = 0;
		if (!empty($data['full_reporst'])) {
			foreach ($data['full_reporst'] as $key => $full_reporst) {
				if ($full_reporst["totalAmount"] > 0) {
					$firsttimefees = $this->admin_model->getLastpayment(array(
						'date' => $reposrint_date,
						'merchant_id' => $full_reporst['id'],
					));
					$data['full_reporst'][$key]['monthly_fees'] = 0;
					if ($firsttimefees[0]["cnt"] == 0) {
						$data['full_reporst'][$key]['monthly_fees'] = $full_reporst['monthly_fee'];
					}
					$GrosspaymentValume = $GrosspaymentValume + $full_reporst['totalAmount'];
					$TotalFeeCaptured = $TotalFeeCaptured + $full_reporst['feesamoun'] + $data['full_reporst'][$key]['monthly_fees'];
					$TotalTransactions = $TotalTransactions + 1;
				} else {
					$data['full_reporst'][$key]['monthly_fees'] = 0;
				}
			}
		}
		$this->session->unset_userdata('mymsg');
		
		$data['GrosspaymentValume'] = $GrosspaymentValume;
		$data['TotalFeeCaptured'] = $TotalFeeCaptured;
		$data['TotalTransactions'] = $TotalTransactions;
		//print_r($data);die();
		$this->load->view('admin/report', $data);
	}

	public function search_record_pos() {
		$searchby = $this->input->post('id');
		$data['item'] = $this->admin_model->data_get_where_1("pos", array(
			"id" => $searchby,
		));

		$data['pay_report'] = $this->admin_model->search_pos($searchby);
		echo $this->load->view('merchant/show_pos', $data, true);

	}
	public function search_record_column2() {
		$searchby = $this->input->post('id');
		$date = $this->input->post('date');

		$fundDetails = $this->admin_model->getfundDetails(array(
			"id" => $searchby,
			'date' => $date,
		));
		//$package_data = $this->admin_model->data_get_where('customer_payment_request',array("merchant_id" => $searchby));
		$mem = array();
		foreach ($fundDetails as $each) {
			$memInt = array();
			$memInt['invoice_no'] = $each['invoice_no'];
			$memInt['amount'] = $each['amount'];
			$memInt['add_date'] = $each['add_date'];
			$memInt['email_id'] = $each['email_id'];
			$mem[] = $memInt;
		}
		$data['mem'] = $mem;
		echo $this->load->view('admin/fund_modal', $data, true);

	}
		public function search_record_column_recurring() {
			$searchby = $this->input->post('id');
			$data['pay_report'] = $this->admin_model->search_record($searchby);
			echo $this->load->view('merchant/show_result_recurring', $data, true);
		}
		public function merchant_detail() {

			$data = array();
			$id = $this->uri->segment(3);
			if ($this->input->post('mysubmit')) {

				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				$status = $_POST['status'];
				$package_data = $this->admin_model->get_search($start_date, $end_date, $status, 'customer_payment_request');
			} else {

				$package_data = $this->admin_model->data_get_where('customer_payment_request', array(
					"merchant_id" => $id,
				));
				$merchant_data = $this->admin_model->data_get_where_1('merchant', array(
					"id" => $id,
				));
			}
			$mem = array();
			$member = array();
			foreach ($package_data as $each) {

				$package['id'] = $each->id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['title'] = $each->title;
				$package['date'] = $each->add_date;
				$package['status'] = $each->status;
				$package['payment_type'] = $each->payment_type;
				$package['due_date'] = $each->due_date;
				$package['payment_id'] = $each->invoice_no;

				$mem[] = $package;
			}
			foreach ($merchant_data as $each1) {

				$package1['id'] = $each1['id'];
				$package1['merchant_name'] = $each1['name'];

				$member[] = $package1;
			}
			$data['mem'] = $mem;
			$data['member'] = $member;
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');

			$this->load->view('admin/merchant_detail', $data);
		}
		public function all_customer_request_recurring() {
			$data = array();
		 	$merchant_id = $this->session->userdata('merchant_id'); 
			if (isset($_POST['mysubmit'])) {
				$status = $_POST['status'];
				$date1 = $_POST['start_date'];
				$date2 = $_POST['end_date'];
				$package_data = $this->admin_model->get_full_details_admin_report_search1('customer_payment_request', $date1, $date2, $status);
				// $package_data = $this->admin_model->get_package_details_customer_admin($date1,$date2,$status);
	            $data["start_date"] = $_POST['start_date'];
				$data["end_date"] = $_POST['end_date'];
				$data["status"] = $_POST['status'];
			} else {
				$package_data = $this->admin_model->get_full_details_payment_admin('customer_payment_request');
			}
		    //   echo $this->db->last_query();  die; 
			$mem = array();
			$member = array();
			foreach ($package_data as $each) {
				$package['id'] = $each->id;
				$package['payment_id'] = $each->invoice_no;
				$package['name'] = $each->name;
				$package['merchant_id'] = $each->merchant_id;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['late_fee'] = $each->late_fee;
				$package['title'] = $each->title;
				$package['date'] = $each->add_date;
				$package['due_date'] = $each->due_date;
				$package['status'] = $each->status;
				$package['payment_type'] = $each->payment_type;
				$package['recurring_payment'] = $each->recurring_payment;
				$package['recurring_type'] = $each->recurring_type;
				$package['recurring_count'] = $each->recurring_count;
				$package['recurring_pay_start_date'] = $each->recurring_pay_start_date;
				$package['recurring_pay_type'] = $each->recurring_pay_type;
				$package['recurring_count_remain'] = $each->recurring_count_remain;
				$package['date_c'] = $each->date_c;
				$mem[] = $package;
			}
			$data['mem'] = $mem;
		 	// echo "<pre>";print_r($data);die;
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');
			$this->load->view('admin/all_customer_request_recurring', $data);
		}
		public function stop_recurring($id) {
			$this->admin_model->stop_recurring($id);
			echo json_encode(array(
				"status" => TRUE,
			));
		}
		public function start_recurring($id) {
			$this->admin_model->start_recurring($id);
			echo json_encode(array(
				"status" => TRUE,
			));
		}
		//Invoice Details for admin recurring transactions
		public function invoice_details($invoice_no) {
			// echo date('Y-m-d H:i:s');die;
			$data = array();
			$merchant_id = $this->session->userdata('merchant_id');
		  	if ($this->input->post('mysubmit')) {
				$curr_payment_date = $_POST['curr_payment_date'];
				$invoice_no = $_POST['invoice_no'];
				$end_date = $_POST['end'];
				$status = $_POST['status'];   
				$data['mem']= $this->admin_model->get_singleGroup_filter_customer_admin($curr_payment_date,$_POST['end'], $status,$invoice_no);
				$data["curr_payment_date"] = $_POST['curr_payment_date']; 
				$data["end"] = $_POST['end'];
			    $data['invoice_no']=$invoice_no; 
				$data["status"] = $_POST['status']; 

	            $this->load->view('admin/invoice_details', $data);
			} else if($invoice_no != "") {
				$date = date('Y-m-d', strtotime('-30 days'));
				if ($merchant_id != '') {
					$this->db->where('merchant_id', $merchant_id);
				} 
				$this->db->where('payment_type', 'recurring');
				$this->db->where('invoice_no', $invoice_no);
				$this->db->where("payment_type", "recurring");
				//$this->db->where('recurring_next_pay_date >=', $date);
			    $this->db->order_by("id", "desc");
				$data['mem']=$this->db->get('customer_payment_request')->result_array();
				// echo "<pre>";print_r($data);die;
				//print_r(count($data['mem'])); die();       
				$data["curr_payment_date"] = $date; 
				$data["end"] = date('Y-m-d');
				$data["status"] = "";
				$this->load->view('admin/invoice_details', $data);  
			} else {
				redirect(base_url('dashboard/all_customer_request_recurring')); 
			}
		}
		//Search Invoice Detail Receipt
		public function search_invoice_detail_receipt() {
			// $merchant_id = $this->session->userdata('id');
			$searchby = $this->input->post('id');
			// echo $searchby;die;
			$data['invoice_detail_receipt_item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
			$data['invoice_detail_receipt'] = $this->admin_model->search_record($searchby);
			$data['refundData'] = $this->admin_model->data_get_refund("customer_payment_request", $searchby);
			$merchant_id = $data['invoice_detail_receipt'][0]->merchant_id;
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
			    $data['merchant_data'] = $getQuery1->result_array();
			// echo "<pre>";print_r($data);die;
			echo $this->load->view('admin/show_invoice_detail_receipt_admin', $data, true);
		}
		//Refund Amount from admin
		public function refund() {
			// echo "<pre>";print_r(($_POST)); die();
			$refundfor = $_POST['refundfor'];  
			$merchant_id = $_POST['merchant_id'];  
		 	if($refundfor) {
				// $merchant_id = $this->session->userdata('merchant_id');
				//Data, connection, auth
				# $dataFromTheForm = $_POST['fieldName']; // request data from the form
				$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL

				$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
				$getEmail_a = $getQuery_a->result_array();
				$data['$getEmail_a'] = $getEmail_a;
				//print_r($getEmail_a);
				$account_id = $getEmail_a[0]['account_id_cnp'];
				$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
				$account_token = $getEmail_a[0]['account_token_cnp'];
				$application_id = $getEmail_a[0]['application_id_cnp'];
				$terminal_id = $getEmail_a[0]['terminal_id'];
				$id = $_POST['id'];
				$invoice_no = $_POST['invoice_no'];
				$amount = $_POST['amount'];
				$transaction_id = $_POST['transaction_id'];
				$payment_id = $_POST['payment_id'];
				$TicketNumber = (rand(100000, 999999));
				$TicketNumber1 = (rand(100000000, 999999999));
				$TicketNumber2 = ($TicketNumber1 . rand(1000000, 9999999));
				// xml post structure
				$xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID>
		            <AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID>
		            </Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
		            <Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
		            <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
		            <TransactionID>" . $transaction_id . "</TransactionID><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $TicketNumber2 . "</ReferenceNumber><TicketNumber>" . $TicketNumber . "</TicketNumber>
		            </Transaction></CreditCardReturn>"; // data from the form, e.g. some ID number

				$headers = array(
					"Content-type: text/xml;charset=\"utf-8\"",
					"Accept: text/xml",
					"Cache-Control: no-cache",
					"Pragma: no-cache",
					"SOAPAction: https://transaction.elementexpress.com/",
					"Content-length: " . strlen($xml_post_string),
				); //SOAPAction: your op URL

				$url = $soapUrl;

				// PHP cURL  for https connection with auth
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				// converting
				$response = curl_exec($ch);
				$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
				$json = json_encode($xml);
				$arraya = json_decode($json, TRUE);
				
				curl_close($ch);

				// print_r($arraya);  die(); 

				$trans_a_no = $arraya['Response']['Transaction']['TransactionID'];
				$card_type = $arraya['Response']['Card']['CardLogo']? $arraya['Response']['Card']['CardLogo'] : '';
				$card_no = $arraya['Response']['Card']['CardNumberMasked'] ? $arraya['Response']['Card']['CardNumberMasked'] : '';
				//  die();
				$date_c = date("Y-m-d");
				// $merchant_id = $this->session->userdata('merchant_id');

				$branch_info = array(
					// 'name' => $name,
					//'email' => $email,
					//'mobile_no' => $mobile,
					'amount' => $amount,
					'transaction_id' => $trans_a_no,
					'card_type' => $card_type,
					'card_no' => $card_no,
					'payment_id' => $payment_id,
					'invoice_no' => $invoice_no,
					//'reason' => $reason,
					'merchant_id' => $merchant_id,
					'date_c' => $date_c,
					'type' => $refundfor,
					'status' => 'confirm',
					'c_type' => 'CNP',
				);
				$branch_inf = array(
					'status' => 'Chargeback_Confirm',
				);
				// $id1 = $this->admin_model->insert_data("refund", $branch_info);
				// $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));
				if ($arraya['Response']['ExpressResponseMessage'] == 'Approved') {
					$id1 = $this->admin_model->insert_data("refund", $branch_info);
					$m = $this->admin_model->update_data('customer_payment_request', $branch_inf, array('id' => $id));
					//Refund receipt mail
					$getQuery = $this->db->query("SELECT * from customer_payment_request where id='$id' ");
					$getEmail = $getQuery->result_array();
					$data['getEmail'] = $getEmail;
					$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' ");
					$getEmail1 = $getQuery1->result_array(); 
					$data['getEmail1'] = $getEmail1;
					$data['resend'] = "";  
					$data['refund_data'] = $branch_info; 
					$email = $getEmail[0]['email_id']; 
					$amount = $getEmail[0]['amount']; 
					$sub_total = $getEmail[0]['sub_total'];
					$tax = $getEmail[0]['tax']; 
					$originalDate = $getEmail[0]['date_c']; 
					$newDate = date("F d,Y", strtotime($originalDate));
					$item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
					//Email Process
					$data['invoice_detail_receipt_item'] = $item;  
					$data['email'] = $getEmail[0]['email_id'];
					$data['color'] = $getEmail1[0]['color'];  
					$data['amount'] = $getEmail[0]['amount'];
					$data['sub_total'] = $getEmail[0]['sub_total']; 
					$data['tax'] = $getEmail[0]['tax']; 
					$data['originalDate'] = $getEmail[0]['date_c']; 
					$data['card_a_no'] = $card_a_no; 
					$data['trans_a_no'] = $trans_a_no; 
					$data['card_a_type'] = $card_a_type;
					$data['message_a'] = $message_a;
					$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
					$data['late_fee'] = $getEmail[0]['late_fee'];
					$data['payment_type'] = 'recurring';
					$data['recurring_type'] = $getEmail[0]['recurring_type'];
					$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
					$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
					$data['msgData'] = $data;
					$msg = $this->load->view('email/refund_receipt', $data, true);
					$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
					$email = $email;
					$MailSubject = ' Refund Receipt from ' . $getEmail1[0]['business_dba_name'];
	                $nameoFCustomer=$getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id']; 
					$MailSubject2 = ' Refund Receipt to ' .$nameoFCustomer;
					
					if (!empty($email)) {
						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->to($email);
						$this->email->subject($MailSubject);
						$this->email->message($msg);
						$this->email->send();
					}
		            $this->session->set_flashdata('msg', '<div class="text-success text-center"> Amount Refunded Successfully.. </div>');
		            if($refundfor=='straight') {
						redirect(base_url().'dashboard/all_customer_request');
					} else {
						redirect(base_url() . 'dashboard/invoice_details/'.$invoice_no);
					}
				} else {
					// $id = $arraya['Response']['ExpressResponseMessage'];
					// redirect('payment_error/' . $id);
					$id = $arraya['Response']['ExpressResponseMessage'];
					$this->session->set_flashdata('msg', '<div class="text-danger text-center"> '.$arraya['Response']['ExpressResponseMessage'].' </div>');
					if($refundfor=='straight') {
						redirect(base_url().'dashboard/all_customer_request');
					} else if($refundfor=='recurring') {
	                    redirect(base_url('dashboard/all_customer_request_recurring'));
					}
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="text-danger text-center">Refund :  Type of Invoice  id Required..</div>');
				redirect(base_url().'dashboard/invoice_details/'.$invoice_no); 
				
		 	}
			// if(empty($trans_a_no)){
			//      $id='Refund Fail';
			//   redirect('payment_error/'.$id);
			//   }
			//   else
			//   {
			//   $id1 = $this->admin_model->insert_data("refund", $branch_info);
			//   $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));

			//   redirect(base_url().'pos/all_customer_request');
			//   }
		}
		//Resend invoice
		public function re_invoice() {
			$rowid = $this->input->post('rowid');
			if($rowid) {
			    $this->db->where('status','pending'); 
				$this->db->where('id',$rowid);  
				$getrequest=$this->db->get('customer_payment_request')->result_array();
				// echo "<pre>";print_r($getrequest);die;
				$data = array(
					'name' => $getrequest[0]['name'],
					'invoice_no' => $getrequest[0]['invoice_no'],
					'sub_total' => $getrequest[0]['sub_total'],
					'tax' => $getrequest[0]['tax'],
					'fee' => $getrequest[0]['fee'],
					's_fee' => $getrequest[0]['s_fee'],
					'email_id' => $getrequest[0]['email_id'],
					'mobile_no' => $getrequest[0]['mobile_no'],
					'amount' => $getrequest[0]['amount'],
					'title' => $getrequest[0]['title'],
					'detail' => $getrequest[0]['detail'],
					'note' => $getrequest[0]['note'],
					'url' => $getrequest[0]['url'],
					'payment_type' => 'straight',
					'recurring_type' => $getrequest[0]['recurring_type'],
					'recurring_count' => $getrequest[0]['recurring_count'],
					'recurring_count_paid' => '0',
					'recurring_count_remain' => $getrequest[0]['recurring_count_remain'],
					'due_date' => $getrequest[0]['due_date'],
					'reference' => $getrequest[0]['reference'],
					'merchant_id' => $getrequest[0]['merchant_id'],
					'sub_merchant_id' => $getrequest[0]['sub_merchant_id'],
					'payment_id' => $getrequest[0]['payment_id'],
					'recurring_payment' => $getrequest[0]['recurring_payment'],
					'recurring_pay_start_date' => $getrequest[0]['recurring_pay_start_date'],
					'year' => $getrequest[0]['year'],
					'month' => $getrequest[0]['month'],
					'time1' => $getrequest[0]['time1'],
					'day1' => $getrequest[0]['day1'],
					'status' => 'pending',
					'date_c' => $getrequest[0]['date_c'],
					'add_date' => $getrequest[0]['add_date'],
				);
				if(count($getrequest)) { 
				    $merchantid=$getrequest[0]['merchant_id'];  

				    $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchantid . "' ");
					$getDashboardData_m = $getDashboard_m->result_array();
				}
				//print_r($getEmail);  die(); 
				if($getrequest && $getDashboardData_m) {  
                    $data['getDashboardData_m'] = $getDashboardData_m;
					$data['business_name'] = $getDashboardData_m[0]['business_name'];
					$data['address1'] = $getDashboardData_m[0]['address1'];
					$data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
					$data['logo'] = $getDashboardData_m[0]['logo'];
					$data['business_number'] = $getDashboardData_m[0]['business_number'];
					$data['color'] = $getDashboardData_m[0]['color'];
					$data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
					$data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
					$data['late_fee'] = $getDashboardData_m[0]['late_fee'];
					$data['payment_type'] = 'recurring';
					$data['recurring_type'] = $getrequest[0]['recurring_type'];
					$data['no_of_invoice'] = $getrequest[0]['no_of_invoice'];
					$data['recurring_count'] = $getrequest[0]['recurring_count'] ? $getrequest[0]['recurring_count'] : '&infin;';
					$getitem = $this->admin_model->data_get_where_1("order_item", array("p_id" => $getrequest[0]['id']));
						$item_Detail_1 = array(
							"p_id" => $getitem[0]['p_id'],
							"item_name" => ($getitem[0]['item_name']),
							"quantity" => ($getitem[0]['quantity']),
							"price" => ($getitem[0]['price']),
							"tax" => ($getitem[0]['tax']),
							"tax_id" => ($getitem[0]['tax_id']),
							"tax_per" => ($getitem[0]['tax_per']),
							"total_amount" => ($getitem[0]['total_amount']),
						);
						$data['item_detail'] = $item_Detail_1;
						$data['msgData'] = $data;
						$msg = $this->load->view('email/invoice', $data, true); 
							
						$email = $getrequest[0]['email_id'];
						$mobile_no=$getrequest[0]['mobile_no']; 
						$name=$getrequest[0]['name']; 
						$url=$getrequest[0]['url'];
						$amount=$getrequest[0]['amount'];
						$MailTo = $email;
						
					    $MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
						if (!empty($email)) {
							$this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
							$this->email->to($MailTo);
							$this->email->subject($MailSubject);
							$this->email->message($msg);
							$this->email->send();
						}


					if (!empty($mobile_no)) {
						$sms_reciever = $mobile_no;
						//$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
						$sms_message = trim(" Hello '" .$name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");

						$from = '+18325324983'; //trial account twilio number
						// $to = '+'.$sms_reciever; //sms recipient number
						$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
						$to = '+1' . $mob;
						$response = $this->twilio->sms($from, $to, $sms_message);
					}
                    echo "200";
				}
			}
		}
		//Resend Receipt
		public function re_receipt(){
	     	$rowid = $this->input->post('rowid');   
		 	$type = $this->input->post('type');
		 	if($type=='request') {
           		$table1='customer_payment_request'; 
	 		} else if($type=='all_request') {
				$table1='pos'; 
		 	}

			if($rowid) {
			   	// $this->db->where('status','confirm'); 
			   	//  $this->db->where('id',$rowid); 
				$data['getEmail']=$getEmail=$this->db->query("SELECT * FROM $table1 WHERE ( `status`='confirm' OR `status`='Chargeback_Confirm')  AND  id='$rowid'   ")->result_array();
				//print_r($getEmail);  die();  
				if(count($getEmail)) {
					$merchantid=$getEmail[0]['merchant_id'];  

					$getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchantid."'  ");
					$getEmail1 =$getQuery_a->result_array();
					$data['getEmail1'] = $getEmail1;  
					//print_r($getEmail1);  die(); 
				}
				//print_r($getEmail);  die(); 
				if($getEmail && $getEmail1) {
					$data['email'] = $getEmail[0]['email_id'];  
					$data['color'] = $getEmail1[0]['color']?$getEmail1[0]['color']: '#000';
					$data['amount'] = $getEmail[0]['amount'];
					$data['sub_total'] = $getEmail[0]['sub_total'];
					$data['tax'] = $getEmail[0]['tax']; 
					$data['originalDate'] = $getEmail[0]['date_c'];
					$data['card_a_no'] = $getEmail[0]['card_no'];
					$data['trans_a_no'] = $getEmail[0]['transaction_id'];
					$data['card_a_type'] = $getEmail[0]['card_type'];
					$data['message_a'] = $getEmail[0]['status'];
					$data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
					$data['late_fee'] = $getEmail[0]['late_fee'];
					$data['payment_type'] = 'recurring';
					$data['recurring_type'] = $getEmail[0]['recurring_type'];
					$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
					$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
					$data['msgData'] = $data;
					$itemslist=array(); 
					if($type=='all_request'){
						$invoice_no=$getEmail[0]['invoice_no'];
						$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$invoice_no'");
						$itemslist = $getQuery1->result_array();
						$data['invoice_detail_receipt_item'] = $itemslist;
						$data['itemlisttype'] = 'pos';
					}elseif($type=='request') { 
						$data['invoice_detail_receipt_item']=$this->db->query("SELECT * FROM order_item WHERE  p_id='$rowid' ")->result_array();
						$data['itemlisttype'] = 'request';
					} else{
						$data['pos_item'] =array();
						$data['itemlisttype'] = '';
					}
					$msg = $this->load->view('email/receipt', $data, true); 
					$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);

					$email=$getEmail[0]['email_id'];
					$merchant_email=$getEmail1[0]['email']; 
					$MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
					$customername=$getEmail[0]['name']?$getEmail[0]['name']:$getEmail[0]['email_id']; 
					$MailSubject2 =  'Receipt to '.$customername;
					
				
					if(!empty($email)){ 
						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->to($email);
						//$this->email->attach($filename);
					    $this->email->subject($MailSubject);
						$this->email->message($msg);
					    $this->email->send();
	 
						 }
	                
					

				      if(!empty($merchant_email)){ 
						 $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						 $this->email->to($merchant_email);
						 $this->email->subject($MailSubject2);
						 $this->email->message($merchnat_msg);
						 $this->email->send();
						 }

						 if($type=='request')
						 {
						    $url=$getEmail[0]['url'];
						    $purl = str_replace('payment', 'reciept', $url);
						 }
						 else if($type=='all_request')
						 {
							$business_dba_name=$getEmail1[0]['business_dba_name']; 
							$invoice_no=$getEmail[0]['invoice_no'];
							$purl=" '" . $business_dba_name . "' POS Invoice No :: '" . $invoice_no . "' Your Amount ::'" . $data['amount'] . "' Payment date :: '" . $data['originalDate'] . "' Transaction id ::'" . $data['trans_a_no'] . "' Card type :: '" . $data['card_a_type'] . "' ";
						}
						//print_r($getEmail[0]['mobile_no']);  die(); 
						 if(!empty($getEmail[0]['mobile_no'])){ 

							//$sms_sender = trim($this->input->post('sms_sender'));
			 
							$sms_reciever = $getEmail[0]['mobile_no'];
			 
							//$sms_message = trim('Payment Receipt : '.$purl);
			                $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
							$from = '+18325324983'; //trial account twilio number
			 
							// $to = '+'.$sms_reciever; //sms recipient number
			 
							$mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
			 
							$to = '+1'.$mob;
			 
							$response = $this->twilio->sms($from, $to,$sms_message);
			 
							}
	                       
					 echo "200";
				} else{
					echo "500";
				}
			} else {
				echo "500";
			}
		}
		//End Recurring Feature in Admin
		public function stop_package() {
			$pak_id = $this->uri->segment(3);

			if ($this->admin_model->stop_recurring($pak_id)) {
				$this->session->set_userdata("mymsg", "Recurring Has Been Stop.");
			}
		}
		public function start_package() {
			$pak_id = $this->uri->segment(3);

			if ($this->admin_model->start_recurring($pak_id)) {
				$this->session->set_userdata("mymsg", "Recurring Has Been Start.");
			}
		}
		public function all_recurrig_request() {

			$data = array();
			$merchant_id = $this->session->userdata('merchant_id');
			if ($this->input->post('mysubmit')) {

				$curr_payment_date = $_POST['curr_payment_date'];
				$status = $_POST['status'];
				$package_data = $this->admin_model->get_recurring_details_payment_admin($curr_payment_date, $status);
			} else {

				$package_data = $this->admin_model->get_recurring_details_payment_admin1();
			}
			$mem = array();
			$member = array();
			foreach ($package_data as $each) {

				$package['rid'] = $each->rid;
				$package['cid'] = $each->cid;
				$package['name'] = $each->name;
				$package['merchant_id'] = $each->merchant_id;
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->amount;
				$package['title'] = $each->title;
				$package['date'] = $each->add_date;
				$package['status'] = $each->status;
				$package['payment_type'] = $each->payment_type;

				$mem[] = $package;
			}
			$data['mem'] = $mem;
			$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
			$this->session->unset_userdata('mymsg');
	        $this->load->view('admin/all_recurrig_request', $data);
		}
		public function delete_package() {
			$pak_id = $this->uri->segment(3);

			if ($this->admin_model->delete_package($pak_id)) {
				$this->session->set_userdata("mymsg", "Data Has Been Deleted.");
			}

		}
	public function getmerchantDetails()
	{
		$merchant_id=$this->input->post('merchant_id')?$this->input->post('merchant_id'):'699'; 
		// echo $_REQUEST['merchant_id'];
		// echo "<br/>";
		// echo $merchant_id;  die();  
		//$merchant_id=280;
		
		$getdataOfApi=$this->db->query("SELECT * FROM  merchant_api WHERE merchant_id='$merchant_id'  ")->result_array(); 
		if(count($getdataOfApi) > 0)
		{
			  $merchantApplicationId=$getdataOfApi[0]['merchant_application_id']; 
			  
		}
		//$merchantApplicationId=8000; 
		if($merchantApplicationId!='')
		{
			$url='https://merchantapp.io/salequicktest/api/v1/MerchantApplication/MerchantApplicationDetails?merchantApplicationId='.$merchantApplicationId; 
			//echo json_encode($m);   die; 
			$ch = curl_init();   
			$body = '{}';
			$headers = array(
			   //  "Accept-Encoding: gzip", 
			   //  "Content-Type: application/json",
				"X-AuthenticationKeyId: a626be59-d58b-4f33-8050-104107dfb68f",
				"X-AuthenticationKeyValue: Q8n1!RGbn-5YAEA^s0s6AMrKZoPRuqLoBx2GKW15huKXOvwLq~*vJQqC7REdXviE"
			   
			   );
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
			curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($m));           
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response     = curl_exec ($ch);
			$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$err = curl_error($ch);
			 //$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
			 //$jsondata = json_encode($response);
			 $responceArrayData =json_decode($response, true); 
			curl_close($ch);
   
			//echo  $statusCode;
			if ($err) {
			  echo json_encode("cURL Error #:" . $err);
			} else {
				 //$responceArrayData;
				 //print_r($responceArrayData['ApplicationStatus']);
				 //print_r($responceArrayData['ApplicationStatusLabel']);
				 $dataUp=array(
					 'status'=>$responceArrayData['ApplicationStatus']?$responceArrayData['ApplicationStatus']:'',
					 'status_message'=>$responceArrayData['ApplicationStatusLabel']?$responceArrayData['ApplicationStatusLabel']:''
				 );

				 
				 $this->db->where('merchant_id',$merchant_id);
				 $this->db->where('merchant_application_id',$merchantApplicationId);
				 $up=$this->db->update('merchant_api',$dataUp);
				//   echo json_encode(988);
                //  echo json_encode($up);  die(); 
				 if($up)
				 {
					//  print_r($responceArrayData);  die(); 
					//echo $response; 

					echo json_encode($responceArrayData); 
					// echo json_encode(array('ApplicationStatus'=>101));

					//echo json_encode(array('ApplicationStatus'=>$responceArrayData['ApplicationStatus'],'ApplicationStatusLabel'=>$responceArrayData['ApplicationStatusLabel'],)); 
				    die();  
				} 
				 else
				 {
					echo json_encode(array('ApplicationStatus'=>600));  die(); 
				 } 
			   
		   }
			echo json_encode(array('ApplicationStatus'=>400));
		}
		else
		{
            echo json_encode(array('ApplicationStatus'=>400));
		}
		
	}

	public function merchant_api()
	{
		// echo json_encode($_POST); die();  
        
		if(isset($_POST))
		{
			//echo $this->input->post('checkbox')? $this->input->post('checkbox'):''; die(); 
			$activation_id =$this->input->post('activation_id')? $this->input->post('activation_id'):'';
			$address1 =$this->input->post('address1')? $this->input->post('address1'):'';
			$amexrate =$this->input->post('amexrate')? $this->input->post('amexrate'):'0';
			$annual_cc_sales_vol =$this->input->post('annual_cc_sales_vol')? $this->input->post('annual_cc_sales_vol'):'0';
			$annual_processing_volume =$this->input->post('annual_processing_volume')? $this->input->post('annual_processing_volume'):'';
			$bank_account =$this->input->post('bank_account')? $this->input->post('bank_account'):'';
			$bank_ach =$this->input->post('bank_ach')? $this->input->post('bank_ach'):'';
			$bank_dda =$this->input->post('bank_dda')? $this->input->post('bank_dda'):'';
			$bank_routing =$this->input->post('bank_routing')? $this->input->post('bank_routing'):'';
			$billing_descriptor =$this->input->post('billing_descriptor')? $this->input->post('billing_descriptor'):'';
			$business_dba_name =$this->input->post('business_dba_name')? $this->input->post('business_dba_name'):'';
			$business_email =$this->input->post('business_email')? $this->input->post('business_email'):'';
			$business_name =$this->input->post('business_name')? $this->input->post('business_name'):'';
			$business_number =$this->input->post('business_number')? $this->input->post('business_number'):'';
			$business_type =$this->input->post('business_type')? $this->input->post('business_type'):'';
			$chargeback =$this->input->post('chargeback')? $this->input->post('chargeback'):'0';
			$city =$this->input->post('city')? $this->input->post('city'):'';
			$country =$this->input->post('country')? $this->input->post('country'):'';
			$customer_service_email =$this->input->post('customer_service_email')? $this->input->post('customer_service_email'):'';
			$customer_service_phone =$this->input->post('customer_service_phone')? $this->input->post('customer_service_phone'):'';
			$dis_trans_fee =$this->input->post('dis_trans_fee')? $this->input->post('dis_trans_fee'):'0';
			$establishmentdate =$this->input->post('establishmentdate')? $this->input->post('establishmentdate'):'';
			$key =$this->input->post('key')? $this->input->post('key'):'';
			$monthly_fee =$this->input->post('monthly_fee')? $this->input->post('monthly_fee'):'0';
			$monthly_gateway_fee =$this->input->post('monthly_gateway_fee')? $this->input->post('monthly_gateway_fee'):'0';
			$checkbox =$this->input->post('mycheckbox')? $this->input->post('mycheckbox'):'';
			$name =$this->input->post('name')? $this->input->post('name'):'';
			$o_address =$this->input->post('o_address')? $this->input->post('o_address'):'';
			$o_dob =$this->input->post('o_dob')? $this->input->post('o_dob'):'';
			$o_email =$this->input->post('o_email')? $this->input->post('o_email'):'';
			$o_phone =$this->input->post('o_phone')? $this->input->post('o_phone'):'';
			$o_ss_number =$this->input->post('o_ss_number')? $this->input->post('o_ss_number'):'';
			$ownershiptype =$this->input->post('ownershiptype')? $this->input->post('ownershiptype'):'';
			$pc_address =$this->input->post('pc_address')? $this->input->post('pc_address'):'';
			$pc_email =$this->input->post('pc_email')? $this->input->post('pc_email'):'';
			$pc_name =$this->input->post('pc_name')? $this->input->post('pc_name'):'';
			$pc_phone =$this->input->post('pc_phone')? $this->input->post('pc_phone'):'';
			$pc_title =$this->input->post('pc_title')? $this->input->post('pc_title'):'';
			$question =$this->input->post('question')? $this->input->post('question'):'';
			$taxid =$this->input->post('taxid')? $this->input->post('taxid'):'';
			$vm_cardrate =$this->input->post('vm_cardrate') ? $this->input->post('vm_cardrate'):'0';
			$website =$this->input->post('website')? $this->input->post('website'):'';

            // echo json_encode($checkbox);
			// die(); 
			
			// if($pc_name && $pc_title && $pc_address && $pc_email && $pc_phone && $monthly_fee && $vm_cardrate && $dis_trans_fee && $amexrate
			//  && $chargeback && $monthly_gateway_fee && $annual_cc_sales_vol && $checkbox && $question && $billing_descriptor ) {
	       //echo json_encode(array('Status'=>$this->input->post('amexrate')));die; 
		if($address1  && $amexrate >=0 &&  $annual_cc_sales_vol >=0 && $annual_processing_volume && $bank_account && 
		  $bank_ach && $bank_dda  && $bank_routing && $billing_descriptor &&  $business_dba_name &&  $business_email && $business_name 
		  && $business_number && $business_type && $chargeback >=0 && $city && $country && $customer_service_email
		   && $customer_service_phone &&  $dis_trans_fee >=0  && $establishmentdate && $key && $monthly_fee >=0  && $monthly_gateway_fee >=0 &&
			$checkbox  && $name && $o_address && $o_dob && $o_email && $o_phone  && $o_ss_number && $ownershiptype && $pc_address 
			&& $pc_email && $pc_name && $pc_phone  &&  $pc_title && $question && $taxid && $vm_cardrate >=0 &&  $website 
		  ) {
			   $data=array(
				'address1' =>$address1,
				'amexrate' =>$amexrate,
				'annual_cc_sales_vol' =>$annual_cc_sales_vol,
				'annual_processing_volume' =>$annual_processing_volume,
				'bank_account' =>$bank_account,
				'bank_ach' =>$bank_ach,
				'bank_dda' =>$bank_dda,
				'bank_routing' =>$bank_routing,
				'billing_descriptor' =>$billing_descriptor,
				'business_dba_name' =>$business_dba_name,
				'business_email' =>$business_email,
				'business_name' =>$business_name,
				'business_number' =>$business_number,
				'business_type' =>$business_type,
				'chargeback' =>$chargeback,
				'city' =>$city,
				'country' =>$country,
				'customer_service_email' =>$customer_service_email,
				'customer_service_phone' =>$customer_service_phone,
				'dis_trans_fee' =>$dis_trans_fee,

				'year_business' =>substr($establishmentdate,0,4),
				'month_business' =>substr($establishmentdate,5,2),
				'day_business' =>substr($establishmentdate,8,2),
				// 'key' =>$key,
				'monthly_fee' =>$monthly_fee,
				'monthly_gateway_fee'=> $monthly_gateway_fee,
				'checkbox' => $checkbox ? 'true':'false',
				'name' =>$name,
				'o_name'=>$name,
				'o_address' =>$o_address,

				'dob' =>$o_dob,
				'o_dob_y' =>substr($establishmentdate,0,4),
				'o_dob_m' =>substr($establishmentdate,5,2),
				'o_dob_d' =>substr($establishmentdate,8,2),

				'o_email' =>$o_email,
				'o_phone' =>$o_phone,
				'o_ss_number' =>$o_ss_number,
				'ownershiptype' =>$ownershiptype,
				'pc_address' =>$pc_address, 
				'pc_email' =>$pc_email,
				'pc_name' =>$pc_name,
				'pc_phone' =>$pc_phone,
				'pc_title' =>$pc_title,
				'question' =>$question,
				'taxid' =>$taxid,
				'vm_cardrate' =>$vm_cardrate,
				'website' =>$website
			   ); 
				$id=$this->input->post('key')?$this->input->post('key'):'';
				$this->db->where('id', $id);
				$up=$this->db->update('merchant', $data);
				//echo json_encode($up);  die(); 
				//echo json_encode($id);  die(); 
				if($up)
				{
					
					$this->db->where('id', $id);
					$getdata=$this->db->get('merchant')->row();
					// echo json_encode($getdata); die(); 
                    $inputRawData=array (
						'AuthenticationKeyId' => 'a626be59-d58b-4f33-8050-104107dfb68f',
						'AuthenticationKeyValue' => 'Q8n1!RGbn-5YAEA^s0s6AMrKZoPRuqLoBx2GKW15huKXOvwLq~*vJQqC7REdXviE',
						"Merchant_IPAddress"=> $_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR'] :'',
						"Merchant_IPDateTime"=> date("l j F Y  g:ia", time() - date("Z")) ? date("l j F Y  g:ia", time() - date("Z")) :'',
						"Merchant_BrowserUserAgentString"=> $_SERVER['HTTP_USER_AGENT']?$_SERVER['HTTP_USER_AGENT']:'',
						"ExternalApplicationId"=> $getdata->business_name ? $getdata->business_name :'',
						'CustomFieldAnswers' => 
						array (
						  0 => 
						  array (
							'Id' => 6161,
							'UserDefinedId' => 'legal.name',
							'Value' => 
							array (
							  '#' => $getdata->business_name,
							),
						  ),
						  1 => 
						  array (
							'Id' => 6162,
							'UserDefinedId' => 'legal.dba',
							'Value' => 
							array (
							  '#' => $getdata->business_dba_name,
							),
						  ),
						  2 => 
						  array (
							'Id' => 6163,
							'UserDefinedId' => 'legal.address',
							'Value' => 
							array (
							  'Country' => $getdata->country,
							  'Street1' => $getdata->address1,
							  'Street2' => $getdata->address2,
							  'City' => $getdata->city,
							  'State' => $getdata->state,
							  'Zip' => $getdata->zip,
							),
						  ),
						  3 => 
						  array (
							'Id' => 6164,
							'UserDefinedId' => 'legal.ownershiptype',
							'Value' => 
							array (
							  '#' => $getdata->ownershiptype,
							),
						  ),
						  4 => 
						  array (
							'Id' => 6165,
							'UserDefinedId' => 'legal.taxid',
							'Value' => 
							array (
							  '#' => str_replace("-","",$getdata->taxid),
							),
						  ),
						  5 => 
						  array (
							'Id' => 6166,
							'UserDefinedId' => 'Legal.DateofIncorporation',
							'Value' => 
							array (
							  'Month' => $getdata->month_business,
							  'Day' =>   $getdata->day_business,
							  'Year' =>  $getdata->year_business,
							),
						  ),
						  6 => 
						  array (
							'Id' => 6167,
							'UserDefinedId' => 'legal.phone',
							'Value' => 
							array (
							  '#' => $getdata->business_number,
							),
						  ),
						  7 => 
						  array (
							'Id' => 6168,
							'UserDefinedId' => 'legal.email',
							'Value' => 
							array (
							  '#' => $getdata->business_email,
							),
						  ),
						  8 => 
						  array (
							'Id' => 6169,
							'UserDefinedId' => 'legal.website',
							'Value' => 
							array (
							  '#' => $getdata->website,
							),
						  ),
						  9 => 
						  array (
							'Id' => 6170,
							'UserDefinedId' => 'bank.routingnumber',
							'Value' => 
							array (
							  '#' => $getdata->bank_routing,
							),
						  ),
						  10 => 
						  array (
							'Id' => 6171,
							'UserDefinedId' => 'bank.routingnumber.confirm',
							'Value' => 
							array (
							  '#' => $getdata->bank_routing,
							),
						  ),
						  11 => 
						  array (
							'Id' => 6172,
							'UserDefinedId' => 'bank.acctnumber',
							'Value' => 
							array (
							  '#' => $getdata->bank_account,
							),
						  ),
						  12 => 
						  array (
							'Id' => 6173,
							'UserDefinedId' => 'bank.acctnumber.confirm',
							'Value' => 
							array (
							  '#' => $getdata->bank_account,
							),
						  ),
						  13 => 
						  array (
							'Id' => 6174,
							'UserDefinedId' => 'owner1.name',
							'Value' => 
							array (
							  'FirstName' => $getdata->o_name,
							  'MiddleName' => $getdata->m_name,
							  'LastName' => $getdata->l_name,
							),
						  ),
						  14 => 
						  array (
							'Id' => 6175,
							'UserDefinedId' => 'owner1.dob',
							'Value' => 
							array (
							  'Month' => $getdata->o_dob_m,
							  'Day' => $getdata->o_dob_d,
							  'Year' => $getdata->o_dob_y,
							),
						  ),
						  15 => 
						  array (
							'Id' => 6176,
							'UserDefinedId' => 'owner1.address',
							'Value' => 
							array (
							  'Country' => $getdata->o_country,
							  'Street1' => $getdata->o_address1,
							  'Street2' => $getdata->o_address2,
							  'City' => $getdata->o_city,
							  'State' => $getdata->o_state,
							  'Zip' => $getdata->o_zip,
							),
						  ),
						  16 => 
						  array (
							'Id' => 6178,
							'UserDefinedId' => 'owner1.ssn',
							'Value' => 
							array (
							  '#' =>$getdata->o_ss_number,
							),
						  ),
						  17 => 
						  array (
							'Id' => 6200,
							'UserDefinedId' => 'pc.name',
							'Value' => 
							array (
							  'FirstName' => $getdata->pc_name,
							  'MiddleName' =>  $getdata->pc_name,
							  'LastName' => $getdata->pc_name,
							),
						  ),
						  18 => 
						  array (
							'Id' => 6201,
							'UserDefinedId' => 'pc.title',
							'Value' => 
							array (
							//   '#' => 'true',
							  '#' => $getdata->pc_title ? 'true' :'false',
							),
						  ),
						  19 => 
						  array (
							'Id' => 6202,
							'UserDefinedId' => 'pc.address',
							'Value' => 
							array (
							  'Country' => $getdata->pc_address,
							  'Street1' => '11',
							  'Street2' => '12',
							  'City' => 'HongCong',
							  'State' =>'california',
							  'Zip' => '23233',
							),
						  ),
						  20 => 
						  array (
							'Id' => 6203,
							'UserDefinedId' => 'pc.email',
							'Value' => 
							array (
							  '#' => $getdata->pc_email,
							),
						  ),
						  21 => 
						  array (
							'Id' => 6204,
							'UserDefinedId' => 'pc.phone',
							'Value' => 
							array (
							  '#' => $getdata->pc_phone,
							),
						  ),
						  22 => 
						  array (
							'Id' => 6205,
							'UserDefinedId' => 'bank.ach',
							'Value' => 
							array (
							  '#' => $getdata->bank_ach,
							),
						  ),
						  23 => 
						  array (
							'Id' => 6206,
							'UserDefinedId' => 'legal.annualprocessing',
							'Value' => 
							array (
							  '#' => $getdata->annual_cc_sales_vol,
							),
						  ),
						  24 => 
						  array (
							'Id' => 6208,
							'UserDefinedId' => 'feeprofile.monthlyfee',
							'Value' => 
							array (
							  '#' => $getdata->monthly_fee,
							),
						  ),
						  25 => 
						  array (
							'Id' => 6209,
							'UserDefinedId' => 'feeprofile.vmcardrate',
							'Value' => 
							array (
							  '#' => $getdata->vm_cardrate,
							),
						  ),
						  26 => 
						  array (
							'Id' => 6212,
							'UserDefinedId' => 'feeprofile.distransfee',
							'Value' => 
							array (
							  '#' => $getdata->dis_trans_fee,
							),
						  ),
						  27 => 
						  array (
							'Id' => 6213,
							'UserDefinedId' => 'feeprofile.amexrate',
							'Value' => 
							array (
							  '#' => $getdata->amexrate,
							),
						  ),
						  28 => 
						  array (
							'Id' => 6215,
							'UserDefinedId' => 'feeprofile.chargebackfee',
							'Value' => 
							array (
							  '#' => $getdata->chargeback,
							),
						  ),
						  29 => 
						  array (
							'Id' => 6216,
							'UserDefinedId' => 'feeprofile.monthlygatewayfee',
							'Value' => 
							array (
							  '#' => $getdata->monthly_gateway_fee,
							),
						  ),
						  30 => 
						  array (
							'Id' => 6217,
							'UserDefinedId' => 'feeprofile.annualccsalesvol',
							'Value' => 
							array (
							  '#' => $getdata->annual_cc_sales_vol,
							),
						  ),
						  31 => 
						  array (
							'Id' => 6226,
							'UserDefinedId' => 'owner1.checkbox',
							'Value' => 
							array (
							  '#' => $getdata->business_name ? 'true':'false',
							),
						  ),
						  32 => 
						  array (
							'Id' => 6230,
							'UserDefinedId' => 'legal.question',
							'Value' => 
							array (
							  '#' => $getdata->question,
							),
						  ),
						  33 => 
						  array (
							'Id' => 6231,
							'UserDefinedId' => 'legal.billingdescriptor',
							'Value' => 
							array (
							  '#' => $getdata->billing_descriptor,
							),
						  ),
						  34 => 
						  array (
							'Id' => 6232,
							'UserDefinedId' => 'cs.phone',
							'Value' => 
							array (
							  '#' => $getdata->customer_service_phone,
							),
						  ),
						  35 => 
						  array (
							'Id' => 6233,
							'UserDefinedId' => 'cs.email',
							'Value' => 
							array (
							  '#' => $getdata->customer_service_email,
							),
						  ),
						  36 => 
						  array (
							'Id' => 6237,
							'UserDefinedId' => 'legal.businesstype',
							'Value' => 
							array (
							  '#' => $getdata->business_type,
							),
						  ),
						  37 => 
						  array (
							'Id' => 6238,
							'UserDefinedId' => 'bank.dda',
							'Value' => 
							array (
							  '#' => $getdata->bank_dda,
							),
						  ),
						),
					);
			      //print_r($inputRawData);  
				//    echo json_encode($inputRawData); 
				// 	die;
					
				   $purl='https://merchantapp.io/salequicktest/api/v1/MerchantApplication/Submit'; 
					$ch = curl_init();
					$headers = array("Accept-Encoding: gzip", "Content-Type: application/json" );
					curl_setopt($ch, CURLOPT_URL,$purl);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($inputRawData));           
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$response     = curl_exec ($ch);
					$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $err = curl_error($ch);
					 //$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
					 //$jsondata = json_encode($response);
					 $responceArrayData =json_decode($response, true); 
					curl_close($ch);
                    // print_r($response); echo $err;  die();  
					//echo  $statusCode;
					if ($err) {
					  //echo json_encode("cURL Error #:" . $err);
					  echo json_encode(array('Status'=>600,'StatusMessage'=>'cURL Error #'.$err));
					} else {
						//print_r($responceArrayData['Status']); 
						if($responceArrayData['Status']=='30')
						{
                           $apidata=array(
							
							'merchant_id'=>$getdata->id,
							'merchant_application_id'=>$responceArrayData['MerchantApplicationId'],
							'external_merchant_application_id'=>$responceArrayData['ExternalMerchantApplicationId'],
							'infinicept_application_id'=>$responceArrayData['InfiniceptApplicationId'],
							'status'=>$responceArrayData['Status'],
							'status_message'=>$responceArrayData['StatusMessage']
						   );
                           $getdataOfApi=$this->db->query("SELECT * FROM  merchant_api WHERE merchant_id='$getdata->id'  ")->result_array(); 
						   if(count($getdataOfApi) == '0')
						   {
							     $this->db->insert('merchant_api',$apidata);
						   }


							echo $response;
						} 
						else
						{
							//echo json_encode(array('Status'=>200));
							echo $response;   
						}
						
					}
                    //die("okay"); 
					//echo "update"; 
					
				}
				else
				{
	                echo json_encode(array('Status'=>600));   
				} 


			}else
			{
				echo json_encode(array('Status'=>40)); 
			}
		}
		else
		{
            echo json_encode(array('Status'=>400));   
		}
		
		   //echo jsonencode($_POST); 
	}


	public function search_record_column() {
		$searchby = $this->input->post('id');

		$data['pay_report'] = $this->admin_model->search_record_un($searchby, 'merchant');
		echo $this->load->view('admin/show_result', $data, true);

	}
	public function search_record_column1() {
		$searchby = $this->input->post('id');

		$data['item'] = $this->admin_model->data_get_where_1("order_item", array(
			"p_id" => $searchby,
		));
		// $data['item'] = $this->admin_model->search_item($searchby);
		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('admin/show_result_admin', $data, true);

	}
	public function search_record_payment() {
		$searchby = $this->input->post('id');

		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('admin/show_result_payment', $data, true);

	}
	public function tokenSystemPermission()
	{
		if(isset($_POST))
		{
                $permission=$_POST['permission']; 
				$id=$_POST['id']; 
				if($permission=='true') { 
					$data = array(
						'is_token_system_permission' => 1,
						'is_tokenized'=>1
					);
					 
					$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
					echo '200';
				 }else if($permission=='false') { 
					$data = array(
						'is_token_system_permission' =>0,
						'is_tokenized'=>0
					);
					 
					$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
					echo '200';
				 }
				
		}
	}
	// public function merchant_delete($id) {
	// 	$this->admin_model->delete_by_id($id, 'merchant');
	// 	echo json_encode(array(
	// 		"status" => TRUE,
	// 	));
	// }

	public function merchant_delete() {  

		$pass=$this->input->post('pass'); 
		$password = $this->my_encrypt( $pass , 'e' );
		$merchant_id=$this->input->post('merchant_id');
		$admin_id=$this->input->post('admin_id');
		
	   if($pass && $merchant_id && $admin_id)
	   {
		
		   $getdetails=$this->admin_model->get_user_by_id($admin_id); 
		  
		   //echo json_encode(array("status" => FALSE,'message'=>$getdetails['password'])); die; 
		   if(count($getdetails))
			{
				if($getdetails['password']==$password){ 
					$this->admin_model->delete_by_id($merchant_id, 'merchant');
					echo json_encode(array("status" => TRUE,'message'=>'Merchant Will be deleted.'));
				   
				}
				else
				{ 
					echo json_encode(array("status" => FALSE,'message'=>'Wrong Password.'));
				}
		   }
		   else
		   {  
			   echo json_encode(array("status" => FALSE,'message'=>'Please re-try'));
		   }
	   
	   }
	   else
	   {   echo json_encode(array("status" => FALSE,'message'=>"else")); die; 
		   echo json_encode(array("status" => FALSE,'message'=>'Please enter Your password'));
	   }
	   
   }

	public function subadmin_delete($id) {
		$this->admin_model->delete_by_id($id, 'sub_admin');
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	public function block_merchant($id) {
		$this->admin_model->block_by_id($id, 'merchant');
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	public function confirm_email($id) {
		$this->admin_model->confirm_email_id($id, 'merchant');
		echo json_encode(array(
			"status" => TRUE,
		));
	}
	public function active_merchant($id) {
		$this->admin_model->active_by_id($id, 'merchant');
		echo json_encode(array(
			"status" => TRUE,
		));
	}
}
?>
	