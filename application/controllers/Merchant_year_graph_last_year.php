<?php
    ini_set('MAX_EXECUTION_TIME', '-1');
    ini_set('memory_limit','2048M');
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Merchant_year_graph_last_year extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->library('form_validation');
			$this->load->model('admin_model'); 
			
			
			date_default_timezone_set("America/Chicago");
			ini_set('display_errors', 1);
		  error_reporting(E_ALL);
		}

public function index()
{


$getQuery1 = $this->db->query("SELECT id from merchant where user_type ='merchant'  ");
          $package_data = $getQuery1->result_array();


    foreach ($package_data as $each) {


    $merchant_id =$each['id'];
	$today2 = date("Y");
    $last_year = date("Y", strtotime("-1 year"));
    $last_date = date("Y-m-d", strtotime("-29 days"));
    $date = date("Y-m-d");
   
      
         $getDashboard = $this->db->query("INSERT INTO merchant_year_graph values ('',".$merchant_id.",'','','','','','','','','','','','','','','','','','','','','','','' ,'','','','','','','','','','','','','',
            
      (SELECT sum(amount) as Totalbjan from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '01' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '01' and year = '" . $last_year . "' and status='confirm' ) x group by month )  ,
              (SELECT sum(amount) as Totalbfeb from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '02' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '02' and year = '" . $last_year . "' and status='confirm' ) x group by month )   ,
                 (SELECT sum(amount) as Totalbmarch from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '03' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '03' and year = '" . $last_year . "' and status='confirm' ) x group by month )   ,
                  (SELECT sum(amount) as Totalbaprl from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '04' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '04' and year = '" . $last_year . "' and status='confirm' ) x group by month )    ,
                     (SELECT sum(amount) as Totalbmay from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '05' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '05' and year = '" . $last_year . "' and status='confirm' ) x group by month ) ,
                       (SELECT sum(amount) as Totalbjune from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '06' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '06' and year = '" . $last_year . "' and status='confirm' ) x group by month ) ,
                        (SELECT sum(amount) as Totalbjuly from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '07' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '07' and year = '" . $last_year . "' and status='confirm' ) x group by month )   ,
                        (SELECT sum(amount) as Totalbaugust from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '08' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '08' and year = '" . $last_year . "' and status='confirm' ) x group by month ) ,
                         (SELECT sum(amount) as Totalbsep from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '09' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '09' and year = '" . $last_year . "' and status='confirm' ) x group by month ) ,
                          (SELECT sum(amount) as Totalboct from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '10' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '10' and year = '" . $last_year . "' and status='confirm' ) x group by month )  ,
                            (SELECT sum(amount) as Totalbnov from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '11' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '11' and year = '" . $last_year . "' and status='confirm' ) x group by month )  ,
      (SELECT sum(amount) as Totalbdec from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '12' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '12' and year = '" . $last_year . "' and status='confirm' ) x group by month ),
               
         
             (SELECT avg(amount) as Totalbjanf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '01' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '01' and year = '" . $last_year . "' and status='confirm' )x group by month )    ,
                 (SELECT avg(amount) as Totalbfebf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '02' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '02' and year = '" . $last_year . "' and status='confirm' )x group by month ) ,
                   (SELECT avg(amount) as Totalbmarchf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '03' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '03' and year = '" . $last_year . "' and status='confirm' )x group by month )    ,
                     (SELECT avg(amount) as Totalbaprlf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '04' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '04' and year = '" . $last_year . "' and status='confirm' )x group by month ) ,
                      (SELECT avg(amount) as Totalbmayf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '05' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '05' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
                          (SELECT avg(amount) as Totalbjunef from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '06' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '06' and year = '" . $last_year . "' and status='confirm' )x group by month ),
                           (SELECT avg(amount) as Totalbjulyf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '07' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '07' and year = '" . $last_year . "' and status='confirm' )x group by month )   ,
                           (SELECT avg(amount) as Totalbaugustf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '08' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '08' and year = '" . $last_year . "' and status='confirm' )x group by month )   ,
                          (SELECT avg(amount) as Totalbsepf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '09' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '09' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
                        (SELECT avg(amount) as Totalboctf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '10' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '10' and year = '" . $last_year . "' and status='confirm' )x group by month ) ,
                       (SELECT avg(amount) as Totalbnovf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '11' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '11' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
                      (SELECT avg(amount) as Totalbdecf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '12' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $merchant_id . "' and month = '12' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
              
        
        (SELECT sum(tax) as Totalbjantax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '01' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '01' and year = '" . $last_year . "' and status='confirm' )x group by month )   ,
               (SELECT sum(tax) as Totalbfebtax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '02' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '02' and year = '" . $last_year . "' and status='confirm' )x group by month )    ,
               (SELECT sum(tax) as Totalbmarchtax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '03' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '03' and year = '" . $last_year . "' and status='confirm' )x group by month )    ,
               (SELECT sum(tax) as Totalbaprltax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '04' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '04' and year = '" . $last_year . "' and status='confirm' )x group by month )    ,
              (SELECT sum(tax) as Totalbmaytax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '05' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '05' and year = '" . $last_year . "' and status='confirm' )x group by month )   ,
               (SELECT sum(tax) as Totalbjunetax from ( SELECT month,tax from customer_payment_request where merchant_id  = '" . $merchant_id . "' and month = '06' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '06' and year = '" . $last_year . "' and status='confirm' )x group by month ) ,
               (SELECT sum(tax) as Totalbjulytax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '07' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '07' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
               (SELECT sum(tax) as Totalbaugusttax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '08' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '08' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
               (SELECT sum(tax) as Totalbseptax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '09' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '09' and year = '" . $last_year . "' and status='confirm' )x group by month )   ,
              (SELECT sum(tax) as Totalbocttax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '10' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '10' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
               (SELECT sum(tax) as Totalbnovtax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '11' and year = '" . $last_year . "' and status='confirm'   union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '11' and year = '" . $last_year . "' and status='confirm' )x group by month )  ,
               (SELECT sum(tax) as Totalbdectax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $merchant_id . "' and month = '12' and year = '" . $last_year . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $merchant_id . "' and month = '12' and year = '" . $last_year . "' and status='confirm' )x group by month )  ) 
		");
}
			echo $this->db->last_query();die;

		}





		}