<?php
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Test_report extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model("serverside_model");
		$this->load->model("invoice_model");
		$this->load->model("recurring_model");
		$this->load->model('session_checker_model');
		$this->load->library('email');
		$this->load->library('twilio');

		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}

		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}

	public function test_report() {
		$start = '2020-12-14';
    	$end = '2021-01-12';


		// $query = $this->db->query("SELECT m.id,m.business_dba_name,fs.amount,fs.hold_amount,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,fs.status,(IFNULL((select sum(fee) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "' ),0) + IFNULL((select sum(fee) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0)) as feesamoun, '" . $filters['date'] . "' as date_c, (IFNULL((select sum(amount) from  pos where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c <='" . $filters['date2'] . "'),0) + IFNULL((select sum(amount) from  customer_payment_request where merchant_id=m.id and date_c >='" . $filters['date'] . "' AND date_c  <='" . $filters['date2'] . "'),0)) as totalAmount from merchant m left join funding_status fs on (fs.merchant_id=m.id and fs.date >='" . $filters['date'] . "' AND fs.date  <='" . $filters['date2'] . "' )  where  m.user_type='merchant' and m.status='Active' $condtions");

		$whereMerchant = array('user_type'=>'merchant', 'status'=>'Active');
		// $merchantArr = $this->db->select('id,business_dba_name,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account')->where($whereMerchant)->get('merchant')->result_array();
		$merchantArr = $this->db->select('id,business_dba_name,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account')->get_where('merchant', $whereMerchant, 25, 0)->result_array();
		// get_where('merchant', $whereMerchant, 25, 0);
		// echo $this->db->last_query();die;
		// echo '<pre>';print_r($merchantArr);die;
		foreach ($merchantArr as $i => $merchant) {
			// echo '<pre>';print_r($merchant);
			$merchant_id = $merchant['id'];
			$posArr = $this->db->query("select fee,amount from pos where merchant_id=$merchant_id and date_c >='".$start."' AND date_c <='".$end."'")->result_array();
			// echo '<pre>';print_r($posArr);
			$totalPosFee = $totalPosAmt = 0;
			$totalInvFee = $totalInvAmt = 0;
			foreach ($posArr as $pos) {
				$posFee = !empty($pos['fee']) ? $pos['fee'] : 0;
				$posAmt = !empty($pos['amount']) ? $pos['amount'] : 0;

				$totalPosFee = $totalPosFee + $posFee;
				$totalPosAmt = $totalPosAmt + $posAmt;
			}
			// echo $totalPosFee.','.$totalPosAmt.'<br>';
			$invArr = $this->db->query("select fee,amount from customer_payment_request where merchant_id=$merchant_id and date_c >='".$start."' AND date_c <='".$end."'")->result_array();
			// echo '<pre>';print_r($posArr);
			
			foreach ($invArr as $inv) {
				$invFee = !empty($inv['fee']) ? $inv['fee'] : 0;
				$invAmt = !empty($inv['amount']) ? $inv['amount'] : 0;

				$totalInvFee = $totalInvFee + $invFee;
				$totalInvAmt = $totalInvAmt + $invAmt;
			}
			$merchantArr[$i]['totalFee'] = $totalPosFee + $totalInvFee;
			$merchantArr[$i]['totalAmt'] = $totalPosAmt + $totalInvAmt;

			$funding = $this->db->select('amount,hold_amount,status')->where('merchant_id', $merchant_id)->get('funding_status')->row();
			$merchantArr[$i]['funding_amount'] = $funding->amount;
			$merchantArr[$i]['funding_hold_amount'] = $funding->hold_amount;
			$merchantArr[$i]['funding_status'] = $funding->status;
			$merchantArr[$i]['date_c'] = $start;
		}
		echo '<pre>';print_r($merchantArr);die;
	}

	public function report_original($Requestdata = null) {
		$data["title"] = "Admin Panel";
		
		if (isset($_POST['mysubmit'])) {
			//echo '1';die();
			$employee = $_POST['employee'];
			$status = $_POST['status'];
			$date1 = $_POST['start_date'];
			$date2 = $_POST['end_date'];
			$package_data_full_reporst = $this->admin_model->get_full_reports(array(
				'date' => $date1,
				'date2' => $date2,
				'employee' => $employee,
				'status' => $status,
			));
			$data['reposrint_date'] = $date1;
			$data['full_reporst'] = $package_data_full_reporst;

			$data['employee'] = $employee;
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];

		} else { 
			//echo '2';die();    
			// $package_data = $this->admin_model->get_full_details_admin_report('customer_payment_request');
			//echo $this->db->last_query();die();
			// $package_data1 = $this->admin_model->get_full_details_admin_report('recurring_payment');
			// $package_data2 = $this->admin_model->get_full_details_admin_report('pos');

            //echo '<pre>';print_r($package_data); die();
			$reposrint_date = date("Y-m-d");
			$datetime = new DateTime($reposrint_date);
			$datetime->modify('-1 day');
			$reposrint_date2 = $datetime->format('Y-m-d'); 
			
			if ($Requestdata != null) {
				$reposrint_date = $Requestdata;
			}
			$package_data_full_reporst = $this->admin_model->get_full_reports(array(
				'date' => $reposrint_date2,
				'date2' => $reposrint_date
			));
			//print_r($package_data_full_reporst); die();
			$data['full_reporst'] = $package_data_full_reporst;
			$data['reposrint_date'] = $reposrint_date;

		}
		// print_r($data);die;
		
		if ($Requestdata != null) {
			$data['reposrint_date'] = $Requestdata;
		}
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$GrosspaymentValume = 0;
		$TotalFeeCaptured = 0;
		$TotalPayout = 0;
		$TotalTransactions = 0;
		if (!empty($data['full_reporst'])) {
			foreach ($data['full_reporst'] as $key => $full_reporst) {
				if ($full_reporst["totalAmount"] > 0) {
					$firsttimefees = $this->admin_model->getLastpayment(array(
						'date' => $reposrint_date,
						'merchant_id' => $full_reporst['id'],
					));
					$data['full_reporst'][$key]['monthly_fees'] = 0;
					if ($firsttimefees[0]["cnt"] == 0) {
						$data['full_reporst'][$key]['monthly_fees'] = $full_reporst['monthly_fee'];
					}
					$GrosspaymentValume = $GrosspaymentValume + $full_reporst['totalAmount'];
					$TotalFeeCaptured = $TotalFeeCaptured + $full_reporst['feesamoun'] + $data['full_reporst'][$key]['monthly_fees'];
					$TotalTransactions = $TotalTransactions + 1;
				} else {
					$data['full_reporst'][$key]['monthly_fees'] = 0;
				}
			}
		}
		// $this->session->unset_userdata('mymsg');
		
		$data['GrosspaymentValume'] = $GrosspaymentValume;
		$data['TotalFeeCaptured'] = $TotalFeeCaptured;
		$data['TotalTransactions'] = $TotalTransactions;
		print_r($data);die();
		$this->load->view('admin/report', $data);
	}

}