
<?php
    ini_set('MAX_EXECUTION_TIME', '-1');
    ini_set('memory_limit','2048M');
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Funding_cron extends CI_Controller {
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
			//ini_set('display_errors', 1);
		    //    error_reporting(E_ALL);
		}

public function index()
{

            $reposrint_date = date("Y-m-d");
			$datetime = new DateTime($reposrint_date);
			$datetime->modify('-30 day');
		    $reposrint_date2 = $datetime->format('Y-m-d');


			$this->db->query("CREATE OR REPLACE VIEW report_admin_view AS SELECT m.id,m.business_dba_name,fs.amount,fs.hold_amount,monthly_fee,text_email,f_swap_Invoice,f_swap_Recurring,f_swap_Text,name,invoice,recurring,point_sale,email,bank_account,fs.status,(IFNULL((select sum(fee) from pos where merchant_id=m.id and date_c >='".$reposrint_date2."' AND date_c <='".$reposrint_date."' ),0) + IFNULL((select sum(fee) from customer_payment_request where merchant_id=m.id and date_c >='".$reposrint_date2."' AND date_c <='".$reposrint_date."'),0)) as feesamoun, '".$reposrint_date2."' as date_c, (IFNULL((select sum(amount) from pos where merchant_id=m.id and date_c >='".$reposrint_date2."' AND date_c <='".$reposrint_date."'),0) + IFNULL((select sum(amount) from customer_payment_request where merchant_id=m.id and date_c >='".$reposrint_date2."' AND date_c <='".$reposrint_date."'),0)) as totalAmount from merchant m left join funding_status fs on (fs.merchant_id=m.id and fs.date >='".$reposrint_date2."' AND fs.date <='".$reposrint_date."' ) where m.user_type='merchant' and m.status='Active'");

		$this->db->query("DROP TABLE report_admin");

	$this->db->query("CREATE  TABLE report_admin AS SELECT * FROM report_admin_view");

		}





		}