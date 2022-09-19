<?php
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }

  class Employee_update_merchant extends CI_Controller {
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

 if( $this->session->userdata('employee_id') ) {
            $merchant_id = $this->session->userdata('employee_id');
            $p_merchant_id = $this->session->userdata('merchant_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
             $p_merchant_id = $this->session->userdata('merchant_id');
        }
echo $p_merchant_id;
echo $merchant_id;

$getQuery1 = $this->db->query("SELECT id,name,l_name from merchant where  status='active' and user_type='employee'  and merchant_id='" . $p_merchant_id . "' ");
          $package_data = $getQuery1->result_array();


    foreach ($package_data as $each) {

        $name=$each['name'].$each['l_name'];
       //$cday = date("Y-m-d", strtotime("-1 days"));
              $cday = date("Y-m-d");
             $amount = $this->db->query("UPDATE pos SET sub_merchant_name='".$name."'  where sub_merchant_id= " . $each['id'] . " and date_c='".$cday."' and (sub_merchant_name='' OR sub_merchant_name IS NULL)  ");
       //echo $this->db->last_query();die;
    }



}

public function get_transaction()

{

 
$merchant_id=543;

$getQuery1 = $this->db->query("SELECT transaction_id,split_payment_id,invoice_no,amount,sub_merchant_id from pos where   date_c='2022-08-04' and transaction_type='full' and (status='confirm' OR status='Chargeback_Confirm')   and merchant_id='" . $merchant_id . "' ");
          $package_data = $getQuery1->result_array();


    foreach ($package_data as $each) {

         $transaction_id=$each['transaction_id'];
         $split_payment_id=$each['split_payment_id'];
          $invoice_no=$each['invoice_no'];
           $amount=$each['amount'];
           $sub_merchant_id=$each['sub_merchant_id'];
        

              $getQuery11 = $this->db->query("SELECT transaction_id from adv_pos_cart_item where    merchant_id='" . $merchant_id . "' and transaction_id='" . $transaction_id . "'  ");
          $package_data11 = $getQuery11->result_array();

             if(empty($package_data11))
             {
               echo 'transaction_id--'.$transaction_id;
                echo 'invoice_no--'.$invoice_no;
                 echo 'amount--'.$amount;
                  echo 'sub_merchant_id--'.$sub_merchant_id;
                echo '<br>';

             }
    }



}


  }