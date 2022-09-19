<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class AgentRevenue extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('Revenue_model');
		$this->load->model('pos_model');
		$this->load->model('session_checker_model');
		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}
       
		date_default_timezone_set("America/Chicago");
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		
		ini_set('display_errors', 1);
	    error_reporting(E_ALL);
	}

	public function dateTimeConvertTimeZone($Adate) {
		date_default_timezone_set("UTC");
		$time_Zone='America/Chicago';
		//date_default_timezone_set('America/Chicago');
		//if($time_Zone!='America/Chicago'){
			$datetime = new DateTime($Adate);
			$la_time = new DateTimeZone($time_Zone);
			$datetime->setTimezone($la_time);
			$convertedDateTime=$datetime->format('Y-m-d H:i:s');
		// } else {
		// 	$convertedDateTime=$Adate;
		// }
		return $convertedDateTime; 
	}

	public function index() {
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
			$package_data = $this->Revenue_model->get_search_merchant_pos_new_admin($start_date, $end_date, $status, 'pos');

			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
			// echo '<pre>';print_r($data);die;
			
		} else {
			$start_date = date("Y-m-d", strtotime("-29 days"));
			$end_date = date("Y-m-d");

			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			$package_data = $this->Revenue_model->get_full_details_pos_new_admin('pos');
            //echo '<pre>';print_r($package_data);die;
		}

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if($each->transaction_type == "split") {
		 		$card_no = "";
				$card_type = "SPLIT";
		 	} else {
				$card_no = $each->card_no;
				$card_type = $each->card_type;
		 	}

		 	$typeOfCard = strtolower($card_type);
			switch($typeOfCard) {
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
				case 'american express':
                    $card_image = 'amx.png';
                    break;
			   	default :
				 	$card_image='other.png';
			}
			if ($card_image == 'other.png') {
				if ($typeOfCard == "check") {
					$card_image = '<img src="'.base_url().'new_assets/img/check.png" alt="'.$card_type.'" style="display: inline; max-width: 35px;" >';
					$card_image .= ' ('.$each->card_no.')';
				} else if($typeOfCard == "cash") {
					$card_image = '<img src="'.base_url().'new_assets/img/cash.png" alt="'.$card_type.'"  style="display: inline; max-width: 35px;">';
				} else {
					$card_image = $card_type;
				}
			} else {
				$card_image = '<img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'" style="display: inline; max-width: 35px;" > ';
				$card_image .= !empty($each->card_no) ? ('****' . substr($each->card_no, -4)) : '********';
			}

			$new_date=$this->dateTimeConvertTimeZone($each->add_date);
			$date = date("M d Y h:i A", strtotime($new_date));

			// $ch_card_no = !empty($each->card_no) ? ('****' . substr($each->card_no, -4)) : '********';
			// $card_no = '<img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'" style="display: inline; max-width: 35px;" >'.$ch_card_no;

			$package['id'] = $each->id;
			$package['payment_id'] = $each->invoice_no;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			// $package['card_no'] = $card_no;
			$package['date'] = $date;
			$package['status'] = $each->status;
			$package['transaction_id'] = $each->transaction_id;
			$package['card_type'] = $each->card_type;
			$package['card_no'] = $card_image;

			$mem[] = $package;
            // echo '<pre>';print_r($each);
		}

		$data['mem'] = $mem;
		$this->load->view('admin/all_pos_revenue_dash', $data);
	}

	public function transaction() {
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
			$package['buy_rate'] = '0.10';
     		$package['date'] = $date;
     		$package['settlement_date'] = $settlement_date;
			

			$mem[] = $package;
            // echo '<pre>';print_r($each);
		}

		$data['mem'] = $mem;
		$this->load->view('admin/all_pos_revenue_dash_transaction', $data);
	}

}