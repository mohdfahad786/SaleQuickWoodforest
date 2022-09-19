<?php
if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Merchant_week_graph_one_cron extends CI_Controller {
		public function __construct() {
			parent::__construct();
		$this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
   
			
			date_default_timezone_set("America/Chicago");
			
      // ini_set('max_execution_time', 6000);
      // ini_set('default_socket_timeout', 6000);

      //  ini_set('display_errors', 1);
      //  error_reporting(E_ALL);
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

public function index()
{

//echo  $start = $this->uri->segment(2);
//echo  $limit = $this->uri->segment(3);

$getQuery12 = $this->db->query("SELECT count(id) as mid from merchant where  status='active' and user_type='merchant' and id=413  ");
          $package_data2 = $getQuery12->result_array();

 $itemcount=$package_data2[0]['mid']; 
 $batches1 = round($itemcount / 1); // Number of while-loop calls - around 120.
 $batches = $batches1+1;
for ($i = 0; $i <= $batches; $i++) {

  $offset = $i * 1; // MySQL Limit offset number
  $start=$offset;
  $limit=1;

$getQuery1 = $this->db->query("SELECT id,time_zone from merchant where  status='active' and user_type='merchant' and id=413 limit $start,$limit ");

//$getQuery1 = $this->db->query("SELECT id,time_zone from merchant where  id='" . $p_merchant_id . "' ");
          $package_data = $getQuery1->result_array();
     
          //echo $this->db->last_query();die;

    foreach ($package_data as $each) {


  echo   $merchant_id =$each['id'];
    $timezone =$each['time_zone'];

    if ($timezone == "") {$timezone = "America/Chicago";}
    date_default_timezone_set($timezone);
    $Zone__GMT = $this->tz_list($timezone);

       
   
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

   
      
    $getDashboard = $this->db->query("INSERT INTO merchant_week_graph values ('',".$merchant_id.",
                 
(SELECT sum(`amount`-`p_ref_amount`) as Monday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Tuesday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and (status='confirm' or partial_refund=1) )x group by merchant_id ) ,
      (SELECT sum(`amount`-`p_ref_amount`) as Wednesday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Thursday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Friday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Satuday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Sunday from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and (status='confirm' or partial_refund=1) union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,

      (SELECT avg(amount) as Monday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Tuesday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Wednesday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm' )x group by merchant_id ),
      (SELECT avg(amount) as Thursday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Friday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Satuday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Sunday_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm' )x group by merchant_id ) ,

      (SELECT sum(tax) as Monday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 1 and status='confirm' )x group by merchant_id ) ,
      (SELECT sum(tax) as Tuesday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 2 and status='confirm' )x group by merchant_id ) ,
      (SELECT sum(tax) as Wednesday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 3 and status='confirm' )x group by merchant_id )  ,
      (SELECT sum(tax) as Thursday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 4 and status='confirm' )x group by merchant_id )  ,
      (SELECT sum(tax) as Friday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 5 and status='confirm' )x group by merchant_id )  ,
      (SELECT sum(tax) as Satuday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 6 and status='confirm' )x group by merchant_id ),
      (SELECT sum(tax) as Sunday_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd' and day1 = 7 and status='confirm' )x group by merchant_id )  ,

      (SELECT sum(`amount`-`p_ref_amount`) as Monday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and (status='confirm' or partial_refund=1) )x group by merchant_id ) ,
      (SELECT sum(`amount`-`p_ref_amount`) as Tuesday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and (status='confirm' or partial_refund=1) union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and (status='confirm' or partial_refund=1) )x group by merchant_id ),
      (SELECT sum(`amount`-`p_ref_amount`) as Wednesday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Thursday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and (status='confirm' or partial_refund=1) )x group by merchant_id ) ,
      (SELECT sum(`amount`-`p_ref_amount`) as Friday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and (status='confirm' or partial_refund=1) union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Satuday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and (status='confirm' or partial_refund=1) )x group by merchant_id )  ,
      (SELECT sum(`amount`-`p_ref_amount`) as Sunday_l from ( SELECT merchant_id,time1,amount,p_ref_amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and (status='confirm' or partial_refund=1)  union all SELECT merchant_id,time1,amount,p_ref_amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and (status='confirm' or partial_refund=1) )x group by merchant_id ) ,

      (SELECT avg(amount) as Monday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm' )x group by merchant_id ) ,
      (SELECT avg(amount) as Tuesday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm' )x group by merchant_id ),
      (SELECT avg(amount) as Wednesday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Thursday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Friday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Satuday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm' )x group by merchant_id )  ,
      (SELECT avg(amount) as Sunday_l_fee from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,amount from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm' )x group by merchant_id )  ,

      (SELECT sum(tax) as Monday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 1 and status='confirm' )x group by merchant_id ) ,
      (SELECT sum(tax) as Tuesday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 2 and status='confirm' )x group by merchant_id )  ,
      (SELECT sum(tax) as Wednesday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 3 and status='confirm' )x group by merchant_id ) ,
      (SELECT sum(tax) as Thursday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 4 and status='confirm' )x group by merchant_id ) ,
      (SELECT sum(tax) as Friday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 5 and status='confirm' )x group by merchant_id )  ,
      (SELECT sum(tax) as Satuday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 6 and status='confirm' )x group by merchant_id ),
      (SELECT sum(tax) as Sunday_l_tax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm'  union all SELECT merchant_id,time1,tax from pos where merchant_id = '$merchant_id' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') <= '$this_week_ed1' and DATE_FORMAT(CONVERT_TZ(date_c, '-5:00', '$Zone__GMT'),'%Y-%m-%d') >= '$this_week_sd1' and day1 = 7 and status='confirm' )x group by merchant_id ) 



                   ) 
		");
}

}

			//echo $this->db->last_query();die;

		}





		}