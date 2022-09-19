<?php
ini_set('MAX_EXECUTION_TIME', '-1');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

//header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
@ini_set("output_buffering", "Off");
@ini_set('implicit_flush', 1);
@ini_set('zlib.output_compression', 0);

class Agent extends CI_Controller {
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
		$this->load->model('Revenue_model');
		$this->load->model('session_checker_model');
		$this->load->model('Home_model');
		$this->load->library('email');
		$this->load->library('twilio');
		// if (!$this->session_checker_model->chk_session_subadmim()) {
		// 	redirect('admin');
		// }
		date_default_timezone_set("America/Chicago");

	   // ini_set('display_errors', 1);
	   // error_reporting(E_ALL);
	   
	}

	public function test() {
		$getDashboard = $this->db->query("SELECT * from sales_trend_admin ");
		$dashboard = $getDashboard->result_array();
		print_r($dashboard);
	}

	public function test1() {
		$getDashboard = $this->db->query("SELECT * from table_a ");
		$dashboard = $getDashboard->result_array();
		print_r($dashboard);
	}

	public function dashboard() {
		$data["title"] = "Reseller Panel";
		$data["meta"] = "Dashboard";
	    $assign_merchant = $this->session->userdata('subadmin_assign_merchant');
	    $agent_id=$this->session->userdata('subadmin_id');
	    //print_r($assign_merchant);
		
		$month = date("m");
        $today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$last_date = date("Y-m-d", strtotime("-29 days"));
		$date = date("Y-m-d");
		// $start_date = date("Y-m-01");
		// $end_date = date("Y-m-t");
		$start_date = date("Y-m-d", strtotime("-29 days"));
        $end_date = date("Y-m-d");
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


        $month_firstdate =date('Y-m-01');
        $month_lastdate =date('Y-m-t');

		if($assign_merchant)
		{
			$getDashboard = $this->db->query("SELECT 
		
                (SELECT count(id) as TotalOrders from pos where date_c >= '" . $month_firstdate . "' AND date_c <= '" . $month_lastdate . "'  AND merchant_id IN ($assign_merchant) ) as TotalOrders, 
				
				(SELECT count(id) as TotalFailOrders from customer_payment_request where date_c >= '" . $last_date . "' AND date_c <= '" . $date . "' AND (status='declined' ||  status='block')  AND merchant_id IN ($assign_merchant) ) as TotalFailOrders, 
				(SELECT count(id) as TotalPosFailorder from pos where date_c >= '" . $last_date . "' AND date_c <= '" . $date . "' AND (status='declined' ||  status='block')  AND merchant_id IN ($assign_merchant) ) as TotalPosFailorder,

                (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  AND merchant_id IN ($assign_merchant)  ) as TotalAmount ,
                (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($assign_merchant) ) as TotalAmountRe ,
                (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($assign_merchant) ) as TotalAmountPOS,

                (SELECT count(id) as ApproveAccount from merchant where DATE(created_on) >= '" . $month_firstdate . "' AND DATE(created_on) <= '" . $month_lastdate . "' AND status='active'  AND id IN ($assign_merchant) ) as ApproveAccount,

                (SELECT count(id) as CancelAccount from merchant where DATE(created_on) >= '" . $start_date . "' AND DATE(created_on) <= '" . $end_date . "' AND status='cancel' AND id IN ($assign_merchant) ) as CancelAccount ");

			
			
			if($month=='12'){

         $amount = $this->db->query("SELECT sum(amount) as Totaldec from ( SELECT month,amount from infinicept_transaction where merchant_id IN ($assign_merchant) and month = '12' and year = '" . $today2 . "' and status='confirm'    )x group by month  ");

          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totaldecf from ( SELECT month,amount from infinicept_transaction where merchant_id IN ($assign_merchant) and month = '12' and year = '" . $today2 . "' and status='confirm'    )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(revenue) as Totaldectax from ( SELECT month,revenue from infinicept_transaction where merchant_id IN ($assign_merchant) and month = '12' and year = '" . $today2 . "' and status='confirm'     )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE agent_year_graph SET Totaldec='".$getamount[0]['Totaldec']."' ,Totaldecf='".$getfee[0]['Totaldecf']."',Totaldectax='".$gettax[0]['Totaldectax']."'   where agent_id= '" . $agent_id . "' ");


           }

			$getDashboard_year = $this->db->query("SELECT * from agent_year_graph where agent_id= '" . $agent_id . "' order by id desc limit 1");
			//print_r($this->db->last_query());
			//die();
	$getDashboardData_year = $getDashboard_year->result_array(); 
		//print_r($getDashboardData_year); die();
		$getDashboardData = $getDashboard->result_array();

		}
		else
		{
			$getDashboardData_year=array();
			$getDashboardData=array(); 
		}
		$data['getDashboardData'] = $getDashboardData;
		$data['getDashboardData_year'] = $getDashboardData_year;
		
		$data1 = array();
		// $data['item'] = $this->admin_model->data_get_where_gg($last_date, $date,'confirm',$merchant_id,$employee,'customer_payment_request' );
		$package_data = $this->subadmin_model->data_get_where_dow("customer_payment_request", $date, $last_date);
		
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


		
		$data['item1'] = $this->subadmin_model->data_get_where_dow("recurring_payment", $date, $last_date);
		$data['item2'] = $this->subadmin_model->data_get_where_dow("pos", $date, $last_date);
		$data['item3'] = json_encode(array_merge($data['item'], $data['item1'], $data['item2']));
		//  $data['highchart'] = $this->admin_model->get_details($merchant_id);
		// echo json_encode($data['highchart']);
		// print_r($data); die(); 
		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			 return $this->load->view('subadmin/label_dashboard', $data);
		}

	}
	public function index1() {
		
		$data["title"] = "Agent Panel";
		$today2 = date("Y");
		$last_year = date("Y", strtotime("-1 year"));
		$last_date = date("Y-m-d", strtotime("-29 days"));
		$date = date("Y-m-d");
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		if(!empty($this->input->post('employee')) ) { $employee=$this->input->post('employee'); }
		// $last_date1 = date("Y-m-d",strtotime("-29 days"));
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
		//print_r();  die(); 
		$assign_merchant = $this->session->userdata('subadmin_assign_merchant');
		if(!empty($this->input->post('employee')) &&  $this->input->post('employee')=='all' ) {
            $merchantid=explode(',',$assign_merchant); 
		} else if(!empty($this->input->post('employee')) && $this->input->post('employee')!='all' ) {
			$merchantid=explode(',',$employee); 
		} else {
			$merchantid=explode(',',$assign_merchant); 
		}
		 // echo $merchantid; die('Die'); 
		// $m="SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm' AND merchant_id IN ($assign_merchant) "; 
		// $n="SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm' AND merchant_id IN ($assign_merchant)";
		// print_r($m);
		// echo "<br/>";
		// print_r($n);
		// die("Query"); 

		if ($employee == 'all') {
			$getDashboard = $this->db->query("SELECT
              	(SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($assign_merchant)  ) as TotalAmount ,
              	(SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($assign_merchant) ) as TotalAmountRe ,
              	(SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($assign_merchant) ) as TotalAmountPOS
		 	"); 
          	$DashboardCountData = $this->db->query("SELECT 
             	( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm' AND merchant_id IN ($assign_merchant) ) as TotalOrders, 
			 	( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm' AND merchant_id IN ($assign_merchant) ) as TotalPosorder ,
			 	( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  status='pending'  AND merchant_id IN ($assign_merchant) ) as TotalpendingOrders,
			  	( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = CURDATE()  AND merchant_id IN ($assign_merchant) ) as NewTotalOrders, 
			 	( SELECT count(id) as TotalPosordernew from pos where  date_c = CURDATE() AND merchant_id IN ($assign_merchant) ) as TotalPosordernew ,
             	( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block') AND merchant_id IN ($assign_merchant) ) as TotalFailOrders, 
			 	( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block')   AND merchant_id IN ($assign_merchant)  ) as TotalPosFailorder
		 	"); 

		} elseif ($employee == 'merchant') {
			$getDashboard = $this->db->query("SELECT
              	(SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  AND merchant_id IN ($employee)) as TotalAmount ,
              	(SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) ) as TotalAmountRe ,
              	(SELECT sum(amount) as TotalAmountPOS from pos where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) ) as TotalAmountPOS
		 	");
		 	$DashboardCountData = $this->db->query("SELECT 
             	( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm' AND merchant_id IN ($employee) ) as TotalOrders, 
			 	( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND status='confirm' AND merchant_id IN ($employee) ) as TotalPosorder ,
			 	( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  status='pending'  AND merchant_id IN ($employee)) as TotalpendingOrders,
			 	( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND date_c = CURDATE() AND merchant_id IN ($employee)) as NewTotalOrders, 
			 	( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  date_c = CURDATE() AND merchant_id IN ($employee)) as TotalPosordernew ,
             	( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block') AND merchant_id IN ($employee)) as TotalFailOrders, 
			 	( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND  ( status='declined' ||  status='block')  AND merchant_id IN ($employee) ) as TotalPosFailorder
		 	"); 

		} else {
			$getDashboard = $this->db->query("SELECT
              	(SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) ) as TotalAmount ,
              	(SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm'  and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee)) as TotalAmountRe ,
              	(SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee)) as TotalAmountPOS
		 	");
			$DashboardCountData = $this->db->query("SELECT 
				( SELECT count(id) as TotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee)  AND status='confirm'  ) as TotalOrders, 
				( SELECT count(id) as TotalPosorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) AND status='confirm'  ) as TotalPosorder ,
				( SELECT count(id) as TotalpendingOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee)  AND  status='pending'  ) as TotalpendingOrders,
				( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) AND date_c = CURDATE()) as NewTotalOrders, 
				( SELECT count(id) as TotalPosordernew from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) AND  date_c = CURDATE()) as TotalPosordernew ,
				( SELECT count(id) as TotalFailOrders from customer_payment_request where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) AND  ( status='declined' ||  status='block') ) as TotalFailOrders, 
				( SELECT count(id) as TotalPosFailorder from pos where  date_c >= '" . $last_date . "' and date_c <= '" . $date . "' AND merchant_id IN ($employee) AND  ( status='declined' ||  status='block')   ) as TotalPosFailorder
		 	");
		}
        // echo $this->db->last_query(); die('Die'); 
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;
		$DashboardCountData=$DashboardCountData->result_array();
	  
        // print_r($DashboardCountData[0]['TotalPOSConfirm']); die(); 
	    $widgets_data = array(
			'TotalConfirmOrders'=>$DashboardCountData[0]['TotalOrders']+$DashboardCountData[0]['TotalPosorder'], 
			'TotalpendingOrders'=>$DashboardCountData[0]['TotalpendingOrders'], 
			'NewTotalOrders'=>$DashboardCountData[0]['NewTotalOrders']+$DashboardCountData[0]['TotalPosordernew'], 
			'TotalFaildOrders'=>$DashboardCountData[0]['TotalFailOrders']+$DashboardCountData[0]['TotalPosFailorder'],
	  	); 
		$data['widgets_data'] = $widgets_data;
		$data1 = array();
		//  $data['item'] = $this->admin_model->data_get_where_ggg($last_date, $date,'confirm',$employee,'customer_payment_request' );

		$package_data = $this->subadmin_model->data_get_where_ggg_1($last_date, $date, 'confirm', $merchantid, 'customer_payment_request');
		$mem = array();
		$sum=0;
		$member = array();
		$sum_tip = 0;
		foreach ($package_data as $each) {
			$package['amount'] = $each['amount'];
			$sum += $each['amount'];
			$package['tax'] = $each['tax'];
			if ($each['type'] = 'straight') {
				$package['type'] = 'Invoice';
			} else {
				$package['type'] = $each['type'];
			}
			$package['date_c'] = $each['date_c'];
			$package['reference'] = $each['reference'];
			$package['tip_amount'] = '$' . $each['tip_amount'];
			$sum_tip = $sum_tip + $each['tip_amount'];
			$mem[] = $package;
		}

		$data['item'] = $mem; 

		// $package_data1=$data['item1']=$this->subadmin_model->data_get_where_ggg_1($last_date, $date, 'confirm', $merchantid, 'recurring_payment'); 
		$mem1 = array();
		$sum1=0;
		$member = array();
		// foreach ($package_data1 as $each) {
		// 	$package1['amount'] = $each['amount'];
		// 	$sum1 += $each['amount'];
		// 	$package1['tax'] = $each['tax'];
		// 	if ($each['type'] = 'straight') {
		// 		$package1['type'] = 'Invoice';
		// 	} else {
		// 		$package1['type'] = $each['type'];
		// 	}
		// 	$package1['date_c'] = $each['date_c'];
		// 	$package1['reference'] = $each['reference'];
		// 	$mem1[] = $package1;
		// }
		//$data['item1'] =$mem1; 

		$package_data2=$data['item2']=$this->subadmin_model->data_get_where_ggg_1($last_date, $date, 'confirm', $merchantid, 'pos');
        $mem2 = array();
		$sum2=0;
		$member = array();
		foreach ($package_data2 as $each) {

			$package2['amount'] = $each['amount'];
			$sum2 += $each['amount'];
			$package2['tax'] = $each['tax'];
			if ($each['type'] = 'straight') {
				$package2['type'] = 'Invoice';
			} else {
				$package2['type'] = $each['type'];
			}
			$package2['date_c'] = $each['date_c'];
			$package2['reference'] = $each['reference'];
			$package2['tip_amount'] = '$' . $each['tip_amount'];
			$sum_tip= $sum_tip + $each['tip_amount'];
			$mem2[] = $package2;
		}
		$data['item2'] =$mem2; 

		// for refund
	   	$package_data3 = $this->subadmin_model->get_refund_data_admin($date, $last_date, $merchantid);
	   	// echo "<pre>"; print_r($package_data3);die;
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
			   	if($getA_merchantData->csv_Customer_name > 0 ) { 
			   		$refund['name'] = '--';
			   	} 
			   	$refund['Items'] =  '--';
			   	$mem3[] = $refund;
			   	$total_refund += $refund_amount;//$each->refund_amount;
			   	$tip_refunded += $each->tip_amount;
			   
		   }
	   	}
	   	// echo $sum_tip."<br>".$tip_refunded;die;
	   	$data['item_refund'] = $mem3;

		// $invoice_refund = $this->subadmin_model->data_get_where_ggg_refund($last_date, $date, 'confirm', $merchantid, 'customer_payment_request');
		// $mem3 = array();
		// $sum_ref=0;
		// $member = array();
		// foreach ($invoice_refund as $each) {
		// 	$package3['amount'] = '-$' . $each->amount;
		// 	$sum_ref+= $each->amount;
		// 	$package3['tax'] = $each->tax;
		// 	if ($each->type = 'straight') {
		// 		$package3['type'] = 'Invoice-Refund';
		// 	} else {
		// 		$package3['type'] = $each->type . "-Refund";
		// 	}
		// 	$package3['date_c'] = $each->date_c;
		// 	$package3['reference'] = $each->reference;
		// 	$mem3[] = $package3;
		// }
		// $data['invoice_refund'] = $mem3;
		

		// $pos_refund = $this->subadmin_model->data_get_where_ggg_refund($last_date, $date, 'confirm', $merchantid, 'pos');
		// $mem4 = array();
		// $member = array();
		// $sum_ref1=0;
		// foreach ($pos_refund as $each) {
		// 	$package4['amount'] = '-$' . $each->amount;
		// 	$sum_ref1+= $each->amount;
		// 	$package4['tax'] = $each->tax;
		// 	$package4['type'] = $each->type . "-Refund";
		// 	$package4['date_c'] = $each->date_c;
		// 	$package4['reference'] = $each->reference;
		// 	$mem4[] = $package4;
		// }
		// $data['pos_refund'] = $mem4;
		$totalsum = number_format($sum + $sum1 + $sum2, 2);
		$totalsumr = number_format($sum_ref + $sum_ref1, 2);
        $data['item5'] = [
			[
				"Sum_Amount" => "Sum Amount = $ " . $totalsum,
				"is_Customer_name"=>'1',
				"Refund_Amount" => "Refund Amount = $ " . $total_refund,
				"Total_Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2)-($sum_ref + $sum_ref1), 2),
				"Total_Tip_Amount" => "Total Tip Amount = $ " . number_format($sum_tip-$tip_refunded,2)
			]
		]; 
		$arr = array_merge($data['item'], $data['item_refund'], $data['item2']);
		array_multisort(array_column($arr, 'date_c'), SORT_ASC, $arr);
		$data['item3'] = json_encode($arr);


		if ($this->input->post('start') != '') {
			echo json_encode($data);
			die();
		} else {
			return $this->load->view('subadmin/dashboard', $data);
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
	      // print_r($_POST); die;  
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
				//$this->load->view("subadmin/add_subadmin", $data);
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
				//redirect("subadmin/all_subadmin");
			}
		
	}
	public function create_new_subadmin() {
		$data['meta'] = "Create New Agent";
		$data['loc'] = "create_new_subadmin";
		$data['action'] = "Create New Agent";

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
				//$this->load->view("subadmin/add_subadmin", $data);
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
				//redirect("subadmin/all_subadmin");
			}
		} else {
			
			$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
		
			$data['all_merchantList'] = $this->subadmin_model->get_package_details($merchantid);

			$this->load->view("subadmin/add_subadmin", $data);
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
				//$this->load->view("subadmin/add_subadmin", $data);
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
				// $this->session->set_userdata("mymsg", "Data Has Been Updated.");
			    // redirect('subadmin/all_subadmin');
			}

			// $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			// $email = $this->input->post('email') ? $this->input->post('email') : "";
			// $name = $this->input->post('name') ? $this->input->post('name') : "";
			// $status = $this->input->post('status') ? $this->input->post('status') : "";
			// $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			// $password = $this->input->post('password') ? $this->input->post('password') : "";
			// $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			// $view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			// $edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			// $delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			// $active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";
			// $password1 = $this->my_encrypt($cpsw, 'e');

			// if ($cpsw != '') {
			// 	$psw1 = $password1;
			// } else {
			// 	$psw1 = $password;
			// }
			// echo md5($password);
			
			
		
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
			redirect('subadmin/all_subadmin');
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
		$data['loc'] = "edit_subadmin";
		$this->load->view('subadmin/add_subadmin', $data);

	}

	public function Approved_merchant($id) {

		//check data exist

		$this->admin_model->update_data('merchant', array(
			"status" => "active",
		), array(
			"id" => $id,
		));

		$this->session->set_userdata("msg", "Merchant Approved");
		redirect('subadmin/all_merchant');
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
		redirect('subadmin/report/' . $date);
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
		redirect('subadmin/report/' . $date);
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
			redirect('subadmin/update_merchant/' . $id);
			
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
			//redirect('subadmin/all_merchant');
			redirect('subadmin/update_merchant/' . $id);
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
		$this->load->view('subadmin/update_merchant', $data);

	}
	public function all_subadmin() {

		$data = array();

		$package_data = $this->subadmin_model->get_full_details('sub_admin');

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

		$this->load->view('subadmin/all_subadmin', $data);
	}


	public function all_merchant() {

		$data = array();
		$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_agent($status);
			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
            
			$package_data = $this->subadmin_model->get_package_details($merchantid);
		}


		$mem = array();
		$member = array();
		$package_mem = array();
		

		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			// $getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			// $datacount=count($getApplicationDetails);  
			// $applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';

			$package['id'] = $each->id;
			//$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			//$package['applicationstatus'] = $applicationstatus;
			//$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		array_multisort(array_column($mem, 'date'), SORT_ASC, $mem);
		//print_r($mem);
		$data['package_mem'] = $this->subadmin_model->get_package_details_id($merchantid);
		$data['mem'] = $mem;
		// echo '<pre>';print_r($mem);die;
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');
        $data['meta'] = 'All Merchant'; 
		$this->load->view('subadmin/all_merchant', $data);
	}


	public function all_active_merchant() {

		$data = array();
		$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));

		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_merchant($start_date, $end_date, $status);
			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->subadmin_model->get_package_details($merchantid);
		}
		$mem = array();
		$member = array();
        $package_mem = array();
		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			// $getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			// $datacount=count($getApplicationDetails);  
			// $applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';

			$package['id'] = $each->id;
			//$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			//$package['applicationstatus'] = $applicationstatus;
			//$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
	$data['package_mem'] =  $this->subadmin_model->get_package_details_id($merchantid);
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'Active Merchant'; 
		$this->load->view('subadmin/active_merchant', $data);
	}	

