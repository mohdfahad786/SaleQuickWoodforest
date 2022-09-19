<?php
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }

  class Employee_update extends CI_Controller {
    public function __construct() {
      parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
   
      
      date_default_timezone_set("America/Chicago");
      
      // ini_set('display_errors', 1);
      // error_reporting(E_ALL);
    }

public function index()

{


$getQuery12 = $this->db->query("SELECT count(id) as mid from merchant where  status='active' and user_type='employee'   ");
          $package_data2 = $getQuery12->result_array();
         // print_r($package_data2); die();

 $itemcount=$package_data2[0]['mid']; 
 $batches1 = round($itemcount / 1); // Number of while-loop calls - around 120.
 $batches = $batches1+1;
for ($i = 0; $i <= $batches; $i++) {

  $offset = $i * 1; // MySQL Limit offset number
  $start=$offset;
  $limit=1;

$getQuery1 = $this->db->query("SELECT id,name,l_name from merchant where  status='active' and user_type='employee'  limit $start,$limit ");
          $package_data = $getQuery1->result_array();


    foreach ($package_data as $each) {



        $name=$each['name'].$each['l_name'];
       $cday = date("Y-m-d", strtotime("-1 days"));
             $amount = $this->db->query("UPDATE pos SET sub_merchant_name='".$name."'  where sub_merchant_id= " . $each['id'] . " and date_c='".$cday."' and (sub_merchant_name='' OR sub_merchant_name IS NULL)  ");
       //echo $this->db->last_query();die;
    }
}


    }






  }