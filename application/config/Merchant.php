<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Merchant extends CI_Controller{
       	public function __construct(){
            parent::__construct();
            $this->load->helper('form'); 
            $this->load->helper('url'); 
            $this->load->helper('html');
            $this->load->model('profile_model');
            $this->load->model('admin_model');
            $this->load->model('home_model');
            $this->load->library('form_validation');
            $this->load->library('email');
            $this->load->library('twilio');
          	//$this->load->model('sendmail_model');
            $this->load->model('session_checker_model');
            if(!$this->session_checker_model->chk_session_merchant())
                redirect('login');
                date_default_timezone_set("America/Chicago");
        }
        public function index(){
            $data["title"] ="Merchant Panel";
            $merchant_id = $this->session->userdata('merchant_id');
            $today2 = date("Y");
            $last_year = date("Y",strtotime("-1 year"));
            $last_date = date("Y-m-d",strtotime("-29 days"));
            $date = date("Y-m-d");
            $start = $this->input->post('start');
            $end = $this->input->post('end');
            $employee = $this->input->post('employee');
            //  $last_date1 = date("Y-m-d",strtotime("-29 days"));
            //$date1 = date("Y-m-d");
            if($start=='undefined'){
                $last_date = date("Y-m-d",strtotime("-29 days"));
                $date = date("Y-m-d");
            }elseif($start!=''){
                $last_date = $start;
                $date = $end;
            }else{
                $last_date = date("Y-m-d",strtotime("-29 days"));
                $date = date("Y-m-d");
            }
            if($employee=='all'){
                $sub_merchant_id = 0;
            }elseif($employee=='merchant'){
                $sub_merchant_id = 0;
            }else{
                $sub_merchant_id = $employee;
            }
            $getDashboard = $this->db->query("SELECT ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = CURDATE() and merchant_id = '".$merchant_id."' ) as NewTotalOrders,  ( SELECT count(id) as NewTotalOrders_p from pos where date_c = CURDATE() and merchant_id = '".$merchant_id."' ) as NewTotalOrders_p,  ( SELECT count(id) as TotalOrders from customer_payment_request where status='confirm' and merchant_id = '".$merchant_id."' ) as TotalOrders, ( SELECT count(id) as TotalOrders_P from pos where status='confirm' and merchant_id = '".$merchant_id."' ) as TotalOrders_p, ( SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending'  and merchant_id = '".$merchant_id."') as TotalpendingOrders, 
                            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountPOS,
                             (SELECT sum(amount) as Totaljan from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljan   ,
                            (SELECT sum(amount) as Totalfeb from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm' )x group by month ) as Totalfeb   ,
                        (SELECT sum(amount) as Totalmarch from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmarch   ,
                         (SELECT sum(amount) as Totalaprl from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaprl   ,
                         (SELECT sum(amount) as Totalmay from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmay   ,
                          (SELECT sum(amount) as Totaljune from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljune   ,
                          (SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljuly   ,
                            (SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaugust   ,
                             (SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm' )x group by month ) as Totalsep   ,
                            (SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm' )x group by month ) as Totaloct   ,
                          (SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm' )x group by month ) as Totalnov   ,
                           (SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm' )x group by month ) as Totaldec   ,
                        (SELECT sum(fee) as Totaljanf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljanf   ,
                 (SELECT sum(fee) as Totalfebf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm' )x group by month ) as Totalfebf   ,
                   (SELECT sum(fee) as Totalmarchf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmarchf   ,
                     (SELECT sum(fee) as Totalaprlf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaprlf   ,
                      (SELECT sum(fee) as Totalmayf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmayf   ,
              
               (SELECT sum(fee) as Totaljunef from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljunef   ,
                           (SELECT sum(fee) as Totaljulyf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljulyf   ,
                           (SELECT sum(fee) as Totalaugustf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaugustf   ,
                          (SELECT sum(fee) as Totalsepf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm' )x group by month ) as Totalsepf   ,
                        (SELECT sum(fee) as Totaloctf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm' )x group by month ) as Totaloctf   ,
                       (SELECT sum(fee) as Totalnovf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm' )x group by month ) as Totalnovf   ,
                      (SELECT sum(fee) as Totaldecf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm' )x group by month ) as Totaldecf   ,
              (SELECT sum(tax) as Totaljantax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '01' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljantax   ,
               (SELECT sum(tax) as Totalfebtax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '02' and year = '".$today2."' and status='confirm' )x group by month ) as Totalfebtax   ,
               (SELECT sum(tax) as Totalmarchtax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '03' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmarchtax   ,
               (SELECT sum(tax) as Totalaprltax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '04' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaprltax   ,
              (SELECT sum(tax) as Totalmaytax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '05' and year = '".$today2."' and status='confirm' )x group by month ) as Totalmaytax   ,
               (SELECT sum(tax) as Totaljunetax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '06' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljunetax   ,
               (SELECT sum(tax) as Totaljulytax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '07' and year = '".$today2."' and status='confirm' )x group by month ) as Totaljulytax   ,
               (SELECT sum(tax) as Totalaugusttax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '08' and year = '".$today2."' and status='confirm' )x group by month ) as Totalaugusttax   ,
               (SELECT sum(tax) as Totalseptax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '09' and year = '".$today2."' and status='confirm' )x group by month ) as Totalseptax   ,
              (SELECT sum(tax) as Totalocttax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '10' and year = '".$today2."' and status='confirm' )x group by month ) as Totalocttax   ,
               (SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '11' and year = '".$today2."' and status='confirm' )x group by month ) as Totalnovtax   ,
               (SELECT sum(tax) as Totaldectax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '12' and year = '".$today2."' and status='confirm' )x group by month ) as Totaldectax   ,
                                (SELECT sum(amount) as Totalbjan from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbjan   ,
              (SELECT sum(amount) as Totalbfeb from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbfeb   ,
                 (SELECT sum(amount) as Totalbmarch from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbmarch   ,
                  (SELECT sum(amount) as Totalbaprl from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbaprl   ,
                     (SELECT sum(amount) as Totalbmay from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbmay   ,
                       (SELECT sum(amount) as Totalbjune from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbjune   ,
                        (SELECT sum(amount) as Totalbjuly from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbjuly   ,
                        (SELECT sum(amount) as Totalbaugust from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbaugust   ,
                         (SELECT sum(amount) as Totalbsep from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbsep   ,
                          (SELECT sum(amount) as Totalboct from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalboct   ,
                            (SELECT sum(amount) as Totalbnov from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbnov   ,
      (SELECT sum(amount) as Totalbdec from ( SELECT month,amount from customer_payment_request where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm'   union all SELECT month,amount from recurring_payment where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm' union all SELECT month,amount from pos where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm' ) x group by month ) as Totalbdec ,
               (SELECT sum(fee) as Totalbjanf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjanf   ,
                 (SELECT sum(fee) as Totalbfebf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbfebf   ,
                   (SELECT sum(fee) as Totalbmarchf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmarchf   ,
                     (SELECT sum(fee) as Totalbaprlf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaprlf   ,
                      (SELECT sum(fee) as Totalbmayf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmayf   ,
              
               (SELECT sum(fee) as Totalbjunef from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjunef   ,
                           (SELECT sum(fee) as Totalbjulyf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjulyf   ,
                           (SELECT sum(fee) as Totalbaugustf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaugustf   ,
                          (SELECT sum(fee) as Totalbsepf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbsepf   ,
                        (SELECT sum(fee) as Totalboctf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalboctf   ,
                       (SELECT sum(fee) as Totalbnovf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbnovf   ,
                      (SELECT sum(fee) as Totalbdecf from ( SELECT month,fee from customer_payment_request where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm'   union all SELECT month,fee from recurring_payment where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm' union all SELECT month,fee from pos where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbdecf   ,
              (SELECT sum(tax) as Totalbjantax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '01' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjantax   ,
               (SELECT sum(tax) as Totalbfebtax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '02' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbfebtax   ,
               (SELECT sum(tax) as Totalbmarchtax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '03' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmarchtax   ,
               (SELECT sum(tax) as Totalbaprltax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '04' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaprltax   ,
              (SELECT sum(tax) as Totalbmaytax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '05' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbmaytax   ,
               (SELECT sum(tax) as Totalbjunetax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '06' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjunetax   ,
               (SELECT sum(tax) as Totalbjulytax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '07' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbjulytax   ,
               (SELECT sum(tax) as Totalbaugusttax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '08' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbaugusttax   ,
               (SELECT sum(tax) as Totalbseptax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '09' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbseptax   ,
              (SELECT sum(tax) as Totalbocttax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '10' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbocttax   ,
               (SELECT sum(tax) as Totalbnovtax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '11' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbnovtax   ,
               (SELECT sum(tax) as Totalbdectax from ( SELECT month,tax from customer_payment_request where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm'   union all SELECT month,tax from recurring_payment where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm' union all SELECT month,tax from pos where merchant_id = '".$merchant_id."' and month = '12' and year = '".$last_year."' and status='confirm' )x group by month ) as Totalbdectax   
                           "); 
                          $getDashboardData = $getDashboard->result_array();
                  $data['getDashboardData'] = $getDashboardData; 
                 $data1 =  array();
                       // $data['item'] = $this->admin_model->data_get_where_gg($last_date, $date,'confirm',$merchant_id,$employee,'customer_payment_request' );
                    $package_data = $this->admin_model->data_get_where_down("customer_payment_request",$date,$last_date,$merchant_id);
  
    $mem = array();
    $member = array();
     foreach($package_data as $each)
    {
      
      
      $package['Amount'] = '$'.$each->amount;
      $package['Tax'] = '$'.$each->tax;
      $package['Card'] = Ucfirst($each->card_type);
      if($each->type='straight'){
      $package['Type'] = 'Invoice';
      }
      else
      {
          $package['Type'] = $each->type;
      }
      
      $package['Date'] = $each->date_c; 
      
      
        $package['Referece'] = $each->reference;
    
    
      
      $mem[] = $package;
    }
    $data['item'] = $mem;



   $package_data1 = $this->admin_model->data_get_where_down("recurring_payment",$date,$last_date,$merchant_id);
  
  $mem1 = array();
    $member1 = array();
 
     foreach($package_data1 as $each)
    {
      
      
      $package1['Amount'] = '$'.$each->amount;
      $package1['Tax'] = '$'.$each->tax;
      $package1['Card'] = Ucfirst($each->card_type);
      if($each->type='recurring'){
      $package1['Type'] = 'INV';
      }
      else
      {
          $package1['Type'] = $each->type;
      }
      
      $package1['Date'] = $each->date_c; 
      
      
        $package1['Referece'] = $each->reference;
    
    
      
      $mem1[] = $package1;
    }
    $data['item1'] = $mem1;
    
     $package_data2 = $this->admin_model->data_get_where_down("pos",$date,$last_date,$merchant_id);
     
    $mem2 = array();
    $member2 = array();
   
     foreach($package_data2 as $each)
    {
      
      
     if($each->status=='Chargeback_Confirm')
      {
      $package2['Amount'] = '-$'.$each->amount;
      }
      else
      {
           $package2['Amount'] = '$'.$each->amount;
      }
      $package2['Tax'] = '$'.$each->tax;
      $package2['Card'] = Ucfirst($each->card_type);
      $package2['Type'] = strtoupper($each->type);
      $package2['Date'] = $each->date_c; 
      $package2['Referece'] = $each->reference;
    
    
      
      $mem2[] = $package2;
    }
    $data['item2'] = $mem2;
    
        


          $data['item3']= json_encode(array_merge($data['item'],$data['item1'],$data['item2']));
                   
          //  $data['highchart'] = $this->admin_model->get_details($merchant_id);
                   // echo json_encode($data['highchart']);
                             if($this->input->post('start')!=''){
              echo json_encode($data);
              die();
          }
          else
          {
           return $this->load->view('merchant/dashboard',$data);
          }
              
          }
                      public function index1(){
                  $data["title"] ="Merchant Panel";
                                  $merchant_id = $this->session->userdata('merchant_id');
                  
                  $today2 = date("Y");
                          $last_year = date("Y",strtotime("-1 year"));
                           $last_date = date("Y-m-d",strtotime("-29 days"));
                 $date = date("Y-m-d");
                     $start = $this->input->post('start');
              $end = $this->input->post('end');
               $employee = $this->input->post('employee');
                         //  $last_date1 = date("Y-m-d",strtotime("-29 days"));
                 //$date1 = date("Y-m-d");
             if($start=='undefined')
             {
             
                 
                 $last_date = date("Y-m-d",strtotime("-29 days"));
                 $date = date("Y-m-d");
             
             }
              elseif($start!='')
             {
             $last_date = $start;
                 $date = $end;
             
             }
             else
             {
              $last_date = date("Y-m-d",strtotime("-29 days"));
                 $date = date("Y-m-d");
             }
                         if($employee=='all')
         {
            $getDashboard = $this->db->query("SELECT  
                            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountPOS
                                   "); 
         }
         elseif($employee=='merchant')
         {
        $getDashboard = $this->db->query("SELECT 
                            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountPOS
                                   "); 
         }
         else
         {
                   $getDashboard = $this->db->query("SELECT 
                      (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and sub_merchant_id ='".$employee."' and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and sub_merchant_id ='".$employee."'  and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and sub_merchant_id ='".$employee."'  and merchant_id = '".$merchant_id."' and date_c >= '".$last_date."' and date_c <= '".$date."') as TotalAmountPOS
                                   ");  }
       
         
               
                  $getDashboardData = $getDashboard->result_array();
                  $data['getDashboardData'] = $getDashboardData; 
                 $data1 =  array();
                  $package_data = $this->admin_model->data_get_where_down("customer_payment_request",$date,$last_date,$merchant_id);
  
    $mem = array();
    $member = array();
      $sum = 0;
   $sum_ref = 0;
    foreach($package_data as $each)
    {
     if($each->status=='Chargeback_Confirm')
      {
      $package['Amount'] = '-$'.$each->amount;
       $sum_ref+= $each->amount;
      }
      else
      {
           $package['Amount'] = '$'.$each->amount;
            $sum+= $each->amount;
      }
      $package['Tax'] = $each->tax;
       $package['Card'] = Ucfirst($each->card_type);
      if($each->type='straight'){
      $package['Type'] = 'INV';
      }
      else
      {
          $package['Type'] = $each->type;
      }
      $package['Date'] = $each->date_c; 
      $package['Referece'] = $each->reference; 
      $mem[] = $package;
    }
    $data['item'] = $mem;

   $package_data1 = $this->admin_model->data_get_where_down("recurring_payment",$date,$last_date,$merchant_id);
  
   $mem1 = array();
    $member1 = array();
      $sum1 = 0;
   $sum_ref1 = 0;
 
     foreach($package_data1 as $each)
    {
      if($each->status=='Chargeback_Confirm')
      {
      $package1['Amount'] = '-$'.$each->amount;
       $sum_ref1+= $each->amount;
      }
      else
      {
           $package1['Amount'] = '$'.$each->amount;
            $sum1+= $each->amount;
      }
      $package1['Tax'] = '$'.$each->tax;
       $package1['Card'] = Ucfirst($each->card_type);
      if($each->type='recurring'){
      $package1['Type'] = 'INV';
      }
      else
      {
          $package1['Type'] = $each->type;
      }
      $package1['Date'] = $each->date_c; 
      $package1['Referece'] = $each->reference;
      $mem1[] = $package1;
    }
    $data['item1'] = $mem1;

         $package_data2 = $this->admin_model->data_get_where_down("pos",$date,$last_date,$merchant_id);
   
    $mem2 = array();
    $member2 = array();
   
    $sum2 = 0;
   $sum_ref2 = 0;
   
     foreach($package_data2 as $each)
    {
      if($each->status=='Chargeback_Confirm')
      {
      $package2['Amount'] = '-$'.$each->amount;
       $sum_ref2+= $each->amount;
      }
      else
      {
           $package2['Amount'] = '$'.$each->amount;
            $sum2+= $each->amount;
      }
      $package2['Tax'] = '$'.$each->tax;
       $package2['Card'] = Ucfirst($each->card_type);
      $package2['Type'] = strtoupper($each->type);
      $package2['Date'] = $each->date_c; 
      $package2['Referece'] = $each->reference;
    
    
      
      $mem2[] = $package2;
    }
    $data['item2'] = $mem2;
    
    
    //print_r($package_data2);die();
//      $package_data3 =  'Array ( [0] => stdClass Object ( [amount] => 0.25 [tax] => 0.00 [card_type] => Discover [type] => pos [date_c] => 2019-01-12 [reference] => 0 [status] => confirm ) )'; 
// //  print_r( $package_data3);die();
     
//     $mem3 = array();
//     $member3 = array();
   
//      foreach($package_data3 as $each)
//     {
      
//      $package3['Amount'] = '$'.$each->amount;
//       $package3['Tax'] = '';
//       $package3['Card'] ='';
//       $package3['Type'] = '';
//       $package3['Date'] = '';
//       $package3['Referece'] = '';
    
    
      
//       $mem3[] = $package3;
//     }
    
    //$data['item4'] = $mem3;
  // $data['item4'] = 'Array ( [0] => Array ( [Amount] => 0.25 [Tax] => 0.00 [Card] => Discover [Type] => POS [Date] => 2019-01-12 [Referece] => 0 )   )';
    
// print_r($data['item4']);

//echo 'shuaeb'.'<br>';
$totalsum = number_format($sum + $sum1 + $sum2,2);
$totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2,2);

$data['item4'] = [
    [
        "Amount" => "",
        "Tax" => '',
        "Card" => '',
        "Type" => '',
        "Date" => '',
        "Referece" => ''
    ],
    [
        "Amount" => "Sum Amount = $ ".$totalsum,
        "Tax" => '',
        "Card" => '',
        "Type" => '',
        "Date" => '',
        "Referece" => ''
    ],
    
    [
        "Amount" => "Refund Amount = $ ". $totalsumr,
        "Tax" => '',
        "Card" => '',
        "Type" => '',
        "Date" => '',
        "Referece" => ''
    ]
];
// $data['item5'] = [["refundamount"=>"$sum_ref"]];

//print_r($data['item4']);die();
// print_r($data);die();
// print_r($data);die();


        //  $data['item3']= json_encode(array_merge($data['item'],$data['item1'],$data['item2'],$data['item4'],$data['item5']));


        $data['item3']= json_encode(array_merge($data['item'],$data['item1'],$data['item2'],$data['item4']));
                     if($this->input->post('start')!=''){
              echo json_encode($data);
              
              die();
          }
          else
          {
           return $this->load->view('merchant/dashboard',$data);
          }
              
          }
       	function my_encrypt( $string, $action = 'e' ) {
          // you may change these values to your own
          $secret_key = '1@#$%^&s6*';
          $secret_iv = '`~ @hg(n5%';
                  $output = false;
          $encrypt_method = "AES-256-CBC";
          $key = hash( 'sha256', $secret_key );
          $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
                  if( $action == 'e' ) {
              $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
          }
          else if( $action == 'd' ){
              $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
          }
                  return $output;
      }
                
              public function add_employee()
        {
           $data['meta'] = "Add New Employee";
          $data['loc'] = "add_employee";
          $data['action'] = "Add New Employee";
                   
            if (isset($_POST['submit'])) {
                 $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
                 // $this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[merchant.mob_no]');
                   $this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[merchant.mob_no]');
                          $email = $this->input->post('email') ? $this->input->post('email') : "";
                   $name = $this->input->post('name') ? $this->input->post('name') : "";
                  $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                  $password1 = $this->input->post('password') ? $this->input->post('password') : "";
                  
                              
            $password = $this->my_encrypt( $password1, 'e' );
                      $view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') :'0'. "";
              $edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') :'0'. "";
          $create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') :'0'. "";
                 
                 
                  if ($this->form_validation->run() == FALSE) {
                      $this->load->view("merchant/add_employee" , $data);
                  } else {
                    $merchant_id = $this->session->userdata('merchant_id');
            $today1 = date("Ymdhms");
            $today2 = date("Y-m-d");
            
                      $data = Array(
                         
                              'name' => $name,
                              'email' => $email,
                              'mob_no' => $mobile,
                              'user_type' => 'employee',
                              'merchant_id' => $merchant_id,
                              'password' => ($password),
                              'view_permissions' => $view_permissions,
                              'edit_permissions' => $edit_permissions,
                              'create_pay_permissions' => $create_pay_permissions,
                              'status' => 'active',
                              'date_c' => $today2
                );
                         
                      $id = $this->admin_model->insert_data("merchant", $data);
              
              redirect(base_url().'merchant/all_employee');
                    
                  }
              } 
           else {
                  $this->load->view("merchant/add_employee" , $data);
              }
           
          
        
        }
                      public function edit_employee()
        {
                   $data['meta'] = "Update Employee";
          $data['action'] = "Update Employee";
          $data['loc'] = "edit_employee";
            
          $bct_id = $this->uri->segment(3);
          
          if(!$bct_id && !$this->input->post('submit'))
          {
            echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
            die;
          }
          $branch = $this->admin_model->get_employee_details($bct_id);
          if($this->input->post('submit'))
          {
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
                  $this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[merchant.mob_no]');
                    $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
               $email = $this->input->post('email') ? $this->input->post('email') : "";
                   $name = $this->input->post('name') ? $this->input->post('name') : "";
                  $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                                  $password = $this->input->post('password') ? $this->input->post('password') : "";
                   $status = $this->input->post('status') ? $this->input->post('status') : "";
                  $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
                      $view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') :'0'. "";
              $edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') :'0'. "";
                $create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') :'0'. "";
                 
         
                              
            $password1 = $this->my_encrypt( $cpsw, 'e' );
       
                if($cpsw!='')
            {
            $psw1 = $password1 ;
            }
            else 
            {
              $psw1 = $password;  
            }
                                    
            $data = array(
                      'name' => $name,
                              'email' => $email,
                              'mob_no' => $mobile,
                              'password' => $psw1,
                              'view_permissions' => $view_permissions,
                              'edit_permissions' => $edit_permissions,
                              'create_pay_permissions' => $create_pay_permissions,
                              'status' => $status,
                                );
                      
                          
            
            $this->admin_model->update_data('merchant',$data, array('id' => $id));
                $this->session->set_userdata("mymsg",  "Data Has Been Updated.");
              
                        redirect(base_url().'merchant/all_employee');
          
          }
          else
          {
            foreach($branch as $sub)
            {
              $data['bct_id'] = $sub->id;
              $data['email'] = $sub->email;
                $data['name'] = $sub->name;
              $data['mobile'] = $sub->mob_no;
              $data['password'] = $sub->password;
              $data['status'] = $sub->status;
                      
              $data['view_permissions'] = $sub->view_permissions;
                $data['edit_permissions'] = $sub->edit_permissions;
              $data['create_pay_permissions'] = $sub->create_pay_permissions;
            
              break;
            } 
          } 
          
          $this->load->view('merchant/add_employee', $data);
          
        }
        
                                public function all_employee()
       {
             
          $data = array();
        
          $merchant_id = $this->session->userdata('merchant_id');
          
          $package_data = $this->admin_model->get_full_details_employee('merchant',$merchant_id);
           $merchant_status = $this->session->userdata('merchant_status');
            $Activate_Details = $this->session->userdata('Activate_Details');
            if($merchant_status=='active'){
          $mem = array();
          $member = array();
          foreach($package_data as $each)
          {
             
            $package['id'] = $each->id;
            $package['name'] = $each->name;
            $package['email'] = $each->email;
            $package['mob_no'] = $each->mob_no;
                  
                  $package['view_permissions'] = $each->view_permissions;
            $package['edit_permissions'] = $each->edit_permissions;
            $package['create_pay_permissions'] = $each->create_pay_permissions;
            
             
            $package['status'] = $each->status;
                    
            $mem[] = $package;
          }
          $data['mem'] = $mem;
          $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          $this->session->unset_userdata('mymsg');
          
               $this->load->view('merchant/all_employee', $data);
               
            }elseif($merchant_status=='block'){
                $data['meta'] = "Your Account Is Block";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/block" , $data);
            }elseif($merchant_status=='confirm'){
                $data['meta'] = "Your Account Is Not Active";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/block" , $data);
            }elseif($merchant_status=="Activate_Details"){
                $urlafterSign = 'https://salequick.com/merchant/after_signup';
                $data['meta'] = "Please Activate Your Account <a href='".$urlafterSign."'>Activate Link</a>";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/blockactive" , $data);
            }elseif($merchant_status=="Waiting_For_Approval"){
                $urlafterSign = 'https://salequick.com/merchant/after_signup';
                $data['meta'] = "Waiting For Admin Approval, <a href='".$urlafterSign."'>Activate Link</a>";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/blockactive" , $data);
            }else{
                $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
                $data['loc'] = "resend";
                $data['resend'] = "resend";
                $this->load->view("merchant/block" , $data);
            }
       }
        
      public function employee_delete($id)
        {
          $this->admin_model->delete_by_id($id,'merchant');
          echo json_encode(array("status" => TRUE));
        }
        
         public function pending_delete($id)
        {
          $this->admin_model->delete_by_id($id,'customer_payment_request');
          echo json_encode(array("status" => TRUE));
        }
                              public function add_user()
        {
           $data['meta'] = "Add New User";
          $data['loc'] = "add_user";
          $data['action'] = "Add New User";
                   
            if (isset($_POST['submit'])) {
                 $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[user.email]');
                  $this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[user.mob_no]');
                   $this->form_validation->set_rules('domain_name', 'Domain Name', 'required|is_unique[user.domain]');
                          $email = $this->input->post('email') ? $this->input->post('email') : "";
                   $name = $this->input->post('name') ? $this->input->post('name') : "";
                  $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                   $address = $this->input->post('address') ? $this->input->post('address') : "";
                   $domain_name = $this->input->post('domain_name') ? $this->input->post('domain_name') : "";
                 
         
                 
                  if ($this->form_validation->run() == FALSE) {
                      $this->load->view("merchant/add_user" , $data);
                  } else {
                    $merchant_id = $this->session->userdata('merchant_id');
                    $merchant_auth_key = $this->session->userdata('merchant_auth_key');
            $today1 = 'SL_'.date("Ymdhms");
            $today2 = date("Y-m-d");
            
                      $data = Array(
                         
                              'name' => $name,
                              'email' => $email,
                              'mob_no' => $mobile,
                              'address1' => $address,
                               'domain' => $domain_name,
                              'merchant_id' => $merchant_id,
                              'm_auth_key' => $merchant_auth_key,
                              'auth_key' => $today1,
                              'status' => 'active',
                              'date_c' => $today2
                );
                         
                      $id = $this->admin_model->insert_data("user", $data);
              
              redirect(base_url().'merchant/all_user');
                    
                  }
              } 
           else {
                  $this->load->view("merchant/add_user" , $data);
              }
           
          
        
        }
          public function after_signup()
        {
           $data['meta'] = "Add New User";
          $data['loc'] = "add_user";
          $data['action'] = "Add New User";    
              
      if (isset($_POST['submit'])) {
                 //$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[user.email]');
                  $this->form_validation->set_rules('business_number', 'Business Phone Number', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[user.mob_no]');
                      $merchant_id = $this->session->userdata('merchant_id');
                    $merchant_auth_key = $this->session->userdata('merchant_auth_key');
            $today1 = 'SL_'.date("Ymdhms");
            $today2 = date("Y-m-d");
            
                      $data = Array(
                         
                              'business_type' => $this->input->post('business_type'),
                              'industry_type' => $this->input->post('industry_type'),
                          'business_service' => $this->input->post('business_service'),
                          'website' => $this->input->post('website'),
                          'year_business' => $this->input->post('year_business'),
                          //'mob_no' => $this->input->post('website'),
                          'business_number' => $this->input->post('business_number'),
                           'monthly_processing_volume' => $this->input->post('monthly_processing_volume'),
                            'business_dba_name' => $this->input->post('business_dba_name'),
                          'business_name' =>$this->input->post('business_name'),
                          'ien_no' =>$this->input->post('ien_no'),
                          'address1' =>$this->input->post('address1'),
            'city' =>$this->input->post('city'),
            'country' =>$this->input->post('country'),
                          'o_name' =>$this->input->post('o_name').' '.$this->input->post('o_last_name'),
                          'o_dob' =>$this->input->post('o_dob'),
                          'o_ss_number' =>$this->input->post('o_ss_number'),
                          'percentage_of_ownership' =>$this->input->post('percentage_of_ownership'),
                          'o_address' =>$this->input->post('o_address'),
                          'cc_business_name' =>$this->input->post('cc_business_name'),
                          'bank_routing' =>$this->input->post('bank_routing'),
                          'bank_account' =>$this->input->post('bank_account'),
                          'bank_name' =>$this->input->post('bank_name'),       
                          'funding_time' =>$this->input->post('funding_time'), 
            'zip' =>$this->input->post('zip'),
            
            'bank_country' =>$this->input->post('bank_country'),
            'bank_street' =>$this->input->post('bank_street'),
            'bank_city' =>$this->input->post('bank_city'),
            'bank_zip' =>$this->input->post('bank_zip'),
                      
                          'status' => 'Waiting_For_Approval',
                          'date_c' => $today2
                );
                         $merchant_id = $this->session->userdata('merchant_id');
                      
                  $id = $this->admin_model->update_data("merchant", $data,array("id"=>$merchant_id));
                      
                $this->session->set_userdata("merchant_status",'Waiting_For_Approval');
          redirect(base_url().'merchant/index');
                    
                  
              } 
           else {
                   $merchant_id = $this->session->userdata('merchant_id');
                      $mearchent = $this->admin_model->data_get_where_serch("merchant",array("id"=>$merchant_id));
                  $data["mearchent"]=json_decode(json_encode($mearchent[0]),true);  
                          
              $this->load->view("merchant/after_signup" , $data);
              }   
        
        }
          public function edit_user()
        {
                   $data['meta'] = "Update User";
          $data['action'] = "Update User";
          $data['loc'] = "edit_user";
            
          $bct_id = $this->uri->segment(3);
          
          if(!$bct_id && !$this->input->post('submit'))
          {
            echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
            die;
          }
          $branch = $this->admin_model->get_user_details($bct_id);
          if($this->input->post('submit'))
          {
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[user.email]');
                  $this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[user.mob_no]');
                    $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
               $email = $this->input->post('email') ? $this->input->post('email') : "";
                   $name = $this->input->post('name') ? $this->input->post('name') : "";
                  $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
        $address = $this->input->post('address') ? $this->input->post('address') : "";
                   $status = $this->input->post('status') ? $this->input->post('status') : "";
              $domain_name = $this->input->post('domain_name') ? $this->input->post('domain_name') : "";
              
                                   
           $data = array(
                      'name' => $name,
                              'email' => $email,
                              'mob_no' => $mobile,
                              'address1' => $address,
                               'domain' => $domain_name,
                              'name' => $name,
                             'status' => $status
                                );
                      
                            
            
            $this->admin_model->update_data('user',$data, array('id' => $id));
            $this->session->set_userdata("mymsg",  "Data Has Been Updated.");
              
                        redirect(base_url().'merchant/all_user');
          
          }
          else
          {
            foreach($branch as $sub)
            {
              $data['bct_id'] = $sub->id;
              $data['email'] = $sub->email;
              $data['domain_name'] = $sub->domain;
                $data['name'] = $sub->name;
              $data['mobile'] = $sub->mob_no;
               $data['auth_key'] = $sub->auth_key;
             $data['address'] = $sub->address1;
              $data['status'] = $sub->status;
                 
            
              break;
            } 
          } 
          
          $this->load->view('merchant/add_user', $data);
          
        }
        
                                public function all_user()
       {
             
          $data = array();
        
          $merchant_id = $this->session->userdata('merchant_id');
          
          $package_data = $this->admin_model->get_full_details_employee('user',$merchant_id);
          
          $mem = array();
          $member = array();
          foreach($package_data as $each)
          {
             
            $package['id'] = $each->id;
            $package['name'] = $each->name;
            $package['email'] = $each->email;
            $package['mob_no'] = $each->mob_no;
            $package['auth_key'] = $each->auth_key;
                  
                  $package['address1'] = $each->address1;
            $package['created_on'] = $each->created_on;
                  
                 
            
             
            $package['status'] = $each->status;
                    
            $mem[] = $package;
          }
          $data['mem'] = $mem;
          $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          $this->session->unset_userdata('mymsg');
          
               $this->load->view('merchant/all_user', $data);
       }
        
      public function user_delete($id)
        {
          $this->admin_model->delete_by_id($id,'user');
          echo json_encode(array("status" => TRUE));
        }
                      public function add_tax()
        {
           $data['meta'] = "Add New Tax";
          $data['loc'] = "add_tax";
          $data['action'] = "Add New Tax";
           
            if (isset($_POST['submit'])) {
                 $this->form_validation->set_rules('title', 'Title', 'required');
                 $this->form_validation->set_rules('percentage', 'Percentage', 'required');
                          $title = $this->input->post('title') ? $this->input->post('title') : "";
                   $percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";
                 
                  if ($this->form_validation->run() == FALSE) {
                      $this->load->view("merchant/add_tax" , $data);
                  } else {
                    $merchant_id = $this->session->userdata('merchant_id');
            $today1 = date("Ymdhms");
            $today2 = date("Y-m-d");
            
                      $data = Array(
                         
                              'title' => $title,
                              'percentage' => $percentage,
                              'merchant_id' => $merchant_id,
                              'status' => 'active',
                              'date_c' => $today2
                );
                         
                      $id = $this->admin_model->insert_data("tax", $data);
              
              redirect(base_url().'merchant/tax_list');
                    
                  }
              } 
           else {
                  $this->load->view("merchant/add_tax" , $data);
              }
           
          
        
        }
                      public function edit_tax()
        {
            
          $bct_id = $this->uri->segment(3);
          
          if(!$bct_id && !$this->input->post('submit'))
          {
            echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
            die;
          }
          $branch = $this->admin_model->data_get_where('tax', array('id' => $bct_id));
                          if($this->input->post('submit'))
          {
             $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
              $title = $this->input->post('title') ? $this->input->post('title') : "";
                   $percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";
         
       
                                    
            $branch_info = array(
                      'title' => $title,
                              'percentage' => $percentage
                                
                      
                                );
            
            $this->admin_model->update_data('tax',$branch_info, array('id' => $id));
                        $this->session->set_userdata("mymsg",  "Data Has Been Updated.");
              redirect('merchant/tax_list');
                  }
          else
          {
            foreach($branch as $sub)
            {
              $data['bct_id'] = $sub->id;
              $data['title'] = $sub->title;
                $data['percentage'] = $sub->percentage;
              
              break;
            } 
          } 
          $data['meta'] = "Update Tax";
          $data['action'] = "Update Tax";
          $data['loc'] = "edit_tax";
          $this->load->view('merchant/add_tax', $data);
          
        }
        
                                public function tax_list()
       {
             
          $data = array();
        
          $merchant_id = $this->session->userdata('merchant_id');
          
          //$package_data = $this->admin_model->get_data('tax',$merchant_id);
                  $package_data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
          
          $mem = array();
          $member = array();
          foreach($package_data as $each)
          {
             
            
            $mem[] = $each;
          }
          $data['mem'] = $mem;
          $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          $this->session->unset_userdata('mymsg');
          
               $this->load->view('merchant/tax_list', $data);
       }
                        
      public function tax_delete($id)
        {
          $this->admin_model->delete_by_id($id,'tax');
          echo json_encode(array("status" => TRUE));
        }
                                                           public function resend() {
          
          
              if (isset($_POST['submit'])) {
        
                  
               
                           $unique = $this->session->userdata('merchant_auth_key');
                   $email = $this->session->userdata('email');
                            $url="https://salequick.com/confirm/".$unique;
                     set_time_limit(3000); 
              $MailTo = $email; 
            //   $MailSubject = 'Confirm Email'; 
            //   $header = "From: Salequick<info@salequick.com >\r\n".
            //           "MIME-Version: 1.0" . "\r\n" .
            //           "Content-type: text/html; charset=UTF-8" . "\r\n"; 
              $msg = " Click this Url: : ".$url.".";
            //   ini_set('sendmail_from', $email); 
            //   mail($MailTo, $MailSubject, $msg, $header);
              
              $MailSubject='Confirm Email';
              $this->email->from('reply@salequick.com', 'Confirm Email');
                   $this->email->to($email);
                  $this->email->subject($MailSubject);
                   $this->email->message($msg);
                  $this->email->send();
                   
                             
                  
                               $this->session->set_userdata("mymsge",  "Please Check Your Email-Id For Confirm Account Link.");
                                       $data['msg'] = "<h3>".$this->session->userdata('mymsge')."</h3>";
                                        $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
                 $data['loc'] = "resend";
                  $data['resend'] = "resend";
                  $this->session->unset_userdata('mymsg');
           $this->load->view("merchant/block" , $data);
                              
                 
              } else {
               
            redirect("merchant/add_customer_request");
              }
          }
        public function add_straight_request(){
            
          	$data= array();
            $merchant_id = $this->session->userdata('merchant_id');
            $merchant_name = $this->session->userdata('merchant_name');
            $t_fee = $this->session->userdata('t_fee');
            $merchantdetails = $this->admin_model->s_fee("merchant",$merchant_id);  
            $s_fee = $merchantdetails['0']['s_fee'];      
            $t_fee = $this->session->userdata('t_fee');
            $fee_invoice = $merchantdetails['0']['invoice'];
            $fee_swap =$merchantdetails['0']['f_swap_Invoice'];
            $fee_email =$merchantdetails['0']['text_email'];
            $names = substr($merchant_name, 0, 3);
            $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '".$merchant_id."' ) as TotalOrders ");
            $getDashboardData = $getDashboard->result_array();
            $getDashboardNum = $getDashboard->num_rows();
            $data['getDashboardNum'] = $getDashboardNum;
            if($getDashboardData==false){
                $data['getDashboardData'] = '0';
                $inv = '1';
            }else{
                $data['getDashboardData'] = $getDashboardData;
                $inv1 = $getDashboardData[0]['TotalOrders'];
                $inv = $inv1+1;
            }
            $merchant_status = $this->session->userdata('merchant_status');
            $Activate_Details = $this->session->userdata('Activate_Details');
            if($merchant_status=='active'){
                $data['meta'] = "Direct Invoice Request";
                $data['loc'] = "add_straight_request";
                $data['action'] = "Send Request";
                if (isset($_POST['submit'])) {
                    $this->form_validation->set_rules('amount', 'amount', 'required');
                    $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
                    
                    
                    $title = $this->input->post('title') ? $this->input->post('title') : "";
                    $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
                    $name = $this->input->post('name') ? $this->input->post('name') : "";
                    $email_id = $this->input->post('email') ? $this->input->post('email') : "";
                    $mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                    $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
                    $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') :'0'."";
                    $note = $this->input->post('note') ? $this->input->post('note') : "";
                    $reference = $this->input->post('reverence') ? $this->input->post('reverence') :'0'."";
                    if(!empty($this->session->userdata('subuser_id'))){
                        $sub_merchant_id = $this->session->userdata('subuser_id');
                    }else{
                        $sub_merchant_id = '0';
                    }
                    $fee = ($amount/100)*$fee_invoice;
                    $fee_swap=($fee_swap!='')?$fee_swap:0;
                    $fee_email=($fee_email!='')?$fee_email:0;
                    $fee=$fee+$fee_swap+$fee_email;
                    $recurring_type = 'false';
                    $recurring_count = '0';
                    $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
                    $recurring_payment = 'stop';
                   // $invoice_no = 'INV'.strtoupper($names).'000'. $sub_merchant_id.rand(10,1000000).$inv;
                     $invoice_no = 'INV'.strtoupper($names).$sub_merchant_id.rand(10,1000000).$inv;
                    $merchant_id = $this->session->userdata('merchant_id');
                    if ($this->form_validation->run() == FALSE) {
                        $this->load->view('merchant/add_straight_request');
                    }else{
                        $today1 = date("Ymdhisu");
                        $url = 'https://salequick.com/payment/PY'.$today1.'/'.$merchant_id;
                        $today2 = date("Y-m-d");
                         $p_date = date('F j, Y',strtotime($today2));
                        $year = date("Y");
                        $month = date("m");
                        $time11 = date("H");
                        if($time11=='00'){
                            $time1 = '01';
                        }else{
                            $time1 = date("H");
                        }
                        $day1 = date("N");
                        $today3 = date("Y-m-d H:i:s");
                        $amountaa = $sub_amount + $fee;
                        $unique = "PY".$today1 ;
                        $data = array(
                            'name' => $name,
                            'invoice_no' => $invoice_no,
                            'sub_total' => $sub_amount,
                            'tax' => $total_tax,
                            'fee' => $fee,
                            's_fee' => $s_fee,
                            'email_id' => $email_id,
                            'mobile_no' => $mobile_no,
                            'amount' => $amount,
                            'title' => $title,
                            'detail' => $remark,
                            'note' => $note,
                            'url' => $url,
                            'payment_type' => 'straight',
                            'recurring_type' => $recurring_type,
                            'recurring_count' => $recurring_count,
                            'recurring_count_paid' => '0',
                            'recurring_count_remain' => $recurring_count,
                            'due_date' => $due_date,
                            'reference' => $reference,
                            'merchant_id' => $merchant_id,
                            'sub_merchant_id' => $sub_merchant_id,
                            'payment_id' => $unique,
                            'recurring_payment' => $recurring_payment,
                            'year' => $year,
                            'month' => $month,
                            'time1' => $time1,
                            'day1' => $day1,
                            'status' => 'pending',
                            'date_c' => $today2,
                            'add_date' => $today3,
                        );
                        $id = $this->admin_model->insert_data("customer_payment_request", $data);
                        // $id1 = $this->admin_model->insert_data("graph", $data);
                        $item_name =json_encode($this->input->post('Item_Name'));
                        $quantity = json_encode($this->input->post('Quantity'));
                        $price = json_encode($this->input->post('Price'));
                        $tax = json_encode($this->input->post('Tax_Amount'));
                        $tax_id = json_encode($this->input->post('Tax'));
                        $total_amount =  json_encode($this->input->post('Total_Amount'));
                        $tax_per = json_encode($this->input->post('Tax_Per'));
                        $item_Detail_1 = array(
                            "p_id" => $id,
                            "item_name" => ($item_name),
                            "quantity" => ($quantity),
                            "price" => ($price),
                            "tax" => ($tax),
                            "tax_id" => ($tax_id),
                            "tax_per" => ($tax_per),
                            "total_amount" => ($total_amount),
                        );
                        $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color FROM merchant WHERE id = '".$merchant_id."' "); 
                        $getDashboardData_m = $getDashboard_m->result_array();
                        $data['getDashboardData_m'] = $getDashboardData_m;
                        $data['business_name'] = $getDashboardData_m[0]['business_name'];
                        $data['address1'] = $getDashboardData_m[0]['address1'];
                        $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
                        $data['logo'] = $getDashboardData_m[0]['logo'];
                        $data['business_number'] = $getDashboardData_m[0]['business_number'];
                        $data['color'] = $getDashboardData_m[0]['color'];
                        $this->admin_model->insert_data("order_item", $item_Detail_1);
                        $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
                        $data['item_detail'] = $item_Detail_1;
                        
                        $data['msgData'] = $data;
                        // echo "<pre>";print_r($data);die;
                        //Send Mail Code
                        $msg = $this->load->view('email/invoice', $data, true);
                        $email = $email_id;
                        
                //   $config['mailtype'] = 'html';
                //   $this->email->initialize($config);
                //     $email_config = Array(
                //       'protocol'  => 'smtp',
                //       'smtp_host' => 'ssl://linux3.gipcloudlinux.com',
                //       'smtp_port' => '465',
                //       'smtp_user' => 'donotreply@salequick.co',
                //       'smtp_pass' => 'Augurs@009',
                //       'mailtype'  => 'html',
                //       'charset' => 'utf-8',
                //       'starttls'  => true,
                //       'newline'   => "\r\n"
                //     );
                //  $this->load->library('email', $email_config);
                //   $from = "donotreply@salequick.co";
                //     $subject = "Salequick Invoice";
                //     $headers  = "From: $from\r\n"; 
                //   $headers .= "Content-type: text/html\r\n";
                //     mail($email, $subject, $msg, $headers);
                                    
                         if(!empty($mobile_no)){
                        $sms_reciever = $mobile_no;
                        //$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
                         $sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."') $url ");
                        
                        $from = '+18325324983'; //trial account twilio number
                        // $to = '+'.$sms_reciever; //sms recipient number
                        $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
                        $to = '+1'.$mob;
                        $response = $this->twilio->sms($from, $to,$sms_message);
                         }
                       //print_r($response); die();
                        
                       
                        // $from = "donotreply@salequick.com";
                        // $subject = "Salequick Invoice";
                        // $headers  = "From: $from\r\n"; 
                        // $headers .= "Content-type: text/html\r\n";
                        // mail($email, $subject, $msg, $headers);
                        
                      $MailTo = $email;
                      $MailSubject = 'Salequick Invoice'; 
//                       $headers  = "MIME-Version: 1.0\r\n"; 
//                       $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//                       $headers .= "From: Salequick<donotreply@salequick.com >\r\n";                  
//                       mail($MailTo, $MailSubject, $msg, $headers);
                      
                      
//                       $config['mailtype'] = 'html';
// $this->email->initialize($config);
// $this->email->to($email);
// $this->email->from('info@salequick.com','SaleQuick');
// $this->email->subject('Payment Reciept');
// $this->email->message($htmlContent);
// //$this->email->attach('files/attachment.pdf');
// $this->email->send();
if(!empty($email)){
$this->email->from('reply@salequick.com', 'SaleQuick');
$this->email->to($MailTo);
$this->email->subject($MailSubject);
$this->email->message($msg);
$this->email->send();
}
                      
                    //   mail($MailTo, $MailSubject, $msg, $headers);
                    
                  // $host = 'http://moogli.in/komal/api.php';
                  // echo '<br>';
                  // echo 'Mail_status='.$Mail_s;
                  //$url = $host."?to=".$email."&message=".$msg;
               
                 
             //$url = "http://moogli.in/komal/api.php?to=".$email.&"message="test;
             
           //  $post_data = array('to' => $email,'message' => $msg);
          // $url = "http://moogli.in/komal/api.php";
             
             
                // PHP cURL  for https connection with auth
               // $ch = curl_init();
              //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
               // curl_setopt($ch, CURLOPT_URL, $url);
               // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
             //   curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
             //   curl_setopt($ch, CURLOPT_TIMEOUT, 10);
             //   curl_setopt($ch, CURLOPT_POST, true);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                // converting
             //   $response = curl_exec($ch); 
    			//$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                //$json = json_encode($xml);
               // $arrayy = json_decode($json,TRUE);
               
             //  $url = "https://api.betterdoctor.com/2016-03-01/doctors?".$query;
             
        // working  curl code    
             
    //   $url = "http://moogli.in/komal/api.php?to=$email"."&message=".$url;
    //   $curl = curl_init();
    //   curl_setopt_array($curl, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,  // Capture response.
    //         CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         //CURLOPT_POST => 1,
    //         //CURLOPT_POSTFIELDS => $post_data,
    //         //CURLOPT_CUSTOMREQUEST => "POST",
    //       CURLOPT_CUSTOMREQUEST => "GET",
           
    //     ));
    //     $response = curl_exec($curl);




//$handle = curl_init($url);

        //CURLOPT_RETURNTRANSFER => true,     // return web page
       // CURLOPT_HEADER         => false,    // don't return headers
       // CURLOPT_FOLLOWLOCATION => true,     // follow redirects
       // CURLOPT_ENCODING       => "",       // handle all encodings
       // CURLOPT_USERAGENT      => "spider", // who am i
      //  CURLOPT_AUTOREFERER    => true,     // set referer on redirect
      //  CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
      //  CURLOPT_TIMEOUT        => 120,      // timeout on response
      //  CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
      
// curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);      
// curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);  
// curl_setopt($handle, CURLOPT_HEADER, false); 
// curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
// curl_setopt($handle, CURLOPT_ENCODING, "");
// curl_setopt($handle, CURLOPT_USERAGENT, "spider"); 
// curl_setopt($handle, CURLOPT_AUTOREFERER, true);
// curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 120);
// curl_setopt($handle, CURLOPT_TIMEOUT, 120);
// curl_setopt($handle, CURLOPT_MAXREDIRS, 120);

//curl_setopt($handle, CURLOPT_POST, true);
//curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
//curl_exec($handle);
  
                                                                                                                     
   // $result = curl_exec($handle);
               
               
    	     // print_r($response);
    	      // die();
                //curl_close($curl);

                      
                        $this->session->set_userdata("mymsg",  "New payment Request Add Successfully.");
                      
                        // redirect("merchant/all_straight_request");
                        redirect("pos/all_customer_request");
                    }
                }else {
                    $this->load->view("merchant/add_straight_request" , $data);
                }
            }elseif($merchant_status=='block'){
                $data['meta'] = "Your Account Is Block";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/block" , $data);
            }elseif($merchant_status=='confirm'){
                $data['meta'] = "Your Account Is Not Active";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/block" , $data);
            }elseif($merchant_status=="Activate_Details"){
                $urlafterSign = 'https://salequick.com/merchant/after_signup';
                $data['meta'] = "Please Activate Your Account <a href='".$urlafterSign."'>Activate Link</a>";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/blockactive" , $data);
            }elseif($merchant_status=="Waiting_For_Approval"){
                $urlafterSign = 'https://salequick.com/merchant/after_signup';
                $data['meta'] = "Waiting For Admin Approval, <a href='".$urlafterSign."'>Activate Link</a>";
                $data['loc'] = "";
                $data['resend'] = "";
                $this->load->view("merchant/blockactive" , $data);
            }else{
                $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
                $data['loc'] = "resend";
                $data['resend'] = "resend";
                $this->load->view("merchant/block" , $data);
            }
        }
        public function add_customer_request(){
            $merchant_id = $this->session->userdata('merchant_id');
            $merchant_name = $this->session->userdata('merchant_name');
            $t_fee = $this->session->userdata('t_fee');
            $aa = $this->admin_model->s_fee("merchant",$merchant_id);  
            $merchantdetails = $this->admin_model->s_fee("merchant",$merchant_id);  
            $s_fee = $merchantdetails['0']['s_fee'];      
            $t_fee = $this->session->userdata('t_fee');
            $fee_invoice = $merchantdetails['0']['recurring'];
            $fee_swap =$merchantdetails['0']['f_swap_Recurring'];
            $fee_email =$merchantdetails['0']['text_email'];
            $names = substr($merchant_name, 0, 3);
            $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '".$merchant_id."' ) as TotalOrders "); 
            $getDashboardData = $getDashboard->result_array();
            $getDashboardNum = $getDashboard->num_rows();
            $data['getDashboardNum'] = $getDashboardNum;
            if($getDashboardData==false){
                $data['getDashboardData'] = '0';
                $inv = '1';
            }else{
                $data['getDashboardData'] = $getDashboardData;
                $inv1 = $getDashboardData[0]['TotalOrders'];
                $inv = $inv1+1;
            }
            $merchant_status = $this->session->userdata('merchant_status');
            if($merchant_status=='active'){
                $data['meta'] = "Send Recurring Payment Request";
                $data['loc'] = "add_customer_request";
                $data['action'] = "Send Request";
                if (isset($_POST['submit'])) {
                 // $this->form_validation->set_rules('amount', 'amount', 'required');
                    $this->form_validation->set_rules('title', 'title', 'required');
                    $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
                    $title = $this->input->post('title') ? $this->input->post('title') : "";
                    $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
                    $name = $this->input->post('name') ? $this->input->post('name') : "";
                    $email_id = $this->input->post('email') ? $this->input->post('email') : "";
                    $mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
                    $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
                    $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
                    $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
                    $note = $this->input->post('note') ? $this->input->post('note') : "";
                    $reference = $this->input->post('reverence') ? $this->input->post('reverence') :'0'."";
                    if(!empty($this->session->userdata('subuser_id'))){
                        $sub_merchant_id = $this->session->userdata('subuser_id');
                    }else{
                        $sub_merchant_id = '0';
                    }
                    $fee = ($amount/100)*$fee_invoice;
                    $fee_swap=($fee_swap!='')?$fee_swap:0;
                    $fee_email=($fee_email!='')?$fee_email:0;
                    $fee=$fee+$fee_swap+$fee_email;
                    $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
                    $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') :'0'. "";
                    $invoice_no = 'INV'.strtoupper($names). $sub_merchant_id.rand(10,1000000).$inv; 
                   // $invoice_no = 'INV'.strtoupper($names).'000'.$inv;
                    $recurring_payment = 'start';
                    $merchant_id = $this->session->userdata('merchant_id');
                    if ($this->form_validation->run() == FALSE) {
                        $this->load->view('merchant/add_customer_request');
                    } else {
                        $today1 = date("Ymdhisu");
                        $url = 'https://salequick.com/rpayment/PY'.$today1.'/'.$merchant_id;
                        $today2 = date("Y-m-d");
                        $year = date("Y");
                        $month = date("m");
                        $today3 = date("Y-m-d H:i:s");
                        $unique = "PY".$today1 ;
                        $time11 = date("H");
                        if($time11=='00'){
                            $time1 = '01';
                        }else{
                            $time1 = date("H");
                        }
                        $day1 = date("N");
                        $amountaa = $sub_amount + $fee  ;
                        $data = Array(
                            'reference' => $reference,
                            'name' => $name,
                            'invoice_no' => $invoice_no,
                            'email_id' => $email_id,
                            'mobile_no' => $mobile_no,
                            'amount' => $amount,
                            'sub_total' => $sub_amount,
                            'tax' => $total_tax,
                            'fee' => $fee,
                            's_fee' => $fee_swap,

                            'title' => $title,
                            'detail' => $remark,
                            'note' => $note,
                            'url' => $url,
                            'payment_type' => 'recurring',
                            'recurring_type' => $recurring_type,
                            'recurring_count' => $recurring_count,
                            'recurring_count_paid' => '0',
                            'recurring_count_remain' => $recurring_count,
                            'due_date' => $due_date,
                            'merchant_id' => $merchant_id,
                            'sub_merchant_id' => $sub_merchant_id,
                            'payment_id' => $unique,
                            'recurring_payment' => $recurring_payment,
                            'year' => $year,
                            'month' => $month,
                            'time1' => $time1,
                            'day1' => $day1,
                            'status' => 'pending',
                            'date_c' => $today2,
                            'add_date' => $today3,
                        );
                        $id = $this->admin_model->insert_data("customer_payment_request", $data);
                        //  $id1 = $this->admin_model->insert_data("graph", $data);
                        $item_name =json_encode($this->input->post('Item_Name'));
                        $quantity = json_encode($this->input->post('Quantity'));
                        $price = json_encode($this->input->post('Price'));
                        $tax = json_encode($this->input->post('Tax_Amount'));
                        $tax_id = json_encode($this->input->post('Tax'));
                        $tax_per = json_encode($this->input->post('Tax_Per'));
                        $total_amount =  json_encode($this->input->post('Total_Amount'));
                        $item_Detail_1 = array(
                            "p_id" => $id,
                            "item_name" => ($item_name),

                            "quantity" => ($quantity),
                            "price" => ($price),
                            "tax" => ($tax),
                            "tax_id" => ($tax_id),
                            "tax_per" => ($tax_per),
                            "total_amount" => ($total_amount),

                        );
                        $this->admin_model->insert_data("order_item", $item_Detail_1);
                        $MailTo = $email_id; 
              $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
                                 
$getDashboard_t = $this->db->query(" SELECT templete FROM email_template WHERE id =1  "); 
$getDashboardData_t = $getDashboard_t->result_array();
                    
                  $data['getDashboardData_t'] = $getDashboardData_t;
                  $templete = $getDashboardData_t[0]['templete'];

       $getDashboard_m = $this->db->query(" SELECT business_dba_name,logo FROM merchant WHERE id = '".$merchant_id."'  "); 
$getDashboardData_m = $getDashboard_m->result_array();
                    
                  $data['getDashboardData_m'] = $getDashboardData_m;
                  $business_name = $getDashboardData_m[0]['business_dba_name'];
                  $logo = $getDashboardData_m[0]['logo'];


$tamount1 = $amount - $total_tax;
   $tamount = number_format($tamount1,2);
                   $token = array(
  
    'USER_NAME' => $name,
    'PHONE' => $this->session->userdata('m_business_number'),
    'EMAIL' => $this->session->userdata('m_email'),
    'AMOUNT'=> number_format($amount,2),
    'COMPANY'=> $business_name,
    'LOGO'=> $logo,
    'TAX'=> number_format($total_tax,2),
    'URL'=> $url,
     'TAMOUNT'=> $tamount,
    'INVOICE_NO'=> $invoice_no,
    'PAYMENT_DATE'=> $today2
   
    
);

$pattern = '[%s]';
foreach($token as $key=>$val){
    $varMap[sprintf($pattern,$key)] = $val;
}

    $MailSubject = 'Payment  Invoice'; 
         $header = "From:Salequick<info@salequick.com >\r\n".
              "MIME-Version: 1.0" . "\r\n" .
              "Content-type: text/html; charset=UTF-8" . "\r\n"; 

              $htmlContent = strtr($templete,$varMap);

$message = mail($email_id, $MailSubject, $htmlContent, $header);
              
              
              $this->session->set_userdata("mymsg",  "New payment Request Add Successfully.");
                     // redirect("merchant/all_customer_request");
                      redirect("pos/all_customer_request_recurring");
                      
                  }
              } 
           else {
                  $this->load->view("merchant/add_customer_request" , $data);
              }
           
          }
                  elseif($merchant_status=='block')
          {
                 $data['meta'] = "Your Account Is Block";
            $data['loc'] = "";
            $data['resend'] = "";
                  $this->load->view("merchant/block" , $data);
          }
                  elseif($merchant_status=='confirm')
          {
                 $data['meta'] = "Your Account Is Not Active";
                 $data['loc'] = "";
                 $data['resend'] = "";
                    $this->load->view("merchant/block" , $data);
          }elseif($merchant_status=="Activate_Details")
          {
            $urlafterSign = 'https://salequick.com/merchant/after_signup';
             $data['meta'] = "Please Activate Your Account <a href='".$urlafterSign."'>Activate Link</a>";
                 $data['loc'] = "";
                 $data['resend'] = "";
                    $this->load->view("merchant/blockactive" , $data);
          }
    
  elseif($merchant_status=="Waiting_For_Approval")
          {
          $urlafterSign = 'https://salequick.com/merchant/after_signup';
             $data['meta'] = "Waiting For Admin Approval, <a href='".$urlafterSign."'>Activate Link</a>";
                 $data['loc'] = "";
                 $data['resend'] = "";
                    $this->load->view("merchant/blockactive" , $data);
          }
          else
      {
                     $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
                 $data['loc'] = "resend";
                  $data['resend'] = "resend";
                         $this->load->view("merchant/block" , $data);
                  }
        
        }
        public function all_customer_request(){
          	$data = array();
           	$merchant_id = $this->session->userdata('merchant_id');
          	if($this->input->post('mysubmit')){
		        $start_date = $_POST['start_date'];
		        $end_date = $_POST['end_date'];
		        $status = $_POST['status'];
		        $package_data = $this->admin_model->get_package_details_customer_r($start_date,$end_date,$status,$merchant_id);
        	}else{
          		$package_data = $this->admin_model->get_full_details_payment_r('customer_payment_request',$merchant_id);
          	}
          	$mem = array();
          	$member = array();
          	foreach($package_data as $each){
	            $package['id'] = $each->id;
	            $package['merchant_id'] = $each->merchant_id;
	            $package['payment_id'] = $each->invoice_no;
	            $package['name'] = $each->name;
	            $package['email'] = $each->email_id; 
	            $package['mobile'] = $each->mobile_no;
	            $package['amount'] = $each->amount;
	            $package['title'] = $each->title; 
	            $package['date'] = $each->add_date; 
	            $package['due_date'] = $each->due_date; 
	            $package['payment_date'] = $each->payment_date; 
	            $package['status'] = $each->status;
	            $package['payment_type'] = $each->payment_type;
	            $package['date_c'] = $each->date_c;
              	$package['recurring_payment'] = $each->recurring_payment;
            	$mem[] = $package;
          	}
          	$data['mem'] = $mem;
          	$data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          	$this->session->unset_userdata('mymsg');
           $this->load->view('merchant/all_customer_request', $data);
       }
      	public function all_straight_request(){
          	$data = array();
           	$merchant_id = $this->session->userdata('merchant_id');
          	if($this->input->post('mysubmit')){
              	$start_date = $_POST['start_date'];
    			$end_date = $_POST['end_date'];
        		$status = $_POST['status'];
        		$package_data = $this->admin_model->get_search_merchant_type($start_date,$end_date,$status,$merchant_id,'customer_payment_request','straight');
            }else{
          		$package_data = $this->admin_model->get_full_details_payment('customer_payment_request',$merchant_id);
          	}
          	$mem = array();
          	$member = array();
          	foreach($package_data as $each){
	            $package['id'] = $each->id;
	            $package['payment_id'] = $each->invoice_no;
	            $package['name'] = $each->name;
	            $package['email'] = $each->email_id; 
	            $package['mobile'] = $each->mobile_no;
	            $package['amount'] = $each->amount;
	            $package['title'] = $each->title; 
	            $package['date'] = $each->add_date; 
	            $package['due_date'] = $each->due_date; 
	            $package['payment_date'] = $each->payment_date; 
	            $package['status'] = $each->status;
	            $package['payment_type'] = $each->payment_type;
              	$package['recurring_payment'] = $each->recurring_payment;
            	$mem[] = $package;
          	}
          	$data['mem'] = $mem;
          	$data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          	$this->session->unset_userdata('mymsg');
       		$this->load->view('merchant/all_straight_request', $data);
       	}
       	public function stop_recurring($id){
          	$this->admin_model->stop_recurring($id);
          	echo json_encode(array("status" => TRUE));
        }
        public function start_recurring($id){
            $this->admin_model->start_recurring($id);
        	echo json_encode(array("status" => TRUE));
        }
     	public function stop_tex($id){
          	$this->admin_model->stop_tex($id);
          	echo json_encode(array("status" => TRUE));
        }
        public function start_tex($id){
            $this->admin_model->start_tex($id);
        	echo json_encode(array("status" => TRUE));
        }
       	public function all_recurrig_request(){ 
          	$data = array();
           	$merchant_id = $this->session->userdata('merchant_id');
        	$id = $this->uri->segment(3);
          	if($this->input->post('mysubmit')){
		        $curr_payment_date = $_POST['curr_payment_date'];
		        $status = $_POST['status'];
		        $package_data = $this->admin_model->get_recurring_details_payment_search($curr_payment_date,$status,$merchant_id);
    		}else{
          		$package_data = $this->admin_model->get_recurring_details_payment($merchant_id,$id);
          	}
          	$mem = array();
          	$member = array();
          	foreach($package_data as $each){
	            $package['rid'] = $each->rid;
	            $package['cid'] = $each->cid;
	            $package['name'] = $each->name;
	            $package['email'] = $each->email_id; 
	            $package['mobile'] = $each->mobile_no;
	            $package['amount'] = $each->amount;
	            $package['title'] = $each->title; 
	            $package['date'] = $each->add_date;
	            $package['payment_date'] = $each->payment_date; 
	            $package['status'] = $each->status;
	            $package['payment_type'] = $each->payment_type;
	                    
	            $mem[] = $package;
          	}
          	$data['mem'] = $mem;
          	$data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          	$this->session->unset_userdata('mymsg');
			$this->load->view('merchant/all_recurrig_request', $data);
       	}
      	public function delete_package(){
            $pak_id = $this->uri->segment(3);
          	if($this->admin_model->delete_package($pak_id))
          	$this->session->set_userdata("mymsg",  "Data Has Been Deleted.");
        }
        public function active_package(){
            $pak_id = $this->uri->segment(3);
          	if($this->admin_model->active_order($pak_id))
          		$this->session->set_userdata("mymsg",  "Merchant Active.");
		}
      	public function add_new_request(){
           	$data['meta'] = "Add New Payment Request";
          	$data['loc'] = "add_new_request";
          	$data['action'] = "Add payment Request";
            if (isset($_POST['submit'])) {
              	$this->form_validation->set_rules('amount', 'amount', 'required');
              	$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
              	$title = $this->input->post('title') ? $this->input->post('title') : "";
              	$remark = $this->input->post('remark') ? $this->input->post('remark') : "";
              	$merchant_id = $this->session->userdata('merchant_id');
              	if ($this->form_validation->run() == FALSE) {
                  	$this->load->view('merchant/add_request');
              	} else {
		            $today1 = date("Ymdhms");
		            $url = 'py'.$today1;
		            $today2 = date("Y-m-d");
		            $today3 = date("Y-m-d H:i:s");
		            $unique = "OH" .$today1 ;
                  	$data = Array(
						'amount' => $amount,
						'title' => $title,
						'detail' => $remark,
						'url' => $url,
						'merchant_id' => $merchant_id,

						'status' => 'pending',
						'date_c' => $today2,
						'add_date' => $today3,
                	);
                         
                  	$id = $this->admin_model->insert_data("payment_request", $data);
          			$this->session->set_userdata("mymsg",  "New payment Request Add Successfully.");
                  	redirect("merchant/all_payment_request");
              	}
          	}else {
                $this->load->view("merchant/add_request" , $data);
          	}
        }
        public function all_payment_request(){
          	$data = array();
          	if($this->input->post('mysubmit')){
		        $curr_payment_date = $_POST['curr_payment_date'];
		        $status = $_POST['status'];
		        $package_data = $this->admin_model->get_package_details_new($curr_payment_date,$status);
    		}else{
          		$package_data = $this->admin_model->get_full_details('payment_request');
          	}
          	$mem = array();
          	$member = array();
          	foreach($package_data as $each){
	            $package['id'] = $each->id;
	            $package['amount'] = $each->amount;
	            $package['title'] = $each->title; 
	            
	            $package['date'] = $each->add_date; 
	            $package['status'] = $each->status;
	                    
	            $mem[] = $package;
          	}
      		$data['mem'] = $mem;
      		$data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
          	$this->session->unset_userdata('mymsg');
           	$this->load->view('merchant/all_payment_request', $data);
       	}
      	public function edit_profile(){
            $data['emymsg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
        	$this->session->unset_userdata('mymsg');
         	$sub_merchant_id = $this->session->userdata('subuser_id');
           	$merchant_id =  $this->session->userdata('merchant_id');
          	// print_r($this->session->userdata);
          	$data['upload_loc'] = base_url('logo');
          	$package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
          	if($this->input->post('mysubmit')){
             	if( empty($sub_merchant_id)){
            		$id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
            		$title = $this->input->post('title') ? $this->input->post('title') : "";
              		$psw = $this->input->post('psw') ? $this->input->post('psw') : "";
		            $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
		            $name = $this->input->post('name') ? $this->input->post('name') : "";
		            $mob_no = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
		            $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
	              	$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
		            $state = $this->input->post('state') ? $this->input->post('state') : "";
		            $city = $this->input->post('city') ? $this->input->post('city') : "";
		            $pin_code = $this->input->post('pin_code') ? $this->input->post('pin_code') : "";
		            $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
		            $color = $this->input->post('color') ? $this->input->post('color') : "";
		            $api_type = $this->input->post('api_type') ? $this->input->post('api_type') : "";
		            $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : "";
		            // if($cpsw!='')
		            // {
		            // $psw1 = $this->my_encrypt($cpsw, 'e' );
		            // }
		            // else 
		            // {
		            //   $psw1 = $psw; 
		            // }
            
             		if($cpsw!=''){
            			$psw1 = $this->my_encrypt($cpsw, 'e' );
            		}
                    $cou = 0;
		          	$config['upload_path'] = 'logo/';  
	              	$config['allowed_types'] = 'gif|jpg|jpeg|png';  
	              	$config['max_size'] = '0';  
	              	$this->load->library('upload', $config);
	              	if($this->upload->do_upload('mypic')){
      					$fInfo = $this->upload->data();
      					$mypic = $fInfo['file_name'];
     					if($cpsw!=''){
      						$package_info = array(
                              	'name' => $name,
                              	'color' => $color,
                              	'password' => $psw1,
                              	'mob_no' => $mob_no,
                              	'address1' => $address1,
                              	'address2' => $address2,
                              	'state' => $state,
                              	'city' => $city,
                              	'pin_code' => $pin_code,
                              	'logo'   => $mypic,
                              	'api_type'   => $api_type,
                              	'report_type' => $report_type
                      		);
    					}else{
         					$package_info = array(
                              	'name' => $name,
                              	'color' => $color,
                              	'mob_no' => $mob_no,
                              	'address1' => $address1,
                              	'address2' => $address2,
                              	'state' => $state,
                              	'city' => $city,
                              	'pin_code' => $pin_code,
                              	'logo'   => $mypic,
                              	'api_type'   => $api_type,
                              	'report_type' => $report_type
                      		);
    					}
    				} else{
         				if($cpsw!=''){
      						$package_info = array(
                      			'name' => $name,
                      			'color' => $color,
                      			'password' => $psw1,
                      			'mob_no' => $mob_no,
                      			'address1' => $address1,
                      			'address2' => $address2,
                      			'state' => $state,
                      			'city' => $city,
                      			'pin_code' => $pin_code,
                      			'api_type'   => $api_type,
                      			'report_type' => $report_type
                      		);
						}else{
        					$package_info = array(
                      			'name' => $name,
                      			'color' => $color,
                      			'mob_no' => $mob_no,
                      			'address1' => $address1,
                      			'address2' => $address2,
                      			'state' => $state,
                      			'city' => $city,
                      			'pin_code' => $pin_code,
                      			'api_type'   => $api_type,
                      			'report_type' => $report_type
                        
                      		);
    					}
    				}
      				$this->admin_model->update_data('merchant',$package_info,array('id' => $id));
              		$this->session->set_userdata("mymsg",  "Data Has Been Updated .");
      				redirect('merchant/edit_profile');
 				}else{
          			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
           			if($cpsw!=''){
        				$psw1 = $this->my_encrypt($cpsw, 'e' );
      					$package_info = array(
                       		'password' => $psw1
                      	);
           				$this->admin_model->update_data('merchant',$package_info,array('id' => $sub_merchant_id));
					}
              		$this->session->set_userdata("mymsg",  "Data Has Been Updated .");
      				redirect('merchant/edit_profile'); 
 				}
  			}else{
    			foreach($package as $pak){
      				$data['pak_id'] = $pak->id;
      				$data['auth_key'] = $pak->auth_key;
      				$data['merchant_key'] = $pak->merchant_key;
      				$data['title'] = $pak->email;
      				$data['name'] = $pak->name;
      				$data['psw'] = $pak->password;
      				$data['color'] = $pak->color;
      				$data['mypic'] = $pak->logo;
      				$data['mob_no'] = $pak->mob_no;
      				$data['address1'] = $pak->address1;
      				$data['address2'] = $pak->address2;
      				$data['state'] = $pak->state;
      				$data['city'] = $pak->city;
      				$data['pin_code'] = $pak->pin_code;
      				$data['status'] = $pak->status;
      				$data['register_type'] = $pak->register_type;
      				$data['api_type'] = $pak->api_type;
      				$data['report_type'] = $pak->report_type;
      				break;
    			} 
  			} 
   			$data['loc'] = "edit_profile";
   			$data['meta'] = 'Update Profile';
       		$data['action'] = 'Update';
  			$this->load->view('merchant/edit_profile', $data);
    
		}
        
     	public function search_record_column() {
          	$searchby = $this->input->post('id');
         	$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
         	// $data['item'] = $this->admin_model->search_item($searchby);
          	$data['pay_report'] = $this->admin_model->search_record($searchby);
         	echo $this->load->view('merchant/show_result', $data,true);
      	}
      	public function search_record_column_pos() {
          	$searchby = $this->input->post('id');
         	//$data['item'] = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
         	// $data['item'] = $this->admin_model->search_item($searchby);
          	$data['pay_report'] = $this->admin_model->search_record_pos($searchby);
         	echo $this->load->view('merchant/show_result_pos', $data,true);
      	}
       	public function search_record_payment() {
        	$searchby = $this->input->post('id');
        	$data['pay_report'] = $this->admin_model->search_record($searchby);
           	echo $this->load->view('admin/show_result_payment', $data,true);
    	}
        public function search_record_pos() {
          	$searchby = $this->input->post('id');
          	$data['item'] = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
            $data['pay_report'] = $this->admin_model->search_pos($searchby);
         	echo $this->load->view('merchant/show_pos', $data,true);
      	}
       	public function search_record_column_recurring() {
          	$searchby = $this->input->post('id');
          	$data['pay_report'] = $this->admin_model->search_record($searchby);
         	echo $this->load->view('merchant/show_result_recurring', $data,true);
      	}
      	public function print_reciept(){
          	$user = $this->uri->segment(3);
          	$file = $user.'_reciept.html';
          	$cont = file_get_contents('reciepts/'.$file);
          	$data['reciept'] = $cont;
          	$this->load->view('registration/reciept.php', $data);
        }
        public function print_welcome(){
          	$user = $this->uri->segment(3);
          	$file = $user.'_welcome.html';
          	$cont = file_get_contents('reciepts/'.$file);
          	$data['reciept'] = $cont;
          	$this->load->view('registration/reciept.php', $data);
        }
        public function get_tax() {
          	$var = $this->input->post('id');
          	$data = $this->admin_model->data_get_where("tax", array("id" => $var));
          	echo json_encode($data);
          	die();
      	}
        public function search_record_pos11() {
          	$searchby = $merchant_id = $this->session->userdata('merchant_id');
          	$data = array();
      		$item = array();
          	$merchant_id = $this->session->userdata('merchant_id');
          	$data['item'] = $this->admin_model->data_get_where_g("customer_payment_request", array("merchant_id" => $merchant_id));
            //$data['pay_report'] = $this->admin_model->search_pos($searchby);
         	echo $this->load->view('merchant/dashboard', $data);
      	}
        public function search_record_column1() {
			$searchby = $this->input->post('id');

			$data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
         	// $data['item'] = $this->admin_model->search_item($searchby);
		  	$data['pay_report'] = $this->admin_model->search_record($searchby);
		 	echo $this->load->view('admin/show_result1', $data,true);
		}
   
  	}
?>