public function inactive_merchant() {

		$data = array();
		$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));

		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_merchant($start_date, $end_date, $status);
			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->subadmin_model->get_package_details($merchantid);
		}
		$mem = array();
		$member = array();

		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			// $getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			// $datacount=count($getApplicationDetails);  
			// $applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';

			$package['id'] = $each->id;
			//$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			//$package['applicationstatus'] = $applicationstatus;
			//$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
			$data['package_mem'] =  $this->subadmin_model->get_package_details_id($merchantid);

		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'Inactive Merchant'; 
		$this->load->view('subadmin/inactive_merchant', $data);
	}	

	public function canceled_merchant() {

		$data = array();
		$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_merchant($start_date, $end_date, $status);
			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
	

		} else {
			$package_data = $this->subadmin_model->get_package_details($merchantid);
		}
		$mem = array();
		$member = array();
		$package_mem = array();

		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			// $getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			// $datacount=count($getApplicationDetails);  
			// $applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';

			$package['id'] = $each->id;
			//$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			//$package['applicationstatus'] = $applicationstatus;
			//$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}

		$data['package_mem'] =  $this->subadmin_model->get_package_details_id($merchantid);
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'Canceled Merchant'; 
		$this->load->view('subadmin/all_merchant', $data);
	}

	public function pending_merchant() {

		$data = array();
		$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));

		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_merchant($start_date, $end_date, $status);
			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->subadmin_model->get_package_details($merchantid);
		}
		$mem = array();
		$member = array();
		$package_mem = array();

		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			// $getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			// $datacount=count($getApplicationDetails);  
			// $applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';

			$package['id'] = $each->id;
			//$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			//$package['applicationstatus'] = $applicationstatus;
			//$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['package_mem'] =  $this->subadmin_model->get_package_details_id($merchantid);

		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'Pending Merchant'; 
		$this->load->view('subadmin/all_merchant', $data);
	}

	public function approve_merchant() {

		$data = array();
		$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));

		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_merchant($start_date, $end_date, $status);
			//print_r($package_data); die("okul");  
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			$package_data = $this->subadmin_model->get_package_details($merchantid);
		}
		$mem = array();
		$member = array();
		$package_mem = array();

		foreach ($package_data as $each) {

            $merchant_id=$each->id; 
			// $getApplicationDetails=$this->db->query("SELECT * FROM merchant_api WHERE merchant_id = '$merchant_id' ")->result_array();
			// $datacount=count($getApplicationDetails);  
			// $applicationstatus=($datacount > 0) ? $getApplicationDetails[0]['status_message']: '';

			$package['id'] = $each->id;
			//$package['allDettils'] = json_decode(json_encode($each), true);
			$package['name'] = $each->name;
			$package['business_name'] = $each->business_name;
			$package['business_number'] = $each->business_number;
			$package['business_dba_name'] = $each->business_dba_name;
			$package['id'] = $each->id;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['t_fee'] = $each->t_fee;
			$package['auth_key'] = $each->auth_key;
			//$package['applicationstatus'] = $applicationstatus;
			//$package['merchant_application_id'] = ($datacount > 0) ? $getApplicationDetails[0]['merchant_application_id']: '';
			$package['is_token_system_permission'] = $each->is_token_system_permission;
			$package['created_on'] = $each->created_on;
			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['package_mem'] =  $this->subadmin_model->get_package_details_id($merchantid);

		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'Approved Merchant'; 
		$this->load->view('subadmin/all_merchant', $data);
	}

	public function all_sub_merchant() {

		$data = array();
		if (isset($_POST['mysubmit'])) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_package_details_merchant_sub($start_date, $end_date, $status);
			//echo $this->db->last_query(); die("okly"); 
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		}
		elseif($this->uri->segment(3))
		{
			$v=$this->uri->segment(3); 
			// print_r($v); die(); 
			$package_data = $this->subadmin_model->get_package_details_sub($v);
		}  
		else {
			$merchantid=explode(',',$this->session->userdata('subadmin_assign_merchant'));
			$package_data = $this->subadmin_model->get_package_details_sub($merchantid);
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

		$this->load->view('subadmin/all_sub_merchant', $data);
	}
	
	public function all_customer_request() {
         
		$data = array();
		
		if (isset($_POST['mysubmit'])) {
			$employee = '';
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data=$this->subadmin_model->get_full_details_admin_report_search('customer_payment_request', $date1, $date2, $employee, $status);
		    $data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
           
			$package_data = $this->subadmin_model->get_full_details_admin_orderby('customer_payment_request');
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$getMerchantDetails=$this->db->query("SELECT name FROM merchant WHERE id = '$each->merchant_id' ")->result_array();
			
            $package['merchant_name'] = $getMerchantDetails[0]['name'];
			
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

				$getRefunddata= $this->subadmin_model->get_refund_transaction($each->merchant_id,$each->invoice_no);
				$package['id'] = $each->id;
				$package['name'] = $each->name;
				$package['merchant_id'] = $each->merchant_id;
				$getMerchantDetails=$this->db->query("SELECT name FROM merchant WHERE id = '$each->merchant_id' ")->result_array();
			
            $package['merchant_name'] = $getMerchantDetails[0]['name'];
				$package['email'] = $each->email_id;
				$package['mobile'] = $each->mobile_no;
				$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
				$package['title'] = $each->title;  
				$package['date'] = $each->refund_date; 
				$package['status'] = "Refund"; 
				$package['payment_type'] = $each->payment_type;
				$package['due_date'] = $each->due_date;
				$package['payment_id'] = $each->invoice_no;
				$package['date_c'] = $each->refund_date?$each->refund_date:$getRefunddata->add_date;
				$package['transaction_id'] = $each->refund_transaction_id?$each->refund_transaction_id:$getRefunddata->transaction_id;
				$package['mpayment_id'] = $each->payment_id;
				$package['card_type'] = $each->card_type;
				$mem[] = $package;
			}

		}
		array_multisort(array_column($mem, 'date_c'), SORT_DESC, $mem);
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
		$data['meta'] = 'All Invoice';
		$this->load->view('subadmin/all_customer_request', $data);
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

	public function report_1($Requestdata = null) {
		$data["title"] = "Agent Panel";
		$subadmin_id = $this->session->userdata('subadmin_id');
		if (isset($_POST['mysubmit'])) {
			// echo '<pre>';print_r($_POST);die;
			$employee = $_POST['employee'];
			$status = $_POST['status'];
		    $date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
		    // $year = $_POST['year'];
            //$month = $_POST['month'];
            $year = $_POST['csv_year'];
            $month = $_POST['csv_month'];


            $data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$csv_year = $_POST['csv_year'];
			$csv_month = $_POST['csv_month'];
			$data["csv_year"] = $_POST['csv_year'];
			$data["csv_month"] = $_POST['csv_month'];
			$data["start_date"] = date($csv_year.'-'.$csv_month.'-01');
			$data["end_date"] = date($csv_year.'-'.$csv_month.'-t');
            


            $package_data_full_reporst = $this->subadmin_model->get_full_reports(array(
				'date' => $year,
				'date2' => $month
			));

			// $package_data_full_reporst = $this->subadmin_model->get_full_reports_reseller(array(
			// 	'date' => $date1,
			// 	'date2' => $date2
			// ));
			
		   
		   //	$package_amount = $this->subadmin_model->data_get_where_amount($subadmin_id,$month,$year);
			$data['reposrint_date'] = $date1;
			$data['full_reporst'] = $package_data_full_reporst;
            $data['year'] = $year;
			$data['month'] = $month;
			$data['employee'] = $employee;
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
			//$data['package_amount'] = $package_amount[0]->amount;
			// echo '<pre>';print_r($data);die;

		} else {     

           $data["start_date"] = date('Y-m-01',strtotime("-1 month"));
		   $data["end_date"] = date('Y-m-t',strtotime("-1 month"));
		   $data["csv_year"] = date("Y");
		   $data["csv_month"] = date("m",strtotime("-1 month"));
            $year = date("Y");
            $month = date("m");
            
            $package_data_full_reporst = $this->subadmin_model->get_full_reports(array(
				'date' => $year,
				'date2' => $month
			));
			
			//print_r($package_data_full_reporst); 
		   //die();
			//$package_amount = $this->subadmin_model->data_get_where_amount($subadmin_id,$month,$year);
			$data['full_reporst'] = $package_data_full_reporst;
			$data['year'] = $year;
			$data['month'] = $month;
			//$data['package_amount'] = $package_amount[0]->amount;

			// $data["start_date"] = $_POST['start_date'];
			// $data["end_date"] = $_POST['end_date'];

		    //$data['reposrint_date'] = $reposrint_date;

		}
		
		
		if ($Requestdata != null) {
			$data['reposrint_date'] = $Requestdata;
		}
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$GrosspaymentValume = 0;
		$TotalFeeCaptured = 0;
		$TotalPayout = 0;
		$TotalTransactions = 0;

		foreach ($data['full_reporst'] as $key => $full_reporst) {
		    $GrosspaymentValume = $GrosspaymentValume + $full_reporst['totalAmount'];
		}

		$total_payout = $this->db->query("SELECT sum(amount)  as amount FROM  agent_payout WHERE merchant_id = '$subadmin_id' ")->result_array();
		$data['total_payout'] =$total_payout[0]['amount'];
		
		

		$this->session->unset_userdata('mymsg');
		$data['GrosspaymentValume'] = $GrosspaymentValume;
		$data['TotalFeeCaptured'] = $TotalFeeCaptured;
		$data['TotalTransactions'] = $TotalTransactions;
		//print_r($data);
		 $data['meta'] = 'Residual';
		$this->load->view('subadmin/report1', $data);
	}

	public function report() {

		
		$data = array();
		$mem = array();
		$member = array();
		$data["title"] = "Agent Panel";
		$subadmin_id = $this->session->userdata('subadmin_id');

		if (isset($_POST['mysubmit'])) {
			//$employee = $_POST['employee'];
			//$status = $_POST['status'];

			// $date1 = $_POST['start_date'];
			// $date2 = $_POST['end_date'];

			// $data["start_date"] = $_POST['start_date'];
			// $data["end_date"] = $_POST['end_date'];
			$csv_year = $_POST['csv_year'];
			$csv_month = $_POST['csv_month'];
			$data["csv_year"] = $_POST['csv_year'];
			$data["csv_month"] = $_POST['csv_month'];

			 $data["start_date"] = date($csv_year.'-'.$csv_month.'-01');
			 $data["end_date"] = date($csv_year.'-'.$csv_month.'-t');

		} else {
			

			$data["start_date"] = date('Y-m-01',strtotime("-1 month"));
			$data["end_date"] = date('Y-m-t',strtotime("-1 month"));

			 $data["csv_year"] = date("Y");
			 $data["csv_month"] = date("m",strtotime("-1 month"));
		}


		$package_data_full_reporst = $this->subadmin_model->get_full_reports_reseller(array(
				'csv_year' => $data["csv_year"],
				'csv_month' => $data["csv_month"]
			));

		$package_data_full_payout = $this->subadmin_model->get_full_payout_reseller(array(
				'date' => $data["start_date"],
				'date2' => $data["end_date"]
			));

		//print_r($package_data_full_reporst); 
		//die();

		 $package_data = $this->subadmin_model->get_full_details_agent('sub_admin',$subadmin_id);
		  // print_r($package_data); 
		  // print_r($package_data['0']->commission_p_merchant);
		  // print_r($package_data['0']->assign_merchant);
		 //die();
		// foreach ($package_data as $each) {

			// $package['id'] = $each->id;
			// $package['name'] = $each->name;
			// $package['email'] = $each->email;
			// $package['mob_no'] = $each->mob_no;
			// $package['view_permissions'] = $each->view_permissions;
			// $package['edit_permissions'] = $each->edit_permissions;
			// $package['delete_permissions'] = $each->delete_permissions;
			// $package['active_permissions'] = $each->active_permissions;
			// $package['assign_merchan'] = $each->assign_merchant;
			// $package['buy_rate'] = $each->buy_rent;
			// $package['buyrate_volume'] = $each->buyrate_volume;
			// $package['gateway_fee'] = $each->commission_p_transaction;
			// $package['sign_bonus'] = $each->total_commission;
			// $merchantid=explode(',',$each->assign_merchant);
			// $package['total_merchant'] = count($merchantid);

			$allmerf=$this->session->userdata('subadmin_assign_merchant'); 
            $merchantid=explode(',',$allmerf);
          // print_r($merchantid); 
           foreach ($merchantid as $key => $value) {

           //	echo $value;

           	$total_payout = $this->db->query("SELECT business_dba_name FROM  merchant WHERE id = '".$value."' ")->result_array();
		  $package['name'] =$total_payout[0]['business_dba_name'];
           
            //die();

			 $package_data_report_merchant = $this->subadmin_model->get_full_reports_merchant(array(
				'merchant_id' => $value,
				'csv_year' => $data["csv_year"],
				'csv_month' => $data["csv_month"]
			));
			 //print_r($package_data_report_merchant[0]);
			 //$package['name'] = $package_data_report_merchant[0]['Merchant'];
			 $package['id'] = $value;
             $package['m_amount'] = $package_data_report_merchant[0]['amount'];
             $package['m_transaction'] = $package_data_report_merchant[0]['transaction'];

             $package['m_buy_rate'] = $package_data_report_merchant[0]['buy_rate']+$package_data_report_merchant[0]['buy_rate_valume']; 
             $package['m_gateway_fee'] = $package_data_report_merchant[0]['gateway_fee']; 
             $package['m_buy_rate_valume'] = $package_data_report_merchant[0]['buy_rate_valume']; 

             $package['m_revenue'] = $package_data_report_merchant[0]['revenue'];
             $package['m_cost'] = $package_data_report_merchant[0]['interchangeFee'];
             $profit = $package_data_report_merchant[0]['GrossProfit'] -($package['m_buy_rate']);
             $package['m_profit']=($profit*$package_data['0']->commission_p_merchant)/100;
			 //$package['date'] = $package_data['0']->date;
			 $package['status'] = $package_data['0']->status;

			$mem[] = $package;


           }
		$data['mem'] = $mem;

		$data['GrosspaymentValume'] = $package_data_full_reporst[0]['amount'];
		$data['TotalrevenueCaptured'] = $package_data_full_reporst[0]['revenue'];
		$data['Payout'] = $package_data_full_payout[0]['amount'];
		$data['Cost'] = $package_data_full_reporst[0]['interchangeFee'];
		$data['meta'] = 'Residual';
		$this->load->view('subadmin/report', $data);
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
		echo $this->load->view('subadmin/fund_modal', $data, true);

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

		$this->load->view('subadmin/merchant_detail', $data);
  }
  
      public function all_payout() {

        $bct_id = $this->session->userdata('subadmin_id');
		$data = array();
		$package_data = $this->admin_model->get_full_details_agent_payout($bct_id,'sub_admin');
		//print_r($package_data); die();
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['merchant_id'] = $each->merchant_id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;
			$package['amount'] = $each->amount;
			$package['year'] = $each->year;
			$package['month'] = $each->month;

			$mem[] = $package;
		}
		$data['mem'] = $mem;

		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
		$this->load->view('admin/all_payout', $data);
	}

	public function all_pos_2() {
		//print_r($this->session->userdata); 
		$data = array();
		$data['meta'] = 'Point Of Sale List';

		if ($_POST) {
			// echo '<pre>';print_r($_POST);die;
			$start_date1 = $_POST['start_date'];
			$end_date1 = $_POST['end_date'];

			if (!empty($start_date1)) {
				$start_date = $_POST['start_date'];
			} else {
				$start_date = date("Y-m-d", strtotime("-29 days"));
			}
			if (!empty($end_date1)) {
				$end_date = $_POST['end_date'];
			} else {
				$end_date = date("Y-m-d");
			}
			$status = $_POST['status'];
			$package_data = $this->Revenue_model->get_search_merchant_pos_new_admin($start_date, $end_date, $status, 'infinicept_transaction');

			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
			// echo '<pre>';print_r($data);die;
			
		} else {
			$start_date = date("Y-m-d", strtotime("-29 days"));
			$end_date = date("Y-m-d");

			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			$package_data = $this->Revenue_model->get_full_details_pos_new_admin('infinicept_transaction');
            //echo '<pre>';print_r($package_data);die;
		}

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
	

			//$new_date=$this->dateTimeConvertTimeZone($each->add_date);
			$date = date("M d Y", strtotime($each->transactionDate));
			$settlement_date = date("M d Y", strtotime($each->settlement_date));

		

			$package['id'] = $each->id;
			$package['merchant_id'] = $each->merchant_id;
			$package['merchant_name'] = $each->merchant_name;
			$package['amount'] = number_format($each->authorizationAmount,2);
			$package['revenue'] =  number_format($each->revenue,2);
			$package['interchangeFee'] =  number_format($each->interchangeFee,2);
			$package['networkFees'] =  number_format($each->networkFees,2);
			$package['buy_rate'] = $this->session->userdata('buy_rate');
     		$package['date'] = $date;
     		$package['settlement_date'] = $settlement_date;
			

			$mem[] = $package;
            // echo '<pre>';print_r($each);
		}

		$data['mem'] = $mem;
		$this->load->view('subadmin/all_pos_revenue_dash_transaction', $data);
	}



  public function all_pos() {
		ini_set('memory_limit', '-1');

		$data = array();

		if (isset($_POST['mysubmit'])) {

			$start_date= $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_search_merchant_pos_new_admin($start_date, $end_date, $status, 'pos');
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {

			$package_data = $this->subadmin_model->get_full_details_pos_new_admin('pos');
		}
		$mem = array();
		$member = array();
		// print_r($package_data); die('UI'); 
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['payment_id'] = $each->invoice_no;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;

			$getMerchantDetails=$this->db->query("SELECT name FROM merchant WHERE id = '$each->merchant_id' ")->result_array();
			
            $package['merchant_name'] = $getMerchantDetails[0]['name'];
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['mpayment_id'] = $each->invoice_no;
			
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$package['transaction_id'] = $each->transaction_id;
			$package['card_type'] = $each->card_type;

			$mem[] = $package;
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'All Instore & Mobile'; 
		$this->load->view('subadmin/all_pos_new', $data);
  }

  //POS Listing
	public function pos_list() {
		
		$data = array();
		$_result = $this->subadmin_model->get_datatables();    
		$pos_list = $_result['result'];
        // echo json_encode($_result['query']); die; 
	    
		$no = $_POST['start'];
		foreach ($pos_list as $pos) {
			 $pos_transaction_id=$pos->transaction_id;
			 $get_item_data = $this->subadmin_model->check_pos_optimized_inv('adv_pos_cart_item',$pos_transaction_id);
			 if(count($get_item_data)  > 0 ){ $receipt_type='adv_pos_reciept'; }else{ $receipt_type='pos_reciept'; }
			 if(count($get_item_data)  > 0 ){ $refund_receipt_type='adv_pos_refund_reciept'; }else{ $refund_receipt_type='pos_refund_reciept'; }
			 $typeOfCard=strtolower($pos->card_type); 
			 switch($typeOfCard)
			 {
			   case 'discover':
				 $card_image='discover.png';
				 break;
			   case 'mastercard':
				 $card_image='mastercard.png';
				 break;
			   case 'visa':
				 $card_image='visa.png';
				 break;
			   case 'jcb':
				 $card_image='jcb.png';
				 break;
			   case 'maestro':
				 $card_image='maestro.png';
				 break;
			   case 'dci':
				 $card_image = 'dci.png';
				 break;
			   case 'amex':
				 $card_image='amx.png';
				 break;
			   default :
				 $card_image='other.png';
			 }
			if ($this->input->post('status') != "Chargeback_Confirm") {
				$row = array();
				$merchant_name = $this->admin_model->data_get_where_1('merchant', array('id' => $pos->merchant_id));
				foreach ($merchant_name as $key => $value) {
					$name = $value['business_dba_name'];
				}
				
				$row[] = $pos->transaction_id;
				// $row[] = $pos->card_type;
				$row[] = '<span class="card-type-image" ><img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'"  ></span>';
				$row[] = $name;
				$row[] = $pos->mobile_no;
				$row[] = '<span class="status_success" >$' . number_format($pos->amount, 2) . '</span>';
				if ($pos->status == 'pending') {
					$status = '<span class="status_refund"> ' . $pos->status . '  </span>';
				} elseif ($pos->status == 'confirm' || $pos->status == 'Chargeback_Confirm') {
					$status = '<span class="pos_Status_c"> Confirm </span>';
				} elseif ($pos->status == 'declined') {
					$status = '<span class="pos_Status_cncl"> Declined </span>';
				} else {
					$status = '';
				}
				$row[] = $status;
				// $row[] = $pos->add_date;
				$row[] = date("M d Y h:i A", strtotime($pos->add_date));
				if ($pos->status == 'pending') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank"  class="dropdown-item"><i class="	ti-receipt"></i> Invoice
                         </a>';
				} elseif ($pos->status == 'confirm') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Receipt
                        </a>';
				}
				elseif ($pos->status == 'Chargeback_Confirm') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/'. $pos->invoice_no . '/' . $pos->merchant_id .'" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Receipt
				        </a>';
				} 
				else {
					$invoice_no = '';
				}
				if($invoice_no != ''){
					$row[] = '<div class="dropdown dt-vw-del-dpdwn"> <button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> <div class="dropdown-menu dropdown-menu-right">'
						.$invoice_no.
						'<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="dropdown-item"><i class="ti-eye"></i> Detail</a>'
						.'</div> </div>';
				}
				else{
					$row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> Detail</a>';
				}
				$data[] = $row;
			}

			//for refund tarnsections

			if ($pos->status == 'Chargeback_Confirm') {
				$row = array();
				$merchant_name = $this->admin_model->data_get_where_1('merchant', array('id' => $pos->merchant_id));
			
				foreach ($merchant_name as $key => $value) {
					$name = $value['business_dba_name'];
				}
				$row[] = $pos->refund_transaction_id;
				// $row[] = $pos->card_type;
				$row[] = '<span class="card-type-image" ><img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'"  ></span>';
				$row[] = $name;
				$row[] = $pos->mobile_no;
				$row[] = '<span class="status_success" >$' . number_format($pos->amount, 2) . '</span>';

				$status = '<span class="status_refund"> Refund </span>';

				$row[] = $status;
				// $row[] = $pos->refund_date;
				$row[] = date("M d Y h:i A", strtotime($pos->refund_date));
				if ($pos->status == 'pending') {
					$invoice_no = ' <a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank" class="dropdown-item"><i class="ti-receipt"></i> Invoice</a>';
				} elseif ($pos->status == 'confirm') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>';
				}
				elseif ($pos->status == 'Chargeback_Confirm') {
					$invoice_no = '<a href="'.base_url().$refund_receipt_type.'/'. $pos->invoice_no . '/' . $pos->merchant_id .'" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>
                        </a>';
				}
				else {
					$invoice_no = '';
				}
				if($invoice_no != ''){
					$row[] = '<div class="dropdown dt-vw-del-dpdwn"> <button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> <div class="dropdown-menu dropdown-menu-right">'
						.$invoice_no.
						'<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="dropdown-item"><i class="ti-eye"></i> Detail</a>'
						.'</div> </div>';
				}
				else{
					// $row[] = $invoice_no;
					$row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> Detail</a>';
				}
				$data[] = $row;
			}
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->subadmin_model->count_all(),
			"recordsFiltered" => $this->subadmin_model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
  //  POS LISTING 
  

  public function search_record_column_pos() {
	 
		$searchby = $this->input->post('id');
		//$data['item'] = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
		// $data['item'] = $this->admin_model->search_item($searchby);
		$data['pay_report'] = $this->admin_model->search_record_pos($searchby);
		
		echo $this->load->view('subadmin/show_result_pos', $data, true);

  }

  	public function search_record_column_merchant() {
      	$merchant_id = $this->input->post('id');
      	$merchant_details = $this->db->get_where('merchant', ['id' => $merchant_id])->row();
      	// echo '<pre>'; print_r($merchant_details);die();

      	$stateArr = array(
		    "AL" => 'Alabama',
		    "AK" => 'Alaska',
		    "AZ" => 'Arizona',
		    "AR" => 'Arkansas',
		    "CA" => 'California',
		    "CO" => 'Colorado',
		    "CT" => 'Connecticut',
		    "DE" => 'Delaware',
		    "DC" => 'District Of Columbia',
		    "FL" => 'Florida',
		    "GA" => 'Georgia',
		    "HI" => 'Hawaii',
		    "ID" => 'Idaho',
		    "IL" => 'Illinois',
		    "IN" => 'Indiana',
		    "IA" => 'Iowa',
		    "KS" => 'Kansas',
		    "KY" => 'Kentucky',
		    "LA" => 'Louisiana',
		    "ME" => 'Maine',
		    "MD" => 'Maryland',
		    "MA" => 'Massachusetts',
		    "MI" => 'Michigan',
		    "MN" => 'Minnesota',
		    "MS" => 'Mississippi',
		    "MO" => 'Missouri',
		    "MT" => 'Montana',
		    "NE" => 'Nebraska',
		    "NV" => 'Nevada',
		    "NH" => 'New Hampshire',
		    "NJ" => 'New Jersey',
		    "NM" => 'New Mexico',
		    "NY" => 'New York',
		    "NC" => 'North Carolina',
		    "ND" => 'North Dakota',
		    "OH" => 'Ohio',
		    "OK" => 'Oklahoma',
		    "OR" => 'Oregon',
		    "PA" => 'Pennsylvania',
		    "RI" => 'Rhode Island',
		    "SC" => 'South Carolina',
		    "SD" => 'South Dakota',
		    "TN" => 'Tennessee',
		    "TX" => 'Texas',
		    "UT" => 'Utah',
		    "VT" => 'Vermont',
		    "VA" => 'Virginia',
		    "WA" => 'Washington',
		    "WV" => 'West Virginia',
		    "WI" => 'Wisconsin',
		    "WY" => 'Wyoming'
		);

      	$merchant_address = '';
      	if(!empty($merchant_details->address1)) {
      		$merchant_address.= $merchant_details->address1.', ';
      	}
      	if(!empty($merchant_details->city)) {
      		$merchant_address.= $merchant_details->city.', ';
      	}
      	if(!empty($merchant_details->state)) {
      		foreach ($stateArr as $state_code => $state_name) {
				if($state_code == $merchant_details->state) {
		      		$merchant_address.= $state_name.', ';
				}
			}
      	}
      	$merchant_address = rtrim(trim($merchant_address), ',');
      	if(!empty($merchant_details->zip)) {
      		$merchant_address.= ' '.$merchant_details->zip;
      	}
      	$merchant_details->merchant_address = $merchant_address;
      	// echo $merchant_details->merchant_address;die;
      	echo json_encode($merchant_details);die;
      	// echo $this->load->view('subadmin/show_result_pos_dash', $data, true);
    }

  
  public function edit_profile_old(){
    $this->load->model('profile_model');
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
    $data['upload_loc'] = base_url('logo');  
    //  $package = $this->profile_model->get_merchant_details($this->session->userdata('id'));
    //  print_r($this->session->userdata());  die(); 
    $package = $this->admin_model->data_get_where('sub_admin', array('id' => $this->session->userdata('subadmin_id')));
    
    if($this->input->post('mysubmit'))
    {

     
     $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
     $title = $this->input->post('title') ? $this->input->post('title') : "";
     $psw = $this->input->post('psw') ? $this->input->post('psw') : "";
     $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
     $oldpsw = $this->input->post('oldpsw') ? $this->input->post('oldpsw') : "";
     $name = $this->input->post('name') ? $this->input->post('name') : "";
     $mob_no = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
     $address = $this->input->post('address') ? $this->input->post('address') : "";
     //$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
     $state = $this->input->post('state') ? $this->input->post('state') : "";
     $city = $this->input->post('city') ? $this->input->post('city') : "";
     $zip_code = $this->input->post('zip_code') ? $this->input->post('zip_code') : "";
     $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
     if($cpsw!='' && $oldpsw!="" ) {
		    if($this->my_encrypt($oldpsw, 'e' )==$psw)
		    {
			  $psw1 = $this->my_encrypt($cpsw, 'e' );
			}
			else
			{
			 $psw1=$psw; 
			} 
		}  
		else  
		{ $psw1 = $psw;   }
    
     $package_info=array('name'=>$name,'address'=>$address,'state'=>$state,'city'=>$city,'zip_code'=>$zip_code,'password'=>$psw1,'mob_no'=>$mob_no);
     //print_r($package_info);  die;  
     $this->admin_model->update_data('sub_admin',$package_info,array('id'=>$id));
     $this->session->set_userdata("mymsg","Profile has been updated.");
     redirect(base_url().'agent/edit_profile');
}
else
{
	// print_r($package); die; 
     foreach($package as $pak)
     {
          $data['pak_id'] = $pak->id;
          $data['email'] = $pak->email;
          $data['name'] = $pak->name;
          $data['psw'] = $pak->password;
          $data['mob_no'] = $pak->mob_no;
          $data['status'] = $pak->status;
          $data['address'] = $pak->address;
          $data['city'] = $pak->city;
          $data['state'] = $pak->state;
          $data['zip_code'] = $pak->zip_code;




           $data['total_commission'] = $pak->total_commission;
          $data['ssn'] = $pak->ssn;
          $data['ein_no'] = $pak->ein_no;
          $data['commission_p_merchant'] = $pak->commission_p_merchant;
           $data['commission_p_transaction'] = $pak->commission_p_transaction;
          $data['buy_rent'] = $pak->buy_rent;
         

          break;
     }    
}    

 $data['loc'] = "edit_profile";
 $data['meta'] = 'Update Profile';
 $data['action'] = 'Update';

//  print_r($data);  die();  
$this->load->view('subadmin/edit_profile', $data);
}

	public function edit_profile() {
	    $this->load->model('profile_model');
	    // $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
	    // $this->session->unset_userdata('mymsg');
	    $data['upload_loc'] = base_url('logo');
	    //  $package = $this->profile_model->get_merchant_details($this->session->userdata('id'));
	    
	    $package = $this->admin_model->data_get_where('sub_admin', array('id' => $this->session->userdata('subadmin_id')));
	    
	    if($this->input->post('mysubmit')) {
	    	// echo '<pre>';print_r($_POST);  die(); 
			$id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
			// $title = $this->input->post('title') ? $this->input->post('title') : "";
			$psw = $this->input->post('psw') ? $this->input->post('psw') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$oldpsw = $this->input->post('oldpsw') ? $this->input->post('oldpsw') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$last_name = $this->input->post('last_name') ? $this->input->post('last_name') : "";
			$mob_no = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
			$address = $this->input->post('address') ? $this->input->post('address') : "";
			//$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
			$state = $this->input->post('state') ? $this->input->post('state') : "";
			$city = $this->input->post('city') ? $this->input->post('city') : "";
			$zip_code = $this->input->post('zip_code') ? $this->input->post('zip_code') : "";

			$ssn = $this->input->post('ssn') ? $this->input->post('ssn') : "";
			$ein_no = $this->input->post('ein_no') ? $this->input->post('ein_no') : "";
			// $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
			if($cpsw!='' && $oldpsw!="" ) {
		    	if($this->my_encrypt($oldpsw, 'e' )==$psw) {
			  		$psw1 = $this->my_encrypt($cpsw, 'e' );
				} else {
			 		$psw1=$psw; 
				}
			} else {
				$psw1 = $psw;
			}

			if($_FILES['mypic']['name']) {
				$path = $_FILES['mypic']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$filename='image_'.date('YmdHi').'.'.$ext; 
				$_FILES['mypic']['name']=$filename;
				$config['upload_path'] = 'logo/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_width'] = 70000;
				$config['max_height'] = 70000;
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('mypic')) {
					$fInfo = $this->upload->data();
					$mypic = $fInfo['file_name'];
	            }
		        $logoArr = array('logo' => $mypic ); 
	            $this->admin_model->update_data('sub_admin', $logoArr, array('id' =>$id));
            }
    
     		$package_info = array(
     			'name'=>$name,
     			'address'=>$address,
     			'state'=>$state,
     			'city'=>$city,
     			'zip_code'=>$zip_code,
     			'password'=>$psw1,
     			'mob_no'=>$mob_no,
     			'last_name' => $last_name,
     			'ssn' => $ssn,
     			'ein_no' => $ein_no
     		);
     		// echo '<pre>';print_r($package_info);die;  
     		$this->admin_model->update_data('sub_admin',$package_info,array('id'=>$id));
     		$this->session->set_flashdata("success","Profile Updated Successfully");
     		redirect(base_url().'agent/edit_profile');
		} else {
			// print_r($package); die; 
     		foreach($package as $pak) {
          		$data['pak_id'] = $pak->id;
          		$data['email'] = $pak->email;
          		$data['name'] = $pak->name;
          		$data['last_name'] = $pak->last_name;
          		$data['psw'] = $pak->password;
          		$data['mypic'] = $pak->logo;
          		$data['mob_no'] = $pak->mob_no;
          		$data['status'] = $pak->status;
          		$data['address'] = $pak->address;
          		$data['city'] = $pak->city;
          		$data['state'] = $pak->state;
          		$data['zip_code'] = $pak->zip_code;
           		$data['total_commission'] = $pak->total_commission;
          		$data['ssn'] = $pak->ssn;
          		$data['ein_no'] = $pak->ein_no;
          		$data['commission_p_merchant'] = $pak->commission_p_merchant;
           		$data['commission_p_transaction'] = $pak->commission_p_transaction;
          		$data['buy_rent'] = $pak->buy_rent;
          		break;
     		}
		}
 		$data['loc'] = "edit_profile";
 		$data['meta'] = 'Reseller Profile';
 		$data['action'] = 'Update';
		//  print_r($data);  die();  
		$this->load->view('subadmin/edit_profile', $data);
	}


	public function all_customer_request_recurring() {

		$data = array();
	    $merchant_id = $this->session->userdata('subadmin_assign_merchant'); 
		
		if (isset($_POST['mysubmit'])) {
		
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data = $this->subadmin_model->get_full_details_admin_report_search1('customer_payment_request', $date1, $date2, $status);
			// $package_data = $this->admin_model->get_package_details_customer_admin($date1,$date2,$status);
            $data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];

		} else {

			$package_data = $this->subadmin_model->get_full_details_payment_admin_co('customer_payment_request');

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
			$package['title'] = $each->title;
			$package['date'] = $each->add_date;
			$package['due_date'] = $each->due_date;
			$package['status'] = $each->status;
			$package['payment_type'] = $each->payment_type;
			$package['recurring_payment'] = $each->recurring_payment;
			$package['date_c'] = $each->date_c;
			$package['card_type'] = $each->card_type;
			$package['transaction_id'] = $each->transaction_id;
			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');
        $data['meta'] = 'Recurring Invoice';
		$this->load->view('subadmin/all_customer_request_recurring', $data);
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
		$assign_merchant = $this->session->userdata('subadmin_assign_merchant');
		if (isset($_POST['mysubmit'])) {

			
			
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];

			$curr_payment_date = $date2;
			$status = $_POST['status'];
			$package_data = $this->subadmin_model->get_recurring_details_payment_admin($curr_payment_date, $status);
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
			//echo $this->db->last_query();  die();  
			 
		} else {

			$package_data = $this->subadmin_model->get_recurring_details_payment_admin1();
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

		$this->load->view('subadmin/all_recurrig_request', $data);
	}
	public function delete_package() {
		$pak_id = $this->uri->segment(3);

		if ($this->admin_model->delete_package($pak_id)) {
			$this->session->set_userdata("mymsg", "Data has been deleted.");
		}

	}
	public function getmerchantDetails()
	{
		$merchant_id=$this->input->post('merchant_id')?$this->input->post('merchant_id'):'288'; 
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
		//echo json_encode($_POST); die();  
        
		if(isset($_POST))
		{
			//echo $this->input->post('checkbox')? $this->input->post('checkbox'):''; die(); 
			$activation_id =$this->input->post('activation_id')? $this->input->post('activation_id'):'';
			$address1 =$this->input->post('address1')? $this->input->post('address1'):'';
			$amexrate =$this->input->post('amexrate')? $this->input->post('amexrate'):'';
			$annual_cc_sales_vol =$this->input->post('annual_cc_sales_vol')? $this->input->post('annual_cc_sales_vol'):'';
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
			$chargeback =$this->input->post('chargeback')? $this->input->post('chargeback'):'';
			$city =$this->input->post('city')? $this->input->post('city'):'';
			$country =$this->input->post('country')? $this->input->post('country'):'';
			$customer_service_email =$this->input->post('customer_service_email')? $this->input->post('customer_service_email'):'';
			$customer_service_phone =$this->input->post('customer_service_phone')? $this->input->post('customer_service_phone'):'';
			$dis_trans_fee =$this->input->post('dis_trans_fee')? $this->input->post('dis_trans_fee'):'';
			$establishmentdate =$this->input->post('establishmentdate')? $this->input->post('establishmentdate'):'';
			$key =$this->input->post('key')? $this->input->post('key'):'';
			$monthly_fee =$this->input->post('monthly_fee')? $this->input->post('monthly_fee'):'';
			$monthly_gateway_fee =$this->input->post('monthly_gateway_fee')? $this->input->post('monthly_gateway_fee'):'';
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
			$vm_cardrate =$this->input->post('vm_cardrate')? $this->input->post('vm_cardrate'):'';
			$website =$this->input->post('website')? $this->input->post('website'):'';

            // echo json_encode($checkbox);
			// die(); 
			
			// if($pc_name && $pc_title && $pc_address && $pc_email && $pc_phone && $monthly_fee && $vm_cardrate && $dis_trans_fee && $amexrate
			//  && $chargeback && $monthly_gateway_fee && $annual_cc_sales_vol && $checkbox && $question && $billing_descriptor ) {

		if($address1  && $amexrate &&  $annual_cc_sales_vol && $annual_processing_volume && $bank_account && 
		  $bank_ach && $bank_dda  && $bank_routing && $billing_descriptor &&  $business_dba_name &&  $business_email && $business_name 
		  && $business_number && $business_type && $chargeback && $city && $country && $customer_service_email
		   && $customer_service_phone &&  $dis_trans_fee && $establishmentdate && $key && $monthly_fee && $monthly_gateway_fee &&
			$checkbox  && $name && $o_address && $o_dob && $o_email && $o_phone  && $o_ss_number && $ownershiptype && $pc_address 
			&& $pc_email && $pc_name && $pc_phone  &&  $pc_title && $question && $taxid && $vm_cardrate &&  $website 
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
				echo json_encode(array('Status'=>400)); 
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
		echo $this->load->view('subadmin/show_result', $data, true);

	}
	public function search_record_column1() {
		$searchby = $this->input->post('id');

		$data['item'] = $this->admin_model->data_get_where_1("order_item", array(
			"p_id" => $searchby,
		));
		// $data['item'] = $this->admin_model->search_item($searchby);
		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('subadmin/show_result_admin', $data, true);

	}
	public function search_record_payment() {
		$searchby = $this->input->post('id');

		$data['pay_report'] = $this->admin_model->search_record($searchby);
		echo $this->load->view('subadmin/show_result_payment', $data, true);

	}

	public function tokenSystemPermission() {
		if(isset($_POST)) {
            $permission=$_POST['permission']; 
			$id=$_POST['id']; 
			if($permission=='true') {
				$data = array(
					'is_token_system_permission' => 1,
					'is_tokenized'=>1
				);
				 
				$up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
				echo '200';
			} else if($permission=='false') { 
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
		$subadmin_id=$this->input->post('subadmin_id');
		
	   if($pass && $merchant_id && $subadmin_id)
	   {
		
		   //$getdetails=$this->admin_model->get_user_by_id($admin_id); 
		   $getdetails=$this->subadmin_model->select_request_id('sub_admin',$subadmin_id);
		   //echo json_encode(array("status" => FALSE,'message'=>$getdetails['password'])); die; 
		   if($getdetails!="")
			{
				if($getdetails->password==$password){ 
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
			   echo json_encode(array("status" => FALSE,'message'=>'Please re-try','message'=>$getdetails));
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

	public function logout() {
		if($this->session->userdata())
		{
			$this->session->unset_userdata('subadmin_id');
			$this->session->unset_userdata('subadmin_user_type');
			$this->session->unset_userdata('subadmin_name');
			$this->session->unset_userdata('subadmin_assign_merchant');
			$this->session->unset_userdata('subadmin_view_menu_permissions');
			$this->session->unset_userdata('subadmin_view_permissions');
			$this->session->unset_userdata('subadmin_edit_permissions');
			$this->session->unset_userdata('subadmin_delete_permissions');
			$this->session->unset_userdata('subadmin_loginuser');
			
			//header('Location:  '.  base_url().'admin'  );
		}
		else
		{
			$this->session->unset_userdata();
		}

		// redirect(base_url('admin')); 
		header('Location:'.base_url(''));

	}

	// Add merchant process
	public function add_merchant() {
		$data['meta'] = 'Add Merchant';
		$this->load->view('subadmin/add_merchant', $data);
	}

public function stepone_signup() {
// echo 'stp1';die;
$email = $this->input->post('email') ? $this->input->post('email') : '';
$password_one = $this->input->post('password') ? $this->input->post('password') : '';
$cpassword = $this->input->post('mconfpass') ? $this->input->post('mconfpass') : '';

if ($password_one == $cpassword) {
$password1 = $this->input->post('password');
} else {
echo json_encode(600);
}

$today1 = date("Ymdhisu");
$unique = "SAL" . $today1;
$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
$password = $this->my_encrypt($password1, 'e');

$usr_result = $this->db->query("SELECT * FROM merchant WHERE email='$email'")->row_array();
if(count($usr_result) =='0') {
$data = array(
"email" => $this->input->post('email'),
"password" => $password,
"auth_key" => $unique,
"merchant_key" => $merchant_key,
'status' => 'pending_signup'
);

if ($email && $password_one && $cpassword) {
$inserted_merchant = $result = $this->Home_model->insert_data("merchant", $data);
// echo '<pre>';print_r($inserted_merchant);die;
$agent_id = $this->session->userdata('subadmin_id');
$getAgent = $this->db->select('assign_merchant')->where('id', $agent_id)->get('sub_admin')->row();
$assign_merchant = $getAgent->assign_merchant;

$upAssgnMerchant = $assign_merchant.','.$inserted_merchant;
$upData = array('assign_merchant' => $upAssgnMerchant);

$this->db->where('id', $agent_id);
$this->db->update('sub_admin', $upData);
// echo $upAssgnMerchant;die;

$this->session->set_userdata('last_merchantId', $result);
$this->session->set_userdata('merchant_key', $merchant_key);
$this->session->set_userdata('step', 'one');
echo json_encode(200);die;
} else {
echo json_encode(400);die;
}

} else {
echo json_encode(700);die;
}
}

	public function steptwo_signup() {
		$data = array(
			'business_dba_name' => $this->input->post('bsns_dbaname') ? $this->input->post('bsns_dbaname') : "",
			"business_email" => $this->input->post('bsns_email') ? $this->input->post('bsns_email') : "",
			'business_name' => $this->input->post('bsns_name') ? $this->input->post('bsns_name') : "",
			'ownershiptype' => $this->input->post('bsns_ownrtyp') ? $this->input->post('bsns_ownrtyp') : "",
			'business_number' => $this->input->post('bsns_phone') ? $this->input->post('bsns_phone') : "",
			'day_business' => $this->input->post('bsns_strtdate_d') ? $this->input->post('bsns_strtdate_d') : "",
			'month_business' => $this->input->post('bsns_strtdate_m') ? $this->input->post('bsns_strtdate_m') : "",
			'year_business' => $this->input->post('bsns_strtdate_y') ? $this->input->post('bsns_strtdate_y') : "",
			'taxid' => $this->input->post('bsns_tin') ? $this->input->post('bsns_tin') : "",
			'business_type' => $this->input->post('bsns_type') ? $this->input->post('bsns_type') : "",
			'website' => $this->input->post('bsns_website') ? $this->input->post('bsns_website') : "",
			'address1' => $this->input->post('bsnspadd_1') ? $this->input->post('bsnspadd_1') : "",
			'address2' => $this->input->post('bsnspadd_2') ? $this->input->post('bsnspadd_2') : "",
			'city' => $this->input->post('bsnspadd_city') ? $this->input->post('bsnspadd_city') : "",
			'country' => $this->input->post('bsnspadd_cnttry') ? $this->input->post('bsnspadd_cnttry') : "",
			'state' => $this->input->post('bsnspadd_state') ? $this->input->post('bsnspadd_state') : "",
			'zip' => $this->input->post('bsnspadd_zip') ? $this->input->post('bsnspadd_zip') : "",
			'customer_service_email' => $this->input->post('custServ_email') ? $this->input->post('custServ_email') : "",
			'customer_service_phone' => $this->input->post('custServ_phone') ? $this->input->post('custServ_phone') : "",
			'annual_processing_volume' => $this->input->post('mepvolume') ? $this->input->post('mepvolume') : "",

		);

		//echo json_encode($data);  die();
		$last_merchantId = $this->session->userdata('last_merchantId');
		if (isset($_POST['bsns_dbaname']) && isset($_POST['bsns_email']) && isset($_POST['bsns_name']) && isset($_POST['bsns_ownrtyp']) && isset($_POST['bsns_phone']) &&
			isset($_POST['bsns_strtdate_d']) && isset($_POST['bsns_strtdate_m']) && isset($_POST['bsns_strtdate_y']) && isset($_POST['bsns_tin']) &&
			isset($_POST['bsns_type']) && isset($_POST['bsns_website']) && isset($_POST['bsnspadd_1']) && isset($_POST['bsnspadd_2']) && isset($_POST['bsnspadd_city']) &&
			isset($_POST['bsnspadd_cnttry']) && isset($_POST['bsnspadd_state']) && isset($_POST['bsnspadd_zip']) && isset($_POST['custServ_email']) && isset($_POST['custServ_phone']) &&
			isset($_POST['mepvolume'])
		) {
			//$result=$this->Home_model->insert_data("merchant", $data);
			$this->db->where('id', $last_merchantId);
			$this->db->update('merchant', $data);
			$this->session->set_userdata('last_merchantId', $last_merchantId);
			$this->session->set_userdata('step', 'two');
			echo json_encode($data);
		}
	}

	public function stepthree_signup_new() {
		$dobYear = $this->input->post('fodoby') ? $this->input->post('fodoby') : "";
		$dobMonth = $this->input->post('fodobm') ? $this->input->post('fodobm') : "";
		$dobDate = $this->input->post('fodobd') ? $this->input->post('fodobd') : "";
		$ownerArr = $_POST['ownerArr'] ? $_POST['ownerArr'] : [];
		$DOB = $dobYear . '-' . $dobMonth . '-' . $dobDate;

		$data = array(
			'o_email' => $this->input->post('fo_email') ? $this->input->post('fo_email') : "",
			"o_phone" => $this->input->post('fo_phone') ? $this->input->post('fo_phone') : "",
			'o_dob_d' => $dobDate,
			'o_dob_m' => $dobMonth,
			'o_dob_y' => $dobYear,
			'dob' => $DOB,
			'o_address1' => htmlspecialchars($this->input->post('fohadd_1') ? $this->input->post('fohadd_1') : ""),
			'o_address2' => htmlspecialchars($this->input->post('fohadd_2') ? $this->input->post('fohadd_2') : ""),
			'o_city' => $this->input->post('fohadd_city') ? $this->input->post('fohadd_city') : "",
			'o_country' => $this->input->post('fohadd_cntry') ? $this->input->post('fohadd_cntry') : "",
			'o_state' => $this->input->post('fohadd_state') ? $this->input->post('fohadd_state') : "",
			'o_zip' => $this->input->post('fohadd_zip') ? $this->input->post('fohadd_zip') : "",
			'o_ss_number' => $this->input->post('fossn') ? $this->input->post('fossn') : "",
			'o_name' => $this->input->post('foname1') ? $this->input->post('foname1') : "",
			'name' => htmlspecialchars($this->input->post('foname1') ? $this->input->post('foname1') : ""),
			'm_name' => htmlspecialchars($this->input->post('foname2') ? $this->input->post('foname2') : ""),
			'l_name' => htmlspecialchars($this->input->post('foname3') ? $this->input->post('foname3') : "")
		);
		// echo json_encode($data);  die();
		$last_merchantId = $this->session->userdata('last_merchantId');

		if ( isset($_POST['fo_email']) && isset($_POST['fo_phone']) && isset($_POST['fodobd']) && isset($_POST['fodobm']) &&
		isset($_POST['fodoby']) && isset($_POST['fohadd_1']) && isset($_POST['fohadd_2']) && isset($_POST['fohadd_city']) &&
		isset($_POST['fohadd_cntry']) &&
		isset($_POST['fohadd_state']) && isset($_POST['fohadd_zip']) && isset($_POST['foname1']) && isset($_POST['foname2']) && isset($_POST['foname3']) &&
		isset($_POST['fossn']) ) {
			//$result=$this->Home_model->insert_data("merchant", $data);
			$this->db->where('id', $last_merchantId);
			$this->db->update('merchant', $data);

			$ownerInsertedIds = array();
			$allOwnerInsertedIds = [$last_merchantId];
			if(!empty($ownerArr)) {
				foreach ($ownerArr as $owner) {
					$dobYear_arr = $owner['fodoby_arr'] ? $owner['fodoby_arr'] : "";
					$dobMonth_arr = $owner['fodobm_arr'] ? $owner['fodobm_arr'] : "";
					$dobDate_arr = $owner['fodobd_arr'] ? $owner['fodobd_arr'] : "";
					$DOB_arr = $dobYear_arr . '-' . $dobMonth_arr . '-' . $dobDate_arr;

					if( !empty($owner['saved_id']) ) {
						//update
						$update_data_owner = array(
							'o_email_arr'		=> $owner['fo_email_arr'] ? $owner['fo_email_arr'] : "",
							"o_phone_arr"		=> $owner['fo_phone_arr'] ? $owner['fo_phone_arr'] : "",
							'o_dob_d_arr'		=> $dobDate_arr,
							'o_dob_m_arr'		=> $dobMonth_arr,
							'o_dob_y_arr'		=> $dobYear_arr,
							'dob_arr'			=> $DOB_arr,
							'o_address1_arr' 	=> htmlspecialchars($owner['fohadd_1_arr'] ? $owner['fohadd_1_arr'] : ""),
							'o_address2_arr' 	=> htmlspecialchars($owner['fohadd_2_arr'] ? $owner['fohadd_2_arr'] : ""),
							'o_city_arr'		=> $owner['fohadd_city_arr'] ? $owner['fohadd_city_arr'] : "",
							'o_country_arr'		=> $owner['fohadd_cntry_arr'] ? $owner['fohadd_cntry_arr'] : "",
							'o_state_arr'		=> $owner['fohadd_state_arr'] ? $owner['fohadd_state_arr'] : "",
							'o_zip_arr'			=> $owner['fohadd_zip_arr'] ? $owner['fohadd_zip_arr'] : "",
							'o_ss_number_arr'	=> $owner['fossn_arr'] ? $owner['fossn_arr'] : "",
							'o_name_arr'		=> $owner['foname1_arr'] ? $owner['foname1_arr'] : "",
							'name_arr'			=> htmlspecialchars($owner['foname1_arr'] ? $owner['foname1_arr'] : ""),
							'm_name_arr'		=> htmlspecialchars($owner['foname2_arr'] ? $owner['foname2_arr'] : ""),
							'l_name_arr'		=> htmlspecialchars($owner['foname3_arr'] ? $owner['foname3_arr'] : "")
						);
						$this->db->where('id', $owner['saved_id']);
						$this->db->update('business_owner', $update_data_owner);

						$insertedId = $owner['saved_id'];
				        array_push($ownerInsertedIds, $insertedId);
				        array_push($allOwnerInsertedIds, $insertedId);

					} else {
						//insert
						$insert_data_owner = array(
							'merchant_id_arr'	=> $last_merchantId,
							'o_email_arr'		=> $owner['fo_email_arr'] ? $owner['fo_email_arr'] : "",
							"o_phone_arr"		=> $owner['fo_phone_arr'] ? $owner['fo_phone_arr'] : "",
							'o_dob_d_arr'		=> $dobDate_arr,
							'o_dob_m_arr'		=> $dobMonth_arr,
							'o_dob_y_arr'		=> $dobYear_arr,
							'dob_arr'			=> $DOB_arr,
							'o_address1_arr' 	=> htmlspecialchars($owner['fohadd_1_arr'] ? $owner['fohadd_1_arr'] : ""),
							'o_address2_arr' 	=> htmlspecialchars($owner['fohadd_2_arr'] ? $owner['fohadd_2_arr'] : ""),
							'o_city_arr'		=> $owner['fohadd_city_arr'] ? $owner['fohadd_city_arr'] : "",
							'o_country_arr'		=> $owner['fohadd_cntry_arr'] ? $owner['fohadd_cntry_arr'] : "",
							'o_state_arr'		=> $owner['fohadd_state_arr'] ? $owner['fohadd_state_arr'] : "",
							'o_zip_arr'			=> $owner['fohadd_zip_arr'] ? $owner['fohadd_zip_arr'] : "",
							'o_ss_number_arr'	=> $owner['fossn_arr'] ? $owner['fossn_arr'] : "",
							'o_name_arr'		=> $owner['foname1_arr'] ? $owner['foname1_arr'] : "",
							'name_arr'			=> htmlspecialchars($owner['foname1_arr'] ? $owner['foname1_arr'] : ""),
							'm_name_arr'		=> htmlspecialchars($owner['foname2_arr'] ? $owner['foname2_arr'] : ""),
							'l_name_arr'		=> htmlspecialchars($owner['foname3_arr'] ? $owner['foname3_arr'] : "")
						);
				        $this->db->insert('business_owner', $insert_data_owner);
				        $insertedId = $this->db->insert_id();
				        array_push($ownerInsertedIds, $insertedId);
				        array_push($allOwnerInsertedIds, $insertedId);
					}
				}
			}
			$data['ownerInsertedIds'] = $ownerInsertedIds;
			$data['allOwnerInsertedIds'] = $allOwnerInsertedIds;

			// echo $this->db->last_query();  die();
			$this->session->set_userdata('last_merchantId', $last_merchantId);
			$this->session->set_userdata('step', 'three');
			echo json_encode($data);
		}
	}

	public function stepfour_signup_new() {
		$last_merchantId = $this->session->userdata('last_merchantId');
		$getdauth_key=$this->db->query("SELECT auth_key FROM  merchant WHERE id='$last_merchantId' ")->row_array();
		$today1 = date("Ymdhisu");
		$unique = $getdauth_key['auth_key'];
		
		$this->db->where('id', $last_merchantId);
		$getresult = $this->db->get('merchant')->row_array();
		// print_r($getresult['mob_no']); die();
		$name = $getresult['name'];
		$mobile = $getresult['mob_no'] ? $getresult['mob_no'] : $getresult['business_number'];
		$email = $getresult['email'];

		$routeNo = htmlspecialchars($this->input->post('routeNo') ? $this->input->post('routeNo') : '');
		$confrouteNo = htmlspecialchars($this->input->post('confrouteNo') ? $this->input->post('confrouteNo') : "");
		if ($routeNo == $confrouteNo) {
			$routingno = $this->input->post('routeNo');
		} else {
			echo '400';
		}

		$accountnumber_one = htmlspecialchars($this->input->post('accno') ? $this->input->post('accno') : '');
		$caccountnumber = htmlspecialchars($this->input->post('confaccno') ? $this->input->post('confaccno') : "");
		if ($accountnumber_one == $caccountnumber) {
			$accountnumber = $this->input->post('accno');
		} else {
			echo '400';
		}
		$bank_dda = $this->input->post('bank_dda_type') ? $this->input->post('bank_dda_type') : '';
		$bank_ach = $this->input->post('baccachtype') ? $this->input->post('baccachtype') : '';

		// start infinicept api
      	// $activation_id =$this->input->post('activation_id')? $this->input->post('activation_id'):'';
		$address1 = $getresult['address1'] ? $getresult['address1']:'';
		$amexrate ='2.70';
		$annual_cc_sales_vol = $getresult['annual_processing_volume'] ? $getresult['annual_processing_volume']:'0';
		$annual_processing_volume = $getresult['annual_processing_volume'] ? $getresult['annual_processing_volume']:'';
		$bank_account = $accountnumber ? $accountnumber :'';
		$bank_ach = $bank_ach ? $bank_ach:'';
		$bank_dda = $bank_dda ? $bank_dda:'';
		$bank_routing = $routingno ? $routingno :'';
		$billing_descriptor = $getresult['billing_descriptor'] ? $getresult['billing_descriptor']:'dvs';
		$business_dba_name = $getresult['business_dba_name'] ? $getresult['business_dba_name']:'';
		$business_email = $getresult['business_email'] ? $getresult['business_email']:'';
		$business_name = $getresult['business_name'] ? $getresult['business_name']:'';
		$business_number = $getresult['business_number'] ? $getresult['business_number']:'';
		$business_type = $getresult['business_type'] ? $getresult['business_type']:'';
		$chargeback ='25';
		$city = $getresult['city'] ? $getresult['city']:'';
		$country = $getresult['country'] ? $getresult['country']:'';
		$customer_service_email = $getresult['customer_service_email'] ? $getresult['customer_service_email']:'';
		$customer_service_phone = $getresult['customer_service_phone'] ? $getresult['customer_service_phone']:'';
		$dis_trans_fee = '0.15';
        $establishmentdate = $getresult['year_business'].'-'.$getresult['month_business'] .'-'.$getresult['day_business'];
		$key = $last_merchantId;
		$monthly_fee ='5';
		$monthly_gateway_fee ='25';
		$checkbox ='1';
		$name = $name ? $name :'';
		$o_address = $getresult['o_address1'] ? $getresult['o_address1']:'';
		$o_dob = $getresult['dob'] ? $getresult['dob']:'';
		$o_email = $getresult['o_email'] ? $getresult['o_email']:'';
		$o_phone = $getresult['o_phone'] ? $getresult['o_phone']:'';
		$o_ss_number = $getresult['o_ss_number'] ? $getresult['o_ss_number']:'';
		$ownershiptype = $getresult['ownershiptype'] ? $getresult['ownershiptype']:'';
		$pc_address = $getresult['o_address1'] ? $getresult['o_address1']:'';
		$pc_email = $getresult['o_email'] ? $getresult['o_email']:'';
		$pc_name = $getresult['o_name'] ? $getresult['o_name']:'';
		$pc_phone = $getresult['o_phone'] ? $getresult['o_phone']:'';
		$pc_title = $getresult['business_dba_name'] ? $getresult['business_dba_name']:'';
		$question = $getresult['question'] ? $getresult['question']:'Question';
		$taxid = $getresult['taxid'] ? $getresult['taxid']:'';
		$vm_cardrate ='2.70';
		$website = $getresult['website'] ? $getresult['website']:'';

       	if($address1  && $amexrate >=0 &&  $annual_cc_sales_vol >=0 && $annual_processing_volume && $bank_account && $bank_ach && $bank_dda  && $bank_routing && $billing_descriptor &&  $business_dba_name &&  $business_email && $business_name && $business_number && $business_type && $chargeback >=0 && $city && $country && $customer_service_email && $customer_service_phone &&  $dis_trans_fee >=0  && $establishmentdate && $key && $monthly_fee >=0  && $monthly_gateway_fee >=0 && $checkbox  && $name && $o_address && $o_dob && $o_email && $o_phone  && $o_ss_number && $ownershiptype && $pc_address && $pc_email && $pc_name && $pc_phone  &&  $pc_title && $question && $taxid && $vm_cardrate >=0 &&  $website) {
	  		//echo json_encode(array('Status'=>4000));

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
				'o_dob_y' =>substr($o_dob,0,4),
				'o_dob_m' =>substr($o_dob,5,2),
				'o_dob_d' =>substr($o_dob,8,2),
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
			$id= $last_merchantId;
			$this->db->where('id', $id);
			$up=$this->db->update('merchant', $data);
			//echo json_encode($up);  die(); 
			//echo json_encode($id);  die(); 
			if($up) {
				//echo 'shuaeb'; die();
				$this->db->where('id', $id);
				$getdata=$this->db->get('merchant')->row();
				// echo json_encode($getdata); die(); 
                $inputRawData = array (
					'AuthenticationKeyId' => 'a626be59-d58b-4f33-8050-104107dfb68f',
					'AuthenticationKeyValue' => 'Q8n1!RGbn-5YAEA^s0s6AMrKZoPRuqLoBx2GKW15huKXOvwLq~*vJQqC7REdXviE',
					"Merchant_IPAddress"=> $_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR'] :'',
					"Merchant_IPDateTime"=> date("l j F Y  g:ia", time() - date("Z")) ? date("l j F Y  g:ia", time() - date("Z")) :'',
					"Merchant_BrowserUserAgentString"=> $_SERVER['HTTP_USER_AGENT']?$_SERVER['HTTP_USER_AGENT']:'',
					"ExternalApplicationId"=> $getdata->business_name ? $getdata->business_name :'',
					'CustomFieldAnswers' => 
					array (
					  	0 => array (
							'Id' => 6161,
							'UserDefinedId' => 'legal.name',
							'Value' => array (
				  				'#' => $getdata->business_name,
							),
			  			),
					  	1 => array (
							'Id' => 6162,
							'UserDefinedId' => 'legal.dba',
							'Value' => array (
						  		'#' => $getdata->business_dba_name,
							),
					  	),
					  	2 => array (
							'Id' => 6163,
							'UserDefinedId' => 'legal.address',
							'Value' => array (
						  		'Country' => $getdata->country,
						  		'Street1' => $getdata->address1,
						  		'Street2' => $getdata->address2,
						  		'City' => $getdata->city,
						  		'State' => $getdata->state,
						  		'Zip' => $getdata->zip,
							),
					  	),
					  	3 => array (
							'Id' => 6164,
							'UserDefinedId' => 'legal.ownershiptype',
							'Value' => array (
						  		'#' => $getdata->ownershiptype,
							),
					  	),
					  	4 => array (
							'Id' => 6165,
							'UserDefinedId' => 'legal.taxid',
							'Value' => array (
						  		'#' => str_replace("-","",$getdata->taxid),
							),
					  	),
					  	5 => array (
							'Id' => 6166,
							'UserDefinedId' => 'Legal.DateofIncorporation',
							'Value' => array (
						  		'Month' => $getdata->month_business,
						  		'Day' =>   $getdata->day_business,
						  		'Year' =>  $getdata->year_business,
							),
					  	),
					  	6 => array (
							'Id' => 6167,
							'UserDefinedId' => 'legal.phone',
							'Value' => array (
						  		'#' => $getdata->business_number,
							),
					  	),
					  	7 => array (
							'Id' => 6168,
							'UserDefinedId' => 'legal.email',
							'Value' => array (
						  		'#' => $getdata->business_email,
							),
					  	),
					  	8 => array (
							'Id' => 6169,
							'UserDefinedId' => 'legal.website',
							'Value' => array (
						  		'#' => $getdata->website,
							),
					  	),
					  	9 => array (
							'Id' => 6170,
							'UserDefinedId' => 'bank.routingnumber',
							'Value' => array (
						  		'#' => $getdata->bank_routing,
							),
					  	),
					  	10 => array (
							'Id' => 6171,
							'UserDefinedId' => 'bank.routingnumber.confirm',
							'Value' => array (
						  		'#' => $getdata->bank_routing,
							),
					  	),
					  	11 => array (
							'Id' => 6172,
							'UserDefinedId' => 'bank.acctnumber',
							'Value' => array (
						  		'#' => $getdata->bank_account,
							),
					  	),
					  	12 => array (
							'Id' => 6173,
							'UserDefinedId' => 'bank.acctnumber.confirm',
							'Value' => array (
						  		'#' => $getdata->bank_account,
							),
					  	),
					  	13 => array (
							'Id' => 6174,
							'UserDefinedId' => 'owner1.name',
							'Value' => array (
						  		'FirstName' => $getdata->o_name,
						  		'MiddleName' => $getdata->m_name,
						  		'LastName' => $getdata->l_name,
							),
					  	),
					  	14 => array (
							'Id' => 6175,
							'UserDefinedId' => 'owner1.dob',
							'Value' => array (
						  		'Month' => $getdata->o_dob_m,
						  		'Day' => $getdata->o_dob_d,
						  		'Year' => $getdata->o_dob_y,
							),
					  	),
					  	15 => array (
							'Id' => 6176,
							'UserDefinedId' => 'owner1.address',
							'Value' => array (
						  		'Country' => $getdata->o_country,
						  		'Street1' => $getdata->o_address1,
						  		'Street2' => $getdata->o_address2,
						  		'City' => $getdata->o_city,
						  		'State' => $getdata->o_state,
						  		'Zip' => $getdata->o_zip,
							),
					  	),
					  	16 => array (
							'Id' => 6178,
							'UserDefinedId' => 'owner1.ssn',
							'Value' => array (
						  		'#' =>$getdata->o_ss_number,
							),
					  	),
					  	17 => array (
							'Id' => 6200,
							'UserDefinedId' => 'pc.name',
							'Value' => array (
						  		'FirstName' => $getdata->pc_name,
						  		'MiddleName' =>  $getdata->pc_name,
						  		'LastName' => $getdata->pc_name,
							),
					  	),
					  	18 => array (
							'Id' => 6201,
							'UserDefinedId' => 'pc.title',
							'Value' => array (
								//   '#' => 'true',
						  		'#' => $getdata->pc_title ? 'true' :'false',
							),
					  	),
					  	19 => array (
							'Id' => 6202,
							'UserDefinedId' => 'pc.address',
							'Value' => array (
						  		'Country' => $getdata->pc_address,
						  		'Street1' => '11',
						  		'Street2' => '12',
						  		'City' => 'HongCong',
						  		'State' =>'california',
						  		'Zip' => '23233',
							),
					  	),
					  	20 => array (
							'Id' => 6203,
							'UserDefinedId' => 'pc.email',
							'Value' => array (
						  		'#' => $getdata->pc_email,
							),
					  	),
					  	21 => array (
							'Id' => 6204,
							'UserDefinedId' => 'pc.phone',
							'Value' => array (
						  		'#' => $getdata->pc_phone,
							),
					  	),
					  	22 => array (
							'Id' => 6205,
							'UserDefinedId' => 'bank.ach',
							'Value' => array (
						  		'#' => $getdata->bank_ach,
							),
					  	),
					  	23 => array (
							'Id' => 6206,
							'UserDefinedId' => 'legal.annualprocessing',
							'Value' => array (
						  		'#' => $getdata->annual_cc_sales_vol,
							),
					  	),
					  	24 => array (
							'Id' => 6208,
							'UserDefinedId' => 'feeprofile.monthlyfee',
							'Value' => array (
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
					if($responceArrayData['Status']=='30') {
                       	$apidata = array(
							'merchant_id'=>$getdata->id,
							'merchant_application_id'=>$responceArrayData['MerchantApplicationId'],
							'external_merchant_application_id'=>$responceArrayData['ExternalMerchantApplicationId'],
							'infinicept_application_id'=>$responceArrayData['InfiniceptApplicationId'],
							'status'=>$responceArrayData['Status'],
							'status_message'=>$responceArrayData['StatusMessage']
					   	);
                       	$getdataOfApi=$this->db->query("SELECT * FROM  merchant_api WHERE merchant_id='$getdata->id'  ")->result_array(); 
					   	if(count($getdataOfApi) == '0') {
						    $this->db->insert('merchant_api',$apidata);
					   	}
      
						//$unique = "SAL" . $today1;
						$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
						$data = array(
							"bank_dda" => $bank_dda,
							"bank_ach" => $bank_ach,
							"bank_routing" => $routingno,
							"bank_account" => $accountnumber,
							//"auth_key" => $unique,
							//"merchant_key" => $merchant_key,
							"amexrate" =>$amexrate,
							'monthly_fee'=> $monthly_fee,
							'monthly_gateway_fee'=> $monthly_gateway_fee,
							'vm_cardrate'=> $vm_cardrate,
							'dis_trans_fee' =>$dis_trans_fee,
							//   'status' => 'block',
							// 'status' => 'Waiting_For_Approval',
							'status' => 'pending',
						);

						if ($routingno && $accountnumber) {
							//$result=$this->Home_model->insert_data("merchant", $data);
							$this->db->where('id', $last_merchantId);
							$this->db->update('merchant', $data);
							// $this->session->unset_userdata('last_merchantId');
							// $this->session->unset_userdata('step');
							$url = base_url() . "confirm/" . $unique;
							set_time_limit(3000);
							$MailTo = $email;

							$htmlContent = '<!DOCTYPE html>
							<html>
							<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
							<title></title>
							
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
							</head>
							<body style="padding: 0px;margin: 0;font-family:Open Sans, sans-serif;font-size: 14px !important;color: #333;">
							<div style="max-width: 751px;margin: 0 auto;background:#fafafa;">
							<div style="color:#fff;padding-top: 30px;padding-bottom: 5px;background-color: #2273dc;border-top-left-radius: 10px;border-top-right-radius: 10px;">
							<div style="width:80%;margin:0 auto;">
							<div style="width: 245px;text-align: center;height: 70px;border-radius: 50%;margin: 10px auto 20px;padding: 10px;box-shadow: 0px 0px 5px 10px #438cec8c;"><img src="https://salequick.com/front/images/logo-w.png" style="max-width: 90%;width: 100%;margin: 8px auto 0;display: block;"></div>
							</div>
							</div>
							<div style="max-width: 563px;text-align:right;margin: 0px auto 0;clear: both;width: 100%;display: table;">
							<p style="text-align: center !important;font-size: 20px !important;font-family: fantasy !important;letter-spacing: 3px;color: #3c763d;">Your registration is complete.</p>
							<p style="font-size: 16px !important;text-align: center !important;font-weight: 600;">Registration Details:</p>
							<table style="border-collapse: separate; border-spacing: 0;width: 100%; max-width: 100%;clear: both;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;font-size: 14px;"> 
								<tr >
									<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
										Name
									</th>
									<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'. $name . '</td>
								</tr>
								<tr >
									<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
										Email
									</th>
									<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'.$email.'</td>
								</tr>
								<tr >
									<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
										Phone
									</th>
									<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'.$mobile.'</td>
								</tr>
							</table>
							</div>
							<div style="padding: 25px 0;overflow:hidden;">
							<div style="width: 100%;margin:0 auto;overflow:hidden;max-width: 80%;">
							<div style="width: 100%;margin:10px auto 20px;text-align:center;">
							<p style="line-height: 1.432;">
							<span style="display: block;margin-bottom: 11px;font-weight: 600;color: #3c763d !important;">Verify Email</span>
							<a href="'.$url.'" style="max-height: 40px;padding: 10px 20px;display: inline-flex;justify-content: center;align-items: center;font-size: 0.875rem;font-weight: 600;letter-spacing: 0.03rem;color: #fff;background-color: #696ffb;text-decoration: none;border-radius: 20px;">Click Here</a>
							</p> 
							
							</div>
							</div>
							<footer style="width:100%;padding: 35px 0 21px;background: #414141;margin-top: 0px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
							<div style="text-align:center;width:80%;margin:0 auto;color: rgba(255, 255, 255, 0.75);">
							<h5 style="margin-top: 0;margin-bottom: 10px;font-size: 16px;font-weight:400;line-height: 1.432;">Feel free to contact us any time with question and concerns.</h5>
							<p style="color: rgba(255, 255, 255, 0.55);">You are receiving something because purchased something at Company name</p>
							<p style="text-align:center"><a href="https://salequick.com/" style="color: #6ea9ff;cursor:pointer;text-decoration:none !important;"><span style="color: rgba(255, 255, 255, 0.55);">Powered by:</span> SaleQuick.com</a></p>
							</div>
							</footer>
							</div>
							</body>
							</html>';
							//print_r($htmlContent); die();
							$config['mailtype'] = 'html';
							$this->email->initialize($config);
							$MailSubject = 'Salequick Registration Confirmation ';
							$this->email->from('info@salequick.com', 'Confirm Email');
							$this->email->to($email);
							$this->email->subject($MailSubject);
							$this->email->message($htmlContent);
							$this->email->send();

							$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Merchant Added Successfully.</div>');
							echo json_encode(array('Status'=>200));

						} else {
							$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Somthing Event Wrong!..</div>');
							//echo $this->session->flashdata('error'); die();
							//redirect(base_url("signup"));
							//echo '500';
							echo json_encode(array('Status'=>500)); 
						}
						// start infinicpt api

						//echo $response;
					} else {
						echo json_encode(array('Status'=>200));
						//echo $response;   
					}
					
				}
                //die("okay"); 
				//echo "update"; 
			} else {
                echo json_encode(array('Status'=>600));   
			}

		} else {
			echo json_encode(array('Status'=>40));
		} 
	}

	public function delete_business_owner() {
		$owner_id = $this->input->post('del_owner_id') ? $this->input->post('del_owner_id') : "";
		// echo $owner_id;die;

		$this->db->where('id', $owner_id);
		$this->db->delete('business_owner');
		echo $owner_id;
	}
}
?>
