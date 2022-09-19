<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Graph extends CI_Controller
{
 public function __construct() 
     { 
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
    if(!$this->session_checker_model->chk_session_merchant())
    redirect('login');
    
    date_default_timezone_set("America/Chicago");
     }




      public function trends(){

            $data["title"] ="Merchant Panel";

            $merchant_id = $this->session->userdata('merchant_id');
            $today2 = date("Y");

            $last_year = date("Y",strtotime("-1 year"));

              $start = $this->input->post('start');
        $end = $this->input->post('end');

           //  $last_date1 = date("Y-m-d",strtotime("-29 days"));
           //$date1 = date("Y-m-d");
       if($start!='')
       {
        $last_date = $start;
           $date = $end;
       
       } 
       else
       {
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
 
$this_week_sd1 = date("Y-m-d",$sunday2);
$this_week_ed1 = date("Y-m-d",$sunday1);

$this_week_sd = date("Y-m-d",$monday);
$this_week_ed = date("Y-m-d",$sunday);

 $last_date = date("Y-m-d",strtotime("-8 days"));
 $date = date("Y-m-d",strtotime("-1 days"));

            $getDashboard = $this->db->query("SELECT 


              (SELECT sum(amount) as Monday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Monday   ,

               (SELECT sum(amount) as Tuesday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesday   ,

                 (SELECT sum(amount) as Wednesday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesday   ,

                  (SELECT sum(amount) as Thursday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursday   ,

                   (SELECT sum(amount) as Friday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Friday   ,

                   (SELECT sum(amount) as Satuday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satuday   ,

                    (SELECT sum(amount) as Sunday from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed."' and date_c >= '".$this_week_sd."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sunday   ,


                     (SELECT sum(amount) as Monday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '1' and status='confirm' )x group by merchant_id ) as Monday_l   ,

              (SELECT sum(amount) as Tuesday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '2' and status='confirm' )x group by merchant_id ) as Tuesday_l   ,

                 (SELECT sum(amount) as Wednesday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '3' and status='confirm' )x group by merchant_id ) as Wednesday_l   ,

                (SELECT sum(amount) as Thursday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '4' and status='confirm' )x group by merchant_id ) as Thursday_l   ,

                  (SELECT sum(amount) as Friday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '5' and status='confirm' )x group by merchant_id ) as Friday_l   ,

                    (SELECT sum(amount) as Satuday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '6' and status='confirm' )x group by merchant_id ) as Satuday_l   ,

                    (SELECT sum(amount) as Sunday_l from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$this_week_ed1."' and date_c >= '".$this_week_sd1."' and day1 = '7' and status='confirm' )x group by merchant_id ) as Sunday_l   ,



      (SELECT sum(amount) as Totaljana from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 < '2' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 < '2' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 < '2' and status='confirm' )x group by merchant_id ) as Totaljana   ,

               (SELECT sum(amount) as Totalfeba from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' )x group by merchant_id ) as Totalfeba   ,

                 (SELECT sum(amount) as Totalmarcha from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' )x group by merchant_id ) as Totalmarcha   ,

                   (SELECT sum(amount) as Totalaprla from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' )x group by merchant_id ) as Totalaprla   ,

                   (SELECT sum(amount) as Totalmaya from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' )x group by merchant_id ) as Totalmaya   ,

                   (SELECT sum(amount) as Totaljunea from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as Totaljunea   ,

                    (SELECT sum(amount) as Totaljulya from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as Totaljulya   ,

           (SELECT sum(amount) as Totalaugusta from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as Totalaugusta   ,

           (SELECT sum(amount) as Totalsepa from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as Totalsepa   ,

         (SELECT sum(amount) as Totalocta from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as Totalocta  ,

           (SELECT sum(amount) as Totalnova from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as Totalnova   ,

         (SELECT sum(amount) as Totaldeca from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by merchant_id ) as Totaldeca   ,


         (SELECT sum(tax) as Totaljantaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and  time1 < '2' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and  time1 < '2' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and  time1 < '2' and status='confirm' )x group by merchant_id ) as Totaljantaxa   ,
                          

 (SELECT sum(tax) as Totalfebtaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm' )x group by merchant_id ) as Totalfebtaxa   ,

(SELECT sum(tax) as Totalmarchtaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm' )x group by merchant_id ) as Totalmarchtaxa   ,

 (SELECT sum(tax) as Totalaprltaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm' )x group by merchant_id ) as Totalaprltaxa   ,

(SELECT sum(tax) as Totalmaytaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm' )x group by merchant_id ) as Totalmaytaxa   ,

 (SELECT sum(tax) as Totaljunetaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as Totaljunetaxa   ,

(SELECT sum(tax) as Totaljulytaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as Totaljulytaxa   ,

 (SELECT sum(tax) as Totalaugusttaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as Totalaugusttaxa   ,

 (SELECT sum(tax) as Totalseptaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as Totalseptaxa   ,

 (SELECT sum(tax) as Totalocttaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as Totalocttaxa  ,

 (SELECT sum(tax) as Totalnovtaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as Totalnovtaxa   ,

 (SELECT sum(tax) as Totaldectaxa from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by merchant_id ) as Totaldectaxa  ,



(SELECT sum(fee) as Totaljanfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and  time1 < '2' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."'  and  time1 < '2' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'   and  time1 < '2' and status='confirm' )x group by merchant_id ) as Totaljanfeea   ,
                          

 (SELECT sum(fee) as Totalfebfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm' )x group by merchant_id ) as Totalfebfeea   ,

 (SELECT sum(fee) as Totalmarchfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm' )x group by merchant_id ) as Totalmarchfeea   ,

 (SELECT sum(fee) as Totalaprlfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm' )x group by merchant_id ) as Totalaprlfeea   ,

 (SELECT sum(fee) as Totalmayfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm' )x group by merchant_id ) as Totalmayfeea   ,

 (SELECT sum(fee) as Totaljunefeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as Totaljunefeea   ,

 (SELECT sum(fee) as Totaljulyfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as Totaljulyfeea   ,

 (SELECT sum(fee) as Totalaugustfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as Totalaugustfeea   ,

 (SELECT sum(fee) as Totalsepfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as Totalsepfeea   ,

 (SELECT sum(fee) as Totaloctfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as Totaloctfeea   ,

 (SELECT sum(fee) as Totalnovfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as Totalnovfeea   ,

 (SELECT sum(fee) as Totaldecfeea from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by merchant_id ) as Totaldecfeea,




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


// $data['item'] = $this->admin_model->data_get_where_g("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));



$package_data = $this->admin_model->data_get_where("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));
  
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
      
      
      $package['amount'] = $each->amount;
      $package['tax'] = $each->tax; 
      $package['type'] = $each->type; 
      $package['date'] = $each->date_c; 
    
      
      $mem[] = $package;
    }
    $data['item'] = $mem;






         $data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("merchant_id" => $merchant_id ,"status"=>'confirm'));
         $data['item2'] = $this->admin_model->data_get_where_g("pos", array("merchant_id" => $merchant_id ));


         
      
     
     if($this->input->post('start')!=''){
        echo json_encode($data);
        die();
    }
    else
    {
     return $this->load->view('merchant/trend',$data);
    }
    
        
       
        
    }


      public function sale(){

            $data["title"] ="Merchant Panel";

            $merchant_id = $this->session->userdata('merchant_id');
            $today2 = date("Y");

            $last_year = date("Y",strtotime("-1 year"));

              $start = $this->input->post('start');
        $end = $this->input->post('end');

           //  $last_date1 = date("Y-m-d",strtotime("-29 days"));
           //$date1 = date("Y-m-d");
       if($start!='')
       {
        $last_date = $start;
           $date = $end;
       
       }
       else
       {
        $last_date = date("Y-m-d",strtotime("-29 days"));
           $date = date("Y-m-d");
       }


            $getDashboard = $this->db->query("SELECT 

              (SELECT sum(amount) as Totaljan from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 < '2' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 < '2' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 < '2' and status='confirm' )x group by merchant_id ) as Totaljan   ,

               (SELECT sum(amount) as Totalfeb from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' )x group by merchant_id ) as Totalfeb   ,

                 (SELECT sum(amount) as Totalmarch from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' )x group by merchant_id ) as Totalmarch   ,

                   (SELECT sum(amount) as Totalaprl from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' )x group by merchant_id ) as Totalaprl   ,

                   (SELECT sum(amount) as Totalmay from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' )x group by merchant_id ) as Totalmay   ,

                   (SELECT sum(amount) as Totaljune from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as Totaljune   ,

                    (SELECT sum(amount) as Totaljuly from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as Totaljuly   ,

           (SELECT sum(amount) as Totalaugust from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as Totalaugust   ,

           (SELECT sum(amount) as Totalsep from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as Totalsep   ,

         (SELECT sum(amount) as Totaloct from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as Totaloct   ,

           (SELECT sum(amount) as Totalnov from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as Totalnov   ,

         (SELECT sum(amount) as Totaldec from ( SELECT merchant_id,time1,amount from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT merchant_id,time1,amount from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT merchant_id,time1,amount from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by merchant_id ) as Totaldec   ,


         (SELECT sum(tax) as Totaljantax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and  time1 < '2' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and  time1 < '2' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."' and  time1 < '2' and status='confirm' )x group by merchant_id ) as Totaljantax   ,
                          

 (SELECT sum(tax) as Totalfebtax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm' )x group by merchant_id ) as Totalfebtax   ,

(SELECT sum(tax) as Totalmarchtax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm' )x group by merchant_id ) as Totalmarchtax   ,

 (SELECT sum(tax) as Totalaprltax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm' )x group by merchant_id ) as Totalaprltax   ,

(SELECT sum(tax) as Totalmaytax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm' )x group by merchant_id ) as Totalmaytax   ,

 (SELECT sum(tax) as Totaljunetax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as Totaljunetax   ,

(SELECT sum(tax) as Totaljulytax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as Totaljulytax   ,

 (SELECT sum(tax) as Totalaugusttax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as Totalaugusttax   ,

 (SELECT sum(tax) as Totalseptax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as Totalseptax   ,

 (SELECT sum(tax) as Totalocttax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as Totalocttax   ,

 (SELECT sum(tax) as Totalnovtax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as Totalnovtax   ,

 (SELECT sum(tax) as Totaldectax from ( SELECT merchant_id,time1,tax from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT merchant_id,time1,tax from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT merchant_id,time1,tax from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 <= '24' and status='confirm' )x group by merchant_id ) as Totaldectax   ,



(SELECT sum(fee) as Totaljanfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and  time1 < '2' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."'  and  time1 < '2' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'   and  time1 < '2' and status='confirm' )x group by merchant_id ) as Totaljanfee   ,
                          

 (SELECT sum(fee) as Totalfebfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '2' and  time1 < '4' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '2' and  time1 < '4' and status='confirm' )x group by merchant_id ) as Totalfebfee   ,

 (SELECT sum(fee) as Totalmarchfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '4' and  time1 < '6' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '4' and  time1 < '6' and status='confirm' )x group by merchant_id ) as Totalmarchfee   ,

 (SELECT sum(fee) as Totalaprlfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '6' and  time1 < '8' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '6' and  time1 < '8' and status='confirm' )x group by merchant_id ) as Totalaprlfee   ,

 (SELECT sum(fee) as Totalmayfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '8' and  time1 < '10' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '8' and  time1 < '10' and status='confirm' )x group by merchant_id ) as Totalmayfee   ,

 (SELECT sum(fee) as Totaljunefee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '10' and  time1 < '12' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '10' and  time1 < '12' and status='confirm' )x group by merchant_id ) as Totaljunefee   ,

 (SELECT sum(fee) as Totaljulyfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '12' and  time1 < '14' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '12' and  time1 < '14' and status='confirm' )x group by merchant_id ) as Totaljulyfee   ,

 (SELECT sum(fee) as Totalaugustfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '14' and  time1 < '16' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '14' and  time1 < '16' and status='confirm' )x group by merchant_id ) as Totalaugustfee   ,

 (SELECT sum(fee) as Totalsepfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '16' and  time1 < '18' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '16' and  time1 < '18' and status='confirm' )x group by merchant_id ) as Totalsepfee   ,

 (SELECT sum(fee) as Totaloctfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '18' and  time1 < '20' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '18' and  time1 < '20' and status='confirm' )x group by merchant_id ) as Totaloctfee   ,

 (SELECT sum(fee) as Totalnovfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '20' and  time1 < '22' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '20' and  time1 < '22' and status='confirm' )x group by merchant_id ) as Totalnovfee   ,

 (SELECT sum(fee) as Totaldecfee from ( SELECT merchant_id,time1,fee from customer_payment_request where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm'   union all SELECT merchant_id,time1,fee from recurring_payment where merchant_id = '".$merchant_id."'  and date_c <= '".$date."' and date_c > '".$last_date."' and time1 >= '22' and  time1 < '24' and status='confirm' union all SELECT merchant_id,time1,fee from pos where merchant_id = '".$merchant_id."' and date_c <= '".$date."' and date_c > '".$last_date."'  and time1 >= '22' and  time1 < '24' and status='confirm' )x group by merchant_id ) as Totaldecfee  
                          

             "); 

            $getDashboardData = $getDashboard->result_array();
            $data['getDashboardData'] = $getDashboardData; 


// $data['item'] = $this->admin_model->data_get_where_g("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));



$package_data = $this->admin_model->data_get_where("customer_payment_request", array("merchant_id" => $merchant_id ,"status"=>'confirm' ));
  
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
      
      
      $package['amount'] = $each->amount;
      $package['tax'] = $each->tax; 
      $package['type'] = $each->type; 
      $package['date'] = $each->date_c; 
    
      
      $mem[] = $package;
    }
    $data['item'] = $mem;






         $data['item1'] = $this->admin_model->data_get_where_g("recurring_payment", array("merchant_id" => $merchant_id ,"status"=>'confirm'));
         $data['item2'] = $this->admin_model->data_get_where_g("pos", array("merchant_id" => $merchant_id ));


         
      
     
     if($this->input->post('start')!=''){
        echo json_encode($data);
        die();
    }
    else
    {
     return $this->load->view('merchant/sale',$data);
    }
    
        
       
        
    }


  

}

?>
