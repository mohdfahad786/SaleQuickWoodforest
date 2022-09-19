<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_Graph extends CI_Controller {
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
		$this->load->model('session_checker_model');
		if(!$this->session_checker_model->chk_session())
			redirect('admin');
		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}

	public function sale_original(){
		$data["title"] ="Admin Panel";
		$data['meta'] = 'Sales Summary';

		$today2 = date("Y");
		$last_year = date("Y",strtotime("-1 year"));
		$start = $this->input->post('start');
		$end = $this->input->post('end');

		if($start!='') {  
			$last_date = $start;  $date = $end;  
		} else { 
			$last_date = date("Y-m-d",strtotime("-29 days"));
			$date = date("Y-m-d");
		}

		if($this->input->post('employee')=='all') {
			$Allmerchant='';
		} else if($this->input->post('employee')!='all' && $this->input->post('employee')!="") {
			$Allmerchant=$this->input->post('employee');
		} else {
			$Allmerchant="";
		}

		if($this->input->post('employee')=='all') {
			$getDashboard = $this->db->query("SELECT 

			(SELECT sum(amount) as Totaljan from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 = '01'  and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 = '01'   and status='confirm' )x group by status ) as Totaljan   ,
			(SELECT sum(amount) as Totalfeb from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfeb   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarch   ,
			(SELECT sum(amount) as Totalaprl from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprl   ,
			(SELECT sum(amount) as Totalmay from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmay   ,
			(SELECT sum(amount) as Totaljune from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljune   ,
			(SELECT sum(amount) as Totaljuly from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljuly   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugust   ,
			(SELECT sum(amount) as Totalsep from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalsep   ,
			(SELECT sum(amount) as Totaloct from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totaloct   ,
			(SELECT sum(amount) as Totalnov from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnov   ,
			(SELECT sum(amount) as Totaldec from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ) as Totaldec   ,
			(SELECT sum(tax) as Totaljantax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and  time1 = '01' and status='confirm' )x group by status ) as Totaljantax   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfebtax   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarchtax   ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprltax   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmaytax   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljunetax   ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljulytax   ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugusttax   ,
			(SELECT sum(tax) as Totalseptax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalseptax   ,
			(SELECT sum(tax) as Totalocttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totalocttax   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnovtax   ,
			(SELECT sum(tax) as Totaldectax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ) as Totaldectax   ,
			(SELECT sum(fee) as Totaljanfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'    and  time1 = '01' and status='confirm' )x group by status ) as Totaljanfee   ,
			(SELECT sum(fee) as Totalfebfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfebfee   ,
			(SELECT sum(fee) as Totalmarchfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarchfee   ,
			(SELECT sum(fee) as Totalaprlfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprlfee   ,
			(SELECT sum(fee) as Totalmayfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmayfee   ,
			(SELECT sum(fee) as Totaljunefee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljunefee   ,
			(SELECT sum(fee) as Totaljulyfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljulyfee   ,
			(SELECT sum(fee) as Totalaugustfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugustfee   ,
			(SELECT sum(fee) as Totalsepfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalsepfee   ,
			(SELECT sum(fee) as Totaloctfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totaloctfee   ,
			(SELECT sum(fee) as Totalnovfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnovfee   ,
			(SELECT sum(fee) as Totaldecfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT fee,status from pos where   date_c = '".$date."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by status ) as Totaldecfee  
									");
		} else if($this->input->post('employee')!='all' && $this->input->post('employee') ) {
		 	$Allmerchant=$this->input->post('employee');
		 	$getDashboard = $this->db->query("SELECT 

			(SELECT sum(amount) as Totaljan from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 = '01'  and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 = '01'   and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 = '01'   and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljan   ,
			(SELECT sum(amount) as Totalfeb from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant))x group by status ) as Totalfeb   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalmarch   ,
			(SELECT sum(amount) as Totalaprl from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalaprl   ,
			(SELECT sum(amount) as Totalmay from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalmay   ,
			(SELECT sum(amount) as Totaljune from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljune   ,
			(SELECT sum(amount) as Totaljuly from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljuly   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalaugust   ,
			(SELECT sum(amount) as Totalsep from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalsep   ,
			(SELECT sum(amount) as Totaloct from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaloct   ,
			(SELECT sum(amount) as Totalnov from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalnov   ,
			(SELECT sum(amount) as Totaldec from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaldec   ,
			(SELECT sum(tax) as Totaljantax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and  time1 = '01' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and  time1 = '01' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljantax   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm'  AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalfebtax   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalmarchtax   ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalaprltax   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalmaytax   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljunetax   ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm'  AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljulytax   ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalaugusttax   ,
			(SELECT sum(tax) as Totalseptax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalseptax   ,
			(SELECT sum(tax) as Totalocttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant)  )x group by status ) as Totalocttax   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalnovtax   ,
			(SELECT sum(tax) as Totaldectax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 < '24' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaldectax   ,
			(SELECT sum(fee) as Totaljanfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'    and  time1 = '01' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljanfee   ,
			(SELECT sum(fee) as Totalfebfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalfebfee   ,
			(SELECT sum(fee) as Totalmarchfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalmarchfee   ,
			(SELECT sum(fee) as Totalaprlfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalaprlfee   ,
			(SELECT sum(fee) as Totalmayfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalmayfee   ,
			(SELECT sum(fee) as Totaljunefee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljunefee   ,
			(SELECT sum(fee) as Totaljulyfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm'  AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaljulyfee   ,
			(SELECT sum(fee) as Totalaugustfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalaugustfee   ,
			(SELECT sum(fee) as Totalsepfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalsepfee   ,
			(SELECT sum(fee) as Totaloctfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaloctfee   ,
			(SELECT sum(fee) as Totalnovfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($Allmerchant) )x group by status ) as Totalnovfee   ,
			(SELECT sum(fee) as Totaldecfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 < '24' and status='confirm' AND merchant_id  IN ($Allmerchant)  union all SELECT fee,status from recurring_payment where    date_c <= '".$last_date."' and date_c >= '".$date."' and time1 >= '22' and  time1 < '24' and status='confirm' AND merchant_id  IN ($Allmerchant) union all SELECT fee,status from pos where   date_c = '".$date."'  and time1 >= '22' and  time1 < '24' and status='confirm'  AND merchant_id  IN ($Allmerchant) )x group by status ) as Totaldecfee  
						"); 
		} else {
			$getDashboard = $this->db->query("SELECT 

			(SELECT sum(amount) as Totaljan from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 = '01'  and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 = '01'   and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 = '01'   and status='confirm' )x group by status ) as Totaljan   ,
			(SELECT sum(amount) as Totalfeb from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfeb   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarch   ,
			(SELECT sum(amount) as Totalaprl from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprl   ,
			(SELECT sum(amount) as Totalmay from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmay   ,
			(SELECT sum(amount) as Totaljune from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljune   ,
			(SELECT sum(amount) as Totaljuly from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljuly   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugust   ,
			(SELECT sum(amount) as Totalsep from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalsep   ,
			(SELECT sum(amount) as Totaloct from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totaloct   ,
			(SELECT sum(amount) as Totalnov from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnov   ,
			(SELECT sum(amount) as Totaldec from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm'   union all SELECT amount,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' union all SELECT amount,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ) as Totaldec   ,
			(SELECT sum(tax) as Totaljantax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and  time1 = '01' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'  and  time1 = '01' and status='confirm' )x group by status ) as Totaljantax   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfebtax   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarchtax   ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprltax   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmaytax   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljunetax   ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljulytax   ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugusttax   ,
			(SELECT sum(tax) as Totalseptax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalseptax   ,
			(SELECT sum(tax) as Totalocttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totalocttax   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnovtax   ,
			(SELECT sum(tax) as Totaldectax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT tax,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT tax,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ) as Totaldectax   ,
			(SELECT sum(fee) as Totaljanfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'   and  time1 = '01' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'    and  time1 = '01' and status='confirm' )x group by status ) as Totaljanfee   ,
			(SELECT sum(fee) as Totalfebfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '02' and  time1 < '04' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfebfee   ,
			(SELECT sum(fee) as Totalmarchfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '04' and  time1 < '06' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarchfee   ,
			(SELECT sum(fee) as Totalaprlfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '06' and  time1 < '08' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprlfee   ,
			(SELECT sum(fee) as Totalmayfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '08' and  time1 < '10' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmayfee   ,
			(SELECT sum(fee) as Totaljunefee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljunefee   ,
			(SELECT sum(fee) as Totaljulyfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljulyfee   ,
			(SELECT sum(fee) as Totalaugustfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugustfee   ,
			(SELECT sum(fee) as Totalsepfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalsepfee   ,
			(SELECT sum(fee) as Totaloctfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totaloctfee   ,
			(SELECT sum(fee) as Totalnovfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$date."' and date_c >= '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT fee,status from pos where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnovfee   ,
			(SELECT sum(fee) as Totaldecfee from ( SELECT fee,status from customer_payment_request where   date_c <= '".$date."' and date_c >= '".$last_date."'   and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT fee,status from recurring_payment where    date_c <= '".$last_date."' and date_c >= '".$date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT fee,status from pos where   date_c = '".$date."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by status ) as Totaldecfee  
									");
		}
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData; 

		//echo "<pre>"; print_r($getDashboardData);die;

		$package_data = $this->admin_model->data_get_where_dow_bymerchant("customer_payment_request",$date,$last_date,$Allmerchant);
		$mem = array();
		$sum=0;
		$member = array();
		$sum_tip=0;
		foreach($package_data as $each) {
			$package['amount'] = '$' .$each->amount;
			$sum += $each->amount;
			$package['tax'] = '$' .$each->tax;
			if($each->type='straight'){
				$package['type'] = 'Invoice';
			} else {
				$package['type'] = $each->type;
			}
			$package['date_c'] = $each->date_c; 
			$package['reference'] = $each->reference;
			$package['tip_amount'] = '$' . $each->tip_amount;
			$sum_tip= $sum_tip + $each->tip_amount;
			$mem[] = $package;
		}
		$data['item'] = $mem;
		
		// $package_data1=$data['item1'] = $this->admin_model->data_get_where_dow_bymerchant("recurring_payment",$date,$last_date,$Allmerchant);
		$package_data2= $this->admin_model->data_get_where_dow_bymerchant("pos",$date,$last_date,$Allmerchant);
	
		$mem1 = array();
		$sum1=0;
		$member = array();

		// if(count($package_data1) > 0) {
		// 	foreach ($package_data1 as $each) {
		// 		$package1['amount'] = $each->amount;
		// 		$sum1 += $each->amount; 
		// 		$package1['tax'] = $each->tax;
		// 		if ($each->type = 'straight') {
		// 			$package1['type'] = 'Invoice';
		// 		} else {
		// 			$package1['type'] = $each->type;
		// 		}
		// 		$package1['date_c'] = $each->date_c;
		// 		$package1['reference'] = $each->reference;
		// 		$mem1[] = $package1;
		// 	}
		// }
		//$data['item1'] =$mem1; 
			
		$mem2 = array();
		$sum2=0;
		$member = array();
		if(count($package_data2) > 0) {
		    
			foreach ($package_data2 as $each) {
				$package2['amount'] = '$' .$each->amount;
				$sum2 += $each->amount;
				$package2['tax'] = '$' .$each->tax;
				if ($each->type = 'straight') {
					$package2['type'] = 'Invoice';
				} else {
					$package2['type'] = $each->type;
				}
					
				$package2['date_c'] = $each->date_c;
				$package2['reference'] = $each->reference;
				$package2['tip_amount'] = '$' . $each->tip_amount;
				$sum_tip= $sum_tip + $each->tip_amount;
				$mem2[] = $package2;
			}
			
		}
		$data['item2'] =$mem2; 
	
		// for refund
	   	$package_data3 = $this->admin_model->get_refund_data_admin($date, $last_date, $Allmerchant);
	    
		$mem3 = array();
		$member3 = array();
		$sum3 = 0;
		$total_refund = 0;
		$tip_refunded=0;
	   	foreach ($package_data3 as $each) {
		   	if ($each->status == 'Chargeback_Confirm') {
		       	$refund_amount = (!empty($each->refund_amount)?$each->refund_amount:$each->amount);
			   	$refund['amount'] = '-$' .$refund_amount;
			   	$refund['tax'] = '$' . $each->tax;
			   	$refund['tip_amount'] = '-$' . $each->tip_amount;
			   	if($each->type == 'straight') {
				   $refund['type'] = 'INV-Refunded';
			   	} else {
				   $refund['type'] = strtoupper($each->type)."-Refunded";
			   	}
			   	$refund['date_c'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
			   	$refund['reference'] = $each->reference;
			   	if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
			   	$refund['Items'] =  '--';
			   	$mem3[] = $refund;
			   	$total_refund += $refund_amount;//$each->refund_amount;
			   	$tip_refunded += $each->tip_amount;
			   
		   	}
	   	}
	   	$data['item_refund'] = $mem3;
		$totalsum = number_format($sum + $sum1 + $sum2, 2);
		$totalsumr ="0.00";
		// $totalsumr = number_format($sum_ref + $sum_ref1, 2);
		$data['item5'] = [
			[
				"Sum_Amount" => "Sum Amount = $ " . $totalsum,
				"is_Customer_name"=>'1',
				"Refund_Amount" => "Refund Amount = $ " . $total_refund,
				"Total_Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2)-($totalsumr), 2),
				"Total_Tip_Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2)
			]
		]; 
        $merged_array=array_merge($data['item'],$data['item2'], $data['item_refund']);
        // array_multisort(array_column($merged_array, "date_c"), SORT_DESC);    
        array_multisort(array_map('strtotime',array_column($merged_array,'date_c')),SORT_DESC, $merged_array);
		$data['item3']= json_encode($merged_array);
		// echo '<pre>';print_r($data);die;

		if($this->input->post('start')!=''){
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('admin/sale',$data); 
		}
	}

	public function sale() {
		$data["title"] = "Admin Panel";
		$data['meta'] = 'Sales Summary';

		$this->load->view('admin/sale_dash',$data);
	}

	public function getSalesSummaryChartData() {
		// echo '<pre>';print_r($_POST);die;
		$response = array();
		$user = array();
		$getA_merchantData->csv_Customer_name = '';

		$date_c = $this->input->post('start');
		$date_cc = $this->input->post('end');
		$employee = $this->input->post('employee');
		$merchnat = $this->input->post('employee');

		// Sales Summary Chart Data
		if ($employee == 'all') {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ) x group by date_c");
			// echo $this->db->last_query();die;
			// echo 'test<pre>';print_r($stmt->result_array());die;

		} elseif ($employee != 'all') {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($merchnat) union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN ($merchnat)  ) x group by date_c");
			// echo $this->db->last_query();die;

		} else {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($merchnat) union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($merchnat)  ) x group by date_c");
		}
		// echo $stmt->num_rows();die;
		// echo '<pre>';print_r($stmt->result_array());die;
		if ($stmt->num_rows() > 0) {
			foreach ($stmt->result_array() as $result) {
				$temp = array(
					'date' 				=> $result['date_c'],
					'amount' 			=> $result['amount'],
					'clicks' 			=> $result['tax'],
					'cost' 				=> $result['fee'],
					'tax' 				=> $result['tax'],
					'converted_people'  => $result['tax'],
					'revenue' 			=> $result['tax'],
					'linkcost' 			=> $result['tax']
				);
				array_push($user, $temp);
			}

		} else {
			$user = array();
			$temp = array(
				'date' 				=> $date_c,
				'amount' 			=> "0",
				'clicks' 			=> "0",
				'cost' 				=> "0",
				'tax' 				=> "0",
				'converted_people' 	=> "0",
				'revenue' 			=> "0",
				'linkcost' 			=> "0"
			);
			array_push($user, $temp);
		}
		$responseData['summaryData'] = $user;

		// Summary Table Data
		$tableData = array();
		if ($employee == 'all') {
			$stmt = $this->db->query("SELECT (SELECT SUM(amount) as Amount from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as Amount,
				(SELECT SUM(amount) as PAmount from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as PAmount,
				(SELECT SUM(tax) as Tax from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as Tax,
				(SELECT SUM(tax) as PTax from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as PTax,
				(SELECT SUM(tip_amount) as tip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as Tip,
				(SELECT SUM(tip_amount) as PTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as PTip,
				(SELECT SUM(tip_amount) as RTip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='Chargeback_Confirm') as RTip,
				(SELECT SUM(tip_amount) as RPTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='Chargeback_Confirm' ) as RPTip,
				(SELECT SUM(fee) as Fee from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as Fee,
				(SELECT SUM(fee) as PFee from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as PFee,
				(select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and  p.status='Chargeback_Confirm') As RAmountPOS,
  				(select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and  p.status='Chargeback_Confirm' ) As RAmountCPR");

		} elseif ($employee == 'merchent') {
			$stmt = $this->db->query("SELECT (SELECT SUM(amount) as Amount from customer_payment_request where date_c > '".$date_c."' and date_c < '".$date_cc."' and status='confirm') as Amount,
				(SELECT SUM(amount) as PAmount from pos where date_c > '".$date_c."' and date_c < '".$date_cc."' and status='confirm') as PAmount,
				(SELECT SUM(tax) as Tax from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as Tax,
				(SELECT SUM(tax) as PTax from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as PTax,
				(SELECT SUM(tip_amount) as tip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $merchnat and status='confirm') as Tip,
				(SELECT SUM(tip_amount) as PTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $merchnat and status='confirm') as PTip,
				(SELECT SUM(tip_amount) as RTip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $merchnat and status='Chargeback_Confirm') as RTip,
				(SELECT SUM(tip_amount) as RPTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $merchnat and status='Chargeback_Confirm') as RPTip,
				(SELECT SUM(fee) as Fee from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as Fee,
				(SELECT SUM(fee) as PFee from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm') as PFee,
				(select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and p.status='Chargeback_Confirm' and r.merchant_id= $merchnat) As RAmountPOS,
  				(select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and  p.status='Chargeback_Confirm' and r.merchant_id= $merchnat) As RAmountCPR");

		} else {
			$stmt = $this->db->query("SELECT (SELECT SUM(amount) as Amount from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm' ) as Amount,
				(SELECT SUM(amount) as PAmount from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm') as PAmount,
				(SELECT SUM(tax) as Tax from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm') as Tax,
				(SELECT SUM(tax) as PTax from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm') as PTax,
				(SELECT SUM(tip_amount) as tip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm') as Tip,
				(SELECT SUM(tip_amount) as PTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm') as PTip,
				(SELECT SUM(tip_amount) as RTip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='Chargeback_Confirm') as RTip,
				(SELECT SUM(tip_amount) as RPTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='Chargeback_Confirm') as RPTip,
				(SELECT SUM(fee) as Fee from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm') as Fee,
				(SELECT SUM(fee) as PFee from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='confirm' ) as PFee,
				(select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and r.merchant_id= $employee and  p.status='Chargeback_Confirm') As RAmountPOS,
  				(select sum(CASE when r.amount is null OR r.amount='' then p.amount else r.amount end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where r.date_c>='".$date_c."' and r.date_c <= '".$date_cc."' and r.merchant_id= $employee and p.status='Chargeback_Confirm') As RAmountCPR");
		}

		if ($stmt->num_rows() > 0) {
			// echo '<pre>';print_r($stmt->result_array());die;
			foreach ($stmt->result_array() as $result2) {
		  		$temp1 = array(
					'label' => 'Amount',
					'people' => $result2['Amount'] + $result2['PAmount'],
					'clicks' => ($result2['RAmountPOS'] + $result2['RAmountCPR']),
					'converted_people' => ($result2['Amount'] + $result2['PAmount']) - ($result2['RAmountPOS'] + $result2['RAmountCPR']),
				);

				$temp2 = array(
					'label' => 'Tax',
					'people' => $result2['Tax'] + $result2['PTax'],
					'clicks' => '0',
					'converted_people' => $result2['Tax'] + $result2['PTax'],
				);

				$temp3 = array(
					'label' => 'Fee',
					'people' => $result2['Fee'] + $result2['PFee'],
					'clicks' => '0',
					'converted_people' => $result2['Fee'] + $result2['PFee'],
				);

				$temp4 = array(
					'label' => 'Tip',
					'people' => $result2['Tip'] + $result2['PTip'],
					'clicks' => $result2['RTip'] + $result2['RPTip'],
					'converted_people' => ($result2['Tip'] + $result2['PTip']) - ($result2['RTip'] + $result2['RPTip']),
				);
				array_push($tableData, $temp1, $temp2, $temp3, $temp4);
			}
		}
		$responseData['summaryTableData'] = $tableData;

		echo json_encode($responseData);
	}

	public function getTODChartData() {
		// echo '<pre>';print_r($_POST);die;
		// TOD Chart Data
		$response = array();
		$user = array();
		$getA_merchantData->csv_Customer_name = '';

		$date_c = $this->input->post('start');
		$date_cc = $this->input->post('end');
		$employee = $this->input->post('employee');

		if($employee == 'all') {
			$getDashboard = $this->db->query("SELECT 
			(SELECT sum(amount) as Totaljan from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 = '01'  and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 = '01'   and status='confirm' )x group by status ) as Totaljan   ,
			(SELECT sum(amount) as Totalfeb from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfeb   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarch   ,
			(SELECT sum(amount) as Totalaprl from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprl   ,
			(SELECT sum(amount) as Totalmay from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmay   ,
			(SELECT sum(amount) as Totaljune from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljune   ,
			(SELECT sum(amount) as Totaljuly from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljuly   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugust   ,
			(SELECT sum(amount) as Totalsep from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalsep   ,
			(SELECT sum(amount) as Totaloct from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totaloct   ,
			(SELECT sum(amount) as Totalnov from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnov   ,
			(SELECT sum(amount) as Totaldec from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '22' and  time1 <= '24' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ) as Totaldec   ,
			(SELECT sum(tax) as Totaljantax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and  time1 = '01' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and  time1 = '01' and status='confirm' )x group by status ) as Totaljantax   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfebtax   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarchtax   ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprltax   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmaytax   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljunetax   ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljulytax   ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugusttax   ,
			(SELECT sum(tax) as Totalseptax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalseptax   ,
			(SELECT sum(tax) as Totalocttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totalocttax   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnovtax   ,
			(SELECT sum(tax) as Totaldectax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ) as Totaldectax   ,
			(SELECT avg(amount)  as Totaljanfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and  time1 = '01' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'    and  time1 = '01' and status='confirm' )x group by status ) as Totaljanfee   ,
			(SELECT avg(amount) as Totalfebfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status ) as Totalfebfee   ,
			(SELECT avg(amount) as Totalmarchfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status ) as Totalmarchfee   ,
			(SELECT avg(amount) as Totalaprlfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status ) as Totalaprlfee   ,
			(SELECT avg(amount) as Totalmayfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) as Totalmayfee   ,
			(SELECT avg(amount) as Totaljunefee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) as Totaljunefee   ,
			(SELECT avg(amount) as Totaljulyfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status ) as Totaljulyfee   ,
			(SELECT avg(amount) as Totalaugustfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) as Totalaugustfee   ,
			(SELECT avg(amount) as Totalsepfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) as Totalsepfee   ,
			(SELECT avg(amount) as Totaloctfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status ) as Totaloctfee   ,
			(SELECT avg(amount) as Totalnovfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) as Totalnovfee   ,
			(SELECT avg(amount) as Totaldecfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT amount,status from pos where   date_c = '".$date_cc."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by status ) as Totaldecfee  
			");

		} else {
		 	$getDashboard = $this->db->query("SELECT 
			(SELECT sum(amount) as Totaljan from (SELECT amount,status from customer_payment_request where date_c <= '".$date_cc."' and date_c >= '".$date_c."' and time1 = '01' and status='confirm' AND merchant_id IN ($employee) union all SELECT amount,status from pos where date_c <= '".$date_cc."' and date_c >= '".$date_c."' and time1 = '01' and status='confirm' AND merchant_id IN ($employee) )x group by status) as Totaljan,
			(SELECT sum(amount) as Totalfeb from (SELECT amount,status from customer_payment_request where date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($employee))x group by status ) as Totalfeb   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalmarch   ,
			(SELECT sum(amount) as Totalaprl from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalaprl   ,
			(SELECT sum(amount) as Totalmay from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalmay   ,
			(SELECT sum(amount) as Totaljune from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljune   ,
			(SELECT sum(amount) as Totaljuly from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljuly   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalaugust   ,
			(SELECT sum(amount) as Totalsep from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalsep   ,
			(SELECT sum(amount) as Totaloct from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaloct   ,
			(SELECT sum(amount) as Totalnov from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalnov   ,
			(SELECT sum(amount) as Totaldec from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaldec   ,
			(SELECT sum(tax) as Totaljantax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."' and time1 = '01' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'  and  time1 = '01' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljantax   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm'  AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalfebtax   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalmarchtax   ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalaprltax   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalmaytax   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljunetax   ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm'  AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljulytax   ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalaugusttax   ,
			(SELECT sum(tax) as Totalseptax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalseptax   ,
			(SELECT sum(tax) as Totalocttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($employee)  )x group by status ) as Totalocttax   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalnovtax   ,
			(SELECT sum(tax) as Totaldectax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '22' and  time1 < '24' and status='confirm' AND merchant_id  IN ($employee) union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '22' and  time1 <= '24' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaldectax   ,
			(SELECT avg(amount) as Totaljanfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and  time1 = '01' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'    and  time1 = '01' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljanfee   ,
			(SELECT avg(amount) as Totalfebfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '02' and  time1 < '04' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalfebfee   ,
			(SELECT avg(amount) as Totalmarchfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '04' and  time1 < '06' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalmarchfee   ,
			(SELECT avg(amount) as Totalaprlfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '06' and  time1 < '08' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalaprlfee   ,
			(SELECT avg(amount) as Totalmayfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '08' and  time1 < '10' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalmayfee   ,
			(SELECT avg(amount) as Totaljunefee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '10' and  time1 < '12' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaljunefee   ,
			(SELECT avg(amount) as Totaljulyfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '12' and  time1 < '14' and status='confirm'  AND merchant_id  IN ($employee) )x group by status ) as Totaljulyfee   ,
			(SELECT avg(amount) as Totalaugustfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '14' and  time1 < '16' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalaugustfee   ,
			(SELECT avg(amount) as Totalsepfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '16' and  time1 < '18' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalsepfee   ,
			(SELECT avg(amount) as Totaloctfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '18' and  time1 < '20' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totaloctfee   ,
			(SELECT avg(amount) as Totalnovfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '20' and  time1 < '22' and status='confirm' AND merchant_id  IN ($employee) )x group by status ) as Totalnovfee   ,
			(SELECT avg(amount) as Totaldecfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'   and time1 >= '22' and  time1 < '24' and status='confirm' AND merchant_id  IN ($employee) union all SELECT amount,status from pos where   date_c = '".$date_cc."'  and time1 >= '22' and  time1 < '24' and status='confirm'  AND merchant_id  IN ($employee) )x group by status ) as Totaldecfee  
			");

		}

		$getDashboardData = $getDashboard->result_array();
		$responseData['getDashboardData'] = $getDashboardData;
		
		echo json_encode($responseData);
	}

	public function getSalesSummaryReportData() {
		// echo '<pre>';print_r($_POST);die;
		// TOD Chart Data
		$response = array();
		$user = array();
		$getA_merchantData->csv_Customer_name = '';

		$date_c = $this->input->post('start');
		$date_cc = $this->input->post('end');
		$employee = $this->input->post('employee');
		$merchnat = $this->input->post('employee');

		$package_data = $this->admin_model->get_sales_summary_report("customer_payment_request",$date_cc,$date_c,$employee);
		$mem = array();
		$sum=0;
		$member = array();
		$sum_tip=0;
		foreach($package_data as $each) {
			$package['amount'] = '$' .$each->amount;
			$sum += $each->amount;
			$package['tax'] = '$' .$each->tax;
			if($each->type='straight'){
				$package['type'] = 'Invoice';
			} else {
				$package['type'] = $each->type;
			}
			$package['date_c'] = $each->date_c; 
			$package['reference'] = $each->reference;
			$package['tip_amount'] = '$' . $each->tip_amount;
			$sum_tip= $sum_tip + $each->tip_amount;
			$mem[] = $package;
		}
		$responseData['item'] = $mem;
		
		$package_data2= $this->admin_model->get_sales_summary_report("pos",$date_cc,$date_c,$employee);
		$mem1 = array();
		$sum1=0;
		$member = array();

		$mem2 = array();
		$sum2=0;
		$member = array();
		if(count($package_data2) > 0) {
			foreach ($package_data2 as $each) {
				$package2['amount'] = '$' .$each->amount;
				$sum2 += $each->amount;
				$package2['tax'] = '$' .$each->tax;
				if ($each->type = 'straight') {
					$package2['type'] = 'Invoice';
				} else {
					$package2['type'] = $each->type;
				}	
				$package2['date_c'] = $each->date_c;
				$package2['reference'] = $each->reference;
				$package2['tip_amount'] = '$' . $each->tip_amount;
				$sum_tip= $sum_tip + $each->tip_amount;
				$mem2[] = $package2;
			}
		}
		$responseData['item2'] =$mem2; 
	
		// for refund
	   	$package_data3 = $this->admin_model->get_sales_summary_report_refund($date_cc, $date_c, $employee);
		$mem3 = array();
		$member3 = array();
		$sum3 = 0;
		$total_refund = 0;
		$tip_refunded=0;
	   	foreach ($package_data3 as $each) {
		   	if ($each->status == 'Chargeback_Confirm') {
		       	$refund_amount = (!empty($each->refund_amount)?$each->refund_amount:$each->amount);
			   	$refund['amount'] = '-$' .$refund_amount;
			   	$refund['tax'] = '$' . $each->tax;
			   	$refund['tip_amount'] = '-$' . $each->tip_amount;
			   	if($each->type == 'straight') {
				   $refund['type'] = 'INV-Refunded';
			   	} else {
				   $refund['type'] = strtoupper($each->type)."-Refunded";
			   	}
			   	$refund['date_c'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
			   	$refund['reference'] = $each->reference;
			   	if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
			   	$refund['Items'] =  '--';
			   	$mem3[] = $refund;
			   	$total_refund += $refund_amount;//$each->refund_amount;
			   	$tip_refunded += $each->tip_amount;
		   	}
	   	}
	   	$responseData['item_refund'] = $mem3;
		$totalsum = number_format($sum + $sum1 + $sum2, 2);
		$totalsumr ="0.00";
		// $totalsumr = number_format($sum_ref + $sum_ref1, 2);
		$responseData['item5'] = [
			[
				"Sum_Amount" => "Sum Amount = $ " . $totalsum,
				"is_Customer_name"=>'1',
				"Refund_Amount" => "Refund Amount = $ " . $total_refund,
				"Total_Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2)-($totalsumr), 2),
				"Total_Tip_Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2)
			]
		]; 
        $merged_array=array_merge($responseData['item'],$responseData['item2'], $responseData['item_refund']);
        array_multisort(array_map('strtotime',array_column($merged_array,'date_c')),SORT_DESC, $merged_array);
		$responseData['item3']= json_encode($merged_array);

		echo json_encode($responseData);
	}

	public function trends_original(){
		$data["title"] ="Admin Panel";
		$data["meta"] ="Sales Trends";

		$today2 = date("Y");
		$last_year = date("Y",strtotime("-1 year"));
		$start = $this->input->post('start');
		$end = $this->input->post('end');
	 	//  $last_date1 = date("Y-m-d",strtotime("-29 days"));
	 	//$date1 = date("Y-m-d");
		if($start!='') {
			$last_date = $start;
			$date = $end;
		} else {
			$last_date = date("Y-m-d",strtotime("-29 days"));
			$date = date("Y-m-d");
		}
		$cday = date("Y-m-d",strtotime("-1 days"));
		$lday = date("Y-m-d",strtotime("-8 days")); 
		$monday = strtotime("last monday");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		$sunday1 = strtotime(date("Y-m-d",$monday)." -7 days");
		$sunday2 = strtotime(date("Y-m-d",$sunday1)." +6 days");
		$this_week_ed1 = date("Y-m-d",$sunday2);
		$this_week_sd1 = date("Y-m-d",$sunday1);
		$this_week_sd = date("Y-m-d",$monday);
		$this_week_ed = date("Y-m-d",$sunday);
		$last_date = date("Y-m-d",strtotime("-8 days"));
		$date = date("Y-m-d",strtotime("-1 days"));
		$getDashboard = $this->db->query("SELECT 
			(SELECT sum(amount) as Monday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday   ,
			(SELECT sum(amount) as Tuesday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday   ,
			(SELECT sum(amount) as Wednesday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday   ,
			(SELECT sum(amount) as Thursday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday   ,
			(SELECT sum(amount) as Friday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'   union all SELECT day1,time1,amount from recurring_payment where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday   ,
			(SELECT sum(amount) as Satuday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday   ,
			(SELECT sum(amount) as Sunday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday   ,
			(SELECT sum(amount) as Monday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_l   ,
			(SELECT sum(amount) as Tuesday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_l   ,
			(SELECT sum(amount) as Wednesday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_l   ,
			(SELECT sum(amount) as Thursday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_l   ,
			(SELECT sum(amount) as Friday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_l   ,
			(SELECT sum(amount) as Satuday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_l   ,
			(SELECT sum(amount) as Sunday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_l   ,
			(SELECT sum(fee) as Monday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_fee   ,
			(SELECT sum(fee) as Tuesday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_fee   ,
			(SELECT sum(fee) as Wednesday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_fee   ,
			(SELECT sum(fee) as Thursday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_fee   ,
			(SELECT sum(fee) as Friday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_fee   ,
			(SELECT sum(fee) as Satuday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_fee   ,
			(SELECT sum(fee) as Sunday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_fee   ,
			(SELECT sum(fee) as Monday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_l_fee   ,
			(SELECT sum(fee) as Tuesday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_l_fee   ,
			(SELECT sum(fee) as Wednesday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_l_fee   ,
			(SELECT sum(fee) as Thursday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_l_fee   ,
			(SELECT sum(fee) as Friday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_l_fee   ,
			(SELECT sum(fee) as Satuday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_l_fee   ,
			(SELECT sum(fee) as Sunday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_l_fee   ,
			(SELECT sum(tax) as Monday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_tax   ,
			(SELECT sum(tax) as Tuesday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_tax   ,
			(SELECT sum(tax) as Wednesday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_tax   ,
			(SELECT sum(tax) as Thursday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_tax   ,
			(SELECT sum(tax) as Friday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_tax   ,
			(SELECT sum(tax) as Satuday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_tax   ,
			(SELECT sum(tax) as Sunday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_tax   ,
			(SELECT sum(tax) as Monday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_l_tax   ,
			(SELECT sum(tax) as Tuesday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_l_tax   ,
			(SELECT sum(tax) as Wednesday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_l_tax   ,
			(SELECT sum(tax) as Thursday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_l_tax   ,
			(SELECT sum(tax) as Friday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_l_tax   ,
			(SELECT sum(tax) as Satuday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_l_tax   ,
			(SELECT sum(tax) as Sunday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_l_tax   ,


			(SELECT sum(amount) as Totaljana from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 = '01' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 = '01' and status='confirm' )x group by day1 ) as Totaljana   ,
			(SELECT sum(amount) as Totalfeba from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '02' and  time1 < '04' and status='confirm' )x group by day1 ) as Totalfeba   ,
			(SELECT sum(amount) as Totalmarcha from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '04' and  time1 < '06' and status='confirm' )x group by day1 ) as Totalmarcha   ,
			(SELECT sum(amount) as Totalaprla from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '06' and  time1 < '08' and status='confirm' )x group by day1 ) as Totalaprla   ,
			(SELECT sum(amount) as Totalmaya from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '08' and  time1 < '10' and status='confirm' )x group by day1 ) as Totalmaya   ,
			(SELECT sum(amount) as Totaljunea from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by day1 ) as Totaljunea   ,
			(SELECT sum(amount) as Totaljulya from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by day1 ) as Totaljulya   ,
			(SELECT sum(amount) as Totalaugusta from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by day1 ) as Totalaugusta   ,
			(SELECT sum(amount) as Totalsepa from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by day1 ) as Totalsepa   ,
			(SELECT sum(amount) as Totalocta from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by day1 ) as Totalocta  ,
			(SELECT sum(amount) as Totalnova from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by day1 ) as Totalnova   ,
			(SELECT sum(amount) as Totaldeca from ( SELECT day1,time1,amount from customer_payment_request where   date_c = '".$date."' and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c = '".$date."' and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by day1 ) as Totaldeca   ,
			(SELECT sum(tax) as Totaljantaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and  time1 = '1' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."' and  time1 = '1' and status='confirm' )x group by day1 ) as Totaljantaxa   ,
			(SELECT sum(tax) as Totalfebtaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm' )x group by day1 ) as Totalfebtaxa   ,
			(SELECT sum(tax) as Totalmarchtaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm' )x group by day1 ) as Totalmarchtaxa   ,
			(SELECT sum(tax) as Totalaprltaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm' )x group by day1 ) as Totalaprltaxa   ,
			(SELECT sum(tax) as Totalmaytaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm' )x group by day1 ) as Totalmaytaxa   ,
			(SELECT sum(tax) as Totaljunetaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by day1 ) as Totaljunetaxa   ,
			(SELECT sum(tax) as Totaljulytaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by day1 ) as Totaljulytaxa   ,
			(SELECT sum(tax) as Totalaugusttaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by day1 ) as Totalaugusttaxa   ,
			(SELECT sum(tax) as Totalseptaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by day1 ) as Totalseptaxa   ,
			(SELECT sum(tax) as Totalocttaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by day1 ) as Totalocttaxa  ,
			(SELECT sum(tax) as Totalnovtaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by day1 ) as Totalnovtaxa   ,
			(SELECT sum(tax) as Totaldectaxa from ( SELECT day1,time1,tax from customer_payment_request where   date_c = '".$date."'  and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c = '".$date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by day1 ) as Totaldectaxa  ,
			(SELECT sum(fee) as Totaljanfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and  time1 = '01' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'   and  time1 = '01' and status='confirm' )x group by day1 ) as Totaljanfeea   ,
			(SELECT sum(fee) as Totalfebfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '02' and  time1 < '04' and status='confirm' )x group by day1 ) as Totalfebfeea   ,
			(SELECT sum(fee) as Totalmarchfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm'  union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '04' and  time1 < '06' and status='confirm' )x group by day1 ) as Totalmarchfeea   ,
			(SELECT sum(fee) as Totalaprlfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '06' and  time1 < '08' and status='confirm' )x group by day1 ) as Totalaprlfeea   ,
			(SELECT sum(fee) as Totalmayfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '08' and  time1 < '10' and status='confirm' )x group by day1 ) as Totalmayfeea   ,
			(SELECT sum(fee) as Totaljunefeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by day1 ) as Totaljunefeea   ,
			(SELECT sum(fee) as Totaljulyfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by day1 ) as Totaljulyfeea   ,
			(SELECT sum(fee) as Totalaugustfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by day1 ) as Totalaugustfeea   ,
			(SELECT sum(fee) as Totalsepfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by day1 ) as Totalsepfeea   ,
			(SELECT sum(fee) as Totaloctfee from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by day1 ) as Totaloctfeea   ,
			(SELECT sum(fee) as Totalnovfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by day1 ) as Totalnovfeea   ,
			(SELECT sum(fee) as Totaldecfeea from ( SELECT day1,time1,fee from customer_payment_request where   date_c = '".$date."'  and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c = '".$date."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by day1 ) as Totaldecfeea,


			(SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where   month = '01' and year = '".$today2."' and status='confirm'    union all SELECT month,amount from pos where   month = '01' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljan   ,
			(SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where   month = '02' and year = '".$today2."' and status='confirm'    union all SELECT month,amount from pos where   month = '02' and year = '".$today2."' and status='confirm' )x group by month ) as Totalfeb   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request where   month = '03' and year = '".$today2."' and status='confirm'    union all SELECT month,amount from pos where   month = '03' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmarch   ,
			(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request where   month = '04' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from pos where   month = '04' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaprl   ,
			(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request where   month = '05' and year = '".$today2."' and status='confirm'    union all SELECT month,amount from pos where   month = '05' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmay   ,
			(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request where   month = '06' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from pos where   month = '06' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljune   ,
			(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where   month = '07' and year = '".$today2."' and status='confirm'    union all SELECT month,amount from pos where   month = '07' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljuly   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where   month = '08' and year = '".$today2."' and status='confirm'  union all SELECT month,amount from pos where   month = '08' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaugust   ,
			(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where   month = '09' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from pos where   month = '09' and year = '".$today2."' and status='confirm' )x group by month ) as Totalsep   ,
			(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where   month = '10' and year = '".$today2."' and status='confirm'    union all SELECT month,amount from pos where   month = '10' and year = '".$today2."' and status='confirm' )x group by month ) as Totaloct   ,
			(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where   month = '11' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from pos where   month = '11' and year = '".$today2."' and status='confirm' )x group by month ) as Totalnov   ,
			(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where   month = '12' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where   month = '12' and year = '".$today2."' and status='confirm' )x group by month ) as Totaldec   ,
			(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request where   month = '01' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from pos where   month = '01' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljanf   ,
			(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request where   month = '02' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '02' and year = '".$today2."' and status='confirm' )x group by month ) as Totalfebf   ,
			(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request where   month = '03' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '03' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmarchf   ,
			(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request where   month = '04' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '04' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaprlf   ,
			(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request where   month = '05' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '05' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmayf   ,
			(SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request where   month = '06' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '06' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljunef   ,
			(SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request where   month = '07' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '07' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljulyf   ,
			(SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request where   month = '08' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '08' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaugustf   ,
			(SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request where   month = '09' and year = '".$today2."' and status='confirm'    union all SELECT month,fee from pos where   month = '09' and year = '".$today2."' and status='confirm' )x group by month ) as Totalsepf   ,
			(SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request where   month = '10' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where   month = '10' and year = '".$today2."' and status='confirm' )x group by month ) as Totaloctf   ,
			(SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request where   month = '11' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from pos where   month = '11' and year = '".$today2."' and status='confirm' )x group by month ) as Totalnovf   ,
			(SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request where   month = '12' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from pos where   month = '12' and year = '".$today2."' and status='confirm' )x group by month ) as Totaldecf   ,
			(SELECT sum(tax) as Totaljantax from ( SELECT month,tax from customer_payment_request where   month = '01' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '01' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljantax   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT month,tax from customer_payment_request where   month = '02' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from pos where   month = '02' and year = '".$today2."' and status='confirm' )x group by month ) as Totalfebtax   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT month,tax from customer_payment_request where   month = '03' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from pos where   month = '03' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmarchtax   ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT month,tax from customer_payment_request where   month = '04' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '04' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaprltax   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT month,tax from customer_payment_request where   month = '05' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '05' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmaytax   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT month,tax from customer_payment_request where   month = '06' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from pos where   month = '06' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljunetax   ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT month,tax from customer_payment_request where   month = '07' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '07' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljulytax   ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT month,tax from customer_payment_request where   month = '08' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from pos where   month = '08' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaugusttax   ,
			(SELECT sum(tax) as Totalseptax from ( SELECT month,tax from customer_payment_request where   month = '09' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from pos where   month = '09' and year = '".$today2."' and status='confirm' )x group by month ) as Totalseptax   ,
			(SELECT sum(tax) as Totalocttax from ( SELECT month,tax from customer_payment_request where   month = '10' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '10' and year = '".$today2."' and status='confirm' )x group by month ) as Totalocttax   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request where   month = '11' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '11' and year = '".$today2."' and status='confirm' )x group by month ) as Totalnovtax   ,
			(SELECT sum(tax) as Totaldectax from ( SELECT month,tax from customer_payment_request where   month = '12' and year = '".$today2."' and status='confirm'    union all SELECT month,tax from pos where   month = '12' and year = '".$today2."' and status='confirm' )x group by month ) as Totaldectax   ,
			(SELECT sum(amount) as Totalbjan from ( SELECT month,amount from customer_payment_request where   month = '01' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from pos where   month = '01' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbjan   ,
			(SELECT sum(amount) as Totalbfeb from ( SELECT month,amount from customer_payment_request where   month = '02' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from pos where   month = '02' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbfeb   ,
			(SELECT sum(amount) as Totalbmarch from ( SELECT month,amount from customer_payment_request where   month = '03' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from pos where   month = '03' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbmarch   ,
			(SELECT sum(amount) as Totalbaprl from ( SELECT month,amount from customer_payment_request where   month = '04' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from pos where   month = '04' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbaprl   ,
			(SELECT sum(amount) as Totalbmay from ( SELECT month,amount from customer_payment_request where   month = '05' and year = '".$last_year."' and status='confirm'    union all SELECT month,amount from pos where   month = '05' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbmay   ,
			(SELECT sum(amount) as Totalbjune from ( SELECT month,amount from customer_payment_request where   month = '06' and year = '".$last_year."' and status='confirm'    union all SELECT month,amount from pos where   month = '06' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbjune   ,
			(SELECT sum(amount) as Totalbjuly from ( SELECT month,amount from customer_payment_request where   month = '07' and year = '".$last_year."' and status='confirm'    union all SELECT month,amount from pos where   month = '07' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbjuly   ,
			(SELECT sum(amount) as Totalbaugust from ( SELECT month,amount from customer_payment_request where   month = '08' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from pos where   month = '08' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbaugust   ,
			(SELECT sum(amount) as Totalbsep from ( SELECT month,amount from customer_payment_request where   month = '09' and year = '".$last_year."' and status='confirm'    union all SELECT month,amount from pos where   month = '09' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbsep   ,
			(SELECT sum(amount) as Totalboct from ( SELECT month,amount from customer_payment_request where   month = '10' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from pos where   month = '10' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalboct   ,
			(SELECT sum(amount) as Totalbnov from ( SELECT month,amount from customer_payment_request where   month = '11' and year = '".$last_year."' and status='confirm'    union all SELECT month,amount from pos where   month = '11' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbnov   ,
			(SELECT sum(amount) as Totalbdec from ( SELECT month,amount from customer_payment_request where   month = '12' and year = '".$last_year."' and status='confirm'    union all SELECT month,amount from pos where   month = '12' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbdec ,
			(SELECT sum(fee) as Totalbjanf from ( SELECT month,fee from customer_payment_request where   month = '01' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '01' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjanf   ,
			(SELECT sum(fee) as Totalbfebf from ( SELECT month,fee from customer_payment_request where   month = '02' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from pos where   month = '02' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbfebf   ,
			(SELECT sum(fee) as Totalbmarchf from ( SELECT month,fee from customer_payment_request where   month = '03' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '03' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmarchf   ,
			(SELECT sum(fee) as Totalbaprlf from ( SELECT month,fee from customer_payment_request where   month = '04' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '04' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaprlf   ,
			(SELECT sum(fee) as Totalbmayf from ( SELECT month,fee from customer_payment_request where   month = '05' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from pos where   month = '05' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmayf   ,
			(SELECT sum(fee) as Totalbjunef from ( SELECT month,fee from customer_payment_request where   month = '06' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '06' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjunef   ,
			(SELECT sum(fee) as Totalbjulyf from ( SELECT month,fee from customer_payment_request where   month = '07' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from pos where   month = '07' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjulyf   ,
			(SELECT sum(fee) as Totalbaugustf from ( SELECT month,fee from customer_payment_request where   month = '08' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from pos where   month = '08' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaugustf   ,
			(SELECT sum(fee) as Totalbsepf from ( SELECT month,fee from customer_payment_request where   month = '09' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '09' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbsepf   ,
			(SELECT sum(fee) as Totalboctf from ( SELECT month,fee from customer_payment_request where   month = '10' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '10' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalboctf   ,
			(SELECT sum(fee) as Totalbnovf from ( SELECT month,fee from customer_payment_request where   month = '11' and year = '".$last_year."' and status='confirm'    union all SELECT month,fee from pos where   month = '11' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbnovf   ,
			(SELECT sum(fee) as Totalbdecf from ( SELECT month,fee from customer_payment_request where   month = '12' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from pos where   month = '12' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbdecf   ,
			(SELECT sum(tax) as Totalbjantax from ( SELECT month,tax from customer_payment_request where   month = '01' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from pos where   month = '01' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjantax   ,
			(SELECT sum(tax) as Totalbfebtax from ( SELECT month,tax from customer_payment_request where   month = '02' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '02' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbfebtax   ,
			(SELECT sum(tax) as Totalbmarchtax from ( SELECT month,tax from customer_payment_request where   month = '03' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '03' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmarchtax   ,
			(SELECT sum(tax) as Totalbaprltax from ( SELECT month,tax from customer_payment_request where   month = '04' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '04' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaprltax   ,
			(SELECT sum(tax) as Totalbmaytax from ( SELECT month,tax from customer_payment_request where   month = '05' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '05' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmaytax   ,
			(SELECT sum(tax) as Totalbjunetax from ( SELECT month,tax from customer_payment_request where   month = '06' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '06' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjunetax   ,
			(SELECT sum(tax) as Totalbjulytax from ( SELECT month,tax from customer_payment_request where   month = '07' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from pos where   month = '07' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjulytax   ,
			(SELECT sum(tax) as Totalbaugusttax from ( SELECT month,tax from customer_payment_request where   month = '08' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '08' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaugusttax   ,
			(SELECT sum(tax) as Totalbseptax from ( SELECT month,tax from customer_payment_request where   month = '09' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '09' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbseptax   ,
			(SELECT sum(tax) as Totalbocttax from ( SELECT month,tax from customer_payment_request where   month = '10' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from pos where   month = '10' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbocttax   ,
			(SELECT sum(tax) as Totalbnovtax from ( SELECT month,tax from customer_payment_request where   month = '11' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '11' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbnovtax   ,
			(SELECT sum(tax) as Totalbdectax from ( SELECT month,tax from customer_payment_request where   month = '12' and year = '".$last_year."' and status='confirm'    union all SELECT month,tax from pos where   month = '12' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbdectax   
			"); 
			// echo $this->db->last_query();die;
			$getDashboardData = $getDashboard->result_array();
			$data['getDashboardData'] = $getDashboardData; 
			// $data['item'] = $this->admin_model->data_get_where_g("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));
			$package_data = $this->admin_model->data_get_where("customer_payment_request", array("status"=>'confirm' ));
			$mem = array();
			$member = array();
			foreach($package_data as $each) {
				$package['amount'] = $each->amount;
				$package['tax'] = $each->tax; 
				$package['type'] = $each->type; 
				$package['date'] = $each->date_c; 
				$mem[] = $package;
			}
			$data['item'] = $mem;
			$data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("status"=>'confirm'));
			$data['item2'] = $this->admin_model->data_get_where_g("pos", array("status"=>'confirm' ));
			//print_r($data);
			if($this->input->post('start') != '') {
				echo json_encode($data);  die();
			} else {
				// print_r($data);
				return $this->load->view('admin/trend_dash',$data);
			}
	}

	public function trends(){
		$data["title"] ="Admin Panel";
		$data["meta"] ="Sales Trends";

		$getDashboard = $this->db->get('sales_trend_admin');
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;

		$package_data = $this->admin_model->data_get_where("customer_payment_request", array("status"=>'confirm' ));
		$mem = array();
		$member = array();
		foreach($package_data as $each) {
			$package['amount'] = $each->amount;
			$package['tax'] = $each->tax; 
			$package['type'] = $each->type; 
			$package['date'] = $each->date_c; 
			$mem[] = $package;
		}
		$data['item'] = $mem;
		$data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("status"=>'confirm'));
		$data['item2'] = $this->admin_model->data_get_where_g("pos", array("status"=>'confirm' ));
		//print_r($data);
		if($this->input->post('start') != '') {
			echo json_encode($data);  die();
		} else {
			// print_r($data);
			return $this->load->view('admin/trend_dash',$data);
		}

		// $this->load->view('admin/trend_dash',$data);
	}

	public function getTrendGraph() {
		$getDashboard = $this->db->get('sales_trend_admin');
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;
		// echo '<pre>';print_r($getDashboardData);die;
		// $data['item'] = $this->admin_model->data_get_where_g("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));
		$package_data = $this->admin_model->data_get_where("customer_payment_request", array("status"=>'confirm' ));
		$mem = array();
		$member = array();
		foreach($package_data as $each) {
			$package['amount'] = $each->amount;
			$package['tax'] = $each->tax; 
			$package['type'] = $each->type; 
			$package['date'] = $each->date_c; 
			$mem[] = $package;
		}
		$data['item'] = $mem;
		$data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("status"=>'confirm'));
		$data['item2'] = $this->admin_model->data_get_where_g("pos", array("status"=>'confirm' ));
		echo json_encode($data);die;
	}


	public function getTrendsWeekAndMonthChart() {
		// echo 123;die;
		$today2 = date("Y");
		$last_year = date("Y",strtotime("-1 year"));

		if($start!='') {
			$last_date = $start;
			$date = $end;
		} else {
			$last_date = date("Y-m-d",strtotime("-29 days"));
			$date = date("Y-m-d");
		}
		$cday = date("Y-m-d",strtotime("-1 days"));
		$lday = date("Y-m-d",strtotime("-8 days")); 
		$monday = strtotime("last monday");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		$sunday1 = strtotime(date("Y-m-d",$monday)." -7 days");
		$sunday2 = strtotime(date("Y-m-d",$sunday1)." +6 days");
		$this_week_ed1 = date("Y-m-d",$sunday2);
		$this_week_sd1 = date("Y-m-d",$sunday1);
		$this_week_sd = date("Y-m-d",$monday);
		$this_week_ed = date("Y-m-d",$sunday);
		$last_date = date("Y-m-d",strtotime("-8 days"));
		$date = date("Y-m-d",strtotime("-1 days"));

		$getDashboard = $this->db->query("SELECT 
			(SELECT sum(amount) as Monday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday   ,
			(SELECT sum(amount) as Tuesday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday   ,
			(SELECT sum(amount) as Wednesday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday   ,
			(SELECT sum(amount) as Thursday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday   ,
			(SELECT sum(amount) as Friday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'   union all SELECT day1,time1,amount from recurring_payment where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday   ,
			(SELECT sum(amount) as Satuday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday   ,
			(SELECT sum(amount) as Sunday from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday   ,
			(SELECT sum(amount) as Monday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_l   ,
			(SELECT sum(amount) as Tuesday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_l   ,
			(SELECT sum(amount) as Wednesday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_l   ,
			(SELECT sum(amount) as Thursday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_l   ,
			(SELECT sum(amount) as Friday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_l   ,
			(SELECT sum(amount) as Satuday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_l   ,
			(SELECT sum(amount) as Sunday_l from ( SELECT day1,time1,amount from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,amount from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_l   ,
			(SELECT sum(fee) as Monday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_fee   ,
			(SELECT sum(fee) as Tuesday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_fee   ,
			(SELECT sum(fee) as Wednesday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_fee   ,
			(SELECT sum(fee) as Thursday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_fee   ,
			(SELECT sum(fee) as Friday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_fee   ,
			(SELECT sum(fee) as Satuday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_fee   ,
			(SELECT sum(fee) as Sunday from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_fee   ,
			(SELECT sum(fee) as Monday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_l_fee   ,
			(SELECT sum(fee) as Tuesday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_l_fee   ,
			(SELECT sum(fee) as Wednesday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_l_fee   ,
			(SELECT sum(fee) as Thursday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_l_fee   ,
			(SELECT sum(fee) as Friday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_l_fee   ,
			(SELECT sum(fee) as Satuday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_l_fee   ,
			(SELECT sum(fee) as Sunday_l from ( SELECT day1,time1,fee from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,fee from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_l_fee   ,
			(SELECT sum(tax) as Monday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_tax   ,
			(SELECT sum(tax) as Tuesday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_tax   ,
			(SELECT sum(tax) as Wednesday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_tax   ,
			(SELECT sum(tax) as Thursday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_tax   ,
			(SELECT sum(tax) as Friday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_tax   ,
			(SELECT sum(tax) as Satuday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_tax   ,
			(SELECT sum(tax) as Sunday from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_tax   ,
			(SELECT sum(tax) as Monday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by day1 ) as Monday_l_tax   ,
			(SELECT sum(tax) as Tuesday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by day1 ) as Tuesday_l_tax   ,
			(SELECT sum(tax) as Wednesday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by day1 ) as Wednesday_l_tax   ,
			(SELECT sum(tax) as Thursday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by day1 ) as Thursday_l_tax   ,
			(SELECT sum(tax) as Friday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by day1 ) as Friday_l_tax   ,
			(SELECT sum(tax) as Satuday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'   union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by day1 ) as Satuday_l_tax   ,
			(SELECT sum(tax) as Sunday_l from ( SELECT day1,time1,tax from customer_payment_request where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'    union all SELECT day1,time1,tax from pos where   date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by day1 ) as Sunday_l_tax
		");
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;

		$package_data = $this->admin_model->data_get_where("customer_payment_request", array("status"=>'confirm'));
		$mem = array();
		$member = array();
		foreach($package_data as $each) {
			$package['amount'] = $each->amount;
			$package['tax'] = $each->tax; 
			$package['type'] = $each->type; 
			$package['date'] = $each->date_c; 
			$mem[] = $package;
		}
		$data['item'] = $mem;
		$data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("status"=>'confirm'));
		$data['item2'] = $this->admin_model->data_get_where_g("pos", array("status"=>'confirm' ));
		//print_r($data);
		echo json_encode($data);die();
	}
}

?>
