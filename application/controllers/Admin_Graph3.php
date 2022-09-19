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
		 //ini_set('display_errors', 1);
	    //error_reporting(E_ALL);
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

		// $date_c = $this->input->post('start');
		// $date_cc = $this->input->post('end');
		// $date_c = date("Y-m-d", strtotime($date_c));
		// $date_cc = date("Y-m-d", strtotime($date_cc));

		$date_c = date("Y-m-d", strtotime($_POST['start']));
        $date_cc = date('Y-m-d', strtotime($this->input->post('end')));

		$employee = $this->input->post('employee');
		$merchnat = $this->input->post('employee');

		// Sales Summary Chart Data
		if ($employee == 'all') {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm'  union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' ) x group by date_c");
			// echo $this->db->last_query();die;
			// echo 'test<pre>';print_r($stmt->result_array());die;

		} elseif ($employee != 'all') {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee) union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN ($employee)  ) x group by date_c");
			// echo $this->db->last_query();die;

		} else {
			$stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(amount) as amount,sum(tax) as tax,sum(fee) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from customer_payment_request where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee) union all SELECT id,merchant_id,invoice_no,amount,tax,fee,name,date_c from pos where  date_c >= '".$date_c."' and date_c <= '".$date_cc."' and status='confirm' and merchant_id IN($employee)  ) x group by date_c");
		}
		// echo $this->db->last_query();die;
		// echo $stmt->num_rows();die;
		// echo '<pre>';print_r($stmt->result_array());die;
		if ($stmt->num_rows() > 0) {
			foreach ($stmt->result_array() as $result) {
				$temp = array(
					'date' 				=> $result['date_c'],
					'amount' 			=> $result['amount'],
					'clicks' 			=> !empty($result['tax']) ? $result['tax'] : '0.00',
					'cost' 				=> $result['fee'],
					'tax' 				=> !empty($result['tax']) ? $result['tax'] : '0.00',
					'converted_people'  => !empty($result['tax']) ? $result['tax'] : '0.00',
					'revenue' 			=> !empty($result['tax']) ? $result['tax'] : '0.00',
					'linkcost' 			=> !empty($result['tax']) ? $result['tax'] : '0.00'
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
			$stmt = $this->db->query("SELECT (SELECT SUM(amount) as Amount from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as Amount,
				(SELECT SUM(amount) as PAmount from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as PAmount,
				(SELECT SUM(tax) as Tax from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as Tax,
				(SELECT SUM(tax) as PTax from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as PTax,
				(SELECT SUM(other_charges) as c_other_charges from customer_payment_request where date_c >= '".$date_c."' and merchant_id!='413' and date_c <= '".$date_cc."' and (status='confirm' or status='Chargeback_Confirm')) as c_other_charges,
				(SELECT SUM(other_charges) as p_other_charges from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as p_other_charges,
				(SELECT SUM(tip_amount) as tip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as Tip,
				(SELECT SUM(tip_amount) as PTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as PTip,
				
				(SELECT SUM(fee) as Fee from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as Fee,
				(SELECT SUM(fee) as PFee from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and (status='confirm' or status='Chargeback_Confirm')) as PFee,

				(select sum(amount) as rAmu from refund  where date_c>='".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413' and  status='confirm') As RAmountPOS,
  				
  				
  				(select SUM(tip_amount) as RTip from customer_payment_request  where date_r>='".$date_c."' and date_r <= '".$date_cc."' and  status='Chargeback_Confirm' and partial_refund='0' and merchant_id!='413') As RTip,
  				(select SUM(tip_amount) as RPTip from pos  where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id!='413'  and status='Chargeback_Confirm' and partial_refund='0') As RPTip,
  				
  				(select SUM(tax) as RTax from customer_payment_request where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id!='413'  and  status='Chargeback_Confirm' and partial_refund='0') As RTax,
  				(select SUM(tax) as RPTax from pos  where date_r>='".$date_c."' and date_c <= '".$date_cc."' and merchant_id!='413'  and status='Chargeback_Confirm' and partial_refund='0') As RPTax,
  				
  				(select SUM(other_charges) as Rc_other_charges from customer_payment_request where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id!='413'  and  status='Chargeback_Confirm' and partial_refund='0') As Rc_other_charges,
  				(select SUM(other_charges) as Rp_other_charges from pos where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id!='413'  and status='Chargeback_Confirm' and partial_refund='0') As Rp_other_charges,

  				(select SUM(fee) as RFee from customer_payment_request where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id!='413'  and  status='Chargeback_Confirm' and partial_refund='0') As RFee,
  				(select SUM(fee) as RPFee from pos  where date_r>='".$date_c."' and date_r <= '".$date_cc."'  and status='Chargeback_Confirm' and partial_refund='0') As RPFee ");

		}  else {
			$stmt = $this->db->query("SELECT (SELECT SUM(amount) as Amount from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm') ) as Amount,
				(SELECT SUM(amount) as PAmount from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as PAmount,
				(SELECT SUM(tax) as Tax from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as Tax,
				(SELECT SUM(tax) as PTax from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as PTax,
				(SELECT SUM(other_charges) as c_other_charges from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as c_other_charges,
				(SELECT SUM(other_charges) as p_other_charges from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as p_other_charges,
				(SELECT SUM(tip_amount) as tip from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as Tip,
				(SELECT SUM(tip_amount) as PTip from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as PTip,
				(SELECT SUM(fee) as Fee from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm')) as Fee,
				(SELECT SUM(fee) as PFee from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and (status='confirm' or status='Chargeback_Confirm') ) as PFee,

				
				(select sum(amount) as RAmountPOS from refund  where date_c>='".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and   status='confirm') As RAmountPOS,
  				
  				
  				(select SUM(tip_amount) as RTip from customer_payment_request  where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id= $employee and  status='Chargeback_Confirm' and partial_refund='0') As RTip,
  				(select SUM(tip_amount) as RPTip from pos  where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id= $employee and status='Chargeback_Confirm' and partial_refund='0') As RPTip,
  				
  				(select SUM(tax) as RTax from customer_payment_request where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id= $employee  and  status='Chargeback_Confirm' and partial_refund='0') As RTax,
  				(select SUM(tax) as RPTax from pos  where date_r>='".$date_c."' and date_c <= '".$date_cc."' and merchant_id= $employee and status='Chargeback_Confirm' and partial_refund='0') As RPTax,
  				
  				(select SUM(other_charges) as Rc_other_charges from customer_payment_request where date_r>='".$date_c."' and merchant_id= $employee and date_r <= '".$date_cc."'  and  status='Chargeback_Confirm' and partial_refund='0') As Rc_other_charges,
  				(select SUM(other_charges) as Rp_other_charges from pos where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id= $employee  and status='Chargeback_Confirm' and partial_refund='0') As Rp_other_charges,

  				(select SUM(fee) as RFee from customer_payment_request where date_r>='".$date_c."' and date_r <= '".$date_cc."' and merchant_id= $employee  and  status='Chargeback_Confirm' and partial_refund='0') As RFee,
  				(select SUM(fee) as RPFee from pos  where date_r>='".$date_c."' and date_r <= '".$date_cc."'  and merchant_id= $employee and status='Chargeback_Confirm' and partial_refund='0') As RPFee


  				");

		}
		// echo $this->db->last_query();die;

		if ($stmt->num_rows() > 0) {
			// echo '<pre>';print_r($stmt->result_array());die;
			foreach ($stmt->result_array() as $result2) {
				$result2['RAmountCPR']=0;
		  		$temp1 = array(
					'label' => 'Amount',
					'people' => $result2['Amount'] + $result2['PAmount'],
					'clicks' => ($result2['RAmountPOS'] + $result2['RAmountCPR']),
					'converted_people' => ($result2['Amount'] + $result2['PAmount']) - ($result2['RAmountPOS'] + $result2['RAmountCPR']),
				);

				$temp2 = array(
					'label' => 'Tax',
					'people' => $result2['Tax'] + $result2['PTax'],
					'clicks' => $result2['RTax'] + $result2['RPTax'],
					'converted_people' => ($result2['Tax'] + $result2['PTax']) - ($result2['RTax'] + $result2['RPTax']),
				);

				$temp3 = array(
					'label' => 'Fee',
					'people' => $result2['Fee'] + $result2['PFee'],
					'clicks' => $result2['RFee'] + $result2['RPFee'],
					'converted_people' => ($result2['Fee'] + $result2['PFee']) - ($result2['RFee'] + $result2['RPFee']),
				);

				$temp4 = array(
					'label' => 'Tip',
					'people' => $result2['Tip'] + $result2['PTip'],
					'clicks' => $result2['RTip'] + $result2['RPTip'],
					'converted_people' => ($result2['Tip'] + $result2['PTip']) - ($result2['RTip'] + $result2['RPTip']),
				);

				$temp5 = array(
					'label' => 'OtherCharges',
					'people' => $result2['c_other_charges'] + $result2['p_other_charges'],
					'clicks' => $result2['Rc_other_charges'] + $result2['Rp_other_charges'],
					'converted_people' => ($result2['c_other_charges'] + $result2['p_other_charges']) - ($result2['Rc_other_charges'] + $result2['Rp_other_charges']),
				);
				array_push($tableData, $temp1, $temp2, $temp3, $temp4, $temp5);
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
		$date_c = date("Y-m-d", strtotime($date_c));
		$date_cc = date("Y-m-d", strtotime($date_cc));

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
		$date_c = date("Y-m-d", strtotime($date_c));
		$date_cc = date("Y-m-d", strtotime($date_cc));
		
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

	

	public function trends(){
		$data["title"] ="Admin Panel";
		$data["meta"] ="Sales Trends";

		$getDashboard = $this->db->order_by('id', 'desc')->limit(1)->get('sales_trend_admin');
		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;
		// echo '<pre>';print_r($getDashboardData[0]);die;
		
		// $package_data = $this->admin_model->data_get_where("customer_payment_request", array("status"=>'confirm' ));
		// $mem = array();
		// $member = array();
		// foreach($package_data as $each) {
		// 	$package['amount'] = $each->amount;
		// 	$package['tax'] = $each->tax; 
		// 	$package['type'] = $each->type; 
		// 	$package['date'] = $each->date_c; 
		// 	$mem[] = $package;
		// }
		// $data['item'] = $mem;
		// $data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("status"=>'confirm'));
		// $data['item2'] = $this->admin_model->data_get_where_g("pos", array("status"=>'confirm' ));
		
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
