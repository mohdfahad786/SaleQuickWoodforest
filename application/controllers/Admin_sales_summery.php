<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_sales_summery extends CI_Controller {
 	public function __construct() {
 	    
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('email');
		//$this->load->model('session_checker_model');
		//if(!$this->session_checker_model->chk_session())
		//	redirect('admin');
		date_default_timezone_set("America/Chicago");
	   //ini_set('display_errors', 1);
	   //error_reporting(E_ALL);
	}
	
	public function index() {
		//daily
		 $date_c = date("Y-m-d",strtotime("-29 days"));
		 $date_cc = date("Y-m-d",strtotime("-1 days"));

		// $date_c = date("Y-m-d", strtotime($date_c));
		// $date_cc = date("Y-m-d", strtotime($date_cc));
		$query=$this->db->query("SELECT wf_merchants from admin where id='9'")->result_array();
        $wf_merchants=$query[0]['wf_merchants']; 
        $stmt=" and merchant_id IN('";
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
		$employee = $this->input->post('employee');

		$getDashboard = $this->db->query("INSERT INTO admin_sales_summery_graph_wf values ('', 
			(SELECT sum(amount) as Totaljan from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 = '01'  and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 = '01'   and status='confirm' )x group by status )    ,
			(SELECT sum(amount) as Totalfeb from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status )   ,
			(SELECT sum(amount) as Totalmarch from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status )  ,
			(SELECT sum(amount) as Totalaprl from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status )  ,
			(SELECT sum(amount) as Totalmay from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status ) ,
			(SELECT sum(amount) as Totaljune from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status ) ,
			(SELECT sum(amount) as Totaljuly from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status )   ,
			(SELECT sum(amount) as Totalaugust from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ),
			(SELECT sum(amount) as Totalsep from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status ) ,
			(SELECT sum(amount) as Totaloct from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status )  ,
			(SELECT sum(amount) as Totalnov from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) ,
			(SELECT sum(amount) as Totaldec from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '22' and  time1 <= '24' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status )   ,
			(SELECT avg(amount)  as Totaljanfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and  time1 = '01' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."    and  time1 = '01' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totalfebfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totalmarchfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status )   ,
			(SELECT avg(amount) as Totalaprlfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totalmayfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totaljunefee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status )   ,
			(SELECT avg(amount) as Totaljulyfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totalaugustfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totalsepfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totaloctfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status )    ,
			(SELECT avg(amount) as Totalnovfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT amount,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status ) ,
			(SELECT avg(amount) as Totaldecfee from ( SELECT amount,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT amount,status from pos where   date_c = '".$date_cc."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by status  ) ,
			(SELECT sum(tax) as Totaljantax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and  time1 = '01' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."  and  time1 = '01' and status='confirm' )x group by status )   ,
			(SELECT sum(tax) as Totalfebtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '02' and  time1 < '04' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '02' and  time1 < '04' and status='confirm' )x group by status )   ,
			(SELECT sum(tax) as Totalmarchtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '04' and  time1 < '06' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '04' and  time1 < '06' and status='confirm' )x group by status )  ,
			(SELECT sum(tax) as Totalaprltax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '06' and  time1 < '08' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '06' and  time1 < '08' and status='confirm' )x group by status )   ,
			(SELECT sum(tax) as Totalmaytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '08' and  time1 < '10' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '08' and  time1 < '10' and status='confirm' )x group by status )   ,
			(SELECT sum(tax) as Totaljunetax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '10' and  time1 < '12' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '10' and  time1 < '12' and status='confirm' )x group by status )    ,
			(SELECT sum(tax) as Totaljulytax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '12' and  time1 < '14' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '12' and  time1 < '14' and status='confirm' )x group by status )  ,
			(SELECT sum(tax) as Totalaugusttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '14' and  time1 < '16' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '14' and  time1 < '16' and status='confirm' )x group by status ) ,
			(SELECT sum(tax) as Totalseptax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '16' and  time1 < '18' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '16' and  time1 < '18' and status='confirm' )x group by status )    ,
			(SELECT sum(tax) as Totalocttax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '18' and  time1 < '20' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '18' and  time1 < '20' and status='confirm' )x group by status )   ,
			(SELECT sum(tax) as Totalnovtax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '20' and  time1 < '22' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '20' and  time1 < '22' and status='confirm' )x group by status )    ,
			(SELECT sum(tax) as Totaldectax from ( SELECT tax,status from customer_payment_request where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '22' and  time1 < '24' and status='confirm'    union all SELECT tax,status from pos where   date_c <= '".$date_cc."' and date_c >= '".$date_c."'".$stmt."   and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by status ))   
			
		");
		// echo $this->db->last_query();die;
		
	}

	
}
?>