 <?php
 ini_set('MAX_EXECUTION_TIME', '-1');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Agent_year extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('Inventory_graph_model');
		$this->load->model('subadmin_model');
		$this->load->model('pos_model');
		$this->load->model('session_checker_model');
		$this->load->model('Home_model');
		$this->load->library('email');
		$this->load->library('twilio');
		// if (!$this->session_checker_model->chk_session_subadmim()) {
		// 	redirect('admin');
		// }
		date_default_timezone_set("America/Chicago");

		//ini_set('display_errors', 1);
	    //error_reporting(E_ALL);
	    // ini_set('max_execution_time', -1);
	}

public function year() {
		$data["title"] = "Reseller Panel";
		$data["meta"] = "Dashboard";
	   $assign_merchant = $this->session->userdata('subadmin_assign_merchant');
	   $subadmin_id = $this->session->userdata('subadmin_id');

	   //$assign_merchant = '324,446,582,566,464,452,564,108,365,533';
	   //$subadmin_id = '15';
	   //print_r($assign_merchant);
	   //print_r($this->session->userdata); 
	   //die();
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$last_date = date("Y-m-d", strtotime("-29 days"));
		$date = date("Y-m-d");
		// $start_date = date("Y-m-01");
		// $end_date = date("Y-m-t");

		// $start = $this->input->post('start');
		// $end = $this->input->post('end');
		// $employee = $this->input->post('employee');
		// //  $last_date1 = date("Y-m-d",strtotime("-29 days"));
		// //$date1 = date("Y-m-d");
		// if ($start == 'undefined') {

		// 	$last_date = date("Y-m-d", strtotime("-29 days"));
		// 	$date = date("Y-m-d");

		// } elseif ($start != '') {
		// 	$last_date = $start;
		// 	$date = $end;

		// } else {
		// 	$last_date = date("Y-m-d", strtotime("-29 days"));
		// 	$date = date("Y-m-d");
		// }
		// if ($employee == 'all') {
		// 	$sub_merchant_id = 0;
		// } elseif ($employee == 'merchant') {
		// 	$sub_merchant_id = 0;
		// } else {
		// 	$sub_merchant_id = $employee;
		// }
	
		$getQuery1 = $this->db->query("SELECT count(id) as id from cron_limit where type ='Merchant_week_graph_one' and date_c ='" . $date . "' and merchant_id='" . $p_merchant_id . "'  ");
            $getEmail1 = $getQuery1->result_array();
          
              echo $id =$getEmail1[0]['id']; 
         if ($id<1) { 
          

          $branch_info1 = array(
            'type' => 'Agent_year_graph',
            'date_c' => $date,
            'merchant_id' => $subadmin_id
            );

            $id111 = $this->admin_model->insert_data("cron_limit", $branch_info1);
            
            if($id111>0){
			$getDashboard_year = $this->db->query("INSERT INTO agent_year_graph values (
				'',".$subadmin_id.",(SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request  where  month = '01' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)     union all SELECT month,amount from pos  where  month = '01' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request  where  month = '02' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '02' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request  where  month = '03' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '03' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request  where  month = '04' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '04' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month ) ,
				(SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request  where  month = '05' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '05' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request  where  month = '06' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '06' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request  where  month = '07' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '07' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request  where  month = '08' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '08' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request  where  month = '09' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '09' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request  where  month = '10' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '10' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request  where  month = '11' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '11' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request  where  month = '12' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '12' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month ) ,
				(SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request  where  month = '01' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '01' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request  where  month = '02' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '02' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request  where  month = '03' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '03' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request  where  month = '04' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '04' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request  where  month = '05' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '05' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,

                (SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request  where  month = '06' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '06' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
                (SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request  where  month = '07' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '07' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request  where  month = '08' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '08' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request  where  month = '09' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '09' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request  where  month = '10' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '10' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request  where  month = '11' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '11' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month ) ,
                (SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request  where  month = '12' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '12' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month ) ,
				(SELECT sum(tax) as Totaljantax from ( SELECT month,tax from customer_payment_request  where  month = '01' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '01' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalfebtax from ( SELECT month,tax from customer_payment_request  where  month = '02' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)   union all SELECT month,tax from pos  where  month = '02' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalmarchtax from ( SELECT month,tax from customer_payment_request  where  month = '03' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '03' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalaprltax from ( SELECT month,tax from customer_payment_request  where  month = '04' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '04' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalmaytax from ( SELECT month,tax from customer_payment_request  where  month = '05' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)   union all SELECT month,tax from pos  where  month = '05' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(tax) as Totaljunetax from ( SELECT month,tax from customer_payment_request  where  month = '06' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '06' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(tax) as Totaljulytax from ( SELECT month,tax from customer_payment_request  where  month = '07' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '07' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalaugusttax from ( SELECT month,tax from customer_payment_request  where  month = '08' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '08' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(tax) as Totalseptax from ( SELECT month,tax from customer_payment_request  where  month = '09' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '09' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalocttax from ( SELECT month,tax from customer_payment_request  where  month = '10' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '10' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request  where  month = '11' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '11' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(tax) as Totaldectax from ( SELECT month,tax from customer_payment_request  where  month = '12' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '12' and year = '" . $today2 . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(amount) as Totalbjan from ( SELECT month,amount from customer_payment_request  where  month = '01' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '01' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )   ,
                (SELECT sum(amount) as Totalbfeb from ( SELECT month,amount from customer_payment_request  where  month = '02' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '02' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )    ,
                (SELECT sum(amount) as Totalbmarch from ( SELECT month,amount from customer_payment_request  where  month = '03' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '03' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )  ,
                (SELECT sum(amount) as Totalbaprl from ( SELECT month,amount from customer_payment_request  where  month = '04' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '04' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )   ,
                (SELECT sum(amount) as Totalbmay from ( SELECT month,amount from customer_payment_request  where  month = '05' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '05' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )   ,
                (SELECT sum(amount) as Totalbjune from ( SELECT month,amount from customer_payment_request  where  month = '06' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '06' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )   ,
                (SELECT sum(amount) as Totalbjuly from ( SELECT month,amount from customer_payment_request  where  month = '07' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '07' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )  ,
                (SELECT sum(amount) as Totalbaugust from ( SELECT month,amount from customer_payment_request  where  month = '08' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '08' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )    ,
                (SELECT sum(amount) as Totalbsep from ( SELECT month,amount from customer_payment_request  where  month = '09' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '09' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )  ,
                (SELECT sum(amount) as Totalboct from ( SELECT month,amount from customer_payment_request  where  month = '10' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '10' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )   ,
                (SELECT sum(amount) as Totalbnov from ( SELECT month,amount from customer_payment_request  where  month = '11' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '11' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )   ,
                (SELECT sum(amount) as Totalbdec from ( SELECT month,amount from customer_payment_request  where  month = '12' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,amount from pos  where  month = '12' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) ) x group by month )  ,
                (SELECT sum(fee) as Totalbjanf from ( SELECT month,fee from customer_payment_request  where  month = '01' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '01' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totalbfebf from ( SELECT month,fee from customer_payment_request  where  month = '02' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '02' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totalbmarchf from ( SELECT month,fee from customer_payment_request  where  month = '03' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '03' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalbaprlf from ( SELECT month,fee from customer_payment_request  where  month = '04' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '04' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalbmayf from ( SELECT month,fee from customer_payment_request  where  month = '05' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '05' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalbjunef from ( SELECT month,fee from customer_payment_request  where  month = '06' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '06' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totalbjulyf from ( SELECT month,fee from customer_payment_request  where  month = '07' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '07' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totalbaugustf from ( SELECT month,fee from customer_payment_request  where  month = '08' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '08' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
                (SELECT sum(fee) as Totalbsepf from ( SELECT month,fee from customer_payment_request  where  month = '09' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '09' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalboctf from ( SELECT month,fee from customer_payment_request  where  month = '10' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '10' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalbnovf from ( SELECT month,fee from customer_payment_request  where  month = '11' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '11' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
                (SELECT sum(fee) as Totalbdecf from ( SELECT month,fee from customer_payment_request  where  month = '12' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,fee from pos  where  month = '12' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbjantax from ( SELECT month,tax from customer_payment_request  where  month = '01' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '01' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbfebtax from ( SELECT month,tax from customer_payment_request  where  month = '02' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '02' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalbmarchtax from ( SELECT month,tax from customer_payment_request  where  month = '03' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '03' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalbaprltax from ( SELECT month,tax from customer_payment_request  where  month = '04' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '04' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )  ,
				(SELECT sum(tax) as Totalbmaytax from ( SELECT month,tax from customer_payment_request  where  month = '05' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '05' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )   ,
				(SELECT sum(tax) as Totalbjunetax from ( SELECT month,tax from customer_payment_request  where  month = '06' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '06' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbjulytax from ( SELECT month,tax from customer_payment_request  where  month = '07' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '07' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbaugusttax from ( SELECT month,tax from customer_payment_request  where  month = '08' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '08' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbseptax from ( SELECT month,tax from customer_payment_request  where  month = '09' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '09' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbocttax from ( SELECT month,tax from customer_payment_request  where  month = '10' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '10' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbnovtax from ( SELECT month,tax from customer_payment_request  where  month = '11' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '11' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month )    ,
				(SELECT sum(tax) as Totalbdectax from ( SELECT month,tax from customer_payment_request where     month = '12' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant)    union all SELECT month,tax from pos  where  month = '12' and year = '" . $last_year . "' and status='confirm'  AND merchant_id IN ($assign_merchant) )x group by month ) ) ");

         //$getDashboardData_year = $getDashboard_year->result_array();
		//print_r($this->db->last_query());
			//die();

        //$getDashboard_yearr = $this->db->query("INSERT INTO agent_year_grap SELECT * FROM agent_year_graph_view_".$subadmin_id." WHERE agent_id='".$subadmin_id."'");

       // $getDashboard_yearr = $this->db->query("CREATE OR REPLACE TABLE agent_year_graph AS SELECT * FROM agent_year_graph_view");
       // $getDashboardData_yearr = $getDashboard_yearr->result_array();

			
		}

} else

{
  exit(); die();
}
		


		}



	}