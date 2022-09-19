<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Subadmin_graph_dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('pos_model');
		$this->load->model('session_checker_model');
		//if (!$this->session_checker_model->chk_session()) {
			//redirect('admin');
		//}
		date_default_timezone_set("America/Chicago");
    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);
    }
    
    public function index()
    {
        
        $response = array();
        $user = array(); 
       
       $date_c = $_GET['start'];
       $date_cc = $_GET['end'];
       $merchnat = $_GET['merchant'];
       $employee = $_GET['employee'];
    
       //print_r($this->session->userdata('subadmin_assign_merchant'));
        
       if($_GET['employee']=='all') {
            if(!empty($this->session->userdata('subadmin_assign_merchant')))
            { 
                $Allmerchant=$this->session->userdata('subadmin_assign_merchant'); 
                $Allmerchant = rtrim($Allmerchant, ',');
                $getQuery=$this->db->query("SELECT sum(amount) as amount,sum(tax) as tax,avg(amount) as fee,date_c from ( SELECT amount,tax,date_c from pos where  date_c >='$date_c' and date_c <= '$date_cc' and status='confirm' and merchant_id IN ($Allmerchant)     ) x group by date_c");
            }else
            {
                $getQuery=$this->db->query("SELECT sum(amount) as amount,sum(revenue) as tax,avg(amount) as fee,name,date_c from ( SELECT amount,revenue,date_c from infinicept_transaction where  date_c >='$date_c' and date_c <= '$date_cc' and status='confirm'      ) x group by date_c");
            }
         }
       elseif($_GET['employee']=='merchent') {
          $getQuery=$this->db->query("SELECT sum(amount) as amount,sum(revenue) as tax,avg(amount) as fee,date_c from ( SELECT amount,revenue,fee,date_c from infinicept_transaction where  date_c >='$date_c' and date_c <='$date_cc' and status='confirm' and merchant_id IN ($employee)   ) x group by date_c"); 
        }
       else
       {
        // echo 'sss'; die();
        //    $getQuery=$this->db->query("SELECT sum(amount) as amount,sum(revenue) as tax,avg(amount) as fee,date_c from ( SELECT amount,revenue,fee,date_c from infinicept_transaction where  date_c >='$date_c' and date_c <='$date_cc' and status='confirm' and merchant_id IN ($employee)     ) x group by date_c");

            $getQuery=$this->db->query("SELECT sum(amount) as amount,sum(tax) as tax,avg(amount) as fee,date_c from ( SELECT amount,tax,date_c from pos where  date_c >='$date_c' and date_c <= '$date_cc' and status='confirm' and merchant_id='".$employee."'    ) x group by date_c"); 
       }
      
       $resultdata=$getQuery->result(); 
       
        if(count($resultdata) > 0 )
        {
          

          foreach($resultdata as $resultdataValue)
          {

            //print_r($resultdataValue); die; 
            $temp = array('date' => $resultdataValue->date_c,'amount' => $resultdataValue->amount,'clicks' => $resultdataValue->tax ? $resultdataValue->tax :0,'cost' => $resultdataValue->fee ? $resultdataValue->fee :0,	'tax' => $resultdataValue->tax ? $resultdataValue->tax :0,'converted_people' => $resultdataValue->tax ? $resultdataValue->tax :0,'revenue' => $resultdataValue->tax ? $resultdataValue->tax :0,'linkcost' => $resultdataValue->tax ? $resultdataValue->tax :0);
            array_push($user, $temp);
          }
       }
       else
       {
         $user = array(); 
         $temp = array('date'=>$date_c,'amount'=>"0",'clicks'=>"0",'cost'=>"0",'tax'=>"0",'converted_people'=>"0",'revenue'=>"0",'linkcost'=>"0");
         array_push($user, $temp);
       }
        $response = $user;
        //print_r($response);  die('er'); 

        echo json_encode($response); 




        

    }



    public function report()
    {
        $response = array();
        $user = array(); 
       
       $date_c = $_GET['start'];
       $date_cc = $_GET['end'];
       $merchnat = $_GET['merchant'];
       $employee = $_GET['employee'];   
    
       
        
       if($_GET['employee']=='all') {

            if(!empty($this->session->userdata('subadmin_assign_merchant')))
            {  
                $Allmerchant=$this->session->userdata('subadmin_assign_merchant'); 
                $Allmerchant = rtrim($Allmerchant, ',');
                $getQuery=$this->db->query("SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($Allmerchant)  and  status='confirm' ) as Amount , ( SELECT SUM(amount) as PAmount from pos where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($Allmerchant)  and  status='confirm' ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where   date_c >='$date_c' and date_c <='$date_c'  and merchant_id IN ($Allmerchant)  and  status='confirm' ) as Tax , (SELECT SUM(tax) as PTax from pos where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($Allmerchant)  and  status='confirm' ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($Allmerchant)  and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($Allmerchant)   and  status='confirm' ) as PFee ,  ( SELECT SUM(amount) as RAmount from refund where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($Allmerchant)  and  status='confirm' ) as RAmount");
         
              }else
            {
                $getQuery=$this->db->query("SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as Amount , ( SELECT SUM(amount) as PAmount from pos where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as Tax , (SELECT SUM(tax) as PTax from pos where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where   date_c >='$date_c' and date_c <='$date_cc'   and  status='confirm' ) as PFee ,  ( SELECT SUM(amount) as RAmount from refund where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as RAmount");
            }
         }
       elseif($_GET['employee']=='merchent') {
          $getQuery=$this->db->query(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where  date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as Amount , ( SELECT SUM(amount) as PAmount from pos where  date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as Tax , (SELECT SUM(tax) as PTax from pos where   date_c >='$date_c' and date_c <='$date_cc'   and  status='confirm' ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'   and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where   date_c >='$date_c' and date_c <='$date_cc'   and  status='confirm' ) as PFee ,  ( SELECT SUM(amount) as RAmount from refund where   date_c >='$date_c' and date_c <='$date_cc'    and  status='confirm' ) as RAmount "); 
        }
       else
       {
           $getQuery=$this->db->query(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc' and merchant_id IN ($employee)    and  status='confirm' ) as Amount , ( SELECT SUM(amount) as PAmount from pos where   date_c >='$date_c' and date_c <='$date_cc' and merchant_id IN ($employee)   and  status='confirm' ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($employee)  and  status='confirm' ) as Tax , (SELECT SUM(tax) as PTax from pos where   date_c >='$date_c' and date_c <='$date_cc' and merchant_id IN ($employee)   and  status='confirm' ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($employee)  and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($employee)  and  status='confirm' ) as PFee ,  ( SELECT SUM(amount) as RAmount from refund where   date_c >='$date_c' and date_c <='$date_cc'  and merchant_id IN ($employee)  and  status='confirm' ) as RAmount "); 
       }
      
       $resultdata=$getQuery->result(); 
     
        if(count($resultdata) > 0 )
        {
          

          foreach($resultdata as $resultdataValue)
          {

           // print_r($resultdataValue); die; 
            $temp1  = array('label'=>'Amount', 'people'=>$resultdataValue->Amount + $resultdataValue->PAmount,'clicks'=>$resultdataValue->RAmount,'converted_people'=>($resultdataValue->Amount + $resultdataValue->PAmount) - $resultdataValue->RAmount );
            $temp2 = array('label'=>'Tax', 'people'=>$resultdataValue->Tax + $resultdataValue->PTax ,  'clicks'=>'0',  'converted_people'=>$resultdataValue->Tax + $resultdataValue->PTax);
            $temp3  = array( 'label'=>'Fee', 'people'=>$resultdataValue->Fee + $resultdataValue->PFee,'clicks'=>'0','converted_people'=>$resultdataValue->Fee + $resultdataValue->PFee);
            array_push($user, $temp1, $temp2, $temp3);
           
          }
       }
       else
       {
         $user = array(); 
         $temp  = array('date'=>$date_c,'people'=>"0",'clicks'=>"0",'cost'=>"0",'conversions'=>"0",'converted_people'=>"0",'revenue'=>"0",  'linkcost'=>"0", );
         array_push($user, $temp);
       }
        $response = $user;
        // print_r($response);  die('er'); 

        echo json_encode($response); 
    }





}   //   END 