<?php
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }

  class Merchant_year_graph_new extends CI_Controller {
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
      
      date_default_timezone_set("America/Chicago");
     // ini_set('display_errors', 1);
     // error_reporting(E_ALL);
     
    }

public function index()
{

//echo  $start = $this->uri->segment(2);
//echo  $limit = $this->uri->segment(3);

$getQuery12 = $this->db->query("SELECT count(id) as mid from merchant where  status='active' and user_type='merchant'    ");
$package_data2 = $getQuery12->result_array();
 $itemcount=$package_data2[0]['mid']; 
 $batches1 = round($itemcount / 1); // Number of while-loop calls - around 120.
 $batches = $batches1+1;
for ($i = 0; $i <= $batches; $i++) {

  $offset = $i * 1; // MySQL Limit offset number
  $start=$offset;
  $limit=1;

$getQuery1 = $this->db->query("SELECT id from merchant where  status='active'  and user_type='merchant'  limit $start,$limit ");
          $package_data = $getQuery1->result_array();


    foreach ($package_data as $each) {


    $merchant_id =$each['id'];
    $p_merchant_id =$each['id'];
    $month = date("m");
    $today2 = date("Y");
    $last_year = date("Y", strtotime("-1 year"));
    $last_date = date("Y-m-d", strtotime("-30 days"));
    $date = date("Y-m-d");

     $date_c = date('Y-m-01');
     $date_cc = $date;
   
       if($month=='02' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totalfeb from ( SELECT month,amount,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '02' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '02' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm') )x group by month  ");
          
      $getamount = $amount->result_array();

        

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ");
      
         
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
      
     
      $total_amount = $getamount[0]['Totalfeb'] - $r_getamount[0]['ramount'];
       
          
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totalfeb='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }

 else if($month=='03' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totalmarch from ( SELECT month,amount,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '03' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '03' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm') )x group by month  ");
          
      $getamount = $amount->result_array();

        

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ");


               
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
      
     
      $total_amount = $getamount[0]['Totalmarch'] - $r_getamount[0]['ramount'];
       
          
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totalmarch='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }

  else if($month=='04' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totalaprl from ( SELECT month,amount,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '04' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '04' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm') )x group by month  ");
          
      $getamount = $amount->result_array();    

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ");

               
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
      $total_amount = $getamount[0]['Totalaprl'] - $r_getamount[0]['ramount'];
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totalaprl='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }

 else if($month=='05' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totalmay from ( SELECT month,amount,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '05' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '05' and year = '" . $today2 . "' and (status='confirm' or status='Chargeback_Confirm') )x group by month  ");
          
      $getamount = $amount->result_array();    

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ");

               
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
      $total_amount = $getamount[0]['Totalmay'] - $r_getamount[0]['ramount'];
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totalmay='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }

 else if($month=='06' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totaljune from ( SELECT month,amount,merchant_id,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "'  and date_c>='".$last_date."' and date_c <= '".$date."' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,merchant_id,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "'  and date_c>='".$last_date."' and date_c <= '".$date."' and (status='confirm' or status='Chargeback_Confirm') )x group by merchant_id  ");

             //  echo $this->db->last_query();die;

          
      $getamount = $amount->result_array();    

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$last_date."' and date_c <= '".$date."' and status='confirm' ");

               
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
     echo  $total_amount = $getamount[0]['Totaljune'] - $r_getamount[0]['ramount'];
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totaljune='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }

else if($month=='07' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totaljuly from ( SELECT month,amount,merchant_id,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "'  and date_c>='".$last_date."' and date_c <= '".$date."' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,merchant_id,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "'  and date_c>='".$last_date."' and date_c <= '".$date."' and (status='confirm' or status='Chargeback_Confirm') )x group by merchant_id  ");

             //  echo $this->db->last_query();die;

          
      $getamount = $amount->result_array();    

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$last_date."' and date_c <= '".$date."' and status='confirm' ");

               
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
     echo  $total_amount = $getamount[0]['Totaljuly'] - $r_getamount[0]['ramount'];
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totaljuly='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }

 else if($month=='08' ){
         $amount = $this->db->query("SELECT sum(`amount`) as Totalaugust from ( SELECT month,amount,merchant_id,p_ref_amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "'  and date_c>='".$last_date."' and date_c <= '".$date."' and (status='confirm' or status='Chargeback_Confirm')    union all SELECT month,amount,merchant_id,p_ref_amount from pos where merchant_id = '" . $p_merchant_id . "'  and date_c>='".$last_date."' and date_c <= '".$date."' and (status='confirm' or status='Chargeback_Confirm') )x group by merchant_id  ");

             //  echo $this->db->last_query();die;

          
      $getamount = $amount->result_array();    

            $r_amount = $this->db->query("SELECT sum(`amount`) as ramount from refund where merchant_id = '" . $p_merchant_id . "' and date_c>='".$last_date."' and date_c <= '".$date."' and status='confirm' ");

               
      $r_getamount = $r_amount->result_array();
      //print_r($r_getamount);
      echo $r_getamount[0]['ramount'];
     echo  $total_amount = $getamount[0]['Totalaugust'] - $r_getamount[0]['ramount'];
           $amount = $this->db->query("UPDATE merchant_year_graph_two SET Totalaugust='".$total_amount."'  where merchant_id= '" . $p_merchant_id . "' ");

          // echo $this->db->last_query();die;
 }
       
}
      //echo $this->db->last_query();die;

    }

}



    }